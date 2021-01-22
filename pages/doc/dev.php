<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/doc.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/doc/dev";
$page_title_en    = "Behind the scenes";
$page_title_fr    = "Coulisses";
$page_description = "A deep dive into the gritty guts of NoBleme's source code and design choices";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_behind_scenes')?>
  </h1>

  <h5>
    <?=__('doc_bts_subtitle')?>
  </h5>

  <p>
    <?=__('doc_bts_intro')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('doc_bts_creed_title')?>
  </h5>

  <p>
    <?=__('doc_bts_creed_intro')?>
  </p>

  <p>
    <?=__('doc_bts_creed_1')?>
  </p>

  <p>
    <?=__('doc_bts_creed_2')?>
  </p>

  <p>
    <?=__('doc_bts_creed_3')?>
  </p>

  <p>
    <?=__('doc_bts_creed_4')?>
  </p>

  <p>
    <?=__('doc_bts_creed_5')?>
  </p>

  <p>
    <?=__('doc_bts_creed_6')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('doc_bts_stack_title')?>
  </h5>

  <div class="padding_top">
    <?=__('doc_bts_stack_intro')?><br>
    <ul class="tinypadding_top">
      <li>
        <?=__('doc_bts_stack_domain')?>
      </li>
      <li>
        <?=__('doc_bts_stack_server')?>
      </li>
      <li>
        <?=__('doc_bts_stack_http')?>
      </li>
      <li>
        <?=__('doc_bts_stack_database')?>
      </li>
      <li>
        <?=__('doc_bts_stack_back')?>
      </li>
      <li>
        <?=__('doc_bts_stack_front')?>
      </li>
      <li>
        <?=__('doc_bts_stack_images')?>
      </li>
      <li>
        <?=__('doc_bts_stack_machine')?>
      </li>
      <li>
        <?=__('doc_bts_stack_editor')?>
      </li>
      <li>
        <?=__('doc_bts_stack_git')?>
      </li>
      <li>
        <?=__('doc_bts_stack_shell')?>
      </li>
    </ul>
  </div>

  <h5 class="bigpadding_top">
    <?=__('doc_bts_source_title')?>
  </h5>

  <p>
    <?=__('doc_bts_source_1')?>
  </p>

  <p>
    <?=__('doc_bts_source_2')?>
  </p>

  <p>
    <?=__('doc_bts_source_3')?>
  </p>

  <p>
    <?=__('doc_bts_source_4')?>
  </p>

  <p>
    <?=__('doc_bts_source_5')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('doc_bts_contributing_title')?>
  </h5>

  <p>
    <?=__('doc_bts_contributing_body')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }