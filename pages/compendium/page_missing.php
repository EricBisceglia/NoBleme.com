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
$page_url         = "pages/compendium/page_missing";
$page_title_en    = "Compendium: Missing page";
$page_title_fr    = "Compendium : Page manquante";
$page_description = "An encyclopedia of 21st century culture, documenting the ";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the missing page data

// Fetch the id or the url
$compendium_missing_page_id   = (int)form_fetch_element('id', request_type: 'GET');
$compendium_missing_page_url  = (string)form_fetch_element('url', request_type: 'GET');

// Fetch the missing page data
$compendium_missing_data = compendium_missing_get(  $compendium_missing_page_id   ,
                                                    $compendium_missing_page_url  );

// Stop here if the missing page doesn't exist
if(!$compendium_missing_data)
  exit(header("Location: ".$path."pages/compendium/page_missing_list"));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_90 bigpadding_bot">

  <h1 class="align_center">
    <?=__link('pages/compendium/page_missing_list', __('compendium_missing_page_title'), 'noglow')?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/page_add?url='.$compendium_missing_data['url'])?>
    <?php if($compendium_missing_data['id']) { ?>
    <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', href: 'pages/compendium/page_missing_edit?id='.$compendium_missing_data['id'])?>
    <?php } else { ?>
    <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', href: 'pages/compendium/page_missing_edit?url='.$compendium_missing_data['url'])?>
    <?php } ?>
  </h1>

  <h4 class="align_center smallpadding_top">
    <?=__link('pages/compendium/page_add?url='.$compendium_missing_data['url'], $compendium_missing_data['url'], 'noglow')?>
  </h4>

  <?php if($compendium_missing_data['title']) { ?>
  <h4 class="align_center smallpadding_top">
    <?=__link('pages/compendium/page_add?url='.$compendium_missing_data['url'], $compendium_missing_data['title'], 'noglow')?>
  </h4>
  <?php } ?>

</div>

<div class="width_50">

  <?php if($compendium_missing_data['body']) { ?>
  <p class="align_justify padding_bot">
    <?=$compendium_missing_data['body']?>
  </p>
  <?php } ?>

  <?php if(!$compendium_missing_data['count']) { ?>
  <p class="align_center big bold">
    <?=__('compendium_missing_page_none')?>
  </p>
  <?php } else { ?>
  <div>
    <p class="smallpadding_bot">
      <?=__('compendium_missing_page_links')?>
    </p>
    <ul>
      <?php for($i = 0; $i < $compendium_missing_data['count_pages']; $i++) { ?>
      <li> <?=__link('pages/compendium/'.$compendium_missing_data[$i]['page_url'], $compendium_missing_data[$i]['page_title'])?></li>
      <?php } for($i = 0; $i < $compendium_missing_data['count_images']; $i++) { ?>
      <li> <?=__link('pages/compendium/image?name='.$compendium_missing_data[$i]['image_name'], $compendium_missing_data[$i]['image_name'])?></li>
      <?php } ?>
    </ul>
  </div>
  <?php } ?>

</div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }