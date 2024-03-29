<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../inc/bbcodes.inc.php';   # Core

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Process the BBCodes preview

$preview = bbcodes(sanitize_output(form_fetch_element('preview_element', ''), true));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

echo $preview;