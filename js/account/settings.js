/*********************************************************************************************************************/
/*                                                                                                                   */
/*  settings_nsfw_update            Triggers the updating of an account's nsfw settings.                             */
/*  settings_privacy_update         Triggers the updating of an account's privacy settings.                          */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Triggers the updating of an account's nsfw settings.
 *
 * @returns {void}
*/

function settings_nsfw_update()
{
  // Assemble the postdata
  postdata = 'account_settings_nsfw=' + fetch_sanitize_id('account_settings_nsfw');

  // Reveal the confirmation area
  toggle_element_oneway('account_settings_nsfw_confirm', 1);

  // Trigger the update
  fetch_page('settings_nsfw', 'account_settings_nsfw_confirm', postdata);
}




/**
 * Triggers the updating of an account's privacy settings.
 *
 * @param   {string}  third_party   The name of the third party setting being changed.
 *
 * @returns {void}
*/

function settings_privacy_update( third_party )
{
  // Assemble the field's name
  third_party_field = 'account_privacy_' + third_party;

  // Look up which value is checked
  third_party_value = (document.getElementById(third_party_field + '_0').checked) ? 0 : 1;

  // Assemble the postdata
  postdata  = 'account_privacy_change=true&';
  postdata += third_party_field + '=' + third_party_value;

  // Reveal the confirmation area
  toggle_element_oneway('account_settings_privacy_confirm', 1);

  // Trigger the update
  fetch_page('settings_privacy', 'account_settings_privacy_confirm', postdata);
}