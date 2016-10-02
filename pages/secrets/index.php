<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'secrets';
$header_submenu   = 'liste';

// Titre et description
$page_titre = "Travaux";
$page_desc  = "Page en cours de travaux, revenez plus tard !";

// Identification
$page_nom = "nobleme";
$page_id  = "travaux";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/travaux.png" alt="Page en cours de travaux, revenez plus tard !">
    </div>
    <br>
    <br>
    <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';