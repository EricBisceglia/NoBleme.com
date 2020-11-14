/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_ban_search_logs       Performs a search through the deactivated accounts.                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Performs a search through the deactivated accounts.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function admin_ban_search_logs( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('admin_reactivate_sort').value = sort_data;

  // Assemble the postdata
  postdata  = 'admin_reactivate_sort='      + fetch_sanitize_id('admin_reactivate_sort');
  postdata += '&admin_reactivate_id='       + fetch_sanitize_id('admin_reactivate_id');
  postdata += '&admin_reactivate_username=' + fetch_sanitize_id('admin_reactivate_username');

  // Submit the search
  fetch_page('deactivate', 'admin_reactivate_tbody', postdata);
}
