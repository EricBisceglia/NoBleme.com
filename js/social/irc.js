/*********************************************************************************************************************/
/*                                                                                                                   */
/*  irc_faq_display_section       Displays a specific section of the IRC chat FAQ.                                   */
/*                                                                                                                   */
/*  irc_channel_list_delete       Submits the deletion of an entry in the IRC channel list.                          */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Displays a specific section of the IRC chat FAQ.
 *
 * @returns {void}
 */

function irc_faq_display_section()
{
  // Fetch the value of the selction selector
  page_name = document.getElementById('irc_faq_section_selector').value;

  // Hide all currently selected FAQ sections
  toggle_class_oneway('irc_faq_section', 0);

  // Display the requested FAQ section
  toggle_element_oneway('irc_faq_' + page_name, 1);

  // Fetch the new page's title
  page_title = document.getElementById('irc_faq_name_' + page_name).value;

  // Update the header's title
  document.getElementById('irc_faq_title').innerHTML = page_title;

  // Fetch the page name suffix
  page_suffix = document.getElementById('irc_faq_name_suffix').value;

  // Update the page's title
  document.title = page_title + page_suffix;

  // If the main FAQ section is being selected, remove all URL parameters
  if(page_name == 'main')
    history.pushState({}, null, 'irc');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'irc?' + page_name);
}




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