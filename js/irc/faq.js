/*********************************************************************************************************************/
/*                                                                                                                   */
/*  irc_faq_display_section       Displays a specific section of the IRC chat FAQ.                                   */
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
    history.pushState({}, null, 'faq');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'faq?' + page_name);
}