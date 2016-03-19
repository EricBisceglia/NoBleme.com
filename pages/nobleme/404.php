<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Perdus dans l'espace !";
$page_desc  = "Erreur 404 : Page non trouvée";

// Identification
$page_nom = "erreur";
$page_id  = "404";

// CSS & JS
$css = array('404');
$js  = array('404');

// Pour ne pas envoyer de soft 404
header("HTTP/1.0 404 Not Found");

// Pour trigger l'erreur 404
$cette_page_est_404 = '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <br>
    <div class="indiv align_center">
      <a class="blank" href="<?=$chemin?>">
        <img src="<?=$chemin?>img/logos/404.png" alt="Erreur 404 : Perdus dans l'espace">
      </a>
    </div>
    <br>
    <br>
    <br>
    <br>

    <div class="margin_auto bigsize">
      <table class="indiv">
        <tr>
          <td class="img404">
            <img class="img404gauche" src="<?=$chemin?>img/divers/404_gauche.png" alt=" ">
          </td>
          <td>
            <script type="text/javascript">
              document.write('<textarea class="indiv texte404" rows="10" id="text404" readonly></textarea>');
              // Cette ruse est pour que la balise noscript qui suive soit validée WC3 :>
            </script>
            <noscript>
              <textarea class="indiv texte404" rows="10" id="text404" readonly>





Erreur 404 : 'Zig' introuvable</textarea>
            </noscript>
          </td>
          <td class="img404">
            <img class="img404droite" src="<?=$chemin?>img/divers/404_droite.gif" alt=" ">
          </td>
        </tr>
      </table>
    </div>

    <br>
    <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';