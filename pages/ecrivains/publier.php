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
  $texte_titre    = postdata($_POST['publier_titre']);
  $texte_contenu  = postdata($_POST['publier_contenu']);

  // Informations nécessaires pour publier le texte
  $texte_auteur   = $_SESSION['user'];
  $texte_creation = time();
  $texte_longueur = mb_strlen($texte_contenu, 'UTF-8');

  // Publication du texte
  query(" INSERT INTO ecrivains_texte
          SET         ecrivains_texte.FKmembres               = '$texte_auteur'   ,
                      ecrivains_texte.FKecrivains_concours    = 0                 ,
                      ecrivains_texte.timestamp_creation      = '$texte_creation' ,
                      ecrivains_texte.timestamp_modification  = 0                 ,
                      ecrivains_texte.niveau_feedback         = '$texte_feedback' ,
                      ecrivains_texte.titre                   = '$titre'          ,
                      ecrivains_texte.note_moyenne            = -1                ,
                      ecrivains_texte.longueur_texte          = '$texte_longueur' ,
                      ecrivains_texte.contenu                 = '$texte_contenu'  ");

  // Redirection vers le texte
  $texte_id = mysqli_insert_id($db);
  //exit(header("Location: ".$chemin."pages/ecrivains/texte.php?id="));
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

            <label for="publier_titre">Titre du texte (maximum 120 caractères)</label>
            <input id="publier_titre" name="publier_titre" class="indiv" type="text" maxlength="120"><br>
            <br>

            <label for="publier_contenu">Contenu du texte (vous pouvez utiliser des <a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> pour formater le texte)</label>
            <textarea id="publier_contenu" name="publier_contenu" class="indiv composer_texte"></textarea><br>
            <br>

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