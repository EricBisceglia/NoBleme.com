/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_admin_menu                 Navigates between compendium administration pages.                         */
/*                                                                                                                   */
/*  compendium_autocomplete_url           Updates the datalist used to autocomplete compendium page urls.            */
/*                                                                                                                   */
/*  compendium_recalculate_image_links    Triggers the recalculation of all compendium image links.                  */
/*                                                                                                                   */
/*  compendium_type_delete                Triggers the deletion of a compendium page type.                           */
/*                                                                                                                   */
/*  compendium_category_delete            Triggers the deletion of a compendium category.                            */
/*                                                                                                                   */
/*  compendium_era_delete                 Triggers the deletion of a compendium era.                                 */
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
 *
 * @returns {void}
 */

function compendium_autocomplete_url( url_input_id            ,
                                      target_element          ,
                                      list_id                 ,
                                      no_redirects    = null  )
{
  // Assemble the postdata
  postdata  = 'compendium_autocomplete_url='  + fetch_sanitize_id(url_input_id);
  postdata += '&compendium_autocomplete_id='  + fetch_sanitize(list_id);
  if(no_redirects)
    postdata += '&compendium_autocomplete_no_redirects=true';

  // Submit the fetch request
  fetch_page('page_autocomplete_url', target_element, postdata);
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
