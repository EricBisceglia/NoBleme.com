<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      QUERIES                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// All's OK
___('dev_queries_ok', 'EN', "ALL QUERIES HAVE SUCCESSFULLY BEEN RAN");
___('dev_queries_ok', 'FR', "LES REQUÊTES ONT ÉTÉ EFFECTUÉES AVEC SUCCÈS");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 CLOSE THE WEBSITE                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Close the website
___('dev_close_website_title',  'EN', "Open / Close the website");
___('dev_close_website_title',  'FR', "Ouvrir / Fermer le site");
___('dev_close_website_button', 'EN', "Toggle");
___('dev_close_website_button', 'FR', "Changer");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  VERSION NUMBERS                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Version numbers: header
___('dev_versions_subtitle',      'EN', "NoBleme Semantic Versioning");
___('dev_versions_subtitle',      'FR', "NoBleme Semantic Versioning");
___('dev_versions_nbsemver',      'EN', "Given a version number MAJOR.MINOR.PATCH-EXTENSION, increment the:");
___('dev_versions_nbsemver',      'FR', "Étant donné un numéro de version MAJEUR.MINEUR.CORRECTIF-EXTENSION, il faut incrémenter :");
___('dev_versions_nbsemver_list', 'EN', <<<EOT
<ul>
  <li>
    MAJOR version when there is a significant core rework,
  </li>
  <li>
    MINOR version when there is a new major functionality,
  </li>
  <li>
    PATCH version when there is a new minor functionality or a bug has been fixed.
  </li>
  <li>
    EXTENSION can be added for incomplete or partial releases (alpha, beta, rc0, etc.).
  </li>
</ul>
EOT
);
___('dev_versions_nbsemver_list', 'FR', <<<EOT
<ul>
  <li>
    MAJEUR quand il y a une réécriture majeure d'un élément central,
  </li>
  <li>
    MINEUR quand il y a une nouvelle fonctionnalité majeure,
  </li>
  <li>
    CORRECTIF quand il y a une nouvelle fonctionnalité mineure ou qu'un bug a été corrigé.
  </li>
  <li>
  EXTENSION peut être ajouté pour les versions incomplètes ou partielles (alpha, beta, rc0, etc.).
  </li>
</ul>
EOT
);


// Version numbers: Form
___('dev_versions_form_title',      'EN', "Release new version");
___('dev_versions_form_title',      'FR', "Publier une nouvelle version");
___('dev_versions_form_major',      'EN', "Major");
___('dev_versions_form_major',      'FR', "Majeur");
___('dev_versions_form_minor',      'EN', "Minor");
___('dev_versions_form_minor',      'FR', "Mineur");
___('dev_versions_form_patch',      'EN', "Patch");
___('dev_versions_form_patch',      'FR', "Correctif");
___('dev_versions_form_extension',  'EN', "Extension");
___('dev_versions_form_extension',  'FR', "Extension");
___('dev_versions_form_activity',   'EN', "Publish in recent activity");
___('dev_versions_form_activity',   'FR', "Publier dans l'activité récente");
___('dev_versions_form_irc',        'EN', "Notify IRC #dev of the new release");
___('dev_versions_form_irc',        'FR', "Notifier IRC #dev de la nouvelle version");
___('dev_versions_form_submit',     'EN', "New release");
___('dev_versions_form_submit',     'FR', "Nouvelle version");


// Version numbers: Table
___('dev_versions_table_title',             'EN', "Version history");
___('dev_versions_table_title',             'FR', "Historique des versions");
___('dev_versions_table_delay',             'EN', "Delay");
___('dev_versions_table_delay',             'FR', "Délai");
___('dev_versions_table_not_existing',      'EN', "This version number does not exist");
___('dev_versions_table_not_existing',      'FR', "Ce numéro de version n'existe pas");
___('dev_versions_table_confirm_deletion',  'EN', "Confirm the irreversible deletion of version {{1}}");
___('dev_versions_table_confirm_deletion',  'FR', "Confirmer la suppression irréversible de la version {{1}}");
___('dev_versions_table_deleted',           'EN', "Version {{1}} has been deleted");
___('dev_versions_table_deleted',           'FR', "Version {{1}} supprimée");


