<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/integrations.act.php';  # Actions
include_once './../../lang/integrations.lang.php';    # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/social/irc";
$page_title_en    = "IRC chat";
$page_title_fr    = "Chat IRC";
$page_description = "NoBleme's primary communication method, our real time IRC chat server";

// Extra CSS & JS
$css  = array('irc');
$js   = array('social/irc', 'common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$irc_faq_selector_entries = array(  'main'      ,
                                    'why'       ,
                                    'browser'   ,
                                    'client'    ,
                                    'bouncer'   ,
                                    'guide'     ,
                                    'commands'  ,
                                    'nickserv'  ,
                                    'chanserv'  ,
                                    'bots'      ,
                                    'channels'  );

// Define the default dropdown menu entry
$irc_faq_selector_default = 'main';

// Initialize the page section selector data
$irc_faq_selector = page_section_selector(            $irc_faq_selector_entries  ,
                                            default:  $irc_faq_selector_default  );

// Prepare a suffix for the page titles
$irc_faq_page_name_suffix = ($GLOBALS['dev_mode']) ? ' | Devmode' : ' | NoBleme';

// Set the correct page title
$page_title_en  = (isset($_GET['why']))       ? "Why IRC?"                : $page_title_en;
$page_title_fr  = (isset($_GET['why']))       ? "Pourquoi IRC ?"          : $page_title_fr;
$page_title_en  = (isset($_GET['browser']))   ? "IRC web client"          : $page_title_en;
$page_title_fr  = (isset($_GET['browser']))   ? "Client web IRC"          : $page_title_fr;
$page_title_en  = (isset($_GET['client']))    ? "IRC client"              : $page_title_en;
$page_title_fr  = (isset($_GET['client']))    ? "Client IRC"              : $page_title_fr;
$page_title_en  = (isset($_GET['bouncer']))   ? "IRC bouncer"             : $page_title_en;
$page_title_fr  = (isset($_GET['bouncer']))   ? "Bouncer IRC"             : $page_title_fr;
$page_title_en  = (isset($_GET['guide']))     ? "Vocabulary and symbols"  : $page_title_en;
$page_title_fr  = (isset($_GET['guide']))     ? "Vocabulaire et symboles" : $page_title_fr;
$page_title_en  = (isset($_GET['commands']))  ? "IRC Commands"            : $page_title_en;
$page_title_fr  = (isset($_GET['commands']))  ? "Commandes IRC"           : $page_title_fr;
$page_title_en  = (isset($_GET['nickserv']))  ? "IRC NickServ"            : $page_title_en;
$page_title_fr  = (isset($_GET['nickserv']))  ? "IRC NickServ"            : $page_title_fr;
$page_title_en  = (isset($_GET['chanserv']))  ? "IRC ChanServ"            : $page_title_en;
$page_title_fr  = (isset($_GET['chanserv']))  ? "IRC ChanServ"            : $page_title_fr;
$page_title_en  = (isset($_GET['bots']))      ? "IRC bots"                : $page_title_en;
$page_title_fr  = (isset($_GET['bots']))      ? "Bots IRC"                : $page_title_fr;
$page_title_en  = (isset($_GET['channels']))  ? "IRC channels"            : $page_title_en;
$page_title_fr  = (isset($_GET['channels']))  ? "Canaux IRC"              : $page_title_fr;

// Determine the title to use in the header
$irc_faq_page_name = ($lang === 'EN') ? $page_title_en : $page_title_fr;

// Set the correct page URLs
$page_url = (isset($_GET['why']))       ? 'pages/social/irc?why'      : $page_url;
$page_url = (isset($_GET['browser']))   ? 'pages/social/irc?browser'  : $page_url;
$page_url = (isset($_GET['client']))    ? 'pages/social/irc?client'   : $page_url;
$page_url = (isset($_GET['bouncer']))   ? 'pages/social/irc?bouncer'  : $page_url;
$page_url = (isset($_GET['guide']))     ? 'pages/social/irc?guide'    : $page_url;
$page_url = (isset($_GET['commands']))  ? 'pages/social/irc?commands' : $page_url;
$page_url = (isset($_GET['nickserv']))  ? 'pages/social/irc?nickserv' : $page_url;
$page_url = (isset($_GET['chanserv']))  ? 'pages/social/irc?chanserv' : $page_url;
$page_url = (isset($_GET['bots']))      ? 'pages/social/irc?bots'     : $page_url;
$page_url = (isset($_GET['channels']))  ? 'pages/social/irc?channels' : $page_url;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Privacy settings

