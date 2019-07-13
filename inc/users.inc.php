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
 * Look, I just don't trust PHP sessions. I'm not a fan of them, ok? Call this instead of session_start().
 * A new session token is generated on every page load, to ensure full regen of everything.
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
 * Returns a user's nickname from his id.
 *
 * @param   int   $user_id  (OPTIONAL)  If no id is specified, it will try to return the nickname of the current user
 *
 * @return  string                      The user's nickame.
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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de check si modérateur d'une section à partir de l'id de l'user
// Renvoie 1 si l'user est modérateur de la section, 0 s'il ne l'est pas
//
// Exemple d'utilisation:
// getmod('irl','1');

function getmod($section=NULL, $user=NULL)
{
  // Si on spécifie pas d'user, on prend la session en cours
  if(!$user && isset($_SESSION['user_id']))
    $user = $_SESSION['user_id'];

  // Si on a pas d'user, on renvoie 0
  if(!$user)
    return 0;

  // Si c'est un mod de la section concernée, on renvoie 1
  if($section)
  {
    $qdroits = mysqli_fetch_array(query(" SELECT users.moderator_rights FROM users WHERE id = '$user' AND moderator_rights LIKE '%$section%' "));
    if($qdroits['moderator_rights'])
      return 1;
  }

  // Si on ne spécifie pas de section, on va vérifier si c'est un mod et on renvoie 1 si oui
  if(!$section)
  {
    $qdroits = mysqli_fetch_array(query(" SELECT users.moderator_rights FROM users WHERE id = '$user' AND moderator_rights != '' "));
    if($qdroits['moderator_rights'])
      return 1;
  }

  // Si c'est un sysop ou un admin, on renvoie aussi 1
  $qdroits = mysqli_fetch_array(query(" SELECT users.is_global_moderator, users.is_administrator FROM users WHERE id = '$user' "));
  if($qdroits['is_global_moderator'] || $qdroits['is_administrator'])
    return 1;

  // Sinon on renvoie 0
  return 0;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de check si sysop à partir de l'id de l'user
// Renvoie 1 si l'user est sysop, 0 s'il ne l'est pas
//
// Exemple d'utilisation:
// getsysop('1');

function getsysop($user=NULL)
{
  // Si on a pas de session en cours, on renvoie 0
  if(!$user && !isset($_SESSION['user_id']))
    return 0;

  // Si on spécifie pas d'user, on prend la session en cours
  if(!$user && isset($_SESSION['user_id']))
    $user = $_SESSION['user_id'];

  // On vérifie si l'user est sysop ou admin
  $ddroits = mysqli_fetch_array(query(" SELECT  users.is_global_moderator ,
                                                users.is_administrator
                                        FROM    users
                                        WHERE   users.id = '$user' "));
  if($ddroits['is_global_moderator'] || $ddroits['is_administrator'])
    return 1;
  else
    return 0;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de check si admin à partir de l'id de l'user
// Renvoie 1 si l'user est admin, 0 s'il ne l'est pas
//
// Exemple d'utilisation:
// getadmin('1');

function getadmin($user=NULL)
{
  // Si on spécifie pas d'user, on prend la session en cours
  if(!$user && isset($_SESSION['user_id']))
    $user = $_SESSION['user_id'];

  // Si on a pas d'user, on renvoie 0
  if(!$user)
    return 0;

  // On vérifie si l'user est admin
  $ddroits = mysqli_fetch_array(query(" SELECT  users.is_administrator
                                        FROM    users
                                        WHERE   users.id = '$user' "));
    return $ddroits['is_administrator'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'est pas un sysop
// Si le second paramètre est rempli, autorise également les modérateurs d'une section spécifique
//
// Exemple d'utilisation:
// sysoponly('FR', 'irls');

function sysoponly($lang='FR', $section=NULL)
{
  // On prépare le message selon la langue
  $message = ($lang == 'FR') ? "Cette page est réservée aux administrateurs.<br><br>Ouste !" : 'This page is for admins only<br><br>Shoo!';

  // On vérifie si l'user est connecté et est un admin
  if(loggedin())
  {
    // On vérifie si l'user est un admin
    if(!$section)
    {
      if(!getsysop($_SESSION['user_id']))
        erreur($message);
    }
    else
    {
      if(!getsysop($_SESSION['user_id']) && !getmod($section,$_SESSION['user_id']))
        erreur($message);
    }
  }
  else
    erreur($message);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'est pas un admin
//
// Exemple d'utilisation:
// adminonly();

function adminonly($lang='FR')
{
  // On prépare le message selon la langue
  $message = ($lang == 'FR') ? "Cette page est réservée aux administrateurs.<br><br>Ouste !" : 'This page is for admins only<br><br>Shoo!';

  // On vérifie si l'user est connecté et est un admin
  if(loggedin())
  {
    // On vérifie si l'user est un admin
    if(!getadmin())
      erreur($message);
  }
  else
    erreur($message);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'est pas connecté
//
// Exemple d'utilisation:
// useronly();

function useronly($lang='FR')
{
  // On vérifie si l'user est connecté
  if(!loggedin())
  {
    // Trouver où on est sur le site
    // Similaire à la recherche de $chemin dans /inc/header.php

    // La base est différente selon si on est en localhost ou en prod
    if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1")
      $count_base = 3;
    else
      $count_base = 2;

    // Déterminer à combien de dossiers de la racine on est
    $longueur = count(explode( '/', $_SERVER['REQUEST_URI']));

    // Si on est à la racine, laisser le chemin tel quel
    if($longueur <= $count_base)
      $chemin = "";

    // Sinon, partir de ./ puis déterminer le nombre de ../ à rajouter
    else
    {
      $chemin = "./";
      for ($i=0 ; $i<($longueur-$count_base) ; $i++)
        $chemin .= "../";
    }

    if($lang == 'FR')
      erreur("<br>Cette page n'est utilisable que par les utilisateurs connectés.<br><br><br><a href=\"".$chemin."pages/user/login\"><button class=\"grosbouton\">SE CONNECTER</button></a><a href=\"".$chemin."pages/user/register\">&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"grosbouton button-outline\">CRÉER UN COMPTE</button></a>");
    else
      erreur("<br>This page is for registered users only.<br><br><br><a href=\"".$chemin."pages/user/login\"><button class=\"grosbouton\">LOGIN</button></a><a href=\"".$chemin."pages/user/register\">&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"grosbouton button-outline\">REGISTER</button></a>");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur est connecté
//
// Exemple d'utilisation:
// guestonly();

function guestonly($lang='FR')
{
  // On prépare le message selon la langue
  $message = ($lang == 'FR') ? "Cette page n'est accessible qu'aux invités." : "This page is accessible by guests only.";

  // On vérifie si l'user est connecté
  if(loggedin())
    erreur($message);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction renvoyant le niveau de NSFW que le membre désire voir
//
// Exemple d'utilisation:
// niveau_nsfw();

function niveau_nsfw()
{
  // Si l'utilisateur n'est pas connecté, on floute tout
  if(!loggedin())
    return 0;

  // Sinon, on va chercher le niveau de NSFW
  $membre_id  = sanitize($_SESSION['user_id'], 'int', 0);
  $dnsfw      = mysqli_fetch_array(query("  SELECT  users_settings.show_nsfw_content AS 'm_nsfw'
                                            FROM    users_settings
                                            WHERE   users_settings.fk_users = '$membre_id' "));
  return $dnsfw['m_nsfw'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction renvoyant le niveau de protection de la vie privée que le membre a choisi, sous forme de tableau
//
// Exemple d'utilisation:
// niveau_vie_privee();

function niveau_vie_privee()
{
  // Si l'utilisateur n'est pas connecté, on floute tout
  if(!loggedin())
    return 0;

  // On va chercher les options de l'utilisateur
  $membre_id  = sanitize($_SESSION['user_id'], 'int', 0);
  $dvieprivee = mysqli_fetch_array(query("  SELECT  users_settings.hide_tweets         AS 'm_twitter'  ,
                                                    users_settings.hide_youtube        AS 'm_youtube'  ,
                                                    users_settings.hide_google_trends  AS 'm_trends'
                                            FROM    users_settings
                                            WHERE   users_settings.fk_users = '$membre_id' "));

  // Et on renvoie tout ça dans un tableau
  return array( 'twitter' => $dvieprivee['m_twitter'] ,
                'youtube' => $dvieprivee['m_youtube'] ,
                'trends'  => $dvieprivee['m_trends'] );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction générant un surnom aléatoire pour un invité
//
// Utilisation: surnom_mignon();

function surnom_mignon()
{
  // Liste de mots (les adjectif1 doivent prendre un espace s'ils ne se collent pas au nom)
  $adjectif1 = array("Petit ", "Gros ", "Sale ", "Grand ", "Bel ", "Doux ", "L'", "Un ", "Cet ", "Ce ", "Premier ", "Gentil ", "Méchant ", "Bout d'", "Le ", "Capitaine ", "Quel ", "Saint ", "Chétif ", "Président ", "Général ", "Dernier ", "L'unique ", "Ex ", "Archi ", "Méga ", "Micro ", "Fort ", "Demi ", "Cadavre de ", "Âme d'", "Fils du ", "Futur ", "Second ", "Meta-");

  $nom = array("ours", "oiseau", "chat", "chien", "canard", "pigeon", "haricot", "arbre", "rongeur", "pot de miel", "indien", "gazon", "paysan", "crouton", "mollusque", "bouc", "éléphant", "sanglier", "journal", "singe", "cœur", "félin", "", "morse", "phoque", "miquet", "kévin", "monstre", "meuble", "frelon", "robot", "slip", "cousin", "frère", "internet", "type", "copain", "raton", "mouton", "VIP");

  $âdjectif2 = array("solitaire", "mignon", "moche", "farouche", "mystérieux", "con", "lourdingue", "glandeur", "douteux", "noir", "blanc", "rose", "mauve", "chaotique", "pâle", "raciste", "rigolo", "choupinet", "borgne", "douteux", "baltique", "fatigué", "", "peureux", "millénaire", "belge", "bouseux", "crade", "des champs", "urbain", "sourd", "techno", "fatigué", "cornu", "mort", "cool", "moelleux");

  // On assemble le surnom
  $surnom = $adjectif1[rand(0,(count($adjectif1)-1))].$nom[rand(0,(count($nom)-1))]." ".$âdjectif2[rand(0,(count($âdjectif2)-1))];

  // Et on balance la sauce
  return($surnom);
}