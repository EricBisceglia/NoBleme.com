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
$page_title_en    = "Contrapositionist manifesto";
$page_title_fr    = "Manifeste contrapositioniste";
$page_description = "The contrapositionist manifesto. The system has failed, the world is on a timer, but it is not too late for change to come from within.";

// Hide the footer
$hide_footer = 1;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center bigpadding_top bigglow">
    <?=__('pol_manifesto_title')?>
  </h1>

  <h5 class="align_center hugepadding_bot bigglow">
    <?=__('pol_manifesto_subtitle')?>
  </h5>

  <h4 class="bigpadding_top">
    <?=__('pol_manifesto_preamble_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_preamble_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_preamble_body')?>

  <h4 class="gigapadding_top">
    <?=__('pol_manifesto_contents')?>
  </h4>

  <div class="bigpadding_top padding_bot">
    <a class="bigger bold" href="#intro">
      <?=__('pol_manifesto_intro_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#contract">
      <?=__('pol_manifesto_contract_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#capitalism">
      <?=__('pol_manifesto_capitalism_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#violence">
      <?=__('pol_manifesto_violence_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#work">
      <?=__('pol_manifesto_work_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#creativity">
      <?=__('pol_manifesto_creativity_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#nature">
      <?=__('pol_manifesto_nature_title')?>
    </a>
  </div>
  <div class="bigpadding_top bigpadding_bot">
    <a class="bigger bold" href="#inspirations">
      <?=__('pol_manifesto_inspirations_title')?>
    </a>
  </div>
  <div>
    <a class="bigger bold" href="#philosophy">
      <?=__('pol_manifesto_philosophy_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#listening">
      <?=__('pol_manifesto_listening_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#solutions">
      <?=__('pol_manifesto_solutions_title')?>
    </a>
  </div>
  <div class="smallpadding_top">
    <a class="bigger bold" href="#praxis">
      <?=__('pol_manifesto_praxis_title')?>
    </a>
  </div>

  <h4 class="gigapadding_top" id="intro">
    <?=__('pol_manifesto_intro_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_intro_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_intro_body')?>

  <h4 class="megapadding_top" id="contract">
    <?=__('pol_manifesto_contract_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_contract_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_contract_body')?>

  <h4 class="megapadding_top" id="capitalism">
    <?=__('pol_manifesto_capitalism_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_capitalism_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_capitalism_body')?>

  <h4 class="megapadding_top" id="violence">
    <?=__('pol_manifesto_violence_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_violence_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_violence_body')?>

  <h4 class="megapadding_top" id="work">
    <?=__('pol_manifesto_work_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_work_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_work_body')?>

  <h4 class="megapadding_top" id="creativity">
    <?=__('pol_manifesto_creativity_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_creativity_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_creativity_body')?>

  <h4 class="megapadding_top" id="nature">
    <?=__('pol_manifesto_nature_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_nature_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_nature_body')?>

  <h4 class="megapadding_top" id="inspirations">
    <?=__('pol_manifesto_inspirations_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_inspirations_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_inspirations_body')?>

  <h4 class="megapadding_top" id="philosophy">
    <?=__('pol_manifesto_philosophy_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_philosophy_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_philosophy_body')?>

  <h4 class="megapadding_top" id="listening">
    <?=__('pol_manifesto_listening_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_listening_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_listening_body')?>

  <h4 class="megapadding_top" id="solutions">
    <?=__('pol_manifesto_solutions_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_solutions_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_solutions_body')?>

  <h4 class="megapadding_top" id="praxis">
    <?=__('pol_manifesto_praxis_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_praxis_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_praxis_body')?>

  <h4 class="megapadding_top">
    <?=__('pol_manifesto_postface_title')?>
  </h4>

  <div class="padding_top">
    <blockquote class="nobackground text_light bold">
      <span class="glow">
        <?=__('pol_manifesto_postface_quote')?>
      </span>
    </blockquote>
  </div>

  <?=__('pol_manifesto_postface_body')?>

  <div class="hugepadding_top bigpadding_bot">
    <?=__('pol_manifesto_credits')?>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }