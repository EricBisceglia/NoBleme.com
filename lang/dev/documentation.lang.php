<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   DOCUMENTATION                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Code snippets selector
___('dev_snippets_title',             'EN', "Snippets");
___('dev_snippets_title',             'FR', "Modèles");
___('dev_snippets_selector_full',     'EN', "Full page");
___('dev_snippets_selector_full',     'FR', "Page complète");
___('dev_snippets_selector_fetched',  'EN', "Fetched page");
___('dev_snippets_selector_fetched',  'FR', "Page fetchée");
___('dev_snippets_selector_header',   'EN', "Headers");
___('dev_snippets_selector_header',   'FR', "En-têtes");
___('dev_snippets_selector_blocks',   'EN', "Comment blocks");
___('dev_snippets_selector_blocks',   'FR', "Blocs de commentaires");


// CSS palette selector
___('dev_palette_title',              'EN', "CSS palette");
___('dev_palette_title',              'FR', "Palette CSS");
___('dev_palette_selector_bbcodes',   'EN', "BBCodes");
___('dev_palette_selector_bbcodes',   'FR', "BBCodes");
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
___('dev_palette_selector_spacing',   'FR', "Spacing");
___('dev_palette_selector_tables',    'EN', "Tables");
___('dev_palette_selector_tables',    'FR', "Tableaux");
___('dev_palette_selector_text',      'EN', "Text");
___('dev_palette_selector_text',      'FR', "Texte");
___('dev_palette_selector_tooltips',  'EN', "Tooltips");
___('dev_palette_selector_tooltips',  'FR', "Infobulles");


// JS toolbox selector
___('dev_js_toolbox_title', 'EN', "JavaScript toolbox");
___('dev_js_toolbox_title', 'FR', "Boîte à outils JavaScript");


// Functions list selector
___('dev_functions_list_title',             'EN', "Functions for");
___('dev_functions_list_title',             'FR', "Fonctions pour");
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