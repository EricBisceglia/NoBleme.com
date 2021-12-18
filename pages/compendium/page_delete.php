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
$page_url         = "pages/compendium/page_delete";
$page_title_en    = "Compendium: Delete page";
$page_title_fr    = "Compendium : Supprimer une page";




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

// Redirect if the page doesn't exist or shouldn't be accessed
if(!$compendium_page_data)
  exit(header('Location: '.$path.'pages/compendium/page_list_admin'));

// Determine if the deletion is soft or hard
$compendium_hard_delete = ($compendium_page_data['deleted'] || $compendium_page_data['draft']) ? true : false;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete the page

// Attempt to delete the page if requested
if(isset($_POST['compendium_delete_submit']))
{
  // Delete the page
  compendium_pages_delete(  $compendium_page_id     ,
                            $compendium_hard_delete );

  // Redirect to the page (if hard deleted, redirection will go to the page list instead)
  exit(header("Location: ".$path."pages/compendium/".$compendium_page_data['url']));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/compendium/page_list_admin', __('compendium_page_delete_title'), 'noglow')?>
  </h1>

  <p>
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

  <p class="bold smallpadding_bot">
    <?php if(!$compendium_hard_delete) { ?>
    <span class="text_orange big"><?=__('compendium_page_delete_soft')?></span>
    <?php } else { ?>
    <span class="red text_white big"><?=__('compendium_page_delete_hard')?></span>
    <?php } ?>
  </p>


  <form method="POST">
    <fieldset>

      <div class="smallpadding_top">
        <input type="submit" name="compendium_delete_submit" value="<?=__('compendium_page_delete_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }