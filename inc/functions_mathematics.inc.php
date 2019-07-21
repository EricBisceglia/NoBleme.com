<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calcul le pourcentage qu'un nombre représente d'un autre nombre
// $nombre est le nombre qui est un pourcent du total
// $total est le total dont le nombre est un pourcent
// Si $croissance est rempli, calcule une croissance au lieu d'un pourcentage d'un nombre
//
// Exemple d'utilisation :
// $pourcentage = calcul_pourcentage($nombre,$total);

function calcul_pourcentage($nombre, $total, $croissance=NULL)
{
  if(!$croissance)
    return ($total) ? (($nombre/$total)*100) : 0;
  else
    return ($total) ? (($nombre/$total)*100)-100 : 0;
}