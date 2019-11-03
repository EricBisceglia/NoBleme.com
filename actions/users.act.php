<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       LOGIN                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Accept or reject a user's login attempt.
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
 * @return  string|int                          Returns 1 if successfully logged in, or a string if an error happened.
 */

function users_authenticate($ip, $nickname, $password, $remember_me=0)
{
  // Sanitize the data
  $ip           = sanitize($ip, 'string');
  $nickname     = sanitize($nickname, 'string');
  $password_raw = $password;
  $password     = sanitize($password, 'string');
  $timestamp    = sanitize(time(), 'int', 0);

  // Error: No nickname specified
  if(!$nickname)
    return __('users_login_error_no_nickname');

  // Error: No password specified - allow passwordless users in dev mode though so that users can be made from fixtures
  if(!$password && !$GLOBALS['dev_mode'])
    return __('users_login_error_no_password');

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
    return __('users_login_error_bruteforce');

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
    return __('users_login_error_wrong_user');
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
      return __('users_login_error_bruteforce');
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
    return __('users_login_error_wrong_password');
  }

  // Log in the user by setting the session variable
  $_SESSION['user'] = $user_id;

  // If requested, also create the session cookie
  if($remember_me)
    setcookie("nobleme_memory", encrypt_data($nickname_raw) , 2147483647, "/");

  // The login process is complete
  return 1;
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
    return __('users_login_error_nickname_short');

  // Error: Nickname too long
  if(mb_strlen($nickname) > 15)
    return __('users_login_error_nickname_long');

  // Error: Password too short
  if(mb_strlen($password) < 8)
    return __('users_login_error_password_short');

  // Fetch all currently existing nicknames
  $qnicknames = query(" SELECT  nickname  AS 'u_nick'
                        FROM    users ");

  // Check if the desired nickname already exists - in a case insensitive way
  while($dnicknames = mysqli_fetch_array($qnicknames))
  {
    if(string_change_case($dnicknames['u_nick'], 'lowercase') == string_change_case($nickname, 'lowercase'))
      return __('users_register_error_nickname_taken');
  }

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
  log_activity('users_register', 0, 'ENFR', $account_id, $nickname);

  // IRC message
  ircbot("A new member registered on the website: $nickname_raw - ".$GLOBALS['website_url']."pages/users/user?id=".$account_id, "#english");
  ircbot("Nouveau membre enregistré sur le site : $nickname_raw - ".$GLOBALS['website_url']."pages/users/user?id=".$account_id, "#NoBleme");

  // Welcome private message
  private_message_send(__('users_register_private_message_title'), __('users_register_private_message', null, 0, 0, array($path)), $account_id, 1);

  // The registration process is complete
  return 1;
}
