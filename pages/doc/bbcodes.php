<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = '';
$header_submenu   = 'aide';
$header_sidemenu  = 'bbcodes';

// Titre et description
$page_titre = "Doc : BBCodes";
$page_desc  = "Documentation illustrée des balises de formatage de texte sur NoBleme";

// Identification
$page_nom = "doc";
$page_id  = "bbcodes";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remplir la prévisulation des commentaires si nécessaire

$preview_bbcodes  = isset($_POST['bbcodes_test']) ? $_POST['bbcodes_test'] : '';
$preview_traite   = isset($_POST['bbcodes_test']) ? bbcode(destroy_html(nl2br_fixed($_POST['bbcodes_test']))) : '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/doc/">
        <img src="<?=$chemin?>img/logos/documentation.png" alt="Documentation">
      </a>
    </div>
    <br>



    <div class="body_main midsize">
      <span class="titre">Utilisation des BBCodes</span><br>
      <br>
      Le système de balises que les messages postés sur NoBleme utilisent pour la mise en forme s'appellent des <a href="https://fr.wikipedia.org/wiki/Bbcode">BBCodes</a>.<br>
      <br>
      A l'instar du <a href="https://fr.wikipedia.org/wiki/HTML" target="_blank">HTML</a> ou d'autres <a href="https://fr.wikipedia.org/wiki/Langage_de_balisage" target="_blank">langages de balisage</a>, un texte est mis en forme en mettant une balise de BBCode avant le début du texte que vous voulez mettre en forme, puis une seconde balise à la fin du texte.<br>
      <br>
      Ci-dessous, une liste des BBCodes disponibles sur NoBleme, avec un ou plusieurs exemples pour chacun d'entre eux.
    </div>

    <br>
    <br>

    <div class="body_main midsize margin_auto">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Effet
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Balises
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Exemple d'utilisation des balises
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Résultat de l'exemple
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras">
            Gras
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [b] [/b]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            Mon texte [b]en gras[/b]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("Mon texte [b]en gras[/b]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras">
            Italique
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [i] [/i]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            Un peu [i]d'italique[/i] ici
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("Un peu [i]d'italique[/i] ici")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras">
            Souligné
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [u] [/u]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [u]Je souligne[/u] ma phrase
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[u]Je souligne[/u] ma phrase")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras">
            Barré
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [s] [/s]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [s]Je barre ceci[/s]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[s]Je barre ceci[/s]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras" rowspan="2">
            Lien
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            [url] [/url]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [url]http://www.nobleme.com[/url]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[url]http://www.nobleme.com[/url]")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            [url=http://www.nobleme.com] NoBleme [/url] est cool
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[url=http://www.nobleme.com]NoBleme[/url] est cool")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras">
            Image
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [img] [/img]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [img]http://nobleme.com/favicon.ico[/img]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[img]http://nobleme.com/favicon.ico[/img]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras" rowspan="3">
            Alignement
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="3">
            [align] [/align]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [align=left]À gauche[/align]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[align=left]À gauche[/align]")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            [align=center]Au centre[/align]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[align=center]Au centre[/align]")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            [align=right]À droite[/align]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[align=right]À droite[/align]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras" rowspan="2">
            Couleur
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            [color] [/color]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [color=green]Nom de couleur en anglais[/color]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[color=green]Nom de couleur en anglais[/color]")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            [color=#7F9DB1]Ou en hexadécimal[/color]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[color=#7F9DB1]Ou en hexadécimal[/color]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras" rowspan="2">
            Taille
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            [size] [/size]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [size=0.7]70% de la taille normale[/size]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[size=0.7]70% de la taille normale[/size]")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            [size=1.3]130% de la taille normale[/size]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[size=1.3]130% de la taille normale[/size]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras">
            Texte flouté
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [flou] [/flou]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [flou]Passez la souris sur ce texte[/flou]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[flou]Passez la souris sur ce texte[/flou]")?>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras" rowspan="2">
            Texte caché
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            [spoiler] [/spoiler]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [spoiler]L'assassin est le juge[/spoiler]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[spoiler]L'assassin est le juge[/spoiler]")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            [spoiler=Star Wars]Han Solo a tiré le premier[/spoiler]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[spoiler=Star Wars]Han Solo a tiré le premier[/spoiler]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras" rowspan="2">
            Citation
          </td>
          <td class="cadre_gris cadre_gris_haut align_center" rowspan="2">
            [quote] [/quote]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [quote]Un tiens vaut mieux que deux tu l'auras[/quote]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[quote]Un tiens vaut mieux que deux tu l'auras[/quote]")?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_haut align_center">
            [quote=Bad]Ceci a été écrit par Bad[/quote]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[quote=Bad]Ceci a été écrit par Bad[/quote]")?>
          </td>
        </tr>


        <tr>
          <td class="cadre_gris cadre_gris_haut align_center gras">
            Code
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            [code] [/code]
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <pre>[code]Préserve        l'espacement[/code]</pre>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center">
            <?=bbcode("[code]Préserve        l'espacement[/code]")?>
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>

    <div class="body_main bigsize">
      <span class="titre">Détails bons à savoir sur les BBCodes</span><br>
      <br>
      <hr>
      <br>
      <span class="soustitre">Les BBCodes peuvent se combiner</span><br>
      <br>
      Texte en [b]gras et [i]italique et [u]souligné[/u][/i][/b]<br>
      <?=bbcode("Texte en [b]gras et [i]italique et [u]souligné[/u][/i][/b]")?><br>
      <br>
      <hr>
      <br>
      <span class="soustitre">Les citations peuvent être imbriquées à l'infini</span><br>
      <br>
      [quote=Personne A]Comme l'a dit Personne B, [quote=Personne B]Pour citer Personne C, [quote=Personne C]Le fond de l'air est frais[/quote][/quote]Fou, non?[/quote]<br>
      <br>
      <?=bbcode("[quote=Personne A]Comme l'a dit Personne B, [quote=Personne B]Pour citer Personne C, [quote=Personne C]Le fond de l'air est frais[/quote][/quote]Fou, non?[/quote]")?>
      <br>
      <hr>
      <br>
      <span class="soustitre">Les spoilers ne peuvent pas s'imbriquer</span><br>
      <br>
      [spoiler]Spoiler dans un[spoiler]spoiler[/spoiler]ne marche pas[/spoiler]<br>
      <br>
      <?=bbcode("[spoiler]Spoiler dans un[spoiler]spoiler[/spoiler]ne marche pas[/spoiler]")?><br>
      <br>
      [spoiler]Mais une citation dans un spoiler [quote]fonctionne correctement[/quote][/spoiler]<br>
      <br>
      <?=bbcode("[spoiler]Mais une citation dans un spoiler [quote]fonctionne correctement[/quote][/spoiler]")?><br>
      Ce comportement devrait être changé tôt ou tard et les spoilers pourront s'imbriquer les uns dans les autres. Ce n'est pas une urgence, mais ce sera fait un jour.
    </div>

    <br>
    <br>

    <?php if(isset($_POST["bbcodes_go_x"]) && $preview_bbcodes != "") { ?>

    <div class="body_main midsize margin_auto" id="test">
      <span class="moinsgros gras alinea">Résultat de l'expérimentation :</span><br>
      <br>
      <?=$preview_traite?>
    </div>

    <br>
    <br>

    <?php } ?>

    <div class="body_main midsize">
      <span class="titre">Espace d'expérimentation</span><br>
      <br>

      Vous pouvez vous servir de la zone de texte ci-dessous pour expérimenter avec les BBCodes.<br>
      Écrivez-y du texte entouré de BBCodes, appuyez sur prévisualiser, et voyez le résultat.<br>
      <br>
      Si vous manquez d'inspiration, reprenez par exemple les utilisations des BBCodes dans le tableau en haut de la page.

      <form name="todo_commentaire" method="post" action="bbcodes#test">
        <br>
        <textarea class="intable" name="bbcodes_test" rows="10"><?=$preview_bbcodes?></textarea><br>
        <br>
        <div class="align_center">
          <input type="image" src="<?=$chemin?>img/boutons/previsualiser.png" alt="PRÉVISUALISER" name="bbcodes_go">
        </div>
      </form>

    </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';