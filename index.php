<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './inc/includes.inc.php';  # Core
include_once './lang/nobleme.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "index";
$page_title_en    = "Homepage";
$page_title_fr    = "Accueil";
$page_description = "NoBleme, la communauté web qui n'apporte rien mais a réponse à tout";

// Extra CSS
$css = array('index');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/**********************************************************************************/ include './inc/header.inc.php'; ?>

<div class="width_50">

  <div class="align_center padding_top bigpadding_bot bigglow nobleme_logo">
    <img src="<?=$path?>img/common/logo_full.png" alt="NoBleme.com">
  </div>

  <h1 class="bigpadding_top">
    <?=__('nobleme_home_welcome_title')?>
  </h1>

  <h5>
    <?=__('nobleme_home_welcome_subtitle')?>
  </h5>

  <p>
    <?=__('nobleme_home_intro_1')?>
  </p>

  <p>
    <?=__('nobleme_home_intro_2')?>
  </p>

  <p>
    <?=__('nobleme_home_intro_3')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('nobleme_home_statement_title')?>
  </h5>

  <p>
    <?=__('nobleme_home_statement_1')?>
  </p>

  <p>
    <?=__('nobleme_home_statement_2')?>
  </p>

  <p>
    <?=__('nobleme_home_statement_3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*************************************************************************************/ include './inc/footer.inc.php';