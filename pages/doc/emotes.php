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
$page_nom = "Contemple les émoticônes";
$page_url = "pages/doc/emotes";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Émoticônes" : "Emotes";
$page_desc  = "Liste des émoticônes disponibles sur NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{

  // Description
  $trad['titre']            = "Émoticônes";
  $trad['soustitre']        = "Pour donner de la vie aux messages";
  $temp_bbcode              = bbcode("XD");
  $trad['description']      = <<<EOD
<p>
  Les émoticônes sont des petites images amusantes qui remplacent automatiquement certaines combinaisons de caractères dans vos messages. Elles expriment diverses émotions, et vous permettent de rendre vos messages un peu plus vivants, si vous le désirez.
</p>
<p>
  Par exemple, si vous écrivez ceci : &laquo; Je me marre XD &raquo;<br>
  Votre phrase sera remplacée par : &laquo; Je me marre {$temp_bbcode} &raquo;
</p>
EOD;
  $trad['source']           = "Source des émoticônes de NoBleme";
  $trad['source_desc']      = <<<EOD
<p>
  Toutes les émoticônes utilisées sur NoBleme sont prises au projet <a class="gras" href="http://chatzilla.hacksrus.com/">ChatZilla</a>. Ce choix est le produit d'une ancienne tradition NoBlemeuse d'utiliser ces émoticônes particulièrement amusants à l'époque où la majorité d'entre nous utilisaient ChatZilla pour se conneter à <a class="gras" href="{$chemin}pages/irc/index">notre serveur IRC</a>.
</p>
<p>
  ChatZilla, ainsi que le contenu qui lui est lié (incluant les émoticônes) sont protégés par la MPL (Mozilla Public Licence), qui autorise la réutilisation de son contenu sous diverses <a class="gras" href="https://www.mozilla.org/en-US/MPL/2.0/FAQ/">conditions et clauses</a>, que NoBleme s'efforce de respecter. L'équipe de développement de ChatZilla a été contactée au sujet de l'utilisation de ces émoticônes, et a donné son autorisation tant que la licence MPL est respectée.
</p>
EOD;

  // Tableau
  $trad['table_emote']      = 'ÉMOTICÔNE';
  $trad['table_texte']      = 'TEXTE';
  $trad['table_nom']        = 'NOM';
  $trad['table_sourire']    = 'Sourire';
  $trad['table_heureux']    = 'Heureux';
  $trad['table_jouissif']   = 'Jouissif';
  $trad['table_rire']       = 'Rire';
  $trad['table_coquin']     = 'Coquin';
  $trad['table_triste']     = 'Triste';
  $trad['table_pleure']     = 'Pleure';
  $trad['table_mecontent']  = 'Mécontent';
  $trad['table_colere']     = 'Colère';
  $trad['table_cool']       = 'Cool';
  $trad['table_complice']   = 'Complice';
  $trad['table_honte']      = 'Honte';
  $trad['table_reveur']     = 'Rêveur';
  $trad['table_blase']      = 'Blasé';
  $trad['table_gene']       = 'Gêné';
  $trad['table_surprise']   = 'Surprise';
  $trad['table_perplexe']   = 'Perplexe';
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Description
  $trad['titre']            = "Emotes";
  $trad['soustitre']        = "Making your messages feel alive";
  $temp_bbcode              = bbcode("XD");
  $trad['description']      = <<<EOD
<p>
  Emotes are amusing little images that will automatically replace certain character combinations in your messages. They allow you to show a range of emotions through simple images, and can be used to make your message feel a bit more alive if you so desire.
</p>
<p>
  For example, if you typed this: &laquo; I'm laughing XD &raquo;<br>
  It would get replaced with this: &laquo; I'm laughing {$temp_bbcode} &raquo;
</p>
EOD;
  $trad['source']           = "Source of NoBleme's emotes";
  $trad['source_desc']      = <<<EOD
<p>
  All the emotes used on NoBleme were taken from the <a class="gras" href="http://chatzilla.hacksrus.com/">ChatZilla</a> project. This choice is the product of a long standing NoBleme tradition of loving these funny little exaggerated emotes, back in the day when most of us used ChatZilla to connect to <a class="gras" href="{$chemin}pages/irc/index">our IRC server</a>.
</p>
<p>
  ChatZilla, aswell as the contents linked to it, are protected by the MPL (Mozilla Public Licence), which allows reuse of its contents as long as <a class="gras" href="https://www.mozilla.org/en-US/MPL/2.0/FAQ/">certain conditions</a> are respected, which NoBleme obviously does its best to respect. The ChatZilla development team was contacted aswell, and gave us their approval for emote reuse as long as we keep respecting the MPL licence.
</p>
EOD;

  // Tableau
  $trad['table_emote']      = 'EMOTE';
  $trad['table_texte']      = 'TEXT';
  $trad['table_nom']        = 'NAME';
  $trad['table_sourire']    = 'Smiling';
  $trad['table_heureux']    = 'Happy';
  $trad['table_jouissif']   = 'Nirvana';
  $trad['table_rire']       = 'Lauhging';
  $trad['table_coquin']     = 'Rascal';
  $trad['table_triste']     = 'Sad';
  $trad['table_pleure']     = 'Crying';
  $trad['table_mecontent']  = 'Angry';
  $trad['table_colere']     = 'Pissed';
  $trad['table_cool']       = 'Cool';
  $trad['table_complice']   = 'Complicit';
  $trad['table_honte']      = 'Ashamed';
  $trad['table_reveur']     = 'Dreamy';
  $trad['table_blase']      = 'Blasé';
  $trad['table_gene']       = 'Awkward';
  $trad['table_surprise']   = 'Surprised';
  $trad['table_perplexe']   = 'Perplexed';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['description']?>

        <br>
        <br>

        <h5><?=$trad['source']?></h5>

        <?=$trad['source_desc']?>

      </div>

      <br>
      <br>

      <div class="minitexte2">

        <table class="fullgrid titresnoirs">
          <thead>
            <tr>
              <th>
                <?=$trad['table_emote']?>
              </th>
              <th>
                <?=$trad['table_texte']?>
              </th>
              <th>
                <?=$trad['table_nom']?>
              </th>
            </tr>
          </thead>

          <tbody class="align_center">

            <tr>
              <td>
                <?=bbcode(":-)")?>
              </td>
              <td class="monospace">
                :-)
              </td>
              <td>
                <?=$trad['table_sourire']?>
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":-D")?>
              </td>
              <td class="monospace">
                :-D
              </td>
              <td>
                <?=$trad['table_heureux']?>
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":-DD")?>
              </td>
              <td class="monospace">
                :-DD
              </td>
              <td>
                <?=$trad['table_jouissif']?>
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
                <?=$trad['table_rire']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                xD
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":-P")?>
              </td>
              <td class="monospace">
                :-P
              </td>
              <td rowspan="2">
                <?=$trad['table_coquin']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :-p
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":-(")?>
              </td>
              <td class="monospace">
                :-(
              </td>
              <td>
                <?=$trad['table_triste']?>
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
                <?=$trad['table_pleure']?>
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
                <?=$trad['table_mecontent']?>
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
                <?=$trad['table_colere']?>
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
                <?=$trad['table_cool']?>
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
                <?=$trad['table_complice']?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":-#")?>
              </td>
              <td class="monospace">
                :-")
              </td>
              <td rowspan="2">
                <?=$trad['table_honte']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :-#
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
                <?=$trad['table_reveur']?>
              </td>
            </tr>

            <tr>
              <td>
                <?=bbcode(":-|")?>
              </td>
              <td class="monospace">
                :-|
              </td>
              <td>
                <?=$trad['table_blase']?>
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":-S")?>
              </td>
              <td class="monospace">
                :-S
              </td>
              <td rowspan="2">
                <?=$trad['table_gene']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :-s
              </td>
            </tr>

            <tr>
              <td rowspan="2">
                <?=bbcode(":-O")?>
              </td>
              <td class="monospace">
                :-O
              </td>
              <td rowspan="2">
                <?=$trad['table_surprise']?>
              </td>
            </tr>
            <tr>
              <td class="monospace">
                :-o
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
                <?=$trad['table_perplexe']?>
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