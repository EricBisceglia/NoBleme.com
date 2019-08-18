<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


/**
 * Ensures a number is preceded by its sign.
 *
 * @param   int|double $number  The number in question.
 *
 * @return  string|int|double   The same number, but signed.
 */

function number_prepend_sign($number)
{
  // If the number is above 0, then we prepend a plus to it
  if($number > 0)
    return '+'.$number;

  // Otherwise, we do nothing
  else
    return $number;
}




/**
 * Returns a styling depending on whether the number is positive, zero, or negative.
 *
 * @param   int|double  $number                       The value for which we want a styling.
 * @param   bool|null   $return_color_hex (OPTIONAL)  If set, then return a hexadecimal color value instead of a style.
 *
 * @return  string                                    The css styling or hexadecimal code corresponding to the value.
 */

function number_styling($number, $return_color_hex=0)
{
  // If we want a hex code, then we return a hex code for each case
  if($return_color_hex)
  {
    if($number > 0)
      return '339966';
    else if($number < 0)
      return 'FF0000';
    else
      return 'EB8933';
  }

  // Otherwise, we return the corresponding css styling
  if($number > 0)
    return 'positive';
  else if($number < 0)
    return 'negative';
  else
    return 'neutral';
}




/**
 * Changes the formatting of a number.
 *
 * I initially wanted to use number_format, but it was already taken by PHP's stdlib. Oh well.
 *
 * @param   int|double  $number                   The number to format.
 * @param   string|null $format       (OPTIONAL)  The format of the returned number.
 *                                                "number", "price", "price_cents", "percentage", "percentage_point"
 * @param   int|null    $decimals     (OPTIONAL)  Which amount of decimals should be returned.
 * @param   bool|null   $prepend_sign (OPTIONAL)  Should a sign always precede the returned number.
 *
 * @return  int|double|string                     The formatted number.
 */

function number_display_format($number, $format="number", $decimals=0, $prepend_sign=0)
{
  // Format: standard format - 10,01
  if($format == "number")
    $number = number_format((float)$number, 0, ',', ' ');

  // Format: price - 10 € (we ignore decimals)
  if($format == "price")
    $number = number_format((float)$number, 0, ',', ' ')." €";

  // Format: price with cents - 10,01 € (we limit to 2 decimals)
  if($format == "price_cents")
    $number = number_format((float)$number, 2, ',', ' ')." €";

  // Format: percentage - 10,01 %
  else if($format == "percentage")
    $number = number_format((float)$number, $decimals, ',', ' ')." %";

  // Format: percentage point - 10,01 p%
  else if($format == "percentage_point")
    $number = number_format((float)$number, $decimals, ',', ' ')." p%";

  // Retern the number, with an extra sign if necessary
  return ($prepend_sign && $number > 0) ? '+'.$number : $number;
}