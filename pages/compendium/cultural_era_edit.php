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
$page_url         = "pages/compendium/cultural_era_edit";
$page_title_en    = "Compendium: Edit an era";
$page_title_fr    = "Compendium : Modifier une période";

// Extra CSS
$css = array('compendium');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch era data

// Fetch the era's id
$compendium_era_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the era data
$compendium_era_data = compendium_eras_get($compendium_era_id);

// Stop here if the era does not exist
if(!$compendium_era_data)
  exit(header("Location: ".$path."pages/compendium/cultural_era_admin"));

// Prepare the form values
if(isset($_POST['compendium_era_edit_start']))
{
  $compendium_era_edit_start    = (int)form_fetch_element('compendium_era_edit_start');
  $compendium_era_edit_end      = (int)form_fetch_element('compendium_era_edit_end');
  $compendium_era_edit_name_en  = form_fetch_element('compendium_era_edit_name_en');
  $compendium_era_edit_name_fr  = form_fetch_element('compendium_era_edit_name_fr');
  $compendium_era_edit_short_en = form_fetch_element('compendium_era_edit_short_en');
  $compendium_era_edit_short_fr = form_fetch_element('compendium_era_edit_short_fr');
  $compendium_era_edit_body_en  = form_fetch_element('compendium_era_edit_body_en');
  $compendium_era_edit_body_fr  = form_fetch_element('compendium_era_edit_body_fr');
}
else
{
  $compendium_era_edit_start    = $compendium_era_data['start'];
  $compendium_era_edit_end      = $compendium_era_data['end'];
  $compendium_era_edit_name_en  = $compendium_era_data['name_en'];
  $compendium_era_edit_name_fr  = $compendium_era_data['name_fr'];
  $compendium_era_edit_short_en = $compendium_era_data['short_en'];
  $compendium_era_edit_short_fr = $compendium_era_data['short_fr'];
  $compendium_era_edit_body_en  = $compendium_era_data['body_en'];
  $compendium_era_edit_body_fr  = $compendium_era_data['body_fr'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit an era

if(isset($_POST['compendium_era_edit_submit']))
{
  // Place the values in an array
  $compendium_era_edit_values = array(  'start'     => $compendium_era_edit_start     ,
                                        'end'       => $compendium_era_edit_end       ,
                                        'name_en'   => $compendium_era_edit_name_en   ,
                                        'name_fr'   => $compendium_era_edit_name_fr   ,
                                        'short_en'  => $compendium_era_edit_short_en  ,
                                        'short_fr'  => $compendium_era_edit_short_fr  ,
                                        'body_en'   => $compendium_era_edit_body_en   ,
                                        'body_fr'   => $compendium_era_edit_body_fr   );

  // Attempt to edit the era
  $compendium_era_edit_error = compendium_eras_edit(  $compendium_era_id          ,
                                                      $compendium_era_edit_values );

  // Redirect if it was successfully created
  if(!$compendium_era_edit_error)
    exit(header("Location: ".$path."pages/compendium/cultural_era?era=".$compendium_era_id));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Preview

// Apply the NBCodes
if(isset($_POST['compendium_era_edit_preview']))
{
  $compendium_era_edit_preview_en = compendium_nbcodes_apply($compendium_era_edit_body_en);
  $compendium_era_edit_preview_fr = compendium_nbcodes_apply($compendium_era_edit_body_fr);
}

// Prepare the form values
if(isset($_POST['compendium_era_edit_start']))
{
  $compendium_era_edit_start    = sanitize_output($compendium_era_edit_start);
  $compendium_era_edit_end      = sanitize_output($compendium_era_edit_end);
  $compendium_era_edit_name_en  = sanitize_output($compendium_era_edit_name_en);
  $compendium_era_edit_name_fr  = sanitize_output($compendium_era_edit_name_fr);
  $compendium_era_edit_short_en = sanitize_output($compendium_era_edit_short_en);
  $compendium_era_edit_short_fr = sanitize_output($compendium_era_edit_short_fr);
  $compendium_era_edit_body_en  = sanitize_output($compendium_era_edit_body_en);
  $compendium_era_edit_body_fr  = sanitize_output($compendium_era_edit_body_fr);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 padding_bot">

  <h1 class="align_center">
    <?=__link('pages/compendium/cultural_era_admin', __('compendium_era_edit_title'), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <div class="padding_top">
        <label for="compendium_era_edit_start"><?=__('compendium_era_add_start')?></label>
        <input class="indiv" type="text" id="compendium_era_edit_start" name="compendium_era_edit_start" value="<?=$compendium_era_edit_start?>">
      </div>

      <div class="smallpadding_top">
        <label for="compendium_era_edit_end"><?=__('compendium_era_add_end')?></label>
        <input class="indiv" type="text" id="compendium_era_edit_end" name="compendium_era_edit_end" value="<?=$compendium_era_edit_end?>">
      </div>

      <div class="flexcontainer">
        <div class="flex spaced_right">

          <div class="smallpadding_top smallpadding_bot">
            <label for="compendium_era_edit_name_en"><?=__('compendium_era_add_name_en')?></label>
            <input class="indiv" type="text" id="compendium_era_edit_name_en" name="compendium_era_edit_name_en" value="<?=$compendium_era_edit_name_en?>">
          </div>

          <div class="smallpadding_bot">
            <label for="compendium_era_edit_short_en"><?=__('compendium_era_add_short_en')?></label>
            <input class="indiv" type="text" id="compendium_era_edit_short_en" name="compendium_era_edit_short_en" value="<?=$compendium_era_edit_short_en?>">
          </div>

          <label for="compendium_era_edit_body_en"><?=__('compendium_type_add_body_en')?></label>
          <textarea class="compendium_admin_editor" id="compendium_era_edit_body_en" name="compendium_era_edit_body_en"><?=$compendium_era_edit_body_en?></textarea>

        </div>
        <div class="flex spaced_left">

          <div class="smallpadding_top smallpadding_bot">
            <label for="compendium_era_edit_name_fr"><?=__('compendium_era_add_name_fr')?></label>
            <input class="indiv" type="text" id="compendium_era_edit_name_fr" name="compendium_era_edit_name_fr" value="<?=$compendium_era_edit_name_fr?>">
          </div>

          <div class="smallpadding_bot">
            <label for="compendium_era_edit_short_fr"><?=__('compendium_era_add_short_fr')?></label>
            <input class="indiv" type="text" id="compendium_era_edit_short_fr" name="compendium_era_edit_short_fr" value="<?=$compendium_era_edit_short_fr?>">
          </div>

          <label for="compendium_era_edit_body_fr"><?=__('compendium_type_add_body_fr')?></label>
          <textarea class="compendium_admin_editor" id="compendium_era_edit_body_fr" name="compendium_era_edit_body_fr"><?=$compendium_era_edit_body_fr?></textarea>

        </div>
      </div>

      <div class="smallpadding_top">
        <span class="spaced_right">
          <input type="submit" name="compendium_era_edit_preview" value="<?=__('preview')?>">
        </span>
        <input type="submit" name="compendium_era_edit_submit" value="<?=__('compendium_era_edit_submit')?>">
      </div>

    </fieldset>
  </form>

  <?php if(isset($compendium_era_edit_error)) { ?>

  <div class="padding_top">
    <div class="red text_white align_center uppercase bold bigger spaced">
      <?=__('error').__(':', spaces_after: 1).$compendium_era_edit_error?>
    </div>
  </div>

  <?php } ?>

</div>

<?php if(isset($_POST['compendium_era_edit_preview'])) { ?>

<?php if($compendium_era_edit_name_en) { ?>

<hr>

<div class="width_50 padding_bot padding_top">

  <h1>
    <?=__('compendium_index_title')?>
  </h1>

  <h5>
    <?=__('compendium_era_subtitle', spaces_after: 1).$compendium_era_edit_name_en?>
  </h5>

  <p class="italics">
    <?=__('compendium_eras_summary')?>
  </p>

  <?php if($compendium_era_edit_preview_en) { ?>
  <div class="padding_top">
    <?=$compendium_era_edit_preview_en?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_era_pages')?>
  </h3>

  <p>
    <?=__('compendium_era_empty')?>
  </p>

</div>

<?php } if($compendium_era_edit_name_fr) { ?>

<hr>

<div class="width_50 padding_top">

  <h1>
    <?=__('compendium_index_title')?>
  </h1>

  <h5>
    <?=__('compendium_era_subtitle', spaces_after: 1).$compendium_era_edit_name_fr?>
  </h5>

  <p class="italics">
    <?=__('compendium_eras_summary')?>
  </p>

  <?php if($compendium_era_edit_preview_fr) { ?>
  <div class="padding_top">
    <?=$compendium_era_edit_preview_fr?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_era_pages')?>
  </h3>

  <p>
    <?=__('compendium_era_empty')?>
  </p>

</div>

<?php } ?>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }