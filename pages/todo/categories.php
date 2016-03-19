<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Titre et description
$page_titre = "Catégories";
$page_desc  = "Gestion des catégories de tickets";

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

// On va chercher les catégories
$qcat = query(" SELECT id, categorie FROM todo_categorie ORDER BY categorie ASC ");

// Et on prépare pour l'affichage
for($ncat = 0 ; $dcat = mysqli_fetch_array($qcat) ; $ncat++)
{
  $cat_id[$ncat]  = $dcat['id'];
  $cat_nom[$ncat] = $dcat['categorie'];
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

    <div class="body_main admin_microsize">
      <table class="cadre_gris indiv">
        <tr>
          <td colspan="2" class="cadre_gris_titre moinsgros">Projets</td>
        </tr>
        <tr id="cat_add">
          <td colspan="2" class="cadre_gris nobleme_background">
            <input class="intable discret align_center nobleme_background" value="" id="new_cat"
                   onChange="dynamique('<?=$chemin?>','categories?dynamique','cat_add',
                            'cat_add=0&amp;cat_nom='+dynamique_prepare('new_cat'));">
          </td>
        </tr>
        <?php for($i=0;$i<$ncat;$i++) { ?>
        <tr id="cat_row<?=$i?>">
          <td class="cadre_gris nobleme_background">
            <input class="intable discret align_center nobleme_background" value="<?=$cat_nom[$i]?>" id="cat<?=$cat_id[$i]?>"
                   onChange="dynamique('<?=$chemin?>','categories?dynamique','cat_row<?=$i?>',
                            'cat_edit=0&amp;cat_id=<?=$cat_id[$i]?>&amp;cat_nom='+dynamique_prepare('cat<?=$cat_id[$i]?>'));">
          </td>
          <td class="cadre_gris nobleme_background">
            <a class="pointeur dark blank gras" onClick="dynamique('<?=$chemin?>','categories?dynamique','cat_row<?=$i?>',
                                                        'cat_delete=0&amp;cat_id=<?=$cat_id[$i]?>');">&nbsp;X</a>
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
  // XHR: Nouvelle catégorie

  if(isset($_POST['cat_add']))
  {
    // Assainissement
    $add_nom = postdata(destroy_html($_POST['cat_nom']));

    // Ajout
    query(" INSERT INTO todo_categorie SET categorie = '$add_nom' ");

    // Affichage
    ?>
    <td colspan="2" class="cadre_gris intable vert_background texte_blanc align_center gras">Catégorie ajoutée</td>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Modifier nom de catégorie

  if(isset($_POST['cat_edit']))
  {
    // Assainissement
    $edit_id  = postdata($_POST['cat_id']);
    $edit_nom = postdata(destroy_html($_POST['cat_nom']));

    // Mise à jour
    query(" UPDATE todo_categorie SET categorie = '$edit_nom' WHERE id = '$edit_id' ");

    // Affichage
    ?>
    <td colspan="2" class="cadre_gris intable vert_background texte_blanc align_center gras">Nom de catégorie modifié</td>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Supprimer une catégorie

  if(isset($_POST['cat_delete']))
  {
    // Assainissement
    $delete_id = postdata($_POST['cat_id']);

    // Suppression
    query(" DELETE FROM todo_categorie WHERE id = '$delete_id' ");

    // Réassigner les tickets qui avaient cette catégorie
    query(" UPDATE todo SET FKtodo_categorie = 0 WHERE FKtodo_categorie = '$delete_id' ");

    // Affichage
    ?>
    <td colspan="2" class="cadre_gris intable erreur texte_blanc align_center gras">Catégorie supprimée</td>
    <?php
  }
}