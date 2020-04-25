<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 CLOSE THE WEBSITE                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Toggles the website's status between open and closed.
 *
 * @return  void
 */

function dev_toggle_website_status()
{
  // Fetch the current update status
  $website_status = system_variable_fetch('update_in_progress');

  // Determine the required new value
  $new_status = ($website_status) ? 0 : 1;

  // Toggle the website status
  system_variable_update('update_in_progress', $new_status, 'int');
}