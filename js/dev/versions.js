 /**
 * Triggers the deletion of a website release in the version history.
 *
 * @param   {int}     version_id  The id of the version.
 * @param   {string}  message     The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function dev_versions_delete(version_id, message)
{
  // Make sure the user knows what they're doing and fetch the data
  if(confirm(message))
    fetch_page('versions_delete', 'versions_list_' + version_id, 'version_id=' + version_id);
}