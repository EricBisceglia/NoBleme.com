<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../actions/users/user.act.php';    # Actions
include_once './../../lang/users/user_list.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/list";
$page_title_en    = "User list";
$page_title_fr    = "Liste des membres";
$page_description = "List of accounts registered on NoBleme.com";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// User list

// Fetch the user list
$user_list = user_list('registered');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_userlist')?>
  </h1>

  <p>
    <?=__('users_list_description_intro')?>
  </p>

  <p>
    <?=__('users_list_description_colors')?>
  </p>

  <div class="smallpadding_top">
    <table>
      <thead>

        <tr class="uppercase">
          <th>
            <?=string_change_case(__('username'), 'uppercase')?>
          </th>
          <th>
            <?=__('users_list_registered')?>
          </th>
          <th>
            <?=__('users_online_activity')?>
          </th>
          <th>
            <?=__('users_list_languages')?>
          </th>
        </tr>

      </thead>
      <tbody class="align_center">

        <?php for($i = 0; $i < $user_list['rows']; $i++) { ?>

        <tr class="<?=$user_list[$i]['css']?>"">

          <td>
            <?=__link('todo_link?id='.$user_list[$i]['id'], $user_list[$i]['username'], 'text_white bold noglow')?>
          </td>

          <td class="tooltip_container">
            <?=$user_list[$i]['registered']?>
            <div class="tooltip">
              <?=$user_list[$i]['created']?>
            </div>
          </td>

          <td class="tooltip_container">
            <?=$user_list[$i]['activity']?>
            <div class="tooltip">
              <?=$user_list[$i]['active_at']?>
            </div>
          </td>

          <td>
            <?php if($user_list[$i]['lang_en']) { ?>
            <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
            <?php } if($user_list[$i]['lang_en']) { ?>
            <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="20" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
            <?php } ?>
          </td>

        </tr>

        <?php } ?>

      </tbody>
    </table>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }