<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  stats_metrics_list          Lists data regarding website performance.                                            */
/*  stats_metrics_reset         Resets website metrics.                                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Lists data regarding website performance.
 *
 * @return  array     The metrics data, ready for displaying.
 */

function stats_metrics_list()
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Fetch the metrics
  $qmetrics = query(" SELECT    stats_pages.id              AS 's_id'       ,
                                stats_pages.page_name_en    AS 's_page_en'  ,
                                stats_pages.page_name_fr    AS 's_page_fr'  ,
                                stats_pages.page_url        AS 's_url'      ,
                                stats_pages.last_viewed_at  AS 's_activity' ,
                                stats_pages.view_count      AS 's_views'    ,
                                stats_pages.query_count     AS 's_queries'  ,
                                stats_pages.load_time       AS 's_load'
                      FROM      stats_pages
                      WHERE     stats_pages.query_count > 0
                      AND       stats_pages.load_time   > 0
                      ORDER BY  stats_pages.last_viewed_at DESC ");

  // Fetch the user's language
  $lang = user_get_language();

  // Initialize the counters
  $min_queries    = 0;
  $max_queries    = 0;
  $total_queries  = 0;
  $min_load       = 0;
  $max_load       = 0;
  $total_load     = 0;

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmetrics); $i++)
  {
    $data[$i]['id']         = sanitize_output($row['s_id']);
    $temp                   = ($lang == 'FR') ? $row['s_page_fr'] : $row['s_page_en'];
    $data[$i]['page']       = sanitize_output($temp);
    $data[$i]['url']        = sanitize_output(string_truncate($row['s_url'], 40, '...'));
    $data[$i]['url_full']   = (mb_strlen($row['s_url']) > 40) ? sanitize_output($row['s_url']) : '';
    $data[$i]['activity']   = sanitize_output(time_since($row['s_activity']));
    $data[$i]['views']      = number_display_format($row['s_views'], 'number');
    $data[$i]['queries']    = sanitize_output($row['s_queries']);
    $data[$i]['load']       = sanitize_output($row['s_load']);
    $min_queries            = (!$i || $row['s_queries'] < $min_queries) ? $row['s_queries'] : $min_queries;
    $max_queries            = ($row['s_queries'] > $max_queries) ? $row['s_queries'] : $max_queries;
    $total_queries         += $row['s_queries'];
    $min_load               = (!$i || $row['s_load'] < $min_load) ? $row['s_load'] : $min_load;
    $max_load               = ($row['s_load'] > $max_load) ? $row['s_load'] : $max_load;
    $total_load            += $row['s_load'];
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Calculate the reference metrics
  $average_queries  = ($data['rows']) ? round($total_queries / $data['rows']) : 0;
  $good_queries     = round($average_queries / 1.5);
  $bad_queries      = round($average_queries * 1.5);
  $awful_queries    = round($average_queries * 2);
  $average_load     = ($data['rows']) ? round($total_load / $data['rows']) : 0;
  $good_load        = round($average_load / 2);
  $bad_load         = round($average_load * 2);
  $awful_load       = round($average_load * 3);

  // Prepare the global metrics
  $data['min_queries']      = sanitize_output($min_queries);
  $data['good_queries']     = sanitize_output($good_queries);
  $data['average_queries']  = sanitize_output($average_queries);
  $data['bad_queries']      = sanitize_output($bad_queries);
  $data['awful_queries']    = sanitize_output($awful_queries);
  $data['max_queries']      = sanitize_output($max_queries);
  $data['min_load']         = sanitize_output(number_display_format($min_load, 'number')).'ms';
  $data['good_load']        = sanitize_output(number_display_format($good_load, 'number')).'ms';
  $data['average_load']     = sanitize_output(number_display_format($average_load, 'number')).'ms';
  $data['bad_load']         = sanitize_output(number_display_format($bad_load, 'number')).'ms';
  $data['awful_load']       = sanitize_output(number_display_format($awful_load, 'number')).'ms';
  $data['max_load']         = sanitize_output(number_display_format($max_load, 'number')).'ms';

  // Style the metrics based on the average
  for($i = 0; $i < $data['rows']; $i++)
  {
    $temp                     = ($data[$i]['queries'] <= $good_queries) ? 'green' : 'purple';
    $temp                     = ($data[$i]['queries'] <= $min_queries) ? 'blue' : $temp;
    $temp                     = ($data[$i]['queries'] >= $bad_queries) ? 'orange' : $temp;
    $temp                     = ($data[$i]['queries'] >= $awful_queries) ? 'red' : $temp;
    $temp                     = ($data[$i]['queries'] >= $max_queries) ? 'brown' : $temp;
    $data[$i]['css_queries']  = sanitize_output($temp);
    $temp                     = ($data[$i]['load'] <= $good_load) ? 'green' : 'purple';
    $temp                     = ($data[$i]['load'] <= $min_load) ? 'blue' : $temp;
    $temp                     = ($data[$i]['load'] >= $bad_load) ? 'orange' : $temp;
    $temp                     = ($data[$i]['load'] >= $awful_load) ? 'red' : $temp;
    $temp                     = ($data[$i]['load'] >= $max_load) ? 'brown' : $temp;
    $data[$i]['css_load']     = sanitize_output($temp);
    $data[$i]['load']         = sanitize_output(number_display_format($data[$i]['load'], 'number')).'ms';
  }

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'admin/stats.act.php', 'function' => 'stats_metrics_list', 'data' => $data));

  // Return the prepared data
  return $data;
}




/**
 * Resets website metrics.
 *
 * @param   int|null  $metric_id  The id of the metric to reset - all metrics will be reset if the id is 0.
 *
 * @return  void
 */

function stats_metrics_reset( $metric_id = NULL )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanatize the metric id
  $metric_id = sanitize($metric_id, 'int', -1);

  // Wipe a specific metric
  if($metric_id > 0)
    query(" UPDATE  stats_pages
            SET     stats_pages.query_count = 0 ,
                    stats_pages.load_time   = 0
            WHERE   stats_pages.id          = '$metric_id' ");

  // Wipe all metrics
  else if($metric_id == 0)
    query(" UPDATE  stats_pages
            SET     stats_pages.query_count = 0 ,
                    stats_pages.load_time   = 0 ");
}