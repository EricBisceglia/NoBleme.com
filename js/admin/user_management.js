/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_reactivate_account    Reactivates a deleted account.                                                       */
/*  admin_reactivate_search     Performs a search through the deactivated accounts.                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Reactivates a deleted account
 *
 * @param   {int}     [account_id]  The ID of the account to reactivate.
 * @param   {string}  [message]     The confirmation message which will be displayed.
 *
 * @returns {void}
 */

 function admin_reactivate_account( account_id  ,
                                    message     )
 {
  // Make sure the user knows what they're doing and fetch the data
  if(confirm(message))
    fetch_page('user_reactivate', 'admin_reactivate_row_' + account_id, 'reactivate_id=' + account_id);
 }




/**
 * Performs a search through the deactivated accounts.
 *
 * @param   {string}  [sort_data] The column which should be used to sort the data.
 *
 * @returns {void}
*/

function admin_reactivate_search( sort_data = null )
{
  // Update the data sort input if requested
  if(sort_data)
    document.getElementById('admin_reactivate_sort').value = sort_data;

  // Assemble the postdata
  postdata  = 'admin_reactivate_sort='      + fetch_sanitize_id('admin_reactivate_sort');
  postdata += '&admin_reactivate_id='       + fetch_sanitize_id('admin_reactivate_id');
  postdata += '&admin_reactivate_username=' + fetch_sanitize_id('admin_reactivate_username');

  // Submit the search
  fetch_page('user_deactivate', 'admin_reactivate_tbody', postdata);
}
