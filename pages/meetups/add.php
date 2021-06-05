<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/meetups.act.php'; # Actions
include_once './../../lang/meetups.lang.php';   # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/add";
$page_title_en    = "Add a new meetup";
$page_title_fr    = "Créer une nouvelle IRL";

// Extra JS
$js = array('meetups/meetup', 'common/toggle', 'common/preview');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add a meetup

// Attempt to create the meetup
if(isset($_POST['meetups_add_submit']))
{
  // Prepare an array with the meetup data
  $meetups_add_data = array(  'date'        => form_fetch_element('meetups_add_date')                           ,
                              'location'    => form_fetch_element('meetups_add_location')                       ,
                              'lang_en'     => form_fetch_element('meetups_add_lang_en', element_exists: true)  ,
                              'lang_fr'     => form_fetch_element('meetups_add_lang_fr', element_exists: true)  ,
                              'details_en'  => form_fetch_element('meetups_add_details_en')                     ,
                              'details_fr'  => form_fetch_element('meetups_add_details_fr')                     );

  // Create the meetup
  $meetups_add = meetups_add($meetups_add_data);

  // If the meetup was properly created, redirect to it
  if(is_int($meetups_add))
    exit(header("Location: ".$path."pages/meetups/".$meetups_add));
}

// Keep the forms filled if there was an error
$meetups_add_date       = sanitize_output(form_fetch_element('meetups_add_date'));
$meetups_add_location   = sanitize_output(form_fetch_element('meetups_add_location'));
$meetups_add_lang_en    = form_fetch_element('meetups_add_lang_en', element_exists: true) ? ' checked' : '';
$meetups_add_lang_fr    = form_fetch_element('meetups_add_lang_fr', element_exists: true) ? ' checked' : '';
$meetups_add_details_en = sanitize_output(form_fetch_element('meetups_add_details_en'));
$meetups_add_details_fr = sanitize_output(form_fetch_element('meetups_add_details_fr'));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/meetups/list', __('meetups_new_title'), 'noglow text_red')?>
  </h1>

  <p class="padding_bot">
    <?=__('meetups_new_header')?>
  </p>

  <form method="POST">
    <fieldset>

      <?php if(isset($meetups_add)) { ?>
      <div class="padding_bot">
        <div class="red text_white uppercase bold spaced bigger">
          <?=__('error').__(':', spaces_after: 1).$meetups_add?>
        </div>
      </div>
      <?php } ?>

      <h5 class="padding_bot">
        <?=__('meetups_new_summary')?>
      </h5>

      <div class="smallpadding_bot">
        <label for="meetups_add_date"><?=__('meetups_new_date')?></label>
        <input class="indiv" type="text" id="meetups_add_date" name="meetups_add_date" value="<?=$meetups_add_date?>">
      </div>

      <div class="smallpadding_bot">
        <label for="meetups_add_location"><?=__('meetups_new_location')?></label>
        <input class="indiv" type="text" id="meetups_add_location" name="meetups_add_location" value="<?=$meetups_add_location?>" maxlength="20">
      </div>

      <div class="tinypadding_top padding_bot">
        <label><?=__('meetups_new_languages')?></label>
        <?php if($lang == 'EN') { ?>
        <input type="checkbox" id="meetups_add_lang_en" name="meetups_add_lang_en"<?=$meetups_add_lang_en?>>
        <label class="label_inline" for="meetups_add_lang_en"><?=string_change_case(__('english'), 'initials')?></label><br>
        <?php } ?>
        <input type="checkbox" id="meetups_add_lang_fr" name="meetups_add_lang_fr"<?=$meetups_add_lang_fr?>>
        <label class="label_inline" for="meetups_add_lang_fr"><?=string_change_case(__('french'), 'initials')?></label><br>
        <?php if($lang != 'EN') { ?>
        <input type="checkbox" id="meetups_add_lang_en" name="meetups_add_lang_en"<?=$meetups_add_lang_en?>>
        <label class="label_inline" for="meetups_add_lang_en"><?=string_change_case(__('english'), 'initials')?></label><br>
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
          <label for="meetups_add_details_en"><?=__('meetups_new_details_en')?></label>
          <textarea class="higher" id="meetups_add_details_en" name="meetups_add_details_en" onkeyup="meetups_details_preview('en', 'add');" onfocus="meetups_details_preview('en', 'add');"><?=$meetups_add_details_en?></textarea>
        </div>
        <div class="flex spaced_left">
          <label for="meetups_add_details_fr"><?=__('meetups_new_details_fr')?></label>
          <textarea class="higher" id="meetups_add_details_fr" name="meetups_add_details_fr" onkeyup="meetups_details_preview('fr', 'add');" onfocus="meetups_details_preview('fr', 'add');"><?=$meetups_add_details_fr?></textarea>
        </div>
        <?php } else { ?>
        <div class="flex spaced_right">
          <label for="meetups_add_details_fr"><?=__('meetups_new_details_fr')?></label>
          <textarea class="higher" id="meetups_add_details_fr" name="meetups_add_details_fr" onkeyup="meetups_details_preview('fr', 'add');" onfocus="meetups_details_preview('fr', 'add');"><?=$meetups_add_details_fr?></textarea>
        </div>
        <div class="flex spaced_left">
          <label for="meetups_add_details_en"><?=__('meetups_new_details_en')?></label>
          <textarea class="higher" id="meetups_add_details_en" name="meetups_add_details_en" onkeyup="meetups_details_preview('en', 'add');" onfocus="meetups_details_preview('en', 'add');"><?=$meetups_add_details_en?></textarea>
        </div>
        <?php } ?>
      </div>

      <div class="tinypadding_top">
        <input type="submit" name="meetups_add_submit" value="<?=__('meetups_new_submit')?>">
      </div>

    </fieldset>
  </form>

  <div id="meetups_add_preview_container_en" class="hidden padding_top meetups_add_preview">
    <h4 class="bigpadding_top">
      <?=__('meetups_new_preview_en')?>
    </h4>
    <p id="meetups_add_preview_en">
      &nbsp;
    </p>
  </div>

  <div id="meetups_add_preview_container_fr" class="hidden padding_top meetups_add_preview">
    <h4 class="bigpadding_top">
      <?=__('meetups_new_preview_fr')?>
    </h4>
    <p id="meetups_add_preview_fr">
      &nbsp;
    </p>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }