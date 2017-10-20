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
$page_nom = "Contemple les émoticônes";
$page_url = "pages/doc/emotes";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Émoticônes" : "Emotes";
$page_desc  = "Liste des émoticônes disponibles sur NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Description
$traduction['titre']      = ($lang == 'FR') ? "Émoticônes" : "Emotes";
$traduction['soustitre']  = ($lang == 'FR') ? "Pour donner de la vie aux messages" : "Making your messages feel alive";
if($lang == 'FR')
  $traduction['description'] = "<p>
  Les émoticônes sont des petites images amusantes qui remplacent automatiquement certaines combinaisons de caractères dans vos messages. Elles expriment diverses émotions, et vous permettent de rendre vos messages un peu plus vivants, si vous le désirez.
</p>
<p>
  Par exemple, si vous écrivez ceci: &laquo; Je me marre XD &raquo;<br>
  Votre phrase sera remplacée par: &laquo; Je me marre ".bbcode("XD")." &raquo;
</p>";
else
  $traduction['description'] = "<p>
  Emotes are amusing little images that will automatically replace certain character combinations in your messages. They allow you to show a range of emotions through simple images, and can be used to make your message feel a bit more alive if you so desire.
</p>
<p>
  For example, if you typed this: &laquo; I'm laughing XD &raquo;<br>
  It would get replaced with this: &laquo; I'm laughing ".bbcode("XD")." &raquo;
</p>";
$traduction['source'] = ($lang == 'FR') ? "Source des émoticônes de NoBleme" : "Source of NoBleme's emotes";
if($lang == 'FR')
  $traduction['source_description'] = "<p>
   Toutes les émoticônes utilisées sur NoBleme sont prises au projet <a class=\"gras\" href=\"http://chatzilla.hacksrus.com/\">ChatZilla</a>. Ce choix est le produit d'une ancienne tradition NoBlemeuse d'utiliser ces émoticônes particulièrement amusants à l'époque où la majorité d'entre nous utilisaient ChatZilla pour se conneter à <a class=\"gras\" href=\"".$chemin."pages/irc/index\">notre serveur IRC</a>.
</p>
<p>
  ChatZilla, ainsi que le contenu qui lui est lié (incluant les émoticônes) sont protégés par la MPL (Mozilla Public Licence), qui autorise la réutilisation de son contenu sous diverses <a class=\"gras\" href=\"https://www.mozilla.org/en-US/MPL/2.0/FAQ/\">conditions et clauses</a>, que NoBleme s'efforce de respecter. L'équipe de développement de ChatZilla a été contactée au sujet de l'utilisation de ces émoticônes, et a donné son autorisation tant que la licence MPL est respectée.
</p>";
else
  $traduction['source_description'] = "<p>
   All the emotes used on NoBleme were taken from the <a class=\"gras\" href=\"http://chatzilla.hacksrus.com/\">ChatZilla</a> project. This choice is the product of a long standing NoBleme tradition of loving these funny little exaggerated emotes, back in the day when most of us used ChatZilla to connect to <a class=\"gras\" href=\"".$chemin."pages/irc/index\">our IRC server</a>.
</p>
<p>
  ChatZilla, aswell as the contents linked to it, are protected by the MPL (Mozilla Public Licence), which allows reuse of its contents as long as <a class=\"gras\" href=\"https://www.mozilla.org/en-US/MPL/2.0/FAQ/\">certain conditions</a> are respected, which NoBleme obviously does its best to respect. The ChatZilla development team was contacted aswell, and gave us their approval for emote reuse as long as we keep respecting the MPL licence.
</p>";

