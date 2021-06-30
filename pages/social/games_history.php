<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/nobleme.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/social/games_history";
$page_title_en    = "Fallen games";
$page_title_fr    = "Jeux disparus";
$page_description = "A tribute to the memory of the fallen games of NoBleme's past";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('nobleme_gaming_history_title')?>
  </h1>

  <h5>
    <?=__('nobleme_gaming_history_subtitle')?>
  </h5>

  <p>
    <?=__('nobleme_gaming_history_body_1')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_body_2')?>
  </p>

  <h2 class="bigpadding_top" id="nbrpg">
    <?=__('nobleme_gaming_history_nbrpg_title')?>
  </h2>

  <div class="align_center padding_top padding_bot">
    <img src="<?=$path?>img/doc/games_nbrpg.png" alt="NBRPG.png" title="NoBlemeRPG"><br>
    <span class="italics"><?=__('nobleme_gaming_history_nbrpg_image')?></span>
  </div>

  <p>
    <?=__('nobleme_gaming_history_nbrpg_body_1')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nbrpg_body_2')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nbrpg_body_3')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nbrpg_body_4')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nbrpg_body_5')?>
  </p>

  <div class="bigpadding_top flexcontainer align_center">
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nbrpg_1.png">
        <img src="<?=$path?>img/doc/games_nbrpg_1.png" alt="NBRPG_1.png" title="NoBlemeRPG">
      </a>
    </div>
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nbrpg_2.png">
        <img src="<?=$path?>img/doc/games_nbrpg_2.png" alt="NBRPG_2.png" title="NoBlemeRPG">
      </a>
    </div>
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nbrpg_3.png">
        <img src="<?=$path?>img/doc/games_nbrpg_3.png" alt="NBRPG_3.png" title="NoBlemeRPG">
      </a>
    </div>
  </div>
  <div class="tinypadding_top flexcontainer align_center">
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nbrpg_4.png">
        <img src="<?=$path?>img/doc/games_nbrpg_4.png" alt="NBRPG_4.png" title="NoBlemeRPG">
      </a>
    </div>
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nbrpg_5.png">
        <img src="<?=$path?>img/doc/games_nbrpg_5.png" alt="NBRPG_5.png" title="NoBlemeRPG">
      </a>
    </div>
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nbrpg_6.png">
        <img src="<?=$path?>img/doc/games_nbrpg_6.png" alt="NBRPG_6.png" title="NoBlemeRPG">
      </a>
    </div>
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nbrpg_7.png">
        <img src="<?=$path?>img/doc/games_nbrpg_7.png" alt="NBRPG_7.png" title="NoBlemeRPG">
      </a>
    </div>
  </div>

  <h2 class="bigpadding_top" id="nrm">
    <?=__('nobleme_gaming_history_nrm_title')?>
  </h2>

  <div class="align_center padding_top padding_bot">
    <img src="<?=$path?>img/doc/games_nrm.png" alt="NRM.png" title="NRM Online"><br>
    <span class="italics"><?=__('nobleme_gaming_history_nrm_image')?></span>
  </div>

  <p>
    <?=__('nobleme_gaming_history_nrm_body_1')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nrm_body_2')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nrm_body_3')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nrm_body_4')?>
  </p>

  <p>
    <?=__('nobleme_gaming_history_nrm_body_5')?>
  </p>

  <div class="bigpadding_top smallpadding_bot flexcontainer align_center">
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nrm_1.png">
        <img src="<?=$path?>img/doc/games_nrm_1.png" alt="NRM_1.png" title="NRM Online">
      </a>
    </div>
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nrm_2.png">
        <img src="<?=$path?>img/doc/games_nrm_2.png" alt="NRM_2.png" title="NRM Online">
      </a>
    </div>
    <div class="flex spaced">
      <a class="noglow" href="<?=$path?>img/doc/games_nrm_3.png">
        <img src="<?=$path?>img/doc/games_nrm_3.png" alt="NRM_3.png" title="NRM Online">
      </a>
    </div>
  </div>

  <p class="tinypadding_bot">
    <?=__('nobleme_gaming_history_nrm_body_6')?>
  </p>

  <div class="align_center padding_top">
    <a class="noglow" href="<?=$path?>img/doc/games_nrm_rankings.png">
      <img src="<?=$path?>img/doc/games_nrm_rankings.png" alt="NRM.png" title="NRM Online">
    </a>
  </div>


</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }