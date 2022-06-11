/**
 * Displays the selected page section.
 *
 * @param   {string}  page_section_prefix   Beginning of the ID of the dropdown selector and every page section.
 * @param   {string}  [default_selection]   URL of the default selection, for which no URL parameter will be shown.
 *
 * @returns {void}
 */

 function page_section_selector(  page_section_prefix         ,
                                  default_selection   = null  )
 {
   // Fetch the value of the page selection dropdown menu
   page_name = document.getElementById(page_section_prefix + '_selector').value;

   // Hide all page sections
   toggle_class_oneway(page_section_prefix + '_section', 0);

   // Display the requested page section
   toggle_element_oneway(page_section_prefix + '_' + page_name, 1);

   // Assemble the current page's url
   page_url = window.location.href.split('?')[0].split("/").pop();

   // If the default selection is being selected, remove all URL parameters
   if(default_selection && page_name == default_selection)
     history.pushState({}, null, page_url);

   // Otherwise, set the currently selected entry as an URL parameter
   else
     history.pushState({}, null, page_url + '?' + page_name);
 }