<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Begin by opening a session and checking the user's identity.
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

// To store and retrieve identify, go check if there is a valid cookie
if(isset($_COOKIE['nobleme_memory']) && !isset($_GET['logout']))
{
  // Fetch a list of users
  $qusers = query(" SELECT  users.id        AS 'u_id' ,
                            users.nickname  AS 'u_nick'
                    FROM    users ");

  // Compare encrypted nicknames to the cookie's contents
  $cookie_ok = 0;
  while($dusers = mysqli_fetch_array($qusers))
  {
    // Encrypt the nicknames
    $user_test = encrypt_data($dusers['u_nick']);

    // Compare them to the data stored in the session cookie
    if ($user_test == $_COOKIE['nobleme_memory'])
    {
      $cookie_ok = 1;
      $cookie_id = $dusers['u_id'];
    }
  }

  // If there's a match, insert user id in a session variable
  if ($cookie_ok)
    $_SESSION['user_id'] = $cookie_id;

  // If not, destroy the cookie
  else
    setcookie("nobleme_memory", "", time()-630720000, "/");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Next up, check if the user is connected and what his access rights are

// Figure out if the user is connected or not according to session data
$is_logged_in = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;

// Does the user have special permissions? (required by the header)
if(!$is_logged_in)
{
  // By default, assume he does not
  $is_admin     = 0;
  $is_moderator = 0;
}
else
{
  // Sanitize the user id, just in case
  $id_user = sanitize($is_logged_in, 'int', 0);

  // Go look for his access rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_administrator  AS 'm_admin' ,
                                                users.is_moderator      AS 'm_mod'
                                        FROM    users
                                        WHERE   users.id = '$id_user' "));

  // Set them as variables, which the header will use
  $is_admin     = $drights['m_admin'];
  $is_moderator = ($is_admin || $drights['m_mod']) ? 1 : 0;

  // If the user's account doesn't exist, log him out and set all permissions to 0
  if($drights['m_admin'] === null)
  {
    user_log_out();
    $is_admin     = 0;
    $is_moderator = 0;
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Language management

// If there is no language in the session, assign one
if(!isset($_SESSION['lang']))
{
  // If there is no language cookie, then the default language is fetched from the browser's accept language headers
  if(!isset($_COOKIE['nobleme_language']))
  {
    // Fetch the language settings (default to english if it isn't french)
    $language_header = (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == 'fr') ? 'FR' : 'EN';

    // Create the cookie and the session variable
    setcookie("nobleme_language", $language_header , 2147483647, "/");
    $_SESSION['lang'] = $language_header;
  }

  // If the language cookie exists, set the session language to the one in the cookie
  else
    $_SESSION['lang'] = $_COOKIE['nobleme_language'];
}

// If the user clicks on the language flag, change the language accordingly
if(isset($_GET['changelang']))
{
  // Get the language that the user is currently not using
  $changelang = ($_SESSION['lang'] == 'EN') ? 'FR' : 'EN';

  // Change the cookie and session language to the new one
  setcookie("nobleme_language", $changelang , 2147483647 , "/");
  $_SESSION['lang'] = $changelang;
}

// If the URL contains a request to change to a specific language, then fullfill that request
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
// One final check: Is the user banned

// First off, to avoid infinite loops, make sure that the user is loggsed in and isn't already on the banned.php page
if(substr($_SERVER["PHP_SELF"], -11) != "/banned.php" && user_is_logged_in())
{
  // Check whether the user is banned - if yes, redirect them to the banned page
  if(user_is_banned($_SESSION['user_id']))
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

function secure_session_start()
{
  // This public token will be used to identify the session name
  $session_name = 'nobleme_session_secure';

  // This is where it gets tricky: force this session to only use cookies or block execution of the application
  if (ini_set('session.use_only_cookies', 1) === FALSE) {
      exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Can not start secure session. Please enable cookies.</body></html>');
  }

  // Fetch the current cookie
  $cookieParams = session_get_cookie_params();

  // Prepare a session cookie every time a new page is loaded
  session_set_cookie_params(  $cookieParams["lifetime"]             ,
                              $cookieParams["path"].';SameSite=lax' ,
                              $cookieParams["domain"]               ,
                              false                                 ,  // Enforce HTTPS - TODO set this to true
                              true                                  ); // Ensures this can't be caught by js

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
 * @param string    $data               The data to encrypt.
 * @param int|null  $old    (OPTIONAL)  Will use the old (insecure) encryption method instead of the current one.
 *
 * @return string                       The encrypted data.
 */

function encrypt_data(  $data         ,
                        $old  = NULL  )
{
  // If the old method is still being used, call crypt with the salt key
  if($old)
    return crypt($data, $GLOBALS['salt_key']);

  // If not, then use sha1 with the salt key
  else
    return sha1($data.$GLOBALS['salt_key']);
}




/**
 * Detects the user's language.
 *
 * @param   int|null  $user_id  (OPTIONAL)  Gets the language of a specified user instead of the current user.
 *
 * @return  string                          The user's language settings.
 */

function user_get_language($user_id = NULL)
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
  return ($dlanguage['language']) ? $dlanguage['language'] : 'EN';
}




/**
 * Checks whether the user is logged in.
 *
 * @return boolean  Simply enough returns true/1 if logged in, false/0 if logged out.
 */

function user_is_logged_in()
{
  // As simple as it seems, grab the value in the session
  return isset($_SESSION['user_id']);
}




/**
 * Logs the user out of his account.
 *
 * @return void
 */

function user_log_out()
{
  // Destroy the session cookie
  setcookie('nobleme_memory', '', time()-630720000, "/");

  // Destroy the session itself
  session_destroy();

  // Determine the path to the current page without the logout parameter
  unset($_GET['logout']);
  $url_self   = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_logout = urldecode(http_build_query($_GET));
  $url_logout = ($url_logout) ? $url_self.'?'.$url_logout : $url_self;

  // Reload the page
  exit(header("location: ".$url_logout));
}




/**
 * Returns a user's id.
 *
 * @return int The user's id / 0 if logged out.
 */

function user_get_id()
{
  // As simple as it sounds, return the value stored in the session if the user is logged in, else 0
  return (user_is_logged_in()) ? $_SESSION['user_id'] : 0;
}




/**
 * Returns a user's nickname from his id.
 *
 * @param   int|null   $user_id  (OPTIONAL) If no id is specified, it will try to return the nickname of current user.
 *
 * @return  string                          The user's nickame.
 */

function user_get_nickname($user_id = NULL)
{
  // If no id is specified, grab the one currently stored in the session
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no id is stored in the session, then this is a guest, return nothing
  else if(!$user_id)
    return;

  // Sanitize the provided id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch the user's nickname
  $dnickname = mysqli_fetch_array(query(" SELECT  users.nickname AS 'nickname'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // Return whatever the database returned (could be NULL)
  return $dnickname['nickname'];
}




/**
 * Checks if an user is a moderator (or above).
 *
 * Defaults to checking whether current user is a moderator unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  Checks if user with a specific id is a moderator.
 *
 * @return  bool                            Returns 1 if the user has moderator rights, 0 if he doesn't.
 */

function user_is_moderator($user_id = NULL)
{
  // If no user id is specified, use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means he is a guest, return 0
  if(!$user_id)
    return 0;

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_moderator      AS 'u_mod' ,
                                                users.is_administrator  AS 'u_admin'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // If user is an admin or a mod, return 1
  if($drights['u_mod'] || $drights['u_admin'])
    return 1;

  // If none of the above were matches, then the user shouldn't have access: return 0
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

function user_is_administrator($user_id = NULL)
{
  // If no user id is specified, use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means the user is a guest, in this case return 0
  if(!$user_id)
    return 0;

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch user rights
  $drights = mysqli_fetch_array(query(" SELECT  users.is_administrator AS 'u_admin'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

  // Return 1 if the user is an administrator, 0 if he isn't
  return $drights['u_admin'];
}




/**
 * Checks if an user is banned.
 *
 * Defaults to checking whether current user is banned unless the $user_id optional parameter is specified.
 *
 * @param   int|null  $user_id  (OPTIONAL)  Checks if user with a specific id is banned.
 *
 * @return  bool                            Returns 1 if the user is banned, 0 if he isn't.
 */

function user_is_banned($user_id = NULL)
{
  // If no user id is specified, use the current active session instead
  if(!$user_id && isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

  // If no user is specified, this means the user is a guest, in this case return 0
  if(!$user_id)
    return 0;

  // Sanitize user id
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch banned status
  $dbanned = mysqli_fetch_array(query(" SELECT  users.is_banned_until AS 'u_ban_end'
                                        FROM    users
                                        WHERE   users.id = '$user_id' "));

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
 * Unbans a banned user.
 *
 * @param   int   $user_id                  The user's ID.
 * @param   int   $unbanner_id  (OPTIONAL)  The ID of the moderator doing the unbanning.
 *
 * @return  void
 */

function user_unban(  $user_id          ,
                      $unbanner_id  = 0 )
{
  // Sanitize the data
  $user_id      = sanitize($user_id, 'int', 0);
  $unbanner_id  = sanitize($unbanner_id, 'int', 0);
  $timestamp    = sanitize(time(), 'int', 0);

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
}




/**
 * Allows access only to moderators (or above).
 *
 * Any user who does not have the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @param   string|null $lang (OPTIONAL)  The language used in the error message.
 *
 * @return  void
 */

function user_restrict_to_moderators($lang = 'EN')
{
  // Prepare the error message that will be displayed
  $error_message = ($lang == 'EN') ? "This page is restricted to website staff only." : "Cette page est réservée aux équipes d'administration du site.";

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
 * Allows access only to administrators.
 *
 * Any user who does not have the required rights will get rejected and see an error page.
 * Running this fuction interrupts the page with an exit() at the end if the user doesn't meet the correct permissions.
 *
 * @param   string|null $lang (OPTIONAL)  The language used in the error message.
 *
 * @return  void
 */

function user_restrict_to_administrators($lang = 'EN')
{
  // Prepare the error message that will be displayed
  $error_message = ($lang == 'EN') ? "This page is restricted to website administrators only." : "Cette page est réservée aux équipes d'administration du site.";

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

function user_restrict_to_users(  $lang = 'EN'        ,
                                  $path = "./../../"  )
{
  // If the user is logged out, throw an error page asking the user to log in or register
  if(!user_is_logged_in())
  {
    if($lang == 'EN')
      error_page("This page is restricted to logged in users.<br><br>Log in by clicking the <img src=\"".$path."img/icons/login.svg\" alt=\"Account\" class=\"icon valign_middle red\"> icon on the top right of the page", $path);
    else
      error_page("Cette page est réservée aux utilisateurs connectés.<br><br>Connectez vous en cliquant sur l'icône <img src=\"".$path."img/icons/login.svg\" alt=\"Account\" class=\"icon valign_middle red\"> en haut à droite de la page", $path);
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

function user_restrict_to_guests($lang = 'EN')
{
  // Prepare the error message that will be displayed
  $error_message = ($lang == 'EN') ? "This page cannot be used while logged into an account." : "Cette page n'est pas utilisable lorsque vous êtes connecté à un compte.";

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
 * @param   string|null $lang (OPTIONAL)  The language used in the error message.
 * @param   string|null $path (OPTIONAL)  The path to the root of the website.
 *
 * @return  void
 */

function user_restrict_to_banned( $path = './../../' )
{
  // Check if the user is logged out or logged in but not banned, then redirect them
  if(!user_is_logged_in() || !user_is_banned())
    exit(header("Location: ".$path."index"));
}




/**
 * NSFW filter settings of the current user.
 *
 * There are several levels of NSFW filters, all this function does is return the current level of the user.
 * If the user is logged out, all NSFW content should be hidden by default.
 *
 * @return int The current NSFW filter level of the user.
 */

function user_settings_nsfw()
{
  // If the user isn't logged in, return 0
  if(!user_is_logged_in())
    return 0;

  // Sanitize the user id
  $user_id = sanitize($_SESSION['user_id'], 'int', 0);

  // Fetch the current nsfw level of the user
  $dnsfw = mysqli_fetch_array(query(" SELECT  users_settings.show_nsfw_content AS 'user_nsfw'
                                      FROM    users_settings
                                      WHERE   users_settings.fk_users = '$user_id' "));

  // Return the user's nsfw settings
  return $dnsfw['user_nsfw'];
}




/**
 * Third party content privacy settings of the current user.
 *
 * This function returns whether the user wants to hide any Twitter, Youtube, etc. data when browsing the website.
 * If the user is logged out, all third party content should be allowed by default.
 *
 * @return array The current third party privacy settings of the user, in the form of an array.
 */

function user_settings_privacy()
{
  // By default, set all of the privacy values to 0
  $privacy_twitter  = 0;
  $privacy_youtube  = 0;
  $privacy_trends   = 0;

  // If the user is logged in, fetch his third party privacy settings
  if(user_is_logged_in())
  {
    // Sanitize the user id
    $user_id = sanitize($_SESSION['user_id'], 'int', 0);

    // Fetch the settings
    $dprivacy = mysqli_fetch_array(query("  SELECT  users_settings.hide_tweets        AS 'user_twitter' ,
                                                    users_settings.hide_youtube       AS 'user_youtube' ,
                                                    users_settings.hide_google_trends AS 'user_trends'
                                            FROM    users_settings
                                            WHERE   users_settings.fk_users = '$user_id' "));

    // Set the privacy values to those wanted by the user
    $privacy_twitter = $dprivacy['user_twitter'];
    $privacy_youtube = $dprivacy['user_youtube'];
    $privacy_trends  = $dprivacy['user_trends'];
  }

  // Return those privacy settings, neatly folded in a cozy array
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
 * @param   string|null  $lang  (OPTIONAL)  The language in which the nickname will be generated.
 *
 * @return  string                          The randomly generated nickname.
 */

function user_generate_random_nickname($lang = 'EN')
{
  // English logic
  if($lang == 'EN')
  {
    // Random word list: A main qualifier
    $qualifier1 = array("Lonely ", "Cute ", "Mr. ", "Ms. ", "President ", "Generic ", "Dirty ", "The ", "Forever ", "Never ", "Always ", "Painful ", "Very ", "Ugly ", "Dangerously ", "Mysterious ", "Chaotic ", "Pale ", "Funny ", "Cute ", "One eyed ", "European ", "American ", "Asian ", "Silly ", "Millenial ", "Dirty ", "Techno ", "Tired ", "Horned ", "Dead ", "Cool ", "Naked ", "Overcooked ", "Raw ", "One ", "First ", "Past ", "Some ");

    // Random word list: A second qualifier that goes after the first one name
    $qualifier2 = array("small ", "big ", "tall ", "pretty ", "beautiful ", "soft ",  "nice ", "evil ", "thin ", "tiny ", "last ", "unique ", "ex-", "mega ", "micro ", "strong ", "half ", "future ", "second ", "meta-", "long ", "double ", "simple ", "vicious ", "mini ", "blue ", "red ", "lazy ", "odd ", "black ", "white ", "pink ", "clever ", "super", "", "", "", "", "");

    // Random word list: The core name that will be assigned to the guest
    $core_name = array("bear", "bird", "cat", "dog", "duck", "pidgeon", "bean", "tree", "rodent", "honeypot", "lawn", "peasant", "crumb", "goat", "elephant", "wild boar", "newspaper", "monkey", "heart", "seal", "dummy", "princess", "monster", "furniture", "wasp", "robot", "underwear", "cousin", "brother", "internet", "dude", "buddy", "rat", "sheep", "VIP", "pope", "blood cell", "opponent", "poo", "poopie", "king", "queen");

    // Asemble and return the nickname
    return $qualifier1[rand(0,(count($qualifier1)-1))].$qualifier2[rand(0,(count($qualifier2)-1))].$core_name[rand(0,(count($core_name)-1))];
  }

  // French logic
  if($lang == 'FR')
  {
    // Random word list: The first qualifier should end with a space if it's not directly attached to the core name
    $qualifier1 = array("Petit ", "Gros ", "Sale ", "Grand ", "Beau ", "Doux ", "Un ", "Premier ", "Gentil ", "Méchant ", "Le ", "Capitaine ", "Quel ", "Saint ", "Chétif ", "Président ", "Général ", "Dernier ", "L'unique ", "Ex-", "Archi ", "Méga ", "Micro ", "Fort ", "Demi ", "Futur ", "Second ", "Meta-", "Long ", "Double ", "Simple ", "Fourbe ", "Mini ");

    // Random word list: The core name that will be assigned to the guest
    $core_name = array("ours", "oiseau", "chat", "chien", "canard", "pigeon", "haricot", "arbre", "rongeur", "pot de miel", "gazon", "paysan", "crouton", "mollusque", "bouc", "éléphant", "sanglier", "journal", "singe", "cœur", "félin", "", "morse", "phoque", "miquet", "kévin", "monstre", "meuble", "frelon", "robot", "slip", "cousin", "frère", "internet", "type", "copain", "raton", "mouton", "VIP", "pape", "globule", "adversaire", "caca", "crotiau", "roi", "prince");

    // Random word list: A second qualifier that goes after the core name
    $qualifier2 = array("solitaire", "mignon", "moche", "farouche", "mystérieux", "lourdingue", "glandeur", "douteux", "noir", "blanc", "rose", "mauve", "chaotique", "pâle", "raciste", "rigolo", "choupinet", "borgne", "douteux", "baltique", "fatigué", "", "peureux", "millénaire", "bouseux", "crade", "des champs", "des villes", "des plaines", "urbain", "sourd", "techno", "fatigué", "cornu", "mort", "cool", "moelleux", "futé", "gourmand", "en slip", "naturiste", "trop cuit", "cru");

    // Asemble and return the nickname
    return $qualifier1[rand(0,(count($qualifier1)-1))].$core_name[rand(0,(count($core_name)-1))]." ".$qualifier2[rand(0,(count($qualifier2)-1))];
  }
}