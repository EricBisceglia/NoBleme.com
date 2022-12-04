/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_mail_display              Displays the contents of the desired admin mail.                                 */
/*  admin_mail_search               Searches through the admin mail.                                                 */
/*  admin_mail_reply                Opens the form allowing to write a reply to admin mail.                          */
/*  admin_mail_reply_preview        Previews the reply to an admin mail.                                             */
/*  admin_mail_reply_send           Triggers the sending of a reply to an admin mail.                                */
/*  admin_mail_delete               Triggers the deletion of an admin mail.                                          */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Displays the contents of the desired admin mail.
 *
 * @param   {int}  [message_id]   The ID of the message to display.
 *
 * @returns {void}
*/

function admin_mail_display( message_id = 0 )
{
  // Make the message appear read by removing its red glow in the message list
  css_remove('admin_mail_list_' + message_id, ['text_red', 'glow', 'bold']);

  // Assemble the postdata
  postdata = 'admin_mail_display_message=' + fetch_sanitize(message_id);

  // Trigger the message displaying
  fetch_page('inbox_message', 'admin_mail_main_panel', postdata);
}




/**
 * Searches through the admin mail.
 *
 * @returns {void}
 */

function admin_mail_search()
{
  // Assemble the postdata
  postdata = 'admin_mail_search=' + fetch_sanitize_id('admin_mail_search');

  // Trigger the search
  fetch_page('inbox', 'admin_mail_message_list', postdata);
}




/**
 * Opens the form allowing to write a reply to admin mail.
 *
 * @returns {void}
 */

function admin_mail_reply()
{
  // Hide the reply icon and button
  toggle_element_oneway('admin_mail_reply_icon', 0);
  toggle_element_oneway('admin_mail_reply_button', 0);

  // Show the reply box
  toggle_element_oneway('admin_mail_reply_container', 1);
}




/**
 * Previews the reply to an admin mail.
 *
 * @return  {void}
 */

function admin_mail_reply_preview()
{
  // Show the preview area
  toggle_element_oneway('admin_mail_preview_container', 1);

  // Preview the message
  preview_bbcodes('admin_mail_reply_textarea', 'admin_mail_preview');
}




/**
 * Triggers the sending of a reply to an admin mail.
 *
 * @param   {int}   message_id  The id of the private message.
 *
 * @return  {void}
 */

function admin_mail_reply_send( message_id )
{
  // Don't send empty messages
  if(!document.getElementById('admin_mail_reply_textarea').value)
  {
    css_add('admin_mail_reply_textarea', 'glow');
    return;
  }

  // Hide the reply box and the preview box
  toggle_element_oneway('admin_mail_reply_container', 0);
  toggle_element_oneway('admin_mail_preview_container', 0);

  // Show the reply acknowledgement
  toggle_element_oneway('admin_mail_reply_return', 1);

  // Prepare the postdata
  postdata  = 'admin_mail_id='    + fetch_sanitize(message_id);
  postdata += '&admin_mail_body=' + fetch_sanitize_id('admin_mail_reply_textarea');

  // Trigger the sending
  fetch_page('inbox_reply', 'admin_mail_reply_return', postdata);
}




/**
 * Triggers the deletion of an admin mail.
 *
 * @param   {int}   message_id        The ID of the private message.
 * @param   {int}   confirm_message   The confirmation message which will be displayed.
 *
 * @return  {void}
 */

function admin_mail_delete( message_id      ,
                            confirm_message )
{
  // Prepare the postdata
  postdata = 'admin_mail_id=' + fetch_sanitize(message_id);

  // Prepare the target element
  target = 'admin_mail_message_' + message_id;

  // Trigger the deletion and reload the right panel
  if(confirm(confirm_message))
    fetch_page('inbox_delete', target, postdata, admin_mail_search());
}