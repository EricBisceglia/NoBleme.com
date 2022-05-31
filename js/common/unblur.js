/**
 * Removes the blur filter from an element being triggered by an action.
 *
 * @param   {string}  [target_id]   The action's target.
 *
 * @returns {void}
 */

function unblur(target_id)
{
  // Remove the blur filter
  target_id.classList.remove('blur');
  target_id.classList.remove('nbcode_blur');
  target_id.classList.remove('nbcode_blur_2');
  target_id.classList.remove('nbcode_blur_3');
  target_id.classList.remove('compendium_image_blur');
}




/**
 * Removes the blur filter from a specific element.
 *
 * @param   {string}  [element_id]  Unblur the specific element.
 *
 * @returns {void}
 */

function unblur_element(element_id)
{
  // Remove the blur filter
  document.getElementById(element_id).classList.remove('blur');
  document.getElementById(element_id).classList.remove('nbcode_blur');
  document.getElementById(element_id).classList.remove('nbcode_blur_2');
  document.getElementById(element_id).classList.remove('nbcode_blur_3');
  document.getElementById(element_id).classList.remove('compendium_image_blur');
}