/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_admin_menu                 Navigates between compendium administration pages.                         */
/*                                                                                                                   */
/*  compendium_autocomplete_url           Updates the datalist used to autocomplete compendium page urls.            */
/*  compendium_autocomplete_image         Updates the datalist used to autocomplete image file names.                */
/*                                                                                                                   */
/*  compendium_page_links_open            Opens all links related to a compendium page.                              */
/*                                                                                                                   */
/*  compendium_recalculate_image_links    Triggers the recalculation of all compendium image links.                  */
/*                                                                                                                   */
/*  compendium_image_delete               Triggers the deletion or undeletion of a compendium image.                 */
/*                                                                                                                   */
/*  compendium_missing_delete             Triggers the deletion or undeletion of a missing compendium page.          */
/*                                                                                                                   */
/*  compendium_type_delete                Triggers the deletion of a compendium page type.                           */
/*                                                                                                                   */
/*  compendium_category_delete            Triggers the deletion of a compendium category.                            */
/*                                                                                                                   */
/*  compendium_era_delete                 Triggers the deletion of a compendium era.                                 */
/*                                                                                                                   */
/*  compendium_edit_toggle_history        Toggles the history options when editing a compendium page.                */
/*  compendium_edit_toggle_major          Toggles more history options when editing a compendium page.               */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Navigates between compendium administration pages.
 *
 * @returns {void}
 */

function compendium_admin_menu()
{
  // Fetch the requested page
  page = document.getElementById('compendium_admin_menu').value;

  // Go to the requested page
  window.location.href = page;
}




/**
 * Updates the datalist used to autocomplete compendium page urls.
 *
 * @param   {string}  url_input_id        ID of the input containing the page url.
 * @param   {string}  parent_element_id   ID of the element containing the datalist of the url being autocompleted.
 * @param   {string}  list_id             ID of the datalist used for autocompletion.
 * @param   {string}  [no_redirects]      Exclude redirections from the autocompletion proposals.
 * @param   {string}  [include_missing]   Include missing pages from the autocompletion proposals.
 *
 * @returns {void}
 */

 function compendium_autocomplete_url(  url_input_id            ,
                                        target_element          ,
                                        list_id                 ,
                                        no_redirects    = null  ,
                                        include_missing = null  )
{
  // Assemble the postdata
  postdata  = 'compendium_autocomplete_url='  + fetch_sanitize_id(url_input_id);
  postdata += '&compendium_autocomplete_id='  + fetch_sanitize(list_id);
  if(no_redirects)
    postdata += '&compendium_autocomplete_no_redirects=true';
  if(include_missing)
    postdata += '&compendium_autocomplete_include_missing=true';

  // Submit the fetch request
  fetch_page('page_autocomplete_url', target_element, postdata);
}




/**
 * Updates the datalist used to autocomplete compendium image file names.
 *
 * @param   {string}  image_input_id      ID of the input containing the image name.
 * @param   {string}  parent_element_id   ID of the element containing the datalist of the image being autocompleted.
 * @param   {string}  list_id             ID of the datalist used for autocompletion.
 *
 * @returns {void}
 */

function compendium_autocomplete_image( image_input_id  ,
                                        target_element  ,
                                        list_id         )
{
  // Assemble the postdata
  postdata  = 'compendium_autocomplete_image='  + fetch_sanitize_id(image_input_id);
  postdata += '&compendium_autocomplete_id='    + fetch_sanitize(list_id);

  // Submit the fetch request
  fetch_page('image_autocomplete', target_element, postdata);
}




/**
 * Opens all links related to a compendium page.
 *
 * @param   {array}   links   The list of links which should be opened.
 *
 * @returns {void}
 */

function compendium_page_links_open ( links )
{
  for(i = 0; i < links.length; i++)
    window.open(links[i]);
}




/**
 * Triggers the recalculation of all compendium image links.
 *
 * @param   {string}  message   The message which will be displayed.
 *
 * @returns {void}
*/

function compendium_recalculate_image_links( message )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Assemble the postdata
    postdata = 'compendium_images_recalculate_links=1';

    // Submit the recalculation
    fetch_page('image_admin', 'compendium_image_list_tbody', postdata);
  }
}




/**
 * Triggers the deletion or undeletion of a compendium image.
 *
 * @param   {string}  image_name  The image's name.
 * @param   {int}     image_id    The image's id.
 * @param   {string}  action      Whether to delete or restore the image.
 * @param   {string}  message     Message to show before an action is performed.
 *
 * @returns {void}
*/

function compendium_image_delete( image_name  ,
                                  image_id    ,
                                  action      ,
                                  message     )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Assemble the postdata
    postdata  = 'compendium_image_action='  + fetch_sanitize(action);
    postdata += '&compendium_image_id='     + fetch_sanitize(image_id);

    // Remove the deleted message if it exists
    if(document.getElementById('compendium_image_delete_message'))
      toggle_element_oneway('compendium_image_delete_message', false);

    // Submit the deletion
    fetch_page('image?name=' + image_name, 'compendium_image_delete_icon', postdata);
  }
}




/**
 * Triggers the deletion or undeletion of a missing compendium page.
 *
 * @param   {int}     missing_id  The missing page's id.
 * @param   {string}  message     Message to show before the deletion is performed.
 * @param   {string}  page        The page from which the deletion is being performed.
 *
 * @returns {void}
*/

function compendium_missing_delete( missing_id  ,
                                    message     ,
                                    page        )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Assemble the postdata
    postdata = 'compendium_missing_delete_id=' + fetch_sanitize(missing_id);

    // Submit the deletion
    if(page === 'list')
      fetch_page('page_missing_list', 'compendium_missing_list_tbody', postdata);
    else
    {
      toggle_element_oneway('compendium_missing_delete_icon', false);
      fetch_page('page_missing?id=' + missing_id, 'compendium_missing_delete_icon', postdata);
    }
  }
}




/**
 * Triggers the deletion of a compendium page type.
 *
 * @param   {int}     type_id   The compendium page type's id.
 * @param   {string}  message   The confirmation message that is shown before triggering the deletion.
 *
 * @returns {void}
 */

 function compendium_type_delete( type_id ,
                                  message )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Assemble the postdata
    postdata = 'compendium_type_delete=' + fetch_sanitize(type_id);

    // Trigger the deletion
    fetch_page('page_type_delete', 'compendium_admin_type_row_' + type_id, postdata);
  }
}




/**
 * Triggers the deletion of a compendium category.
 *
 * @param   {int}     category_id   The compendium category's id.
 * @param   {string}  message       The confirmation message that is shown before triggering the deletion.
 *
 * @returns {void}
 */

 function compendium_category_delete( category_id ,
                                      message     )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Assemble the postdata
    postdata = 'compendium_category_delete=' + fetch_sanitize(category_id);

    // Trigger the deletion
    fetch_page('category_delete', 'compendium_admin_category_row_' + category_id, postdata);
  }
}




/**
 * Triggers the deletion of a compendium era.
 *
 * @param   {int}     era_id    The compendium era's id.
 * @param   {string}  message   The confirmation message that is shown before triggering the deletion.
 *
 * @returns {void}
 */

 function compendium_era_delete(  era_id  ,
                                  message )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Assemble the postdata
    postdata = 'compendium_era_delete=' + fetch_sanitize(era_id);

    // Trigger the deletion
    fetch_page('cultural_era_delete', 'compendium_admin_era_row_' + era_id, postdata);
  }
}




/**
 * Toggles the history options when editing a compendium page.
 *
 * @returns {void}
 */

function compendium_edit_toggle_history()
{
  // Toggle the form elements
  toggle_element('compendium_edit_history_descriptions');
  toggle_element('compendium_edit_history_checkboxes');
}




/**
 * Toggles more history options when editing a compendium page.
 *
 * @returns {void}
 */

function compendium_edit_toggle_major()
{
  // Uncheck the checkboxes
  document.getElementById('compendium_edit_activity').checked = false;
  document.getElementById('compendium_edit_irc').checked      = false;
  document.getElementById('compendium_edit_discord').checked  = false;

  // Toggle the form elements
  toggle_element('compendium_edit_history_major');
}
