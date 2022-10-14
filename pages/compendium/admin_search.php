<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/admin_search";
$page_title_en    = "Compendium search";
$page_title_fr    = "Compendium : recherche";

// Compendium admin menu selection
$compendium_admin_menu['search'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Perform a search

// Execute the search
if(isset($_POST['compendium_admin_search_query']))
  $compendium_admin_search = compendium_search($_POST['compendium_admin_search_query']);

// Prepare the search string
$compendium_admin_search_query = sanitize_output(form_fetch_element('compendium_admin_search_query'));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_30">

  <h2 class="padding_top bigpadding_bot align_center">
    <?=__('compendium_admin_search_title')?>
  </h2>

  <form method="POST" class="bigpadding_bot">
    <fieldset>

      <label for="compendium_admin_search_query"><?=__('compendium_admin_search_label')?></label>
      <input type="text" class="indiv" id="compendium_admin_search_query" name="compendium_admin_search_query" value="<?=$compendium_admin_search_query?>">

      <div class="smallpadding_top">
        <input type="submit" name="compendium_admin_search_submit" value="<?=__('search')?>">
      </div>

    </fieldset>
  </form>

</div>

<div class="width_30 autoscroll">

  <?php if(isset($compendium_admin_search)) { ?>

  <table class="nowrap">
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('contents')?>
        </th>
        <th>
          <?=__('title')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc2">

      <tr>
        <td colspan="2" class="uppercase text_light dark bold align_center">
          <?=__('compendium_admin_search_results', amount: $compendium_admin_search['count'], preset_values: array($compendium_admin_search['count']))?>
        </td>
      </tr>

      <?php for($i = 0; $i < $compendium_admin_search['count']; $i++) { ?>

      <?php if($i < ($compendium_admin_search['count'] - 1) && $compendium_admin_search[$i]['type'] != $compendium_admin_search[$i+1]['type']) { ?>

      <tr class="row_separator_dark">

      <?php } else { ?>

      <tr>

      <?php } ?>

        <td class="align_center">
          <?=$compendium_admin_search[$i]['type']?>
        </td>
        <td>
          <?=__link($compendium_admin_search[$i]['url'], $compendium_admin_search[$i]['title'])?>
        </td>
      </tr>

      <?php } ?>

    </tbody>
  </table>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }