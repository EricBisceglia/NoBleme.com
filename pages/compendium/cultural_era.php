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

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/cultural_era";
$page_title_en    = "Compendium: ";
$page_title_fr    = "Compendium : ";
$page_description = "An encyclopedia of 21st century culture, documenting the ";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the cultural era

// Fetch the era id
$compendium_era_id = (int)form_fetch_element('era', request_type: 'GET');

// Fetch the era data
$compendium_era_data = compendium_eras_get($compendium_era_id);

// Stop here if the era doesn't exist
if(!$compendium_era_data)
  exit(header("Location: ".$path."pages/compendium/cultural_era_list"));

// Update the page summary
$page_url         .= "?era=".$compendium_era_id;
$page_title_en    .= $compendium_era_data['name_en_raw'];
$page_title_fr    .= $compendium_era_data['name_fr_raw'];
$page_description .= string_change_case($compendium_era_data['name_en'], 'lowercase')." and its associated memes";

// Fetch the page list
$compendium_pages_list = compendium_pages_list( sort_by:    'title'                              ,
                                                search:     array( 'era' => $compendium_era_id ) ,
                                                user_view:  true                                 );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/compendium/index', __('compendium_index_title'), 'noglow')?>
  </h1>

  <h5>
    <?=__link('pages/compendium/cultural_era_list', __('compendium_era_subtitle', spaces_after: 1).$compendium_era_data['name'], 'noglow')?>
    <?php if($is_admin) { ?>
    <?=__icon('edit', is_small: true, alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced_left', href: 'pages/compendium/cultural_era_edit?id='.$compendium_era_id)?>
    <?php } ?>
  </h5>

  <p class="italics">
    <?=__('compendium_eras_summary')?>
  </p>

  <p class="italics">
    <?php if($compendium_era_data['start'] && $compendium_era_data['end']) { ?>
    <?=__('compendium_era_years', preset_values: array($compendium_era_data['start'], $compendium_era_data['end']))?>
    <?php } else if(!$compendium_era_data['start']) { ?>
    <?=__('compendium_era_no_start', preset_values: array($compendium_era_data['end']))?>
    <?php } else if(!$compendium_era_data['end']) { ?>
    <?=__('compendium_era_no_end', preset_values: array($compendium_era_data['start']))?>
    <?php } if($compendium_era_data['prev_id']) { ?>
    <br>
    <?=__('compendium_era_previous', spaces_after: 1).__link('pages/compendium/cultural_era?era='.$compendium_era_data['prev_id'], $compendium_era_data['prev_name'], style: '')?>
    <?php } if($compendium_era_data['next_id']) { ?>
    <br>
    <?=__('compendium_era_next', spaces_after: 1).__link('pages/compendium/cultural_era?era='.$compendium_era_data['next_id'], $compendium_era_data['next_name'], style: '')?>
    <?php } ?>
  </p>

  <?php if($compendium_era_data['body']) { ?>
  <div class="padding_top align_justify">
    <?=$compendium_era_data['body']?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_era_pages')?>
  </h3>

  <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

  <p class="bigpadding_top">
    <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['title'], 'big bold noglow'.$compendium_pages_list[$i]['blur_link'], onmouseover: 'unblur();')?>
  </p>

  <p class="tinypadding_top">
    <?php if($compendium_pages_list[$i]['type']) { ?>
    <span class=""><?=__('compendium_index_recent_type', spaces_after: 1).__link('pages/compendium/page_type?type='.$compendium_pages_list[$i]['type_id'], $compendium_pages_list[$i]['type'])?></span><br>
    <?php } if($compendium_pages_list[$i]['appeared']) { ?>
    <?=__('compendium_list_appeared').__(':', spaces_after: 1),$compendium_pages_list[$i]['appeared']?>
    <?php } if($compendium_pages_list[$i]['appeared'] && $compendium_pages_list[$i]['peak'] && $compendium_pages_list[$i]['appeared'] != $compendium_pages_list[$i]['peak']) { ?>
    <br>
    <?php } if($compendium_pages_list[$i]['peak'] && $compendium_pages_list[$i]['appeared'] != $compendium_pages_list[$i]['peak']) { ?>
    <?=__('compendium_list_peak').__(':', spaces_after: 1),$compendium_pages_list[$i]['peak']?>
    <?php } ?>
  </p>

  <?php if($compendium_pages_list[$i]['summary']) { ?>
  <p class="tinypadding_top">
    <?=$compendium_pages_list[$i]['summary']?>
  </p>
  <?php } ?>

  <?php } if(!$i) { ?>

  <p>
    <?=__('compendium_era_empty')?>
  </p>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }