

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/admin.act.php'; # Actions
include_once './../../lang/admin.lang.php';   # Translations

// Limit page access rights
user_restrict_to_moderators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/ban";
$page_title_en    = "Bans";
$page_title_fr    = "Bannissements";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ban a user

// Hide the french ban justification in the english interface
$admin_ban_hide_french = ($lang == 'EN') ? ' hidden' : '';

// Fetch the ban form values, that way they can be kept as is after submitting
$admin_ban_add_nick       = form_fetch_element('admin_ban_add_nick', '');
$admin_ban_add_reason_en  = form_fetch_element('admin_ban_add_reason_en', '');
$admin_ban_add_reason_fr  = form_fetch_element('admin_ban_add_reason_fr', '');
$admin_ban_add_length     = form_fetch_element('admin_ban_add_length', 0);

// Keep the ban length selector as is aswell by setting the correct element to selected
$admin_ban_add_selector_values = array(0, 1, 7, 30, 365, 3650);
foreach($admin_ban_add_selector_values as $value)
  $admin_ban_add_selector[$value] = ($admin_ban_add_length == $value) ? ' selected' : '';

// If the ban length selector isn't in use, make the empty option the default one
if(!isset($_POST['admin_ban_add_length']))
  $admin_ban_add_selector[0] = ' selected';

// Submit the ban request
if(isset($_POST['admin_ban_add_submit']))
{
  $admin_ban_add_error = admin_ban_user(  user_get_id()             ,
                                          $admin_ban_add_nick       ,
                                          $admin_ban_add_length     ,
                                          $admin_ban_add_reason_en  ,
                                          $admin_ban_add_reason_fr  ,
                                          $lang                     );

  // Reset the nickname to allow chain bans, unless the ban request resulted in an error
  if(!$admin_ban_add_error)
    $admin_ban_add_nick     = '';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 align_center">

  <h1>
    <?=__('admin_ban_title')?>
  </h1>

</div>

<div class="width_30 bigpadding_top">

  <h5 class="smallpadding_bot">
    <?=__('admin_ban_add_title')?>
  </h5>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="admin_ban_add_nick"><?=__('admin_ban_add_nickname')?></label>
        <input class="indiv" type="text" id="admin_ban_add_nick" name="admin_ban_add_nick" value="<?=$admin_ban_add_nick?>">
      </div>

      <div class="smallpadding_bot<?=$admin_ban_hide_french?>">
        <label for="admin_ban_add_reason_fr"><?=__('admin_ban_add_reason_fr')?></label>
        <input class="indiv" type="text" id="admin_ban_add_reason_fr" name="admin_ban_add_reason_fr" value="<?=$admin_ban_add_reason_fr?>">
      </div>

      <div class="smallpadding_bot">
        <label for="admin_ban_add_reason_en"><?=__('admin_ban_add_reason_en')?></label>
        <input class="indiv" type="text" id="admin_ban_add_reason_en" name="admin_ban_add_reason_en" value="<?=$admin_ban_add_reason_en?>">
      </div>

      <div class="padding_bot">
        <label for="admin_ban_add_length"><?=__('admin_ban_add_duration')?></label>
        <select class="indiv" id="admin_ban_add_length" name="admin_ban_add_length">
          <option value="0"<?=$admin_ban_add_selector[0]?>>&nbsp;</option>
          <option value="1"<?=$admin_ban_add_selector[1]?>><?=__('admin_ban_add_duration_1d')?></option>
          <option value="7"<?=$admin_ban_add_selector[7]?>><?=__('admin_ban_add_duration_1w')?></option>
          <option value="30"<?=$admin_ban_add_selector[30]?>><?=__('admin_ban_add_duration_1m')?></option>
          <option value="365"<?=$admin_ban_add_selector[365]?>><?=__('admin_ban_add_duration_1y')?></option>
          <option value="3650"<?=$admin_ban_add_selector[3650]?>><?=__('admin_ban_add_duration_10y')?></option>
        </select>
      </div>

      <?php if(isset($admin_ban_add_error)) { ?>
      <div class="padding_bot">
        <span class="bold big red spaced">
          <?=string_change_case(__('error'), 'uppercase').__(':', 0, 0, 1).$admin_ban_add_error?>
        </span>
      </div>
      <?php } ?>

      <input type="submit" name="admin_ban_add_submit" value="<?=__('admin_ban_add_button')?>">

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }