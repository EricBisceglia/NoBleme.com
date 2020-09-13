// Close the ban log popin if it is open upon loading the page
popin_close('ban_log_popin');


/**
 * Fetches a ban log.
 *
 * @param   {int} log_id    The ID of the ban log to fetch.
 * @param   {int} [ban_id]  The ID of the banned user - will be used if the log id is unknown.
 *
 * @returns {void}
 */

function admin_ban_fetch_log( log_id          ,
                              ban_id  = null  )
{
  // Assemble the postdata
  postdata  = 'log_id='   + fetch_sanitize(log_id);
  if(ban_id)
    postdata += '&ban_id='  + fetch_sanitize(ban_id);

  // Fetch the requested ban log
  fetch_page('ban_log', 'admin_ban_popin_log', postdata);
}




/**
 * Performs a search through the ban history logs.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function admin_ban_search_logs( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('admin_ban_logs_sorting_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'admin_ban_logs_sorting_order='     + fetch_sanitize_id('admin_ban_logs_sorting_order');
  postdata += '&admin_ban_logs_search_username='  + fetch_sanitize_id('admin_ban_logs_search_username');
  postdata += '&admin_ban_logs_search_status='    + fetch_sanitize_id('admin_ban_logs_search_status');
  postdata += '&admin_ban_logs_search_banner='    + fetch_sanitize_id('admin_ban_logs_search_banner');
  postdata += '&admin_ban_logs_search_unbanner='  + fetch_sanitize_id('admin_ban_logs_search_unbanner');

  // Submit the search
  fetch_page('ban', 'admin_ban_logs_tbody', postdata);
}