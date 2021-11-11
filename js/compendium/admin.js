/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_admin_menu             Navigates between compendium administration pages.                             */
/*                                                                                                                   */
/*  compendium_type_delete            Triggers the deletion of a compendium page type.                               */
/*                                                                                                                   */
/*  compendium_category_delete        Triggers the deletion of a compendium category.                                */
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