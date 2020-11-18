<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/users/account.act.php'; # Actions

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_guests();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Login attempt

if(isset($_POST['login_form_username']) && isset($_POST['login_form_password']))
{
  // Check whether the remember me box is checked
  $login_form_remember_me = (form_fetch_element('login_form_remember_desktop') == 'false' || form_fetch_element('login_form_remember_mobile') == 'false') ? 0 : 1;

  // Attempt to login
  $login_form_attempt = user_authenticate(  $_SERVER["REMOTE_ADDR"]                   ,
                                            form_fetch_element('login_form_username') ,
                                            form_fetch_element('login_form_password') ,
                                            $login_form_remember_me                   );
}
else
  $login_form_attempt = 0;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

echo $login_form_attempt;