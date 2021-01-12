/*********************************************************************************************************************/
/*                                                                                                                   */
/*  users_profile_preview         Previews a user's public profile.                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Previews a user's public profile.
 *
 * @param   {string}  input_id  The id of the input textarea containing the text to show in the preview area.
 *
 * @return  {void}
 */

function users_profile_preview( input_id )
{
  // Show the preview area
  toggle_element_oneway('users_profile_text_preview_container', 1);

  // Preview the message
  preview_bbcodes(input_id, 'users_profile_text_preview');
}