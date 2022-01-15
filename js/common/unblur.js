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