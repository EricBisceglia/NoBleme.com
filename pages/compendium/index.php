<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/compendium.act.php';    # Actions
include_once './../../lang/compendium.lang.php';      # Translations
include_once './../../inc/bbcodes.inc.php';           # BBCodes
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../inc/functions_numbers.inc.php'; # Number formatting

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/index";
$page_title_en    = "Compendium";
$page_title_fr    = "Compendium";
$page_description = "An encyclopedia of 21st century culture, internet memes, modern slang, and sociocultural concepts";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the page list

$compendium_pages_list = compendium_pages_list( search:     array(  'nsfw'        => 0    ,
                                                                    'gross'       => 0    ,
                                                                    'offensive'   => 0    ,
                                                                    'nsfw_title'  => 0  ) ,
                                                limit:      20                            ,
                                                user_view:  true                          );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_pages_compendium')?>
    <?=__icon('stats', alt: 's', title: string_change_case(__('statistics'), 'initials'), href: "pages/compendium/stats")?>
    <?php if($is_admin) { ?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/page_add')?>
    <?=__icon('settings', alt: 'S', title: __('settings'), title_case: 'initials', href: 'pages/compendium/admin_notes')?>
    <?php } ?>
  </h1>

  <h5>
    <?=__('compendium_index_subitle')?>
  </h5>

  <p>
    <?=__('compendium_index_intro_1')?>
  </p>

  <p>
    <?=__('compendium_index_intro_2')?>
  </p>

  <p>
    <?=__('compendium_index_intro_3')?>
  </p>

  <p>
    <?=__('compendium_index_intro_4')?>
  </p>

  <h3 class="bigpadding_top">
    <?=__('compendium_index_recent_title')?>
  </h3>

  <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

  <p class="bigpadding_top">
    <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['title'], 'big bold noglow forced_link')?>
  </p>

  <p class="tinypadding_top">
    <?php if($compendium_pages_list[$i]['type_id']) { ?>
    <span class=""><?=__('compendium_index_recent_type', spaces_after: 1).__link('pages/compendium/page_type?type='.$compendium_pages_list[$i]['type_id'], $compendium_pages_list[$i]['type'])?></span><br>
    <?php } ?>
    <span class=""><?=string_change_case(__('published', spaces_after: 1), 'initials').$compendium_pages_list[$i]['created']?></span>
    <?php if($compendium_pages_list[$i]['edited']) { ?>
    <br>
    <span class=""><?=__('compendium_index_recent_reworked', spaces_after: 1).$compendium_pages_list[$i]['edited']?></span><br>
    <?php } ?>
  </p>

  <?php if($compendium_pages_list[$i]['summary']) { ?>
  <p class="tinypadding_top">
    <?=$compendium_pages_list[$i]['summary']?>
  </p>
  <?php } ?>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }