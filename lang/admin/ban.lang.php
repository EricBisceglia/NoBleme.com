<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     USER BANS                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// User bans: title
___('admin_ban_title', 'EN', "Ban management");
___('admin_ban_title', 'FR', "Bannissements");


// User bans: ban form
___('admin_ban_add_title',        'EN', "Ban a user or an IP address");
___('admin_ban_add_title',        'FR', "Bannir un compte ou une IP");
___('admin_ban_add_type',         'EN', "Ban type");
___('admin_ban_add_type',         'FR', "Type de bannissement");
___('admin_ban_add_type_user',    'EN', "Account");
___('admin_ban_add_type_user',    'FR', "Compte");
___('admin_ban_add_type_ip',      'EN', "IP address (extreme cases only)");
___('admin_ban_add_type_ip',      'FR', "Adresse IP (cas extrêmes uniquement)");
___('admin_ban_add_ip',           'EN', "IP address to ban (you can use wildcards, eg. 127.0.0.*)");
___('admin_ban_add_ip',           'FR', "Adresse IP à bannir (jokers autorisés, par ex. 127.0.0.*)");
___('admin_ban_add_nickname',     'EN', "User's nickname");
___('admin_ban_add_nickname',     'FR', "Pseudonyme du compte à bannir");
___('admin_ban_add_nickname_ip',  'EN', "OR nickname of a user - their IP address will be banned");
___('admin_ban_add_nickname_ip',  'FR', "OU pseudonyme d'un compte - son adresse IP sera bannie");
___('admin_ban_add_full_ip_ban',  'EN', "Severity of the IP ban (total bans are extreme cases only)");
___('admin_ban_add_full_ip_ban',  'FR', "Sévérité du ban IP (réserver le ban total aux cas extrêmes)");
___('admin_ban_add_full_ip_no',   'EN', "Standard: affected users will not be able to log into their accounts");
___('admin_ban_add_full_ip_no',   'FR', "Standard : les utilisateurs affectés ne pourront pas se connecter à leurs comptes");
___('admin_ban_add_full_ip_yes',  'EN', "Full: affected users will not be able to see the website at all");
___('admin_ban_add_full_ip_yes',  'FR', "Total : les utilisateurs affectés ne pourront pas voir le contenu du site");
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
___('admin_ban_add_button',       'FR', "Bannir le compte");
___('admin_ban_add_ip_button',    'EN', "Ban IP address");
___('admin_ban_add_ip_button',    'FR', "Bannir l'adresse IP");


