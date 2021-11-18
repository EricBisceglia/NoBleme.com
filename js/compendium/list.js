/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_page_list_search     Performs a search through the compendium page list.                              */
/*  compendium_admin_list_search    Performs a search through the compendium admin page list.                        */
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