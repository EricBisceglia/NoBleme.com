<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/settings";
$page_title_en    = "Website settings";
$page_title_fr    = "Réglages du site";

// Extra JS
$js = array('common/toggle', 'dev/settings');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update settings

// Open the website
if(isset($_POST['dev_settings_open_website']))
  system_variable_update('website_is_closed', 0, 'int');

// Close the website
if(isset($_POST['dev_settings_close_website']))
  system_variable_update('website_is_closed', 1, 'int');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch current settings

// Fetch website status and prepare radio buttons
$dev_settings_state         = system_variable_fetch('website_is_closed');
$dev_settings_state_open    = (!$dev_settings_state)  ? ' checked' : '';
$dev_settings_state_closed  = ($dev_settings_state)   ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_admin_settings')?>
  </h1>

  <form method="POST">
    <fieldset>

    <div class="hidden" id="dev_settings_dummy_div">
      &nbsp;
    </div>

    <h5 class="padding_top"><?=__('dev_settings_state_title')?></h5>

    <div class="smallpadding_top">
      <input type="radio" id="dev_settings_close_0" name="dev_settings_close[]" value="0" onclick="dev_settings_open()"<?=$dev_settings_state_open?>>
      <label class="label_inline" for="dev_settings_close_0"><?=string_change_case(__('opened'), 'initials')?></label>
      <br>
      <input type="radio" id="dev_settings_close_1" name="dev_settings_close[]" value="1" onclick="dev_settings_close()"<?=$dev_settings_state_closed?>>
      <label class="label_inline" for="dev_settings_close_1"><?=string_change_case(__('closed'), 'initials')?></label>
    </div>

    <div class="smallpadding_top hidden" id="dev_settings_open_message">
      <div class="uppercase align_center bigger spaced green text_white bold">
        <?=__('dev_settings_state_open')?>
      </div>
    </div>

    <div class="smallpadding_top hidden" id="dev_settings_close_message">
      <div class="uppercase align_center bigger spaced red text_white bold">
        <?=__('dev_settings_state_closed')?>
      </div>
    </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }