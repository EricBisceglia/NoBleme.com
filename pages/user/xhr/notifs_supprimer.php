<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
useronly($lang);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On s'assure qu'il y ait bien un message
if(!isset($_POST['message']))
  exit('ERREUR: ID MESSAGE INEXISTANT');

// On va chercher le contenu du message
$message_id = postdata($_POST['message'], 'int');
$qmessage = query(" SELECT    notifications.FKmembres_destinataire  AS 'm_a'
                    FROM      notifications
                    LEFT JOIN membres ON notifications.FKmembres_envoyeur = membres.id
                    WHERE     notifications.id = '$message_id' ");

// Si il n'y a pas de message, on s'arrête là
if(!mysqli_num_rows($qmessage))
  exit('ERREUR: MESSAGE INEXISTANT');

// Si le message n'est pas destiné à l'user qui le lit, on s'arrête là
$dmessage = mysqli_fetch_array($qmessage);
if($dmessage['m_a'] != $_SESSION['user'])
  exit('ERREUR: ON NE SUPPRIME PAS LES MESSAGES DES AUTRES');

// Sinon, on peut supprimer
query(" DELETE FROM notifications WHERE notifications.id = '$message_id' ");

// On prépare juste une phrase
$message_supprime = ($lang == 'FR') ? "MESSAGE SUPPRIMÉ" : "MESSAGE DELETED";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<td class="grisfonce texte_blanc gras" colspan="3">
  <?=$message_supprime?>
</td>