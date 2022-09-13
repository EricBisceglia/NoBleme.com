<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// Block illegal page URLs by removing any stray slashes /************************************************************/
if(str_contains(mb_substr($_SERVER['REQUEST_URI'], (mb_stripos($_SERVER['REQUEST_URI'], 'pages/compendium/') + mb_strlen('pages/compendium/'))), '/')) { exit(header("Location: ..")); die(); }

// File inclusions
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

// Hide the regular footer, except for admins
$hide_footer = true;

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

// Redirect if the page doesn't have an url
if(!$compendium_page_url)
  exit(header('Location: '.$path.'pages/compendium/page_list'));

// Fetch the page's data
$compendium_page_data = compendium_pages_get( page_url: $compendium_page_url );

// Redirect if needed
if(isset($compendium_page_data['redirect']))
{
  if($compendium_page_data['redir_ext'])
    exit(header('Location: '.$path.$compendium_page_data['redirect']));
  else
    exit(header('Location: '.$path.'pages/compendium/'.$compendium_page_data['redirect']));
}

// Update the page summary
if($compendium_page_data)
{
  $page_url        .= $compendium_page_url;
  $page_title_en   .= $compendium_page_data['titleenraw'];
  $page_title_fr   .= $compendium_page_data['titlefrraw'];
  $page_description = ($compendium_page_data['summary']) ? $compendium_page_data['meta_desc'] : $page_description;
}
else
{
  $page_url        .= 'dead_link';
  $page_title_en   .= "Compendium: Missing page";
  $page_title_fr   .= "Compendium : Page manquante";
  unset($hide_footer);

  // Fetch a random image to go with the missing page text
  $compendium_random_image      = compendium_images_get_random();
  $compendium_random_image_data = compendium_images_get(file_name: $compendium_random_image);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update pageview count

if($compendium_page_data)
  compendium_pages_update_pageviews(  $compendium_page_data['id'] ,
                                      $page_url                   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Footer text

// Copyright ending date
$copyright_date = date('Y');

// Current pageview count
$pageviews = isset($pageviews) ? __('footer_pageviews').$pageviews.__('times', $pageviews, 1) : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<?php if($compendium_page_data) { ?>

<?php if(!$compendium_page_data['no_page'] || $is_admin) { ?>

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

    <?php if($compendium_page_data['blur_title']) { ?>
    <?=__link('pages/compendium/page_list', $compendium_page_data['title'], 'noglow blur bigblur', onmouseover: 'unblur(this);')?>
    <?php } else { ?>
    <?=__link('pages/compendium/page_list', $compendium_page_data['title'], 'noglow')?>
    <?php } ?>

    <?php if($is_admin) { ?>
    <?php if(!$compendium_page_data['draft']) { ?>
    <?=__icon('link', alt: 'L', title: __('link'), title_case: 'initials', href: 'pages/compendium/page_social_media?id='.$compendium_page_data['id'])?>
    <?php } ?>
    <?=__icon('edit', class: 'valign_middle pointer', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/page_edit?id='.$compendium_page_data['id'])?>
    <?php if($compendium_page_data['draft']) { ?>
    <?=__icon('done', alt: 'D', title: __('compendium_page_draft_icon'), href: 'pages/compendium/page_publish?id='.$compendium_page_data['id'])?>
    <?php } if($compendium_page_data['deleted']) { ?>
    <?=__icon('refresh', alt: 'X', title: __('restore'), title_case: 'initials', href: 'pages/compendium/page_restore?id='.$compendium_page_data['id'])?>
    <?php } ?>
    <?=__icon('delete', class: 'valign_middle pointer', alt: 'X', title: __('delete'), title_case: 'initials', href: 'pages/compendium/page_delete?id='.$compendium_page_data['id'])?>
    <?php } ?>

  </<?=$compendium_page_data['title_size']?>>

  <p class="tinypadding_top padding_bot">
    <?php if($compendium_page_data['type']) { ?>
    <span class="bold"><?=__('compendium_page_type').__(':')?></span>
    <?=__link('pages/compendium/page_type?type='.$compendium_page_data['type_id'], $compendium_page_data['type'])?>
    <br>
    <?php } if($compendium_page_data['era']) { ?>
    <span class="bold"><?=__('compendium_page_era').__(':')?></span>
    <?=__link('pages/compendium/cultural_era?era='.$compendium_page_data['era_id'], $compendium_page_data['era'])?>
    <br>
    <?php } if($compendium_page_data['categories']) { ?>
    <span class="bold"><?=string_change_case(__('category', amount: $compendium_page_data['categories']), 'initials').__(':')?></span>
    <?php for($i = 0; $i < $compendium_page_data['categories']; $i++) { ?>
    <?=__link('pages/compendium/category?id='.$compendium_page_data['category_id'][$i], $compendium_page_data['category_name'][$i])?>
    <?php if(($i + 1) < $compendium_page_data['categories']) { ?>
    ;
    <?php } ?>
    <?php } ?>
    <br>
    <?php } if($compendium_page_data['appeared']) { ?>
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

  <div class="smallpadding_top align_desktop">
    <?=$compendium_page_data['body']?>
  </div>

  <p class="align_center hugepadding_top bigpadding_bot">
    <?php if($is_admin && $pageviews) { ?>
    <?=__link("pages/admin/stats_views", __('compendium_page_pageviews', amount: $pageviews, preset_values: array($pageviews)), style: 'hugeglow_dark')?><br>
    <?php } ?>
    <?=__link("pages/doc/legal", __('compendium_page_copyright', preset_values: array($copyright_date)), style: 'hugeglow_dark')?><br>
    <?=__link('pages/compendium/mission_statement', __('compendium_page_compendium'), style: 'hugeglow_dark')?><br>
    <?=__link('#compendium_page_history', __('compendium_page_modified', preset_values: array($compendium_page_data['updated'])), is_internal: false, onclick: "compendium_page_history_fetch('".$compendium_page_data['id']."')", style: 'hugeglow_dark')?><br>
    <?php if($compendium_page_data['type_id']) { ?>
    <?=__link('pages/compendium/random_page?type='.$compendium_page_data['type_id'].'&id='.$compendium_page_data['id'], __('compendium_page_random_type', preset_values: array($compendium_page_data['type_full'])), style: 'hugeglow_dark')?><br>
    <?php } ?>
    <?=__link('pages/compendium/random_page?id='.$compendium_page_data['id'], __('compendium_page_random_page'), style: 'hugeglow_dark')?><br>
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

<?php } else { ?>

<div class="width_50">

  <h1 class="padding_bot">
    <?=__link('pages/compendium/index', __('submenu_pages_compendium'), 'noglow')?>
  </h1>

  <div class="smallpadding_top">
    <h5 class="uppercase orange text_white bold spaced align_center">
      <?=__('compendium_page_no_lang')?>
    </h5>
  </div>

</div>

<?php } ?>

<?php } else { ?>

<div class="width_50">

  <h1>
    <?=__('compendium_page_missing_title')?>
    <?php if($is_admin) { ?>
    <?=__icon('settings', alt: 'S', title: __('settings'), title_case: 'initials', href: 'pages/compendium/page_missing_list')?>
    <?php } ?>
  </h1>

  <p class="bold">
    <?=__('compendium_page_missing_body_1')?>
  </p>

  <p class="hugepadding_bot">
    <?=__('compendium_page_missing_body_2')?>
  </p>

  <div class="align_center">

    <a class="noglow" href="<?=$path?>pages/compendium/image?name=<?=$compendium_random_image?>">
      <img src="<?=$path?>img/compendium/<?=$compendium_random_image?>" alt="<?=$compendium_random_image?>">
    </a>

    <?php if($compendium_random_image_data['body']) { ?>
    <div class="padding_top align_center">
      <?=$compendium_random_image_data['body']?>
    </div>
    <?php } ?>

  </div>

</div>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }