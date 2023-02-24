<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../inc/includes.inc.php';   # Core
include_once './../actions/users.act.php';  # Actions
include_once './../lang/users.lang.php';    # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of users

// Get the search parameters
$users_search_admins  = (int)(bool)form_fetch_element('admins', request_type: 'GET', default_value: false);
$users_search_created = form_fetch_element('created', request_type: 'GET', default_value: 0);

// Filter which quotes should be shown
$users_list_search = array( 'admins'  => $users_search_admins   ,
                            'created' => $users_search_created  );

// Get the sorting order
$users_sort = form_fetch_element('sort', request_type: 'GET', default_value: '');

// Fetch the list of users
$users_list = users_list_api( search:   $users_list_search  ,
                              sort_by:  $users_sort         );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the quote list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the quotes
echo sanitize_api_output($users_list);