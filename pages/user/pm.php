<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Menus du header
$header_menu      = 'compte';
$header_submenu   = 'messages';
$header_sidemenu  = 'ecrire';

// Titre et description
$page_titre = "Composer un message privé";
$page_desc  = "Composer un message privé destiné à un autre membre du site";

// Identification
$page_nom = "user";
$page_id  = "pm";

// JS
$js  = array('dynamique');
$css = array('user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si un destinataire est preset
$pm_destinataire = '';
if(isset($_GET['user']))
{
  $pm_getuser      = postdata($_GET['user']);
  $pm_destinataire = ($pm_getuser == 0) ? 'Bad' : getpseudo($pm_getuser);
}

// Si un message est preset
$pm_body  = '';
$pm_titre = 'Message privé de '.getpseudo($_SESSION['user']);
if(isset($_GET['reply']))
{
  // On va chercher le message d'origine
  $pm_reply = postdata($_GET['reply']);
  $dpmbody  = mysqli_fetch_array(query("  SELECT  notifications.contenu     ,
                                                  notifications.titre       ,
                                                  notifications.FKmembres_destinataire
                                          FROM    notifications
                                          WHERE   notifications.id = '$pm_reply' "));

  // On laisse pas lire les messages des autres
  if($dpmbody['FKmembres_destinataire'] == $_SESSION['user'])
  {
    $pm_titre = 'Re: '.$dpmbody['titre'];
    if($pm_destinataire == '')
      $pm_body = '[quote]'.$dpmbody['contenu'].'[/quote]';
    else
      $pm_body = '[quote='.$pm_destinataire.']'.$dpmbody['contenu'].'[/quote]';
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/composer_un_message_prive.png" alt="Composer un message privé">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Message privé</span><br>
      <br>
      Entrez le <a href="<?=$chemin?>pages/nobleme/membres">pseudonyme</a> de votre destinataire dans le premier champ, un sujet (optionnel), puis le corps de votre message.<br>
      Une copie du message sera conservée dans votre <a href="<?=$chemin?>pages/user/notifications?envoyes">boite d'envoi</a> tant que le detinataire n'aura pas supprimé votre message.<br>
      <br>
      Vous pouvez utiliser les <a href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> et des <a href="<?=$chemin?>pages/doc/emotes">émoticônes</a> dans votre message.
      <script type="text/javascript">
        document.write('<br>'); // Cette ruse est pour que la balise noscript qui suive soit validée WC3 :>
      </script>
      <noscript>
        <br>
        <br>
        <div class="gros gras align_center erreur texte_blanc intable">
          <br>
          Le JavaScript est désactivé sur votre navigateur.<br>
          <br>
          Vous devez activer le JavaScript pour pouvoir composer un message !<br>
          <br>
        </div>
        <br>
      </noscript>
    </div>

    <br>

    <div class="body_main midsize">

      <span id="prev"></span>

      <table class="data_input indiv">
        <tr>
          <td class="data_input_right titres_pm">
            Destinataire :&nbsp;
          </td>
          <td>
            <input class="indiv" id="pm_destinataire" value="<?=$pm_destinataire?>">
          </td>
        </tr>
        <tr>
          <td class="data_input_right titres_pm">
            Sujet :&nbsp;
          </td>
          <td>
            <input class="indiv" value="<?=$pm_titre?>" id="pm_sujet">
          </td>
        </tr>
        <tr>
          <td class="data_input_right titres_pm">
            Message :&nbsp;
          </td>
          <td>
            <textarea class="indiv" rows="15" id="pm_message"><?=$pm_body?></textarea>
          </td>
        </tr>
      </table>

      <div class="indiv align_center">
        <img class="pointeur" src="<?=$chemin?>img/boutons/previsualiser.png" alt="Prévisualiser"
          onClick="dynamique('<?=$chemin?>','pm.php?dynamique','prev','prev='+dynamique_prepare('pm_message'));">
        <img src="<?=$chemin?>img/boutons/separateur.png" alt=" ">
        <img class="pointeur" src="<?=$chemin?>img/boutons/envoyer_le_message.png" alt="Envoyer le message"
          onClick="dynamique('<?=$chemin?>','pm.php?dynamique','prev',
          'destinataire='+dynamique_prepare('pm_destinataire')+
          '&amp;sujet='+dynamique_prepare('pm_sujet')+
          '&amp;message='+dynamique_prepare('pm_message')+
          '&amp;envoyer=1');">
      </div>

    </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Prévisualiser

  if(isset($_POST['prev']) && $_POST['prev'] != '')
  {
    // On sanitize et prépare tout ce bordel
    $pm_prev = bbcode(nl2br_fixed(destroy_html($_POST['prev'])));

    // Puis on l'affiche
    ?>

    <span class="moinsgros gras alinea">Prévisualisation avant envoi de votre message :</span><br>

    <div class="indiv limited">
      <table class="cadre_gris indiv">
        <tr>
          <td>
            <?=$pm_prev?>
          </td>
        </tr>
      </table>
    </div>

    <br>

    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Envoyer

  if(isset($_POST['envoyer']))
  {
    // On commence par faire la chasse aux erreurs
    $erreur = '';

    // Membre inexistant ?
    $pm_destinataire = postdata_vide('destinataire');
    $qpmembre = query(" SELECT membres.id FROM membres WHERE membres.pseudonyme LIKE '$pm_destinataire' ");
    if(!mysqli_num_rows($qpmembre))
      $erreur = 'Destinataire non existant, vérifiez le pseudonyme';
    else
    {
      $dpmembre         = mysqli_fetch_array($qpmembre);
      $pm_destinataire  = $dpmembre['id'];
    }

    // Sujet trop long ?
    if(strlen($_POST['sujet']) > 50)
      $erreur = 'Sujet trop long ('.(strlen($_POST['sujet'])-50).' caractère(s) de trop)';

    // Message vide ?
    if($_POST['message'] == '')
      $erreur = 'Votre message est vide';

    // Duplicata ?
    $itsme = $_SESSION['user'];
    if($erreur === '')
    {
      $pm_titre = postdata_vide('sujet');
      $pm_sdate = time()-100;
      $qpmdup   = query(" SELECT  notifications.id
                          FROM    notifications
                          WHERE   notifications.date_envoi              >     '$pm_sdate'
                          AND     notifications.FKmembres_destinataire  =     '$pm_destinataire'
                          AND     notifications.FKmembres_envoyeur      =     '$itsme'
                          AND     notifications.titre                   LIKE  '$pm_titre' ");
      if(mysqli_num_rows($qpmdup))
        $erreur = 'Vous venez d\'envoyer ce message !';
    }

    // Flood ?
    $pm_flooddate = time()-3600;
    $qpmflood     = query(" SELECT  notifications.id
                            FROM    notifications
                            WHERE   notifications.date_envoi      > '$pm_flooddate'
                            AND notifications.FKmembres_envoyeur  = '$itsme' ");
    if(mysqli_num_rows($qpmflood) >= 10)
      $erreur     = 'Vous avez envoyé trop de messages privés récemment.<br>Ré-essayez dans quelques heures, merci de ne pas flooder le système.';

    // Y'a une erreur ? -> On envoie pas
    if($erreur !== '')
    {
      ?>

      <div class="gros gras align_center erreur texte_blanc intable">
        <span class="souligne">Erreur</span> : <?=$erreur?>
      </div>
      <br>

      <?php
    }
    // Sinon on envoie le message
    else
    {
      // Traitement du postdata
      $pm_envoyeur  = $_SESSION['user'];
      $pm_date      = time();
      $pm_message   = postdata_vide('message');

      // Envoi du message
      query(" INSERT INTO notifications
              SET         notifications.FKmembres_destinataire  = '$pm_destinataire'  ,
                          notifications.FKmembres_envoyeur      = '$pm_envoyeur'      ,
                          notifications.date_envoi              = '$pm_date'          ,
                          notifications.date_consultation       = 0                   ,
                          notifications.titre                   = '$pm_titre'         ,
                          notifications.contenu                 = '$pm_message'       ");

      // Et on fait savoir que ça s'est bien passé !
      ?>

      <div class="gros gras align_center vert_background intable">
        <br>
        Le message a bien été envoyé !<br>
        <br>
      </div>
      <br>

      <?php
    }
  }

}