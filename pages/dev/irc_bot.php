<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; # Core
include_once './../../actions/dev.act.php';  # Actions
include_once './../../lang/dev.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/irc_bot";
$page_title_en    = "IRC bot";
$page_title_fr    = "Bot IRC";

// Extra JS
$js   = array('dev/irc_bot');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dropdown selector

$bot_action_selector = sanitize_input('POST', 'bot_action', 'string', 'upcoming');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stop the IRC bot

// Check if there is a request to stop the bot
$irc_bot_stop = form_fetch_element('irc_bot_stop', 0, 1);

// Stop the bot if required
if($irc_bot_stop)
{
  // Send the kill message to the bot
  irc_bot_stop();

  // Set the action selector on the stop the bot page
  $bot_action_selector = 'stop';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h4 class="align_center">
    <?=__('irc_bot_action_title')?>
    <select class="inh" id="select_bot_action" onchange="dev_bot_action_selector();">
      <option value="start"><?=__('irc_bot_action_start')?></option>
      <option value="stop"><?=__('irc_bot_action_stop')?></option>
      <option value="silence"><?=__('irc_bot_action_silence')?></option>
      <option value="upcoming" selected><?=__('irc_bot_action_upcoming')?></option>
      <option value="message_log"><?=__('irc_bot_action_message_log')?></option>
      <option value="send_message"><?=__('irc_bot_action_send_message')?></option>
      <option value="specialchars"><?=__('irc_bot_action_specialchars')?></option>
    </select>
  </h4>

</div>

<div class="bigpadding_top" id="bot_actions_body">




<?php } if($bot_action_selector === 'start') { ##################################################################### ?>

<div id="bot_actions_start" class="width_50 align_center bigpadding_top bigpadding_bot">

  <h3 class="bigpadding_bot uppercase"><?=__('irc_bot_start_warning')?></h3>

  <button class="bigbutton" onclick="dev_bot_start('<?=__('irc_bot_start_starting')?>');"><?=__('irc_bot_action_start')?></button>

</div>




<?php } else if($bot_action_selector === 'stop') { ################################################################# ?>

<div id="bot_actions_stop" class="width_50 align_center hugepadding_top bigpadding_bot">

  <?php if(!$irc_bot_stop) { ?>

  <button class="bigbutton" onclick="dev_bot_stop();"><?=__('irc_bot_action_stop')?></button>

  <?php } else { ?>

  <h2 class="align_center"><?=__('irc_bot_stopped')?></h2>

  <?php } ?>

</div>




<?php } else if($bot_action_selector === 'silence') { ############################################################## ?>

<div id="bot_actions_silence" class="width_50 align_center hugepadding_top bigpadding_bot">

  <?php if(!$irc_bot_stop) { ?>

  <button class="bigbutton" onclick="dev_bot_stop();"><?=__('irc_bot_action_stop')?></button>

  <?php } else { ?>

  <h2 class="align_center"><?=__('irc_bot_stopped')?></h2>

  <?php } ?>

</div>




<?php } else if($bot_action_selector === 'upcoming') { ############################################################# ?>




<?php } else if($bot_action_selector === 'message_log') { ########################################################## ?>




<?php } else if($bot_action_selector === 'send_message') { ######################################################### ?>




<?php } else if($bot_action_selector === 'specialchars') { ######################################################### ?>




<?php } if(!page_is_fetched_dynamically()) { ###################################################################### ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }