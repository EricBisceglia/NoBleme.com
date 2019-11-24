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

  // Replace URLs if needed, using a regex that looks for {{link|href|text|style|internal|path}} (last 3 are optional)
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

function __link($href, $text, $style="bold", $is_internal=true, $path="./../../")
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
___('nbcodes_video_hidden',       'EN', "This video is hidden (<a href=\"{{1}}pages/users/privacy\">privacy options</a>)");
___('nbcodes_video_hidden',       'FR', "Cette vidéo est masquée (<a href=\"{{1}}pages/users/privacy\">options de vie privée</a>)");
___('nbcodes_video_hidden_small', 'EN', "Video hidden (<a href=\"{{1}}pages/users/privacy\">privacy options</a>)");
___('nbcodes_video_hidden_small', 'FR', "Vidéo masquée (<a href=\"{{1}}pages/users/privacy\">options de vie privée</a>)");

___('nbcodes_trends_hidden', 'EN', "This Google trends graph is hidden (<a href=\"{{1}}pages/users/privacy\">privacy options</a>)");
___('nbcodes_trends_hidden', 'FR', "Ce graphe Google trends est masqué (<a href=\"{{1}}pages/users/privacy\">options de vie privée</a>)");




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

___('header_status_logged_in', 'EN', "You are logged in as {{1}}. Click here to manage your account or edit your profile.");
___('header_status_logged_in', 'FR', "Vous êtes connecté en tant que {{1}}. Cliquez ici pour gérer votre compte ou modifier votre profil.");
___('header_status_logged_in_short', 'EN', "{{1}}: Manage my account.");
___('header_status_logged_in_short', 'FR', "{{1}} : Gérer mon compte");

___('header_status_login', 'EN', "You are not logged in: Click here to login or register.");
___('header_status_login', 'FR', "Vous n'êtes pas connecté: Cliquez ici pour vous identifier ou vous enregistrer.");
___('header_status_login_short', 'EN', "Logged out: Click here to login or register.");
___('header_status_login_short', 'FR', "Cliquez ici pour vous identifier ou vous enregistrer.");

___('header_status_logout', 'EN', "Log out");
___('header_status_logout', 'FR', "Déconnexion");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global menus

// Top menu
___('menu_top_nobleme', 'EN', "NOBLEME");
___('menu_top_nobleme', 'FR', "NOBLEME");
___('menu_top_community', 'EN', "COMMUNITY");
___('menu_top_community', 'FR', "COMMUNAUTÉ");
___('menu_top_pages', 'EN', "PAGES");
___('menu_top_pages', 'FR', "PAGES");
___('menu_top_admin', 'EN', "ADMIN");
___('menu_top_admin', 'FR', "ADMIN");


// Side menu actions
___('menu_side_display', 'EN', 'Show the side menu');
___('menu_side_display', 'FR', 'Afficher le menu latéral');
___('menu_side_hide', 'EN', 'Hide the side menu');
___('menu_side_hide', 'FR', 'Masquer le menu latéral');


// Side menu: NoBleme
___('menu_side_nobleme_homepage', 'EN', "Home page");
___('menu_side_nobleme_homepage', 'FR', "Page d'accueil");
___('menu_side_nobleme_activity', 'EN', "Recent activity");
___('menu_side_nobleme_activity', 'FR', "Activité récente");

___('menu_side_nobleme_documentation', 'EN', "Documentation");
___('menu_side_nobleme_documentation', 'FR', "Documentation");
___('menu_side_nobleme_what_is', 'EN', "What is NoBleme");
___('menu_side_nobleme_what_is', 'FR', "Qu'est-ce que NoBleme");
___('menu_side_nobleme_coc', 'EN', "Code of conduct");
___('menu_side_nobleme_coc', 'FR', "Code de conduite");
___('menu_side_nobleme_api', 'EN', "Public API");
___('menu_side_nobleme_api', 'FR', "API publique");
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
___('menu_side_nobleme_contact_admin', 'EN', "Contact the admins");
___('menu_side_nobleme_contact_admin', 'FR', "Contacter l'administration");
___('menu_side_nobleme_privacy', 'EN', "Privacy policy");
___('menu_side_nobleme_privacy', 'FR', "Politique de confidentialité");
___('menu_side_nobleme_personal_data', 'EN', "Your personal data");
___('menu_side_nobleme_personal_data', 'FR', "Vos données personnelles");
___('menu_side_nobleme_forget_me', 'EN', "Right to be forgotten");
___('menu_side_nobleme_forget_me', 'FR', "Droit à l'oubli");


// Side menu: Community
___('menu_side_community_irc', 'EN', "IRC chat server");
___('menu_side_community_irc', 'FR', "Serveur de chat IRC");
___('menu_side_community_irc_intro', 'EN', "What is IRC");
___('menu_side_community_irc_intro', 'FR', "Qu'est-ce que IRC");
___('menu_side_community_irc_browser', 'EN', "Chat from your browser");
___('menu_side_community_irc_browser', 'FR', "Chat depuis le navigateur");
___('menu_side_community_irc_client', 'EN', "Using an IRC client");
___('menu_side_community_irc_client', 'FR', "Utiliser un client IRC");
___('menu_side_community_irc_channels', 'EN', "Channel list");
___('menu_side_community_irc_channels', 'FR', "Liste des canaux");

___('menu_side_community_users', 'EN', "Users");
___('menu_side_community_users', 'FR', "Membres");
___('menu_side_community_online', 'EN', "Who's online");
___('menu_side_community_online', 'FR', "Qui est en ligne");
___('menu_side_community_userlist', 'EN', "Registered user list");
___('menu_side_community_userlist', 'FR', "Liste des membres");
___('menu_side_community_staff', 'EN', "Administrative team");
___('menu_side_community_staff', 'FR', "Équipe administrative");
___('menu_side_community_birthdays', 'EN', "User birthdays");
___('menu_side_community_birthdays', 'FR', "Anniversaires");

___('menu_side_community_meetups', 'EN', "Real life meetups");
___('menu_side_community_meetups', 'FR', "Rencontres IRL");
___('menu_side_community_meetups_list', 'EN', "List of meetups");
___('menu_side_community_meetups_list', 'FR', "Liste des IRL");

___('menu_side_community_quotes', 'EN', "Quotes");
___('menu_side_community_quotes', 'FR', "Citations");
___('menu_side_community_quotes_list', 'EN', "Quote database");
___('menu_side_community_quotes_list', 'FR', "Paroles de NoBlemeux");
___('menu_side_community_quotes_random', 'EN', "Random quote");
___('menu_side_community_quotes_random', 'FR', "Citation au hasard");
___('menu_side_community_quotes_submit', 'EN', "Submit a new quote");
___('menu_side_community_quotes_submit', 'FR', "Proposer une citation");

___('menu_side_community_writers', 'EN', "Writer's corner");
___('menu_side_community_writers', 'FR', "Coin des écrivains");
___('menu_side_community_writers_writings', 'EN', "NoBleme's writings");
___('menu_side_community_writers_writings', 'FR', "Écrits de NoBlemeux");
___('menu_side_community_writers_publish', 'EN', "Publish a writing");
___('menu_side_community_writers_publish', 'FR', "Publier un écrit");
___('menu_side_community_writers_contests', 'EN', "Writing contests");
___('menu_side_community_writers_contests', 'FR', "Concours d'écriture");


// Side menu: Pages
___('menu_side_pages_internet', 'EN', "Internet encyclopedia");
___('menu_side_pages_internet', 'FR', "Encyclopédie du web");
___('menu_side_pages_internet_index', 'EN', "Internet culture guide");
___('menu_side_pages_internet_index', 'FR', "Guide de la culture web");
___('menu_side_pages_internet_pages', 'EN', "Meme encyclopedia");
___('menu_side_pages_internet_pages', 'FR', "Enyclopédie des memes");
___('menu_side_pages_internet_dictionary', 'EN', "Slang dictionnary");
___('menu_side_pages_internet_dictionary', 'FR', "Dictionnaire d'argot");
___('menu_side_pages_internet_culture', 'EN', "Society and culture");
___('menu_side_pages_internet_culture', 'FR', "Société et culture");
___('menu_side_pages_internet_random', 'EN', "Random page");
___('menu_side_pages_internet_random', 'FR', "Page au hasard");

___('menu_side_pages_archives', 'EN', "Archives");
___('menu_side_pages_archives', 'FR', "Archives");
___('menu_side_pages_nbrpg', 'EN', "NoBlemeRPG");
___('menu_side_pages_nbrpg', 'FR', "NoBlemeRPG");
___('menu_side_pages_nbrpg_sessions', 'EN', "Archived sessions");
___('menu_side_pages_nbrpg_sessions', 'FR', "Sessions archivées");
___('menu_side_pages_nrm', 'EN', "NRM Online");
___('menu_side_pages_nrm', 'FR', "NRM Online");
___('menu_side_pages_nrm_champions', 'EN', "Champions of the past");
___('menu_side_pages_nrm_champions', 'FR', "Champions du passé");


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
___('menu_side_admin_nickname', 'EN', "Change a nickname");
___('menu_side_admin_nickname', 'FR', "Modifier un pseudonyme");
___('menu_side_admin_password', 'EN', "Change a password");
___('menu_side_admin_password', 'FR', "Modifier un mot de passe");
___('menu_side_admin_banned', 'EN', "Banned users");
___('menu_side_admin_banned', 'FR', "Pilori des bannis");
___('menu_side_admin_rights', 'EN', "User access rights");
___('menu_side_admin_rights', 'FR', "Changer les permissions");

___('menu_side_admin_stats', 'EN', "Stats");
___('menu_side_admin_stats', 'FR', "Statistiques");
___('menu_side_admin_pageviews', 'EN', "Pageviews");
___('menu_side_admin_pageviews', 'FR', "Popularité des pages");
___('menu_side_admin_doppelganger', 'EN', "Doppelgänger");
___('menu_side_admin_doppelganger', 'FR', "Doppelgänger");

___('menu_side_admin_website', 'EN', "Website management");
___('menu_side_admin_website', 'FR', "Gestion du site");
___('menu_side_admin_ircbot', 'EN', "IRC bot management");
___('menu_side_admin_ircbot', 'FR', "Gestion du bot IRC");
___('menu_side_admin_close', 'EN', "Close the website");
___('menu_side_admin_close', 'FR', "Fermer le site");
___('menu_side_admin_sql', 'EN', "Run SQL queries");
___('menu_side_admin_sql', 'FR', "Jouer les requêtes SQL");
___('menu_side_admin_release', 'EN', "Version numbers");
___('menu_side_admin_release', 'FR', "Numéros de version");
___('menu_side_admin_scheduler', 'EN', "Scheduled tasks");
___('menu_side_admin_scheduler', 'FR', "Tâches planifiées");

___('menu_side_admin_doc', 'EN', "Dev documentation");
___('menu_side_admin_doc', 'FR', "Documentation dev");
___('menu_side_admin_doc_snippets', 'EN', "Code snippets");
___('menu_side_admin_doc_snippets', 'FR', "Modèles de code");
___('menu_side_admin_doc_css', 'EN', "CSS palette");
___('menu_side_admin_doc_css', 'FR', "Palette CSS");




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
/*                                                  CODE OF CONDUCT                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

___('coc', 'EN', <<<EOT
<p class="padding_bot">
  NoBleme is a small community with a laid back mood. There is no age restriction, and very few restrictions on content. However, in order to ensure all can coexist peacefully, there is a minimalistic code of conduct that everyone should respect, which you will find below:
</p>
<ul>
  <li>
    Obviously, <span class="bold">illegal content</span> will immediately be <span class="bold">sent to the police</span>. Don't play with fire.
  </li>
  <li>
    Since NoBleme has no age restriction <span class="bold">pornography or highly suggestive content is forbidden</span>.
  </li>
  <li>
    All <span class="bold">gore images</span> and other disgusting things are <span class="bold">also forbidden</span>. NoBleme is not the right place for that.
  </li>
  <li>
    Any form of <span class="bold">hate speech, discrimination, or incitation to violence</span> will be met with an <span class="bold">immediate ban</span>.
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
    Tout <span class="bold">contenu illégal</span> sera immédiatement <span class="bold">envoyé à la police</span>. Ne jouez pas avec le feu.
  </li>
  <li>
    Comme NoBleme n'a pas de restriction d'âge, <span class="bold">la pornographie et la nudité gratuite sont interdits</span>.
  </li>
  <li>
    Les <span class="bold">images gores</span> ou dégueulasses sont <span class="bold">également interdites</span>. NoBleme n'est pas le lieu pour ça.
  </li>
  <li>
  <span class="bold">L'incitation à la haine</span> et les <span class="bold">propos discriminatoires</span> auront pour réponse un <span class="bold">bannissement immédiat</span>.
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