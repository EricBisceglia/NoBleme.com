<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/quotes.act.php';  # Actions
include_once './../../lang/quotes.lang.php';    # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/quotes/stats";
$page_title_en    = "Quotes statistics";
$page_title_fr    = "Statistiques des citations";
$page_description = "Statistics generated from NoBleme's quote database";

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
$quotes_selector_entries = array( 'users' ,
                                  'years' );

// Define the default dropdown menu entry
$quotes_selector_default = 'users';

// Initialize the page section selector data
$quotes_selector = page_section_selector(           $quotes_selector_entries  ,
                                          default:  $quotes_selector_default  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>
      <?=__('quotes_stats_selector')?>
      <select class="inh" id="quotes_stats_selector" onchange="page_section_selector('quotes_stats', '<?=$quotes_selector_default?>');">
        <option value="users"<?=$quotes_selector['menu']['users']?>><?=string_change_case(__('user+'), 'initials')?></option>
        <option value="years"<?=$quotes_selector['menu']['years']?>><?=string_change_case(__('year+'), 'initials')?></option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************* USERS ****************************************************/ ?>

<div class="width_60 padding_top quotes_stats_section<?=$quotes_selector['hide']['users']?>" id="quotes_stats_users">

  <?=string_change_case(__('user+'), 'initials')?>

</div>




<?php /************************************************* USERS ****************************************************/ ?>

<div class="width_60 padding_top quotes_stats_section<?=$quotes_selector['hide']['years']?>" id="quotes_stats_years">

  <?=string_change_case(__('year+'), 'initials')?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }