<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';         # BBCodes

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
// Delete a compendium era

// Fetch the era's id
$compendium_era_id = (int)form_fetch_element('compendium_era_delete');

// Attempt to delete the era
$compendium_era_delete = compendium_eras_delete($compendium_era_id);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if($compendium_era_delete) { ?>

<td colspan="6" class="red spaced text_white align_center bold uppercase">
  <?=$compendium_era_delete?>
</td>

<?php } else { ?>

<td colspan="6" class="green spaced text_white align_center bold uppercase">
  <?=__('compendium_era_delete_ok')?>
</td>

<?php } ?>