<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch compendium page's history entry

// Fetch the history entry's id
$compendium_history_id = (int)form_fetch_element('compendium_history_id');

// Fetch the history entry data
$compendium_history_data = compendium_page_history_get($compendium_history_id);

// Prepare the checkbox
$compendium_history_major_checkbox = ($compendium_history_data && $compendium_history_data['major']) ? ' checked' : '';



/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if(!$compendium_history_data) { ?>

<div class="padding_top padding_bot">
  <h5 class="red text_white bold uppercase align_center spaced">
    <?=__('error').__(':', spaces_after: 1).__('compendium_page_history_none')?>
  </h5>
</div>

<?php } else { ?>

<h4 class="padding_bot align_center">
  <?=__('compendium_page_history_edit_title')?>
</h4>

<fieldset>

  <div class="smallpadding_bot">
    <label for="compendium_history_edit_summary_en"><?=__('compendium_page_history_edit_body_en')?></label>
    <input class="indiv" type="text" id="compendium_history_edit_summary_en" name="compendium_history_edit_summary_en" value="<?=$compendium_history_data['body_en']?>">
  </div>

  <div class="smallpadding_bot">
    <label for="compendium_history_edit_summary_fr"><?=__('compendium_page_history_edit_body_fr')?></label>
    <input class="indiv" type="text" id="compendium_history_edit_summary_fr" name="compendium_history_edit_summary_fr" value="<?=$compendium_history_data['body_fr']?>">
  </div>

  <div class="tinypadding_top smallpadding_bot">
    <input type="checkbox" id="compendium_history_edit_major" name="compendium_history_edit_major"<?=$compendium_history_major_checkbox?>>
    <label class="label_inline" for="compendium_history_edit_major"><?=__('compendium_page_history_edit_major')?></label>
  </div>

  <button onclick="compendium_page_history_edit('<?=$compendium_history_data['page_id']?>', '<?=$compendium_history_id?>')"><?=__('compendium_page_history_edit_submit')?></button>

</fieldset>

<?php } ?>