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
$header_sidemenu  = 'charte';

// Titre
$page_titre = "Dev : Charte graphique";

// Identification
$page_nom = "admin";

// CSS & JS
$css = array('admin');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>

    <div class="margin_auto css_couleurs monospace">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">PALETTE DE COULEURS NOBLEMEUSES</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">CSS</td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Hex</td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">RGB</td>
        </tr>
        <tr>
          <td class="cadre_gris_haut align_center nobleme_background gras">nobleme_background</td>
          <td class="cadre_gris_haut align_center nobleme_background gras">#E9E9E9</td>
          <td class="cadre_gris_haut align_center nobleme_background gras">233 233 233</td>
        </tr>
        <tr>
          <td class="cadre_gris_haut align_center nobleme_clair gras">nobleme_clair</td>
          <td class="cadre_gris_haut align_center nobleme_clair gras">#7F9DB1</td>
          <td class="cadre_gris_haut align_center nobleme_clair gras">127 157 177</td>
        </tr>
        <tr>
          <td class="cadre_gris_haut align_center nobleme_fonce gras texte_blanc">nobleme_fonce</td>
          <td class="cadre_gris_haut align_center nobleme_fonce gras texte_blanc">#2F4456</td>
          <td class="cadre_gris_haut align_center nobleme_fonce gras texte_blanc">47 68 86</td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>

    <div class="margin_auto css_couleurs monospace">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros">FORMATTAGE DES BOUTONS</td>
        </tr>
        <tr>
          <td class="cadre_gris blanc cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/boutons/dev1.png" alt=" "><br>
            <br>
            <img src="<?=$chemin?>img/boutons/dev2.png" alt=" "><br>
            <br>
            <img src="<?=$chemin?>img/boutons/dev3.png" alt=" ">
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>

    <div class="margin_auto midsize monospace">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros">POLICES DES LOGOS</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">ACTIVITÉ RÉCENTE / QUI EST EN LIGNE : <u>PHRASTIC MEDIUM</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/activite.png" alt=" ">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">ADMINISTRATION / NEUTRE / ERREUR : <u>FIXEDSYS</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/administration.png" alt=" ">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">ANNIVERSAIRES : <u>FLUBBER</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/anniversaires.png" alt=" ">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">BANNISSEMENT / PUNITION : <u>AR DARLING</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/banned.png" alt=" " width="750">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">DÉVELOPPEMENT / DEVBLOG : <u>ALIEN ENCOUNTERS</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/developpement.png" alt=" ">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">INDEX / CATCHPHRASE: <u>SEGOE UI</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/index.png" alt=" ">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">IRC : <u>TERMINATOR TWO</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/irc.png" alt=" " width="750">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">IRL : <u>COMIC SANS MS</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/irl.png" alt=" ">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">LISTE DES MEMBRES : <u>BOLSTER BOLD</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut">
            <img src="<?=$chemin?>img/logos/liste_membres.png" alt=" " width="750">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">MISCELLANÉES : <u>WHIMSY TT</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/miscellanees.png" alt=" " width="750">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">NOBLEMERPG : <u>BREATHE FIRE</u> + <u>DPOLY TWENTY SIDER</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/nbrpg.png" alt=" ">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">PROFIL / MESSAGES PRIVÉS : <u>X-FILES</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/profil.png" alt=" " width="750">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">LISTE DES TÂCHES / PLAN DE ROUTE : <u>CRACKED JOHNNIE</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/todo.png" alt=" " width="750">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut gros">SECRETS : <u>IMPACT</u></td>
        </tr>
        <tr>
          <td class="cadre_gris nobleme_background cadre_gris_haut align_center">
            <img src="<?=$chemin?>img/logos/secret.png" alt=" ">
          </td>
        </tr>

      </table>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto midsize monospace">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris cadre_gris_haut gros gras align_center nobleme_clair texte_nobleme_fonce">
            TOUS LES LOGOS DU HEADER (584x70px)
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_titre">

            <?php for($i=1;file_exists($chemin.'img/logos/nobleme_'.$i.'.png');$i++) { ?>
            <img src="<?=$chemin?>img/logos/nobleme_<?=$i?>.png" alt=" "><br>
            <br>
            <?php } ?>

          </td>
        </tr>

      </table>
    </div>



<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';