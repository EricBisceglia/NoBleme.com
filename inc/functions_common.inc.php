<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  root_path                           Returns the path to the root of the website                                  */
/*                                                                                                                   */
/*  database_row_exists                 Checks whether a row exists in a table.                                      */
/*  database_entry_exists               Checks whether an entry exists in a table.                                   */
/*                                                                                                                   */
/*  system_variable_fetch               Fetches a system variable's value.                                           */
/*  system_variable_update              Updates a system variable's value.                                           */
/*                                                                                                                   */
/*  system_assemble_version_number      Assembles a version number in accordance with SemVer 2.0.0 specification.    */
/*  system_get_current_version_number   Returns information about the current version number.                        */
/*                                                                                                                   */
/*  page_is_fetched_dynamically         Is the page being fetched dynamically.                                       */
/*  page_must_be_fetched_dynamically    Throws a 404 if the page is not being fetched dynamically.                   */
/*                                                                                                                   */
/*  has_file_been_included              Checks whether a specific file has been included.                            */
/*  require_included_file               Requires a file to be included or exits the script.                          */
/*                                                                                                                   */
/*  form_fetch_element                  Fetches the unsanitized value or returns the existence of submitted user data*/
/*                                                                                                                   */
/*  string_truncate                     Truncates a string if it is longer than a specified length.                  */
/*  string_change_case                  Changes the case of a string.                                                */
/*  string_remove_accents               Removes accentuated latin characters from a string.                          */
/*  string_increment                    Increments the last character of a string.                                   */
/*                                                                                                                   */
/*  date_to_text                        Transforms a MySQL date or a timestamp into a plaintext date.                */
/*  date_to_ddmmyy                      Converts a mysql date to the DD/MM/YY format.                                */
/*  date_to_mysql                       Converts a date to the mysql date format.                                    */
/*                                                                                                                   */
/*  diff_raw_string_arrays              Returns a raw diff between two string arrays.                                */
/*  diff_strings                        Returns a human readable list of differences between two strings.            */
/*                                                                                                                   */
/*  search_string_context               Searches for a string in a text, along with the words surrounding said string*/
/*  string_wrap_in_html_tags            Wraps HTML tags around every occurence of a string in a text.                */
/*                                                                                                                   */
/*  page_section_selector               Initializes the use of a page section selector.                              */
/*                                                                                                                   */
/*  private_message_send                Sends a private message to a user.                                           */
/*                                                                                                                   */
/*  flood_check                         Throws an error if the user is currently flooding the website,               */
/*                                      then updates the last activity date.                                         */
/*                                                                                                                   */
/*  log_activity                        Adds an entry to the recent activity logs.                                   */
/*  log_activity_details                Adds an entry to the recent activity detailed logs.                          */
/*  log_activity_purge_orphan_diffs     Deletes all orphan entries in the detailed activity logs.                    */
/*  log_activity_delete                 Soft deletes an entry in the activity logs.                                  */
/*                                                                                                                   */
/*  irc_bot_send_message                Uses the IRC bot to broadcast a message.                                     */
/*                                                                                                                   */
/*  discord_send_message                Uses a Discord webhook to broadcast a message.                               */
/*                                                                                                                   */
/*********************************************************************************************************************/


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   GENERIC TOOLS                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Returns the path to the root of the website.
 *
 * @return  string  The path to the root of the website.
 */

function root_path() : string
{
  // Define where to look for URLs: account for the two slashes in http://, then add extra folders from local settings
  $uri_base_slashes = 2 + $GLOBALS['extra_folders'];

  // Check how far removed from the project root the current path is
  $uri_length = count(explode( '/', $_SERVER['REQUEST_URI']));

  // If we are at the project root, then there is no $path
  if($uri_length <= $uri_base_slashes)
    $path = "";

  // Otherwise, increment the $path for each folder that must be ../ until reaching the root at ./
  else
  {
    $path = "./";
    for ($i = 0 ; $i < ($uri_length - $uri_base_slashes) ; $i++)
      $path .= "../";
  }

  // Return the current root path
  return $path;
}




/**
 * Checks whether a row exists in a table.
 *
 * @param   string  $table  Name of the table.
 * @param   int     $id     ID of the row.
 *
 * @return  bool            Whether the row exists or not.
 */

