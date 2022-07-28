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
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/stats_guests";
$page_title_en    = "Guests";
$page_title_fr    = "Visites";

// Extra JS
$js = array('admin/stats');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch total guest count
$guests_total_count = users_guests_count();

// Fetch guest storage length
$guests_storage_length = users_guests_storage_length();

// Fetch the search data
$guests_search_data = array(  'identity'  => form_fetch_element('stats_guests_search_identity') ,
                              'page'      => form_fetch_element('stats_guests_search_page')     ,
                              'language'  => form_fetch_element('stats_guests_search_language') ,
                              'theme'     => form_fetch_element('stats_guests_search_theme')    );

// Fetch guests
$guests_data = stats_guests_list( form_fetch_element('stats_guests_sort', 'activity') ,
                                  $guests_search_data                                 );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_60">

  <h1>
    <?=__('submenu_admin_stats_guests')?>
  </h1>

  <p>
    <?=__('admin_stats_guests_storage', amount: $guests_storage_length, preset_values: array($guests_storage_length))?>
  </p>

  <p>
    <?=__('admin_stats_guests_lang_en', amount: $guests_data['sum_en'], preset_values: array($guests_data['sum_en'], $guests_data['percent_english']))?><br>
    <?=__('admin_stats_guests_lang_fr', amount: $guests_data['sum_fr'], preset_values: array($guests_data['sum_fr'], $guests_data['percent_french']))?>
  </p>

  <p class="bigpadding_bot">
    <?=__('admin_stats_guests_themes_dark', amount: $guests_data['sum_dark'], preset_values: array($guests_data['sum_dark'], $guests_data['percent_dark']))?><br>
    <?=__('admin_stats_guests_themes_light', amount: $guests_data['sum_light'], preset_values: array($guests_data['sum_light'], $guests_data['percent_light']))?>
  </p>

  <div class="autoscroll">
    <table>
      <thead>

        <tr class="uppercase">
          <th>
            <?=__('admin_stats_guests_identity')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('identity');")?>
          </th>
          <th>
            <?=__('admin_stats_guests_visits')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('visits');")?>
          </th>
          <th>
            <?=__('activity')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('activity');")?>
            <?=__icon('sort_up', is_small: true, alt: '^', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('ractivity');")?>
          </th>
          <th>
            <?=__('page')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('page');")?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('url');")?>
          </th>
          <th>
            <?=__('language')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('language');")?>
          </th>
          <th>
            <?=__('theme')?>
            <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "admin_guests_search('theme');")?>
          </th>
        </tr>

        <tr>

          <th>
            <input type="hidden" name="stats_guests_sort" id="stats_guests_sort" disabled>
            <input type="text" class="table_search" name="stats_guests_identity" id="stats_guests_identity" value="" size="1" onkeyup="admin_guests_search();">
          </th>

          <th>
            &nbsp;
          </th>

          <th>
            &nbsp;
          </th>

          <th>
            <input type="text" class="table_search" name="stats_guests_page" id="stats_guests_page" value="" size="1" onkeyup="admin_guests_search();">
          </th>

          <th>
            <select class="table_search" name="stats_guests_language" id="stats_guests_language" onchange="admin_guests_search();">
              <option value="0">&nbsp;</option>
              <option value="EN"><?=string_change_case(__('english'), 'initials')?></option>
              <option value="FR"><?=string_change_case(__('french'), 'initials')?></option>
              <option value="None"><?=string_change_case(__('none'), 'initials')?></option>
            </select>
          </th>

          <th>
            <select class="table_search" name="stats_guests_theme" id="stats_guests_theme" onchange="admin_guests_search();">
              <option value="0">&nbsp;</option>
              <option value="dark" class="dark text_light"><?=__('admin_stats_guests_theme_dark')?></option>
              <option value="light" class="light text_dark"><?=__('admin_stats_guests_theme_light')?></option>
              <option value="None"><?=string_change_case(__('none'), 'initials')?></option>
            </select>
          </th>

        </tr>

      </thead>
      <tbody class="altc align_center" id="stats_guests_tbody">

        <?php } ?>

        <tr class="uppercase bold dark text_light">
          <td colspan="6">
            <?php if($guests_data['rows'] == $guests_total_count) { ?>
            <?=__('admin_stats_guests_count', preset_values: array($guests_data['rows']))?>
            <?php } else { ?>
            <?=__('admin_stats_guests_partial', amount: $guests_data['rows'], preset_values: array($guests_data['rows'], $guests_total_count, $guests_data['percent_guests']))?>
            <?php } ?>
          </td>
        </tr>

        <?php for($i = 0; $i < $guests_data['rows'] ; $i++) { ?>

        <tr>

          <?php if($guests_data[$i]['user_id']) { ?>
          <td class="tooltip_container">
            <?=__link('pages/users/'.$guests_data[$i]['user_id'], $guests_data[$i]['identity'])?>
            <div class="tooltip">
              <?=$guests_data[$i]['ip']?>
            </div>
          </td>
          <?php } else { ?>
          <td>
            <?=$guests_data[$i]['identity']?>
          </td>
          <?php } ?>

          <td>
            <?=$guests_data[$i]['visits']?>
          </td>

          <td>
            <?=$guests_data[$i]['active']?>
          </td>

          <td>
            <?php if($guests_data[$i]['url']) { ?>
            <?=__link($guests_data[$i]['url'], $guests_data[$i]['page'])?>
            <?php } else { ?>
            <?=$guests_data[$i]['page']?>
            <?php } ?>
          </td>

          <td>
            <?php if($guests_data[$i]['language'] == 'EN') { ?>
            <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
            <?php } else if($guests_data[$i]['language'] == 'FR') { ?>
            <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="20" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
            <?php } else { ?>
            &nbsp;
            <?php } ?>
          </td>

          <?php if($guests_data[$i]['theme'] == 'dark') { ?>
          <td class="text_light dark">
            <?=__('admin_stats_guests_theme_dark')?>
          </td>
          <?php } else if($guests_data[$i]['theme'] == 'light') { ?>
          <td class="text_dark light">
            <?=__('admin_stats_guests_theme_light')?>
          </td>
          <?php } else { ?>
          <td>
            &nbsp;
          </td>
          <?php } ?>

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