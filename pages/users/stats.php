<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/users.act.php'; # Actions
include_once './../../lang/users.lang.php';   # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/stats";
$page_title_en    = "Users statistics";
$page_title_fr    = "Statistiques des comptes";
$page_description = "Statistics generated from NoBleme's registered users.";

// Extra JS
$js = array('common/toggle', 'common/selector');




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
                                  'birthdays'     ,
                                  'anniversaries' );

// Define the default dropdown menu entry
$users_selector_default = 'overall';

// Initialize the page section selector data
$users_selector = page_section_selector(           $users_selector_entries  ,
                                          default: $users_selector_default  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch users stats

$users_stats = users_stats();




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
        <option value="birthdays"<?=$users_selector['menu']['birthdays']?>><?=__('users_stats_selector_birthdays')?></option>
        <option value="anniversaries"<?=$users_selector['menu']['anniversaries']?>><?=__('users_stats_selector_anniversaries')?></option>
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

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }