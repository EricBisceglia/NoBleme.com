/*********************************************************************************************************************/
/*                                                                                                                   */
/*  irc_channel_list_delete       Submits the deletion of an entry in the IRC channel list.                          */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Submits the deletion of an entry in the IRC channel list.
 *
 * @param   {int}     channel_id        The ID of the channel which will be deleted.
 * @param   {string}  confirm_message   The confirmation message which will be shown before deletion is triggered.
 *
 * @returns {void}
 */

function irc_channel_list_delete( channel_id      ,
                                  confirm_message )
{
  // Confirm the deletion
  if(!confirm(confirm_message))
    return;

  // Assemble the postdata
  postdata = 'channel_id=' + fetch_sanitize(channel_id);

  // Submit the deletion request
  fetch_page('irc_channel_delete', 'irc_channel_list_row_' + channel_id, postdata);
}