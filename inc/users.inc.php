<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// First off, we need to open a session and check the user's identity.
//
// TODO:  This whole process is really bad security wise, and inefficient too. It must be rewritten ASAP:
//          - It exposes the encryption method used for passwords.
//          - It forces me to make encrypt_data() insecure since it is called on every page load thus needs to be fast.
//          - It compares the cookie to every single user for some reason.
//          - It makes it possible to impersonate people.
//          - It does not use tokens for auth but rather something built from the nickname.
//          - The cookie name is stupid too tbh.
//          - Yeah I just plain don't like this whole thing. Also the comments are minimum effort.

// Let's begin by opening the session
secure_session_start();

// To store and retrieve identify, let's go check if there is a valid cookie
if(isset($_COOKIE['nobleme_memory']) && !isset($_GET['logout']))
{
  // We need to fetch a list of users
  $qusers = query(" SELECT  users.id        AS 'u_id' ,
                            users.nickname  AS 'u_nick'
                    FROM    users ");

  // Let's compare encrypted nicknames to the cookie's contents
  $cookie_ok = 0;
  while($dusers = mysqli_fetch_array($qusers))
  {
    // We encrypt the nicknames
    $user_test = encrypt_data($dusers['u_nick']);

    // Then compare them to the data stored in the session cookie
    if ($user_test == $_COOKIE['nobleme_memory'])
    {
      $cookie_ok = 1;
      $cookie_id = $dusers['u_id'];
    }
  }

  // If we found a match, we can insert user id in a session variable
  if ($cookie_ok)
    $_SESSION['user_id'] = $cookie_id;

  // If not, then we should destroy the cookie
  else
    setcookie("nobleme_memory", "", time()-630720000, "/");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Next up, we can check if the user is connected and what his access rights are

// Let's figure out if the user is connected or not according to session data
$is_logged_in = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;

// Does the user have special permissions? (required by the header)
if(!$is_logged_in)
{
  // By default we assume he does not
  $is_admin             = 0;
  $is_global_moderator  = 0;
  $is_moderator         = 0;
}
else
{
  // Let's sanitize the user id, just in case
  $id_user = sanitize($is_logged_in, 'int', 0);

  // Now we can go look for his user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_administrator    AS 'm_admin'      ,
                                                users.is_global_moderator AS 'm_globalmod'  ,
                                                users.is_moderator        AS 'm_mod'
                                        FROM    users
                                        WHERE   users.id = '$id_user' "));

  // And we can set them as variables, which the header will use
  $is_admin             = $drights['m_admin'];
  $is_global_moderator  = ($is_admin || $drights['m_globalmod']) ? 1 : 0;
  $is_moderator         = $drights['m_mod'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Language management

// If there is no language in the session, we need to get one
if(!isset($_SESSION['lang']))
{
  // If there is no language cookie, then the default language, in case of no cookie, is set to french (for now)
  if(!isset($_COOKIE['nobleme_language']))
  {
    // We create the cookie and assign the language to the session
    setcookie("nobleme_language", 'FR' , 2147483647, "/");
    $_SESSION['lang'] = 'FR';
  }

  // If the language cookie exists, we set the session language to the one in the cookie
  else
    $_SESSION['lang'] = $_COOKIE['nobleme_language'];
}

// If the user clicks on the language flag, we need to change the language
if(isset($_GET['changelang']))
{
  // We get the language that the user is currently not using
  $changelang = ($_SESSION['lang'] == 'EN') ? 'FR' : 'EN';

  // Then change the cookie and session language to the new one
  setcookie("nobleme_language", $changelang , 2147483647 , "/");
  $_SESSION['lang'] = $changelang;
}

// If the URL contains a request to change language, then we fullfill that request
if(isset($_GET['english']) || isset($_GET['anglais']))
{
  // Change the cookie and session language to english on request
  setcookie("nobleme_language", "EN" , 2147483647 , "/");
  $_SESSION['lang'] = "EN";
}

// In case more than one language change request is being done, then english will be the final language
else if(isset($_GET['francais']) || isset($_GET['french']))
{
  // Change the cookie and session language to french on request
  setcookie("nobleme_language", "FR" , 2147483647 , "/");
  $_SESSION['lang'] = "FR";
}

// If we just changed language, then we clean up the URL and reload the page
if(isset($_GET['english']) || isset($_GET['anglais']) || isset($_GET['francais']) || isset($_GET['french']) || isset($_GET['changelang']))
{
  // We get rid of all the language related query parameters
  unset($_GET['english']);
  unset($_GET['anglais']);
  unset($_GET['francais']);
  unset($_GET['french']);
  unset($_GET['changelang']);

  // We re-build the URL, with all its other query parameters intact
  $url_self     = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_rebuild  = urldecode(http_build_query($_GET));
  $url_rebuild  = ($url_rebuild) ? $url_self.'?'.$url_rebuild : $url_self;

  // And we reload the page by giving it the cleaned up rebuilt URL
  exit(header("Location: ".$url_rebuild));
}

// After all this, we can use the $lang variable to store the language for the duration of the session
$lang = (!isset($_SESSION['lang'])) ? 'FR' : $_SESSION['lang'];

// We also initialize the $text array, which will be used to prepare translations for display in the page
$text = array();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// One final check: Let's see if the user is banned or not

// First off, to avoid infinite loops, we make sure that we aren't already on banned.php and that the user is logged in
if(substr($_SERVER["PHP_SELF"], -11) != "/banned.php" && user_is_logged_in())
{
  // We fetch user id from the session
  $id_user = $_SESSION['user_id'];

  // Let's sanitize the user id, just in case
  $id_user = sanitize($id_user, 'int', 0);

  // We need to check whether the user is banned, obviously
  $dbanned = mysqli_fetch_array(query(" SELECT  users.is_banned_until AS 'ban_end'
                                        FROM    users
                                        WHERE   users.id = '$id_user' "));

  // If the user is banned, we proceed
  if($dbanned["ban_end"])
  {
    // If the ban is still active, then we need to redirect the user
    if($dbanned["ban_end"] > time())
      exit(header("Location: ".$path."pages/user/banned"));

    // If the ban has ended, then we can remove it
    else
      query(" UPDATE  users
              SET     users.is_banned_until   = '0' ,
                      users.is_banned_because = ''
              WHERE   users.id                = '$id_user' ");
  }
}





/**
 * Starts a session.
 *
 * Look, I just don't trust PHP sessions. I'm not a fan of them, ok? Call this instead of session_start().
 * A new session token is generated on every page load, to ensure full regen of everything.
 *
 * @return void
 */

function secure_session_start()
{
  // This public token will be used to identify the session name
  $session_name = 'nobleme_session_secure';

  // This is where it gets tricky, we'll force this session to only use cookies
  if (ini_set('session.use_only_cookies', 1) === FALSE) {
      exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Can not start secure session. Please enable cookies.</body></html>');
  }

  // Then we go fetch the current cookie
  $cookieParams = session_get_cookie_params();

  // We prepare a session cookie every time we load a new page
  session_set_cookie_params(  $cookieParams["lifetime"] ,
                              $cookieParams["path"]     ,
                              $cookieParams["domain"]   ,
                              false                     ,  // Enforce HTTPS - TODO be brave and set it to true
                              true                      ); // Ensures this can't be caught by js

  // Now we can actually start the session
  session_name($session_name);
  session_start();
  session_regenerate_id();
}




/**
 * Encrypts data.
 *
 * This is the function used to hash passwords or other data.
 *
 * @param string    $data               The data to encrypt.
 * @param int|null  $old    (OPTIONAL)  Will use the old (insecure) encryption method instead of the current one.
 *
 * @return string                       The encrypted data.
 */

function encrypt_data($data, $old=NULL)
{
  // If we are using the old method, we call crypt
  if($old)
    return crypt($data, $GLOBALS['salt_key']);

  // If not, then we use sha1 with our salt key
  else
    return sha1($data.$GLOBALS['salt_key']);
}




/**
 * Checks whether the user is logged in.
 *
 * @return boolean  Simply enough returns true/1 if logged in, false/0 if logged out.
 */

function user_is_logged_in()
{
  // As simple as it seems, we grab the value in the session
  return isset($_SESSION['user_id']);
}




/**
 * Logs the user out of his account.
 *
 * @return void
 */

function user_log_out()
{
  // First we destroy the session cookie
  setcookie('nobleme_memory', '', time()-630720000, "/");

  // Then we destroy the session itself
  session_destroy();

  // And finally we reload the whole page
  exit(header("location: ".$_SERVER['PHP_SELF']));
}




/**
 * Returns a user's id.
 *
 * @return int The user's id / 0 if logged out.
 */

function user_get_id()
{
  // As simple as it sounds, we return the value stored in the session if the user is logged in, else 0
  return (user_is_logged_in()) ? $_SESSION['user_id'] : 0;
}




/**
 * Returns a user's nickname from his id.
 *
 * @param   int|null   $user_id  (OPTIONAL) If no id is specified, it will try to return the nickname of current user.
 *
 * @return  string                          The user's nickame.
 */

function user_get_nickname($user_id=NULL)
{
  // If no id is specified, we grab the one currently stored in the session
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no id is stored in the session, then this is a guest, we return nothing
  else if(!$user_id)
    return;

  // We need to sanitize the id
  $user_id = sanitize($user_id, 'int', 0);

  // Now we can go fetch the nickname
  $dnickname = mysqli_fetch_array(query(" SELECT  users.nickname AS 'nickname'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // Whatever the database gave us (could be NULL), we return that
  return $dnickname['nickname'];
}




/**
 * Checks if an user has moderator rights (or above).
 *
 * Defaults to checking whether current user is a moderator unless the $user_id optional parameter is specified.
 *
 * @param   string|null  $website_section  (OPTIONAL)  Checks if the user has moderator rights over a specific area.
 * @param   int|null     $user_id          (OPTIONAL)  Checks if user with a specific id is a moderator.
 *
 * @return  bool                                  Returns 1 if the user has moderator rights, 0 if he doesn't.
 */

function user_is_moderator($website_section=NULL, $user_id=NULL)
{
  // If no user id is specified, we use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means we're logged out, in this case we can return 0
  if(!$user_id)
    return 0;

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Go fetch user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.moderator_rights    AS 'u_mod_area' ,
                                                users.is_moderator        AS 'u_mod'      ,
                                                users.is_global_moderator AS 'u_global'   ,
                                                users.is_administrator    AS 'u_admin'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // If user is an admin or a global mod, then we return 1
  if($drights['u_global'] || $drights['u_admin'])
    return 1;

  // If user is a moderator and there's no specified section, then we return 1
  if($drights['u_mod'] && !$website_section)
    return 1;

  // If user is a moderator and we specified a website section, then we check whether he is allowed to moderate it
  if($drights['u_mod'] && $website_section && strpos($drights['u_mod_area'], $website_section))
    return 1;

  // If none of the above were matches, then the user shouldn't have access and we can return 0
  return 0;
}




/**
 * Checks if an user is a global moderator (or above).
 *
 * Defaults to checking whether current user is a global moderator unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  Checks if user with a specific id is a global moderator.
 *
 * @return  bool                            Returns 1 if the user has global moderator rights, 0 if he doesn't.
 */

function user_is_global_moderator($user_id=NULL)
{
  // If no user id is specified, we use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means we're logged out, in this case we can return 0
  if(!$user_id)
    return 0;

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Go fetch user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_global_moderator AS 'u_global' ,
                                                users.is_administrator    AS 'u_admin'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // If user is an admin or a global mod, then we return 1
  if($drights['u_global'] || $drights['u_admin'])
    return 1;

  // If none of the above were matches, then the user shouldn't have access and we can return 0
  return 0;
}




/**
 * Checks if an user is an administrator.
 *
 * Defaults to checking whether current user is an administrator unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  Checks if user with a specific id is an administrator.
 *
 * @return  bool                            Returns 1 if the user has administrator rights, 0 if he doesn't.
 */

function user_is_administrator($user_id=NULL)
{
  // If no user id is specified, we use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means we're logged out, in this case we can return 0
  if(!$user_id)
    return 0;

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Go fetch user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_administrator AS 'u_admin'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // We return 1 if the user is an administrator, 0 if he isn't
  return $drights['u_admin'];
}




/**
 * Allows access only to global or local moderators (or above).
 *
 * Any user who does not have the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @param   string|null $lang             (OPTIONAL)  The language used in the error message.
 * @param   string|null $website_section  (OPTIONAL)  The section of the website on which moderators must have rights.
 *
 * @return  void
 */

function user_restrict_to_moderators($lang='EN', $website_section=NULL)
{
  // We prepare the error message that will be displayed
  $error_message = ($lang == 'EN') ? "This page is restricted to website staff only." : "Cette page est réservée aux équipes de modération du site.";

  // First off, we check if the user is logged in
  if(user_is_logged_in())
  {
    // If no website section is specified, we check if the user has global moderator rights, else we throw the error
    if(!$website_section)
    {
      if(!user_is_global_moderator($_SESSION['user_id']))
        error_page($error_message);
    }
    // If a section is specified, we check if the user has global or local moderator rights, else we throw the error
    else
    {
      if(!user_is_global_moderator($_SESSION['user_id']) && !user_is_moderator($website_section, $_SESSION['user_id']))
        error_page($error_message);
    }
  }
  // If the user is logged out, we throw the error
  else
    error_page($error_message);
}




/**
 * Allows access only to administartors.
 *
 * Any user who does not have the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @param   string|null $lang (OPTIONAL)  The language used in the error message.
 *
 * @return  void
 */

function user_restrict_to_administrators($lang='EN')
{
  // We prepare the error message that will be displayed
  $error_message = ($lang == 'EN') ? "This page is restricted to website administrators only." : "Cette page est réservée aux équipes d'administration du site.";

  // First off, we check if the user is logged in
  if(user_is_logged_in())
  {
    // If the user isn't an administrator, we throw the error
    if(!user_is_administrator())
      error_page($error_message);
  }
  // If the user is logged out, we throw the error
  else
    error_page($error_message);
}




/**
 * Allows access only to logged in users.
 *
 * Any user who does not have the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @param   string|null $lang (OPTIONAL)  The language used in the error message.
 * @param   string|null $path (OPTIONAL)  The relative path to the root of the website (defaults to 2 folders away).
 *
 * @return  void
 */

function user_restrict_to_users($lang='EN', $path="./../../")
{
  // If the user is not logged in, we throw an error page asking the user to log in or register
  if(!user_is_logged_in())
  {
    if($lang == 'EN')
      error_page("This page is restricted to logged in users.<br><a href=\"".$path."pages/user/login\"><button class=\"grosbouton login_register_gap above_login_button\">LOGIN</button></a><a href=\"".$path."pages/user/register\"><button class=\"grosbouton button-outline\">REGISTER</button></a>");
    else
      error_page("Cette page est réservée aux utilisateurs connectés.<br><a href=\"".$path."pages/user/login\"><button class=\"grosbouton login_register_gap above_login_button\">SE CONNECTER</button></a><a href=\"".$path."pages/user/register\"><button class=\"grosbouton button-outline\">CRÉER UN COMPTE</button></a>");
  }
}




/**
 * Allows access only to guests (not logged into an account).
 *
 * Any user who does not have the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @param   string|null $lang (OPTIONAL)  The language used in the error message.
 *
 * @return  void
 */

function user_restrict_to_guests($lang='EN')
{
  // We prepare the error message that will be displayed
  $error_message = ($lang == 'EN') ? "This page cannot be used while logged into an account." : "Cette page n'est pas utilisable lorsque vous êtes connecté à un compte.";

  // If the user is logged in, we throw the error
  if(user_is_logged_in())
    error_page($error_message);
}




/**
 * NSFW filter settings of the current user.
 *
 * There are several levels of NSFW filters, all this function does is return the current level of the user.
 * If the user is logged out, we consider that we should hide all NSFW content by default.
 *
 * @return int The current NSFW filter level of the user.
 */

function user_settings_nsfw()
{
  // If the user isn't logged in, then we return 0
  if(!user_is_logged_in())
    return 0;

  // We sanitize the user id
  $user_id = sanitize($_SESSION['user_id'], 'int', 0);

  // We fetch the current nsfw level of the user
  $dnsfw = mysqli_fetch_array(query(" SELECT  users_settings.show_nsfw_content AS 'user_nsfw'
                                      FROM    users_settings
                                      WHERE   users_settings.fk_users = '$user_id' "));

  // We return whichever value we got from the database
  return $dnsfw['user_nsfw'];
}




/**
 * Third party content privacy settings of the current user.
 *
 * This function returns whether the user wants to hide any Twitter, Youtube, etc. data when browsing the website.
 * If the user is logged out, we consider that we should show all third party content by default.
 *
 * @return array The current third party privacy settings of the user, in the form of an array.
 */

function user_settings_privacy()
{
  // By default, we set all of the privacy values to 0
  $privacy_twitter  = 0;
  $privacy_youtube  = 0;
  $privacy_trends   = 0;

  // If the user is logged in, we go fetch his third party privacy settings
  if(user_is_logged_in())
  {
    // We sanitize the user id
    $user_id = sanitize($_SESSION['user_id'], 'int', 0);

    // We go fetch the required settings
    $dprivacy = mysqli_fetch_array(query("  SELECT  users_settings.hide_tweets         AS 'user_twitter'  ,
                                                    users_settings.hide_youtube        AS 'user_youtube'  ,
                                                    users_settings.hide_google_trends  AS 'user_trends'
                                            FROM    users_settings
                                            WHERE   users_settings.fk_users = '$user_id' "));

    // We set the privacy values to those wanted by the user
    $privacy_twitter  = $dprivacy['user_twitter'];
    $privacy_youtube  = $dprivacy['user_youtube'];
    $privacy_trends   = $dprivacy['user_trends'];
  }

  // We can now return those privacy settings, neatly folded in a cozy array
  return array( 'twitter' => $privacy_twitter ,
                'youtube' => $privacy_youtube ,
                'trends'  => $privacy_trends  );
}




/**
 * Generates a random nickname for a guest.
 *
 * The nicknames are taken from an array of possible words instead of a database to minimize queries.
 * It doesn't create the best nicknames, but hey, good enough.
 * The nickname returned is in french. There is no english equivalent to this function for now. Sorry.
 *
 * @return string The randomly generated nickname.
 */

function user_generate_random_nickname()
{
  // Random word list: The first qualifier should end with a space if it's not directly attached to the core name
  $qualifier1 = array("Petit ", "Gros ", "Sale ", "Grand ", "Beau ", "Doux ", "Un ", "Premier ", "Gentil ", "Méchant ", "Le ", "Capitaine ", "Quel ", "Saint ", "Chétif ", "Président ", "Général ", "Dernier ", "L'unique ", "Ex-", "Archi ", "Méga ", "Micro ", "Fort ", "Demi ", "Futur ", "Second ", "Meta-", "Long ", "Double ", "Simple ", "Fourbe ", "Mini ");

  // Random word list: The core name that will be assigned to the guest
  $core_name = array("ours", "oiseau", "chat", "chien", "canard", "pigeon", "haricot", "arbre", "rongeur", "pot de miel", "gazon", "paysan", "crouton", "mollusque", "bouc", "éléphant", "sanglier", "journal", "singe", "cœur", "félin", "", "morse", "phoque", "miquet", "kévin", "monstre", "meuble", "frelon", "robot", "slip", "cousin", "frère", "internet", "type", "copain", "raton", "mouton", "VIP", "pape", "globule", "adversaire", "caca", "crotiau", "roi", "prince");

  // Random word list: A second qualifier that goes after the core name
  $qualifier2 = array("solitaire", "mignon", "moche", "farouche", "mystérieux", "lourdingue", "glandeur", "douteux", "noir", "blanc", "rose", "mauve", "chaotique", "pâle", "raciste", "rigolo", "choupinet", "borgne", "douteux", "baltique", "fatigué", "", "peureux", "millénaire", "bouseux", "crade", "des champs", "des villes", "des plaines", "urbain", "sourd", "techno", "fatigué", "cornu", "mort", "cool", "moelleux", "futé", "gourmand", "en slip", "naturiste", "trop cuit", "cru");

  // Now we can assemble and return the nickname
  return $qualifier1[rand(0,(count($qualifier1)-1))].$core_name[rand(0,(count($core_name)-1))]." ".$qualifier2[rand(0,(count($qualifier2)-1))];
}