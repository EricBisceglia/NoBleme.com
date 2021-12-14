<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../lang/politics.lang.php';  # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/politics/manifesto";
$page_title_en    = "Contramanifesto";
$page_title_fr    = "Contremanifeste";
$page_description = "The world is on a timer, but it is never too late for change to come from within.";

// Hide the footer
$hide_footer = 1;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center bigpadding_top bigglow_dark">
    <?=__('politics_manifesto_title')?>
  </h1>

  <h4 class="align_center hugepadding_bot bigglow_dark">
    <?=__('politics_manifesto_subtitle')?>
  </h4>

  <h4 class="bigpadding_top">
    <?=__('politics_manifesto_preamble_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_preamble_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_preamble_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_8')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_9')?>
  </p>
  <p>
    <?=__('politics_manifesto_preamble_10')?>
  </p>
  <p class="text_red bold glow_dark">
    <?=__('politics_manifesto_preamble_11')?>
  </p>

  <h4 class="gigapadding_top">
    <?=__('politics_manifesto_contents')?>
  </h4>

  <div class="bigpadding_top padding_bot">
    <a class="bigger bold" href="#intro">
      <?=__('politics_manifesto_intro_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#contract">
      <?=__('politics_manifesto_contract_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#capitalism">
      <?=__('politics_manifesto_capitalism_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#violence">
      <?=__('politics_manifesto_violence_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#work">
      <?=__('politics_manifesto_work_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#creativity">
      <?=__('politics_manifesto_creativity_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#nature">
      <?=__('politics_manifesto_nature_title')?>
    </a>
  </div>
  <div class="bigpadding_top">
    <a class="bigger bold" href="#philosophy">
      <?=__('politics_manifesto_philosophy_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#listening">
      <?=__('politics_manifesto_listening_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#solutions">
      <?=__('politics_manifesto_solutions_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#praxis">
      <?=__('politics_manifesto_praxis_title')?>
    </a>
  </div>
  <div class="bigpadding_top">
    <a class="bigger bold" href="#postface">
      <?=__('politics_manifesto_postface_title')?>
    </a>
  </div>

  <h4 class="gigapadding_top" id="intro">
    <?=__('politics_manifesto_intro_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_intro_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_intro_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_intro_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_intro_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_intro_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_intro_5')?>
  </p>

  <h4 class="megapadding_top" id="contract">
    <?=__('politics_manifesto_contract_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_contract_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_contract_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_contract_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_contract_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_contract_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_contract_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_contract_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_contract_7')?>
  </p>

  <h4 class="megapadding_top" id="capitalism">
    <?=__('politics_manifesto_capitalism_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_capitalism_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_capitalism_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_8')?>
  </p>
  <p>
    <?=__('politics_manifesto_capitalism_9')?>
  </p>

  <h4 class="megapadding_top" id="violence">
    <?=__('politics_manifesto_violence_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_violence_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_violence_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_8')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_9')?>
  </p>
  <p>
    <?=__('politics_manifesto_violence_10')?>
  </p>

  <h4 class="megapadding_top" id="work">
    <?=__('politics_manifesto_work_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_work_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_work_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_8')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_9')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_10')?>
  </p>
  <p>
    <?=__('politics_manifesto_work_11')?>
  </p>

  <h4 class="megapadding_top" id="creativity">
    <?=__('politics_manifesto_creativity_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_creativity_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_creativity_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_8')?>
  </p>
  <p>
    <?=__('politics_manifesto_creativity_9')?>
  </p>

  <h4 class="megapadding_top" id="nature">
    <?=__('politics_manifesto_nature_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_nature_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_nature_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_nature_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_nature_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_nature_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_nature_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_nature_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_nature_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_nature_8')?>
  </p>
  <p class="megapadding_bot">
    <?=__('politics_manifesto_nature_9')?>
  </p>

  <h4 class="megapadding_top" id="philosophy">
    <?=__('politics_manifesto_philosophy_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_philosophy_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_philosophy_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_philosophy_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_philosophy_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_philosophy_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_philosophy_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_philosophy_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_philosophy_7')?>
  </p>

  <h4 class="megapadding_top" id="listening">
    <?=__('politics_manifesto_listening_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_listening_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_listening_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_listening_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_listening_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_listening_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_listening_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_listening_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_listening_7')?>
  </p>

  <h4 class="megapadding_top" id="solutions">
    <?=__('politics_manifesto_solutions_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_solutions_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_solutions_intro_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_intro_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_8')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_9')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_10')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_11')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_12')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_13')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_14')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_15')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_16')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_17')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_18')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_19')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_20')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_21')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_22')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_23')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_24')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_25')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_26')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_27')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_28')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_29')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_30')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_31')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_32')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_33')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_34')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_35')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_36')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_37')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_38')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_39')?>
  </p>
  <p>
    <?=__('politics_manifesto_solutions_point_40')?>
  </p>

  <h4 class="megapadding_top" id="praxis">
    <?=__('politics_manifesto_praxis_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_praxis_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_praxis_intro_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_intro_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_intro_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_5')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_6')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_7')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_8')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_9')?>
  </p>
  <p>
    <?=__('politics_manifesto_praxis_points_10')?>
  </p>

  <h4 class="megapadding_top" id="postface">
    <?=__('politics_manifesto_postface_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground bold">
      <span class="text_red glow_dark">
        <?=__('politics_manifesto_postface_quote')?>
      </span>
    </blockquote>
  </div>

  <p>
    <?=__('politics_manifesto_postface_1')?>
  </p>
  <p>
    <?=__('politics_manifesto_postface_2')?>
  </p>
  <p>
    <?=__('politics_manifesto_postface_3')?>
  </p>
  <p>
    <?=__('politics_manifesto_postface_4')?>
  </p>
  <p>
    <?=__('politics_manifesto_postface_5')?>
  </p>
  <p class="bold glow_dark text_red bigger">
    <?=__('politics_manifesto_postface_6')?>
  </p>

  <div class="hugepadding_top bigpadding_bot">
    <p class="hugepadding_top align_center text_red glow_dark small">
      <?=__('politics_manifesto_credits')?>
    </p>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }