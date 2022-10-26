/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_metrics_search    Performs a search through the metrics.                                                   */
/*  admin_metrics_reset     Triggers the resetting of page metrics.                                                  */
/*                                                                                                                   */
/*  admin_views_search      Performs a search through the pageviews.                                                 */
/*  admin_views_delete      Triggers the deletion of an entry in the pageviews.                                      */
/*                                                                                                                   */
/*  admin_users_search      Performs a search through the users.                                                     */
/*  admin_guests_search     Performs a search through the guests.                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Performs a search through the metrics.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function admin_metrics_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('stats_metrics_sort').value = sort_data;

  // Assemble the postdata
  postdata  = 'stats_metrics_sort='             + fetch_sanitize_id('stats_metrics_sort');
  postdata += '&stats_metrics_search_url='      + fetch_sanitize_id('stats_metrics_search_url');
  postdata += '&stats_metrics_search_queries='  + fetch_sanitize_id('stats_metrics_search_queries');
  postdata += '&stats_metrics_search_load='     + fetch_sanitize_id('stats_metrics_search_load');

  // Submit the search
  fetch_page('stats_metrics', 'stats_metrics_tbody', postdata);
}





/**
 * Triggers the resetting of page metrics.
 *
 * @param   {string}  message   The confirmation message which will be displayed.
 * @param   {int}     [page_id] The id of the page to reset - or no id to reset all.
 *
 * @returns {void}
 */

function admin_metrics_reset( message         ,
                              page_id = null  )
{
  // Set the page_id to 0 if none is specified
  if(!page_id)
    page_id = 0;

  // Assemble the postdata
  postdata = 'admin_metrics_reset=' + fetch_sanitize(page_id);

  // Decide which element should be targetted
  target_element = (page_id) ? 'admin_metrics_row_' + page_id : 'admin_metrics_table';

  // Make sure the user knows what they're doing and reset the metrics
  if(confirm(message))
    fetch_page('stats_metrics', target_element, postdata);
}




/**
 * Performs a search through the pageviews.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function admin_views_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('stats_views_sort').value = sort_data;

  // Assemble the postdata
  postdata  = 'stats_views_sort='   + fetch_sanitize_id('stats_views_sort');
  postdata += '&stats_views_name='  + fetch_sanitize_id('stats_views_name');

  // Submit the search
  fetch_page('stats_views', 'stats_views_tbody', postdata);
}




/**
 * Triggers the deletion of an entry in the pageviews.
 *
 * @param   {string}  message   The confirmation message which will be displayed.
 * @param   {int}     page_id   The id of the page to delete.
 *
 * @returns {void}
 */

function admin_views_delete(  message ,
                              page_id )
{
  // Assemble the postdata
  postdata = 'admin_views_delete=' + fetch_sanitize(page_id);

  // Assemble the targetted element's id
  target_element = 'admin_views_row_' + page_id;

  // Make sure the user knows what they're doing and trigger the deletion
  if(confirm(message))
    fetch_page('stats_views', target_element, postdata);
}




/**
 * Performs a search through the users.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function admin_users_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('stats_users_sort').value = sort_data;

  // Assemble the postdata
  postdata    = 'stats_users_sort='             + fetch_sanitize_id('stats_users_sort');
  postdata   += '&stats_users_search_username=' + fetch_sanitize_id('stats_users_username');
  postdata   += '&stats_users_search_created='  + fetch_sanitize_id('stats_users_created');
  if(document.getElementById('stats_users_page'))
    postdata += '&stats_users_search_page='     + fetch_sanitize_id('stats_users_page');
  if(document.getElementById('stats_users_action'))
    postdata += '&stats_users_search_action='   + fetch_sanitize_id('stats_users_action');
  postdata   += '&stats_users_search_language=' + fetch_sanitize_id('stats_users_language');
  postdata   += '&stats_users_search_speaks='   + fetch_sanitize_id('stats_users_speaks');
  postdata   += '&stats_users_search_theme='    + fetch_sanitize_id('stats_users_theme');
  if(document.getElementById('stats_users_birthday'))
    postdata += '&stats_users_search_birthday=' + fetch_sanitize_id('stats_users_birthday');
  postdata   += '&stats_users_search_profile='  + fetch_sanitize_id('stats_users_profile');
  postdata   += '&stats_users_search_settings=' + fetch_sanitize_id('stats_users_settings');

  // Submit the search
  fetch_page('stats_users', 'stats_users_tbody', postdata);
}




/**
 * Performs a search through the guests.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function admin_guests_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('stats_guests_sort').value = sort_data;

  // Assemble the postdata
  postdata    = 'stats_guests_sort='              + fetch_sanitize_id('stats_guests_sort');
  if(document.getElementById('stats_guests_identity'))
    postdata += '&stats_guests_search_identity='  + fetch_sanitize_id('stats_guests_identity');
  postdata   += '&stats_guests_search_page='      + fetch_sanitize_id('stats_guests_page');
  postdata   += '&stats_guests_search_language='  + fetch_sanitize_id('stats_guests_language');
  postdata   += '&stats_guests_search_theme='     + fetch_sanitize_id('stats_guests_theme');

  // Submit the search
  fetch_page('stats_guests', 'stats_guests_tbody', postdata);
}