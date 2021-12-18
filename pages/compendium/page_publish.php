<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../inc/functions_time.inc.php';  # Time management

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/page_publish";
$page_title_en    = "Compendium: Publish draft";
$page_title_fr    = "Compendium : Publier un brouillon";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page contents

// Fetch the page's id
$compendium_page_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the page's data
$compendium_page_data = compendium_pages_get( page_id:  $compendium_page_id ,
                                              no_loops: false               );

// Redirect if the page doesn't exist, shouldn't be accessed, or isn't a draft
if(!$compendium_page_data || !$compendium_page_data['draft'])
  exit(header('Location: '.$path.'pages/compendium/page_list_admin'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Publish the page

// Attempt to publish the page if requested
if(isset($_POST['compendium_publish_submit']))
{
  // Gather the postdata
  $compendium_publish_activity  = form_fetch_element('compendium_publish_activity', element_exists: true);
  $compendium_publish_irc       = form_fetch_element('compendium_publish_irc', element_exists: true);
  $compendium_publish_discord   = form_fetch_element('compendium_publish_discord', element_exists: true);

  // Publish the page
  compendium_pages_publish( $compendium_page_id           ,
                            $compendium_publish_activity  ,
                            $compendium_publish_irc       ,
                            $compendium_publish_discord   );

  // Redirect to the page
  exit(header("Location: ".$path."pages/compendium/".$compendium_page_data['url']));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/compendium/page_list_admin', __('compendium_page_draft_title'), 'noglow')?>
  </h1>

  <p class="padding_bot">
    <span class="bold"><?=__('compendium_list_admin_url').__(':')?></span> <?=__link('pages/compendium/'.$compendium_page_data['url'], $compendium_page_data['url'])?><br>
    <?php if($compendium_page_data['title_en']) { ?>
    <span class="bold"><?=__('compendium_page_draft_name_en')?></span> <?=__link('pages/compendium/'.$compendium_page_data['url'], $compendium_page_data['title_en'])?><br>
    <?php } if($compendium_page_data['title_fr']) { ?>
    <span class="bold"><?=__('compendium_page_draft_name_fr')?></span> <?=__link('pages/compendium/'.$compendium_page_data['url'], $compendium_page_data['title_fr'])?><br>
    <?php } if($compendium_page_data['redir_en']) { ?>
    <span class="bold"><?=__('compendium_page_draft_redir_en')?></span> <?=__link('pages/compendium/'.$compendium_page_data['url'], $compendium_page_data['redir_en'])?><br>
    <?php } if($compendium_page_data['redir_fr']) { ?>
    <span class="bold"><?=__('compendium_page_draft_redir_fr')?></span> <?=__link('pages/compendium/'.$compendium_page_data['url'], $compendium_page_data['redir_fr'])?><br>
    <?php } ?>
  </p>

  <form method="POST">
    <fieldset>

      <?php if(!$compendium_page_data['redir_en'] && !$compendium_page_data['redir_fr']) { ?>

      <input type="checkbox" id="compendium_publish_activity" name="compendium_publish_activity" checked>
      <label class="label_inline" for="compendium_publish_activity"><?=__('compendium_page_draft_activity')?></label><br>

      <input type="checkbox" id="compendium_publish_irc" name="compendium_publish_irc" checked>
      <label class="label_inline" for="compendium_publish_irc"><?=__('compendium_page_draft_irc')?></label><br>

      <input type="checkbox" id="compendium_publish_discord" name="compendium_publish_discord" checked>
      <label class="label_inline" for="compendium_publish_discord"><?=__('compendium_page_draft_discord')?></label>

      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="compendium_publish_submit" value="<?=__('compendium_page_draft_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }