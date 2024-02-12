<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }

// Limit page access rights
user_restrict_to_administrators();

// Only allow this page to be ran in dev mode
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

// Run a query and return its results
$test = query(" SELECT * FROM system_variables ",
                ignore_errors:  true    ,
                fetch_row:      true    ,
                row_format:     'both'  ,
                description:    'Test'  );

// Expect an array of values
if(is_array($test) === true && count($test))
{
  $test_results['query2'] = true;
  $test_returns['query2'] = "Returned an array of data";
}
else if(is_array($test) && !count($test))
{
  $test_results['query2'] = false;
  $test_returns['query2'] = "Returned an array, but it is empty";
}
else
{
  $test_results['query2'] = false;
  $test_returns['query2'] = "Did not return an array of data";
}