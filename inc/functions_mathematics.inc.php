<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  maths_percentage_of         The percentage of a number that another number represents.                           */
/*  maths_percentage_growth     Growth in percent from one value to another.                                         */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * The percentage of a number that another number represents.
 *
 * @param   float   $number   The number which is a percentage of a total.
 * @param   float   $total    The total of which another number is a percentage of.
 *
 * @return  float             This function returns $number as a percentage of $total.
 */

function maths_percentage_of( float $number ,
                              float $total  ) : float
{
  // Simple enough: do the calculation and return its result (and avoid division by zero)
  return ($total) ? (($number/$total)*100) : 0;
}




/**
 * Growth in percent from one value to another.
 *
 * @param   float   $before   The value before the growth.
 * @param   float   $after    The value after the growth.
 *
 * @return  float             Growth in % between the two values.
 */

function maths_percentage_growth( float $before ,
                                  float $after  ) : float
{
  // Simple enough: do the calculation and return its result (and avoid division by zero)
  return ($before) ? (($after/$before)*100)-100 : 0;
}