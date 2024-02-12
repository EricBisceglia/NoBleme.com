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
$test_results['query']  = is_a($test, 'mysqli_result');
$test_returns['query']  = ($test_results['query'] === true)
                        ? "Returned a mysqli_result"
                        : "Did not return a mysqli_result";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run a query and return its results

// Run the query
$test = query(" SELECT * FROM system_variables ",
                ignore_errors:  true    ,
                fetch_row:      true    ,
                row_format:     'both'  ,
                description:    'Test'  );

// Expect an array of values
if(is_array($test) === true && count($test))
{
  $test_results['query_data'] = true;
  $test_returns['query_data'] = "Returned an array of data";
}
else if(is_array($test) && !count($test))
{
  $test_results['query_data'] = false;
  $test_returns['query_data'] = "Returned an array, but it is empty";
}
else
{
  $test_results['query_data'] = false;
  $test_returns['query_data'] = "Did not return an array of data";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run a query and ignore errors

// Run the query
$test = query(" SELECT * FROM nowhere ", ignore_errors: true);

// Expect the boolean false
$test_results['query_err']  = ($test === false);
$test_returns['query_err']  = ($test === false)
                            ? "Errors were ignored"
                            : "Errors were not ignored";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the next row of a query

// Run the query, fetch the next row
$test = query_row(query(" SELECT * FROM system_variables "));

// Expect an array of values
if(is_array($test) === true && count($test))
{
  $test_results['query_row']  = true;
  $test_returns['query_row']  = "Returned an array of data";
}
else if(is_array($test) && !count($test))
{
  $test_results['query_row']  = false;
  $test_returns['query_row']  = "Returned an array, but it is empty";
}
else
{
  $test_results['query_row']  = false;
  $test_returns['query_row']  = "Did not return an array of data";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Count a query's rows

// Randomly limit row count to a low number
$test_count = rand(2, 4);

// Run a query, count its rows
$test = query_row_count(query(" SELECT * FROM users LIMIT $test_count "));

// Expect the input number
if($test === $test_count)
{
  $test_results['query_count']  = true;
  $test_returns['query_count']  = "Returned the number of rows";
}
else if(is_int($test))
{
  $test_results['query_count']  = false;
  $test_returns['query_count']  = "Returned a wrong number of rows";
}
else
{
  $test_results['query_count']  = false;
  $test_returns['query_count']  = "Did not return a number of rows";
}




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
$test_results['query_id'] = ($test_id === $test_version_id);
$test_returns['query_id'] = ($test_id === $test_version_id)
                          ? "Last query ID was fetched"
                          : "Last query ID was not fetched";