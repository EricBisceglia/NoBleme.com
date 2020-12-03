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
/*                 Before version 3, query history was not recorded, hence the lack of older content                 */
/*                Before version 4, table and field names were in french, hence the non-english stuff                */
/*                                                                                                                   */
/*      Do not add content to this page, it is an archive. Add content to the bottom of queries.inc.php instead.     */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 VERSION 3 BUILD 5                                                 */
/*                                                                                                                   */
/**********************************************************************************************************************
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
/**********************************************************************************************************************
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
/**********************************************************************************************************************
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
/**********************************************************************************************************************
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
/**********************************************************************************************************************
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

*/