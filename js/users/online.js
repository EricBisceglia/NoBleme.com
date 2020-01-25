///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Define a variable that prevents execution of parallel loops

users_online_loop = false;


/**
 * Alters the data shown in the table depending on the options selected above.
 *
 * @returns {void}
 */

function users_online_table_settings()
{
  // Prepare the postdata
  postdata  = 'online_hide_guests='  + Number(document.getElementById('online_hide_guests').checked);

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