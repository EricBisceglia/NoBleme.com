<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';                # Core
include_once './../../inc/functions_time.inc.php';          # Time management
include_once './../../actions/user.act.php';                # Admin list
include_once './../../actions/user_management.act.php';     # Actions
include_once './../../lang/admin/user_management.lang.php'; # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/user_rights";
$page_title_en    = "User rights";
$page_title_fr    = "Permissions";

// Extra JS
$js = array('users/autocomplete_username');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Change account rights

// Fetch the form values
$admin_rights_username  = form_fetch_element('admin_rights_username', NULL);
$admin_rights_level     = form_fetch_element('admin_rights_level', -1);

// Change the account rights
if(isset($_POST['admin_rights_submit']))
{
  $admin_rights_error = admin_account_change_rights(  $admin_rights_username  ,
                                                      $admin_rights_level     );

  // If all went well, reset the form values
  if(!$admin_rights_error)
  {
    $admin_rights_username  = '';
    $admin_rights_level     = -1;
  }
}

// Set the correct rights to selected to preserve the form's selection
for($i = -1; $i <= 2; $i++)
  $admin_rights_level_selector[$i] = ($admin_rights_level == $i) ? ' selected' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Administrative team list

$admin_list = user_list_admins('activity');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center bigpadding_bot">
    <?=__('admin_rights_title')?>
  </h1>

</div>

<div class="width_30 bigpadding_bot">

  <h4 class="align_center padding_bot">
    <?=__('admin_rights_form_title')?>
  </h4>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="admin_rights_username"><?=string_change_case(__('username'), 'initials')?></label>
        <input class="indiv" type="text" id="admin_rights_username" name="admin_rights_username" value="<?=$admin_rights_username?>" autocomplete="off" list="admin_rights_username_list" onkeyup="autocomplete_username('admin_rights_username', 'admin_rights_username_list_parent', './../common/autocomplete_username', 'admin_rights_username_list', 'normal');">
      </div>
      <div id="admin_rights_username_list_parent">
        <datalist id="admin_rights_username_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <div class="padding_bot">
        <label for="admin_rights_level"><?=string_change_case(__('rights'), 'initials')?></label>
        <select class="indiv align_left" id="admin_rights_level" name="admin_rights_level">
          <option value="-1"<?=$admin_rights_level_selector[-1]?>>&nbsp;</option>
          <option value="0" class="black bold"<?=$admin_rights_level_selector[0]?>><?=string_change_case(__('user'), 'initials')?></option>
          <option value="1" class="orange bold"<?=$admin_rights_level_selector[1]?>><?=string_change_case(__('moderator'), 'initials')?></option>
          <option value="2" class="red bold"<?=$admin_rights_level_selector[2]?>><?=string_change_case(__('administrator'), 'initials')?></option>
        </select>
      </div>

      <?php if(isset($admin_rights_error)) { ?>
      <div class="padding_bot">
        <h5 class="spaced uppercase red text_white">
          <?=__('error').__(':', 0, 0, 1).$admin_rights_error?>
        </h5>
      </div>
      <?php } ?>

      <input type="submit" name="admin_rights_submit" value="<?=__('admin_rights_submit')?>">

    </fieldset>
  </form>

</div>

<hr>

<div class="width_30 bigpadding_top">

  <h4 class="align_center bigpadding_bot">
    <?=__('admin_rights_list_title')?>
  </h4>

  <table>
    <thead class="uppercase">

      <tr>
        <th>
          <?=__('username')?>
        </th>
        <th>
          <?=__('rights')?>
        </th>
        <th>
          <?=__('activity')?>
        </th>
      </tr>

    </thead>
    <tbody class="align_center">

      <?php for($i = 0; $i < $admin_list['rows'] ; $i++) { ?>

      <tr>
        <td>
          <?=__link('todo_link?id='.$admin_list[$i]['id'], $admin_list[$i]['username'], $admin_list[$i]['css'])?>
        </td>
        <td class="<?=$admin_list[$i]['css']?>">
          <?=$admin_list[$i]['title']?>
        </td>
        <td>
          <?=$admin_list[$i]['activity']?>
        </td>
      </tr>

      <?php } ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }