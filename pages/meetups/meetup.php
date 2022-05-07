<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../actions/users.act.php';       # User actions
include_once './../../actions/meetups.act.php';     # Meetup actions
include_once './../../lang/meetups.lang.php';       # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/list";
$page_title_en    = "Real life meetup";
$page_title_fr    = "Rencontre IRL";
$page_description = "Real life meetup between the members of NoBleme's community";

// Extra JS
$js = array('meetups/meetup', 'common/toggle', 'users/autocomplete_username');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add an attendee to a meetup

// Fetch the meetup's ID
$meetup_id  = form_fetch_element('id', request_type: 'GET');
$meetup_id  = (isset($_POST['meetup_id'])) ? form_fetch_element('meetup_id') : $meetup_id;

// Add an attendee if requested
if(isset($_POST['meetup_attendees_add_submit']))
{
  // Prepare the attendee's data
  $meetup_attendee_add_data = array(  'account'   => form_fetch_element('meetup_attendees_add_account')   ,
                                      'nickname'  => form_fetch_element('meetup_attendees_add_nickname')  ,
                                      'extra_en'  => form_fetch_element('meetup_attendees_add_extra_en')  ,
                                      'extra_fr'  => form_fetch_element('meetup_attendees_add_extra_fr')  ,
                                      'lock'      => form_fetch_element('meetup_attendees_add_lock')      );

  // Submit the attendee creation request
  meetups_attendees_add(  $meetup_id                ,
                          $meetup_attendee_add_data );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit a meetup attendee

if(isset($_POST['meetup_attendees_edit_submit']))
{
  // Prepare the attendee's data
  $meetup_attendee_edit_id    = form_fetch_element('meetup_attendee_edit_id');
  $meetup_attendee_edit_data  = array(  'account'   => form_fetch_element('meetup_attendee_edit_account')   ,
                                        'nickname'  => form_fetch_element('meetup_attendee_edit_nickname')  ,
                                        'extra_en'  => form_fetch_element('meetup_attendee_edit_extra_en')  ,
                                        'extra_fr'  => form_fetch_element('meetup_attendee_edit_extra_fr')  ,
                                        'lock'      => form_fetch_element('meetup_attendee_edit_lock')      );

  // Submit the attendee modification request
  meetups_attendees_edit( $meetup_attendee_edit_id    ,
                          $meetup_attendee_edit_data  );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Meetup data

// Fetch the meetup's data
$meetup_data = meetups_get($meetup_id);

// Redirect to the meetup list if anything went wrong
if(!$meetup_data)
  exit(header('Location: '.$path.'pages/meetups/list'));

// Fetch the meetup's attendees
$meetup_attendees = meetups_attendees_list($meetup_id);

// Redirect to the meetup list if anything went wrong
if(!$meetup_attendees)
  exit(header('Location: '.$path.'pages/meetups/list'));

// Update the page summary
if($meetup_data['is_deleted'])
  $hidden_activity  = 1;
$page_url           = "pages/meetups/".$meetup_id;
$page_title_en      = $meetup_data['date_short_en']." meetup";
$page_title_fr      = "IRL du ".$meetup_data['date_short_fr'];
$page_description  .= " taking place ".$meetup_data['date_en']." in ".$meetup_data['location_raw'];




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>

    <?php if($meetup_data['is_deleted']) { ?>
    <?=__link('pages/meetups/list', __('meetups_title_deleted'), 'noglow')?>
    <?php } else { ?>
    <?=__link('pages/meetups/list', __('meetups_title'), 'noglow')?>
    <?php } ?>

    <?php if($is_moderator) { ?>
    <?php if(!$meetup_data['is_deleted']) { ?>
    <?=__icon('edit', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/meetups/edit?id='.$meetup_id)?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "meetups_delete('$meetup_id', 'soft', '".__('meetups_delete_confirm')."');", identifier: 'meetup_delete_button')?>
    <?php } else { ?>
    <?=__icon('refresh', alt: 'R', title: __('restore'), title_case: 'initials', onclick: "meetups_restore('$meetup_id', '".__('meetups_restore_confirm')."');", identifier: 'meetup_restore_button')?>
    <?php if($is_admin) { ?>
    <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "meetups_delete('$meetup_id', 'hard', '".__('meetups_delete_hard_confirm')."');", identifier: 'meetup_delete_button')?>
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

  <?php } ?>

  <div id="meetup_attendees_table">

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
      <?=__icon('user_add', alt: '+', title: __('add'), title_case: 'initials', class: 'valign_h4 pointer spaced', onclick: "meetups_attendee_add_form();")?>
      <?php } ?>

    </h4>

    <?php if($is_moderator) { ?>

    <div class="hidden padding_bot" id="meetup_add_attendee_form">

      <p class="mobile">
        <?=__('meetups_attendees_add_username')?>
      </p>

      <form method="POST" id="meetup_add_attendee_form_body">
        <fieldset>

          <div class="padding_top smallpadding_bot">
            <label for="meetup_attendees_add_account"><?=__('meetups_attendees_add_account')?></label>
            <div class="flexcontainer">
              <div style="flex: 9">
                <input type="text" class="indiv" id="meetup_attendees_add_account" name="meetup_attendees_add_account" value="" autocomplete="off" list="meetup_attendees_add_account_list" onkeyup="autocomplete_username('meetup_attendees_add_account', 'meetup_attendees_add_account_list_parent', './../common/autocomplete_username', 'meetup_attendees_add_account_list', 'meetup', '<?=$meetup_id?>');">
                <div id="meetup_attendees_add_account_list_parent">
                  <datalist id="meetup_attendees_add_account_list">
                    <option value=" ">&nbsp;</option>
                  </datalist>
                </div>
              </div>
              <div class="desktop flex align_center tooltip_container">
                <?=__icon('help', alt: '?', title: __('help'), title_case: 'initials')?>
                <div class="tooltip">
                  <?=__('meetups_attendees_add_username')?>
                </div>
              </div>
            </div>
          </div>

          <div class="smallpadding_bot">
            <label for="meetup_attendees_add_nickname"><?=__('meetups_attendees_add_nickname')?></label>
            <div class="flexcontainer">
              <div style="flex: 9">
                <input class="indiv" type="text" id="meetup_attendees_add_nickname" name="meetup_attendees_add_nickname" value="" maxlength="20">
              </div>
              <div class="desktop flex align_center tooltip_container">
                <?=__icon('help', alt: '?', title: __('help'), title_case: 'initials')?>
                <div class="tooltip">
                  <?=__('meetups_attendees_add_username')?>
                </div>
              </div>
            </div>
          </div>

          <div class="smallpadding_bot">
            <label for="meetup_attendees_add_extra_en"><?=__('meetups_attendees_add_extra_en')?></label>
            <input class="indiv" type="text" id="meetup_attendees_add_extra_en" name="meetup_attendees_add_extra_en" value="">
          </div>

          <div class="smallpadding_bot">
            <label for="meetup_attendees_add_extra_fr"><?=__('meetups_attendees_add_extra_fr')?></label>
            <input class="indiv" type="text" id="meetup_attendees_add_extra_fr" name="meetup_attendees_add_extra_fr" value="">
          </div>

          <div class="tinypadding_top smallpadding_bot">
            <input type="checkbox" id="meetup_attendees_add_lock" name="meetup_attendees_add_lock">
            <label class="label_inline bold" for="meetup_attendees_add_lock"><?=__('meetups_attendees_add_lock')?></label>
          </div>

        </fieldset>
      </form>

      <div class="tinypadding_top">
        <button onclick="meetups_attendee_add('<?=$meetup_id?>');"><?=__('meetups_attendees_add_submit')?></button>
      </div>

    </div>

    <?php } ?>

    <?php if($meetup_attendees['rows']) { ?>

    <?php if(!$meetup_data['is_finished'] && !$meetup_data['is_today']) { ?>
    <p>
      <?=__('meetups_attendees_body')?>
    </p>
    <?php } ?>

    <div class="padding_top autoscroll">
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
        <tbody class="doublealtc">

          <?php for($i = 0; $i < $meetup_attendees['rows']; $i++) { ?>

          <tr class="align_center" id="meetup_attendee_row_<?=$meetup_attendees[$i]['attendee_id']?>">

            <td class="nowrap bold">
              <?php if($meetup_attendees[$i]['user_id']) { ?>
              <?=__link('pages/users/'.$meetup_attendees[$i]['user_id'], $meetup_attendees[$i]['nick'])?>
              <?php } else { ?>
              <?=$meetup_attendees[$i]['nick']?>
              <?php } ?>
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
              <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', onclick: "meetups_attendee_edit_form('".$meetup_attendees[$i]['attendee_id']."');")?>
              <?=__icon('user_delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "meetups_attendee_delete('".$meetup_attendees[$i]['attendee_id']."', '".__('meetups_attendees_delete_confirm')."');")?>
            </td>
            <?php } ?>

          </tr>

          <tr class="hidden meetup_edit_attendee_form" id="meetup_edit_attendee_form_<?=$meetup_attendees[$i]['attendee_id']?>">
            <?php if(!$meetup_data['is_finished'] && $is_moderator) { ?>
            <td colspan="4">
            <?php } else if (!$meetup_data['is_finished'] || $is_moderator) { ?>
            <td colspan="3">
            <?php } else { ?>
            <td colspan="2">
            <?php } ?>
              &nbsp;
            </td>
          </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>

    <?php } ?>

    <?php if(!page_is_fetched_dynamically()) { ?>

  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }