<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/translations";
$page_title_en    = "Duplicate translations";
$page_title_fr    = "Traductions redondantes";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Look up duplicate translations

// Include every single translation in the whole project
$directory = $path."/lang/";
foreach(scandir($directory) as $filename)
{
  if($filename && mb_substr($filename, -9) === '.lang.php')
    include_once './../../lang/'.$filename;
}

// Assemble a list of strings which are allowed to be duplicates
$duplicate_ok_list = array( 'account_password_confirm'          , # Nuance in english only
                            'account_password_new'              , # Nuance in english only
                            'activity_type_dev'                 , # Acceptable redundancy
                            'admin_ban_list_length'             , # Short/long versions
                            'admin_ban_delete_ban_reason'       , # With/without line break
                            'admin_ban_delete_unban_reason_en'  , # Nuance in english only
                            'admin_ban_delete_unban_reason_fr'  , # Nuance in english only
                            'admin_metrics_count_search+'       , # Nuance in english only
                            'admin_metrics_page'                , # Nuance in french only
                            'admin_metrics_warning'             , # Nuance in french only
                            'admin_rights_submit'               , # Nuance in english only
                            'admin_stats_users_complete'        , # Acceptable redundancy
                            'admin_stats_users_partial+'        , # Nuance in french only
                            'admin_stats_users_profile_text'    , # Nuance in english only
                            'admin_stats_users_pronouns'        , # Acceptable redundancy
                            'administration'                    , # Nuance in english only
                            'at_date'                           , # Nuance in english only
                            'compendium_admin_search_page'      , # Nuance in english only
                            'compendium_category_edit_submit'   , # Nuance in english only
                            'compendium_era_edit_submit'        , # Nuance in english only
                            'compendium_eras_entries'           , # Nuance in english only
                            'compendium_faq_question_12'        , # Nuance in english only
                            'compendium_image_list_uploaded'    , # Nuance in english only
                            'compendium_list_admin_menu'        , # Nuance in english only
                            'compendium_list_created'           , # Nuance in french only
                            'compendium_list_links_url'         , # Nuance in english only
                            'compendium_page_delete_submit'     , # Nuance in english only
                            'compendium_page_draft_submit'      , # Nuance in english only
                            'compendium_page_edit_submit'       , # Nuance in english only
                            'compendium_page_pageviews+'        , # Nuance in english only
                            'compendium_page_type'              , # Nuance in french only
                            'compendium_type_edit_submit'       , # Nuance in english only
                            'compendium_type_subtitle'          , # Nuance in french only
                            'discord_webhook_message_admin'     , # Nuance in french only
                            'irc_bot_message_send'              , # Acceptable redundancy
                            'irc_faq_select_guide'              , # Nuance in french only
                            'irc_faq_symbols_user'              , # Acceptable redundancy
                            'meetups_details_title'             , # Nuance in french only
                            'meetups_organize_title'            , # Nuance in english only
                            'meetups_stats_selector_people'     , # Nuance in english only
                            'modify'                            , # Nuance in english only
                            'month+'                            , # Redundant on purpose
                            'month_1'                           , # Redundant on purpose
                            'month_2'                           , # Redundant on purpose
                            'month_3'                           , # Redundant on purpose
                            'month_4'                           , # Redundant on purpose
                            'month_5'                           , # Redundant on purpose
                            'month_6'                           , # Redundant on purpose
                            'month_7'                           , # Redundant on purpose
                            'month_8'                           , # Redundant on purpose
                            'month_9'                           , # Redundant on purpose
                            'month_10'                          , # Redundant on purpose
                            'month_11'                          , # Redundant on purpose
                            'month_12'                          , # Redundant on purpose
                            'month_short_5'                     , # Short/long versions
                            'month_short_6'                     , # Short/long versions
                            'month_short_7'                     , # Short/long versions
                            'month_short_8'                     , # Short/long versions
                            'nobleme_home_statement_title'      , # Acceptable redundancy
                            'none_f'                            , # Nuance in french only
                            'ordinal_2_en'                      , # Redundant on purpose
                            'preview_2'                         , # Nuance in french only
                            'quotes_stats_contrib_approved'     , # Acceptable redundancy
                            'quotes_stats_selector_submitted'   , # Acceptable redundancy
                            'quotes_subtitle'                   , # Nuance in english only
                            'quotes_users_empty'                , # Acceptable redundancy
                            'search2'                           , # Nuance in french only
                            'sent+'                             , # Nuance in french only
                            'submenu_admin_doc'                 , # Nuance in english only
                            'submenu_admin_settings'            , # Nuance in french only
                            'submenu_admin_stats_guests'        , # Nuance in english only
                            'submenu_nobleme_roadmap'           , # Nuance in english only
                            'submenu_pages_compendium_eras'     , # Nuance in english only
                            'submenu_social_meetups'            , # Nuance in english only
                            'submenu_social_quotes'             , # Acceptable redundancy
                            'submenu_social_quotes_submit'      , # Nuance in english only
                            'tasks_add_milestone'               , # Nuance in english only
                            'tasks_categories_edit'             , # Acceptable redundancy
                            'tasks_list_count_finished'         , # Nuance in french only
                            'tasks_list_count_finished_short'   , # Nuance in french only
                            'tasks_list_goal'                   , # Nuance in english only
                            'tasks_list_uncategorized'          , # Acceptable redundancy
                            'tasks_reject_submit'               , # Nuance in french only
                            'tasks_stats_selector_priority'     , # Nuance in english only
                            'tasks_stats_selector_submitted'    , # Acceptable redundancy
                            'time_indicator_en'                 , # Redundant on purpose
                            'times'                             , # Redundant on purpose
                            'undelete'                          , # Nuance in english only
                            'user+'                             , # Nuance in french only
                            'user_acc+'                         , # Nuance in french only
                            'users_mail_chain_unread'           , # Nuance in english only
                            'users_message_admins_name_del'     , # Nuance in english only
                            'users_message_error_nick_long'     , # Nuance in english only
                            'users_message_error_nick_short'    , # Nuance in english only
                            'users_profile_edit_submit'         , # Nuance in english only
                            'users_stats_anniv_days'            , # Nuance in english only
                            'users_stats_birth_age'             , # Nuance in french only
                            'users_stats_contrib_tasks'         , # Acceptable redundancy
                            'year_age'                          , # Nuance in english only
                            'year_age+'                        ); # Nuance in english only

