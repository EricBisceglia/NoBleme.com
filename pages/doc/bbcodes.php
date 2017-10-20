<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Documentation';

// Identification
$page_nom = "Apprend à utiliser les BBCodes";
$page_url = "pages/doc/bbcodes";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = "BBCodes";
$page_desc  = "Documentation illustrée des balises de formatage de contenu sur NoBleme";

// CSS & JS
$css  = array('doc');
$js   = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Description
$traduction['soustitre'] = ($lang == 'FR') ? "Formater vos messages" : "Formatting your messages";
if($lang == 'FR')
  $traduction['description'] = "<p>
Les messages postés sur NoBleme peuvent être formatés à l'aide d'un système nommé <a href=\"https://fr.wikipedia.org/wiki/BBCode\" class=\"gras\">BBcode</a>.
</p>
<p>
  À l'aide d'instruction placées entre crochets avant et après des morceaux de vos messages, vous pouvez transformer des passages en les rendant gras, italiques, en créant des liens, en insérant des images, etc.
</p>
<p>
  Sur cette page, vous trouverez une liste de tous les BBCodes existant sur NoBleme, ainsi que d'un exemple d'utilisation pour chacun d'entre eux. Tout en bas de la page, vous trouverez une <a href=\"#bbcodes_testarea\">zone de tests</a> vous permettant d'expérimenter avec les BBCodes de NoBleme.
</p>";
else
  $traduction['description'] = "<p>
Messages posted on NoBleme are formatted using a system called <a href=\"https://en.wikipedia.org/wiki/BBCode\" class=\"gras\">BBcode</a>.
</p>
<p>
  Using instructions placed between brackets before and after bits of your message, you can turn those bits bold, underline them, create links, post images, etc.
</p>
<p>
  On this page, you will find a list of all BBCodes that are available on NoBleme, aswell as an usage example for each one of them. At the bottom of the page, you will find an <a href=\"#bbcodes_testarea\">experimentation zone</a> allowing you to try your hand at formatting messages using NoBleme's BBCodes.
</p>";

// Tableau
$traduction['table_effet']      = ($lang == 'FR') ? "Effet" : "Effect";
$traduction['table_exemple']    = ($lang == 'FR') ? "Exemple d'utilisation" : "Usage example";
$traduction['table_resultat']   = ($lang == 'FR') ? "Résultat formaté" : "Formatted result";
$traduction['table_gras']       = ($lang == 'FR') ? "Gras" : "Bold";
$traduction['tablex_gras']      = ($lang == 'FR') ? "Mon texte [b]en gras[/b]" : "My [b]bolded[/b] text";
$traduction['table_italique']   = ($lang == 'FR') ? "Italique" : "Italics";
$traduction['tablex_italique']  = ($lang == 'FR') ? "Un peu [i]d'italiques[/i] ici" : "Here be [i]italics[/i]";
$traduction['table_souligne']   = ($lang == 'FR') ? "Souligné" : "Underlined";
$traduction['tablex_souligne']  = ($lang == 'FR') ? "Je [u]souligne[/u] mon texte" : "I [u]underline[/u] my text";
$traduction['table_barre']      = ($lang == 'FR') ? "Barré" : "Strikethrough";
$traduction['tablex_barre']     = ($lang == 'FR') ? "[s]Barrons[/s] du contenu" : "Let's [s]strike through[/s] some stuff";
$traduction['table_lien']       = ($lang == 'FR') ? "Lien" : "Link";
$traduction['tablex_lien']      = ($lang == 'FR') ? "[url=http://www.nobleme.com]NoBleme[/url] est cool" : "[url=http://www.nobleme.com]NoBleme[/url] is cool";
$traduction['table_align']      = ($lang == 'FR') ? "Alignement" : "Alignment";
$traduction['tablex_align_1']   = ($lang == 'FR') ? "[align=left]À gauche[/align]" : "[align=left]To the left[/align]";
$traduction['tablex_align_2']   = ($lang == 'FR') ? "[align=center]Au milieu[/align]" : "[align=center]To the middle[/align]";
$traduction['tablex_align_3']   = ($lang == 'FR') ? "[align=right]À droite[/align]" : "[align=right]To the right[/align]";
$traduction['table_couleur']    = ($lang == 'FR') ? "Couleur" : "Color";
$traduction['tablex_couleur_1'] = ($lang == 'FR') ? "[color=green]Couleur (en anglais)[/color]" : "[color=green]Please color me[/color]";
$traduction['tablex_couleur_2'] = ($lang == 'FR') ? "[color=#A15F8E]Ou en hexadécimal[/color]" : "[color=#A15F8E]Works with hex codes[/color]";
$traduction['table_taille']     = ($lang == 'FR') ? "Taille" : "Size";
$traduction['tablex_taille_1']  = ($lang == 'FR') ? "[size=0.7]70% de la taille normale[/size]" : "[size=0.7]70% smaller than normal[/size]";
$traduction['tablex_taille_2']  = ($lang == 'FR') ? "[size=1.3]30% plus gros[/size]" : "[size=1.3]30% bigger text[/size]";
$traduction['table_flou']       = ($lang == 'FR') ? "Flou" : "Blur";
$traduction['tablex_flou']      = ($lang == 'FR') ? "[blur]Passez la souris sur ce texte[/blur]" : "[blur]Hover your mouse over this text[/blur]";
$traduction['table_spoiler']    = ($lang == 'FR') ? "Texte caché" : "Spoiler";
$traduction['tablex_spoiler_1'] = ($lang == 'FR') ? "[spoiler]L'assassin est le juge[/spoiler]" : "[spoiler]The assassin is the judge[/spoiler]";
$traduction['tablex_spoiler_2'] = ($lang == 'FR') ? "[spoiler=Star Wars]Han Solo a tiré le premier[/spoiler]" : "[spoiler=Star Wars]Han shot first[/spoiler]";
$traduction['table_quote']      = ($lang == 'FR') ? "Citation" : "Quote";
$traduction['tablex_quote_1']   = ($lang == 'FR') ? "[quote]Quelqu'un a dit quelque chose[/quote]" : "[quote]Somebody once told me[/quote]";
$traduction['tablex_quote_2']   = ($lang == 'FR') ? "[quote=ThArGos]J'aime les citations qui tournent[/quote]" : "[quote=Smash Mouth]The world is gonna roll me[/quote]";
$traduction['tablex_code']      = ($lang == 'FR') ? "[code]Préserve        l'espacement[/code]" : "[code]Preserves        spacing[/code]";

