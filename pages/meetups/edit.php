<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../actions/meetups.act.php';     # Actions
include_once './../../lang/meetups.lang.php';       # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/edit";
$page_title_en    = "Edit a meetup";
$page_title_fr    = "Modifier une IRL";

// Extra JS
$js = array('meetups/meetup', 'common/preview');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Meetup data

// Fetch the meetup id
$meetup_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the meetup data
$meetup_data = meetups_get($meetup_id);

// Redirect if the meetup does not exist
if(!$meetup_data)
  exit(header("Location: ".$path."pages/meetups/list"));

// Prepare the form values
if(!isset($_POST['meetups_edit_submit']))
{
  $meetups_edit_date        = $meetup_data['date_ddmmyy'];
  $meetups_edit_location    = $meetup_data['location'];
  $meetups_edit_lang_en     = ($meetup_data['lang_en']) ? 'checked' : '';
  $meetups_edit_lang_fr     = ($meetup_data['lang_fr']) ? 'checked' : '';
  $meetups_edit_details_en  = $meetup_data['details_en'];
  $meetups_edit_details_fr  = $meetup_data['details_fr'];
}
else
{
  $meetups_edit_date        = sanitize_output(form_fetch_element('meetups_edit_date'));
  $meetups_edit_location    = sanitize_output(form_fetch_element('meetups_edit_location'));
  $meetups_edit_lang_en     = form_fetch_element('meetups_edit_lang_en', element_exists: true) ? ' checked' : '';
  $meetups_edit_lang_fr     = form_fetch_element('meetups_edit_lang_fr', element_exists: true) ? ' checked' : '';
  $meetups_edit_details_en  = sanitize_output(form_fetch_element('meetups_edit_details_en'));
  $meetups_edit_details_fr  = sanitize_output(form_fetch_element('meetups_edit_details_fr'));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit a meetup

// Attempt to edit the meetup
if(isset($_POST['meetups_edit_submit']))
{
  // Prepare an array with the meetup data
  $meetups_edit_data = array( 'date'        => form_fetch_element('meetups_edit_date')                          ,
                              'location'    => form_fetch_element('meetups_edit_location')                      ,
                              'lang_en'     => form_fetch_element('meetups_edit_lang_en', element_exists: true) ,
                              'lang_fr'     => form_fetch_element('meetups_edit_lang_fr', element_exists: true) ,
                              'details_en'  => form_fetch_element('meetups_edit_details_en')                    ,
                              'details_fr'  => form_fetch_element('meetups_edit_details_fr')                    );

  // Create the meetup
  $meetups_edit = meetups_edit( $meetup_id          ,
                                $meetups_edit_data  );

  // If the meetup was properly created, redirect to it
  if(!$meetups_edit)
    exit(header("Location: ".$path."pages/meetups/".$meetup_id));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="padding_bot">
    <?=__link('pages/meetups/'.$meetup_id, __('meetups_edit_title'), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <?php if(isset($meetups_edit)) { ?>
      <div class="padding_bot">
        <div class="red text_white uppercase bold spaced bigger">
          <?=__('error').__(':', spaces_after: 1).$meetups_edit?>
        </div>
      </div>
      <?php } ?>

      <h5 class="padding_bot">
        <?=__('meetups_new_summary')?>
      </h5>

      <div class="smallpadding_bot">
        <label for="meetups_edit_date"><?=__('meetups_new_date')?></label>
        <input class="indiv" type="text" id="meetups_edit_date" name="meetups_edit_date" value="<?=$meetups_edit_date?>">
      </div>

      <div class="smallpadding_bot">
        <label for="meetups_edit_location"><?=__('meetups_new_location')?></label>
        <input class="indiv" type="text" id="meetups_edit_location" name="meetups_edit_location" value="<?=$meetups_edit_location?>" maxlength="20">
      </div>

      <div class="tinypadding_top padding_bot">
        <label><?=__('meetups_new_languages')?></label>
        <?php if($lang == 'EN') { ?>
        <input type="checkbox" id="meetups_edit_lang_en" name="meetups_edit_lang_en"<?=$meetups_edit_lang_en?>>
        <label class="label_inline" for="meetups_edit_lang_en"><?=string_change_case(__('english'), 'initials')?></label><br>
        <?php } ?>
        <input type="checkbox" id="meetups_edit_lang_fr" name="meetups_edit_lang_fr"<?=$meetups_edit_lang_fr?>>
        <label class="label_inline" for="meetups_edit_lang_fr"><?=string_change_case(__('french'), 'initials')?></label><br>
        <?php if($lang != 'EN') { ?>
        <input type="checkbox" id="meetups_edit_lang_en" name="meetups_edit_lang_en"<?=$meetups_edit_lang_en?>>
        <label class="label_inline" for="meetups_edit_lang_en"><?=string_change_case(__('english'), 'initials')?></label><br>
        <?php } ?>
      </div>

      <h5>
        <?=__('meetups_new_details')?>
      </h5>

      <p>
        <?=__('meetups_new_details_body_1')?>
      </p>

      <p class="smallpadding_bot">
        <?=__('meetups_new_details_body_2')?>
      </p>

      <div class="tinypadding_top smallpadding_bot flexcontainer">
        <?php if($lang == 'EN') { ?>
        <div class="flex spaced_right">
          <label for="meetups_edit_details_en"><?=__('meetups_new_details_en')?></label>
          <textarea class="higher" id="meetups_edit_details_en" name="meetups_edit_details_en" onkeyup="meetups_details_preview('en', 'edit');" onfocus="meetups_details_preview('en', 'edit');"><?=$meetups_edit_details_en?></textarea>
        </div>
        <div class="flex spaced_left">
          <label for="meetups_edit_details_fr"><?=__('meetups_new_details_fr')?></label>
          <textarea class="higher" id="meetups_edit_details_fr" name="meetups_edit_details_fr" onkeyup="meetups_details_preview('fr', 'edit');" onfocus="meetups_details_preview('fr', 'edit');"><?=$meetups_edit_details_fr?></textarea>
        </div>
        <?php } else { ?>
        <div class="flex spaced_right">
          <label for="meetups_edit_details_fr"><?=__('meetups_new_details_fr')?></label>
          <textarea class="higher" id="meetups_edit_details_fr" name="meetups_edit_details_fr" onkeyup="meetups_details_preview('fr', 'edit');" onfocus="meetups_details_preview('fr', 'edit');"><?=$meetups_edit_details_fr?></textarea>
        </div>
        <div class="flex spaced_left">
          <label for="meetups_edit_details_en"><?=__('meetups_new_details_en')?></label>
          <textarea class="higher" id="meetups_edit_details_en" name="meetups_edit_details_en" onkeyup="meetups_details_preview('en', 'edit');" onfocus="meetups_details_preview('en', 'edit');"><?=$meetups_edit_details_en?></textarea>
        </div>
        <?php } ?>
      </div>

      <div class="tinypadding_top">
        <input type="submit" name="meetups_edit_submit" value="<?=__('meetups_edit_submit')?>">
      </div>

    </fieldset>
  </form>

  <div id="meetups_edit_preview_container_en" class="hidden padding_top meetups_edit_preview">
    <h4 class="bigpadding_top">
      <?=__('meetups_new_preview_en')?>
    </h4>
    <p id="meetups_edit_preview_en">
      &nbsp;
    </p>
  </div>

  <div id="meetups_edit_preview_container_fr" class="hidden padding_top meetups_edit_preview">
    <h4 class="bigpadding_top">
      <?=__('meetups_new_preview_fr')?>
    </h4>
    <p id="meetups_edit_preview_fr">
      &nbsp;
    </p>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }