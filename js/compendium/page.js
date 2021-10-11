/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_page_fetch_history       Fetches a compendium's page history.                                         */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Close the page history popin if it is open upon loading the page
popin_close('compendium_page_history');


/**
 * Fetches a compendium's page history.
 *
 * @param   {int}   page_id   The compendium page's id.
 *
 * @returns {void}
 */

function compendium_page_fetch_history( page_id )
{
  // Assemble the postdata
  postdata = 'compendium_page_id=' + fetch_sanitize(page_id);

  // Fetch the compendium page's history
  fetch_page('page_history', 'compendium_page_history_body', postdata);
}