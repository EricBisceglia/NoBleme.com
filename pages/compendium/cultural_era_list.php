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
$page_url         = "pages/compendium/cultural_era_list";
$page_title_en    = "Compendium eras";
$page_title_fr    = "Compendium : Périodes";
$page_description = "Cultural eras of 21st culture";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch a list of eras
$compendium_eras_list = compendium_eras_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/compendium/index', __('compendium_eras_title'), 'noglow')?>
    <?php if($is_admin) { ?>
    <?=__icon('settings', alt: 'E', title: __('settings'), title_case: 'initials', href: 'pages/compendium/cultural_era_admin')?>
    <?php } ?>
  </h1>

  <h5>
    <?=__link('pages/compendium/index', __('submenu_pages_compendium_index'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_eras_intro_1')?>
  </p>

  <p>
    <?=__('compendium_eras_intro_2')?>
  </p>

  <p class="bigpadding_bot">
    <?=__('compendium_eras_intro_3')?>
  </p>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_eras_start')?>
        </th>
        <th>
          <?=__('compendium_eras_end')?>
        </th>
        <th>
          <?=__('compendium_eras_name')?>
        </th>
        <th>
          <?=__('compendium_eras_entries')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <?php for($i = 0; $i < $compendium_eras_list['rows']; $i++) { ?>

      <tr>

        <td>
          <?=$compendium_eras_list[$i]['start']?>
        </td>

        <td>
          <?=$compendium_eras_list[$i]['end']?>
        </td>

        <td>
          <?=__link('pages/compendium/cultural_era?era='.$compendium_eras_list[$i]['id'], $compendium_eras_list[$i]['name'])?>
        </td>

        <td>
          <?=$compendium_eras_list[$i]['count']?>
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