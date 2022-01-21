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
$page_url         = "pages/compendium/admin_notes";
$page_title_en    = "Compendium admin notes";
$page_title_fr    = "Compendium : Notes admin";

// Compendium admin menu selection
$compendium_admin_menu['notes'] = 1;

// Extra CSS & JS
$css  = array('compendium');
$js   = array('compendium/admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update the admin notes

if(isset($_POST['compendium_admin_notes_submit']))
  compendium_admin_notes_edit(array(  'global'      => form_fetch_element('compendium_admin_notes_global')      ,
                                      'snippets'    => form_fetch_element('compendium_admin_notes_snippets')    ,
                                      'template_en' => form_fetch_element('compendium_admin_notes_template_en') ,
                                      'template_fr' => form_fetch_element('compendium_admin_notes_template_fr') ));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the admin notes

$compendium_admin_notes = compendium_admin_notes_get();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the page list

$compendium_pages_list = compendium_pages_list( sort_by:  'page_url'            ,
                                                search:   array( 'notes' => 1 ) );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /****/ include './../../inc/header.inc.php'; /****/ include './admin_menu.php'; ?>

<div class="width_70">

  <h2 class="padding_top padding_bot align_center">
    <?=__link('pages/compendium/index', __('compendium_admin_notes_title'), 'noglow')?>
  </h2>

  <form method="POST">
    <fieldset>

      <div class="flexcontainer tinypadding_top smallpadding_bot">
        <div class="flex spaced_right">

          <div class="smallpadding_bot">
            <label for="compendium_admin_notes_global"><?=__('compendium_admin_notes_global')?></label>
            <textarea class="compendium_admin_notes" id="compendium_admin_notes_global" name="compendium_admin_notes_global"><?=$compendium_admin_notes['global']?></textarea>
          </div>

          <label for="compendium_admin_notes_template_en"><?=__('compendium_admin_notes_template_en')?></label>
          <textarea class="compendium_admin_notes" id="compendium_admin_notes_template_en" name="compendium_admin_notes_template_en"><?=$compendium_admin_notes['template_en']?></textarea>

        </div>
        <div class="flex spaced_left">

          <div class="smallpadding_bot">
            <label for="compendium_admin_notes_snippets"><?=__('compendium_admin_notes_snippets')?></label>
            <textarea class="compendium_admin_notes" id="compendium_admin_notes_snippets" name="compendium_admin_notes_snippets"><?=$compendium_admin_notes['snippets']?></textarea>
          </div>

          <label for="compendium_admin_notes_template_fr"><?=__('compendium_admin_notes_template_fr')?></label>
          <textarea class="compendium_admin_notes" id="compendium_admin_notes_template_fr" name="compendium_admin_notes_template_fr"><?=$compendium_admin_notes['template_fr']?></textarea>

        </div>
      </div>

      <div class="tinypadding_top bigpadding_bot">
        <input type="submit" name="compendium_admin_notes_submit" value="<?=__('compendium_admin_notes_submit')?>">
      </div>

    </fieldset>
  </form>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('compendium_admin_notes_page')?>
        </th>
        <th>
          <?=__('compendium_admin_notes_text')?>
        </th>
        <th>
          <?=__('compendium_admin_notes_url')?>
        </th>
        <th>
          <?=__('act')?>
        </th>
      </tr>

    </thead>

    <tbody class="altc">

      <?php for($i = 0; $i < $compendium_pages_list['rows']; $i++) { ?>

      <tr>

        <?php if(!$compendium_pages_list[$i]['fullurl']) { ?>
        <td class="align_left nowrap">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['url'])?>
        </td>
        <?php } else { ?>
        <td class="align_left tooltip_container">
          <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['urldisplay'])?>
          <div class="tooltip">
            <?=__link('pages/compendium/'.$compendium_pages_list[$i]['url'], $compendium_pages_list[$i]['fullurl'])?>
          </div>
        </td>
        <?php } ?>

        <td class="align_left">
          <?=$compendium_pages_list[$i]['notes']?>
        </td>

        <td class="align_left nowrap">
          <?=$compendium_pages_list[$i]['urlnotes']?>
        </td>

        <td class="align_center">
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', href: 'pages/compendium/page_edit?id='.$compendium_pages_list[$i]['id'])?>
        </td>

      </tr>

      <?php } ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }