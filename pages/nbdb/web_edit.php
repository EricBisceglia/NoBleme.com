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

// CSS
$css = array('NBDB');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout ou modification d'une entrée

if(isset($_POST['web_add']) || isset($_POST['web_edit']))
{
  // Assainissement du postdata
  $edit_web_titre_fr        = postdata_vide('web_titre_fr', 'string', '');
  $edit_web_titre_en        = postdata_vide('web_titre_en', 'string', '');
  $edit_web_redirection_fr  = postdata_vide('web_redirection_fr', 'string', '');
  $edit_web_redirection_en  = postdata_vide('web_redirection_en', 'string', '');
  $edit_web_titre_fr_raw    = (isset($_POST['web_titre_fr'])) ? $_POST['web_titre_fr'] : '';
  $edit_web_titre_en_raw    = (isset($_POST['web_titre_en'])) ? $_POST['web_titre_en'] : '';
  $edit_web_contenu_fr      = postdata_vide('web_definition_fr', 'string', '');
  $edit_web_contenu_en      = postdata_vide('web_definition_en', 'string', '');
  $edit_web_apparition      = ($_POST['web_apparition']) ? mysqldate(postdata_vide('web_apparition', 'string', '')) : '0000-00-00';
  $edit_web_popularisation  = ($_POST['web_popularisation']) ? mysqldate(postdata_vide('web_popularisation', 'string', '')) : '0000-00-00';
  $edit_web_vulgaire        = isset($_POST['web_vulgaire']) ? 1 : 0;
  $edit_web_politise        = isset($_POST['web_politise']) ? 1 : 0;
  $edit_web_incorrect       = isset($_POST['web_incorrect']) ? 1 : 0;
  $edit_web_activite        = isset($_POST['web_activite']) ? 1 : 0;
  $edit_web_irc             = isset($_POST['web_irc']) ? 1 : 0;

  // Création d'une entrée
  if(isset($_POST['web_add']))
  {
    // On ajoute la définition
    query(" INSERT INTO nbdb_web_page
            SET         nbdb_web_page.titre_fr            = '$edit_web_titre_fr'        ,
                        nbdb_web_page.titre_en            = '$edit_web_titre_en'        ,
                        nbdb_web_page.redirection_fr      = '$edit_web_redirection_fr'  ,
                        nbdb_web_page.redirection_en      = '$edit_web_redirection_en'  ,
                        nbdb_web_page.contenu_fr          = '$edit_web_contenu_fr'      ,
                        nbdb_web_page.contenu_en          = '$edit_web_contenu_en'      ,
                        nbdb_web_page.date_apparition     = '$edit_web_apparition'      ,
                        nbdb_web_page.date_popularisation = '$edit_web_popularisation'  ,
                        nbdb_web_page.est_vulgaire        = '$edit_web_vulgaire'        ,
                        nbdb_web_page.est_politise        = '$edit_web_politise'        ,
                        nbdb_web_page.est_incorrect       = '$edit_web_incorrect'       ");

    // On récupère l'ID
    $edit_web_id = mysqli_insert_id($db);

    // Activité récente
    if($edit_web_activite)
      activite_nouveau('nbdb_web_page_new', 0, 0, NULL, $edit_web_id, $edit_web_titre_fr, $edit_web_titre_en);

    // IRC
    if($edit_web_irc)
    {
      if($edit_web_titre_fr)
        ircbot($chemin, "Nouvelle entrée dans l'encyclopédie de la culture internet : ".$edit_web_titre_fr_raw." - ".$GLOBALS['url_site']."pages/nbdb/web?id=".$edit_web_id, "#NoBleme");
      if($edit_web_titre_en)
        ircbot($chemin, "New entry in the encyclopedia of internet culture : ".$edit_web_titre_en_raw." - ".$GLOBALS['url_site']."pages/nbdb/web?id=".$edit_web_id, "#english");
    }
  }

  // Modification d'une définition
  if(isset($_POST['web_edit']))
  {
    // On a besoin de l'ID
    $edit_web_id = postdata($_GET['id'], 'int', 0);

    // On modifie la définition
    query(" UPDATE  nbdb_web_page
            SET     nbdb_web_page.titre_fr            = '$edit_web_titre_fr'        ,
                    nbdb_web_page.titre_en            = '$edit_web_titre_en'        ,
                    nbdb_web_page.redirection_fr      = '$edit_web_redirection_fr'  ,
                    nbdb_web_page.redirection_en      = '$edit_web_redirection_en'  ,
                    nbdb_web_page.contenu_fr          = '$edit_web_contenu_fr'      ,
                    nbdb_web_page.contenu_en          = '$edit_web_contenu_en'      ,
                    nbdb_web_page.date_apparition     = '$edit_web_apparition'      ,
                    nbdb_web_page.date_popularisation = '$edit_web_popularisation'  ,
                    nbdb_web_page.est_vulgaire        = '$edit_web_vulgaire'        ,
                    nbdb_web_page.est_politise        = '$edit_web_politise'        ,
                    nbdb_web_page.est_incorrect       = '$edit_web_incorrect'
            WHERE   nbdb_web_page.id                  = '$edit_web_id'              ");

    // Activité récente
    if($edit_web_activite)
      activite_nouveau('nbdb_web_page_edit', 0, 0, NULL, $edit_web_id, $edit_web_titre_fr, $edit_web_titre_en);

    // IRC
    if($edit_web_irc)
    {
      if($edit_web_titre_fr)
        ircbot($chemin, "Une entrée de l'encyclopédie de la culture internet a été modifiée : ".$edit_web_titre_fr_raw." - ".$GLOBALS['url_site']."pages/nbdb/web?id=".$edit_web_id, "#NoBleme");
      if($edit_web_titre_en)
        ircbot($chemin, "An entry in the encyclopedia of internet culture has been modified : ".$edit_web_titre_en_raw." - ".$GLOBALS['url_site']."pages/nbdb/web?id=".$edit_web_id, "#english");
    }
  }

  // Redirection
  $temp_web_lang = ($lang == 'FR') ? $edit_web_titre_fr_raw : $edit_web_titre_en_raw;
  exit(header("Location: ".$chemin."pages/nbdb/web?page=".urlencode($temp_web_lang)));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu des champs du formulaire d'édition

// Si on fait une prévisualisation, on remet le contenu modifié dans les champs
if(isset($_POST['web_preview']))
{
  // Assainissement du postdata
  $web_titre_fr       = predata($_POST['web_titre_fr']);
  $web_titre_en       = predata($_POST['web_titre_en']);
  $web_redirect_fr    = predata($_POST['web_redirection_fr']);
  $web_redirect_en    = predata($_POST['web_redirection_en']);
  $web_contenu_fr     = $_POST['web_definition_fr'];
  $web_contenu_en     = $_POST['web_definition_en'];
  $web_definition_fr  = nbdbcode(bbcode(predata($_POST['web_definition_fr'], 1)));
  $web_definition_en  = nbdbcode(bbcode(predata($_POST['web_definition_en'], 1)));
  $web_apparition     = predata($_POST['web_apparition']);
  $web_popularisation = predata($_POST['web_popularisation']);
  $web_vulgaire       = isset($_POST['web_vulgaire']) ? ' checked' : '';
  $web_politise       = isset($_POST['web_politise']) ? ' checked' : '';
  $web_incorrect      = isset($_POST['web_incorrect']) ? ' checked' : '';
  $web_activite       = isset($_POST['web_activite']) ? ' checked' : '';
  $web_irc            = isset($_POST['web_irc']) ? ' checked' : '';
}

// Si on spécifie une définition déjà existante, on va chercher son contenu
else if(isset($_GET['id']))
{
  // On récupère et on assainit l'id
  $web_id = postdata($_GET['id'], 'int', 0);

  // Si l'id n'existe pas, on dégage
  if(!verifier_existence('nbdb_web_page', $web_id))
    exit(header("Location: ".$chemin."pages/nbdb/web"));

  // On va récupérer le contenu de la définition
  $dweb = mysqli_fetch_array(query("  SELECT  nbdb_web_page.titre_fr            AS 'w_titre_fr'       ,
                                              nbdb_web_page.titre_en            AS 'w_titre_en'       ,
                                              nbdb_web_page.redirection_fr      AS 'w_redirect_fr'    ,
                                              nbdb_web_page.redirection_en      AS 'w_redirect_en'    ,
                                              nbdb_web_page.contenu_fr          AS 'w_contenu_fr'     ,
                                              nbdb_web_page.contenu_en          AS 'w_contenu_en'     ,
                                              nbdb_web_page.date_apparition     AS 'w_apparition'     ,
                                              nbdb_web_page.date_popularisation AS 'w_popularisation' ,
                                              nbdb_web_page.est_vulgaire        AS 'w_vulgaire'       ,
                                              nbdb_web_page.est_politise        AS 'w_politise'       ,
                                              nbdb_web_page.est_incorrect       AS 'w_incorrect'
                                      FROM    nbdb_web_page
                                      WHERE   nbdb_web_page.id = '$web_id' "));

  // On prépare tout ça pour l'affichage
  $web_titre_fr       = predata($dweb['w_titre_fr']);
  $web_titre_en       = predata($dweb['w_titre_en']);
  $web_redirect_fr    = predata($dweb['w_redirect_fr']);
  $web_redirect_en    = predata($dweb['w_redirect_en']);
  $web_contenu_fr     = $dweb['w_contenu_fr'];
  $web_contenu_en     = $dweb['w_contenu_en'];
  $web_apparition     = ($dweb['w_apparition'] != '0000-00-00') ? date('d/m/y', strtotime($dweb['w_apparition'])) : '';
  $web_popularisation = ($dweb['w_popularisation'] != '0000-00-00') ? date('d/m/y', strtotime($dweb['w_popularisation'])) : '';
  $web_vulgaire       = ($dweb['w_vulgaire']) ? ' checked' : '';
  $web_politise       = ($dweb['w_politise']) ? ' checked' : '';
  $web_incorrect      = ($dweb['w_incorrect']) ? ' checked' : '';
  $web_activite       = '';
  $web_irc            = '';
}

// Sinon, c'est un ajout de nouvelle définition, on se contente de laisser tous les champs vides
else
{
  $web_titre_fr       = '';
  $web_titre_en       = '';
  $web_redirect_fr    = '';
  $web_redirect_en    = '';
  $web_contenu_fr     = '';
  $web_contenu_en     = '';
  $web_apparition     = '';
  $web_popularisation = '';
  $web_vulgaire       = '';
  $web_politise       = '';
  $web_incorrect      = '';
  $web_activite       = ' checked';
  $web_irc            = ' checked';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php if(!isset($_POST['web_preview'])) { ?>

      <div class="tableau2">

        <h1 class="align_center">Administration de l'encyclopédie de la culture web</h1>

        <?php } else { ?>

      <?php if($web_titre_fr) { ?>

      <div class="texte">

        <h3 class="alinea texte_noir">
          <?=$web_titre_fr?> :
        </h3>

        <p>
          <?=$web_definition_fr?>
        </p>

        <br>
        <br>

      </div>

      <hr class="separateur_contenu">

      <br>
      <br>

      <?php } if($web_titre_en) { ?>

      <div class="texte">

        <h3 class="alinea texte_noir">
          <?=$web_titre_en?>:
        </h3>

        <p>
          <?=$web_definition_en?>
        </p>

        <br>
        <br>

      </div>

      <hr class="separateur_contenu">

      <br>
      <br>

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

                <label for="web_titre_fr">Titre de l'article</label>
                <input id="web_titre_fr" name="web_titre_fr" class="indiv" type="text" value="<?=$web_titre_fr?>"><br>
                <br>

                <label for="web_redirection_fr">Redirection vers l'article (laisser le reste vide)</label>
                <input id="web_redirection_fr" name="web_redirection_fr" class="indiv" type="text" value="<?=$web_redirect_fr?>"><br>
                <br>

                <label for="web_definition_fr">Contenu de l'article (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_definition_fr" name="web_definition_fr" class="indiv web_encyclo_edit"><?=$web_contenu_fr?></textarea><br>

              </div>
              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:8" class="spaced">

                <h2 class="align_center souligne">ENGLISH</h2>

                <br>
                <br>

                <label for="web_titre_en">Titre de l'article</label>
                <input id="web_titre_en" name="web_titre_en" class="indiv" type="text" value="<?=$web_titre_en?>"><br>
                <br>

                <label for="web_redirection_en">Redirection vers l'article (laisser le reste vide)</label>
                <input id="web_redirection_en" name="web_redirection_en" class="indiv" type="text" value="<?=$web_redirect_en?>"><br>
                <br>

                <label for="web_definition_en">Contenu de l'article (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> + <a class="gras" href="<?=$chemin?>pages/doc/nbdbcodes">NBDBCodes</a>)</label>
                <textarea id="web_definition_en" name="web_definition_en" class="indiv web_encyclo_edit"><?=$web_contenu_en?></textarea><br>

              </div>
            </div>

            <br>
            <br>

            <div class="texte">

              <div class="flexcontainer web_encyclo_dates_container">
                <div style="flex:1">
                  <label for="web_apparition">Date d'apparition (d/m/y)</label>
                  <input id="web_apparition" name="web_apparition" class="indiv web_encyclo_dates" type="text" value="<?=$web_apparition?>">
                </div>
                <div style="flex:1">
                  <label for="web_popularisation">Date de popularisation</label>
                  <input id="web_popularisation" name="web_popularisation" class="indiv web_encyclo_dates" type="text" value="<?=$web_popularisation?>">
                </div>
              </div>
              <br>

              <label>Avertissements à afficher avant la définition</label>
              <input id="web_vulgaire" name="web_vulgaire" type="checkbox"<?=$web_vulgaire?>>
              <label class="label-inline" for="web_vulgaire">Vulgaire (NSFW)</label><br>
              <input id="web_politise" name="web_politise" type="checkbox"<?=$web_politise?>>
              <label class="label-inline" for="web_politise">Sujet politisé (parle de sujets de société sur lesquels tout le monde n'est pas d'accord)</label><br>
              <input id="web_incorrect" name="web_incorrect" type="checkbox"<?=$web_incorrect?>>
              <label class="label-inline" for="web_incorrect">Politiquement incorrect (terme dont l'usage est déconseillé)</label><br>
              <br>

              <?php if(isset($_GET['id'])) { ?>
              <label>Actions à effectuer au moment de la modification</label>
              <?php } else { ?>
              <label>Actions à effectuer au moment de l'ajout</label>
              <?php } ?>
              <input id="web_activite" name="web_activite" type="checkbox"<?=$web_activite?>>
              <label class="label-inline" for="web_activite">Entrée dans l'activité récente</label><br>
              <input id="web_irc" name="web_irc" type="checkbox"<?=$web_irc?>>
              <label class="label-inline" for="web_irc">Message du bot IRC NoBleme</label><br>
              <br>

              <input value="PRÉVISUALISER L'ARTICLE" type="submit" class="button button-outline" name="web_preview">
              &nbsp;
              <?php if(!isset($_GET['id'])) { ?>
              <input value="AJOUTER L'ARTICLE À L'ENCYCLOPÉDIE DU WEB" type="submit" name="web_add">
              <?php } else { ?>
              <input value="MODIFIER L'ARTICLE" type="submit" name="web_edit">
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
