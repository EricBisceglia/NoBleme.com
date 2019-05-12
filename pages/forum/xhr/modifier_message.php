<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
useronly();




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// S'il manque du postdata, on dégage
if(!isset($_POST['chemin']) || !isset($_POST['id']) || !isset($_POST['action']))
  exit();

// Assainissement du postdata
$chemin_xhr   = postdata_vide('chemin', 'string', $chemin);
$edit_id      = postdata_vide('id', 'int', 0);
$action_type  = postdata_vide('action', 'string', '');

// On va chercher si le message existe (et on en profite pour récupérer son contenu)
$qmessage = mysqli_fetch_array(query("  SELECT  forum_message.contenu ,
                                                forum_message.FKmembres
                                        FROM    forum_message
                                        WHERE   forum_message.id = '$edit_id'" ));

// S'il existe pas, on dégage
if($qmessage['contenu'] === NULL)
  exit();

// Sinon, on prépare son contenu pour l'affichage
$message_contenu          = predata($qmessage['contenu']);
$message_contenu_formate  = bbcode(predata($qmessage['contenu'], 1), 1);

// On regarde si c'est une modération (et si oui, on rejette si les droits ne sont pas bons)
if($qmessage['FKmembres'] != $_SESSION['user'])
{
  if(!getmod('forum'))
    exit();
  else
    $action_sysop = 1;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Options de modération
  $trad['mod_justif']   = ($action_type == 'edit') ? "Justification de la modification du message (optionnel)" : "Justification de la suppression (optionnel)";
  $trad['mod_envoyer']  = "Envoyer un message privé à l'utilisateur pour le notifier de l'action de modération";
  $trad['mod_oui']      = "Oui, envoyer un message privé automatique";
  $trad['mod_non']      = "Non, ne pas envoyer de message privé automatique";

  // Modifier un message
  $trad['edit_label']   = <<<EOD
Modifier le contenu du message (vous pouvez utiliser des <a class="gras" href="{$chemin}pages/doc/emotes">émoticônes</a> et des <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a>)
EOD;
  $trad['edit_prev']    = "Prévisualisation du message";
  $trad['edit_go']      = "MODIFIER LE MESSAGE";

  // Supprimer un message
  $trad['delete_check'] = "Confirmez la suppression définitive de ce message en cliquant sur le bouton ci-dessous";
  $trad['delete_go']    = "SUPPRIMER LE MESSAGE";

  // Supprimer un sujet
  $trad['sujet_check']  = "Confirmez la suppression définitive de ce sujet et de toutes ses réponses en cliquant sur le bouton ci-dessous";
  $trad['sujet_go']     = "SUPPRIMER L'INTÉGRALITÉ DU SUJET";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Options de modération
  $trad['mod_justif']   = ($action_type == 'edit') ? "Reason for editing the post (optional)" : "Reason for deleting the post (optional)";
  $trad['mod_envoyer']  = "Send a private message to the user to justify the moderating";
  $trad['mod_oui']      = "Yes, send an automated private message";
  $trad['mod_non']      = "No, do not send an automated private message";

  // Modifier un message
  $trad['edit_label']   = <<<EOD
Edit the contents of this reply (you can use <a class="gras" href="{$chemin}pages/doc/emotes">emotes</a> and <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a> for formatting)
EOD;
  $trad['edit_prev']    = "Formatted message preview";
  $trad['edit_go']      = "EDIT REPLY";

  // Supprimer un message
  $trad['delete_check'] = "Confirm the permanent deletion of this reply by clicking the button below";
  $trad['delete_go']    = "PERMANENTLY DELETE REPLY";

  // Supprimer un sujet
  $trad['sujet_check']  = "Confirm the permanent deletion of this thread and all its replies by clicking the button below";
  $trad['sujet_go']     = "PERMANENTLY DELETE THE WHOLE THREAD";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<tr>
  <td class="forum_modifier_message_corps">

    <form method="POST" id="forum_poster_reponse_<?=$edit_id?>">
      <fieldset>

        <input type="hidden" name="forum_message_id" value="<?=$edit_id?>">

        <?php if(isset($action_sysop)) { ?>

        <label for="forum_message_justification_<?=$edit_id?>" id="forum_add_titre_label"><?=$trad['mod_justif']?></label>
        <input id="forum_message_justification_<?=$edit_id?>" name="forum_message_justification_<?=$edit_id?>" class="indiv" type="text"><br>
        <br>

        <label for="forum_message_envoyer_<?=$edit_id?>" id="forum_add_titre_label"><?=$trad['mod_envoyer']?></label>
        <select id="forum_message_envoyer_<?=$edit_id?>" name="forum_message_envoyer_<?=$edit_id?>" class="indiv">
          <option value="1"><?=$trad['mod_oui']?></option>
          <option value="0"><?=$trad['mod_non']?></option>
        </select><br>
        <br>

        <?php } ?>

        <?php if($action_type == 'edit') { ?>

        <label for="forum_modifier_message_<?=$edit_id?>" id="forum_ecrire_reponse_label_<?=$edit_id?>"><?=$trad['edit_label']?></label>
        <textarea id="forum_modifier_message_<?=$edit_id?>" name="forum_modifier_message_<?=$edit_id?>" class="indiv forum_ecrire_reponse_composition" onkeyup="forum_ecrire_reponse_previsualisation('<?=$chemin?>', <?=$edit_id?>);"><?=$message_contenu?></textarea><br>
        <br>

        <input type="submit" value="<?=$trad['edit_go']?>" name="forum_modifier_message_go">

        <div id="forum_ecrire_reponse_container_<?=$edit_id?>">
          <br>
          <label><?=$trad['edit_prev']?></label>
          <div class="vscrollbar forum_ecrire_reponse_previsualisation" id="forum_modifier_message_previsualisation_<?=$edit_id?>">
            <?=$message_contenu_formate?>
          </div>
          <br>
        </div>

        <?php } else if($action_type == 'delete') { ?>

        <div class="align_center">
          <br>
          <span class="moinsgros gras texte_negatif"><?=$trad['delete_check']?></span><br>
          <br>
          <br>
          <input type="submit" value="<?=$trad['delete_go']?>" name="forum_supprimer_message_go"><br>
          <br>
        </div>

        <?php } else { ?>

        <div class="align_center">
          <br>
          <span class="moinsgros gras texte_negatif"><?=$trad['sujet_check']?></span><br>
          <br>
          <br>
          <input type="submit" value="<?=$trad['sujet_go']?>" name="forum_supprimer_sujet_go"><br>
          <br>
        </div>

        <?php } ?>

      </fieldset>
    </form>

  </td>
</tr>