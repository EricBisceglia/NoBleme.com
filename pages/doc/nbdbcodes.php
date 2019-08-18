<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/functions_nbdb.inc.php';     // Inclusions liées à la NBDB
include './../../inc/bbcodes.inc.php';

// Permissions
user_restrict_to_administrators();

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

        <p>
          Une version NSFW (floutage) de tous les NBDBCodes image/vidéo existe également, en rajoutant -nsfw au nom du tag (exemple: [[image-nsfw:]] au lieu de [[image:]], [[galerie-nsfw:]] au lieu de [[galerie:]], etc.)
        </p>

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
                <?=nbdbcodes('== Ceci est un titre ==', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                === Sous-titre ===
              </td>
              <td>
                <?=nbdbcodes('=== Ceci est un sous-titre ===', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[web:page|titre alternatif]]
              </td>
              <td>
                <?=nbdbcodes('[[web:Poop da scoop di poop|Scoop di poop]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[dico:page|titre alternatif]]
              </td>
              <td>
                <?=nbdbcodes('[[dico:troll|Troll]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[lien:http://www.lien.com]]
              </td>
              <td>
                <?=nbdbcodes('[[lien:http://www.nobleme.com/]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
               [[lien:http://www.lien.com|titre]]
              </td>
              <td>
                <?=nbdbcodes('[[lien:http://www.nobleme.com/|NoBleme]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[copypasta=id]]Texte[[/copypasta]]
              </td>
              <td class="align_left">
                <?=nbdbcodes('[[copypasta=id]]Ce texte sera copié dans le presse papiers lorsque vous double cliquerez dessus[[/copypasta]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[copypasta-nsfw=id]]Texte[[/copypasta-nsfw]]
              </td>
              <td class="align_left">
                <?=nbdbcodes('[[copypasta-nsfw=xx]]Ce texte sera copié dans le presse papiers lorsque vous double cliquerez dessus[[/copypasta-nsfw]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[image:image.png]]
              </td>
              <td>
                <?=nbdbcodes('[[image:Image_de_test_pour_les_exemples.png]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[image:image.png|gauche]]
              </td>
              <td>
                <?=nbdbcodes('[[image:Image_de_test_pour_les_exemples.png|gauche]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[image:image.png|droite|Légende]]
              </td>
              <td>
                <?=nbdbcodes('[[image:Image_de_test_pour_les_exemples.png|droite|Légende]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image Il y a du texte à côté de cette image
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[youtube:hash]]
              </td>
              <td>
                <?=nbdbcodes('[[youtube:LDU_Txk06tM]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[youtube:hash|gauche]]
              </td>
              <td>
                <?=nbdbcodes('[[youtube:LDU_Txk06tM|gauche]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[youtube:hash|droite|Légende]]
              </td>
              <td>
                <?=nbdbcodes('[[youtube:LDU_Txk06tM|droite|Légende]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo Il y a du texte à côté de cette vidéo
              </td>
            </tr>

            <tr>
              <td class="texte_noir">
                [[trends:mot]]
              </td>
              <td>
                <?=nbdbcodes('[[trends:mot]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[trends2:mot|mot]]
              </td>
              <td>
                <?=nbdbcodes('[[trends2:uno|deux]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[trends3:mot|mot|mot]]
              </td>
              <td>
                <?=nbdbcodes('[[trends3:uno|deux|trois]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[trends4:mot|mot|mot|mot]]
              </td>
              <td>
                <?=nbdbcodes('[[trends4:uno|deux|trois|quatre]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
              </td>
            </tr>
            <tr>
              <td class="texte_noir">
                [[trends5:mot|mot|mot|mot|mot]]
              </td>
              <td>
                <?=nbdbcodes('[[trends5:uno|deux|trois|quatre|cinq]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
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
                <?=nbdbcodes(' [[galerie]]
                                [[galerie:Image_de_test_pour_les_exemples.png]]
                                [[galerie:Image_de_test_pour_les_exemples.png]]
                                [[galerie:Image_de_test_pour_les_exemples.png|Légende]]
                                [[galerie:LDU_Txk06tM|youtube]]
                                [[galerie:LDU_Txk06tM|youtube]]
                                [[galerie:LDU_Txk06tM|youtube|Légende]]
                              [[/galerie]]', $path, nbdb_web_list_pages($lang), nbdb_web_list_definitions($lang))?>
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