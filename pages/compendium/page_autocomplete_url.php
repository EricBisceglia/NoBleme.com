<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions

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
$autocomplete_url           = form_fetch_element('compendium_autocomplete_url', '');
$autocomplete_id            = form_fetch_element('compendium_autocomplete_id', '');
$autocomplete_no_redirects  = (bool)form_fetch_element('compendium_autocomplete_no_redirects', false);

// Autocomplete the page url
$autocomplete_data = compendium_pages_autocomplete( $autocomplete_url           ,
                                                    $autocomplete_no_redirects  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<datalist id="<?=$autocomplete_id?>">
  <?php for($i = 0; $i < $autocomplete_data['rows']; $i++) { ?>
  <option value="<?=$autocomplete_data[$i]['url']?>">
  <?php } ?>
</datalist>