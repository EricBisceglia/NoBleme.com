<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../inc/bbcodes.inc.php';   # BBCodes
include_once './../../actions/tasks.act.php'; # Actions
include_once './../../lang/tasks.lang.php';   # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/add";
$page_title_en    = "New task";
$page_title_fr    = "Nouvelle tâche";

// Extra JS & CSS
$js   = array('tasks/edit');
$css  = array('tasks');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Form elements

// Fetch categories
$tasks_categories = tasks_categories_list(exclude_archived: true);

// Fetch milestones
$tasks_milestones = tasks_milestones_list(exclude_archived: true);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Create the task

// Attempt to create the task
if(isset($_POST['tasks_add_submit']))
{
  // Prepare an array with the task data
  $tasks_add_data = array(  'title_en'  => form_fetch_element('tasks_add_title_en')                       ,
                            'title_fr'  => form_fetch_element('tasks_add_title_fr')                       ,
                            'body_en'   => form_fetch_element('tasks_add_body_en')                        ,
                            'body_fr'   => form_fetch_element('tasks_add_body_fr')                        ,
                            'priority'  => form_fetch_element('tasks_add_priority')                       ,
                            'category'  => form_fetch_element('tasks_add_category')                       ,
                            'milestone' => form_fetch_element('tasks_add_milestone')                      ,
                            'private'   => form_fetch_element('tasks_add_private', element_exists: true)  ,
                            'silent'    => form_fetch_element('tasks_add_silent', element_exists: true)   );

  // Create the task
  $tasks_add = tasks_add($tasks_add_data);

  // If the task was properly created, redirect to it
  if(is_int($tasks_add))
    exit(header("Location: ".$path."pages/tasks/".$tasks_add));
}

// Keep the forms filled if there was an error
$tasks_add_title_en   = sanitize_output(form_fetch_element('tasks_add_title_en'));
$tasks_add_body_en    = sanitize_output(form_fetch_element('tasks_add_body_en'));
$tasks_add_title_fr   = sanitize_output(form_fetch_element('tasks_add_title_fr'));
$tasks_add_body_fr    = sanitize_output(form_fetch_element('tasks_add_body_fr'));
$tasks_add_priority   = sanitize_output(form_fetch_element('tasks_add_priority'));
$tasks_add_category   = sanitize_output(form_fetch_element('tasks_add_category'));
$tasks_add_milestone  = sanitize_output(form_fetch_element('tasks_add_milestone'));
$tasks_add_private    = form_fetch_element('tasks_add_private', element_exists: true) ? ' checked' : '';
$tasks_add_silent     = form_fetch_element('tasks_add_silent', element_exists: true) ? ' checked' : '';

// Preserve the dropdown menus
for($i = 0; $i <= 5; $i++)
  $tasks_add_priority_selected[$i]  = ($tasks_add_priority == $i) ? ' selected' : '';
for($i = 0; $i < $tasks_categories['rows']; $i++)
  $tasks_add_category_selected[$i]  = ($tasks_add_category == $tasks_categories[$i]['id']) ? ' selected' : '';
for($i = 0; $i < $tasks_milestones['rows']; $i++)
  $tasks_add_milestone_selected[$i] = ($tasks_add_milestone == $tasks_milestones[$i]['id']) ? ' selected' : '';

// Preview the descriptions
$tasks_preview_body_en  = bbcodes(sanitize_output(form_fetch_element('tasks_add_body_en'), true));
$tasks_preview_body_fr  = bbcodes(sanitize_output(form_fetch_element('tasks_add_body_fr'), true));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="padding_bot">
    <?=__link('pages/tasks/roadmap', __('tasks_add_title'), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <div class="flexcontainer smallpadding_bot">
        <div style="flex: 10;">

          <div class="smallpadding_bot">
            <label for="tasks_add_title_en"><?=__('tasks_add_title_en')?></label>
            <input type="text" class="indiv" id="tasks_add_title_en" name="tasks_add_title_en" value="<?=$tasks_add_title_en?>">
          </div>

          <label for="tasks_add_body_en"><?=__('tasks_add_body_en')?></label>
          <textarea class="indiv" id="tasks_add_body_en" name="tasks_add_body_en"><?=$tasks_add_body_en?></textarea>

        </div>
        <div class="flex">
          &nbsp;
        </div>
        <div style="flex: 10;">

          <div class="smallpadding_bot">
            <label for="tasks_add_title_fr"><?=__('tasks_add_title_fr')?></label>
            <input type="text" class="indiv" id="tasks_add_title_fr" name="tasks_add_title_fr" value="<?=$tasks_add_title_fr?>">
          </div>

          <label for="tasks_add_body_fr"><?=__('tasks_add_body_fr')?></label>
          <textarea class="indiv" id="tasks_add_body_fr" name="tasks_add_body_fr"><?=$tasks_add_body_fr?></textarea>

        </div>
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_add_priority"><?=__('tasks_add_priority')?></label>
        <select class="indiv align_left" id="tasks_add_priority" name="tasks_add_priority">
          <?php for($i = 0; $i <= 5; $i++) { ?>
          <option value="<?=$i?>"<?=$tasks_add_priority_selected[$i]?>><?=__('tasks_list_state_'.$i)?></option>
          <?php } ?>
        </select>
      </div>

      <div class="flexcontainer smallpadding_bot" id="task_categories_selector">

        <?php } if(!isset($_POST['reload_milestones'])) { ?>

        <div class="tasks_edit_category">

          <label for="tasks_add_category"><?=string_change_case(__('category'), 'initials')?></label>
          <select class="indiv align_left" id="tasks_add_category" name="tasks_add_category">
            <option value="0" selected>&nbsp;</option>
            <?php for($i = 0; $i < $tasks_categories['rows']; $i++) { ?>
            <option value="<?=$tasks_categories[$i]['id']?>"<?=$tasks_add_category_selected[$i]?>><?=$tasks_categories[$i]['title']?></option>
            <?php } ?>
          </select>

        </div>
        <div class="flex align_center tasks_edit_category_icon nowrap">

          <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_categories_popin();")?>

          <?=__icon('refresh', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_categories_reload('add')")?>

        </div>

        <?php } if(!page_is_fetched_dynamically()) { ?>

      </div>

      <div class="flexcontainer smallpadding_bot" id="task_milestones_selector">

        <?php } if(!isset($_POST['reload_categories'])) {?>

        <div class="tasks_edit_category">

          <label for="tasks_add_milestone"><?=__('tasks_add_milestone')?></label>
          <select class="indiv align_left" id="tasks_add_milestone" name="tasks_add_milestone">
            <option value="0" selected>&nbsp;</option>
            <?php for($i = 0; $i < $tasks_milestones['rows']; $i++) { ?>
            <option value="<?=$tasks_milestones[$i]['id']?>"<?=$tasks_add_milestone_selected[$i]?>><?=$tasks_milestones[$i]['title']?></option>
            <?php } ?>
          </select>

        </div>
        <div class="flex align_center tasks_edit_category_icon nowrap">

          <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_milestones_popin();")?>

          <?=__icon('refresh', alt: 'E', title: __('edit'), title_case: 'initials', class: 'valign_middle pointer spaced', onclick: "tasks_milestones_reload('add');")?>

        </div>

        <?php } if(!page_is_fetched_dynamically()) { ?>

      </div>

      <input type="checkbox" id="tasks_add_private" name="tasks_add_private"<?=$tasks_add_private?>>
      <label class="label_inline" for="tasks_add_private"><?=__('tasks_add_private')?></label><br>

      <input type="checkbox" id="tasks_add_silent" name="tasks_add_silent"<?=$tasks_add_silent?>>
      <label class="label_inline" for="tasks_add_silent"><?=__('tasks_add_silent')?></label>

      <?php if(isset($tasks_add)) { ?>
      <div class="smallpadding_top smallpadding_bot">
        <div class="red text_white uppercase bold spaced big">
          <?=__('error').__(':', spaces_after: 1).$tasks_add?>
        </div>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="tasks_add_submit" value="<?=__('tasks_add_submit')?>">
        <input type="submit" name="tasks_add_preview" value="<?=__('preview')?>">
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