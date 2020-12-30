<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';                  # Core
include_once './../../actions/user_management.act.php';       # Actions
include_once './../../lang/admin/user_management.lang.php';   # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/user_password";
$page_title_en    = "Password";
$page_title_fr    = "Mot de passe";

// Extra JS
$js = array('users/autocomplete_username');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Change a password

// Fetch the form values
$admin_password_username  = form_fetch_element('admin_password_username', NULL);
$admin_password_new       = form_fetch_element('admin_password_new', NULL);

// Change the password
if(isset($_POST['admin_password_submit']))
{
  $admin_password_error = admin_account_change_password(  $admin_password_username  ,
                                                          $admin_password_new       );

  // If all went well, reset the form values
  if(!$admin_password_error)
  {
    $admin_password_username  = '';
    $admin_password_new       = '';
  }
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center">
    <?=__('admin_password_title')?>
  </h1>

</div>

<div class="width_30">

  <p class="bigpadding_bot bigpadding_top">
    <?=__('admin_password_warning')?>
  </p>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="admin_password_username"><?=string_change_case('username', 'initials')?></label>
        <input class="indiv" type="text" id="admin_password_username" name="admin_password_username" value="<?=$admin_password_username?>" autocomplete="off" list="admin_password_username_list" onkeyup="autocomplete_username('admin_password_username', 'admin_password_username_list_parent', './../common/autocomplete_username', 'admin_password_username_list', 'normal');">
      </div>
      <div id="admin_password_username_list_parent">
        <datalist id="admin_password_username_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <div class="padding_bot">
        <label for="admin_password_new"><?=__('admin_password_new')?></label>
        <input class="indiv" type="password" id="admin_password_new" name="admin_password_new" value="<?=$admin_password_new?>">
      </div>

      <?php if(isset($admin_password_error)) { ?>
      <div class="padding_bot">
        <h5 class="spaced uppercase red text_white">
          <?=__('error').__(':', 0, 0, 1).$admin_password_error?>
        </h5>
      </div>
      <?php } ?>

      <input type="submit" name="admin_password_submit" value="<?=__('admin_password_submit')?>">

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }