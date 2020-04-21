<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                The functions in this file are global to the website and should always be included                 //
//     Most of them are used in the header, the footer, or are generic useful functions that any page might need     //
//                                                                                                                   //
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   GENERIC TOOLS                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Checks whether a row exists in a table.
 *
 * @param   string  $table  Name of the table.
 * @param   int     $id     ID of the row.
 *
 * @return  bool            Whether the row exists or not.
 */

function database_row_exists($table, $id)
{
  // Sanitize the data before running the query
  $table  = sanitize($table, 'string');
  $id     = sanitize($id, 'int', 0);

  // Check whether the row exists
  $dcheck = mysqli_fetch_array(query("  SELECT  ".$table.".id AS 'r_id'
                                        FROM    $table
                                        WHERE   ".$table.".id = '".$id."' "));

  // Return the result
  return ($dcheck['r_id']) ? 1 : 0;
}




/**
 * Is the page being fetched dynamically.
 *
 * @return  bool  Whether the page is being called through fetch or not.
 */

function page_is_fetched_dynamically()
{
  // Return whether the fetched header is set
  return isset($_SERVER['HTTP_FETCHED']);
}




/**
 * Throws a 404 if the page is not being fetched dynamically.
 *
 * @param   string|null $path The path to the root of the website (defaults to 2 folders away from root).
 *
 * @return  void
 */

function page_must_be_fetched_dynamically($path='./../../')
{
  // If the fetched header is not set, throw a 404
  if(!page_is_fetched_dynamically())
    exit(header("Location: ".$path."404"));
}




/**
 * Checks whether a specific file has been included.
 *
 * @param   string  $file_name  The name of the file that should have been included.
 *
 * @return  bool                Whether the file has currently been included or not.
 */

function has_file_been_included($file_name)
{
  // Fetch all included files
  $included_files = get_included_files();

  // Check if the requested file has been included
  foreach($included_files as $included_file)
  {
    // If the file has been included, return 1
    if(basename($included_file) == $file_name)
      return 1;
  }

  // If the file has not been included, return 0
  return 0;
}




/**
 * Requires a file to be included or exits the script.
 *
 * @param   string  $file_name  The name of the file that must be included.
 *
 * @return  void
 */

function require_included_file($file_name)
{
  // If the file has not been included, exit the script
  if(!has_file_been_included($file_name))
    exit($file_name.' is required for this page to work as intended');
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                STRING MANIPULATION                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Truncates a string if it is longer than a specified length.
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
/*                                         SEARCHING AND DIFFERENCE CHECKING                                         */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Returns a raw diff between two string arrays.
 *
 * This function is a prerequisite for the more useful diff_strings() function to work properly.
 * The core logic was taken from Paul Butler's simplediff through arrays method @ https://github.com/paulgb/simplediff.
 *
 * @param   array $old  An array of strings, the older version of the texts being compared.
 * @param   array $new  An array of strings, the newer version of the texts being compared.
 *
 * @return  array       An array of strings, showcasing the differences between the two arrays of strings.
 */

function diff_raw_string_arrays($old, $new)
{
  // Prepare the variables
  $matrix = array();
  $maxlen = 0;

  // Finds the largest substring in common between the two arrays
  foreach($old as $oindex => $ovalue)
  {
    $nkeys = array_keys($new, $ovalue);
    foreach($nkeys as $nindex)
    {
      $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
        $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
      if($matrix[$oindex][$nindex] > $maxlen){
        $maxlen = $matrix[$oindex][$nindex];
        $omax = $oindex + 1 - $maxlen;
        $nmax = $nindex + 1 - $maxlen;
      }
    }
  }

  // If a difference has been found, return it in an array of arrays of strings
  // The deleted content is in an array called 'd', and the inserted content in an array called 'i'
  if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));

  // As long as there are differences, run this function recursively until all differences are identified
  // Content without differences is returned at the root of the returned array, not within a 'd' or 'i' sub-array
  return array_merge(
    diff_raw_string_arrays(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
    array_slice($new, $nmax, $maxlen),
    diff_raw_string_arrays(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
  );
}




/**
 * Returns a human readable list of differences between two strings.
 *
 * The differences are treated word by word and not character by character.
 * The output contains HTML tags, as we use <del> and <ins> to highlight the differences.
 * The core logic was taken from Paul Butler's simplediff through arrays method @ https://github.com/paulgb/simplediff.
 *
 * @param   string $old  The older version of the texts being compared.
 * @param   string $new  The newer version of the texts being compared.
 *
 * @return  string       Human readable list of differences between the two arrays.
 */

function diff_strings($old, $new)
{
  // Break both strings in arrays of words, then run diff_raw_string_arrays() on them
  $diff = diff_raw_string_arrays(preg_split("/[\s]+/", $old), preg_split("/[\s]+/", $new));

  // Initialize the future returned string
  $return = '';

  // Walk through the array of differences returned by diff_raw_string_arrays()
  foreach($diff as $k)
  {
    // If the element is an array, then there is a difference - wrap it between <del> or <ins> tags
    if(is_array($k))
        $return .= (!empty($k['d'])?" <del> ".implode(' ',$k['d'])." </del> ":'').(!empty($k['i'])?" <ins> ".implode(' ',$k['i'])." </ins> ":'');
    // Otherwise there's no difference, leave it as is
    else
      $return .= $k . ' ';
  }

  // Return the recomposed string
  return $return;
}




/**
 * Searches for a string in a text, along with the words surrounding said string.
 *
 * @param   string    $search                       The string being searched.
 * @param   string    $text                         The text in which to search for the string.
 * @param   int|null  $nb_words_around  (OPTIONAL)  Number of words around the string to return.
 *
 * @return  string                                  The searched string and the words around it (or an empty string).
 */

function search_string_context($search, $text, $nb_words_around=1)
{
  // Escape special characters
  $search = preg_quote($search, '/');
  $text   = preg_quote($text, '/');

  // Split the text into an array of words and make them all lowercase (this way the search becomes case insensitive)
  $words = preg_split('/\s+/u', string_change_case($text, 'lowercase'));

  // Search for the string in the array of words, and mark its positions in an array if found
  $fetch_words      = preg_grep("/".string_change_case($search, 'lowercase').".*/", $words);
  $words_positions  = array_keys($fetch_words);

  // Split the text into an array of words again, but without changing case this time
  $words = preg_split('/\s+/u', $text);

  // If the string has been found, fetch its first position
  if(count($words_positions))
    $position = $words_positions[0];

  // If the string has not been found, return an empty string
  if(!isset($position))
    return '';

  // Fetch the start and end positions based on the number of words that should be wrapped around the result
  $start  = (($position - $nb_words_around) > 0) ? $position - $nb_words_around : 0;
  $end    = ((($position + ($nb_words_around + 1)) < count($words)) ? $position + ($nb_words_around + 1) : count($words)) - $start;

  // Purge the useless array contents, keeping only the needed words (anything between start and end positions)
  $slice  = array_slice($words, $start, $end);

  // If needed, add suspension points at the beginning and/or end of the array
  $start  = ($start > 0) ? "..." : "";
  $end    = ($position + ($nb_words_around + 1) < count($words)) ? "..." : "";

  // Assemble this array of words into a string and return it
  return stripslashes($start.implode(' ', $slice).$end);
}




/**
 * Wraps HTML tags around every occurence of a string in a text.
 *
 * @param   string  $search     The string being searched.
 * @param   string  $text       The text in which the string is being searched.
 * @param   string  $open_tag   The tag to place before each occurence of the string.
 * @param   string  $close_tag  The tag to place after each occurence oft he string.
 *
 * @return  string              The result of the operation.
 */

function string_wrap_in_html_tags($search, $text, $open_tag, $close_tag)
{
  // Escape special characters
  $search = preg_quote($search, '/');
  $text   = preg_quote($text, '/');

  // Use a regex to do the trick and return the result
  return stripslashes(preg_replace("/($search)/i", "$open_tag$1$close_tag", $text));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 PRIVATE MESSAGES                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Sends a private message to an user.
 *
 * @param   string    $title                        The message's title.
 * @param   string    $body                         The message's body.
 * @param   int|null  $recipient        (OPTIONAL)  The ID of the user which gets the message - if 0, current user.
 * @param   int|null  $sender           (OPTIONAL)  The ID of the suer sending the message - if 0, system notification.
 * @param   bool|null $is_silent        (OPTIONAL)  If set, the message arrives as already read.
 * @param   bool|null $do_not_sanitize  (OPTIONAL)  If set, the data will not be sanitized.
 *
 * @return  bool                                    Whether the message was sent or not.
 */

function private_message_send($title, $body, $recipient=0, $sender=0, $is_silent=0, $do_not_sanitize=0)
{
  // If there is no recipient and current user is not logged in, no message should be sent
  if(!$recipient && !user_is_logged_in())
    return 0;

  // Sanitize and prepare the data
  $title      = ($do_not_sanitize) ? $title : sanitize($title, 'string');
  $body       = ($do_not_sanitize) ? $body : sanitize($body, 'string');
  $recipient  = ($recipient) ? sanitize($recipient, 'int', 0) : sanitize(user_get_id(), 'int', 0);
  $sender     = sanitize($sender, 'int', 0);
  $sent_at    = sanitize(time(), 'int', 0);
  $read_at    = ($is_silent) ? sanitize(time(), 'int', 0) : 0;

  // If the recipient does not exist, do not send the message
  if(!database_row_exists('users', $recipient))
    return 0;

  // If the sender does not exist, do not send the message either
  if($sender && !database_row_exists('users', $sender))
    return 0;

  // Send the message by inserting a new row in the private messages table
  query(" INSERT INTO   users_private_messages
          SET           users_private_messages.fk_users_recipient = '$recipient'  ,
                        users_private_messages.fk_users_sender    = '$sender'     ,
                        users_private_messages.sent_at            = '$sent_at'    ,
                        users_private_messages.read_at            = '$read_at'    ,
                        users_private_messages.title              = '$title'      ,
                        users_private_messages.body               = '$body'       ");

  // Return 1 to show the message was sent
  return 1;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                ACTIVITY MANAGEMENT                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Throws an error if the user is currently flooding the website, then updates the last activity date.
 *
 * Keep in mind, since an error is being thrown, this interrupts the rest of the process of the page.
 *
 * @param   string|null $path       (OPTIONAL)  The path to the root of the website (defaults to 2 folders from root).
 * @param   int|null    $user_id    (OPTIONAL)  Specifies the ID of the user to check - if null, current user.
 * @param   string|null $lang       (OPTIONAL)  The language to use for the error - if null, current user's language.
 *
 * @return  bool                                Is the user allowed to post content to the website.
 */

function flood_check($path='./../../', $user_id=null, $lang=null)
{
  // Fetch the user's language if required
  $lang = (!$lang) ? user_get_language() : $lang;

  // If the user is logged out, then he shouldn't be able to do any actions: throw an error
  if(is_null($user_id) && !user_is_logged_in())
    error_page(__('error_flood_login'), $path, $lang);

  // Fetch and sanitize the user's ID
  $user_id = (!is_null($user_id)) ? $user_id : user_get_id();
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch the user's recent activity
  $dactivity = mysqli_fetch_array(query(" SELECT  users.last_action_at AS 'u_last'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // If the last activity for the user happened less than 10 seconds ago, throw an error
  $timestamp = time();
  if(($timestamp - $dactivity['u_last']) <= 10 )
    error_page(__('error_flood_wait'), $path, $lang);

  // Update the last activity of the user
  query(" UPDATE  users
          SET     users.last_action_at  = '$timestamp'
          WHERE   users.id              = '$user_id' ");
}




/**
 * Adds an entry to the recent activity logs.
 *
 * @param   string          $activity_type                      The identifier of the activity log's type.
 * @param   bool|null       $is_administrators_only (OPTIONAL)  Is it a public activity log or a moderation log.
 * @param   string|null     $language               (OPTIONAL)  The language(s) in which the log should appear.
 * @param   int|null        $activity_id            (OPTIONAL)  ID of the item linked to the activity log.
 * @param   string|null     $activity_summary_en    (OPTIONAL)  Summary of the activity log, in english.
 * @param   string|null     $activity_summary_fr    (OPTIONAL)  Summary of the activity log, in french.
 * @param   int|null        $activity_amount        (OPTIONAL)  An amout tied to the activity log.
 * @param   int|null        $fk_users               (OPTIONAL)  ID of the user implicated in the activity log.
 * @param   string|null     $nickname               (OPTIONAL)  Nickname of the user implicated in the activity log.
 * @param   string|null     $moderator_nickname     (OPTIONAL)  Nickname of the website admin implicated in the log.
 * @param   string|null     $moderation_reason      (OPTOINAL)  Reason specified by the moderator for the activity.
 * @param   bool|null       $do_not_sanitize        (OPTOINAL)  If set, do not sanitize the data.
 *
 * @return  int                                                 The ID of the newly inserted activity log.
 */

function log_activity($activity_type, $is_administrators_only=0, $language='ENFR', $activity_id=0, $activity_summary_en=NULL, $activity_summary_fr=NULL, $activity_amount=0, $fk_users=0, $nickname=NULL, $moderator_nickname=NULL, $moderation_reason=NULL, $do_not_sanitize=0)
{
  // Sanitize and prepare the data
  $timestamp              = sanitize(time(), 'int', 0);
  $activity_type          = sanitize($activity_type, 'string');
  $is_administrators_only = sanitize($is_administrators_only, 'int', 0, 1);
  $language               = ($do_not_sanitize) ? $language : sanitize($language, 'string');
  $activity_id            = sanitize($activity_id, 'int', 0);
  $activity_summary_en    = ($do_not_sanitize) ? $activity_summary_en : sanitize($activity_summary_en, 'string');
  $activity_summary_fr    = ($do_not_sanitize) ? $activity_summary_fr : sanitize($activity_summary_fr, 'string');
  $activity_amount        = sanitize($activity_amount, 'int');
  $fk_users               = sanitize($fk_users, 'int', 0);
  $nickname               = ($do_not_sanitize) ? $nickname : sanitize($nickname, 'string');
  $moderator_nickname     = ($do_not_sanitize) ? $moderator_nickname : sanitize($moderator_nickname, 'string');
  $moderation_reason      = ($do_not_sanitize) ? $moderation_reason : sanitize($moderation_reason, 'string');

  // Create the activity log by inserting it in the table
  query(" INSERT INTO logs_activity
          SET         logs_activity.fk_users                    = '$fk_users'               ,
                      logs_activity.happened_at                 = '$timestamp'              ,
                      logs_activity.is_administrators_only      = '$is_administrators_only' ,
                      logs_activity.language                    = '$language'               ,
                      logs_activity.activity_type               = '$activity_type'          ,
                      logs_activity.activity_id                 = '$activity_id'            ,
                      logs_activity.activity_amount             = '$activity_amount'        ,
                      logs_activity.activity_summary_en         = '$activity_summary_en'    ,
                      logs_activity.activity_summary_fr         = '$activity_summary_fr'    ,
                      logs_activity.activity_nickname           = '$nickname'               ,
                      logs_activity.activity_moderator_nickname = '$nickname'               ,
                      logs_activity.moderation_reason           = '$moderation_reason'      ");

  // Return the ID of the newly created activity log
  return(query_id());
}




/**
 * Adds an entry to the recent activity detailed logs.
 *
 * @param   int         $linked_activity_log              ID of the recent activity log to which this is linked.
 * @param   string      $description_en                   Description of the detailed activity log, in english.
 * @param   string      $description_fr                   Description of the detailed activity log, in french.
 * @param   string      $before                           Previous value of the content.
 * @param   string|null $after                (OPTIONAL)  Current value of the content.
 * @param   bool|null   $optional             (OPTIONAL)  The log will only be created if before / after are different.
 * @param   bool|null   $do_not_sanitize      (OPTOINAL)  If set, do not sanitize the data.
 *
 * @return  void
 */

function log_activity_details($linked_activity_log, $description_en, $description_fr, $before, $after=NULL, $optional=0, $do_not_sanitize = 0)
{
  // If there are no differences, do not create a detailed activity log
  if($optional && ($before == $after))
    return 0;

  // In order to avoid strain caused by the diff functions, do not create a diff log if $after is too long
  $after = (strlen($after) > 10000) ? NULL : $after;

  // Sanitize the data if required
  $linked_activity_log  = sanitize($linked_activity_log, 'int', 0);
  $description_en       = ($do_not_sanitize) ? $description_en : sanitize($description_en, 'string');
  $description_fr       = ($do_not_sanitize) ? $description_fr : sanitize($description_fr, 'string');
  $before               = ($do_not_sanitize) ? $before : sanitize($before, 'string');
  $after                = ($do_not_sanitize) ? $after : sanitize($after, 'string');

  // Create the detailed log
  query(" INSERT INTO logs_activity_details
          SET         logs_activity_details.fk_logs_activity        = '$linked_activity_log'  ,
                      logs_activity_details.content_description_en  = '$description_en'       ,
                      logs_activity_details.content_description_fr  = '$description_fr'       ,
                      logs_activity_details.content_before          = '$before'               ,
                      logs_activity_details.content_after           = '$after'                ");
}




/**
 * Deletes all orphan entries in the detailed activity logs.
 *
 * This will remove all entries in thes logs_activity_details table which have no linked entry in logs_activity.
 *
 * @return  void
 */

function log_activity_purge_orphan_diffs()
{
  // Fetch all orphan diffs
  $qorphans = query(" SELECT    logs_activity_details.id AS 'd_id'
                      FROM      logs_activity_details
                      LEFT JOIN logs_activity ON logs_activity_details.fk_logs_activity = logs_activity.id
                      WHERE     logs_activity.id IS NULL ");

  // Stealthily choke them to death
  while($dorphans = mysqli_fetch_array($qorphans))
  {
    $orphan_id = sanitize($dorphans['d_id'], 'int', 0);
    query(" DELETE FROM logs_activity_details
            WHERE       logs_activity_details.id = '$orphan_id' ");
  }
}




/**
 * Soft deletes an entry in the activity logs.
 *
 * @param   string          $activity_type                      The identifier of the activity log's type.
 * @param   bool|null       $is_administrators_only (OPTIONAL)  Is it a public activity log or a moderation log.
 * @param   int|null        $fk_users               (OPTIONAL)  ID of the user implicated in the activity log.
 * @param   string|null     $nickname               (OPTIONAL)  Nickname of the user implicated in the activity log.
 * @param   int|null        $activity_id            (OPTIONAL)  ID of the item linked to the activity log.
 * @param   bool|null       $global_type_wipe       (OPTOINAL)  Deletes all logs of type beginning like $activity_type.
 *
 * @return  void
 */

function log_activity_delete($activity_type, $is_administrators_only=0, $fk_users=0, $nickname=NULL, $activity_id=0, $global_type_wipe=0)
{
  // Begin by sanitizing the data
  $activity_type          = sanitize($activity_type, 'string');
  $is_administrators_only = sanitize($is_administrators_only, 'int', 0, 1);
  $fk_users               = sanitize($fk_users, 'int', 0);
  $nickname               = sanitize($nickname, 'string');
  $activity_id            = sanitize($activity_id, 'int', 0);
  $global_type_wipe       = sanitize($global_type_wipe, 'int', 0, 1);

  // Begin building the query
  $qactivity    = " UPDATE      logs_activity
                    SET         logs_activity.is_deleted = 1 ";

  // Depending on whether this is a global type wipe or not, do a different kind of string matching
  if(!$global_type_wipe)
    $qactivity .= " WHERE       logs_activity.activity_type           LIKE  '$activity_type' ";
  else
    $qactivity .= " WHERE       logs_activity.activity_type           LIKE  '$activity_type%' ";

  // Treat public and private logs separately
  $qactivity .= "   AND         logs_activity.is_administrators_only  =     '$is_administrators_only' ";

  // Optional parameters
  if($fk_users)
    $qactivity .= " AND         logs_activity.fk_users                =     '$fk_users' ";
  if($nickname)
    $qactivity .= " AND         logs_activity.activity_nickname       LIKE  '$nickname' ";
  if($activity_id)
    $qactivity .= " AND         logs_activity.activity_id             =     '$activity_id' ";

  // Run the query and delete the activity
  query($qactivity);

  // Purge all orphaned detailed activity logs
  log_activity_purge_orphan_diffs();
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      IRC BOT                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Uses the IRC bot to broadcast a message.
 *
 * @param   string      $message                              The message to send.
 * @param   string|null $channel                  (OPTIONAL)  The IRC channel on which the message should be sent.
 * @param   string|null $path                     (OPTIONAL)  Path to the website root (defaults to 2 folders away).
 * @param   bool|null   $allow_special_formatting (OPTIONAL)  Allow IRC formatting characters in the message.
 *
 * @return  bool                                              Whether the message has been queued in the bot's file.
 */

function ircbot($message, $channel=NULL, $path='./../../', $allow_special_formatting=0)
{
  // Sanitize the message for IRC usage
  $message = str_replace("\\n", '', $message);
  $message = str_replace("\\r", '', $message);
  $message = str_replace("\\t", '', $message);

  // If allowed, apply special formatting to the message
  if($allow_special_formatting)
  {
    // Swap special characters for bytes
    $message = str_replace('%O',chr(0x0f),$message);        // Reset
    $message = str_replace('%B',chr(0x02),$message);        // Bold
    $message = str_replace('%I',chr(0x1d),$message);        // Italics
    $message = str_replace('%U',chr(0x1f),$message);        // Underline
    $message = str_replace('%C00',chr(0x03).'00',$message); // Color: White
    $message = str_replace('%C01',chr(0x03).'01',$message); // Color: Black
    $message = str_replace('%C02',chr(0x03).'02',$message); // Color: Blue
    $message = str_replace('%C03',chr(0x03).'03',$message); // Color: Green
    $message = str_replace('%C04',chr(0x03).'04',$message); // Color: Red
    $message = str_replace('%C05',chr(0x03).'05',$message); // Color: Brown
    $message = str_replace('%C06',chr(0x03).'06',$message); // Color: Purple
    $message = str_replace('%C07',chr(0x03).'07',$message); // Color: Orange
    $message = str_replace('%C08',chr(0x03).'08',$message); // Color: Yellow
    $message = str_replace('%C09',chr(0x03).'09',$message); // Color: Light green
    $message = str_replace('%C10',chr(0x03).'10',$message); // Color: Teal
    $message = str_replace('%C11',chr(0x03).'11',$message); // Color: Light cyan
    $message = str_replace('%C12',chr(0x03).'12',$message); // Color: Ligh blue
    $message = str_replace('%C13',chr(0x03).'13',$message); // Color: Pink
    $message = str_replace('%C14',chr(0x03).'14',$message); // Color: Grey

    // Custom made bytes
    $message = str_replace('%NB',chr(0x02).chr(0x03).'00,01',$message);              // Bold white on black
    $message = str_replace('%TROLL',chr(0x1f).chr(0x02).chr(0x03).'08,13',$message); // Bold underlined yellow on green
  }

  // If the file can be written in, then queue a message in it
  if($fichier_ircbot = fopen($path.'ircbot.txt', "a"))
  {
    // Depending on whether a channel is specifiied, the message is sent to the server or to a channel
    if(!$channel)
      file_put_contents($path.'ircbot.txt', time()." ".substr($message,0,450).PHP_EOL, FILE_APPEND);
    else
      file_put_contents($path.'ircbot.txt', time()." PRIVMSG ".$channel." :".substr($message,0,450).PHP_EOL, FILE_APPEND);

    // Close the IRCbot file
    fclose($fichier_ircbot);

    // Return 1 now that the work is done
    return 1;
  }
  // If the file can't be written in, return 0
  else
    return 0;
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