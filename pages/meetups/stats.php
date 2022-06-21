<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/meetups.act.php'; # Actions
include_once './../../lang/meetups.lang.php';   # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/stats";
$page_title_en    = "Meetups statistics";
$page_title_fr    = "Statistiques des IRL";
$page_description = "Statistics generated from NoBleme's real life meetups";

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
$meetups_selector_entries = array(  'overall'   ,
                                    'people'    ,
                                    'locations' ,
                                    'years'     );

// Define the default dropdown menu entry
$meetups_selector_default = 'overall';

// Initialize the page section selector data
$meetups_selector = page_section_selector(            $meetups_selector_entries ,
                                            default:  $meetups_selector_default );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recalculate all stats

if(isset($_GET['recalculate']) && user_is_administrator())
{
  // Recalculate the stats
  meetups_recalculate_all_stats();

  // Reload the page in its default state
  exit(header("Location: ".$path."pages/meetups/stats"));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch meetup stats

$meetups_stats = meetups_stats();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>

      <?=__link('pages/meetups/list', __('meetups_selector_title').__(':'), style: 'noglow')?>

      <select class="inh align_left" id="meetups_stats_selector" onchange="page_section_selector('meetups_stats', '<?=$meetups_selector_default?>');">
        <option value="overall"<?=$meetups_selector['menu']['overall']?>><?=__('stats_overall')?></option>
        <option value="people"<?=$meetups_selector['menu']['people']?>><?=__('meetups_stats_selector_people')?></option>
        <option value="locations"<?=$meetups_selector['menu']['locations']?>><?=__('meetups_stats_selector_locations')?></option>
        <option value="years"<?=$meetups_selector['menu']['years']?>><?=__('stats_timeline')?></option>
      </select>

      <?php if($is_admin) { ?>
      <?=__icon('refresh', alt: 'R', title: __('meetups_stats_recalculate_button'), title_case: 'initials', class: 'valign_middle pointer spaced_left', href: 'pages/meetups/stats?recalculate', confirm: __('meetups_stats_recalculate_alert'))?>
      <?php } ?>

    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ OVERALL ***************************************************/ ?>

<div class="width_50 padding_top meetups_stats_section<?=$meetups_selector['hide']['overall']?>" id="meetups_stats_overall">

  <p class="align_center big padding_bot">
    <?=__('meetups_stats_overall_summary', amount: $meetups_stats['total'], preset_values: array($meetups_stats['total']))?>
  </p>

  <p class="align_center">
    <?=__('meetups_stats_overall_lang_bilingual', amount: $meetups_stats['total_bi'], preset_values: array($meetups_stats['total_bi'],))?>
  </p>

  <p class="align_center padding_bot">
    <?=__('meetups_stats_overall_lang_en', amount: $meetups_stats['total_en'], preset_values: array($meetups_stats['total_en']))?><br>
    <?=__('meetups_stats_overall_lang_fr', amount: $meetups_stats['total_fr'], preset_values: array($meetups_stats['total_fr']))?>
  </p>

  <p class="align_center padding_bot">
    <?=__('meetups_stats_overall_future', amount: $meetups_stats['future'], preset_values: array($meetups_stats['future']))?>
  </p>

  <p class="align_center">
    <?=__('meetups_stats_overall_biggest', preset_values: array($meetups_stats['biggest_id'], $meetups_stats['biggest_count'], $meetups_stats['biggest_date']))?>
  </p>

  <p class="align_center bigpadding_top">
    <?=__('meetups_stats_overall_more')?>
  </p>

</div>




<?php /************************************************* PEOPLE ***************************************************/ ?>

<div class="width_60 padding_top autoscroll meetups_stats_section<?=$meetups_selector['hide']['people']?>" id="meetups_stats_people">

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('username')?>
        </th>

        <th>
          <?=__link('pages/meetups/list', __('meetups_stats_users_meetups'))?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_bi')?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_en')?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_fr')?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_old')?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_new')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $meetups_stats['users_count']; $i++) { ?>

      <tr>

        <td>
          <?=__link('pages/meetups/list?attendee='.$meetups_stats['users_id_'.$i], $meetups_stats['users_nick_'.$i])?>
        </td>

        <td class="bold">
          <?=$meetups_stats['users_meetups_'.$i]?>
        </td>

        <td>
          <?=$meetups_stats['users_meetups_bi_'.$i]?>
        </td>

        <td>
          <?=$meetups_stats['users_meetups_en_'.$i]?>
        </td>

        <td>
          <?=$meetups_stats['users_meetups_fr_'.$i]?>
        </td>

        <?php if($meetups_stats['users_meetups_'.$i] > 1) { ?>

        <td>
          <?=__link('pages/meetups/'.$meetups_stats['users_mold_id_'.$i], $meetups_stats['users_mold_date_'.$i])?>
        </td>

        <td>
          <?=__link('pages/meetups/'.$meetups_stats['users_mnew_id_'.$i], $meetups_stats['users_mnew_date_'.$i])?>
        </td>

        <?php } else { ?>

        <td colspan="2">
          <?=__link('pages/meetups/'.$meetups_stats['users_mold_id_'.$i], $meetups_stats['users_mold_date_'.$i])?>
        </td>

        <?php } ?>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>




<?php /************************************************ LOCATIONS *************************************************/ ?>

<div class="width_30 padding_top autoscroll meetups_stats_section<?=$meetups_selector['hide']['locations']?>" id="meetups_stats_locations">

   <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('location')?>
        </th>

        <th>
          <?=__('meetups_stats_location_meetups')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $meetups_stats['locations_count']; $i++) { ?>

      <tr>

        <td class="bold">
          <?=__link('pages/meetups/list?location='.$meetups_stats['locations_name_'.$i], $meetups_stats['locations_name_'.$i])?>
        </td>

        <td class="bold">
          <?=$meetups_stats['locatouns_count_'.$i]?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>




<?php /************************************************** YEARS ***************************************************/ ?>

<div class="width_40 padding_top autoscroll meetups_stats_section<?=$meetups_selector['hide']['years']?>" id="meetups_stats_years">

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('year')?>
        </th>

        <th>
          <?=__('meetups_stats_years_meetups')?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_bi')?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_en')?>
        </th>

        <th>
          <?=__('meetups_stats_users_meetups_fr')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = date('Y'); $i >= $meetups_stats['oldest_year']; $i--) { ?>

      <tr>

        <td class="bold">
          <?php if($meetups_stats['years_count_'.$i]) { ?>
          <?=__link('pages/meetups/list?year='.$i, $i)?>
          <?php } else { ?>
          <?=$i?>
          <?php } ?>
        </td>

        <td class="bold">
          <?=$meetups_stats['years_count_'.$i]?>
        </td>

        <td>
          <?=$meetups_stats['years_count_bi_'.$i]?>
        </td>

        <td>
          <?=$meetups_stats['years_count_en_'.$i]?>
        </td>

        <td>
          <?=$meetups_stats['years_count_fr_'.$i]?>
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