<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './inc/includes.inc.php';    # Core
include_once './lang/personal.lang.php';  # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "cv";
$page_title_en    = "Éric Bisceglia";
$page_title_fr    = "Éric Bisceglia";
$page_description = "Éric Bisceglia's portfolio and curriculum vitæ";

// Enforce light color theme, hide the header and the footer
$mode         = 'light';
$hide_header  = true;
$hide_footer  = true;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/**********************************************************************************/ include './inc/header.inc.php'; ?>

<div class="width_50 nowrap spaced">

  <div class="flexcontainer bigpadding_top padding_bot">
    <div class="autoflex spaced_right">
      <h1>
        <?=__('cv_name')?>
      </h1>
      <h5>
        <?=__('cv_title_1')?>
      </h5>
      <h5>
        <?=__('cv_title_2')?>
      </h5>
    </div>
    <div class="autoflex spaced_left">
      <p>
        <?=__('cv_summary')?>
      </p>
    </div>
  </div>

  <hr>

  <h5 class="padding_top indented">
    <?=__('cv_career')?>
  </h5>

  <div class="flexcontainer padding_top padding_bot">
    <div class="autoflex spaced_right">
      <?=__('cv_career_years')?>
    </div>
    <div class="autoflex spaced">
      <?=__('cv_career_companies')?>
    </div>
    <div class="autoflex spaced_left">
      <?=__('cv_career_descriptions')?>
    </div>
  </div>

  <hr>

  <h5 class="padding_top indented">
    <?=__('cv_skills')?>
  </h5>

  <div class="flexcontainer padding_top padding_bot">
    <div class="autoflex spaced_right">
      <?=__('cv_skills_name')?>
    </div>
    <div class="autoflex spaced_left">
      <?=__('cv_skills_details')?>
    </div>
  </div>

  <hr>

  <h5 class="padding_top indented">
    <?=__('cv_afterword')?>
  </h5>

  <p class="dowrap">
    <?=__('cv_afterword_1')?>
  </p>

  <p class="dowrap">
    <?=__('cv_afterword_2')?>
  </p>

  <p class="dowrap">
    <?=__('cv_afterword_3')?>
  </p>

  <p class="dowrap bigpadding_bot">
    <?=__('cv_afterword_4')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*************************************************************************************/ include './inc/footer.inc.php';