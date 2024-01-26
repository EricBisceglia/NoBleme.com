/*********************************************************************************************************************/
/*                                                                                                                   */
/*  activity_submit_menus       Submits the dropdwon menus that control which activity logs are shown.               */
/*                                                                                                                   */
/*  activity_show_details       Displays the details of an activity log.                                             */
/*  activity_delete_log         Triggers the deletion of an activity log.                                            */
/*  activity_restore_log        Restores a soft deleted activity log.                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Submits the dropdwon menus that control which activity logs are shown.
 *
 * @param   {string}  fetch_url       The url that should be called dynamically.
 * @param   {bool}    toggle_deleted  If set, toggles between visible and deleted view.
 *
 * @returns {void}
 */

function activity_submit_menus( fetch_url               ,
                                toggle_deleted  = null  )
{
  // Toggle between visible and deleted view if required
  if(toggle_deleted)
  {
    deleted_status = document.getElementById('activity_deleted').value;
    deleted_status = (deleted_status === 1) ? 0 : 1;
    document.getElementById('activity_deleted').value = deleted_status;
  }

  // Prepare the postdata
  postdata  = 'activity_amount='    + fetch_sanitize_id('activity_amount');
  postdata += '&activity_type='     + fetch_sanitize_id('activity_type');
  postdata += '&activity_deleted='  + fetch_sanitize_id('activity_deleted');

  // Prepare the custom query string
  query_string      = window.location.search;
  base_query        = (query_string.startsWith('?mod') || fetch_sanitize_id('activity_type') != 'all') ? '?' : '';
  mod_query         = (query_string.startsWith('?mod')) ? 'mod' : '';
  mid_query         = (query_string.startsWith('?mod') && fetch_sanitize_id('activity_type') != 'all') ? '&' : '';
  activity_query    = (fetch_sanitize_id('activity_type') != 'all') ? fetch_sanitize_id('activity_type') : '';
  new_query_string  = base_query + mod_query + mid_query + activity_query;

  // Rewrite the URL with the custom query string
  window.history.pushState({}, document.title, window.location.pathname + new_query_string);

  // Fetch the data
  fetch_page(fetch_url, 'activity_body', postdata);
}




/**
 * Displays the details of an activity log.
 *
 * @param   {int}     log_id  The id of the activity log.
 *
 * @returns {void}
 */

function activity_show_details(log_id)
{
  // Toggle the visiblity of the details
  toggle_element('activity_details_' + log_id, 'table-row');

  // Prepare the postdata
  postdata = 'log_id=' + log_id;

  // Fetch the data
  fetch_page('activity_details', 'activity_details_' + log_id, postdata);
}




/**
 * Triggers the deletion of an activity log.
 *
 * @param   {int}     log_id        The id of the activity log.
 * @param   {string}  message       The confirmation message which will be displayed.
 * @param   {bool}    deletion_type Whether this call should trigger a soft (0) or hard (1) delete.
 *
 * @returns {void}
 */

function activity_delete_log( log_id            ,
                              message           ,
                              deletion_type = 0 )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Hide the details if they exist and are currently visible
    if(document.getElementById('activity_details_' + log_id))
      toggle_element_oneway('activity_details_' + log_id, 0, 'table-row');

    // Prepare the postdata
    postdata  = 'log_id='         + log_id;
    postdata += '&deletion_type=' + deletion_type;

    // Fetch the data
    fetch_page('activity_delete', 'activity_row_' + log_id, postdata);
  }
}




/**
 * Restores a soft deleted activity log.
 *
 * @param   {int}     log_id        The id of the activity log.
 *
 * @returns {void}
 */

function activity_restore_log(log_id)
{
  // Hide the details if they exist and are currently visible
  if(document.getElementById('activity_details_' + log_id))
    toggle_element_oneway('activity_details_' + log_id, 0, 'table-row');

  // Prepare the postdata
  postdata = 'log_id=' + log_id;

  // Fetch the data
  fetch_page('activity_restore', 'activity_row_' + log_id, postdata);
}