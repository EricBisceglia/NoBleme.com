<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../inc/includes.inc.php';     # Core
include_once './../actions/meetups.act.php';  # Actions
include_once './../lang/meetups.lang.php';    # Translations
include_once './../inc/bbcodes.inc.php';      # BBCodes




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of meetups

// Get the search parameters
$meetups_search_user      = form_fetch_element('user_id', request_type: 'GET');
$meetups_search_lang      = form_fetch_element('language', request_type: 'GET');
$meetups_search_year      = form_fetch_element('year', request_type: 'GET');
$meetups_search_location  = form_fetch_element('location', request_type: 'GET');
$meetups_search_attendees = form_fetch_element('attendees', request_type: 'GET');

// Filter which meetups should be shown
$meetups_list_search = array( 'attendee'  => $meetups_search_user       ,
                              'lang_api'  => $meetups_search_lang       ,
                              'date'      => $meetups_search_year       ,
                              'location'  => $meetups_search_location   ,
                              'people'    => $meetups_search_attendees  );

// Fetch the list of meetups
$meetups_list = meetups_list( search: $meetups_list_search  ,
                              format: 'api'                 );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the meetups list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the meetups
echo sanitize_api_output($meetups_list);