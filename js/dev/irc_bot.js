/*********************************************************************************************************************/
/*                                                                                                                   */
/*  irc_bot_action_selector           Displays the selected bot action.                                              */
/*                                                                                                                   */
/*  irc_bot_start                     Starts the IRC bot.                                                            */
/*  irc_bot_stop                      Stops the IRC bot.                                                             */
/*                                                                                                                   */
/*  irc_bot_toggle_silence_mode       Toggles the silent status of the IRC bot.                                      */
/*                                                                                                                   */
/*  irc_bot_purge_message_queue       Purges the IRC bot's upcoming message queue.                                   */
/*                                                                                                                   */
/*  irc_bot_reset_history_form        Resets the search form of the IRC bot's message history table.                 */
/*  irc_bot_replay_history_entry      Triggers the replaying of an entry from the IRC bot's message history.         */
/*  irc_bot_delete_history_entry      Triggers the deletion of an entry from the IRC bot's message history.          */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Displays the selected bot action.
 *
 * @returns {void}
 */

function irc_bot_action_selector()
{
  // Fetch the value of the irc bot action selector
  page_name = document.getElementById('irc_bot_action_selector').value;

  // Hide all irc bot actions
  toggle_class_oneway('irc_bot_section', 0);

  // Display the requested irc bot actions
  toggle_element_oneway('irc_bot_' + page_name, 1);

  // If the main irc bot action is being selected, remove all URL parameters
  if(page_name == 'full')
    history.pushState({}, null, 'irc_bot');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'irc_bot?' + page_name);
}




/**
 * Starts the IRC bot.
 *
 * @param   {string}  starting_message  The message that will be displayed once the bot starts.
 *
 * @returns {void}
 */

function irc_bot_start(starting_message)
{
  // Send the starting message
  document.getElementById('irc_bot_start').innerHTML = '<h2 class="align_center padding_top text_green">' + starting_message + '</h2>';

  // Trigger the actual bot launch
  fetch_page('irc_bot_start?start', 'irc_bot_start');
}




/**
 * Stops the IRC bot.
 *
 * @returns {void}
 */

function irc_bot_stop()
{
  // Trigger the death of the IRC bot
  fetch_page('irc_bot?stop', 'irc_bot_stop', 'irc_bot_stop=1');
}




/**
 * Toggles the silent status of the IRC bot.
 *
 * @returns {void}
 */

function irc_bot_toggle_silence_mode()
{
  // Trigger the death of the IRC bot
  fetch_page('irc_bot?silence', 'irc_bot_silence', 'irc_bot_toggle_silence_mode=1');
}




/**
 * Purges the IRC bot's upcoming message queue.
 *
 * @param   {int}     purge_line_number       The line number to purge, 0 to purge all lines
 * @param   {string}  [confirmation_message]  The message that will be displayed if a complete purge is ordered
 *
 * @returns {void}
 */

function irc_bot_purge_message_queue( purge_line_number             ,
                                      confirmation_message  = null  )
{
  // Make sure the user knows what they're doing
  if(confirmation_message)
  {
    if(!confirm(confirmation_message))
      return;
  }

  // Assemble the postdata
  postdata = 'purge_line_number=' + fetch_sanitize(purge_line_number);

  // Trigger the purge of the messages
  fetch_page('irc_bot?upcoming', 'irc_bot_upcoming', postdata);
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

function irc_bot_replay_history_entry(  log_id                ,
                                        confirmation_message  ,
                                        log_body              )
{
  // Make sure the user knows what they're doing
  if(!confirm(confirmation_message + '\n\n' + log_body + '\n\n'))
    return;

  // Assemble the postdata (need to submit the search data or the search would be lost)
  postdata  = 'dev_irc_bot_history_submit=1';
  postdata += '&dev_irc_bot_history_channel=' + fetch_sanitize_id('dev_irc_bot_history_channel');
  postdata += '&dev_irc_bot_history_message=' + fetch_sanitize_id('dev_irc_bot_history_message');
  postdata += '&dev_irc_bot_history_sent='    + fetch_sanitize_id('dev_irc_bot_history_sent');
  postdata += '&irc_bot_replay_log_id='       + fetch_sanitize(log_id);

  // Trigger the replaying of the log
  fetch_page('irc_bot?message_log', 'irc_bot_history_tbody', postdata);
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

function irc_bot_delete_history_entry(  log_id                ,
                                        confirmation_message  ,
                                        log_body              )
{
  // Make sure the user knows what they're doing
  if(!confirm(confirmation_message + '\n\n' + log_body + '\n\n'))
    return;

  // Assemble the postdata (need to submit the search data or the search would be lost)
  postdata  = 'dev_irc_bot_history_submit=1';
  postdata += '&dev_irc_bot_history_channel=' + fetch_sanitize_id('dev_irc_bot_history_channel');
  postdata += '&dev_irc_bot_history_message=' + fetch_sanitize_id('dev_irc_bot_history_message');
  postdata += '&dev_irc_bot_history_sent='    + fetch_sanitize_id('dev_irc_bot_history_sent');
  postdata += '&irc_bot_delete_log_id='       + fetch_sanitize(log_id);

  // Trigger the deletion of the log
  fetch_page('irc_bot?message_log', 'irc_bot_history_tbody', postdata);
}