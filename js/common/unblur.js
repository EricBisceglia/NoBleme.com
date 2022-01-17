/**
 * Removes the blur filter from an element.
 *
 * @returns {void}
 */

function unblur()
{
  // Remove the blur filter
  event.target.classList.remove('blur');
  event.target.classList.remove('nbcode_blur');
  event.target.classList.remove('nbcode_blur_2');
  event.target.classList.remove('nbcode_blur_3');
  event.target.classList.remove('compendium_image_blur');
}




/**
 * Removes the blur filter from a targetted element.
 *
 * @param   {string}  [element_id]  Unblur the targetted element.
 *
 * @returns {void}
 */

 function unblur_element( element_id )
 {
  // Remove the blur filter
  document.getElementById(element_id).classList.remove('blur');
  document.getElementById(element_id).classList.remove('nbcode_blur');
  document.getElementById(element_id).classList.remove('nbcode_blur_2');
  document.getElementById(element_id).classList.remove('nbcode_blur_3');
  document.getElementById(element_id).classList.remove('compendium_image_blur');
 }