<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
adminonly($lang);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des données

// On chope l'id et l'action à faire
$image_id     = postdata_vide('id', 'int', 0);
$image_action = (isset($_GET['delete'])) ? 'delete' : 'edit';

// On vérifie qu'on ait le droit d'être là
if(!verifier_existence('nbdb_web_image', $image_id))
  exit('ID inexistant');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Informations sur l'image

// On va chercher les infos sur l'image
$dimage = mysqli_fetch_array(query("  SELECT  nbdb_web_image.nom_fichier  AS 'i_nom'  ,
                                              nbdb_web_image.tags         AS 'i_tags' ,
                                              nbdb_web_image.nsfw         AS 'i_nsfw'
                                      FROM    nbdb_web_image
                                      WHERE   nbdb_web_image.id = '$image_id' "));

// Et on les prépare pour l'affichage
$image_nom  = predata($dimage['i_nom']);
$image_tags = predata($dimage['i_tags']);
$image_nsfw = ($dimage['i_nsfw']) ? ' checked' : '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<td colspan="5">
  <br>

  <div class="minitexte3 align_left">
    <fieldset>

      <?php if($image_action == 'edit') { ?>

      <label for="web_edit_image_tags_<?=$image_id?>">Tags (séparés par des points virgule)</label>
      <input id="web_edit_image_tags_<?=$image_id?>" name="web_edit_image_nom_<?=$image_id?>" class="indiv" type="text" value="<?=$image_tags?>"><br>
      <br>

      <input id="web_edit_image_nsfw_<?=$image_id?>" name="web_edit_image_nsfw_<?=$image_id?>" type="checkbox"<?=$image_nsfw?>>
      <label class="label-inline" for="web_edit_image_nsfw_<?=$image_id?>">Cette image est NSFW</label><br>
      <br>

      <button onclick="toggle_oneway('web_images_edition_<?=$image_id?>', 0, 1); dynamique('<?=$chemin?>', 'web_images?edit', 'web_images_tableau', 'web_images_id=<?=$image_id?>&amp;web_images_tags='+dynamique_prepare('web_edit_image_tags_<?=$image_id?>')+'&amp;web_images_nsfw='+document.getElementById('web_edit_image_nsfw_<?=$image_id?>').checked, 1);">MODIFIER LES INFORMATIONS</button>
      &nbsp;
      <button class="button-clear" onclick="toggle_oneway('web_images_edition_<?=$image_id?>', 0, 1);">MASQUER LE FORMULAIRE</button>

      <?php } else { ?>

      <h5 class="align_center">
        Confirmer la suppression de <?=$image_nom?> ?
      </h5>

      <br>

      <button onclick="toggle_oneway('web_images_edition_<?=$image_id?>', 0, 1); dynamique('<?=$chemin?>', 'web_images?delete', 'web_images_tableau', 'web_images_id=<?=$image_id?>', 1)">SUPPRIMER DÉFINITIVEMENT L'IMAGE</button>
      &nbsp;
      <button class="button-clear" onclick="toggle_oneway('web_images_edition_<?=$image_id?>', 0, 1);">MASQUER LE FORMULAIRE</button>

      <?php } ?>

      </fieldset>
    </div>

  <br>
</td>