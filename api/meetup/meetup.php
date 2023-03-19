<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/meetups.act.php';     # Actions




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the meetup

// Sanitize the requested ID
$meetup_id = (int)form_fetch_element('id', request_type: 'GET', default_value: 0);

// Fetch the meetup
$meetup = meetups_get(  meetup_id:  $meetup_id ,
                        format:     'api'     );



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the meetup as JSON

// Throw a 404 if necessary
if(!$meetup)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the meetup
echo sanitize_api_output($meetup);