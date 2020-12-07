<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../inc/functions_time.inc.php';      # Time management
include_once './../../actions/users/messages.act.php';  # Actions
include_once './../../lang/users/messages.lang.php';    # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/inbox";
$page_title_en    = "Message inbox";
$page_title_fr    = "Boite de réception";
$page_description = "Private message inbox - for private messages from the system or from other users.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the private messages

$messages_list = private_messages_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_user_pms_inbox')?>
  </h1>

  <h5>
    <?=__('users_inbox_subtitle')?>
  </h5>

  <p>
    <?=__('users_inbox_intro')?>
  </p>

  <div class="padding_top">
    <table>
      <thead>

        <tr class="uppercase">

          <th>
            <?=__('users_inbox_message')?>
          </th>

          <th>
            <?=__('users_inbox_sender')?>
          </th>

          <th>
            <?=__('users_inbox_sent')?>
          </th>

          <th>
            <?=__('users_inbox_read')?>
          </th>

        </tr>

      </thead>
      <tbody class="altc">

        <tr>
          <td class="uppercase text_white align_center dark bold" colspan="4">
            <?php if($messages_list['rows']) { ?>
            <?=__('users_inbox_count', $messages_list['rows'], 0, 0, array($messages_list['rows']))?>
            <?php } else { ?>
            <?=__('users_inbox_empty')?>
            <?php } ?>
          </td>
        </tr>

        <?php for($i = 0; $i < $messages_list['rows']; $i++) { ?>

        <tr class="align_center pointer">

          <td class="align_left<?=$messages_list[$i]['css']?>">
            <?=$messages_list[$i]['title']?>
          </td>

          <td class="nowrap">
            <?php if($messages_list[$i]['system']) { ?>
            <?=__('nobleme')?>
            <?php } else { ?>
            <span class="bold"><?=$messages_list[$i]['sender']?></span>
            <?php } ?>
          </td>

          <td class="nowrap">
            <?=$messages_list[$i]['sent']?>
          </td>

          <td class="nowrap">
            <?=$messages_list[$i]['read']?>
          </td>

        </tr>

        <?php } ?>

      </tbody>
    </table>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }