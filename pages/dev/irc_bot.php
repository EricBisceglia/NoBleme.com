<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/dev/ircbot.act.php';  # Actions
include_once './../../lang/dev.lang.php';           # Translations

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

// Grab the value
$bot_action_selector = sanitize_input('POST', 'bot_action', 'string', 'send_message');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stop the IRC bot

// Check if there is a request to stop the bot
$irc_bot_stop = form_fetch_element('irc_bot_stop', 0, 1);

// Stop the bot if required
if($irc_bot_stop)
{
  // Send the kill message to the bot
  irc_bot_stop($lang);

  // Set the action selector on the stop the bot page
  $bot_action_selector = 'stop';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Silence the IRC bot

// Check if the bot is currently silenced
$irc_bot_silenced = $system_variables['irc_bot_is_silenced'];

// Toggle the silenced status if requested
if(isset($_POST['irc_bot_toggle_silence_mode']))
{
  $irc_bot_silenced                         = irc_bot_toggle_silence_mode(  $irc_bot_silenced ,
                                                                            $lang             );
  $bot_action_selector                      = 'silence';
  $system_variables['irc_bot_is_silenced']  = system_variable_fetch('irc_bot_is_silenced');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a message through the IRC bot

if(isset($_POST['dev_irc_bot_message_send']))
  irc_bot_admin_send_message( form_fetch_element('dev_irc_bot_message_body', '')    ,
                              form_fetch_element('dev_irc_bot_message_channel', '') ,
                              form_fetch_element('dev_irc_bot_message_user', '')    ,
                              $path                                                 ,
                              $lang                                                 );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Purge a queued message

if(isset($_POST['purge_line_number']))
{
  irc_bot_message_queue_delete( form_fetch_element('purge_line_number', 0)  ,
                                $path                                       ,
                                $lang                                       );
  $bot_action_selector = 'upcoming';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// List of queued messages

if($bot_action_selector == 'upcoming')
  $irc_bot_message_queue = irc_bot_message_queue_list($path, $lang);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Replay a message from the logs

if(isset($_POST['irc_bot_replay_log_id']))
{
  irc_bot_message_history_replay( form_fetch_element('irc_bot_replay_log_id', 0)  ,
                                  $path                                           ,
                                  $lang                                           );
  $bot_action_selector = 'message_log';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a message from the logs

if(isset($_POST['irc_bot_delete_log_id']))
{
  irc_bot_message_history_delete( form_fetch_element('irc_bot_delete_log_id', 0)  ,
                                  $lang                                           );
  $bot_action_selector = 'message_log';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Message history

// Treat search requests first
if(isset($_POST['dev_irc_bot_history_submit']))
{
  // Prepare the search values
  $irc_bot_history_search_channel = form_fetch_element('dev_irc_bot_history_channel');
  $irc_bot_history_search_message = form_fetch_element('dev_irc_bot_history_message');
  $irc_bot_history_search_sent    = form_fetch_element('dev_irc_bot_history_sent');
  $irc_bot_history_search_sent_0  = ($irc_bot_history_search_sent == 0) ? ' selected' : '';
  $irc_bot_history_search_sent_1  = ($irc_bot_history_search_sent == 1) ? ' selected' : '';

  // Submit the search and fetch the data for the history table
  $irc_bot_message_history = irc_bot_message_history_list(  $lang                           ,
                                                            $irc_bot_history_search_channel ,
                                                            $irc_bot_history_search_message ,
                                                            $irc_bot_history_search_sent    );

  // Display the history table
  $bot_action_selector = 'message_log';
}

// Then treat display request with no search
else if($bot_action_selector == 'message_log')
{
  // Set the default search values
  $irc_bot_history_search_channel = '';
  $irc_bot_history_search_message = '';
  $irc_bot_history_search_sent_0  = '';
  $irc_bot_history_search_sent_1  = '';

  // Fetch the data for the history table
  $irc_bot_message_history = irc_bot_message_history_list($lang);
}

// Prepare the selector's value for when the history page is selected (avoids incorrect selector value when submitted)
$bot_action_selector_history = ($bot_action_selector == 'message_log') ? ' selected' : '';
$bot_action_selector_message = ($bot_action_selector != 'message_log') ? ' selected' : '';




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
      <option value="message_log"<?=$bot_action_selector_history?>><?=__('irc_bot_action_message_log')?></option>
      <option value="send_message"<?=$bot_action_selector_message?>><?=__('irc_bot_action_send_message')?></option>
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

<div id="bot_actions_purge" class="width_80">

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

<div id="bot_actions_history" class="width_80">

  <form method="POST">
    <fieldset>

      <table>

        <thead>

          <tr class="uppercase">
            <th>
              <?=__('date')?>
            </th>
            <th>
              <?=__('irc_bot_history_channel')?>
            </th>
            <th>
              <?=__('message')?>
            </th>
            <th>
              <?=__('error')?>
            </th>
            <th>
              <?=__('action', 2)?>
            </th>
          </tr>

          <tr>

            <th>
              <input type="reset" class="table_search" name="dev_irc_bot_history_submit" value="<?=__('reset')?>" onclick="irc_bot_reset_history_form();">
            </th>

            <th>
              <input type="text" class="table_search" id="dev_irc_bot_history_channel" name="dev_irc_bot_history_channel" value="<?=$irc_bot_history_search_channel?>">
            </th>

            <th>
              <input type="text" class="table_search" id="dev_irc_bot_history_message" name="dev_irc_bot_history_message" value="<?=$irc_bot_history_search_message?>">
            </th>

            <th>
              <select class="table_search" id="dev_irc_bot_history_sent" name="dev_irc_bot_history_sent">
                <option value="-1"><?=__('all')?></option>
                <option value="0"<?=$irc_bot_history_search_sent_0?>><?=__('irc_bot_history_sent')?></option>
                <option value="1"<?=$irc_bot_history_search_sent_1?>><?=string_change_case(__('error+'), 'initials')?></option>
              </select>
            </th>

            <th>
              <input type="submit" class="table_search" id="dev_irc_bot_history_submit" name="dev_irc_bot_history_submit" value="<?=__('search')?>">
            </th>

          </tr>

        </thead>

        <tbody>

          <?php for($i = 0; $i < $irc_bot_message_history['line_count']; $i++) { ?>

          <?php if(!$irc_bot_message_history[$i]['action']) { ?>

          <tr>
            <td class="align_center nowrap">
              <?=$irc_bot_message_history[$i]['date']?>
            </td>
            <td class="align_center nowrap">
              <?=$irc_bot_message_history[$i]['channel']?>
            </td>
            <td>
              <?=$irc_bot_message_history[$i]['body']?>
            </td>
            <td class="align_center nowrap<?=$irc_bot_message_history[$i]['failed_css']?>">
              <?=$irc_bot_message_history[$i]['failed']?>
            </td>
            <td class="align_center nowrap">
              <img class="smallicon valign_middle spaced_right pointer" src="<?=$path?>img/icons/refresh_small.svg" alt="R" title="resend" onclick="irc_bot_replay_history_entry('<?=$irc_bot_message_history[$i]['id']?>', '<?=__('irc_bot_history_confirm_replay')?>', '<?=$irc_bot_message_history[$i]['body_js']?>');">
              <img class="smallicon valign_middle pointer" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="delete" onclick="irc_bot_delete_history_entry('<?=$irc_bot_message_history[$i]['id']?>', '<?=__('irc_bot_history_confirm_delete')?>', '<?=$irc_bot_message_history[$i]['body_js']?>');">
            </td>
          </tr>

          <?php } else { ?>

          <tr>
            <td class="align_center nowrap dark">
              <?=$irc_bot_message_history[$i]['date']?>
            </td>
            <td colspan="3" class="align_center uppercase bold dark smallpadding_top smallpadding_bot">
              <?=$irc_bot_message_history[$i]['body']?>
            </td>
            <td class="align_center nowrap dark">
              <img class="smallicon valign_middle pointer" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="delete" onclick="irc_bot_delete_history_entry('<?=$irc_bot_message_history[$i]['id']?>', '<?=__('irc_bot_history_confirm_delete')?>');">
            </td>
          </tr>

          <?php } ?>

          <?php } ?>

        </tbody>

      </table>

    </fieldset>
  </form>

</div>




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