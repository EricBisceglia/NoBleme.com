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

// Check if the user is the maintainer
$is_maintainer = user_is_maintainer();

// Fetch the devblogs
$devblogs = dev_blogs_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('dev_blog_title')?>
    <?php if($is_maintainer) { ?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/dev/blog_add')?>
    <?php } ?>
  </h1>

  <h5>
    <?=__('dev_blog_subtitle')?>
  </h5>

  <p class="bigpadding_bot">
    <?=__('dev_blog_intro')?>
  </p>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('dev_blog_table_title')?>
        </th>
        <th>
          <?=__('dev_blog_table_date')?>
        </th>
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