// User bans: errors
___('admin_ban_add_error_no_nickname',  'EN', "No nickname has been specified");
___('admin_ban_add_error_no_nickname',  'FR', "Il est nécessaire de préciser un pseudonyme");
___('admin_ban_add_error_no_ip',        'EN', "No IP address or nickname have been specified");
___('admin_ban_add_error_no_ip',        'FR', "Il est nécessaire de préciser une adresse IP ou un pseudonyme");
___('admin_ban_add_error_wildcard',     'EN', "You are not allowed to IP ban the whole planet");
___('admin_ban_add_error_wildcard',     'FR', "Vous n'avez pas le droit de bannir toute la planète");
___('admin_ban_add_error_wildcards',    'EN', "Only one wildcard (*) is allowed at a time");
___('admin_ban_add_error_wildcards',    'FR', "Un maximum d'un seul joker (*) est autorisé");
___('admin_ban_add_error_ip_and_user',  'EN', "You must specify an IP address OR a nickname, not both");
___('admin_ban_add_error_ip_and_user',  'FR', "Il est nécessaire de préciser SOIT une adresse IP SOIT un pseudonyme, non pas les deux");
___('admin_ban_add_error_wrong_user',   'EN', "The specified username does not exist");
___('admin_ban_add_error_wrong_user',   'FR', "Ce pseudonyme n'est associé à aucun compte");
___('admin_ban_add_error_self',         'EN', "You can not ban yourself");
___('admin_ban_add_error_self',         'FR', "Vous ne pouvez pas vous bannir vous-même");
___('admin_ban_add_error_moderator',    'EN', "Moderators are not allowed to ban administrators");
___('admin_ban_add_error_moderator',    'FR', "La modération ne peut pas bannir l'administration");
___('admin_ban_add_error_length',       'EN', "You must specify a ban length");
___('admin_ban_add_error_length',       'FR', "Il est nécessaire de spécifier la durée du bannissement");
___('admin_ban_add_error_no_user_ip',   'EN', "No IP address has been found for this user");
___('admin_ban_add_error_no_user_ip',   'FR', "Aucune adresse IP n'est associée à ce compte");
___('admin_ban_add_error_already',      'EN', "This user is already banned! Edit their ban in the table below instead");
___('admin_ban_add_error_already',      'FR', "Compte déjà banni : vous pouvez modifier son bannissement dans la liste ci-dessous");
___('admin_ban_add_error_ip_already',   'EN', "This IP address is already banned! Edit their ban in the table below instead");
___('admin_ban_add_error_ip_already',   'FR', "Adresse IP déjà bannie : vous pouvez modifier son bannissement dans la liste ci-dessous");
___('admin_ban_add_error_ip_admin',     'EN', "You can not IP ban an IP belonging to an administrator");
___('admin_ban_add_error_ip_admin',     'FR', "Vous ne pouvez pas bannir une IP appartenant à l'administration du site");


// Current bans list
___('admin_ban_list_title',           'EN', "Currently banned users");
___('admin_ban_list_title',           'FR', "Bannissements actifs");
___('admin_ban_list_subtitle',        'EN', "Sorted by upcoming unban date");
___('admin_ban_list_subtitle',        'FR', "Triés par date de fin du bannissement");
___('admin_ban_list_account',         'EN', "User or IP");
___('admin_ban_list_account',         'FR', "Compte ou IP");
___('admin_ban_list_end',             'EN', "Ban end");
___('admin_ban_list_end',             'FR', "Fin du ban");
___('admin_ban_list_start',           'EN', "Ban start");
___('admin_ban_list_start',           'FR', "Début du ban.");
___('admin_ban_list_length',          'EN', "Ban length");
___('admin_ban_list_length',          'FR', "Durée du ban");
___('admin_ban_list_served',          'EN', "Served");
___('admin_ban_list_served',          'FR', "Peine purgée");
___('admin_ban_list_tooltip_total',   'EN', "This is a total IP ban: the affected users can't even see any of the website's content at all.");
___('admin_ban_list_tooltip_total',   'FR', "Il s'agit d'un ban IP total : les IP affectées ne peuvent même pas voir le contenu du site.");
___('admin_ban_list_tooltip_users',   'EN', "{{1}} account is affected by this IP ban:");
___('admin_ban_list_tooltip_users',   'FR', "{{1}} compte est affecté par ce ban d'IP :");
___('admin_ban_list_tooltip_users+',  'EN', "{{1}} accounts are affected by this IP ban:");
___('admin_ban_list_tooltip_users+',  'FR', "{{1}} comptes sont affectés par ce ban d'IP :");
___('admin_ban_list_tooltip_none',    'EN', "No accounts are affected by this IP ban");
___('admin_ban_list_tooltip_none',    'FR', "Aucun compte n'est affecté par ce ban IP");


// Ban log history
___('admin_ban_logs_title',         'EN', "Ban history logs");
___('admin_ban_logs_title',         'FR', "Historique des bannissements");
___('admin_ban_logs_start',         'EN', "Banned");
___('admin_ban_logs_start',         'FR', "Bannissement");
___('admin_ban_logs_end',           'EN', "Unbanned");
___('admin_ban_logs_end',           'FR', "Fin du<br>bannissement");
___('admin_ban_logs_length',        'EN', "Days<br>sentenced");
___('admin_ban_logs_length',        'FR', "Jours<br>ban.");
___('admin_ban_logs_served',        'EN', "Days<br>banned");
___('admin_ban_logs_served',        'FR', "Jours<br>purgés");
___('admin_ban_logs_percent',       'EN', "Percent<br>served");
___('admin_ban_logs_percent',       'FR', "Pourcent.<br>purgés");
___('admin_ban_logs_banned_by',     'EN', "Banned by");
___('admin_ban_logs_banned_by',     'FR', "Bannissement<br>par");
___('admin_ban_logs_unbanned_by',   'EN', "Unbanned by");
___('admin_ban_logs_unbanned_by',   'FR', "Bannissement<br>annulé par");
___('admin_ban_logs_ban_reason',    'EN', "Ban reason");
___('admin_ban_logs_ban_reason',    'FR', "Raison du<br>bannissement");
___('admin_ban_logs_unban_reason',  'EN', "Unban reason");
___('admin_ban_logs_unban_reason',  'FR', "Raison de fin<br>du bannissement");
___('admin_ban_logs_status_banned', 'EN', "Active bans");
___('admin_ban_logs_status_banned', 'FR', "Bannissements actifs");
___('admin_ban_logs_status_free',   'EN', "Expired bans");
___('admin_ban_logs_status_free',   'FR', "Bannissements finis");
___('admin_ban_logs_info_found',    'EN', "{{1}} logs found in the ban history");
___('admin_ban_logs_info_found',    'FR', "{{1}} entrées trouvées dans l'historique des bannissements");
___('admin_ban_logs_info_none',     'EN', "No logs have been found in the ban history");
___('admin_ban_logs_info_none',     'FR', "Aucune entrée trouvée dans l'historique des bannissements");
___('admin_ban_logs_info_delete',   'EN', "Confirm the permanent and irreversible deletion of this entry in the ban history logs");
___('admin_ban_logs_info_delete',   'FR', "Confirmer la suppression permanente et irréversible de cette entrée de l\'historique des bannissements");


// Ban log popin
___('admin_ban_logs_error_missing',     'EN', "The requested ban log does not exist");
___('admin_ban_logs_error_missing',     'FR', "L'historique du bannissement demandé n'existe pas");
___('admin_ban_logs_popin_title',       'EN', "Ban log");
___('admin_ban_logs_popin_title',       'FR', "Historique de bannissement");
___('admin_ban_logs_full_user',         'EN', "Banned user:");
___('admin_ban_logs_full_user',         'FR', "Compte banni :");
___('admin_ban_logs_full_ip',           'EN', "Banned IP address:");
___('admin_ban_logs_full_ip',           'FR', "Adresse IP bannie :");
___('admin_ban_logs_full_ip_bans',      'EN', "IP banned account:");
___('admin_ban_logs_full_ip_bans',      'FR', "Compte banni par IP :");
___('admin_ban_logs_full_ip_bans+',     'EN', "{{1}} IP banned accounts:");
___('admin_ban_logs_full_ip_bans+',     'FR', "{{1}} comptes bannis par IP :");
___('admin_ban_logs_full_start',        'EN', "Ban date:");
___('admin_ban_logs_full_start',        'FR', "Date du bannissement :");
___('admin_ban_logs_full_end',          'EN', "Scheduled ban end:");
___('admin_ban_logs_full_end',          'FR', "Bannissement jusqu'à :");
___('admin_ban_logs_full_unban',        'EN', "Unban date:");
___('admin_ban_logs_full_unban',        'FR', "Date du débannissement :");
___('admin_ban_logs_full_days',         'EN', "Initial ban duration:");
___('admin_ban_logs_full_days',         'FR', "Durée initiale du bannissement :");
___('admin_ban_logs_full_served',       'EN', "Duration banned:");
___('admin_ban_logs_full_served',       'FR', "Durée purgée :");
___('admin_ban_logs_full_percent',      'EN', "Percent of the ban served:");
___('admin_ban_logs_full_percent',      'FR', "Pourcentage du ban. purgé :");
___('admin_ban_logs_full_banned_by',    'EN', "Banned by:");
___('admin_ban_logs_full_banned_by',    'FR', "Bannissement par :");
___('admin_ban_logs_full_reason_en',    'EN', "Ban reason (english):");
___('admin_ban_logs_full_reason_en',    'FR', "Justification du ban. (anglais) :");
___('admin_ban_logs_full_reason_fr',    'EN', "Ban reason (french):");
___('admin_ban_logs_full_reason_fr',    'FR', "Justification du ban. (français) :");
___('admin_ban_logs_full_unbanned_by',  'EN', "Unbanned by:");
___('admin_ban_logs_full_unbanned_by',  'FR', "Débannissement par :");
___('admin_ban_logs_full_unreason_en',  'EN', "Unan reason (english):");
___('admin_ban_logs_full_unreason_en',  'FR', "Justification du déban. (anglais) :");
___('admin_ban_logs_full_unreason_fr',  'EN', "Unban reason (french):");
___('admin_ban_logs_full_unreason_fr',  'FR', "Justification du déban. (français) :");


// Edit a ban
___('admin_ban_edit_title',     'EN', 'Modify an existing ban');
___('admin_ban_edit_title',     'FR', 'Modifier un bannissement');
___('admin_ban_edit_duration',  'EN', "Ban expiry date");
___('admin_ban_edit_duration',  'FR', "Expiration du bannissement");
___('admin_ban_edit_reban',     'EN', "Modify remaining ban duration (optional)");
___('admin_ban_edit_reban',     'FR', "Modifier la durée restante du bannissement (optionnel)");
___('admin_ban_edit_submit',    'EN', "Edit the ban");
___('admin_ban_edit_submit',    'FR', "Modifier le bannissement");


// Delete a ban
___('admin_ban_delete_title',               'EN', "Unban a user");
___('admin_ban_delete_title',               'FR', "Débannir un compte");
___('admin_ban_delete_title_ip',            'EN', "Unban an IP");
___('admin_ban_delete_title_ip',            'FR', "Débannir une IP");
___('admin_ban_delete_nickname',            'EN', "Nickname of the user you wish to unban");
___('admin_ban_delete_nickname',            'FR', "Pseudonyme du compte à débannir");
___('admin_ban_delete_ip',                  'EN', "IP address you wish to unban");
___('admin_ban_delete_ip',                  'FR', "Adresse IP à débannir");
___('admin_ban_delete_ban_reason',          'EN', "Ban reason");
___('admin_ban_delete_ban_reason',          'FR', "Raison du bannissement");
___('admin_ban_delete_unban_reason_fr',     'EN', "Reason for unbanning the account, in french (optional)");
___('admin_ban_delete_unban_reason_fr',     'FR', "Raison du débannissement en français (optionnel)");
___('admin_ban_delete_unban_reason_en',     'EN', "Reason for unbanning the account (optional)");
___('admin_ban_delete_unban_reason_en',     'FR', "Raison du débannissement en anglais (optionnel)");
___('admin_ban_delete_unban_reason_ip_fr',  'EN', "Reason for unbanning the IP, in french (optional)");
___('admin_ban_delete_unban_reason_ip_fr',  'FR', "Raison du débannissement en français (optionnel)");
___('admin_ban_delete_unban_reason_ip_en',  'EN', "Reason for unbanning the IP (optional)");
___('admin_ban_delete_unban_reason_ip_en',  'FR', "Raison du débannissement en anglais (optionnel)");
___('admin_ban_delete_submit',              'EN', "Unban the account");
___('admin_ban_delete_submit',              'FR', "Débannir le compte");
___('admin_ban_delete_ip_submit',           'EN', "Unban the IP");
___('admin_ban_delete_ip_submit',           'FR', "Débannir l'IP");


// Edit or delete a ban: Errors
___('admin_ban_edit_error_id',      'EN', "This user ID does not exist or is not banned.");
___('admin_ban_edit_error_id',      'FR', "Cet ID de compte n'existe pas ou n'est pas banni.");
___('admin_ban_edit_error_ip',      'EN', "This IP address is not banned.");
___('admin_ban_edit_error_ip',      'FR', "Cette adresse IP n'est pas bannie.");
___('admin_ban_edit_error_rights',  'EN', "Only administrators can ban or unban website staff.");
___('admin_ban_edit_error_rights',  'FR', "Seule l'administration peut bannir ou débannir des membres de l'équipe administrative.");


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


// Ban extension private message
$admin_ban_edit_private_message_title_en  = "Your account ban end date has been changed";
$admin_ban_edit_private_message_title_fr  = "La date de fin de votre bannissement a été modifiée";
$admin_ban_edit_private_message_en        = <<<EOT
On {{2}}, your account's ban has been changed to {{3}}.

In the future, be mindful of NoBleme's short and clear [url={{1}}todo_link]Code of Conduct[/url].
EOT;
$admin_ban_edit_private_message_fr        = <<<EOT
Le {{2}}, la date de fin de votre bannissement a été modifiée : {{3}}.

Dans le futur, veillez à respecter le [url={{1}}todo_link]Code de Conduite de NoBleme[/url], qui est clair et concis.
EOT;
___('admin_ban_edit_private_message_title_en',  'EN', $admin_ban_edit_private_message_title_en);
___('admin_ban_edit_private_message_title_en',  'FR', $admin_ban_edit_private_message_title_en);
___('admin_ban_edit_private_message_title_fr',  'EN', $admin_ban_edit_private_message_title_fr);
___('admin_ban_edit_private_message_title_fr',  'FR', $admin_ban_edit_private_message_title_fr);
___('admin_ban_edit_private_message_en',        'EN', $admin_ban_edit_private_message_en);
___('admin_ban_edit_private_message_en',        'FR', $admin_ban_edit_private_message_en);
___('admin_ban_edit_private_message_fr',        'EN', $admin_ban_edit_private_message_fr);
___('admin_ban_edit_private_message_fr',        'FR', $admin_ban_edit_private_message_fr);


// Manual unban private message
$admin_ban_delete_private_message_title_en  = "Your account has been manually unbanned";
$admin_ban_delete_private_message_title_fr  = "Votre compte a été débanni manuellement";
$admin_ban_delete_private_message_en        = <<<EOT
On {{2}}, your account has been unbanned earlier than planned.

You had purged {{3}} days of your banishment, and had {{4}} days left to purge.

In the future, be mindful of NoBleme's short and clear [url={{1}}todo_link]Code of Conduct[/url].
EOT;
$admin_ban_delete_private_message_fr        = <<<EOT
Le {{2}}, votre compte a été débanni plus tôt que prévu.

Vous aviez purgé {{3}} jours de votre bannissement, et il vous restait {{4}} jours à purger.

Dans le futur, veillez à respecter le [url={{1}}todo_link]Code de Conduite de NoBleme[/url], qui est clair et concis.
EOT;
___('admin_ban_delete_private_message_title_en',      'EN', $admin_ban_delete_private_message_title_en);
___('admin_ban_delete_private_message_title_en',      'FR', $admin_ban_delete_private_message_title_en);
___('admin_ban_delete_private_message_title_fr',      'EN', $admin_ban_delete_private_message_title_fr);
___('admin_ban_delete_private_message_title_fr',      'FR', $admin_ban_delete_private_message_title_fr);
___('admin_ban_delete_private_message_en',            'EN', $admin_ban_delete_private_message_en);
___('admin_ban_delete_private_message_en',            'FR', $admin_ban_delete_private_message_en);
___('admin_ban_delete_private_message_fr',            'EN', $admin_ban_delete_private_message_fr);
___('admin_ban_delete_private_message_fr',            'FR', $admin_ban_delete_private_message_fr);