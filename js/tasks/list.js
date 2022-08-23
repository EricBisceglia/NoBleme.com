/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tasks_list_search           Performs a search through the task list.                                             */
/*  tasks_list_details          Shows the details of a task in the task list.                                        */
/*                                                                                                                   */
/*  tasks_delete                Triggers the soft deletion of a task.                                                */
/*  tasks_restore               Triggers the restoration of a soft deleted task.                                     */
/*  tasks_delete_hard           Triggers the hard deletion of a task.                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Close the milestones popin if it is open upon loading the page
popin_close('task_categories_popin');


/**
 * Performs a search through the task list.
 *
 * @param   {string}  [sort_data]   Change the order in which the data will be sorted.
 *
 * @returns {void}
*/

function tasks_list_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('tasks_search_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'tasks_search_order='         + fetch_sanitize_id('tasks_search_order');
  postdata += '&tasks_search_id='           + fetch_sanitize_id('tasks_search_id');
  postdata += '&tasks_search_description='  + fetch_sanitize_id('tasks_search_description');
  postdata += '&tasks_search_status='       + fetch_sanitize_id('tasks_search_status');
  postdata += '&tasks_search_created='      + fetch_sanitize_id('tasks_search_created');
  postdata += '&tasks_search_reporter='     + fetch_sanitize_id('tasks_search_reporter');
  postdata += '&tasks_search_category='     + fetch_sanitize_id('tasks_search_category');
  postdata += '&tasks_search_goal='         + fetch_sanitize_id('tasks_search_goal');
  postdata += '&tasks_search_admin='        + fetch_sanitize_id('tasks_search_admin');
  postdata += '&tasks_search=1';

  // Submit the search
  fetch_page('list', 'tasks_list_tbody', postdata);
}




/**
 * Shows the details of a task in the task list.
 *
 * @param   {int}   [task_id]   The id of the task for which details will be displayed.
 *
 * @returns {void}
 */

function tasks_list_details( task_id )
{
  // Show the task details container
  toggle_element('tasks_list_row_' + task_id, 'table-row');

  // Assemble the postdata
  postdata = 'task_id=' + fetch_sanitize(task_id);

  // Fetch the task details
  fetch_page('task_details', 'tasks_list_' + task_id, postdata);
}




/**
 * Triggers the soft deletion of a task.
 *
 * @param   {string}  task_id   The ID of the task that should be soft deleted.
 * @param   {string}  message   The confirmation message which will be displayed prior to the deletion.
 *
 * @return  {void}
 */

 function tasks_delete( task_id ,
                        message )
{
  // Assemble the postdata
  postdata =  'task_id=' + fetch_sanitize(task_id);
  postdata += '&task_delete=1';

  // Trigger the deletion
  if(confirm(message))
    fetch_page('task_details', 'tasks_list_' + task_id, postdata);
}




/**
 * Triggers the restoration of a soft deleted task.
 *
 * @param   {string}  task_id   The ID of the task that should be restored.
 * @param   {string}  message   The confirmation message which will be displayed prior to the restoration.
 *
 * @return  {void}
 */

 function tasks_restore(  task_id ,
                          message )
{
  // Assemble the postdata
  postdata =  'task_id=' + fetch_sanitize(task_id);
  postdata += '&task_restore=1';

  // Trigger the restoration
  if(confirm(message))
    fetch_page('task_details', 'tasks_list_' + task_id, postdata);
}




/**
 * Triggers the hard deletion of a task.
 *
 * @param   {string}  task_id   The ID of the task that should be hard deleted.
 * @param   {string}  message   The confirmation message which will be displayed prior to the hard deletion.
 *
 * @return  {void}
 */

 function tasks_delete_hard(  task_id ,
                              message )
{
  // Assemble the postdata
  postdata =  'task_id=' + fetch_sanitize(task_id);
  postdata += '&task_delete_hard=1';

  // Trigger the hard deletion
  if(confirm(message))
    fetch_page('task_details', 'tasks_list_' + task_id, postdata);
}