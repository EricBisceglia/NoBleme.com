<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/nobleme.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/doc/nobleme";
$page_title_en    = "What is NoBleme?";
$page_title_fr    = "Qu'est-ce que NoBleme ?";
$page_description = "What is NoBleme? Is it even a thing? Let's find out!";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_what_is')?>
  </h1>

  <h5>
    <?=__('nobleme_what_subtitle')?>
  </h5>

  <p>
    <?=__('nobleme_what_intro')?>
  </p>

  <p>
    <?=__('nobleme_what_intro2')?>
  </p>

  <h1 class="hugepadding_top">
    <?=__('nobleme_history_title')?>
  </h1>

  <h5 class="smallpadding_top">
    <?=__('nobleme_history_beforet')?>
  </h5>

  <p>
    <?=__('nobleme_history_before1')?>
  </p>

  <p>
    <?=__('nobleme_history_before2')?>
  </p>

  <p>
    <?=__('nobleme_history_before3')?>
  </p>

  <p>
    <?=__('nobleme_history_before4')?>
  </p>

  <p>
    <?=__('nobleme_history_before5')?>
  </p>

  <p>
    <?=__('nobleme_history_before6')?>
  </p>

  <h5 class="hugepadding_top">
    <?=__('nobleme_history_earlyt')?>
  </h5>

  <p>
    <?=__('nobleme_history_early1')?>
  </p>

  <p>
    <?=__('nobleme_history_early2')?>
  </p>

  <p>
    <?=__('nobleme_history_early3')?>
  </p>

  <div class="floater float_right"><a class="noglow" href="<?=$path?>img/doc/history_2005_forum.png"><img src="<?=$path?>img/doc/history_2005_forum.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2005_forum')?></div>
  <p>
    <?=__('nobleme_history_early4')?>
  </p>

  <p>
    <?=__('nobleme_history_early5')?>
  </p>

  <p>
    <?=__('nobleme_history_early6')?>
  </p>

  <h5 class="hugepadding_top">
    <?=__('nobleme_history_communityt')?>
  </h5>

  <p>
    <?=__('nobleme_history_community1')?>
  </p>

  <div class="floater float_left float_above"><a class="noglow" href="<?=$path?>img/doc/history_2006_homepage.png"><img src="<?=$path?>img/doc/history_2006_homepage.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2006_home')?></div>
  <p>
    <?=__('nobleme_history_community2')?>
  </p>

  <p>
    <?=__('nobleme_history_community3')?>
  </p>

  <div class="floater float_right float_above"><a class="noglow" href="<?=$path?>img/doc/history_2008_nrm.png"><img src="<?=$path?>img/doc/history_2008_nrm.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2008_nrm')?></div>
  <p>
    <?=__('nobleme_history_community4')?>
  </p>

  <div class="floater float_left float_above"><a class="noglow" href="<?=$path?>img/doc/history_2008_nbrpg.png"><img src="<?=$path?>img/doc/history_2008_nbrpg.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2008_nbrpg')?></div>
  <p>
    <?=__('nobleme_history_community5')?>
  </p>

  <div class="floater float_right float_above"><a class="noglow" href="<?=$path?>img/doc/history_2008_wiki.png"><img src="<?=$path?>img/doc/history_2008_wiki.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2008_wiki')?></div>
  <p>
    <?=__('nobleme_history_community6')?>
  </p>

  <p>
    <?=__('nobleme_history_community7')?>
  </p>

  <h5 class="hugepadding_top">
    <?=__('nobleme_history_longt')?>
  </h5>

  <div class="floater float_left float_above"><a class="noglow" href="<?=$path?>img/doc/history_2010_blackout.png"><img src="<?=$path?>img/doc/history_2010_blackout.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2010_black')?></div>
  <p>
    <?=__('nobleme_history_long1')?>
  </p>

  <div class="floater float_right float_above"><a class="noglow" href="<?=$path?>img/doc/history_2012_relaunch.png"><img src="<?=$path?>img/doc/history_2012_relaunch.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2012_home')?></div>
  <p>
    <?=__('nobleme_history_long2')?>
  </p>

  <div class="floater float_left float_above"><a class="noglow" href="<?=$path?>img/doc/history_2015.png"><img src="<?=$path?>img/doc/history_2015.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2015_home')?></div>
  <p>
    <?=__('nobleme_history_long3')?>
  </p>

  <p>
    <?=__('nobleme_history_long4')?>
  </p>

  <h5 class="hugepadding_top">
    <?=__('nobleme_history_hiddent')?>
  </h5>

  <p>
    <?=__('nobleme_history_hidden1')?>
  </p>

  <div class="floater float_left float_above"><a class="noglow" href="<?=$path?>img/doc/history_2017.png"><img src="<?=$path?>img/doc/history_2017.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2017_home')?></div>
  <p>
    <?=__('nobleme_history_hidden2')?>
  </p>

  <p>
    <?=__('nobleme_history_hidden3')?>
  </p>

  <p>
    <?=__('nobleme_history_hidden4')?>
  </p>

  <div class="floater float_right"><a class="noglow" href="<?=$path?>img/doc/history_2019_meme.png"><img src="<?=$path?>img/doc/history_2019_meme.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2019_nbdb')?></div>
  <p>
    <?=__('nobleme_history_hidden5')?>
  </p>

  <h5 class="hugepadding_top">
    <?=__('nobleme_history_politicalt')?>
  </h5>

  <p>
    <?=__('nobleme_history_political1')?>
  </p>

  <p>
    <?=__('nobleme_history_political2')?>
  </p>

  <div class="floater float_left float_above"><a class="noglow" href="<?=$path?>img/doc/history_2021.png"><img src="<?=$path?>img/doc/history_2021.png" alt="<?=__('image')?>"></a><?=__('nobleme_history_img_2021_home')?></div>

  <p>
    <?=__('nobleme_history_political3')?>
  </p>

  <p>
    <?=__('nobleme_history_political4')?>
  </p>

  <h1 class="hugepadding_top">
    <?=__('nobleme_existential_title')?>
  </h1>

  <h5 class="smallpadding_top">
    <?=__('nobleme_existential_whatt')?>
  </h5>

  <p>
    <?=__('nobleme_existential_what1')?>
  </p>

  <p>
    <?=__('nobleme_existential_what2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('nobleme_existential_futuret')?>
  </h5>

  <p>
    <?=__('nobleme_existential_future1')?>
  </p>

  <p>
    <?=__('nobleme_existential_future2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('nobleme_existential_whyt')?>
  </h5>

  <p>
    <?=__('nobleme_existential_why1')?>
  </p>

  <p>
    <?=__('nobleme_existential_why2')?>
  </p>

  <p>
    <?=__('nobleme_existential_why3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }