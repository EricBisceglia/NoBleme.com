/*********************************************************************************************************************/
/*                                                                                                                   */
/*  users_inbox_search          Performs a search through a user's private messages inbox.                           */
/*  users_message_open          Triggers the opening of a private message.                                           */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Close the private messages popin if it is open upon loading the page
popin_close('popin_private_message');


/**
 * Performs a search through a user's private messages inbox.
 *
 * @param   {string}  [sort_data]   The column which should be used to sort the data.
 *
 * @returns {void}
*/

function users_inbox_search( sort_data = null )
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

  // Submit the search
  fetch_page('inbox', 'inbox_tbody', postdata);
}




/**
 * Triggers the opening of a private message.
 *
 * @param   {int}   message_id  The private message's id.
 *
 * @returns {void}
*/

function users_message_open( message_id )
{
  // Make it seem as if the message is unread in the message list
  document.getElementById('private_message_title_' + message_id).classList.remove('text_red');
  document.getElementById('private_message_title_' + message_id).classList.remove('glow');
  document.getElementById('private_message_title_' + message_id).classList.remove('bold');

  // Open the private message popin
  location.hash = '#popin_private_message';

  // Prepare the postdata
  postdata = 'private_message_id=' + fetch_sanitize(message_id);

  // Fetch the private message
  fetch_page('private_message', 'popin_private_message_body', postdata);
}