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

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/profile";
$page_title_en    = "Public profile";
$page_title_fr    = "Profil public";
$page_description = "Your account's public profile on NoBleme";

// Extra CSS
$css = array('users');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get data about the user

// Fetch the profile id and the user's current id
$profile_id = form_fetch_element('id', request_type: 'GET');
$user_id    = user_get_id();

// Fetch the data
$profile_data = user_get($profile_id);

// Stop there if the profile can't be found
if(!$profile_data)
  exit(header("Location: ./"));

// Update the page data if required
if($profile_id)
{
  $page_url         = 'pages/users/'.$profile_data['id'];
  $page_title_en    = $profile_data['username']."'s public profile";
  $page_title_fr    = "Profil public de ".$profile_data['username'];
  $page_description = "Public profile of the user $page_title_en on NoBleme";
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<?php if($profile_data['deleted']) { ?>

<div class="gigapadding_top hugepadding_bot align_center text_red bigger">
  <?=__('users_profile_deleted')?>
</div>

<?php } else if($profile_data['banned']) { ?>

<div class="gigapadding_top hugepadding_bot align_center text_red bigger">
  <?=__('users_profile_banned')?>
  <?php if($is_moderator) { ?>
  <?=__icon('user_confirm', href: 'pages/admin/ban_delete?user='.$profile_data['id'], class: 'valign_middle spaced_left pointer', alt: 'O', title: __('users_profile_unban'), title_case: 'initials')?>
  <?php } ?>
  <div class="small bigpadding_top">
    <?=__('users_profile_ban_end', preset_values: array($profile_data['unbanned']))?>
  </div>
</div>

<?php } else { ?>

<div class="width_30">

  <h1 class="align_center">
    <?=__link('pages/users/list', $profile_data['username'], 'text_red noglow')?>
    <?php if(!$profile_id || $profile_id == $user_id) { ?>
    <?=__icon('edit', href: 'pages/users/profile_edit', alt: 'E', title: __('edit'), title_case: 'initials')?>
    <?php } ?>
    <?php if($is_moderator && $profile_id && $profile_id != $user_id) { ?>
    <?=__icon('edit', href: 'pages/users/profile_delete?id='.$profile_data['id'], alt: 'E', title: __('edit'), title_case: 'initials')?>
    <?=__icon('user_delete', href: 'pages/admin/ban?id='.$profile_data['id'], alt: 'X', title: __('edit'), title_case: 'initials')?>
    <?php } ?>
  </h1>

  <?php if($profile_data['title']) { ?>
  <h5 class="align_center tinypadding_bot">
    <?=__link('pages/users/admins', $profile_data['title'], $profile_data['title_css'])?>
  </h5>
  <?php } ?>

  <?php if($profile_data['text']) { ?>
  <div class="profile_box profile_text">
    <?=$profile_data['text']?>
  </div>
  <?php } ?>

  <div class="profile_box profile_info">

    <div class="profile_info_box glow text_red bold">
      <?=__('users_profile_summary', preset_values: array($profile_data['id']))?>
    </div>

    <?php if($profile_data['lang_en'] || $profile_data['lang_fr']) { ?>
    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_languages')?></span><br>
      <div class="tinypadding_bot">
        <?php if($profile_data['lang_en']) { ?>
        <img src="<?=$path?>img/icons/lang_en.png" class="valign_middle profile_flag" alt="<?=__('EN')?>" title="<?=string_change_case(__('english'), 'initials')?>">
        <?php } if($profile_data['lang_fr']) { ?>
        <img src="<?=$path?>img/icons/lang_fr.png" class="valign_middle profile_flag" alt="<?=__('FR')?>" title="<?=string_change_case(__('french'), 'initials')?>">
        <?php } ?>
      </div>
    </div>
    <?php } ?>

    <?php if($profile_data['pronouns']) { ?>
    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_pronouns')?></span><br>
      <?=$profile_data['pronouns']?>
    </div>
    <?php } ?>

    <?php if($profile_data['country']) { ?>
    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_country')?></span><br>
      <?=$profile_data['country']?>
    </div>
    <?php } ?>

    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_created')?></span><br>
      <?=$profile_data['created']?> (<?=$profile_data['screated']?>)
    </div>

    <?php if(!$profile_data['hideact']) { ?>
    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_activity')?></span><br>
      <?=$profile_data['activity']?>
    </div>
    <?php } ?>

    <?php if($profile_data['age']) { ?>
    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_age')?></span><br>
      <?=__('users_profile_age_years', preset_values: array($profile_data['age']))?>
    </div>
    <?php } ?>

    <?php if($profile_data['birthday']) { ?>
    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_birthday')?></span><br>
      <?=$profile_data['birthday']?>
    </div>
    <?php } ?>

  </div>

  <?php if($is_moderator && $profile_id) { ?>

  <div class="profile_box profile_info profile_admin">

    <div class="profile_info_box glow text_red bold">
      <?=__('users_profile_admin')?>
    </div>

    <?php if($is_admin) { ?>

    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_ip')?></span><br>
      <?=$profile_data['ip']?>
    </div>

    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_email')?></span><br>
      <?=$profile_data['email']?>
    </div>

    <?php } ?>

    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_page')?></span><br>
      <?php if($profile_data['lasturl']) { ?>
      <?=__link($profile_data['lasturl'], $profile_data['lastpage'])?>
      <?php } else { ?>
      <?=$profile_data['lastpage']?>
      <?php } ?>
    </div>

    <div class="profile_info_box">
      <span class="bold"><?=__('users_profile_action')?></span><br>
      <?=$profile_data['lastaction']?>
    </div>

  </div>

  <?php } ?>

</div>

<?php } ?>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }
