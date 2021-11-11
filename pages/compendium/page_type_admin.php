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
$page_url         = "pages/compendium/page_type_admin";
$page_title_en    = "Compendium page types";
$page_title_fr    = "Compendium : Thématiques";

// Compendium admin menu selection
$compendium_admin_menu['page_types'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page type list

// Fetch a list of page types
$compendium_types_list = compendium_types_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_50 padding_top">

  <h2 class="align_center">
    <?=__link('pages/compendium/page_type_list', __('compendium_types_title'), 'noglow')?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/page_type_add')?>
  </h2>

</div>

<div class="bigpadding_top width_50">

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_category_admin_order')?>
        </th>
        <th>
          <?=__('compendium_type_admin_short')?>
        </th>
        <th>
          <?=__('compendium_type_admin_long')?>
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

      <?php for($i = 0; $i < $compendium_types_list['rows']; $i++) { ?>

      <tr id="compendium_admin_type_row_<?=$compendium_types_list[$i]['id']?>">

        <td>
          <?=$compendium_types_list[$i]['order']?>
        </td>

        <td>
          <?=__link('pages/compendium/page_type?type='.$compendium_types_list[$i]['id'], $compendium_types_list[$i]['name'])?>
        </td>

        <td>
          <?=$compendium_types_list[$i]['full']?>
        </td>

        <td>
          <?=$compendium_types_list[$i]['count']?>
        </td>

        <td class="align_center">
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/page_type_edit?id='.$compendium_types_list[$i]['id'])?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "compendium_type_delete('".$compendium_types_list[$i]['id']."', '".__('compendium_type_delete_confirm')."')")?>
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