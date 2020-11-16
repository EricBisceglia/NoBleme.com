<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/functions_time.inc.php';        # Time management
include_once './../../inc/activity.inc.php';              # Activity log parsing
include_once './../../actions/nobleme/activity.act.php';  # Actions
include_once './../../lang/nobleme/activity.lang.php';    # Translations

// Limit page access rights
if(isset($_GET['mod']))
  user_restrict_to_moderators();

// Hide the page from who's online
if(isset($_GET['mod']))
  $hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/activity";
$page_title_en    = (!isset($_GET['mod'])) ? "Recent activity" : "Moderation logs";
$page_title_fr    = (!isset($_GET['mod'])) ? "Activité récente" : "Logs de modération";
$page_description = "Chronology of recent events that happened on NoBleme";

// Extra CSS & JS
$css  = array('pages');
$js   = array('common/toggle', 'nobleme/activity');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare an url for dynamic calls, depending on whether we're on recent activity or moderation logs

$activity_modlogs = form_fetch_element('mod', 0, 1, 'GET');
$logs_url         = (!$activity_modlogs) ? "activity" : "activity?mod";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch recent activity

$activity_deleted = form_fetch_element('activity_deleted', 0);
$activity_logs    = activity_list(  $activity_modlogs                           ,
                                    form_fetch_element('activity_amount', 100)  ,
                                    form_fetch_element('activity_type', 'all')  ,
                                    $activity_deleted                           ,
                                    $is_admin                                   ,
                                    $path                                       ,
                                    $lang                                       );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Set deletion type to soft or hard depending on the view

$deletion_type = ($is_admin && $activity_deleted) ? 1 : 0;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_60">

  <?php if(!isset($_GET['mod'])) { ?>

  <h1 class="align_center bigpadding_bot">
    <?=__('activity_title')?>

    <?php if($is_admin) { ?>
    <img class="pointer icon" src="<?=$path?>img/icons/delete.svg" alt="X" onclick="activity_submit_menus('<?=$logs_url?>', 1);">
    <?php } ?>

  </h1>

  <?php } else { ?>

  <h1 class="align_center padding_bot">
    <?=__('activity_title_modlogs')?>

    <?php if($is_admin) { ?>
    <img class="pointer icon" src="<?=$path?>img/icons/delete.svg" alt="X" onclick="activity_submit_menus('<?=$logs_url?>', 1);">
    <?php } ?>

  </h1>

  <p class="bigpadding_bot align_center">
    <?=__('activity_mod_info', null, 0, 0, array($path))?>
  </p>

  <?php } ?>

  <h5 class="align_center bigpadding_bot">

    <input type="hidden" class="hidden" id="activity_deleted" value="0">

    <select class="inh small activity_amount" id="activity_amount" onchange="activity_submit_menus('<?=$logs_url?>');">
      <option value="100">100</option>
      <option value="200">200</option>
      <option value="500">500</option>
      <option value="1000">1000</option>
      <?php if($is_admin) { ?>
      <option value="1001"><?=__('all')?></option>
      <?php } ?>
    </select>

    <?=__('activity_latest_actions')?>

    <select class="inh small activity_type" id="activity_type" onchange="activity_submit_menus('<?=$logs_url?>');">
      <option value="all"><?=__('activity_type_all')?></option>
      <option value="users"><?=__('activity_type_users')?></option>
      <option value="meetups"><?=__('activity_type_meetups')?></option>
      <?php if(!$activity_modlogs) { ?>
      <option value="internet"><?=__('activity_type_internet')?></option>
      <option value="quotes"><?=__('activity_type_quotes')?></option>
      <?php } ?>
      <?php if(!$activity_modlogs) { ?>
      <option value="dev"><?=__('activity_type_dev')?></option>
      <?php } ?>
    </select>

  </h5>

  <table id="activity_body">
    <?php } ?>
    <tbody class="align_center">

    <?php for($i = 0; $i < $activity_logs['rows']; $i++) { ?>
    <?php if($activity_logs[$i]['text']) { ?>
      <tr id="activity_row_<?=$activity_logs[$i]['id']?>">

        <?php if($activity_logs[$i]['href']) { ?>
        <td class="pointer nowrap <?=$activity_logs[$i]['css']?>" onclick="window.open('<?=$activity_logs[$i]['href']?>','_blank');">
        <?php } else { ?>
        <td class="nowrap <?=$activity_logs[$i]['css']?>">
        <?php } ?>
          <span class="tooltip_container">
          <?=$activity_logs[$i]['date']?>
            <span class="tooltip notbold">
              <?=$activity_logs[$i]['fulldate']?>
            </span>
          </span>
        </td>

        <?php if($activity_logs[$i]['href']) { ?>
        <td class="pointer <?=$activity_logs[$i]['css']?>" onclick="window.open('<?=$activity_logs[$i]['href']?>','_blank');">
        <?php } else { ?>
        <td class="<?=$activity_logs[$i]['css']?>">
        <?php } ?>

          <?php if(!$activity_logs[$i]['fulltext']) { ?>
          <?=$activity_logs[$i]['text']?>
          <?php } else { ?>
          <span class="tooltip_container">
            <?=$activity_logs[$i]['text']?>
            <span class="tooltip notbold">
              <?=$activity_logs[$i]['fulltext']?>
            </span>
          </span>
          <?php } ?>

        </td>

        <?php if($is_admin || $activity_modlogs) { ?>
        <td class="nowrap <?=$activity_logs[$i]['css']?>">

          <?php if($activity_logs[$i]['details']) { ?>
          <img class="smallicon valign_center spaced pointer" src="<?=$path?>img/icons/help.svg" alt="?" onclick="activity_show_details('<?=$activity_logs[$i]['id']?>');">
          <?php } if($is_admin) { ?>

          <?php if($deletion_type) { ?>
          <img class="smallicon valign_center pointer spaced_right" src="<?=$path?>img/icons/refresh.svg" alt="R" onclick="activity_restore_log('<?=$activity_logs[$i]['id']?>');">
          <?php } ?>
          <img class="smallicon valign_center pointer spaced_right" src="<?=$path?>img/icons/delete.svg" alt="X" onclick="activity_delete_log('<?=$activity_logs[$i]['id']?>', '<?=addslashes(__('activity_delete'))?>', '<?=$deletion_type?>');">
          <?php } ?>

        </td>
        <?php } ?>

      </tr>

    <?php if($activity_modlogs && $activity_logs[$i]['details']) { ?>

      <tr id="activity_details_<?=$activity_logs[$i]['id']?>" class="hidden">
        <td colspan="3" class="align_left spaced">
          &nbsp;
        </td>
      </tr>

    <?php } ?>

    <?php } ?>
    <?php } ?>

    </tbody>
    <?php if(!page_is_fetched_dynamically()) { ?>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }