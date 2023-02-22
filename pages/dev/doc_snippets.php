<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/dev.lang.php';     # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang      = array('FR', 'EN');
$page_url       = "pages/dev/doc_snippets";
$page_title_en  = "Code snippets";
$page_title_fr  = "Modèles de code";

// Extra CSS & JS
$css  = array('dev');
$js   = array('common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$snippets_selector_entries = array( 'full'          ,
                                    'fetched'       ,
                                    'blocks'        ,
                                    'action'        ,
                                    'act_elements'  );

// Define the default dropdown menu entry
$snippets_selector_default = 'full';

// Initialize the page section selector data
$snippets_selector = page_section_selector(           $snippets_selector_entries  ,
                                            default:  $snippets_selector_default  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>
      <?=__('dev_snippets_title')?>
      <select class="inh" id="dev_snippets_selector" onchange="page_section_selector('dev_snippets', '<?=$snippets_selector_default?>');">
        <option value="full"<?=$snippets_selector['menu']['full']?>><?=__('dev_snippets_selector_full')?></option>
        <option value="fetched"<?=$snippets_selector['menu']['fetched']?>><?=__('dev_snippets_selector_fetched')?></option>
        <option value="blocks"<?=$snippets_selector['menu']['blocks']?>><?=__('dev_snippets_selector_blocks')?></option>
        <option value="action"<?=$snippets_selector['menu']['action']?>><?=__('dev_snippets_selector_action')?></option>
        <option value="act_elements"<?=$snippets_selector['menu']['act_elements']?>><?=__('dev_snippets_selector_act_elements')?></option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************** FULL ****************************************************/ ?>

<div class="width_60 padding_top dev_snippets_section<?=$snippets_selector['hide']['full']?>" id="dev_snippets_full">

  <pre class="small" id="dev_snippets_full_standard" onclick="to_clipboard('', 'dev_snippets_full_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Limit page access rights
user_restrict_to_guests();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/index";
$page_title_en    = "Title";
$page_title_fr    = "Titre";
$page_description = "Metadescription";

// Extra CSS & JS
$css  = array('');
$js   = array('');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

&lt;div class="width_50">

  &lt;h1>
    &lt;?=__('nobleme')?>
  &lt;/h1>

  &lt;h5>
    &lt;?=__('nobleme')?>
  &lt;/h5>

  &lt;p>
    &lt;?=__('nobleme')?>
  &lt;/p>

&lt;/div>

&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }</pre>

</div>




<?php /************************************************ FETCHED ***************************************************/ ?>

<div class="width_60 padding_top dev_snippets_section<?=$snippets_selector['hide']['fetched']?>" id="dev_snippets_fetched">

  <pre class="small" id="dev_snippets_fetched_standard" onclick="to_clipboard('', 'dev_snippets_fetched_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_guests();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

&lt;?=__('nobleme')?></pre>

</div>




<?php /************************************************* BLOCKS ***************************************************/ ?>

