<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../actions/tasks.act.php';       # Actions
include_once './../../lang/tasks.lang.php';         # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/edit";
$page_title_en    = "Edit task #";
$page_title_fr    = "Modifier la tâche #";

// Extra JS & CSS
$js   = array('common/toggle', 'users/autocomplete_username', 'tasks/edit');
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

// Throw an error if the task hasn't been validated
if(!$task_details['validated'])
  error_page(__('tasks_edit_unvalidated'));

// Update the page's title
$page_title_en .= $task_id;
$page_title_fr .= $task_id;

// Fetch categories
$tasks_categories = tasks_categories_list();

// Fetch milestones
$tasks_milestones = tasks_milestones_list();

// Prepare task data
$tasks_edit_title_en    = $task_details['title_en'];
$tasks_edit_body_en     = $task_details['body_en'];
$tasks_edit_title_fr    = $task_details['title_fr'];
$tasks_edit_body_fr     = $task_details['body_fr'];
$tasks_edit_author      = $task_details['creator'];
$tasks_edit_source      = $task_details['source'];
$tasks_preview_body_en  = "";
$tasks_preview_body_fr  = "";

// Prepare dropdown menus
for($i = 0; $i <= 5; $i++)
  $tasks_edit_priority_selected[$i]  = ($task_details['priority'] == $i) ? ' selected' : '';
for($i = 0; $i < $tasks_categories['rows']; $i++)
  $tasks_edit_category_selected[$i]  = ($task_details['category_id'] == $tasks_categories[$i]['id']) ? ' selected' : '';
for($i = 0; $i < $tasks_milestones['rows']; $i++)
  $tasks_edit_milestone_selected[$i] = ($task_details['milestone_id'] == $tasks_milestones[$i]['id']) ? ' selected' : '';

// Prepare checkboxes
$tasks_edit_private = (!$task_details['public'])  ? ' checked' : '';
$tasks_edit_solved  = ($task_details['solved'])   ? ' checked' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit the task

// Attempt to edit the task
if(isset($_POST['tasks_edit_submit']))
{
  // Prepare an array with the task data
  $tasks_edit_data = array( 'title_en'  => form_fetch_element('tasks_edit_title_en')                      ,
                            'title_fr'  => form_fetch_element('tasks_edit_title_fr')                      ,
                            'body_en'   => form_fetch_element('tasks_edit_body_en')                       ,
                            'body_fr'   => form_fetch_element('tasks_edit_body_fr')                       ,
                            'priority'  => form_fetch_element('tasks_edit_priority')                      ,
                            'category'  => form_fetch_element('tasks_edit_category')                      ,
                            'milestone' => form_fetch_element('tasks_edit_milestone')                     ,
                            'source'    => form_fetch_element('tasks_edit_source')                        ,
                            'author'    => form_fetch_element('tasks_edit_author')                        ,
                            'private'   => form_fetch_element('tasks_edit_private', element_exists: true) ,
                            'solved'    => form_fetch_element('tasks_edit_solved', element_exists: true)  );

  // Edit the task
  $tasks_edit = tasks_edit( $task_id          ,
                            $tasks_edit_data  );

  // If the task was properly modified, redirect to it
  if(is_null($tasks_edit))
    exit(header("Location: ".$path."pages/tasks/".$task_id));
}

