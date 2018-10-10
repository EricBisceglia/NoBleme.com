<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/nbdb.inc.php';     // Inclusions liées à la NBDB

// Permissions
adminonly();

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Doc';

// Identification
$page_nom = "Apprend à utiliser les BBCodes";
$page_url = "pages/doc/bbcodes";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "NBDBCodes";
$page_desc  = "Documentation illustrée des balises de formatage de contenu sur NoBleme";

// CSS & JS
$css  = array('doc', 'nbdb');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1 class="align_center">NBDBCodes</h1>

        <br>
        <br>

        <table class="fullgrid titresnoirs">
          <thead>
            <tr>
              <th>
                NBDBCode
              </th>
              <th>
                Exemple
              </th>
            </tr>
          </thead>

          <tbody class="align_center">

            <tr>
              <td class="texte_noir">
                == Titre ==
              </td>
              <td>
                <?=nbdbcode('== Ceci est un titre ==', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                === Sous-titre ===
              </td>
              <td>
                <?=nbdbcode('=== Ceci est un sous-titre ===', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[web:page]]
              </td>
              <td>
                <?=nbdbcode('[[web:Somebody toucha my spaghet]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[web:page|titre alternatif]]
              </td>
              <td>
                <?=nbdbcode('[[web:Poop da scoop|Scoop di poop inexistant]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[dico:page]]
              </td>
              <td>
                <?=nbdbcode('[[web:IRL]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[dico:page|titre alternatif]]
              </td>
              <td>
                <?=nbdbcode('[[web:It is a heuristic|Page qui n\'est pas là]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[lien:http://www.lien.com]]
              </td>
              <td>
                <?=nbdbcode('[[lien:http://www.nobleme.com/]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
               [[lien:http://www.lien.com|titre]]
              </td>
              <td>
                <?=nbdbcode('[[lien:http://www.nobleme.com/|NoBleme]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[image:image.png]]
              </td>
              <td>
                <?=nbdbcode('[[image:Image_de_test_pour_les_exemples.png]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[image:image.png|gauche]]
              </td>
              <td>
                <?=nbdbcode('[[image:Image_de_test_pour_les_exemples.png|gauche]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[image:image.png|droite|Légende]]
              </td>
              <td>
                <?=nbdbcode('[[image:Image_de_test_pour_les_exemples.png|droite|Légende]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[youtube:hash]]
              </td>
              <td>
                <?=nbdbcode('[[youtube:LDU_Txk06tM]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[youtube:hash|gauche]]
              </td>
              <td>
                <?=nbdbcode('[[youtube:LDU_Txk06tM|gauche]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[youtube:hash|droite|Légende]]
              </td>
              <td>
                <?=nbdbcode('[[youtube:LDU_Txk06tM|droite|Légende]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[galerie]]<br>
                <br>
                [[galerie:image.png]]<br>
                [[galerie:image.png|légende]]<br>
                [[galerie:hash|youtube]]
                [[galerie:hash|youtube|légende]]<br>
                <br>
                [[/galerie]]
              </td>
              <td>
                <?=nbdbcode(' [[galerie]]
                                [[galerie:Image_de_test_pour_les_exemples.png]]
                                [[galerie:Image_de_test_pour_les_exemples.png]]
                                [[galerie:Image_de_test_pour_les_exemples.png|Légende]]
                                [[galerie:LDU_Txk06tM|youtube]]
                                [[galerie:LDU_Txk06tM|youtube]]
                                [[galerie:LDU_Txk06tM|youtube|Légende]]
                              [[/galerie]]', $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang))?>
              </td>
            </tr>

          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';