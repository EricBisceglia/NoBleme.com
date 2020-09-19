<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       USERS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

 /**
 * Fetches a list of users.
 *
 * @param   string|null $sort_by          OPTIONAL  The way the user list should be sorted.
 * @param   int|null    $max_count        OPTIONAL  The number of users to return (0 for unlimited).
 * @param   bool|null   $deleted          OPTIONAL  If set, shows deleted users only.
 * @param   int|null    $activity_cutoff  OPTIONAL  If set, will only return users active since this many seconds.
 * @param   bool|null   $include_guests   OPTIONAL  If set, guests will be included in the user list.
 * @param   int|null    $max_guest_count  OPTIONAL  The number of guests to return (if guests are included, 0 for all).
 * @param   int|null    $banned_only      OPTIONAL  If set, returns only banned users.
 * @param   int|null    $is_admin         OPTIONAL  Whether the current user is an administrator.
 * @param   int|null    $is_activity      OPTIONAL  Whether the list will be used to display user activity.
 * @param   string|null $lang             OPTIONAL  The language currently in use.
 *
 * @return  array                                   A list of users, prepared for displaying.
 */

function users_get_list(  $sort_by          = ''    ,
                          $max_count        = 0     ,
                          $deleted          = 0     ,
                          $activity_cutoff  = 0     ,
                          $include_guests   = 0     ,
                          $max_guest_count  = 0     ,
                          $banned_only      = 0     ,
                          $is_admin         = 0     ,
                          $is_activity      = 0     ,
                          $lang             = 'EN'  )
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

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
                              users.nickname              AS 'u_nick'           ,
                              ''                          AS 'u_guest_name_en'  ,
                              ''                          AS 'u_guest_name_fr'  ,
                              users.is_administrator      AS 'u_admin'          ,
                              users.is_moderator          AS 'u_mod'            ,
                              users.last_visited_at       AS 'u_activity'       ,
                              users.last_visited_page_en  AS 'u_last_page_en'   ,
                              users.last_visited_page_fr  AS 'u_last_page_fr'   ,
                              users.last_visited_url      AS 'u_last_url'       ,
                              users.is_banned_since       AS 'u_ban_start'      ,
                              users.is_banned_until       AS 'u_ban_end'        ,
                              users.is_banned_because_en  AS 'u_ban_reason_en'  ,
                              users.is_banned_because_fr  AS 'u_ban_reason_fr'
                    FROM      users
                    LEFT JOIN users_settings ON users.id = users_settings.fk_users
                    WHERE     users.is_deleted                  = '$deleted' ";

  // Hide user activity based on their settings
  if($is_activity && !$is_admin)
    $qusers .= "    AND       users_settings.hide_from_activity = 0 ";

  // Activity cutoff
  if($activity_cutoff)
    $qusers .= "    AND       users.last_visited_at             >= '$minimum_activity' ";

  // Banned users view
  if($banned_only)
    $qusers .= "    AND       users.is_banned_until             > 0 ";

  // Sort the users
  if(!$include_guests)
  {
    if($sort_by == 'activity')
      $qusers .= "  ORDER BY  users.last_visited_at DESC ";
    if($sort_by == 'banned')
      $qusers .= "  ORDER BY  users.is_banned_until ASC ";
    else
      $qusers .= "  ORDER BY  users.id ASC ";
  }

  // Limit the amount of users returned
  if($max_count)
    $qusers .= "    LIMIT $max_count ";

  // Include guests if necessary
  if($include_guests)
    $qusers = "     ( SELECT    'guest'                                 AS 'data_type'        ,
                                0                                       AS 'u_id'             ,
                                ''                                      AS 'u_nick'           ,
                                users_guests.randomly_assigned_name_en  AS 'u_guest_name_en'  ,
                                users_guests.randomly_assigned_name_fr  AS 'u_guest_name_fr'  ,
                                0                                       AS 'u_admin'          ,
                                0                                       AS 'u_mod'            ,
                                users_guests.last_visited_at            AS 'u_activity'       ,
                                users_guests.last_visited_page_en       AS 'u_last_page_en'   ,
                                users_guests.last_visited_page_fr       AS 'u_last_page_fr'   ,
                                users_guests.last_visited_url           AS 'u_last_url'       ,
                                0                                       AS 'u_ban_start'      ,
                                0                                       AS 'u_ban_end'        ,
                                ''                                      AS 'u_ban_reason_en'  ,
                                ''                                      AS 'u_ban_reason_fr'
                      FROM      users_guests
                      WHERE     users_guests.last_visited_at >= '$minimum_activity'
                      LIMIT     $max_guest_count )
                    UNION
                      ( ".$qusers." )
                    ORDER BY u_activity DESC ";

  // Run the query
  $qusers = query($qusers);

  // Go through the rows returned by query
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    // Prepare the data
    $data[$i]['type']       = $row['data_type'];
    $data[$i]['id']         = $row['u_id'];
    $temp                   = ($lang == 'EN') ? $row['u_guest_name_en'] : $row['u_guest_name_fr'];
    $data[$i]['nickname']   = ($row['data_type'] == 'user') ? sanitize_output($row['u_nick']) : $temp;
    $data[$i]['activity']   = time_since($row['u_activity']);
    $temp                   = ($lang == 'EN') ? $row['u_last_page_en'] : $row['u_last_page_fr'];
    $data[$i]['last_page']  = sanitize_output(string_truncate($temp, 50, '...'));
    $data[$i]['last_url']   = sanitize_output($row['u_last_url']);
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
    $temp                   = ($row['data_type'] == 'user') ? ' bold noglow' : ' noglow';
    $temp                   = ($row['u_mod']) ? ' bold text_orange noglow' : $temp;
    $temp                   = ($row['u_admin']) ? ' bold text_red' : $temp;
    $data[$i]['css']        = $temp;
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('users.act.php', 'users_get_list', $data));

  // Return the prepared data
  return $data;
}




/**
 * Checks if a username currently exists in the database.
 *
 * @param   string  $username The username to check.
 *
 * @return  bool              Whether the username exists.
 */

function users_check_username($username)
{
  // Sanitize the data
  $username = sanitize($username, 'string');

  // Look for the username
  $dusername = mysqli_fetch_array(query(" SELECT  users.id  AS 'u_id'
                                          FROM    users
                                          WHERE   users.nickname LIKE '$username' "));

  // Return the result
  return ($dusername['u_id']) ? 1 : 0;
}




/**
 * Checks if a username is illegal.
 *
 * @param   string  $username The username to check.
 *
 * @return  bool              Whether the username is illegal on the website.
 */

function users_check_username_illegality($username)
{
  // Define a list of badwords
  $bad_words = array('admin', 'biatch', 'bitch', 'coon', 'fagg', 'kike', 'moderat', 'nigg', 'offici', 'trann', 'whore');

  // Check if the username matches any of the bad words
  $is_illegal = 0;
  foreach($bad_words as $bad_word)
    $is_illegal = (mb_strpos($username, $bad_word) !== false) ? 1 : $is_illegal;

  // Return the result
  return $is_illegal;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       LOGIN                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Logs the user into their account (or refuses to).
 *
 * The following two bruteforce checks will be done during the login process:
 * No more than 15 login attempts per IP every 10 minutes.
 * No more than 10 login attempts for a specific user every 10 minutes (except 1 allowed attempt per unique IP).
 *
 * @param   string      $ip                     The IP adress of the user attempting to login.
 * @param   string      $nickname               The nickname the user is attempting to login with.
 * @param   string      $password               The password the user is attempting to login with.
 * @param   int|null    $remember_me  OPTIONAL  Whether the website's front should create a cookie to keep the user in.
 *
 * @return  string                              Returns 'OK' if successfully logged in, or an error if it went wrong.
 */

function user_authenticate( $ip               ,
                            $nickname         ,
                            $password         ,
                            $remember_me = 0  )
{
  // Sanitize the data
  $ip           = sanitize($ip, 'string');
  $nickname     = sanitize($nickname, 'string');
  $password_raw = $password;
  $password     = sanitize($password, 'string');
  $timestamp    = sanitize(time(), 'int', 0);

  // Error: No nickname specified
  if(!$nickname)
    return __('login_form_error_no_nickname');

  // Error: No password specified - allow passwordless users in dev mode though so that users can be made from fixtures
  if(!$password && !$GLOBALS['dev_mode'])
    return __('login_form_error_no_password');

  // Check for a bruteforce attempt in the past 10 minutes
  $bruteforce_check_limit = (time() - 600);

  // Delete all older entries in the bruteforce attempts table
  query(" DELETE FROM users_login_attempts
          WHERE       users_login_attempts.attempted_at < $bruteforce_check_limit ");

  // Check for a bruteforce attempt by the current IP address
  $dbruteforce_check = mysqli_fetch_array(query(" SELECT  COUNT(users_login_attempts.ip_address) AS 'nb_attempts'
                                                  FROM    users_login_attempts
                                                  WHERE   users_login_attempts.ip_address LIKE '$ip' "));

  // If a bruteforce attempt is going on, throw the user away
  if($dbruteforce_check['nb_attempts'] > 15)
    return __('login_form_error_bruteforce');

  // Fetch the ID of the requested user
  $dfetch_user = mysqli_fetch_array(query(" SELECT  users.id        AS 'u_id'   ,
                                                    users.nickname  AS 'u_nick' ,
                                                    users.password  AS 'u_pass'
                                            FROM    users
                                            WHERE   users.nickname LIKE '$nickname' "));

  // Grab the user's nickname to fix any case inconsistency
  $nickname_raw = $dfetch_user['u_nick'];

  // If the user does not exist, log the bruteforce attempt and end the process here
  if(!$dfetch_user['u_id'])
  {
    query(" INSERT INTO users_login_attempts
            SET         users_login_attempts.fk_users     = 0             ,
                        users_login_attempts.ip_address   = '$ip'         ,
                        users_login_attempts.attempted_at = '$timestamp'  ");
    return __('login_form_error_wrong_user').'<br><br>'.__link('#popin_lost_access', __('login_form_error_forgotten_user'), 'text_red', 0);
  }

  // Check if the specific user is under bruteforce attempt
  $user_id            = sanitize($dfetch_user['u_id'], 'int', 0);
  $dbruteforce_check  = mysqli_fetch_array(query("  SELECT  COUNT(users_login_attempts.ip_address) AS 'nb_attempts'
                                                    FROM    users_login_attempts
                                                    WHERE   users_login_attempts.fk_users = '$user_id' "));

  // If the specific user is under bruteforce attempt, lock it to one attempt per IP
  if($dbruteforce_check['nb_attempts'] > 9)
  {
    $dbruteforce_check  = mysqli_fetch_array(query("  SELECT  COUNT(users_login_attempts.ip_address) AS 'nb_attempts'
                                                      FROM    users_login_attempts
                                                      WHERE   users_login_attempts.fk_users   =     '$user_id'
                                                      AND     users_login_attempts.ip_address LIKE  '$ip' "));
    if($dbruteforce_check['nb_attempts'] > 0)
      return __('login_form_error_bruteforce');
  }

  // Hash the password
  $hashed_password = encrypt_data($password_raw);

  // If the entered password is incorrect, log the bruteforce attempt and end the process here
  if($dfetch_user['u_pass'] && $hashed_password != $dfetch_user['u_pass'])
  {
    query(" INSERT INTO users_login_attempts
            SET         users_login_attempts.fk_users     = '$user_id'    ,
                        users_login_attempts.ip_address   = '$ip'         ,
                        users_login_attempts.attempted_at = '$timestamp'  ");
    return __('login_form_error_wrong_password').'<br><br>'.__link('#popin_lost_access', __('login_form_error_forgotten_password'), 'text_red', 0);
  }

  // Log in the user by setting the session variable
  $_SESSION['user'] = $user_id;

  // If requested, also create the session cookie
  if($remember_me)
    setcookie("nobleme_memory", encrypt_data($nickname_raw) , 2147483647, "/");

  // The login process is complete
  return 'OK';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     REGISTER                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Accept or reject a user's registration attempt.
 *
 * @param   string      $nickname                   The nickname of the account to be created.
 * @param   string      $password                   The password of the account to be created.
 * @param   string      $email                      The e-mail address of the account to be created.
 * @param   string|null $password_check   OPTIONAL  The second entry of the password of the account to be created.
 * @param   string|null $captcha          OPTIONAL  The captcha entered by the guest trying to register.
 * @param   string|null $captcha_session  OPTIONAL  The captcha value stored in the session.
 * @param   string|null $path             OPTIONAL  The path to the root of the website (defaults to 2 folders away).
 *
 * @return  string|int                              Returns 1 if successfully registered, or a string in case of error.
 */

function users_create_account(  $nickname                       ,
                                $password                       ,
                                $email                          ,
                                $password_check   = NULL        ,
                                $captcha          = NULL        ,
                                $captcha_session  = NULL        ,
                                $path             = './../../'  )
{
  // Check if the required files have been included
  require_included_file('users.lang.php');

  // Sanitize the data
  $nickname_raw       = $nickname;
  $nickname           = sanitize($nickname, 'string');
  $password_raw       = $password;
  $password           = sanitize($password, 'string');
  $password_encrypted = sanitize(encrypt_data($password_raw), 'string');
  $email              = sanitize($email, 'string');
  $timestamp          = sanitize(time(), 'int', 0);

  // Error: No nickname specified
  if(!$nickname)
    return __('users_login_error_no_nickname');

  // Error: No password specified
  if(!$password)
    return __('users_login_error_no_password');

  // Incorrect email (no error)
  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    $email = '';

  // Error: Different passwords
  if($password_check && ($password_raw != $password_check))
    return __('users_register_error_passwords');

  // Error: Password too short
  if(mb_strlen($password_raw) < 8)
    return __('users_register_error_password_length');

  // Error: Different captchas
  if($captcha && ($captcha != $captcha_session))
    return __('users_register_error_captchas');

  // Error: Nickname too short
  if(mb_strlen($nickname) < 3)
    return __('users_register_error_nickname_short');

  // Error: Nickname too long
  if(mb_strlen($nickname) > 15)
    return __('users_register_error_nickname_long');

  // Error: Password too short
  if(mb_strlen($password) < 8)
    return __('users_register_error_password_short');

  // Error: Special characters in nickname
  if(!preg_match("/^[a-zA-Z0-9]+$/", $nickname))
    return __('users_register_error_nickname_characters');

  // Error: Illegal string in username
  if(users_check_username_illegality($nickname))
    return __('users_register_error_nickname_illegal');

  // Error: Nickname already taken
  if(users_check_username($nickname))
    return __('users_register_error_nickname_taken');

  // Create the account
  query(" INSERT INTO users
          SET         users.nickname  = '$nickname'           ,
                      users.password  = '$password_encrypted' ");

  // Fetch the ID of the newly created account
  $account_id = sanitize(query_id(), 'int', 0);

  // Create the other account related entries in the database
  query(" INSERT INTO users_profile
          SET         users_profile.fk_users      = '$account_id' ,
                      users_profile.email_address = '$email'      ,
                      users_profile.created_at    = '$timestamp'  ");
  query(" INSERT INTO users_settings
          SET         users_settings.fk_users     = '$account_id' ");
  query(" INSERT INTO users_stats
          SET         users_stats.fk_users        = '$account_id' ");

  // Log the activity
  log_activity('users_register', 0, 'ENFR', 0, NULL, NULL, 0, $account_id, $nickname);

  // IRC message
  irc_bot_send_message("A new member registered on the website: $nickname_raw - ".$GLOBALS['website_url']."todo_link", "english");
  irc_bot_send_message("Nouveau compte crée sur le site : $nickname_raw - ".$GLOBALS['website_url']."todo_link", "french");

  // Welcome private message
  private_message_send(__('users_register_private_message_title'), __('users_register_private_message', null, 0, 0, array($path)), $account_id, 1);

  // The registration process is complete
  return 1;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      BANNED                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

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

  // Return the data
  return $data;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   AUTOCOMPLETE                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Autocompletes a nickname.
 *
 * @param   string      $input              The input that needs to be autocompleted.
 * @param   string|null $type   (OPTIONAL)  The type of autocomplete query we're making (eg. 'normal', 'ban', 'unban')
 *
 * @return  array                           An array containing all the data required to autocomplete the nickname.
 */

function users_autocomplete_nickname( $input          ,
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