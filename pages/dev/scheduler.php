<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';       # Core
include_once './../../inc/functions_time.inc.php'; # Time management
include_once './../../actions/dev.act.php';        # Actions
include_once './../../lang/dev.lang.php';          # Translations

// Limit page access rights
user_restrict_to_administrators($lang);

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
// Delete an entry

// Delete a future task
if(isset($_POST['scheduler_task_delete']))
  dev_scheduler_delete_task(  form_fetch_element('scheduler_task_delete', 0) ,
                              $lang                                         );

// Delete a scheduler log
if(isset($_POST['scheduler_log_delete']))
  dev_scheduler_delete_log( form_fetch_element('scheduler_log_delete', 0) ,
                            $lang                                         );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get the past and future tasks

$scheduler_tasks = dev_scheduler_list(  form_fetch_element('scheduler_search_order', 'date')  ,
                                        form_fetch_element('scheduler_search_type')           ,
                                        form_fetch_element('scheduler_search_id')             ,
                                        form_fetch_element('scheduler_search_date')           ,
                                        form_fetch_element('scheduler_search_description')    ,
                                        form_fetch_element('scheduler_search_report')         );




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
    <?=__('dev_scheduler_title')?>
  </h1>

  <form method="post">
    <fieldset>

      <table>
        <thead>

          <tr class="nowrap uppercase">
            <th>
              <?=__('type')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'type')?>" onclick="dev_scheduler_list_search('type');">
            </th>
            <th>
              <?=__('id')?>
            </th>
            <th>
              <?=__('dev_scheduler_task_execution')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'date')?>" onclick="dev_scheduler_list_search('date');">
            </th>
            <th>
              <?=__('dev_scheduler_task_description')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'description')?>" onclick="dev_scheduler_list_search('description');">
            </th>
            <th>
              <?=__('dev_scheduler_task_report')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'report')?>" onclick="dev_scheduler_list_search('report');">
            </th>
            <th>
              <?=__('action')?>
            </th>
          </tr>

          <tr>

            <th>
              <input type="hidden" class="hidden" name="scheduler_sort_order" id="scheduler_search_order" value="date">
              <select class="table_search" name="scheduler_search_type" id="scheduler_search_type" onchange="dev_scheduler_list_search();">
                <option value="0"></option>
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
                <option value="0"></option>
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

          <?php if($i && $scheduler_tasks['sort'] == 'date' && $scheduler_tasks[$i]['type'] != $scheduler_tasks[$i-1]['type']) { ?>

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

            <td>
              <?=$scheduler_tasks[$i]['task_type']?>
            </td>

            <td>
              <?=$scheduler_tasks[$i]['task_id']?>
            </td>

            <td class="nowrap">
              <?=$scheduler_tasks[$i]['date']?>
            </td>

            <?php if($scheduler_tasks[$i]['fdescription']) { ?>
            <td>
              <span class="tooltip_container">
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
              <span class="tooltip_container">
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
              <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/edit_small.svg" alt="?" title="Edit">
              <?php if($scheduler_tasks[$i]['type'] == 'future') { ?>
              <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete" onclick="dev_scheduler_delete_task('<?=$scheduler_tasks[$i]['id']?>', '<?=__('dev_scheduler_delete_task')?>');">
              <?php } else { ?>
              <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete" onclick="dev_scheduler_delete_log('<?=$scheduler_tasks[$i]['id']?>', '<?=__('dev_scheduler_delete_log')?>');">
              <?php } ?>
            </td>

          </tr>

          <?php } ?>

        </tbody>

        <?php if(!page_is_fetched_dynamically()) { ?>

      </table>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }
