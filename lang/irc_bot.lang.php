<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


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
___('irc_bot_history_resend',         'EN', "Resend");
___('irc_bot_history_resend',         'FR', "Renvoyer");
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