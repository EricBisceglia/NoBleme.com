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
$page_url         = "pages/compendium/page_edit";
$page_title_en    = "Compendium: Edit page";
$page_title_fr    = "Compendium : Modifier une page";

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page contents

// Fetch the page's id
$compendium_page_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the page's data
$compendium_page_data = compendium_pages_get( page_id:  $compendium_page_id ,
                                              no_loops: false               );

// Redirect if the page doesn't exist
if(!$compendium_page_data)
  exit(header('Location: '.$path.'pages/compendium/page_list_admin'));

// Prepare the form values
$compendium_edit_url          = $compendium_page_data['url'];
$compendium_edit_title_en     = $compendium_page_data['title_en'];
$compendium_edit_title_fr     = $compendium_page_data['title_fr'];
$compendium_edit_redirect_en  = $compendium_page_data['redir_en'];
$compendium_edit_redirect_fr  = $compendium_page_data['redir_fr'];
$compendium_edit_redirect_ext = $compendium_page_data['redir_ext'];
$compendium_edit_summary_en   = $compendium_page_data['summary_en'];
$compendium_edit_summary_fr   = $compendium_page_data['summary_fr'];
$compendium_edit_body_en      = $compendium_page_data['body_en'];
$compendium_edit_body_fr      = $compendium_page_data['body_fr'];
$compendium_edit_type         = $compendium_page_data['type_id'];
$compendium_edit_era          = $compendium_page_data['era_id'];
$compendium_edit_appear_month = $compendium_page_data['app_month'];
$compendium_edit_appear_year  = ($compendium_page_data['app_year']) ? $compendium_page_data['app_year'] : '';
$compendium_edit_peak_month   = $compendium_page_data['peak_month'];
$compendium_edit_peak_year    = ($compendium_page_data['peak_year']) ? $compendium_page_data['peak_year'] : '';
$compendium_edit_nsfw_title   = $compendium_page_data['nsfw_title'];
$compendium_edit_nsfw         = $compendium_page_data['nsfw'];
$compendium_edit_gross        = $compendium_page_data['gross'];
$compendium_edit_offensive    = $compendium_page_data['offensive'];
$compendium_edit_admin_notes  = $compendium_page_data['admin_note'];
$compendium_edit_admin_urls   = $compendium_page_data['admin_urls'];
$compendium_edit_history_en   = "";
$compendium_edit_history_fr   = "";
$compendium_edit_silent       = false;
$compendium_edit_major        = false;
$compendium_edit_activity     = false;
$compendium_edit_irc          = false;
$compendium_edit_discord      = false;

// Fetch the categories list
$compendium_categories_list = compendium_categories_list();

// Prepare the page categories
$compendium_page_categories = ($compendium_page_data['categories']) ? $compendium_page_data['category_id'] : array();
for($i = 0; $i < $compendium_categories_list['rows']; $i++)
  $compendium_edit_category[$compendium_categories_list[$i]['id']] = in_array($compendium_categories_list[$i]['id'], $compendium_page_categories);

// Update the form values if submitted
if(isset($_POST['compendium_edit_preview']) || isset($_POST['compendium_edit_submit']))
{
  $compendium_edit_url          = compendium_format_url(form_fetch_element('compendium_edit_url'));
  $compendium_edit_title_en     = compendium_format_title(form_fetch_element('compendium_edit_title_en'));
  $compendium_edit_title_fr     = compendium_format_title(form_fetch_element('compendium_edit_title_fr'));
  $compendium_edit_redirect_en  = form_fetch_element('compendium_edit_redirect_en');
  $compendium_edit_redirect_fr  = form_fetch_element('compendium_edit_redirect_fr');
  $compendium_edit_redirect_ext = form_fetch_element('compendium_edit_redirect_ext', element_exists: true);
  $compendium_edit_summary_en   = form_fetch_element('compendium_edit_summary_en');
  $compendium_edit_summary_fr   = form_fetch_element('compendium_edit_summary_fr');
  $compendium_edit_body_en      = form_fetch_element('compendium_edit_body_en');
  $compendium_edit_body_fr      = form_fetch_element('compendium_edit_body_fr');
  $compendium_edit_type         = form_fetch_element('compendium_edit_type');
  $compendium_edit_era          = form_fetch_element('compendium_edit_era');
  $compendium_edit_appear_month = form_fetch_element('compendium_edit_appear_month');
  $compendium_edit_appear_year  = form_fetch_element('compendium_edit_appear_year');
  $compendium_edit_peak_month   = form_fetch_element('compendium_edit_peak_month');
  $compendium_edit_peak_year    = form_fetch_element('compendium_edit_peak_year');
  $compendium_edit_nsfw_title   = form_fetch_element('compendium_edit_nsfw_title', element_exists: true);
  $compendium_edit_nsfw         = form_fetch_element('compendium_edit_nsfw', element_exists: true);
  $compendium_edit_gross        = form_fetch_element('compendium_edit_gross', element_exists: true);
  $compendium_edit_offensive    = form_fetch_element('compendium_edit_offensive', element_exists: true);
  $compendium_edit_admin_notes  = form_fetch_element('compendium_edit_admin_notes');
  $compendium_edit_admin_urls   = form_fetch_element('compendium_edit_admin_urls');
  $compendium_edit_history_en   = form_fetch_element('compendium_edit_history_en');
  $compendium_edit_history_fr   = form_fetch_element('compendium_edit_history_fr');
  $compendium_edit_silent       = form_fetch_element('compendium_edit_silent', element_exists: true);
  $compendium_edit_major        = form_fetch_element('compendium_edit_major', element_exists: true);
  $compendium_edit_activity     = form_fetch_element('compendium_edit_activity', element_exists: true);
  $compendium_edit_irc          = form_fetch_element('compendium_edit_irc', element_exists: true);
  $compendium_edit_discord      = form_fetch_element('compendium_edit_discord', element_exists: true);

  // Format redirections if they point towards a compendium page
  if(!$compendium_edit_redirect_ext)
  {
    $compendium_edit_redirect_en  = compendium_format_url($compendium_edit_redirect_en);
    $compendium_edit_redirect_fr  = compendium_format_url($compendium_edit_redirect_fr);
  }

  // Update the selected categories aswell
  for($i = 0; $i < $compendium_categories_list['rows']; $i++)
  $compendium_edit_category[$compendium_categories_list[$i]['id']] = form_fetch_element('compendium_edit_category_'.$compendium_categories_list[$i]['id'], element_exists: true);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit the page

// Attempt to edit the page if requested
if(isset($_POST['compendium_edit_submit']))
{
  // Assemble the page data
  $compendium_edit_data = array(  'url'           => $compendium_edit_url           ,
                                  'title_en'      => $compendium_edit_title_en      ,
                                  'title_fr'      => $compendium_edit_title_fr      ,
                                  'redirect_en'   => $compendium_edit_redirect_en   ,
                                  'redirect_fr'   => $compendium_edit_redirect_fr   ,
                                  'redirect_ext'  => $compendium_edit_redirect_ext  ,
                                  'summary_en'    => $compendium_edit_summary_en    ,
                                  'summary_fr'    => $compendium_edit_summary_fr    ,
                                  'body_en'       => $compendium_edit_body_en       ,
                                  'body_fr'       => $compendium_edit_body_fr       ,
                                  'type'          => $compendium_edit_type          ,
                                  'era'           => $compendium_edit_era           ,
                                  'appear_month'  => $compendium_edit_appear_month  ,
                                  'appear_year'   => $compendium_edit_appear_year   ,
                                  'peak_month'    => $compendium_edit_peak_month    ,
                                  'peak_year'     => $compendium_edit_peak_year     ,
                                  'nsfw_title'    => $compendium_edit_nsfw_title    ,
                                  'nsfw'          => $compendium_edit_nsfw          ,
                                  'gross'         => $compendium_edit_gross         ,
                                  'offensive'     => $compendium_edit_offensive     ,
                                  'admin_notes'   => $compendium_edit_admin_notes   ,
                                  'admin_urls'    => $compendium_edit_admin_urls    ,
                                  'history_en'    => $compendium_edit_history_en    ,
                                  'history_fr'    => $compendium_edit_history_fr    ,
                                  'silent'        => $compendium_edit_silent        ,
                                  'major'         => $compendium_edit_major         ,
                                  'activity'      => $compendium_edit_activity      ,
                                  'irc'           => $compendium_edit_irc           ,
                                  'discord'       => $compendium_edit_activity      );

  // Add category data to the page data
  for($i = 0; $i < $compendium_categories_list['rows']; $i++)
    $compendium_edit_data['category_'.$compendium_categories_list[$i]['id']] = $compendium_edit_category[$compendium_categories_list[$i]['id']];

  // Edit the page
  $compendium_pages_edit = compendium_pages_edit( $compendium_page_id   ,
                                                  $compendium_edit_data );

  // Redirect if it was properly edited
  if(is_null($compendium_pages_edit))
    exit(header("Location: ".$path."pages/compendium/".$compendium_edit_url));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Preview

// Prepare the preview data
if(isset($_POST['compendium_edit_preview']))
{
  $compendium_preview_summary_en  = compendium_nbcodes_apply($compendium_edit_summary_en);
  $compendium_preview_summary_fr  = compendium_nbcodes_apply($compendium_edit_summary_fr);
  $compendium_preview_body_en     = compendium_nbcodes_apply($compendium_edit_body_en);
  $compendium_preview_body_fr     = compendium_nbcodes_apply($compendium_edit_body_fr);
}

// Prepare the form values for displaying
if(isset($_POST['compendium_edit_preview']) || isset($_POST['compendium_edit_submit']))
{
  $compendium_edit_url          = sanitize_output($compendium_edit_url);
  $compendium_edit_title_en     = sanitize_output($compendium_edit_title_en);
  $compendium_edit_title_fr     = sanitize_output($compendium_edit_title_fr);
  $compendium_edit_redirect_en  = sanitize_output($compendium_edit_redirect_en);
  $compendium_edit_redirect_fr  = sanitize_output($compendium_edit_redirect_fr);
  $compendium_edit_summary_en   = sanitize_output($compendium_edit_summary_en);
  $compendium_edit_summary_fr   = sanitize_output($compendium_edit_summary_fr);
  $compendium_edit_body_en      = sanitize_output($compendium_edit_body_en);
  $compendium_edit_body_fr      = sanitize_output($compendium_edit_body_fr);
  $compendium_edit_era          = sanitize_output($compendium_edit_era);
  $compendium_edit_appear_year  = sanitize_output($compendium_edit_appear_year);
  $compendium_edit_peak_year    = sanitize_output($compendium_edit_peak_year);
  $compendium_edit_admin_notes  = sanitize_output($compendium_edit_admin_notes);
  $compendium_edit_admin_urls   = sanitize_output($compendium_edit_admin_urls);
  $compendium_edit_history_en   = sanitize_output($compendium_edit_history_en);
  $compendium_edit_history_fr   = sanitize_output($compendium_edit_history_fr);
}

// Fetch the page types list
$compendium_types_list = compendium_types_list();

// Keep the proper page type selected
for($i = 0; $i < $compendium_types_list['rows']; $i++)
  $compendium_edit_type_select[$i] = ($compendium_edit_type === $compendium_types_list[$i]['id']) ? ' selected' : '';

// Fetch the era list
$compendium_eras_list = compendium_eras_list();

// Keep the proper era selected
for($i = 0; $i < $compendium_eras_list['rows']; $i++)
  $compendium_edit_era_select[$i] = ($compendium_edit_era === $compendium_eras_list[$i]['id']) ? ' selected' : '';

// Keep the proper appearance and peak entries selected
for($i = 1; $i <= 12; $i++)
  $compendium_edit_appear_month_select[$i] = ($compendium_edit_appear_month === $i)  ? ' selected' : '';
for($i = 1; $i <= 12; $i++)
  $compendium_edit_peak_month_select[$i]   = ($compendium_edit_peak_month === $i)    ? ' selected' : '';

// Keep the proper categories checked
for($i = 0; $i < $compendium_categories_list['rows']; $i++)
$compendium_edit_category_checkbox[$i] = ($compendium_edit_category[$compendium_categories_list[$i]['id']] === $compendium_categories_list[$i]['id']) ? ' checked' : '';

// Keep the proper checkboxes checked
$compendium_edit_redirect_ext_checkbox  = ($compendium_edit_redirect_ext) ? ' checked' : '';
$compendium_edit_nsfw_title_checkbox    = ($compendium_edit_nsfw_title)   ? ' checked' : '';
$compendium_edit_nsfw_checkbox          = ($compendium_edit_nsfw)         ? ' checked' : '';
$compendium_edit_gross_checkbox         = ($compendium_edit_gross)        ? ' checked' : '';
$compendium_edit_offensive_checkbox     = ($compendium_edit_offensive)    ? ' checked' : '';
$compendium_edit_silent_checkbox        = ($compendium_edit_silent)       ? ' checked' : '';
$compendium_edit_major_checkbox         = ($compendium_edit_major)        ? ' checked' : '';
$compendium_edit_activity_checkbox      = ($compendium_edit_activity)     ? ' checked' : '';
$compendium_edit_irc_checkbox           = ($compendium_edit_irc)          ? ' checked' : '';
$compendium_edit_discord_checkbox       = ($compendium_edit_discord)      ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1 class="align_center bigpadding_bot">
    <?=__link('pages/compendium/'.$compendium_page_data['url'], __('compendium_page_edit_title'), 'noglow')?>
    <?=__icon('image', alt: 'P', title: __('image'), title_case: 'initials', href: 'pages/compendium/image_admin', popup: true)?>
  </h1>

  <?php if(isset($compendium_pages_edit)) { ?>
  <div class="padding_bot">
    <div class="red text_white uppercase bold bigger spaced">
      <?=__('error').__(':', spaces_after: 1).$compendium_pages_edit?>
    </div>
  </div>
  <?php } ?>

  <form method="POST">
    <fieldset>

      <label for="compendium_edit_url"><?=__('compendium_page_new_url')?></label>
      <input type="text" class="indiv" id="compendium_edit_url" name="compendium_edit_url" value="<?=$compendium_edit_url?>" autocomplete="off" list="compendium_url_list" onkeyup="compendium_autocomplete_url('compendium_edit_url', 'compendium_url_list_parent', 'compendium_url_list');">
      <div id="compendium_url_list_parent">
        <datalist id="compendium_url_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <div class="flexcontainer smallpadding_top">
        <div class="flex spaced_right">

          <label for="compendium_edit_title_en"><?=__('compendium_page_new_title_en')?></label>
          <input type="text" class="indiv" id="compendium_edit_title_en" name="compendium_edit_title_en" value="<?=$compendium_edit_title_en?>">

          <div class="smallpadding_top">
            <label for="compendium_edit_redirect_en"><?=__('compendium_page_new_redirect_en')?></label>
            <input type="text" class="indiv" id="compendium_edit_redirect_en" name="compendium_edit_redirect_en" value="<?=$compendium_edit_redirect_en?>" autocomplete="off" list="compendium_redirect_en_list" onkeyup="compendium_autocomplete_url('compendium_edit_redirect_en', 'compendium_redirect_en_list_parent', 'compendium_redirect_en_list', true);">
            <div id="compendium_redirect_en_list_parent">
              <datalist id="compendium_redirect_en_list">
                <option value=" ">&nbsp;</option>
              </datalist>
            </div>
          </div>

        </div>
        <div class="flex spaced_left">

        <label for="compendium_edit_title_fr"><?=__('compendium_page_new_title_fr')?></label>
          <input type="text" class="indiv" id="compendium_edit_title_fr" name="compendium_edit_title_fr" value="<?=$compendium_edit_title_fr?>">

          <div class="smallpadding_top">
            <label for="compendium_edit_redirect_fr"><?=__('compendium_page_new_redirect_fr')?></label>
            <input type="text" class="indiv" id="compendium_edit_redirect_fr" name="compendium_edit_redirect_fr" value="<?=$compendium_edit_redirect_fr?>" autocomplete="off" list="compendium_redirect_fr_list" onkeyup="compendium_autocomplete_url('compendium_edit_redirect_fr', 'compendium_redirect_fr_list_parent', 'compendium_redirect_fr_list', true);">
            <div id="compendium_redirect_fr_list_parent">
              <datalist id="compendium_redirect_fr_list">
                <option value=" ">&nbsp;</option>
              </datalist>
            </div>
          </div>

        </div>
      </div>

      <div class="smallpadding_top">
        <input type="checkbox" id="compendium_edit_redirect_ext" name="compendium_edit_redirect_ext"<?=$compendium_edit_redirect_ext_checkbox?>>
        <label class="label_inline" for="compendium_edit_redirect_ext"><?=__('compendium_page_new_redirect_ext')?></label><br>
      </div>

      <div class="flexcontainer ">
        <div class="flex spaced_right">

          <div class="smallpadding_top">
            <label for="compendium_edit_summary_en"><?=__('compendium_page_new_summary_en')?></label>
            <textarea class="indiv compendium_admin_summary" id="compendium_edit_summary_en" name="compendium_edit_summary_en"><?=$compendium_edit_summary_en?></textarea>
          </div>

          <div class="smallpadding_top">
            <label for="compendium_edit_body_en"><?=__('compendium_page_new_body_en')?></label>
            <textarea class="indiv compendium_admin_editor" id="compendium_edit_body_en" name="compendium_edit_body_en"><?=$compendium_edit_body_en?></textarea>
          </div>

        </div>
        <div class="flex spaced_left">

          <div class="smallpadding_top">
            <label for="compendium_edit_summary_fr"><?=__('compendium_page_new_summary_fr')?></label>
            <textarea class="indiv compendium_admin_summary" id="compendium_edit_summary_fr" name="compendium_edit_summary_fr"><?=$compendium_edit_summary_fr?></textarea>
          </div>

          <div class="smallpadding_top">
            <label for="compendium_edit_body_fr"><?=__('compendium_page_new_body_fr')?></label>
            <textarea class="indiv compendium_admin_editor" id="compendium_edit_body_fr" name="compendium_edit_body_fr"><?=$compendium_edit_body_fr?></textarea>
          </div>

        </div>
      </div>

      <div class="smallpadding_top">
        <label for="compendium_edit_type"><?=__('compendium_page_new_type')?></label>
        <select class="indiv align_left" id="compendium_edit_type" name="compendium_edit_type">
          <option value="0">&nbsp;</option>
          <?php for($i = 0; $i < $compendium_types_list['rows']; $i++) { ?>
          <option value="<?=$compendium_types_list[$i]['id']?>"<?=$compendium_edit_type_select[$i]?>>
            <?=$compendium_types_list[$i]['name']?>
          </option>
          <?php } ?>
        </select>
      </div>

      <div class="smallpadding_top">
        <label for="compendium_edit_era"><?=__('compendium_page_new_era')?></label>
        <select class="indiv align_left" id="compendium_edit_era" name="compendium_edit_era">
          <option value="0" selected>&nbsp;</option>
          <?php for($i = 0; $i < $compendium_eras_list['rows']; $i++) { ?>
          <option value="<?=$compendium_eras_list[$i]['id']?>"<?=$compendium_edit_era_select[$i]?>>
            [<?=$compendium_eras_list[$i]['startx']?> - <?=$compendium_eras_list[$i]['endx']?>] <?=$compendium_eras_list[$i]['name']?>
          </option>
          <?php } ?>
        </select>
      </div>

      <div class="flexcontainer smallpadding_top tinypadding_bot">
        <div class="flex spaced_right">

          <label for="compendium_edit_appear_month"><?=__('compendium_page_new_appear_month')?></label>
          <select class="indiv align_left" id="compendium_edit_appear_month" name="compendium_edit_appear_month">
            <option value="0">&nbsp;</option>
            <?php for($i = 1; $i <= 12; $i++) { ?>
            <option value="<?=$i?>"<?=$compendium_edit_appear_month_select[$i]?>><?=__('month_'.$i)?></option>
            <?php } ?>
          </select>

          <div class="smallpadding_top">
            <label for="compendium_edit_appear_year"><?=__('compendium_page_new_appear_year')?></label>
            <input type="text" class="indiv" id="compendium_edit_appear_year" name="compendium_edit_appear_year" value="<?=$compendium_edit_appear_year?>">
          </div>

        </div>
        <div class="flex spaced_left">

          <label for="compendium_edit_peak_month"><?=__('compendium_page_new_peak_month')?></label>
          <select class="indiv align_left" id="compendium_edit_peak_month" name="compendium_edit_peak_month">
            <option value="0" selected>&nbsp;</option>
            <?php for($i = 1; $i <= 12; $i++) { ?>
            <option value="<?=$i?>"<?=$compendium_edit_peak_month_select[$i]?>><?=__('month_'.$i)?></option>
            <?php } ?>
          </select>

          <div class="smallpadding_top">
            <label for="compendium_edit_peak_year"><?=__('compendium_page_new_peak_year')?></label>
            <input type="text" class="indiv" id="compendium_edit_peak_year" name="compendium_edit_peak_year" value="<?=$compendium_edit_peak_year?>">
          </div>

        </div>
      </div>

      <div class="smallpadding_top">
        <label><?=__('compendium_page_new_categories')?></label>
      </div>

      <?php for($i = 0; $i < $compendium_categories_list['rows']; $i++) { ?>
      <input type="checkbox" id="compendium_edit_category_<?=$compendium_categories_list[$i]['id']?>" name="compendium_edit_category_<?=$compendium_categories_list[$i]['id']?>"<?=$compendium_edit_category_checkbox[$i]?>>
      <label class="label_inline" for="compendium_edit_category_<?=$compendium_categories_list[$i]['id']?>"><?=__link('pages/compendium/category?id='.$compendium_categories_list[$i]['id'], $compendium_categories_list[$i]['name'], popup: true)?></label><br>
      <?php } ?>

      <div class="smallpadding_top">
        <label><?=__('compendium_page_new_nsfw_section')?></label>
      </div>

      <input type="checkbox" id="compendium_edit_nsfw_title" name="compendium_edit_nsfw_title"<?=$compendium_edit_nsfw_title_checkbox?>>
      <label class="label_inline" for="compendium_edit_nsfw_title"><?=__('compendium_page_new_nsfw_title')?></label><br>

      <input type="checkbox" id="compendium_edit_nsfw" name="compendium_edit_nsfw"<?=$compendium_edit_nsfw_checkbox?>>
      <label class="label_inline" for="compendium_edit_nsfw"><?=__('compendium_page_new_nsfw')?></label><br>

      <input type="checkbox" id="compendium_edit_offensive" name="compendium_edit_offensive"<?=$compendium_edit_offensive_checkbox?>>
      <label class="label_inline" for="compendium_edit_offensive"><?=__('compendium_page_new_offensive')?></label><br>

      <input type="checkbox" id="compendium_edit_gross" name="compendium_edit_gross"<?=$compendium_edit_gross_checkbox?>>
      <label class="label_inline" for="compendium_edit_gross"><?=__('compendium_page_new_gross')?></label>

      <div class="smallpadding_top">
        <label for="compendium_edit_admin_notes"><?=__('compendium_pages_new_admin_notes')?></label>
        <textarea class="indiv compendium_admin_summary" id="compendium_edit_admin_notes" name="compendium_edit_admin_notes"><?=$compendium_edit_admin_notes?></textarea>
      </div>

      <div class="smallpadding_top smallpadding_bot">
        <label for="compendium_edit_admin_urls"><?=__('compendium_pages_new_admin_urls')?></label>
        <textarea class="indiv compendium_admin_urls" id="compendium_edit_admin_urls" name="compendium_edit_admin_urls"><?=$compendium_edit_admin_urls?></textarea>
      </div>

      <?php if(!$compendium_edit_redirect_en && !$compendium_edit_redirect_fr && !$compendium_page_data['deleted'] && !$compendium_page_data['draft']) { ?>

      <div id="compendium_edit_history_descriptions">

        <div class="smallpadding_bot">
          <label for="compendium_edit_history_en"><?=__('compendium_page_edit_history_en')?></label>
          <input type="text" class="indiv" id="compendium_edit_history_en" name="compendium_edit_history_en" value="<?=$compendium_edit_history_en?>">
        </div>

        <div class="smallpadding_bot">
          <label for="compendium_edit_history_fr"><?=__('compendium_page_edit_history_fr')?></label>
          <input type="text" class="indiv" id="compendium_edit_history_fr" name="compendium_edit_history_fr" value="<?=$compendium_edit_history_fr?>">
        </div>

      </div>

      <input type="checkbox" id="compendium_edit_silent" name="compendium_edit_silent"<?=$compendium_edit_silent_checkbox?> onclick="compendium_edit_toggle_history()">
      <label class="label_inline" for="compendium_edit_silent"><?=__('compendium_page_edit_silent')?></label><br>

      <div id="compendium_edit_history_checkboxes">

        <input type="checkbox" id="compendium_edit_major" name="compendium_edit_major"<?=$compendium_edit_major_checkbox?> onclick="compendium_edit_toggle_major()">
        <label class="label_inline" for="compendium_edit_major"><?=__('compendium_page_edit_major')?></label><br>

        <div id="compendium_edit_history_major" class="hidden">

          <input type="checkbox" id="compendium_edit_activity" name="compendium_edit_activity"<?=$compendium_edit_activity_checkbox?>>
          <label class="label_inline" for="compendium_edit_activity"><?=__('compendium_page_draft_activity')?></label><br>

          <input type="checkbox" id="compendium_edit_irc" name="compendium_edit_irc"<?=$compendium_edit_irc_checkbox?>>
          <label class="label_inline" for="compendium_edit_irc"><?=__('compendium_page_draft_irc')?></label><br>

          <input type="checkbox" id="compendium_edit_discord" name="compendium_edit_discord"<?=$compendium_edit_discord_checkbox?>>
          <label class="label_inline" for="compendium_edit_discord"><?=__('compendium_page_draft_discord')?></label>

        </div>

      </div>

      <?php } ?>

      <div class="smallpadding_top">
        <span class="spaced_right">
          <input type="submit" name="compendium_edit_preview" value="<?=__('preview')?>">
        </span>
        <input type="submit" name="compendium_edit_submit" value="<?=__('compendium_page_edit_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php if(isset($_POST['compendium_edit_preview'])) { ?>

<?php if($compendium_edit_title_en && $compendium_preview_summary_en) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <p class="padding_top">
    <?=__link('#', $compendium_edit_title_en, 'big bold noglow forced_link', is_internal: false)?><br>
    <span class=""><?=__('compendium_index_recent_type', spaces_after: 1).__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?></span><br>
    <span class=""><?=__('compendium_index_recent_reworked').__(':', spaces_after: 1).string_change_case(__('preview_2'), 'initials')?></span><br>
    <span class=""><?=string_change_case(__('published', spaces_after: 1), 'initials').__(':', spaces_after: 1).string_change_case(__('preview_2'), 'initials')?></span>
  </p>

  <p class="tinypadding_top">
    <?=$compendium_preview_summary_en?>
  </p>

</div>

<?php } if($compendium_edit_title_fr && $compendium_preview_summary_fr) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <p class="padding_top">
    <?=__link('#', $compendium_edit_title_fr, 'big bold noglow forced_link', is_internal: false)?><br>
    <span class=""><?=__('compendium_index_recent_type', spaces_after: 1).__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?></span><br>
    <span class=""><?=__('compendium_index_recent_reworked').__(':', spaces_after: 1).string_change_case(__('preview_2'), 'initials')?></span><br>
    <span class=""><?=string_change_case(__('published', spaces_after: 1), 'initials').__(':', spaces_after: 1).string_change_case(__('preview_2'), 'initials')?></span>
  </p>

  <p class="tinypadding_top">
    <?=$compendium_preview_summary_fr?>
  </p>

</div>

<?php } if($compendium_edit_title_en) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <h1>
    <?=$compendium_edit_title_en?>
  </h1>

  <p class="tinypadding_top padding_bot">
    <span class="bold"><?=__('compendium_page_type').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_era').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=string_change_case(__('category'), 'initials').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_appeared').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_list_peak').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
  </p>

  <?php if($compendium_edit_nsfw) { ?>
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

  <?php } if($compendium_edit_offensive) { ?>
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

  <?php } if($compendium_edit_gross) { ?>
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
  <?php } ?>

  <div class="smallpadding_top align_justify">
    <?=$compendium_preview_body_en?>
  </div>

  <p class="align_center hugepadding_top bigpadding_bot">
    <?=__link('#', __('compendium_page_copyright', preset_values: array(date('Y'))), style: 'hugeglow_dark')?><br>
    <?=__link('#', __('compendium_page_compendium'), is_internal: false, style: 'hugeglow_dark')?><br>
    <?=__link('#', __('compendium_page_random_page'), is_internal: false, style: 'hugeglow_dark')?>
  </p>

</div>

<?php } if($compendium_edit_title_fr) { ?>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <h1>
    <?=$compendium_edit_title_fr?>
  </h1>

  <p class="tinypadding_top padding_bot">
    <span class="bold"><?=__('compendium_page_type').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_era').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=string_change_case(__('category'), 'initials').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_page_appeared').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
    <br>
    <span class="bold"><?=__('compendium_list_peak').__(':')?></span>
    <?=__link('#', string_change_case(__('preview_2'), 'initials'), is_internal: false)?>
  </p>

  <?php if($compendium_edit_nsfw) { ?>
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

  <?php } if($compendium_edit_offensive) { ?>
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

  <?php } if($compendium_edit_gross) { ?>
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
  <?php } ?>

  <div class="smallpadding_top align_justify">
    <?=$compendium_preview_body_fr?>
  </div>

  <p class="align_center hugepadding_top bigpadding_bot">
    <?=__link('#', __('compendium_page_copyright', preset_values: array(date('Y'))), style: 'hugeglow_dark')?><br>
    <?=__link('#', __('compendium_page_compendium'), is_internal: false, style: 'hugeglow_dark')?><br>
    <?=__link('#', __('compendium_page_random_page'), is_internal: false, style: 'hugeglow_dark')?>
  </p>

</div>

<?php } ?>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }