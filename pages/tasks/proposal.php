<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/tasks.act.php'; # Actions
include_once './../../lang/tasks.lang.php';   # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/proposal";
$page_title_en    = "Bug report";
$page_title_fr    = "Rapporter un bug";
$page_description = "Report a bug or suggest a new feature for NoBleme";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Submit proposal

// Fetch the form's content
$task_proposal_body = form_fetch_element('tasks_proposal_body');

// Submit the proposal
if(isset($_POST['tasks_proposal_submit']))
  $task_proposal_error = tasks_propose($task_proposal_body);

// Prepare the form contents for displaying
$task_proposal_body = sanitize_output($task_proposal_body);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('tasks_proposal_title')?>
  </h1>

  <h5>
    <?=__('tasks_proposal_subtitle')?>
  </h5>

  <p>
    <?=__('tasks_proposal_intro_1')?>
  </p>

  <p>
    <?=__('tasks_proposal_intro_2')?>
  </p>

  <p>
    <?=__('tasks_proposal_intro_3')?>
  </p>

  <?php if(isset($task_proposal_error) && is_int($task_proposal_error)) { ?>

  <div class="bigpadding_top">
    <div class="green text_white uppercase bold spaced bigger">
      <?=__('tasks_proposal_sent')?>
    </div>
  </div>

  <?php } else { ?>

  <form method="POST">
    <fieldset>

      <div class="padding_top smallpadding_bot">
        <textarea id="tasks_proposal_body" name="tasks_proposal_body"><?=$task_proposal_body?></textarea>
      </div>

      <?php if(isset($task_proposal_error) && !is_int($task_proposal_error)) { ?>
      <div class="tinypadding_top padding_bot">
        <div class="red text_white uppercase bold spaced bigger">
          <?=__('error').__(':', spaces_after: 1).$task_proposal_error?>
        </div>
      </div>
      <?php } ?>

      <input type="submit" name="tasks_proposal_submit" value="<?=__('tasks_proposal_submit')?>">

    </fieldset>
  </form>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }