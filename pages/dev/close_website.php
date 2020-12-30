<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/dev.act.php';         # Actions
include_once './../../lang/dev/devtools.lang.php';  # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/close_website";
$page_title_en    = "Close the website";
$page_title_fr    = "Fermer le site";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Toggle the website's status between open and closed
if(isset($_POST['dev_toggle_website_status']))
  dev_toggle_website_status($system_variables['update_in_progress']);

// Update the system variables array entry so that the header knows of the new status
$system_variables['update_in_progress'] = system_variable_fetch('update_in_progress');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="padding_top align_center hugepadding_bot">
    <?=__('dev_close_website_title')?>
  </h1>

  <form method="POST" class="bigpadding_bot">
    <fieldset class="align_center">
      <input class="bigbutton" type="submit" name="dev_toggle_website_status" value="<?=__('dev_close_website_button')?>">
    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }