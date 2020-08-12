<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       BANS                                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

// User bans: title
___('admin_ban_title', 'EN', "User bans");
___('admin_ban_title', 'FR', "Bannissement d'utilisateurs");


// User bans: ban form
___('admin_ban_add_title',        'EN', "Ban an user");
___('admin_ban_add_title',        'FR', "Bannir un utilisateur");
___('admin_ban_add_nickname',     'EN', "User's nickname");
___('admin_ban_add_nickname',     'FR', "Pseudonyme de l'utilisateur");
___('admin_ban_add_reason_fr',    'EN', "Ban justification in french (optional)");
___('admin_ban_add_reason_fr',    'FR', "Raison du bannissement en français (optionnel)");
___('admin_ban_add_reason_en',    'EN', "Ban justification (optional)");
___('admin_ban_add_reason_en',    'FR', "Raison du bannissement en anglais (optionnel)");
___('admin_ban_add_duration',     'EN', "Ban length");
___('admin_ban_add_duration',     'FR', "Durée du bannissement");
___('admin_ban_add_duration_1d',  'EN', "Light warning: 1 day ban");
___('admin_ban_add_duration_1d',  'FR', "Léger avertissement : 1 jour d'exclusion");
___('admin_ban_add_duration_1w',  'EN', "Serious warning: 1 week ban");
___('admin_ban_add_duration_1w',  'FR', "Avertissement sérieux : 1 semaine d'exclusion");
___('admin_ban_add_duration_1m',  'EN', "Edginess, slurs, hate: 1 month ban");
___('admin_ban_add_duration_1m',  'FR', "Edgy, insultes, haine : 1 mois d'exclusion");
___('admin_ban_add_duration_1y',  'EN', "Threats, harrassment, fascism: 1 year ban");
___('admin_ban_add_duration_1y',  'FR', "Menaces, harcèlement, fascisme : 1 an d'exclusion");
___('admin_ban_add_duration_10y', 'EN', "Spammers, advertisers, illegal content: 10 year ban");
___('admin_ban_add_duration_10y', 'FR', "Spammeurs, publicitaires, contenu illégal : 10 ans d'exclusion");
___('admin_ban_add_button',       'EN', "Ban user");
___('admin_ban_add_button',       'FR', "Bannir");


// User bans: errors
___('admin_ban_add_error_no_nickname',  'EN', "No nickname has been specified");
___('admin_ban_add_error_no_nickname',  'FR', "Il est nécessaire de préciser un pseudonyme");
___('admin_ban_add_error_wrong_user',   'EN', "The specified username does not exist");
___('admin_ban_add_error_wrong_user',   'FR', "Ce pseudonyme n'est associé à aucun·e utilisat·eur·ice");
___('admin_ban_add_error_self',         'EN', "You can not ban yourself");
___('admin_ban_add_error_self',         'FR', "Vous ne pouvez pas vous bannir vous-même");
___('admin_ban_add_error_moderator',    'EN', "Moderators are not allowed to ban administrators");
___('admin_ban_add_error_moderator',    'FR', "Les modérateur·ices ne peuvent pas bannir les administrateur·ices");
___('admin_ban_add_error_length',       'EN', "You must specify a ban length");
___('admin_ban_add_error_length',       'FR', "Il est nécessaire de spécifier la durée du bannissement");
___('admin_ban_add_error_already',      'EN', "This user is already banned! Edit their ban in the table below instead");
___('admin_ban_add_error_already',      'FR', "Membre déjà banni : vous pouvez modifier son bannissement dans la liste ci-dessous");


// Current bans list
___('admin_ban_list_title',     'EN', "Currently banned users");
___('admin_ban_list_title',     'FR', "Bannissements actifs");
___('admin_ban_list_subtitle',  'EN', "Sorted by upcoming unban date");
___('admin_ban_list_subtitle',  'FR', "Triés par date de fin du bannissement");
___('admin_ban_list_end',       'EN', "Ban end");
___('admin_ban_list_end',       'FR', "Fin du ban");
___('admin_ban_list_start',     'EN', "Ban start");
___('admin_ban_list_start',     'FR', "Banni depuis");
___('admin_ban_list_length',    'EN', "Ban length");
___('admin_ban_list_length',    'FR', "Durée du ban");
___('admin_ban_list_purged',    'EN', "Purged");
___('admin_ban_list_purged',    'FR', "Peine purgée");


// Banned private message
$admin_ban_add_private_message_title_en     = "Your account has been banned";
$admin_ban_add_private_message_title_fr     = "Votre compte a été banni";
$admin_ban_add_private_message_no_reason_en = "No reason was specified for the ban. If you don't understand what you did wrong, feel free to discuss it with the [url={{1}}todo_link]administrative team[/url].";
$admin_ban_add_private_message_no_reason_fr = "Aucune raison n'a été spécifiée pour votre bannissement. Si vous ne comprenez pas ce que vous avez commis comme faute, vous pouvez en discuter avec [url={{1}}todo_link]l'équipe administrative[/url].";
$admin_ban_add_private_message_reason_en    = <<<EOT
You have been banned for the following reason: [b]{{2}}[/b].

If you don't understand what you did wrong, feel free to discuss it with the [url={{1}}todo_link]administrative team[/url].
EOT;
$admin_ban_add_private_message_reason_fr    = <<<EOT
Votre compte a été banni pour la raison suivante : [b]{{2}}[/b].

Si vous ne comprenez pas ce que vous avez commis comme faute, vous pouvez en discuter avec [url={{1}}todo_link]l'équipe administrative[/url].
EOT;
$admin_ban_add_private_message_en           = <<<EOT
On {{2}}, your account has been banned {{3}}.

{{4}}

In the future, be mindful of NoBleme's short and clear [url={{1}}todo_link]Code of Conduct[/url].
EOT;
$admin_ban_add_private_message_fr           = <<<EOT
Le {{2}}, votre compte a été banni {{3}}.

{{4}}

Dans le futur, veillez à respecter le [url={{1}}todo_link]Code de Conduite de NoBleme[/url], qui est clair et concis.
EOT;
___('admin_ban_add_private_message_title_en',     'EN', $admin_ban_add_private_message_title_en);
___('admin_ban_add_private_message_title_en',     'FR', $admin_ban_add_private_message_title_en);
___('admin_ban_add_private_message_title_fr',     'EN', $admin_ban_add_private_message_title_fr);
___('admin_ban_add_private_message_title_fr',     'FR', $admin_ban_add_private_message_title_fr);
___('admin_ban_add_private_message_no_reason_en', 'EN', $admin_ban_add_private_message_no_reason_en);
___('admin_ban_add_private_message_no_reason_en', 'FR', $admin_ban_add_private_message_no_reason_en);
___('admin_ban_add_private_message_no_reason_fr', 'EN', $admin_ban_add_private_message_no_reason_fr);
___('admin_ban_add_private_message_no_reason_fr', 'FR', $admin_ban_add_private_message_no_reason_fr);
___('admin_ban_add_private_message_reason_en',    'EN', $admin_ban_add_private_message_reason_en);
___('admin_ban_add_private_message_reason_en',    'FR', $admin_ban_add_private_message_reason_en);
___('admin_ban_add_private_message_reason_fr',    'EN', $admin_ban_add_private_message_reason_fr);
___('admin_ban_add_private_message_reason_fr',    'FR', $admin_ban_add_private_message_reason_fr);
___('admin_ban_add_private_message_en',           'EN', $admin_ban_add_private_message_en);
___('admin_ban_add_private_message_en',           'FR', $admin_ban_add_private_message_en);
___('admin_ban_add_private_message_fr',           'EN', $admin_ban_add_private_message_fr);
___('admin_ban_add_private_message_fr',           'FR', $admin_ban_add_private_message_fr);