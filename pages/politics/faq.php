<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../lang/politics.lang.php';  # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/politics/faq";
$page_title_en    = "Contrapolitics";
$page_title_fr    = "Contrepolitique";
$page_description = "Society has failed us. We, in turn, must fail society";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('politics_faq_title')?>
  </h1>

  <h5 class="bigpadding_top">
    <?=__('politics_faq_nobleme_title')?>
  </h5>

  <p>
    <?=__('politics_faq_nobleme_1')?>
  </p>

  <p>
    <?=__('politics_faq_nobleme_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('politics_faq_movement_title')?>
  </h5>

  <p>
    <?=__('politics_faq_movement_1')?>
  </p>

  <p>
    <?=__('politics_faq_movement_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('politics_faq_branding_title')?>
  </h5>

  <p>
    <?=__('politics_faq_branding_1')?>
  </p>

  <p>
    <?=__('politics_faq_branding_2')?>
  </p>

  <div class="floater float_right float_above"><img src="<?=$path?>img/common/logo.png" alt="<?=__('image')?>" class="bigglow"><?=__('politics_faq_branding_logo')?></div>
  <p>
    <?=__('politics_faq_branding_3')?>
  </p>

  <p>
    <?=__('politics_faq_branding_4')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }