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