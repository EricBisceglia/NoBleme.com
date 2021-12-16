<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*       This page contains an archive of older SQL queries that might be ran during an update of the website.       */
/*                   It can only be called by a website admin through the page /pages/dev/queries.                   */
/*     Since this page is only called once during each update, performance optimization is not an issue at all.      */
/*                                                                                                                   */
/*       A bunch of functions for manipulating SQL are included in this page, making it a proto-ORM of sorts.        */
/*   Queries are done in such a way that they can only be ran once, avoiding a lot of potential silly situations.    */
/*                                                                                                                   */
/*        If you want to modifiy the database structure, do it by adding content to the bottom of this page.         */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Include pages that are required to make MySQL queries
include_once 'settings.inc.php';     # General settings
include_once 'error.inc.php';        # Error management
include_once 'sql.inc.php';          # MySQL connection
include_once 'sanitization.inc.php'; # Data sanitization

// If the database still uses the old data structure, then skip the other includes
$old_structure = 0;
$qtablelist = query(" SHOW TABLES ");
while($dtablelist = mysqli_fetch_array($qtablelist))
  $old_structure = ($dtablelist[0] == 'vars_globales') ? 1 : $old_structure;

// If the database uses the current data structure, proceed with the checks
if(!$old_structure)
{
  // Include user rights management
  include_once 'users.inc.php';

  // Only allow admins to use this page
  if(!user_is_administrator())
    exit(header("Location: .."));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                       FUNCTIONS USED FOR STRUCTURAL QUERIES                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*     These functions allow for "safe" manipulation of the database, and should only be used within this file.      */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*  sql_check_query_id        Checks whether a query should be ran or not.                                           */
/*  sql_update_query_id       Updates th ID of the last query that was ran.                                          */
/*                                                                                                                   */
/*  sql_create_table          Creates a new table.                                                                   */
/*  sql_rename_table          Renames an existing table.                                                             */
/*  sql_empty_table           Gets rid of all the data in an existing table.                                         */
/*  sql_delete_table          Deletes an existing table.                                                             */
/*                                                                                                                   */
/*  sql_create_field          Creates a new field in an existing table.                                              */
/*  sql_rename_field          Renames an existing field in an existing table.                                        */
/*  sql_change_field_type     Changes the type of an existing field in an existing table.                            */
/*  sql_move_field            Moves an existing field in an existing table.                                          */
/*  sql_delete_field          Deletes an existing field in an existing table.                                        */
/*                                                                                                                   */
/*  sql_create_index          Creates an index in an existing table.                                                 */
/*  sql_delete_index          Deletes an existing index in an existing table.                                        */
/*                                                                                                                   */
/*  sql_insert_value          Inserts a value in an existing table.                                                  */
/*                                                                                                                   */
/*  sql_sanitize_data         Sanitizes data for MySQL queries.                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Checks whether a query should be ran or not.
 *
 * @return  int|null  Returns null if the query should be ran, otherwise return the id of the latest query that ran.
 */

function sql_check_query_id() : mixed
{
  // As the name of the global variables table has been changed, check everything twice
  $query_ok     = 0;
  $query_ok_old = 0;

  // Proceed only if the table exists
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
  {
    $query_ok     = ($dtablelist[0] == 'system_variables')  ? 1 : $query_ok;
    $query_ok_old = ($dtablelist[0] == 'vars_globales')     ? 1 : $query_ok_old;
  }
  if(!$query_ok && !$query_ok_old)
    return NULL;

  // If it does exist, then fetch need its structure
  if($query_ok)
    $qdescribe = query(" DESCRIBE system_variables ");
  else
    $qdescribe = query(" DESCRIBE vars_globales ");

  // Proceed only if the field exists
  $field_exists = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($query_ok)
      $field_exists = ($ddescribe['Field'] != "latest_query_id") ? 1 : $field_exists;
    else
      $field_exists = ($ddescribe['Field'] != "derniere_requete_sql") ? 1 : $field_exists;
  }

  // If the query can't be run, abort here
  if(!$field_exists)
    return NULL;

  // Fetch the id of the last query that was ran
  if($query_ok)
    $last_query = mysqli_fetch_array(query("  SELECT    system_variables.latest_query_id AS 'latest_query_id'
                                              FROM      system_variables
                                              ORDER BY  system_variables.latest_query_id DESC
                                              LIMIT     1 "));
  else
    $last_query = mysqli_fetch_array(query("  SELECT    vars_globales.derniere_requete_sql AS 'latest_query_id'
                                              FROM      vars_globales
                                              ORDER BY  vars_globales.derniere_requete_sql DESC
                                              LIMIT     1 "));

  // Return that id
  return $last_query['latest_query_id'];
}




/**
 * Updates th ID of the last query that was ran.
 *
 * @param   int   $id   ID of the query.
 *
 * @return  void
 */

function sql_update_query_id( int $id ) : void
{
  // As the name of the global variables table has been changed, check everything twice
  $query_ok     = 0;
  $query_ok_old = 0;

  // Proceed only if the table exists
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
  {
    $query_ok     = ($dtablelist[0] == 'system_variables')  ? 1 : $query_ok;
    $query_ok_old = ($dtablelist[0] == 'vars_globales')     ? 1 : $query_ok_old;
  }
  if(!$query_ok && !$query_ok_old)
    return;

  // If it does exist, then fetch its structure
  if($query_ok)
    $qdescribe = query(" DESCRIBE system_variables");
  else
    $qdescribe = query(" DESCRIBE vars_globales");

  // Proceed only if the field exists
  $field_exists = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($query_ok)
      $field_exists = ($ddescribe['Field'] != "latest_query_id") ? 1 : $field_exists;
    else
      $field_exists = ($ddescribe['Field'] != "derniere_requete_sql") ? 1 : $field_exists;
  }

  // If the query can't be ran, abort
  if(!$field_exists)
    return;

  // Data sanitization
  $id = intval($id);

  // Update the id in the database
  if($query_ok)
    query(" UPDATE  system_variables
            SET     system_variables.latest_query_id = $id ");
  else
    query(" UPDATE  vars_globales
            SET     vars_globales.derniere_requete_sql = $id ");
}




/**
 * Creates a new table.
 *
 * The table will only contain one field, called "id", an auto incremented primary key.
 *
 * @param   string  $table_name   The name of the table to create.
 *
 * @return  void
 */

function sql_create_table( string $table_name ) : void
{
  // Create the table
  query(" CREATE TABLE IF NOT EXISTS ".$table_name." ( id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM;");
}




/**
 * Renames an existing table.
 *
 * @param   string  $table_name   The old name of the table.
 * @param   string  $new_name     The new name of the table.
 *
 * @return  void
 */

function sql_rename_table(  string  $table_name ,
                            string  $new_name   ) : void
{
  // Proceed only if the table exists and the new table name is not taken
  $query_old_ok = 0;
  $query_new_ok = 1;
  $qtablelist   = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
  {
    $query_old_ok = ($dtablelist[0] == $table_name) ? 1 : $query_old_ok;
    $query_new_ok = ($dtablelist[0] == $new_name)   ? 0 : $query_new_ok;
  }
  if(!$query_old_ok || !$query_new_ok)
    return;

  // Rename the table
  query(" ALTER TABLE $table_name RENAME $new_name ");
}




/**
 * Gets rid of all the data in an existing table.
 *
 * @param   string  $table_name   The table's name.
 *
 * @return  void
 */

function sql_empty_table( string $table_name ) : void
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Purge the table's contents
  query(" TRUNCATE TABLE ".$table_name);
}




/**
 * Deletes an existing table.
 *
 * @param   string  $table_name   The table's name.
 *
 * @return  void
 */

function sql_delete_table( string $table_name ) : void
{
  // Delete the table
  query(" DROP TABLE IF EXISTS ".$table_name);
}




/**
 * Creates a new field in an existing table.
 *
 * @param   string  $table_name         The existing table's name.
 * @param   string  $field_name         The new field's name.
 * @param   string  $field_type         The new field's MySQL type.
 * @param   string  $after_field_name   The name of the field that is located before the emplacement of the new one.
 *
 * @return  void
 */

function sql_create_field(  string  $table_name       ,
                            string  $field_name       ,
                            string  $field_type       ,
                            string  $after_field_name ) : void
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Proceed only if the preceeding field exists
  $query_ok = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $query_ok = ($ddescribe['Field'] == $after_field_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure yet again
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Proceed only if the field doesn't already exist
  $query_ko = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $query_ko = ($ddescribe['Field'] == $field_name) ? 1 : $query_ko;
  if($query_ko)
    return;

  // Run the query
  query(" ALTER TABLE ".$table_name." ADD ".$field_name." ".$field_type." AFTER ".$after_field_name);
}




/**
 * Renames an existing field in an existing table.
 *
 * @param   string  $table_name       The existing table's name.
 * @param   string  $old_field_name   The field's old name.
 * @param   string  $new_field_name   The field's new name.
 * @param   string  $field_type       The MySQL type of the field.
 *
 * @return  void
 */

function sql_rename_field(  string  $table_name     ,
                            string  $old_field_name ,
                            string  $new_field_name ,
                            string  $field_type     ) : void
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Continue only if the new field name doesn't exist
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if ($ddescribe['Field'] == $new_field_name)
      return;
  }

  // Fetch the table's structure yet again
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, rename it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $old_field_name)
      query(" ALTER TABLE ".$table_name." CHANGE ".$old_field_name." ".$new_field_name." ".$field_type);
  }
}




/**
 * Changes the type of an existing field in an existing table.
 *
 * @param   string  $table_name   The existing table's name.
 * @param   string  $field_name   The existing field's name.
 * @param   string  $field_type   The MySQL type to give the field.
 *
 * @return  void
 */

function sql_change_field_type( string  $table_name ,
                                string  $field_name ,
                                string  $field_type ) : void
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, rename it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $field_name)
      query(" ALTER TABLE ".$table_name." MODIFY ".$field_name." ".$field_type);
  }
}




/**
 * Moves an existing field in an existing table.
 *
 * @param   string  $table_name         The existing table's name.
 * @param   string  $field_name         The existing field's name.
 * @param   string  $field_type         The MySQL type of the field.
 * @param   string  $after_field_name   The name of the field that is located before the emplacement of the new one.
 *
 * @return  void
 */

function sql_move_field(  string  $table_name       ,
                          string  $field_name       ,
                          string  $field_type       ,
                          string  $after_field_name ) : void
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Continue only if both of the field names actually exist
  $field_ok       = 0;
  $field_after_ok = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    $field_ok       = ($ddescribe['Field'] == $field_name)        ? 1 : $field_ok;
    $field_after_ok = ($ddescribe['Field'] == $after_field_name)  ? 1 : $field_after_ok;
  }
  if(!$field_ok || !$field_after_ok)
    return;

  // Move the field
  query(" ALTER TABLE ".$table_name." MODIFY COLUMN ".$field_name." ".$field_type." AFTER ".$after_field_name);
}




/**
 * Deletes an existing field in an existing table.
 *
 * @param   string  $table_name   The existing table's name.
 * @param   string  $field_name   The existing field's name
 *
 * @return  void
 */

function sql_delete_field(  string  $table_name ,
                            string  $field_name ) : void
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, delete it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $field_name)
      query(" ALTER TABLE ".$table_name." DROP ".$field_name);
  }
}




/**
 * Creates an index in an existing table.
 *
 * @param   string  $table_name               The name of the existing table.
 * @param   string  $index_name               The name of the index that will be created.
 * @param   string  $field_names              One or more fields to be indexed (eg. "my_field, other_field").
 * @param   bool    $fulltext     (OPTIONAL)  If set, the index will be created as fulltext.
 *
 * @return  void
 */

function sql_create_index(  string  $table_name           ,
                            string  $index_name           ,
                            string  $field_names          ,
                            bool    $fulltext     = false )
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Check whether the index already exists
  $qindex = query(" SHOW INDEX FROM ".$table_name." WHERE key_name LIKE '".$index_name."' ");

  // If it does not exist yet, then can create it and run a check to populate the table's indexes
  if(!mysqli_num_rows($qindex))
  {
    $temp = ($fulltext) ? ' FULLTEXT ' : '';
    query(" ALTER TABLE ".$table_name."
            ADD ".$temp." INDEX ".$index_name." (".$field_names."); ");
    query(" CHECK TABLE ".$table_name." ");
  }
}




/**
 * Deletes an existing index in an existing table.
 *
 * @param   string  $table_name   The existing table's name.
 * @param   string  $index_name   The existing index's name.
 *
 * @return  void
 */

function sql_delete_index(  string  $table_name ,
                            string  $index_name ) : void
{
  // Proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Check whether the index already exists
  $qindex = query(" SHOW INDEX FROM ".$table_name." WHERE key_name LIKE '".$index_name."' ");

  // If it exists, delete it and run a check to depopulate the index
  if(mysqli_num_rows($qindex))
  {
    query(" ALTER TABLE ".$table_name."
            DROP INDEX ".$index_name );
    query(" CHECK TABLE ".$table_name." ");
  }
}




/**
 * Inserts a value in an existing table.
 *
 * The only way to clarify the way this function works is with a concrete example, so here you go:
 * sql_insert_value(" SELECT my_string, my_int FROM my_table WHERE my_string LIKE 'test' AND my_int = 1 ",
 * " INSERT INTO my_table SET my_string = 'test' , my_int = 1 ");
 *
 * @param   string  $condition  A condition that must be matched before the query is ran.
 * @param   string  $query      The query to be ran to insert the value.
 *
 * @return  void
 */

function sql_insert_value(  string  $condition  ,
                            string  $query      ) : void
{
  // If the condition is met, run the query
  if(!mysqli_num_rows(query($condition)))
    query($query);
}




/**
 * Sanitizes data for MySQL queries.
 *
 * @param   mixed  $data  The data to sanitize.
 *
 * @return  mixed         The sanitized data
 */

function sql_sanitize_data( mixed $data ) : mixed
{
  // Sanitize the data using the currently open MySQL connection
  return trim(mysqli_real_escape_string($GLOBALS['db'], $data));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   QUERY HISTORY                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                               Allows replaying of queries that haven't been run yet                               */
/*              in order to ensure a version upgrade between any two versions of NoBleme goes smoothly               */
/*                                                                                                                   */
/*                                 Older queries are archived in queries.archive.php                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Those queries are treated like data migrations and will only be ran once, hence the storing of the last query id

// Fetch the id of the last query that was run
$last_query = sql_check_query_id();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 VERSION 4 BUILD 1                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - System tables

if($last_query < 20)
{
  sql_rename_table('automatisation', 'system_scheduler');
  sql_rename_table('vars_globales', 'system_variables');
  sql_rename_table('version', 'system_versions');

  sql_change_field_type('system_scheduler', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('system_scheduler', 'action_id', 'task_id', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('system_scheduler', 'action_type', 'task_type', 'VARCHAR(40) NOT NULL');
  sql_rename_field('system_scheduler', 'action_description', 'task_description', 'TEXT NOT NULL');
  sql_rename_field('system_scheduler', 'action_timestamp', 'planned_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('system_scheduler', 'planned_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_delete_index('system_scheduler', 'index_action');
  sql_create_index('system_scheduler', 'index_task_id', 'task_id');

  query(" DELETE FROM system_scheduler
          WHERE       system_scheduler.task_type LIKE 'ecrivains_*' ");

  $qbans = query("  SELECT  membres.id            AS 'm_id'   ,
                            membres.pseudonyme    AS 'm_nick' ,
                            membres.banni_date    AS 'm_date'
                    FROM    membres
                    WHERE   membres.banni_date > 0 ");
  while($dbans = mysqli_fetch_array($qbans))
  {
    $ban_id   = sanitize($dbans['m_id'], 'int');
    $ban_nick = sanitize($dbans['m_nick'], 'string');
    $ban_end  = sanitize($dbans['m_date'], 'int');
    query(" INSERT INTO system_scheduler
            SET         system_scheduler.planned_at       = '$ban_end'    ,
                        system_scheduler.task_id          = '$ban_id'     ,
                        system_scheduler.task_type        = 'users_unban' ,
                        system_scheduler.task_description = '$ban_nick'   ");
  }

  sql_rename_field('system_variables', 'mise_a_jour', 'update_in_progress', 'INT UNSIGNED NOT NULL PRIMARY KEY');
  sql_rename_field('system_variables', 'derniere_requete_sql', 'latest_query_id', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('system_variables', 'last_scheduler_execution', 'INT UNSIGNED NOT NULL DEFAULT 0', 'latest_query_id');
  sql_change_field_type('system_variables', 'last_pageview_check', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('system_variables', 'mise_a_jour');
  sql_create_field('system_variables', 'irc_bot_is_silenced', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0', 'last_pageview_check');
  sql_create_field('system_variables', 'discord_is_silenced', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0', 'irc_bot_is_silenced');

  query(" UPDATE  system_versions
          SET     system_versions.version = 0
          WHERE   system_versions.version LIKE 'beta' ");

  sql_change_field_type('system_versions', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('system_versions', 'version', 'major', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('system_versions', 'build', 'minor', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('system_versions', 'patch', 'INT UNSIGNED NOT NULL DEFAULT 0', 'minor');
  sql_create_field('system_versions', 'extension', 'VARCHAR(40) NOT NULL', 'patch');
  sql_rename_field('system_versions', 'date', 'release_date', 'DATE');
  sql_create_index('system_versions', 'index_date', 'release_date');

  query(" UPDATE  system_versions
          SET     system_versions.major     = 1                     ,
                  system_versions.patch     = system_versions.minor ,
                  system_versions.minor     = 0                     ,
                  system_versions.extension = 'beta'
          WHERE   system_versions.major     = 0                     ");

  sql_update_query_id(20);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Log tables

if($last_query < 21)
{
  sql_rename_table('activite', 'logs_activity');
  sql_rename_table('activite_diff', 'logs_activity_details');

  sql_change_field_type('logs_activity', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('logs_activity', 'timestamp', 'happened_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('logs_activity', 'log_moderation', 'is_moderators_only', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('logs_activity', 'language', 'VARCHAR(12) NOT NULL', 'is_moderators_only');
  sql_rename_field('logs_activity', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('logs_activity', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_rename_field('logs_activity', 'pseudonyme', 'activity_username', 'VARCHAR(45) NOT NULL');
  sql_rename_field('logs_activity', 'action_type', 'activity_type', 'VARCHAR(40) NOT NULL');
  sql_create_field('logs_activity', 'activity_amount', 'INT UNSIGNED NOT NULL DEFAULT 0', 'activity_type');
  sql_rename_field('logs_activity', 'action_id', 'activity_id', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('logs_activity', 'activity_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'activity_username');
  sql_create_field('logs_activity', 'activity_summary_en', 'TEXT NOT NULL', 'activity_amount');
  sql_rename_field('logs_activity', 'action_titre', 'activity_summary_fr', 'TEXT NOT NULL');
  sql_rename_field('logs_activity', 'parent', 'activity_parent', 'TEXT NOT NULL');
  sql_move_field('logs_activity', 'activity_username', 'VARCHAR(45) NOT NULL', 'activity_parent');
  sql_create_field('logs_activity', 'activity_moderator_username', 'VARCHAR(45) NOT NULL', 'activity_username');
  sql_rename_field('logs_activity', 'justification', 'moderation_reason', 'TEXT NOT NULL');
  sql_delete_index('logs_activity', 'index_membres');
  sql_delete_index('logs_activity', 'index_action');
  sql_delete_index('logs_activity', 'index_type');
  sql_create_index('logs_activity', 'index_related_user', 'fk_users');
  sql_create_index('logs_activity', 'index_language', 'language');
  sql_create_index('logs_activity', 'index_related_foreign_key', 'activity_id');
  sql_create_index('logs_activity', 'index_activity_type', 'activity_type(40)');

  sql_change_field_type('logs_activity_details', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('logs_activity_details', 'FKactivite', 'fk_logs_activity', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('logs_activity_details', 'titre_diff', 'content_description_fr', 'TEXT NOT NULL');
  sql_create_field('logs_activity_details', 'content_description_en', 'TEXT NOT NULL', 'fk_logs_activity');
  sql_rename_field('logs_activity_details', 'diff_avant', 'content_before', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('logs_activity_details', 'diff_apres', 'content_after', 'MEDIUMTEXT NOT NULL');
  sql_delete_index('logs_activity_details', 'index_activite');
  sql_create_index('logs_activity_details', 'index_logs_activity', 'fk_logs_activity');

  $logs_activity_language = array(  'version'                         => 'ENFR' ,
                                    'devblog'                         => 'FR'   ,
                                    'todo_new'                        => 'ENFR' ,
                                    'todo_fini'                       => 'ENFR' ,
                                    'register'                        => 'ENFR' ,
                                    'profil'                          => 'ENFR' ,
                                    'profil_edit'                     => 'ENFR' ,
                                    'editpass'                        => 'ENFR' ,
                                    'ban'                             => 'ENFR' ,
                                    'deban'                           => 'ENFR' ,
                                    'droits_delete'                   => 'ENFR' ,
                                    'droits_mod'                      => 'ENFR' ,
                                    'droits_sysop'                    => 'ENFR' ,
                                    'irl_new'                         => 'ENFR' ,
                                    'irl_edit'                        => 'ENFR' ,
                                    'irl_delete'                      => 'ENFR' ,
                                    'irl_add_participant'             => 'ENFR' ,
                                    'irl_edit_participant'            => 'ENFR' ,
                                    'irl_del_participant'             => 'ENFR' ,
                                    'quote_new_en'                    => 'ENFR' ,
                                    'quote_new_fr'                    => 'FR'   );

  foreach($logs_activity_language as $original_log => $log_language)
  {
    $original_log   = sanitize($original_log, 'string');
    $log_language   = sanitize($log_language, 'string');
    query(" UPDATE  logs_activity
            SET     logs_activity.language         = '$log_language'
            WHERE   logs_activity.activity_type LIKE '$original_log' ");
  }

  $logs_activity_translation = array( 'version'                         => 'dev_version'                ,
                                      'devblog'                         => 'dev_blog'                   ,
                                      'todo_new'                        => 'dev_task_new'               ,
                                      'todo_fini'                       => 'dev_task_finished'          ,
                                      'register'                        => 'users_register'             ,
                                      'profil'                          => 'users_profile_edit'         ,
                                      'profil_edit'                     => 'users_admin_edit_profile'   ,
                                      'editpass'                        => 'users_password'             ,
                                      'ban'                             => 'users_banned'               ,
                                      'deban'                           => 'users_unbanned'             ,
                                      'droits_delete'                   => 'users_rights_delete'        ,
                                      'droits_mod'                      => 'users_rights_old_moderator' ,
                                      'droits_sysop'                    => 'users_rights_moderator'     ,
                                      'irl_new'                         => 'meetups_new'                ,
                                      'irl_edit'                        => 'meetups_edit'               ,
                                      'irl_delete'                      => 'meetups_delete'             ,
                                      'irl_add_participant'             => 'meetups_people_new'         ,
                                      'irl_edit_participant'            => 'meetups_people_edit'        ,
                                      'irl_del_participant'             => 'meetups_people_delete'      ,
                                      'quote_new_en'                    => 'quotes_new_en'              ,
                                      'quote_new_fr'                    => 'quotes_new_fr'              );

  foreach($logs_activity_translation as $original_log => $translated_log)
  {
    $original_log   = sanitize($original_log, 'string');
    $translated_log = sanitize($translated_log, 'string');
    query(" UPDATE  logs_activity
            SET     logs_activity.activity_type    = '$translated_log'
            WHERE   logs_activity.activity_type LIKE '$original_log' ");
  }

  query(" DELETE FROM logs_activity
          WHERE       logs_activity.activity_type LIKE 'users_rights_old_moderator' ");

  query(" UPDATE  logs_activity
          SET     logs_activity.activity_summary_en = logs_activity.activity_summary_fr
          WHERE   logs_activity.activity_type    LIKE 'dev_version' ");

  query(" UPDATE  logs_activity
          SET     logs_activity.activity_summary_en = logs_activity.activity_parent
          WHERE ( logs_activity.activity_type    LIKE 'dev_task_%'
          OR      logs_activity.activity_type    LIKE 'internet_%' ) ");

  query(" UPDATE  logs_activity
          SET     logs_activity.activity_moderator_username = logs_activity.activity_username ,
                  logs_activity.activity_username           = ''
          WHERE ( logs_activity.activity_type            LIKE 'meetups_delete'
          OR      logs_activity.activity_type            LIKE 'meetups_edit'
          OR      logs_activity.activity_type            LIKE 'meetups_new' ) ");

  query(" UPDATE  logs_activity
          SET     logs_activity.activity_moderator_username = logs_activity.activity_parent ,
                  logs_activity.activity_parent             = ''
          WHERE ( logs_activity.activity_type            LIKE 'meetups_people_delete'
          OR      logs_activity.activity_type            LIKE 'meetups_people_edit'
          OR      logs_activity.activity_type            LIKE 'meetups_people_new'
          OR      logs_activity.activity_type            LIKE 'users_admin_edit_password'
          OR      logs_activity.activity_type            LIKE 'users_admin_edit_profile'
          OR      logs_activity.activity_type            LIKE 'users_banned'
          OR      logs_activity.activity_type            LIKE 'users_unbanned'
          OR      logs_activity.activity_type            LIKE 'users_profile_edit' ) ");

  query(" UPDATE  logs_activity
          SET     logs_activity.activity_amount   = logs_activity.activity_id ,
                  logs_activity.activity_id       = 0
          WHERE ( logs_activity.activity_type  LIKE 'users_banned'
          OR      logs_activity.activity_type  LIKE 'users_unbanned' ) ");

  query(" UPDATE  logs_activity
          SET     logs_activity.language            = 'FR'
          WHERE   logs_activity.activity_type    LIKE 'dev_task_%'
          AND     logs_activity.activity_summary_en = '' ");

  query(" UPDATE  logs_activity
          SET     logs_activity.language            = 'EN'
          WHERE   logs_activity.activity_type    LIKE 'internet_%'
          AND     logs_activity.activity_summary_fr = '' ");
  query(" UPDATE  logs_activity
          SET     logs_activity.language            = 'FR'
          WHERE   logs_activity.activity_type    LIKE 'internet_%'
          AND     logs_activity.activity_summary_en = '' ");

  query(" UPDATE  logs_activity
          SET     logs_activity.activity_amount   = 3650
          WHERE   logs_activity.activity_amount   = 3652
          AND     logs_activity.activity_type  LIKE 'users_banned' ");

  $logs_activity_details = array( 'Auteur'                => 'Author'                 ,
                                  'Contenu'               => 'Body'                   ,
                                  'Date de naissance'     => 'Date of birth'          ,
                                  'Détails (anglais)'     => 'Details (english)'      ,
                                  'Détails (en)'          => 'Details (english)'      ,
                                  'Détails (fr)'          => 'Details (french)'       ,
                                  'Détails (français)'    => 'Details (french)'       ,
                                  'Genre'                 => 'Gender'                 ,
                                  'Langues parlées'       => 'Spoken languages'       ,
                                  'Métier / Occupation'   => 'Job / Occupation'       ,
                                  'Présence confirmée'    => 'Confirmed attending'    ,
                                  'Texte'                 => 'Profile text'           ,
                                  'Texte libre'           => 'Profile text'           ,
                                  'Titre'                 => 'Title'                  ,
                                  'Ville / Région / Pays' => 'City / Area / Country'  );

  foreach($logs_activity_details as $original_log => $translated_log)
  {
    $original_log   = sanitize($original_log, 'string');
    $translated_log = sanitize($translated_log, 'string');
    query(" UPDATE  logs_activity_details
            SET     logs_activity_details.content_description_en    = '$translated_log'
            WHERE   logs_activity_details.content_description_fr LIKE '$original_log' ");
  }

  sql_delete_field('logs_activity', 'activity_parent');

  sql_create_table('logs_irc_bot');
  sql_create_field('logs_irc_bot', 'sent_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('logs_irc_bot', 'channel', 'TEXT NOT NULL', 'sent_at');
  sql_create_field('logs_irc_bot', 'body', 'TEXT NOT NULL', 'channel');
  sql_create_field('logs_irc_bot', 'is_silenced', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'body');
  sql_create_field('logs_irc_bot', 'is_failed', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_silenced');
  sql_create_field('logs_irc_bot', 'is_manual', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_failed');
  sql_create_field('logs_irc_bot', 'is_action', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_manual');
  sql_create_index('logs_irc_bot', 'index_sent_at', 'sent_at');

  sql_create_table('logs_scheduler');
  sql_create_field('logs_scheduler', 'happened_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('logs_scheduler', 'task_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'happened_at');
  sql_create_field('logs_scheduler', 'task_type', 'VARCHAR(40) NOT NULL', 'task_id');
  sql_create_field('logs_scheduler', 'task_description', 'TEXT NOT NULL', 'task_type');
  sql_create_field('logs_scheduler', 'execution_report', 'TEXT NOT NULL', 'task_description');
  sql_create_index('logs_scheduler', 'index_happened_at', 'happened_at');
  sql_create_index('logs_scheduler', 'index_related_foreign_key', 'task_id');
  sql_create_index('logs_scheduler', 'index_task_type', 'task_type(40)');

  sql_create_table('logs_bans');
  sql_create_field('logs_bans', 'fk_banned_user', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('logs_bans', 'banned_ip_address', 'VARCHAR(156) NOT NULL', 'fk_banned_user');
  sql_create_field('logs_bans', 'is_a_total_ip_ban', 'TINYINT NOT NULL DEFAULT 0', 'banned_ip_address');
  sql_create_field('logs_bans', 'fk_banned_by_user', 'INT UNSIGNED NOT NULL DEFAULT 0', 'is_a_total_ip_ban');
  sql_create_field('logs_bans', 'fk_unbanned_by_user', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_banned_by_user');
  sql_create_field('logs_bans', 'banned_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_unbanned_by_user');
  sql_create_field('logs_bans', 'banned_until', 'INT UNSIGNED NOT NULL DEFAULT 0', 'banned_at');
  sql_create_field('logs_bans', 'unbanned_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'banned_until');
  sql_create_field('logs_bans', 'ban_reason_en', 'TEXT NOT NULL', 'unbanned_at');
  sql_create_field('logs_bans', 'ban_reason_fr', 'TEXT NOT NULL', 'ban_reason_en');
  sql_create_field('logs_bans', 'unban_reason_en', 'TEXT NOT NULL', 'ban_reason_fr');
  sql_create_field('logs_bans', 'unban_reason_fr', 'TEXT NOT NULL', 'unban_reason_en');
  sql_create_index('logs_bans', 'index_banned_user', 'fk_banned_user');
  sql_create_index('logs_bans', 'index_banned_until', 'banned_until');
  sql_create_index('logs_bans', 'index_unbanned_at', 'unbanned_at');

  $qbans = query("  SELECT  membres.id            AS 'm_id'   ,
                            membres.banni_date    AS 'm_date' ,
                            membres.banni_raison  AS 'm_reason'
                    FROM    membres
                    WHERE   membres.banni_date > 0 ");
  while($dbans = mysqli_fetch_array($qbans))
  {
    $ban_id     = sanitize($dbans['m_id'], 'int');
    $ban_start  = sanitize(strtotime('-10 years', $dbans['m_date']), 'int');
    $ban_end    = sanitize($dbans['m_date'], 'int');
    $ban_reason = sanitize($dbans['m_reason'], 'string');
    query(" INSERT INTO logs_bans
            SET         logs_bans.fk_banned_user    = '$ban_id'     ,
                        logs_bans.fk_banned_by_user = 1             ,
                        logs_bans.banned_at         = '$ban_start'  ,
                        logs_bans.banned_until      = '$ban_end'    ,
                        logs_bans.ban_reason_fr     = '$ban_reason' ");
  }

  sql_update_query_id(21);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Stats tables

if($last_query < 22)
{
  sql_rename_table('pageviews', 'stats_pages');

  sql_change_field_type('stats_pages', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('stats_pages', 'nom_page', 'page_name_fr', 'TEXT NOT NULL');
  sql_create_field('stats_pages', 'page_name_en', 'TEXT NOT NULL', 'id');
  sql_rename_field('stats_pages', 'url_page', 'page_url', 'TEXT NOT NULL');
  sql_create_field('stats_pages', 'last_viewed_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'page_url');
  sql_rename_field('stats_pages', 'vues', 'view_count', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('stats_pages', 'vues_lastvisit', 'view_count_archive', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('stats_pages', 'query_count', 'INT UNSIGNED NOT NULL DEFAULT 0', 'view_count_archive');
  sql_create_field('stats_pages', 'load_time', 'INT UNSIGNED NOT NULL DEFAULT 0', 'query_count');
  sql_delete_index('stats_pages', 'index_tri');
  sql_delete_index('stats_pages', 'index_recherche');
  sql_create_index('stats_pages', 'index_view_count', 'view_count, view_count_archive');
  sql_create_index('stats_pages', 'index_queries', 'query_count');
  sql_create_index('stats_pages', 'index_load_time', 'load_time');

  $pageviews_page_urls = array( 'pages/devblog/index'             => 'pages/dev/blog_list'              ,
                                'pages/doc/donnees_personnelles'  => 'pages/doc/data'                   ,
                                'pages/doc/mentions_legales'      => 'pages/doc/legal'                  ,
                                'pages/irc/canaux'                => 'pages/social/irc?channels'        ,
                                'pages/irc/client'                => 'pages/social/irc?client'          ,
                                'pages/irc/index'                 => 'pages/social/irc'                 ,
                                'pages/irc/services'              => 'pages/social/irc?nickserv'        ,
                                'pages/irl/index'                 => 'pages/meetups/list'               ,
                                'pages/nobleme/404'               => '404'                              ,
                                'pages/nobleme/activite'          => 'pages/nobleme/activity'           ,
                                'pages/nobleme/admins'            => 'pages/users/admins'               ,
                                'pages/nobleme/coulisses'         => 'pages/doc/dev'                    ,
                                'pages/nobleme/membres'           => 'pages/users/list'                 ,
                                'pages/nobleme/online'            => 'pages/users/online'               ,
                                'pages/nobleme/online?noguest'    => 'pages/users/online'               ,
                                'pages/quotes/add'                => 'pages/quotes/submit'              ,
                                'pages/quotes/index'              => 'pages/quotes/list'                ,
                                'pages/todo/index'                => 'pages/tasks/list'                 ,
                                'pages/todo/request'              => 'pages/tasks/proposal'             ,
                                'pages/todo/roadmap'              => 'pages/tasks/roadmap'              ,
                                'pages/user/email'                => 'pages/account/settings_email'     ,
                                'pages/user/notifications'        => 'pages/messages/inbox'             ,
                                'pages/user/nsfw'                 => 'pages/account/settings_nsfw'      ,
                                'pages/user/pass'                 => 'pages/account/settings_password'  ,
                                'pages/user/pm'                   => 'pages/messages/write'             ,
                                'pages/user/privacy'              => 'pages/account/settings_privacy'   ,
                                'pages/user/profil'               => 'pages/users/profile'              ,
                                'pages/user/register'             => 'pages/account/register'           );

  foreach($pageviews_page_urls as $old_url => $new_url)
  {
    $old_url  = sanitize($old_url, 'string');
    $new_url  = sanitize($new_url, 'string');
    query(" UPDATE  stats_pages
            SET     stats_pages.page_url    = '$new_url'
            WHERE   stats_pages.page_url LIKE '$old_url' ");
  }

  $qstats = query(" SELECT  stats_pages.id        AS 'p_id' ,
                            stats_pages.page_url  AS 'p_url'
                    FROM    stats_pages
                    WHERE   stats_pages.page_url LIKE 'pages/devblog/devblog?%' ");
  while($dstats = mysqli_fetch_array($qstats))
    query(" UPDATE  stats_pages
            SET     stats_pages.page_url  = '".str_replace('pages/devblog/devblog', 'pages/dev/blog', $dstats['p_url'])."'
            WHERE   stats_pages.id        = '".$dstats['p_id']."' ");

  $qstats = query(" SELECT  stats_pages.id        AS 'p_id' ,
                            stats_pages.page_url  AS 'p_url'
                    FROM    stats_pages
                    WHERE   stats_pages.page_url LIKE 'pages/irl/irl?%' ");
  while($dstats = mysqli_fetch_array($qstats))
    query(" UPDATE  stats_pages
            SET     stats_pages.page_url  = '".str_replace('pages/irl/irl?id=', 'pages/meetups/', $dstats['p_url'])."'
            WHERE   stats_pages.id        = '".$dstats['p_id']."' ");

  $qstats = query(" SELECT  stats_pages.id        AS 'p_id' ,
                            stats_pages.page_url  AS 'p_url'
                    FROM    stats_pages
                    WHERE   stats_pages.page_url LIKE 'pages/quotes/quote?%' ");
  while($dstats = mysqli_fetch_array($qstats))
    query(" UPDATE  stats_pages
            SET     stats_pages.page_url  = '".str_replace('pages/quotes/quote?id=', 'pages/quotes/', $dstats['p_url'])."'
            WHERE   stats_pages.id        = '".$dstats['p_id']."' ");

  $qstats = query(" SELECT  stats_pages.id        AS 'p_id' ,
                            stats_pages.page_url  AS 'p_url'
                    FROM    stats_pages
                    WHERE   stats_pages.page_url LIKE 'pages/todo/index?%' ");
  while($dstats = mysqli_fetch_array($qstats))
    query(" UPDATE  stats_pages
            SET     stats_pages.page_url  = '".str_replace('pages/todo/index?id=', 'pages/tasks/', $dstats['p_url'])."'
            WHERE   stats_pages.id        = '".$dstats['p_id']."' ");

  $qstats = query(" SELECT  stats_pages.id        AS 'p_id' ,
                            stats_pages.page_url  AS 'p_url'
                    FROM    stats_pages
                    WHERE   stats_pages.page_url LIKE 'pages/user/user?%' ");
  while($dstats = mysqli_fetch_array($qstats))
    query(" UPDATE  stats_pages
            SET     stats_pages.page_url  = '".str_replace('pages/user/user?id=', 'pages/users/', $dstats['p_url'])."'
            WHERE   stats_pages.id        = '".$dstats['p_id']."' ");

  query(" DELETE FROM stats_pages
          WHERE       stats_pages.page_url  LIKE 'pages/doc/api'
          OR          stats_pages.page_url  LIKE 'pages/doc/droit_oubli'
          OR          stats_pages.page_url  LIKE 'pages/doc/emotes'
          OR          stats_pages.page_url  LIKE 'pages/doc/index'
          OR          stats_pages.page_url  LIKE 'pages/doc/raccourcis'
          OR          stats_pages.page_url  LIKE 'pages/doc/rss'
          OR          stats_pages.page_url  LIKE 'pages/ecrivains/%'
          OR          stats_pages.page_url  LIKE 'pages/forum/%'
          OR          stats_pages.page_url  LIKE 'pages/irl/stats'
          OR          stats_pages.page_url  LIKE 'pages/nobleme/anniversaires'
          OR          stats_pages.page_url  LIKE 'pages/user/login'
          OR          stats_pages.page_url  LIKE 'pages/nbdb/%'
          OR          stats_pages.page_url  LIKE 'pages/nbrpg/%'
          OR          stats_pages.page_url  LIKE 'pages/nrm/%'
          OR          stats_pages.page_url  LIKE 'pages/quotes/stats'
          OR          stats_pages.page_url  LIKE 'pages/radikal/%'
          OR          stats_pages.page_url  LIKE 'pages/todo/request?bug'
          OR          stats_pages.page_url  LIKE 'pages/user/delete'
          OR          stats_pages.page_url  LIKE 'pages/user/pseudo' ");

  $timestamp = time();
  query(" UPDATE  stats_pages
          SET     stats_pages.page_name_en        = '-'                     ,
                  stats_pages.page_name_fr        = '-'                     ,
                  stats_pages.view_count_archive  = stats_pages.view_count  ,
                  stats_pages.last_viewed_at      = '$timestamp'            ");

  query(" UPDATE  system_variables
          SET     system_variables.last_pageview_check = '$timestamp' ");

  sql_update_query_id(22);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Dev tables

if($last_query < 23)
{
  sql_rename_table('devblog', 'dev_blogs');
  sql_rename_table('todo', 'dev_tasks');
  sql_rename_table('todo_categorie', 'dev_tasks_categories');
  sql_rename_table('todo_roadmap', 'dev_tasks_milestones');

  sql_change_field_type('dev_blogs', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_blogs', 'timestamp', 'posted_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('dev_blogs', 'title_en', 'VARCHAR(255) NOT NULL', 'posted_at');
  sql_rename_field('dev_blogs', 'titre', 'title_fr', 'VARCHAR(255) NOT NULL');
  sql_create_field('dev_blogs', 'body_en', 'LONGTEXT NOT NULL', 'title_fr');
  sql_rename_field('dev_blogs', 'contenu', 'body_fr', 'LONGTEXT NOT NULL');

  sql_change_field_type('dev_tasks', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_tasks', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('dev_tasks', 'timestamp', 'created_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('dev_tasks', 'importance', 'priority_level', 'TINYINT UNSIGNED NOt NULL DEFAULT 0');
  sql_rename_field('dev_tasks', 'titre_fr', 'title_fr', 'TEXT NOT NULL');
  sql_rename_field('dev_tasks', 'titre_en', 'title_en', 'TEXT NOT NULL');
  sql_move_field('dev_tasks', 'title_fr', 'TEXT NOT NULL', 'title_en');
  sql_rename_field('dev_tasks', 'contenu_fr', 'body_fr', 'TEXT NOT NULL');
  sql_rename_field('dev_tasks', 'contenu_en', 'body_en', 'TEXT NOT NULL');
  sql_move_field('dev_tasks', 'body_fr', 'TEXT NOT NULL', 'body_en');
  sql_rename_field('dev_tasks', 'FKtodo_categorie', 'fk_dev_tasks_categories', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_tasks', 'fk_dev_todo_categories', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  sql_rename_field('dev_tasks', 'FKtodo_roadmap', 'fk_dev_tasks_milestones', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_tasks', 'fk_dev_todo_milestones', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_dev_tasks_categories');
  sql_rename_field('dev_tasks', 'timestamp_fini', 'finished_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_tasks', 'finished_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'created_at');
  sql_rename_field('dev_tasks', 'valide_admin', 'admin_validation', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_tasks', 'admin_validation', 'INT UNSIGNED NOT NULL DEFAULT 0', 'finished_at');
  sql_rename_field('dev_tasks', 'public', 'is_public', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_tasks', 'is_public', 'INT UNSIGNED NOT NULL DEFAULT 0', 'admin_validation');
  sql_rename_field('dev_tasks', 'source', 'source_code_link', 'TEXT NOT NULL');
  sql_delete_index('dev_tasks', 'index_membres');
  sql_delete_index('dev_tasks', 'index_categorie');
  sql_delete_index('dev_tasks', 'index_roadmap');
  sql_delete_index('dev_tasks', 'index_titre_en');
  sql_delete_index('dev_tasks', 'index_titre_fr');
  sql_create_index('dev_tasks', 'index_author', 'fk_users');
  sql_create_index('dev_tasks', 'index_category', 'fk_dev_tasks_categories');
  sql_create_index('dev_tasks', 'index_milestone', 'fk_dev_tasks_milestones');
  sql_create_index('dev_tasks', 'index_title_en', 'title_en', 1);
  sql_create_index('dev_tasks', 'index_title_fr', 'title_fr', 1);

  sql_change_field_type('dev_tasks_categories', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_tasks_categories', 'titre_fr', 'title_fr', 'VARCHAR(255) NOT NULL');
  sql_rename_field('dev_tasks_categories', 'titre_en', 'title_en', 'VARCHAR(255) NOT NULL');
  sql_move_field('dev_tasks_categories', 'title_fr', 'VARCHAR(255) NOT NULL', 'title_en');

  sql_change_field_type('dev_tasks_milestones', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_tasks_milestones', 'id_classement', 'sorting_order', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('dev_tasks_milestones', 'version_fr', 'title_fr', 'TEXT NOT NULL');
  sql_rename_field('dev_tasks_milestones', 'version_en', 'title_en', 'TEXT NOT NULL');
  sql_move_field('dev_tasks_milestones', 'title_fr', 'TEXT NOT NULL', 'title_en');
  sql_rename_field('dev_tasks_milestones', 'description_fr', 'summary_fr', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('dev_tasks_milestones', 'description_en', 'summary_en', 'MEDIUMTEXT NOT NULL');
  sql_move_field('dev_tasks_milestones', 'summary_fr', 'MEDIUMTEXT NOT NULL', 'summary_en');
  sql_delete_index('dev_tasks_milestones', 'index_classement');
  sql_create_index('dev_tasks_milestones', 'index_sorting_order', 'sorting_order');

  sql_update_query_id(23);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Get rid of the writer's corner

if($last_query < 24)
{
  sql_delete_table('ecrivains_texte');
  sql_delete_table('ecrivains_concours');
  sql_delete_table('ecrivains_concours_vote');
  sql_delete_table('ecrivains_note');

  query(" DELETE FROM logs_activity
          WHERE       logs_activity.activity_type LIKE 'ecrivains_%' ");

  sql_update_query_id(24);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Get rid of the forum

if($last_query < 25)
{
  sql_delete_table('forum_sujet',);
  sql_delete_table('forum_message');
  sql_delete_table('forum_categorie');
  sql_delete_table('forum_filtrage');

  query(" DELETE FROM logs_activity
          WHERE       logs_activity.activity_type LIKE 'forum_%' ");

  sql_update_query_id(25);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Users (includes splitting users into multiple tables)

if($last_query < 26)
{
  sql_rename_table('membres', 'users');
  sql_create_table('users_profile');
  sql_create_table('users_settings');
  sql_create_table('users_stats');
  sql_rename_table('invites', 'users_guests');
  sql_rename_table('membres_essais_login', 'users_login_attempts');
  sql_rename_table('notifications', 'users_private_messages');

  sql_change_field_type('users', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('users', 'pseudonyme', 'username', 'VARCHAR(45) NOT NULL');
  sql_rename_field('users', 'pass', 'password', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('users', 'admin', 'is_administrator', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users', 'sysop', 'is_moderator', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_field('users', 'moderateur');
  sql_delete_field('users', 'moderateur_description_fr');
  sql_delete_field('users', 'moderateur_description_en');
  sql_create_field('users', 'current_language', 'VARCHAR(16) NOT NULL', 'is_moderator');
  sql_create_field('users', 'current_theme', 'VARCHAR(20) NOT NULL', 'current_language');
  sql_rename_field('users', 'derniere_visite', 'last_visited_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users', 'derniere_visite_page', 'last_visited_page_en', "VARCHAR(510) NOT NULL");
  sql_create_field('users', 'last_visited_page_fr', "VARCHAR(510) NOT NULL", 'last_visited_page_en');
  query(" UPDATE  users
          SET     users.last_visited_page_fr = users.last_visited_page_en ,
                  users.last_visited_page_en = '-'                        ");
  sql_rename_field('users', 'derniere_visite_url', 'last_visited_url', "VARCHAR(510) NOT NULL");
  sql_create_field('users', 'visited_page_count', 'INT UNSIGNED NOT NULL DEFAULT 0', 'last_visited_url');
  sql_rename_field('users', 'derniere_visite_ip', 'current_ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'");
  sql_rename_field('users', 'derniere_activite', 'last_action_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('users', 'last_action_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'last_visited_at');
  sql_create_field('users', 'is_banned_since', 'INT UNSIGNED NOT NULL DEFAULT 0', 'current_ip_address');
  sql_rename_field('users', 'banni_date', 'is_banned_until', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('users', 'is_banned_because_en', 'TEXT NOT NULL', 'is_banned_until');
  sql_rename_field('users', 'banni_raison', 'is_banned_because_fr', 'TEXT NOT NULL');
  sql_delete_field('users', 'forum_messages');
  sql_delete_field('users', 'forum_lang');
  sql_delete_index('users', 'index_login');
  sql_delete_index('users', 'index_droits');
  sql_create_index('users', 'index_access_rights', 'is_administrator, is_moderator');
  sql_create_index('users', 'index_doppelganger', 'current_ip_address');
  sql_create_index('users', 'index_banned', 'is_banned_until');

  $qusers = query(" SELECT  users.id              AS 'u_id'     ,
                            users.username        AS 'u_nick'   ,
                            users.last_visited_at AS 'u_visit'  ,
                            users.is_banned_until AS 'u_ban'
                    FROM    users ");
  while($dusers = mysqli_fetch_array($qusers))
  {
    $newnick = $dusers['u_nick'];
    if(!preg_match("/^[a-zA-Z0-9]+$/", $newnick))
      $newnick = preg_replace("/[^a-zA-Z0-9]/", "", $dusers['u_nick']);
    if(mb_strlen($newnick) < 3)
    {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $newnick = str_pad($newnick, 1, $characters[rand(0, mb_strlen($characters) - 1)], STR_PAD_RIGHT);
      $newnick = str_pad($newnick, 2, $characters[rand(0, mb_strlen($characters) - 1)], STR_PAD_RIGHT);
      $newnick = str_pad($newnick, 3, $characters[rand(0, mb_strlen($characters) - 1)], STR_PAD_RIGHT);
    }
    if(mb_strlen($newnick) > 15)
      $newnick = mb_substr($newnick, 0, 15);
    if($newnick == 'Nemo')
    {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $newnick = str_pad($newnick, 5, $characters[rand(0, mb_strlen($characters) - 1)], STR_PAD_RIGHT);
      $newnick = str_pad($newnick, 6, $characters[rand(0, mb_strlen($characters) - 1)], STR_PAD_RIGHT);
    }
    if($newnick != $dusers['u_nick'])
      query(" UPDATE  users
              SET     users.username  = '".sql_sanitize_data($newnick)."'
              WHERE   users.id        = '".sql_sanitize_data($dusers['u_id'])."'");
    if($dusers['u_ban'])
    {
      query(" UPDATE  users
              SET     users.is_banned_since = '".sql_sanitize_data($dusers['u_visit'])."'
              WHERE   users.id              = '".sql_sanitize_data($dusers['u_id'])."'");
    }
  }

  sql_create_field('users_profile', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_profile', 'email_address', 'VARCHAR(510) NOT NULL', 'fk_users');
  sql_create_field('users_profile', 'created_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'email_address');
  sql_create_field('users_profile', 'birthday', "DATE NOT NULL DEFAULT '0000-00-00'", 'created_at');
  sql_create_field('users_profile', 'spoken_languages', 'VARCHAR(12) NOT NULL', 'birthday');
  sql_create_field('users_profile', 'lives_at', 'TEXT NOT NULL', 'spoken_languages');
  sql_create_field('users_profile', 'pronouns_en', 'TEXT NOT NULL', 'lives_at');
  sql_create_field('users_profile', 'pronouns_fr', 'TEXT NOT NULL', 'pronouns_en');
  sql_create_field('users_profile', 'profile_text_en', 'LONGTEXT NOT NULL', 'pronouns_fr');
  sql_create_field('users_profile', 'profile_text_fr', 'LONGTEXT NOT NULL', 'profile_text_en');
  $qusers = query(" SELECT  users.id            AS 'u_id'         ,
                            users.email         AS 'u_mail'       ,
                            users.date_creation AS 'u_created'    ,
                            users.langue        AS 'u_languages'  ,
                            users.anniversaire  AS 'u_birthday'   ,
                            users.habite        AS 'u_lives_at'
                    FROM    users ");
  while($dusers = mysqli_fetch_array($qusers))
    query(" INSERT INTO users_profile
            SET         users_profile.fk_users          = '".sql_sanitize_data($dusers['u_id'])."'        ,
                        users_profile.email_address     = '".sql_sanitize_data($dusers['u_mail'])."'      ,
                        users_profile.created_at        = '".sql_sanitize_data($dusers['u_created'])."'   ,
                        users_profile.spoken_languages  = '".sql_sanitize_data($dusers['u_languages'])."' ,
                        users_profile.birthday          = '".sql_sanitize_data($dusers['u_birthday'])."'  ,
                        users_profile.lives_at          = '".sql_sanitize_data($dusers['u_lives_at'])."'  ");
  sql_create_index('users_profile', 'index_user', 'fk_users');
  sql_delete_field('users', 'email');
  sql_delete_field('users', 'date_creation');
  sql_delete_field('users', 'langue');
  sql_delete_field('users', 'genre');
  sql_delete_field('users', 'anniversaire');
  sql_delete_field('users', 'habite');
  sql_delete_field('users', 'metier');
  sql_delete_field('users', 'profil');

  $qusers = query(" SELECT  users_profile.id            AS 'up_id' ,
                            users_profile.email_address AS 'up_mail'
                    FROM    users_profile ");
  while($dusers = mysqli_fetch_array($qusers))
  {
    if(!filter_var($dusers['up_mail'], FILTER_VALIDATE_EMAIL))
      query(" UPDATE  users_profile
              SET     users_profile.email_address = ''
              WHERE   users_profile.id            = '".sql_sanitize_data($dusers['up_id'])."'");
  }

  sql_create_field('users_settings', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_settings', 'show_nsfw_content', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  sql_create_field('users_settings', 'hide_youtube', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'show_nsfw_content');
  sql_create_field('users_settings', 'hide_google_trends', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'hide_youtube');
  sql_create_field('users_settings', 'hide_discord', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'hide_google_trends');
  sql_create_field('users_settings', 'hide_kiwiirc', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'hide_discord');
  sql_create_field('users_settings', 'hide_from_activity', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'hide_kiwiirc');
  sql_create_field('users_settings', 'quotes_languages', 'VARCHAR(12) NOT NULL', 'hide_from_activity');
  $qusers = query(" SELECT  users.id                  AS 'u_id'       ,
                            users.voir_nsfw           AS 'u_nsfw'     ,
                            users.voir_youtube        AS 'u_youtube'  ,
                            users.voir_google_trends  AS 'u_trends'
                    FROM    users ");
  while($dusers = mysqli_fetch_array($qusers))
    query(" INSERT INTO users_settings
            SET         users_settings.fk_users               = '".sql_sanitize_data($dusers['u_id'])."'        ,
                        users_settings.show_nsfw_content      = '".sql_sanitize_data($dusers['u_nsfw'])."'      ,
                        users_settings.hide_youtube           = '".sql_sanitize_data($dusers['u_youtube'])."'   ,
                        users_settings.hide_google_trends     = '".sql_sanitize_data($dusers['u_trends'])."'    ");
  sql_create_index('users_settings', 'index_user', 'fk_users');
  sql_create_index('users_settings', 'index_nsfw_filter', 'show_nsfw_content');

  sql_create_field('users_stats', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  $qusers = query(" SELECT  users.id AS 'u_id'
                    FROM    users ");
  while($dusers = mysqli_fetch_array($qusers))
    query(" INSERT INTO users_stats
            SET         users_stats.fk_users = '".sql_sanitize_data($dusers['u_id'])."' ");
  sql_create_index('users_stats', 'index_user', 'fk_users');
  sql_delete_field('users', 'voir_nsfw');
  sql_delete_field('users', 'voir_tweets');
  sql_delete_field('users', 'voir_youtube');
  sql_delete_field('users', 'voir_google_trends');

  sql_change_field_type('users_guests', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('users_guests', 'ip', 'ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'");
  sql_rename_field('users_guests', 'surnom', 'randomly_assigned_name_en', 'VARCHAR(510) NOT NULL');
  sql_create_field('users_guests', 'randomly_assigned_name_fr', 'VARCHAR(510) NOT NULL', 'randomly_assigned_name_en');
  sql_create_field('users_guests', 'current_language', 'VARCHAR(16) NOT NULL', 'randomly_assigned_name_fr');
  sql_create_field('users_guests', 'current_theme', 'VARCHAR(20) NOT NULL', 'current_language');
  sql_rename_field('users_guests', 'derniere_visite', 'last_visited_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_guests', 'derniere_visite_page', 'last_visited_page_en', "VARCHAR(510) NOT NULL");
  sql_create_field('users_guests', 'last_visited_page_fr', "VARCHAR(510) NOT NULL", 'last_visited_page_en');
  query(" UPDATE  users_guests
          SET     users_guests.randomly_assigned_name_fr  = users_guests.randomly_assigned_name_en  ,
                  users_guests.last_visited_page_fr       = users_guests.last_visited_page_en       ,
                  users_guests.randomly_assigned_name_en  = '-'                                     ,
                  users_guests.last_visited_page_en       = '-'                                     ");
  sql_rename_field('users_guests', 'derniere_visite_url', 'last_visited_url', "VARCHAR(510) NOT NULL");
  sql_create_field('users_guests', 'visited_page_count', 'INT UNSIGNED NOT NULL DEFAULT 0', 'last_visited_url');
  sql_delete_index('users_guests', 'ip');

  sql_change_field_type('users_login_attempts', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('users_login_attempts', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_login_attempts', 'timestamp', 'attempted_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_login_attempts', 'ip', 'ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'");
  sql_move_field('users_login_attempts', 'ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'", 'fk_users');
  sql_delete_index('users_login_attempts', 'index_membres');
  sql_create_index('users_login_attempts', 'index_user', 'fk_users');
  sql_create_index('users_login_attempts', 'index_guest', 'ip_address');

  sql_change_field_type('users_private_messages', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('users_private_messages', 'FKmembres_destinataire', 'fk_users_recipient', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_private_messages', 'FKmembres_envoyeur', 'fk_users_sender', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('users_private_messages', 'fk_users_true_sender', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_users_sender');
  sql_create_field('users_private_messages', 'fk_parent_message', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_users_true_sender');
  sql_create_field('users_private_messages', 'is_admin_only_message', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_parent_message');
  sql_create_field('users_private_messages', 'hide_from_admin_mail', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_admin_only_message');
  sql_rename_field('users_private_messages', 'date_envoi', 'sent_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_private_messages', 'date_consultation', 'read_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_private_messages', 'titre', 'title', 'TEXT NOT NULL');
  sql_rename_field('users_private_messages', 'contenu', 'body', 'LONGTEXT NOT NULL');
  sql_delete_index('users_private_messages', 'index_destinataire');
  sql_delete_index('users_private_messages', 'index_envoyeur');
  sql_delete_index('users_private_messages', 'index_chronologie');
  sql_create_index('users_private_messages', 'index_inbox', 'fk_users_recipient');
  sql_create_index('users_private_messages', 'index_outbox', 'fk_users_sender');
  sql_create_index('users_private_messages', 'index_message_chain', 'fk_parent_message');
  sql_create_index('users_private_messages', 'index_read', 'read_at');

  query(" UPDATE  users_private_messages
          SET     users_private_messages.hide_from_admin_mail = 1
          WHERE   users_private_messages.fk_users_sender      = 0 ");

  sql_create_table('users_tokens');
  sql_create_field('users_tokens', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_tokens', 'token', 'VARCHAR(255) NOT NULL', 'fk_users');
  sql_create_field('users_tokens', 'token_type', 'VARCHAR(40) NOT NULL', 'token');
  sql_create_field('users_tokens', 'regenerate_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'token_type');
  sql_create_field('users_tokens', 'delete_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'regenerate_at');
  sql_create_index('users_tokens', 'index_user', 'fk_users');
  sql_create_index('users_tokens', 'index_token', 'token', 1);

  sql_update_query_id(26);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - IRC

if($last_query < 27)
{
  sql_rename_table('irc_canaux', 'irc_channels');

  sql_change_field_type('irc_channels', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('irc_channels', 'canal', 'name', 'VARCHAR(153) NOT NULL');
  sql_rename_field('irc_channels', 'importance', 'channel_type', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('irc_channels', 'langue', 'languages', 'VARCHAR(12) NOT NULL');
  sql_move_field('irc_channels', 'languages', 'VARCHAR(12) NOT NULL', 'channel_type');
  sql_change_field_type('irc_channels', 'description_fr', 'TEXT NOT NULL');
  sql_change_field_type('irc_channels', 'description_en', 'TEXT NOT NULL');
  sql_move_field('irc_channels', 'description_fr', 'TEXT NOT NULL', 'description_en');
  sql_create_index('irc_channels', 'index_channel_type', 'channel_type');

  query(" UPDATE  irc_channels
          SET     irc_channels.channel_type   = 3
          WHERE   irc_channels.channel_type  >= 50 ");
  query(" UPDATE  irc_channels
          SET     irc_channels.channel_type   = 2
          WHERE   irc_channels.channel_type  >= 40 ");
  query(" UPDATE  irc_channels
          SET     irc_channels.channel_type   = 4
          WHERE   irc_channels.channel_type  >= 10 ");
  query(" UPDATE  irc_channels
          SET     irc_channels.channel_type   = 4
          WHERE   irc_channels.channel_type   = 1 ");
  query(" UPDATE  irc_channels
          SET     irc_channels.channel_type   = 1
          WHERE   irc_channels.channel_type   = 0 " );
  query(" UPDATE  irc_channels
          SET     irc_channels.channel_type   = 0
          WHERE   irc_channels.channel_type   = 4 " );

  sql_update_query_id(27);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Meetups

if($last_query < 28)
{
  sql_rename_table('irl', 'meetups');
  sql_rename_table('irl_participants', 'meetups_people');

  sql_change_field_type('meetups', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('meetups', 'date', 'event_date', "DATE NOT NULL DEFAULT '0000-00-00'");
  sql_rename_field('meetups', 'lieu', 'location', "VARCHAR(60) NOT NULL");
  sql_create_field('meetups', 'languages', "VARCHAR(12) NOT NULL", 'location');
  sql_create_field('meetups', 'attendee_count', 'INT UNSIGNED NOT NULL DEFAULT 0', 'languages');
  sql_delete_field('meetups', 'raison_fr');
  sql_delete_field('meetups', 'raison_en');
  sql_rename_field('meetups', 'details_fr', 'details_fr', "MEDIUMTEXT NOT NULL");
  sql_rename_field('meetups', 'details_en', 'details_en', "MEDIUMTEXT NOT NULL");
  sql_move_field('meetups', 'details_fr', 'MEDIUMTEXT NOT NULL', 'details_en');

  query(" UPDATE  meetups
          SET     languages = 'FR' ");

  sql_change_field_type('meetups_people', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('meetups_people', 'FKirl', 'fk_meetups', "INT UNSIGNED NOT NULL DEFAULT 0");
  sql_rename_field('meetups_people', 'FKmembres', 'fk_users', "INT UNSIGNED NOT NULL DEFAULT 0");
  sql_rename_field('meetups_people', 'pseudonyme', 'username', "VARCHAR(45) NOT NULL");
  sql_rename_field('meetups_people', 'confirme', 'attendance_confirmed', "TINYINT UNSIGNED NOT NULL DEFAULT 0");
  sql_rename_field('meetups_people', 'details_fr', 'extra_information_fr', "VARCHAR(510) NOT NULL");
  sql_rename_field('meetups_people', 'details_en', 'extra_information_en', "VARCHAR(510) NOT NULL");
  sql_move_field('meetups_people', 'extra_information_fr', 'VARCHAR(510) NOT NULL', 'extra_information_en');
  sql_delete_index('meetups_people', 'index_irl');
  sql_delete_index('meetups_people', 'index_membres');
  sql_create_index('meetups_people', 'index_meetup', 'fk_meetups');
  sql_create_index('meetups_people', 'index_people', 'fk_users');

  $qmeetups = query(" SELECT  meetups.id AS 'm_id'
                      FROM    meetups ");
  while($dmeetups = mysqli_fetch_array($qmeetups))
  {
    $dpeople = mysqli_fetch_array(query(" SELECT  COUNT(*) AS 'mp_count'
                                          FROM    meetups_people
                                          WHERE   meetups_people.fk_meetups = '".$dmeetups['m_id']."' "));
    query(" UPDATE  meetups
            SET     meetups.attendee_count = '".$dpeople['mp_count']."'
            WHERE   meetups.id = '".$dmeetups['m_id']."' ");
  }

  query(" DELETE FROM logs_activity
          WHERE       logs_activity.activity_type LIKE 'meetups_delete' ");

  $qmeetups = query(" SELECT    logs_activity.id    AS 'l_id' ,
                                meetups.event_date  AS 'm_d'
                      FROM      logs_activity
                      LEFT JOIN meetups ON logs_activity.activity_id = meetups.id
                      WHERE   ( logs_activity.activity_type LIKE 'meetups_edit'
                      OR        logs_activity.activity_type LIKE 'meetups_new'
                      OR        logs_activity.activity_type LIKE 'meetups_people_delete'
                      OR        logs_activity.activity_type LIKE 'meetups_people_edit'
                      OR        logs_activity.activity_type LIKE 'meetups_people_new' ) ");
  while($dmeetups = mysqli_fetch_array($qmeetups))
    query(" UPDATE  logs_activity
            SET     logs_activity.activity_summary_en = '".strtotime($dmeetups['m_d'])."' ,
                    logs_activity.activity_summary_fr = '".strtotime($dmeetups['m_d'])."'
            WHERE   logs_activity.id                  = '".$dmeetups['l_id']."' ");

  sql_update_query_id(28);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Quotes

if($last_query < 29)
{
  sql_rename_table('quotes_membres', 'quotes_users');

  sql_change_field_type('quotes', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('quotes', 'timestamp', 'submitted_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('quotes', 'langue', 'language', 'VARCHAR(6) NOT NULL');
  sql_rename_field('quotes', 'contenu', 'body', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('quotes', 'FKauteur', 'fk_users_submitter', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('quotes', 'fk_users_submitter', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_rename_field('quotes', 'nsfw', 'is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('quotes', 'is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'submitted_at');
  sql_rename_field('quotes', 'valide_admin', 'admin_validation', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('quotes', 'admin_validation', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_users_submitter');
  sql_delete_index('quotes', 'index_membres');
  sql_create_index('quotes', 'index_submitter', 'fk_users_submitter');

  sql_change_field_type('quotes_users', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('quotes_users', 'FKquotes', 'fk_quotes', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('quotes_users', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('quotes_users', 'index_quotes');
  sql_delete_index('quotes_users', 'index_membres');
  sql_create_index('quotes_users', 'index_quote', 'fk_quotes');
  sql_create_index('quotes_users', 'index_user', 'fk_users');

  sql_update_query_id(29);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Encyclopedia of internet culture

if($last_query < 30)
{
  sql_rename_table('nbdb_web_notes_admin', 'compendium_admin_tools');
  sql_rename_table('nbdb_web_categorie', 'compendium_categories');
  sql_rename_table('nbdb_web_periode', 'compendium_eras');
  sql_rename_table('nbdb_web_image', 'compendium_images');
  sql_rename_table('nbdb_web_page', 'compendium_pages');
  sql_rename_table('nbdb_web_page_categorie', 'compendium_pages_categories');

  sql_rename_field('compendium_admin_tools', 'notes_admin', 'global_notes', 'LONGTEXT NOT NULL');
  sql_delete_field('compendium_admin_tools', 'brouillon_fr');
  sql_delete_field('compendium_admin_tools', 'brouillon_en');
  sql_move_field('compendium_admin_tools', 'draft_fr', 'LONGTEXT NOT NULL', 'draft_en');
  sql_rename_field('compendium_admin_tools', 'template_global', 'snippets', 'LONGTEXT NOT NULL');
  sql_change_field_type('compendium_admin_tools', 'template_fr', 'LONGTEXT NOT NULL');
  sql_change_field_type('compendium_admin_tools', 'template_en', 'LONGTEXT NOT NULL');
  sql_move_field('compendium_admin_tools', 'template_fr', 'LONGTEXT NOT NULL', 'template_en');

  sql_change_field_type('compendium_categories', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('compendium_categories', 'titre_fr', 'name_fr', 'VARCHAR(510) NOT NULL');
  sql_rename_field('compendium_categories', 'titre_en', 'name_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('compendium_categories', 'name_fr', 'VARCHAR(510) NOT NULL', 'name_en');
  sql_rename_field('compendium_categories', 'ordre_affichage', 'display_order', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('compendium_categories', 'display_order', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_rename_field('compendium_categories', 'description_fr', 'description_fr', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('compendium_categories', 'description_en', 'description_en', 'MEDIUMTEXT NOT NULL');
  sql_move_field('compendium_categories', 'description_fr', 'MEDIUMTEXT NOT NULL', 'description_en');
  sql_delete_index('compendium_categories', 'index_ordre_affichage');
  sql_delete_index('compendium_categories', 'index_description_fr');
  sql_delete_index('compendium_categories', 'index_description_en');
  sql_create_index('compendium_categories', 'index_display_order', 'display_order');

  sql_change_field_type('compendium_eras', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('compendium_eras', 'titre_fr', 'name_fr', 'VARCHAR(510) NOT NULL');
  sql_rename_field('compendium_eras', 'titre_en', 'name_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('compendium_eras', 'name_fr', 'VARCHAR(510) NOT NULL', 'name_en');
  sql_create_field('compendium_eras', 'short_name_en', 'VARCHAR(510) NOT NULL', 'name_fr');
  sql_create_field('compendium_eras', 'short_name_fr', 'VARCHAR(510) NOT NULL', 'short_name_en');
  sql_rename_field('compendium_eras', 'description_fr', 'description_fr', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('compendium_eras', 'description_en', 'description_en', 'MEDIUMTEXT NOT NULL');
  sql_move_field('compendium_eras', 'description_fr', 'MEDIUMTEXT NOT NULL', 'description_en');
  sql_rename_field('compendium_eras', 'annee_debut', 'year_start', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_eras', 'annee_fin', 'year_end', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('compendium_eras', 'year_start', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_move_field('compendium_eras', 'year_end', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0', 'year_start');

  sql_create_table('compendium_types');
  sql_create_field('compendium_types', 'display_order', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('compendium_types', 'name_en', 'VARCHAR(510) NOT NULL', 'display_order');
  sql_create_field('compendium_types', 'name_fr', 'VARCHAR(510) NOT NULL', 'name_en');
  sql_create_field('compendium_types', 'full_name_en', 'TEXT NOT NULL', 'name_fr');
  sql_create_field('compendium_types', 'full_name_fr', 'TEXT NOT NULL', 'full_name_en');
  sql_create_field('compendium_types', 'description_en', 'MEDIUMTEXT NOT NULL', 'full_name_fr');
  sql_create_field('compendium_types', 'description_fr', 'MEDIUMTEXT NOT NULL', 'description_en');
  sql_create_index('compendium_types', 'index_display_order', 'display_order');

  sql_change_field_type('compendium_images', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('compendium_images', 'timestamp_upload', 'uploaded_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_images', 'nom_fichier', 'file_name', 'VARCHAR(510) NOT NULL');
  sql_change_field_type('compendium_images', 'tags', 'TEXT NOT NULL');
  sql_rename_field('compendium_images', 'nsfw', 'is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('compendium_images', 'is_gross', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_nsfw');
  sql_create_field('compendium_images', 'is_offensive', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_gross');
  sql_rename_field('compendium_images', 'pages_utilisation_fr', 'used_in_pages_fr', 'TEXT NOT NULL');
  sql_rename_field('compendium_images', 'pages_utilisation_en', 'used_in_pages_en', 'TEXT NOT NULL');
  sql_move_field('compendium_images', 'used_in_pages_fr', 'TEXT NOT NULL', 'used_in_pages_en');
  sql_create_field('compendium_images', 'caption_en', 'MEDIUMTEXT NOT NULL', 'used_in_pages_fr');
  sql_create_field('compendium_images', 'caption_fr', 'MEDIUMTEXT NOT NULL', 'caption_en');
  sql_create_index('compendium_images', 'index_file_name', 'file_name', 1);

  sql_create_table('compendium_missing');
  sql_create_field('compendium_missing', 'page_url', 'VARCHAR(510) NOT NULL', 'id');
  sql_create_field('compendium_missing', 'title', 'VARCHAR(510) NOT NULL', 'page_url');
  sql_create_field('compendium_missing', 'notes', 'MEDIUMTEXT NOT NULL', 'title');
  sql_create_index('compendium_missing', 'index_url', 'page_url(255)');

  sql_change_field_type('compendium_pages', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_create_field('compendium_pages', 'fk_compendium_types', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_rename_field('compendium_pages', 'FKnbdb_web_periode', 'fk_compendium_eras', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('compendium_pages', 'is_draft', 'TINYINT NOT NULL DEFAULT 0', 'fk_compendium_eras');
  sql_create_field('compendium_pages', 'created_at', 'INT UNSIGNED NOT NULL', 'is_draft');
  sql_create_field('compendium_pages', 'last_edited_at', 'INT UNSIGNED NOT NULL', 'created_at');
  sql_create_field('compendium_pages', 'page_url', 'VARCHAR(510) NOT NULL', 'last_edited_at');
  sql_rename_field('compendium_pages', 'titre_fr', 'title_fr', 'VARCHAR(510) NOT NULL');
  sql_rename_field('compendium_pages', 'titre_en', 'title_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('compendium_pages', 'title_fr', 'VARCHAR(510) NOT NULL', 'title_en');
  sql_change_field_type('compendium_pages', 'redirection_fr', 'VARCHAR(510) NOT NULL');
  sql_change_field_type('compendium_pages', 'redirection_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('compendium_pages', 'redirection_fr', 'VARCHAR(510) NOT NULL', 'redirection_en');
  sql_rename_field('compendium_pages', 'contenu_fr', 'definition_fr', 'LONGTEXT NOT NULL');
  sql_rename_field('compendium_pages', 'contenu_en', 'definition_en', 'LONGTEXT NOT NULL');
  sql_rename_field('compendium_pages', 'annee_apparition', 'year_appeared', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_pages', 'mois_apparition', 'month_appeared', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_pages', 'annee_popularisation', 'year_peak', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_pages', 'mois_popularisation', 'month_peak', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_pages', 'contenu_floute', 'is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_pages', 'est_vulgaire', 'is_gross', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_field('compendium_pages', 'est_politise');
  sql_rename_field('compendium_pages', 'est_incorrect', 'is_offensive', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('compendium_pages', 'title_is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_offensive');
  sql_create_field('compendium_pages', 'summary_en', 'TEXT NOT NULL', 'title_is_nsfw');
  sql_create_field('compendium_pages', 'summary_fr', 'TEXT NOT NULL', 'summary_en');
  sql_move_field('compendium_pages', 'definition_en', 'LONGTEXT NOT NULL', 'summary_fr');
  sql_move_field('compendium_pages', 'definition_fr', 'LONGTEXT NOT NULL', 'definition_en');
  sql_rename_field('compendium_pages', 'notes_admin', 'admin_notes', 'MEDIUMTEXT NOT NULL');
  sql_create_field('compendium_pages', 'admin_urls', 'TEXT NOT NULL', 'admin_notes');
  sql_delete_index('compendium_pages', 'index_periode');
  sql_delete_index('compendium_pages', 'index_apparition');
  sql_delete_index('compendium_pages', 'index_popularisation');
  sql_delete_index('compendium_pages', 'index_titre_fr');
  sql_delete_index('compendium_pages', 'index_titre_en');
  sql_delete_index('compendium_pages', 'index_contenu_en');
  sql_delete_index('compendium_pages', 'index_contenu_fr');
  sql_create_index('compendium_pages', 'index_type', 'fk_compendium_types');
  sql_create_index('compendium_pages', 'index_era', 'fk_compendium_eras');
  sql_create_index('compendium_pages', 'index_activity', 'created_at, last_edited_at');
  sql_create_index('compendium_pages', 'index_url', 'page_url(255)');
  sql_create_index('compendium_pages', 'index_appeared', 'year_appeared, month_appeared');
  sql_create_index('compendium_pages', 'index_spread', 'year_peak, month_peak');
  sql_create_index('compendium_pages', 'index_title_en', 'title_en(255), redirection_en(255)', 1);
  sql_create_index('compendium_pages', 'index_title_fr', 'title_fr(255), redirection_fr(255)', 1);

  sql_change_field_type('compendium_pages_categories', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('compendium_pages_categories', 'FKnbdb_web_page', 'fk_compendium_pages', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('compendium_pages_categories', 'FKnbdb_web_categorie', 'fk_compendium_categories', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('compendium_pages_categories', 'index_pages');
  sql_create_index('compendium_pages_categories', 'index_page', 'fk_compendium_pages');
  sql_create_index('compendium_pages_categories', 'index_category', 'fk_compendium_categories');

  sql_create_table('compendium_pages_history');
  sql_create_field('compendium_pages_history', 'fk_compendium_pages', 'INT UNSIGNED NOT NULL', 'id');
  sql_create_field('compendium_pages_history', 'edited_at', 'INT UNSIGNED NOT NULL', 'fk_compendium_pages');
  sql_create_field('compendium_pages_history', 'is_major_edit', 'TINYINT UNSIGNED NOT NULL', 'edited_at');
  sql_create_field('compendium_pages_history', 'summary_en', 'TEXT NOT NULL', 'is_major_edit');
  sql_create_field('compendium_pages_history', 'summary_fr', 'TEXT NOT NULL', 'summary_en');
  sql_create_index('compendium_pages_history', 'index_page', 'fk_compendium_pages');
  sql_create_index('compendium_pages_history', 'index_history', 'edited_at');

  query(" UPDATE  compendium_pages
          SET     compendium_pages.fk_compendium_types  = 1             ,
                  compendium_pages.is_draft             = 1             ,
                  compendium_pages.created_at           = '".time()."'  ");
  query(" UPDATE  compendium_images
          SET     compendium_images.used_in_pages_en = '' ,
                  compendium_images.used_in_pages_fr = '' ");

  $qcompendium = query("  SELECT  nbdb_web_definition.titre_fr        AS 'title_fr'     ,
                                  nbdb_web_definition.titre_en        AS 'title_en'     ,
                                  nbdb_web_definition.redirection_fr  AS 'redirect_fr'  ,
                                  nbdb_web_definition.redirection_en  AS 'redirect_en'  ,
                                  nbdb_web_definition.definition_fr   AS 'body_fr'      ,
                                  nbdb_web_definition.definition_en   AS 'body_en'      ,
                                  nbdb_web_definition.contenu_floute  AS 'is_nsfw'      ,
                                  nbdb_web_definition.est_vulgaire    AS 'is_gross'     ,
                                  nbdb_web_definition.est_incorrect   AS 'is_incorrect' ,
                                  nbdb_web_definition.notes_admin     AS 'admin_notes'
                          FROM    nbdb_web_definition ");
  while($dcompendium = mysqli_fetch_array($qcompendium))
    query(" INSERT INTO compendium_pages
            SET         compendium_pages.fk_compendium_types  = 2                                                     ,
                        compendium_pages.is_draft             = 1                                                     ,
                        compendium_pages.created_at           = '".time()."'                                          ,
                        compendium_pages.title_en             = '".sql_sanitize_data($dcompendium['title_en'])."'     ,
                        compendium_pages.title_fr             = '".sql_sanitize_data($dcompendium['title_fr'])."'     ,
                        compendium_pages.redirection_en       = '".sql_sanitize_data($dcompendium['redirect_en'])."'  ,
                        compendium_pages.redirection_fr       = '".sql_sanitize_data($dcompendium['redirect_fr'])."'  ,
                        compendium_pages.is_nsfw              = '".sql_sanitize_data($dcompendium['is_nsfw'])."'      ,
                        compendium_pages.is_gross             = '".sql_sanitize_data($dcompendium['is_gross'])."'     ,
                        compendium_pages.is_offensive         = '".sql_sanitize_data($dcompendium['is_incorrect'])."' ,
                        compendium_pages.definition_en        = '".sql_sanitize_data($dcompendium['body_en'])."'      ,
                        compendium_pages.definition_fr        = '".sql_sanitize_data($dcompendium['body_fr'])."'      ,
                        compendium_pages.admin_notes          = '".sql_sanitize_data($dcompendium['admin_notes'])."' ");

  query(" UPDATE  compendium_pages
          SET     compendium_pages.page_url = LOWER(REPLACE(compendium_pages.title_fr, ' ', '_'))");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.page_url = LOWER(REPLACE(REPLACE(REPLACE(REPLACE(compendium_pages.title_en, ' ', '_'), '?', ''), '\'', ''), ',', ''))
          WHERE   compendium_pages.title_en NOT LIKE '' ");
  query(" DELETE FROM compendium_pages
          WHERE       compendium_pages.redirection_en LIKE 'O RLY?' ");

  sql_delete_table('nbdb_web_definition');

  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '[[web:', '[[page:') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '[[web:', '[[page:') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '[[dico:', '[[page:') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '[[dico:', '[[page:') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '[[lien:', '[[link:') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '[[lien:', '[[link:') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '[[galerie', '[[gallery') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '[[galerie', '[[gallery') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '/galerie]]', '/gallery]]') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '/galerie]]', '/gallery]]') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '[[', '[') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '[[', '[') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, ']]', ']') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, ']]', ']') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '|droite', '|right') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '|droite', '|right') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_en = REPLACE(compendium_pages.definition_en, '|gauche', '|left') ");
  query(" UPDATE  compendium_pages
          SET     compendium_pages.definition_fr = REPLACE(compendium_pages.definition_fr, '|gauche', '|left') ");

  query(" INSERT INTO compendium_types
          SET         compendium_types.id            = 1       ,
                      compendium_types.display_order = 1       ,
                      compendium_types.name_en       = 'Meme'  ,
                      compendium_types.name_fr       = 'Meme'  ,
                      compendium_types.full_name_en  = 'Meme'  ,
                      compendium_types.full_name_fr  = 'Meme'  ");
  query(" INSERT INTO compendium_types
          SET         compendium_types.id            = 2             ,
                      compendium_types.display_order = 10            ,
                      compendium_types.name_en       = 'Definition'  ,
                      compendium_types.name_fr       = 'Définition'  ,
                      compendium_types.full_name_en  = 'Definition'  ,
                      compendium_types.full_name_fr  = 'Definition'  ");
  query(" INSERT INTO compendium_types
          SET         compendium_types.id            = 3                       ,
                      compendium_types.display_order = 100                     ,
                      compendium_types.name_en       = 'Sociocultural'         ,
                      compendium_types.name_fr       = 'Socioculturel'         ,
                      compendium_types.full_name_en  = 'Sociocultural entry'   ,
                      compendium_types.full_name_fr  = 'Contenu socioculturel' ");
  query(" INSERT INTO compendium_types
          SET         compendium_types.id            = 4       ,
                      compendium_types.display_order = 1000    ,
                      compendium_types.name_en       = 'Drama' ,
                      compendium_types.name_fr       = 'Drame' ,
                      compendium_types.full_name_en  = 'Drama' ,
                      compendium_types.full_name_fr  = 'Drame' ");
  query(" INSERT INTO compendium_types
          SET         compendium_types.id             = 5                     ,
                      compendium_types.display_order  = 10000                 ,
                      compendium_types.name_en        = 'History'             ,
                      compendium_types.name_fr        = 'Histoire'            ,
                      compendium_types.full_name_en  = 'Historical entry'    ,
                      compendium_types.full_name_fr  = 'Contenu historique'  ");

  query(" DELETE FROM logs_activity
          WHERE       logs_activity.activity_type LIKE 'internet_*' ");
  query(" DELETE FROM logs_activity
          WHERE       logs_activity.activity_type LIKE 'nbdb_*' ");

  $qeras = query("  SELECT  compendium_eras.id      AS 'id'       ,
                            compendium_eras.name_en AS 'name_en'  ,
                            compendium_eras.name_fr AS 'name_fr'
                    FROM    compendium_eras ");
  while($deras = mysqli_fetch_array($qeras))
    query(" UPDATE  compendium_eras
            SET     compendium_eras.short_name_en = '".sql_sanitize_data(mb_substr($deras['name_en'], 0, 20))."'  ,
                    compendium_eras.short_name_fr = '".sql_sanitize_data(mb_substr($deras['name_fr'], 0, 20))."'
            WHERE   compendium_eras.id            = '".sql_sanitize_data($deras['id'])."' ");

  sql_update_query_id(30);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Add soft deletion capacity to most website elements

if($last_query < 31)
{
  sql_create_field('dev_blogs', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_index('dev_blogs', 'index_deleted', 'is_deleted');
  sql_create_field('dev_tasks', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  sql_create_index('dev_tasks', 'index_deleted', 'is_deleted');

  sql_create_field('logs_activity', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  sql_create_index('logs_activity', 'index_deleted', 'is_deleted');

  sql_create_field('meetups', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_index('meetups', 'index_deleted', 'is_deleted');

  sql_create_field('compendium_images', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_index('compendium_images', 'index_deleted', 'is_deleted');
  sql_create_field('compendium_pages', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_compendium_eras');
  sql_create_index('compendium_pages', 'index_deleted', 'is_deleted');

  sql_create_field('quotes', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_users_submitter');
  sql_create_index('quotes', 'index_deleted', 'is_deleted');

  sql_create_field('users', 'is_deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users', 'deleted_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'is_deleted');
  sql_create_field('users', 'deleted_username', 'VARCHAR(45) NOT NULL', 'deleted_at');
  sql_create_index('users', 'index_deleted', 'is_deleted');
  sql_create_field('users_private_messages', 'deleted_by_recipient', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_private_messages', 'deleted_by_sender', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'deleted_by_recipient');
  sql_create_index('users_private_messages', 'index_deleted_by_recipient', 'deleted_by_recipient');
  sql_create_index('users_private_messages', 'index_deleted_by_sender', 'deleted_by_sender');

  sql_update_query_id(31);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Add IP bans

if($last_query < 32)
{
  sql_create_table('system_ip_bans');
  sql_create_field('system_ip_bans', 'ip_address', 'VARCHAR(156) NOT NULL', 'id');
  sql_create_field('system_ip_bans', 'is_a_total_ban', 'TINYINT NOT NULL DEFAULT 0', 'ip_address');
  sql_create_field('system_ip_bans', 'banned_since', 'INT UNSIGNED NOT NULL DEFAULT 0', 'is_a_total_ban');
  sql_create_field('system_ip_bans', 'banned_until', 'INT UNSIGNED NOT NULL DEFAULT 0', 'banned_since');
  sql_create_field('system_ip_bans', 'ban_reason_en', 'TEXT NOT NULL', 'banned_until');
  sql_create_field('system_ip_bans', 'ban_reason_fr', 'TEXT NOT NULL', 'ban_reason_en');

  sql_update_query_id(32);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Leftover orphan activity logs

if($last_query < 33)
{
  $qorphans = query(" SELECT    logs_activity_details.id AS 'd_id'
                      FROM      logs_activity_details
                      LEFT JOIN logs_activity ON logs_activity_details.fk_logs_activity = logs_activity.id
                      WHERE     logs_activity.id IS NULL ");
  while($dorphans = mysqli_fetch_array($qorphans))
  {
    $orphan_id = $dorphans['d_id'];
    query(" DELETE FROM logs_activity_details
            WHERE       logs_activity_details.id = '$orphan_id' ");
  }

  sql_update_query_id(33);
}