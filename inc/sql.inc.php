<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Connexion à la base de données
// S'effectue automatiquement au chargement d'une page incluant ce fichier
// Détecte si le script est sur le localhost ou en prod
// Fixe le charset

if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1" )
  $GLOBALS['db'] = @mysqli_connect('127.0.0.1', 'root', '', 'nobleme') or die ('Erreur SQL ! Connexion &agrave; la base de donn&eacute;es impossible');
else
  $GLOBALS['db'] = @mysqli_connect('localhost', 'root', $GLOBALS['mysql_pass'], 'nobleme') or die ('Erreur SQL ! Connexion &agrave; la base de donn&eacute;es impossible');

mysqli_set_charset($GLOBALS['db'], "utf8");
$GLOBALS['query'] = 0;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de faire une requête et d'en retourner le message d'erreur en cas d'échec
//
// $ignore est un paramètre optionnel qui ignore les erreurs
//
// Exemple d'utilisation:
// $ma_requete = query("SELECT * FROM ma_bdd");

function query($requete, $ignore=NULL)
{
  $GLOBALS['query']++;
  if($ignore)
    $query = mysqli_query($GLOBALS['db'],$requete);
  else
    $query = mysqli_query($GLOBALS['db'],$requete) or die ('Erreur SQL !<br>'.mysqli_error($GLOBALS['db']));
  return $query;
}