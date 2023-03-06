<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_pages_get                      Returns data related to a compendium page.                             */
/*  compendium_pages_get_random               Returns data related to a random compendium page.                      */
/*  compendium_pages_list                     Fetches a list of compendium pages.                                    */
/*  compendium_pages_list_urls                Fetches a list of all public compendium page urls.                     */
/*  compendium_pages_add                      Creates a new compendium page.                                         */
/*  compendium_pages_edit                     Modifies an existing compendium page.                                  */
/*  compendium_pages_publish                  Publishes an existing compendium page.                                 */
/*  compendium_pages_delete                   Deletes an existing compendium page.                                   */
/*  compendium_pages_restore                  Restores a deleted compendium page.                                    */
/*  compendium_pages_update_pageviews         Updates the pageview count for an existing compendium page.            */
/*  compendium_pages_autocomplete             Autocompletes a page url.                                              */
/*                                                                                                                   */
/*  compendium_images_get                     Returns data related to an image used in the compendium.               */
/*  compendium_images_get_random              Returns data related to a random image used in the compendium.         */
/*  compendium_images_list                    Fetches a list of images used in the compendium.                       */
/*  compendium_images_upload                  Uploads a new compendium image.                                        */
/*  compendium_images_edit                    Modifies an existing compendium image.                                 */
/*  compendium_images_delete                  Deletes, restores, or hard deletes an existing compendium image.       */
/*  compendium_images_recalculate_links       Recalculates the compendium pages on which an image is being used.     */
/*  compendium_images_recalculate_all_links   Recalculates all compendium image links.                               */
/*  compendium_images_assemble_links          Lists all compendium pages containing an image in a usable format.     */
/*  compendium_images_assemble_tags           Transforms compendium image tags into a usable format.                 */
/*  compendium_images_update_pageviews        Updates the pageview count for an existing compendium image.           */
/*  compendium_images_autocomplete            Autocompletes an image file name.                                      */
/*                                                                                                                   */
/*  compendium_missing_get                    Returns data related to a missing compendium page.                     */
/*  compendium_missing_get_random             Returns data related to a random missing compendium page.              */
/*  compendium_missing_list                   Fetches a list of all missing compendium pages.                        */
/*  compendium_missing_edit                   Creates or modifies data on a missing compendium page.                 */
/*  compendium_missing_delete                 Deletes a missing compendium page entry.                               */
/*                                                                                                                   */
/*  compendium_types_get                      Returns data related to a compendium page type.                        */
/*  compendium_types_list                     Fetches a list of compendium page types.                               */
/*  compendium_types_add                      Creates a new compendium page type.                                    */
/*  compendium_types_edit                     Modifies an existing compendium page type.                             */
/*  compendium_types_delete                   Deletes an existing compendium page type.                              */
/*                                                                                                                   */
/*  compendium_categories_get                 Returns data related to a compendium category.                         */
/*  compendium_categories_list                Fetches a list of compendium categories.                               */
/*  compendium_categories_add                 Creates a new compendium category.                                     */
/*  compendium_categories_edit                Modifies an existing compendium category.                              */
/*  compendium_categories_delete              Deletes an existing compendium category.                               */
/*                                                                                                                   */
/*  compendium_eras_get                       Returns data related to a compendium era.                              */
/*  compendium_eras_list                      Fetches a list of compendium eras.                                     */
/*  compendium_eras_add                       Creates a new compendium era.                                          */
/*  compendium_eras_edit                      Modifies an existing compendium era.                                   */
/*  compendium_eras_delete                    Deletes an existing compendium era.                                    */
/*                                                                                                                   */
/*  compendium_search                         Returns the result of a search through all compendium content.         */
/*                                                                                                                   */
/*  compendium_page_history_get               Returns data related to an entry in a compendium page's history.       */
/*  compendium_page_history_list              Returns data related to a compendium page's history entry.             */
/*  compendium_page_history_edit              Modifies an existing compendium page's history entry.                  */
/*  compendium_page_history_delete            Hard deletes an existing compendium page's history entry.              */
/*                                                                                                                   */
/*  compendium_admin_notes_get                Fetches the admin notes.                                               */
/*  compendium_admin_notes_edit               Modifies the admin notes.                                              */
/*                                                                                                                   */
/*  compendium_pages_list_years               Fetches the years at which compendium pages have been created.         */
/*  compendium_images_list_years              Fetches the years in which compendium images have been uploaded.       */
/*  compendium_appearance_list_years          Fetches the years at which compendium content has appeared.            */
/*  compendium_peak_list_years                Fetches the years at which compendium content has peaked.              */
/*                                                                                                                   */
/*  compendium_stats_list                     Returns stats related to the compendium.                               */
/*  compendium_stats_recalculate_all          Recalculates stats for all compendium pages.                           */
/*                                                                                                                   */
/*  compendium_format_url                     Formats a compendium page url.                                         */
/*  compendium_format_title                   Formats a compendium page title.                                       */
/*  compendium_format_image_name              Formats a compendium image name.                                       */
/*  compendium_nbcodes_apply                  Applies NBCodes to a string.                                           */
/*                                                                                                                   */
/*  compendium_find_images_in_entry           Puts the name of all images within a compendium entry in an array.     */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns data related to a compendium page.
 *
 * @param   int         $page_id    (OPTIONAL)  The page's id. Only one of these two parameters should be set.
 * @param   string      $page_url   (OPTIONAL)  The page's url. Only one of these two parameters should be set.
 * @param   bool        $no_loops   (OPTIONAL)  If false, page data will be returned even if it is a redirect loop.
 * @param   string      $format     (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array|null                          An array containing page related data, or NULL if it does not exist.
 */

function compendium_pages_get(  int     $page_id  = 0       ,
                                string  $page_url = ''      ,
                                bool    $no_loops = true    ,
                                string  $format   = 'html'  ) : mixed
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Get the user's current language, access rights, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = user_is_administrator();
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Sanitize the data
  $page_id  = sanitize($page_id, 'int', 0);
  $page_url = sanitize($page_url, 'string');

  // Return null if both parameters are missing
  if(!$page_id && !$page_url)
    return NULL;

  // Return null if both parameters are set
  if($page_id && $page_url)
    return NULL;

  // Check if the page exists
  if($page_id && !database_row_exists('compendium_pages', $page_id))
    return NULL;
  if($page_url && !database_entry_exists('compendium_pages', 'page_url', $page_url))
    return NULL;

  // Prepare the correct condition for the query
  if($page_id)
    $where = " compendium_pages.id = '$page_id' ";
  if($page_url)
    $where = " compendium_pages.page_url LIKE '$page_url' ";

  // Fetch the data
  $dpage = mysqli_fetch_array(query(" SELECT    compendium_pages.id                       AS 'p_id'           ,
                                                compendium_pages.is_deleted               AS 'p_deleted'      ,
                                                compendium_pages.is_draft                 AS 'p_draft'        ,
                                                compendium_pages.created_at               AS 'p_created'      ,
                                                compendium_pages.page_url                 AS 'p_url'          ,
                                                compendium_pages.title_$lang              AS 'p_title'        ,
                                                compendium_pages.title_en                 AS 'p_title_en'     ,
                                                compendium_pages.title_fr                 AS 'p_title_fr'     ,
                                                compendium_pages.redirection_$lang        AS 'p_redirect'     ,
                                                compendium_pages.redirection_en           AS 'p_redirect_en'  ,
                                                compendium_pages.redirection_fr           AS 'p_redirect_fr'  ,
                                                compendium_pages.is_external_redirection  AS 'p_redirect_ext' ,
                                                compendium_pages.year_appeared            AS 'p_new_year'     ,
                                                compendium_pages.month_appeared           AS 'p_new_month'    ,
                                                compendium_pages.year_peak                AS 'p_peak_year'    ,
                                                compendium_pages.month_peak               AS 'p_peak_month'   ,
                                                compendium_pages.is_nsfw                  AS 'p_nsfw'         ,
                                                compendium_pages.is_gross                 AS 'p_gross'        ,
                                                compendium_pages.is_offensive             AS 'p_offensive'    ,
                                                compendium_pages.title_is_nsfw            AS 'p_nsfw_title'   ,
                                                compendium_pages.summary_$lang            AS 'p_summary'      ,
                                                compendium_pages.summary_en               AS 'p_summary_en'   ,
                                                compendium_pages.summary_fr               AS 'p_summary_fr'   ,
                                                compendium_pages.definition_$lang         AS 'p_body'         ,
                                                compendium_pages.definition_en            AS 'p_body_en'      ,
                                                compendium_pages.definition_fr            AS 'p_body_fr'      ,
                                                compendium_pages.admin_notes              AS 'p_admin_notes'  ,
                                                compendium_pages.admin_urls               AS 'p_admin_urls'   ,
                                                compendium_eras.id                        AS 'pe_id'          ,
                                                compendium_eras.name_$lang                AS 'pe_name'        ,
                                                compendium_eras.name_en                   AS 'pe_name_en'     ,
                                                compendium_eras.name_fr                   AS 'pe_name_fr'     ,
                                                compendium_types.id                       AS 'pt_id'          ,
                                                compendium_types.name_$lang               AS 'pt_name'        ,
                                                compendium_types.name_en                  AS 'pt_name_en'     ,
                                                compendium_types.full_name_$lang          AS 'pt_display'     ,
                                                compendium_types.full_name_en             AS 'pt_full_en'     ,
                                                compendium_types.full_name_fr             AS 'pt_full_fr'
                                      FROM      compendium_pages
                                      LEFT JOIN compendium_types
                                      ON        compendium_pages.fk_compendium_types  = compendium_types.id
                                      LEFT JOIN compendium_eras
                                      ON        compendium_pages.fk_compendium_eras   = compendium_eras.id
                                      WHERE     $where "));

  // Format the data
  $page_id                = $dpage['p_id'];
  $page_id_sanitized      = sanitize($dpage['p_id'], 'int', 0);
  $page_deleted           = $dpage['p_deleted'];
  $page_draft             = $dpage['p_draft'];
  $page_created_on        = $dpage['p_created'];
  $page_url               = $dpage['p_url'];
  $page_title             = $dpage['p_title'];
  $page_title_en          = $dpage['p_title_en'];
  $page_title_fr          = $dpage['p_title_fr'];
  $page_redirect          = $dpage['p_redirect'];
  $page_redirect_en       = $dpage['p_redirect_en'];
  $page_redirect_fr       = $dpage['p_redirect_fr'];
  $page_redirect_ext      = $dpage['p_redirect_ext'];
  $page_appeared_year     = $dpage['p_new_year'];
  $page_appeared_month    = $dpage['p_new_month'];
  $page_peaked_year       = $dpage['p_peak_year'];
  $page_peaked_month      = $dpage['p_peak_month'];
  $page_content_warning   = ($dpage['p_nsfw'] || $dpage['p_offensive'] || $dpage['p_gross'] || $dpage['p_nsfw_title']);
  $page_nsfw              = $dpage['p_nsfw'];
  $page_offensive         = $dpage['p_offensive'];
  $page_gross             = $dpage['p_gross'];
  $page_nsfw_title        = $dpage['p_nsfw_title'];
  $page_summary           = $dpage['p_summary'];
  $page_summary_en        = $dpage['p_summary_en'];
  $page_summary_fr        = $dpage['p_summary_fr'];
  $page_body              = $dpage['p_body'];
  $page_body_en           = $dpage['p_body_en'];
  $page_body_fr           = $dpage['p_body_fr'];
  $page_admin_notes       = $dpage['p_admin_notes'];
  $page_admin_urls        = $dpage['p_admin_urls'];
  $page_type_id           = $dpage['pt_id'];
  $page_type_name         = $dpage['pt_name'];
  $page_type_name_en      = $dpage['pt_name_en'];
  $page_type_full_name    = $dpage['pt_display'];
  $page_type_full_name_en = $dpage['pt_full_en'];
  $page_type_full_name_fr = $dpage['pt_full_fr'];
  $page_era_id            = $dpage['pe_id'];
  $page_era_name          = $dpage['pe_name'];
  $page_era_name_en       = $dpage['pe_name_en'];
  $page_era_name_fr       = $dpage['pe_name_fr'];

  // Prepare the data for display
  if($format === 'html')
  {
    // Return null if the page should not be displayed
    if(!$is_admin && $page_deleted)
      return NULL;
    if(!$is_admin && $page_draft)
      return NULL;

    // Assemble an array with the data
    $data['id']         = sanitize_output($page_id);
    $data['deleted']    = $page_deleted;
    $data['draft']      = $page_draft;
    $data['url']        = sanitize_output($page_url);
    $data['url_raw']    = $page_url;
    $data['no_page']    = ($page_title) ? 0 : 1;
    $title_size         = (strlen($page_title) > 25) ? 'h2' : 'h1';
    $title_size         = (strlen($page_title) > 30) ? 'h3' : $title_size;
    $title_size         = (strlen($page_title) > 40) ? 'h4' : $title_size;
    $data['title_size'] = (strlen($page_title) > 50) ? 'h5' : $title_size;
    $data['title']      = sanitize_output($page_title);
    $data['title_en']   = sanitize_output($page_title_en);
    $data['title_fr']   = sanitize_output($page_title_fr);
    $data['titleenraw'] = $page_title_en;
    $data['titlefrraw'] = $page_title_fr;
    $data['redir_en']   = sanitize_output($page_redirect_en);
    $data['redir_fr']   = sanitize_output($page_redirect_fr);
    $data['redir_ext']  = sanitize_output($page_redirect_ext);
    $appeared_month     = ($page_appeared_month) ? __('month_'.$page_appeared_month, spaces_after: 1) : '';
    $data['appeared']   = ($page_appeared_year) ? $appeared_month.$page_appeared_year : '';
    $data['app_year']   = sanitize_output($page_appeared_year);
    $data['app_month']  = sanitize_output($page_appeared_month);
    $peak_month         = ($page_peaked_month) ? __('month_'.$page_peaked_month, spaces_after: 1) : '';
    $data['peak']       = ($page_peaked_year) ? $peak_month.$page_peaked_year : '';
    $data['peak_year']  = sanitize_output($page_peaked_year);
    $data['peak_month'] = sanitize_output($page_peaked_month);
    $data['nsfw']       = sanitize_output($page_nsfw);
    $data['offensive']  = sanitize_output($page_offensive);
    $data['gross']      = sanitize_output($page_gross);
    $data['nsfw_title'] = sanitize_output($page_nsfw_title);
    $data['blur_title'] = (($nsfw < 1) && $page_nsfw_title) ? 1 : 0;
    $data['meta_desc']  = string_truncate(nbcodes_remove($page_summary_en), 250, '...');
    $data['summary']    = sanitize_output($page_summary);
    $data['summary_en'] = sanitize_output($page_summary_en);
    $data['summary_fr'] = sanitize_output($page_summary_fr);
    $data['body']       = nbcodes(sanitize_output($page_body, preserve_line_breaks: true),
                                  page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
    $data['body_en']    = sanitize_output($page_body_en);
    $data['body_fr']    = sanitize_output($page_body_fr);
    $data['bodyenraw']  = $page_body_en;
    $data['bodyfrraw']  = $page_body_fr;
    $data['admin_note'] = sanitize_output($page_admin_notes);
    $data['admin_urls'] = sanitize_output($page_admin_urls);
    $data['type_id']    = sanitize_output($page_type_id);
    $data['type']       = sanitize_output($page_type_name);
    $data['type_en']    = sanitize_output($page_type_name_en);
    $data['type_full']  = sanitize_output(string_change_case($page_type_full_name, 'lowercase'));
    $data['era_id']     = sanitize_output($page_era_id);
    $data['era']        = sanitize_output($page_era_name);
  }

  // Prepare the data for the API
  else if($format === 'api')
  {
    // Do not show deleted or unpublished pages in the API
    if($page_deleted || $page_draft)
      return NULL;

    // Core page data
    $data['page']['id']   = (string)$page_id;
    $data['page']['url']  = sanitize_json($page_url);
    $data['page']['link'] = sanitize_json($GLOBALS['website_url'].'pages/compendium/'.$page_url);

    // Redirection data
    if($page_redirect_en || $page_redirect_fr || $page_redirect_ext)
    {
      $data['page']['redirects_to']['target_is_a_page_url'] = (bool)!$page_redirect_ext;
      $data['page']['redirects_to']['url_en']               = sanitize_json($page_redirect_en) ?: NULL;
      $data['page']['redirects_to']['url_fr']               = sanitize_json($page_redirect_fr) ?: NULL;
    }
    else
      $data['page']['redirects_to'] = NULL;

    // Page title
    $data['page']['title_en'] = sanitize_json($page_title_en) ?: NULL;
    $data['page']['title_fr'] = sanitize_json($page_title_fr) ?: NULL;

    // Content warnings
    if($page_content_warning)
    {
      $data['page']['content_warnings']['title_is_nsfw']      = (bool)($page_nsfw_title);
      $data['page']['content_warnings']['not_safe_for_work']  = (bool)($page_nsfw);
      $data['page']['content_warnings']['offensive']          = (bool)($page_offensive);
      $data['page']['content_warnings']['gross']              = (bool)($page_gross);
    }
    else
      $data['page']['content_warnings'] = NULL;

    // Page data
    $data['page']['first_appeared_year']    = (int)$page_appeared_year ?: NULL;
    $data['page']['first_appeared_month']   = (int)$page_appeared_month ?: NULL;
    $data['page']['peak_popularity_year']   = (int)$page_peaked_year ?: NULL;
    $data['page']['peak_popularity_month']  = (int)$page_peaked_month ?: NULL;
    $data['page']['summary_en']             = sanitize_json(nbcodes_remove($page_summary_en)) ?: NULL;
    $data['page']['summary_fr']             = sanitize_json(nbcodes_remove($page_summary_fr)) ?: NULL;
    $data['page']['contents_en']            = sanitize_json(nbcodes_remove($page_body_en)) ?: NULL;
    $data['page']['contents_fr']            = sanitize_json(nbcodes_remove($page_body_fr)) ?: NULL;

    // Page type data
    if($page_type_id)
    {
      $data['page']['type']['id']       = (string)$page_type_id;
      $data['page']['type']['name_en']  = sanitize_json($page_type_full_name_en);
      $data['page']['type']['name_fr']  = sanitize_json($page_type_full_name_fr);
    }
    else
      $data['page']['type'] = NULL;

    // Era data
    if($page_era_id)
    {
      $data['page']['era']['id']      = (string)$page_era_id;
      $data['page']['era']['name_en'] = sanitize_json($page_era_name_en);
      $data['page']['era']['name_fr'] = sanitize_json($page_era_name_fr);
    }
    else
      $data['page']['era'] = NULL;
  }

  // Fetch the latest update
  $dupdate = mysqli_fetch_array(query(" SELECT    compendium_pages_history.edited_at AS 'ph_time'
                                        FROM      compendium_pages_history
                                        WHERE     compendium_pages_history.fk_compendium_pages = '$page_id_sanitized'
                                        ORDER BY  compendium_pages_history.edited_at DESC
                                        LIMIT     1 "));

  // Format the update data
  $last_updated_on = $dupdate['ph_time'] ?? NULL;

  // Prepare the data for display
  if($format === 'html')
  {
    $latest_update    = (isset($last_updated_on) && $last_updated_on) ? $last_updated_on : $page_created_on;
    $data['updated']  = ($latest_update)
                      ? sanitize_output(string_change_case(time_since($latest_update), 'lowercase'))
                      : __('error');
  }

  // Fetch any associated categories
  $qcategories = query("  SELECT    compendium_pages_categories.id    AS 'cpc_id'     ,
                                    compendium_categories.id          AS 'pc_id'      ,
                                    compendium_categories.name_$lang  AS 'pc_name'    ,
                                    compendium_categories.name_en     AS 'pc_name_en' ,
                                    compendium_categories.name_fr     AS 'pc_name_fr'
                          FROM      compendium_pages_categories
                          LEFT JOIN compendium_categories
                          ON        compendium_pages_categories.fk_compendium_categories  = compendium_categories.id
                          WHERE     compendium_pages_categories.fk_compendium_pages       = '$page_id_sanitized'
                          ORDER BY  compendium_categories.display_order ASC ");

  // Prepare the category data
  for($i = 0; $row = mysqli_fetch_array($qcategories); $i++)
  {
    // Format the category data
    $category_id      = $row['pc_id'];
    $category_name    = $row['pc_name'];
    $category_name_en = $row['pc_name_en'];
    $category_name_fr = $row['pc_name_fr'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data['category_id'][$i]    = sanitize_output($category_id);
      $data['category_name'][$i]  = sanitize_output($category_name);
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      $data['page']['categories'][$i]['id']       = (string)$category_id;
      $data['page']['categories'][$i]['name_en']  = sanitize_json($category_name_en);
      $data['page']['categories'][$i]['name_fr']  = sanitize_json($category_name_fr);
    }
  }

  // Show that there are no categories in the API if necessary
  if(!$i)
    $data['page']['categories'] = NULL;

  // Add the number of categories do the data
  if($format === 'html')
    $data['categories'] = $i;

  // Add the creation and latest modification data to the API
  if($format === 'api')
  {
    // Creation data
    if($page_created_on)
    {
      $page_created_on_aware_datetime = date_to_aware_datetime($page_created_on);
      $data['page']['created_at']['datetime'] = $page_created_on_aware_datetime['datetime'];
      $data['page']['created_at']['timezone'] = $page_created_on_aware_datetime['timezone'];
    }
    else
      $data['page']['created_at'] = NULL;

    // Latest update data
    if($last_updated_on)
    {
      $page_updated_on_aware_datetime = date_to_aware_datetime($last_updated_on);
      $data['page']['last_updated_at']['datetime']  = $page_updated_on_aware_datetime['datetime'];
      $data['page']['last_updated_at']['timezone']  = $page_updated_on_aware_datetime['timezone'];
    }
    else
      $data['page']['last_updated_at'] = NULL;
  }

  // If the page is a redirection to another compendium page, check whether it is a legal redirection
  if($page_redirect && $no_loops && $format === 'html')
  {
    // Sanitize the redirection
    $redirect_page = sanitize($page_redirect, 'string');

    // If the redirection is to a page external to the compendium, skip the checks
    if($page_redirect_ext)
      $data['redirect'] = ($format === 'html') ? $redirect_page : NULL;

    // Check if the redirection is a valid page url
    else if(database_entry_exists('compendium_pages', 'page_url', $redirect_page))
    {
      // Check if the redirection is a redirection
      $dredirect = mysqli_fetch_array(query(" SELECT  compendium_pages.id                 AS 'p_redir_id' ,
                                                      compendium_pages.redirection_$lang  AS 'p_redirect'
                                              FROM    compendium_pages
                                              WHERE   compendium_pages.page_url LIKE '$redirect_page' "));

      // Return null if the redirection is a redirection
      if($dredirect['p_redirect'])
        return NULL;

      // Otherwise add the redirection's ID and url to the returned data
      $data['redirect']     = $redirect_page;
      $data['redirect_id']  = $dredirect['p_redir_id'];
    }

    // If the redirection is not a page url, look up whether it is a valid page name
    else
    {
      // Stop here if the page name is not valid
      if(!database_entry_exists('compendium_pages', 'title_'.$lang, $redirect_page))
        return NULL;

      // Check if the redirection is a redirection
      $dredirect = mysqli_fetch_array(query(" SELECT  compendium_pages.page_url           AS 'p_url' ,
                                                      compendium_pages.redirection_$lang  AS 'p_redirect'
                                              FROM    compendium_pages
                                              WHERE   compendium_pages.title_$lang LIKE '$redirect_page' "));

      // Return null if the redirection is a redirection
      if($dredirect['p_redirect'])
        return NULL;

      // Otherwise add the redirection's url to the returned data
      $data['redirect'] = sanitize_output($dredirect['p_url']);
    }
  }

  // Return the data
  return $data;
}




/**
 * Returns data related to a random compendium page.
 *
 * @param   int     $exclude_id           (OPTIONAL)  A page id to exclude from the pages being fetched.
 * @param   int     $type                 (OPTIONAL)  Request a specific page type for the randomly returned page.
 * @param   bool    $include_nsfw         (OPTIONAL)  Include the possibility of returning pages with content warnings.
 * @param   string  $language             (OPTIONAL)  Only return pages with a title in the selected language.
 * @param   bool    $include_redirections (OPTIONAL)  Include the possibility of returning a redirection page.
 *
 * @return  string                                    The url of a randomly chosen compendium page.
 */

function compendium_pages_get_random( int     $exclude_id           = 0     ,
                                      int     $type                 = 0     ,
                                      mixed   $include_nsfw         = false ,
                                      string  $language             = NULL  ,
                                      mixed   $include_redirections = false ) : string
{
  // Sanitize the search parameters
  $exclude_id           = sanitize($exclude_id, 'int', 0);
  $type                 = sanitize($type, 'string');
  $include_nsfw         = sanitize($include_nsfw, 'bool');
  $language             = sanitize($language, 'string');
  $include_redirections = sanitize($include_redirections, 'bool');

  // Get the user's current language and set the language search variable
  $language = ($language === 'fr' || $language === 'en' || $language == 'all') ? $language : '';
  $lang     = ($language) ?: sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Add the excluded id if necessary
  $query_exclude = ($exclude_id) ? " AND compendium_pages.id != '$exclude_id' " : " ";

  // Prepare the page type condition
  $query_type = ($type) ? " AND compendium_pages.fk_compendium_types = '$type' " : " ";

  // Add NSFW pages if necessary
  $query_nsfw = (!$include_nsfw) ?  " AND compendium_pages.is_nsfw      = 0
                                      AND compendium_pages.is_gross     = 0
                                      AND compendium_pages.is_offensive = 0
                                      AND compendium_pages.is_offensive = 0 " : " ";

  // Add a language filter if necessary
  $query_language = ($language != 'all') ? " AND compendium_pages.title_$lang NOT LIKE '' " : " ";

  // Exclude redirections if necessary
  if(!$include_redirections && $language != 'all')
    $query_redirect = " AND compendium_pages.redirection_$lang LIKE '' ";
  else if(!$include_redirections)
    $query_redirect = " AND compendium_pages.redirection_en LIKE ''
                        AND compendium_pages.redirection_fr LIKE '' ";
  else
    $query_redirect = '';

  // Fetch a random page's url
  $dpage = mysqli_fetch_array(query(" SELECT    compendium_pages.page_url AS 'c_url'
                                      FROM      compendium_pages
                                      WHERE     compendium_pages.is_deleted         = 0
                                      AND       compendium_pages.is_draft           = 0
                                                $query_exclude
                                                $query_type
                                                $query_nsfw
                                                $query_language
                                                $query_redirect
                                      ORDER BY  RAND()
                                      LIMIT     1 "));

  // If no page has been found, return an empty string
  if(!isset($dpage['c_url']))
    return '';

  // Otherwise, return the page url
  return $dpage['c_url'];
}




/**
 * Fetches a list of compendium pages.
 *
 * @param   string  $sort_by    (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search     (OPTIONAL)  Search for specific field values.
 * @param   array   $limit      (OPTIONAL)  Return a limited amount of pages.
 * @param   bool    $user_view  (OPTIONAL)  Views the list as a regular user even if the account is an administrator.
 * @param   string  $format     (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                           An array containing compendium pages.
 */

function compendium_pages_list( string  $sort_by    = 'date'    ,
                                array   $search     = array()   ,
                                int     $limit      = 0         ,
                                bool    $user_view  = false     ,
                                string  $format     = 'html'    ) : array
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Get the user's current language, access rights, settings, and the compendium pages which they can access
  $lang       = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $otherlang  = ($lang === 'en') ? 'fr' : 'en';
  $is_admin   = ($user_view) ? 0 : user_is_administrator();
  $nsfw       = user_settings_nsfw();
  $privacy    = user_settings_privacy();
  $mode       = user_get_mode();
  $pages      = compendium_pages_list_urls();

  // Sanitize the search parameters
  $search_url         = sanitize_array_element($search, 'url', 'string');
  $search_translation = sanitize_array_element($search, 'translation', 'int', min: -2, max: 2, default: 0);
  $search_title       = sanitize_array_element($search, 'title', 'string');
  $search_title_en    = sanitize_array_element($search, 'title_en', 'string');
  $search_title_fr    = sanitize_array_element($search, 'title_fr', 'string');
  $search_redirect    = sanitize_array_element($search, 'redirect', 'int', min: -1, max: 1, default: 0);
  $search_incredir    = sanitize_array_element($search, 'include_redirections', 'bool', default: false);
  $search_redirname   = sanitize_array_element($search, 'redirname', 'string');
  $search_no_nsfw     = sanitize_array_element($search, 'exclude_nsfw', 'bool', default: false);
  $search_nsfw        = sanitize_array_element($search, 'nsfw', 'int', min: -1, max: 1, default: -1);
  $search_gross       = sanitize_array_element($search, 'gross', 'int', min: -1, max: 1, default: -1);
  $search_offensive   = sanitize_array_element($search, 'offensive', 'int', min: -1, max: 1, default: -1);
  $search_nsfw_title  = sanitize_array_element($search, 'nsfw_title', 'int', min: -1, max: 1, default: -1);
  $search_type        = sanitize_array_element($search, 'type', 'int', min: -1, default: 0);
  $search_era         = sanitize_array_element($search, 'era', 'int', min: -1, default: 0);
  $search_category    = sanitize_array_element($search, 'category', 'int', min: -2, default: 0);
  $search_language    = sanitize_array_element($search, 'language', 'string');
  $search_summary     = sanitize_array_element($search, 'summary', 'string');
  $search_body_en     = sanitize_array_element($search, 'body_en', 'string');
  $search_body_fr     = sanitize_array_element($search, 'body_fr', 'string');
  $search_appeared    = sanitize_array_element($search, 'appeared', 'int', min: 0, max: date('Y'), default: 0);
  $search_peaked      = sanitize_array_element($search, 'peaked', 'int', min: 0, max: date('Y'), default: 0);
  $search_created     = sanitize_array_element($search, 'created', 'int', min: 0, max: date('Y'), default: 0);
  $search_nsfw_admin  = sanitize_array_element($search, 'nsfw_admin', 'string');
  $search_wip         = sanitize_array_element($search, 'wip', 'string');
  $search_notes       = sanitize_array_element($search, 'notes', 'int', min: 0, max: 1, default: 0);

  // Forbid some searches if the user is not an admin
  if($format === 'html' && !$is_admin)
  {
    $search_url         = '';
    $search_translation = 0;
    $search_redirect    = 0;
    $search_redirname   = '';
    $search_language    = '';
    $search_summary     = '';
    $search_nsfw_admin  = '';
    $search_wip         = '';
    $search_notes       = 0;
  }

  // Do not show deleted pages, drafts, or redirections to regular users and only show them pages in their own language
  $query_search = ($format === 'html' && !$is_admin) ? "  WHERE compendium_pages.is_deleted         = 0
                                                          AND   compendium_pages.is_draft           = 0
                                                          AND   compendium_pages.redirection_$lang  = ''
                                                          AND   compendium_pages.title_$lang       != '' "
                                                      : " WHERE 1 = 1 ";

  // Do not show deleted pages and drafts in the API
  $query_search .= ($format === 'api') ? "  AND compendium_pages.is_deleted   = 0
                                            AND compendium_pages.is_draft     = 0 " : " ";

  // Search through the data: Language
  $query_search .= match($search_language)
  {
    'monolingual' => "  AND ( compendium_pages.title_en   = ''
                        OR    compendium_pages.title_fr   = '' )  " ,
    'bilingual'   => "  AND   compendium_pages.title_en  != ''
                        AND   compendium_pages.title_fr  != ''    " ,
    'english'     => "  AND   compendium_pages.title_en  != ''    " ,
    'french'      => "  AND   compendium_pages.title_fr  != ''    " ,
    default       => ""                                             ,
  };

  // Search through the data: Summary
  $query_search .= match($search_summary)
  {
    'none'        => "  AND (   compendium_pages.summary_en   = ''
                        AND     compendium_pages.summary_fr   = '' )    " ,
    'monolingual' => "  AND ( ( compendium_pages.summary_en   = ''
                        AND     compendium_pages.summary_fr  != '' )
                        OR  (   compendium_pages.summary_en  != ''
                        AND     compendium_pages.summary_fr   = '' ) )  " ,
    'bilingual'   => "  AND     compendium_pages.summary_en  != ''
                        AND     compendium_pages.summary_fr  != ''      " ,
    default       => ""                                                   ,
  };

  // Search through the data: Translations
  $query_search .= match($search_translation)
  {
    -2      => "  AND   compendium_pages.title_en           = ''
                  AND   compendium_pages.title_fr           = ''    " ,
    -1      => "  AND   compendium_pages.title_$lang        = ''
                  AND ( compendium_pages.title_en          != ''
                  OR    compendium_pages.title_fr          != '' )  " ,
    1       => "  AND   compendium_pages.title_$lang       != ''    " ,
    2       => "  AND ( compendium_pages.title_$lang       != ''
                  OR    compendium_pages.title_$otherlang  != '' )  " ,
    default => ""                                                     ,
  };

  // Search through the data: Body
  if($search_body_en && (mb_strlen($search_body_en) >= 4))
    $query_search .= "  AND ( compendium_pages.summary_en     LIKE '%$search_body_en%'
                        OR    compendium_pages.definition_en  LIKE '%$search_body_en%' ) ";
  if($search_body_fr && (mb_strlen($search_body_fr) >= 4))
    $query_search .= "  AND ( compendium_pages.summary_en     LIKE '%$search_body_fr%'
                        OR    compendium_pages.definition_en  LIKE '%$search_body_fr%' ) ";

  // Search through the data: Page title
  if($search_title === 'exists' && $is_admin)
    $query_search .= "  AND   compendium_pages.title_$lang      !=    '' ";
  else if($search_title)
    $query_search .= "  AND   compendium_pages.title_$lang      LIKE  '%$search_title%'
                        OR  ( compendium_pages.title_$lang      =     ''
                        AND   compendium_pages.title_$otherlang LIKE  '%$search_title%' ) ";
  if($search_title_en)
    $query_search .= "  AND   compendium_pages.title_en         LIKE  '%$search_title_en%' ";
  if($search_title_fr)
    $query_search .= "  AND   compendium_pages.title_fr         LIKE  '%$search_title_fr%' ";

  // Search through the data: Redirections
  if($search_redirect === -1)
    $query_search .= "  AND ( compendium_pages.title_$lang             != ''
                        OR    compendium_pages.title_$otherlang        != '' )
                        AND   compendium_pages.redirection_$lang        = '' ";
  else if($search_redirect === 1)
    $query_search .= "  AND ( compendium_pages.redirection_$lang       != ''
                        OR    compendium_pages.title_$lang              = ''
                        AND   compendium_pages.redirection_$otherlang  != '' ) ";
  if($search_redirname)
    $query_search .= "  AND   compendium_pages.redirection_$lang     LIKE '%$search_redirname%' ";
  if($format === 'api' && !$search_incredir)
    $query_search .= "  AND ( compendium_pages.redirection_en           = ''
                        OR   compendium_pages.redirection_fr            = '' ) ";

  // Search through the data: Page types
  if($search_type === -1)
    $query_search .= " AND compendium_pages.fk_compendium_types  = 0               ";
  else if($search_type)
    $query_search .= " AND compendium_pages.fk_compendium_types  = '$search_type'  ";

  // Search through the data: Cultural eras
  if($search_era === -1)
    $query_search .= " AND compendium_pages.fk_compendium_eras = 0             ";
  else if($search_era)
    $query_search .= " AND compendium_pages.fk_compendium_eras = '$search_era' ";

  // Search through the data: Categories
  if($search_category > 0)
    $query_search .= " AND compendium_pages_categories.fk_compendium_categories  = '$search_category' ";
  else if($search_category === -1)
    $query_search .= " AND compendium_pages_categories.fk_compendium_categories  IS NULL              ";
  else if($search_category === -2)
    $query_search .= " AND compendium_pages_categories.fk_compendium_categories  IS NOT NULL          ";

  // Search through the data: Content warnings
  if($search_nsfw_admin === 'nsfw')
    $query_search .= "  AND ( compendium_pages.title_is_nsfw  = 1
                        OR    compendium_pages.is_nsfw        = 1
                        OR    compendium_pages.is_gross       = 1
                        OR    compendium_pages.is_offensive   = 1 ) ";
  else if($search_nsfw_admin === 'safe' || $search_no_nsfw)
    $query_search .= "  AND   compendium_pages.title_is_nsfw  = 0
                        AND   compendium_pages.is_nsfw        = 0
                        AND   compendium_pages.is_gross       = 0
                        AND   compendium_pages.is_offensive   = 0 ";
  else if($search_nsfw_admin === 'title')
    $query_search .= "  AND   compendium_pages.title_is_nsfw  = 1 ";
  else if($search_nsfw_admin === 'page')
    $query_search .= "  AND   compendium_pages.is_nsfw        = 1 ";
  else if($search_nsfw_admin === 'gross')
    $query_search .= "  AND   compendium_pages.is_gross       = 1 ";
  else if($search_nsfw_admin === 'offensive')
    $query_search .= "  AND   compendium_pages.is_offensive   = 1 ";

  // Search through the data: Unpublished content
  if($search_wip === 'draft')
    $query_search .= "  AND compendium_pages.is_draft   = 1 ";
  else if($search_wip === 'deleted')
    $query_search .= "  AND compendium_pages.is_deleted = 1 ";
  else if($search_wip === 'finished')
    $query_search .= "  AND compendium_pages.is_draft   = 0
                        AND compendium_pages.is_deleted = 0 ";

  // Search through the data: Other searches
  $query_search .= ($search_url)              ? " AND compendium_pages.page_url    LIKE '%$search_url%'       " : "";
  $query_search .= ($search_nsfw > -1)        ? " AND compendium_pages.is_nsfw        = '$search_nsfw'        " : "";
  $query_search .= ($search_gross > -1)       ? " AND compendium_pages.is_gross       = '$search_gross'       " : "";
  $query_search .= ($search_offensive > -1)   ? " AND compendium_pages.is_offensive   = '$search_offensive'   " : "";
  $query_search .= ($search_nsfw_title > -1)  ? " AND compendium_pages.title_is_nsfw  = '$search_nsfw_title'  " : "";
  $query_search .= ($search_appeared)         ? " AND compendium_pages.year_appeared  = '$search_appeared'    " : "";
  $query_search .= ($search_peaked)           ? " AND compendium_pages.year_peak      = '$search_peaked'      " : "";
  $query_search .= ($search_created)          ? " AND
                                     YEAR(FROM_UNIXTIME(compendium_pages.created_at)) = '$search_created'     " : "";
  $query_search .= ($search_notes)            ? " AND ( compendium_pages.admin_notes != ''
                                                  OR    compendium_pages.admin_urls  != '' )                  " : "";

  // Forbid some sorting orders if the user is not an admin
  $forbidden_sorts = array('url', 'redirect', 'categories', 'pageviews', 'pageviews_r', 'language', 'summary', 'nsfw', 'wip', 'chars_en', 'chars_en_r', 'chars_fr', 'chars_fr_r', 'seen', 'seen_r');
  if(!$is_admin && $format === 'html' && in_array($sort_by, $forbidden_sorts))
    $sort_by = '';

  // Forbid other sorting orders when using the API
  $forbidden_sorts = array('title', 'redirect', 'theme', 'categories', 'era', 'appeared_desc', 'peak', 'peak_desc', 'created', 'created_r', 'pageviews', 'pageviews_r', 'language', 'summary', 'nsfw', 'wip', 'chars_en', 'chars_en_r', 'chars_fr', 'chars_fr_r', 'seen', 'seen_r');
  if($format === 'api' && in_array($sort_by, $forbidden_sorts))
    $sort_by = '';

  // Create some aliases
  $sort_by = ($sort_by === 'appeared_reverse')  ? 'appeared_desc' : $sort_by;
  $sort_by = ($sort_by === 'peaked')            ? 'peak'          : $sort_by;
  $sort_by = ($sort_by === 'peaked_reverse')    ? 'peak_desc'     : $sort_by;

  // Sort the data
  $query_sort = match($sort_by)
  {
    'url'           => "  ORDER BY    compendium_pages.page_url               ASC                 " ,
    'title'         => "  ORDER BY    compendium_pages.title_$lang            = ''                ,
                                      compendium_pages.title_$lang            ASC                 ,
                                      compendium_pages.title_$otherlang       = ''                ,
                                      compendium_pages.title_$otherlang       ASC                 " ,
    'redirect'      => "  ORDER BY    compendium_pages.redirection_$lang      = ''                ,
                                      compendium_pages.redirection_$lang      ASC                 ,
                                      compendium_pages.redirection_$otherlang = ''                ,
                                      compendium_pages.redirection_$otherlang ASC                 ,
                                      compendium_pages.page_url               ASC                 " ,
    'theme'         => "  ORDER BY    compendium_types.id                     IS NULL             ,
                                      compendium_types.name_en                != 'meme'           ,
                                      compendium_types.name_en                != 'definition'     ,
                                      compendium_types.name_en                != 'sociocultural'  ,
                                      compendium_types.name_en                ASC                 ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'categories'    => "  ORDER BY    compendium_pages_categories.id          IS NULL             ,
                                      COUNT(compendium_pages_categories.id)   DESC                ,
                                      compendium_pages.page_url               ASC                 " ,
    'era'           => "  ORDER BY    compendium_eras.id                      IS NULL             ,
                                      compendium_eras.year_start              DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'appeared'      => "  ORDER BY    compendium_pages.year_appeared          DESC                ,
                                      compendium_pages.month_appeared         DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'appeared_desc' => "  ORDER BY    compendium_pages.year_appeared          = 0                 ,
                                      compendium_pages.year_appeared          ASC                 ,
                                      compendium_pages.month_appeared         ASC                 ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'peak'          => "  ORDER BY    compendium_pages.year_peak              DESC                ,
                                      compendium_pages.month_peak             DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'peak_desc'     => "  ORDER BY    compendium_pages.year_peak              = 0                 ,
                                      compendium_pages.year_peak              ASC                 ,
                                      compendium_pages.month_peak             ASC                 ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'created'       => "  ORDER BY    compendium_pages.created_at             DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'created_r'     => "  ORDER BY    compendium_pages.created_at             ASC                 ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'language'      => "  ORDER BY  ( compendium_pages.title_en               != ''
                          AND         compendium_pages.title_fr               != '' )             ,
                                      compendium_pages.title_en               = ''                ,
                                      compendium_pages.title_fr               = ''                ,
                                      compendium_pages.page_url               ASC                 " ,
    'summary'       => "  ORDER BY  ( compendium_pages.summary_en             != ''
                          AND         compendium_pages.summary_fr             != '' )             ,
                                    ( compendium_pages.summary_en             != ''
                          OR          compendium_pages.summary_fr             != '' )             ,
                                      compendium_pages.summary_en             = ''                ,
                                      compendium_pages.summary_fr             = ''                ,
                                      compendium_pages.page_url               ASC                 " ,
    'nsfw'          => "  ORDER BY    compendium_pages.title_is_nsfw          = ''                ,
                                      compendium_pages.is_nsfw                = ''                ,
                                      compendium_pages.is_gross               = ''                ,
                                      compendium_pages.is_offensive           = ''                ,
                                      compendium_pages.page_url               ASC                 " ,
    'wip'           => "  ORDER BY    compendium_pages.is_draft               = 0                 ,
                                      compendium_pages.is_deleted             = 0                 ,
                                      compendium_pages.page_url               ASC                 " ,
    'pageviews'     => "  ORDER BY    compendium_pages.view_count             DESC                ,
                          GREATEST  ( compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'pageviews_r'   => "  ORDER BY    compendium_pages.view_count             ASC                 ,
                          GREATEST  ( compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'seen'          => "  ORDER BY    compendium_pages.last_seen_on           DESC                ,
                          GREATEST (  compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'seen_r'        => "  ORDER BY    compendium_pages.last_seen_on           ASC                 ,
                          GREATEST (  compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'chars_en'      => "  ORDER BY    compendium_pages.character_count_en     DESC                ,
                          GREATEST  ( compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'chars_en_r'    => "  ORDER BY    compendium_pages.character_count_en     = 0                 ,
                                      compendium_pages.character_count_en     ASC                 ,
                          GREATEST  ( compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'chars_fr'      => "  ORDER BY    compendium_pages.character_count_fr     DESC                ,
                          GREATEST  ( compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    'chars_fr_r'    => "  ORDER BY    compendium_pages.character_count_fr     = 0                 ,
                                      compendium_pages.character_count_fr     ASC                 ,
                          GREATEST  ( compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
    default         => "  ORDER BY
                          GREATEST (  compendium_pages.created_at                                 ,
                                      compendium_pages.last_edited_at )       DESC                ,
                                      compendium_pages.title_$lang            ASC                 " ,
  };

  // Optionally limit the number of pages returned
  $query_limit = ($limit) ? " LIMIT $limit " : "";

  // Join categories if required
  $join_categories  = ($search_category || isset($search['join_categories'])) ? " LEFT JOIN compendium_pages_categories ON compendium_pages_categories.fk_compendium_pages = compendium_pages.id ": '';
  $count_categories = ($join_categories) ? " , COUNT(compendium_pages_categories.id) AS 'pc_count' " : '';
  $group_categories = ($join_categories) ? " GROUP BY compendium_pages.id " : '';

  // Fetch the pages
  $qpages = query(" SELECT    compendium_pages.id                       AS 'p_id'         ,
                              compendium_pages.is_deleted               AS 'p_deleted'    ,
                              compendium_pages.is_draft                 AS 'p_draft'      ,
                              compendium_pages.created_at               AS 'p_created'    ,
                              compendium_pages.last_edited_at           AS 'p_edited'     ,
                              compendium_pages.page_url                 AS 'p_url'        ,
                              compendium_pages.title_$lang              AS 'p_title'      ,
                              compendium_pages.title_en                 AS 'p_title_en'   ,
                              compendium_pages.title_fr                 AS 'p_title_fr'   ,
                              compendium_pages.redirection_$lang        AS 'p_redirect'   ,
                              compendium_pages.redirection_en           AS 'p_redir_en'   ,
                              compendium_pages.redirection_fr           AS 'p_redir_fr'   ,
                              compendium_pages.is_external_redirection  AS 'p_redir_ext'  ,
                              compendium_pages.view_count               AS 'p_viewcount'  ,
                              compendium_pages.last_seen_on             AS 'p_seen'       ,
                              compendium_pages.year_appeared            AS 'p_app_year'   ,
                              compendium_pages.month_appeared           AS 'p_app_month'  ,
                              compendium_pages.year_peak                AS 'p_peak_year'  ,
                              compendium_pages.month_peak               AS 'p_peak_month' ,
                              compendium_pages.is_nsfw                  AS 'p_nsfw'       ,
                              compendium_pages.is_gross                 AS 'p_gross'      ,
                              compendium_pages.is_offensive             AS 'p_offensive'  ,
                              compendium_pages.title_is_nsfw            AS 'p_nsfw_title' ,
                              compendium_pages.summary_$lang            AS 'p_summary'    ,
                              compendium_pages.summary_en               AS 'p_summary_en' ,
                              compendium_pages.summary_fr               AS 'p_summary_fr' ,
                              compendium_pages.character_count_en       AS 'p_chars_en'   ,
                              compendium_pages.character_count_fr       AS 'p_chars_fr'   ,
                              compendium_pages.admin_notes              AS 'p_notes'      ,
                              compendium_pages.admin_urls               AS 'p_urlnotes'   ,
                              compendium_eras.id                        AS 'pe_id'        ,
                              compendium_eras.short_name_$lang          AS 'pe_name'      ,
                              compendium_types.id                       AS 'pt_id'        ,
                              compendium_types.name_$lang               AS 'pt_name'      ,
                              compendium_types.full_name_$lang          AS 'pt_display'   ,
                              compendium_types.full_name_en             AS 'pt_full_en'   ,
                              compendium_types.full_name_fr             AS 'pt_full_fr'
                              $count_categories
                    FROM      compendium_pages
                    LEFT JOIN compendium_types  ON    compendium_pages.fk_compendium_types  = compendium_types.id
                    LEFT JOIN compendium_eras   ON    compendium_pages.fk_compendium_eras   = compendium_eras.id
                              $join_categories
                              $query_search
                              $group_categories
                              $query_sort
                              $query_limit ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qpages); $i++)
  {
    // Format the data
    $page_id                    = $row['p_id'];
    $page_url                   = $row['p_url'];
    $page_deleted               = $row['p_deleted'];
    $page_draft                 = $row['p_draft'];
    $page_redirection           = $row['p_redirect'];
    $page_redirection_en        = $row['p_redir_en'];
    $page_redirection_fr        = $row['p_redir_fr'];
    $page_redirection_ext       = $row['p_redir_ext'];
    $page_redirection_lang      = $row['p_redir_'.$lang];
    $page_redirection_otherlang = $row['p_redir_'.$otherlang];
    $page_created_on            = $row['p_created'];
    $page_last_edited_on        = $row['p_edited'];
    $page_title                 = $row['p_title'];
    $page_title_en              = $row['p_title_en'];
    $page_title_fr              = $row['p_title_fr'];
    $page_summary               = $row['p_summary'];
    $page_summary_en            = $row['p_summary_en'];
    $page_summary_fr            = $row['p_summary_fr'];
    $page_appeared_month        = $row['p_app_month'];
    $page_appeared_year         = $row['p_app_year'];
    $page_peaked_month          = $row['p_peak_month'];
    $page_peaked_year           = $row['p_peak_year'];
    $page_content_warning       = ($row['p_nsfw_title'] || $row['p_nsfw'] || $row['p_gross'] || $row['p_offensive']);
    $page_nsfw_title            = $row['p_nsfw_title'];
    $page_nsfw                  = $row['p_nsfw'];
    $page_gross                 = $row['p_gross'];
    $page_offensive             = $row['p_offensive'];
    $page_type_id               = $row['pt_id'];
    $page_type_name             = $row['pt_name'];
    $page_type_full_name_en     = $row['pt_full_en'];
    $page_type_full_name_fr     = $row['pt_full_fr'];
    $page_era_id                = $row['pe_id'];
    $page_era_name              = $row['pe_name'];
    $page_category_count        = ($join_categories) ? $row['pc_count'] : 0;
    $page_admin_notes           = $row['p_notes'];
    $page_admin_urls            = $row['p_urlnotes'];
    $page_views_count           = $row['p_viewcount'];
    $page_last_seen_on          = $row['p_seen'];
    $page_character_count_en    = $row['p_chars_en'];
    $page_character_count_fr    = $row['p_chars_fr'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data[$i]['id']         = sanitize_output($page_id);
      $data[$i]['deleted']    = ($page_deleted);
      $data[$i]['draft']      = ($page_draft);
      $data[$i]['created']    = ($page_created_on)
                              ? sanitize_output(string_change_case(time_since($page_created_on), 'lowercase'))
                              : '';
      $data[$i]['created_d']  = ($page_created_on)
                              ? sanitize_output(date('Y-m-d', $page_created_on))
                              : '';
      $data[$i]['edited']     = ($page_last_edited_on)
                              ? sanitize_output(string_change_case(time_since($page_last_edited_on), 'lowercase'))
                              : '';
      $data[$i]['url']        = sanitize_output($page_url);
      $data[$i]['urldisplay'] = sanitize_output(string_truncate($page_url, 18, '...'));
      $data[$i]['fullurl']    = (mb_strlen($page_url) > 18) ? sanitize_output($page_url) : '';
      $data[$i]['urlstats']   = sanitize_output(string_truncate($page_url, 30, '...'));
      $data[$i]['fullurlst']  = (mb_strlen($page_url) > 30) ? sanitize_output($page_url) : '';
      $data[$i]['title']      = sanitize_output($page_title);
      $data[$i]['shorttitle'] = sanitize_output(string_truncate($page_title, 32, '...'));
      $data[$i]['fulltitle']  = (mb_strlen($page_title) > 32) ? sanitize_output($page_title) : '';
      $data[$i]['admintitle'] = sanitize_output(string_truncate($page_title, 18, '...'));
      $data[$i]['adminfull']  = (mb_strlen($page_title) > 18) ? sanitize_output($page_title) : '';
      $wrong_title            = ($lang === 'en') ? $page_title_fr : $page_title_en;
      $data[$i]['wrongtitle'] = sanitize_output(string_truncate($wrong_title, 21, '...'));
      $data[$i]['fullwrong']  = (mb_strlen($wrong_title) > 23) ? sanitize_output($wrong_title) : '';
      $data[$i]['notitle']    = (!$page_title_en && !$page_title_fr) ? 1 : 0;
      $data[$i]['lang_en']    = ($page_title_en) ? 1 : 0;
      $data[$i]['lang_fr']    = ($page_title_fr) ? 1 : 0;
      $data[$i]['summary_en'] = ($page_summary_en) ? 1 : 0;
      $data[$i]['summary_fr'] = ($page_summary_fr) ? 1 : 0;
      $data[$i]['redirect']   = sanitize_output(string_truncate($page_redirection, 18, '...'));
      $data[$i]['fullredir']  = (mb_strlen($page_redirection) > 18) ? sanitize_output($page_redirection) : '';
      $data[$i]['redirlang']  = (!$page_redirection_lang && $page_redirection_otherlang)
                              ? sanitize_output(string_truncate($page_redirection_otherlang, 18, '...'))
                              : '';
      $redirect_language      = (mb_strlen($page_redirection_otherlang) > 18)
                              ? sanitize_output($page_redirection_otherlang)
                              : '';
      $data[$i]['fullrlang']  = ($redirect_language && !$page_redirection_lang && $page_redirection_otherlang)
                              ? $redirect_language
                              : '';
      $appeared_month         = ($page_appeared_month) ? __('month_'.$page_appeared_month, spaces_after: 1) : '';
      $data[$i]['appeared']   = ($page_appeared_year) ? $appeared_month.$page_appeared_year : '';
      $appeared_month_short   = ($page_appeared_month) ? __('month_short_'.$page_appeared_month, spaces_after: 1) : '';
      $data[$i]['app_short']  = ($page_appeared_year) ? $appeared_month_short.mb_substr($page_appeared_year, 2) : '';
      $peak_month             = ($page_peaked_month) ? __('month_'.$page_peaked_month, spaces_after: 1) : '';
      $data[$i]['peak']       = ($page_peaked_year) ? $peak_month.$page_peaked_year : '';
      $peak_month_short       = ($page_peaked_month) ? __('month_short_'.$page_peaked_month, spaces_after: 1) : '';
      $data[$i]['peak_short'] = ($page_peaked_year) ? $peak_month_short.mb_substr($page_peaked_year, 2) : '';
      $data[$i]['blur']       = ($page_nsfw_title && $nsfw < 1) ? ' blur' : '';
      $data[$i]['blur_link']  = ($page_nsfw_title && $nsfw < 1) ? ' blur' : ' forced_link';
      $data[$i]['adminnsfw']  = ($page_nsfw || $page_gross || $page_offensive || $page_nsfw_title);
      $data[$i]['nsfw']       = ($page_nsfw);
      $data[$i]['gross']      = ($page_gross);
      $data[$i]['offensive']  = ($page_offensive);
      $data[$i]['nsfwtitle']  = ($page_nsfw_title);
      $data[$i]['summary']    = nbcodes(sanitize_output($page_summary, preserve_line_breaks: true),
                                        page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
      $data[$i]['notes']      = sanitize_output($page_admin_notes);
      $data[$i]['urlnotes']   = '';
      $data[$i]['linknotes']  = '';
      $data[$i]['type_id']    = sanitize_output($page_type_id);
      $data[$i]['type']       = sanitize_output($page_type_name);
      $data[$i]['era_id']     = sanitize_output($page_era_id);
      $data[$i]['era']        = sanitize_output($page_era_name);
      $data[$i]['categories'] = sanitize_output($page_category_count);
      $data[$i]['viewcount']  = ($page_views_count > 1)
                              ? sanitize_output(number_display_format($page_views_count, "number"))
                              : '&nbsp;';
      $data[$i]['seen']       = ($page_last_seen_on) ? sanitize_output(time_since($page_last_seen_on)) : '&nbsp;';
      $data[$i]['chars_en']   = ($page_character_count_en) ? sanitize_output($page_character_count_en) : '-';
      $data[$i]['chars_fr']   = ($page_character_count_fr) ? sanitize_output($page_character_count_fr) : '-';

      // Prepare the admin urls
      if($page_admin_urls)
      {
        // Open the array of links for usage in JS
        $data[$i]['linknotes'] = '[';

        // Split the urls
        $admin_urls = explode("|||", $page_admin_urls);

        // Format the url lists
        $formatted_admin_urls = '';
        for($j = 0; $j < count($admin_urls); $j++)
        {
          $formatted_admin_urls .= __link($admin_urls[$j], string_truncate($admin_urls[$j], 40, '...'), is_internal: false).'<br>';
          if($j)
            $data[$i]['linknotes'] .= ', ';
          $data[$i]['linknotes'] .= "'$admin_urls[$j]'";
        }

        // Add the formatted page list and the page count to the data
        $data[$i]['urlnotes'] = $formatted_admin_urls;
        $data[$i]['urlcount'] = $j;

        // Close the array of links for usage in JS
        $data[$i]['linknotes'] .= ']';
      }
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      // Core page data
      $data[$i]['page']['id']   = (string)$page_id;
      $data[$i]['page']['url']  = sanitize_json($page_url);
      $data[$i]['page']['link'] = sanitize_json($GLOBALS['website_url'].'pages/compendium/'.$page_url);

      // Redirection data
      if($page_redirection_en || $page_redirection_fr || $page_redirection_ext)
      {
        $data[$i]['page']['redirects_to']['target_is_a_page_url'] = (bool)!$page_redirection_ext;
        $data[$i]['page']['redirects_to']['url_en']               = sanitize_json($page_redirection_en) ?: NULL;
        $data[$i]['page']['redirects_to']['url_fr']               = sanitize_json($page_redirection_fr) ?: NULL;
      }
      else
        $data[$i]['page']['redirects_to'] = NULL;

      // Page title
      $data[$i]['page']['title_en'] = sanitize_json($page_title_en) ?: NULL;
      $data[$i]['page']['title_fr'] = sanitize_json($page_title_fr) ?: NULL;

      // Content warnings
      if($page_content_warning)
      {
        $data[$i]['page']['content_warnings']['title_is_nsfw']      = (bool)($page_nsfw_title);
        $data[$i]['page']['content_warnings']['not_safe_for_work']  = (bool)($page_nsfw);
        $data[$i]['page']['content_warnings']['offensive']          = (bool)($page_offensive);
        $data[$i]['page']['content_warnings']['gross']              = (bool)($page_gross);
      }
      else
        $data[$i]['page']['content_warnings'] = NULL;

      // Page data
      $data[$i]['page']['first_appeared_year']    = (int)$page_appeared_year ?: NULL;
      $data[$i]['page']['first_appeared_month']   = (int)$page_appeared_month ?: NULL;
      $data[$i]['page']['peak_popularity_year']   = (int)$page_peaked_year ?: NULL;
      $data[$i]['page']['peak_popularity_month']  = (int)$page_peaked_month ?: NULL;
      $data[$i]['page']['summary_en']             = sanitize_json(nbcodes_remove($page_summary_en)) ?: NULL;
      $data[$i]['page']['summary_fr']             = sanitize_json(nbcodes_remove($page_summary_fr)) ?: NULL;

      // Page type data
      if($page_type_id)
      {
        $data[$i]['page']['type']['id']       = (string)$page_type_id;
        $data[$i]['page']['type']['name_en']  = sanitize_json($page_type_full_name_en);
        $data[$i]['page']['type']['name_fr']  = sanitize_json($page_type_full_name_fr);
      }
      else
        $data[$i]['page']['type'] = NULL;
    }
  }

  // Add the number of rows to the data
  if($format === 'html')
    $data['rows'] = $i;

  // Give a default return value when no pages are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('pages' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Fetches a list of all public compendium page urls.
 *
 * @return  array   An array containing all compendium page urls which the user is allowed to access.
 */

function compendium_pages_list_urls() : array
{
  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the page urls
  $qpages = query(" SELECT    compendium_pages.page_url AS 'p_url'
                    FROM      compendium_pages
                    WHERE   ( compendium_pages.title_$lang        != ''
                    OR        compendium_pages.redirection_$lang  != '' )
                    AND       compendium_pages.is_deleted         = 0
                    AND       compendium_pages.is_draft           = 0
                    ORDER BY  compendium_pages.page_url ASC ");

  // Prepare an array with the page urls
  $data = array();
  while($dpages = mysqli_fetch_array($qpages))
    array_push($data, $dpages['p_url']);

  // Return the array containing the page urls
  return $data;
}




/**
 * Creates a new compendium page.
 *
 * @param   array         $contents   The contents of the page.
 *
 * @return  string|int                A string if an error happened, or the new page's ID if all went well.
 */

function compendium_pages_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Apply formatting rules to page url and title
  $page_url       = isset($contents['url'])      ? compendium_format_url($contents['url'])        : '';
  $page_title_en  = isset($contents['title_en']) ? compendium_format_title($contents['title_en']) : '';
  $page_title_fr  = isset($contents['title_fr']) ? compendium_format_title($contents['title_fr']) : '';

  // Sanitize and prepare the data
  $timestamp          = sanitize(time(), 'int', 0);
  $page_url           = sanitize($page_url, 'string');
  $page_title_en      = sanitize($page_title_en, 'string');
  $page_title_fr      = sanitize($page_title_fr, 'string');
  $page_redirect_en   = sanitize_array_element($contents, 'redirect_en', 'string');
  $page_redirect_fr   = sanitize_array_element($contents, 'redirect_fr', 'string');
  $page_redirect_ext  = sanitize_array_element($contents, 'redirect_ext', 'int', min: 0, max: 1, default: 0);
  $page_summary_en    = sanitize_array_element($contents, 'summary_en', 'string');
  $page_summary_fr    = sanitize_array_element($contents, 'summary_fr', 'string');
  $page_body_en       = sanitize_array_element($contents, 'body_en', 'string');
  $page_body_fr       = sanitize_array_element($contents, 'body_fr', 'string');
  $page_appear_month  = sanitize_array_element($contents, 'appear_month', 'int', min: 0, max: 12, default: 0);
  $page_appear_year   = sanitize_array_element($contents, 'appear_year', 'int', min: 0, default: 0);
  $page_peak_month    = sanitize_array_element($contents, 'peak_month', 'int', min: 0, max: 12, default: 0);
  $page_peak_year     = sanitize_array_element($contents, 'peak_year', 'int', min: 0, default: 0);
  $page_nsfw_title    = sanitize_array_element($contents, 'nsfw_title', 'int', min: 0, max: 1, default: 0);
  $page_nsfw          = sanitize_array_element($contents, 'nsfw', 'int', min: 0, max: 1, default: 0);
  $page_gross         = sanitize_array_element($contents, 'gross', 'int', min: 0, max: 1, default: 0);
  $page_offensive     = sanitize_array_element($contents, 'offensive', 'int', min: 0, max: 1, default: 0);
  $page_type          = sanitize_array_element($contents, 'type', 'int', min: 0, default: 0);
  $page_era           = sanitize_array_element($contents, 'era', 'int', min: 0, default: 0);
  $page_char_count_en = sanitize(mb_strlen(nbcodes_remove($page_body_en)), 'int', 0);
  $page_char_count_fr = sanitize(mb_strlen(nbcodes_remove($page_body_fr)), 'int', 0);
  $page_admin_notes   = sanitize_array_element($contents, 'admin_notes', 'string');
  $page_admin_urls    = sanitize_array_element($contents, 'admin_urls', 'string');

  // Error: No URL or URL already taken
  if(!$page_url || database_entry_exists('compendium_pages', 'page_url', $page_url))
    return __('compendium_page_new_no_url');

  // Error: No title in either language
  if(!$page_title_en && !$page_redirect_en && !$page_title_fr && !$page_redirect_fr)
    return __('compendium_page_new_no_title');

  // Error: Redirects to non existing pages
  if(!$page_redirect_ext)
  {
    if($page_redirect_en && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_en))
      return __('compendium_page_new_bad_redirect');
    if($page_redirect_fr && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_fr))
      return __('compendium_page_new_bad_redirect');
  }

  // Create the compendium page
  query(" INSERT INTO compendium_pages
          SET         compendium_pages.fk_compendium_types      = '$page_type'          ,
                      compendium_pages.fk_compendium_eras       = '$page_era'           ,
                      compendium_pages.is_draft                 = 1                     ,
                      compendium_pages.created_at               = '$timestamp'          ,
                      compendium_pages.page_url                 = '$page_url'           ,
                      compendium_pages.title_en                 = '$page_title_en'      ,
                      compendium_pages.title_fr                 = '$page_title_fr'      ,
                      compendium_pages.redirection_en           = '$page_redirect_en'   ,
                      compendium_pages.redirection_fr           = '$page_redirect_fr'   ,
                      compendium_pages.is_external_redirection  = '$page_redirect_ext'  ,
                      compendium_pages.year_appeared            = '$page_appear_year'   ,
                      compendium_pages.month_appeared           = '$page_appear_month'  ,
                      compendium_pages.year_peak                = '$page_peak_year'     ,
                      compendium_pages.month_peak               = '$page_peak_month'    ,
                      compendium_pages.is_nsfw                  = '$page_nsfw'          ,
                      compendium_pages.is_gross                 = '$page_gross'         ,
                      compendium_pages.is_offensive             = '$page_offensive'     ,
                      compendium_pages.title_is_nsfw            = '$page_nsfw_title'    ,
                      compendium_pages.summary_en               = '$page_summary_en'    ,
                      compendium_pages.summary_fr               = '$page_summary_fr'    ,
                      compendium_pages.definition_en            = '$page_body_en'       ,
                      compendium_pages.definition_fr            = '$page_body_fr'       ,
                      compendium_pages.character_count_en       = '$page_char_count_en' ,
                      compendium_pages.character_count_fr       = '$page_char_count_fr' ,
                      compendium_pages.admin_notes              = '$page_admin_notes'   ,
                      compendium_pages.admin_urls               = '$page_admin_urls'    ");

  // Fetch the newly created compendium page's id
  $page_id = query_id();

  // Fetch the category list
  $categories = compendium_categories_list();

  // Loop through the categories
  for($i = 0; $i < $categories['rows']; $i++)
  {
    // Sanitize the category id
    $category_id = sanitize($categories[$i]['id'], 'int', 0);

    // Link any selected categories to the newly created page
    if(isset($contents['category_'.$category_id]) && $contents['category_'.$category_id])
      query(" INSERT INTO compendium_pages_categories
              SET         compendium_pages_categories.fk_compendium_pages       = '$page_id'      ,
                          compendium_pages_categories.fk_compendium_categories  = '$category_id'  ");
  }

  // Delete any related missing page
  query(" DELETE FROM compendium_missing
          WHERE       compendium_missing.page_url LIKE '$page_url' ");

  // Immediately publish the page if it is a redirection
  if($page_redirect_en || $page_redirect_fr)
    compendium_pages_publish($page_id);

  // Return the compendium page's id
  return $page_id;
}




/**
 * Modifies a new compendium page.
 *
 * @param   int           $page_id    The id of the page to edit.
 * @param   array         $contents   The contents of the page.
 *
 * @return  string|null               A string if an error happened, or null if all went well.
 */

function compendium_pages_edit( int   $page_id  ,
                                array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the page's id
  $page_id = sanitize($page_id, 'int', 0);

  // Stop here if the page doesn't exist
  if(!database_row_exists('compendium_pages', $page_id))
    return __('compendium_page_edit_missing');

  // Fetch the page data
  $page_data = compendium_pages_get(  $page_id        ,
                                      no_loops: false );

  // Stop here if the page data is missing
  if(!isset($page_data) || !$page_data)
    return __('compendium_page_edit_missing');

  // Apply formatting rules to page url and title
  $page_url       = isset($contents['url'])      ? compendium_format_url($contents['url'])        : '';
  $page_title_en  = isset($contents['title_en']) ? compendium_format_title($contents['title_en']) : '';
  $page_title_fr  = isset($contents['title_fr']) ? compendium_format_title($contents['title_fr']) : '';

  // Sanitize and prepare the data
  $timestamp          = sanitize(time(), 'int', 0);
  $page_url_raw       = $page_url;
  $page_title_en_raw  = $page_title_en;
  $page_title_fr_raw  = $page_title_fr;
  $page_url           = sanitize($page_url, 'string');
  $page_title_en      = sanitize($page_title_en, 'string');
  $page_title_fr      = sanitize($page_title_fr, 'string');
  $page_redirect_en   = sanitize_array_element($contents, 'redirect_en', 'string');
  $page_redirect_fr   = sanitize_array_element($contents, 'redirect_fr', 'string');
  $page_redirect_ext  = sanitize_array_element($contents, 'redirect_ext', 'int', min: 0, max: 1, default: 0);
  $page_summary_en    = sanitize_array_element($contents, 'summary_en', 'string');
  $page_summary_fr    = sanitize_array_element($contents, 'summary_fr', 'string');
  $page_body_en_raw   = (isset($contents['body_en'])) ? $contents['body_en'] : '';
  $page_body_fr_raw   = (isset($contents['body_fr'])) ? $contents['body_fr'] : '';
  $page_body_en       = sanitize_array_element($contents, 'body_en', 'string');
  $page_body_fr       = sanitize_array_element($contents, 'body_fr', 'string');
  $page_appear_month  = sanitize_array_element($contents, 'appear_month', 'int', min: 0, max: 12, default: 0);
  $page_appear_year   = sanitize_array_element($contents, 'appear_year', 'int', min: 0, default: 0);
  $page_peak_month    = sanitize_array_element($contents, 'peak_month', 'int', min: 0, max: 12, default: 0);
  $page_peak_year     = sanitize_array_element($contents, 'peak_year', 'int', min: 0, default: 0);
  $page_nsfw_title    = sanitize_array_element($contents, 'nsfw_title', 'int', min: 0, max: 1, default: 0);
  $page_nsfw          = sanitize_array_element($contents, 'nsfw', 'int', min: 0, max: 1, default: 0);
  $page_gross         = sanitize_array_element($contents, 'gross', 'int', min: 0, max: 1, default: 0);
  $page_offensive     = sanitize_array_element($contents, 'offensive', 'int', min: 0, max: 1, default: 0);
  $page_type          = sanitize_array_element($contents, 'type', 'int', min: 0, default: 0);
  $page_era           = sanitize_array_element($contents, 'era', 'int', min: 0, default: 0);
  $page_char_count_en = sanitize(mb_strlen(nbcodes_remove($page_body_en)), 'int', 0);
  $page_char_count_fr = sanitize(mb_strlen(nbcodes_remove($page_body_fr)), 'int', 0);
  $page_admin_notes   = sanitize_array_element($contents, 'admin_notes', 'string');
  $page_admin_urls    = sanitize_array_element($contents, 'admin_urls', 'string');
  $page_history_en    = sanitize_array_element($contents, 'history_en', 'string');
  $page_history_fr    = sanitize_array_element($contents, 'history_fr', 'string');
  $page_history_major = sanitize_array_element($contents, 'major', 'int', min: 0, max: 1, default: 0);
  $page_silent_edit   = sanitize_array_element($contents, 'silent', 'int', min: 0, max: 1, default: 0);

  // Error: No URL
  if(!$page_url)
    return __('compendium_page_new_no_url');

  // Error: New URL is already taken
  if(($page_url_raw !== $page_data['url_raw']) && database_entry_exists('compendium_pages', 'page_url', $page_url))
    return __('compendium_page_new_no_url');

  // Error: No title in either language
  if(!$page_title_en && !$page_redirect_en && !$page_title_fr && !$page_redirect_fr)
    return __('compendium_page_new_no_title');

  // Error: Redirects to non existing pages
  if(!$page_redirect_ext)
  {
    if($page_redirect_en && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_en))
      return __('compendium_page_new_bad_redirect');
    if($page_redirect_fr && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_fr))
      return __('compendium_page_new_bad_redirect');
  }

  // Update the compendium page
  query(" UPDATE  compendium_pages
          SET     compendium_pages.fk_compendium_types      = '$page_type'          ,
                  compendium_pages.fk_compendium_eras       = '$page_era'           ,
                  compendium_pages.page_url                 = '$page_url'           ,
                  compendium_pages.title_en                 = '$page_title_en'      ,
                  compendium_pages.title_fr                 = '$page_title_fr'      ,
                  compendium_pages.redirection_en           = '$page_redirect_en'   ,
                  compendium_pages.redirection_fr           = '$page_redirect_fr'   ,
                  compendium_pages.is_external_redirection  = '$page_redirect_ext'  ,
                  compendium_pages.year_appeared            = '$page_appear_year'   ,
                  compendium_pages.month_appeared           = '$page_appear_month'  ,
                  compendium_pages.year_peak                = '$page_peak_year'     ,
                  compendium_pages.month_peak               = '$page_peak_month'    ,
                  compendium_pages.is_nsfw                  = '$page_nsfw'          ,
                  compendium_pages.is_gross                 = '$page_gross'         ,
                  compendium_pages.is_offensive             = '$page_offensive'     ,
                  compendium_pages.title_is_nsfw            = '$page_nsfw_title'    ,
                  compendium_pages.summary_en               = '$page_summary_en'    ,
                  compendium_pages.summary_fr               = '$page_summary_fr'    ,
                  compendium_pages.definition_en            = '$page_body_en'       ,
                  compendium_pages.definition_fr            = '$page_body_fr'       ,
                  compendium_pages.character_count_en       = '$page_char_count_en' ,
                  compendium_pages.character_count_fr       = '$page_char_count_fr' ,
                  compendium_pages.admin_notes              = '$page_admin_notes'   ,
                  compendium_pages.admin_urls               = '$page_admin_urls'
          WHERE   compendium_pages.id                       = '$page_id'            ");

  // Fetch the category list
  $categories = compendium_categories_list();

  // Prepare the page's category list
  $page_categories = (isset($page_data['category_id'])) ? $page_data['category_id'] : array();

  // Loop through the categories
  for($i = 0; $i < $categories['rows']; $i++)
  {
    // Sanitize the category id
    $category_id = sanitize($categories[$i]['id'], 'int', 0);

    // Check whether the page should belong to that category
    $page_belongs = (isset($contents['category_'.$category_id]) && $contents['category_'.$category_id]);

    // If the page isn't attached to a category it should be attached to, attach it
    if($page_belongs && !in_array($category_id, $page_categories))
      query(" INSERT INTO compendium_pages_categories
              SET         compendium_pages_categories.fk_compendium_pages       = '$page_id'      ,
                          compendium_pages_categories.fk_compendium_categories  = '$category_id'  ");

    // If the page is attached to a category it shouldn't be attached to, remove it
    if(!$page_belongs && in_array($category_id, $page_categories))
      query(" DELETE FROM compendium_pages_categories
              WHERE       compendium_pages_categories.fk_compendium_pages       = '$page_id'
              AND         compendium_pages_categories.fk_compendium_categories  = '$category_id'  ");
  }

  // If the url was changed, delete any related missing page
  if($page_url_raw !== $page_data['url_raw'])
    query(" DELETE FROM compendium_missing
            WHERE       compendium_missing.page_url LIKE '$page_url' ");

  // If a page became a redirection, delete any related activity
  if($page_redirect_en || $page_redirect_fr)
    log_activity_delete(  'compendium_'               ,
                          activity_id:      $page_id  ,
                          global_type_wipe: true      );

  // If a page is no longer a redirection, restore any related activity
  if(!$page_redirect_en && !$page_redirect_fr && ($page_data['redir_en'] || $page_data['redir_fr']))
    log_activity_delete(  'compendium_'               ,
                          activity_id:      $page_id  ,
                          global_type_wipe: true      ,
                          restore:          true      );

  // Do not handle history, activity, integrations for redirections, deleted pages, drafts or if silence is requested
  if(!$page_silent_edit && !$page_redirect_en && !$page_redirect_fr && !$page_data['draft'] && !$page_data['deleted'])
  {
    // Page history
    query(" INSERT INTO compendium_pages_history
            SET         compendium_pages_history.fk_compendium_pages  = '$page_id'            ,
                        compendium_pages_history.edited_at            = '$timestamp'          ,
                        compendium_pages_history.is_major_edit        = '$page_history_major' ,
                        compendium_pages_history.summary_en           = '$page_history_en'    ,
                        compendium_pages_history.summary_fr           = '$page_history_fr'    ");

    // Update the page edition data in case of a major modification
    if($page_history_major)
      query(" UPDATE  compendium_pages
              SET     compendium_pages.last_edited_at = '$timestamp'
              WHERE   compendium_pages.id             = '$page_id' ");

    // Recent activity
    if(isset($contents['activity']) && $contents['activity'])
    {
      // Determine the language to use
      $lang   = ($page_title_en_raw) ? 'EN' : '';
      $lang  .= ($page_title_fr_raw) ? 'FR' : '';

      // Create the activity entry
      if($lang)
        log_activity( 'compendium_edit',
                      language:             'ENFR'              ,
                      activity_id:          $page_id            ,
                      activity_summary_en:  $page_title_en_raw  ,
                      activity_summary_fr:  $page_title_fr_raw  ,
                      username:             $page_url_raw       );
    }

    // IRC bot message
    if(isset($contents['irc']) && $contents['irc'])
    {
      if($page_data['titleenraw'])
        irc_bot_send_message("21st century compendium entry edited: ".$page_title_en_raw." - ".$GLOBALS['website_url']."pages/compendium/".$page_url_raw, 'english');
      if($page_data['titlefrraw'])
        irc_bot_send_message("Page modifée dans le compendium du 21ème siècle : ".$page_title_fr_raw." - ".$GLOBALS['website_url']."pages/compendium/".$page_url_raw, 'french');
    }

    // Discord message
    if(isset($contents['discord']) && $contents['discord'])
    {
      // Prepare the correct message
      if($page_title_en_raw && $page_title_fr_raw)
      {
        $message  = "21st century compendium entry edited: ".$page_title_en_raw;
        $message .= PHP_EOL."Page modifiée dans le compendium : ".$page_title_fr_raw;
        $message .= PHP_EOL."<".$GLOBALS['website_url']."pages/compendium/".$page_url_raw.">";
      }
      else if($page_title_en_raw)
      {
        $message  = "21st century compendium entry edited: ".$page_title_en_raw;
        $message .= PHP_EOL."Page modifiée dans le compendium - n'est pas disponible en français";
        $message .= PHP_EOL."<".$GLOBALS['website_url']."pages/compendium/".$page_url_raw.">";
      }
      else if($page_title_fr_raw)
      {
        $message  = "21st century compendium entry edited - not available in englsih";
        $message .= PHP_EOL."Page modifiée dans le compendium : ".$page_title_fr_raw;
        $message .= PHP_EOL."<".$GLOBALS['website_url']."pages/compendium/".$page_url_raw.">";
      }

      // Send the message
      if(isset($message))
        discord_send_message($message, 'main');
    }
  }

  // Find all images in the page
  $image_list_en      = compendium_find_images_in_entry($page_body_en_raw);
  $image_list_fr      = compendium_find_images_in_entry($page_body_fr_raw);
  $old_image_list_en  = compendium_find_images_in_entry($page_data['bodyenraw']);
  $old_image_list_fr  = compendium_find_images_in_entry($page_data['bodyfrraw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr, $old_image_list_en, $old_image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used or previously used on the page
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // All went well, return null
  return NULL;
}




/**
 * Publishes an existing compendium page.
 *
 * @param   int   $page_id                      The ID of the compendium page to publish.
 * @param   bool  $recent_activity  (OPTIONAL)  Whether to create an entry in the recent activity.
 * @param   bool  $irc_message      (OPTIONAL)  Whether to broadcast a message on IRC.
 * @param   bool  $discord_message  (OPTIONAL)  Whether to broadcast a message on Discord.
 *
 * @return  void
 */

function compendium_pages_publish(  int   $page_id                  ,
                                    bool  $recent_activity  = false ,
                                    bool  $irc_message      = false ,
                                    bool  $discord_message  = false ) : void
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $page_id    = sanitize($page_id, 'int', 0);
  $timestamp  = sanitize(time(), 'int', 0);

  // Stop here if the page does not exist
  if(!database_row_exists('compendium_pages', $page_id))
    return;

  // Fetch the page's data
  $page_data = compendium_pages_get($page_id);

  // Stop here if the page data is invalid
  if(!isset($page_data) || !$page_data)
    return;

  // Stop here if the page is not a draft
  if(!$page_data['draft'])
    return;

  // Publish the page
  query(" UPDATE  compendium_pages
          SET     compendium_pages.is_draft   = 0             ,
                  compendium_pages.created_at = '$timestamp'
          WHERE   compendium_pages.id         = '$page_id'    ");

  // Stop here if the page is a redirection
  if($page_data['redir_en'] || $page_data['redir_fr'])
    return;

  // Recent activity
  if($recent_activity)
  {
    // Determine the language to use
    $lang   = ($page_data['titleenraw']) ? 'EN' : '';
    $lang  .= ($page_data['titlefrraw']) ? 'FR' : '';

    // Create the activity entry
    if($lang)
      log_activity( 'compendium_new',
                    language:             'ENFR'                    ,
                    activity_id:          $page_id                  ,
                    activity_summary_en:  $page_data['titleenraw']  ,
                    activity_summary_fr:  $page_data['titlefrraw']  ,
                    username:             $page_data['url_raw']     );
  }

  // IRC bot message
  if($irc_message)
  {
    if($page_data['titleenraw'])
      irc_bot_send_message("New entry in the 21st century compendium: ".$page_data['titleenraw']." - ".$GLOBALS['website_url']."pages/compendium/".$page_data['url_raw'], 'english');
    if($page_data['titlefrraw'])
      irc_bot_send_message("Nouvelle page dans le compendium du 21ème siècle : ".$page_data['titlefrraw']." - ".$GLOBALS['website_url']."pages/compendium/".$page_data['url_raw'], 'french');
  }

  // Discord message
  if($discord_message)
  {
    // Prepare the correct message
    if($page_data['titleenraw'] && $page_data['titlefrraw'])
    {
      $message  = "New 21st century compendium page: ".$page_data['titleenraw'];
      $message .= PHP_EOL."Nouvelle page dans le compendium : ".$page_data['titlefrraw'];
      $message .= PHP_EOL."<".$GLOBALS['website_url']."pages/compendium/".$page_data['url_raw'].">";
    }
    else if($page_data['titleenraw'])
    {
      $message  = "New 21st century compendium page: ".$page_data['titleenraw'];
      $message .= PHP_EOL."Nouvelle page dans le compendium - n'est pas disponible en français";
      $message .= PHP_EOL."<".$GLOBALS['website_url']."pages/compendium/".$page_data['url_raw'].">";
    }
    else if($page_data['titlefrraw'])
    {
      $message  = "New 21st century compendium page - not available in englsih";
      $message .= PHP_EOL."Nouvelle page dans le compendium : ".$page_data['titlefrraw'];
      $message .= PHP_EOL."<".$GLOBALS['website_url']."pages/compendium/".$page_data['url_raw'].">";
    }

    // Send the message
    if(isset($message))
      discord_send_message($message, 'main');
  }

  // Find all images in the page
  $image_list_en  = compendium_find_images_in_entry($page_data['bodyenraw']);
  $image_list_fr  = compendium_find_images_in_entry($page_data['bodyfrraw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used on the page
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);
}




/**
 * Deletes an existing compendium page.
 *
 * @param   int   $page_id                    The ID of the compendium page to delete.
 * @param   bool  $hard_deletion  (OPTIONAL)  Performs a hard deletion instead of a soft one.
 *
 * @return  void
 */

function compendium_pages_delete( int   $page_id                ,
                                  bool  $hard_deletion  = false ) : void
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the page's id
  $page_id = sanitize($page_id, 'int', 0);

  // Stop here if the page does not exist
  if(!database_row_exists('compendium_pages', $page_id))
    return;

  // Fetch the page's data
  $page_data = compendium_pages_get($page_id);

  // Soft deletion
  if(!$hard_deletion)
    query(" UPDATE  compendium_pages
            SET     compendium_pages.is_deleted = 1
            WHERE   compendium_pages.id         = '$page_id' ");

  // Delete any linked recent activity
  log_activity_delete(  'compendium_'               ,
                        activity_id:      $page_id  ,
                        global_type_wipe: true      );

  // Hard deletion
  if($hard_deletion)
  {
    query(" DELETE FROM compendium_pages
            WHERE       compendium_pages.id = '$page_id' ");
    query(" DELETE FROM compendium_pages_categories
            WHERE       compendium_pages_categories.fk_compendium_pages = '$page_id' ");
    query(" DELETE FROM compendium_pages_history
            WHERE       compendium_pages_history.fk_compendium_pages = '$page_id' ");
  }

  // Find all images in the page
  $image_list_en  = compendium_find_images_in_entry($page_data['bodyenraw']);
  $image_list_fr  = compendium_find_images_in_entry($page_data['bodyfrraw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used on the page
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);
}




/**
 * Restores a deleted compendium page.
 *
 * @param   int   $page_id  The ID of the compendium page to restore.
 *
 * @return  void
 */

function compendium_pages_restore( int $page_id ) : void
{
  // Sanitize the page's id
  $page_id = sanitize($page_id, 'int', 0);

  // Stop here if the page does not exist
  if(!database_row_exists('compendium_pages', $page_id))
    return;

  // Restore the page
  query(" UPDATE  compendium_pages
          SET     compendium_pages.is_deleted = 0
          WHERE   compendium_pages.id         = '$page_id' ");

  // Retore any linked recent activity
  log_activity_delete(  'compendium_'               ,
                        activity_id:      $page_id  ,
                        global_type_wipe: true      ,
                        restore:          true      );

  // Fetch the page's data
  $page_data = compendium_pages_get($page_id);

  // Find all images in the page
  $image_list_en  = compendium_find_images_in_entry($page_data['bodyenraw']);
  $image_list_fr  = compendium_find_images_in_entry($page_data['bodyfrraw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used on the page
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);
}




/**
 * Updates the pageview count for an existing compendium page.
 *
 * @param   string  $page_id    The compendium page's id.
 * @param   string  $page_url   The complete page url.
 */

function compendium_pages_update_pageviews( int     $page_id  ,
                                            string  $page_url )
{
  // Sanitize the data
  $page_url   = sanitize($page_url, 'string');
  $page_id    = sanitize($page_id, 'int', 0);

  // Ensure the compendium page exists
  if(!$page_url || !$page_id || !database_row_exists('compendium_pages', $page_id))
    return;

  // Fetch the pageview count
  $dviews = mysqli_fetch_array(query("  SELECT  stats_pages.view_count AS 'sp_count'
                                        FROM    stats_pages
                                        WHERE   stats_pages.page_url LIKE '$page_url' "));

  // Sanitize the pageview count and the current timestamp
  $view_count = (isset($dviews['sp_count'])) ? sanitize($dviews['sp_count'], 'int', 0) : 0;
  $timestamp  = sanitize(time(), 'int', 0);

  // Update the pageview count
  query(" UPDATE  compendium_pages
          SET     compendium_pages.view_count   = '$view_count' ,
                  compendium_pages.last_seen_on = '$timestamp'
          WHERE   compendium_pages.id           = '$page_id' ");
}




/**
 * Autocompletes a page url.
 *
 * @param   string      $input                        The input that needs to be autocompleted.
 * @param   bool        $no_redirects     (OPTIONAL)  If set, the returned page list will exclude redirections.
 * @param   bool        $include_missing  (OPTIONAL)  If set, the returned page list will include missing pages.
 *
 * @return  array|null                                An array containing autocomplete data, NULL if something failed.
 */

function compendium_pages_autocomplete( string  $input                      ,
                                        bool    $no_redirects     = false   ,
                                        bool    $include_missing  = false   ) : mixed
{
  // Sanitize the input
  $input  = sanitize($input, 'string');

  // Only work when more than 1 character has been submitted
  if(mb_strlen($input) < 1)
    return NULL;

  // Remove redirections if needed
  $no_redirects = ($no_redirects) ? " AND compendium_pages.redirection_en = '' AND compendium_pages.redirection_fr = '' " : '';

  // Look for page urls to add to autocompletion
  $qpages = query(" SELECT    compendium_pages.page_url AS 'c_url'
                    FROM      compendium_pages
                    WHERE     compendium_pages.page_url LIKE '$input%'
                              $no_redirects
                    ORDER BY  compendium_pages.page_url ASC
                    LIMIT     10 ");

  // Prepare the returned data
  for($i = 0; $dpages = mysqli_fetch_array($qpages); $i++)
    $data[$i]['url'] = sanitize_output($dpages['c_url']);

  // Add missing pages if requested
  if($include_missing)
  {
    // Look for missing pages to add to autocompletion
    $qmissing = query(" SELECT    compendium_missing.page_url AS 'cm_url'
                        FROM      compendium_missing
                        WHERE     compendium_missing.page_url LIKE '$input%'
                        ORDER BY  compendium_missing.page_url ASC
                        LIMIT     10 ");

    // Prepare the returned data
    for($i = $i; $dmissing = mysqli_fetch_array($qmissing); $i++)
      $data[$i]['url'] = sanitize_output($dmissing['cm_url']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns data related to an image used in the compendium.
 *
 * @param   int         $image_id   (OPTIONAL)  The image's id. Only one of these two parameters should be set.
 * @param   string      $file_name  (OPTIONAL)  The image file's name  Only one of these two parameters should be set.
 *
 *
 * @return  array|null              An array containing page image data, or NULL if it does not exist.
 */

function compendium_images_get( ?int    $image_id   = 0 ,
                                string  $file_name  = '') : mixed
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');

  // Get the user's current language, access rights, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = user_is_administrator();
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Sanitize the parameters
  $image_id  = sanitize($image_id, 'int', 0);
  $file_name = sanitize($file_name, 'string');

  // Return null if both parameters are missing
  if(!$image_id && !$file_name)
    return NULL;

  // Return null if both parameters are set
  if($image_id && $file_name)
    return NULL;

  // Fetch the image id if it wasn't set
  if($file_name)
    $image_id = database_entry_exists('compendium_images', 'file_name', $file_name);

  // Return null if the image doesn't exist
  if(!database_row_exists('compendium_images', $image_id))
    return NULL;

  // Fetch the data
  $dimage = mysqli_fetch_array(query("  SELECT  compendium_images.id                  AS 'ci_id'          ,
                                                compendium_images.is_deleted          AS 'ci_deleted'     ,
                                                compendium_images.file_name           AS 'ci_filename'    ,
                                                compendium_images.tags                AS 'ci_tags'        ,
                                                compendium_images.is_nsfw             AS 'ci_nsfw'        ,
                                                compendium_images.is_gross            AS 'ci_gross'       ,
                                                compendium_images.is_offensive        AS 'ci_offensive'   ,
                                                compendium_images.used_in_pages_$lang AS 'ci_used'        ,
                                                compendium_images.used_in_pages_en    AS 'ci_used_en'     ,
                                                compendium_images.used_in_pages_fr    AS 'ci_used_fr'     ,
                                                compendium_images.caption_$lang       AS 'ci_body'        ,
                                                compendium_images.caption_en          AS 'ci_caption_en'  ,
                                                compendium_images.caption_fr          AS 'ci_caption_fr'
                                        FROM    compendium_images
                                        WHERE   compendium_images.id = '$image_id' "));

  // Return null if the image should not be displayed
  if(!$is_admin && $dimage['ci_deleted'])
    return NULL;

  // Assemble an array with the data
  $data['id']         = sanitize_output($dimage['ci_id']);
  $data['deleted']    = sanitize_output($dimage['ci_deleted']);
  $data['name']       = sanitize_output($dimage['ci_filename']);
  $data['name_raw']   = $dimage['ci_filename'];
  $data['tags']       = sanitize_output($dimage['ci_tags']);
  $data['nsfw']       = sanitize_output($dimage['ci_nsfw']);
  $data['gross']      = sanitize_output($dimage['ci_gross']);
  $data['offensive']  = sanitize_output($dimage['ci_offensive']);
  $blur_image         = ($dimage['ci_nsfw'] || $dimage['ci_gross'] || $dimage['ci_offensive']) ? 1 : 0;
  $data['blur']       = ($nsfw < 2 && $blur_image) ? ' class="compendium_image_blur"' : '';
  $data['blurred']    = ($nsfw < 2 && $blur_image) ? 1 : 0;
  $data['body_clean'] = sanitize_output($dimage['ci_body']);
  $data['body']       = nbcodes(sanitize_output($dimage['ci_body'], preserve_line_breaks: true),
                                page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $page_links         = ($dimage['ci_used']) ? compendium_images_assemble_links($dimage['ci_used']) : '';
  $data['used']       = ($dimage['ci_used']) ? $page_links['list'] : '';
  $data['used_count'] = ($dimage['ci_used']) ? $page_links['count'] : 0;
  $data['used_en']    = sanitize_output($dimage['ci_used_en']);
  $data['used_fr']    = sanitize_output($dimage['ci_used_fr']);
  $data['caption_en'] = sanitize_output($dimage['ci_caption_en']);
  $data['caption_fr'] = sanitize_output($dimage['ci_caption_fr']);
  $data['meta_desc']  = ($dimage['ci_caption_en'])
                      ? string_truncate(nbcodes_remove($dimage['ci_caption_en']), 250, '...')
                      : string_truncate(nbcodes_remove($dimage['ci_caption_fr']), 250, '...');

  // Return the data
  return $data;
}




/**
 * Returns data related to a random image used in the compendium.
 *
 * @param   int     $exclude_id   (OPTIONAL)  An image id to exclude from the images being fetched.
 *
 * @return  string                            The url of a randomly chosen compendium image.
 */

function compendium_images_get_random( int $exclude_id = 0 ) : string
{
  // Sanitize the excluded id
  $exclude_id = sanitize($exclude_id, 'int', 0);

  // Add the excluded id if necessary
  $query_exclude = ($exclude_id) ? " AND compendium_images.id != '$exclude_id' " : '';

  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch a random page's url
  $dimage = mysqli_fetch_array(query("  SELECT    compendium_images.file_name AS 'c_name'
                                        FROM      compendium_images
                                        WHERE     compendium_images.is_deleted          = 0
                                        AND       compendium_images.used_in_pages_$lang NOT LIKE ''
                                        AND       compendium_images.is_nsfw             = 0
                                        AND       compendium_images.is_gross            = 0
                                        AND       compendium_images.is_offensive        = 0
                                                  $query_exclude
                                        ORDER BY  RAND()
                                        LIMIT     1 "));

  // If no page has been found, return an empty string
  if(!isset($dimage['c_name']))
    return '';

  // Otherwise, return the page url
  return $dimage['c_name'];
}




/**
 * Fetches a list of images used in the compendium.
 *
 * @param   string  $sort_by    (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search     (OPTIONAL)  Search for specific field values.
 *
 * @return  array                           An array containing images used in the compendium.
 */

function compendium_images_list(  string  $sort_by  = 'date'  ,
                                  array   $search   = array() ) : array
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Get the user's current language, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Sanitize the search parameters
  $search_name    = sanitize_array_element($search, 'name', 'string');
  $search_date    = sanitize_array_element($search, 'date', 'int', min: 0, default: 0);
  $search_nsfw    = sanitize_array_element($search, 'nsfw', 'string');
  $search_used_en = sanitize_array_element($search, 'used_en', 'string');
  $search_used_fr = sanitize_array_element($search, 'used_fr', 'string');
  $search_tags    = sanitize_array_element($search, 'tags', 'string');
  $search_caption = sanitize_array_element($search, 'caption', 'string');
  $search_deleted = sanitize_array_element($search, 'deleted', 'int', min: 0, max: 2, default: 0);

  // Search through the data: Content warnings
  $query_search = match($search_nsfw)
  {
    'safe'      => "  WHERE   compendium_images.is_nsfw       = 0
                      AND     compendium_images.is_gross      = 0
                      AND     compendium_images.is_offensive  = 0 "   ,
    'nsfw'      => "  WHERE ( compendium_images.is_nsfw       = 1
                      OR      compendium_images.is_gross      = 1
                      OR      compendium_images.is_offensive  = 1 ) " ,
    'image'     => "  WHERE   compendium_images.is_nsfw       = 1 "   ,
    'gross'     => "  WHERE   compendium_images.is_gross      = 1 "   ,
    'offensive' => "  WHERE   compendium_images.is_offensive  = 1 "   ,
    default     => "  WHERE   1 = 1 "                                 ,
  };

  // Search through the data: Caption languages
  $query_search .= match($search_caption)
  {
    'none'        => "  AND   compendium_images.caption_en  = ''
                        AND   compendium_images.caption_fr  = '' " ,
    'monolingual' => "  AND ( compendium_images.caption_en  = ''
                        AND   compendium_images.caption_fr != '' )
                        OR  ( compendium_images.caption_en != ''
                        AND   compendium_images.caption_fr  = '' ) " ,
    'bilingual'   => "  AND   compendium_images.caption_en != ''
                        AND   compendium_images.caption_fr != '' " ,
    'english'     => "  AND   compendium_images.caption_en != '' " ,
    'french'      => "  AND   compendium_images.caption_fr != '' " ,
    default       => "" ,
  };

  // Search through the data: Other searches
  $query_search .= ($search_name)           ? " AND compendium_images.file_name        LIKE '%$search_name%'    " : "";
  $query_search .= ($search_date)           ? " AND
                                       YEAR(FROM_UNIXTIME(compendium_images.uploaded_at)) = '$search_date'      " : "";
  $query_search .= ($search_used_en)        ? " AND compendium_images.used_in_pages_en LIKE '%$search_used_en%' " : "";
  $query_search .= ($search_used_fr)        ? " AND compendium_images.used_in_pages_fr LIKE '%$search_used_fr%' " : "";
  $query_search .= ($search_tags)           ? " AND compendium_images.tags             LIKE '%$search_tags%'    " : "";
  $query_search .= ($search_deleted === 1)  ? " AND compendium_images.is_deleted          = 0                   " : "";
  $query_search .= ($search_deleted === 2)  ? " AND compendium_images.is_deleted          = 1                   " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'name'    => "  ORDER BY    compendium_images.file_name         ASC     ,
                                compendium_images.uploaded_at       DESC    " ,
    'nsfw'    => "  ORDER BY    compendium_images.is_nsfw           = ''    ,
                                compendium_images.is_gross          = ''    ,
                                compendium_images.is_offensive      = ''    ,
                                compendium_images.uploaded_at       DESC    " ,
    'used_en' => "  ORDER BY    compendium_images.used_in_pages_en  != ''   ,
                                compendium_images.used_in_pages_fr  != ''   ,
                                compendium_images.used_in_pages_en  ASC     ,
                                compendium_images.uploaded_at       DESC    " ,
    'used_fr' => "  ORDER BY    compendium_images.used_in_pages_fr  != ''   ,
                                compendium_images.used_in_pages_en  != ''   ,
                                compendium_images.used_in_pages_fr  ASC     ,
                                compendium_images.uploaded_at       DESC    " ,
    'tags'    => "  ORDER BY    compendium_images.tags              != ''   ,
                                compendium_images.tags              ASC     ,
                                compendium_images.uploaded_at       DESC    " ,
    'caption' => "  ORDER BY (  compendium_images.caption_en        != ''
                    AND         compendium_images.caption_fr        != '' ) ,
                                compendium_images.caption_fr        != ''   ,
                                compendium_images.caption_en        != ''   ,
                                compendium_images.uploaded_at       DESC    " ,
    'views'   => "  ORDER BY    compendium_images.view_count        DESC    ,
                                compendium_images.uploaded_at       DESC    " ,
    'seen'    => "  ORDER BY    compendium_images.last_seen_on      DESC    ,
                                compendium_images.uploaded_at       DESC    " ,
    'deleted' => "  ORDER BY    compendium_images.is_deleted        DESC    ,
                                compendium_images.uploaded_at       DESC    " ,
    default   => "  ORDER BY    compendium_images.uploaded_at       DESC    " ,
  };

  // Fetch the images
  $qimages = query("  SELECT  compendium_images.id                AS 'ci_id'          ,
                              compendium_images.is_deleted        AS 'ci_del'         ,
                              compendium_images.uploaded_at       AS 'ci_date'        ,
                              compendium_images.file_name         AS 'ci_name'        ,
                              compendium_images.tags              AS 'ci_tags'        ,
                              compendium_images.view_count        AS 'ci_viewcount'   ,
                              compendium_images.last_seen_on      AS 'ci_seen'        ,
                              compendium_images.is_nsfw           AS 'ci_nsfw'        ,
                              compendium_images.is_gross          AS 'ci_gross'       ,
                              compendium_images.is_offensive      AS 'ci_offensive'   ,
                              compendium_images.used_in_pages_en  AS 'ci_used_en'     ,
                              compendium_images.used_in_pages_fr  AS 'ci_used_fr'     ,
                              compendium_images.caption_$lang     AS 'ci_caption'     ,
                              compendium_images.caption_en        AS 'ci_caption_en'  ,
                              compendium_images.caption_fr        AS 'ci_caption_fr'
                    FROM      compendium_images
                              $query_search
                              $query_sort ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qimages); $i++)
  {
    $data[$i]['id']         = sanitize_output($row['ci_id']);
    $data[$i]['deleted']    = ($row['ci_del']) ? 1 : 0;
    $data[$i]['name']       = sanitize_output(string_truncate($row['ci_name'], 18, '...'));
    $data[$i]['fullname']   = sanitize_output($row['ci_name']);
    $data[$i]['date']       = sanitize_output(time_since($row['ci_date']));
    $data[$i]['blur']       = ($row['ci_nsfw'] || $row['ci_gross'] || $row['ci_offensive']) ? 1 : 0;
    $data[$i]['nsfw']       = $row['ci_nsfw'];
    $data[$i]['gross']      = $row['ci_gross'];
    $data[$i]['offensive']  = $row['ci_offensive'];
    $page_links             = ($row['ci_used_en']) ? compendium_images_assemble_links($row['ci_used_en'], true) : '';
    $data[$i]['used_en']    = ($row['ci_used_en']) ? $page_links['list'] : '';
    $page_links             = ($row['ci_used_en']) ? compendium_images_assemble_links($row['ci_used_en']) : '';
    $data[$i]['used_en_f']  = ($row['ci_used_en']) ? $page_links['list'] : '';
    $page_links             = ($row['ci_used_fr']) ? compendium_images_assemble_links($row['ci_used_fr'], true) : '';
    $data[$i]['used_fr']    = ($row['ci_used_fr']) ? $page_links['list'] : '';
    $page_links             = ($row['ci_used_fr']) ? compendium_images_assemble_links($row['ci_used_fr']) : '';
    $data[$i]['used_fr_f']  = ($row['ci_used_fr']) ? $page_links['list'] : '';
    $tags                   = ($row['ci_tags']) ? compendium_images_assemble_tags($row['ci_tags'], true) : '';
    $data[$i]['tags']       = ($row['ci_tags']) ? $tags['list'] : '';
    $tags                   = ($row['ci_tags']) ? compendium_images_assemble_tags($row['ci_tags']) : '';
    $data[$i]['tags_full']  = ($row['ci_tags']) ? $tags['list'] : '';
    $data[$i]['caption_en'] = ($row['ci_caption_en']) ? 1 : 0;
    $data[$i]['caption_fr'] = ($row['ci_caption_fr']) ? 1 : 0;
    $data[$i]['body']       = nbcodes(sanitize_output($row['ci_caption'], preserve_line_breaks: true),
                                      page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
    $data[$i]['views']      = ($row['ci_viewcount'] > 1)
                            ? sanitize_output(number_display_format($row['ci_viewcount'], "number"))
                            : '&nbsp;';
    $data[$i]['seen']       = ($row['ci_seen']) ? sanitize_output(time_since($row['ci_seen'])) : '&nbsp;';
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Uploads a new compendium image.
 *
 * @param   array   $file       The image being uploaded.
 * @param   array   $contents   The contents of the image data.
 *
 * @return  string|int              A string if an error happened, or the new compendium image's ID if all went well.
 */

function compendium_images_upload(  array   $file     ,
                                    array   $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Error: File data is missing
  if(!isset($file['name']) || !$file['name'] || !isset($file['type']) || !$file['type'] || !isset($file['tmp_name']) || !$file['tmp_name'])
    return __('compendium_image_upload_missing');

  // Error: Upload went wrong
  if(!isset($file['error']) || $file['error'])
    return __('compendium_image_upload_error');

  // Error: File name is missing
  if(!isset($contents['name']) || !$contents['name'])
    return __('compendium_image_upload_misnamed');

  // Sanitize and prepare the data
  $timestamp  = sanitize(time(), 'int', 0);
  $name_raw   = compendium_format_image_name($contents['name']);
  $name       = sanitize($name_raw, 'string');
  $file_path  = root_path().'img/compendium/'.$name_raw;
  $tmp_name   = $file['tmp_name'];

  // Error: Incorrect file name
  if(!$name)
    return __('compendium_image_upload_misnamed');

  // Error: File already exists
  if(file_exists($file_path))
    return __('compendium_image_upload_duplicate');

  // Error: File name already used
  if(database_entry_exists('compendium_images', 'file_name', $name))
    return __('compendium_image_upload_filename');

  // Sanitize and prepare the rest of the contents
  $tags       = sanitize_array_element($contents, 'tags', 'string', case: 'lowercase');
  $caption_en = sanitize_array_element($contents, 'caption_en', 'string');
  $caption_fr = sanitize_array_element($contents, 'caption_fr', 'string');
  $nsfw       = sanitize_array_element($contents, 'nsfw', 'int', min: 0, max: 1, default: 0);
  $gross      = sanitize_array_element($contents, 'gross', 'int', min: 0, max: 1, default: 0);
  $offensive  = sanitize_array_element($contents, 'offensive', 'int', min: 0, max: 1, default: 0);

  // Upload the image
  if(move_uploaded_file($tmp_name, $file_path))
  {
    // Create the image entry
    query(" INSERT INTO compendium_images
            SET         compendium_images.uploaded_at   = '$timestamp'  ,
                        compendium_images.file_name     = '$name'       ,
                        compendium_images.tags          = '$tags'       ,
                        compendium_images.is_nsfw       = '$nsfw'       ,
                        compendium_images.is_gross      = '$gross'      ,
                        compendium_images.is_offensive  = '$offensive'  ,
                        compendium_images.caption_en    = '$caption_en' ,
                        compendium_images.caption_fr    = '$caption_fr' ");

    // Fetch the newly created compendium page type's id
    $image_id = query_id();
  }

  // Upload failed
  else
    return __('compendium_image_upload_failed');

  // Return the compendium page type's id
  return $image_id;
}




/**
 * Modifies an existing compendium image.
 *
 * @param   int           $image_id   The id of the image to edit.
 * @param   array         $contents   The contents of the image.
 *
 * @return  string|null               A string if an error happened, or null if all went well.
 */

function compendium_images_edit(  int   $image_id  ,
                                  array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the page's id
  $image_id = sanitize($image_id, 'int', 0);

  // Stop here if the page doesn't exist
  if(!database_row_exists('compendium_images', $image_id))
    return __('compendium_image_edit_missing');

  // Fetch the image data
  $image_data = compendium_images_get(image_id: $image_id);

  // Stop here if the image data is missing
  if(!isset($image_data) || !$image_data)
    return __('compendium_image_edit_missing');

  // Sanitize and prepare the data
  $image_name_raw   = isset($contents['name']) ? $contents['name'] : '';
  $image_name       = sanitize(compendium_format_image_name($contents['name']), 'string');
  $image_tags       = sanitize_array_element($contents, 'tags', 'string', case: 'lowercase');
  $image_caption_en = sanitize_array_element($contents, 'caption_en', 'string');
  $image_caption_fr = sanitize_array_element($contents, 'caption_fr', 'string');
  $image_nsfw       = sanitize_array_element($contents, 'nsfw', 'int', min: 0, max: 1, default: 0);
  $image_gross      = sanitize_array_element($contents, 'gross', 'int', min: 0, max: 1, default: 0);
  $image_offensive  = sanitize_array_element($contents, 'offensive', 'int', min: 0, max: 1, default: 0);

  // Error: No image name
  if(!$image_name)
    return __('compendium_image_upload_misnamed');

  // Move the image file if necessary
  if($image_name_raw !== $image_data['name_raw'])
  {
    // Determine the previous and new file paths
    $old_file_path  = root_path().'img/compendium/'.$image_data['name_raw'];
    $new_file_path  = root_path().'img/compendium/'.$image_name_raw;

    // Error: Old file name does not exist
    if(!file_exists($old_file_path))
      return __('compendium_image_edit_not_found');

    // Error: New file name already exists
    if(file_exists($new_file_path))
      return __('compendium_image_upload_duplicate');

    // Error: File name already used
    if(database_entry_exists('compendium_images', 'file_name', $new_file_path))
      return __('compendium_image_upload_filename');

    // Move the file
    if(!rename($old_file_path, $new_file_path))
      return __('compendium_image_edit_no_rename');
  }

  // Update the image page
  query(" UPDATE  compendium_images
          SET     compendium_images.file_name     = '$image_name'       ,
                  compendium_images.tags          = '$image_tags'       ,
                  compendium_images.is_nsfw       = '$image_nsfw'       ,
                  compendium_images.is_gross      = '$image_gross'      ,
                  compendium_images.is_offensive  = '$image_offensive'  ,
                  compendium_images.caption_en    = '$image_caption_en' ,
                  compendium_images.caption_fr    = '$image_caption_fr'
          WHERE   compendium_images.id            = '$image_id' " );

  // All went well, return null
  return NULL;
}




/**
 * Deletes an existing compendium image.
 *
 * @param   int     $image_id   The ID of the compendium image to delete.
 * @param   string  $action     The action to perform ('delete', 'restore', 'hard_delete').
 *
 * @return  void
 */

function compendium_images_delete(  int     $image_id ,
                                    string  $action   ) : void
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the image's id
  $image_id = sanitize($image_id, 'int', 0);

  // Stop here if the image does not exist
  if(!database_row_exists('compendium_images', $image_id))
    return;

  // Fetch the image's data
  $image_data = compendium_images_get($image_id);

  // Stop here if the image is used on any page
  if($action !== 'restore' && $image_data['used_en'] || $image_data['used_fr'])
    return;

  // Soft deletion
  if($action === 'delete')
    query(" UPDATE  compendium_images
            SET     compendium_images.is_deleted  = 1
            WHERE   compendium_images.id          = '$image_id' ");

  // Restoration
  if($action === 'restore')
    query(" UPDATE  compendium_images
            SET     compendium_images.is_deleted  = 0
            WHERE   compendium_images.id          = '$image_id' ");

  // Hard deletion
  if($action === 'hard_delete')
  {
    // Delete the database entry
    query(" DELETE FROM compendium_images
            WHERE       compendium_images.id = '$image_id' ");

    // Assemble the file name
    $file_name = root_path().'img/compendium/'.$image_data['name_raw'];

    // Delete the file
    if(file_exists($file_name))
      unlink($file_name);
  }
}




/**
 * Recalculates the compendium pages on which an image is being used.
 *
 * @param   int|string  $image  The image's id or file name.
 *
 * @return  void
 */

function compendium_images_recalculate_links( int|string $image ) : void
{
  // If a file name has been provided, find its id
  if(!is_int($image))
  {
    // Sanitize the file name
    $image_name = sanitize($image, 'string');

    // Stop here if the image doesn't have a name
    if(!$image_name)
      return;

    // Stop here if the image doesn't exist
    if(!database_entry_exists('compendium_images', 'file_name', $image_name))
      return;

    // Fetch the image's id
    $dimage = mysqli_fetch_array(query("  SELECT  compendium_images.id  AS 'ci_id'
                                          FROM    compendium_images
                                          WHERE   compendium_images.file_name LIKE '$image_name' "));

    // Sanitize the image's id
    $image_id = sanitize($dimage['ci_id'], 'int', 0);
  }

  // If an id has been provided, find its file name
  else
  {
    // Sanitize the image's id
    $image_id = sanitize($image, 'int', 0);

    // Stop here if the image doesn't exist
    if(!database_row_exists('compendium_images', $image_id))
      return;

    // Fetch the image's name
    $dimage = mysqli_fetch_array(query("  SELECT  compendium_images.file_name AS 'ci_name'
                                          FROM    compendium_images
                                          WHERE   compendium_images.id = '$image_id' "));

    // Sanitize the image's name
    $image_name = sanitize($dimage['ci_name'], 'string');

    // Stop here if the image doesn't have a name
    if(!$image_name)
      return;
  }

  // Prepare strings for the image usages
  $usage_list_en  = '';
  $usage_list_fr  = '';

  // Look up page types containing the image
  $qusage = query(" SELECT    compendium_types.id           AS 'ct_id'  ,
                              compendium_types.full_name_en AS 'ct_name'
                    FROM      compendium_types
                    WHERE     compendium_types.description_en LIKE '%:$image_name%'
                    ORDER BY  compendium_types.full_name_en ASC ");

  // Add any english page types to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_en .= ($usage_list_en) ? '|||' : '';
    $usage_list_en .= 'page_type?type='.$dusage['ct_id'].'|||Type: '.$dusage['ct_name'];
  }

  // Look up page types containing the image in french
  $qusage = query(" SELECT    compendium_types.id           AS 'ct_id'  ,
                              compendium_types.full_name_fr AS 'ct_name'
                    FROM      compendium_types
                    WHERE     compendium_types.description_fr LIKE '%:$image_name%'
                    ORDER BY  compendium_types.full_name_fr ASC ");

  // Add any french page types to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_fr .= ($usage_list_fr) ? '|||' : '';
    $usage_list_fr .= 'page_type?type='.$dusage['ct_id'].'|||Thématique: '.$dusage['ct_name'];
  }

  // Look up categories containing the image in english
  $qusage = query(" SELECT    compendium_categories.id      AS 'cc_id'  ,
                              compendium_categories.name_en AS 'cc_name'
                    FROM      compendium_categories
                    WHERE     compendium_categories.description_en LIKE '%:$image_name%'
                    ORDER BY  compendium_categories.name_en ASC ");

  // Add any english categories to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_en .= ($usage_list_en) ? '|||' : '';
    $usage_list_en .= 'category?id='.$dusage['cc_id'].'|||Category: '.$dusage['cc_name'];
  }

  // Look up categories containing the image in french
  $qusage = query(" SELECT    compendium_categories.id      AS 'cc_id'  ,
                              compendium_categories.name_fr AS 'cc_name'
                    FROM      compendium_categories
                    WHERE     compendium_categories.description_fr LIKE '%:$image_name%'
                    ORDER BY  compendium_categories.name_fr ASC ");

  // Add any french categories to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_fr .= ($usage_list_fr) ? '|||' : '';
    $usage_list_fr .= 'category?id='.$dusage['cc_id'].'|||Category: '.$dusage['cc_name'];
  }

  // Look up eras containing the image in english
  $qusage = query(" SELECT    compendium_eras.id      AS 'ce_id'  ,
                              compendium_eras.name_en AS 'ce_name'
                    FROM      compendium_eras
                    WHERE     compendium_eras.description_en LIKE '%:$image_name%'
                    ORDER BY  compendium_eras.name_en ASC ");

  // Add any english eras to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_en .= ($usage_list_en) ? '|||' : '';
    $usage_list_en .= 'cultural_era?era='.$dusage['ce_id'].'|||Era: '.$dusage['ce_name'];
  }

  // Look up eras containing the image in french
  $qusage = query(" SELECT    compendium_eras.id      AS 'ce_id'  ,
                              compendium_eras.name_fr AS 'ce_name'
                    FROM      compendium_eras
                    WHERE     compendium_eras.description_fr LIKE '%:$image_name%'
                    ORDER BY  compendium_eras.name_fr ASC ");

  // Add any french eras to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_fr .= ($usage_list_fr) ? '|||' : '';
    $usage_list_fr .= 'cultural_era?era='.$dusage['ce_id'].'|||Période: '.$dusage['ce_name'];
  }

  // Look up pages containing the image in english
  $qusage = query(" SELECT    compendium_pages.page_url   AS 'c_url'  ,
                              compendium_pages.title_en   AS 'c_title'
                    FROM      compendium_pages
                    WHERE     compendium_pages.is_deleted     =   0
                    AND       compendium_pages.is_draft       =   0
                    AND       compendium_pages.title_en       !=  ''
                    AND       compendium_pages.redirection_en =   ''
                    AND       compendium_pages.definition_en  LIKE '%:$image_name%'
                    ORDER BY  compendium_pages.title_en       ASC ");

  // Add any english page names to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_en .= ($usage_list_en) ? '|||' : '';
    $usage_list_en .= $dusage['c_url'].'|||'.$dusage['c_title'];
  }

  // Look up pages containing the image in french
  $qusage = query(" SELECT    compendium_pages.page_url   AS 'c_url'  ,
                              compendium_pages.title_fr   AS 'c_title'
                    FROM      compendium_pages
                    WHERE     compendium_pages.is_deleted     =   0
                    AND       compendium_pages.is_draft       =   0
                    AND       compendium_pages.title_fr       !=  ''
                    AND       compendium_pages.redirection_fr =   ''
                    AND       compendium_pages.definition_fr  LIKE '%:$image_name%'
                    ORDER BY  compendium_pages.title_fr       ASC ");

  // Add any french page names to the string
  while($dusage = mysqli_fetch_array($qusage))
  {
    $usage_list_fr .= ($usage_list_fr) ? '|||' : '';
    $usage_list_fr .= $dusage['c_url'].'|||'.$dusage['c_title'];
  }

  // Sanitize the page lists
  $usage_list_en = sanitize($usage_list_en, 'string');
  $usage_list_fr = sanitize($usage_list_fr, 'string');

  // Update the image's links
  query(" UPDATE  compendium_images
          SET     compendium_images.used_in_pages_en  = '$usage_list_en'  ,
                  compendium_images.used_in_pages_fr  = '$usage_list_fr'
          WHERE   compendium_images.id                = '$image_id'       ");
}




/**
 * Recalculates all compendium image links.
 *
 * @return  void
 */

function compendium_images_recalculate_all_links()
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Fetch all compendium images
  $qimages = query("  SELECT    compendium_images.id AS 'ci_id'
                      FROM      compendium_images
                      ORDER BY  compendium_images.uploaded_at DESC ");

  // Loop through the images and recalculate the links
  while($dimages = mysqli_fetch_array($qimages))
    compendium_images_recalculate_links($dimages['ci_id']);
}




/**
 * Lists all compendium pages containing an image in a usable format.
 *
 * @param   string  $page_list              A list of compendium pages.
 * @param   bool    $shorten    (OPTIONAL)  Shorten long page names.
 *
 * @return  array               The formatted list and the page count.
 */

function compendium_images_assemble_links(  string  $page_list          ,
                                            bool    $shorten    = false ) : array
{
  // Split the page list
  $page_list_array = explode("|||", $page_list);

  // Format the page list
  $formatted_page_list = '';
  for($i = 0; $i < count($page_list_array); $i++)
  {
    if(!($i % 2) && isset($page_list_array[$i + 1]))
    {
      $short_name = ($shorten) ? string_truncate($page_list_array[$i + 1], 18, '...') : $page_list_array[$i + 1];
      $formatted_page_list .= __link('pages/compendium/'.$page_list_array[$i], sanitize_output($short_name)).'<br>';
    }
  }

  // Add the formatted page list and the page count to the returned data
  $data['list']   = $formatted_page_list;
  $data['count']  = ($i) ? floor($i / 2) : 0;

  // Return the formatted page list
  return $data;
}




/**
 * Transforms compendium image tags into a usable format.
 *
 * @param   string  $tags                 A list of compendium tags.
 * @param   bool    $shorten  (OPTIONAL)  Shorten long tags.
 *
 * @return  array                         The formatted tag list and the tag count.
 */

function compendium_images_assemble_tags( string  $tags             ,
                                          bool    $shorten  = false ) : array
{
  // Split the tags
  $tags_array = explode(";", $tags);

  // Format the tags
  $formatted_tags = '';
  for($i = 0; $i < count($tags_array); $i++)
  {
    $short_name = ($shorten) ? string_truncate($tags_array[$i], 15, '...') : $tags_array[$i];
    $formatted_tags .= sanitize_output($short_name).'<br>';
  }

  // Add the formatted tag list and the tag count to the returned data
  $data['list']   = $formatted_tags;
  $data['count']  = $i;

  // Return the formatted page list
  return $data;
}




/**
 * Updates the pageview count for an existing compendium image.
 *
 * @param   string  $image_id   The compendium image's id.
 * @param   string  $page_url   The complete page url.
 */

function compendium_images_update_pageviews(  int     $image_id ,
                                              string  $page_url )
{
  // Sanitize the data
  $page_url = sanitize($page_url, 'string');
  $image_id = sanitize($image_id, 'int', 0);

  // Ensure the compendium image exists
  if(!$page_url || !$image_id || !database_row_exists('compendium_images', $image_id))
    return;

  // Fetch the pageview count
  $dviews = mysqli_fetch_array(query("  SELECT  stats_pages.view_count AS 'sp_count'
                                        FROM    stats_pages
                                        WHERE   stats_pages.page_url LIKE '$page_url' "));

  // Sanitize the pageview count and the current timestamp
  $view_count = (isset($dviews['sp_count']) && $dviews['sp_count']) ? sanitize($dviews['sp_count'], 'int', 0) : 0;
  $timestamp  = sanitize(time(), 'int', 0);

  // Update the pageview count
  query(" UPDATE  compendium_images
          SET     compendium_images.view_count    = '$view_count' ,
                  compendium_images.last_seen_on  = '$timestamp'
          WHERE   compendium_images.id            = '$image_id' ");
}




/**
 * Autocompletes an image file name.
 *
 * @param   string      $input  The input that needs to be autocompleted.
 *
 * @return  array|null          An array containing autocomplete data, or NULL if something failed.
 */

function compendium_images_autocomplete( string $input ) : mixed
{
  // Sanitize the input
  $input  = sanitize($input, 'string');

  // Only work when more than 1 character has been submitted
  if(mb_strlen($input) < 1)
    return NULL;

  // Look for image file names to add to autocompletion
  $qimages = query("  SELECT    compendium_images.file_name AS 'ci_name'
                      FROM      compendium_images
                      WHERE     compendium_images.file_name LIKE '$input%'
                      ORDER BY  compendium_images.file_name ASC
                      LIMIT     10 ");

  // Prepare the returned data
  for($i = 0; $dimages = mysqli_fetch_array($qimages); $i++)
    $data[$i]['url'] = sanitize_output($dimages['ci_name']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns data related to a missing compendium page.
 *
 * @param   int         $missing_id   (OPTIONAL)  The missing page's id. One of these two parameters should be set.
 * @param   string      $missing_url  (OPTIONAL)  The missing page's url. One of these two parameters should be set.
 *
 * @return  array|null                            An array containing page related data, or NULL if it does not exist.
 */

function compendium_missing_get(  int     $missing_id   = 0   ,
                                  string  $missing_url  = ''  ) : mixed
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Get the user's current language, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Sanitize the data
  $missing_url_raw  = $missing_url;
  $missing_id       = sanitize($missing_id, 'int', 0);
  $missing_url      = sanitize($missing_url, 'string');

  // Return null if both parameters are missing
  if(!$missing_id && !$missing_url)
    return NULL;

  // Return null if both parameters are set
  if($missing_id && $missing_url)
    return NULL;

  // Check if the missing page exists
  if($missing_id && !database_row_exists('compendium_missing', $missing_id))
    return NULL;

  // Fetch the missing page data if an id was provided
  if($missing_id || database_entry_exists('compendium_missing', 'page_url', $missing_url))
  {
    // Prepare the query's parameter
    $where = ($missing_id) ? " compendium_missing.id = '$missing_id' " : " compendium_missing.page_url LIKE '$missing_url' ";

    // Fetch the data
    $dmissing = mysqli_fetch_array(query("  SELECT  compendium_missing.id                   AS 'cm_id'        ,
                                                    compendium_missing.fk_compendium_types  AS 'cm_type'      ,
                                                    compendium_missing.page_url             AS 'cm_url'       ,
                                                    compendium_missing.title                AS 'cm_title'     ,
                                                    compendium_missing.is_a_priority        AS 'cm_priority'  ,
                                                    compendium_missing.notes                AS 'cm_notes'
                                            FROM    compendium_missing
                                            WHERE   $where "));

    // Assemble an array with the missing data
    $missing_url_raw  = $dmissing['cm_url'];
    $missing_url      = sanitize($missing_url_raw, 'string');
    $missing_id       = $dmissing['cm_id'];
    $data['type']     = sanitize_output($dmissing['cm_type']);
    $data['title']    = sanitize_output($dmissing['cm_title']);
    $data['prio']     = sanitize_output($dmissing['cm_priority']);
    $data['body']     = nbcodes(sanitize_output($dmissing['cm_notes'], preserve_line_breaks: true),
                                page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
    $data['notes']    = sanitize_output($dmissing['cm_notes']);
  }

  // If no id was provided, fill up the array with empty data
  else
  {
    $data['title']  = '';
    $data['body']   = '';
  }

  // Return null if the missing page has no valid url
  if(!$missing_url_raw)
    return NULL;

  // Assemble an array with the data
  $data['id']       = sanitize_output($missing_id);
  $data['url']      = sanitize_output($missing_url_raw);
  $data['url_raw']  = $missing_url_raw;

  // Assemble the missing page NBCode
  $missing_page_nbcode = '[page:'.$missing_url.'|';

  // Look for calls to this missing page in compendium pages
  $qpages = query(" SELECT    compendium_pages.page_url AS 'c_url'  ,
                              compendium_pages.title_en AS 'c_title'
                    FROM      compendium_pages
                    WHERE   ( compendium_pages.summary_en     LIKE '%$missing_page_nbcode%'
                    OR        compendium_pages.summary_fr     LIKE '%$missing_page_nbcode%'
                    OR        compendium_pages.definition_en  LIKE '%$missing_page_nbcode%'
                    OR        compendium_pages.definition_fr  LIKE '%$missing_page_nbcode%' )
                    ORDER BY  compendium_pages.page_url ASC ");

  // Add any missing page to the returned data
  for($count_pages = 0; $dpages = mysqli_fetch_array($qpages); $count_pages++)
  {
    $data[$count_pages]['page_url']   = sanitize_output($dpages['c_url']);
    $data[$count_pages]['page_title'] = sanitize_output($dpages['c_title']);
  }

  // Look for calls to this missing page in compendium images
  $qimages = query("  SELECT    compendium_images.file_name AS 'ci_name'
                      FROM      compendium_images
                      WHERE   ( compendium_images.caption_en  LIKE '%$missing_page_nbcode%'
                      OR        compendium_images.caption_fr  LIKE '%$missing_page_nbcode%' )
                      ORDER BY  compendium_images.file_name ASC ");

  // Add any missing image to the returned data
  for($count_images = 0; $dimages = mysqli_fetch_array($qimages); $count_images++)
    $data[$count_images]['image_name'] = sanitize_output($dimages['ci_name']);

  // Look for calls to this missing page in compendium categories
  $qcategories = query("  SELECT    compendium_categories.id          AS 'cc_id' ,
                                    compendium_categories.name_$lang  AS 'cc_name'
                          FROM      compendium_categories
                          WHERE   ( compendium_categories.description_en  LIKE '%$missing_page_nbcode%'
                          OR        compendium_categories.description_fr  LIKE '%$missing_page_nbcode%' )
                          ORDER BY  compendium_categories.name_$lang ASC ");

  // Add any missing categories to the returned data
  for($count_categories = 0; $dcategories = mysqli_fetch_array($qcategories); $count_categories++)
  {
    $data[$count_categories]['category_id']   = sanitize_output($dcategories['cc_id']);
    $data[$count_categories]['category_name'] = sanitize_output($dcategories['cc_name']);
  }

  // Look for calls to this missing page in compendium eras
  $qeras = query("  SELECT    compendium_eras.id          AS 'ce_id' ,
                              compendium_eras.name_$lang  AS 'ce_name'
                    FROM      compendium_eras
                    WHERE   ( compendium_eras.description_en  LIKE '%$missing_page_nbcode%'
                    OR        compendium_eras.description_fr  LIKE '%$missing_page_nbcode%' )
                    ORDER BY  compendium_eras.name_$lang ASC ");

  // Add any missing eras to the returned data
  for($count_eras = 0; $deras = mysqli_fetch_array($qeras); $count_eras++)
  {
    $data[$count_eras]['era_id']    = sanitize_output($deras['ce_id']);
    $data[$count_eras]['era_name']  = sanitize_output($deras['ce_name']);
  }

  // Look for calls to this missing page in compendium page types
  $qtypes = query(" SELECT    compendium_types.id               AS 'ct_id' ,
                              compendium_types.full_name_$lang  AS 'ct_name'
                    FROM      compendium_types
                    WHERE   ( compendium_types.description_en LIKE '%$missing_page_nbcode%'
                    OR        compendium_types.description_fr LIKE '%$missing_page_nbcode%' )
                    ORDER BY  compendium_types.full_name_$lang ASC ");

  // Add any missing page types to the returned data
  for($count_types = 0; $dtypes = mysqli_fetch_array($qtypes); $count_types++)
  {
    $data[$count_types]['type_id']    = sanitize_output($dtypes['ct_id']);
    $data[$count_types]['type_name']  = sanitize_output($dtypes['ct_name']);
  }

  // Sum up the total missing page calls count and all them to the returned data
  $data['count_pages']      = $count_pages;
  $data['count_images']     = $count_images;
  $data['count_categories'] = $count_categories;
  $data['count_eras']       = $count_eras;
  $data['count_types']      = $count_types;
  $data['count']            = $count_pages + $count_images + $count_categories + $count_eras + $count_types;

  // Return the data
  return $data;
}




/**
 * Returns data related to a random missing compendium page.
 *
 * @param   int   $exclude_id   (OPTIONAL)  A missing page id to exclude from the missing pages being fetched.
 *
 * @return  int                             The id of a randomly chosen missing compendium page.
 */

function compendium_missing_get_random( int $exclude_id = 0 ) : string
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the excluded id
  $exclude_id = sanitize($exclude_id, 'int', 0);

  // Add the excluded id if necessary
  $query_exclude = ($exclude_id) ? " WHERE compendium_missing.id != '$exclude_id' " : '';

  // Fetch a random missing page's id
  $dpage = mysqli_fetch_array(query(" SELECT    compendium_missing.id AS 'cm_id'
                                      FROM      compendium_missing
                                                $query_exclude
                                      ORDER BY  RAND()
                                      LIMIT     1 "));

  // If no page has been found, return an empty string
  if(!isset($dpage['cm_id']))
    return '';

  // Otherwise, return the page url
  return $dpage['cm_id'];
}




/**
 * Fetches a list of all missing compendium pages.
 *
 * @param   string  $sort_by    (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search     (OPTIONAL)  Search for specific field values.
 *
 * @return  array                           An array containing wanted missing pages from the compendium.
 */

function compendium_missing_list( string  $sort_by  = 'url'   ,
                                  array   $search   = array() ) : array
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Get the user's current language, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Sanitize and prepare the data
  $missing          = array();
  $links            = array();
  $call_count       = array();
  $urls             = array();
  $search_url       = sanitize_array_element($search, 'url', 'string');
  $search_title     = sanitize_array_element($search, 'title', 'string');
  $search_type      = sanitize_array_element($search, 'type', 'int', min: 0, default: 0);
  $search_priority  = sanitize_array_element($search, 'priority', 'int', min: -1, max: 1, default: -1);
  $search_notes     = sanitize_array_element($search, 'notes', 'int', min: -1, max: 1, default: -1);
  $search_links     = sanitize_array_element($search, 'links', 'int', min: 0, max: 1, default: 0);
  $search_status    = sanitize_array_element($search, 'status', 'int', min: -1, max: 1, default: -1);

  // Fetch a list of all urls
  $qurls = query("  SELECT    compendium_pages.page_url AS 'c_url'
                    FROM      compendium_pages
                    ORDER BY  compendium_pages.id ASC ");

  // Turn the url list into an array
  while($durls = mysqli_fetch_array($qurls))
    array_push($urls, $durls['c_url']);

  // Fetch a list of all pages
  $qpages = query(" SELECT    compendium_pages.summary_en     AS 'c_summary_en' ,
                              compendium_pages.summary_fr     AS 'c_summary_fr' ,
                              compendium_pages.definition_en  AS 'c_body_en'    ,
                              compendium_pages.definition_fr  AS 'c_body_fr'
                    FROM      compendium_pages
                    WHERE     compendium_pages.is_deleted = 0
                    ORDER BY  compendium_pages.id ASC ");

  // Loop through the pages
  while($dpages = mysqli_fetch_array($qpages))
  {
    // Reset the list of already called pages
    $called = array();

    // Look for missing pages in the english definitions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_body_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }

    // Look for missing pages in the french definitions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_body_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }

    // Look for missing pages in the english summaries
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_summary_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }

    // Look for missing pages in the french summaries
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_summary_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }
  }

  // Fetch a list of all images
  $qimages = query("  SELECT    compendium_images.caption_en  AS 'ci_caption_en' ,
                                compendium_images.caption_fr  AS 'ci_caption_fr'
                      FROM      compendium_images
                      WHERE     compendium_images.is_deleted = 0
                      ORDER BY  compendium_images.id ASC ");

  // Loop through the images
  while($dimages = mysqli_fetch_array($qimages))
  {
    // Reset the list of already called pages
    $called = array();

    // Look for missing pages in the english captions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dimages['ci_caption_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }

    // Look for missing pages in the french captions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dimages['ci_caption_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }
  }

  // Fetch a list of all categories
  $qcategories = query("  SELECT    compendium_categories.description_en  AS 'cc_body_en' ,
                                    compendium_categories.description_fr  AS 'cc_body_fr'
                          FROM      compendium_categories
                          ORDER BY  compendium_categories.id ASC ");

  // Loop through the categories
  while($dcategories = mysqli_fetch_array($qcategories))
  {
    // Reset the list of already called pages
    $called = array();

    // Look for missing pages in the english category descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dcategories['cc_body_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }

    // Look for missing pages in the french category descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dcategories['cc_body_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }
  }

  // Fetch a list of all eras
  $qeras = query("  SELECT    compendium_eras.description_en  AS 'ce_body_en' ,
                              compendium_eras.description_fr  AS 'ce_body_fr'
                    FROM      compendium_eras
                    ORDER BY  compendium_eras.id ASC ");

  // Loop through the eras
  while($deras = mysqli_fetch_array($qeras))
  {
    // Reset the list of already called pages
    $called = array();

    // Look for missing pages in the english era descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $deras['ce_body_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }

    // Look for missing pages in the french era descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $deras['ce_body_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }
  }

  // Fetch a list of all page types
  $qtypes = query(" SELECT    compendium_types.description_en AS 'ct_body_en' ,
                              compendium_types.description_fr AS 'ct_body_fr'
                    FROM      compendium_types
                    ORDER BY  compendium_types.id ASC ");

  // Loop through the page types
  while($dtypes = mysqli_fetch_array($qtypes))
  {
    // Reset the list of already called pages
    $called = array();

    // Look for missing pages in the english page types descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dtypes['ct_body_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }

    // Look for missing pages in the french page types descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dtypes['ct_body_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i], no_reserved_urls: true);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
      if(!isset($called[$dead_link]))
      {
        $call_count[$dead_link] = (!isset($call_count[$dead_link])) ? 1 : ($call_count[$dead_link] + 1);
        $called[$dead_link] = 1;
      }
    }
  }

  // Remove non matching array elements in case a search is being performed
  if($search_url)
  {
    foreach($missing as $missing_page)
    {
      if(!str_contains($missing_page, $search_url))
        array_splice($missing, array_search($missing_page, $missing), 1);
    }
  }

  // Remove all elements from array if some searches are being performed
  if($search_title || $search_type || $search_priority > -1 || $search_notes > -1 || $search_status === 1)
    $missing = array();

  // Search through the data
  $query_search  = ($search_url)            ? " AND compendium_missing.page_url        LIKE '%$search_url%'     " : "";
  $query_search .= ($search_title)          ? " AND compendium_missing.title           LIKE '%$search_title%'   " : "";
  $query_search .= ($search_notes === 0)    ? " AND compendium_missing.notes              = ''                  " : "";
  $query_search .= ($search_notes === 1)    ? " AND compendium_missing.notes             != ''                  " : "";
  $query_search .= ($search_type)           ? " AND compendium_missing.fk_compendium_types = '$search_type'     " : "";
  $query_search .= ($search_priority > -1)  ? " AND compendium_missing.is_a_priority      = '$search_priority'  " : "";

  // Do not fetch any missing pages when searching for links or sorting by links
  $query_search .= ($search_links || ($sort_by === 'links' && $search_status !== 0)) ? " AND 0 = 1 " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'url'   => " ORDER BY compendium_missing.page_url             ASC   " ,
    'title' => " ORDER BY compendium_missing.title                = ''  ,
                          compendium_missing.title                ASC   ,
                          compendium_missing.page_url             ASC   " ,
    'type'  => " ORDER BY compendium_missing.fk_compendium_types  = ''  ,
                          compendium_types.name_$lang             ASC   ,
                          compendium_missing.is_a_priority        DESC  ,
                          compendium_missing.page_url             ASC   " ,
    'notes' => " ORDER BY compendium_missing.notes                = ''  ,
                          compendium_missing.page_url             ASC   " ,
    default => " ORDER BY compendium_missing.is_a_priority        DESC  ,
                          compendium_missing.page_url             ASC   " ,
  };

  // Fetch the missing pages in the database
  $qmissing = query(" SELECT    compendium_missing.id             AS 'cm_id'        ,
                                compendium_missing.page_url       AS 'cm_url'       ,
                                compendium_missing.title          AS 'cm_title'     ,
                                compendium_missing.is_a_priority  AS 'cm_priority'  ,
                                compendium_missing.notes          AS 'cm_notes'     ,
                                compendium_types.name_$lang       AS 'cm_type'
                      FROM      compendium_missing
                      LEFT JOIN compendium_types ON compendium_missing.fk_compendium_types = compendium_types.id
                      WHERE     1 = 1
                                $query_search
                                $query_sort ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmissing); $i++)
  {
    // Format the data
    $data[$i]['id']         = sanitize_output($row['cm_id']);
    $data[$i]['url']        = sanitize_output($row['cm_url']);
    $data[$i]['urldisplay'] = sanitize_output(string_truncate($row['cm_url'], 22, '...'));
    $data[$i]['fullurl']    = (mb_strlen($row['cm_url']) > 22) ? sanitize_output($row['cm_url']) : '';
    $data[$i]['title']      = sanitize_output($row['cm_title']);
    $data[$i]['t_display']  = sanitize_output(string_truncate($row['cm_title'], 22, '...'));
    $data[$i]['t_full']     = (mb_strlen($row['cm_title']) > 22) ? sanitize_output($row['cm_title']) : '';
    $data[$i]['type']       = sanitize_output(string_truncate($row['cm_type'], 20, '...'));
    $data[$i]['priority']   = sanitize_output($row['cm_priority']);
    $data[$i]['notes']      = nbcodes(sanitize_output($row['cm_notes'], preserve_line_breaks: true),
                                      page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);

    // Find page call count and remove matching missing pages
    if(in_array($row['cm_url'], $missing))
    {
      $data[$i]['links']  = (isset($call_count[$row['cm_url']])) ? sanitize_output($call_count[$row['cm_url']]) : '&nbsp;';
      array_splice($missing, array_search($row['cm_url'], $missing), 1);
    }
    else
      $data[$i]['links'] = '&nbsp;';
  }

  // Sort the missing pages array (with a little encoding trick for accents)
  $missing = array_map("utf8_decode", $missing);
  sort($missing, SORT_LOCALE_STRING);
  $missing = array_map("utf8_encode", $missing);

  // Prepare the missing pages array and page call counts for displaying
  foreach($missing as $page_id => $page_name)
  {
    $missing[$page_id]  = sanitize_output($page_name);
    $links[$page_id]    = (isset($call_count[$page_name])) ? sanitize_output($call_count[$page_name]) : 0;
  }

  // Sort the array by links if requested
  if($sort_by === 'links')
  {
    // Create a new temporary array combining both page names and link count
    $sort_pages = array();
    foreach($missing as $page_id => $page_name)
    {
      $sort_pages[$page_id]['name']   = $page_name;
      $sort_pages[$page_id]['links']  = $links[$page_id];
    }

    // Sort the temporary array by link count
    usort($sort_pages, function($a, $b) { return $b['links'] <=> $a['links']; });

    // Replace the missing pages and page call count arrays by the contents of the sorted temporary array
    foreach($sort_pages as $sort_id => $sort_values)
    {
      $missing[$sort_id]  = sanitize_output($sort_values['name']);
      $links[$sort_id]    = (isset($call_count[$sort_values['name']])) ? sanitize_output($call_count[$sort_values['name']]) : 0;
    }
  }

  // Add the missing pages and page call count to the data
  $data['missing']  = $missing;
  $data['links']    = $links;

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Remove the rows when searching for undocumented pages
  if($search_status === 0)
    $data['rows'] = 0;

  // Return the prepared data
  return $data;
}




/**
 * Creates or modifies data on a missing compendium page.
 *
 * @param   string        $missing_url              The missing page's url.
 * @param   array         $contents                 The missing page's contents.
 * @param   int           $missing_id   (OPTIONAL)  The missing page's ID, if it already exists.
 *
 * @return  string|null                             A string if an error happened, or NULL if all went well.
 */

function compendium_missing_edit( string  $missing_url      ,
                                  array   $contents         ,
                                  int     $missing_id   = 0 ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $missing_url      = sanitize(compendium_format_url($missing_url), 'string');
  $missing_id       = sanitize($missing_id, 'int', 0);
  $missing_title    = sanitize_array_element($contents, 'title', 'string');
  $missing_type     = sanitize_array_element($contents, 'type', 'int', min: 0, default: 0);
  $missing_notes    = sanitize_array_element($contents, 'notes', 'string');
  $missing_priority = sanitize_array_element($contents, 'priority', 'int', min: 0, max: 1, default: 0);

  // Error: No url
  if(!$missing_url)
    return __('compendium_missing_edit_no_url');

  // Error: URL already taken by a compendium page
  if(database_entry_exists('compendium_pages', 'page_url', $missing_url))
    return __('compendium_missing_edit_taken');

  // If the page doesn't exist, create it
  if(!$missing_id)
  {
    // Ensure a missing page with that url doesn't already exist
    if(database_entry_exists('compendium_missing', 'page_url', $missing_url))
      return __('compendium_missing_edit_double');

    // Create the missing page
    query(" INSERT INTO compendium_missing
            SET         compendium_missing.page_url             = '$missing_url'      ,
                        compendium_missing.title                = '$missing_title'    ,
                        compendium_missing.fk_compendium_types  = '$missing_type'     ,
                        compendium_missing.is_a_priority        = '$missing_priority' ,
                        compendium_missing.notes                = '$missing_notes'    ");
  }

  // Otherwise, update it
  else
  {
    // Fetch data on the missing page
    $missing_data = compendium_missing_get(missing_id: $missing_id);

    // Error: Missing page does not exist
    if(!$missing_data)
      return __('compendium_missing_edit_deleted');

    // Sanitize the page's url
    $missing_data_url = sanitize($missing_data['url_raw'], 'string');

    // Error: Missing page's new URL is already taken
    if($missing_data_url !== $missing_url && database_entry_exists('compendium_missing', 'page_url', $missing_url))
      return __('compendium_missing_edit_double');

    // Update the missing pages
    query(" UPDATE  compendium_missing
            SET     compendium_missing.page_url             = '$missing_url'      ,
                    compendium_missing.title                = '$missing_title'    ,
                    compendium_missing.fk_compendium_types  = '$missing_type'     ,
                    compendium_missing.is_a_priority        = '$missing_priority' ,
                    compendium_missing.notes                = '$missing_notes'
            WHERE   compendium_missing.id                   = '$missing_id'     ");
  }

  // All went well
  return NULL;
}




/**
 * Deletes a missing compendium page entry.
 *
 * @param   int           $missing_id   The missing compendium page's id.
 *
 * @return  void
 */

function compendium_missing_delete( int $missing_id ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the missing compendium page's id
  $missing_id = sanitize($missing_id, 'int', 0);

  // Delete the missing compendium page
  query(" DELETE FROM compendium_missing
          WHERE       compendium_missing.id = '$missing_id' ");

  // All went well
  return NULL;
}




/**
 * Returns data related to a compendium page type.
 *
 * @param   int         $type_id  The compendium page type's id.
 *
 * @return  array|null            An array containing page type related data, or NULL if it does not exist.
 */

function compendium_types_get( int $type_id ) : mixed
{
  // Sanitize the page type's id
  $type_id = sanitize($type_id, 'int', 0);

  // Return null if the page type doesn't exist
  if(!database_row_exists('compendium_types', $type_id))
    return NULL;

  // Get the user's current language, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Fetch the data
  $dtype = mysqli_fetch_array(query(" SELECT  compendium_types.display_order      AS 'ct_order'   ,
                                              compendium_types.name_en            AS 'ct_name_en' ,
                                              compendium_types.name_fr            AS 'ct_name_fr' ,
                                              compendium_types.full_name_$lang    AS 'ct_full'    ,
                                              compendium_types.full_name_en       AS 'ct_full_en' ,
                                              compendium_types.full_name_fr       AS 'ct_full_fr' ,
                                              compendium_types.description_$lang  AS 'ct_body'    ,
                                              compendium_types.description_en     AS 'ct_body_en' ,
                                              compendium_types.description_fr     AS 'ct_body_fr'
                                      FROM    compendium_types
                                      WHERE   compendium_types.id = '$type_id' "));

  // Assemble an array with the data
  $data['order']        = sanitize_output($dtype['ct_order']);
  $data['name_en']      = sanitize_output($dtype['ct_name_en']);
  $data['name_fr']      = sanitize_output($dtype['ct_name_fr']);
  $data['full']         = sanitize_output($dtype['ct_full']);
  $data['full_en']      = sanitize_output($dtype['ct_full_en']);
  $data['full_fr']      = sanitize_output($dtype['ct_full_fr']);
  $data['full_en_raw']  = $dtype['ct_full_en'];
  $data['full_fr_raw']  = $dtype['ct_full_fr'];
  $data['body']         = nbcodes(sanitize_output($dtype['ct_body'], preserve_line_breaks: true),
                                  page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $data['body_en']      = sanitize_output($dtype['ct_body_en']);
  $data['body_fr']      = sanitize_output($dtype['ct_body_fr']);
  $data['body_en_raw']  = $dtype['ct_body_en'];
  $data['body_fr_raw']  = $dtype['ct_body_fr'];

  // Return the data
  return $data;
}




/**
 * Fetches a list of compendium page types.
 *
 * @param   string  $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                         An array containing page types.
 */

function compendium_types_list( string $format = 'html' ) : array
{
  // Check if the required files have been included
  if($format === 'api')
    require_included_file('bbcodes.inc.php');

  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the compendium page types
  $qtypes = query(" SELECT    compendium_types.id               AS 'ct_id'      ,
                              compendium_types.display_order    AS 'ct_order'   ,
                              compendium_types.name_$lang       AS 'ct_name'    ,
                              compendium_types.full_name_$lang  AS 'ct_full'    ,
                              compendium_types.full_name_en     AS 'ct_full_en' ,
                              compendium_types.full_name_fr     AS 'ct_full_fr' ,
                              compendium_types.description_en   AS 'ct_body_en' ,
                              compendium_types.description_fr   AS 'ct_body_fr' ,
                              COUNT(compendium_pages.id)        AS 'ct_count'
                    FROM      compendium_types
                    LEFT JOIN compendium_pages ON compendium_types.id = compendium_pages.fk_compendium_types
                    AND       compendium_pages.is_deleted             = 0
                    AND       compendium_pages.is_draft               = 0
                    AND       compendium_pages.title_$lang           != ''
                    AND       compendium_pages.redirection_$lang      = ''
                    GROUP BY  compendium_types.id
                    ORDER BY  compendium_types.display_order ASC ");


  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qtypes); $i++)
  {
    // Format the data
    $type_id            = $row['ct_id'];
    $type_order         = $row['ct_order'];
    $type_name          = $row['ct_name'];
    $type_name_full     = $row['ct_full'];
    $type_name_full_en  = $row['ct_full_en'];
    $type_name_full_fr  = $row['ct_full_fr'];
    $type_body_en       = $row['ct_body_en'];
    $type_body_fr       = $row['ct_body_fr'];
    $type_page_count    = $row['ct_count'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data[$i]['id']     = sanitize_output($type_id);
      $data[$i]['order']  = sanitize_output($type_order);
      $data[$i]['name']   = sanitize_output($type_name);
      $data[$i]['full']   = sanitize_output($type_name_full);
      $data[$i]['count']  = ($type_page_count) ? sanitize_output($type_page_count) : '-';
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      $data[$i]['type']['id']             = (string)$type_id;
      $data[$i]['type']['name_en']        = sanitize_json($type_name_full_en);
      $data[$i]['type']['name_fr']        = sanitize_json($type_name_full_fr);
      $data[$i]['type']['link']           = $GLOBALS['website_url'].'pages/compendium/page_type?type='.$type_id;
      $data[$i]['type']['pages_of_type']  = (int)$type_page_count;
      $data[$i]['type']['description_en'] = sanitize_json(nbcodes_remove($type_body_en)) ?: NULL;
      $data[$i]['type']['description_fr'] = sanitize_json(nbcodes_remove($type_body_fr)) ?: NULL;
    }
  }

  // Add the number of rows to the data
  if($format === 'html')
    $data['rows'] = $i;

  // Give a default return value when no channels are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('types' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new compendium page type.
 *
 * @param   array         $contents   The contents of the page type.
 *
 * @return  string|int                A string if an error happened, or the new page type's ID if all went well.
 */

function compendium_types_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $order        = sanitize($contents['order'], 'int', 0);
  $name_en      = sanitize($contents['name_en'], 'string');
  $name_fr      = sanitize($contents['name_fr'], 'string');
  $full_en      = sanitize($contents['full_en'], 'string');
  $full_fr      = sanitize($contents['full_fr'], 'string');
  $body_en      = sanitize($contents['body_en'], 'string');
  $body_fr      = sanitize($contents['body_fr'], 'string');
  $body_en_raw  = $contents['body_en'];
  $body_fr_raw  = $contents['body_fr'];

  // Error: No title
  if(!$name_en || !$name_fr || !$full_en || !$full_fr)
    return __('compendium_type_add_no_name');

  // Create the compendium page type
  query(" INSERT INTO compendium_types
          SET         compendium_types.display_order  = '$order'    ,
                      compendium_types.name_en        = '$name_en'  ,
                      compendium_types.name_fr        = '$name_fr'  ,
                      compendium_types.full_name_en   = '$full_en'  ,
                      compendium_types.full_name_fr   = '$full_fr'  ,
                      compendium_types.description_en = '$body_en'  ,
                      compendium_types.description_fr = '$body_fr'  ");

  // Fetch the newly created compendium page type's id
  $type_id = query_id();

  // Find all images in the page type's body
  $image_list_en  = compendium_find_images_in_entry($body_en_raw);
  $image_list_fr  = compendium_find_images_in_entry($body_fr_raw);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // Return the compendium page type's id
  return $type_id;
}




/**
 * Modifies an existing compendium page type.
 *
 * @param   int           $type_id    The page type's id.
 * @param   array         $contents   The page type's contents.
 *
 * @return  string|null               A string if an error happened, or NULL if all went well.
 */

function compendium_types_edit( int   $type_id  ,
                                array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $type_id      = sanitize($type_id, 'int', 0);
  $order        = sanitize($contents['order'], 'int', 0);
  $name_en      = sanitize($contents['name_en'], 'string');
  $name_fr      = sanitize($contents['name_fr'], 'string');
  $full_en      = sanitize($contents['full_en'], 'string');
  $full_fr      = sanitize($contents['full_fr'], 'string');
  $body_en      = sanitize($contents['body_en'], 'string');
  $body_fr      = sanitize($contents['body_fr'], 'string');
  $body_en_raw  = $contents['body_en'];
  $body_fr_raw  = $contents['body_fr'];

  // Error: Page type does not exist
  if(!$type_id || !database_row_exists('compendium_types', $type_id))
    return __('compendium_type_edit_error');

  // Error: No title
  if(!$name_en || !$name_fr || !$full_en || !$full_fr)
    return __('compendium_type_add_no_name');

  // Fetch the old page type's data
  $type_old = compendium_types_get($type_id);

  // Edit the compendium page type
  query(" UPDATE  compendium_types
          SET     compendium_types.display_order    = '$order'    ,
                  compendium_types.name_en          = '$name_en'  ,
                  compendium_types.name_fr          = '$name_fr'  ,
                  compendium_types.full_name_en     = '$full_en'  ,
                  compendium_types.full_name_fr     = '$full_fr'  ,
                  compendium_types.description_en   = '$body_en'  ,
                  compendium_types.description_fr   = '$body_fr'
          WHERE   compendium_types.id               = '$type_id' ");

  // Find all images in the page type's body
  $image_list_en      = compendium_find_images_in_entry($body_en_raw);
  $image_list_fr      = compendium_find_images_in_entry($body_fr_raw);
  $image_list_en_old  = compendium_find_images_in_entry($type_old['body_en_raw']);
  $image_list_fr_old  = compendium_find_images_in_entry($type_old['body_fr_raw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr, $image_list_en_old, $image_list_fr_old);
  $image_list = array_unique($image_list);

  // Update the info of all images used or previously used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // All went well
  return NULL;
}




/**
 * Deletes an existing page type.
 *
 * @param   int           $type_id  The compendium page type's id.
 *
 * @return  string|null             A string if an error happened, or NULL if all went well.
 */

function compendium_types_delete( int $type_id ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the compendium page type's id
  $type_id = sanitize($type_id, 'int', 0);

  // Error: Compendium page type does not exist
  if(!$type_id || !database_row_exists('compendium_types', $type_id))
    return __('compendium_type_edit_error');

  // Check if there are any pages tied to the page type
  $dtype = mysqli_fetch_array(query(" SELECT    COUNT(*)  AS 'count'
                                      FROM      compendium_pages
                                      WHERE     compendium_pages.fk_compendium_types = '$type_id' "));

  // Error: Page type has pages linked to it
  if($dtype['count'])
    return __('compendium_type_delete_impossible');

  // Fetch the page type's data before deleting it
  $type_deleted = compendium_types_get($type_id);

  // Delete the page type
  query(" DELETE FROM compendium_types
          WHERE       compendium_types.id = '$type_id' ");

  // Find all images in the page type's body
  $image_list_en  = compendium_find_images_in_entry($type_deleted['body_en_raw']);
  $image_list_fr  = compendium_find_images_in_entry($type_deleted['body_fr_raw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // All went well
  return NULL;
}




/**
 * Returns data related to a compendium category.
 *
 * @param   int         $category_id  The compendium category's id.
 *
 * @return  array|null                An array containing category related data, or NULL if it does not exist.
 */

function compendium_categories_get( int $category_id ) : mixed
{
  // Sanitize the category's id
  $category_id = sanitize($category_id, 'int', 0);

  // Return null if the category doesn't exist
  if(!database_row_exists('compendium_categories', $category_id))
    return NULL;

  // Get the user's current language, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Fetch the data
  $dcategory = mysqli_fetch_array(query(" SELECT  compendium_categories.display_order     AS 'cc_order'   ,
                                                  compendium_categories.name_$lang        AS 'cc_name'    ,
                                                  compendium_categories.name_en           AS 'cc_name_en' ,
                                                  compendium_categories.name_fr           AS 'cc_name_fr' ,
                                                  compendium_categories.description_$lang AS 'cc_body'    ,
                                                  compendium_categories.description_en    AS 'cc_body_en' ,
                                                  compendium_categories.description_fr    AS 'cc_body_fr'
                                          FROM    compendium_categories
                                          WHERE   compendium_categories.id = '$category_id' "));

  // Assemble an array with the data
  $data['order']        = sanitize_output($dcategory['cc_order']);
  $data['name']         = sanitize_output($dcategory['cc_name']);
  $data['name_en_raw']  = $dcategory['cc_name_en'];
  $data['name_fr_raw']  = $dcategory['cc_name_fr'];
  $data['name_en']      = sanitize_output($dcategory['cc_name_en']);
  $data['name_fr']      = sanitize_output($dcategory['cc_name_fr']);
  $data['body']         = nbcodes(sanitize_output($dcategory['cc_body'], preserve_line_breaks: true),
                                  page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $data['body_en']      = sanitize_output($dcategory['cc_body_en']);
  $data['body_fr']      = sanitize_output($dcategory['cc_body_fr']);
  $data['body_en_raw']  = $dcategory['cc_body_en'];
  $data['body_fr_raw']  = $dcategory['cc_body_fr'];

  // Return the data
  return $data;
}




/**
 * Fetches a list of compendium categories.
 *
 * @param   string  $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                         An array containing categories.
 */

function compendium_categories_list( string $format = 'html' ) : array
{
  // Check if the required files have been included
  if($format === 'api')
    require_included_file('bbcodes.inc.php');

  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the compendium categories
  $qcategories = query("  SELECT    compendium_categories.id              AS 'cc_id'      ,
                                    compendium_categories.display_order   AS 'cc_order'   ,
                                    compendium_categories.name_$lang      AS 'cc_name'    ,
                                    compendium_categories.name_en         AS 'cc_name_en' ,
                                    compendium_categories.name_fr         AS 'cc_name_fr' ,
                                    compendium_categories.description_en  AS 'cc_body_en' ,
                                    compendium_categories.description_fr  AS 'cc_body_fr' ,
                                    COUNT(compendium_pages.id)            AS 'cc_count'
                          FROM      compendium_categories
                          LEFT JOIN compendium_pages_categories
                          ON        compendium_categories.id = compendium_pages_categories.fk_compendium_categories
                          LEFT JOIN compendium_pages
                          ON        compendium_pages_categories.fk_compendium_pages = compendium_pages.id
                          AND       compendium_pages.is_deleted                     = 0
                          AND       compendium_pages.is_draft                       = 0
                          AND       compendium_pages.title_$lang                   != ''
                          AND       compendium_pages.redirection_$lang              = ''
                          GROUP BY  compendium_categories.id
                          ORDER BY  compendium_categories.display_order ASC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qcategories); $i++)
  {
    // Format the data
    $category_id      = $row['cc_id'];
    $category_order   = $row['cc_order'];
    $category_name    = $row['cc_name'];
    $category_name_en = $row['cc_name_en'];
    $category_name_fr = $row['cc_name_fr'];
    $category_body_en = $row['cc_body_en'];
    $category_body_fr = $row['cc_body_fr'];
    $category_pages   = $row['cc_count'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data[$i]['id']     = sanitize_output($category_id);
      $data[$i]['order']  = sanitize_output($category_order);
      $data[$i]['name']   = sanitize_output($category_name);
      $data[$i]['count']  = ($category_pages) ? sanitize_output($category_pages) : '-';
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      $data[$i]['category']['id']                 = (string)$category_id;
      $data[$i]['category']['name_en']            = sanitize_json($category_name_en);
      $data[$i]['category']['name_fr']            = sanitize_json($category_name_fr);
      $data[$i]['category']['link']               = $GLOBALS['website_url'].'pages/compendium/category?id='
                                                                           .$category_id;
      $data[$i]['category']['pages_in_category']  = (int)$category_pages;
      $data[$i]['category']['description_en']     = sanitize_json(nbcodes_remove($category_body_en)) ?: NULL;
      $data[$i]['category']['description_fr']     = sanitize_json(nbcodes_remove($category_body_fr)) ?: NULL;
    }
  }

  // Add the number of rows to the data
  if($format === 'html')
    $data['rows'] = $i;

  // Give a default return value when no channels are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('categories' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new compendium category.
 *
 * @param   array         $contents   The contents of the category.
 *
 * @return  string|int                A string if an error happened, or the new category's ID if all went well.
 */

function compendium_categories_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $order        = sanitize($contents['order'], 'int', 0);
  $name_en      = sanitize($contents['name_en'], 'string');
  $name_fr      = sanitize($contents['name_fr'], 'string');
  $body_en      = sanitize($contents['body_en'], 'string');
  $body_fr      = sanitize($contents['body_fr'], 'string');
  $body_en_raw  = $contents['body_en'];
  $body_fr_raw  = $contents['body_fr'];

  // Error: No title
  if(!$name_en || !$name_fr)
    return __('compendium_category_add_no_name');

  // Create the compendium category
  query(" INSERT INTO compendium_categories
          SET         compendium_categories.display_order   = '$order'    ,
                      compendium_categories.name_en         = '$name_en'  ,
                      compendium_categories.name_fr         = '$name_fr'  ,
                      compendium_categories.description_en  = '$body_en'  ,
                      compendium_categories.description_fr  = '$body_fr'  ");

  // Fetch the newly created compendium category's id
  $category_id = query_id();

  // Find all images in the category's body
  $image_list_en  = compendium_find_images_in_entry($body_en_raw);
  $image_list_fr  = compendium_find_images_in_entry($body_fr_raw);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // Return the compendium category's id
  return $category_id;
}




/**
 * Modifies an existing compendium category.
 *
 * @param   int           $category_id  The category's id.
 * @param   array         $contents     The category's contents.
 *
 * @return  string|null                 A string if an error happened, or NULL if all went well.
 */

function compendium_categories_edit(  int   $category_id  ,
                                      array $contents     ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $category_id  = sanitize($category_id, 'int', 0);
  $order        = sanitize($contents['order'], 'int', 0);
  $name_en      = sanitize($contents['name_en'], 'string');
  $name_fr      = sanitize($contents['name_fr'], 'string');
  $body_en      = sanitize($contents['body_en'], 'string');
  $body_fr      = sanitize($contents['body_fr'], 'string');
  $body_en_raw  = $contents['body_en'];
  $body_fr_raw  = $contents['body_fr'];

  // Error: Category does not exist
  if(!$category_id || !database_row_exists('compendium_categories', $category_id))
    return __('compendium_category_edit_error');

  // Error: No title
  if(!$name_en || !$name_fr)
    return __('compendium_category_add_no_name');

  // Fetch the old category's data
  $category_old = compendium_categories_get($category_id);

  // Edit the compendium category
  query(" UPDATE  compendium_categories
          SET     compendium_categories.display_order   = '$order'    ,
                  compendium_categories.name_en         = '$name_en'  ,
                  compendium_categories.name_fr         = '$name_fr'  ,
                  compendium_categories.description_en  = '$body_en'  ,
                  compendium_categories.description_fr  = '$body_fr'
          WHERE   compendium_categories.id              = '$category_id' ");

  // Find all images in the category's body
  $image_list_en      = compendium_find_images_in_entry($body_en_raw);
  $image_list_fr      = compendium_find_images_in_entry($body_fr_raw);
  $image_list_en_old  = compendium_find_images_in_entry($category_old['body_en_raw']);
  $image_list_fr_old  = compendium_find_images_in_entry($category_old['body_fr_raw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr, $image_list_en_old, $image_list_fr_old);
  $image_list = array_unique($image_list);

  // Update the info of all images used or previously used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // All went well
  return NULL;
}




/**
 * Deletes an existing compendium category.
 *
 * @param   int           $category_id  The compendium category's id.
 *
 * @return  string|null                 A string if an error happened, or NULL if all went well.
 */

function compendium_categories_delete( int $category_id ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the compendium category's id
  $category_id = sanitize($category_id, 'int', 0);

  // Error: Compendium category does not exist
  if(!$category_id || !database_row_exists('compendium_categories', $category_id))
    return __('compendium_category_edit_error');

  // Check if there are any pages tied to the category
  $dcategory = mysqli_fetch_array(query("
    SELECT    COUNT(*)  AS 'count'
    FROM      compendium_pages_categories
    LEFT JOIN compendium_pages
    ON        compendium_pages_categories.fk_compendium_pages       = compendium_pages.id
    WHERE     compendium_pages_categories.fk_compendium_categories  = '$category_id'
    AND       compendium_pages.id IS NOT NULL "));

  // Error: Category has pages linked to it
  if($dcategory['count'])
    return __('compendium_category_delete_impossible');

  // Fetch the category's data before deleting it
  $category_deleted = compendium_categories_get($category_id);

  // Delete the category
  query(" DELETE FROM compendium_categories
          WHERE       compendium_categories.id = '$category_id' ");

  // Delete any dead links to the category
  query(" DELETE FROM compendium_pages_categories
          WHERE       compendium_pages_categories.fk_compendium_categories = '$category_id' ");

  // Find all images in the category's body
  $image_list_en  = compendium_find_images_in_entry($category_deleted['body_en_raw']);
  $image_list_fr  = compendium_find_images_in_entry($category_deleted['body_fr_raw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // All went well
  return NULL;
}




/**
 * Returns data related to a compendium era.
 *
 * @param   int         $era_id   The compendium era's id.
 *
 * @return  array|null            An array containing era related data, or NULL if it does not exist.
 */

function compendium_eras_get( int $era_id ) : mixed
{
  // Sanitize the era's id
  $era_id = sanitize($era_id, 'int', 0);

  // Return null if the era doesn't exist
  if(!database_row_exists('compendium_eras', $era_id))
    return NULL;

  // Get the user's current language, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Fetch the data
  $dera = mysqli_fetch_array(query("  SELECT  compendium_eras.year_start        AS 'ce_start'     ,
                                              compendium_eras.year_end          AS 'ce_end'       ,
                                              compendium_eras.name_$lang        AS 'ce_name'      ,
                                              compendium_eras.name_en           AS 'ce_name_en'   ,
                                              compendium_eras.name_fr           AS 'ce_name_fr'   ,
                                              compendium_eras.short_name_en     AS 'ce_short_en'  ,
                                              compendium_eras.short_name_fr     AS 'ce_short_fr'  ,
                                              compendium_eras.description_$lang AS 'ce_body'      ,
                                              compendium_eras.description_en    AS 'ce_body_en'   ,
                                              compendium_eras.description_fr    AS 'ce_body_fr'
                                      FROM    compendium_eras
                                      WHERE   compendium_eras.id = '$era_id' "));

  // Assemble an array with the data
  $data['start']        = sanitize_output($dera['ce_start']);
  $data['end']          = sanitize_output($dera['ce_end']);
  $data['name']         = sanitize_output($dera['ce_name']);
  $data['name_en_raw']  = $dera['ce_name_en'];
  $data['name_fr_raw']  = $dera['ce_name_fr'];
  $data['name_en']      = sanitize_output($dera['ce_name_en']);
  $data['name_fr']      = sanitize_output($dera['ce_name_fr']);
  $data['short_en']     = sanitize_output($dera['ce_short_en']);
  $data['short_fr']     = sanitize_output($dera['ce_short_fr']);
  $data['body']         = nbcodes(sanitize_output($dera['ce_body'], preserve_line_breaks: true),
                                  page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $data['body_en']      = sanitize_output($dera['ce_body_en']);
  $data['body_fr']      = sanitize_output($dera['ce_body_fr']);
  $data['body_en_raw']  = $dera['ce_body_en'];
  $data['body_fr_raw']  = $dera['ce_body_fr'];

  // Sanitize the start and end years
  $era_start  = sanitize($dera['ce_start'], 'int', 0);
  $era_end    = sanitize($dera['ce_end'], 'int', 0);

  // Fetch the previous era
  $dera = mysqli_fetch_array(query("  SELECT    compendium_eras.id          AS 'ce_prev_id' ,
                                                compendium_eras.name_$lang  AS 'ce_prev_name'
                                      FROM      compendium_eras
                                      WHERE     compendium_eras.year_end    <= '$era_start'
                                      AND       compendium_eras.id          != '$era_id'
                                      AND       compendium_eras.name_$lang  != ''
                                      ORDER BY  compendium_eras.year_end DESC
                                      LIMIT     1 "));

  // Add the previous era's info to the data array
  $data['prev_id']    = ($era_start && isset($dera['ce_prev_id']))    ? sanitize_output($dera['ce_prev_id'])    : 0;
  $data['prev_name']  = ($era_start && isset($dera['ce_prev_name']))  ? sanitize_output($dera['ce_prev_name'])  : '';

  // Fetch the next era
  $dera = mysqli_fetch_array(query("  SELECT    compendium_eras.id          AS 'ce_next_id' ,
                                                compendium_eras.name_$lang  AS 'ce_next_name'
                                      FROM      compendium_eras
                                      WHERE     compendium_eras.year_start  >= '$era_end'
                                      AND       compendium_eras.id          != '$era_id'
                                      AND       compendium_eras.name_$lang  != ''
                                      ORDER BY  compendium_eras.year_start ASC
                                      LIMIT     1 "));

  // Add the previous era's info to the data array
  $data['next_id']    = ($era_end && isset($dera['ce_next_id']))    ? sanitize_output($dera['ce_next_id'])    : 0;
  $data['next_name']  = ($era_end && isset($dera['ce_next_name']))  ? sanitize_output($dera['ce_next_name'])  : '';

  // Return the data
  return $data;
}




/**
 * Fetches a list of compendium eras.
 *
 * @param   string  $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                         An array containing eras.
 */

function compendium_eras_list( string $format = 'html' ) : array
{
  // Check if the required files have been included
  if($format === 'api')
    require_included_file('bbcodes.inc.php');

  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the compendium eras
  $qeras = query("  SELECT    compendium_eras.id                AS 'ce_id'      ,
                              compendium_eras.name_$lang        AS 'ce_name'    ,
                              compendium_eras.name_en           AS 'ce_name_en' ,
                              compendium_eras.name_fr           AS 'ce_name_fr' ,
                              compendium_eras.short_name_$lang  AS 'ce_short'   ,
                              compendium_eras.year_start        AS 'ce_start'   ,
                              compendium_eras.year_end          AS 'ce_end'     ,
                              compendium_eras.description_en    AS 'ce_body_en' ,
                              compendium_eras.description_fr    AS 'ce_body_fr' ,
                              COUNT(compendium_pages.id)        AS 'ce_count'
                    FROM      compendium_eras
                    LEFT JOIN compendium_pages ON compendium_eras.id  = compendium_pages.fk_compendium_eras
                    AND       compendium_pages.is_deleted             = 0
                    AND       compendium_pages.is_draft               = 0
                    AND       compendium_pages.title_$lang           != ''
                    AND       compendium_pages.redirection_$lang      = ''
                    GROUP BY  compendium_eras.id
                    ORDER BY  compendium_eras.year_start ASC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qeras); $i++)
  {
    // Format the data
    $era_id         = $row['ce_id'];
    $era_name       = $row['ce_name'];
    $era_name_en    = $row['ce_name_en'];
    $era_name_fr    = $row['ce_name_fr'];
    $era_short_name = $row['ce_short'];
    $era_year_start = $row['ce_start'];
    $era_year_end   = $row['ce_end'];
    $era_body_en    = $row['ce_body_en'];
    $era_body_fr    = $row['ce_body_fr'];
    $era_page_count = $row['ce_count'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data[$i]['id']     = sanitize_output($era_id);
      $data[$i]['name']   = sanitize_output($era_name);
      $data[$i]['short']  = sanitize_output($era_short_name);
      $data[$i]['start']  = ($era_year_start) ? sanitize_output($era_year_start) : '-';
      $data[$i]['startx'] = ($era_year_start) ? sanitize_output($era_year_start) : 'xxxx';
      $data[$i]['end']    = ($era_year_end) ? sanitize_output($era_year_end) : '-';
      $data[$i]['endx']   = ($era_year_end) ? sanitize_output($era_year_end) : 'xxxx';
      $data[$i]['count']  = ($era_page_count) ? sanitize_output($era_page_count) : '-';
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      $data[$i]['era']['id']              = (string)$era_id;
      $data[$i]['era']['name_en']         = sanitize_json($era_name_en);
      $data[$i]['era']['name_fr']         = sanitize_json($era_name_fr);
      $data[$i]['era']['year_start']      = (int)$era_year_start ?: NULL;
      $data[$i]['era']['year_end']        = (int)$era_year_end ?: NULL;
      $data[$i]['era']['link']            = $GLOBALS['website_url'].'pages/compendium/cultural_era?era='.$era_id;
      $data[$i]['era']['pages_in_era']    = (int)$era_page_count;
      $data[$i]['era']['description_en']  = sanitize_json(nbcodes_remove($era_body_en)) ?: NULL;
      $data[$i]['era']['description_fr']  = sanitize_json(nbcodes_remove($era_body_fr)) ?: NULL;
    }
  }

  // Add the number of rows to the data
  if($format === 'html')
    $data['rows'] = $i;

  // Give a default return value when no channels are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('eras' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new compendium era.
 *
 * @param   array         $contents   The contents of the era.
 *
 * @return  string|int                A string if an error happened, or the new era's ID if all went well.
 */

function compendium_eras_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $start        = sanitize($contents['start'], 'int', 0);
  $end          = sanitize($contents['end'], 'int', 0);
  $name_en      = sanitize($contents['name_en'], 'string');
  $name_fr      = sanitize($contents['name_fr'], 'string');
  $short_en     = sanitize($contents['short_en'], 'string');
  $short_fr     = sanitize($contents['short_fr'], 'string');
  $body_en      = sanitize($contents['body_en'], 'string');
  $body_fr      = sanitize($contents['body_fr'], 'string');
  $body_en_raw  = $contents['body_en'];
  $body_fr_raw  = $contents['body_fr'];

  // Error: No title
  if(!$name_en || !$name_fr || !$short_en || !$short_fr)
    return __('compendium_era_add_no_name');

  // Create the compendium era
  query(" INSERT INTO compendium_eras
          SET         compendium_eras.year_start      = '$start'    ,
                      compendium_eras.year_end        = '$end'      ,
                      compendium_eras.name_en         = '$name_en'  ,
                      compendium_eras.name_fr         = '$name_fr'  ,
                      compendium_eras.short_name_en   = '$short_en'  ,
                      compendium_eras.short_name_fr   = '$short_fr'  ,
                      compendium_eras.description_en  = '$body_en'  ,
                      compendium_eras.description_fr  = '$body_fr'  ");

  // Fetch the newly created compendium era's id
  $era_id = query_id();

  // Find all images in the compendium era's body
  $image_list_en  = compendium_find_images_in_entry($body_en_raw);
  $image_list_fr  = compendium_find_images_in_entry($body_fr_raw);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // Return the compendium era's id
  return $era_id;
}




/**
 * Modifies an existing compendium era.
 *
 * @param   int           $era_id     The era's id.
 * @param   array         $contents   The era's contents.
 *
 * @return  string|null               A string if an error happened, or NULL if all went well.
 */

function compendium_eras_edit(  int   $era_id   ,
                                array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $era_id       = sanitize($era_id, 'int', 0);
  $start        = sanitize($contents['start'], 'int', 0);
  $end          = sanitize($contents['end'], 'int', 0);
  $name_en      = sanitize($contents['name_en'], 'string');
  $name_fr      = sanitize($contents['name_fr'], 'string');
  $short_en     = sanitize($contents['short_en'], 'string');
  $short_fr     = sanitize($contents['short_fr'], 'string');
  $body_en      = sanitize($contents['body_en'], 'string');
  $body_fr      = sanitize($contents['body_fr'], 'string');
  $body_en_raw  = $contents['body_en'];
  $body_fr_raw  = $contents['body_fr'];

  // Error: Era does not exist
  if(!$era_id || !database_row_exists('compendium_eras', $era_id))
    return __('compendium_era_edit_error');

  // Error: No title
  if(!$name_en || !$name_fr || !$short_en || !$short_fr)
    return __('compendium_era_add_no_name');

  // Fetch the old compendium era's data
  $era_old = compendium_eras_get($era_id);

  // Edit the compendium era
  query(" UPDATE  compendium_eras
          SET     compendium_eras.year_start      = '$start'    ,
                  compendium_eras.year_end        = '$end'      ,
                  compendium_eras.name_en         = '$name_en'  ,
                  compendium_eras.name_fr         = '$name_fr'  ,
                  compendium_eras.short_name_en   = '$short_en'  ,
                  compendium_eras.short_name_fr   = '$short_fr'  ,
                  compendium_eras.description_en  = '$body_en'  ,
                  compendium_eras.description_fr  = '$body_fr'
          WHERE   compendium_eras.id              = '$era_id' ");

  // Find all images in the compendium era's body
  $image_list_en      = compendium_find_images_in_entry($body_en_raw);
  $image_list_fr      = compendium_find_images_in_entry($body_fr_raw);
  $image_list_en_old  = compendium_find_images_in_entry($era_old['body_en_raw']);
  $image_list_fr_old  = compendium_find_images_in_entry($era_old['body_fr_raw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr, $image_list_en_old, $image_list_fr_old);
  $image_list = array_unique($image_list);

  // Update the info of all images used or previously used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);

  // All went well
  return NULL;
}




/**
 * Deletes an existing era.
 *
 * @param   int           $era_id   The compendium era's id.
 *
 * @return  string|null             A string if an error happened, or NULL if all went well.
 */

function compendium_eras_delete( int $era_id ) : mixed
{
  // Check if the required files have been included
  require_included_file('compendium.lang.php');
  require_included_file('bbcodes.inc.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the compendium era's id
  $era_id = sanitize($era_id, 'int', 0);

  // Error: Compendium era does not exist
  if(!$era_id || !database_row_exists('compendium_eras', $era_id))
    return __('compendium_era_edit_error');

  // Check if there are any pages tied to the era
  $dera = mysqli_fetch_array(query("  SELECT    COUNT(*)  AS 'count'
                                      FROM      compendium_pages
                                      WHERE     compendium_pages.fk_compendium_eras = '$era_id' "));

  // Error: Era has pages linked to it
  if($dera['count'])
    return __('compendium_era_delete_impossible');

  // Fetch the compendium era's data before deleting it
  $era_deleted = compendium_eras_get($era_id);

  // Delete the era
  query(" DELETE FROM compendium_eras
          WHERE       compendium_eras.id = '$era_id' ");

  // Find all images in the compendium era's body
  $image_list_en  = compendium_find_images_in_entry($era_deleted['body_en_raw']);
  $image_list_fr  = compendium_find_images_in_entry($era_deleted['body_fr_raw']);

  // Merge the image lists into one
  $image_list = array_merge($image_list_en, $image_list_fr);
  $image_list = array_unique($image_list);

  // Update the info of all images used
  foreach($image_list as $image_entry)
    compendium_images_recalculate_links($image_entry);


  // All went well
  return NULL;
}




/**
 * Returns the result of a search through all compendium content.
 *
 * @param   string      $search_query   The content being searched.
 *
 * @return  array|null                  An array containing search results, or NULL in case of an error.
 */

function compendium_search( string $search_query ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the search query
  $search_query = sanitize($search_query, 'string');

  // Stop here if the search query is less than 3 characters
  if(mb_strlen($search_query) < 3)
    return null;

  // Fetch and sanitize the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Prepare an array for the search results
  $search_results = array();

  // Search compendium content for the query
  $qsearch = query("  ( SELECT    'page_type'                       AS 'c_type'   ,
                                  compendium_types.full_name_$lang  AS 'c_title'  ,
                                  compendium_types.id               AS 'c_url'
                        FROM      compendium_types
                        WHERE     compendium_types.full_name_en   LIKE '%$search_query%'
                        OR        compendium_types.full_name_fr   LIKE '%$search_query%'
                        OR        compendium_types.description_en LIKE '%$search_query%'
                        OR        compendium_types.description_fr LIKE '%$search_query%'
                        ORDER BY  compendium_types.full_name_$lang ASC )

                      UNION

                      ( SELECT    'category'                        AS 'c_type'   ,
                                  compendium_categories.name_$lang  AS 'c_title'  ,
                                  compendium_categories.id          AS 'c_url'
                        FROM      compendium_categories
                        WHERE     compendium_categories.name_en         LIKE '%$search_query%'
                        OR        compendium_categories.name_fr         LIKE '%$search_query%'
                        OR        compendium_categories.description_en  LIKE '%$search_query%'
                        OR        compendium_categories.description_fr  LIKE '%$search_query%'
                        ORDER BY  compendium_categories.name_$lang ASC )

                      UNION

                      ( SELECT    'era'                       AS 'c_type'   ,
                                  compendium_eras.name_$lang  AS 'c_title'  ,
                                  compendium_eras.id          AS 'c_url'
                        FROM      compendium_eras
                        WHERE     compendium_eras.name_en         LIKE '%$search_query%'
                        OR        compendium_eras.name_fr         LIKE '%$search_query%'
                        OR        compendium_eras.description_en  LIKE '%$search_query%'
                        OR        compendium_eras.description_fr  LIKE '%$search_query%'
                        ORDER BY  compendium_eras.name_$lang ASC )

                      UNION

                      ( SELECT    'page'                        AS 'c_type'   ,
                                  compendium_pages.title_$lang  AS 'c_title'  ,
                                  compendium_pages.page_url     AS 'c_url'
                        FROM      compendium_pages
                        WHERE     compendium_pages.title_en       LIKE '%$search_query%'
                        OR        compendium_pages.title_fr       LIKE '%$search_query%'
                        OR        compendium_pages.definition_en  LIKE '%$search_query%'
                        OR        compendium_pages.definition_fr  LIKE '%$search_query%'
                        OR        compendium_pages.summary_en     LIKE '%$search_query%'
                        OR        compendium_pages.summary_fr     LIKE '%$search_query%'
                        ORDER BY  CONCAT(compendium_pages.title_$lang, compendium_pages.page_url) ASC )

                      UNION

                      ( SELECT    'missing'                   AS 'c_type'   ,
                                  compendium_missing.page_url AS 'c_title'  ,
                                  compendium_missing.id       AS 'c_url'
                        FROM      compendium_missing
                        WHERE     compendium_missing.page_url LIKE '%$search_query%'
                        OR        compendium_missing.title    LIKE '%$search_query%'
                        OR        compendium_missing.notes    LIKE '%$search_query%'
                        ORDER BY  compendium_missing.page_url ASC )

                      UNION

                      ( SELECT    'image'                     AS 'c_type'   ,
                                  compendium_images.file_name AS 'c_title'  ,
                                  compendium_images.file_name AS 'c_url'
                        FROM      compendium_images
                        WHERE     compendium_images.file_name   LIKE '%$search_query%'
                        OR        compendium_images.caption_en  LIKE '%$search_query%'
                        OR        compendium_images.caption_fr  LIKE '%$search_query%'
                        ORDER BY  compendium_images.file_name ASC ) ");

  // Prepare and add the search results to the return array
  for($i = 0; $row = mysqli_fetch_array($qsearch); $i++)
  {
    // Content type name
    $search_results[$i]['type'] = match($row['c_type'])
    {
      'page_type' => __('compendium_type_admin_short')              ,
      'category'  => string_change_case(__('category'), 'initials') ,
      'era'       => __('compendium_page_era')                      ,
      'page'      => __('compendium_admin_search_page')             ,
      'missing'   => __('compendium_page_missing_title')            ,
      'image'     => string_change_case(__('image'), 'initials')    ,
      default     => '&nbsp;'                                       ,
    };

    // Assemble the content URLs
    $search_results[$i]['url'] = match($row['c_type'])
    {
      'page_type' => 'pages/compendium/page_type?type='.$row['c_url']   ,
      'category'  => 'pages/compendium/category?id='.$row['c_url']      ,
      'era'       => 'pages/compendium/cultural_era?era='.$row['c_url'] ,
      'page'      => 'pages/compendium/'.$row['c_url']                  ,
      'missing'   => 'pages/compendium/page_missing?id='.$row['c_url']  ,
      'image'     => 'pages/compendium/image?name='.$row['c_url']       ,
      default     => 'pages/compendium/index'                           ,
    };

    // Content title
    $search_results[$i]['title'] = match($row['c_type'])
    {
      'page'      => ($row['c_title']) ? $row['c_title'] : $row['c_url']  ,
      default     => $row['c_title']                                      ,
    };

    // Sanitize the data
    $search_results[$i]['type']   = sanitize_output($search_results[$i]['type']);
    $search_results[$i]['title']  = sanitize_output(string_truncate($search_results[$i]['title'], 35, '...'));
  }

  // Add the search result count to the return array
  $search_results['count'] = $i;

  // Return the search results
  return $search_results;
}




/**
 * Returns data related to an entry in a compendium page's history entry.
 *
 * @param   int         $history_id   The compendium page's history entry id.
 *
 * @return  array|null                An array containing page related data, or NULL if it does not exist.
 */

function compendium_page_history_get( int $history_id ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the history entry's id
  $history_id = sanitize($history_id, 'int', 0);

  // Return null if the history entry doesn't exist
  if(!database_row_exists('compendium_pages_history', $history_id))
    return NULL;

  // Fetch the data
  $dhistory = mysqli_fetch_array(query("  SELECT  compendium_pages_history.fk_compendium_pages  AS 'ph_page'    ,
                                                  compendium_pages_history.is_major_edit        AS 'ph_major'   ,
                                                  compendium_pages_history.summary_en           AS 'ph_body_en' ,
                                                  compendium_pages_history.summary_fr           AS 'ph_body_fr'
                                          FROM    compendium_pages_history
                                          WHERE   compendium_pages_history.id = '$history_id' "));

  // Assemble an array with the data
  $data['page_id']  = sanitize_output($dhistory['ph_page']);
  $data['major']    = $dhistory['ph_major'];
  $data['body_en']  = sanitize_output($dhistory['ph_body_en']);
  $data['body_fr']  = sanitize_output($dhistory['ph_body_fr']);

  // Return the data
  return $data;
}




/**
 * Returns data related to a compendium page's history.
 *
 * @param   int         $page_id  The page's id
 *
 * @return  array|null            An array containing the data, or null if the page history doesn't exist.
 */

function compendium_page_history_list( int $page_id ) : mixed
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Sanitize the page's id
  $page_id = sanitize($page_id, 'int', 0);

  // Return null if the page doesn't exist
  if(!database_row_exists('compendium_pages', $page_id))
    return null;

  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the related page history
  $qhistory = query(" SELECT    compendium_pages_history.id             AS 'ph_id'    ,
                                compendium_pages_history.edited_at      AS 'ph_date'  ,
                                compendium_pages_history.is_major_edit  AS 'ph_major' ,
                                compendium_pages_history.summary_$lang  AS 'ph_body'
                      FROM      compendium_pages_history
                      WHERE     compendium_pages_history.fk_compendium_pages = '$page_id'
                      ORDER BY  compendium_pages_history.edited_at DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qhistory); $i++)
  {
    $data[$i]['id']   = sanitize_output($row['ph_id']);
    $data[$i]['date'] = sanitize_output(time_since($row['ph_date']));
    $data[$i]['css']  = ($row['ph_major']) ? ' class="bold"' : '';
    $data[$i]['body'] = sanitize_output($row['ph_body']);
  }

  // Fetch the page's creation date
  $dpage = mysqli_fetch_array(query(" SELECT  compendium_pages.created_at AS 'p_created'
                                      FROM    compendium_pages
                                      WHERE   compendium_pages.id = '$page_id' "));

  // Add the page creation info to the data
  $data[$i]['id']   = 0;
  $data[$i]['date'] = sanitize_output(time_since($dpage['p_created']));
  $data[$i]['css']  = ' class="bold"';
  $data[$i]['body'] = '';

  // Add the number of rows to the data
  $data['rows'] = $i + 1;

  // Return the prepared data
  return $data;
}




/**
 * Modifies an existing compendium page's history entry.
 *
 * @param   int     $history_id     The compendium page's history entry id.
 * @param   array   $history_data   The compendium page's history entry's data.
 *
 * @return  void
 */

function compendium_page_history_edit(  int   $history_id   ,
                                        array $history_data ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the history entry's id
  $history_id = sanitize($history_id, 'int', 0);

  // Stop here if the history entry does not exist
  if(!database_row_exists('compendium_pages_history', $history_id))
    return;

  // Sanitize the updated data
  $history_body_en  = sanitize_array_element($history_data, 'body_en', 'string');
  $history_body_fr  = sanitize_array_element($history_data, 'body_fr', 'string');
  $history_major    = sanitize_array_element($history_data, 'major', 'string', default: 'false');
  $history_major    = ($history_major === 'false') ? 0 : 1;

  // Update the quote
  query(" UPDATE  compendium_pages_history
          SET     compendium_pages_history.is_major_edit  = '$history_major'    ,
                  compendium_pages_history.summary_en     = '$history_body_en'  ,
                  compendium_pages_history.summary_fr     = '$history_body_fr'
          WHERE   compendium_pages_history.id             = '$history_id' ");
}




/**
 * Hard deletes an existing compendium page's history entry.
 *
 * @param   int   $history_id   The compendium page's history entry id.
 *
 * @return  void
 */

function compendium_page_history_delete( int $history_id ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the history entry's id
  $history_id = sanitize($history_id, 'int', 0);

  // Stop here if the history entry does not exist
  if(!database_row_exists('compendium_pages_history', $history_id))
    return;

  // Delete the history entry
  query(" DELETE FROM compendium_pages_history
          WHERE       compendium_pages_history.id = '$history_id' ");
}




/**
 * Fetches the admin notes.
 *
 * @return  array   An array containing the admin notes.
 */

function compendium_admin_notes_get() : array
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Fetch the data
  $dnotes = mysqli_fetch_array(query("  SELECT  compendium_admin_tools.global_notes AS 'cn_global'      ,
                                                compendium_admin_tools.snippets     AS 'cn_snippets'    ,
                                                compendium_admin_tools.template_en  AS 'cn_template_en' ,
                                                compendium_admin_tools.template_fr  AS 'cn_template_fr' ,
                                                compendium_admin_tools.links        AS 'cn_links'
                                        FROM    compendium_admin_tools
                                        LIMIT   1 "));

  // Assemble an array with the data
  $data['global']           = sanitize_output($dnotes['cn_global']);
  $data['snippets']         = sanitize_output($dnotes['cn_snippets']);
  $data['template_en']      = sanitize_output($dnotes['cn_template_en']);
  $data['template_fr']      = sanitize_output($dnotes['cn_template_fr']);
  $data['links']            = sanitize_output($dnotes['cn_links']);
  $data['links_formatted']  = '';
  $data['links_js']         = '';

  // Prepare the admin urls
  if($dnotes['cn_links'])
  {
    // Open the array of links for usage in JS
    $data['links_js'] = '[';

    // Split the urls
    $admin_urls = explode("|||", $dnotes['cn_links']);

    // Format the url lists
    $formatted_admin_urls = '';
    for($i = 0; $i < count($admin_urls); $i++)
    {
      $formatted_admin_urls .= __link($admin_urls[$i], string_truncate($admin_urls[$i], 40, '...'), is_internal: false).'<br>';
      if($i)
        $data['links_js'] .= ', ';
      $data['links_js'] .= "'$admin_urls[$i]'";
    }

    // Add the formatted page list to the data
    $data['links_formatted'] = $formatted_admin_urls;

    // Close the array of links for usage in JS
    $data['links_js'] .= ']';
  }

  // Return the data
  return $data;
}




/**
 * Modifies the admin notes.
 *
 * @param   array   $notes_data   The new compendium admin notes.
 *
 * @return  void
 */

function compendium_admin_notes_edit( array $notes_data ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the updated admin notes
  $notes_global       = sanitize_array_element($notes_data, 'global', 'string');
  $notes_snippets     = sanitize_array_element($notes_data, 'snippets', 'string');
  $notes_template_en  = sanitize_array_element($notes_data, 'template_en', 'string');
  $notes_template_fr  = sanitize_array_element($notes_data, 'template_fr', 'string');
  $notes_links        = sanitize_array_element($notes_data, 'links', 'string');

  // Update the admin notes
  query(" UPDATE  compendium_admin_tools
          SET     compendium_admin_tools.global_notes = '$notes_global'       ,
                  compendium_admin_tools.snippets     = '$notes_snippets'     ,
                  compendium_admin_tools.template_en  = '$notes_template_en'  ,
                  compendium_admin_tools.template_fr  = '$notes_template_fr'  ,
                  compendium_admin_tools.links        = '$notes_links'        ");
}




/**
 * Fetches the years at which compendium pages have been created.
 *
 * @param   bool  $admin_view   Lists every possible year including drafts, deleted pages, and wrong language.
 *
 * @return  array               An array containing years.
 */

function compendium_pages_list_years(bool $admin_view = false) : array
{
  // Get the user's current language
  $lang = user_get_language();

  // Fetch the compendium page years
  if($admin_view)
    $qyears = query(" SELECT    YEAR(FROM_UNIXTIME(compendium_pages.created_at)) AS 'c_year'
                      FROM      compendium_pages
                      WHERE     compendium_pages.created_at != '0000-00-00'
                      GROUP BY  YEAR(FROM_UNIXTIME(compendium_pages.created_at))
                      ORDER BY  YEAR(FROM_UNIXTIME(compendium_pages.created_at)) DESC ");
  else
    $qyears = query(" SELECT    YEAR(FROM_UNIXTIME(compendium_pages.created_at)) AS 'c_year'
                      FROM      compendium_pages
                      WHERE     compendium_pages.created_at != '0000-00-00'
                      AND       compendium_pages.title_$lang       != ''
                      AND       compendium_pages.is_deleted         = 0
                      AND       compendium_pages.is_draft           = 0
                      GROUP BY  YEAR(FROM_UNIXTIME(compendium_pages.created_at))
                      ORDER BY  YEAR(FROM_UNIXTIME(compendium_pages.created_at)) DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qyears); $i++)
    $data[$i]['year'] = sanitize_output($row['c_year']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Fetches the years in which compendium images have been uploaded.
 *
 * @return  array   An array containing years.
 */

function compendium_images_list_years() : array
{
  // Fetch the compendium image years
  $qyears = query(" SELECT    YEAR(FROM_UNIXTIME(compendium_images.uploaded_at)) AS 'ci_year'
                    FROM      compendium_images
                    WHERE     compendium_images.uploaded_at != '0000-00-00'
                    GROUP BY  YEAR(FROM_UNIXTIME(compendium_images.uploaded_at))
                    ORDER BY  YEAR(FROM_UNIXTIME(compendium_images.uploaded_at)) DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qyears); $i++)
    $data[$i]['year'] = sanitize_output($row['ci_year']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Fetches the years at which compendium content has appeared.
 *
 * @param   bool  $admin_view   Lists every possible year including drafts, deleted pages, and wrong language.
 *
 * @return  array               An array containing years.
 */

function compendium_appearance_list_years(bool $admin_view = false) : array
{
  // Get the user's current language
  $lang = user_get_language();

  // Fetch the compendium page years
  if($admin_view)
    $qyears = query(" SELECT    compendium_pages.year_appeared AS 'a_year'
                      FROM      compendium_pages
                      GROUP BY  compendium_pages.year_appeared
                      ORDER BY  compendium_pages.year_appeared DESC ");
  else
    $qyears = query(" SELECT    compendium_pages.year_appeared AS 'a_year'
                      FROM      compendium_pages
                      WHERE     compendium_pages.title_$lang       != ''
                      AND       compendium_pages.is_deleted         = 0
                      AND       compendium_pages.is_draft           = 0
                      GROUP BY  compendium_pages.year_appeared
                      ORDER BY  compendium_pages.year_appeared DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qyears); $i++)
    $data[$i]['year'] = sanitize_output($row['a_year']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Fetches the years at which compendium content has peaked.
 *
 * @param   bool  $admin_view   Lists every possible year including drafts, deleted pages, and wrong language.
 *
 * @return  array               An array containing years.
 */

function compendium_peak_list_years(bool $admin_view = false) : array
{
  // Get the user's current language
  $lang = user_get_language();

  // Fetch the compendium page years
  if($admin_view)
    $qyears = query(" SELECT    compendium_pages.year_peak AS 'p_year'
                      FROM      compendium_pages
                      GROUP BY  compendium_pages.year_peak
                      ORDER BY  compendium_pages.year_peak DESC ");
  else
    $qyears = query(" SELECT    compendium_pages.year_peak AS 'p_year'
                      FROM      compendium_pages
                      WHERE     compendium_pages.title_$lang       != ''
                      AND       compendium_pages.is_deleted         = 0
                      AND       compendium_pages.is_draft           = 0
                      GROUP BY  compendium_pages.year_peak
                      ORDER BY  compendium_pages.year_peak DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qyears); $i++)
    $data[$i]['year'] = sanitize_output($row['p_year']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns stats related to the compendium.
 *
 * @return  array   An array of stats related to the compendium.
 */

function compendium_stats_list() : array
{
  // Check if the required files have been included
  require_included_file('functions_numbers.inc.php');
  require_included_file('functions_mathematics.inc.php');

  // Initialize the return array
  $data = array();

  // Fetch the user's language
  $lang = string_change_case(user_get_language(), 'lowercase');

  // Fetch the total number of pages
  $dpages = mysqli_fetch_array(query("  SELECT  COUNT(*)                            AS 'cp_total'     ,
                                                SUM(compendium_pages.is_nsfw)       AS 'cp_nsfw'      ,
                                                SUM(compendium_pages.is_gross)      AS 'cp_gross'     ,
                                                SUM(compendium_pages.is_offensive)  AS 'cp_offensive'
                                        FROM    compendium_pages
                                        WHERE   compendium_pages.is_deleted         = 0
                                        AND     compendium_pages.is_draft           = 0
                                        AND     compendium_pages.redirection_$lang  = ''
                                        AND     compendium_pages.title_$lang       != '' "));

  // Add some stats to the return array
  $data['pages']      = sanitize_output($dpages['cp_total']);
  $data['nsfw']       = sanitize_output($dpages['cp_nsfw']);
  $data['nsfwp']      = number_display_format(maths_percentage_of($dpages['cp_nsfw'], $dpages['cp_total']) ,
                                              'percentage');
  $data['gross']      = sanitize_output($dpages['cp_gross']);
  $data['grossp']     = number_display_format(maths_percentage_of($dpages['cp_gross'], $dpages['cp_total']) ,
                                              'percentage');
  $data['offensive']  = sanitize_output($dpages['cp_offensive']);
  $data['offensivep'] = number_display_format(maths_percentage_of($dpages['cp_offensive'], $dpages['cp_total']) ,
                                              'percentage');

  // Fetch the total number of images
  $dimages = mysqli_fetch_array(query(" SELECT  COUNT(*)                            AS 'ci_total' ,
                                                SUM(compendium_images.is_nsfw)      AS 'ci_nsfw'      ,
                                                SUM(compendium_images.is_gross)     AS 'ci_gross'     ,
                                                SUM(compendium_images.is_offensive) AS 'ci_offensive'
                                        FROM    compendium_images
                                        WHERE   compendium_images.is_deleted = 0 "));

  // Add some stats to the return array
  $data['images']       = sanitize_output($dimages['ci_total']);
  $data['insfw']        = sanitize_output($dimages['ci_nsfw']);
  $data['insfwp']       = number_display_format(maths_percentage_of($dimages['ci_nsfw'], $dimages['ci_total']) ,
                                                'percentage');
  $data['igross']       = sanitize_output($dimages['ci_gross']);
  $data['igrossp']      = number_display_format(maths_percentage_of($dimages['ci_gross'], $dimages['ci_total']) ,
                                                'percentage');
  $data['ioffensive']   = sanitize_output($dimages['ci_offensive']);
  $data['ioffensivep']  = number_display_format(maths_percentage_of($dimages['ci_offensive'], $dimages['ci_total']) ,
                                                'percentage');

  // Fetch total page views
  $dpages = mysqli_fetch_array(query("  SELECT  SUM(compendium_pages.view_count) AS 'cp_views'
                                        FROM    compendium_pages "));

  // Add total page views to the return array
  $data['pageviews'] = sanitize_output(number_display_format($dpages['cp_views'], 'number'));

  // Fetch total image views
  $dimages = mysqli_fetch_array(query(" SELECT  SUM(compendium_images.view_count) AS 'ci_views'
                                        FROM    compendium_images "));

  // Add total image views to the return array
  $data['imageviews'] = sanitize_output(number_display_format($dimages['ci_views'], 'number'));

  // Create a temporary array to store page type stats
  $type_stats = array();

  // Fetch page type stats
  $dpages = query(" SELECT    COUNT(compendium_pages.id)            AS 'cp_count'   ,
                              compendium_pages.fk_compendium_types  AS 'cp_type_id' ,
                              SUM(compendium_pages.is_nsfw)         AS 'cp_nsfw'    ,
                              SUM(compendium_pages.is_gross)        AS 'cp_gross'   ,
                              SUM(compendium_pages.is_offensive)    AS 'cp_offensive'
                    FROM      compendium_pages
                    WHERE     compendium_pages.fk_compendium_types  > 0
                    AND       compendium_pages.is_deleted           = 0
                    AND       compendium_pages.is_draft             = 0
                    AND       compendium_pages.redirection_$lang    = ''
                    AND       compendium_pages.title_$lang         != ''
                    GROUP BY  compendium_pages.fk_compendium_types ");

  // Loop through page type stats and add their data to the temporary array
  while($row = mysqli_fetch_array($dpages))
  {
    $type_stats['pages_'.$row['cp_type_id']]  = sanitize_output($row['cp_count']);
    $type_stats['nsfw_'.$row['cp_type_id']]   = sanitize_output($row['cp_nsfw']);
    $type_stats['gross_'.$row['cp_type_id']]  = sanitize_output($row['cp_gross']);
    $type_stats['off_'.$row['cp_type_id']]    = sanitize_output($row['cp_offensive']);
  }

  // Fetch page types
  $qtypes = query(" SELECT    compendium_types.id         AS 'ct_id'  ,
                              compendium_types.name_$lang AS 'ct_name'
                    FROM      compendium_types
                    ORDER BY  compendium_types.display_order ASC ");

  // Loop through page types and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qtypes); $i++)
  {
    $data['types_id_'.$i]     = sanitize_output($row['ct_id']);
    $data['types_name_'.$i]   = sanitize_output($row['ct_name']);
    $data['types_pages_'.$i]  = ($type_stats['pages_'.$row['ct_id']]) ?? 0;
    $data['types_pagesp_'.$i] = number_display_format(maths_percentage_of($data['types_pages_'.$i], $data['pages']) ,
                                                      'percentage');
    $data['types_nsfw_'.$i]   = ($type_stats['nsfw_'.$row['ct_id']]) ?? 0;
    $data['types_nsfw_'.$i]   = ($data['types_nsfw_'.$i])
                              ? $data['types_nsfw_'.$i].' ('.number_display_format(
                                maths_percentage_of($data['types_nsfw_'.$i], $data['types_pages_'.$i]) ,
                                                    'percentage').')'
                              : '&nbsp;';
    $data['types_gross_'.$i]  = ($type_stats['gross_'.$row['ct_id']]) ?? 0;
    $data['types_gross_'.$i]  = ($data['types_gross_'.$i])
                              ? $data['types_gross_'.$i].' ('.number_display_format(
                                maths_percentage_of($data['types_gross_'.$i], $data['types_pages_'.$i]) ,
                                                    'percentage').')'
                              : '&nbsp;';
    $data['types_off_'.$i]    = ($type_stats['off_'.$row['ct_id']]) ?? 0;
    $data['types_off_'.$i]    = ($data['types_off_'.$i])
                              ? $data['types_off_'.$i].' ('.number_display_format(
                                maths_percentage_of($data['types_off_'.$i], $data['types_pages_'.$i]) ,
                                                    'percentage').')'
                              : '&nbsp;';
  }

  // Add the amount of page types to the return array
  $data['types_count'] = $i;

  // Loop through the page types once again in order to adjust their output
  for($i = 0; $i < $data['types_count']; $i++)
  {
    $data['types_pagesp_'.$i] = ($data['types_pages_'.$i]) ? $data['types_pagesp_'.$i] : '&nbsp;';
    $data['types_pages_'.$i]  = ($data['types_pages_'.$i]) ?: '&nbsp;';
  }

  // Create a temporary array to store category stats
  $category_stats = array();

  // Fetch category stats
  $dpages = query(" SELECT    COUNT(compendium_pages_categories.id)                 AS 'cp_count'   ,
                              compendium_pages_categories.fk_compendium_categories  AS 'cp_cat_id'  ,
                              SUM(compendium_pages.is_nsfw)                         AS 'cp_nsfw'    ,
                              SUM(compendium_pages.is_gross)                        AS 'cp_gross'   ,
                              SUM(compendium_pages.is_offensive)                    AS 'cp_offensive'
                    FROM      compendium_pages_categories
                    LEFT JOIN compendium_pages ON compendium_pages_categories.fk_compendium_pages = compendium_pages.id
                    WHERE     compendium_pages.is_deleted         = 0
                    AND       compendium_pages.is_draft           = 0
                    AND       compendium_pages.redirection_$lang  = ''
                    AND       compendium_pages.title_$lang       != ''
                    GROUP BY  compendium_pages_categories.fk_compendium_categories ");

  // Loop through category stats and add their data to the temporary array
  while($row = mysqli_fetch_array($dpages))
  {
    $category_stats['pages_'.$row['cp_cat_id']] = sanitize_output($row['cp_count']);
    $category_stats['nsfw_'.$row['cp_cat_id']]  = sanitize_output($row['cp_nsfw']);
    $category_stats['gross_'.$row['cp_cat_id']] = sanitize_output($row['cp_gross']);
    $category_stats['off_'.$row['cp_cat_id']]   = sanitize_output($row['cp_offensive']);
  }

  // Fetch categories
  $qcategories = query("  SELECT    compendium_categories.id          AS 'cc_id'  ,
                                    compendium_categories.name_$lang  AS 'cc_name'
                          FROM      compendium_categories
                          ORDER BY  compendium_categories.display_order ASC ");

  // Loop through categories and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qcategories); $i++)
  {
    $data['cat_id_'.$i]     = sanitize_output($row['cc_id']);
    $data['cat_name_'.$i]   = sanitize_output($row['cc_name']);
    $data['cat_pages_'.$i]  = ($category_stats['pages_'.$row['cc_id']]) ?? 0;
    $data['cat_nsfw_'.$i]   = ($category_stats['nsfw_'.$row['cc_id']]) ?? 0;
    $data['cat_nsfw_'.$i]   = ($data['cat_nsfw_'.$i])
                            ? $data['cat_nsfw_'.$i].' ('.number_display_format(
                              maths_percentage_of($data['cat_nsfw_'.$i], $data['cat_pages_'.$i]) ,
                                                  'percentage').')'
                            : '&nbsp;';
    $data['cat_gross_'.$i]  = ($category_stats['gross_'.$row['cc_id']]) ?? 0;
    $data['cat_gross_'.$i]  = ($data['cat_gross_'.$i])
                            ? $data['cat_gross_'.$i].' ('.number_display_format(
                              maths_percentage_of($data['cat_gross_'.$i], $data['cat_pages_'.$i]) ,
                                                  'percentage').')'
                            : '&nbsp;';
    $data['cat_off_'.$i]    = ($category_stats['off_'.$row['cc_id']]) ?? 0;
    $data['cat_off_'.$i]    = ($data['cat_off_'.$i])
                            ? $data['cat_off_'.$i].' ('.number_display_format(
                              maths_percentage_of($data['cat_off_'.$i], $data['cat_pages_'.$i]) ,
                                                  'percentage').')'
                            : '&nbsp;';
  }

  // Add the amount of categories to the return array
  $data['cat_count'] = $i;

  // Loop through the categories once again in order to adjust their output
  for($i = 0; $i < $data['cat_count']; $i++)
    $data['cat_pages_'.$i]  = ($data['cat_pages_'.$i]) ?: '&nbsp;';

  // Create a temporary array to store cultural era stats
  $era_stats = array();

  // Fetch cultural era stats
  $dpages = query(" SELECT    COUNT(compendium_pages.id)          AS 'cp_count'   ,
                              compendium_pages.fk_compendium_eras AS 'cp_era_id'  ,
                              SUM(compendium_pages.is_nsfw)       AS 'cp_nsfw'    ,
                              SUM(compendium_pages.is_gross)      AS 'cp_gross'   ,
                              SUM(compendium_pages.is_offensive)  AS 'cp_offensive'
                    FROM      compendium_pages
                    WHERE     compendium_pages.fk_compendium_eras > 0
                    AND       compendium_pages.is_deleted         = 0
                    AND       compendium_pages.is_draft           = 0
                    AND       compendium_pages.redirection_$lang  = ''
                    AND       compendium_pages.title_$lang       != ''
                    GROUP BY  compendium_pages.fk_compendium_eras ");

  // Loop through cultural era stats and add their data to the temporary array
  while($row = mysqli_fetch_array($dpages))
  {
    $era_stats['pages_'.$row['cp_era_id']]  = sanitize_output($row['cp_count']);
    $era_stats['nsfw_'.$row['cp_era_id']]   = sanitize_output($row['cp_nsfw']);
    $era_stats['gross_'.$row['cp_era_id']]  = sanitize_output($row['cp_gross']);
    $era_stats['off_'.$row['cp_era_id']]    = sanitize_output($row['cp_offensive']);
  }

  // Fetch cultural eras
  $qeras = query("  SELECT    compendium_eras.id          AS 'ce_id'    ,
                              compendium_eras.name_$lang  AS 'ce_name'  ,
                              compendium_eras.year_start  AS 'ce_start' ,
                              compendium_eras.year_end    AS 'ce_end'
                    FROM      compendium_eras
                    ORDER BY  compendium_eras.year_start  ASC  ,
                              compendium_eras.year_end    ASC ");

  // Loop through cultural eras and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qeras); $i++)
  {
    $data['eras_id_'.$i]      = sanitize_output($row['ce_id']);
    $data['eras_name_'.$i]    = sanitize_output($row['ce_name']);
    $data['eras_start_'.$i]   = ($row['ce_start']) ? sanitize_output($row['ce_start']) : '-';
    $data['eras_end_'.$i]     = ($row['ce_end']) ? sanitize_output($row['ce_end']) : '-';
    $data['eras_pages_'.$i]   = ($era_stats['pages_'.$row['ce_id']]) ?? 0;
    $data['eras_nsfw_'.$i]    = ($era_stats['nsfw_'.$row['ce_id']]) ?? 0;
    $data['eras_nsfw_'.$i]    = ($data['eras_nsfw_'.$i])
                              ? $data['eras_nsfw_'.$i].' ('.number_display_format(
                                maths_percentage_of($data['eras_nsfw_'.$i], $data['eras_pages_'.$i]) ,
                                                    'percentage').')'
                              : '&nbsp;';
    $data['eras_gross_'.$i]   = ($era_stats['gross_'.$row['ce_id']]) ?? 0;
    $data['eras_gross_'.$i]   = ($data['eras_gross_'.$i])
                              ? $data['eras_gross_'.$i].' ('.number_display_format(
                                maths_percentage_of($data['eras_gross_'.$i], $data['eras_pages_'.$i]) ,
                                                    'percentage').')'
                              : '&nbsp;';
    $data['eras_off_'.$i]     = ($era_stats['off_'.$row['ce_id']]) ?? 0;
    $data['eras_off_'.$i]     = ($data['eras_off_'.$i])
                              ? $data['eras_off_'.$i].' ('.number_display_format(
                                maths_percentage_of($data['eras_off_'.$i], $data['eras_pages_'.$i]) ,
                                                    'percentage').')'
                              : '&nbsp;';
  }

  // Add the amount of cultural eras to the return array
  $data['eras_count'] = $i;

  // Loop through the cultural eras once again in order to adjust their output
  for($i = 0; $i < $data['eras_count']; $i++)
    $data['eras_pages_'.$i]   = ($data['eras_pages_'.$i]) ?: '&nbsp;';

  // Fetch the longest pages
  $qlongest = query(" SELECT    compendium_pages.page_url               AS 'cp_url'   ,
                                compendium_pages.title_$lang            AS 'cp_title'
                      FROM      compendium_pages
                      WHERE     compendium_pages.is_deleted             = 0
                      AND       compendium_pages.is_draft               = 0
                      AND       compendium_pages.redirection_$lang      = ''
                      AND       compendium_pages.title_$lang           != ''
                      AND       compendium_pages.character_count_$lang  > 0
                      ORDER BY  compendium_pages.character_count_$lang DESC
                      LIMIT     10 ");

  // Loop through the longest pages and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qlongest); $i++)
  {
    $data['longest_url_'.$i]    = sanitize_output($row['cp_url']);
    $data['longest_title_'.$i]  = sanitize_output(string_truncate($row['cp_title'], 40, '...'));
  }

  // Add the amount of longest pages to the return array
  $data['longest_count'] = $i;

  // Fetch the shortest pages
  $qshortest = query("  SELECT    compendium_pages.page_url               AS 'cp_url'   ,
                                  compendium_pages.title_$lang            AS 'cp_title'
                        FROM      compendium_pages
                        WHERE     compendium_pages.is_deleted             = 0
                        AND       compendium_pages.is_draft               = 0
                        AND       compendium_pages.redirection_$lang      = ''
                        AND       compendium_pages.title_$lang           != ''
                        AND       compendium_pages.character_count_$lang  > 0
                        ORDER BY  compendium_pages.character_count_$lang ASC
                        LIMIT     10 ");

  // Loop through the longest pages and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qshortest); $i++)
  {
    $data['shortest_url_'.$i]   = sanitize_output($row['cp_url']);
    $data['shortest_title_'.$i] = sanitize_output(string_truncate($row['cp_title'], 40, '...'));
  }

  // Add the amount of longest pages to the return array
  $data['shortest_count'] = $i;

  // Prepare a variable used to find the oldest page or image creation year
  $oldest_year = date('Y');

  // Fetch pages by publication year
  $qpages = query(" SELECT    compendium_pages.created_at                       AS 'cp_time'  ,
                              YEAR(FROM_UNIXTIME(compendium_pages.created_at))  AS 'cp_year'  ,
                              COUNT(*)                                          AS 'cp_count'
                    FROM      compendium_pages
                    WHERE     compendium_pages.is_deleted         = 0
                    AND       compendium_pages.is_draft           = 0
                    AND       compendium_pages.redirection_$lang  = ''
                    AND       compendium_pages.title_$lang       != ''
                    AND       compendium_pages.created_at         > 0
                    GROUP BY  cp_year
                    ORDER BY  cp_year ");

  // Add page data over time to the return data
  while($dpages = mysqli_fetch_array($qpages))
  {
    $year                       = ($dpages['cp_year']);
    $oldest_year                = ($year < $oldest_year) ? $year : $oldest_year;
    $data['years_pages_'.$year] = ($dpages['cp_count']) ? sanitize_output($dpages['cp_count']) : '';
  }

  // Fetch images by publication year
  $qimages = query("  SELECT    compendium_images.uploaded_at                       AS 'ci_time'  ,
                                YEAR(FROM_UNIXTIME(compendium_images.uploaded_at))  AS 'ci_year'  ,
                                COUNT(*)                                            AS 'ci_count'
                      FROM      compendium_images
                      WHERE     compendium_images.is_deleted  = 0
                      AND       compendium_images.uploaded_at > 0
                      GROUP BY  ci_year
                      ORDER BY  ci_year ");

  // Initialize image data for the oldest year
  $data['years_images_'.$oldest_year] = 0;

  // Add image data over time to the return data
  while($dimages = mysqli_fetch_array($qimages))
  {
    $year                         = $dimages['ci_year'];
    $data['years_images_'.$year]  = ($dimages['ci_count']) ? sanitize_output($dimages['ci_count']) : '';
    if($year <= $oldest_year)
      $data['years_images_'.$oldest_year] += $dimages['ci_count'];
  }

  // Sanitize image data for the oldest year
  $data['years_images_'.$oldest_year] = sanitize_output($data['years_images_'.$oldest_year]);

  // Ensure every year has an entry until the current one
  for($i = $oldest_year; $i <= date('Y'); $i++)
  {
    $data['years_pages_'.$i]  ??= '';
    $data['years_images_'.$i] ??= '';
  }

  // Add the oldest year to the return data
  $data['oldest_year'] = $oldest_year;

  // Return the stats
  return $data;
}




/**
 * Recalculates stats for all compendium pages.
 *
 * @return void
 */

function compendium_stats_recalculate_all()
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Fetch all compendium pages
  $qpages = query(" SELECT  compendium_pages.id                 AS 'cp_id'      ,
                            compendium_pages.definition_en      AS 'cp_body_en' ,
                            compendium_pages.definition_fr      AS 'cp_body_fr' ,
                            compendium_pages.character_count_en AS 'cp_char_en' ,
                            compendium_pages.character_count_fr AS 'cp_char_fr'
                    FROM    compendium_pages ");

  // Loop through the pages
  while($dpages = mysqli_fetch_array($qpages))
  {
    // Recalculate character count
    $page_id        = sanitize($dpages['cp_id'], 'int', 0);
    $char_count_en  = sanitize(mb_strlen(nbcodes_remove($dpages['cp_body_en'])), 'int', 0);
    $char_count_fr  = sanitize(mb_strlen(nbcodes_remove($dpages['cp_body_fr'])), 'int', 0);

    // Update the page's stats if necessary
    if($char_count_en !== (int)$dpages['cp_char_en'] || $char_count_fr !== (int)$dpages['cp_char_fr'])
      query(" UPDATE  compendium_pages
              SET     compendium_pages.character_count_en = $char_count_en  ,
                      compendium_pages.character_count_fr = $char_count_fr
              WHERE   compendium_pages.id                 = $page_id  ");
  }
}




/**
 * Formats a compendium page url.
 *
 * @param   string  $url                The compendium page url.
 * @param   bool    $no_reserved_urls   Do not check for reserved urls
 *
 * @return  string                      The formatted page url.
 */

function compendium_format_url( ?string $url                      ,
                                bool    $no_reserved_urls = false ) : string
{
  // Change the url to lowercase
  $url = string_change_case($url, 'lowercase');

  // Replace spaces with underscores
  $url = str_replace(' ', '_', $url);

  // Remove forbidden characters
  $url = str_replace('%', '', $url);
  $url = str_replace('/', '', $url);
  $url = str_replace('\\', '', $url);
  $url = str_replace('|', '', $url);
  $url = str_replace('"', '', $url);
  $url = str_replace('<', '', $url);
  $url = str_replace('>', '', $url);
  $url = str_replace('*', '', $url);
  $url = str_replace('+', '', $url);
  $url = str_replace('#', '', $url);
  $url = str_replace('&', '', $url);
  $url = str_replace('?', '', $url);

  // Prohibit reserved urls
  if(!$no_reserved_urls)
  {
    $url = (mb_substr($url, 0, 6)   === 'admin_')             ? mb_substr($url, 6)  : $url;
    $url = (mb_substr($url, 0, 8)   === 'category')           ? mb_substr($url, 8)  : $url;
    $url = (mb_substr($url, 0, 12)  === 'cultural_era')       ? mb_substr($url, 12) : $url;
    $url = (mb_substr($url, 0, 5)   === 'index')              ? mb_substr($url, 5)  : $url;
    $url = (mb_substr($url, 0, 5)   === 'image')              ? mb_substr($url, 5)  : $url;
    $url = (mb_substr($url, 0, 17)  === 'mission_statement')  ? mb_substr($url, 17) : $url;
    $url = (mb_substr($url, 0, 5)   === 'page_')              ? mb_substr($url, 5)  : $url;
    $url = (mb_substr($url, 0, 7)   === 'random_')            ? mb_substr($url, 7)  : $url;
  }

  // Return the formatted url
  return $url;
}




/**
 * Formats a compendium page title.
 *
 * @param   string  $title  The compendium page title.
 *
 * @return  string          The formatted page title.
 */

function compendium_format_title( ?string $title ) : string
{
  // Forbid three vertical bars in a row
  $title = str_replace('|||', '///', $title);

  // Return the formatted url
  return $title;
}




/**
 * Formats a compendium image name.
 *
 * @param   string  $name   The compendium image file name.
 *
 * @return  string          The formatted image file name.
 */

function compendium_format_image_name( ?string $name ) : string
{
  // Change the name to lowercase
  $name = string_change_case($name, 'lowercase');

  // Replace spaces with underscores
  $name = str_replace(' ', '_', $name);

  // Remove forbidden characters
  $name = str_replace('%', '', $name);
  $name = str_replace('/', '', $name);
  $name = str_replace('\\', '', $name);
  $name = str_replace('|', '', $name);
  $name = str_replace('"', '', $name);
  $name = str_replace('<', '', $name);
  $name = str_replace('>', '', $name);
  $name = str_replace('*', '', $name);
  $name = str_replace('+', '', $name);
  $name = str_replace('#', '', $name);
  $name = str_replace('&', '', $name);
  $name = str_replace('?', '', $name);

  // Return the formatted name
  return $name;
}




/**
 * Applies NBCodes to a string.
 *
 * @param   string  $text   A string with NBCodes in it.
 *
 * @return  string          The formatted string.
 */

function compendium_nbcodes_apply( ?string $text ) : string
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');

  // Get the user's current settings, and the compendium pages which they can access
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Format the string
  $text = nbcodes(sanitize_output($text, preserve_line_breaks: true) ,
                  page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);

  // Return the formatted string
  return $text;
}




/**
 * Puts the name of all images within a compendium entry in an array.
 *
 * @param   string  $entry  A compendium entry's body.
 *
 * @return  array           The list of images contained within the entry's body.
 */

function compendium_find_images_in_entry( string $entry ) : array
{
  // Initialize the list of images
  $images = array();

  // Find aligned images with a caption and add them to the list of images
  preg_match_all('/\[image:(.*?)\|(.*?)\|(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Remove aligned images with a caption from the body
  $entry = preg_replace('/\[image:(.*?)\|(.*?)\|(.*?)\]/i', '', $entry);

  // Find aligned images with no caption and add them to the list of images
  preg_match_all('/\[image:(.*?)\|(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Remove aligned images with no caption from the body
  $entry = preg_replace('/\[image:(.*?)\|(.*?)\]/i', '', $entry);

  // Find full resolution images and add them to the list of images
  preg_match_all('/\[image:(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Find aligned nsfw images with a caption and add them to the list of images
  preg_match_all('/\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Remove aligned nsfw images with a caption from the body
  $entry = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]/i', '', $entry);

  // Find aligned nsfw images with no caption and add them to the list of images
  preg_match_all('/\[image-nsfw:(.*?)\|(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Remove aligned nsfw images with no caption from the body
  $entry = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\]/i', '', $entry);

  // Find full resolution nsfw images and add them to the list of images
  preg_match_all('/\[image-nsfw:(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Find gallery entries with a caption and add them to the list of images
  preg_match_all('/\[gallery:(.*?)\|(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Remove gallery entries with a caption from the body
  $entry = preg_replace('/\[gallery:(.*?)\|(.*?)\]/i', '', $entry);

  // Find gallery entries without a caption and add them to the list of images
  preg_match_all('/\[gallery:(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Find nsfw gallery entries with a caption and add them to the list of images
  preg_match_all('/\[gallery-nsfw:(.*?)\|(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Remove nsfw gallery entries with a caption from the body
  $entry = preg_replace('/\[gallery-nsfw:(.*?)\|(.*?)\]/i', '', $entry);

  // Find nsfw gallery entries without a caption and add them to the list of images
  preg_match_all('/\[gallery-nsfw:(.*?)\]/i', $entry, $matches);
  foreach($matches[1] as $match)
  {
    if(!in_array($match, $images))
      array_push($images, $match);
  }

  // Return the list of images
  return $images;
}