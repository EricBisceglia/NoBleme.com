<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../actions/user.act.php';          # Actions
include_once './../../lang/users/user_list.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/admins";
$page_title_en    = "Administrative team";
$page_title_fr    = "Équipe administrative";
$page_description = "NoBleme's administrative team - the staff that keeps the website running";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the administrative team

$admin_list = user_list_admins();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_staff')?>
  </h1>

  <p>
    <?=__('users_admins_intro')?>
  </p>

  <p>
    <?=__('users_admins_mods')?>
  </p>

  <p>
    <?=__('users_admins_admins')?>
  </p>

  <div class="bigpadding_top">
    <table>
      <thead>

        <tr class="uppercase">
          <th>
            <?=__('username')?>
          </th>
          <th>
            <?=__('users_admins_title')?>
          </th>
          <th>
            <?=__('users_online_activity')?>
          </th>
          <th>
            <?=__('users_list_languages')?>
          </th>
        </tr>

      </thead>
      <tbody class="align_center altc">

        <?php for($i = 0; $i < $admin_list['rows']; $i++) { ?>

        <tr class="<?=$admin_list[$i]['css']?>">

          <td>
            <?=__link('todo_link?id='.$admin_list[$i]['id'], $admin_list[$i]['username'], $admin_list[$i]['css'])?>
          </td>

          <td>
            <?=$admin_list[$i]['title']?>
          </td>

          <td>
            <?=$admin_list[$i]['activity']?>
          </td>

          <td>
            <?php if($admin_list[$i]['lang_en']) { ?>
            <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
            <?php } if($admin_list[$i]['lang_fr']) { ?>
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