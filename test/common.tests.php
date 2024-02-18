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