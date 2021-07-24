<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/functions_time.inc.php';        # Time management
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../actions/tasks.act.php';             # Actions
include_once './../../lang/tasks.lang.php';               # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/list";
$page_title_en    = "To-do list";
$page_title_fr    = "Liste des tâches";
$page_description = "List of tasks laying the roadmap for NoBleme's past and future development";

// Extra CSS
$css = array('tasks');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Task list

// Fetch the tasks
$task_list = tasks_list();

// Compute the number of columns depending on the what the user is allowed to see
$tasks_rows_desktop = ($is_admin) ? 8 : 7;
$tasks_rows_mobile  = 4;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_todolist')?>
  </h1>

  <h5>
    <?=__('tasks_list_subtitle')?>
  </h5>

  <p>
    <?=__('tasks_list_body_1')?>
  </p>

  <p>
    <?=__('tasks_list_body_2')?>
  </p>

</div>

<div class="width_80 bigpadding_top">

  <table>
    <thead>

      <tr class="uppercase nowrap">

        <th>
          <?=__('id')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>

        <th>
          <?=__('tasks_list_description')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>

        <th>
          <?=__('tasks_list_status')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>

        <th>
          <?=__('tasks_list_created')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>

        <th class="desktop">
          <?=__('tasks_list_reporter')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>

        <th class="desktop">
          <?=__('tasks_list_category')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>

        <th class="desktop">
          <?=__('tasks_list_goal')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>

        <?php if($is_admin) { ?>
        <th class="desktop">
          <?=__('admin')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
        </th>
        <?php } ?>

      </tr>

      <tr>

        <th>
          <input type="text" class="table_search" name="tasks_search_id" id="tasks_search_id" value="" size="1">
        </th>

        <th>
          <input type="text" class="table_search" name="tasks_search_description" id="tasks_search_description" value="">
        </th>

        <th>
          <select class="table_search" name="tasks_search_status" id="tasks_search_status">
            <option value="0">&nbsp;</option>
          </select>
        </th>

        <th>
          <select class="table_search" name="tasks_search_created" id="tasks_search_created">
            <option value="0">&nbsp;</option>
          </select>
        </th>

        <th class="desktop">
          <input type="text" class="table_search" name="tasks_search_reporter" id="tasks_search_reporter" value="" size="1">
        </th>

        <th class="desktop">
          <select class="table_search" name="tasks_search_category" id="tasks_search_category">
            <option value="0">&nbsp;</option>
          </select>
        </th>

        <th class="desktop">
          <select class="table_search" name="tasks_search_goal" id="tasks_search_goal">
            <option value="0">&nbsp;</option>
          </select>
        </th>

        <?php if($is_admin) { ?>
        <th class="desktop">
          <select class="table_search" name="tasks_search_admin" id="tasks_search_admin">
            <option value="0">&nbsp;</option>
          </select>
        </th>
        <?php } ?>

      </tr>

    </thead>
    <tbody>

      <tr>

        <td colspan="<?=$tasks_rows_desktop?>" class="desktop uppercase text_light dark bold align_center">
          <span class="spaced">
            <?=__('tasks_list_count', amount: $task_list['rows'], preset_values: array($task_list['rows']))?>
          </span>
          <span class="spaced text_green">
            <?=__('tasks_list_count_finished', amount: $task_list['finished'], preset_values: array($task_list['finished']))?>
          </span>
          <span class="spaced text_red">
            <?=__('tasks_list_count_open', preset_values: array($task_list['todo']))?>
          </span>
          <span class="spaced text_orange">
            <?=__('tasks_list_count_solved', preset_values: array($task_list['percent']))?>
          </span>
        </td>

        <td colspan="<?=$tasks_rows_mobile?>" class="mobile uppercase text_light dark bold align_center">
          <span class="spaced">
            <?=__('tasks_list_count', amount: $task_list['rows'], preset_values: array($task_list['rows']))?>
          </span>
          <span class="spaced text_green">
            <?=__('tasks_list_count_finished_short', amount: $task_list['finished'], preset_values: array($task_list['finished']))?>
          </span>
          <span class="spaced text_red">
            <?=__('tasks_list_count_open_short', preset_values: array($task_list['todo']))?>
          </span>
        </td>

      </tr>

      <?php for($i = 0; $i < $task_list['rows']; $i++) { ?>

      <tr class="align_center pointer text_dark light_hover <?=$task_list[$i]['css_row']?>">

        <td>
          #<?=$task_list[$i]['id']?>
        </td>

        <td class="bold align_left desktop">
          <?=$task_list[$i]['title']?>
        </td>

        <td class="bold align_left mobile">
          <?=$task_list[$i]['shorttitle']?>
        </td>

        <td class="nowrap<?=$task_list[$i]['css_status']?>"">
          <?=$task_list[$i]['status']?>
        </td>

        <td class="nowrap">
          <?=$task_list[$i]['created']?>
        </td>

        <td class="nowrap desktop">
          <?=$task_list[$i]['author']?>
        </td>

        <td class="nowrap desktop">
          <?=$task_list[$i]['category']?>
        </td>

        <td class="nowrap desktop">
          <?=$task_list[$i]['milestone']?>
        </td>

        <?php if($is_admin) { ?>
        <td class="nowrap desktop">
          <?php if($task_list[$i]['nolang_en']) { ?>
          <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="14" alt="<?=__('EN')?>" title="<?=__('tasks_list_nolang_en')?>">
          <?php } if($task_list[$i]['nolang_fr']) { ?>
          <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="14" alt="<?=__('FR')?>" title="<?=__('tasks_list_nolang_fr')?>">
          <?=__icon('lang_fr', is_small: true, class: 'valign_middle', alt: 'FR', title: __('tasks_list_nolang_fr'))?>
          <?php } if($task_list[$i]['deleted']) { ?>
          <?=__icon('delete', is_small: true, class: 'valign_middle', alt: 'X', title: __('tasks_list_deleted'), use_dark: true)?>
          <?php } if($task_list[$i]['private']) { ?>
          <?=__icon('user_delete', is_small: true, class: 'valign_middle', alt: 'P', title: __('tasks_list_private'), use_dark: true)?>
          <?php } if($task_list[$i]['new']) { ?>
          <?=__icon('edit', is_small: true, class: 'valign_middle', alt: 'U', title: __('tasks_list_unvalidated'), use_dark: true)?>
          <?php } ?>
        </td>
        <?php } ?>

      </tr>

      <tr>

        <td class="desktop hidden" colspan="<?=$tasks_rows_desktop?>">
          &nbsp;
        </td>

        <td class="mobile hidden" colspan="<?=$tasks_rows_mobile?>">
          &nbsp;
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