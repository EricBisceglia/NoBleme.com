/*********************************************************************************************************************/
/*                                                                                                                   */
/*  meetups_add_attendee_form       Opens the form which allows the addition of an attendee to a meetup.             */
/*  meetups_add_attendee            Submits the form and adds an attendee to a meetup.                               */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Opens the form which allows the addition of an attendee to a meetup.
 *
 * @returns {void}
*/

function meetups_add_attendee_form()
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

function meetups_add_attendee( meetup_id )
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

  // Submit the search
  fetch_page('meetup?id=' + meetup_id, 'meetup_attendees_table', postdata);
}