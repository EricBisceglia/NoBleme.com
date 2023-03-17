<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/bbcodes.inc.php';               # BBCodes
include_once './../../inc/functions_time.inc.php';        # Time management
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../actions/tasks.act.php';             # Actions
include_once './../../lang/tasks.lang.php';               # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of tasks

// Get the search parameters
$tasks_search_open      = (int)(bool)form_fetch_element('open', request_type: 'GET', default_value: false);
$tasks_search_title_en  = form_fetch_element('title_en', request_type: 'GET');
$tasks_search_title_fr  = form_fetch_element('title_fr', request_type: 'GET');
$tasks_search_reporter  = form_fetch_element('reporter_id', request_type: 'GET', default_value: 0);

// Filter which quotes should be shown
$tasks_list_search = array( 'open'        => $tasks_search_open     ,
                            'title_en'    => $tasks_search_title_en ,
                            'title_fr'    => $tasks_search_title_fr ,
                            'reporter_id' => $tasks_search_reporter );

// Fetch the list of tasks
$tasks_list = tasks_list( search:   $tasks_list_search  ,
                          format:   'api'               );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the tasks list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the tasks
echo sanitize_api_output($tasks_list);