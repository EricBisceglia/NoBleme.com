/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_page_history_fetch         Fetches a compendium's page history.                                       */
/*  compendium_page_history_edit_form     Opens a form for editing an entry in a compendium page's history.          */
/*  compendium_page_history_edit          Submits the modification of an entry in a compendium page's history.       */
/*  compendium_page_history_delete        Triggers the deletion of an entry in a compendium page's history.          */
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

function compendium_page_history_fetch( page_id )
{
  // Assemble the postdata
  postdata = 'compendium_page_id=' + fetch_sanitize(page_id);

  // Fetch the compendium page's history
  fetch_page('page_history', 'compendium_page_history_body', postdata);
}




/**
 * Opens a form for editing an entry in a compendium page's history.
 *
 * @param   {int}   history_id    The compendium page's history entry id.
 *
 * @return  {void}
 */

function compendium_page_history_edit_form( history_id )
{
  // Assemble the postdata
  postdata = 'compendium_history_id=' + fetch_sanitize(history_id);

  // Fetch the compendium page's history
  fetch_page('page_history_edit', 'compendium_page_history_body', postdata);
}




/**
 * Submits the modification of an entry in a compendium page's history.
 *
 * @param   {int}   page_id     The compendium page's id.
 * @param   {int}   history_id  The compendium page's history entry id.
 *
 * @returns {void}
 */

function compendium_page_history_edit(  page_id     ,
                                        history_id  )
{
  // Assemble the postdata
  postdata =  'compendium_page_id='                       + fetch_sanitize(page_id);
  postdata += '&compendium_page_history_edit='            + fetch_sanitize(history_id);
  postdata += '&compendium_page_history_edit_summary_en=' + fetch_sanitize_id('compendium_history_edit_summary_en');
  postdata += '&compendium_page_history_edit_summary_fr=' + fetch_sanitize_id('compendium_history_edit_summary_fr');
  postdata += '&compendium_page_history_edit_major='      + document.getElementById('compendium_history_edit_major').checked;

  // Fetch the compendium page's history
  fetch_page('page_history', 'compendium_page_history_body', postdata);
}




/**
 * Triggers the deletion of an entry in a compendium page's history.
 *
 * @param   {int}     page_id     The compendium page's id.
 * @param   {int}     history_id  The compendium page's history entry id.
 * @param   {string}  message     The confirmation message that is shown before triggering the deletion.
 *
 * @returns {void}
 */

function compendium_page_history_delete(  page_id     ,
                                          history_id  ,
                                          message     )
{
  // Make sure the user knows what they're doing
  if(confirm(message))
  {
    // Assemble the postdata
    postdata  = 'compendium_page_id='               + fetch_sanitize(page_id);
    postdata += '&compendium_page_history_delete='  + fetch_sanitize(history_id);

    // Fetch the compendium page's history
    fetch_page('page_history', 'compendium_page_history_body', postdata);
  }
}