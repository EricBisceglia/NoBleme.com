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
$page_url         = "pages/compendium/page_list";
$page_title_en    = "Compendium";
$page_title_fr    = "Compendium";
$page_description = "List of pages in NoBleme's encyclopedia of 21st century culture, internet memes, modern slang, and sociocultural concepts";

// Wider header menu
$header_width = 70;

// Extra js
$js = array('compendium/list');




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
$compendium_pages_sort_order = form_fetch_element('compendium_pages_search_order', 'title');

// Assemble the search query
$compendium_pages_list_search = array(  'title'     => form_fetch_element('compendium_search_title')    ,
                                        'type'      => form_fetch_element('compendium_search_type')     ,
                                        'era'       => form_fetch_element('compendium_search_era')      ,
                                        'appeared'  => form_fetch_element('compendium_search_appeared') ,
                                        'peaked'    => form_fetch_element('compendium_search_peak')     ,
                                        'created'   => form_fetch_element('compendium_search_created')  );

// Fetch the pages
$compendium_pages_list = compendium_pages_list( sort_by:    $compendium_pages_sort_order  ,
                                                search:     $compendium_pages_list_search ,
                                                user_view:  true                          );

// Fetch the appearance, peak, and page creation years
$compendium_page_list_years       = compendium_pages_list_years();
$compendium_appearance_list_years = compendium_appearance_list_years();
$compendium_peak_list_years       = compendium_peak_list_years();

// Fetch the page types
$compendium_types_list = compendium_types_list();

// Fetch the eras
$compendium_eras_list = compendium_eras_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1>
    <?=__link('pages/compendium/index', __('compendium_index_title'), 'noglow')?>
    <?php if($is_admin) { ?>
    <?=__icon('settings', alt: 'E', title: __('settings'), title_case: 'initials', href: 'pages/compendium/page_list_admin')?>
    <?php } ?>
  </h1>

  <h5>
    <?=__('compendium_list_subtitle')?>
  </h5>

  <p>
    <?=__('compendium_list_intro')?>
    <?php if($user_settings_nsfw < 2) { ?>
    <?=__('compendium_list_blur')?>
    <?php } ?>
  </p>

</div>

<div class="width_70">

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_list_title')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('title');")?>
        </th>
        <th>
          <?=__('compendium_list_theme')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('theme');")?>
        </th>
        <th>
          <?=__('compendium_page_era')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('era');")?>
        </th>
        <th class="desktop">
          <?=__('compendium_list_appeared')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('appeared');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('appeared_desc');", class: 'valign_middle pointer desktop')?>
        </th>
        <th>
          <?=__('compendium_list_peak')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('peak');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('peak_desc');", class: 'valign_middle pointer desktop')?>
        </th>
        <th class="desktop">
          <?=__('compendium_list_created')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_page_list_search('created');")?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="compendium_pages_search_order" id="compendium_pages_search_order" value="<?=$compendium_pages_sort_order?>">
          <input type="text" class="table_search" name="compendium_search_title" id="compendium_search_title" value="" onkeyup="compendium_page_list_search();">
        </th>

        <th>
          <select class="table_search" name="compendium_search_type" id="compendium_search_type" onchange="compendium_page_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_types_list['rows']; $i++) { ?>
            <option value="<?=$compendium_types_list[$i]['id']?>"><?=$compendium_types_list[$i]['name']?></option>
            <?php } ?>
          </select>
        </th>

        <th>
          <select class="table_search" name="compendium_search_era" id="compendium_search_era" onchange="compendium_page_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_eras_list['rows']; $i++) { ?>
            <option value="<?=$compendium_eras_list[$i]['id']?>"><?=$compendium_eras_list[$i]['short']?></option>
            <?php } ?>
          </select>
        </th>

        <th class="desktop">
          <select class="table_search" name="compendium_search_appeared" id="compendium_search_appeared" onchange="compendium_page_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_appearance_list_years['rows']; $i++) { ?>
            <?php if($compendium_appearance_list_years[$i]['year'] > 0) { ?>
            <option value="<?=$compendium_appearance_list_years[$i]['year']?>"><?=$compendium_appearance_list_years[$i]['year']?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </th>

        <th>
          <select class="table_search" name="compendium_search_peak" id="compendium_search_peak" onchange="compendium_page_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_peak_list_years['rows']; $i++) { ?>
            <?php if($compendium_peak_list_years[$i]['year'] > 0) { ?>
            <option value="<?=$compendium_peak_list_years[$i]['year']?>"><?=$compendium_peak_list_years[$i]['year']?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </th>

        <th class="desktop">
          <select class="table_search" name="compendium_search_created" id="compendium_search_created" onchange="compendium_page_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_page_list_years['rows']; $i++) { ?>
            <option value="<?=$compendium_page_list_years[$i]['year']?>"><?=$compendium_page_list_years[$i]['year']?></option>
            <?php } ?>
          </select>
        </th>

      </tr>

    </thead>

    <tbody class="altc2 nowrap" id="compendium_pages_tbody">

      <?php } ?>

      <tr>
        <td colspan="6" class="uppercase text_light dark bold align_center desktop">
          <?=__('compendium_list_count', preset_values: array($compendium_pages_list['rows']))?>
        </td>
        <td colspan="4" class="uppercase text_light dark bold align_center mobile">
          <?=__('compendium_list_count', preset_values: array($compendium_pages_list['rows']))?>
        </td>
      </tr>

      <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

      <tr>

        <?php if(!$compendium_pages_list[$i]['fulltitle'] && !$compendium_pages_list[$i]['summary']) { ?>
        <td class="align_left<?=$compendium_pages_list[$i]['blur']?>" onmouseover="unblur();">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['title'], 'bold'.$compendium_pages_list[$i]['blur'], onmouseover: 'unblur();')?>
        </td>
        <?php } else { ?>
        <td class="tooltip_container<?=$compendium_pages_list[$i]['blur']?>" onmouseover="unblur();">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['shorttitle'], 'bold'.$compendium_pages_list[$i]['blur'], onmouseover: 'unblur();')?>
          <div class="tooltip dowrap">
            <h5>
              <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['title'], 'noglow')?>
            </h5>
            <?php if($compendium_pages_list[$i]['summary']) { ?>
            <p>
              <?=$compendium_pages_list[$i]['summary']?>
            </p>
            <?php } ?>
          </div>
        </td>
        <?php } ?>

        <td class="align_center">
          <?=__link('pages/compendium/page_type?type='.$compendium_pages_list[$i]['type_id'], string_change_case($compendium_pages_list[$i]['type'], 'initials'))?>
        </td>

        <td class="align_center">
          <?=__link('pages/compendium/cultural_era?era='.$compendium_pages_list[$i]['era_id'], $compendium_pages_list[$i]['era'])?>
        </td>

        <td class="align_center desktop">
          <?=$compendium_pages_list[$i]['appeared']?>
        </td>

        <td class="align_center">
          <?=$compendium_pages_list[$i]['peak']?>
        </td>

        <td class="align_center desktop">
          <?=$compendium_pages_list[$i]['created']?>
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