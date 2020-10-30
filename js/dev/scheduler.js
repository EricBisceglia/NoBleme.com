/**
 * Performs a search through the scheduler entries and logs.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function dev_scheduler_list_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('scheduler_search_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'scheduler_search_order='         + fetch_sanitize_id('scheduler_search_order');
  postdata += '&scheduler_search_type='         + fetch_sanitize_id('scheduler_search_type');
  postdata += '&scheduler_search_id='           + fetch_sanitize_id('scheduler_search_id');
  postdata += '&scheduler_search_date='         + fetch_sanitize_id('scheduler_search_date');
  postdata += '&scheduler_search_description='  + fetch_sanitize_id('scheduler_search_description');
  postdata += '&scheduler_search_report='       + fetch_sanitize_id('scheduler_search_report');

  // Submit the search
  fetch_page('scheduler', 'scheduler_list_tbody', postdata);
}