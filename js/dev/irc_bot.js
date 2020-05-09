/**
 * Displays the selected bot action
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
 * Starts the IRC bot
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
 * Stops the IRC bot
 *
 * @returns {void}
 */

function dev_bot_stop(stopping_message)
{
  // Trigger the death of the IRC bot
  fetch_page('irc_bot', 'bot_actions_stop', 'irc_bot_stop=1');
}