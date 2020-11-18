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
  <li>Guests will not have any specific formatting.</li>
  <li>{{link|todo_link|Registered users}} will appear in <span class="bold">bold</span>.</li>
  <li>{{link|todo_link|Moderators}} have an <span class="text_orange bold">orange</span> background.</li>
  <li>{{link|todo_link|Administrators}} have a <span class="text_red glow bold">red</span> background.</li>
</ul>
EOD
);
___('users_online_header_colors', 'FR', <<<EOD
Afin de les distinguer, les visiteurs suivent un code couleur :
<ul class="nopadding">
  <li>Les invités n'ont pas de formattage spécifique.</li>
  <li>{{link|todo_link|Les membres du site}} apparaissent en <span class="bold">gras</span>.</li>
  <li>{{link|todo_link|La modération}} apparait en <span class="text_orange bold">orange.</span></li>
  <li>{{link|todo_link|L'administration}} apparait en <span class="text_red glow bold">rouge.</span></li>
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