/**
 * Displays the selected code snippets
 *
 * @returns {void}
 */

function dev_snippet_selector()
{
  // Fetch the requested snippet
  fetch_snippet = document.getElementById('select_snippet').value;

  // Update the page
  fetch_page('doc_snippets', 'dev_snippets_body', 'snippet=' + fetch_snippet);
}




/**
 * Displays the selected CSS palette.
 *
 * @returns {void}
 */

function dev_palette_selector()
{
  // Fetch the requested palette
  fetch_palette = document.getElementById('select_css_palette').value;

  // Update the page
  fetch_page('doc_css_palette', 'dev_palette_body', 'palette=' + fetch_palette);
}




/**
 * Displays the selected JS toolbox.
 *
 * @returns {void}
 */

function dev_js_toolbox_selector()
{
  // Fetch the requested toolbox
  fetch_toolbox = document.getElementById('select_js_toolbox').value;

  // Update the page
  fetch_page('doc_js_toolbox', 'dev_js_toolbox_body', 'js_toolbox=' + fetch_toolbox);
}




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
  fetch_page('doc_functions', 'dev_functions_list_body', 'functions_list_type=' + fetch_functions_type);
}