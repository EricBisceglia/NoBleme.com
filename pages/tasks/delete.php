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

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Hard delete a task

// Fetch the task's id
$task_id = (int)form_fetch_element('task_id', 0);

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

<h1 class="bigpadding_bot">
  <?=__link('pages/tasks/list', __('tasks_details_id', preset_values: array($task_id)), 'noglow')?>
</h1>

<div class="intable align_center red text_white bold uppercase bigger">
  <?php if(!$task_details) { ?>
  <?=__('tasks_delete_hard_ok')?>
  <?php } else { ?>
  <?=__('tasks_delete_hard_error')?>
  <?php } ?>
</div>