/**
 * Displays the selected CSS snippets
 *
 * @returns {void}
 */

function dev_snippet_selector()
{
  // Fetch the requested snippet
  fetch_snippet = document.getElementById('select_css_snippet').value;

  // Update the page
  fetch_page('snippets', 'dev_snippets_body', 'snippet=' + fetch_snippet);
}
