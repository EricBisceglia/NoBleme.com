/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tasks_list_search           Performs a search through the todo list.                                             */
/*  tasks_list_details          Shows the details of a task in the todo list.                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Performs a search through the todo list.
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
 * Shows the details of a task in the todo list.
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
  fetch_page('task_details', 'tasks_list_' + task_id, postdata, null, null, null, 1);
}