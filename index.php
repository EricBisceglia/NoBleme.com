<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './inc/includes.inc.php';  # Core
include_once './lang/nobleme.lang.php'; # Translations

// Menus
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Homepage';

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "index";
$page_title_en    = "Homepage";
$page_title_fr    = "Accueil";
$page_description = "NoBleme, la communauté web qui n'apporte rien mais a réponse à tout";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// All that's needed is the website's age, so let's calculate the difference between the current year and 2005
$website_age = date('Y') - 2005;

// If the current date is earlier than march 19th, then the website is not that old yet - substract a year
$website_age = (date('n') < 3 || (date('n') == 3 && date('j') < 19)) ? $website_age - 1 : $website_age;




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/**********************************************************************************/ include './inc/header.inc.php'; ?>

      <div class="width_50">

        <div class="align_center smallpadding_top smallpadding_bot">
          <img src="<?=$path?>img/common/logo_full.png">
        </div>

        <h5 class="bigpadding_top">
          <?=__('nobleme_home_welcome_title')?>
        </h5>

        <?=__('nobleme_home_welcome', 0, 0 , 0, array($website_age))?>

        <h5 class="bigpadding_top">
          <?=__('nobleme_home_tour_title')?>
        </h5>

        <?=__('nobleme_home_tour')?>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*************************************************************************************/ include './inc/footer.inc.php';