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
$page_title_en    = "Reject task";
$page_title_fr    = "Rejeter une tâche";




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

// Throw an error if the task does not exist
if(!$task_details)
  error_page(__('tasks_details_error'));

// Throw an error if the task has already been rejected
if($task_details['validated'])
  error_page(__('tasks_approve_impossible'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Reject the task

// Attempt to reject the task
if(isset($_POST['tasks_reject_submit']))
{
  // Reject the task
  $tasks_reject = tasks_reject( $task_id                                                        ,
                                form_fetch_element('tasks_reject_reason')                       ,
                                form_fetch_element('tasks_reject_silent', element_exists: true) );

  // If the task was properly rejected, redirect to the task list
  if(is_null($tasks_reject))
    exit(header("Location: ".$path."pages/tasks/list"));
}

// Keep the forms filled if there was an error
$tasks_reject_reason  = sanitize_output(form_fetch_element('tasks_reject_reason'));
$tasks_reject_silent  = form_fetch_element('tasks_reject_silent', element_exists: true) ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h2>
    <?=__('tasks_reject_title')?>
  </h2>

  <h5 class="bigpadding_top padding_bot">
    <?=__('tasks_approve_subtitle', spaces_after: 1).__link('pages/users/'.$task_details['creator_id'], $task_details['creator']).__(':')?>
  </h5>

  <pre id="task_reject_body" onclick="to_clipboard('', 'task_reject_body', 1);"><?=$task_details['body_proposal']?>
  </pre>

  <form method="POST">
    <fieldset>

      <div class="padding_top">
        <label for="tasks_reject_reason"><?=__('tasks_reject_reason')?></label>
        <input type="text" class="indiv" id="tasks_reject_reason" name="tasks_reject_reason" value="<?=$tasks_reject_reason?>">
      </div>

      <div class="smallpadding_top">
        <input type="checkbox" id="tasks_reject_silent" name="tasks_reject_silent"<?=$tasks_reject_silent?>>
        <label class="label_inline" for="tasks_reject_silent"><?=__('tasks_reject_silent')?></label>
      </div>

      <?php if(isset($tasks_reject)) { ?>
      <div class="smallpadding_top smallpadding_bot">
        <div class="red text_white uppercase bold spaced big">
          <?=__('error').__(':', spaces_after: 1).$tasks_reject?>
        </div>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="tasks_reject_submit" value="<?=__('tasks_reject_submit')?>">
      </div>

    </fieldset>
  </form>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }