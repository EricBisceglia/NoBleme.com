<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/dev.act.php';         # Actions
include_once './../../lang/dev.lang.php';           # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/versions";
$page_title_en    = "Version numbers";
$page_title_fr    = "Versions";

// Extra JS
$js = array('dev/versions');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add a new version

if(isset($_POST['dev_versions_create']))
  $version_add_error = dev_versions_create( form_fetch_element('dev_new_version_major')       ,
                                            form_fetch_element('dev_new_version_minor')       ,
                                            form_fetch_element('dev_new_version_patch')       ,
                                            form_fetch_element('dev_new_version_extension')   ,
                                            form_fetch_element('dev_versions_activity', 0, 1) ,
                                            form_fetch_element('dev_versions_irc', 0, 1)      );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit an existing version

if(isset($_POST['dev_versions_edit']))
{
  // Edit the version
  $version_edit_id    = form_fetch_element('dev_versions_edit', 0);
  $version_edit_error = dev_versions_edit(  $version_edit_id                                            ,
                                            form_fetch_element('dev_versions_edit_major', 0)            ,
                                            form_fetch_element('dev_versions_edit_minor', 0)            ,
                                            form_fetch_element('dev_versions_edit_patch', 0)            ,
                                            form_fetch_element('dev_versions_edit_extension', '')       ,
                                            form_fetch_element('dev_versions_edit_date', date('d/m/y')) );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Close the edit popin if it is open

$onload = "popin_close('dev_versions_popin')";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Next version suggestion

$next_version = system_get_current_version_number('next');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Version history

$version_history = dev_versions_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 padding_bot">

  <h1>
    <?=__('submenu_admin_versions')?>
  </h1>

  <h5>
    <?=__('dev_versions_subtitle')?>
  </h5>

  <p>
    <?=__('dev_versions_nbsemver')?>
  </p>

  <?=__('dev_versions_nbsemver_list')?>

</div>

<hr>

<div class="width_50 padding_top bigpadding_bot">

  <h5>
    <?=__('dev_versions_form_title')?>
  </h5>

  <form class="padding_top" method="POST">
    <fieldset>

      <div class="flexcontainer smallpadding_bot">

        <div class="flex spaced_right">
          <label for="dev_new_version_major"><?=__('dev_versions_form_major')?></label>
          <input class="indiv" type="text" id="dev_new_version_major" name="dev_new_version_major" value="<?=$next_version['major']?>">
        </div>

        <div class="flex spaced_left spaced_right">
          <label for="dev_new_version_minor"><?=__('dev_versions_form_minor')?></label>
          <input class="indiv" type="text" id="dev_new_version_minor" name="dev_new_version_minor" value="<?=$next_version['minor']?>">
        </div>

        <div class="flex spaced_left spaced_right">
          <label for="dev_new_version_patch"><?=__('dev_versions_form_patch')?></label>
          <input class="indiv" type="text" id="dev_new_version_patch" name="dev_new_version_patch" value="<?=$next_version['patch']?>">
        </div>

        <div class="flex spaced_left">
          <label for="dev_new_version_extension"><?=__('dev_versions_form_extension')?></label>
          <input class="indiv" type="text" id="dev_new_version_extension" name="dev_new_version_extension" value="<?=$next_version['extension']?>">
        </div>

      </div>

      <input type="checkbox" id="dev_versions_activity" name="dev_versions_activity" checked>
      <label class="label_inline" for="dev_versions_activity"><?=__('dev_versions_form_activity')?></label><br>

      <input type="checkbox" id="dev_versions_irc" name="dev_versions_irc">
      <label class="label_inline" for="dev_versions_irc"><?=__('dev_versions_form_irc')?></label>

      <?php if(isset($version_add_error) && $version_add_error) { ?>

      <div class="text_red bold big">
        <?=$version_add_error?>
      </div>

      <?php } ?>

      <div class="tinypadding_top">
        <input type="submit" name="dev_versions_create" value="<?=__('dev_versions_form_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<hr>

<div class="width_40 padding_top">

  <h2 class="align_center padding_bot">
    <?=__('dev_versions_table_title')?>
  </h2>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('version')?>
        </th>
        <th>
          <?=__('date')?>
        </th>
        <th>
          <?=__('dev_versions_table_delay')?>
        </th>
        <th>
          <?=__('action')?>
        </th>
      </tr>

    </thead>
    <tbody id="versions_list_table" class="altc align_center">

      <?php } ?>

      <?php for($i = 0; $i < $version_history['rows']; $i++) { ?>

      <tr id="versions_list_<?=$version_history[$i]['id']?>">
        <td class="bold">
          <?=$version_history[$i]['version']?>
        </td>
        <td>
          <?=$version_history[$i]['date']?>
        </td>
        <td<?=$version_history[$i]['css']?>>
          <?=$version_history[$i]['date_diff']?>
        </td>
        <td class="align_center">
          <?=__icon('edit', is_small: true, class: 'valign_middle pointer spaced', alt: 'M', title: __('edit'), title_case: 'initials', onclick: "dev_versions_edit_popin(".$version_history[$i]['id'].");")?>
          <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "dev_versions_delete(".$version_history[$i]['id'].", '".__('dev_versions_table_confirm_deletion', preset_values: array($version_history[$i]['version']))."');")?>
        </td>
      </tr>

      <?php if(isset($version_edit_error) && $version_edit_error && $version_edit_id == $version_history[$i]['id']) { ?>

      <tr>
        <td colspan="4" class="red text_white bold">
          <?=$version_edit_error?>
        </td>
      </tr>

      <?php } ?>

      <?php } ?>

      <?php if(!page_is_fetched_dynamically()) { ?>

    </tbody>
  </table>

</div>

<div id="dev_versions_popin" class="popin_background">
  <div class="popin_body">
    <a class="popin_close" onclick="popin_close('dev_versions_popin');">&times;</a>
    <div id="dev_versions_popin_body">
      &nbsp;
    </div>
  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }