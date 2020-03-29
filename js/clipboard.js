/**
 * Places some data in the user's clipboard.
 *
 * @param   {string}  contents            The contents that should be placed in the user's clipboard.
 * @param   {string}  [element_id]        If set, fetches the element's contents instead of the first argument.
 * @param   {bool}    [highlight_element] If set, highlights the element's contents after copying it to clipboard.
 *
 * @returns {void}
 */

function to_clipboard(contents, element_id, highlight_element)
{
  // If needed, fetch the element's contents
  if(typeof(element_id) !== 'undefined')
    contents = document.getElementById(element_id).innerHTML;

  // Replace any &lt; or &gt; in the contents by < and >
  contents = contents.replace(/&lt;/gi, "<");
  contents = contents.replace(/&gt;/gi, ">");

  // Prepare a temporary textarea and place the contents in it
  var temparea    = document.createElement('textarea');
  temparea.value  = contents;

  // Place the textarea off screen and make it uneditable
  temparea.setAttribute('readonly', '');
  temparea.style = {position: 'absolute', left: '-9999px'};
  document.body.appendChild(temparea);

  // Move the textarea's contents into the clipboard (if the browser allows it…)
  temparea.select();
  document.execCommand('copy');

  // Delete the temporary textarea
  document.body.removeChild(temparea);

  // Highlight the element's contents if required
  if(typeof(highlight_element) !== 'undefined')
  {
    // Fetch the element
    contents = document.getElementById(element_id)

    // Wrap the browser's selection range around it
    var selection = document.createRange();
    selection.setStartBefore(contents);
    selection.setEndAfter(contents);
    window.getSelection().addRange(selection);
  }
}