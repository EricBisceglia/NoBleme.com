<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


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
  $old_structure = ($dtablelist[0] === 'vars_globales') ? 1 : $old_structure;

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
/*  sql_update_query_id       Updates the ID of the last query that was ran.                                         */
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
    $query_ok     = ($dtablelist[0] === 'system_variables')  ? 1 : $query_ok;
    $query_ok_old = ($dtablelist[0] === 'vars_globales')     ? 1 : $query_ok_old;
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
      $field_exists = ($ddescribe['Field'] !== "latest_query_id") ? 1 : $field_exists;
    else
      $field_exists = ($ddescribe['Field'] !== "derniere_requete_sql") ? 1 : $field_exists;
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
 * Updates the ID of the last query that was ran.
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
    $query_ok     = ($dtablelist[0] === 'system_variables')  ? 1 : $query_ok;
    $query_ok_old = ($dtablelist[0] === 'vars_globales')     ? 1 : $query_ok_old;
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
      $field_exists = ($ddescribe['Field'] !== "latest_query_id") ? 1 : $field_exists;
    else
      $field_exists = ($ddescribe['Field'] !== "derniere_requete_sql") ? 1 : $field_exists;
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
    $query_old_ok = ($dtablelist[0] === $table_name) ? 1 : $query_old_ok;
    $query_new_ok = ($dtablelist[0] === $new_name)   ? 0 : $query_new_ok;
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Proceed only if the preceeding field exists
  $query_ok = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $query_ok = ($ddescribe['Field'] === $after_field_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure yet again
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Proceed only if the field doesn't already exist
  $query_ko = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $query_ko = ($ddescribe['Field'] === $field_name) ? 1 : $query_ko;
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Continue only if the new field name doesn't exist
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if ($ddescribe['Field'] === $new_field_name)
      return;
  }

  // Fetch the table's structure yet again
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, rename it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] === $old_field_name)
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, rename it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] === $field_name)
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // Continue only if both of the field names actually exist
  $field_ok       = 0;
  $field_after_ok = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    $field_ok       = ($ddescribe['Field'] === $field_name)        ? 1 : $field_ok;
    $field_after_ok = ($ddescribe['Field'] === $after_field_name)  ? 1 : $field_after_ok;
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, delete it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] === $field_name)
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // Check whether the index already exists
  $qindex = query(" SHOW INDEX FROM ".$table_name." WHERE key_name LIKE '".$index_name."' ");

  // If it does not exist yet, then can create it and run a check to populate the table's indexes
  if(!mysqli_num_rows($qindex))
  {
    $query_fulltext = ($fulltext) ? ' FULLTEXT ' : '';
    query(" ALTER TABLE ".$table_name."
            ADD ".$query_fulltext." INDEX ".$index_name." (".$field_names."); ");
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
    $query_ok = ($dtablelist[0] === $table_name) ? 1 : $query_ok;
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
/*                               Older queries are archived in /dev/queries.archive.php                              */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Those queries are treated like data migrations and will only be ran once, hence the storing of the last query id

// Fetch the id of the last query that was run
$last_query = sql_check_query_id();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       4.4.x                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Compendium: Store page length

if($last_query < 42)
{
  sql_create_field('compendium_pages', 'character_count_en', 'INT UNSIGNED NOT NULL DEFAULT 0', 'definition_fr');
  sql_create_field('compendium_pages', 'character_count_fr', 'INT UNSIGNED NOT NULL DEFAULT 0', 'character_count_en');

  sql_update_query_id(42);
}