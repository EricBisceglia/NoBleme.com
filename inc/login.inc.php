<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ouverture de la session et vérification de l'identité

// Déjà, on ouvre la session
session_start_securise();

// Et maintenant, on va check si le cookie est légitime
if(isset($_COOKIE['nobleme_memory']) && !isset($_GET['logout']))
{
  // Allons chercher une liste des users existants
  $users = query(" SELECT membres.pseudonyme, membres.id FROM membres ");

  // Et comparons les pseudos saltés au contenu du cookie
  $cookie_ok = 0;
  while($userlist = mysqli_fetch_array($users))
  {
    // On sale l'user à tester
    $usertest = salage($userlist['pseudonyme']);

    // Et on compare
    if ($usertest == $_COOKIE['nobleme_memory'])
    {
      $cookie_ok = 1;
      $cookie_id = $userlist['id'];
    }
  }

  // Si c'est bon, on a plus qu'à assigner une session
  if ($cookie_ok)
    $_SESSION['user'] = $cookie_id;
  // Sinon, on détruit le cookie
  else
    setcookie("nobleme_memory", "", time()-630720000, "/");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérification de si l'user est banni

// On s'assure de pas être sur banned.php pour pas looper stupidement
if(substr($_SERVER["PHP_SELF"], -11) != "/banned.php" && loggedin())
{
  $userid = $_SESSION['user'];

  // On récupère les infos de ban sur l'user
  $queryban = query(" SELECT membres.banni_date FROM membres WHERE id = '$userid' ");

  while($databan = mysqli_fetch_array($queryban))
  {
    // On check si l'user est banni
    if($databan["banni_date"] != 0)
    {
      // On check si le ban est fini ou pas
      if($databan["banni_date"] > time())
      {
        // Redéfinition du $chemin
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
        // Redirection vers la page de ban
        header("Location: ".$chemin."pages/user/banned");
      }
      else
        // S'il est fini, on le retire
        query(" UPDATE  membres
                SET     membres.banni_date    = '0' ,
                        membres.banni_raison  = ''
                WHERE   membres.id            = '$userid' ");
    }
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Gestion du langage

// Détermination du langage s'il n'est pas encore déterminé
if(!isset($_SESSION['lang']))
{
  // Par défaut (si on a pas de cookie) en met en français
  if(!isset($_COOKIE['nobleme_language']))
  {
    setcookie("nobleme_language", 'FR' , time()+630720000, "/");
    $_SESSION['lang'] = 'FR';
  }
  // Sinon on lui donne la valeur du cookie
  else
    $_SESSION['lang'] = $_COOKIE['nobleme_language'];
}

// Changement de langage demandé en cliquant sur le drapeau
if(isset($_GET['changelang']))
{
  // On détermine le nouveau langage
  $changelang = ($_SESSION['lang'] == 'EN') ? 'FR' : 'EN';

  // On change le cookie de langage et la session en cours
  setcookie("nobleme_language", $changelang , time()+630720000, "/");
  $_SESSION['lang'] = $changelang;
}

// Changement de langage imposé par l'URL
if(isset($_GET['english']) || isset($_GET['anglais']))
{
  setcookie("nobleme_language", "EN" , time()+630720000, "/");
  $_SESSION['lang'] = "EN";
}
if(isset($_GET['francais']) || isset($_GET['french']))
{
  setcookie("nobleme_language", "FR" , time()+630720000, "/");
  $_SESSION['lang'] = "FR";
}

// Si on a changé le langage, on reload pour virer l'url spéciale
if(isset($_GET['english']) || isset($_GET['anglais']) || isset($_GET['francais']) || isset($_GET['french']) || isset($_GET['changelang']))
{
  // On vire les paramètres dont on ne veut plus dans l'url
  unset($_GET['english']);
  unset($_GET['anglais']);
  unset($_GET['francais']);
  unset($_GET['french']);
  unset($_GET['changelang']);

  // On reconstruit l'URL
  $url_self     = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_rebuild  = urldecode(http_build_query($_GET));
  $url_rebuild  = ($url_rebuild) ? $url_self.'?'.$url_rebuild : $url_self;

  // Et on recharge la page
  exit(header("Location: ".$url_rebuild));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle fonction de salage d'un mot de passe
// Renvoie le mot de passe salé
//
// Exemple d'utilisation:
// salage("monpass");

function salage($pass,$old=NULL)
{
  if($old)
    return crypt($pass,$GLOBALS['salage']);
  else
    return sha1($pass.$GLOBALS['salage']);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de logout
// Déconnecte tout simplement l'utilisateur

function logout()
{
  // Nullifier le cookie
  setcookie("nobleme_memory", "", time()-630720000, "/");

  // Détruire la session
  session_destroy();

  // Actualiser la page
  header("location: ".$_SERVER['PHP_SELF']."");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de vérification du login
// Renvoie TRUE si l'utilisateur est connecté, renvoie FALSE s'il n'est pas connecté

function loggedin()
{
  if(isset($_SESSION['user']))
    return TRUE;
  else
    return FALSE;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de récupération du pseudo
// Renvoie le pseudonyme de l'utilisateur à partir de son userid
//
// Exemple d'utilisation:
// getpseudo('1');

function getpseudo($id=NULL)
{
  // Si on spécifie pas d'id, on prend la session en cours
  if(!$id && isset($_SESSION['user']))
    $id = $_SESSION['user'];

  // Si on a pas d'id, on renvoie rien
  if(!$id)
    return '';

  // On renvoie le pseudonyme
  $qpseudo = mysqli_fetch_array(query(" SELECT membres.pseudonyme FROM membres WHERE id = '$id' "));
    return $qpseudo['pseudonyme'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de check si modérateur d'une section à partir de l'id de l'user
// Renvoie 1 si l'user est modérateur de la section, 0 s'il ne l'est pas
//
// Exemple d'utilisation:
// getmod('irl','1');

function getmod($section,$user=NULL)
{
  // Si on spécifie pas d'user, on prend la session en cours
  if(!$user && isset($_SESSION['user']))
    $user = $_SESSION['user'];

  // Si on a pas d'user, on renvoie 0
  if(!$user)
    return 0;

  // Si c'est un mod de la section concernée, on renvoie 1
  $qdroits = mysqli_fetch_array(query(" SELECT membres.moderateur FROM membres WHERE id = '$user' AND moderateur LIKE '%$section%' "));
  if($qdroits['moderateur'])
    return 1;

  // Si c'est un sysop ou un admin, on renvoie aussi 1
  $qdroits = mysqli_fetch_array(query(" SELECT membres.sysop, membres.admin FROM membres WHERE id = '$user' "));
  if($qdroits['sysop'] || $qdroits['admin'])
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
  if(!$user && !isset($_SESSION['user']))
    return 0;

  // Si on spécifie pas d'user, on prend la session en cours
  if(!$user && isset($_SESSION['user']))
    $user = $_SESSION['user'];

  // On vérifie si l'user est sysop ou admin
  $qdroits = mysqli_fetch_array(query(" SELECT membres.sysop, membres.admin FROM membres WHERE id = '$user' "));
  if($qdroits['sysop'] || $qdroits['admin'])
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
  if(!$user && isset($_SESSION['user']))
    $user = $_SESSION['user'];

  // Si on a pas d'user, on renvoie 0
  if(!$user)
    return 0;

  // On vérifie si l'user est admin
  $qdroits = mysqli_fetch_array(query(" SELECT membres.admin FROM membres WHERE id = '$user' "));
    return $qdroits['admin'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'est pas un sysop
// Si le second paramètre est rempli, autorise également les modérateurs d'une section spécifique
//
// Exemple d'utilisation:
// sysoponly('FR', 'irls');

function sysoponly($lang='FR', $section=NULL)
{
  // On prépare le message selon le langage
  $message = ($lang == 'FR') ? "Cette page est réservée aux administrateurs.<br><br>Ouste !" : 'This page is for admins only<br><br>Shoo!';

  // On vérifie si l'user est connecté et est un admin
  if(loggedin())
  {
    // On vérifie si l'user est un admin
    if(!$section)
    {
      if(!getsysop($_SESSION['user']))
        erreur($message);
    }
    else
    {
      if(!getsysop($_SESSION['user']) && !getmod($section,$_SESSION['user']))
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
  // On prépare le message selon le langage
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
      erreur("Cette page n'est utilisable que par les utilisateurs connectés.<br><br>Connectez-vous à votre compte en <a href=\"".$chemin."pages/user/login\">cliquant ici</a>,<br>ou créez-vous un compte en <a href=\"".$chemin."pages/user/register\">cliquant ici</a>.");
    else
      erreur("This page is for registered users only.<br><br>Log into your account by <a href=\"".$chemin."pages/user/login\">clicking here</a>,<br>or create an account by <a href=\"".$chemin."pages/user/register\">clicking here</a>.");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur est connecté
//
// Exemple d'utilisation:
// guestonly();

function guestonly($lang='FR')
{
  // On prépare le message selon le langage
  $message = ($lang == 'FR') ? "Cette page n'est accessible qu'aux invités." : "This page is accessible by guests only.";

  // On vérifie si l'user est connecté
  if(loggedin())
    erreur($message);
}