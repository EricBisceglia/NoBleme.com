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
                                            assertion:  is_array($test) && count($test) > 0       ,
                                            success:    "Query returns an array of data"          ,
                                            failure:    "Query does not return an array of data"  ,
                                            type:       'array'                                   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run a query and ignore errors

// Run the query
$test = query(" SELECT * FROM nowhere ", ignore_errors: true);

// Expect the boolean false
$test_results['query_err'] = test_assert( value:        $test                     ,
                                          expectation:  false                     ,
                                          success:      "Errors are ignored"      ,
                                          failure:      "Errors are not ignored"  ,
                                          type:         'bool'                    );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the next row of a query

// Run the query, fetch the next row
$test = query_row(query(" SELECT * FROM system_variables "));

// Expect an array of values
$test_results['query_row'] = test_assert( value:      $test                                     ,
                                          assertion:  is_array($test) && count($test) > 0       ,
                                          success:    "Returns an array of data"                ,
                                          failure:    "Query does not return an array of data"  ,
                                          type:       'array'                                   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Count a query's rows

// Randomly limit row count to a low number
$test_count = rand(2, 4);

// Run a query, count its rows
$test = query_row_count(query(" SELECT * FROM users LIMIT $test_count "));

// Expect an array of values
$test_results['query_count'] = test_assert( value:        $test                             ,
                                            expectation:  $test_count                       ,
                                            success:      "Returns the number of rows"      ,
                                            failure:      "Returns a wrong number of rows"  ,
                                            type:         'int'                             );




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
                                          expectation:  $test_version_id                  ,
                                          success:      "Last query ID is fetched"        ,
                                          failure:      "Wrong last query ID is fetched"  ,
                                          type:         'int'                             );




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
                                                expectation:  "Te\'st"                  ,
                                                success:      "String is sanitized"     ,
                                                failure:      "String is not sanitized" ,
                                                type:         'string'                  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize an integer

// Sanitize a string into an integer
$test = sanitize("15", 'int');

// Expect an integer
$test_results['sanitize_int'] = test_assert(  value:        $test                       ,
                                              expectation:  15                          ,
                                              success:      "Integer is sanitized"      ,
                                              failure:      "Integer is not sanitized"  ,
                                              type:         'int'                       );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize a boolean

// Sanitize a string into a boolean
$test = sanitize("false", 'bool');

// Expect a boolean
$test_results['sanitize_bool'] = test_assert( value:        $test                       ,
                                              expectation:  false                       ,
                                              success:      "Boolean is sanitized"      ,
                                              failure:      "Boolean is not sanitized"  ,
                                              type:         'bool'                      );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize a float

// Sanitize an int into a float
$test = sanitize(1, 'float');

// Expect a float
$test_results['sanitize_float'] = test_assert(  value:        $test                     ,
                                                expectation:  (float)1                  ,
                                                success:      "Float is sanitized"      ,
                                                failure:      "Float is not sanitized"  ,
                                                type:         'float'                   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize and apply minimum value

// Randomly decide a minimum value
$test_minimum = rand(-5, 5);

// Apply a minimum value to an integer
$test = sanitize(-10, 'int', $test_minimum);

// Expect the minimum value
$test_results['sanitize_min'] = test_assert(  value:        $test                                 ,
                                              expectation:  $test_minimum                         ,
                                              success:      "Integer has minimum value"           ,
                                              failure:      "Integer does not have minimum value" ,
                                              type:         'int'                                 );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize and apply maximum value to an int

// Randomly decide a maximum value
$test_maximum = rand(-5, 5);

// Apply a maximum value to an integer
$test = sanitize(10, 'int', -10, $test_maximum);

// Expect the maximum value
$test_results['sanitize_max'] = test_assert(  value:        $test                                 ,
                                              expectation:  $test_maximum                         ,
                                              success:      "Integer has maximum value"           ,
                                              failure:      "Integer does not have maximum value" ,
                                              type:         'int'                                 );




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
                                              expectation:  "Lo\'ngxxxxx"                         ,
                                              success:      "String is trimmed and padded"        ,
                                              failure:      "String is wrongly trimmed or padded" ,
                                              type:         'string'                              );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize an input

// Fetch and sanitize the input which triggered these tests
$test = sanitize_input('POST', 'dev_tests_core', 'string');

// Expect the default value of a checkbox
$test_results['sanitize_post'] = test_assert( value:        $test                     ,
                                              expectation:  "on"                      ,
                                              success:      "Postdata is fetched"     ,
                                              failure:      "Postdata is not fetched" ,
                                              type:         'string'                  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize an array entry

// Pick the latest test result and sanitize it
$test = sanitize_array_element($test_results['sanitize_post'], 'explanation', 'string');

// Expect a string
$test_results['sanitize_array'] = test_assert(  value:        $test                         ,
                                                assertion:    is_string($test)              ,
                                                success:      "Array entry is fetched"      ,
                                                failure:      "Array entry is not fetched"  ,
                                                type:         'string'                      );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for HTML output

// Sanitize a string
$test = sanitize_output("<te'st>");

// Expect it to be HTML ready
$test_results['sanitize_html'] = test_assert( value:        $test                             ,
                                              expectation:  "&lt;te&#039;st&gt;"              ,
                                              success:      "String is ready for output"      ,
                                              failure:      "String is not ready for output"  ,
                                              type:         'string'                          );




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
                                                expectation:  $expectations                         ,
                                                success:      "String is formatted for output"      ,
                                                failure:      "String is not formatted for output"  ,
                                                type:         'string'                              );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize untrusted user data for HTML output

// Sanitize a string
$test = sanitize_output_full('<img onclick="script.svg">');

// Define the expected result
$expectations = "&amp;lt;img onclick&zwnj;=&amp;quot;script.&zwnj;svg&amp;quot;&amp;gt;";

// Expect it to be fully sanitized
$test_results['sanitize_full'] = test_assert( value:        $test                           ,
                                              expectation:  $expectations                   ,
                                              success:      "String is fully sanitized"     ,
                                              failure:      "String is not fully sanitized" ,
                                              type:         'string'                        );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for JS output

// Sanitize a string
$test = sanitize_output_full('String&more');

// Define the expected result
$expectations = "String&amp;amp;more";

// Expect it to be properly sanitized
$test_results['sanitize_js'] = test_assert( value:        $test                             ,
                                            expectation:  $expectations                     ,
                                            success:      "String is sanitized for JS"      ,
                                            failure:      "String is not sanitized for JS"  ,
                                            type:         'string'                          );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for usage in meta tags

// Sanitize a string
$test = sanitize_meta_tags('Meta <b> with [tags]');

// Define the expected result
$expectations = "Meta b with tags";

// Expect it to be properly sanitized
$test_results['sanitize_meta'] = test_assert( value:        $test                               ,
                                              expectation:  $expectations                       ,
                                              success:      "String is sanitized for meta"      ,
                                              failure:      "String is not sanitized for meta"  ,
                                              type:         'string'                            );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sanitize data for usage in JSON

// Sanitize a string
$test = sanitize_json("Line
break");

// Define the expected result
$expectations = "Line\nbreak";

// Expect it to be properly sanitized
$test_results['sanitize_json'] = test_assert( value:        $test                               ,
                                              expectation:  $expectations                       ,
                                              success:      "String is sanitized for JSON"      ,
                                              failure:      "String is not sanitized for JSON"  ,
                                              type:         'string'                            );




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
                                              expectation:  $expectations                         ,
                                              success:      "Array is sanitized for the API"      ,
                                              failure:      "Array is not sanitized for the API"  ,
                                              type:         'string'                              );