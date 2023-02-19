<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../inc/includes.inc.php';   # Core
include_once './../actions/quotes.act.php'; # Actions
include_once './../lang/quotes.lang.php';   # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of quotes

// Get the search parameters
$quotes_search_lang = form_fetch_element('lang', request_type: 'GET', default_value: 'ENFR');
$quotes_search_en   = str_contains($quotes_search_lang, 'EN');
$quotes_search_fr   = str_contains($quotes_search_lang, 'FR');
$quotes_search_body = form_fetch_element('search', request_type: 'GET', default_value: NULL);
$quotes_search_user = form_fetch_element('user_id', request_type: 'GET', default_value: 0);
$quotes_search_year = form_fetch_element('year', request_type: 'GET', default_value: 0);

// Filter which quotes should be shown
$quotes_list_search = array(  'lang_en' => $quotes_search_en    ,
                              'lang_fr' => $quotes_search_fr    ,
                              'body'    => $quotes_search_body  ,
                              'user'    => $quotes_search_user  ,
                              'year'    => $quotes_search_year  );

// Fetch the list of quotes
$quotes_list = quotes_list( search:     $quotes_list_search,
                            is_for_api: true);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the quote list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the quotes
echo sanitize_api_output($quotes_list);