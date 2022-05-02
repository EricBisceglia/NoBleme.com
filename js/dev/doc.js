/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_snippet_selector            Displays the selected code snippets                                              */
/*  dev_palette_selector            Displays the selected CSS palette.                                               */
/*  dev_js_toolbox_selector         Displays the selected JS toolbox.                                                */
/*  dev_functions_type_selector     Displays functions of the selected type.                                         */
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
  // Fetch the requested palette
  fetch_palette = document.getElementById('select_css_palette').value;

  // Update the page
  fetch_page('doc_css_palette', 'dev_palette_body', 'palette=' + fetch_palette);
}




/**
 * Displays the selected JS toolbox.
 *
 * @returns {void}
 */

function dev_js_toolbox_selector()
{
  // Fetch the requested toolbox
  fetch_toolbox = document.getElementById('select_js_toolbox').value;

  // Update the page
  fetch_page('doc_js_toolbox', 'dev_js_toolbox_body', 'js_toolbox=' + fetch_toolbox);
}




/**
 * Displays functions of the selected type.
 *
 * @returns {void}
 */

function dev_functions_type_selector()
{
  // Fetch the requested type
  fetch_functions_type = document.getElementById('select_functions_list_type').value;

  // Update the page
  fetch_page('doc_functions', 'dev_functions_list_body', 'functions_list_type=' + fetch_functions_type);
}