

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/functions_time.inc.php';        # Time
include_once './../../inc/functions_mathematics.inc.php'; # Maths
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../actions/admin.act.php';             # Actions
include_once './../../actions/users.act.php';             # User list
include_once './../../lang/admin.lang.php';               # Translations

// Limit page access rights
user_restrict_to_moderators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/ban";
$page_title_en    = "Bans";
$page_title_fr    = "Bannissements";

// Extra JS
$js = array('admin/ban', 'users/autocomplete_nickname');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ban a user

// Hide the french ban justification in the english interface
$admin_ban_hide_french = ($lang == 'EN') ? ' hidden' : '';

// Fetch the ban form values, that way they can be kept as is after submitting
$admin_ban_add_nick       = form_fetch_element('admin_ban_add_nick', '');
$admin_ban_add_reason_en  = form_fetch_element('admin_ban_add_reason_en', '');
$admin_ban_add_reason_fr  = form_fetch_element('admin_ban_add_reason_fr', '');
$admin_ban_add_length     = form_fetch_element('admin_ban_add_length', 0);

// Keep the ban length selector as is aswell by setting the correct element to selected
$admin_ban_add_selector_values = array(0, 1, 7, 30, 365, 3650);
foreach($admin_ban_add_selector_values as $value)
  $admin_ban_add_selector[$value] = ($admin_ban_add_length == $value) ? ' selected' : '';

// If the ban length selector isn't in use, make the empty option the default one
if(!isset($_POST['admin_ban_add_length']))
  $admin_ban_add_selector[0] = ' selected';

// Submit the ban request
if(isset($_POST['admin_ban_add_submit']))
{
  $admin_ban_add_error = admin_ban_user(  user_get_id()             ,
                                          $admin_ban_add_nick       ,
                                          $admin_ban_add_length     ,
                                          $admin_ban_add_reason_en  ,
                                          $admin_ban_add_reason_fr  ,
                                          $lang                     );

  // Reset the nickname to allow chain bans, unless the ban request resulted in an error
  if(!$admin_ban_add_error)
    $admin_ban_add_nick     = '';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// List of banned users

$banned_users = users_get_list('banned', 0, 0, 0, 0, 0, 1, 0, 0, $lang);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a ban history log

if(isset($_POST['admin_ban_logs_delete']))
  admin_ban_logs_delete(  form_fetch_element('admin_ban_logs_delete') ,
                          $lang                                       );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ban history

$ban_logs = admin_ban_logs_get_list(  $lang                                                         ,
                                      form_fetch_element('admin_ban_logs_sorting_order', 'banned')  ,
                                      form_fetch_element('admin_ban_logs_search_status', -1)        ,
                                      form_fetch_element('admin_ban_logs_search_username')          ,
                                      form_fetch_element('admin_ban_logs_search_banner')            ,
                                      form_fetch_element('admin_ban_logs_search_unbanner')          );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div id="ban_log_popin" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('ban_log_popin');">&times;</a>
    <div id="admin_ban_popin_log">
      &nbsp;
    </div>
  </div>
</div>

<div class="width_50 align_center">

  <h1>
    <?=__('admin_ban_title')?>
  </h1>

</div>

<div class="width_30 bigpadding_top bigpadding_bot">

  <h5 class="smallpadding_bot">
    <?=__('admin_ban_add_title')?>
  </h5>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="admin_ban_add_nick"><?=__('admin_ban_add_nickname')?></label>
        <input class="indiv" type="text" id="admin_ban_add_nick" name="admin_ban_add_nick" value="<?=$admin_ban_add_nick?>" autocomplete="off" list="admin_ban_add_nick_list" onkeyup="autocomplete_nickname('admin_ban_add_nick', 'admin_ban_add_nick_list_parent', './../users/autocomplete_nickname', 'admin_ban_add_nick_list', 'ban');">
        <div id="admin_ban_add_nick_list_parent">
          <datalist id="admin_ban_add_nick_list">
            <option value=" ">
          </datalist>
        </div>
      </div>

      <div class="smallpadding_bot<?=$admin_ban_hide_french?>">
        <label for="admin_ban_add_reason_fr"><?=__('admin_ban_add_reason_fr')?></label>
        <input class="indiv" type="text" id="admin_ban_add_reason_fr" name="admin_ban_add_reason_fr" value="<?=$admin_ban_add_reason_fr?>">
      </div>

      <div class="smallpadding_bot">
        <label for="admin_ban_add_reason_en"><?=__('admin_ban_add_reason_en')?></label>
        <input class="indiv" type="text" id="admin_ban_add_reason_en" name="admin_ban_add_reason_en" value="<?=$admin_ban_add_reason_en?>">
      </div>

      <div class="padding_bot">
        <label for="admin_ban_add_length"><?=__('admin_ban_add_duration')?></label>
        <select class="indiv" id="admin_ban_add_length" name="admin_ban_add_length">
          <option value="0"<?=$admin_ban_add_selector[0]?>>&nbsp;</option>
          <option value="1"<?=$admin_ban_add_selector[1]?>><?=__('admin_ban_add_duration_1d')?></option>
          <option value="7"<?=$admin_ban_add_selector[7]?>><?=__('admin_ban_add_duration_1w')?></option>
          <option value="30"<?=$admin_ban_add_selector[30]?>><?=__('admin_ban_add_duration_1m')?></option>
          <option value="365"<?=$admin_ban_add_selector[365]?>><?=__('admin_ban_add_duration_1y')?></option>
          <option value="3650"<?=$admin_ban_add_selector[3650]?>><?=__('admin_ban_add_duration_10y')?></option>
        </select>
      </div>

      <?php if(isset($admin_ban_add_error)) { ?>
      <div class="padding_bot">
        <span class="bold big red spaced">
          <?=string_change_case(__('error'), 'uppercase').__(':', 0, 0, 1).$admin_ban_add_error?>
        </span>
      </div>
      <?php } ?>

      <input type="submit" name="admin_ban_add_submit" value="<?=__('admin_ban_add_button')?>">

    </fieldset>
  </form>

</div>

<?php if($banned_users['rows']) { ?>

<hr>

<div class="width_70 smallpadding_top bigpadding_bot" id="active">

  <h2 class="align_center padding_top">
    <?=__('admin_ban_list_title')?>
  </h2>
  <h5 class="align_center bigpadding_bot">
    <?=__('admin_ban_list_subtitle')?>
  </h5>

  <table class="nowrap">
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('nickname')?>
        </th>
        <th>
          <?=__('admin_ban_list_start')?>
        </th>
        <th class="desktop">
          <?=__('admin_ban_list_length')?>
        </th>
        <th>
          <?=__('admin_ban_list_end')?>
        </th>
        <th class="desktop">
          <?=__('admin_ban_list_served')?>
        </th>
        <th>
          <?=__('reason')?>
        </th>
        <th>
          <?=__('action+')?>
        </th>
      </tr>

    </thead>
    <tbody class="align_center">

      <?php for($i = 0; $i < $banned_users['rows']; $i++) { ?>

      <tr>

        <td>
          <?=__link('todo_link?id='.$banned_users[$i]['id'], $banned_users[$i]['nickname'], $banned_users[$i]['css'])?>
        </td>

        <td>
          <div class="tooltip_container">
            <?=$banned_users[$i]['ban_start']?>
            <div class="tooltip">
              <?=$banned_users[$i]['ban_startf']?>
            </div>
          </div>
        </td>

        <td class="desktop">
          <?=$banned_users[$i]['ban_length'].__('day', $banned_users[$i]['ban_length'], 1)?>
        </td>

        <td>
          <div class="tooltip_container">
            <?=$banned_users[$i]['ban_end']?>
            <div class="tooltip">
              <?=$banned_users[$i]['ban_endf']?>
            </div>
          </div>
        </td>

        <td class="desktop">
          <?=$banned_users[$i]['ban_served'].__('day', $banned_users[$i]['ban_served'], 1)?>
        </td>

        <td>
          <?php if($banned_users[$i]['ban_full']) { ?>
          <div class="tooltip_container">
            <?=$banned_users[$i]['ban_reason']?>
            <div class="tooltip dowrap">
              <?=$banned_users[$i]['ban_full']?>
            </div>
          </div>
          <?php } else { ?>
          <?=$banned_users[$i]['ban_reason']?>
          <?php } ?>
        </td>

        <td>
          <?=__link('#ban_log_popin', '<img class="smallicon valign_middle pointer spaced" src="'.$path.'img/icons/info.svg" alt="M" title="'.string_change_case(__('details'), 'initials').'">', 'noglow', 0, $path, 'admin_ban_fetch_log(0, '.$banned_users[$i]['id'].');')?>
          <?=__link('pages/admin/ban_edit?user='.$banned_users[$i]['id'], '<img class="smallicon valign_middle pointer spaced" src="'.$path.'img/icons/edit_small.svg" alt="M" title="'.string_change_case(__('modify'), 'initials').'">', 'noglow')?>
          <?=__link('pages/admin/ban_delete?user='.$banned_users[$i]['id'], '<img class="smallicon valign_middle pointer spaced" src="'.$path.'img/icons/delete_small.svg" alt="X" title="'.string_change_case(__('delete'), 'initials').'">', 'noglow')?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>


<?php } ?>

<hr>

<div class="width_80 smallpadding_top">

  <h2 class="align_center padding_top padding_bot">
    <?=__('admin_ban_logs_title')?>
  </h2>

  <fieldset class="bigpadding_bot align_center">
    <table class="nowrap">
      <thead>

        <tr class="uppercase">
          <th>
            <?=__('nickname')?>
            <img class="smallicon pointer valign_middle spaced_right" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_ban_search_logs('username');">
          </th>
          <th>
            <?=__('admin_ban_logs_start')?>
            <img class="smallicon pointer valign_middle spaced_right" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_ban_search_logs('banned');">
          </th>
          <th>
            <?=__('admin_ban_logs_end')?>
            <img class="smallicon pointer valign_middle spaced_right" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_ban_search_logs('unbanned');">
          </th>
          <th class="desktop">
            <?=__('admin_ban_logs_length')?>
            <img class="smallicon pointer valign_twolines spaced_right" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_ban_search_logs('sentence');">
          </th>
          <th  class="desktop">
            <?=__('admin_ban_logs_served')?>
            <img class="smallicon pointer valign_twolines spaced_right" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="admin_ban_search_logs('served');">
          </th>
          <th class="desktop">
            <?=__('admin_ban_logs_percent')?>
          </th>
          <th>
            <?=__('admin_ban_logs_banned_by')?>
          </th>
          <th>
            <?=__('admin_ban_logs_unbanned_by')?>
          </th>
          <th class="desktop">
            <?=__('admin_ban_logs_ban_reason')?>
          </th>
          <th class="desktop">
            <?=__('admin_ban_logs_unban_reason')?>
          </th>
          <th>
            <?=__('act')?>
          </th>
        </tr>

        <tr>
          <th>
            <input type="hidden" class="hidden" value="banned" name="admin_ban_logs_sorting_order" id="admin_ban_logs_sorting_order">
            <input type="text" class="table_search" name="admin_ban_logs_search_username" id="admin_ban_logs_search_username" value="" onkeyup="admin_ban_search_logs()">
          </th>
          <th colspan="2">
            <select class="table_search" name="admin_ban_logs_search_status" id="admin_ban_logs_search_status" onchange="admin_ban_search_logs()">
              <option value="-1">&nbsp;</option>
              <option value="1"><?=__('admin_ban_logs_status_banned')?></option>
              <option value="0"><?=__('admin_ban_logs_status_free')?></option>
            </select>
          </th>
          <th colspan="3" class="desktop">
            &nbsp;
          </th>
          <th>
            <input type="text" class="table_search" name="admin_ban_logs_search_banner" id="admin_ban_logs_search_banner" value="" onkeyup="admin_ban_search_logs()">
          </th>
          <th>
            <input type="text" class="table_search" name="admin_ban_logs_search_unbanner" id="admin_ban_logs_search_unbanner" value="" onkeyup="admin_ban_search_logs()">
          </th>
          <th colspan="2" class="desktop">
            &nbsp;
          </th>
          <th>
            &nbsp;
          </th>
        </tr>

      </thead>

      <?php } ?>

      <tbody class="align_center altc2" id="admin_ban_logs_tbody">

        <tr>
          <?php if($ban_logs['rows']) { ?>
          <td colspan="11" class="uppercase text_light dark bold">
            <?=__('admin_ban_logs_info_found', 0, 0, 0, array($ban_logs['rows']))?>
          </td>
          <?php } else { ?>
          <td colspan="11" class="uppercase text_light red bold">
            <?=__('admin_ban_logs_info_none')?>
          </td>
          <?php } ?>
        </tr>

        <?php for($i = 0; $i < $ban_logs['rows']; $i++) { ?>

        <tr>

          <td>
            <?=__link('todo_link?id='.$ban_logs[$i]['user_id'], $ban_logs[$i]['nickname'], 'bold noglow')?>
          </td>

          <td>
            <div class="tooltip_container">
              <?=$ban_logs[$i]['start']?>
              <div class="tooltip dowrap">
                <?=$ban_logs[$i]['start_full']?>
              </div>
            </div>
          </td>

          <td>
            <?php if($ban_logs[$i]['end']) { ?>
            <div class="tooltip_container">
              <?=$ban_logs[$i]['end']?>
              <div class="tooltip dowrap">
                <?=$ban_logs[$i]['end_full']?>
              </div>
            </div>
            <?php } else { ?>
            <?=$ban_logs[$i]['end']?>
            <?php } ?>
          </td>

          <td class="desktop">
            <?=$ban_logs[$i]['duration']?>
          </td>

          <td  class="desktop">
            <?=$ban_logs[$i]['served']?>
          </td>

          <td class="desktop">
            <?=$ban_logs[$i]['served_percent']?>
          </td>

          <td>
            <?=__link('todo_link?id='.$ban_logs[$i]['banned_by_id'], $ban_logs[$i]['banned_by'], 'bold noglow')?>
          </td>

          <td>
            <?php if($ban_logs[$i]['unbanned_by']) { ?>
            <?=__link('todo_link?id='.$ban_logs[$i]['unbanned_by_id'], $ban_logs[$i]['unbanned_by'], 'bold noglow')?>
            <?php } ?>
          </td>

          <td class="desktop">
            <?php if($ban_logs[$i]['ban_reason_full']) { ?>
            <div class="tooltip_container">
              <?=$ban_logs[$i]['ban_reason']?>
              <div class="tooltip dowrap">
                <?=$ban_logs[$i]['ban_reason_full']?>
              </div>
            </div>
            <?php } else { ?>
            <?=$ban_logs[$i]['ban_reason']?>
            <?php } ?>
          </td>

          <td class="desktop">
            <?php if($ban_logs[$i]['unban_reason_full']) { ?>
            <div class="tooltip_container">
              <?=$ban_logs[$i]['unban_reason']?>
              <div class="tooltip dowrap">
                <?=$ban_logs[$i]['unban_reason_full']?>
              </div>
            </div>
            <?php } else { ?>
            <?=$ban_logs[$i]['unban_reason']?>
            <?php } ?>
          </td>

          <td>
            <?=__link('#ban_log_popin', '<img class="smallicon valign_middle pointer" src="'.$path.'img/icons/info.svg" alt="M" title="'.string_change_case(__('details'), 'initials').'">', 'noglow', 0, $path, 'admin_ban_fetch_log('.$ban_logs[$i]['id'].');')?>
            <?php if($is_admin) { ?>
            <img class="smallicon valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="<?=string_change_case(__('delete'), 'initials')?>" onclick="admin_ban_delete_log('<?=$ban_logs[$i]['id']?>', '<?=__('admin_ban_logs_info_delete')?>')">
            <?php } ?>
          </td>

        </tr>

      <?php } ?>

      </tbody>

    <?php if(!page_is_fetched_dynamically()) { ?>

    </table>

  </fieldset>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }