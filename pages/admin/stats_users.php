<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/functions_time.inc.php';        # Time management
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../actions/users.act.php';             # User actions
include_once './../../actions/stats.act.php';             # Stats
include_once './../../lang/stats.lang.php';               # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/stats_users";
$page_title_en    = "Users";
$page_title_fr    = "Comptes";

// Extra JS & CSS
$js   = array('admin/stats');
$css  = array('admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch total user count
$users_total_count = users_total_count();

// Fetch birth years
$user_birth_years = user_get_birth_years();

// Fetch the oldest account creation date
$user_oldest_account = user_get_oldest();

// Fetch the search data
$users_search_data = array( 'username'  => form_fetch_element('stats_users_search_username')  ,
                            'created'   => form_fetch_element('stats_users_search_created')   ,
                            'page'      => form_fetch_element('stats_users_search_page')      ,
                            'action'    => form_fetch_element('stats_users_search_action')    ,
                            'language'  => form_fetch_element('stats_users_search_language')  ,
                            'speaks'    => form_fetch_element('stats_users_search_speaks')    ,
                            'theme'     => form_fetch_element('stats_users_search_theme')     ,
                            'birthday'  => form_fetch_element('stats_users_search_birthday')  ,
                            'profile'   => form_fetch_element('stats_users_search_profile')   ,
                            'settings'  => form_fetch_element('stats_users_search_settings')  );

// Fetch users
$users_data = stats_users_list( form_fetch_element('stats_users_sort', 'activity')  ,
                                $users_search_data                                  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<?php if($is_admin) { ?>
<div class="width_50 bigpadding_bot">

  <h1>
    <?=string_change_case(__('user_acc+'), 'initials')?>
  </h1>

  <p>
    <?=__('admin_stats_users_visited', amount: $users_data['sum_visited'], preset_values: array($users_data['sum_visited'], $users_data['percent_visited']))?>
  </p>

  <p>
    <?=__('admin_stats_users_profiledata', amount: $users_data['sum_profile'], preset_values: array($users_data['sum_profile'], $users_data['percent_profile']))?>
  </p>

  <p>
    <?=__('admin_stats_guests_lang_en', amount: $users_data['sum_en'], preset_values: array($users_data['sum_en'], $users_data['percent_english']))?><br>
    <?=__('admin_stats_guests_lang_fr', amount: $users_data['sum_fr'], preset_values: array($users_data['sum_fr'], $users_data['percent_french']))?>
  </p>

  <p>
    <?=__('admin_stats_guests_themes_dark', amount: $users_data['sum_dark'], preset_values: array($users_data['sum_dark'], $users_data['percent_dark']))?><br>
    <?=__('admin_stats_guests_themes_light', amount: $users_data['sum_light'], preset_values: array($users_data['sum_light'], $users_data['percent_light']))?>
  </p>

</div>
<?php } ?>

<?php if($is_admin) { ?>
<div class="width_100 autoscroll">
<?php } else { ?>
<div class="width_70 autoscroll">
<?php } ?>

  <?php if($is_moderator && !$is_admin) { ?>
  <h1 class="align_center hugepadding_bot">
    <?=string_change_case(__('user_acc+'), 'initials')?>
  </h1>
  <?php } ?>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('username')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('username');")?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('usertypes');")?>
        </th>
        <?php if($is_admin) { ?>
        <th>
          <?=__('admin_stats_guests_visits')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('visits');")?>
        </th>
        <?php } ?>
        <th class="desktop">
          <?=__('created')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('created');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('rcreated');")?>
        </th>
        <th>
          <?=__('activity')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('activity');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('ractivity');")?>
        </th>
        <?php if($is_admin) { ?>
        <th class="desktop">
          <?=__('page')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('page');")?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('url');")?>
        </th>
        <th class="desktop">
          <?=__('action')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('action');")?>
        </th>
        <?php } ?>
        <th>
          <?=__('lang.')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('language');")?>
        </th>
        <th class="desktop">
          <?=__('admin_stats_users_speaks')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('speaks');")?>
        </th>
        <th>
          <?=__('theme')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('theme');")?>
        </th>
        <?php if($is_admin) { ?>
        <th class="desktop">
          <?=__('admin_stats_users_birthday')?>
          <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('birthday');")?>
          <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "admin_users_search('rbirthday');")?>
        </th>
        <?php } ?>
        <th>
          <?=__('admin_stats_users_profile')?>
        </th>
        <th>
          <?=__('settings')?>
        </th>
      </tr>

      <tr>

        <th>
          <input type="hidden" name="stats_users_sort" id="stats_users_sort" disabled>
          <input type="text" class="table_search" name="stats_users_username" id="stats_users_username" value="" size="1" onkeyup="admin_users_search();">
        </th>

        <?php if($is_admin) { ?>
        <th>
          &nbsp;
        </th>
        <?php } ?>

        <th class="desktop">
          <select class="table_search" name="stats_users_created" id="stats_users_created" onchange="admin_users_search();">
            <option value="0">&nbsp;</option>
            <?php for($i = date('Y'); $i >= $user_oldest_account; $i--) { ?>
            <option value="<?=$i?>"><?=$i?></option>
            <?php } ?>
          </select>
        </th>

        <th>
          &nbsp;
        </th>

        <?php if($is_admin) { ?>
        <th class="desktop">
          <input type="text" class="table_search" name="stats_users_page" id="stats_users_page" value="" size="1" onkeyup="admin_users_search();">
        </th>

        <th class="desktop">
          <select class="table_search" name="stats_users_action" id="stats_users_action" onchange="admin_users_search();">
            <option value="-1">&nbsp;</option>
            <option value="1"><?=__('admin_stats_users_action')?></option>
            <option value="0"><?=__('admin_stats_users_noaction')?></option>
          </select>
        </th>
        <?php } ?>

        <th>
          <select class="table_search" name="stats_users_language" id="stats_users_language" onchange="admin_users_search();">
            <option value="0">&nbsp;</option>
            <option value="EN"><?=string_change_case(__('english'), 'initials')?></option>
            <option value="FR"><?=string_change_case(__('french'), 'initials')?></option>
            <option value="None"><?=string_change_case(__('none'), 'initials')?></option>
          </select>
        </th>

        <th class="desktop">
          <select class="table_search" name="stats_users_speaks" id="stats_users_speaks" onchange="admin_users_search();">
            <option value="0">&nbsp;</option>
            <option value="EN"><?=string_change_case(__('english'), 'initials')?></option>
            <option value="FR"><?=string_change_case(__('french'), 'initials')?></option>
            <option value="Both"><?=string_change_case(__('bilingual'), 'initials')?></option>
            <option value="None"><?=string_change_case(__('none'), 'initials')?></option>
          </select>
        </th>

        <th>
          <select class="table_search" name="stats_users_theme" id="stats_users_theme" onchange="admin_users_search();">
            <option value="0">&nbsp;</option>
            <option value="dark" class="dark text_light"><?=__('admin_stats_guests_theme_dark')?></option>
            <option value="light" class="light text_dark"><?=__('admin_stats_guests_theme_light')?></option>
            <option value="None"><?=string_change_case(__('none'), 'initials')?></option>
          </select>
        </th>

        <?php if($is_admin) { ?>
        <th class="desktop">
          <select class="table_search" name="stats_users_birthday" id="stats_users_birthday" onchange="admin_users_search();">
            <option value="0">&nbsp;</option>
            <option value="-1"><?=string_change_case(__('none'), 'initials')?></option>
            <?php for($i = 0; $i < $user_birth_years['rows']; $i++) { ?>
            <option value="<?=$user_birth_years[$i]['year']?>"><?=$user_birth_years[$i]['year']?></option>
            <?php } ?>
          </select>
        </th>
        <?php } ?>

        <th>
          <select class="table_search admin_stats_profile_dropdown" name="stats_users_profile" id="stats_users_profile" onchange="admin_users_search();">
            <option value="0">&nbsp;</option>
            <option value="empty"><?=__('admin_stats_users_empty')?></option>
            <option value="filled"><?=__('admin_stats_users_filled')?></option>
            <option value="complete"><?=__('admin_stats_users_complete')?>
            <option value="speaks"><?=string_change_case(__('language+'), 'initials')?></option>
            <option value="birthday"><?=string_change_case(__('birthday'), 'initials')?></option>
            <option value="location"><?=string_change_case(__('location'), 'initials')?></option>
            <option value="pronouns"><?=__('admin_stats_users_pronouns')?></option>
            <option value="text"><?=__('admin_stats_users_profile_text')?></option>
          </select>
        </th>

        <th>
          <select class="table_search admin_stats_settings_dropdown" name="stats_users_settings" id="stats_users_settings" onchange="admin_users_search();">
            <option value="0">&nbsp;</option>
            <option value="nsfw"><?=__('admin_stats_users_all_nsfw')?></option>
            <option value="some_nsfw"><?=__('admin_stats_users_some_nsfw')?></option>
            <option value="no_nsfw"><?=__('admin_stats_users_no_nsfw')?></option>
            <option value="no_youtube"><?=__('admin_stats_users_youtube')?></option>
            <option value="no_trends"><?=__('admin_stats_users_discord')?></option>
            <option value="no_discord"><?=__('admin_stats_users_trends')?></option>
            <option value="no_kiwiirc"><?=__('admin_stats_users_kiwiirc')?></option>
            <option value="hide"><?=__('admin_stats_users_hidden')?></option>
          </select>
        </th>

      </tr>

    </thead>
    <tbody class="altc align_center" id="stats_users_tbody">

      <?php } ?>

      <tr class="uppercase bold dark text_light">
        <?php if($is_admin) { ?>
        <td colspan="12">
        <?php } else { ?>
        <td colspan="8">
        <?php } ?>
          <?php if($users_data['rows'] == $users_total_count) { ?>
          <?=__('admin_stats_users_count', preset_values: array($users_data['rows']))?>
          <?php } else { ?>
          <?=__('admin_stats_users_partial', amount: $users_data['rows'], preset_values: array($users_data['rows'], $users_total_count, $users_data['percent_users']))?>
          <?php } ?>
        </td>
      </tr>

      <?php for($i = 0; $i < $users_data['rows'] ; $i++) { ?>

      <tr>

        <td>
          <?=__link('pages/users/'.$users_data[$i]['id'], $users_data[$i]['username'], style: $users_data[$i]['user_css'])?>
        </td>

        <?php if($is_admin) { ?>
        <td>
          <?=$users_data[$i]['visits']?>
        </td>
        <?php } ?>

        <td class="desktop">
          <?=$users_data[$i]['created']?>
        </td>

        <td>
          <?=$users_data[$i]['active']?>
        </td>

        <?php if($is_admin) { ?>
        <td class="desktop">
          <?php if($users_data[$i]['url']) { ?>
          <?=__link($users_data[$i]['url'], $users_data[$i]['page'])?>
          <?php } else { ?>
          <?=$users_data[$i]['page']?>
          <?php } ?>
        </td>

        <td class="desktop">
          <?=$users_data[$i]['action']?>
        </td>
        <?php } ?>

        <td>
          <?php if($users_data[$i]['language'] == 'EN') { ?>
          <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
          <?php } else if($users_data[$i]['language'] == 'FR') { ?>
          <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="20" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
          <?php } else { ?>
          &nbsp;
          <?php } ?>
        </td>

        <td class="desktop">
          <?php if($users_data[$i]['speak_en']) { ?>
          <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
          <?php } if($users_data[$i]['speak_fr']) { ?>
          <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="20" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
          <?php } else { ?>
          &nbsp;
          <?php } ?>
        </td>

        <?php if($users_data[$i]['theme'] == 'dark') { ?>
        <td class="text_light dark">
          <?=__('admin_stats_guests_theme_dark')?>
        </td>
        <?php } else if($users_data[$i]['theme'] == 'light') { ?>
        <td class="text_dark light">
          <?=__('admin_stats_guests_theme_light')?>
        </td>
        <?php } else { ?>
        <td>
          &nbsp;
        </td>
        <?php } ?>

        <?php if($is_admin) { ?>
        <td class="desktop">
          <?=$users_data[$i]['birthday']?>
        </td>
        <?php } ?>

        <td class="pointer tooltip_container tooltip_desktop" onclick="window.location = '<?=$path?>pages/users/<?=$users_data[$i]['id']?>'">
          <?php if($users_data[$i]['speaks']) { ?>
          <span class="text_green" title="<?=__('admin_stats_users_speaks')?>">&check;</span>
          <?php } else { ?>
          <span class="text_red" title="<?=__('admin_stats_users_speaks')?>">&cross;</span>
          <?php } if($users_data[$i]['birthday']) { ?>
          <span class="text_green" title="<?=string_change_case(__('birthday'), 'initials')?>">&check;</span>
          <?php } else { ?>
          <span class="text_red" title="<?=string_change_case(__('birthday'), 'initials')?>">&cross;</span>
          <?php } if($users_data[$i]['location']) { ?>
          <span class="text_green" title="<?=string_change_case(__('location'), 'initials')?>">&check;</span>
          <?php } else { ?>
          <span class="text_red" title="<?=string_change_case(__('location'), 'initials')?>">&cross;</span>
          <?php } if($users_data[$i]['pronouns']) { ?>
          <span class="text_green" title="<?=__('admin_stats_users_pronouns')?>">&check;</span>
          <?php } else { ?>
          <span class="text_red" title="<?=__('admin_stats_users_pronouns')?>">&cross;</span>
          <?php } if($users_data[$i]['profile']) { ?>
          <span class="text_green" title="<?=__('admin_stats_users_profile_text')?>">&check;</span>
          <?php } else { ?>
          <span class="text_red" title="<?=__('admin_stats_users_profile_text')?>">&cross;</span>
          <?php } ?>
          <div class="tooltip">
            <?php if($users_data[$i]['speaks']) { ?>
            <span class="text_green">&check;</span> <?=__('admin_stats_users_speaks')?><br>
            <?php } else { ?>
            <span class="text_red">&cross;</span> <?=__('admin_stats_users_speaks')?><br>
            <?php } if($users_data[$i]['birthday']) { ?>
            <span class="text_green">&check;</span> <?=string_change_case(__('birthday'), 'initials')?><br>
            <?php } else { ?>
            <span class="text_red">&cross;</span> <?=string_change_case(__('birthday'), 'initials')?><br>
            <?php } if($users_data[$i]['location']) { ?>
            <span class="text_green">&check;</span> <?=string_change_case(__('location'), 'initials')?><br>
            <?php } else { ?>
            <span class="text_red">&cross;</span> <?=string_change_case(__('location'), 'initials')?><br>
            <?php } if($users_data[$i]['pronouns']) { ?>
            <span class="text_green">&check;</span> <?=__('admin_stats_users_pronouns')?><br>
            <?php } else { ?>
            <span class="text_red">&cross;</span> <?=__('admin_stats_users_pronouns')?><br>
            <?php } if($users_data[$i]['profile']) { ?>
            <span class="text_green">&check;</span> <?=__('admin_stats_users_profile_text')?>
            <?php } else { ?>
            <span class="text_red">&cross;</span> <?=__('admin_stats_users_profile_text')?>
            <?php } ?>
          </div>
        </td>

        <td class="pointer tooltip_container tooltip_desktop" onclick="window.location = '<?=$path?>pages/users/<?=$users_data[$i]['id']?>'">
          <?php if($users_data[$i]['nsfw'] == 0) { ?>
          <span class="text_red" title="<?=__('admin_stats_users_no_nsfw')?>">&cross;</span>
          <?php } else if($users_data[$i]['nsfw'] == 1) { ?>
          <span class="text_orange" title="<?=__('admin_stats_users_some_nsfw')?>">&frac12;</span>
          <?php } else { ?>
          <span class="text_green" title="<?=__('admin_stats_users_all_nsfw')?>">&check;</span>
          <?php } if($users_data[$i]['youtube']) { ?>
          <span class="text_red" title="<?=__('admin_stats_users_youtube')?>">&cross;</span>
          <?php } if($users_data[$i]['trends']) { ?>
          <span class="text_red" title="<?=__('admin_stats_users_trends')?>">&cross;</span>
          <?php } if($users_data[$i]['discord']) { ?>
          <span class="text_red" title="<?=__('admin_stats_users_discord')?>">&cross;</span>
          <?php } if($users_data[$i]['kiwiirc']) { ?>
          <span class="text_red" title="<?=__('admin_stats_users_kiwiirc')?>">&cross;</span>
          <?php } if($users_data[$i]['hidden']) { ?>
          <span class="text_red" title="<?=__('admin_stats_users_hidden')?>">&cross;</span>
          <?php } ?>
          <div class="tooltip">
            <?php if($users_data[$i]['nsfw'] == 0) { ?>
            <span class="text_red">&cross;</span> <?=__('admin_stats_users_no_nsfw')?>
            <?php } else if($users_data[$i]['nsfw'] == 1) { ?>
            <span class="text_orange">&cross;</span> <?=__('admin_stats_users_some_nsfw')?>
            <?php } else { ?>
            <span class="text_green">&check;</span> <?=__('admin_stats_users_all_nsfw')?>
            <?php } if($users_data[$i]['youtube']) { ?>
            <br><span class="text_red">&cross;</span> <?=__('admin_stats_users_youtube')?>
            <?php } if($users_data[$i]['trends']) { ?>
            <br><span class="text_red">&cross;</span> <?=__('admin_stats_users_trends')?>
            <?php } if($users_data[$i]['discord']) { ?>
            <br><span class="text_red">&cross;</span> <?=__('admin_stats_users_discord')?>
            <?php } if($users_data[$i]['kiwiirc']) { ?>
            <br><span class="text_red">&cross;</span> <?=__('admin_stats_users_kiwiirc')?>
            <?php } if($users_data[$i]['hidden']) { ?>
            <br><span class="text_red">&cross;</span> <?=__('admin_stats_users_hidden')?>
            <?php } ?>
          </div>
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
/*****************************************************************************/ include './../../inc/footer.inc.php'; }