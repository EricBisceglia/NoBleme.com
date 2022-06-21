<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/blog_stats";
$page_title_en    = "Devblog statistics";
$page_title_fr    = "Statistiques des blogs de développement";
$page_description = "Statistics generated from NoBleme's development blogs";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch devblog stats

$dev_blogs_stats = dev_blogs_stats();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_30">

  <h1>
    <?=__link('pages/dev/blog_list', __('dev_blog_title+'), 'noglow')?>
  </h1>

  <h5 class="padding_bot">
    <?=__link('pages/dev/blog_list', __('dev_blog_stats_subtitle'), 'noglow')?>
  </h5>

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('year')?>
        </th>

        <th>
          <?=__('dev_blog_title+')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = date('Y'); $i >= $dev_blogs_stats['oldest_year']; $i--) { ?>

      <tr>

        <td class="bold">
          <?php if($dev_blogs_stats['count_'.$i]) { ?>
          <?=__link('pages/dev/blog_list?year='.$i, $i)?>
          <?php } else { ?>
          <?=$i?>
          <?php } ?>
        </td>

        <td class="bold">
          <?=$dev_blogs_stats['count_'.$i]?>
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