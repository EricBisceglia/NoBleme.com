/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_ban_add_swap_form     Changes the appearance of the ban form depending on whether it is a user or IP ban.  */
/*                                                                                                                   */
/*  admin_ban_fetch_log         Fetches a ban log.                                                                   */
/*  admin_ban_search_logs       Performs a search through the ban history logs.                                      */
/*  admin_ban_delete_log        Triggers the deletion of a ban history log.                                          */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Close the ban log popin if it is open upon loading the page
popin_close('ban_log_popin');


/**
 * Changes the appearance of the ban form depending on whether it is a user or IP ban.
 *
 * @returns {void}
 */

function admin_ban_add_swap_form()
{
  // Fetch the value of the ban type selector
  ban_type = document.getElementById('admin_ban_add_type').value;

  // Determine which elements should be hidden and which should be shown
  hide_element = (ban_type === 'user') ? 'admin_ban_add_swap_ip'   : 'admin_ban_add_swap_user';
  show_element = (ban_type === 'user') ? 'admin_ban_add_swap_user' : 'admin_ban_add_swap_ip';

  // Swap the forms
  toggle_class_oneway(hide_element, 0);
  toggle_class_oneway(show_element, 1);
}




/**
 * Fetches a ban log.
 *
 * @param   {int} log_id      The ID of the ban log to fetch.
 * @param   {int} [ban_id]    The ID of the banned user - will be used if the log id is unknown.
 * @param   {int} [ip_ban_id] The ID of an IP ban - will be used if both other ids are unknown.
 *
 * @returns {void}
 */

function admin_ban_fetch_log( log_id            ,
                              ban_id    = null  ,
                              ip_ban_id = null  )
{
  // Assemble the postdata
  postdata  =   'log_id='     + fetch_sanitize(log_id);
  if(ban_id)
    postdata += '&ban_id='    + fetch_sanitize(ban_id);
  if(ip_ban_id)
    postdata += '&ip_ban_id=' + fetch_sanitize(ip_ban_id);

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




/**
 * Triggers the deletion of a ban history log.
 *
 * @param   {int}     log_id    The id of the ban history log.
 * @param   {string}  message   The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function admin_ban_delete_log(  log_id  ,
                                message )
{
  // Make sure the user knows what they're doing and fetch the data
  if(confirm(message))
    fetch_page('ban', 'admin_ban_logs_tbody', 'admin_ban_logs_delete=' + log_id);
}