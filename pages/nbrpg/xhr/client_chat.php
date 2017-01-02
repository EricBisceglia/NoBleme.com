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
$id_nbrpg = nbrpg();
if(!$id_nbrpg)
  exit();

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                               AFFICHAGE DES LIGNES DE CHAT À RATTRAPER                                                */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On détermine de quel type de chat il s'agit
$type_chat      = postdata($_POST['type']);
$type_lastchat  = ($type_chat == 'RP') ? 'dernier_chat_rp' : 'dernier_chat_hrp';

// On va chercher le timestamp de la dernière ligne et on met à jour avec le timestamp actuel
$timestamp    = time();
$qgetlastchat = query(" SELECT $type_lastchat AS 'lastchat' FROM nbrpg_persos WHERE id = $id_nbrpg ");
$getlastchat  = mysqli_fetch_array($qgetlastchat);
$lastchat     = $getlastchat['lastchat'];

// On va chercher le contenu manquant depuis la dernière vérification
$qupdatechat  = query(" SELECT  nbrpg_chatlog.timestamp     AS 'c_date'     ,
                                membres.pseudonyme          AS 'm_pseudo'   ,
                                nbrpg_persos.nom            AS 'm_nom'      ,
                                nbrpg_persos.couleur_chat   AS 'm_couleur'  ,
                                nbrpg_chatlog.type_chat     AS 'c_type'     ,
                                nbrpg_chatlog.message       AS 'c_message'
                      FROM      nbrpg_chatlog
                      LEFT JOIN nbrpg_persos  ON nbrpg_chatlog.FKmembres  = nbrpg_persos.FKmembres
                      LEFT JOIN membres       ON nbrpg_chatlog.FKmembres  = membres.id
                      WHERE     nbrpg_chatlog.timestamp > $lastchat
                      AND       nbrpg_chatlog.type_chat = '$type_chat'
                      ORDER BY  nbrpg_chatlog.timestamp ASC ");

// S'il y en a, on les affiche
while($dupdatechat = mysqli_fetch_array($qupdatechat))
{
  $updatetimestamp = $dupdatechat['c_date'];
  query(" UPDATE nbrpg_persos SET $type_lastchat = '$updatetimestamp' WHERE id = $id_nbrpg ");
  $nomoupseudo = ($type_chat == 'RP') ? $dupdatechat['m_nom'] : $dupdatechat['m_pseudo'];
  echo nbrpg_chatlog($dupdatechat['c_date'], $dupdatechat['m_couleur'], $nomoupseudo, $type_chat, $dupdatechat['c_message']);
}