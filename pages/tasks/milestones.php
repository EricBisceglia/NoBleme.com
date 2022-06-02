<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/tasks.act.php'; # Actions
include_once './../../lang/tasks.lang.php';   # Translations

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
// Create a new task milestone

if(isset($_POST['task_milestone_create']))
{
  // Prepare an array with the milestone data
  $tasks_milestone_add_data = array(  'order'     => form_fetch_element('task_milestone_order')   ,
                                      'title_en'  => form_fetch_element('task_milestone_name_en') ,
                                      'title_fr'  => form_fetch_element('task_milestone_name_fr') );

  // Create the task milestone
  tasks_milestones_add($tasks_milestone_add_data);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit a task milestone

if(isset($_POST['task_milestone_edit']))
{
  // Fetch the task milestone id
  $tasks_milestone_edit_id = (int)form_fetch_element('task_milestone_edit');

  // Prepare an array with the milestone data
  $tasks_milestone_edit_data = array( 'order'     => form_fetch_element('task_milestone_edit_order')    ,
                                      'title_en'  => form_fetch_element('task_milestone_edit_name_en')  ,
                                      'title_fr'  => form_fetch_element('task_milestone_edit_name_fr')  ,
                                      'body_en'   => form_fetch_element('task_milestone_edit_body_en')  ,
                                      'body_fr'   => form_fetch_element('task_milestone_edit_body_fr')  );

  // Edit the task milestone
  tasks_milestones_edit(  $tasks_milestone_edit_id   ,
                          $tasks_milestone_edit_data );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a task milestone

if(isset($_POST['task_milestone_delete']))
{
  tasks_milestones_delete(form_fetch_element('task_milestone_delete'));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch task milestones

$task_milestones = tasks_milestones_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<table>
  <thead>

    <tr class="uppercase">

      <th>
        <?=__('order')?>
      </th>

      <th>
        <?=__('english')?>
      </th>

      <th>
        <?=__('french')?>
      </th>

      <th>
        <?=__('action')?>
      </th>

    </tr>

    <tr>

      <th>
        <input type="text" class="table_search" name="tasks_milestones_add_order" id="tasks_milestones_add_order" value="" size="1">
      </th>

      <th>
        <input type="text" class="table_search" name="tasks_milestones_add_english" id="tasks_milestones_add_english" value="" size="1">
      </th>

      <th>
        <input type="text" class="table_search" name="tasks_milestones_add_french" id="tasks_milestones_add_french" value="" size="1">
      </th>

      <th>
        <input type="submit" class="table_search" name="tasks_milestones_add_submit" id="tasks_milestones_add_submit" value="<?=string_change_case(__('add'), 'initials')?>" onclick="tasks_milestones_add();">
      </th>

    </tr>

  </thead>
  <tbody class="doublealtc">

    <?php for($i = 0; $i < $task_milestones['rows']; $i++) { ?>

    <tr class="align_center">

      <td>
        <?=$task_milestones[$i]['order']?>
      </td>

      <td>
        <?=$task_milestones[$i]['title_en']?>
      </td>

      <td>
        <?=$task_milestones[$i]['title_fr']?>
      </td>

      <td>
        <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', onclick: "tasks_milestones_edit_form('".$task_milestones[$i]['id']."');")?>
        <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "tasks_milestones_delete('".$task_milestones[$i]['id']."', '".__('tasks_milestones_delete')."');")?>
      </td>

    </tr>

    <tr class="hidden" id="tasks_milestones_edit_form_<?=$task_milestones[$i]['id']?>">
      <td colspan="4">

      <div class="padding_top smallpadding_bot">
        <label for="tasks_milestones_edit_order_<?=$task_milestones[$i]['id']?>"><?=string_change_case(__('order'), 'initials')?></label>
        <input type="text" class="intable light text_dark" id="tasks_milestones_edit_order_<?=$task_milestones[$i]['id']?>" name="tasks_milestones_edit_order_<?=$task_milestones[$i]['id']?>" value="<?=$task_milestones[$i]['order']?>">
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_milestones_edit_english_<?=$task_milestones[$i]['id']?>"><?=__('tasks_milestones_title_en')?></label>
        <input type="text" class="intable light text_dark" id="tasks_milestones_edit_english_<?=$task_milestones[$i]['id']?>" name="tasks_milestones_edit_english_<?=$task_milestones[$i]['id']?>" value="<?=$task_milestones[$i]['title_en']?>">
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_milestones_edit_french_<?=$task_milestones[$i]['id']?>"><?=__('tasks_milestones_title_fr')?></label>
        <input type="text" class="intable light text_dark" id="tasks_milestones_edit_french_<?=$task_milestones[$i]['id']?>" name="tasks_milestones_edit_french_<?=$task_milestones[$i]['id']?>" value="<?=$task_milestones[$i]['title_fr']?>">
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_milestones_edit_body_en_<?=$task_milestones[$i]['id']?>"><?=__('tasks_milestones_body_en')?></label>
        <textarea class="intable light text_dark" id="tasks_milestones_edit_body_en_<?=$task_milestones[$i]['id']?>" name="tasks_milestones_edit_body_en_<?=$task_milestones[$i]['id']?>"><?=$task_milestones[$i]['body_en']?></textarea>
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_milestones_edit_body_fr_<?=$task_milestones[$i]['id']?>"><?=__('tasks_milestones_body_fr')?></label>
        <textarea class="intable light text_dark" id="tasks_milestones_edit_body_fr_<?=$task_milestones[$i]['id']?>" name="tasks_milestones_edit_body_fr_<?=$task_milestones[$i]['id']?>"><?=$task_milestones[$i]['body_fr']?></textarea>
      </div>

      <div class="smallpadding_top padding_bot">
        <input type="submit" class="light text_dark spaced" name="tasks_milestones_edit_submit_<?=$task_milestones[$i]['id']?>" value="<?=__('tasks_milestones_edit')?>" onclick="tasks_milestones_edit('<?=$task_milestones[$i]['id']?>');">
        <input type="submit" class="black text_white spaced" name="tasks_milestones_edit_close_<?=$task_milestones[$i]['id']?>" value="<?=__('close_form')?>" onclick="tasks_milestones_edit_form('<?=$task_milestones[$i]['id']?>');">
      </div>

      </td>
    </tr>

    <?php } ?>

  </tbody>
</table>