/**
 * Displays functions of the selected type.
 *
 * @returns {void}
 */

function dev_functions_type_selector()
{
  // Fetch the requested type
  fetch_functions_type = document.getElementById('select_functions_list_type').value;

  // Update the page
  fetch_page('functions_list', 'dev_functions_list_body', 'functions_list_type=' + fetch_functions_type);
}