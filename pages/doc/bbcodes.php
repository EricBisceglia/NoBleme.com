<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Doc';

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
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Description
  $trad['soustitre']        = "Formater vos messages";
  $trad['description']      = <<<EOD
<p>
  Les messages postés sur NoBleme peuvent être formatés à l'aide d'un système nommé <a href="https://fr.wikipedia.org/wiki/BBCode" class="gras">BBcode</a>.
</p>
<p>
  À l'aide d'instruction placées entre crochets avant et après des morceaux de vos messages, vous pouvez transformer des passages en les rendant gras, italiques, en créant des liens, en insérant des images, etc.
</p>
<p>
  Sur cette page, vous trouverez une liste de tous les BBCodes existant sur NoBleme, ainsi que d'un exemple d'utilisation pour chacun d'entre eux. Tout en bas de la page, vous trouverez une <a href="#bbcodes_testarea">zone de tests</a> vous permettant d'expérimenter avec les BBCodes de NoBleme.
</p>
EOD;

  // Tableau
  $trad['table_effet']      = "Effet";
  $trad['table_exemple']    = "Exemple d'utilisation";
  $trad['table_resultat']   = "Résultat formaté";
  $trad['table_gras']       = "Gras";
  $trad['tablex_gras']      = "Mon texte [b]en gras[/b]";
  $trad['table_italique']   = "Italique";
  $trad['tablex_italique']  = "Un peu [i]d'italiques[/i] ici";
  $trad['table_souligne']   = "Souligné";
  $trad['tablex_souligne']  = "Je [u]souligne[/u] mon texte";
  $trad['table_barre']      = "Barré";
  $trad['tablex_barre']     = "[s]Barrons[/s] du contenu";
  $trad['table_lien']       = "Lien";
  $trad['tablex_lien']      = "[url=http://www.nobleme.com]NoBleme[/url] est cool";
  $trad['table_align']      = "Alignement";
  $trad['tablex_align_1']   = "[align=left]À gauche[/align]";
  $trad['tablex_align_2']   = "[align=center]Au milieu[/align]";
  $trad['tablex_align_3']   = "[align=right]À droite[/align]";
  $trad['table_couleur']    = "Couleur";
  $trad['tablex_couleur_1'] = "[color=green]Couleur (en anglais)[/color]";
  $trad['tablex_couleur_2'] = "[color=#A15F8E]Ou en hexadécimal[/color]";
  $trad['table_taille']     = "Taille";
  $trad['tablex_taille_1']  = "[size=0.7]70% de la taille normale[/size]";
  $trad['tablex_taille_2']  = "[size=1.3]30% plus gros[/size]";
  $trad['table_flou']       = "Flou";
  $trad['tablex_flou']      = "[blur]Passez la souris sur ce texte[/blur]";
  $trad['table_spoiler']    = "Texte caché";
  $trad['tablex_spoiler_1'] = "[spoiler]L'assassin est le juge[/spoiler]";
  $trad['tablex_spoiler_2'] = "[spoiler=Star Wars]Han Solo a tiré le premier[/spoiler]";
  $trad['table_quote']      = "Citation";
  $trad['tablex_quote_1']   = "[quote]Quelqu'un a dit quelque chose[/quote]";
  $trad['tablex_quote_2']   = "[quote=ThArGos]J'aime les citations qui tournent[/quote]";
  $trad['tablex_code']      = "[code]Préserve        l'espacement[/code]";

  // Détails bons à savoir
  $trad['details_titre']    = "Détails bons à savoir sur les BBCodes";
  $trad['details_combine']  = "Les BBCodes peuvent se combiner";
  $trad['details_combinex'] = "Texte en [b]gras et [i]italique et [u]souligné[/u][/i][/b]";
  $trad['details_quote']    = "Les citations et les spoilers peuvent être imbriquées à l'infini";
  $trad['details_quotex']   = <<<EOD
[quote=Personne A]Comme l'a dit Personne B,
[quote=Personne B]Pour citer Personne C,
[spoiler=Personne C]Le fond de l'air est frais
[spoiler=Personne D]Tout à fait[/spoiler]C'est bien ça[/spoiler]Eh ouais.[/quote]Fou, non?[/quote]
EOD;

  // Zone d'expérimentation
  $trad['experimentation']  = "Zone d'expérimentation";
  $trad['exp_instructions'] = "Testez les BBCodes en écrivant un message dans l'encadré ci-dessous:";
  $trad['exp_default']      = "[u]Zone de test des [b]BBcodes[/b][/u]";
  $trad['exp_previs']       = "Prévisualisation en direct du résultat formaté:";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Description
  $trad['soustitre']        = "Formatting your messages";
  $trad['description']      = <<<EOD
<p>
  Messages posted on NoBleme are formatted using a system called <a href="https://en.wikipedia.org/wiki/BBCode" class="gras">BBcode</a>.
</p>
<p>
  Using instructions placed between brackets before and after bits of your message, you can turn those bits bold, underline them, create links, post images, etc.
</p>
<p>
  On this page, you will find a list of all BBCodes that are available on NoBleme, aswell as an usage example for each one of them. At the bottom of the page, you will find an <a href="#bbcodes_testarea">experimentation zone</a> allowing you to try your hand at formatting messages using NoBleme's BBCodes.
</p>
EOD;

  // Tableau
  $trad['table_effet']      = "Effect";
  $trad['table_exemple']    = "Usage example";
  $trad['table_resultat']   = "Formatted result";
  $trad['table_gras']       = "Bold";
  $trad['tablex_gras']      = "My [b]bolded[/b] text";
  $trad['table_italique']   = "Italics";
  $trad['tablex_italique']  = "Here be [i]italics[/i]";
  $trad['table_souligne']   = "Underlined";
  $trad['tablex_souligne']  = "I [u]underline[/u] my text";
  $trad['table_barre']      = "Strikethrough";
  $trad['tablex_barre']     = "Let's [s]strike through[/s] some stuff";
  $trad['table_lien']       = "Link";
  $trad['tablex_lien']      = "[url=http://www.nobleme.com]NoBleme[/url] is cool";
  $trad['table_align']      = "Alignment";
  $trad['tablex_align_1']   = "[align=left]To the left[/align]";
  $trad['tablex_align_2']   = "[align=center]To the middle[/align]";
  $trad['tablex_align_3']   = "[align=right]To the right[/align]";
  $trad['table_couleur']    = "Color";
  $trad['tablex_couleur_1'] = "[color=green]Please color me[/color]";
  $trad['tablex_couleur_2'] = "[color=#A15F8E]Works with hex codes[/color]";
  $trad['table_taille']     = "Size";
  $trad['tablex_taille_1']  = "[size=0.7]70% smaller than normal[/size]";
  $trad['tablex_taille_2']  = "[size=1.3]30% bigger text[/size]";
  $trad['table_flou']       = "Blur";
  $trad['tablex_flou']      = "[blur]Hover your mouse over this text[/blur]";
  $trad['table_spoiler']    = "Spoiler";
  $trad['tablex_spoiler_1'] = "[spoiler]The assassin is the judge[/spoiler]";
  $trad['tablex_spoiler_2'] = "[spoiler=Star Wars]Han shot first[/spoiler]";
  $trad['table_quote']      = "Quote";
  $trad['tablex_quote_1']   = "[quote]Somebody once told me[/quote]";
  $trad['tablex_quote_2']   = "[quote=Smash Mouth]The world is gonna roll me[/quote]";
  $trad['tablex_code']      = "[code]Preserves        spacing[/code]";

  // Détails bons à savoir
  $trad['details_titre']    = "Useful extra info about BBCodes";
  $trad['details_combine']  = "You can mix BBCodes with eachother";
  $trad['details_combinex'] = "This text is [b]bolded, [i]in italics, [u]and underlined[/u][/i][/b]";
  $trad['details_quote']    = "You can stack spoilers and quotes";
  $trad['details_quotex']   = <<<EOD
