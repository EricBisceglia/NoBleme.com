<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/scheduler.act.php';   # Actions
include_once './../../lang/scheduler.lang.php';     # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/scheduler";
$page_title_en    = "Task scheduler";
$page_title_fr    = "Tâches planifiées";

// Extra JS
$js = array('dev/scheduler');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Close the edit popin if it is open

$onload = "popin_close('dev_scheduler_popin')";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Manually run the scheduler on demand

if(isset($_POST['dev_scheduler_run']))
{
  // Set the correct root path
  $scheduler_set_root_path = './../../';

  // Manually run the scheduler
  include_once './../../scripts/scheduler.php';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit an entry

if(isset($_POST['dev_scheduler_edit']))
  dev_scheduler_edit( form_fetch_element('dev_scheduler_edit', 0)   ,
                      form_fetch_element('dev_scheduler_edit_date') ,
                      form_fetch_element('dev_scheduler_edit_time') );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete an entry

// Delete a future task
if(isset($_POST['scheduler_task_delete']))
  dev_scheduler_delete_task(form_fetch_element('scheduler_task_delete', 0));

// Delete a scheduler log
if(isset($_POST['scheduler_log_delete']))
  dev_scheduler_delete_log(form_fetch_element('scheduler_log_delete', 0));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get the past and future tasks

// Fetch the search data
$scheduler_tasks_search = array(  'type'        =>  form_fetch_element('scheduler_search_type')         ,
                                  'id'          =>  form_fetch_element('scheduler_search_id')           ,
                                  'date'        =>  form_fetch_element('scheduler_search_date')         ,
                                  'description' =>  form_fetch_element('scheduler_search_description')  ,
                                  'report'      =>  form_fetch_element('scheduler_search_report')       );

$scheduler_tasks = dev_scheduler_list(  form_fetch_element('scheduler_search_order', 'date')  ,
                                        $scheduler_tasks_search                               );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get all existing task types

$scheduler_task_types = dev_scheduler_types_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_60">

  <h1 class="align_center bigpadding_bot">
    <form method="POST" id="dev_scheduler_run">
      <?=__('submenu_admin_scheduler')?>
      <input type="hidden" name="dev_scheduler_run" value="dev_scheduler_run">
      <?=__icon('settings_gear', alt: 'S', title: __('dev_scheduler_manual_run'), title_case: 'initials', onclick: "if(confirm('".__('dev_scheduler_manual_confirm')."')){ document.getElementById('dev_scheduler_run').submit(); }")?>
    </form>
  </h1>

  <form method="post">
    <fieldset>

      <div class="autoscroll">
        <table>
          <thead>

            <tr class="nowrap uppercase">
              <th>
                <?=__('type')?>
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "dev_scheduler_list_search('type');")?>
              </th>
              <th>
                <?=__('id')?>
              </th>
              <th>
                <?=__('dev_scheduler_task_execution')?>
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "dev_scheduler_list_search('date');")?>
              </th>
              <th>
                <?=__('description')?>
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "dev_scheduler_list_search('description');")?>
              </th>
              <th>
                <?=__('dev_scheduler_task_report')?>
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "dev_scheduler_list_search('report');")?>
              </th>
              <th>
                <?=__('action')?>
              </th>
            </tr>

            <tr>

              <th>
                <input type="hidden" class="hidden" name="scheduler_sort_order" id="scheduler_search_order" value="date">
                <select class="table_search" name="scheduler_search_type" id="scheduler_search_type" onchange="dev_scheduler_list_search();">
                  <option value="0">&nbsp;</option>
                  <?php for($i = 0; $i < $scheduler_task_types['rows'] ; $i++) { ?>
                  <option value="<?=$scheduler_task_types[$i]['type']?>"><?=$scheduler_task_types[$i]['type']?></option>
                  <?php } ?>
                </select>
              </th>

              <th>
                <input type="text" class="table_search" name="scheduler_search_id" id="scheduler_search_id" value="" size="2" onkeyup="dev_scheduler_list_search();">
              </th>

              <th>
                <select class="table_search" name="scheduler_search_date" id="scheduler_search_date" onchange="dev_scheduler_list_search();">
                  <option value="0">&nbsp;</option>
                  <option value="1"><?=__('dev_scheduler_task_execution_future')?></option>
                  <option value="2"><?=__('dev_scheduler_task_execution_past')?></option>
                </select>
              </th>

              <th>
                <input type="text" class="table_search" name="scheduler_search_description" id="scheduler_search_description" value="" onkeyup="dev_scheduler_list_search();">
              </th>

              <th>
                <input type="text" class="table_search" name="scheduler_search_report" id="scheduler_search_report" value="" onkeyup="dev_scheduler_list_search();">
              </th>

              <th>
                &nbsp;
              </th>

            </tr>

          </thead>

          <?php } ?>

          <tbody class="altc2 align_center" id="scheduler_list_tbody">

            <tr>
              <td colspan="6" class="uppercase text_light dark bold align_center">
                <?=__('dev_scheduler_task_results', 0, 0, 0, array($scheduler_tasks['rows'], $scheduler_tasks['rows_future'], $scheduler_tasks['rows_past']))?>
              </td>
            </tr>

            <?php for($i = 0; $i < $scheduler_tasks['rows'] ; $i++) { ?>

            <?php if($i && $scheduler_tasks['sort'] === 'date' && $scheduler_tasks[$i]['type'] !== $scheduler_tasks[$i-1]['type']) { ?>

            <tr>
              <td colspan="6" class="dark">
                &nbsp;
              </td>
            </tr>
            <tr class="hidden">
              <td colspan="6" class="dark">
                &nbsp;
              </td>
            </tr>

            <?php } ?>

            <tr>

              <td class="nowrap">
                <?=$scheduler_tasks[$i]['task_type']?>
              </td>

              <td class="nowrap">
                <?=$scheduler_tasks[$i]['task_id']?>
              </td>

              <td class="nowrap">
                <span class="tooltip_container tooltip_desktop">
                <?=$scheduler_tasks[$i]['date']?>
                  <span class="tooltip notbold">
                    <?=$scheduler_tasks[$i]['fdate']?>
                  </span>
                </span>
              </td>

              <?php if($scheduler_tasks[$i]['fdescription']) { ?>
              <td>
                <span class="tooltip_container tooltip_desktop">
                <?=$scheduler_tasks[$i]['description']?>
                  <span class="tooltip notbold">
                    <?=$scheduler_tasks[$i]['fdescription']?>
                  </span>
                </span>
              </td>
              <?php } else { ?>
                <td>
                <?=$scheduler_tasks[$i]['description']?>
              </td>
              <?php } ?>

              <?php if($scheduler_tasks[$i]['freport']) { ?>
              <td>
                <span class="tooltip_container tooltip_desktop">
                <?=$scheduler_tasks[$i]['report']?>
                  <span class="tooltip notbold">
                    <?=$scheduler_tasks[$i]['freport']?>
                  </span>
                </span>
              </td>
              <?php } else { ?>
              <td>
                <?=$scheduler_tasks[$i]['report']?>
              </td>
              <?php } ?>

              <td class="align_center nowrap">
                <?php if($scheduler_tasks[$i]['type'] === 'future') { ?>
                <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: '?', title: __('edit'), title_case: 'initials', onclick: "dev_scheduler_edit_popin('".$scheduler_tasks[$i]['id']."', '".$scheduler_tasks[$i]['type']."');")?>
                <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "dev_scheduler_delete_task('".$scheduler_tasks[$i]['id']."', '".__('dev_scheduler_delete_task')."');")?>
                <?php } else { ?>
                <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "dev_scheduler_delete_log('".$scheduler_tasks[$i]['id']."', '".__('dev_scheduler_delete_log')."');")?>
                <?php } ?>
              </td>

            </tr>

            <?php } ?>

          </tbody>

          <?php if(!page_is_fetched_dynamically()) { ?>

        </table>
      </div>

    </fieldset>
  </form>

</div>

<div id="dev_scheduler_popin" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('dev_scheduler_popin');">&times;</a>
    <div id="dev_scheduler_popin_body">
      &nbsp;
    </div>
  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }
