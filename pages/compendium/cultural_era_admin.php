<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/compendium.act.php';    # Actions
include_once './../../lang/compendium.lang.php';      # Translations
include_once './../../inc/bbcodes.inc.php';           # BBCodes
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../inc/functions_numbers.inc.php'; # Number formatting

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/cultural_era_admin";
$page_title_en    = "Compendium eras";
$page_title_fr    = "Compendium : Ères";

// Compendium admin menu selection
$compendium_admin_menu['eras'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Eras list

// Fetch a list of eras
$compendium_eras_list = compendium_eras_list();

// Fetch the list of pages without an era
$compendium_page_list = compendium_pages_list( search: array( 'era'       => -1           ,
                                                              'title'     => 'exists'     ,
                                                              'redirect'  => -1           ,
                                                              'wip'       => 'finished' ) );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_50 padding_top">

  <h2 class="align_center">
    <?=__link('pages/compendium/cultural_era_list', __('compendium_eras_title'), 'noglow')?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/compendium/cultural_era_add')?>
  </h2>

</div>

<div class="bigpadding_top width_50">

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
          <?=__('compendium_era_admin_name')?>
        </th>
        <th>
          <?=__('compendium_era_admin_short')?>
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
        <td>
          -
        </td>
        <td class="bold pointer">
          <?=__('compendium_era_admin_none')?>
        </td>
        <td>
          -
        </td>
        <td>
          <?=$compendium_page_list['rows']?>
        </td>
        <td>
          -
        </td>
      </tr>

      <?php for($i = 0; $i < $compendium_eras_list['rows']; $i++) { ?>

      <tr id="compendium_admin_era_row_<?=$compendium_eras_list[$i]['id']?>">

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
          <?=$compendium_eras_list[$i]['short']?>
        </td>

        <td>
          <?=$compendium_eras_list[$i]['count']?>
        </td>

        <td class="align_center">
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/cultural_era_edit?id='.$compendium_eras_list[$i]['id'])?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "compendium_era_delete('".$compendium_eras_list[$i]['id']."', '".__('compendium_era_delete_confirm')."')")?>
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