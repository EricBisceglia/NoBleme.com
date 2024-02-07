<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  TASK  SCHEDULER                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('dev_scheduler_manual_run',     'EN', "Run the scheduler now");
___('dev_scheduler_manual_run',     'FR', "Exécuter les tâches planifiées maintenant");
___('dev_scheduler_manual_confirm', 'EN', "Confirm manual execution of the task scheduler");
___('dev_scheduler_manual_confirm', 'FR', "Confirmer l\'exécution manuelle du planificateur de taches");

// Task list
___('dev_scheduler_task_execution',         'EN', "Execution");
___('dev_scheduler_task_execution',         'FR', "Exécution");
___('dev_scheduler_task_report',            'EN', "Report");
___('dev_scheduler_task_report',            'FR', "Résultat");
___('dev_scheduler_task_results',           'EN', "{{1}} results found   //   {{2}} future tasks   //   {{3}} past logs");
___('dev_scheduler_task_results',           'FR', "{{1}} résultats trouvés   //   {{2}} tâches futures   //   {{3}} logs d'exécution");
___('dev_scheduler_task_execution_future',  'EN', "Future tasks");
___('dev_scheduler_task_execution_future',  'FR', "Tâches futures");
___('dev_scheduler_task_execution_past',    'EN', "Finished tasks");
___('dev_scheduler_task_execution_past',    'FR', "Tâches finies");


// Maintenance tasks
___('dev_scheduler_maintenance_task', 'EN', "The scheduler ran {{1}}");
___('dev_scheduler_maintenance_task', 'FR', "Le planificateur s'est exécuté {{1}}");


// Edit scheduler entries
___('dev_scheduler_edit_error_postdata',  'EN', "Error: No scheduled task id was provided.");
___('dev_scheduler_edit_error_postdata',  'FR', "Erreur : Aucun numéro de tâche planifiée n'a été envoyé.");
___('dev_scheduler_edit_error_id',        'EN', "Error: The requested scheduled task does not exist.");
___('dev_scheduler_edit_error_id',        'FR', "Erreur : La tâche planifiée demandée n'existe pas.");
___('dev_scheduler_edit_error_time',      'EN', "Error: The submitted date and/or time are incorrect.");
___('dev_scheduler_edit_error_time',      'FR', "Erreur : L'heure et/ou la date sont incorrects.");
___('dev_scheduler_edit_button',          'EN', "Edit scheduled task");
___('dev_scheduler_edit_button',          'FR', "Modifier la tâche planifiée");


// Delete scheduler entries
___('dev_scheduler_delete_task',  'EN', "Confirm the irreversible deletion of this scheduled task");
___('dev_scheduler_delete_task',  'FR', "Confirmer la suppression irréversible de cette tâche planifiée");
___('dev_scheduler_delete_log',   'EN', "Confirm the irreversible deletion of this scheduler log entry");
___('dev_scheduler_delete_log',   'FR', "Confirmer la suppression irréversible de cette entrée de l\'historique des tâches planifiées");