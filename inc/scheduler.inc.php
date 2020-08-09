<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


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

/**
 * Schedules a task to be ran at a later date.
 *
 * All this function does is creating an entry in the `system_scheduler` table.
 *
 * @param   string      $action_type        A string identifying the task type, up to 40 characters long.
 * @param   int         $action_id          The id of the element which will be affected by the task.
 * @param   int         $action_planned_at  A timestamp of the time at which the task must be run.
 * @param   string|null $action_description A description of the task.
 * @param   int|null    $sanitize_data      If this has a value, then the data will be sanitized before insertion.
 */
function schedule_task( $action_type                ,
                        $action_id                  ,
                        $action_planned_at          ,
                        $action_description = NULL  ,
                        $sanitize_data      = 0     )
{
  // If sanitization is required, then do it
  if($sanitize_data)
  {
    $action_type        = sanitize($action_type, 'string');
    $action_id          = sanitize($action_id, 'int', 0);
    $action_timestamp   = sanitize($action_planned_at, 'int', time());
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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Processing of all the tasks ready to be ran

// This shouldn't run more than once every 15 seconds, to avoid conflict
$timestamp = time();

// Start a transaction to avoid deadlocks
query(" START TRANSACTION ");

// Fetch the timestamp of the most recent scheduler execution
$dcheck_scheduler = mysqli_fetch_array(query("  SELECT  system_variables.last_scheduler_execution AS 'scheduler_last'
                                                FROM    system_variables"));

// If the timestamp is less than 15 seconds old, end the transaction
if($dcheck_scheduler['scheduler_last'] >= ($timestamp - 15))
  query(" COMMIT ");

// Otherwise, run the scheduler
if($dcheck_scheduler['scheduler_last'] < ($timestamp - 15))
{
  // Update the timestamp of the latest scheduler execution
  query(" UPDATE  system_variables
          SET     system_variables.last_scheduler_execution = '$timestamp' ");

  // End the transaction
  query(" COMMIT ");

  // Go check if any scheduled task is waiting to be ran
  $timestamp  = time();
  $qscheduler = query(" SELECT  system_scheduler.id               AS 't_id'   ,
                                system_scheduler.task_id          AS 't_task' ,
                                system_scheduler.task_type        AS 't_type' ,
                                system_scheduler.task_description AS 't_desc'
                        FROM    system_scheduler
                        WHERE   system_scheduler.planned_at       <= '$timestamp' ");

  // Parse the list of potential tasks awaiting execution
  while($dscheduler = mysqli_fetch_array($qscheduler))
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

    if($scheduler_type == 'users_unban')
    {
      // Fetch data on the user
      $duser = mysqli_fetch_array(query(" SELECT  users.nickname        AS 'u_nick'   ,
                                                  users.is_banned_until AS 'u_banned'
                                          FROM    users
                                          WHERE   users.id = '$scheduler_action_id' "));

      // Only proceed if the user actually exists and is banned
      if($duser['u_banned'])
      {
        // Unban the user
        user_unban($scheduler_action_id);

        // Activity logs
        $banned_nickname = sanitize($duser['u_nick'], 'string');
        log_activity('users_unbanned', 0, 'ENFR', 0, NULL, NULL, 0, $scheduler_action_id, $banned_nickname);

        // Scheduler log
        $scheduler_log = "The user has been unbanned";
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