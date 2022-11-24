<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../inc/functions_numbers.inc.php'; # Number formatting
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../actions/users.act.php';         # Actions
include_once './../../lang/users.lang.php';           # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/stats";
$page_title_en    = "Users statistics";
$page_title_fr    = "Statistiques des comptes";
$page_description = "Statistics generated from NoBleme's registered users.";

// Extra JS
$js = array('common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$users_selector_entries = array(  'overall'       ,
                                  'years'         ,
                                  'contributions' ,
                                  'anniversaries' ,
                                  'birthdays'     );

// Define the default dropdown menu entry
$users_selector_default = 'overall';

// Initialize the page section selector data
$users_selector = page_section_selector(           $users_selector_entries  ,
                                          default: $users_selector_default  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch users stats

$users_stats = users_stats_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>

      <?=__link('pages/users/list', __('users_stats_selector_title').__(':'), style: 'noglow')?>

      <select class="inh align_left" id="users_stats_selector" onchange="page_section_selector('users_stats', '<?=$users_selector_default?>');">
        <option value="overall"<?=$users_selector['menu']['overall']?>><?=__('stats_overall')?></option>
        <option value="years"<?=$users_selector['menu']['years']?>><?=__('stats_timeline')?></option>
        <option value="contributions"<?=$users_selector['menu']['contributions']?>><?=__('users_stats_selector_contributions')?></option>
        <option value="anniversaries"<?=$users_selector['menu']['anniversaries']?>><?=__('users_stats_selector_anniversaries')?></option>
        <option value="birthdays"<?=$users_selector['menu']['birthdays']?>><?=__('users_stats_selector_birthdays')?></option>
      </select>

    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ OVERALL ***************************************************/ ?>

<div class="width_50 padding_top users_stats_section<?=$users_selector['hide']['overall']?>" id="users_stats_overall">

  <p class="align_center padding_bot big">
    <?=__('users_stats_overall_summary', preset_values: array($users_stats['total']))?>
  </p>

  <p class="align_center padding_bot">
  <?=__('users_stats_overall_admins', preset_values: array($users_stats['admins']), amount: $users_stats['admins'])?><br>
  <?=__('users_stats_overall_mods', preset_values: array($users_stats['mods']), amount: $users_stats['mods'])?>
  </p>

  <p class="align_center">
    <?=__('users_stats_overall_banned', preset_values: array($users_stats['banned']), amount: $users_stats['banned'])?>
  </p>

  <p class="align_center">
    <?=__('users_stats_overall_deleted', preset_values: array($users_stats['deleted']), amount: $users_stats['deleted'])?>
  </p>

  <p class="align_center bigpadding_top">
    <?=__('users_stats_overall_more')?>
  </p>

</div>




<?php /************************************************ TIMELINE **************************************************/ ?>

<div class="width_30 padding_top users_stats_section<?=$users_selector['hide']['years']?>" id="users_stats_years">

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('year')?>
        </th>

        <th>
          <?=__('users_stats_years_created')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = date('Y'); $i >= $users_stats['oldest_account']; $i--) { ?>

      <tr>

        <td class="bold">
          <?=$i?>
        </td>

        <td class="bold">
          <?=$users_stats['created_'.$i]?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>




<?php /********************************************** CONTRIBUTORS ************************************************/ ?>

<div class="width_50 padding_top users_stats_section<?=$users_selector['hide']['contributions']?>" id="users_stats_contributions">

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('username')?>
        </th>

        <th>
          <?=__('users_stats_contrib_total')?>
        </th>

        <th>
          <?=__link('pages/quotes/stats?submitted', __('users_stats_contrib_quotes_s'))?>
        </th>

        <th>
          <?=__link('pages/quotes/stats?submitted', __('users_stats_contrib_quotes_a'))?>
        </th>

        <th>
          <?=__link('pages/tasks/stats?contributors', __('users_stats_contrib_tasks'))?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $users_stats['contrib_count']; $i++) { ?>

      <tr>

        <td>
          <?=__link('pages/users/'.$users_stats['contrib_id_'.$i], $users_stats['contrib_nick_'.$i])?>
        </td>

        <td class="bold">
          <?=$users_stats['contrib_total_'.$i]?>
        </td>

        <td>
          <?=$users_stats['contrib_quotes_s_'.$i]?>
        </td>

        <td>
          <?=$users_stats['contrib_quotes_a_'.$i]?>
        </td>

        <td>
          <?=$users_stats['contrib_tasks_'.$i]?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>




<?php /********************************************** ANNIVERSARIES ***********************************************/ ?>

<div class="width_50 padding_top users_stats_section<?=$users_selector['hide']['anniversaries']?>" id="users_stats_anniversaries">

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('username')?>
        </th>

        <th>
          <?=__('users_stats_anniv_age')?>
        </th>

        <th>
          <?=__('users_stats_anniv_date')?>
        </th>

        <th>
          <?=__('users_stats_anniv_days')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $users_stats['anniv_count']; $i++) { ?>

      <tr<?=$users_stats['anniv_css_row_'.$i]?>>

        <td>
          <?=__link('pages/users/'.$users_stats['anniv_id_'.$i], $users_stats['anniv_nick_'.$i], style: $users_stats['anniv_css_link_'.$i])?>
        </td>

        <td class="bold">
          <?=$users_stats['anniv_years_'.$i]?>
        </td>

        <td>
          <?=$users_stats['anniv_date_'.$i]?>
        </td>

        <td>
          <?=$users_stats['anniv_days_'.$i]?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>




<?php /************************************************ BIRTHDAYS *************************************************/ ?>

<div class="width_50 padding_top users_stats_section<?=$users_selector['hide']['birthdays']?>" id="users_stats_birthdays">

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('username')?>
        </th>

        <th>
          <?=__('users_stats_birth_age')?>
        </th>

        <th>
          <?=__link('pages/users/profile_edit', __('users_stats_birth_date'))?>
        </th>

        <th>
          <?=__('users_stats_anniv_days')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $users_stats['birth_count']; $i++) { ?>

      <tr<?=$users_stats['birth_css_row_'.$i]?>>

        <td>
          <?=__link('pages/users/'.$users_stats['birth_id_'.$i], $users_stats['birth_nick_'.$i], style: $users_stats['birth_css_link_'.$i])?>
        </td>

        <td class="bold">
          <?=$users_stats['birth_years_'.$i]?>
        </td>

        <td>
          <?=$users_stats['birth_date_'.$i]?>
        </td>

        <td>
          <?=$users_stats['birth_days_'.$i]?>
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
/*****************************************************************************/ include './../../inc/footer.inc.php'; }