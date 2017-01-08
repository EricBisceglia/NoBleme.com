<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'admin';
$header_submenu   = 'admin';
$header_sidemenu  = 'nompages';

// Titre et description
$page_titre = "Dev : Nom des pages";

// Identification
$page_nom = "admin";

// CSS & JS
$js  = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Ajout d'une nouvelle ligne dans le tableau
if(isset($_POST['addrow']))
{
  // Traitement du postdata
  $add_nom  = postdata(destroy_html($_POST['add_nom']));
  $add_id   = postdata(destroy_html($_POST['add_id']));
  $add_page = postdata(destroy_html($_POST['add_page']));
  $add_url  = postdata(destroy_html($_POST['add_url']));

  // Insertion de la nouvelle ligne
  query(" INSERT INTO pages
          SET         pages.page_nom    = '$add_nom'  ,
                      pages.page_id     = '$add_id'   ,
                      pages.visite_page = '$add_page' ,
                      pages.visite_url  = '$add_url'  ");

  // Et on chope le nom de cette ligne
  $add_newline = mysqli_insert_id($db);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va récupérer tous les noms de page existants
$qpages = query(" SELECT    pages.id            ,
                            pages.page_nom      ,
                            pages.page_id       ,
                            pages.visite_page   ,
                            pages.visite_url
                  FROM      pages
                  ORDER BY  pages.page_nom  ASC ,
                            pages.page_id   ASC ");

// Et on prépare les données
for($npages = 0 ; $dpages = mysqli_fetch_array($qpages) ; $npages++)
{
  $p_id[$npages]    = $dpages['id'];
  $p_nom[$npages]   = $dpages['page_nom'];
  $p_pid[$npages]   = $dpages['page_id'];
  $p_page[$npages]  = $dpages['visite_page'];
  $p_url[$npages]   = $dpages['visite_url'];
  $p_bg[$npages]    = ($npages%2) ? ' blanc' : ' nobleme_background';
  $p_bg[$npages]    = (isset($add_newline) && $add_newline == $dpages['id']) ? ' vert_background' : $p_bg[$npages];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <br>
    <br>

    <div class="body_main bigsize margin_auto">
      <table class="indiv cadre_gris">

        <tr>
          <td class="cadre_gris_titre gros" colspan="6">
            NOM DES PAGES
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Nom
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            ID
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Page
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            URL
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros" colspan="2">
            Actions
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">
            <input class="indiv align_center discret" id="add_nom" value="" size="5">
          </td>
          <td class="cadre_gris align_center">
            <input class="indiv align_center discret" id="add_id" value="" size="5">
          </td>
          <td class="cadre_gris align_center">
            <input class="indiv align_center discret" id="add_page" value="">
          </td>
          <td class="cadre_gris align_center">
            <input class="indiv align_center discret" id="add_url" value="">
          </td>
          <td class="cadre_gris align_center" colspan="2">
            <input type="submit" class="indiv align_center discret pointeur" value="Ajouter"
              onClick="dynamique('<?=$chemin?>','pages.php','body',
              'add_nom='+dynamique_prepare('add_nom')+
              '&amp;add_id='+dynamique_prepare('add_id')+
              '&amp;add_page='+dynamique_prepare('add_page')+
              '&amp;add_url='+dynamique_prepare('add_url')+
              '&amp;addrow=<?=$i?>')">
          </td>
        </tr>

        <?php for($i=0;$i<$npages;$i++) { ?>

        <tr id="rn<?=$i?>">
          <td class="cadre_gris align_center<?=$p_bg[$i]?>">
            <?=$p_nom[$i]?>
          </td>
          <td class="cadre_gris align_center<?=$p_bg[$i]?>">
            <?=$p_pid[$i]?>
          </td>
          <td class="cadre_gris align_center<?=$p_bg[$i]?>">
            <input type="hidden" id="p_id<?=$i?>" value="<?=$p_id[$i]?>">
            <input id="p_page<?=$i?>" class="indiv align_center discret<?=$p_bg[$i]?>" value="<?=$p_page[$i]?>">
          </td>
          <td class="cadre_gris align_center<?=$p_bg[$i]?>">
            <input id="p_url<?=$i?>" class="indiv align_center discret<?=$p_bg[$i]?>" value="<?=$p_url[$i]?>">
          </td>
          <td class="cadre_gris align_center<?=$p_bg[$i]?>">
            <input type="submit" class="indiv align_center discret pointeur<?=$p_bg[$i]?>" value="Éditer"
              onClick="dynamique('<?=$chemin?>','pages.php?dynamique','rn<?=$i?>',
              'p_id='+dynamique_prepare('p_id<?=$i?>')+
              '&amp;p_page='+dynamique_prepare('p_page<?=$i?>')+
              '&amp;p_url='+dynamique_prepare('p_url<?=$i?>')+
              '&amp;editrow=<?=$i?>')">
          </td>
          <td class="cadre_gris align_center<?=$p_bg[$i]?>">
            <input type="submit" class="indiv align_center discret pointeur<?=$p_bg[$i]?>" value="Supprimer"
              onClick="var ok = confirm('Confirmer la suppression de <?=addslashes($p_page[$i])?> ?'); if(ok == true) {
              dynamique('<?=$chemin?>','pages.php?dynamique','rn<?=$i?>',
              'p_id='+dynamique_prepare('p_id<?=$i?>')+
              '&amp;deleterow=<?=$i?>'); }">
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
  // XHR: Éditer une ligne

  if(isset($_POST['editrow']))
  {
    // Traitement du postdata
    $post_id    = postdata($_POST['p_id']);
    $post_page  = postdata(destroy_html($_POST['p_page']));
    $post_url   = postdata(destroy_html($_POST['p_url']));
    $i          = postdata($_POST['editrow']);

    // Mise à jour des données
    query(" UPDATE pages SET pages.visite_page = '$post_page', pages.visite_url = '$post_url' WHERE pages.id = '$post_id' ");

    // On prépare les données pour l'affichage
    $display_page = stripslashes($post_page);
    $display_url  = stripslashes($post_url);

    // Et on balance la ligne validée
    ?>

    <td class="cadre_gris align_center italique vert_background">
      <?=$p_nom[$i]?>
    </td>
    <td class="cadre_gris align_center italique vert_background">
      <?=$p_pid[$i]?>
    </td>
    <td class="cadre_gris align_center italique vert_background">
      <?=$display_page?>
    </td>
    <td class="cadre_gris align_center italique vert_background">
      <?=$display_url?>
    </td>
    <td class="cadre_gris align_center gras vert_background" colspan="2">
      L'entrée a bien été éditée
    </td>

    <?php
  }

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Supprimer

  if(isset($_POST['deleterow']))
  {
    // Récupération de la ligne à faire péter
    $delete_id = postdata_vide('p_id');

    // Suppression
    query(" DELETE FROM pages WHERE pages.id = '$delete_id' ");

    // Et on balance la ligne purgée
    ?>

    <td class="cadre_gris align_center gras erreur texte_blanc" colspan="6">
      L'éntrée a bien été supprimée
    </td>

    <?php
  }

}