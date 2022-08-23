/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_delete                 Triggers the deletion of a quote.                                                  */
/*  quotes_restore                Triggers the undeletion of a soft deleted quote.                                   */
/*                                                                                                                   */
/*  quotes_approve                Triggers the approval of a quote awaiting admin validation.                        */
/*                                                                                                                   */
/*  quotes_search                 Searches for content within the quote database.                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Submits the deletion of a quote.
 *
 * @param   {int}     quote_id            The ID of the quote which will be deleted.
 * @param   {string}  [confirm_message]   If set, this string will appear as a confirmation message.
 * @param   {bool}    [hard_delete]       If set, triggers a hard deletion instead of a soft deletion.
 *
 * @returns {void}
 */

function quotes_delete( quote_id        ,
                        confirm_message ,
                        hard_delete     )
{
  // Confirm the action if needed
  if(confirm_message)
  {
    if(!confirm(confirm_message))
      return;
  }

  // Assemble the postdata
  postdata    = 'quote_id=' + fetch_sanitize(quote_id);
  if(hard_delete)
    postdata += '&quote_hard_delete=1';

  // Submit the deletion request
  fetch_page('delete', 'quote_body_' + quote_id, postdata);
}




/**
 * Triggers the undeletion of a soft deleted quote.
 *
 * @param   {int}   quote_id    The ID of the quote which will be restored.
 *
 * @returns {void}
 */

function quotes_restore(quote_id)
{
  // Assemble the postdata
  postdata = 'quote_id=' + fetch_sanitize(quote_id);

  // Submit the deletion request
  fetch_page('restore', 'quote_body_' + quote_id, postdata);
}



/**
 * Triggers the approval of a quote awaiting admin validation.
 *
 * @param   {int}     quote_id          The ID of the quote being approved.
 * @param   {string}  confirm_message   The contents of the confirmation message.
 *
 * @returns {void}
 */

function quotes_approve(  quote_id        ,
                          confirm_message )
{
  // Require confirmation
  if(!confirm(confirm_message))
    return;

  // Assemble the postdata
  postdata = 'quote_id=' + fetch_sanitize(quote_id);

  // Submit the approval request
  fetch_page('approve', 'quote_body_' + quote_id, postdata);
}




/**
 * Searches for content within the quote database.
 *
 * @returns {void}
 */

function quotes_search()
{
  // Assemble the postdata
  postdata  = 'quotes_lang_en='       + fetch_sanitize(document.getElementById('quotes_lang_en').checked);
  postdata += '&quotes_lang_fr='      + fetch_sanitize(document.getElementById('quotes_lang_fr').checked);
  postdata += '&quotes_search_body='  + fetch_sanitize_id('quotes_search_body');
  postdata += '&quotes_waitlist='     + fetch_sanitize_id('quotes_waitlist');
  postdata += '&quotes_deleted='      + fetch_sanitize_id('quotes_deleted');

  // Submit the change request
  fetch_page('list', 'quotes_list_body', postdata);
}