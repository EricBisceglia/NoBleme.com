

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';       # Core
include_once './../../inc/functions_time.inc.php'; # Time
include_once './../../actions/admin.act.php';      # Actions
include_once './../../actions/users.act.php';      # User list
include_once './../../lang/admin.lang.php';        # Translations

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
$js = array('users/autocomplete_nickname');




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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

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
          <?=__('admin_ban_list_end')?>
        </th>
        <th>
          <?=__('admin_ban_list_start')?>
        </th>
        <th>
          <?=__('admin_ban_list_length')?>
        </th>
        <th>
          <?=__('admin_ban_list_purged')?>
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
            <?=$banned_users[$i]['ban_end']?>
            <div class="tooltip">
              <?=$banned_users[$i]['ban_endf']?>
            </div>
          </div>
        </td>

        <td>
          <div class="tooltip_container">
            <?=$banned_users[$i]['ban_start']?>
            <div class="tooltip">
              <?=$banned_users[$i]['ban_startf']?>
            </div>
          </div>
        </td>

        <td>
          <?=$banned_users[$i]['ban_length'].__('day', $banned_users[$i]['ban_length'], 1)?>
        </td>

        <td>
          <?=$banned_users[$i]['ban_purged'].__('day', $banned_users[$i]['ban_purged'], 1)?>
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

        <td class="align_center">
          <?=__link('pages/admin/ban_edit?user='.$banned_users[$i]['id'], '<img class="smallicon valign_middle pointer spaced" src="'.$path.'img/icons/edit_small.svg" alt="M" title="'.string_change_case(__('modify'), 'initials').'">', 'noglow')?>
          <?=__link('todo_link?user='.$banned_users[$i]['id'], '<img class="smallicon valign_middle pointer spaced" src="'.$path.'img/icons/delete_small.svg" alt="X" title="'.string_change_case(__('delete'), 'initials').'">', 'noglow')?>
        </td>

      </tr>

      <?php } ?>

    </tbody>
  </table>

</div>

<?php } ?>

<hr>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }