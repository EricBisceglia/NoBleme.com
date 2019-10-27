/**
 * Submits the dropdwon menus that control which activity logs are shown.
 *
 * @param   {string}  path    The path to the root of the website.
 * @param   {string}  xhr_url The url that should be called by the xhr.
 *
 * @returns {void}
 */

function activity_submit_menus(path, xhr_url)
{
  // Prepare the postdata
  postdata  = 'activity_amount='  + xhr_sanitize_id('activity_amount');
  postdata += '&activity_type='   + xhr_sanitize_id('activity_type');

  // Send the xhr
  xhr_load(path, xhr_url, 'activity_body', postdata, 1);
}




/**
 * Displays the details of an activity log.
 *
 * @param   {string}  path    The path to the root of the website.
 * @param   {int}     log_id  The id of the activity log.
 *
 * @returns {void}
 */

function activity_show_details(path, log_id)
{
  // Toggle the visiblity of the details
  toggle_element('activity_details_' + log_id, 1);

  // Prepare the postdata
  postdata = 'log_id=' + log_id;

  // Send the xhr
  xhr_load(path, 'activity_details.xhr.php', 'activity_details_' + log_id, postdata, 1);
}




/**
 * Triggers the deletion of an activity log.
 *
 * @param   {string}  path        The path to the root of the website.
 * @param   {int}     log_id      The id of the activity log.
 * @param   {string}  message     The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function activity_delete_log(path, log_id, message)
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Hide the details if they exist and are currently visible
    if(document.getElementById('activity_details_' + log_id))
      toggle_element_oneway('activity_details_' + log_id, 0, 1);

    // Prepare the postdata
    postdata = 'log_id=' + log_id;

    // Send the xhr
    xhr_load(path, 'activity_delete.xhr.php', 'activity_row_' + log_id, postdata, 1);
  }
}