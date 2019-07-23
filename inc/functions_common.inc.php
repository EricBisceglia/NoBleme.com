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
  // If we need to truncate the string, then we do it and apply the suffix - else, we return the string as is
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
  // We add an extra parameter to strftime using the date standard function
  $format = str_replace('%O', date('S', $timestamp), $format);

  // We return the formatted output
  return strftime($format, $timestamp);
}




/**
 * Returns the french ordinal value of a number.
 *
 * Because date is not locale aware and strftime lacks some functionalities, we'll need to do some extra work here...
 * If we want ordinal numbers in dates in both french and english, we'll need to be able to return french ordinals.
 *
 * @param   int     $timestamp  The timestamp of the date we want to ordinalize.
 *
 * @return  string              The formatted output.
 */

function date_french_ordinal($timestamp)
{
  // We get the full day from the timestamp
  $full_day = date('d', $timestamp);

  // If the full day is 1, we return an ordinal. Else, we don't. French is simple with dates, isn't it?
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
 * @param   string|null     $lang       The language in which we want to display the result.
 * @param   int|null        $strip_day  If 1, strips the day's name. If 2, strips the whole day.
 *
 * @return  string                      The required date, in plaintext.
 */

function date_to_text($date=NULL, $lang="EN", $strip_day=0)
{
  // If no date has been entered, we use the current timestamp instead
  $date = (!$date) ? time() : $date;

  // If we are dealing with a MySQL date, we transform it into a timestamp
  $date = (!is_numeric($date)) ? strtotime($date) : $date;

  // We set the correct locale for times
  if($lang == 'EN')
    setlocale(LC_TIME, "en_US.UTF-8", 'eng');
  else
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

  // We can now return the formatted date - each language has its own date formatting rules
  if(!$strip_day)
  {
    if($lang == 'EN')
      return date_better_strftime('%A, %B %#d%O, %Y', $date);
    else
      return string_change_case(strftime('%A %#d'.date_french_ordinal($date).' %B %Y', $date), "initials");
  }

  // We need to also treat this situation differently if we are stripping part of the day
  else if($strip_day == 1)
  {
    if($lang == 'EN')
      return date_better_strftime('%B %#d%O, %Y', $date);
    else
      return strftime('%#d'.date_french_ordinal($date), $date).' '.string_change_case(strftime('%B %Y', $date), "initials");
  }

  // And differently aswell if we are stripping the full day
  else
  {
    if($lang == 'EN')
      return date_better_strftime('%B %Y', $date);
    else
      return string_change_case(strftime('%B %Y', $date), "initials");
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
  // If the date is not set or '0000-00-00', then we return null
  if(!$date || $date == '0000-00-00')
    return NULL;

  // Else, we return the date in the DD/MM/YY format
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
  // If the date is DD/MM/YYYY, we convert it to the correct format
  if(strlen($date) == 10)
    $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

  // Same thing if the date is DD/MM/YY
  else if(strlen($date) == 8)
    $date = date('Y-m-d', strtotime(substr($date,6,2).'-'.substr($date,3,2).'-'.substr($date,0,2)));

  // Otherwise, we return the absence of a MySQL date
  else
    return '0000-00-00';

  // If the converted date is incorrect, then we also return the absence of a MySQL date
  if($date == '1970-01-01')
    return '0000-00-00';

  // We can now return the converted date
  return $date;
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
  // We replace illegal characters by their legal counterparcs
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

  // And we return the modified string
  return $string;
}