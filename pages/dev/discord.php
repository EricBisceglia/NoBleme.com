<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/integrations.act.php';  # Actions
include_once './../../lang/integrations.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/discord";
$page_title_en    = "Discord webhook";
$page_title_fr    = "Webhook Discord";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send message through Discord webhook

if(isset($_POST['discord_webhook_message_submit']))
  discord_webhook_send_message( form_fetch_element('discord_webhook_message_body')    ,
                                form_fetch_element('discord_webhook_message_channel') );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Silence the Discord integration

// Silence the integration
if(isset($_POST['discord_webhook_toggle_off']))
  system_variable_update('discord_is_silenced', 0, 'int');

// Unsilence the integration
if(isset($_POST['discord_webhook_toggle_on']))
  system_variable_update('discord_is_silenced', 1, 'int');

// Retrieve the current status
$discord_is_silenced = system_variable_fetch('discord_is_silenced');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1>
    <?=__('submenu_admin_discord')?>
  </h1>

  <h5 class="padding_bot">
    <?=__('discord_webhook_message_title')?>
  </h5>

  <form method="POST">
    <fieldset>

      <div class="padding_bot">
        <label for="discord_webhook_message_channel"><?=__('discord_webhook_message_channel')?></label>
        <select class="indiv align_left" id="discord_webhook_message_channel" name="discord_webhook_message_channel">
          <option value="main" selected><?=__('discord_webhook_message_main')?></option>
          <option value="mod"><?=__('discord_webhook_message_mod')?></option>
          <option value="admin"><?=__('discord_webhook_message_admin')?></option>
        </select>
      </div>

      <div class="padding_bot">
        <label for="discord_webhook_message_body"><?=__('discord_webhook_message_body')?></label>
        <textarea id="discord_webhook_message_body" name="discord_webhook_message_body"></textarea>
      </div>

      <input type="submit" name="discord_webhook_message_submit" value="<?=__('discord_webhook_message_submit')?>">

    </fieldset>
  </form>

</div>

<hr>

<div class="width_50 bigpadding_top">

  <h5 class="padding_bot">
    <?php if($discord_is_silenced) { ?>
    <?=__('discord_webhook_toggle_title_off')?>
    <?php } else { ?>
    <?=__('discord_webhook_toggle_title_on')?>
    <?php } ?>
  </h5>

  <form method="POST">
    <fieldset>

        <?php if($discord_is_silenced) { ?>
        <input type="submit" name="discord_webhook_toggle_off" value="<?=__('discord_webhook_toggle_on')?>">
        <?php } else { ?>
        <input type="submit" name="discord_webhook_toggle_on" value="<?=__('discord_webhook_toggle_off')?>">
        <?php } ?>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }