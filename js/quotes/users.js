/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_unlink_account       Unlinks an account from a quote.                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Unlinks an account from a quote.
 *
 * @param   {int}   quote_id  Id of the quote.
 * @param   {int}   user_id   User id of the account.
 *
 * @returns {void}
 */

function quotes_unlink_account( quote_id  ,
                                user_id   )
{

  // Assemble the postdata
  postdata  = 'quote_id=' + fetch_sanitize(quote_id);
  postdata += '&user_id=' + fetch_sanitize(user_id);
  postdata += '&quote_unlink_account=1'

  // Submit the deletion request
  fetch_page('users?id=' + quote_id, 'quote_users_list', postdata);
}
