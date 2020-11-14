<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';                  # Core
include_once './../../inc/functions_time.inc.php';            # Time management
include_once './../../actions/users/user.act.php';            # User list
include_once './../../actions/admin/user_management.act.php'; # Actions
include_once './../../lang/admin/user_management.lang.php';   # Translations

// Limit page access rights
user_restrict_to_moderators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/deactivate";
$page_title_en    = "Delete an account";
$page_title_fr    = "Supprimer un compte";

// Extra JS
$js = array('admin/user_management');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// List of deleted users

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

<?php if($is_admin && $deleted_users['rows']) { ?>

<div class="width_40 padding_top">

  <h2 class="align_center padding_bot">
    <?=__('admin_deactivate_list_title')?>
  </h2>

  <table>
    <thead>

      <tr>
        <th>
          <?=__('id')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=__('sort')?>" onclick="admin_ban_search_logs('id');">
        </th>
        <th>
          <?=string_change_case(__('nickname'), 'uppercase')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=__('sort')?>" onclick="admin_ban_search_logs('deleted_username');">
        </th>
        <th>
          <?=__('admin_deactivate_list_deleted_at')?>
          <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=__('sort')?>" onclick="admin_ban_search_logs('deleted');">
        </th>
        <th>
          <?=string_change_case(__('action+'), 'uppercase')?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="admin_reactivate_sort" id="admin_reactivate_sort" value="username">
          <input type="text" class="table_search" name="admin_reactivate_id" id="admin_reactivate_id" value="" size="3" onkeyup="admin_ban_search_logs();">
        </th>

        <th>
          <input type="text" class="table_search" name="admin_reactivate_username" id="admin_reactivate_username" value="" onkeyup="admin_ban_search_logs();">
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

      <tr>
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
          <img class="smallicon valign_middle" src="<?=$path?>img/icons/refresh_small.svg" alt="R" title="<?=__('admin_deactivate_list_reactivate')?>">
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