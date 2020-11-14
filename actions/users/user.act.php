<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  user_list                           Fetches a list of users.                                                     */
/*                                                                                                                   */
/*  user_ban_details                    Fetches information related to a user's ban.                                 */
/*                                                                                                                   */
/*  user_check_username                 Checks if a username currently exists in the database.                       */
/*  user_check_username_illegality      Checks if a username is illegal.                                             */
/*                                                                                                                   */
/*  user_autocomplete_nickname          Autocompletes a nickname.                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

 /**
 * Fetches a list of users.
 *
 * @param   string|null $sort_by          OPTIONAL  The way the user list should be sorted.
 * @param   array|null  $search           OPTIONAL  Search for specific field values.
 * @param   int|null    $max_count        OPTIONAL  The number of users to return (0 for unlimited).
 * @param   bool|null   $deleted          OPTIONAL  If set, shows deleted users only.
 * @param   int|null    $activity_cutoff  OPTIONAL  If set, will only return users active since this many seconds.
 * @param   bool|null   $include_guests   OPTIONAL  If set, guests will be included in the user list.
 * @param   int|null    $max_guest_count  OPTIONAL  The number of guests to return (if guests are included, 0 for all).
 * @param   int|null    $banned_only      OPTIONAL  If set, returns only banned users.
 * @param   int|null    $include_ip_bans  OPTIONAL  If set, IP bans will be included in the banned_only user list.
 * @param   int|null    $is_admin         OPTIONAL  Whether the current user is an administrator.
 * @param   int|null    $is_activity      OPTIONAL  Whether the list will be used to display user activity.
 * @param   string|null $lang             OPTIONAL  The language currently in use.
 *
 * @return  array                                   A list of users, prepared for displaying.
 */

function user_list( $sort_by          = ''    ,
                    $search           = NULL  ,
                    $max_count        = 0     ,
                    $deleted          = 0     ,
                    $activity_cutoff  = 0     ,
                    $include_guests   = 0     ,
                    $max_guest_count  = 0     ,
                    $banned_only      = 0     ,
                    $include_ip_bans  = 0     ,
                    $is_admin         = 0     ,
                    $is_activity      = 0     ,
                    $lang             = 'EN'  )
{
  // Require special rights to run this action in special cases
  if($include_ip_bans)
    user_restrict_to_moderators($lang);
  if($is_admin)
    user_restrict_to_administrators($lang);

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  if($include_ip_bans)
    require_included_file('ban.act.php');

  // Sanitize the data
  $sort_by          = sanitize($sort_by, 'string');
  $max_count        = sanitize($max_count, 'int', 0);
  $deleted          = sanitize($deleted, 'int', 0, 1);
  $activity_cutoff  = sanitize($activity_cutoff, 'int', 0);
  $include_guests   = sanitize($include_guests, 'int', 0, 1);
  $max_guest_count  = sanitize($max_guest_count, 'int', 0);

  // Prepare data
  $minimum_activity = sanitize((time() - $activity_cutoff), 'int', 0);

  // Initialize the returned array
  $data = array();

  // Fetch the user list
  $qusers = "       SELECT    'user'                      AS 'data_type'        ,
                              users.id                    AS 'u_id'             ,
                              users.is_deleted            AS 'u_deleted'        ,
                              users.deleted_at            AS 'u_deleted_at'     ,
                              users.deleted_nickname      AS 'u_deleted_nick'   ,
                              users.nickname              AS 'u_nick'           ,
                              ''                          AS 'u_guest_name_en'  ,
                              ''                          AS 'u_guest_name_fr'  ,
                              users.is_administrator      AS 'u_admin'          ,
                              users.is_moderator          AS 'u_mod'            ,
                              users.last_visited_at       AS 'u_activity'       ,
                              users.last_visited_page_en  AS 'u_last_page_en'   ,
                              users.last_visited_page_fr  AS 'u_last_page_fr'   ,
                              users.last_visited_url      AS 'u_last_url'       ,
                              users.current_ip_address    AS 'u_ip'             ,
                              users.is_banned_since       AS 'u_ban_start'      ,
                              users.is_banned_until       AS 'u_ban_end'        ,
                              users.is_banned_because_en  AS 'u_ban_reason_en'  ,
                              users.is_banned_because_fr  AS 'u_ban_reason_fr'  ,
                              0                           AS 'u_ip_ban_id'      ,
                              0                           AS 'u_total_ip_ban'
                    FROM      users
                    LEFT JOIN users_settings ON users.id = users_settings.fk_users
                    WHERE     users.is_deleted                  = '$deleted'            ";

  // Hide user activity based on their settings
  if($is_activity && !$is_admin)
    $qusers .= "    AND       users_settings.hide_from_activity = 0                     ";

  // Activity cutoff
  if($activity_cutoff)
    $qusers .= "    AND       users.last_visited_at             >= '$minimum_activity'  ";

  // Banned users view
  if($banned_only)
    $qusers .= "    AND       users.is_banned_until             > 0                     ";

  // Sanitize the search parameters
  $search_id        = isset($search['id'])        ? sanitize($search['id'], 'int', 0)       : NULL;
  $search_username  = isset($search['username'])  ? sanitize($search['username'], 'string') : NULL;
  $search_del_user  = isset($search['del_user'])  ? sanitize($search['del_user'], 'string') : NULL;

  // Run the searches
  if($search_id)
    $qusers .= "    AND       users.id                          = '$search_id'          ";
  if($search_username)
    $qusers .= "    AND       users.nickname                 LIKE '%$search_username%'  ";
  if($search_del_user)
    $qusers .= "    AND       users.deleted_nickname         LIKE '%$search_del_user%'  ";

  // Sort the users
  if(!$include_guests)
  {
    if($sort_by == 'activity')
      $qusers .= "  ORDER BY  users.last_visited_at   DESC  ";
    else if($sort_by == 'banned')
      $qusers .= "  ORDER BY  users.is_banned_until   ASC   ";
    else if($sort_by == 'username')
      $qusers .= "  ORDER BY  users.nickname          ASC   ";
    else if($sort_by == 'deleted_username')
      $qusers .= "  ORDER BY  users.deleted_nickname  ASC   ";
    else if($sort_by == 'deleted')
      $qusers .= "  ORDER BY  users.deleted_at        DESC  ";
    else
      $qusers .= "  ORDER BY  users.id                ASC   ";
  }

  // Limit the amount of users returned
  if($max_count)
    $qusers .= "    LIMIT $max_count ";

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
                                users_guests.last_visited_at            AS 'u_activity'       ,
                                users_guests.last_visited_page_en       AS 'u_last_page_en'   ,
                                users_guests.last_visited_page_fr       AS 'u_last_page_fr'   ,
                                users_guests.last_visited_url           AS 'u_last_url'       ,
                                users_guests.ip_address                 AS 'u_ip'             ,
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
                                0                             AS 'u_activity'           ,
                                ''                            AS 'u_last_page_en'       ,
                                ''                            AS 'u_last_page_fr'       ,
                                ''                            AS 'u_last_url'           ,
                                system_ip_bans.ip_address     AS 'u_ip'                 ,
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

  // Go through the rows returned by query
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    // Prepare the data
    $data[$i]['type']       = sanitize_output($row['data_type']);
    $data[$i]['id']         = sanitize_output($row['u_id']);
    $data[$i]['deleted']    = sanitize_output($row['u_deleted']);
    $data[$i]['del_since']  = sanitize_output(time_since($row['u_deleted_at']));
    $data[$i]['del_nick']   = sanitize_output($row['u_deleted_nick']);
    $temp                   = ($lang == 'EN') ? $row['u_guest_name_en'] : $row['u_guest_name_fr'];
    $temp                   = ($row['data_type'] == 'guest') ? $temp : $row['u_nick'];
    $data[$i]['nickname']   = sanitize_output($temp);
    $data[$i]['activity']   = time_since($row['u_activity']);
    $temp                   = ($lang == 'EN') ? $row['u_last_page_en'] : $row['u_last_page_fr'];
    $data[$i]['last_page']  = sanitize_output(string_truncate($temp, 50, '...'));
    $data[$i]['last_url']   = sanitize_output($row['u_last_url']);
    $data[$i]['ip']         = sanitize_output($row['u_ip']);
    $data[$i]['ban_end']    = ($row['u_ban_end']) ? time_until($row['u_ban_end']) : '';
    $data[$i]['ban_endf']   = ($row['u_ban_end']) ? date_to_text($row['u_ban_end'], 0, 1) : '';
    $data[$i]['ban_start']  = ($row['u_ban_start']) ? time_since($row['u_ban_start']) : '';
    $data[$i]['ban_startf'] = ($row['u_ban_start']) ? date_to_text($row['u_ban_start'], 0, 1) : '';
    $data[$i]['ban_length'] = ($row['u_ban_end']) ? time_days_elapsed($row['u_ban_start'], $row['u_ban_end'], 1) : '';
    $data[$i]['ban_served'] = ($row['u_ban_end']) ? time_days_elapsed($row['u_ban_start'], time(), 1) : '';
    $temp                   = ($row['u_ban_reason_en']) ? $row['u_ban_reason_en'] : '';
    $temp                   = ($lang == 'FR' && $row['u_ban_reason_fr']) ? $row['u_ban_reason_fr'] : $temp;
    $data[$i]['ban_reason'] = sanitize_output(string_truncate($temp, 30, '...'));
    $data[$i]['ban_full']   = (strlen($temp) > 30) ? sanitize_output($temp) : '';
    $data[$i]['ip_ban_id']  = $row['u_ip_ban_id'];
    $data[$i]['ip_bans']    = ($row['data_type'] == 'ip_ban') ? admin_ip_ban_list_users($row['u_ip'], $lang) : '';
    $data[$i]['total_ban']  = ($row['u_total_ip_ban']) ? 1 : 0;
    $temp                   = ($row['data_type'] == 'user') ? ' bold noglow' : ' noglow';
    $temp                   = ($row['u_mod']) ? ' bold text_orange noglow' : $temp;
    $temp                   = ($row['u_admin']) ? ' bold text_red' : $temp;
    $temp                   = ($row['u_total_ip_ban']) ? 'text_red' : $temp;
    $data[$i]['css']        = $temp;
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'users/user.act.php', 'function' => 'user_list', 'data' => $data));

  // Return the prepared data
  return $data;
}




/**
 * Fetches information related to a user's ban.
 *
 * @param   string|null $lang     The language currently in use.
 * @param   int|null    $user_id  The user's ID in the database. If null, fetches the current user's ID.
 *
 * @return  array                 An array of data regarding the ban.
 */

function user_ban_details(  $lang     = 'EN'  ,
                            $user_id  = NULL  )
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
  $data['ban_start']  = sanitize_output(date_to_text($dban['u_ban_start'], 0, 0, $lang));
  $data['ban_length'] = time_days_elapsed(date('Y-m-d', $dban['u_ban_start']), date('Y-m-d', $dban['u_ban_end']));
  $data['ban_end']    = sanitize_output(date_to_text($dban['u_ban_end'], 0, 0, $lang).__('at_date', 0, 1 ,1).date('H:i:s', $dban['u_ban_end']));
  $data['time_left']  = sanitize_output(time_until($dban['u_ban_end']));
  $temp               = ($dban['u_ban_fr']) ? sanitize_output($dban['u_ban_fr']) : sanitize_output($dban['u_ban_en']);
  $data['ban_reason'] = ($lang == 'EN') ? sanitize_output($dban['u_ban_en']) : $temp;
  $data['ban_r_en']   = sanitize_output($dban['u_ban_en']);
  $data['ban_r_fr']   = sanitize_output($dban['u_ban_fr']);

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'users/users.act.php', 'function' => 'user_ban_details', 'data' => $data));

  // Return the data
  return $data;
}




/**
 * Checks if a username currently exists in the database.
 *
 * @param   string  $username The username to check.
 *
 * @return  bool              Whether the username exists.
 */

function user_check_username($username)
{
  // Sanitize the data
  $username = sanitize($username, 'string');

  // Look for the username
  $dusername = mysqli_fetch_array(query(" SELECT  users.id  AS 'u_id'
                                          FROM    users
                                          WHERE   users.nickname LIKE '$username' "));

  // Return the result
  return isset($dusername['u_id']);
}




/**
 * Checks if a username is illegal.
 *
 * @param   string  $username The username to check.
 *
 * @return  bool              Whether the username is illegal on the website.
 */

function user_check_username_illegality($username)
{
  // Define a list of badwords
  $bad_words = array('admin', 'biatch', 'bitch', 'coon', 'fagg', 'kike', 'moderat', 'nigg', 'offici', 'trann', 'whore');

  // Check if the username matches any of the bad words
  $is_illegal = 0;
  foreach($bad_words as $bad_word)
    $is_illegal = (mb_strpos(string_change_case($username, 'lowercase'), $bad_word) !== false) ? 1 : $is_illegal;

  // Return the result
  return $is_illegal;
}




/**
 * Autocompletes a nickname.
 *
 * @param   string      $input              The input that needs to be autocompleted.
 * @param   string|null $type   (OPTIONAL)  The type of autocomplete query we're making (eg. 'normal', 'ban', 'unban')
 *
 * @return  array                           An array containing all the data required to autocomplete the nickname.
 */

function user_autocomplete_nickname(  $input          ,
                                      $type   = NULL  )
{
  // Sanitize the input
  $input_raw  = $input;
  $input      = sanitize($input, 'string');
  $where      = '';

  // Only work when more than 1 character has been input
  if(mb_strlen($input) < 1)
    return;

  // Exclude banned users if required
  if($type == 'ban')
    $where .= ' AND users.is_banned_until = 0 ';
  else if($type == 'unban')
    $where .= ' AND users.is_banned_until > 0 ';

  // Look for nicknames to add to autocompletion
  $qnicknames = query(" SELECT    users.nickname AS 'u_nick'
                        FROM      users
                        WHERE     is_deleted      =     0
                        AND       users.nickname  LIKE  '$input%'
                                  $where
                        ORDER BY  users.nickname  ASC
                        LIMIT     10 ");

  // Prepare the returned data
  for($i = 0; $dnicknames = mysqli_fetch_array($qnicknames); $i++)
    $data[$i]['nick'] = sanitize_output($dnicknames['u_nick']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}