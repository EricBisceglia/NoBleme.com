<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/bbcodes.inc.php';               # BBCodes
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../actions/compendium.act.php';        # Actions
include_once './../../lang/compendium.lang.php';          # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/stats";
$page_title_en    = "Compendium statistics";
$page_title_fr    = "Statistiques du compendium";
$page_description = "Statistics generated from NoBleme's 21st century compendium, a documentation of popular culture in the Internet age";

// Extra CSS & JS
$js = array('common/toggle', 'common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$compendium_selector_entries = array( 'overall'     ,
                                      'years'       ,
                                      'types'       ,
                                      'eras'        ,
                                      'categories'  ,
                                      'missing'     );

// Define the default dropdown menu entry
$compendium_selector_default = 'overall';

// Initialize the page section selector data
$compendium_selector = page_section_selector(           $compendium_selector_entries  ,
                                              default:  $compendium_selector_default  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch compendium stats

$compendium_stats = compendium_stats_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>

      <?=__link('pages/compendium/index', __('compendium_page_compendium').__(':'), style: 'noglow')?>

      <select class="inh align_left" id="compendium_stats_selector" onchange="page_section_selector('compendium_stats', '<?=$compendium_selector_default?>');">
        <option value="overall"<?=$compendium_selector['menu']['overall']?>><?=__('stats_overall')?></option>
        <option value="years"<?=$compendium_selector['menu']['years']?>><?=__('stats_timeline')?></option>
        <option value="types"<?=$compendium_selector['menu']['types']?>><?=__('submenu_pages_compendium_types')?></option>
        <option value="eras"<?=$compendium_selector['menu']['eras']?>><?=__('submenu_pages_compendium_eras')?></option>
        <option value="categories"<?=$compendium_selector['menu']['categories']?>><?=string_change_case(__('category+'), 'initials')?></option>
        <option value="missing"<?=$compendium_selector['menu']['missing']?>><?=__('compendium_missing_title')?></option>
      </select>

    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ OVERALL ***************************************************/ ?>

<div class="width_50 padding_top compendium_stats_section<?=$compendium_selector['hide']['overall']?>" id="compendium_stats_overall">

  <p class="align_center big padding_bot">
    <?=__('compendium_stats_overall_pages', preset_values: array($compendium_stats['pages']))?>
  </p>

  <p class="align_center">
    <?=__('compendium_stats_overall_nsfw', amount: $compendium_stats['nsfw'], preset_values: array($compendium_stats['nsfw'], $compendium_stats['nsfwp']))?><br>
    <?=__('compendium_stats_overall_gross', amount: $compendium_stats['gross'], preset_values: array($compendium_stats['gross'], $compendium_stats['grossp']))?><br>
    <?=__('compendium_stats_overall_offensive', amount: $compendium_stats['offensive'], preset_values: array($compendium_stats['offensive'], $compendium_stats['offensivep']))?>
  </p>

</div>



<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }