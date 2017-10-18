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
if(!isset($_POST['message_id']))
  exit('ERREUR: ID MESSAGE INEXISTANT');

// On veut aussi avoir le bon chemin
if(!isset($_POST['chemin']))
  exit('ERREUR: CHEMIN INEXISTANT');

// Maintenant on peut assainir le postdata
$message_id = postdata($_POST['message_id'], 'int');
$chemin_xhr = postdata($_POST['chemin'], 'string');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher le contenu du message
$qmessage = "     SELECT    notifications.FKmembres_destinataire  AS 'm_a'      ,
                            notifications.FKmembres_envoyeur      AS 'm_de_id'  ,
                            membres.pseudonyme                    AS 'm_de'     ,
                            notifications.date_envoi              AS 'm_date'   ,
                            notifications.date_consultation       AS 'm_lu'     ,
                            notifications.titre                   AS 'm_titre'  ,
                            notifications.contenu                 AS 'm_texte'
                  FROM      notifications ";
if(!isset($_POST['envoye']))
  $qmessage .= "  LEFT JOIN membres ON notifications.FKmembres_envoyeur = membres.id ";
else
  $qmessage .= "  LEFT JOIN membres ON notifications.FKmembres_destinataire = membres.id ";
$qmessage .= "    WHERE     notifications.id = '$message_id' ";
$qmessage = query($qmessage);

// Si il n'y a pas de message, on s'arrête là
if(!mysqli_num_rows($qmessage))
  exit('ERREUR: MESSAGE INEXISTANT');

// Si le message n'est pas destiné à l'user qui le lit, on s'arrête là
$dmessage = mysqli_fetch_array($qmessage);
if($dmessage['m_a'] != $_SESSION['user'] && $dmessage['m_de_id'] != $_SESSION['user'])
  exit('ERREUR: ON NE LIT PAS LES MESSAGES DES AUTRES');

// Tout est bon, on peut préparer les données pour l'affichage
$message_titre    = predata($dmessage['m_titre']);
$temp_de_id       = (!isset($_POST['envoye'])) ? $dmessage['m_de_id'] : $dmessage['m_a'];
$message_de       = ($dmessage['m_de']) ? '<a class="gras" href="'.$chemin_xhr.'pages/user/user?id='.$temp_de_id.'">'.predata($dmessage['m_de']).'</a>' : "le système";
$message_de       = (!$dmessage['m_de'] && $lang == 'EN') ? "the system" : $message_de;
$message_date     = datefr(date('Y-m-d', $dmessage['m_date']), $lang);
$message_heure    = date('H:i', $dmessage['m_date']);
$message_ilya     = ilya($dmessage['m_date'], $lang);
$message_lu       = ($dmessage['m_lu']) ? datefr(date('Y-m-d', $dmessage['m_lu']), $lang) : 0;
$message_lu_h     = ($dmessage['m_lu']) ? date('H:i', $dmessage['m_lu']) : '';
$message_texte    = bbcode(predata($dmessage['m_texte'], 1), 1);
$message_reponse  = ($dmessage['m_de']) ? predata($dmessage['m_de']) : 'Bad';
$message_re       = predata('RE: '.$dmessage['m_titre']);
$message_envoyeur = (!$dmessage['m_de']) ? 'Bad' : predata($dmessage['m_de']);
$message_corps    = predata($dmessage['m_texte']);

// Si le message n'est pas lu, on le marque comme lu
if(!$dmessage['m_lu'] && !isset($_POST['envoye']))
{
  $timestamp = time();
  query(" UPDATE notifications SET notifications.date_consultation = '$timestamp' WHERE notifications.id = '$message_id' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if(!isset($_POST['envoye']))
{
  $traduction['m_envoye']       = ($lang == 'FR') ? "Message envoyé par $message_de le $message_date à $message_heure ($message_ilya)" : "Message sent by $message_de on $message_date at $message_heure ($message_ilya)";
  $traduction['m_lu']           = ($lang == 'FR') ? "Vous avez lu ce message le $message_lu à $message_lu_h" : "You have read this message on $message_lu at $message_lu_h";
}
else
{
  $traduction['m_envoye']       = ($lang == 'FR') ? "Message envoyé à $message_de le $message_date à $message_heure ($message_ilya)" : "Message sent to $message_de on $message_date at $message_heure ($message_ilya)";
  $traduction['m_lu']           = ($lang == 'FR') ? "$message_envoyeur a lu ce message le $message_lu à $message_lu_h" : "$message_envoyeur read this message on $message_lu at $message_lu_h";
}


$traduction['m_destinataire'] = ($lang == 'FR') ? "Destinataire" : "Message to";
$traduction['m_sujet']        = ($lang == 'FR') ? "Sujet du message" : "Message title";
$traduction['m_corps']        = ($lang == 'FR') ? "Corps du message (vous pouvez utiliser des <a href=\"".$chemin_xhr."pages/doc/emotes\">émoticônes</a> et des <a href=\"".$chemin_xhr."pages/doc/bbcodes\">BBCodes</a>)" : "Message body (you can use <a href=\"".$chemin_xhr."pages/doc/emotes\">emotes</a> and <a href=\"".$chemin_xhr."pages/doc/bbcodes\">BBCodes</a>)";
$traduction['m_preview']      = ($lang == 'FR') ? "Prévisualisation du message" : "Formatted message preview";
$traduction['m_envoyer']      = ($lang == 'FR') ? "ENVOYER LE MESSAGE PRIVÉ" : "SEND PRIVATE MESSAGE";
$traduction['m_rep_citer']    = ($lang == 'FR') ? "RÉPONDRE AVEC CITATION" : "REPLY AND QUOTE MESSAGE";
$traduction['m_rep_non']      = ($lang == 'FR') ? "RÉPONDRE SANS CITATION" : "REPLY WITHOUT QUOTING";
$traduction['m_supprimer']    = ($lang == 'FR') ? "SUPPRIMER LE MESSAGE" : "DELETE THIS MESSAGE";
$traduction['m_confirm']      = ($lang == 'FR') ? "Êtes-vous sûr de vouloir supprimer définitivement ce message ?" : "Are you sure you want to delete this message? It will be forever lost."




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<div class="indiv align_left notif_cadre notif_grand_cadre">
  <br>
  <span class="alinea gras souligne"><?=$message_titre?></span><br>
  <br>
  <span class="italique"><?=$traduction['m_envoye']?></span><br>
  <?php if($message_lu) { ?>
  <span class="italique texte_nobleme_clair"><?=$traduction['m_lu']?></span>
  <?php } ?>
</div>

<div class="indiv align_left notif_cadre notif_grand_cadre">
  <br>
  <?=$message_texte?><br>
  <br>
</div>

<?php if(!isset($_POST['envoye'])) { ?>

<div class="indiv align_left notif_cadre notif_grand_cadre hidden" id="message_reponse_<?=$message_id?>">
  <fieldset>

    <label for="message_destinataire_<?=$message_id?>"><?=$traduction['m_destinataire']?></label>
    <input id="message_destinataire_<?=$message_id?>" name="message_destinataire_<?=$message_id?>" class="indiv" type="text" value="<?=$message_reponse?>" disabled><br>
    <br>

    <label for="message_sujet_<?=$message_id?>"><?=$traduction['m_sujet']?></label>
    <input id="message_sujet_<?=$message_id?>" name="message_sujet_<?=$message_id?>" class="indiv" type="text" value="<?=$message_re?>" maxlength="80" disabled><br>
    <br>

    <label for="message_textarea_<?=$message_id?>"><?=$traduction['m_corps']?></label>
    <textarea id="message_textarea_<?=$message_id?>" name="message_textarea_<?=$message_id?>" class="indiv notif_message"
              onkeyup=" notification_previsualiser('<?=$chemin?>', '<?=$message_id?>');">[quote=<?=$message_envoyeur?>]
<?=$message_corps?>

[/quote]</textarea><br>
    <br>

    <div id="message_previsualisation_container_<?=$message_id?>">
      <label><?=$traduction['m_preview']?>:</label>
      <div id="message_previsualisation_<?=$message_id?>" class="vscrollbar notif_previsualisation notif_cadre">
        <?=$message_texte?>
      </div>
      <br>
    </div>

    <div class="indiv align_center">
      <button class="button" onclick="notification_envoyer_reponse('<?=$chemin?>', '<?=$message_id?>');"><?=$traduction['m_envoyer']?></button>
    </div>

  </fieldset>
</div>

<div class="flexcontainer" id="message_actions_<?=$message_id?>">

  <div  class="pointeur notif_cadre notif_cadre_gauche" style="flex:1;" onclick="notification_formulaire_reponse('<?=$message_id?>', 1);">
    <button class="button button-outline notif_cadre_bouton"><?=$traduction['m_rep_citer']?></button>
  </div>

  <div  class="pointeur notif_cadre notif_cadre_milieu" style="flex:1;" onclick="notification_formulaire_reponse('<?=$message_id?>');">
    <button class="button button-outline notif_cadre_bouton"><?=$traduction['m_rep_non']?></button>
  </div>

  <div  class="pointeur notif_cadre notif_cadre_droite" style="flex:1;" onclick="notification_supprimer('<?=$chemin?>', '<?=$message_id?>', '<?=$traduction['m_confirm']?>')">
    <button class="button notif_cadre_bouton"><?=$traduction['m_supprimer']?></button>
  </div>

</div>

<?php } ?>