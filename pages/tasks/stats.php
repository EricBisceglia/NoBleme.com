<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../actions/tasks.act.php';             # Actions
include_once './../../lang/tasks.lang.php';               # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/stats";
$page_title_en    = "Tasks statistics";
$page_title_fr    = "Statistiques des tâches";
$page_description = "Statistics generated from the tasks in NoBleme's to-do list";

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
$tasks_selector_entries = array(  'overall'       ,
                                  'years'         ,
                                  'milestones'    ,
                                  'categories'    ,
                                  'priority'      ,
                                  'velocity'      ,
                                  'contributors'  );

// Define the default dropdown menu entry
$tasks_selector_default = 'overall';

// Initialize the page section selector data
$tasks_selector = page_section_selector(           $tasks_selector_entries  ,
                                          default: $tasks_selector_default  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recalculate all stats

if(isset($_GET['recalculate']) && user_is_administrator())
{
  // Recalculate the stats
  tasks_recalculate_all_stats();

  // Reload the page in its default state
  exit(header("Location: ".$path."pages/tasks/stats"));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch tasks stats

$tasks_stats = tasks_stats();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>

      <?=__link('pages/tasks/list', __('tasks_stats_selector_title').__(':'), style: 'noglow')?>

      <select class="inh align_left" id="tasks_stats_selector" onchange="page_section_selector('tasks_stats', '<?=$tasks_selector_default?>');">
        <option value="overall"<?=$tasks_selector['menu']['overall']?>><?=__('stats_overall')?></option>
        <option value="years"<?=$tasks_selector['menu']['years']?>><?=__('stats_timeline')?></option>
        <option value="years"<?=$tasks_selector['menu']['milestones']?>><?=__('tasks_stats_selector_milestones')?></option>
        <option value="years"<?=$tasks_selector['menu']['categories']?>><?=__('tasks_stats_selector_categories')?></option>
        <option value="years"<?=$tasks_selector['menu']['priority']?>><?=__('tasks_stats_selector_priority')?></option>
        <option value="years"<?=$tasks_selector['menu']['velocity']?>><?=__('tasks_stats_selector_velocity')?></option>
        <option value="years"<?=$tasks_selector['menu']['contributors']?>><?=__('tasks_stats_selector_submitted')?></option>
      </select>

      <?php if($is_admin) { ?>
      <?=__icon('refresh', alt: 'R', title: __('tasks_stats_recalculate_button'), title_case: 'initials', class: 'valign_middle pointer spaced_left', href: 'pages/tasks/stats?recalculate', confirm: __('tasks_stats_recalculate_alert'))?>
      <?php } ?>

    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ OVERALL ***************************************************/ ?>

<div class="width_50 padding_top tasks_stats_section<?=$tasks_selector['hide']['overall']?>" id="tasks_stats_overall">

  <p class="align_center padding_bot">
    <?=__('tasks_stats_overall_summary', preset_values: array($tasks_stats['total']))?>
  </p>

  <p class="align_center padding_bot">
    <?=__('tasks_stats_overall_unsolved', preset_values: array($tasks_stats['unsolved'], $tasks_stats['percent_unsolved']))?><br>
    <?=__('tasks_stats_overall_solved', preset_values: array($tasks_stats['solved'], $tasks_stats['percent_solved']))?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }