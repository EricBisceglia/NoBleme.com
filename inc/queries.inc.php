<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                This page contains all SQL queries that will be ran during an update of the website                */
/*                   It can only be called by a website admin through the page /pages/dev/requetes                   */
/*      Since this page is only called once during each update, performance optimization is not an issue at all      */
/*                                                                                                                   */
/*        A bunch of functions for manipulating SQL are included in this page, making it a proto-ORM of sorts        */
/*    Queries are done in such a way that they can only be ran once, avoiding a lot of potential silly situations    */
/*                                                                                                                   */
/*         If you want to modifiy the database structure, do it by adding content to the bottom of this page         */
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

/**
 * Checks whether a query should be ran or not.
 *
 * @return void
 */

function sql_check_query_id()
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
    return;

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
 * @param   int $id ID of the query.
 *
 * @return  void
 */

function sql_update_query_id($id)
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
 * @return void
 */

function sql_create_table($table_name)
{
  // Create the table
  return query(" CREATE TABLE IF NOT EXISTS ".$table_name." ( id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM;");
}




/**
 * Renames an existing table.
 *
 * @param   string  $table_name The old name of the table.
 * @param   string  $new_name   The new name of the table.
 *
 * @return void
 */

function sql_rename_table($table_name, $new_name)
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
 * Gets rid of all the data in an existing table
 *
 * @param   string  $table_name The table's name.
 *
 * @return  void
 */

function sql_empty_table($table_name)
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
 * @param   string  $table_name The table's name.
 *
 * @return  void
 */

function sql_delete_table($table_name)
{
  // Delete the table
  query(" DROP TABLE IF EXISTS ".$table_name);
}




/**
 * Creates a new field in an existing table.
 *
 * @param   string  $table_name       The existing table's name.
 * @param   string  $field_name       The new field's name.
 * @param   string  $field_type       The new field's MySQL type.
 * @param   string  $after_field_name Where to place the new field - name of the field that will be before the new one.
 *
 * @return void
 */

function sql_create_field($table_name, $field_name, $field_type, $after_field_name)
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
 * @param   string  $table_name     The existing table's name.
 * @param   string  $old_field_name The field's old name.
 * @param   string  $new_field_name The field's new name.
 * @param   string  $field_type     The MySQL type of the field.
 *
 * @return  void
 */

function sql_rename_field($table_name, $old_field_name, $new_field_name, $field_type)
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
 * @param   string  $table_name The existing table's name.
 * @param   string  $field_name The existing field's name.
 * @param   string  $field_type The MySQL type to give the field.
 *
 * @return  void
 */

function sql_change_field_type($table_name, $field_name, $field_type)
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
 * @param   string  $table_name       The existing table's name.
 * @param   string  $field_name       The existing field's name.
 * @param   string  $field_type       The MySQL type of the field.
 * @param   string  $after_field_name Where to place this field - name of the existing field after which it should be.
 */

function sql_move_field($table_name, $field_name, $field_type, $after_field_name)
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
 * @param   string  $table_name The existing table's name.
 * @param   string  $field_name The existing field's name
 *
 * @return  void
 */

function sql_delete_field($table_name, $field_name)
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
 * @param   string    $table_name               The name of the existing table.
 * @param   string    $index_name               The name of the index that will be created.
 * @param   string    $field_names              One or more fields to be indexed (eg. "my_field, other_field").
 * @param   int|null  $fulltext     (OPTIONAL)  If set, the index will be created as fulltext.
 *
 * @return  void
 */

function sql_create_index($table_name, $index_name, $field_names, $fulltext=NULL)
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
    $temp_fulltext = ($fulltext) ? ' FULLTEXT ' : '';
    query(" ALTER TABLE ".$table_name."
            ADD ".$temp_fulltext." INDEX ".$index_name." (".$field_names."); ");
    query(" CHECK TABLE ".$table_name." ");
  }
}




/**
 * Deletes an existing index in an existing table.
 *
 * @param   string  $table_name The existing table's name.
 * @param   string  $index_name The existing index's name.
 *
 * @return  void
 */

function sql_delete_index($table_name, $index_name)
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

function sql_insert_value($condition, $query)
{
  // If the condition is met, run the query
  if(!mysqli_num_rows(query($condition)))
    query($query);
}




/**
 * Sanitizes data for MySQL queries.
 *
 * @param   string  $data The data to sanitize.
 *
 * @return  void
 */

function sql_sanitize_data($data)
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
/*                          Allows replaying of all past queries that haven't been run yet                           */
/*              in order to ensure a version upgrade between any two versions of NoBleme goes smoothly               */
/*                                                                                                                   */
/*                 Before version 3, query history was not recorded, hence the lack of older content                 */
/*                Before version 4, table and field names were in french, hence the non-english stuff                */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Global requirement: fetch the id of the last query that was run

$last_query = sql_check_query_id();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 VERSION 3 BUILD 5                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Structural change of the writer's corner

