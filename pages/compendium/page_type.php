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
// Fetch the page type

// Fetch the page type id
$compendium_type_id = (int)form_fetch_element('type', request_type: 'GET');

// Fetch the page type data
$compendium_type_data = compendium_types_get($compendium_type_id);

// Stop here if the era doesn't exist
if(!$compendium_type_data)
  exit(header("Location: ".$path."pages/compendium/page_type_list"));

// Update the page summary
$page_url         .= "?era=".$compendium_type_id;
$page_title_en    .= $compendium_type_data['full_en_raw'];
$page_title_fr    .= $compendium_type_data['full_fr_raw'];
$page_description .= string_change_case($compendium_type_data['full_en'], 'lowercase')." and its associated memes";

// Fetch the page list
$compendium_pages_list = compendium_pages_list( sort_by:    'title'                                 ,
                                                search:     array( 'type' => $compendium_type_id )  ,
                                                user_view:  true                                    );




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
    <?=__link('pages/compendium/page_type_list', __('compendium_type_subtitle', spaces_after: 1).$compendium_type_data['full'], 'noglow')?>
    <?php if($is_admin) { ?>
    <?=__icon('edit', is_small: true, alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced_left', href: 'pages/compendium/page_type_edit?id='.$compendium_type_id)?>
    <?php } ?>
  </h5>

  <p class="italics tinypadding_top">
    <?=__('compendium_type_summary')?>
  </p>

  <?php if($compendium_type_data['body']) { ?>
  <div class="padding_top align_justify">
    <?=$compendium_type_data['body']?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_type_pages')?>
  </h3>

  <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

  <p class="bigpadding_top">
    <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['title'], 'big bold noglow'.$compendium_pages_list[$i]['blur_link'], onmouseover: 'unblur();')?>
  </p>

  <?php if($compendium_pages_list[$i]['appeared'] || $compendium_pages_list[$i]['peak']) { ?>
  <p class="tinypadding_top">
    <?php if($compendium_pages_list[$i]['appeared']) { ?>
    <?=__('compendium_list_appeared').__(':', spaces_after: 1),$compendium_pages_list[$i]['appeared']?>
    <?php } if($compendium_pages_list[$i]['appeared'] && $compendium_pages_list[$i]['peak'] && $compendium_pages_list[$i]['appeared'] != $compendium_pages_list[$i]['peak']) { ?>
    <br>
    <?php } if($compendium_pages_list[$i]['peak'] && $compendium_pages_list[$i]['appeared'] != $compendium_pages_list[$i]['peak']) { ?>
    <?=__('compendium_list_peak').__(':', spaces_after: 1),$compendium_pages_list[$i]['peak']?>
    <?php } ?>
  </p>
  <?php } ?>

  <?php if($compendium_pages_list[$i]['summary']) { ?>
  <p class="tinypadding_top">
    <?=$compendium_pages_list[$i]['summary']?>
  </p>
  <?php } ?>

  <?php } if(!$i) { ?>

  <p>
    <?=__('compendium_type_empty')?>
  </p>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }