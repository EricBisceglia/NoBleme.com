<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../actions/users.act.php';       # Actions
include_once './../../lang/users.lang.php';         # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/profile_edit";
$page_title_en    = "Modify your profile";
$page_title_fr    = "Modifier mon profil";
$page_description = "Modify your account's public profile to better reflect (or hide) your identity";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit the user's public profile

if(isset($_POST['profile_edit_submit']))
{
  // Prepare an array containing the updated profile data
  $profile_edit = array(  'lang_en'     => form_fetch_element('profile_edit_languages_en', element_exists: true)  ,
                          'lang_fr'     => form_fetch_element('profile_edit_languages_fr', element_exists: true)  ,
                          'birth_day'   => form_fetch_element('profile_edit_birth_day')                           ,
                          'birth_month' => form_fetch_element('profile_edit_birth_month')                         ,
                          'birth_year'  => form_fetch_element('profile_edit_birth_year')                          ,
                          'residence'   => form_fetch_element('profile_edit_residence')                           ,
                          'pronouns_en' => form_fetch_element('profile_edit_pronouns_en')                         ,
                          'pronouns_fr' => form_fetch_element('profile_edit_pronouns_fr')                         ,
                          'text_en'     => form_fetch_element('users_profile_edit_text_en')                       ,
                          'text_fr'     => form_fetch_element('users_profile_edit_text_fr')                       );

  // Update the profile
  user_edit_profile(user_data: $profile_edit);

  // Redirect the user to their public profile
  exit(header("Location: ".$path."pages/users/profile"));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Current user profile data

// Fetch the profile data
$profile_data = user_get();

// Stop there if the profile can't be found
if(!$profile_data)
  exit(header("Location: ./"));

// Hide the french inputs when the user's language is english
$hide_lang      = ($lang == 'FR' || $profile_data['lang_fr']) ? '' : ' hidden';
$hide_lang_full = ($lang == 'FR' || $profile_data['lang_fr']) ? '' : ' class="hidden"';

// Determine whether the language checkboxes should be checked
$check_lang_en = ($profile_data['lang_en']) ? ' checked' : '';
$check_lang_fr = ($profile_data['lang_fr']) ? ' checked' : '';

// Prepare the dropdown menu for birth day
$select_birth_day[0] = (!$profile_data['birth_d']) ? ' selecetd' : '';
for($i = 1; $i <= 31; $i++)
  $select_birth_day[$i] = ($i == $profile_data['birth_d']) ? ' selected' : '';

// Prepare the dropdown menu for birth month
$select_birth_month[0] = (!$profile_data['birth_m']) ? ' selecetd' : '';
for($i = 1; $i <= 12; $i++)
  $select_birth_month[$i] = ($i == $profile_data['birth_m']) ? ' selected' : '';

// Prepare the dropdown menu for birth year
$select_birth_year[0] = (!$profile_data['birth_y']) ? ' selecetd' : '';
for($i = 1900; $i <= date('Y'); $i++)
  $select_birth_year[$i] = ($i == $profile_data['birth_y']) ? ' selected' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=$profile_data['username']?>
  </h1>

  <h5>
    <?=__('users_profile_edit_subtitle')?>
  </h5>

  <p>
    <?=__('users_profile_edit_intro')?>
  </p>

  <form method="POST">
    <fieldset>

      <div class="padding_top padding_bot">

        <div class="smallpadding_top">
          <label for="profile_edit_languages_en"><?=__('users_profile_edit_bilingual')?></label>
          <input type="checkbox" id="profile_edit_languages_en" name="profile_edit_languages_en" value="en"<?=$check_lang_en?>>
          <label class="label_inline" for="profile_edit_languages_en"><?=string_change_case(__('english'), 'initials')?></label><br>
          <input type="checkbox" id="profile_edit_languages_fr" name="profile_edit_languages_fr" value="fr"<?=$check_lang_fr?>>
          <label class="label_inline" for="profile_edit_languages_fr"><?=string_change_case(__('french'), 'initials')?></label>
        </div>

      </div>

      <label for="profile_edit_birth_day"><?=__('users_profile_edit_birthday')?></label>

      <div class="flexcontainer padding_bot">

        <div style="flex: 4">
          <select class="indiv" id="profile_edit_birth_day" name="profile_edit_birth_day">
            <option value="0"<?=$select_birth_day[0]?>>&nbsp;</option>
            <?php for($i = 1; $i <= 31; $i++) { ?>
            <option value="<?=$i?>"<?=$select_birth_day[$i]?>><?=$i?></option>
            <?php } ?>
          </select>
        </div>

        <div class="flex">
          &nbsp;
        </div>

        <div style="flex: 6">
          <select class="indiv" id="profile_edit_birth_month" name="profile_edit_birth_month">
            <option value="0"<?=$select_birth_month[0]?>>&nbsp;</option>
            <?php for($i = 1; $i <= 12; $i++) { ?>
            <option value="<?=$i?>"<?=$select_birth_month[$i]?>><?=__('month_'.$i)?></option>
            <?php } ?>
          </select>
        </div>

        <div class="flex">
          &nbsp;
        </div>

        <div style="flex: 4">
          <select class="indiv" id="profile_edit_birth_year" name="profile_edit_birth_year">
            <option value="0"<?=$select_birth_year[0]?>>&nbsp;</option>
            <?php for($i = date('Y'); $i >= 1900; $i--) { ?>
            <option value="<?=$i?>"<?=$select_birth_year[$i]?>><?=$i?></option>
            <?php } ?>
          </select>
        </div>

        <div style="flex: 15" class="desktop">
          &nbsp;
        </div>

      </div>

      <label for="profile_edit_residence"><?=__('users_profile_edit_residence')?></label>
      <input type="text" class="indiv" id="profile_edit_residence" name="profile_edit_residence" value="<?=$profile_data['country']?>" maxlength="40">

      <div class="flexcontainer padding_top padding_bot">

        <div style="flex: 8;"<?=$hide_lang_full?>>

          <label for="profile_edit_pronouns_fr"><?=__('users_profile_edit_pronouns')?><span<?=$hide_lang_full?>><?=__('users_profile_edit_french')?></span></label>
          <input type="text" class="indiv" id="profile_edit_pronouns_fr" name="profile_edit_pronouns_fr" value="<?=$profile_data['pronoun_fr']?>" maxlength="40">

          <div class="padding_top">
            <label for="users_profile_edit_text_fr"><?=__('users_profile_edit_text')?><span<?=$hide_lang_full?>><?=__('users_profile_edit_french')?></span></label>
            <textarea id="users_profile_edit_text_fr" name="users_profile_edit_text_fr"><?=$profile_data['text_fr']?></textarea>
          </div>

        </div>

        <div style="flex: 1;"<?=$hide_lang_full?>>
          &nbsp;
        </div>

        <div style="flex: 8;">

          <label for="profile_edit_pronouns_en"><?=__('users_profile_edit_pronouns')?><span<?=$hide_lang_full?>><?=__('users_profile_edit_english')?></span></label>
          <input type="text" class="indiv" id="profile_edit_pronouns_en" name="profile_edit_pronouns_en" value="<?=$profile_data['pronoun_en']?>" maxlength="25">

          <div class="padding_top">
            <label for="users_profile_edit_text_en"><?=__('users_profile_edit_text')?><span<?=$hide_lang_full?>><?=__('users_profile_edit_english')?></span></label>
            <textarea id="users_profile_edit_text_en" name="users_profile_edit_text_en"><?=$profile_data['text_en']?></textarea>
          </div>

        </div>

      </div>

      <div class="smallpadding_top">
        <input type="submit" name="profile_edit_submit" value="<?=__('users_profile_edit_submit')?>">
      </div>

      <div class="padding_top hidden" id="users_profile_text_preview">
        &nbsp;
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }