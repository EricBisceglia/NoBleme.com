///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Define a variable that prevents execution of parallel loops

users_online_loop = false;


/**
 * Alters the data shown in the table depending on the options selected above.
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