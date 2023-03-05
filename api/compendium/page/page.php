<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../../inc/includes.inc.php';       # Core
include_once './../../../inc/bbcodes.inc.php';        # BBCodes
include_once './../../../inc/functions_time.inc.php'; # Time management
include_once './../../../actions/compendium.act.php'; # Actions
include_once './../../../lang/compendium.lang.php';   # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the compendium page

// Sanitize the requested ID
$compendium_page_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the compendium page
$compendium_page = compendium_pages_get(  page_id:  $compendium_page_id ,
                                          format:   'api'               );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the compendium page data as JSON

// Throw a 404 if necessary
if(!$compendium_page)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the compendium page data
echo sanitize_api_output($compendium_page);