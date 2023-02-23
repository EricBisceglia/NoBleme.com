<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCOdes
include_once './../../actions/users.act.php';       # Actions
include_once './../../lang/users.lang.php';         # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the user

// Sanitize the requested ID
$user_id = (int)form_fetch_element('id', request_type: 'GET', default_value: 0);

// Fetch the user
$user_get = users_get(  user_id:  $user_id  ,
                        format:   'api'     );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the quote list as JSON

// Throw a 404 if necessary
if(!$user_get)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the quotes
echo sanitize_api_output($user_get);