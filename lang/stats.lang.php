<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      METRICS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Metrics: Reset
___('admin_metrics_reset',          'EN', "Reset all metrics");
___('admin_metrics_reset',          'FR', "Remise à zéro<br>des indicateurs");
___('admin_metrics_reset_warning',  'EN', "Confirm the irreversible deletion of every current metric");
___('admin_metrics_reset_warning',  'FR', "Confirmer la suppression irréversible de tous les indicateurs actuels");


// Metrics: Table
___('admin_metrics_load',           'EN', "Load");
___('admin_metrics_load',           'FR', "Charge");
___('admin_metrics_minimum',        'EN', "Minimum");
___('admin_metrics_minimum',        'FR', "Minimum");
___('admin_metrics_target',         'EN', "Target");
___('admin_metrics_target',         'FR', "Objectif");
___('admin_metrics_average',        'EN', "Average");
___('admin_metrics_average',        'FR', "Moyenne");
___('admin_metrics_warning',        'EN', "Warning");
___('admin_metrics_warning',        'FR', "Attention");
___('admin_metrics_bad',            'EN', "Bad");
___('admin_metrics_bad',            'FR', "Mauvais");
___('admin_metrics_maximum',        'EN', "Maximum");
___('admin_metrics_maximum',        'FR', "Maximum");
___('admin_metrics_page',           'EN', "Page URL");
___('admin_metrics_page',           'FR', "URL de la page");
___('admin_metrics_count',          'EN', "Stats based on {{1}} page metric");
___('admin_metrics_count',          'FR', "Statistiques issues des performances d'une seule page");
___('admin_metrics_count+',         'EN', "Stats based on {{1}} page metrics");
___('admin_metrics_count+',         'FR', "Statistiques issues des performances de {{1}} pages");
___('admin_metrics_count_search',   'EN', "{{1}} out of {{2}} page metric displayed");
___('admin_metrics_count_search',   'FR', "Performances de {{1}} sur {{2}} pages");
___('admin_metrics_count_search+',  'EN', "{{1}} out of {{2}} page metrics displayed");
___('admin_metrics_count_search+',  'FR', "Performances de {{1}} sur {{2}} pages");


// Metrics: Table actions
___('admin_metrics_table_reset_warning',  'EN', "Confirm the irreversible deletion of this page\'s metrics");
___('admin_metrics_table_reset_warning',  'FR', "Confirmer la suppression irréversible des indicateurs de cette page");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     PAGEVIEWS                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Pageviews: Header
___('admin_views_date',     'EN', "Current comparison date:");
___('admin_views_date',     'FR', "Date de comparaison actuelle :");
___('admin_views_nodate',   'EN', "The comparison data has never been reset");
___('admin_views_nodate',   'FR', "Les données de comparaison n'ont jamais été remises à zéro");
___('admin_views_reset',    'EN', "Reset the comparison data");
___('admin_views_reset',    'FR', "Remise à zéro des données de comparaison");
___('admin_views_warning',  'EN', "Confirm the irreversible loss of all archived page growth data in order to reset them");
___('admin_views_warning',  'FR', "Confirmer la suppression irréversible de toutes les données sur la croissance des pages afin de les remettre à zéro");


// Pageviews: Table
___('admin_views_name',   'EN', "Page name");
___('admin_views_name',   'FR', "Nom de la page");
___('admin_views_growth', 'EN', "Growth");
___('admin_views_growth', 'FR', "Croissance");
___('admin_views_old',    'EN', "Before");
___('admin_views_old',    'FR', "Avant");
___('admin_views_new',    'EN', "NEW");
___('admin_views_new',    'FR', "NOUV.");
___('admin_views_delete', 'EN', "Confirm the irreversible deletion of this page\'s data");
___('admin_views_delete', 'FR', "Confirmer la suppression irréversible des données de cette page");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      GUESTS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('admin_stats_guests_storage',     'EN', <<<EOT
Guest data is currently being stored for <span class="bold text_red glow">{{1}} day</span>.
EOT
);
___('admin_stats_guests_storage',     'FR', <<<EOT
Les données sur les personnes sans compte sont actuellement stockées <span class="bold text_red glow">{{1}} jour</span>.
EOT
);
___('admin_stats_guests_storage+',      'EN', <<<EOT
Guest data is currently being stored for <span class="bold text_red glow">{{1}} days</span>.
EOT
);
___('admin_stats_guests_storage+',      'FR', <<<EOT
Les données sur les personnes sans compte sont actuellement stockées <span class="bold text_red glow">{{1}} jours</span>.
EOT
);
___('admin_stats_guests_lang_en',       'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> use the <span class="bold text_red glow">english</span> language ({{2}}).
EOT
);
___('admin_stats_guests_lang_en',       'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilise le site en <span class="bold text_red glow">anglais</span> ({{2}}).
EOT
);
___('admin_stats_guests_lang_en+',      'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilisent le site en <span class="bold text_red glow">anglais</span> ({{2}}).
EOT
);
___('admin_stats_guests_lang_fr',       'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> use the <span class="bold text_red glow">french</span> language ({{2}}).
EOT
);
___('admin_stats_guests_lang_fr',       'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilise le site en <span class="bold text_red glow">français</span> ({{2}}).
EOT
);
___('admin_stats_guests_lang_fr+',      'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilisent le site en <span class="bold text_red glow">français</span> ({{2}}).
EOT
);
___('admin_stats_guests_themes_dark',   'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> use the <span class="bold text_red glow">dark</span> theme ({{2}}).
EOT
);
___('admin_stats_guests_themes_dark',   'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilise le mode <span class="bold text_red glow">sombre</span> ({{2}}).
EOT
);
___('admin_stats_guests_themes_dark+',  'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilisent le mode <span class="bold text_red glow">sombre</span> ({{2}}).
EOT
);
___('admin_stats_guests_themes_light',  'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> use the <span class="bold text_red glow">light</span> theme ({{2}}).
EOT
);
___('admin_stats_guests_themes_light',  'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilise le mode <span class="bold text_red glow">clair</span> ({{2}}).
EOT
);
___('admin_stats_guests_themes_light+',  'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> utilisent le mode <span class="bold text_red glow">clair</span> ({{2}}).
EOT
);


// Table
___('admin_stats_guests_count',       'EN', "{{1}} guests stored in the database");
___('admin_stats_guests_count',       'FR', "{{1}} personnes en base de données");
___('admin_stats_guests_partial',     'EN', "{{1}} guest out of {{2}} shown ({{3}})");
___('admin_stats_guests_partial',     'FR', "{{1}} personne sur {{2}} affichée ({{3}})");
___('admin_stats_guests_partial+',    'EN', "{{1}} guests out of {{2}} shown ({{3}})");
___('admin_stats_guests_partial+',    'FR', "{{1}} personnes sur {{2}} affichées ({{3}})");
___('admin_stats_guests_identity',    'EN', "Identity");
___('admin_stats_guests_identity',    'FR', "Identité");
___('admin_stats_guests_visits',      'EN', "Visits");
___('admin_stats_guests_visits',      'FR', "Visites");
___('admin_stats_guests_theme_light', 'EN', "Light");
___('admin_stats_guests_theme_light', 'FR', "Clair");
___('admin_stats_guests_theme_dark',  'EN', "Dark");
___('admin_stats_guests_theme_dark',  'FR', "Sombre");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       USERS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('admin_stats_users_visited',      'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> user logged into their account in the past <span class="bold text_red glow">100 days</span> ({{2}}).<br>
EOT
);
___('admin_stats_users_visited+',     'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> users logged into their account in the past <span class="bold text_red glow">100 days</span> ({{2}}).<br>
EOT
);
___('admin_stats_users_visited',      'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> personne s'est connectée à son compte dans les <span class="bold text_red glow">100 jours</span> passés ({{2}}).<br>
EOT
);
___('admin_stats_users_visited+',     'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> personnes se sont connectées à leur compte dans les <span class="bold text_red glow">100 jours</span> passés ({{2}}).<br>
EOT
);
___('admin_stats_users_profiledata',  'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> account has filled some <span class="bold text_red glow">profile</span> data ({{2}}).<br>
EOT
);
___('admin_stats_users_profiledata+', 'EN', <<<EOT
<span class="bold text_red glow">{{1}}</span> accounts have filled some <span class="bold text_red glow">profile</span> data ({{2}}).<br>
EOT
);
___('admin_stats_users_profiledata',  'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> compte a modifié son <span class="bold text_red glow">profil</span> ({{2}}).<br>
EOT
);
___('admin_stats_users_profiledata+', 'FR', <<<EOT
<span class="bold text_red glow">{{1}}</span> comptes ont modifié leur <span class="bold text_red glow">profil</span> ({{2}}).<br>
EOT
);


// Table
___('admin_stats_users_speaks',       'EN', "Speaks");
___('admin_stats_users_speaks',       'FR', "Parle");
___('admin_stats_users_birthday',     'EN', "B.day");
___('admin_stats_users_birthday',     'FR', "Anniv.");
___('admin_stats_users_profile',      'EN', "Profile");
___('admin_stats_users_profile',      'FR', "Profil");
___('admin_stats_users_count',        'EN', "{{1}} users registered on the website");
___('admin_stats_users_count',        'FR', "{{1}} comptes crées sur le site");
___('admin_stats_users_partial',      'EN', "{{1}} user out of {{2}} shown ({{3}})");
___('admin_stats_users_partial',      'FR', "{{1}} compte sur {{2}} affiché ({{3}})");
___('admin_stats_users_partial+',     'EN', "{{1}} users out of {{2}} shown ({{3}})");
___('admin_stats_users_partial+',     'FR', "{{1}} comptes sur {{2}} affichés ({{3}})");
___('admin_stats_users_empty',        'EN', "Empty");
___('admin_stats_users_empty',        'FR', "Vide");
___('admin_stats_users_filled',       'EN', "Filled");
___('admin_stats_users_filled',       'FR', "Rempli");
___('admin_stats_users_complete',     'EN', "Complete");
___('admin_stats_users_complete',     'FR', "Complet");
___('admin_stats_users_action',       'EN', "Happened");
___('admin_stats_users_action',       'FR', "A agi");
___('admin_stats_users_noaction',     'EN', "Never");
___('admin_stats_users_noaction',     'FR', "Jamais");
___('admin_stats_users_pronouns',     'EN', "Pronouns");
___('admin_stats_users_pronouns',     'FR', "Pronoms");
___('admin_stats_users_profile_text', 'EN', "Profile text");
___('admin_stats_users_profile_text', 'FR', "Texte libre");
___('admin_stats_users_all_nsfw',     'EN', "Sees all NSFW content");
___('admin_stats_users_all_nsfw',     'FR', "Voit tout le contenu NSFW");
___('admin_stats_users_some_nsfw',    'EN', "Sees NSFW text only");
___('admin_stats_users_some_nsfw',    'FR', "Texte NSFW uniquement");
___('admin_stats_users_no_nsfw',      'EN', "Blocks NSFW content");
___('admin_stats_users_no_nsfw',      'FR', "Bloque le contenu NSFW");
___('admin_stats_users_youtube',      'EN', "Blocked YouTube");
___('admin_stats_users_youtube',      'FR', "Bloque YouTube");
___('admin_stats_users_discord',      'EN', "Blocked Discord");
___('admin_stats_users_discord',      'FR', "Bloque Discord");
___('admin_stats_users_trends',       'EN', "Blocked Trends");
___('admin_stats_users_trends',       'FR', "Bloque Trends");
___('admin_stats_users_kiwiirc',      'EN', "Blocked KiwiIRC");
___('admin_stats_users_kiwiirc',      'FR', "Bloque KiwiIRC");
___('admin_stats_users_hidden',       'EN', "Hidden from recent activity");
___('admin_stats_users_hidden',       'FR', "N'apparait pas dans l'activité récente");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   DOPPELGÄNGER                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Doppelgänger: Header
___('admin_doppel_subtitle',  'EN', "Accounts sharing an IP address");
___('admin_doppel_subtitle',  'FR', "Comptes partageant une adresse IP");
___('admin_doppel_none',      'EN', "There are currently no doppelgänger on the website.");
___('admin_doppel_none',      'FR', "Il n'y a actuellement aucun doppelgänger sur le site.");


// Doppelgänger: Table
___('admin_doppel_ip',        'EN', "IP address");
___('admin_doppel_ip',        'FR', "Adresse IP");
___('admin_doppel_activity',  'EN', "Last active");
___('admin_doppel_activity',  'FR', "Dernière activité");
___('admin_doppel_banned',    'EN', "Banned until");
___('admin_doppel_banned',    'FR', "Compte banni");