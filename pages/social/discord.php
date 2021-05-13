<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../lang/integrations.lang.php';  # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/social/discord";
$page_title_en    = "Discord";
$page_title_fr    = "Discord";
$page_description = "NoBleme's official Discord server";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Privacy settings

// Fetch current Discord related privacy settings
$privacy_settings   = user_settings_privacy();
$discord_hide_embed = $privacy_settings['discord'];




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_social_platforms_discord')?>
  </h1>

  <h5>
    <?=__('discord_summary_title')?>
  </h5>

  <p>
    <?=__('discord_summary_body_1')?>
  </p>

  <ul class="tinypadding_top">
    <li>
      <?=__('discord_summary_list_1')?>
    </li>
    <li>
      <?=__('discord_summary_list_2')?>
    </li>
    <li>
      <?=__('discord_summary_list_3')?>
    </li>
    <li>
      <?=__('discord_summary_list_4')?>
    </li>
    <li>
      <?=__('discord_summary_list_5')?>
    </li>
  </ul>

  <p>
    <?=__('discord_summary_body_2')?>
  </p>

  <p>
    <?=__('discord_summary_body_3')?>
  </p>

  <p>
    <?=__('discord_summary_body_4')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('discord_join_title')?>
  </h5>

  <?php if($discord_hide_embed) { ?>

  <p class="tinypadding_bot">
    <?=__('discord_join_noembed')?>
  </p>

  <?php } else { ?>

  <p class="tinypadding_bot">
    <?=__('discord_join_embed')?>
  </p>

  <div class="padding_top">
    <iframe src="https://discord.com/widget?id=694151150902968320&theme=dark" class="indiv" height="400" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
  </div>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }