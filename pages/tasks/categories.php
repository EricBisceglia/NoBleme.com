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
// Create a new task category

if(isset($_POST['task_category_create']))
{
  // Prepare an array with the category data
  $tasks_category_add_data = array( 'title_en'  => form_fetch_element('task_category_name_en')  ,
                                    'title_fr'  => form_fetch_element('task_category_name_fr')  );

  // Create the task category
  tasks_categories_add($tasks_category_add_data);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit a task category

if(isset($_POST['task_category_edit']))
{
  // Fetch the task category id
  $tasks_category_edit_id = (int)form_fetch_element('task_category_edit');

  // Prepare an array with the category data
  $tasks_category_edit_data = array(  'title_en'  => form_fetch_element('task_category_edit_name_en') ,
                                      'title_fr'  => form_fetch_element('task_category_edit_name_fr') );

  // Edit the task category
  tasks_categories_edit(  $tasks_category_edit_id   ,
                          $tasks_category_edit_data );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a task category

if(isset($_POST['task_category_delete']))
{
  tasks_categories_delete(form_fetch_element('task_category_delete'));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch task categories

$task_categories = tasks_categories_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<table>
  <thead>

    <tr class="uppercase">

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
        <input type="text" class="table_search" name="tasks_categories_add_english" id="tasks_categories_add_english" value="" size="1">
      </th>

      <th>
        <input type="text" class="table_search" name="tasks_categories_add_french" id="tasks_categories_add_french" value="" size="1">
      </th>

      <th>
        <input type="submit" class="table_search" name="tasks_categories_add_submit" id="tasks_categories_add_submit" value="<?=string_change_case(__('add'), 'initials')?>" onclick="tasks_categories_add();">
      </th>

    </tr>

  </thead>
  <tbody class="doublealtc">

    <?php for($i = 0; $i < $task_categories['rows']; $i++) { ?>

    <tr class="align_center">

      <td>
        <?=$task_categories[$i]['title_en']?>
      </td>

      <td>
        <?=$task_categories[$i]['title_fr']?>
      </td>

      <td>
        <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', onclick: "tasks_categories_edit_form('".$task_categories[$i]['id']."');")?>
        <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "tasks_categories_delete('".$task_categories[$i]['id']."', '".__('tasks_categories_delete')."');")?>
      </td>

    </tr>

    <tr class="hidden" id="tasks_categories_edit_form_<?=$task_categories[$i]['id']?>">
      <td colspan="3">

      <div class="padding_top smallpadding_bot">
        <label for="tasks_categories_edit_english_<?=$task_categories[$i]['id']?>"><?=__('tasks_categories_title_en')?></label>
        <input type="text" class="intable light text_dark" id="tasks_categories_edit_english_<?=$task_categories[$i]['id']?>" name="tasks_categories_edit_english_<?=$task_categories[$i]['id']?>" value="<?=$task_categories[$i]['title_en']?>">
      </div>

      <div class="smallpadding_bot">
        <label for="tasks_categories_edit_french_<?=$task_categories[$i]['id']?>"><?=__('tasks_categories_title_fr')?></label>
        <input type="text" class="intable light text_dark" id="tasks_categories_edit_french_<?=$task_categories[$i]['id']?>" name="tasks_categories_edit_french_<?=$task_categories[$i]['id']?>" value="<?=$task_categories[$i]['title_fr']?>">
      </div>

      <div class="smallpadding_top padding_bot">
        <input type="submit" class="light text_dark spaced" name="tasks_categories_edit_submit_<?=$task_categories[$i]['id']?>" value="<?=__('tasks_categories_edit')?>" onclick="tasks_categories_edit('<?=$task_categories[$i]['id']?>');">
        <input type="submit" class="black text_white spaced" name="tasks_categories_edit_close_<?=$task_categories[$i]['id']?>" value="<?=__('tasks_categories_close')?>" onclick="tasks_categories_edit_form('<?=$task_categories[$i]['id']?>');">
      </div>

      </td>
    </tr>

    <?php } ?>

  </tbody>
</table>