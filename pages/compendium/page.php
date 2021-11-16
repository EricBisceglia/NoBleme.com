<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/functions_time.inc.php';  # Core
include_once './../../inc/bbcodes.inc.php';         # Core


// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/";
$page_title_en    = "";
$page_title_fr    = "";
$page_description = "An encyclopedia of 21st century culture, internet memes, modern slang, and sociocultural concepts";

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/page');



/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page contents

// Fetch the page's url
$compendium_page_url = (string)form_fetch_element('page', request_type: 'GET');

// Fetch the page's data
$compendium_page_data = compendium_pages_get( page_url: $compendium_page_url );

// Redirect if the page doesn't exist or shouldn't be accessed
if(!$compendium_page_data)
  exit(header('Location: '.$path.'pages/compendium/page_list'));

// Redirect if needed
if(isset($compendium_page_data['redirect']))
  exit(header('Location: '.$path.'pages/compendium/'.$compendium_page_data['redirect']));

// Update the page summary
$page_url        .= $compendium_page_url;
$page_title_en   .= $compendium_page_data['title_en'];
$page_title_fr   .= $compendium_page_data['title_fr'];
$page_description = ($compendium_page_data['summary']) ? $compendium_page_data['meta'] : $page_description;



/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <?php if($compendium_page_data['deleted']) { ?>
  <div class="padding_bot">
    <h5 class="uppercase red text_white bold spaced align_center">
      <?=__('compendium_page_deleted')?>
    </h5>
  </div>
  <?php } ?>

  <?php if($compendium_page_data['draft']) { ?>
  <div class="padding_bot">
    <h5 class="uppercase orange text_white bold spaced align_center">
      <?=__('compendium_page_draft')?>
    </h5>
  </div>
  <?php } ?>

  <?php if($compendium_page_data['no_page']) { ?>
  <div class="padding_bot">
    <h5 class="uppercase red text_white bold spaced align_center">
      <?=__('compendium_page_no_page')?>
    </h5>
  </div>
  <?php } ?>

  <<?=$compendium_page_data['title_size']?>>
    <?=__link('pages/compendium/page_list', $compendium_page_data['title'], 'noglow')?>
    <?php if($is_admin) { ?>
    <?php if($compendium_page_data['draft']) { ?>
    <?=__icon('done', alt: 'D', title: __('compendium_page_draft_icon'), href: 'pages/compendium/page_publish?id='.$compendium_page_data['id'])?>
    <?php } ?>
    <?php } ?>
  </<?=$compendium_page_data['title_size']?>>

  <p class="tinypadding_top padding_bot">
    <span class="bold"><?=__('compendium_page_type').__(':')?></span>
    <?=__link('pages/compendium/page_type?type='.$compendium_page_data['type_id'], $compendium_page_data['type'])?>
    <?php if($compendium_page_data['era']) { ?>
    <br>
    <span class="bold"><?=__('compendium_page_era').__(':')?></span>
    <?=__link('pages/compendium/cultural_era?era='.$compendium_page_data['era_id'], $compendium_page_data['era'])?>
    <?php } if($compendium_page_data['categories']) { ?>
    <br>
    <span class="bold"><?=__('compendium_page_category', amount: $compendium_page_data['categories']).__(':')?></span>
    <?php for($i = 0; $i < $compendium_page_data['categories']; $i++) { ?>
    <?=__link('pages/compendium/category?id='.$compendium_page_data['category_id'][$i], $compendium_page_data['category_name'][$i])?>
    <?php if(($i + 1) < $compendium_page_data['categories']) { ?>
    ;
    <?php } ?>
    <?php } ?>
    <?php } if($compendium_page_data['appeared']) { ?>
    <br>
    <span class="bold"><?=__('compendium_page_appeared').__(':')?></span>
    <?=$compendium_page_data['appeared']?>
    <?php } if($compendium_page_data['peak']) { ?>
    <br>
    <span class="bold"><?=__('compendium_list_peak').__(':')?></span>
    <?=$compendium_page_data['peak']?>
    <?php } ?>
  </p>

  <?php if($compendium_page_data['nsfw']) { ?>
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
  <?php } ?>

  <?php if($compendium_page_data['offensive']) { ?>
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
  <?php } ?>

  <?php if($compendium_page_data['gross']) { ?>
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

  <div class="smallpadding_top padding_bot align_justify">
    <?=$compendium_page_data['body']?>
  </div>

  <p class="align_center bigpadding_top">
    <?=__link('pages/compendium/index', __('compendium_page_compendium'))?><br>
    <?=__link('#compendium_page_history', __('compendium_page_modified', preset_values: array($compendium_page_data['updated'])), is_internal: false, onclick: "compendium_page_history_fetch('".$compendium_page_data['id']."')")?><br>
    <?=__link('pages/compendium/random_page?type='.$compendium_page_data['type_id'].'&id='.$compendium_page_data['id'], __('compendium_page_random_type', preset_values: array($compendium_page_data['type_full'])))?><br>
    <?=__link('pages/compendium/random_page?id='.$compendium_page_data['id'], __('compendium_page_random_page'))?>
  </p>

</div>

<div id="compendium_page_history" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('compendium_page_history');">&times;</a>
    <div class="nopadding_top" id="compendium_page_history_body">
      &nbsp;
    </div>
  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }