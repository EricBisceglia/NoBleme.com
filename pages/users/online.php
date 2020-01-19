<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';       # Core
include_once './../../inc/functions_time.inc.php'; # Time management
include_once './../../actions/users.act.php';      # Actions
include_once './../../lang/users.lang.php';        # Translations

// Menus
$header_menu      = 'Community';
$header_sidemenu  = 'Online';

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/online";
$page_title_en    = "Who's online";
$page_title_fr    = "Qui est en ligne";
$page_description = "List of recent visitors of NoBleme and their latest activity.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch user list

// Fetch the user list
$userlist = users_get_list('activity', 0, 0, 2629746, 1, 1000, $lang);




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

        <p class="padding_bot">
          <?=__('users_online_header_colors')?>
        </p>

        <table class="blacktitles">

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

          <tbody>
            <?php for($i=0;$i<$userlist['rows'];$i++) { ?>
              <tr>

                <td class="align_center<?=$userlist[$i]['css']?>">
                  <?php if($userlist[$i]['type'] == 'user') { ?>
                  <?=__link('pages/users/user?id='.$userlist[$i]['id'], $userlist[$i]['nickname'], $userlist[$i]['css'])?>
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
          </tbody>

        </table>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }