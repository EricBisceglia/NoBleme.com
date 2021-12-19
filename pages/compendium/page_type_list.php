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
$page_url         = "pages/compendium/page_type_list";
$page_title_en    = "Compendium types";
$page_title_fr    = "Compendium : Thèmes";
$page_description = "List of page types present of NoBleme's 21st century culture compendium";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch a list of page types
$compendium_types_list = compendium_types_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_30">

  <h1>
    <?=__link('pages/compendium/index', __('compendium_types_title'), 'noglow')?>
    <?php if($is_admin) { ?>
    <?=__icon('settings', alt: 'E', title: __('settings'), title_case: 'initials', href: 'pages/compendium/page_type_admin')?>
    <?php } ?>
  </h1>

  <h5>
    <?=__link('pages/compendium/index', __('compendium_eras_subtitle'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_types_intro_1')?>
  </p>

  <p class="bigpadding_bot">
    <?=__('compendium_types_intro_2')?>
  </p>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_page_type')?>
        </th>
        <th>
          <?=__('compendium_eras_entries')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <?php for($i = 0; $i < $compendium_types_list['rows']; $i++) { ?>

      <tr>

        <td>
          <?=__link('pages/compendium/page_type?type='.$compendium_types_list[$i]['id'], $compendium_types_list[$i]['name'])?>
        </td>

        <td>
          <?=$compendium_types_list[$i]['count']?>
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