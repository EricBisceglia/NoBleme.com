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

  <p class="padding_bot">
    <?=__('compendium_faq_intro')?>
  </p>

  <h5 class="smallpadding_bot padding_top">
    <?=__('compendium_faq_contents')?>
  </h5>

  <ul>
    <li>
      <?=__link('mission_statement#q0', __('compendium_faq_question_0'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q1', __('compendium_faq_question_1'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q2',__('compendium_faq_question_2'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q3',__('compendium_faq_question_3'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q4',__('compendium_faq_question_4'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q5',__('compendium_faq_question_5'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q6',__('compendium_faq_question_6'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q7',__('compendium_faq_question_7'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q8',__('compendium_faq_question_8'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q9',__('compendium_faq_question_9'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q10',__('compendium_faq_question_10'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q11',__('compendium_faq_question_11'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q12',__('compendium_faq_question_12'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q13',__('compendium_faq_question_13'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q14',__('compendium_faq_question_14'), is_internal: false)?>
    </li>
    <li>
      <?=__link('mission_statement#q15',__('compendium_faq_question_15'), is_internal: false)?>
    </li>
  </ul>

  <h5 id="q0" class="bigpadding_top">
    <?=__('compendium_faq_question_0')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_0_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_0_2')?>
  </p>

  <h5 id="q1" class="bigpadding_top">
    <?=__('compendium_faq_question_1')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_1_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_1_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_1_3')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_1_4')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_1_5')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_1_6')?>
  </p>

  <h5 id="q2" class="bigpadding_top">
    <?=__('compendium_faq_question_2')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_2_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_2_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_2_3')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_2_4')?>
  </p>

  <h5 id="q3" class="bigpadding_top">
    <?=__('compendium_faq_question_3')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_3_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_3_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_3_3')?>
  </p>

  <h5 id="q4" class="bigpadding_top">
    <?=__('compendium_faq_question_4')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_4_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_4_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_4_3')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_4_4')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_4_5')?>
  </p>

  <h5 id="q5" class="bigpadding_top">
    <?=__('compendium_faq_question_5')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_5_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_5_2')?>
  </p>

  <h5 id="q6" class="bigpadding_top">
    <?=__('compendium_faq_question_6')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_6_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_6_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_6_3')?>
  </p>

  <h5 id="q7" class="bigpadding_top">
    <?=__('compendium_faq_question_7')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_7_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_7_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_7_3')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_7_4')?>
  </p>

  <h5 id="q8" class="bigpadding_top">
    <?=__('compendium_faq_question_8')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_8_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_8_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_8_3')?>
  </p>

  <h5 id="q9" class="bigpadding_top">
    <?=__('compendium_faq_question_9')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_9_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_9_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_9_3')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_9_4')?>
  </p>

  <h5 id="q10" class="bigpadding_top">
    <?=__('compendium_faq_question_10')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_10_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_10_2')?>
  </p>

  <ul class="smallpadding_top">
    <li>
      <?=__('compendium_faq_answer_10_3')?>
    </li>
    <li>
      <?=__('compendium_faq_answer_10_4')?>
    </li>
    <li>
      <?=__('compendium_faq_answer_10_5')?>
    </li>
    <li>
      <?=__('compendium_faq_answer_10_6')?>
    </li>
    <li>
      <?=__('compendium_faq_answer_10_7')?>
    </li>
  </ul>

  <h5 id="q11" class="bigpadding_top">
    <?=__('compendium_faq_question_11')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_11_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_11_2')?>
  </p>

  <h5 id="q12" class="bigpadding_top">
    <?=__('compendium_faq_question_12')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_12_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_12_2')?>
  </p>

  <h5 id="q13" class="bigpadding_top">
    <?=__('compendium_faq_question_13')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_13_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_13_2')?>
  </p>

  <h5 id="q14" class="bigpadding_top">
    <?=__('compendium_faq_question_14')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_14_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_14_2')?>
  </p>

  <h5 id="q15" class="bigpadding_top">
    <?=__('compendium_faq_question_15')?>
  </h5>

  <p>
    <?=__('compendium_faq_answer_15_1')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_15_2')?>
  </p>

  <p>
    <?=__('compendium_faq_answer_15_3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }