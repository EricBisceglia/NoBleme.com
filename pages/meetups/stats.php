<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../actions/meetups.act.php';           # Actions
include_once './../../lang/meetups.lang.php';             # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/stats";
$page_title_en    = "Meetups statistics";
$page_title_fr    = "Statistiques des IRL";
$page_description = "Statistics generated from NoBleme's real life meetups";

// Extra JS
$js = array('common/toggle', 'common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$meetups_selector_entries = array(  'overall'   ,
                                    'people'    ,
                                    'locations' ,
                                    'years'     );

// Define the default dropdown menu entry
$meetups_selector_default = 'overall';

// Initialize the page section selector data
$meetups_selector = page_section_selector(            $meetups_selector_entries ,
                                            default:  $meetups_selector_default );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recalculate all stats

if(isset($_GET['recalculate']) && user_is_administrator())
{
  // Recalculate the stats
  meetups_recalculate_all_stats();

  // Reload the page in its default state
  exit(header("Location: ".$path."pages/meetups/stats"));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>

      <?=__link('pages/meetups/list', __('meetups_selector_title').__(':'), style: 'noglow')?>

      <select class="inh align_left" id="meetups_stats_selector" onchange="page_section_selector('meetups_stats', '<?=$meetups_selector_default?>');">
        <option value="overall"<?=$meetups_selector['menu']['overall']?>><?=__('meetups_stats_selector_overall')?></option>
        <option value="people"<?=$meetups_selector['menu']['people']?>><?=__('meetups_stats_selector_people')?></option>
        <option value="locations"<?=$meetups_selector['menu']['locations']?>><?=__('meetups_stats_selector_locations')?></option>
        <option value="years"<?=$meetups_selector['menu']['years']?>><?=__('meetups_stats_selector_years')?></option>
      </select>

      <?php if($is_admin) { ?>
      <?=__icon('refresh', alt: 'R', title: __('meetups_stats_recalculate_button'), title_case: 'initials', class: 'valign_middle pointer spaced_left', href: 'pages/meetups/stats?recalculate', confirm: __('meetups_stats_recalculate_alert'))?>
      <?php } ?>

    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ OVERALL ***************************************************/ ?>

<div class="width_50 padding_top meetups_stats_section<?=$meetups_selector['hide']['overall']?>" id="meetups_stats_overall">

  &nbsp;

</div>




<?php /************************************************* PEOPLE ***************************************************/ ?>

<div class="width_60 padding_top autoscroll meetups_stats_section<?=$meetups_selector['hide']['people']?>" id="meetups_stats_people">

  &nbsp;

</div>




<?php /************************************************ LOCATIONS *************************************************/ ?>

<div class="width_60 padding_top autoscroll meetups_stats_section<?=$meetups_selector['hide']['locations']?>" id="meetups_stats_locations">

  &nbsp;

</div>




<?php /************************************************** YEARS ***************************************************/ ?>

<div class="width_30 padding_top autoscroll meetups_stats_section<?=$meetups_selector['hide']['years']?>" id="meetups_stats_years">

  &nbsp;

</div>




<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }