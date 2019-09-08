/*********************************************************************************************************************/
/*                                                                                                                   */
/*                            Functions related to controlling the visibility of elements                            */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Toggles the visibility state of an element.
 *
 * @param   {string}  element_id        The element whose visibility will be toggled.
 * @param   {int}     [is_a_table_row]  This parameter should be set when working on a <tr> instead of a block.
 *
 * @returns {void}
 */

function toggle_element(element_id, is_a_table_row)
{
  // Fetch the selected element
  var selected_element = document.getElementById(element_id);

  // Check the current visibility state of the line
  var element_visibility = selected_element.currentStyle ? selected_element.currentStyle.display : getComputedStyle(selected_element,null).display;

  // Toggle it to the opposite visibility state
  if(element_visibility == 'none')
    selected_element.style.display = (typeof is_a_table_row === 'undefined') ? 'block' : 'table-row';
  else
    selected_element.style.display = 'none';
}




/**
 * Toggles the visibility state of all elements of a specific class.
 *
 * @param   {string}  element_class The element whose visibility will be toggled.
 *
 * @returns {void}
 */

function toggle_class(element_class)
{
  // Fetch all elements with the selected class, it will place them in a table
  var selected_class = document.getElementsByClassName(element_class);

  // Check the current visibility state of the first element of the class
  var first_element     = selected_class[0];
  var class_visibility  = first_element.currentStyle ? first_element.currentStyle.display : getComputedStyle(first_element,null).display;

  // Define the new visibility state to apply to the class
  var new_visibility_state = class_visibility == 'none' ? 'block' : 'none';

  // Apply the changed visibility state to all elements of the class
  for(var i = 0; i < selected_class.length; i++)
    selected_class[i].style.display = new_visibility_state;
}



/**
 * Sets the visibility state of an element.
 *
 * @param   {string}  element_id            The element whose visibility will be toggled.
 * @param   {int}     will_be_made_visible  Whether the element will be hidden (0) or made visible (1).
 * @param   {int}     [is_a_table_row]      This parameter should be set when working on a <tr> instead of a block.
 *
 * @returns {void}
 */

function toggle_oneway(element_id, will_be_made_visible, is_a_table_row)
{
  // Hide the requested element
  if(!will_be_made_visible)
    document.getElementById(element_id).style.display = 'none';

  // Make the requested element visible
  else
    document.getElementById(element_id).style.display = (typeof is_a_table_row === 'undefined') ? 'block' : 'table-row';
}