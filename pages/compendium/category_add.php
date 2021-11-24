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
$page_url         = "pages/compendium/category_add";
$page_title_en    = "Compendium: New category";
$page_title_fr    = "Compendium : Nouvelle catégorie";

// Extra CSS
$css = array('compendium');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add a category

// Fetch the submitted values
$compendium_category_add_order    = (int)form_fetch_element('compendium_category_add_order');
$compendium_category_add_name_en  = form_fetch_element('compendium_category_add_name_en');
$compendium_category_add_name_fr  = form_fetch_element('compendium_category_add_name_fr');
$compendium_category_add_body_en  = form_fetch_element('compendium_category_add_body_en');
$compendium_category_add_body_fr  = form_fetch_element('compendium_category_add_body_fr');

// Create the category
if(isset($_POST['compendium_category_add_submit']))
{
  // Place the values in an array
  $compendium_category_add_values = array(  'order'   => $compendium_category_add_order   ,
                                            'name_en' => $compendium_category_add_name_en ,
                                            'name_fr' => $compendium_category_add_name_fr ,
                                            'body_en' => $compendium_category_add_body_en ,
                                            'body_fr' => $compendium_category_add_body_fr );

  // Attempt to create the category
  $compendium_category_add_error = compendium_categories_add($compendium_category_add_values);

  // Redirect if it was successfully created
  if(is_int($compendium_category_add_error))
    exit(header("Location: ".$path."pages/compendium/category?id=".$compendium_category_add_error));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Preview

// Apply the NBCodes
if(isset($_POST['compendium_category_add_preview']))
{
  $compendium_category_add_preview_en = compendium_nbcodes_apply($compendium_category_add_body_en);
  $compendium_category_add_preview_fr = compendium_nbcodes_apply($compendium_category_add_body_fr);
}

// Prepare the form values
$compendium_category_add_order    = sanitize_output($compendium_category_add_order);
$compendium_category_add_name_en  = sanitize_output($compendium_category_add_name_en);
$compendium_category_add_name_fr  = sanitize_output($compendium_category_add_name_fr);
$compendium_category_add_body_en  = sanitize_output($compendium_category_add_body_en);
$compendium_category_add_body_fr  = sanitize_output($compendium_category_add_body_fr);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 padding_bot">

  <h1 class="align_center">
    <?=__link('pages/compendium/category_admin', __('compendium_category_add_title'), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <div class="padding_top">
        <label for="compendium_category_add_order"><?=__('compendium_category_add_order')?></label>
        <input class="indiv" type="text" id="compendium_category_add_order" name="compendium_category_add_order" value="<?=$compendium_category_add_order?>">
      </div>

      <div class="flexcontainer">
        <div class="flex spaced_right">

          <div class="smallpadding_top smallpadding_bot">
            <label for="compendium_category_add_name_en"><?=__('compendium_category_add_name_en')?></label>
            <input class="indiv" type="text" id="compendium_category_add_name_en" name="compendium_category_add_name_en" value="<?=$compendium_category_add_name_en?>">
          </div>

          <label for="compendium_category_add_body_en"><?=__('compendium_type_add_body_en')?></label>
          <textarea class="compendium_admin_editor" id="compendium_category_add_body_en" name="compendium_category_add_body_en"><?=$compendium_category_add_body_en?></textarea>

        </div>
        <div class="flex spaced_left">

          <div class="smallpadding_top smallpadding_bot">
            <label for="compendium_category_add_name_fr"><?=__('compendium_category_add_name_fr')?></label>
            <input class="indiv" type="text" id="compendium_category_add_name_fr" name="compendium_category_add_name_fr" value="<?=$compendium_category_add_name_fr?>">
          </div>

          <label for="compendium_category_add_body_fr"><?=__('compendium_type_add_body_fr')?></label>
          <textarea class="compendium_admin_editor" id="compendium_category_add_body_fr" name="compendium_category_add_body_fr"><?=$compendium_category_add_body_fr?></textarea>

        </div>
      </div>

      <div class="smallpadding_top">
        <span class="spaced_right">
          <input type="submit" name="compendium_category_add_preview" value="<?=__('preview')?>">
        </span>
        <input type="submit" name="compendium_category_add_submit" value="<?=__('compendium_category_add_submit')?>">
      </div>

    </fieldset>
  </form>

  <?php if(isset($compendium_category_add_error)) { ?>

  <div class="padding_top">
    <div class="red text_white align_center uppercase bold bigger spaced">
      <?=__('error').__(':', spaces_after: 1).$compendium_category_add_error?>
    </div>
  </div>

  <?php } ?>

</div>

<?php if(isset($_POST['compendium_category_add_preview'])) { ?>

<?php if($compendium_category_add_name_en) { ?>

<hr>

<div class="width_50 padding_bot padding_top">

  <h1>
    <?=__('compendium_index_title')?>
  </h1>

  <h5>
    <?=$compendium_category_add_name_en?>
  </h5>

  <p class="italics">
    <?=__('compendium_category_summary')?>
  </p>

  <?php if($compendium_category_add_preview_en) { ?>
  <div class="padding_top">
    <?=$compendium_category_add_preview_en?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_category_pages')?>
  </h3>

  <p>
    <?=__('compendium_category_empty')?>
  </p>

</div>

<?php } if($compendium_category_add_name_fr) { ?>

<hr>

<div class="width_50 padding_top">

  <h1>
    <?=__('compendium_index_title')?>
  </h1>

  <h5>
    <?=$compendium_category_add_name_fr?>
  </h5>

  <p class="italics">
    <?=__('compendium_category_summary')?>
  </p>

  <?php if($compendium_category_add_preview_fr) { ?>
  <div class="padding_top">
    <?=$compendium_category_add_preview_fr?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_category_pages')?>
  </h3>

  <p>
    <?=__('compendium_category_empty')?>
  </p>

</div>

<?php } ?>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }