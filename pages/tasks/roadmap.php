<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/bbcodes.inc.php';               # BBCodes
include_once './../../inc/functions_time.inc.php';        # Time management
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../actions/tasks.act.php';             # Actions
include_once './../../lang/tasks.lang.php';               # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/tasks/roadmap";
$page_title_en    = "Roadmap";
$page_title_fr    = "Plan de route";
$page_description = "Roadmap of NoBleme's past and future development";

// Extra CSS & JS
$css  = array('tasks');
$js   = array('tasks/list', 'tasks/edit', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Check if the page should enforce being viewed without administrator rights
$task_list_user_view = form_fetch_element('user', element_exists: true, request_type: 'GET');

// Fetch the tasks
$task_list = tasks_list(  'roadmap'                       ,
                          user_view: $task_list_user_view );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1>
    <?=__link('pages/tasks/list', __('tasks_roadmap_title'), 'noglow')?>
    <?php if($is_admin) { ?>
      <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/tasks/add')?>
      <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', onclick: "tasks_milestones_popin();")?>
      <?php if(!isset($_GET['user'])) { ?>
      <?=__icon('user', alt: 'U', title: __('tasks_roadmap_user'), href: 'pages/tasks/roadmap?user')?>
      <?php } else { ?>
      <?=__icon('user_delete', alt: 'A', title: __('tasks_roadmap_admin'), href: 'pages/tasks/roadmap')?>
      <?php } ?>
    <?php } ?>
  </h1>

  <p>
    <?=__('tasks_roadmap_body_1')?>
  </p>

  <p>
    <?=__('tasks_roadmap_body_2')?>
  </p>

  <?php for($i = 0; $i < $task_list['rows']; $i++) { ?>

  <?php if(!$i || $task_list[$i]['milestone'] != $task_list[$i - 1]['milestone']) { ?>

  </div>

<hr>

  <div class="width_50 padding_top bigpadding_bot">

  <h4 class="smallpadding_top align_center">
    <?=$task_list[$i]['milestone']?>
  </h4>

  <?php if($task_list[$i]['goal_body']) { ?>

  <p class="align_center">
    <?=$task_list[$i]['goal_body']?>
  </p>

  <?php } ?>

  <div class="bigpadding_top">
    <table>
      <thead>

        <tr class="uppercase nowrap">
          <th>
            <?=__('tasks_roadmap_task')?>
          </th>
          <th>
            <?=__('tasks_list_created')?>
          </th>
          <th>
            <?=__('tasks_list_solved')?>
          </th>
        </tr>

      </thead>
      <tbody>

  <?php } ?>

        <tr class="align_center nowrap pointer text_dark light_hover <?=$task_list[$i]['css_row']?>" onclick="tasks_list_details('<?=$task_list[$i]['id']?>');">

          <?php if($task_list[$i]['road_full']) { ?>
          <td class="bold align_left tooltip_container">
            <?php if($is_admin) { ?>
            #<?=$task_list[$i]['id']?> -
            <?php } ?>
            <?=$task_list[$i]['road_title']?>
            <div class="tooltip">
              <?=$task_list[$i]['road_full']?>
            </div>
          </td>
          <?php } else { ?>
          <td class="bold align_left">
            <?php if($is_admin) { ?>
            #<?=$task_list[$i]['id']?> -
            <?php } ?>
            <?=$task_list[$i]['road_title']?>
          </td>
          <?php } ?>

          <td>
            <?=$task_list[$i]['created']?>
          </td>

          <td>
            <?=$task_list[$i]['solved']?>
          </td>

        </tr>

        <tr class="hidden" id="tasks_list_row_<?=$task_list[$i]['id']?>">
          <td colspan="3" id="tasks_list_<?=$task_list[$i]['id']?>">
            &nbsp;
          </td>
        </tr>

  <?php if($i == ($task_list['rows'] - 1) || $task_list[$i]['milestone'] != $task_list[$i + 1]['milestone']) { ?>

      </tbody>
    </table>
  </div>

  <?php } ?>

  <?php } ?>

</div>

<?php if($is_admin) { ?>
<div id="task_milestones_popin" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('task_milestones_popin');">&times;</a>
    <div id="task_milestones_popin_body">
      &nbsp;
    </div>
  </div>
</div>
<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }