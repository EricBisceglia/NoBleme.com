<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                  THIS PAGE CAN ONLY BE RAN ON A DEV ENVIRONMENT                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*        Running this script will create a new `nobleme` database or replace any existing `nobleme` database        */
/*                                                                                                                   */
/*              It will be populated with the latest database schema required to make the website work               */
/*    It will also include fixtures (demo data) so that you can actually interact with the website's various pages   */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Only allow this page to be ran in dev mode, it wouldn't be nice to accidentally wipe production data, would it?
include_once './inc/configuration.inc.php';
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));

// Include global settings and the local configuration file
include_once "./inc/settings.inc.php";

// Include mysql functions - but specify this is a special mode
$GLOBALS['sql_database_agnostic'] = 1;
include_once "./inc/sql.inc.php";

// Seek user confirmation before doing any harm
if(isset($_POST['fixtures_reset']))
{
  // Delete and recreate the `nobleme` database
  query(" DROP DATABASE IF EXISTS nobleme ");
  query(" CREATE DATABASE IF NOT EXISTS nobleme DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

  // Specify that queries should be done on the `nobleme` database
  $GLOBALS['db'] = @mysqli_connect($GLOBALS['mysql_host'], $GLOBALS['mysql_user'], $GLOBALS['mysql_pass'], 'nobleme') or die ('MySQL error: Connexion failed 2.');

  // Make sure we're using the correct character set
  mysqli_set_charset($GLOBALS['db'], "utf8mb4");
  query(' SET NAMES utf8mb4 ');

  // Import the database schema
  $database_schema = explode(';', file_get_contents('./inc/sqldump_schema.sql'));

  // Run each query in the schema except the first one
  foreach($database_schema as $schema_query_id => $schema_query)
  {
    if($schema_query_id && $schema_query)
      query($schema_query);
  }

  // Import and run fixtures aswell to fill up the database
  include_once './inc/sqldump_fixtures.php';

  // Finished!
  exit("Job's done! Check your database for confirmation.<br><br><a href=\"index\">Click here</a> to return to the website's index.");
}

// Ask for user confirmation before resetting the database ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>NoBleme - Database reset</title>
  </head>
  <body>
    <form method="post" action="fixtures">
      Are you sure you want to wipe any local database you have under the name <i>nobleme</i> then create a new one with baseline fixtures?<br>
      <br>
      If yes, <button name="fixtures_reset">click here</button> and clench your butt patiently until the (possibly lengthy) operation is done.<br>
      <br>
      There is no progress bar, but don't get fooled, if it's running then it's actually doing some work.<br>
      <br>
      If it does not work, you probably have incorrect settings in <i>/inc/configuration.inc.php</i>
    </form>
  </body>
</html>