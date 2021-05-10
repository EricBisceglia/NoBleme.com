<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/integrations.act.php';  # Actions
include_once './../../lang/integrations.lang.php';    # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/social/irc_channel_edit";
$page_title_en    = "Edit an IRC channel";
$page_title_fr    = "Éditer un canal IRC";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the form elements

// Fetch the channel id
$channel_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the data
$irc_channel_data = irc_channels_get($channel_id);

// Go back to the table if the channel doesn't exist
if(is_null($irc_channel_data))
  header("Location: ".$path."pages/social/irc?channels");

// Prepare the form values
$irc_channel_name     = $irc_channel_data['name'];
$irc_channel_desc_en  = $irc_channel_data['desc_en'];
$irc_channel_desc_fr  = $irc_channel_data['desc_fr'];
$irc_channel_type     = $irc_channel_data['type'];
$irc_channel_english  = $irc_channel_data['lang_en'];
$irc_channel_french   = $irc_channel_data['lang_fr'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit the channel

// Update the channel data if requested
if(isset($_POST['irc_channel_edit_submit']))
{
  // Prepare the data array
  $irc_channel_edit_contents = array( 'desc_en' => form_fetch_element('irc_channel_edit_desc_en') ,
                                      'desc_fr' => form_fetch_element('irc_channel_edit_desc_fr') ,
                                      'type'    => form_fetch_element('irc_channel_edit_type', 1) ,
                                      'lang_en' => form_fetch_element('irc_channel_edit_english') ,
                                      'lang_fr' => form_fetch_element('irc_channel_edit_french')  );

  // Attempt to edit the channel
  $irc_channel_edit_error = irc_channels_edit(  $channel_id                 ,
                                                $irc_channel_edit_contents  );

  // Redirect if all went well
  if(is_null($irc_channel_edit_error))
    header('Location: '.$path.'pages/social/irc?channels');

  // Otherwise, set the form values to the submitted ones
  $irc_channel_desc_en  = sanitize_output(form_fetch_element('irc_channel_edit_desc_en'));
  $irc_channel_desc_fr  = sanitize_output(form_fetch_element('irc_channel_edit_desc_fr'));
  $irc_channel_type     = form_fetch_element('irc_channel_edit_type', 1);
  $irc_channel_english  = form_fetch_element('irc_channel_edit_english');
  $irc_channel_french   = form_fetch_element('irc_channel_edit_french');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the form elements

// Channel types dropdown menu
for($i = 0; $i <= 3; $i++)
{
  // Fetch the channel type
  $irc_channel_type_data = irc_channels_type_get($i);

  // Prepare the name
  $irc_channel_type_name[$i] = sanitize_output($irc_channel_type_data['name']);

  // Preselect the correct dropdown entry
  $irc_channel_type_selected[$i] = ($i == $irc_channel_type) ? ' selected' : '';
}

// Languages checkboxes
$irc_language_english = ($irc_channel_english)  ? ' checked' : '';
$irc_language_french  = ($irc_channel_french)   ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('irc_channels_edit_title', preset_values: array($irc_channel_name))?>
  </h1>

  <p class="smallpadding_bot">
    <?=__('irc_channels_type_instructions')?>
  </p>

  <ul>
    <li>
      <?=__('irc_channels_type_main')?>
    </li>
    <li>
      <?=__('irc_channels_type_major')?>
    </li>
    <li>
      <?=__('irc_channels_type_minor')?>
    </li>
    <li>
      <?=__('irc_channels_type_automated')?>
    </li>
  </ul>

  <p class="padding_bot">
    <?=__('irc_channels_desc_instructions')?>
  </p>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="irc_channel_edit_desc_en"><?=__('irc_channels_add_desc_en')?></label>
        <input class="indiv" type="text" id="irc_channel_edit_desc_en" name="irc_channel_edit_desc_en" value="<?=$irc_channel_desc_en?>">
      </div>

      <div class="padding_bot">
        <label for="irc_channel_edit_desc_fr"><?=__('irc_channels_add_desc_fr')?></label>
        <input class="indiv" type="text" id="irc_channel_edit_desc_fr" name="irc_channel_edit_desc_fr" value="<?=$irc_channel_desc_fr?>">
      </div>

      <div class="padding_bot">
        <label for="irc_channel_edit_type"><?=__('irc_channels_add_type')?></label>
        <select class="indiv align_left" id="irc_channel_edit_type" name="irc_channel_edit_type">
          <?php for($i = 0; $i <= 3; $i++) { ?>
          <option value="<?=$i?>"<?=$irc_channel_type_selected[$i]?>><?=$irc_channel_type_name[$i]?></option>
          <?php } ?>
        </select>
      </div>

      <div class="smallpadding_bot">
        <label><?=__('irc_channels_add_languages')?></label>
        <input type="checkbox" id="irc_channel_edit_english" name="irc_channel_edit_english"<?=$irc_language_english?>>
        <label class="label_inline" for="irc_channel_edit_english"><?=string_change_case(__('english'), 'initials')?></label><br>
        <input type="checkbox" id="irc_channel_edit_french" name="irc_channel_edit_french"<?=$irc_language_french?>>
        <label class="label_inline" for="irc_channel_edit_french"><?=string_change_case(__('french'), 'initials')?></label>
      </div>

      <?php if(isset($irc_channel_edit_error)) { ?>
      <div class="smallpadding_top padding_bot">
        <h5 class="red text_white bold uppercase spaced">
          <?=__('error').__(':', spaces_after: 1).$irc_channel_edit_error?>
        </h5>
      </div>
      <?php } ?>

      <div class="tinypadding_top">
        <input type="submit" name="irc_channel_edit_submit" value="<?=__('irc_channels_edit_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }