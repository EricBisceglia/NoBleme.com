<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a compendium category

// Fetch the category's id
$compendium_category_id = (int)form_fetch_element('compendium_category_delete');

// Attempt to delete the category
$compendium_category_delete = compendium_categories_delete($compendium_category_id);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if($compendium_category_delete) { ?>

<td colspan="4" class="red spaced text_white align_center bold uppercase">
  <?=$compendium_category_delete?>
</td>

<?php } else { ?>

<td colspan="4" class="green spaced text_white align_center bold uppercase">
  <?=__('compendium_category_delete_ok')?>
</td>

<?php } ?>