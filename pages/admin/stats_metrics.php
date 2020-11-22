<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../inc/functions_numbers.inc.php'; # Number formatting
include_once './../../actions/admin/stats.act.php';   # Actions
include_once './../../lang/admin/stats.lang.php';     # Translations

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

$admin_reset_metrics = form_fetch_element('admin_metrics_reset', -1);

if(isset($_POST['admin_metrics_reset']))
  stats_metrics_reset($admin_reset_metrics);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get the metrics

$admin_metrics = stats_metrics_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center bigpadding_bot">
    <?=__('submenu_admin_metrics')?>
  </h1>

  <table id="admin_metrics_table">
    <?php } if($admin_reset_metrics <= 0) { ?>
    <thead class="align_center">

      <tr class="uppercase">
        <th colspan="2" rowspan="7" class="dark valign_middle">
          <button onclick="admin_metrics_reset('<?=__('admin_metrics_reset_warning')?>');"><?=__('admin_metrics_reset')?></button>
        </th>
        <th class="dark">
          &nbsp;
        </th>
        <th>
          <?=__('admin_metrics_queries')?>
        </th>
        <th>
          <?=__('admin_metrics_load')?>
        </th>
        <th rowspan="8" class="dark">
          &nbsp;
        </th>
      </tr>

      <tr>
        <th class="uppercase align_right bold dark spaced">
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
        <th class="uppercase align_right bold dark spaced">
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
        <th class="uppercase align_right bold dark spaced">
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
        <th class="uppercase align_right bold dark spaced">
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
        <th class="uppercase align_right bold dark spaced">
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
        <th class="uppercase align_right bold dark spaced">
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
        <th colspan="5" class="dark">
          &nbsp;
        </th>
      </tr>

      <tr class="uppercase">
        <th>
          <?=__('admin_metrics_page')?>
        </th>
        <th>
          <?=__('admin_metrics_activity')?>
        </th>
        <th>
          <?=__('admin_metrics_views')?>
        </th>
        <th>
          <?=__('admin_metrics_queries')?>
        </th>
        <th>
          <?=__('admin_metrics_load')?>
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <?php for($i = 0; $i < $admin_metrics['rows']; $i++) { ?>

      <tr id="admin_metrics_row_<?=$admin_metrics[$i]['id']?>">
        <?php if($admin_metrics[$i]['url_full']) { ?>
        <td class="tooltip_container align_left">
          <?=__link($admin_metrics[$i]['url_full'], $admin_metrics[$i]['url'], 'bold noglow text_white')?>
          <div class="tooltip">
            <?=__link($admin_metrics[$i]['url_full'], $admin_metrics[$i]['url_full'])?>
          </div>
        </td>
        <?php } else { ?>
        <td class="align_left">
          <?=__link($admin_metrics[$i]['url'], $admin_metrics[$i]['url'], 'bold noglow text_white')?>
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
          <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/refresh_small.svg" alt="R" title="<?=__('admin_metrics_table_reset')?>" onclick="admin_metrics_reset('<?=__('admin_metrics_table_reset_warning')?>', <?=$admin_metrics[$i]['id']?>);">
        </td>
      </tr>

      <?php } ?>

    </tbody>
    <?php } if(!page_is_fetched_dynamically()) { ?>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }