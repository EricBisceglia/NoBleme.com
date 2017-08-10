<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                                       //
// Htmlentities() remplace les caractères html par un équivalent utf/iso                                                                 //
// Addslashes() ajoute des backslashes \ avant les caractères à escaper pour ne pas planter les requêtes                                 //
//                                                                                                                                       //
// Exemple d'utilisation:                                                                                                                //
// $ma_variable = postdata($_POST["mon_postdata"]) ;                                                                                     //
//                                                                                                                                       //
// Note: Pour voir les retour à la ligne dans du texte stocké, utiliser la fonction ln2br                                                //
// Exemple: echo ln2br($ma_requete["mon_champ"]);                                                                                        //
//                                                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Fonction de traitement du postdata
function postdata($data)
{
  $output = mysqli_real_escape_string($GLOBALS['db'],$data);
  return $output;
}


// Fonction de traitement de postdata gérant la non-existence possible du postdata concerné, assigne une valeur par défaut même si le post est NULL
// Prend en arguments le nom du $_POST et la valeur à assigner s'il n'existe pas.
// S'utilise ainsi: postdata_vide("mon_postdata");
function postdata_vide($data)
{
  if(isset($_POST[$data]))
    $output = postdata($data);
  else
    $output = "";

  return $output;
}