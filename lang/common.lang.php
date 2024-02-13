<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


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
 * @param   string                $string         The string identifying the phrase to be translated.
 * @param   int|null  (OPTIONAL)  $amount         Amount of elements: 1 or null is singular, anything else is plural.
 * @param   int       (OPTIONAL)  $spaces_before  Number of spaces to insert before the translation.
 * @param   int       (OPTIONAL)  $spaces_after   Number of spaces to append to the end of the translation.
 * @param   array     (OPTIONAL)  $preset_values  An array of values to be included in the phrase.
 *
 * @return  string                              The translated string, or an empty string if no translation was found.
 */

function __(  string  $string                   ,
              ?int    $amount         = NULL    ,
              int     $spaces_before  = 0       ,
              int     $spaces_after   = 0       ,
              array   $preset_values  = array() ) : string
{
  // If there are no global translations, return nothing
  if(!isset($GLOBALS['translations']))
    return '';

  // If required, use the plural version of the string if it exists (plural translation names ends in a '+')
  if(!is_null($amount) && $amount !== 1 && isset($GLOBALS['translations'][$string.'+']))
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
  / {{link_popup|href|text}}        # Will open in a popup (target blank)
  / {{link++|href|text|style|path}} # Will always be an internal link
  / {{link+|href|text|style}}
  / {{link|href|text}}
  / {{external|href|text}}
  / {{external_popup|href|text}}    # Will open in a popup (target blank)
  */
  $returned_string = preg_replace('/\{\{link_popup\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", popup: true), $returned_string);
  $returned_string = preg_replace('/\{\{link\+\+\|(.*?)\|(.*?)\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", "$3", path: "$5"), $returned_string);
  $returned_string = preg_replace('/\{\{link\+\+\|(.*?)\|(.*?)\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", "$3", 0), $returned_string);
  $returned_string = preg_replace('/\{\{link\+\|(.*?)\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", "$3"), $returned_string);
  $returned_string = preg_replace('/\{\{link\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2"), $returned_string);
  $returned_string = preg_replace('/\{\{external\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", is_internal: false), $returned_string);
  $returned_string = preg_replace('/\{\{external_popup\|(.*?)\|(.*?)\}\}/is',__link("$1", "$2", is_internal: false, popup: true), $returned_string);

  /*
  / Replace tooltips if needed, using a regex that can work in either of the following ways:
  / {{tooltip+|title|tooltip|title_style|tooltip_style}}
  / {{tooltip|title|tooltip}}
  */
  $returned_string = preg_replace('/\{\{tooltip\+\|(.*?)\|(.*?)\|(.*?)\|(.*?)\}\}/is',__tooltip("$1", "$2", "$3", "$4"), $returned_string);
  $returned_string = preg_replace('/\{\{tooltip\|(.*?)\|(.*?)\}\}/is',__tooltip("$1", "$2"), $returned_string);

  // Prepare the spaces to prepend to the string
  if(is_int($spaces_before) && $spaces_before > 0)
    $spaces_before = ($spaces_before === 1) ? " " : str_repeat(" ", $spaces_before);
  else
    $spaces_before = '';

  // Prepare the spaces to append to the string
  if(is_int($spaces_after) && $spaces_after > 0)
    $spaces_after = ($spaces_after === 1) ? " " : str_repeat(" ", $spaces_after);
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

function ___( string  $name         ,
              string  $lang         ,
              string  $translation  ) : void
{
  // Only treat this if we are in the current language
  $current_lang = (!isset($_SESSION['lang'])) ? 'EN' : $_SESSION['lang'];
  if($current_lang !== $lang)
    return;

  // Check if a translation by this name already exists - if yes publicly humiliate the coder for their poor work :(
  if(isset($GLOBALS['translations'][$name]))
    exit(__('error_duplicate_translation').$name);

  // Create or overwrite an entry in the global translations array
  $GLOBALS['translations'][$name] = $translation;
}




 /**
 * Builds a link.
 *
 * @param   string  $href                     The destination of the link.
 * @param   string  $text                     The text to be displayed on the link.
 * @param   string  $style        (OPTIONAL)  The CSS style(s) to apply to the link.
 * @param   bool    $is_internal  (OPTIONAL)  Whether the link is internal (on the website) or external.
 * @param   string  $path         (OPTIONAL)  The path to the website's root (defaults to 2 folders from root).
 * @param   string  $onclick      (OPTIONAL)  A javascript option to trigger upon clicking the link.
 * @param   string  $onmouseover  (OPTIONAL)  A javascript option to trigger upon hovering over the link.
 * @param   string  $id           (OPTIONAL)  An ID to give the <a> element containing the link.
 * @param   bool    $popup        (OPTIONAL)  Opens the link in a new window.
 * @param   string  $confirm      (OPTIONAL)  A confirmation dialog that must be accepted before the link is followed.
 *
 * @return  string                            The link, ready for use.
 */

function __link(  string  $href                       ,
                  string  $text                       ,
                  string  $style        = "bold"      ,
                  bool    $is_internal  = true        ,
                  string  $path         = "./../../"  ,
                  string  $onclick      = ''          ,
                  string  $onmouseover  = ''          ,
                  string  $id           = ''          ,
                  bool    $popup        = false       ,
                  string  $confirm      = ''          ) : string
{
  // Prepare the style
  $class = ($style) ? " class=\"$style\"" : "";

  // Prepare the URL
  $url = ($is_internal) ? $path.$href : $href;
  $url = ($url)         ? "href=\"".$url."\"" : "";

  // Make it pop-up if needed
  $popup = ($popup) ? 'rel="noopener noreferrer" target="_blank"' : '';

  // Prepare the confirmation dialog
  $onclick = ($confirm) ? "return confirm('".$confirm."'); ".$onclick : $onclick;

  // Prepare the onclick
  $onclick = ($onclick) ? 'onclick="'.$onclick.'"' : '';

  // Prepare the onmouseover
  $onmouseover = ($onmouseover) ? 'onmouseover="'.$onmouseover.'"' : '';

  // Prepare the ID
  $id = ($id) ? 'id="'.$id.'"' : '';

  // Return the built link
  return "<a $class $url $popup $onclick $onmouseover $id>$text</a>";
}



 /**
 * Builds an icon.
 *
 * @param   string  $icon                     The icon's name.
 * @param   bool    $is_small     (OPTIONAL)  Use the small version of an icon instead of the full version.
 * @param   string  $href         (OPTIONAL)  The URL the icon links to.
 * @param   bool    $is_internal  (OPTIONAL)  Whether the link is internal (on the website) or external.
 * @param   string  $class        (OPTIONAL)  Extra css classes to apply to the icon.
 * @param   string  $alt          (OPTIONAL)  The alt text which will be displayed if the image can't be found.
 * @param   string  $title        (OPTIONAL)  The hover text which shows up when the pointer rests over the image.
 * @param   string  $title_case   (OPTIONAL)  Change the case of the icon's hover title.
 * @param   bool    $use_dark     (OPTIONAL)  Whether to use the dark version of the icon instead of user settings.
 * @param   bool    $use_light    (OPTIONAL)  Whether to use the light version of the icon instead of user settings.
 * @param   string  $identifier   (OPTIONAL)  Gives a html id to the element.
 * @param   string  $path         (OPTIONAL)  The path to the website's root (defaults to 2 folders from root).
 * @param   string  $onclick      (OPTIONAL)  A javascript option to trigger upon clicking the link.
 * @param   bool    $popup        (OPTIONAL)  Opens the link in a new window.
 * @param   string  $confirm      (OPTIONAL)  A confirmation dialog that must be accepted before a link is followed.
 *
 * @return  string                            The icon, ready for use.
 */

function __icon(  string  $icon                                   ,
                  bool    $is_small     = false                   ,
                  string  $href         = ''                      ,
                  bool    $is_internal  = true                    ,
                  string  $class        = 'valign_middle pointer' ,
                  string  $alt          = 'X'                     ,
                  string  $title        = ' '                     ,
                  string  $title_case   = ''                      ,
                  bool    $use_dark     = false                   ,
                  bool    $use_light    = false                   ,
                  string  $identifier   = ''                      ,
                  string  $path         = "./../../"              ,
                  string  $onclick      = ''                      ,
                  bool    $popup        = false                   ,
                  string  $confirm      = ''                      ) : string
{
  // Prepare the URL
  $url = ($is_internal) ? $path.$href : $href;
  $url = ($url)         ? "href=\"".$url."\"" : "";

  // Make the link pop-up if needed
  $popup = ($popup) ? 'rel="noopener noreferrer" target="_blank"' : '';

  // Prepare the identifier if needed
  $id = ($identifier) ? ' id="'.$identifier.'"' : '';

  // Prepare the style
  $style  = ($is_small) ? 'smallicon' : 'icon';
  $style .= ($class)    ? ' '.$class : '';
  $class  = 'class="'.$style.'"';

  // Prepare the confirmation dialog
  $onclick = ($confirm) ? "return confirm('".$confirm."'); ".$onclick : $onclick;

  // Prepare the onclick
  $onclick = ($onclick) ? 'onclick="'.$onclick.'"' : '';

  // Prepare the image path
  $icon = ($is_small) ? $icon.'_small' : $icon;
  $icon = (!$use_light && (user_get_mode() === 'light' || $use_dark)) ? $icon.'_dark' : $icon;
  $src  = 'src="'.$path.'img/icons/'.$icon.'.svg"';

  // Prepare the alt text and title
  $alt = 'alt="'.$alt.'"';

  // Prepare the title
  $title  = ($title_case) ? string_change_case($title, $title_case) : $title;
  $title  = 'title="'.$title.'"';

  // Return the assembled icon
  if($href)
    return "<a class=\"noglow\" $url $popup><img $id $class $src $alt $title $onclick></a>";
  else
    return "<img $id $class $src $alt $title $onclick>";
}




 /**
 * Builds an inline tooltip.
 *
 * @param   string  $title                      The element that triggers the tooltip.
 * @param   string  $tooltip_body               The tooltip's body.
 * @param   string  $title_style    (OPTIONAL)  The CSS style(s) to apply to the tooltip's triggering element.
 * @param   string  $tooltip_style  (OPTIONAL)  CSS style(s) to apply to the tooltip's body.
 *
 * @return  string                              The tooltip, ready for use.
 */

function __tooltip( string  $title                      ,
                    string  $tooltip_body               ,
                    string  $title_style    = "bold"    ,
                    string  $tooltip_style  = "notbold" ) : string
{
  // Return the assembled tooltip
  return "<span class=\"tooltip_container ".$title_style."\">".$title."<span class=\"tooltip ".$tooltip_style."\">".$tooltip_body."</span></span>";
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                SHARED TRANSLATIONS                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Website name
___('nobleme',      'EN', "NoBleme");
___('nobleme',      'FR', "NoBleme");
___('nobleme.com',  'EN', "NoBleme.com");
___('nobleme.com',  'FR', "NoBleme.com");


// Punctuation
___(':', 'EN', ":");
___(':', 'FR', " :");


// Buttons and labels
___('add',        'EN', "add");
___('add',        'FR', "créer");
___('calendar',   'EN', "calendar");
___('calendar',   'FR', "calendrier");
___('clock',      'EN', "clock");
___('clock',      'FR', "horloge");
___('confirm',    'EN', "confirm");
___('confirm',    'FR', "confirmer");
___('copy',       'EN', "copy");
___('copy',       'FR', "copier");
___('delete',     'EN', "delete");
___('delete',     'FR', "supprimer");
___('done',       'EN', "done");
___('done',       'FR', "fini");
___('duplicate',  'EN', "duplicate");
___('duplicate',  'FR', "dupliquer");
___('details',    'EN', "details");
___('details',    'FR', "détails");
___('edit',       'EN', "edit");
___('edit',       'FR', "modifier");
___('graph',      'EN', "graph");
___('graph',      'FR', "graphe");
___('help',       'EN', "help");
___('help',       'FR', "aide");
___('info',       'EN', "info");
___('info',       'FR', "info");
___('maximize',   'EN', "maximize");
___('maximize',   'FR', "agrandir");
___('minimize',   'EN', "minimize");
___('minimize',   'FR', "réduire");
___('mode_dark',  'EN', "dark mode");
___('mode_dark',  'FR', "mode sombre");
___('mode_light', 'EN', "light mode");
___('mode_light', 'FR', "mode clair");
___('modify',     'EN', "modify");
___('modify',     'FR', "modifier");
___('more',       'EN', "more");
___('more',       'FR', "plus");
___('preview',    'EN', "preview");
___('preview',    'FR', "prévisualiser");
___('preview_2',  'EN', "preview");
___('preview_2',  'FR', "prévisualisation");
___('refresh',    'EN', "refresh");
___('refresh',    'FR', "recharger");
___('rss',        'EN', "RSS feed");
___('rss',        'FR', "flux RSS");
___('reset',      'EN', "reset");
___('reset',      'FR', "ràz");
___('reason',     'EN', "reason");
___('reason',     'FR', "raison");
___('settings',   'EN', "settings");
___('settings',   'FR', "réglages");
___('star',       'EN', "star");
___('star',       'FR', "étoile");
___('stats',      'EN', "stats");
___('stats',      'FR', "stats");
___('statistics', 'EN', "statistics");
___('statistics', 'FR', "statistiques");
___('submit',     'EN', "submit");
___('submit',     'FR', "envoyer");
___('undelete',   'EN', "undelete");
___('undelete',   'FR', "restaurer");
___('upload',     'EN', "upload");
___('upload',     'FR', "téléverser");
___('warning',    'EN', "warning");
___('warning',    'FR', "avertissement");


// Common words
___('bilingual',    'EN', "bilingual");
___('bilingual',    'FR', "bilingue");
___('birthday',     'EN', "birthday");
___('birthday',     'FR', "anniversaire");
___('category',     'EN', "category");
___('category',     'FR', "catégorie");
___('category+',    'EN', "categories");
___('category+',    'FR', "catégories");
___('closed',       'EN', "closed");
___('closed',       'FR', "fermé");
___('contents',     'EN', "contents");
___('contents',     'FR', "contenu");
___('created',      'EN', "created");
___('created',      'FR', "crée");
___('description',  'EN', "description");
___('description',  'FR', "description");
___('en',           'EN', "EN");
___('en',           'FR', "EN");
___('english',      'EN', "english");
___('english',      'FR', "anglais");
___('fr',           'EN', "FR");
___('fr',           'FR', "FR");
___('french',       'EN', "french");
___('french',       'FR', "français");
___('lang.',        'EN', "lang.");
___('lang.',        'FR', "lang.");
___('language',     'EN', "language");
___('language',     'FR', "langue");
___('language+',    'EN', "languages");
___('language+',    'FR', "langues");
___('link+',        'EN', "links");
___('link+',        'FR', "liens");
___('location',     'EN', "location");
___('location',     'FR', "lieu");
___('no',           'EN', "no");
___('no',           'FR', "non");
___('none',         'EN', "none");
___('none',         'FR', "aucun");
___('none_f',       'EN', "none");
___('none_f',       'FR', "aucune");
___('opened',       'EN', "opened");
___('opened',       'FR', "ouvert");
___('order',        'EN', "order");
___('order',        'FR', "ordre");
___('page',         'EN', "page");
___('page',         'FR', "page");
___('published',    'EN', "published");
___('published',    'FR', "publié");
___('sent',         'EN', "sent");
___('sent',         'FR', "envoyé");
___('sent+',        'EN', "sent");
___('sent+',        'FR', "envoyés");
___('text',         'EN', "text");
___('text',         'FR', "texte");
___('theme',        'EN', "theme");
___('theme',        'FR', "thème");
___('the',          'EN', "the");
___('the',          'FR', "le");
___('title',        'EN', "title");
___('title',        'FR', "titre");
___('view',         'EN', "view");
___('view',         'FR', "vue");
___('view+',        'EN', "views");
___('view+',        'FR', "vues");
___('with',         'EN', "with");
___('with',         'FR', "avec");
___('yes',          'EN', "yes");
___('yes',          'FR', "oui");


// Common actions
___('act',        'EN', "act.");
___('act',        'FR', "act.");
___('action',     'EN', "action");
___('action+',    'EN', "actions");
___('action',     'FR', "action");
___('action+',    'FR', "actions");
___('close_form', 'EN', "close this form");
___('close_form', 'FR', "fermer ce formulaire");
___('restore',    'EN', "restore");
___('restore',    'FR', "restaurer");
___('search',     'EN', "search");
___('search',     'FR', "chercher");
___('search2',    'EN', "search");
___('search2',    'FR', "recherche");
___('sort',       'EN', "sort");
___('sort',       'FR', "trier");
___('message',    'EN', "message");
___('message',    'FR', "message");


// Common technical terms
___('error',    'EN', "error");
___('error',    'FR', "erreur");
___('error+',   'EN', "errors");
___('error+',   'FR', "erreurs");
___('id',       'EN', "ID");
___('id',       'FR', "ID");
___('option',   'EN', "option");
___('option+',  'EN', "options");
___('option',   'FR', "option");
___('option+',  'FR', "options");
___('query',    'EN', "query");
___('query+',   'EN', "queries");
___('query',    'FR', "requête");
___('query+',   'FR', "requêtes");
___('type',     'EN', "type");
___('type',     'FR', "type");
___('version',  'EN', "version");
___('version',  'FR', "version");


// Common time and quantity related terms
___('all',          'EN', "All");
___('all',          'FR', "Tous");
___('date',         'EN', "date");
___('date',         'FR', "date");
___('at_date',      'EN', "at");
___('at_date',      'FR', "à");
___('day',          'EN', "day");
___('day+',         'EN', "days");
___('day',          'FR', "jour");
___('day+',         'FR', "jours");
___('day_short',    'EN', "d");
___('day_short',    'FR', "j");
___('ddmmyy',       'EN', "DD/MM/YY");
___('ddmmyy',       'FR', "JJ/MM/AA");
___('hhiiss',       'EN', "hours:minutes:seconds");
___('hhiiss',       'FR', "heures:minutes:secondes");
___('month',        'EN', "month");
___('month+',       'EN', "months");
___('month',        'FR', "mois");
___('month+',       'FR', "mois");
___('month_short',  'EN', "m");
___('month_short',  'FR', "m");
___('time',         'EN', "time");
___('time',         'FR', "heure");
___('times',        'EN', "time");
___('times+',       'EN', "times");
___('times',        'FR', "fois");
___('yyyyddmm',     'EN', "YYYY-DD-MM");
___('yyyyddmm',     'FR', "AAAA-MM-JJ");
___('year',         'EN', "year");
___('year+',        'EN', "years");
___('year',         'FR', "année");
___('year+',        'FR', "années");
___('year_age',     'EN', "year");
___('year_age+',    'EN', "years");
___('year_age',     'FR', "an");
___('year_age+',    'FR', "ans");
___('year_short',   'EN', "y");
___('year_short',   'FR', "a");


// Generic user related terms
___('account',        'EN', "account");
___('account',        'FR', "compte");
___('activity',       'EN', "activity");
___('activity',       'FR', "activité");
___('admin',          'EN', "admin");
___('admin',          'FR', "admin");
___('administration', 'EN', "administration");
___('administration', 'FR', "administration");
___('administrator',  'EN', "administrator");
___('administrator',  'FR', "administration");
___('deleted',        'EN', "deleted");
___('deleted',        'FR', "supprimé");
___('login',          'EN', "login");
___('login',          'FR', "connexion");
___('moderator',      'EN', "moderator");
___('moderator',      'FR', "modération");
___('password',       'EN', "password");
___('password',       'FR', "mot de passe");
___('register',       'EN', "register");
___('register',       'FR', "inscription");
___('rights',         'EN', "rights");
___('rights',         'FR', "droits");
___('user',           'EN', "user");
___('user',           'FR', "membre");
___('user+',          'EN', "users");
___('user+',          'FR', "membres");
___('user_acc+',      'EN', "users");
___('user_acc+',      'FR', "comptes");
___('username',       'EN', "username");
___('username',       'FR', "pseudonyme");


// Stats pages
___('stats_overall',  'EN', "Overall stats");
___('stats_overall',  'FR', "Stats globales");
___('stats_timeline', 'EN', "Timeline");
___('stats_timeline', 'FR', "Ligne temporelle");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       DATES                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Bilingual ordinals
___('ordinal_0_en', 'EN', "th");
___('ordinal_0_en', 'FR', "th");
___('ordinal_1_en', 'EN', "st");
___('ordinal_1_en', 'FR', "st");
___('ordinal_2_en', 'EN', "nd");
___('ordinal_2_en', 'FR', "nd");
___('ordinal_3_en', 'EN', "rd");
___('ordinal_3_en', 'FR', "rd");
___('ordinal_0_fr', 'EN', "ème");
___('ordinal_0_fr', 'FR', "ème");
___('ordinal_1_fr', 'EN', "er");
___('ordinal_1_fr', 'FR', "er");
___('ordinal_2_fr', 'EN', "nd");
___('ordinal_2_fr', 'FR', "nd");


// Bilingual time indicator
___('time_indicator_en',  'EN', "at");
___('time_indicator_en',  'FR', "at");
___('time_indicator_fr',  'EN', "à");
___('time_indicator_fr',  'FR', "à");


// Bilingual days
___('day_1_en', 'EN', "Monday");
___('day_1_en', 'FR', "Monday");
___('day_2_en', 'EN', "Tuesday");
___('day_2_en', 'FR', "Tuesday");
___('day_3_en', 'EN', "Wednesday");
___('day_3_en', 'FR', "Wednesday");
___('day_4_en', 'EN', "Thursday");
___('day_4_en', 'FR', "Thursday");
___('day_5_en', 'EN', "Friday");
___('day_5_en', 'FR', "Friday");
___('day_6_en', 'EN', "Saturday");
___('day_6_en', 'FR', "Saturday");
___('day_7_en', 'EN', "Sunday");
___('day_7_en', 'FR', "Sunday");
___('day_1_fr', 'EN', "Lundi");
___('day_1_fr', 'FR', "Lundi");
___('day_2_fr', 'EN', "Mardi");
___('day_2_fr', 'FR', "Mardi");
___('day_3_fr', 'EN', "Mercredi");
___('day_3_fr', 'FR', "Mercredi");
___('day_4_fr', 'EN', "Jeudi");
___('day_4_fr', 'FR', "Jeudi");
___('day_5_fr', 'EN', "Vendredi");
___('day_5_fr', 'FR', "Vendredi");
___('day_6_fr', 'EN', "Samedi");
___('day_6_fr', 'FR', "Samedi");
___('day_7_fr', 'EN', "Dimanche");
___('day_7_fr', 'FR', "Dimanche");


// Month names
___('month_1',        'EN', "January");
___('month_1',        'FR', "Janvier");
___('month_2',        'EN', "February");
___('month_2',        'FR', "Février");
___('month_3',        'EN', "March");
___('month_3',        'FR', "Mars");
___('month_4',        'EN', "April");
___('month_4',        'FR', "Avril");
___('month_5',        'EN', "May");
___('month_5',        'FR', "Mai");
___('month_6',        'EN', "June");
___('month_6',        'FR', "Juin");
___('month_7',        'EN', "July");
___('month_7',        'FR', "Juillet");
___('month_8',        'EN', "August");
___('month_8',        'FR', "Août");
___('month_9',        'EN', "September");
___('month_9',        'FR', "Septembre");
___('month_10',       'EN', "October");
___('month_10',       'FR', "Octobre");
___('month_11',       'EN', "November");
___('month_11',       'FR', "Novembre");
___('month_12',       'EN', "December");
___('month_12',       'FR', "Décembre");
___('month_short_1',  'EN', "Jan.");
___('month_short_1',  'FR', "Jan.");
___('month_short_2',  'EN', "Feb.");
___('month_short_2',  'FR', "Fév.");
___('month_short_3',  'EN', "Mar.");
___('month_short_3',  'FR', "Mar.");
___('month_short_4',  'EN', "Apr.");
___('month_short_4',  'FR', "Avr.");
___('month_short_5',  'EN', "May");
___('month_short_5',  'FR', "Mai");
___('month_short_6',  'EN', "June");
___('month_short_6',  'FR', "Juin");
___('month_short_7',  'EN', "July");
___('month_short_7',  'FR', "Juil.");
___('month_short_8',  'EN', "Aug.");
___('month_short_8',  'FR', "Août");
___('month_short_9',  'EN', "Sept.");
___('month_short_9',  'FR', "Sept.");
___('month_short_10', 'EN', "Oct.");
___('month_short_10', 'FR', "Oct.");
___('month_short_11', 'EN', "Nov.");
___('month_short_11', 'FR', "Nov.");
___('month_short_12', 'EN', "Dec.");
___('month_short_12', 'FR', "Déc.");


// Bilingual months
___('month_1_en',   'EN', "January");
___('month_1_en',   'FR', "January");
___('month_2_en',   'EN', "February");
___('month_2_en',   'FR', "February");
___('month_3_en',   'EN', "March");
___('month_3_en',   'FR', "March");
___('month_4_en',   'EN', "April");
___('month_4_en',   'FR', "April");
___('month_5_en',   'EN', "May");
___('month_5_en',   'FR', "May");
___('month_6_en',   'EN', "June");
___('month_6_en',   'FR', "June");
___('month_7_en',   'EN', "July");
___('month_7_en',   'FR', "July");
___('month_8_en',   'EN', "August");
___('month_8_en',   'FR', "August");
___('month_9_en',   'EN', "September");
___('month_9_en',   'FR', "September");
___('month_10_en',  'EN', "October");
___('month_10_en',  'FR', "October");
___('month_11_en',  'EN', "November");
___('month_11_en',  'FR', "November");
___('month_12_en',  'EN', "December");
___('month_12_en',  'FR', "December");
___('month_1_fr',   'EN', "Janvier");
___('month_1_fr',   'FR', "Janvier");
___('month_2_fr',   'EN', "Février");
___('month_2_fr',   'FR', "Février");
___('month_3_fr',   'EN', "Mars");
___('month_3_fr',   'FR', "Mars");
___('month_4_fr',   'EN', "Avril");
___('month_4_fr',   'FR', "Avril");
___('month_5_fr',   'EN', "Mai");
___('month_5_fr',   'FR', "Mai");
___('month_6_fr',   'EN', "Juin");
___('month_6_fr',   'FR', "Juin");
___('month_7_fr',   'EN', "Juillet");
___('month_7_fr',   'FR', "Juillet");
___('month_8_fr',   'EN', "Août");
___('month_8_fr',   'FR', "Août");
___('month_9_fr',   'EN', "Septembre");
___('month_9_fr',   'FR', "Septembre");
___('month_10_fr',  'EN', "Octobre");
___('month_10_fr',  'FR', "Octobre");
___('month_11_fr',  'EN', "Novembre");
___('month_11_fr',  'FR', "Novembre");
___('month_12_fr',  'EN', "Décembre");
___('month_12_fr',  'FR', "Décembre");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 BBCODES / NBCODES                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// BBCodes editor
___('bold',       'EN', "Bold");
___('bold',       'FR', "Gras");
___('italics',    'EN', "Italics");
___('italics',    'FR', "Italique");
___('underlined', 'EN', "Underline");
___('underlined', 'FR', "Souligner");
___('quote',      'EN', "Quote");
___('quote',      'FR', "Citation");
___('spoiler',    'EN', "Spoiler");
___('spoiler',    'FR', "Divulgâchage");
___('link',       'EN', "Link");
___('link',       'FR', "Lien");
___('image',      'EN', "Image");
___('image',      'FR', "Image");


// BBcodes editor prompts
___('quote_prompt',   'EN', "Who or what are you quoting? (you can leave this empty)");
___('quote_prompt',   'FR', "Qui ou quoi citez-vous ? (vous pouvez laisser ceci vide)");
___('spoiler_prompt', 'EN', "What is the name of the content that you are spoiling? (you can leave this empty)");
___('spoiler_prompt', 'FR', "Quel est le nom de ce que vous divulgâchez ? (vous pouvez laisser ceci vide)");
___('link_prompt',    'EN', "What is the URL you want to link to?");
___('link_prompt',    'FR', "Vers quelle adresse internet voulez-vous faire pointer votre lien ?");
___('link_prompt_2',  'EN', "What text do you want your link to show (optional)");
___('link_prompt_2',  'FR', "Quel texte voulez-vous afficher sur votre lien (optionnel)");
___('image_prompt',   'EN', "What is the URL of the image you want to insert?");
___('image_prompt',   'FR', "Quelle est l\'adresse internet de l\'image que vous désirez insérer ?");


// BBCodes
___('bbcodes',              'EN', "BBCodes");
___('bbcodes',              'FR', "BBCodes");
___('bbcodes_quote',        'EN', "Quote:");
___('bbcodes_quote',        'FR', "Citation :");
___('bbcodes_quote_by',     'EN', "Quote by");
___('bbcodes_quote_by',     'FR', "Citation de");
___('bbcodes_spoiler',      'EN', "SPOILER");
___('bbcodes_spoiler',      'FR', "DIVULGÂCHAGE");
___('bbcodes_spoiler_hide', 'EN', "HIDE SPOILER CONTENTS");
___('bbcodes_spoiler_hide', 'FR', "MASQUER LE CONTENU CACHÉ");
___('bbcodes_spoiler_show', 'EN', "SHOW SPOILER CONTENTS");
___('bbcodes_spoiler_show', 'FR', "VOIR LE CONTENU CACHÉ");


// NBCodes
___('nbcodes_menu_contents',      'EN', "Page contents:");
___('nbcodes_menu_contents',      'FR', "Contenu de la page :");
___('nbcodes_video_hidden',       'EN', "This video is hidden ({{link|pages/account/settings_privacy|privacy options}})");
___('nbcodes_video_hidden',       'FR', "Cette vidéo est masquée ({{link|pages/account/settings_privacy|options de vie privée}}");
___('nbcodes_video_hidden_small', 'EN', "Video hidden ({{link|pages/account/settings_privacy|privacy options}})");
___('nbcodes_video_hidden_small', 'FR', "Vidéo masquée ({{link|pages/account/settings_privacy|options de vie privée}})");
___('nbcodes_trends_hidden',      'EN', "This Google trends graph is hidden ({{link|pages/account/settings_privacy|privacy options}})");
___('nbcodes_trends_hidden',      'FR', "Ce graphe Google trends est masqué ({{link|pages/account/settings_privacy|options de vie privée}})");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   COMMON FILES                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Error messages

// Strings thrown by the functions on this very page
___('error_duplicate_translation', 'EN', "Error: Duplicate translation name - ");
___('error_duplicate_translation', 'FR', "Erreur : Traduction déjà existante - ");


// Strings required by the function that throws the errors
___('error_ohno',         'EN', "OH NO  : (");
___('error_ohno',         'FR', "OH NON  : (");
___('error_encountered',  'EN', "YOU HAVE ENCOUNTERED AN ERROR");
___('error_encountered',  'FR', "VOUS AVEZ RENCONTRÉ UNE ERREUR");


// Forbidden page
___('error_forbidden', 'EN', "This page should not be accessed");
___('error_forbidden', 'FR', "Vous ne devriez pas accéder à cette page");


// Website update
___('website_closed',       'EN', "The website is currently closed for maintenance. Click here to reopen it to the public.");
___('website_closed',       'FR', "Le site est actuellement fermé pour maintenance. Cliquer ici pour le rouvrir au public.");
___('error_website_update', 'EN', <<<EOT
<html>
  <head>
    <title>NoBleme - Maintenance</title>
  </head>
  <body style="background: #121212; color: #B00B1E; font-size: 2.5em; font-weight: bold;">
    <div style="text-align: center; width: 60%; margin: auto; padding-top: 3.0em;">
      <img style="width: 100%; max-width: 750px; filter: drop-shadow(0 0 10px #B00B1E);" src="{{1}}/img/common/logo_full.png" alt="NoBleme.com">
    </div>
    <div style="font-family: sans-serif; text-align: center; padding-top: 5.0em;">
      A maintenance operation is in progress.<br>
      <br>
      Come back in a few minutes.
    </div>
  </body>
</html>
EOT
);
___('error_website_update', 'FR', <<<EOT
<html>
  <head>
    <title>NoBleme - Maintenance</title>
  </head>
  <body style="background: #121212; color: #B00B1E; font-size: 2.5em; font-weight: bold;">
    <div style="text-align: center; width: 60%; margin: auto; padding-top: 3.0em;">
      <img style="width: 100%; max-width: 750px; filter: drop-shadow(0 0 10px #B00B1E);" src="{{1}}/img/common/logo_full.png" alt="NoBleme.com">
    </div>
    <div style="font-family: sans-serif; text-align: center; padding-top: 5.0em;">
      Une opération de maintenance est en cours.<br>
      <br>
      Revenez dans quelques minutes.
    </div>
  </body>
</html>
EOT
);


// Flood check
___('error_flood_login',  'EN', "You can only do this action while logged into your account");
___('error_flood_login',  'FR', "Vous devez vous connecter à votre compte pour effectuer cette action");
___('error_flood_wait',   'EN', "In order to prevent flood, you must wait between each action on the website<br><br>Try doing it again later");
___('error_flood_wait',   'FR', "Afin d'éviter le flood, vous devez attendre entre chaque action<br><br>Réessayez plus tard");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Time differentials

// Past actions
___('time_diff_past_future',  'EN', "In the future");
___('time_diff_past_future',  'FR', "Dans le futur");
___('time_diff_past_now',     'EN', "Right now");
___('time_diff_past_now',     'FR', "En ce moment même");
___('time_diff_past_second',  'EN', "A second ago");
___('time_diff_past_second',  'FR', "Il y a 1 seconde");
___('time_diff_past_seconds', 'EN', "{{1}} seconds ago");
___('time_diff_past_seconds', 'FR', "Il y a {{1}} secondes");
___('time_diff_past_minute',  'EN', "A minute ago");
___('time_diff_past_minute',  'FR', "Il y a 1 minute");
___('time_diff_past_minutes', 'EN', "{{1}} minutes ago");
___('time_diff_past_minutes', 'FR', "Il y a {{1}} minutes");
___('time_diff_past_hour',    'EN', "An hour ago");
___('time_diff_past_hour',    'FR', "Il y a 1 heure");
___('time_diff_past_hours',   'EN', "{{1}} hours ago");
___('time_diff_past_hours',   'FR', "Il y a {{1}} heures");
___('time_diff_past_day',     'EN', "Yesterday");
___('time_diff_past_day',     'FR', "Hier");
___('time_diff_past_2days',   'EN', "2 days ago");
___('time_diff_past_2days',   'FR', "Avant-hier");
___('time_diff_past_days',    'EN', "{{1}} days ago");
___('time_diff_past_days',    'FR', "Il y a {{1}} jours");
___('time_diff_past_year',    'EN', "A year ago");
___('time_diff_past_year',    'FR', "L'année dernière");
___('time_diff_past_years',   'EN', "{{1}} years ago");
___('time_diff_past_years',   'FR', "Il y a {{1}} ans");
___('time_diff_past_century', 'EN', "A century ago");
___('time_diff_past_century', 'FR', "Le siècle dernier");
___('time_diff_past_long',    'EN', "An extremely long time ago");
___('time_diff_past_long',    'FR', "Il y a très très longtemps");


// Future actions
___('time_diff_future_past',    'EN', "In the past");
___('time_diff_future_past',    'FR', "Dans le passé");
___('time_diff_future_second',  'EN', "In 1 second");
___('time_diff_future_second',  'FR', "Dans 1 seconde");
___('time_diff_future_seconds', 'EN', "In {{1}} seconds");
___('time_diff_future_seconds', 'FR', "Dans {{1}} secondes");
___('time_diff_future_minute',  'EN', "In 1 minute");
___('time_diff_future_minute',  'FR', "Dans 1 minute");
___('time_diff_future_minutes', 'EN', "In {{1}} minutes");
___('time_diff_future_minutes', 'FR', "Dans {{1}} minutes");
___('time_diff_future_hour',    'EN', "In 1 hour");
___('time_diff_future_hour',    'FR', "Dans 1 heure");
___('time_diff_future_hours',   'EN', "In {{1}} hours");
___('time_diff_future_hours',   'FR', "Dans {{1}} heures");
___('time_diff_future_day',     'EN', "Tomorrow");
___('time_diff_future_day',     'FR', "Demain");
___('time_diff_future_2days',   'EN', "In 2 days");
___('time_diff_future_2days',   'FR', "Après-demain");
___('time_diff_future_days',    'EN', "In {{1}} days");
___('time_diff_future_days',    'FR', "Dans {{1}} jours");
___('time_diff_future_year',    'EN', "In 1 year");
___('time_diff_future_year',    'FR', "Dans 1 an");
___('time_diff_future_years',   'EN', "In {{1}} years");
___('time_diff_future_years',   'FR', "Dans {{1}} ans");
___('time_diff_future_century', 'EN', "Next century");
___('time_diff_future_century', 'FR', "Dans un siècle");
___('time_diff_future_long',    'EN', "In an extremely long time");
___('time_diff_future_long',    'FR', "Dans très très longtemps");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Header

// Language warning
___('header_language_error', 'EN', "Sorry! This page is only available in french and does not have an english translation yet.");
___('header_language_error', 'FR', "Désolé ! Cette page n'est disponible qu'en anglais et n'a pas encore de traduction française.");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global menus

// Top menu
___('menu_top_nobleme', 'EN', "NOBLEME");
___('menu_top_nobleme', 'FR', "NOBLEME");
___('menu_top_pages',   'EN', "PAGES");
___('menu_top_pages',   'FR', "PAGES");
___('menu_top_social',  'EN', "SOCIAL");
___('menu_top_social',  'FR', "SOCIAL");


// Submenu: NoBleme
___('submenu_nobleme_homepage',       'EN', "Home page");
___('submenu_nobleme_homepage',       'FR', "Page d'accueil");
___('submenu_nobleme_what_is',        'EN', "What is NoBleme");
___('submenu_nobleme_what_is',        'FR', "Qu'est-ce que NoBleme");
___('submenu_nobleme_follow',         'EN', "Follow NoBleme");
___('submenu_nobleme_follow',         'FR', "Suivre NoBleme");
___('submenu_nobleme_activity',       'EN', "Recent activity");
___('submenu_nobleme_activity',       'FR', "Activité récente");

___('submenu_nobleme_online',         'EN', "Who's online");
___('submenu_nobleme_online',         'FR', "Qui est en ligne");
___('submenu_nobleme_userlist',       'EN', "Registered users");
___('submenu_nobleme_userlist',       'FR', "Liste des membres");
___('submenu_nobleme_staff',          'EN', "Administrative team");
___('submenu_nobleme_staff',          'FR', "Équipe administrative");

___('submenu_nobleme_dev',            'EN', "Development");
___('submenu_nobleme_dev',            'FR', "Développement");
___('submenu_nobleme_behind_scenes',  'EN', "Behind the scenes");
___('submenu_nobleme_behind_scenes',  'FR', "Coulisses de NoBleme");
___('submenu_nobleme_devblog',        'EN', "Development blog");
___('submenu_nobleme_devblog',        'FR', "Blog de développement");
___('submenu_nobleme_todolist',       'EN', "To-do list");
___('submenu_nobleme_todolist',       'FR', "Liste des tâches");
___('submenu_nobleme_api',            'EN', "NoBleme API");
___('submenu_nobleme_api',            'FR', "API NoBleme");
___('submenu_nobleme_roadmap',        'EN', "Website roadmap");
___('submenu_nobleme_roadmap',        'FR', "Plan de route");
___('submenu_nobleme_report_bug',     'EN', "Report a bug");
___('submenu_nobleme_report_bug',     'FR', "Rapporter un bug");

___('submenu_nobleme_support',        'EN', "Support");
___('submenu_nobleme_support',        'FR', "Support");
___('submenu_nobleme_coc',            'EN', "Code of conduct");
___('submenu_nobleme_coc',            'FR', "Code de conduite");
___('submenu_nobleme_privacy',        'EN', "Privacy policy");
___('submenu_nobleme_privacy',        'FR', "Politique de confidentialité");
___('submenu_nobleme_personal_data',  'EN', "Your personal data");
___('submenu_nobleme_personal_data',  'FR', "Vos données personnelles");
___('submenu_nobleme_legal',          'EN', "Legal notice");
___('submenu_nobleme_legal',          'FR', "Mentions légales");
___('submenu_nobleme_contact_admin',  'EN', "Contact the admins");
___('submenu_nobleme_contact_admin',  'FR', "Contacter l'administration");


// Submenu: Pages
___('submenu_pages_compendium',             'EN', "Compendium");
___('submenu_pages_compendium',             'FR', "Compendium");
___('submenu_pages_compendium_index',       'EN', "21st century culture");
___('submenu_pages_compendium_index',       'FR', "Culture du 21ème siècle");
___('submenu_pages_compendium_faq',         'EN', "Mission statement");
___('submenu_pages_compendium_faq',         'FR', "Introduction & FAQ");
___('submenu_pages_compendium_pages',       'EN', "List of all pages");
___('submenu_pages_compendium_pages',       'FR', "Liste des pages");
___('submenu_pages_compendium_random',      'EN', "Random page");
___('submenu_pages_compendium_random',      'FR', "Page au hasard");
___('submenu_pages_compendium_image',       'EN', "Random image");
___('submenu_pages_compendium_image',       'FR', "Image au hasard");
___('submenu_pages_compendium_types',       'EN', "Page types");
___('submenu_pages_compendium_types',       'FR', "Thématiques");
___('submenu_pages_compendium_eras',        'EN', "Cultural eras");
___('submenu_pages_compendium_eras',        'FR', "Périodes");

___('submenu_pages_politics',             'EN', "Politics");
___('submenu_pages_politics',             'FR', "Politique");
___('submenu_pages_politics_manifesto',   'EN', "Contramanifesto");
___('submenu_pages_politics_manifesto',   'FR', "Contremanifeste");
___('submenu_pages_politics_faq',         'EN', "Contrapolitics FAQ");
___('submenu_pages_politics_faq',         'FR', "FAQ Contrepolitique");


// Submenu: Social
___('submenu_social_platforms',           'EN', "Social platforms");
___('submenu_social_platforms',           'FR', "Plateformes sociales");
___('submenu_social_platforms_irc',       'EN', "IRC chat server");
___('submenu_social_platforms_irc',       'FR', "Serveur de chat IRC");
___('submenu_social_platforms_irc_web',   'EN', "IRC from your browser");
___('submenu_social_platforms_irc_web',   'FR', "Client navigateur IRC");
___('submenu_social_platforms_irc_chans', 'EN', "IRC channel list");
___('submenu_social_platforms_irc_chans', 'FR', "Liste des canaux IRC");
___('submenu_social_platforms_discord',   'EN', "NoBleme on Discord");
___('submenu_social_platforms_discord',   'FR', "NoBleme sur Discord");
___('submenu_social_platforms_others',    'EN', "Other social platforms");
___('submenu_social_platforms_others',    'FR', "Autres plateformes");

___('submenu_social_quotes',              'EN', "Quotes");
___('submenu_social_quotes',              'FR', "Citations");
___('submenu_social_quotes_list',         'EN', "Quote database");
___('submenu_social_quotes_list',         'FR', "Paroles de NoBleme");
___('submenu_social_quotes_random',       'EN', "Random quote");
___('submenu_social_quotes_random',       'FR', "Citation au hasard");
___('submenu_social_quotes_submit',       'EN', "Submit a new quote");
___('submenu_social_quotes_submit',       'FR', "Proposer une citation");

___('submenu_social_meetups',             'EN', "Real life meetups");
___('submenu_social_meetups',             'FR', "Rencontres IRL");
___('submenu_social_meetups_list',        'EN', "List of meetups");
___('submenu_social_meetups_list',        'FR', "Liste des IRL");
___('submenu_social_meetups_host',        'EN', "Plan a new meetup");
___('submenu_social_meetups_host',        'FR', "Organiser une IRL");

___('submenu_social_games',               'EN', "Games");
___('submenu_social_games',               'FR', "Jeux");
___('submenu_social_games_nobleme',       'EN', "Gaming nights");
___('submenu_social_games_nobleme',       'FR', "Sessions de jeu");
___('submenu_social_games_memories',      'EN', "Old memories");
___('submenu_social_games_memories',      'FR', "Vieux souvenirs");


// Submenu: Account
___('submenu_user_pms',               'EN', "Private messages");
___('submenu_user_pms',               'FR', "Messages privés");
___('submenu_user_pms_inbox',         'EN', "Message inbox");
___('submenu_user_pms_inbox',         'FR', "Boîte de réception");
___('submenu_user_pms_outbox',        'EN', "Sent messages");
___('submenu_user_pms_outbox',        'FR', "Messages envoyés");
___('submenu_user_pms_write',         'EN', "Write a message");
___('submenu_user_pms_write',         'FR', "Écrire un message");

___('submenu_user_edit',              'EN', "Account settings");
___('submenu_user_edit',              'FR', "Réglages du compte");
___('submenu_user_edit_email',        'EN', "Change my e-mail");
___('submenu_user_edit_email',        'FR', "Changer d'e-mail");
___('submenu_user_edit_password',     'EN', "Change my password");
___('submenu_user_edit_password',     'FR', "Changer de mot de passe");
___('submenu_user_edit_username',     'EN', "Change my username");
___('submenu_user_edit_username',     'FR', "Changer de pseudonyme");
___('submenu_user_edit_delete',       'EN', "Delete my account");
___('submenu_user_edit_delete',       'FR', "Supprimer mon compte");

___('submenu_user_settings',          'EN', "Website settings");
___('submenu_user_settings',          'FR', "Réglages du site");
___('submenu_user_settings_privacy',  'EN', "Privacy options");
___('submenu_user_settings_privacy',  'FR', "Options de vie privée");
___('submenu_user_settings_nsfw',     'EN', "Adult content options");
___('submenu_user_settings_nsfw',     'FR', "Options de vulgarité");

___('submenu_user_profile',           'EN', "Public profile");
___('submenu_user_profile',           'FR', "Profil public");
___('submenu_user_profile_self',      'EN', "My public profile");
___('submenu_user_profile_self',      'FR', "Voir mon profil public");
___('submenu_user_profile_edit',      'EN', "Edit my profile");
___('submenu_user_profile_edit',      'FR', "Modifier mon profil");

___('submenu_user_logout_logout',     'EN', "Log out of this account");
___('submenu_user_logout_logout',     'FR', "Se déconnecter du compte");


// Submenu: Admin
___('submenu_admin_activity',       'EN', "Mod. tools");
___('submenu_admin_activity',       'FR', "Outils de mod.");
___('submenu_admin_inbox',          'EN', "Administrative mail");
___('submenu_admin_inbox',          'FR', "Courrier administratif");
___('submenu_admin_modlogs',        'EN', "Moderation logs");
___('submenu_admin_modlogs',        'FR', "Logs de modération");
___('submenu_admin_doppelganger',   'EN', "Doppelgänger");
___('submenu_admin_doppelganger',   'FR', "Doppelgänger");

___('submenu_admin_users',            'EN', "User management");
___('submenu_admin_users',            'FR', "Gestion des membres");
___('submenu_admin_ban',              'EN', "Banned users management");
___('submenu_admin_ban',              'FR', "Gestion des bannissements");
___('submenu_admin_username',         'EN', "Change a username");
___('submenu_admin_username',         'FR', "Modifier un pseudonyme");
___('submenu_admin_password',         'EN', "Change a password");
___('submenu_admin_password',         'FR', "Modifier un mot de passe");
___('submenu_admin_rights',           'EN', "User access rights");
___('submenu_admin_rights',           'FR', "Changer les permissions");
___('submenu_admin_deactivate',       'EN', "Delete an account");
___('submenu_admin_deactivate',       'FR', "Supprimer un compte");
___('submenu_admin_account_settings', 'EN', "User settings & stats");
___('submenu_admin_account_settings', 'FR', "Réglages & stats comptes");
___('submenu_admin_guest_settings',   'EN', "Guest settings & stats");
___('submenu_admin_guest_settings',   'FR', "Réglages & stats visites");

___('submenu_admin_website',        'EN', "Admin tools");
___('submenu_admin_website',        'FR', "Outils admin");
___('submenu_admin_settings',       'EN', "Website settings");
___('submenu_admin_settings',       'FR', "Paramètres du site");
___('submenu_admin_ircbot',         'EN', "IRC bot management");
___('submenu_admin_ircbot',         'FR', "Gestion du bot IRC");
___('submenu_admin_discord',        'EN', "Discord webhook");
___('submenu_admin_discord',        'FR', "Webhook Discord");
___('submenu_admin_scheduler',      'EN', "Scheduled tasks");
___('submenu_admin_scheduler',      'FR', "Tâches planifiées");
___('submenu_admin_versions',       'EN', "Version numbers");
___('submenu_admin_versions',       'FR', "Numéros de version");
___('submenu_admin_sql',            'EN', "Run SQL queries");
___('submenu_admin_sql',            'FR', "Jouer les requêtes SQL");

___('submenu_admin_metrics',        'EN', "Metrics");
___('submenu_admin_metrics',        'FR', "Performances");
___('submenu_admin_pageviews',      'EN', "Pageviews");
___('submenu_admin_pageviews',      'FR', "Pages populaires");
___('submenu_admin_stats_guests',   'EN', "Guests");
___('submenu_admin_stats_guests',   'FR', "Visites");

___('submenu_admin_doc_snippets',   'EN', "Code snippets");
___('submenu_admin_doc_snippets',   'FR', "Modèles de code");
___('submenu_admin_doc_functions',  'EN', "Functions list");
___('submenu_admin_doc_functions',  'FR', "Liste de fonctions");
___('submenu_admin_doc',            'EN', "Dev tools");
___('submenu_admin_doc',            'FR', "Développement");
___('submenu_admin_doc_css',        'EN', "CSS palette");
___('submenu_admin_doc_css',        'FR', "Palette CSS");
___('submenu_admin_doc_js',         'EN', "JavaScript toolbox");
___('submenu_admin_doc_js',         'FR', "Outils JavaScript");
___('submenu_admin_doc_workflow',   'EN', "Development workflow");
___('submenu_admin_doc_workflow',   'FR', "Workflow de développement");
___('submenu_admin_doc_duplicates', 'EN', "Duplicate translations");
___('submenu_admin_doc_duplicates', 'FR', "Traductions redondantes");

___('submenu_admin_local_tests',    'EN', "Local dev: Tests");
___('submenu_admin_local_tests',    'FR', "Dev local : Tests");
___('submenu_admin_local_fixtures', 'EN', "Local dev: Fixtures");
___('submenu_admin_local_fixtures', 'FR', "Dev local : Fixtures");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Footer

___('footer_pageviews', 'EN', "This page has been seen ");
___('footer_pageviews', 'FR', "Cette page a été consultée ");
___('footer_loadtime',  'EN', "Page loaded in ");
___('footer_loadtime',  'FR', "Page chargée en ");
___('footer_legal',     'EN', "Legal notice and privacy policy");
___('footer_legal',     'FR', "Mentions légales &amp; confidentialité");
___('footer_copyright', 'EN', "&copy; NoBleme.com : 2005 - {{1}}");
___('footer_copyright', 'FR', "&copy; NoBleme.com : 2005 - {{1}}");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       LOGIN                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Login form
___('login_form_form_remember', 'EN', "Stay logged in");
___('login_form_form_remember', 'FR', "Maintenir la connexion");
___('login_form_form_register', 'EN', "REGISTER");
___('login_form_form_register', 'FR', "INSCRIPTION");


// Error messages
___('login_form_error_no_username',         'EN', "You must specify a username");
___('login_form_error_no_username',         'FR', "Vous devez saisir un pseudonyme");
___('login_form_error_no_password',         'EN', "You must specify a password");
___('login_form_error_no_password',         'FR', "Vous devez saisir un mot de passe");
___('login_form_error_bruteforce',          'EN', "You are trying to log in too often, please wait 10 minutes before your next attempt");
___('login_form_error_bruteforce',          'FR', "Trop de tentatives de connexion, merci d'attendre 10 minutes avant d'essayer de nouveau");
___('login_form_error_deleted',             'EN', "This account has been deleted");
___('login_form_error_deleted',             'FR', "Ce compte a été supprimé");
___('login_form_error_wrong_user',          'EN', "This username does not exist on the website");
___('login_form_error_wrong_user',          'FR', "Ce pseudonyme n'existe pas sur le site");
___('login_form_error_forgotten_user',      'EN', "Forgot your username?");
___('login_form_error_forgotten_user',      'FR', "Vous avez oublié votre pseudonyme ?");
___('login_form_error_wrong_password',      'EN', "Incorrect password for this username");
___('login_form_error_wrong_password',      'FR', "Mauvais mot de passe pour ce pseudonyme");
___('login_form_error_forgotten_password',  'EN', "Forgot your password?");
___('login_form_error_forgotten_password',  'FR', "Mot de passe oublié ?");


// Lost account access
___('users_lost_access_title',    'EN', "Lost account access");
___('users_lost_access_title',    'FR', "Accès perdu à votre compte");
___('users_lost_access_body',     'EN', <<<EOT
As a part of its {{link++|pages/doc/privacy|privacy policy|bold|{{1}}}}, NoBleme will protect your anonymity as much as possible. This means that you will never be sent any emails that could be used to link you to your identity on the website, or asking you to provide your password. On top of that, automated password recovery systems can be used in a few nefarious ways that we would rather not have to deal with. With this context in mind, NoBleme decided to not implement an automated account recovery process.
EOT
);
___('users_lost_access_body',     'FR', <<<EOT
Par respect pour la {{link++|pages/doc/privacy|politique de confidentialité|bold|{{1}}}} de NoBleme, votre anonymité doit être protégée le plus possible. Cela signifie que vous ne recevrez jamais d'e-mail permettant de vous relier à votre identité sur NoBleme, ou vous demandant votre mot de passe. Par ailleurs, les systèmes de récupération automatique de mots de passe perdus peuvent être exploités de plusieurs façons que nous n'avons pas envie de devoir gérer. Ce contexte devrait vous aider à comprendre pourquoi NoBleme a fait le choix de ne pas avoir de système de récupération de compte automatisé.
EOT
);
___('users_lost_access_solution', 'EN', <<<EOT
If you have lost access to your account (forgotten username, forgotten password, or otherwise), the only way to recover that access is to go on NoBleme's {{link++|pages/social/irc|NoBleme's IRC chat server|bold|{{1}}}} and ask for a {{link++|pages/users/admins|website administrator|bold|{{1}}}} to manually reset your account's password. No need to worry about identity usurpation, there is a strict process in place that will allow the administrator to verify your identity before doing the resetting.
EOT
);
___('users_lost_access_solution', 'FR', <<<EOT
Si vous avez perdu l'accès à votre compte (pseudonyme oublié, mot de passe oublié, ou autre), la seule façon de récupérer cet accès est d'aller sur le {{link++|pages/social/irc|chat IRC NoBleme|bold|{{1}}}} afin d'y demander à {{link++|pages/users/admins|l'équipe administrative|bold|{{1}}}} de manuellement remettre à zéro le mot de passe de votre compte. Pas d'inquiétude pour ce qui est de l'usurpation d'identité, un processus strict de vérification est en place et devra être respecté avant que l'administration puisse remettre à zéro votre mot de passe et vous rendre l'accès à votre compte perdu.
EOT
);


// IP banned
___('users_ip_banned_title',  'EN', "Your IP is banned");
___('users_ip_banned_title',  'FR', "Adresse IP bannie");
___('users_ip_banned_body',   'EN', <<<EOT
<p>
  Your current IP address has been banned from logging into or registering an account on this website.
</p>
<p>
  This type of extreme punishment is only given in special cases where we have no other choice left. If you are the author of the mischief that caused you to be IP banned, then you know exactly why you are reading this. If not, then we are deeply sorry that you have been banned as collateral damage, but we have no other choice than to restrict your access to the website as your {{external|https://en.wikipedia.org/wiki/IP_address|IP address}} is shared with someone else who has been using the website in abusive ways.
</p>
<p>
  Once this IP ban expires, we hope to see you again under different circumstances. Until then, you are free to continue using the website as a guest.
</p>
EOT
);
___('users_ip_banned_body',   'FR', <<<EOT
<p>
  Votre adresse IP actuelle est bannie : vous ne pouvez pas vous connecter à un compte.
</p>
<p>
Ce type de punition extrême n'est utilisé que dans des cas spéciaux où nous n'avons pas d'autre option qu'une exclusion totale. Si vous êtes responsable du chaos qui a mené à ce bannissement, vous savez exactement pourquoi vous voyez ce message. Si ce n'est pas le cas, nous sommes désolés de vous annoncer que vous êtes victime de dommages collatéraux : quelqu'un d'autre partageant la même {{external|https://fr.wikipedia.org/wiki/Adresse_IP|Adresse IP}} que vous a causé tant de problèmes que nous n'avons pas eu d'autre option que de bannir cette adresse IP.
</p>
<p>
Une fois ce bannissement fini, nous espérons vous revoir dans de meilleures circonstances. En attendant, vous êtes libre de continuer à utiliser le site, mais sans pouvoir utiliser de compte.
</p>
EOT
);




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
    Obviously, illegal content will immediately be sent to the authorities. Don't play with fire.
  </li>
  <li>
    Since NoBleme has no age restriction, pornography and highly suggestive content are forbidden.
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
We know tensions always tend to appear in shared spaces containing varied personalities and opinions. However, if your behavior prevents other people from having a good time, then we will have to exclude you. Let's all be respectful of others, we collectively benefit from it.
</p>
EOT
);

___('coc', 'FR', <<<EOT
<p class="padding_bot">
  NoBleme est une petite communauté à l'ambiance décontractée. Il n'y a pas de restriction d'âge, et peu de restrictions de contenu. Il y a juste un code de conduite minimaliste à respecter afin de cohabiter paisiblement, que vous trouverez ci-dessous :
</p>
<ul>
  <li>
    Tout contenu illégal sera immédiatement envoyé aux autorités. Ne jouez pas avec le feu.
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
Il est normal que des tensions apparaissent dans des lieux où des personnalités et opinions variées coexistent. Toutefois, si votre comportement empêche d'autres personnes de passer un bon moment, nous devrons vous exclure. La bonne ambiance de la communauté dépend de la bienveillance collective de ses membres.
</p>
EOT
);