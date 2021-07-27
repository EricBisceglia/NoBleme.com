/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tasks_list_search           Performs a search through the todo list.                                             */
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
