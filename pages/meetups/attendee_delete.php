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

// Delete the attendee
if(is_array($attendee_data))
  $attendee_delete_error = meetups_attendees_delete($attendee_id);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if(!is_array($attendee_data) || !$attendee_data['is_finished']) { ?>
<td colspan="4" class="indiv red text_white align_center uppercase bold vspaced">
<?php } else { ?>
<td colspan="3" class="indiv red text_white align_center uppercase bold vspaced">
<?php } ?>

  <?php if(isset($attendee_delete_error)) { ?>
  <?=__('error').__(':', spaces_after: 1).$attendee_delete_error?>
  <?php } else if(!is_array($attendee_data)) { ?>
  <?=__('error').__(':', spaces_after: 1).$attendee_data?>
  <?php } else { ?>
  <?=__('meetups_attendees_delete_ok')?>
  <?php } ?>

</td>
