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
                                      success:    "Query returned a mysqli_result"        ,
                                      failure:    "Query did not return a mysqli_result"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run a query and return its results

// Run the query
$test = query(" SELECT * FROM system_variables ",
                ignore_errors:  true    ,
                fetch_row:      true    ,
                row_format:     'both'  ,
                description:    'Test'  );

// Expect an array of values
$test_results['query_data'] = test_assert(  value:      $test                                   ,
                                            assertion:  is_array($test) && count($test) > 0     ,
                                            success:    "Query returned an array of data"       ,
                                            failure:    "Query did not return an array of data" ,
                                            type:       'array'                                 );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run a query and ignore errors

// Run the query
$test = query(" SELECT * FROM nowhere ", ignore_errors: true);

// Expect the boolean false
$test_results['query_err'] = test_assert( value:        $test                     ,
                                          expectation:  false                     ,
                                          success:      "Errors were ignored"     ,
                                          failure:      "Errors were not ignored" ,
                                          type:         'bool'                    );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the next row of a query

// Run the query, fetch the next row
$test = query_row(query(" SELECT * FROM system_variables "));

// Expect an array of values
$test_results['query_row'] = test_assert( value:      $test                                   ,
                                          assertion:  is_array($test) && count($test) > 0     ,
                                          success:    "Returned an array of data"             ,
                                          failure:    "Query did not return an array of data" ,
                                          type:       'array'                                 );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Count a query's rows

// Randomly limit row count to a low number
$test_count = rand(2, 4);

// Run a query, count its rows
$test = query_row_count(query(" SELECT * FROM users LIMIT $test_count "));

// Expect an array of values
$test_results['query_count'] = test_assert( value:        $test                             ,
                                            expectation:  $test_count                       ,
                                            success:      "Returned the number of rows"     ,
                                            failure:      "Returned a wrong number of rows" ,
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
                                          success:      "Last query ID was fetched"       ,
                                          failure:      "Wrong last query ID was fetched" ,
                                          type:         'int'                             );