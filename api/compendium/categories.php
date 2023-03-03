<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../actions/compendium.act.php';  # Actions




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of compendium categories

$compendium_categories_list = compendium_categories_list( format: 'api' );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the compendium category list list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the compendium categories
echo sanitize_api_output($compendium_categories_list);