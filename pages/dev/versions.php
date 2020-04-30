<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';       # Core
include_once './../../actions/dev.act.php';        # Actions
include_once './../../lang/dev.lang.php';          # Translations
include_once './../../inc/functions_time.inc.php'; # Time calculations

// Limit page access rights
user_restrict_to_administrators($lang);

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
{
  dev_versions_create(  form_fetch_element('dev_new_version_major')       ,
                        form_fetch_element('dev_new_version_minor')       ,
                        form_fetch_element('dev_new_version_patch')       ,
                        form_fetch_element('dev_new_version_extension')   ,
                        form_fetch_element('dev_versions_activity', 0, 1) ,
                        form_fetch_element('dev_versions_irc', 0, 1)      );
}




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
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 padding_bot">

  <h1>
    <?=__('dev_versions_title')?>
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

      <div class="tinypadding_top">
        <input type="submit" name="dev_versions_create" value="<?=__('dev_versions_form_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<hr>

<div class="width_30 padding_top">

  <h5 class="padding_bot">
    <?=__('dev_versions_table_title')?>
  </h5>

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
          X
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center">

      <?php for($i = 0; $i < $version_history['rows']; $i++) { ?>

      <tr id="versions_list_<?=$version_history[$i]['id']?>">
        <td class="bold">
          <?=$version_history[$i]['version']?>
        </td>
        <td>
          <?=$version_history[$i]['date']?>
        </td>
        <td>
          <?=$version_history[$i]['date_diff']?>
        </td>
        <td class="align_center">
          <img class="valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete" onclick="dev_versions_delete(<?=$version_history[$i]['id']?>, '<?=__('dev_versions_table_confirm_deletion', 0, 0, 0, array($version_history[$i]['version']))?>');">
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
/*******************************************************************************/ include './../../inc/footer.inc.php';