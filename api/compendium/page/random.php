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

// Fetch extra parameters
$compendium_search_type   = (int)form_fetch_element('type', request_type: 'GET', default_value: 0);
$compendium_search_nsfw   = form_fetch_element('include_nsfw', request_type: 'GET', default_value: false);
$compendium_search_lang   = form_fetch_element('language', request_type: 'GET', default_value: 'all');
$compendium_search_redir  = form_fetch_element('include_redirections', request_type: 'GET', default_value: false);

// Get a random compendium page id
$random_page_url = compendium_pages_get_random( type:                 $compendium_search_type   ,
                                                include_nsfw:         $compendium_search_nsfw   ,
                                                language:             $compendium_search_lang   ,
                                                include_redirections: $compendium_search_redir  );

// Fetch the compendium page
$compendium_page = compendium_pages_get(  page_url: $random_page_url  ,
                                          format:   'api'             );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the compendium page data as JSON

// Throw a 404 if necessary
if(!$compendium_page)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the compendium page data
echo sanitize_api_output($compendium_page);