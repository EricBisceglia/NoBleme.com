<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/nobleme.act.php'; # Actions
include_once './../../lang/nobleme.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators($lang);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Sanitize postdata
$log_id         = sanitize_input('POST', 'log_id', 'int', 0, 0);
$deletion_type  = sanitize_input('POST', 'deletion_type', 'int', 0, 0, 1);

// Delete the activity log
activity_delete_log($log_id, $deletion_type);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<td colspan="3" class="negative text_white bold">
  <?=__('activity_deleted')?>
</td>