<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Compte';
$header_sidemenu  = (!isset($_GET['envoyes'])) ? 'Notifications' : 'MessagesEnvoyes';

// Identification
$page_nom = "Consulte ses messages privés";
$page_url = "pages/user/notifications";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
if(!isset($_GET['envoyes']))
  $page_titre = ($lang == 'FR') ? "Boîte de réception" : "Inbox";
else
  $page_titre = ($lang == 'FR') ? "Boîte d'envoi" : "Outbox";

// CSS & JS
$css  = array('user');
$js   = array('toggle', 'dynamique', 'user/notifications');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les messages
$userid     = $_SESSION['user'];
$qmessages  = "   SELECT    notifications.id                AS 'm_id'   ,
                            notifications.date_consultation AS 'm_lu'   ,
                            notifications.date_envoi        AS 'm_date' ,
                            membres.pseudonyme              AS 'm_user' ,
                            notifications.titre             AS 'm_titre'
                  FROM      notifications ";
if(!isset($_GET['envoyes']))
  $qmessages .= " LEFT JOIN membres ON notifications.FKmembres_envoyeur = membres.id
                  WHERE     notifications.FKmembres_destinataire = '$userid' ";
else
  $qmessages .= " LEFT JOIN membres ON notifications.FKmembres_destinataire = membres.id
                  WHERE     notifications.FKmembres_envoyeur = '$userid' ";
$qmessages  .= "  ORDER BY  notifications.date_envoi DESC ";

// Et on les prépare pour l'affichage
$qmessages = query($qmessages);
$messages_non_lus = 0;
for($nmessages = 0 ; $dmessages = mysqli_fetch_array($qmessages) ; $nmessages++)
{
  $messages_id[$nmessages]    = $dmessages['m_id'];
  $messages_css[$nmessages]   = (!$dmessages['m_lu']) ? ' gras' : '';
  $messages_date[$nmessages]  = ilya($dmessages['m_date'], $lang);
  $messages_user[$nmessages]  = ($dmessages['m_user']) ? predata($dmessages['m_user']) : 'Message système';
  $messages_user[$nmessages]  = (!$dmessages['m_user'] && $lang != 'FR') ? 'System notification' : $messages_user[$nmessages];
  $messages_ucss[$nmessages]  = (!$dmessages['m_user']) ? ' class="italique"' : '';
  $messages_titre[$nmessages] = predata(tronquer_chaine($dmessages['m_titre'], 40, '...'));
  $message_envoye[$nmessages] = (isset($_GET['envoyes'])) ? ' , 1 ' : '';
  $messages_non_lus          += (!$dmessages['m_lu']) ? 1 : 0;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Titres et description
if(!isset($_GET['envoyes']))
{
  $traduction['titre']        = ($lang == 'FR') ? "Boîte de réception" : "Inbox";
  $traduction['soustitre']    = ($lang == 'FR') ? "Notifications systèmes et messages privés" : "Notifications and private messages";
  $traduction['description']  = ($lang == 'FR') ? "Pour consulter le contenu d'un message et/ou y répondre, cliquez dessus. Les messages non lus apparaissent en gras. La suppression d'un message est définitive, les messages ne sont pas archivés sur le serveur." : "Click on a message to read it and/or reply to it. Unread messages appear in bold in the message list. Once a message is deleted, it cannot be restored, as messages are not archived on the server.";
}
else
{
  $traduction['titre']        = ($lang == 'FR') ? "Boîte d'envoi" : "Outbox";
  $traduction['soustitre']    = ($lang == 'FR') ? "Notifications systèmes et messages privés" : "Notifications and private messages";
  $traduction['description']  = ($lang == 'FR') ? "Pour consulter le contenu d'un message, cliquez dessus. Les messages apparaissent en gras si leur destinataire ne les a pas encore lu. Vous ne pouvez pas supprimer un message envoyé, et le message disparaitra de vos messages envoyés si son destinataire le supprime de sa boîte de réception." : "Click on a message to read it. Messages that appear in bold mean that they have not been read by threir recipient yet. You can not delete a message that you have sent, and the message will disappear from your outbox if its recipient deletes it from his personal inbox.";
}

// Actions globales
$traduction['readall']      = ($lang == 'FR') ? "MARQUER TOUS LES MESSAGES COMME LUS" : "MARK ALL UNREAD MESSAGES AS READ";
$traduction['deleteall']    = ($lang == 'FR') ? "SUPPRIMER TOUS LES MESSAGES" : "DELETE ALL MESSAGES IN INBOX";
$traduction['confirmlire']  = ($lang == 'FR') ? "Êtes-vous sûr de vouloir marquer tous vos messages comme lus ?" : "Are you sure you want to mark all your messages as read?";
$traduction['confirmdel']   = ($lang == 'FR') ? "Êtes-vous sûr de vouloir supprimer définitivement tous vos messages ?" : "Are you sure you want to delete all your messages? They will be forever lost.";

// Liste des messages
if(!isset($_GET['envoyes']))
{
  $traduction['notif_date']   = ($lang == 'FR') ? "REÇU" : "DATE";
  $traduction['notif_de']     = ($lang == 'FR') ? "MESSAGE DE" : "SENT BY";
  $traduction['notif_sujet']  = ($lang == 'FR') ? "SUJET DU MESSAGE" : "MESSAGE TITLE";
  $traduction['notif_vide']   = ($lang == 'FR') ? "VOUS N'AVEZ AUCUN MESSAGE DANS VOTRE BOÎTE DE RÉCEPTION" : "YOU CURRENTLY HAVE NO MESSAGES IN YOUR INBOX";
}
else
{
  $traduction['notif_date']   = ($lang == 'FR') ? "ENVOYÉ" : "DATE";
  $traduction['notif_de']     = ($lang == 'FR') ? "DESTINATAIRE" : "SENT TO";
  $traduction['notif_sujet']  = ($lang == 'FR') ? "SUJET DU MESSAGE" : "MESSAGE TITLE";
  $traduction['notif_vide']   = ($lang == 'FR') ? "VOUS N'AVEZ AUCUN MESSAGE DANS VOTRE BOÎTE D'ENVOI'" : "YOU CURRENTLY HAVE NO MESSAGES IN YOUR OUTBOX";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$traduction['titre']?></h1>

        <h5><?=$traduction['soustitre']?></h5>

        <p><?=$traduction['description']?></p>

        <?php if(!isset($_GET['envoyes'])) { ?>

        <br>
        <br>

        <div id="messages_confirmation" class="indiv align_center hidden">
          &nbsp;
        </div>

        <?php if($nmessages > 1) { ?>

        <div class="flexcontainer align_center">

          <?php if($messages_non_lus > 1) { ?>
          <div style="flex:1" id="messages_nonlus">
            <button class="button-outline" onclick="notifications_boutons('<?=$chemin?>', '<?=$traduction['confirmlire']?>', 'lire');">
              <?=$traduction['readall']?>
            </button>
          </div>

          <?php } ?>
          <div style="flex:1">
            <button class="button-outline" onclick="notifications_boutons('<?=$chemin?>', '<?=$traduction['confirmdel']?>', 'supprimer');">
              <?=$traduction['deleteall']?>
            </button>
          </div>

        </div>
        <?php } ?>
        <?php } ?>

      </div>

      <br>
      <br>

      <div class="texte2">

        <table class="grid titresnoirs hiddenaltc2">
          <thead>
            <tr>
              <th>
                <?=$traduction['notif_date']?>
              </th>
              <th>
                <?=$traduction['notif_de']?>
              </th>
              <th>
                <?=$traduction['notif_sujet']?>
              </th>
            </tr>
          </thead>
          <tbody id="messages_tbody" class="align_center">
            <?php if(!$nmessages) { ?>
            <tr>
              <td colspan="3" class="grisfonce moinsgros gras texte_blanc">
                <?=$traduction['notif_vide']?>
              </td>
            </tr>
            <?php } else { ?>
            <tr>
              <td colspan="3" class="hidden texte_blanc noir gras">
                WHY HELLO THERE... YOU WERE NOT SUPPOSED TO SEE THIS!
              </td>
            </tr>
            <?php for($i=0;$i<$nmessages;$i++) { ?>
            <tr id="message_tableau_<?=$messages_id[$i]?>" class="pointeur noflow<?=$messages_css[$i]?>" onclick=" notifications_afficher_message('<?=$chemin?>', '<?=$messages_id[$i]?>'<?=$message_envoye[$i]?>); ">
              <td>
                <?=$messages_date[$i]?>
              </td>
              <td<?=$messages_ucss[$i]?>>
                <?=$messages_user[$i]?>
              </td>
              <td>
                <?=$messages_titre[$i]?>
              </td>
            </tr>
            <tr class="hidden" id="message_ligne_<?=$messages_id[$i]?>">
              <td colspan="3" id="message_corps_<?=$messages_id[$i]?>">
                &nbsp;
              </td>
            </tr>
            <?php } ?>
            <?php } ?>
          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';