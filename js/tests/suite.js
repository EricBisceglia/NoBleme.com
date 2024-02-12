/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tests_suite_select_all        Selects all entries in the test suite.                                             */
/*  tests_suite_unselect_all      Unselects all entries in the test suite.                                           */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Selects all entries in the test suite.
 *
 * @returns {void}
 */

function tests_suite_select_all()
{
  // Fetch all checkboxes in the form
  var checkboxes = document.querySelectorAll("#dev_tests_selector input[type=checkbox]");

  // Loop through the checkboxes and check them
  for($i = 0; $i < checkboxes.length; $i++)
    checkbox_toggle_oneway(checkboxes[$i].id, 1, 'table-row');

  // Uncheck the radio button used to trigger this function
  document.querySelector('input[name="dev_tests_all"]:checked').checked = false;
}




/**
 * Unselects all entries in the test suite.
 *
 * @returns {void}
 */

function tests_suite_unselect_all()
{
  // Fetch all checkboxes in the form
  var checkboxes = document.querySelectorAll("#dev_tests_selector input[type=checkbox]");

  // Loop through the checkboxes and uncheck them
  for($i = 0; $i < checkboxes.length; $i++)
    checkbox_toggle_oneway(checkboxes[$i].id, 0, 'table-row');

  // Uncheck the radio button used to trigger this function
  document.querySelector('input[name="dev_tests_none"]:checked').checked = false;
}