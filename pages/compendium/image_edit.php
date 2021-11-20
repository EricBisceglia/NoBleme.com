<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../inc/functions_time.inc.php';  # Time management

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/image_edit";
$page_title_en    = "Compendium: Edit image";
$page_title_fr    = "Compendium : Modifier une image";

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Image data

// Fetch the image's id
$compendium_image_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the image's data
$compendium_image_data = compendium_images_get(image_id: $compendium_image_id);

// Redirect if the image doesn't exist
if(!$compendium_image_data)
  exit(header('Location: '.$path.'pages/compendium/image_admin'));

// Prepare the form values
$compendium_image_edit_name       = $compendium_image_data['name'];
$compendium_image_edit_tags       = $compendium_image_data['tags'];
$compendium_image_edit_caption_en = $compendium_image_data['caption_en'];
$compendium_image_edit_caption_fr = $compendium_image_data['caption_fr'];
$compendium_image_edit_nsfw       = $compendium_image_data['nsfw'];
$compendium_image_edit_gross      = $compendium_image_data['gross'];
$compendium_image_edit_offensive  = $compendium_image_data['offensive'];

// Update the form values if submitted
if(isset($_POST['compendium_edit_image_preview']) || isset($_POST['compendium_edit_image_submit']))
{
  $compendium_image_edit_name       = compendium_format_image_name(form_fetch_element('compendium_image_edit_name'));
  $compendium_image_edit_tags       = form_fetch_element('compendium_image_edit_tags');
  $compendium_image_edit_caption_en = form_fetch_element('compendium_image_edit_caption_en');
  $compendium_image_edit_caption_fr = form_fetch_element('compendium_image_edit_caption_fr');
  $compendium_image_edit_nsfw       = form_fetch_element('compendium_image_edit_nsfw', element_exists: true);
  $compendium_image_edit_gross      = form_fetch_element('compendium_image_edit_gross', element_exists: true);
  $compendium_image_edit_offensive  = form_fetch_element('compendium_image_edit_offensive', element_exists: true);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit the image

// Attempt to edit the image if requested
if(isset($_POST['compendium_edit_image_submit']))
{
  // Assemble the page data
  $compendium_image_edit_data = array(  'name'        => $compendium_image_edit_name        ,
                                        'tags'        => $compendium_image_edit_tags        ,
                                        'caption_en'  => $compendium_image_edit_caption_en  ,
                                        'caption_fr'  => $compendium_image_edit_caption_fr  ,
                                        'nsfw'        => $compendium_image_edit_nsfw        ,
                                        'gross'       => $compendium_image_edit_gross       ,
                                        'offensive'   => $compendium_image_edit_offensive   );

  // Edit the image
  $compendium_images_edit = compendium_images_edit( $compendium_image_id        ,
                                                    $compendium_image_edit_data );

  // Redirect if it was properly edited
  if(is_null($compendium_images_edit))
    exit(header("Location: ".$path."pages/compendium/image?name=".$compendium_image_edit_name));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Preview

// Prepare the preview data
if(isset($_POST['compendium_edit_image_preview']))
{
  $compendium_image_preview_caption_en = compendium_nbcodes_apply($compendium_image_edit_caption_en);
  $compendium_image_preview_caption_fr = compendium_nbcodes_apply($compendium_image_edit_caption_fr);
}


// Prepare the form values for displaying
if(isset($_POST['compendium_edit_image_preview']) || isset($_POST['compendium_edit_image_submit']))
{
  $compendium_image_edit_name       = sanitize_output($compendium_image_edit_name);
  $compendium_image_edit_tags       = sanitize_output($compendium_image_edit_tags);
  $compendium_image_edit_caption_en = sanitize_output($compendium_image_edit_caption_en);
  $compendium_image_edit_caption_fr = sanitize_output($compendium_image_edit_caption_fr);
}

// Keep the proper checkboxes checked
$compendium_image_edit_nsfw_checkbox      = ($compendium_image_edit_nsfw)       ? ' checked' : '';
$compendium_image_edit_gross_checkbox     = ($compendium_image_edit_gross)      ? ' checked' : '';
$compendium_image_edit_offensive_checkbox = ($compendium_image_edit_offensive)  ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h3 class="align_center bigpadding_bot">
    <?=__link('pages/compendium/image?name='.$compendium_image_data['name'], __('compendium_image_edit_title', preset_values: array($compendium_image_data['name'])), 'noglow')?>
    <?=__icon('settings', alt: 'S', title: __('settings'), title_case: 'initials', href: 'pages/compendium/image_admin', popup: true)?>
  </h3>

  <?php if(isset($compendium_images_edit)) { ?>
  <div class="padding_bot">
    <div class="red text_white uppercase bold bigger spaced">
      <?=__('error').__(':', spaces_after: 1).$compendium_images_edit?>
    </div>
  </div>
  <?php } ?>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="compendium_image_edit_name"><?=__('compendium_image_upload_name')?></label>
        <input type="text" class="indiv" id="compendium_image_edit_name" name="compendium_image_edit_name" value="<?=$compendium_image_edit_name?>" autocomplete="off" list="compendium_image_list" onkeyup="compendium_autocomplete_image('compendium_image_edit_name', 'compendium_image_list_parent', 'compendium_image_list');">
        <div id="compendium_image_list_parent">
          <datalist id="compendium_image_list">
            <option value=" ">&nbsp;</option>
          </datalist>
        </div>
      </div>

      <div class="smallpadding_bot">
        <label for="compendium_image_edit_tags"><?=__('compendium_image_upload_tags')?></label>
        <input type="text" class="indiv" id="compendium_image_edit_tags" name="compendium_image_edit_tags" value="<?=$compendium_image_edit_tags?>">
      </div>

      <div class="flexcontainer smallpadding_bot">
        <div class="flex spaced_right">

          <label for="compendium_image_edit_caption_en"><?=__('compendium_image_upload_caption_en')?></label>
          <textarea id="compendium_image_edit_caption_en" class="compendium_admin_summary" name="compendium_image_edit_caption_en"><?=$compendium_image_edit_caption_en?></textarea>

        </div>
        <div class="flex spaced_left">

          <label for="compendium_image_edit_caption_fr"><?=__('compendium_image_upload_caption_fr')?></label>
          <textarea id="compendium_image_edit_caption_fr" class="compendium_admin_summary" name="compendium_image_edit_caption_fr"><?=$compendium_image_edit_caption_fr?></textarea>

        </div>
      </div>

      <input type="checkbox" id="compendium_image_edit_nsfw" name="compendium_image_edit_nsfw"<?=$compendium_image_edit_nsfw_checkbox?>>
      <label class="label_inline" for="compendium_image_edit_nsfw"><?=__('compendium_image_upload_nsfw')?></label><br>

      <input type="checkbox" id="compendium_image_edit_gross" name="compendium_image_edit_gross"<?=$compendium_image_edit_gross_checkbox?>>
      <label class="label_inline" for="compendium_image_edit_gross"><?=__('compendium_image_upload_gross')?></label><br>

      <input type="checkbox" id="compendium_image_edit_offensive" name="compendium_image_edit_offensive"<?=$compendium_image_edit_offensive_checkbox?>>
      <label class="label_inline" for="compendium_image_edit_offensive"><?=__('compendium_image_upload_offensive')?></label>

      <div class="smallpadding_top">
        <span class="spaced_right">
          <input type="submit" name="compendium_edit_image_preview" value="<?=__('preview')?>">
        </span>
        <input type="submit" name="compendium_edit_image_submit" value="<?=__('compendium_image_edit_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php if(isset($_POST['compendium_edit_image_preview'])) { ?>

<?php if($compendium_image_edit_caption_en) { ?>

<hr>

<div class="width_50 padding_top padding_bot">

  <div class="align_center">
    <?=$compendium_image_preview_caption_en?>
  </div>

</div>

<?php } if($compendium_image_edit_caption_fr) { ?>

<hr>

<div class="width_50 padding_top padding_bot">

  <div class="align_center">
    <?=$compendium_image_preview_caption_fr?>
  </div>

</div>

<?php } if($compendium_image_edit_caption_en || $compendium_image_edit_caption_fr) { ?>

<hr>

<?php } ?>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }