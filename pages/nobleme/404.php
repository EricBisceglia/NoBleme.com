<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_title = "Perdus dans l'espace !";
$page_desc  = "Erreur 404 : Page non trouvée";

// Identification
$page_name_en = "Error 404: Page not found";
$page_name_fr = "Erreur 404 : Page non trouvée";
$page_url = "pages/nobleme/404";

// CSS & JS
$css = array('404');
$js  = array('404');

// Pour ne pas envoyer de soft 404
header("HTTP/1.0 404 Not Found");

// Pour trigger l'erreur 404
$this_page_is_a_404 = '';


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <br>

    <div class="indiv align_center">
      <a class="blank" href="<?=$path?>">
        <img src="<?=$path?>img/divers/404_titre_<?=string_change_case($lang, 'lowercase')?>.png" alt="Erreur 404 : Perdus dans l'espace">
      </a>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto" style="width:1000px">
      <table class="indiv">
        <tr>
          <td class="img404 noborder">
            <img class="img404left" src="<?=$path?>img/divers/404_gauche.png" alt=" ">
          </td>
          <td class="noborder">
            <textarea class="indiv text404" rows="10" id="text404" readonly></textarea>
          </td>
          <td class="img404 noborder">
            <img class="img404right" src="<?=$path?>img/divers/404_droite.gif" alt=" ">
          </td>
        </tr>
      </table>
    </div>

    <br>
    <br>
    <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';