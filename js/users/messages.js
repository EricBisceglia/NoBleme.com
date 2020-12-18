/*********************************************************************************************************************/
/*                                                                                                                   */
/*  users_inbox_search            Performs a search through a user's private messages inbox.                         */
/*  users_outbox_search           Performs a search through a user's private messages outbox.                        */
/*                                                                                                                   */
/*  users_message_preview         Previews a private message.                                                        */
/*  users_message_open            Triggers the opening of a private message.                                         */
/*  users_message_reply           Opens the form allowing replying to a private message.                             */
/*  users_message_reply_preview   Previews the reply to a private message.                                           */
/*  users_message_reply_send      Triggers the sending of a reply to a private message.                              */
/*  users_message_delete          Triggers the deletion of a private message.                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Close the private messages popin if it is open upon loading the page
popin_close('popin_private_message');


/**
 * Performs a search through a user's private messages inbox.
 *
 * @param   {string}  [sort_data]         The column which should be used to sort the data.
 * @param   {bool}    [mark_as_read]      Marks all unread messages as read.
 * @param   {string}  [confirm_message]   The confirmation message which will be displayed before marking all as read.
 *
 * @returns {void}
*/

function users_inbox_search(  sort_data       = null ,
                              mark_as_read    = null ,
                              confirm_message = null  )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('inbox_sort_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'inbox_sort_order='     + fetch_sanitize_id('inbox_sort_order');
  postdata += '&inbox_search_title='  + fetch_sanitize_id('inbox_search_title');
  postdata += '&inbox_search_sender=' + fetch_sanitize_id('inbox_search_sender');
  postdata += '&inbox_search_date='   + fetch_sanitize_id('inbox_search_date');
  postdata += '&inbox_search_read='   + fetch_sanitize_id('inbox_search_read');

  // Mark all items as read if requested
  if(mark_as_read && confirm_message && confirm(confirm_message))
    postdata += '&inbox_mark_as_read='  + fetch_sanitize('mark_as_read');

  // Submit the search
  fetch_page('inbox', 'inbox_tbody', postdata);
}




/**
 * Performs a search through a user's private messages outbox.
 *
 * @param   {string}  [sort_data]   The column which should be used to sort the data.
 *
 * @returns {void}
*/

function users_outbox_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('outbox_sort_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'outbox_sort_order='        + fetch_sanitize_id('outbox_sort_order');
  postdata += '&outbox_search_title='     + fetch_sanitize_id('outbox_search_title');
  postdata += '&outbox_search_recipient=' + fetch_sanitize_id('outbox_search_recipient');
  postdata += '&outbox_search_date='      + fetch_sanitize_id('outbox_search_date');
  postdata += '&outbox_search_read='      + fetch_sanitize_id('outbox_search_read');

  // Submit the search
  fetch_page('outbox', 'outbox_tbody', postdata);
}




/**
 *  Previews a private message.
 *
 * @return  {void}
 */

function users_message_preview()
{
  // Show the preview area
  toggle_element_oneway('private_message_preview_container', 1);

  // Preview the message
  preview_bbcodes('private_message_body', 'private_message_preview');
}




/**
 * Triggers the opening of a private message.
 *
 * @param   {int}   message_id    The private message's id.
 * @param   {bool}  keep_unread   If true, the message will not appear as read in the message list.
 *
 * @returns {void}
*/

function users_message_open(  message_id          ,
                              keep_unread = null  )
{
  // Make it seem as if the message is read in the message list, unless specified otherwise
  if(!keep_unread)
  {
    document.getElementById('private_message_title_' + message_id).classList.remove('text_red');
    document.getElementById('private_message_title_' + message_id).classList.remove('glow');
    document.getElementById('private_message_title_' + message_id).classList.remove('bold');
  }

  // Open the private message popin
  location.hash = '#popin_private_message';

  // Prepare the postdata
  postdata = 'private_message_id=' + fetch_sanitize(message_id);

  // Fetch the private message
  fetch_page('private_message', 'popin_private_message_body', postdata);
}




/**
 * Opens the form allowing replying to a private message.
 *
 * @returns {void}
 */

function users_message_reply()
{
  // Hide the action buttons
  toggle_class_oneway('private_message_buttons', 0);

  // Show the reply form
  toggle_element_oneway('private_message_reply', 1);
}




/**
 *  Previews the reply to a private message.
 *
 * @return  {void}
 */

function users_message_reply_preview()
{
  // Show the preview area
  toggle_element_oneway('private_message_preview_area', 1);

  // Preview the message
  preview_bbcodes('private_message_reply_body', 'private_message_preview');
}




/**
 * Triggers the sending of a reply to a private message.
 *
 * @param   {int}   message_id  The id of the private message.
 *
 * @return  {void}
 */

function users_message_reply_send( message_id )
{
  // Don't send empty messages
  if(!document.getElementById('private_message_reply_body').value)
  {
    document.getElementById('private_message_reply_body').classList.add('glow');
    return;
  }

  // Hide the reply box
  toggle_element_oneway('private_message_reply', 0);

  // Show the reply acknowledgement
  toggle_element_oneway('private_message_reply_return', 1);

  // Prepare the postdata
  postdata  = 'private_message_id=' + fetch_sanitize(message_id);
  postdata += '&private_message_body=' + fetch_sanitize_id('private_message_reply_body');

  // Fetch the private message
  fetch_page('private_message_reply', 'private_message_reply_return', postdata);
}




/**
 * Triggers the deletion of a private message.
 *
 * @param   {int}     message_id        The id of the private message.
 * @param   {string}  confirm_message   The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function users_message_delete(  message_id      ,
                                confirm_message )
{
  // Make sure the user knows what they're doing
  if(confirm(confirm_message))
  {
    // Close the popin in case it is open
    popin_close('popin_private_message');

    // Trigger the deletion request
    fetch_page('private_message_delete', 'private_message_row_' + message_id, 'private_message_delete=' + message_id);
  }
}