<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';      # Core
include_once './../../actions/messages.act.php';  # Actions
include_once './../../lang/messages.lang.php';    # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_users();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send the private message reply

$reply_error =  private_messages_reply( form_fetch_element('private_message_id', 0) ,
                                        form_fetch_element('private_message_body')  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if($reply_error) { ?>
<h5 class="red text_white bold uppercase align_center">
  <?=__('error').__(':', spaces_after: 1).$reply_error?>
</h5>
<?php } else { ?>
<h5 class="green text_white bold uppercase align_center">
  <?=__('users_message_sent')?>
</h5>
<?php } ?>