/*********************************************************************************************************************/
/*                                                                                                                   */
/*  meetups_attendee_add_form       Opens the form which allows the addition of an attendee to a meetup.             */
/*  meetups_attendee_add            Submits the form and adds an attendee to a meetup.                               */
/*                                                                                                                   */
/*  meetups_attendee_edit_form      Opens the form which allows the modification of a meetup's attendee.             */
/*  meetups_attendee_edit_hide      Hides the form which allows the modification of a meetup's attendee.             */
/*  meetups_attendee_edit           Submits the form and edits a meetup attendee.                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Opens the form which allows the addition of an attendee to a meetup.
 *
 * @returns {void}
*/

function meetups_attendee_add_form()
{
  // Display or hide the div containing the form
  toggle_element('meetup_add_attendee_form');
}




/**
 * Submits the form and adds an attendee to a meetup.
 *
 * @param   {int}   meetup_id   The ID of the meetup to which the attendee will be added.
 *
 * @returns {void}
*/

function meetups_attendee_add( meetup_id )
{
  // Assemble the postdata
  postdata  = 'meetup_id='                      + fetch_sanitize(meetup_id);
  postdata += '&meetup_attendees_add_account='  + fetch_sanitize_id('meetup_attendees_add_account');
  postdata += '&meetup_attendees_add_nickname=' + fetch_sanitize_id('meetup_attendees_add_nickname');
  postdata += '&meetup_attendees_add_extra_en=' + fetch_sanitize_id('meetup_attendees_add_extra_en');
  postdata += '&meetup_attendees_add_extra_fr=' + fetch_sanitize_id('meetup_attendees_add_extra_fr');
  postdata += '&meetup_attendees_add_lock='     + document.getElementById('meetup_attendees_add_lock').checked;
  postdata += '&meetup_attendees_add_submit=true';

  // Hide and reset the form
  toggle_element_oneway('meetup_add_attendee_form', 0);
  document.getElementById('meetup_add_attendee_form_body').reset();

  // Submit the query
  fetch_page('meetup?id=' + meetup_id, 'meetup_attendees_table', postdata);
}



/**
 * Opens the form which allows the modification of a meetup's attendee.
 *
 * @param   {int}   attendee_id   The user ID of the attendee to edit.
 *
 * @return  {void}
 */

function meetups_attendee_edit_form( attendee_id )
{
  // If the requested form is already open, simply close it
  if(element_is_toggled('meetup_edit_attendee_form_' + attendee_id))
  {
    toggle_element_oneway('meetup_edit_attendee_form_' + attendee_id, 0);
    return;
  }

  // Hide all other modification forms
  toggle_class_oneway('meetup_edit_attendee_form', 0);

  // Display the appropriate modification form
  toggle_element_oneway('meetup_edit_attendee_form_' + attendee_id, 1, 'table-row');

  // Assemble the postdata
  postdata = "attendee_id=" + fetch_sanitize(attendee_id);

  // Fetch the modification form
  fetch_page('attendee_edit', 'meetup_edit_attendee_form_' + attendee_id, postdata);
}




/**
 * Hides the form which allows the modification of a meetup's attendee.
 *
 * @return  {void}
 */

function meetups_attendee_edit_hide( )
{
  // Close all open modification forms
  toggle_class_oneway('meetup_edit_attendee_form', 0);
}




/**
 * Submits the form and edits a meetup attendee.
 *
 * @param   {int}   meetup_id     The ID of the meetup to which the attendee belongs.
 * @param   {int}   attendee_id   The user ID of the attendee to edit.
 *
 * @return  {void}
 */

function meetups_attendee_edit( meetup_id   ,
                                attendee_id )
{
  // Assemble the postdata
  postdata  = 'meetup_id='                      + fetch_sanitize(meetup_id);
  postdata += '&meetup_attendee_edit_id='       + fetch_sanitize(attendee_id);
  postdata += '&meetup_attendee_edit_account='  + fetch_sanitize_id('meetup_attendee_edit_account_' + attendee_id);
  postdata += '&meetup_attendee_edit_nickname=' + fetch_sanitize_id('meetup_attendee_edit_nickname_' + attendee_id);
  postdata += '&meetup_attendee_edit_extra_en=' + fetch_sanitize_id('meetup_attendee_edit_extra_en_' + attendee_id);
  postdata += '&meetup_attendee_edit_extra_fr=' + fetch_sanitize_id('meetup_attendee_edit_extra_fr_' + attendee_id);
  postdata += '&meetup_attendee_edit_lock='     + document.getElementById('meetup_attendee_edit_lock_' + attendee_id).checked;
  postdata += '&meetup_attendees_edit_submit=true';

  // Hide the modification form
  toggle_class_oneway('meetup_edit_attendee_form', 0);

  // Submit the query
  fetch_page('meetup?id=' + meetup_id, 'meetup_attendees_table', postdata);
}