<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                          INTERNATIONALIZATION FUNCTIONS                                           */
/*                                                                                                                   */
/*********************************************************************************************************************/

 /**
 * Returns a localized translation.
 *
 * The translations are stored in the global variable called $GLOBALS['translations'].
 * Translations can optionally have a plural version, in this case append a '+' to the end of 'phrase_name'.
 * If you request a plural and no plural is found by the function, it will return the singular version of the phrase.
 *
 * @param   string                  $string         The string identifying the phrase to be translated.
 * @param   int|null    (OPTIONAL)  $amount         Amount of elements: 1 or null is singular, anything else is plural.
 * @param   int|null    (OPTIONAL)  $spaces_before  Number of spaces to insert before the translation.
 * @param   int|null    (OPTIONAL)  $spaces_after   Number of spaces to append to the end of the translation.
 * @param   array|null  (OPTIONAL)  $preset_values  An array of values to be included in the phrase.
 *
 * @return  string                          The translated string, or an empty string if no translation was found.
 */

function __($string, $amount=null, $spaces_before=0, $spaces_after=0, $preset_values=array())
{
  // If there are no global translations, return nothing
  if(!isset($GLOBALS['translations']))
    return '';
  // If required, use the plural version of the string if it exists (plural translation names ends in a '+')
  if(!is_null($amount) && $amount != 1 && isset($GLOBALS['translations'][$string.'+']))
    $returned_string = $GLOBALS['translations'][$string.'+'];

  // Otherwise, use the requested string
  else if(isset($GLOBALS['translations'][$string]))
    $returned_string = $GLOBALS['translations'][$string];

  // If we have no string to return, return an empty string
  if(!isset($returned_string))
    return '';

  // Look for content to replace if required
  if(is_array($preset_values) && !empty($preset_values))
  {
    // Walk through all elements in the provided array and replace them using a regex
    foreach($preset_values as $key => $value)
      $returned_string = str_replace("{{".($key + 1)."}}", $value, $returned_string);
  }

  // Prepare the spaces to prepend to the string
  if(is_int($spaces_before) && $spaces_before > 0)
    $spaces_before = ($spaces_before == 1) ? " " : str_repeat(" ", $spaces_before);
  else
    $spaces_before = '';

  // Prepare the spaces to append to the string
  if(is_int($spaces_after) && $spaces_after > 0)
    $spaces_after = ($spaces_after == 1) ? " " : str_repeat(" ", $spaces_after);
  else
    $spaces_after = '';

  // Return the string, with the requested spaces around it
  return $spaces_before.$returned_string.$spaces_after;
}




 /**
 * Adds a new translation to the global translations array.
 *
 * @param   string  $name         The identifier of the translation, used to fetch it with the __() function.
 * @param   string  $lang         The language in which the translation is being made.
 * @param   string  $translation  The translated string, which will be returned when calling the __() function.
 *
 * @return  void
 */

function ___($name, $lang, $translation)
{
  // Only treat this if we are in the current language
  $current_lang = (!isset($_SESSION['lang'])) ? 'EN' : $_SESSION['lang'];
  if($current_lang != $lang)
    return null;

  // Check if a translation by this name already exists - if yes publicly humiliate the dev for his poor work :(
  if(isset($GLOBALS['translations'][$name]))
    exit(__('error_duplicate_translation').$name);

  // Create or overwrite an entry in the global translations array
  $GLOBALS['translations'][$name] = $translation;
}




 /**
 * Looks for similar translations in the global translation array.
 *
 * This is a debugging function and should only be used locally during development.
 * To enforce this requirement, the function ends with an exit().
 *
 * @return  void
 */
function debug_duplicate_translations()
{
  // We do a diff between the array before and after filtering all unique values, and dump it
  exit(var_dump(array_unique(array_diff_assoc($GLOBALS['translations'],array_unique($GLOBALS['translations'])))));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   SIMPLE WORDS                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Just words
___('with', 'EN', 'with');
___('with', 'FR', 'avec');


// Quantifiers / amounts
___('times',  'EN', "time");
___('times+', 'EN', "times");
___('times',  'FR', "fois");


// Technical stuff
___('query',  'EN', 'query');
___('query+', 'EN', 'queries');
___('query',  'FR', 'requête');
___('query+', 'FR', 'requêtes');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                BBCODES / NBDBCODES                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

// BBCodes
___('bbcodes_quote',    'EN', "Quote:");
___('bbcodes_quote',    'FR', "Citation :");
___('bbcodes_quote_by', 'EN', "Quote by");
___('bbcodes_quote_by', 'FR', "Citation de");

___('bbcodes_spoiler',      'EN', 'SPOILER');
___('bbcodes_spoiler',      'FR', 'SPOILER');
___('bbcodes_spoiler_hide', 'EN', "HIDE SPOILER CONTENTS");
___('bbcodes_spoiler_hide', 'FR', "MASQUER LE CONTENU CACHÉ");
___('bbcodes_spoiler_show', 'EN', "SHOW SPOILER CONTENTS");
___('bbcodes_spoiler_show', 'FR', "VOIR LE CONTENU CACHÉ");


// NBDBCodes
___('nbdbcodes_video_hidden',       'EN', "This video is hidden (<a href=\"{{1}}pages/user/privacy\">privacy options</a>)");
___('nbdbcodes_video_hidden',       'FR', "Cette vidéo est masquée (<a href=\"{{1}}pages/user/privacy\">options de vie privée</a>)");
___('nbdbcodes_video_hidden_small', 'EN', "Video hidden (<a href=\"{{1}}pages/user/privacy\">privacy options</a>)");
___('nbdbcodes_video_hidden_small', 'FR', "Vidéo masquée (<a href=\"{{1}}pages/user/privacy\">options de vie privée</a>)");

___('nbdbcodes_trends_hidden', 'EN', "This Google trends graph is hidden (<a href=\"{{1}}pages/user/privacy\">privacy options</a>)");
___('nbdbcodes_trends_hidden', 'FR', "Ce graphe Google trends est masqué (<a href=\"{{1}}pages/user/privacy\">options de vie privée</a>)");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 ACTIVITY MESSAGES                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Admin actions
___('activity_admin_en', 'EN', 'Administrating the website');
___('activity_admin_en', 'FR', 'Administrating the website');
___('activity_admin_fr', 'EN', 'Administre secrètement le site');
___('activity_admin_fr', 'FR', 'Administre secrètement le site');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   COMMON FILES                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Error messages

// Strings thrown by the functions on this very page
___('error_duplicate_translation', 'EN', 'Error: Duplicate translation name - ');
___('error_duplicate_translation', 'FR', 'Erreur : Traduction déjà existante - ');


// Strings required by the function that throws the errors
___('error_ohno', 'EN', "OH NO  : (");
___('error_ohno', 'FR', "OH NON  : (");

___('error_encountered', 'EN', "YOU HAVE ENCOUNTERED AN ERROR");
___('error_encountered', 'FR', "VOUS AVEZ RENCONTRÉ UNE ERREUR");


// Forbidden page
___('error_forbidden', 'EN', "This page should not be accessed");
___('error_forbidden', 'FR', "Vous ne devriez pas accéder à cette page");


// Website update
___('error_website_update', 'EN', 'An update is in progress, NoBleme is temporarily closed. Come back in a few minutes.');
___('error_website_update', 'FR', 'Une mise à jour est en cours, NoBleme est temporairement fermé. Revenez dans quelques minutes.');


// Flood check
___('error_flood_login', 'EN', "You can only do this action while logged into your account");
___('error_flood_login', 'FR', "Vous devez être connecté pour effectuer cette action");
___('error_flood_wait', 'EN', "You must wait a bit between each action on the website<br><br>Try doing it again in 10 seconds");
___('error_flood_wait', 'FR', "Vous devez attendre quelques secondes entre chaque action<br><br>Réessayez dans 10 secondes");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Time differentials

// Past actions
___('time_diff_past_future', 'EN', "In the future");
___('time_diff_past_future', 'FR', "Dans le futur");
___('time_diff_past_now', 'EN', "Right now");
___('time_diff_past_now', 'FR', "En ce moment même");
___('time_diff_past_second', 'EN', "A second ago");
___('time_diff_past_second', 'FR', "Il y a 1 seconde");
___('time_diff_past_seconds', 'EN', "{{1}} seconds ago");
___('time_diff_past_seconds', 'FR', "Il y a {{1}} secondes");
___('time_diff_past_minute', 'EN', "A minute ago");
___('time_diff_past_minute', 'FR', "Il y a 1 minute");
___('time_diff_past_minutes', 'EN', "{{1}} minutes ago");
___('time_diff_past_minutes', 'FR', "Il y a {{1}} minutes");
___('time_diff_past_hour', 'EN', "A hour ago");
___('time_diff_past_hour', 'FR', "Il y a 1 heure");
___('time_diff_past_hours', 'EN', "{{1}} hours ago");
___('time_diff_past_hours', 'FR', "Il y a {{1}} heures");
___('time_diff_past_day', 'EN', "Yesterday");
___('time_diff_past_day', 'FR', "Hier");
___('time_diff_past_2days', 'EN', "2 days ago");
___('time_diff_past_2days', 'FR', "Avant-hier");
___('time_diff_past_days', 'EN', "{{1}} days ago");
___('time_diff_past_days', 'FR', "Il y a {{1}} jours");
___('time_diff_past_year', 'EN', "A year ago");
___('time_diff_past_year', 'FR', "L'année dernière");
___('time_diff_past_years', 'EN', "{{1}} years ago");
___('time_diff_past_years', 'FR', "Il y a {{1}} ans");
___('time_diff_past_century', 'EN', "A century ago");
___('time_diff_past_century', 'FR', "Le siècle dernier");
___('time_diff_past_long', 'EN', "An extremely long time ago");
___('time_diff_past_long', 'FR', "Il y a très très longtemps");

// Future actions
___('time_diff_future_past', 'EN', "In the past");
___('time_diff_future_past', 'FR', "Dans le passé");
___('time_diff_future_second', 'EN', "In 1 second");
___('time_diff_future_second', 'FR', "Dans 1 seconde");
___('time_diff_future_seconds', 'EN', "In {{1}} seconds");
___('time_diff_future_seconds', 'FR', "Dans {{1}} secondes");
___('time_diff_future_minute', 'EN', "In 1 minute");
___('time_diff_future_minute', 'FR', "Dans 1 minute");
___('time_diff_future_minutes', 'EN', "In {{1}} minutes");
___('time_diff_future_minutes', 'FR', "Dans {{1}} minutes");
___('time_diff_future_hour', 'EN', "In 1 hour");
___('time_diff_future_hour', 'FR', "Dans 1 heure");
___('time_diff_future_hours', 'EN', "In {{1}} hours");
___('time_diff_future_hours', 'FR', "Dans {{1}} heures");
___('time_diff_future_day', 'EN', "Tomorrow");
___('time_diff_future_day', 'FR', "Demain");
___('time_diff_future_2days', 'EN', "In 2 days");
___('time_diff_future_2days', 'FR', "Après-demain");
___('time_diff_future_days', 'EN', "In {{1}} days");
___('time_diff_future_days', 'FR', "Dans {{1}} jours");
___('time_diff_future_year', 'EN', "In 1 year");
___('time_diff_future_year', 'FR', "Dans 1 an");
___('time_diff_future_years', 'EN', "In {{1}} years");
___('time_diff_future_years', 'FR', "Dans {{1}} ans");
___('time_diff_future_century', 'EN', "Next century");
___('time_diff_future_century', 'FR', "Dans un siècle");
___('time_diff_future_long', 'EN', "In an extremely long time");
___('time_diff_future_long', 'FR', "Dans très très longtemps");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Header

// Language warning
___('header_language_error', 'EN', "Sorry! This page is only available in french and does not have an english translation yet.");
___('header_language_error', 'FR', "Désolé ! Cette page n'est disponible qu'en anglais et n'a pas encore de traduction française.");

// Meta description length warning
___('header_meta_error_short', 'EN', "The meta description tag is too short ({{1}} <= 25)");
___('header_meta_error_short', 'FR', "Le tag meta de description est trop court ({{1}} <= 25)");
___('header_meta_error_long', 'EN', "The meta description tag is too long ({{1}} => 155)");
___('header_meta_error_long', 'FR', "Le tag meta de description est trop long ({{1}} => 155)");

// Status bar
___('header_status_message', 'EN', "{{1}}, you have recieved a new private message, click here to read it!");
___('header_status_message', 'FR', "{{1}}, vous avez reçu un nouveau message privé, cliquez ici pour le lire !");
___('header_status_message+', 'EN', "{{1}}, you have recieved {{2}} new private messages, click here to read them!");
___('header_status_message+', 'FR', "{{1}}, vous avez reçu {{2}} nouveaux messages privés, cliquez ici pour les lire !");
___('header_status_message_short', 'EN', "{{1}}: New private message!");
___('header_status_message_short', 'FR', "{{1}} : Nouveau message privé !");
___('header_status_message_short+', 'EN', "{{1}}: {{2}} new private messages!");
___('header_status_message_short+', 'FR', "{{1}} : {{2}} nouveaux messages privés !");
___('header_status_logged_in', 'EN', "Vous êtes connecté en tant que {{1}}. Cliquez ici pour gérer votre compte ou modifier votre profil.");
___('header_status_logged_in', 'FR', "You are logged in as {{1}}. Click here to manage your account or edit your profile.");
___('header_status_logged_in_short', 'EN', "{{1}}: Manage my account.");
___('header_status_logged_in_short', 'FR', "{{1}} : Gérer mon compte");
___('header_status_logout', 'EN', "Log out");
___('header_status_logout', 'FR', "Déconnexion");
___('header_status_login', 'EN', "You are not logged in: Click here to login or register.");
___('header_status_login', 'FR', "Vous n'êtes pas connecté: Cliquez ici pour vous identifier ou vous enregistrer.");
___('header_status_login_short', 'EN', "Logged out: Click here to login or register.");
___('header_status_login_short', 'FR', "Cliquez ici pour vous identifier ou vous enregistrer.");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global menus

// Top menu
___('menu_top_nobleme', 'EN', "NOBLEME");
___('menu_top_nobleme', 'FR', "NOBLEME");
___('menu_top_talk', 'EN', "TALK");
___('menu_top_talk', 'FR', "DISCUTER");
___('menu_top_play', 'EN', "PLAY");
___('menu_top_play', 'FR', "JOUER");
___('menu_top_read', 'EN', "READ");
___('menu_top_read', 'FR', "LIRE");
___('menu_top_admin', 'EN', "ADMIN");
___('menu_top_admin', 'FR', "ADMIN");
___('menu_top_dev', 'EN', "DEV");
___('menu_top_dev', 'FR', "DEV");

// Side menu actions
___('menu_side_display', 'EN', 'Show the side menu');
___('menu_side_display', 'FR', 'Afficher le menu latéral');
___('menu_side_hide', 'EN', 'Hide the side menu');
___('menu_side_hide', 'FR', 'Masquer le menu latéral');

// Side menu: NoBleme
___('menu_side_nobleme_title', 'EN', "NoBleme.com");
___('menu_side_nobleme_title', 'FR', "NoBleme.com");
___('menu_side_nobleme_homepage', 'EN', "Home page");
___('menu_side_nobleme_homepage', 'FR', "Page d'accueil");
___('menu_side_nobleme_activity', 'EN', "Recent activity");
___('menu_side_nobleme_activity', 'FR', "Activité récente");
___('menu_side_nobleme_community', 'EN', "Community");
___('menu_side_nobleme_community', 'FR', "Communauté");
___('menu_side_nobleme_online', 'EN', "Who's online");
___('menu_side_nobleme_online', 'FR', "Qui est en ligne");
___('menu_side_nobleme_staff', 'EN', "Administrative team");
___('menu_side_nobleme_staff', 'FR', "Équipe administrative");
___('menu_side_nobleme_userlist', 'EN', "Registered user list");
___('menu_side_nobleme_userlist', 'FR', "Liste des membres");
___('menu_side_nobleme_birthdays', 'EN', "User birthdays");
___('menu_side_nobleme_birthdays', 'FR', "Anniversaires");
___('menu_side_nobleme_meetups', 'EN', "Real life meetups");
___('menu_side_nobleme_meetups', 'FR', "Rencontres IRL");
___('menu_side_nobleme_meetup_stats', 'EN', "RL meetup stats");
___('menu_side_nobleme_meetup_stats', 'FR', "Statistiques des IRL");
___('menu_side_nobleme_help', 'EN', "Help / Documentation");
___('menu_side_nobleme_help', 'FR', "Aide & Informations");
___('menu_side_nobleme_documentation', 'EN', "Website documentation");
___('menu_side_nobleme_documentation', 'FR', "Documentation du site");
___('menu_side_nobleme_what_is', 'EN', "What is NoBleme");
___('menu_side_nobleme_what_is', 'FR', "Qu'est-ce que NoBleme");
___('menu_side_nobleme_coc', 'EN', "Code of conduct");
___('menu_side_nobleme_coc', 'FR', "Code de conduite");
___('menu_side_nobleme_api', 'EN', "API publique");
___('menu_side_nobleme_api', 'FR', "Public API");
___('menu_side_nobleme_rss', 'EN', "RSS feeds");
___('menu_side_nobleme_rss', 'FR', "Flux RSS");
___('menu_side_nobleme_dev', 'EN', "Development");
___('menu_side_nobleme_dev', 'FR', "Développement");
___('menu_side_nobleme_behind_scenes', 'EN', "Behind the scenes");
___('menu_side_nobleme_behind_scenes', 'FR', "Coulisses de NoBleme");
___('menu_side_nobleme_devblog', 'EN', "Development blog");
___('menu_side_nobleme_devblog', 'FR', "Blog de développement");
___('menu_side_nobleme_todolist', 'EN', "To-do list");
___('menu_side_nobleme_todolist', 'FR', "Liste des tâches");
___('menu_side_nobleme_roadmap', 'EN', "Website roadmap");
___('menu_side_nobleme_roadmap', 'FR', "Plan de route");
___('menu_side_nobleme_report_bug', 'EN', "Report a bug");
___('menu_side_nobleme_report_bug', 'FR', "Rapporter un bug");
___('menu_side_nobleme_feature', 'EN', "Request a feature");
___('menu_side_nobleme_feature', 'FR', "Quémander un feature");
___('menu_side_nobleme_legal', 'EN', "Legal notice");
___('menu_side_nobleme_legal', 'FR', "Mentions légales");
___('menu_side_nobleme_privacy', 'EN', "Privacy policy");
___('menu_side_nobleme_privacy', 'FR', "Politique de confidentialité");
___('menu_side_nobleme_personal_data', 'EN', "Your personal data");
___('menu_side_nobleme_personal_data', 'FR', "Vos données personnelles");
___('menu_side_nobleme_forget_me', 'EN', "Right to be forgotten");
___('menu_side_nobleme_forget_me', 'FR', "Droit à l'oubli");

// Side menu: Talk
___('menu_side_talk_irc', 'EN', "IRC chat server");
___('menu_side_talk_irc', 'FR', "Serveur de chat IRC");
___('menu_side_talk_irc_intro', 'EN', "What is IRC");
___('menu_side_talk_irc_intro', 'FR', "Qu'est-ce que IRC");
___('menu_side_talk_irc_join', 'EN', "Join the conversation");
___('menu_side_talk_irc_join', 'FR', "Rejoindre la conversation");
___('menu_side_talk_irc_services', 'EN', "Commands and services");
___('menu_side_talk_irc_services', 'FR', "Commandes et services");
___('menu_side_talk_irc_channels', 'EN', "Channel list");
___('menu_side_talk_irc_channels', 'FR', "Liste des canaux");
___('menu_side_talk_forum', 'EN', "Discussion forum");
___('menu_side_talk_forum', 'FR', "Forum de discussion");
___('menu_side_talk_forum_topics', 'EN', "Latest forum topics");
___('menu_side_talk_forum_topics', 'FR', "Sujets de discussion");
___('menu_side_talk_forum_new', 'EN', "Open a new topic");
___('menu_side_talk_forum_new', 'FR', "Démarrer une discussion");
___('menu_side_talk_forum_search', 'EN', "Search the forum");
___('menu_side_talk_forum_search', 'FR', "Recherche sur le forum");
___('menu_side_talk_forum_preferences', 'EN', "Filtering preferences");
___('menu_side_talk_forum_preferences', 'FR', "Préférences de filtrage");

// Side menu: Read
___('menu_side_read_nbdb', 'EN', "NBDB");
___('menu_side_read_nbdb', 'FR', "NBDB");
___('menu_side_read_nbdb_index', 'EN', "The NoBleme Database");
___('menu_side_read_nbdb_index', 'FR', "Base d'informations");
___('menu_side_read_nbdb_web', 'EN', "Internet encyclopedia");
___('menu_side_read_nbdb_web', 'FR', "Encyclopédie du web");
___('menu_side_read_nbdb_web_pages', 'EN', "List of all pages");
___('menu_side_read_nbdb_web_pages', 'FR', "Liste des pages");
___('menu_side_read_nbdb_web_random', 'EN', "Random page");
___('menu_side_read_nbdb_web_random', 'FR', "Page au hasard");
___('menu_side_read_nbdb_web_dictionary', 'EN', "Internet dictionnary");
___('menu_side_read_nbdb_web_dictionary', 'FR', "Dictionnaire du web");
___('menu_side_read_quotes', 'EN', "Miscellanea");
___('menu_side_read_quotes', 'FR', "Miscellanées");
___('menu_side_read_quotes_list', 'EN', "Quote database");
___('menu_side_read_quotes_list', 'FR', "Paroles de NoBlemeux");
___('menu_side_read_quotes_random', 'EN', "Random quote");
___('menu_side_read_quotes_random', 'FR', "Citation au hasard");
___('menu_side_read_quotes_stats', 'EN', "Quote statistics");
___('menu_side_read_quotes_stats', 'FR', "Stats des citations");
___('menu_side_read_quotes_submit', 'EN', "Submit a new quote");
___('menu_side_read_quotes_submit', 'FR', "Proposer une citation");
___('menu_side_read_writers', 'EN', "Writer's corner");
___('menu_side_read_writers', 'FR', "Coin des écrivains");
___('menu_side_read_writers_writings', 'EN', "NoBleme's writings");
___('menu_side_read_writers_writings', 'FR', "Écrits de NoBlemeux");
___('menu_side_read_writers_contests', 'EN', "Writing contests");
___('menu_side_read_writers_contests', 'FR', "Concours d'écriture");
___('menu_side_read_writers_publish', 'EN', "Publish a writing");
___('menu_side_read_writers_publish', 'FR', "Publier un écrit");

// Side menu: Play
___('menu_side_play_nbrpg', 'EN', "NoBlemeRPG");
___('menu_side_play_nbrpg', 'FR', "NoBlemeRPG");
___('menu_side_play_nbrpg_intro', 'EN', "What is the NBRPG");
___('menu_side_play_nbrpg_intro', 'FR', "Qu'est-ce que le NBRPG");
___('menu_side_play_nbrpg_archives', 'EN', "Archived sessions");
___('menu_side_play_nbrpg_archives', 'FR', "Sessions archivées");
___('menu_side_play_nrm', 'EN', "NRM Online");
___('menu_side_play_nrm', 'FR', "NRM Online");
___('menu_side_play_nrm_memory', 'EN', "Remembering the NRM");
___('menu_side_play_nrm_memory', 'FR', "En souvenir du NRM");
___('menu_side_play_nrm_podium', 'EN', "Champions of the past");
___('menu_side_play_nrm_podium', 'FR', "Champions du passé");
___('menu_side_play_radikal', 'EN', "Project: Radikal");
___('menu_side_play_radikal', 'FR', "Projet : Radikal");
___('menu_side_play_radikal_next', 'EN', "NoBleme's next game");
___('menu_side_play_radikal_next', 'FR', "Le prochain jeu NoBleme");

// Side menu: User
___('menu_side_user_pms', 'EN', "Private messages");
___('menu_side_user_pms', 'FR', "Messages privés");
___('menu_side_user_pms_inbox', 'EN', "Message inbox");
___('menu_side_user_pms_inbox', 'FR', "Boîte de réception");
___('menu_side_user_pms_outbox', 'EN', "Sent messages");
___('menu_side_user_pms_outbox', 'FR', "Messages envoyés");
___('menu_side_user_pms_write', 'EN', "Write a message");
___('menu_side_user_pms_write', 'FR', "Écrire un message");
___('menu_side_user_profile', 'EN', "Public profile");
___('menu_side_user_profile', 'FR', "Profil public");
___('menu_side_user_profile_self', 'EN', "My public profile");
___('menu_side_user_profile_self', 'FR', "Voir mon profil public");
___('menu_side_user_profile_edit', 'EN', "Edit my profile");
___('menu_side_user_profile_edit', 'FR', "Modifier mon profil");
___('menu_side_user_settings', 'EN', "Account settings");
___('menu_side_user_settings', 'FR', "Réglages du compte");
___('menu_side_user_settings_privacy', 'EN', "Privacy options");
___('menu_side_user_settings_privacy', 'FR', "Options de vie privée");
___('menu_side_user_settings_nsfw', 'EN', "Adult content options");
___('menu_side_user_settings_nsfw', 'FR', "Options de vulgarité");
___('menu_side_user_settings_email', 'EN', "Change my e-mail");
___('menu_side_user_settings_email', 'FR', "Changer d'e-mail");
___('menu_side_user_settings_password', 'EN', "Change my password");
___('menu_side_user_settings_password', 'FR', "Changer de mot de passe");
___('menu_side_user_settings_nickname', 'EN', "Change my nickname");
___('menu_side_user_settings_nickname', 'FR', "Changer de pseudonyme");
___('menu_side_user_settings_delete', 'EN', "Delete my account");
___('menu_side_user_settings_delete', 'FR', "Supprimer mon compte");

// Side menu: Admin
___('menu_side_admin_activity', 'EN', "Website activity");
___('menu_side_admin_activity', 'FR', "Activité du site");
___('menu_side_admin_modlogs', 'EN', "Moderation logs");
___('menu_side_admin_modlogs', 'FR', "Logs de modération");
___('menu_side_admin_users', 'EN', "User management");
___('menu_side_admin_users', 'FR', "Gestion des membres");
___('menu_side_admin_banned', 'EN', "Banned users");
___('menu_side_admin_banned', 'FR', "Pilori des bannis");
___('menu_side_admin_ban', 'EN', "Ban a user");
___('menu_side_admin_ban', 'FR', "Bannir un utilisateur");
___('menu_side_admin_profile', 'EN', "Edit a profile");
___('menu_side_admin_profile', 'FR', "Modifier un profil");
___('menu_side_admin_password', 'EN', "Reset a password");
___('menu_side_admin_password', 'FR', "Modifier un mot de passe");
___('menu_side_admin_tools', 'EN', "Administrative tools");
___('menu_side_admin_tools', 'FR', "Outils administratifs");
___('menu_side_admin_rights', 'EN', "User access rights");
___('menu_side_admin_rights', 'FR', "Changer les permissions");
___('menu_side_admin_stats', 'EN', "Stats");
___('menu_side_admin_stats', 'FR', "Statistiques");
___('menu_side_admin_pageviews', 'EN', "Pageviews");
___('menu_side_admin_pageviews', 'FR', "Popularité des pages");
___('menu_side_admin_doppelganger', 'EN', "Doppelgänger");
___('menu_side_admin_doppelganger', 'FR', "Doppelgänger");

// Side menu: Dev
___('menu_side_dev_ircbot', 'EN', "NoBleme IRC bot");
___('menu_side_dev_ircbot', 'FR', "Bot IRC NoBleme");
___('menu_side_dev_ircbot_management', 'EN', "IRC bot management");
___('menu_side_dev_ircbot_management', 'FR', "Gestion du bot IRC");
___('menu_side_dev_website', 'EN', "Website management");
___('menu_side_dev_website', 'FR', "Gestion du site");
___('menu_side_dev_checklist', 'EN', "Update checklist");
___('menu_side_dev_checklist', 'FR', "Checklist de mise à jour");
___('menu_side_dev_sql', 'EN', "SQL queries");
___('menu_side_dev_sql', 'FR', "Requêtes SQL");
___('menu_side_dev_close', 'EN', "Close the website");
___('menu_side_dev_close', 'FR', "Fermer le site");
___('menu_side_dev_release', 'EN', "Version numbers");
___('menu_side_dev_release', 'FR', "Numéros de version");
___('menu_side_dev_doc', 'EN', "Developer documentation");
___('menu_side_dev_doc', 'FR', "Documentation de dev");
___('menu_side_dev_doc_snippets', 'EN', "Code snippets");
___('menu_side_dev_doc_snippets', 'FR', "Snippets de code");
___('menu_side_dev_doc_html', 'EN', "HTML / CSS");
___('menu_side_dev_doc_html', 'FR', "HTML / CSS");
___('menu_side_dev_doc_functions', 'EN', "Functions");
___('menu_side_dev_doc_functions', 'FR', "Fonctions");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Footer

___('footer_pageviews', 'EN', "This page has been seen ");
___('footer_pageviews', 'FR', "Cette page a été consultée ");

___('footer_loadtime', 'EN', "Page loaded in ");
___('footer_loadtime', 'FR', "Page chargée en ");

___('footer_version', 'EN', 'Version {{1}}, build {{2}} - {{3}}');
___('footer_version', 'FR', 'Version {{1}}, build {{2}} du {{3}}');

___('footer_shorturl', 'EN', "Shorter link alternative");
___('footer_shorturl', 'FR', "Lien court vers cette page");

___('footer_legal', 'EN', "Legal notices and privacy policy");
___('footer_legal', 'FR', "Mentions légales &amp; confidentialité");