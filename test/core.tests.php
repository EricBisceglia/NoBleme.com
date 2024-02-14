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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 inc/tests.inc.php                                                 */
/*                                                                                                                   */
/*                                                       TESTS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Assert a test result

// Run a successful test
$test = test_assert(  value:        1     ,
                      type:         'int' ,
                      expectation:  1     ,
                      success:      'Yes' );

// Expect the test to be successful
$test_results['test'] = test_assert(  value:      $test                                                       ,
                                      type:       'array'                                                     ,
                                      assertion:  $test['result'] === true && $test['explanation'] === 'Yes'  ,
                                      success:    "Test successful"                                           ,
                                      failure:    "Test failed"                                               );



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fail a test

// Run a failed test
$test = test_assert(  value:        '1'       ,
                      type:         'string'  ,
                      expectation:  1         ,
                      failure:      'No'      );

// Expect the test to be successful
$test_results['test_fail'] = test_assert( value:      $test                                                       ,
                                          type:       'array'                                                     ,
                                          assertion:  $test['result'] === false && $test['explanation'] === 'No'  ,
                                          success:    "Test successfully failed"                                  ,
                                          failure:    "Test failed to fail"                                       );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 inc/query.inc.php                                                 */
/*                                                                                                                   */
/*                                                    SQL QUERIES                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Run a query

// Include SQL query tools in case they haven't been included yet
include_once './inc/sql.inc.php';

// Run a query
$test = query(" SELECT * FROM system_variables ");

// Expect a mysqli object
$test_results['query'] = test_assert( value:      $test                                   ,
                                      assertion:  is_a($test, 'mysqli_result')            ,
                                      success:    "Query returns a mysqli_result"         ,
                                      failure:    "Query does not return a mysqli_result" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run a query and return its results

// Run the query
$test = query(" SELECT * FROM system_variables ",
                ignore_errors:  true    ,
                fetch_row:      true    ,
                row_format:     'both'  ,
                description:    'Test'  );

// Expect an array of values
$test_results['query_data'] = test_assert(  value:      $test                                     ,
                                            type:       'array'                                   ,
                                            assertion:  is_array($test) && count($test) > 0       ,
                                            success:    "Query returns an array of data"          ,
                                            failure:    "Query does not return an array of data"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run a query and ignore errors

// Run the query
$test = query(" SELECT * FROM nowhere ", ignore_errors: true);

// Expect the boolean false
$test_results['query_err'] = test_assert( value:        $test                     ,
                                          type:         'bool'                    ,
                                          expectation:  false                     ,
                                          success:      "Errors are ignored"      ,
                                          failure:      "Errors are not ignored"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the next row of a query

// Run the query, fetch the next row
$test = query_row(query(" SELECT * FROM system_variables "));

// Expect an array of values
$test_results['query_row'] = test_assert( value:      $test                                     ,
                                          type:       'array'                                   ,
                                          assertion:  is_array($test) && count($test) > 0       ,
                                          success:    "Returns an array of data"                ,
                                          failure:    "Query does not return an array of data"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Count a query's rows

// Randomly limit row count to a low number
$test_count = fixtures_generate_data('int', 2, 4);

// Run a query, count its rows
$test = query_row_count(query(" SELECT * FROM users LIMIT $test_count "));

// Expect an array of values
$test_results['query_count'] = test_assert( value:        $test                             ,
                                            type:         'int'                             ,
                                            expectation:  $test_count                       ,
                                            success:      "Returns the number of rows"      ,
                                            failure:      "Returns a wrong number of rows"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insert an entry and return its ID

// Create a new website version
$test_version = query(" INSERT INTO system_versions
                        SET         system_versions.major         = 0 ,
                                    system_versions.minor         = 0 ,
                                    system_versions.patch         = 0 ,
                                    system_versions.release_date  = '0000-00-00' ");

// Get the ID of the inserted row
$test_id = query_id($test);

// Get the ID of the latest version
$test_version_id = query("  SELECT      system_versions.id AS 'v_id'
                            FROM        system_versions
                            ORDER BY    system_versions.id DESC
                            LIMIT       1 ",
                            fetch_row: true );

// Sanitize the result
$test_version_id = sanitize($test_version_id['v_id'], 'int', 0);

// Delete the new entry if all went right
if($test_id === $test_version_id)
  query(" DELETE FROM system_versions
          WHERE       system_versions.id = '$test_id' ");

// Expect the correct version number
$test_results['query_id'] = test_assert(  value:        $test_id                          ,
                                          type:         'int'                             ,
                                          expectation:  $test_version_id                  ,
                                          success:      "Last query ID is fetched"        ,
                                          failure:      "Wrong last query ID is fetched"  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             inc/sanitization.inc.php                                              */
/*                                                                                                                   */
/*                                                   SANITIZATION                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Sanitize an unsanitized string

// Sanitize a bad string
$test = sanitize("Te'st", 'string');

// Expect a sanitized string
$test_results['sanitize_string'] = test_assert( value:        $test                     ,
                                                type:         'string'                  ,
                                                expectation:  "Te\'st"                  ,
                                                success:      "String is sanitized"     ,
                                                failure:      "String is not sanitized" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize an integer

// Sanitize a string into an integer
$test = sanitize("15", 'int');

// Expect an integer
$test_results['sanitize_int'] = test_assert(  value:        $test                       ,
                                              type:         'int'                       ,
                                              expectation:  15                          ,
                                              success:      "Integer is sanitized"      ,
                                              failure:      "Integer is not sanitized"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize a boolean

// Sanitize a string into a boolean
$test = sanitize("false", 'bool');

// Expect a boolean
$test_results['sanitize_bool'] = test_assert( value:        $test                       ,
                                              type:         'bool'                      ,
                                              expectation:  false                       ,
                                              success:      "Boolean is sanitized"      ,
                                              failure:      "Boolean is not sanitized"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize a float

// Sanitize an int into a float
$test = sanitize(1, 'float');

// Expect a float
$test_results['sanitize_float'] = test_assert(  value:        $test                     ,
                                                type:         'float'                   ,
                                                expectation:  (float)1                  ,
                                                success:      "Float is sanitized"      ,
                                                failure:      "Float is not sanitized"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize and apply minimum value

// Randomly decide a minimum value
$test_minimum = rand(-5, 5);

// Apply a minimum value to an integer
$test = sanitize(-10, 'int', $test_minimum);

// Expect the minimum value
$test_results['sanitize_min'] = test_assert(  value:        $test                                 ,
                                              type:         'int'                                 ,
                                              expectation:  $test_minimum                         ,
                                              success:      "Integer has minimum value"           ,
                                              failure:      "Integer does not have minimum value" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize and apply maximum value to an int

// Randomly decide a maximum value
$test_maximum = rand(-5, 5);

// Apply a maximum value to an integer
$test = sanitize(10, 'int', -10, $test_maximum);

// Expect the maximum value
$test_results['sanitize_max'] = test_assert(  value:        $test                                 ,
                                              type:         'int'                                 ,
                                              expectation:  $test_maximum                         ,
                                              success:      "Integer has maximum value"           ,
                                              failure:      "Integer does not have maximum value" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize and apply trimming and padding to a string

// Sanitize and trim a string
$test = sanitize("Lo'ng string", 'string', max: 5);

// Unsanitize the string
$test = stripslashes($test);

// Sanitize once again and pad the string
$test = sanitize($test, 'string', min: 10, padding: 'x');

// Expect the maximum value
$test_results['sanitize_pad'] = test_assert(  value:        $test                                 ,
                                              type:         'string'                              ,
                                              expectation:  "Lo\'ngxxxxx"                         ,
                                              success:      "String is trimmed and padded"        ,
                                              failure:      "String is wrongly trimmed or padded" );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize an input

// Fetch and sanitize the input which triggered these tests
$test = sanitize_input('POST', 'dev_tests_core', 'string');

// Expect the default value of a checkbox
$test_results['sanitize_post'] = test_assert( value:        $test                     ,
                                              type:         'string'                  ,
                                              expectation:  "on"                      ,
                                              success:      "Postdata is fetched"     ,
                                              failure:      "Postdata is not fetched" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize an array entry

// Pick the latest test result and sanitize it
$test = sanitize_array_element($test_results['sanitize_post'], 'explanation', 'string');

// Expect a string
$test_results['sanitize_array'] = test_assert(  value:        $test                         ,
                                                type:         'string'                      ,
                                                assertion:    is_string($test)              ,
                                                success:      "Array entry is fetched"      ,
                                                failure:      "Array entry is not fetched"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for HTML output

// Sanitize a string
$test = sanitize_output("<te'st>");

// Expect it to be HTML ready
$test_results['sanitize_html'] = test_assert( value:        $test                             ,
                                              type:         'string'                          ,
                                              expectation:  "&lt;te&#039;st&gt;"              ,
                                              success:      "String is ready for output"      ,
                                              failure:      "String is not ready for output"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for HTML output with extra options

// Sanitize a string
$test = sanitize_output("Te\&
st",
preserve_line_breaks: true,
preserve_backslashes: true);

// Define the expected result
$expectations = "Te\&amp;<br />
st";

// Expect the test to match expectations
$test_results['sanitize_output'] = test_assert( value:        $test                                 ,
                                                type:         'string'                              ,
                                                expectation:  $expectations                         ,
                                                success:      "String is formatted for output"      ,
                                                failure:      "String is not formatted for output"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize untrusted user data for HTML output

// Sanitize a string
$test = sanitize_output_full('<img onclick="script.svg">');

// Define the expected result
$expectations = "&amp;lt;img onclick&zwnj;=&amp;quot;script.&zwnj;svg&amp;quot;&amp;gt;";

// Expect it to be fully sanitized
$test_results['sanitize_full'] = test_assert( value:        $test                           ,
                                              type:         'string'                        ,
                                              expectation:  $expectations                   ,
                                              success:      "String is fully sanitized"     ,
                                              failure:      "String is not fully sanitized" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for JS output

// Sanitize a string
$test = sanitize_output_full('String&more');

// Define the expected result
$expectations = "String&amp;amp;more";

// Expect it to be properly sanitized
$test_results['sanitize_js'] = test_assert( value:        $test                             ,
                                            type:         'string'                          ,
                                            expectation:  $expectations                     ,
                                            success:      "String is sanitized for JS"      ,
                                            failure:      "String is not sanitized for JS"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for usage in meta tags

// Sanitize a string
$test = sanitize_meta_tags('Meta <b> with [tags]');

// Define the expected result
$expectations = "Meta b with tags";

// Expect it to be properly sanitized
$test_results['sanitize_meta'] = test_assert( value:        $test                               ,
                                              type:         'string'                            ,
                                              expectation:  $expectations                       ,
                                              success:      "String is sanitized for meta"      ,
                                              failure:      "String is not sanitized for meta"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for usage in JSON

// Sanitize a string
$test = sanitize_json("Line
break");

// Define the expected result
$expectations = "Line\nbreak";

// Expect it to be properly sanitized
$test_results['sanitize_json'] = test_assert( value:        $test                               ,
                                              type:         'string'                            ,
                                              expectation:  $expectations                       ,
                                              success:      "String is sanitized for JSON"      ,
                                              failure:      "String is not sanitized for JSON"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize an array of data for usage in the API

// Sanitize an array
$test = sanitize_api_output(array('Entry 1', 'Entry 2', array('Sub entry 1', 'Sub entry 2')));

// Define the expected result
$expectations = sanitize_json(
<<<EOT
[
    "Entry 1",
    "Entry 2",
    [
        "Sub entry 1",
        "Sub entry 2"
    ]
]
EOT
);

// Expect it to be properly sanitized
$test_results['sanitize_api'] = test_assert(  value:        $test                                 ,
                                              type:         'string'                              ,
                                              expectation:  $expectations                         ,
                                              success:      "Array is sanitized for the API"      ,
                                              failure:      "Array is not sanitized for the API"  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                inc/fixtures.inc.php                                               */
/*                                                                                                                   */
/*                                               RANDOM DATA GENERATION                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Generate a random integer

// Generate the integer
$test = fixtures_generate_data('int', 10, 100);

// Expect the integer to be within bounds
$test_results['fixtures_int'] = test_assert(  value:      $test                           ,
                                              type:       'int'                           ,
                                              assertion:  ($test >= 10) && ($test <= 100) ,
                                              success:    "Random integer generated"      ,
                                              failure:    "Integer improperly generated"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Generate a random string

// Generate the string
$test = fixtures_generate_data('string', 5, 10);

// Expect the integer to be within bounds
$test_results['fixtures_string'] = test_assert( value:      $test                         ,
                                                type:       'string'                      ,
                                                assertion:  (strlen($test) > 0)           ,
                                                success:    "Random string generated"     ,
                                                failure:    "String improperly generated" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch a random existing ID

// Fetch an ID
$test = sanitize(fixtures_fetch_random_id('users'), 'int', 0);

// Expect the ID to exist
$test_results['fixtures_id'] = test_assert( value:      $test                               ,
                                            type:       'int'                               ,
                                            assertion:  database_row_exists('users', $test) ,
                                            success:    "Valid random ID fetched"           ,
                                            failure:    "Invalid random ID fetched"         );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch a random existing entry

// Fetch an entry
$test = sanitize(fixtures_fetch_random_value('users', 'username'), 'string');

// Check if the entry exists
$test_entry = sanitize(database_entry_exists('users', 'username', $test), 'int', 0);

// Expect the entry to have a valid ID
$test_results['fixtures_entry'] = test_assert(  value:      $test                                     ,
                                                type:       'string'                                  ,
                                                assertion:  database_row_exists('users', $test_entry) ,
                                                success:    "Valid random entry fetched"              ,
                                                failure:    "Invalid random entry fetched"            );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Check for an existing entry

// Fetch an entry
$test = sanitize(fixtures_fetch_random_value('users', 'username'), 'string');

// Check if the entry exists
$test_entry = sanitize(fixtures_check_entry('users', 'username', $test), 'bool');

// Expect the entry to exist
$test_results['fixtures_exists'] = test_assert( value:      $test                       ,
                                                type:       'string'                    ,
                                                assertion:  $test_entry                 ,
                                                success:    "Matching entry found"      ,
                                                failure:    "Matching entry not found"  );



/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                lang/common.lang.php                                               */
/*                                                                                                                   */
/*                                             TEMPLATES AND TRANSLATIONS                                            */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Translate a string

// Ask for a translation with extra requirements
$test = __('nobleme'      ,
        spaces_before:  1 ,
        spaces_after:   1 );

// Expect the translated string
$test_results['translation'] = test_assert( value:        $test                       ,
                                            type:         'string'                    ,
                                            expectation:  " NoBleme "                 ,
                                            success:      "Translation successful"    ,
                                            failure:      "Translation unsuccessful"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add a new string to the translation array

// Generate a random string
$test = fixtures_generate_data('text', 2, 3);

// Add a new translation to the current language
___('test_dummy_translation', $lang, $test);

// Expect the translation to be added to the global translations array
$test_results['translation_add'] = test_assert( value:        $test                               ,
                                                type:         'string'                            ,
                                                expectation:  __('test_dummy_translation')        ,
                                                success:      "New translation added"             ,
                                                failure:      "New translation can not be added"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemble an internal link

// Create a link
$test = __link( href:         './test'    ,
                text:         'Test'      ,
                style:        "italics"   ,
                is_internal:  true        ,
                path:         $path       ,
                onclick:      'action();' ,
                onmouseover:  'thing();'  ,
                id:           "test_id"   ,
                popup:        true        ,
                confirm:      "Confirm?"  );

// Define what the link should look like
$test_expectation = '<a  class="italics" href="./test" rel="noopener noreferrer" target="_blank" onclick="return confirm(\'Confirm?\'); action();" onmouseover="thing();" id="test_id">Test</a>';

// Expect the link to look like its assembled version
$test_results['translation_link'] = test_assert(  value:        $test                                 ,
                                                  type:         'string'                              ,
                                                  expectation:  $test_expectation                     ,
                                                  success:      "Internal link assembled correctly"   ,
                                                  failure:      "Internal link assembled incorrectly" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemble an external link

// Create an external link
$test = __link( href:         'https://nobleme.com/'  ,
                text:         'NoBleme'               ,
                is_internal:  false                   );

// Define what the link should look like
$test_expectation = '<a  class="bold" href="https://nobleme.com/"    >NoBleme</a>';

// Expect the link to look like its assembled version
$test_results['translation_extlink'] = test_assert( value:        $test                                 ,
                                                    type:         'string'                              ,
                                                    expectation:  $test_expectation                     ,
                                                    success:      "External link assembled correctly"   ,
                                                    failure:      "External link assembled incorrectly" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemble an icon

// Create an icon
$test = __icon( icon:         "test"      ,
                is_small:     "true"      ,
                href:         "./link"    ,
                is_internal:  true        ,
                class:        "pointer"   ,
                alt:          "Alt"       ,
                title:        "Title"     ,
                title_case:   "uppercase" ,
                use_dark:     true        ,
                use_light:    false       ,
                identifier:   "test_id"   ,
                path:         $path       ,
                onclick:      "action();" ,
                popup:        true        ,
                confirm:      "Confirm?"  );

// Define what the icon should look like
$test_expectation = '<a class="noglow" href="./link" rel="noopener noreferrer" target="_blank"><img  id="test_id" class="smallicon pointer" src="img/icons/test_small_dark.svg" alt="Alt" title="TITLE" onclick="return confirm(\'Confirm?\'); action();"></a>';

// Expect the icon to look like its assembled version
$test_results['translation_icon'] = test_assert(  value:        $test                         ,
                                                  type:         'string'                      ,
                                                  expectation:  $test_expectation             ,
                                                  success:      "Icon assembled correctly"    ,
                                                  failure:      "Icon assembled incorrectly"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assemble a tooltip

// Create a tooltip
$test = __tooltip(  title:          "Tooltip"   ,
                    tooltip_body:   "Body text" ,
                    title_style:    "uppercase" ,
                    tooltip_style:  "bold"      );

// Define what the tooltip should look like
$test_expectation = '<span class="tooltip_container uppercase">Tooltip<span class="tooltip bold">Body text</span></span>';

// Expect the tooltip to look like its assembled version
$test_results['translation_tooltip'] = test_assert( value:        $test                           ,
                                                    type:         'string'                        ,
                                                    expectation:  $test_expectation               ,
                                                    success:      "Tooltip assembled correctly"   ,
                                                    failure:      "Tooltip assembled incorrectly" );