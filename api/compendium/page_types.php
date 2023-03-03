<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of compendium page types

$compendium_types_list = compendium_types_list( format: 'api' );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the compendium page types list list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the compendium page types
echo sanitize_api_output($compendium_types_list);