// Version numbers: Edition
___('dev_versions_edit_button',           'EN', "Edit release");
___('dev_versions_edit_button',           'FR', "Modifier la version");
___('dev_versions_edit_error_postdata',   'EN', "Error: No version id was provided.");
___('dev_versions_edit_error_postdata',   'FR', "Erreur : Aucun numéro de version n'a été envoyé.");
___('dev_versions_edit_error_id',         'EN', "Error: The requested version does not exist.");
___('dev_versions_edit_error_id',         'FR', "Erreur : La version demandée n'existe pas.");
___('dev_versions_edit_error_duplicate',  'EN', "Error: This version number already exists.");
___('dev_versions_edit_error_duplicate',  'FR', "Erreur : Ce numéro de version existe déjà.");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   DOCUMENTATION                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Code snippets selector
___('dev_snippets_title',             'EN', "Code snippets:");
___('dev_snippets_title',             'FR', "Modèles de code :");
___('dev_snippets_selector_full',     'EN', "Full page");
___('dev_snippets_selector_full',     'FR', "Page complète");
___('dev_snippets_selector_fetched',  'EN', "Fetched page");
___('dev_snippets_selector_fetched',  'FR', "Page fetchée");
___('dev_snippets_selector_header',   'EN', "Headers");
___('dev_snippets_selector_header',   'FR', "En-têtes");
___('dev_snippets_selector_blocks',   'EN', "Comment blocks");
___('dev_snippets_selector_blocks',   'FR', "Blocs de commentaires");


// CSS palette selector
___('dev_palette_selector_colors',    'EN', "Colors");
___('dev_palette_selector_colors',    'FR', "Couleurs");
___('dev_palette_selector_default',   'EN', "Default");
___('dev_palette_selector_default',   'FR', "Tags");
___('dev_palette_selector_divs',      'EN', "Divs");
___('dev_palette_selector_divs',      'FR', "Divs");
___('dev_palette_selector_forms',     'EN', "Forms");
___('dev_palette_selector_forms',     'FR', "Formulaires");
___('dev_palette_selector_grids',     'EN', "Grids");
___('dev_palette_selector_grids',     'FR', "Grilles");
___('dev_palette_selector_icons',     'EN', "Icons");
___('dev_palette_selector_icons',     'FR', "Icônes");
___('dev_palette_selector_popins',    'EN', "Popins");
___('dev_palette_selector_popins',    'FR', "Popins");
___('dev_palette_selector_spacing',   'EN', "Spacing");
___('dev_palette_selector_spacing',   'FR', "Espacement");
___('dev_palette_selector_tables',    'EN', "Tables");
___('dev_palette_selector_tables',    'FR', "Tableaux");
___('dev_palette_selector_text',      'EN', "Text");
___('dev_palette_selector_text',      'FR', "Texte");
___('dev_palette_selector_tooltips',  'EN', "Tooltips");
___('dev_palette_selector_tooltips',  'FR', "Infobulles");


// JS toolbox selector
___('dev_js_toolbox_title', 'EN', "JavaScript toolbox:");
___('dev_js_toolbox_title', 'FR', "Boîte à outils JavaScript :");


// Functions list selector
___('dev_functions_list_title',             'EN', "Functions:");
___('dev_functions_list_title',             'FR', "Fonctions :");
___('dev_functions_selector_database',      'EN', "Database");
___('dev_functions_selector_database',      'FR', "Base de données");
___('dev_functions_selector_dates',         'EN', "Dates & Time");
___('dev_functions_selector_dates',         'FR', "Dates & Temps");
___('dev_functions_selector_numbers',       'EN', "Numbers & Math");
___('dev_functions_selector_numbers',       'FR', "Nombres & Mathématiques");
___('dev_functions_selector_sanitization',  'EN', "Sanitization");
___('dev_functions_selector_sanitization',  'FR', "Assainissement");
___('dev_functions_selector_strings',       'EN', "Strings");
___('dev_functions_selector_strings',       'FR', "Chaînes de caractères");
___('dev_functions_selector_unsorted',      'EN', "Unsorted");
___('dev_functions_selector_unsorted',      'FR', "Divers");
___('dev_functions_selector_users',         'EN', "Users");
___('dev_functions_selector_users',         'FR', "Utilisateurs");
___('dev_functions_selector_website',       'EN', "Website internals");
___('dev_functions_selector_website',       'FR', "Éléments internes");


// Development workflow: Common words
___('dev_workflow_branch',  'EN', "branch");
___('dev_workflow_branch',  'FR', "branche");
___('dev_workflow_tag',     'EN', "tag");
___('dev_workflow_tag',     'FR', "tag");


// Development workflow: Preliminary checks
___('dev_workflow_preliminary_title', 'EN', "Preliminary checks");
___('dev_workflow_preliminary_title', 'FR', "Vérifications en amont");
___('dev_workflow_preliminary_body',  'EN', <<<EOT
Resets the repository to its remote state. Ensure that everything looks correct.
EOT
);
___('dev_workflow_preliminary_body',  'FR', <<<EOT
Met le dépôt local dans le même état que le dépôt distant. S'assurer que tout ait l'air correct.
EOT
);


// Development workflow: New branch
___('dev_workflow_branch_title',  'EN', "Working in a new branch");
___('dev_workflow_branch_title',  'FR', "Travailler dans une nouvelle branche");
___('dev_workflow_branch_body',   'EN', <<<EOT
Name the branch in an explicit way, related to the work being done.<br>
If in doubt, the corresponding task number can be used as the branch name.
EOT
);
___('dev_workflow_branch_body',   'FR', <<<EOT
Nommer la branche de façon explicite, en lien avec le travail qui y est accompli.<br>
En cas de doute, le numéro de tâche correspondant peut servir de nom de branche.
EOT
);


// Development workflow: Publishing code
___('dev_workflow_commit_title',  'EN', "Publishing code changes");
___('dev_workflow_commit_title',  'FR', "Publier le code modifié");
___('dev_workflow_commit_body',   'EN', <<<EOT
Commits should have descriptive messages, using the present tense and a neutral tone.<br>
<span class="italics">fix version numbering ; correct spelling in tasks ; add a new page to quotes</span><br>
<br>
If the branch solves multiple tasks, start the commit messages with a task ID<br>
<span class="italics">584: create the development workflow page</span>
EOT
);
___('dev_workflow_commit_body',   'FR', <<<EOT
Les commits doivent avoir un message clair en anglais, au présent, sur un ton neutre.<br>
<span class="italics">fix version numbering ; correct spelling in tasks ; add a new page to quotes</span><br>
<br>
Si la branche résout plusieurs tâches, commencer les messages par l'ID des tâches<br>
<span class="italics">584: create the development workflow page</span>
EOT
);


// Development workflow: Testing
___('dev_workflow_testing_title', 'EN', "Testing and deploying the code");
___('dev_workflow_testing_title', 'FR', "Tester et déployer le code");
___('dev_workflow_testing_body',  'EN', <<<EOT
Test locally in dark/light mode, in english/french, and with guest/user/mod/admin access rights.<br>
Once ready to deploy, optionally {{external|https://nobleme.com/pages/dev/close_website|close the website}} if necessary.<br>
Deploy the files to production, run {{external|https://nobleme.com/pages/dev/queries|SQL queries in production}} if necessary.<br>
Test the production environment and ensure that everything is working as expected.<br>
If the website was closed, {{external|https://nobleme.com/pages/dev/close_website|re-open the website}}.
EOT
);
___('dev_workflow_testing_body',  'FR', <<<EOT
Tester localement en mode sombre/clair, en français/anglais, en tant que guest/user/mod/admin.<br>
Une fois le code prêt à être déployé, optionnellement {{external|https://nobleme.com/pages/dev/close_website|fermer le site}} si nécessaire.<br>
Déployer les fichiers en production, exécuter {{external|https://nobleme.com/pages/dev/queries|les requêtes SQL en production}} si nécessaire.<br>
Tester l'environnement de production et vérifier que tout fonctionne bien comme prévu.<br>
Si le site a été fermé, {{external|https://nobleme.com/pages/dev/close_website|ré-ouvrir le site}}.
EOT
);

// Development workflow: Pull request
___('dev_workflow_pr_title',  'EN', "Pull request on GitHub");
___('dev_workflow_pr_title',  'FR', "Pull request sur GitHub");
___('dev_workflow_pr_body_1', 'EN', <<<EOT
On {{external|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|NoBleme's pull requests GitHub page}}, create a pull request for the corresponding branch.<br>
Merge the branch through the GitHub pull request interface.<br>
<br>
A form will appear when merging, expecting the following information:<br>
Pull request title: <span class="monospace"> Task #\$task_number: \$task_title</span><br>
Pull request description: Link to the task {{external|https://nobleme.com/pages/tasks/list|on the website}}, leave empty if it is a private task.<br>
<br>
Once the PR has been merged, press the "Delete branch" button.<br>
Switch to the `trunk` branch after merging and ensure that everything has been updated locally:
EOT
);
___('dev_workflow_pr_body_1', 'FR', <<<EOT
Créer une pull request pour la branche correspondante dans {{external|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|le dépôt GitHub de NoBleme}}.<br>
Merger la branche via l'interface pull request de GitHub.<br>
<br>
Un formulaire apparaitra au moment de merger, demandant les informations suivantes :<br>
Titre de la pull request: <span class="monospace"> Tâche #\$numéro: \$titre</span><br>
Description de la pull request: Lien vers la tâche {{external|https://nobleme.com/pages/tasks/list|sur NoBleme}}, laisser vide si la tâche est privée.<br>
<br>
Une fois la PR mergée, appuxer sur le bouton « Delete branch ».<br>
Basculer sur `trunk` après avoir mergé et vérifier que tout soit correct localement :
EOT
);
___('dev_workflow_pr_body_2', 'EN', <<<EOT
If there is a straggler branch (if it wasn't deleted locally), delete it:
EOT
);
___('dev_workflow_pr_body_2', 'FR', <<<EOT
Si jamais la branche n'a pas été supprimée localement, la supprimer :
EOT
);


// Development workflow: NoBleme tasks
___('dev_workflow_nobleme_title',   'EN', "Updating the task on NoBleme");
___('dev_workflow_nobleme_title',   'FR', "Mettre à jour la tâche sur NoBleme");
___('dev_workflow_nobleme_body',    'EN', <<<EOT
Find the appropriate task(s) in the {{external|https://nobleme.com/pages/tasks/roadmap|roadmap}} or the {{external|https://nobleme.com/pages/tasks/list|to-do list}} and mark it as solved.<br>
When marking the task as solved, make sure to link to {{external|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|a pull request}} URL and not a commit URL.<br>
EOT
);
___('dev_workflow_nobleme_body',    'FR', <<<EOT
Trouver les tâches sur le {{external|https://nobleme.com/pages/tasks/roadmap|plan de route}} ou la {{external|https://nobleme.com/pages/tasks/list|liste des tâches}} et les marquer comme résolues.<br>
Au moment de la résolution, s'assurer de partager l'URL d'une {{external|https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr|pull request}} et pas celle d'un commit.<br>
EOT
);


// Development workflow: New version
___('dev_workflow_version_title',   'EN', "New version number");
___('dev_workflow_version_title',   'FR', "Nouveau numéro de version");
___('dev_workflow_version_body_1',  'EN', <<<EOT
Only release new version numbers following major changes.<br>
No need to create a new version for hotfixes, tweaks, and cosmetic changes.<br>
Find the next version number to use {{external|https://nobleme.com/pages/dev/versions|on the website}} and confirm it by running <span class="monospace">gitlog</span>.<br>
Tag the new version in the git repository:
EOT
);
___('dev_workflow_version_body_1',  'FR', <<<EOT
Ne créer de nouvelles versions que pour les changements majeurs.<br>
Nul besoin de créer une version pour des hotfixes, ajustements, et modifications cosmétiques.<br>
Trouver le prochain numéro de version {{external|https://nobleme.com/pages/dev/versions|sur NoBleme}} et le vérifier avec la commande <span class="monospace">gitlog</span>.<br>
Créer le tag de la nouvelle version dans le dépôt git :
EOT
);
___('dev_workflow_version_body_2',  'EN', <<<EOT
Ensure that the tag has properly been created and pushed {{external|https://github.com/EricBisceglia/NoBleme.com/tags|on GitHub}}.<br>
Publish the corresponding {{external|https://nobleme.com/pages/dev/versions|version number on NoBleme}}.
EOT
);
___('dev_workflow_version_body_2',  'FR', <<<EOT
S'assurer que le tag a bien été crée et poussé {{external|https://github.com/EricBisceglia/NoBleme.com/tags|sur GitHub}}.<br>
Publier le numéro de version correspondant {{external|https://nobleme.com/pages/dev/versions|sur NoBleme}}.
EOT
);


// Development workflow: Aliases
___('dev_workflow_aliases_title', 'EN', "Git alias reminders");
___('dev_workflow_aliases_title', 'FR', "Rappel des alias git");
___('dev_workflow_aliases_body',  'EN', <<<EOT
These aliases will simplify the git worflow and should be placed in your .bash_profile.<br>
A few of these aliases are needed in order to follow the workflow: <span class="monospace">gitlog, gitpull, gitpush</span>.
EOT
);
___('dev_workflow_aliases_body',  'FR', <<<EOT
Ces alias facilitent le workflow git et sont à mettre dans votre .bash_profile.<br>
Certains de ces alias sont requis pour que le workflow fonctionne : <span class="monospace">gitlog, gitpull, gitpush</span>.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     DEVBLOGS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Devblog list: Header
___('dev_blog_title',     'EN', "Devblog");
___('dev_blog_title',     'FR', "Devblog");
___('dev_blog_subtitle',  'EN', "Updates on NoBleme");
___('dev_blog_subtitle',  'FR', "Nouvelles de NoBleme");
___('dev_blog_intro',     'EN', <<<EOT
These blogs serve as a medium for {{link|pages/users/1|Bad}} to share updates on NoBleme's development, to reflect on the past, to announce plans for the website's future, or to discuss anything NoBleme related in general.
EOT
);
___('dev_blog_intro',     'FR', <<<EOT
Ces blogs servent de plateforme à {{link|pages/users/1|Bad}} dans le but de partager des nouvelles sur le développement de NoBleme, de parler du passé ou du futur du site, ou de discuter de NoBleme en général.
EOT
);


// Devblog list: Table
___('dev_blog_table_title', 'EN', "Title");
___('dev_blog_table_title', 'FR', "Titre");
___('dev_blog_table_date',  'EN', "Publication date");
___('dev_blog_table_date',  'FR', "Date de publication");
___('dev_blog_table_views', 'EN', "Views");
___('dev_blog_table_views', 'FR', "Vues");
___('dev_blog_table_lang',  'EN', "Languages");
___('dev_blog_table_lang',  'FR', "Langues");


// Devblog
___('dev_blog_no_title',  'EN', "Unavailable");
___('dev_blog_no_title',  'FR', "Indisponible");
___('dev_blog_no_body',   'EN', "This devblog is not available in this language.");
___('dev_blog_no_body',   'FR', "Ce devblog n'est pas disponible dans cette langue.");
___('dev_blog_published', 'EN', "Published {{1}} ({{2}})");
___('dev_blog_published', 'FR', "Publié le {{1}} ({{2}})");
___('dev_blog_previous',  'EN', "Previous devblog:");
___('dev_blog_previous',  'FR', "Devblog précédent :");
___('dev_blog_next',      'EN', "Next devblog:");
___('dev_blog_next',      'FR', "Devblog suivant :");


// Devblog: Create
___('dev_blog_add_subtitle',    'EN', "Write a new devblog");
___('dev_blog_add_subtitle',    'FR', "Écrire un nouveau devblog");
___('dev_blog_add_title_en',    'EN', "Title (english)");
___('dev_blog_add_title_en',    'FR', "Titre (anglais)");
___('dev_blog_add_title_fr',    'EN', "Title (french)");
___('dev_blog_add_title_fr',    'FR', "Titre (français)");
___('dev_blog_add_body_en',     'EN', "Body (english) - HTML allowed");
___('dev_blog_add_body_en',     'FR', "Contenu (anglais) - HTML autorisé");
___('dev_blog_add_body_fr',     'EN', "Body (french) - HTML allowed");
___('dev_blog_add_body_fr',     'FR', "Contenu (français) - HTML autorisé");
___('dev_blog_add_submit',      'EN', "Publish devblog");
___('dev_blog_add_submit',      'FR', "Publier le devblog");
___('dev_blog_add_empty',       'EN', "There must be a title in at least one language");
___('dev_blog_add_empty',       'FR', "Il doit y avoir un titre dans au moins une langue");
___('dev_blog_add_empty_en',    'EN', "There is an english title but no body");
___('dev_blog_add_empty_en',    'FR', "Il y a un titre mais pas de contenu en anglais");
___('dev_blog_add_empty_fr',    'EN', "There is a french title but no body");
___('dev_blog_add_empty_fr',    'FR', "Il y a un titre mais pas de contenu en français");
___('dev_blog_add_no_body_en',  'EN', "There is an english body but no title");
___('dev_blog_add_no_body_en',  'FR', "Il y a un contenu mais pas de titre en anglais");
___('dev_blog_add_no_body_fr',  'EN', "There is a french body but no title");
___('dev_blog_add_no_body_fr',  'FR', "Il y a un contenu mais pas de titre en français");


// Devblog: Edit
___('dev_blog_edit_submit', 'EN', "Edit devblog");
___('dev_blog_edit_submit', 'FR', "Modifier le devblog");
___('dev_blog_edit_error',  'EN', "This devblog does not exist or has been deleted");
___('dev_blog_edit_error',  'FR', "Ce devblog n'existe pas ou a été supprimé");


// Devblog: Soft delete
___('dev_blog_delete_confirm',  'EN', "Confirm the soft deletion of this devblog");
___('dev_blog_delete_confirm',  'FR', "Confirmer la suppression non définitive de ce devblog");
___('dev_blog_delete_error',    'EN', "This devblog does not exist or has already been deleted");
___('dev_blog_delete_error',    'FR', "Ce devblog n'existe pas ou a déjà été supprimé");
___('dev_blog_delete_ok',       'EN', "This devblog has been soft deleted");
___('dev_blog_delete_ok',       'FR', "Ce devblog a été supprimé de façon non définitive");


// Devblog: Restore
___('dev_blog_restore_icon',      'EN', "Undelete");
___('dev_blog_restore_icon',      'FR', "Restaurer");
___('dev_blogs_restore_confirm',  'EN', "Confirm the undeletion of this devblog");
___('dev_blogs_restore_confirm',  'FR', "Confirmer la restauration de ce devblog");
___('dev_blog_restore_ok',        'EN', "This devblog has been restored");
___('dev_blog_restore_ok',        'FR', "Ce devblog a été restauré");


// Devblog: Hard delete
___('dev_blog_delete_hard_confirm', 'EN', "Confirm the irreversible permanent deletion of this devblog");
___('dev_blog_delete_hard_confirm', 'FR', "Confirmer la suppression définitive et irréversible de ce devblog");
___('dev_blog_delete_hard_ok',      'EN', "This devblog has been hard deleted");
___('dev_blog_delete_hard_ok',      'FR', "Ce devblog a été définitivement supprimé");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              DUPLICATE TRANSLATIONS                                               */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Duplicate translation list
___('dev_translations_name',  'EN', "Translation");
___('dev_translations_name',  'FR', "Traduction");
___('dev_translations_value', 'EN', "Contents");
___('dev_translations_value', 'FR', "Contenu");
___('dev_translations_none',  'EN', "There are no duplicate translations in the current language");
___('dev_translations_none',  'FR', "Il n'y a aucune traduction en double dans la langue actuelle");