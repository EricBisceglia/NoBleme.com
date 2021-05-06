<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/irc.act.php';   # Actions
include_once './../../lang/irc.lang.php';     # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/irc/channel_add";
$page_title_en    = "New IRC channel";
$page_title_fr    = "Nouveau canal IRC";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add the channel to the list

// Create the channel if requested
if(isset($_POST['irc_channel_add_submit']))
{
  // Prepare the data array
  $irc_channel_add_contents = array(  'name'    => form_fetch_element('irc_channel_add_name')     ,
                                      'desc_en' => form_fetch_element('irc_channel_add_desc_en')  ,
                                      'desc_fr' => form_fetch_element('irc_channel_add_desc_fr')  ,
                                      'type'    => form_fetch_element('irc_channel_add_type', 1)  ,
                                      'lang_en' => form_fetch_element('irc_channel_add_english')  ,
                                      'lang_fr' => form_fetch_element('irc_channel_add_french')   );

  // Attempt to create the channel
  $irc_channel_add_error = irc_channels_add($irc_channel_add_contents);

  // Redirect if all went well
  if(is_int($irc_channel_add_error))
    header('Location: '.$path.'pages/irc/faq?channels');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the form elements

// Form values
$irc_channel_add_name     = sanitize_output(form_fetch_element('irc_channel_add_name'));
$irc_channel_add_desc_en  = sanitize_output(form_fetch_element('irc_channel_add_desc_en'));
$irc_channel_add_desc_fr  = sanitize_output(form_fetch_element('irc_channel_add_desc_fr'));
$irc_channel_add_type     = form_fetch_element('irc_channel_add_type', 1);
$irc_channel_add_english  = form_fetch_element('irc_channel_add_english');
$irc_channel_add_french   = form_fetch_element('irc_channel_add_french');

// Channel types dropdown menu
for($i = 0; $i <= 3; $i++)
{
  // Fetch the channel type
  $irc_channel_type = irc_channels_type_get($i);

  // Prepare the name
  $irc_channel_type_name[$i] = sanitize_output($irc_channel_type['name']);

  // Preselect the correct dropdown entry
  $irc_channel_type_selected[$i] = ($i == $irc_channel_add_type) ? ' selected' : '';
}

// Languages checkboxes
$irc_language_english = ($irc_channel_add_english)  ? ' checked' : '';
$irc_language_french  = ($irc_channel_add_french)   ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('irc_channels_add_title')?>
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
        <label for="irc_channel_add_name"><?=__('irc_channels_add_name')?></label>
        <input class="indiv" type="text" id="irc_channel_add_name" name="irc_channel_add_name" value="<?=$irc_channel_add_name?>">
      </div>

      <div class="smallpadding_bot">
        <label for="irc_channel_add_desc_en"><?=__('irc_channels_add_desc_en')?></label>
        <input class="indiv" type="text" id="irc_channel_add_desc_en" name="irc_channel_add_desc_en" value="<?=$irc_channel_add_desc_en?>">
      </div>

      <div class="padding_bot">
        <label for="irc_channel_add_desc_fr"><?=__('irc_channels_add_desc_fr')?></label>
        <input class="indiv" type="text" id="irc_channel_add_desc_fr" name="irc_channel_add_desc_fr" value="<?=$irc_channel_add_desc_fr?>">
      </div>

      <div class="padding_bot">
        <label for="irc_channel_add_type"><?=__('irc_channels_add_type')?></label>
        <select class="indiv align_left" id="irc_channel_add_type" name="irc_channel_add_type">
          <?php for($i = 0; $i <= 3; $i++) { ?>
          <option value="<?=$i?>"<?=$irc_channel_type_selected[$i]?>><?=$irc_channel_type_name[$i]?></option>
          <?php } ?>
        </select>
      </div>

      <div class="smallpadding_bot">
        <label><?=__('irc_channels_add_languages')?></label>
        <input type="checkbox" id="irc_channel_add_english" name="irc_channel_add_english"<?=$irc_language_english?>>
        <label class="label_inline" for="irc_channel_add_english"><?=string_change_case(__('english'), 'initials')?></label><br>
        <input type="checkbox" id="irc_channel_add_french" name="irc_channel_add_french"<?=$irc_language_french?>>
        <label class="label_inline" for="irc_channel_add_french"><?=string_change_case(__('french'), 'initials')?></label>
      </div>

      <?php if(isset($irc_channel_add_error)) { ?>
      <div class="smallpadding_top padding_bot">
        <h5 class="red text_white bold uppercase spaced">
          <?=__('error').__(':', spaces_after: 1).$irc_channel_add_error?>
        </h5>
      </div>
      <?php } ?>

      <div class="tinypadding_top">
        <input type="submit" name="irc_channel_add_submit" value="<?=__('irc_channels_add_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }