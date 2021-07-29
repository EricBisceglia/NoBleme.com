<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     TASK LIST                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('tasks_list_subtitle',  'EN', "Tasks, bugs, and features");
___('tasks_list_subtitle',  'FR', "Suivi du développement de NoBleme");
___('tasks_list_body_1',    'EN', <<<EOT
The table below lists all of the bugs and functional changes related to NoBleme's past and future evolution. Click on any task to see more details about it. You can use the first rows to sort, filter, and search the to-do list. These tasks are presented in a more organized format on {{link|todo_link|NoBleme's roadmap}}.
EOT
);
___('tasks_list_body_1',    'FR', <<<EOT
Ce tableau contient tous les bugs et idées d'évolutions liés au développement passé et futur de NoBleme. Cliquez sur une tâche pour plus de détails à son sujet. Les premières lignes du tableau vous permettent de filtrer, trier, et chercher les tâches. Le {{link|todo_link|plan de route}} présente le même contenu de façon plus organisée.
EOT
);
___('tasks_list_body_2',    'EN', <<<EOT
If you happen to find a bug on NoBleme, please {{link|todo_link|submit a bug report}}.
EOT
);
___('tasks_list_body_2',    'FR', <<<EOT
Si vous trouvez un bug sur NoBleme, nous vous serions reconnaissants de {{link|todo_link|rapporter le bug}}.
EOT
);


// List: Titles
___('tasks_list_status',      'EN', "Status");
___('tasks_list_status',      'FR', "État");
___('tasks_list_description', 'EN', "Description");
___('tasks_list_description', 'FR', "Description");
___('tasks_list_created',     'EN', "Created");
___('tasks_list_created',     'FR', "Création");
___('tasks_list_reporter',    'EN', "Reporter");
___('tasks_list_reporter',    'FR', "Ouvert par");
___('tasks_list_category',    'EN', "Category");
___('tasks_list_category',    'FR', "Catégorie");
___('tasks_list_goal',        'EN', "Goal");
___('tasks_list_goal',        'FR', "Objectif");


// List: Count
___('tasks_list_count',                 'EN', "{{1}} task found");
___('tasks_list_count',                 'FR', "{{1}} tâche trouvée");
___('tasks_list_count+',                'EN', "{{1}} tasks found");
___('tasks_list_count+',                'FR', "{{1}} tâches trouvées");
___('tasks_list_count_finished',        'EN', "Including {{1}} finished");
___('tasks_list_count_finished',        'FR', "Dont {{1}} finie");
___('tasks_list_count_finished+',       'EN', "Including {{1}} finished");
___('tasks_list_count_finished+',       'FR', "Dont {{1}} finies");
___('tasks_list_count_finished_short',  'EN', "{{1}} finished");
___('tasks_list_count_finished_short',  'FR', "{{1}} finie");
___('tasks_list_count_finished_short+', 'EN', "{{1}} finished");
___('tasks_list_count_finished_short+', 'FR', "{{1}} finies");
___('tasks_list_count_open',            'EN', "And {{1}} still to do");
___('tasks_list_count_open',            'FR', "Et {{1}} à faire");
___('tasks_list_count_open_short',      'EN', "{{1}} to do");
___('tasks_list_count_open_short',      'FR', "{{1}} à faire");
___('tasks_list_count_solved',          'EN', "Total {{1}} solved");
___('tasks_list_count_solved',          'FR', "Soit {{1}} finies");


// List: Table
___('tasks_list_state_0',       'EN', "Maybe some day");
___('tasks_list_state_0',       'FR', "À faire un jour");
___('tasks_list_state_1',       'EN', "No hurry");
___('tasks_list_state_1',       'FR', "Pas pressé");
___('tasks_list_state_2',       'EN', "There's time");
___('tasks_list_state_2',       'FR', "Y'a le temps");
___('tasks_list_state_3',       'EN', "To consider");
___('tasks_list_state_3',       'FR', "À considérer");
___('tasks_list_state_4',       'EN', "Important");
___('tasks_list_state_4',       'FR', "Important");
___('tasks_list_state_5',       'EN', "Emergency");
___('tasks_list_state_5',       'FR', "Urgence");
___('tasks_list_solved',        'EN', "Solved");
___('tasks_list_solved',        'FR', "Résolu");
___('tasks_list_solved_in',     'EN', "Solved in {{1}}");
___('tasks_list_solved_in',     'FR', "Résolu en {{1}}");
___('tasks_list_uncategorized', 'EN', "Uncategorized");
___('tasks_list_uncategorized', 'FR', "Non catégorisé");
___('tasks_list_no_milestone',  'EN', "No goal set");
___('tasks_list_no_milestone',  'FR', "Aucun objectif");
___('tasks_list_nolang_en',     'EN', "No english translation");
___('tasks_list_nolang_en',     'FR', "Pas de traduction anglaise");
___('tasks_list_nolang_fr',     'EN', "No french translation");
___('tasks_list_nolang_fr',     'FR', "Pas de traduction française");
___('tasks_list_deleted',       'EN', "Deleted task");
___('tasks_list_deleted',       'FR', "Tâche supprimée");
___('tasks_list_private',       'EN', "Private task");
___('tasks_list_private',       'FR', "Tâche privée");
___('tasks_list_unvalidated',   'EN', "Unvalidated task");
___('tasks_list_unvalidated',   'FR', "Tâche non validée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   TASK DETAILS                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Task summary
___('tasks_details_error',    'EN', "This task does not exist or has been deleted");
___('tasks_details_error',    'FR', "Cette tâche n'existe pas ou a été supprimée");
___('tasks_details_title',    'EN', "#{{1}}: {{2}}");
___('tasks_details_title',    'FR', "#{{1}} : {{2}}");
___('tasks_details_no_title', 'EN', "Title has not been translated");
___('tasks_details_no_title', 'FR', "Le titre n'a pas été traduit");
___('tasks_details_id',       'EN', "Task #{{1}}");
___('tasks_details_id',       'FR', "Tâche #{{1}}");
___('tasks_details_link',     'EN', "Direct link to this task:");
___('tasks_details_link',     'FR', "Lien direct vers cette tâche :");
___('tasks_details_created',  'EN', "Task opened on {{1}} by");
___('tasks_details_created',  'FR', "Tâche ouverte le {{1}} par");
___('tasks_details_solved',   'EN', "Task solved on {{1}}");
___('tasks_details_solved',   'FR', "Tâche résolue le {{1}}");
___('tasks_details_source',   'EN', "Source code");
___('tasks_details_source',   'FR', "Code source");
___('tasks_details_no_body',  'EN', "This task has not been translated into english.");
___('tasks_details_no_body',  'FR', "Le contenu de cette tâche n'a pas été traduit en français.");


// Full details
___('tasks_full_unvalidated', 'EN', "This task has not been validated yet, only admins can see it");
___('tasks_full_unvalidated', 'FR', "Cette tâche n'a pas été validée, seule l'administration peut la voir");
___('tasks_full_private',     'EN', "This task is private, only admins can see it");
___('tasks_full_private',     'FR', "Cette tâche est privée, seule l'administration peut la voir");
___('tasks_full_created',     'EN', "Task opened {{1}} ({{2}}) by");
___('tasks_full_created',     'FR', "Tâche ouverte {{1}} ({{2}}) par");
___('tasks_full_solved',      'EN', "Task solved {{1}} ({{2}})");
___('tasks_full_solved',      'FR', "Tâche résolue {{1}} ({{2}})");
___('tasks_full_source',      'EN', "Source code of the patch that solved the task");
___('tasks_full_source',      'FR', "Code source du patch qui a résolu la tâche");
___('tasks_full_unsolved',    'EN', "This task has not been solved yet");
___('tasks_full_unsolved',    'FR', "Cette tâche n'a pas encore été résolue");
___('tasks_full_priority',    'EN', "Task priority status:");
___('tasks_full_priority',    'FR', "Priorité de la résolution :");
___('tasks_full_category',    'EN', "Task category:");
___('tasks_full_category',    'FR', "Catégorie de la tâche :");
___('tasks_full_milestone',   'EN', "Task milestone:");
___('tasks_full_milestone',   'FR', "Objectif de la tâche :");
___('tasks_full_body',        'EN', "Task details:");
___('tasks_full_body',        'FR', "Détails de la tâche :");