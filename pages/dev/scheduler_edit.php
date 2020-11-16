<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/dev/scheduler.act.php'; # Actions
include_once './../../lang/dev/scheduler.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch the task id
$task_id = form_fetch_element('task_id', 0);

// Fetch the task information
$task_data = dev_scheduler_get($task_id, $lang);

// Prepare error messages if anything went wrong
if(!$task_id)
  $error = __('dev_scheduler_edit_error_postdata');
else if(!$task_data)
  $error = __('dev_scheduler_edit_error_id');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if(isset($error)) { ?>

<h5 class="align_center">
  <?=$error?>
</h5>

<?php } else { ?>

<fieldset>

  <div class="padding_bot">
    <label for="dev_scheduler_edit_date"><?=string_change_case(__('date'), 'initials')?> (<?=__('ddmmyy')?>)</label>
    <input class="indiv" type="text" id="dev_scheduler_edit_date" name="dev_scheduler_edit_date" value="<?=$task_data['date_days']?>">
  </div>

  <div class="padding_bot">
    <label for="dev_scheduler_edit_time"><?=string_change_case(__('time'), 'initials')?> (<?=__('hhiiss')?>)</label>
    <input class="indiv" type="text" id="dev_scheduler_edit_time" name="dev_scheduler_edit_time" value="<?=$task_data['date_time']?>">
  </div>

  <button onclick="dev_scheduler_edit(<?=$task_id?>);"><?=__('dev_scheduler_edit_button')?></button>

</fieldset>

<?php } ?>