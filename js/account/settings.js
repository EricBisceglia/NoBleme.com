/*********************************************************************************************************************/
/*                                                                                                                   */
/*  settings_nsfw_update            Triggers the updating of an account's nsfw settings.                             */
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