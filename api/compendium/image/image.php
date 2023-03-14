<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../../inc/includes.inc.php';       # Core
include_once './../../../inc/bbcodes.inc.php';        # BBCodes
include_once './../../../actions/compendium.act.php'; # Actions
include_once './../../../lang/compendium.lang.php';   # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the compendium image

// Sanitize the requested url
$compendium_image_name = form_fetch_element('name', request_type: 'GET');

// Fetch the compendium image
$compendium_image = compendium_images_get(  file_name: $compendium_image_name ,
                                            format:   'api'                   );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the compendium page data as JSON

// Throw a 404 if necessary
if(!$compendium_image)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the compendium page data
echo sanitize_api_output($compendium_image);