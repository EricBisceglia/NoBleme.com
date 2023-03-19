<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/users.act.php'; # Actions
include_once './../../lang/account.lang.php'; # Translations

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
// Check whether the username exists

// Fetch postdata
$check_username = form_fetch_element('register_username');

// Check if the username is legal
$username_is_illegal = users_check_username_illegality($check_username);

// Check if the username exists
$username_exists = users_check_username($check_username);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if($username_is_illegal) { ?>

<label class="red"><?=__('users_register_form_username_is_illegal')?></label>

<?php } else if($username_exists) { ?>

<label class="red"><?=__('users_register_form_username_exists')?></label>

<?php } else { ?>

<label class="hidden">&nbsp;</label>

<?php } ?>