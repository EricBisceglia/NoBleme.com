<?php /***************************************************************************************************************/
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
include_once './inc/bbcodes.inc.php';




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
$expectations = '<span class="bold"><div class="tinypadding_top"><div class="bbcode_quote_body"><div class="bbcode_quote_title">Quote by test :</div><hr class="bbcode_quote_separator"><a class="bold" href="https://nobleme.com">https://nobleme.com</a></div></div></span>';

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
$expectations = "test: https://nobleme.com";

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
$test = system_get_current_version_number('semver', 'en');

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
