<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';      # Core
include_once './../../lang/compendium.lang.php';  # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/mission_statement";
$page_title_en    = "Mission statement";
$page_title_fr    = "Foire aux questions";
$page_description = "Goals and inner workings of NoBleme's 21st century compendium";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/compendium/index', __('submenu_pages_compendium'), 'noglow')?>
  </h1>

  <h5>
    <?=__('compendium_faq_subtitle')?>
  </h5>

  <p class="padding_bot padding_top">
    <?=__('compendium_faq_intro')?>
  </p>

  <h5 class="smallpadding_bot padding_top">
    <?=__('compendium_faq_contents')?>
  </h5>

  <ul>
    <li>
      <?=__link('mission_statement#whatis', __('compendium_faq_whatis_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#contents', __('compendium_faq_contents_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#goals',__('compendium_faq_goals_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#bias',__('compendium_faq_bias_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#leaning',__('compendium_faq_leaning_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#longterm',__('compendium_faq_longterm_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#who',__('compendium_faq_who_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#guidelines',__('compendium_faq_guidelines_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#sources',__('compendium_faq_sources_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#controversial',__('compendium_faq_controversial_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#differences',__('compendium_faq_differences_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#whynobleme',__('compendium_faq_whynobleme_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#whatnobleme',__('compendium_faq_whatnobleme_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#contact',__('compendium_faq_contact_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#help',__('compendium_faq_help_title'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#updates',__('compendium_faq_updates_title'), is_internal: false)?>
    </li>
  </ul>

  <h5 id="whatis" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#whatis', __('compendium_faq_whatis_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_whatis_1')?>
  </p>

  <p>
    <?=__('compendium_faq_whatis_2')?>
  </p>

  <h5 id="contents" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#contents', __('compendium_faq_contents_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_contents_1')?>
  </p>

  <p>
    <?=__('compendium_faq_contents_2')?>
  </p>

  <p>
    <?=__('compendium_faq_contents_3')?>
  </p>

  <p>
    <?=__('compendium_faq_contents_4')?>
  </p>

  <p>
    <?=__('compendium_faq_contents_5')?>
  </p>

  <p>
    <?=__('compendium_faq_contents_6')?>
  </p>

  <h5 id="goals" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#goals', __('compendium_faq_goals_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_goals_1')?>
  </p>

  <p>
    <?=__('compendium_faq_goals_2')?>
  </p>

  <p>
    <?=__('compendium_faq_goals_3')?>
  </p>

  <p>
    <?=__('compendium_faq_goals_4')?>
  </p>

  <h5 id="bias" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#bias', __('compendium_faq_bias_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_bias_1')?>
  </p>

  <p>
    <?=__('compendium_faq_bias_2')?>
  </p>

  <p>
    <?=__('compendium_faq_bias_3')?>
  </p>

  <h5 id="leaning" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#leaning', __('compendium_faq_leaning_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_leaning_1')?>
  </p>

  <p>
    <?=__('compendium_faq_leaning_2')?>
  </p>

  <p>
    <?=__('compendium_faq_leaning_3')?>
  </p>

  <p>
    <?=__('compendium_faq_leaning_4')?>
  </p>

  <p>
    <?=__('compendium_faq_leaning_5')?>
  </p>

  <h5 id="longterm" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#longterm', __('compendium_faq_longterm_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_longterm_1')?>
  </p>

  <p>
    <?=__('compendium_faq_longterm_2')?>
  </p>

  <h5 id="who" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#who', __('compendium_faq_who_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_who_1')?>
  </p>

  <p>
    <?=__('compendium_faq_who_2')?>
  </p>

  <p>
    <?=__('compendium_faq_who_3')?>
  </p>

  <h5 id="guidelines" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#guidelines', __('compendium_faq_guidelines_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_guidelines_1')?>
  </p>

  <p>
    <?=__('compendium_faq_guidelines_2')?>
  </p>

  <p>
    <?=__('compendium_faq_guidelines_3')?>
  </p>

  <p>
    <?=__('compendium_faq_guidelines_4')?>
  </p>

  <h5 id="sources" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#sources', __('compendium_faq_sources_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_sources_1')?>
  </p>

  <p>
    <?=__('compendium_faq_sources_2')?>
  </p>

  <p>
    <?=__('compendium_faq_sources_3')?>
  </p>

  <h5 id="controversial" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#controversial', __('compendium_faq_controversial_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_controversial_1')?>
  </p>

  <p>
    <?=__('compendium_faq_controversial_2')?>
  </p>

  <p>
    <?=__('compendium_faq_controversial_3')?>
  </p>

  <p>
    <?=__('compendium_faq_controversial_4')?>
  </p>

  <h5 id="differences" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#differences', __('compendium_faq_differences_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_differences_1')?>
  </p>

  <p>
    <?=__('compendium_faq_differences_2')?>
  </p>

  <ul class="smallpadding_top">
    <li>
      <?=__('compendium_faq_differences_3')?>
    </li>
    <li>
      <?=__('compendium_faq_differences_4')?>
    </li>
    <li>
      <?=__('compendium_faq_differences_5')?>
    </li>
    <li>
      <?=__('compendium_faq_differences_6')?>
    </li>
    <li>
      <?=__('compendium_faq_differences_7')?>
    </li>
  </ul>

  <h5 id="whynobleme" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#whynobleme', __('compendium_faq_whynobleme_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_whynobleme_1')?>
  </p>

  <p>
    <?=__('compendium_faq_whynobleme_2')?>
  </p>

  <h5 id="whatnobleme" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#whatnobleme', __('compendium_faq_whatnobleme_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_whatnobleme_1')?>
  </p>

  <p>
    <?=__('compendium_faq_whatnobleme_2')?>
  </p>

  <h5 id="contact" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#contact', __('compendium_faq_contact_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_contact_1')?>
  </p>

  <p>
    <?=__('compendium_faq_contact_2')?>
  </p>

  <h5 id="help" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#help', __('compendium_faq_help_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_help_1')?>
  </p>

  <p>
    <?=__('compendium_faq_help_2')?>
  </p>

  <h5 id="updates" class="hugepadding_top smallpadding_bot">
    <?=__link('pages/compendium/mission_statement#updates', __('compendium_faq_updates_title'), 'noglow')?>
  </h5>

  <p>
    <?=__('compendium_faq_updates_1')?>
  </p>

  <p>
    <?=__('compendium_faq_updates_2')?>
  </p>

  <p>
    <?=__('compendium_faq_updates_3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }