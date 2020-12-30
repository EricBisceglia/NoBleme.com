<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';                # Core
include_once './../../actions/user.act.php';                # Username check
include_once './../../actions/user_management.act.php';     # Actions
include_once './../../lang/admin/user_management.lang.php'; # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_moderators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Check username validity

// Fetch the new username
$admin_rename = form_fetch_element('admin_rename', NULL);

// Check for its validity
$admin_rename_validity = admin_account_check_availability($admin_rename);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if(isset($admin_rename_validity['valid']) && $admin_rename_validity['valid']) { ?>

<span class="spaced uppercase bold green text_white"><?=__('admin_rename_valid')?></span>

<?php } else if (isset($admin_rename_validity['error'])) { ?>

<span class="spaced uppercase bold red text_white"><?=__('error').__(':', 0, 0, 1).$admin_rename_validity['error']?></span>

<?php } else { ?>

<?=__('admin_rename_new')?>

<?php } ?>