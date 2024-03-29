<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  stats_metrics_list          Lists data regarding website performance.                                            */
/*  stats_metrics_reset         Resets website metrics.                                                              */
/*                                                                                                                   */
/*  stats_views_list            Lists data regarding pageviews.                                                      */
/*  stats_views_reset           Resets the pageview comparison data.                                                 */
/*  stats_views_delete          Deletes a page's data.                                                               */
/*                                                                                                                   */
/*  stats_users_list            Lists data regarding registered users.                                               */
/*  stats_guests_list           Lists data regarding non registered users.                                           */
/*                                                                                                                   */
/*  stats_doppelgangers_list    Lists users sharing the same IP address.                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Lists data regarding website performance.
 *
 * @param   string  $sort_by  (OPTIONAL)  The order in which the returned data will be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         The metrics data, ready for displaying.
 */

function stats_metrics_list(  string  $sort_by  = 'activity'  ,
                              array   $search   = array()     ) : array
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Sanitize the search parameters
  $search_url     = sanitize_array_element($search, 'url', 'string');
  $search_queries = sanitize_array_element($search, 'queries', 'int', min: 0, max: 5, default: 0);
  $search_load    = sanitize_array_element($search, 'load', 'int', min: 0, max: 5, default: 0);

  // Search through the data
  $query_search = ($search_url) ? " AND stats_pages.page_url LIKE '%$search_url%' " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'url'     => " ORDER BY stats_pages.page_url        ASC   " ,
    'views'   => " ORDER BY stats_pages.view_count      DESC  " ,
    'queries' => " ORDER BY stats_pages.query_count     DESC  " ,
    'load'    => " ORDER BY stats_pages.load_time       DESC  " ,
    default   => " ORDER BY stats_pages.last_viewed_at  DESC  " ,
  };

  // Prepare the query to fetch the metrics
  $qmetrics = query(" SELECT    stats_pages.id              AS 's_id'       ,
                                stats_pages.page_url        AS 's_url'      ,
                                stats_pages.last_viewed_at  AS 's_activity' ,
                                stats_pages.view_count      AS 's_views'    ,
                                stats_pages.query_count     AS 's_queries'  ,
                                stats_pages.load_time       AS 's_load'
                      FROM     stats_pages
                      WHERE    stats_pages.query_count     > 0
                      AND      stats_pages.load_time       > 0
                                $query_search
                                $query_sort ");

  // Prepare the data
  for($i = 0; $row = query_row($qmetrics); $i++)
  {
    $data[$i]['id']       = sanitize_output($row['s_id']);
    $data[$i]['url']      = sanitize_output(string_truncate($row['s_url'], 30, '...'));
    $data[$i]['url_full'] = (mb_strlen($row['s_url']) > 30) ? sanitize_output($row['s_url']) : '';
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
  for($pagestats = 0; $dmetrics = query_row($qmetrics); $pagestats++)
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
    $unwanted_metrics = ($search_queries === 1 && $data[$i]['queries'] > $min_queries)    ? 1 : 0;
    $unwanted_metrics = ($search_queries === 2 && $data[$i]['queries'] > $good_queries)   ? 1 : $unwanted_metrics;
    $unwanted_metrics = ($search_queries === 3 && $data[$i]['queries'] < $bad_queries)    ? 1 : $unwanted_metrics;
    $unwanted_metrics = ($search_queries === 4 && $data[$i]['queries'] < $awful_queries)  ? 1 : $unwanted_metrics;
    $unwanted_metrics = ($search_queries === 5 && $data[$i]['queries'] < $max_queries)    ? 1 : $unwanted_metrics;
    $unwanted_metrics = ($search_load === 1 && $data[$i]['load'] > $min_load)             ? 1 : $unwanted_metrics;
    $unwanted_metrics = ($search_load === 2 && $data[$i]['load'] > $good_load)            ? 1 : $unwanted_metrics;
    $unwanted_metrics = ($search_load === 3 && $data[$i]['load'] < $bad_load)             ? 1 : $unwanted_metrics;
    $unwanted_metrics = ($search_load === 4 && $data[$i]['load'] < $awful_load)           ? 1 : $unwanted_metrics;
    $data[$i]['skip'] = ($search_load === 5 && $data[$i]['load'] < $max_load)             ? 1 : $unwanted_metrics;
    $data['realrows'] = ($data[$i]['skip']) ? ($data['realrows'] - 1) : $data['realrows'];

    // Style the metrics based on their performance
    $metrics_css              = ($data[$i]['queries'] <= $good_queries) ? 'green' : 'purple';
    $metrics_css              = ($data[$i]['queries'] <= $min_queries) ? 'blue' : $metrics_css;
    $metrics_css              = ($data[$i]['queries'] >= $bad_queries) ? 'orange' : $metrics_css;
    $metrics_css              = ($data[$i]['queries'] >= $awful_queries) ? 'red' : $metrics_css;
    $metrics_css              = ($data[$i]['queries'] >= $max_queries) ? 'brown' : $metrics_css;
    $data[$i]['css_queries']  = sanitize_output($metrics_css);
    $metrics_css              = ($data[$i]['load'] <= $good_load) ? 'green' : 'purple';
    $metrics_css              = ($data[$i]['load'] <= $min_load) ? 'blue' : $metrics_css;
    $metrics_css              = ($data[$i]['load'] >= $bad_load) ? 'orange' : $metrics_css;
    $metrics_css              = ($data[$i]['load'] >= $awful_load) ? 'red' : $metrics_css;
    $metrics_css              = ($data[$i]['load'] >= $max_load) ? 'brown' : $metrics_css;
    $data[$i]['css_load']     = sanitize_output($metrics_css);
    $data[$i]['load']         = sanitize_output(number_display_format($data[$i]['load'], 'number')).'ms';
  }

  // Return the prepared data
  return $data;
}




/**
 * Resets website metrics.
 *
 * @param   int   $metric_id  (OPTIONAL)  The id of the metric to reset - all metrics will be reset if the id is 0.
 *
 * @return  void
 */

function stats_metrics_reset( int $metric_id = NULL ) : void
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
  else if($metric_id === 0)
    query(" UPDATE  stats_pages
            SET     stats_pages.query_count = 0 ,
                    stats_pages.load_time   = 0 ");
}




/**
 * Lists data regarding pageviews.
 *
 * @param   string  $sort_by  (OPTIONAL)  The order in which the returned data will be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         The pageviews data, ready for displaying.
 */

function stats_views_list(  string  $sort_by  = NULL    ,
                            array   $search   = array() ) : array
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');
  require_included_file('functions_mathematics.inc.php');
  require_included_file('stats.lang.php');

  // Fetch the current user's language
  $lang           = user_get_language();
  $lang_lowercase = sanitize(string_change_case($lang, 'lowercase'), 'string');

  // Sanitize the search parameters
  $search_name = sanitize_array_element($search, 'name', 'string');

  // Search through the data
  $query_search = ($search_name) ? "  WHERE ( stats_pages.page_url                  LIKE '%$search_name%'
                                      OR      stats_pages.page_name_$lang_lowercase LIKE '%$search_name%' ) " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'url'       => " ORDER BY stats_pages.page_url                  ASC   " ,
    'name'      => " ORDER BY stats_pages.page_name_$lang_lowercase ASC   " ,
    'oldviews'  => " ORDER BY stats_pages.view_count_archive        DESC  ,
                              stats_pages.view_count                DESC  ,
                              stats_pages.last_viewed_at            DESC  " ,
    'activity'  => " ORDER BY stats_pages.last_viewed_at            DESC  " ,
    'ractivity' => " ORDER BY stats_pages.last_viewed_at            ASC   " ,
    'uactivity' => " ORDER BY stats_pages.last_viewed_at            ASC   " ,
    default     => " ORDER BY stats_pages.view_count                DESC  ,
                              stats_pages.view_count_archive        DESC  ,
                              stats_pages.last_viewed_at            DESC  " ,
  };

  // Prepare the query to fetch the views
  $qviews = query(" SELECT    stats_pages.id                  AS 'p_id'       ,
                              stats_pages.page_name_en        AS 'p_name_en'  ,
                              stats_pages.page_name_fr        AS 'p_name_fr'  ,
                              stats_pages.page_url            AS 'p_url'      ,
                              stats_pages.last_viewed_at      AS 'p_activity' ,
                              stats_pages.view_count          AS 'p_views'    ,
                              stats_pages.view_count_archive  AS 'p_oldviews'
                    FROM      stats_pages
                              $query_search
                              $query_sort ");

  // Prepare the data
  for($i = 0; $row = query_row($qviews); $i++)
  {
    $data[$i]['id']       = sanitize_output($row['p_id']);
    $page_name            = ($lang === 'EN') ? $row['p_name_en'] : $row['p_name_fr'];
    $page_name            = (in_array($sort_by, array('url', 'uactivity'))) ? $row['p_url'] : $page_name;
    $data[$i]['name']     = ($page_name) ? sanitize_output(string_truncate($page_name, 40, '...')) : '-';
    $data[$i]['fullname'] = (mb_strlen($page_name) > 40) ? sanitize_output($page_name) : NULL;
    $data[$i]['url']      = sanitize_output($row['p_url']);
    $data[$i]['activity'] = sanitize_output(time_since($row['p_activity']));
    $data[$i]['views']    = sanitize_output(number_display_format($row['p_views'], 'number'));
    $old_view_count       = ($row['p_oldviews']) ? number_display_format($row['p_oldviews'], 'number') : '-';
    $old_view_count       = ($row['p_oldviews']) ? $old_view_count : __('admin_views_new');
    $data[$i]['oldviews'] = sanitize_output($old_view_count);
    $data[$i]['sgrowth']  = sanitize_output($row['p_views'] - $row['p_oldviews']);
    $data[$i]['growth']   = ($data[$i]['sgrowth'])
                          ? sanitize_output(number_display_format($data[$i]['sgrowth'], 'number', 0, 1))
                          : '-';
    $data[$i]['spgrowth'] = ($row['p_oldviews']) ? maths_percentage_growth($row['p_oldviews'], $row['p_views']) : 0;
    $percent_growth       = ($data[$i]['spgrowth'])
                          ? number_display_format($data[$i]['spgrowth'], 'percentage', 0, 1)
                          : 0;
    $percent_growth       = ($row['p_oldviews']) ? $percent_growth : __('admin_views_new');
    $data[$i]['pgrowth']  = ($percent_growth) ? sanitize_output($percent_growth) : '-';
  }

  // If the sorting is by days sentenced or days banned, then it must still be sorted
  if($sort_by === 'growth')
    array_multisort(array_column($data, "sgrowth"), SORT_DESC, $data);
  if($sort_by === 'pgrowth')
    array_multisort(array_column($data, "spgrowth"), SORT_DESC, $data);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Add the current comparison date to the data
  $comparison_date          = system_variable_fetch('last_pageview_check');
  $data['comparison_date']  = ($comparison_date)
                            ? sanitize_output(date_to_text($comparison_date).' ('.time_since($comparison_date).')')
                            : __('admin_views_nodate');

  // Return the prepared data
  return $data;
}




/**
 * Resets the pageview comparison data.
 *
 * @return  void
 */

function stats_views_reset() : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Reset all pageviews comparison data
  query(" UPDATE  stats_pages
          SET     stats_pages.view_count_archive = stats_pages.view_count ");

  // Update the global variable
  $timestamp = sanitize(time(), 'int', 0);
  system_variable_update('last_pageview_check', $timestamp, 'int');
}




/**
 * Delete a page's data.
 *
 * @param   int   $page_id  The id of the page to delete.
 *
 * @return  void
 */

function stats_views_delete( int $page_id ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanatize the page's id
  $page_id = sanitize($page_id, 'int', 0);

  // Delete the page's data
  query(" DELETE FROM stats_pages
          WHERE       stats_pages.id = '$page_id' ");
}




/**
 * Lists data regarding registered users.
 *
 * @param   string  $sort_by  (OPTIONAL)  The order in which the returned data will be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         A list of users.
 */

function stats_users_list(  string  $sort_by  = 'activity'  ,
                            array   $search   = array()     ) : array
{
  // Check if the required files have been included
  require_included_file('users.act.php');
  require_included_file('functions_time.inc.php');
  require_included_file('functions_mathematics.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Require special rights to run this action
  user_restrict_to_moderators();

  // Fetch current user's language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Sanitize the search parameters
  $search_username  = sanitize_array_element($search, 'username', 'string');
  $search_created   = sanitize_array_element($search, 'created', 'int', min: 0, max: date('Y'), default: 0);
  $search_page      = sanitize_array_element($search, 'page', 'string');
  $search_action    = sanitize_array_element($search, 'action', 'int', min: -1, max: 1, default: -1);
  $search_language  = sanitize_array_element($search, 'language', 'string');
  $search_speaks    = sanitize_array_element($search, 'speaks', 'string');
  $search_theme     = sanitize_array_element($search, 'theme', 'string');
  $search_birthday  = sanitize_array_element($search, 'birthday', 'int', min: 0, max: date('Y'), default: 0);
  $search_profile   = sanitize_array_element($search, 'profile', 'string');
  $search_settings  = sanitize_array_element($search, 'settings', 'string');

  // Search through the data: Actions
  $query_search = match($search_action)
  {
    0       => " WHERE users.last_action_at = 0 " ,
    1       => " WHERE users.last_action_at > 0 " ,
    default => " WHERE 1 = 1 "                    ,
  };

  // Search through the data: Website language
  if($search_language && $search_language !== 'None')
    $query_search .= " AND  users.current_language LIKE '%$search_language%'  ";
  else if($search_language)
    $query_search .= " AND  users.current_language    = ''                    ";

  // Search through the data: Spoken languages
  if($search_speaks && $search_speaks !== 'None' && $search_speaks !== 'Both')
    $query_search .= " AND    users_profile.spoken_languages LIKE '%$search_speaks%'  ";
  else if($search_speaks === 'Both')
    $query_search .= "  AND ( users_profile.spoken_languages LIKE 'FREN'
                        OR    users_profile.spoken_languages LIKE 'ENFR' )            ";
  else if($search_speaks)
    $query_search .= "  AND   users_profile.spoken_languages    = ''                  ";

  // Search through the data: Website theme
  if($search_theme && $search_theme !== 'None')
    $query_search .= " AND users.current_theme LIKE '%$search_theme%' ";
  else if($search_theme)
    $query_search .= " AND users.current_theme    = ''                ";

  // Search through the data: Birthday
  if($search_birthday === -1)
    $query_search .= " AND users_profile.birthday       = '0000-00-00'        ";
  else if($search_birthday > 0)
    $query_search .= " AND YEAR(users_profile.birthday) = '$search_birthday'  ";

  // Search through the data: Profile info
  $query_search .= match($search_profile)
  {
    'empty'     => "  AND   users_profile.birthday          = '0000-00-00'
                      AND   users_profile.spoken_languages  = ''
                      AND   users_profile.lives_at          = ''
                      AND   users_profile.pronouns_en       = ''
                      AND   users_profile.pronouns_fr       = ''
                      AND   users_profile.profile_text_en   = ''
                      AND   users_profile.profile_text_fr   = '' "            ,
    'filled'    => "  AND ( users_profile.birthday         != '0000-00-00'
                      OR    users_profile.spoken_languages != ''
                      OR    users_profile.lives_at         != ''
                      OR    users_profile.pronouns_en      != ''
                      OR    users_profile.pronouns_fr      != ''
                      OR    users_profile.profile_text_en  != ''
                      OR    users_profile.profile_text_fr  != '' ) "          ,
    'complete'  => "  AND   users_profile.birthday         != '0000-00-00'
                      AND   users_profile.spoken_languages != ''
                      AND   users_profile.lives_at         != ''
                      AND ( users_profile.pronouns_en      != ''
                      OR    users_profile.pronouns_fr      != '' )
                      AND ( users_profile.profile_text_en  != ''
                      OR    users_profile.profile_text_fr  != '' ) "          ,
    'speaks'    => "  AND   users_profile.spoken_languages != '' "            ,
    'birthday'  => "  AND   users_profile.birthday         != '0000-00-00' "  ,
    'location'  => "  AND   users_profile.lives_at         != '' "            ,
    'pronouns'  => "  AND ( users_profile.pronouns_en      != ''
                      OR    users_profile.pronouns_fr      != '' ) "          ,
    'text'      => "  AND ( users_profile.profile_text_en  != ''
                      OR    users_profile.profile_text_fr  != '' ) "          ,
    default     => ""                                                         ,
  };

  // Search through the data: Settings
  $query_search .= match($search_settings)
  {
    'nsfw'        => " AND  users_settings.show_nsfw_content  = 2 " ,
    'some_nsfw'   => " AND  users_settings.show_nsfw_content  = 1 " ,
    'no_nsfw'     => " AND  users_settings.show_nsfw_content  = 0 " ,
    'no_youtube'  => " AND  users_settings.hide_youtube       = 1 " ,
    'no_trends'   => " AND  users_settings.hide_google_trends = 1 " ,
    'no_discord'  => " AND  users_settings.hide_discord       = 1 " ,
    'no_kiwiirc'  => " AND  users_settings.hide_kiwiirc       = 1 " ,
    'hide'        => " AND  users_settings.hide_from_activity = 1 " ,
    default       => ""                                             ,
  };

  // Search through the data: Other searches
  $query_search .= ($search_username)     ? " AND   users.username                 LIKE '%$search_username%'  " : "";
  $query_search .= ($search_created > 0)  ? "
                                    AND YEAR(FROM_UNIXTIME(users_profile.created_at)) = '$search_created'     " : "";
  $query_search .= ($search_page)         ? " AND ( users.last_visited_page_$lang  LIKE '%$search_page%'
                                              OR    users.last_visited_url         LIKE '%$search_page%' )    " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'username'  => " ORDER BY users.username                  ASC       " ,
    'usertypes' => " ORDER BY users.is_administrator          = 0       ,
                              users.is_moderator              = 0       ,
                              users.is_banned_until           = 0       ,
                              users.is_deleted                = 0       ,
                              users.username                  ASC       " ,
    'visits'    => " ORDER BY users.visited_page_count        DESC      ,
                              users.last_visited_at           DESC      " ,
    'created'   => " ORDER BY users_profile.created_at        ASC       " ,
    'rcreated'  => " ORDER BY users_profile.created_at        DESC      " ,
    'ractivity' => " ORDER BY users.last_visited_at           ASC       " ,
    'page'      => " ORDER BY users.last_visited_page_$lang   = ''      ,
                              users.last_visited_page_$lang   ASC       ,
                              users.last_visited_at           DESC      " ,
    'url'       => " ORDER BY users.last_visited_url          = ''      ,
                              users.last_visited_url          ASC       ,
                              users.last_visited_page_$lang   = ''      ,
                              users.last_visited_page_$lang   ASC       ,
                              users.last_visited_at           DESC      " ,
    'action'    => " ORDER BY users.last_action_at            = 0       ,
                              users.last_action_at            DESC      ,
                              users.last_visited_at           DESC      " ,
    'language'  => " ORDER BY users.current_language          = ''      ,
                              users.current_language          != 'EN'   ,
                              users.current_language          ASC       ,
                              users.last_visited_at           DESC      " ,
    'speaks'    => " ORDER BY users_profile.spoken_languages  = ''      ,
                              users_profile.spoken_languages  != 'EN'   ,
                              users_profile.spoken_languages  ASC       ,
                              users.last_visited_at           DESC      " ,
    'theme'     => " ORDER BY users.current_theme             = ''      ,
                              users.current_theme             != 'dark' ,
                              users.current_theme             ASC       ,
                              users.last_visited_at           DESC      " ,
    'birthday'  => " ORDER BY users_profile.birthday          = 0       ,
                              users_profile.birthday          ASC       ,
                              users.last_visited_at           DESC      " ,
    'rbirthday' => " ORDER BY users_profile.birthday          = 0       ,
                              users_profile.birthday          DESC      ,
                              users.last_visited_at           DESC      " ,
    default     => " ORDER BY users.last_visited_at           DESC      " ,
  };

  // Fetch the guest list
  $qusers = query(" SELECT    users.id                          AS 'u_id'           ,
                              users.is_deleted                  AS 'u_deleted'      ,
                              users.is_administrator            AS 'u_admin'        ,
                              users.is_moderator                AS 'u_mod'          ,
                              users.deleted_username            AS 'u_delnick'      ,
                              users.username                    AS 'u_nick'         ,
                              users.current_language            AS 'u_lang'         ,
                              users.current_theme               AS 'u_theme'        ,
                              users.last_visited_at             AS 'u_visit'        ,
                              users.last_visited_page_$lang     AS 'u_page'         ,
                              users.last_visited_url            AS 'u_url'          ,
                              users.last_action_at              AS 'u_action'       ,
                              users.visited_page_count          AS 'u_visits'       ,
                              users.is_banned_until             AS 'u_banned'       ,
                              users_profile.created_at          AS 'u_created'      ,
                              users_profile.birthday            AS 'u_birthday'     ,
                              users_profile.spoken_languages    AS 'u_languages'    ,
                              users_profile.lives_at            AS 'u_location'     ,
                              users_profile.pronouns_en         AS 'u_pronouns_en'  ,
                              users_profile.pronouns_fr         AS 'u_pronouns_fr'  ,
                              users_profile.profile_text_en     AS 'u_profile_en'   ,
                              users_profile.profile_text_fr     AS 'u_profile_fr'   ,
                              users_settings.show_nsfw_content  AS 'u_nsfw'         ,
                              users_settings.hide_youtube       AS 'u_youtube'      ,
                              users_settings.hide_google_trends AS 'u_trends'       ,
                              users_settings.hide_discord       AS 'u_discord'      ,
                              users_settings.hide_kiwiirc       AS 'u_kiwiirc'      ,
                              users_settings.hide_from_activity AS 'u_hidden'
                    FROM      users
                    LEFT JOIN users_settings  ON users_settings.fk_users  = users.id
                    LEFT JOIN users_profile   ON users_profile.fk_users   = users.id
                              $query_search
                              $query_sort ");

  // Initialize variables used for stats
  $sum_visited  = 0;
  $sum_english  = 0;
  $sum_french   = 0;
  $sum_dark     = 0;
  $sum_light    = 0;
  $sum_profile  = 0;

  // Loop through the data
  for($i = 0; $row = query_row($qusers); $i++)
  {
    // Prepare the data
    $data[$i]['id']       = sanitize_output($row['u_id']);
    $user_css             = ($row['u_mod']) ? 'text_green bold noglow' : 'bold';
    $user_css             = ($row['u_admin']) ? 'text_red bold' : $user_css;
    $user_css             = ($row['u_banned']) ? 'text_brown bold noglow strikethrough' : $user_css;
    $data[$i]['user_css'] = ($row['u_deleted']) ? ' strikethrough noglow' : $user_css;
    $data[$i]['username'] = ($row['u_deleted']) ? sanitize_output($row['u_delnick']) : sanitize_output($row['u_nick']);
    $data[$i]['language'] = sanitize_output($row['u_lang']);
    $data[$i]['theme']    = sanitize_output($row['u_theme']);
    $data[$i]['active']   = sanitize_output(time_since($row['u_visit']));
    $data[$i]['page']     = sanitize_output(string_truncate($row['u_page'], 18, '...'));
    $data[$i]['url']      = sanitize_output($row['u_url']);
    $data[$i]['action']   = ($row['u_action']) ? sanitize_output(time_since($row['u_action'])) : '-';
    $data[$i]['visits']   = ($row['u_visits'] > 1) ? sanitize_output($row['u_visits']) : '-';
    $data[$i]['created']  = sanitize_output(time_since($row['u_created']));
    $data[$i]['birthday'] = sanitize_output(date_to_ddmmyy($row['u_birthday']));
    $data[$i]['speaks']   = sanitize_output($row['u_languages']);
    $data[$i]['speak_en'] = str_contains($row['u_languages'], 'EN');
    $data[$i]['speak_fr'] = str_contains($row['u_languages'], 'FR');
    $data[$i]['location'] = ($row['u_location']);
    $data[$i]['pronouns'] = ($row['u_pronouns_en'] || $row['u_pronouns_fr']);
    $data[$i]['profile']  = ($row['u_profile_en'] || $row['u_profile_fr']);
    $data[$i]['nsfw']     = sanitize_output($row['u_nsfw']);
    $data[$i]['youtube']  = ($row['u_youtube']);
    $data[$i]['trends']   = ($row['u_trends']);
    $data[$i]['discord']  = ($row['u_discord']);
    $data[$i]['kiwiirc']  = ($row['u_kiwiirc']);
    $data[$i]['hidden']   = ($row['u_hidden']);

    // Update the stats
    $sum_visited  += ($row['u_visit'] >= (time() - 8640000))  ? 1 : 0;
    $sum_english  += ($row['u_lang'] === 'EN')                ? 1 : 0;
    $sum_french   += ($row['u_lang'] === 'FR')                ? 1 : 0;
    $sum_dark     += ($row['u_theme'] === 'dark')             ? 1 : 0;
    $sum_light    += ($row['u_theme'] === 'light')            ? 1 : 0;
    $sum_profile  += ($row['u_birthday'] !== '0000-00-00' || $row['u_location'] || $row['u_languages'] || $row['u_pronouns_en'] || $row['u_pronouns_fr'] || $row['u_profile_en'] || $row['u_profile_fr']) ? 1 : 0;
  }

  // Fetch the total guest count
  $total_users = users_total_count();

  // Calculate more stats
  $data['percent_users']    = number_display_format(maths_percentage_of($i, $total_users), 'percentage', decimals: 1);
  $data['percent_visited']  = number_display_format(maths_percentage_of($sum_visited, $i), 'percentage', decimals: 1);
  $data['percent_english']  = number_display_format(maths_percentage_of($sum_english, $i), 'percentage', decimals: 1);
  $data['percent_french']   = number_display_format(maths_percentage_of($sum_french , $i), 'percentage', decimals: 1);
  $data['percent_dark']     = number_display_format(maths_percentage_of($sum_dark   , $i), 'percentage', decimals: 1);
  $data['percent_light']    = number_display_format(maths_percentage_of($sum_light  , $i), 'percentage', decimals: 1);
  $data['percent_profile']  = number_display_format(maths_percentage_of($sum_profile, $i), 'percentage', decimals: 1);

  // Add the stats to the data
  $data['sum_visited']  = $sum_visited;
  $data['sum_en']       = $sum_english;
  $data['sum_fr']       = $sum_french;
  $data['sum_dark']     = $sum_dark;
  $data['sum_light']    = $sum_light;
  $data['sum_profile']  = $sum_profile;

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Lists data regarding non registered users.
 *
 * @param   string  $sort_by  (OPTIONAL)  The order in which the returned data will be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         A list of guests.
 */

function stats_guests_list( string  $sort_by  = 'activity'  ,
                            array   $search   = array()     ) : array
{
  // Check if the required files have been included
  require_included_file('users.act.php');
  require_included_file('functions_time.inc.php');
  require_included_file('functions_mathematics.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Require special rights to run this action
  user_restrict_to_moderators();

  // Fetch current user's language and access rights
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = user_is_administrator();

  // Sanitize the search parameters
  $search_identity  = sanitize_array_element($search, 'identity', 'string');
  $search_page      = sanitize_array_element($search, 'page', 'string');
  $search_language  = sanitize_array_element($search, 'language', 'string');
  $search_theme     = sanitize_array_element($search, 'theme', 'string');

  // Only admins should see users in this list
  $query_search = ($is_admin) ? " WHERE 1 = 1 " : " AND users.id IS NULL ";

  // Search through the data: Website language
  if($search_language && $search_language !== 'None')
    $query_search .= " AND users_guests.current_language LIKE '%$search_language%'  ";
  else if($search_language)
    $query_search .= " AND users_guests.current_language    = ''                    ";

  // Search through the data: Website theme
  if($search_theme && $search_theme !== 'None')
    $query_search .= " AND users_guests.current_theme  LIKE '%$search_theme%' ";
  else if($search_theme)
    $query_search .= " AND users_guests.current_theme     = ''                ";

  // Search through the data: Other searches
  $query_search .= ($search_identity && $is_admin) ? "
                                      AND ( users_guests.ip_address              LIKE '%$search_identity%'
                                      OR    users.username                       LIKE '%$search_identity%' )  " : "";
  $query_search .= ($search_page) ? " AND ( users_guests.last_visited_page_$lang LIKE '%$search_page%'
                                      OR    users_guests.last_visited_url        LIKE '%$search_page%' )      " : "";

  // Forbid non-admins from searching by identity
  if($sort_by === 'identity' && !$is_admin)
    $sort_by = '';

  // Sort the data
  $query_sort = match($sort_by)
  {
    'identity'  => " ORDER BY users.id                              IS NULL   ,
                              users.username                        ASC       ,
                              users_guests.ip_address               ASC       " ,
    'visits'    => " ORDER BY users_guests.visited_page_count       DESC      ,
                              users_guests.last_visited_at          DESC      " ,
    'ractivity' => " ORDER BY users_guests.last_visited_at          ASC       " ,
    'page'      => " ORDER BY users_guests.last_visited_page_$lang  = ''      ,
                              users_guests.last_visited_page_$lang  ASC       ,
                              users_guests.last_visited_at          DESC      " ,
    'url'       => " ORDER BY users_guests.last_visited_url         = ''      ,
                              users_guests.last_visited_url         ASC       ,
                              users_guests.last_visited_page_$lang  = ''      ,
                              users_guests.last_visited_page_$lang  ASC       ,
                              users_guests.last_visited_at          DESC      " ,
    'language'  => " ORDER BY users_guests.current_language         = ''      ,
                              users_guests.current_language         != 'EN'   ,
                              users_guests.current_language         ASC       ,
                              users_guests.last_visited_at          DESC      " ,
    'theme'     => " ORDER BY users_guests.current_theme            = ''      ,
                              users_guests.current_theme            != 'dark' ,
                              users_guests.current_theme            ASC       ,
                              users_guests.last_visited_at          DESC      " ,
    default     => " ORDER BY users_guests.last_visited_at          DESC      " ,
  };

  // Fetch the guest list
  $qguests = query("  SELECT    users_guests.ip_address                   AS 'g_ip'     ,
                                users_guests.current_language             AS 'g_lang'   ,
                                users_guests.current_theme                AS 'g_theme'  ,
                                users_guests.last_visited_at              AS 'g_visit'  ,
                                users_guests.last_visited_page_$lang      AS 'g_page'   ,
                                users_guests.last_visited_url             AS 'g_url'    ,
                                users_guests.visited_page_count           AS 'g_visits' ,
                                users_guests.randomly_assigned_name_$lang AS 'g_name'   ,
                                users.id                                  AS 'u_id'     ,
                                users.username                            AS 'u_nick'
                      FROM      users_guests
                      LEFT JOIN users
                      ON        users_guests.ip_address LIKE users.current_ip_address
                                $query_search
                      GROUP BY  users_guests.id
                                $query_sort ");

  // Initialize variables used for stats
  $sum_english  = 0;
  $sum_french   = 0;
  $sum_dark     = 0;
  $sum_light    = 0;

  // Loop through the data
  for($i = 0; $row = query_row($qguests); $i++)
  {
    // Prepare the data
    $data[$i]['user_id']  = sanitize_output($row['u_id']);
    $guest_identity       = ($is_admin) ? $row['g_ip'] : string_truncate($row['g_name'], 30, '...');
    $data[$i]['identity'] = ($row['u_nick']) ? sanitize_output($row['u_nick']) : sanitize_output($guest_identity);
    $data[$i]['ip']       = sanitize_output($row['g_ip']);
    $data[$i]['language'] = sanitize_output($row['g_lang']);
    $data[$i]['theme']    = sanitize_output($row['g_theme']);
    $data[$i]['active']   = sanitize_output(time_since($row['g_visit']));
    $data[$i]['page']     = sanitize_output(string_truncate($row['g_page'], 30, '...'));
    $data[$i]['url']      = sanitize_output($row['g_url']);
    $data[$i]['visits']   = ($row['g_visits'] > 1) ? sanitize_output($row['g_visits']) : '-';

    // Update the stats
    $sum_english  += ($row['g_lang'] === 'EN')      ? 1 : 0;
    $sum_french   += ($row['g_lang'] === 'FR')      ? 1 : 0;
    $sum_dark     += ($row['g_theme'] === 'dark')   ? 1 : 0;
    $sum_light    += ($row['g_theme'] === 'light')  ? 1 : 0;
  }

  // Fetch the total guest count
  $total_guests = users_guests_count();

  // Calculate more stats
  $data['percent_guests']   = number_display_format(maths_percentage_of($i, $total_guests), 'percentage', decimals: 1);
  $data['percent_english']  = number_display_format(maths_percentage_of($sum_english, $i), 'percentage', decimals: 1);
  $data['percent_french']   = number_display_format(maths_percentage_of($sum_french , $i), 'percentage', decimals: 1);
  $data['percent_dark']     = number_display_format(maths_percentage_of($sum_dark   , $i), 'percentage', decimals: 1);
  $data['percent_light']    = number_display_format(maths_percentage_of($sum_light  , $i), 'percentage', decimals: 1);

  // Add the stats to the data
  $data['sum_en']     = $sum_english;
  $data['sum_fr']     = $sum_french;
  $data['sum_dark']   = $sum_dark;
  $data['sum_light']  = $sum_light;

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Lists users sharing the same IP address.
 *
 * @return  array   An array of data regarding IP doppelgangers.
 */

function stats_doppelgangers_list() : array
{
  // Require administrator rights to run this action
  user_restrict_to_moderators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Fetch the doppelgangers
  $qdoppel = query("  SELECT    users.id                  AS 'u_id'     ,
                                users.username            AS 'u_nick'   ,
                                users.last_visited_at     AS 'u_active' ,
                                users.current_ip_address  AS 'u_ip'     ,
                                users.is_banned_until     AS 'u_banned'
                      FROM      users
                      WHERE     users.current_ip_address  NOT LIKE  ''
                      AND       users.current_ip_address  NOT LIKE  '0.0.0.0'
                      AND       users.is_deleted          =         0
                      AND       users.current_ip_address  IN (  SELECT    users.current_ip_address
                                                                FROM      users
                                                                GROUP BY  users.current_ip_address
                                                                HAVING    COUNT(users.current_ip_address) > 1 )
                      ORDER BY  users.current_ip_address  ASC   ,
                                users.last_visited_at     DESC  ");

  // Initialize the ban check counter
  $data['includes_bans'] = 0;

  // Prepare the data
  for($i = 0; $row = query_row($qdoppel); $i++)
  {
    $data[$i]['id']         = sanitize_output($row['u_id']);
    $data[$i]['ip']         = sanitize_output($row['u_ip']);
    $data[$i]['hiddenip']   = sanitize_output(preg_replace('#[0-9 ]*#', '*', $row['u_ip']));
    $data[$i]['username']   = sanitize_output($row['u_nick']);
    $data[$i]['activity']   = sanitize_output(time_since($row['u_active']));
    $data[$i]['banned']     = ($row['u_banned']) ? date_to_text($row['u_banned'], 1) : 0;
    $data['includes_bans']  = ($row['u_banned']) ? 1 : $data['includes_bans'];
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Initialize the rowspan counter
  $count = 1;

  // Go through the rows once again but in reverse in order count the amount of times an IP is shared
  for($i = ($data['rows'] - 1); $i >= 0; $i--)
  {
    if($i < ($data['rows'] - 1) && $data[$i]['ip'] === $data[$i+1]['ip'])
      $count++;
    else
      $count = 1;
    $data[$i]['count'] = $count;
  }

  // Return the prepared data
  return $data;
}