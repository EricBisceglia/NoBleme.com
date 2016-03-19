<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Titre et description
$page_titre = "Roadmaps";
$page_desc  = "Gestion des plans de route";

// Identification
$page_nom = "admin";
$page_id  = "admin";

// CSS et JS
$css = array('todo');
$js  = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les roadmaps
$qroadmaps = query(" SELECT id, id_classement, version, description FROM todo_roadmap ORDER BY id_classement DESC ");

// Et on prépare pour l'affichage
for($nroadmaps = 0 ; $droadmaps = mysqli_fetch_array($qroadmaps) ; $nroadmaps++)
{
  $roadmap_id[$nroadmaps]           = $droadmaps['id'];
  $roadmap_classement[$nroadmaps]   = $droadmaps['id_classement'];
  $roadmap_version[$nroadmaps]      = $droadmaps['version'];
  $roadmap_description[$nroadmaps]  = $droadmaps['description'];
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/administration.png" alt="ADMINISTRATION">
    </div>
    <br>

    <div class="body_main admin_roadmap">
      <table class="cadre_gris indiv">
        <tr>
          <td colspan="3" class="cadre_gris_titre moinsgros">Plans de route</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre">Classement</td>
          <td colspan="2" class="cadre_gris_sous_titre">Version</td>
        </tr>
        <tr id="roadmap_add">
          <td class="cadre_gris nobleme_background roadmap_classement">
            <input class="intable discret align_center nobleme_background" value="" id="new_roadmap_classement">
          </td>
          <td class="cadre_gris nobleme_background">
            <input class="intable discret align_center nobleme_background" value="" id="new_roadmap_version">
          </td>
          <td class="cadre_gris nobleme_background roadmap_action">
            <a class="pointeur dark blank gras" onClick="dynamique('<?=$chemin?>','roadmaps?dynamique','roadmap_add',
                                                         'roadmap_add=0&amp;add_classement='+dynamique_prepare('new_roadmap_classement')+'&amp;add_version='+dynamique_prepare('new_roadmap_version'));">&nbsp;+</a>
          </td>
        </tr>
        <?php for($i=0;$i<$nroadmaps;$i++) { ?>
        <tr>
          <td colspan="3" class="cadre_gris_vide">
          </td>
        </tr>
        <tr id="roadmap_row<?=$i?>">
          <td class="cadre_gris nobleme_background roadmap_classement">
            <input class="intable discret align_center nobleme_background" value="<?=$roadmap_classement[$i]?>" id="roadmap_classement_<?=$roadmap_id[$i]?>" onChange="dynamique('<?=$chemin?>','roadmaps?dynamique','roadmap_row<?=$i?>',
                                         'roadmap_edit_classement=0&amp;roadmap_id=<?=$roadmap_id[$i]?>'+
                                         '&amp;roadmap_classement='+dynamique_prepare('roadmap_classement_<?=$roadmap_id[$i]?>'));">
          </td>
          <td class="cadre_gris nobleme_background">
            <input class="intable discret align_center nobleme_background" value="<?=$roadmap_version[$i]?>" id="roadmap_version_<?=$roadmap_id[$i]?>" onChange="dynamique('<?=$chemin?>','roadmaps?dynamique','roadmap_row<?=$i?>',
                                         'roadmap_edit_version=0&amp;roadmap_id=<?=$roadmap_id[$i]?>'+
                                         '&amp;roadmap_version='+dynamique_prepare('roadmap_version_<?=$roadmap_id[$i]?>'));">
          </td>
          <td class="cadre_gris nobleme_background roadmap_action">
            <a class="pointeur dark blank gras" onClick="dynamique('<?=$chemin?>','roadmaps?dynamique','roadmap_row<?=$i?>',
                                                        'roadmap_delete=0&amp;roadmap_id=<?=$roadmap_id[$i]?>');">&nbsp;X</a>
          </td>
        </tr>
        <tr id="roadmap_subrow<?=$i?>">
          <td colspan="3" class="cadre_gris nobleme_background">
            <textarea rows="2" class="intable discret align_center nobleme_background" id="roadmap_description_<?=$roadmap_id[$i]?>"
              onChange="dynamique('<?=$chemin?>','roadmaps?dynamique','roadmap_subrow<?=$i?>',
                       'roadmap_edit_description=0&amp;roadmap_id=<?=$roadmap_id[$i]?>'+
                       '&amp;roadmap_description='+dynamique_prepare('roadmap_description_<?=$roadmap_id[$i]?>'));"><?=$roadmap_description[$i]?></textarea>
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
  // XHR: Nouveau plan de route

  if(isset($_POST['roadmap_add']))
  {
    // Assainissement
    $add_classement = postdata(destroy_html($_POST['add_classement']));
    $add_version    = postdata(destroy_html($_POST['add_version']));

    // Ajout
    query(" INSERT INTO todo_roadmap SET id_classement = '$add_classement' , version = '$add_version' ");

    // Affichage
    ?>
    <td colspan="3" class="cadre_gris intable vert_background texte_blanc align_center gras">Plan de route ajouté</td>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Mise à jour du classement

  else if(isset($_POST['roadmap_edit_classement']))
  {
    // Assainissement
    $edit_id          = postdata($_POST['roadmap_id']);
    $edit_classement  = postdata(destroy_html($_POST['roadmap_classement']));

    // Mise à jour
    query(" UPDATE todo_roadmap SET id_classement = '$edit_classement' WHERE id = '$edit_id' ");

    // Affichage
    ?>
    <td colspan="3" class="cadre_gris intable vert_background texte_blanc align_center gras">Classement mis à jour</td>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Mise à jour de la version

  else if(isset($_POST['roadmap_edit_version']))
  {
    // Assainissement
    $edit_id      = postdata($_POST['roadmap_id']);
    $edit_version = postdata(destroy_html($_POST['roadmap_version']));

    // Mise à jour
    query(" UPDATE todo_roadmap SET version = '$edit_version' WHERE id = '$edit_id' ");

    // Affichage
    ?>
    <td colspan="3" class="cadre_gris intable vert_background texte_blanc align_center gras">Nom de version mis à jour</td>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Mise à jour de la description

  else if(isset($_POST['roadmap_edit_description']))
  {
    // Assainissement
    $edit_id          = postdata($_POST['roadmap_id']);
    $edit_description = postdata(destroy_html($_POST['roadmap_description']));

    // Mise à jour
    query(" UPDATE todo_roadmap SET description = '$edit_description' WHERE id = '$edit_id' ");

    // Affichage
    ?>
    <td colspan="3" class="cadre_gris intable vert_background texte_blanc align_center gras"><br>Description mise à jour<br><br></td>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Supprimer un plan de route

  else if(isset($_POST['roadmap_delete']))
  {
    // Assainissement
    $delete_id = postdata($_POST['roadmap_id']);

    // Suppression
    query(" DELETE FROM todo_roadmap WHERE id = '$delete_id' ");

    // Réassigner les tickets qui avaient cette catégorie
    query(" UPDATE todo SET FKtodo_roadmap = 0 WHERE FKtodo_roadmap = '$delete_id' ");

    // Affichage
    ?>
    <td colspan="3" class="cadre_gris intable erreur texte_blanc align_center gras">Plan de route supprimé</td>
    <?php
  }
}