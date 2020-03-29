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
  fetch_page('palette', 'dev_palette_body', 'palette=' + fetch_palette);
}
