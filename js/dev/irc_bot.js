/**
 * Displays the selected bot action.
 *
 * @returns {void}
 */

function dev_bot_action_selector()
{
  // Fetch the requested bot action
  fetch_bot_action = document.getElementById('select_bot_action').value;

  // Update the page
  fetch_page('irc_bot', 'bot_actions_body', 'bot_action=' + fetch_bot_action);
}




/**
 * Starts the IRC bot.
 *
 * @param   {string}  starting_message  The message that will be displayed once the bot starts.
 *
 * @returns {void}
 */

function dev_bot_start(starting_message)
{
  // Send the starting message
  document.getElementById('bot_actions_start').innerHTML = '<h2 class="align_center text_green">' + starting_message + '</h2>';

  // Trigger the actual bot launch
  fetch_page('irc_bot_start', 'bot_actions_start');
}




/**
 * Stops the IRC bot.
 *
 * @returns {void}
 */

function dev_bot_stop()
{
  // Trigger the death of the IRC bot
  fetch_page('irc_bot', 'bot_actions_stop', 'irc_bot_stop=1');
}




/**
 * Toggles the silent status of the IRC bot.
 *
 * @returns {void}
 */

function irc_bot_toggle_silence_mode()
{
  // Trigger the death of the IRC bot
  fetch_page('irc_bot', 'bot_actions_silence', 'irc_bot_toggle_silence_mode=1');
}




/**
 * Purges the IRC bot's upcoming message queue.
 *
 * @param   {int}     purge_line_number       The line number to purge, 0 to purge all lines
 * @param   {string}  [confirmation_message]  The message that will be displayed if a complete purge is ordered
 *
 * @returns {void}
 */

function irc_bot_purge_message_queue(purge_line_number, confirmation_message)
{
  // Make sure the user knows what they're doing
  if(typeof(confirmation_message) !== 'undefined')
  {
    if(!confirm(confirmation_message))
      return;
  }

  // Assemble the postdata
  postdata = 'purge_line_number=' + fetch_sanitize(purge_line_number);

  // Trigger the purge of the messages
  fetch_page('irc_bot', 'bot_actions_purge', postdata);
}




/**
 * Resets the search form of the IRC bot's message history table.
 *
 * @returns {void}
 */

function irc_bot_reset_history_form()
{
  // Reset the fields
  document.getElementById('dev_irc_bot_history_channel').value  = '';
  document.getElementById('dev_irc_bot_history_message').value  = '';
  document.getElementById('dev_irc_bot_history_sent').value     = '-1';

  // Submit the form with the reset values
  document.getElementById('dev_irc_bot_history_submit').click();
}




/**
 * Triggers the replaying of an entry from the IRC bot's message history.
 *
 * @param   {int}     log_id                The ID of the log to replay.
 * @param   {string}  confirmation_message  The message that will be displayed before the log is replayed.
 * @param   {string}  log_body              The body of the log to replay.
 *
 * @returns {void}
 */

function irc_bot_replay_history_entry(log_id, confirmation_message, log_body)
{
  // Make sure the user knows what they're doing
  if(!confirm(confirmation_message + log_body))
    return;

  // Assemble the postdata (need to submit the search data or the search would be lost)
  postdata  = 'dev_irc_bot_history_submit=1';
  postdata += '&dev_irc_bot_history_channel=' + fetch_sanitize_id('dev_irc_bot_history_channel');
  postdata += '&dev_irc_bot_history_message=' + fetch_sanitize_id('dev_irc_bot_history_message');
  postdata += '&dev_irc_bot_history_sent='    + fetch_sanitize_id('dev_irc_bot_history_sent');
  postdata += '&irc_bot_replay_log_id='       + fetch_sanitize(log_id);

  // Trigger the replaying of the log
  fetch_page('irc_bot', 'bot_actions_history', postdata);
}




/**
 * Triggers the deletion of an entry from the IRC bot's message history.
 *
 * @param   {int}     log_id                The ID of the log to delete.
 * @param   {string}  confirmation_message  The message that will be displayed before the log is deleted.
 * @param   {string}  log_body              The body of the log to delete.
 *
 * @returns {void}
 */

function irc_bot_delete_history_entry(log_id, confirmation_message, log_body)
{
  // Make sure the user knows what they're doing
  if(!confirm(confirmation_message + log_body))
    return;

  // Assemble the postdata (need to submit the search data or the search would be lost)
  postdata  = 'dev_irc_bot_history_submit=1';
  postdata += '&dev_irc_bot_history_channel=' + fetch_sanitize_id('dev_irc_bot_history_channel');
  postdata += '&dev_irc_bot_history_message=' + fetch_sanitize_id('dev_irc_bot_history_message');
  postdata += '&dev_irc_bot_history_sent='    + fetch_sanitize_id('dev_irc_bot_history_sent');
  postdata += '&irc_bot_delete_log_id='       + fetch_sanitize(log_id);

  // Trigger the deletion of the log
  fetch_page('irc_bot', 'bot_actions_history', postdata);
}