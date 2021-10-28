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
___('users_message_sent_by',  'EN', "Sent by {{link|pages/users/{{1}}|{{2}}}} on {{3}}.");
___('users_message_sent_by',  'FR', "Envoyé par {{link|pages/users/{{1}}|{{2}}}} le {{3}}.");
___('users_message_system',   'EN', "System message sent on {{1}}.");
___('users_message_system',   'FR', "Message système envoyé le {{1}}.");
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
___('users_message_reply_system',   'EN', "Replies to system messages will be sent to the website administration's collective inbox. This means that everyone on the {{link|pages/users/admins|administrative team}} will be able to see your reply and to reply back to you.");
___('users_message_reply_system',   'FR', "Les réponses aux messages système sont envoyées à la boîte de réception collective de l'administration du site. Cela signifie que toute {{link|pages/users/admins|l'équipe administrative}} pourra voir votre message et y répondre.");
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
___('users_inbox_system',   'EN', "System message");
___('users_inbox_system',   'FR', "Message système");
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
Private messages sent to other users of the website are - as their name implies - a private conversation between two users, which website administrators can not read. They are however still subject to the website's {{link|pages/doc/coc|code of conduct}}, any reports of abusive private messages will lead to measures being taken against the offending party. Stay civil, private messages are not used to settle grudges or harrass people.
EOD
);
___('users_message_intro',  'FR', <<<EOD
Les messages privés sont - comme leur nom le suggère - des conversations privées que l'administration du site ne peut pas consulter. Ces messages sont toutefois soumis au {{link|pages/doc/coc|code de conduite}} de NoBleme : si l'administration est contactée au sujet d'un message privé abusif, elle agira en conséquence. Même en privé, restez courtois, la messagerie privée n'est pas un lieu pour régler vos comptes ou harceler des gens.
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

// Header: Standard
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
If you plan to use this form to report a breach of the {{link|pages/doc/coc|code of conduct}} by another user or make a copyright claim, make sure to provide enough proof (links, screenshots, descriptions of incriminating content).
EOD
);
___('users_message_admins_proof', 'FR', <<<EOD
Si vous avez l'intention de signaler un non respect du {{link|pages/doc/coc|code de conduite}} ou une brêche de votre propriété intellectuelle, assurez-vous d'inclure des preuves (liens, captures d'écran, descriptions du contenu incriminant).
EOD
);
___('users_message_admins_bug',   'EN', <<<EOD
If you want to report a bug in the website's usage, or want to suggest a new feature that you'd like to have on the website, please use the {{link|pages/tasks/proposal|bug report form}} instead.
EOD
);
___('users_message_admins_bug',   'FR', <<<EOD
Si vous avez trouvé un bug dans le fonctionnement du site, ou que vous avez une suggestion pour un nouveau contenu que vous aimeriez bien voir sur le site, utilisez plutôt le {{link|pages/tasks/proposal|formulaire de rapport de bug}}.
EOD
);


// Header: Username change request
___('users_message_admins_nick_title',  'EN', "Username change request");
___('users_message_admins_nick_title',  'FR', "Changement de pseudonyme");
___('users_message_admins_nick_intro',  'EN', <<<EOD
In order to avoid potential abuse, you can not change your username by yourself. Instead, you must write a request to the website's {{link|pages/users/admins|administrative team}}, which will then proceed to change your username if your request seems properly justified (we will do it in most cases). Before submitting the request, make sure to check that your desired new username is not already taken by searching for it on the {{link|pages/users/list|registered user list}}.
EOD
);
___('users_message_admins_nick_intro',  'FR', <<<EOD
Afin d'éviter certaines formes d'abus, nous ne vous laissons pas la possibilité de changer votre pseudonyme par vous-même. Il faut à la place écrire une requête à {{link|pages/users/admins|l'équipe administrative}}, qui se chargera de modifier votre pseudonyme si votre requête lui semble légitime (nous le ferons dans la majorité des cas). Avant de soumettre la requête, assurez-vous que votre choix de nouveau pseudonyme n'est pas déjà utilisé par un autre compte en le cherchant dans la {{link|pages/users/list|liste des membres}}.
EOD
);
___('users_message_admins_nick_past',  'EN', <<<EOD
Once your username is changed, it will also be retroactively changed in almost all of the website's past content. However there might remain a few places where your old username is still present - but with no link to your account. If you spot your old username still in use somewhere after changing to your new one, use the {{link|pages/messages/admins|administrative contact form}} to report it, and we will fix it. As stated in our {{link|pages/doc/privacy|privacy policy}}, we believe in your right to remain anonymous, and as of such will help you erase any traces left following the change.
EOD
);
___('users_message_admins_nick_past',  'FR', <<<EOD
Une fois votre pseudonyme changé, il sera également changé rétroactivement dans la majorité des contenus du site. Toutefois, il se peut que votre ancien pseudonyme soit toujours présent à quelques endroits - mais sans lien avec votre compte. Si vous repérez votre ancien pseudonyme quelque part sur le site après en avoir changé, {{link|pages/messages/admins|contactez l'administration}} et nous le corrigerons. Comme indiqué dans notre {{link|pages/doc/privacy|politique de confidentialité}}, nous croyons en votre droit à l'anonymat, et par conséquent vous aiderons à effacer toute trace qui pourrait rester suite à vote changement de pseudonyme.
EOD
);


// Header: Account deletion request
___('users_message_admins_del_title',   'EN', "Account deletion request");
___('users_message_admins_del_title',   'FR', "Suppression de compte");
___('users_message_admins_del_intro',   'EN', <<<EOD
Account deletion requests are not automated. Instead, you must write a message to the {{link|pages/users/admins|administrative team}}, which will then proceed to delete your account if the request seems justified (we will do it in most cases).
EOD
);
___('users_message_admins_del_intro',   'FR', <<<EOD
La suppression de comptes n'est pas automatisée. Vous devez écrire un message à {{link|pages/users/admins|l'équipe administrative}}, qui se chargera de la suppression de votre compte si votre requête lui semble justifiée (nous le ferons dans la majorité des cas).
EOD
);
___('users_message_admin_del_history',  'EN', <<<EOD
Deleting an account includes the deletion of a lot of historical content on the website, which we are looking to avoid doing unless strictly necessary. However, our {{link|pages/doc/privacy|privacy policy}} is more important to us than our feelings on the integrity of the website's history. Therefore, we will honor your right to disappearance as long as you properly explain in the form below why you want your account deleted.
EOD
);
___('users_message_admin_del_history',  'FR', <<<EOD
Supprimer un compte implique la suppression de beaucoup de contenu historique du site, ce que nous essayons d'éviter de faire si ce n'est pas strictement nécessaire. Toutefois, notre {{link|pages/doc/privacy|politique de confidentialité}} est plus importante pour nous que nos sentiments sur l'intégrité de l'historique du site. Par conséquent, nous honorerons votre droit à disparaître, à condition que vous expliquiez la raison pour laquelle vous désirez disparaître de NoBleme dans le formulaire ci-dessous.
EOD
);


// Message form
___('users_message_admins_newnick',   'EN', "Your new username (3 to 15 characters, letters and numbers only)");
___('users_message_admins_newnick',   'FR', "Votre nouveau pseudonyme (3 à 15 caractères, chiffres et lettres sans accents)");
___('users_message_admins_nick',      'EN', "Explanation message: Why do you want to change your username?");
___('users_message_admins_nick',      'FR', "Message d'explication: Pourquoi désirez-vous changer votre pseudonyme ?");
___('users_message_admins_name_nick', 'EN', "Username change");
___('users_message_admins_name_nick', 'FR', "Chagement de pseudo");
___('users_message_admins_name_del',  'EN', "Deletion request");
___('users_message_admins_name_del',  'FR', "Suppression de compte");
___('users_message_admins_name',      'EN', "Admin contact form");
___('users_message_admins_name',      'FR', "Formulaire de contact");
___('users_message_admins_body_nick', 'EN', <<<EOD
I would like to change my username.

Desired new username: [b]{{1}}[/b]

[u]Justification:[/u]

EOD
);
___('users_message_admins_body_nick', 'FR', <<<EOD
Je désire changer mon pseudonyme.

Nouveau pseudonyme désiré: [b]{{1}}[/b]

[u]Justification:[/u]

EOD
);
___('users_message_admins_body_del',  'EN', <<<EOD
I would like you to delete my account on NoBleme.

[u]Justification:[/u]

EOD
);
___('users_message_admins_body_del',  'FR', <<<EOD
Je désire que vous supprimez mon compte sur NoBleme.

[u]Justification:[/u]

EOD
);


// Errors / Confirmation
___('users_message_admins_body',      'EN', "Your private must not be empty");
___('users_message_admins_body',      'FR', "Votre message doit avoir un contenu");
___('users_message_error_nick_short', 'EN', "The provided username is too short");
___('users_message_error_nick_short', 'FR', "Le pseudonyme choisi est trop court");
___('users_message_error_nick_long',  'EN', "The provided username is too long");
___('users_message_error_nick_long',  'FR', "Le pseudonyme choisi est trop long");
___('users_message_error_nick_type',  'EN', "The provided username should contain only letters and numbers");
___('users_message_error_nick_type',  'FR', "Le pseudonyme choisi ne doit contenir que des lettres et des chiffres");
___('users_message_admins_sent',      'EN', "Your message has successfully be sent to the administrative team. They have been notified of the message, and will reply whenever they are available.");
___('users_message_admins_sent',      'FR', "Votre message a bien été envoyé à l'équipe administrative, ainsi qu'une notification les informant de l'envoi du message.");




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
___('admin_mail_list_select', 'EN', "Select an admin mail in the right column by clicking on it");
___('admin_mail_list_select', 'FR', "Sélectionnez un courrier administratif dans la colonne de droite en cliquant dessus");
___('admin_mail_list_search', 'EN', "Search through the messages:");
___('admin_mail_list_search', 'FR', "Recherche dans les messages :");
___('admin_mail_list_none',   'EN', "There are currently no private messages in the admin mail inbox.");
___('admin_mail_list_none',   'FR', "Il n'y a actuellement aucun message privé dans la boîte de courrier administratif.");


// Message chain
___('admin_mail_chain_reply',   'EN', "Reply");
___('admin_mail_chain_reply',   'FR', "Répondre");
___('admin_mail_chain_system',  'EN', "Sent to {{link|pages/users/{{1}}|{{2}}}} by <span class=\"bold glow\">{{3}}</span> on {{4}}");
___('admin_mail_chain_system',  'FR', "Envoyé à {{link|pages/users/{{1}}|{{2}}}} par <span class=\"bold glow\">{{3}}</span> le {{4}}");
___('users_mail_chain_unread', 'EN', "This message has not been read yet.");
___('users_mail_chain_unread', 'FR', "Ce message n'a pas encore été lu.");


// Message chain errors
___('admin_mail_error_not_found', 'EN', "The requested message does not exist");
___('admin_mail_error_not_found', 'FR', "Le message demandé n'existe pas");
___('admin_mail_error_deleted',   'EN', "The requested message has been deleted");
___('admin_mail_error_deleted',   'FR', "Le message demandé a été supprimé");
___('admin_mail_error_admins',    'EN', "Only administrators may view this message");
___('admin_mail_error_admins',    'FR', "Seule l'administration peut consulter ce message");


// Reply to a message chain
___('admin_mail_reply_label',   'EN', "Your reply to the message - you can use {{link_popup|pages/doc/bbcodes|BBCodes}} for formatting");
___('admin_mail_reply_label',   'FR', "Votre réponse au message - vous pouvez la formater avec des {{link_popup|pages/doc/bbcodes|BBCodes}}");
___('admin_mail_reply_admins',  'EN', "Only administrators can reply to this message");
___('admin_mail_reply_admins',  'FR', "Seule l'adiminstration peut répondre à ce message");


// Delete a message
___('admin_mail_delete_confirm',  'EN', "Confirm the irreversible deletion of this private message. Do not use this feature lightly, only when strictly necessary.");
___('admin_mail_delete_confirm',  'FR', "Confirmer la suppression irréversible de ce message privé. Ne supprimez pas des messages à outrance, seulement lorsque c\'est strictement nécessaire.");