<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../inc/functions_time.inc.php';  # Time management

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/page_missing_edit";
$page_title_en    = "Compendium: Edit missing page";
$page_title_fr    = "Compendium : Modifier une page manquante";

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Missing page contents

// Fetch the id or the url
$compendium_missing_id  = (int)form_fetch_element('id', request_type: 'GET', default_value: 0);
$compendium_missing_url = compendium_format_url(form_fetch_element('url', request_type: 'GET'));

// Fetch the missing page data
$compendium_missing_data = compendium_missing_get(  missing_id:   $compendium_missing_id  ,
                                                    missing_url:  $compendium_missing_url );

// Redirect if the missing page doesn't exist
if($compendium_missing_id && !$compendium_missing_data)
  exit(header('Location: '.$path.'pages/compendium/page_missing_list'));

// Prepare the form values
$compendium_missing_url   = ($compendium_missing_id)  ? $compendium_missing_data['url']   : $compendium_missing_url;
$compendium_missing_title = ($compendium_missing_id)  ? $compendium_missing_data['title'] : '';
$compendium_missing_notes = ($compendium_missing_id)  ? $compendium_missing_data['notes'] : '';

// Update the form values if submitted
if(isset($_POST['compendium_missing_submit']))
{
  $compendium_missing_url   = compendium_format_url(form_fetch_element('compendium_missing_url'));
  $compendium_missing_title = form_fetch_element('compendium_missing_title');
  $compendium_missing_notes = form_fetch_element('compendium_missing_notes');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit the missing page

// Attempt to edit the page if requested
if(isset($_POST['compendium_missing_submit']))
{
  // Assemble the page data
  $compendium_missing_edit_data = array(  'title' => $compendium_missing_title  ,
                                          'notes' => $compendium_missing_notes  );

  // Edit the page
  $compendium_missing_edit = compendium_missing_edit( $compendium_missing_url       ,
                                                      $compendium_missing_edit_data ,
                                                      $compendium_missing_id        );

  // Redirect if it was properly edited
  if(is_null($compendium_missing_edit))
    exit(header("Location: ".$path."pages/compendium/page_missing?url=".$compendium_missing_url));
}

// Prepare the form values for displaying
if(isset($_POST['compendium_missing_submit']))
{
  $compendium_missing_url   = sanitize_output($compendium_missing_url);
  $compendium_missing_title = sanitize_output($compendium_missing_title);
  $compendium_missing_notes = sanitize_output($compendium_missing_notes);
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1 class="align_center bigpadding_bot">
    <?php if($compendium_missing_url) { ?>
    <?=__link('pages/compendium/page_missing?url='.$compendium_missing_url, __('compendium_missing_edit_title'), 'noglow')?>
    <?php } else { ?>
    <?=__link('pages/compendium/page_missing_list', __('compendium_missing_edit_create'), 'noglow')?>
    <?php } ?>
  </h1>

  <?php if(isset($compendium_missing_edit)) { ?>
  <div class="padding_bot">
    <div class="red text_white uppercase bold bigger spaced">
      <?=__('error').__(':', spaces_after: 1).$compendium_missing_edit?>
    </div>
  </div>
  <?php } ?>

  <form method="POST">
    <fieldset>

      <label for="compendium_missing_url"><?=__('compendium_missing_edit_url')?></label>
      <input type="text" class="indiv" id="compendium_missing_url" name="compendium_missing_url" value="<?=$compendium_missing_url?>" autocomplete="off" list="compendium_url_list" onkeyup="compendium_autocomplete_url('compendium_missing_url', 'compendium_url_list_parent', 'compendium_url_list', null, 1);">
      <div id="compendium_url_list_parent">
        <datalist id="compendium_url_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <div class="smallpadding_top">
        <label for="compendium_missing_title"><?=__('compendium_missing_edit_name')?></label>
        <input type="text" class="indiv" id="compendium_missing_title" name="compendium_missing_title" value="<?=$compendium_missing_title?>">
      </div>

      <div class="smallpadding_top">
        <label for="compendium_missing_notes"><?=__('compendium_missing_edit_notes')?></label>
        <textarea class="indiv compendium_admin_summary" id="compendium_missing_notes" name="compendium_missing_notes"><?=$compendium_missing_notes?></textarea>
      </div>

      <div class="smallpadding_top">
        <input type="submit" name="compendium_missing_submit" value="<?=__('compendium_page_edit_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }