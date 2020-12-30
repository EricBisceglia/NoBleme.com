<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/users.act.php';       # Actions
include_once './../../lang/users.lang.php';         # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/online";
$page_title_en    = "Who's online";
$page_title_fr    = "Qui est en ligne";
$page_description = "List of recent visitors of NoBleme and their latest activity.";

// JS
$js = array('users/user_list');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Sanitize postdata
$include_guests = (sanitize_input('POST', 'online_hide_guests', 'int', 0, 0, 1)) ? 0 : 1;
$admin_view     = (sanitize_input('POST', 'online_admin_view', 'int', $is_admin, 0, 1)) ? 0 : 1;;
$admin_view     = ($admin_view && $is_admin);

// Fetch the user list
$userlist = user_list(  'activity'                        ,
                        activity_cutoff:  2629746         ,
                        include_guests:   $include_guests ,
                        max_guest_count:  1000            ,
                        is_admin:         $admin_view     ,
                        is_activity:      1               );



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
    <span class="desktop">
      <label class="label_inline desktop" for="online_refresh"><?=__('users_online_refresh')?></label>
    </span>
    <span class="mobile">
      <label class="label_inline mobile" for="online_refresh"><?=__('users_online_refresh_mobile')?></label>
    </span>

  </fieldset>

  <table>

    <thead>
      <tr>
        <th>
          <?=string_change_case(__('username'), 'uppercase')?>
        </th>
        <th>
          <?=__('users_online_activity')?>
        </th>
        <th>
          <?=__('users_online_page')?>
        </th>
      </tr>
    </thead>

    <tbody class="altc" id="users_online_table">
      <?php } ?>
      <?php for($i=0;$i<$userlist['rows'];$i++) { ?>
        <tr>

          <?php if($is_admin && $userlist[$i]['type'] == 'guest') { ?>
          <td class="tooltip_container align_center<?=$userlist[$i]['css']?>">
          <?php } else { ?>
          <td class="align_center<?=$userlist[$i]['css']?>">
          <?php } ?>
            <?php if($userlist[$i]['type'] == 'user') { ?>
            <?=__link('todo_link/user?id='.$userlist[$i]['id'], $userlist[$i]['username'], $userlist[$i]['css'])?>
            <?php } else { ?>
            <?=$userlist[$i]['username']?>
            <?php } ?>
            <?php if($is_admin && $userlist[$i]['type'] == 'guest') { ?>
            <div class="tooltip">
              <?=$userlist[$i]['ip']?>
            </div>
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