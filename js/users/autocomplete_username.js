/**
 * Updates the datalist used to autocomplete a username.
 *
 * @param   {string}  username_input_id   ID of the input containing the username.
 * @param   {string}  parent_element_id   ID of the element containing the datalist of the input being autocompleted.
 * @param   {string}  autocomplete_file   Path to the file which will do the autocompletion work.
 * @param   {string}  [datalist_id]       ID of the datalist to use for the suggested autocompletions.
 * @param   {string}  [autocomplete_type] Type of autocomplete to use (for ex. 'ban' if using the ban user page).
 * @param   {string}  [autocomplete_id]   ID to use with the autocomplete type (for ex. a meetup id).
 *
 * @returns {void}
 */

function autocomplete_username( username_input            ,
                                target_element            ,
                                autocomplete_file         ,
                                datalist_id       = null  ,
                                autocomplete_type = null  ,
                                autocomplete_id   = null  )
{
  // Fetch the current input data
  username = fetch_sanitize_id(username_input);

  // Assemble the postdata
  postdata = 'autocomplete_username=' + fetch_sanitize_id(username_input);
  if(datalist_id)
    postdata += '&autocomplete_datalist=' + fetch_sanitize(datalist_id);
  if(autocomplete_type)
    postdata += '&autocomplete_type=' + fetch_sanitize(autocomplete_type);
  if(autocomplete_id)
    postdata += '&autocomplete_id=' + fetch_sanitize(autocomplete_id);

  // Submit the fetch request
  fetch_page(autocomplete_file, target_element, postdata);
}