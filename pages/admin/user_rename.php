<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';                  # Core
include_once './../../actions/users/user.act.php';            # Username check
include_once './../../actions/admin/user_management.act.php'; # Actions
include_once './../../lang/admin/user_management.lang.php';   # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/user_rename";
$page_title_en    = "Rename accounts";
$page_title_fr    = "Renommer un compte";

// Extra JS
$js = array('admin/user_management', 'users/autocomplete_nickname');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Rename a user

// Fetch the form values
$admin_rename_current   = form_fetch_element('admin_rename_current', NULL);
$admin_rename_new       = form_fetch_element('admin_rename_new', NULL);

// Rename the user
if(isset($_POST['admin_rename_submit']))
{
  $admin_rename_error = admin_account_rename( $admin_rename_current ,
                                              $admin_rename_new     );

  // Clear the form if all went well
  if(!$admin_rename_error)
  {
    $admin_rename_current = '';
    $admin_rename_new     = '';
  }
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center">
    <?=__('admin_rename_title')?>
  </h1>

</div>

<div class="width_30">

  <p class="bigpadding_bot bigpadding_top">
    <?=__('admin_rename_warning')?>
  </p>

  <?php if(isset($_POST['admin_rename_submit']) && !$admin_rename_error) { ?>
  <div class="bigpadding_bot">
    <h5 class="spaced align_center uppercase green text_white">
      <?=__('admin_rename_success')?>
    </h5>
  </div>
  <?php } ?>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="admin_rename_current"><?=__('admin_rename_current')?></label>
        <input class="indiv" type="text" id="admin_rename_current" name="admin_rename_current" value="<?=$admin_rename_current?>" autocomplete="off" list="admin_rename_current_list" onkeyup="autocomplete_nickname('admin_rename_current', 'admin_rename_current_list_parent', './../users/autocomplete_nickname', 'admin_rename_current_list', 'normal');">
      </div>
      <div id="admin_rename_current_list_parent">
        <datalist id="admin_rename_current_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <div class="padding_bot">
        <label for="admin_rename_new" id="admin_rename_new_label"><?=__('admin_rename_new')?></label>
        <input class="indiv" type="text" id="admin_rename_new" name="admin_rename_new" value="<?=$admin_rename_new?>" onkeyup="admin_rename_check();">
      </div>

      <?php if(isset($admin_rename_error)) { ?>
      <div class="padding_bot">
        <h5 class="spaced uppercase red text_white">
          <?=__('error').__(':', 0, 0, 1).$admin_rename_error?>
        </h5>
      </div>
      <?php } ?>

      <input type="submit" name="admin_rename_submit" value="<?=__('admin_rename_submit')?>">

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }