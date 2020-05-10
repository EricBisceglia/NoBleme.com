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

$bot_action_selector = sanitize_input('POST', 'bot_action', 'string', 'send_message');




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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Silence the IRC bot

// Check if the bot is currently silenced
$irc_bot_silenced = system_variable_fetch('irc_bot_is_silenced');

// Toggle the silenced status if requested
if(isset($_POST['irc_bot_toggle_silence_mode']))
{
  $irc_bot_silenced = irc_bot_toggle_silence_mode($irc_bot_silenced);
  $bot_action_selector = 'silence';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a message through the IRC bot

if(isset($_POST['dev_irc_bot_message_send']))
  irc_bot_admin_send_message( form_fetch_element('dev_irc_bot_message_body', '')    ,
                              form_fetch_element('dev_irc_bot_message_channel', '') ,
                              form_fetch_element('dev_irc_bot_message_user', '')    ,
                              $path                                                 );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Purge a queued message

if(isset($_POST['purge_line_number']))
{
  irc_bot_purge_queued_message( form_fetch_element('purge_line_number', 0)  ,
                                $path                                       );
  $bot_action_selector = 'upcoming';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// List of queued messages

$irc_bot_message_queue = irc_bot_get_message_queue();




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
      <option value="upcoming"><?=__('irc_bot_action_upcoming')?></option>
      <option value="message_log"><?=__('irc_bot_action_message_log')?></option>
      <option value="send_message" selected><?=__('irc_bot_action_send_message')?></option>
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

<div id="bot_actions_stop" class="width_50 align_center">

  <div class="hugepadding_top bigpadding_bot">

    <?php if(!$irc_bot_stop) { ?>

    <button class="bigbutton" onclick="dev_bot_stop();"><?=__('irc_bot_action_stop')?></button>

    <?php } else { ?>

    <h2 class="align_center"><?=__('irc_bot_stopped')?></h2>

    <?php } ?>

  </div>

</div>




<?php } else if($bot_action_selector === 'silence') { ############################################################## ?>

<div id="bot_actions_silence" class="width_50 align_center">

  <div class="hugepadding_top bigpadding_bot">

    <?php if(!$irc_bot_silenced) { ?>

    <button class="bigbutton red red_hover" onclick="irc_bot_toggle_silence_mode();"><?=__('irc_bot_mute')?></button>

    <?php } else { ?>

    <button class="bigbutton green green_hover" onclick="irc_bot_toggle_silence_mode();"><?=__('irc_bot_unmute')?></button>

    <?php } ?>

  </div>

</div>




<?php } else if($bot_action_selector === 'upcoming') { ############################################################# ?>

<div id="bot_actions_purge" class="width_100">

  <?php if(!$irc_bot_message_queue['line_count'] && !isset($_POST['purge_line_number'])) { ?>

  <h3 class="padding_top padding_bot align_center text_green"><?=__('irc_bot_upcoming_empty')?></h3>

  <?php } else if(!$irc_bot_message_queue['line_count'] && isset($_POST['purge_line_number'])) { ?>

  <h3 class="padding_top padding_bot align_center"><?=__('irc_bot_upcoming_purged')?></h3>

  <?php } else { ?>

  <div class="padding_top bigpadding_bot align_center">
    <button class="bigbutton red" onclick="irc_bot_purge_message_queue(-1, '<?=__('irc_bot_upcoming_confirm_purge')?>');"><?=__('irc_bot_upcoming_purge')?></button>
  </div>

  <table>
    <tbody>

      <?php for($i = 0; $i < $irc_bot_message_queue['line_count']; $i++) { ?>

      <tr>
        <td class="align_center">
          <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete" onclick="irc_bot_purge_message_queue(<?=$i?>)">
        </td>
        <td>
          <?=$irc_bot_message_queue[$i]['line']?>
        </td>
      </tr>

      <?php } ?>

    </tbody>
  </table>

  <?php } ?>

</div>




<?php } else if($bot_action_selector === 'message_log') { ########################################################## ?>




<?php } else if($bot_action_selector === 'send_message') { ######################################################### ?>

<div id="bot_actions_message" class="width_30">
  <form method="POST">
    <fieldset>

      <label for="dev_irc_bot_message_body"><?=__('irc_bot_message_body')?></label>
      <input class="indiv" type="text" id="dev_irc_bot_message_body" name="dev_irc_bot_message_body" value="">

      <label class="padding_top" for="dev_irc_bot_message_channel"><?=__('irc_bot_message_channel')?></label>
      <input class="indiv" type="text" id="dev_irc_bot_message_channel" name="dev_irc_bot_message_channel" value="">

      <label class="padding_top" for="dev_irc_bot_message_user"><?=__('irc_bot_message_user')?></label>
      <input class="indiv" type="text" id="dev_irc_bot_message_user" name="dev_irc_bot_message_user" value="">

      <div class="padding_top">
        <input type="submit" name="dev_irc_bot_message_send" value="<?=__('irc_bot_message_send')?>">
      </div>

    </fieldset>
  </form>
</div>



<?php } else if($bot_action_selector === 'specialchars') { ######################################################### ?>

<div class="width_40">
  <table>
    <thead>

      <tr>
        <th>
          <?=__('irc_bot_bytes_effect')?>
        </th>
        <th>
          <?=__('irc_bot_bytes_character')?>
        </th>
        <th>
          <?=__('irc_bot_bytes_bytes')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td>
          <?=__('irc_bot_bytes_reset')?>
        </td>
        <td class="bold align_center">
          %O
        </td>
        <td class="bold align_center">
          chr(0x0f)
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_bold')?>
        </td>
        <td class="bold align_center">
          %B
        </td>
        <td class="bold align_center">
          chr(0x02)
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_italics')?>
        </td>
        <td class="bold align_center">
          %I
        </td>
        <td class="bold align_center">
          chr(0x1d)
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_underlined')?>
        </td>
        <td class="bold align_center">
          %U
        </td>
        <td class="bold align_center">
          chr(0x1f)
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_white')?>
        </td>
        <td class="bold align_center">
          %C00
        </td>
        <td class="bold align_center">
          chr(0x03).'00'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_black')?>
        </td>
        <td class="bold align_center">
          %C01
        </td>
        <td class="bold align_center">
          chr(0x03).'01'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_blue')?>
        </td>
        <td class="bold align_center">
          %C02
        </td>
        <td class="bold align_center">
          chr(0x03).'02'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_green')?>
        </td>
        <td class="bold align_center">
          %C03
        </td>
        <td class="bold align_center">
          chr(0x03).'03'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_red')?>
        </td>
        <td class="bold align_center">
          %C04
        </td>
        <td class="bold align_center">
          chr(0x03).'04'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_brown')?>
        </td>
        <td class="bold align_center">
          %C05
        </td>
        <td class="bold align_center">
          chr(0x03).'05'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_purple')?>
        </td>
        <td class="bold align_center">
          %C06
        </td>
        <td class="bold align_center">
          chr(0x03).'06'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_orange')?>
        </td>
        <td class="bold align_center">
          %C07
        </td>
        <td class="bold align_center">
          chr(0x03).'07'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_yellow')?>
        </td>
        <td class="bold align_center">
          %C08
        </td>
        <td class="bold align_center">
          chr(0x03).'08'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_light_green')?>
        </td>
        <td class="bold align_center">
          %C09
        </td>
        <td class="bold align_center">
          chr(0x03).'09'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_teal')?>
        </td>
        <td class="bold align_center">
          %C10
        </td>
        <td class="bold align_center">
          chr(0x03).'10'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_light_cyan')?>
        </td>
        <td class="bold align_center">
          %C11
        </td>
        <td class="bold align_center">
          chr(0x03).'11'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_light_blue')?>
        </td>
        <td class="bold align_center">
          %C12
        </td>
        <td class="bold align_center">
          chr(0x03).'12'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_pink')?>
        </td>
        <td class="bold align_center">
          %C13
        </td>
        <td class="bold align_center">
          chr(0x03).'13'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_text_grey')?>
        </td>
        <td class="bold align_center">
          %C14
        </td>
        <td class="bold align_center">
          chr(0x03).'14'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_black_white')?>
        </td>
        <td class="bold align_center">
          %BW
        </td>
        <td class="bold align_center">
          chr(0x02).chr(0x03).'00,01'
        </td>
      </tr>

      <tr>
        <td>
          <?=__('irc_bot_bytes_troll')?>
        </td>
        <td class="bold align_center">
          %TROLL
        </td>
        <td class="bold align_center">
          chr(0x1f).chr(0x02).chr(0x03).'08,13'
        </td>
      </tr>

    </tbody>
  </table>
</div>




<?php } if(!page_is_fetched_dynamically()) { ###################################################################### ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }