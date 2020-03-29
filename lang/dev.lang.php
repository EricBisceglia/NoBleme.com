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
/*                                                     SNIPPETS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Section titles
___('dev_snippets_title_blocks', 'EN', 'COMMENT BLOCKS');
___('dev_snippets_title_blocks', 'FR', 'BLOCS DE COMMENTAIRES');
___('dev_snippets_title_header', 'EN', 'HEADERS');
___('dev_snippets_title_header', 'FR', 'EN-TÊTES');
___('dev_snippets_title_full', 'EN', 'FULL PAGE');
___('dev_snippets_title_full', 'FR', 'PAGE COMPLÈTE');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    CSS PALETTE                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Selector
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
___('dev_palette_selector_icons', 'EN', 'Icons');
___('dev_palette_selector_icons', 'FR', 'Icônes');
___('dev_palette_selector_spacing', 'EN', 'Spacing');
___('dev_palette_selector_spacing', 'FR', 'Spacing');
___('dev_palette_selector_tables', 'EN', 'Tables');
___('dev_palette_selector_tables', 'FR', 'Tableaux');
___('dev_palette_selector_text', 'EN', 'Text');
___('dev_palette_selector_text', 'FR', 'Texte');
___('dev_palette_selector_tooltips', 'EN', 'Tooltips');
___('dev_palette_selector_tooltips', 'FR', 'Infobulles');