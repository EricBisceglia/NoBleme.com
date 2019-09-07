<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                The functions in this file are global to the website and should always be included                 //
//     Most of them are used in the header, the footer, or are generic useful functions that any page might need     //
//                                                                                                                   //
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                STRING MANIPULATION                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Truncates a string if it is longer than a specified value.
 *
 * @param   string                  $string The string that will be truncated.
 * @param   int                     $length The length above which the string will be truncated.
 * @param   string|null (OPTIONAL)  $suffix Appends text to the end of the string if it has been truncated.
 *
 * @return  string                          The string, truncated if necessary.
 */

function string_truncate($string, $length, $suffix='')
{
  // If the string needs to be truncated, then do it and apply the suffix, else return the string as is
  return (mb_strlen($string, 'UTF-8') > $length) ? mb_substr($string, 0, $length, 'UTF-8').$suffix : $string;
}




/**
 * Changes the case of a string.
 *
 * @param   string  $string The string that will have its case changed.
 * @param   string  $case   The case to apply to the string ('uppercase', 'lowercase', 'initials')
 *
 * @return  string          The string, with its case changed.
 */

function string_change_case($string, $case)
{
  // Changes the string to all uppercase
  if($case == 'uppercase')
    return mb_convert_case($string, MB_CASE_UPPER, "UTF-8");

  // Changes the string to all lowercase
  else if($case == 'lowercase')
    return mb_convert_case($string, MB_CASE_LOWER, "UTF-8");

  // Changes the first character of the string to uppercase, ignores the rest
  else if($case == 'initials')
    return mb_substr(mb_convert_case($string, MB_CASE_UPPER, "UTF-8"), 0, 1, 'utf-8').mb_substr($string, 1, 65536, 'utf-8');
}




/**
 * Removes accentuated latin characters from a string.
 *
 * @param   string $string  The string which is about to lose its latin accents.
 *
 * @return  string          The string, without its latin accents.
 */

function string_remove_accents($string)
{
  // Simply enough, prepare two arrays: accents and their non accentuated equivalents
  $accents    = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
  $no_accents = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

  // Replace any occurence of the first set of characters by its equivalent in the second
  return str_replace($accents, $no_accents, $string);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             DATE FORMAT MANIPULATION                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Improves the strftime function.
 *
 * The default PHP strftime function does not allow for ordinal suffixes when converting dates to text, let's fix this!
 *
 * @param   string  $format     The string used to format your date.
 * @param   int     $timestamp  The timestamp being formatted.
 *
 * @return  string              The formatted output.
 */

function date_better_strftime($format, $timestamp)
{
  // Add an extra parameter to strftime using the date standard function
  $format = str_replace('%O', date('S', $timestamp), $format);

  // Return the formatted output
  return strftime($format, $timestamp);
}




/**
 * Returns the french ordinal value of a number.
 *
 * Because date is not locale aware and strftime lacks some functionalities, we'll need to do some extra work here...
 * If we want ordinal numbers in dates in both french and english, we'll need to be able to return french ordinals.
 *
 * @param   int     $timestamp  The timestamp of the date to ordinalize.
 *
 * @return  string              The formatted output.
 */

function date_french_ordinal($timestamp)
{
  // Get the full day from the timestamp
  $full_day = date('d', $timestamp);

  // If the full day is 1, return an ordinal. Else, don't. French is simple with dates, isn't it?
  if($full_day == 1)
    return 'er';
  else
    return '';
}




/**
 * Transforms a MySQL date or a timestamp into a plaintext date.
 *
 * MySQL gives us dates in the YYYY-MM-DD format, and we often want to display them in plaintext.
 * We store a lot of our dates in timestamps aswell, this function can work with a timestamp as an input too.
 * If no date is specified, it returns the current date instead.
 *
 * @param   string|int|null $date       The MySQL date or timestamp that we want to transform.
 * @param   int|null        $strip_day  If 1, strips the day's name. If 2, strips the whole day.
 * @param   string|null     $lang       The language in which we want to display the result, defaults to current lang.
 *
 * @return  string                      The required date, in plaintext.
 */

function date_to_text($date=NULL, $strip_day=0, $lang=null)
{
  // If no date has been entered, use the current timestamp instead
  $date = (!$date) ? time() : $date;

  // If we are dealing with a MySQL date, transform it into a timestamp
  $date = (!is_numeric($date)) ? strtotime($date) : $date;

  // Set the correct locale for times
  $lang = (!$lang) ? user_get_language() : $lang;
  if($lang == 'EN')
    setlocale(LC_TIME, "en_US.UTF-8", 'eng');
  else
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

  // Return the formatted date - each language has its own date formatting rules
  if(!$strip_day)
  {
    if($lang == 'EN')
      return date_better_strftime('%A, %B %#d%O, %Y', $date);
    else
      return string_change_case(utf8_encode(strftime('%A %#d'.date_french_ordinal($date).' %B %Y', $date)), "initials");
  }

  // Treat this situation differently if the day needs to be stripped
  else if($strip_day == 1)
  {
    if($lang == 'EN')
      return date_better_strftime('%B %#d%O, %Y', $date);
    else
      return utf8_encode(strftime('%#d'.date_french_ordinal($date), $date).' '.string_change_case(strftime('%B %Y', $date), "initials"));
  }

  // And differently aswell if the full day is being stripped
  else
  {
    if($lang == 'EN')
      return date_better_strftime('%B %Y', $date);
    else
      return string_change_case(utf8_encode(strftime('%B %Y', $date)), "initials");
  }
}




/**
 * Converts a mysql date to the DD/MM/YY format.
 *
 * MySQL gives us dates in the YYYY-MM-DD format, and we often want to display them in the DD/MM/YY format.
 * If any american reading this is unhappy with my use of DD/MM/YY over MM/DD/YY, sorry not sorry get used to it :)
 * If no date is specified or the mysql date is '0000-00-00', then we return nothing.
 *
 * @param   string  $date The MySQL date that will be converted.
 *
 * @return  string|null   The converted MySQL date.
 */

function date_to_ddmmyy($date)
{
  // If the date is not set or '0000-00-00', return null
  if(!$date || $date == '0000-00-00')
    return NULL;

  // Else, return the date in the DD/MM/YY format
  return date('d/m/y',strtotime($date));
}




/**
 * Converts a date to the mysql date format.
 *
 * MySQL stores dates in the YYYY-MM-DD format, and user input is often in DD/MM/YY, so we have to adapt to it.
 * This function's goal is to directly transform user input into a ready to use MySQL formatted date string.
 * If the person entering the date is american and inputs MM/DD/YY, well, too bad. Can't do anything about it.
 *
 * @param   string  $date The date that will be converted - can be DD/MM/YY or DD/MM/YYYY.
 *
 * @return  string        The converted date in MySQL date format.
 */

function date_to_mysql($date)
{
  // If the date is DD/MM/YYYY, convert it to the correct format
  if(strlen($date) == 10)
    $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

  // Same thing if the date is DD/MM/YY
  else if(strlen($date) == 8)
    $date = date('Y-m-d', strtotime(substr($date,6,2).'-'.substr($date,3,2).'-'.substr($date,0,2)));

  // Otherwise, return the absence of a MySQL date
  else
    return '0000-00-00';

  // If the converted date is incorrect, also return the absence of a MySQL date
  if($date == '1970-01-01')
    return '0000-00-00';

  // Return the converted date
  return $date;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   LINK BUILDING                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

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



/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             HTML OUTPUT MANIPULATION                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Makes the content of meta tags valid.
 *
 * Some characters are forbidden in HTML <meta> tags, this function replaces them with their valid equivalent.
 * Note that I am not even sure this is the proper way to do things... I'm just hoping it's right.
 *
 * @param   string  $string A string to turn meta-tag-valid.
 *
 * @return  string          The meta-tag-valid string.
 */

function html_fix_meta_tags($string)
{
  // Replace illegal characters by their legal counterparcs
  $string = str_replace("'","&#39;",$string);
  $string = str_replace("\"","&#34;",$string);
  $string = str_replace("<","&#60;",$string);
  $string = str_replace(">","&#62;",$string);
  $string = str_replace("{","&#123;",$string);
  $string = str_replace("}","&#125;",$string);
  $string = str_replace("[","&#91;",$string);
  $string = str_replace("]","&#93;",$string);
  $string = str_replace("(","&#40;",$string);
  $string = str_replace(")","&#41;",$string);

  // Return the modified string
  return $string;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   PAGE STYLING                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Returns the CSS classes to use for header menus.
 *
 * This gives different results based on whether an element is currently selected or not.
 *
 * @param string  $menu_element         The element of the menu for which we want CSS classes.
 * @param string  $current_menu_element The currently selected menu element (for the page in use).
 * @param string  $menu_type            The type of menu for which we want a styling (top or side menu).
 */

function header_menu_css($menu_element, $current_menu_element, $menu_type)
{
  // Main (top) menu
  if($menu_type == 'top')
    return (strtolower($menu_element) == strtolower($current_menu_element)) ? 'header_topmenu_title header_topmenu_selected' : 'header_topmenu_title';

  // Side menu
  else if($menu_type == 'side')
    return (strtolower($menu_element) == strtolower($current_menu_element)) ? 'header_sidemenu_item header_sidemenu_selected' : 'header_sidemenu_item';
}