function database_row_exists( string  $table  ,
                              int     $id     ) : bool
{
  // Sanitize the data before running the query
  $table  = sanitize($table, 'string');
  $id     = sanitize($id, 'int', 0);

  // Check whether the row exists
  $dcheck = mysqli_fetch_array(query("  SELECT  $table.id AS 'r_id'
                                        FROM    $table
                                        WHERE   $table.id = '$id' "));

  // Return the result
  return (isset($dcheck['r_id']));
}




/**
 * Checks whether an entry exists in a table.
 *
 * @param   string  $table                  Name of the table.
 * @param   string  $field                  Name of the field.
 * @param   mixed   $value                  Data value to look for.
 * @param   bool    $sanitize  (OPTIONAL)   Sanitize the value before looking it up.
 *
 * @return  int                             The id of the row containing the entry, or 0 if it does not exist.
 */

function database_entry_exists( string  $table            ,
                                string  $field            ,
                                mixed   $value            ,
                                bool    $sanitize = false ) : int
{
  // Sanitize the data before running the query
  $table  = sanitize($table, 'string');
  $field  = sanitize($field, 'string');
  $value  = ($sanitize) ? sanitize($value, 'string') : $value;

  // Check whether the entry exists
  $dcheck = mysqli_fetch_array(query("  SELECT  $table.id AS 'r_id'
                                        FROM    $table
                                        WHERE   $table.$field = '$value' "));

  // Return the result
  return (isset($dcheck['r_id'])) ? $dcheck['r_id'] : 0;
}




/**
 * Fetches a system variable's value.
 *
 * @param   string  $var_name   Name of the system variable.
 *
 * @return  mixed               The value of the variable, or null if it doesn't exist.
 */

function system_variable_fetch( string $var_name ) : mixed
{
  // Sanitize the data before running the query
  $var_name = sanitize($var_name, 'string');

  // Fetch the list of global variables
  $qdescribe = query(" DESCRIBE system_variables");

  // Run through the list of global variables
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    // If the variable exists, fetch its value and return it
    if($ddescribe['Field'] == $var_name)
    {
      $dvar = mysqli_fetch_array(query("  SELECT  system_variables.".$var_name." AS 'v_value'
                                          FROM    system_variables "));
      return ($dvar['v_value']);
    }
  }

  // If the variable does not exist, return null
  return null;
}




/**
 * Updates a system variable's value.
 *
 * @param   string  $var_name   Name of the system variable.
 * @param   string  $value      The value to give the system variable.
 * @param   string  $type       The variable type (int, float or string)
 *
 * @return  bool                1 if it went well, 0 if something went wrong.
 */

function system_variable_update(  string  $var_name ,
                                  string  $value    ,
                                  string  $type     ) : bool
{
  // Check that the variable type is allowed
  $type = sanitize($type, 'string');
  if(!in_array($type, array('int', 'float', 'string')))
    return 0;

  // Sanitize the data before running the query
  $var_name = sanitize($var_name, 'string');
  $value    = sanitize($value, $type);

  // Fetch the list of global variables
  $qdescribe = query(" DESCRIBE system_variables");

  // Run through the list of global variables
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    // If the variable exists, update its value and return 1
    if($ddescribe['Field'] == $var_name)
    {
      query(" UPDATE  system_variables
              SET     system_variables.".$var_name." = '$value' ");
      return 1;
    }
  }

  // If the variable does not exist, return null
  return 0;
}




/**
 * Assembles a version number in accordance with SemVer 2.0.0 specification.
 *
 * @param   string              $major      The major element of the version number.
 * @param   string              $minor      The minor element of the version number.
 * @param   string              $patch      The patch element of the version number.
 * @param   string  (OPTIONAL)  $extension  The extension (beta, rc-0, etc.).
 *
 * @return  string                          The assembled version number.
 */

function system_assemble_version_number(  string  $major          ,
                                          string  $minor          ,
                                          string  $patch          ,
                                          string  $extension = '' ) : string
{
  // Assemble the semver string
  $version  = $major.'.'.$minor.'.'.$patch;

  // Add the extension if provided
  $version  = ($extension) ? $version.'-'.$extension : $version;

  // Return the assembled string
  return $version;
}




/**
 * Returns information about the current version number.
 *
 * @param   string  (OPTIONAL)  $format The format of the returned data ('semver', 'full', 'array', 'next').
 *
 * @return  mixed               The current version number, in the chosen format.
 */

function system_get_current_version_number( string $format = 'semver' ) : mixed
{
  // Fetch the user's language
  $lang = user_get_language();

  // Fetch the latest version
  $dversion = mysqli_fetch_array(query("  SELECT    system_versions.major         AS 'v_major'      ,
                                                    system_versions.minor         AS 'v_minor'      ,
                                                    system_versions.patch         AS 'v_patch'      ,
                                                    system_versions.extension     AS 'v_extension'  ,
                                                    system_versions.release_date  AS 'v_date'
                                          FROM      system_versions
                                          ORDER BY  system_versions.release_date  DESC ,
                                                    system_versions.id            DESC
                                          LIMIT     1 "));

  // Full format: version + date
  if($format == 'full')
    return system_assemble_version_number($dversion['v_major'], $dversion['v_minor'], $dversion['v_patch'], $dversion['v_extension']).' - '.date_to_text($dversion['v_date'], 1, 0, $lang);

  // Array or next: all elements in an array (in case of next, prepare for the next version)
  if($format == 'array' || $format == 'next')
  {
    $patch      = ($format == 'next' && !$dversion['v_extension']) ? ($dversion['v_patch'] + 1) : $dversion['v_patch'];
    $extension  = ($format == 'next' && $dversion['v_extension']) ? string_increment($dversion['v_extension']) : $dversion['v_extension'];
    return array( 'major'     => $dversion['v_major']     ,
                  'minor'     => $dversion['v_minor']     ,
                  'patch'     => $patch                   ,
                  'extension' => $extension );
  }

  // Default format: standard semver
  else
    return system_assemble_version_number($dversion['v_major'], $dversion['v_minor'], $dversion['v_patch'], $dversion['v_extension']);
}




/**
 * Is the page being fetched dynamically.
 *
 * @return  bool  Whether the page is being called through fetch or not.
 */

function page_is_fetched_dynamically() : bool
{
  // Return whether the fetched header is set
  return isset($_SERVER['HTTP_FETCHED']);
}




/**
 * Throws a 404 if the page is not being fetched dynamically.
 *
 * @return void
 */

function page_must_be_fetched_dynamically() : void
{
  // Fetch the path to the website's root
  $path = root_path();

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

function has_file_been_included( string $file_name ) : bool
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

function require_included_file( string $file_name ) : void
{
  // If the file has not been included, exit the script
  if(!has_file_been_included($file_name))
    exit($file_name.' is required for this page to work as intended');
}




/**
 * Fetches the unsanitized value or returns the existence of submitted user data.
 *
 * @param   string  $element_name               The name of the element.
 * @param   mixed   $default_value  (OPTIONAL)  Value to return if the element does not exist.
 * @param   bool    $element_exists (OPTIONAL)  Only returns whether the element exists (eg. checkbox).
 * @param   string  $request_type   (OPTIONAL)  The type of request ('POST', 'GET', 'FILES').
 *
 * @return  mixed                               The unsanitized value of the element (or default).
 */

function form_fetch_element(  string  $element_name             ,
                              mixed   $default_value  = NULL    ,
                              bool    $element_exists = false   ,
                              string  $request_type   = 'POST'  ) : mixed
{
  // If the goal is only to check existence, just return whether the element exists or not
  if($element_exists)
  {
    if($request_type == 'GET')
      return (isset($_GET[$element_name]));
    else if($request_type == 'FILES')
      return (isset($_FILES[$element_name]));
    else
      return (isset($_POST[$element_name]));
  }

  // Otherwise return the unsanitized value of the element if it exists
  else
  {
    if($request_type == 'GET')
      return (isset($_GET[$element_name])) ? $_GET[$element_name] : $default_value;
    else if($request_type == 'FILES')
      return (isset($_FILES[$element_name])) ? $_FILES[$element_name] : $default_value;
    else
      return (isset($_POST[$element_name])) ? $_POST[$element_name] : $default_value;
  }
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                STRING MANIPULATION                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Truncates a string if it is longer than a specified length.
 *
 * @param   string  $string               The string that will be truncated.
 * @param   int     $length               The length above which the string will be truncated.
 * @param   string  $suffix   (OPTIONAL)  Appends text to the end of the string if it has been truncated.
 *
 * @return  string                        The string, truncated if necessary.
 */

function string_truncate( ?string $string       ,
                          int     $length       ,
                          string  $suffix = ''  ) : ?string
{
  // If the string needs to be truncated, then do it and apply the suffix, else return the string as is
  return (mb_strlen($string, 'UTF-8') > $length) ? mb_substr($string, 0, $length, 'UTF-8').$suffix : $string;
}




/**
 * Changes the case of a string.
 *
 * @param   string  $string   The string that will have its case changed.
 * @param   string  $case     The case to apply to the string ('uppercase', 'lowercase', 'initials')
 *
 * @return  string            The string, with its case changed.
 */

function string_change_case(  ?string $string ,
                              string  $case   ) : string
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

  // Return nothing otherwise
  else
    return '';
}




/**
 * Removes accentuated latin characters from a string.
 *
 * @param   string  $string   The string which is about to lose its latin accents.
 *
 * @return  string            The string, without its latin accents.
 */

function string_remove_accents( string $string ) : string
{
  // Simply enough, prepare two arrays: accents and their non accentuated equivalents
  $accents    = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
  $no_accents = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

  // Replace any occurence of the first set of characters by its equivalent in the second
  return str_replace($accents, $no_accents, $string);
}




/**
 * Increments the last character of a string.
 *
 * This is mainly meant to increment versioning strings (eg. rc1, beta3, etc.).
 * If the string does not end in a number, then the number 1 will be appended to the end of the string.
 *
 * @param   string  $string   The string to increment.
 *
 * @return  string            The incremented string.
 */

function string_increment( string $string ) : string
{
  // If the string is empty, return one
  if(!$string)
    return 1;

  // Get the last character of the string
  $last_character =  substr($string, -1);

  // If that character is a number, increment it
  if(is_numeric($last_character))
    return substr($string, 0, -1).($last_character + 1);

  // Otherwise, append an 1 to the end of the string
  return $string.'1';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             DATE FORMAT MANIPULATION                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Transforms a MySQL date or a timestamp into a plaintext date.
 *
 * MySQL gives us dates in the YYYY-MM-DD format, and we often want to display them in plaintext.
 * We store a lot of our dates in timestamps aswell, this function can work with a timestamp as an input too.
 * If no date is specified, it returns the current date instead.
 *
 * @param   string|int  $date           (OPTIONAL)  The MySQL date or timestamp that we want to transform.
 * @param   int         $strip_day      (OPTIONAL)  If 1, strips the day's name. If 2, strips the whole day.
 * @param   int         $include_time   (OPTIONAL)  If 1, will add the time after the date. If 2, strips seconds.
 * @param   bool        $strip_year     (OPTIONAL)  If set, omits the year from the returned data.
 * @param   string      $lang           (OPTIONAL)  The language used, defaults to current lang.
 *
 * @return  string                                  The required date, in plaintext.
 */

function date_to_text(  mixed   $date         = ''    ,
                        int     $strip_day    = 0     ,
                        int     $include_time = 0     ,
                        bool    $strip_year   = false ,
                        string  $lang         = ''    ) : string
{
  // If no date has been entered, use the current timestamp instead
  $date = (!$date) ? time() : $date;

  // If we are dealing with a MySQL date, transform it into a timestamp
  $date = (!is_numeric($date)) ? strtotime($date) : $date;

  // Fetch the user's language if none was specified
  $lang = (!$lang) ? user_get_language() : $lang;
  $lang = string_change_case($lang, 'lowercase');

  // Decompose the date
  $day      = date('j', $date);
  $weekday  = date('N', $date);
  $month    = date('n', $date);
  $year     = date('Y', $date);
  $time     = date('H:i', $date);
  $seconds  = date('s', $date);

  // Prepare an empty return string
  $return = '';

  // Add the plaintext day to the return string
  if(!$strip_day)
  {
    $return .= __('day_'.$weekday.'_'.$lang);
    $return .= ($lang == 'en') ? "," : "";
  }

  // Add the month to the return string if the date is in english
  if($lang == 'en')
    $return .= " ".__('month_'.$month.'_en');

  // Add the day's number to the return string
  if($strip_day < 2)
    $return .= " ".date('j', $date);

  // Add the day's ordinal to the return string
  if($strip_day < 2 && $lang == 'en')
  {
    $ordinal = __('ordinal_0_en');
    $ordinal = ($day == 1 || $day == 21 || $day == 31) ? __('ordinal_1_en') : $ordinal;
    $ordinal = (($day % 10) == 2) ? __('ordinal_2_en') : $ordinal;
    $ordinal = (($day % 10) == 3) ? __('ordinal_3_en') : $ordinal;
    $return .= $ordinal;
  }
  else if($strip_day < 2 && $lang == 'fr')
    $return .= ($day == 1) ? __('ordinal_1_fr') : '';

  // Add the month to the return string if the date is in french
  if($lang == 'fr')
    $return .= " ".string_change_case(__('month_'.$month.'_fr'), 'lowercase');

  // Add the year to the return string
  if(!$strip_year)
    $return .= " ".$year;

  // Add the time to the return string
  if($include_time)
  {
    $return .= " ".__('time_indicator_'.$lang);
    $return .= " ".$time;
    $return .= ($include_time == 1) ? ":".$seconds : '';
  }

  // Return the formatted date
  return $return;
}




/**
 * Converts a mysql date to the DD/MM/YY format.
 *
 * MySQL gives us dates in the YYYY-MM-DD format, and we often want to display them in the DD/MM/YY format.
 * If any american reading this is unhappy with my use of DD/MM/YY over MM/DD/YY, sorry not sorry get used to it :)
 * If no date is specified or the mysql date is '0000-00-00', then we return nothing.
 *
 * @param   string        $date   The MySQL date that will be converted.
 *
 * @return  string|null           The converted MySQL date.
 */

function date_to_ddmmyy( string $date ) : mixed
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
 * @param   string  $date     The date that will be converted - can be DD/MM/YY or DD/MM/YYYY.
 * @param   string  $default  The default date to use if the format is incorrect.
 *
 * @return  string            The converted date in MySQL date format.
 */

function date_to_mysql( string  $date                   ,
                        string  $default = '0000-00-00' ) : string
{
  // If the date is DD/MM/YYYY, convert it to the correct format
  if(strlen($date) == 10)
    $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

  // Same thing if the date is DD/MM/YY
  else if(strlen($date) == 8)
    $date = date('Y-m-d', strtotime(substr($date,6,2).'-'.substr($date,3,2).'-'.substr($date,0,2)));

  // Otherwise, return the absence of a MySQL date
  else
    return $default;

  // If the converted date is incorrect, also return the absence of a MySQL date
  if($date == '1970-01-01')
    return $default;

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
 * @param   array   $old  An array of strings, the older version of the texts being compared.
 * @param   array   $new  An array of strings, the newer version of the texts being compared.
 *
 * @return  array         An array of strings, showcasing the differences between the two arrays of strings.
 */

function diff_raw_string_arrays(  array $old  ,
                                  array $new  ) : array
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
 * @param   string  $old  The older version of the texts being compared.
 * @param   string  $new  The newer version of the texts being compared.
 *
 * @return  string        Human readable list of differences between the two arrays.
 */

function diff_strings(  string  $old  ,
                        string  $new  ) : string
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
 * @param   string  $search                       The string being searched.
 * @param   string  $text                         The text in which to search for the string.
 * @param   int     $nb_words_around  (OPTIONAL)  Number of words to show around the string.
 *
 * @return  string                                The searched string and the words around it (or an empty string).
 */

function search_string_context( string  $search               ,
                                string  $text                 ,
                                int     $nb_words_around = 1  ) : string
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

function string_wrap_in_html_tags(  string  $search     ,
                                    string  $text       ,
                                    string  $open_tag   ,
                                    string  $close_tag  ) : string
{
  // Escape special characters
  $search = preg_quote($search, '/');
  $text   = preg_quote($text, '/');

  // Use a regex to do the trick and return the result
  return stripslashes(preg_replace("/($search)/i", "$open_tag$1$close_tag", $text));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    PAGE LAYOUT                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Initializes the use of a page section selector.
 *
 * @param   array   $entries  The list of all menu entries.
 * @param   string  $default  The menu entry to use when none is being selected.
 *
 * @return  array             An array of data ready for use in assembling a page section selector.
 */

function page_section_selector( array   $entries  ,
                                string  $default  ) : array
{
  // Initialize the return array and the selected entry
  $data     = array();
  $selected = '';

  // Loop through the menu entries in order to find whether a selection is being made
  foreach($entries as $entry)
  {
    // Check whether the menu entry is being selected
    if(isset($_GET[$entry]))
      $selected = $entry;
  }

  // Add the selected menu entry to the returned data
  $data['selected'] = $selected;

  // Loop once again through the menu entries in order to prepare the data
  foreach($entries as $entry)
  {
    // Define which dropdown menu entry should be selected and which page sections should be hidden
    $data['menu'][$entry] = ($selected == $entry || (!$selected && $entry == $default)) ? ' selected' : '';
    $data['hide'][$entry] = ($selected == $entry || (!$selected && $entry == $default)) ? '' : ' hidden';
  }

  // Return the assembled data
  return $data;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 PRIVATE MESSAGES                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Sends a private message to a user.
 *
 * @param   string  $title                        The message's title.
 * @param   string  $body                         The message's body.
 * @param   int     $recipient        (OPTIONAL)  The ID of the user which gets the message - if -1, current user.
 * @param   int     $sender           (OPTIONAL)  The ID of the suer sending the message - if 0, system notification.
 * @param   int     $parent_message   (OPTIONAL)  The ID of the parent message, if it is part of a message chain.
 * @param   int     $true_sender      (OPTIONAL)  For admin mail, the id of the true sender.
 * @param   bool    $is_admin_only    (OPTIONAL)  If set, moderators will not be able to see this message.
 * @param   bool    $hide_admin_mail  (OPTIONAL)  If set, the message will not appear in the collective admin outbox.
 * @param   bool    $is_silent        (OPTIONAL)  If set, the message arrives as already read.
 * @param   bool    $do_not_sanitize  (OPTIONAL)  If set, the data will not be sanitized.
 *
 * @return  bool                                  Whether the message was sent or not.
 */

function private_message_send(  string  $title                    ,
                                string  $body                     ,
                                int     $recipient        = 0     ,
                                int     $sender           = 0     ,
                                int     $parent_message   = 0     ,
                                int     $true_sender      = 0     ,
                                bool    $is_admin_only    = false ,
                                bool    $hide_admin_mail  = false ,
                                bool    $is_silent        = false ,
                                bool    $do_not_sanitize  = false ) : bool
{
  // If there is no recipient and current user is not logged in, no message should be sent
  if(!$recipient && !user_is_logged_in())
    return 0;

  // Sanitize and prepare the data
  $title        = ($do_not_sanitize) ? $title : sanitize($title, 'string');
  $body         = ($do_not_sanitize) ? $body : sanitize($body, 'string');
  $recipient    = ($recipient > -1) ? sanitize($recipient, 'int', 0) : sanitize(user_get_id(), 'int', 0);
  $sender       = sanitize($sender, 'int', 0);
  $parent       = sanitize($parent_message, 'int', 0);
  $sent_at      = sanitize(time(), 'int', 0);
  $read_at      = ($is_silent) ? sanitize(time(), 'int', 0) : 0;
  $true_sender  = sanitize($true_sender, 'int', 0);
  $admin_only   = sanitize($is_admin_only, 'int', 0, 1);
  $admin_mail   = sanitize($hide_admin_mail, 'int', 0, 1);

  // If the recipient does not exist, do not send the message
  if($recipient && !database_row_exists('users', $recipient))
    return 0;

  // If the sender does not exist, do not send the message either
  if($sender && !database_row_exists('users', $sender))
    return 0;

  // Send the message by inserting a new row in the private messages table
  query(" INSERT INTO   users_private_messages
          SET           users_private_messages.fk_users_recipient     = '$recipient'    ,
                        users_private_messages.fk_users_sender        = '$sender'       ,
                        users_private_messages.fk_users_true_sender   = '$true_sender'  ,
                        users_private_messages.fk_parent_message      = '$parent'       ,
                        users_private_messages.is_admin_only_message  = '$admin_only'   ,
                        users_private_messages.hide_from_admin_mail   = '$admin_mail'   ,
                        users_private_messages.sent_at                = '$sent_at'      ,
                        users_private_messages.read_at                = '$read_at'      ,
                        users_private_messages.title                  = '$title'        ,
                        users_private_messages.body                   = '$body'         ");

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
 * @param   bool      $error_&age   (OPTIONAL)  If set, throws an error page.
 * @param   int|null  $user_id      (OPTIONAL)  Specifies the ID of the user to check - if null, current user.
 *
 * @return  bool                                Is the user allowed to post content to the website.
 */

function flood_check( bool  $error_page = true  ,
                      ?int  $user_id    = NULL  ) : bool
{
  // If the user is logged out, then he shouldn't be able to do any actions: throw an error
  if(is_null($user_id) && !user_is_logged_in())
    error_page(__('error_flood_login'));

  // Fetch and sanitize the user's ID
  $user_id = (!is_null($user_id)) ? $user_id : user_get_id();
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch the user's recent activity
  $dactivity = mysqli_fetch_array(query(" SELECT  users.last_action_at AS 'u_last'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // If the last activity for the user happened less than 10 seconds ago, throw an error or return false
  $timestamp = time();
  if(($timestamp - $dactivity['u_last']) <= 10 )
  {
    if($error_page)
      error_page(__('error_flood_wait'));
    else
      return false;
  }

  // Update the last activity of the user
  query(" UPDATE  users
          SET     users.last_action_at  = '$timestamp'
          WHERE   users.id              = '$user_id' ");

  // The user is allowed to proceed
  return true;
}




/**
 * Adds an entry to the recent activity logs.
 *
 * @param   string  $activity_type                    The identifier of the activity log's type.
 * @param   bool    $is_moderators_only   (OPTIONAL)  Is it a public activity log or a moderation log.
 * @param   string  $language             (OPTIONAL)  The language(s) in which the log should appear.
 * @param   int     $activity_id          (OPTIONAL)  ID of the item linked to the activity log.
 * @param   string  $activity_summary_en  (OPTIONAL)  Summary of the activity log, in english.
 * @param   string  $activity_summary_fr  (OPTIONAL)  Summary of the activity log, in french.
 * @param   int     $activity_amount      (OPTIONAL)  An amout tied to the activity log.
 * @param   int     $fk_users             (OPTIONAL)  ID of the user implicated in the activity log.
 * @param   string  $username             (OPTIONAL)  username of the user implicated in the activity log.
 * @param   string  $moderator_username   (OPTIONAL)  username of the website admin implicated in the log.
 * @param   string  $moderation_reason    (OPTOINAL)  Reason specified by the moderator for the activity.
 * @param   bool    $do_not_sanitize      (OPTOINAL)  If set, do not sanitize the data.
 *
 * @return  int                                       The ID of the newly inserted activity log.
 */

function log_activity(  string  $activity_type                  ,
                        bool    $is_moderators_only   = false   ,
                        string  $language             = 'ENFR'  ,
                        int     $activity_id          = 0       ,
                        string  $activity_summary_en  = ''      ,
                        string  $activity_summary_fr  = ''      ,
                        int     $activity_amount      = 0       ,
                        int     $fk_users             = 0       ,
                        string  $username             = ''      ,
                        string  $moderator_username   = ''      ,
                        string  $moderation_reason    = ''      ,
                        bool    $do_not_sanitize      = false   ) : int
{
  // Sanitize and prepare the data
  $timestamp            = sanitize(time(), 'int', 0);
  $activity_type        = sanitize($activity_type, 'string');
  $is_moderators_only   = sanitize($is_moderators_only, 'int', 0, 1);
  $language             = ($do_not_sanitize) ? $language : sanitize($language, 'string');
  $activity_id          = sanitize($activity_id, 'int', 0);
  $activity_summary_en  = ($do_not_sanitize) ? $activity_summary_en : sanitize($activity_summary_en, 'string');
  $activity_summary_fr  = ($do_not_sanitize) ? $activity_summary_fr : sanitize($activity_summary_fr, 'string');
  $activity_amount      = sanitize($activity_amount, 'int');
  $fk_users             = sanitize($fk_users, 'int', 0);
  $username             = ($do_not_sanitize) ? $username : sanitize($username, 'string');
  $moderator_username   = ($do_not_sanitize) ? $moderator_username : sanitize($moderator_username, 'string');
  $moderation_reason    = ($do_not_sanitize) ? $moderation_reason : sanitize($moderation_reason, 'string');

  // Create the activity log by inserting it in the table
  query(" INSERT INTO logs_activity
          SET         logs_activity.fk_users                    = '$fk_users'               ,
                      logs_activity.happened_at                 = '$timestamp'              ,
                      logs_activity.is_moderators_only          = '$is_moderators_only' ,
                      logs_activity.language                    = '$language'               ,
                      logs_activity.activity_type               = '$activity_type'          ,
                      logs_activity.activity_id                 = '$activity_id'            ,
                      logs_activity.activity_amount             = '$activity_amount'        ,
                      logs_activity.activity_summary_en         = '$activity_summary_en'    ,
                      logs_activity.activity_summary_fr         = '$activity_summary_fr'    ,
                      logs_activity.activity_username           = '$username'               ,
                      logs_activity.activity_moderator_username = '$moderator_username'     ,
                      logs_activity.moderation_reason           = '$moderation_reason'      ");

  // Return the ID of the newly created activity log
  return(query_id());
}




/**
 * Adds an entry to the recent activity detailed logs.
 *
 * @param   int     $linked_activity_log              ID of the recent activity log to which this is linked.
 * @param   string  $description_en                   Description of the detailed activity log, in english.
 * @param   string  $description_fr                   Description of the detailed activity log, in french.
 * @param   string  $before                           Previous value of the content.
 * @param   string  $after                (OPTIONAL)  Current value of the content.
 * @param   bool    $is_optional          (OPTIONAL)  The log will only be created if before / after are different.
 * @param   bool    $do_not_sanitize      (OPTOINAL)  If set, do not sanitize the data.
 *
 * @return  void
 */

function log_activity_details(  int     $linked_activity_log          ,
                                string  $description_en               ,
                                string  $description_fr               ,
                                string  $before                       ,
                                string  $after                = ''    ,
                                bool    $is_optional          = false ,
                                bool    $do_not_sanitize      = false ) : void
{
  // If there are no differences, do not create a detailed activity log
  if($is_optional && ($before == $after))
    return;

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

function log_activity_purge_orphan_diffs() : void
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
 * @param   string  $activity_type                    The identifier of the activity log's type.
 * @param   bool    $is_moderators_only   (OPTIONAL)  Is it a public activity log or a moderation log.
 * @param   int     $fk_users             (OPTIONAL)  ID of the user implicated in the activity log.
 * @param   string  $username             (OPTIONAL)  username of the user implicated in the activity log.
 * @param   int     $activity_id          (OPTIONAL)  ID of the item linked to the activity log.
 * @param   bool    $global_type_wipe     (OPTOINAL)  Deletes all logs of type beginning like $activity_type.
 * @param   bool    $restore              (OPTIONAL)  Restores deleted logs instead of deleting them.
 *
 * @return  void
 */

function log_activity_delete( string  $activity_type              ,
                              bool    $is_moderators_only = false ,
                              int     $fk_users           = 0     ,
                              string  $username           = ''    ,
                              int     $activity_id        = 0     ,
                              bool    $global_type_wipe   = false ,
                              bool    $restore            = false ) : void
{
  // Begin by sanitizing the data
  $activity_type      = sanitize($activity_type, 'string');
  $is_moderators_only = sanitize($is_moderators_only, 'int', 0, 1);
  $fk_users           = sanitize($fk_users, 'int', 0);
  $username           = sanitize($username, 'string');
  $activity_id        = sanitize($activity_id, 'int', 0);
  $global_type_wipe   = sanitize($global_type_wipe, 'int', 0, 1);

  // Determine whether it is a log deletion or restoration
  $log_action = ($restore) ? 0 : 1;

  // Begin building the query
  $qactivity    = " UPDATE      logs_activity
                    SET         logs_activity.is_deleted = '$log_action' ";

  // Depending on whether this is a global type wipe or not, do a different kind of string matching
  if(!$global_type_wipe)
    $qactivity .= " WHERE       logs_activity.activity_type       LIKE  '$activity_type' ";
  else
    $qactivity .= " WHERE       logs_activity.activity_type       LIKE  '$activity_type%' ";

  // Treat public and private logs separately
  $qactivity .= "   AND         logs_activity.is_moderators_only  =     '$is_moderators_only' ";

  // Optional parameters
  if($fk_users)
    $qactivity .= " AND         logs_activity.fk_users            =     '$fk_users' ";
  if($username)
    $qactivity .= " AND         logs_activity.activity_username   LIKE  '$username' ";
  if($activity_id)
    $qactivity .= " AND         logs_activity.activity_id         =     '$activity_id' ";

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
 * @param   string  $message                            The message to send.
 * @param   string  $channel                (OPTIONAL)  The channel to use ('english' 'french' 'dev' 'mod' 'admin').
 * @param   bool    $allow_special_chars    (OPTIONAL)  Allow IRC formatting characters in the message.
 * @param   bool    $ignore_silenced_mode   (OPTIONAL)  Sends the message even if the IRC bot is in silenced mode.
 *
 * @return  bool                                        Whether the message has been queued in the bot's file.
 */

function irc_bot_send_message(  string  $message                          ,
                                string  $channel                  = ''    ,
                                bool    $allow_special_formatting = false ,
                                bool    $ignore_silenced_mode     = false ) : bool
{
  // Only use a limited amount of preset channel names
  if($channel)
  {
    $channel = match($channel)
    {
      'french'  => '#nobleme' ,
      'dev'     => '#dev'     ,
      'mod'     => '#sysop'   ,
      'admin'   => '#admin'   ,
      default   => '#english' ,
    };
  }

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
    $message = str_replace('%WHITE',chr(0x02).chr(0x03).'00,01',$message);              // Bold white on black
    $message = str_replace('%TROLL',chr(0x1f).chr(0x02).chr(0x03).'08,13',$message); // Bold underlined yellow on green
  }

  // Sanitize the data
  $timestamp          = sanitize(time(), 'int', 0);
  $channel_sanitized  = sanitize($channel, 'string');
  $body_sanitized     = sanitize($message, 'string');
  $temp               = (system_variable_fetch('irc_bot_is_silenced'));
  $temp               = $ignore_silenced_mode ? 0 : $temp;
  $silenced_mode      = sanitize($temp, 'int', 0, 1);
  $manual_mode        = ($channel) ? 0 : 1;

  // Write a log in the database
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at      = '$timestamp'          ,
                      logs_irc_bot.channel      = '$channel_sanitized'  ,
                      logs_irc_bot.body         = '$body_sanitized'     ,
                      logs_irc_bot.is_silenced  = '$silenced_mode'      ,
                      logs_irc_bot.is_manual    = '$manual_mode'        ");

  // Stop the process if the bot is in silenced mode, but return 1 since the job was done as intended
  if($silenced_mode && !$ignore_silenced_mode)
    return 1;

  // Fetch the path to the website's root
  $path = root_path();

  // If the file can be written in, then queue a message in it
  if($ircbot_file = fopen($path.'ircbot.txt', "a"))
  {
    // Depending on whether a channel is specifiied, the message is sent to the server or to a channel
    if(!$channel)
      file_put_contents($path.'ircbot.txt', time()." ".substr($message,0,450).PHP_EOL, FILE_APPEND);
    else
      file_put_contents($path.'ircbot.txt', time()." PRIVMSG ".$channel." :".substr($message,0,450).PHP_EOL, FILE_APPEND);

    // Close the IRCbot file
    fclose($ircbot_file);

    // Return 1 now that the job is done
    return 1;
  }

  // Otherwise we need to clarify that the file couldn't be written into
  else
  {
    // Update the log
    $log_id = sanitize(query_id(), 'int', 0);
    query(" UPDATE  logs_irc_bot
            SET     logs_irc_bot.is_failed  = 1
            WHERE   logs_irc_bot.id         = '$log_id' ");

    // Job failed, return 0
    return 0;
  }
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      DISCORD                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Uses a Discord webhook to broadcast a message.
 *
 * @param   string  $message              The message to send.
 * @param   string  $channel  (OPTIONAL)  The channel to use ('main' 'mod' 'admin').
 *
 * @return  void
 */

function discord_send_message(  string  $message          ,
                                string  $channel = 'main' ) : void
{
  // Stop here if Discord is toggled off
  if(!$GLOBALS['enable_discord'])
    return;

  // Stop here if Discord is silenced
  if(system_variable_fetch('discord_is_silenced'))
    return;

  // Determine which webhook to use
  if($channel == 'admin')
    $webhook = $GLOBALS['discord_admin'];
  else if($channel == 'mod')
    $webhook = $GLOBALS['discord_mod'];
  else
    $webhook = $GLOBALS['discord_main'];

  // If dev mod is enabled, use the dev webhook
  if($GLOBALS['dev_mode'])
  {
    // Set the webhook to the dev one
    $webhook = $GLOBALS['dev_discord'];

    // Prepare extra debug information
    if($channel == 'admin')
      $prepend = "**DEBUG: Admin notification:**";
    else if($channel == 'mod')
      $prepend = "**DEBUG: Mod notification:**";
    else
      $prepend = "**DEBUG: Main channel notification:**";

    // Prepend the message with extra debug information
    $message = $prepend.PHP_EOL.$message;
  }

  // Stop here if the selected webhook is not set
  if(!$webhook)
    return;

  // Encode the message
  $encoded_message = json_encode(['content' => $message], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS | JSON_PRETTY_PRINT);

  // Determine the HTTP settings to use
  $options = [
      'http' => [
          'method'        => 'POST'                           ,
          'header'        => 'Content-Type: application/json' ,
          'ignore_errors' => true                             , # Ignore any errors
          'timeout'       => 5                                , # Stop hanging after 5 seconds
          'content'       => $encoded_message
      ]
  ];

  // Open the stream
  $context = stream_context_create($options);

  // Send the message through the webhook, ignore any errors
  @file_get_contents($webhook, false, $context);
}