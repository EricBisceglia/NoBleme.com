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
// Nouvelle fonction de salage d'un mot de passe
// Renvoie le mot de passe salé
//
// Exemple d'utilisation:
// salage("monpass");

function salage($pass)
{
  return crypt($pass,$GLOBALS['salage']);
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
  if($id === NULL && isset($_SESSION['user']))
    $id = $_SESSION['user'];
  $users = query(" SELECT membres.pseudonyme FROM membres WHERE id = '$id' ");
  $getpseudo = mysqli_fetch_array($users);
  return $getpseudo['pseudonyme'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de check si modérateur d'une section à partir de l'id de l'user
// Renvoie 1 si l'user est modérateur de la section, 0 s'il ne l'est pas
//
// Exemple d'utilisation:
// getsysop('irl','1');

function getmod($section,$user=NULL)
{
  if($user === NULL && isset($_SESSION['user']))
    $user = $_SESSION['user'];
  $modos = query(" SELECT membres.moderateur FROM membres WHERE id = '$user' AND moderateur LIKE '%$section%' ");
  $modo = mysqli_fetch_array($modos);
  if($modo['moderateur'])
    return 1;
  else
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
  if($user === NULL && isset($_SESSION['user']))
    $user = $_SESSION['user'];
  $sysops = query(" SELECT membres.sysop, membres.admin FROM membres WHERE id = '$user' ");
  $sysop = mysqli_fetch_array($sysops);
  if($sysop['sysop'] || $sysop['admin'])
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
  if($user === NULL && isset($_SESSION['user']))
    $user = $_SESSION['user'];
  $admins = query(" SELECT membres.admin FROM membres WHERE id = '$user' ");
  $admin = mysqli_fetch_array($admins);
  return $admin['admin'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'est pas un sysop ou un modérateur d'une section spécifique
//
// Exemple d'utilisation:
// sysoponly('irls');

function sysoponly($section=NULL)
{
  // On vérifie si l'user est connecté et est un admin
  if(loggedin())
  {
    // On vérifie si l'user est un admin
    if($section == NULL)
    {
      if(!getsysop($_SESSION['user']))
        erreur("Cette page est réservée aux administrateurs.<br><br>Dehors!");
    }
    else
    {
      if(!getsysop($_SESSION['user']) && !getmod($section,$_SESSION['user']))
        erreur("Cette page est réservée aux administrateurs.<br><br>Dehors!");
    }
  }
  else
    erreur("Cette page est réservée aux administrateurs.<br><br>Dehors!");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'est pas un admin
//
// Exemple d'utilisation:
// adminonly();

function adminonly()
{
  // On vérifie si l'user est connecté et est un admin
  if(loggedin())
  {
    // On vérifie si l'user est un admin
    if(!getadmin($_SESSION['user']))
      erreur("Cette page est réservée aux administrateurs.<br><br>Dehors!");
  }
  else
    erreur("Cette page est réservée aux administrateurs.<br><br>Dehors!");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur n'est pas connecté
//
// Exemple d'utilisation:
// useronly();

function useronly()
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

    erreur("Cette page n'est utilisable que par les utilisateurs connectés.<br><br>Connectez-vous à votre compte en <a class=\"dark\" href=\"".$chemin."pages/user/login\">cliquant ici</a>,<br>ou créez-vous un compte en <a class=\"dark\" href=\"".$chemin."pages/user/register\">cliquant ici</a>.");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction interdisant l'accès à une page si l'utilisateur est connecté
//
// Exemple d'utilisation:
// guestonly();

function guestonly()
{
  // On vérifie si l'user est connecté
  if(loggedin())
    erreur("Vous ne pouvez pas accéder à cette page.");
}