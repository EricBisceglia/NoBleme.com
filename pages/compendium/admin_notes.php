<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/compendium.act.php';    # Actions
include_once './../../lang/compendium.lang.php';      # Translations
include_once './../../inc/bbcodes.inc.php';           # BBCodes
include_once './../../inc/functions_time.inc.php';    # Time management
include_once './../../inc/functions_numbers.inc.php'; # Number formatting

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/admin_notes";
$page_title_en    = "Compendium admin notes";
$page_title_fr    = "Compendium : Notes admin";

// Compendium admin menu selection
$compendium_admin_menu['notes'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update the admin notes

if(isset($_POST['compendium_admin_notes_submit']))
  compendium_admin_notes_edit(array(  'global'      => form_fetch_element('compendium_admin_notes_global')      ,
                                      'snippets'    => form_fetch_element('compendium_admin_notes_snippets')    ,
                                      'template_en' => form_fetch_element('compendium_admin_notes_template_en') ,
                                      'template_fr' => form_fetch_element('compendium_admin_notes_template_fr') ,
                                      'links'       => form_fetch_element('compendium_admin_notes_links')       ));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the admin notes

$compendium_admin_notes = compendium_admin_notes_get();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_70">

  <h2 class="padding_top padding_bot align_center">
    <?=__link('pages/compendium/index', __('compendium_admin_notes_title'), 'noglow')?>
  </h2>

  <form method="POST">
    <fieldset>

      <div class="flexcontainer tinypadding_top smallpadding_bot">
        <div class="flex spaced_right">

          <div class="smallpadding_bot">
            <label for="compendium_admin_notes_global"><?=__('compendium_admin_notes_global')?></label>
            <textarea class="compendium_admin_notes" id="compendium_admin_notes_global" name="compendium_admin_notes_global"><?=$compendium_admin_notes['global']?></textarea>
          </div>

          <label for="compendium_admin_notes_template_en"><?=__('compendium_admin_notes_template_en')?></label>
          <textarea class="compendium_admin_notes" id="compendium_admin_notes_template_en" name="compendium_admin_notes_template_en"><?=$compendium_admin_notes['template_en']?></textarea>

        </div>
        <div class="flex spaced_left">

          <div class="smallpadding_bot">
            <label for="compendium_admin_notes_snippets"><?=__('compendium_admin_notes_snippets')?></label>
            <textarea class="compendium_admin_notes" id="compendium_admin_notes_snippets" name="compendium_admin_notes_snippets"><?=$compendium_admin_notes['snippets']?></textarea>
          </div>

          <label for="compendium_admin_notes_template_fr"><?=__('compendium_admin_notes_template_fr')?></label>
          <textarea class="compendium_admin_notes" id="compendium_admin_notes_template_fr" name="compendium_admin_notes_template_fr"><?=$compendium_admin_notes['template_fr']?></textarea>

        </div>
      </div>

      <div class="smallpadding_bot">
        <label for="compendium_admin_notes_links"><?=__('compendium_admin_notes_links')?></label>
        <textarea class="compendium_admin_links" id="compendium_admin_notes_links" name="compendium_admin_notes_links"><?=$compendium_admin_notes['links']?></textarea>
      </div>

      <div class="tinypadding_top bigpadding_bot">
        <input type="submit" name="compendium_admin_notes_submit" value="<?=__('compendium_admin_notes_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }