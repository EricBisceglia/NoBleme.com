<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   ACTIVITY LOGS                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Fetches activity logs.
 *
 * @param   bool|null   $modlogs  OPTIONAL  If set to 1, display moderation logs instead of global activity logs.
 * @param   int|null    $amount   OPTIONAL  The amount of logs to fetch.
 * @param   string|null $type     OPTIONAL  Filters the output by only showing logs of a specific type.
 * @param   bool|null   $deleted  OPTIONAL  If set, shows deleted activity logs only.
 * @param   bool|null   $is_admin OPTIONAL  Is the user seeing the logs an administrator.
 * @param   string|null $path     OPTIONAL  The path to the root of the website.
 * @param   string|null $lang     OPTIONAL  The language currently in use.
 *
 * @return  array                           An array of activity logs, prepared for displaying.
 */

function activity_get_logs( $modlogs  = 0           ,
                            $amount   = 100         ,
                            $type     = 'all'       ,
                            $deleted  = 0           ,
                            $is_admin = 0           ,
                            $path     = './../../'  ,
                            $lang     = 'EN'        )
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('activity.inc.php');

  // Sanitize the data
  $modlogs  = ($modlogs) ? 1 : 0;
  $amount   = sanitize($amount, 'int', 100);
  $type     = sanitize($type, 'string');
  $lang     = sanitize($lang, 'string');
  $deleted  = sanitize($deleted, 'int', 0, 1);

  // Only allow admins to see full activity logs or deleted activity items
  $amount  = (!$is_admin && $amount > 1000) ? 1000 : $amount;
  $deleted = (!$is_admin) ? 0 : $deleted;

  // Initialize the returned array
  $data = array();

  // Fetch activity logs
  $qlogs = "    SELECT    logs_activity.id                          AS 'l_id'         ,
                          logs_activity.fk_users                    AS 'l_userid'     ,
                          logs_activity.happened_at                 AS 'l_date'       ,
                          logs_activity.activity_nickname           AS 'l_user'       ,
                          logs_activity.activity_moderator_nickname AS 'l_mod_user'   ,
                          logs_activity.activity_id                 AS 'l_actid'      ,
                          logs_activity.activity_type               AS 'l_type'       ,
                          logs_activity.activity_summary_en         AS 'l_summary_en' ,
                          logs_activity.activity_summary_fr         AS 'l_summary_fr' ,
                          logs_activity.activity_amount             AS 'l_amount'     ,
                          logs_activity.moderation_reason           AS 'l_reason'     ,
                          logs_activity_details.id                  AS 'l_details'
                FROM      logs_activity
                LEFT JOIN logs_activity_details ON logs_activity.id = logs_activity_details.fk_logs_activity
                WHERE     logs_activity.is_moderators_only      = '$modlogs'
                AND       logs_activity.language             LIKE '%$lang%' ";

  // Filter by log type
  if($type == 'users')
    $qlogs .= " AND       logs_activity.activity_type LIKE 'users_%' ";
  else if($type == 'meetups')
    $qlogs .= " AND       logs_activity.activity_type LIKE 'meetups_%' ";
  else if($type == 'internet')
    $qlogs .= " AND       logs_activity.activity_type LIKE 'internet_%' ";
  else if($type == 'quotes')
    $qlogs .= " AND       logs_activity.activity_type LIKE 'quotes_%' ";
  else if($type == 'writers')
    $qlogs .= " AND       logs_activity.activity_type LIKE 'writings_%' ";
  else if($type == 'dev')
    $qlogs .= " AND       logs_activity.activity_type LIKE 'dev_%' ";

  // Show deleted logs on request
  if($deleted)
    $qlogs .= " AND       logs_activity.is_deleted = 1 ";
  else
    $qlogs .= " AND       logs_activity.is_deleted = 0 ";

  // Group and sort limit the results
  $qlogs .= "   GROUP BY  logs_activity.id
                ORDER BY  logs_activity.happened_at DESC ";

  // Limit the results
  if($amount <= 1000)
    $qlogs .= " LIMIT     $amount ";

  // Run the query
  $qlogs = query($qlogs);

  // Go through the rows of the query
  for($i = 0; $row = mysqli_fetch_array($qlogs); $i++)
  {
    // Parse the activity log
    $parsed_row = log_activity_parse($path, $modlogs, $row['l_type'], $row['l_actid'], $row['l_summary_en'], $row['l_summary_fr'], $row['l_userid'], $row['l_user'], $row['l_mod_user'], $row['l_amount']);

    // Prepare the data
    $data[$i]['id']       = $row['l_id'];
    $data[$i]['date']     = time_since($row['l_date']);
    $data[$i]['fulldate'] = date_to_text($row['l_date']).__('at_date', 1, 1, 1).date('H:i:s', $row['l_date']);
    $data[$i]['css']      = (!$deleted) ? $parsed_row['css'] : 'red text_light';
    $data[$i]['href']     = $parsed_row['href'];
    $data[$i]['text']     = (mb_strlen($parsed_row[$lang]) < 90) ? sanitize_output($parsed_row[$lang]) : sanitize_output(string_truncate($parsed_row[$lang], 85, '...'));
    $data[$i]['fulltext'] = (mb_strlen($parsed_row[$lang]) < 90) ? '' : sanitize_output($parsed_row[$lang]);
    $data[$i]['details']  = ($row['l_reason'] || $row['l_details']) ? 1 : 0;
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('nobleme.act.php', 'activity_get_logs', $data));

  // Return the prepared data
  return $data;
}




