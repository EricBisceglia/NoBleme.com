/**
 * Places some data in the user's clipboard.
 *
 * @param   {string}  contents            The contents that should be placed in the user's clipboard.
 * @param   {string}  [element_id]        If set, fetches the element's contents instead of the first argument.
 * @param   {bool}    [highlight_element] If set, highlights the element's contents after copying it to clipboard.
 *
 * @returns {void}
 */

function to_clipboard(  contents                  ,
                        element_id        = null  ,
                        highlight_element = null  )
{
  // If needed, fetch the element's contents
  if(element_id)
    contents = document.getElementById(element_id).innerHTML;

  // Replace any special characters with their real value
  contents = contents.replace(/&lt;/gi, "<");
  contents = contents.replace(/&gt;/gi, ">");
  contents = contents.replace(/&amp;/gi, "&");
  contents = contents.replace(/&times;/gi, "×");
  contents = contents.replace(/&nbsp;/gi, " ");
  contents = contents.replace(/<br>/gi, "");

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
  if(highlight_element)
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