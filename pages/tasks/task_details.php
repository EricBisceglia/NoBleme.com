<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/tasks.act.php';       # Actions
include_once './../../lang/tasks.lang.php';         # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete or restore the task

// Fetch the task's id
$task_id = (int)form_fetch_element('task_id', 0);

// Soft delete a task
if(isset($_POST['task_delete']))
  tasks_delete($task_id);

// Restore a deleted task
if(isset($_POST['task_restore']))
  tasks_restore($task_id);

// Hard delete a task
if(isset($_POST['task_delete_hard']))
  tasks_delete_hard($task_id);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch task data

// Fetch the task's details
$task_details = tasks_get($task_id);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if(!$task_details) { ?>

<div class="intable align_center red text_white bold uppercase bigger">
  <?=__('tasks_details_error')?>
</div>

<?php } else { ?>

<div class="indented spaced padding_top padding_bot">

  <h5 class="tinypadding_bot">

    <?php if($task_details['title']) { ?>
    <?=__link('pages/tasks/'.$task_id, __('tasks_details_title', preset_values: array($task_id, $task_details['title'])), 'noglow')?>
    <?php } else { ?>
    <?=__('tasks_details_no_title')?>
    <?php } ?>

    <?php if($is_admin) { ?>
    <?php if(!$task_details['validated']) { ?>
    <?=__icon('user_confirm', alt: 'O', title: __('tasks_approve_submit'), title_case: 'initials', href: 'pages/tasks/approve?id='.$task_id)?>
    <?=__icon('user_delete', alt: 'X', title: __('tasks_reject_icon'), title_case: 'initials', href: 'pages/tasks/reject?id='.$task_id)?>
    <?php } if($task_details['validated']) { ?>
    <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', href: 'pages/tasks/edit?id='.$task_id)?>
    <?php } if($task_details['validated'] && !$task_details['solved'] && !$task_details['deleted']) { ?>
    <?=__icon('done', alt: 'D', title: __('done'), title_case: 'initials', href: 'pages/tasks/solved?id='.$task_id)?>
    <?php } if($task_details['validated'] && !$task_details['deleted']) { ?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "tasks_delete('".$task_id."', '".__('tasks_delete_confirm')."')")?>
    <?php } if($task_details['validated'] && $task_details['deleted']) { ?>
    <?=__icon('refresh', alt: 'R', title: __('restore'), title_case: 'initials', onclick: "tasks_restore('".$task_id."', '".__('tasks_restore_confirm')."')")?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "tasks_delete_hard('".$task_id."', '".__('tasks_delete_hard_confirm')."')")?>
    <?php } ?>
    <?php } ?>

  </h5>


  <span class="bold">
    <?=__('tasks_details_link', spaces_after: 1).__link('pages/tasks/'.$task_id, __('tasks_details_id', preset_values: array($task_id)))?>
  </span>

  <br>

  <span class="bold">
    <?=__('tasks_details_created', spaces_after: 1, preset_values: array($task_details['created'])).__link('pages/users/'.$task_details['creator_id'], $task_details['creator'])?>
  </span>

  <?php if($task_details['solved']) { ?>

  <br>

  <span class="bold">
    <?=__('tasks_details_solved', preset_values: array($task_details['solved']))?>
    <?php if($task_details['source']) { ?>
    <?=__(':', spaces_after: 1).__link($task_details['source'], __('tasks_details_source'), is_internal: false)?></a>
    <?php } ?>
  </span>

  <?php } ?>

  <p>
    <?php if(!$task_details['validated']) { ?>
    <?=$task_details['body_flex']?>
    <?php } else if($task_details['body']) { ?>
    <?=$task_details['body']?>
    <?php } else { ?>
    <?=__('tasks_details_no_body')?>
    <?php } ?>
  </p>

</div>

<?php } ?>