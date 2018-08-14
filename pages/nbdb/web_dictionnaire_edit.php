<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBDicoWeb';

// Identification
$page_nom = "Administre la NBDB";
$page_url = "pages/nbdb/index";

// Langues disponibles
$langue_page = array('FR');

// Titre
$page_titre = "NBDB : Administration";

// CSS
$css = array('NBDB');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'une nouvelle définition

if(isset($_POST['web_dico_add']))
{
  // Assainissement du postdata
  $add_dico_titre_fr      = postdata_vide('web_dico_titre_fr', 'string', '');
  $add_dico_titre_en      = postdata_vide('web_dico_titre_en', 'string', '');
  $add_dico_titre_fr_raw  = (isset($_POST['web_dico_titre_fr'])) ? $_POST['web_dico_titre_fr'] : '';
  $add_dico_titre_en_raw  = (isset($_POST['web_dico_titre_en'])) ? $_POST['web_dico_titre_en'] : '';
  $add_dico_contenu_fr    = postdata_vide('web_dico_definition_fr', 'string', '');
  $add_dico_contenu_en    = postdata_vide('web_dico_definition_en', 'string', '');

  // Ajout de la définition dans le dictionnaire
  query(" INSERT INTO nbdb_web_definition
          SET         nbdb_web_definition.titre_fr      = '$add_dico_titre_fr'    ,
                      nbdb_web_definition.titre_en      = '$add_dico_titre_en'    ,
                      nbdb_web_definition.definition_fr = '$add_dico_contenu_fr'  ,
                      nbdb_web_definition.definition_en = '$add_dico_contenu_en'  ");

  // Redirection
  $add_dico_id    = mysqli_insert_id($db);
  $temp_dico_lang = ($lang == 'FR') ? $add_dico_titre_fr_raw : $add_dico_titre_en_raw;
  exit(header("Location: ".$chemin."pages/nbdb/web_dictionnaire?define=".urlencode($temp_dico_lang)));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="tableau2">

        <h1 class="align_center">Administration du dictionnaire de la culture web</h1>

        <br>
        <br>

        <form method="POST">
          <fieldset>

            <div class="flexcontainer">
              <div style="flex:8" class="spaced">

                <h2 class="align_center souligne">FRANÇAIS</h2>

                <br>
                <br>

                <label for="web_dico_titre_fr">Titre de la définition</label>
                <input id="web_dico_titre_fr" name="web_dico_titre_fr" class="indiv" type="text"><br>
                <br>

                <label for="web_dico_definition_fr">Contenu de la définition (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_dico_definition_fr" name="web_dico_definition_fr" class="indiv web_dico_edit"></textarea><br>

              </div>
              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:8" class="spaced">

                <h2 class="align_center souligne">ENGLISH</h2>

                <br>
                <br>

                <label for="web_dico_titre_en">Titre de la définition</label>
                <input id="web_dico_titre_en" name="web_dico_titre_en" class="indiv" type="text"><br>
                <br>

                <label for="web_dico_definition_en">Contenu de la définition (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_dico_definition_en" name="web_dico_definition_en" class="indiv web_dico_edit"></textarea><br>

              </div>
            </div>

            <br>
            <br>

            <div class="texte">

              <label>Avertissements à afficher avant la définition</label>
              <input id="web_dico_vulgaire" name="web_dico_vulgaire" type="checkbox">
              <label class="label-inline" for="web_dico_vulgaire">Vulgaire (NSFW)</label><br>
              <input id="web_dico_politique" name="web_dico_politique" type="checkbox">
              <label class="label-inline" for="web_dico_politique">Sujet politisé (parle de sujets de société sur lesquels tout le monde n'est pas d'accord)</label><br>
              <input id="web_dico_incorrect" name="web_dico_incorrect" type="checkbox">
              <label class="label-inline" for="web_dico_incorrect">Politiquement incorrect (terme dont l'usage est déconseillé)</label><br>
              <br>

              <label>Actions à effectuer au moment de l'ajout</label>
              <input id="web_dico_activite" name="web_dico_activite" type="checkbox" checked>
              <label class="label-inline" for="web_dico_activite">Entrée dans l'activité récente</label><br>
              <input id="web_dico_irc" name="web_dico_irc" type="checkbox" checked>
              <label class="label-inline" for="web_dico_irc">Message du bot IRC NoBleme</label><br>
              <br>

              <input value="PRÉVISUALISER LA DÉFINITION" type="submit" class="button button-outline" name="web_dico_preview">
              &nbsp;
              <input value="AJOUTER LA DÉFINITION AU DICTIONNAIRE DU WEB" type="submit" name="web_dico_add">

            </div>

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';
