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

  // Submit the change request
  fetch_page('index', 'quotes_list_body', postdata);
}