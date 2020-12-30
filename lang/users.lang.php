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
This page lists the most recently visited page of all users that were active on NoBleme in the last month. In the case of guests (users without an account), only the 1000 most recent ones are displayed, and randomly generated silly usernames are assigned to each of them. If you fear that it might enable stalking in ways you're not comfortable with and want to be hidden from this page, you can do that in your account's {{link|todo_link|privacy options}}.
EOD
);
___('users_online_header_intro',  'FR', <<<EOD
Cette page recense la dernière activité des visiteurs de NoBleme ce mois-ci. Dans le cas des invités (visiteurs non connectés), seuls les 1000 entrées les plus récentes sont affichées, et de petits surnoms stupides leur sont aléatoirement assignés. Si vous craignez que cette page permette à des gens de vous traquer ou n'êtes juste pas confortable avec le fait d'avoir votre activité listée publiquement, vous pouvez retirer votre compte de la liste via vos {{link|todo_link|options de vie privée}}.
EOD
);
___('users_online_header_colors', 'EN', <<<EOD
In order to tell them apart from each other, users are color coded:
<ul class="nopadding">
  <li>Guests do not have any specific formatting.</li>
  <li>{{link|pages/users/list|Registered users}} appear in <span class="bold">bold</span>.</li>
  <li>{{link|pages/users/admins|Moderators}} appear in <span class="text_orange bold">orange</span>.</li>
  <li>{{link|pages/users/admins|Administrators}} appear in <span class="text_red glow bold">red</span>.</li>
</ul>
EOD
);
___('users_online_header_colors', 'FR', <<<EOD
Afin de les distinguer, les visiteurs suivent un code couleur :
<ul class="nopadding">
  <li>Les invités n'ont pas de formattage spécifique.</li>
  <li>{{link|pages/users/list|Les membres du site}} apparaissent en <span class="bold">gras</span>.</li>
  <li>{{link|pages/users/admins|La modération}} apparait en <span class="text_orange bold">orange.</span></li>
  <li>{{link|pages/users/admins|L'administration}} apparait en <span class="text_red glow bold">rouge.</span></li>
</ul>
EOD
);


// Options
___('users_online_hide_gests',      'EN', "Do not show guests in the list");
___('users_online_hide_gests',      'FR', "Ne pas afficher les invités dans la liste");
___('users_online_admin_view',      'EN', "See the table like a regular user would");
___('users_online_admin_view',      'FR', "Voir la page comme un utilisateur normal");
___('users_online_refresh',         'EN', "Automatically reload the table every 10 seconds");
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
___('users_list_languages',   "EN", "Languages");
___('users_list_languages',   "FR", "Langues");
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
NoBleme's administrative team are a group of volunteers that ensure the smooth running of the website and its community by dealing with any potential issues that could arise within them. If you need their help with an issue - be it of a human or technical nature - you can ask for it {{link|todo_link|through our irc server}} or {{link|pages/messages/admins|through the website}}.
EOT
);
___('users_admins_intro',   'FR', <<<EOT
L'équipe administrative de NoBleme est un groupe de volontaires qui maintiennent le site internet et sa communauté en gérant les potentiels problèmes qui peuvent y apparaître. Si vous avez besion de leur aide avec un sujet - qu'il soit humain ou technique - vous pouvez les contacter {{link|todo_link|via le serveur IRC}} ou {{link|pages/messages/admins|via le site web}}.
EOT
);
___('users_admins_mods',    'EN', <<<EOT
<span class="text_orange bold">Moderators</span> have full power over any content on the website that involves users: they can ban accounts, reset forgotten passwords, delete accounts, manage real life meetups, etc.
EOT
);
___('users_admins_mods',    'FR', <<<EOT
<span class="text_orange bold">La modération</span> dispose des pleins pouvoirs sur tous les contenus du site impliquant des utilisateurs : bannissements, suppression de comptes, remise à zéro de mots de passe, gestion de rencontres IRL, etc.
EOT
);
___('users_admins_admins',  'EN', <<<EOT
<span class="text_red bold">Adminstrators</span> maintain the technical aspects of the website: they share the same powers as moderators, but can also manage the content of pages, close the website for maintenance, etc.
EOT
);
___('users_admins_admins',  'FR', <<<EOT
<span class="text_red bold">L'administration</span> gère les aspiects technique du site : elle possède les mêmes pouvoirs que la modération, et peut également gérer le contenu des pages, fermer le site lors des maintenances techniques, etc.
EOT
);


// Table
___('users_admins_title', "EN", "Title");
___('users_admins_title', "FR", "Titre");