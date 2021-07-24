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
___('tasks_list_state_0',     'EN', "Maybe some day");
___('tasks_list_state_0',     'FR', "À faire un jour");
___('tasks_list_state_1',     'EN', "No hurry");
___('tasks_list_state_1',     'FR', "Pas pressé");
___('tasks_list_state_2',     'EN', "There's time");
___('tasks_list_state_2',     'FR', "Y'a le temps");
___('tasks_list_state_3',     'EN', "To consider");
___('tasks_list_state_3',     'FR', "À considérer");
___('tasks_list_state_4',     'EN', "Important");
___('tasks_list_state_4',     'FR', "Important");
___('tasks_list_state_5',     'EN', "Emergency");
___('tasks_list_state_5',     'FR', "Urgence");
___('tasks_list_solved',      'EN', "Solved");
___('tasks_list_solved',      'FR', "Résolu");
___('tasks_list_nolang_en',   'EN', "No english translation");
___('tasks_list_nolang_en',   'FR', "Pas de traduction anglaise");
___('tasks_list_nolang_fr',   'EN', "No french translation");
___('tasks_list_nolang_fr',   'FR', "Pas de traduction française");
___('tasks_list_deleted',     'EN', "Deleted task");
___('tasks_list_deleted',     'FR', "Tâche supprimée");
___('tasks_list_private',     'EN', "Private task");
___('tasks_list_private',     'FR', "Tâche privée");
___('tasks_list_unvalidated', 'EN', "Unvalidated task");
___('tasks_list_unvalidated', 'FR', "Tâche non validée");