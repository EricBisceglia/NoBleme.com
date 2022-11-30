<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/meetups.act.php'; # Actions
include_once './../../lang/meetups.lang.php';   # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/list";
$page_title_en    = "Real life meetups";
$page_title_fr    = "Rencontres IRL";
$page_description = "List of past and future real life meetups within NoBleme's community";

// Extra JS
$js = array('meetups/list');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Meetups list

// Check whether a search/sort is being done
$meetups_list_search_status = form_fetch_element('meetups_list_search', element_exists: true);

// Fetch the search order
$meetups_list_search_order = form_fetch_element('meetups_list_search_order', 'date');

// Look for a set year
$meetups_search_date = ($meetups_list_search_status) ? form_fetch_element('meetups_list_date') : form_fetch_element('year', request_type: 'GET');

// Look for a set location
$meetups_search_location = ($meetups_list_search_status) ? form_fetch_element('meetups_list_location') : form_fetch_element('location', request_type: 'GET');

// Look for a set attendee
if(isset($_GET['attendee']))
  $meetups_search_attendee = (int)form_fetch_element('attendee', request_type: 'GET', default_value: 0);
else
  $meetups_search_attendee = form_fetch_element('meetups_search_attendee');

// Assemble the search array
$meetups_list_search = array( 'date'      => $meetups_search_date                         ,
                              'lang'      => form_fetch_element('meetups_list_language')  ,
                              'location'  => $meetups_search_location                     ,
                              'people'    => form_fetch_element('meetups_list_attendees') ,
                              'attendee'  => $meetups_search_attendee                     );

// Fetch the meetups list
$meetups_list = meetups_list( $meetups_list_search_order  ,
                              $meetups_list_search        );

// Fetch the meetup years
$meetup_years = meetups_list_years();

// Look up the most attended meetup's attendee count
$meetups_max_attendees = meetups_get_max_attendees();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Meetup years selector menu

// Prepare the default option
$meetups_date_selected  = (is_null($meetups_search_date)) ? ' selected' : '';
$meetups_dates_list     = '<option value="0"'.$meetups_date_selected.'>&nbsp;</option>';

// Loop through the years and select the correct one if requested
for($i = 0; $i < $meetup_years['rows']; $i++)
{
  $meetups_date_selected  = ($meetups_search_date === $meetup_years[$i]['year']) ? ' selected' : '';
  $meetups_dates_list    .= '<option value="'.$meetup_years[$i]['year'].'"'.$meetups_date_selected.'>'.$meetup_years[$i]['year'].'</option>';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_social_meetups')?>
    <?=__icon('stats', alt: 's', title: string_change_case(__('statistics'), 'initials'), href: "pages/meetups/stats")?>
    <?php if($is_moderator) { ?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', href: 'pages/meetups/add')?>
    <?php } ?>
  </h1>

  <p>
    <?=__('meetups_list_body_1')?>
  </p>

  <?php if($meetups_search_attendee && $meetups_list['attendee']) { ?>

  <p>
    <?=__('meetups_list_body_2')?>
  </p>

  <p class="bold padding_top">
    <?=__('meetups_list_body_3', preset_values: array($meetups_search_attendee, $meetups_list['attendee']))?>
  </p>

  <p class="bigpadding_bot">
    <?=__('meetups_list_body_4')?>
  </p>

  <?php } else { ?>

  <p class="bigpadding_bot">
    <?=__('meetups_list_body_2')?>
  </p>

  <?php } ?>

  <form method="POST">
    <fieldset>

    <input type="hidden" name="meetups_list_search_order" id="meetups_list_search_order" value="<?=$meetups_list_search_order?>">
    <input type="hidden" name="meetups_search_attendee" id="meetups_search_attendee" value="<?=$meetups_search_attendee?>">

      <div class="autoscroll">
        <table>
          <thead>

            <tr class="uppercase">

              <th>
                <?=__('meetups_list_date')?>
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "meetups_list_search('date');")?>
              </th>

              <th>
                <?=__('language', amount: 2)?>
              </th>

              <th>
                <?=__('location')?>
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "meetups_list_search('location');")?>
              </th>

              <th>
                <?=__('meetups_list_attendees')?>
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials', onclick: "meetups_list_search('people');")?>
              </th>

            </tr>

            <tr>

              <th>
                <select class="table_search" name="meetups_list_date" id="meetups_list_date" onchange="meetups_list_search()">
                  <?=$meetups_dates_list?>
                </select>
              </th>

              <th>
                <select class="table_search" name="meetups_list_language" id="meetups_list_language" onchange="meetups_list_search()">
                  <option value="0">&nbsp;</option>
                  <?php if($lang === 'EN') { ?>
                  <option value="ENFR"><?=string_change_case(__('bilingual'), 'initials')?></option>
                  <option value="EN"><?=string_change_case(__('english'), 'initials')?></option>
                  <option value="FR"><?=string_change_case(__('french'), 'initials')?></option>
                  <?php } else { ?>
                  <option value="FREN"><?=string_change_case(__('bilingual'), 'initials')?></option>
                  <option value="FR"><?=string_change_case(__('french'), 'initials')?></option>
                  <option value="EN"><?=string_change_case(__('english'), 'initials')?></option>
                  <?php } ?>
                </select>
              </th>

              <th>
                <input type="text" class="table_search" name="meetups_list_location" id="meetups_list_location" value="<?=$meetups_search_location?>" size="1" onkeyup="meetups_list_search();">
              </th>

              <th>
                <select class="table_search" name="meetups_list_attendees" id="meetups_list_attendees" onchange="meetups_list_search()">
                  <option value="0" selected>&nbsp;</option>
                  <?php for($i = 5; $i <= $meetups_max_attendees; $i += 5) { ?>
                  <option value="<?=$i?>"><?=$i?>+</option>
                  <?php } ?>
                </select>
              </th>

            </tr>

          </thead>
          <tbody class="altc" id="meetups_list_tbody">

          <?php } ?>

          <tr>
            <?php if($is_moderator) { ?>
            <td colspan="5" class="uppercase text_light dark bold align_center">
            <?php } else { ?>
            <td colspan="4" class="uppercase text_light dark bold align_center">
            <?php } ?>
              <?php if(!$meetups_list['rows']) { ?>
              <?=__('meetups_list_none')?>
              <?php } else { ?>
              <?=__('meetups_list_count', preset_values:array($meetups_list['rows']))?>
              <?php } ?>
            </td>
          </tr>

            <?php for($i = 0; $i < $meetups_list['rows']; $i++) { ?>

            <tr class="align_center pointer<?=$meetups_list[$i]['css']?>" onclick="window.location = '<?=$path.'pages/meetups/'.$meetups_list[$i]['id']?>';">

              <td class="nowrap">
                <?=__link('pages/meetups/'.$meetups_list[$i]['id'], $meetups_list[$i]['date'], 'noglow '.$meetups_list[$i]['css_link'])?>
              </td>

              <td class="nowrap">
                <?php if($meetups_list[$i]['lang_en']) { ?>
                <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
                <?php } if($meetups_list[$i]['lang_fr']) { ?>
                <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="20" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
                <?php } ?>
              </td>

              <td>
                <?=$meetups_list[$i]['location']?>
              </td>

              <td class="bold nowrap">
                <?=$meetups_list[$i]['people']?>
              </td>

            </tr>

            <?php } ?>

            <?php if(!page_is_fetched_dynamically()) { ?>

          </tbody>
        </table>
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }