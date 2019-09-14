<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/functions_time.inc.php';

// Permissions
user_restrict_to_users();

// Menus du header
$header_menu      = 'User';
$header_sidemenu  = (!isset($_GET['envoyes'])) ? 'Notifications' : 'MessagesEnvoyes';

// Identification
$page_nom = "Consulte ses messages privés";
$page_url = "pages/users/notifications";

// Langues disponibles
$langue_page = array('FR','EN');

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
$userid     = $_SESSION['user_id'];
$qmessages  = "   SELECT    users_private_messages.id       AS 'm_id'   ,
                            users_private_messages.read_at  AS 'm_lu'   ,
                            users_private_messages.sent_at  AS 'm_date' ,
                            users.nickname                  AS 'm_user' ,
                            users_private_messages.title     AS 'm_titre'
                  FROM      users_private_messages ";
if(!isset($_GET['envoyes']))
  $qmessages .= " LEFT JOIN users ON users_private_messages.fk_users_sender = users.id
                  WHERE     users_private_messages.fk_users_recipient = '$userid' ";
else
  $qmessages .= " LEFT JOIN users ON users_private_messages.fk_users_recipient = users.id
                  WHERE     users_private_messages.fk_users_sender = '$userid' ";
$qmessages  .= "  ORDER BY  users_private_messages.sent_at DESC ";

// Et on les prépare pour l'affichage
$qmessages = query($qmessages);
$messages_non_lus = 0;
for($nmessages = 0 ; $dmessages = mysqli_fetch_array($qmessages) ; $nmessages++)
{
  $messages_id[$nmessages]    = $dmessages['m_id'];
  $messages_css[$nmessages]   = (!$dmessages['m_lu']) ? ' gras' : '';
  $messages_date[$nmessages]  = time_since($dmessages['m_date'], $lang);
  $messages_user[$nmessages]  = ($dmessages['m_user']) ? sanitize($dmessages['m_user']) : 'Message système';
  $messages_user[$nmessages]  = (!$dmessages['m_user'] && $lang != 'FR') ? 'System notification' : $messages_user[$nmessages];
  $messages_ucss[$nmessages]  = (!$dmessages['m_user']) ? ' class="italique"' : '';
  $messages_titre[$nmessages] = sanitize(string_truncate($dmessages['m_titre'], 40, '...'));
  $message_envoye[$nmessages] = (isset($_GET['envoyes'])) ? ' , 1 ' : '';
  $messages_non_lus          += (!$dmessages['m_lu']) ? 1 : 0;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Titres et description
  if(!isset($_GET['envoyes']))
  {
    $trad['titre']        = "Boîte de réception";
    $trad['soustitre']    = "Notifications systèmes et messages privés";
    $trad['description']  = "Pour consulter le contenu d'un message et/ou y répondre, cliquez dessus. Les messages non lus apparaissent en gras. La suppression d'un message est définitive, les messages ne sont pas archivés sur le serveur.";
  }
  else
  {
    $trad['titre']        = "Boîte d'envoi";
    $trad['soustitre']    = "Notifications systèmes et messages privés";
    $trad['description']  = "Pour consulter le contenu d'un message, cliquez dessus. Les messages apparaissent en gras si leur destinataire ne les a pas encore lu. Vous ne pouvez pas supprimer un message envoyé, et le message disparaitra de vos messages envoyés si son destinataire le supprime de sa boîte de réception.";
  }

  // Actions globales
  $trad['readall']        = "MARQUER TOUS LES MESSAGES COMME LUS";
  $trad['deleteall']      = "SUPPRIMER TOUS LES MESSAGES";
  $trad['confirmlire']    = "Êtes-vous sûr de vouloir marquer tous vos messages comme lus ?";
  $trad['confirmdel']     = "Êtes-vous sûr de vouloir supprimer définitivement tous vos messages ?";

  // Liste des messages
  if(!isset($_GET['envoyes']))
  {
    $trad['notif_date']   = "REÇU";
    $trad['notif_de']     = "MESSAGE DE";
    $trad['notif_sujet']  = "SUJET DU MESSAGE";
    $trad['notif_vide']   = "VOUS N'AVEZ AUCUN MESSAGE DANS VOTRE BOÎTE DE RÉCEPTION";
  }
  else
  {
    $trad['notif_date']   = "ENVOYÉ";
    $trad['notif_de']     = "DESTINATAIRE";
    $trad['notif_sujet']  = "SUJET DU MESSAGE";
    $trad['notif_vide']   = "VOUS N'AVEZ AUCUN MESSAGE DANS VOTRE BOÎTE D'ENVOI";
  }
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Titres et description
  if(!isset($_GET['envoyes']))
  {
    $trad['titre']        = "Inbox";
    $trad['soustitre']    = "Notifications and private messages";
    $trad['description']  = "Click on a message to read it and/or reply to it. Unread messages appear in bold in the message list. Once a message is deleted, it cannot be restored, as messages are not archived on the server.";
  }
  else
  {
    $trad['titre']        = "Outbox";
    $trad['soustitre']    = "Notifications and private messages";
    $trad['description']  = "Click on a message to read it. Messages that appear in bold mean that they have not been read by threir recipient yet. You can not delete a message that you have sent, and the message will disappear from your outbox if its recipient deletes it from his personal inbox.";
  }

  // Actions globales
  $trad['readall']        = "MARK ALL UNREAD MESSAGES AS READ";
  $trad['deleteall']      = "DELETE ALL MESSAGES IN INBOX";
  $trad['confirmlire']    = "Are you sure you want to mark all your messages as read?";
  $trad['confirmdel']     = "Are you sure you want to delete all your messages? They will be forever lost.";

  // Liste des messages
  if(!isset($_GET['envoyes']))
  {
    $trad['notif_date']   = "DATE";
    $trad['notif_de']     = "SENT BY";
    $trad['notif_sujet']  = "MESSAGE TITLE";
    $trad['notif_vide']   = "YOU CURRENTLY HAVE NO MESSAGES IN YOUR INBOX";
  }
  else
  {
    $trad['notif_date']   = "DATE";
    $trad['notif_de']     = "SENT TO";
    $trad['notif_sujet']  = "MESSAGE TITLE";
    $trad['notif_vide']   = "YOU CURRENTLY HAVE NO MESSAGES IN YOUR OUTBOX";
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['description']?></p>

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
            <button class="button-outline" onclick="notifications_boutons('<?=$chemin?>', '<?=$trad['confirmlire']?>', 'lire');">
              <?=$trad['readall']?>
            </button>
          </div>

          <?php } ?>
          <div style="flex:1">
            <button class="button-outline" onclick="notifications_boutons('<?=$chemin?>', '<?=$trad['confirmdel']?>', 'supprimer');">
              <?=$trad['deleteall']?>
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
                <?=$trad['notif_date']?>
              </th>
              <th>
                <?=$trad['notif_de']?>
              </th>
              <th>
                <?=$trad['notif_sujet']?>
              </th>
            </tr>
          </thead>
          <tbody id="messages_tbody" class="align_center">
            <?php if(!$nmessages) { ?>
            <tr>
              <td colspan="3" class="grisfonce moinsgros gras texte_blanc">
                <?=$trad['notif_vide']?>
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