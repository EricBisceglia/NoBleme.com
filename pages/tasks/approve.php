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
$page_title_en    = "Approve task";
$page_title_fr    = "Approuver une tâche";

// Extra JS & CSS
$js   = array('common/toggle', 'tasks/edit');
$css  = array('tasks');




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

// Throw an error if the task has already been validated
if($task_details['validated'])
  error_page(__('tasks_approve_impossible'));

// Fetch categories
$tasks_categories = tasks_categories_list();

// Fetch milestones
$tasks_milestones = tasks_milestones_list();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Approve the task

// Attempt to approve the task
if(isset($_POST['tasks_approve_submit']))
{
  // Prepare an array with the task data
  $tasks_approve_data = array(  'title_en'  => form_fetch_element('tasks_approve_title_en')                       ,
                                'title_fr'  => form_fetch_element('tasks_approve_title_fr')                       ,
                                'body_en'   => form_fetch_element('tasks_approve_body_en')                        ,
                                'body_fr'   => form_fetch_element('tasks_approve_body_fr')                        ,
                                'priority'  => form_fetch_element('tasks_approve_priority')                       ,
                                'category'  => form_fetch_element('tasks_approve_category')                       ,
                                'milestone' => form_fetch_element('tasks_approve_milestone')                      ,
                                'private'   => form_fetch_element('tasks_approve_private', element_exists: true)  ,
                                'silent'    => form_fetch_element('tasks_approve_silent', element_exists: true)   );

  // Approve the task
  $tasks_approve = tasks_approve( $task_id            ,
                                  $tasks_approve_data );

  // If the task was properly approved, redirect to it
  if(is_null($tasks_approve))
    exit(header("Location: ".$path."pages/tasks/".$task_id));
}

// Keep the forms filled if there was an error
$tasks_approve_title_en   = sanitize_output(form_fetch_element('tasks_approve_title_en'));
$tasks_approve_body_en    = sanitize_output(form_fetch_element('tasks_approve_body_en'));
$tasks_approve_title_fr   = sanitize_output(form_fetch_element('tasks_approve_title_fr'));
$tasks_approve_body_fr    = sanitize_output(form_fetch_element('tasks_approve_body_fr'));
$tasks_approve_priority   = sanitize_output(form_fetch_element('tasks_approve_priority'));
$tasks_approve_category   = sanitize_output(form_fetch_element('tasks_approve_category'));
$tasks_approve_milestone  = sanitize_output(form_fetch_element('tasks_approve_milestone'));
$tasks_approve_private    = form_fetch_element('tasks_approve_private', element_exists: true) ? ' checked' : '';
$tasks_approve_silent     = form_fetch_element('tasks_approve_silent', element_exists: true) ? ' checked' : '';

// Preserve the dropdown menus
for($i = 0; $i <= 5; $i++)
  $tasks_approve_priority_selected[$i]  = ($tasks_approve_priority == $i) ? ' selected' : '';
for($i = 0; $i < $tasks_categories['rows']; $i++)
  $tasks_approve_category_selected[$i]  = ($tasks_approve_category == $tasks_categories[$i]['id']) ? ' selected' : '';
for($i = 0; $i < $tasks_milestones['rows']; $i++)
  $tasks_approve_milestone_selected[$i] = ($tasks_approve_milestone == $tasks_milestones[$i]['id']) ? ' selected' : '';

// Preview the descriptions
$tasks_preview_body_en  = bbcodes(sanitize_output(form_fetch_element('tasks_approve_body_en'), true));
$tasks_preview_body_fr  = bbcodes(sanitize_output(form_fetch_element('tasks_approve_body_fr'), true));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h2>
    <?=__('tasks_approve_title')?>
  </h2>

  <h5 class="bigpadding_top padding_bot">
    <?=__('tasks_edit_author', spaces_after: 1).__link('pages/users/'.$task_details['creator_id'], $task_details['creator']).__(':')?>
  </h5>

  <pre id="task_approve_body" onclick="to_clipboard('', 'task_approve_body', 1);"><?=$task_details['body_proposal']?>
  </pre>

  <form method="POST">
    <fieldset>

      <div class="bigpadding_top flexcontainer smallpadding_bot">
        <div style="flex: 10;">

          <div class="smallpadding_bot">
            <label for="tasks_approve_title_en"><?=__('tasks_add_title_en')?></label>
            <input type="text" class="indiv" id="tasks_approve_title_en" name="tasks_approve_title_en" value="<?=$tasks_approve_title_en?>">
          </div>

          <label for="tasks_approve_body_en"><?=__('tasks_add_body_en')?></label>
          <textarea class="indiv" id="tasks_approve_body_en" name="tasks_approve_body_en"><?=$tasks_approve_body_en?></textarea>

        </div>
        <div class="flex">
          &nbsp;
        </div>
        <div style="flex: 10;">

          <div class="smallpadding_bot">
            <label for="tasks_approve_title_fr"><?=__('tasks_add_title_fr')?></label>
            <input type="text" class="indiv" id="tasks_approve_title_fr" name="tasks_approve_title_fr" value="<?=$tasks_approve_title_fr?>">
          </div>

          <label for="tasks_approve_body_fr"><?=__('tasks_add_body_fr')?></label>
          <textarea class="indiv" id="tasks_approve_body_fr" name="tasks_approve_body_fr"><?=$tasks_approve_body_fr?></textarea>

        </div>
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_approve_priority"><?=__('tasks_add_priority')?></label>
        <select class="indiv align_left" id="tasks_approve_priority" name="tasks_approve_priority">
          <?php for($i = 0; $i <= 5; $i++) { ?>
          <option value="<?=$i?>"<?=$tasks_approve_priority_selected[$i]?>><?=__('tasks_list_state_'.$i)?></option>
          <?php } ?>
        </select>
      </div>

      <div class="flexcontainer smallpadding_bot" id="task_categories_selector">

        <?php } if(!isset($_POST['reload_milestones'])) { ?>

        <div class="tasks_edit_category">

          <label for="tasks_approve_category"><?=string_change_case(__('category'), 'initials')?></label>
          <select class="indiv align_left" id="tasks_approve_category" name="tasks_approve_category">
            <option value="0" selected>&nbsp;</option>
            <?php for($i = 0; $i < $tasks_categories['rows']; $i++) { ?>
            <option value="<?=$tasks_categories[$i]['id']?>"<?=$tasks_approve_category_selected[$i]?>><?=$tasks_categories[$i]['title']?></option>
            <?php } ?>
          </select>

        </div>
        <div class="flex align_center tasks_edit_category_icon nowrap">

          <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_categories_popin();")?>

          <?=__icon('refresh', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_categories_reload('approve?id=".$task_id."');")?>

        </div>

        <?php } if(!page_is_fetched_dynamically()) { ?>

      </div>

      <div class="flexcontainer smallpadding_bot" id="task_milestones_selector">

        <?php } if(!isset($_POST['reload_categories'])) {?>

        <div class="tasks_edit_category">

          <label for="tasks_approve_milestone"><?=__('tasks_add_milestone')?></label>
          <select class="indiv align_left" id="tasks_approve_milestone" name="tasks_approve_milestone">
            <option value="0" selected>&nbsp;</option>
            <?php for($i = 0; $i < $tasks_milestones['rows']; $i++) { ?>
            <option value="<?=$tasks_milestones[$i]['id']?>"<?=$tasks_approve_milestone_selected[$i]?>><?=$tasks_milestones[$i]['title']?></option>
            <?php } ?>
          </select>

        </div>
        <div class="flex align_center tasks_edit_category_icon nowrap">

          <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_milestones_popin();")?>

          <?=__icon('refresh', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_milestones_reload('approve?id=".$task_id."');")?>

        </div>

        <?php } if(!page_is_fetched_dynamically()) { ?>

      </div>

      <input type="checkbox" id="tasks_approve_private" name="tasks_approve_private"<?=$tasks_approve_private?>>
      <label class="label_inline" for="tasks_approve_private"><?=__('tasks_add_private')?></label><br>

      <input type="checkbox" id="tasks_approve_silent" name="tasks_approve_silent"<?=$tasks_approve_silent?>>
      <label class="label_inline" for="tasks_approve_silent"><?=__('tasks_add_silent')?></label>

      <?php if(isset($tasks_approve)) { ?>
      <div class="smallpadding_top smallpadding_bot">
        <div class="red text_white uppercase bold spaced big">
          <?=__('error').__(':', spaces_after: 1).$tasks_approve?>
        </div>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="tasks_approve_submit" value="<?=__('tasks_approve_submit')?>">
        <input type="submit" name="tasks_approve_preview" value="<?=__('preview')?>">
      </div>

    </fieldset>
  </form>

  <?php if($tasks_preview_body_en) { ?>

  <div class="bigpadding_top">
    <hr>
  </div>

  <h5 class="bigpadding_top">
    <?=__('tasks_add_preview_en')?>
  </h5>

  <p>
    <?=$tasks_preview_body_en?>
  </p>

  <?php } if($tasks_preview_body_fr) { ?>

  <div class="bigpadding_top">
    <hr>
  </div>

  <h5 class="bigpadding_top">
    <?=__('tasks_add_preview_fr')?>
  </h5>

  <p>
    <?=$tasks_preview_body_fr?>
  </p>

  <?php } ?>

</div>

<div id="task_categories_popin" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('task_categories_popin');">&times;</a>
    <div id="task_categories_popin_body">
      &nbsp;
    </div>
  </div>
</div>

<div id="task_milestones_popin" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('task_milestones_popin');">&times;</a>
    <div id="task_milestones_popin_body">
      &nbsp;
    </div>
  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }