<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


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
 * Inside those translations, links can be built using the {{link|href|text|style|internal|path}} format.
 * The last 3 parameters of this format are optional - see the doc of the __link() function for details.
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
    return "";

  // Look for content to replace if required
  if(is_array($preset_values) && !empty($preset_values))
  {
    // Walk through all elements in the provided array and replace them using a regex
    foreach($preset_values as $key => $value)
      $returned_string = str_replace("{{".($key + 1)."}}", $value, $returned_string);
  }

  /*
  / Replace URLs if needed, using a regex that can work in either of the following ways:
  / {{link+++|href|text|style|is_internal|path}}
  / {{link++|href|text|style|is_internal}}
  / {{link+|href|text|style}}
  / {{link|href|text}}
  */
  $returned_string = preg_replace('/\{\{link\+\+\+\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", "$3", "$4", "$5"), $returned_string);
  $returned_string = preg_replace('/\{\{link\+\+\|(.*?)\|(.*?)\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", "$3", "$4"), $returned_string);
  $returned_string = preg_replace('/\{\{link\+\|(.*?)\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", "$3"), $returned_string);
  $returned_string = preg_replace('/\{\{link\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2"), $returned_string);

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
 * Builds a link.
 *
 * @param   string      $href         The destination of the link.
 * @param   string      $text         The text to be displayed on the link.
 * @param   string|null $style        The CSS style(s) to apply to the link.
 * @param   bool|null   $is_internal  Whether the link is internel (on the website) or external (outside the website).
 * @param   string|null $path         The path to the root of the website (defaults to 2 folders away from root).
 *
 * @return  string                    The link, ready for use.
 */

function __link($href, $text, $style="bold", $is_internal=1, $path="./../../")
{
  // Prepare the style
  $class = ($style) ? " class=\"$style\"" : "";

  // Prepare the URL
  $url = ($is_internal) ? $path.$href : $href;
  $url = ($url) ? "href=\"".$url."\"" : "";

  // Return the built link
  return "<a $class $url>$text</a>";
}




/**
 * Looks for similar translations in the global translation array.
 *
 * This is a debugging function and should only be used locally during development.
 * To enforce this requirement, the function ends with an exit().
 *
 * @param   int|null  $print_all  OPTIONAL  If set, prints all values in the array after the duplicates.
 *
 * @return  void
 */

function debug_duplicate_translations($print_all=null)
{
  // We do a diff between the array before and after filtering all unique values, and dump it
  $diff = var_dump(array_unique(array_diff_assoc($GLOBALS['translations'], array_unique($GLOBALS['translations']))));

  // If no full printing is requested, exit with the differences
  if(!$print_all)
    exit($diff);

  // Else, print all the existing translations
  else
  {
    echo $diff.'<pre style="max-width: 100%; white-space: pre-wrap;">';
    ksort($GLOBALS['translations']);
    print_r($GLOBALS['translations']);
    exit("</pre>");
  }
}




/**
 * Looks for similar activity names in the page names array.
 *
 * This is a debugging function and should only be used locally during development.
 * To enforce this requirement, the function ends with an exit().
 *
 * @param   array     $page_names           The array containing all page names.
 * @param   int|null  $print_all  OPTIONAL  If set, prints all values in the array after the duplicates.
 *
 * @return  void
 */

function debug_duplicate_page_names($page_names, $print_all=null)
{
  // We do a diff between the array before and after filtering all unique values, and dump it
  $diff = var_dump(array_unique(array_diff_assoc($page_names, array_unique($page_names))));

  // If no full printing is requested, exit with the differences
  if(!$print_all)
    exit($diff);

  // Else, print all the existing user activities
  else
  {
    echo $diff.'<pre style="max-width: 100%; white-space: pre-wrap;">';
    ksort($page_names);
    print_r($page_names);
    exit("</pre>");
  }
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                SHARED TRANSLATIONS                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Website name
___('nobleme', 'EN', "NoBleme");
___('nobleme', 'FR', "NoBleme");
___('nobleme.com', 'EN', "NoBleme.com");
___('nobleme.com', 'FR', "NoBleme.com");


// Punctuation
___(':', 'EN', ":");
___(':', 'FR', " :");


// Common words
___('yes', 'EN', "yes");
___('yes', 'FR', "oui");
___('no', 'EN', "no");
___('no', 'FR', "non");

___('error', 'EN', "error");
___('error', 'FR', "erreur");

___('the', 'EN', "the");
___('the', 'FR', "le");

___('with', 'EN', "with");
___('with', 'FR', "avec");

___('query',  'EN', "query");
___('query+', 'EN', "queries");
___('query',  'FR', "requête");
___('query+', 'FR', "requêtes");

___('nickname', 'EN', "nickname");
___('nickname', 'FR', "pseudonyme");
___('password', 'EN', "password");
___('password', 'FR', "mot de passe");

___('user', 'EN', "user");
___('user', 'FR', "utilisateur");
___('login', 'EN', "login");
___('login', 'FR', "connexion");
___('register', 'EN', "register");
___('register', 'FR', "inscription");

___('option', 'EN', "option");
___('option+', 'EN', "options");
___('option', 'FR', "option");
___('option+', 'FR', "options");


// Quantifiers, amounts, and times
___('times',  'EN', "time");
___('times+', 'EN', "times");
___('times',  'FR', "fois");

___('all', 'EN', "All");
___('all', 'FR', "Tous");

___('at_date', 'EN', "at");
___('at_date', 'FR', "à");





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 BBCODES / NBCODES                                                 */
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


// NBCodes
___('nbcodes_video_hidden',       'EN', "This video is hidden ({{link|{{1}}todo_link|privacy options}})");
___('nbcodes_video_hidden',       'FR', "Cette vidéo est masquée ({{link|{{1}}todo_link|options de vie privée}}");
___('nbcodes_video_hidden_small', 'EN', "Video hidden ({{link|{{1}}todo_link|privacy options}})");
___('nbcodes_video_hidden_small', 'FR', "Vidéo masquée ({{link|{{1}}todo_link|options de vie privée}})");

___('nbcodes_trends_hidden', 'EN', "This Google trends graph is hidden ({{link|{{1}}todo_link|privacy options}})");
___('nbcodes_trends_hidden', 'FR', "Ce graphe Google trends est masqué ({{link|{{1}}todo_link|options de vie privée}})");




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
___('website_closed', 'EN', 'The website is currently closed for maintenance. Click here to reopen it to the public.');
___('website_closed', 'FR', 'Le site est actuellement fermé pour maintenance. Cliquer ici pour le rouvrir au public.');


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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global menus

// Top menu
___('menu_top_nobleme', 'EN', "NOBLEME");
___('menu_top_nobleme', 'FR', "NOBLEME");
___('menu_top_pages', 'EN', "PAGES");
___('menu_top_pages', 'FR', "PAGES");
___('menu_top_social', 'EN', "SOCIAL");
___('menu_top_social', 'FR', "SOCIAL");


// Submenu: NoBleme
___('submenu_nobleme_homepage', 'EN', "Home page");
___('submenu_nobleme_homepage', 'FR', "Page d'accueil");
___('submenu_nobleme_what_is', 'EN', "What is NoBleme");
___('submenu_nobleme_what_is', 'FR', "Qu'est-ce que NoBleme");
___('submenu_nobleme_activity', 'EN', "Recent activity");
___('submenu_nobleme_activity', 'FR', "Activité récente");
___('submenu_nobleme_internet', 'EN', "Internet encyclopedia");
___('submenu_nobleme_internet', 'FR', "Encyclopédie du web");
___('submenu_nobleme_irc', 'EN', "IRC chat server");
___('submenu_nobleme_irc', 'FR', "Serveur de chat IRC");
___('submenu_nobleme_manifesto', 'EN', "Political manifesto");
___('submenu_nobleme_manifesto', 'FR', "Manifeste politique");

___('submenu_nobleme_users', 'EN', "Users");
___('submenu_nobleme_users', 'FR', "Membres");
___('submenu_nobleme_online', 'EN', "Who's online");
___('submenu_nobleme_online', 'FR', "Qui est en ligne");
___('submenu_nobleme_userlist', 'EN', "Registered user list");
___('submenu_nobleme_userlist', 'FR', "Liste des membres");
___('submenu_nobleme_staff', 'EN', "Administrative team");
___('submenu_nobleme_staff', 'FR', "Équipe administrative");
___('submenu_nobleme_birthdays', 'EN', "User birthdays");
___('submenu_nobleme_birthdays', 'FR', "Anniversaires");

___('submenu_nobleme_documentation', 'EN', "Documentation");
___('submenu_nobleme_documentation', 'FR', "Documentation");
___('submenu_nobleme_coc', 'EN', "Code of conduct");
___('submenu_nobleme_coc', 'FR', "Code de conduite");
___('submenu_nobleme_rss', 'EN', "RSS feeds");
___('submenu_nobleme_rss', 'FR', "Flux RSS");
___('submenu_nobleme_privacy', 'EN', "Privacy policy");
___('submenu_nobleme_privacy', 'FR', "Politique de confidentialité");
___('submenu_nobleme_personal_data', 'EN', "Your personal data");
___('submenu_nobleme_personal_data', 'FR', "Vos données personnelles");
___('submenu_nobleme_contact_admin', 'EN', "Contact the admins");
___('submenu_nobleme_contact_admin', 'FR', "Contacter l'administration");

___('submenu_nobleme_dev', 'EN', "Development");
___('submenu_nobleme_dev', 'FR', "Développement");
___('submenu_nobleme_behind_scenes', 'EN', "Behind the scenes");
___('submenu_nobleme_behind_scenes', 'FR', "Coulisses de NoBleme");
___('submenu_nobleme_devblog', 'EN', "Development blog");
___('submenu_nobleme_devblog', 'FR', "Blog de développement");
___('submenu_nobleme_todolist', 'EN', "To-do list");
___('submenu_nobleme_todolist', 'FR', "Liste des tâches");
___('submenu_nobleme_roadmap', 'EN', "Website roadmap");
___('submenu_nobleme_roadmap', 'FR', "Plan de route");
___('submenu_nobleme_report_bug', 'EN', "Report a bug");
___('submenu_nobleme_report_bug', 'FR', "Rapporter un bug");
___('submenu_nobleme_feature', 'EN', "Request a feature");
___('submenu_nobleme_feature', 'FR', "Quémander un feature");


// Submenu: Pages
___('submenu_pages_internet', 'EN', "Internet culture");
___('submenu_pages_internet', 'FR', "Culture internet");
___('submenu_pages_internet_index', 'EN', "21st century compendium");
___('submenu_pages_internet_index', 'FR', "Étude du 21ème siècle");
___('submenu_pages_internet_pages', 'EN', "Meme encyclopedia");
___('submenu_pages_internet_pages', 'FR', "Enyclopédie des memes");
___('submenu_pages_internet_dictionary', 'EN', "Slang dictionnary");
___('submenu_pages_internet_dictionary', 'FR', "Dictionnaire d'argot");
___('submenu_pages_internet_culture', 'EN', "Sociocultural guide");
___('submenu_pages_internet_culture', 'FR', "Guide socioculturel");
___('submenu_pages_internet_random', 'EN', "Random page");
___('submenu_pages_internet_random', 'FR', "Page au hasard");

___('submenu_pages_politics', 'EN', "Politics");
___('submenu_pages_politics', 'FR', "Politique");
___('submenu_pages_politics_manifesto', 'EN', "Contrapositionist manifesto");
___('submenu_pages_politics_manifesto', 'FR', "Manifeste contrapositioniste");
___('submenu_pages_politics_documentation', 'EN', "Systemic violence");
___('submenu_pages_politics_documentation', 'FR', "Violence systémique");
___('submenu_pages_politics_join', 'EN', "Join the movement");
___('submenu_pages_politics_join', 'FR', "Rejoindre le mouvement");


// Submenu: Social
___('submenu_social_irc', 'EN', "IRC chat server");
___('submenu_social_irc', 'FR', "Serveur de chat IRC");
___('submenu_social_irc_intro', 'EN', "What is IRC");
___('submenu_social_irc_intro', 'FR', "Qu'est-ce que IRC");
___('submenu_social_irc_browser', 'EN', "Chat from your browser");
___('submenu_social_irc_browser', 'FR', "Chat depuis le navigateur");
___('submenu_social_irc_client', 'EN', "Using an IRC client");
___('submenu_social_irc_client', 'FR', "Utiliser un client IRC");
___('submenu_social_irc_channels', 'EN', "Channel list");
___('submenu_social_irc_channels', 'FR', "Liste des canaux");

___('submenu_social_meetups', 'EN', "Real life meetups");
___('submenu_social_meetups', 'FR', "Rencontres IRL");
___('submenu_social_meetups_list', 'EN', "List of meetups");
___('submenu_social_meetups_list', 'FR', "Liste des IRL");
___('submenu_social_meetups_stats', 'EN', "Meetup statistics");
___('submenu_social_meetups_stats', 'FR', "Statistiques des IRL");

___('submenu_social_quotes', 'EN', "Quotes");
___('submenu_social_quotes', 'FR', "Citations");
___('submenu_social_quotes_list', 'EN', "Quote database");
___('submenu_social_quotes_list', 'FR', "Paroles de NoBlemeux");
___('submenu_social_quotes_random', 'EN', "Random quote");
___('submenu_social_quotes_random', 'FR', "Citation au hasard");
___('submenu_social_quotes_stats', 'EN', "Quote statistics");
___('submenu_social_quotes_stats', 'FR', "Statistiques des citations");
___('submenu_social_quotes_submit', 'EN', "Submit a new quote");
___('submenu_social_quotes_submit', 'FR', "Proposer une citation");

___('submenu_social_games', 'EN', "Video games");
___('submenu_social_games', 'FR', "Jeux vidéo");
___('submenu_social_games_minecraft', 'EN', "Serveur Minecraft");
___('submenu_social_games_minecraft', 'FR', "Minecraft server");
___('submenu_social_games_nbrpg', 'EN', "Archive: NoBlemeRPG");
___('submenu_social_games_nbrpg', 'FR', "Archive : NoBlemeRPG");
___('submenu_social_games_nrm', 'EN', "Archive: NRM Online");
___('submenu_social_games_nrm', 'FR', "Archive : NRM Online");


// Submenu: Account
___('submenu_user_pms', 'EN', "Private messages");
___('submenu_user_pms', 'FR', "Messages privés");
___('submenu_user_pms_inbox', 'EN', "Message inbox");
___('submenu_user_pms_inbox', 'FR', "Boîte de réception");
___('submenu_user_pms_outbox', 'EN', "Sent messages");
___('submenu_user_pms_outbox', 'FR', "Messages envoyés");
___('submenu_user_pms_write', 'EN', "Write a message");
___('submenu_user_pms_write', 'FR', "Écrire un message");

___('submenu_user_profile', 'EN', "Public profile");
___('submenu_user_profile', 'FR', "Profil public");
___('submenu_user_profile_self', 'EN', "My public profile");
___('submenu_user_profile_self', 'FR', "Voir mon profil public");
___('submenu_user_profile_edit', 'EN', "Edit my profile");
___('submenu_user_profile_edit', 'FR', "Modifier mon profil");

___('submenu_user_settings', 'EN', "Website settings");
___('submenu_user_settings', 'FR', "Réglages du site");
___('submenu_user_settings_privacy', 'EN', "Privacy options");
___('submenu_user_settings_privacy', 'FR', "Options de vie privée");
___('submenu_user_settings_nsfw', 'EN', "Adult content options");
___('submenu_user_settings_nsfw', 'FR', "Options de vulgarité");

___('submenu_user_edit', 'EN', "Account settings");
___('submenu_user_edit', 'FR', "Réglages du compte");
___('submenu_user_edit_email', 'EN', "Change my e-mail");
___('submenu_user_edit_email', 'FR', "Changer d'e-mail");
___('submenu_user_edit_password', 'EN', "Change my password");
___('submenu_user_edit_password', 'FR', "Changer de mot de passe");
___('submenu_user_edit_nickname', 'EN', "Change my nickname");
___('submenu_user_edit_nickname', 'FR', "Changer de pseudonyme");
___('submenu_user_edit_delete', 'EN', "Delete my account");
___('submenu_user_edit_delete', 'FR', "Supprimer mon compte");

___('submenu_user_logout_logout', 'EN', "Log out of this account");
___('submenu_user_logout_logout', 'FR', "Se déconnecter du compte");

___('submenu_user_logged_out', 'EN', "You are not logged in");
___('submenu_user_logged_out', 'FR', "Vous n'êtes pas connecté");


// Submenu: Admin
___('submenu_admin_activity', 'EN', "Mod tools");
___('submenu_admin_activity', 'FR', "Outils de modération");
___('submenu_admin_modlogs', 'EN', "Moderation logs");
___('submenu_admin_modlogs', 'FR', "Logs de modération");

___('submenu_admin_users', 'EN', "User management");
___('submenu_admin_users', 'FR', "Gestion des membres");
___('submenu_admin_banned', 'EN', "Banned users list");
___('submenu_admin_banned', 'FR', "Pilori des bannis");
___('submenu_admin_nickname', 'EN', "Change a nickname");
___('submenu_admin_nickname', 'FR', "Modifier un pseudonyme");
___('submenu_admin_password', 'EN', "Change a password");
___('submenu_admin_password', 'FR', "Modifier un mot de passe");
___('submenu_admin_rights', 'EN', "User access rights");
___('submenu_admin_rights', 'FR', "Changer les permissions");

___('submenu_admin_stats', 'EN', "Stats");
___('submenu_admin_stats', 'FR', "Statistiques");
___('submenu_admin_pageviews', 'EN', "Pageviews");
___('submenu_admin_pageviews', 'FR', "Popularité des pages");
___('submenu_admin_doppelganger', 'EN', "Doppelgänger");
___('submenu_admin_doppelganger', 'FR', "Doppelgänger");

___('submenu_admin_website', 'EN', "Admin tools");
___('submenu_admin_website', 'FR', "Outils admin");
___('submenu_admin_ircbot', 'EN', "IRC bot management");
___('submenu_admin_ircbot', 'FR', "Gestion du bot IRC");
___('submenu_admin_close', 'EN', "Close the website");
___('submenu_admin_close', 'FR', "Fermer le site");
___('submenu_admin_sql', 'EN', "Run SQL queries");
___('submenu_admin_sql', 'FR', "Jouer les requêtes SQL");
___('submenu_admin_release', 'EN', "Version numbers");
___('submenu_admin_release', 'FR', "Numéros de version");
___('submenu_admin_scheduler', 'EN', "Scheduled tasks");
___('submenu_admin_scheduler', 'FR', "Tâches planifiées");

___('submenu_admin_doc', 'EN', "Dev docs");
___('submenu_admin_doc', 'FR', "Docs dev");
___('submenu_admin_doc_snippets', 'EN', "Code snippets");
___('submenu_admin_doc_snippets', 'FR', "Modèles de code");
___('submenu_admin_doc_css', 'EN', "CSS palette");
___('submenu_admin_doc_css', 'FR', "Palette CSS");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Footer

___('footer_pageviews', 'EN', "This page has been seen ");
___('footer_pageviews', 'FR', "Cette page a été consultée ");

___('footer_loadtime', 'EN', "Page loaded in ");
___('footer_loadtime', 'FR', "Page chargée en ");

___('footer_version', 'EN', 'Version {{1}}, build {{2}} - {{3}}');
___('footer_version', 'FR', 'Version {{1}}, build {{2}} - {{3}}');

___('footer_legal', 'EN', "Legal notices and privacy policy");
___('footer_legal', 'FR', "Mentions légales &amp; confidentialité");

___('footer_copyright', 'EN', "&copy; NoBleme.com : 2005 - {{1}}");
___('footer_copyright', 'FR', "&copy; NoBleme.com : 2005 - {{1}}");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       LOGIN                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page title
___('login_form_title', 'EN', "Login");
___('login_form_title', 'FR', "Connexion");


// Login form
___('login_form_form_remember', 'EN', "Stay logged in");
___('login_form_form_remember', 'FR', "Rester connecté");
___('login_form_form_register', 'EN', 'REGISTER');
___('login_form_form_register', 'FR', 'INSCRIPTION');


// Error messages
___('login_form_error_no_nickname', 'EN', "You must specify a nickname");
___('login_form_error_no_nickname', 'FR', "Vous devez saisir un pseudonyme");
___('login_form_error_no_password', 'EN', "You must specify a password");
___('login_form_error_no_password', 'FR', "Vous devez saisir un mot de passe");
___('login_form_error_bruteforce', 'EN', "You are trying to log in too often, please wait 10 minutes before your next attempt");
___('login_form_error_bruteforce', 'FR', "Trop de tentatives de connexion, merci d'attendre 10 minutes avant d'essayer de nouveau");
___('login_form_error_wrong_user', 'EN', "This nickname does not exist on the website");
___('login_form_error_wrong_user', 'FR', "Ce pseudonyme n'existe pas sur le site");
___('login_form_error_forgotten_user', 'EN', "Forgot your nickname?");
___('login_form_error_forgotten_user', 'FR', "Vous avez oublié votre pseudonyme ?");
___('login_form_error_wrong_password', 'EN', "Incorrect password for this nickname");
___('login_form_error_wrong_password', 'FR', "Mauvais mot de passe pour ce pseudonyme");
___('login_form_error_forgotten_password', 'EN', "Forgot your password?");
___('login_form_error_forgotten_password', 'FR', "Mot de passe oublié ?");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  CODE OF CONDUCT                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

___('coc', 'EN', <<<EOT
<p class="padding_bot">
  NoBleme is a small community with a laid back mood. There is no age restriction, and very few restrictions on content. However, in order to ensure all can coexist peacefully, there is a minimalistic code of conduct that everyone should respect, which you will find below:
</p>
<ul>
  <li>
    Obviously, illegal content will immediately be sent to the police. Don't play with fire.
  </li>
  <li>
    Since NoBleme has no age restriction pornography or highly suggestive content is forbidden.
  </li>
  <li>
    All gore images and other disgusting things are also forbidden. NoBleme is not the right place for that.
  </li>
  <li>
    Any form of hate speech, discrimination, or incitation to violence will be met with an immediate ban.
  </li>
  <li>
    If you have to argue with someone about a tense situation, do it privately or risk both being banned.
  </li>
  <li>
    Trolls and purposeful agitators will be banned without a warning if they try to test boundaries.
  </li>
</ul>
<p>
We know tensions always tend to appear in shared spaces containing varied personalities and opinions. However, if your behavior or your vocabulary prevent other people from having a good time, then we will have to exclude you. Let's all be respectful of others, we'll collectively benefit from it.
</p>
EOT
);

___('coc', 'FR', <<<EOT
<p class="padding_bot">
  NoBleme est une petite communauté à l'ambiance décontractée. Il n'y a pas de restriction d'âge, et peu de restrictions de contenu. Il y a juste un code de conduite minimaliste à respecter afin de tous cohabiter paisiblement, que vous trouverez ci-dessous :
</p>
<ul>
  <li>
    Tout contenu illégal sera immédiatement envoyé à la police. Ne jouez pas avec le feu.
  </li>
  <li>
    Comme NoBleme n'a pas de restriction d'âge, la pornographie et la nudité gratuite sont interdits.
  </li>
  <li>
    Les images gores ou dégueulasses sont également interdites. NoBleme n'est pas le lieu pour ça.
  </li>
  <li>
    L'incitation à la haine et les propos discriminatoires auront pour réponse un bannissement immédiat.
  </li>
  <li>
    Les situations tendues doivent se régler en privé avant de trop escalader, au risque de se faire bannir.
  </li>
  <li>
  Les trolls et autres provocateurs gratuits pourront être bannis sans sommation s'ils abusent trop.
  </li>
</ul>
<p>
Il est normal que des tensions apparaissent dans des lieux où des personnalités et opinions variées coexistent. Toutefois, si votre comportement ou votre vocabulaire empêchent d'autres personnes de passer un bon moment, nous devrons vous exclure. Soyons bienveillants, et nous en bénéficierons tous.
</p>
EOT
);