<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED THROUGH XHR                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/nobleme.act.php'; # Actions
include_once './../../lang/nobleme.lang.php';   # Translations
include_once './../../inc/bbcodes.inc.php';     # BBCodes

// Throw a 404 if the page is being accessed directly
allow_only_xhr();

// Limit page access rights
user_restrict_to_global_moderators($lang);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Sanitize postdata
$log_id = sanitize_input('POST', 'log_id', 'int', 0, 0);

// Fetch log details
$log_details = activity_get_details($log_id);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<td colspan="3" class="align_left spaced padding_top">

  <?php if($log_details['reason']) { ?>

  <span class="indented bold underlined"><?=__('activity_details_reason')?></span> <?=$log_details['reason']?><br>
  <br>

  <?php } if($log_details['diff']) { ?>

  <span class="indented bold underlined"><?=__('activity_details_diff')?></span><br>
  <br>
  <?=$log_details['diff']?>
  <?php } ?>

</td>