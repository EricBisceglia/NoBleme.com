/**
 * Displays the selected page section.
 *
 * @param   {string}  page_section_prefix     Beginning of the ID of the dropdown selector and every page section.
 * @param   {string}  [default_selection]     URL of the default selection, for which no URL parameter will be shown.
 * @param   {bool}    [update_header_title]   If set, update the title in the header upon making a selection.
 * @param   {bool}    [update_page_title]     If set, updates the page's title upon making a selection.
 *
 * @returns {void}
 */

 function page_section_selector(  page_section_prefix         ,
                                  default_selection   = null  ,
                                  update_header_title = false ,
                                  update_page_title   = false )
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

  // Update the title in the header if requested
  if(update_header_title)
  {
    // Fetch the new header title
    page_title = document.getElementById(page_section_prefix + '_name_' + page_name).value;

    // Update the title in the header
    document.getElementById(page_section_prefix + '_title').innerHTML = page_title;
  }

  // Update the page's title if requested
  if(update_page_title)
  {
    // Fetch the new page title
    page_title = document.getElementById(page_section_prefix + '_name_' + page_name).value;

    // Fetch the page name suffix
    page_suffix = document.getElementById(page_section_prefix + '_name_suffix').value;

    // Update the page's title
    document.title = page_title + page_suffix;
  }
 }