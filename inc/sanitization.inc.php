<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  sanitize                      Sanitizes data.                                                                    */
/*  sanitize_input                Sanitizes user inputted data.                                                      */
/*  sanitize_output               Sanitizes data for HTML usage.                                                     */
/*  sanitize_output_full          Sanitizes data before outputting it as HTML, for untrusted user data.              */
/*  sanitize_output_javascript    Sanitizes data for passing to inline javascript.                                   */
/*  sanitize_meta_tags            Sanitizes the content of meta tags.                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Sanitizes data.
 *
 * To protect ourselves from MySQL injections or just plain breaking of MySQL, data needs to be sanitized.
 * This function also ensures that data is of a specific type, useful given the very flexible way PHP treats types.
 * For ints and floats, it also allows you to ensure that the number's value is between a set minimum and maximum.
 * For strings, it allows you to ensure that the string's length is between a minimum and maximum size.
 *
 * @param   mixed     $data                 The data to be sanitized.
 * @param   string    $type     (OPTIONAL)  The expected data type: "string", "int", or "float"
 * @param   int|null  $min      (OPTIONAL)  Minimum expected value or length of the data (see description above).
 * @param   int|null  $max      (OPTIONAL)  Maximum expected value or length of the data (see description above).
 * @param   string    $padding  (OPTIONAL)  The character to add at the end of strings that are too short.
 *
 * @return  mixed                           Sanitized version of your data.
 */

function sanitize(  mixed   $data                 ,
                    string  $type     = 'string'  ,
                    ?int    $min      = NULL      ,
                    ?int    $max      = NULL      ,
                    string  $padding  = "_"       ) : mixed
{
  // For floats, ensure that it is a float, else convert it, then ensure that it is between min and max values
  if($type == "float")
  {
    if(!is_float($data))
      $data = floatval($data);
    if($min !== NULL && $data < $min)
      $data = $min;
    if($max !== NULL && $data > $max)
      $data = $max;
  }

  // For ints, ensure that it is an int, else convert it, then ensure that it is between min and max values
  else if($type == "int")
  {
    if(!is_int($data))
      $data = intval($data);
    if($min !== NULL && $data < $min)
      $data = $min;
    if($max !== NULL && $data > $max)
      $data = $max;
  }

  // For strings, ensure that it is a string, else convert it to one
  else if($type == "string")
  {
    if(!is_string($data))
      $data = strval($data);

    // If the string is below min value, pad its length with underscores
    if($min && strlen($data) < $min)
      $data = str_pad($data, $min, $padding);

    // If the string is above max value, strip it to max length
    if($max && strlen($data) > $max)
      $data = mb_substr($data, 0, $max);
  }

  // Sanitize the data by trimming any trailing whitespace and removing any characters that could break MySQL
  return trim(mysqli_real_escape_string($GLOBALS['db'], $data));
}




/**
 * Sanitizes user inputted data.
 *
 * This function is a wrapper around the sanitize() function.
 * It provides more options and convenience when dealing with data from $_POST or $_GET values.
 *
 * @param   string    $input_type                 The type of input: 'POST' or 'GET'.
 * @param   string    $input_name                 The input's name (eg. for $_POST['abc'], this is 'abc').
 * @param   string    $data_type                  The expected data type ('string', 'int', 'float').
 * @param   mixed     $default_value  (OPTIONAL)  Returns this value if the $input_name does not exist.
 * @param   int|null  $min            (OPTIONAL)  Min. value: see the documentation of sanitize().
 * @param   int|null  $max            (OPTIONAL)  Max. value: see the documentation of sanitize().
 * @param   string    $padding        (OPTIONAL)  Character used for padding strings, see sanitize().
 *
 * @return  mixed                                 Sanitized version of your inputted data.
 */

function sanitize_input(  string  $input_type             ,
                          string  $input_name             ,
                          string  $data_type              ,
                          mixed   $default_value  = ''    ,
                          ?int    $min            = NULL  ,
                          ?int    $max            = NULL  ,
                          string  $padding        = "_"   )
{
  // When dealing with $_POST, fetch the value (if it exists)
  if($input_type == 'POST')
    $data = (isset($_POST[$input_name])) ? $_POST[$input_name] : $default_value;

  // Same thing if dealing with $_GET
  if($input_type == 'GET')
    $data = (isset($_GET[$input_name])) ? $_GET[$input_name] : $default_value;

  // Sanitize the data, then return it
  return sanitize($data, $data_type, $min, $max, $padding);
}




/**
 * Sanitizes data for HTML usage.
 *
 * @param   string|null $data                               The data to be sanitized.
 * @param   bool        $prevent_line_breaks    (OPTIONAL)  If false/unset, will remove the line breaks from your data.
 * @param   bool        $preserve_backslashes   (OPTIONAL)  If false/unset, will remove backslashes from your data.
 *
 * @return  string                                      The sanitized data, ready to be printed in your HTML.
 */

