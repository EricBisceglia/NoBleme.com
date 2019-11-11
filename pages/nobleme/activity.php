<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';       # Core
include_once './../../actions/nobleme.act.php';    # Actions
include_once './../../lang/nobleme.lang.php';      # Translations
include_once './../../inc/functions_time.inc.php'; # Time management
include_once './../../inc/activity.inc.php';       # Activity log parsing

// Limit page access rights
if(isset($_GET['mod']))
  user_restrict_to_global_moderators($lang);

// Menus
$header_menu      = (!isset($_GET['mod'])) ? 'NoBleme' : 'Admin';
$header_sidemenu  = (!isset($_GET['mod'])) ? 'Activity' : 'Modlogs';

// User activity
$page_name  = "activity";
$page_url   = "pages/nobleme/activity";

// Page summary
$page_lang        = array('FR', 'EN');
$page_title       = (!isset($_GET['mod'])) ? __('activity_page_title') : __('activity_page_title_modlogs');
$page_description = __('activity_page_description');

// Extra JS
$js = array('xhr', 'toggle', 'nobleme/activity');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare an url for xhr calls, depending on whether we're on recent activity or moderation logs

$xhr_logs_url = (!isset($_GET['mod'])) ? "activity" : "activity?mod";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch recent activity

// Sanitize postdata
$activity_modlogs = isset($_GET['mod']);
$activity_amount  = sanitize_input('POST', 'activity_amount', 'int', 100, 100, 1000);
$activity_type    = sanitize_input('POST', 'activity_type', 'string', 'all');

// Only allow admins to see deleted activity
if($activity_type == 'deleted' && !$is_admin)
  $activity_type = 'all';

// Fetch the activity logs
$activity_logs = activity_get_logs($activity_modlogs, $activity_amount, $activity_type, $path, $lang);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Set deletion type to soft or hard depending on the view

$deletion_type = ($activity_type == 'deleted' && $is_admin) ? 1 : 0;






/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_xhr()) { /*******************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_40">

        <?php if(!isset($_GET['mod'])) { ?>

        <h1 class="align_center bigpadding_bot">
          <?=__('activity_page_title')?>

          <?php if($is_admin) { ?>
          <img class="pointer" src="<?=$path?>img/icons/delete.svg" alt="X" height="30" onclick="activity_submit_menus('<?=$path?>', '<?=$xhr_logs_url?>', 1);">
          <?php } ?>

        </h1>

        <?php } else { ?>

        <h1 class="align_center padding_bot">
          <?=__('activity_page_title_modlogs')?>

          <?php if($is_admin) { ?>
          <img class="pointer" src="<?=$path?>img/icons/delete.svg" alt="X" height="30" onclick="activity_submit_menus('<?=$path?>', '<?=$xhr_logs_url?>', 1);">
          <?php } ?>

        </h1>

        <p class="bigpadding_bot">
          <?=__('activity_mod_info', null, 0, 0, array($path))?>
        </p>

        <?php } ?>

      </div>
      <div class="width_60">

        <div class="align_center bigpadding_bot">

          <select id="activity_amount" onchange="activity_submit_menus('<?=$path?>', '<?=$xhr_logs_url?>');">
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="500">500</option>
            <option value="1000">1000</option>
          </select>

          <span class="spaced bold bigger valign_bottom">
            <?=__('activity_latest_actions')?>
          </span>

          <select id="activity_type" onchange="activity_submit_menus('<?=$path?>', '<?=$xhr_logs_url?>');">
            <option value="all"><?=__('activity_type_all')?></option>
            <option value="users"><?=__('activity_type_users')?></option>
            <option value="meetups"><?=__('activity_type_meetups')?></option>
            <option value="internet"><?=__('activity_type_internet')?></option>
            <option value="quotes"><?=__('activity_type_quotes')?></option>
            <option value="writers"><?=__('activity_type_writers')?></option>
            <option value="dev"><?=__('activity_type_dev')?></option>
          </select>

        </div>

        <table id="activity_body">
          <?php } ?>
          <tbody class="align_center">

          <?php for($i = 0; $i < $activity_logs['rows']; $i++) { ?>
          <?php if($activity_logs[$i]['text']) { ?>
            <tr id="activity_row_<?=$activity_logs[$i]['id']?>">

              <?php if($activity_logs[$i]['href']) { ?>
              <td class="pointer <?=$activity_logs[$i]['css']?>" onclick="window.open('<?=$activity_logs[$i]['href']?>','_blank');">
              <?php } else { ?>
              <td class="<?=$activity_logs[$i]['css']?>">
              <?php } ?>
                <?=$activity_logs[$i]['date']?>
              </td>

              <?php if($activity_logs[$i]['href']) { ?>
              <td class="pointer <?=$activity_logs[$i]['css']?>" onclick="window.open('<?=$activity_logs[$i]['href']?>','_blank');">
              <?php } else { ?>
              <td class="<?=$activity_logs[$i]['css']?>">
              <?php } ?>
                <?=$activity_logs[$i]['text']?>
              </td>

              <?php if($is_admin || $activity_modlogs) { ?>
              <td class="<?=$activity_logs[$i]['css']?>">

                <?php if($activity_logs[$i]['details']) { ?>
                <img class="valign_center spaced pointer" src="<?=$path?>img/icons/help.svg" height="16" alt="?" onclick="activity_show_details('<?=$path?>', '<?=$activity_logs[$i]['id']?>');">
                <?php } if($is_admin) { ?>

                <?php if($deletion_type) { ?>
                <img class="valign_center pointer spaced_right" src="<?=$path?>img/icons/reload.svg" height="16" alt="R" onclick="activity_restore_log('<?=$path?>', '<?=$activity_logs[$i]['id']?>');">
                <?php } ?>
                <img class="valign_center pointer spaced_right" src="<?=$path?>img/icons/delete.svg" height="16" alt="X" onclick="activity_delete_log('<?=$path?>', '<?=$activity_logs[$i]['id']?>', '<?=addslashes(__('activity_delete'))?>', '<?=$deletion_type?>');">
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
          <?php if(!page_is_xhr()) { ?>
        </table>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }