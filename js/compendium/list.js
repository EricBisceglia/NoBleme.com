/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_page_list_search         Performs a search through the compendium page list.                          */
/*  compendium_admin_list_search        Performs a search through the compendium admin page list.                    */
/*  compendium_image_list_search        Performs a search through the compendium image list.                         */
/*  compendium_missing_list_search      Performs a search through the compendium missing pages list.                 */
/*                                                                                                                   */
/*  compendium_image_list_clipboard     Copies an image to the clipoard, ready for use in the compendium.            */
/*  compendium_image_list_preview       Fetches the preview of a compendium image.                                   */
/*  compendium_image_list_upload        Fills out the image upload form when an image is submitted.                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Performs a search through the compendium page list.
 *
 * @param   {string}  [sort_data]   Change the order in which the data will be sorted.
 *
 * @returns {void}
*/

function compendium_page_list_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('compendium_pages_search_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'compendium_pages_search_order='  + fetch_sanitize_id('compendium_pages_search_order');
  postdata += '&compendium_search_title='       + fetch_sanitize_id('compendium_search_title');
  postdata += '&compendium_search_type='        + fetch_sanitize_id('compendium_search_type');
  postdata += '&compendium_search_era='         + fetch_sanitize_id('compendium_search_era');
  postdata += '&compendium_search_appeared='    + fetch_sanitize_id('compendium_search_appeared');
  postdata += '&compendium_search_peak='        + fetch_sanitize_id('compendium_search_peak');
  postdata += '&compendium_search_created='     + fetch_sanitize_id('compendium_search_created');

  // Submit the search
  fetch_page('page_list', 'compendium_pages_tbody', postdata);
}




/**
 * Performs a search through the compendium admin page list.
 *
 * @param   {string}  [sort_data]   Change the order in which the data will be sorted.
 *
 * @returns {void}
*/

function compendium_admin_list_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('compendium_pages_search_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'compendium_pages_search_order='  + fetch_sanitize_id('compendium_pages_search_order');
  postdata += '&compendium_search_url='         + fetch_sanitize_id('compendium_search_url');
  postdata += '&compendium_search_translation=' + fetch_sanitize_id('compendium_search_translation');
  postdata += '&compendium_search_title='       + fetch_sanitize_id('compendium_search_title');
  postdata += '&compendium_search_redirect='    + fetch_sanitize_id('compendium_search_redirect');
  postdata += '&compendium_search_redirname='   + fetch_sanitize_id('compendium_search_redirname');
  postdata += '&compendium_search_type='        + fetch_sanitize_id('compendium_search_type');
  postdata += '&compendium_search_category='    + fetch_sanitize_id('compendium_search_category');
  postdata += '&compendium_search_era='         + fetch_sanitize_id('compendium_search_era');
  postdata += '&compendium_search_appeared='    + fetch_sanitize_id('compendium_search_appeared');
  postdata += '&compendium_search_peak='        + fetch_sanitize_id('compendium_search_peak');
  postdata += '&compendium_search_created='     + fetch_sanitize_id('compendium_search_created');
  postdata += '&compendium_search_language='    + fetch_sanitize_id('compendium_search_language');
  postdata += '&compendium_search_nsfw='        + fetch_sanitize_id('compendium_search_nsfw');
  postdata += '&compendium_search_wip='         + fetch_sanitize_id('compendium_search_wip');

  // Submit the search
  fetch_page('page_list_admin', 'compendium_pages_tbody', postdata);
}




/**
 * Performs a search through the compendium image list.
 *
 * @param   {string}  [sort_data]       Change the order in which the data will be sorted.
 * @param   {string}  [deletion_type]   Delete or restore an image from the table.
 * @param   {string}  [delete_id]       The id of the image to delete or restore.
 * @param   {string}  [message]         Message to show before a deletion is performed.
 *
 * @returns {void}
*/

function compendium_image_list_search(  sort_data     = null  ,
                                        deletion_type = null  ,
                                        delete_id     = null  ,
                                        message       = null  )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('compendium_images_search_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'compendium_images_search_order='     + fetch_sanitize_id('compendium_images_search_order');
  postdata += '&compendium_images_search_name='     + fetch_sanitize_id('compendium_images_search_name');
  postdata += '&compendium_images_search_tags='     + fetch_sanitize_id('compendium_images_search_tags');
  postdata += '&compendium_images_search_used_en='  + fetch_sanitize_id('compendium_images_search_used_en');
  postdata += '&compendium_images_search_used_fr='  + fetch_sanitize_id('compendium_images_search_used_fr');
  postdata += '&compendium_images_search_date='     + fetch_sanitize_id('compendium_images_search_date');
  postdata += '&compendium_images_search_caption='  + fetch_sanitize_id('compendium_images_search_caption');
  postdata += '&compendium_images_search_nsfw='     + fetch_sanitize_id('compendium_images_search_nsfw');
  postdata += '&compendium_images_search_deleted='  + fetch_sanitize_id('compendium_images_search_deleted');

  // In case of deletion, make sure the user knows what they're doing
  if(message && !confirm(message))
    return;

  // Assemble the deletion postdata
  if(deletion_type)
  {
    postdata += '&compendium_images_search_action='     + fetch_sanitize(deletion_type);
    postdata += '&compendium_images_search_action_id='  + fetch_sanitize(delete_id);
  }

  // Submit the search
  fetch_page('image_admin', 'compendium_image_list_tbody', postdata);
}




/**
 * Performs a search through the compendium missing pages list.
 *
 * @param   {string}  [sort_data]   Change the order in which the data will be sorted.
 *
 * @returns {void}
*/

function compendium_missing_list_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('compendium_missing_sort_order').value = sort_data;

  // Assemble the postdata
  postdata  = 'compendium_missing_sort_order='  + fetch_sanitize_id('compendium_missing_sort_order');
  postdata += '&compendium_missing_url='        + fetch_sanitize_id('compendium_missing_url');
  postdata += '&compendium_missing_title='      + fetch_sanitize_id('compendium_missing_title');
  postdata += '&compendium_missing_type='       + fetch_sanitize_id('compendium_missing_type');
  postdata += '&compendium_missing_priority='   + fetch_sanitize_id('compendium_missing_priority');
  postdata += '&compendium_missing_notes='      + fetch_sanitize_id('compendium_missing_notes');
  postdata += '&compendium_missing_status='     + fetch_sanitize_id('compendium_missing_status');

  // Submit the search
  fetch_page('page_missing_list', 'compendium_missing_list_tbody', postdata);
}




/**
 * Copies an image to the clipoard, ready for use in the compendium.
 *
 * @param   {string}  image_name  The image's name.
 * @param   {boolean} [nsfw]      If set, will add a nsfw tag to the image.
 * @param   {boolean} [gallery]   If set, will format the image for use in a gallery.
 *
 * @returns {void}
*/

function compendium_image_list_clipboard( image_name          ,
                                          nsfw        = null  ,
                                          gallery     = null  )
{
  // Prepare the correct tag
  image_tag = (gallery) ? 'gallery' : 'image';
  image_tag = (nsfw) ? image_tag + '-nsfw' : image_tag;

  // Copy the image to the clipboard
  to_clipboard('[' + image_tag + ':' + image_name + ']');
}




/**
 * Fetches the preview of a compendium image.
 *
 * @param   {int}   image_id    The compendium image's id.
 * @param   {int}   image_name  The compendium image's name.
 * @param   {int}   root_path   The path to the root of the website.
 *
 * @returns {void}
 */

function compendium_image_list_preview( image_id        ,
                                        image_name      ,
                                        root_path       )
{
  // Prepare the image
  image = document.createElement("img");
  image.setAttribute("src", root_path + "img/compendium/" + image_name);

  // Add the image in the element
  document.getElementById('compendium_image_list_container_' + image_id).appendChild(image);

  // Prevent the fetch from happening more than once
  document.getElementById('compendium_image_list_preview_cell_' + image_id).onmouseover = null;
}




/**
 * Fills out the image upload form when an image is submitted.
 *
 * @returns {void}
 */

function compendium_image_list_upload()
{
  // Reveal the hidden image upload form
  toggle_element_oneway('compendium_image_upload_form', true);

  // Hide the error or upload success message in case it was previously displayed
  if(document.getElementById('compendium_image_upload_error'))
    toggle_element_oneway('compendium_image_upload_error', false);

  // Move the image upload button to the left
  document.getElementById('compendium_image_upload_file').style.textAlign = "left";

  // Fetch the submitted image's name
  image = document.getElementById('compendium_image_upload_file').value;

  // Get rid of the path in the image's name
  position = image.lastIndexOf('\\');
  if(position >= 0)
    image = image.substring(position + 1);

  // Clean up the image's name by removing spaces and caps
  image = image.replace(" ", "_").toLowerCase();

  // Display the suggested file name
  document.getElementById('compendium_image_upload_name').value = image;
}