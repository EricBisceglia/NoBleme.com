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
$page_url         = "pages/account/settings_privacy";
$page_title_en    = "Settings: Privacy";
$page_title_fr    = "Réglages : Vie privée";
$page_description = "Block third party content from being displayed on the website";

// Extra JS
$js = array('common/toggle', 'account/settings');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update privacy settings

// YouTube
if(isset($_POST['account_privacy_youtube']))
  account_update_settings('hide_youtube', form_fetch_element('account_privacy_youtube'));

// Google trends
if(isset($_POST['account_privacy_trends']))
  account_update_settings('hide_google_trends', form_fetch_element('account_privacy_trends'));

// Who's online
if(isset($_POST['account_privacy_online']))
  account_update_settings('hide_from_activity', form_fetch_element('account_privacy_online'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Current privacy settings

// Fetch current value
$privacy_settings = user_settings_privacy();

// Prepare the selectors
$privacy_youtube_yes  = ($privacy_settings['youtube'])  ? '' : ' checked';
$privacy_youtube_no   = ($privacy_settings['youtube'])  ? ' checked' : '';
$privacy_trends_yes   = ($privacy_settings['trends'])   ? '' : ' checked';
$privacy_trends_no    = ($privacy_settings['trends'])   ? ' checked' : '';
$privacy_online_yes   = ($privacy_settings['online'])   ? '' : ' checked';
$privacy_online_no    = ($privacy_settings['online'])   ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_user_settings_privacy')?>
  </h1>

  <p>
    <?=__('account_privacy_intro')?>
  </p>

  <p>
    <?=__('account_privacy_others')?>
  </p>

  <p>
    <?=__('account_privacy_disable')?>
  </p>

  <p>
    <?=__('account_privacy_activity')?>
  </p>

  <div class="bigpadding_top">
    <fieldset>

      <label><?=__('account_privacy_youtube')?></label>
      <input type="radio" id="account_privacy_youtube_0" name="account_privacy_youtube[]" value="0" onchange="settings_privacy_update('youtube');"<?=$privacy_youtube_yes?>>
      <label class="label_inline" for="account_privacy_youtube_0"><?=string_change_case(__('yes'), 'initials')?></label>
      <input type="radio" id="account_privacy_youtube_1" name="account_privacy_youtube[]" value="1" onchange="settings_privacy_update('youtube');"<?=$privacy_youtube_no?>>
      <label class="label_inline" for="account_privacy_youtube_1"><?=string_change_case(__('no'), 'initials')?></label>

      <label class="padding_top"><?=__('account_privacy_trends')?></label>
      <input type="radio" id="account_privacy_trends_0" name="account_privacy_trends[]" value="0" onchange="settings_privacy_update('trends');"<?=$privacy_trends_yes?>>
      <label class="label_inline" for="account_privacy_trends_0"><?=string_change_case(__('yes'), 'initials')?></label>
      <input type="radio" id="account_privacy_trends_1" name="account_privacy_trends[]" value="1" onchange="settings_privacy_update('trends');"<?=$privacy_trends_no?>>
      <label class="label_inline" for="account_privacy_trends_1"><?=string_change_case(__('no'), 'initials')?></label>

      <label class="padding_top"><?=__('account_privacy_online')?></label>
      <input type="radio" id="account_privacy_online_0" name="account_privacy_online[]" value="0" onchange="settings_privacy_update('online');"<?=$privacy_online_yes?>>
      <label class="label_inline" for="account_privacy_online_0"><?=string_change_case(__('yes'), 'initials')?></label>
      <input type="radio" id="account_privacy_online_1" name="account_privacy_online[]" value="1" onchange="settings_privacy_update('online');"<?=$privacy_online_no?>>
      <label class="label_inline" for="account_privacy_online_1"><?=string_change_case(__('no'), 'initials')?></label>

    </fieldset>
  </div>

  <div class="hidden padding_top bold uppercase" id="account_settings_privacy_confirm">
    <?php } if(isset($_POST['account_privacy_change'])) { ?>
    <div class="green text_white align_center bigger vspaced">
      <?=__('account_nsfw_confirm')?>
    </div>
    <?php } else { ?>
    &nbsp;
    <?php } if(!page_is_fetched_dynamically()) { ?>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }