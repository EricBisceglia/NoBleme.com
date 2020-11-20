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

// Metrics: Table
___('admin_metrics_page',     'EN', "Page URL");
___('admin_metrics_page',     'FR', "URL de la page");
___('admin_metrics_activity', 'EN', "Last used");
___('admin_metrics_activity', 'FR', "Activité");
___('admin_metrics_views',    'EN', "Views");
___('admin_metrics_views',    'FR', "Vues");
___('admin_metrics_queries',  'EN', "Queries");
___('admin_metrics_queries',  'FR', "Requêtes");
___('admin_metrics_load',     'EN', "Load");
___('admin_metrics_load',     'FR', "Charge");
___('admin_metrics_minimum',  'EN', "Minimum");
___('admin_metrics_minimum',  'FR', "Minimum");
___('admin_metrics_target',   'EN', "Target");
___('admin_metrics_target',   'FR', "Objectif");
___('admin_metrics_average',  'EN', "Average");
___('admin_metrics_average',  'FR', "Moyenne");
___('admin_metrics_warning',  'EN', "Warning");
___('admin_metrics_warning',  'FR', "Attention");
___('admin_metrics_bad',      'EN', "Bad");
___('admin_metrics_bad',      'FR', "Mauvais");
___('admin_metrics_maximum',  'EN', "Maximum");
___('admin_metrics_maximum',  'FR', "Maximum");