<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  users_get                           Fetches data related to a user.                                              */
/*  users_list                          Fetches a list of users.                                                     */
/*  users_list_admins                   Fetches a list of administrative team members.                               */
/*  users_edit_profile                  Modifies a user's own public profile.                                        */
/*  users_delete_profile                Deletes a user's public profile.                                             */
/*                                                                                                                   */
/*  users_ban_details                   Fetches information related to a user's ban.                                 */
/*                                                                                                                   */
/*  users_check_username                Checks if a username currently exists in the database.                       */
/*  users_check_username_illegality     Checks if a username is illegal.                                             */
/*                                                                                                                   */
/*  users_autocomplete_username         Autocompletes a username.                                                    */
/*                                                                                                                   */
/*  users_total_count                   Returns the number of users stored in the database.                          */
/*  users_guests_count                  Returns the number of guests stored in the database.                         */
/*  users_guests_storage_length         Returns for how long guests are currently being stored in the database.      */
/*                                                                                                                   */
/*  users_stats_list                    Returns stats related to users.                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Fetches data related to a user.
 *
 * @param   int|null    $user_id  (OPTIONAL)  The user's id, will default to current user if unset.
 * @param   string      $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array|null                        An array containing user related data, or NULL if it does not exist.
 */

function users_get( ?int    $user_id  = NULL    ,
                    string  $format   = 'html'  ) : mixed
{
  // Check if the required files have been included
  require_included_file('users.lang.php');
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // User must be logged in if no id is provided
  if(!$user_id && !user_is_logged_in())
    return NULL;

  // Get current user id if needed
  $user_id = ($user_id) ? $user_id : user_get_id();

  // Sanitize the user id
  $user_id = sanitize($user_id, 'int', 0);

  // Check if the user exists
  if(!database_row_exists('users', $user_id))
    return NULL;

  // Fetch the data
  $duser = mysqli_fetch_array(query(" SELECT    users.is_deleted                  AS 'u_deleted'      ,
                                                users.is_banned_until             AS 'u_banned'       ,
                                                users.username                    AS 'u_nick'         ,
                                                users.is_administrator            AS 'u_admin'        ,
                                                users.is_moderator                AS 'u_mod'          ,
                                                users.last_visited_at             AS 'u_activity'     ,
                                                users.last_visited_page_en        AS 'u_active_en'    ,
                                                users.last_visited_page_fr        AS 'u_active_fr'    ,
                                                users.last_visited_url            AS 'u_active_url'   ,
                                                users.last_action_at              AS 'u_lastaction'   ,
                                                users.current_ip_address          AS 'u_ip'           ,
                                                users_profile.created_at          AS 'u_created'      ,
                                                users_profile.spoken_languages    AS 'u_lang'         ,
                                                users_profile.pronouns_en         AS 'u_pronouns_en'  ,
                                                users_profile.pronouns_fr         AS 'u_pronouns_fr'  ,
                                                users_profile.lives_at            AS 'u_country'      ,
                                                users_profile.birthday            AS 'u_birthday'     ,
                            TIMESTAMPDIFF(YEAR, users_profile.birthday, NOW())    AS 'u_age'          ,
                                                DAY(users_profile.birthday)       AS 'u_birth_d'      ,
                                                MONTH(users_profile.birthday)     AS 'u_birth_m'      ,
                                                YEAR(users_profile.birthday)      AS 'u_birth_y'      ,
                                                users_profile.profile_text_en     AS 'u_text_en'      ,
                                                users_profile.profile_text_fr     AS 'u_text_fr'      ,
                                                users_profile.email_address       AS 'u_mail'         ,
                                                users_settings.hide_from_activity AS 'u_hideact'      ,
                                                users_stats.quotes                AS 'us_quotes'      ,
                                                users_stats.quotes_approved       AS 'us_quotes_app'  ,
                                                users_stats.meetups               AS 'us_meetups'     ,
                                                users_stats.tasks_submitted       AS 'us_tasks_sub'
                                      FROM      users
                                      LEFT JOIN users_profile   ON users_profile.fk_users   = users.id
                                      LEFT JOIN users_settings  ON users_settings.fk_users  = users.id
                                      LEFT JOIN users_stats     ON users_stats.fk_users     = users.id
                                      WHERE     users.id = '$user_id' "));

  // Get the current user's language
  $lang = user_get_language();

  // Format the data
  $user_deleted           = $duser['u_deleted'];
  $user_banned            = $duser['u_banned'];
  $user_username          = $duser['u_nick'];
  $user_moderator         = $duser['u_mod'];
  $user_admin             = $duser['u_admin'];
  $user_languages         = $duser['u_lang'];
  $user_text_fr           = $duser['u_text_fr'];
  $user_text_en           = $duser['u_text_en'];
  $user_pronouns_fr       = $duser['u_pronouns_fr'];
  $user_pronouns_en       = $duser['u_pronouns_en'];
  $user_country           = $duser['u_country'];
  $user_created           = $duser['u_created'];
  $user_activity          = $duser['u_activity'];
  $user_birthday          = $duser['u_birthday'];
  $user_birth_y           = ($duser['u_birth_y']) ? $duser['u_birth_y'] : '';
  $user_birth_m           = ($duser['u_birth_m']) ? $duser['u_birth_m'] : '';
  $user_birth_d           = ($duser['u_birth_d']) ? $duser['u_birth_d'] : '';
  $user_age               = ($user_birth_y) ? $duser['u_age'] : 0;
  $user_hide_activity     = $duser['u_hideact'];
  $user_last_page_en      = $duser['u_active_en'];
  $user_last_page_fr      = $duser['u_active_fr'];
  $user_last_page_url     = (substr($duser['u_active_url'], 0, 1) != '.') ? $duser['u_active_url'] : '';
  $user_last_action       = $duser['u_lastaction'];
  $user_ip                = $duser['u_ip'];
  $user_email             = $duser['u_mail'];
  $user_stats_quotes      = $duser['us_quotes'];
  $user_stats_quotes_sub  = $duser['us_quotes_app'];
  $user_stats_meetups     = $duser['us_meetups'];
  $user_stats_tasks_sub   = $duser['us_tasks_sub'];
  $user_stats_contribs    = $user_stats_quotes + $user_stats_quotes_sub + $user_stats_meetups + $user_stats_tasks_sub;

  // Prepare the data for display
  if($format === 'html')
  {
    $data['id']         = sanitize_output($user_id);
    $data['deleted']    = sanitize_output($user_deleted);
    $data['banned']     = ($user_banned);
    $data['unbanned']   = sanitize_output(string_change_case(time_until($user_banned), 'lowercase'));
    $data['username']   = sanitize_output($user_username);
    $user_title         = ($user_moderator) ? __('moderator') : '';
    $user_title         = ($user_admin) ? __('administrator') : $user_title;
    $data['title']      = sanitize_output(string_change_case($user_title, 'initials'));
    $user_css           = ($user_moderator) ? ' text_orange noglow' : '';
    $data['title_css']  = ($user_admin) ? ' text_red glow_dark' : $user_css;
    $data['lang_en']    = str_contains($user_languages, 'EN');
    $data['lang_fr']    = str_contains($user_languages, 'FR');
    $data['text']       = ($lang === 'FR' && $user_text_fr)
                        ? bbcodes(sanitize_output($user_text_fr, preserve_line_breaks: true))
                        : bbcodes(sanitize_output($user_text_en, preserve_line_breaks: true));
    $data['text_fr']    = sanitize_output($user_text_fr);
    $data['text_en']    = sanitize_output($user_text_en);
    $data['ftext_fr']   = bbcodes(sanitize_output($user_text_fr, true));
    $data['ftext_en']   = bbcodes(sanitize_output($user_text_en, true));
    $data['pronouns']   = ($lang === 'FR' && $user_pronouns_fr)
                        ? sanitize_output($user_pronouns_fr)
                        : sanitize_output($user_pronouns_en);
    $data['pronoun_en'] = sanitize_output($user_pronouns_en);
    $data['pronoun_fr'] = sanitize_output($user_pronouns_fr);
    $data['country']    = sanitize_output($user_country);
    $data['created']    = sanitize_output(date_to_text($user_created, strip_day: 1));
    $data['screated']   = sanitize_output(time_since($user_created));
    $data['activity']   = ($user_activity)
                        ? sanitize_output(time_since($user_activity))
                        : sanitize_output(time_since($user_activity));
    $data['birthday']   = ($user_birth_d && $user_birth_m)
                        ? sanitize_output(date_to_text($user_birthday, strip_day: true, strip_year: true))
                        : 0;
    $data['age']        = sanitize_output($user_age);
    $data['birth_d']    = sanitize_output($user_birth_d);
    $data['birth_m']    = sanitize_output($user_birth_m);
    $data['birth_y']    = sanitize_output($user_birth_y);
    $data['hideact']    = ($user_hide_activity);
    $data['ip']         = ($user_ip === '0.0.0.0') ? __('users_profile_unknown') : sanitize_output($user_ip);
    $data['lastpage']   = ($lang === 'FR' && $user_last_page_fr)
                        ? sanitize_output($user_last_page_fr)
                        : sanitize_output($user_last_page_en);
    $data['lasturl']    = sanitize_output($user_last_page_url);
    $data['lastaction'] = ($user_last_action)
                        ? sanitize_output(time_since($user_last_action))
                        : sanitize_output(string_change_case(__('none_f'), 'initials'));
    $data['email']      = ($user_email)
                        ? sanitize_output($user_email)
                        : string_change_case(__('none_f'), 'initials');
    $data['quotes']     = sanitize_output($user_stats_quotes);
    $data['quotes_app'] = sanitize_output($user_stats_quotes_sub);
    $data['meetups']    = sanitize_output($user_stats_meetups);
    $data['tasks']      = sanitize_output($user_stats_tasks_sub);
    $data['contribs']   = sanitize_output($user_stats_contribs);
  }

  // Prepare the data for the API
  else if($format === 'api')
  {
    // User data
    $data['user']['id']               = (string)$user_id;
    $data['user']['username']         = (!$user_deleted) ? $user_username : '[deleted]';
    $data['user']['is_deleted']       = (bool)$user_deleted;
    $data['user']['is_banned']        = (bool)($user_banned);
    $data['user']['is_moderator']     = (bool)($user_moderator || $user_admin);
    $data['user']['is_administrator'] = (bool)($user_admin);

    // Profile data
    if(!$user_deleted)
    {
      $data['user']['profile']['account_created_on']  = date('Y-m-d', $user_created);
      $data['user']['profile']['speaks_english']      = (bool)str_contains($user_languages, 'EN');
      $data['user']['profile']['speaks_french']       = (bool)str_contains($user_languages, 'FR');
      $data['user']['profile']['birthday']            = ($user_birthday != '0000-00-00') ? $user_birthday : NULL;
      $data['user']['profile']['age']                 = $user_age ?: NULL;
      $data['user']['profile']['location']            = $user_country ?: NULL;
      $data['user']['profile']['pronouns_en']         = $user_pronouns_en ?: NULL;
      $data['user']['profile']['pronouns_fr']         = $user_pronouns_fr ?: NULL;
      $data['user']['profile']['custom_text_en']      = sanitize_json(bbcodes_remove($user_text_en)) ?: NULL;
      $data['user']['profile']['custom_text_fr']      = sanitize_json(bbcodes_remove($user_text_fr)) ?: NULL;
    }
    else
      $data['user']['profile'] = NULL;

    // Activity data
    if($user_activity && !$user_hide_activity && !$user_deleted)
    {
      $user_activity_aware_datetime = date_to_aware_datetime($user_activity);
      $data['user']['last_activity']['time_since']    = time_since($user_activity);
      $data['user']['last_activity']['datetime']      = $user_activity_aware_datetime['datetime'];
      $data['user']['last_activity']['timezone']      = $user_activity_aware_datetime['timezone'];
      $data['user']['last_activity']['page_link']     = ($user_last_page_url)
                                                      ? $GLOBALS['website_url'].$user_last_page_url
                                                      : $GLOBALS['website_url'];
      $data['user']['last_activity']['page_name_en']  = $user_last_page_en ?: NULL;
      $data['user']['last_activity']['page_name_fr']  = $user_last_page_fr ?: NULL;
    }
    else
      $data['user']['last_activity'] = NULL;

    // Stats
    if(!$user_deleted)
    {
      $data['user']['stats']['quotes_appeared_in']  = (int)$user_stats_quotes;
      $data['user']['stats']['quotes_submitted']    = (int)$user_stats_quotes_sub;
      $data['user']['stats']['meetups_attended']    = (int)$user_stats_meetups;
      $data['user']['stats']['tasks_submitted']     = (int)$user_stats_tasks_sub;
    }

    // Ban data
    if($user_banned && !$user_deleted)
    {
      $ban_aware_datetime = date_to_aware_datetime($user_banned);
      $data['user']['ban']['unban_deadline']  = time_until($user_banned);
      $data['user']['ban']['unban_datetime']  = $ban_aware_datetime['datetime'];
      $data['user']['ban']['unban_timezone']  = $ban_aware_datetime['timezone'];
    }
    else
      $data['user']['ban'] = NULL;
  }

  // Return the array
  return $data;
}




 /**
 * Fetches a list of users.
 *
 * @param   string  $sort_by          (OPTIONAL)  The way the user list should be sorted.
 * @param   array   $search           (OPTIONAL)  Search for specific field values.
 * @param   int     $max_count        (OPTIONAL)  The number of users to return (0 for unlimited).
 * @param   bool    $show_deleted     (OPTIONAL)  If true, shows deleted users only.
 * @param   int     $activity_cutoff  (OPTIONAL)  If set, will only return users active since this many seconds.
 * @param   bool    $include_guests   (OPTIONAL)  If true, guests will be included in the user list.
 * @param   int     $max_guest_count  (OPTIONAL)  The number of guests to return (if guests are included, 0 for all).
 * @param   bool    $banned_only      (OPTIONAL)  If true, returns only banned users.
 * @param   bool    $include_ip_bans  (OPTIONAL)  If true, IP bans will be included in the banned_only user list.
 * @param   bool    $is_admin         (OPTIONAL)  Whether the current user is an administrator.
 * @param   bool    $is_activity      (OPTIONAL)  Whether the list will be used to display user activity.
 *
 * @return  array                                 A list of users, prepared for displaying.
 */

function users_list(  string  $sort_by          = ''      ,
                      array   $search           = array() ,
                      int     $max_count        = 0       ,
                      bool    $show_deleted     = false   ,
                      int     $activity_cutoff  = 0       ,
                      bool    $include_guests   = false   ,
                      int     $max_guest_count  = 0       ,
                      bool    $banned_only      = false   ,
                      bool    $include_ip_bans  = false   ,
                      bool    $is_admin         = false   ,
                      bool    $is_activity      = false   ) : array
{
  // Require special rights to run this action in special cases
  if($include_ip_bans)
    user_restrict_to_moderators();
  if($is_admin)
    user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  if($include_ip_bans)
    require_included_file('ban.act.php');

  // Sanitize and prepare the data
  $lang             = user_get_language();
  $sort_by          = sanitize($sort_by, 'string');
  $max_count        = sanitize($max_count, 'int', 0);
  $deleted          = sanitize($show_deleted, 'int', 0, 1);
  $activity_cutoff  = sanitize($activity_cutoff, 'int', 0);
  $include_guests   = sanitize($include_guests, 'int', 0, 1);
  $max_guest_count  = sanitize($max_guest_count, 'int', 0);
  $active_limit     = sanitize(time() - 2629746, 'int', 0);

  // Sanitize the search parameters
  $search_id          = sanitize_array_element($search, 'id', 'int', min: 0, default: 0);
  $search_username    = sanitize_array_element($search, 'username', 'string');
  $search_del_user    = sanitize_array_element($search, 'del_user', 'string');
  $search_registered  = sanitize_array_element($search, 'registered', 'int', min: 0, max: date('Y'), default: 0);
  $search_active      = sanitize_array_element($search, 'active', 'int', min: 0, max: 1, default: 0);
  $search_languages   = sanitize_array_element($search, 'languages', 'string');

  // Determine the activity cutoff
  $minimum_activity = sanitize((time() - $activity_cutoff), 'int', 0);

  // Hide user activity based on their settings
  $query_settings = ($is_activity && !$is_admin) ? " AND users_settings.hide_from_activity = 0 " : "";

  // Activity cutoff
  $query_settings .= ($activity_cutoff) ? " AND users.last_visited_at >= '$minimum_activity' " : "";

  // Banned users view
  $query_settings .= ($banned_only) ? " AND users.is_banned_until > 0 " : "";

  // Search through the data
  $query_search  = ($search_id)         ? " AND   users.id                          = '$search_id'          " : "";
  $query_search .= ($search_username)   ? " AND   users.username                 LIKE '%$search_username%'  " : "";
  $query_search .= ($search_del_user)   ? " AND   users.deleted_username         LIKE '%$search_del_user%'  " : "";
  $query_search .= ($search_registered) ? "
                          AND YEAR(FROM_UNIXTIME(users_profile.created_at))         = '$search_registered'  " : "";
  $query_search .= ($search_active)     ? " AND ( users.last_visited_at             > '$active_limit'
                                            OR    users_profile.created_at          > '$active_limit' )     " : "";
  $query_search .= ($search_languages)  ? " AND   users_profile.spoken_languages LIKE '%$search_languages%' " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'id'                => " ORDER BY users.id                                ASC   " ,
    'activity'          => " ORDER BY users.last_visited_at                   DESC  " ,
    'banned'            => " ORDER BY users.is_banned_until                   ASC   " ,
    'username'          => " ORDER BY users.username                          ASC   " ,
    'deleted_username'  => " ORDER BY users.deleted_username                  ASC   " ,
    'deleted'           => " ORDER BY users.deleted_at                        DESC  " ,
    'registered'        => " ORDER BY users_profile.created_at                DESC  " ,
    'rregistered'       => " ORDER BY users_profile.created_at                ASC   " ,
    'language'          => " ORDER BY users_profile.spoken_languages = 'ENFR' DESC  ,
                                      users_profile.spoken_languages = 'FREN' DESC  ,
                                      users_profile.spoken_languages = 'EN'   DESC  ,
                                      users_profile.spoken_languages = 'FR'   DESC  ,
                                      users.last_visited_at                   DESC  " ,
    default             => " ORDER BY users.id                                ASC   " ,
  };

  // Limit the amount of users returned
  $query_limit = ($max_count) ? " LIMIT $max_count " : "";

  // Fetch the user list
  $qusers = "       SELECT    'user'                          AS 'data_type'        ,
                              users.id                        AS 'u_id'             ,
                              users.is_deleted                AS 'u_deleted'        ,
                              users.deleted_at                AS 'u_deleted_at'     ,
                              users.deleted_username          AS 'u_deleted_nick'   ,
                              users.username                  AS 'u_nick'           ,
                              ''                              AS 'u_guest_name_en'  ,
                              ''                              AS 'u_guest_name_fr'  ,
                              users.is_administrator          AS 'u_admin'          ,
                              users.is_moderator              AS 'u_mod'            ,
                              users_profile.created_at        AS 'u_created'        ,
                              users.last_visited_at           AS 'u_activity'       ,
                              users.last_visited_page_en      AS 'u_last_page_en'   ,
                              users.last_visited_page_fr      AS 'u_last_page_fr'   ,
                              users.last_visited_url          AS 'u_last_url'       ,
                              users.current_ip_address        AS 'u_ip'             ,
                              users_profile.spoken_languages  AS 'u_languages'      ,
                              users.is_banned_since           AS 'u_ban_start'      ,
                              users.is_banned_until           AS 'u_ban_end'        ,
                              users.is_banned_because_en      AS 'u_ban_reason_en'  ,
                              users.is_banned_because_fr      AS 'u_ban_reason_fr'  ,
                              0                               AS 'u_ip_ban_id'      ,
                              0                               AS 'u_total_ip_ban'
                    FROM      users
                    LEFT JOIN users_settings  ON users.id = users_settings.fk_users
                    LEFT JOIN users_profile   ON users.id = users_profile.fk_users
                    WHERE     users.is_deleted = '$deleted'
                              $query_settings
                              $query_search
                              $query_sort
                              $query_limit ";

  // Include guests if necessary
  if($include_guests)
    $qusers = "     ( SELECT    'guest'                                 AS 'data_type'        ,
                                0                                       AS 'u_id'             ,
                                0                                       AS 'u_deleted'        ,
                                0                                       AS 'u_deleted_at'     ,
                                ''                                      AS 'u_deleted_nick'   ,
                                ''                                      AS 'u_nick'           ,
                                users_guests.randomly_assigned_name_en  AS 'u_guest_name_en'  ,
                                users_guests.randomly_assigned_name_fr  AS 'u_guest_name_fr'  ,
                                0                                       AS 'u_admin'          ,
                                0                                       AS 'u_mod'            ,
                                0                                       AS 'u_created'        ,
                                users_guests.last_visited_at            AS 'u_activity'       ,
                                users_guests.last_visited_page_en       AS 'u_last_page_en'   ,
                                users_guests.last_visited_page_fr       AS 'u_last_page_fr'   ,
                                users_guests.last_visited_url           AS 'u_last_url'       ,
                                users_guests.ip_address                 AS 'u_ip'             ,
                                ''                                      AS 'u_languages'      ,
                                0                                       AS 'u_ban_start'      ,
                                0                                       AS 'u_ban_end'        ,
                                ''                                      AS 'u_ban_reason_en'  ,
                                ''                                      AS 'u_ban_reason_fr'  ,
                                0                                       AS 'u_ip_ban_id'      ,
                                0                                       AS 'u_total_ip_ban'
                      FROM      users_guests
                      WHERE     users_guests.last_visited_at >= '$minimum_activity'
                      LIMIT     $max_guest_count )
                    UNION
                      ( ".$qusers." )
                    ORDER BY u_activity DESC ";

  // Include IP bans if necessary
  if($banned_only && $include_ip_bans)
    $qusers = "     ( SELECT    'ip_ban'                      AS 'data_type'            ,
                                0                             AS 'u_id'                 ,
                                0                             AS 'u_deleted'            ,
                                0                             AS 'u_deleted_at'         ,
                                ''                            AS 'u_deleted_nick'       ,
                                system_ip_bans.ip_address     AS 'u_nick'               ,
                                ''                            AS 'u_guest_name_en'      ,
                                ''                            AS 'u_guest_name_fr'      ,
                                0                             AS 'u_admin'              ,
                                0                             AS 'u_mod'                ,
                                0                             AS 'u_created'            ,
                                0                             AS 'u_activity'           ,
                                ''                            AS 'u_last_page_en'       ,
                                ''                            AS 'u_last_page_fr'       ,
                                ''                            AS 'u_last_url'           ,
                                system_ip_bans.ip_address     AS 'u_ip'                 ,
                                ''                            AS 'u_languages'          ,
                                system_ip_bans.banned_since   AS 'u_ban_start'          ,
                                system_ip_bans.banned_until   AS 'u_ban_end'            ,
                                system_ip_bans.ban_reason_en  AS 'u_ban_reason_en'      ,
                                system_ip_bans.ban_reason_fr  AS 'u_ban_reason_fr'      ,
                                system_ip_bans.id             AS 'u_ip_ban_id'          ,
                                system_ip_bans.is_a_total_ban AS 'u_total_ip_ban'
                      FROM      system_ip_bans )
                    UNION
                      ( ".$qusers." )
                    ORDER BY u_ban_end ASC ";

  // Run the query
  $qusers = query($qusers);

  // Initialize the returned array
  $data = array();

  // Fetch the user's display mode
  $mode = user_get_mode();

  // Go through the rows returned by query
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    // Prepare the data
    $data[$i]['type']       = sanitize_output($row['data_type']);
    $data[$i]['id']         = sanitize_output($row['u_id']);
    $data[$i]['deleted']    = sanitize_output($row['u_deleted']);
    $data[$i]['del_since']  = sanitize_output(time_since($row['u_deleted_at']));
    $data[$i]['del_nick']   = sanitize_output($row['u_deleted_nick']);
    $guest_name             = ($lang === 'EN') ? $row['u_guest_name_en'] : $row['u_guest_name_fr'];
    $data[$i]['username']   = ($row['data_type'] === 'guest')
                            ? sanitize_output($guest_name)
                            : sanitize_output($row['u_nick']);
    $data[$i]['registered'] = sanitize_output(time_since($row['u_created']));
    $data[$i]['created']    = sanitize_output(date_to_text($row['u_created'], include_time: 2));
    $user_activity          = ($row['u_activity']) ?: $row['u_created'];
    $data[$i]['activity']   = sanitize_output(time_since($user_activity));
    $data[$i]['active_at']  = sanitize_output(date_to_text($user_activity, include_time: 2));
    $data[$i]['last_page']  = ($lang === 'EN')
                            ? sanitize_output(string_truncate($row['u_last_page_en'], 40, '...'))
                            : sanitize_output(string_truncate($row['u_last_page_fr'], 40, '...'));
    $data[$i]['last_url']   = sanitize_output($row['u_last_url']);
    $data[$i]['ip']         = sanitize_output($row['u_ip']);
    $data[$i]['lang_en']    = str_contains($row['u_languages'], 'EN');
    $data[$i]['lang_fr']    = str_contains($row['u_languages'], 'FR');
    $data[$i]['ban_end']    = ($row['u_ban_end']) ? time_until($row['u_ban_end']) : '';
    $data[$i]['ban_endf']   = ($row['u_ban_end']) ? date_to_text($row['u_ban_end'], 0, 2) : '';
    $data[$i]['ban_start']  = ($row['u_ban_start']) ? time_since($row['u_ban_start']) : '';
    $data[$i]['ban_startf'] = ($row['u_ban_start']) ? date_to_text($row['u_ban_start'], 0, 2) : '';
    $data[$i]['ban_length'] = ($row['u_ban_end']) ? time_days_elapsed($row['u_ban_start'], $row['u_ban_end'], 1) : '';
    $data[$i]['ban_served'] = ($row['u_ban_end']) ? time_days_elapsed($row['u_ban_start'], time(), 1) : '';
    $ban_reason             = ($row['u_ban_reason_en']) ? $row['u_ban_reason_en'] : '';
    $ban_reason             = ($lang === 'FR' && $row['u_ban_reason_fr']) ? $row['u_ban_reason_fr'] : $ban_reason;
    $data[$i]['ban_reason'] = sanitize_output(string_truncate($ban_reason, 30, '...'));
    $data[$i]['ban_full']   = (strlen($ban_reason) > 30) ? sanitize_output($ban_reason) : '';
    $data[$i]['ip_ban_id']  = $row['u_ip_ban_id'];
    $data[$i]['ip_bans']    = ($row['data_type'] === 'ip_ban') ? admin_ip_ban_list_users($row['u_ip']) : '';
    $data[$i]['total_ban']  = ($row['u_total_ip_ban']);
    if($is_activity)
    {
      $user_css             = ($row['data_type'] === 'user') ? ' bold text_blue noglow' : ' noglow';
      $user_css             = ($row['u_mod']) ? ' bold text_orange noglow' : $user_css;
      $user_css             = ($row['u_admin']) ? ' bold text_red' : $user_css;
    }
    else if($include_ip_bans)
      $user_css             = ($row['u_total_ip_ban']) ? 'text_red glow_css' : 'noglow';
    else
    {
      $user_css             = ($row['u_activity']) ?: $row['u_created'];
      $user_css             = ($user_css > $active_limit) ? 'bold green text_white' : '';
      $user_css             = ($row['u_ban_end']) ? 'bold brown text_white' : $user_css;
      $user_css             = ($row['u_mod']) ? 'bold orange text_white'  : $user_css;
      $user_css             = ($row['u_admin']) ? 'bold red text_white'  : $user_css;
    }
    $data[$i]['css']        = $user_css;
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Fetches a list of administrative team members.
 *
 * @param   string  $sort_by  (OPTIONAL)  The way the list should be sorted.
 *
 * @return  array                         A list of administrative team members.
 */

function users_list_admins( string $sort_by = '' ) : array
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Sort the data
  $query_sort = match($sort_by)
  {
    'activity'  => " ORDER BY users.is_administrator  DESC  ,
                              users.last_visited_at   DESC  " ,
    default     => " ORDER BY users.is_administrator  DESC  ,
                              users.username          ASC   " ,
  };

  // Fetch the admin list
  $qadmins = query("  SELECT    users.id                        AS 'u_id'       ,
                                users.username                  AS 'u_nick'     ,
                                users.is_administrator          AS 'u_admin'    ,
                                users.is_moderator              AS 'u_mod'      ,
                                users.last_visited_at           AS 'u_activity' ,
                                users_profile.spoken_languages  AS 'u_languages'
                      FROM      users
                      LEFT JOIN users_profile ON users.id = users_profile.fk_users
                      WHERE     users.is_deleted        = 0
                      AND     ( users.is_administrator  = 1
                      OR        users.is_moderator      = 1 )
                                $query_sort ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qadmins); $i++)
  {
    $data[$i]['id']       = sanitize_output($row['u_id']);
    $data[$i]['username'] = sanitize_output($row['u_nick']);
    $data[$i]['admin']    = sanitize_output($row['u_admin']);
    $data[$i]['mod']      = sanitize_output($row['u_mod']);
    $data[$i]['title']    = ($row['u_admin'])
                          ? sanitize_output(string_change_case(__('administrator'), 'initials'))
                          : sanitize_output(string_change_case(__('moderator'), 'initials'));
    $data[$i]['activity'] = sanitize_output(time_since($row['u_activity']));
    $data[$i]['lang_en']  = str_contains($row['u_languages'], 'EN');
    $data[$i]['lang_fr']  = str_contains($row['u_languages'], 'FR');
    $data[$i]['css']      = ($row['u_admin']) ? 'text_red bold' : 'text_orange bold';
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Modifies a user's own public profile.
 *
 * @param   array   $user_data   The data to update on the user's profile.
 *
 * @return  void
 */

function users_edit_profile( array $user_data ) : void
{
  // Require the user to be logged in
  user_restrict_to_users();

  // Flood prevention
  flood_check();

  // Get the current user's ID
  $user_id = sanitize(user_get_id(), 'int');

  // Sanitize and assemble the data
  $languages        = ($user_data['lang_en']) ? 'EN' : '';
  $languages       .= ($user_data['lang_fr']) ? 'FR' : '';
  $languages        = sanitize($languages, 'string');
  $birthday         = str_pad($user_data['birth_year'], 4, 0, STR_PAD_LEFT).'-';
  $birthday        .= str_pad($user_data['birth_month'], 2, 0, STR_PAD_LEFT).'-';
  $birthday        .= str_pad($user_data['birth_day'], 2, 0, STR_PAD_LEFT);
  $birthday         = sanitize($birthday, 'string');
  $residence_raw    = $user_data['residence'];
  $residence        = sanitize(string_truncate($user_data['residence'], 50), 'string');
  $pronouns_en_raw  = $user_data['pronouns_en'];
  $pronouns_en      = sanitize(string_truncate($user_data['pronouns_en'], 50), 'string');
  $pronouns_fr_raw  = $user_data['pronouns_fr'];
  $pronouns_fr      = sanitize(string_truncate($user_data['pronouns_fr'], 50), 'string');
  $text_en_raw      = $user_data['text_en'];
  $text_en          = sanitize($user_data['text_en'], 'string');
  $text_fr_raw      = $user_data['text_fr'];
  $text_fr          = sanitize($user_data['text_fr'], 'string');

  // Fetch the current (soon to be previous) values before updating
  $old_user_data = mysqli_fetch_array(query(" SELECT  users_profile.spoken_languages AS 'u_lang'        ,
                                                      users_profile.birthday         AS 'u_birthday'    ,
                                                      users_profile.lives_at         AS 'u_residence'   ,
                                                      users_profile.pronouns_en      AS 'u_pronouns_en' ,
                                                      users_profile.pronouns_fr      AS 'u_pronouns_fr' ,
                                                      users_profile.profile_text_en  AS 'u_text_en'     ,
                                                      users_profile.profile_text_fr  AS 'u_text_fr'
                                              FROM    users_profile
                                              WHERE   users_profile.fk_users = '$user_id' "));

  // Update the user's profile
  query(" UPDATE  users_profile
          SET     users_profile.spoken_languages  = '$languages'    ,
                  users_profile.birthday          = '$birthday'     ,
                  users_profile.lives_at          = '$residence'    ,
                  users_profile.pronouns_en       = '$pronouns_en'  ,
                  users_profile.pronouns_fr       = '$pronouns_fr'  ,
                  users_profile.profile_text_en   = '$text_en'      ,
                  users_profile.profile_text_fr   = '$text_fr'
          WHERE   users_profile.fk_users          = '$user_id'      ");

  // Check for differences between the previous and new profiles
  if($languages !== $old_user_data['u_lang'])
    $differences['languages'] = 1;
  if($birthday !== $old_user_data['u_birthday'])
    $differences['birthday'] = 1;
  if($residence_raw !== $old_user_data['u_residence'])
    $differences['residence'] = 1;
  if($pronouns_en_raw !== $old_user_data['u_pronouns_en'])
    $differences['pronouns_en'] = 1;
  if($pronouns_fr_raw !== $old_user_data['u_pronouns_fr'])
    $differences['pronouns_fr'] = 1;
  if($text_en_raw !== $old_user_data['u_text_en'])
    $differences['text_en'] = 1;
  if($text_fr_raw !== $old_user_data['u_text_fr'])
    $differences['text_fr'] = 1;

  // If any differences have been spotted, notify the moderation team - just in case
  if(isset($differences))
  {
    // Get the user's nickname
    $username_raw = user_get_username();
    $username     = sanitize($username_raw, 'string');

    // Activity log
    $modlog = log_activity( 'users_profile_edit'      ,
                            is_moderators_only: true  ,
                            fk_users: $user_id        ,
                            username: $username       );

    // Detailed activity logs
    if(isset($differences['languages']))
      log_activity_details($modlog, 'Languages', 'Langues', $old_user_data['u_lang'], $languages);
    if(isset($differences['birthday']))
      log_activity_details($modlog, 'Birth date', 'Date de naissance', $old_user_data['u_birthday'], $birthday);
    if(isset($differences['residence']))
      log_activity_details($modlog, 'Location', 'Localisation', $old_user_data['u_residence'], $residence_raw);
    if(isset($differences['pronouns_en']))
      log_activity_details($modlog, 'Pronouns (EN)', 'Pronoms (EN)', $old_user_data['u_pronouns_en'], $pronouns_en_raw);
    if(isset($differences['pronouns_fr']))
      log_activity_details($modlog, 'Pronouns (FR)', 'Pronoms (FR)', $old_user_data['u_pronouns_fr'], $pronouns_en_raw);
    if(isset($differences['text_en']))
      log_activity_details($modlog, 'Free text (EN)', 'Texte libre (FR)', $old_user_data['u_text_en'], $text_en_raw);
    if(isset($differences['text_fr']))
      log_activity_details($modlog, 'Free text (FR)', 'Texte libre (FR)', $old_user_data['u_text_fr'], $text_fr_raw);

    // IRC bot message
    irc_bot_send_message("$username_raw has made changes to their public profile - ".$GLOBALS['website_url']."pages/users/".$user_id." - detailed logs are available - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');
  }

  // Done
  return;
}




/**
 * Deletes a user's public profile.
 *
 * @param   int     $user_id              The ID of the user whose public profile will be deleted.
 * @param   string  $fields   (OPTIONAL)  The list of fields to delete from their public profile.
 *
 * @return  void
 */

function users_delete_profile(  $user_id              ,
                                $fields     = array() ) : void
{
  // Check if the required files have been included
  require_included_file('users.lang.php');

  // Only moderators or above should run this action
  user_restrict_to_moderators();

  // End here if no fields are requested for deletion
  if(!$fields['country'] && !$fields['pronouns_en'] && !$fields['pronouns_fr'] && !$fields['text_en'] && !$fields['text_fr'])
    return;

  // Sanitize the user id
  $user_id = sanitize($user_id, 'int');

  // End here if the user doesn't exist
  if(!database_row_exists('users', $user_id))
    return;

  // Get the moderator's id
  $mod_id = sanitize(user_get_id(), 'int');

  // End here if the moderator is trying to delete their own profile
  if($user_id === $mod_id)
    return;

  // Prepare and sanitize the data
  $path         = root_path();
  $username     = user_get_username($user_id);
  $user_lang    = string_change_case(user_get_language($user_id), 'lowercase');
  $mod_username = user_get_username($mod_id);

  // Grab the values of the public profile fields before deleting them
  $profile_data = mysqli_fetch_array(query("  SELECT  users_profile.lives_at         AS 'u_country'     ,
                                                      users_profile.pronouns_en      AS 'u_pronouns_en' ,
                                                      users_profile.pronouns_fr      AS 'u_pronouns_fr' ,
                                                      users_profile.profile_text_en  AS 'u_text_en'     ,
                                                      users_profile.profile_text_fr  AS 'u_text_fr'
                                              FROM    users_profile
                                              WHERE   users_profile.fk_users = '$user_id' "));

  // Assemble the deletion query
  $delete_fields  = ($fields['country'])      ? " users_profile.lives_at        = '' ," : '';
  $delete_fields .= ($fields['pronouns_en'])  ? " users_profile.pronouns_en     = '' ," : '';
  $delete_fields .= ($fields['pronouns_fr'])  ? " users_profile.pronouns_fr     = '' ," : '';
  $delete_fields .= ($fields['text_en'])      ? " users_profile.profile_text_en = '' ," : '';
  $delete_fields .= ($fields['text_fr'])      ? " users_profile.profile_text_fr = '' ," : '';
  $delete_fields  = mb_substr($delete_fields, 0, -1);

  // Proceed with the deletion of requested fields
  query(" UPDATE  users_profile
          SET     $delete_fields
          WHERE   users_profile.fk_users = '$user_id' ");

  // Activity log
  $modlog = log_activity( 'users_admin_edit_profile'        ,
                          is_moderators_only: true          ,
                          fk_users: $user_id                ,
                          username: $username               ,
                          moderator_username: $mod_username );

  // Detailed activity logs
  if($fields['country'])
    log_activity_details($modlog, 'Location', 'Localisation', $profile_data['u_country']);
  if($fields['pronouns_en'])
    log_activity_details($modlog, 'Pronouns (EN)', 'Pronoms (EN)', $profile_data['u_pronouns_en']);
  if($fields['pronouns_fr'])
    log_activity_details($modlog, 'Pronouns (FR)', 'Pronoms (FR)', $profile_data['u_pronouns_fr']);
  if($fields['text_en'])
    log_activity_details($modlog, 'Custom text (EN)', 'Texte libre (EN)', $profile_data['u_text_en']);
  if($fields['text_fr'])
    log_activity_details($modlog, 'Custom text (FR)', 'Texte libre (FR)', $profile_data['u_text_fr']);

  // IRC bot message
  irc_bot_send_message("$mod_username has deleted parts of $username's public profile - ".$GLOBALS['website_url']."pages/users/".$user_id." - detailed logs are available - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Discord message
  discord_send_message("$mod_username has deleted parts of $username's public profile: ".$GLOBALS['website_url']."pages/users/".$user_id.PHP_EOL."Detailed logs are available: <".$GLOBALS['website_url']."pages/nobleme/activity?mod>", 'mod');

  // Private message
  private_message_send( __('users_profile_delete_pm_title_'.$user_lang)                                       ,
                        __('users_profile_delete_pm_body_'.$user_lang, preset_values: array($path, $user_id)) ,
                        recipient: $user_id                                                                   ,
                        hide_admin_mail: true                                                                 );

  // Done
  return;
}




/**
 * Fetches information related to a user's ban.
 *
 * @param   int    $user_id   (OPTIONAL)  The user's ID in the database. If null, fetches the current user's ID.
 *
 * @return  array                         An array of data regarding the ban.
 */

function users_ban_details( ?int $user_id = NULL ) : array
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // If no id is specified, grab the one currently stored in the session
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no id is stored in the session, then this is a guest and this shouldn't be happening, exit
  else if(!$user_id)
    exit();

  // Sanitize the id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch data regarding the ban
  $dban = mysqli_fetch_array(query("  SELECT  users.is_banned_since       AS 'u_ban_start'  ,
                                              users.is_banned_until       AS 'u_ban_end'    ,
                                              users.is_banned_because_en  AS 'u_ban_en'     ,
                                              users.is_banned_because_fr  AS 'u_ban_fr'
                                      FROM    users
                                      WHERE   users.id = '$user_id' "));

  // Prepare the data
  $lang               = user_get_language();
  $data['ban_start']  = sanitize_output(date_to_text($dban['u_ban_start'], 0, 0, $lang));
  $data['ban_length'] = time_days_elapsed(date('Y-m-d', $dban['u_ban_start']), date('Y-m-d', $dban['u_ban_end']));
  $data['ban_end']    = sanitize_output(date_to_text($dban['u_ban_end'], 0, 0, $lang).__('at_date', 0, 1 ,1)
                        .date('H:i:s', $dban['u_ban_end']));
  $data['time_left']  = sanitize_output(time_until($dban['u_ban_end']));
  $ban_reason         = ($dban['u_ban_fr']) ? sanitize_output($dban['u_ban_fr']) : sanitize_output($dban['u_ban_en']);
  $data['ban_reason'] = ($lang === 'EN') ? sanitize_output($dban['u_ban_en']) : $ban_reason;
  $data['ban_r_en']   = sanitize_output($dban['u_ban_en']);
  $data['ban_r_fr']   = sanitize_output($dban['u_ban_fr']);

  // Return the data
  return $data;
}




/**
 * Checks if a username currently exists in the database.
 *
 * @param   string  $username   The username to check.
 *
 * @return  bool                Whether the username exists.
 */

function users_check_username( string $username ) : bool
{
  // Sanitize the data
  $username = sanitize($username, 'string');

  // Look for the username
  $dusername = mysqli_fetch_array(query(" SELECT  users.id  AS 'u_id'
                                          FROM    users
                                          WHERE   users.username LIKE '$username' "));

  // Return the result
  return isset($dusername['u_id']);
}




/**
 * Checks if a username is illegal.
 *
 * @param   string  $username   The username to check.
 *
 * @return  bool                Whether the username is illegal on the website.
 */

function users_check_username_illegality( string $username ) : bool
{
  // Define a list of badwords
  $bad_words = array('admin', 'biatch', 'bitch', 'coon', 'fagg', 'kike', 'moderat', 'nigg', 'offici', 'putain', 'salope', 'trann', 'whore');

  // Check if the username matches any of the bad words
  $is_illegal = 0;
  foreach($bad_words as $bad_word)
    $is_illegal = (mb_strpos(string_change_case($username, 'lowercase'), $bad_word) !== false) ? 1 : $is_illegal;

  // Return the result
  return $is_illegal;
}




/**
 * Autocompletes a username.
 *
 * @param   string      $input              The input that needs to be autocompleted.
 * @param   string      $type   (OPTIONAL)  The type of autocomplete query we're making (eg. 'normal', 'ban', 'unban')
 * @param   int         $id     (OPTIONAL)  An ID to use along with the type (eg. a meetup id)
 *
 * @return  array|null                      An array containing the autocomplete data, or NULL if something went wrong.
 */

function users_autocomplete_username( string  $input        ,
                                      string  $type   = ''  ,
                                      int     $id     = 0   ) : mixed
{
  // Sanitize the input
  $input  = sanitize($input, 'string');
  $id     = sanitize($id, 'int', 0);
  $join   = '';
  $where  = '';

  // Only work when more than 1 character has been submitted
  if(mb_strlen($input) < 1)
    return NULL;

  // Exclude banned users if required
  if($type === 'ban')
    $where .= " AND users.is_banned_until = 0 ";
  else if($type === 'unban')
    $where .= " AND users.is_banned_until > 0 ";

  // Look up a specific meetup if required
  if($type === 'meetup')
  {
    $join  .= " LEFT JOIN meetups_people ON meetups_people.fk_meetups = '$id' AND meetups_people.fk_users = users.id ";
    $where .= " AND meetups_people.id IS NULL ";
  }

  // Look for usernames to add to autocompletion
  $qusernames = query(" SELECT    users.username AS 'u_nick'
                        FROM      users
                                  $join
                        WHERE     users.is_deleted  =     0
                        AND       users.username    LIKE  '$input%'
                                  $where
                        ORDER BY  users.username  ASC
                        LIMIT     10 ");

  // Prepare the returned data
  for($i = 0; $dusernames = mysqli_fetch_array($qusernames); $i++)
    $data[$i]['nick'] = sanitize_output($dusernames['u_nick']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns the number of users stored in the database.
 *
 * @return  int   The number of users.
 */

function users_total_count() : int
{
  // Fetch the user count
  $duser = mysqli_fetch_array(query(" SELECT  COUNT(*) AS 'u_count'
                                      FROM    users "));

  // Return the user count
  return $duser['u_count'];
}




/**
 * Returns the number of guests stored in the database.
 *
 * @return  int   The number of guests.
 */

function users_guests_count() : int
{
  // Fetch the guest count
  $dguest = mysqli_fetch_array(query("  SELECT  COUNT(*) AS 'g_count'
                                        FROM    users_guests "));

  // Return the guest count
  return $dguest['g_count'];
}




/**
 * Returns for how long guests are currently being stored in the database.
 *
 * @return  int   The number of days for which the oldest guest has been stored in the database.
 */

function users_guests_storage_length() : int
{
  // Fetch the oldest guest
  $dguest = mysqli_fetch_array(query("  SELECT    users_guests.last_visited_at AS 'g_date'
                                        FROM      users_guests
                                        WHERE     users_guests.last_visited_at > 0
                                        ORDER BY  users_guests.last_visited_at ASC
                                        LIMIT     1 "));

  // Calculate the days since the guest's last visit
  $delay = (!isset($dguest['g_date'])) ? 0 : time_days_elapsed($dguest['g_date'], time(), use_timestamps: true);

  // Return the delay
  return $delay;
}




/**
 * Returns stats related to users.
 *
 * @return  array   An array of stats related to users.
 */

function users_stats_list() : array
{
  // Check if the required files have been included
  require_included_file('functions_numbers.inc.php');
  require_included_file('functions_time.inc.php');

  // Initialize the return array
  $data = array();

  // Fetch the total number of users
  $dusers = mysqli_fetch_array(query("  SELECT  COUNT(*)                    AS 'u_total'    ,
                                                SUM(users.is_deleted)       AS 'u_deleted'  ,
                                                SUM(users.is_administrator) AS 'u_admin'    ,
                                                SUM(users.is_moderator)     AS 'u_mod'      ,
                                                SUM(CASE  WHEN  users.is_banned_until > 0 THEN  1
                                                          ELSE  0 END)      AS 'u_banned'
                                        FROM    users "));

  // Add some stats to the return array
  $data['total']    = sanitize_output($dusers['u_total']);
  $data['banned']   = sanitize_output($dusers['u_banned']);
  $data['deleted']  = sanitize_output($dusers['u_deleted']);
  $data['admins']   = sanitize_output($dusers['u_admin']);
  $data['mods']     = sanitize_output($dusers['u_mod']);

  // Fetch account creations by year
  $qusers = query(" SELECT    YEAR(FROM_UNIXTIME(users_profile.created_at)) AS 'up_created' ,
                              COUNT(*)                                      AS 'up_count'
                    FROM      users_profile
                    WHERE     users_profile.created_at > 0
                    GROUP BY  up_created
                    ORDER BY  up_created ASC ");

  // Prepare to identify the oldest account creation year
  $oldest_year = date('Y');

  // Add account creation data over time to the return data
  while($dusers = mysqli_fetch_array($qusers))
  {
    $year                   = $dusers['up_created'];
    $oldest_year            = ($year < $oldest_year) ? $year : $oldest_year;
    $data['created_'.$year] = ($dusers['up_count']) ? sanitize_output($dusers['up_count']) : '-';
  }

  // Ensure every year has an entry until the current one
  for($i = $oldest_year; $i <= date('Y'); $i++)
    $data['created_'.$i] ??= '-';

  // Add the oldest account creation year to the return data
  $data['oldest_account'] = $oldest_year;

  // Fetch user contributions
  $qusers = query(" SELECT    SUM(  users_stats.quotes_approved
                                  + users_stats.tasks_submitted ) AS 'us_contrib'   ,
                              users_stats.quotes_submitted        AS 'us_quotes_s'  ,
                              users_stats.quotes_approved         AS 'us_quotes_a'  ,
                              users_stats.tasks_submitted         AS 'us_tasks'     ,
                              users.id                            AS 'u_id'         ,
                              users.username                      AS 'u_nick'
                    FROM      users_stats
                    LEFT JOIN users ON users_stats.fk_users = users.id
                    WHERE     ( users_stats.quotes_approved
                              + users_stats.tasks_submitted ) > 0
                    GROUP BY  users_stats.fk_users
                    ORDER BY  us_contrib      DESC  ,
                              users.username  ASC   ");

  // Loop through contributions and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    $data['contrib_id_'.$i]       = sanitize_output($row['u_id']);
    $data['contrib_nick_'.$i]     = sanitize_output($row['u_nick']);
    $data['contrib_total_'.$i]    = sanitize_output($row['us_contrib']);
    $data['contrib_quotes_s_'.$i] = ($row['us_quotes_s']) ? sanitize_output($row['us_quotes_s']) : '';
    $data['contrib_quotes_a_'.$i] = ($row['us_quotes_a']) ? sanitize_output($row['us_quotes_a']) : '';
    $data['contrib_tasks_'.$i]    = ($row['us_tasks']) ? sanitize_output($row['us_tasks']) : '';
  }

  // Add the number of contributors to the return array
  $data['contrib_count'] = $i;

  // Fetch anniversaries
  $qusers = query(" SELECT    users_profile.created_at                AS 'up_date'  ,
                              FROM_UNIXTIME(users_profile.created_at) AS 'up_anniv' ,
                              ( TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(users_profile.created_at), CURDATE())
                              + 1 )                                   AS 'up_years' ,
                              DATE_ADD(FROM_UNIXTIME(users_profile.created_at) ,
                              INTERVAL YEAR(FROM_DAYS(DATEDIFF(CURDATE(), FROM_UNIXTIME(users_profile.created_at))-1))
                              + 1 YEAR)                               AS 'up_next'  ,
                              users.id                                AS 'u_id'     ,
                              users.username                          AS 'u_nick'
                    FROM      users_profile
                    LEFT JOIN users ON users_profile.fk_users = users.id
                    ORDER BY  CONCAT(SUBSTR(up_anniv, 6) < SUBSTR(CURDATE(), 6), SUBSTR(up_anniv, 6)) ASC
                    LIMIT     100 ");

  // Loop through anniversaries and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    $data['anniv_id_'.$i]       = sanitize_output($row['u_id']);
    $data['anniv_nick_'.$i]     = sanitize_output($row['u_nick']);
    $data['anniv_years_'.$i]    = sanitize_output($row['up_years'].number_ordinal($row['up_years']));
    $data['anniv_date_'.$i]     = sanitize_output(date_to_text($row['up_date'], strip_day: 1));
    $anniversary_days           = time_days_elapsed(date('Y-m-d', time()), substr($row['up_next'], 0, 10));
    $data['anniv_days_'.$i]     = ($anniversary_days) ? sanitize_output($anniversary_days) : __('emoji_tada');
    $data['anniv_css_row_'.$i]  = ($anniversary_days) ? '' : ' class="text_white green"';
    $data['anniv_css_link_'.$i] = ($anniversary_days) ? 'bold' : 'text_white bold';
  }

  // Add the number of anniversaries to the return array
  $data['anniv_count'] = $i;

  // Fetch birthdays
  $qusers = query(" SELECT    users_profile.birthday                  AS 'up_birthday'  ,
                              YEAR(users_profile.birthday)            AS 'up_year'      ,
                              ( TIMESTAMPDIFF(YEAR, users_profile.birthday, CURDATE())
                              + 1 )                                   AS 'up_years'     ,
                              DATE_ADD(users_profile.birthday ,
                              INTERVAL YEAR(FROM_DAYS(DATEDIFF(CURDATE(), users_profile.birthday)-1))
                              + 1 YEAR)                               AS 'up_next'      ,
                              users.id                                AS 'u_id'         ,
                              users.username                          AS 'u_nick'
                    FROM      users_profile
                    LEFT JOIN users ON users_profile.fk_users = users.id
                    WHERE     users_profile.birthday        != '0000-00-00'
                    AND       YEAR(users_profile.birthday)  <  YEAR(CURDATE())
                    AND       MONTH(users_profile.birthday) > 0
                    AND       DAY(users_profile.birthday)   > 0
                    ORDER BY  CONCAT(SUBSTR(up_birthday, 6) < SUBSTR(CURDATE(), 6), SUBSTR(up_birthday, 6)) ASC
                    LIMIT     10 ");

  // Loop through birthdays and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    $data['birth_id_'.$i]       = sanitize_output($row['u_id']);
    $data['birth_nick_'.$i]     = sanitize_output($row['u_nick']);
    $user_upcoming_age          = ($row['up_next'] === date('Y-m-d', time()))
                                ? ($row['up_years']-1).__('year_age', amount: ($row['up_years']-1), spaces_before: 1)
                                : $row['up_years'].__('year_age', amount: $row['up_years'], spaces_before: 1);
    $data['birth_years_'.$i]    = ($row['up_year']) ? sanitize_output($user_upcoming_age) : '?';
    $data['birth_date_'.$i]     = ($row['up_year'])
                                ? sanitize_output(date_to_text($row['up_birthday'], strip_day: true))
                                : sanitize_output(date_to_text($row['up_birthday'], strip_day: true, strip_year: true)
                                                  .' ????');
    $user_days_to_bday          = time_days_elapsed(date('Y-m-d', time()), substr($row['up_next'], 0, 10));
    $data['birth_days_'.$i]     = ($user_days_to_bday) ? sanitize_output($user_days_to_bday) : __('emoji_tada');
    $data['birth_css_row_'.$i]  = ($user_days_to_bday) ? '' : ' class="text_white green"';
    $data['birth_css_link_'.$i] = ($user_days_to_bday) ? 'bold' : 'text_white bold';
  }

  // Add the number of birthdays to the return array
  $data['birth_count'] = $i;

  // Return the stats
  return $data;
}