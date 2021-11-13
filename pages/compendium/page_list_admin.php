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
$page_url         = "pages/compendium/page_list_admin";
$page_title_en    = "Compendium page list";
$page_title_fr    = "Compendium : list des pages";

// Compendium admin menu selection
$compendium_admin_menu['page_list'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/list', 'compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the compendium pages

// Fetch the user's nsfw options
$user_settings_nsfw = user_settings_nsfw();

// Fetch the sorting order
$compendium_pages_sort_order = form_fetch_element('compendium_pages_search_order', 'url');

// Assemble the search query
$compendium_pages_list_search = array(  'url'             => form_fetch_element('compendium_search_url')          ,
                                        'translation'     => form_fetch_element('compendium_search_translation')  ,
                                        'title'           => form_fetch_element('compendium_search_title')        ,
                                        'redirect'        => form_fetch_element('compendium_search_redirect')     ,
                                        'redirname'       => form_fetch_element('compendium_search_redirname')    ,
                                        'type'            => form_fetch_element('compendium_search_type')         ,
                                        'category'        => form_fetch_element('compendium_search_category')     ,
                                        'era'             => form_fetch_element('compendium_search_era')          ,
                                        'language'        => form_fetch_element('compendium_search_language')     ,
                                        'nsfw_admin'      => form_fetch_element('compendium_search_nsfw')         ,
                                        'wip'             => form_fetch_element('compendium_search_wip')          ,
                                        'join_categories' => 1                                                    );

// Fetch the pages
$compendium_pages_list = compendium_pages_list( sort_by:    $compendium_pages_sort_order  ,
                                                search:     $compendium_pages_list_search );

// Fetch the page types
$compendium_types_list = compendium_types_list();

// Fetch the categories
$compendium_categories_list = compendium_categories_list();

// Fetch the eras
$compendium_eras_list = compendium_eras_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_80">

  <h2 class="padding_top bigpadding_bot align_center">
    <?=__link('pages/compendium/page_list', __('compendium_list_admin_title'), 'noglow')?>
  </h2>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_list_admin_url')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('url');")?>
        </th>
        <th colspan="2">
          <?=__('compendium_list_title')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('title');")?>
        </th>
        <th colspan="2">
          <?=__('compendium_list_admin_redirect')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('redirect');")?>
        </th>
        <th>
          <?=__('compendium_list_theme')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('theme');")?>
        </th>
        <th>
          <?=__('compendium_list_admin_categories')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('categories');")?>
        </th>
        <th>
          <?=__('compendium_page_era')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('era');")?>
        </th>
        <th>
          <?=__('compendium_list_admin_language')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('language');")?>
        </th>
        <th>
          <?=__('compendium_list_admin_nsfw')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('nsfw');")?>
        </th>
        <th>
          <?=__('compendium_list_admin_wip')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_admin_list_search('wip');")?>
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="compendium_pages_search_order" id="compendium_pages_search_order" value="<?=$compendium_pages_sort_order?>">
          <input type="text" class="table_search" name="compendium_search_url" id="compendium_search_url" value="" onkeyup="compendium_admin_list_search();">
        </th>

        <th class="compendium_admin_search_big">
          <select class="table_search" name="compendium_search_translation" id="compendium_search_translation" onchange="compendium_admin_list_search();">
            <option value="0">&nbsp;</option>
            <option value="1"><?=__('compendium_list_admin_translated')?></option>
            <option value="-1"><?=__('compendium_list_admin_untranslated')?></option>
          </select>
        </th>

        <th>
          <input type="text" class="table_search" name="compendium_search_title" id="compendium_search_title" value="" onkeyup="compendium_admin_list_search();" size="1">
        </th>

        <th class="compendium_admin_search_big">
          <select class="table_search" name="compendium_search_redirect" id="compendium_search_redirect" onchange="compendium_admin_list_search();">
            <option value="0">&nbsp;</option>
            <option value="-1"><?=__('compendium_list_admin_redirect_no')?></option>
            <option value="1"><?=__('compendium_list_admin_redirect_yes')?></option>
          </select>
        </th>

        <th>
          <input type="text" class="table_search" name="compendium_search_redirname" id="compendium_search_redirname" value="" onkeyup="compendium_admin_list_search();" size="1">
        </th>

        <th>
          <select class="table_search" name="compendium_search_type" id="compendium_search_type" onchange="compendium_admin_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_types_list['rows']; $i++) { ?>
            <option value="<?=$compendium_types_list[$i]['id']?>"><?=$compendium_types_list[$i]['name']?></option>
            <?php } ?>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_search_category" id="compendium_search_category" onchange="compendium_admin_list_search();">
            <option value="">&nbsp;</option>
            <option value="-1"><?=__('compendium_list_admin_categories_no')?></option>
            <option value="-2"><?=__('compendium_list_admin_categories_yes')?></option>
            <?php for($i = 0; $i < $compendium_categories_list['rows']; $i++) { ?>
            <option value="<?=$compendium_categories_list[$i]['id']?>"><?=$compendium_categories_list[$i]['name']?></option>
            <?php } ?>
          </select>
        </th>

        <th>
          <select class="table_search" name="compendium_search_era" id="compendium_search_era" onchange="compendium_admin_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_eras_list['rows']; $i++) { ?>
            <option value="<?=$compendium_eras_list[$i]['id']?>"><?=$compendium_eras_list[$i]['short']?></option>
            <?php } ?>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_search_language" id="compendium_search_language" onchange="compendium_admin_list_search();">
            <option value="">&nbsp;</option>
            <option value="monolingual"><?=__('compendium_list_admin_monolingual')?></option>
            <option value="bilingual"><?=__('compendium_list_admin_bilingual')?></option>
            <option value="english"><?=string_change_case(__('english'), 'initials')?></option>
            <option value="french"><?=string_change_case(__('french'), 'initials')?></option>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_search_nsfw" id="compendium_search_nsfw" onchange="compendium_admin_list_search();">
            <option value="">&nbsp;</option>
            <option value="safe"><?=__('compendium_list_admin_safe')?></option>
            <option value="nsfw"><?=__('compendium_list_admin_unsafe')?></option>
            <option value="title"><?=__('compendium_list_admin_nsfw_title')?></option>
            <option value="page"><?=__('compendium_list_admin_nsfw_page')?></option>
            <option value="gross"><?=__('compendium_list_admin_gross')?></option>
            <option value="offensive"><?=__('compendium_list_admin_offensive')?></option>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_search_wip" id="compendium_search_wip" onchange="compendium_admin_list_search();">
            <option value="">&nbsp;</option>
            <option value="finished"><?=__('compendium_list_admin_finished')?></option>
            <option value="draft"><?=__('compendium_list_admin_draft')?></option>
            <option value="deleted"><?=__('compendium_list_admin_deleted')?></option>
          </select>
        </th>

        <th>
          &nbsp;
        </th>

      </tr>

    </thead>

    <tbody class="altc2 nowrap" id="compendium_pages_tbody">

      <?php } ?>

      <tr>
        <td colspan="12" class="uppercase text_light dark bold align_center">
          <?=__('compendium_list_count', preset_values: array($compendium_pages_list['rows']))?>
        </td>
      </tr>

      <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

      <tr>

        <?php if(!$compendium_pages_list[$i]['fullurl']) { ?>
        <td class="align_left">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['url'])?>
        </td>
        <?php } else { ?>
        <td class="align_left tooltip_container">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['urldisplay'])?>
          <div class="tooltip">
            <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['fullurl'])?>
          </div>
        </td>
        <?php } ?>

        <?php if($compendium_pages_list[$i]['admintitle'] && !$compendium_pages_list[$i]['adminfull']) { ?>
        <td class="align_left" colspan="2">
          <?=$compendium_pages_list[$i]['admintitle']?>
        </td>
        <?php } else if($compendium_pages_list[$i]['adminfull']) { ?>
        <td class="align_left tooltip_container" colspan="2">
          <?=$compendium_pages_list[$i]['admintitle']?>
          <div class="tooltip">
            <?=$compendium_pages_list[$i]['adminfull']?>
          </div>
        </td>
        <?php } else if(!$compendium_pages_list[$i]['fullwrong']) { ?>
        <td class="align_left" colspan="2">
          <?=__icon('message', is_small: true, alt: 'M', title: __('compendium_list_admin_missing'), title_case: 'initials', class: 'valign_middle spaced_right')?>
          <span class="strikethrough">
            <?=$compendium_pages_list[$i]['wrongtitle']?>
          </span>
        </td>
        <?php } else { ?>
        <td class="align_left tooltip_container" colspan="2">
          <?=__icon('message', is_small: true, alt: 'M', title: __('compendium_list_admin_missing'), title_case: 'initials', class: 'valign_middle spaced_right')?>
          <span class="strikethrough">
            <?=$compendium_pages_list[$i]['wrongtitle']?>
          </span>
          <div class="tooltip strikethrough">
            <?=$compendium_pages_list[$i]['fullwrong']?>
          </div>
        </td>
        <?php } ?>

        <?php if(!$compendium_pages_list[$i]['fullredir']) { ?>
        <td class="align_left" colspan="2">
          <?=$compendium_pages_list[$i]['redirect']?>
        </td>
        <?php } else { ?>
        <td class="align_left tooltip_container" colspan="2">
          <?=$compendium_pages_list[$i]['redirect']?>
          <div class="tooltip">
            <?=$compendium_pages_list[$i]['fullredir']?>
          </div>
        </td>
        <?php } ?>

        <td class="align_center">
          <?=__link('pages/compendium/page_type?type='.$compendium_pages_list[$i]['type_id'], string_change_case($compendium_pages_list[$i]['type'], 'initials'))?>
        </td>

        <td class="align_center">
          <?php if($compendium_pages_list[$i]['categories']) { ?>
          <?=__icon('done', is_small: true, alt: 'C', title: __('compendium_list_admin_category_count', amount: $compendium_pages_list[$i]['categories'], preset_values: array($compendium_pages_list[$i]['categories'])))?>
          <?php } else { ?>
          &nbsp;
          <?php } ?>
        </td>

        <td class="align_center">
          <?=__link('pages/compendium/cultural_era?era='.$compendium_pages_list[$i]['era_id'], $compendium_pages_list[$i]['era'])?>
        </td>

        <td class="align_center">
          <?php if($compendium_pages_list[$i]['lang_en']) { ?>
          <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="14" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
          <?php } if($compendium_pages_list[$i]['lang_fr']) { ?>
          <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="14" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
          <?php } ?>
        </td>

        <?php if($compendium_pages_list[$i]['adminnsfw']) { ?>
        <td class="align_center tooltip_container">
          <?=__icon('warning', is_small: true, class: 'valign_middle pointer', alt: 'X', title: __('compendium_list_admin_nsfw'), title_case: 'initials')?>
          <div class="tooltip">
            <?php if($compendium_pages_list[$i]['nsfwtitle']) { ?>
            <?=__('compendium_list_admin_nsfw_title')?><br>
            <?php } if($compendium_pages_list[$i]['nsfw']) { ?>
            <?=__('compendium_list_admin_nsfw_page')?><br>
            <?php } if($compendium_pages_list[$i]['gross']) { ?>
            <?=__('compendium_list_admin_gross')?><br>
            <?php } if($compendium_pages_list[$i]['offensive']) { ?>
            <?=__('compendium_list_admin_offensive')?>
            <?php } ?>
          </div>
        </td>
        <?php } else { ?>
        <td>
          &nbsp;
        </td>
        <?php } ?>

        <td class="align_center">
          <?php if($compendium_pages_list[$i]['deleted']) { ?>
          <?=__icon('x', is_small: true, alt: 'X', title: __('compendium_list_admin_deleted'), title_case: 'initials')?>
          <?php } else if($compendium_pages_list[$i]['draft']) { ?>
          <?=__icon('copy', is_small: true, alt: 'C', title: __('compendium_list_admin_draft'), title_case: 'initials')?>
          <?php } else { ?>
          &nbsp;
          <?php } ?>
        </td>

        <td class="align_center nowrap">
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'M', title: __('edit'), title_case: 'initials')?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer', alt: 'X', title: __('delete'), title_case: 'initials')?>
        </td>

      </tr>

      <?php } ?>

      <?php if(!page_is_fetched_dynamically()) { ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }