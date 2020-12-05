/*********************************************************************************************************************/
/*                                                                                                                   */
/*  users_online_table_settings     Alters the data shown in the "who's online" table.                               */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Define a variable that prevents execution of parallel loops on the "who's online" page
users_online_loop = false;


/**
 * Alters the data shown in the "who's online" table.
 *
 * @param   {bool}  user_is_administrator   Whether the user is an administrator.
 *
 * @returns {void}
 */

function users_online_table_settings(user_is_administrator = 0)
{
  // Prepare the postdata
  postdata  = 'online_hide_guests=' + Number(document.getElementById('online_hide_guests').checked);
  if(user_is_administrator)
    postdata += '&online_admin_view=' + Number(document.getElementById('online_admin_view').checked);

  // Update the table
  fetch_page('online', 'users_online_table', postdata);

  // Clear all instances of the function looping
  if(users_online_loop)
  {
    clearTimeout(users_online_loop);
    users_online_loop = 0;
  }

  // Loop this function as long as the appropriate box is checked
  if(document.getElementById('online_refresh').checked)
    users_online_loop = setTimeout(function() { users_online_table_settings(); }, 10000);
}




/**
 * Performs a search through the registered users list.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function users_list_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('users_list_sort').value = sort_data;

  // Assemble the postdata
  postdata  = 'users_list_sort='                + fetch_sanitize_id('users_list_sort');
  postdata += '&users_list_search_username='    + fetch_sanitize_id('users_list_search_username');
  postdata += '&users_list_search_registered='  + fetch_sanitize_id('users_list_search_registered');
  postdata += '&users_list_search_activity='    + fetch_sanitize_id('users_list_search_activity');
  postdata += '&users_list_search_languages='   + fetch_sanitize_id('users_list_search_languages');
  postdata += '&users_list_search_id='          + fetch_sanitize_id('users_list_search_id');

  // Submit the search
  fetch_page('list', 'users_list_tbody', postdata);
}