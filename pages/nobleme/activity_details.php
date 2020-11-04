<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';              # Core
include_once './../../actions/nobleme/activity.act.php';  # Actions
include_once './../../lang/nobleme.lang.php';             # Translations
include_once './../../inc/bbcodes.inc.php';               # BBCodes

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_moderators($lang);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Fetch log details
$log_details = activity_get(  form_fetch_element('log_id', 0) ,
                              $lang                           );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<td colspan="3" class="align_left indented padding_top">

  <?php if($log_details['reason']) { ?>

  <span class="indented bold underlined"><?=__('activity_details_reason')?></span> <?=$log_details['reason']?><br>
  <br>

  <?php } if($log_details['diff']) { ?>

  <span class="indented bold underlined"><?=__('activity_details_diff')?></span><br>
  <br>
  <?=$log_details['diff']?>
  <?php } ?>

</td>