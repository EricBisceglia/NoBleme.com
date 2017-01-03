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
$id_nbrpg     = nbrpg();
if(!$id_nbrpg)
  exit();
$id_session   = nbrpg_session($id_nbrpg);
if(!$id_session)
  exit();

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         TRAITEMENT DES ACTIONS                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On récupère l'action demandée

$do_action = postdata($_POST['action']);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Envoyer un message dans le chat

if($do_action == 'chat_rp' || $do_action == 'chat_hrp')
{
  // On prépare les infos
  $chat_timestamp = time();
  $chat_membre    = $_SESSION['user'];
  $chat_type      = ($do_action == 'chat_rp') ? 'RP' : 'HRP';
  $chat_message   = substr(htmlentities(postdata($_POST['valeur'])),0,256);

  // Et on fait la requête
  if($chat_message)
  {
    query(" INSERT INTO nbrpg_chatlog SET timestamp = $chat_timestamp ,
                                          FKmembres = $chat_membre    ,
                                          type_chat = '$chat_type'    ,
                                          message   = '$chat_message' ");
  }
}