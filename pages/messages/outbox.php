<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # Text formatting
include_once './../../actions/messages.act.php';    # Actions
include_once './../../lang/messages.lang.php';      # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/messages/outbox";
$page_title_en    = "Message outbox";
$page_title_fr    = "Boite d'envoi";
$page_description = "Private message outbox - private messages sent by the user.";

// Extra JS
$js = array('common/editor', 'common/toggle', 'common/preview', 'messages/messages');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the years at which the user got private messages

$messages_years = private_message_years_list(true);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the private messages

// Fetch the search data
$outbox_search = array( 'title'     => form_fetch_element('outbox_search_title')      ,
                        'recipient' => form_fetch_element('outbox_search_recipient')  ,
                        'date'      => form_fetch_element('outbox_search_date')       ,
                        'read'      => form_fetch_element('outbox_search_read')       );

// Fetch the messages
$messages_list = private_message_list(  form_fetch_element('outbox_sort_order', 'sent') ,
                                        $outbox_search                                  ,
                                        sent_messages: true                             );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_user_pms_outbox')?>
  </h1>

  <p>
    <?=__('users_outbox_intro')?>
  </p>

  <div class="padding_top">
    <table>
      <thead>

        <tr class="uppercase">

          <th>
            <?=__('users_inbox_message')?>
            <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="users_outbox_search('title')">
          </th>

          <th>
            <?=__('users_outbox_recipient')?>
            <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="users_outbox_search('recipient')">
          </th>

          <th>
            <?=__('users_inbox_sent')?>
            <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="users_outbox_search('sent')">
            <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_up_small.svg" alt="^" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="users_outbox_search('rsent')">
          </th>

          <th>
            <?=__('users_inbox_read')?>
            <img class="smallicon pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="<?=string_change_case(__('sort'), 'initials')?>" onclick="users_outbox_search('read')">
          </th>

          <th>
            &nbsp;
          </th>

        </tr>

        <tr>

          <th>
            <input type="hidden" name="outbox_sort_order" id="outbox_sort_order" value="">
            <input type="text" class="table_search" name="outbox_search_title" id="outbox_search_title" value="" onkeyup="users_outbox_search();">
          </th>

          <th>
            <input type="text" class="table_search" name="outbox_search_recipient" id="outbox_search_recipient" value="" onkeyup="users_outbox_search();">
          </th>

          <th>
            <select class="table_search" name="outbox_search_date" id="outbox_search_date" onchange="users_outbox_search();">
              <option value="0">&nbsp;</option>
              <?php for($i = 0; $i < $messages_years['rows']; $i++) { ?>
              <option value="<?=$messages_years[$i]['year']?>"><?=$messages_years[$i]['year']?></option>
              <?php } ?>
            </select>
          </th>

          <th>
            <select class="table_search" name="outbox_search_read" id="outbox_search_read" onchange="users_outbox_search();">
              <option value="0">&nbsp;</option>
              <option value="-1"><?=__('users_inbox_unread')?></option>
              <option value="1"><?=__('users_inbox_read')?></option>
            </select>
          </th>

          <th>
            &nbsp;
          </th>

        </tr>

      </thead>
      <tbody class="altc" id="outbox_tbody">

        <?php } ?>

        <tr>
          <td class="uppercase text_white align_center dark bold" colspan="5">
            <?php if($messages_list['rows']) { ?>
            <?=__('users_outbox_count', $messages_list['rows'], 0, 0, array($messages_list['rows']))?>
            <?php } else { ?>
            <?=__('users_outbox_empty')?>
            <?php } ?>
          </td>
        </tr>

        <?php for($i = 0; $i < $messages_list['rows']; $i++) { ?>

        <tr class="align_center pointer" id="private_message_row_<?=$messages_list[$i]['id']?>">

          <td class="align_left tooltip_container" onclick="users_message_open('<?=$messages_list[$i]['id']?>', true);">
            <span class="<?=$messages_list[$i]['css']?>" id="private_message_title_<?=$messages_list[$i]['id']?>"><?=$messages_list[$i]['title']?></span>
            <div class="tooltip">
              <?=$messages_list[$i]['body']?>
            </div>
          </td>

          <?php if($messages_list[$i]['system']) { ?>
          <td class="nowrap tooltip_container" onclick="users_message_open('<?=$messages_list[$i]['id']?>', true);">
            <?=__('nobleme')?>
            <div class="tooltip">
              <?=__('users_outbox_system')?>
            </div>
          </td>
          <?php } else { ?>
          <td class="nowrap" onclick="users_message_open('<?=$messages_list[$i]['id']?>', true);">
            <?=__link('pages/users/'.$messages_list[$i]['recipient_id'], $messages_list[$i]['recipient'])?>
          </td>
          <?php } ?>

          <td class="nowrap tooltip_container" onclick="users_message_open('<?=$messages_list[$i]['id']?>', true);">
            <?=$messages_list[$i]['sent']?>
            <div class="tooltip">
              <?=$messages_list[$i]['fsent']?>
            </div>
          </td>

          <td class="nowrap tooltip_container" onclick="users_message_open('<?=$messages_list[$i]['id']?>', true);">
            <?=$messages_list[$i]['read']?>
            <div class="tooltip">
              <?php if($messages_list[$i]['fread']) { ?>
              <?=$messages_list[$i]['fread']?>
              <?php } else { ?>
              <?=__('users_outbox_not_read')?>
              <?php } ?>
            </div>
          </td>

          <td class="nowrap valign_middle align_center">
            <img class="smallicon valign_middle spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="<?=string_change_case(__('delete'), 'initials')?>" onclick="users_message_delete(<?=$messages_list[$i]['id']?>, '<?=__('users_message_confirm')?>');">
          </td>

        </tr>

        <?php } ?>

        <?php if(!page_is_fetched_dynamically()) { ?>

      </tbody>
    </table>
  </div>

</div>

<div id="popin_private_message" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('popin_private_message');">×</a>
    <div class="nopadding_top" id="popin_private_message_body"></div>
  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }