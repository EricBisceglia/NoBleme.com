/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_snippet_selector            Displays the selected code snippets                                              */
/*  dev_palette_selector            Displays the selected CSS palette.                                               */
/*  dev_js_toolbox_selector         Displays the selected JS toolbox.                                                */
/*  dev_functions_type_selector     Displays functions of the selected type.                                         */
/*  dev_workflow_selector           Displays the selected workflow reminders.                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Displays the selected code snippets
 *
 * @returns {void}
 */

function dev_snippet_selector()
{
  // Fetch the value of the snippet selector
  page_name = document.getElementById('dev_snippet_selector').value;

  // Hide all snippets
  toggle_class_oneway('dev_snippets_section', 0);

  // Display the requested snippet
  toggle_element_oneway('dev_snippets_' + page_name, 1);

  // If the main snippet is being selected, remove all URL parameters
  if(page_name == 'full')
    history.pushState({}, null, 'doc_snippets');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'doc_snippets?' + page_name);
}




/**
 * Displays the selected CSS palette.
 *
 * @returns {void}
 */

function dev_palette_selector()
{
  // Fetch the value of the css palette selector
  page_name = document.getElementById('dev_palette_selector').value;

  // Hide all css palette elements
  toggle_class_oneway('dev_palette_section', 0);

  // Display the requested css palette element
  toggle_element_oneway('dev_palette_' + page_name, 1);

  // If the main css palette element is being selected, remove all URL parameters
  if(page_name == 'default')
    history.pushState({}, null, 'doc_css_palette');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'doc_css_palette?' + page_name);
}




/**
 * Displays the selected JS toolbox.
 *
 * @returns {void}
 */

function dev_js_toolbox_selector()
{
  // Fetch the value of the js toolbox selector
  page_name = document.getElementById('dev_jstools_selector').value;

  // Hide all js toolbox entries
  toggle_class_oneway('dev_jstools_section', 0);

  // Display the requested js toolbox entry
  toggle_element_oneway('dev_jstools_' + page_name, 1);

  // If the main js toolbox entry is being selected, remove all URL parameters
  if(page_name == 'fetch')
    history.pushState({}, null, 'doc_js_toolbox');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'doc_js_toolbox?' + page_name);
}




/**
 * Displays functions of the selected type.
 *
 * @returns {void}
 */

function dev_functions_type_selector()
{
  // Fetch the value of the function list selector
  page_name = document.getElementById('dev_functions_type_selector').value;

  // Hide all function list entries
  toggle_class_oneway('dev_functions_section', 0);

  // Display the requested function list entry
  toggle_element_oneway('dev_functions_' + page_name, 1);

  // If the main function list entry is being selected, remove all URL parameters
  if(page_name == 'fetch')
    history.pushState({}, null, 'doc_functions');

  // Otherwise, set the currently selected section as an URL parameter
  else
    history.pushState({}, null, 'doc_functions?' + page_name);
}




/**
 * Displays the selected workflow reminders.
 *
 * @returns {void}
 */

function dev_workflow_selector()
{
  // Fetch the value of the workflow reminders selector
  page_name = document.getElementById('dev_workflow_selector').value;

  // Hide all workflow reminders entries
  toggle_class_oneway('dev_workflow_section', 0);

  // Display the requested workflow reminder
  toggle_element_oneway('dev_workflow_' + page_name, 1);

  // If the main workflow reminder is being selected, remove all URL parameters
  if(page_name == 'fetch')
    history.pushState({}, null, 'doc_workflow');

  // Otherwise, set the currently selected reminder as an URL parameter
  else
    history.pushState({}, null, 'doc_workflow?' + page_name);
}