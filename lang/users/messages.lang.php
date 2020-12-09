<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  PRIVATE MESSAGE                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Errors
___('users_message_not_found',  'EN', "Private message not found");
___('users_message_not_found',  'FR', "Le message privé n'a pas été trouvé");
___('users_message_neighbor',   'EN', "You are not allowed to view other people's private messages");
___('users_message_neighbor',   'FR', "Vous ne pouvez pas voir les messages privés des autres comptes");


// Private message
___('users_message_sent_by',  'EN', "Sent by {{link|{{1}}|{{2}}}} on {{3}}.");
___('users_message_sent_by',  'FR', "Envoyé par {{link|{{1}}|{{2}}}} le {{3}}.");
___('users_message_system',   'EN', "Automated message sent on {{1}}.");
___('users_message_system',   'FR', "Message automatisé envoyé le {{1}}.");
___('users_message_read',     'EN', "Read on {{1}}.");
___('users_message_read',     'FR', "Lu le {{1}}.");




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
___('users_inbox_empty',    'EN', "There are currently no messages in your inbox");
___('users_inbox_empty',    'FR', "Vous n'avez aucun message dans votre boîte de réception");
___('users_inbox_unread',   'EN', "Unread");
___('users_inbox_unread',   'FR', "Non lu");
___('users_inbox_system',   'EN', "Automated message");
___('users_inbox_system',   'FR', "Message automatisé");
___('users_inbox_not_read', 'EN', "You have not read this message yet - click here to open it.");
___('users_inbox_not_read', 'FR', "Vous n'avez pas encore lu ce message - cliquez ici pour l'ouvrir.");