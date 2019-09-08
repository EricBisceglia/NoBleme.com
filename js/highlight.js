/**
 * Selects the contents of an element.
 *
 * This won't work in older browsers (IE8- etc.). I used to support them, but what's the point nowadays.
 *
 * @param   {string}  element_id  The element to select.
 *
 * @returns {void}
 */

function select_element(element_id)
{
  // Fetch the requested element
  var selected_element = document.getElementById(element_id);

  // Wrap the browser's selection range around it
  var selection = document.createRange();
  selection.setStartBefore(selected_element);
  selection.setEndAfter(selected_element);
  window.getSelection().addRange(selection);
}