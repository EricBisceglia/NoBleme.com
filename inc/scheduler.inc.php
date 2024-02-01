<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//               The goal of this page is to simulate a crontab without having to actually set one up                //
//  I just like the idea of having all the website logic in the source code and requiring no extra install process   //
//                                                                                                                   //
//        The tasks are stored in the `system_scheduler` table and added through the schedule_task() function        //
//  Tasks are triggered by guests or users visiting the website, so if you don't have traffic tasks will never run   //
//                                                                                                                   //
//                          Tasks are single use: one they finish running, they get deleted                          //
//         Recurring tasks (cron style) can be set up by creating a new task whenever a specific task is ran         //
//                                                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*                                                                                                                   */
/*  schedule_task             Schedules a task to be ran at a later date.                                            */
/*  schedule_task_update      Update an existing scheduled task.                                                     */
/*  schedule_task_delete      Delete an existing scheduled task.                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Schedules a task to be ran at a later date.
 *
 * All this function does is creating an entry in the `system_scheduler` table.
 *
 * @param   string  $action_type                      A string identifying the task type, up to 40 characters long.
 * @param   int     $action_id                        The id of the element which will be affected by the task.
 * @param   int     $action_planned_at                A timestamp of the time at which the task must be run.
 * @param   string  $action_description   (OPTIONAL)  A description of the task.
 * @param   bool    $sanitize_data        (OPTIONAL)  If set, the data will be sanitized before insertion.
 *
 * @return  void
 */
