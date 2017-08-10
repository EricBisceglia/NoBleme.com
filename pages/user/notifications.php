<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Menus du header
$header_menu      = 'Compte';
$header_sidemenu  = (!isset($_GET['envoyes'])) ? 'Inbox' : 'Outbox';

// Titre et description
$page_titre = "Nofitications";
$page_desc  = "Boite de réception des messages et notifications";

// Identification
$page_nom = "user";
$page_id  = "notifications";

// JS
$js = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale ******************************************/

// On va récupérer les notifications de l'user
$cestmoi  = $_SESSION['user'];
$qnotifs  = "   SELECT    notifications.id                      ,
                          notifications.FKmembres_destinataire  ,
                          notifications.FKmembres_envoyeur      ,
                          notifications.date_envoi              ,
                          notifications.date_consultation       ,
                          notifications.titre
                FROM      notifications ";
if(!isset($_GET['envoyes']))
  $qnotifs .= " WHERE     notifications.FKmembres_destinataire = '$cestmoi' ";
else
  $qnotifs .= " WHERE     notifications.FKmembres_envoyeur = '$cestmoi' ";
$qnotifs   .= " ORDER BY  notifications.date_envoi DESC ";

$qnotifs = query($qnotifs);

// Assignation et formattage des données
for($nnotifs = 0 ; $dnotifs = mysqli_fetch_array($qnotifs) ; $nnotifs++)
{
  $notif_id[$nnotifs]     = $dnotifs['id'];
  $notif_date[$nnotifs]   = ilya($dnotifs['date_envoi']);
  $notif_titre[$nnotifs]  = destroy_html($dnotifs['titre']);
  $notif_source[$nnotifs] = ($dnotifs['FKmembres_envoyeur'] !=0) ? '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dnotifs['FKmembres_envoyeur'].'">'.getpseudo($dnotifs['FKmembres_envoyeur']).'</a>' : '<span class="italique">Message système</span>';
  $notif_dest[$nnotifs]   = getpseudo($dnotifs['FKmembres_destinataire']);
  $notif_css[$nnotifs]    = ($nnotifs%2) ? 'nobleme_background' : 'blanc';
  $notif_css[$nnotifs]   .= ($dnotifs['date_consultation'] != 0) ? '' : ' gras';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/notifications.png" alt="Notifications">
    </div>
    <br>

    <div class="body_main midsize">

      <?php if(!isset($_GET['envoyes'])) { ?>

      <span class="titre">Boite de réception des notifications système et messages privés</span><br>
      <br>
      Vous trouverez ici les notifications automatiques, ainsi que les messages privés qui vous sont envoyés par les autres membres du site.<br>
      Les notifications et messages privés qui ne sont pas encore consultés apparaissent en gras dans la liste.<br>
      <br>
      Pour consulter vos notifications, cliquez sur leur sujet. Leur contenu apparaitra alors, et elles seront considérées comme lues.<br>
      <br>
      <span class="souligne">Attention</span> : La suppression d'une notification ou d'un message privé est définitive. Aucune copie de secours n'est conservée sur le serveur.<br>
      <br>

      <?php } else { ?>

      <span class="titre">Boite d'envoi des messages privés</span><br>
      <br>
      Vous trouverez ici tous les messages privés que vous avez envoyé aux autres membres du site.<br>
      Notez toutefois que ces messages disparaissent si leur récipient choisit de les supprimer. Aucune copie n'en est conservée.<br>
      Vous n'avez pas la possibilité de supprimer les messages envoyés. Désolé. Il faut en assumer les conséquences.<br>
      <br>
      Si un message privé apparait en gras dans la liste, c'est qu'il n'a pas encore été lu par son récipient.<br>
      Cliquez sur le titre d'un message pour en voir le contenu, qui inclut la date à laquelle le message a été lu.<br>
      <br>


      <?php } ?>

      <script type="text/javascript">
        document.write('<br>'); // Cette ruse est pour que la balise noscript qui suive soit validée WC3 :>
      </script>
      <noscript>
        <div class="gros gras align_center erreur texte_blanc intable">
          <br>
          Le JavaScript est désactivé sur votre navigateur.<br>
          <br>
          Vous devez activer le JavaScript pour pouvoir consulter vos notifications !<br>
          <br>
        </div>
        <br>
      </noscript>

      <table class="cadre_gris indiv">

        <?php if($nnotifs) { ?>

        <tr>
          <td class="cadre_gris_titre moinsgros">
            Date d'envoi
          </td>
          <td class="cadre_gris_titre moinsgros">
            <?php if(!isset($_GET['envoyes'])) { ?>
            Message de
            <?php } else { ?>
            Envoyé à
            <?php } ?>
          </td>
          <td class="cadre_gris_titre moinsgros">
            Sujet du message
          </td>
        </tr>

        <?php for($i=0;$i<$nnotifs;$i++) { ?>

        <tr id="rn<?=$notif_id[$i]?>">
          <td class="cadre_gris cadre_gris_haut align_center <?=$notif_css[$i]?>">
            <?=$notif_date[$i]?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center <?=$notif_css[$i]?>">
            <?php if(!isset($_GET['envoyes'])) { ?>
            <?=$notif_source[$i]?>
            <?php } else { ?>
            <?=$notif_dest[$i]?>
            <?php } ?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center pointeur <?=$notif_css[$i]?>"
            onClick="dynamique('<?=$chemin?>','notifications.php?dynamique','rn<?=$notif_id[$i]?>','lire_message=<?=$notif_id[$i]?>');">
            <?=$notif_titre[$i]?>
          </td>
        </tr>

        <?php } } else { ?>

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            <?php if(!isset($_GET['envoyes'])) { ?>
            VOUS N'AVEZ AUCUN MESSAGE DANS VOTRE BOITE DE RÉCEPTION
            <?php } else { ?>
            VOUS N'AVEZ AUCUN MESSAGE DANS VOTRE BOITE D'ENVOI
            <?php } ?>
          </td>
        </tr>

        <?php } ?>

      </table>
    </div>



<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Lire un message

  if(isset($_POST['lire_message']))
  {
    // On va chercher plus d'infos sur le message
    $lire_message = postdata_vide('lire_message');
    $dmessage     = mysqli_fetch_array(query("  SELECT  notifications.id                      ,
                                                        notifications.FKmembres_destinataire  ,
                                                        notifications.FKmembres_envoyeur      ,
                                                        notifications.date_envoi              ,
                                                        notifications.date_consultation       ,
                                                        notifications.titre                   ,
                                                        notifications.contenu
                                                FROM    notifications
                                                WHERE   notifications.id = '$lire_message' "));

    // Les tricheurs à la porte, thx
    if($dmessage['FKmembres_destinataire'] !== $_SESSION['user'] && $dmessage['FKmembres_envoyeur'] !== $_SESSION['user'] ) { ?>

    <td class="cadre_gris cadre_gris_haut align_center erreur texte_blanc gras moinsgros"colspan="3">Erreur : On ne consulte pas les notifications des autres. Bien essayé :)</td>

    <?php } else {

      // On prépare les données
      $m_id       = $dmessage['id'];
      $m_reply    = ($dmessage['FKmembres_envoyeur'] != 0) ? $dmessage['FKmembres_envoyeur'] : 1;
      $m_titre    = destroy_html($dmessage['titre']);
      if($dmessage['FKmembres_envoyeur'] != 0)
        $m_header = 'Message privé envoyé par <a class="dark blank gras" href="'.$chemin.'pages/user/id?'.$dmessage['FKmembres_envoyeur'].'">'.getpseudo($dmessage['FKmembres_envoyeur']).'</a> le '.datefr(date('Y-m-d',$dmessage['date_envoi'])).' à '.date('h:i',$dmessage['date_envoi']).' ('.ilya($dmessage['date_envoi']).')';
      else
        $m_header = 'Message envoyé automatiquement par le système le '.datefr(date('Y-m-d',$dmessage['date_envoi'])).' à '.date('h:i',$dmessage['date_envoi']).' ('.ilya($dmessage['date_envoi']).')';
      $m_contenu  = bbcode(nl2br_fixed(destroy_html(stripslashes($dmessage['contenu']))));

      // Si la notification n'est pas lue, on la marque comme lue
      $lecture = '';
      if($dmessage['date_consultation'])
      {
        if($dmessage['FKmembres_envoyeur'] !== $_SESSION['user'])
          $lecture = '<span class="italique texte_nobleme_clair">Vous avez lu ce message pour la première fois le '.datefr(date('Y-m-d',$dmessage['date_consultation'])).' à '.date('h:i',$dmessage['date_consultation']).'</span><br>';
        else
          $lecture = '<span class="italique texte_nobleme_clair">Ce message a été lu pour la première fois le '.datefr(date('Y-m-d',$dmessage['date_consultation'])).' à '.date('h:i',$dmessage['date_consultation']).'</span><br>';
      }
      else if($dmessage['FKmembres_envoyeur'] !== $_SESSION['user'] || $dmessage['FKmembres_envoyeur'] === $dmessage['FKmembres_destinataire'])
      {
        $timestamp = time();
        query(" UPDATE notifications SET notifications.date_consultation = '$timestamp' WHERE notifications.id = '$lire_message' ");
      }

      ?>

      <td colspan="3">
        <table class="cadre_gris indiv">
          <tr>
            <td class="cadre_gris spaced" colspan="3">
              <br>
              <span class="alinea moinsgros gras souligne"><?=$m_titre?></span><br>
              <br>
              <span class="italique"><?=$m_header?></span><br>
              <?=$lecture?>
              <br>
            </td>
          </tr>
          <tr>
            <td class="cadre_gris spaced" colspan="3">
              <br>
              <?=$m_contenu?><br>
              <br>
            </td>
          </tr>
          <?php if($dmessage['FKmembres_envoyeur'] !== $_SESSION['user'] || $dmessage['FKmembres_envoyeur'] === $dmessage['FKmembres_destinataire']) { ?>
          <tr>
            <td class="cadre_gris spaced align_center pointeur" onClick="window.location='<?=$chemin?>pages/user/pm?user=<?=$m_reply?>&amp;reply=<?=$m_id?>'">
              <img src="<?=$chemin?>img/boutons/notification_repondre_quote.png" alt="Répondre avec citation">
            </td>
            <td class="cadre_gris spaced align_center pointeur" onClick="window.location='<?=$chemin?>pages/user/pm?user=<?=$m_reply?>'">
              <img src="<?=$chemin?>img/boutons/notification_repondre_noquote.png" alt="Répondre sans citation">
            </td>
            <td class="cadre_gris spaced align_center pointeur">
              <img src="<?=$chemin?>img/boutons/notification_supprimer.png" alt="Supprimer la notification"
                onClick="var ok = confirm('Confirmer la suppression définitive du message privé « <?=addslashes($m_titre)?> » ?');
                if(ok == true) { dynamique('<?=$chemin?>','notifications.php?dynamique','rn<?=$m_id?>','delete_message=<?=$m_id?>'); }">
            </td>
          </tr>
          <?php } ?>
        </table>
      </td>

      <?php
    }
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Supprimer un message

  if(isset($_POST['delete_message']))
  {
    // On va vérifier que le message appartient bien à celui qui essaye de le delete
    $delete_message = postdata_vide('delete_message');
    $verif_owner    = mysqli_fetch_array(query(" SELECT notifications.FKmembres_destinataire FROM notifications WHERE notifications.id = '$delete_message' "));

    // Les tricheurs à la porte, thx
    if($verif_owner['FKmembres_destinataire'] !== $_SESSION['user']) { ?>

    <td class="cadre_gris cadre_gris_haut align_center erreur texte_blanc gras moinsgros"colspan="3">Erreur : On ne supprime pas les notifications des autres. Bien essayé :)</td>

    <?php } else {

      // On peut supprimer la notification maintenant
      query(" DELETE FROM notifications WHERE notifications.id = '$delete_message' ");

      // Et on affiche que ça s'est bien passé
      ?>

      <td class="cadre_gris cadre_gris_haut align_center erreur texte_blanc gras moinsgros"colspan="3">Le message a été définitivement supprimé</td>

      <?php
    }
  }
}