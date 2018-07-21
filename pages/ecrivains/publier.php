<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php';   // Inclusions communes
include './../../inc/ecrivains.inc.php';  // Fonctions liées au coin des écrivains

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsPublier';

// Identification
$page_nom = "Publie un texte";
$page_url = "pages/ecrivains/publier";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Publier un texte";
$page_desc  = "Un lieu de partage public pour créations littéraires entre amateurs";

// CSS
$css = array('ecrivains');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Publier un texte

if(isset($_POST['publier_go']))
{
  // Assainissement du postdata
  $texte_concours = postdata_vide('publier_concours', 'int', 0);
  $texte_feedback = postdata_vide('publier_feedback', 'int', 2);
  $texte_titre    = isset($_POST['publier_titre']) ? postdata(tronquer_chaine($_POST['publier_titre'], 90)) : '';
  $texte_contenu  = postdata_vide('publier_contenu', 'string');
  $texte_anonyme  = (isset($_POST['publier_anonyme'])) ? 1 : 0;

  // Informations nécessaires pour publier le texte
  $texte_auteur   = $_SESSION['user'];
  $texte_creation = time();
  $texte_longueur = mb_strlen($texte_contenu, 'UTF-8');

  // On vérifie que le texte soit bien rempli
  $erreur = "";
  if(!$texte_longueur)
    $erreur = "Texte vide";
  if(!$texte_titre)
    $erreur = "Votre texte doit avoir un titre";

  // On vérifie que le concours choisi soit toujours ouvert
  $dconcours  = mysqli_fetch_array(query("  SELECT    ecrivains_concours.timestamp_fin AS 'c_fin'
                                            FROM      ecrivains_concours
                                            WHERE     ecrivains_concours.id = '$texte_concours' "));
  if($texte_concours && time() > $dconcours['c_fin'])
    $erreur = "La date limite du concours d'écriture choisi est dépassée";

  // Si on a pas d'erreur, on peut passer à la suite
  if(!$erreur)
  {
    // Publication du texte
    query(" INSERT INTO ecrivains_texte
            SET         ecrivains_texte.FKmembres               = '$texte_auteur'   ,
                        ecrivains_texte.FKecrivains_concours    = '$texte_concours' ,
                        ecrivains_texte.anonyme                 = '$texte_anonyme'  ,
                        ecrivains_texte.timestamp_creation      = '$texte_creation' ,
                        ecrivains_texte.timestamp_modification  = 0                 ,
                        ecrivains_texte.niveau_feedback         = '$texte_feedback' ,
                        ecrivains_texte.titre                   = '$texte_titre'    ,
                        ecrivains_texte.note_moyenne            = -1                ,
                        ecrivains_texte.longueur_texte          = '$texte_longueur' ,
                        ecrivains_texte.contenu                 = '$texte_contenu'  ");

    // Activité récente
    $texte_id   = mysqli_insert_id($db);
    $add_pseudo = ($texte_anonyme) ? 'Anonyme' : postdata(getpseudo(), 'string');
    activite_nouveau('ecrivains_new', 0, 0, $add_pseudo, $texte_id, $texte_titre);

    // Si le texte est une participation à un concours, en en recompte le nombre de textes
    if($texte_concours)
      ecrivains_concours_compter_textes($texte_concours);

    // Bot IRC
    $add_pseudo_raw = getpseudo();
    $add_titre_raw  = (isset($_POST['publier_titre'])) ? tronquer_chaine($_POST['publier_titre'], 80) : '';
    if(!$texte_anonyme)
    {
      ircbot($chemin, $add_pseudo_raw." a publié un nouveau texte dans le coin des écrivains : ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_id, "#NoBleme");
      ircbot($chemin, $add_pseudo_raw." a publié un nouveau texte dans le coin des écrivains : ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_id, "#write");
    }
    else
    {
      ircbot($chemin, "Un nouveau texte a été publié dans le coin des écrivains : ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_id, "#NoBleme");
      ircbot($chemin, "Un nouveau texte a été publié dans le coin des écrivains : ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_id, "#write");
    }

    // Redirection vers le texte
    exit(header("Location: ".$chemin."pages/ecrivains/texte?id=".$texte_id));
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des concours du coin des écrivains ouverts

// On va chercher les concours encore ouverts
$timestamp  = time();
$qconcours  = query(" SELECT    ecrivains_concours.id     AS 'c_id' ,
                                ecrivains_concours.titre  AS 'c_titre'
                      FROM      ecrivains_concours
                      WHERE     ecrivains_concours.timestamp_fin >= '$timestamp'
                      ORDER BY  ecrivains_concours.titre ASC ");

// Puis on les prépare pour le menu déroulant
$texte_concours   = postdata_vide('publier_concours', 'int', 2);
$temp_selected    = (!$texte_concours) ? ' selected' : '';
$select_concours  = '<option value="0"'.$temp_selected.'>Non, ce texte n\'est pas une participation à un concours</option>';
for($nconcours = 0; $dconcours = mysqli_fetch_array($qconcours); $nconcours++)
{
  $temp_selected    = ($texte_concours == $dconcours['c_id']) ? ' selected' : '';
  $select_concours .= '<option value="'.$dconcours['c_id'].'"'.$temp_selected.'>Participer au concours '.predata($dconcours['c_titre']).'</option>';
}






///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualiser un texte

// Si on demande une prévisualisation...
if(isset($_POST['publier_prev']) || isset($_POST['publier_go']))
{
  // On prépare le contenu des champs
  $texte_titre        = $_POST['publier_titre'];
  $texte_contenu      = $_POST['publier_contenu'];
  $texte_anonyme      = (isset($_POST['publier_anonyme'])) ? ' checked' : '';
  $texte_titre_prev   = predata($_POST['publier_titre']);
  $texte_contenu_prev = bbcode(predata($_POST['publier_contenu'], 1));
  $texte_auteur       = predata(getpseudo());
  $texte_creation     = predata(changer_casse(ilya(time()-1), 'min'));
}
else
{
  // Sinon, on met le contenu à zéro
  $texte_titre        = '';
  $texte_contenu      = '';
  $texte_anonyme      = '';
}

// Il faut aussi que le menu déroulant du feedback soit rempli
$texte_feedback   = postdata_vide('publier_feedback', 'int', 2);
$temp_selected    = ($texte_feedback == 2) ? ' selected' : '';
$select_feedback  = '<option value="2"'.$temp_selected.'">Je partage ce texte pour qu\'on y réagisse, je veux bien que les gens le notent et fassent savoir ce qu\'ils en pensent.</option>';
$temp_selected    = ($texte_feedback == 1) ? ' selected' : '';
$select_feedback .= '<option value="1"'.$temp_selected.'>Si quelqu\'un a quelque chose à dire sur mon texte, il peut le faire, mais uniquement par messages privés.</option>';
$temp_selected    = ($texte_feedback == 0) ? ' selected' : '';
$select_feedback .= '<option value="0"'.$temp_selected.'>Je ne veux aucun retour sur mon texte. Il est fait pour être lu, les réactions ne m\'intéressent pas.</option>';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Le coin des écrivains</h1>

        <h5>Publier un texte pour qu'il soit disponible publiquement</h5>

        <p>Le formulaire ci-dessous vous permet de publier un texte dans le <a class="gras" href="<?=$chemin?>pages/ecrivains/index">coin des écrivains</a> de NoBleme, le rendant publiquement visible. Vous pouvez publier n'importe quelle création littéraire ici, tant que vous en êtes l'auteur, et qu'elle respecte notre <a class="gras" href="<?=$chemin?>pages/doc/coc">code de conduite</a>.</p>

        <br>
        <br>

        <form method="POST" action="publier#publier_contenu">
          <fieldset>

            <?php if($nconcours) { ?>

            <label for="publier_concours">Ce texte est-il pour un <a href="<?=$chemin?>pages/ecrivains/concours_liste">concours du coin des écrivains</a></label>
            <select id="publier_concours" name="publier_concours" class="indiv">
              <?=$select_concours?>
            </select><br>
            <br>

            <?php } ?>

            <label for="publier_feedback">Niveau de retours que vous désirez</label>
            <select id="publier_feedback" name="publier_feedback" class="indiv">
              <?=$select_feedback?>
            </select><br>
            <br>

            <label for="publier_titre">Titre du texte (maximum 90 caractères)</label>
            <input id="publier_titre" name="publier_titre" class="indiv" type="text" value="<?=$texte_titre?>" maxlength="90"><br>
            <br>

            <label for="publier_contenu">Contenu du texte (vous pouvez utiliser des <a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> pour formater le texte)</label>
            <textarea id="publier_contenu" name="publier_contenu" class="indiv composer_texte"><?=$texte_contenu?></textarea><br>
            <br>

            <label>Publier ce texte anonymement (vous n'apparaitrez pas comme auteur du texte)</label>
            <input id="publier_anonyme" name="publier_anonyme" type="checkbox"<?=$texte_anonyme?>>
            <label class="label-inline" for="publier_anonyme">Je désire que ce texte soit publié anonymement (s'il gagne un <a class="gras" href="<?=$chemin?>pages/ecrivains/concours_liste">concours d'écriture</a>, il sera dé-anonymisé)</label><br>

            <?php if(isset($erreur)) { ?>
            <h4 class="align_center erreur texte_blanc">Erreur : <?=$erreur?></h4>
            <?php } ?>

            <br>
            <div class="flexcontainer">
              <div style="flex:1">
                <input class="button-outline" value="PRÉVISUALISER LE TEXTE AVANT DE LE PUBLIER" type="submit" name="publier_prev">
              </div>
              <div style="flex:1">
                <input value="PUBLIER LE TEXTE DANS LE COIN DES ÉCRIVAINS" type="submit" name="publier_go">
              </div>
            </div>

          </fieldset>
        </form>

      </div>

      <?php if(isset($_POST['publier_prev'])) { ?>

      <br>
      <br>
      <hr class="separateur_contenu">
      <br>

      <div class="texte">

        <h3>
          <?=$texte_titre_prev?>
        </h3>

        <h6>
          <?php if(!$texte_anonyme) { ?>
          Publié dans le <a>coin des écrivains</a> de NoBleme par <a><?=$texte_auteur?></a> <?=$texte_creation?>
          <?php } else { ?>
          Publié anonymement dans le <a>coin des écrivains</a> de NoBleme <?=$texte_creation?>
          <?php } ?>
        </h6>

        <br>

        <p>
          <?=$texte_contenu_prev?>
        </p>

      </div>

      <br>
      <br>
      <br>
      <hr class="separateur_contenu">

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';