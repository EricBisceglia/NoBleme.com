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
// Delete a compendium page type

// Fetch the page type's id
$compendium_type_id = (int)form_fetch_element('compendium_type_delete');

// Attempt to delete the page type
$compendium_type_delete = compendium_types_delete($compendium_type_id);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if($compendium_type_delete) { ?>

<td colspan="5" class="red spaced text_white align_center bold uppercase">
  <?=$compendium_type_delete?>
</td>

<?php } else { ?>

<td colspan="5" class="green spaced text_white align_center bold uppercase">
  <?=__('compendium_type_delete_ok')?>
</td>

<?php } ?>