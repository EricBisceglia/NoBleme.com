<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/category_list";
$page_title_en    = "Compendium categories";
$page_title_fr    = "Compendium : Catégories";
$page_description = "Categorizations used to filter pages within NoBleme's 21st century culture compendium";

// Temporarily closed
if(!$is_admin)
  exit(header("Location: ".$path."pages/compendium/index_closed"));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch a list of categories
$compendium_categories_list = compendium_categories_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_30">

  <h1>
    <?=__link('pages/compendium/index', __('compendium_categories_title'), 'noglow')?>
    <?php if($is_admin) { ?>
    <?=__icon('settings', alt: 'E', title: __('settings'), title_case: 'initials', href: 'pages/compendium/category_admin')?>
    <?php } ?>
  </h1>

  <h5>
    <?=__link('pages/compendium/index', __('compendium_eras_subtitle'), 'noglow')?>
  </h5>

  <p class="bigpadding_bot">
    <?=__('compendium_categories_intro')?>
  </p>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_page_category')?>
        </th>
        <th>
          <?=__('compendium_eras_entries')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <?php for($i = 0; $i < $compendium_categories_list['rows']; $i++) { ?>

      <tr>

        <td>
          <?=__link('pages/compendium/category?id='.$compendium_categories_list[$i]['id'], $compendium_categories_list[$i]['name'])?>
        </td>

        <td>
          <?=$compendium_categories_list[$i]['count']?>
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