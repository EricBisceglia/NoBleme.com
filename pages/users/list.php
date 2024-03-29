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
$page_url         = "pages/users/list";
$page_title_en    = "User list";
$page_title_fr    = "Liste des membres";
$page_description = "List of accounts registered on NoBleme.com";

// Extra JS
$js = array('users/user_list');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// User list

// Fetch the search data
$user_list_search = array(  'username'    => form_fetch_element('users_list_search_username')   ,
                            'registered'  => form_fetch_element('users_list_search_registered') ,
                            'active'      => form_fetch_element('users_list_search_activity')   ,
                            'languages'   => form_fetch_element('users_list_search_languages')  ,
                            'id'          => form_fetch_element('users_list_search_id')         );

// Fetch the user list
$user_list = users_list(  form_fetch_element('users_list_sort', 'registered') ,
                          $user_list_search                                   );

// Fetch the oldest account creation date
$user_oldest_account = user_get_oldest();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_userlist')?>
    <?=__icon('stats', alt: 's', title: string_change_case(__('statistics'), 'initials'), href: "pages/users/stats")?>
  </h1>

  <p>
    <?=__('users_list_description_intro')?>
  </p>

  <div class="padding_top padding_bot">
    <?=__('users_list_description_colors')?>
  </div>

  <div class="smallpadding_top autoscroll">
    <table>
      <thead>

        <tr class="uppercase">

          <th>
            <?=('username')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "users_list_search('username');")?>
          </th>

          <th>
            <?=__('users_list_registered')?>
            <span class="desktop">
              <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "users_list_search('registered');")?>
            </span>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "users_list_search('rregistered');")?>
          </th>

          <th class="desktop">
            <?=__('users_online_activity')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "users_list_search('activity');")?>
          </th>

          <th>
            <?=__('language+')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "users_list_search('language');")?>
          </th>

          <th class="desktop">
            <?=__('id')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "users_list_search('id');")?>
          </th>

        </tr>

        <tr>

          <th>
            <input type="hidden" name="users_list_sort" id="users_list_sort" value="registered">
            <input type="text" class="table_search" name="users_list_search_username" id="users_list_search_username" value="" onkeyup="users_list_search();">
          </th>

          <th>
            <select class="table_search" name="users_list_search_registered" id="users_list_search_registered" onchange="users_list_search();">
              <option value="0">&nbsp;</option>
              <?php for($i = date('Y'); $i >= $user_oldest_account; $i--) { ?>
              <option value="<?=$i?>"><?=$i?></option>
              <?php } ?>
            </select>
          </th>

          <th class="desktop">
            <select class="table_search" name="users_list_search_activity" id="users_list_search_activity" onchange="users_list_search();">
              <option value="0">&nbsp;</option>
              <option value="1"><?=__('users_list_active')?></option>
            </select>
          </th>

          <th>
            <select class="table_search" name="users_list_search_languages" id="users_list_search_languages" onchange="users_list_search();">
              <option value="0">&nbsp;</option>
              <option value="EN"><?=string_change_case(__('english'), 'initials')?></option>
              <option value="FR"><?=string_change_case(__('french'), 'initials')?></option>
            </select>
          </th>

          <th class="desktop">
            <input type="text" class="table_search" name="users_list_search_id" id="users_list_search_id" value="" size="3" onkeyup="users_list_search();">
          </th>

        </tr>

      </thead>
      <tbody class="align_center" id="users_list_tbody">

        <?php } ?>

        <tr>
          <td colspan="5" class="uppercase text_light dark bold align_center desktop">
            <?=__('users_list_count', $user_list['rows'], 0, 0, array($user_list['rows']))?>
          </td>
          <td colspan="3" class="uppercase text_light dark bold align_center mobile_table">
            <?=__('users_list_count', $user_list['rows'], 0, 0, array($user_list['rows']))?>
          </td>
        </tr>

        <?php for($i = 0; $i < $user_list['rows']; $i++) { ?>

        <tr class="<?=$user_list[$i]['css']?>">

          <td>
            <?php if($mode === 'light' && !$user_list[$i]['css']) { ?>
            <?=__link('pages/users/'.$user_list[$i]['id'], $user_list[$i]['username'], 'text_dark bold noglow')?>
            <?php } else { ?>
            <?=__link('pages/users/'.$user_list[$i]['id'], $user_list[$i]['username'], 'text_white bold noglow')?>
            <?php } ?>
          </td>

          <td class="tooltip_container tooltip_desktop">
            <?=$user_list[$i]['registered']?>
            <div class="tooltip">
              <?=$user_list[$i]['created']?>
            </div>
          </td>

          <td class="tooltip_container desktop">
            <?=$user_list[$i]['activity']?>
            <div class="tooltip">
              <?=$user_list[$i]['active_at']?>
            </div>
          </td>

          <td>
            <?php if($user_list[$i]['lang_en']) { ?>
            <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
            <?php } if($user_list[$i]['lang_fr']) { ?>
            <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="20" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
            <?php } ?>
          </td>

          <td class="desktop">
            <?=$user_list[$i]['id']?>
          </td>

        </tr>

        <?php } ?>

        <?php if(!page_is_fetched_dynamically()) { ?>

      </tbody>
    </table>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }