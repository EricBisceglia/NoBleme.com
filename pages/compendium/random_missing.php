<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/random_missing";
$page_title_en    = "Compendium: Random missing page";
$page_title_fr    = "Compendium : Page manquante au hasard";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Redirect to a random missing page

// Fetch a random missing page
$random_missing_page = compendium_missing_get_random((int)form_fetch_element('id', request_type: 'GET'));

// Redirect to the random missing page
exit(header("Location: ".$path."pages/compendium/page_missing?id=".$random_missing_page));