[quote=Person A]As person B said,
[quote=Person B]To quote person B,
[spoiler=Person C]The weather is nice today
[spoiler=Person D]Quite so[/spoiler]Absolutely[/spoiler]Innit?[/quote]Amirite[/quote]
EOD;

  // Zone d'expérimentation
  $trad['experimentation']  = "Experimentation zone";
  $trad['exp_instructions'] = "Experiment with BBCodes by writing a message in the form below:";
  $trad['exp_default']      = "[u][b]BBCode[/b] test zone[/u]";
  $trad['exp_previs']       = "Live preview of the formatted results:";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>BBCodes</h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['description']?>

      </div>

      <br>
      <br>

      <div class="texte3">

        <table class="fullgrid titresnoirs">
          <thead>
            <tr>
              <th>
                <?=$trad['table_effet']?>
              </th>
              <th>
                BBcode
              </th>
              <th>
                <?=$trad['table_exemple']?>
              </th>
              <th>
                <?=$trad['table_resultat']?>
              </th>
            </tr>
          </thead>

          <tbody class="align_center">

            <tr>
              <td>
                <?=$trad['table_gras']?>
              </td>
              <td>
                [b] [/b]
              </td>
              <td>
                <?=$trad['tablex_gras']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_gras'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$trad['table_italique']?>
              </td>
              <td>
                [i] [/i]
              </td>
              <td>
                <?=$trad['tablex_italique']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_italique'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$trad['table_souligne']?>
              </td>
              <td>
                [u] [/u]
              </td>
              <td>
                <?=$trad['tablex_souligne']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_souligne'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$trad['table_barre']?>
              </td>
              <td>
                [s] [/s]
              </td>
              <td>
                <?=$trad['tablex_barre']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_barre'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$trad['table_lien']?>
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
                <?=$trad['tablex_lien']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_lien'])?>
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
                <?=$trad['table_align']?>
              </td>
              <td rowspan="3">
                [align] [/align]
              </td>
              <td>
                <?=$trad['tablex_align_1']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_align_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['tablex_align_2']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_align_2'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['tablex_align_3']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_align_3'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$trad['table_couleur']?>
              </td>
              <td rowspan="2">
                [color] [/color]
              </td>
              <td>
                <?=$trad['tablex_couleur_1']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_couleur_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['tablex_couleur_2']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_couleur_2'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$trad['table_taille']?>
              </td>
              <td rowspan="2">
                [size] [/size]
              </td>
              <td>
                <?=$trad['tablex_taille_1']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_taille_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['tablex_taille_2']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_taille_2'])?>
              </td>
            </tr>

            <tr>
              <td>
                <?=$trad['table_flou']?>
              </td>
              <td>
                [blur] [/blur]
              </td>
              <td>
                <?=$trad['tablex_flou']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_flou'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$trad['table_spoiler']?>
              </td>
              <td rowspan="2">
                [spoiler] [/spoiler]
              </td>
              <td>
                <?=$trad['tablex_spoiler_1']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_spoiler_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['tablex_spoiler_2']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_spoiler_2'])?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=$trad['table_quote']?>
              </td>
              <td rowspan="2">
                [quote] [/quote]
              </td>
              <td>
                <?=$trad['tablex_quote_1']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_quote_1'])?>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['tablex_quote_2']?>
              </td>
              <td>
                <?=bbcode($trad['tablex_quote_2'])?>
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
                <pre><?=$trad['tablex_code']?></pre>
              </td>
              <td class="align_left">
                <?=bbcode($trad['tablex_code'])?>
              </td>
            </tr>

          </tbody>
        </table>

      </div>

      <br>
      <br>
      <br>

      <div class="texte">

        <h3><?=$trad['details_titre']?></h3>

        <p class="moinsgros gras alinea"><?=$trad['details_combine']?></p>
        <br>
        <pre class="alinea"><?=$trad['details_combinex']?></pre><br>
        <?=bbcode($trad['details_combinex'])?><br>
        <br>

        <p class="moinsgros gras alinea"><?=$trad['details_quote']?></p>
        <br>
        <pre class="alinea"><?=$trad['details_quotex']?></pre><br>
        <?=bbcode($trad['details_quotex'])?><br>
        <br>
        <br>
        <br>
        <br>

        <h3><?=$trad['experimentation']?></h3>

        <br>

        <label for="bbcodes_testarea"><?=$trad['exp_instructions']?></label>
        <textarea id="bbcodes_testarea" name="bbcodes_testarea" class="indiv bbcodes_cadre bbcodes_message" onkeyup="dynamique('<?=$chemin?>', './../user/xhr/previsualiser_bbcodes.php', 'bbcodes_previsualisation', 'message=' + dynamique_prepare('bbcodes_testarea'), 1 );"><?=$trad['exp_default']?></textarea><br>
        <br>

        <label><?=$trad['exp_previs']?></label>
        <div id="bbcodes_previsualisation" class="vscrollbar bbcodes_cadre bbcodes_previsualisation">
          <?=bbcode($trad['exp_default'])?>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';