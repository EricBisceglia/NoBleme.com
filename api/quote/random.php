<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';   # Core
include_once './../../actions/quotes.act.php'; # Actions


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the quote

// Get extra parameters
$quote_search_lang  = form_fetch_element('language', request_type: 'GET');
$quote_search_nsfw  = form_fetch_element('nsfw', request_type: 'GET');
$quote_search_user  = form_fetch_element('user_id', request_type: 'GET');
$quote_search_year  = form_fetch_element('year', request_type: 'GET');

// Get a random quote ID
$quote_id = quotes_get_random_id( search:   array(  'lang'  => $quote_search_lang   ,
                                                    'nsfw'  => $quote_search_nsfw   ,
                                                    'user'  => $quote_search_user   ,
                                                    'year'  => $quote_search_year ) ,
                                  context:  'api'                                   );

// Fetch the quote
$quote = quotes_get(  quote_id: $quote_id ,
                      format:   'api'     );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the quote as JSON

// Throw a 404 if necessary
if(!$quote)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the quotes
echo sanitize_api_output($quote);