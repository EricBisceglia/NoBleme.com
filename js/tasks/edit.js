/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tasks_categories_popin          Shows a popin containing the editable task category list.                        */
/*  tasks_categories_add            Submits the creation of a new task category.                                     */
/*  tasks_categories_edit_form      Displays a form allowing the modification an existing task category.             */
/*  tasks_categories_edit           Submits the modification af an existing task category.                           */
/*  tasks_categories_delete         Submits the deletion of an existing task category.                               */
/*  tasks_categories_reload         Reloads the task category selector.                                              */
/*                                                                                                                   */
/*  tasks_milestones_reload        Reloads the task milestone selector.                                              */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Close the categories and milestones popins if they are open upon loading the page
popin_close('task_categories_popin');
popin_close('task_milestones_popin');


/**
 * Shows a popin containing the editable task category list.
 *
 * @returns {void}
 */

function tasks_categories_popin()
{
  // Open the popin
  location.hash = "#task_categories_popin";

  // Fetch the edit form
  fetch_page('categories', 'task_categories_popin_body', '');
}




/**
 * Submits the creation of a new task category.
 *
 * @returns {void}
 */

function tasks_categories_add()
{
  // Assemble the postdata
  postdata =  'task_category_name_en='  + fetch_sanitize_id('tasks_categories_add_english');
  postdata += '&task_category_name_fr=' + fetch_sanitize_id('tasks_categories_add_french');
  postdata += '&task_category_create=1';

  // Update the edit form
  fetch_page('categories', 'task_categories_popin_body', postdata);
}




/**
 * Displays a form allowing the modification an existing task category.
 *
 * @param   {int}   category_id   The id of the task category.
 *
 * @returns {void}
 */

function tasks_categories_edit_form( category_id )
{
  // Toggle the edit form
  toggle_element('tasks_categories_edit_form_' + category_id, 'table-row');
}




/**
 * Submits the modification af an existing task category.
 *
 * @param   {int}   category_id   The id of the task category.
 *
 * @returns {void}
*/

function tasks_categories_edit( category_id )
{
  // Assemble the postdata
  postdata =  'task_category_edit_name_en='   + fetch_sanitize_id('tasks_categories_edit_english_' + category_id);
  postdata += '&task_category_edit_name_fr='  + fetch_sanitize_id('tasks_categories_edit_french_' + category_id);
  postdata += '&task_category_edit='          + fetch_sanitize(category_id);

  // Submit the modifications
  fetch_page('categories', 'task_categories_popin_body', postdata);
}




/**
 * Submits the deletion of an existing task category.
 *
 * @param   {int}     category_id   The id of the task category
 * @param   {string}  message       The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function tasks_categories_delete(  category_id ,
                                        message     )
{
  // Make sure the user knows what they're doing and submit the deletion
  if(confirm(message))
    fetch_page('categories', 'task_categories_popin_body', 'task_category_delete=' + category_id);
}




/**
 * Reloads the task category selector.
 *
 * @returns {void}
 */

function tasks_categories_reload()
{
  // Reload the selector
  fetch_page('add', 'task_categories_selector', 'reload_categories=1');
}




/**
 * Reloads the task milestone selector.
 *
 * @returns {void}
 */

function tasks_milestones_reload()
{
  // Reload the selector
  fetch_page('add', 'task_milestones_selector', 'reload_milestones=1');
}