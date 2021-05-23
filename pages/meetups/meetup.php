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

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/list";
$page_title_en    = "Real life meetup";
$page_title_fr    = "Rencontre IRL";
$page_description = "Real life meetup between the members of NoBleme's community";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Meetup data

// Fetch the meetup's data
$meetup_data = meetups_get((int)form_fetch_element('id', request_type: 'GET'));

// Redirect to the meetup list if anything went wrong
if(!$meetup_data)
  exit(header('Location: '.$path.'pages/meetups/list'));

// Fetch the meetup's attendees
$meetup_attendees = meetups_list_attendees($meetup_data['id']);

// Redirect to the meetup list if anything went wrong
if(!$meetup_attendees)
  exit(header('Location: '.$path.'pages/meetups/list'));

// Update the page summary
if($meetup_data['is_deleted'])
  $hidden_activity  = 1;
$page_url           = "pages/meetups/".$meetup_data['id'];
$page_title_en      = $meetup_data['date_short_en']." meetup";
$page_title_fr      = "IRL du ".$meetup_data['date_short_fr'];
$page_description  .= " taking place ".$meetup_data['date_en']." in ".$meetup_data['location'];




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>

    <?php if($meetup_data['is_deleted']) { ?>
    <?=__link('pages/meetups/list', __('meetups_title_deleted'), 'text_red noglow')?>
    <?php } else { ?>
    <?=__link('pages/meetups/list', __('meetups_title'), 'text_red noglow')?>
    <?php } ?>

    <?php if($is_moderator) { ?>
    <?php if(!$meetup_data['is_deleted']) { ?>
    <?=__icon('edit', alt: 'M', title: __('edit'), title_case: 'initials')?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials')?>
    <?php } else { ?>
    <?=__icon('refresh', alt: 'R', title: __('restore'), title_case: 'initials')?>
    <?php if($is_admin) { ?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials')?>
    <?php } ?>
    <?php } ?>
    <?php } ?>

  </h1>

  <h4>
    <?=__('meetups_subtitle', preset_values: array($meetup_data['date'], $meetup_data['location']))?>
  </h4>

  <?php if($meetup_data['is_finished']) { ?>

  <p>
    <?=__('meetups_past_body')?>
  </p>

  <?php } else if($meetup_data['is_today']) { ?>

  <p>
    <?=__('meetups_today_body')?>
  </p>

  <?php } else { ?>

  <p>
    <?=__('meetups_future_body_1', preset_values: array($meetup_data['days_until']))?>
  </p>

  <p>
    <?=__('meetups_future_body_2')?>
  </p>

  <?php if($meetup_data['wrong_lang_en'] || $meetup_data['wrong_lang_fr']) { ?>

  <p>
    <?=__('meetups_wrong_language')?>
  </p>

  <?php } ?>

  <?php } ?>

  <?php if($meetup_data['details']) { ?>

  <h4 class="bigpadding_top">
    <?=__('meetups_details_title')?>
  </h4>

  <p>
    <?=$meetup_data['details']?>
  </p>

  <?php } ?>

  <h4 class="bigpadding_top">

    <?php if($meetup_attendees['rows']) { ?>
    <?php if($meetup_data['is_finished']) { ?>
    <?=__('meetups_attendees_finished', amount: $meetup_attendees['rows'], preset_values: array($meetup_attendees['rows']))?>
    <?php } else if($meetup_data['is_today']) { ?>
    <?=__('meetups_attendees_present', amount: $meetup_attendees['rows'], preset_values: array($meetup_attendees['rows']))?>
    <?php } else { ?>
    <?=__('meetups_attendees_future', amount: $meetup_attendees['rows'], preset_values: array($meetup_attendees['rows']))?>
    <?php } ?>
    <?php } else { ?>
    <?php if($meetup_data['is_finished']) { ?>
    <?=__('meetups_no_attendees_finished')?>
    <?php } else { ?>
    <?=__('meetups_no_attendees_future')?>
    <?php } ?>
    <?php } ?>

    <?php if($is_moderator) { ?>
    <?=__icon('user_add', alt: '+', title: __('add'), title_case: 'initials', class: 'valign_h4 pointer spaced')?>
    <?php } ?>

  </h4>

  <?php if($meetup_attendees['rows']) { ?>

  <?php if(!$meetup_data['is_finished'] && !$meetup_data['is_today']) { ?>
  <p>
    <?=__('meetups_attendees_body')?>
  </p>
  <?php } ?>

  <div class="padding_top">
    <table>
      <thead>

        <tr class="uppercase nowrap">

          <th>
            <?=__('username')?>
          </th>

          <?php if(!$meetup_data['is_finished']) { ?>
          <th>
            <?=__('meetups_attendees_lock')?>
          </th>
          <?php } ?>

          <th>
            <?=__('meetups_attendees_details')?>
          </th>

          <?php if($is_moderator) { ?>
          <th>
            <?=__('act')?>
          </th>
          <?php } ?>

        </tr>

      </thead>
      <tbody class="altc">

        <?php for($i = 0; $i < $meetup_attendees['rows']; $i++) { ?>

        <tr class="align_center">

          <td class="nowrap bold">
            <?=$meetup_attendees[$i]['nick']?>
          </td>

          <?php if(!$meetup_data['is_finished']) { ?>
          <?php if($meetup_attendees[$i]['lock']) { ?>
          <td class="text_green bold nowrap">
            &check;
          </td>
          <?php } else { ?>
          <td class="text_red bold nowrap">
            &cross;
          </td>
          <?php } ?>
          <?php } ?>

          <td>
            <?=$meetup_attendees[$i]['extra']?>
          </td>

          <?php if($is_moderator) { ?>
          <td class="nowrap">
            <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials')?>
            <?=__icon('user_delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials')?>
          </td>
          <?php } ?>

        </tr>

        <?php } ?>

      </tbody>
    </table>
  </div>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }