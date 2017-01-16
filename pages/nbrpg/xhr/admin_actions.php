<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                     CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE PAR DU XHR                                    */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(!isset($_POST['xhr']))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Cette page n\'est pas censée être chargée toute seule, dehors !</body></html>');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inclusions communes + nbrpg, protection des permissions, et correction du chemin vu qu'on se situe un dossier plus haut que d'habitude
include './../../../inc/includes.inc.php';
include './../../../inc/nbrpg.inc.php';
$chemin_fixed = substr($chemin,0,-3);
adminonly();

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         TRAITEMENT DES ACTIONS                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On récupère l'action demandée

$do_action = postdata($_POST['action']);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier les HP d'une cible

if($do_action == 'modifier_hp')
{
  $edithp_cible   = postdata($_POST['cible']);
  $edithp_valeur  = postdata($_POST['valeur']);
  nbrpg_edithp($edithp_cible,$edithp_valeur,'magique');
}