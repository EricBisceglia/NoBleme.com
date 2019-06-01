<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/nbdb.inc.php';     // Fonctions lées à la NBDB

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBEncycloWeb';

// Identification
$page_nom = "Administre la NBDB";
$page_url = "pages/nbdb/index";

// Langues disponibles
$langue_page = array('FR');

// Titre
$page_titre = "NBDB : Administration";

// CSS
$css = array('nbdb');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mise à jour des notes

if(isset($_POST['web_notes_prev']) || isset($_POST['web_notes_edit']))
{
  // Assainissement du postdata
  $web_notes_global = postdata_vide('web_notes_global', 'string', '');
  $web_notes_fr     = postdata_vide('web_notes_fr', 'string', '');
  $web_notes_en     = postdata_vide('web_notes_en', 'string', '');

  // On supprime le contenu des notes
  query(" TRUNCATE nbdb_web_notes_admin ");

  // Mise à jour
  query(" INSERT INTO nbdb_web_notes_admin
          SET         nbdb_web_notes_admin.notes_admin  = '$web_notes_global' ,
                      nbdb_web_notes_admin.brouillon_fr = '$web_notes_fr'     ,
                      nbdb_web_notes_admin.brouillon_en = '$web_notes_en'     ");

  // Préparation des prévisualisations
  $web_notes_global   = ($_POST['web_notes_global']);
  $web_notes_fr       = ($_POST['web_notes_fr']);
  $web_notes_en       = ($_POST['web_notes_en']);
  $web_notes_fr_prev  = nbdbcode(bbcode(predata($_POST['web_notes_fr'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie('FR'), nbdb_web_liste_pages_dictionnaire('FR'));
  $web_notes_en_prev  = nbdbcode(bbcode(predata($_POST['web_notes_en'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie('FR'), nbdb_web_liste_pages_dictionnaire('FR'));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des notes

if(!isset($_POST['web_notes_prev']))
{
  // On va chercher la liste des notes
  $dnotes = mysqli_fetch_array(query("  SELECT  nbdb_web_notes_admin.notes_admin  AS 'web_notes_global' ,
                                                nbdb_web_notes_admin.brouillon_fr AS 'web_notes_fr'     ,
                                                nbdb_web_notes_admin.brouillon_en AS 'web_notes_en'
                                        FROM    nbdb_web_notes_admin "));

  // Puis on les prépare pour l'affichage
  $web_notes_global = $dnotes['web_notes_global'];
  $web_notes_fr     = $dnotes['web_notes_fr'];
  $web_notes_en     = $dnotes['web_notes_en'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <h2 class="align_center">NBDB - Administration - Notes privées</h2>

      <br>
      <hr class="separateur_contenu">
      <br>

      <?php if(isset($_POST['web_notes_prev'])) { ?>

      <?php if($web_notes_fr_prev) { ?>

      <div class="texte align_justify">

        <br>
        <br>

        <h3 class="alinea texte_noir">
          Titre de l'article :
        </h3>

        <br>
        <br>

        <p>
          <?=$web_notes_fr_prev?>
        </p>

        <br>
        <br>

      </div>

      <hr class="separateur_contenu">

      <br>
      <br>

      <?php } if($web_notes_en_prev) { ?>

      <div class="texte align_justify">

        <br>
        <br>

        <h3 class="alinea texte_noir">
          Article title:
        </h3>

        <br>
        <br>

        <p>
          <?=$web_notes_en_prev?>
        </p>

        <br>
        <br>

      </div>

      <hr class="separateur_contenu">

      <br>
      <br>

      <?php } ?>
      <?php } ?>

      <div class="texte">

        <form method="POST">
          <fieldset>

            <label for="web_notes_global">Notes globales</label>
            <textarea id="web_notes_global" name="web_notes_global" class="indiv web_encyclo_edit_brouillon"><?=$web_notes_global?></textarea><br>
            <br>

            <label for="web_notes_fr">Brouillon français</label>
            <textarea id="web_notes_fr" name="web_notes_fr" class="indiv web_encyclo_edit_brouillon"><?=$web_notes_fr?></textarea><br>
            <br>

            <label for="web_notes_en">Brouillon anglais</label>
            <textarea id="web_notes_en" name="web_notes_en" class="indiv web_encyclo_edit_brouillon"><?=$web_notes_en?></textarea><br>
            <br>

            <input value="ENREGISTRER ET PRÉVISUALISER LES BROUILLONS" class="button button-outline" type="submit" name="web_notes_prev">
            &nbsp;
            <input value="ENREGISTRER LES NOTES PRIVÉES" type="submit" name="web_notes_edit">
          </fieldset>
        </form>

      </div>

      <br>
      <hr class="separateur_contenu">
      <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';