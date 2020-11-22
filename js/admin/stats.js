/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_metrics_reset     Triggers the resetting of page metrics.                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/


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