<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/account.act.php'; # Actions
include_once './../../lang/account.lang.php';   # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/account/settings_password";
$page_title_en    = "Settings: Password";
$page_title_fr    = "Réglages : Mot de passe";
$page_description = "Change your NoBleme account's password";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update the account's password

if(isset($_POST['account_settings_password_submit']))
  $account_password_error = account_update_password(  form_fetch_element('account_settings_password_current')  ,
                                                      form_fetch_element('account_settings_password_new')      ,
                                                      form_fetch_element('account_settings_password_confirm')  );





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_30">

  <h2 class="bigpadding_bot">
    <?=__('account_password_title')?>
  </h2>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="account_settings_password_current"><?=__('account_password_current')?></label>
        <input class="indiv" type="password" id="account_settings_password_current" name="account_settings_password_current" value="">
      </div>

      <div class="padding_top">
        <label for="account_settings_password_new"><?=__('account_password_new')?></label>
        <input class="indiv" type="password" id="account_settings_password_new" name="account_settings_password_new" value="">
      </div>

      <div class="smallpadding_top">
        <label for="account_settings_password_confirm"><?=__('account_password_confirm')?></label>
        <input class="indiv" type="password" id="account_settings_password_confirm" name="account_settings_password_confirm" value="">
      </div>

      <div class="padding_top">
        <input type="submit" name="account_settings_password_submit" value="<?=__('submenu_user_edit_password')?>">
      </div>

    </fieldset>
  </form>

  <?php if(isset($account_password_error) && $account_password_error) { ?>

  <div class="padding_top">
    <div class="red text_white bigger uppercase bold align_center">
      <?=$account_password_error?>
    </div>
  </div>

  <?php } else if(isset($_POST['account_settings_password_submit'])) { ?>

  <div class="padding_top">
    <div class="green text_white bigger uppercase bold align_center">
      <?=__('account_password_success')?>
    </div>
  </div>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }