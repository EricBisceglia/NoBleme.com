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


// Development workflows selector
___('dev_workflow_selector_git',                'EN', "Git");
___('dev_workflow_selector_git',                'FR', "Git");
___('dev_workflow_selector_server_maintenance', 'EN', "Server maintenance");
___('dev_workflow_selector_server_maintenance', 'FR', "Maintenance serveur");
___('dev_workflow_selector_server_issues',      'EN', "Server issues");
___('dev_workflow_selector_server_issues',      'FR', "Problèmes serveur");
___('dev_workflow_selector_server_setup',       'EN', "Server setup");
___('dev_workflow_selector_server_setup',       'FR', "Installation serveur");
___('dev_workflow_selector_aliases',            'EN', "Aliases");
___('dev_workflow_selector_aliases',            'FR', "Alias");




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