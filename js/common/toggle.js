/*********************************************************************************************************************/
/*                                                                                                                   */
/*  toggle_element            Toggles the visibility state of an element.                                            */
/*  toggle_class              Toggles the visibility state of all elements of a specific class.                      */
/*  toggle_checkbox           Toggles the checked status of a checkbox.                                              */
/*  toggle_element_oneway     Sets the visibility state of an element.                                               */
/*  toggle_class_oneway       Sets the visibility state of all elements of a specific class.                         */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Toggles the visibility state of an element.
 *
 * @param   {string}  element_id      The element whose visibility will be toggled.
 * @param   {string}  [element_type]  The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_element(  element_id              ,
                          element_type  = 'block' )
{
  // Fetch the selected element
  var selected_element = document.getElementById(element_id);

  // Check the current visibility state of the element
  var element_visibility = selected_element.currentStyle ? selected_element.currentStyle.display : getComputedStyle(selected_element,null).display;

  // Toggle it to the opposite visibility state
  if(element_visibility == 'none')
    selected_element.style.display = element_type;
  else
    selected_element.style.display = 'none';
}




/**
 * Toggles the visibility state of all elements of a specific class.
 *
 * @param   {string}  element_class   The class whose visibility will be toggled.
 * @param   {string}  [element_type]  The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_class(  element_class           ,
                        element_type  = 'block' )
{
  // Fetch all elements with the selected class
  var selected_class = document.getElementsByClassName(element_class);

  // Check the current visibility state of the first element of the class
  var first_element     = selected_class[0];
  var class_visibility  = first_element.currentStyle ? first_element.currentStyle.display : getComputedStyle(first_element,null).display;

  // Define the new visibility state to apply to the class
  var new_visibility_state = class_visibility == 'none' ? element_type : 'none';

  // Apply the changed visibility state to all elements of the class
  for(var i = 0; i < selected_class.length; i++)
    selected_class[i].style.display = new_visibility_state;
}




/**
 * Toggles the checked status of a checkbox.
 *
 * @param   {string}  checkbox_id   The checkbox whose visibility will be toggled.
 *
 * @returns {void}
 */

function toggle_checkbox( checkbox_id )
{
  // Swap the checked status
  document.getElementById(checkbox_id).click();
}




/**
 * Sets the visibility state of an element.
 *
 * @param   {string}  element_id            The element whose visibility will be toggled.
 * @param   {int}     will_be_made_visible  Whether the element will be hidden (0) or made visible (1).
 * @param   {string}  [element_type]        The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_element_oneway( element_id                      ,
                                will_be_made_visible            ,
                                element_type          = 'block' )
{
  // Hide the requested element
  if(!will_be_made_visible)
    document.getElementById(element_id).style.display = 'none';

  // Make the requested element visible
  else
    document.getElementById(element_id).style.display = element_type;
}




/**
 * Sets the visibility state of all elements of a specific class.
 *
 * @param   {string}  element_class         The class whose visibility will be toggled.
 * @param   {int}     will_be_made_visible  Whether the element will be hidden (0) or made visible (1).
 * @param   {string}  [element_type]        The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_class_oneway( element_class                   ,
                              will_be_made_visible            ,
                              element_type          = 'block' )
{
  // Fetch all elements with the selected class
  var selected_class = document.getElementsByClassName(element_class);

  // Define the visibility state to apply
  var visibility_state = (!will_be_made_visible) ? 'none' : element_type;

  // Apply the changed visibility state to all elements of the class
  for(var i = 0; i < selected_class.length; i++)
    selected_class[i].style.display = visibility_state;
}