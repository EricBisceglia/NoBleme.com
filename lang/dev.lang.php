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
___('dev_queries_ok', 'EN', "ALL QUERIES HAVE SUCCESSFULLY BEEN RAN");
___('dev_queries_ok', 'FR', "LES REQUÊTES ONT ÉTÉ EFFECTUÉES AVEC SUCCÈS");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                WEBSITE MANAGEMENT                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Close the website
___('dev_close_website_title',  'EN', "Open / Close the website");
___('dev_close_website_title',  'FR', "Ouvrir / Fermer le site");
___('dev_close_website_button', 'EN', "Toggle");
___('dev_close_website_button', 'FR', "Changer");


// Version numbers: header
___('dev_versions_title',         'EN', "Version numbers");
___('dev_versions_title',         'FR', "Numéros de version");
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
/*                                                      IRC BOT                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Bot action selector
___('irc_bot_action_title',         'EN', "IRC bot management");
___('irc_bot_action_title',         'FR', "Gestion du bot IRC");
___('irc_bot_action_start',         'EN', "Start the bot");
___('irc_bot_action_start',         'FR', "Démarrer le bot");
___('irc_bot_action_stop',          'EN', "Stop the bot");
___('irc_bot_action_stop',          'FR', "Arrêter le bot");
___('irc_bot_action_silence',       'EN', "Silence the bot");
___('irc_bot_action_silence',       'FR', "Faire taire le bot");
___('irc_bot_action_upcoming',      'EN', "Message queue");
___('irc_bot_action_upcoming',      'FR', "Messages en attente");
___('irc_bot_action_message_log',   'EN', "Message history");
___('irc_bot_action_message_log',   'FR', "Historique des messages");
___('irc_bot_action_send_message',  'EN', "Send a message");
___('irc_bot_action_send_message',  'FR', "Envoyer un message");
___('irc_bot_action_specialchars',  'EN', "Special bytes");
___('irc_bot_action_specialchars',  'FR', "Bytes spéciaux");


// Start the bot
___('irc_bot_start_warning',  'EN', "Warning: Only do this if the bot is not already currently running.");
___('irc_bot_start_warning',  'FR', "Avertissement : Il ne faut pas démarrer le bot s'il est déjà présent sur IRC.");
___('irc_bot_start_starting', 'EN', "The IRC bot is starting…");
___('irc_bot_start_starting', 'FR', "Le bot IRC est en train de démarrer…");

___('irc_bot_start_disabled', 'EN', "Error: The IRC bot is disabled in global settings.");
___('irc_bot_start_disabled', 'FR', "Erreur : Le bot IRC est désactivé dans les réglages globaux.");
___('irc_bot_start_no_file',  'EN', "Error: The IRC bot file must exist.");
___('irc_bot_start_no_file',  'FR', "Erreur : Le fichier du bot IRC doit exister.");
___('irc_bot_start_failed',   'EN', "Error: Connexion to IRC server failed.");
___('irc_bot_start_failed',   'FR', "Erreur : La connexion au serveur IRC a échoué.");


// Stop the bot
___('irc_bot_stopped', 'EN', "The IRC bot has been stopped.");
___('irc_bot_stopped', 'FR', "Le bot IRC a été arrêté.");


// Silence the bot
___('irc_bot_mute',   'EN', "Silence the IRC bot");
___('irc_bot_mute',   'FR', "Faire taire le bot IRC");
___('irc_bot_unmute', 'EN', "Reactivate the IRC bot");
___('irc_bot_unmute', 'FR', "Réactiver le bot IRC");


// Upcoming messages
___('irc_bot_upcoming_empty',         'EN', "There are no upcoming messages, the IRC bot is probably currently running.");
___('irc_bot_upcoming_empty',         'FR', "Il n'y a aucun message en attente, le bot IRC est probablement actif.");
___('irc_bot_upcoming_purge',         'EN', "PURGE THE WHOLE QUEUE");
___('irc_bot_upcoming_purge',         'FR', "PURGER TOUTE LA QUEUE");
___('irc_bot_upcoming_confirm_purge', 'EN', "Confirm that you want to purge the full IRC bot message queue.");
___('irc_bot_upcoming_confirm_purge', 'FR', "Confirmez que vous voulez purger l\'intégralité de la queue de messages du bot IRC.");
___('irc_bot_upcoming_purged',        'EN', "The IRC bot's message queue has successfully been purged.");
___('irc_bot_upcoming_purged',        'FR', "La queue de messages du bot IRC a bien été purgée.");


// Message history
___('irc_bot_history_channel',        'EN', "Channel");
___('irc_bot_history_channel',        'FR', "Canal");
___('irc_bot_history_nochan',         'EN', "----");
___('irc_bot_history_nochan',         'FR', "----");
___('irc_bot_history_silenced',       'EN', "Silenced");
___('irc_bot_history_silenced',       'FR', "Silencieux");
___('irc_bot_history_sent',           'EN', "Sent");
___('irc_bot_history_sent',           'FR', "Envoyés");
___('irc_bot_history_failed',         'EN', "Failed");
___('irc_bot_history_failed',         'FR', "Échec");

___('irc_bot_history_confirm_delete', 'EN', "Confirm permanent deletion of this log: ");
___('irc_bot_history_confirm_delete', 'FR', "Confirmer la suppression définitive de ce message : ");
___('irc_bot_history_confirm_replay', 'EN', "Confirm that you want to replay this log: ");
___('irc_bot_history_confirm_replay', 'FR', "Confirmer vouloir rejouer ce message : ");


// Send a message
___('irc_bot_message_body',     'EN', "Send a message on IRC through the bot");
___('irc_bot_message_body',     'FR', "Envoyer un message sur IRC via le bot");
___('irc_bot_message_channel',  'EN', "[OPTIONAL] Send the message on this channel");
___('irc_bot_message_channel',  'FR', "[OPTIONNEL] Envoyer le message sur ce canal");
___('irc_bot_message_user',     'EN', "[OPTIONAL] Send the message to this user");
___('irc_bot_message_user',     'FR', "[OPTIONNEL] Envoyer le message à cet utilisateur");
___('irc_bot_message_send',     'EN', "Send the message");
___('irc_bot_message_send',     'FR', "Envoyer the message");


// Special bytes
___('irc_bot_bytes_effect',           'EN', "EFFECT");
___('irc_bot_bytes_effect',           'FR', "EFFET");
___('irc_bot_bytes_character',        'EN', "CHARACTER");
___('irc_bot_bytes_character',        'FR', "CARACTÈRE");
___('irc_bot_bytes_bytes',            'EN', "PHP CODE");
___('irc_bot_bytes_bytes',            'FR', "CODE PHP");

___('irc_bot_bytes_reset',            'EN', "Reset to default style");
___('irc_bot_bytes_reset',            'FR', "Remise à zéro du style");
___('irc_bot_bytes_bold',             'EN', "Bold");
___('irc_bot_bytes_bold',             'FR', "Bold");
___('irc_bot_bytes_italics',          'EN', "Italics");
___('irc_bot_bytes_italics',          'FR', "Italique");
___('irc_bot_bytes_underlined',       'EN', "Underlined");
___('irc_bot_bytes_underlined',       'FR', "Souligné");
___('irc_bot_bytes_text_white',       'EN', "Text color: White");
___('irc_bot_bytes_text_white',       'FR', "Couleur du texte : Blanc");
___('irc_bot_bytes_text_black',       'EN', "Text color: Black");
___('irc_bot_bytes_text_black',       'FR', "Couleur du texte : Noir");
___('irc_bot_bytes_text_blue',        'EN', "Text color: Blue");
___('irc_bot_bytes_text_blue',        'FR', "Couleur du texte : Bleu");
___('irc_bot_bytes_text_green',       'EN', "Text color: Green");
___('irc_bot_bytes_text_green',       'FR', "Couleur du texte : Vert");
___('irc_bot_bytes_text_red',         'EN', "Text color: Red");
___('irc_bot_bytes_text_red',         'FR', "Couleur du texte : Rouge");
___('irc_bot_bytes_text_brown',       'EN', "Text color: Brown");
___('irc_bot_bytes_text_brown',       'FR', "Couleur du texte : Marron");
___('irc_bot_bytes_text_purple',      'EN', "Text color: Purple");
___('irc_bot_bytes_text_purple',      'FR', "Couleur du texte : Violet");
___('irc_bot_bytes_text_orange',      'EN', "Text color: Orange");
___('irc_bot_bytes_text_orange',      'FR', "Couleur du texte : Orange");
___('irc_bot_bytes_text_yellow',      'EN', "Text color: Yellow");
___('irc_bot_bytes_text_yellow',      'FR', "Couleur du texte : Jaune");
___('irc_bot_bytes_text_light_green', 'EN', "Text color: Light green");
___('irc_bot_bytes_text_light_green', 'FR', "Couleur du texte : Vert clair");
___('irc_bot_bytes_text_teal',        'EN', "Text color: Teal");
___('irc_bot_bytes_text_teal',        'FR', "Couleur du texte : Bleu-vert");
___('irc_bot_bytes_text_light_cyan',  'EN', "Text color: Light cyan");
___('irc_bot_bytes_text_light_cyan',  'FR', "Couleur du texte : Cyan clair");
___('irc_bot_bytes_text_light_blue',  'EN', "Text color: Light blue");
___('irc_bot_bytes_text_light_blue',  'FR', "Couleur du texte : Bleu clair");
___('irc_bot_bytes_text_pink',        'EN', "Text color: Pink");
___('irc_bot_bytes_text_pink',        'FR', "Couleur du texte : Rose");
___('irc_bot_bytes_text_grey',        'EN', "Text color: Grey");
___('irc_bot_bytes_text_grey',        'FR', "Couleur du texte : Gris");
___('irc_bot_bytes_black_white',      'EN', "Bold white on black");
___('irc_bot_bytes_black_white',      'FR', "Blanc gras sur fond noir");
___('irc_bot_bytes_troll',            'EN', "Troll (brutal color contrast)");
___('irc_bot_bytes_troll',            'FR', "Troll (contraste brutal)");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  TASK  SCHEDULER                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('dev_scheduler_title',  'EN', "Scheduled tasks");
___('dev_scheduler_title',  'FR', "Tâches planifiées");


// Task list
___('dev_scheduler_task_execution',         'EN', "Execution");
___('dev_scheduler_task_execution',         'FR', "Exécution");
___('dev_scheduler_task_description',       'EN', "Description");
___('dev_scheduler_task_description',       'FR', "Description");
___('dev_scheduler_task_report',            'EN', "Report");
___('dev_scheduler_task_report',            'FR', "Résultat");
___('dev_scheduler_task_results',           'EN', "{{1}} results found   //   {{2}} future tasks   //   {{3}} past logs");
___('dev_scheduler_task_results',           'FR', "{{1}} résultats trouvés   //   {{2}} tâches futures   //   {{3}} logs d'exécution");
___('dev_scheduler_task_execution_future',  'EN', "Future tasks");
___('dev_scheduler_task_execution_future',  'FR', "Tâches futures");
___('dev_scheduler_task_execution_past',    'EN', "Finished tasks");
___('dev_scheduler_task_execution_past',    'FR', "Tâches finies");


// Delete scheduler entries
___('dev_scheduler_delete_task',  'EN', "Confirm the irreversible deletion of this scheduled task");
___('dev_scheduler_delete_task',  'FR', "Confirmer la suppression irréversible de cette tâche planifiée");
___('dev_scheduler_delete_log',   'EN', "Confirm the irreversible deletion of this scheduler log entry");
___('dev_scheduler_delete_log',   'FR', "Confirmer la suppression irréversible de cette entrée de l\'historique des tâches planifiées");



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