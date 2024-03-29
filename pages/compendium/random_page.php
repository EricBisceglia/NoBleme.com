<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/random_page";
$page_title_en    = "Compendium: Random page";
$page_title_fr    = "Compendium : Page au hasard";
$page_description = "A random page from NoBleme's 21st century compendium";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Redirect to a random page

// Fetch a random page
$random_compendium_page = compendium_pages_get_random(
  exclude_id:  (int)form_fetch_element('id', request_type: 'GET')    ,
  type:        (int)form_fetch_element('type', request_type: 'GET')  );

// Redirect to the random page
exit(header("Location: ".$path."pages/compendium/".$random_compendium_page));