/**
 * Fetches details on an activity log.
 *
 * @param   int         $log_id   The id of the log on which details are desired.
 * @param   string|null $lang     The language currently being used.
 *
 * @return  array                 An array of activity log details, prepared for displaying.
 */

function activity_get_details(  $log_id         ,
                                $lang   = 'EN'  )
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');

  // Sanitize the data
  $log_id = sanitize($log_id, 'int', 0);
  $lang   = sanitize($lang, 'string');

  // Initialize the returned array
  $data         = array();
  $data['diff'] = '';

  // Fetch the justification reason
  $dlog = mysqli_fetch_array(query("  SELECT  logs_activity.moderation_reason AS 'l_reason'
                                      FROM    logs_activity
                                      WHERE   logs_activity.id = '$log_id' "));
  $data['reason'] = sanitize_output($dlog['l_reason']);

  // Fetch any diffs linked to the log
  $qdiff = query("  SELECT    logs_activity_details.content_description_$lang AS 'd_desc'   ,
                              logs_activity_details.content_before            AS 'd_before' ,
                              logs_activity_details.content_after             AS 'd_after'
                    FROM      logs_activity_details
                    WHERE     logs_activity_details.fk_logs_activity = '$log_id'
                    ORDER BY  logs_activity_details.id ASC ");

  // Go through the diffs (if any)
  while($ddiff = mysqli_fetch_array($qdiff))
  {
    if(!$ddiff['d_desc'])
      $data['diff'] .= bbcodes(diff_strings(sanitize_output($ddiff['d_before'], 1), sanitize_output($ddiff['d_after'], 1))).'<br><br>';
    else
      $data['diff'] .= '<span class="bold underlined">'.sanitize_output($ddiff['d_desc']).' :</span> '.bbcodes(diff_strings(sanitize_output($ddiff['d_before'], 1), sanitize_output($ddiff['d_after'], 1))).'<br><br>';
  }

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('nobleme.act.php', 'activity_get_details', $data));

  // Return the prepared data
  return $data;
}




/**
 * Deletes an activity log.
 *
 * @param   int       $log_id         The id of the log which will be deleted.
 * @param   bool|null $deletion_type  Performs a soft (0) or hard (1) delete.
 *
 * @return  void
 */

function activity_delete_log( $log_id             ,
                              $deletion_type = 0  )
{
  // Sanitize the data
  $log_id = sanitize($log_id, 'int', 0);

  // If requested, soft delete the activity log
  if(!$deletion_type)
    query(" UPDATE  logs_activity
            SET     logs_activity.is_deleted = 1
            WHERE   logs_activity.id      = '$log_id' ");

  // Otherwise, hard delete the activity log and any potential log details
  else
  {
    query(" DELETE FROM logs_activity
            WHERE       logs_activity.id = '$log_id' ");
    query(" DELETE FROM logs_activity_details
            WHERE       logs_activity_details.fk_logs_activity = '$log_id' ");
  }

  // Purge all existing orphan logs, just in case
  log_activity_purge_orphan_diffs();
}




/**
 * Restores a soft deleted activity log.
 *
 * @param   int   $log_id   The id of the log which will be restored.
 *
 * @return  void
 */

function activity_restore_log($log_id)
{
  // Sanitize the data
  $log_id = sanitize($log_id, 'int', 0);

  // Restore the activity log
  query(" UPDATE  logs_activity
          SET     logs_activity.is_deleted  = 0
          WHERE   logs_activity.id          = '$log_id' ");
}