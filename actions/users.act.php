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
 * @param   int|null    $is_admin         OPTIONAL  Whether the current user is an administrator.
 * @param   int|null    $is_activity      OPTIONAL  Whether the list will be used to display user activity.
 * @param   string|null $lang             OPTIONAL  The language currently in use.
 *
 * @return  array                                   A list of users, prepared for displaying.
 */

function users_get_list($sort_by='', $max_count=0, $deleted=0, $activity_cutoff=0, $include_guests=0, $max_guest_count=0, $is_admin=0, $is_activity=0, $lang='EN')
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
  $qusers = "       SELECT    'user'                            AS 'data_type'        ,
                              users.id                          AS 'u_id'             ,
                              users.nickname                    AS 'u_nick'           ,
                              ''                                AS 'u_guest_name_en'  ,
                              ''                                AS 'u_guest_name_fr'  ,
                              users.is_administrator            AS 'u_admin'          ,
                              users.is_global_moderator         AS 'u_global_mod'     ,
                              users.is_moderator                AS 'u_mod'            ,
                              users.last_visited_at             AS 'u_activity'       ,
                              users.last_visited_page_en        AS 'u_last_page_en'   ,
                              users.last_visited_page_fr        AS 'u_last_page_fr'   ,
                              users.last_visited_url            AS 'u_last_url'
                    FROM      users
                    LEFT JOIN users_settings ON users.id = users_settings.fk_users
                    WHERE     users.is_deleted                  = '$deleted' ";

  // Hide user activity based on their settings
  if($is_activity && !$is_admin)
    $qusers .= "    AND       users_settings.hide_from_activity = 0 ";

  // Activity cutoff
  if($activity_cutoff)
    $qusers .= "    AND       users.last_visited_at             >= '$minimum_activity' ";

  // Sort the users
  if(!$include_guests)
  {
    if($sort_by == 'activity')
      $qusers .= "  ORDER BY  users.last_visited_at DESC ";
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
                                0                                       AS 'u_global_mod'     ,
                                0                                       AS 'u_mod'            ,
                                users_guests.last_visited_at            AS 'u_activity'       ,
                                users_guests.last_visited_page_en       AS 'u_last_page_en'   ,
                                users_guests.last_visited_page_fr       AS 'u_last_page_fr'   ,
                                users_guests.last_visited_url           AS 'u_last_url'
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
    $temp                   = ($row['data_type'] == 'user') ? ' bold noglow' : ' noglow';
    $temp                   = ($row['u_mod']) ? ' bold text_orange noglow' : $temp;
    $temp                   = ($row['u_global_mod']) ? ' bold text_orange noglow' : $temp;
    $temp                   = ($row['u_admin']) ? ' bold text_red' : $temp;
    $data[$i]['css']        = $temp;
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

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
 * @param   string|null $path         OPTIONAL  The path to the root of the website (defaults to 2 folders away).
 *
 * @return  string                              Returns 'OK' if successfully logged in, or an error if it went wrong.
 */

function user_authenticate($ip, $nickname, $password, $remember_me=0, $path='./../../')
{
  // Sanitize the data
  $ip           = sanitize($ip, 'string');
  $nickname     = sanitize($nickname, 'string');
  $password_raw = $password;
  $password     = sanitize($password, 'string');
  $path         = sanitize($path, 'string');
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
    return __('login_form_error_wrong_user').'<br><br>'.__link('pages/users/lost_access', __('login_form_error_forgotten_user'), 'text_red', 1, $path);;
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
    return __('login_form_error_wrong_password').'<br><br>'.__link('pages/users/lost_access', __('login_form_error_forgotten_password'), 'text_red', 1, $path);
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

function users_create_account($nickname, $password, $email, $password_check=null, $captcha=null, $captcha_session=null, $path='./../../')
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

  // Error: No email specified
  if(!$password)
    return __('users_register_error_no_email');

  // Error: Different passwords
  if($password_check && ($password_raw != $password_check))
    return __('users_register_error_passwords');

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

  // Check if the desired nickname is illegal
  if(users_check_username_illegality($nickname))
    return __('users_register_error_nickname_illegal');

  // Check if the desired nickname already exists
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
  ircbot("A new member registered on the website: $nickname_raw - ".$GLOBALS['website_url']."pages/users/user?id=".$account_id, "#english");
  ircbot("Nouveau membre enregistré sur le site : $nickname_raw - ".$GLOBALS['website_url']."pages/users/user?id=".$account_id, "#NoBleme");

  // Welcome private message
  private_message_send(__('users_register_private_message_title'), __('users_register_private_message', null, 0, 0, array($path)), $account_id, 1);

  // The registration process is complete
  return 1;
}