function schedule_task( string  $action_type                ,
                        int     $action_id                  ,
                        int     $action_planned_at          ,
                        string  $action_description = ''    ,
                        bool    $sanitize_data      = false ) : void
{
  // If sanitization is required, then do it
  if($sanitize_data)
  {
    $action_type        = sanitize($action_type, 'string');
    $action_id          = sanitize($action_id, 'int', 0);
    $action_planned_at  = sanitize($action_planned_at, 'int', time());
    $action_description = sanitize($action_description, 'string');
  }

  // If the task already exists, delete it
  query(" DELETE FROM system_scheduler
          WHERE       system_scheduler.task_id    =     '$action_id'
          AND         system_scheduler.task_type  LIKE  '$action_type' ");

  // Create the new task in the scheduler
  query(" INSERT INTO system_scheduler
          SET         system_scheduler.task_id          = '$action_id'          ,
                      system_scheduler.task_type        = '$action_type'        ,
                      system_scheduler.task_description = '$action_description' ,
                      system_scheduler.planned_at       = '$action_planned_at'  ");
}




/**
 * Update an existing scheduled task.
 *
 * @param   string  $action_type                      A string identifying the task type, up to 40 characters long.
 * @param   int     $action_id                        The id of the element which will be affected by the task.
 * @param   int     $action_planned_at    (OPTIONAL)  If set, the new time at which the action will be run.
 * @param   string  $action_description   (OPTIONAL)  If set, the new task description.
 * @param   bool    $sanitize_data        (OPTIONAL)  If set, data will be sanitized before insertion.
 *
 * @return  void
 */
function schedule_task_update(  string  $action_type                ,
                                int     $action_id                  ,
                                int     $action_planned_at  = 0     ,
                                string  $action_description = ''    ,
                                bool    $sanitize_data      = false ) : void
{
  // If sanitization is required, then do it
  if($sanitize_data)
  {
    $action_type        = sanitize($action_type, 'string');
    $action_id          = sanitize($action_id, 'int', 0);
    $action_planned_at  = sanitize($action_planned_at, 'int', time());
    $action_description = sanitize($action_description, 'string');
  }

  // Prepare the required updates
  $query = "";
  if($action_description)
    $query .= " system_scheduler.task_description = '$action_description' ";
  if($action_description && $action_planned_at)
    $query .= " , ";
  if($action_planned_at)
    $query .= " system_scheduler.planned_at = '$action_planned_at' ";

  // Update the existing task
  query(" UPDATE  system_scheduler
          SET     $query
          WHERE   system_scheduler.task_id    =     '$action_id'
          AND     system_scheduler.task_type  LIKE  '$action_type' ");
}




/**
 * Delete an existing scheduled task.
 *
 * @param   string  $action_type  A string identifying the task type, up to 40 characters long.
 * @param   int     $action_id    The id of the element which would have been affected if not deleted.
 *
 * @return  void
 */
function schedule_task_delete(  string  $action_type  ,
                                int     $action_id    ) : void
{
  // Sanitize the data
  $action_type  = sanitize($action_type, 'string');
  $action_id    = sanitize($action_id, 'int', 0);

  // Delete the task
  query(" DELETE FROM system_scheduler
          WHERE       system_scheduler.task_id    =     '$action_id'
          AND         system_scheduler.task_type  LIKE  '$action_type' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Processing of all the tasks ready to be ran

// This shouldn't run more than once every 15 seconds, to avoid conflict
$timestamp = time();

// Start a transaction to avoid deadlocks
query(" START TRANSACTION ", description: "Initialize the scheduler's transaction");

// Fetch the timestamp of the most recent scheduler execution
$dcheck_scheduler = query(" SELECT  system_variables.last_scheduler_execution AS 'scheduler_last'
                            FROM    system_variables " ,
                            fetch_row: true,
                            description: "Check whether the scheduler needs to run");

// If the timestamp is less than 15 seconds old, end the transaction
if($dcheck_scheduler['scheduler_last'] >= ($timestamp - 15))
  query(" COMMIT ", description: "End the scheduler's transaction");

// Otherwise, run the scheduler
if($dcheck_scheduler['scheduler_last'] < ($timestamp - 15))
{
  // Update the timestamp of the latest scheduler execution
  query(" UPDATE  system_variables
          SET     system_variables.last_scheduler_execution = '$timestamp' " ,
          description: "Update the scheduler's last execution time");

  // End the transaction
  query(" COMMIT ", description: "End the scheduler's transaction");

  // Go check if any scheduled task is waiting to be ran
  $timestamp  = time();
  $qscheduler = query(" SELECT  system_scheduler.id               AS 't_id'   ,
                                system_scheduler.task_id          AS 't_task' ,
                                system_scheduler.task_type        AS 't_type' ,
                                system_scheduler.task_description AS 't_desc'
                        FROM    system_scheduler
                        WHERE   system_scheduler.planned_at       <= '$timestamp' " ,
                        description: "Check for scheduled tasks awaiting execution" );

  // Parse the list of potential tasks awaiting execution
  while($dscheduler = query_row($qscheduler))
  {
    // Prepare data related to the task about to be ran
    $scheduler_id         = sanitize($dscheduler['t_id'], 'int', 0);
    $scheduler_action_id  = sanitize($dscheduler['t_task'], 'int', 0);
    $scheduler_type       = sanitize($dscheduler['t_type'], 'string');
    $scheduler_desc       = sanitize($dscheduler['t_desc'], 'string');
    $scheduler_desc_raw   = $dscheduler['t_desc'];
    $scheduler_log        = "";




    //***************************************************************************************************************//
    //                                                     USERS                                                     //
    //***************************************************************************************************************//
    // End a ban after it has expired

    if($scheduler_type === 'users_unban')
    {
      // Fetch data on the user
      $duser = query("  SELECT  users.username        AS 'u_nick'   ,
                                users.is_banned_until AS 'u_banned'
                        FROM    users
                        WHERE   users.id = '$scheduler_action_id' ",
                        fetch_row: true);

      // Only proceed if the user actually exists and is banned
      if($duser['u_banned'])
      {
        // Unban the user
        user_unban($scheduler_action_id);

        // Activity logs
        $banned_username = sanitize($duser['u_nick'], 'string');
        log_activity( 'users_unbanned'                        ,
                      fk_users:         $scheduler_action_id  ,
                      username:         $banned_username      );

        // Ban logs
        query(" UPDATE    logs_bans
                SET       logs_bans.fk_unbanned_by_user = 0 ,
                          logs_bans.unbanned_at         = '$timestamp'
                WHERE     logs_bans.fk_banned_user      = '$scheduler_action_id'
                AND       logs_bans.unbanned_at         = 0
                ORDER BY  logs_bans.banned_until        DESC
                LIMIT     1 ");

        // Scheduler log
        $scheduler_log = "The user has been unbanned";
      }
    }




    //***************************************************************************************************************//
    // End an IP ban after it has expired

    else if($scheduler_type === 'users_unban_ip')
    {
      // Only proceed if the IP ban actually exists
      if(database_row_exists('system_ip_bans', $scheduler_action_id))
      {
        // Remove the IP ban
        query(" DELETE FROM system_ip_bans
                WHERE       system_ip_bans.id = '$scheduler_action_id' ");

        // Activity logs
        log_activity( 'users_unbanned_ip'                       ,
                      is_moderators_only: 1                     ,
                      activity_id:        $scheduler_action_id  ,
                      username:           $scheduler_desc_raw   );

        // Ban logs
        query(" UPDATE    logs_bans
                SET       logs_bans.fk_unbanned_by_user =     0 ,
                          logs_bans.unbanned_at         =     '$timestamp'
                WHERE     logs_bans.banned_ip_address   LIKE  '$scheduler_desc'
                AND       logs_bans.unbanned_at         =     0
                ORDER BY  logs_bans.banned_until        DESC
                LIMIT     1 ");

        // Scheduler log
        $scheduler_log = "The IP address has been unbanned";
      }
    }




    //***************************************************************************************************************//
    //                                                    MEETUPS                                                    //
    //***************************************************************************************************************//
    // Recalculate a meetup's stats once it's over

    else if($scheduler_type === 'meetups_end')
    {
      // Only proceed if the meetup actually exists
      if(database_row_exists('meetups', $scheduler_action_id))
      {
        // Include meetup related actions
        include_once $path.'./actions/meetups.act.php';

        // Fetch all users that took part in the meetup
        $qmeetups = query(" SELECT  meetups_people.fk_users AS 'mp_uid'
                            FROM    meetups_people
                            WHERE   meetups_people.fk_meetups = '$scheduler_action_id'
                            AND     meetups_people.fk_users   > 0 ");

        // Update the meetup stats of each user
        while($dmeetup = query_row($qmeetups))
          meetups_stats_recalculate_user($dmeetup['mp_uid']);
      }
    }




    //***************************************************************************************************************//
    //                                      THE SCHEDULED TASK HAS BEEN TREATED                                      //
    //***************************************************************************************************************//
    // Archive the task

    // Delete the entry from the scheduler
    query(" DELETE FROM   system_scheduler
            WHERE         system_scheduler.id = '$scheduler_id' ");

    // Create a scheduler execution log
    query(" INSERT INTO logs_scheduler
            SET         logs_scheduler.happened_at      = '$timestamp'            ,
                        logs_scheduler.task_id          = '$scheduler_action_id'  ,
                        logs_scheduler.task_type        = '$scheduler_type'       ,
                        logs_scheduler.task_description = '$scheduler_desc'       ,
                        logs_scheduler.execution_report = '$scheduler_log'        ");
  }
}