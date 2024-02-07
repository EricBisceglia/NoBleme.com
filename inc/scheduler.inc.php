<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//         Tasks are stored in the `system_scheduler` table and created through the schedule_task() function         //
//                 The execution of tasks is triggered by a cronjob, see README for how to set it up                 //
//                          The scheduler can also be ran manually on /pages/dev/scheduler                           //
//                                                                                                                   //
//                     Scheduled tasks are single use: one they finish running, they get deleted                     //
//                                                                                                                   //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Process the tasks ready to be ran

// Check if any scheduled task is awaiting execution
$timestamp  = sanitize(time(), 'int', 0);
$qscheduler = query(" SELECT  system_scheduler.id               AS 't_id'   ,
                              system_scheduler.task_id          AS 't_task' ,
                              system_scheduler.task_type        AS 't_type' ,
                              system_scheduler.task_description AS 't_desc'
                      FROM    system_scheduler
                      WHERE   system_scheduler.planned_at       <= '$timestamp' " ,
                      description: "Check for scheduled tasks awaiting execution" );

// Parse the list of tasks awaiting execution
while($dscheduler = query_row($qscheduler))
{
  // Prepare data related to the task about to be ran
  $scheduler_id         = sanitize($dscheduler['t_id'], 'int', 0);
  $scheduler_action_id  = sanitize($dscheduler['t_task'], 'int', 0);
  $scheduler_type       = sanitize($dscheduler['t_type'], 'string');
  $scheduler_desc       = sanitize($dscheduler['t_desc'], 'string');
  $scheduler_desc_raw   = $dscheduler['t_desc'];
  $scheduler_log        = "";




  //*****************************************************************************************************************//
  //                                                      USERS                                                      //
  //*****************************************************************************************************************//
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




  //*****************************************************************************************************************//
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




  //*****************************************************************************************************************//
  //                                                     MEETUPS                                                     //
  //*****************************************************************************************************************//
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




  //*****************************************************************************************************************//
  //                                                  EXECUTION LOG                                                  //
  //*****************************************************************************************************************//
  // Archive the task once it has been ran

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




//*******************************************************************************************************************//
//                                                    MAINTENANCE                                                    //
//*******************************************************************************************************************//
// Confirm that the scheduler ran properly

// Insert a maintenance scheduler log confirming proper execution
$timestamp = sanitize(time(), 'int', 0);
query(" INSERT INTO logs_scheduler
        SET         logs_scheduler.happened_at      = '$timestamp'  ,
                    logs_scheduler.task_type        = 'maintenance' ");


// Find older scheduler maintenance logs
$qmaintenance = query(" SELECT      logs_scheduler.id AS 'ls_id'
                        FROM        logs_scheduler
                        WHERE       logs_scheduler.task_type LIKE 'maintenance'
                        ORDER BY    logs_scheduler.happened_at DESC ");

// Delete unnecessary old maintenance logs
for($i = 0; $dmaintenance = query_row($qmaintenance); $i++)
{
  // Keep the 5 most recent logs
  if($i >= 5)
  {
    // Delete older logs
    $dlog_id = sanitize($dmaintenance['ls_id'], 'int', 0);
    query(" DELETE FROM logs_scheduler
            WHERE       logs_scheduler.id = '$dlog_id' ");
  }
}