<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 PRIVATE MESSAGES                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Errors
___('users_message_not_found',  'EN', "Private message not found");
___('users_message_not_found',  'FR', "Le message privé n'a pas été trouvé");
___('users_message_neighbor',   'EN', "You are not allowed to view other people's private messages");
___('users_message_neighbor',   'FR', "Vous ne pouvez pas voir les messages privés des autres comptes");


// Private message
___('users_message_sent_by',  'EN', "Sent by {{link|todo_link?id={{1}}|{{2}}}} on {{3}}.");
___('users_message_sent_by',  'FR', "Envoyé par {{link|todo_link?id={{1}}|{{2}}}} le {{3}}.");
___('users_message_system',   'EN', "Automated message sent on {{1}}.");
___('users_message_system',   'FR', "Message automatisé envoyé le {{1}}.");
___('users_message_read',     'EN', "Read on {{1}}.");
___('users_message_read',     'FR', "Lu le {{1}}.");


// Private message parents
___('users_message_parents',        'EN', "This message is part of a conversation. Below is the rest of the messages in this conversation, from the most recent message to the oldest one.");
___('users_message_parents',        'FR', "Ce message fait partie d'une conversation. Vous trouverez ci-dessous le reste de la conversation, du message le plus récent au message le plus ancien.");
___('users_message_chain_sent',     'EN', "Sent by <span class=\"bold glow\">{{1}}</span> on {{2}} ({{3}})");
___('users_message_chain_sent',     'FR', "Envoyé par <span class=\"bold glow\">{{1}}</span> le {{2}} ({{3}})");
___('users_message_chain_deleted',  'EN', "[A message in the conversation has been deleted]");
___('users_message_chain_deleted',  'FR', "[Un des messages de la conversation a été supprimé]");


// Reply to a private message
___('users_message_reply',          'EN', "Reply to this message");
___('users_message_reply',          'FR', "Répondre au message");
___('users_message_reply_system',   'EN', "Replies to automated messages will be sent to the website administration's collective inbox. This means that everyone on the {{link|pages/users/admins|administrative team}} will be able to see your reply and to reply back to you.");
___('users_message_reply_system',   'FR', "Les réponses aux messages automatisés sont envoyées à la boîte de réception collective de l'administration du site. Cela signifie que toute {{link|pages/users/admins|l'équipe administrative}} pourra voir votre message et y répondre.");
___('users_message_reply_title',    'EN', "Your reply - you can use {{1}} for formatting");
___('users_message_reply_title',    'FR', "Votre réponse - vous pouvez la formater avec des {{1}}");
___('users_message_reply_send',     'EN', "Send reply");
___('users_message_reply_send',     'FR', "Envoyer la réponse");
___('users_message_reply_no_body',  'EN', "Your message must not be empty");
___('users_message_reply_no_body',  'FR', "Votre message ne peut pas être vide");
___('users_message_reply_self',     'EN', "You can not reply to yourself");
___('users_message_reply_self',     'FR', "Vous ne pouvez pas répondre à vos propres messages");
___('users_message_reply_others',   'EN', "You can not reply to messages that do not belong to you");
___('users_message_reply_others',   'FR', "Vous ne pouvez pas réponder à des messages qui ne vous sont pas destinés");
___('users_message_reply_flood',    'EN', "Your message has not been sent. In order to prevent flood, you must wait before performing another action on the website");
___('users_message_reply_flood',    'FR', "Votre message n'a pas été envoyé. Afin d'éviter le flood, vous devez attendre avant de pouvoir effectuer une autre action sur le site");
___('users_message_sent',           'EN', "The message has been sent");
___('users_message_sent',           'FR', "Le message a été envoyé");
___('users_message_preview_reply',  'EN', "Preview of your message :");
___('users_message_preview_reply',  'FR', "Prévisualisation de votre message :");


// Delete a private message
___('users_message_delete',     'EN', "Delete this message");
___('users_message_delete',     'FR', "Supprimer ce message");
___('users_message_confirm',    'EN', "Confirm the irreversible deletion of this private message.");
___('users_message_confirm',    'FR', "Confirmer la suppression irréversible de ce message privé.");
___('users_message_deleted',    'EN', "This private message has been deleted");
___('users_message_deleted',    'FR', "Ce message privé a été supprimé");
___('users_message_predeleted', 'EN', "This private message has already been deleted");
___('users_message_predeleted', 'FR', "Ce message privé a déjà été supprimé");
___('users_message_ownership',  'EN', "You can not delete other people's private messages");
___('users_message_ownership',  'FR', "Vous ne pouvez pas supprimer les messages privés des autres");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       INBOX                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_inbox_subtitle', 'EN', "Website notifications and private messages");
___('users_inbox_subtitle', 'FR', "Notifications système et messages privés");
___('users_inbox_intro',    'EN', <<<EOD
Messages with a <span class="bold glow text_red">glowing red</span> title are unread, they will automatically be marked as read once you've opened them. Click on a message in the list below to display the content of the message.
EOD
);
___('users_inbox_intro',    'FR', <<<EOD
Les messages avec un titre <span class="bold glow text_red">néon rouge</span> n'ont pas encore été lus, ils seront automatiquement marqués comme lus une fois consultés. Cliquez sur un message dans la liste ci-dessous pour en afficher le contenu.
EOD
);


// Table
___('users_inbox_message',  'EN', "Message title");
___('users_inbox_message',  'FR', "Titre du message");
___('users_inbox_sender',   'EN', "Sender");
___('users_inbox_sender',   'FR', "Expéditeur");
___('users_inbox_sent',     'EN', "Sent");
___('users_inbox_sent',     'FR', "Envoyé");
___('users_inbox_read',     'EN', "Read");
___('users_inbox_read',     'FR', "Lu");
___('users_inbox_count',    'EN', "{{1}} message in your inbox");
___('users_inbox_count',    'FR', "{{1}} message dans votre boîte de réception");
___('users_inbox_count+',   'EN', "{{1}} messages in your inbox");
___('users_inbox_count+',   'FR', "{{1}} messages dans votre boîte de réception");
___('users_inbox_mark',     'EN', "Mark {{1}} messages as read");
___('users_inbox_mark',     'FR', "Marquer {{1}} messages comme lus");
___('users_inbox_mark_ok',  'EN', "Confirm that you want all currently unread messages to be marked as read.");
___('users_inbox_mark_ok',  'FR', "Confirmez que vous voulez que tous les messages actuellement non lus soient marqués comme lus.");
___('users_inbox_empty',    'EN', "There are currently no messages in your inbox");
___('users_inbox_empty',    'FR', "Vous n'avez aucun message dans votre boîte de réception");
___('users_inbox_unread',   'EN', "Unread");
___('users_inbox_unread',   'FR', "Non lu");
___('users_inbox_system',   'EN', "Automated message");
___('users_inbox_system',   'FR', "Message automatisé");
___('users_inbox_not_read', 'EN', "You have not read this message yet - click here to open it.");
___('users_inbox_not_read', 'FR', "Vous n'avez pas encore lu ce message - cliquez ici pour l'ouvrir.");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      OUTBOX                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_outbox_intro', 'EN', <<<EOD
Messages with a <span class="bold glow text_red">glowing red</span> title have not been read yet by their recipient. Click on a message in the list below to display the content of the message.
EOD
);
___('users_outbox_intro', 'FR', <<<EOD
Les messages avec un titre <span class="bold glow text_red">néon rouge</span> n'ont pas encore été lus par leur destinataire. Cliquez sur un message dans la liste ci-dessous pour en afficher le contenu.
EOD
);

// Table
___('users_outbox_recipient', 'EN', "Recipient");
___('users_outbox_recipient', 'FR', "Destinataire");
___('users_outbox_count',     'EN', "{{1}} message in your outbox");
___('users_outbox_count',     'FR', "{{1}} message envoyé");
___('users_outbox_count+',    'EN', "{{1}} messages in your outbox");
___('users_outbox_count+',    'FR', "{{1}} messages envoyés");
___('users_outbox_empty',     'EN', "There are currently no messages in your outbox");
___('users_outbox_empty',     'FR', "Vous n'avez aucun message envoyé");
___('users_outbox_system',    'EN', "The website's administrative team");
___('users_outbox_system',    'FR', "Équipe administrative du site");
___('users_outbox_not_read',  'EN', "This message has not been read by its recipient yet.");
___('users_outbox_not_read',  'FR', "Ce message n'a pas encore été lu.");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              WRITE A PRIVATE MESSAGE                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_message_intro',  'EN', <<<EOD
Private messages sent to other users of the website are - as their name implies - a private conversation between two users, which website administrators can not read. They are however still subject to the website's {{link|todo_link|code of conduct}}, any reports of abusive private messages will lead to measures being taken against the offending party. Stay civil, private messages are not used to settle grudges or harrass people.
EOD
);
___('users_message_intro',  'FR', <<<EOD
Les messages privés sont - comme leur nom le suggère - des conversations privées que l'administration du site ne peut pas consulter. Ces messages sont toutefois soumis au {{link|todo_link|code de conduite}} de NoBleme : si l'administration est contactée au sujet d'un message privé abusif, elle agira en conséquence. Même en privé, restez courtois, la messagerie privée n'est pas un lieu pour régler vos comptes ou harceler des gens.
EOD
);


// Message form
___('users_message_form_recipient', 'EN', "Message recipient");
___('users_message_form_recipient', 'FR', "Destinataire du message");
___('users_message_form_title',     'EN', "Message title");
___('users_message_form_title',     'FR', "Titre du message");
___('users_message_form_body',      'EN', "Message body - you can use {{1}} for formatting");
___('users_message_form_body',      'FR', "Contenu du message - vous pouvez utiliser des {{1}}");
___('users_message_form_send',      'EN', "Send the message");
___('users_message_form_send',      'FR', "Envoyer le message");


// Message errors
___('users_message_error_recipient',  'EN', "You must specify a recipient for your private message");
___('users_message_error_recipient',  'FR', "Votre message privé doit avoir un destinataire");
___('users_message_error_title',      'EN', "Your private message must have a title");
___('users_message_error_title',      'FR', "Votre message privé doit avoir un titre");
___('users_message_error_body',       'EN', "Your private message must have a body");
___('users_message_error_body',       'FR', "Votre message privé doit avoir un contenu");
___('users_message_error_ghost',      'EN', "The specified username does not exist on the website");
___('users_message_error_ghost',      'FR', "Le pseudonyme spécifié n'existe pas sur le site");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                            CONTACT THE ADMINISTRATION                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_message_admins_title', 'EN', "Contact the administrative team");
___('users_message_admins_title', 'FR', "Contacter l'équipe administrative");
___('users_message_admins_intro', 'EN', <<<EOD
Messages sent using this form will be displayed on a page that can be accessed by every member of the website's {{link|pages/users/admins|administrative team}}. You can use it for anything that warrants a private conversation with the administrative team including reporting illicit content, asking questions related to account security or private data collection, reporting breach of your intellectual property, etc.
EOD
);
___('users_message_admins_intro', 'FR', <<<EOD
Les messages envoyés via ce formulaire arriveront sur une page que toute {{link|pages/users/admins|l'équipe administrative}} du site peut consulter. Vous pouvez l'utiliser pour tout ce qui peut nécessiter une conversation privée avec l'équipe administrative, que ce soit le signalement de contenus illicites, des questions sur la sécurité ou vos données privées, une plainte pour usurpation de votre propriété intellectuelle, etc.
EOD
);
___('users_message_admins_proof', 'EN', <<<EOD
If you plan to use this form to report a breach of the {{link|todo_link|code of conduct}} by another user, make sure to provide enough proof (links, screenshots, descriptions of incriminating content).
EOD
);
___('users_message_admins_proof', 'FR', <<<EOD
Si vous avez l'intention de signaler le non respect du {{link|todo_link|code de conduite}} par un autre compte, assurez-vous d'inclure des preuves (liens, captures d'écran, descriptions du contenu incriminant).
EOD
);
___('users_message_admins_bug',   'EN', <<<EOD
If you want to report a bug in the website's usage, or want to suggest a new feature that you'd like to have on the website, please use the {{link|todo_link|bug report form}} instead.
EOD
);
___('users_message_admins_bug',   'FR', <<<EOD
Si vous avez trouvé un bug dans le fonctionnement du site, ou que vous avez une suggestion pour un nouveau contenu que vous aimeriez bien voir sur le site, utilisez plutôt le {{link|todo_link|formulaire de rapport de bug}}.
EOD
);


// Message form
___('users_message_admins_name',  'EN', "Admin contact form");
___('users_message_admins_name',  'FR', "Formulaire de contact");
___('users_message_admins_body',  'EN', "Your private must not be empty");
___('users_message_admins_body',  'FR', "Votre message doit avoir un contenu");
___('users_message_admins_sent',  'EN', "Your message has successfully be sent to the administrative team. They have been notified of the message, and will reply whenever they are available.");
___('users_message_admins_sent',  'FR', "Votre message a bien été envoyé à l'équipe administrative, ainsi qu'une notification les informant de l'envoi du message.");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                ADMINISTRATIVE MAIL                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('admin_mail_header',  'EN', <<<EOD
Messages with a <span class="text_red glow bold">glowing red title</span> are unread. They will automatically be marked as read once you click on them. All private messages sent through this tool will appear as being sent anonymously from the fictive user <a>NoBleme</a>, and will be readable by all other members of the {{link|pages/users/admins|administrative team}}. With great power comes great responsibility, make a sensible usage of this tool!
EOD
);
___('admin_mail_header',  'FR', <<<EOD
Les messages avec un titre <span class="text_red glow bold">néon rouge</span> n'ont pas encore été lus. Ils seront automatiquement marqués comme lus une fois que vous aurez cliqué dessus. Tous les messages privés envoyés depuis cet outil apparaitront comme envoyés anonymement par le compte fictif <a>NoBleme</a>, et seront visibles par tout le reste de {{link|pages/users/admins|l'équipe administrative}}. Avec de grands pouvoirs viennent de grandes responsabilités, faites-en bon usage !
EOD
);


// Message list
___('admin_mail_list_search', 'EN', "Search through the messages:");
___('admin_mail_list_search', 'FR', "Recherche dans les messages :");


// Message chain
___('admin_mail_chain_reply',   'EN', "Reply");
___('admin_mail_chain_reply',   'FR', "Répondre");
___('admin_mail_chain_system',  'EN', "Sent to {{link|todo_link?id={{1}}|{{2}}}} by <span class=\"bold glow\">{{3}}</span> on {{4}}");
___('admin_mail_chain_system',  'FR', "Envoyé à {{link|todo_link?id={{1}}|{{2}}}} par <span class=\"bold glow\">{{3}}</span> le {{4}}");


// Errors
___('admin_mail_error_not_found', 'EN', "The requested message does not exist");
___('admin_mail_error_not_found', 'FR', "Le message demandé n'existe pas");
___('admin_mail_error_deleted',   'EN', "The requested message has been deleted");
___('admin_mail_error_deleted',   'FR', "Le message demandé a été supprimé");