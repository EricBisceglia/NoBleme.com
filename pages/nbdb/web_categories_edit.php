<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

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

// CSS & JS
$css  = array('nbdb');
$js   = array('dynamique', 'toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout ou modification d'une catégorie

if(isset($_POST['categorie_add']) || isset($_POST['categorie_edit']))
{
  // On assainit le postdata
  $categorie_edit_id              = postdata_vide('categorie_id', 'int', 0);
  $categorie_edit_titre_fr        = postdata_vide('categorie_titre_fr', 'string', '');
  $categorie_edit_titre_en        = postdata_vide('categorie_titre_en', 'string', '');
  $categorie_edit_description_fr  = postdata_vide('categorie_description_fr', 'string', '');
  $categorie_edit_description_en  = postdata_vide('categorie_description_en', 'string', '');
  $categorie_edit_ordre           = postdata_vide('categorie_ordre', 'int', 0);

  // Puis on crée la catégorie
  if(isset($_POST['categorie_add']))
    query(" INSERT INTO nbdb_web_categorie
            SET         nbdb_web_categorie.titre_fr         = '$categorie_edit_titre_fr'        ,
                        nbdb_web_categorie.titre_en         = '$categorie_edit_titre_en'        ,
                        nbdb_web_categorie.ordre_affichage  = '$categorie_edit_ordre'           ,
                        nbdb_web_categorie.description_fr   = '$categorie_edit_description_fr'  ,
                        nbdb_web_categorie.description_en   = '$categorie_edit_description_en'  ");

  // Ou on modifie la catégorie
  if(isset($_POST['categorie_edit']))
    query(" UPDATE  nbdb_web_categorie
            SET     nbdb_web_categorie.titre_fr         = '$categorie_edit_titre_fr'        ,
                    nbdb_web_categorie.titre_en         = '$categorie_edit_titre_en'        ,
                    nbdb_web_categorie.ordre_affichage  = '$categorie_edit_ordre'           ,
                    nbdb_web_categorie.description_fr   = '$categorie_edit_description_fr'  ,
                    nbdb_web_categorie.description_en   = '$categorie_edit_description_en'
            WHERE   nbdb_web_categorie.id               = '$categorie_edit_id'              ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une catégorie

if(isset($_GET['delete']))
{
  // Assainissement du postdata
  $categorie_delete_id = postdata($_GET['delete'], 'int', 0);

  // On vérifie s'il y a des pages liées à la catégorie
  $qcheckpages = mysqli_fetch_array(query(" SELECT  COUNT(*) AS 'w_num'
                                            FROM    nbdb_web_page_categorie
                                            WHERE   nbdb_web_page_categorie.FKnbdb_web_categorie = '$categorie_delete_id' "));

  // S'il n'y en a pas, on peut supprimer la catégorie
  if(!$qcheckpages['w_num'])
    query(" DELETE FROM nbdb_web_categorie
            WHERE       nbdb_web_categorie.id = '$categorie_delete_id' ");

  // Sinon, on affiche un message d'erreur
  else
    $delete_impossible = $qcheckpages['w_num'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tableau des catégories

// On va chercher toutes les catégories
$qcategories = query("  SELECT    nbdb_web_categorie.id               AS 'c_id'       ,
                                  nbdb_web_categorie.titre_fr         AS 'c_titre_fr' ,
                                  nbdb_web_categorie.titre_en         AS 'c_titre_en' ,
                                  nbdb_web_categorie.ordre_affichage  AS 'c_ordre'
                        FROM      nbdb_web_categorie
                        ORDER BY  nbdb_web_categorie.ordre_affichage  ASC  ,
                                  nbdb_web_categorie.titre_fr         ASC ");

// Et on les prépare pour l'affichage
for($ncategories = 0 ; $dcategories = mysqli_fetch_array($qcategories) ; $ncategories++)
{
  $categorie_id[$ncategories]       = $dcategories['c_id'];
  $categorie_titre_fr[$ncategories] = predata($dcategories['c_titre_fr']);
  $categorie_titre_en[$ncategories] = predata($dcategories['c_titre_en']);
  $categorie_ordre[$ncategories]    = $dcategories['c_ordre'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Catégorie spécifique

if(isset($_GET['edit']))
{
  // Assainissement du postdata
  $categorie_afficher_id = postdata($_GET['edit'], 'int', 0);

  // On continue seulement si la catégorie existe
  if(verifier_existence('nbdb_web_categorie', $categorie_afficher_id))
  {
    // On va chercher les infos de la catégorie
    $dcategorie = mysqli_fetch_array(query("  SELECT  nbdb_web_categorie.titre_fr         AS 'c_titre_fr' ,
                                                      nbdb_web_categorie.titre_en         AS 'c_titre_en' ,
                                                      nbdb_web_categorie.ordre_affichage  AS 'c_ordre'    ,
                                                      nbdb_web_categorie.description_fr   AS 'c_desc_fr'  ,
                                                      nbdb_web_categorie.description_en   AS 'c_desc_en'
                                              FROM    nbdb_web_categorie
                                              WHERE   nbdb_web_categorie.id = '$categorie_afficher_id' "));

    // Et on les prépare pour l'affichage
    $categorie_afficher_edit      = 1;
    $categorie_afficher_titre_fr  = predata($dcategorie['c_titre_fr']);
    $categorie_afficher_titre_en  = predata($dcategorie['c_titre_en']);
    $categorie_afficher_desc_fr   = predata($dcategorie['c_desc_fr']);
    $categorie_afficher_desc_en   = predata($dcategorie['c_desc_en']);
    $categorie_afficher_ordre     = $dcategorie['c_ordre'];
  }
}

// Si on n'a pas récupéré de catégorie spécifique, on met les valeurs des champs à zéro
if(!isset($categorie_afficher_edit))
{
  $categorie_afficher_edit      = 0;
  $categorie_afficher_titre_fr  = '';
  $categorie_afficher_titre_en  = '';
  $categorie_afficher_desc_fr   = '';
  $categorie_afficher_desc_en   = '';
  $categorie_afficher_ordre     = '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte align_justify">

        <h4 class="align_center">
          Encyclopédie de la culture internet : Catégories
          &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="26" onclick="toggle_row('categorie_edit_form');">
        </h4>

        <br>
        <br>

        <?php if(isset($delete_impossible)) { ?>

        <h5 class="align_center negatif texte_blanc">IMPOSSIBLE DE SUPPRIMER LA CATÉGORIE CAR <?=$delete_impossible?> PAGES LUI SONT LIÉES</h5>

        <br>
        <br>

        <?php } ?>

        <div id="categorie_edit_form" class="hidden">

        <?php } ?>

          <form method="POST">
            <fieldset>

            <?php if($categorie_afficher_edit) { ?>
            <input type="hidden" id="categorie_id" name="categorie_id" value="<?=$categorie_afficher_id?>">
            <?php } ?>

              <div class="flexcontainer">
                <div style="flex:8">

                  <h4 class="align_center souligne">FRANÇAIS</h4>

                  <br>

                  <label for="categorie_titre_fr">Nom de la catégorie</label>
                  <input id="categorie_titre_fr" name="categorie_titre_fr" class="indiv" type="text" value="<?=$categorie_afficher_titre_fr?>"><br>
                  <br>

                  <label for="categorie_description_fr">Description (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                  <textarea id="categorie_description_fr" name="categorie_description_fr" class="indiv web_dico_edit"><?=$categorie_afficher_desc_fr?></textarea>

                </div>

                <div style="flex:1">
                  &nbsp;
                </div>

                <div style="flex:8">

                  <h4 class="align_center souligne">ENGLISH</h4>

                  <br>

                  <label for="categorie_titre_en">Nom de la catégorie</label>
                  <input id="categorie_titre_en" name="categorie_titre_en" class="indiv" type="text" value="<?=$categorie_afficher_titre_en?>"><br>
                  <br>

                  <label for="categorie_description_en">Description (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                  <textarea id="categorie_description_en" name="categorie_description_en" class="indiv web_dico_edit"><?=$categorie_afficher_desc_en?></textarea>

                </div>
              </div>

              <br>
              <label for="categorie_ordre">Ordre de classement de la catégorie</label>
              <input id="categorie_ordre" name="categorie_ordre" class="indiv" type="text" value="<?=$categorie_afficher_ordre?>"><br>
              <br>

              <br>

              <?php if(!$categorie_afficher_edit) { ?>
              <input value="AJOUTER LA CATÉGORIE À L'ENCYCLOPÉDIE DU WEB" type="submit" name="categorie_add">
              <?php } else { ?>
              <input value="MODIFIER LA CATÉGORIE" type="submit" name="categorie_edit">
              <?php } ?>

            </fieldset>
          </form>

          <br>
          <br>
          <br>

          <?php if(!getxhr()) { ?>

        </div>

        <table class="fullgrid titresnoirs">
          <thead>

            <tr class="bas_noir">
              <th>
                ORDRE
              </th>
              <th>
                NOM DE LA CATÉGORIE
              </th>
              <th>
                ACTIONS
              </th>
            </tr>

          </thead>
          <tbody class="align_center">

            <?php for($i=0;$i<$ncategories;$i++) { ?>

            <tr>
            <td class="texte_noir bas_noir" rowspan="2">
                <?=$categorie_ordre[$i]?>
              </td>
              <td class="texte_noir">
                <?=$categorie_titre_fr[$i]?>
              </td>
              <td rowspan="2" class="bas_noir">
                <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="24" onclick="dynamique('<?=$chemin?>', 'web_categories_edit?edit=<?=$categorie_id[$i]?>', 'categorie_edit_form', '', 1); toggle_oneway('categorie_edit_form', 1);">
                &nbsp;
                <a href="<?=$chemin?>pages/nbdb/web_categories_edit?delete=<?=$categorie_id[$i]?>" onclick="return confirm('Confirmer la suppression définitive de la catégorie');">
                  <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" height="24">
                </a>
              </td>
            </tr>
            <tr class="bas_noir">
              <td class="texte_noir">
                <?=$categorie_titre_en[$i]?>
              </td>
            </tr>

            <?php } ?>

          </tbody>
        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }