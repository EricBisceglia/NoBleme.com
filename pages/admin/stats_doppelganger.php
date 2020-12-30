<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/stats.act.php';       # Actions
include_once './../../lang/stats.lang.php';         # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/stats_doppelganger";
$page_title_en    = "Doppelgänger";
$page_title_fr    = "Doppelgänger";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the doppelganger data

$doppelgangers = stats_doppelgangers_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center">
    <?=__('submenu_admin_doppelganger')?>
  </h1>

  <h4 class="align_center padding_top bigpadding_bot">
    <?=__('admin_doppel_subtitle')?>
  </h4>

  <?php if(!$doppelgangers['rows']) { ?>
  <h5 class="hugepadding_top bigpadding_bot align_center uppercase">
    <?=__('admin_doppel_none')?>
  </h5>
  <?php } else { ?>

  <table>
    <thead>

      <tr class="uppercase">

        <th>
          <?=__('admin_doppel_ip')?>
        </th>

        <th>
          <?=__('username')?>
        </th>

        <th>
          <?=__('admin_doppel_activity')?>
        </th>

        <?php if($doppelgangers['includes_bans']) { ?>
        <th>
          <?=__('admin_doppel_banned')?>
        </th>
        <?php } ?>

      </tr>

    </thead>
    <tbody class="align_center">

      <?php for($i = 0; $i < $doppelgangers['rows']; $i++) { ?>

      <?php if(!$i || $doppelgangers[$i]['ip'] != $doppelgangers[$i-1]['ip']) { ?>
      <tr>
        <?php if($doppelgangers['includes_bans']) { ?>
        <td colspan="4" class="dark smallest">
        <?php } else { ?>
        <td colspan="3" class="dark smallest">
        <?php } ?>
          &nbsp;
        </td>
      </tr>
      <?php } ?>

      <tr>

        <?php if(!$i || $doppelgangers[$i]['ip'] != $doppelgangers[$i-1]['ip']) { ?>

        <?php if($is_admin) { ?>
        <td rowspan="<?=$doppelgangers[$i]['count']?>" class="bold">
          <?=$doppelgangers[$i]['ip']?>
        </td>
        <?php } else { ?>
        <td rowspan="<?=$doppelgangers[$i]['count']?>" class="bold">
          <?=$doppelgangers[$i]['hiddenip']?>
        </td>
        <?php } ?>
        <?php } ?>

        <td>
          <?=__link('pages/users/'.$doppelgangers[$i]['id'], $doppelgangers[$i]['username'])?>
        </td>

        <td>
          <?=$doppelgangers[$i]['activity']?>
        </td>

        <?php if($doppelgangers['includes_bans']) { ?>
        <?php if($doppelgangers[$i]['banned']) { ?>
        <td class="red bold">
          <?=$doppelgangers[$i]['banned']?>
        </td>
        <?php } else { ?>
        <td>
          &nbsp;
        </td>
        <?php } ?>

        <?php } ?>

      </tr>

      <?php } ?>

    </tbody>
  </table>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }