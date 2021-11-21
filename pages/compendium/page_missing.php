<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/page_missing";
$page_title_en    = "Compendium missing pages";
$page_title_fr    = "Compendium : pages manquantes";

// Compendium admin menu selection
$compendium_admin_menu['missing'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/list', 'compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the missing pages

// Fetch the sorting order
$compendium_missing_sort_order = form_fetch_element('compendium_missing_sort_order', 'url');

// Assemble the search query
$compendium_missing_search = array( 'url' => form_fetch_element('compendium_missing_url') );

// Fetch the missing pages
$compendium_missing_list = compendium_missing_list( sort_by:  $compendium_missing_sort_order  ,
                                                    search:   $compendium_missing_search      );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_30">

  <h2 class="padding_top bigpadding_bot align_center">
    <?=__('compendium_missing_title')?>
  </h2>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_list_admin_url')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "compendium_image_list_search('url');")?>
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="compendium_missing_sort_order" id="compendium_missing_sort_order" value="<?=$compendium_missing_sort_order?>">
          <input type="text" class="table_search" name="compendium_missing_url" id="compendium_missing_url" value="" onkeyup="compendium_missing_list_search();">
        </th>

        <th>
          &nbsp;
        </th>

      </tr>

    </thead>

    <tbody class="altc2 nowrap" id="compendium_missing_list_tbody">

      <?php } ?>

      <tr>
        <td colspan="2" class="uppercase text_light dark bold align_center">
          <?=__('compendium_missing_count', preset_values: array(($compendium_missing_list['rows'] + count($compendium_missing_list['missing']))))?>
        </td>
      </tr>

      <?php for($i = 0; $i < $compendium_missing_list['rows']; $i++) { ?>

      <tr>

        <td class="align_left nbcode_dead_link noglow">
          <?=$compendium_missing_list[$i]['url']?>
        </td>

        <td class="align_center nowrap">
          <?=__icon('add', is_small: true, class: 'valign_middle pointer spaced_right', alt: '+', title: __('add'), title_case: 'initials')?>
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/missing_edit?id='.$compendium_missing_list[$i]['id'])?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'X', title: __('delete'), title_case: 'initials')?>
        </td>

      </tr>

      <?php } ?>

      <?php for($i = 0; $i < count($compendium_missing_list['missing']); $i++) { ?>

      <tr>

        <td class="align_left nbcode_dead_link noglow">
          <?=$compendium_missing_list['missing'][$i]?>
        </td>

        <td class="align_center nowrap">
          <?=__icon('add', is_small: true, class: 'valign_middle pointer spaced_right', alt: '+', title: __('add'), title_case: 'initials')?>
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced_right', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/missing_edit?name='.$compendium_missing_list['missing'][$i])?>
        </td>

      </tr>

      <?php } ?>

      <?php if(!page_is_fetched_dynamically()) { ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }