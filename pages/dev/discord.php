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
// Send message through webhook

if(isset($_POST['discord_webhook_message_submit']))
  discord_webhook_send_message( form_fetch_element('discord_webhook_message_body')    ,
                                form_fetch_element('discord_webhook_message_channel') );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

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

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }