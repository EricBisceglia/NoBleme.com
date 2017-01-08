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
$header_sidemenu  = 'flashanniv';

// Titre et description
$page_titre = "Dev : Flash anniv";

// Identification
$page_nom = "admin";

// CSS & JS
$js  = array('dynamique','popup');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Ajout d'une nouvelle entrée
if(isset($_POST['addrow']))
{
  // Traitement du postdata
  $add_nom      = postdata(destroy_html($_POST['add_nom']));
  $add_largeur  = postdata(destroy_html($_POST['add_largeur']));

  // Insertion des données
  query(" INSERT INTO anniv_flash SET anniv_flash.nom_fichier = '$add_nom', anniv_flash.largeur = '$add_largeur' ");

  // On garde l'id de la ligne fraichement ajoutée
  $add_newline = mysqli_insert_id($db);
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tableau des flashs

if(!isset($_GET['showcase']))
{
  // On va chercher les données
  $qflashanniv = query(" SELECT anniv_flash.id, anniv_flash.nom_fichier, anniv_flash.largeur FROM anniv_flash ORDER BY anniv_flash.nom_fichier ASC ");

  // Préparation des données
  for($nflashanniv = 0 ; $dflashanniv = mysqli_fetch_array($qflashanniv) ; $nflashanniv++)
  {
    $fa_id[$nflashanniv]      = $dflashanniv['id'];
    $fa_nom[$nflashanniv]     = $dflashanniv['nom_fichier'];
    $fa_largeur[$nflashanniv] = $dflashanniv['largeur'];
    $fa_css[$nflashanniv]     = ($nflashanniv%2) ? 'blanc' : 'nobleme_background';
    $fa_css[$nflashanniv]     = (isset($add_newline) && $add_newline == $dflashanniv['id']) ? ' vert_background' : $fa_css[$nflashanniv];
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Flash individuel en showcase
else
{
  // Récupération du postdata
  $flashatraiter = postdata($_GET['showcase']);

  // Récupération du flash à showcaser
  $dflashanniv = mysqli_fetch_array(query(" SELECT anniv_flash.nom_fichier, anniv_flash.largeur FROM anniv_flash WHERE anniv_flash.id = '$flashatraiter' "));

  // Préparation des données
  $agenobleme = (date('Y')-2005+1);
  $annivflash = $dflashanniv['nom_fichier'];
  $annivsize  = $dflashanniv['largeur'];
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <?php if(!isset($_GET['showcase'])) { ?>

    <br>

    <div class="body_main midsize margin_auto">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="5">
            FLASH LOOPS POUR L'ANNIVERSAIRE (19 MARS)
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Fichier
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Largeur
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros" colspan="3">
            Actions
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">
            <input class="indiv discret align_center" id="add_nom" value="">
          </td>
          <td class="cadre_gris align_center">
            <input class="indiv discret align_center" id="add_largeur" value="">
          </td>
          <td class="cadre_gris align_center" colspan="3">
            <input type="submit" class="indiv discret align_center blanc" value="Ajouter"
              onClick="dynamique('<?=$chemin?>','flashanniv.php?ajouter','body',
              'add_nom='+dynamique_prepare('add_nom')+
              '&amp;add_largeur='+dynamique_prepare('add_largeur')+
              '&amp;addrow=1');">
          </td>
        </tr>

        <?php for($i=0;$i<$nflashanniv;$i++) { ?>

        <tr id="dl<?=$i?>">
          <td class="cadre_gris align_center <?=$fa_css[$i]?>">
            <input class="indiv discret align_center <?=$fa_css[$i]?>" id="fa_nom<?=$i?>" value="<?=$fa_nom[$i]?>">
          </td>
          <td class="cadre_gris align_center <?=$fa_css[$i]?>">
            <input class="indiv discret align_center <?=$fa_css[$i]?>" id="fa_largeur<?=$i?>" value="<?=$fa_largeur[$i]?>">
          </td>
          <td class="cadre_gris align_center <?=$fa_css[$i]?>" id="rn<?=$i?>">
            <input type="submit" class="indiv discret align_center <?=$fa_css[$i]?>" value="Aperçu" onClick="lienpopup('flashanniv.php?popup&amp;showcase=<?=$fa_id[$i]?>',500);">
          </td>
          <td class="cadre_gris align_center <?=$fa_css[$i]?>">
            <input type="submit" class="indiv discret align_center <?=$fa_css[$i]?>" value="Modifier"
              onClick="dynamique('<?=$chemin?>','flashanniv.php?dynamique','rn<?=$i?>',
              'fa_id=<?=$fa_id[$i]?>
              &amp;fa_nom='+dynamique_prepare('fa_nom<?=$i?>')+
              '&amp;fa_largeur='+dynamique_prepare('fa_largeur<?=$i?>')+
              '&amp;editrow=<?=$i?>');">
          </td>
          <td class="cadre_gris align_center <?=$fa_css[$i]?>">
            <input type="submit" class="indiv discret align_center <?=$fa_css[$i]?>" value="Supprimer"
            onClick="var ok = confirm('Confirmer la suppression de <?=addslashes($fa_nom[$i])?> ?'); if(ok == true) {
            dynamique('<?=$chemin?>','flashanniv.php?dynamique','dl<?=$i?>','deleterow=<?=$fa_id[$i]?>'); }">
          </td>
        </tr>

        <?php } ?>

      </table>
    </div>

    <?php } else { ?>

    <br>
    <br>
    <br>

    <div class="moinsgros gras align_center">
      Joyeux anniversaire NoBleme.com !<br>
      <?=$agenobleme?> ans de bons moments<br>
      2005 - <?=date('Y')?><br>
      <a class="dark blank gros gras" href="">F5 !</a><br>
    </div>
    <br>
    <div class="align_center">
      <embed src="<?=$chemin?>img/swf/anniv_<?=$annivflash?>.swf" width="<?=$annivsize?>px"> </embed>
    </div>

    <br>
    <br>

    <?php } ?>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Éditer une entrée

  if(isset($_POST['editrow']))
  {
    // Récupération du postdata
    $edit_id      = postdata($_POST['fa_id']);
    $edit_nom     = postdata(destroy_html($_POST['fa_nom']));
    $edit_largeur = postdata(destroy_html($_POST['fa_largeur']));

    // Modification des données
    query(" UPDATE anniv_flash SET anniv_flash.nom_fichier = '$edit_nom', anniv_flash.largeur = '$edit_largeur' WHERE anniv_flash.id = '$edit_id' ");

    // Et on confirme que ça s'est bien passé
    ?>

    <input type="submit" class="indiv discret align_center vert_background" value="Aperçu" onClick="lienpopup('flashanniv.php?popup&amp;showcase=<?=$edit_id?>',500)";>

    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Supprimer une entrée

  if(isset($_POST['deleterow']))
  {
    // On se chope l'id à supprimer
    $deleterow = postdata_vide('deleterow');

    // On bazarde la ligne
    query(" DELETE FROM anniv_flash WHERE anniv_flash.id = '$deleterow' ");

    // Et on affiche une ligne rouge dans le tableau
    ?>

    <td class="cadre_gris align_center gras erreur texte_blanc" colspan="5">
      L'éntrée a bien été supprimée
    </td>

    <?php
  }
}