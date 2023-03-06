<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../inc/bbcodes.inc.php';           # BBCodes
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../inc/functions_numbers.inc.php'; # Number formatting
include_once './../../actions/compendium.act.php';    # Actions




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of compendium pages

// Get the search parameters
$pages_search_redirect  = form_fetch_element('include_redirections', request_type: 'GET', default_value: false);
$pages_search_no_nsfw   = form_fetch_element('exclude_nsfw', request_type: 'GET', default_value: false);
$pages_search_url       = form_fetch_element('url', request_type: 'GET');
$pages_search_title_en  = form_fetch_element('title_en', request_type: 'GET');
$pages_search_title_fr  = form_fetch_element('title_fr', request_type: 'GET');
$pages_search_body_en   = form_fetch_element('contents_en', request_type: 'GET');
$pages_search_body_fr   = form_fetch_element('contents_fr', request_type: 'GET');
$pages_search_type      = form_fetch_element('type', request_type: 'GET');
$pages_search_era       = form_fetch_element('era', request_type: 'GET');
$pages_search_category  = form_fetch_element('category', request_type: 'GET');

// Filter which pages should be shown
$pages_list_search = array( 'include_redirections'  => $pages_search_redirect ,
                            'exclude_nsfw'          => $pages_search_no_nsfw  ,
                            'url'                   => $pages_search_url      ,
                            'title_en'              => $pages_search_title_en ,
                            'title_fr'              => $pages_search_title_fr ,
                            'body_en'               => $pages_search_body_en  ,
                            'body_fr'               => $pages_search_body_fr  ,
                            'type'                  => $pages_search_type     ,
                            'era'                   => $pages_search_era      ,
                            'category'              => $pages_search_category );

// Get the sorting order
$compendium_pages_sort = form_fetch_element('sort', request_type: 'GET', default_value: '');

// Fetch the list of pages
$compendium_pages_list = compendium_pages_list( search:   $pages_list_search      ,
                                                sort_by:  $compendium_pages_sort  ,
                                                format:   'api'                   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the compendium page list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the compendium page list
echo sanitize_api_output($compendium_pages_list);