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

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/list";
$page_title_en    = "Solve task";
$page_title_fr    = "Résoudre une tâche";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Form elements

// Fetch the task's id
$task_id = (int)form_fetch_element('id', 0, request_type: 'GET');

// Fetch the task's details
$task_details = tasks_get($task_id);

// Throw an error if the task does not exist or has been deleted
if(!$task_details || $task_details['deleted'])
  error_page(__('tasks_details_error'));

// Throw an error if the task has already been solved
if($task_details['solved'])
  error_page(__('tasks_solve_impossible'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Solve the task

// Attempt to solve the task
if(isset($_POST['tasks_solve_submit']))
{
  // Solve the task
  $tasks_solve = tasks_solve( $task_id                                                            ,
                              form_fetch_element('tasks_solve_source')                            ,
                              form_fetch_element('tasks_solve_silent', element_exists: true)      ,
                              form_fetch_element('tasks_solve_no_message', element_exists: true)  );

  // If the task was properly solved, redirect to it
  if(is_null($tasks_solve))
    exit(header("Location: ".$path."pages/tasks/".$task_id));
}

// Keep the forms filled if there was an error
$tasks_solve_source     = sanitize_output(form_fetch_element('tasks_solve_source'));
$tasks_solve_silent     = form_fetch_element('tasks_solve_silent', element_exists: true) ? ' checked' : '';
$tasks_solve_no_message = form_fetch_element('tasks_solve_no_message', element_exists: true) ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h2>
    <?=__link('pages/tasks/'.$task_id, __('tasks_solve_title', preset_values: array($task_id)), 'noglow')?>
  </h2>

  <form method="POST">
    <fieldset>

      <div class="padding_top smallpadding_bot">
        <label for="tasks_solve_source"><?=__('tasks_solve_source')?></label>
        <input type="text" class="indiv" id="tasks_solve_source" name="tasks_solve_source" value="<?=$tasks_solve_source?>">
      </div>

      <?php if($task_details['creator_id'] != user_get_id()) { ?>
      <input type="checkbox" id="tasks_solve_no_message" name="tasks_solve_no_message"<?=$tasks_solve_no_message?>>
      <label class="label_inline" for="tasks_solve_no_message"><?=__('tasks_solve_no_message')?></label><br>
      <?php } ?>

      <?php if($task_details['public']) { ?>
      <input type="checkbox" id="tasks_solve_silent" name="tasks_solve_silent"<?=$tasks_solve_silent?>>
      <label class="label_inline" for="tasks_solve_silent"><?=__('tasks_add_silent')?></label>
      <?php } ?>

      <?php if(isset($tasks_solve)) { ?>
      <div class="smallpadding_top smallpadding_bot">
        <div class="red text_white uppercase bold spaced big">
          <?=__('error').__(':', spaces_after: 1).$tasks_solve?>
        </div>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="tasks_solve_submit" value="<?=__('tasks_solve_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }