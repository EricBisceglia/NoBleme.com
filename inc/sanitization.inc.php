<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }



/**
 * Sanitizes data.
 *
 * To protect ourselves from MySQL injections or just plain breaking of MySQL, we need to sanitize the data we use.
 * This function also allows you to ensure that data is of a specific type, useful given the way PHP treats types.
 * For ints and floats, it also allows you to ensure that the number's value is between a set minimum and maximum.
 * For strings, it allows you to ensure that the string's length is between a minimum and maximum size.
 *
 * @example sanitize("My string", "string"); // Ensures that "My string" is a string
 * @example sanitize($some_boolean, "int", 0, 1); // Ensures that $some_boolean is a boolean
 * @example sanitize($_POST['user_input'], "string", 5, 15); // Ensures that some postdata is a string of 5 to 15 chars
 *
 * @param   string|int|float  $data               The data to be sanitized.
 * @param   string|null       $type    (OPTIONAL) The expected data type: "string", "int", "float", or "double".
 * @param   int|null          $min     (OPTIONAL) Minimum expected value or length of the data (see description above).
 * @param   int|null          $max     (OPTIONAL) Maximum expected value or length of the data (see description above).
 * @param   string            $padding (OPTIONAL) The character to be added at the end of strings that are too short.
 *
 * @return  string|int|float                      Sazitized version of your data.
 */

function sanitize($data, $type=NULL, $min=NULL, $max=NULL, $padding="_")
{
  // For floats, we ensure that it is a float, else we convert it, then we ensure that it is between min and max values
  if($type == "float" || $type == "double")
  {
    if(!is_float($data))
      $data = floatval($data);
    if($min !== NULL && $data < $min)
      $data = $min;
    if($max !== NULL && $data > $max)
      $data = $max;
  }

  // For ints, we ensure that it is an int, else we convert it, then we ensure that it is between min and max values
  else if($type == "int")
  {
    if(!is_int($data))
      $data = intval($data);
    if($min !== NULL && $data < $min)
      $data = $min;
    if($max !== NULL && $data > $max)
      $data = $max;
  }

  // For strings, we ensure that it is a string, else we convert it to one
  else if($type == "string")
  {
    if(!is_string($data))
      $data = strval($data);

    // If the string is below min value, we pad its length with underscores
    if($min && strlen($data) < $min)
      $data = str_pad($data, $min, $padding);

    // If the string is above max value, we strip it to max length
    if($max && strlen($data) > $max)
      $data = mb_substr($data, 0, $max);
  }

  // We sanitize the data by trimming any trailing whitespace and removing any characters that could break MySQL
  $data = trim(mysqli_real_escape_string($GLOBALS['db'], $data));

  // We can now return the sanitized data
  return $data;
}




/**
 * Sanitizes user inputted data.
 *
 * This function is a wrapper around the sanitize() function.
 * It provides more options and convenience when dealing with data from $_POST or $_GET values.
 *
 * @example sanitize_input('POST', 'some_post', 'int', 0); // Will retrieve 'some_post' if it exists, else return 0.
 * @example sanitize_input('GET', 'page_name', 'string'); // Will return the URL parameter 'page_name', else NULL.
 *
 * @param   string                $input_type                 The type of input: 'POST' or 'GET'.
 * @param   string                $input_name                 The input's name (eg. for $_POST['abc'], this is 'abc').
 * @param   string                $data_type                  The expected data type ('string', 'int', 'float').
 * @param   string|int|float|null $default_value  (OPTIONAL)  Returns this value if the $input_name does not exist.
 * @param   int|null              $min            (OPTIONAL)  Min. value: see the documentation of sanitize().
 * @param   int|null              $max            (OPTIONAL)  Max. value: see the documentation of sanitize().
 * @param   string|null           $padding        (OPTIONAL)  Character used for padding strings, see sanitize().
 *
 * @return  string|int|float                                  Sanitized version of your inputted data.
 */

function sanitize_input($input_type, $input_name, $data_type, $default_value=NULL, $min=NULL, $max=NULL, $padding=NULL)
{
  // If we are dealing with $_POST, we fetch the value (if it exists)
  if($input_type == 'POST')
    $data = (isset($_POST[$input_name])) ? $_POST[$input_name] : $default_value;

  // Same thing if we are dealing with $_GET
  if($input_type == 'GET')
    $data = (isset($_GET[$input_name])) ? $_GET[$input_name] : $default_value;

  // We need to sanitize the data, then we can return it
  return sanitize($data, $data_type, $min, $max, $padding);
}




/**
 * Sanitizes data before outputting it as HTML.
 *
 * Before printing some data, you might want to sanitize it so that it interacts as expected with HTML rules.
 * Applying this function will prevent users from using HTML themselves, and thus avoid potential silly XSS issues.
 *
 * @example sanitize_output('My string<hr>contains HTML', 0, 0);
 *
 * @param string  $data                             The data to be sanitized.
 * @param int     $prevent_line_breaks  (OPTIONAL)  If value is 0 or unset, will remove the line breaks from your data.
 * @param int     $preserve_backslashes (OPTIONAL)  If value is 0 or unset, backslashes will be removed from your data.
 *
 * @return string                                   The sanitized data, ready to be printed in your HTML.
 */

function sanitize_output($data, $preserve_line_breaks=0, $preserve_backslashes=0)
{
  // First off, we need to get rid of all the HTML tags in the data - and if necessary to remove backslashes
  $data = ($preserve_backslashes) ? htmlentities($data, ENT_QUOTES, 'utf-8') : stripslashes(htmlentities($data, ENT_QUOTES, 'utf-8'));

  // We can now return the sanitized data, optionally with line breaks
  return ($preserve_line_breaks) ? nl2br($data) : $data;
}