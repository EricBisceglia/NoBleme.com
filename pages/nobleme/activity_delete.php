<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../actions/nobleme/activity.act.php';  # Actions
include_once './../../lang/nobleme.lang.php';             # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators($lang);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Delete the activity log
activity_delete_log(  form_fetch_element('log_id', 0)         ,
                      form_fetch_element('deletion_type', 0)  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<td colspan="3" class="red bold">
  <?=__('activity_deleted')?>
</td>