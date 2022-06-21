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
$page_url         = "pages/dev/blog_list";
$page_title_en    = "Devblog";
$page_title_fr    = "Blog de développement";
$page_description = "Blogs containing updates on NoBleme's development over the years";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the devblogs list

// Check if the list should be sorted by views
$blogs_sort = ($is_admin && isset($_GET['views'])) ? 'views' : '';

// Check if the list should be filtered for a year
$blogs_year = (isset($_GET['year'])) ? (int)form_fetch_element('year', request_type: 'GET') : 0;

// Fetch the devblogs
$devblogs = dev_blogs_list( $blogs_sort ,
                            $blogs_year );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<?php if($is_admin) { ?>
<div class="width_60">
<?php } else { ?>
<div class="width_50">
<?php } ?>

  <h1>
    <?=__('dev_blog_title')?>
    <?=__icon('stats', alt: 's', title: string_change_case(__('statistics'), 'initials'), href: "pages/dev/blog_stats")?>
    <?php if($is_admin) { ?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/dev/blog_add')?>
    <?php } ?>
  </h1>

  <h5>
    <?=__('dev_blog_subtitle')?>
  </h5>

  <?php if($blogs_year) { ?>

  <p class="smallpadding_bot">
    <?=__('dev_blog_intro')?>
  </p>

  <p class="bold">
    <?=__('dev_blog_filtered', preset_values: array($blogs_year))?>
  </p>

  <p class="bigpadding_bot">
    <?=__link('pages/dev/blog_list', __('dev_blog_see_all'))?>
  </p>

  <?php } else { ?>

  <p class="bigpadding_bot">
    <?=__('dev_blog_intro')?>
  </p>

  <?php } ?>

  <table>
    <thead>

      <tr class="uppercase">

        <th>
          <?=__('title')?>
        </th>

        <th>
          <?=__('dev_blog_table_date')?>
          <?php if($is_admin) { ?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', href: 'pages/dev/blog_list')?>
          <?php } ?>
        </th>

        <?php if($is_admin) { ?>

        <th>
          <?=__('view+')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', href: 'pages/dev/blog_list?views')?>
        </th>

        <th>
          <?=__('language+')?>
        </th>

        <?php } ?>

      </tr>

    </thead>
    <tbody class="altc align_center">

      <?php for($i = 0; $i < $devblogs['rows']; $i++) { ?>

      <tr>

        <td>
          <?php if($devblogs[$i]['deleted']) { ?>
          <?=__link('pages/dev/blog?id='.$devblogs[$i]['id'], $devblogs[$i]['title'], style: 'text_red bold')?>
          [<?=__('deleted')?>]
          <?php } else { ?>
          <?=__link('pages/dev/blog?id='.$devblogs[$i]['id'], $devblogs[$i]['title'])?>
          <?php } ?>
        </td>

        <td>
          <?=$devblogs[$i]['date']?>
        </td>

        <?php if($is_admin) { ?>

        <td>
          <?=$devblogs[$i]['views']?>
        </td>

        <td>
          <?php if($devblogs[$i]['lang_en']) { ?>
          <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle smallicon" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
          <?php } if($devblogs[$i]['lang_fr']) { ?>
            <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle smallicon" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
          <?php } ?>
        </td>

        <?php } ?>

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