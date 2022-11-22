/*********************************************************************************************************************/
/*                                                                                                                   */
/*  css_add             Adds a CSS class to an element                                                               */
/*  css_remove          Removes a CSS class from an element.                                                         */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Adds a CSS class to an element.
 *
 * @param   {string}        element_id  The element's id.
 * @param   {string|array}  class_name  The CSS class to add to the element, can be an array of classes.
 *
 * @returns {void}
 */

function css_add( element_id  ,
                  class_name  )
{
  // If the provided class is singular, add it to the element
  if(!Array.isArray(class_name))
    document.getElementById(element_id)?.classList.add(class_name);

  // Otherwise add each class in the array to the element
  else
    class_name.forEach(class_add => document.getElementById(element_id)?.classList.add(class_add));
}




/**
 * Removes a CSS class from an element.
 *
 * @param   {string}        element_id  The element's id.
 * @param   {string|array}  class_name  The CSS class to remove from the element, can be an array of classes.
 *
 * @returns {void}
 */

 function css_remove( element_id  ,
                      class_name  )
{
  // If the provided class is singular, remove it from the element
  if(!Array.isArray(class_name))
    document.getElementById(element_id)?.classList.remove(class_name);

  // Otherwise remove each class in the array from the element
  else
    class_name.forEach(class_add => document.getElementById(element_id)?.classList.remove(class_add));
}
