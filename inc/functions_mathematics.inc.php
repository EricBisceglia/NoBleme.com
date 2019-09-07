<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/**
 * The percentage of a number that another number represents.
 *
 * @param   double  $number The number which is a percentage of a total.
 * @param   double  $total  The total of which another number is a percentage of.
 *
 * @return  double          This function returns $number as a percentage of $total.
 */

function maths_percentage_of($number, $total)
{
  // Simple enough: do the calculation and return its result (and avoid division by zero)
  return ($total) ? (($number/$total)*100) : 0;
}




/**
 * Growth in percent from one value to another.
 *
 * @param   double  $before The value before the growth.
 * @param   double  $after  The value after the growth.
 *
 * @return  double          Growth in % between the two values.
 */

function math_percentage_growth($before, $after)
{
  // Simple enough: do the calculation and return its result (and avoid division by zero)
  return ($before) ? (($after/$before)*100)-100 : 0;
}