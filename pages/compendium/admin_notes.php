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
$page_url         = "pages/compendium/admin_notes";
$page_title_en    = "Compendium admin notes";
$page_title_fr    = "Compendium : Notes admin";

// Compendium admin menu selection
$compendium_admin_menu['notes'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the page list

$compendium_pages_list = compendium_pages_list( sort_by:  'page_url'            ,
                                                search:   array( 'notes' => 1 ) );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_70">

  <h2 class="padding_top bigpadding_bot align_center">
    <?=__link('pages/compendium/index', __('compendium_admin_notes_title'), 'noglow')?>
  </h2>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_list_admin_url')?>
        </th>
        <th>
          <?=__('compendium_admin_notes_text')?>
        </th>
        <th>
          <?=__('compendium_admin_notes_url')?>
        </th>
      </tr>

    </thead>

    <tbody class="altc">

      <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

      <tr>

        <?php if(!$compendium_pages_list[$i]['fullurl']) { ?>
        <td class="align_left nowrap">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['url'])?>
        </td>
        <?php } else { ?>
        <td class="align_left tooltip_container">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['urldisplay'])?>
          <div class="tooltip">
            <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['fullurl'])?>
          </div>
        </td>
        <?php } ?>

        <td class="align_left">
          <?=$compendium_pages_list[$i]['notes']?>
        </td>

        <td class="align_left nowrap">
          <?=$compendium_pages_list[$i]['urlnotes']?>
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