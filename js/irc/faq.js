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
  ban_type = document.getElementById('irc_faq_section_selector').value;

  // Hide all currently selected FAQ sections
  toggle_class_oneway('irc_faq_section', 0);

  // Display the requested FAQ section
  toggle_element_oneway('irc_faq_' + ban_type, 1);

  // If the main FAQ section is being selected, remove all URL parameters
  if(ban_type == 'main')
    history.pushState({}, null, 'faq');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'faq?' + ban_type);
}