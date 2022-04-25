<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/page_missing_list";
$page_title_en    = "Compendium missing pages";
$page_title_fr    = "Compendium : pages manquantes";

// Compendium admin menu selection
$compendium_admin_menu['missing'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/list', 'compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a missing page

if(isset($_POST['compendium_missing_delete_id']))
  compendium_missing_delete(form_fetch_element('compendium_missing_delete_id'));



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the missing pages

// Fetch the sorting order
$compendium_missing_sort_order = form_fetch_element('compendium_missing_sort_order', 'priority');

// Assemble the search query
$compendium_missing_search = array( 'url'       => form_fetch_element('compendium_missing_url')       ,
                                    'title'     => form_fetch_element('compendium_missing_title')     ,
                                    'type'      => form_fetch_element('compendium_missing_type')      ,
                                    'priority'  => form_fetch_element('compendium_missing_priority')  ,
                                    'notes'     => form_fetch_element('compendium_missing_notes')     ,
                                    'status'    => form_fetch_element('compendium_missing_status')    );

// Fetch the missing pages
$compendium_missing_list = compendium_missing_list( sort_by:  $compendium_missing_sort_order  ,
                                                    search:   $compendium_missing_search      );

// Fetch the page types
$compendium_types_list = compendium_types_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_50">

  <h2 class="padding_top bigpadding_bot align_center">
    <?=__('compendium_missing_title')?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/page_missing_edit')?>
  </h2>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_list_admin_url')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_missing_list_search('url');")?>
        </th>
        <th>
          <?=__('compendium_missing_page')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_missing_list_search('title');")?>
        </th>
        <th class="desktop">
          <?=__('compendium_list_theme')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_missing_list_search('type');")?>
        </th>
        <th class="desktop">
          <?=__('compendium_missing_priority')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_missing_list_search('priority');")?>
        </th>
        <th>
          <?=__('compendium_missing_notes')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_missing_list_search('notes');")?>
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="compendium_missing_sort_order" id="compendium_missing_sort_order" value="<?=$compendium_missing_sort_order?>">
          <input type="text" class="table_search" name="compendium_missing_url" id="compendium_missing_url" value="" onkeyup="compendium_missing_list_search();">
        </th>

        <th>
          <input type="text" class="table_search" name="compendium_missing_title" id="compendium_missing_title" value="" onkeyup="compendium_missing_list_search();">
        </th>

        <th class="desktop">
          <select class="table_search" name="compendium_missing_type" id="compendium_missing_type" onchange="compendium_missing_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 0; $i < $compendium_types_list['rows']; $i++) { ?>
            <option value="<?=$compendium_types_list[$i]['id']?>"><?=$compendium_types_list[$i]['name']?></option>
            <?php } ?>
          </select>
        </th>

        <th class="desktop">
          <select class="table_search" name="compendium_missing_priority" id="compendium_missing_priority" onchange="compendium_missing_list_search();">
            <option value="-1">&nbsp;</option>
            <option value="1"><?=__('compendium_missing_prioritary')?></option>
            <option value="0"><?=__('compendium_missing_no_priority')?></option>
          </select>
        </th>

        <th>
          <select class="table_search" name="compendium_missing_notes" id="compendium_missing_notes" onchange="compendium_missing_list_search();">
            <option value="-1">&nbsp;</option>
            <option value="1"><?=__('compendium_missing_notes')?></option>
            <option value="0"><?=__('compendium_missing_no_notes')?></option>
          </select>
        </th>

        <th>
          <select class="table_search compendium_admin_actions" name="compendium_missing_status" id="compendium_missing_status" onchange="compendium_missing_list_search();">
            <option value="-1">&nbsp;</option>
            <option value="1"><?=__('compendium_missing_documented')?></option>
            <option value="0"><?=__('compendium_missing_undocumented')?></option>
          </select>
        </th>

      </tr>

    </thead>

    <tbody class="altc2 nowrap" id="compendium_missing_list_tbody">

      <?php } ?>

      <?php if($compendium_missing_list['rows']) { ?>

      <tr>
        <td colspan="6" class="uppercase text_light dark bold align_center desktop">
          <?=__('compendium_missing_count', preset_values: array($compendium_missing_list['rows']))?>
        </td>
        <td colspan="4" class="uppercase text_light dark bold align_center mobile">
          <?=__('compendium_missing_count', preset_values: array($compendium_missing_list['rows']))?>
        </td>
      </tr>

      <?php } for($i = 0; $i < $compendium_missing_list['rows']; $i++) { ?>

      <tr>

        <?php if(!$compendium_missing_list[$i]['fullurl']) { ?>
        <td class="align_left">
          <?=__link('pages/compendium/page_missing?id='.$compendium_missing_list[$i]['id'], $compendium_missing_list[$i]['url'], 'nbcode_dead_link noglow')?>
        </td>
        <?php } else { ?>
        <td class="align_left nbcode_dead_link noglow tooltip_container">
          <?=__link('pages/compendium/page_missing?id='.$compendium_missing_list[$i]['id'], $compendium_missing_list[$i]['urldisplay'], 'nbcode_dead_link noglow')?>
          <div class="tooltip">
            <?=__link('pages/compendium/page_missing?id='.$compendium_missing_list[$i]['id'], $compendium_missing_list[$i]['fullurl'], 'nbcode_dead_link noglow')?>
          </div>
        </td>
        <?php } ?>

        <?php if(!$compendium_missing_list[$i]['t_full']) { ?>
        <td class="align_center">
          <?=$compendium_missing_list[$i]['title']?>
        </td>
        <?php } else { ?>
        <td class="align_center tooltip_container">
          <?=$compendium_missing_list[$i]['t_display']?>
          <div class="tooltip">
            <?=$compendium_missing_list[$i]['t_full']?>
          </div>
        </td>
        <?php } ?>

        <td class="align_center desktop">
          <?=$compendium_missing_list[$i]['type']?>
        </td>

        <td class="align_center desktop">
          <?php if($compendium_missing_list[$i]['priority']) { ?>
          <?=__icon('warning', is_small: true, alt: 'P', title: __('compendium_missing_priority_full'), title_case: 'initials')?>
          <?php } else { ?>
          &nbsp;
          <?php } ?>
        </td>

        <?php if($compendium_missing_list[$i]['notes']) { ?>
        <td class="align_center tooltip_container">
          <?=__icon('message', is_small: true, alt: 'M', title: __('message'), title_case: 'initials')?>
          <div class="tooltip dowrap">
            <?=$compendium_missing_list[$i]['notes']?>
          </div>
        </td>
        <?php } else { ?>
        <td>
          &nbsp;
        </td>
        <?php } ?>

        <td class="align_center nowrap">
          <?=__icon('add', is_small: true, class: 'valign_middle pointer spaced_right', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/page_add?url='.$compendium_missing_list[$i]['url'])?>
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/page_missing_edit?id='.$compendium_missing_list[$i]['id'])?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "compendium_missing_delete('".$compendium_missing_list[$i]['id']."', '".__('compendium_missing_delete')."', 'list');")?>
        </td>

      </tr>

      <?php } if(count($compendium_missing_list['missing'])) { ?>

      <tr>
        <td colspan="6" class="uppercase text_light dark bold align_center desktop">
          <?=__('compendium_missing_uncount', preset_values: array(count($compendium_missing_list['missing'])))?>
        </td>
        <td colspan="4" class="uppercase text_light dark bold align_center mobile">
          <?=__('compendium_missing_uncount', preset_values: array(count($compendium_missing_list['missing'])))?>
        </td>
      </tr>

      <?php } for($i = 0; $i < count($compendium_missing_list['missing']); $i++) { ?>

      <tr>

        <?php if(mb_strlen($compendium_missing_list['missing'][$i]) <= 50) { ?>
        <td colspan="5" class="align_left desktop">
          <?=__link('pages/compendium/page_missing?url='.$compendium_missing_list['missing'][$i], $compendium_missing_list['missing'][$i], 'nbcode_dead_link noglow')?>
        </td>
        <td colspan="3" class="align_left mobile">
          <?=__link('pages/compendium/page_missing?url='.$compendium_missing_list['missing'][$i], $compendium_missing_list['missing'][$i], 'nbcode_dead_link noglow')?>
        </td>
        <?php } else { ?>
        <td colspan="5" class="align_left nbcode_dead_link noglow tooltip_container desktop">
          <?=__link('pages/compendium/page_missing?url='.$compendium_missing_list['missing'][$i], string_truncate($compendium_missing_list['missing'][$i], 50, '...'), 'nbcode_dead_link noglow')?>
          <div class="tooltip">
            <?=__link('pages/compendium/page_missing?url='.$compendium_missing_list['missing'][$i], $compendium_missing_list['missing'][$i], 'nbcode_dead_link noglow')?>
          </div>
        </td>
        <td colspan="3" class="align_left nbcode_dead_link noglow tooltip_container mobile">
          <?=__link('pages/compendium/page_missing?url='.$compendium_missing_list['missing'][$i], string_truncate($compendium_missing_list['missing'][$i], 50, '...'), 'nbcode_dead_link noglow')?>
          <div class="tooltip">
            <?=__link('pages/compendium/page_missing?url='.$compendium_missing_list['missing'][$i], $compendium_missing_list['missing'][$i], 'nbcode_dead_link noglow')?>
          </div>
        </td>
        <?php } ?>

        <td class="align_center nowrap">
          <?=__icon('add', is_small: true, class: 'valign_middle pointer spaced_right', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/page_add?url='.$compendium_missing_list['missing'][$i])?>
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/page_missing_edit?url='.$compendium_missing_list['missing'][$i])?>
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