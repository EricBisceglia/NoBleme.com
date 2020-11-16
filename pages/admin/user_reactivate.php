<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';                  # Core
include_once './../../actions/admin/user_management.act.php'; # Actions
include_once './../../lang/admin/user_management.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch the account id
$reactivate_id = form_fetch_element('reactivate_id', 0);

// If the account id exists, reactivate the account
if($reactivate_id)
  $error = admin_account_reactivate($reactivate_id);
else
  $error = __('admin_reactivate_no_id');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if($error) { ?>

<tr>
  <td colspan="4" class="align_center text_white red bold uppercase">
    <?=__('error').__(':', 0, 0, 1).$error?>
  </td>
</tr>

<?php } else { ?>

<tr>
  <td colspan="4" class="align_center text_white green bold uppercase">
    <?=__('admin_reactivate_success')?>
  </td>
</tr>

<?php } ?>