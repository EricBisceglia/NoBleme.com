<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  test_assert                   Checks whether a test result met expectations.                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Checks whether a test result met expectations.
 *
 * @param   mixed   $value                  The value being tested.
 * @param   string  $type         OPTIONAL  The expected type of the value (bool, int, float, string, array, etc.).
 * @param   mixed   $assertion    OPTIONAL  The test result being asserted (if empty, will compare to expectations).
 * @param   mixed   $expectation  OPTIONAL  The expected result (if empty, will check whether the assertion is true).
 * @param   string  $success      OPTIONAL  Message to return in case of test success.
 * @param   string  $failure      OPTIONAL  Message to return in case of test failure.
 *
 * @return  array                             An array of results related to the test.
 *
 */

function test_assert( mixed   $value                    ,
                      string  $type         = ''        ,
                      mixed   $assertion    = NULL      ,
                      mixed   $expectation  = true      ,
                      string  $success      = 'Success' ,
                      string  $failure      = 'Failure' ) : array
{
  // Look for type mismatches
  if($type)
  {
    // Boolean type mismatch
    if($type === 'bool' && !is_bool($value))
    {
      $return['result']       = false;
      $return['explanation']  = "Type mismatch: expected a boolean";
    }

    // Int type mismatch
    if($type === 'int' && !is_int($value))
    {
      $return['result']       = false;
      $return['explanation']  = "Type mismatch: expected an integer";
    }

    // Float type mismatch
    if($type === 'float' && !is_float($value))
    {
      $return['result']       = false;
      $return['explanation']  = "Type mismatch: expected a float";
    }

    // String type mismatch
    if($type === 'string' && !is_string($value))
    {
      $return['result']       = false;
      $return['explanation']  = "Type mismatch: expected a string";
    }

    // Array type mismatch
    if($type === 'array' && !is_array($value))
    {
      $return['result']       = false;
      $return['explanation']  = "Type mismatch: expected an array";
    }

    // Null type mismatch
    if($type === 'null' && !is_null($value))
    {
      $return['result']       = false;
      $return['explanation']  = "Type mismatch: Expected NULL";
    }
  }

  // Stop there if there is a type mismatch
  if(isset($return['result']) && $return['result'] === false)
    return $return;

  // If there are neither assertions nor expectations, the test fails
  if(!$assertion && !$expectation)
    $result = false;

  // Check whether the result met expectations
  if($assertion)
    $result = (bool)($assertion === $expectation);
  else
    $result = (bool)($value === $expectation);

  // Add the test's results and its explanation to the return array
  $return['result']       = $result;
  $return['explanation']  = ($result === true) ? $success : $failure;

  // Return the array of test data
  return $return;
}