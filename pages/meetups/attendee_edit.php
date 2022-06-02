<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/meetups.act.php'; # Actions
include_once './../../lang/meetups.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_moderators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Attendee data

// Fetch the attendee's id
$attendee_id = (int)form_fetch_element('attendee_id');

// Fetch the attendee data
$attendee_data = meetups_attendees_get($attendee_id);

// Check the confirmed attendance box if required
$attendee_locked = (is_array($attendee_data) && $attendee_data['lock']) ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if(!is_array($attendee_data) || !$attendee_data['is_finished']) { ?>
<td colspan="4">
<?php } else { ?>
<td colspan="3">
<?php } ?>

  <?php if(!is_array($attendee_data)) { ?>

  <div class="indiv red text_white align_center uppercase bold vspaced">
    <?=__('error').__(':', spaces_after: 1).$attendee_data?>
  </div>

  <?php } else { ?>

  <div class="padding_top">
    <label for="meetup_attendee_edit_account_<?=$attendee_id?>"><?=__('meetups_attendees_add_account')?></label>
    <input class="indiv light text_dark" type="text" id="meetup_attendee_edit_account_<?=$attendee_id?>" name="meetup_attendee_edit_account_<?=$attendee_id?>" value="<?=$attendee_data['account']?>" autocomplete="off" list="meetup_attendee_edit_account_<?=$attendee_id?>_list" onkeyup="autocomplete_username('meetup_attendee_edit_account_<?=$attendee_id?>', 'meetup_attendee_edit_account_<?=$attendee_id?>_list_parent', './../common/autocomplete_username', 'meetup_attendee_edit_account_<?=$attendee_id?>_list', 'meetup', '<?=$attendee_data['meetup_id']?>');">
    <div id="meetup_attendee_edit_account_<?=$attendee_id?>_list_parent">
      <datalist id="meetup_attendee_edit_account_<?=$attendee_id?>_list">
        <option value=" ">&nbsp;</option>
      </datalist>
    </div>
  </div>

  <div class="smallpadding_top">
    <label for="meetup_attendee_edit_nickname_<?=$attendee_id?>"><?=__('meetups_attendees_add_nickname')?></label>
    <input class="indiv light text_dark" type="text" id="meetup_attendee_edit_nickname_<?=$attendee_id?>" name="meetup_attendee_edit_nickname_<?=$attendee_id?>" value="<?=$attendee_data['nickname']?>">
  </div>

  <div class="smallpadding_top">
    <label for="meetup_attendee_edit_extra_en_<?=$attendee_id?>"><?=__('meetups_attendees_add_extra_en')?></label>
    <input class="indiv light text_dark" type="text" id="meetup_attendee_edit_extra_en_<?=$attendee_id?>" name="meetup_attendee_edit_extra_en_<?=$attendee_id?>" value="<?=$attendee_data['extra_en']?>">
  </div>

  <div class="smallpadding_top tinypadding_bot">
    <label for="meetup_attendee_edit_extra_fr_<?=$attendee_id?>"><?=__('meetups_attendees_add_extra_fr')?></label>
    <input class="indiv light text_dark" type="text" id="meetup_attendee_edit_extra_fr_<?=$attendee_id?>" name="meetup_attendee_edit_extra_fr_<?=$attendee_id?>" value="<?=$attendee_data['extra_fr']?>">
  </div>

  <div class="smallpadding_top">
    <input type="checkbox" id="meetup_attendee_edit_lock_<?=$attendee_id?>" name="meetup_attendee_edit_lock_<?=$attendee_id?>"<?=$attendee_locked?>>
    <label class="label_inline" for="meetup_attendee_edit_lock_<?=$attendee_id?>"><?=__('meetups_attendees_add_lock')?></label>
  </div>

  <div class="tinypadding_top padding_bot flexcontainer">
    <div class="flex">
      <button class="light white_hover text_dark text_black_hover" onclick="meetups_attendee_edit('<?=$attendee_data['meetup_id']?>', '<?=$attendee_id?>');"><?=__('meetups_attendees_edit_submit')?></button>
    </div>
    <div class="flex">
      <button class="dark black_hover text_light text_white_hover" onclick="meetups_attendee_edit_hide();"><?=__('close_form')?></button>
    </div>
  </div>

  <?php } ?>

</td>
