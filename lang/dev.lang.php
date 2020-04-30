<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      QUERIES                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// All's OK
___('dev_queries_ok', 'EN', 'ALL QUERIES HAVE SUCCESSFULLY BEEN RAN');
___('dev_queries_ok', 'FR', 'LES REQUÊTES ONT ÉTÉ EFFECTUÉES AVEC SUCCÈS');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                WEBSITE MANAGEMENT                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Close the website
___('dev_close_website_title', 'EN', 'Open / Close the website');
___('dev_close_website_title', 'FR', 'Ouvrir / Fermer le site');
___('dev_close_website_button', 'EN', 'Toggle');
___('dev_close_website_button', 'FR', 'Changer');


// Version numbers: header
___('dev_versions_title', 'EN', 'Version numbers');
___('dev_versions_title', 'FR', 'Numéros de version');
___('dev_versions_subtitle', 'EN', 'NoBleme Semantic Versioning');
___('dev_versions_subtitle', 'FR', 'NoBleme Semantic Versioning');
___('dev_versions_nbsemver', 'EN', "Given a version number MAJOR.MINOR.PATCH-EXTENSION, increment the:");
___('dev_versions_nbsemver', 'FR', "Étant donné un numéro de version MAJEUR.MINEUR.CORRECTIF-EXTENSION, il faut incrémenter :");
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
___('dev_versions_form_title', 'EN', "Release new version");
___('dev_versions_form_title', 'FR', "Publier une nouvelle version");
___('dev_versions_form_major', 'EN', 'Major');
___('dev_versions_form_major', 'FR', 'Majeur');
___('dev_versions_form_minor', 'EN', 'Minor');
___('dev_versions_form_minor', 'FR', 'Mineur');
___('dev_versions_form_patch', 'EN', 'Patch');
___('dev_versions_form_patch', 'FR', 'Correctif');
___('dev_versions_form_extension', 'EN', 'Extension');
___('dev_versions_form_extension', 'FR', 'Extension');
___('dev_versions_form_activity', 'EN', "Publish in recent activity");
___('dev_versions_form_activity', 'FR', "Publier dans l'activité récente");
___('dev_versions_form_irc', 'EN', "Notify IRC #dev of the new release");
___('dev_versions_form_irc', 'FR', "Notifier IRC #dev de la nouvelle version");
___('dev_versions_form_submit', 'EN', "New release");
___('dev_versions_form_submit', 'FR', "Nouvelle version");


// Version numbers: Table
___('dev_versions_table_title', 'EN', "Version history");
___('dev_versions_table_title', 'FR', "Historique des versions");
___('dev_versions_table_delay', 'EN', "Delay");
___('dev_versions_table_delay', 'FR', "Délai");
___('dev_versions_table_confirm_deletion', 'EN', "Confirm the irreversible deletion of version {{1}}");
___('dev_versions_table_confirm_deletion', 'FR', "Confirmer la suppression irréversible de la version {{1}}");
___('dev_versions_table_deleted', 'EN', "Version {{1}} has been deleted");
___('dev_versions_table_deleted', 'FR', "Version {{1}} supprimée");
___('dev_versions_table_not_existing', 'EN', "This version number does not exist");
___('dev_versions_table_not_existing', 'FR', "Ce numéro de version n'existe pas");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   DOCUMENTATION                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Code snippets selector
___('dev_snippets_title', 'EN', 'Snippets');
___('dev_snippets_title', 'FR', 'Modèles');
___('dev_snippets_selector_full', 'EN', 'Full page');
___('dev_snippets_selector_full', 'FR', 'Page complète');
___('dev_snippets_selector_fetched', 'EN', 'Fetched page');
___('dev_snippets_selector_fetched', 'FR', 'Page fetchée');
___('dev_snippets_selector_header', 'EN', 'Headers');
___('dev_snippets_selector_header', 'FR', 'En-têtes');
___('dev_snippets_selector_blocks', 'EN', 'Comment blocks');
___('dev_snippets_selector_blocks', 'FR', 'Blocs de commentaires');


// CSS palette selector
___('dev_palette_title', 'EN', 'CSS palette');
___('dev_palette_title', 'FR', 'Palette CSS');
___('dev_palette_selector_bbcodes', 'EN', 'BBCodes');
___('dev_palette_selector_bbcodes', 'FR', 'BBCodes');
___('dev_palette_selector_colors', 'EN', 'Colors');
___('dev_palette_selector_colors', 'FR', 'Couleurs');
___('dev_palette_selector_default', 'EN', 'Default');
___('dev_palette_selector_default', 'FR', 'Tags');
___('dev_palette_selector_divs', 'EN', 'Divs');
___('dev_palette_selector_divs', 'FR', 'Divs');
___('dev_palette_selector_forms', 'EN', 'Forms');
___('dev_palette_selector_forms', 'FR', 'Formulaires');
___('dev_palette_selector_grids', 'EN', 'Grids');
___('dev_palette_selector_grids', 'FR', 'Grilles');
___('dev_palette_selector_icons', 'EN', 'Icons');
___('dev_palette_selector_icons', 'FR', 'Icônes');
___('dev_palette_selector_popins', 'EN', 'Popins');
___('dev_palette_selector_popins', 'FR', 'Popins');
___('dev_palette_selector_spacing', 'EN', 'Spacing');
___('dev_palette_selector_spacing', 'FR', 'Spacing');
___('dev_palette_selector_tables', 'EN', 'Tables');
___('dev_palette_selector_tables', 'FR', 'Tableaux');
___('dev_palette_selector_text', 'EN', 'Text');
___('dev_palette_selector_text', 'FR', 'Texte');
___('dev_palette_selector_tooltips', 'EN', 'Tooltips');
___('dev_palette_selector_tooltips', 'FR', 'Infobulles');


// JS toolbox selector
___('dev_js_toolbox_title', 'EN', 'JavaScript toolbox');
___('dev_js_toolbox_title', 'FR', 'Boîte à outils JavaScript');


// Functions list selector
___('dev_functions_list_title', 'EN', 'Functions for');
___('dev_functions_list_title', 'FR', 'Fonctions pour');
___('dev_functions_selector_database', 'EN', 'Database');
___('dev_functions_selector_database', 'FR', 'Base de données');
___('dev_functions_selector_dates', 'EN', 'Dates & Time');
___('dev_functions_selector_dates', 'FR', 'Dates & Temps');
___('dev_functions_selector_numbers', 'EN', 'Numbers & Math');
___('dev_functions_selector_numbers', 'FR', 'Nombres & Mathématiques');
___('dev_functions_selector_sanitization', 'EN', 'Sanitization');
___('dev_functions_selector_sanitization', 'FR', 'Assainissement');
___('dev_functions_selector_strings', 'EN', 'Strings');
___('dev_functions_selector_strings', 'FR', 'Chaînes de caractères');
___('dev_functions_selector_unsorted', 'EN', 'Unsorted');
___('dev_functions_selector_unsorted', 'FR', 'Divers');
___('dev_functions_selector_users', 'EN', 'Users');
___('dev_functions_selector_users', 'FR', 'Utilisateurs');
___('dev_functions_selector_website', 'EN', 'Website internals');
___('dev_functions_selector_website', 'FR', 'Éléments internes');