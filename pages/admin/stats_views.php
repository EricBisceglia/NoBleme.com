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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the page popularity data

$stats_views = stats_views_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center bigpadding_bot">
    <?=__('submenu_admin_pageviews')?>
  </h1>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('admin_views_name')?>
        </th>
        <th class="black text_white">
          <?=__('admin_metrics_views')?>
        </th>
        <th colspan="2">
          <?=__('admin_views_growth')?>
        </th>
        <th>
          <?=__('admin_views_old')?>
        </th>
        <th>
          <?=__('admin_metrics_activity')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <?php for($i = 0; $i < $stats_views['rows']; $i++) { ?>

      <tr>

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

        <td class="bold black text_white">
          <?=$stats_views[$i]['views']?>
        </td>

        <td>
          <?=$stats_views[$i]['growth']?>
        </td>

        <td>
          <?=$stats_views[$i]['pgrowth']?>
        </td>

        <td>
          <?=$stats_views[$i]['oldviews']?>
        </td>

        <td>
          <?=$stats_views[$i]['activity']?>
        </td>

      </tr>

      <?php } ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }