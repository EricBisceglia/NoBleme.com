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
  if(!is_null($amount) && is_int($amount) && $amount != 1 && isset($GLOBALS['translations'][$string.'+']))
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