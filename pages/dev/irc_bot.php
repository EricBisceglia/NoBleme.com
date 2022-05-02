<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../actions/integrations.act.php';  # Actions
include_once './../../lang/integrations.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/irc_bot";
$page_title_en    = "IRC bot";
$page_title_fr    = "Bot IRC";

// Extra CSS & JS
$css  = array('dev');
$js   = array('dev/irc_bot', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the correct dropdown menu entry

// Prepare a list of all menu entries
$irc_bot_selection = array('start', 'stop', 'silence', 'upcoming', 'message_log', 'send_message', 'specialchars');

// Prepare the CSS for each entry
foreach($irc_bot_selection as $irc_bot_selection_name)
{
  // If a menu entry is selected, display it and select the correct dropdown menu entry
  if(!isset($irc_bot_is_selected) && isset($_GET[$irc_bot_selection_name]))
  {
    $irc_bot_is_selected                        = true;
    $irc_bot_hide[$irc_bot_selection_name]      = '';
    $irc_bot_selected[$irc_bot_selection_name]  = ' selected';
    $irc_bot_action                             = $irc_bot_selection_name;
  }

  // Hide every other menu entry
  else
  {
    $irc_bot_hide[$irc_bot_selection_name]      = ' hidden';
    $irc_bot_selected[$irc_bot_selection_name]  = '';
  }
}

// If no menu entry is selected, select the main one by default
if(!isset($irc_bot_is_selected))
{
  $irc_bot_hide['send_message']     = '';
  $irc_bot_selected['send_message'] = ' selected';
  $irc_bot_action                   = 'send_message';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stop the IRC bot

// Check if there is a request to stop the bot
$irc_bot_stop = form_fetch_element('irc_bot_stop', 0, 1);

// Send the kill message to the bot if requested
if($irc_bot_stop)
  irc_bot_stop();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Silence the IRC bot

// Check if the bot is currently silenced
$irc_bot_silenced = $system_variables['irc_bot_is_silenced'];

// Toggle the silenced status if requested
if(isset($_POST['irc_bot_toggle_silence_mode']))
{
  $irc_bot_silenced                         = irc_bot_toggle_silence_mode($irc_bot_silenced);
  $system_variables['irc_bot_is_silenced']  = system_variable_fetch('irc_bot_is_silenced');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a message through the IRC bot

if(isset($_POST['dev_irc_bot_message_send']))
  irc_bot_admin_send_message( form_fetch_element('dev_irc_bot_message_body', '')    ,
                              form_fetch_element('dev_irc_bot_message_channel', '') ,
                              form_fetch_element('dev_irc_bot_message_user', '')    );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Replay a message from the logs

if(isset($_POST['irc_bot_replay_log_id']))
  irc_bot_message_history_replay(form_fetch_element('irc_bot_replay_log_id', 0));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a message from the logs

if(isset($_POST['irc_bot_delete_log_id']))
  irc_bot_message_history_delete(form_fetch_element('irc_bot_delete_log_id', 0));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Purge a queued message

if(isset($_POST['purge_line_number']))
  irc_bot_message_queue_delete(form_fetch_element('purge_line_number', 0));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// List of queued messages

$irc_bot_message_queue = irc_bot_message_queue_list();




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

  // Fetch the search data
  $irc_bot_history_search = array(  'channel' =>  $irc_bot_history_search_channel ,
                                    'message' =>  $irc_bot_history_search_message ,
                                    'sent'    => $irc_bot_history_search_sent     );

  // Submit the search and fetch the data for the history table
  $irc_bot_message_history = irc_bot_message_history_list($irc_bot_history_search);
}
else
{
  // Set the default search values
  $irc_bot_history_search_channel = '';
  $irc_bot_history_search_message = '';
  $irc_bot_history_search_sent_0  = '';
  $irc_bot_history_search_sent_1  = '';

  // Fetch the data for the history table
  $irc_bot_message_history = irc_bot_message_history_list();
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center dev_doc_selector">

  <fieldset>
    <h5>
      <?=__('submenu_admin_ircbot').__(':')?>
      <select class="inh" id="irc_bot_action_selector" onchange="irc_bot_action_selector();">
        <option value="start"<?=$irc_bot_selected['start']?>><?=__('irc_bot_action_start')?></option>
        <option value="stop"<?=$irc_bot_selected['stop']?>><?=__('irc_bot_action_stop')?></option>
        <option value="silence"<?=$irc_bot_selected['silence']?>><?=__('irc_bot_action_silence')?></option>
        <option value="upcoming"<?=$irc_bot_selected['upcoming']?>><?=__('irc_bot_action_upcoming')?></option>
        <option value="message_log"<?=$irc_bot_selected['message_log']?>><?=__('irc_bot_action_message_log')?></option>
        <option value="send_message"<?=$irc_bot_selected['send_message']?>><?=__('irc_bot_action_send_message')?></option>
        <option value="specialchars"<?=$irc_bot_selected['specialchars']?>><?=__('irc_bot_action_specialchars')?></option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************** START ***************************************************/ ?>

<div class="padding_top irc_bot_section<?=$irc_bot_hide['start']?>" id="irc_bot_start">

  <?php } if($irc_bot_action == 'start' || !page_is_fetched_dynamically()) { ?>

  <div class="width_50 align_center bigpadding_top bigpadding_bot">

    <h3 class="bigpadding_bot uppercase"><?=__('irc_bot_start_warning')?></h3>

    <button class="bigbutton" onclick="irc_bot_start('<?=__('irc_bot_start_starting')?>');"><?=__('irc_bot_action_start')?></button>

  </div>

  <?php } if(!page_is_fetched_dynamically()) { ?>

</div>




<?php /************************************************** STOP ****************************************************/ ?>

<div class="padding_top irc_bot_section<?=$irc_bot_hide['stop']?>" id="irc_bot_stop">

  <?php } if($irc_bot_action == 'stop' || !page_is_fetched_dynamically()) { ?>

  <div class="width_50 align_center">

    <div class="hugepadding_top bigpadding_bot">

      <?php if(!$irc_bot_stop) { ?>

      <button class="bigbutton" onclick="irc_bot_stop();"><?=__('irc_bot_action_stop')?></button>

      <?php } else { ?>

      <h2 class="align_center"><?=__('irc_bot_stopped')?></h2>

      <?php } ?>

    </div>

  </div>

  <?php } if(!page_is_fetched_dynamically()) { ?>

</div>




<?php /************************************************* SILENCE **************************************************/ ?>

<div class="padding_top irc_bot_section<?=$irc_bot_hide['silence']?>" id="irc_bot_silence">

  <?php } if($irc_bot_action == 'silence' || !page_is_fetched_dynamically()) { ?>

  <div class="width_50 align_center">

    <div class="hugepadding_top bigpadding_bot">

      <?php if(!$irc_bot_silenced) { ?>

      <button class="bigbutton red red_hover" onclick="irc_bot_toggle_silence_mode();"><?=__('irc_bot_mute')?></button>

      <?php } else { ?>

      <button class="bigbutton green green_hover" onclick="irc_bot_toggle_silence_mode();"><?=__('irc_bot_unmute')?></button>

      <?php } ?>

    </div>

  </div>

  <?php } if(!page_is_fetched_dynamically()) { ?>

</div>




<?php /********************************************* MESSAGE QUEUE ************************************************/ ?>

<div class="padding_top irc_bot_section<?=$irc_bot_hide['upcoming']?>" id="irc_bot_upcoming">

  <?php } if($irc_bot_action == 'upcoming' || !page_is_fetched_dynamically()) { ?>

  <div id="bot_actions_purge" class="width_80 autoscroll">

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
            <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "irc_bot_purge_message_queue('".$i."');")?>
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

  <?php } if(!page_is_fetched_dynamically()) { ?>

</div>




<?php /********************************************* MESSAGE HISTORY **********************************************/ ?>

<div class="padding_top irc_bot_section<?=$irc_bot_hide['message_log']?>" id="irc_bot_message_log">

  <div class="width_80 autoscroll">

    <form method="POST">
      <fieldset>

        <table>

          <thead>

            <tr class="uppercase">
              <th>
                <?=__('date')?>
              </th>
              <th>
                <?=__('irc_channels_name')?>
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

          <tbody id="irc_bot_history_tbody">

            <?php } if($irc_bot_action == 'message_log' || !page_is_fetched_dynamically()) { ?>

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
                <?=__icon('refresh', is_small: true, class: 'valign_middle spaced_right pointer', alt: 'R', title: __('irc_bot_history_resend'), onclick: "irc_bot_replay_history_entry('".$irc_bot_message_history[$i]['id']."', '".__('irc_bot_history_confirm_replay')."', '".$irc_bot_message_history[$i]['body_js']."');")?>
                <?=__icon('delete', is_small: true, alt: 'X', title: __('delete'), title_case: 'initials', onclick: "irc_bot_delete_history_entry('".$irc_bot_message_history[$i]['id']."', '".__('irc_bot_history_confirm_delete')."', '".$irc_bot_message_history[$i]['body_js']."');")?>
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
                <?=__icon('delete', is_small: true, alt: 'X', title: __('delete'), title_case: 'initials', onclick: "irc_bot_delete_history_entry('".$irc_bot_message_history[$i]['id']."', '".__('irc_bot_history_confirm_delete')."');")?>
              </td>
            </tr>

            <?php } ?>

            <?php } ?>

            <?php } if(!page_is_fetched_dynamically()) { ?>

          </tbody>

        </table>

      </fieldset>
    </form>

  </div>

</div>




<?php /********************************************* SEND A MESSAGE ***********************************************/ ?>

<div class="padding_top irc_bot_section<?=$irc_bot_hide['send_message']?>" id="irc_bot_send_message">

  <div class="width_30">
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

</div>



<?php /******************************************* SPECIAL CHARACTERS *********************************************/ ?>

<div class="padding_top irc_bot_section<?=$irc_bot_hide['specialchars']?>" id="irc_bot_specialchars">

  <div class="width_50 autoscroll">
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
            <?=__('bold')?>
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
            <?=__('italics')?>
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
            <?=__('underlined')?>
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
            %WHITE
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

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }