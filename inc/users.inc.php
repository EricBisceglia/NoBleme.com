<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }

/*********************************************************************************************************************/
/*                                                                                                                   */
/*  secure_session_start              Starts a session.                                                              */
/*  encrypt_data                      Encrypts data.                                                                 */
/*                                                                                                                   */
/*  user_is_logged_in                 Checks whether the current user is logged in.                                  */
/*  user_log_out                      Logs the user out of their account.                                            */
/*                                                                                                                   */
/*  user_unban                        Unbans a banned user.                                                          */
/*                                                                                                                   */
/*  user_get_id                       Returns the current user's id.                                                 */
/*  user_fetch_id                     Returns the user id for a specific username.                                   */
/*  user_get_username                 Returns a user's username from their id.                                       */
/*  user_get_language                 Returns a user's language.                                                     */
/*  user_get_mode                     Returns the current user's display mode.                                       */
/*                                                                                                                   */
/*  user_is_administrator             Checks if a user is an administrator.                                          */
/*  user_is_moderator                 Checks if a user is a moderator (or above).                                    */
/*  user_is_banned                    Checks if a user is banned.                                                    */
/*  user_is_ip_banned                 Checks if a user is IP banned.                                                 */
/*  user_is_deleted                   Checks if a user's account is deleted.                                         */
/*                                                                                                                   */
/*  user_restrict_to_administrators   Allows access only to administrators.                                          */
/*  user_restrict_to_moderators       Allows access only to moderators (or above).                                   */
/*  user_restrict_to_users            Allows access only to logged in users.                                         */
/*  user_restrict_to_guests           Allows access only to guests (not logged into an account).                     */
/*  user_restrict_to_banned           Allows access only to banned users.                                            */
/*  user_restrict_to_ip_banned        Allows access only to fully IP banned users.                                   */
/*  user_restrict_to_non_ip_banned    Allows access only to users who are not IP banned.                             */
/*                                                                                                                   */
/*  user_settings_nsfw                NSFW filter settings of the current user.                                      */
/*  user_settings_privacy             Third party content privacy settings of the current user.                      */
/*                                                                                                                   */
/*  user_get_oldest                   Finds when the oldest user registered on the website.                          */
/*  user_get_birth_years              Returns all the years during which a user was born.                            */
/*                                                                                                                   */
/*  user_generate_random_username     Generates a random username for a guest.                                       */
/*                                                                                                                   */
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Let's begin by opening the session
secure_session_start();

// If the user has an ID cookie set, attempt to identify them
if(isset($_COOKIE['nobleme_memory']) && !isset($_GET['logout']))
{
  // Sanitize the cookie's value
  $login_cookie = sanitize($_COOKIE['nobleme_memory'], 'string');

  // Check if the token exists in the database
  $timestamp = sanitize(time(), 'int', 0);
  $dusers = mysqli_fetch_array(query("  SELECT  users_tokens.id             AS 't_id'   ,
                                                users_tokens.fk_users       AS 't_uid'  ,
                                                users_tokens.regenerate_at  AS 't_regen'
                                        FROM    users_tokens
                                        WHERE   users_tokens.token_type LIKE 'session'
                                        AND     users_tokens.token      LIKE '$login_cookie'
                                        AND     users_tokens.delete_at     > '$timestamp' "));

  // If there's a match, the process can continue
  if(isset($dusers['t_uid']))
  {
    // Regenerate the token if needed
    if($dusers['t_regen'] <= time())
    {
      // Generate the hash and its expiry date
      $token_id     = sanitize($dusers['t_id'], 'int', 0);
      $user_id      = sanitize($dusers['t_uid'], 'int', 0);
      $token_hash   = sanitize(bin2hex(random_bytes(64)), 'string');
      $token_regen  = sanitize(time() + 60, 'int', 0);
      $token_expiry = sanitize(time() + 7890000, 'int', 0);

      // Update the cookie
      if($GLOBALS['dev_http_only'])
        setcookie("nobleme_memory", $token_hash, 2147483647, "/");
      else
        setcookie(  "nobleme_memory"          ,
                    $token_hash               ,
                  [ 'expires'   => 2147483647 ,
                    'path'      => '/'        ,
                    'samesite'  => 'None'     ,
                    'secure'    => true       ]);

      // Update the database
      query(" UPDATE  users_tokens
              SET     users_tokens.token          = '$token_hash'   ,
                      users_tokens.regenerate_at  = '$token_regen'  ,
                      users_tokens.delete_at      = '$token_expiry'
              WHERE   users_tokens.id             = '$token_id'   ");

      // Run housecleaning on expired tokens
      query(" DELETE FROM users_tokens
              WHERE       users_tokens.delete_at <= '$timestamp' ");
    }

    // Assign the user id to the session to log them in
    $_SESSION['user_id'] = $dusers['t_uid'];
  }

  // If there's no match, log the user out
  else
    user_log_out();
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Next up, check if the user is connected and what their access rights are

// Figure out if the user is connected or not according to session data
$is_logged_in = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;

// Gather data regarding the user
if($is_logged_in)
{
  // Sanitize the user ID
  $user_id = sanitize($is_logged_in, 'int', 0);

  // Fetch some data
  $duser = mysqli_fetch_array(query("   SELECT    users.is_deleted                    AS 'u_deleted'  ,
                                                  users.username                      AS 'u_nick'     ,
                                                  users.is_administrator              AS 'u_admin'    ,
                                                  users.is_moderator                  AS 'u_mod'      ,
                                                  users.unread_private_message_count  AS 'u_pm'       ,
                                                  users.is_banned_until               AS 'u_ban_end'  ,
                                                  users_settings.show_nsfw_content    AS 'us_nsfw'
                                        FROM      users
                                        LEFT JOIN users_settings on users_settings.fk_users = users.id
                                        WHERE     users.id = '$user_id' " ,
                                        description: "Fetch data related to the currently logged in user"));

  // If the user's account doesn't exist or is deleted, log them out and set their user id to 0
  if(!isset($duser['u_deleted']) || $duser['u_deleted'])
  {
    user_log_out();
    $user_id = 0;
  }

  // Otherwise, set some useful values as variables
  $username       = $duser['u_nick'];
  $is_admin       = $duser['u_admin'];
  $is_moderator   = ($is_admin || $duser['u_mod']);
  $is_guest       = 0;
  $is_banned      = $duser['u_ban_end'];
  $unread_pms     = $duser['u_pm'];
  $settings_nsfw  = $duser['us_nsfw'];
}

// If the user isn't logged in, set some default values
if(!$is_logged_in || !$user_id)
{
  $username       = NULL;
  $user_id        = 0;
  $is_admin       = 0;
  $is_moderator   = 0;
  $is_guest       = 1;
  $is_banned      = 0;
  $unread_pms     = 0;
  $settings_nsfw  = 0;
}

// Store these values in the session
$_SESSION['username']       = $username;
$_SESSION['is_admin']       = $is_admin;
$_SESSION['is_moderator']   = $is_moderator;
$_SESSION['is_guest']       = $is_guest;
$_SESSION['is_banned']      = $is_banned;
$_SESSION['unread_pms']     = 0;
$_SESSION['settings_nsfw']  = $settings_nsfw;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Language management

// If there is no language in the session, assign one
if(!isset($_SESSION['lang']))
{
  // If there is no language cookie, then the default language is fetched from the browser's accept language headers
  if(!isset($_COOKIE['nobleme_language']))
  {
    // Fetch the language settings (default to english if it isn't french or if it isn't found)
    if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
      $language_header  = (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) === 'fr') ? 'FR' : 'EN';
    else
      $language_header  = 'EN';

    // Create the cookie and the session variable
    $_SESSION['lang'] = $language_header;
    if($GLOBALS['dev_http_only'])
        setcookie("nobleme_language", $language_header, 2147483647, "/");
    else
      setcookie(  "nobleme_language"        ,
                  $language_header          ,
                [ 'expires'   => 2147483647 ,
                  'path'      => '/'        ,
                  'samesite'  => 'None'     ,
                  'secure'    => true       ]);
  }

  // If the language cookie exists, set the session language to the one in the cookie
  else
    $_SESSION['lang'] = $_COOKIE['nobleme_language'];
}

// If the user clicks on the language flag, change the language accordingly
if(isset($_GET['changelang']))
{
  // Get the language that the user is currently not using
  $changelang = ($_SESSION['lang'] === 'EN') ? 'FR' : 'EN';

  // Change the cookie and session language to the new one
  $_SESSION['lang'] = $changelang;
  if($GLOBALS['dev_http_only'])
    setcookie("nobleme_language", $changelang, 2147483647, "/");
  else
    setcookie(  "nobleme_language"        ,
                $changelang               ,
              [ 'expires'   => 2147483647 ,
                'path'      => '/'        ,
                'samesite'  => 'None'     ,
                'secure'    => true       ]);
}

// If the URL contains a request to change to a specific language, then fullfill that request
if(isset($_GET['english']) || isset($_GET['anglais']))
{
  // Change the cookie and session language to english on request
  $_SESSION['lang'] = "EN";
  if($GLOBALS['dev_http_only'])
    setcookie("nobleme_language", "EN", 2147483647, "/");
  else
    setcookie(  "nobleme_language"        ,
                "EN"                      ,
              [ 'expires'   => 2147483647 ,
                'path'      => '/'        ,
                'samesite'  => 'None'     ,
                'secure'    => true       ]);
}

// In case more than one language change request is being done, then english will be the final language
else if(isset($_GET['francais']) || isset($_GET['french']))
{
  // Change the cookie and session language to french on request
  $_SESSION['lang'] = "FR";
  if($GLOBALS['dev_http_only'])
    setcookie("nobleme_language", "FR", 2147483647, "/");
  else
    setcookie(  "nobleme_language"        ,
                "FR"                      ,
              [ 'expires'   => 2147483647 ,
                'path'      => '/'        ,
                'samesite'  => 'None'     ,
                'secure'    => true       ]);
}

// If a language change just happened, clean up the URL and reload the page
if(isset($_GET['english']) || isset($_GET['anglais']) || isset($_GET['francais']) || isset($_GET['french']) || isset($_GET['changelang']))
{
  // Get rid of all the language related query parameters
  unset($_GET['english']);
  unset($_GET['anglais']);
  unset($_GET['francais']);
  unset($_GET['french']);
  unset($_GET['changelang']);

  // Re-build the URL, with all its other query parameters intact
  $url_self     = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_rebuild  = urldecode(http_build_query($_GET));
  $url_rebuild  = ($url_rebuild) ? $url_self.'?'.$url_rebuild : $url_self;

  // Reload the page by giving it the cleaned up URL (there better not be an infinite loop case I didn't test here)
  exit(header("Location: ".$url_rebuild));
}

// Use the $lang variable to store the language for the duration of the session (the header and other pages need it)
$lang = (!isset($_SESSION['lang'])) ? 'EN' : $_SESSION['lang'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display mode

// If there is no display mode in the session, assign one
if(!isset($_SESSION['mode']))
{
  // If there is no display mode cookie, then default to dark mode
  if(!isset($_COOKIE['nobleme_mode']))
  {
    // Create the cookie and the session variable
    $_SESSION['mode'] = "dark";
    if($GLOBALS['dev_http_only'])
        setcookie("nobleme_mode", "dark", 2147483647, "/");
    else
      setcookie(  "nobleme_mode"            ,
                  "dark"                    ,
                [ 'expires'   => 2147483647 ,
                  'path'      => '/'        ,
                  'samesite'  => 'None'     ,
                  'secure'    => true       ]);
  }

  // If the display mode cookie exists, set the display mode to the one in the cookie
  else
    $_SESSION['mode'] = $_COOKIE['nobleme_mode'];
}

// If the URL contains a request to change to a specific display mode, then fullfill that request
if(isset($_GET['light_mode']))
{
  $_SESSION['mode'] = "light";
  if($GLOBALS['dev_http_only'])
    setcookie("nobleme_mode", "light", 2147483647, "/");
  else
    setcookie(  "nobleme_mode"            ,
                "light"                   ,
              [ 'expires'   => 2147483647 ,
                'path'      => '/'        ,
                'samesite'  => 'None'     ,
                'secure'    => true       ]);
}

// In case more than one mode change request is being done, then dark will be the final mode
else if(isset($_GET['dark_mode']))
{
  // Change the cookie and session language to french on request
  $_SESSION['mode'] = "dark";
  if($GLOBALS['dev_http_only'])
    setcookie("nobleme_mode", "dark", 2147483647, "/");
  else
    setcookie(  "nobleme_mode"            ,
                "dark"                    ,
              [ 'expires'   => 2147483647 ,
                'path'      => '/'        ,
                'samesite'  => 'None'     ,
                'secure'    => true       ]);
}

// If a mode change just happened, clean up the URL and reload the page
if(isset($_GET['light_mode']) || isset($_GET['dark_mode']))
{
  // Get rid of all the mode related query parameters
  unset($_GET['light_mode']);
  unset($_GET['dark_mode']);

  // Re-build the URL, with all its other query parameters intact
  $url_self     = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_rebuild  = urldecode(http_build_query($_GET));
  $url_rebuild  = ($url_rebuild) ? $url_self.'?'.$url_rebuild : $url_self;

  // Reload the page by giving it the cleaned up URL (there better not be an infinite loop case I didn't test here)
  exit(header("Location: ".$url_rebuild));
}

// Use the $mode variable to store the display mode for the duration of the session (header and other pages need it)
$mode = (!isset($_SESSION['mode'])) ? 'dark' : $_SESSION['mode'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Is the user IP banned

// Check whether the user is IP banned
$is_ip_banned = user_is_ip_banned();

// Regular IP bans should get logged out of any account they're currently using
if($is_ip_banned && user_is_logged_in())
  user_log_out();

// Full IP bans should be redirected to an error page
if(substr($_SERVER["PHP_SELF"], -14) !== "/banned_ip.php" && $is_ip_banned === 2)
  exit(header("Location: ".$path."banned_ip"));



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Is the user banned

// First off, to avoid infinite loops, make sure that the user is logged in and isn't already on the banned.php page
if(substr($_SERVER["PHP_SELF"], -11) !== "/banned.php" && user_is_logged_in())
{
  // Check whether the user is banned - if yes, redirect them to the banned page
  if(user_is_banned())
    exit(header("Location: ".$path."banned"));
}





/**
 * Starts a session.
 *
 * Look, I just don't trust PHP sessions. I'm not a fan of them, ok? Call this instead of session_start().
 * A new session token is generated on every page load, to ensure full regen of everything.
 *
 * @return void
 */

function secure_session_start() : void
{
  // This public token will be used to identify the session name
  $session_name = 'nobleme_session';

  // This is where it gets tricky: force this session to only use cookies or block execution of the application
  if (ini_set('session.use_only_cookies', 1) === FALSE) {
      exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Can not start secure session. Please enable cookies.</body></html>');
  }

  // Fetch the current cookie
  $cookieParams = session_get_cookie_params();

  // Prepare a session cookie every time a new page is loaded
  if($GLOBALS['dev_mode'])
    session_set_cookie_params(  $cookieParams["lifetime"]             ,
                                $cookieParams["path"].';SameSite=lax' ,
                                $cookieParams["domain"]               ,
                                false                                 ,
                                true                                  );
  else
    session_set_cookie_params(  $cookieParams["lifetime"]                 ,
                                $cookieParams["path"].';SameSite=Strict;' ,
                                $cookieParams["domain"]                   ,
                                true                                      ,  // Enforce HTTPS
                                true                                      ); // Ensures it can't be caught by js

  // Start the session, for real this time
  session_name($session_name);
  session_start();
  session_regenerate_id();
}




/**
 * Encrypts data.
 *
 * This is the function used to hash passwords or other data.
 *
 * @param   string  $data                         The data to encrypt.
 * @param   bool    $use_old_method   (OPTIONAL)  Will use the old insecure encryption method instead of the current.
 *
 * @return  string                      The encrypted data.
 */

function encrypt_data(  string  $data                     ,
                        bool    $use_old_method  = false  ) : string
{
  // If the old method is still being used, call crypt with the salt key
  if($use_old_method)
    return crypt($data, $GLOBALS['salt_key']);

  // If not, then use sha1 with the salt key
  else
    return sha1($data.$GLOBALS['salt_key']);
}




/**
 * Checks whether the current user is logged in.
 *
 * @return  bool  Whether the current user is logged in.
 */

function user_is_logged_in() : bool
{
  // As simple as it seems, grab the value in the session
  return isset($_SESSION['user_id']);
}




/**
 * Logs the user out of their account.
 *
 * @return void
 */

function user_log_out() : void
{
  // Delete the session cookie if it exists
  if(isset($_COOKIE['nobleme_memory']))
  {
    // Grab the cookie's value
    $session_token = sanitize($_COOKIE['nobleme_memory'], 'string');

    // Delete the database entry
    query(" DELETE FROM users_tokens
            WHERE       users_tokens.token LIKE '$session_token' ");

    // Destroy the session cookie
    setcookie('nobleme_memory', '', (time() - 630720000), "/");
  }

  // Destroy the session itself
  session_destroy();

  // Determine the path to the current page without the logout parameter
  unset($_GET['logout']);
  $url_self   = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_logout = urldecode(http_build_query($_GET));
  $url_logout = ($url_logout) ? $url_self.'?'.$url_logout : $url_self;

  // Reset the user id in the session
  $_SESSION['user_id'] = 0;

  // Reload the page
  exit(header("location: ".$url_logout));
}




/**
 * Unbans a banned user.
 *
 * @param   int   $user_id                      The user's ID.
 * @param   int   $unbanner_id      (OPTIONAL)  The ID of the moderator doing the unbanning.
 * @param   bool  $recent_activity  (OPTIONAL)  If set, generates an entry in recent activity.
 *
 * @return  void
 */

function user_unban(  int   $user_id                  ,
                      int   $unbanner_id      = 0     ,
                      bool  $recent_activity  = false ) : void
{
  // Sanitize the data
  $timestamp          = sanitize(time(), 'int', 0);
  $user_id            = sanitize($user_id, 'int', 0);
  $user_username      = sanitize(user_get_username($user_id));
  $unbanner_id        = sanitize($unbanner_id, 'int', 0);

  // Unban the user
  query(" UPDATE  users
          SET     users.is_banned_since       = 0   ,
                  users.is_banned_until       = 0   ,
                  users.is_banned_because_en  = ''  ,
                  users.is_banned_because_fr  = ''
          WHERE   users.id                    = '$user_id' ");

  // Ban logs
  query(" UPDATE    logs_bans
          SET       logs_bans.fk_unbanned_by_user = '$unbanner_id' ,
                    logs_bans.unbanned_at         = '$timestamp'
          WHERE     logs_bans.fk_banned_user      = '$user_id'
          AND       logs_bans.unbanned_at         = 0
          ORDER BY  logs_bans.banned_until        DESC
          LIMIT     1 ");

  // Recent activity
  if($recent_activity)
    query(" INSERT INTO logs_activity
            SET         logs_activity.happened_at         = '$timestamp'          ,
                        logs_activity.is_moderators_only  = '0'                   ,
                        logs_activity.language            = 'ENFR'                ,
                        logs_activity.activity_type       = 'users_unbanned'      ,
                        logs_activity.activity_id         = '$user_id'            ,
                        logs_activity.activity_username   = '$user_username'      ");
}




/**
 * Returns the current user's id.
 *
 * @return  int   The current user's id, or 0 if logged out.
 */

function user_get_id() : int
{
  // As simple as it sounds, return the value stored in the session if the user is logged in, else 0
  return (user_is_logged_in()) ? $_SESSION['user_id'] : 0;
}




/**
 * Returns the user id for a specific username.
 *
 * @param   string  The user's username.
 *
 * @return  int     The user's id, or 0 if it wasn't found.
 */

function user_fetch_id( string $username ) : int
{
  // Sanitize the username
  $username = sanitize($username, 'string');

  // Fetch the username
  $duser = mysqli_fetch_array(query(" SELECT  users.id AS 'u_id'
                                      FROM    users
                                      WHERE   users.username LIKE '$username' "));

  // Return the user's id, or 0 if it wasn't found
  return isset($duser['u_id']) ? $duser['u_id'] : 0;
}




/**
 * Returns a user's username from their id.
 *
 * @param   int|null    $user_id  (OPTIONAL)  The user's id - if none, try to return the username of current user.
 *
 * @return  string|null                       The user's nickame, or NULL if not found.
 */

function user_get_username( ?int $user_id = NULL ) : ?string
{
  // Check whether the current user is being queried
  $current_user = (is_null($user_id));

  // If no id is specified, grab the one currently stored in the session
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no id is stored in the session, then this is a guest, return nothing
  else if(!$user_id)
    return NULL;

  // If we are looking for the current user, use the session info if it exists
  if($current_user && isset($_SESSION['username']))
    return $_SESSION['username'];

  // Sanitize the provided id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch the user's username
  $dusername = mysqli_fetch_array(query(" SELECT  users.username AS 'username'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // Return 0 if the user does not exist
  if(!isset($dusername['username']))
    return 0;

  // Return whatever the database returned, or NULL if not found
  return $dusername['username'] ?? NULL;
}




/**
 * Returns a user's language.
 *
 * @param   int|null  $user_id  (OPTIONAL)  The user's id - if none, try to return the language of current user.
 *
 * @return  string                          The user's language, defaults to english if not found.
 */

function user_get_language( ?int $user_id = NULL ) : string
{
  // If no user is specified, returns the language settings stored in the session - or english if none
  if(!$user_id)
    return (!isset($_SESSION['lang'])) ? 'EN' : $_SESSION['lang'];

  // Sanitize the provided id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch the user's language
  $dlanguage = mysqli_fetch_array(query(" SELECT  users.current_language AS 'language'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // Return the user's language, or english if nothing was found
  return $dlanguage['language'] ?? 'EN';
}




/**
 * Returns the current user's display mode.
 *
 * @return  string  The user's display mode, defaults to dark if not found.
 */

function user_get_mode() : string
{
  // Return the display mode, or dark if none in the session
  return (!isset($_SESSION['mode'])) ? 'dark' : $_SESSION['mode'];
}




/**
 * Checks if a user is an administrator.
 *
 * Defaults to checking whether current user is an administrator unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  The user's id - if none, try to return the rights of current user.
 *
 * @return  bool                            Returns 1 if the user has administrator rights, 0 if they don't.
 */

function user_is_administrator( ?int $user_id = NULL ) : bool
{
  // Check whether the current user is being queried
  $current_user = (is_null($user_id));

  // If no user id is specified, use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means the user is a guest, in this case return 0
  if(!$user_id)
    return 0;

  // If we are looking for the current user, use the session info if it exists
  if($current_user && isset($_SESSION['is_admin']))
    return $_SESSION['is_admin'];

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_administrator AS 'u_admin'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // Return 0 if the user does not exist
  if(!isset($drights['u_admin']))
    return 0;

  // Return 1 if the user is an administrator, 0 if they don't
  return $drights['u_admin'];
}




/**
 * Checks if a user is a moderator (or above).
 *
 * Defaults to checking whether current user is a moderator unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  The user's id - if none, try to return the rights of current user.
 *
 * @return  bool                            Returns 1 if the user has moderator rights, 0 if they don't.
 */

function user_is_moderator( ?int $user_id = NULL ) : bool
{
  // Check whether the current user is being queried
  $current_user = (is_null($user_id));

  // If no user id is specified, use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means they are a guest, return 0
  if(!$user_id)
    return 0;

  // If we are looking for the current user, use the session info if it exists
  if($current_user && isset($_SESSION['is_moderator']))
    return $_SESSION['is_moderator'];

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_moderator      AS 'u_mod' ,
                                                users.is_administrator  AS 'u_admin'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // Return 0 if the user does not exist
  if(!isset($drights['u_mod']))
    return 0;

  // If user is an admin or a mod, return 1
  if($drights['u_mod'] || $drights['u_admin'])
    return 1;

  // If none of the above were matches, then the user shouldn't have access: return 0
  return 0;
}




/**
 * Checks if a user is banned.
 *
 * Defaults to checking whether current user is banned unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  The user's id - if none, try to return if the current user is banned.
 *
 * @return  bool                            Returns 1 if the user is banned, 0 if they don't.
 */

function user_is_banned( ?int $user_id = NULL ) : bool
{
  // Check whether the current user is being queried
  $current_user = (is_null($user_id));

  // If no user id is specified, use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means the user is a guest, in this case return 0
  if(!$user_id)
    return 0;

  // If we are looking for the current user, use the session info if it exists
  if($current_user && isset($_SESSION['is_banned']))
    return $_SESSION['is_banned'];

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch banned status
  $dbanned = mysqli_fetch_array(query(" SELECT  users.is_banned_until AS 'u_ban_end'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // Return 0 if the user does not exist
  if(!isset($dbanned['u_ban_end']))
    return 0;

  // If the user isn't banned, return 0
  if(!$dbanned['u_ban_end'])
    return 0;

  // If the user is banned and hasn't purged their sentence, return 1
  if($dbanned["u_ban_end"] > time())
    return 1;

  // If the ban has been purged, then unban the user and return 0
  user_unban($user_id);
  return 0;
}




/**
 * Checks if the current user is IP banned.
 *
 * @return  int   0 if the user is not IP banned, 1 if the user is IP banned, 2 if the user is total IP banned
 */

function user_is_ip_banned() : int
{
  // Get the current user's IP and sanitize it
  $user_ip = sanitize($_SERVER['REMOTE_ADDR'], 'string');

  // Check if it is banned
  $dbanned = mysqli_fetch_array(query(" SELECT  system_ip_bans.id             AS 'b_id'     ,
                                                system_ip_bans.ip_address     AS 'b_ip'     ,
                                                system_ip_bans.is_a_total_ban AS 'b_total'  ,
                                                system_ip_bans.banned_until   AS 'b_end'
                                        FROM    system_ip_bans
                                        WHERE   LOCATE(REPLACE(system_ip_bans.ip_address, '*', ''), '$user_ip') > 0 " ,
                                        description: "Check whether a user is IP banned" ));

  // If the user isn't IP banned, return 0
  if(!isset($dbanned['b_id']))
    return 0;

  // If the ban hasn't expired, return whether it is a standard (1) or total (2) IP ban
  if($dbanned['b_end'] > time())
    return ($dbanned['b_total'] + 1);

  // If the ban has expired, remove it
  $ip_ban_raw = $dbanned['b_ip'];
  $ip_ban     = sanitize($dbanned['b_ip'], 'string');
  $ip_ban_id  = sanitize($dbanned['b_id'], 'int', 0);
  query(" DELETE FROM system_ip_bans
          WHERE       system_ip_bans.id = '$ip_ban_id' ");

  // Activity logs
  $timestamp = sanitize(time(), 'int', 0);
  query(" INSERT INTO logs_activity
          SET         logs_activity.happened_at         = '$timestamp'        ,
                      logs_activity.is_moderators_only  = '1'                 ,
                      logs_activity.language            = 'ENFR'              ,
                      logs_activity.activity_type       = 'users_unbanned_ip' ,
                      logs_activity.activity_id         = '$ip_ban_id'        ,
                      logs_activity.activity_username   = '$ip_ban'           ");

  // Ban logs
  query(" UPDATE    logs_bans
          SET       logs_bans.fk_unbanned_by_user =     0 ,
                    logs_bans.unbanned_at         =     '$timestamp'
          WHERE     logs_bans.banned_ip_address   LIKE  '$ip_ban'
          AND       logs_bans.unbanned_at         =     0
          ORDER BY  logs_bans.banned_until        DESC
          LIMIT     1 ");

  // Update the related scheduler task
  query(" DELETE FROM system_scheduler
          WHERE       system_scheduler.task_id    =     '$ip_ban_id'
          AND         system_scheduler.task_type  LIKE  'users_unban_ip' ");

  // Return 0 since the IP is now unbanned
  return 0;
}




/**
 * Checks if a user's account is deleted.
 *
 * Defaults to checking whether current account is deleted unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  The user's id - if none, check if the current user is deleted.
 *
 * @return  bool                            Returns 1 if the account is deleted, 0 if it isn't.
 */

function user_is_deleted( ?int $user_id = NULL) : bool
{
  // If no user id is specified, use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means the user is a guest, in this case return 0
  if(!$user_id)
    return 0;

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch account status
  $ddeleted = mysqli_fetch_array(query("  SELECT  users.is_deleted AS 'u_deleted'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // Return 1 if the user is an deleted, 0 if they aren't
  return $ddeleted['u_deleted'];
}




/**
 * Allows access only to administrators.
 *
 * Any user lacking the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @return  void
 */

function user_restrict_to_administrators() : void
{
  // Fetch the user's language
  $lang = user_get_language();

  // Prepare the error message that will be displayed
  $error_message = ($lang === 'EN') ? "This page is restricted to website administrators only." : "Cette page est réservée aux équipes d'administration du site.";

  // Check if the user is logged in
  if(user_is_logged_in())
  {
    // If the user isn't an administrator, throw the error
    if(!user_is_administrator())
      error_page($error_message);
  }
  // If the user is logged out, throw the error
  else
    error_page($error_message);
}




/**
 * Allows access only to moderators (or above).
 *
 * Any user lacking the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @return  void
 */

function user_restrict_to_moderators() : void
{
  // Fetch the user's language
  $lang = user_get_language();

  // Prepare the error message that will be displayed
  $error_message = ($lang === 'EN') ? "This page is restricted to website staff only." : "Cette page est réservée aux équipes d'administration du site.";

  // Check if the user is logged in
  if(user_is_logged_in())
  {
    // Check if the user has global moderator rights
    if(!user_is_moderator($_SESSION['user_id']))
      error_page($error_message);
  }
  // If the user is logged out, throw the error
  else
    error_page($error_message);
}




/**
 * Allows access only to logged in users.
 *
 * Any user lacking the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @return  void
 */

function user_restrict_to_users() : void
{
  // Fetch the path to the website's root
  $path = root_path();

  // Fetch the user's language
  $lang = user_get_language();

  // Determine the icon's color
  $icon_color = (user_get_mode() === 'dark') ? ' red' : '';

  // If the user is logged out, throw an error page asking the user to log in or register
  if(!user_is_logged_in())
  {
    if($lang === 'EN')
      error_page("This page is restricted to logged in users.<br><br>Log in by clicking the <img src=\"".$path."img/icons/login.svg\" alt=\"Account\" class=\"icon valign_middle$icon_color\"> icon on the top right of the page");
    else
      error_page("Cette page nécessite de vous connecter à un compte.<br><br>Connectez vous en cliquant sur l'icône <img src=\"".$path."img/icons/login.svg\" alt=\"Account\" class=\"icon valign_middle$icon_color\"> en haut à droite de la page");
  }
}




/**
 * Allows access only to guests (not logged into an account).
 *
 * Any user lacking the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @return  void
 */

function user_restrict_to_guests() : void
{
  // Fetch the user's language
  $lang = user_get_language();

  // Prepare the error message that will be displayed
  $error_message = ($lang === 'EN') ? "This page cannot be used while logged into an account." : "Cette page n'est pas utilisable lorsque vous êtes connecté à un compte.";

  // If the user is logged in, throw the error
  if(user_is_logged_in())
    error_page($error_message);
}




/**
 * Allows access only to banned users.
 *
 * Any guest or non-banned user will get redirected to the homepage.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @return  void
 */

function user_restrict_to_banned() : void
{
  // Fetch the path to the website's root
  $path = root_path();

  // Check if the user is logged out or logged in but not banned, then redirect them
  if(!user_is_logged_in() || !user_is_banned())
    exit(header("Location: ".$path."index"));
}




/**
 * Allows access only to fully IP banned users.
 *
 * Any non IP banned user will get redirected to the homepage.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @return  void
 */

function user_restrict_to_ip_banned() : void
{
  // Fetch the path to the website's root
  $path = root_path();

  // Check if the user isn't fully IP banned, then redirect them
  if(user_is_ip_banned() < 2)
    exit(header("Location: ".$path."index"));
}




/**
 * Allows access only to users who aren't IP banned.
 *
 * Any IP banned user will get redirected to the homepage.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @return  void
 */

function user_restrict_to_non_ip_banned() : void
{
  // Fetch the path to the website's root
  $path = root_path();

  // Check if the user isn't fully IP banned, then redirect them
  if(user_is_ip_banned())
    exit(header("Location: ".$path."index"));
}




/**
 * NSFW filter settings of the current user.
 *
 * There are several levels of NSFW filters, all this function does is return the current level of the user.
 * If the user is logged out, all NSFW content should be hidden by default.
 *
 * @return  int   The current NSFW filter level of the user.
 */

function user_settings_nsfw() : int
{
  // If the user isn't logged in, return 0
  if(!user_is_logged_in())
    return 0;

  // Sanitize the user id
  $user_id = sanitize($_SESSION['user_id'], 'int', 0);

  // Check if the data is saved in the session
  if(isset($_SESSION['settings_nsfw']))
    return $_SESSION['settings_nsfw'];

  // Fetch the current nsfw level of the user
  $dnsfw = mysqli_fetch_array(query(" SELECT  users_settings.show_nsfw_content AS 'user_nsfw'
                                      FROM    users_settings
                                      WHERE   users_settings.fk_users = '$user_id' "));

  // Save the user's nsfw settings in the session
  $_SESSION['settings_nsfw'] = $dnsfw['user_nsfw'];

  // Return the user's nsfw settings
  return $dnsfw['user_nsfw'];
}




/**
 * Third party content privacy settings of the current user.
 *
 * This function returns whether the user wants to hide any third party data when browsing the website.
 * If the user is logged out, all third party content should be allowed by default.
 *
 * @return  array   The current third party privacy settings of the user, in the form of an array.
 */

function user_settings_privacy() : array
{
  // By default, set all of the privacy values to 0
  $privacy_youtube    = 0;
  $privacy_trends     = 0;
  $privacy_discord    = 0;
  $privacy_kiwiirc    = 0;
  $privacy_online     = 0;

  // If the user is logged in, fetch their third party privacy settings
  if(user_is_logged_in())
  {
    // Sanitize the user id
    $user_id = sanitize($_SESSION['user_id'], 'int', 0);

    // Check if the settings are set in the session
    if(isset($_SESSION['settings_privacy']))
    {
      // Set the privacy values to those set in the session
      $privacy_youtube  = $_SESSION['settings_privacy']['youtube'];
      $privacy_trends   = $_SESSION['settings_privacy']['trends'];
      $privacy_discord  = $_SESSION['settings_privacy']['discord'];
      $privacy_kiwiirc  = $_SESSION['settings_privacy']['kiwiirc'];
      $privacy_online   = $_SESSION['settings_privacy']['online'];
    }

    // Otherwise, fetch the settings
    else
    {
      $dprivacy = mysqli_fetch_array(query("  SELECT  users_settings.hide_youtube       AS 'user_youtube' ,
                                                      users_settings.hide_google_trends AS 'user_trends'  ,
                                                      users_settings.hide_discord       AS 'user_discord' ,
                                                      users_settings.hide_kiwiirc       AS 'user_kiwiirc' ,
                                                      users_settings.hide_from_activity AS 'user_online'
                                              FROM    users_settings
                                              WHERE   users_settings.fk_users = '$user_id' "));

      // Set them in the session
      $_SESSION['settings_privacy'] = array(  'youtube' => $dprivacy['user_youtube']  ,
                                              'trends'  => $dprivacy['user_trends']   ,
                                              'discord' => $dprivacy['user_discord']  ,
                                              'kiwiirc' => $dprivacy['user_kiwiirc']  ,
                                              'online'  => $dprivacy['user_online']   );

      // Set the privacy values to those wanted by the user
      $privacy_youtube  = $dprivacy['user_youtube'];
      $privacy_trends   = $dprivacy['user_trends'];
      $privacy_discord  = $dprivacy['user_discord'];
      $privacy_kiwiirc  = $dprivacy['user_kiwiirc'];
      $privacy_online   = $dprivacy['user_online'];
    }
  }

  // Return those privacy settings, neatly folded in a cozy array
  return array( 'youtube' => $privacy_youtube ,
                'trends'  => $privacy_trends  ,
                'discord' => $privacy_discord ,
                'kiwiirc' => $privacy_kiwiirc ,
                'online'  => $privacy_online  );
}




/**
 * Finds when the oldest user registered on the website.
 *
 * @return  int   The year at which the oldest account was created.
 */

function user_get_oldest() : int
{
  // Fetch the oldest user's registration date
  $qoldest = mysqli_fetch_array(query(" SELECT  MIN(users_profile.created_at) AS 'u_min'
                                        FROM    users_profile "));

  // Return the registration year
  return isset($qoldest['u_min']) ? date('Y', $qoldest['u_min']) : date('Y');
}



/**
 * Returns all the years during which a user was born.
 *
 * @return  array   The birth years.
 */

function user_get_birth_years() : array
{
  // Fetch the birth years
  $qbirths = query("  SELECT    YEAR(users_profile.birthday) AS 'u_year'
                      FROM      users_profile
                      WHERE     users_profile.birthday != '0000-00-00'
                      GROUP BY  YEAR(users_profile.birthday)
                      ORDER BY  YEAR(users_profile.birthday) DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qbirths); $i++)
    $data[$i]['year'] = sanitize_output($row['u_year']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Generates a random username for a guest.
 *
 * The usernames are taken from an array of possible words instead of a database to minimize queries.
 * It doesn't create the best usernames, but hey, good enough.
 *
 * @param   string  $lang  (OPTIONAL)  The language in which the username will be generated.
 *
 * @return  string                      The randomly generated username.
 */

function user_generate_random_username( string $lang = 'EN' ) : string
{
  // English logic
  if($lang === 'EN')
  {
    // Random word list: A main qualifier
    $qualifier1 = array("Lonely ", "Cute ", "Mr. ", "Ms. ", "President ", "Generic ", "Dirty ", "The ", "Forever ", "Never ", "Always ", "Painful ", "Very ", "Ugly ", "Dangerously ", "Mysterious ", "Chaotic ", "Pale ", "Funny ", "Cute ", "One eyed ", "European ", "American ", "Asian ", "Silly ", "Millenial ", "Dirty ", "Techno ", "Tired ", "Horned ", "Dead ", "Cool ", "Naked ", "Overcooked ", "Raw ", "One ", "First ", "Past ", "Some ");

    // Random word list: A second qualifier that goes after the first one name
    $qualifier2 = array("small ", "big ", "tall ", "pretty ", "beautiful ", "soft ",  "nice ", "evil ", "thin ", "tiny ", "last ", "unique ", "ex-", "mega ", "micro ", "strong ", "half ", "future ", "second ", "meta-", "long ", "double ", "simple ", "vicious ", "mini ", "blue ", "red ", "lazy ", "odd ", "black ", "white ", "pink ", "clever ", "super", "", "", "", "", "");

    // Random word list: The core name that will be assigned to the guest
    $core_name = array("bear", "bird", "cat", "dog", "duck", "pidgeon", "bean", "tree", "rodent", "honeypot", "lawn", "peasant", "crumb", "goat", "elephant", "wild boar", "newspaper", "monkey", "heart", "seal", "dummy", "princess", "monster", "furniture", "wasp", "robot", "underwear", "cousin", "brother", "internet", "dude", "buddy", "rat", "sheep", "VIP", "pope", "blood cell", "opponent", "poo", "poopie", "king", "queen");

    // Asemble and return the username
    return $qualifier1[rand(0,(count($qualifier1)-1))].$qualifier2[rand(0,(count($qualifier2)-1))].$core_name[rand(0,(count($core_name)-1))];
  }

  // French logic
  if($lang === 'FR')
  {
    // Random word list: The first qualifier should end with a space if it's not directly attached to the core name
    $qualifier1 = array("Petit ", "Gros ", "Sale ", "Grand ", "Beau ", "Doux ", "Un ", "Premier ", "Gentil ", "Méchant ", "Le ", "Capitaine ", "Quel ", "Saint ", "Chétif ", "Président ", "Général ", "Dernier ", "L'unique ", "Ex-", "Archi ", "Méga ", "Micro ", "Fort ", "Demi ", "Futur ", "Second ", "Meta-", "Long ", "Double ", "Simple ", "Fourbe ", "Mini ");

    // Random word list: The core name that will be assigned to the guest
    $core_name = array("ours", "oiseau", "chat", "chien", "canard", "pigeon", "haricot", "arbre", "rongeur", "pot de miel", "gazon", "paysan", "crouton", "mollusque", "bouc", "éléphant", "sanglier", "journal", "singe", "cœur", "félin", "", "morse", "phoque", "miquet", "kévin", "monstre", "meuble", "frelon", "robot", "slip", "cousin", "frère", "internet", "type", "copain", "raton", "mouton", "VIP", "pape", "globule", "adversaire", "caca", "crotiau", "roi", "prince");

    // Random word list: A second qualifier that goes after the core name
    $qualifier2 = array("solitaire", "mignon", "moche", "farouche", "mystérieux", "lourdingue", "glandeur", "douteux", "noir", "blanc", "rose", "mauve", "chaotique", "pâle", "raciste", "rigolo", "choupinet", "borgne", "douteux", "baltique", "fatigué", "", "peureux", "millénaire", "bouseux", "crade", "des champs", "des villes", "des plaines", "urbain", "sourd", "techno", "fatigué", "cornu", "mort", "cool", "moelleux", "futé", "gourmand", "en slip", "naturiste", "trop cuit", "cru");

    // Asemble and return the username
    return $qualifier1[rand(0,(count($qualifier1)-1))].$core_name[rand(0,(count($core_name)-1))]." ".$qualifier2[rand(0,(count($qualifier2)-1))];
  }
}