<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  activity_get            Fetches details on an activity log.                                                      */
/*  activity_list           Fetches activity logs.                                                                   */
/*  activity_delete         Deletes an activity log.                                                                 */
/*  activity_restore        Restores a soft deleted activity log.                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Fetches details on an activity log.
 *
 * @param   int     $log_id   The id of the log on which details are desired.
 *
 * @return  array             An array of activity log details, prepared for displaying.
 */

function activity_get( int $log_id ) : array
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');

  // Sanitize and prepare the data
  $log_id   = sanitize($log_id, 'int', 0);
  $lang_raw = user_get_language();
  $lang     = sanitize(string_change_case($lang_raw, 'lowercase'), 'string');

  // Initialize the returned array
  $data         = array();
  $data['diff'] = '';

  // Fetch the justification reason
  $dlog = query(" SELECT  logs_activity.moderation_reason AS 'l_reason'
                  FROM    logs_activity
                  WHERE   logs_activity.id = '$log_id' ",
                  fetch_row: true);
  $data['reason'] = sanitize_output($dlog['l_reason']);

  // Fetch any diffs linked to the log
  $qdiff = query("  SELECT    logs_activity_details.content_description_$lang AS 'd_desc'   ,
                              logs_activity_details.content_before            AS 'd_before' ,
                              logs_activity_details.content_after             AS 'd_after'
                    FROM      logs_activity_details
                    WHERE     logs_activity_details.fk_logs_activity = '$log_id'
                    ORDER BY  logs_activity_details.id ASC ");

  // Go through the diffs (if any)
  while($ddiff = query_row($qdiff))
  {
    if(!$ddiff['d_desc'])
      $data['diff'] .= bbcodes(diff_strings(sanitize_output($ddiff['d_before'], 1), sanitize_output($ddiff['d_after'], 1))).'<br><br>';
    else
      $data['diff'] .= '<span class="bold underlined">'.sanitize_output($ddiff['d_desc']).' :</span> '.bbcodes(diff_strings(sanitize_output($ddiff['d_before'], 1), sanitize_output($ddiff['d_after'], 1))).'<br><br>';
  }

  // Return the prepared data
  return $data;
}




/**
 * Fetches activity logs.
 *
 * @param   bool    $show_mod_logs  (OPTIONAL)  If true, display moderation logs instead of global activity logs.
 * @param   int     $amount         (OPTIONAL)  The amount of logs to fetch.
 * @param   string  $type           (OPTIONAL)  Filters the output by only showing logs of a specific type.
 * @param   bool    $show_deleted   (OPTIONAL)  If true, shows deleted activity logs only.
 * @param   bool    $is_admin       (OPTIONAL)  Is the user seeing the logs an administrator.
 *
 * @return  array                           An array of activity logs, prepared for displaying.
 */

function activity_list( bool    $show_mod_logs  = false ,
                        int     $amount         = 100   ,
                        string  $type           = 'all' ,
                        bool    $show_deleted   = false ,
                        bool    $is_admin       = false ) : array
{
  // Require administrator rights to run this action in special cases
  if($is_admin)
    user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('activity.inc.php');

  // Sanitize the data
  $modlogs  = ($show_mod_logs);
  $amount   = sanitize($amount, 'int', 100);
  $type     = sanitize($type, 'string');
  $lang_raw = user_get_language();
  $lang     = sanitize($lang_raw, 'string');
  $deleted  = sanitize($show_deleted, 'int', 0, 1);

  // Only allow admins to see full activity logs or deleted activity items
  $amount  = (!$is_admin && $amount > 1000) ? 1000 : $amount;
  $deleted = (!$is_admin) ? 0 : $deleted;

  // Log type filter
  $search_type = ($type && $type !== "all") ? " AND logs_activity.activity_type LIKE '".$type."_%' " : "";

  // Show deleted logs on request
  $search_deleted = ($deleted) ? " AND logs_activity.is_deleted = 1 " : " AND logs_activity.is_deleted = 0 ";

  // Limit on the number of results
  $limit = ($amount <= 1000) ? " LIMIT $amount " : "";

  // Fetch activity logs
  $qlogs = query("    SELECT    logs_activity.id                          AS 'l_id'         ,
                                logs_activity.fk_users                    AS 'l_userid'     ,
                                logs_activity.happened_at                 AS 'l_date'       ,
                                logs_activity.activity_username           AS 'l_user'       ,
                                logs_activity.activity_moderator_username AS 'l_mod_user'   ,
                                logs_activity.activity_id                 AS 'l_actid'      ,
                                logs_activity.activity_type               AS 'l_type'       ,
                                logs_activity.activity_summary_en         AS 'l_summary_en' ,
                                logs_activity.activity_summary_fr         AS 'l_summary_fr' ,
                                logs_activity.activity_amount             AS 'l_amount'     ,
                                logs_activity.moderation_reason           AS 'l_reason'     ,
                                logs_activity_details.id                  AS 'l_details'
                      FROM      logs_activity
                      LEFT JOIN logs_activity_details ON logs_activity.id = logs_activity_details.fk_logs_activity
                      WHERE     logs_activity.is_moderators_only  =     '$modlogs'
                      AND       logs_activity.language            LIKE  '%$lang%'
                                $search_type
                                $search_deleted
                      GROUP BY  logs_activity.id
                      ORDER BY  logs_activity.happened_at DESC
                                $limit ");

  // Initialize the returned array
  $data = array();

  // Go through the rows of the query
  for($i = 0; $row = query_row($qlogs); $i++)
  {
    // Parse the activity log
    $parsed_row = logs_activity_parse($modlogs, $row['l_type'], $row['l_actid'], $row['l_summary_en'], $row['l_summary_fr'], $row['l_userid'], $row['l_user'], $row['l_mod_user'], $row['l_amount']);

    // Prepare the data
    $data[$i]['id']       = $row['l_id'];
    $data[$i]['date']     = sanitize_output(time_since($row['l_date']));
    $data[$i]['fulldate'] = sanitize_output(
                            date_to_text($row['l_date']).__('at_date', 1, 1, 1).date('H:i:s', $row['l_date']));
    $data[$i]['css']      = (!$deleted) ? sanitize_output($parsed_row['css']) : 'red text_light';
    $data[$i]['href']     = sanitize_output($parsed_row['href']);
    $data[$i]['text']     = (mb_strlen($parsed_row[$lang]) < 58)
                          ? sanitize_output($parsed_row[$lang])
                          : sanitize_output(string_truncate($parsed_row[$lang], 55, '...'));
    $data[$i]['fulltext'] = (mb_strlen($parsed_row[$lang]) < 58) ? '' : sanitize_output($parsed_row[$lang]);
    $data[$i]['details']  = ($row['l_reason'] || $row['l_details']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Deletes an activity log.
 *
 * @param   int   $log_id         The id of the log which will be deleted.
 * @param   bool  $deletion_type  Performs a soft (false) or hard (true) delete.
 *
 * @return  void
 */

function activity_delete( int   $log_id                 ,
                          bool  $deletion_type  = false ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

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

function activity_restore( int $log_id ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $log_id = sanitize($log_id, 'int', 0);

  // Restore the activity log
  query(" UPDATE  logs_activity
          SET     logs_activity.is_deleted  = 0
          WHERE   logs_activity.id          = '$log_id' ");
}