/*********************************************************************************************************************/
/*                                                                                                                   */
/*  api_doc_menu            Navigates between pages of the API documentation.                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Navigates between pages of the API documentation.
 *
 * @returns {void}
 */

function api_doc_menu()
{
  // Fetch the requested page
  page = document.getElementById('api_doc_menu').value;

  // Go to the requested page
  window.location.href = page;
}