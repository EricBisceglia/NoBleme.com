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
include_once './../../lang/stats.lang.php';               # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admins/stats_guests";
$page_title_en    = "Guests";
$page_title_fr    = "Invités";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch guest storage length
$guests_storage_length = user_guest_storage_length();

// Fetch guests
$guests_data = user_list_guests();




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
    <?=__('admin_stats_guests_languages', preset_values: array($guests_data['sum_en'], $guests_data['sum_fr'], $guests_data['percent_english'], $guests_data['percent_french']))?>
  </p>

  <p class="bigpadding_bot">
    <?=__('admin_stats_guests_themes', preset_values: array($guests_data['sum_dark'], $guests_data['sum_light'], $guests_data['percent_dark'], $guests_data['percent_light']))?>
  </p>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('admin_stats_guests_identity')?>
        </th>
        <th>
          <?=__('admin_stats_guests_visits')?>
        </th>
        <th>
          <?=__('activity')?>
        </th>
        <th>
          <?=__('page')?>
        </th>
        <th>
          <?=__('language')?>
        </th>
        <th>
          <?=__('admin_stats_guests_theme')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <tr class="uppercase bold dark text_light">
        <td colspan="6">
          <?=__('admin_stats_guests_count', preset_values: array($guests_data['rows']))?>
        </td>
      </tr>

      <?php for($i = 0; $i < $guests_data['rows'] ; $i++) { ?>

      <tr>

        <td>
          <?php if($guests_data[$i]['user_id']) { ?>
          <?=__link('pages/users/'.$guests_data[$i]['user_id'], $guests_data[$i]['identity'])?>
          <?php } else { ?>
          <?=$guests_data[$i]['identity']?>
          <?php } ?>
        </td>

        <td>
          <?=$guests_data[$i]['visits']?>
        </td>

        <td>
          <?=$guests_data[$i]['active']?>
        </td>

        <td>
          <?=__link($guests_data[$i]['url'], $guests_data[$i]['page'])?>
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

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }