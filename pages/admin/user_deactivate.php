<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../inc/functions_time.inc.php';      # Time management
include_once './../../actions/users.act.php';           # User list
include_once './../../actions/user_management.act.php'; # Actions
include_once './../../lang/user_management.lang.php';   # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/user_deactivate";
$page_title_en    = "Delete an account";
$page_title_fr    = "Supprimer un compte";

// Extra JS
$js = array('admin/user_management', 'users/autocomplete_username');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Deactivate an account

if(isset($_POST['admin_deactivate_submit']))
  $deactivate_error = admin_account_deactivate(form_fetch_element('admin_deactivate_username'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// List of deactivated accounts

// Prepare the sorting order
$deleted_users_sort = form_fetch_element('admin_reactivate_sort', 'deleted');

// Prepare the search parameters
$search['id']       = form_fetch_element('admin_reactivate_id', NULL);
$search['del_user'] = form_fetch_element('admin_reactivate_username', NULL);

// Fetch the list of deleted users
$deleted_users      = user_list($deleted_users_sort, $search, 0, 1);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 padding_bot">

  <h1 class="align_center">
    <?=__('admin_deactivate_title')?>
  </h1>

</div>

<div class="width_30 bigpadding_bot">

  <p class="padding_bot">
    <?=__('admin_deactivate_warning')?>
  </p>

  <form method="POST">
    <fieldset>

      <label for="admin_deactivate_username"><?=string_change_case(__('username'), 'initials')?></label>
      <input class="indiv" type="text" id="admin_deactivate_username" name="admin_deactivate_username" value="" autocomplete="off" list="admin_deactivate_username_list" onkeyup="autocomplete_username('admin_deactivate_username', 'admin_deactivate_username_list_parent', './../common/autocomplete_username', 'admin_deactivate_username_list', 'normal');">
      <div id="admin_deactivate_username_list_parent">
        <datalist id="admin_deactivate_username_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <?php if(isset($_POST['admin_deactivate_submit'])) { ?>
      <div class="padding_top">
        <?php if($deactivate_error) { ?>
        <h5 class="align_center uppercase text_white red">
          <?=__('error').__(':', 0, 0, 1).$deactivate_error?>
        </h5>
        <?php } else { ?>
        <h5 class="align_center uppercase text_white green">
          <?=__('admin_deactivate_success')?>
        </h5>
        <?php } ?>
      </div>
      <?php } ?>

      <div class="padding_top">
        <input type="submit" name="admin_deactivate_submit" value="<?=__('admin_deactivate_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php if($is_admin && $deleted_users['rows']) { ?>

<hr>

<div class="width_40 padding_top">

  <h2 class="align_center padding_bot">
    <?=__('admin_deactivate_list_title')?>
  </h2>

  <table>
    <thead>

      <tr>
        <th>
          <?=__('id')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_reactivate_search('id');")?>
        </th>
        <th>
          <?=string_change_case(__('username'), 'uppercase')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_reactivate_search('deleted_username');")?>
        </th>
        <th>
          <?=__('admin_deactivate_list_deleted_at')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_reactivate_search('deleted');")?>
        </th>
        <th>
          <?=string_change_case(__('action+'), 'uppercase')?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="admin_reactivate_sort" id="admin_reactivate_sort" value="username">
          <input type="text" class="table_search" name="admin_reactivate_id" id="admin_reactivate_id" value="" size="3" onkeyup="admin_reactivate_search();">
        </th>

        <th>
          <input type="text" class="table_search" name="admin_reactivate_username" id="admin_reactivate_username" value="" onkeyup="admin_reactivate_search();">
        </th>

        <th>
          &nbsp;
        </th>

        <th>
          &nbsp;
        </th>

      </tr>

    </thead>

    <tbody class="altc2 align_center" id="admin_reactivate_tbody">

      <?php } } if($is_admin && $deleted_users['rows']) { ?>

      <tr>
        <td colspan="4" class="uppercase text_light dark bold align_center">
          <?=__('admin_deactivate_list_count', $deleted_users['rows'], 0, 0, array($deleted_users['rows']));?>
        </td>
      </tr>

      <?php for($i = 0; $i < $deleted_users['rows'] ; $i++) { ?>

      <tr id="admin_reactivate_row_<?=$deleted_users[$i]['id']?>">
        <td>
          <?=$deleted_users[$i]['id']?>
        </td>
        <td>
          <?=$deleted_users[$i]['del_nick']?>
        </td>
        <td>
          <?=$deleted_users[$i]['del_since']?>
        </td>
        <td class="align_center">
          <?=__icon('refresh', is_small: true, alt: 'R', title: __('admin_deactivate_list_reactivate'), onclick: "admin_reactivate_account('".$deleted_users[$i]['id']."', '".__('admin_deactivate_list_confirm')."')")?>
        </td>
      </tr>

      <?php } ?>

      <?php } if(!page_is_fetched_dynamically()) { ?>
      <?php if($is_admin && $deleted_users['rows']) { ?>

    </tbody>
  </table>

</div>
<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }