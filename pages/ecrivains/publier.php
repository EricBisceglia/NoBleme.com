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
// Titre




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

            <label for="feedback_niveau">Niveau de retours que vous désirez</label>
            <select id="feedback_niveau" name="feedback_niveau" class="indiv">
              <option value="2">Je partage ce texte pour qu'on y réagisse, je veux bien que les gens le notent et y postent des réponses.</option>
              <option value="1">Si quelqu'un a quelque chose à dire sur mon texte, il peut le faire par messages privés.</option>
              <option value="0">Je ne veux aucun retour sur mon texte. Il est fait pour être lu, les réactions ne m'intéressent pas.</option>
            </select><br>
            <br>

            <label for="publier_titre">Titre du texte</label>
            <input id="publier_titre" name="publier_titre" class="indiv" type="text"><br>
            <br>

            <label for="publier_contenu">Contenu du texte</label>
            <textarea id="publier_contenu" name="publier_contenu" class="indiv composer_texte"></textarea><br>

            <br>
            <input value="PUBLIER LE TEXTE DANS LE COIN DES ÉCRIVAINS" type="submit" name="publier_go">

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';