<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

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
  $texte_feedback = postdata($_POST['publier_feedback']);
  $texte_titre    = postdata(tronquer_chaine($_POST['publier_titre'], 90));
  $texte_contenu  = postdata($_POST['publier_contenu']);

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

  // Si on a pas d'erreur, on peut passer à la suite
  if(!$erreur)
  {
    // Publication du texte
    query(" INSERT INTO ecrivains_texte
            SET         ecrivains_texte.FKmembres               = '$texte_auteur'   ,
                        ecrivains_texte.FKecrivains_concours    = 0                 ,
                        ecrivains_texte.timestamp_creation      = '$texte_creation' ,
                        ecrivains_texte.timestamp_modification  = 0                 ,
                        ecrivains_texte.niveau_feedback         = '$texte_feedback' ,
                        ecrivains_texte.titre                   = '$texte_titre'    ,
                        ecrivains_texte.note_moyenne            = -1                ,
                        ecrivains_texte.longueur_texte          = '$texte_longueur' ,
                        ecrivains_texte.contenu                 = '$texte_contenu'  ");

    // Activité récente
    $texte_id   = mysqli_insert_id($db);
    $add_pseudo = postdata(getpseudo(), 'string');
    query(" INSERT INTO activite
            SET         activite.timestamp      = '$texte_creation' ,
                        activite.pseudonyme     = '$add_pseudo'     ,
                        activite.action_type    = 'ecrivains_new'   ,
                        activite.action_id      = '$texte_id'       ,
                        activite.action_titre   = '$texte_titre'    ");

    // Bot IRC
    $add_pseudo_raw = getpseudo();
    $add_titre_raw  = (isset($_POST['publier_titre'])) ? tronquer_chaine($_POST['publier_titre'], 80) : '';
    ircbot($chemin, $add_pseudo_raw." a publié un nouveau texte dans le coin des écrivains : ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_id, "#NoBleme");

    // Redirection vers le texte
    exit(header("Location: ".$chemin."pages/ecrivains/texte?id=".$texte_id));
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualiser un texte

if(isset($_POST['publier_prev']) || isset($_POST['publier_go']))
{
  // On prépare le contenu des champs
  $texte_titre    = $_POST['publier_titre'];
  $texte_contenu  = $_POST['publier_contenu'];
}
else
{
  // Sinon, on met le contenu à zéro
  $texte_titre    = '';
  $texte_contenu  = '';
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

      <div class="texte">

        <h1>Le coin des écrivains</h1>

        <h5>Publier un texte pour qu'il soit disponible publiquement</h5>

        <p>Le formulaire ci-dessous vous permet de publier un texte dans le <a class="gras" href="<?=$chemin?>pages/ecrivains/index">coin des écrivains</a> de NoBleme, le rendant publiquement visible. Vous pouvez publier n'importe quelle création littéraire ici, tant que vous en êtes l'auteur, et qu'elle respecte notre <a class="gras" href="<?=$chemin?>pages/doc/coc">code de conduite</a>.</p>

        <br>
        <br>

        <form method="POST">
          <fieldset>

            <label for="publier_feedback">Niveau de retours que vous désirez</label>
            <select id="publier_feedback" name="publier_feedback" class="indiv">
              <option value="2">Je partage ce texte pour qu'on y réagisse, je veux bien que les gens le notent et fassent savoir ce qu'ils en pensent.</option>
              <option value="1">Si quelqu'un a quelque chose à dire sur mon texte, il peut le faire, mais uniquement par messages privés.</option>
              <option value="0">Je ne veux aucun retour sur mon texte. Il est fait pour être lu, les réactions ne m'intéressent pas.</option>
            </select><br>
            <br>

            <label for="publier_titre">Titre du texte (maximum 90 caractères)</label>
            <input id="publier_titre" name="publier_titre" class="indiv" type="text" value="<?=$texte_titre?>" maxlength="90"><br>
            <br>

            <label for="publier_contenu">Contenu du texte (vous pouvez utiliser des <a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> pour formater le texte)</label>
            <textarea id="publier_contenu" name="publier_contenu" class="indiv composer_texte"><?=$texte_contenu?></textarea><br>
            <br>

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

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';