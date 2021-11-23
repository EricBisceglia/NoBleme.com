<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       INDEX                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Introduction
___('compendium_index_title',   'EN', "Compendium");
___('compendium_index_title',   'FR', "Compendium");
___('compendium_index_subitle', 'EN', "Documenting 21st century culture");
___('compendium_index_subitle', 'FR', "Documentation du 21ème siècle");
___('compendium_index_intro_1', 'EN', <<<EOT
The turn of the century came with a globalization of communication through the spread of the Internet, exposing many people to overwhelming amount of contents - some funny, some good, some sad, some bad.
EOT
);
___('compendium_index_intro_1', 'FR', <<<EOT
Le 21ème siècle et l'avènement d'Internet ont exposé beaucoup de personnes à des quantités écrasantes de contenus, certains drôles ou divertissants, d'autres choquants ou dangereux.
EOT
);
___('compendium_index_intro_2', 'EN', <<<EOT
In this new hyperconnected society, it has become hard to keep up to date with everything. This compendium aims to be a documentation for elements of 21st century culture, making them as accessible as possible to those who are "out of the loop" on specific topics.
EOT
);
___('compendium_index_intro_2', 'FR', <<<EOT
Dans cette nouvelle société hyperconnectée, il est devenu impossible de suivre tous ces nouveaux contenus. Le but de ce compendium est de documenter et démystifier des éléments de la culture du 21ème siècle, en essayant de les rendre aussi accessibles que possible.
EOT
);
___('compendium_index_intro_3', 'EN', <<<EOT
You might be wondering why this compendium has been created, whether it has a deliberate political bias, who runs it, which guidelines it follows, all those questions and more are answered in our {{link|pages/compendium/mission_statement|mission statement}}.
EOT
);
___('compendium_index_intro_3', 'FR', <<<EOT
Si vous vous demandez dans quel but ce compendium a été crée, d'où viennent ses contenus, s'il a un biais politique délibéré, des réponses à ces questions et à d'autres se trouvent dans notre {{link|pages/compendium/mission_statement|foire aux questions}}.
EOT
);
___('compendium_index_intro_4', 'EN', <<<EOT
All of the compendium's contents can be found on the {{link|pages/compendium/page_list|list of all pages}}. Though maybe you would rather get started in your browsing by reading a {{link|pages/compendium/random_page|randomly chosen page}}.
EOT
);
___('compendium_index_intro_4', 'FR', <<<EOT
Toutes les pages du compendium sont listées sur la {{link|pages/compendium/page_list|liste des pages}}, mais peut-être préféreriez-vous commencer votre exploration en lisant une {{link|pages/compendium/random_page|page au hasard}}.
EOT
);


// Recent changes
___('compendium_index_recent_title',    'EN', "Latest updates");
___('compendium_index_recent_title',    'FR', "Nouveau contenu");
___('compendium_index_recent_type',     'EN', "Page type:");
___('compendium_index_recent_type',     'FR', "Thème :");
___('compendium_index_recent_reworked', 'EN', "Reworked");
___('compendium_index_recent_reworked', 'FR', "Modifié");
___('compendium_index_recent_created',  'EN', "Created");
___('compendium_index_recent_created',  'FR', "Crée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  INDIVIDUAL PAGE                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Warnings
___('compendium_page_deleted',  'EN', "This page has been soft deleted. It is not viewable by the general public.");
___('compendium_page_deleted',  'FR', "Cette page a été supprimée de façon non définitive. Elle n'est pas visible par le public.");
___('compendium_page_draft',    'EN', "This page is an unpublished draft. It is not viewable by the general public.");
___('compendium_page_draft',    'FR', "Cette page est un brouillon non publié. Elle n'est pas visible par le public.");
___('compendium_page_no_page',  'EN', "This page has no title in the current language. It is not viewable by the general public.");
___('compendium_page_no_page',  'FR', "Cette page n'a pas de titre dans la langue actuelle. Elle n'est pas visible par le public.");


// Header
___('compendium_page_type',       'EN', "Page type");
___('compendium_page_type',       'FR', "Thème");
___('compendium_page_era',        'EN', "Era");
___('compendium_page_era',        'FR', "Période");
___('compendium_page_category',   'EN', "Category");
___('compendium_page_category',   'FR', "Catégorie");
___('compendium_page_category+',  'EN', "Categories");
___('compendium_page_category+',  'FR', "Catégories");
___('compendium_page_appeared',   'EN', "First appearance");
___('compendium_page_appeared',   'FR', "Première apparition");
___('compendium_page_modified',   'EN', "Page last modified {{1}}");
___('compendium_page_modified',   'FR', "Dernière modification {{1}}");


// Warnings
___('compendium_page_nsfw',       'EN', "This page covers a topic which can be considered not safe for work");
___('compendium_page_nsfw',       'FR', "Cette page couvre un sujet non approprié pour lecture sur un lieu de travail");
___('compendium_page_offensive',  'EN', "This page covers an offensive topic: it is documented here for purely encyclopedic purposes, avoid using it yourself");
___('compendium_page_offensive',  'FR', "Cette page couvre un sujet offensant : il est documenté ici pour des raisons purement encyclopédiques, évitez de l'utiliser");
___('compendium_page_gross',      'EN', "This page contains some gross and/or gore content, read it at your own risk");
___('compendium_page_gross',      'FR', "Cette page inclut du contenu dégueulasse et/ou gore, à lire à vos propres risques");


// Footer
___('compendium_page_list',         'EN', "List of all pages");
___('compendium_page_list',         'FR', "Liste des pages");
___('compendium_page_compendium',   'EN', "NoBleme's 21st century compendium");
___('compendium_page_compendium',   'FR', "Compendium du 21ème siècle de NoBleme");
___('compendium_page_random_page',  'EN', "Another random page");
___('compendium_page_random_page',  'FR', "Autre page au hasard");
___('compendium_page_random_type',  'EN', "Another random {{1}}");
___('compendium_page_random_type',  'FR', "Autre {{1}} au hasard");


// New page
___('compendium_page_new_title',        'EN', "New page");
___('compendium_page_new_title',        'FR', "Nouvelle page");
___('compendium_page_new_url',          'EN', "Page URL (unique, lowercase, no spaces, avoid special characters)");
___('compendium_page_new_url',          'FR', "Adresse de la page (unique, en minuscules, sans espaces, éviter les caractères spéciaux)");
___('compendium_page_new_title_en',     'EN', "Page title (english)");
___('compendium_page_new_title_en',     'FR', "Titre de la page (anglais)");
___('compendium_page_new_title_fr',     'EN', "Page title (french)");
___('compendium_page_new_title_fr',     'FR', "Titre de la page (français)");
___('compendium_page_new_redirect_en',  'EN', "Redirection (english)");
___('compendium_page_new_redirect_en',  'FR', "Redirection (anglais)");
___('compendium_page_new_redirect_fr',  'EN', "Redirection (french)");
___('compendium_page_new_redirect_fr',  'FR', "Redirection (français)");
___('compendium_page_new_summary_en',   'EN', "Page summary (english) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_summary_en',   'FR', "Résumé de la page (anglais) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_summary_fr',   'EN', "Page summary (french) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_summary_fr',   'FR', "Résumé de la page (français) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_body_en',      'EN', "Page contents (english) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_body_en',      'FR', "Contenu de la page (anglais) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_body_fr',      'EN', "Page contents (french) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_body_fr',      'FR', "Contenu de la page (français) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_page_new_type',         'EN', "Page type ({{link_popup|pages/compendium/page_type_admin|Page types}})");
___('compendium_page_new_type',         'FR', "Thématique ({{link_popup|pages/compendium/page_type_admin|Thématiques}})");
___('compendium_page_new_era',          'EN', "Cultural era ({{link_popup|pages/compendium/cultural_era_admin|Eras}})");
___('compendium_page_new_era',          'FR', "Ère culturelle ({{link_popup|pages/compendium/cultural_era_admin|Ères}})");
___('compendium_page_new_appear_year',  'EN', "First appearance year");
___('compendium_page_new_appear_year',  'FR', "Année d'apparition");
___('compendium_page_new_appear_month', 'EN', "First appearance month");
___('compendium_page_new_appear_month', 'FR', "Mois d'apparition");
___('compendium_page_new_peak_year',    'EN', "Peak popularity year");
___('compendium_page_new_peak_year',    'FR', "Année du pic de popularité");
___('compendium_page_new_peak_month',   'EN', "Peak popularity month");
___('compendium_page_new_peak_month',   'FR', "Mois du pic de popularité");
___('compendium_page_new_categories',   'EN', "Categorization ({{link_popup|pages/compendium/category_admin|Categories}}):");
___('compendium_page_new_categories',   'FR', "Classification ({{link_popup|pages/compendium/category_admin|Catégories}}) :");
___('compendium_page_new_nsfw_section', 'EN', "Vulgarity warnings:");
___('compendium_page_new_nsfw_section', 'FR', "Avertissements :");
___('compendium_page_new_nsfw_title',   'EN', "NSFW page title");
___('compendium_page_new_nsfw_title',   'FR', "Titre de page NSFW");
___('compendium_page_new_nsfw',         'EN', "NSFW contents");
___('compendium_page_new_nsfw',         'FR', "Contenu NSFW");
___('compendium_page_new_gross',        'EN', "Gross and/or gore contents");
___('compendium_page_new_gross',        'FR', "Contenu dégueulasse et/ou gore");
___('compendium_page_new_offensive',    'EN', "Offensive contents");
___('compendium_page_new_offensive',    'FR', "Contenu offensant");
___('compendium_pages_new_admin_notes', 'EN', "Admin notes (private)");
___('compendium_pages_new_admin_notes', 'FR', "Notes admin (privées)");
___('compendium_pages_new_admin_urls',  'EN', "Useful URLs, separated by three bars ||| (private)");
___('compendium_pages_new_admin_urls',  'FR', "URLs utiles, séparées par trois barres ||| (privées)");
___('compendium_page_new_draft',        'EN', "The page will be created as a draft: it will not be publicly visible until you publish it.");
___('compendium_page_new_draft',        'FR', "La page crée sera un brouillon : elle ne sera pas visible du public tant que vous ne l'aurez pas publiée.");
___('compendium_page_new_draft_redir',  'EN', "Redirection pages skip the draft stage, they are immediately published.");
___('compendium_page_new_draft_redir',  'FR', "Les redirections ne passent pas par la phase brouillon et sont immédiatement publiées.");
___('compendium_page_new_submit',       'EN', "Create a new page");
___('compendium_page_new_submit',       'FR', "Créer une nouvelle page");
___('compendium_page_new_no_url',       'EN', "Every page must have a unique URL");
___('compendium_page_new_no_url',       'FR', "Chaque page doit avoir une adresse unique");
___('compendium_page_new_no_title',     'EN', "The page must have a title in at least one language");
___('compendium_page_new_no_title',     'FR', "La page doit avoir un titre dans au moins une langue");
___('compendium_page_new_bad_redirect', 'EN', "Redirection points to a non existing page URL");
___('compendium_page_new_bad_redirect', 'FR', "Redirection vers une adresse de page non existante");
___('compendium_page_new_no_type',      'EN', "Every compendium page must have a page type");
___('compendium_page_new_no_type',      'FR', "Toutes les pages du compendium doivent avoir une thématique");
___('compendium_page_new_preview',      'EN', "Preview");
___('compendium_page_new_preview',      'FR', "Prévisualisation");


// Publish a draft
___('compendium_page_draft_icon',     'EN', "Publish draft");
___('compendium_page_draft_icon',     'FR', "Publier le brouillon");
___('compendium_page_draft_title',    'EN', "Publish page");
___('compendium_page_draft_title',    'FR', "Publier la page");
___('compendium_page_draft_name_en',  'EN', "Page name (english):");
___('compendium_page_draft_name_en',  'FR', "Nom de la page (anglais) :");
___('compendium_page_draft_name_fr',  'EN', "Page name (french):");
___('compendium_page_draft_name_fr',  'FR', "Nom de la page (français) :");
___('compendium_page_draft_redir_en', 'EN', "Redirects to (english):");
___('compendium_page_draft_redir_en', 'FR', "Redirige vers (anglais) :");
___('compendium_page_draft_redir_fr', 'EN', "Redirects to (french):");
___('compendium_page_draft_redir_fr', 'FR', "Redirige vers (français) :");
___('compendium_page_draft_activity', 'EN', "Create an entry in {{link_popup|pages/nobleme/activity|recent activity}}");
___('compendium_page_draft_activity', 'FR', "Créer une entrée dans l'{{link_popup|pages/nobleme/activity|activité récente}}");
___('compendium_page_draft_irc',      'EN', "Send a message on IRC");
___('compendium_page_draft_irc',      'FR', "Envoyer un message sur IRC");
___('compendium_page_draft_discord',  'EN', "Send a message on Discord");
___('compendium_page_draft_discord',  'FR', "Envoyer un message sur Discord");
___('compendium_page_draft_submit',   'EN', "Publish the page");
___('compendium_page_draft_submit',   'FR', "Publier la page");


// Edit a page
___('compendium_page_edit_title',       'EN', "Edit page");
___('compendium_page_edit_title',       'FR', "Modifier la page");
___('compendium_page_edit_history_en',  'EN', "Reason for the modification (optional, english)");
___('compendium_page_edit_history_en',  'FR', "Raison de la modification (optional, english)");
___('compendium_page_edit_history_fr',  'EN', "Reason for the modification (optional, french)");
___('compendium_page_edit_history_fr',  'FR', "Raison de la modification (optional, french)");
___('compendium_page_edit_major',       'EN', "This edit is a major modification");
___('compendium_page_edit_major',       'FR', "Cette modification est une modification majeure");
___('compendium_page_edit_submit',      'EN', "Edit the page");
___('compendium_page_edit_submit',      'FR', "Modifier la page");
___('compendium_page_edit_missing',     'EN', "This page does not exist or has been deleted");
___('compendium_page_edit_missing',     'FR', "Cette page n'existe pas ou a été supprimée");


// Delete a page
___('compendium_page_delete_title',   'EN', "Delete page");
___('compendium_page_delete_title',   'FR', "Supprimer la page");
___('compendium_page_delete_soft',    'EN', "This will perform a soft deletion: the page will still exist, but only admins will be able to view it.");
___('compendium_page_delete_soft',    'FR', "Une suppression douce va être effectuée : la page existera toujours, mais ne sera visible que de l'administration.");
___('compendium_page_delete_hard',    'EN', "The page will be hard deleted: it will disappear forever, and will not be recoverable in any way.");
___('compendium_page_delete_hard',    'FR', "Une suppression dure va être effectuée : la page disparaitra à jamais, elle ne sera pas récupérable.");
___('compendium_page_delete_submit',  'EN', "Delete the page");
___('compendium_page_delete_submit',  'FR', "Supprimer la page");


// Restore a deleted page
___('compendium_page_restore_title',  'EN', "Restore a deleted page");
___('compendium_page_restore_title',  'FR', "Restaurer une page supprimée");
___('compendium_page_restore_submit', 'EN', "Restore the page");
___('compendium_page_restore_submit', 'FR', "Restaurer la page");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   PAGE HISTORY                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Error message
___('compendium_page_history_error',  'EN', "This page has no history.");
___('compendium_page_history_error',  'FR', "La page n'a pas d'historique.");
___('compendium_page_history_none',   'EN', "This compendium page's history entry does not exist or has been deleted");
___('compendium_page_history_none',   'FR', "Cette entrée de l'historique de la page du compendium n'existe pas ou a été supprimée");


// Header
___('compendium_page_history_title',  'EN', "Page modification history");
___('compendium_page_history_title',  'FR', "Historique des changements de la page");


// History table
___('compendium_page_history_creation', 'EN', "Page created");
___('compendium_page_history_creation', 'FR', "Création de la page");


// Edit a history entry
___('compendium_page_history_edit_title',   'EN', "Edit the page history entry");
___('compendium_page_history_edit_title',   'FR', "Modifier un élément de l'historique");
___('compendium_page_history_edit_body_en', 'EN', "Change summary (english)");
___('compendium_page_history_edit_body_en', 'FR', "Résumé du changement (anglais)");
___('compendium_page_history_edit_body_fr', 'EN', "Change summary (french)");
___('compendium_page_history_edit_body_fr', 'FR', "Résumé du changement (français)");
___('compendium_page_history_edit_major',   'EN', "Major change");
___('compendium_page_history_edit_major',   'FR', "Changement majeur");
___('compendium_page_history_edit_submit',  'EN', "Edit history entry");
___('compendium_page_history_edit_submit',  'FR', "Modifier l'historique");


// Delete a history entry
___('compendium_page_history_delete', 'EN', "Confirm the permanent and irreversible deletion of this compendium page\'s history entry.");
___('compendium_page_history_delete', 'FR', "Confirmer la suppression définitive et irréversible de cette entrée de l\'historique de la page du compendium.");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     PAGE LIST                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('compendium_list_subtitle', 'EN', "List of all compendium pages");
___('compendium_list_subtitle', 'FR', "Liste des pages du compendium");
___('compendium_list_intro',    'EN', <<<EOT
The table below lists all entries in NoBleme's {{link|pages/compendium/index|21st century compendium}}. If you are looking for specific content, you can use the first rows of the table to sort and filter through the entries.
EOT
);
___('compendium_list_blur',     'EN', <<<EOT
Some page titles might appear blurred due to being considered not safe for work: put your pointer over them to reveal them. If you'd rather see all titles at all times, this feature can be permanently deactivated in your {{link|pages/account/settings_nsfw|adult content options}}.
EOT
);
___('compendium_list_intro',    'FR', <<<EOT
La liste ci-dessous recense toutes les pages du {{link|pages/compendium/index|compendium du 21ème siècle}} de NoBleme. Si vous êtes à la recherche de pages spécifiques, vous pouvez utiliser les premières lignes du tableau pour trier et filtrer son contenu.
EOT
);
___('compendium_list_blur',     'FR', <<<EOT
Certains titres de pages sont floutés, il s'agit de contenus vulgaires ou politiquement incorrects : passez votre curseur dessus pour les révéler. Si vous préféreriez voir tous les contenus sans floutage, cette fonctionnalité peut se désactiver dans vos {{link|pages/account/settings_nsfw|options de vulgarité}}.
EOT
);


// Table
___('compendium_list_title',    'EN', "Page title");
___('compendium_list_title',    'FR', "Titre de la page");
___('compendium_list_theme',    'EN', "Theme");
___('compendium_list_theme',    'FR', "Thème");
___('compendium_list_created',  'EN', "Page created");
___('compendium_list_created',  'FR', "Page crée");
___('compendium_list_appeared', 'EN', "Appeared");
___('compendium_list_appeared', 'FR', "Apparition");
___('compendium_list_peak',     'EN', "Peak popularity");
___('compendium_list_peak',     'FR', "Pic de popularité");
___('compendium_list_count',    'EN', "{{1}} compendium pages");
___('compendium_list_count',    'FR', "{{1}} pages dans le compendium");


// Admin
___('compendium_list_admin_title',            'EN', "Compendium pages");
___('compendium_list_admin_title',            'FR', "Pages du compendium");
___('compendium_list_admin_menu',             'EN', "Page list");
___('compendium_list_admin_menu',             'FR', "Liste des pages");
___('compendium_list_admin_url',              'EN', "Page URL");
___('compendium_list_admin_url',              'FR', "Adresse");
___('compendium_list_admin_redirect',         'EN', "Redirection");
___('compendium_list_admin_redirect',         'FR', "Redirection");
___('compendium_list_admin_redirect_no',      'EN', "Pages");
___('compendium_list_admin_redirect_no',      'FR', "Pages");
___('compendium_list_admin_redirect_yes',     'EN', "Redirections");
___('compendium_list_admin_redirect_yes',     'FR', "Redirections");
___('compendium_list_admin_translated',       'EN', "Translated");
___('compendium_list_admin_translated',       'FR', "Traduit");
___('compendium_list_admin_untranslated',     'EN', "Not translated");
___('compendium_list_admin_untranslated',     'FR', "Non traduit");
___('compendium_list_admin_missing',          'EN', "No title in this language");
___('compendium_list_admin_missing',          'FR', "Pas de titre dans cette langue");
___('compendium_list_admin_categories',       'EN', "Cat.");
___('compendium_list_admin_categories',       'FR', "Cat.");
___('compendium_list_admin_categories_no',    'EN', "Uncategorized");
___('compendium_list_admin_categories_no',    'FR', "Sans catégorie");
___('compendium_list_admin_categories_yes',   'EN', "Categorized");
___('compendium_list_admin_categories_yes',   'FR', "Catégorisé");
___('compendium_list_admin_category_count',   'EN', "Page has {{1}} category");
___('compendium_list_admin_category_count',   'FR', "La page a {{1}} catégorie");
___('compendium_list_admin_category_count+',  'EN', "Page has {{1}} categories");
___('compendium_list_admin_category_count+',  'FR', "La page a {{1}} catégories");
___('compendium_list_admin_appeared',         'EN', "App.");
___('compendium_list_admin_appeared',         'FR', "App.");
___('compendium_list_admin_peak',             'EN', "Peak");
___('compendium_list_admin_peak',             'FR', "Pic");
___('compendium_list_admin_created',          'EN', "Created");
___('compendium_list_admin_created',          'FR', "Crée");
___('compendium_list_admin_language',         'EN', "Lang.");
___('compendium_list_admin_language',         'FR', "Lang.");
___('compendium_list_admin_monolingual',      'EN', "Monolingual");
___('compendium_list_admin_monolingual',      'FR', "Monolangue");
___('compendium_list_admin_bilingual',        'EN', "Bilingual");
___('compendium_list_admin_bilingual',        'FR', "Bilingue");
___('compendium_list_admin_nsfw',             'EN', "NSFW");
___('compendium_list_admin_nsfw',             'FR', "NSFW");
___('compendium_list_admin_safe',             'EN', "Safe");
___('compendium_list_admin_safe',             'FR', "Propre");
___('compendium_list_admin_unsafe',           'EN', "Unsafe");
___('compendium_list_admin_unsafe',           'FR', "Sale");
___('compendium_list_admin_nsfw_title',       'EN', "NSFW title");
___('compendium_list_admin_nsfw_title',       'FR', "Titre NSFW");
___('compendium_list_admin_nsfw_page',        'EN', "NSFW page");
___('compendium_list_admin_nsfw_page',        'FR', "Page NSFW");
___('compendium_list_admin_gross',            'EN', "Gross");
___('compendium_list_admin_gross',            'FR', "Dégueu");
___('compendium_list_admin_offensive',        'EN', "Offensive");
___('compendium_list_admin_offensive',        'FR', "Offensant");
___('compendium_list_admin_wip',              'EN', "DEL.");
___('compendium_list_admin_wip',              'FR', "SUP.");
___('compendium_list_admin_finished',         'EN', "Finished");
___('compendium_list_admin_finished',         'FR', "Complet");
___('compendium_list_admin_draft',            'EN', "Draft");
___('compendium_list_admin_draft',            'FR', "Brouillon");
___('compendium_list_admin_deleted',          'EN', "Deleted");
___('compendium_list_admin_deleted',          'FR', "Supprimé");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       IMAGE                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Warnings
___('compendium_image_deleted',   'EN', "This image has been soft deleted. It is not viewable by the general public.");
___('compendium_image_deleted',   'FR', "Cette image a été supprimée de façon non définitive. Elle n'est pas visible par le public.");
___('compendium_image_nsfw',      'EN', "This image's contents can be considered not safe for work");
___('compendium_image_nsfw',      'FR', "Le contenu de cette image est non approprié pour un lieu de travail");
___('compendium_image_offensive', 'EN', "This image is offensive: it is here for purely encyclopedic purposes, avoid using it yourself");
___('compendium_image_offensive', 'FR', "Cette image est offensante : elle est ici pour des raisons purement encyclopédiques, évitez de l'utiliser hors d'un contexte de documentation");
___('compendium_image_gross',     'EN', "This image contains some gross and/or gore content, watch it at your own risk");
___('compendium_image_gross',     'FR', "Cette image inclut du contenu gore et/ou dégueulasse");


// Privacy message
___('compendium_image_blurred', 'EN', <<<EOT
This image below appears as blurred due to its crude, shocking, or offensive nature. You can unblur it by moving your pointer over the image. Image blurring can be permanently disabled in your {{link|pages/account/settings_nsfw|privacy settings}}.
EOT
);
___('compendium_image_blurred', 'FR', <<<EOT
L'image ci-dessous est floutée de par sa nature vulgaire, choquante, ou offensante. Vous pouvez révéler son contenu en déplaçant votre pointeur sur l'image. Le floutage des images peut être désactivé de façon permanente via vos {{link|pages/account/settings_nsfw|options de vulgarité}}.
EOT
);


// Image usage
___('compendium_image_used',  'EN', "This image is being used on this page:");
___('compendium_image_used',  'FR', "Cette image est utilisée sur cette page :");
___('compendium_image_used+', 'EN', "This image is being used on these pages:");
___('compendium_image_used+', 'FR', "Cette image est utilisée sur ces pages :");


// Disclaimer
___('compendium_image_disclaimer',  'EN', <<<EOT
This image is being hosted here for encyclopedic purposes, as a part of NoBleme's {{link|pages/compendium/index|21st century compendium}}. If you are the author of this image and want it to be removed from this website, contact us by using our {{link|pages/messages/admins|contact form}} and it will be removed from the website.
EOT
);
___('compendium_image_disclaimer',  'FR', <<<EOT
Cette image est présente ici pour des raisons encyclopédiques, en tant qu'élément du {{link|pages/compendium/index|compendium du 21ème siècle}} de NoBleme. Si vous détenez la propriété intellectuelle de cette image et désirez qu'elle soit supprimée, utilisez notre {{link|pages/messages/admins|formulaire de contact}} et nous coopèrerons.
EOT
);


// Footer
___('compendium_image_compendium',  'EN', "21st century compendium");
___('compendium_image_compendium',  'FR', "Compendium du 21ème siècle");
___('compendium_image_random',      'EN', "Another random image");
___('compendium_image_random',      'FR', "Autre image au hasard");


// Image list
___('compendium_image_list_title',      'EN', "Image list");
___('compendium_image_list_title',      'FR', "Images");
___('compendium_image_list_refresh',    'EN', "Recalculate all image usage data");
___('compendium_image_list_refresh',    'FR', "Recalculer les données d'utilisation de toutes les images");
___('compendium_image_list_warning',    'EN', "Recalculating all image usage data could be a long and intensive process, are you sure you want to do this?");
___('compendium_image_list_warning',    'FR', "Recalculer toutes les données d\'utilisation des images peut être un processus long et intensif, tenez-vous réellement à le faire ?");
___('compendium_image_list_copy',       'EN', "Copy");
___('compendium_image_list_copy',       'FR', "Copier");
___('compendium_image_list_name',       'EN', "File name");
___('compendium_image_list_name',       'FR', "Nom du fichier");
___('compendium_image_list_tags',       'EN', "Tags");
___('compendium_image_list_tags',       'FR', "Mots clés");
___('compendium_image_list_used_en',    'EN', "Usage (english)");
___('compendium_image_list_used_en',    'FR', "Utilisation (anglais)");
___('compendium_image_list_used_fr',    'EN', "Usage (french)");
___('compendium_image_list_used_fr',    'FR', "Utilisation (français)");
___('compendium_image_list_uploaded',   'EN', "Uploaded");
___('compendium_image_list_uploaded',   'FR', "Date");
___('compendium_image_list_caption',    'EN', "Text");
___('compendium_image_list_caption',    'FR', "Texte");
___('compendium_image_list_nsfw',       'EN', "NSFW image");
___('compendium_image_list_nsfw',       'FR', "Image NSFW");
___('compendium_image_list_notdeleted', 'EN', "Not deleted");
___('compendium_image_list_notdeleted', 'FR', "Visible");
___('compendium_image_list_count',      'EN', "{{1}} compendium images");
___('compendium_image_list_count',      'FR', "{{1}} images dans le compendium");
___('compendium_image_list_delete',     'EN', "Confirm the soft deletion of this image");
___('compendium_image_list_delete',     'FR', "Confirmer la suppression douce de cette image");
___('compendium_image_list_restore',    'EN', "Confirm the undeletion of this image");
___('compendium_image_list_restore',    'FR', "Confirmer la restoration de cette image");
___('compendium_image_list_hard',       'EN', "Confirm the irreversible deletion of this image");
___('compendium_image_list_hard',       'FR', "Confirmer la suppression irréversible de cette image");
___('compendium_image_list_no_delete',  'EN', "Can\'t delete an image if it is currently in use on a compendium page");
___('compendium_image_list_no_delete',  'FR', "Impossible de supprimer une image tant qu\'elle est utilisée sur une page du compendium");


// Image upload
___('compendium_image_upload_label',      'EN', "Upload a new image");
___('compendium_image_upload_label',      'FR', "Mettre une nouvelle image en ligne");
___('compendium_image_upload_name',       'EN', "File name - lowercase, no spaces");
___('compendium_image_upload_name',       'FR', "Nom du fichier - minuscules, pas d'espaces");
___('compendium_image_upload_tags',       'EN', "Image tags separated by ; semicolons");
___('compendium_image_upload_tags',       'FR', "Mots clés séparés par des ; point-virgules");
___('compendium_image_upload_caption_en', 'EN', "English caption ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_image_upload_caption_en', 'FR', "Légende en anglais ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_image_upload_caption_fr', 'EN', "French caption ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_image_upload_caption_fr', 'FR', "Légende en français ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_image_upload_nsfw',       'EN', "Image is NSFW");
___('compendium_image_upload_nsfw',       'FR', "L'image est NSFW");
___('compendium_image_upload_gross',      'EN', "Image contents are gross");
___('compendium_image_upload_gross',      'FR', "L'image est dégueulasse");
___('compendium_image_upload_offensive',  'EN', "Image contents are offensive");
___('compendium_image_upload_offensive',  'FR', "L'image est offensante");
___('compendium_image_upload_submit',     'EN', "Add image to compendium");
___('compendium_image_upload_submit',     'FR', "Ajouter l'image au compendium");
___('compendium_image_upload_missing',    'EN', "This image can't be uploaded");
___('compendium_image_upload_missing',    'FR', "Cette image ne peut pas être mise en ligne");
___('compendium_image_upload_error',      'EN', "An error happened during the upload");
___('compendium_image_upload_error',      'FR', "Une erreur a eu lieu lors de la mise en ligne");
___('compendium_image_upload_misnamed',   'EN', "Incorrect image name");
___('compendium_image_upload_misnamed',   'FR', "Nom d'image incorrect");
___('compendium_image_upload_duplicate',  'EN', "An image with this file name already exists");
___('compendium_image_upload_duplicate',  'FR', "Une image avec ce nom de fichier existe déjà");
___('compendium_image_upload_filename',   'EN', "This file name is already being used by another image");
___('compendium_image_upload_filename',   'FR', "Ce nom de fichier est déjà utilisé par une autre image");
___('compendium_image_upload_failed',     'EN', "Image upload failed");
___('compendium_image_upload_failed',     'FR', "La mise en ligne de l'image a échoué");
___('compendium_image_upload_ok',         'EN', "The image was successfully uploaded");
___('compendium_image_upload_ok',         'FR', "L'image a bien été mise en ligne");


// Edit image
___('compendium_image_edit_title',      'EN', "Edit {{1}}");
___('compendium_image_edit_title',      'FR', "Modifier {{1}}");
___('compendium_image_edit_submit',     'EN', "Edit image");
___('compendium_image_edit_submit',     'FR', "Modifier l'image");
___('compendium_image_edit_missing',    'EN', "This image does not exist or has been deleted");
___('compendium_image_edit_missing',    'FR', "L'image n'existe pas ou a été supprimée");
___('compendium_image_edit_not_found',  'EN', "The image file can not be found");
___('compendium_image_edit_not_found',  'FR', "Le fichier de l'image n'existe pas");
___('compendium_image_edit_no_rename',  'EN', "The image file could not be renamed");
___('compendium_image_edit_no_rename',  'FR', "Impossible de renommer le fichier de l'image");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   MISSING PAGES                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Missing pages list
___('compendium_missing_admin_menu',    'EN', "Missing");
___('compendium_missing_admin_menu',    'FR', "Manquant");
___('compendium_missing_title',         'EN', "Missing pages");
___('compendium_missing_title',         'FR', "Pages manquantes");
___('compendium_missing_page',          'EN', "Title");
___('compendium_missing_page',          'FR', "Titre");
___('compendium_missing_notes',         'EN', "Notes");
___('compendium_missing_notes',         'FR', "Notes");
___('compendium_missing_no_notes',      'EN', "No notes");
___('compendium_missing_no_notes',      'FR', "Pas de notes");
___('compendium_missing_documented',    'EN', "Documented");
___('compendium_missing_documented',    'FR', "Documenté");
___('compendium_missing_undocumented',  'EN', "Undocumented");
___('compendium_missing_undocumented',  'FR', "Non documenté");
___('compendium_missing_count',         'EN', "{{1}} documented missing pages");
___('compendium_missing_count',         'FR', "{{1}} pages à créer documentées");
___('compendium_missing_uncount',       'EN', "{{1}} undocumented missing pages");
___('compendium_missing_uncount',       'FR', "{{1}} pages à créer non documentées");


// Missing page
___('compendium_missing_page_title',  'EN', "Missing page");
___('compendium_missing_page_title',  'FR', "Page manquante");
___('compendium_missing_page_links',  'EN', "Dead links to this missing page:");
___('compendium_missing_page_links',  'FR', "Liens morts vers cette page manquante :");
___('compendium_missing_page_none',   'EN', "This missing page is not called by any existing compendium page or image.");
___('compendium_missing_page_none',   'FR', "Cette page manquante n'est appelée par aucune page ou image.");


// Edit a missing page
___('compendium_missing_edit_create',   'EN', "New missing page");
___('compendium_missing_edit_create',   'FR', "Nouvelle page manquante");
___('compendium_missing_edit_title',    'EN', "Edit missing page");
___('compendium_missing_edit_title',    'FR', "Modifier une page manquante");
___('compendium_missing_edit_url',      'EN', "Missing page URL (no spaces, must not be taken)");
___('compendium_missing_edit_url',      'FR', "Adresse de la page manquante (ne doit pas être déjà utilisé)");
___('compendium_missing_edit_name',     'EN', "Missing page title");
___('compendium_missing_edit_name',     'FR', "Titre de la page manquante");
___('compendium_missing_edit_notes',    'EN', "Notes ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_missing_edit_notes',    'FR', "Notes ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_missing_edit_no_url',   'EN', "An URL must be provided");
___('compendium_missing_edit_no_url',   'FR', "La page manquante doit avoir une adresse");
___('compendium_missing_edit_taken',    'EN', "This page URL is already taken by an existing page");
___('compendium_missing_edit_taken',    'FR', "Cette adresse est déjà utilisée par une page existante");
___('compendium_missing_edit_double',   'EN', "A missing page with this URL already exists");
___('compendium_missing_edit_double',   'FR', "Une page manquante existe déjà pour cette adresse");
___('compendium_missing_edit_deleted',  'EN', "This missing page does not exist or has been deleted");
___('compendium_missing_edit_deleted',  'FR', "Cette page manquante n'existe pas ou a été supprimée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       ERAS                                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Era list: Header
___('compendium_eras_title',    'EN', "Eras");
___('compendium_eras_title',    'FR', "Périodes");
___('compendium_eras_subtitle', 'EN', "21st century culture");
___('compendium_eras_subtitle', 'FR', "Culture du 21ème siècle");
___('compendium_eras_summary',  'EN', <<<EOT
This page is about a {{link|pages/compendium/cultural_era_list|cultural era}}, an arbitrary way to separate {{link|todo_list|meme}} history into time periods.
EOT
);
___('compendium_eras_summary',  'FR', <<<EOT
Cette page concerne une {{link|pages/compendium/cultural_era_list|période}}, un découpage arbitraire de l'histoire des {{link|todo_list|memes}} en ères distinctes.
EOT
);


// Era list: Introduction
___('compendium_eras_intro_1',  'EN', <<<EOT
Time changes all things. Culture is no exception. It evolves, takes various forms over time, picks up new themes and leaves older ones behind. Most of the vocabulary or the sociocultural topics of the 21st century are not locked in time. However memes tend to be a reflection of the time period in which they appeared, which causes a lot of them to age poorly.
EOT
);
___('compendium_eras_intro_1',  'FR', <<<EOT
Le passage du temps affecte tout. La culture n'y échappe pas. Elle évolue, change de forme, abandonne certains sujets pour en adopter d'autres. La plupart du vocabulaire ou des concepts socioculturels propres au 21ème siècle ne sont pas verrouillés dans le temps. Toutefois, les memes ont tendance à être fortement influencés par l'époque à laquelle ils sont crées, ce qui fait que beaucoup d'entre eux vieillissent mal.
EOT
);
___('compendium_eras_intro_2',  'EN', <<<EOT
In order to add context to them, most memes documented in this {{link|pages/compendium/index|compendium}} are linked to an era. These eras are entirely made up for the purpose of this documentation, they are not based on anything other than subjective observations and feelings.
EOT
);
___('compendium_eras_intro_2',  'FR', <<<EOT
Afin de leur donner du contexte, une période est assignée à la plupart des memes documentés dans ce {{link|pages/compendium/index|compendium}}. Ces périodes ne sont pas basées sur des éléments factuels, ce sont des catégories crées artificiellement pour cette documentation, en se basant sur des observations subjectives.
EOT
);
___('compendium_eras_intro_3',  'EN', <<<EOT
The table below presents all eras in chronological order. Click on an era's name to learn more about it and see a list of all memes categorized as being part of this specific era.
EOT
);
___('compendium_eras_intro_3',  'FR', <<<EOT
Le tableau ci-dessous présente les périodes dans l'ordre chronologique. Cliquez sur le nom d'une période pour en apprendre plus à son sujet et voir une liste de tous les memes catégorisés comme en faisant partie.
EOT
);


// Era list: Table
___('compendium_eras_start',    'EN', "Start");
___('compendium_eras_start',    'FR', "Début");
___('compendium_eras_end',      'EN', "End");
___('compendium_eras_end',      'FR', "Fin");
___('compendium_eras_name',     'EN', "Era name");
___('compendium_eras_name',     'FR', "Nom de la période");
___('compendium_eras_entries',  'EN', "Entries");
___('compendium_eras_entries',  'FR', "Pages");


// Era: Header
___('compendium_era_subtitle',  'EN', "Era:");
___('compendium_era_subtitle',  'FR', "Période :");


// Era: Page list
___('compendium_era_pages', 'EN', "Content from this era");
___('compendium_era_pages', 'FR', "Pages issues de cette période");
___('compendium_era_empty', 'EN', <<<EOT
There are currently no pages documenting content from this era. Until this section of the {{link|pages/compendium/index|compendium}} gets filled up, you can browse content from other {{link|pages/compendium/cultural_era_list|eras}}.
EOT
);
___('compendium_era_empty', 'FR', <<<EOT
Il n'y a pour le moment aucune page documentant des contenus issus de cette période. En attendant que cette section du {{link|pages/compendium/index|compendium}} soit remplie, vous pouvez parcourir les autres {{link|pages/compendium/cultural_era_list|périodes}}.
EOT
);


// Era administration
___('compendium_era_admin_name',  'EN', "Full name");
___('compendium_era_admin_name',  'FR', "Nom complet");
___('compendium_era_admin_short', 'EN', "Short name");
___('compendium_era_admin_short', 'FR', "Nom court");


// Create a new era
___('compendium_era_add_title',     'EN', "New era");
___('compendium_era_add_title',     'FR', "Nouvelle période");
___('compendium_era_add_start',     'EN', "Start year");
___('compendium_era_add_start',     'FR', "Année de début");
___('compendium_era_add_end',       'EN', "End year");
___('compendium_era_add_end',       'FR', "Année de fin");
___('compendium_era_add_name_en',   'EN', "Era name (english)");
___('compendium_era_add_name_en',   'FR', "Nom de la période (anglais)");
___('compendium_era_add_name_fr',   'EN', "Era name (french)");
___('compendium_era_add_name_fr',   'FR', "Nom de la période (français)");
___('compendium_era_add_short_en',  'EN', "Short name (english)");
___('compendium_era_add_short_en',  'FR', "Nom court (anglais)");
___('compendium_era_add_short_fr',  'EN', "Short name (french)");
___('compendium_era_add_short_fr',  'FR', "Nom court (français)");
___('compendium_era_add_body_en',   'EN', "Description (english) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_era_add_body_en',   'FR', "Description (anglais) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_era_add_body_fr',   'EN', "Description (french) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_era_add_body_fr',   'FR', "Description (français) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_era_add_submit',    'EN', "Create new era");
___('compendium_era_add_submit',    'FR', "Créer la période");
___('compendium_era_add_no_name',   'EN', "Eras must have a name and a short name in both languages");
___('compendium_era_add_no_name',   'FR', "Les périodes doivent avoir un nom et un nom court dans les deux langues");


// Edit an era
___('compendium_era_edit_title',  'EN', "Edit an era");
___('compendium_era_edit_title',  'FR', "Modifier la période");
___('compendium_era_edit_submit', 'EN', "Edit era");
___('compendium_era_edit_submit', 'FR', "Modifier la période");
___('compendium_era_edit_error',  'EN', "The era doesn't exist or has been deleted");
___('compendium_era_edit_error',  'FR', "La période n'existe pas ou a été supprimée");


// Delete an era
___('compendium_era_delete_confirm',    'EN', "Confirm the irreversible deletion of this era");
___('compendium_era_delete_confirm',    'FR', "Confirmer la suppression irréversible de cette période");
___('compendium_era_delete_impossible', 'EN', "Eras with any page linked to them can not be deleted");
___('compendium_era_delete_impossible', 'FR', "Impossible de supprimer une période tant qu'une page y est liée");
___('compendium_era_delete_ok',         'EN', "The era has successfully been deleted");
___('compendium_era_delete_ok',         'FR', "La période a bien été supprimée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    CATEGORIES                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Category list: Header
___('compendium_categories_title',    'EN', "Categories");
___('compendium_categories_title',    'FR', "Catégories");
___('compendium_categories_intro',    'EN', <<<EOT
This {{link|pages/compendium/index|compendium}} is full of varied content. In order to keep everything organized, some pages are categorized as belonging to one or more category. All the categories used to classify compendium pages are lited in the table below, along with the number of pages belonging to each category. If you are looking to browse specific types of content, then click on a category's name to learn more about it and see a list of all pages belonging to it.
EOT
);
___('compendium_categories_intro',    'FR', <<<EOT
Ce {{link|pages/compendium/index|compendium}} est rempli de contenu varié. Afin d'organiser ce contenu, une ou plusieurs catégories sont assignées à certaines pages. Le tableau ci-dessous contient toutes les catégories, ainsi que le nombre de pages appartenant à chaque catégorie. Vous pouvez cliquer sur le nom d'une catégorie pour en apprendre plus à son sujet et voir la liste des pages y correspondant.
EOT
);


// Category list: Table
___('compendium_categories_name', 'EN', "Category");
___('compendium_categories_name', 'FR', "Catégorie");


// Category: Header
___('compendium_category_subtitle', 'EN', "Category:");
___('compendium_category_subtitle', 'FR', "Catégorie :");
___('compendium_category_summary',  'EN', <<<EOT
Content is {{link|pages/compendium/category_list|categorized}} in order to keep this compendium organized, more on this in the {{link|pages/compendium/category_list|category list}}.
EOT
);
___('compendium_category_summary',  'FR', <<<EOT
Le contenu du compendium est organisé en catégories, vous pouvez en voir plus sur la {{link|pages/compendium/category_list|liste des catégories}}.
EOT
);


// Category: Page list
___('compendium_category_pages',  'EN', "Content from this category");
___('compendium_category_pages',  'FR', "Pages issues de cette catégorie");
___('compendium_category_empty',  'EN', <<<EOT
There are currently no pages belonging to this category. Until this section of the {{link|pages/compendium/index|compendium}} gets filled up, you can browse content from other {{link|pages/compendium/category_list|categories}}.
EOT
);
___('compendium_category_empty',  'FR', <<<EOT
Il n'y a pour le moment aucune page appartenant à cette catégorie. En attendant que cette section du {{link|pages/compendium/index|compendium}} soit remplie, vous pouvez parcourir les autres {{link|pages/compendium/category_list|catégories}}.
EOT
);


// Category administration
___('compendium_category_admin_order',          'EN', "Order");
___('compendium_category_admin_order',          'FR', "Ordre");
___('compendium_category_admin_uncategorized',  'EN', "Uncategorized pages");
___('compendium_category_admin_uncategorized',  'FR', "Pages non catégorisées");


// Create a new category
___('compendium_category_add_title',    'EN', "New category");
___('compendium_category_add_title',    'FR', "Nouvelle catégorie");
___('compendium_category_add_name_en',  'EN', "Category name (english)");
___('compendium_category_add_name_en',  'FR', "Nom de la catégorie (anglais)");
___('compendium_category_add_name_fr',  'EN', "Category name (french)");
___('compendium_category_add_name_fr',  'FR', "Nom de la catégorie (français)");
___('compendium_category_add_body_en',  'EN', "Description (english) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_category_add_body_en',  'FR', "Description (anglais) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_category_add_body_fr',  'EN', "Description (french) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_category_add_body_fr',  'FR', "Description (français) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_category_add_order',    'EN', "Display order");
___('compendium_category_add_order',    'FR', "Ordre d'affichage");
___('compendium_category_add_submit',   'EN', "Create new category");
___('compendium_category_add_submit',   'FR', "Créer la catégorie");
___('compendium_category_add_no_name',  'EN', "Categories must have a name in both languages");
___('compendium_category_add_no_name',  'FR', "Les catégories doivent avoir un nom dans les deux langues");


// Edit a category
___('compendium_category_edit_title',   'EN', "Edit a category");
___('compendium_category_edit_title',   'FR', "Modifier la catégorie");
___('compendium_category_edit_submit',  'EN', "Edit category");
___('compendium_category_edit_submit',  'FR', "Modifier la catégorie");
___('compendium_category_edit_error',   'EN', "The category doesn't exist or has been deleted");
___('compendium_category_edit_error',   'FR', "La catégorie n'existe pas ou a été supprimée");


// Delete a category
___('compendium_category_delete_confirm',     'EN', "Confirm the irreversible deletion of this category");
___('compendium_category_delete_confirm',     'FR', "Confirmer la suppression irréversible de cette catégorie");
___('compendium_category_delete_impossible',  'EN', "Categories with any page linked to them can not be deleted");
___('compendium_category_delete_impossible',  'FR', "Impossible de supprimer une catégorie tant qu'une page y est liée");
___('compendium_category_delete_ok',          'EN', "The category has successfully been deleted");
___('compendium_category_delete_ok',          'FR', "La catégorie a bien été supprimée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     PAGE TYPES                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Types list: Header
___('compendium_types_title',   'EN', "Page types");
___('compendium_types_title',   'FR', "Thématiques");
___('compendium_types_intro_1', 'EN', <<<EOT
In this {{link|pages/compendium/index|compendium}}, various different types of contents are covered. Some of you might be looking solely for the light hearted entertainment of memes, while others will desire a deep dive into more serious sociocultural topics. In order to let you find the contents you are looking for, each page is assigned a <span class="italics">type</span>.
EOT
);
___('compendium_types_intro_1', 'FR', <<<EOT
Des contenus variés sont documentés dans ce {{link|pages/compendium/index|compendium}}. Si vous êtes uniquement à la recherche de la légèreté des memes, ou au contraire désirez spécifiquement plonger dans les sujets socioculturels sérieux, un <span class="italics">thème</span> est assigné à chaque page afin que vous puissiez trouver et parcourir les contenus qui vous intéressent.
EOT
);
___('compendium_types_intro_2', 'EN', <<<EOT
Below is a list of all the page types along with the number of pages belonging to each type. Click on a page type to read more about it.
EOT
);
___('compendium_types_intro_2', 'FR', <<<EOT
Le tableau ci-dessous liste les thèmatiques abordées dans le compendium, ainsi que le nombre de pages correspondant à chaque thématique. Cliquez sur le nom d'un thème pour en lire plus à son sujet.
EOT
);


// Types list: Table
___('compendium_types_name',  'EN', "Page type");
___('compendium_types_name',  'FR', "Thème");


// Type: Header
___('compendium_type_subtitle', 'EN', "Page type:");
___('compendium_type_subtitle', 'FR', "Thématique :");
___('compendium_type_summary',  'EN', <<<EOT
Pages are each given a {{link|pages/compendium/page_type_list|type}} in order to keep this compendium organized, more on this in the {{link|pages/compendium/page_type_list|page type list}}.
EOT
);
___('compendium_type_summary',  'FR', <<<EOT
Une {{link|pages/compendium/page_type_list|thématique}} est assignée à chaque page, vous pouvez en voir plus à ce sujet sur la {{link|pages/compendium/page_type_list|liste des thèmes}}.
EOT
);


// Type: Page list
___('compendium_type_pages',  'EN', "Content of this type");
___('compendium_type_pages',  'FR', "Pages ayant cette thématique");
___('compendium_type_empty',  'EN', <<<EOT
There are currently no pages of this type. Until this section of the {{link|pages/compendium/index|compendium}} gets filled up, you can browse content from other {{link|pages/compendium/page_type_list|page types}}.
EOT
);
___('compendium_type_empty',  'FR', <<<EOT
Il n'y a pour le moment aucune page ayant ce thème. En attendant que cette section du {{link|pages/compendium/index|compendium}} soit remplie, vous pouvez parcourir les autres {{link|pages/compendium/page_type_list|thématiques}}.
EOT
);


// Type administration
___('compendium_type_admin_short',  'EN', "Page type");
___('compendium_type_admin_short',  'FR', "Thématique");
___('compendium_type_admin_long',   'EN', "Full name");
___('compendium_type_admin_long',   'FR', "Nom complet");


// Create a new page type
___('compendium_type_add_title',    'EN', "New page type");
___('compendium_type_add_title',    'FR', "Nouvelle thématique");
___('compendium_type_add_name_en',  'EN', "Type name (english)");
___('compendium_type_add_name_en',  'FR', "Nom du thème (anglais)");
___('compendium_type_add_name_fr',  'EN', "Type name (french)");
___('compendium_type_add_name_fr',  'FR', "Nom du thème (français)");
___('compendium_type_add_full_en',  'EN', "Full name (english)");
___('compendium_type_add_full_en',  'FR', "Nom complet (anglais)");
___('compendium_type_add_full_fr',  'EN', "Full name (french)");
___('compendium_type_add_full_fr',  'FR', "Nom complet (français)");
___('compendium_type_add_body_en',  'EN', "Description (english) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_type_add_body_en',  'FR', "Description (anglais) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_type_add_body_fr',  'EN', "Description (french) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_type_add_body_fr',  'FR', "Description (français) ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_type_add_submit',   'EN', "Create new page type");
___('compendium_type_add_submit',   'FR', "Créer la thématique");
___('compendium_type_add_no_name',  'EN', "Page types must have a name and a full name in both languages");
___('compendium_type_add_no_name',  'FR', "Les thématiques doivent avoir un nom et un nom complet dans les deux langues");


// Edit a page type
___('compendium_type_edit_title',     'EN', "Edit a page type");
___('compendium_type_edit_title',     'FR', "Modifier la thématique");
___('compendium_type_edit_submit',    'EN', "Edit page type");
___('compendium_type_edit_submit',    'FR', "Modifier la thématique");
___('compendium_type_edit_error',     'EN', "The page type doesn't exist or has been deleted");
___('compendium_type_edit_error',     'FR', "La thématique n'existe pas ou a été supprimée");


// Delete a page type
___('compendium_type_delete_confirm',     'EN', "Confirm the irreversible deletion of this page type");
___('compendium_type_delete_confirm',     'FR', "Confirmer la suppression irréversible de cette thématique");
___('compendium_type_delete_impossible',  'EN', "Page types with any page linked to them can not be deleted");
___('compendium_type_delete_impossible',  'FR', "Impossible de supprimer une thématique tant qu'une page y est liée");
___('compendium_type_delete_ok',          'EN', "The page type has successfully been deleted");
___('compendium_type_delete_ok',          'FR', "La thématique a bien été supprimée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    ADMIN TOOLS                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Admin menu
___('compendium_admin_menu_title',  'EN', "Compendium administration");
___('compendium_admin_menu_title',  'FR', "Administration du compendium");


// Admin notes
___('compendium_admin_notes_title',       'EN', "Admin notes");
___('compendium_admin_notes_title',       'FR', "Notes admin");
___('compendium_admin_notes_global',      'EN', "Global notes");
___('compendium_admin_notes_global',      'FR', "Notes globales");
___('compendium_admin_notes_snippets',    'EN', "Useful snippets");
___('compendium_admin_notes_snippets',    'FR', "Bribes utiles");
___('compendium_admin_notes_template_en', 'EN', "English template ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_admin_notes_template_en', 'FR', "Modèle anglophone ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_admin_notes_template_fr', 'EN', "French template ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_admin_notes_template_fr', 'FR', "Modèle francophone ({{link_popup|pages/doc/bbcodes|NBCodes}})");
___('compendium_admin_notes_submit',      'EN', "Update admin notes");
___('compendium_admin_notes_submit',      'FR', "Mettre à jour les notes admin");
___('compendium_admin_notes_page',        'EN', "Compendium page");
___('compendium_admin_notes_page',        'FR', "Page du compendium");
___('compendium_admin_notes_text',        'EN', "Page notes");
___('compendium_admin_notes_text',        'FR', "Notes sur la page");
___('compendium_admin_notes_url',         'EN', "Related links");
___('compendium_admin_notes_url',         'FR', "Liens");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 MISSION STATEMENT                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('compendium_faq_subtitle',  'EN', "Mission statement: methods and goals");
___('compendium_faq_subtitle',  'FR', "Foire aux questions (courtes et simples)");
___('compendium_faq_intro',     'EN', <<<EOT
Using a Q&A format, this page will attempt to answer some of the questions you might have about NoBleme's {{link|pages/compendium/index|21st century compendium}}'s goals and methods. Instead of needlessly going deep into detail, it will be a series of simple questions with quick answers. Any further questions you have can be answered by interacting with NoBleme's community on our {{link|pages/social/irc|IRC chat}} or {{link|pages/social/discord|Discord server}}.
EOT
);
___('compendium_faq_intro',     'FR', <<<EOT
En utilisant un format questions/réponses, cette page tentera de répondre à certaines des questions que vous pouvez avoir au sujet du {{link|pages/compendium/index|compendium du 21ème siècle}}. Plutôt que de rentrer dans les détails, il s'agit de questions simples et de réponses concises. S'il vous reste d'autres questions auxquelles cette page ne répond pas, vous pouvez venir les poser à la communauté de NoBleme sur notre {{link|pages/social/irc|chat IRC}} ou notre {{link|pages/social/discord|serveur Discord}}.
EOT
);
___('compendium_faq_contents',  'EN', "Table of contents:");
___('compendium_faq_contents',  'FR', "Sommaire des questions :");


// Questions
___('compendium_faq_question_1',  'EN', "What will I find in this compendium?");
___('compendium_faq_question_1',  'FR', "Que trouverais-je dans ce compendium ?");
___('compendium_faq_question_2',  'EN', "What are the compendium's goals?");
___('compendium_faq_question_2',  'FR', "Quels sont les objectifs de ce compendium ?");
___('compendium_faq_question_3',  'EN', "Is there a language / culture bias?");
___('compendium_faq_question_3',  'FR', "Y a-t-il un biais culturel / linguistique ?");
___('compendium_faq_question_4',  'EN', "Is there a deliberate political leaning?");
___('compendium_faq_question_4',  'FR', "Y a-t-il un biais politique délibéré ?");
___('compendium_faq_question_5',  'EN', "Is there a long term vision?");
___('compendium_faq_question_5',  'FR', "Y a-t-il une vision à long terme ?");
___('compendium_faq_question_6',  'EN', "Who writes the articles / pages?");
___('compendium_faq_question_6',  'FR', "Qui écrit les articles / pages ?");
___('compendium_faq_question_7',  'EN', "What are the guidelines for writing content?");
___('compendium_faq_question_7',  'FR', "Quelles consignes sont suivies lors de l'écriture de contenu ?");
___('compendium_faq_question_8',  'EN', "How can you ensure content is properly sourced?");
___('compendium_faq_question_8',  'FR', "Comment s'assurer que tout soit bien sourcé ?");
___('compendium_faq_question_9',  'EN', "How is controversial content handled?");
___('compendium_faq_question_9',  'FR', "Comment le contenu controversé est-il géré ?");
___('compendium_faq_question_10', 'EN', "What makes it different from other similar websites?");
___('compendium_faq_question_10', 'FR', "Qu'est-ce qui différencie ce compendium des autres sites similaires ?");
___('compendium_faq_question_11', 'EN', "Why is the compendium part of NoBleme?");
___('compendium_faq_question_11', 'FR', "Pourquoi ce compendium fait-il partie de NoBleme ?");
___('compendium_faq_question_12', 'EN', "What is NoBleme anyway?");
___('compendium_faq_question_12', 'FR', "Qu'est-ce que NoBleme ?");
___('compendium_faq_question_13', 'EN', "How can I report incorrect content / make a copyright claim?");
___('compendium_faq_question_13', 'FR', "Comment puis-je signaler du contenu incorrect / copyrighté ?");
___('compendium_faq_question_14', 'EN', "Can I help in any way?");
___('compendium_faq_question_14', 'FR', "Puis-je aider d'une façon quelconque ?");
___('compendium_faq_question_15', 'EN', "Where / how can I stay up to date with new content?");
___('compendium_faq_question_15', 'FR', "Où / comment se tenir au courant des futurs contenus ?");


// Answers
___('compendium_faq_answer_1_1',  'EN', <<<EOT
A documentation of elements of 21st century culture.
EOT
);
___('compendium_faq_answer_1_1',  'FR', <<<EOT
Une documentation d'éléments de la culture du 21ème siècle.
EOT
);
___('compendium_faq_answer_1_2',  'EN', <<<EOT
The hyperconnected era ushered in by the advent of the Internet altered both mainstream and underground culture in many ways, which this compendium tries to document as much as possible. Several different {{link|pages/compendium/page_type_list|types}} and {{link|pages/compendium/category_list|categories}} of contents are covered by the compendium. Special attention is given to three types of contents in particular:
EOT
);
___('compendium_faq_answer_1_2',  'FR', <<<EOT
L'avènement d'Internet et d'une nouvelle ère hyperconnectée a modifié la culture populaire de nombreuses façons, que ce compendium essaye de documenter autant que possible. Plusieurs {{link|pages/compendium/page_type_list|thématiques}} et {{link|pages/compendium/category_list|catégories}} de contenus sont documentées, en prêtant une attention particulière aux trois types de contenus suivants:
EOT
);
___('compendium_faq_answer_1_3',  'EN', <<<EOT
<span class="bold">Memes</span> have become an unavoidable source of entertainment and amusement, or sometimes controversy and confusion. Memes are documented with a focus on fun, featuring image and video galleries showcasing how entertaining and creative people can be.
EOT
);
___('compendium_faq_answer_1_3',  'FR', <<<EOT
<span class="bold">Les memes</span> sont devenus une source omniprésente de divertissement et d'amusement, ou parfois de controverse et de confusion. Les memes sont documentés en mettant l'accent sur leur côté divertissant, via des galeries d'images et de vidéos montrant le potentiel de créativité des gens.
EOT
);
___('compendium_faq_answer_1_4',  'EN', <<<EOT
<span class="bold">Slang</span> born or popularized in the 21st century gets featured in short pages explaining their meaning, and sometimes also the hidden meanings which can apear when used in funny or nefarious ways.
EOT
);
___('compendium_faq_answer_1_4',  'FR', <<<EOT
<span class="bold">L'argot</span> propre à la culture du 21ème siècle est documenté dans des pages courtes explicant son sens, et parfois les sens cachés qui peuvent exister lorsque les mots sont utilisés dans un but comique ou néfaste.
EOT
);
___('compendium_faq_answer_1_5',  'EN', <<<EOT
<span class="bold">Sociocultural</span> concepts which people were not aware of before the turn of the 21st century have become mainstream notions as many groups became able to express themselves on platforms that could reach a global audience. The 21st century compendium aims to demystify these sociocultural concepts by explaining them in simple terms, both the good and the bad, whether they belong to the oppressed or the oppressive, in order to explain their history, their meanings, their reach, and their real world consequences.
EOT
);
___('compendium_faq_answer_1_5',  'FR', <<<EOT
<span class="bold">Des concepts socioculturels</span> sont également documentés. Pas tous propres au 21ème siècle, ils se sont popularisés grâce à la libération de la parole au tourant du siècle, Internet permettant à des groupes marginalisés de se faire entendre à une échelle globale. Ce compendium cherche à démystifier ces concepts socioculturels en les expliquant le plus simplement possible, qu'ils soient bons ou mauvais, oppressés ou oppressants, afin d'expliquer leur histoire, leur sens, leur portée, et leurs impacts dans le monde.
EOT
);
___('compendium_faq_answer_1_6',  'EN', <<<EOT
You might believe that these elements do not belong together, but they are fully interconnected. Most memes include slang and use sociocultural concepts as their theme, most sociocultural movements express themselves through slang and memes, and other types of contents covered in this compendium also contain callbacks to the three main themes mentioned above.
EOT
);
___('compendium_faq_answer_1_6',  'FR', <<<EOT
Vous pourriez croire que ces contenus devraient être documentés séparément, mais ils sont inextricablement interconnectés. Les memes utilisent de l'argot et ont des thèmes socioculturels, la plupart des mouvements socioculturels s'expriment via des memes et un argot qui leur est propre, et les autres contenus couverts dans ce compendium référencent régulièrement ces trois types de contenus.
EOT
);


___('compendium_faq_answer_2_1',  'EN', <<<EOT
The 21st century compendium is trying to achieve three different goals.
EOT
);
___('compendium_faq_answer_2_1',  'FR', <<<EOT
Le compendium cherche à atteindre trois objectifs différents.
EOT
);
___('compendium_faq_answer_2_2',  'EN', <<<EOT
First and foremost, it strives to be an encyclopedia of its era. This is nothing unique, other websites are already doing the same thing, some of them much better, which is why there is a focus on quality over quantity. Entries are written at a slow pace, but are exhaustive, properly sourced, and follow strict style and content guidelines.
EOT
);
___('compendium_faq_answer_2_2',  'FR', <<<EOT
Avant tout, son but est d'être une encyclopédie de son époque. Ce n'est rien d'unique, il existe déjà d'autres sites cherchant à accomplir le même but. Nous ne cherchons pas à rivaliser avec ces autres sites, et nous concentrons plutôt sur la qualité que sur la quantité : les pages sont écrites à un rythme lent, mais sont complètes, correctement sourcées, et respectent une ligne directrice unique et clairement définie.
EOT
);
___('compendium_faq_answer_2_3',  'EN', <<<EOT
As a side effect of documenting its era, a secondary goal of this compendium is to help "out of the loop" people understand memes, slang, concepts, etc. which they are not at all or only partly aware of. In order to fulfill this goal, the language is kept simple, pages are short, the reader's limited attention span is always kept in mind.
EOT
);
___('compendium_faq_answer_2_3',  'FR', <<<EOT
En tant que documentation de son époque, un objectif secondaire de ce compendium est d'aider les personnes « hors de la boucle » à comprendre les memes, l'argot, les concepts socioculturels, etc. qui sont nombreux et souvent obscurs à comprendre. Dans ce but, le vocabulaire utilisé reste simple, les pages sont courtes, et l'attention limitée des personnes qui liront les pages est prise en compte lors de leur rédaction.
EOT
);
___('compendium_faq_answer_2_4',  'EN', <<<EOT
Lastly, as sociocultural topics have to be explained when documenting 21st century culture, an effort is also done to try and explain those concepts in the clearest way possible. Having to explain basic concepts to people over and over can be exhausting, we try our best to demystify them in a simple to read and understand format which can be linked to people in order to hopefully relieve some of that burden.
EOT
);
___('compendium_faq_answer_2_4',  'FR', <<<EOT
Troisièmement, vu que des concepts socioculturels doivent être documentés en tant qu'éléments de la culture du 21ème siècle, un effort est fait pour les expliquer de la façon la plus claire possible. Nous savons à quel point devoir expliquer encore et encore les mêmes concepts de base à d'autres personnes peut être épuisant, et espérons que certaines pages de ce compendium pourront vous libérer de ces efforts et vous servir de liens que vous pourrez partager avec les personnes non sensibilisées à ces sujets.
EOT
);

___('compendium_faq_answer_3_1',  'EN', <<<EOT
Yes. Everything in this compendium has been written as perceived through the prism of the english and french speaking world. This means that there is a strong european and american bias to the documented content, and that many non-english and non-french elements of 21st century culture will be missing.
EOT
);
___('compendium_faq_answer_3_1',  'FR', <<<EOT
Oui. Les contenus sont rédigés tels que perçus à travers le prisme du monde francophone et anglophone. Cela signifie qu'il y a un fort biais européen et américain au contenu documenté, et que de nombreux éléments non-francophones et non-anglophones de la culture du 21ème siècle seront manquants.
EOT
);
___('compendium_faq_answer_3_2',  'EN', <<<EOT
Attempts to fix this bias have been made, but led to the realization that it is simply not our place to document other people's cultures without experiencing them firsthand. As this compendium is the work of a single person, it will only cover the experiences relevant to the spheres of influence affecting said person.
EOT
);
___('compendium_faq_answer_3_2',  'FR', <<<EOT
Tenter de corriger ce biais ne ferait qu'amener un nouveau problème : ce n'est tout simplement pas notre rôle de documenter les cultures des autres personnes sans baigner dedans personnellement. Comme ce compendium est l'œuvre d'une seule personne, il ne couvrira que les sphères d'influence affectant la personne en question.
EOT
);
___('compendium_faq_answer_3_3',  'EN', <<<EOT
If you want to alleviate this issue by offering documentation on memes, slangs, sociocultural concepts of your language and/or culture, you can do so using our {{link|pages/messages/admins|contact form}}. We would be delighted with the help. Contributors are credited on the pages which they have contributed to (unless they asked to not be credited).
EOT
);
___('compendium_faq_answer_3_3',  'FR', <<<EOT
Toutefois, si vous voulez nous aider à remédier à ce problème en proposant de la documentation sur des memes, de l'argot, des concepts socioculturels propres à votre langue et/ou culture, vous pouvez le faire via notre {{link|pages/messages/admins|formulaire de contact}}. Nous apprécierons assurément votre aide. Les personnes offrant des contributions sont créditées sur les pages concernées (sauf si elles demandent à rester anonymes).
EOT
);

___('compendium_faq_answer_4_1',  'EN', <<<EOT
Yes. It might seem odd for encyclopedic content to take a political or social stance, but it is the very nature of the content being documented which leaves no choice.
EOT
);
___('compendium_faq_answer_4_1',  'FR', <<<EOT
Oui. Cela peut vous sembler étrange que du contenu encyclopédique soit politisé, mais la nature du contenu documenté ne laisse aucun choix.
EOT
);
___('compendium_faq_answer_4_2',  'EN', <<<EOT
You might think that not everything has to be political, but some people do not have much of a say in this: it is not minorities who made being a woman, black, queer, non-binary, jewish, etc. into a political topic, it is those who abuse their political power to actively discriminate and/or call for discrimination against them.
EOT
);
___('compendium_faq_answer_4_2',  'FR', <<<EOT
Peut-être que le fait que tout ce que vous voyez semble être politisé vous fatigue, mais ce n'est pas du fait des personnes concernées : ce ne sont pas les minorités qui ont décidé qu'être une femme, qu'avoir la peau noire, que d'être non-binaire, que d'avoir une mère juive, etc. sont des sujets politiques. Ce sont les personnes qui discriminent et/ou appellent à la discrimination envers ces groupes qui sont la cause de cet état de fait.
EOT
);
___('compendium_faq_answer_4_3',  'EN', <<<EOT
In topics related to social justice, staying neutral means siding with the statu quo: accepting that the current state of society is fine, including injustices. It is our encyclopedic duty to document them properly, which means actively listening to minorities, and using this compendium as a platform to relay their words.
EOT
);
___('compendium_faq_answer_4_3',  'FR', <<<EOT
Rester neutre politiquement tout en documentant des sujets socioculturels signifierait une acceptation du statu quo : accepter l'état actuel de la société comme une fatalité, incluant ses injustices. C'est notre devoir encyclopédique de documenter ces sujets correctement, ce qui implique d'écouter activement les minorités, et d'utiliser ce compendium comme une plateforme pour transmettre leurs paroles.
EOT
);
___('compendium_faq_answer_4_4',  'EN', <<<EOT
Some people fear that minorities exploit the goodwill of social justice movements in order to further an agenda. This fearmongering is an illusion which we are trying to dispel, by properly documenting not only the causes of social justice movements, but also their actual goals and demands.
EOT
);
___('compendium_faq_answer_4_4',  'FR', <<<EOT
Certaines personnes craignent que des minorités exploitent la bienveillance des mouvements de justice sociale afin d'accomplir des buts cachés néfastes. Cet alarmisme est une illusion que nous essayons de dissiper, en documentant non seulement les causes des mouvements de justice sociale, mais aussi leurs véritables objectifs et revendications.
EOT
);
___('compendium_faq_answer_4_5',  'EN', <<<EOT
If you are in full disagreement with political or social statements made in this compendium, it might be best for you to simply stop reading it. The Internet is a vast landscape with many other websites which might be more appropriate for your needs, and we have no desire to argue about basic empathy with contrarians.
EOT
);
___('compendium_faq_answer_4_5',  'FR', <<<EOT
Si vous êtes en désaccord avec la majorité des prises de position politiques de ce compendium, peut-être vaudrait-il mieux simplement arrêter de le lire. L'Internet est un monde vaste rempli de nombreux autres contenus qui pourraient être plus appropriés pour vos besoins, et nous n'avons aucun désir de débattre d'un sujet aussi simple que l'existence de l'empathie avec des personnes fermées d'esprit.
EOT
);

___('compendium_faq_answer_5_1',  'EN', <<<EOT
No. There are no fixed goals, short or long term, other than writing more content and improving the website.
EOT
);
___('compendium_faq_answer_5_1',  'FR', <<<EOT
Non. Aucun objectif n'a été fixé, à court ou long terme, à part de continuer à écrire plus de contenus.
EOT
);
___('compendium_faq_answer_5_2',  'EN', <<<EOT
Growth and exposure are appreciated, but not needed. Even if this compendium remained lost in its corner of the Internet and was seen by one new person every month, it would be enough to justify its existence. It is a work of passion, not an attempt at wealth or fame.
EOT
);
___('compendium_faq_answer_5_2',  'FR', <<<EOT
La croissance et la popularité sont appréciés, mais pas nécessaires. Même si ce compendium restait perdu dans son coin d'Internet et n'était vu que par une seule nouvelle personne chaque mois, ce serait suffisant pour justifier son existence. C'est une œuvre de passion, pas une tentative d'enrichissement ou de célébrité.
EOT
);

___('compendium_faq_answer_6_1',  'EN', <<<EOT
This compendium is the work of a single person, {{link|todo_link|Eric Bisceglia}}.
EOT
);
___('compendium_faq_answer_6_1',  'FR', <<<EOT
Ce compendium est l'œuvre d'une seule personne, {{link|todo_link|Eric Bisceglia}}.
EOT
);
___('compendium_faq_answer_6_2',  'EN', <<<EOT
Having only one main writer and editor is a deliberate choice in order to maintain quality over quantity. As a consequence, this compendium will never have the same amount of content that other bigger collaborative encyclopedias might have, but it ensures that editorial control is maintained over all of the compendium's contents. It also relieves the main editor from the pressure of having to review other people's contributions when time off is needed for personal reasons, thus mitigating burnout.
EOT
);
___('compendium_faq_answer_6_2',  'FR', <<<EOT
N'avoir qu'une seule personne en charge de la rédaction des contenus est un choix délibéré afin de s'assurer que la qualité prime sur la quantité. En conséquence, il n'y aura jamais autant de contenus dans ce compendium que dans des encyclopédies collaboratives couvrant les mêmes sujets, mais cela garantit que le contrôle éditorial est maintenu sur tous les contenus. Cela permet également d'avoir une très importante tranquillité mentale : la pression éditoriale de devoir examiner en continu les contenus proposés par d'autres personnes n'est pas présente, ce qui permet de faire des pauses à tout moment pour des raisons personnelles sans froisser personne, et ainsi d'éviter le surmenage sur le long terme.
EOT
);
___('compendium_faq_answer_6_3',  'EN', <<<EOT
However, third party contributors are more than welcome. Whether you would like to suggest new content or point out inaccuracies in existing content, you can do so using our {{link|pages/messages/admins|contact form}}. Contributors are credited on the pages which they have contributed to (unless they asked to not be credited).
EOT
);
___('compendium_faq_answer_6_3',  'FR', <<<EOT
Toutefois, les contributions tierces sont encouragées. Que vous vouliez proposer de nouveaux contenus ou signaler des erreurs dans du contenu existant, vous pouvez le faire via notre {{link|pages/messages/admins|formulaire de contact}}. Les personnes offrant des contributions sont créditées sur les pages concernées (sauf si elles demandent à rester anonymes).
EOT
);

___('compendium_faq_answer_7_1',  'EN', <<<EOT
The first and most important guideline is that all content must be short form rather than essays. The goal is to keep the reader's attention from start to finish, anything too lengthy or rambly might lose them halfway.
EOT
);
___('compendium_faq_answer_7_1',  'FR', <<<EOT
La première et plus importante des consignes est que tout le contenu doit être simple et concis plutôt que des dissertations. Le but est de conserver l'attention des personnes qui lisent les pages du début à la fin, un contenu verbeux ou complexe pourrait les perdre en route.
EOT
);
___('compendium_faq_answer_7_2',  'EN', <<<EOT
The second guideline is that everything must be written from the point of view of a reader who is fully "out of the loop", even if it means over-explaining things. The first guideline takes precedence however, explanations must stay short and might need to be skipped at times.
EOT
);
___('compendium_faq_answer_7_2',  'FR', <<<EOT
La seconde consigne est que tout doit être écrit du point de vue de personnes « hors de la boucle », même si cela implique de sur-expliquer certaines choses. La première consigne est toutefois prioritaire, les explications doivent toujours rester concises et peuvent être ignorées si elles rendent le contenu trop indigeste.
EOT
);
___('compendium_faq_answer_7_3',  'EN', <<<EOT
The third guideline is that each content should be documented in a fitting way: image galleries should be the focal point when documenting memes, controversial topics should be presented in a well sourced encyclopedic way, and a Q&A format should be used for complicated topics.
EOT
);
___('compendium_faq_answer_7_3',  'FR', <<<EOT
La troisième consigne est que tous les contenus doivent être documentés d'une façon appropriée : les memes via des galeries d'images, les sujets controversés de façon sourcée et encyclopédique, les sujets compliqués dans un format questions-réponses.
EOT
);
___('compendium_faq_answer_7_4',  'EN', <<<EOT
The fourth guideline is to write entries in a gender neutral way. The default pronoun in use should be `they`, unless referring to specific people.
EOT
);
___('compendium_faq_answer_7_4',  'FR', <<<EOT
La quatrième consigne est d'écrire les textes d'une façon non genrée. Les formes neutres sont préférées plutôt que les points médians ou les terminaisons mixtes (par exemple « les personnes lisant cette page » plutôt que « les lecteurs » ou « les lecteurices »). Cette documentation (et le reste de ce site) sert accessoirement la preuve qu'il est possible d'écrire du français non genré sans grand effort et sans que la lecture en soit pénible.
EOT
);

___('compendium_faq_answer_8_1',  'EN', <<<EOT
The short and honest answer is that you can't always guarantee it.
EOT
);
___('compendium_faq_answer_8_1',  'FR', <<<EOT
La réponse honnête est que c'est parfois impossible.
EOT
);
___('compendium_faq_answer_8_2',  'EN', <<<EOT
Some content can be traced back to its authentic origins, or can be backed up by academic sources. In these cases, it is easy to document said content in a properly sourced way. Sadly, it is impossible to guarantee that the original content has not been appropriated from someone else's work, or that the acamedic sources do not have a bias.
EOT
);
___('compendium_faq_answer_8_2',  'FR', <<<EOT
Certains contenus peuvent être remontés jusqu'à leurs origines authentiques, ou peuvent être soutenus par des études académiques. Malheureusement, même dans ces cas, il est impossible de garantir que le prétendu contenu d'origine n'est pas le produit d'une appropriation, ou que les études académiques ne sont pas biasées.
EOT
);
___('compendium_faq_answer_8_3',  'EN', <<<EOT
As our sources might be unreliable, the documentation will evolve as needed to correct inaccuracies. Please report any incorrect content using our {{link|pages/messages/admins|contact form}}.
EOT
);
___('compendium_faq_answer_8_3',  'FR', <<<EOT
Même si un gros effort est fait pour tout sourcer, les contenus évolueront autant que nécessaire pour corriger les erreurs qui peuvent s'y trouver. Signalez-nous les contenus inexacts ou les sources questionnables via notre {{link|pages/messages/admins|formulaire de contact}}.
EOT
);

___('compendium_faq_answer_9_1',  'EN', <<<EOT
There is more than one type of controversial content, each has its own answer to this question.
EOT
);
___('compendium_faq_answer_9_1',  'FR', <<<EOT
Il existe plusieurs types de contenus controversés. Chacun est géré d'une façon différente.
EOT
);
___('compendium_faq_answer_9_2',  'EN', <<<EOT
Extreme vulgarity, nudity, gross images, or anything else which could be considered not safe for work will be blurred, requiring an action (clicking the content) before it is revealed. You can permanently disable this feature by {{link|pages/account/register|registering an account}} on NoBleme and changing your {{link|pages/account/settings_nsfw|adult content settings}}.
EOT
);
___('compendium_faq_answer_9_2',  'FR', <<<EOT
La vulgarité extrême, la nudité, les images dégueulasses, ou tout ce qui pourrait être considéré problématique sur un lieu de travail est flouté, demandant une action délibérée (cliquer sur le contenu) pour retirer le floutage. Vous pouvez désactiver ce floutage sur toutes les pages en vous {{link|pages/account/register|créant un compte sur NoBleme}} puis en modifiant vos {{link|pages/account/settings_nsfw|options de vulgarité}}.
EOT
);
___('compendium_faq_answer_9_3',  'EN', <<<EOT
Politically incorrect and offensive content will be documented in this compendium, as it strives to be an exhaustive documentation of 21st century culture, including its bad sides. However, these contents will come with a warning at the top of the page, and we will ensure that they are portrayed in a negative light by explaining their real life consequences.
EOT
);
___('compendium_faq_answer_9_3',  'FR', <<<EOT
Des contenus politiquement incorrects ou offensants sont documentés dans ce compendium, vu qu'une documentation de la culture du 21ème siècle ne peut pas en ignorer les aspects problématiques. Toutefois, ces contenus viendront avec un avertissement en haut de la page, et seront représentés d'une façon négative.
EOT
);
___('compendium_faq_answer_9_4',  'EN', <<<EOT
Sociocultural content related to minorities will only be written with the help of those concerned. For example, a white european documenting an issue related to black americans might get everything right, but they might also be missing some critical elements which can only be understood by those who have to live with the weight of those issues on a daily basis. This means that some sociocultural topics will not be covered at all rather than risking documenting them in a non exhaustive or simply wrong way.
EOT
);
___('compendium_faq_answer_9_4',  'FR', <<<EOT
Les contenus socioculturels touchant à des minorités ne seront écrits qu'avec l'assistance de personnes concernées. Un blanc européen cherchant à documenter un problème spécifique aux personnes noires des USA pourrait le documenter de façon correcte, mais il serait également possible que des éléments critiques lui échappent, dont le poids ne se ressent que lorsqu'ils sont subis au quotidien. Cela signifie que certains sujets ne seront simplement pas couverts plutôt que de les documenter d'une façon potentiellement incorrecte.
EOT
);

___('compendium_faq_answer_10_1', 'EN', <<<EOT
There are many other websites already documenting subsets of 21st century culture, especially memes. It is their very existence which prompted the creation of the 21st century compendium: separating memes from their sociocultural context can turn them into propaganda tools. As unlikely as this seems, {{external|https://en.wikipedia.org/wiki/Memetic_warfare|memetic warfare}} is a legitimate concern, and led amongst other things to the {{external|https://en.wikipedia.org/wiki/Social_media_in_the_2016_United_States_presidential_election#Donald_Trump_campaign|2016 election}} of white supremacist president Donald Trump in the USA.
EOT
);
___('compendium_faq_answer_10_1', 'FR', <<<EOT
De nombreux autres sites documentent des aspects de la culture du 21ème siècle, particulièrement les memes. C'est l'existence même de ces sites qui a mené à la création de ce compendium : séparer les memes de leur contexte socioculturel peut les transformer en outils de propagande. Aussi improbable que cela peut vous sembler, la {{external|https://en.wikipedia.org/wiki/Memetic_warfare|guerre mémétique}} est une préoccupation légitime, qui a déjà {{external|https://en.wikipedia.org/wiki/Social_media_in_the_2016_United_States_presidential_election#Donald_Trump_campaign|joué un rôle central en 2016}} dans l'élection du suprémaciste blanc Donald Trump comme président des USA.
EOT
);
___('compendium_faq_answer_10_2', 'EN', <<<EOT
Once the decision to create this compendium had been made, the question of "what will set this documentation apart from the others" had to be asked, and the answer is the following :
EOT
);
___('compendium_faq_answer_10_2', 'FR', <<<EOT
Les éléments qui séparent ce compendium des autres sites silimaires sont les suivants :
EOT
);
___('compendium_faq_answer_10_3', 'EN', "Documenting all aspects of 21st century culture at once, not just memes or politics.");
___('compendium_faq_answer_10_3', 'FR', "Documenter tous les aspects de la culture du 21ème siècle d'un coup, pas uniquement les memes.");
___('compendium_faq_answer_10_4', 'EN', "A focus on quality over quantity: less content, but better content.");
___('compendium_faq_answer_10_4', 'FR', "Une focalisation sur la qualité plutôt que la quantité : moins de contenus, mais de meilleurs contenus.");
___('compendium_faq_answer_10_5', 'EN', "Short and simple pages with simple vocabulary, accessible to all.");
___('compendium_faq_answer_10_5', 'FR', "Des pages courtes et accessibles utilisant du vocabulaire simple.");
___('compendium_faq_answer_10_6', 'EN', "A single core writer/editor in order to have control over all content.");
___('compendium_faq_answer_10_6', 'FR', "Une seule personne rédigeant tous les contenus afin de garantir la ligne éditoriale.");
___('compendium_faq_answer_10_7', 'EN', "English/French bilingual, as the french community lacks such websites.");
___('compendium_faq_answer_10_7', 'FR', "Bilingue français/anglais, la communauté francophone ayant peu de sites en ce genre.");

___('compendium_faq_answer_11_1', 'EN', <<<EOT
NoBleme is more than just a domain name or a website, it is also a "framework", a set of development tools which make the creation of new components for the website much quicker than if they were created from scratch for a new platform. With this in mind, it made more sense to develop the 21st century compendium as a part of NoBleme rather than as a separate website.
EOT
);
___('compendium_faq_answer_11_1', 'FR', <<<EOT
NoBleme est plus qu'un nom de domaine ou un site internet, c'est également un « framework », une panoplie d'outils de développement qui rendent la création de nouveaux contenus sur le site plus rapide et facile que si ces contenus étaient crées à partir de rien pour une nouvelle plateforme.
EOT
);
___('compendium_faq_answer_11_2', 'EN', <<<EOT
As this whole platform is the work of one single person with limited time and energy to invest in the project, going with the quicker solution simply made more sense. Hopefully it will not affect your experience of browsing the 21st century compendium in any negative way.
EOT
);
___('compendium_faq_answer_11_2', 'FR', <<<EOT
Vu que tout ce site est l'œuvre d'une seule personne disposant d'une quantité limitée de temps et d'énergie à y investir, il était logique de choisir la solution la plus simple et rapide, et de faire de ce compendium une partie de NoBleme plutôt qu'un autre site séparé. Cela ne devrait toutefois pas affecter votre expérience lorsque vous parcourez le compendium.
EOT
);

___('compendium_faq_answer_12_1', 'EN', <<<EOT
NoBleme is an Internet community which has continuously existed since 2005. You can find out more about its history, its purpose, and its goals on the {{link|pages/doc/nobleme|what is NoBleme?}} page.
EOT
);
___('compendium_faq_answer_12_1', 'FR', <<<EOT
NoBleme est une communauté internet qui existe en continu depuis 2005. Vous pouvez en lire plus sur son histoire et sa raison d'être sur la page {{link|pages/doc/nobleme|qu'est-ce que NoBleme?}}
EOT
);
___('compendium_faq_answer_12_2', 'EN', <<<EOT
As a sidenote, a first attempt at documenting 21st century culture was already done on NoBleme all the way back in 2006, under the name "Wiki NoBleme". It was quite successful, attracting millions of readers, but had to eventually be shut down due to a few issues, the main one being that it attempted to keep politics out of everything and be a "neutral" documentation. Once it was clear that the neutral stance was actually helping the spread of harmful ideas, NoBleme's wiki was shut down in 2011. Ten years later, in 2021, this compendium is designed with the shortcomings of the first attempt in mind. Always learn from your past!
EOT
);
___('compendium_faq_answer_12_2', 'FR', <<<EOT
Par ailleurs, une première tentative de documenter la culture du 21ème siècle avait déjà eu lieu sur NoBleme en 2006, sous le nom « wiki NoBleme ». Cette tentative a connu un grand succès, attirant des millions de visites, mais a fini par fermer ses portes sous le poids de nombreux problèmes, le principal étant la règle de rendre le wiki NoBleme « apolitique » en prétendant que les contenus qui y étaient documentés pouvaient l'être sans prendre en compte leur impact social et politique. Lorsqu'il est devenu clair que le wiki NoBleme contribuait involontairement à répandre des contenus nocifs, il a été définitevement fermé en 2011. Dix ans plus tard, en 2021, ce compendium a été crée en prenant en compte les leçons qui ont été apprises lors de cette première tentative originelle. Il est important de toujours tirer des leçons du passé !
EOT
);

___('compendium_faq_answer_13_1', 'EN', <<<EOT
Please use our {{link|pages/messages/admins|contact form}} for any corrections or claims. Even if you are looking to have an e-mail or legal exchange with us, the contact form is our starting point for any conversation.
EOT
);
___('compendium_faq_answer_13_1', 'FR', <<<EOT
Utilisez notre {{link|pages/messages/admins|formulaire de contact}} pour tout signalement d'erreur ou toute réclamation. Même si vous désirez discuter par e-mail ou avoir un échange légal avec nous, le formulaire de contact est le point d'entrée de toute conversation.
EOT
);
___('compendium_faq_answer_13_2', 'EN', <<<EOT
A lot of material is being documented in this compendium for encyclopedic purposes. We try to steer clear of slandering anyone or hosting any copyrighted content without the appropriate permissions, but mistakes might happen and we are open to fixing them. Do not hesitate to get in touch with us.
EOT
);
___('compendium_faq_answer_13_2', 'FR', <<<EOT
Beaucoup de contenus sont documentés dans ce compendium dans un but purement encyclopédique. Nous essayons activement d'éviter les situations de diffamation en sourçant tous nos écrits, et évitons également d'héberger des contenus soumis à des limitations de propriété intellectuelle sans disposer des permissions requises. Toutefois, la nature chaotique des contenus partagés sur Internet fait que des erreurs peuvent avoir lieu, auquel cas nous désirons les corriger. N'hésitez pas à nous contacter à ces sujets.
EOT
);

___('compendium_faq_answer_14_1', 'EN', <<<EOT
Third party contributors are more than welcome. Whether you would like to suggest new content or point out inaccuracies in existing content, you can do so using our {{link|pages/messages/admins|contact form}}. Contributors are credited on the pages which they have contributed to (unless they asked to not be credited).
EOT
);
___('compendium_faq_answer_14_1', 'FR', <<<EOT
Les contributions sont plus que bienvenues. Que vous désiriez proposer des nouveaux contenus, signaler des erreurs, proposer des améliorations, vous pouvez le faire via notre {{link|pages/messages/admins|formulaire de contact}}. Les personnes offrant des contributions sont créditées sur les pages concernées (sauf si elles demandent à rester anonymes).
EOT
);
___('compendium_faq_answer_14_2', 'EN', <<<EOT
Do bear in mind however that, due to the compendium being the work of only one person, contributions can take a very long time to be used (unless they are pointing out errors of critical importance).
EOT
);
___('compendium_faq_answer_14_2', 'FR', <<<EOT
Gardez toutefois à l'esprit que, ce compendium étant l'œuvre d'une seule personne, beaucoup de temps peut parfois s'écouler avant que vos contributions soient traitées (sauf s'il s'agit de sujets d'importance critique).
EOT
);

___('compendium_faq_answer_15_1', 'EN', <<<EOT
NoBleme's {{link|pages/nobleme/activity|recent activity}} page and the compendium's {{link|pages/compendium/page_list|list of all pages}} both let you filter data in a way which allows you to track recent activity in the 21st century compendium.
EOT
);
___('compendium_faq_answer_15_1', 'FR', <<<EOT
La page {{link|pages/nobleme/activity|activité récente}} de NoBleme et la {{link|pages/compendium/page_list|liste des pages}} de ce compendium vous permettent de trier et filtrer les données afin de voir les pages crées ou modifiées récemment.
EOT
);
___('compendium_faq_answer_15_2', 'EN', <<<EOT
Automated messages are sent on both of NoBleme's {{link|pages/social/irc|IRC chat server}} and {{link|pages/social/discord|Discord server}} every time content is added or modified in the 21st century compendium.
EOT
);
___('compendium_faq_answer_15_2', 'FR', <<<EOT
Des messages automatisés sont envoyés sur le {{link|pages/social/irc|serveur de chat IRC}} et le {{link|pages/social/discord|serveur Discord}} de NoBleme à chaque fois qu'une nouvelle page est crée ou qu'une modification majeure a lieu sur le compendium.
EOT
);
___('compendium_faq_answer_15_3', 'EN', <<<EOT
We currently have no presence on other websites or social media, but might eventually share compendium updates on platforms other than NoBleme.
EOT
);
___('compendium_faq_answer_15_3', 'FR', <<<EOT
Nous n'avons actuellement aucune présence sur d'autres sites Internet ou réseaux sociaux, mais comptons à terme partager l'activité du compendium sur des plateformes autres que NoBleme.
EOT
);