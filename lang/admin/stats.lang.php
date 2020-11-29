<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      METRICS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Metrics: Reset
___('admin_metrics_reset',          'EN', "Reset all metrics");
___('admin_metrics_reset',          'FR', "Remise à zéro<br>des indicateurs");
___('admin_metrics_reset_warning',  'EN', "Confirm the irreversible deletion of every current metric");
___('admin_metrics_reset_warning',  'FR', "Confirmer la suppression irréversible de tous les indicateurs actuels");


// Metrics: Table
___('admin_metrics_queries',        'EN', "Queries");
___('admin_metrics_queries',        'FR', "Requêtes");
___('admin_metrics_load',           'EN', "Load");
___('admin_metrics_load',           'FR', "Charge");
___('admin_metrics_minimum',        'EN', "Minimum");
___('admin_metrics_minimum',        'FR', "Minimum");
___('admin_metrics_target',         'EN', "Target");
___('admin_metrics_target',         'FR', "Objectif");
___('admin_metrics_average',        'EN', "Average");
___('admin_metrics_average',        'FR', "Moyenne");
___('admin_metrics_warning',        'EN', "Warning");
___('admin_metrics_warning',        'FR', "Attention");
___('admin_metrics_bad',            'EN', "Bad");
___('admin_metrics_bad',            'FR', "Mauvais");
___('admin_metrics_maximum',        'EN', "Maximum");
___('admin_metrics_maximum',        'FR', "Maximum");
___('admin_metrics_page',           'EN', "Page URL");
___('admin_metrics_page',           'FR', "URL de la page");
___('admin_metrics_activity',       'EN', "Activity");
___('admin_metrics_activity',       'FR', "Activité");
___('admin_metrics_views',          'EN', "Views");
___('admin_metrics_views',          'FR', "Vues");
___('admin_metrics_count',          'EN', "Stats based on {{1}} page metric");
___('admin_metrics_count',          'FR', "Statistiques issues des performances d'une seule page");
___('admin_metrics_count+',         'EN', "Stats based on {{1}} page metrics");
___('admin_metrics_count+',         'FR', "Statistiques issues des performances de {{1}} pages");
___('admin_metrics_count_search',   'EN', "{{1}} out of {{2}} page metric displayed");
___('admin_metrics_count_search',   'FR', "Performances de {{1}} sur {{2}} pages");
___('admin_metrics_count_search+',  'EN', "{{1}} out of {{2}} page metrics displayed");
___('admin_metrics_count_search+',  'FR', "Performances de {{1}} sur {{2}} pages");


// Metrics: Table actions
___('admin_metrics_table_reset',          'EN', "Reset");
___('admin_metrics_table_reset',          'FR', "Remettre à zéro");
___('admin_metrics_table_reset_warning',  'EN', "Confirm the irreversible deletion of this page\'s metrics");
___('admin_metrics_table_reset_warning',  'FR', "Confirmer la suppression irréversible des indicateurs de cette page");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     PAGEVIEWS                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Pageviews: Header
___('admin_views_date',     'EN', "Current comparison date:");
___('admin_views_date',     'FR', "Date de comparaison actuelle :");
___('admin_views_nodate',   'EN', "The comparison data has never been reset");
___('admin_views_nodate',   'FR', "Les données de comparaison n'ont jamais été remises à zéro");
___('admin_views_reset',    'EN', "Reset the comparison data");
___('admin_views_reset',    'FR', "Remise à zéro des données de comparaison");
___('admin_views_warning',  'EN', "Confirm the irreversible loss of all archived page growth data in order to reset them");
___('admin_views_warning',  'FR', "Confirmer la suppression irréversible de toutes les données sur la croissance des pages afin de les remettre à zéro");


// Pageviews: Table
___('admin_views_name',   'EN', "Page name");
___('admin_views_name',   'FR', "Nom de la page");
___('admin_views_growth', 'EN', "Growth");
___('admin_views_growth', 'FR', "Croissance");
___('admin_views_old',    'EN', "Before");
___('admin_views_old',    'FR', "Avant");
___('admin_views_new',    'EN', "NEW");
___('admin_views_new',    'FR', "NOUV.");
___('admin_views_delete', 'EN', "Confirm the irreversible deletion of this page\'s data");
___('admin_views_delete', 'FR', "Confirmer la suppression irréversible des données de cette page");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   DOPPELGÄNGER                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Doppelgänger: Header
___('admin_doppel_subtitle',  'EN', "Accounts sharing an IP address");
___('admin_doppel_subtitle',  'FR', "Comptes partageant une adresse IP");
___('admin_doppel_none',      'EN', "There are currently no doppelgänger on the website.");
___('admin_doppel_none',      'FR', "Il n'y a actuellement aucun doppelgänger sur le site.");


// Doppelgänger: Table
___('admin_doppel_ip',        'EN', "IP address");
___('admin_doppel_ip',        'FR', "Adresse IP");
___('admin_doppel_activity',  'EN', "Last active");
___('admin_doppel_activity',  'FR', "Dernière activité");
___('admin_doppel_banned',    'EN', "Banned until");
___('admin_doppel_banned',    'FR', "Compte banni");