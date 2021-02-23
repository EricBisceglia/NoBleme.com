<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


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


// Faq: Main
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