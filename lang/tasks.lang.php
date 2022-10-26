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
The table below lists all of the bugs and functional changes related to NoBleme's past and future evolution. Click on any task to see more details about it. You can use the first rows to sort, filter, and search the to-do list. These tasks are presented in a more organized format on {{link|pages/tasks/roadmap|NoBleme's roadmap}}.
EOT
);
___('tasks_list_body_1',    'FR', <<<EOT
Ce tableau contient tous les bugs et idées d'évolutions liés au développement passé et futur de NoBleme. Cliquez sur une tâche pour voir plus de détails à son sujet. Les premières lignes du tableau vous permettent de filtrer, trier, et chercher les tâches. Le {{link|pages/tasks/roadmap|plan de route}} présente le même contenu de façon plus organisée.
EOT
);
___('tasks_list_body_2',    'EN', <<<EOT
If you happen to find a bug on NoBleme, please {{link|pages/tasks/proposal|submit a bug report}}.
EOT
);
___('tasks_list_body_2',    'FR', <<<EOT
Si vous trouvez un bug sur NoBleme, nous vous serions reconnaissants de {{link|pages/tasks/proposal|rapporter le bug}}.
EOT
);


// List: Titles
___('tasks_list_status',    'EN', "Status");
___('tasks_list_status',    'FR', "État");
___('tasks_list_reporter',  'EN', "Reporter");
___('tasks_list_reporter',  'FR', "Ouvert par");
___('tasks_list_goal',      'EN', "Goal");
___('tasks_list_goal',      'FR', "Objectif");


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
___('tasks_list_open',          'EN', "Unsolved");
___('tasks_list_open',          'FR', "Non résolu");
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
/*                                                      ROADMAP                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('tasks_roadmap_title',  'EN', "Roadmap");
___('tasks_roadmap_title',  'FR', "Plan de route");
___('tasks_roadmap_user',   'EN', "View as a regular user");
___('tasks_roadmap_user',   'FR', "Voir comme un compte normal");
___('tasks_roadmap_admin',  'EN', "View as an administrator");
___('tasks_roadmap_admin',  'FR', "Voir comme un compte administratif");
___('tasks_roadmap_body_1', 'EN', <<<EOT
As NoBleme is a constantly evolving website, this page acts as both a roadmap previewing plans for future developments and a changelog archiving past evolutions and bug fixes. All of the tasks listed below are taken from the {{link|pages/tasks/list|to-do list}}, and listed in reverse chronological order.
EOT
);
___('tasks_roadmap_body_1', 'FR', <<<EOT
NoBleme étant un site Internet en évolution permanente, cette page sert à la fois de plan de route pour les développements futurs et d'archive des évolutions et correctifs qui ont eu lieu dans le passé. Toutes les tâches listées ci-dessous sont issues de la {{link|pages/tasks/list|liste des tâches}}, et sont listées antéchronologiquement.
EOT
);
___('tasks_roadmap_body_2', 'EN', <<<EOT
Future tasks which are yet to be completed appear in <span class="task_status_1 spaced text_dark bold">shades</span><span class="task_status_3 spaced text_dark bold">of</span><span class="task_status_5 spaced text_dark bold">red</span> depending on their priority level, whereas finished tasks appear in <span class="task_solved spaced text_dark bold">green</span>. You can click on a task to see its details.
EOT
);
___('tasks_roadmap_body_2', 'FR', <<<EOT
Les tâches futures (qui n'ont pas encore été complétées) apparaissent en <span class="task_status_1 spaced text_dark bold">nuances</span><span class="task_status_3 spaced text_dark bold">de</span><span class="task_status_5 spaced text_dark bold">rouge</span> selon leur niveau de priorité, tandis que les tâches complétées apparaissent en <span class="task_solved spaced text_dark bold">vert</span>. Vous pouvez cliquer sur une tâche pour afficher plus d'informations à son sujet.
EOT
);


// Table
___('tasks_roadmap_task',     'EN', "Task");
___('tasks_roadmap_task',     'FR', "Tâche");
___('tasks_roadmap_unsolved', 'EN', "Not yet");
___('tasks_roadmap_unsolved', 'FR', "Pas encore");
___('tasks_roadmap_private',  'EN', "[PRIVATE] ");
___('tasks_roadmap_private',  'FR', "[PRIVÉ] ");




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
___('tasks_full_deleted',     'EN', "This task has been deleted, only admins can see it");
___('tasks_full_deleted',     'FR', "Cette tâche a été supprimée, seule l'adminstration peut la voir");
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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   CREATE A TASK                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('tasks_add_title',  'EN', "New task");
___('tasks_add_title',  'FR', "Nouvelle tâche");


// Form
___('tasks_add_title_en',   'EN', "Title in english");
___('tasks_add_title_en',   'FR', "Titre en anglais");
___('tasks_add_title_fr',   'EN', "Title in french");
___('tasks_add_title_fr',   'FR', "Titre en français");
___('tasks_add_body_en',    'EN', "Description in english ({{link_popup|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_add_body_en',    'FR', "Description en anglais ({{link_popup|pages/doc/bbcodes|BBCodes}} autorisés)");
___('tasks_add_body_fr',    'EN', "Description in french ({{link_popup|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_add_body_fr',    'FR', "Description en français ({{link_popup|pages/doc/bbcodes|BBCodes}} autorisés)");
___('tasks_add_milestone',  'EN', "Milestone");
___('tasks_add_milestone',  'FR', "Objectif");
___('tasks_add_priority',   'EN', "Priority level");
___('tasks_add_priority',   'FR', "Importance");
___('tasks_add_private',    'EN', "Private task (will not be publicly visible)");
___('tasks_add_private',    'FR', "Tâche privée (ne sera visible que pour l'administration)");
___('tasks_add_silent',     'EN', "Silent (no IRC notification)");
___('tasks_add_silent',     'FR', "Silencieux (pas de notification IRC)");
___('tasks_add_submit',     'EN', "Create a task");
___('tasks_add_submit',     'FR', "Créer une tâche");


// Preview
___('tasks_add_preview_en', 'EN', "Preview (english):");
___('tasks_add_preview_en', 'FR', "Prévisualisation (anglais):");
___('tasks_add_preview_fr', 'EN', "Preview (french);");
___('tasks_add_preview_fr', 'FR', "Prévisualisation (français);");


// Errors
___('tasks_add_error_title',  'EN', "The task must have a title in either french or english");
___('tasks_add_error_title',  'FR', "La tâche doit avoir un titre en français ou en anglais");





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                         APPROVE / REJECT A TASK PROPOSAL                                          */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Approve a task proposal
___('tasks_approve_title',      'EN', "Approve a task proposal");
___('tasks_approve_title',      'FR', "Accepter une proposition de tâche");
___('tasks_approve_impossible', 'EN', "This task has already been approved or rejected");
___('tasks_approve_impossible', 'FR', "Cette tâche a déjà été approuvée ou rejetée");
___('tasks_approve_submit',     'EN', "Approve task proposal");
___('tasks_approve_submit',     'FR', "Approuver la proposition");


// Reject a task proposal
___('tasks_reject_title',   'EN', "Reject a task proposal");
___('tasks_reject_title',   'FR', "Rejeter une proposition de tâche");
___('tasks_reject_icon',    'EN', "Reject task proposal");
___('tasks_reject_icon',    'FR', "Rejeter la proposition de tâche");
___('tasks_reject_reason',  'EN', "Rejection reason (optional)");
___('tasks_reject_reason',  'FR', "Raison du rejet (optionnel)");
___('tasks_reject_silent',  'EN', "Silent (do not send a rejection private message)");
___('tasks_reject_silent',  'FR', "Silencieux (ne pas envoyer de message privé de rejet)");
___('tasks_reject_submit',  'EN', "Reject task proposal");
___('tasks_reject_submit',  'FR', "Rejecter la proposition");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   SOLVE A TASK                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Solve a task
___('tasks_solve_impossible', 'EN', "This task has already been solved");
___('tasks_solve_impossible', 'FR', "Cette tâche a déjà été résolue");
___('tasks_solve_title',      'EN', "Solve task #{{1}}");
___('tasks_solve_title',      'FR', "Résoudre la tâche #{{1}}");
___('tasks_solve_source',     'EN', "Patch source code on {{external_popup|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|GitHub}} (optional)");
___('tasks_solve_source',     'FR', "Code source du patch sur {{external_popup|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|GitHub}} (optionnel)");
___('tasks_solve_no_message', 'EN', "Stealthy (no private message to the task's author)");
___('tasks_solve_no_message', 'FR', "Discret (pas de message privé à la personne qui a ouvert la tâche)");
___('tasks_solve_submit',     'EN', "Solve task");
___('tasks_solve_submit',     'FR', "Résoudre la tâche");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    EDIT A TASK                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Form
___('tasks_edit_author',  'EN', "Task proposal by");
___('tasks_edit_author',  'FR', "Tâche proposée par");
___('tasks_edit_solved',  'EN', "Task has been solved");
___('tasks_edit_solved',  'FR', "La tâche a été résolue");
___('tasks_edit_submit',  'EN', "Edit task");
___('tasks_edit_submit',  'FR', "Modifier la tâche");


// Errors
___('tasks_edit_unvalidated', 'EN', "Unvalidated tasks can not be edited");
___('tasks_edit_unvalidated', 'FR', "Les tâches ne peuvent pas être modifiées avant d'avoir été validées");
___('tasks_edit_no_author',   'EN', "The task proposal author must be a valid username");
___('tasks_edit_no_author',   'FR', "La tâche doit être proposée par un compte valide");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              DELETE / RESTORE A TASK                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Soft deletion
___('tasks_delete_confirm', 'EN', "Confirm the soft deletion of this task.");
___('tasks_delete_confirm', 'FR', "Confirmer la suppression non définitive de cette tâche.");


// Restoration
___('tasks_restore_confirm',  'EN', "Confirm the restoration of this deleted task");
___('tasks_restore_confirm',  'FR', "Confirmer la restauration de cette tâche supprimée");


// Hard deletion
___('tasks_delete_hard_confirm',  'EN', "Confirm the permanent and irreversible deletion of this task");
___('tasks_delete_hard_confirm',  'FR', "Confirmer la suppression définitive et irréversible de cette tâche");
___('tasks_delete_hard_ok',       'EN', "The task has properly been deleted");
___('tasks_delete_hard_ok',       'FR', "La tâche a bien été supprimée");
___('tasks_delete_hard_error',    'EN', "The task could not be deleted or has already been deleted");
___('tasks_delete_hard_error',    'FR', "La tâche n'a pas pu être supprimée ou a déjà été supprimée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             CATEGORIES AND MILESTONES                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Manage categories
___('tasks_categories_archived',  'EN', "Archived");
___('tasks_categories_archived',  'FR', "Archivé");
___('tasks_categories_title_en',  'EN', "Category title in english");
___('tasks_categories_title_en',  'FR', "Nom de la catégorie en anglais");
___('tasks_categories_title_fr',  'EN', "Category title in french");
___('tasks_categories_title_fr',  'FR', "Nom de la catégorie en français");
___('tasks_categories_archive',   'EN', "Archived category (will not appear when creating new tasks)");
___('tasks_categories_archive',   'FR', "Catégorie archivée (n'apparaitra pas à la création de nouvelles tâches)");
___('tasks_categories_edit',      'EN', "Edit category");
___('tasks_categories_edit',      'FR', "Modifier la catégorie");
___('tasks_categories_delete',    'EN', "Confirm the irreversible deletion of this task category");
___('tasks_categories_delete',    'FR', "Confirmer la suppression irréversible de cette catégorie de tâches");


// Manage milestones
___('tasks_milestones_title_en',  'EN', "Milestone title in english");
___('tasks_milestones_title_en',  'FR', "Nom de l'objectif en anglais");
___('tasks_milestones_title_fr',  'EN', "Milestone title in french");
___('tasks_milestones_title_fr',  'FR', "Nom de l'objectif en français");
___('tasks_milestones_body_en',   'EN', "Milestone description in english ({{link_popup|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_milestones_body_en',   'FR', "Description de l'objectif en anglais ({{link_popup|pages/doc/bbcodes|BBCodes}} autorisés)");
___('tasks_milestones_body_fr',   'EN', "Milestone description in french ({{link_popup|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_milestones_body_fr',   'FR', "Description de l'objectif en français ({{link_popup|pages/doc/bbcodes|BBCodes}} autorisés)");
___('tasks_milestones_edit',      'EN', "Edit milestone");
___('tasks_milestones_edit',      'FR', "Modifier l'objectif");
___('tasks_milestones_delete',    'EN', "Confirm the irreversible deletion of this task milestone");
___('tasks_milestones_delete',    'FR', "Confirmer la suppression irréversible de cet objectif de tâches");





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    BUG REPORT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('tasks_proposal_title',     'EN', "Task proposal");
___('tasks_proposal_title',     'FR', "Proposition de tâche");
___('tasks_proposal_subtitle',  'EN', "Bug report or feature request");
___('tasks_proposal_subtitle',  'FR', "Rapport de bug ou demande de fonctionnalité");
___('tasks_proposal_intro_1',   'EN', <<<EOT
If you have found a flaw or issue during your usage of NoBleme or while browsing its {{link|pages/doc/dev|source code}}, please fill up the form below and make sure to include as many details as possible.
EOT
);
___('tasks_proposal_intro_1',   'FR', <<<EOT
Si vous repérez une faille ou un problème lors de votre utilisation de NoBleme ou dans son {{link|pages/doc/dev|code source}}, remplissez le formulaire ci-dessous avec le plus d'informations possibles à son sujet.
EOT
);
___('tasks_proposal_intro_2',   'EN', <<<EOT
If you have an idea for a change or improvement to NoBleme that would make the website better, or an idea for a new feature that would benefit the website, you can also use the form below to make your proposal.
EOT
);
___('tasks_proposal_intro_2',   'FR', <<<EOT
Si vous avez une idée d'amélioration qui rendrait NoBleme plus pratique à utiliser, ou une idée de nouvelle fonctionnalité, vous pouvez également utiliser le formulaire ci-dessous pour faire une proposition.
EOT
);
___('tasks_proposal_intro_3',   'EN', <<<EOT
In either case, please check the {{link|pages/tasks/list|to-do list}} and ensure your bug report or feature request has not already been made by someone else. Thanks in advance for your contribution to NoBleme!
EOT
);
___('tasks_proposal_intro_3',   'FR', <<<EOT
Dans les deux cas, regardez d'abord si votre rapport de bug ou proposition de fonctionnalité n'est pas déjà présent sur la {{link|pages/tasks/list|liste des tâches}}. Merci d'avance pour votre contribution à NoBleme !
EOT
);


// Bug report form
___('tasks_proposal_submit',  'EN', "Submit proposal");
___('tasks_proposal_submit',  'FR', "Envoyer la proposition");
___('tasks_proposal_error',   'EN', "The proposal can not be empty");
___('tasks_proposal_error',   'FR', "La proposition ne peut pas être vide");
___('tasks_proposal_flood',   'EN', "Your proposal has not been sent. In order to prevent website flooding, you must wait before performing another action on the website");
___('tasks_proposal_flood',   'FR', "Votre proposition n'a pas été envoyée. Afin d'éviter le flood, vous devez attendre avant de pouvoir effectuer une autre action sur le site");
___('tasks_proposal_sent',    'EN', "Your proposal has been submitted. Thank you!");
___('tasks_proposal_sent',    'FR', "Votre proposition a été envoyée. Merci !");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       STATS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page section selector
___('tasks_stats_selector_title',       'EN', "Tasks statistics");
___('tasks_stats_selector_title',       'FR', "Stats des tâches");
___('tasks_stats_selector_categories',  'EN', "Categories");
___('tasks_stats_selector_categories',  'FR', "Catégories");
___('tasks_stats_selector_milestones',  'EN', "Milestones");
___('tasks_stats_selector_milestones',  'FR', "Objectifs");
___('tasks_stats_selector_priority',    'EN', "Priority levels");
___('tasks_stats_selector_priority',    'FR', "Importance");
___('tasks_stats_selector_submitted',   'EN', "Contributors");
___('tasks_stats_selector_submitted',   'FR', "Contributions");


// Recalculate all stats
___('tasks_stats_recalculate_button', 'EN', "Recalculate all tasks statistics");
___('tasks_stats_recalculate_button', 'FR', "Recalculer toutes les statistiques des tâches");
___('tasks_stats_recalculate_alert',  'EN', "Are you sure you wish to recalculate all tasks statistics?");
___('tasks_stats_recalculate_alert',  'FR', "Confirmer que vous tenez à recalculer toutes les statistiques des tâches");


// Overall stats
___('tasks_stats_overall_summary',    'EN', "There are <span class=\"bold\">{{1}}</span> tasks on the {{link|pages/tasks/list|to-do list}}.");
___('tasks_stats_overall_summary',    'FR', "Il y a <span class=\"bold\">{{1}}</span> tâches sur la {{link|pages/tasks/list|liste des tâches}}.");
___('tasks_stats_overall_solved',     'EN', "<span class=\"bold\">{{1}}</span> tasks ({{2}}) have been solved.");
___('tasks_stats_overall_solved',     'FR', "<span class=\"bold\">{{1}}</span> tâches ({{2}}) ont été résolues.");
___('tasks_stats_overall_unsolved',   'EN', "<span class=\"bold\">{{1}}</span> tasks ({{2}}) are still open and waiting for a resolution.");
___('tasks_stats_overall_unsolved',   'FR', "<span class=\"bold\">{{1}}</span> tâches ({{2}}) sont toujours ouvertes, en attente d'une résolution.");
___('tasks_stats_overall_sourced',    'EN', "<span class=\"bold\">{{1}}</span> ({{2}}) solved tasks include a link to the {{link|pages/doc/dev|source code}} of the fix.");
___('tasks_stats_overall_sourced',    'FR', "<span class=\"bold\">{{1}}</span> ({{2}}) tâches résolues incluent un lien vers le {{link|pages/doc/dev|code source}} du correctif.");
___('tasks_stats_overall_categories', 'EN', "<span class=\"bold\">{{1}}</span> categories are used to sort the tasks.");
___('tasks_stats_overall_categories', 'FR', "<span class=\"bold\">{{1}}</span> catégories servent a trier les tâches.");
___('tasks_stats_overall_milestones', 'EN', "<span class=\"bold\">{{1}}</span> milestones have been created for the {{link|pages/tasks/roadmap|roadmap}}.");
___('tasks_stats_overall_milestones', 'FR', "<span class=\"bold\">{{1}}</span> objectifs ont été crées pour le {{link|pages/tasks/roadmap|plan de route}}.");
___('tasks_stats_overall_more',       'EN', " You can find more stats about NoBleme's tasks by using the dropdown menu at the top.");
___('tasks_stats_overall_more',       'FR', " Vous trouverez d'autres stats sur les tâches en utilisant le menu déroulant en haut de la page. ");


// Timeline
___('tasks_stats_years_created',  'EN', "Tasks<br>created");
___('tasks_stats_years_created',  'FR', "Tâches<br>ouvertes");
___('tasks_stats_years_solved',   'EN', "Tasks<br>solved");
___('tasks_stats_years_solved',   'FR', "Tâches<br>résolues");


// Categories
___('tasks_stats_categories_tasks',   'EN', "Tasks");
___('tasks_stats_categories_tasks',   'FR', "Tâches");
___('tasks_stats_categories_oldest',  'EN', "Oldest<br>task");
___('tasks_stats_categories_oldest',  'FR', "Première<br>tâche");
___('tasks_stats_categories_newest',  'EN', "Newest<br>task");
___('tasks_stats_categories_newest',  'FR', "Dernière<br>tâche");
___('tasks_stats_categories_none',    'EN', "No category");
___('tasks_stats_categories_none',    'FR', "Pas de catégorie");


// Milestones
___('tasks_stats_milestones_date',      'EN', "Release date");
___('tasks_stats_milestones_date',      'FR', "Date de<br>résolution");
___('tasks_stats_milestones_unsolved',  'EN', "Unsolved<br>tasks");
___('tasks_stats_milestones_unsolved',  'FR', "Tâches non<br>résolues");
___('tasks_stats_milestones_solved',    'EN', "Solved<br>tasks");
___('tasks_stats_milestones_solved',    'FR', "Tâches<br>résolues");


// Priority levels
___('tasks_stats_priority_level', 'EN', "Task<br>priority");
___('tasks_stats_priority_level', 'FR', "Importance<br>de la tâche");
___('tasks_stats_priority_total', 'EN', "Total<br>tasks");
___('tasks_stats_priority_total', 'FR', "Nombre<br>de tâches");


// Contributors
___('tasks_stats_contrib_count',  'EN', "Task<br>proposals");
___('tasks_stats_contrib_count',  'FR', "Tâches<br>proposées");