<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED THROUGH XHR                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/nobleme.act.php'; # Actions
include_once './../../lang/nobleme.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
allow_only_xhr();

// Limit page access rights
user_restrict_to_administrators($lang);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Sanitize postdata
$log_id = sanitize_input('POST', 'log_id', 'int', 0, 0);

// Delete the activity log
activity_delete_log($log_id);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<td colspan="3" class="negative text_white bold">
  <?=__('activity_deleted')?>
</td>