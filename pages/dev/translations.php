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
  if($filename && mb_substr($filename, -9) == '.lang.php')
    include_once './../../lang/'.$filename;
}

// Assemble a list of strings which are allowed to be duplicates
$duplicate_ok_list = array( 'account_email_submit'              ,
                            'account_password_confirm'          ,
                            'account_password_submit'           ,
                            'activity_title_modlogs'            ,
                            'activity_type_compendium'          ,
                            'activity_type_dev'                 ,
                            'activity_type_meetups'             ,
                            'activity_type_quotes'              ,
                            'activity_type_users'               ,
                            'admin_ban_delete_ban_reason'       ,
                            'admin_ban_delete_unban_reason_en'  ,
                            'admin_ban_delete_unban_reason_fr'  ,
                            'admin_ban_list_length'             ,
                            'admin_ban_logs_status_banned'      ,
                            'admin_metrics_count_search+'       ,
                            'admin_metrics_target'              ,
                            'admin_metrics_views'               ,
                            'admin_password_new'                ,
                            'admin_rights_submit'               ,
                            'admin_stats_guests_theme'          ,
                            'admin_stats_guests_visits'         ,
                            'admin_stats_users_complete'        ,
                            'admin_stats_users_created'         ,
                            'admin_stats_users_has_birthday'    ,
                            'admin_stats_users_language'        ,
                            'admin_stats_users_location'        ,
                            'admin_stats_users_partial+'        ,
                            'admin_stats_users_profile_text'    ,
                            'admin_stats_users_spoken'          ,
                            'administrator'                     ,
                            'compendium_categories_title'       ,
                            'compendium_category_edit_submit'   ,
                            'compendium_era_admin_name'         ,
                            'compendium_era_edit_submit'        ,
                            'compendium_eras_entries'           ,
                            'compendium_eras_subtitle'          ,
                            'compendium_eras_title'             ,
                            'compendium_index_title'            ,
                            'compendium_list_admin_bilingual'   ,
                            'compendium_list_admin_menu'        ,
                            'compendium_list_admin_url'         ,
                            'compendium_list_created'           ,
                            'compendium_list_theme'             ,
                            'compendium_missing_page'           ,
                            'compendium_page_category+'         ,
                            'compendium_page_delete_title'      ,
                            'compendium_page_draft_submit'      ,
                            'compendium_page_edit_submit'       ,
                            'compendium_page_list'              ,
                            'compendium_type_admin_short'       ,
                            'compendium_type_edit_submit'       ,
                            'compendium_type_subtitle'          ,
                            'compendium_types_title'            ,
                            'dev_blog_table_lang'               ,
                            'dev_functions_selector_users'      ,
                            'dev_js_toolbox_title'              ,
                            'dev_palette_selector_text'         ,
                            'dev_translations_value'            ,
                            'dev_scheduler_task_description'    ,
                            'discord_webhook_message_admin'     ,
                            'irc_bot_history_sent'              ,
                            'irc_bot_message_send'              ,
                            'irc_channels_language'             ,
                            'irc_faq_symbols_name'              ,
                            'login_form_error_no_password'      ,
                            'login_form_error_no_username'      ,
                            'meetups_attendees_edit_hide'       ,
                            'meetups_list_bilingual'            ,
                            'meetups_new_details'               ,
                            'meetups_organize_title'            ,
                            'modify'                            ,
                            'month+'                            ,
                            'month_short_5'                     ,
                            'month_short_6'                     ,
                            'month_short_7'                     ,
                            'month_short_8'                     ,
                            'nobleme_home_statement_title'      ,
                            'privacy_data_title'                ,
                            'quotes_add'                        ,
                            'quotes_add_subtitle'               ,
                            'quotes_restore'                    ,
                            'quotes_subtitle'                   ,
                            'quotes_users_empty'                ,
                            'submenu_admin_stats_users'         ,
                            'submenu_nobleme_dev'               ,
                            'tasks_add_milestone'               ,
                            'tasks_approve_submit'              ,
                            'tasks_categories_edit'             ,
                            'tasks_edit_author'                 ,
                            'tasks_list_category'               ,
                            'tasks_list_count_finished+'        ,
                            'tasks_list_created'                ,
                            'tasks_list_count_finished_short'   ,
                            'tasks_list_description'            ,
                            'tasks_list_uncategorized'          ,
                            'tasks_milestones_order'            ,
                            'tasks_reject_submit'               ,
                            'tasks_roadmap_title'               ,
                            'times'                             ,
                            'users_admins_title'                ,
                            'users_list_registered'             ,
                            'users_mail_chain_unread'           ,
                            'users_message_admins_del_title'    ,
                            'users_message_error_nick_short'    ,
                            'users_message_error_nick_long'     ,
                            'users_profile_delete_contents'     ,
                            'users_profile_edit_submit'         ,
                            'users_profile_pronouns'            );

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
          <?=__('dev_translations_value')?>
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

      <?php if(($i + 1) < $duplicate_translations['rows'] && $duplicate_translations[$i]['value'] != $duplicate_translations[$i+1]['value']) { ?>
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