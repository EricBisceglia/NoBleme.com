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
// Ajout ou modification d'une période

if(isset($_POST['periode_add']) || isset($_POST['periode_edit']))
{
  // On assainit le postdata
  $periode_edit_id              = postdata_vide('periode_id', 'int', 0);
  $periode_edit_titre_fr        = postdata_vide('periode_titre_fr', 'string', '');
  $periode_edit_titre_en        = postdata_vide('periode_titre_en', 'string', '');
  $periode_edit_description_fr  = postdata_vide('periode_description_fr', 'string', '');
  $periode_edit_description_en  = postdata_vide('periode_description_en', 'string', '');
  $periode_edit_debut           = postdata_vide('periode_debut', 'int', 0);
  $periode_edit_fin             = postdata_vide('periode_fin', 'int', 0);

  // Puis on crée la période
  if(isset($_POST['periode_add']))
    query(" INSERT INTO nbdb_web_periode
            SET         nbdb_web_periode.titre_fr       = '$periode_edit_titre_fr'        ,
                        nbdb_web_periode.titre_en       = '$periode_edit_titre_en'        ,
                        nbdb_web_periode.description_fr = '$periode_edit_description_fr'  ,
                        nbdb_web_periode.description_en = '$periode_edit_description_en'  ,
                        nbdb_web_periode.annee_debut    = '$periode_edit_debut'           ,
                        nbdb_web_periode.annee_fin      = '$periode_edit_fin'             ");

  // Ou on modifie la période
  if(isset($_POST['periode_edit']))
    query(" UPDATE  nbdb_web_periode
            SET     nbdb_web_periode.titre_fr       = '$periode_edit_titre_fr'        ,
                    nbdb_web_periode.titre_en       = '$periode_edit_titre_en'        ,
                    nbdb_web_periode.description_fr = '$periode_edit_description_fr'  ,
                    nbdb_web_periode.description_en = '$periode_edit_description_en'  ,
                    nbdb_web_periode.annee_debut    = '$periode_edit_debut'           ,
                    nbdb_web_periode.annee_fin      = '$periode_edit_fin'
            WHERE   nbdb_web_periode.id             = '$periode_edit_id'              ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une période

if(isset($_GET['delete']))
{
  // Assainissement du postdata
  $periode_delete_id = postdata($_GET['delete'], 'int', 0);

  // On vérifie s'il y a des pages liées à la période
  $qcheckpages = mysqli_fetch_array(query(" SELECT  COUNT(*) AS 'w_num'
                                            FROM    nbdb_web_page
                                            WHERE   nbdb_web_page.FKnbdb_web_periode = '$periode_delete_id' "));

  // S'il n'y en a pas, on peut supprimer la période
  if(!$qcheckpages['w_num'])
    query(" DELETE FROM nbdb_web_periode
            WHERE       nbdb_web_periode.id = '$periode_delete_id' ");

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
// Tableau des périodes

// On va chercher toutes les périodes
$qperiodes = query("  SELECT    nbdb_web_periode.id           AS 'p_id'       ,
                                nbdb_web_periode.titre_fr     AS 'p_titre_fr' ,
                                nbdb_web_periode.titre_en     AS 'p_titre_en' ,
                                nbdb_web_periode.annee_debut  AS 'p_debut'    ,
                                nbdb_web_periode.annee_fin    AS 'p_fin'
                      FROM      nbdb_web_periode
                      ORDER BY  nbdb_web_periode.annee_debut  ASC ,
                                nbdb_web_periode.annee_fin    ASC ");

// Et on les prépare pour l'affichage
for($nperiodes = 0 ; $dperiodes = mysqli_fetch_array($qperiodes) ; $nperiodes++)
{
  $periode_id[$nperiodes]       = $dperiodes['p_id'];
  $periode_titre_fr[$nperiodes] = predata($dperiodes['p_titre_fr']);
  $periode_titre_en[$nperiodes] = predata($dperiodes['p_titre_en']);
  $periode_debut[$nperiodes]    = ($dperiodes['p_debut']) ? $dperiodes['p_debut'] : '-';
  $periode_fin[$nperiodes]      = ($dperiodes['p_fin']) ? $dperiodes['p_fin'] : '-';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Période spécifique

if(isset($_GET['edit']))
{
  // Assainissement du postdata
  $periode_afficher_id = postdata($_GET['edit'], 'int', 0);

  // On continue seulement si la période existe
  if(verifier_existence('nbdb_web_periode', $periode_afficher_id))
  {
    // On va chercher les infos de la période
    $dperiode = mysqli_fetch_array(query("  SELECT  nbdb_web_periode.titre_fr       AS 'p_titre_fr' ,
                                                    nbdb_web_periode.titre_en       AS 'p_titre_en' ,
                                                    nbdb_web_periode.description_fr AS 'p_desc_fr'  ,
                                                    nbdb_web_periode.description_en AS 'p_desc_en'  ,
                                                    nbdb_web_periode.annee_debut    AS 'p_debut'    ,
                                                    nbdb_web_periode.annee_fin      AS 'p_fin'
                                            FROM    nbdb_web_periode
                                            WHERE   nbdb_web_periode.id = '$periode_afficher_id' "));

    // Et on les prépare pour l'affichage
    $periode_afficher_edit      = 1;
    $periode_afficher_titre_fr  = predata($dperiode['p_titre_fr']);
    $periode_afficher_titre_en  = predata($dperiode['p_titre_en']);
    $periode_afficher_desc_fr   = predata($dperiode['p_desc_fr']);
    $periode_afficher_desc_en   = predata($dperiode['p_desc_en']);
    $periode_afficher_debut     = $dperiode['p_debut'];
    $periode_afficher_fin       = $dperiode['p_fin'];
  }
}

// Si on n'a pas récupéré de période spécifique, on met les valeurs des champs à zéro
if(!isset($periode_afficher_edit))
{
  $periode_afficher_edit      = 0;
  $periode_afficher_titre_fr  = '';
  $periode_afficher_titre_en  = '';
  $periode_afficher_desc_fr   = '';
  $periode_afficher_desc_en   = '';
  $periode_afficher_debut     = '';
  $periode_afficher_fin       = '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h4 class="align_center">
          Encyclopédie de la culture internet : Périodes
          &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="26" onclick="toggle_row('periode_edit_form');">
        </h4>

        <br>
        <br>

        <?php if(isset($delete_impossible)) { ?>

        <h5 class="align_center negatif texte_blanc">IMPOSSIBLE DE SUPPRIMER LA PÉRIODE CAR <?=$delete_impossible?> PAGES LUI SONT LIÉES</h5>

        <br>
        <br>

        <?php } ?>

        <div id="periode_edit_form" class="hidden">

        <?php } ?>

          <form method="POST">
            <fieldset>

            <?php if($periode_afficher_edit) { ?>
            <input type="hidden" id="periode_id" name="periode_id" value="<?=$periode_afficher_id?>">
            <?php } ?>

              <div class="flexcontainer">
                <div style="flex:8">

                  <h4 class="align_center souligne">FRANÇAIS</h4>

                  <br>

                  <label for="periode_titre_fr">Nom de la période</label>
                  <input id="periode_titre_fr" name="periode_titre_fr" class="indiv" type="text" value="<?=$periode_afficher_titre_fr?>"><br>
                  <br>

                  <label for="periode_description_fr">Description (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                  <textarea id="periode_description_fr" name="periode_description_fr" class="indiv web_dico_edit"><?=$periode_afficher_desc_fr?></textarea>

                </div>

                <div style="flex:1">
                  &nbsp;
                </div>

                <div style="flex:8">

                  <h4 class="align_center souligne">ENGLISH</h4>

                  <br>

                  <label for="periode_titre_en">Nom de la période</label>
                  <input id="periode_titre_en" name="periode_titre_en" class="indiv" type="text" value="<?=$periode_afficher_titre_en?>"><br>
                  <br>

                  <label for="periode_description_en">Description (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                  <textarea id="periode_description_en" name="periode_description_en" class="indiv web_dico_edit"><?=$periode_afficher_desc_en?></textarea>

                </div>
              </div>

              <br>
              <label for="periode_debut">Année de début de la période</label>
              <input id="periode_debut" name="periode_debut" class="indiv" type="text" value="<?=$periode_afficher_debut?>"><br>
              <br>

              <label for="periode_fin">Année de fin de la période</label>
              <input id="periode_fin" name="periode_fin" class="indiv" type="text" value="<?=$periode_afficher_fin?>"><br>
              <br>

              <br>

              <?php if(!$periode_afficher_edit) { ?>
              <input value="AJOUTER LA PÉRIODE À L'ENCYCLOPÉDIE DU WEB" type="submit" name="periode_add">
              <?php } else { ?>
              <input value="MODIFIER LA PÉRIODE" type="submit" name="periode_edit">
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
                NOM DE LA PÉRIODE
              </th>
              <th>
                DÉBUT
              </th>
              <th>
                FIN
              </th>
              <th>
                ACTIONS
              </th>
            </tr>

          </thead>
          <tbody class="align_center">

            <?php for($i=0;$i<$nperiodes;$i++) { ?>

            <tr>
              <td class="texte_noir">
                <?=$periode_titre_fr[$i]?>
              </td>
              <td class="texte_noir bas_noir" rowspan="2">
                <?=$periode_debut[$i]?>
              </td>
              <td class="texte_noir bas_noir" rowspan="2">
                <?=$periode_fin[$i]?>
              </td>
              <td rowspan="2" class="bas_noir">
                <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="24" onclick="dynamique('<?=$chemin?>', 'web_periodes_edit?edit=<?=$periode_id[$i]?>', 'periode_edit_form', '', 1); toggle_oneway('periode_edit_form', 1);">
                &nbsp;
                <a href="<?=$chemin?>pages/nbdb/web_periodes_edit?delete=<?=$periode_id[$i]?>" onclick="return confirm('Confirmer la suppression définitive de la période');">
                  <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" height="24">
                </a>
              </td>
            </tr>
            <tr class="bas_noir">
              <td class="texte_noir">
                <?=$periode_titre_en[$i]?>
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