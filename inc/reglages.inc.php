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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Définition du fuseau horaire

date_default_timezone_set('Europe/Paris');