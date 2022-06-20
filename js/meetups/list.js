/*********************************************************************************************************************/
/*                                                                                                                   */
/*  meetups_list_search           Performs a search through the meetups list                                         */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Performs a search through the meetups list
 *
 * @param   {string}  [sort_data]   Change the order in which the data will be sorted.
 *
 * @returns {void}
*/

function meetups_list_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('meetups_list_search_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'meetups_list_search_order='  + fetch_sanitize_id('meetups_list_search_order');
  postdata += '&meetups_list_date='         + fetch_sanitize_id('meetups_list_date');
  postdata += '&meetups_list_language='     + fetch_sanitize_id('meetups_list_language');
  postdata += '&meetups_list_location='     + fetch_sanitize_id('meetups_list_location');
  postdata += '&meetups_list_attendees='    + fetch_sanitize_id('meetups_list_attendees');
  postdata += '&meetups_search_attendee='   + fetch_sanitize_id('meetups_search_attendee');
  postdata += '&meetups_list_search=1';

  // Submit the search
  fetch_page('list', 'meetups_list_tbody', postdata);
}