function sanitize_output( ?string $data                         ,
                          bool    $preserve_line_breaks = false ,
                          bool    $preserve_backslashes = true  ) : string
{
  // Prepare the data for use in HTML
  $data = ($preserve_backslashes) ? htmlentities($data, ENT_QUOTES, 'utf-8') : stripslashes(htmlentities($data, ENT_QUOTES, 'utf-8'));

  // Return the prepared data
  return ($preserve_line_breaks) ? nl2br($data) : $data;
}




/**
 * Sanitizes data before outputting it as HTML, for untrusted user data.
 *
 * Before printing some data, you might want to sanitize it so that it interacts as expected with HTML rules.
 * Applying this function will prevent users from using HTML themselves, and thus avoid potential silly XSS issues.
 *
 * @param   string  $data                               The data to be sanitized.
 * @param   int     $prevent_line_breaks    (OPTIONAL)  If false or unset, will remove the line breaks from your data.
 * @param   int     $preserve_backslashes   (OPTIONAL)  If false or unset, backslashes will be removed from your data.
 *
 * @return  string                                      The sanitized data, ready to be printed in your HTML.
 */

function sanitize_output_full(  string  $data                         ,
                                bool    $preserve_line_breaks = false ,
                                bool    $preserve_backslashes = false ) : string
{
  // First off, get rid of all the HTML tags in the data - and if necessary remove backslashes
  $data = ($preserve_backslashes) ? htmlentities($data, ENT_QUOTES, 'utf-8') : stripslashes(htmlentities($data, ENT_QUOTES, 'utf-8'));

  // Get rid of the HTML tags
  $data = htmlentities($data);

  // Basic cleanup: Get rid of absusable tags, then restore the HTML
  $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
  $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
  $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
  $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

  // We don't want any property that begins with 'on' or 'xmlns'
  $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

  // There's a few abusable things that can happen in javascript which definitely need to dealt with
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

  // Let's also clean up IE related issues (oldie but goodie, never forget about IE's existence... sadly)
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

  // XSS prevention attempts.
  // This is poor quality code. Anyone who has a better solution, please give it to me, I really want it.
  $data = str_ireplace(".svg",".&zwnj;svg",$data);       # SVGs are exploitable through CDATA, deny them
  $data = str_ireplace("xmlns","xmlns&zwnj;",$data);     # XMLNS trolling attempts denial
  $data = str_ireplace("onclick","onclick&zwnj;",$data); # Guess it's time to manually handle all js events...
  $data = str_ireplace("oncontextmenu","oncontextmenu&zwnj;",$data);
  $data = str_ireplace("ondblclick","ondblclick&zwnj;",$data);
  $data = str_ireplace("onmousedown","onmousedown&zwnj;",$data);
  $data = str_ireplace("onmouseenter","onmouseenter&zwnj;",$data);
  $data = str_ireplace("onmouseleave","onmouseleave&zwnj;",$data);
  $data = str_ireplace("onmousemove","onmousemove&zwnj;",$data);
  $data = str_ireplace("onmouseover","onmouseover&zwnj;",$data);
  $data = str_ireplace("onmouseout","onmouseout&zwnj;",$data);
  $data = str_ireplace("onmouseup","onmouseup&zwnj;",$data);
  $data = str_ireplace("onkeydown","onkeydown&zwnj;",$data);
  $data = str_ireplace("onkeypress","onkeypress&zwnj;",$data);
  $data = str_ireplace("onkeyup","onkeyup&zwnj;",$data);
  $data = str_ireplace("onabort","onabort&zwnj;",$data);
  $data = str_ireplace("onbeforeunload","onbeforeunload&zwnj;",$data);
  $data = str_ireplace("onerror","onerror&zwnj;",$data);
  $data = str_ireplace("onhashchange","onhashchange&zwnj;",$data);
  $data = str_ireplace("onload","onload&zwnj;",$data);
  $data = str_ireplace("onpageshow","onpageshow&zwnj;",$data);
  $data = str_ireplace("onpagehide","onpagehide&zwnj;",$data);
  $data = str_ireplace("onresize","onresize&zwnj;",$data);
  $data = str_ireplace("onscroll","onscroll&zwnj;",$data);
  $data = str_ireplace("onunload","onunload&zwnj;",$data);
  $data = str_ireplace("onblur","onblur&zwnj;",$data);
  $data = str_ireplace("onchange","onchange&zwnj;",$data);
  $data = str_ireplace("onfocus","onfocus&zwnj;",$data);
  $data = str_ireplace("onfocusin","onfocusin&zwnj;",$data);
  $data = str_ireplace("onfocusout","onfocusout&zwnj;",$data);
  $data = str_ireplace("oninput","oninput&zwnj;",$data);
  $data = str_ireplace("oninvalid","oninvalid&zwnj;",$data);
  $data = str_ireplace("onreset","onreset&zwnj;",$data);
  $data = str_ireplace("onsearch","onsearch&zwnj;",$data);
  $data = str_ireplace("onselect","onselect&zwnj;",$data);
  $data = str_ireplace("onsubmit","onsubmit&zwnj;",$data);
  $data = str_ireplace("ondrag","ondrag&zwnj;",$data);
  $data = str_ireplace("ondragend","ondragend&zwnj;",$data);
  $data = str_ireplace("ondragenter","ondragenter&zwnj;",$data);
  $data = str_ireplace("ondragleave","ondragleave&zwnj;",$data);
  $data = str_ireplace("ondragover","ondragover&zwnj;",$data);
  $data = str_ireplace("ondragstart","ondragstart&zwnj;",$data);
  $data = str_ireplace("ondrop","ondrop&zwnj;",$data);
  $data = str_ireplace("oncopy","oncopy&zwnj;",$data);
  $data = str_ireplace("oncut","oncut&zwnj;",$data);
  $data = str_ireplace("onpaste","onpaste&zwnj;",$data);
  $data = str_ireplace("onafterprint","onafterprint&zwnj;",$data);
  $data = str_ireplace("onbeforeprint","onbeforeprint&zwnj;",$data);
  $data = str_ireplace("onabort","onabort&zwnj;",$data);
  $data = str_ireplace("oncanplay","oncanplay&zwnj;",$data);
  $data = str_ireplace("oncanplaythrough","oncanplaythrough&zwnj;",$data);
  $data = str_ireplace("ondurationchange","ondurationchange&zwnj;",$data);
  $data = str_ireplace("onemptied","onemptied&zwnj;",$data);
  $data = str_ireplace("onended","onended&zwnj;",$data);
  $data = str_ireplace("onloadeddata","onloadeddata&zwnj;",$data);
  $data = str_ireplace("onloadedmetadata","onloadedmetadata&zwnj;",$data);
  $data = str_ireplace("onloadstart","onloadstart&zwnj;",$data);
  $data = str_ireplace("onpause","onpause&zwnj;",$data);
  $data = str_ireplace("onplay","onplay&zwnj;",$data);
  $data = str_ireplace("onplaying","onplaying&zwnj;",$data);
  $data = str_ireplace("onprogress","onprogress&zwnj;",$data);
  $data = str_ireplace("onratechange","onratechange&zwnj;",$data);
  $data = str_ireplace("onseeked","onseeked&zwnj;",$data);
  $data = str_ireplace("onseeking","onseeking&zwnj;",$data);
  $data = str_ireplace("onstalled","onstalled&zwnj;",$data);
  $data = str_ireplace("onsuspend","onsuspend&zwnj;",$data);
  $data = str_ireplace("ontimeupdate","ontimeupdate&zwnj;",$data);
  $data = str_ireplace("onvolumechange","onvolumechange&zwnj;",$data);
  $data = str_ireplace("onwaiting","onwaiting&zwnj;",$data);
  $data = str_ireplace("animationend","animationend&zwnj;",$data);
  $data = str_ireplace("animationiteration","animationiteration&zwnj;",$data);
  $data = str_ireplace("animationstart","animationstart&zwnj;",$data);
  $data = str_ireplace("transitionend","transitionend&zwnj;",$data);
  $data = str_ireplace("onmessage","onmessage&zwnj;",$data);
  $data = str_ireplace("onopen","onopen&zwnj;",$data);
  $data = str_ireplace("ononline","ononline&zwnj;",$data);
  $data = str_ireplace("onoffline","onoffline&zwnj;",$data);
  $data = str_ireplace("onpopstate","onpopstate&zwnj;",$data);
  $data = str_ireplace("onmousewheel","onmousewheel&zwnj;",$data);
  $data = str_ireplace("onshow","onshow&zwnj;",$data);
  $data = str_ireplace("onstorage","onstorage&zwnj;",$data);
  $data = str_ireplace("ontoggle","ontoggle&zwnj;",$data);
  $data = str_ireplace("onwheel","onwheel&zwnj;",$data);
  $data = str_ireplace("ontouchcancel","ontouchcancel&zwnj;",$data);
  $data = str_ireplace("ontouchend","ontouchend&zwnj;",$data);
  $data = str_ireplace("ontouchmove","ontouchmove&zwnj;",$data);
  $data = str_ireplace("ontouchstart","ontouchstart&zwnj;",$data);

  // Return the sanitized data, optionally with line breaks
  return ($preserve_line_breaks) ? nl2br($data) : $data;
}




/**
 * Sanitizes data for passing to inline javascript.
 *
 * @param   string  $data   The data to be sanitized.
 *
 * @return  string          The sanitized data, ready to be printed in your HTML.
 */

function sanitize_output_javascript( string $data ) : string
{
  // Determine the length of the data
  $length = strlen($data);

  // Replace every single character by its ASCII value, avoids any attempted cheekiness
  $sanitized_data = '';
  for($i = 0; $i < $length; $i++) {
    $sanitized_data .= '\\x' . sprintf('%02x', ord(substr($data, $i, 1)));
  }

  // Return the sanitized data
  return $sanitized_data;
}




/**
 * Sanitizes the contents of meta tags.
 *
 * @param   string  $data   The data to be sanitized.
 *
 * @return  string          The sanitized data, ready to be used in a meta tag.
 */

function sanitize_meta_tags( string $data ) : string
{
  // Strip illegal characters
  $data = str_replace("\"","",$data);
  $data = str_replace("<","",$data);
  $data = str_replace(">","",$data);
  $data = str_replace("&","",$data);

  // Return the sanitized data
  return $data;
}