<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../inc/functions_numbers.inc.php'; # Number formatting
include_once './../../actions/stats.act.php';         # Actions
include_once './../../lang/stats.lang.php';           # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/stats_metrics";
$page_title_en    = "Metrics";
$page_title_fr    = "Performances";

// Extra JS
$js = array('admin/stats');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Reset the metrics

// Fetch the reset requests
$admin_reset_metrics = form_fetch_element('admin_metrics_reset', -1);

// Reset the metrics if required
if(isset($_POST['admin_metrics_reset']))
  stats_metrics_reset($admin_reset_metrics);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get the metrics

// Check whether a search has been requested
$admin_metrics_search = form_fetch_element('stats_metrics_sort', NULL, 1);

// Fetch the search data
$admin_metrics_search_data = array( 'url'     =>  form_fetch_element('stats_metrics_search_url')      ,
                                    'queries' =>  form_fetch_element('stats_metrics_search_queries')  ,
                                    'load'    =>  form_fetch_element('stats_metrics_search_load')     );

// Fetch the metrics
$admin_metrics = stats_metrics_list(  form_fetch_element('stats_metrics_sort', 'activity')  ,
                                      $admin_metrics_search_data                            );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_60 autoscroll">

  <h1 class="align_center bigpadding_bot">
    <?=__('submenu_admin_metrics')?>
  </h1>

  <table id="admin_metrics_table">
    <?php } if($admin_reset_metrics <= 0 && !$admin_metrics_search) { ?>
    <thead class="align_center">

      <tr class="uppercase">
        <th colspan="2" rowspan="8" class="background valign_middle">
          <button onclick="admin_metrics_reset('<?=__('admin_metrics_reset_warning')?>');"><?=__('admin_metrics_reset')?></button>
        </th>
        <th class="background">
          &nbsp;
        </th>
        <th class="background">
          <?=__('query+')?>
        </th>
        <th class="background">
          <?=__('admin_metrics_load')?>
        </th>
        <th rowspan="9" class="background">
          &nbsp;
        </th>
      </tr>

      <tr>
        <th class="uppercase align_right bold background spaced">
          <?=__('admin_metrics_minimum').__(':')?>
        </th>
        <th class="bold blue">
          <?=$admin_metrics['min_queries']?>
        </th>
        <th class="bold blue">
          <?=$admin_metrics['min_load']?>
        </th>
      </tr>

      <tr>
        <th class="uppercase align_right bold background spaced">
          <?=__('admin_metrics_average').__(':')?>
        </th>
        <th class="bold purple">
          <?=$admin_metrics['average_queries']?>
        </th>
        <th class="bold purple">
          <?=$admin_metrics['average_load']?>
        </th>
      </tr>

      <tr>
        <th class="uppercase align_right bold background spaced">
          <?=__('admin_metrics_maximum').__(':')?>
        </th>
        <th class="bold brown">
          <?=$admin_metrics['max_queries']?>
        </th>
        <th class="bold brown">
          <?=$admin_metrics['max_load']?>
        </th>
      </tr>

      <tr>
        <th colspan="3" class="background smallest">
          &nbsp;
        </th>
      </tr>

      <tr>
        <th class="uppercase align_right bold background spaced">
          <?=__('admin_metrics_target').__(':')?>
        </th>
        <th class="bold green">
          <?=$admin_metrics['good_queries']?>
        </th>
        <th class="bold green">
          <?=$admin_metrics['good_load']?>
        </th>
      </tr>

      <tr>
        <th class="uppercase align_right bold background spaced">
          <?=__('admin_metrics_warning').__(':')?>
        </th>
        <th class="bold orange">
          <?=$admin_metrics['bad_queries']?>
        </th>
        <th class="bold orange">
          <?=$admin_metrics['bad_load']?>
        </th>
      </tr>

      <tr>
        <th class="uppercase align_right bold background spaced">
          <?=__('admin_metrics_bad').__(':')?>
        </th>
        <th class="bold red">
          <?=$admin_metrics['awful_queries']?>
        </th>
        <th class="bold red">
          <?=$admin_metrics['awful_load']?>
        </th>
      </tr>

      <tr>
        <th colspan="5" class="background">
          &nbsp;
        </th>
      </tr>

      <tr class="uppercase">

        <th>
          <?=__('admin_metrics_page')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_metrics_search('url');")?>
        </th>

        <th>
          <?=__('activity')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_metrics_search('activity');")?>
        </th>

        <th>
          <?=__('view+')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_metrics_search('views');")?>
        </th>

        <th>
          <?=__('query+')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_metrics_search('queries');")?>
        </th>

        <th>
          <?=__('admin_metrics_load')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_metrics_search('load');")?>
        </th>

        <th>
          <?=__('act')?>
        </th>

      </tr>

      <tr>

        <th>
          <input type="hidden" name="stats_metrics_sort" id="stats_metrics_sort" value="activity">
          <input type="text" class="table_search" name="stats_metrics_search_url" id="stats_metrics_search_url" value="" onkeyup="admin_metrics_search();">
        </th>

        <th colspan="2">
          &nbsp;
        </th>

        <th>
          <select class="table_search" name="stats_metrics_search_queries" id="stats_metrics_search_queries" onchange="admin_metrics_search();">
            <option value="0">&nbsp;</option>
            <option value="1" class="bold blue"><?=string_change_case(__('admin_metrics_minimum'), 'uppercase')?></option>
            <option value="2" class="bold green"><?=string_change_case(__('admin_metrics_target'), 'uppercase')?></option>
            <option value="3" class="bold orange"><?=string_change_case(__('admin_metrics_warning'), 'uppercase')?></option>
            <option value="4" class="bold red"><?=string_change_case(__('admin_metrics_bad'), 'uppercase')?></option>
            <option value="5" class="bold brown"><?=string_change_case(__('admin_metrics_maximum'), 'uppercase')?></option>
          </select>
        </th>

        <th>
          <select class="table_search" name="stats_metrics_search_load" id="stats_metrics_search_load" onchange="admin_metrics_search();">
            <option value="0">&nbsp;</option>
            <option value="1" class="bold blue"><?=string_change_case(__('admin_metrics_minimum'), 'uppercase')?></option>
            <option value="2" class="bold green"><?=string_change_case(__('admin_metrics_target'), 'uppercase')?></option>
            <option value="3" class="bold orange"><?=string_change_case(__('admin_metrics_warning'), 'uppercase')?></option>
            <option value="4" class="bold red"><?=string_change_case(__('admin_metrics_bad'), 'uppercase')?></option>
            <option value="5" class="bold brown"><?=string_change_case(__('admin_metrics_maximum'), 'uppercase')?></option>
          </select>
        </th>

        <th>
          &nbsp;
        </th>

      </tr>

    </thead>
    <tbody class="altc align_center" id="stats_metrics_tbody">
    <?php } if($admin_reset_metrics <= 0) { ?>

      <tr>
        <td class="uppercase bold dark text_white" colspan="6">
          <?php if($admin_metrics['realrows'] == $admin_metrics['totalrows']) { ?>
          <?=__('admin_metrics_count', $admin_metrics['totalrows'], 0, 0, array($admin_metrics['totalrows']))?>
          <?php } else { ?>
          <?=__('admin_metrics_count_search', $admin_metrics['realrows'], 0, 0, array($admin_metrics['realrows'], $admin_metrics['totalrows']))?>
          <?php } ?>
        </td>
      </tr>

      <?php for($i = 0; $i < $admin_metrics['rows']; $i++) { ?>
      <?php if(!$admin_metrics[$i]['skip']) { ?>

      <tr id="admin_metrics_row_<?=$admin_metrics[$i]['id']?>">
        <?php if($admin_metrics[$i]['url_full']) { ?>
        <td class="tooltip_container tooltip_desktop align_left">
          <?=__link($admin_metrics[$i]['url_full'], $admin_metrics[$i]['url'], 'bold noglow')?>
          <div class="tooltip">
            <?=__link($admin_metrics[$i]['url_full'], $admin_metrics[$i]['url_full'])?>
          </div>
        </td>
        <?php } else { ?>
        <td class="align_left">
          <?=__link($admin_metrics[$i]['url'], $admin_metrics[$i]['url'], 'bold noglow')?>
        </td>
        <?php } ?>
        <td class="nowrap spaced">
          <?=$admin_metrics[$i]['activity']?>
        </td>
        <td class="nowrap spaced bold">
          <?=$admin_metrics[$i]['views']?>
        </td>
        <td class="nowrap spaced bold <?=$admin_metrics[$i]['css_queries']?>">
          <?=$admin_metrics[$i]['queries']?>
        </td>
        <td class="nowrap spaced bold <?=$admin_metrics[$i]['css_load']?>">
          <?=$admin_metrics[$i]['load']?>
        </td>
        <td>
          <?=__icon('refresh', is_small: true, class: 'valign_middle pointer spaced', alt: 'R', title: string_change_case(__('reset'), 'initials'), onclick: "admin_metrics_reset('".__('admin_metrics_table_reset_warning')."', ".$admin_metrics[$i]['id'].");")?>
        </td>
      </tr>

      <?php } ?>
      <?php } ?>

      <?php } if($admin_reset_metrics <= 0 && !$admin_metrics_search) { ?>
    </tbody>
    <?php } if(!page_is_fetched_dynamically()) { ?>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }