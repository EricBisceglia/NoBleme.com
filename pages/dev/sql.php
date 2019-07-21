<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// Inclusions /*******************************************************************************************************/
include_once './../../inc/queries.inc.php';  // Queries awaiting execution
include_once './../../inc/includes.inc.php'; // Common inclusions

// Limit page access based on user rights
user_restrict_to_users($lang);

// Change the display of header menus
$header_menu      = 'Dev';
$header_sidemenu  = 'MajRequetes';

// Page title and description
$page_titre = "Dev: Requêtes SQL";

// Internal page identification
$page_nom = "Administre secrètement le site";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              HTML : DISPLAY THE DATA                                              */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

      <br>
      <br>
      <br>
      <br>
      <br>
      <br>

      <div class="texte">

        <h1 class="positif texte_blanc align_center">LES REQUÊTES ONT ÉTÉ EFFECTUÉES AVEC SUCCÈS</h1>

      </div>

      <br>
      <br>
      <br>
      <br>
      <br>


<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF HTML                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';