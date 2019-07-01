<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                      THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                                      */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { header("Location: ./../pages/nobleme/404") ; die(); }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// This page contains all SQL queries that will be ran during an update of the website
// It can only be called by a website admin through the page /pages/dev/requetes
// A bunch of functions for manipulating SQL are included in this page, making it a proto-ORM of sorts
// Queries are done in such a way that they can only be ran once, avoiding needless strain on the database or queries overwriting eachother




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                 FUNCTIONS USED FOR STRUCTURAL QUERIES                                                 */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/*               These functions allow for "safe" manipulation of the database, and should only be used within this file.                */
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/* sql_check_query_id();                                                                                                                 */
/* sql_update_query_id($id);                                                                                                             */
/*                                                                                                                                       */
/* sql_create_table($table_name);                                                                                                        */
/* sql_rename_table($table_name, $new_name);                                                                                             */
/* sql_empty_table($table_name);                                                                                                         */
/* sql_delete_table($table_name);                                                                                                        */
/*                                                                                                                                       */
/* sql_create_field($table_name, $field_name, $field_type, $after_field_name);                                                           */
/* sql_rename_field($table_name, $old_field_name, $new_field_name, $field_type);                                                         */
/* sql_change_field_type($table_name, $field_name, $field_type)                                                                          */
/* sql_move_field($table_name, $field_name, $field_type, $after_field_name)                                                              */
/* sql_delete_field($table_name, $field_name);                                                                                           */
/*                                                                                                                                       */
/* sql_create_index($table_name, $index_name, $field_names, $fulltext);                                                                  */
/* sql_delete_index($table_name, $index_name);                                                                                           */
/*                                                                                                                                       */
/* sql_insert_value($condition, $query);                                                                                                 */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Checks whether a query should be ran or not
//
// Example: if(sql_check_query_id() < 10) { run_query(); }

function sql_check_query_id()
{
  // As the name of the global variables table has been changed, we need to check everything twice
  $query_ok     = 0;
  $query_ok_old = 0;

  // We proceed only if the table exists
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
  {
    $query_ok     = ($dtablelist[0] == 'system_variables')  ? 1 : $query_ok;
    $query_ok_old = ($dtablelist[0] == 'vars_globales')     ? 1 : $query_ok_old;
  }
  if(!$query_ok && !$query_ok_old)
    return 0;

  // If it does exist, then we need its structure
  if($query_ok)
    $qdescribe = query(" DESCRIBE system_variables ");
  else
    $qdescribe = query(" DESCRIBE vars_globales ");

  // We proceed only if the field exists
  $field_exists = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($query_ok)
      $field_exists = ($ddescribe['Field'] != "latest_query_id") ? 1 : $field_exists;
    else
      $field_exists = ($ddescribe['Field'] != "derniere_requete_sql") ? 1 : $field_exists;
  }

  // If we aren't allowed to run this query, we abort here
  if(!$field_exists)
    return 0;

  // We are now allowed to fetch the id of the last query that was ran
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

  // We return that id
  return $last_query['latest_query_id'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Updates the id of the last query that was ran
//
// Example: sql_update_query_id(69);

function sql_update_query_id($id)
{
  // As the name of the global variables table has been changed, we need to check everything twice
  $query_ok     = 0;
  $query_ok_old = 0;

  // We proceed only if the table exists
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
  {
    $query_ok     = ($dtablelist[0] == 'system_variables')  ? 1 : $query_ok;
    $query_ok_old = ($dtablelist[0] == 'vars_globales')     ? 1 : $query_ok_old;
  }
  if(!$query_ok && !$query_ok_old)
    return 0;

  // If it does exist, then we need its structure
  if($query_ok)
    $qdescribe = query(" DESCRIBE system_variables");
  else
    $qdescribe = query(" DESCRIBE vars_globales");

  // We proceed only if the field exists
  $field_exists = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($query_ok)
      $field_exists = ($ddescribe['Field'] != "latest_query_id") ? 1 : $field_exists;
    else
      $field_exists = ($ddescribe['Field'] != "derniere_requete_sql") ? 1 : $field_exists;
  }

  // If we aren't allowed to run this query, we abort here
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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Creates a new table which will only contain one field called "id", an auto incremented primary key
//
// Example: sql_create_table("my_table");

function sql_create_table($table_name)
{
  return query(" CREATE TABLE IF NOT EXISTS ".$table_name." ( id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM;");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renames an existing table
//
// Example: sql_rename_table("table_name", "new_name");

function sql_rename_table($table_name, $new_name)
{
  // We proceed only if the table exists and the new table name is not taken
  $query_old_ok = 0;
  $query_new_ok = 1;
  $qtablelist   = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
  {
    $query_old_ok = ($dtablelist[0] == $table_name) ? 1 : $query_old_ok;
    $query_new_ok = ($dtablelist[0] == $new_name)   ? 0 : $query_new_ok;
  }
  if(!$query_old_ok || !$query_new_ok)
    return 0;

  // We can now rename the table
  query(" ALTER TABLE $table_name RENAME $new_name ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Gets rid of all the data in an existing table
//
// Example: sql_empty_table("table_name");

function sql_empty_table($table_name)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We can now purge the table's contents
  query(" TRUNCATE TABLE ".$table_name);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Deletes an existing table
//
// Example: sql_delete_table("table_name");

function sql_delete_table($table_name)
{
  query(" DROP TABLE IF EXISTS ".$table_name);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Creates a new field in an existing table
//
// Example: sql_create_field("my_table", "my_field", "INT(11) UNSIGNED NOT NULL", "some_existing_field");

function sql_create_field($table_name, $field_name, $field_type, $after_field_name)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We need to fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // We proceed only if the preceeding field exists
  $query_ok = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $query_ok = ($ddescribe['Field'] == $after_field_name) ? 1 : $query_ok;
  if(!$query_ok)
    return;

  // We need to fetch the table's structure yet again
  $qdescribe = query(" DESCRIBE ".$table_name);

  // We proceed only if the field doesn't already exist
  $query_ko = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $query_ko = ($ddescribe['Field'] == $field_name) ? 1 : $query_ko;
  if($query_ko)
    return;

  // We can now run the query
  query(" ALTER TABLE ".$table_name." ADD ".$field_name." ".$field_type." AFTER ".$after_field_name);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renames an existng field in an existing table
//
// Example: sql_rename_field("my_table", "old_name", "new_name", "MEDIUMTEXT");

function sql_rename_field($table_name, $old_field_name, $new_field_name, $field_type)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We need to fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // We continue only if the new field name doesn't exist
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if ($ddescribe['Field'] == $new_field_name)
      return;
  }

  // We need to fetch the table's structure yet again
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, we rename it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $old_field_name)
      query(" ALTER TABLE ".$table_name." CHANGE ".$old_field_name." ".$new_field_name." ".$field_type);
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Changes the type of an existing field in an existing table
//
// Example: sql_change_field_type("my_table", "my_field", "MEDIUMTEXT");

function sql_change_field_type($table_name, $field_name, $field_type)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We need to fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, we rename it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $field_name)
      query(" ALTER TABLE ".$table_name." MODIFY ".$field_name." ".$field_type);
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Moves an existing field after another existing field in an existing table
//
// Example: sql_empty_table("table_name");

function sql_move_field($table_name, $field_name, $field_type, $after_field_name)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We need to fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // We continue only if both of the field names actually exist
  $field_ok       = 0;
  $field_after_ok = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    $field_ok       = ($ddescribe['Field'] == $field_name)        ? 1 : $field_ok;
    $field_after_ok = ($ddescribe['Field'] == $after_field_name)  ? 1 : $field_after_ok;
  }
  if(!$field_ok || !$field_after_ok)
    return;

  // We can now move the field
  query(" ALTER TABLE ".$table_name." MODIFY COLUMN ".$field_name." ".$field_type." AFTER ".$after_field_name);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Deletes an existing field in an existing table
//
// Example: sql_delete_field("my_table", "my_field");

function sql_delete_field($table_name, $field_name)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We need to fetch the table's structure
  $qdescribe = query(" DESCRIBE ".$table_name);

  // If the field exists in the table, we delete it
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $field_name)
      query(" ALTER TABLE ".$table_name." DROP ".$field_name);
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Creates an index in an existing table
//
// $field_names             can be one or multiple field names, contained in a string (example "my_field" or "my_field, my_other_field")
// $fulltext    (optional)  makes it a fulltext index if any value is entered for this option
//
// Example: sql_create_index("my_table", "index_name", "field_name, other_field_name(10)")

function sql_create_index($table_name, $index_name, $field_names, $fulltext=NULL)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We check whether the index already exists
  $qindex = query(" SHOW INDEX FROM ".$table_name." WHERE key_name LIKE '".$index_name."' ");

  // If it does not exist yet, then we can create it, and run a check to populate the indexes
  if(!mysqli_num_rows($qindex))
  {
    $temp_fulltext = ($fulltext) ? ' FULLTEXT ' : '';
    query(" ALTER TABLE ".$table_name."
            ADD ".$temp_fulltext." INDEX ".$index_name." (".$field_names."); ");
    query(" CHECK TABLE ".$table_name." ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Deletes an existing index in an existing table
//
// Example: sql_delete_index("my_table", "my_index")

function sql_delete_index($table_name, $index_name)
{
  // We proceed only if the table exists
  $query_ok   = 0;
  $qtablelist = query(" SHOW TABLES ");
  while($dtablelist = mysqli_fetch_array($qtablelist))
    $query_ok = ($dtablelist[0] == $table_name) ? 1 : $query_ok;
  if(!$query_ok)
    return 0;

  // We check whether the index already exists
  $qindex = query(" SHOW INDEX FROM ".$table_name." WHERE key_name LIKE '".$index_name."' ");

  // If it exists, we delete it, and run a check to depopulate the indexes
  if(mysqli_num_rows($qindex))
  {
    query(" ALTER TABLE ".$table_name."
            DROP INDEX ".$index_name );
    query(" CHECK TABLE ".$table_name." ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inserts a value in an existing table
//
// $condition   is a query to check whether the field already exists
// $query       is the query to be run to insert the value
//
/* Example:
sql_insert_value(" SELECT my_string, my_int FROM my_table WHERE my_string LIKE 'test' AND my_int = 1 ",
" INSERT INTO my_table
  SET         my_string = 'test'  ,
              my_int    = 1       ");
*/

function sql_insert_value($condition, $query)
{
  // If the condition is met, we run the query
  if(!mysqli_num_rows(query($condition)))
    query($query);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             QUERY HISTORY                                                             */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                    Allows replaying of all past queries that haven't been run yet                                     */
/*                        in order to ensure a version upgrade between any two versions of NoBleme goes smoothly                         */
/*                                                                                                                                       */
/*                           Before version 3, query history was not recorded, hence the lack of older content                           */
/*                          Before version 4, table and field names were in french, hence the non-english stuff                          */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
// Global requirement: fetch the id of the last query that was run

$last_query = sql_check_query_id();



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 5                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 6                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Internet culture page categories

if($last_query < 9)
{
  sql_create_table('nbdb_web_page_categorie');

  sql_create_field('nbdb_web_page_categorie', 'FKnbdb_web_page', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_create_field('nbdb_web_page_categorie', 'FKnbdb_web_categorie', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_page');

  sql_create_index('nbdb_web_page_categorie', 'index_pages', 'FKnbdb_web_page, FKnbdb_web_categorie');

  sql_update_query_id(9);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// New table: NBDB - Internet culture images

if($last_query < 10)
{
  sql_create_table('nbdb_web_image');

  sql_create_field('nbdb_web_image', 'timestamp_upload', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_create_field('nbdb_web_image', 'nom_fichier', 'MEDIUMTEXT', 'timestamp_upload');
  sql_create_field('nbdb_web_image', 'tags', 'MEDIUMTEXT', 'nom_fichier');

  sql_update_query_id(10);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 7                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
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



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Store latest user activity

if($last_query < 12)
{
  sql_create_field('membres', 'derniere_activite', 'INT(11) UNSIGNED NOT NULL', 'derniere_visite_ip');

  sql_update_query_id(12);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 8                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
// #496 - Option to turn off google trends

if($last_query < 13)
{
  sql_create_field('membres', 'voir_tweets', 'TINYINT(1)', 'voir_nsfw');
  sql_create_field('membres', 'voir_youtube', 'TINYINT(1)', 'voir_tweets');
  sql_create_field('membres', 'voir_google_trends', 'TINYINT(1)', 'voir_youtube');

  sql_update_query_id(13);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #477 - Allow tagging of internet culture encyclopedia/dictionary content as NSFW

if($last_query < 14)
{
  sql_create_field('nbdb_web_page', 'contenu_floute', 'TINYINT(1)', 'mois_popularisation');
  sql_create_field('nbdb_web_definition', 'contenu_floute', 'TINYINT(1)', 'definition_en');
  sql_create_field('nbdb_web_image', 'nsfw', 'TINYINT(1)', 'tags');

  sql_update_query_id(14);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 9                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #543 - SQL query history (this page!)

if($last_query < 16)
{
  sql_create_field("vars_globales", "derniere_requete_sql", "TINYINT(1) NOT NULL", "mise_a_jour");

  sql_update_query_id(16);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #533 - Internet culture encyclopedia private comments do not need an id

if($last_query < 17)
{
  sql_delete_field("nbdb_web_notes_admin", "id");

  sql_update_query_id(17);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #547 - Private templates for the internet culture encyclopedia

if($last_query < 18)
{
  sql_create_field("nbdb_web_notes_admin", "template_global", "LONGTEXT", "brouillon_en");
  sql_create_field("nbdb_web_notes_admin", "template_fr", "LONGTEXT", "template_global");
  sql_create_field("nbdb_web_notes_admin", "template_en", "LONGTEXT", "template_fr");

  sql_update_query_id(18);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 4 BUILD 1                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - System tables

if($last_query < 20)
{
  sql_rename_table('automatisation', 'system_scheduler');
  sql_rename_table('vars_globales', 'system_variables');
  sql_rename_table('version', 'system_versions');

  sql_change_field_type('system_scheduler', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('system_scheduler', 'action_id', 'task_id', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('system_scheduler', 'action_type', 'task_type', 'VARCHAR(40) DEFAULT NULL');
  sql_rename_field('system_scheduler', 'action_description', 'task_description', 'TEXT DEFAULT NULL');
  sql_rename_field('system_scheduler', 'action_timestamp', 'task_timestamp', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('system_scheduler', 'task_timestamp', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_delete_index('system_scheduler', 'index_action');
  sql_create_index('system_scheduler', 'index_task_id', 'task_id');

  sql_rename_field('system_variables', 'mise_a_jour', 'update_in_progress', 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
  sql_rename_field('system_variables', 'derniere_requete_sql', 'latest_query_id', 'SMALLINT UNSIGNED NOT NULL DEFAULT 0');
  sql_change_field_type('system_variables', 'last_pageview_check', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('system_variables', 'mise_a_jour');

  sql_change_field_type('system_versions', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_change_field_type('system_versions', 'version', 'VARCHAR(20) DEFAULT NULL');
  sql_change_field_type('system_versions', 'build', 'VARCHAR(10) DEFAULT NULL');
  sql_create_index('system_versions', 'index_full_version', 'version, build');

  sql_update_query_id(20);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Log tables

if($last_query < 21)
{
  sql_rename_table('activite', 'logs_activity');
  sql_rename_table('activite_diff', 'logs_activity_archives');

  sql_change_field_type('logs_activity', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('logs_activity', 'timestamp', 'happened_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('logs_activity', 'log_moderation', 'is_moderators_only', 'TINYINT NOT NULL DEFAULT 0');
  sql_rename_field('logs_activity', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('logs_activity', 'pseudonyme', 'nickname', 'VARCHAR(45) DEFAULT NULL');
  sql_rename_field('logs_activity', 'action_type', 'activity_type', 'VARCHAR(40) DEFAULT NULL');
  sql_rename_field('logs_activity', 'action_id', 'activity_id', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('logs_activity', 'activity_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'nickname');
  sql_rename_field('logs_activity', 'action_titre', 'activity_summary', 'TEXT DEFAULT NULL');
  sql_rename_field('logs_activity', 'parent', 'activity_parent', 'TEXT DEFAULT NULL');
  sql_rename_field('logs_activity', 'justification', 'moderation_reason', 'TEXT DEFAULT NULL');
  sql_delete_index('logs_activity', 'index_membres');
  sql_delete_index('logs_activity', 'index_action');
  sql_delete_index('logs_activity', 'index_type');
  sql_create_index('logs_activity', 'index_related_users', 'fk_users');
  sql_create_index('logs_activity', 'index_related_foreign_keys', 'activity_id');
  sql_create_index('logs_activity', 'index_activity_type', 'activity_type(40)');

  sql_change_field_type('logs_activity_archives', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('logs_activity_archives', 'FKactivite', 'fk_logs_activity', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('logs_activity_archives', 'titre_diff', 'content_description', 'TEXT DEFAULT NULL');
  sql_rename_field('logs_activity_archives', 'diff_avant', 'content_before', 'MEDIUMTEXT DEFAULT NULL');
  sql_rename_field('logs_activity_archives', 'diff_apres', 'content_after', 'MEDIUMTEXT DEFAULT NULL');
  sql_delete_index('logs_activity_archives', 'index_activite');
  sql_create_index('logs_activity_archives', 'index_logs_activity', 'fk_logs_activity');

  sql_update_query_id(21);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Stats tables

if($last_query < 22)
{
  sql_rename_table('pageviews', 'stats_pageviews');

  sql_change_field_type('stats_pageviews', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('stats_pageviews', 'nom_page', 'page_name', 'VARCHAR(255) DEFAULT NULL');
  sql_rename_field('stats_pageviews', 'url_page', 'page_url', 'TEXT DEFAULT NULL');
  sql_rename_field('stats_pageviews', 'vues', 'view_count', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('stats_pageviews', 'vues_lastvisit', 'view_count_archive', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_delete_index('stats_pageviews', 'index_tri');
  sql_delete_index('stats_pageviews', 'index_recherche');
  sql_create_index('stats_pageviews', 'index_view_count_stats', 'view_count, view_count_archive');

  sql_update_query_id(22);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #544 - Translation and optimization of all tables - Dev tables

if($last_query < 23)
{
  sql_rename_table('devblog', 'dev_blog');
  sql_rename_table('todo', 'dev_todo');
  sql_rename_table('todo_categorie', 'dev_todo_categories');
  sql_rename_table('todo_roadmap', 'dev_todo_milestones');

  sql_change_field_type('dev_blog', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_blog', 'timestamp', 'posted_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('dev_blog', 'titre', 'title', 'VARCHAR(255)');
  sql_rename_field('dev_blog', 'contenu', 'body', 'LONGTEXT NOT NULL');

  sql_change_field_type('dev_todo', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_todo', 'FKmembres', 'fk_users', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('dev_todo', 'timestamp', 'created_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('dev_todo', 'importance', 'priority_level', 'TINYINT UNSIGNED NOt NULL DEFAULT 0');
  sql_rename_field('dev_todo', 'titre_fr', 'title_fr', 'TEXT NOT NULL');
  sql_rename_field('dev_todo', 'titre_en', 'title_en', 'TEXT NOT NULL');
  sql_rename_field('dev_todo', 'contenu_fr', 'body_fr', 'TEXT NOT NULL');
  sql_rename_field('dev_todo', 'contenu_en', 'body_en', 'TEXT NOT NULL');
  sql_rename_field('dev_todo', 'FKtodo_categorie', 'fk_dev_todo_categories', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_todo', 'fk_dev_todo_categories', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  sql_rename_field('dev_todo', 'FKtodo_roadmap', 'fk_dev_todo_milestones', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_todo', 'fk_dev_todo_milestones', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_dev_todo_categories');
  sql_rename_field('dev_todo', 'timestamp_fini', 'finished_at', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_todo', 'finished_at', 'INT UNSIGNED NOT NULL DEFAULT 0', 'created_at');
  sql_rename_field('dev_todo', 'valide_admin', 'admin_validation', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_todo', 'admin_validation', 'INT UNSIGNED NOT NULL DEFAULT 0', 'finished_at');
  sql_rename_field('dev_todo', 'public', 'is_public', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_move_field('dev_todo', 'is_public', 'INT UNSIGNED NOT NULL DEFAULT 0', 'admin_validation');
  sql_rename_field('dev_todo', 'source', 'source_code_link', 'TEXT NOT NULL');
  sql_delete_index('dev_todo', 'index_membres');
  sql_delete_index('dev_todo', 'index_categorie');
  sql_delete_index('dev_todo', 'index_roadmap');
  sql_delete_index('dev_todo', 'index_titre_en');
  sql_delete_index('dev_todo', 'index_titre_fr');
  sql_create_index('dev_todo', 'index_authors', 'fk_users');
  sql_create_index('dev_todo', 'index_categories', 'fk_dev_todo_categories');
  sql_create_index('dev_todo', 'index_milestones', 'fk_dev_todo_milestones');
  sql_create_index('dev_todo', 'index_title_fr', 'title_fr', 1);
  sql_create_index('dev_todo', 'index_title_en', 'title_en', 1);

  sql_change_field_type('dev_todo_categories', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_todo_categories', 'titre_fr', 'title_fr', 'VARCHAR(255) NOT NULL');
  sql_rename_field('dev_todo_categories', 'titre_en', 'title_en', 'VARCHAR(255) NOT NULL');

  sql_change_field_type('dev_todo_milestones', 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT');
  sql_rename_field('dev_todo_milestones', 'id_classement', 'sorting_order', 'INT UNSIGNED NOT NULL DEFAULT 0');
  sql_rename_field('dev_todo_milestones', 'version_fr', 'title_fr', 'TEXT NOT NULL');
  sql_rename_field('dev_todo_milestones', 'version_en', 'title_en', 'TEXT NOT NULL');
  sql_rename_field('dev_todo_milestones', 'description_fr', 'summary_fr', 'MEDIUMTEXT NOT NULL');
  sql_rename_field('dev_todo_milestones', 'description_en', 'summary_en', 'MEDIUMTEXT NOT NULL');
  sql_delete_index('dev_todo_milestones', 'index_classement');
  sql_create_index('dev_todo_milestones', 'index_sorting_order', 'sorting_order');

  sql_update_query_id(23);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                                       //
//                     !!!!! REMEMBER TO UPDATE SQLDUMP.SQL AT THE PROJECT ROOT AFTER EVERY STRUCTURAL CHANGE !!!!!                      //
//                                                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
exit('<br>-----<br>Done -> '.$last_query);