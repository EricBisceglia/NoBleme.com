<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';         # Core

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/image";
$page_title_en    = "Image";
$page_title_fr    = "Image";
$page_description = "An image used to illustrate NoBleme's 21st century culture compendium.";

// Extra CSS
$css = array('compendium');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the image data

// Fetch the image's file name
$compendium_image_file_name = (string)form_fetch_element('name', request_type: 'GET');

// Fetch the image data
$compendium_image_data = compendium_images_get( file_name: $compendium_image_file_name );

// Stop here if the image doesn't exist or isn't allowed to be seen
if(!isset($compendium_image_data) || !$compendium_image_data)
  exit(header("Location: ".$path."pages/compendium/page_list"));

// Update the page summary
$page_url        .= '?name='.$compendium_image_file_name;
$page_title_en   .= ': '.$compendium_image_file_name;
$page_title_fr   .= ' : '.$compendium_image_file_name;
$page_description = ($compendium_image_data['body_clean']) ? $compendium_image_data['body_clean'] : $page_description;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <?php if($compendium_image_data['deleted']) { ?>
  <div class="padding_bot">
    <h5 class="uppercase red text_white bold spaced align_center">
      <?=__('compendium_image_deleted')?>
    </h5>
  </div>
  <?php } ?>

  <h2 class="align_center padding_bot">
    <?=__link('pages/compendium/page_list', $compendium_image_file_name, 'noglow')?>
  </h2>

  <?php if($compendium_image_data['nsfw']) { ?>
  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase bigger bold">
      <?=__('compendium_image_nsfw')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>
  <?php } ?>

  <?php if($compendium_image_data['offensive']) { ?>
  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase big bold">
      <?=__('compendium_image_offensive')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>
  <?php } ?>

  <?php if($compendium_image_data['gross']) { ?>
  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase bigger bold">
      <?=__('compendium_image_gross')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>
  <?php } ?>

  <?php if($compendium_image_data['blurred']) { ?>
  <p class="hugepadding_bot">
    <?=__('compendium_image_blurred')?>
  </p>
  <?php } ?>

</div>

<div class="width_70">

  <div class="padding_top padding_bot align_center">
    <img src="<?=$path?>img/compendium/<?=$compendium_image_file_name?>"<?=$compendium_image_data['blur']?>>
  </div>

</div>

<div class="width_50">

  <?php if($compendium_image_data['body']) { ?>

  <div class="padding_top padding_bot align_center">
    <?=$compendium_image_data['body']?>
  </div>

  <?php } if($compendium_image_data['used']) { ?>

  <p class="align_center padding_bot">
    <?=__('compendium_image_used', amount: $compendium_image_data['used_count'])?><br>
    <?=$compendium_image_data['used']?>
  </p>

  <?php } ?>

  <p class="align_center padding_bot bigger">
    <?=__link('pages/compendium/random_image?id='.$compendium_image_data['id'], __('compendium_image_random'))?>
  </p>

  <p class="small align_center">
    <?=__('compendium_image_disclaimer')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }