<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                             THIS PAGE CAN NOT BE RAN                                              */
/*                                                                                                                   */
// Kill the script /**************************************************************************************************/
die();

/*********************************************************************************************************************/
/*                                                                                                                   */
/*      This page contains an archive of older SQL queries that have be ran during past updates of the website.      */
/*           It is purged of older queries every once in a while, only relevant recent changes are stored.           */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       4.0.x                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add a type and a priority to compendium missing pages

if($last_query < 34)
{
  sql_create_field('compendium_missing', 'fk_compendium_types', 'INT UNSIGNED NOT NULL DEFAULT 0', 'id');
  sql_create_field('compendium_missing', 'is_a_priority', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'title');
  sql_update_query_id(34);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       4.1.x                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Store a copy of the page count in compendium pages and images

if($last_query < 35)
{
  sql_create_field('compendium_pages', 'view_count', 'INT UNSIGNED NOT NULL DEFAULT 0', 'redirection_fr');
  sql_create_field('compendium_images', 'view_count', 'INT UNSIGNED NOT NULL DEFAULT 0', 'tags');
  sql_update_query_id(35);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       4.3.x                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Store quotes stats in the database

if($last_query < 36)
{
  sql_create_field('users_stats', 'quotes', 'INT UNSIGNED NOT NULL DEFAULT 0', 'fk_users');
  sql_create_field('users_stats', 'quotes_en', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes');
  sql_create_field('users_stats', 'quotes_fr', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_en');
  sql_create_field('users_stats', 'quotes_nsfw', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_fr');
  sql_create_field('users_stats', 'quotes_oldest_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_nsfw');
  sql_create_field('users_stats', 'quotes_oldest_date', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_oldest_id');
  sql_create_field('users_stats', 'quotes_newest_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_oldest_date');
  sql_create_field('users_stats', 'quotes_newest_date', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_newest_id');
  sql_create_field('users_stats', 'quotes_submitted', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_newest_date');
  sql_create_field('users_stats', 'quotes_approved', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_submitted');

  sql_create_index('users_stats', 'index_quotes', 'quotes');
  sql_create_index('users_stats', 'index_quotes_approved', 'quotes_approved');

  sql_update_query_id(36);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Store meetups stats in the database

if($last_query < 37)
{
  sql_create_field('users_stats', 'meetups', 'INT UNSIGNED NOT NULL DEFAULT 0', 'quotes_approved');
  sql_create_field('users_stats', 'meetups_en', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups');
  sql_create_field('users_stats', 'meetups_fr', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups_en');
  sql_create_field('users_stats', 'meetups_bilingual', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups_fr');
  sql_create_field('users_stats', 'meetups_oldest_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups_bilingual');
  sql_create_field('users_stats', 'meetups_oldest_date', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups_oldest_id');
  sql_create_field('users_stats', 'meetups_newest_id', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups_oldest_date');
  sql_create_field('users_stats', 'meetups_newest_date', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups_newest_id');

  sql_create_index('users_stats', 'index_meetups', 'meetups');

  sql_update_query_id(37);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Store tasks stats in the database

if($last_query < 38)
{
  sql_create_field('users_stats', 'tasks_submitted', 'INT UNSIGNED NOT NULL DEFAULT 0', 'meetups_newest_date');
  sql_create_field('users_stats', 'tasks_solved', 'INT UNSIGNED NOT NULL DEFAULT 0', 'tasks_submitted');

  sql_create_index('users_stats', 'index_tasks_submitted', 'tasks_submitted');

  sql_update_query_id(38);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Compendium: Redirect to non-compendium URLs

if($last_query < 39)
{
  sql_create_field('compendium_pages', 'is_external_redirection', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'redirection_fr');

  sql_update_query_id(39);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Rework system variables

if($last_query < 40)
{
  sql_create_field('system_variables', 'registrations_are_closed', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'last_pageview_check');

  sql_rename_field('system_variables', 'update_in_progress', 'website_is_closed', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');

  sql_change_field_type('system_variables', 'irc_bot_is_silenced', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
  sql_change_field_type('system_variables', 'discord_is_silenced', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');

  sql_update_query_id(40);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tasks: Deactivate older categories and milestones

if($last_query < 41)
{
  sql_create_field('dev_tasks_categories', 'is_archived', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_create_field('dev_tasks_milestones', 'is_archived', 'TINYINT UNSIGNED NOT NULL DEFAULT 0', 'id');

  sql_update_query_id(41);
}