<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  number_prepend_sign         Ensures a number is preceded by its sign.                                            */
/*                                                                                                                   */
/*  number_display_format       Changes the formatting of a number.                                                  */
/*  number_styling              Returns a styling depending on whether the number is positive, zero, or negative.    */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Ensures a number is preceded by its sign.
 *
 * @param   int|float   $number   The number in question.
 *
 * @return  string                The same number, but signed.
 */

function number_prepend_sign( mixed $number ) : string
{
  // If the number is above 0, then prepend a plus to it
  if($number > 0)
    return '+'.$number;

  // Otherwise, do nothing
  else
    return $number;
}




/**
 * Changes the formatting of a number.
 *
 * @param   int|float   $number                   The number to format.
 * @param   string      $format       (OPTIONAL)  The format of the returned number.
 *                                                "number", "price", "price_cents", "percentage", "percentage_point"
 * @param   int         $decimals     (OPTIONAL)  Which amount of decimals should be returned.
 * @param   bool        $prepend_sign (OPTIONAL)  Should a sign always precede the returned number.
 *
 * @return  string                                The formatted number.
 */

function number_display_format( mixed   $number                   ,
                                string  $format       = "number"  ,
                                int     $decimals     = 0         ,
                                bool    $prepend_sign = false     ) : string
{
  // Standard format - 10,01
  if($format == "number")
    $number = number_format((float)$number, 0, ',', ' ');

  // Price - 10 € (ignore decimals)
  if($format == "price")
    $number = number_format((float)$number, 0, ',', ' ')." €";

  // Price with cents - 10,01 € (limit to 2 decimals)
  if($format == "price_cents")
    $number = number_format((float)$number, 2, ',', ' ')." €";

  // Percentage - 10,01 %
  else if($format == "percentage")
    $number = number_format((float)$number, $decimals, ',', ' ')." %";

  // Percentage point - 10,01 p%
  else if($format == "percentage_point")
    $number = number_format((float)$number, $decimals, ',', ' ')." p%";

  // Return the number, with an extra sign if necessary
  return ($prepend_sign && $number > 0) ? '+'.$number : $number;
}




/**
 * Returns a styling depending on whether the number is positive, zero, or negative.
 *
 * @param   int|float   $number                         The value from which the style will be determined.
 * @param   bool        $return_color_hex   (OPTIONAL)  If set, return a hexadecimal color value instead of a style.
 *
 * @return  string                                      The css styling or hexadecimal code corresponding to the value.
 */

function number_styling(  mixed $number                   ,
                          bool  $return_color_hex = false ) : string
{
  // Hex codes
  if($return_color_hex)
  {
    if($number > 0)
      return '339966';
    else if($number < 0)
      return 'FF0000';
    else
      return 'EB8933';
  }

  // CSS stylings
  if($number > 0)
    return 'positive';
  else if($number < 0)
    return 'negative';
  else
    return 'neutral';
}