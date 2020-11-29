/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_metrics_search    Performs a search through the metrics.                                                   */
/*  admin_metrics_reset     Triggers the resetting of page metrics.                                                  */
/*                                                                                                                   */
/*  admin_views_search      Performs a search through the pageviews.                                                 */
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