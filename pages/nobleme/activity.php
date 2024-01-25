<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/activity.inc.php';        # Activity log parsing
include_once './../../actions/activity.act.php';    # Actions
include_once './../../lang/activity.lang.php';      # Translations

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
$js   = array('nobleme/activity');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare an url for dynamic calls, depending on whether we're on recent activity or moderation logs

$activity_modlogs = form_fetch_element('mod', default_value: 0, element_exists: 1, request_type: 'GET');
$logs_url         = (!$activity_modlogs) ? "activity" : "activity?mod";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Check for a preset activity type

// Assemble a list of all allowed activity types
$activity_types = array('all', 'users', 'meetups', 'quotes', 'compendium', 'irc', 'dev');

// Check if one of the allowed activity types has been preselected
foreach($activity_types as $activity_type_entry)
{
  if(!isset($activity_type) && form_fetch_element($activity_type_entry, element_exists: true, request_type: 'GET'))
    $activity_type = $activity_type_entry;
}

// Set the activity type to a default value if none was preselected
$activity_type = (isset($activity_type)) ? $activity_type : 'all';

// Overwrite the activity type with the one in the search form if it is in use
$activity_type  = form_fetch_element('activity_type', request_type: 'POST')
                ? form_fetch_element('activity_type', 'all', request_type: 'POST')
                : $activity_type;

// Prepare the activity type dropdown menu selection
foreach($activity_types as $activity_type_entry)
  $activity_type_selected[$activity_type_entry] = ($activity_type === $activity_type_entry) ? ' selected' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch recent activity

$activity_deleted = form_fetch_element('activity_deleted', 0);
$activity_logs    = activity_list(  $activity_modlogs                           ,
                                    form_fetch_element('activity_amount', 100)  ,
                                    $activity_type                              ,
                                    $activity_deleted                           ,
                                    $is_admin                                   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Set deletion type to soft or hard depending on the view

$deletion_type = ($is_admin && $activity_deleted);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_60">

  <?php if(!isset($_GET['mod'])) { ?>

  <h1 class="align_center bigpadding_bot">

    <?php if($is_moderator) { ?>
    <?=__link('pages/nobleme/activity?mod', __('submenu_nobleme_activity'), 'noglow')?>
    <?php } else { ?>
    <?=__('submenu_nobleme_activity')?>
    <?php } ?>

    <?php if($is_admin) { ?>
    <?=__icon('delete', alt: 'X', title: __('activity_icon_deleted'), onclick: "activity_submit_menus('".$logs_url."', 1);")?>
    <?php } ?>

    <?php if($is_moderator) { ?>
    <?=__icon('user_confirm', href: 'pages/nobleme/activity?mod', alt: 'X', title: __('submenu_admin_modlogs'));?>
    <?php } ?>

  </h1>

  <?php } else { ?>

  <h1 class="align_center padding_bot">

    <?=__link('pages/nobleme/activity', __('submenu_admin_modlogs'), 'noglow')?>

    <?php if($is_admin) { ?>
    <?=__icon('delete', alt: 'X', title: __('activity_icon_deleted'), onclick: "activity_submit_menus('".$logs_url."', 1);")?>
    <?php } ?>

    <?php if($is_moderator) { ?>
    <?=__icon('user_delete', href: 'pages/nobleme/activity', alt: 'X', title: __('submenu_nobleme_activity'));?>
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
      <option value="all"<?=$activity_type_selected['all']?>><?=__('activity_type_all')?></option>
      <option value="users"<?=$activity_type_selected['users']?>><?=string_change_case(__('user_acc+'), 'initials')?></option>
      <option value="meetups"<?=$activity_type_selected['meetups']?>><?=__('activity_type_meetups')?></option>
      <?php if(!$activity_modlogs) { ?>
      <option value="quotes"<?=$activity_type_selected['quotes']?>><?=__('submenu_social_quotes')?></option>
      <option value="compendium"<?=$activity_type_selected['compendium']?>><?=__('submenu_pages_compendium')?></option>
      <?php } else { ?>
      <option value="irc"<?=$activity_type_selected['irc']?>><?=__('activity_type_irc')?></option>
      <?php } ?>
      <?php if(!$activity_modlogs) { ?>
      <option value="dev"<?=$activity_type_selected['dev']?>><?=__('activity_type_dev')?></option>
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
          <span class="tooltip_container tooltip_desktop">
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
          <span class="tooltip_container tooltip_desktop">
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
          <?=__icon('help', is_small: true, alt: '?', title: __('edit'), title_case: 'initials', onclick: "activity_show_details('".$activity_logs[$i]['id']."');")?>
          <?php } if($is_admin) { ?>
          <?php if($deletion_type) { ?>
          <?=__icon('refresh', is_small: true, class: 'valign_middle pointer spaced', alt: 'R', title: __('activity_restore'), onclick: "activity_restore_log('".$activity_logs[$i]['id']."');")?>
          <?php } ?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "activity_delete_log('".$activity_logs[$i]['id']."', '".addslashes(__('activity_delete'))."', '".$deletion_type."');")?>
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