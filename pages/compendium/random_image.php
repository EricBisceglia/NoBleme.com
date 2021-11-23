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
$page_url         = "pages/compendium/random_image";
$page_title_en    = "Compendium: Random image";
$page_title_fr    = "Compendium : Image au hasard";
$page_description = "A random image from NoBleme's 21st century compendium";

// Temporarily closed
if(!$is_admin)
  exit(header("Location: ".$path."pages/compendium/index_closed"));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Redirect to a random page

// Fetch a random page
$random_compendium_image = compendium_images_get_random((int)form_fetch_element('id', request_type: 'GET'));

// Redirect to the random page
exit(header("Location: ".$path."pages/compendium/image?name=".$random_compendium_image));