// Look for duplicate translations in the current language
$duplicate_translations = dev_duplicate_translations_list($duplicate_ok_list);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center bigpadding_bot">
    <?=__('submenu_admin_doc_duplicates')?>
  </h1>

  <table>
    <thead class="uppercase">

      <tr class="row_separator_dark">
        <th class="align_left">
          <?=__('dev_translations_name')?>
        </th>
        <th class="align_left">
          <?=__('contents')?>
        </th>
      </tr>

    </thead>
    <tbody>

      <?php if(!$duplicate_translations['rows']) { ?>

      <tr>
        <td colspan="2" class="align_center">
          <?=__('dev_translations_none')?>
        </td>
      </tr>

      <?php } else { ?>

      <?php for($i = 0; $i < $duplicate_translations['rows']; $i++) { ?>

      <?php if(($i + 1) < $duplicate_translations['rows'] && $duplicate_translations[$i]['value'] !== $duplicate_translations[$i+1]['value']) { ?>
      <tr class="row_separator_dark">
      <?php } else { ?>
      <tr>
      <?php } ?>
        <td>
          <?=$duplicate_translations[$i]['name']?>
        </td>
        <td>
          <?=$duplicate_translations[$i]['value']?>
        </td>
      </tr>

      <?php } ?>

      <?php } ?>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }