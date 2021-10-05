/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_page_list_search     Performs a search through the compendium page list.                              */
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