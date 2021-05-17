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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the meetups list

$meetups_list = meetups_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('meetups_list_title')?>
    <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials')?>
  </h1>

  <p>
    <?=__('meetups_list_body_1')?>
  </p>

  <p class="bigpadding_bot">
    <?=__('meetups_list_body_2')?>
  </p>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('meetups_list_date')?>
        </th>
        <th>
          <?=__('language', amount: 2)?>
        </th>
        <th>
          <?=__('meetups_list_location')?>
        </th>
        <th>
          <?=__('meetups_list_attendees')?>
        </th>
        <?php if($is_moderator) { ?>
        <th>
          <?=__('act')?>
        </th>
        <?php } ?>
      </tr>

    </thead>
    <tbody class="altc">

      <?php for($i = 0; $i < $meetups_list['rows']; $i++) { ?>

      <tr class="align_center pointer<?=$meetups_list[$i]['css']?>">

        <td>
          <?=$meetups_list[$i]['date']?>
        </td>

        <td>
          <?php if($meetups_list[$i]['lang_en']) { ?>
          <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle" height="20" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
          <?php } if($meetups_list[$i]['lang_fr']) { ?>
          <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle" height="20" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
          <?php } ?>
        </td>

        <td>
          <?=$meetups_list[$i]['location']?>
        </td>

        <td class="bold">
          <?=$meetups_list[$i]['people']?>
        </td>

        <?php if($is_moderator) { ?>
        <td>
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: '?', title: __('edit'), title_case: 'initials')?>
          <?php if($meetups_list[$i]['deleted']) { ?>
          <?=__icon('refresh', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('restore'), title_case: 'initials')?>
          <?php } else { ?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials')?>
          <?php } if($meetups_list[$i]['deleted'] && $is_admin) { ?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials')?>
          <?php } ?>
        </td>
        <?php } ?>

      </tr>

      <?php } ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }