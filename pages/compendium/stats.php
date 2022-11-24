<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../inc/bbcodes.inc.php';               # BBCodes
include_once './../../inc/functions_numbers.inc.php';     # Number formatting
include_once './../../inc/functions_mathematics.inc.php'; # Mathematics
include_once './../../actions/compendium.act.php';        # Actions
include_once './../../lang/compendium.lang.php';          # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/stats";
$page_title_en    = "Compendium statistics";
$page_title_fr    = "Statistiques du compendium";
$page_description = "Statistics generated from NoBleme's 21st century compendium, a documentation of popular culture in the Internet age";

// Extra CSS & JS
$js = array('common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$compendium_selector_entries = array( 'overall'       ,
                                      'types'         ,
                                      'categories'    ,
                                      'eras'          ,
                                      'years'         );

// Define the default dropdown menu entry
$compendium_selector_default = 'overall';

// Initialize the page section selector data
$compendium_selector = page_section_selector(           $compendium_selector_entries  ,
                                              default:  $compendium_selector_default  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch compendium stats

$compendium_stats = compendium_stats_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>

      <?=__link('pages/compendium/index', __('compendium_page_compendium').__(':'), style: 'noglow')?>

      <select class="inh align_left" id="compendium_stats_selector" onchange="page_section_selector('compendium_stats', '<?=$compendium_selector_default?>');">
        <option value="overall"<?=$compendium_selector['menu']['overall']?>><?=__('stats_overall')?></option>
        <option value="types"<?=$compendium_selector['menu']['types']?>><?=__('submenu_pages_compendium_types')?></option>
        <option value="categories"<?=$compendium_selector['menu']['categories']?>><?=string_change_case(__('category+'), 'initials')?></option>
        <option value="eras"<?=$compendium_selector['menu']['eras']?>><?=__('submenu_pages_compendium_eras')?></option>
        <option value="years"<?=$compendium_selector['menu']['years']?>><?=__('stats_timeline')?></option>
      </select>

    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ OVERALL ***************************************************/ ?>

<div class="width_50 padding_top compendium_stats_section<?=$compendium_selector['hide']['overall']?>" id="compendium_stats_overall">

  <p class="align_center big">
    <?=__('compendium_stats_overall_pages', preset_values: array($compendium_stats['pages']))?>
  </p>

  <p class="align_center padding_top">
    <?=__('compendium_stats_overall_nsfw', amount: $compendium_stats['nsfw'], preset_values: array($compendium_stats['nsfw'], $compendium_stats['nsfwp']))?><br>
    <?=__('compendium_stats_overall_gross', amount: $compendium_stats['gross'], preset_values: array($compendium_stats['gross'], $compendium_stats['grossp']))?><br>
    <?=__('compendium_stats_overall_offensive', amount: $compendium_stats['offensive'], preset_values: array($compendium_stats['offensive'], $compendium_stats['offensivep']))?>
  </p>

  <p class="align_center bigpadding_top">
    <?=__('compendium_stats_overall_images', preset_values: array($compendium_stats['images']))?>
  </p>

  <p class="align_center padding_top">
    <?=__('compendium_stats_overall_insfw', amount: $compendium_stats['insfw'], preset_values: array($compendium_stats['insfw'], $compendium_stats['insfwp']))?><br>
    <?=__('compendium_stats_overall_igross', amount: $compendium_stats['igross'], preset_values: array($compendium_stats['igross'], $compendium_stats['igrossp']))?><br>
    <?=__('compendium_stats_overall_ioffensive', amount: $compendium_stats['ioffensive'], preset_values: array($compendium_stats['ioffensive'], $compendium_stats['ioffensivep']))?>
  </p>

  <p class="align_center bigpadding_top">
    <?=__('compendium_stats_overall_pageviews', preset_values: array($compendium_stats['pageviews']))?>
  </p>

  <p class="align_center">
    <?=__('compendium_stats_overall_imageviews', preset_values: array($compendium_stats['imageviews']))?>
  </p>

  <p class="align_center bigpadding_top">
    <?=__('compendium_stats_overall_types', preset_values: array($compendium_stats['types_count']))?><br>
    <?=__('compendium_stats_overall_categories', preset_values: array($compendium_stats['cat_count']))?><br>
    <?=__('compendium_stats_overall_eras', preset_values: array($compendium_stats['eras_count']))?>
  </p>

  <p class="align_center bigpadding_top">
    <?=__('compendium_stats_overall_more')?>
  </p>

</div>




<?php /************************************************ PAGE TYPES ************************************************/ ?>

<div class="width_50 padding_top autoscroll compendium_stats_section<?=$compendium_selector['hide']['types']?>" id="compendium_stats_types">

  <table class="nowrap">

    <thead class="uppercase">

      <tr>

        <th>
          <?=__link('pages/compendium/page_type_list', __('compendium_type_admin_short'))?>
        </th>

        <th>
          <?=__('compendium_stats_types_count')?>
        </th>

        <th>
          <?=__('compendium_stats_types_percentage')?>
        </th>

        <th>
          <?=__('compendium_stats_types_nsfw')?>
        </th>

        <th>
          <?=__('compendium_stats_types_gross')?>
        </th>

        <th>
          <?=__('compendium_stats_types_offensive')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $compendium_stats['types_count']; $i++) { ?>

      <tr>

        <td class="bold">
          <?=__link('pages/compendium/page_type?type='.$compendium_stats['types_id_'.$i], $compendium_stats['types_name_'.$i])?>
        </td>

        <td class="bold">
          <?=$compendium_stats['types_pages_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['types_pagesp_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['types_nsfw_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['types_gross_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['types_off_'.$i]?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>




<?php /************************************************ CATEGORIES ************************************************/ ?>

<div class="width_50 padding_top autoscroll compendium_stats_section<?=$compendium_selector['hide']['categories']?>" id="compendium_stats_categories">

  <table class="nowrap">

    <thead class="uppercase">

      <tr>

        <th>
          <?=__link('pages/compendium/category_list', __('compendium_stats_category'))?>
        </th>

        <th>
          <?=__('compendium_stats_types_count')?>
        </th>

        <th>
          <?=__('compendium_stats_types_nsfw')?>
        </th>

        <th>
          <?=__('compendium_stats_types_gross')?>
        </th>

        <th>
          <?=__('compendium_stats_types_offensive')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $compendium_stats['cat_count']; $i++) { ?>

      <tr>

        <td class="bold">
          <?=__link('pages/compendium/category?id='.$compendium_stats['cat_id_'.$i], $compendium_stats['cat_name_'.$i])?>
        </td>

        <td class="bold">
          <?=$compendium_stats['cat_pages_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['cat_nsfw_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['cat_gross_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['cat_off_'.$i]?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>




<?php /********************************************** CULTURAL ERAS ***********************************************/ ?>

<div class="width_60 padding_top autoscroll compendium_stats_section<?=$compendium_selector['hide']['eras']?>" id="compendium_stats_eras">

  <table class="nowrap">

    <thead class="uppercase">

      <tr>

        <th>
          <?=__link('pages/compendium/cultural_era_list', __('compendium_eras_name'))?>
        </th>

        <th>
          <?=__('compendium_eras_start')?>
        </th>

        <th>
          <?=__('compendium_eras_end')?>
        </th>

        <th>
          <?=__('compendium_stats_types_count')?>
        </th>

        <th>
          <?=__('compendium_stats_types_nsfw')?>
        </th>

        <th>
          <?=__('compendium_stats_types_gross')?>
        </th>

        <th>
          <?=__('compendium_stats_types_offensive')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = 0; $i < $compendium_stats['eras_count']; $i++) { ?>

      <tr>

        <td class="bold">
          <?=__link('pages/compendium/cultural_era?era='.$compendium_stats['eras_id_'.$i], $compendium_stats['eras_name_'.$i])?>
        </td>

        <td>
          <?=$compendium_stats['eras_start_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['eras_end_'.$i]?>
        </td>

        <td class="bold">
          <?=$compendium_stats['eras_pages_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['eras_nsfw_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['eras_gross_'.$i]?>
        </td>

        <td>
          <?=$compendium_stats['eras_off_'.$i]?>
        </td>

      </tr>

      <?php } ?>

    </tbody>

  </table>

</div>





<?php /************************************************ TIMELINE **************************************************/ ?>

<div class="width_30 padding_top autoscroll compendium_stats_section<?=$compendium_selector['hide']['years']?>" id="compendium_stats_years">

  <table>

    <thead class="uppercase">

      <tr>

        <th>
          <?=__('year')?>
        </th>

        <th>
          <?=__('compendium_stats_timeline_pages')?>
        </th>

        <th>
          <?=__('compendium_stats_timeline_images')?>
        </th>

      </tr>

    </thead>
    <tbody class="align_center altc">

      <?php for($i = date('Y'); $i >= $compendium_stats['oldest_year']; $i--) { ?>

      <tr>

        <td class="bold">
          <?=$i?>
        </td>

        <td class="bold">
          <?=$compendium_stats['years_pages_'.$i]?>
        </td>

        <td class="bold">
          <?=$compendium_stats['years_images_'.$i]?>
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