/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_delete                 Triggers the deletion of a quote.                                                  */
/*                                                                                                                   */
/*  quotes_set_language           Submits a language change to the user's quotes settings.                           */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Submits the deletion of a quote.
 *
 * @param   {int}   quote_id  The ID of the quote which will be deleted.
 *
 * @returns {void}
 */

function quote_delete(quote_id)
{
  // Assemble the postdata
  postdata  = 'quote_id=' + fetch_sanitize(quote_id);

  // Submit the deletion request
  fetch_page('delete', 'quote_body_' + quote_id, postdata);
}




/**
 * Submits a language change to the user's quotes settings.
 *
 * @returns {void}
 */

function quotes_set_language()
{
  // Assemble the postdata
  postdata  = 'quotes_lang_en='   + fetch_sanitize(document.getElementById('quotes_lang_en').checked);
  postdata += '&quotes_lang_fr='  + fetch_sanitize(document.getElementById('quotes_lang_fr').checked);
  postdata += '&quotes_waitlist=' + fetch_sanitize_id('quotes_waitlist');
  postdata += '&quotes_deleted='  + fetch_sanitize_id('quotes_deleted');

  // Submit the change request
  fetch_page('list', 'quotes_list_body', postdata);
}