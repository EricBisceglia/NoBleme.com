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
function schedule_task($action_type, $action_id, $action_planned_at, $action_description=NULL, $sanitize_data=0)
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

// This shouldn't run more than once every 15 seconds, to avoid a MySQL deadlock caused by the LOCK queue
$timestamp = time();

// Fetch the timestamp of the most recent scheduler execution
$dcheck_scheduler = mysqli_fetch_array(query("  SELECT  system_variables.last_scheduler_execution AS 'scheduler_last'
                                                FROM    system_variables "));

// If this timestamp is more than 15 seconds old, run the scheduler
if($dcheck_scheduler['scheduler_last'] < ($timestamp - 15))
{
  // Update the timestamp of the latest scheduler execution
  query(" UPDATE  system_variables
          SET     system_variables.last_scheduler_execution = '$timestamp' ");

  // Lock the table so that the action can not be ran twice
  query(" LOCK TABLES system_scheduler WRITE ");

  // Go check if any scheduled task is waiting to be ran
  $timestamp  = time();
  $qscheduler = query(" SELECT  system_scheduler.task_id          AS 't_id'   ,
                                system_scheduler.task_type        AS 't_type' ,
                                system_scheduler.task_description AS 't_desc'
                        FROM    system_scheduler
                        WHERE   system_scheduler.planned_at       <= '$timestamp' ");

  // Parse the list of potential tasks awaiting execution
  while($dscheduler = mysqli_fetch_array($qscheduler))
  {
    // Prepare data related to the task about to be ran
    $scheduler_action_id = $dscheduler['t_id'];
    $scheduler_type      = $dscheduler['t_type'];
    $scheduler_desc      = sanitize($dscheduler['t_desc'], 'string');
    $scheduler_desc_raw  = $dscheduler['t_desc'];




    //***************************************************************************************************************//
    //                                            WRITER'S CORNER CONTEST                                            //
    //***************************************************************************************************************//
    // Writing deadline, open voting

    if($scheduler_type == 'writers_contest_vote')
    {
      // Check whether the requested contest exists
      $dcheck_contest = mysqli_fetch_array(query("  SELECT  writings_contests.contest_name AS 'c_name'
                                                    FROM    writings_contests
                                                    WHERE   writings_contests.id = '$scheduler_action_id' "));

      // If it does exist, proceed
      if($dcheck_contest['c_name'])
      {
        // Create an entry in the recent activity
        $contest_title = sanitize($dcheck_contest['c_name'], 'string');
        log_activity('writers_contest_vote', 0, 'FR', 0, 0, $scheduler_action_id, $contest_title);

        // Announce on IRC that voting is open
        $contest_title_raw = $dcheck_contest['c_name'];
        ircbot($path, 'Fin de la participation au concours du coin des écrivains : '.$contest_title_raw.' - Les votes sont ouverts pendant 10 jours : '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$scheduler_action_id, '#NoBleme');
        ircbot($path, 'Fin de la participation au concours du coin des écrivains : '.$contest_title_raw.' - Les votes sont ouverts pendant 10 jours : '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$scheduler_action_id, '#write');

        // Schedule a task for the end of the contest (in 10 days at 22:00)
        $contest_end_date = strtotime(date('d-m-Y', strtotime("+10 days")).' 22:00:00');
        schedule_task('writers_contest_end', $scheduler_action_id, $contest_end_date);
      }
    }


    //***************************************************************************************************************//
    // Voting deadline, close the contest

    else if($scheduler_type == 'writers_contest_end')
    {
      // Check whether the requested contest exists
      $dcheck_contest = mysqli_fetch_array(query("  SELECT  writings_contests.contest_name AS 'c_name'
                                                    FROM    writings_contests
                                                    WHERE   writings_contests.id = '$scheduler_action_id' "));

      // If it exists, figure out who won the contest
      if($dcheck_contest['c_name'])
      {
        // Fetch all texts with the highest score, in a random order (in case of draw, a random winner will be picked)
        $qwritings = query("  SELECT    writings_texts.id AS 'w_id'
                              FROM      writings_texts
                              WHERE     writings_texts.fk_writings_contests = '$scheduler_action_id'
                              ORDER BY  RAND() ");

        // Prepare the variabes which will be used to pick the winner
        $writings_top_rating  = 0;
        $contest_winner_id    = 0;

        // Fetch the ratings of all writings in the contest
        while($dwritings = mysqli_fetch_array($qwritings))
        {
          $writing_id = $dwritings['w_id'];
          $dratings   = mysqli_fetch_array(query(" SELECT
                                                SUM(writings_contests_votes.vote_weight)     AS 'c_rating'
                                        FROM    writings_contests_votes
                                        WHERE   writings_contests_votes.fk_writings_contests  = '$scheduler_action_id'
                                        AND     writings_contests_votes.fk_writings_texts     = '$writing_id' "));

          // Check whether the parsed text is now leading in points
          if($dratings['c_rating'] > $writings_top_rating)
          {
            $writings_top_rating  = $dratings['c_rating'];
            $contest_winner_id    = $writing_id;
          }
        }

        // Now that a winner has been picked, update the contest
        query(" UPDATE  writings_contests
                SET     writings_contests.fk_writings_texts_winner  = '$contest_winner_id'
                WHERE   writings_contests.id                        = '$scheduler_action_id' ");

        // Fetch details about the winning writing
        $dwinner = mysqli_fetch_array(query(" SELECT    writings_texts.is_anonymous AS 'w_anon' ,
                                                        users.id                    AS 'u_id'   ,
                                                        users.nickname              AS 'u_nick'
                                              FROM      writings_texts
                                              LEFT JOIN users ON writings_texts.fk_users = users.id
                                              WHERE     writings_texts.id = '$contest_winner_id' "));

        // If the text isn't anonymous, update the contest by linking it to the winner
        if(!$dwinner['w_anon'])
        {
          $winner_id = $dwinner['u_id'];
          query(" UPDATE  writings_contests
                  SET     writings_contests.fk_users_winner = '$winner_id'
                  WHERE   writings_contests.id              = '$scheduler_action_id' ");
        }

        // Create an entry in recent activity
        $contest_title  = sanitize($dcheck_contest['c_name'], 'string');
        $contest_winner = ($dwinner['w_anon']) ? 'Un auteur anonyme' : sanitize($dwinner['u_nick'], 'string');
        log_activity('writers_contest_winner', 0, 'FR', 0, $contest_winner, $scheduler_action_id, $contest_title);

        // Announce the winner on IRC
        $contest_title_raw  = $dcheck_contest['c_name'];
        $contest_winner_raw = ($dwinner['w_anon']) ? 'Un auteur anonyme' : $dwinner['u_nick'];
        ircbot($path, $contest_winner_raw.' a gagné le concours du coin des écrivains  : '.$contest_title_raw.' - '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$scheduler_action_id, '#NoBleme');
        ircbot($path, $contest_winner_raw.' a gagné le concours du coin des écrivains  : '.$contest_title_raw.' - '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$scheduler_action_id, '#write');
      }
    }




    //***************************************************************************************************************//
    //                                      THE SCHEDULED TASK HAS BEEN TREATED                                      //
    //***************************************************************************************************************//
    // Delete the entry from the scheduler

    query(" DELETE FROM   system_scheduler
            WHERE         system_scheduler.id = '$scheduler_action_id' ");
  }

  // Now that every scheduled task has been treated, release the database lock so that normal activity can resume
  query(" UNLOCK TABLES ");
}