if($last_query < 1)
{
  sql_delete_field('ecrivains_concours', 'FKforum_sujet');
  sql_rename_field('ecrivains_concours', 'date_debut', 'timestamp_debut', 'INT(11) UNSIGNED NOT NULL');
  sql_rename_field('ecrivains_concours', 'date_fin', 'timestamp_fin', 'INT(11) UNSIGNED NOT NULL');

  sql_create_field('ecrivains_concours', 'FKmembres_gagnant', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_create_field('ecrivains_concours', 'FKecrivains_texte_gagnant', 'INT(11) UNSIGNED NOT NULL', 'FKmembres_gagnant');
  sql_create_field('ecrivains_concours', 'num_participants', 'INT(11) UNSIGNED NOT NULL', 'timestamp_fin');
  sql_create_field('ecrivains_concours_vote', 'poids_vote', 'INT(11) UNSIGNED NOT NULL', 'FKmembres');

  sql_update_query_id(1);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Table used to simulate cronjobs

if($last_query < 2)
{
  sql_create_table("automatisation", " id                 INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
                                      action_id           INT(11) UNSIGNED NOT NULL                             ,
                                      action_type         MEDIUMTEXT                                            ,
                                      action_description  MEDIUMTEXT                                            ,
                                      action_timestamp    INT(11) UNSIGNED NOT NULL                             ");

  sql_update_query_id(2);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 VERSION 3 BUILD 6                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Fulltext indexes for internet encyclopedia & dictionary search

if($last_query < 3)
{
  sql_create_index('nbdb_web_page', 'index_contenu_en', 'contenu_en', 1);
  sql_create_index('nbdb_web_page', 'index_contenu_fr', 'contenu_fr', 1);

  sql_create_index('nbdb_web_definition', 'index_definition_en', 'definition_en', 1);
  sql_create_index('nbdb_web_definition', 'index_definition_fr', 'definition_fr', 1);

  sql_create_index('nbdb_web_categorie', 'index_description_fr', 'description_fr', 1);
  sql_create_index('nbdb_web_categorie', 'index_description_en', 'description_en', 1);

  sql_create_index('nbdb_web_definition', 'index_definition_fr', 'definition_fr', 1);
  sql_create_index('nbdb_web_definition', 'index_definition_en', 'definition_en', 1);

  sql_update_query_id(3);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Missing indexes

if($last_query < 4)
{
  sql_create_index('automatisation', 'index_action', 'action_id');

  sql_create_index('ecrivains_concours', 'index_gagnant', 'FKecrivains_texte_gagnant, FKmembres_gagnant');

  sql_create_index('ecrivains_concours_vote', 'index_texte', 'FKecrivains_concours');
  sql_create_index('ecrivains_concours_vote', 'index_concours', 'FKecrivains_texte');
  sql_create_index('ecrivains_concours_vote', 'index_membre', 'FKmembres');
  sql_create_index('ecrivains_concours_vote', 'index_poids', 'poids_vote, FKmembres, FKecrivains_texte, FKecrivains_concours');

  sql_create_index('ecrivains_note', 'index_texte', 'FKecrivains_texte');
  sql_create_index('ecrivains_note', 'index_membre', 'FKmembres');
  sql_create_index('ecrivains_note', 'index_note', 'note');

  sql_create_index('ecrivains_texte', 'index_auteur', 'anonyme, FKmembres');
  sql_create_index('ecrivains_texte', 'index_concours', 'FKecrivains_concours');

  sql_update_query_id(4);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Encyclopedia of internet culture

if($last_query < 5)
{
  sql_create_table('nbdb_web_page');

  sql_create_field('nbdb_web_page', 'FKnbdb_web_periode', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_create_field('nbdb_web_page', 'titre_fr', 'MEDIUMTEXT', 'FKnbdb_web_periode');
  sql_create_field('nbdb_web_page', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
  sql_create_field('nbdb_web_page', 'redirection_fr', 'MEDIUMTEXT', 'titre_en');
  sql_create_field('nbdb_web_page', 'redirection_en', 'MEDIUMTEXT', 'redirection_fr');
  sql_create_field('nbdb_web_page', 'contenu_fr', 'LONGTEXT', 'redirection_en');
  sql_create_field('nbdb_web_page', 'contenu_en', 'LONGTEXT', 'contenu_fr');
  sql_create_field('nbdb_web_page', 'annee_apparition', 'INT(4)', 'contenu_en');
  sql_create_field('nbdb_web_page', 'mois_apparition', 'INT(2)', 'annee_apparition');
  sql_create_field('nbdb_web_page', 'annee_popularisation', 'INT(4)', 'mois_apparition');
  sql_create_field('nbdb_web_page', 'mois_popularisation', 'INT(2)', 'annee_popularisation');
  sql_create_field('nbdb_web_page', 'est_vulgaire', 'TINYINT(1)', 'mois_popularisation');
  sql_create_field('nbdb_web_page', 'est_politise', 'TINYINT(1)', 'est_vulgaire');
  sql_create_field('nbdb_web_page', 'est_incorrect', 'TINYINT(1)', 'est_politise');

  sql_create_index('nbdb_web_page', 'index_periode', 'FKnbdb_web_periode');
  sql_create_index('nbdb_web_page', 'index_apparition', 'annee_apparition, mois_apparition');
  sql_create_index('nbdb_web_page', 'index_popularisation', 'annee_popularisation, mois_popularisation');
  sql_create_index('nbdb_web_page', 'index_titre_fr', 'titre_fr (25)');
  sql_create_index('nbdb_web_page', 'index_titre_en', 'titre_en (25)');

  sql_update_query_id(5);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Dictionary of internet culture

if($last_query < 6)
{
  sql_create_table('nbdb_web_definition');

  sql_create_field('nbdb_web_definition', 'titre_fr', 'MEDIUMTEXT', 'id');
  sql_create_field('nbdb_web_definition', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
  sql_create_field('nbdb_web_definition', 'redirection_fr', 'MEDIUMTEXT', 'titre_en');
  sql_create_field('nbdb_web_definition', 'redirection_en', 'MEDIUMTEXT', 'redirection_fr');
  sql_create_field('nbdb_web_definition', 'definition_fr', 'LONGTEXT', 'redirection_en');
  sql_create_field('nbdb_web_definition', 'definition_en', 'LONGTEXT', 'definition_fr');
  sql_create_field('nbdb_web_definition', 'est_vulgaire', 'TINYINT(1)', 'definition_en');
  sql_create_field('nbdb_web_definition', 'est_politise', 'TINYINT(1)', 'est_vulgaire');
  sql_create_field('nbdb_web_definition', 'est_incorrect', 'TINYINT(1)', 'est_politise');

  sql_create_index('nbdb_web_definition', 'index_titre_fr', 'titre_fr (25)');
  sql_create_index('nbdb_web_definition', 'index_titre_en', 'titre_en (25)');

  sql_update_query_id(6);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Internet culture eras

if($last_query < 7)
{
  sql_create_table('nbdb_web_periode');

  sql_create_field('nbdb_web_periode', 'titre_fr', 'MEDIUMTEXT', 'id');
  sql_create_field('nbdb_web_periode', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
  sql_create_field('nbdb_web_periode', 'description_fr', 'MEDIUMTEXT', 'titre_en');
  sql_create_field('nbdb_web_periode', 'description_en', 'MEDIUMTEXT', 'description_fr');
  sql_create_field('nbdb_web_periode', 'annee_debut', 'INT(4)', 'description_en');
  sql_create_field('nbdb_web_periode', 'annee_fin', 'INT(4)', 'annee_debut');

  sql_update_query_id(7);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Internet culture categories

if($last_query < 8)
{
  sql_create_table('nbdb_web_categorie');

  sql_create_field('nbdb_web_categorie', 'titre_fr', 'MEDIUMTEXT', 'id');
  sql_create_field('nbdb_web_categorie', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
  sql_create_field('nbdb_web_categorie', 'ordre_affichage', 'INT(11) UNSIGNED NOT NULL', 'titre_en');
  sql_create_field('nbdb_web_categorie', 'description_fr', 'MEDIUMTEXT', 'ordre_affichage');
  sql_create_field('nbdb_web_categorie', 'description_en', 'MEDIUMTEXT', 'description_fr');

  sql_create_index('nbdb_web_categorie', 'index_ordre_affichage', 'ordre_affichage');

  sql_update_query_id(8);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Internet culture page categories

if($last_query < 9)
{
  sql_create_table('nbdb_web_page_categorie');

  sql_create_field('nbdb_web_page_categorie', 'FKnbdb_web_page', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_create_field('nbdb_web_page_categorie', 'FKnbdb_web_categorie', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_page');

  sql_create_index('nbdb_web_page_categorie', 'index_pages', 'FKnbdb_web_page, FKnbdb_web_categorie');

  sql_update_query_id(9);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Internet culture images

if($last_query < 10)
{
  sql_create_table('nbdb_web_image');

  sql_create_field('nbdb_web_image', 'timestamp_upload', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_create_field('nbdb_web_image', 'nom_fichier', 'MEDIUMTEXT', 'timestamp_upload');
  sql_create_field('nbdb_web_image', 'tags', 'MEDIUMTEXT', 'nom_fichier');

  sql_update_query_id(10);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 VERSION 3 BUILD 7                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/
// #505 - Make quotes bilingual

if($last_query < 11)
{
  sql_create_field('quotes', 'langue', 'TINYTEXT', 'timestamp');

  query(" UPDATE  quotes
          SET     quotes.langue = 'FR'
          WHERE   quotes.langue IS NULL ");

  query(" UPDATE  activite
          SET     activite.action_type  =     'quote_new_fr'
          WHERE   activite.action_type  LIKE  'quote' ");

  sql_update_query_id(11);
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Store latest user activity

if($last_query < 12)
{
  sql_create_field('membres', 'derniere_activite', 'INT(11) UNSIGNED NOT NULL', 'derniere_visite_ip');

  sql_update_query_id(12);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 VERSION 3 BUILD 8                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/
// #496 - Option to turn off google trends

if($last_query < 13)
{
  sql_create_field('membres', 'voir_tweets', 'TINYINT(1)', 'voir_nsfw');
  sql_create_field('membres', 'voir_youtube', 'TINYINT(1)', 'voir_tweets');
  sql_create_field('membres', 'voir_google_trends', 'TINYINT(1)', 'voir_youtube');

  sql_update_query_id(13);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #477 - Allow tagging of internet culture encyclopedia/dictionary content as NSFW

if($last_query < 14)
{
  sql_create_field('nbdb_web_page', 'contenu_floute', 'TINYINT(1)', 'mois_popularisation');
  sql_create_field('nbdb_web_definition', 'contenu_floute', 'TINYINT(1)', 'definition_en');
  sql_create_field('nbdb_web_image', 'nsfw', 'TINYINT(1)', 'tags');

  sql_update_query_id(14);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 VERSION 3 BUILD 9                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/
// #533 - Private comments in the encyclopedia of interent culture

if($last_query < 15)
{
  sql_create_field('nbdb_web_definition', 'notes_admin', 'LONGTEXT', 'est_incorrect');
  sql_create_field('nbdb_web_page', 'notes_admin', 'LONGTEXT', 'est_incorrect');
  sql_create_table('nbdb_web_notes_admin');
  sql_create_field('nbdb_web_notes_admin', 'notes_admin', 'LONGTEXT', 'id');
  sql_create_field('nbdb_web_notes_admin', 'brouillon_fr', 'LONGTEXT', 'notes_admin');
  sql_create_field('nbdb_web_notes_admin', 'brouillon_en', 'LONGTEXT', 'brouillon_fr');

  sql_update_query_id(15);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #543 - SQL query history (this page!)

if($last_query < 16)
{
  sql_create_field("vars_globales", "derniere_requete_sql", "TINYINT(1) NOT NULL", "mise_a_jour");

  sql_update_query_id(16);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #533 - Internet culture encyclopedia private comments do not need an id

if($last_query < 17)
{
  sql_delete_field("nbdb_web_notes_admin", "id");

  sql_update_query_id(17);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #547 - Private templates for the internet culture encyclopedia

if($last_query < 18)
{
  sql_create_field("nbdb_web_notes_admin", "template_global", "LONGTEXT", "brouillon_en");
  sql_create_field("nbdb_web_notes_admin", "template_fr", "LONGTEXT", "template_global");
  sql_create_field("nbdb_web_notes_admin", "template_en", "LONGTEXT", "template_fr");

  sql_update_query_id(18);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #542 - Make the to-do list bilingual

if($last_query < 19)
{
  sql_rename_field("todo", "titre", "titre_fr", "MEDIUMTEXT");
  sql_create_field("todo", "titre_en", "MEDIUMTEXT", "titre_fr");
  sql_rename_field("todo", "contenu", "contenu_fr", "MEDIUMTEXT");
  sql_create_field("todo", "contenu_en", "MEDIUMTEXT", "contenu_fr");

  sql_delete_index("todo", "index_titre");
  sql_create_index("todo", "index_titre_fr", "titre_fr", 1);
  sql_create_index("todo", "index_titre_en", "titre_en", 1);

  sql_rename_field("todo_categorie", "categorie", "titre_fr", "TINYTEXT");
  sql_create_field("todo_categorie", "titre_en", "TINYTEXT", "titre_fr");
  query(" UPDATE todo_categorie SET todo_categorie.titre_en = todo_categorie.titre_fr ");

  sql_rename_field("todo_roadmap", "version", "version_fr", "TINYTEXT");
  sql_rename_field("todo_roadmap", "description", "description_fr", "MEDIUMTEXT");
  sql_create_field("todo_roadmap", "version_en", "TINYTEXT", "version_fr");
  sql_create_field("todo_roadmap", "description_en", "MEDIUMTEXT", "description_fr");
  query(" UPDATE todo_roadmap SET todo_roadmap.version_en = todo_roadmap.version_fr ");
  query(" UPDATE todo_roadmap SET todo_roadmap.description_en = todo_roadmap.description_fr ");

  sql_update_query_id(19);
}


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

  sql_rename_field('system_variables', 'mise_a_jour', 'update_in_progress', 'INT UNSIGNED NOT NULL PRIMARY KEY');
  sql_rename_field('system_variables', 'derniere_requete_sql', 'latest_query_id', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('system_variables', 'last_scheduler_execution', 'INT UNSIGNED NOT NULL DEFAULT 0', 'latest_query_id');
  sql_change_field_type('system_variables', 'last_pageview_check', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('system_variables', 'mise_a_jour');

  sql_change_field_type('system_versions', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_change_field_type('system_versions', 'version', 'VARCHAR(20) NOT NULL');
  sql_change_field_type('system_versions', 'build', 'VARCHAR(10) NOT NULL');
  sql_create_index('system_versions', 'index_full_version', 'version, build');

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
  sql_rename_field('logs_activity', 'log_moderation', 'is_administrators_only', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('logs_activity', 'language', 'VARCHAR(12) NOT NULL', 'is_administrators_only');
  sql_rename_field('logs_activity', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('logs_activity', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_rename_field('logs_activity', 'pseudonyme', 'nickname', 'VARCHAR(45) NOT NULL');
  sql_rename_field('logs_activity', 'action_type', 'activity_type', 'VARCHAR(40) NOT NULL');
  sql_rename_field('logs_activity', 'action_id', 'activity_id', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('logs_activity', 'activity_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'nickname');
  sql_rename_field('logs_activity', 'action_titre', 'activity_summary', 'TEXT NOT NULL');
  sql_rename_field('logs_activity', 'parent', 'activity_parent', 'TEXT NOT NULL');
  sql_rename_field('logs_activity', 'justification', 'moderation_reason', 'TEXT NOT NULL');
  sql_delete_index('logs_activity', 'index_membres');
  sql_delete_index('logs_activity', 'index_action');
  sql_delete_index('logs_activity', 'index_type');
  sql_create_index('logs_activity', 'index_related_users', 'fk_users');
  sql_create_index('logs_activity', 'index_language', 'language');
  sql_create_index('logs_activity', 'index_related_foreign_keys', 'activity_id');
  sql_create_index('logs_activity', 'index_activity_type', 'activity_type(40)');

  sql_change_field_type('logs_activity_details', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('logs_activity_details', 'FKactivite', 'fk_logs_activity', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('logs_activity_details', 'titre_diff', 'content_description_fr', 'TEXT NOT NULL');
  sql_create_field('logs_activity_details', 'content_description_en', 'TEXT NOT NULL', 'fk_logs_activity');
  sql_rename_field('logs_activity_details', 'diff_avant', 'content_before', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('logs_activity_details', 'diff_apres', 'content_after', 'MEDIUMTEXT NOT NULL');
  sql_delete_index('logs_activity_details', 'index_activite');
  sql_create_index('logs_activity_details', 'index_logs_activity', 'fk_logs_activity');

  sql_update_query_id(21);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Stats tables

if($last_query < 22)
{
  sql_rename_table('pageviews', 'stats_pageviews');

  sql_change_field_type('stats_pageviews', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('stats_pageviews', 'nom_page', 'page_name', 'VARCHAR(255) NOT NULL');
  sql_rename_field('stats_pageviews', 'url_page', 'page_url', 'TEXT NOT NULL');
  sql_rename_field('stats_pageviews', 'vues', 'view_count', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('stats_pageviews', 'vues_lastvisit', 'view_count_archive', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('stats_pageviews', 'index_tri');
  sql_delete_index('stats_pageviews', 'index_recherche');
  sql_create_index('stats_pageviews', 'index_view_count_stats', 'view_count, view_count_archive');

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
  sql_rename_field('dev_blogs', 'titre', 'title_en', 'VARCHAR(255) NOT NULL');
  sql_create_field('dev_blogs', 'title_fr', 'VARCHAR(255) NOT NULL', 'title_en');
  sql_rename_field('dev_blogs', 'contenu', 'body_en', 'LONGTEXT NOT NULL');
  sql_create_field('dev_blogs', 'body_fr', 'LONGTEXT NOT NULL', 'body_en');

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
  sql_create_index('dev_tasks', 'index_authors', 'fk_users');
  sql_create_index('dev_tasks', 'index_categories', 'fk_dev_tasks_categories');
  sql_create_index('dev_tasks', 'index_milestones', 'fk_dev_tasks_milestones');
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
// #544 - Translation and optimization of all tables - Writer's corner

if($last_query < 24)
{
  sql_rename_table('ecrivains_texte', 'writings_texts');
  sql_rename_table('ecrivains_note', 'writings_comments');
  sql_rename_table('ecrivains_concours', 'writings_contests');
  sql_rename_table('ecrivains_concours_vote', 'writings_contests_votes');

  sql_change_field_type('writings_texts', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('writings_texts', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_texts', 'FKecrivains_concours', 'fk_writings_contests', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('writings_texts', 'language', 'VARCHAR(6) NOT NULL', 'fk_writings_contests');
  sql_rename_field('writings_texts', 'anonyme', 'is_anonymous', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_texts', 'timestamp_creation', 'created_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_texts', 'timestamp_modification', 'edited_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_texts', 'niveau_feedback', 'desired_feedback_level', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_texts', 'titre', 'title', 'TEXT NOT NULL');
  sql_rename_field('writings_texts', 'note_moyenne', 'average_rating', 'DECIMAL(2,1) NOT NULL DEFAULT 0');
  sql_rename_field('writings_texts', 'longueur_texte', 'character_count', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('writings_texts', 'title', 'TEXT NOT NULL', 'character_count');
  sql_rename_field('writings_texts', 'contenu', 'body', 'LONGTEXT NOT NULL');
  sql_delete_index('writings_texts', 'index_auteur');
  sql_delete_index('writings_texts', 'index_concours');
  sql_create_index('writings_texts', 'index_author', 'fk_users, is_anonymous');
  sql_create_index('writings_texts', 'index_contest', 'fk_writings_contests');
  sql_create_index('writings_texts', 'index_language', 'language');

  sql_change_field_type('writings_comments', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('writings_comments', 'FKecrivains_texte', 'fk_writings_texts', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_comments', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_comments', 'timestamp', 'posted_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_comments', 'note', 'rating', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_comments', 'anonyme', 'is_anonymous', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_comments', 'message', 'message_body', 'MEDIUMTEXT NOT NULL');
  sql_delete_index('writings_comments', 'index_texte');
  sql_delete_index('writings_comments', 'index_membre');
  sql_delete_index('writings_comments', 'index_note');
  sql_create_index('writings_comments', 'index_author', 'fk_users, is_anonymous');
  sql_create_index('writings_comments', 'index_text', 'fk_writings_texts');
  sql_create_index('writings_comments', 'index_ratings', 'rating');

  sql_change_field_type('writings_contests', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('writings_contests', 'FKmembres_gagnant', 'fk_users_winner', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_contests', 'FKecrivains_texte_gagnant', 'fk_writings_texts_winner', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_create_field('writings_contests', 'language', 'VARCHAR(6) NOT NULL', 'fk_writings_texts_winner');
  sql_rename_field('writings_contests', 'timestamp_debut', 'started_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_contests', 'timestamp_fin', 'ended_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_contests', 'num_participants', 'nb_entries', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_contests', 'titre', 'contest_name', 'TEXT NOT NULL');
  sql_rename_field('writings_contests', 'sujet', 'contest_topic', 'TEXT NOT NULL');
  sql_delete_index('writings_contests', 'index_gagnant');
  sql_create_index('writings_contests', 'index_winner', 'fk_users_winner');
  sql_create_index('writings_contests', 'index_winning_text', 'fk_writings_texts_winner');
  sql_create_index('writings_contests', 'index_language', 'language');

  sql_change_field_type('writings_contests_votes', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('writings_contests_votes', 'FKecrivains_concours', 'fk_writings_contests', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_contests_votes', 'FKecrivains_texte', 'fk_writings_texts', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_contests_votes', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('writings_contests_votes', 'poids_vote', 'vote_weight', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('writings_contests_votes', 'index_texte');
  sql_delete_index('writings_contests_votes', 'index_concours');
  sql_delete_index('writings_contests_votes', 'index_membre');
  sql_delete_index('writings_contests_votes', 'index_poids');
  sql_create_index('writings_contests_votes', 'index_author', 'fk_users');
  sql_create_index('writings_contests_votes', 'index_contest', 'fk_writings_contests');
  sql_create_index('writings_contests_votes', 'index_text', 'fk_writings_texts');
  sql_create_index('writings_contests_votes', 'index_ratings', 'vote_weight, fk_writings_contests, fk_writings_texts');

  sql_update_query_id(24);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Forum

if($last_query < 25)
{
  sql_rename_table('forum_sujet', 'forum_threads');
  sql_rename_table('forum_message', 'forum_messages');
  sql_rename_table('forum_categorie', 'forum_categories');
  sql_rename_table('forum_filtrage', 'forum_categories_filters');

  sql_change_field_type('forum_threads', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('forum_threads', 'FKmembres_createur', 'fk_users_author', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_threads', 'FKmembres_dernier_message', 'fk_users_last_message', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_threads', 'FKforum_categorie', 'fk_forum_categories', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_threads', 'timestamp_creation', 'created_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_threads', 'timestamp_dernier_message', 'last_message_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_threads', 'apparence', 'thread_format', 'VARCHAR(50) NOT NULL');
  sql_rename_field('forum_threads', 'classification', 'thread_type', 'VARCHAR(50) NOT NULL');
  sql_rename_field('forum_threads', 'public', 'is_private', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  query(" UPDATE forum_threads SET forum_threads.is_private = 2 WHERE forum_threads.is_private = 1 ");
  query(" UPDATE forum_threads SET forum_threads.is_private = 1 WHERE forum_threads.is_private = 0 ");
  query(" UPDATE forum_threads SET forum_threads.is_private = 0 WHERE forum_threads.is_private = 2 ");
  sql_rename_field('forum_threads', 'ouvert', 'is_closed', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  query(" UPDATE forum_threads SET forum_threads.is_closed = 2 WHERE forum_threads.is_closed = 1 ");
  query(" UPDATE forum_threads SET forum_threads.is_closed = 1 WHERE forum_threads.is_closed = 0 ");
  query(" UPDATE forum_threads SET forum_threads.is_closed = 0 WHERE forum_threads.is_closed = 2 ");
  sql_rename_field('forum_threads', 'epingle', 'is_pinned', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_threads', 'langue', 'language', 'VARCHAR(12) NOT NULL');
  sql_rename_field('forum_threads', 'titre', 'title', 'TEXT NOT NULL');
  sql_rename_field('forum_threads', 'nombre_reponses', 'nb_messages', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('forum_threads', 'nb_messages', 'INT UNSIGNED NOT NULL DEFAULT 0', 'is_pinned');
  sql_delete_index('forum_threads', 'index_createur');
  sql_delete_index('forum_threads', 'index_dernier');
  sql_delete_index('forum_threads', 'index_categorie');
  sql_delete_index('forum_threads', 'index_chronologie');
  sql_delete_index('forum_threads', 'index_titre');
  sql_create_index('forum_threads', 'index_author', 'fk_users_author');
  sql_create_index('forum_threads', 'index_latest_contributor', 'fk_users_last_message');
  sql_create_index('forum_threads', 'index_category', 'fk_forum_categories');
  sql_create_index('forum_threads', 'index_chronology', 'last_message_at');
  sql_create_index('forum_threads', 'index_title', 'title', 1);

  sql_change_field_type('forum_messages', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('forum_messages', 'FKforum_sujet', 'fk_forum_threads', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_messages', 'FKforum_message_parent', 'fk_forum_messages_parent', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_messages', 'FKmembres', 'fk_author', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_messages', 'timestamp_creation', 'posted_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_messages', 'timestamp_modification', 'edited_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_messages', 'message_supprime', 'deleted_message', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_messages', 'contenu', 'body', 'LONGTEXT NOT NULL');
  sql_delete_index('forum_messages', 'index_sujet');
  sql_delete_index('forum_messages', 'index_parent');
  sql_delete_index('forum_messages', 'index_membres');
  sql_delete_index('forum_messages', 'index_chronologie');
  sql_delete_index('forum_messages', 'index_contenu');
  sql_create_index('forum_messages', 'index_author', 'fk_author');
  sql_create_index('forum_messages', 'index_thread', 'fk_forum_threads');
  sql_create_index('forum_messages', 'index_hierarchy', 'fk_forum_messages_parent');
  sql_create_index('forum_messages', 'index_contents', 'body', 1);

  sql_change_field_type('forum_categories', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('forum_categories', 'par_defaut', 'is_default_category', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_categories', 'classement', 'display_order', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_categories', 'nom_fr', 'title_fr', 'TEXT NOT NULL');
  sql_rename_field('forum_categories', 'nom_en', 'title_en', 'TEXT NOT NULL');
  sql_move_field('forum_categories', 'title_fr', 'TEXT NOT NULL', 'title_en');
  sql_rename_field('forum_categories', 'description_fr', 'explanation_fr', 'TEXT NOT NULL');
  sql_rename_field('forum_categories', 'description_en', 'explanation_en', 'TEXT NOT NULL');
  sql_move_field('forum_categories', 'explanation_fr', 'TEXT NOT NULL', 'explanation_en');
  sql_delete_index('forum_categories', 'index_classement');
  sql_create_index('forum_categories', 'index_display_order', 'display_order');

  sql_change_field_type('forum_categories_filters', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('forum_categories_filters', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('forum_categories_filters', 'FKforum_categorie', 'fk_forum_categories', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('forum_categories_filters', 'index_membres');
  sql_delete_index('forum_categories_filters', 'index_categorie');
  sql_create_index('forum_categories_filters', 'index_user_filters', 'fk_users, fk_forum_categories');

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
  sql_rename_field('users', 'pseudonyme', 'nickname', 'VARCHAR(45) NOT NULL');
  sql_rename_field('users', 'pass', 'password', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('users', 'admin', 'is_administrator', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users', 'sysop', 'is_global_moderator', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users', 'moderateur', 'moderator_rights', 'VARCHAR(255) NOT NULL');
  query(" UPDATE users SET users.moderator_rights = '' WHERE users.moderator_rights LIKE '0' ");
  query(" UPDATE users SET users.moderator_rights = 'meetups' WHERE users.moderator_rights LIKE 'irl' ");
  sql_create_field('users', 'is_moderator', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'moderator_rights');
  sql_move_field('users', 'is_moderator', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'is_global_moderator');
  query(" UPDATE users SET users.is_moderator = 0 WHERE users.moderator_rights = '' ");
  query(" UPDATE users SET users.is_moderator = 1 WHERE users.moderator_rights != '' ");
  sql_rename_field('users', 'moderateur_description_fr', 'moderator_title_fr', 'VARCHAR(255) NOT NULL');
  sql_rename_field('users', 'moderateur_description_en', 'moderator_title_en', 'VARCHAR(255) NOT NULL');
  sql_move_field('users', 'moderator_title_fr', 'VARCHAR(255) NOT NULL', 'moderator_title_en');
  sql_rename_field('users', 'derniere_visite', 'last_visited_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users', 'derniere_visite_page', 'last_visited_page_en', "VARCHAR(510) NOT NULL");
  sql_create_field('users', 'last_visited_page_fr', "VARCHAR(510) NOT NULL", 'last_visited_page_en');
  sql_rename_field('users', 'derniere_visite_url', 'last_visited_url', "VARCHAR(510) NOT NULL");
  sql_rename_field('users', 'derniere_visite_ip', 'current_ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'");
  sql_rename_field('users', 'derniere_activite', 'last_action_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('users', 'last_action_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'last_visited_at');
  sql_rename_field('users', 'banni_date', 'is_banned_until', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users', 'banni_raison', 'is_banned_because', 'TEXT NOT NULL');
  sql_delete_index('users', 'index_login');
  sql_delete_index('users', 'index_droits');
  sql_create_index('users', 'index_access_rights', 'is_administrator, is_global_moderator, is_moderator, moderator_rights(127)');
  sql_create_index('users', 'index_doppelgangers', 'current_ip_address');
  sql_create_index('users', 'index_banned', 'is_banned_until');

  sql_create_field('users_profile', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_profile', 'email_address', 'VARCHAR(510) NOT NULL', 'fk_users');
  sql_create_field('users_profile', 'created_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'email_address');
  sql_create_field('users_profile', 'spoken_languages', 'VARCHAR(12) NOT NULL', 'created_at');
  sql_create_field('users_profile', 'gender', 'VARCHAR(105) NOT NULL', 'spoken_languages');
  sql_create_field('users_profile', 'birthday', "DATE NOT NULL DEFAULT '0000-00-00'", 'created_at');
  sql_create_field('users_profile', 'lives_at', 'VARCHAR(105) NOT NULL', 'gender');
  sql_create_field('users_profile', 'occupation', 'VARCHAR(105) NOT NULL', 'lives_at');
  sql_create_field('users_profile', 'profile_text', 'LONGTEXT NOT NULL', 'occupation');
  $qusers = query(" SELECT  users.id            AS 'u_id'         ,
                            users.email         AS 'u_mail'       ,
                            users.date_creation AS 'u_created'    ,
                            users.langue        AS 'u_languages'  ,
                            users.genre         AS 'u_gender'     ,
                            users.anniversaire  AS 'u_birthday'   ,
                            users.habite        AS 'u_lives_at'   ,
                            users.metier        AS 'u_occupation' ,
                            users.profil        AS 'u_profile'
                    FROM    users ");
  while($dusers = mysqli_fetch_array($qusers))
    query(" INSERT INTO users_profile
            SET         users_profile.fk_users          = '".sql_sanitize_data($dusers['u_id'])."'         ,
                        users_profile.email_address     = '".sql_sanitize_data($dusers['u_mail'])."'       ,
                        users_profile.created_at        = '".sql_sanitize_data($dusers['u_created'])."'    ,
                        users_profile.spoken_languages  = '".sql_sanitize_data($dusers['u_languages'])."'  ,
                        users_profile.gender            = '".sql_sanitize_data($dusers['u_gender'])."'     ,
                        users_profile.birthday          = '".sql_sanitize_data($dusers['u_birthday'])."'   ,
                        users_profile.lives_at          = '".sql_sanitize_data($dusers['u_lives_at'])."'   ,
                        users_profile.occupation        = '".sql_sanitize_data($dusers['u_occupation'])."' ,
                        users_profile.profile_text      = '".sql_sanitize_data($dusers['u_profile'])."'    ");
  sql_create_index('users_profile', 'index_user', 'fk_users');

  sql_create_field('users_settings', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_settings', 'show_nsfw_content', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  sql_create_field('users_settings', 'hide_tweets', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'show_nsfw_content');
  sql_create_field('users_settings', 'hide_youtube', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'hide_tweets');
  sql_create_field('users_settings', 'hide_google_trends', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'hide_youtube');
  sql_create_field('users_settings', 'forum_shown_languages', 'VARCHAR(12) NOT NULL', 'hide_google_trends');
  $qusers = query(" SELECT  users.id                  AS 'u_id'       ,
                            users.voir_nsfw           AS 'u_nsfw'     ,
                            users.voir_tweets         AS 'u_tweets'   ,
                            users.voir_youtube        AS 'u_youtube'  ,
                            users.voir_google_trends  AS 'u_trends'   ,
                            users.forum_lang          AS 'u_forumlang'
                    FROM    users ");
  while($dusers = mysqli_fetch_array($qusers))
    query(" INSERT INTO users_settings
            SET         users_settings.fk_users               = '".sql_sanitize_data($dusers['u_id'])."'        ,
                        users_settings.show_nsfw_content      = '".sql_sanitize_data($dusers['u_nsfw'])."'      ,
                        users_settings.hide_tweets            = '".sql_sanitize_data($dusers['u_tweets'])."'    ,
                        users_settings.hide_youtube           = '".sql_sanitize_data($dusers['u_youtube'])."'   ,
                        users_settings.hide_google_trends     = '".sql_sanitize_data($dusers['u_trends'])."'    ,
                        users_settings.forum_shown_languages  = '".sql_sanitize_data($dusers['u_forumlang'])."' ");
  sql_create_index('users_settings', 'index_user', 'fk_users');
  sql_create_index('users_settings', 'index_nsfw_filter', 'show_nsfw_content');

  sql_create_field('users_stats', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_stats', 'forum_message_count', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  $qusers = query(" SELECT  users.id              AS 'u_id' ,
                            users.forum_messages  AS 'u_forum'
                    FROM    users ");
  while($dusers = mysqli_fetch_array($qusers))
    query(" INSERT INTO users_stats
            SET         users_stats.fk_users             = '".sql_sanitize_data($dusers['u_id'])."'    ,
                        users_stats.forum_message_count  = '".sql_sanitize_data($dusers['u_forum'])."' ");
  sql_create_index('users_stats', 'index_user', 'fk_users');

  sql_delete_field('users', 'email');
  sql_delete_field('users', 'date_creation');
  sql_delete_field('users', 'langue');
  sql_delete_field('users', 'genre');
  sql_delete_field('users', 'anniversaire');
  sql_delete_field('users', 'habite');
  sql_delete_field('users', 'metier');
  sql_delete_field('users', 'profil');
  sql_delete_field('users', 'voir_nsfw');
  sql_delete_field('users', 'voir_tweets');
  sql_delete_field('users', 'voir_youtube');
  sql_delete_field('users', 'voir_google_trends');
  sql_delete_field('users', 'forum_messages');
  sql_delete_field('users', 'forum_lang');

  sql_change_field_type('users_guests', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('users_guests', 'ip', 'ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'");
  sql_rename_field('users_guests', 'surnom', 'randomly_assigned_name_en', 'VARCHAR(510) NOT NULL');
  sql_create_field('users_guests', 'randomly_assigned_name_fr', 'VARCHAR(510) NOT NULL', 'randomly_assigned_name_en');
  sql_rename_field('users_guests', 'derniere_visite', 'last_visited_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_guests', 'derniere_visite_page', 'last_visited_page_en', "VARCHAR(510) NOT NULL");
  sql_create_field('users_guests', 'last_visited_page_fr', "VARCHAR(510) NOT NULL", 'last_visited_page_en');
  sql_rename_field('users_guests', 'derniere_visite_url', 'last_visited_url', "VARCHAR(510) NOT NULL");
  sql_delete_index('users_guests', 'ip');

  sql_change_field_type('users_login_attempts', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('users_login_attempts', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_login_attempts', 'timestamp', 'attempted_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_login_attempts', 'ip', 'ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'");
  sql_move_field('users_login_attempts', 'ip_address', "VARCHAR(135) NOT NULL DEFAULT '0.0.0.0'", 'fk_users');
  sql_delete_index('users_login_attempts', 'index_membres');
  sql_create_index('users_login_attempts', 'index_users', 'fk_users');
  sql_create_index('users_login_attempts', 'index_guests', 'ip_address');

  sql_change_field_type('users_private_messages', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('users_private_messages', 'FKmembres_destinataire', 'fk_users_recipient', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_private_messages', 'FKmembres_envoyeur', 'fk_users_sender', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_private_messages', 'date_envoi', 'sent_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_private_messages', 'date_consultation', 'read_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('users_private_messages', 'titre', 'title', 'TEXT NOT NULL');
  sql_rename_field('users_private_messages', 'contenu', 'body', 'LONGTEXT NOT NULL');
  sql_delete_index('users_private_messages', 'index_destinataire');
  sql_delete_index('users_private_messages', 'index_envoyeur');
  sql_delete_index('users_private_messages', 'index_chronologie');
  sql_create_index('users_private_messages', 'index_inbox', 'fk_users_recipient');
  sql_create_index('users_private_messages', 'index_outbox', 'fk_users_sender');

  sql_update_query_id(26);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - IRC

if($last_query < 27)
{
  sql_rename_table('irc_canaux', 'irc_channels');

  sql_change_field_type('irc_channels', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('irc_channels', 'canal', 'name', 'VARCHAR(153) NOT NULL');
  sql_rename_field('irc_channels', 'langue', 'languages', 'VARCHAR(12) NOT NULL');
  sql_rename_field('irc_channels', 'importance', 'display_order', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('irc_channels', 'description_fr', 'details_fr', 'TEXT NOT NULL');
  sql_rename_field('irc_channels', 'description_en', 'details_en', 'TEXT NOT NULL');
  sql_move_field('irc_channels', 'details_fr', 'TEXT NOT NULL', 'details_en');
  sql_create_index('irc_channels', 'index_display_order', 'display_order');

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
  sql_rename_field('meetups', 'raison_fr', 'event_reason_fr', "VARCHAR(105) NOT NULL");
  sql_rename_field('meetups', 'raison_en', 'event_reason_en', "VARCHAR(105) NOT NULL");
  sql_move_field('meetups', 'event_reason_fr', 'VARCHAR(105) NOT NULL', 'event_reason_en');
  sql_rename_field('meetups', 'details_fr', 'details_fr', "MEDIUMTEXT NOT NULL");
  sql_rename_field('meetups', 'details_en', 'details_en', "MEDIUMTEXT NOT NULL");
  sql_move_field('meetups', 'details_fr', 'MEDIUMTEXT NOT NULL', 'details_en');

  sql_change_field_type('meetups_people', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('meetups_people', 'FKirl', 'fk_meetups', "INT UNSIGNED NOT NULL DEFAULT 0");
  sql_rename_field('meetups_people', 'FKmembres', 'fk_users', "INT UNSIGNED NOT NULL DEFAULT 0");
  sql_rename_field('meetups_people', 'pseudonyme', 'nickname', "VARCHAR(45) NOT NULL");
  sql_rename_field('meetups_people', 'confirme', 'attendance_confirmed', "TINYINT UNSIGNED NOT NULL DEFAULT 0");
  sql_rename_field('meetups_people', 'details_fr', 'extra_information_fr', "VARCHAR(510) NOT NULL");
  sql_rename_field('meetups_people', 'details_en', 'extra_information_en', "VARCHAR(510) NOT NULL");
  sql_move_field('meetups_people', 'extra_information_fr', 'VARCHAR(510) NOT NULL', 'extra_information_en');
  sql_delete_index('meetups_people', 'index_irl');
  sql_delete_index('meetups_people', 'index_membres');
  sql_create_index('meetups_people', 'index_meetup', 'fk_meetups');
  sql_create_index('meetups_people', 'index_people', 'fk_users');

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
// #544 - Translation and optimization of all tables - NBDB (NoBleme DataBase): encyclopedia of internet culture

if($last_query < 30)
{
  sql_rename_table('nbdb_web_notes_admin', 'nbdb_web_admin_notes');
  sql_rename_table('nbdb_web_categorie', 'nbdb_web_categories');
  sql_rename_table('nbdb_web_definition', 'nbdb_web_definitions');
  sql_rename_table('nbdb_web_periode', 'nbdb_web_eras');
  sql_rename_table('nbdb_web_image', 'nbdb_web_images');
  sql_rename_table('nbdb_web_page', 'nbdb_web_pages');
  sql_rename_table('nbdb_web_page_categorie', 'nbdb_web_pages_categories');

  sql_rename_field('nbdb_web_admin_notes', 'notes_admin', 'global_notes', 'LONGTEXT NOT NULL');
  sql_rename_field('nbdb_web_admin_notes', 'brouillon_fr', 'draft_fr', 'LONGTEXT NOT NULL');
  sql_rename_field('nbdb_web_admin_notes', 'brouillon_en', 'draft_en', 'LONGTEXT NOT NULL');
  sql_move_field('nbdb_web_admin_notes', 'draft_fr', 'LONGTEXT NOT NULL', 'draft_en');
  sql_rename_field('nbdb_web_admin_notes', 'template_global', 'snippets', 'LONGTEXT NOT NULL');
  sql_change_field_type('nbdb_web_admin_notes', 'template_fr', 'LONGTEXT NOT NULL');
  sql_change_field_type('nbdb_web_admin_notes', 'template_en', 'LONGTEXT NOT NULL');
  sql_move_field('nbdb_web_admin_notes', 'template_fr', 'LONGTEXT NOT NULL', 'template_en');

  sql_change_field_type('nbdb_web_categories', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('nbdb_web_categories', 'titre_fr', 'name_fr', 'VARCHAR(510) NOT NULL');
  sql_rename_field('nbdb_web_categories', 'titre_en', 'name_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('nbdb_web_categories', 'name_fr', 'VARCHAR(510) NOT NULL', 'name_en');
  sql_rename_field('nbdb_web_categories', 'ordre_affichage', 'display_order', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('nbdb_web_categories', 'display_order', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_rename_field('nbdb_web_categories', 'description_fr', 'description_fr', 'TEXT NOT NULL');
  sql_rename_field('nbdb_web_categories', 'description_en', 'description_en', 'TEXT NOT NULL');
  sql_move_field('nbdb_web_categories', 'description_fr', 'TEXT NOT NULL', 'description_en');
  sql_delete_index('nbdb_web_categories', 'index_ordre_affichage');
  sql_delete_index('nbdb_web_categories', 'index_description_fr');
  sql_delete_index('nbdb_web_categories', 'index_description_en');
  sql_create_index('nbdb_web_categories', 'index_display_order', 'display_order');

  sql_change_field_type('nbdb_web_definitions', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('nbdb_web_definitions', 'titre_fr', 'title_fr', 'VARCHAR(510) NOT NULL');
  sql_rename_field('nbdb_web_definitions', 'titre_en', 'title_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('nbdb_web_definitions', 'title_fr', 'VARCHAR(510) NOT NULL', 'title_en');
  sql_change_field_type('nbdb_web_definitions', 'redirection_fr', 'VARCHAR(510) NOT NULL');
  sql_change_field_type('nbdb_web_definitions', 'redirection_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('nbdb_web_definitions', 'redirection_fr', 'VARCHAR(510) NOT NULL', 'redirection_en');
  sql_rename_field('nbdb_web_definitions', 'definition_fr', 'definition_fr', 'LONGTEXT NOT NULL');
  sql_rename_field('nbdb_web_definitions', 'definition_en', 'definition_en', 'LONGTEXT NOT NULL');
  sql_rename_field('nbdb_web_definitions', 'contenu_floute', 'is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_definitions', 'est_vulgaire', 'is_gross', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_definitions', 'est_politise', 'is_political', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_definitions', 'est_incorrect', 'is_politically_incorrect', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('nbdb_web_definitions', 'definition_en', 'LONGTEXT NOT NULL', 'is_politically_incorrect');
  sql_move_field('nbdb_web_definitions', 'definition_fr', 'LONGTEXT NOT NULL', 'definition_en');
  sql_rename_field('nbdb_web_definitions', 'notes_admin', 'private_admin_notes', 'MEDIUMTEXT NOT NULL');
  sql_delete_index('nbdb_web_definitions', 'index_titre_fr');
  sql_delete_index('nbdb_web_definitions', 'index_titre_en');
  sql_delete_index('nbdb_web_definitions', 'index_definition_fr');
  sql_delete_index('nbdb_web_definitions', 'index_definition_en');
  sql_create_index('nbdb_web_definitions', 'index_title_en', 'title_en(255), redirection_en(255)', 1);
  sql_create_index('nbdb_web_definitions', 'index_title_fr', 'title_fr(255), redirection_fr(255)', 1);
  sql_create_index('nbdb_web_definitions', 'index_contents_en', 'definition_en', 1);
  sql_create_index('nbdb_web_definitions', 'index_contents_fr', 'definition_fr', 1);

  sql_change_field_type('nbdb_web_eras', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('nbdb_web_eras', 'titre_fr', 'name_fr', 'VARCHAR(510) NOT NULL');
  sql_rename_field('nbdb_web_eras', 'titre_en', 'name_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('nbdb_web_eras', 'name_fr', 'VARCHAR(510) NOT NULL', 'name_en');
  sql_rename_field('nbdb_web_eras', 'description_fr', 'description_fr', 'TEXT NOT NULL');
  sql_rename_field('nbdb_web_eras', 'description_en', 'description_en', 'TEXT NOT NULL');
  sql_move_field('nbdb_web_eras', 'description_fr', 'TEXT NOT NULL', 'description_en');
  sql_rename_field('nbdb_web_eras', 'annee_debut', 'began_in_year', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_eras', 'annee_fin', 'ended_in_year', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('nbdb_web_eras', 'began_in_year', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_move_field('nbdb_web_eras', 'ended_in_year', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0', 'began_in_year');

  sql_change_field_type('nbdb_web_images', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('nbdb_web_images', 'timestamp_upload', 'uploaded_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_images', 'nom_fichier', 'file_name', 'VARCHAR(510) NOT NULL');
  sql_change_field_type('nbdb_web_images', 'tags', 'TEXT NOT NULL');
  sql_rename_field('nbdb_web_images', 'nsfw', 'is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_images', 'pages_utilisation_fr', 'used_in_pages_fr', 'TEXT NOT NULL');
  sql_rename_field('nbdb_web_images', 'pages_utilisation_en', 'used_in_pages_en', 'TEXT NOT NULL');
  sql_move_field('nbdb_web_images', 'pages_utilisation_fr', 'TEXT NOT NULL', 'pages_utilisation_en');
  sql_create_index('nbdb_web_images', 'index_file_name', 'file_name', 1);
  sql_create_index('nbdb_web_images', 'index_tags', 'tags', 1);

  sql_change_field_type('nbdb_web_pages', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('nbdb_web_pages', 'FKnbdb_web_periode', 'fk_nbdb_web_eras', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'titre_fr', 'title_fr', 'VARCHAR(510) NOT NULL');
  sql_rename_field('nbdb_web_pages', 'titre_en', 'title_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('nbdb_web_pages', 'title_fr', 'VARCHAR(510) NOT NULL', 'title_en');
  sql_change_field_type('nbdb_web_pages', 'redirection_fr', 'VARCHAR(510) NOT NULL');
  sql_change_field_type('nbdb_web_pages', 'redirection_en', 'VARCHAR(510) NOT NULL');
  sql_move_field('nbdb_web_pages', 'redirection_fr', 'VARCHAR(510) NOT NULL', 'redirection_en');
  sql_rename_field('nbdb_web_pages', 'contenu_fr', 'definition_fr', 'LONGTEXT NOT NULL');
  sql_rename_field('nbdb_web_pages', 'contenu_en', 'definition_en', 'LONGTEXT NOT NULL');
  sql_rename_field('nbdb_web_pages', 'annee_apparition', 'appeared_in_year', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'mois_apparition', 'appeared_in_month', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'annee_popularisation', 'spread_in_year', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'mois_popularisation', 'spread_in_month', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'contenu_floute', 'is_nsfw', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'est_vulgaire', 'is_gross', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'est_politise', 'is_political', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages', 'est_incorrect', 'is_politically_incorrect', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('nbdb_web_pages', 'definition_en', 'LONGTEXT NOT NULL', 'is_politically_incorrect');
  sql_move_field('nbdb_web_pages', 'definition_fr', 'LONGTEXT NOT NULL', 'definition_en');
  sql_rename_field('nbdb_web_pages', 'notes_admin', 'private_admin_notes', 'MEDIUMTEXT NOT NULL');
  sql_delete_index('nbdb_web_pages', 'index_periode');
  sql_delete_index('nbdb_web_pages', 'index_apparition');
  sql_delete_index('nbdb_web_pages', 'index_popularisation');
  sql_delete_index('nbdb_web_pages', 'index_titre_fr');
  sql_delete_index('nbdb_web_pages', 'index_titre_en');
  sql_delete_index('nbdb_web_pages', 'index_contenu_en');
  sql_delete_index('nbdb_web_pages', 'index_contenu_fr');
  sql_create_index('nbdb_web_pages', 'index_era', 'fk_nbdb_web_eras');
  sql_create_index('nbdb_web_pages', 'index_appeared', 'appeared_in_year, appeared_in_month');
  sql_create_index('nbdb_web_pages', 'index_spread', 'spread_in_year, spread_in_month');
  sql_create_index('nbdb_web_pages', 'index_title_en', 'title_en(255), redirection_en(255)', 1);
  sql_create_index('nbdb_web_pages', 'index_title_fr', 'title_fr(255), redirection_fr(255)', 1);
  sql_create_index('nbdb_web_pages', 'index_contents_en', 'definition_en', 1);
  sql_create_index('nbdb_web_pages', 'index_contents_fr', 'definition_fr', 1);

  sql_change_field_type('nbdb_web_pages_categories', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('nbdb_web_pages_categories', 'FKnbdb_web_page', 'fk_nbdb_web_pages', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('nbdb_web_pages_categories', 'FKnbdb_web_categorie', 'fk_nbdb_web_categories', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('nbdb_web_pages_categories', 'index_pages');
  sql_create_index('nbdb_web_pages_categories', 'index_page', 'fk_nbdb_web_pages');
  sql_create_index('nbdb_web_pages_categories', 'index_category', 'fk_nbdb_web_categories');

  sql_update_query_id(30);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Translation of the contents of tables

if($last_query < 31)
{
  query(" UPDATE  system_scheduler
          SET     system_scheduler.task_type    = 'writers_contest_vote'
          WHERE   system_scheduler.task_type LIKE 'ecrivains_concours_vote' ");
  query(" UPDATE  system_scheduler
          SET     system_scheduler.task_type    = 'writers_contest_end'
          WHERE   system_scheduler.task_type LIKE 'ecrivains_concours_fin' ");

  query(" UPDATE  forum_threads
          SET     forum_threads.thread_format    = 'thread'
          WHERE   forum_threads.thread_format LIKE 'Fil' ");
  query(" UPDATE  forum_threads
          SET     forum_threads.thread_format    = 'thread_anonymous'
          WHERE   forum_threads.thread_format LIKE 'Anonyme' ");
  query(" UPDATE  forum_threads
          SET     forum_threads.thread_type    = 'standard'
          WHERE   forum_threads.thread_type LIKE 'Standard' ");
  query(" UPDATE  forum_threads
          SET     forum_threads.thread_type    = 'serious'
          WHERE   forum_threads.thread_type LIKE 'Sérieux' ");
  query(" UPDATE  forum_threads
          SET     forum_threads.thread_type    = 'debate'
          WHERE   forum_threads.thread_type LIKE 'Débat' ");
  query(" UPDATE  forum_threads
          SET     forum_threads.thread_type    = 'game'
          WHERE   forum_threads.thread_type LIKE 'Jeu' ");

  $logs_activity_language = array(    'version'                         => 'ENFR' ,
                                      'devblog'                         => 'ENFR' ,
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
                                      'forum_new'                       => 'ENFR' ,
                                      'forum_edit'                      => 'ENFR' ,
                                      'forum_delete'                    => 'ENFR' ,
                                      'forum_new_message'               => 'ENFR' ,
                                      'forum_edit_message'              => 'ENFR' ,
                                      'forum_delete_message'            => 'ENFR' ,
                                      'irl_new'                         => 'ENFR' ,
                                      'irl_edit'                        => 'ENFR' ,
                                      'irl_delete'                      => 'ENFR' ,
                                      'irl_add_participant'             => 'ENFR' ,
                                      'irl_edit_participant'            => 'ENFR' ,
                                      'irl_del_participant'             => 'ENFR' ,
                                      'ecrivains_new'                   => 'FR'   ,
                                      'ecrivains_edit'                  => 'FR'   ,
                                      'ecrivains_delete'                => 'FR'   ,
                                      'ecrivains_reaction_new'          => 'FR'   ,
                                      'ecrivains_reaction_new_anonyme'  => 'FR'   ,
                                      'ecrivains_reaction_delete'       => 'FR'   ,
                                      'ecrivains_concours_new'          => 'FR'   ,
                                      'ecrivains_concours_gagnant'      => 'FR'   ,
                                      'ecrivains_concours_vote'         => 'FR'   ,
                                      'quote_new_en'                    => 'ENFR' ,
                                      'quote_new_fr'                    => 'FR'   ,
                                      'nbdb_web_definition_new'         => 'ENFR' ,
                                      'nbdb_web_definition_edit'        => 'ENFR' ,
                                      'nbdb_web_definition_delete'      => 'ENFR' ,
                                      'nbdb_web_page_new'               => 'ENFR' ,
                                      'nbdb_web_page_edit'              => 'ENFR' ,
                                      'nbdb_web_page_delete'            => 'ENFR' );

  foreach($logs_activity_language as $original_log => $log_language)
  {
    $original_log   = sanitize($original_log, 'string');
    $log_language   = sanitize($log_language, 'string');
    query(" UPDATE  logs_activity
            SET     logs_activity.language         = '$log_language'
            WHERE   logs_activity.activity_type LIKE '$original_log' ");
  }

  $logs_activity_translation = array( 'version'                         => 'dev_version'                        ,
                                      'devblog'                         => 'dev_blog'                           ,
                                      'todo_new'                        => 'dev_task_new'                       ,
                                      'todo_fini'                       => 'dev_task_finished'                  ,
                                      'register'                        => 'users_register'                     ,
                                      'profil'                          => 'users_profile_edit'                 ,
                                      'profil_edit'                     => 'users_admin_edit_profile'           ,
                                      'editpass'                        => 'users_admin_edit_password'          ,
                                      'ban'                             => 'users_banned'                       ,
                                      'deban'                           => 'users_unbanned'                     ,
                                      'droits_delete'                   => 'users_rights_delete'                ,
                                      'droits_mod'                      => 'users_rights_moderator'             ,
                                      'droits_sysop'                    => 'users_rights_global_moderator'      ,
                                      'forum_new'                       => 'forum_thread_new'                   ,
                                      'forum_edit'                      => 'forum_thread_edit'                  ,
                                      'forum_delete'                    => 'forum_thread_delete'                ,
                                      'forum_new_message'               => 'forum_message_new'                  ,
                                      'forum_edit_message'              => 'forum_message_edit'                 ,
                                      'forum_delete_message'            => 'forum_message_delete'               ,
                                      'irl_new'                         => 'meetups_new'                        ,
                                      'irl_edit'                        => 'meetups_edit'                       ,
                                      'irl_delete'                      => 'meetups_delete'                     ,
                                      'irl_add_participant'             => 'meetups_people_new'                 ,
                                      'irl_edit_participant'            => 'meetups_people_edit'                ,
                                      'irl_del_participant'             => 'meetups_people_delete'              ,
                                      'ecrivains_new'                   => 'writings_text_new_fr'               ,
                                      'ecrivains_edit'                  => 'writings_text_edit_fr'              ,
                                      'ecrivains_delete'                => 'writings_text_delete'               ,
                                      'ecrivains_reaction_new'          => 'writings_comment_new_fr'            ,
                                      'ecrivains_reaction_new_anonyme'  => 'writings_comment_new_anonymous_fr'  ,
                                      'ecrivains_reaction_delete'       => 'writings_comment_delete'            ,
                                      'ecrivains_concours_new'          => 'writings_contest_new_fr'            ,
                                      'ecrivains_concours_gagnant'      => 'writings_contest_winner_fr'         ,
                                      'ecrivains_concours_vote'         => 'writings_contest_vote_fr'           ,
                                      'quote_new_en'                    => 'quotes_new_en'                      ,
                                      'quote_new_fr'                    => 'quotes_new_fr'                      );

  foreach($logs_activity_translation as $original_log => $translated_log)
  {
    $original_log   = sanitize($original_log, 'string');
    $translated_log = sanitize($translated_log, 'string');
    query(" UPDATE  logs_activity
            SET     logs_activity.activity_type    = '$translated_log'
            WHERE   logs_activity.activity_type LIKE '$original_log' ");
  }

  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_en = REPLACE(nbdb_web_pages.definition_en, '[[dico:', '[[definition:') ");
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_fr = REPLACE(nbdb_web_pages.definition_fr, '[[dico:', '[[definition:') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_en = REPLACE(nbdb_web_definitions.definition_en, '[[dico:', '[[definition:') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_fr = REPLACE(nbdb_web_definitions.definition_fr, '[[dico:', '[[definition:') ");
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_en = REPLACE(nbdb_web_pages.definition_en, '[[lien:', '[[link:') ");
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_fr = REPLACE(nbdb_web_pages.definition_fr, '[[lien:', '[[link:') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_en = REPLACE(nbdb_web_definitions.definition_en, '[[lien:', '[[link:') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_fr = REPLACE(nbdb_web_definitions.definition_fr, '[[lien:', '[[link:') ");
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_en = REPLACE(nbdb_web_pages.definition_en, '[[galerie', '[[gallery') ");
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_fr = REPLACE(nbdb_web_pages.definition_fr, '[[galerie', '[[gallery') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_en = REPLACE(nbdb_web_definitions.definition_en, '[[galerie', '[[gallery') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_fr = REPLACE(nbdb_web_definitions.definition_fr, '[[galerie', '[[gallery') ");
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_en = REPLACE(nbdb_web_pages.definition_en, '/galerie]]', '/gallery]]') ");
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.definition_fr = REPLACE(nbdb_web_pages.definition_fr, '/galerie]]', '/gallery]]') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_en = REPLACE(nbdb_web_definitions.definition_en, '/galerie]]', '/gallery]]') ");
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.definition_fr = REPLACE(nbdb_web_definitions.definition_fr, '/galerie]]', '/gallery]]') ");

  sql_update_query_id(31);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Add soft deletion capacity to most website elements

if($last_query < 32)
{
  sql_create_field('dev_blogs', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('dev_tasks', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_delete_field('forum_messages', 'deleted_message');
  sql_create_field('forum_messages', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('forum_threads', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_create_field('logs_activity', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_create_field('meetups', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_create_field('nbdb_web_definitions', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('nbdb_web_images', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('nbdb_web_pages', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_create_field('quotes', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_create_field('users', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('users_private_messages', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_create_field('writings_comments', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('writings_contests', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('writings_texts', 'deleted', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_update_query_id(32);
}