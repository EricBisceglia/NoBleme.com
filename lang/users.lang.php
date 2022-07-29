<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   WHO'S ONLINE                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_online_title',         'EN', "Who's online?");
___('users_online_title',         'FR', "Qui est en ligne ?");
___('users_online_header_intro',  'EN', <<<EOD
This page lists the most recently visited page of all users that were active on NoBleme in the last month. In the case of guests (users without an account), only the 1000 most recent ones are displayed, and randomly generated silly usernames are assigned to each of them. If you fear that it might enable stalking in ways you're not comfortable with and want to be hidden from this page, you can do that in your account's {{link|pages/account/settings_privacy|privacy options}}.
EOD
);
___('users_online_header_intro',  'FR', <<<EOD
Cette page recense les visites sur NoBleme ce mois-ci. Dans le cas des personnes sans compte, seules les 1000 entrées les plus récentes sont affichées, et des surnoms niais leur sont aléatoirement assignés. Si vous craignez que cette page permette à des gens de vous traquer ou n'êtes juste pas confortable avec le fait d'avoir votre activité listée publiquement, vous pouvez retirer votre compte de la liste via vos {{link|pages/account/settings_privacy|options de vie privée}}.
EOD
);
___('users_online_header_colors', 'EN', <<<EOD
<p class="nopadding">In order to tell them apart from each other, users are color coded:</p>
<ul class="nopadding">
  <li>Guests do not have any specific formatting.</li>
  <li>{{link|pages/users/list|Registered users}} appear in <span class="bold">bold</span>.</li>
  <li>{{link|pages/users/admins|Moderators}} appear in <span class="text_orange bold">orange</span>.</li>
  <li>{{link|pages/users/admins|Administrators}} appear in <span class="text_red glow bold">red</span>.</li>
</ul>
EOD
);
___('users_online_header_colors', 'FR', <<<EOD
<p class="nopadding">Le code couleur suivant est appliqué afin de simplifier la lecture :</p>
<ul class="nopadding">
  <li>Les personnes sans compte n'ont pas de formattage spécifique.</li>
  <li>{{link|pages/users/list|Les membres du site}} apparaissent en <span class="bold">gras</span>.</li>
  <li>{{link|pages/users/admins|La modération}} apparait en <span class="text_orange bold">orange.</span></li>
  <li>{{link|pages/users/admins|L'administration}} apparait en <span class="text_red glow_dark bold">rouge.</span></li>
</ul>
EOD
);


// Options
___('users_online_hide_gests',      'EN', "Do not show guests in the list");
___('users_online_hide_gests',      'FR', "Ne pas afficher les personnes sans compte dans la liste");
___('users_online_admin_view',      'EN', "See the table like a regular user would");
___('users_online_admin_view',      'FR', "Voir la page comme un compte normal");
___('users_online_refresh',         'EN', "Automatically reload the list every 10 seconds");
___('users_online_refresh',         'FR', "Recharger automatiquement la liste toutes les 10 secondes");
___('users_online_refresh_mobile',  'EN', "Refresh the table every 10 seconds");
___('users_online_refresh_mobile',  'FR', "Actualiser la liste toutes les 10 secondes");


// Table
___('users_online_activity',  'EN', "LATEST ACTIVITY");
___('users_online_activity',  'FR', "DERNIÈRE ACTIVITÉ");
___('users_online_page',      'EN', "LAST VISITED PAGE");
___('users_online_page',      'FR', "DERNIÈRE PAGE VISITÉE");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 REGISTERED USERS                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_list_description_intro',  'EN',  <<<EOT
The table below lists all accounts that have been registered on NoBleme, from the most recent to the oldest. Clicking on a username will bring you to the account's profile page.
EOT
);
___('users_list_description_intro',  'FR',  <<<EOT
Le tableau ci-dessous recense tous les comptes qui ont été crées sur NoBleme, du plus récent au plus ancien. Cliquer sur un pseudonyme vous amènera sur le profil du compte.
EOT
);
___('users_list_description_colors', 'EN', <<<EOD
Some users will appear with color coding:
<ul class="nopadding">
  <li>Actively used accounts have a <span class="green text_white spaced bold">green</span> background.</li>
  <li>Banned accounts have a <span class="brown text_white spaced bold">brown</span> background.</li>
  <li>{{link|pages/users/admins|Moderators}} have an <span class="orange text_white spaced bold">orange</span> background.</li>
  <li>{{link|pages/users/admins|Administrators}} have a <span class="red text_white spaced bold">red</span> background.</li>
</ul>
EOD
);
___('users_list_description_colors', 'FR', <<<EOD
Certains comptes apparaissent avec un code couleur :
<ul class="nopadding">
  <li>Les comptes activement utilisés sur un fond <span class="green text_white spaced bold">vert</span>.</li>
  <li>Les comptes bannis sur un fond <span class="brown text_white spaced bold">marron</span>.</li>
  <li>{{link|pages/users/admins|La modération}} sur un fond <span class="orange text_white spaced bold">orange</span>.</li>
  <li>{{link|pages/users/admins|L'administration}} sur un fond <span class="red text_white spaced bold">rouge</span>.</li>
</ul>
EOD
);


// Table
___('users_list_registered',  "EN", "Registered");
___('users_list_registered',  "FR", "Création");
___('users_list_active',      "EN", "Actively used");
___('users_list_active',      "FR", "Activement utilisés");
___('users_list_count',       "EN", "{{1}} NoBleme user account");
___('users_list_count',       "FR", "{{1}} membre de NoBleme");
___('users_list_count+',      "EN", "{{1}} NoBleme user accounts");
___('users_list_count+',      "FR", "{{1}} membres de NoBleme");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                ADMINISTRATIVE TEAM                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_admins_intro',   'EN', <<<EOT
NoBleme's administrative team are a group of volunteers that ensure the smooth running of the website and its community by dealing with any potential issues that could arise within them. If you need their help with an issue - be it of a human or technical nature - you can ask for it {{link|pages/social/irc|through our IRC chat}} or {{link|pages/messages/admins|through the website}}.
EOT
);
___('users_admins_intro',   'FR', <<<EOT
L'équipe administrative de NoBleme est un groupe de volontaires qui modèrent le site internet et sa communauté en gérant les potentiels problèmes qui peuvent y apparaître. Si vous avez besion de leur aide avec un sujet - qu'il soit humain ou technique - vous pouvez les contacter {{link|pages/social/irc|via notre chat IRC}} ou {{link|pages/messages/admins|via le site web}}.
EOT
);
___('users_admins_mods',    'EN', <<<EOT
<span class="text_orange bold">Moderators</span> have full power over any content on the website that involves users: they can ban accounts, reset forgotten passwords, delete accounts, manage real life meetups, etc.
EOT
);
___('users_admins_mods',    'FR', <<<EOT
<span class="text_orange bold">La modération</span> dispose des pleins pouvoirs sur tous les contenus du site impliquant des personnes : bannissements, suppression de comptes, remise à zéro de mots de passe, gestion de rencontres IRL, etc.
EOT
);
___('users_admins_admins',  'EN', <<<EOT
<span class="text_red bold">Adminstrators</span> maintain the technical aspects of the website: they share the same powers as moderators, but can also manage the content of pages, close the website for maintenance, etc.
EOT
);
___('users_admins_admins',  'FR', <<<EOT
<span class="text_red bold">L'administration</span> gère les aspects technique du site : elle possède les mêmes pouvoirs que la modération, et peut également gérer le contenu des pages, fermer le site lors des maintenances techniques, etc.
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  PUBLIC  PROFILE                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_profile_ban',  'EN', "Ban");
___('users_profile_ban',  'FR', "Bannir");


// Deleted account
___('users_profile_deleted',    'EN', "[deleted account]");
___('users_profile_deleted',    'FR', "[compte supprimé]");


// Banned account
___('users_profile_banned',     'EN', "[banned account]");
___('users_profile_banned',     'FR', "[compte banni]");
___('users_profile_unban',      'EN', "Unban");
___('users_profile_unban',      'FR', "Débannir");
___('users_profile_ban_end',    'EN', "Ban scheduled to end {{1}}");
___('users_profile_ban_end',    'FR', "Fin du bannissement {{1}}");


// Account summary
___('users_profile_summary',    'EN', "Account #{{1}}");
___('users_profile_summary',    'FR', "Compte #{{1}}");
___('users_profile_pronouns',   'EN', "Pronouns");
___('users_profile_pronouns',   'FR', "Pronoms");
___('users_profile_country',    'EN', "Country / Location");
___('users_profile_country',    'FR', "Pays / Localisation");
___('users_profile_created',    'EN', "Account registration");
___('users_profile_created',    'FR', "Création du compte");
___('users_profile_activity',   'EN', "Latest visit");
___('users_profile_activity',   'FR', "Dernière visite");
___('users_profile_age',        'EN', "Age");
___('users_profile_age',        'FR', "Âge");
___('users_profile_age_years',  'EN', "{{1}} years old");
___('users_profile_age_years',  'FR', "{{1}} ans");


// Admin info
___('users_profile_admin',    'EN', "Administrative toolbox - keep this private");
___('users_profile_admin',    'FR', "Informations administratives - à garder privé");
___('users_profile_ip',       'EN', "Latest IP address");
___('users_profile_ip',       'FR', "Dernière adresse IP");
___('users_profile_email',    'EN', "E-mail address");
___('users_profile_email',    'FR', "Adresse e-mail");
___('users_profile_unknown',  'EN', "Unknown");
___('users_profile_unknown',  'FR', "Inconnue");
___('users_profile_page',     'EN', "Last visited page");
___('users_profile_page',     'FR', "Dernière page visitée");
___('users_profile_action',   'EN', "Latest action");
___('users_profile_action',   'FR', "Dernière action");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                EDIT PUBLIC PROFILE                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_profile_edit_subtitle',  'EN', "Customize your public profile");
___('users_profile_edit_subtitle',  'FR', "Personnaliser mon profil public");
___('users_profile_edit_intro',     'EN', <<<EOT
Your {{link|pages/users/profile|public profile}} contains a summary of your account on NoBleme for all other users to see. Some elements of your public profile will appear only if you customize them on this page. It is up to you whether you want to leave your public profile bare to preserve your anonymity or whether you'd rather fill it up to give a summary of yourself to others. Every single field below is optional, you can choose to fill in only some of them.
EOT
);
___('users_profile_edit_intro',     'FR', <<<EOT
Votre {{link|pages/users/profile|profil public}} sert de vitrine à destination des autres membres du site, résumant qui vous êtes au sein de NoBleme. Certains éléments de votre profil public n'apparaîtront que si vous les renseignez sur cette page. C'est à vous de choisir si vous préférez laisser votre profil vide afin de préserver votre anonymat, ou si vous préférez le remplir pour que les autres sachent qui vous êtes. Chacun des champs ci-dessous est optionnel, vous pouvez opter pour ne remplir que certains d'entre eux. Le site étant bilingue, il vous est proposé de remplir votre profil en français et en anglais - libre à vous de laisser les parties anglaises vides si vous n'êtes pas confortable dans cette langue.
EOT
);


// Edit form
___('users_profile_edit_bilingual',   'EN', "Spoken languages");
___('users_profile_edit_bilingual',   'FR', "Langues parlées");

___('users_profile_edit_birthday',    'EN', "Birth date (day - month - year)");
___('users_profile_edit_birthday',    'FR', "Date de naissance (jour - mois - année)");

___('users_profile_edit_residence',   'EN', "Your place of residence (country, city, etc.)");
___('users_profile_edit_residence',   'FR', "Votre localisation (pays, ville, etc.)");

___('users_profile_edit_english',     'EN', " (in english)");
___('users_profile_edit_english',     'FR', " (en anglais)");
___('users_profile_edit_french',      'EN', " (in french)");
___('users_profile_edit_french',      'FR', " (en français)");

___('users_profile_edit_pronouns_en', 'EN', "Your {{external|https://en.wikipedia.org/wiki/Preferred_gender_pronoun|preferred pronouns}}");
___('users_profile_edit_pronouns_en', 'FR', "Vos {{external|https://en.wikipedia.org/wiki/Preferred_gender_pronoun|pronoms}}");
___('users_profile_edit_pronouns_fr', 'EN', "Your {{external|https://scfp.ca/sites/cupe/files/pronouns_fr.pdf|preferred pronouns}}");
___('users_profile_edit_pronouns_fr', 'FR', "Vos {{external|https://scfp.ca/sites/cupe/files/pronouns_fr.pdf|pronoms}}");

___('users_profile_edit_text',        'EN', "Custom text - {{link_popup|pages/doc/bbcodes|BBCodes}} allowed");
___('users_profile_edit_text',        'FR', "Texte libre - {{link_popup|pages/doc/bbcodes|BBCodes}} autorisés");

___('users_profile_edit_submit',      'EN', "Customize my public profile");
___('users_profile_edit_submit',      'FR', "Personnaliser mon profil public");

___('users_profile_edit_preview',     'EN', "Preview of your custom text:");
___('users_profile_edit_preview',     'FR', "Prévisualisation de votre texte libre :");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              DELETE A PUBLIC PROFILE                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('users_profile_delete_subtitle',  'EN', "Delete a public profile");
___('users_profile_delete_subtitle',  'FR', "Supprimer un profil public");
___('users_profile_delete_intro',     'EN', <<<EOT
Check the boxes next to each profile section that you wish to delete below, then press the button at the bottom of the page to proceed with the deletion. The user will get a private message notifying them that parts of their public profile have been deleted, so make sure to only do this if the {{link|pages/doc/coc|code of conduct}} is being violated.
EOT
);
___('users_profile_delete_intro',     'FR', <<<EOT
Cochez les cases à côté de chaque section du profil que vous voulez supprimer ci-dessous, puis appuyez sur le bouton en bas de la page pour effectuer la suppression. Le compte reçevra un message privé expliquant qu'une partie de leur profil public a été supprimé, donc assurez-vous de ne le faire qu'en cas de violation du {{link|pages/doc/coc|code de conduite}} du site.
EOT
);
___('users_profile_delete_none',      'EN', <<<EOT
This user's public profile contains no customizable fields - this means that there is nothing you can delete here.
EOT
);
___('users_profile_delete_none',      'FR', <<<EOT
Le profil public de ce compte ne contient aucun contenu personnalisé - cela signifie que vous ne pouvez effectuer aucune action ici.
EOT
);


// Table
___('users_profile_delete_selection', 'EN', "Selection");
___('users_profile_delete_selection', 'FR', "Sélection");
___('users_profile_delete_field',     'EN', "Field");
___('users_profile_delete_field',     'FR', "Champ");
___('users_profile_delete_text',      'EN', "Custom text");
___('users_profile_delete_text',      'FR', "Texte libre");


// Fields
___('users_profile_delete_reason_en', 'EN', "Reason for the deletion (optional)");
___('users_profile_delete_reason_en', 'FR', "Raison de la suppression (en anglais) - optionnel");
___('users_profile_delete_reason_fr', 'EN', "Reason for the deletion (in french) - optional");
___('users_profile_delete_reason_fr', 'FR', "Raison de la suppression (en français) - optionnel");
___('users_profile_delete_submit',    'EN', "Delete the selected fields");
___('users_profile_delete_submit',    'FR', "Supprimer la sélection");


// Private message
___('users_profile_delete_pm_title_en', 'EN', "Your public profile");
___('users_profile_delete_pm_title_en', 'FR', "Your public profile");
___('users_profile_delete_pm_title_fr', 'EN', "Votre profil public");
___('users_profile_delete_pm_title_fr', 'FR', "Votre profil public");
___('users_profile_delete_pm_body_en',  'EN', <<<EOT
Parts of your [url={{1}}pages/users/{{2}}]public profile[/url] have been deleted.

This most likely happened because some of the customized content you had there went against [url={{1}}pages/doc/coc]NoBleme's code of conduct[/url]. Please make sure to respect it in the future.
EOT
);
___('users_profile_delete_pm_body_en',  'FR', <<<EOT
Parts of your [url={{1}}pages/users/{{2}}]public profile[/url] have been deleted.

This most likely happened because some of the customized content you had there went against [url={{1}}pages/doc/coc]NoBleme's code of conduct[/url]. Please make sure to respect it in the future.
EOT
);
___('users_profile_delete_pm_body_fr',  'EN', <<<EOT
Une partie de votre [url={{1}}pages/users/{{2}}]profil public[/url] a été supprimé.

Dans le futur, assurez-vous que le contenu personnalisable de votre profil public respecte le [url={{1}}pages/doc/coc]code de conduite de NoBleme[/url].
EOT
);
___('users_profile_delete_pm_body_fr',  'FR', <<<EOT
Une partie de votre [url={{1}}pages/users/{{2}}]profil public[/url] a été supprimé.

Dans le futur, assurez-vous que le contenu personnalisable de votre profil public respecte le [url={{1}}pages/doc/coc]code de conduite de NoBleme[/url].
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       STATS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page section selector
___('users_stats_selector_title',         'EN', "Users statistics");
___('users_stats_selector_title',         'FR', "Stats des comptes");
___('users_stats_selector_contributions', 'EN', "Contributions");
___('users_stats_selector_contributions', 'FR', "Contributions");
___('users_stats_selector_birthdays',     'EN', "Birthdays");
___('users_stats_selector_birthdays',     'FR', "Anniversaires");
___('users_stats_selector_anniversaries', 'EN', "Anniversaries");
___('users_stats_selector_anniversaries', 'FR', "Âge des comptes");


// Overall stats
___('users_stats_overall_summary',  'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/users/list|accounts}} have been registered on NoBleme.");
___('users_stats_overall_summary',  'FR', "<span class=\"bold\">{{1}}</span> {{link|pages/users/list|comptes}} ont été créés sur NoBleme.");
___('users_stats_overall_admins+',  'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/users/admins|administrators}} manage the website.");
___('users_stats_overall_admins+',  'FR', "<span class=\"bold\">{{1}}</span> comptes d'{{link|pages/users/admins|administration}} gèrent le site.");
___('users_stats_overall_admins',   'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/users/admins|administrator}} manages the website.");
___('users_stats_overall_admins',   'FR', "<span class=\"bold\">{{1}}</span> compte d'{{link|pages/users/admins|administration}} gère le site.");
___('users_stats_overall_mods+',    'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/users/admins|moderators}} manage the website's contents.");
___('users_stats_overall_mods+',    'FR', "<span class=\"bold\">{{1}}</span> comptes de {{link|pages/users/admins|modération}} gèrent les contenus du site.");
___('users_stats_overall_mods',     'EN', "<span class=\"bold\">{{1}}</span> {{link|pages/users/admins|moderator}} manages the website's contents.");
___('users_stats_overall_mods',     'FR', "<span class=\"bold\">{{1}}</span> compte de {{link|pages/users/admins|modération}} gère les contenus du site.");
___('users_stats_overall_banned+',  'EN', "<span class=\"bold\">{{1}}</span> accounts are currently banned.");
___('users_stats_overall_banned+',  'FR', "<span class=\"bold\">{{1}}</span> comptes sont actuellement bannis.");
___('users_stats_overall_banned',   'EN', "<span class=\"bold\">{{1}}</span> account is currently banned.");
___('users_stats_overall_banned',   'FR', "<span class=\"bold\">{{1}}</span> compte est actuellement banni.");
___('users_stats_overall_deleted+', 'EN', "<span class=\"bold\">{{1}}</span> accounts have been deleted.");
___('users_stats_overall_deleted+', 'FR', "<span class=\"bold\">{{1}}</span> comptes ont été supprimés.");
___('users_stats_overall_deleted',  'EN', "<span class=\"bold\">{{1}}</span> account has been deleted.");
___('users_stats_overall_deleted',  'FR', "<span class=\"bold\">{{1}}</span> compte a été supprimé.");
___('users_stats_overall_more',     'EN', " You can find more stats about NoBleme's users by using the dropdown menu at the top.");
___('users_stats_overall_more',     'FR', " Vous trouverez d'autres stats sur les comptes en utilisant le menu déroulant en haut de la page. ");


// Timeline
___('users_stats_years_created',  'EN', "Accounts<br>created");
___('users_stats_years_created',  'FR', "Comptes<br>créés");


// Contributions
___('users_stats_contrib_total',    'EN', "Contribution<br>score");
___('users_stats_contrib_total',    'FR', "Nombre de<br>contributions");
___('users_stats_contrib_quotes_s', 'EN', "Quotes<br>submitted");
___('users_stats_contrib_quotes_s', 'FR', "Citations<br>proposées");
___('users_stats_contrib_quotes_a', 'EN', "Quotes<br>approved");
___('users_stats_contrib_quotes_a', 'FR', "Citations<br>approuvées");
___('users_stats_contrib_tasks',    'EN', "Tasks<br>opened");
___('users_stats_contrib_tasks',    'FR', "Tâches<br>crées");