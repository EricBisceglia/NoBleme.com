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
 *
 * @return  string                          The translated string, or an empty string if no translation was found.
 */

function __($string, $amount=null, $spaces_before=0, $spaces_after=0)
{
  // If there are no global translations, return nothing
  if(!isset($GLOBALS['translations']))
    return '';

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

  // If required, return the plural version of the string if it exists (plural translation names ends in a '+')
  if(!is_null($amount) && is_int($amount) && $amount != 1 && isset($GLOBALS['translations'][$string.'+']))
    return $spaces_before.$GLOBALS['translations'][$string.'+'].$spaces_after;

  // Otherwise, return the string (or nothing if it does not exist)
  return isset($GLOBALS['translations'][$string]) ? $spaces_before.$GLOBALS['translations'][$string].$spaces_after : '';
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

___('version', 'EN', 'version');
___('version', 'FR', 'version');

___('build', 'EN', 'build');
___('build', 'FR', 'build');



/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                COMMON TRANSLATIONS                                                */
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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Footer

___('footer_pageviews', 'EN', "This page has been seen ");
___('footer_pageviews', 'FR', "Cette page a été consultée ");

___('footer_loadtime', 'EN', "Page loaded in ");
___('footer_loadtime', 'FR', "Page chargée en ");

___('footer_version_prefix', 'EN', '-');
___('footer_version_prefix', 'FR', 'du');

___('footer_shorturl', 'EN', "Shorter link alternative");
___('footer_shorturl', 'FR', "Lien court vers cette page");

___('footer_legal', 'EN', "Legal notices and privacy policy");
___('footer_legal', 'FR', "Mentions légales &amp; confidentialité");