// Tableau
$traduction['table_emote']      = ($lang == 'FR') ? 'ÉMOTICÔNE' : 'EMOTE';
$traduction['table_texte']      = ($lang == 'FR') ? 'TEXTE' : 'TEXT';
$traduction['table_nom']        = ($lang == 'FR') ? 'NOM' : 'NAME';
$traduction['table_sourire']    = ($lang == 'FR') ? 'Sourire' : 'Smiling';
$traduction['table_heureux']    = ($lang == 'FR') ? 'Heureux' : 'Happy';
$traduction['table_jouissif']   = ($lang == 'FR') ? 'Jouissif' : 'Nirvana';
$traduction['table_rire']       = ($lang == 'FR') ? 'Rire' : 'Lauhging';
$traduction['table_coquin']     = ($lang == 'FR') ? 'Coquin' : 'Rascal';
$traduction['table_triste']     = ($lang == 'FR') ? 'Triste' : 'Sad';
$traduction['table_pleure']     = ($lang == 'FR') ? 'Pleure' : 'Crying';
$traduction['table_mecontent']  = ($lang == 'FR') ? 'Mécontent' : 'Angry';
$traduction['table_colere']     = ($lang == 'FR') ? 'Colère' : 'Pissed';
$traduction['table_cool']       = ($lang == 'FR') ? 'Cool' : 'Cool';
$traduction['table_complice']   = ($lang == 'FR') ? 'Complice' : 'Complicit';
$traduction['table_honte']      = ($lang == 'FR') ? 'Honte' : 'Ashamed';
$traduction['table_reveur']     = ($lang == 'FR') ? 'Rêveur' : 'Dreamy';
$traduction['table_blase']      = ($lang == 'FR') ? 'Blasé' : 'Blasé';
$traduction['table_gene']       = ($lang == 'FR') ? 'Gêné' : 'Awkward';
$traduction['table_surprise']   = ($lang == 'FR') ? 'Surprise' : 'Surprised';
$traduction['table_perplexe']   = ($lang == 'FR') ? 'Perplexe' : 'Perplexed';





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$traduction['titre']?></h1>

        <h5><?=$traduction['soustitre']?></h5>

        <?=$traduction['description']?>

        <br>

        <h5><?=$traduction['source']?></h5>

        <?=$traduction['source_description']?>

      </div>

      <br>
      <br>

      <div class="minitexte2">

        <table class="fullgrid titresnoirs">
          <thead>
            <tr>
              <th>
                <?=$traduction['table_emote']?>
              </th>
              <th>
                <?=$traduction['table_texte']?>
              </th>
              <th>
                <?=$traduction['table_nom']?>
              </th>
            </tr>
          </thead>

          <tbody class="align_center">

            <tr>
              <td>
                <?=bbcode(":)")?>
              </td>
              <td class="monospace">
                :)
              </td>
              <td>
                <?=$traduction['table_sourire']?>
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":D")?>
              </td>
              <td class="monospace">
                :D
              </td>
              <td>
                <?=$traduction['table_heureux']?>
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":DD")?>
              </td>
              <td class="monospace">
                :DD
              </td>
              <td>
                <?=$traduction['table_jouissif']?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode("XD")?>
              </td>
              <td class="monospace">
                XD
              </td>
              <td rowspan="2">
                <?=$traduction['table_rire']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                xD
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":P")?>
              </td>
              <td class="monospace">
                :P
              </td>
              <td rowspan="2">
                <?=$traduction['table_coquin']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :p
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":(")?>
              </td>
              <td class="monospace">
                :(
              </td>
              <td>
                <?=$traduction['table_triste']?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":'(")?>
              </td>
              <td class="monospace">
                :'(
              </td>
              <td rowspan="2">
                <?=$traduction['table_pleure']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :"(
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode("):C")?>
              </td>
              <td class="monospace">
                ):C
              </td>
              <td>
                <?=$traduction['table_mecontent']?>
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode("):(")?>
              </td>
              <td class="monospace">
                ):(
              </td>
              <td>
                <?=$traduction['table_colere']?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode("B-)")?>
              </td>
              <td class="monospace">
                B-)
              </td>
              <td rowspan="2">
                <?=$traduction['table_cool']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                8-)
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(";-)")?>
              </td>
              <td class="monospace">
                ;-)
              </td>
              <td>
                <?=$traduction['table_complice']?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":#")?>
              </td>
              <td class="monospace">
                :")
              </td>
              <td rowspan="2">
                <?=$traduction['table_honte']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :#
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode("9_9")?>
              </td>
              <td class="monospace">
                9_9
              </td>
              <td>
                <?=$traduction['table_reveur']?>
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":|")?>
              </td>
              <td class="monospace">
                :|
              </td>
              <td>
                <?=$traduction['table_blase']?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":S")?>
              </td>
              <td class="monospace">
                :S
              </td>
              <td rowspan="2">
                <?=$traduction['table_gene']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :s
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":O")?>
              </td>
              <td class="monospace">
                :O
              </td>
              <td rowspan="2">
                <?=$traduction['table_surprise']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :o
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode("o_O")?>
              </td>
              <td class="monospace">
                o_O
              </td>
              <td rowspan="4">
                <?=$traduction['table_perplexe']?>
              </td>
            </tr>
            <tr>
              <td>
                <?=bbcode("O_o")?>
              </td>
              <td class="monospace">
                O_o
              </td>
            </tr>
            <tr>
              <td rowspan="2">
                <?=bbcode("O_O")?>
              </td>
              <td class="monospace">
                O_O
              </td>
            </tr>
            <tr>
              <td class="monospace">
                o_o
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