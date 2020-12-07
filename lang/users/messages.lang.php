<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


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