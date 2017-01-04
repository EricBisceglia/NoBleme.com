<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'admin';
$header_submenu   = 'dev';
$header_sidemenu  = 'css';

// Titre
$page_titre = "Dev : Référence CSS";

// Identification
$page_nom = "admin";

// CSS
$css = array('admin');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <br>

    <div class="margin_auto css_couleurs monospace">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">NOBLEME.CSS</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur" onClick="window.location.hash='#couleurs';">
            Couleurs
          </td>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur" onClick="window.location.hash='#generaux';">
            Tags généraux
          </td>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur" onClick="window.location.hash='#cadregris';">
            Cadre gris
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur" onClick="window.location.hash='#sections';">
            Sections
          </td>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur" onClick="window.location.hash='#spec';">
            Tags spécifiques
          </td>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur" onClick="window.location.hash='#datainput';">
            Data input
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur">
            &nbsp;
          </td>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur">
            &nbsp;
          </td>
          <td class="cadre_gris_sous_titre moinsgros spaced pointeur" onClick="window.location.hash='#bodymain';">
            Body main
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto css_couleurs monospace" id="couleurs">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="2">COULEURS</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">Tag</td>
          <td class="cadre_gris_sous_titre moinsgros">Effet</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.blanc</td>
          <td class="cadre_gris align_center blanc">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.nobleme_background</td>
          <td class="cadre_gris align_center nobleme_background">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.nobleme_clair</td>
          <td class="cadre_gris align_center nobleme_clair">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.nobleme_fonce</td>
          <td class="cadre_gris align_center nobleme_fonce">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.noir</td>
          <td class="cadre_gris align_center noir">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.mise_a_jour_background</td>
          <td class="cadre_gris align_center mise_a_jour_background">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.sysop</td>
          <td class="cadre_gris align_center sysop">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.mise_a_jour</td>
          <td class="cadre_gris align_center mise_a_jour">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.erreur</td>
          <td class="cadre_gris align_center erreur">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.vert_background_clair</td>
          <td class="cadre_gris align_center vert_background_clair">&nbsp;</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.vert_background</td>
          <td class="cadre_gris align_center vert_background">&nbsp;</td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">.texte_blanc</td>
          <td class="cadre_gris align_center gras texte_blanc">Texte coloré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.texte_nobleme_clair</td>
          <td class="cadre_gris align_center gras texte_nobleme_clair">Texte coloré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.texte_nobleme_fonce</td>
          <td class="cadre_gris align_center gras texte_nobleme_fonce">Texte coloré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.texte_noir</td>
          <td class="cadre_gris align_center gras texte_noir">Texte coloré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.texte_sysop</td>
          <td class="cadre_gris align_center gras texte_sysop">Texte coloré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.texte_mise_a_jour</td>
          <td class="cadre_gris align_center gras texte_mise_a_jour">Texte coloré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.texte_erreur</td>
          <td class="cadre_gris align_center gras texte_erreur">Texte coloré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.texte_vert</td>
          <td class="cadre_gris align_center gras texte_vert">Texte coloré</td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto css_couleurs monospace" id="generaux">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="2">TAGS GÉNÉRAUX</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">Tag</td>
          <td class="cadre_gris_sous_titre moinsgros">Effet</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.align_center</td>
          <td class="cadre_gris align_center">Contenu centré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.align_left</td>
          <td class="cadre_gris align_left">Contenu aligné à gauche</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.align_right</td>
          <td class="cadre_gris align_right">Contenu aligné à droite</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><br>.valign_top<br><br></td>
          <td class="cadre_gris align_center valign_top">Contenu aligné en haut</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><br>.valign_middle<br><br></td>
          <td class="cadre_gris align_center valign_middle">Contenu aligné au milieu</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><br>.valign_bottom<br><br></td>
          <td class="cadre_gris align_center valign_bottom">Contenu aligné en haut</td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">.margin_auto</td>
          <td class="cadre_gris"><div class="margin_auto indiv css_exemple align_center">Div à largeur fixe centré</div></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.indiv</td>
          <td class="cadre_gris align_center" rowspan="2">Occupe tout son conteneur</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.intable</td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">.gras</td>
          <td class="cadre_gris align_center gras">Gras</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.italique</td>
          <td class="cadre_gris align_center italique">Italique</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.souligne</td>
          <td class="cadre_gris align_center souligne">Souligné</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.barre</td>
          <td class="cadre_gris align_center barre">Barré</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.maigre</td>
          <td class="cadre_gris align_center maigre">Maigre</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.moinsgros</td>
          <td class="cadre_gris align_center moinsgros">Moins gros</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.gros</td>
          <td class="cadre_gris align_center gros">Gros</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.monospace</td>
          <td class="cadre_gris align_center">Monospace</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.pointeur</td>
          <td class="cadre_gris align_center pointeur">Hover pointeur</td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">.alinea</td>
          <td class="cadre_gris align_left alinea">Ne colle pas à gauche</td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center" rowspan="2">.spaced</td>
          <td class="cadre_gris align_left spaced">Ne colle pas au bord</td>
        </tr>
        <tr>
          <td class="cadre_gris align_right spaced">Ne colle pas au bord</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center" rowspan="2">.nowrap</td>
          <td class="cadre_gris align_center nowrap">Jamais de line break même si ça dépasse</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center nowrap">Étire son conteneur à droite</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center">.wrap</td>
          <td class="cadre_gris align_center pre-wrap">Force un retour à la ligne quand le texte dépasse la taille du conteneur</td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">.hidden</td>
          <td class="cadre_gris align_left">Contenu invisible</td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto css_couleurs monospace" id="spec">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="2">TAGS SPÉCIFIQUES</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">Tag</td>
          <td class="cadre_gris_sous_titre moinsgros">Effet</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>a</b>.blank</td>
          <td class="cadre_gris align_center"><a class="blank" href=" ">Lien camouflé</a></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>a</b>.dark</td>
          <td class="cadre_gris align_center"><a class="dark" href=" ">Lien sombre</a></td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center"><b>ul</b>.dotlist</td>
          <td class="cadre_gris align_center"><ul class="dotlist"><li>Liste à puces</li></ul></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>li</b>.spaced</td>
          <td class="cadre_gris align_center"><ul><li class="spaced">Liste à puces qui respire</li></ul></td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center"><b>input</b>.discret</td>
          <td class="cadre_gris align_center"><input class="discret align_center indiv nobleme_background" value="Input camouflé"></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>select</b>.discret</td>
          <td class="cadre_gris align_center"><select class="discret align_center indiv nobleme_background"><option>Select camouflé</option></select></td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center"><b>ins</b></td>
          <td class="cadre_gris align_center"><ins>&nbsp;Contenu ajouté&nbsp;</ins></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>del</b></td>
          <td class="cadre_gris align_center"><del>&nbsp;Contenu supprimé&nbsp;</del></td>
        </tr>

        <tr>
          <td class="cadre_gris_vide" colspan="2"></td>
        </tr>

        <tr>
          <td class="cadre_gris align_center"><b>hr</b>.points</td>
          <td class="cadre_gris align_center"><hr class="points">Ligne pointillée<hr class="points"></td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto css_couleurs monospace" id="cadregris">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="2">TABLE: CADRE GRIS</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">Tag</td>
          <td class="cadre_gris_sous_titre moinsgros">Effet</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>table</b>.cadre_gris</td>
          <td class="cadre_gris"><table class="cadre_gris indiv"><tr><td class="align_center">Table avec cadre gris</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>tbody</b>.cadre_gris_altc<br><b>tbody</b>.cadre_gris_altc2</td>
          <td class="cadre_gris"><table class="cadre_gris indiv"><tr><td class="align_center blanc">Une rangée sur deux</td></tr><tr><td class="align_center">sera en gris clair</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.cadre_gris</td>
          <td class="cadre_gris"><table class="indiv"><tr><td class="cadre_gris align_center">Case avec cadre gris</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.cadre_gris_titre</td>
          <td class="cadre_gris"><table class="indiv"><tr><td class="cadre_gris_titre">Case avec titre</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.cadre_gris_sous_titre</td>
          <td class="cadre_gris"><table class="indiv"><tr><td class="cadre_gris_sous_titre align_center">Case avec sous-titre</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.cadre_gris_haut</td>
          <td class="cadre_gris"><table class="indiv"><tr><td class="cadre_gris_haut align_center">Case plus haute</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.cadre_gris_vide</td>
          <td class="cadre_gris"><table class="indiv"><tr><td class="cadre_gris_vide"></td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.cadre_gris_vide_discret</td>
          <td class="cadre_gris blanc"><table class="indiv"><tr><td class="cadre_gris_vide_discret"></td></tr></table></td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto css_table monospace" id="datainput">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="2">TABLE: DATA INPUT</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">Tag</td>
          <td class="cadre_gris_sous_titre moinsgros">Effet</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>table</b>.data_input</td>
          <td class="cadre_gris"><table class="data_input indiv"><tr><td class="align_center">Table contenant des formulaires</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.data_input_right</td>
          <td class="cadre_gris"><table class="data_input indiv"><tr><td class="data_input_right">Table contenant des formulaires</td></tr></table></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>td</b>.data_input_left</td>
          <td class="cadre_gris"><table class="data_input indiv"><tr><td class="data_input_left">Table contenant des formulaires</td></tr></table></td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto css_sections monospace" id="sections">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="2">SECTIONS DE CONTENU</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">Tag</td>
          <td class="cadre_gris_sous_titre moinsgros">Effet</td>
        </tr>
         <tr>
          <td class="cadre_gris align_center"><b>div</b>.smallsize</td>
          <td class="cadre_gris align_center"><br><div class="nobleme_clair margin_auto smallsize"><br>Section de petite taille<br><br></div><br></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>div</b>.midsize</td>
          <td class="cadre_gris align_center"><br><div class="nobleme_clair margin_auto midsize"><br>Section de taille moyenne<br><br></div><br></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>div</b>.bigsize</td>
          <td class="cadre_gris align_center"><br><div class="nobleme_clair margin_auto bigsize"><br>Section de grande taille<br><br></div><br></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>div</b>.limited</td>
          <td class="cadre_gris align_center"><br><div class="limited"><br><br><br><br>Div<br><br><br><br><br><br>de<br><br><br><br><br><br>hauteur<br><br><br><br><br><br>limitée<br><br><br><br></div><br></td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto css_div monospace" id="bodymain">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="2">DIV : BODY MAIN</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">Tag</td>
          <td class="cadre_gris_sous_titre moinsgros">Effet</td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>div</b>.body_main</td>
          <td class="cadre_gris align_center"><br><div class="nobleme_clair margin_auto body_main smallsize">Section de contenu standard<br></div><br></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>div</b>.body_main<br>><br><b>span</b>.titre</td>
          <td class="cadre_gris align_center"><br><div class="nobleme_clair margin_auto body_main smallsize"><span class="titre">Titre dans un body_main</span><br></div><br></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>div</b>.body_main<br>><br><b>span</b>.soustitre</td>
          <td class="cadre_gris align_center"><br><div class="nobleme_clair margin_auto body_main smallsize"><span class="soustitre">Sous-titre dans un body_main</span><br></div><br></td>
        </tr>
        <tr>
          <td class="cadre_gris align_center"><b>div</b>.body_main<br>><br><b>a</b></td>
          <td class="cadre_gris align_center"><br><div class="nobleme_clair margin_auto body_main smallsize"><a href="css">Lien dans un body_main</a><br></div><br></td>
        </tr>

      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';