// Fetch current Kiwiirc related privacy settings
$privacy_settings   = user_settings_privacy();
$kiwiirc_hide_embed = $privacy_settings['kiwiirc'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// IRC channels list

$irc_channels = irc_channels_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 id="irc_faq_title">
    <?=$irc_faq_page_name?>
  </h1>

  <form method="POST">
    <fieldset>
      <h5 class="smallpadding_bot">
        <select class="inh align_left" id="irc_faq_selector" onchange="page_section_selector('irc_faq', '<?=$irc_faq_selector_default?>', true, true);">
          <option value="main"<?=$irc_faq_selector['menu']['main']?>><?=__('irc_faq_select_main')?></option>
          <option value="why"<?=$irc_faq_selector['menu']['why']?>><?=__('irc_faq_select_why')?></option>
          <option value="browser"<?=$irc_faq_selector['menu']['browser']?>><?=__('irc_faq_select_browser')?></option>
          <option value="client"<?=$irc_faq_selector['menu']['client']?>><?=__('irc_faq_select_client')?></option>
          <option value="bouncer"<?=$irc_faq_selector['menu']['bouncer']?>><?=__('irc_faq_select_bouncer')?></option>
          <option value="guide"<?=$irc_faq_selector['menu']['guide']?>><?=__('irc_faq_select_guide')?></option>
          <option value="commands"<?=$irc_faq_selector['menu']['commands']?>><?=__('irc_faq_select_commands')?></option>
          <option value="nickserv"<?=$irc_faq_selector['menu']['nickserv']?>><?=__('irc_faq_select_nickserv')?></option>
          <option value="chanserv"<?=$irc_faq_selector['menu']['chanserv']?>><?=__('irc_faq_select_chanserv')?></option>
          <option value="bots"<?=$irc_faq_selector['menu']['bots']?>><?=__('irc_faq_select_bots')?></option>
          <option value="channels"<?=$irc_faq_selector['menu']['channels']?>><?=__('irc_faq_select_channels')?></option>
        </select>
      </h5>
    </fieldset>
  </form>

  <input type="hidden" id="irc_faq_name_suffix" value="<?=$irc_faq_page_name_suffix?>">
  <input type="hidden" id="irc_faq_name_main" value="<?=__('irc_faq_title')?>">
  <input type="hidden" id="irc_faq_name_why" value="<?=__('irc_faq_title_why')?>">
  <input type="hidden" id="irc_faq_name_browser" value="<?=__('irc_faq_title_browser')?>">
  <input type="hidden" id="irc_faq_name_client" value="<?=__('irc_faq_title_client')?>">
  <input type="hidden" id="irc_faq_name_bouncer" value="<?=__('irc_faq_title_bouncer')?>">
  <input type="hidden" id="irc_faq_name_guide" value="<?=__('irc_faq_title_guide')?>">
  <input type="hidden" id="irc_faq_name_commands" value="<?=__('irc_faq_title_commands')?>">
  <input type="hidden" id="irc_faq_name_nickserv" value="<?=__('irc_faq_title_nickserv')?>">
  <input type="hidden" id="irc_faq_name_chanserv" value="<?=__('irc_faq_title_chanserv')?>">
  <input type="hidden" id="irc_faq_name_bots" value="<?=__('irc_faq_title_bots')?>">
  <input type="hidden" id="irc_faq_name_channels" value="<?=__('irc_faq_title_channels')?>">

</div>




<?php /************************************************ MAIN ****************************************************/ ?>

<div class="width_50 irc_faq_section<?=$irc_faq_selector['hide']['main']?>" id="irc_faq_main">

  <p>
    <?=__('irc_faq_main_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_main_what_title')?>
  </h5>

  <p>
    <?=__('irc_faq_main_what_1')?>
  </p>

  <p>
    <?=__('irc_faq_main_what_2')?>
  </p>

  <div class="flexcontainer padding_top">

    <div class="flex align_right bold spaced_right monospace">
      <?=__('irc_faq_main_what_server')?><br>
      <?=__('irc_faq_main_what_port')?><br>
      <?=__('irc_faq_main_what_channel')?><br>
      <?=__('irc_faq_main_what_encoding')?>
    </div>

    <div class="spaced_left monospace" style="flex:5">
      <?=__('irc_faq_main_what_url')?><br>
      <?=__('irc_faq_main_what_ports')?><br>
      <?=__('irc_faq_main_what_hub')?><br>
      <?=__('irc_faq_main_what_utf')?>
    </div>

  </div>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_main_join_title')?>
  </h5>

  <p>
    <?=__('irc_faq_main_join_1')?>
  </p>

  <p>
    <?=__('irc_faq_main_join_2')?>
  </p>

  <p>
    <?=__('irc_faq_main_join_3')?>
  </p>

  <p>
    <?=__('irc_faq_main_join_4')?>
  </p>

  <h5 id="faq" class="bigpadding_top">
    <?=__('irc_faq_questions_title')?>
  </h5>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_1')?></span><br>
    <?=__('irc_faq_answer_1')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_2')?></span><br>
    <?=__('irc_faq_answer_2')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_3')?></span><br>
    <?=__('irc_faq_answer_3')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_4')?></span><br>
    <?=__('irc_faq_answer_4')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_5')?></span><br>
    <?=__('irc_faq_answer_5')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_6')?></span><br>
    <?=__('irc_faq_answer_6')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_7')?></span><br>
    <?=__('irc_faq_answer_7')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_8')?></span><br>
    <?=__('irc_faq_answer_8')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_9')?></span><br>
    <?=__('irc_faq_answer_9')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_10')?></span><br>
    <?=__('irc_faq_answer_10')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_question_11')?></span><br>
    <?=__('irc_faq_answer_11')?>
  </p>

</div>




<?php /************************************************ WHY IRC ***************************************************/ ?>

<div class="width_50 irc_faq_section<?=$irc_faq_selector['hide']['why']?>" id="irc_faq_why">

  <p>
    <?=__('irc_faq_why_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_why_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_why_freedom_title')?>
  </h5>

  <p>
    <?=__('irc_faq_why_freedom_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_why_freedom_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_why_flex_title')?>
  </h5>

  <p>
    <?=__('irc_faq_why_flex_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_why_flex_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_why_simple_title')?>
  </h5>

  <p>
    <?=__('irc_faq_why_simple_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_why_simple_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_why_habit_title')?>
  </h5>

  <p>
    <?=__('irc_faq_why_habit_body_1')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_why_others_title')?>
  </h5>

  <p>
    <?=__('irc_faq_why_others_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_why_others_body_2')?>
  </p>

  <?=__('irc_faq_why_others_list')?>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_why_summary_title')?>
  </h5>

  <p>
    <?=__('irc_faq_why_summary_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_why_summary_body_2')?>
  </p>

</div>




<?php /************************************************ BROWSER ***************************************************/ ?>

<?php if($kiwiirc_hide_embed) { ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['browser']?>" id="irc_faq_browser">

  <p>
    <?=__('irc_faq_browser_body')?>
  </p>

</div>

<?php } else { ?>

<div class="width_70 padding_top irc_faq_section<?=$irc_faq_selector['hide']['browser']?>" id="irc_faq_browser">

  <?php if($lang === 'EN') { ?>
  <iframe src="https://kiwiirc.com/nextclient/?settings=d88c482df59c1ae0cca6627751a32973" class="indiv irc_client_iframe"></iframe>
  <?php } else { ?>
  <iframe src="https://kiwiirc.com/nextclient/?settings=5f080fa3340afd85b53f47188d628b10" class="indiv irc_client_iframe"></iframe>
  <?php } ?>

</div>

<?php } ?>




<?php /************************************************* CLIENT ***************************************************/ ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['client']?>" id="irc_faq_client">

  <p>
    <?=__('irc_faq_client_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_client_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_client_body_3')?>
  </p>

  <div class="flexcontainer padding_top">

    <div class="flex align_right bold spaced_right monospace">
      <?=__('irc_faq_main_what_server')?><br>
      <?=__('irc_faq_main_what_port')?><br>
      <?=__('irc_faq_main_what_channel')?><br>
      <?=__('irc_faq_main_what_encoding')?>
    </div>

    <div class="spaced_left monospace" style="flex:5">
      <?=__('irc_faq_main_what_url')?><br>
      <?=__('irc_faq_main_what_ports')?><br>
      <?=__('irc_faq_main_what_hub')?><br>
      <?=__('irc_faq_main_what_utf')?>
    </div>

  </div>

  <p>
    <?=__('irc_faq_client_body_4')?>
  </p>

  <p>
    <?=__('irc_faq_client_body_5')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_client_web_title')?>
  </h5>

  <p>
    <?=__('irc_faq_client_web_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_client_web_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_client_web_body_3')?>
  </p>

  <p>
    <?=__('irc_faq_client_web_body_4')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_client_computer_title')?>
  </h5>

  <p>
    <?=__('irc_faq_client_computer_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_client_computer_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_client_computer_body_3')?>
  </p>

  <p>
    <?=__('irc_faq_client_computer_body_4')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_client_mobile_title')?>
  </h5>

  <p>
    <?=__('irc_faq_client_mobile_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_client_mobile_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_client_mobile_body_3')?>
  </p>

  <p>
    <?=__('irc_faq_client_mobile_body_4')?>
  </p>

</div>




<?php /************************************************ BOUNCER ***************************************************/ ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['bouncer']?>" id="irc_faq_bouncer">

  <p>
    <?=__('irc_faq_bouncer_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_bouncer_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_bouncer_body_3')?>
  </p>

  <p>
    <?=__('irc_faq_bouncer_body_4')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_bouncer_third_title')?>
  </h5>

  <p>
    <?=__('irc_faq_bouncer_third_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_bouncer_third_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_bouncer_third_body_3')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_bouncer_tech_title')?>
  </h5>

  <p>
    <?=__('irc_faq_bouncer_tech_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_bouncer_tech_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_bouncer_tech_body_3')?>
  </p>

</div>




<?php /****************************************** VOCABULARY & SYMBOLS ********************************************/ ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['guide']?>" id="irc_faq_guide">

  <h5 id="server"><?=__('irc_faq_vocabulary_title_1')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_1')?>
  </p>

  <h5 id="client"><?=__('irc_faq_vocabulary_title_2')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_2')?>
  </p>

  <h5 id="bouncer"><?=__('irc_faq_vocabulary_title_3')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_3')?>
  </p>

  <h5 id="channel"><?=__('irc_channels_name')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_4')?>
  </p>

  <h5 id="operator"><?=__('irc_faq_symbols_operator')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_5')?>
  </p>

  <h5 id="kick"><?=__('irc_faq_vocabulary_title_6')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_6')?>
  </p>

  <h5 id="services"><?=__('irc_faq_vocabulary_title_7')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_7')?>
  </p>

  <h5 id="command"><?=__('irc_faq_vocabulary_title_8')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_8')?>
  </p>

  <h5 id="mode"><?=__('irc_faq_symbols_mode')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_9')?>
  </p>

  <h5 id="highlight"><?=__('irc_faq_vocabulary_title_10')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_10')?>
  </p>

  <h5 id="lurk"><?=__('irc_faq_vocabulary_title_11')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_11')?>
  </p>

  <h5 id="bot"><?=__('irc_faq_vocabulary_title_12')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_vocabulary_body_12')?>
  </p>

  <h5 id="symbols" class="bigpadding_top">
    <?=__('irc_faq_symbols_title')?>
  </h5>

  <p>
    <?=__('irc_faq_symbols_body_1')?>
  </p>

  <p class="bigpadding_bot">
    <?=__('irc_faq_symbols_body_2')?>
  </p>

  <table>
    <thead>

      <tr class="bold uppercase spaced noflow">
        <th>
          <?=__('title')?>
        </th>
        <th>
          <?=__('irc_faq_symbols_symbol')?>
        </th>
        <th>
          <?=__('irc_faq_symbols_mode')?>
        </th>
        <th>
          <?=__('irc_faq_symbols_abilities')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_center bold noflow">
          <?=__('irc_faq_symbols_user')?>
        </td>
        <td class="align_center bold noflow">
          &nbsp;
        </td>
        <td class="align_center bold noflow">
          &nbsp;
        </td>
        <td>
          <?=__('irc_faq_symbols_user_desc')?>
        </td>
      </tr>

      <tr>
        <td class="align_center bold noflow">
          <?=__('irc_faq_symbols_voice')?>
        </td>
        <td class="align_center bold noflow">
          +
        </td>
        <td class="align_center bold noflow">
          +v
        </td>
        <td>
          <?=__('irc_faq_symbols_voice_desc')?>
        </td>
      </tr>

      <tr>
        <td class="align_center bold noflow">
          <?=__('irc_faq_symbols_halfop')?>
        </td>
        <td class="align_center bold noflow">
          %
        </td>
        <td class="align_center bold noflow">
          +h
        </td>
        <td>
          <?=__('irc_faq_symbols_halfop_desc')?>
        </td>
      </tr>

      <tr>
        <td class="align_center bold noflow">
          <?=__('irc_faq_symbols_operator')?>
        </td>
        <td class="align_center bold noflow">
          @
        </td>
        <td class="align_center bold noflow">
          +o
        </td>
        <td>
          <?=__('irc_faq_symbols_operator_desc')?>
        </td>
      </tr>

      <tr>
        <td class="align_center bold noflow">
          <?=string_change_case(__('admin'), 'initials')?>
        </td>
        <td class="align_center bold noflow">
          &
        </td>
        <td class="align_center bold noflow">
          +a
        </td>
        <td>
          <?=__('irc_faq_symbols_admin_desc')?>
        </td>
      </tr>

      <tr>
        <td class="align_center bold noflow">
          <?=__('irc_faq_symbols_founder')?>
        </td>
        <td class="align_center bold noflow">
          ~
        </td>
        <td class="align_center bold noflow">
          +q
        </td>
        <td>
          <?=__('irc_faq_symbols_founder_desc')?>
        </td>
      </tr>

    </tbody>
  </table>

</div>




<?php /************************************************ COMMANDS **************************************************/ ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['commands']?>" id="irc_faq_commands">

  <p>
    <?=__('irc_faq_commands_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_commands_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_commands_body_3')?>
  </p>

  <h5 class="bigpadding_top" id="clear">/clear</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_clear')?>
  </p>

  <h5 id="quit">/quit</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_quit')?>
  </p>

  <h5 id="server_command">/server <?=__('irc_faq_commands_server')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_connect')?>
  </p>

  <h5 id="list">/list</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_list')?>
  </p>

  <h5 id="join">/join #<?=__('irc_faq_commands_channel')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_join')?>
  </p>

  <h5 id="names">/names #<?=__('irc_faq_commands_channel')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_names')?>
  </p>

  <h5 id="part">/part #<?=__('irc_faq_commands_channel')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_part')?>
  </p>

  <h5 id="nick">/nick <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_nick')?>
  </p>

  <h5 id="whois">/whois <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_whois')?>
  </p>

  <h5 id="whowas">/whowas <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_whowas')?>
  </p>

  <h5 id="msg">/msg <?=__('irc_faq_commands_username')?> <?=__('irc_faq_commands_message')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_msg')?>
  </p>

  <h5 id="ignore">/ignore <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_ignore')?>
  </p>

  <h5 id="unignore">/unignore <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_unignore')?>
  </p>

</div>




<?php /************************************************ NICKSERV **************************************************/ ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['nickserv']?>" id="irc_faq_nickserv">

  <p>
    <?=__('irc_faq_nickserv_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_nickserv_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_nickserv_body_3')?>
  </p>

  <h5 class="bigpadding_top" id="nickserv">/nick <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_commands_nick')?>
  </p>

  <h5 id="register">/msg NickServ register <?=__('irc_faq_commands_password')?> <?=__('irc_faq_commands_email')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_nickserv_register')?>
  </p>

  <h5 id="identify">/msg NickServ identify <?=__('irc_faq_commands_password')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_nickserv_identify')?>
  </p>

  <h5 id="password">/msg NickServ password <?=__('irc_faq_commands_password')?> <?=__('irc_faq_commands_newpass')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_nickserv_password')?>
  </p>

  <h5 id="recover">/msg NickServ recover <?=__('irc_faq_commands_username')?> <?=__('irc_faq_commands_password')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_nickserv_recover')?>
  </p>

  <h5 id="ghost">/msg NickServ ghost <?=__('irc_faq_commands_username')?> <?=__('irc_faq_commands_password')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_nickserv_ghost')?>
  </p>

  <h5 id="drop">/msg NickServ drop <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_nickserv_drop')?>
  </p>

</div>




<?php /************************************************ CHANSERV **************************************************/ ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['chanserv']?>" id="irc_faq_chanserv">

  <p>
    <?=__('irc_faq_chanserv_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_body_3')?>
  </p>

  <h3 id="hostmasks" class="bigpadding_top">
    <?=__('irc_faq_chanserv_hostmasks_title')?>
  </h3>

  <p>
    <?=__('irc_faq_chanserv_hostmasks_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_hostmasks_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_hostmasks_body_3')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_chanserv_hostmasks_ex_1')?></span><br>
    <?=__('irc_faq_chanserv_hostmasks_body_4')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_chanserv_hostmasks_ex_2')?></span><br>
    <?=__('irc_faq_chanserv_hostmasks_body_5')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_chanserv_hostmasks_ex_3')?></span><br>
    <?=__('irc_faq_chanserv_hostmasks_body_6')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_chanserv_hostmasks_ex_4')?></span><br>
    <?=__('irc_faq_chanserv_hostmasks_body_7')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_chanserv_hostmasks_ex_5')?></span><br>
    <?=__('irc_faq_chanserv_hostmasks_body_8')?>
  </p>

  <p>
    <span class="text_red bold indented"><?=__('irc_faq_chanserv_hostmasks_ex_6')?></span><br>
    <?=__('irc_faq_chanserv_hostmasks_body_9')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_hostmasks_body_10')?>
  </p>

  <h3 id="abilities" class="hugepadding_top">
    <?=__('irc_faq_chanserv_optools_title')?>
  </h3>

  <p>
    <?=__('irc_faq_chanserv_optools_body')?>
  </p>

  <h5 class="padding_top" id="topic">/msg ChanServ topic #<?=__('irc_faq_commands_channel')?> <?=__('irc_faq_commands_text')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_topic')?>
  </p>

  <h5 id="chanserv_kick">/msg ChanServ kick #<?=__('irc_faq_commands_channel')?> <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_kick')?>
  </p>

  <h5 id="ban">/msg ChanServ mode #<?=__('irc_faq_commands_channel')?> set +b <?=__('irc_faq_commands_hostmask')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_ban')?>
  </p>

  <h5 id="banlist">/msg ChanServ mode #<?=__('irc_faq_commands_channel')?> b</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_banlist')?>
  </p>

  <h5 id="unban">/msg ChanServ mode #<?=__('irc_faq_commands_channel')?> set -b <?=__('irc_faq_commands_hostmask')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_unban')?>
  </p>

  <h5 id="mute">/msg ChanServ mode #<?=__('irc_faq_commands_channel')?> set +m</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mute')?>
  </p>

  <h5 id="voice">/msg ChanServ mode #<?=__('irc_faq_commands_channel')?> set +v <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_voice')?>
  </p>

  <h5 id="unmute">/msg ChanServ mode #<?=__('irc_faq_commands_channel')?> set -m</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_unmute')?>
  </p>

  <h3 id="management" class="hugepadding_top">
    <?=__('irc_faq_chanserv_manage_title')?>
  </h3>

  <p>
    <?=__('irc_faq_chanserv_manage_body')?>
  </p>

  <h5 class="padding_top" id="register_channel">/msg ChanServ register #<?=__('irc_faq_commands_channel')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_register')?>
  </p>

  <h5 id="founder">/msg ChanServ set founder #<?=__('irc_faq_commands_channel')?> <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_founder')?>
  </p>

  <h5 id="autovoice">/msg ChanServ vop #<?=__('irc_faq_commands_channel')?> add <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_voiceop')?>
  </p>

  <h5 id="autohalfop">/msg ChanServ hop #<?=__('irc_faq_commands_channel')?> add <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_halfop')?>
  </p>

  <h5 id="autoop">/msg ChanServ aop #<?=__('irc_faq_commands_channel')?> add <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_op')?>
  </p>

  <h5 id="autoadmin">/msg ChanServ sop #<?=__('irc_faq_commands_channel')?> add <?=__('irc_faq_commands_username')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_admin')?>
  </p>

  <h3 id="modes" class="hugepadding_top">
    <?=__('irc_faq_chanserv_modes_title')?>
  </h3>

  <p>
    <?=__('irc_faq_chanserv_modes_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_modes_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_modes_body_3')?>
  </p>

  <p>
    <?=__('irc_faq_chanserv_modes_body_4')?>
  </p>

  <h5 class="monospace bold padding_top">+i</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_i')?>
  </p>

  <h5 class="monospace bold">+I <?=__('irc_faq_commands_hostmask')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_i_caps')?>
  </p>

  <h5 class="monospace bold">+k <?=__('irc_faq_commands_password')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_k')?>
  </p>

  <h5 class="monospace bold">+l <?=__('irc_faq_commands_number')?></h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_l')?>
  </p>

  <h5 class="monospace bold">+m</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_m')?>
  </p>

  <h5 class="monospace bold">+M</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_m_caps')?>
  </p>

  <h5 class="monospace bold">+n</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_n')?>
  </p>

  <h5 class="monospace bold">+R</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_r_caps')?>
  </p>

  <h5 class="monospace bold">+s</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_s')?>
  </p>

  <h5 class="monospace bold">+t</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_t')?>
  </p>

  <h5 class="monospace bold">+u</h5>
  <p class="tinypadding_top padding_bot">
    <?=__('irc_faq_chanserv_mode_u')?>
  </p>

</div>




<?php /************************************************** BOTS ****************************************************/ ?>

<div class="width_50 padding_top irc_faq_section<?=$irc_faq_selector['hide']['bots']?>" id="irc_faq_bots">

  <p>
    <?=__('irc_faq_bots_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_bots_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_bots_body_3')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_bots_nobleme_title')?>
  </h5>

  <p>
    <?=__('irc_faq_bots_nobleme_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_bots_nobleme_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_bots_private_title')?>
  </h5>

  <p>
    <?=__('irc_faq_bots_private_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_bots_private_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('irc_faq_bots_custom_title')?>
  </h5>

  <p>
    <?=__('irc_faq_bots_custom_body_1')?>
  </p>

  <p>
    <?=__('irc_faq_bots_custom_body_2')?>
  </p>

  <p>
    <?=__('irc_faq_bots_custom_body_3')?>
  </p>

</div>




<?php /************************************************ CHANNELS **************************************************/ ?>

<div class="width_60 padding_top irc_faq_section<?=$irc_faq_selector['hide']['channels']?>" id="irc_faq_channels">

  <p>
    <?=__('irc_channels_header_1')?>
  </p>

  <p>
    <?=__('irc_channels_header_2')?>
  </p>

  <p class="bigpadding_bot">
    <?=__('irc_channels_header_3')?>
  </p>

  <div class="autoscroll">
    <table>
      <thead class="uppercase">

        <?php if($is_moderator) { ?>
        <tr >
        <?php } else { ?>
        <tr class="row_separator_dark_thin">
        <?php } ?>
          <th>
            <?=__('irc_channels_name')?>
          </th>
          <th>
            <?=__('type')?>
          </th>
          <th>
            <?=__('language')?>
          </th>
          <th>
            <?=__('description')?>
          </th>
          <?php if($is_moderator) { ?>
          <th>
            <?=__('act')?>
          </th>
          <?php } ?>
        </tr>

      </thead>
      <?php if($is_moderator) { ?>
      <tbody class="altc2">
      <?php } else { ?>
      <tbody class="altc">
      <?php } ?>

        <?php if($is_moderator) { ?>
        <tr>
          <td colspan="5" class="align_center uppercase dark text_white bold">
            <?=__link('pages/social/irc_channel_add', __('irc_channels_add'), "bold text_white glow")?>
          </td>
        </tr>
        <?php } ?>

        <?php for($i = 0; $i < $irc_channels['rows']; $i++) { ?>

        <?php if($i < ($irc_channels['rows'] - 1) && $irc_channels[$i]['type'] !== $irc_channels[$i + 1]['type']) { ?>

        <tr class="row_separator_dark_thin" id="irc_channel_list_row_<?=$irc_channels[$i]['id']?>">

        <?php } else { ?>

        <tr id="irc_channel_list_row_<?=$irc_channels[$i]['id']?>">

        <?php } ?>

          <td class="align_center spaced nowrap bold">
            <?=$irc_channels[$i]['name']?>
          </td>

          <td class="align_center spaced nowrap<?=$irc_channels[$i]['type_css']?>">
            <?=$irc_channels[$i]['type']?>
          </td>

          <td class="align_center spaced nowrap">
            <?php if($irc_channels[$i]['lang_en']) { ?>
            <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle smallicon" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
            <?php } if($irc_channels[$i]['lang_fr']) { ?>
            <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle smallicon" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
            <?php } ?>
          </td>

          <td>
            <?=$irc_channels[$i]['desc']?>
          </td>

          <?php if($is_moderator) { ?>
          <td class="align_center spaced nowrap">
            <?=__link('pages/social/irc_channel_edit?id='.$irc_channels[$i]['id'], __icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials'), 'noglow')?>
            <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "irc_channel_list_delete(".$irc_channels[$i]['id'].", '".__('irc_channels_delete_confirm')."');")?>
          </td>
          <?php } ?>

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