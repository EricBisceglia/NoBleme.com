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

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/category_admin";
$page_title_en    = "Compendium categories";
$page_title_fr    = "Compendium : Catégories";

// Compendium admin menu selection
$compendium_admin_menu['categories'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Category list

// Fetch a list of categories
$compendium_categories_list = compendium_categories_list();

// Fetch the list of uncategorized pages
$compendium_page_list = compendium_pages_list( search: array( 'category'  => -1       ,
                                                              'title'     => 'exists' ,
                                                              'redirect'  => -1       ) );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_50 padding_top">

  <h2 class="align_center">
    <?=__link('pages/compendium/category_list', __('compendium_categories_title'), 'noglow')?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/category_add')?>
  </h2>

</div>

<div class="bigpadding_top width_40">

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_category_admin_order')?>
        </th>
        <th>
          <?=__('compendium_page_category')?>
        </th>
        <th>
          <?=__('compendium_eras_entries')?>
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <tr>
        <td>
          -
        </td>
        <td class="bold pointer">
          <?=__('compendium_category_admin_uncategorized')?>
        </td>
        <td>
          <?=$compendium_page_list['rows']?>
        </td>
        <td>
          -
        </td>
      </tr>

      <?php for($i = 0; $i < $compendium_categories_list['rows']; $i++) { ?>

      <tr id="compendium_admin_category_row_<?=$compendium_categories_list[$i]['id']?>">

        <td>
          <?=$compendium_categories_list[$i]['order']?>
        </td>

        <td>
          <?=__link('pages/compendium/category?id='.$compendium_categories_list[$i]['id'], $compendium_categories_list[$i]['name'])?>
        </td>

        <td>
          <?=$compendium_categories_list[$i]['count']?>
        </td>

        <td class="align_center">
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/category_edit?id='.$compendium_categories_list[$i]['id'])?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "compendium_category_delete('".$compendium_categories_list[$i]['id']."', '".__('compendium_category_delete_confirm')."')")?>
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