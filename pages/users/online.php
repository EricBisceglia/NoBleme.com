<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';       # Core
include_once './../../inc/functions_time.inc.php'; # Time management
include_once './../../actions/users.act.php';      # Actions
include_once './../../lang/users.lang.php';        # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/online";
$page_title_en    = "Who's online";
$page_title_fr    = "Qui est en ligne";
$page_description = "List of recent visitors of NoBleme and their latest activity.";

// JS
$js = array('users/online');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Sanitize postdata
$include_guests = (sanitize_input('POST', 'online_hide_guests', 'int', 0, 0, 1)) ? 0 : 1;
$admin_view     = (sanitize_input('POST', 'online_admin_view', 'int', $is_admin, 0, 1)) ? 0 : 1;;
$admin_view     = ($admin_view && $is_admin) ? 1 : 0;

// Fetch the user list
$userlist = users_get_list('activity', 0, 0, 2629746, $include_guests, 1000, $admin_view, 1, $lang);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('users_online_title')?>
  </h1>

  <p>
    <?=__('users_online_header_intro')?>
  </p>

  <div class="padding_top padding_bot">
    <?=__('users_online_header_colors')?>
  </div>

  <fieldset class="padding_bot">

    <label><?=string_change_case(__('option', 2), 'initials').__(':');?></label>

    <input id="online_hide_guests" name="online_hide_guests" type="checkbox" onclick="users_online_table_settings(<?=$is_admin?>);">
    <label class="label_inline" for="online_hide_guests"><?=__('users_online_hide_gests')?></label><br>

    <?php if($is_admin) { ?>
    <input id="online_admin_view" name="online_admin_view" type="checkbox" onclick="users_online_table_settings(<?=$is_admin?>);">
    <label class="label_inline" for="online_admin_view"><?=__('users_online_admin_view')?></label><br>
    <?php } ?>

    <input id="online_refresh" name="online_refresh" type="checkbox" onclick="users_online_table_settings(<?=$is_admin?>);">
    <label class="label_inline" for="online_refresh"><?=__('users_online_refresh')?></label><br>

  </fieldset>

  <table>

    <thead>
      <th>
        <?=string_change_case(__('user'), 'uppercase')?>
      </th>
      <th>
        <?=__('users_online_activity')?>
      </th>
      <th>
        <?=__('users_online_page')?>
      </th>
    </thead>

    <tbody id="users_online_table">
      <?php } ?>
      <?php for($i=0;$i<$userlist['rows'];$i++) { ?>
        <tr>

          <td class="align_center<?=$userlist[$i]['css']?>">
            <?php if($userlist[$i]['type'] == 'user') { ?>
            <?=__link('todo_link/user?id='.$userlist[$i]['id'], $userlist[$i]['nickname'], $userlist[$i]['css'])?>
            <?php } else { ?>
            <?=$userlist[$i]['nickname']?>
            <?php } ?>
          </td>

          <td class="align_center<?=$userlist[$i]['css']?>">
            <?=$userlist[$i]['activity']?>
          </td>

          <td class="align_center<?=$userlist[$i]['css']?>">
            <?php if($userlist[$i]['last_url']) { ?>
            <?=__link($userlist[$i]['last_url'], $userlist[$i]['last_page'], $userlist[$i]['css'])?>
            <?php } else { ?>
            <?=$userlist[$i]['last_page']?>
            <?php } ?>
          </td>

        </tr>
      <?php } ?>
      <?php if(!page_is_fetched_dynamically()) { ?>
    </tbody>

  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }