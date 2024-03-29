/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_blogs_delete      Triggers the deletion of a devblog.                                                        */
/*  dev_blogs_restore     Triggers the restoration of a deleted devblog.                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Triggers the deletion of a devblog.
 *
 * @param   {int}     blog_id         The id of the devblog.
 * @param   {string}  message         The confirmation message which will be displayed.
 * @param   {bool}    [hard_delete]   Trigger a hard deletion instead of a soft deletion.
 *
 * @returns {void}
*/

function dev_blogs_delete(  blog_id             ,
                            message             ,
                            hard_delete = null  )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Prepare the postdata
    postdata = (hard_delete) ? 'hard_delete=1' : 'soft_delete=1';

    // Remove the unnecessary icons
    toggle_element_oneway('devblog_delete_icon', 0);
    if(hard_delete)
    {
      toggle_element_oneway('devblog_edit_icon', 0);
      toggle_element_oneway('devblog_restore_icon', 0);
    }

    // Submit the deletion request
    fetch_page('blog?id=' + blog_id, 'devblog_body', postdata);
  }
}




/**
 * Triggers the restoration of a deleted devblog.
 *
 * @param   {int}     blog_id The id of the devblog.
 * @param   {string}  message The confirmation message which will be displayed.
 *
 * @returns {void}
 */

function dev_blogs_restore( blog_id ,
                            message )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Prepare the postdata
    postdata = 'restore=1';

    // Remove the unnecessary icons
    toggle_element_oneway('devblog_delete_icon', 0);
    toggle_element_oneway('devblog_restore_icon', 0);

    // Submit the deletion request
    fetch_page('blog?id=' + blog_id, 'devblog_body', postdata);
  }
}