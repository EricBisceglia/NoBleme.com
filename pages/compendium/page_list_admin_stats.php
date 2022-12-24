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

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/page_stats_admin";
$page_title_en    = "Compendium page stats";
$page_title_fr    = "Compendium : stats des pages";

// Compendium admin menu selection
$compendium_admin_menu['page_stats'] = 1;

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

// Fetch the sorting order
$compendium_pages_sort_order = form_fetch_element('compendium_pages_search_order', 'pageviews');

// Assemble the search query
$compendium_pages_list_search = array(  'url'             => form_fetch_element('compendium_search_url')          ,
                                        'redirect'        => -1                                                   ,
                                        'type'            => form_fetch_element('compendium_search_type')         ,
                                        'category'        => form_fetch_element('compendium_search_category')     ,
                                        'era'             => form_fetch_element('compendium_search_era')          ,
                                        'created'         => form_fetch_element('compendium_search_created')      ,
                                        'wip'             => 'finished'                                           ,
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

// Fetch the  page creation years
$compendium_page_list_years = compendium_pages_list_years(admin_view: true);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_80 autoscroll">

  <h2 class="padding_top bigpadding_bot align_center">
    <?=__link('pages/compendium/page_list', __('compendium_list_stats_title'), 'noglow')?>
  </h2>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_list_admin_url')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('url');")?>
        </th>
        <th>
          <?=__('theme')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('theme');")?>
        </th>
        <th>
          <?=__('compendium_list_admin_categories')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('categories');")?>
        </th>
        <th>
          <?=__('compendium_page_era')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('era');")?>
        </th>
        <th>
          <?=string_change_case(__('created', spaces_after: 1), 'initials')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('created');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('created_r');")?>
        </th>
        <th>
          <?=__('compendium_list_stats_views')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('pageviews');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('pageviews_r');")?>
        </th>
        <th>
          <?=__('compendium_list_stats_chars_en')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('chars_en');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('chars_en_r');")?>
        </th>
        <th>
          <?=__('compendium_list_stats_chars_fr')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('chars_fr');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "compendium_page_stats_search('chars_fr_r');")?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="compendium_pages_search_order" id="compendium_pages_search_order" value="<?=$compendium_pages_sort_order?>">
          <input type="text" class="table_search" name="compendium_search_url" id="compendium_search_url" value="" onkeyup="compendium_page_stats_search();">
        </th>

        <th>
          <select class="table_search" name="compendium_search_type" id="compendium_search_type" onchange="compendium_page_stats_search();">
            <option value="0">&nbsp;</option>
            <option value="-1"><?=string_change_case(__('none'), 'initials')?></option>
            <?php for($i = 0; $i < $compendium_types_list['rows']; $i++) { ?>
            <option value="<?=$compendium_types_list[$i]['id']?>"><?=$compendium_types_list[$i]['name']?></option>
            <?php } ?>
          </select>
        </th>

        <th class="compendium_admin_search_small">
          <select class="table_search" name="compendium_search_category" id="compendium_search_category" onchange="compendium_page_stats_search();">
            <option value="">&nbsp;</option>
            <option value="-1"><?=__('compendium_list_admin_categories_no')?></option>
            <option value="-2"><?=__('compendium_list_admin_categories_yes')?></option>
            <?php for($i = 0; $i < $compendium_categories_list['rows']; $i++) { ?>
            <option value="<?=$compendium_categories_list[$i]['id']?>"><?=$compendium_categories_list[$i]['name']?></option>
            <?php } ?>
          </select>
        </th>

        <th>
          <select class="table_search" name="compendium_search_era" id="compendium_search_era" onchange="compendium_page_stats_search();">
            <option value="0">&nbsp;</option>
            <option value="-1"><?=string_change_case(__('none_f'), 'initials')?></option>
            <?php for($i = 0; $i < $compendium_eras_list['rows']; $i++) { ?>
            <option value="<?=$compendium_eras_list[$i]['id']?>"><?=$compendium_eras_list[$i]['short']?></option>
            <?php } ?>
          </select>
        </th>

        <th>
          <select class="table_search" name="compendium_search_created" id="compendium_search_created" onchange="compendium_page_stats_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_page_list_years['rows']; $i++) { ?>
            <option value="<?=$compendium_page_list_years[$i]['year']?>"><?=$compendium_page_list_years[$i]['year']?></option>
            <?php } ?>
          </select>
        </th>

        <th colspan="3">
          &nbsp;
        </th>

      </tr>

    </thead>

    <tbody class="altc2 nowrap" id="compendium_pages_stats_tbody">

      <?php } ?>

      <tr>
        <td colspan="8" class="uppercase text_light dark bold align_center">
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
        <td class="align_left tooltip_container tooltip_desktop">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['urlstats'])?>
          <div class="tooltip">
            <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['fullurlst'])?>
          </div>
        </td>
        <?php } ?>

        <td class="align_center">
          <?=__link('pages/compendium/page_type?type='.$compendium_pages_list[$i]['type_id'], string_change_case($compendium_pages_list[$i]['type'], 'initials'))?>
        </td>

        <?php if($compendium_pages_list[$i]['categories']) { ?>
        <td class="align_center tooltip_container tooltip_desktop">
          <?=__icon('done', is_small: true, alt: 'C', title: __('compendium_list_admin_category_count', amount: $compendium_pages_list[$i]['categories'], preset_values: array($compendium_pages_list[$i]['categories'])))?>
          <div class="tooltip">
            <?=__('compendium_list_admin_category_count', amount: $compendium_pages_list[$i]['categories'], preset_values: array($compendium_pages_list[$i]['categories']))?>
          </div>
        </td>
        <?php } else { ?>
        <td class="align_center">
          &nbsp;
        </td>
        <?php } ?>

        <td class="align_center">
          <?=__link('pages/compendium/cultural_era?era='.$compendium_pages_list[$i]['era_id'], $compendium_pages_list[$i]['era'])?>
        </td>

        <td class="align_center">
          <?=$compendium_pages_list[$i]['created']?>
        </td>

        <td class="align_center">
          <?=$compendium_pages_list[$i]['viewcount']?>
        </td>

        <td class="align_center">
          <?=$compendium_pages_list[$i]['chars_en']?>
        </td>

        <td class="align_center">
          <?=$compendium_pages_list[$i]['chars_fr']?>
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