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
$css  = array('NBDB');
$js   = array('dynamique');




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
  $edit_web_titre_fr          = postdata_vide('web_titre_fr', 'string', '');
  $edit_web_titre_en          = postdata_vide('web_titre_en', 'string', '');
  $edit_web_redirection_fr    = postdata_vide('web_redirection_fr', 'string', '');
  $edit_web_redirection_en    = postdata_vide('web_redirection_en', 'string', '');
  $edit_web_titre_fr_raw      = (isset($_POST['web_titre_fr'])) ? $_POST['web_titre_fr'] : '';
  $edit_web_titre_en_raw      = (isset($_POST['web_titre_en'])) ? $_POST['web_titre_en'] : '';
  $edit_web_contenu_fr        = postdata_vide('web_definition_fr', 'string', '');
  $edit_web_contenu_en        = postdata_vide('web_definition_en', 'string', '');
  $edit_web_periode           = postdata_vide('web_periode', 'int', 0);
  $edit_web_apparition_y      = postdata_vide('web_apparition_y', 'int', 0);
  $edit_web_apparition_m      = postdata_vide('web_apparition_m', 'int', 0);
  $edit_web_popularisation_y  = postdata_vide('web_popularisation_y', 'int', 0);
  $edit_web_popularisation_m  = postdata_vide('web_popularisation_m', 'int', 0);
  $edit_web_vulgaire          = isset($_POST['web_vulgaire']) ? 1 : 0;
  $edit_web_politise          = isset($_POST['web_politise']) ? 1 : 0;
  $edit_web_incorrect         = isset($_POST['web_incorrect']) ? 1 : 0;
  $edit_web_activite          = isset($_POST['web_activite']) ? 1 : 0;
  $edit_web_irc               = isset($_POST['web_irc']) ? 1 : 0;

  // Création d'une entrée
  if(isset($_POST['web_add']))
  {
    // On ajoute la définition
    query(" INSERT INTO nbdb_web_page
            SET         nbdb_web_page.FKnbdb_web_periode    = '$edit_web_periode'           ,
                        nbdb_web_page.titre_fr              = '$edit_web_titre_fr'          ,
                        nbdb_web_page.titre_en              = '$edit_web_titre_en'          ,
                        nbdb_web_page.redirection_fr        = '$edit_web_redirection_fr'    ,
                        nbdb_web_page.redirection_en        = '$edit_web_redirection_en'    ,
                        nbdb_web_page.contenu_fr            = '$edit_web_contenu_fr'        ,
                        nbdb_web_page.contenu_en            = '$edit_web_contenu_en'        ,
                        nbdb_web_page.annee_apparition      = '$edit_web_apparition_y'      ,
                        nbdb_web_page.mois_apparition       = '$edit_web_apparition_m'      ,
                        nbdb_web_page.annee_popularisation  = '$edit_web_popularisation_y'  ,
                        nbdb_web_page.mois_popularisation   = '$edit_web_popularisation_m'  ,
                        nbdb_web_page.est_vulgaire          = '$edit_web_vulgaire'          ,
                        nbdb_web_page.est_politise          = '$edit_web_politise'          ,
                        nbdb_web_page.est_incorrect         = '$edit_web_incorrect'         ");

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
            SET     nbdb_web_page.FKnbdb_web_periode    = '$edit_web_periode'           ,
                    nbdb_web_page.titre_fr              = '$edit_web_titre_fr'          ,
                    nbdb_web_page.titre_en              = '$edit_web_titre_en'          ,
                    nbdb_web_page.redirection_fr        = '$edit_web_redirection_fr'    ,
                    nbdb_web_page.redirection_en        = '$edit_web_redirection_en'    ,
                    nbdb_web_page.contenu_fr            = '$edit_web_contenu_fr'        ,
                    nbdb_web_page.contenu_en            = '$edit_web_contenu_en'        ,
                    nbdb_web_page.annee_apparition      = '$edit_web_apparition_y'      ,
                    nbdb_web_page.mois_apparition       = '$edit_web_apparition_m'      ,
                    nbdb_web_page.annee_popularisation  = '$edit_web_popularisation_y'  ,
                    nbdb_web_page.mois_popularisation   = '$edit_web_popularisation_m'  ,
                    nbdb_web_page.est_vulgaire          = '$edit_web_vulgaire'          ,
                    nbdb_web_page.est_politise          = '$edit_web_politise'          ,
                    nbdb_web_page.est_incorrect         = '$edit_web_incorrect'
            WHERE   nbdb_web_page.id                    = '$edit_web_id'              ");

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

  // On supprime les catégories liées à la page
  query(" DELETE FROM nbdb_web_page_categorie
          WHERE       FKnbdb_web_page = '$edit_web_id' ");

  // On va chercher la liste de toutes les catégories
  $qcategories = query("  SELECT  nbdb_web_categorie.id AS 'c_id'
                          FROM    nbdb_web_categorie ");

  // On parcourt cette liste
  while($dcategories = mysqli_fetch_array($qcategories))
  {
    // On vérifie pour chaque entrée si elle est cochée - si oui, on la lie à la page qu'on vient de créer ou modifier
    $temp_categorie = $dcategories['c_id'];
    if(isset($_POST['web_categorie_'.$temp_categorie]))
      query(" INSERT INTO nbdb_web_page_categorie
              SET         nbdb_web_page_categorie.FKnbdb_web_page       = '$edit_web_id' ,
                          nbdb_web_page_categorie.FKnbdb_web_categorie  = '$temp_categorie' ");
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
  $web_id               = postdata($_GET['id'], 'int', 0);
  $web_titre_fr         = predata($_POST['web_titre_fr']);
  $web_titre_en         = predata($_POST['web_titre_en']);
  $web_redirect_fr      = predata($_POST['web_redirection_fr']);
  $web_redirect_en      = predata($_POST['web_redirection_en']);
  $web_contenu_fr       = $_POST['web_definition_fr'];
  $web_contenu_en       = $_POST['web_definition_en'];
  $web_definition_fr    = nbdbcode(bbcode(predata($_POST['web_definition_fr'], 1)));
  $web_definition_en    = nbdbcode(bbcode(predata($_POST['web_definition_en'], 1)));
  $web_periode          = $_POST['web_periode'];
  $web_apparition_y     = predata($_POST['web_apparition_y']);
  $web_apparition_m     = predata($_POST['web_apparition_m']);
  $web_popularisation_y = predata($_POST['web_popularisation_y']);
  $web_popularisation_m = predata($_POST['web_popularisation_m']);
  $web_vulgaire         = isset($_POST['web_vulgaire']) ? ' checked' : '';
  $web_politise         = isset($_POST['web_politise']) ? ' checked' : '';
  $web_incorrect        = isset($_POST['web_incorrect']) ? ' checked' : '';
  $web_activite         = isset($_POST['web_activite']) ? ' checked' : '';
  $web_irc              = isset($_POST['web_irc']) ? ' checked' : '';
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
  $dweb = mysqli_fetch_array(query("  SELECT  nbdb_web_page.FKnbdb_web_periode    AS 'w_periode'          ,
                                              nbdb_web_page.titre_fr              AS 'w_titre_fr'         ,
                                              nbdb_web_page.titre_en              AS 'w_titre_en'         ,
                                              nbdb_web_page.redirection_fr        AS 'w_redirect_fr'      ,
                                              nbdb_web_page.redirection_en        AS 'w_redirect_en'      ,
                                              nbdb_web_page.contenu_fr            AS 'w_contenu_fr'       ,
                                              nbdb_web_page.contenu_en            AS 'w_contenu_en'       ,
                                              nbdb_web_page.annee_apparition      AS 'w_apparition_y'     ,
                                              nbdb_web_page.mois_apparition       AS 'w_apparition_m'     ,
                                              nbdb_web_page.annee_popularisation  AS 'w_popularisation_y' ,
                                              nbdb_web_page.mois_popularisation   AS 'w_popularisation_m' ,
                                              nbdb_web_page.est_vulgaire          AS 'w_vulgaire'         ,
                                              nbdb_web_page.est_politise          AS 'w_politise'         ,
                                              nbdb_web_page.est_incorrect         AS 'w_incorrect'
                                      FROM    nbdb_web_page
                                      WHERE   nbdb_web_page.id = '$web_id' "));

  // On prépare tout ça pour l'affichage
  $web_periode          = $dweb['w_periode'];
  $web_titre_fr         = predata($dweb['w_titre_fr']);
  $web_titre_en         = predata($dweb['w_titre_en']);
  $web_redirect_fr      = predata($dweb['w_redirect_fr']);
  $web_redirect_en      = predata($dweb['w_redirect_en']);
  $web_contenu_fr       = $dweb['w_contenu_fr'];
  $web_contenu_en       = $dweb['w_contenu_en'];
  $web_apparition_y     = ($dweb['w_apparition_y']) ? $dweb['w_apparition_y'] : '';
  $web_apparition_m     = ($dweb['w_apparition_m']) ? $dweb['w_apparition_m'] : '';
  $web_popularisation_y = ($dweb['w_popularisation_y']) ? $dweb['w_popularisation_y'] : '';
  $web_popularisation_m = ($dweb['w_popularisation_m']) ? $dweb['w_popularisation_m'] : '';
  $web_vulgaire         = ($dweb['w_vulgaire']) ? ' checked' : '';
  $web_politise         = ($dweb['w_politise']) ? ' checked' : '';
  $web_incorrect        = ($dweb['w_incorrect']) ? ' checked' : '';
  $web_activite         = '';
  $web_irc              = '';
}

// Sinon, c'est un ajout de nouvelle définition, on se contente de laisser tous les champs vides
else
{
  $web_titre_fr         = '';
  $web_titre_en         = '';
  $web_redirect_fr      = '';
  $web_redirect_en      = '';
  $web_contenu_fr       = '';
  $web_contenu_en       = '';
  $web_apparition_y     = '';
  $web_apparition_m     = '';
  $web_popularisation_y = '';
  $web_popularisation_m = '';
  $web_popularisation   = '';
  $web_vulgaire         = '';
  $web_politise         = '';
  $web_incorrect        = '';
  $web_activite         = ' checked';
  $web_irc              = ' checked';
}

// On va aussi avoir besoin de l'URL de la page à appeler dynamiquement
$dynamique_url = (!isset($_GET['id'])) ? 'web_edit' : 'web_edit?id='.$web_id;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des catégories

// Si c'est une édition, on va chercher la liste des catégories auxquelles la page appartient
if(isset($_GET['id']))
{
  $qpagecategories = query("  SELECT  nbdb_web_page_categorie.FKnbdb_web_categorie AS 'pc_id'
                              FROM    nbdb_web_page_categorie
                              WHERE   nbdb_web_page_categorie.FKnbdb_web_page = '$web_id' ");

  // Et on colle toutes ces valeurs dans un tableau
  $page_categories = array();
  while($dpagecategories = mysqli_fetch_array($qpagecategories))
    array_push($page_categories, $dpagecategories['pc_id']);
}

// On va chercher les catégories
$qcategories = query("  SELECT    nbdb_web_categorie.id       AS 'c_id' ,
                                  nbdb_web_categorie.titre_fr AS 'c_titre'
                        FROM      nbdb_web_categorie
                        ORDER BY  nbdb_web_categorie.ordre_affichage ASC ");

// Puis on prépare les checkboxes
$check_categories = '';
while($dcategories = mysqli_fetch_array($qcategories))
{
  $temp_checked      = (isset($_GET['id']) && in_array($dcategories['c_id'], $page_categories)) ? ' checked' : '';
  $check_categories .= '<input id="web_categorie_'.$dcategories['c_id'].'" name="web_categorie_'.$dcategories['c_id'].'"" type="checkbox"'.$temp_checked.'>&nbsp;<label class="label-inline" for="web_categorie_'.$dcategories['c_id'].'">'.predata($dcategories['c_titre']).'</label><br>';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des périodes

// On va chercher les périodes
$qperiodes = query("  SELECT    nbdb_web_periode.id           AS 'p_id'     ,
                                nbdb_web_periode.titre_fr     AS 'p_titre'  ,
                                nbdb_web_periode.annee_debut  AS 'p_debut'  ,
                                nbdb_web_periode.annee_fin    AS 'p_fin'
                      FROM      nbdb_web_periode
                      ORDER BY  nbdb_web_periode.annee_debut  ASC ,
                                nbdb_web_periode.annee_fin    ASC ");

// On prépare le menu déroulant
$temp_selected    = (isset($_GET['id']) && !$web_periode) ? ' selected' : '';
$select_periodes  = '<option value="0"'.$temp_selected.'></option>';

// Et on remplit le menu déroulant
while($dperiodes = mysqli_fetch_array($qperiodes))
{
  $temp_selected    = (isset($_GET['id']) && $web_periode == $dperiodes['p_id']) ? ' selected' : '';
  $temp_annees      = ($dperiodes['p_debut']) ? $dperiodes['p_debut'].' - ' : 'XXXX - ';
  $temp_annees      = ($dperiodes['p_fin']) ? $temp_annees.$dperiodes['p_fin'] : $temp_annees.' XXXX';
  $select_periodes .= '<option value="'.$dperiodes['p_id'].'"'.$temp_selected.'>'.$temp_annees.' &nbsp; '.predata($dperiodes['p_titre']).'</option>';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

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

              <label>
                Catégories auxquelles laquelle la page appartient
                <a target="_blank" href="<?=$chemin?>pages/nbdb/web_categories_edit">
                  &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="18">
                </a>
                &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/recharger.svg" alt="R" height="18" onclick="dynamique('<?=$chemin?>', '<?=$dynamique_url?>', 'web_categories', 'reload_categories', 1);">
              </label>
              <div id="web_categories">
                <?php } if(!getxhr() || isset($_POST['reload_categories'])) { ?>
                <?=$check_categories?>
                <?php } if(!getxhr()) { ?>
              </div>
              <br>

              <div class="web_encyclo_periode_container">
                <label for="web_periode">
                  Période à laquelle la page appartient
                  <a target="_blank" href="<?=$chemin?>pages/nbdb/web_periodes_edit">
                    &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="18">
                  </a>
                  &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/recharger.svg" alt="R" height="18" onclick="dynamique('<?=$chemin?>', '<?=$dynamique_url?>', 'web_periode', 'reload_periodes', 1);">
                </label>
                <select id="web_periode" name="web_periode" class="indiv">
                  <?php } if(!getxhr() || isset($_POST['reload_periodes'])) { ?>
                  <?=$select_periodes?>
                <?php } if(!getxhr()) { ?>
                </select>
              </div>
              <br>

              <label for="web_apparition">Date d'apparition (mois/année)</label>
              <div class="flexcontainer web_encyclo_dates_container">
                <div style="flex:5">
                  <input id="web_apparition_m" name="web_apparition_m" class="indiv web_encyclo_dates" type="text" value="<?=$web_apparition_m?>">
                </div>
                <div style="flex:1">
                  &nbsp;
                </div>
                <div style="flex:5">
                <input id="web_apparition_y" name="web_apparition_y" class="indiv web_encyclo_dates" type="text" value="<?=$web_apparition_y?>">
                </div>
              </div>
              <br>

              <label for="web_apparition">Date de popularisation (mois/année)</label>
              <div class="flexcontainer web_encyclo_dates_container">
                <div style="flex:5">
                <input id="web_popularisation_m" name="web_popularisation_m" class="indiv web_encyclo_dates" type="text" value="<?=$web_popularisation_m?>">
                </div>
                <div style="flex:1">
                  &nbsp;
                </div>
                <div style="flex:5">
                  <input id="web_popularisation_y" name="web_popularisation_y" class="indiv web_encyclo_dates" type="text" value="<?=$web_popularisation_y?>">
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

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }
