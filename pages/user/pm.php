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
$header_sidemenu  = 'ComposerMessage';

// Identification
$page_nom = "Compose un message privé";
$page_url = "pages/user/pm";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Message privé" : "Private message";
$page_desc  = "Composer un message privé destiné à un autre membre du site";

// CSS & JS
$css  = array('user');
$js   = array('dynamique', 'user/notifications');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Assainissement du postdata
if(isset($_POST['message_envoyer']))
{
  $envoyer_pseudo = postdata_vide('message_destinataire', 'string', '');
  $envoyer_sujet  = postdata_vide('message_sujet',        'string', '');
  $envoyer_corps  = postdata_vide('message_textarea',     'string', '');
}

// Si on demande un destinataire spécifique, on le prend et on le remplit
if(isset($_GET['user']))
{
  $message_id     = postdata($_GET['user'], 'int');
  $message_pseudo = getpseudo($message_id);
}

// Récupération du post raw pour pré-remplir le formulaire
if(!isset($_GET['user']) || isset($_POST['message_envoyer']))
  $message_pseudo = isset($_POST['message_destinataire']) ? predata($_POST['message_destinataire']) : '';
$message_sujet    = isset($_POST['message_sujet'])        ? predata($_POST['message_sujet'])        : '';
$message_corps    = isset($_POST['message_textarea'])     ? predata($_POST['message_textarea'])     : '';
$message_hidden   = (!$message_corps) ? ' class="hidden"' : '';
$message_prev     = bbcode(predata($message_corps, 1));
$erreur           = '';





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if(isset($_POST['message_envoyer']))
{
  // On commence par vérifier que tout soit bien rempli
  $erreur = 0;
  if(!$envoyer_corps || !$envoyer_sujet || !$envoyer_pseudo)
    $erreur = ($lang == 'FR') ? "VOUS DEVEZ REMPLIR TOUS LES CHAMPS" : "EVERY FIELD MUST BE FILLED";

  // On vérifie que le destinataire existe
  if(!$erreur)
  {
    $qcheckpseudo = query(" SELECT membres.id FROM membres WHERE membres.pseudonyme LIKE '$envoyer_pseudo' ");
    if(!mysqli_num_rows($qcheckpseudo))
      $erreur = ($lang == 'FR') ? "CET UTILISATEUR N'EXISTE PAS" : "THIS USER DOES NOT EXIST";
  }

  // On va vérifier si l'user est un flooder ou non
  if(!$erreur)
  {
    $message_de = $_SESSION['user'];
    $floodtest  = (time() - 300);
    $qfloodtest = query(" SELECT  COUNT(notifications.id) AS 'm_count'
                          FROM    notifications
                          WHERE   notifications.FKmembres_envoyeur = '$message_de'
                          AND     notifications.date_envoi        >= '$floodtest' ");
    $dfloodtest = mysqli_fetch_array($qfloodtest);
    if($dfloodtest['m_count'] >= 5)
      $erreur = ($lang == 'FR') ? 'VOTRE MESSAGE N\'A PAS ÉTÉ ENVOYÉ<br>VOUS AVEZ ENVOYÉ TROP DE MESSAGES RÉCEMMENT<br>RÉESSAYEZ PLUS TARD' : 'YOUR MESSAGE HAS NOT BEEN SENT<br>YOU HAVE SENT TOO MANY MESSAGES RECENTLY<br>TRY AGAIN LATER';
  }

  // Si tout est bon, on peut envoyer le message et rediriger vers l'outbox
  if(!$erreur)
  {
    $dcheckpseudo = mysqli_fetch_array($qcheckpseudo);
    $message_a    = $dcheckpseudo['id'];
    $timestamp    = time();
    envoyer_notif($message_a, $envoyer_sujet, $envoyer_corps, $message_de);
    header("Location: ".$chemin."pages/user/notifications?envoyes");
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['m_titre']    = "Message privé";

  // Formulaire
  $trad['m_dest']     = "Pseudonyme du destinataire";
  $trad['m_sujet']    = "Sujet du message";
  $trad['m_corps']    = <<<EOD
Corps du message (vous pouvez utiliser des <a href="{$chemin}pages/doc/emotes">émoticônes</a> et des <a href="{$chemin}pages/doc/bbcodes">BBCodes</a>)
EOD;
  $trad['m_preview']  = "Prévisualisation du message";
  $trad['m_envoyer']  = "ENVOYER LE MESSAGE PRIVÉ";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['m_titre']    = "Private message";

  // Formulaire
  $trad['m_dest']     = "Recipient nickname";
  $trad['m_sujet']    = "Message title";
  $trad['m_corps']    = <<<EOD
Message body (you can use <a href="{$chemin}pages/doc/emotes">emotes</a> and <a href="{$chemin}pages/doc/bbcodes">BBCodes</a>)
EOD;
  $trad['m_preview']  = "Formatted message preview";
  $trad['m_envoyer']  = "SEND PRIVATE MESSAGE";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['m_titre']?></h1>

        <br>
        <br>

        <?php if($erreur) { ?>

        <h5 class="negatif gras texte_blanc align_center"><?=$erreur?></h5>
        <br>
        <br>

        <?php } ?>

        <form method="POST">
          <fieldset>

            <label for="message_destinataire"><?=$trad['m_dest']?></label>
            <input id="message_destinataire" name="message_destinataire" class="indiv" type="text" value="<?=$message_pseudo?>"><br>
            <br>

            <label for="message_sujet"><?=$trad['m_sujet']?></label>
            <input id="message_sujet" name="message_sujet" class="indiv" type="text" maxlength="80" value="<?=$message_sujet?>"><br>
            <br>

            <label for="message_textarea"><?=$trad['m_corps']?></label>
            <textarea id="message_textarea" name="message_textarea" class="indiv notif_message" onkeyup="notification_previsualiser('<?=$chemin?>');"><?=$message_corps?></textarea><br>
            <br>

            <div id="message_previsualisation_container"<?=$message_hidden?>>
              <label><?=$trad['m_preview']?></label>
              <div id="message_previsualisation" class="vscrollbar notif_previsualisation notif_cadre">
                <?=$message_prev?>
              </div>
              <br>
            </div>

            <div class="indiv align_center">
              <input type="submit" class="button" value="<?=$trad['m_envoyer']?>" name="message_envoyer">
            </div>

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';