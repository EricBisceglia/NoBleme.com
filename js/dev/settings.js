/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_settings_open     Opens the website.                                                                         */
/*  dev_settings_close    Closes the website.                                                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Opens the website
 *
 * @returns {void}
 */

function dev_settings_open()
{
  // Toggle the radio buttons
  document.getElementById('dev_settings_close_0').checked = true;
  document.getElementById('dev_settings_close_1').checked = false;

  // Display the website is open banner
  toggle_element_oneway('dev_settings_open_message', true);

  // Hide the website is closed banner
  toggle_element_oneway('dev_settings_close_message', false);

  // Open the website
  fetch_page('settings', 'dev_settings_dummy_div', 'dev_settings_open_website=1');

  // Hide the header banner if it exists
  if(document.getElementById('header_topmenu_closed'))
    toggle_element_oneway('header_topmenu_closed', false);
}




/**
 * Closes the website
 *
 * @returns {void}
 */

function dev_settings_close()
{
  // Toggle the radio buttons
  document.getElementById('dev_settings_close_0').checked = false;
  document.getElementById('dev_settings_close_1').checked = true;

  // Hide the website is open banner
  toggle_element_oneway('dev_settings_open_message', false);

  // Display the website is closed banner
  toggle_element_oneway('dev_settings_close_message', true);

  // CLose the website
  fetch_page('settings', 'dev_settings_dummy_div', 'dev_settings_close_website=1');
}