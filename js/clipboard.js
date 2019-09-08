/**
 * Places some data in the user's clipboard.
 *
 * @param   {string}  contents  The contents that should be placed in the user's clipboard.
 *
 * @returns {void}
 */

function to_clipboard(contents)
{
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
}