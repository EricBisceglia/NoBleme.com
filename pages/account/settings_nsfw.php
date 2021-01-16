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
$page_url         = "pages/account/settings_nsfw";
$page_title_en    = "Settings: Adult content";
$page_title_fr    = "Réglages : Vulgarité";
$page_description = "Decide whether your account should let you display adult content on the website";

// Extra JS
$js = array('common/toggle', 'account/settings');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update nsfw settings

if(isset($_POST['account_settings_nsfw']))
  account_settings_update('show_nsfw_content', form_fetch_element('account_settings_nsfw'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Current nsfw settings

// Fetch the current value
$nsfw_settings = user_settings_nsfw();

// Prepare the selector
for($i = 0; $i <= 2; $i++)
  $nsfw_selected[$i] = ($nsfw_settings == $i) ? ' selected' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_user_settings_nsfw')?>
  </h1>

  <p>
    <?=__('account_nsfw_intro')?>
  </p>

  <p>
    <?=__('account_nsfw_levels')?>
  </p>

  <div class="bigpadding_top">
    <fieldset>

      <label for="account_settings_nsfw"><?=__('account_nsfw_label')?></label>
      <select class="indiv align_left" id="account_settings_nsfw" name="account_settings_nsfw" onchange="settings_nsfw_update();">
        <option value="0"<?=$nsfw_selected[0]?>><?=__('account_nsfw_0')?></option>
        <option value="1"<?=$nsfw_selected[1]?>><?=__('account_nsfw_1')?></option>
        <option value="2"<?=$nsfw_selected[2]?>><?=__('account_nsfw_2')?></option>
      </select>

    </fieldset>
  </div>

  <div class="hidden padding_top bold uppercase" id="account_settings_nsfw_confirm">
    <?php } if(isset($_POST['account_settings_nsfw'])) { ?>
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