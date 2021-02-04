/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_set_language           Submits a language change to the user's quotes settings.                           */
/*                                                                                                                   */
/*********************************************************************************************************************/


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