<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/users.act.php'; # Actions

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
$autocomplete_username  = form_fetch_element('autocomplete_username', '');
$autocomplete_datalist  = form_fetch_element('autocomplete_datalist', '');
$autocomplete_type      = form_fetch_element('autocomplete_type', '');
$autocomplete_id        = form_fetch_element('autocomplete_id', 0);

// Autocomplete the username
$autocomplete_data = users_autocomplete_username( $autocomplete_username  ,
                                                  $autocomplete_type      ,
                                                  $autocomplete_id        );




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