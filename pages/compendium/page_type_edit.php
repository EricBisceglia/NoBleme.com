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
$page_url         = "pages/compendium/page_type_edit";
$page_title_en    = "Compendium: Edit a page type";
$page_title_fr    = "Compendium : Modifier une thématique";

// Extra CSS
$css = array('compendium');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch page type data

// Fetch the page type's id
$compendium_type_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the page type data
$compendium_type_data = compendium_types_get($compendium_type_id);

// Stop here if the page type does not exist
if(!$compendium_type_data)
  exit(header("Location: ".$path."pages/compendium/page_type_admin"));

// Prepare the form values
if(isset($_POST['compendium_type_edit_order']))
{
  $compendium_type_edit_order   = (int)form_fetch_element('compendium_type_edit_order');
  $compendium_type_edit_name_en = form_fetch_element('compendium_type_edit_name_en');
  $compendium_type_edit_name_fr = form_fetch_element('compendium_type_edit_name_fr');
  $compendium_type_edit_full_en = form_fetch_element('compendium_type_edit_full_en');
  $compendium_type_edit_full_fr = form_fetch_element('compendium_type_edit_full_fr');
  $compendium_type_edit_body_en = form_fetch_element('compendium_type_edit_body_en');
  $compendium_type_edit_body_fr = form_fetch_element('compendium_type_edit_body_fr');
}
else
{
  $compendium_type_edit_order   = $compendium_type_data['order'];
  $compendium_type_edit_name_en = $compendium_type_data['name_en'];
  $compendium_type_edit_name_fr = $compendium_type_data['name_fr'];
  $compendium_type_edit_full_en = $compendium_type_data['full_en'];
  $compendium_type_edit_full_fr = $compendium_type_data['full_fr'];
  $compendium_type_edit_body_en = $compendium_type_data['body_en'];
  $compendium_type_edit_body_fr = $compendium_type_data['body_fr'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit a page type

if(isset($_POST['compendium_type_edit_submit']))
{
  // Place the values in an array
  $compendium_type_edit_values = array( 'order'   => $compendium_type_edit_order    ,
                                        'name_en' => $compendium_type_edit_name_en  ,
                                        'name_fr' => $compendium_type_edit_name_fr  ,
                                        'full_en' => $compendium_type_edit_full_en  ,
                                        'full_fr' => $compendium_type_edit_full_fr  ,
                                        'body_en' => $compendium_type_edit_body_en  ,
                                        'body_fr' => $compendium_type_edit_body_fr  );

  // Attempt to edit the page type
  $compendium_type_edit_error = compendium_types_edit(  $compendium_type_id           ,
                                                        $compendium_type_edit_values  );

  // Redirect if it was successfully created
  if(!$compendium_type_edit_error)
    exit(header("Location: ".$path."pages/compendium/page_type?type=".$compendium_type_id));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Preview

// Apply the NBCodes
if(isset($_POST['compendium_type_edit_preview']))
{
  $compendium_type_edit_preview_en = compendium_nbcodes_apply($compendium_type_edit_body_en);
  $compendium_type_edit_preview_fr = compendium_nbcodes_apply($compendium_type_edit_body_fr);
}

// Prepare the form values
if(isset($_POST['compendium_type_edit_order']))
{
  $compendium_type_edit_order   = sanitize_output($compendium_type_edit_order);
  $compendium_type_edit_name_en = sanitize_output($compendium_type_edit_name_en);
  $compendium_type_edit_name_fr = sanitize_output($compendium_type_edit_name_fr);
  $compendium_type_edit_full_en = sanitize_output($compendium_type_edit_full_en);
  $compendium_type_edit_full_fr = sanitize_output($compendium_type_edit_full_fr);
  $compendium_type_edit_body_en = sanitize_output($compendium_type_edit_body_en);
  $compendium_type_edit_body_fr = sanitize_output($compendium_type_edit_body_fr);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 padding_bot">

  <h1 class="align_center">
    <?=__link('pages/compendium/page_type_admin', __('compendium_type_edit_title'), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <div class="padding_top">
        <label for="compendium_type_edit_order"><?=__('compendium_category_add_order')?></label>
        <input class="indiv" type="text" id="compendium_type_edit_order" name="compendium_type_edit_order" value="<?=$compendium_type_edit_order?>">
      </div>

      <div class="flexcontainer">
        <div class="flex spaced_right">

          <div class="smallpadding_top smallpadding_bot">
            <label for="compendium_type_edit_name_en"><?=__('compendium_type_add_name_en')?></label>
            <input class="indiv" type="text" id="compendium_type_edit_name_en" name="compendium_type_edit_name_en" value="<?=$compendium_type_edit_name_en?>">
          </div>

          <div class="smallpadding_bot">
            <label for="compendium_type_edit_full_en"><?=__('compendium_type_add_full_en')?></label>
            <input class="indiv" type="text" id="compendium_type_edit_full_en" name="compendium_type_edit_full_en" value="<?=$compendium_type_edit_full_en?>">
          </div>

          <label for="compendium_type_edit_body_en"><?=__('compendium_type_add_body_en')?></label>
          <textarea class="compendium_admin_editor" id="compendium_type_edit_body_en" name="compendium_type_edit_body_en"><?=$compendium_type_edit_body_en?></textarea>

        </div>
        <div class="flex spaced_left">

          <div class="smallpadding_top smallpadding_bot">
            <label for="compendium_type_edit_name_fr"><?=__('compendium_type_add_name_fr')?></label>
            <input class="indiv" type="text" id="compendium_type_edit_name_fr" name="compendium_type_edit_name_fr" value="<?=$compendium_type_edit_name_fr?>">
          </div>

          <div class="smallpadding_bot">
            <label for="compendium_type_edit_full_fr"><?=__('compendium_type_add_full_fr')?></label>
            <input class="indiv" type="text" id="compendium_type_edit_full_fr" name="compendium_type_edit_full_fr" value="<?=$compendium_type_edit_full_fr?>">
          </div>

          <label for="compendium_type_edit_body_fr"><?=__('compendium_type_add_body_fr')?></label>
          <textarea class="compendium_admin_editor" id="compendium_type_edit_body_fr" name="compendium_type_edit_body_fr"><?=$compendium_type_edit_body_fr?></textarea>

        </div>
      </div>

      <div class="smallpadding_top">
        <span class="spaced_right">
          <input type="submit" name="compendium_type_edit_preview" value="<?=__('preview')?>">
        </span>
        <input type="submit" name="compendium_type_edit_submit" value="<?=__('compendium_type_edit_submit')?>">
      </div>

    </fieldset>
  </form>

  <?php if(isset($compendium_type_edit_error)) { ?>

  <div class="padding_top">
    <div class="red text_white align_center uppercase bold bigger spaced">
      <?=__('error').__(':', spaces_after: 1).$compendium_type_edit_error?>
    </div>
  </div>

  <?php } ?>

</div>

<?php if(isset($_POST['compendium_type_edit_preview'])) { ?>

<?php if($compendium_type_edit_name_en) { ?>

<hr>

<div class="width_50 padding_bot padding_top">

  <h1>
    <?=__('submenu_pages_compendium')?>
  </h1>

  <h5>
    <?=__('compendium_type_subtitle', spaces_after: 1).$compendium_type_edit_full_en?>
  </h5>

  <p class="italics">
    <?=__('compendium_type_summary')?>
  </p>

  <?php if($compendium_type_edit_preview_en) { ?>
  <div class="padding_top align_justify">
    <?=$compendium_type_edit_preview_en?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_type_pages')?>
  </h3>

  <p>
    <?=__('compendium_type_empty')?>
  </p>

</div>

<?php } if($compendium_type_edit_name_fr) { ?>

<hr>

<div class="width_50 padding_top">

  <h1>
    <?=__('submenu_pages_compendium')?>
  </h1>

  <h5>
    <?=__('compendium_type_subtitle', spaces_after: 1).$compendium_type_edit_full_fr?>
  </h5>

  <p class="italics">
    <?=__('compendium_type_summary')?>
  </p>

  <?php if($compendium_type_edit_preview_fr) { ?>
  <div class="padding_top align_justify">
    <?=$compendium_type_edit_preview_fr?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_type_pages')?>
  </h3>

  <p>
    <?=__('compendium_type_empty')?>
  </p>

</div>

<?php } ?>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }