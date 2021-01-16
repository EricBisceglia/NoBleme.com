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
$page_url         = "pages/nobleme/index";
$page_title_en    = "Settings: E-mail";
$page_title_fr    = "Réglages : E-mail";
$page_description = "Change the e-mail address attached to your NoBleme account";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update the user's e-mail address

if(isset($_POST['account_settings_email_submit']))
{
  $account_email        = form_fetch_element('account_settings_email');
  $account_email_error  = account_update_email($account_email);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the user's current e-mail address

$account_email = (isset($account_email)) ? sanitize_output($account_email) : account_get_email();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_user_edit_email')?>
  </h1>

  <p>
    <?=__('account_email_intro')?>
  </p>

</div>

<div class="width_30 bigpadding_top">

  <form method="POST">
    <fieldset>

      <label for="account_settings_email"><?=__('account_email_label')?></label>
      <input class="indiv"type="text" id="account_settings_email" name="account_settings_email" value="<?=$account_email?>">

      <div class="smallpadding_top">
        <input type="submit" name="account_settings_email_submit" value="<?=__('account_email_submit')?>">
      </div>

    </fieldset>
  </form>

  <?php if(isset($account_email_error) && $account_email_error) { ?>

  <div class="padding_top">
    <div class="red text_white bigger uppercase bold align_center">
      <?=$account_email_error?>
    </div>
  </div>

  <?php } else if(isset($_POST['account_settings_email_submit'])) { ?>

  <div class="padding_top">
    <div class="green text_white bigger uppercase bold align_center">
      <?=__('account_email_confirm')?>
    </div>
  </div>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }