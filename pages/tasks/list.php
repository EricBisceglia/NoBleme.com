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

// Extra CSS & JS
$css  = array('tasks');
$js   = array('tasks/list');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Task list

// Fetch the search order
$tasks_list_search_order = form_fetch_element('tasks_search_order', 'status');

// Assemble the search array
$tasks_list_search = array( 'id'        => form_fetch_element('tasks_search_id')          ,
                            'title'     => form_fetch_element('tasks_search_description') ,
                            'status'    => form_fetch_element('tasks_search_status')      ,
                            'created'   => form_fetch_element('tasks_search_created')     ,
                            'reporter'  => form_fetch_element('tasks_search_reporter')    ,
                            'category'  => form_fetch_element('tasks_search_category')    ,
                            'goal'      => form_fetch_element('tasks_search_goal')        ,
                            'admin'     => form_fetch_element('tasks_search_admin')       );

// Fetch the tasks
$task_list = tasks_list(  $tasks_list_search_order  ,
                          $tasks_list_search        );

// Compute the number of columns depending on the what the user is allowed to see
$tasks_rows_desktop = ($is_admin) ? 8 : 7;
$tasks_rows_mobile  = 4;

// Fetch task categories
$tasks_categories_list = tasks_categories_list();

// Fetch task milestones
$tasks_milestones_list = tasks_milestones_list();




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
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('id');")?>
        </th>

        <th>
          <?=__('tasks_list_description')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('description');")?>
        </th>

        <th>
          <?=__('tasks_list_status')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('status');")?>
        </th>

        <th>
          <?=__('tasks_list_created')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('created');")?>
        </th>

        <th class="desktop">
          <?=__('tasks_list_reporter')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('reporter');")?>
        </th>

        <th class="desktop">
          <?=__('tasks_list_category')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('category');")?>
        </th>

        <th class="desktop">
          <?=__('tasks_list_goal')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('goal');")?>
        </th>

        <?php if($is_admin) { ?>
        <th class="desktop">
          <?=__('admin')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "tasks_list_search('admin');")?>
        </th>
        <?php } ?>

      </tr>

      <tr>

        <th>
          <input type="hidden" name="tasks_search_order" id="tasks_search_order" value="">
          <input type="text" class="table_search" name="tasks_search_id" id="tasks_search_id" value="" size="1" onkeyup="tasks_list_search();">
        </th>

        <th>
          <input type="text" class="table_search" name="tasks_search_description" id="tasks_search_description" value="" onkeyup="tasks_list_search();">
        </th>

        <th>
          <select class="table_search" name="tasks_search_status" id="tasks_search_status" onchange="tasks_list_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = 6; $i >= 1; $i--) { ?>
            <option class="text_black task_status_<?=($i-1)?>" value="<?=$i?>"><?=__('tasks_list_state_'.($i-1))?></option>
            <?php } ?>
            <option class="text_black task_solved" value="-1"><?=__('tasks_list_solved')?></option>
            <?php foreach($task_list['years_solved'] as $years_solved) { ?>
            <option class="text_black task_solved" value="<?=$years_solved?>"><?=__('tasks_list_solved_in', preset_values: array($years_solved))?></option>
            <?php } ?>
          </select>
        </th>

        <th>
          <select class="table_search" name="tasks_search_created" id="tasks_search_created" onchange="tasks_list_search();">
            <option value="0">&nbsp;</option>
            <?php foreach($task_list['years_created'] as $years_created) { ?>
            <option value="<?=$years_created?>"><?=$years_created?></option>
            <?php } ?>
          </select>
        </th>

        <th class="desktop">
          <input type="text" class="table_search" name="tasks_search_reporter" id="tasks_search_reporter" value="" size="1" onkeyup="tasks_list_search();">
        </th>

        <th class="desktop">
          <select class="table_search" name="tasks_search_category" id="tasks_search_category" onchange="tasks_list_search();">
            <option value="0">&nbsp;</option>
            <option value="-1"><?=__('tasks_list_uncategorized')?></option>
            <?php for($i = 0; $i < $tasks_categories_list['rows']; $i++) { ?>
            <option value="<?=$tasks_categories_list[$i]['id']?>"><?=$tasks_categories_list[$i]['title']?></option>
            <?php } ?>
          </select>
        </th>

        <th class="desktop">
          <select class="table_search" name="tasks_search_goal" id="tasks_search_goal" onchange="tasks_list_search();">
            <option value="0">&nbsp;</option>
            <option value="-1"><?=__('tasks_list_no_milestone')?></option>
            <?php for($i = 0; $i < $tasks_milestones_list['rows']; $i++) { ?>
            <option value="<?=$tasks_milestones_list[$i]['id']?>"><?=$tasks_milestones_list[$i]['title']?></option>
            <?php } ?>
          </select>
        </th>

        <?php if($is_admin) { ?>
        <th class="desktop">
          <select class="table_search tasks_admin_selector" name="tasks_search_admin" id="tasks_search_admin" onchange="tasks_list_search();">
            <option value="0">&nbsp;</option>
            <option value="1"><?=__('tasks_list_unvalidated')?></option>
            <option value="2"><?=__('tasks_list_deleted')?></option>
            <option value="3"><?=__('tasks_list_private')?></option>
            <option value="4"><?=__('tasks_list_nolang_en')?></option>
            <option value="5"><?=__('tasks_list_nolang_fr')?></option>
          </select>
        </th>
        <?php } ?>

      </tr>

    </thead>
    <tbody id="tasks_list_tbody">

      <?php } ?>

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

        <?php if($task_list[$i]['fulltitle']) { ?>
        <td class="bold align_left tooltip_container desktop">
          <?=$task_list[$i]['title']?>
          <div class="tooltip">
            <?=$task_list[$i]['fulltitle']?>
          </div>
        </td>
        <?php } else { ?>
        <td class="bold align_left desktop">
          <?=$task_list[$i]['title']?>
        </td>
        <?php } ?>

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

      <?php if(!page_is_fetched_dynamically()) { ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }