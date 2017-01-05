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
$header_submenu   = 'nbrpg';

// Titre et description
$page_titre = "NBRPG - Administration";

// Identification
$page_nom = "admin";
$page_id  = "admin";

// JS
$js = array("dynamique");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/nbrpg.png" alt="NoBlemeRPG">
    </div>
    <br>

    <script>
    window.addEventListener("DOMContentLoaded", function() {
      window.setInterval(function(){ dynamique('<?=$chemin?>','xhr/admin_table_session','table_session', 'xhr') }, 2000);
    }, false);
    </script>

    <div class="body_main smallsize">
      <div id="table_session">
        Chargement du contenu...
      </div>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';