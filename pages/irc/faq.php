<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/irc.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/irc/faq";
$page_title_en    = "IRC chat";
$page_title_fr    = "Chat IRC";
$page_description = "NoBleme's primary communication method, our real time IRC chat server";




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

<div class="width_50">

  <h1>
    <?=__('irc_faq_title')?>
  </h1>

  <form method="POST">
    <fieldset>
      <h5 class="smallpadding_bot">
        <select class="inh align_left">
          <option value="main"><?=__('irc_faq_select_main')?></option>
          <option value="why"><?=__('irc_faq_select_why')?></option>
          <option value="browser"><?=__('irc_faq_select_browser')?></option>
          <option value="client"><?=__('irc_faq_select_client')?></option>
          <option value="bouncer"><?=__('irc_faq_select_bouncer')?></option>
          <option value="guide"><?=__('irc_faq_select_guide')?></option>
          <option value="commands"><?=__('irc_faq_select_commands')?></option>
          <option value="nickserv"><?=__('irc_faq_select_nickserv')?></option>
          <option value="chanserv"><?=__('irc_faq_select_chanserv')?></option>
          <option value="bots"><?=__('irc_faq_select_bots')?></option>
          <option value="channels"><?=__('irc_faq_select_channels')?></option>
          <option value="others"><?=__('irc_faq_select_others')?></option>
        </select>
      </h5>
    </fieldset>
  </form>

  <div class="irc_faq_section irc_faq_main">

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

    <h5 class="bigpadding_top">
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

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }