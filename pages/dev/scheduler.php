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
// Get the past and future tasks

$scheduler_tasks = dev_scheduler_list();




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
              <?=__('id')?>
            </th>
            <th>
              <?=__('type')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'type')?>">
            </th>
            <th>
              <?=__('dev_scheduler_task_execution')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'date')?>">
            </th>
            <th>
              <?=__('dev_scheduler_task_description')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'description')?>">
            </th>
            <th>
              <?=__('dev_scheduler_task_report')?>
              <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'report')?>">
            </th>
            <th>
              <?=__('action')?>
            </th>
          </tr>

          <tr>

            <th>
              &nbsp;
            </th>

            <th>
              <select class="table_search" name="example_select" id="example_select">
                <option value="0">Option</option>
              </select>
            </th>

            <th>
              <select class="table_search" name="example_select" id="example_select">
                <option value="0">Option</option>
              </select>
            </th>

            <th>
              <input type="text" class="table_search" name="example_input" id="example_input" value="">
            </th>

            <th>
              <input type="text" class="table_search" name="example_input" id="example_input" value="">
            </th>

            <th>
              &nbsp;
            </th>

          </tr>

        </thead>
        <tbody class="altc2 align_center">

          <tr>
            <td colspan="6" class="uppercase text_light dark bold align_center">
              <?=__('dev_scheduler_task_results', 0, 0, 0, array($scheduler_tasks['rows'], $scheduler_tasks['rows_past'], $scheduler_tasks['rows_future']))?>
            </td>
          </tr>

          <?php for($i = 0; $i < $scheduler_tasks['rows'] ; $i++) { ?>

          <?php if($i && $scheduler_tasks[$i]['type'] != $scheduler_tasks[$i-1]['type']) { ?>

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
              <?=$scheduler_tasks[$i]['task_id']?>
            </td>

            <td>
              <?=$scheduler_tasks[$i]['task_type']?>
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
              <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete">
            </td>

          </tr>

          <?php } ?>

        </tbody>
      </table>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }
