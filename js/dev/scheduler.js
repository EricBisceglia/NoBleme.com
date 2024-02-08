/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_scheduler_run                 Triggers a manual execution of the scheduler.                                  */
/*  dev_scheduler_turn_off            Triggers a shutdown of the scheduler.                                          */
/*  dev_scheduler_turn_on             Triggers a reopening of the scheduler.                                         */
/*                                                                                                                   */
/*  dev_scheduler_list_search         Performs a search through the scheduler entries and logs.                      */
/*  dev_scheduler_edit_popin          Shows the edit mode popin.                                                     */
/*  dev_scheduler_edit                Triggers the modification of a scheduled task.                                 */
/*  dev_scheduler_delete_task         Triggers the deletion of a scheduled task.                                     */
/*  dev_scheduler_delete_log          Triggers the deletion of a scheduler history log.                              */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Triggers a manual execution of the scheduler.
 *
 * @param   {string}  [confirm_message]   Warning message shown before the scheduler can be ran.
 *
 * @returns {void}
 */

function dev_scheduler_run( confirm_message = '' )
{
  // Confirm that the scheduler should be run manually
  if(confirm(confirm_message))
  {
    // Run the scheduler manually
    document.getElementById('dev_scheduler_action').value = 'dev_scheduler_run';
    document.getElementById('dev_scheduler').submit();
  }
}




/**
 * Triggers a shutdown of the scheduler.
 *
 * @param   {string}  [confirm_message]   Warning message shown before the scheduler is disabled.
 *
 * @returns {void}
 */

function dev_scheduler_turn_off( confirm_message = '' )
{
  // Confirm that the scheduler should be turned off
  if(confirm(confirm_message))
  {
    // Turn off the scheduler
    document.getElementById('dev_scheduler_action').value = 'dev_scheduler_turn_off';
    document.getElementById('dev_scheduler').submit();
  }
}




/**
 * Triggers a reopening of the scheduler.
 *
 * @param   {string}  [confirm_message]   Warning message shown before the scheduler is turned back on.
 *
 * @returns {void}
 */

function dev_scheduler_turn_on( confirm_message = '' )
{
  // Confirm that the scheduler should be turned back on
  if(confirm(confirm_message))
  {
    // Turn the scheduler back on
    document.getElementById('dev_scheduler_action').value = 'dev_scheduler_turn_on';
    document.getElementById('dev_scheduler').submit();
  }
}




/**
 * Performs a search through the scheduler entries and logs.
 *
 * @param   {string}  [sort_data]   Change the order in which the data will be sorted.
 * @param   {string}  [edit_task]   Triggers the modification of a scheduled task with the specified id.
 * @param   {string}  [delete_task] Triggers the deletion of a future task with the specified id.
 * @param   {string}  [delete_log]  Triggers the deletion of a log with the specified id.
 *
 * @returns {void}
*/

function dev_scheduler_list_search( sort_data   = null  ,
                                    edit_task   = null  ,
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

  // Edit a line if requested
  if(edit_task)
  {
    postdata += '&dev_scheduler_edit='          + fetch_sanitize(edit_task);
    postdata += '&dev_scheduler_edit_date='     + fetch_sanitize_id('dev_scheduler_edit_date');
    postdata += '&dev_scheduler_edit_time='     + fetch_sanitize_id('dev_scheduler_edit_time');
  }

  // Delete a line if requested
  if(delete_task)
    postdata += '&scheduler_task_delete='       + fetch_sanitize(delete_task);
  if(delete_log)
    postdata += '&scheduler_log_delete='        + fetch_sanitize(delete_log);

  // Submit the search
  fetch_page('scheduler', 'scheduler_list_tbody', postdata);
}




 /**
 * Shows the edit mode popin.
 *
 * @param   {int}   task_id   The id of the scheduled task to edit.
 *
 * @returns {void}
 */

function dev_scheduler_edit_popin( task_id )
{
  // Open the popin
  location.hash = "#dev_scheduler_popin";

  // Fetch the edit form
  fetch_page('scheduler_edit', 'dev_scheduler_popin_body', 'task_id=' + fetch_sanitize(task_id));
}




 /**
 * Triggers the modification of a scheduled task.
 *
 * @param   {int}   task_id   The id of the scheduled task to edit.
 *
 * @returns {void}
 */

function dev_scheduler_edit(task_id)
{
  // Close the popin
  popin_close('dev_scheduler_popin');

  // Submit the modification request
  dev_scheduler_list_search(null, task_id);
}





/**
 * Triggers the deletion of a scheduled task.
 *
 * @param   {int}     task_id   The id of the scheduled task.
 * @param   {string}  message   The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function dev_scheduler_delete_task( task_id ,
                                    message )
{
  // Make sure the user knows what they're doing, then submit the deletion request
  if(confirm(message))
    dev_scheduler_list_search(null, null, task_id);
}




/**
 * $
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
    dev_scheduler_list_search(null, null, null, log_id);
}