<div class="width_60 padding_top dev_snippets_section<?=$snippets_selector['hide']['blocks']?>" id="dev_snippets_blocks">

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_comments" onclick="to_clipboard('', 'dev_snippets_blocks_comments', 1);">///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_back" onclick="to_clipboard('', 'dev_snippets_blocks_back', 1);">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_front" onclick="to_clipboard('', 'dev_snippets_blocks_front', 1);">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?></pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_front_fetch" onclick="to_clipboard('', 'dev_snippets_blocks_front_fetch', 1);">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?></pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_footer" onclick="to_clipboard('', 'dev_snippets_blocks_footer', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_footer_fetch" onclick="to_clipboard('', 'dev_snippets_blocks_footer_fetch', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }</pre>
  </div>

</div>




<?php /************************************************* ACTIONS **************************************************/ ?>

<div class="width_60 padding_top dev_snippets_section<?=$snippets_selector['hide']['action']?>" id="dev_snippets_action">

  <pre class="small" id="dev_snippets_action_template" onclick="to_clipboard('', 'dev_snippets_action_template', 1);">/**
 * Description.
 *
 * @param   string                  $variable_name    Description.
 * @param   int         (OPTIONAL)  $other_variable   Description.
 *
 * @return  string|null                               Description.
 */

function users_authenticate(  int     $variable_name          ,
                              ?string $other_variable = null  ) : mixed
{
  // Check if the required files have been included
  require_included_file('includefile.inc.php');
  require_included_file('langfile.lang.php');

  // Require users to be logged in to run this action
  user_restrict_to_users();

  // Check for flood
  flood_check();

  // Log the activity
  log_activity( 'activity_name'               ,
                activity_id:  $variable_name  );

  // Moderation log
  $modlog = log_activity( 'activity_name'                     ,
                          is_moderators_only: true            ,
                          activity_id:        $variable_name  );

  // Detailed activity logs
  log_activity_details($modlog, 'English', 'Français', $variable_name, $variable_name);

  // IRC bot message
  irc_bot_send_message("Description: ".$variable_name." - ".$GLOBALS['website_url']."pages/page/".$variable_name, 'english');

  // Discord message
  $discord_message  = "English";
  $discord_message .= PHP_EOL."Français";
  $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/page/".$variable_name.">";
  discord_send_message($discord_message, 'main');

  // Private message
  $admin_id = sanitize(user_get_id(), 'int', 0);
  private_message_send( 'Description'             ,
                        'Body'                    ,
                        recipient: $variable_name ,
                        sender: 0                 ,
                        true_sender: $admin_id    ,
                        hide_admin_mail: true     );

  // Admin mail
  private_message_send( 'Description'       ,
                        'Body'              ,
                        recipient: 0        ,
                        sender: 0           ,
                        is_admin_only: true );
}</pre>

</div>




<?php /********************************************* ACTION ELEMENTS **********************************************/ ?>

<div class="width_60 padding_top dev_snippets_section<?=$snippets_selector['hide']['act_elements']?>" id="dev_snippets_act_elements">

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_require" onclick="to_clipboard('', 'dev_snippets_action_require', 1);">// Check if the required files have been included
  require_included_file('includefile.inc.php');
  require_included_file('langfile.lang.php');</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_rights" onclick="to_clipboard('', 'dev_snippets_action_rights', 1);">// Require users to be logged in to run this action
  user_restrict_to_users();</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_admin" onclick="to_clipboard('', 'dev_snippets_action_admin', 1);">// Require administrator rights to run this action
  user_restrict_to_administrators();</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_flood" onclick="to_clipboard('', 'dev_snippets_action_flood', 1);">// Check for flood
  flood_check();</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_activity" onclick="to_clipboard('', 'dev_snippets_action_activity', 1);">// Log the activity
  log_activity( 'activity_name'               ,
                activity_id:  $variable_name  );

  // Moderation log
  $modlog = log_activity( 'activity_name'                     ,
                          is_moderators_only: true            ,
                          activity_id:        $variable_name  );

  // Detailed activity logs
  log_activity_details($modlog, 'English', 'Français', $variable_name, $variable_name);</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_irc" onclick="to_clipboard('', 'dev_snippets_action_irc', 1);">// IRC bot message
  irc_bot_send_message("Description: ".$variable_name." - ".$GLOBALS['website_url']."pages/page/".$variable_name, 'english');</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_discord" onclick="to_clipboard('', 'dev_snippets_action_discord', 1);">// Discord message
  $discord_message  = "English";
  $discord_message .= PHP_EOL."Français";
  $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/page/".$variable_name.">";
  discord_send_message($discord_message, 'main');</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_private_message" onclick="to_clipboard('', 'dev_snippets_action_private_message', 1);">// Private message
  $admin_id = sanitize(user_get_id(), 'int', 0);
  private_message_send( 'Description'             ,
                        'Body'                    ,
                        recipient: $variable_name ,
                        sender: 0                 ,
                        true_sender: $admin_id    ,
                        hide_admin_mail: true     );</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_action_admin_mail" onclick="to_clipboard('', 'dev_snippets_action_admin_mail', 1);">// Admin mail
  private_message_send( 'Description'       ,
                        'Body'              ,
                        recipient: 0        ,
                        sender: 0           ,
                        is_admin_only: true );</pre>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }