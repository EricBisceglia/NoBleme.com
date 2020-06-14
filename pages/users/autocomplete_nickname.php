<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/users.act.php'; # Actions
include_once './../../lang/users.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Autocompletion

// Fetch the postdata
$autocomplete_nickname  = form_fetch_element('autocomplete_nickname', '');
$autocomplete_datalist  = form_fetch_element('autocomplete_datalist', '');
$autocomplete_type      = form_fetch_element('autocomplete_type', '');

// Autocomplete the nickname
$autocomplete_data = users_autocomplete_nickname( $autocomplete_nickname  ,
                                                  $autocomplete_type      );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<datalist id="<?=$autocomplete_datalist?>">
  <?php for($i = 0; $i < $autocomplete_data['rows']; $i++) { ?>
  <option value="<?=$autocomplete_data[$i]['nick']?>">
  <?php } ?>
</datalist>