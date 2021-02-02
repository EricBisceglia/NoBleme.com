<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/quotes.act.php';  # Actions
include_once './../../lang/quotes.lang.php';    # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/quotes/index";
$page_title_en    = "Quotes";
$page_title_fr    = "Citations";
$page_description = "Funny bits and pieces of NoBleme's life, immortalized in our quote database";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the quotes

// Grab the user's adult content settings
$adult_settings = user_settings_nsfw();

// Fetch relevant quotes
$quotes_list = quotes_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_social_quotes')?>
  </h1>

  <h5>
    <?=__('quotes_subtitle')?>
  </h5>

  <p>
    <?=__('quotes_header_intro')?>
  </p>

  <?php if(!$adult_settings) { ?>
  <p>
    <?=__('quotes_header_blur')?>
  </p>
  <?php } ?>

  <h5 class="bigpadding_top">
    <?=__('quotes_count', $quotes_list['rows'], preset_values: array($quotes_list['rows']))?>
  </h5>

  <?php for($i = 0; $i < $quotes_list['rows']; $i++) { ?>

  <div class="monospace padding_top padding_bot align_justify">

    <div class="tinypadding_bot">
      <span class="bold">
        <?=__link('pages/quotes/'.$quotes_list[$i]['id'], __('quotes_id', preset_values: array($quotes_list[$i]['id'])))?>
        <?=$quotes_list[$i]['date']?>
      </span>

      <?php if($quotes_list[$i]['linked_count']) { ?>
      -
      <?php for($j = 0; $j < $quotes_list[$i]['linked_count']; $j++) { ?>
      <?=__link('todo_link?id='.$quotes_list[$i]['linked_ids'][$j], $quotes_list[$i]['linked_nicks'][$j])?>
      <?php } ?>
      <?php } ?>

      <?php if($is_admin) { ?>
      <?=__icon('edit', is_small: true, alt: 'E', title: __('edit'), title_case: 'initials');?>
      <?=__icon('delete', is_small: true, alt: 'X', title: __('delete'), title_case: 'initials');?>
      <?php } ?>
    </div>

    <?php if($quotes_list[$i]['nsfw']) { ?>
    <span class="blur"><?=$quotes_list[$i]['body']?></span>
    <?php } else { ?>
    <?=$quotes_list[$i]['body']?>
    <?php } ?>

  </div>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }