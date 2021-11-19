<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';         # Core

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
// Fetch the image data

// Fetch the image's id
$compendium_image_id = (int)form_fetch_element('compendium_image_id');

// Fetch the image data
$compendium_image_data = compendium_images_get( image_id: $compendium_image_id );

// Stop here if the image doesn't exist or isn't allowed to be seen
if(!isset($compendium_image_data) || !$compendium_image_data)
  exit(header("Location: ".$path."pages/compendium/page_list"));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<h2 class="align_center padding_bot">
  <?=$compendium_image_data['name']?>
</h2>

<div class="padding_top padding_bot align_center">
  <img src="<?=$path?>img/compendium/<?=$compendium_image_data['name']?>">
</div>

<?php if($compendium_image_data['body']) { ?>

<div class="padding_top padding_bot align_center">
  <?=$compendium_image_data['body']?>
</div>

<?php } ?>