if(isset($_POST['tasks_edit_submit']) || isset($_POST['tasks_edit_preview']))
{
  // Keep the forms filled if there was an error
  $tasks_edit_title_en  = sanitize_output(form_fetch_element('tasks_edit_title_en'));
  $tasks_edit_body_en   = sanitize_output(form_fetch_element('tasks_edit_body_en'));
  $tasks_edit_title_fr  = sanitize_output(form_fetch_element('tasks_edit_title_fr'));
  $tasks_edit_body_fr   = sanitize_output(form_fetch_element('tasks_edit_body_fr'));
  $tasks_edit_priority  = form_fetch_element('tasks_edit_priority');
  $tasks_edit_category  = form_fetch_element('tasks_edit_category');
  $tasks_edit_milestone = form_fetch_element('tasks_edit_milestone');
  $tasks_edit_author    = sanitize_output(form_fetch_element('tasks_edit_author'));
  $tasks_edit_source    = sanitize_output(form_fetch_element('tasks_edit_source'));
  $tasks_edit_private   = form_fetch_element('tasks_edit_private', element_exists: true) ? ' checked' : '';
  $tasks_edit_solved    = form_fetch_element('tasks_edit_solved', element_exists: true) ? ' checked' : '';

  // Preserve the dropdown menus
  for($i = 0; $i <= 5; $i++)
    $tasks_edit_priority_selected[$i]  = ($tasks_edit_priority == $i) ? ' selected' : '';
  for($i = 0; $i < $tasks_categories['rows']; $i++)
    $tasks_edit_category_selected[$i]  = ($tasks_edit_category == $tasks_categories[$i]['id']) ? ' selected' : '';
  for($i = 0; $i < $tasks_milestones['rows']; $i++)
    $tasks_edit_milestone_selected[$i] = ($tasks_edit_milestone == $tasks_milestones[$i]['id']) ? ' selected' : '';

  // Prepare previews
  $tasks_preview_body_en  = bbcodes(sanitize_output(form_fetch_element('tasks_edit_body_en'), true));
  $tasks_preview_body_fr  = bbcodes(sanitize_output(form_fetch_element('tasks_edit_body_fr'), true));
}





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="padding_bot">
    <?=__link('pages/tasks/'.$task_id, __('tasks_details_id', preset_values: array($task_id)), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <div class="flexcontainer smallpadding_bot">
        <div style="flex: 10;">

          <div class="smallpadding_bot">
            <label for="tasks_edit_title_en"><?=__('tasks_add_title_en')?></label>
            <input type="text" class="indiv" id="tasks_edit_title_en" name="tasks_edit_title_en" value="<?=$tasks_edit_title_en?>">
          </div>

          <label for="tasks_edit_body_en"><?=__('tasks_add_body_en')?></label>
          <textarea class="indiv" id="tasks_edit_body_en" name="tasks_edit_body_en"><?=$tasks_edit_body_en?></textarea>

        </div>
        <div class="flex">
          &nbsp;
        </div>
        <div style="flex: 10;">

          <div class="smallpadding_bot">
            <label for="tasks_edit_title_fr"><?=__('tasks_add_title_fr')?></label>
            <input type="text" class="indiv" id="tasks_edit_title_fr" name="tasks_edit_title_fr" value="<?=$tasks_edit_title_fr?>">
          </div>

          <label for="tasks_edit_body_fr"><?=__('tasks_add_body_fr')?></label>
          <textarea class="indiv" id="tasks_edit_body_fr" name="tasks_edit_body_fr"><?=$tasks_edit_body_fr?></textarea>

        </div>
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_edit_priority"><?=__('tasks_add_priority')?></label>
        <select class="indiv align_left" id="tasks_edit_priority" name="tasks_edit_priority">
          <?php for($i = 0; $i <= 5; $i++) { ?>
          <option value="<?=$i?>"<?=$tasks_edit_priority_selected[$i]?>><?=__('tasks_list_state_'.$i)?></option>
          <?php } ?>
        </select>
      </div>

      <div class="flexcontainer smallpadding_bot" id="task_categories_selector">

        <?php } if(!isset($_POST['reload_milestones'])) { ?>

        <div class="tasks_edit_category">

          <label for="tasks_edit_category"><?=string_change_case(__('category'), 'initials')?></label>
          <select class="indiv align_left" id="tasks_edit_category" name="tasks_edit_category">
            <option value="0" selected>&nbsp;</option>
            <?php for($i = 0; $i < $tasks_categories['rows']; $i++) { ?>
            <option value="<?=$tasks_categories[$i]['id']?>"<?=$tasks_edit_category_selected[$i]?>><?=$tasks_categories[$i]['title']?></option>
            <?php } ?>
          </select>

        </div>
        <div class="flex align_center tasks_edit_category_icon nowrap">

          <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_categories_popin();")?>

          <?=__icon('refresh', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_categories_reload('edit?id=".$task_id."');")?>

        </div>

        <?php } if(!page_is_fetched_dynamically()) { ?>

      </div>

      <div class="flexcontainer smallpadding_bot" id="task_milestones_selector">

        <?php } if(!isset($_POST['reload_categories'])) {?>

        <div class="tasks_edit_category">

          <label for="tasks_edit_milestone"><?=__('tasks_add_milestone')?></label>
          <select class="indiv align_left" id="tasks_edit_milestone" name="tasks_edit_milestone">
            <option value="0" selected>&nbsp;</option>
            <?php for($i = 0; $i < $tasks_milestones['rows']; $i++) { ?>
            <option value="<?=$tasks_milestones[$i]['id']?>"<?=$tasks_edit_milestone_selected[$i]?>><?=$tasks_milestones[$i]['title']?></option>
            <?php } ?>
          </select>

        </div>
        <div class="flex align_center tasks_edit_category_icon nowrap">

          <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_milestones_popin();")?>

          <?=__icon('refresh', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_milestones_reload('edit?id=".$task_id."');")?>

        </div>

        <?php } if(!page_is_fetched_dynamically()) { ?>

      </div>

      <div class="smallpadding_bot">
        <label for="tasks_edit_author"><?=__('tasks_edit_author')?></label>
        <input class="indiv" type="text" id="tasks_edit_author" name="tasks_edit_author" value="<?=$tasks_edit_author?>" autocomplete="off" list="tasks_edit_author_list" onkeyup="autocomplete_username('tasks_edit_author', 'tasks_edit_author_list_parent', './../common/autocomplete_username', 'tasks_edit_author_list', 'normal');">
      </div>
      <div id="tasks_edit_author_list_parent">
        <datalist id="tasks_edit_author_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <?php if($task_details['solved']) { ?>

      <div class="smallpadding_bot">
        <label for="tasks_edit_source"><?=__('tasks_solve_source')?></label>
        <input type="text" class="indiv" id="tasks_edit_source" name="tasks_edit_source" value="<?=$tasks_edit_source?>">
      </div>

      <input type="checkbox" id="tasks_edit_solved" name="tasks_edit_solved"<?=$tasks_edit_solved?>>
      <label class="label_inline" for="tasks_edit_solved"><?=__('tasks_edit_solved')?></label><br>

      <?php } ?>

      <input type="checkbox" id="tasks_edit_private" name="tasks_edit_private"<?=$tasks_edit_private?>>
      <label class="label_inline" for="tasks_edit_private"><?=__('tasks_add_private')?></label>

      <?php if(isset($tasks_edit)) { ?>
      <div class="smallpadding_top smallpadding_bot">
        <div class="red text_white uppercase bold spaced big">
          <?=__('error').__(':', spaces_after: 1).$tasks_edit?>
        </div>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="tasks_edit_submit" value="<?=__('tasks_edit_submit')?>">
        <input type="submit" name="tasks_edit_preview" value="<?=__('preview')?>">
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