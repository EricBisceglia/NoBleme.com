<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  user_authenticate         Logs the user into their account (or refuses to).                                      */
/*                                                                                                                   */
/*  user_create_account       Accept or reject a user's registration attempt.                                        */
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
 * @param   string      $username               The username the user is attempting to login with.
 * @param   string      $password               The password the user is attempting to login with.
 * @param   int|null    $remember_me  OPTIONAL  Whether the website's front should create a cookie to keep the user in.
 *
 * @return  string                              Returns 'OK' if successfully logged in, or an error if it went wrong.
 */

function user_authenticate( $ip               ,
                            $username         ,
                            $password         ,
                            $remember_me = 0  )
{
  // Only logged out users may authenticate
  user_restrict_to_guests();

  // Sanitize the data
  $ip           = sanitize($ip, 'string');
  $username     = sanitize($username, 'string');
  $password_raw = $password;
  $password     = sanitize($password, 'string');
  $timestamp    = sanitize(time(), 'int', 0);

  // Error: No username specified
  if(!$username)
    return __('login_form_error_no_username');

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
  $dfetch_user = mysqli_fetch_array(query(" SELECT  users.id          AS 'u_id'       ,
                                                    users.is_deleted  AS 'u_deleted'  ,
                                                    users.username    AS 'u_nick'     ,
                                                    users.password    AS 'u_pass'
                                            FROM    users
                                            WHERE   users.username LIKE '$username' "));

  // If the user does not exist, log the bruteforce attempt and end the process here
  if(!isset($dfetch_user['u_id']))
  {
    query(" INSERT INTO users_login_attempts
            SET         users_login_attempts.fk_users     = 0             ,
                        users_login_attempts.ip_address   = '$ip'         ,
                        users_login_attempts.attempted_at = '$timestamp'  ");
    return __('login_form_error_wrong_user').'<br><br>'.__link('#popin_lost_access', __('login_form_error_forgotten_user'), 'text_red', 0);
  }

  // Error: User is deleted
  if($dfetch_user['u_deleted'])
    return __('login_form_error_deleted');

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
  $_SESSION['user_id'] = $user_id;

  // Update the current user IP
  $user_ip = sanitize($_SERVER['REMOTE_ADDR'], 'string');
  query(" UPDATE  users
          SET     users.current_ip_address  = '$user_ip'
          WHERE   users.id                  = '$user_id' ");

  // If requested, also create the session cookie
  if($remember_me)
  {
    // Generate the hash and its expiry date
    $token_hash   = sanitize(bin2hex(random_bytes(64)), 'string');
    $token_regen  = sanitize(time() + 60, 'int', 0);
    $token_expiry = sanitize(time() + 7890000, 'int', 0);

    // Create the cookie
    setcookie("nobleme_memory", $token_hash, 2147483647, "/");

    // Update the database
    query(" INSERT INTO users_tokens
            SET         users_tokens.fk_users       = '$user_id'      ,
                        users_tokens.token          = '$token_hash'   ,
                        users_tokens.token_type     = 'session'       ,
                        users_tokens.regenerate_at  = '$token_regen'  ,
                        users_tokens.delete_at      = '$token_expiry' ");

    // Run housecleaning on expired tokens
    query(" DELETE FROM users_tokens
            WHERE       users_tokens.delete_at <= '$timestamp' ");
  }

  // The login process is complete
  return 'OK';
}




/**
 * Accept or reject a user's registration attempt.
 *
 * @param   string      $username                   The username of the account to be created.
 * @param   string      $password                   The password of the account to be created.
 * @param   string      $email                      The e-mail address of the account to be created.
 * @param   string|null $password_check   OPTIONAL  The second entry of the password of the account to be created.
 * @param   string|null $captcha          OPTIONAL  The captcha entered by the guest trying to register.
 * @param   string|null $captcha_session  OPTIONAL  The captcha value stored in the session.
 *
 * @return  string|int                              Returns 1 if successfully registered, or a string in case of error.
 */

function user_create_account( $username                 ,
                              $password                 ,
                              $email                    ,
                              $password_check   = NULL  ,
                              $captcha          = NULL  ,
                              $captcha_session  = NULL  )
{
  // Check if the required files have been included
  require_included_file('register.lang.php');

  // Sanitize and prepare the data
  $path               = root_path();
  $username_raw       = $username;
  $username           = sanitize($username, 'string');
  $password_raw       = $password;
  $password           = sanitize($password, 'string');
  $password_encrypted = sanitize(encrypt_data($password_raw), 'string');
  $email              = sanitize($email, 'string');
  $timestamp          = sanitize(time(), 'int', 0);

  // Error: No username specified
  if(!$username)
    return __('users_register_error_no_username');

  // Error: No password specified
  if(!$password)
    return __('users_register_error_no_password');

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

  // Error: username too short
  if(mb_strlen($username) < 3)
    return __('users_register_error_username_short');

  // Error: username too long
  if(mb_strlen($username) > 15)
    return __('users_register_error_username_long');

  // Error: Password too short
  if(mb_strlen($password) < 8)
    return __('users_register_error_password_short');

  // Error: Special characters in username
  if(!preg_match("/^[a-zA-Z0-9]+$/", $username))
    return __('users_register_error_username_characters');

  // Error: Illegal string in username
  if(user_check_username_illegality($username))
    return __('users_register_error_username_illegal');

  // Error: username already taken
  if(user_check_username($username))
    return __('users_register_error_username_taken');

  // Create the account
  query(" INSERT INTO users
          SET         users.username  = '$username'           ,
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
  log_activity( 'users_register'              ,
                fk_users:         $account_id ,
                username:         $username   );

  // IRC message
  irc_bot_send_message("A new member registered on the website: $username_raw - ".$GLOBALS['website_url']."todo_link", "english");
  irc_bot_send_message("Nouveau compte crée sur le site : $username_raw - ".$GLOBALS['website_url']."todo_link", "french");

  // Welcome private message
  private_message_send(__('users_register_private_message_title'), __('users_register_private_message', null, 0, 0, array($path)), $account_id, 1);

  // The registration process is complete
  return 1;
}
