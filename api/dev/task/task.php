<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../../inc/includes.inc.php';               # Core
include_once './../../../inc/bbcodes.inc.php';                # BBCodes
include_once './../../../inc/functions_time.inc.php';         # Time management
include_once './../../../inc/functions_numbers.inc.php';      # Number formatting
include_once './../../../inc/functions_mathematics.inc.php';  # Mathematics
include_once './../../../actions/tasks.act.php';              # Actions
include_once './../../../lang/tasks.lang.php';                # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the task

// Sanitize the requested ID
$task_id = (int)form_fetch_element('id', request_type: 'GET', default_value: 0);

// Fetch the task
$task = tasks_get(  task_id:  $task_id  ,
                    format:   'api'     );



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the task as JSON

// Throw a 404 if necessary
if(!$task)
  exit(header("HTTP/1.0 404 Not Found"));

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the task
echo sanitize_api_output($task);