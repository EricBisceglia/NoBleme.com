/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tasks_categories_popin          Shows a popin containing the editable task milestone list.                       */
/*  tasks_categories_add            Submits the creation of a new task category.                                     */
/*  tasks_categories_edit_form      Displays a form allowing the modification an existing task category.             */
/*  tasks_categories_edit           Submits the modification af an existing task category.                           */
/*  tasks_categories_delete         Submits the deletion of an existing task category.                               */
/*  tasks_categories_reload         Reloads the task category selector.                                              */
/*                                                                                                                   */
/*  tasks_milestones_popin          Shows a popin containing the editable task milestone list.                       */
/*  tasks_milestones_add            Submits the creation of a new task milestone.                                    */
/*  tasks_milestones_edit_form      Displays a form allowing the modification an existing task milestone.            */
/*  tasks_milestones_edit           Submits the modification af an existing task milestone.                          */
/*  tasks_milestones_delete         Submits the deletion of an existing task milestone.                              */
/*  tasks_milestones_reload         Reloads the task milestone selector.                                             */
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

function tasks_categories_delete( category_id ,
                                  message     )
{
  // Make sure the user knows what they're doing and submit the deletion
  if(confirm(message))
    fetch_page('categories', 'task_categories_popin_body', 'task_category_delete=' + category_id);
}




/**
 * Reloads the task category selector.
 *
 * @param   {string}  page  The page on which the reloading is happening.
 *
 * @returns {void}
 */

function tasks_categories_reload( page )
{
  // Reload the selector
  fetch_page(page, 'task_categories_selector', 'reload_categories=1');
}




/**
 * Shows a popin containing the editable task milestone list.
 *
 * @returns {void}
 */

function tasks_milestones_popin()
{
  // Open the popin
  location.hash = "#task_milestones_popin";

  // Fetch the edit form
  fetch_page('milestones', 'task_milestones_popin_body', '');
}




/**
 * Submits the creation of a new task milestone.
 *
 * @returns {void}
 */

function tasks_milestones_add()
{
  // Assemble the postdata
  postdata  = 'task_milestone_order='     + fetch_sanitize_id('tasks_milestones_add_order');
  postdata += '&task_milestone_name_en='  + fetch_sanitize_id('tasks_milestones_add_english');
  postdata += '&task_milestone_name_fr='  + fetch_sanitize_id('tasks_milestones_add_french');
  postdata += '&task_milestone_create=1';

  // Update the edit form
  fetch_page('milestones', 'task_milestones_popin_body', postdata);
}




/**
 * Displays a form allowing the modification an existing task milestone.
 *
 * @param   {int}   milestone_id   The id of the task milestone.
 *
 * @returns {void}
 */

function tasks_milestones_edit_form( milestone_id )
{
  // Toggle the edit form
  toggle_element('tasks_milestones_edit_form_' + milestone_id, 'table-row');
}




/**
 * Submits the modification af an existing task milestone.
 *
 * @param   {int}   milestone_id   The id of the task milestone.
 *
 * @returns {void}
 */

function tasks_milestones_edit( milestone_id )
{
  // Assemble the postdata
  postdata  = 'task_milestone_edit_order='    + fetch_sanitize_id('tasks_milestones_edit_order_' + milestone_id);
  postdata += '&task_milestone_edit_name_en=' + fetch_sanitize_id('tasks_milestones_edit_english_' + milestone_id);
  postdata += '&task_milestone_edit_name_fr=' + fetch_sanitize_id('tasks_milestones_edit_french_' + milestone_id);
  postdata += '&task_milestone_edit_body_en=' + fetch_sanitize_id('tasks_milestones_edit_body_en_' + milestone_id);
  postdata += '&task_milestone_edit_body_fr=' + fetch_sanitize_id('tasks_milestones_edit_body_fr_' + milestone_id);
  postdata += '&task_milestone_edit='         + fetch_sanitize(milestone_id);

  // Submit the modifications
  fetch_page('milestones', 'task_milestones_popin_body', postdata);
}




/**
 * Submits the deletion of an existing task milestone.
 *
 * @param   {int}     milestone_id  The id of the task milestone
 * @param   {string}  message       The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function tasks_milestones_delete( milestone_id  ,
                                  message       )
{
  // Make sure the user knows what they're doing and submit the deletion
  if(confirm(message))
    fetch_page('milestones', 'task_milestones_popin_body', 'task_milestone_delete=' + milestone_id);
}




/**
 * Reloads the task milestone selector.
 *
 * @param   {string}  page  The page on which the reloading is happening.
 *
 * @returns {void}
 */

function tasks_milestones_reload( page )
{
  // Reload the selector
  fetch_page(page, 'task_milestones_selector', 'reload_milestones=1');
}