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
 * @param   string|null   $sort_by  (OPTIONAL)  The order in which the returned data will be sorted.
 * @param   array|null    $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                               The metrics data, ready for displaying.
 */

function stats_metrics_list(  $sort_by  = 'activity'  ,
                              $search   = NULL        )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Sanitize the search parameters
  $search_url     = isset($search['url'])     ? sanitize($search['url'], 'string')        : NULL;
  $search_queries = isset($search['queries']) ? sanitize($search['queries'], 'int', 0, 5) : NULL;
  $search_load    = isset($search['load'])    ? sanitize($search['load'], 'int', 0, 5)    : NULL;

  // Prepare the query to fetch the metrics
  $qmetrics = "   SELECT    stats_pages.id              AS 's_id'       ,
                            stats_pages.page_url        AS 's_url'      ,
                            stats_pages.last_viewed_at  AS 's_activity' ,
                            stats_pages.view_count      AS 's_views'    ,
                            stats_pages.query_count     AS 's_queries'  ,
                            stats_pages.load_time       AS 's_load'
                   FROM     stats_pages
                   WHERE    stats_pages.query_count     > 0
                   AND      stats_pages.load_time       > 0 ";

  // Search for data if requested
  if($search_url)
    $qmetrics .= " AND      stats_pages.page_url        LIKE '%$search_url%' ";

  // Sort the data as requested
  if($sort_by == 'url')
    $qmetrics .= " ORDER BY stats_pages.page_url        ASC   ";
  else if($sort_by == 'views')
    $qmetrics .= " ORDER BY stats_pages.view_count      DESC  ";
  else if($sort_by == 'queries')
    $qmetrics .= " ORDER BY stats_pages.query_count     DESC  ";
  else if($sort_by == 'load')
    $qmetrics .= " ORDER BY stats_pages.load_time       DESC  ";
  else
    $qmetrics .= " ORDER BY stats_pages.last_viewed_at  DESC  ";

  // Execute the query
  $qmetrics = query($qmetrics);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmetrics); $i++)
  {
    $data[$i]['id']       = sanitize_output($row['s_id']);
    $data[$i]['url']      = sanitize_output(string_truncate($row['s_url'], 40, '...'));
    $data[$i]['url_full'] = (mb_strlen($row['s_url']) > 40) ? sanitize_output($row['s_url']) : '';
    $data[$i]['activity'] = sanitize_output(time_since($row['s_activity']));
    $data[$i]['views']    = number_display_format($row['s_views'], 'number');
    $data[$i]['queries']  = sanitize_output($row['s_queries']);
    $data[$i]['load']     = sanitize_output($row['s_load']);
  }

  // Add the number of rows to the data
  $data['rows']     = $i;
  $data['realrows'] = $i;

  // Run the query once again without search parameters to get the global metrics
  $qmetrics = query(" SELECT    stats_pages.id              AS 's_id'       ,
                                stats_pages.page_url        AS 's_url'      ,
                                stats_pages.last_viewed_at  AS 's_activity' ,
                                stats_pages.view_count      AS 's_views'    ,
                                stats_pages.query_count     AS 's_queries'  ,
                                stats_pages.load_time       AS 's_load'
                      FROM      stats_pages
                      WHERE     stats_pages.query_count     > 0
                      AND       stats_pages.load_time       > 0  ");

  // Initialize the counters
  $min_queries    = 0;
  $max_queries    = 0;
  $total_queries  = 0;
  $min_load       = 0;
  $max_load       = 0;
  $total_load     = 0;

  // Loop through the results to get the global metrics
  for($pagestats = 0; $dmetrics = mysqli_fetch_array($qmetrics); $pagestats++)
  {
    $min_queries     = (!$pagestats || $dmetrics['s_queries'] < $min_queries) ? $dmetrics['s_queries'] : $min_queries;
    $max_queries     = ($dmetrics['s_queries'] > $max_queries) ? $dmetrics['s_queries'] : $max_queries;
    $total_queries  += $dmetrics['s_queries'];
    $min_load        = (!$pagestats || $dmetrics['s_load'] < $min_load) ? $dmetrics['s_load'] : $min_load;
    $max_load        = ($dmetrics['s_load'] > $max_load) ? $dmetrics['s_load'] : $max_load;
    $total_load     += $dmetrics['s_load'];
  }

  // Calculate the reference metrics
  $average_queries  = ($pagestats) ? round($total_queries / $pagestats) : 0;
  $good_queries     = round($average_queries / 1.5);
  $good_queries     = ($good_queries < $min_queries) ? $min_queries : $good_queries;
  $bad_queries      = round($average_queries * 1.5);
  $bad_queries      = ($bad_queries > $max_queries) ? $max_queries : $bad_queries;
  $awful_queries    = round($average_queries * 2);
  $awful_queries    = ($awful_queries > $max_queries) ? $max_queries : $awful_queries;
  $average_load     = ($pagestats) ? round($total_load / $pagestats) : 0;
  $good_load        = round($average_load / 2);
  $good_load        = ($good_load < $min_load) ? $min_load : $good_load;
  $bad_load         = round($average_load * 2);
  $bad_load         = ($bad_load > $max_load) ? $max_load : $bad_load;
  $awful_load       = round($average_load * 3);
  $awful_load       = ($awful_load > $max_load) ? $max_load : $awful_load;

  // Prepare the global metrics
  $data['totalrows']        = $pagestats;
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

  // Loop once again through the metrics to work with the new data
  for($i = 0; $i < $data['rows']; $i++)
  {
    // Remove unwanted metrics when searching for specific performances
    $temp                     = ($search_queries == 1 && $data[$i]['queries'] > $min_queries)   ? 1 : 0;
    $temp                     = ($search_queries == 2 && $data[$i]['queries'] > $good_queries)  ? 1 : $temp;
    $temp                     = ($search_queries == 3 && $data[$i]['queries'] < $bad_queries)   ? 1 : $temp;
    $temp                     = ($search_queries == 4 && $data[$i]['queries'] < $awful_queries) ? 1 : $temp;
    $temp                     = ($search_queries == 5 && $data[$i]['queries'] < $max_queries)   ? 1 : $temp;
    $temp                     = ($search_load == 1 && $data[$i]['load'] > $min_load)            ? 1 : $temp;
    $temp                     = ($search_load == 2 && $data[$i]['load'] > $good_load)           ? 1 : $temp;
    $temp                     = ($search_load == 3 && $data[$i]['load'] < $bad_load)            ? 1 : $temp;
    $temp                     = ($search_load == 4 && $data[$i]['load'] < $awful_load)          ? 1 : $temp;
    $data[$i]['skip']         = ($search_load == 5 && $data[$i]['load'] < $max_load)            ? 1 : $temp;
    $data['realrows']         = ($data[$i]['skip']) ? ($data['realrows'] - 1) : $data['realrows'];

    // Style the metrics based on their performance
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