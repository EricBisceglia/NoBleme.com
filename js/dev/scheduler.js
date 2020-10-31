/**
 * Performs a search through the scheduler entries and logs.
 *
 * @param   {string}  [sort_data]   Change the order in which the data will be sorted.
 * @param   {string}  [delete_task] Triggers the deletion of a future task with the specified id.
 * @param   {string}  [delete_log]  Triggers the deletion of a log with the specified id.
 *
 * @returns {void}
*/

function dev_scheduler_list_search( sort_data   = null  ,
                                    delete_task = null  ,
                                    delete_log  = null  )
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

  // Delete a line if requested
  if(delete_task)
    postdata += '&scheduler_task_delete=' + fetch_sanitize(delete_task);
  if(delete_log)
    postdata += '&scheduler_log_delete=' + fetch_sanitize(delete_log);

  // Submit the search
  fetch_page('scheduler', 'scheduler_list_tbody', postdata);
}




/**
 * Triggers the deletion of a scheduled task.
 *
 * @param   {int}     task_id The id of the scheduled task.
 * @param   {string}  message The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function dev_scheduler_delete_task( task_id ,
                                    message )
{
  // Make sure the user knows what they're doing, then submit the deletion request
  if(confirm(message))
    dev_scheduler_list_search(null, task_id);
}




/**
 * Triggers the deletion of a scheduler history log.
 *
 * @param   {int}     log_id    The id of the scheduler log.
 * @param   {string}  message   The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function dev_scheduler_delete_log(  log_id  ,
                                    message )
{
  // Make sure the user knows what they're doing, then submit the deletion request
  if(confirm(message))
    dev_scheduler_list_search(null, null, log_id);
}