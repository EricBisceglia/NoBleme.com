<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/tasks.act.php';       # Actions
include_once './../../lang/tasks.lang.php';         # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/list";
$page_title_en    = "Task";
$page_title_fr    = "Tâche";
$page_description = "Task linked to a bug or feature in NoBleme's development";

// Extra JS
$js = array('tasks/task');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete or restore the task

// Fetch the task's id
$task_id = (int)form_fetch_element('id', 0, request_type: 'GET');

// Soft delete a task
if(isset($_POST['task_delete']))
  tasks_delete($task_id);

// Restore a deleted task
if(isset($_POST['task_restore']))
  tasks_restore($task_id);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch task data

// Fetch the task's details
$task_details = tasks_get($task_id);

// Throw an error if the task does not exist
if(!$task_details)
  error_page(__('tasks_details_error'));

// Update the page summary
$page_url         = "pages/tasks/".$task_id;
$page_title_en   .= " #".$task_id.": ".$task_details['title_en_raw'];
$page_title_fr   .= " #".$task_id." : ".$task_details['title_fr_raw'];
$page_description = ($task_details['meta_desc']) ? $task_details['meta_desc'] : $page_description;





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50" id="task_full_body">

  <?php } ?>

  <h1>

    <?=__link('pages/tasks/list', __('tasks_details_id', preset_values: array($task_id)), 'noglow')?>

    <?php if($is_admin) { ?>
    <?php if(!$task_details['validated']) { ?>
    <?=__icon('user_confirm', alt: 'O', title: __('tasks_approve_submit'), title_case: 'initials', href: 'pages/tasks/approve?id='.$task_id)?>
    <?=__icon('user_delete', alt: 'X', title: __('tasks_reject_icon'), title_case: 'initials', href: 'pages/tasks/reject?id='.$task_id)?>
    <?php } if($task_details['validated']) { ?>
    <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', href: 'pages/tasks/edit?id='.$task_id)?>
    <?php } if($task_details['validated'] && !$task_details['solved'] && !$task_details['deleted']) { ?>
    <?=__icon('done', alt: 'D', title: __('done'), title_case: 'initials', href: 'pages/tasks/solved?id='.$task_id)?>
    <?php } if($task_details['validated'] && !$task_details['deleted']) { ?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "task_delete('".$task_id."', '".__('tasks_delete_confirm')."')")?>
    <?php } if($task_details['validated'] && $task_details['deleted']) { ?>
    <?=__icon('refresh', alt: 'R', title: __('restore'), title_case: 'initials', onclick: "task_restore('".$task_id."', '".__('tasks_restore_confirm')."')")?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "task_delete_hard('".$task_id."', '".__('tasks_delete_hard_confirm')."')")?>
    <?php } ?>
    <?php } ?>

  </h1>

  <h4>

    <?php if(!$task_details['validated']) { ?>
    <?=$task_details['title_flex']?>
    <?php } else if($task_details['title']) { ?>
    <?=$task_details['title']?>
    <?php } else { ?>
    <?=__('tasks_details_no_title')?>
    <?php } ?>

  </h4>

  <?php if($is_admin && ($task_details['deleted'] || !$task_details['public'] || !$task_details['validated'])) { ?>
  <p>

    <?php if($task_details['deleted']) { ?>
    <span class="bold red text_white spaced"><?=__('tasks_full_deleted')?></span>
    <?php } else if(!$task_details['validated']) { ?>
    <span class="bold red text_white spaced"><?=__('tasks_full_unvalidated')?></span>
    <?php } else if(!$task_details['public']) { ?>
    <span class="bold red text_white spaced"><?=__('tasks_full_private')?></span>
    <?php } ?>

  </p>
  <?php } ?>

  <p>

    <?=__('tasks_full_created', spaces_after: 1, preset_values: array($task_details['created_since'], $task_details['created_full'])).__link('pages/users/'.$task_details['creator_id'], $task_details['creator'])?><br>

    <?php if($task_details['solved']) { ?>

    <?=__('tasks_full_solved', preset_values: array($task_details['solved_since'], $task_details['solved_full']))?>
    <?php if($task_details['source']) { ?>
    <br><?=__link($task_details['source'], __('tasks_full_source'), is_internal: false)?></a>
    <?php } ?>

    <?php } else { ?>

    <?=__('tasks_full_unsolved')?><br>
    <?=__('tasks_full_priority', spaces_after: 1)?><span class="bold"><?=__('tasks_list_state_'.$task_details['priority'])?></span>

    <?php } ?>

    <?php if($task_details['category']) { ?>
    <br><?=__('tasks_full_category', spaces_after: 1)?><span class="bold"><?=$task_details['category']?></span>
    <?php } if($task_details['milestone']) { ?>
    <br><?=__('tasks_full_milestone', spaces_after: 1)?><span class="bold"><?=__link('pages/tasks/roadmap', $task_details['milestone'])?></span>
    <?php } ?>

  </p>

  <h5 class="bigpadding_top">
    <?=__('tasks_full_body')?>
  </h5>

  <p>

    <?php if(!$task_details['validated']) { ?>
    <?=$task_details['body_flex']?>
    <?php } else if($task_details['body']) { ?>
    <?=$task_details['body']?>
    <?php } else { ?>
    <?=__('tasks_details_no_body')?>
    <?php } ?>

  </p>

  <?php if(!page_is_fetched_dynamically()) { ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }