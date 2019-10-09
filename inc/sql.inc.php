<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Open a connexion to the MySQL database - include it any time you need to run a query

// Initialize the connexion and store it for into a global variable - if requested, don't connect to the nobleme db
if(isset($GLOBALS['sql_database_agnostic']))
  $GLOBALS['db'] = @mysqli_connect($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_pass']) or die ('MySQL error: Connexion failed.');
else
  $GLOBALS['db'] = @mysqli_connect($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_pass'], 'nobleme') or die ('MySQL error: Connexion failed.');

// Initialize a session specific global query counter, used by admins for metrics (number of queries in a page)
$GLOBALS['query'] = -1;

// Use this opportunity to set the global charset - it uses one mandatory query, hence why counter starts at -1
mysqli_set_charset($GLOBALS['db'], "utf8mb4");
query(' SET NAMES utf8mb4 ');




/**
 * Execute a MySQL query.
 *
 * This function will use the global connexion to the database to execute a MySQL query.
 * As it is basically a global wrapper for MySQL usage, you should always use this function when executing a query.
 * Keep in mind that no sanitization/escaping is being done here, you must add your own (see sanitization.inc.php).
 *
 * @param   string      $query                      The query that you want to run.
 * @param   string|int  $ignore_errors  (OPTIONAL)  Do not stop execution if an error is encountered.
 *
 * @return  object                                  The result of the query, in the form of a mysqli_object.
 */

function query($query, $ignore_errors=NULL)
{
  // First off let's increment the global query counter for this session
  $GLOBALS['query']++;

  // If errors are ignored, just run the query and whatever happens happens
  if($ignore_errors)
    $query_result = @mysqli_query($GLOBALS['db'],$query);

  // Otherwise, run the query and stop the script if anything goes wrong
  else
    $query_result = mysqli_query($GLOBALS['db'],$query) or die ("MySQL error:<br>".mysqli_error($GLOBALS['db']));

  // Return the result of the query
  return $query_result;
}