<?php
/***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                  These tests should only be ran through `tests.php` at the root of the project.                   */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Limit page access rights
user_restrict_to_administrators();

// Only allow this page to be ran in dev mode
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));

// Include required files
include_once './inc/activity.inc.php';
include_once './inc/bbcodes.inc.php';
include_once './inc/functions_mathematics.inc.php';
include_once './inc/functions_numbers.inc.php';
include_once './inc/functions_time.inc.php';
include_once './actions/activity.act.php';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                               inc/activity.inc.php                                                */
/*                                                                                                                   */
/*                                                   ACTIVITY LOGS                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parse an activity log

// Parse an empty log
$test_activity_log = logs_activity_parse( admins_only:  false   ,
                                          type:         'test'  );

// Expect the empty log to return no styling
$test_results['activity_parse'] = test_assert(  value:        $test_activity_log['css']           ,
                                                type:         'string'                            ,
                                                expectation:  ''                                  ,
                                                success:      'Empty activity log parsed'         ,
                                                failure:      'Empty activity log wrongly parsed' );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                inc/bbcodes.inc.php                                                */
/*                                                                                                                   */
/*                                                      BBCODES                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Parse BBCodes

// Process some BBCodes
$test = bbcodes("[b][quote=test][url]https://nobleme.com[/url][/quote][/b]");

// Define the expected result
$expectations = '<span class="bold"><div class="tinypadding_top"><div class="bbcode_quote_body"><div class="bbcode_quote_title">'.__('bbcodes_quote_by').' test'.__(':').'</div><hr class="bbcode_quote_separator"><a class="bold" href="https://nobleme.com">https://nobleme.com</a></div></div></span>';

// Expect the test to be processed properly
$test_results['bbcodes'] = test_assert( value:        $test                         ,
                                        type:         'string'                      ,
                                        expectation:  $expectations                 ,
                                        success:      "BBCodes parsed"              ,
                                        failure:      "BBCodes parsed incorrectly"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parse NBCodes

// Process some NBCodes
$test = nbcodes("[page:test|internal][image-nsfw:image.png|left|description]");

// Define the expected result
$expectations = '<a class="nbcode_dead_link noglow" href="pages/compendium/test">internal</a><div class="nbcode_floater nbcode_floater_left"><a href="pages/compendium/image?name=image.png" class="noglow"><img class="nbcode_blur_2" onmouseover="unblur(this);" src="img/compendium/image.png" alt="image.png"></a><br>description</div>';

// Expect the test to be processed properly
$test_results['nbcodes'] = test_assert( value:        $test                         ,
                                        type:         'string'                      ,
                                        expectation:  $expectations                 ,
                                        success:      "NBCodes parsed"              ,
                                        failure:      "NBCodes parsed incorrectly"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remove BBCodes

// Process some BBCodes
$test = bbcodes_remove("[b][quote=test][url]https://nobleme.com[/url][/quote][/b]");

// Define the expected result
$expectations = "test".__(':')." https://nobleme.com";

// Expect the test to be processed properly
$test_results['unbbcodes'] = test_assert( value:        $test                         ,
                                          type:         'string'                      ,
                                          expectation:  $expectations                 ,
                                          success:      "BBCodes removed"             ,
                                          failure:      "BBCodes removed incorrectly" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remove NBCodes

// Process some NBCodes
$test = nbcodes_remove("[page:test|internal][image-nsfw:image.png|left|description]");

// Define the expected result
$expectations = "internalimage.png - description
";

// Expect the test to be processed properly
$test_results['unnbcodes'] = test_assert( value:        $test                         ,
                                          type:         'string'                      ,
                                          expectation:  $expectations                 ,
                                          success:      "NBCodes removed"             ,
                                          failure:      "NBCodes removed incorrectly" );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                           inc/functions_common.inc.php                                            */
/*                                                                                                                   */
/*                                                   COMMON TOOLS                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Get the website's root path

// Get the path to the root
$test = root_path();

// Expect the root path to be correct
$test_results['root_path'] = test_assert( value:        $test                     ,
                                          type:         'string'                  ,
                                          expectation:  $path                     ,
                                          success:      "Root path is correct"    ,
                                          failure:      "Root path is incorrect"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Check for database rows or entries

// Generate a random string
$test_string = sanitize(fixtures_generate_data('string', 20, 30, no_spaces: true), 'string');

// Ensure no test entry exists
query(" DELETE FROM system_versions
        WHERE       system_versions.extension LIKE '$test_string' ");

// Create a test entry
query(" INSERT INTO system_versions
        SET         system_versions.major         = 0               ,
                    system_versions.minor         = 0               ,
                    system_versions.patch         = 0               ,
                    system_versions.extension     = '$test_string'  ,
                    system_versions.release_date  = '0000-00-00'    ");

// Get the id of the inserted row
$test_id = sanitize(query_id(), 'int', 0);

// Check for the row's existence
$test_row = database_row_exists('system_versions', $test_id);

// CHeck for the entry's existence
$test_entry = database_entry_exists('system_versions', 'extension', $test_string);

// Delete the test row
query(" DELETE FROM system_versions
        WHERE       system_versions.id = '$test_id' ");

// Check for the row's deletion
$test_no_row = database_row_exists('system_versions', $test_id);

// CHeck for the entry's existence
$test_no_entry = database_entry_exists('system_versions', 'extension', $test_string);

// Expect the row's existence to be verified
$test_results['db_exists_row'] = test_assert( value:        $test_row               ,
                                              type:         'boolean'               ,
                                              expectation:  true                    ,
                                              success:      "Row ID was found"      ,
                                              failure:      "Row ID was not found"  );

// Expect the row's deletion to be verified
$test_results['db_exists_row_not'] = test_assert( value:        $test_no_row                    ,
                                                  type:         'boolean'                       ,
                                                  expectation:  false                           ,
                                                  success:      "Row ID confirmed deleted"      ,
                                                  failure:      "Row ID not confirmed deleted"  );

// Expect the entry's existence to be verified
$test_results['db_exists_entry'] = test_assert( value:        $test_entry           ,
                                                type:         'integer'             ,
                                                expectation:  $test_id              ,
                                                success:      "Entry was found"     ,
                                                failure:      "Entry was not found" );

// Expect the entry's deletion to be verified
$test_results['db_exists_entry_not'] = test_assert( value:        $test_no_entry              ,
                                                    type:         'integer'                   ,
                                                    expectation:  0                           ,
                                                    success:      "Entry confirmed deleez"    ,
                                                    failure:      "Entry not confirmed found" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update and check system variables

// Fetch and save a system variable
$test_version = sanitize(system_variable_fetch('current_version_number_en'), 'string');

// Generate a random string
$test_string = sanitize(fixtures_generate_data('string', 20, 30, no_spaces: true), 'string');

// Update system variable with the random string
system_variable_update('current_version_number_en', $test_string, 'string');

// Fetch the system variable
$test_variable = system_variable_fetch('current_version_number_en');

// Update the system variable back to its initial value
system_variable_update('current_version_number_en', $test_version, 'string');

// Fetch it once again
$test_wrong_variable = system_variable_fetch('current_version_number_en');

// Expect the system variable to be updated
$test_results['sysvar_correct'] = test_assert(  value:        $test_variable                ,
                                                type:         'string'                      ,
                                                expectation:  $test_string                  ,
                                                success:      "System variable updated"     ,
                                                failure:      "System variable not updated" );

// Expect the system variable to be reverted
$test_results['sysvar_wrong'] = test_assert(  value:      $test_variable                          ,
                                              type:       'boolean'                               ,
                                              assertion:  $test_variable !== $test_wrong_variable ,
                                              success:    "System variable reverted"              ,
                                              failure:    "System variable not reverted"          );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemble version numbers

// Assemble a test version number
$test = system_assemble_version_number(1, 2, 3, 'fix');

// Expect the assembled version number to respect SEMVER
$test_results['version_assemble'] = test_assert(  value:        $test                       ,
                                                  type:         'string'                    ,
                                                  expectation:  "1.2.3-fix"                 ,
                                                  success:      "Version number assembled"  ,
                                                  failure:      "Version number is wrong"   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get version numbers

// Get the current version number
$test = system_get_current_version_number('full', 'en');

// Get the next version number
$test_next = system_get_current_version_number('next', 'en');

// Assemble the next version number
$test_next_full = system_assemble_version_number( major:      $test_next['major']     ,
                                                  minor:      $test_next['minor']     ,
                                                  patch:      $test_next['patch']     ,
                                                  extension:  $test_next['extension'] );

// Fetch the version number from system variables
$test_version = system_variable_fetch('current_version_number_en');

// Expect the current version number to match the one in system variables
$test_results['version_current'] = test_assert( value:        $test                       ,
                                                type:         'string'                    ,
                                                expectation:  $test_version               ,
                                                success:      "Version number fetched"    ,
                                                failure:      "Incorrect version fetched" );

// Expect the next version number to be different from the one in system variables
$test_results['version_next'] = test_assert(  value:      $test_next_full                   ,
                                              type:       'string'                          ,
                                              assertion:  $test_next_full !== $test_version ,
                                              success:    "Next version is different"       ,
                                              failure:    "Next version is not different"   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recognize xhr

// Expect the page to not be fetched dynamically
$test_results['page_is_xhr'] = test_assert( value:        page_is_fetched_dynamically() ,
                                            type:         'boolean'                     ,
                                            expectation:  false                         ,
                                            success:      "Test is not run in XHR"      ,
                                            failure:      "Test is run in XHR"          );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Acknowledge included files

// Expect functions_common.inc.php to be included
$test_results['include_file'] = test_assert(  value:        has_file_been_included('functions_common.inc.php')  ,
                                              type:         'boolean'                                           ,
                                              expectation:  true                                                ,
                                              success:      "Acknowledged included file"                        ,
                                              failure:      "Included file not acknowledged"                    );

// Expect a non existing file to not be included
$test_results['include_fail'] = test_assert(  value:        has_file_been_included('not_a_file.trash.format') ,
                                              type:         'boolean'                                         ,
                                              expectation:  false                                             ,
                                              success:      "Do not acknowledge fake file"                    ,
                                              failure:      "Fake file acknowledged"                          );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch user data

// Check the existence and the value of $_POST['dev_tests_common]
$test_exists  = form_fetch_element('dev_tests_common', element_exists: true);
$test_value   = form_fetch_element('dev_tests_common');
$test_get     = form_fetch_element('dev_tests_common', request_type: 'GET');

// Expect $_POST['dev_tests_common'] to exist when this test runs
$test_results['form_fetch_exists'] = test_assert( value:        $test_exists                  ,
                                                  type:         'boolean'                     ,
                                                  expectation:  true                          ,
                                                  success:      "Postdata element exists"     ,
                                                  failure:      "Postdata element not found"  );

// Expect $_POST['dev_tests_common'] to have a value
$test_results['form_fetch_value'] = test_assert(  value:        $test_value                         ,
                                                  type:         'string'                            ,
                                                  expectation:  'on'                                ,
                                                  success:      "Postdata element has a value"      ,
                                                  failure:      "Postdata element value incorrect"  );

// Expect $_GET['dev_tests_common'] to not exist
$test_results['form_fetch_get'] = test_assert(  value:        $test_get                       ,
                                                type:         'null'                          ,
                                                expectation:  NULL                            ,
                                                success:      "Get element does not exist"    ,
                                                failure:      "Get element should not exist"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Truncate string

// Truncate a string and add a suffix
$test = string_truncate('Simple string', 10, '...');

// Expect the string to be truncated
$test_results['string_truncate'] = test_assert( value:        $test                           ,
                                                type:         'string'                        ,
                                                expectation:  'Simple str...'                 ,
                                                success:      "String truncated"              ,
                                                failure:      "String incorrectly truncated"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Change string case

// Define a test string
$test_string = "tEsT StRiNg";

// Change the case of the test string
$test_lower     = string_change_case($test_string, 'lowercase');
$test_upper     = string_change_case($test_string, 'uppercase');
$test_initials  = string_change_case($test_string, 'initials');

// Expect the string to be lowercase
$test_results['string_lowercase'] = test_assert(  value:        $test_lower               ,
                                                  type:         'string'                  ,
                                                  expectation:  'test string'             ,
                                                  success:      "String is lowercase"     ,
                                                  failure:      "String is not lowercase" );

// Expect the string to be uppercase
$test_results['string_uppercase'] = test_assert(  value:        $test_upper               ,
                                                  type:         'string'                  ,
                                                  expectation:  'TEST STRING'             ,
                                                  success:      "String is uppercase"     ,
                                                  failure:      "String is not uppercase" );

// Expect the string to have initials
$test_results['string_initials'] = test_assert( value:        $test_initials                  ,
                                                type:         'string'                        ,
                                                expectation:  'TEsT StRiNg'                   ,
                                                success:      "String has initials"           ,
                                                failure:      "String does not have initials" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remove accents from string

// Get rid of accents in a string
$test = string_remove_accents("Accentuées çöa");

// Expect accents to be gone
$test_results['string_no_accents'] = test_assert( value:        $test                   ,
                                                  type:         'string'                ,
                                                  expectation:  'Accentuees coa'        ,
                                                  success:      "Accents removed"       ,
                                                  failure:      "Accents badly removed" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Increment string

// Increment a string
$test = string_increment("abcd1234");

// Expect the string to be incremented
$test_results['string_increment'] = test_assert(  value:        $test                       ,
                                                  type:         'string'                    ,
                                                  expectation:  'abcd1235'                  ,
                                                  success:      "String incremented"        ,
                                                  failure:      "String badly incremented"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Convert date to text

// Choose a test date
$test_date = '2005-03-19 01:02:03';

// Convert it to various formats
$test_format  = date_to_text($test_date, lang: 'EN');
$test_simple  = date_to_text($test_date, strip_day: 2, lang: 'EN', include_time: 1);

// Get today's date and convert it to text
$test        = date_to_text(lang: 'EN');
$test_today  = date('l, F jS o');

// Expect the date to be formatted
$test_results['date_to_text'] = test_assert(  value:        $test_format                ,
                                              type:         'string'                    ,
                                              expectation:  'Saturday, March 19th 2005' ,
                                              success:      "Date formatted"            ,
                                              failure:      "Date badly formatted"      );

// Expect the date to be formatted differently
$test_results['date_to_text_2'] = test_assert(  value:        $test_simple                  ,
                                                type:         'string'                      ,
                                                expectation:  ' March 2005 at 01:02:03'     ,
                                                success:      "Other date formatted"        ,
                                                failure:      "Other date badly formatted"  );

// Expect the current date to be formatted
$test_results['date_to_text_3'] = test_assert(  value:        $test                           ,
                                                type:         'string'                        ,
                                                expectation:  $test_today                     ,
                                                success:      "Current date formatted"        ,
                                                failure:      "Current date badly formatted"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Convert date to DD/MM/YY

// Convert a test date
$test = date_to_ddmmyy('2005-03-19');

// Expect the date to be converted to DD/MM/YY
$test_results['date_to_ddmmyy'] = test_assert(  value:        $test                               ,
                                                type:         'string'                            ,
                                                expectation:  "19/03/05"                          ,
                                                success:      "Date formatted to DD/MM/YY"        ,
                                                failure:      "Date badly formatted to DD/MM/YY"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Convert date to MySQL format

// Convert a test date
$test = date_to_mysql('19/03/05');

// Convert an incorrect date
$test_wrong = date_to_mysql('91/30/50', '2005-03-19');

// Expect the date to be converted to MySQL format
$test_results['date_to_mysql'] = test_assert( value:        $test                             ,
                                              type:         'string'                          ,
                                              expectation:  "2005-03-19"                      ,
                                              success:      "Date formatted for MySQL"        ,
                                              failure:      "Date badly formatted for MySQL"  );

// Expect the date to use the default value
$test_results['date_to_mysql_err'] = test_assert( value:        $test_wrong                       ,
                                                  type:         'string'                          ,
                                                  expectation:  "2005-03-19"                      ,
                                                  success:      "Date used default MySQL value"   ,
                                                  failure:      "Date badly formatted for MySQL"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Convert timestamp to aware datetime

// Convert a timestamp to an aware datetime
$test = date_to_aware_datetime(strtotime('2005-03-19'));

// Convert that timestamp to the expected values
$test_datetime = date('c', strtotime('2005-03-19'));
$test_timezone = date('e', strtotime('2005-03-19'));

// Expect the datetime to be correct
$test_results['date_aware_time'] = test_assert( value:        $test['datetime']   ,
                                                type:         'string'            ,
                                                expectation:  $test_datetime      ,
                                                success:      "Correct datetime"  ,
                                                failure:      "Wrong datetime"    );

// Expect the timezone to be correct
$test_results['date_aware_zone'] = test_assert( value:        $test['timezone']   ,
                                                type:         'string'            ,
                                                expectation:  $test_timezone      ,
                                                success:      "Correct timezone"  ,
                                                failure:      "Wrong timezone"    );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Generate a diff between strings

// Create a diff
$test = sanitize_output(diff_strings('String with some old content', 'String with some new content'));

// Define the expected value for the diff
$test_expectations = 'String with some &nbsp;&lt;del&gt;&nbsp;old&nbsp;&lt;/del&gt;&nbsp;&nbsp;&lt;ins&gt;&nbsp;new&nbsp;&lt;/ins&gt;&nbsp;content ';

// Expect both strings to match
$test_results['string_diff'] = test_assert( value:        $test                               ,
                                            type:         'string'                            ,
                                            expectation:  $test_expectations                  ,
                                            success:      "Diff matches expectations"         ,
                                            failure:      "Diff does not match expectations"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Search for context around a string

// Define a test string
$test_string = "Some phrase including the word nobleme and then some more text again";

// Search the test string
$test = search_string_context('nobleme', $test_string, nb_words_around: 2);

// Define the expected result
$test_expectations = '...the word nobleme and then...';

// Expect both strings to match
$test_results['string_context'] = test_assert(  value:        $test                                 ,
                                                type:         'string'                              ,
                                                expectation:  $test_expectations                    ,
                                                success:      "Search matches expectations"         ,
                                                failure:      "Search does not match expectations"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Wrap elements of a string in HTML tags

// Define a test string
$test_string = "A phrase in which the word phrase is repeated phrase a few times";

// Wrap some words in tags
$test = string_wrap_in_html_tags('phrase', $test_string, '<b>', '</b>');

// Define the expected result
$test_expectations = 'A <b>phrase</b> in which the word <b>phrase</b> is repeated <b>phrase</b> a few times';

// Expect both strings to match
$test_results['string_wrap_tags'] = test_assert(  value:        $test                           ,
                                                  type:         'string'                        ,
                                                  expectation:  $test_expectations              ,
                                                  success:      "Tags inserted in string"       ,
                                                  failure:      "Tags badly inserted in string" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Generate a dropdown menu page section selector

// Prepare values for a dummy selector
$test_selector_entries = array( 'test_1'  ,
                                'test_2'  ,
                                'test_3'  ,
                                'test_4'  );
$default_selector_entry = 'test_2';

// Generate a dummy selector
$test_selector = page_section_selector(           $test_selector_entries  ,
                                        default:  $default_selector_entry );

// Expect the second entry to be selected by default
$test_results['page_section_selector'] = test_assert( value:        $test_selector['menu']['test_2']  ,
                                                      type:         'string'                          ,
                                                      expectation:  ' selected'                       ,
                                                      success:      "Section selector generated"      ,
                                                      failure:      "Section selector failed"         );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a private message

// Prepare values for the private message
$test_message_recipient = fixtures_fetch_random_id('users');
$test_message_sender    = fixtures_fetch_random_id('users');
$test_message_title     = fixtures_generate_data('sentence', 3, 4, no_periods: true);
$test_message_body      = fixtures_generate_data('text', 3, 4);

// Send the private message
private_message_send( title:      $test_message_title     ,
                      body:       $test_message_body      ,
                      recipient:  $test_message_recipient ,
                      sender:     $test_message_sender    );

// Sanitize the message's contents
$test_message_recipient = sanitize($test_message_recipient, 'int', 0);
$test_message_sender    = sanitize($test_message_sender, 'int', 0);
$test_message_title     = sanitize($test_message_title, 'string');

// Fetch the sent message
$test_message = query(" SELECT    users_private_messages.id   AS 'pm_id' ,
                                  users_private_messages.body AS 'pm_body'
                        FROM      users_private_messages
                        WHERE     users_private_messages.fk_users_recipient     =     '$test_message_recipient'
                        AND       users_private_messages.fk_users_sender        =     '$test_message_sender'
                        AND       users_private_messages.title                  LIKE  '$test_message_title'
                        AND       users_private_messages.deleted_by_recipient   =     0
                        AND       users_private_messages.deleted_by_sender      =     0
                        AND       users_private_messages.fk_parent_message      =     0
                        AND       users_private_messages.is_admin_only_message  =     0
                        AND       users_private_messages.hide_from_admin_mail   =     0
                        AND       users_private_messages.sent_at                !=    0
                        AND       users_private_messages.read_at                =     0
                        ORDER BY  users_private_messages.sent_at                DESC  ",
                        fetch_row: true);

// Fetch the body of the sent mail
$test_message_result = isset($test_message) ? $test_message['pm_body'] : '';

// Expect the message to have the correct body
$test_results['private_message'] = test_assert( value:        $test_message_result        ,
                                                type:         'string'                    ,
                                                expectation:  $test_message_body          ,
                                                success:      "Private message sent"      ,
                                                failure:      "Private message not sent"  );

// Cleanup: Delete the test private message
$test_message_id = sanitize($test_message['pm_id'], 'int', 0);
query(" DELETE FROM users_private_messages
        WHERE       users_private_messages.id = '$test_message_id' ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a silent system notification

// Prepare values for the notification
$test_message_recipient = fixtures_fetch_random_id('users');
$test_message_title     = fixtures_generate_data('sentence', 3, 4, no_periods: true);
$test_message_body      = fixtures_generate_data('text', 3, 4);

// Send the system notification
private_message_send( title:      $test_message_title     ,
                      body:       $test_message_body      ,
                      recipient:  $test_message_recipient ,
                      is_silent:  true                    );

// Sanitize the notification's contents
$test_message_recipient = sanitize($test_message_recipient, 'int', 0);
$test_message_title     = sanitize($test_message_title, 'string');

// Fetch the sent system notification
$test_message = query(" SELECT    users_private_messages.id   AS 'pm_id' ,
                                  users_private_messages.body AS 'pm_body'
                        FROM      users_private_messages
                        WHERE     users_private_messages.fk_users_recipient     =     '$test_message_recipient'
                        AND       users_private_messages.fk_users_sender        =     0
                        AND       users_private_messages.title                  LIKE  '$test_message_title'
                        AND       users_private_messages.deleted_by_recipient   =     0
                        AND       users_private_messages.deleted_by_sender      =     0
                        AND       users_private_messages.fk_parent_message      =     0
                        AND       users_private_messages.is_admin_only_message  =     0
                        AND       users_private_messages.hide_from_admin_mail   =     0
                        AND       users_private_messages.sent_at                !=    0
                        AND       users_private_messages.read_at                !=    0
                        ORDER BY  users_private_messages.sent_at                DESC  ",
                        fetch_row: true);

// Fetch the body of the sent mail
$test_message_result = isset($test_message) ? $test_message['pm_body'] : '';

// Expect the notification to have the correct body
$test_results['private_message_system'] = test_assert(  value:        $test_message_result            ,
                                                        type:         'string'                        ,
                                                        expectation:  $test_message_body              ,
                                                        success:      "Silent notification sent"      ,
                                                        failure:      "Silent notification not sent"  );

// Cleanup: Delete the test system notification
$test_message_id = sanitize($test_message['pm_id'], 'int', 0);
query(" DELETE FROM users_private_messages
        WHERE       users_private_messages.id = '$test_message_id' ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send admin mail

// Prepare values for the admin mail
$test_message_sender      = sanitize(fixtures_fetch_random_id('users'), 'int');
$test_message_true_sender = sanitize(fixtures_fetch_random_id('users'), 'int');
$test_message_title       = sanitize(fixtures_generate_data('sentence', 3, 4, no_periods: true), 'string');
$test_message_body        = sanitize(fixtures_generate_data('text', 3, 4), 'string');

// Send the admin mail
private_message_send( title:            $test_message_title       ,
                      body:             $test_message_body        ,
                      recipient:        0                         ,
                      sender:           $test_message_sender      ,
                      true_sender:      $test_message_true_sender ,
                      is_admin_only:    true                      ,
                      hide_admin_mail:  true                      ,
                      do_not_sanitize:  true                      );

// Fetch the sent admin mail
$test_message = query(" SELECT    users_private_messages.id   AS 'pm_id' ,
                                  users_private_messages.body AS 'pm_body'
                        FROM      users_private_messages
                        WHERE     users_private_messages.fk_users_recipient     =     0
                        AND       users_private_messages.fk_users_sender        =     '$test_message_sender'
                        AND       users_private_messages.fk_users_true_sender   =     '$test_message_true_sender'
                        AND       users_private_messages.title                  LIKE  '$test_message_title'
                        AND       users_private_messages.deleted_by_recipient   =     0
                        AND       users_private_messages.deleted_by_sender      =     0
                        AND       users_private_messages.fk_parent_message      =     0
                        AND       users_private_messages.is_admin_only_message  =     1
                        AND       users_private_messages.hide_from_admin_mail   =     1
                        AND       users_private_messages.sent_at                !=    0
                        AND       users_private_messages.read_at                =     0
                        ORDER BY  users_private_messages.sent_at                DESC  ",
                        fetch_row: true);

// Fetch the body of the sent mail
$test_message_result = isset($test_message) ? sanitize($test_message['pm_body'], 'string') : '';

// Expect the admin mail to have the correct body
$test_results['private_message_admin'] = test_assert( value:        $test_message_result      ,
                                                      type:         'string'                  ,
                                                      expectation:  $test_message_body        ,
                                                      success:      "Admin mail sent"         ,
                                                      failure:      "Admin mail not sent"     );

// Cleanup: Delete the test admin mail
$test_message_id = sanitize($test_message['pm_id'], 'int', 0);
query(" DELETE FROM users_private_messages
        WHERE       users_private_messages.id = '$test_message_id' ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Trigger flood check for a user

// Ensure there's more than one user in the database
$test_users = query(" SELECT  users.id
                      FROM    users ");
$test_user_count = query_row_count($test_users);

// If the current user is the only one, use them
if($test_user_count == 1)
  $test_user = sanitize(user_get_id(), 'int');

// Otherwise pick a random user other than the current one
else
{
  do {
    $test_user = sanitize(fixtures_fetch_random_id('users'));
  } while ($test_user == user_get_id());
}

// Grab the current timestamp
$timestamp = sanitize(time(), 'int');

// Run flood check for said user
flood_check(  $error_page = false       ,
              $user_id    = $test_user  );

// Fetch the user's last action
$test_user_activity = query(" SELECT  users.last_action_at AS 'u_last'
                              FROM    users
                              WHERE   users.id = '$test_user' ",
                              fetch_row: true);
$test_user_last_action = isset($test_user_activity) ? sanitize($test_user_activity['u_last'], 'int', 0) : 0;

// Expect the last action to be updated
$test_results['flood_check'] = test_assert( value:      $test_user_last_action                  ,
                                            type:       'int'                                   ,
                                            assertion:  ($test_user_last_action >= $timestamp)  ,
                                            success:    "Flood check ran"                       ,
                                            failure:    "Flood check didn't run"                );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add an entry to recent activity

// Prepare values for the activity entry
$test_activity_item_id    = sanitize(fixtures_generate_data('int', 1, 100), 'int');
$test_activity_summary_en = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');
$test_activity_summary_fr = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');
$test_activity_amount     = sanitize(fixtures_generate_data('int', 1, 100), 'int');
$test_activity_user       = sanitize(fixtures_fetch_random_id('users'), 'int');
$test_activity_username   = sanitize(user_get_username($test_activity_user), 'string');
$test_activity_mod        = sanitize(user_get_username(), 'string');
$test_activity_reason     = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');

// Prepare values for the diff log, ensure the before/after values are different
$test_activity_details_en = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');
$test_activity_details_fr = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');
do {
  $test_activity_diff_old   = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');
  $test_activity_diff_new   = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');
} while ($test_activity_diff_old == $test_activity_diff_new);

// Create the activity entry
$test_activity_id = log_activity( activity_type:        'test'                    ,
                                  is_moderators_only:   true                      ,
                                  language:             'ENFR'                    ,
                                  activity_id:          $test_activity_item_id    ,
                                  activity_summary_en:  $test_activity_summary_en ,
                                  activity_summary_fr:  $test_activity_summary_fr ,
                                  activity_amount:      $test_activity_amount     ,
                                  fk_users:             $test_activity_user       ,
                                  username:             $test_activity_username   ,
                                  moderator_username:   $test_activity_mod        ,
                                  moderation_reason:    $test_activity_reason     ,
                                  do_not_sanitize:      true                      );

// Create the diff log
$test_activity_id = sanitize($test_activity_id, 'int', 0);
log_activity_details( linked_activity_log:  $test_activity_id         ,
                      description_en:       $test_activity_details_en ,
                      description_fr:       $test_activity_details_fr ,
                      before:               $test_activity_diff_old   ,
                      after:                $test_activity_diff_new   ,
                      is_optional:          true                      ,
                      do_not_sanitize:      true                      );

// Fetch the activity entry
$test_activity = query("  SELECT  logs_activity.moderation_reason AS 'a_reason'
                          FROM    logs_activity
                          WHERE   logs_activity.fk_users                    =     '$test_activity_user'
                          AND     logs_activity.is_deleted                  =     0
                          AND     logs_activity.happened_at                 !=    0
                          AND     logs_activity.is_moderators_only          =     1
                          AND     logs_activity.language                    =     'ENFR'
                          AND     logs_activity.activity_id                 =     '$test_activity_item_id'
                          AND     logs_activity.activity_type               LIKE  'test'
                          AND     logs_activity.activity_amount             =     '$test_activity_amount'
                          AND     logs_activity.activity_summary_en         LIKE  '$test_activity_summary_en'
                          AND     logs_activity.activity_summary_fr         LIKE  '$test_activity_summary_fr'
                          AND     logs_activity.activity_username           LIKE  '$test_activity_username'
                          AND     logs_activity.activity_moderator_username LIKE  '$test_activity_mod' ",
                          fetch_row: true);

// Fetch the activity's moderation reason
$test_activity_reasoning = isset($test_activity) ? sanitize($test_activity['a_reason'], 'string') : '';

// Fetch the diff log
$test_activity_diff = query(" SELECT  logs_activity_details.content_after AS 'ad_after'
                              FROM    logs_activity_details
                              WHERE   logs_activity_details.fk_logs_activity        =     '$test_activity_id'
                              AND     logs_activity_details.content_description_en  LIKE  '$test_activity_details_en'
                              AND     logs_activity_details.content_description_fr  LIKE  '$test_activity_details_fr'
                              AND     logs_activity_details.content_before          LIKE  '$test_activity_diff_old' ",
                                      fetch_row: true);

// Fetch the diff log's new value
$test_activity_new_value = isset($test_activity_diff) ? sanitize($test_activity_diff['ad_after'], 'string') : '';

// Expect the activity log to have the correct body
$test_results['recent_activity_log'] = test_assert( value:        $test_activity_reasoning            ,
                                                    type:         'string'                            ,
                                                    expectation:  $test_activity_reason               ,
                                                    success:      "Recent activity entry logged"      ,
                                                    failure:      "Recent activity entry not logged"  );

// Expect the diff log to have the correct new value
$test_results['recent_activity_diff'] = test_assert(  value:        $test_activity_new_value        ,
                                                      type:         'string'                        ,
                                                      expectation:  $test_activity_diff_new         ,
                                                      success:      "Activity diff log logged"      ,
                                                      failure:      "Activity diff log not logged"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Purge orphan diff logs

// Fetch a non-existing id for activity logs
$test_empty_diff = query("  SELECT    logs_activity.id AS 'la_id'
                            FROM      logs_activity
                            ORDER BY  logs_activity.id DESC
                            LIMIT     1 ",
                            fetch_row: true );
$test_empty_diff_id = (isset($test_empty_diff['la_id'])) ? sanitize($test_empty_diff['la_id'] + 1, 'int', 0) : 1;

// Create an orphan diff log
query(" INSERT INTO logs_activity_details
        SET         logs_activity_details.fk_logs_activity = '$test_empty_diff_id' ");

// Count the number of entries in the diff log table
$test_diff_count =  query(" SELECT COUNT(*) AS 'lad_count'
                            FROM            logs_activity_details ",
                            fetch_row: true);

// Purge orphan diffs
log_activity_purge_orphan_diffs();

// Count the number of entries in the diff log table once again
$test_purged_diff_count = query(" SELECT COUNT(*) AS 'lad_count'
                                  FROM            logs_activity_details ",
                                  fetch_row: true);

// Compare the diff log counts pre and post orphan logs purge
$test_orphan_purge = ($test_diff_count['lad_count'] == $test_purged_diff_count['lad_count']);

// Expect the diff count to be different post-purge
$test_results['recent_activity_diff_purge'] = test_assert(  value:        $test_orphan_purge                ,
                                                            type:         'bool'                            ,
                                                            expectation:  false                             ,
                                                            success:      "Orphan activity logs purged"     ,
                                                            failure:      "Orphan activity logs not purged" );



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete and restore entries in recent activity

// Delete a test log
log_activity_delete(  activity_type:      'test'                  ,
                      is_moderators_only: true                    ,
                      activity_id:        $test_activity_item_id  );

// Fetch a deleted test log
$test_activity_log = query("  SELECT  logs_activity.is_deleted  AS 'la_del'
                              FROM    logs_activity
                              WHERE   logs_activity.id = '$test_activity_id' ",
                              fetch_row: true);
$test_activity_deleted = (int)$test_activity_log['la_del'];

// Restore a test log
log_activity_delete(  activity_type:      'test'                  ,
                      is_moderators_only: true                    ,
                      activity_id:        $test_activity_item_id  ,
                      restore:            true                    );

// Fetch a restored test log
$test_activity_log = query("  SELECT  logs_activity.is_deleted  AS 'la_del'
                              FROM    logs_activity
                              WHERE   logs_activity.id = '$test_activity_id' ",
                              fetch_row: true);
$test_activity_restored = (int)$test_activity_log['la_del'];

// Expect the deleted log to be properly deleted
$test_results['recent_activity_delete'] = test_assert(  value:        $test_activity_deleted      ,
                                                        type:         'int'                       ,
                                                        expectation:  1                           ,
                                                        success:      "Activity log deleted"      ,
                                                        failure:      "Activity log not deleted"  );

// Expect the restored log to be properly restored
$test_results['recent_activity_restore'] = test_assert( value:        $test_activity_restored     ,
                                                        type:         'int'                       ,
                                                        expectation:  0                           ,
                                                        success:      "Activity log restored"     ,
                                                        failure:      "Activity log not restored" );

// Cleanup: Delete the test activity log
activity_delete(  log_id:         $test_activity_id ,
                  deletion_type:  true              );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Schedule a task

// Prepare values for the task
$test_task_type_item_id = sanitize(fixtures_generate_data('int', 1, 100), 'int');
$test_task_planned_at   = sanitize(time() + 10000, 'int', 0);
$test_task_description  = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');

// Schedule the task
schedule_task(  action_type:        'test'                  ,
                action_id:          $test_task_type_item_id ,
                action_planned_at:  $test_task_planned_at   ,
                action_description: $test_task_description  );

// Fetch the task
$test_task = query("  SELECT  system_scheduler.id               AS 't_id' ,
                              system_scheduler.task_description AS 't_desc'
                      FROM    system_scheduler
                      WHERE   system_scheduler.planned_at = '$test_task_planned_at'
                      AND     system_scheduler.task_id    = '$test_task_type_item_id'
                      AND     system_scheduler.task_type  = 'test' ",
                      fetch_row: true);

// Fetch the task's description and id
$test_task_body = isset($test_task) ? sanitize($test_task['t_desc'])  : '';
$test_task_id   = isset($test_task) ? sanitize($test_task['t_id'])    : 0;

// Expect the task to have the correct body
$test_results['schedule_task'] = test_assert( value:        $test_task_description  ,
                                              type:         'string'                ,
                                              expectation:  $test_task_body         ,
                                              success:      "Task scheduled"        ,
                                              failure:      "Task not scheduled"    );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update a scheduled task

// Prepare updated values for the task
$test_task_description = sanitize(fixtures_generate_data('sentence', 4, 8), 'string');

// Update the task
schedule_task_update( action_type:        'test'                  ,
                      action_id:          $test_task_type_item_id ,
                      action_description: $test_task_description  );

// Fetch the updated task
$test_task = query("  SELECT  system_scheduler.task_description AS 't_desc'
                      FROM    system_scheduler
                      WHERE   system_scheduler.id = '$test_task_id' ",
                      fetch_row: true);

// Fetch the task's updated description
$test_task_body = isset($test_task) ? sanitize($test_task['t_desc']) : '';

// Expect the task to have the correct body
$test_results['schedule_task_update'] = test_assert(  value:        $test_task_description        ,
                                                      type:         'string'                      ,
                                                      expectation:  $test_task_body               ,
                                                      success:      "Scheduled task updated"      ,
                                                      failure:      "Scheduled task not updated"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a scheduled task

// Delete the task
schedule_task_delete( action_type:  'test'                  ,
                      action_id:    $test_task_type_item_id );

// Fetch the updated task
$test_task = query("  SELECT  system_scheduler.task_description AS 't_desc'
                      FROM    system_scheduler
                      WHERE   system_scheduler.id = '$test_task_id' ",
                      fetch_row: true);

// Expect the task to be deleted
$test_results['schedule_task_delete'] = test_assert(  value:        $test_task                    ,
                                                      type:         'null'                        ,
                                                      expectation:  null                          ,
                                                      success:      "Scheduled task deleted"      ,
                                                      failure:      "Scheduled task not deleted"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a message with the IRC bot

// Send a message
$test_irc_message = irc_bot_send_message( message: 'Test message, please ignore.' ,
                                          channel: '#admin'                       );

// Expect the message to be added to the IRC bot file
$test_results['irc_send_message'] = test_assert(  value:        $test_irc_message                       ,
                                                  type:         'bool'                                  ,
                                                  expectation:  true                                    ,
                                                  success:      "Message added to IRC bot txt file"     ,
                                                  failure:      "Message not added to IRC bot txt file" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a message with the Discord webhook

// Send a message
$test_discord_message = discord_send_message( message: 'Test message, please ignore.' ,
                                              channel: 'admin'                        );

// Expect the message to be sent through the Discord webhook
$test_results['discord_send_message'] = test_assert(  value:        $test_discord_message                 ,
                                                      type:         'bool'                                ,
                                                      expectation:  true                                  ,
                                                      success:      "Message sent to Discord webhook"     ,
                                                      failure:      "Message not sent to Discord webhook" );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                         inc/functions_mathematics.inc.php                                         */
/*                                                                                                                   */
/*                                                    MATHEMATICS                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calculate a percentage

// Calculate the percentage of two numbers
$test_number  = rand(1, 10);
$test_total   = rand(11, 100);
$test_percent = (float)(($test_number / $test_total) * 100);

// Expect the percentage calculations to be working
$test_results['maths_percent'] = test_assert( value:        maths_percentage_of($test_number, $test_total)        ,
                                              type:         'float'                                               ,
                                              expectation:  $test_percent                                         ,
                                              success:      'Percentage calculated'                               ,
                                              failure:      "Percentage is wrong ($test_number% of $test_total)"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calculate a percentage growth

// Calculate the percentage growth between two numbers
$test_before  = rand(1, 50);
$test_after   = rand(51, 100);
$test_growth  = (float)((($test_after / $test_before ) * 100) - 100);

// Calculate the same growth using the function
$test_growth_function = maths_percentage_growth($test_before, $test_after);

// Prepare a phrase in case of failure
$test_failure = "Percentage growth is wrong ($test_before to $test_after)";

// Expect the percentage calculations to be working
$test_results['maths_percent_growth'] = test_assert(  value:        $test_growth_function           ,
                                                      type:         'float'                         ,
                                                      expectation:  $test_growth                    ,
                                                      success:      'Percentage growth calculated'  ,
                                                      failure:      $test_failure                   );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                           inc/functions_numbers.inc.php                                           */
/*                                                                                                                   */
/*                                                      NUMBERS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepend a sign to a number

$test_results['number_prepend_pos'] = test_assert(  value:        number_prepend_sign(10)             ,
                                                    type:         'string'                            ,
                                                    expectation:  '+10'                               ,
                                                    success:      'Sign added before number'          ,
                                                    failure:      'Sign not added before number'      );
$test_results['number_prepend_zero'] = test_assert( value:        number_prepend_sign(0)              ,
                                                    type:         'string'                            ,
                                                    expectation:  '0'                                 ,
                                                    success:      'No sign added before zero'         ,
                                                    failure:      'Sign added before zero'            );
$test_results['number_prepend_neg'] = test_assert(  value:        number_prepend_sign(-10)            ,
                                                    type:         'string'                            ,
                                                    expectation:  '-10'                               ,
                                                    success:      'No sign added before number'       ,
                                                    failure:      'Sign added before negative number' );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Format a number for display

// Prepare some formatted numbers
$test_format_number   = number_display_format(  number:       -10                 ,
                                                format:       "number"            ,
                                                decimals:     0                   );
$test_format_price    = number_display_format(  number:       1.8                 ,
                                                format:       "price"             ,
                                                decimals:     2                   );
$test_format_cents    = number_display_format(  number:       1.8                 ,
                                                format:       "price_cents"       );
$test_format_percent  = number_display_format(  number:       50.11111            ,
                                                format:       "percentage"        );
$test_format_point    = number_display_format(  number:       50.11111            ,
                                                format:       "percentage_point"  ,
                                                decimals:     1                   ,
                                                prepend_sign: true                );

// Expect the correct number formatting outcomes
$test_results['number_format_int'] = test_assert(     value:        $test_format_number                 ,
                                                      type:         'string'                            ,
                                                      expectation:  '-10'                               ,
                                                      success:      'Number formatted'                  ,
                                                      failure:      'Number formatted wrong'            );
$test_results['number_format_price'] = test_assert(   value:        $test_format_price                  ,
                                                      type:         'string'                            ,
                                                      expectation:  '2 €'                               ,
                                                      success:      'Price formatted'                   ,
                                                      failure:      'Price formatted wrong'             );
$test_results['number_format_cents'] = test_assert(   value:        $test_format_cents                  ,
                                                      type:         'string'                            ,
                                                      expectation:  '1,80 €'                            ,
                                                      success:      'Full price formatted'              ,
                                                      failure:      'Full price formatted wrong'        );
$test_results['number_format_percent'] = test_assert( value:        $test_format_percent                ,
                                                      type:         'string'                            ,
                                                      expectation:  '50 %'                              ,
                                                      success:      'Percentage formatted'              ,
                                                      failure:      'Percentage formatted wrong'        );
$test_results['number_format_point'] = test_assert(   value:        $test_format_point                  ,
                                                      type:         'string'                            ,
                                                      expectation:  '+50,1 p%'                          ,
                                                      success:      'Percentage point formatted'        ,
                                                      failure:      'Percentage point formatted wrong'  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Style a number

$test_results['number_styling'] = test_assert(  value:        number_styling(rand(1, 100))  ,
                                                type:         'string'                      ,
                                                expectation:  'positive'                    ,
                                                success:      'Number styled'               ,
                                                failure:      'Number styled wrong'         );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Make a number ordinal

$test_results['number_ordinal_fr'] = test_assert( value:        number_ordinal(1, lang: 'FR')     ,
                                                  type:         'string'                          ,
                                                  expectation:  'er'                              ,
                                                  success:      'French ordinal returned'         ,
                                                  failure:      'French ordinal returned wrong'   );
$test_results['number_ordinal_en'] = test_assert( value:        number_ordinal(2, lang: 'EN')     ,
                                                  type:         'string'                          ,
                                                  expectation:  'nd'                              ,
                                                  success:      'English ordinal returned'        ,
                                                  failure:      'English ordinal returned wrong'  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                            inc/functions_time.inc.php                                             */
/*                                                                                                                   */
/*                                                       TIME                                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Write time differences in plaintext

$test_results['time_since'] = test_assert(  value:        time_since(time() + 100)              ,
                                            type:         'string'                              ,
                                            expectation:  __('time_diff_past_future')           ,
                                            success:      'Future timestamp interpreted'        ,
                                            failure:      'Future timestamp interpreted wrong'  );
$test_results['time_until'] = test_assert(  value:        time_until(time() - 100)              ,
                                            type:         'string'                              ,
                                            expectation:  __('time_diff_future_past')           ,
                                            success:      'Past timestamp interpreted'          ,
                                            failure:      'Past timestamp interpreted wrong'    );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calculate the days between dates

// Calculate days
$test_days_mysql      = time_days_elapsed( '2020-01-01', '2021-02-02');
$test_days_timestamp  = time_days_elapsed( '1704063600', '1704841200', use_timestamps: true);

// Expect the days to have been calculated properly
$test_results['time_days_mysql'] = test_assert(     value:        $test_days_mysql                          ,
                                                    type:         'int'                                     ,
                                                    expectation:  398                                       ,
                                                    success:      'Days calculated from dates'              ,
                                                    failure:      'Days wrongly calculated from dates'      );
$test_results['time_days_timestamp'] = test_assert( value:        $test_days_timestamp                      ,
                                                    type:         'int'                                     ,
                                                    expectation:  9                                         ,
                                                    success:      'Days calculated from timestamps'         ,
                                                    failure:      'Days wrongly calculated from timestamps' );