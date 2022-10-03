/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_settings_open             Opens the website.                                                                 */
/*  dev_settings_close            Closes the website.                                                                */
/*                                                                                                                   */
/*  dev_registrations_open        Allows new account creation.                                                       */
/*  dev_registrations_close       Forbids new account creation.                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Opens the website.
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
 * Closes the website.
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




/**
 * Allows new account creation.
 *
 * @returns {void}
 */

function dev_registrations_open()
{
  // Toggle the radio buttons
  document.getElementById('dev_settings_registration_0').checked = true;
  document.getElementById('dev_settings_registration_1').checked = false;

  // Display the website is open banner
  toggle_element_oneway('dev_settings_registration_on_message', true);

  // Hide the website is closed banner
  toggle_element_oneway('dev_settings_registration_off_message', false);

  // Open the website
  fetch_page('settings', 'dev_settings_dummy_div', 'dev_settings_open_registrations=1');
}




/**
 * Forbids new account creation.
 *
 * @returns {void}
 */

function dev_registrations_close()
{
  // Toggle the radio buttons
  document.getElementById('dev_settings_registration_0').checked = false;
  document.getElementById('dev_settings_registration_1').checked = true;

  // Hide the website is open banner
  toggle_element_oneway('dev_settings_registration_on_message', false);

  // Display the website is closed banner
  toggle_element_oneway('dev_settings_registration_off_message', true);

  // CLose the website
  fetch_page('settings', 'dev_settings_dummy_div', 'dev_settings_close_registrations=1');
}