// Détails bons à savoir
$traduction['details_titre']    = ($lang == 'FR') ? "Détails bons à savoir sur les BBCodes" : "Useful extra info about BBCodes";
$traduction['details_combine']  = ($lang == 'FR') ? "Les BBCodes peuvent se combiner" : "You can mix BBCodes with eachother";
$traduction['details_combinex'] = ($lang == 'FR') ? "Texte en [b]gras et [i]italique et [u]souligné[/u][/i][/b]" : "This text is [b]bolded, [i]in italics, [u]and underlined[/u][/i][/b]";
$traduction['details_quote']    = ($lang == 'FR') ? "Les citations peuvent être imbriquées à l'infini" : "You can put quotes in quotes";
$traduction['details_quotex']   = ($lang == 'FR') ? "[quote=Personne A]Comme l'a dit Personne B,
[quote=Personne B]Pour citer Personne C,
[quote=Personne C]Le fond de l'air est frais[/quote]Eh ouais.[/quote]Fou, non?[/quote]" : "[quote=Person A]As person B said,
[quote=Person B]To quote person B,
[quote=Person C]The weather is nice today[/quote]Innit?[/quote]Amirite[/quote]";

// Zone d'expérimentation
$traduction['experimentation']  = ($lang == 'FR') ? "Zone d'expérimentation" : "Experimentation zone";
$traduction['exp_instructions'] = ($lang == 'FR') ? "Testez les BBCodes en écrivant un message dans l'encadré ci-dessous:" : "Experiment with BBCodes by writing a message in the form below:";
$traduction['exp_default']      = ($lang == 'FR') ? "[u]Zone de test des [b]BBcodes[/b][/u]" : "[u][b]BBCode[/b] test zone[/u]";
$traduction['exp_previs']       = ($lang == 'FR') ? "Prévisualisation en direct du résultat formaté:" : "Live preview of the formatted results:";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>BBCodes</h1>

        <h5><?=$traduction['soustitre']?></h5>

        <?=$traduction['description']?>

      </div>

      <br>
      <br>

      <div class="texte3">

        <table class="fullgrid titresnoirs">
          <thead>
            <tr>
              <th>
                <?=$traduction['table_effet']?>
              </th>
              <th>
                BBcode
              </th>
              <th>
                <?=$traduction['table_exemple']?>
              </th>
              <th>
                <?=$traduction['table_resultat']?>
              </th>
            </tr>
          </thead>

          <tbody class="align_center">

            <tr>
              <td>
                <?=$traduction['table_gras']?>
              </td>
              <td>
                [b] [/b]
              </td>
              <td>
                <?=$traduction['tablex_gras']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_gras'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$traduction['table_italique']?>
              </td>
              <td>
                [i] [/i]
              </td>
              <td>
                <?=$traduction['tablex_italique']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_italique'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$traduction['table_souligne']?>
              </td>
              <td>
                [u] [/u]
              </td>
              <td>
                <?=$traduction['tablex_souligne']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_souligne'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$traduction['table_barre']?>
              </td>
              <td>
                [s] [/s]
              </td>
              <td>
                <?=$traduction['tablex_barre']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_barre'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$traduction['table_lien']?>
              </td>
              <td rowspan="2">
                [url] [/url]
              </td>
              <td>
                [url]http://www.nobleme.com[/url]
              </td>
              <td>
                <?=bbcode("[url]http://www.nobleme.com[/url]")?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$traduction['tablex_lien']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_lien'])?>
              </td>
            </tr>

            <tr>
              <td>
                Image
              </td>
              <td>
                [img] [/img]
              </td>
              <td>
                [img]http://www.nobleme.com/favicon.ico[/img]
              </td>
              <td>
                <?=bbcode("[img]http://www.nobleme.com/favicon.ico[/img]")?>
              </td>
            </tr>

            <tr>
              <td rowspan="3">
                <?=$traduction['table_align']?>
              </td>
              <td rowspan="3">
                [align] [/align]
              </td>
              <td>
                <?=$traduction['tablex_align_1']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_align_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$traduction['tablex_align_2']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_align_2'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$traduction['tablex_align_3']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_align_3'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$traduction['table_couleur']?>
              </td>
              <td rowspan="2">
                [color] [/color]
              </td>
              <td>
                <?=$traduction['tablex_couleur_1']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_couleur_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$traduction['tablex_couleur_2']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_couleur_2'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$traduction['table_taille']?>
              </td>
              <td rowspan="2">
                [size] [/size]
              </td>
              <td>
                <?=$traduction['tablex_taille_1']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_taille_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$traduction['tablex_taille_2']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_taille_2'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$traduction['table_flou']?>
              </td>
              <td>
                [blur] [/blur]
              </td>
              <td>
                <?=$traduction['tablex_flou']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_flou'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$traduction['table_spoiler']?>
              </td>
              <td rowspan="2">
                [spoiler] [/spoiler]
              </td>
              <td>
                <?=$traduction['tablex_spoiler_1']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_spoiler_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$traduction['tablex_spoiler_2']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_spoiler_2'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$traduction['table_quote']?>
              </td>
              <td rowspan="2">
                [quote] [/quote]
              </td>
              <td>
                <?=$traduction['tablex_quote_1']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_quote_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$traduction['tablex_quote_2']?>
              </td>
              <td>
                <?=bbcode($traduction['tablex_quote_2'])?>
              </td>
            </tr>

            <tr>
              <td>
                Code
              </td>
              <td>
                [code] [/code]
              </td>
              <td>
                <pre><?=$traduction['tablex_code']?></pre>
              </td>
              <td class="align_left">
                <?=bbcode($traduction['tablex_code'])?>
              </td>
            </tr>

          </tbody>
        </table>

      </div>

      <br>
      <br>
      <br>

      <div class="texte">

        <h3><?=$traduction['details_titre']?></h3>

        <p class="moinsgros gras alinea"><?=$traduction['details_combine']?></p>
        <p>
          <pre class="alinea"><?=$traduction['details_combinex']?></pre><br>
          <?=bbcode($traduction['details_combinex'])?>
        </p>

        <p class="moinsgros gras alinea"><?=$traduction['details_quote']?></p>
        <p>
          <pre class="alinea"><?=$traduction['details_quotex']?></pre><br>
          <?=bbcode($traduction['details_quotex'])?>
        </p>

        <br>
        <br>
        <br>

        <h3><?=$traduction['experimentation']?></h3>

        <br>

        <label for="bbcodes_testarea"><?=$traduction['exp_instructions']?></label>
        <textarea id="bbcodes_testarea" name="bbcodes_testarea" class="indiv bbcodes_cadre bbcodes_message" onkeyup="dynamique('<?=$chemin?>', './../user/xhr/previsualiser_bbcodes.php', 'bbcodes_previsualisation', 'message=' + dynamique_prepare('bbcodes_testarea'), 1 );"><?=$traduction['exp_default']?></textarea><br>
        <br>

        <label><?=$traduction['exp_previs']?></label>
        <div id="bbcodes_previsualisation" class="vscrollbar bbcodes_cadre bbcodes_previsualisation">
          <?=bbcode($traduction['exp_default'])?>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';