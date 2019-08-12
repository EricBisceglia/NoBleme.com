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
  $web_notes_global     = postdata_vide('web_notes_global', 'string', '');
  $web_notes_fr         = postdata_vide('web_notes_fr', 'string', '');
  $web_notes_en         = postdata_vide('web_notes_en', 'string', '');
  $web_template_global  = postdata_vide('web_template_global', 'string', '');
  $web_template_fr      = postdata_vide('web_template_fr', 'string', '');
  $web_template_en      = postdata_vide('web_template_en', 'string', '');

  // On supprime le contenu des notes
  query(" TRUNCATE nbdb_web_notes_admin ");

  // Mise à jour
  query(" INSERT INTO nbdb_web_notes_admin
          SET         nbdb_web_notes_admin.notes_admin      = '$web_notes_global'     ,
                      nbdb_web_notes_admin.brouillon_fr     = '$web_notes_fr'         ,
                      nbdb_web_notes_admin.brouillon_en     = '$web_notes_en'         ,
                      nbdb_web_notes_admin.template_global  = '$web_template_global'  ,
                      nbdb_web_notes_admin.template_fr      = '$web_template_fr'      ,
                      nbdb_web_notes_admin.template_en      = '$web_template_en'      ");

  // Préparation des prévisualisations
  $web_notes_global     = predata($_POST['web_notes_global']);
  $web_notes_fr         = predata($_POST['web_notes_fr']);
  $web_notes_en         = predata($_POST['web_notes_en']);
  $web_template_global  = predata($_POST['web_template_global']);
  $web_template_fr      = predata($_POST['web_template_fr']);
  $web_template_en      = predata($_POST['web_template_en']);
  $web_notes_fr_prev    = nbdbcode(bbcode(predata($_POST['web_notes_fr'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie('FR'), nbdb_web_liste_pages_dictionnaire('FR'));
  $web_notes_en_prev    = nbdbcode(bbcode(predata($_POST['web_notes_en'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie('FR'), nbdb_web_liste_pages_dictionnaire('FR'));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des notes globales

if(!isset($_POST['web_notes_prev']))
{
  // On va chercher la liste des notes
  $dnotes = mysqli_fetch_array(query("  SELECT  nbdb_web_notes_admin.notes_admin      AS 'web_notes_global'     ,
                                                nbdb_web_notes_admin.brouillon_fr     AS 'web_notes_fr'         ,
                                                nbdb_web_notes_admin.brouillon_en     AS 'web_notes_en'         ,
                                                nbdb_web_notes_admin.template_global  AS 'web_template_global'  ,
                                                nbdb_web_notes_admin.template_fr      AS 'web_template_fr'      ,
                                                nbdb_web_notes_admin.template_en      AS 'web_template_en'
                                        FROM    nbdb_web_notes_admin "));

  // Puis on les prépare pour l'affichage
  $web_notes_global     = predata($dnotes['web_notes_global']);
  $web_notes_fr         = predata($dnotes['web_notes_fr']);
  $web_notes_en         = predata($dnotes['web_notes_en']);
  $web_template_global  = predata($dnotes['web_template_global']);
  $web_template_fr      = predata($dnotes['web_template_fr']);
  $web_template_en      = predata($dnotes['web_template_en']);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des pages contenant des notes

// On va récupérer toutes les notes de l'encyclopédie
$qwebnotes = query("  SELECT    nbdb_web_page.id          AS 'web_page_id'  ,
                                nbdb_web_page.titre_fr    AS 'web_page_fr'  ,
                                nbdb_web_page.titre_en    AS 'web_page_en'  ,
                                nbdb_web_page.notes_admin AS 'web_notes'
                      FROM      nbdb_web_page
                      WHERE     nbdb_web_page.notes_admin != ''
                      ORDER BY  nbdb_web_page.titre_fr    ASC ");

// Puis on les prépare pour l'affichage
for($nwebnotes = 0; $dwebnotes = mysqli_fetch_array($qwebnotes); $nwebnotes++)
{
  $web_liste_notes_id[$nwebnotes]   = predata($dwebnotes['web_page_id']);
  $web_liste_notes_fr[$nwebnotes]   = predata($dwebnotes['web_page_fr']);
  $web_liste_notes_en[$nwebnotes]   = predata($dwebnotes['web_page_en']);
  $web_liste_notes_text[$nwebnotes] = bbcode(predata($dwebnotes['web_notes'], 1));
}

// On va récupérer toutes les notes du dictionnaire
$qdiconotes = query(" SELECT    nbdb_web_definition.id          AS 'dico_id'        ,
                                nbdb_web_definition.titre_fr    AS 'dico_titre_fr'  ,
                                nbdb_web_definition.titre_en    AS 'dico_titre_en'  ,
                                nbdb_web_definition.notes_admin AS 'dico_notes'
                      FROM      nbdb_web_definition
                      WHERE     nbdb_web_definition.notes_admin != ''
                      ORDER BY  nbdb_web_definition.titre_fr    ASC ");

// Puis on les prépare pour l'affichage
for($ndiconotes = 0; $ddiconotes = mysqli_fetch_array($qdiconotes); $ndiconotes++)
{
  $dico_liste_notes_id[$ndiconotes]   = predata($ddiconotes['dico_id']);
  $dico_liste_notes_fr[$ndiconotes]   = predata($ddiconotes['dico_titre_fr']);
  $dico_liste_notes_en[$ndiconotes]   = predata($ddiconotes['dico_titre_en']);
  $dico_liste_notes_text[$ndiconotes] = bbcode(predata($ddiconotes['dico_notes'], 1));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <h2 class="align_center">
        NBDB - Administration - Notes privées
        <a href="<?=$chemin?>pages/nbdb/web_images">
          &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/upload.svg" alt="+" height="30">
        </a>
      </h2>

      <br>
      <hr class="separateur_contenu">
      <br>

      <div class="tableau">

        <form method="POST">
          <fieldset>

            <div class="flexcontainer">
              <div style="flex:12">

                <label for="web_notes_global">Notes globales</label>
                <textarea id="web_notes_global" name="web_notes_global" class="indiv web_encyclo_edit_note"><?=$web_notes_global?></textarea><br>
                <br>

                <label for="web_notes_en">Brouillon anglais (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_notes_en" name="web_notes_en" class="indiv web_encyclo_edit_brouillon"><?=$web_notes_en?></textarea><br>
                <br>

                <label for="web_notes_fr">Brouillon français (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_notes_fr" name="web_notes_fr" class="indiv web_encyclo_edit_brouillon"><?=$web_notes_fr?></textarea><br>
                <br>

              </div>
              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:4">

                <label for="web_template_global">Snippets utiles</label>
                <textarea id="web_template_global" name="web_template_global" class="indiv web_encyclo_edit_note"><?=$web_template_global?></textarea><br>
                <br>

                <label for="web_template_en">Template anglais</label>
                <textarea id="web_template_en" name="web_template_en" class="indiv web_encyclo_edit_brouillon"><?=$web_template_en?></textarea><br>
                <br>

                <label for="web_template_fr">Template français</label>
                <textarea id="web_template_fr" name="web_template_fr" class="indiv web_encyclo_edit_brouillon"><?=$web_template_fr?></textarea><br>
                <br>

              </div>
            </div>

            <input value="ENREGISTRER ET PRÉVISUALISER LES BROUILLONS" class="button button-outline" type="submit" name="web_notes_prev">
            &nbsp;
            <input value="ENREGISTRER LES NOTES PRIVÉES" type="submit" name="web_notes_edit">

          </fieldset>
        </form>

      </div>

      <br>
      <br>
      <hr class="separateur_contenu">
      <br>
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

      <div class="tableau">

        <table class="grid titresnoirs altc">
          <thead>

            <tr class="moinsgros gras">
              <th>
                PAGE
              </th>
              <th>
                NOTES
              </th>
            </tr>

          </thead>
          <tbody>

            <?php for($i=0;$i<$nwebnotes;$i++) { ?>

              <tr>

                <td class="gras align_center">
                  <a href="<?=$chemin?>pages/nbdb/web_edit?id=<?=$web_liste_notes_id[$i]?>"><?=$web_liste_notes_fr[$i]?></a>
                  <?php if($web_liste_notes_fr[$i] && $web_liste_notes_en[$i]) { ?>
                  <br>
                  <?php } if($web_liste_notes_fr[$i] != $web_liste_notes_en[$i]) { ?>
                  <a href="<?=$chemin?>pages/nbdb/web_edit?id=<?=$web_liste_notes_id[$i]?>"><?=$web_liste_notes_en[$i]?></a>
                  <?php } ?>
                </td>

                <td class="spaced">
                  <?=$web_liste_notes_text[$i]?>
                </td>

              </tr>

              <?php } for($i=0;$i<$ndiconotes;$i++) { ?>

              <tr>

                <td class="gras align_center">
                  <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_edit?id=<?=$dico_liste_notes_id[$i]?>"><?=$dico_liste_notes_fr[$i]?></a>
                  <?php if($dico_liste_notes_fr[$i] && $dico_liste_notes_en[$i]) { ?>
                  <br>
                  <?php } if($dico_liste_notes_fr[$i] != $dico_liste_notes_en[$i]) { ?>
                  <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_edit?id=<?=$dico_liste_notes_id[$i]?>"><?=$dico_liste_notes_en[$i]?></a>
                  <?php } ?>
                </td>

                <td class="spaced">
                  <?=$dico_liste_notes_text[$i]?>
                </td>

              </tr>

            <?php } ?>

          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';