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

// Sanitize the requested ID
$quote_id = (int)form_fetch_element('id', request_type: 'GET', default_value: 0);

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