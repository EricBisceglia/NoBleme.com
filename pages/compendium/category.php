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
$page_url         = "pages/compendium/category";
$page_title_en    = "Compendium: ";
$page_title_fr    = "Compendium : ";
$page_description = "Pages categorized as being ";

// Temporarily closed
if(!$is_admin)
  exit(header("Location: ".$path."pages/compendium/index_closed"));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the category

// Fetch the category id
$compendium_category_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the category data
$compendium_category_data = compendium_categories_get($compendium_category_id);

// Stop here if the category doesn't exist
if(!$compendium_category_data)
  exit(header("Location: ".$path."pages/compendium/category_list"));

// Update the page summary
$page_url         .= "?id=".$compendium_category_id;
$page_title_en    .= $compendium_category_data['name_en_raw'];
$page_title_fr    .= $compendium_category_data['name_fr_raw'];
$page_description .= string_change_case($compendium_category_data['name_en'], 'lowercase')." in NoBleme's encyclopedia of 21st century culture";

// Fetch the page list
$compendium_pages_list = compendium_pages_list( sort_by:    'title'                                         ,
                                                search:     array( 'category' => $compendium_category_id )  ,
                                                user_view:  true                                            );




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
    <?=__link('pages/compendium/category_list', __('compendium_category_subtitle', spaces_after: 1).$compendium_category_data['name'], 'noglow')?>
    <?php if($is_admin) { ?>
    <?=__icon('edit', is_small: true, alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced_left', href: 'pages/compendium/category_edit?id='.$compendium_category_id)?>
    <?php } ?>
  </h5>

  <p class="italics">
    <?=__('compendium_category_summary')?>
  </p>

  <?php if($compendium_category_data['body']) { ?>
  <div class="padding_top">
    <?=$compendium_category_data['body']?>
  </div>
  <?php } ?>

  <h3 class="bigpadding_top">
    <?=__('compendium_category_pages')?>
  </h3>

  <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

  <p class="padding_top">
    <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['title'], 'big bold noglow'.$compendium_pages_list[$i]['blur_link'])?><br>
    <span class=""><?=__('compendium_index_recent_type', spaces_after: 1).__link('pages/compendium/page_type?type='.$compendium_pages_list[$i]['type_id'], $compendium_pages_list[$i]['type'])?></span><br>
  </p>

  <?php if($compendium_pages_list[$i]['summary']) { ?>
  <p class="tinypadding_top">
    <?=$compendium_pages_list[$i]['summary']?>
  </p>
  <?php } ?>

  <?php } if(!$i) { ?>

  <p>
    <?=__('compendium_category_empty')?>
  </p>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }