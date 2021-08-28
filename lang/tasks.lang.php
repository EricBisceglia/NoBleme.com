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
If you happen to find a bug on NoBleme, please {{link|pages/tasks/proposal|submit a bug report}}.
EOT
);
___('tasks_list_body_2',    'FR', <<<EOT
Si vous trouvez un bug sur NoBleme, nous vous serions reconnaissants de {{link|pages/tasks/proposal|rapporter le bug}}.
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
___('tasks_add_body_en',    'EN', "Description in english ({{link|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_add_body_en',    'FR', "Description en anglais ({{link|pages/doc/bbcodes|BBCodes}} autorisés)");
___('tasks_add_body_fr',    'EN', "Description in french ({{link|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_add_body_fr',    'FR', "Description en français ({{link|pages/doc/bbcodes|BBCodes}} autorisés)");
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
___('tasks_approve_icon',       'EN', "Approve task proposal");
___('tasks_approve_icon',       'FR', "Approuver la proposition de tâche");
___('tasks_approve_impossible', 'EN', "This task has already been approved or rejected");
___('tasks_approve_impossible', 'FR', "Cette tâche a déjà été approuvée ou rejetée");
___('tasks_approve_subtitle',   'EN', "Task proposal by");
___('tasks_approve_subtitle',   'FR', "Proposition par");
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
___('tasks_solve_source',     'EN', "Patch source code on {{external|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|GitHub}} (optional)");
___('tasks_solve_source',     'FR', "Code source du patch sur {{external|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|GitHub}} (optionnel)");
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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             CATEGORIES AND MILESTONES                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Manage categories
___('tasks_categories_title_en',  'EN', "Category title in english");
___('tasks_categories_title_en',  'FR', "Nom de la catégorie en anglais");
___('tasks_categories_title_fr',  'EN', "Category title in french");
___('tasks_categories_title_fr',  'FR', "Nom de la catégorie en français");
___('tasks_categories_edit',      'EN', "Edit category");
___('tasks_categories_edit',      'FR', "Modifier la catégorie");
___('tasks_categories_close',     'EN', "Close this form");
___('tasks_categories_close',     'FR', "Fermer ce formulaire");
___('tasks_categories_delete',    'EN', "Confirm the irreversible deletion of this task category");
___('tasks_categories_delete',    'FR', "Confirmer la suppression irréversible de cette catégorie de tâches");


// Manage milestones
___('tasks_milestones_order',     'EN', "Order");
___('tasks_milestones_order',     'FR', "Classement");
___('tasks_milestones_title_en',  'EN', "Milestone title in english");
___('tasks_milestones_title_en',  'FR', "Nom de l'objectif en anglais");
___('tasks_milestones_title_fr',  'EN', "Milestone title in french");
___('tasks_milestones_title_fr',  'FR', "Nom de l'objectif en français");
___('tasks_milestones_body_en',   'EN', "Milestone description in english ({{link|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_milestones_body_en',   'FR', "Description de l'objectif en anglais ({{link|pages/doc/bbcodes|BBCodes}} autorisés)");
___('tasks_milestones_body_fr',   'EN', "Milestone description in french ({{link|pages/doc/bbcodes|BBCodes}} allowed)");
___('tasks_milestones_body_fr',   'FR', "Description de l'objectif en français ({{link|pages/doc/bbcodes|BBCodes}} autorisés)");
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
If you have found a flaw or issue during your usage of NoBleme or while browsing its {{link|pages/doc/dev|source code}}, please fill up the form below and make sure to give as many details as possible.
EOT
);
___('tasks_proposal_intro_1',   'FR', <<<EOT
Si vous repérez une faille ou un problème lors de votre utilisation de NoBleme ou dans son {{link|pages/doc/dev|code source}}, remplissez le formulaire ci-dessous avec le plus d'informations possibles y son sujet.
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