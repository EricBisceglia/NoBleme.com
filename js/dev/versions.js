 /**
 * Shows the edit mode popin.
 *
 * @param   {int} version_id  The id of the version.
 *
 * @returns {void}
 */

function dev_versions_edit_popin(version_id)
{
  // Open the popin
  location.hash = "#dev_versions_popin";

  // Fetch the edit form
  fetch_page('versions_edit', 'dev_versions_popin_body', 'version_id=' + version_id);
}




 /**
 * Triggers the modification of a website release in the version history.
 *
 * @returns {void}
 */

function dev_versions_edit()
{
  // Close the popin
  popin_close('dev_versions_popin');

  // Prepare the postdata
  postdata  = 'dev_versions_edit='            + fetch_sanitize_id('dev_versions_edit_id');
  postdata += '&dev_versions_edit_major='     + fetch_sanitize_id('dev_versions_edit_major');
  postdata += '&dev_versions_edit_minor='     + fetch_sanitize_id('dev_versions_edit_minor');
  postdata += '&dev_versions_edit_patch='     + fetch_sanitize_id('dev_versions_edit_patch');
  postdata += '&dev_versions_edit_extension=' + fetch_sanitize_id('dev_versions_edit_extension');
  postdata += '&dev_versions_edit_date='      + fetch_sanitize_id('dev_versions_edit_date');

  // Submit the modification request
  fetch_page('versions', 'versions_list_table', postdata);
}




/**
 * Triggers the deletion of a website release in the version history.
 *
 * @param   {int}     version_id  The id of the version.
 * @param   {string}  message     The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function dev_versions_delete( version_id  ,
                              message     )
{
  // Make sure the user knows what they're doing and fetch the data
  if(confirm(message))
    fetch_page('versions_delete', 'versions_list_' + version_id, 'version_id=' + version_id);
}