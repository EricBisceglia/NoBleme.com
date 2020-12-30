<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Retrieve the version id
$version_id = form_fetch_element('version_id', 0);

// Fetch elements related to the version
if($version_id)
  $version_data = dev_versions_get($version_id);

// Prepare errors if anything went wrong
if(!$version_id)
  $error = __('dev_versions_edit_error_postdata');
else if(!$version_data)
  $error = __('dev_versions_edit_error_id');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if(isset($error)) { ?>

<h5 class="align_center">
  <?=$error?>
</h5>

<?php } else { ?>

<fieldset>

<input type="hidden" id="dev_versions_edit_id" name="dev_versions_edit_id" value="<?=$version_id?>">

<div class="smallpadding_bot">
  <label for="dev_versions_edit_major"><?=__('dev_versions_form_major')?></label>
  <input class="indiv" type="text" id="dev_versions_edit_major" name="dev_versions_edit_major" value="<?=$version_data['major']?>">
</div>

<div class="smallpadding_bot">
  <label for="dev_versions_edit_minor"><?=__('dev_versions_form_minor')?></label>
  <input class="indiv" type="text" id="dev_versions_edit_minor" name="dev_versions_edit_minor" value="<?=$version_data['minor']?>">
</div>

<div class="smallpadding_bot">
  <label for="dev_versions_edit_patch"><?=__('dev_versions_form_patch')?></label>
  <input class="indiv" type="text" id="dev_versions_edit_patch" name="dev_versions_edit_patch" value="<?=$version_data['patch']?>">
</div>

<div class="smallpadding_bot">
  <label for="dev_versions_edit_extension"><?=__('dev_versions_form_extension')?></label>
  <input class="indiv" type="text" id="dev_versions_edit_extension" name="dev_versions_edit_extension" value="<?=$version_data['extension']?>">
</div>

<div class="padding_bot">
  <label for="dev_versions_edit_date"><?=string_change_case(__('date'), 'initials')?> (<?=__('ddmmyy')?>)</label>
  <input class="indiv" type="text" id="dev_versions_edit_date" name="dev_versions_edit_date" value="<?=$version_data['release_date']?>">
</div>

<button onclick="dev_versions_edit();"><?=__('dev_versions_edit_button')?></button>

</fieldset>

<?php } ?>