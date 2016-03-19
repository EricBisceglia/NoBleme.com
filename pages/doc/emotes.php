<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Doc: Émoticônes";
$page_desc  = "Liste des émoticônes disponibles sur NoBleme";

// Identification
$page_nom = "doc";
$page_id  = "emotes";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/documentation.png" alt="Documentation">
    </div>
    <br>

    <div class="body_main bigsize">
      <span class="titre">Utilisation des émoticônes</span><br>
      <br>
      Les émoticônes sont des petites images amusantes qui remplacent automatiquement certaines combinaisons de caractères dans vos messages.<br>
      Elles expriment diverses émotions, et vous permettent de rendre vos messages un peu plus vivants, si vous le désirez.<br>
      <br>
      Par exemple, si vous écrivez ceci : « Oh que je ris XD »<br>
      Votre phrase sera remplacée par : « Oh que je ris <?=bbcode('XD')?> »
    </div>

    <br>

    <div class="body_main bigsize">
      <span class="titre">Source des émoticônes de NoBleme</span><br>
      <br>
      Toutes les émoticônes utilisées sur NoBleme sont prises au projet <a href="http://chatzilla.hacksrus.com/">ChatZilla</a>.<br>
      <br>
      Ce choix se justifie par l'usage de ChatZilla depuis longtemps par certains NoBlemeux sur IRC, dont les émoticônes sont devenues pour eux une habitude.<br>
      Au moment de choisir quelles émoticônes utiliser sur le site, j'ai pesé le pour et le contre de diverses options et fini par adopter celles de ChatZilla.<br>
      Ces émoticônes ont des expressions exagérées et amusantes qui donnent de la vie aux messages les plus mornes, tout en restant simples et peu nombreuses.<br>
      <br>
      ChatZilla, ainsi que le contenu qui lui est lié (incluant les émoticônes) sont protégés par la <a href="https://www.mozilla.org/MPL/2.0/">MPL (Mozilla Public Licence)</a><br>
      Cette licence autorise la réutilisation de son contenu sous diverses <a href="https://www.mozilla.org/MPL/2.0/FAQ.html">conditions et clauses</a>, que NoBleme respecte.<br>
      L'équipe de développement de ChatZilla a été contactée au sujet de l'utilisation de ces émoticônes, et a donné son autorisation tant que la licence MPL est respectée.
    </div>

    <br>

    <div class="body_main smallsize">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            RÉFÉRENCE DES ÉMOTICÔNES DE NOBLEME
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Nom
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Texte
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Résultat
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            Sourire
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center">
            :)
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode(':)')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            Heureux
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center nobleme_background">
            :D
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            <?=bbcode(':D')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            Jouissif
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center">
            :DD
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode(':DD')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background" rowspan="2">
            Rire
          </td>
          <td class="cadre_gris gras align_center nobleme_background">
            XD
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background" rowspan="2">
            <?=bbcode('xD')?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center nobleme_background">
            xD
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            Coquin
          </td>
          <td class="cadre_gris gras align_center">
            :P
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            <?=bbcode(':P')?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center">
            :p
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            Triste
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center nobleme_background">
            :(
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            <?=bbcode(':(')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            Pleure
          </td>
          <td class="cadre_gris gras align_center">
            :'(
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            <?=bbcode(":'(")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center">
            :"(
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            Mécontent
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center nobleme_background">
            ):C
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            <?=bbcode('):C')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            Colère
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center">
            ):(
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode('):(')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            Cool
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center nobleme_background">
            B)
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            <?=bbcode('B)')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            Complice
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center">
            ;-)
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode(';-)')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background" rowspan="2">
            Honte
          </td>
          <td class="cadre_gris gras align_center nobleme_background">
            :")
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background" rowspan="2">
            <?=bbcode(':")')?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center nobleme_background">
            :#
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            Rêveur
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center">
            9_9
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode('9_9')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            Blasé
          </td>
          <td class="cadre_gris cadre_gris_haut gras align_center nobleme_background">
            :|
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background">
            <?=bbcode(':|')?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            Gêné
          </td>
          <td class="cadre_gris gras align_center">
            :s
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            <?=bbcode(":s")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center">
            :S
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background" rowspan="2">
            Surprise
          </td>
          <td class="cadre_gris gras align_center nobleme_background">
            :o
          </td>
          <td class="cadre_gris cadre_gris_haut align_center nobleme_background" rowspan="2">
            <?=bbcode(':o')?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center nobleme_background">
            :O
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="4">
            Perplexe
          </td>
          <td class="cadre_gris gras align_center">
            o_O
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("o_O")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center">
            O_o
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("O_o")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center">
            o_o
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            <?=bbcode("o_o")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris gras align_center">
            O_O
          </td>
        </tr>

      </table>
    </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';