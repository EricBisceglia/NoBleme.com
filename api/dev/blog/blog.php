<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../../inc/includes.inc.php';       # Core
include_once './../../../inc/functions_time.inc.php'; # Time management
include_once './../../../actions/dev.act.php';        # Actions
include_once './../../../lang/dev.lang.php';          # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the devblog

// Sanitize the requested ID
$devblog_id = (int)form_fetch_element('id', request_type: 'GET', default_value: 0);

// Fetch the devblog
$devblog = dev_blogs_get( blog_id:  $devblog_id ,
                          format:   'api'       );



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the devblog as JSON

// Throw a 404 if necessary
if(!$devblog)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the devblog
echo sanitize_api_output($devblog);