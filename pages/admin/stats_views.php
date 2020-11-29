<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/functions_time.inc.php';        # Time management
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Maths
include_once './../../actions/admin/stats.act.php';       # Actions
include_once './../../lang/admin/stats.lang.php';         # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/index";
$page_title_en    = "Pageviews";
$page_title_fr    = "Pages populaires";

// Extra JS
$js = array('admin/stats');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a page's data

// Check whether a deletion is requested
$stats_views_delete = form_fetch_element('admin_views_delete', 0);

// Delete a page's data
if($stats_views_delete)
  stats_views_delete($stats_views_delete);





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the page popularity data

$stats_views  = stats_views_list(  form_fetch_element('stats_views_sort', 'views')  ,
                  array( 'name' => form_fetch_element('stats_views_name')           ));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_60">

  <h1 class="align_center bigpadding_bot">
    <?=__('submenu_admin_pageviews')?>
  </h1>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('admin_views_name')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_views_search('name');">
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/link_small.svg" alt="v" title="<?=string_change_case(__('link'), 'initials')?>" onclick="admin_views_search('url');">
        </th>
        <th class="black text_white">
          <?=__('admin_metrics_views')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_views_search('views');">
        </th>
        <th colspan="2">
          <?=__('admin_views_growth')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_views_search('growth');">
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_views_search('pgrowth');">
        </th>
        <th>
          <?=__('admin_views_old')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_views_search('oldviews');">
        </th>
        <th>
          <?=__('admin_metrics_activity')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_views_search('activity');">
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_up_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_views_search('ractivity');">
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/link_small.svg" alt="v" title="<?=string_change_case(__('link'), 'initials')?>" onclick="admin_views_search('uactivity');">
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="stats_views_sort" id="stats_views_sort" value="">
          <input type="text" class="table_search" name="stats_views_name" id="stats_views_name" value="" onkeyup="admin_views_search();">
        </th>

        <th class="black">
          &nbsp;
        </th>

        <th rowspan="4">
          &nbsp;
        </th>

      </tr>

    </thead>
    <tbody class="altc align_center" id="stats_views_tbody">

      <?php } if(!$stats_views_delete) { ?>

      <?php for($i = 0; $i < $stats_views['rows']; $i++) { ?>

      <tr id="admin_views_row_<?=$stats_views[$i]['id']?>">

        <?php if(!$stats_views[$i]['fullname']) { ?>
        <td class="align_left">
          <?=__link($stats_views[$i]['url'], $stats_views[$i]['name'], 'bold noglow text_white')?>
        </td>
        <?php } else { ?>
        <td class="align_left tooltip_container">
          <?=__link($stats_views[$i]['url'], $stats_views[$i]['name'], 'bold noglow text_white')?>
          <div class="tooltip">
            <?=$stats_views[$i]['fullname']?>
          </div>
        </td>
        <?php } ?>

        <td class="nowrap bold black text_white">
          <?=$stats_views[$i]['views']?>
        </td>

        <td class="nowrap">
          <?=$stats_views[$i]['growth']?>
        </td>

        <td class="nowrap">
          <?=$stats_views[$i]['pgrowth']?>
        </td>

        <td class="nowrap">
          <?=$stats_views[$i]['oldviews']?>
        </td>

        <td class="nowrap">
          <?=$stats_views[$i]['activity']?>
        </td>

        <td class="align_center">
          <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="<?=string_change_case(__('delete'), 'initials')?>" onclick="admin_views_delete('<?=__('admin_views_delete')?>','<?=$stats_views[$i]['id']?>')">
        </td>

      </tr>

      <?php } ?>

      <?php } if(!page_is_fetched_dynamically()) { ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }