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
$js = array('dev/settings');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch current settings

// Website state
$dev_settings_state = system_variable_fetch('website_is_closed');

// New account registration
$dev_settings_registration = system_variable_fetch('registrations_are_closed');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update settings

// Open the website
if(isset($_POST['dev_settings_open_website']) && $dev_settings_state)
  dev_settings_website_open();

// Close the website
if(isset($_POST['dev_settings_close_website']) && !$dev_settings_state)
  dev_settings_website_close();

// Enable new account registration
if(isset($_POST['dev_settings_open_registrations']) && $dev_settings_registration)
  dev_settings_registrations_open();

// Disable new account registration
if(isset($_POST['dev_settings_close_registrations']) && !$dev_settings_registration)
  dev_settings_registrations_close();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare form elements and divs visibility

// Website state
$dev_settings_state_open        = (!$dev_settings_state)  ? ' checked'  : '';
$dev_settings_state_closed      = ($dev_settings_state)   ? ' checked'  : '';
$dev_settings_state_open_div    = ($dev_settings_state)   ? ' hidden'   : '';
$dev_settings_state_closed_div  = (!$dev_settings_state)  ? ' hidden'   : '';

// New account registration
$dev_settings_registration_open       = (!$dev_settings_registration) ? ' checked'  : '';
$dev_settings_registration_closed     = ($dev_settings_registration)  ? ' checked'  : '';
$dev_settings_registration_open_div   = ($dev_settings_registration)  ? ' hidden'   : '';
$dev_settings_registration_closed_div = (!$dev_settings_registration) ? ' hidden'   : '';




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

    <div class="bigpadding_top<?=$dev_settings_state_open_div?>" id="dev_settings_open_message">
      <div class="uppercase align_center bigger spaced green text_white bold">
        <?=__('dev_settings_state_open')?>
      </div>
    </div>

    <div class="bigpadding_top<?=$dev_settings_state_closed_div?>" id="dev_settings_close_message">
      <div class="uppercase align_center bigger spaced red text_white bold">
        <?=__('dev_settings_state_closed')?>
      </div>
    </div>

    <h5 class="smallpadding_top"><?=__('dev_settings_state_title')?></h5>

    <div class="smallpadding_top">
      <input type="radio" id="dev_settings_close_0" name="dev_settings_close[]" value="0" onclick="dev_settings_open()"<?=$dev_settings_state_open?>>
      <label class="label_inline" for="dev_settings_close_0"><?=string_change_case(__('opened'), 'initials')?></label>
      <br>
      <input type="radio" id="dev_settings_close_1" name="dev_settings_close[]" value="1" onclick="dev_settings_close()"<?=$dev_settings_state_closed?>>
      <label class="label_inline" for="dev_settings_close_1"><?=string_change_case(__('closed'), 'initials')?></label>
    </div>

    <div class="bigpadding_top<?=$dev_settings_registration_open_div?>" id="dev_settings_registration_on_message">
      <div class="uppercase align_center bigger spaced green text_white bold">
        <?=__('dev_settings_registration_open')?>
      </div>
    </div>

    <div class="bigpadding_top<?=$dev_settings_registration_closed_div?>" id="dev_settings_registration_off_message">
      <div class="uppercase align_center bigger spaced red text_white bold">
        <?=__('dev_settings_registration_closed')?>
      </div>
    </div>

    <h5 class="smallpadding_top"><?=__('dev_settings_registration_title')?></h5>

    <div class="smallpadding_top">
      <input type="radio" id="dev_settings_registration_0" name="dev_settings_registration[]" value="0" onclick="dev_registrations_open()"<?=$dev_settings_registration_open?>>
      <label class="label_inline" for="dev_settings_registration_0"><?=string_change_case(__('opened'), 'initials')?></label>
      <br>
      <input type="radio" id="dev_settings_registration_1" name="dev_settings_registration[]" value="1" onclick="dev_registrations_close()"<?=$dev_settings_registration_closed?>>
      <label class="label_inline" for="dev_settings_registration_1"><?=string_change_case(__('closed'), 'initials')?></label>
    </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }