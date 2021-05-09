<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  DISCORD WEBHOOK                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Send a message
___('discord_webhook_message_title',    'EN', "Send a message through the webhook");
___('discord_webhook_message_title',    'FR', "Envoyer un message via le webhook");
___('discord_webhook_message_channel',  'EN', "Discord channel");
___('discord_webhook_message_channel',  'FR', "Canal Discord");
___('discord_webhook_message_main',     'EN', "Main channel");
___('discord_webhook_message_main',     'FR', "Canal principal");
___('discord_webhook_message_mod',      'EN', "Moderation team");
___('discord_webhook_message_mod',      'FR', "Équipe de modération");
___('discord_webhook_message_admin',    'EN', "Administrative team");
___('discord_webhook_message_admin',    'FR', "Équipe d'administration");
___('discord_webhook_message_body',     'EN', "Message contents");
___('discord_webhook_message_body',     'FR', "Contenu du message");
___('discord_webhook_message_submit',   'EN', "Send message through webhook");
___('discord_webhook_message_submit',   'FR', "Envoyer le message via le webhook");


// Shut down the Discord integration
___('discord_webhook_toggle_title_on',  'EN', "The Discord integration is currently active");
___('discord_webhook_toggle_title_on',  'FR', "L'intégration Discord est actuellement active");
___('discord_webhook_toggle_title_off', 'EN', "The Discord integration is currently inactive");
___('discord_webhook_toggle_title_off', 'FR', "L'intégration Discord est actuellement désactivée");
___('discord_webhook_toggle_off',       'EN', "Turn off the Discord integration");
___('discord_webhook_toggle_off',       'FR', "Désactiver l'intégration Discord");
___('discord_webhook_toggle_on',        'EN', "Turn on the Discord integration");
___('discord_webhook_toggle_on',        'FR', "Activer l'intégration Discord");




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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 IRC CHANNEL LIST                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('irc_channels_header_1',  'EN', <<<EOT
NoBleme's IRC server is comprised of different {{link|pages/irc/faq?guide#channel|channels}}, some public and some private. There are two "main" public channels used for general conversations, #english for english and #NoBleme for french, from which separate channels split when a specific topic starts taking too much space in general conversations.
EOT
);
___('irc_channels_header_1',  'FR', <<<EOT
Le serveur IRC NoBleme est composé de divers {{link|pages/irc/faq?guide#channel|canaux}}, dont certains sont publics et d'autres privés. Deux des canaux sont les « principaux », où ont lieu la majorité des conversations : #NoBleme pour le français et #english pour l'anglais. Lorsque des sujets spécifiques deviennent trop envahissants dans les canaux principaux, des canaux séparés sont crées pour les y canaliser.
EOT
);
___('irc_channels_header_2',  'EN', <<<EOT
The table below acts as a list of NoBleme's public IRC channels. You can join them by typing the {{link|pages/irc/faq?commands|command}} <span class="monospace">/join #channelName</span> in your IRC client, where #channelName is replaced by the desired channel's name.
EOT
);
___('irc_channels_header_2',  'FR', <<<EOT
Le tableau ci-dessous contient une liste de canaux publics sur le serveur IRC NoBleme. Vous pouvez les rejoindre en écrivant la {{link|pages/irc/faq?commands|commande}} <span class="monospace">/join #nomDuCanal</span> dans votre client IRC, en remplaçant #nomDuCanal par le nom d'un canal spécifique.
EOT
);
___('irc_channels_header_3',  'EN', <<<EOT
If you have created your own channel on NoBleme's IRC server (using {{link|pages/irc/faq?chanserv|ChanServ}}) and want it included in this list, {{link|pages/messages/admins|contact the administrative team}} with its name, its language, and a quick description of its purpose.
EOT
);
___('irc_channels_header_3',  'FR', <<<EOT
Si vous avez crée votre propre canal sur le serveur IRC NoBleme (en utilisant {{link|pages/irc/faq?chanserv|ChanServ}}) et aimeriez qu'il soit ajouté à cette liste, {{link|pages/messages/admins|contactez l'administration}} en précisant son nom, la langue qui y est parlée, et une description brève de son utilité.
EOT
);


// Table
___('irc_channels_name',      'EN', "Channel");
___('irc_channels_name',      'FR', "Canal");
___('irc_channels_type',      'EN', "Type");
___('irc_channels_type',      'FR', "Type");
___('irc_channels_language',  'EN', "Language");
___('irc_channels_language',  'FR', "Langue");
___('irc_channels_desc',      'EN', "Description");
___('irc_channels_desc',      'FR', "Description");
___('irc_channels_add',       'EN', "Add a new channel to the list");
___('irc_channels_add',       'FR', "Ajouter un nouveau canal à la liste");


// Channel edition instructions
___('irc_channels_type_instructions', 'EN', <<<EOT
Make sure to select the appropriate channel type. Try to apply a fair and objective judgement for its size: the goal here is to provide a solid documentation of our public channels for guests, we wouldn't want someone joining a channel categorized as major only to discover that it is in fact a minor channel with low activity.
EOT
);
___('irc_channels_type_instructions', 'FR', <<<EOT
Assurez-vous de choisir le type de canal approprié. Essayez d'appliquer un jugement juste et objectif sur sa taille : le but est de documenter de façon réaliste nos canaux IRC, nous ne voudrions pas qu'une personne en visite rejoigne un canal catégorisé comme majeur et se retrouve dans un lieu relativement vide et inactif.
EOT
);
___('irc_channels_type_main',         'EN', <<<EOT
<span class="bold underlined">Main</span> channels are the server's hubs - no more than one per language.
EOT
);
___('irc_channels_type_main',         'FR', <<<EOT
<span class="bold underlined">Principal</span> est réservé aux hubs du serveur - un seul par langue.
EOT
);
___('irc_channels_type_major',        'EN', <<<EOT
<span class="bold underlined">Major</span> channels have daily activity and a constant userbase of 10+ people.
EOT
);
___('irc_channels_type_major',        'FR', <<<EOT
<span class="bold underlined">Majeur</span> est un canal actif au quotidien et où 10+ personnes sont présentes en permanence.
EOT
);
___('irc_channels_type_minor',        'EN', <<<EOT
<span class="bold underlined">Minor</span> channels are side channels with a lower activity and userbase.
EOT
);
___('irc_channels_type_minor',        'FR', <<<EOT
<span class="bold underlined">Mineur</span> est un canal à l'activité ou à la population basse, à utiliser pour les nouveaux canaux.
EOT
);
___('irc_channels_type_automated',    'EN', <<<EOT
<span class="bold underlined">Automated</span> channels are centered around the activity of an IRC bot.
EOT
);
___('irc_channels_type_automated',    'FR', <<<EOT
<span class="bold underlined">Automatisé</span> est réservé aux canaux dont l'activité tourne autour d'un bot IRC.
EOT
);
___('irc_channels_desc_instructions', 'EN', <<<EOT
Also ensure that the channel's description is kept short but efficient. The goal is that it fits within one line in the {{link|pages/irc/faq?channels|channel list}}'s table. Take inspiration from the already existing channel descriptions if needed. If you do not speak french, ask the help of someone who does: a description must be present in both languages.
EOT
);
___('irc_channels_desc_instructions', 'FR', <<<EOT
Assurez-vous également que la description soit brève mais efficace. Le but est de la faire tenir dans une ligne du tableau de la {{link|pages/irc/faq?channels|liste des canaux}}. Inspirez-vous des descriptions existantes si nécessaire. Si vous parlez mal anglais, demandez un coup de main à quelqu'un d'autre : une description est impérative dans les deux langues.
EOT
);


// Add an IRC channel
___('irc_channels_add_title',     'EN', "New IRC channel");
___('irc_channels_add_title',     'FR', "Nouveau canal IRC");
___('irc_channels_add_type',      'EN', "Channel type");
___('irc_channels_add_type',      'FR', "Type de canal");
___('irc_channels_add_languages', 'EN', "Languages used in the channel");
___('irc_channels_add_languages', 'FR', "Langues utilisées sur le canal");
___('irc_channels_add_name',      'EN', "Channel name (including the # hash)");
___('irc_channels_add_name',      'FR', "Nom du canal (incluant le # croisillon)");
___('irc_channels_add_desc_en',   'EN', "Channel description in english");
___('irc_channels_add_desc_en',   'FR', "Description du canal en anglais");
___('irc_channels_add_desc_fr',   'EN', "Channel description in french");
___('irc_channels_add_desc_fr',   'FR', "Description du canal en français");
___('irc_channels_add_submit',    'EN', "Add the channel to the list");
___('irc_channels_add_submit',    'FR', "Ajouter le canal à la liste");


// Channel creation errors
___('irc_channels_add_error_name',      'EN', "The channel must have a name");
___('irc_channels_add_error_name',      'FR', "Le canal doit avoir un nom");
___('irc_channels_add_error_hash',      'EN', "The channel name must start with a # hash");
___('irc_channels_add_error_hash',      'FR', "Le nom du canal doit commencer par un # croisillon");
___('irc_channels_add_error_spaces',    'EN', "The channel name may not contain spaces");
___('irc_channels_add_error_spaces',    'FR', "Le nom du canal ne doit pas contenir d'espaces");
___('irc_channels_add_error_illegal',   'EN', "The channel name contains an illegal character");
___('irc_channels_add_error_illegal',   'FR', "Le nom du canal contient un caractère interdit");
___('irc_channels_add_error_length',    'EN', "Channel name is too long");
___('irc_channels_add_error_length',    'FR', "Le nom du canal est trop long");
___('irc_channels_add_error_duplicate', 'EN', "This channel already exists in the list");
___('irc_channels_add_error_duplicate', 'FR', "Ce canal est déjà présent dans la liste");
___('irc_channels_add_error_desc',      'EN', "A description must be present in both languages");
___('irc_channels_add_error_desc',      'FR', "Une description doit être présente dans les deux langues");
___('irc_channels_add_error_lang',      'EN', "At least one language must be selected");
___('irc_channels_add_error_lang',      'FR', "Au moins une langue doit être sélectionnée");


// Edit an IRC channel
___('irc_channels_edit_title',  'EN', "Edit IRC channel {{1}}");
___('irc_channels_edit_title',  'FR', "Modifier le canal IRC {{1}}");
___('irc_channels_edit_submit', 'EN', "Edit channel");
___('irc_channels_edit_submit', 'FR', "Modifier le canal");


// Channel modification errors
___('irc_channels_edit_error_id', 'EN', "This IRC channel does not exist");
___('irc_channels_edit_error_id', 'FR', "Ce canal IRC n'existe pas");


// Delet an IRC channel
___('irc_channels_delete_confirm',  'EN', "Confirm the permanent and irreversible deletion of this entry in the IRC channel list");
___('irc_channels_delete_confirm',  'FR', "Confirmer la suppression permanente et irréversible de cette entrée dans la liste des canaux IRC");
___('irc_channels_delete_error',    'EN', "This IRC channel does not exist or has already been deleted");
___('irc_channels_delete_error',    'FR', "Ce canal IRC n'existe pas ou a déjà été supprimé");
___('irc_channels_delete_ok',       'EN', "The channel has successfully been deleted");
___('irc_channels_delete_ok',       'FR', "Le canal a bien été supprimé");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      IRC FAQ                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// FAQ: Titles
___('irc_faq_title',          'EN', "IRC chat");
___('irc_faq_title',          'FR', "Chat IRC");
___('irc_faq_title_why',      'EN', "Why IRC?");
___('irc_faq_title_why',      'FR', "Pourquoi IRC ?");
___('irc_faq_title_guide',    'EN', "IRC vocabulary");
___('irc_faq_title_guide',    'FR', "Vocabulaire IRC");
___('irc_faq_title_browser',  'EN', "IRC web client");
___('irc_faq_title_browser',  'FR', "Client web IRC");
___('irc_faq_title_client',   'EN', "IRC client");
___('irc_faq_title_client',   'FR', "Client IRC");
___('irc_faq_title_bouncer',  'EN', "IRC bouncer");
___('irc_faq_title_bouncer',  'FR', "Bouncer IRC");
___('irc_faq_title_commands', 'EN', "IRC Commands");
___('irc_faq_title_commands', 'FR', "Commandes IRC");
___('irc_faq_title_nickserv', 'EN', "IRC NickServ");
___('irc_faq_title_nickserv', 'FR', "IRC NickServ");
___('irc_faq_title_chanserv', 'EN', "IRC ChanServ");
___('irc_faq_title_chanserv', 'FR', "IRC ChanServ");
___('irc_faq_title_bots',     'EN', "IRC bots");
___('irc_faq_title_bots',     'FR', "Bots IRC");
___('irc_faq_title_channels', 'EN', "IRC channels");
___('irc_faq_title_channels', 'FR', "Canaux IRC");
___('irc_faq_title_others',   'EN', "Official platforms");
___('irc_faq_title_others',   'FR', "Plateformes officielles");


// FAQ: Header
___('irc_faq_select_main',      'EN', "The heart of NoBleme's community");
___('irc_faq_select_main',      'FR', "Le cœur de la communauté de NoBleme");
___('irc_faq_select_why',       'EN', "Why IRC instead of anything else?");
___('irc_faq_select_why',       'FR', "Pourquoi IRC plutôt qu'autre chose ?");
___('irc_faq_select_guide',     'EN', "IRC vocabulary and symbols");
___('irc_faq_select_guide',     'FR', "Vocabulaire et symboles");
___('irc_faq_select_browser',   'EN', "Chat from your browser");
___('irc_faq_select_browser',   'FR', "Chat depuis votre navigateur");
___('irc_faq_select_client',    'EN', "Installing an IRC client");
___('irc_faq_select_client',    'FR', "Installer un client IRC");
___('irc_faq_select_bouncer',   'EN', "Setting up an IRC bouncer");
___('irc_faq_select_bouncer',   'FR', "Mettre en place un bouncer IRC");
___('irc_faq_select_commands',  'EN', "Commands: Simple actions");
___('irc_faq_select_commands',  'FR', "Commandes: Actions de base");
___('irc_faq_select_nickserv',  'EN', "NickServ: Username management");
___('irc_faq_select_nickserv',  'FR', "NickServ: Gérer votre pseudonyme");
___('irc_faq_select_chanserv',  'EN', "ChanServ: Channel management");
___('irc_faq_select_chanserv',  'FR', "ChanServ: Gérer vos canaux");
___('irc_faq_select_bots',      'EN', "The bots of NoBleme");
___('irc_faq_select_bots',      'FR', "Les bots de NoBleme");
___('irc_faq_select_channels',  'EN', "Channel list");
___('irc_faq_select_channels',  'FR', "Liste des canaux");
___('irc_faq_select_others',    'EN', "Beyond IRC: Other platforms");
___('irc_faq_select_others',    'FR', "Hors d'IRC: Autres plateformes");


// FAQ: Main
___('irc_faq_main_body',  'EN', <<<EOT
Like most online communities, NoBleme has a place where its members can hold conversations in real time, which is where most of the action happens: it is the heart of the community. This page is a FAQ explaining why we use IRC rather than anything else, and how to join us so that you can be a part of the conversation. Use the dropdown menu right above this paragraph to read more about NoBleme's IRC server and IRC in general.
EOT
);
___('irc_faq_main_body',  'FR', <<<EOT
Comme la plupart des autres communautés, NoBleme possède un lieu de conversation en temps réel, où la majorité des interactions ont lieu : il s'agit du cœur de la communauté. Cette page est une FAQ expliquant pourquoi nous avons choisi IRC plutôt qu'autre chose, et comment nous y rejoindre afin de faire partie de la conversation. Utilisez le menu déroulant situé juste au dessus de ce paragraphe pour en apprendre plus sur le serveur IRC de NoBleme et sur IRC en général.
EOT
);

___('irc_faq_main_what_title',    'EN', "What is IRC?");
___('irc_faq_main_what_title',    'FR', "Qu'est-ce que IRC ?");
___('irc_faq_main_what_1',        'EN', <<<EOT
{{external|https://en.wikipedia.org/wiki/Internet_Relay_Chat|IRC (Internet Relay Chat)}} is a real time communication protocol from 1988. Back in 2005, when NoBleme was founded, IRC was the most commonly used way to chat in real time over the Internet. We still use it to this day, for a variety of reasons {{link|pages/irc/faq?why|detailed here}}. The way IRC works is that a central IRC server is hosted on NoBleme, and each user has to use their own IRC client of choice to connect to that server.
EOT
);
___('irc_faq_main_what_1',        'FR', <<<EOT
{{external|https://fr.wikipedia.org/wiki/Internet_Relay_Chat|IRC (Internet Relay Chat)}} est un protocole permettant les conversations en temps réel datant de 1988. Lorsque NoBleme a été fondé, en 2005, IRC était la méthode de chat la plus communément utilisée sur Internet. Nous choisissons de continuer à l'utiliser encore aujourd'hui, pour des raisons {{link|pages/irc/faq?why|détaillées ici}}.
EOT
);
___('irc_faq_main_what_2',        'EN', <<<EOT
If you already know how to connect to an IRC server, you will find the connexion info for NoBleme's IRC server below. If you don't, no worries, keep reading, it's not as complicated as it seems.
EOT
);
___('irc_faq_main_what_2',        'FR', <<<EOT
Le fonctionnement d'IRC est assez particulier : un serveur IRC central est hébergé sur NoBleme, et chaque personne souhaitant s'y connecter doit utiliser un client IRC de son choix pour le faire. Si vous savez déjà comment vous connecter à un serveur IRC, vous trouverez les informations de connexion à NoBleme ci-dessous. Si vous ne savez pas comment faire, continuez à lire, c'est beaucoup plus simple que ça en a l'air.
EOT
);
___('irc_faq_main_what_server',   'EN', "Server:");
___('irc_faq_main_what_server',   'FR', "Serveur :");
___('irc_faq_main_what_url',      'EN', "irc.nobleme.com");
___('irc_faq_main_what_url',      'FR', "irc.nobleme.com");
___('irc_faq_main_what_port',     'EN', "Port:");
___('irc_faq_main_what_port',     'FR', "Port :");
___('irc_faq_main_what_ports',    'EN', "6697 (SSL) / 6667 (standard)");
___('irc_faq_main_what_ports',    'FR', "6697 (SSL) / 6667 (standard)");
___('irc_faq_main_what_channel',  'EN', "Channel:");
___('irc_faq_main_what_channel',  'FR', "Canal :");
___('irc_faq_main_what_hub',      'EN', "#english");
___('irc_faq_main_what_hub',      'FR', "#NoBleme");
___('irc_faq_main_what_encoding', 'EN', "Encoding:");
___('irc_faq_main_what_encoding', 'FR', "Encodage :");
___('irc_faq_main_what_utf',      'EN', "UTF-8");
___('irc_faq_main_what_utf',      'FR', "UTF-8");

___('irc_faq_main_join_title',    'EN', "Joining NoBleme's IRC server");
___('irc_faq_main_join_title',    'FR', "Rejoindre le serveur IRC de NoBleme");
___('irc_faq_main_join_1',        'EN', <<<EOT
In order to join an IRC server, you need what is called a <span class="italics">client</span>: an application that acts as a third party between the server and you. There are different types of clients, some of which need to be installed on your machine and others which don't, some which keep message history when you're not around and others which don't.
EOT
);
___('irc_faq_main_join_1',        'FR', <<<EOT
Pour rejoindre un serveur IRC, vous avez besoin d'un <span class="italics">client</span> : une application qui sert d'interprète entre le serveur et vous. Il existe différentes sortes de clients IRC, certains qui nécessitent d'être installés sur votre appareil et d'autres non, certains qui conservent l'historique des messages en votre absence et d'autres non.
EOT
);
___('irc_faq_main_join_2',        'EN', <<<EOT
The quickiest and easiest way to join NoBleme's IRC server is by using a {{link|pages/irc/faq?browser|web client in your browser}}. All you have to do is {{link|pages/irc/faq?browser|click this link}}, choose a username, and you'll be in. Simple!
EOT
);
___('irc_faq_main_join_2',        'FR', <<<EOT
La façon la plus simple et rapide de rejoindre le serveur IRC de NoBleme est en utilisant un {{link|pages/irc/faq?browser|client web via votre navigateur}}. Tout ce que vous avez à faire est {{link|pages/irc/faq?browser|cliquer sur ce lien}}, choisir votre pseudonyme, et vous serez sur le serveur IRC de NoBleme. Aussi simple que ça !
EOT
);
___('irc_faq_main_join_3',        'EN', <<<EOT
Once you spend time on NoBleme's IRC server, you might end up thinking that a web client has too many limitations. In this case, you can always {{link|pages/irc/faq?client|install an IRC client on your machine}}. And if you feel sad that your IRC client does not keep track of message history for you, then you can always upgrade to {{link|pages/irc/faq?bouncer|using a bouncer}}.
EOT
);
___('irc_faq_main_join_3',        'FR', <<<EOT
Si vous passez du temps sur le serveur IRC de NoBleme, vous vous direz probablement qu'un client web a ses limites. Dans ce cas, vous pouvez {{link|pages/irc/faq?client|installer un client IRC sur votre appareil}}. Et si vous regrettez que votre client ne garde pas la trace des messages lorsqu'il n'est pas connecté, vous pouvez {{link|pages/irc/faq?bouncer|utiliser un bouncer}}.
EOT
);
___('irc_faq_main_join_4',        'EN', <<<EOT
As you can tell, freedom to choose the way you want to use IRC is both a blessing and a curse. It lets you heavily customize your chatting experience, but also means that a bit of effort is required in setting up your experience to fit your needs. Why is NoBleme choosing to stay on IRC despite this complexity, why don't we switch to a more modern real time chat application? {{link|pages/irc/faq?why|It's complicated, here's a whole page dedicated to answering that question}}.
EOT
);
___('irc_faq_main_join_4',        'FR', <<<EOT
Comme vous pouvez le voir, la liberté de choisir votre façon d'utiliser IRC est à la fois pratique et gênante. Vous avez l'opportunité de personnaliser votre utilisation autant que vous le voulez, mais cela signifie qu'un effort est requis pour la personnalisation initiale de votre expérience. Pourquoi est-ce que NoBleme choisit de continuer à utiliser IRC malgré cette complexité, pourquoi ne basculons-nous pas vers un système de communication en temps réel plus moderne ? {{link|pages/irc/faq?why|La réponse est compliquée, il y a une page entière du site dédiée à ce sujet}}.
EOT
);

___('irc_faq_questions_title',  'EN', 'Frequently asked questions');
___('irc_faq_questions_title',  'FR', 'Foire aux questions');
___('irc_faq_question_1',       'EN', "What are channels?");
___('irc_faq_question_1',       'FR', "Qu'est-ce qu'un canal ?");
___('irc_faq_answer_1',         'EN', <<<EOT
IRC servers are comprised of various channels, which are basically chat rooms. Channel names begin with a <span class="glow">#</span> hash character. Some of NoBleme's channels are generic hubs with no specific theme (such as #english being the main english speaking channel), others are used to offload specific conversations away from the generic channels (such as #dev for computer science related content). You are free to choose which channels you join on the server, the {{link|todo_link|channel list}} explains how to join a channel, and lists NoBleme's main IRC channels.
EOT
);
___('irc_faq_answer_1',         'FR', <<<EOT
Les serveurs IRC sont composés de divers canaux, qui sont des salles de discussion séparées les unes des autres. Les canaux ont un nom commençant par un croisillon (<span class="glow">#</span>). Sur le serveur IRC de NoBleme, chaque langue possède son canal prinicpal où la majorité des conversations ont lieu (#NoBleme pour le français et #english pour l'anglais), les autres canaux ont des thèmes spécifiques (comme par exemple #dev pour l'informatique). Vous êtes libre de choisir à quels canaux vous vous connectez, la {{link|todo_link|liste des canaux}} vous explique comment les rejoindre, et liste les principaux canaux IRC de NoBleme.
EOT
);
___('irc_faq_question_2',       'EN', "Why is nobody talking/replying to me?");
___('irc_faq_question_2',       'FR', "Pourquoi personne ne me parle/répond ?");
___('irc_faq_answer_2',         'EN', <<<EOT
Users are not always around in front of their computers or phones. If you hit a bad timing and everyone is at work, sleeping, or just busy, then be patient and someone will eventually show up. During a standard day, there are long periods of time where no conversations happen, and others where NoBleme's IRC is busy with conversations, simply spend enough time on IRC and you'll eventually catch it at the right time.
EOT
);
___('irc_faq_answer_2',         'FR', <<<EOT
Tout le monde n'est pas en permanence devant leurs ordinateurs ou téléphones. Si vous tombez sur un mauvais moment où tout le monde est au travail, en train de dormir, ou juste indisponible, faites preuve de patience et quelqu'un finira tôt ou tard par vous répondre. Au cours d'une journée normale, il y a de longues périodes pendant lesquelles aucune conversation n'a lieu, et d'autres pendant lesquelles il y a beaucoup de conversations, passez assez de temps sur le serveur IRC NoBleme et vous finirez par y être au bon moment.
EOT
);
___('irc_faq_question_3',       'EN', "Why are people writing in french?");
___('irc_faq_question_3',       'FR', "Pourquoi ça parle anglais ?");
___('irc_faq_answer_3',         'EN', <<<EOT
NoBleme is a bilingual french/english server. Some channels are french only (including the #NoBleme hub), some are english only, some are mixed. The {{link|todo_link|channel list}} shows the languages used in each channel.
EOT
);
___('irc_faq_answer_3',         'FR', <<<EOT
NoBleme est une communauté bilingue anglais/français. Certains canaux IRC sont uniquement en français (comme par exemple #NoBleme), d'autres uniquement en anglais, d'autres bilingues. La {{link|todo_link|liste des canaux}} documente les langues utilisées sur chaque canal de discussion.
EOT
);
___('irc_faq_question_4',       'EN', "Can people \"steal\" my username?");
___('irc_faq_question_4',       'FR', "Peut-on me « voler » mon pseudonyme ?");
___('irc_faq_answer_4',         'EN', <<<EOT
In order to gain exclusive ownership of your username, you first have to register it using our IRC services. You can find more about it on the {{link|pages/irc/faq?nickserv|IRC account management}} page. You are also free to not register and use IRC as a guest, using whichever username you desire.
EOT
);
___('irc_faq_answer_4',         'FR', <<<EOT
Afin d'avoir la propriété exclusive de votre pseudonyme, vous devez d'abord l'enregistrer auprès des services de notre serveur IRC. Plus d'informations à ce sujet sur la page {{link|pages/irc/faq?nickserv|Gérer votre pseudonyme}}. Vous êtes également libre de ne pas enregistrer votre pseudonyme, il ne s'agit que d'une option.
EOT
);
___('irc_faq_question_5',       'EN', "How can I change my username?");
___('irc_faq_question_5',       'FR', "Comment changer mon pseudonyme ?");
___('irc_faq_answer_5',         'EN', <<<EOT
You can change your username at any time. Some IRC clients allow you to change your username directly from their interface, others require you to use a command. You can find out more about commands on the {{link|pages/irc/faq?commands|IRC commands}} page.
EOT
);
___('irc_faq_answer_5',         'FR', <<<EOT
Vous pouvez changer de pseudonyme à tout moment. Certains clients IRC vous permettent de le faire directement depuis leur interface, d'autres attendent que vous le fassiez via une commande. Vous trouverez plus d'inofrmations à ce sujet sur la page {{link|pages/irc/faq?commands|Commandes IRC}}.
EOT
);
___('irc_faq_question_6',       'EN', "Can I create my own channel on NoBleme's IRC server?");
___('irc_faq_question_6',       'FR', "Puis-je créer mon propre canal sur le serveur IRC de NoBleme ?");
___('irc_faq_answer_6',         'EN', <<<EOT
If it has anything to do with NoBleme or its community, sure, go ahead, no need to ask for permission. You will find more details on the {{link|pages/irc/faq?chanserv|IRC channel management}} page. You might even want it to be listed in the {{link|todo_link|channel list}}, in which case use our {{link|pages/messages/admins|administrative contact form}} to make a request. If you would like to create a channel for external people who have nothing to do with NoBleme, this is also fine, but please make sure they respect NoBleme's {{link|pages/doc/coc|code of conduct}} at all times, and use the {{link|pages/messages/admins|admin contact form}} to inform NoBleme's administrative team that you created a channel for your own community (if you don't keep us informed, we might think you are server squatters and shut it down by accident).
EOT
);
___('irc_faq_answer_6',         'FR', <<<EOT
Si vous désirez créer un canal en rapport avec NoBleme ou sa communauté, allez-y, pas besoin de demander la permisison. Vous trouverez comment faire sur la page {{link|pages/irc/faq?chanserv|Gérer vos canaux}}. Si vous voulez que votre canal apparaisse sur la {{link|todo_list|liste des canaux}}, utilisez notre {{link|pages/messages/admins|formulaire de contact administratif}} pour en faire la demande. Si vous désirez créer un canal IRC pour des personnes externes qui n'ont aucun rapport avec NoBleme, cela n'est pas non plus un problème, mais assurez-vous toutefois que votre communauté respecte le {{link|pages/doc/coc|code de conduite de NoBleme}}, et utilisez le {{link|pages/messages/admins|formulaire de contact administratif}} pour prévenir l'équie administrative de NoBleme que vous utilisez son serveur IRC pour votre communauté (si vous ne le faites pas, nous risquons de supprimer votre canal par accident).
EOT
);
___('irc_faq_question_7',       'EN', "Where can I get help?");
___('irc_faq_question_7',       'FR', "Où puis-je avoir de l'aide ?");
___('irc_faq_answer_7',         'EN', <<<EOT
IRC can be overwhelming at first, but it is actually rather simple once you are used to it. If you need help with something, simply ask around, NoBleme's community is friendly and will help you out.
EOT
);
___('irc_faq_answer_7',         'FR', <<<EOT
IRC peut avoir l'air compliqué à première vue, mais une fois votre client installé et configuré tout devient beaucoup plus simple. Si vous avez besoin d'aide, vous pouvez tout simplement demander sur un des canaux du serveur IRC de NoBleme. La communauté est coopérative et vous aidera.
EOT
);
___('irc_faq_question_8',       'EN', "Must I talk?");
___('irc_faq_question_8',       'FR', "Dois-je discuter ?");
___('irc_faq_answer_8',         'EN', <<<EOT
There is no requirement to be part of the conversation, you can join IRC and simply read what others are talking about. It is likely that some people will eventually wonder who you are and ask you questions, but being a guest is not against the rules, feel free to not answer and keep reading. Maybe you will eventually want to be a part of the conversation!
EOT
);
___('irc_faq_answer_8',         'FR', <<<EOT
Rien ne vous oblige à faire partie de la conversation. Vous pouvez rejoindre IRC et vous contenter de lire les conversations des autres. Probablement que quelqu'un se demandera tôt ou tard qui vous êtes et vous posera des questions, mais il n'y a aucune règle contre le silence, vous pouvez vous contenter de ne pas répondre.
EOT
);
___('irc_faq_question_9',       'EN', "Something bad happened, what do I do?");
___('irc_faq_question_9',       'FR', "Il m'est arrivé quelque chose de mal, que faire ?");
___('irc_faq_answer_9',         'EN', <<<EOT
If a singular user is harrassing you, you can use the {{link|pages/irc/faq?commands|/ignore command}} to ignore them, then report their behavior {{link|pages/messages/admins|to NoBleme's administrative team}}. If a user or channel is breaking NoBleme's {{link|pages/doc/coc|code of conduct}}, please report them {{link|pages/messages/admins|to the admins}} aswell. If users are flooding the server, then no need to act: NoBleme's administrative team will be aware of it, and will take action as soon as they are able to. Simply stay patient and wait for it to be over.
EOT
);
___('irc_faq_answer_9',         'FR', <<<EOT
Si une personne vous harcèle, utilisez la {{link|pages/irc/faq?commands|commande /ignore}} pour ne plus voir ses messages, puis {{link|pages/messages/admins|contactez l'administration}} et faites-nous part du problème. Si une personne ou un canal enfreint le {{link|pages/doc/coc|code de conduite de NoBleme}}, utilisez également le {{link|pages/messages/admins|formulaire de contact administratif}} pour nous en informer. Si un problème a lieu à l'échelle de tout le serveur IRC (invasion, spam, lenteurs), vous n'avez rien besoin de faire : l'équipe administrative de NoBleme est assurément déjà au courant, et agira dès que possible.
EOT
);
___('irc_faq_question_10',      'EN', "I can't join IRC, is the server dead?");
___('irc_faq_question_10',      'FR', "Je ne peux pas me connecter à IRC, le serveur est-il KO ?");
___('irc_faq_answer_10',        'EN', <<<EOT
Maybe. Ask on {{link|todo_link|NoBleme's Discord server}}, we use it as our backup communication method.
EOT
);
___('irc_faq_answer_10',        'FR', <<<EOT
Peut-être. Demandez sur le {{link|todo_link|serveur Discord de NoBleme}}, il sert de mode de communication de secours lorsque IRC a des problèmes.
EOT
);
___('irc_faq_question_11',      'EN', "Any plans to move from IRC to something else?");
___('irc_faq_question_11',      'FR', "Quand est-ce que NoBleme utilisera autre chose que IRC ?");
___('irc_faq_answer_11',        'EN', <<<EOT
This has been discussed a lot, and is still being discussed on a regular basis. Currently, the answer is no.
EOT
);
___('irc_faq_answer_11',        'FR', <<<EOT
Cette discussion a lieu très régulièrement. La réponse est actuellement jamais, ce n'est pas prévu.
EOT
);


// FAQ: Why IRC
___('irc_faq_why_body_1',         'EN', <<<EOT
NoBleme has been using IRC as its main real time chat platform since 2005. Back then, it used to be the only option that made sense. Since then, the Internet has changed and evolved a lot, to the point where IRC might seem like an outdated and unnecessarily complicated platform catering to old timers.
EOT
);
___('irc_faq_why_body_1',         'FR', <<<EOT
NoBleme utilise IRC en tant que plateforme de chat en temps réel depuis 2005. À l'époque, il s'agissait de la seule plateforme de chat qui répondait à nos besoins. Entre temps, Internet a beaucoup changé et évolué, au point où IRC peut vous sembler être une plateforme antique et compliquée.
EOT
);
___('irc_faq_why_body_2',         'EN', <<<EOT
You might be expecting this page to be a defense of IRC, consider your expectations subverted: we are very well aware of IRC's many flaws and limitations, and would be happy to migrate to a more fitting alternative. Therefore, we often reconsider our choice of main communication platform, but are yet to find an alternative that meets our needs as well as IRC does. Since the question comes up quite often, this page will do its best to explain why we are yet to switch to something else.
EOT
);
___('irc_faq_why_body_2',         'FR', <<<EOT
Vous vous attendez probablement à ce que cette page soit une défense d'IRC, ce ne sera pas le cas : nous sommes très ouverts au sujet des nombreuses limitations d'IRC, et migrerions avec joie vers une meilleure solution. Par conséquent, nous remettons régulièrement en question le choix d'IRC, mais n'avons jusque-là pas trouvé d'alternative qui répond mieux qu'IRC à nos attentes. Comme la question revient souvent, cette page sert à expliquer notre choix.
EOT
);

___('irc_faq_why_freedom_title',  'EN', "Freedom from corporations");
___('irc_faq_why_freedom_title',  'FR', "Protection de la vie privée");
___('irc_faq_why_freedom_body_1', 'EN', <<<EOT
As stated in NoBleme's {{link|pages/doc/privacy|privacy policy}}, we do not want any third parties to be able to collect and use your {{link|pages/doc/data|personal data}} while you are taking part in any activity related to NoBleme. In order to achieve this goal, any real time chat service offered by NoBleme must be free to use, open sourced, privacy oriented, and have the ability to be hosted on NoBleme's own servers.
EOT
);
___('irc_faq_why_freedom_body_1', 'FR', <<<EOT
Comme précisé dans notre {{link|pages/doc/privacy|politique de confidentialité}}, nous ne voulons pas que des tiers puissent collecter et utiliser vos {{link|pages/doc/data|données personnelles}}. Dans cette optique, tout service de communication en temps réel proposé par NoBleme doit prendre en compte la protection de la vie privée, être libre de droits, son code source doit être public, et il doit pouvoir être hébergé sur les serveurs de NoBleme.
EOT
);
___('irc_faq_why_freedom_body_2', 'EN', <<<EOT
IRC's flexibility in letting you use any chat client of your choice actually acts as an issue in this regard: some of our users choose IRC clients privately hosted by corporations, which can collect and use data from any conversations they are involved in. Even if 100 users use non corporate IRC clients, it only takes one user in the same channel running a privately hosted client offered by a corporation to collect and use the data of these 100 other users without their consent. Hypocritically, we even suggest using {{link|pages/irc/faq?browser|KiwiIRC}} and {{link|pages/irc/faq?bouncer|IRCCloud}} in this FAQ, which might both potentially contribute to this very issue.
EOT
);
___('irc_faq_why_freedom_body_2', 'FR', <<<EOT
La flexibilité d'IRC est paradoxalement problématique à ce sujet : en vous donnant la liberté d'utiliser le client IRC de votre choix, nous vous laissons la possibilité d'utiliser des clients hébergés par des entreprises, qui peuvent en profiter pour collecter des données. Même si 100 membres d'un canal de discussion IRC utilisent des clients respectant la vie privée, il suffit d'un seul membre utilisant un client hébergé par une entreprise mal intentionnée pour collecter et utiliser les données des conversations de ces 100 autres membres, sans leur consentement. Hypocritement, nous vous suggérons même d'utiliser {{link|pages/irc/faq?browser|KiwiIRC}} et {{link|pages/irc/faq?bouncer|IRCCloud}} dans cette FAQ, qui contribuent potentiellement tous les deux à ce problème.
EOT
);

___('irc_faq_why_flex_title',     'EN', "Flexible user experience");
___('irc_faq_why_flex_title',     'FR', "Expérience d'utilisation flexible");
___('irc_faq_why_flex_body_1',    'EN', <<<EOT
As every user chooses their preferred IRC client, you have a freedom to bend IRC's user experience any way you want to and can access IRC on any device or platform of your choice. This used to be extremely important in the early days of NoBleme's IRC server, when the competition (MSN, ICQ, Skype, Google Talk, etc.) locked you into a forced user experience. Nowadays, most real time chat applications offer various degrees of customization, which allow for a properly flexible user experience.
EOT
);
___('irc_faq_why_flex_body_1',    'FR', <<<EOT
Étant donné que vous êtes libre de choisir votre client IRC, vous disposez de la possibilité de personnaliser votre expérience d'utilisation d'IRC sur chaque plateforme ou appareil que vous possédez. Cet avantage était beaucoup plus important aux débuts de NoBleme, du temps où les alternatives (MSN, ICQ, Skype, Google Talk, etc.) vous imposaient une expérence d'utilisation unique non personnalisable. De nos jours, ce problème est moins important, car la majorité des alternatives à IRC vous offrent un minimum d'options de personnalisation.
EOT
);
___('irc_faq_why_flex_body_2',    'EN', <<<EOT
The drawback in IRC's case is that the freedom to customize your user experience means that you actually need to setup and customize your own IRC client. This has a cost in both time and effort, which can be a harsh barrier of entry for some users, and thus turn them away from joining NoBleme's IRC chat. We are very well aware of this issue, and of the cost it has on our community's activity, but are willing to accept that cost.
EOT
);
___('irc_faq_why_flex_body_2',    'FR', <<<EOT
Dans le cas d'IRC, cet avantage est en partie un inconvénient : la liberté de personnaliser votre expérience d'utilisation implique l'obligation de mettre en place votre propre client IRC. Cela peut avoir un coût en temps et en efforts, créant une barrière d'entrée élevée pour certaines personnes, les démotivant potentiellement d'utiliser le chat IRC NoBleme. Nous sommes au courant de ce problème et de son impact sur l'activité de la communauté, mais choisissons de l'accepter.
EOT
);

___('irc_faq_why_simple_title',   'EN', "Simplicity: chat comes first");
___('irc_faq_why_simple_title',   'FR', "Simplicité : la conversation avant tout");
___('irc_faq_why_simple_body_1',  'EN', <<<EOT
As IRC is not trying to compete with any other platforms, there is no race to add features. The core of IRC's usage is and will always remain the simple action of chatting with other users. We appreciate this simplicity, and would only consider an alternative that shares this point of view.
EOT
);
___('irc_faq_why_simple_body_1',  'FR', <<<EOT
IRC n'étant pas en compétition avec d'autres plateformes, il n'y a pas de course à l'amélioration continue. Le cœur de l'utilisation d'IRC est et restera toujours la simple action d'avoir des conversations en temps réel avec d'autres personnes. Nous apprécions cette simplicité, et ne considèrerions que des solutions alternatives partageant ce point de vue.
EOT
);
___('irc_faq_why_simple_body_2',  'EN', <<<EOT
This does not mean that we reject the quality of life features of other real time chat services. If anything, we wish that IRC could find a way to evolve and integrate some of them (being able to chat in threads and adding emoji reactions to messages might be the two most requested ones). Any alternative to IRC that puts chatting first and does not try to overcomplicate itself with useless features but also embraces modern real time chat features would be welcome and taken into consideration.
EOT
);
___('irc_faq_why_simple_body_2',  'FR', <<<EOT
Cela ne signifie pas pour autant que nous rejetons les améliorations proposées par d'autres services de communication en temps réel. Au contraire, nous espérons que IRC pourrait un jour évoluer afin d'en intégrer certaines (les plus demandées sont la possibilité de répondre à des messages spécifiques et de rajouter des réactions à des messages sous forme d'emojis). Toute alternative à IRC faisant passer la conversation en premier mais intégrant tout de même quelques fonctionnalités modernes serait appréciée, et pourrait peut-être même remplacer IRC sur NoBleme dans le futur.
EOT
);

___('irc_faq_why_habit_title',    'EN', "Force of habit");
___('irc_faq_why_habit_title',    'FR', "L'habitude");
___('irc_faq_why_habit_body_1',   'EN', <<<EOT
When weighing the pros and cons of IRC as NoBleme's real time chat solution, it must be reiterated that we have been using it continuously since 2005, thus our community is simply used to it. For some of us, it is a major aspect of our daily lives, which can not be changed on a whim. Only a strictly superior solution would be considered, with no drawbacks compared to our current usage of IRC.
EOT
);
___('irc_faq_why_habit_body_1',   'FR', <<<EOT
Lorsque nous pesons les pour et les contre d'IRC en tant que plateforme de communication en temps réel sur NoBleme, il est important de se souvenir que nous l'utilisons de façon ininterrompue depuis 2005. Notre communauté y est habituée, pour certaines personnes il s'agit même d'une partie importante de leur vie quotidienne. Afin de ne pas bousculer des habitudes pour rien, seule une solution strictement supérieure à IRC serait une alternative acceptable.
EOT
);
___('irc_faq_why_habit_body_2',   'EN', <<<EOT
For those of you who are not convinced by our arguments for IRC but still want to interact with NoBleme's community, you can also find {{link|pages/irc/faq?others|NoBleme on other platforms}} (including the real time chat service Discord). However, IRC will remain the core of NoBleme's community in the foreseeable future, these other platforms are only peripheral services set up to allow those who don't use IRC to keep in touch with NoBleme's activity.
EOT
);
___('irc_faq_why_habit_body_2',   'FR', <<<EOT
Si nos arguments en faveur d'IRC ne sont pas assez convaincants mais que vous souhaitez tout de même interagir avec la communauté de NoBleme, vous pouvez retrouver {{link|pages/irc/faq?others|NoBleme sur d'autres platformes}} (incluant le service de chat en temps réel Discord). Toutefois, IRC restera le cœur de la communauté de NoBleme dans le futur proche, ces autres plateformes ne sont que des services périphériques mis en place afin de permettre à nos membres qui n'utilisent pas IRC de se tenir au courant de l'activité de NoBleme.
EOT
);

___('irc_faq_why_others_title',   'EN', "Alternatives: What will it take to switch?");
___('irc_faq_why_others_title',   'FR', "Alternatives : Que faudra-t-il pour changer ?");
___('irc_faq_why_others_body_1',  'EN', <<<EOT
Every once in a while, we have community driven conversations about switching away from IRC, which so far have always settled on staying on IRC. Even though we currently thrive comfortably on IRC, we are on the lookout for an alternative, and would be open to eventually switching to another platform.
EOT
);
___('irc_faq_why_others_body_1',  'FR', <<<EOT
Nous avons régulièrement des conversations autour de la pertinence d'IRC comme solution de conversation en temps réel, qui jusque-là sont toujours arrivées à la conclusion que rester sur IRC est la meilleure solution. Même si nous sommes actuellement très confortables sur IRC, nous continuons à regarder les alternatives, et conservons une ouverture d'esprit face à l'idée de potentiellement migrer un jour vers une autre plateforme.
EOT
);
___('irc_faq_why_others_body_2',  'EN', <<<EOT
Here is a quick rundown on why we did not switch to the most popular alternatives:
EOT
);
___('irc_faq_why_others_body_2',  'FR', <<<EOT
Voici un résumé de pourquoi nous n'avons pas migré vers les alternatives les plus populaires :
EOT
);
___('irc_faq_why_others_list',    'EN', <<<EOT
<ul>
  <li>
    <span class="bold">Discord, Slack, etc.</span> are privately owned, collect user data, and can not be hosted on NoBleme.
  </li>
  <li>
    <span class="bold">Matrix, Mattermost, Riot, etc.</span> do not add enough in comparison to IRC to warrant the switch.
  </li>
  <li>
    <span class="bold">Telegram, Signal, etc.</span> are linked to your identity and require a mobile device.
  </li>
</ul>
EOT
);
___('irc_faq_why_others_list',    'FR', <<<EOT
<ul>
  <li>
    <span class="bold">Discord, Slack, etc.</span> sont privés, collectent les données personnelles, et ne peuvent pas être hébergés sur les serveurs de NoBleme.
  </li>
  <li>
    <span class="bold">Matrix, Mattermost, Riot, etc.</span> n'ajoutent pas assez de fonctionnalités dont IRC ne dispose pas pour nous convaincre de migrer vers ces plateformes.
  </li>
  <li>
    <span class="bold">Telegram, Signal, etc.</span> sont liés à votre identité et requièrent un appareil mobile.
  </li>
</ul>
EOT
);

___('irc_faq_why_summary_title',  'EN', "In summary…");
___('irc_faq_why_summary_title',  'FR', "En résumé…");
___('irc_faq_why_summary_body_1', 'EN', <<<EOT
Taking all these elements in consideration, it is very likely that we will not switch from IRC to another real time chat service anytime soon. We acknowledge that the barrier of entry can seem high to new users, and are aware that IRC has quality of life limitations compared to more modern solutions, but also consider IRC to be good enough for us currently thanks to an ever evolving ecosystem of modern IRC clients.
EOT
);
___('irc_faq_why_summary_body_1', 'FR', <<<EOT
En prenant tous ces éléments en considération, il est très probable que nous continuions à utiliser IRC comme solution de communication en temps réel à long terme. Nous reconnaissons que la barrière d'entrée peut être effrayante si vous ne connaissez pas encore IRC, et reconnaissons également que IRC ne contient pas autant de fonctionnalités que d'autres alternatives. Toutefois, nous considérons IRC comme étant actuellement la bonne solution pour notre communauté.
EOT
);
___('irc_faq_why_summary_body_2', 'EN', <<<EOT
If you are scared by the barrier of entry, or do not wish to use IRC because it feels outdated, know that we understand your frustration, but be aware that we have no plan to change platform. It will remain the heart of NoBleme's community in the foreseeable future. You can still keep up with NoBleme's activity and interact with some of our community members on {{link|pages/irc/faq?others|other platforms}}, including real time chat on Discord.
EOT
);
___('irc_faq_why_summary_body_2', 'FR', <<<EOT
Si la barrière d'entrée vous repousse, ou si vous ne voulez pas utiliser IRC pour une raison quelconque, sachez que nous comprenons votre frustration, mais sachez également que nous ne prévoyons actuellement pas de changer de plateforme : IRC restera le cœur de la communauté de NoBleme dans le futur proche. Vous pouvez suivre l'activité de NoBleme et interagir avec une partie de sa communauté sur {{link|pages/irc/faq?others|d'autres plateformes}}, incluant le service de chat en temps réel Discord
EOT
);


// FAQ: IRC client
___('irc_faq_client_body_1',          'EN', <<<EOT
Our {{link|pages/irc/faq?browser|browser client}} allows you to easily take part in the conversation, but it lacks all of the customization options that you were promised existed within IRC. This issue is resolved by installing your own IRC client on your devices, or by using a more customizable web client.
EOT
);
___('irc_faq_client_body_1',          'FR', <<<EOT
Notre {{link|pages/irc/faq?browser|client navigateur}} vous permet de facilement rejoindre la conversation, mais ne vous propose pas les options de personnalisation de votre expérience d'utilisation d'IRC que vous pourrez trouver en installant un client IRC, ou en utilisant un client navigateur plus avancé.
EOT
);
___('irc_faq_client_body_2',          'EN', <<<EOT
There exists a huge number of IRC clients, each with their own features (or lack thereof). This page is going to suggest a few popular IRC clients for each platform / operating system. If the suggested ones don't fulfill your needs, feel free to look up alternatives, there is no client specific limitation in place on NoBleme's IRC server.
EOT
);
___('irc_faq_client_body_2',          'FR', <<<EOT
Un grand nombre de clients IRC existent, disposant chacun de leurs propres fonctionnalités spécifiques. Cette page vous suggèrera quelques clients IRC populaires pour chaque plateforme. Si les clients suggérés ne satisfont pas vos attentes, vous pouvez en chercher d'autres : il n'existe aucune restriction d'utilisation de clients spécifiques sur le serveur IRC NoBleme.
EOT
);
___('irc_faq_client_body_3',          'EN', <<<EOT
Regardless of which client you choose to use, you will need to input the following connection information in order to make it connect to NoBleme's IRC server:
EOT
);
___('irc_faq_client_body_3',          'FR', <<<EOT
Une fois votre client IRC choisi, vous aurez besoin d'y rentrer les informations de connection suivantes afin de rejoindre le serveur IRC NoBleme :
EOT
);
___('irc_faq_client_body_4',          'EN', <<<EOT
Once connected to NoBleme's IRC server, you might want to browse the {{link|pages/irc/faq?channels|channel list}} in order to join all channels that could be of interest to you, and to {{link|pages/irc/faq?nickserv|register your username}} in order to gain ownership of your username on the server and have access to a few useful features.
EOT
);
___('irc_faq_client_body_4',          'FR', <<<EOT
Une fois votre client configuré, vous pourrez ensuite parcourir la {{link|pages/irc/faq?channels|liste des canaux}} afin de rejoindre les conversations qui pourraient vous intéresser, et {{link|pages/irc/faq?nickserv|enregistrer votre pseudonyme}} afin d'avoir l'exclusivité de l'utilisation de votre pseudonyme sur le serveur IRC NoBleme.
EOT
);
___('irc_faq_client_body_5',          'EN', <<<EOT
If you get confused or stuck in the process of setting up your IRC client, feel free to ask for help using the {{link|pages/irc/faq?browser|browser client}}. If anyone is around, it is very likely that they will do their best to help you out. If not, be patient, someone will eventually show up.
EOT
);
___('irc_faq_client_body_5',          'FR', <<<EOT
Si une étape du processus de configuration d'un client IRC vous semble confuse ou vous bloque, n'hésitez pas à utiliser le {{link|pages/irc/faq?browser|client navigateur}} pour poser des questions. Si quelqu'un est dans les parages au moment où vous demandez, il est très probable que cette personne essaye de vous aider. Si personne ne vous répond, faites preuve de patience et quelqu'un finira par arriver.
EOT
);

___('irc_faq_client_web_title',       'EN', "Third party web clients");
___('irc_faq_client_web_title',       'FR', "Clients navigateur");
___('irc_faq_client_web_body_1',      'EN', <<<EOT
Web clients have the advantage of not requiring you to install anything on your computer. All you need to do is create an account on a website, which will then remember your customization options.
EOT
);
___('irc_faq_client_web_body_1',      'FR', <<<EOT
Utiliser un client IRC dans votre navigateur a l'avantage de ne pas nécessiter l'installation d'un programme ou d'une application sur vos appareils. Tout ce que vous avez à faire est créer un compte sur un site Internet, qui retiendra ensuite vos options de personnalisation.
EOT
);
___('irc_faq_client_web_body_2',      'EN', <<<EOT
A major downside to this simplicity however is that these clients are hosted by third party websites, which might exploit your user data, or even monitor your conversations. On top of that, you are relying on their website to stay online at all times, any downtime of their platform will mean that you are unable to access IRC during that time - or even permanently if their platform ever shuts down.
EOT
);
___('irc_faq_client_web_body_2',      'FR', <<<EOT
La cotrepartie de cette simplicité est que ces clients sont hébergés sur des sites tiers, qui peuvent potentiellement collecter et utiliser vos données personnelles, voir même monitorer vos conversations. De plus, vous devez compter sur la disponibilité de leur plateforme : si leur site est KO, votre accès à IRC sera également KO pendant ce temps.
EOT
);
___('irc_faq_client_web_body_3',      'EN', <<<EOT
{{external|https://www.irccloud.com|IRCCloud}} is a solid web client with a highly customizable user experience and a lot of modern features. It also comes with partial {{link|pages/irc/faq?bouncer|bouncer}} capabilities and high quality mobile applications for Android and iOS. There is an optional paying service which acts as a full time {{link|pages/irc/faq?bouncer|bouncer}}, but worry not, the free tier gives you access to every other feature, there is no need to pay for anything.
EOT
);
___('irc_faq_client_web_body_3',      'FR', <<<EOT
{{external|https://www.irccloud.com|IRCCloud}} est un client navigateur hautement personnalisable contenant de nombreuses fonctionnalités modernes. Il inclut un {{link|pages/irc/faq?bouncer|bouncer}} partiel, et des applications mobiles de haute qualité pour Android et iOS. Le site vous propose de payer pour avoir un {{link|pages/irc/faq?bouncer|bouncer}} permanent, mais ne vous inquiétez pas, l'option gratuite vous donne accès à toutes les autres fonctionnalités.
EOT
);
___('irc_faq_client_web_body_4',      'EN', <<<EOT
{{external|https://kiwiirc.com|KiwiIRC}} is a very simplistic web client with a few modern features. It is often used to embed onto websites: in fact we use it as our {{link|pages/irc/faq?browser|browser client}} on NoBleme. It also lets you register an account and can act as your regular IRC client - a simple yet efficient option.
EOT
);
___('irc_faq_client_web_body_4',      'FR', <<<EOT
{{external|https://kiwiirc.com|KiwiIRC}} est un client navigateur très simple incorporant quelques fonctionnalités modernes. NoBleme utilise KiwiIRC pour son {{link|pages/irc/faq?browser|client navigateur intégré}}, mais vous pouvez également créer un compte directement sur leur site et vous en servir comme client IRC permanent.
EOT
);

___('irc_faq_client_computer_title',  'EN', "Computer software");
___('irc_faq_client_computer_title',  'FR', "Applications pour ordinateur");
___('irc_faq_client_computer_body_1', 'EN', <<<EOT
If you'd rather install an IRC client on your computer, there are a lot of options to choose from. Most of them tend to be cross platform and work at least on Windows, Mac OS, and Linux.
EOT
);
___('irc_faq_client_computer_body_1', 'FR', <<<EOT
Si vous préférez garder le contrôle de vos données et installer un client IRC sur votre ordinateur, il existe de nombreuses options, dont la majorité sont compatibles avec Windows, Mac OS, et Linux.
EOT
);
___('irc_faq_client_computer_body_2', 'EN', <<<EOT
{{external|https://hexchat.github.io/|HexChat}} is one of the most common IRC clients for Windows, Mac OS, and Linux. Despite its simplistic (and a bit outdated) interface, it is fairly easy to configure, customize, and use for chatting.
EOT
);
___('irc_faq_client_computer_body_2', 'FR', <<<EOT
{{external|https://hexchat.github.io/|HexChat}} est un des clients IRC les plus courants pour Windows, Mac OS, et Linux. Malgré son interface simple (et dépassée), il est très simple à configurer, à personnaliser, et à utiliser pour discuter.
EOT
);
___('irc_faq_client_computer_body_3', 'EN', <<<EOT
{{external|https://quassel-irc.org/|Quassel}} is another solution available for Windows, Mac OS, and Linux. It is much more complicated to configure and use, but comes with more flexibility in how you want your user experience to be.
EOT
);
___('irc_faq_client_computer_body_3', 'FR', <<<EOT
{{external|https://quassel-irc.org/|Quassel}} est une autre option pour Windows, Mac OS, et Linux. Ce client est beaucoup plus compliqué à configurer et utiliser, mais offre en retour plus de flexibilité dans la personnalisation de votre expérience d'utilisation d'IRC.
EOT
);
___('irc_faq_client_computer_body_4', 'EN', <<<EOT
{{external|https://weechat.org/|WeeChat}} is a Linux only solution for the more technically inclined - avoid it if you are not versed in computer science. It is a purely command line client, which can be ran on a server and give you full {{link|pages/irc/faq?bouncer|bouncer}} capabilities. You can then access it through {{external|https://www.glowing-bear.org/|Glowing Bear}} for a better user experience.
EOT
);
___('irc_faq_client_computer_body_4', 'FR', <<<EOT
{{external|https://weechat.org/|WeeChat}} est un client disponible uniquement sous Linux à destination des personnes ayant un profil technique avancé - ne cherchez pas à l'utiliser si vous ne vous y connaissez pas en administration serveur. Il s'agit d'un client purement en ligne de commande, qui peut servir de {{link|pages/irc/faq?bouncer|bouncer}} une fois installé sur un serveur, et peut ensuite être utilisé via {{external|https://www.glowing-bear.org/|Glowing Bear}} pour une meilleure expérience d'utilisation.
EOT
);

___('irc_faq_client_mobile_title',    'EN', "Mobile applications");
___('irc_faq_client_mobile_title',    'FR', "Applications mobiles");
___('irc_faq_client_mobile_body_1',   'EN', <<<EOT
When away from your computer, or if you choose to use a mobile device instead of a computer as your main computing device, you will need to use an IRC client in the form of a mobile application.
EOT
);
___('irc_faq_client_mobile_body_1',   'FR', <<<EOT
Lorsque vous n'êtes pas sur votre ordinateur, ou si vous utilisez un appareil mobile à la place d'un ordinateur dans votre vie courante, vous aurez besoin d'un client IRC à destination des appareils mobiles.
EOT
);
___('irc_faq_client_mobile_body_2',   'EN', <<<EOT
{{external|https://www.irccloud.com|IRCCloud}} has already been mentioned earlier as a third party web option, it also happens to come with high quality mobile applications for Android and iOS. Keep in mind that the downside of this solution is that you are using a third party service, which might collect and use your personal data.
EOT
);
___('irc_faq_client_mobile_body_2',   'FR', <<<EOT
{{external|https://www.irccloud.com|IRCCloud}} a déjà été mentionné plus tôt comme une option de client navigateur, cette plateforme propose également des applications mobiles de haute qualité pour Android et iOS. Gardez à l'esprit qu'en contrepartie de leur solution qualitative, IRCCloud est un service tiers, qui peut potentiellement collecter et utiliser vos données personnelles.
EOT
);
___('irc_faq_client_mobile_body_3',   'EN', <<<EOT
{{external|https://play.google.com/store/apps/details?id=app.holoirc|HoloIRC}} is a minimalistic, simple, and efficient IRC client for Android. It has BNC support, which means it can be used to connect to a {{link|pages/irc/faq?bouncer|bouncer}} if you have access to one or are technically inclined enough to set one up.
EOT
);
___('irc_faq_client_mobile_body_3',   'FR', <<<EOT
{{external|https://play.google.com/store/apps/details?id=app.holoirc|HoloIRC}} est un client IRC Android minimaliste, simple, et efficace. Il permet de se connecter à un serveur (comme celui de NoBleme), mais également à un {{link|pages/irc/faq?bouncer|bouncer}} si vous avez les compétences techniques requises pour en mettre un en place.
EOT
);
___('irc_faq_client_mobile_body_4',   'EN', <<<EOT
{{external|https://iglooirc.com/|Igloo IRC}} is a minimalistic, simple, and efficient IRC client for iOS. It has BNC support, which means it can be used to connect to a {{link|pages/irc/faq?bouncer|bouncer}} if you have access to one or are technically inclined enough to set one up.
EOT
);
___('irc_faq_client_mobile_body_4',   'FR', <<<EOT
{{external|https://iglooirc.com/|Igloo IRC}} est un client IRC iOS minimaliste, simple, et efficace. Il permet de se connecter à un serveur (comme celui de NoBleme), mais également à un {{link|pages/irc/faq?bouncer|bouncer}} si vous avez les compétences techniques requises pour en mettre un en place.
EOT
);


// FAQ: Bouncer
___('irc_faq_bouncer_body_1',       'EN', <<<EOT
A limitation of IRC is that while you are not connected to the server, you can not know which conversations are going on, and thus miss out on some chat history. To some people, this is actually a desirable thing. To others, it is an annoyance. If you are part of the latter, then bouncers are the solution you are looking for.
EOT
);
___('irc_faq_bouncer_body_1',       'FR', <<<EOT
Une limitation d'IRC est l'absence d'histoirique des conversations lorsque vous n'avez pas de client IRC connecté au serveur IRC. Pour certaines personnes, il s'agit de quelque chose de désirable. Pour d'autres, c'est un problème. Si vous faites partie de la seconde catégorie, les bouncers sont la réponse à ce problème.
EOT
);
___('irc_faq_bouncer_body_2',       'EN', <<<EOT
A bouncer is an IRC tool which, instead of being installed on your personal computer or device, is instead installed on a distant server. This allows it to be connected to IRC at all times, thus ensuring you never miss out on any chat history when your computer or devices are shut down or not connected to IRC.
EOT
);
___('irc_faq_bouncer_body_2',       'FR', <<<EOT
Un bouncer est un outil qui, au lieu d'être installé sur votre ordinateur ou appareil personnel, est à la place installé sur un serveur distant. Cela lui permet d'être connecté à IRC en permanence, et de continuer à recevoir les messages sur IRC lorsque votre ordinateur ou vos appareils sont éteints ou non connectés à IRC.
EOT
);
___('irc_faq_bouncer_body_3',       'EN', <<<EOT
Bouncers work in such a way that instead of using your IRC client to connect to NoBleme's IRC server, you would instead use your IRC client to connect to your IRC bouncer which is permanently connected to NoBleme's IRC server.
EOT
);
___('irc_faq_bouncer_body_3',       'FR', <<<EOT
Le fonctionnement d'un bouncer peut se résumer ainsi : au lieu de connecter votre client IRC au serveur IRC de NoBleme, vous connectez votre client IRC à votre bouncer, qui est connecté en permanence au serveur IRC de NoBleme.
EOT
);
___('irc_faq_bouncer_body_4',       'EN', <<<EOT
Sadly, there are no easy solutions to set up a bouncer. If you lack the technical knowledge required to do server administration, then you will not be able to install your own bouncer, and will need to use third party solutions or manage to find someone generous enough to lend you access to a bouncer on their own server.
EOT
);
___('irc_faq_bouncer_body_4',       'FR', <<<EOT
Malheureusement, il n'existe pas de solution simple pour mettre en place un bouncer. Si vous n'avez pas les compétences techniques requises pour faire de l'administration serveur, vous ne pourrez pas installer de bouncer, et devrez plutôt utiliser des solutions tierces ou trouver une personne assez généreuse pour vous prêter l'accès à un bouncer sur son serveur personnel.
EOT
);

___('irc_faq_bouncer_third_title',  'EN', "Third party bouncer services");
___('irc_faq_bouncer_third_title',  'FR', "Services tiers de bouncer");
___('irc_faq_bouncer_third_body_1', 'EN', <<<EOT
A few websites offer partial or full IRC bouncer services. Keep in mind however that these websites being third party services, they might collect or exploit your user data, or even monitor your conversations. On top of that, you are relying on their website to stay online at all times, any downtime of their platform will mean that you are unable to access IRC during that time - or even permanently if their platform ever shuts down.
EOT
);
___('irc_faq_bouncer_third_body_1', 'FR', <<<EOT
Quelques sites Internet offrent des services partiels ou complets de bouncer IRC. Ayez toutefois à l'esprit que ces sites sont des services tiers, et peuvent donc potentiellement collecter ou utiliser vos données personnelles, voir même monitorer vos conversations. De plus, vous devez compter sur la disponibilité de leur plateforme : si leur site est KO, votre accès à IRC sera également KO pendant ce temps.
EOT
);
___('irc_faq_bouncer_third_body_2', 'EN', <<<EOT
{{external|https://wiki.znc.in/Providers|Some free ZNC providers}} exist (ZNC is the most commonly used bouncer). Each of them require you to follow a unique and specific process to create your bouncer instance, which you can then connect to using any IRC client of your choice. Be aware that some of these are restricted to specific IRC networks, and thus might not allow you to create a bouncer instance connected to NoBleme's IRC server. It might be a bit of a pain to figure out how to go through the setup process, but at least once it is done you do not have to worry about it anymore and can focus on using IRC normally.
EOT
);
___('irc_faq_bouncer_third_body_2', 'FR', <<<EOT
{{external|https://wiki.znc.in/Providers|Des fournisseurs gratuits de ZNC}} existent (ZNC est le bouncer le plus communément utilisé). Chacun d'entre eux vous demande de suivre un processus unique et spécifique pour vous mettre en place un bouncer, auquel vous pourrez ensuite vous connecter avec le client IRC de votre choix. Une maitrise basique de l'anglais technique est requise pour utiliser ces services. Notez que certains de ces services sont restreints à certains serveurs IRC, et ne peuvent donc pas être utilisés sur le seurvr IRC de NoBleme. Le processus de mise en place d'un bouncer gratuit est complexe, mais une fois fini vous n'aurez plus à vous en soucier et pourrez vous concentrer sur l'utilisation d'IRC au quotidien.
EOT
);
___('irc_faq_bouncer_third_body_3', 'EN', <<<EOT
{{external|https://www.irccloud.com/|IRCCloud}} is a browser IRC client which also includes mobile applications for Android and iOS, aswell as a partial bouncer service (keeps tracking chat history for 2 hours after you log out). The service is free, but includes an optional paid solution (4€/month) which enables full bouncer capabilities, tracking full chat history no matter how long you are offline.
EOT
);
___('irc_faq_bouncer_third_body_3', 'FR', <<<EOT
{{external|https://www.irccloud.com/|IRCCloud}} est un client IRC navigateur qui propose également des applications mobiles pour Android et iOS, ainsi qu'un service de bouncer partiel (conserve l'historique des conversations IRC qui ont lieu dans les deux heures suivant votre déconnexion). Le service est gratuit, mais inclut également une solution payante optionnelle (4€/mois) qui en fait un bouncer complet, vous donnant un historique de toutes les conversations qui ont lieu lorsque vous êtes hors ligne.
EOT
);

___('irc_faq_bouncer_tech_title',   'EN', "For the more technically inclined");
___('irc_faq_bouncer_tech_title',   'FR', "Pour les personnes techniques");
___('irc_faq_bouncer_tech_body_1',  'EN', <<<EOT
If you already know how to setup a server, then you should not need advanced instructions on how to setup a bouncer - simply following the instructions in your bouncer of choice's documentation should be enough. Here are two common bouncers that are easy to setup and use.
EOT
);
___('irc_faq_bouncer_tech_body_1',  'FR', <<<EOT
Si vous savez déjà administrer un serveur, vous n'aurez pas besoin d'instructions supplémentaires pour mettre en place un bouncer - il vous suffira de suivre les instructions contenues dans la documentation du bouncer que vous choisirez. Voici deux options de bouncers simples à mettre en place et à utiliser.
EOT
);
___('irc_faq_bouncer_tech_body_2',  'EN', <<<EOT
{{external|https://wiki.znc.in/ZNC|ZNC}} is the most common bouncer choice, and has been the "standard" choice for a very long time. Its {{external|https://wiki.znc.in/Webadmin|webadmin module}} allows you to easily administrate user accounts on your ZNC instance if you want to offer bouncer services to other people.
EOT
);
___('irc_faq_bouncer_tech_body_2',  'FR', <<<EOT
{{external|https://wiki.znc.in/ZNC|ZNC}} est le choix de bouncer le plus commun, et est l'option "standard" depuis très longtemps. Son {{external|https://wiki.znc.in/Webadmin|module webadmin}} vous permet d'aministrer facilement des comptes sur votre instance ZNC, vous permettant si vous le désirez de partager votre service de bouncer avec d'autres personnes.
EOT
);
___('irc_faq_bouncer_tech_body_3',  'EN', <<<EOT
{{external|https://thelounge.chat/|The Lounge}} is a two for one solution, being both a bouncer and a modern browser IRC client with an interface that works well on both computers and mobile devices. As with ZNC, {{external|https://thelounge.chat/docs/users|you can add users}} to your installation of The Lounge if you want to offer bouncer services to other people.
EOT
);
___('irc_faq_bouncer_tech_body_3',  'FR', <<<EOT
{{external|https://thelounge.chat/|The Lounge}} est une solution deux en un, étant à la fois un bouncer et un client IRC navigateur, disposant d'une interface moderne sur ordinateur comme sur appareils mobiles. Comme sur ZNC, vous pouvez {{external|https://thelounge.chat/docs/users|gérer des comptes}} sur votre instance de The Lounge, et partager votre service de bouncer avec d'autres personnes.
EOT
);


// FAQ: Vocabulary
___('irc_faq_vocabulary_title_1',   'EN', "Server");
___('irc_faq_vocabulary_title_1',   'FR', "Serveur");
___('irc_faq_vocabulary_body_1',    'EN', <<<EOT
The server is the interface to which everyone is connected in order to chat on IRC. When you send a message on IRC, it is first sent to the server, which then redistributes it to the people who should see that message. In NoBleme's case, the server is software called {{external|https://en.wikipedia.org/wiki/UnrealIRCd|UnrealIRCd}}.
EOT
);
___('irc_faq_vocabulary_body_1',    'FR', <<<EOT
Le serveur est l'interface à laquelle tout le monde est connecté pour discuter sur IRC. Lorsque vous envoyez un message sur IRC, il est d'abord envoyé au serveur, qui le redistribue ensuite. Dans le cas de NoBleme, il s'agit d'un programme nommé {{external|https://en.wikipedia.org/wiki/UnrealIRCd|UnrealIRCd}}.
EOT
);
___('irc_faq_vocabulary_title_2',   'EN', "Client");
___('irc_faq_vocabulary_title_2',   'FR', "Client");
___('irc_faq_vocabulary_body_2',    'EN', <<<EOT
An IRC client is a computer program or application that serves as an interface between a user and an IRC server. Each client has their own interface, appearance, and settings, which means that everyone sees IRC differently.
EOT
);
___('irc_faq_vocabulary_body_2',    'FR', <<<EOT
Un client IRC est un programme ou une application qui sert d'interface entre un serveur IRC et vous. Chaque client possède sa propre interface, apparence, et ses propre réglages, ce qui permet à plusieurs personnes d'avoir une expérience différente d'IRC selon leur choix de client et de configuration.
EOT
);
___('irc_faq_vocabulary_title_3',  'EN', "Bouncer");
___('irc_faq_vocabulary_title_3',  'FR', "Bouncer");
___('irc_faq_vocabulary_body_3',   'EN', <<<EOT
A bouncer is a tool that allows you to retain full history of conversations which happen on IRC, even while you are offline. You can find out more about bouncers on the {{link|pages/irc/faq?bouncer|bouncer}} page of this FAQ.
EOT
);
___('irc_faq_vocabulary_body_3',   'FR', <<<EOT
Un bouncer est un outil qui reste connecté en permanence à un serveur IRC, vous permettant de garder un historique complet des conversations qui ont lieu pendant votre absence.  Vous trouverez plus d'informations sur les bouncers dans la section {{link|pages/irc/faq?bouncer|bouncer}} de cette FAQ.
EOT
);
___('irc_faq_vocabulary_title_4',   'EN', "Channel");
___('irc_faq_vocabulary_title_4',   'FR', "Canal");
___('irc_faq_vocabulary_body_4',    'EN', <<<EOT
An IRC server is comprised of an unlimited number of channels, which can be public or private. When a message is sent on an IRC channel, only the users present on that channel will be able to read the message. IRC channel names begin with the pound sign (#NoBleme, #english, #dev). You can find more information about IRC channels on the {{link|pages/irc/faq?channels|channel list}}.
EOT
);
___('irc_faq_vocabulary_body_4',    'FR', <<<EOT
Un serveur IRC est constitué d'un nombre potentiellement infini de canaux de discussion, qui peuvent être publics ou privés. Lorsqu'un message est envoyé sur un canal, il ne sera visible que par les personnes qui y sont présentes à ce moment-là. Le nom des canaux IRC commence par un symbole croisillon (#NoBleme, #english, #dev). Vous trouverez plus d'informations sur les canaux sur la {{link|pages/irc/faq?channels|liste des canaux}}.
EOT
);
___('irc_faq_vocabulary_title_5',   'EN', "Operator");
___('irc_faq_vocabulary_title_5',   'FR', "Operator");
___('irc_faq_vocabulary_body_5',    'EN', <<<EOT
A channel's founder can give some abilities to specific users (such as the ability to kick problematic users) by making them channel operators. Different operator types have different abilities, which are documented at the bottom of this page in the symbols section. There are also global operators, which have the power to shut down channels, issue server-wide bans, and possess a few more tools useful in extreme situations. In order to avoid tracking their absence to plan mischievous acts when none of them are online, the identity of global operators will remain a secret.
EOT
);
___('irc_faq_vocabulary_body_5',    'FR', <<<EOT
La personne qui crée un canal peut déléguer des pouvoirs (par exemple le pouvoir d'éjecter les personnes problématiques) en donnant le statut d'Operator à d'autres personnes. Différents types d'Operator ont différents pouvoirs, qui sont documentés dans un tableau en bas de cette page. Il existe également des Operator globaux, qui ont le pouvoir de supprimer des canaux, d'éjecter des personnes du serveur IRC NoBleme, et quelques autres outils utiles en cas de problèmes majeurs. Afin d'éviter une situation où quelqu'un attendrait que les Operator globaux soient hors ligne pour causer des problèmes, leur identité restera secrète.
EOT
);
___('irc_faq_vocabulary_title_6',   'EN', "Kick / Ban");
___('irc_faq_vocabulary_title_6',   'FR', "Kick / Bannissement");
___('irc_faq_vocabulary_body_6',    'EN', <<<EOT
When a user misbehaves or breaks the {{link|pages/doc/coc|code of conduct}}, a few measures can be taken by operators against them. A kick will remove them from the channel, but leave them the ability to rejoin it afterwards, acting as a warning that they should keep it cool. A ban will exclude them from the channel and prevent them from rejoining it, for a set amount of time (which can be forever).
EOT
);
___('irc_faq_vocabulary_body_6',    'FR', <<<EOT
Lorsqu'une personne pose problème ou ne respecte pas le {{link|pages/doc/coc|code de conduite}}, les Operator disposent de pouvoirs permettant de les modérer. Un kick éjecte une personne d'un canal, mais leur donne la possibilité de le rejoindre de nouveau, il sert d'avertissement qu'il faut se calmer. Un bannissement les exclut du canal et les empêche de le rejoindre pendant un temps prédéterminé (ou peut être permanent).
EOT
);
___('irc_faq_vocabulary_title_7',   'EN', "Services: NickServ & ChanServ");
___('irc_faq_vocabulary_title_7',   'FR', "Services : NickServ & ChanServ");
___('irc_faq_vocabulary_body_7',    'EN', <<<EOT
All actions related to user accounts or channel administrations are done through what are called Services, special users on the IRC network which go by the usernames NickServ (for users) and ChanServ (for channels). You can read more about them on the {{link|pages/irc/faq?nickserv|NickServ}} and {{link|pages/irc/faq?chanserv|ChanServ}} pages of this FAQ.
EOT
);
___('irc_faq_vocabulary_body_7',    'FR', <<<EOT
Toutes les actions touchant aux comptes des membres ou à l'administration des canaux se font via des utilisateurs automatisés nommés "Services", qui sont présents de façon permanente sur le serveur IRC NoBleme sous le nom NickServ (pour gérer les comptes) et ChanServ (pour gérer les canaux). Vous pouvez en apprendre plus à leur sujet dans les sections {{link|pages/irc/faq?nickserv|NickServ}} et {{link|pages/irc/faq?chanserv|ChanServ}} de cette FAQ.
EOT
);
___('irc_faq_vocabulary_title_8',   'EN', "Command");
___('irc_faq_vocabulary_title_8',   'FR', "Commande");
___('irc_faq_vocabulary_body_8',    'EN', <<<EOT
On IRC, in order to do any action other than chatting, you must use commands. They are sent on the server the same way as normal chat messages, but begin with a slash / character. For example, joining a channel is done by typing <span class="monospace">/join #channel</span>. You will find a guide of useful commands in the {{link|pages/irc/faq?commands|commands}}, {{link|pages/irc/faq?nickserv|NickServ}}, and {{link|pages/irc/faq?chanserv|ChanServ}} pages of this FAQ.
EOT
);
___('irc_faq_vocabulary_body_8',    'FR', <<<EOT
Si vous désirez effectuer n'importe quelle action autre que discuter sur IRC, vous devrez utiliser des commandes. Il s'agit de messages normaux envoyés sur le serveur de la même façon que lorsque vous discutez, mais dont le premier caractère est un / slash. Par exemple, rejoindre un canal se fait en envoyant le message <span class="monospace">/join #channel</span>. Vous trouverez une liste de commandes utiles dans les sections {{link|pages/irc/faq?commands|commandes}}, {{link|pages/irc/faq?nickserv|NickServ}}, et {{link|pages/irc/faq?chanserv|ChanServ}} de cette FAQ.
EOT
);
___('irc_faq_vocabulary_title_9',   'EN', "Mode");
___('irc_faq_vocabulary_title_9',   'FR', "Mode");
___('irc_faq_vocabulary_body_9',    'EN', <<<EOT
IRC channels have settings which are controlled by operators through changing what is called a "mode". It is materialized as a series of letters defining what can or cannot be done on that channel. For example, a channel with <span class="monospace">mode +m</span> is in mute mode: only operators and voiced users can chat in that channel, others will not be able to send messages.
EOT
);
___('irc_faq_vocabulary_body_9',    'FR', <<<EOT
Les canaux IRC peuvent être modifiés par des Operator en leur appliquant ce qui s'appelle un "mode". Il s'agit de réglages représentés par une série de lettres déterminant ce qui peut ou ne peut pas être fait sur un canal spécifique. Par exemple, un canal ayant le <span class="monospace">mode +m</span> est en mode muet : il n'y a que les Operators qui peuvent discuter sur ce canal, les autres ne pourront pas envoyer de messages.
EOT
);
___('irc_faq_vocabulary_title_10',   'EN', "Highlight");
___('irc_faq_vocabulary_title_10',   'FR', "Highlight (surlignage)");
___('irc_faq_vocabulary_body_10',    'EN', <<<EOT
In most IRC clients, when someone else writes your username, you will get notified in some way and see the line of text highlighted. Thus, highlighting someone is the term used for when you aim a message at a specific person on IRC by including their username in the message.
EOT
);
___('irc_faq_vocabulary_body_10',    'FR', <<<EOT
Dans la plupart des clients IRC, lorsque quelqu'un d'autre écrit votre pseudonyme, vous recevrez une notification et verrez la ligne de texte en question surlignée. Le mot highlight (surlignage en anglais) est par conséquent utilisé pour nommer l'action d'inclure le pseudonyme de quelqu'un d'autre dans un message.
EOT
);
___('irc_faq_vocabulary_title_11',  'EN', "Lurk");
___('irc_faq_vocabulary_title_11',  'FR', "Lurk");
___('irc_faq_vocabulary_body_11',   'EN', <<<EOT
A lurker is someone who idles in an IRC channel without sending any messages. Lurkers are as welcome as anyone else on NoBleme's IRC server, we have no issue with users who do not participate in the conversation.
EOT
);
___('irc_faq_vocabulary_body_11',   'FR', <<<EOT
Lorsqu'une personne est présente sur un canal IRC mais n'y participe jamais / n'y envoie jamais de messages, cette personne peut se faire appeler "lurker" (anglais pour une personne qui rôde). Certains serveurs IRC n'apprécient pas les lurkers, mais nous n'avons aucun problème avec leur présence sur NoBleme : vous êtes libre de rester sur notre serveur IRC même sans y participer.
EOT
);
___('irc_faq_vocabulary_title_12',  'EN', "Bot");
___('irc_faq_vocabulary_title_12',  'FR', "Bot");
___('irc_faq_vocabulary_body_12',   'EN', <<<EOT
Not every user on IRC is tied to a human person, some are automated computer programs which we call "Bots". They have different uses and abilities depending on the type of bot they are, you can find out more about them on the {{link|pages/irc/faq?bots|bots}} page of this FAQ.
EOT
);
___('irc_faq_vocabulary_body_12',   'FR', <<<EOT
Tous les pseudonymes sur IRC ne cachent pas un être humain, certains correspondent à des programmes informatiques automatisés que nous appelons des "Bots". Leur utilité varie d'un bot à l'autre, vous pouvez en apprendre plus à leur sujet sur la page {{link|pages/irc/faq?bots|bots}} de cette FAQ.
EOT
);


// FAQ: Symbols
___('irc_faq_symbols_title',          'EN', "Operator and user symbols");
___('irc_faq_symbols_title',          'FR', "Operators et symboles");
___('irc_faq_symbols_body_1',         'EN', <<<EOT
On IRC channels, some users can be given operator abilities, which allow them to manage the channel and handle problematic users. In most IRC clients, operator levels are represented through specific symbols, which appear before the user's username (for example, @Planeshift or ~Bad). These also correspond to a specific user mode, represented by a letter (for example, a channel operator will have +o mode on that channel).
EOT
);
___('irc_faq_symbols_body_1',         'FR', <<<EOT
Sur les canaux IRC, certaines personnes peuvent avoir des pouvoirs d'Operator, qui leur permettent de modérer les personnes problématiques et de gérer le canal. Dans la plupart des clients IRC, des symboles spécifiques sont assignés aux Operators, apparaissant juste avant leur pseudonyme (par exemple @Planeshift ou ~Bad). À chaque type d'Operator correspond également un "mode", une lettre qui est utilisée pour modifier les pouvoirs d'une personne sur un canal spécifique.
EOT
);
___('irc_faq_symbols_body_2',         'EN', <<<EOT
You can find out more about operator rights and how to manage them on the {{link|pages/irc/faq?chanserv|ChanServ}} page of this FAQ. Below is a table of user modes and symbols, and their associated abilities.
EOT
);
___('irc_faq_symbols_body_2',         'FR', <<<EOT
Vous trouverez plus d'informations sur les Operator et comment gérer et utiliser leurs pouvoirs sur la page {{link|pages/irc/faq?chanserv|ChanServ}} de cette FAQ. Ci-dessous, un tableau des modes et symboles des Operator, et des pouvoirs qui y sont associés.
EOT
);

___('irc_faq_symbols_name',           'EN', "Title");
___('irc_faq_symbols_name',           'FR', "Titre");
___('irc_faq_symbols_symbol',         'EN', "Symbol");
___('irc_faq_symbols_symbol',         'FR', "Symbole");
___('irc_faq_symbols_mode',           'EN', "Mode");
___('irc_faq_symbols_mode',           'FR', "Mode");
___('irc_faq_symbols_abilities',      'EN', "Abilities");
___('irc_faq_symbols_abilities',      'FR', "Pouvoirs");
___('irc_faq_symbols_user',           'EN', "User");
___('irc_faq_symbols_user',           'FR', "User");
___('irc_faq_symbols_user_desc',      'EN', "Regular user");
___('irc_faq_symbols_user_desc',      'FR', "Personne normale.");
___('irc_faq_symbols_voice',          'EN', "Voiced");
___('irc_faq_symbols_voice',          'FR', "Voiced");
___('irc_faq_symbols_voice_desc',     'EN', "Can still send messages if the channel is set to mute (+m) mode.");
___('irc_faq_symbols_voice_desc',     'FR', "Peut envoyer des messages même si le canal est en mode muet (+m).");
___('irc_faq_symbols_halfop',         'EN', "Halfop");
___('irc_faq_symbols_halfop',         'FR', "Halfop");
___('irc_faq_symbols_halfop_desc',    'EN', "Half operator. Can kick regular users.");
___('irc_faq_symbols_halfop_desc',    'FR', "Demi-Operator. Peut kick les User et Voiced.");
___('irc_faq_symbols_operator',       'EN', "Operator");
___('irc_faq_symbols_operator',       'FR', "Operator");
___('irc_faq_symbols_operator_desc',  'EN', "Can kick or ban anyone who is not an admin or channel founder.");
___('irc_faq_symbols_operator_desc',  'FR', "Peut kick ou ban toute personne qui n'est pas Admin ou Founder.");
___('irc_faq_symbols_admin',          'EN', "Admin");
___('irc_faq_symbols_admin',          'FR', "Admin");
___('irc_faq_symbols_admin_desc',     'EN', "Can kick or ban anyone who is not channel founder, and can name or remove operators.");
___('irc_faq_symbols_admin_desc',     'FR', "Peut kick ou ban toute personne qui n'est pas Founder, gérer le canal, et nommer ou révoquer des Operators.");
___('irc_faq_symbols_founder',        'EN', "Founder");
___('irc_faq_symbols_founder',        'FR', "Founder");
___('irc_faq_symbols_founder_desc',   'EN', "Can kick or ban anyone and name or remove admins and operators. There can only be one founder per channel at any given time.");
___('irc_faq_symbols_founder_desc',   'FR', "Dispose des pouvoirs d'admin, et peut également nommer ou révoquer des Admin. Il ne peut y avoir qu'une seule personne à la fois portant le titre de Founder sur un canal.");


// FAQ: Commands
___('irc_faq_commands_body_1',    'EN', <<<EOT
On IRC, any action other than chatting is done through what are called "commands". They are regular chat messages, with the only difference being that their first character must always be a / slash. It does not matter in which channel you send the commands, they will always be invisible to other users.
EOT
);
___('irc_faq_commands_body_1',    'FR', <<<EOT
Sur IRC, toute action autre que discuter se fait via ce qu'on appelle des commandes. Il s'agit de messages normaux, envoyés de la même façon que des lignes de conversation, à la différence que leur premier caractère est nécessairement un / slash. Peu importe dans quel canal vous écrivez des commandes, elles seront toujours invisibles aux autres personnes qui y sont présentes.
EOT
);
___('irc_faq_commands_body_2',    'EN', <<<EOT
You will find a list of a few useful commands below. When a word is between [brackets], then it means that its value can be anything you want and you should replace it with something else. For example, if given the command <span class="monospace">/join #[channel]</span>, you should use it as <span class="monospace">/join #NoBleme</span> or <span class="monospace">/join #english</span>.
EOT
);
___('irc_faq_commands_body_2',    'FR', <<<EOT
Vous trouverez ci-dessous une liste de quelques commandes utiles. Lorsqu'un mot est entre [crochets], cela signifie que sa valeur est à personnaliser. Par exemple, lorsque la commande <span class="monospace">/join #[canal]</span> est documentée, vous pouvez l'utiliser comme <span class="monospace">/join #NoBleme</span> ou <span class="monospace">/join #english</span>.
EOT
);
___('irc_faq_commands_body_3',    'EN', <<<EOT
More commands relating to account management and channel management can be found in the {{link|pages/irc/faq?nickserv|NickServ}} and {{link|pages/irc/faq?chanserv|ChanServ}} pages of this FAQ.
EOT
);
___('irc_faq_commands_body_3',    'FR', <<<EOT
Des commandes additionnelles liées à la gestion des comptes et des canaux se trouvent sur les pages {{link|pages/irc/faq?nickserv|NickServ}} et {{link|pages/irc/faq?chanserv|ChanServ}} de cette FAQ.
EOT
);

___('irc_faq_commands_server',    'EN', "[server]");
___('irc_faq_commands_server',    'FR', "[serveur]");
___('irc_faq_commands_channel',   'EN', "[channel]");
___('irc_faq_commands_channel',   'FR', "[canal]");
___('irc_faq_commands_username',  'EN', "[username]");
___('irc_faq_commands_username',  'FR', "[pseudonyme]");
___('irc_faq_commands_message',   'EN', "[message]");
___('irc_faq_commands_message',   'FR', "[message]");
___('irc_faq_commands_password',  'EN', "[password]");
___('irc_faq_commands_password',  'FR', "[mot-de-passe]");
___('irc_faq_commands_newpass',   'EN', "[new-password]");
___('irc_faq_commands_newpass',   'FR', "[nouveau-mot-de-passe]");
___('irc_faq_commands_text',      'EN', "[text]");
___('irc_faq_commands_text',      'FR', "[texte]");
___('irc_faq_commands_hostmask',  'EN', "[hostmask]");
___('irc_faq_commands_hostmask',  'FR', "[hostmask]");
___('irc_faq_commands_number',    'EN', "[number]");
___('irc_faq_commands_number',    'FR', "[nombre]");

___('irc_faq_commands_clear',     'EN', <<<EOT
Clears the currently visible chat messages by removing all text on your screen. Useful in case of clutter, or if you want to hide some history from view. This does not however permanently delete any archived chat logs, and does not clear the screens of other users' IRC clients (everyone else will still see the message history).
EOT
);
___('irc_faq_commands_clear',     'FR', <<<EOT
Supprime tous les messages visibles à l'écran. Pratique si du contenu indésirable est sur votre écran, ou si vous voulez vous souvenir de jusqu'où vous avez suivi une discussion. Cela n'affecte pas les autres personnes (seul votre client aura son écran nettoyé).
EOT
);
___('irc_faq_commands_quit',      'EN', <<<EOT
Disconnects you from the IRC server which you are currently using.
EOT
);
___('irc_faq_commands_quit',      'FR', <<<EOT
Vous déconnecte du serveur IRC sur lequel vous vous trouvez actuellement.
EOT
);
___('irc_faq_commands_connect',   'EN', <<<EOT
Connects to an existing IRC server. For example connecting to NoBleme's IRC server is done by typing <span class="monospace">/server irc.nobleme.com</span>. You may be on more than one IRC server at once, and can leave a specific server by using the <span class="monospace">/quit</span> command while in a channel located on that server.
EOT
);
___('irc_faq_commands_connect',   'FR', <<<EOT
Vous connecte à un serveur IRC existant. Par exemple, vous pouvez vous connecter au serveur IRC de NoBleme en écrivant <span class="monospace">/server irc.nobleme.com</span>. Vous pouvez vous connecter à plus d'un serveur IRC simultanément, et pouvez vous déconnecter d'un serveur spécifique en utilisant la commande <span class="monospace">/quit</span> dans un canal situé sur ce serveur.
EOT
);
___('irc_faq_commands_list',      'EN', <<<EOT
Lists all public IRC channels on the server, along with the number of users currently using each of them.
EOT
);
___('irc_faq_commands_list',      'FR', <<<EOT
Liste tous les canaux IRC publics sur le serveur, ainsi que le nombre de personnes qui s'y trouvent actuellement.
EOT
);
___('irc_faq_commands_join',      'EN', <<<EOT
Joins an existing IRC channel. Some channels are private and can not be joined unless you are specifically granted access to them. You can find out which channels exist on NoBleme's IRC server on our {{link|pages/irc/faq?channels|channel list}}, or by using the <span class="monospace">/list</span> command.
EOT
);
___('irc_faq_commands_join',      'FR', <<<EOT
Rejoint un canal IRC existant. Certains canaux sont privés et ne peuvent pas être rejoints si vous ne disposez pas du droit d'y accéder. Vous pouvez trouver la liste des canaux du serveur IRC de NoBleme sur notre {{link|pages/irc/faq?channels|liste des canaux}}, ou en utilisant la commande <span class="monospace">/list</span>.
EOT
);
___('irc_faq_commands_names',     'EN', <<<EOT
Lists all users currently in the specified channel, even if you are currently not present in it. This will not work if used on a private channel.
EOT
);
___('irc_faq_commands_names',     'FR', <<<EOT
Liste toutes les personnes actuellement présentes sur le canal spécifié, même si vous n'y êtes pas. Cela ne fonctionne pas sur les canaux privés.
EOT
);
___('irc_faq_commands_part',      'EN', <<<EOT
Leaves an IRC channel on which you currently are. You will no longer be able to send messages to this channel (unless you rejoin it), and will stop receiving messages sent to this channel by other users.
EOT
);
___('irc_faq_commands_part',      'FR', <<<EOT
Quitte un canal IRC spécifique dans lequel vous êtes actuellement. Vous ne pourrez plus envoyer de messages sur ce canal (à moins de le rejoindre), et ne recevrez plus les messages envoyés sur ce canal par les autres personnes.
EOT
);
___('irc_faq_commands_nick',      'EN', <<<EOT
Changes your current username to the desired new username. If the desired username is already in use, it will not work. Your username is the same in every IRC channel on specific IRC server, there is no way to have a different username in different channels.
EOT
);
___('irc_faq_commands_nick',      'FR', <<<EOT
Change votre pseudonyme actuel en le remplaçant par le pseudonyme désiré. Si le pseudonyme choisi est déjà utilisé par quelqu'un d'autre, le changement ne se fera pas. Votre pseudonyme sera le même sur tous les canaux d'un serveur IRC donné, vous ne pouvez pas avoir un pseudonyme différent d'un canal à l'autre.
EOT
);
___('irc_faq_commands_whois',     'EN', <<<EOT
Returns various elements of information about the specified user. The amount and nature of the returned elements depend on the user's IRC client and settings.
EOT
);
___('irc_faq_commands_whois',     'FR', <<<EOT
Affiche diverses informations sur la personne spécifiée. La quantité et la nature de ces informations dépend du client IRC et des réglages de la personne en question.
EOT
);
___('irc_faq_commands_whowas',    'EN', <<<EOT
Returns various elements of information about a specified username, even if they are not present on the server anymore. This is a useful way to know when a person last used IRC.
EOT
);
___('irc_faq_commands_whowas',    'FR', <<<EOT
Affiche diverses informations sur un pseudonyme spécifié, même si personne n'est actuellement en train d'utiliser ce pseudonyme sur le serveur. Cela permet de savoir quand une personne était présente sur IRC pour la dernière fois.
EOT
);
___('irc_faq_commands_msg',       'EN', <<<EOT
Sends a private message to the specified user. Only you and the specified user will be able to see the contents of this message, it will not be shared on any channels and will be hidden even from the administrators of the IRC server. For example, if you were trying to initiate a private conversation with a user named SomeUser, you would send the following message: <span class="monospace">/msg SomeUser Hello, how are you doing?</span>
EOT
);
___('irc_faq_commands_msg',       'FR', <<<EOT
Envoie un message privé à la personne spécifiée. Seuls vous et la personne en question pourrez voir le contenu de ce message, il ne sera partagé sur aucun canal, et même l'administration du serveur ne pourra pas le voir. Par exemple, si vous désirez démarrer une conversation privée avec quelqu'un utilisant le pseudonyme QuelqUn, vous pouvez envoyer le message suivant : <span class="monospace">/msg QuelqUn Coucou, tu vas vraiment bien ?</span>
EOT
);
___('irc_faq_commands_ignore',    'EN', <<<EOT
Blocks all incoming messages from the specified user. Not only will you stop receiving their private messages, but you will also not see any further messages sent by them on IRC channels in which both of you are present. The ignored user will still be able to see your messages, there is no way to make your messages invisible to a specific user. The ignore command will automatically continue working on them even if they change username.
EOT
);
___('irc_faq_commands_ignore',    'FR', <<<EOT
Bloque toutes les communications venant de la personne spécifiée. Non seulement vous ne recevrez plus ses messages privés, mais vous ne verrez également plus ses futurs messages sur les canaux de discussion. La personne ignorée pourra toutefois continuer à voir vos messages, il n'existe pas de façon de rendre vos messages invisibles à une personne spécifique. La commande ignore continuera à fonctionner même si la personne ignorée change de pseudonyme.
EOT
);
___('irc_faq_commands_unignore',  'EN', <<<EOT
Stops blocking messages from a currently ignored user.
EOT
);
___('irc_faq_commands_unignore',  'FR', <<<EOT
Cesse de bloquer les communications venant de la personne spécifiée.
EOT
);


// FAQ: NickServ
___('irc_faq_nickserv_body_1',    'EN', <<<EOT
While using IRC, you might come to the realization that nothing is stopping other users from impersonating you by "stealing" your username. This can be avoided by sending messages to a special automated user called NickServ, which is always present on the server.
EOT
);
___('irc_faq_nickserv_body_1',    'FR', <<<EOT
Lors de votre utilisation d'IRC, vous vous rendrez compte que rien n'empêche d'autres personnes d'usurper votre identité en « volant » votre pseudonyme. Ce problème peut être évité en envoyant des messages à un compte automatisé portant le pseudonyme NickServ, qui est présent en permanence sur le serveur IRC NoBleme.
EOT
);
___('irc_faq_nickserv_body_2',    'EN', <<<EOT
You will find a list of NickServ related {{link|pages/irc/faq?commands|commands}} below. When a word is between [brackets], then it means that its value can be anything you want and you should replace it with something else. For example, if given the command <span class="monospace">/msg NickServ identify [password]</span>, you should use it as <span class="monospace">/msg NickServ identify myPassword123</span>.
EOT
);
___('irc_faq_nickserv_body_2',    'FR', <<<EOT
Vous trouverez ci-dessous une liste de commandes en rapport avec NickServ. Lorsqu'un mot est entre [crochets], cela signifie que sa valeur est à personnaliser. Par exemple, lorsque la commande <span class="monospace">/msg NickServ identify [mot-de-passe]</span> est documentée, vous pouvez l'utiliser comme <span class="monospace">/msg NickServ identify monPass123</span>.
EOT
);
___('irc_faq_nickserv_body_3',    'EN', <<<EOT
Most of the commands listed on this page begin with <span class="monospace">/msg NickServ</span>. Depending on your IRC client, you might be able to shorten any such command by using <span class="monospace">/ns</span> instead. For example, <span class="monospace">/msg NickServ identify [password]</span> would become <span class="monospace">/ns identify [password]</span>.
EOT
);
___('irc_faq_nickserv_body_3',    'FR', <<<EOT
La majorité des commandes listées sur cette page commencent par <span class="monospace">/msg NickServ</span>. Selon votre client IRC, il est possible que vous puissiez raccourcir ces commandes en utilisant <span class="monospace">/ns</span> à la place. Par exemple, <span class="monospace">/msg NickServ identify [mot-de-passe]</span> deviendrait <span class="monospace">/ns identify [mot-de-passe]</span>.
EOT
);
___('irc_faq_nickserv_register',  'EN', <<<EOT
Registers your current username with NickServ, making you its owner. <span class="bold">Make sure you remember your chosen password, as there is no way to recover it if you lose it.</span> Do not register other people's usernames in order to annoy or impersonate them, this would only lead to getting permanently banned from NoBleme's IRC server and all your registered usernames being unregistered.
EOT
);
___('irc_faq_nickserv_register',  'FR', <<<EOT
Enregistre votre pseudonyme actuel auprès de NickServ, vous en donnant la propriété exclusive. <span class="bold">Assurez-vous de retenir votre mot de passe, il n'existe aucune façon de le récupérer si vous le perdez.</span>. Ne cherchez pas à enregistrer les pseudonymes d'autres personnes dans le but de les embêter ou d'usurper leur identité, cela conduirait à une exclusion permanente du serveur IRC NoBleme ainsi qu'à un dé-enregistrement de tous les pseudonymes que vous aurez enregistré.
EOT
);
___('irc_faq_nickserv_identify',  'EN', <<<EOT
Identifies you as the owner of the username you are currently using. <span class="bold">You must execute this command every time you connect to NoBleme's IRC server,</span> otherwise your username will be changed at random after one minute. Most IRC clients give you ways to automatically execute certain commands as you connect to an IRC server, adding the identify command to this automation will avoid having to type it manually every single time.
EOT
);
___('irc_faq_nickserv_identify',  'FR', <<<EOT
Vous authentifie comme propriétaire du pseudonyme que vous utilisez actuellement. <span class="bold">Vous devez exécuter cette commande à chaque fois que vous vous connectez au serveur IRC NoBleme,</span> sous peine de voir votre pseudonyme automatiquement changé au bout d'une minute. La plupart des clients IRC vous offrent la possibilité d'automatiquement exécuter certaines commandes lorsque vous vous connectez à un serveur IRC, ajouter la commande identify à cette automatisation vous évitera d'avoir à systématiquement l'écrire manuellement.
EOT
);
___('irc_faq_nickserv_password',  'EN', <<<EOT
Changes your current password to a new password of your choosing. <span class="bold">Make sure you remember your chosen password, as there is no way to recover it if you lose it.</span>
EOT
);
___('irc_faq_nickserv_password',  'FR', <<<EOT
Change votre mot de passe actuel pour un nouveau mot de passe. <span class="bold">Assurez-vous de retenir votre mot de passe, il n'existe aucune façon de le récupérer si vous le perdez.</span>
EOT
);
___('irc_faq_nickserv_recover',  'EN', <<<EOT
Disconnects from the IRC server anyone who is currently using your registered username. This is useful in case you have been disconnected and a ghost of you still lingers idly on the server under your username.
EOT
);
___('irc_faq_nickserv_recover',  'FR', <<<EOT
Déconnecte du serveur IRC toute personne qui utilise actuellement votre pseudonyme enregistré. Cela est utile si vous avez subi une déconnexion accidentelle et que votre fantôme est toujours présent sur le serveur sous votre pseudonyme.
EOT
);
___('irc_faq_nickserv_ghost',   'EN', <<<EOT
If someone has been attempting to bruteforce your NickServ password (trying over and over to identify or recover in order to guess your password), the system might lock anyone out of using your username. In such a situation, the ghost command allows you to release your username, so that you can use it again.
EOT
);
___('irc_faq_nickserv_ghost',   'FR', <<<EOT
Dans le cas où une personne mal intentionnée essayerait de deviner votre mot de passe NickServ en tentant de s'authentifier plusieurs fois de suite, le système peut automatiquement verrouiller votre pseudonyme, le rendant temporairement impossible à utiliser. Dans ces situations, la commande ghost vous permet de libérer votre pseudonyme, afin que vous puissiez l'utiliser.
EOT
);
___('irc_faq_nickserv_drop',    'EN', <<<EOT
Unregisters your username, deleting it from NickServ's database.
EOT
);
___('irc_faq_nickserv_drop',    'FR', <<<EOT
Dé-enregistre votre pseudonyme, le supprimant de la base de données de NickServ.
EOT
);


// FAQ: ChanServ
___('irc_faq_chanserv_body_1',            'EN', <<<EOT
During your usage of IRC, you might end up dealing with channel management - either because you want to create and administrate your own channel, or because you have been named operator in an already existing channel and are faced with a situation where you need to use your operator abilities. A lot of these actions are done by sending messages to a special automated user called ChanServ, which is always present on the server.
EOT
);
___('irc_faq_chanserv_body_1',            'FR', <<<EOT
Lors de votre utilisation d'IRC, vous pourrez vous retrouver à gérer un canal IRC - soit parce que vous désirez créer et administrer votre propre canal, soit parce que vous vous retrouvez Operator d'un canal existant et avez besoin d'utiliser vos pouvoirs. La majorité de ces actions se font en envoyant des messages à un compte automatisé portant le pseudonyme ChanServ, qui est présent en permanence sur le serveur IRC NoBleme.
EOT
);
___('irc_faq_chanserv_body_2',            'EN', <<<EOT
You will find a list of ChanServ related {{link|pages/irc/faq?commands|commands}} below. When a word is between [brackets], then it means that its value can be anything you want and you should replace it with something else. For example, if given the command <span class="monospace">/kick channel [username]</span>, you should use it as <span class="monospace">/kick channel SomeUser</span>.
EOT
);
___('irc_faq_chanserv_body_2',            'FR', <<<EOT
Vous trouverez ci-dessous une liste de {{link|pages/irc/faq?commands|commandes}} en rapport avec ChanServ. Lorsqu'un mot est entre [crochets], cela signifie que sa valeur est à personnaliser. Par exemple, lorsque la commande <span class="monospace">/kick channel [pseudonyme]</span> est documentée, vous pouvez l'utiliser comme <span class="monospace">/kick channel MonPseudo</span>.
EOT
);
___('irc_faq_chanserv_body_3',            'EN', <<<EOT
Most of the commands listed on this page begin with <span class="monospace">/msg ChanServ</span>. Depending on your IRC client, you might be able to shorten any such command by using <span class="monospace">/cs</span> instead. For example, <span class="monospace">/msg ChanServ aop #[channel] list</span> would become <span class="monospace">/cs aop #[channel] list</span>.
EOT
);
___('irc_faq_chanserv_body_3',            'FR', <<<EOT
Beaucoup de commandes listées sur cette page commencent par <span class="monospace">/msg ChanServ</span>. Selon votre client IRC, il est possible que vous puissiez raccourcir ces commandes en utilisant <span class="monospace">/cs</span> à la place. Par exemple, <span class="monospace">/msg ChanServ aop #[canal] list</span> deviendrait <span class="monospace">/cs aop #[canal] list</span>.
EOT
);

___('irc_faq_chanserv_hostmasks_title',   'EN', "Hostmasks");
___('irc_faq_chanserv_hostmasks_title',   'FR', "Hostmask");
___('irc_faq_chanserv_hostmasks_body_1',  'EN', <<<EOT
Every user connected to an IRC server is identified not by their nickname (which can be changed at will), but rather by a unique string of characters called their hostmask. It uses the following format: <span class="monospace">username!user@host</span>, where <span class="monospace">username</span> is self-explanatory, <span class="monospace">user</span> is a special name given by their IRC client, and <span class="monospace">host</span> is a unique identifier for a specific person.
EOT
);
___('irc_faq_chanserv_hostmasks_body_1',  'FR', <<<EOT
Toute personne connectée à un serveur IRC n'est pas identifiée par son pseudonyme (qui peut être changé à volonté), mais plutôt par une chaîne de caractères unique qui porte le nom de « hostmask » (masque d'hôte). Les hostmask utilisent le format suivant: <span class="monospace">pseudonyme!nom@hôte</span>, où <span class="monospace">pseudonyme</span> est le pseudonyme actuellement utilisé, <span class="monospace">nom</span> est une valeur assignée par le client IRC, et <span class="monospace">hôte</span> est une façon unique d'identifier une personne.
EOT
);
___('irc_faq_chanserv_hostmasks_body_2',  'EN', <<<EOT
Based on the way hostnames work, if you are looking to identify someone (for example to permanently ban them from a channel), you should specifically look for the <span class="monospace">host</span> part of their hostname, as the rest can be changed at will. Finding a user's hostname can be done by using the <span class="monospace">/whois [username]</span> or <span class="monospace">/whowas [username]</span> {{link|pages/irc/faq?commands|commands}}.
EOT
);
___('irc_faq_chanserv_hostmasks_body_2',  'FR', <<<EOT
En observant la structure des hostmask, la seule façon d'identifier une personne spécifique (par exemple afin de la bannir d'un canal IRC) est via la partie <span class="monospace">hôte</span> de son hostmask, le reste étant modifiable à volonté. Pour trouver l'hôte d'une personne, utilisez les {{link|pages/irc/faq?commands|commandes}} <span class="monospace">/whois [pseudonyme]</span> ou <span class="monospace">/whowas [pseudonyme]</span>.
EOT
);
___('irc_faq_chanserv_hostmasks_body_3',  'EN', <<<EOT
The asterisk * character can be used as a "wildcard" in a hostmask. For example, the hostmask <span class="monospace">SomeUsername!*@*.fr</span> will match every user that goes by the username "SomeUsername" and has a host ending in ".fr". Here are more concrete examples that should help you better understand the concept:
EOT
);
___('irc_faq_chanserv_hostmasks_body_3',  'FR', <<<EOT
Un astérisque * peut servir de « joker » dans un hostmask. Par exemple, le hostmask <span class="monospace">UnPseudonyme!*@*.fr</span> correspond à toutes les personnes utilisant le pseudonyme « UnPseudonyme » et dont l'hôte finit par « .fr ». Les exemples suivants devraient vous aider à mieux comprendre :
EOT
);
___('irc_faq_chanserv_hostmasks_ex_1',    'EN', "SomeUsername!*@*");
___('irc_faq_chanserv_hostmasks_ex_1',    'FR', "UnPseudonyme!*@*");
___('irc_faq_chanserv_hostmasks_body_4',  'EN', "Matches every user that goes by the exact username SomeUsername");
___('irc_faq_chanserv_hostmasks_body_4',  'FR', "Correspond à toutes les personnes utilisant le pseudonyme UnPseudonyme");
___('irc_faq_chanserv_hostmasks_ex_2',    'EN', "*SomeWord*!*@*");
___('irc_faq_chanserv_hostmasks_ex_2',    'FR', "*UnMot*!*@*");
___('irc_faq_chanserv_hostmasks_body_5',  'EN', "Matches every user whose username contains SomeWord");
___('irc_faq_chanserv_hostmasks_body_5',  'FR', "Correspond à toutes les personnes dont le pseudonyme contient UnMot");
___('irc_faq_chanserv_hostmasks_ex_3',    'EN', "SomeWord*!*@*");
___('irc_faq_chanserv_hostmasks_ex_3',    'FR', "UnMot*!*@*");
___('irc_faq_chanserv_hostmasks_body_6',  'EN', "Matches every user whose username begins with SomeWord");
___('irc_faq_chanserv_hostmasks_body_6',  'FR', "Correspond à toutes les personnes dont le pseudonyme commence par UnMot");
___('irc_faq_chanserv_hostmasks_ex_4',    'EN', "*!*@123-456-789.something.com");
___('irc_faq_chanserv_hostmasks_ex_4',    'FR', "*!*@123-456-789.quelquechose.fr");
___('irc_faq_chanserv_hostmasks_body_7',  'EN', "Matches every user whose host is precisely 123-456-789.something.com");
___('irc_faq_chanserv_hostmasks_body_7',  'FR', "Correspond à toutes les personnes dont l'hôte est 123-456-789.quelquechose.fr");
___('irc_faq_chanserv_hostmasks_ex_5',    'EN', "*!*@*.something.com");
___('irc_faq_chanserv_hostmasks_ex_5',    'FR', "*!*@*.quelquechose.fr");
___('irc_faq_chanserv_hostmasks_body_8',  'EN', "Matches every user whose host ends in .something.com");
___('irc_faq_chanserv_hostmasks_body_8',  'FR', "Correspond à toutes les personnes dont l'hôte finit par quelquechose.fr");
___('irc_faq_chanserv_hostmasks_ex_6',    'EN', "*!*@*");
___('irc_faq_chanserv_hostmasks_ex_6',    'FR', "*!*@*");
___('irc_faq_chanserv_hostmasks_body_9',  'EN', "Matches literally everyone, be very careful when using this");
___('irc_faq_chanserv_hostmasks_body_9',  'FR', "Correspond à littéralement tout le monde, faites très attention");
___('irc_faq_chanserv_hostmasks_body_10', 'EN', <<<EOT
When you see the word [hostmask] between brackets later on this page, you should now hopefully understand what to input as a hostmask. If you don't get it, or if you are scared by the complexity, then don't hesitate to ask around: someone will surely help you out.
EOT
);
___('irc_faq_chanserv_hostmasks_body_10', 'FR', <<<EOT
Lorsque vous verrez le mot [hostmask] entre crochets sur cette page, vous devriez maintenant comprendre ce qu'il faut écrire à la place. Si vous ne comprenez pas le concept, ou que vous avez peur de sa complexité, n'hésitez pas à demander un coup de main.
EOT
);

___('irc_faq_chanserv_optools_title',   'EN', "Operator abilities");
___('irc_faq_chanserv_optools_title',   'FR', "Pouvoirs d'Operator");
___('irc_faq_chanserv_optools_body',    'EN', <<<EOT
Operator abilities can only be used in a channel in which you are an operator, and require you to be registered with NickServ and identified. You can find more about operator names, abilities, and symbols at the bottom of the {{link|pages/irc/faq?guide#symbols|vocabulary and symbols}} section of this FAQ, and more about account management on the {{link|pages/irc/faq?nickserv|NickServ}} section of this FAQ.
EOT
);
___('irc_faq_chanserv_optools_body',    'FR', <<<EOT
Les pouvoirs d'Operator ne peuvent être utilisés que dans un canal IRC sur lequel vous êtes Operator, et requièrent que votre pseudonyme soit enregistré auprès de NickServ. Vous pouvez en lire plus sur les types d'Operator et leurs pouvoirs dans la section symboles de la page {{link|pages/irc/faq?guide#symbols|vocabulaire et symboles}} de cette FAQ, et plus sur l'enregistrement de votre pseudonyme dans la section {{link|pages/irc/faq?nickserv|NickServ}} de cette FAQ.
EOT
);
___('irc_faq_chanserv_topic',           'EN', <<<EOT
Changes a channel's topic. Each channel has a short piece of text which everyone will see when joining the channel (or might permanently see while using the channel, depending on their IRC client). In most IRC clients, this command can be shortened to simply /topic, for example <span class="monospace">/topic This is a topic</span> should work.
EOT
);
___('irc_faq_chanserv_topic',           'FR', <<<EOT
Change le sujet d'un canal. Chaque canal contient un court texte visible de toute personne qui s'y connecte (et est généralement visible en permanence lors de l'utilisation du canal, selon le client IRC). Sur la plupart des clients IRC, cette commande peut se raccourcir en simplement /topic, par exemple <span class="monospace">/topic Ceci est un sujet</span>.
EOT
);
___('irc_faq_chanserv_kick',            'EN', <<<EOT
Removes a user from the channel. They are free to rejoin the channel after being kicked. In most IRC clients, this command can be shortened to simply /kick, for example <span class="monospace">/kick SomeUser</span> should work. An optional justification can be added afterwards, for example <span class="monospace">/kick SomeUser Please chill out</span>.
EOT
);
___('irc_faq_chanserv_kick',            'FR', <<<EOT
Éjecte une personne du canal. Cette personne est libre de rejoindre le canal à tout moment. Sur la plupart des clients IRC, cette commande peut se raccourcir en simplement /kick, par exemple <span class="monospace">/kick UnPseudo</span>. Une justification optionnelle peut être rajoutée ensuite, par exemple <span class="monospace">/kick UnPseudo On se calme, merci</span>.
EOT
);
___('irc_faq_chanserv_ban',             'EN', <<<EOT
Bans a hostmask from the channel. Once banned, any user matching the hostmask will not be able to join or send messages on the channel anymore. If you kick them, if they leave the channel, or if they disconnect from the server, they will not be able to rejoin the channel until they are unbanned.
EOT
);
___('irc_faq_chanserv_ban',             'FR', <<<EOT
Bannit un hostmask du canal. Toute personne dont l'hostmask correspond au hostmask banni ne pourra plus rejoindre ou envoyer de messages sur le canal. Les personnes présentes sur le canal dont le hostmask correspond n'en seront pas automatiquement éjectées - par contre, si vous utiliser un /kick sur elles, ou qu'elles quittent le canal, elles ne pourront plus le rejoindre par la suite.
EOT
);
___('irc_faq_chanserv_banlist',         'EN', <<<EOT
Lists all hostmasks currently banned from the channel. This command might not always work, if it doesn't try simply typing <span class="monospace">/mode #[channel] b</span> in the channel instead of the full command.
EOT
);
___('irc_faq_chanserv_banlist',         'FR', <<<EOT
Liste tous les hostmask actuellement bannis sur le canal. Si cette commande ne fonctionne pas, essayez d'utiliser <span class="monospace">/mode #[canal] b</span> à la place.
EOT
);
___('irc_faq_chanserv_unban',           'EN', <<<EOT
Lifts a ban on a hostmask from the channel. Once unbanned, users matching the hostmask are free to join the channel once again.
EOT
);
___('irc_faq_chanserv_unban',           'FR', <<<EOT
Débannit un hostmask du canal. Une fois débannis, toute personne dont l'hostmask correspond est libre de rejoindre le canal de nouveau.
EOT
);
___('irc_faq_chanserv_mute',            'EN', <<<EOT
Sets the channel to mute mode: only voiced users and operators will be able to send messages in this channel as long as it is in mute mode. This is the best way to deal with attemps to flood a channel in order to render it unusable.
EOT
);
___('irc_faq_chanserv_mute',            'FR', <<<EOT
Passe le canal en mode muet : uniquement les Operator et les personnes Voiced pourront envoyer des messages sur ce canal tant qu'il sera en mode muet. Il s'agit de la meilleure façon de gérer les situations où des personnes tentent d'envahir un canal en y envoyant une grande quantité de messages.
EOT
);
___('irc_faq_chanserv_voice',           'EN', <<<EOT
Gives voice to a user: they will gain the ability to send messages in this channel even while it is in mute mode.
EOT
);
___('irc_faq_chanserv_voice',           'FR', <<<EOT
Rend une personne Voiced : il leur sera possible d'envoyer des messages sur le canal même s'il est en mode muet.
EOT
);
___('irc_faq_chanserv_unmute',          'EN', <<<EOT
Removes mute mode, everyone in the channel can once again send messages.
EOT
);
___('irc_faq_chanserv_unmute',          'FR', <<<EOT
Retire le mode muet : tout le monde peut de nouveau discuter sur le canal.
EOT
);

___('irc_faq_chanserv_manage_title',    'EN', "Channel management");
___('irc_faq_chanserv_manage_title',    'FR', "Gestion des canaux");
___('irc_faq_chanserv_manage_body',     'EN', <<<EOT
This section will list commands that you can only use if you are the founder or administrator of a channel (or looking to register a new channel), and require you to be registered with NickServ and identified. You can find more about operator names, abilities, and symbols at the bottom of the {{link|pages/irc/faq?guide#symbols|vocabulary and symbols}} section of this FAQ, and more about account management on the {{link|pages/irc/faq?nickserv|NickServ}} section of this FAQ.
EOT
);
___('irc_faq_chanserv_manage_body',     'FR', <<<EOT
Cette section contient une liste de commandes que vous ne pouvez utiliser que si vous êtes Founder ou Admin d'un canal IRC (ou désirez créer un nouveau canal IRC), et requièrent que votre pseudonyme soit enregistré auprès de NickServ Vous pouvez en lire plus sur les types d'Operator et leurs pouvoirs dans la section symboles de la page {{link|pages/irc/faq?guide#symbols|vocabulaire et symboles}} de cette FAQ, et plus sur l'enregistrement de votre pseudonyme dans la section {{link|pages/irc/faq?nickserv|NickServ}} de cette FAQ.
EOT
);
___('irc_faq_chanserv_register',        'EN', <<<EOT
Registers a channel, making you its founder. Once you start growing the channel and have regular users and conversations, you might want to get it added to NoBleme's {{link|pages/irc/faq?channels|channel list}}.
EOT
);
___('irc_faq_chanserv_register',        'FR', <<<EOT
Enregistre un canal auprès de ChanServ, faisant de vous son Founder. Une fois que votre canal est régulièrement utilisé, vous pouvez demander à ce qu'il soit ajouté à la {{link|pages/irc/faq?channels|liste des canaux}}.
EOT
);
___('irc_faq_chanserv_founder',         'EN', <<<EOT
Transfers founder status to another user. As there can only be one founder at a time in a channel, you will lose your founder status in the process.
EOT
);
___('irc_faq_chanserv_founder',         'FR', <<<EOT
Transfère le statut de Founder à quelqu'un d'autre. Comme il ne peut y avoir qu'une seule personne portant le statut Founder à la fois sur un canal IRC, vous perdrez votre statut de Founder.
EOT
);
___('irc_faq_chanserv_voiceop',         'EN', <<<EOT
Permanently gives voiced status to a user (the user will still be able to chat if the channel is set to mute mode). You can revoke this status by replacing <span class="monospace">add</span> by <span class="monospace">del</span> in this command.
EOT
);
___('irc_faq_chanserv_voiceop',         'FR', <<<EOT
Donne le statut Voiced de façon permanente à une personne (il lui sera possible de discuter sur le canal même s'il est en mode muet). Vous pouvez retirer ce statut à quelqu'un en remplaçant <span class="monospace">add</span> par <span class="monospace">del</span> dans cette commande.
EOT
);
___('irc_faq_chanserv_halfop',          'EN', <<<EOT
Permanently gives halfop status to a user (the user will be able to kick other users). You can revoke this status by replacing <span class="monospace">add</span> by <span class="monospace">del</span> in this command.
EOT
);
___('irc_faq_chanserv_halfop',          'FR', <<<EOT
Donne le statut Halfop de façon permanente à une personne (il lui sera possible d'éjecter d'autres personnes). Vous pouvez retirer ce statut à quelqu'un en remplaçant <span class="monospace">add</span> par <span class="monospace">del</span> dans cette commande.
EOT
);
___('irc_faq_chanserv_op',              'EN', <<<EOT
Permanently gives operator status to a user (the user will be able to kick and ban other users and manage the channel). You can revoke this status by replacing <span class="monospace">add</span> by <span class="monospace">del</span> in this command.
EOT
);
___('irc_faq_chanserv_op',              'FR', <<<EOT
Donne le statut Operator de façon permanente à une personne (il lui sera possible d'éjecter et bannir d'autres personnes et de gérer le canal). Vous pouvez retirer ce statut à quelqu'un en remplaçant <span class="monospace">add</span> par <span class="monospace">del</span> dans cette commande.
EOT
);
___('irc_faq_chanserv_admin',           'EN', <<<EOT
Permanently gives admin status to a user (the user will be able to kick and ban users, manage the channel, and name or revoke the operator status of other users). You can revoke this status by replacing <span class="monospace">add</span> by <span class="monospace">del</span> in this command.
EOT
);
___('irc_faq_chanserv_admin',           'FR', <<<EOT
Donne le statut Admin de façon permanente à une personne (il lui sera possible d'éjecter et bannir d'autres personnes, de gérer le canal, et de nommer ou retirer d'autres Operator). Vous pouvez retirer ce statut à quelqu'un en remplaçant <span class="monospace">add</span> par <span class="monospace">del</span> dans cette commande.
EOT
);

___('irc_faq_chanserv_modes_title',     'EN', "Channel modes");
___('irc_faq_chanserv_modes_title',     'FR', "Modes");
___('irc_faq_chanserv_modes_body_1',    'EN', <<<EOT
Some elements of channel administration are done through setting or removing "modes", special channel settings which materialize through the form of a single letter.
EOT
);
___('irc_faq_chanserv_modes_body_1',    'FR', <<<EOT
Certains éléments de l'administration des canaux IRC sont contrôlés par des « modes », des réglages qui se manifestent sous la forme d'une lettre de l'alphabet.
EOT
);
___('irc_faq_chanserv_modes_body_2',    'EN', <<<EOT
A channel mode is set through the command <span class="monospace text_red">/msg ChanServ mode #[channel] +[mode]</span>, where [mode] is a letter from the list of modes below. For example, forcing users to register before accessing a channel would look like this: <span class="monospace">/msg ChanServ mode #myChannel +R</span>.
EOT
);
___('irc_faq_chanserv_modes_body_2',    'FR', <<<EOT
Un mode s'active via la commande <span class="monospace text_red">/msg ChanServ mode #[canal] +[mode]</span>, où [mode] est une lettre. Par exemple, pour forcer toute personne souhaitant rejoindre le canal à s'authentifier préalablement auprès de NickServ, il faut utiliser la commande suivante : <span class="monospace">/msg ChanServ mode #monCanal +R</span>.
EOT
);
___('irc_faq_chanserv_modes_body_3',    'EN', <<<EOT
Removing a mode from a channel is done the same way as adding a mode, except that the plus + sign before the letter representing the mode is replaced by a minus - sign. For example, instead of using +R in the previous example, you would use -R.
EOT
);
___('irc_faq_chanserv_modes_body_3',    'FR', <<<EOT
Désactiver un mode se fait de la même façon qu'activer un mode, à la différence que le signe + plus avant la lettre représentant le mode est remplacée par un signe - moins. Par exemple, au lieu d'utiliser +R dans l'exemple précédent, vous utiliseriez -R.
EOT
);
___('irc_faq_chanserv_modes_body_4',    'EN', <<<EOT
You can check which modes your channel currently has set by running the following command: <span class="monospace text_red">/msg ChanServ mode #[channel]</span>. You will find a list of useful modes below, be warned that capitalization matters: mode +m is not at all the same thing as mode +M.
EOT
);
___('irc_faq_chanserv_modes_body_4',    'FR', <<<EOT
Vous pouvez vérifier quels modes sont actuellement activés sur votre canal en utilisant la commande suivante : <span class="monospace text_red">/msg ChanServ mode #[canal]</span>. Vous trouverez ci-dessous une liste de modes utiles, faites attention à la capitalisation : mode +m n'est pas du tout la même chose que mode +M.
EOT
);
___('irc_faq_chanserv_mode_i',          'EN', <<<EOT
Sets the channel to invite-only mode: the only way to join it is to be invited by someone who is already in it by using <span class="monospace">/msg ChanServ invite #[channel] [username]</span>, or to be on the invite list.
EOT
);
___('irc_faq_chanserv_mode_i',          'FR', <<<EOT
Passe le canal en mode invitation : il n'est possible de le rejoindre qu'en y étant invité par quelqu'un qui s'y trouve déjà via la commande <span class="monospace">/msg ChanServ invite #[canal] [pseudonyme]</span>, ou en étant sur la liste des invitations.
EOT
);
___('irc_faq_chanserv_mode_i_caps',      'EN', <<<EOT
Adds a hostmask to the invite list: they can freely join the channel even if it is set in invite-only mode.
EOT
);
___('irc_faq_chanserv_mode_i_caps',      'FR', <<<EOT
Ajoute un hostmask à la liste des invitations : toute personne correspondant à ce hostmask peut rejoindre le canal même s'il est en mode invitation.
EOT
);
___('irc_faq_chanserv_mode_k',          'EN', <<<EOT
Sets a password. The channel can only be joined by users who know the password, by adding it at the end of the /join command. For example: <span class="monospace">/join #myChannel somePass123</span>.
EOT
);
___('irc_faq_chanserv_mode_k',          'FR', <<<EOT
Ajoute un mot de passe au canal, le rendant impossible à rejoindre sans connaitre le mot de passe. Pour rejoindre un canal protégé par mot de passe, il faut rajouter le mot de passe à la fin de la commande /join. Par exemple : <span class="monospace">/join #myChannel motDePasse123</span>.
EOT
);
___('irc_faq_chanserv_mode_l',          'EN', <<<EOT
Sets a maximum number of users who can be on the channel at any given time. Any extra users will be denied entry if they try to join once the channel has reached maximum capacity.
EOT
);
___('irc_faq_chanserv_mode_l',          'FR', <<<EOT
Définit un nombre maximum de personnes qui peuvent être présentes sur un canal à un moment donné.
EOT
);
___('irc_faq_chanserv_mode_m',          'EN', <<<EOT
Sets the channel to mute mode: only voiced users and operators can chat.
EOT
);
___('irc_faq_chanserv_mode_m',          'FR', <<<EOT
Passe le canal en mode muet : seules les personnes Voiced et les Operator peuvent envoyer des messages.
EOT
);
___('irc_faq_chanserv_mode_m_caps',      'EN', <<<EOT
Only users who have registered and identified their username with {{link|pages/irc/faq?nickserv|NickServ}} can chat in the channel.
EOT
);
___('irc_faq_chanserv_mode_m_caps',      'FR', <<<EOT
Seules les personnes ayant enregistré leur pseudonyme auprès de {{link|pages/irc/faq?nickserv|NickServ}} peuvent envoyer des messages sur le canal.
EOT
);
___('irc_faq_chanserv_mode_n',          'EN', <<<EOT
Prevents users who are not in the channel from sending messages into the channel. This mode is enabled by default in every new channel and it is recommended that you leave it that way.
EOT
);
___('irc_faq_chanserv_mode_n',          'FR', <<<EOT
Empêche les personnes qui ne sont pas présentes sur le canal d'y envoyer des messages. Ce mode est activé par défaut sur les nouveaux canaux, il est recommandé de le laisser activé.
EOT
);
___('irc_faq_chanserv_mode_r_caps',      'EN', <<<EOT
Only users who have registered and identified their username with {{link|pages/irc/faq?nickserv|NickServ}} can join the channel. Non-registered and/or non-identified users who are already in the channel will not get removed from it, but they would be unable to rejoin it if they were to leave or get kicked.
EOT
);
___('irc_faq_chanserv_mode_r_caps',      'FR', <<<EOT
Seules les personnes ayant enregistré leur pseudonyme auprès de {{link|pages/irc/faq?nickserv|NickServ}} peuvent rejoindre le canal. Les personnes non enregistrées et/ou non authentifiées qui sont déjà présentes sur le canal ne s'en feront pas éjecter, mais il leur serait impossible de le rejoindre si elles s'en faisaient éjecter.
EOT
);
___('irc_faq_chanserv_mode_s',          'EN', <<<EOT
Makes the channel secret: it will not appear in the /list command, and will not show when using the /whois command on a user who is currently in the channel.
EOT
);
___('irc_faq_chanserv_mode_s',          'FR', <<<EOT
Passe le canal en mode secret : il n'apparaitra pas dans les résultats de la commande /list, et ne sera pas listé lorsque vous utiliserez /whois sur une personne qui s'y trouve.
EOT
);
___('irc_faq_chanserv_mode_t',          'EN', <<<EOT
Only operators (including halfops) can change the channel's topic. This mode is enabled by default in every new channel, disabling it will allow any of the channel's users to change the topic at will.
EOT
);
___('irc_faq_chanserv_mode_t',          'FR', <<<EOT
Verrouille le sujet : il n'est possible qu'aux Operators de changer le sujet du canal. Ce mode est activé par défaut sur les nouveaux canaux, le désactiver permettra à toute personne présente sur le canal de changer son sujet.
EOT
);
___('irc_faq_chanserv_mode_u',          'EN', <<<EOT
Sets the channel to "conference mode". The automated messages displayed when regular users (non operators) join or leave the channel will not be shown to other regular users. This drastically reduces the amount of join/leave spam seen by regular users in bigger and more active IRC channels.
EOT
);
___('irc_faq_chanserv_mode_u',          'FR', <<<EOT
Passe le canal en mode « conférence » : les messages automatisés qui s'affichent lorsqu'une personne non-Operator rejoint ou quitte le canal ne seront plus visibles des autres personnes non-Operator. Cela permet de grandement réduire la quantité de spam visible par les personnes non-Operator sur les canaux IRC à forte activité.
EOT
);


// FAQ: Bots
___('irc_faq_bots_body_1',          'EN', <<<EOT
Not every user on NoBleme's IRC server is a human being. Some of them are automated programs designed to serve a specific role on the server, which we call IRC bots.
EOT
);
___('irc_faq_bots_body_1',          'FR', <<<EOT
Tous les pseudonymes que vous croisez sur le serveur IRC NoBleme ne correspondent pas à des humains. Certains cachent des programmes informatiques automatisés, que nous appelons des bots.
EOT
);
___('irc_faq_bots_body_2',          'EN', <<<EOT
Some of our IRC bots are an integral part of the server. Rather than acting like regalur users, they will never be present in any public IRC channel. They are {{link|pages/irc/faq?nickserv|NickServ}}, which handles username management, and {{link|pages/irc/faq?chanserv|ChanServ}}, which handles channel management.
EOT
);
___('irc_faq_bots_body_2',          'FR', <<<EOT
Certains de nos bots sont des éléments importants du serveur IRC NoBleme. Ils ne seront jamais visibles publiquement sur les canaux IRC, et ne servent qu'à échanger des messages en privé. Il s'agit de {{link|pages/irc/faq?nickserv|NickServ}}, qui gère les pseudonymes et les comptes, et de {{link|pages/irc/faq?chanserv|ChanServ}}, qui gère les canaux.
EOT
);
___('irc_faq_bots_body_3',          'EN', <<<EOT
Other bots will be present in IRC channels and directly interact with users in various ways (depending on their purpose). NoBleme's most important IRC bots will be documented on this page, but there might be more of them on the server… keep an eye out for them!
EOT
);
___('irc_faq_bots_body_3',          'FR', <<<EOT
Les autres bots sont présents sur des canaux IRC publics et intéragissent avec les personnes qui y sont présentes de diverses façons (chaque bot a sa propre utilité). Les bots IRC principaux de NoBleme sont documentés sur cette page, mais il peut y en avoir d'autres sur le serveur.
EOT
);

___('irc_faq_bots_nobleme_title',   'EN', "The official NoBleme bot");
___('irc_faq_bots_nobleme_title',   'FR', "Le bot NoBleme officiel");
___('irc_faq_bots_nobleme_body_1',  'EN', <<<EOT
NoBleme only has one official bot. It goes by the nickname <span class="bold">NoBleme</span>, and idles in a few {{link|pages/irc/faq?channels|channels}}. It is a non interactive bot : NoBleme will write content on IRC, but it will never reply to anyone's messages.
EOT
);
___('irc_faq_bots_nobleme_body_1',  'FR', <<<EOT
Il n'existe qu'un seul bot officiel sur le serveur IRC NoBleme. Il utilise le pseudonyme <span class="bold">NoBleme</span>, et se trouve en permanence sur quelques {{link|pages/irc/faq?channels|canaux}}. Il s'agit d'un bot non interactif : il écrit des messages sur IRC, mais ne répond pas aux messages des autres personnes.
EOT
);
___('irc_faq_bots_nobleme_body_2',  'EN', <<<EOT
The official NoBleme bot will relay any activity coming from the website on the channels #english (in english), #NoBleme (in french), and #dev (development updates). Most content that appears on the {{link|pages/nobleme/activity|recent activity}} page will also be shared on IRC by the official NoBleme bot, which allows you to keep in touch with what is happening on the website without having to check the website.
EOT
);
___('irc_faq_bots_nobleme_body_2',  'FR', <<<EOT
Le bot NoBleme officiel partage toute activité intéressante venant du site sur les canaux #NoBleme (en français), #english (en anglais), et #dev (développement du site). La plupart du contenu de l'{{link|pages/nobleme/activity|activité récente}} sera partagé sur IRC par le bot NoBleme officiel, ce qui vous permet de suivre en temps réel l'activité du site.
EOT
);

___('irc_faq_bots_private_title',   'EN', "Non official bots");
___('irc_faq_bots_private_title',   'FR', "Bots non officiels");
___('irc_faq_bots_private_body_1',  'EN', <<<EOT
A non official bot can be found in each of the two major {{link|pages/irc/faq?channels|channels}} of NoBleme's IRC server. Both of these are interactive bots, which have a variety of uses - observe how the regulars use the bots and you might find them useful for your own needs!
EOT
);
___('irc_faq_bots_private_body_1',  'FR', <<<EOT
Un bot IRC non officiel se trouve sur chacun des deux {{link|pages/irc/faq?channels|canaux}} principaux du serveur IRC NoBleme. Il s'agit de bots interactifs, qui peuvent s'utiliser de plusieurs façons - observez les utilisations qu'en font les personnes habituées, peut-être que vous leur trouverez une utilité !
EOT
);
___('irc_faq_bots_private_body_2',  'EN', <<<EOT
On the #english channel, the bot nicknamed <span class="bold">Croissant</span> gives a few quality of life features missing on IRC: previews links, offers a translation service, converts timezones, gives the weather on demand, and more. It is an instance of the {{external|https://sopel.chat/|Sopel}} bot maintained by a user nicknamed Phixion.
EOT
);
___('irc_faq_bots_private_body_2',  'FR', <<<EOT
Sur le canal #NoBleme, le bot portant le pseudonyme <span class="bold">Akundo</span> protège des spammeurs, et possède quelques commandes sans utilité particulière. Il s'agit d'un {{external|https://fr.wikipedia.org/wiki/Eggdrop|Eggdrop}} maintenu par ThArGos.
EOT
);
___('irc_faq_bots_private_body_3',  'EN', <<<EOT
On the #NoBleme channel, the bot nicknamed <span class="bold">Akundo</span> offers flood protection services and has a few silly and useless built-in commands. It is an instance of the {{external|https://en.wikipedia.org/wiki/Eggdrop|Eggdrop}} bot maintained by the user ThArGos.
EOT
);
___('irc_faq_bots_private_body_3',  'FR', <<<EOT
Sur le canal #english, le bot portant le pseudonyme <span class="bold">Croissant</span> offre des services de qualité de vie manquants sur IRC : prévisualisation de liens, traduction de messages, conversion de fuseaux horaires, météo à la demande, etc. Il s'agit d'un {{external|https://sopel.chat/|Sopel}} maintenu par Phixion.
EOT
);

___('irc_faq_bots_custom_title',    'EN', "Can I run my own IRC bot on NoBleme's server?");
___('irc_faq_bots_custom_title',    'FR', "Puis-je utiliser mon propre bot sur le serveur IRC NoBleme ?");
___('irc_faq_bots_custom_body_1',   'EN', <<<EOT
You are free to use bots on the server, as long as they do not cause any disruption.
EOT
);
___('irc_faq_bots_custom_body_1',   'FR', <<<EOT
Libre à vous d'utiliser vos propres bots IRC sur le serveur IRC NoBleme, tant qu'ils ne perturbent pas son bon fonctionnement.
EOT
);
___('irc_faq_bots_custom_body_2',   'EN', <<<EOT
Do keep in mind however that bots might not be welcomed in individual channels. Consult with the local Operators before adding your own bot to an already established channel. For example, the two main channels (#english and #NoBleme) will not accept more than the two bots they each currently have.
EOT
);
___('irc_faq_bots_custom_body_2',   'FR', <<<EOT
Gardez toutefois à l'esprit que vos bots ne seront pas forcément appréciés sur tous les canaux. Demandez d'abord aux Operator locaux si la présence de votre bot sur un canal IRC déjà établi pose problème. Par exemple, les deux canaux principaux (#NoBleme et #english) refusent la présence de bots, à l'exception des deux qui y sont déjà.
EOT
);
___('irc_faq_bots_custom_body_3',   'EN', <<<EOT
If you add a bot on NoBleme's IRC server and believe it could be of public utility, {{link|pages/messages/admins|contact the admins}} detailing your bot's purpose and where to find it. It might get added to this documentation page or maybe even welcomed in some of our official channels.
EOT
);
___('irc_faq_bots_custom_body_3',   'FR', <<<EOT
Si vous ajoutez un bot au serveur IRC NoBleme et pensez qu'il pourrait être d'utilité publique, {{link|pages/messages/admins|contactez l'administration}} en détaillant son utilité et où le trouver. Selon ses fonctionnalités, il pourrait être ajouté à cette page de documentation, voir même invité dans les canaux IRC officiels.
EOT
);