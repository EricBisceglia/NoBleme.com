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
___('admin_metrics_activity',       'EN', "Last used");
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