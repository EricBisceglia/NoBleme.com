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
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/profile_delete";
$page_title_en    = "Delete a public profile";
$page_title_fr    = "Supprimer un profil public";
$page_description = "Delete a user's public profile";

// Extra CSS
$css = array('users');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete a public profile

// Make sure an ID is provided
if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  exit(header("Location: ".$path));

// Fetch the user id
$user_id = $_GET['id'];

// Delete the profile if requested
if(isset($_POST['profile_delete_submit']))
{
  // Prepare an array with the contents to be deleted
  $delete_fields = array( 'country'     => form_fetch_element('profile_delete_country', element_exists: true)     ,
                          'pronouns_en' => form_fetch_element('profile_delete_pronouns_en', element_exists: true) ,
                          'pronouns_fr' => form_fetch_element('profile_delete_pronouns_fr', element_exists: true) ,
                          'text_en'     => form_fetch_element('profile_delete_text_en', element_exists: true)     ,
                          'text_fr'     => form_fetch_element('profile_delete_text_fr', element_exists: true)     );

  // Trigger the deletion
  user_delete_profile(  $user_id        ,
                        $delete_fields  );

  // Redirect to the user's profile
  exit(header("Location: ".$path."pages/users/".$user_id));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the user's public profile

// Fetch the user's profile data
$profile_data = user_get($user_id);

// Stop there if the user wasn't found
if(!$profile_data)
  exit(header("Location: ".$path));




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
    <?=__('users_profile_delete_subtitle')?>
  </h5>

  <?php if(!$profile_data['country'] && !$profile_data['pronoun_en'] && !$profile_data['pronoun_fr'] && !$profile_data['ftext_en'] && !$profile_data['ftext_fr']) { ?>

  <p>
    <?=__('users_profile_delete_none')?>
  </p>

  <?php } else { ?>

  <p>
    <?=__('users_profile_delete_intro')?>
  </p>

  <form method="POST" class="bigpadding_top">

    <fieldset>
      <table>

        <thead>
          <tr class="uppercase">
            <th>
              <?=__('users_profile_delete_selection')?>
            </th>
            <th>
              <?=__('contents')?>
            </th>
          </tr>
        </thead>

        <tbody>

          <?php if($profile_data['country']) { ?>
          <tr class="pointer" onclick="checkbox_toggle('profile_delete_country');">
            <td class="nowrap">
              <input type="checkbox" id="profile_delete_country" name="profile_delete_country">
              <label class="label_inline" for="profile_delete_country"><?=__('users_profile_country')?></label>
            </td>
            <td>
              <?=$profile_data['country']?>
            </td>
          </tr>
          <?php } ?>

          <?php if($profile_data['pronoun_en']) { ?>
          <tr class="pointer" onclick="checkbox_toggle('profile_delete_pronouns_en');">
            <td class="nowrap">
              <input type="checkbox" id="profile_delete_pronouns_en" name="profile_delete_pronouns_en">
              <label class="label_inline" for="profile_delete_pronouns_en"><?=__('users_profile_pronouns').__('users_profile_edit_english')?></label>
            </td>
            <td>
              <?=$profile_data['pronoun_en']?>
            </td>
          </tr>
          <?php } ?>

          <?php if($profile_data['pronoun_fr']) { ?>
          <tr class="pointer" onclick="checkbox_toggle('profile_delete_pronouns_fr');">
            <td class="nowrap">
              <input type="checkbox" id="profile_delete_pronouns_fr" name="profile_delete_pronouns_fr">
              <label class="label_inline" for="profile_delete_pronouns_fr"><?=__('users_profile_pronouns').__('users_profile_edit_french')?></label>
            </td>
            <td>
              <?=$profile_data['pronoun_fr']?>
            </td>
          </tr>
          <?php } ?>

          <?php if($profile_data['ftext_en']) { ?>
          <tr class="pointer" onclick="checkbox_toggle('profile_delete_text_en');">
            <td class="nowrap">
              <input type="checkbox" id="profile_delete_text_en" name="profile_delete_text_en">
              <label class="label_inline" for="profile_delete_text_en"><?=__('users_profile_delete_text').__('users_profile_edit_english')?></label>
            </td>
            <td>
              <div class="profile_text_cell">
                <?=$profile_data['ftext_en']?>
              </div>
            </td>
          </tr>
          <?php } ?>

          <?php if($profile_data['ftext_fr']) { ?>
          <tr class="pointer" onclick="checkbox_toggle('profile_delete_text_fr');">
            <td class="nowrap">
              <input type="checkbox" id="profile_delete_text_fr" name="profile_delete_text_fr">
              <label class="label_inline" for="profile_delete_text_fr"><?=__('users_profile_delete_text').__('users_profile_edit_french')?></label>
            </td>
            <td>
              <div class="profile_text_cell">
                <?=$profile_data['ftext_fr']?>
              </div>
            </td>
          </tr>
          <?php } ?>

        </tbody>
      </table>

      <div class="padding_top">
        <input type="submit" name="profile_delete_submit" value="<?=__('users_profile_delete_submit')?>">
      </div>

    </fieldset>
  </form>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }