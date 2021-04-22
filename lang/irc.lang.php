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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      IRC FAQ                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Faq: Header
___('irc_faq_title',            'EN', "IRC chat");
___('irc_faq_title',            'FR', "Chat IRC");
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
___('irc_faq_select_nickserv',  'EN', "NickServ: Account management");
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
The quickiest and easiest way to join NoBleme's IRC server is by using a {{link|pages/irc/faq?browser|web client in your browser}}. All you have to do is {{link|pages/irc/faq?browser|click this link}}, choose a nickname, and you'll be in. Simple!
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
___('irc_faq_question_4',       'EN', "Can people \"steal\" my nickname?");
___('irc_faq_question_4',       'FR', "Peut-on me « voler » mon pseudonyme ?");
___('irc_faq_answer_4',         'EN', <<<EOT
In order to gain exclusive ownership of your nickname, you first have to register it using our IRC services. You can find more about it on the {{link|pages/irc/faq?nickserv|IRC account management}} page. You are also free to not register and use IRC as a guest, using whichever nickname you desire.
EOT
);
___('irc_faq_answer_4',         'FR', <<<EOT
Afin d'avoir la propriété exclusive de votre pseudonyme, vous devez d'abord l'enregistrer auprès des services de notre serveur IRC. Plus d'informations à ce sujet sur la page {{link|pages/irc/faq?nickserv|Gérer votre pseudonyme}}. Vous êtes également libre de ne pas enregistrer votre pseudonyme, il ne s'agit que d'une option.
EOT
);
___('irc_faq_question_5',       'EN', "How can I change my nickname?");
___('irc_faq_question_5',       'FR', "Comment changer mon pseudonyme ?");
___('irc_faq_answer_5',         'EN', <<<EOT
You can change your nickname at any time. Some IRC clients allow you to change your nickname directly from their interface, others require you to use a command. You can find out more about commands on the {{link|pages/irc/faq?commands|IRC commands}} page.
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
As every user chooses their preferred IRC client, you have a freedom to bend IRC's user experience any way you want to and can access IRC on any device or platform of your choice. This used to be extremely important in the early days of NoBleme's IRC server, when the competition (MSN, ICQ, Skype, Goole Talk, etc.) locked you into a forced user experience. Nowadays, most real time chat applications offer various degrees of customization, which allow for a properly flexible user experience.
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
Once connected to NoBleme's IRC server, you might want to browse the {{link|pages/irc/faq?channels|channel list}} in order to join all channels that could be of interest to you, and to {{link|pages/irc/faq?nickserv|register your nickname}} in order to gain ownership of your nickname on the server and have access to a few useful features.
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
All actions related to user accounts or channel administrations are done through what are called Services, special users on the IRC network which go by the nicknames NickServ (for users) and ChanServ (for channels). You can read more about them on the {{link|pages/irc/faq?nickserv|NickServ}} and {{link|pages/irc/faq?chanserv|ChanServ}} pages of this FAQ.
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
In most IRC clients, when someone else writes your nickname, you will get notified in some way and see the line of text highlighted. Thus, highlighting someone is the term used for when you aim a message at a specific person on IRC by including their nickname in the message.
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
On IRC channels, some users can be given operator abilities, which allow them to manage the channel and handle problematic users. In most IRC clients, operator levels are represented through specific symbols, which appear before the user's nickname (for example, @Planeshift or ~Bad). These also correspond to a specific user mode, represented by a letter (for example, a channel operator will have +o mode on that channel).
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