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
// Ajout ou modification d'une définition

if(isset($_POST['web_dico_add']) || isset($_POST['web_dico_edit']))
{
  // Assainissement du postdata
  $edit_dico_titre_fr       = postdata_vide('web_dico_titre_fr', 'string', '');
  $edit_dico_titre_en       = postdata_vide('web_dico_titre_en', 'string', '');
  $edit_dico_redirection_fr = postdata_vide('web_dico_redirection_fr', 'string', '');
  $edit_dico_redirection_en = postdata_vide('web_dico_redirection_en', 'string', '');
  $edit_dico_titre_fr_raw   = (isset($_POST['web_dico_titre_fr'])) ? $_POST['web_dico_titre_fr'] : '';
  $edit_dico_titre_en_raw   = (isset($_POST['web_dico_titre_en'])) ? $_POST['web_dico_titre_en'] : '';
  $edit_dico_contenu_fr     = postdata_vide('web_dico_definition_fr', 'string', '');
  $edit_dico_contenu_en     = postdata_vide('web_dico_definition_en', 'string', '');
  $edit_dico_vulgaire       = isset($_POST['web_dico_vulgaire']) ? 1 : 0;
  $edit_dico_politise       = isset($_POST['web_dico_politise']) ? 1 : 0;
  $edit_dico_incorrect      = isset($_POST['web_dico_incorrect']) ? 1 : 0;
  $edit_dico_activite       = isset($_POST['web_dico_activite']) ? 1 : 0;
  $edit_dico_irc            = isset($_POST['web_dico_irc']) ? 1 : 0;

  // Ajout d'une définition
  if(isset($_POST['web_dico_add']))
  {
    // On ajoute la définition
    query(" INSERT INTO nbdb_web_definition
            SET         nbdb_web_definition.titre_fr        = '$edit_dico_titre_fr'       ,
                        nbdb_web_definition.titre_en        = '$edit_dico_titre_en'       ,
                        nbdb_web_definition.redirection_fr  = '$edit_dico_redirection_fr' ,
                        nbdb_web_definition.redirection_en  = '$edit_dico_redirection_en' ,
                        nbdb_web_definition.definition_fr   = '$edit_dico_contenu_fr'     ,
                        nbdb_web_definition.definition_en   = '$edit_dico_contenu_en'     ,
                        nbdb_web_definition.est_vulgaire    = '$edit_dico_vulgaire'       ,
                        nbdb_web_definition.est_politise    = '$edit_dico_politise'       ,
                        nbdb_web_definition.est_incorrect   = '$edit_dico_incorrect'      ");

    // On récupère l'ID
    $edit_dico_id = mysqli_insert_id($db);

    // Activité récente
    if($edit_dico_activite)
      activite_nouveau('nbdb_web_definition_new', 0, 0, NULL, $edit_dico_id, $edit_dico_titre_fr, $edit_dico_titre_en);

    // IRC
    if($edit_dico_irc)
    {
      if($edit_dico_titre_fr)
        ircbot($chemin, "Nouvelle entrée dans le dictionnaire de la culture internet : ".$edit_dico_titre_fr_raw." - ".$GLOBALS['url_site']."pages/nbdb/web_dictionnaire?id=".$edit_dico_id, "#NoBleme");
      if($edit_dico_titre_en)
        ircbot($chemin, "New entry in the dictionary of internet culture : ".$edit_dico_titre_en_raw." - ".$GLOBALS['url_site']."pages/nbdb/web_dictionnaire?id=".$edit_dico_id, "#english");
    }
  }

  // Modification d'une définition
  if(isset($_POST['web_dico_edit']))
  {
    // On a besoin de l'ID
    $edit_dico_id = postdata($_GET['id'], 'int', 0);

    // On modifie la définition
    query(" UPDATE  nbdb_web_definition
            SET     nbdb_web_definition.titre_fr        = '$edit_dico_titre_fr'       ,
                    nbdb_web_definition.titre_en        = '$edit_dico_titre_en'       ,
                    nbdb_web_definition.redirection_fr  = '$edit_dico_redirection_fr' ,
                    nbdb_web_definition.redirection_en  = '$edit_dico_redirection_en' ,
                    nbdb_web_definition.definition_fr   = '$edit_dico_contenu_fr'     ,
                    nbdb_web_definition.definition_en   = '$edit_dico_contenu_en'     ,
                    nbdb_web_definition.est_vulgaire    = '$edit_dico_vulgaire'       ,
                    nbdb_web_definition.est_politise    = '$edit_dico_politise'       ,
                    nbdb_web_definition.est_incorrect   = '$edit_dico_incorrect'
            WHERE   nbdb_web_definition.id              = '$edit_dico_id'             ");

    // Activité récente
    if($edit_dico_activite)
      activite_nouveau('nbdb_web_definition_edit', 0, 0, NULL, $edit_dico_id, $edit_dico_titre_fr, $edit_dico_titre_en);

    // IRC
    if($edit_dico_irc)
    {
      if($edit_dico_titre_fr)
        ircbot($chemin, "Une entrée du dictionnaire de la culture internet a été modifiée : ".$edit_dico_titre_fr_raw." - ".$GLOBALS['url_site']."pages/nbdb/web_dictionnaire?id=".$edit_dico_id, "#NoBleme");
      if($edit_dico_titre_en)
        ircbot($chemin, "An entry in the dictionary of internet culture has been modified : ".$edit_dico_titre_en_raw." - ".$GLOBALS['url_site']."pages/nbdb/web_dictionnaire?id=".$edit_dico_id, "#english");
    }
  }

  // Redirection
  $temp_dico_lang = ($lang == 'FR') ? $edit_dico_titre_fr_raw : $edit_dico_titre_en_raw;
  exit(header("Location: ".$chemin."pages/nbdb/web_dictionnaire?define=".urlencode($temp_dico_lang)));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu des champs du formulaire d'édition

// Si on fait une prévisualisation, on remet le contenu modifié dans les champs
if(isset($_POST['web_dico_preview']))
{
  // Assainissement du postdata
  $dico_titre_fr      = predata($_POST['web_dico_titre_fr']);
  $dico_titre_en      = predata($_POST['web_dico_titre_en']);
  $dico_redirect_fr   = predata($_POST['web_dico_redirection_fr']);
  $dico_redirect_en   = predata($_POST['web_dico_redirection_en']);
  $dico_contenu_fr    = $_POST['web_dico_definition_fr'];
  $dico_contenu_en    = $_POST['web_dico_definition_en'];
  $dico_definition_fr = nbdbcode(bbcode(predata($_POST['web_dico_definition_fr'], 1)));
  $dico_definition_en = nbdbcode(bbcode(predata($_POST['web_dico_definition_en'], 1)));
  $dico_vulgaire      = isset($_POST['web_dico_vulgaire']) ? ' checked' : '';
  $dico_politise      = isset($_POST['web_dico_politise']) ? ' checked' : '';
  $dico_incorrect     = isset($_POST['web_dico_incorrect']) ? ' checked' : '';
  $dico_activite      = isset($_POST['web_dico_activite']) ? ' checked' : '';
  $dico_irc           = isset($_POST['web_dico_irc']) ? ' checked' : '';
}

// Si on spécifie une définition déjà existante, on va chercher son contenu
else if(isset($_GET['id']))
{
  // On récupère et on assainit l'id
  $dico_id = postdata($_GET['id'], 'int', 0);

  // Si l'id n'existe pas, on dégage
  if(!verifier_existence('nbdb_web_definition', $dico_id))
    exit(header("Location: $chemin/pages/nbdb/web_dictionnaire"));

  // On va récupérer le contenu de la définition
  $ddico = mysqli_fetch_array(query(" SELECT  nbdb_web_definition.titre_fr        AS 'd_titre_fr'     ,
                                              nbdb_web_definition.titre_en        AS 'd_titre_en'     ,
                                              nbdb_web_definition.redirection_fr  AS 'd_redirect_fr'  ,
                                              nbdb_web_definition.redirection_en  AS 'd_redirect_en'  ,
                                              nbdb_web_definition.definition_fr   AS 'd_contenu_fr'   ,
                                              nbdb_web_definition.definition_en   AS 'd_contenu_en'   ,
                                              nbdb_web_definition.est_vulgaire    AS 'd_vulgaire'     ,
                                              nbdb_web_definition.est_politise    AS 'd_politise'     ,
                                              nbdb_web_definition.est_incorrect   AS 'd_incorrect'
                                      FROM    nbdb_web_definition
                                      WHERE   nbdb_web_definition.id = '$dico_id' "));

  // On prépare tout ça pour l'affichage
  $dico_titre_fr    = predata($ddico['d_titre_fr']);
  $dico_titre_en    = predata($ddico['d_titre_en']);
  $dico_redirect_fr = predata($ddico['d_redirect_fr']);
  $dico_redirect_en = predata($ddico['d_redirect_en']);
  $dico_contenu_fr  = $ddico['d_contenu_fr'];
  $dico_contenu_en  = $ddico['d_contenu_en'];
  $dico_vulgaire    = ($ddico['d_vulgaire']) ? ' checked' : '';
  $dico_politise    = ($ddico['d_politise']) ? ' checked' : '';
  $dico_incorrect   = ($ddico['d_incorrect']) ? ' checked' : '';
  $dico_activite    = '';
  $dico_irc         = '';
}

// Sinon, c'est un ajout de nouvelle définition, on se contente de laisser tous les champs vides
else
{
  $dico_titre_fr    = '';
  $dico_titre_en    = '';
  $dico_redirect_fr = '';
  $dico_redirect_en = '';
  $dico_contenu_fr  = '';
  $dico_contenu_en  = '';
  $dico_vulgaire    = '';
  $dico_politise    = '';
  $dico_incorrect   = '';
  $dico_activite    = ' checked';
  $dico_irc         = ' checked';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php if(!isset($_POST['web_dico_preview'])) { ?>

      <div class="tableau2">

        <h1 class="align_center">Administration du dictionnaire de la culture web</h1>

        <?php } else { ?>

      <?php if($dico_titre_fr) { ?>

      <div class="texte">

        <p class="alinea gros texte_noir souligne">
          <?=$dico_titre_fr?> :
        </p>

        <p>
          <?=$dico_definition_fr?>
        </p>

        <br>
        <br>

      </div>

      <hr class="separateur_contenu">

      <br>
      <br>

      <?php } if($dico_titre_en) { ?>

      <div class="texte">

        <p class="alinea gros texte_noir souligne">
          <?=$dico_titre_en?>:
        </p>

        <p>
          <?=$dico_definition_en?>
        </p>

        <br>
        <br>

      </div>

      <hr class="separateur_contenu">

      <?php } ?>

      <div class="tableau2">

        <?php } ?>

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
                <input id="web_dico_titre_fr" name="web_dico_titre_fr" class="indiv" type="text" value="<?=$dico_titre_fr?>"><br>
                <br>

                <label for="web_dico_redirection_fr">Redirection vers la définition (laisser le reste vide)</label>
                <input id="web_dico_redirection_fr" name="web_dico_redirection_fr" class="indiv" type="text" value="<?=$dico_redirect_fr?>"><br>
                <br>

                <label for="web_dico_definition_fr">Contenu de la définition (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_dico_definition_fr" name="web_dico_definition_fr" class="indiv web_dico_edit"><?=$dico_contenu_fr?></textarea><br>

              </div>
              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:8" class="spaced">

                <h2 class="align_center souligne">ENGLISH</h2>

                <br>
                <br>

                <label for="web_dico_titre_en">Titre de la définition</label>
                <input id="web_dico_titre_en" name="web_dico_titre_en" class="indiv" type="text" value="<?=$dico_titre_en?>"><br>
                <br>

                <label for="web_dico_redirection_en">Redirection vers la définition (laisser le reste vide)</label>
                <input id="web_dico_redirection_en" name="web_dico_redirection_en" class="indiv" type="text" value="<?=$dico_redirect_en?>"><br>
                <br>

                <label for="web_dico_definition_en">Contenu de la définition (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_dico_definition_en" name="web_dico_definition_en" class="indiv web_dico_edit"><?=$dico_contenu_en?></textarea><br>

              </div>
            </div>

            <br>
            <br>

            <div class="texte">

              <label>Avertissements à afficher avant la définition</label>
              <input id="web_dico_vulgaire" name="web_dico_vulgaire" type="checkbox"<?=$dico_vulgaire?>>
              <label class="label-inline" for="web_dico_vulgaire">Vulgaire (NSFW)</label><br>
              <input id="web_dico_politise" name="web_dico_politise" type="checkbox"<?=$dico_politise?>>
              <label class="label-inline" for="web_dico_politise">Sujet politisé (parle de sujets de société sur lesquels tout le monde n'est pas d'accord)</label><br>
              <input id="web_dico_incorrect" name="web_dico_incorrect" type="checkbox"<?=$dico_incorrect?>>
              <label class="label-inline" for="web_dico_incorrect">Politiquement incorrect (terme dont l'usage est déconseillé)</label><br>
              <br>

              <?php if(isset($_GET['id'])) { ?>
              <label>Actions à effectuer au moment de la modification</label>
              <?php } else { ?>
              <label>Actions à effectuer au moment de l'ajout</label>
              <?php } ?>
              <input id="web_dico_activite" name="web_dico_activite" type="checkbox"<?=$dico_activite?>>
              <label class="label-inline" for="web_dico_activite">Entrée dans l'activité récente</label><br>
              <input id="web_dico_irc" name="web_dico_irc" type="checkbox"<?=$dico_irc?>>
              <label class="label-inline" for="web_dico_irc">Message du bot IRC NoBleme</label><br>
              <br>

              <input value="PRÉVISUALISER LA DÉFINITION" type="submit" class="button button-outline" name="web_dico_preview">
              &nbsp;
              <?php if(!isset($_GET['id'])) { ?>
              <input value="AJOUTER LA DÉFINITION AU DICTIONNAIRE DU WEB" type="submit" name="web_dico_add">
              <?php } else { ?>
              <input value="MODIFIER LA DÉFINITION" type="submit" name="web_dico_edit">
              <?php } ?>

            </div>

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';
