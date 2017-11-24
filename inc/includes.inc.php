<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inclusion de la config, on exit si elle est pas faite

include 'conf.inc.php';
if(!isset($GLOBALS['mysql_pass']))
  exit("Le conf.inc.php manque !");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Regroupement de tous les includes majeurs qui sont nécessaires dans toutes les pages

include 'sql.inc.php';        // Connexion à MySQL
include 'erreur.inc.php';     // Page d'erreur
include 'session.inc.php';    // Sessions sécurisées
include 'login.inc.php';      // Gestion de la connexion des utilisateurs
include 'post.inc.php';       // Traitement du postdata
include 'date.inc.php';       // Fonctions de traitement de la date
include 'bbcode.inc.php';     // BBCodes et émoticones
include 'fonctions.inc.php';  // Fonctions génériques




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détermination du langage utilisé

$lang = (!isset($_SESSION['lang'])) ? 'FR' : $_SESSION['lang'];
$trad = array();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Définition du $chemin

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