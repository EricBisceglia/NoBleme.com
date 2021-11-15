<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';         # BBCodes

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/page_add";
$page_title_en    = "New compendium page";
$page_title_fr    = "Compendium: Nouvelle page";

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Create a new compendium page

// Assemble the postdata
$compendium_new_url         = compendium_format_url(form_fetch_element('compendium_new_url'));
$compendium_new_title_en    = compendium_format_title(form_fetch_element('compendium_new_title_en'));
$compendium_new_title_fr    = compendium_format_title(form_fetch_element('compendium_new_title_fr'));
$compendium_new_redirect_en = compendium_format_url(form_fetch_element('compendium_new_redirect_en'));
$compendium_new_redirect_fr = compendium_format_url(form_fetch_element('compendium_new_redirect_fr'));
$compendium_new_summary_en  = form_fetch_element('compendium_new_summary_en');
$compendium_new_summary_fr  = form_fetch_element('compendium_new_summary_fr');
$compendium_new_body_en     = form_fetch_element('compendium_new_body_en');
$compendium_new_body_fr     = form_fetch_element('compendium_new_body_fr');

// Attempt to create the page
if(isset($_POST['compendium_new_submit']))
{
  // Assemble the page data
  $compendium_new_data = array( 'url'         => $compendium_new_url          ,
                                'title_en'    => $compendium_new_title_en     ,
                                'title_fr'    => $compendium_new_title_fr     ,
                                'redirect_en' => $compendium_new_redirect_en  ,
                                'redirect_fr' => $compendium_new_redirect_fr  ,
                                'summary_en'  => $compendium_new_summary_en   ,
                                'summary_fr'  => $compendium_new_summary_fr   ,
                                'body_en'     => $compendium_new_body_en      ,
                                'body_fr'     => $compendium_new_body_fr      );

  // Create the page
  $compendium_pages_add = compendium_pages_add($compendium_new_data);

  // Redirect if it was properly created
  if(is_int($compendium_pages_add))
    exit(header("Location: ".$path."pages/compendium/".$compendium_new_url));
}

// Prepare the preview data
if(isset($_POST['compendium_new_preview']))
{
  $compendium_preview_summary_en  = compendium_nbcodes_apply($compendium_new_summary_en);
  $compendium_preview_summary_fr  = compendium_nbcodes_apply($compendium_new_summary_fr);
  $compendium_preview_body_en     = compendium_nbcodes_apply($compendium_new_body_en);
  $compendium_preview_body_fr     = compendium_nbcodes_apply($compendium_new_body_fr);
}

// Prepare the form values for displaying
$compendium_new_url         = sanitize_output($compendium_new_url);
$compendium_new_title_en    = sanitize_output($compendium_new_title_en);
$compendium_new_title_fr    = sanitize_output($compendium_new_title_fr);
$compendium_new_redirect_en = sanitize_output($compendium_new_redirect_en);
$compendium_new_redirect_fr = sanitize_output($compendium_new_redirect_fr);
$compendium_new_summary_en  = sanitize_output($compendium_new_summary_en);
$compendium_new_summary_fr  = sanitize_output($compendium_new_summary_fr);
$compendium_new_body_en     = sanitize_output($compendium_new_body_en);
$compendium_new_body_fr     = sanitize_output($compendium_new_body_fr);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1 class="align_center bigpadding_bot">
    <?=__link('pages/compendium/page_list_admin', __('compendium_page_new_title'), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <label for="compendium_new_url"><?=__('compendium_page_new_url')?></label>
      <input type="text" class="indiv" id="compendium_new_url" name="compendium_new_url" value="<?=$compendium_new_url?>" autocomplete="off" list="compendium_url_list" onkeyup="compendium_autocomplete_url('compendium_new_url', 'compendium_url_list_parent', 'compendium_url_list');">
      <div id="compendium_url_list_parent">
        <datalist id="compendium_url_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <div class="flexcontainer smallpadding_top">
        <div class="flex spaced_right">

          <label for="compendium_new_title_en"><?=__('compendium_page_new_title_en')?></label>
          <input type="text" class="indiv" id="compendium_new_title_en" name="compendium_new_title_en" value="<?=$compendium_new_title_en?>">

          <div class="smallpadding_top">
            <label for="compendium_new_redirect_en"><?=__('compendium_page_new_redirect_en')?></label>
            <input type="text" class="indiv" id="compendium_new_redirect_en" name="compendium_new_redirect_en" value="<?=$compendium_new_redirect_en?>" autocomplete="off" list="compendium_redirect_en_list" onkeyup="compendium_autocomplete_url('compendium_new_redirect_en', 'compendium_redirect_en_list_parent', 'compendium_redirect_en_list', true);">
            <div id="compendium_redirect_en_list_parent">
              <datalist id="compendium_redirect_en_list">
                <option value=" ">&nbsp;</option>
              </datalist>
            </div>
          </div>

          <div class="smallpadding_top">
            <label for="compendium_new_summary_en"><?=__('compendium_page_new_summary_en')?></label>
            <textarea class="indiv compendium_admin_summary" id="compendium_new_summary_en" name="compendium_new_summary_en"><?=$compendium_new_summary_en?></textarea>
          </div>

          <div class="smallpadding_top">
            <label for="compendium_new_body_en"><?=__('compendium_page_new_body_en')?></label>
            <textarea class="indiv compendium_admin_editor" id="compendium_new_body_en" name="compendium_new_body_en"><?=$compendium_new_body_en?></textarea>
          </div>

        </div>
        <div class="flex spaced_left">

          <label for="compendium_new_title_fr"><?=__('compendium_page_new_title_fr')?></label>
          <input type="text" class="indiv" id="compendium_new_title_fr" name="compendium_new_title_fr" value="<?=$compendium_new_title_fr?>">

          <div class="smallpadding_top">
            <label for="compendium_new_redirect_fr"><?=__('compendium_page_new_redirect_fr')?></label>
            <input type="text" class="indiv" id="compendium_new_redirect_fr" name="compendium_new_redirect_fr" value="<?=$compendium_new_redirect_fr?>" autocomplete="off" list="compendium_redirect_fr_list" onkeyup="compendium_autocomplete_url('compendium_new_redirect_fr', 'compendium_redirect_fr_list_parent', 'compendium_redirect_fr_list', true);">
            <div id="compendium_redirect_fr_list_parent">
              <datalist id="compendium_redirect_fr_list">
                <option value=" ">&nbsp;</option>
              </datalist>
            </div>
          </div>

          <div class="smallpadding_top">
            <label for="compendium_new_summary_fr"><?=__('compendium_page_new_summary_fr')?></label>
            <textarea class="indiv compendium_admin_summary" id="compendium_new_summary_fr" name="compendium_new_summary_fr"><?=$compendium_new_summary_fr?></textarea>
          </div>

          <div class="smallpadding_top">
            <label for="compendium_new_body_fr"><?=__('compendium_page_new_body_fr')?></label>
            <textarea class="indiv compendium_admin_editor" id="compendium_new_body_fr" name="compendium_new_body_fr"><?=$compendium_new_body_fr?></textarea>
          </div>

        </div>
      </div>

      <p class="text_red bold">
        <?=__('compendium_page_new_draft')?>
      </p>

      <?php if(isset($compendium_pages_add)) { ?>
      <div class="smallpadding_top smallpadding_bot">
        <div class="red text_white uppercase bold bigger spaced">
          <?=__('error').__(':', spaces_after: 1).$compendium_pages_add?>
        </div>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <span class="spaced_right">
          <input type="submit" name="compendium_new_preview" value="<?=__('preview')?>">
        </span>
        <input type="submit" name="compendium_new_submit" value="<?=__('compendium_page_new_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php if(isset($_POST['compendium_new_preview'])) { ?>

<?php if($compendium_new_title_en && $compendium_preview_summary_en) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <p class="padding_top">
    <?=__link('#', $compendium_new_title_en, 'big bold noglow forced_link', is_internal: false)?><br>
    <span class=""><?=__('compendium_index_recent_type', spaces_after: 1).__link('#', __('compendium_page_new_preview'), is_internal: false)?></span><br>
    <span class=""><?=__('compendium_index_recent_reworked').__(':', spaces_after: 1).__('compendium_page_new_preview')?></span><br>
    <span class=""><?=__('compendium_index_recent_created').__(':', spaces_after: 1).__('compendium_page_new_preview')?></span>
  </p>

  <p class="tinypadding_top">
    <?=$compendium_preview_summary_en?>
  </p>

</div>

<?php } if($compendium_new_title_fr && $compendium_preview_summary_fr) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <p class="padding_top">
    <?=__link('#', $compendium_new_title_fr, 'big bold noglow forced_link', is_internal: false)?><br>
    <span class=""><?=__('compendium_index_recent_type', spaces_after: 1).__link('#', __('compendium_page_new_preview'), is_internal: false)?></span><br>
    <span class=""><?=__('compendium_index_recent_reworked').__(':', spaces_after: 1).__('compendium_page_new_preview')?></span><br>
    <span class=""><?=__('compendium_index_recent_created').__(':', spaces_after: 1).__('compendium_page_new_preview')?></span>
  </p>

  <p class="tinypadding_top">
    <?=$compendium_preview_summary_fr?>
  </p>

</div>

<?php } if($compendium_new_title_en) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <h1>
    <?=$compendium_new_title_en?>
  </h1>

  <p class="tinypadding_top padding_bot">
    <span class="bold"><?=__('compendium_page_type').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_era').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_category').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_appeared').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_list_peak').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
  </p>

  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase bigger bold">
      <?=__('compendium_page_nsfw')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>

  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase big bold">
      <?=__('compendium_page_offensive')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>

  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase bigger bold">
      <?=__('compendium_page_gross')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>

  <div class="smallpadding_top padding_bot align_justify">
    <?=$compendium_preview_body_en?>
  </div>

  <p class="align_center bigpadding_top">
    <?=__link('#', __('compendium_page_compendium'), is_internal: false)?><br>
    <?=__link('#', __('compendium_page_random_page'), is_internal: false)?>
  </p>

</div>

<?php } if($compendium_new_title_fr) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <h1>
    <?=$compendium_new_title_fr?>
  </h1>

  <p class="tinypadding_top padding_bot">
    <span class="bold"><?=__('compendium_page_type').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_era').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_category').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_appeared').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_list_peak').__(':')?></span>
    <?=__link('#', __('compendium_page_new_preview'), is_internal: false)?>
  </p>

  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase bigger bold">
      <?=__('compendium_page_nsfw')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>

  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase big bold">
      <?=__('compendium_page_offensive')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>

  <div class="flexcontainer align_center padding_top bigpadding_bot">
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
    <div class="compendium_warning_text uppercase bigger bold">
      <?=__('compendium_page_gross')?>
    </div>
    <div class="flex">
      <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', class: 'valign_middle compendium_warning_icon')?>
    </div>
  </div>

  <div class="smallpadding_top padding_bot align_justify">
    <?=$compendium_preview_body_fr?>
  </div>

  <p class="align_center bigpadding_top">
    <?=__link('#', __('compendium_page_compendium'), is_internal: false)?><br>
    <?=__link('#', __('compendium_page_random_page'), is_internal: false)?>
  </p>

</div>

<?php } ?>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }