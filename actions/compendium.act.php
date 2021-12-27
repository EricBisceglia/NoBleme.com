<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


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
/*  compendium_images_autocomplete            Autocompletes an image file name.                                      */
/*                                                                                                                   */
/*  compendium_missing_get                    Returns data related to a missing compendium page.                     */
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
/*  compendium_format_url                     Formats a compendium page url.                                         */
/*  compendium_format_title                   Formats a compendium page title.                                       */
/*  compendium_format_image_name              Formats a compendium image name.                                       */
/*  compendium_nbcodes_apply                  Applies NBCodes to a string.                                           */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns data related to a compendium page.
 *
 * @param   int         $page_id      (OPTIONAL)  The page's id. Only one of these two parameters should be set.
 * @param   string      $page_url     (OPTIONAL)  The page's url. Only one of these two parameters should be set.
 * @param   bool        $no_loops     (OPTIONAL)  If false, page data will be returned even if it is a redirect loop.
 *
 * @return  array|null                        An array containing page related data, or NULL if it does not exist.
 */

function compendium_pages_get(  int     $page_id  = 0     ,
                                string  $page_url = ''    ,
                                bool    $no_loops = true  ) : mixed
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
  $dpage = mysqli_fetch_array(query(" SELECT    compendium_pages.id                 AS 'p_id'           ,
                                                compendium_pages.is_deleted         AS 'p_deleted'      ,
                                                compendium_pages.is_draft           AS 'p_draft'        ,
                                                compendium_pages.created_at         AS 'p_created'      ,
                                                compendium_pages.page_url           AS 'p_url'          ,
                                                compendium_pages.title_$lang        AS 'p_title'        ,
                                                compendium_pages.title_en           AS 'p_title_en'     ,
                                                compendium_pages.title_fr           AS 'p_title_fr'     ,
                                                compendium_pages.redirection_$lang  AS 'p_redirect'     ,
                                                compendium_pages.redirection_en     AS 'p_redirect_en'  ,
                                                compendium_pages.redirection_fr     AS 'p_redirect_fr'  ,
                                                compendium_pages.year_appeared      AS 'p_new_year'     ,
                                                compendium_pages.month_appeared     AS 'p_new_month'    ,
                                                compendium_pages.year_peak          AS 'p_peak_year'    ,
                                                compendium_pages.month_peak         AS 'p_peak_month'   ,
                                                compendium_pages.is_nsfw            AS 'p_nsfw'         ,
                                                compendium_pages.is_gross           AS 'p_gross'        ,
                                                compendium_pages.is_offensive       AS 'p_offensive'    ,
                                                compendium_pages.title_is_nsfw      AS 'p_nsfw_title'   ,
                                                compendium_pages.summary_$lang      AS 'p_summary'      ,
                                                compendium_pages.summary_en         AS 'p_summary_en'   ,
                                                compendium_pages.summary_fr         AS 'p_summary_fr'   ,
                                                compendium_pages.definition_$lang   AS 'p_body'         ,
                                                compendium_pages.definition_en      AS 'p_body_en'      ,
                                                compendium_pages.definition_fr      AS 'p_body_fr'      ,
                                                compendium_pages.admin_notes        AS 'p_admin_notes'  ,
                                                compendium_pages.admin_urls         AS 'p_admin_urls'   ,
                                                compendium_eras.id                  AS 'pe_id'          ,
                                                compendium_eras.name_$lang          AS 'pe_name'        ,
                                                compendium_types.id                 AS 'pt_id'          ,
                                                compendium_types.name_$lang         AS 'pt_name'        ,
                                                compendium_types.full_name_$lang    AS 'pt_display'
                                      FROM      compendium_pages
                                      LEFT JOIN compendium_types
                                      ON        compendium_pages.fk_compendium_types  = compendium_types.id
                                      LEFT JOIN compendium_eras
                                      ON        compendium_pages.fk_compendium_eras   = compendium_eras.id
                                      WHERE     $where "));

  // Return null if the page should not be displayed
  if(!$is_admin && $dpage['p_deleted'])
    return NULL;
  if(!$is_admin && $dpage['p_draft'])
    return NULL;
  if(!$is_admin && !$dpage['p_title'])
    return NULL;

  // Assemble an array with the data
  $page_id            = sanitize($dpage['p_id'], 'int', 0);
  $data['id']         = sanitize_output($dpage['p_id']);
  $data['deleted']    = $dpage['p_deleted'];
  $data['draft']      = $dpage['p_draft'];
  $data['url']        = sanitize_output($dpage['p_url']);
  $data['url_raw']    = $dpage['p_url'];
  $data['no_page']    = ($dpage['p_title']) ? 0 : 1;
  $temp               = (strlen($dpage['p_title']) > 25) ? 'h2' : 'h1';
  $temp               = (strlen($dpage['p_title']) > 30) ? 'h3' : $temp;
  $temp               = (strlen($dpage['p_title']) > 40) ? 'h4' : $temp;
  $data['title_size'] = (strlen($dpage['p_title']) > 50) ? 'h5' : $temp;
  $data['title']      = sanitize_output($dpage['p_title']);
  $data['title_en']   = sanitize_output($dpage['p_title_en']);
  $data['title_fr']   = sanitize_output($dpage['p_title_fr']);
  $data['titleenraw'] = $dpage['p_title_en'];
  $data['titlefrraw'] = $dpage['p_title_fr'];
  $data['redir_en']   = sanitize_output($dpage['p_redirect_en']);
  $data['redir_fr']   = sanitize_output($dpage['p_redirect_fr']);
  $temp               = ($dpage['p_new_month']) ? __('month_'.$dpage['p_new_month'], spaces_after: 1) : '';
  $data['appeared']   = ($dpage['p_new_year']) ? $temp.$dpage['p_new_year'] : '';
  $data['app_year']   = sanitize_output($dpage['p_new_year']);
  $data['app_month']  = sanitize_output($dpage['p_new_month']);
  $temp               = ($dpage['p_peak_month']) ? __('month_'.$dpage['p_peak_month'], spaces_after: 1) : '';
  $data['peak']       = ($dpage['p_peak_year']) ? $temp.$dpage['p_peak_year'] : '';
  $data['peak_year']  = sanitize_output($dpage['p_peak_year']);
  $data['peak_month'] = sanitize_output($dpage['p_peak_month']);
  $data['nsfw']       = sanitize_output($dpage['p_nsfw']);
  $data['offensive']  = sanitize_output($dpage['p_offensive']);
  $data['gross']      = sanitize_output($dpage['p_gross']);
  $data['nsfw_title'] = sanitize_output($dpage['p_nsfw_title']);
  $data['meta']       = sanitize_output(string_truncate($dpage['p_summary'], 140, '...'));
  $data['summary']    = sanitize_output($dpage['p_summary']);
  $data['summary_en'] = sanitize_output($dpage['p_summary_en']);
  $data['summary_fr'] = sanitize_output($dpage['p_summary_fr']);
  $temp               = bbcodes(sanitize_output($dpage['p_body'], preserve_line_breaks: true));
  $data['body']       = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $data['body_en']    = sanitize_output($dpage['p_body_en']);
  $data['body_fr']    = sanitize_output($dpage['p_body_fr']);
  $data['admin_note'] = sanitize_output($dpage['p_admin_notes']);
  $data['admin_urls'] = sanitize_output($dpage['p_admin_urls']);
  $data['type_id']    = sanitize_output($dpage['pt_id']);
  $data['type']       = sanitize_output($dpage['pt_name']);
  $data['type_full']  = sanitize_output(string_change_case($dpage['pt_display'], 'lowercase'));
  $data['era_id']     = sanitize_output($dpage['pe_id']);
  $data['era']        = sanitize_output($dpage['pe_name']);

  // Fetch the latest update
  $dupdate = mysqli_fetch_array(query(" SELECT    compendium_pages_history.edited_at AS 'ph_time'
                                        FROM      compendium_pages_history
                                        WHERE     compendium_pages_history.fk_compendium_pages = '$page_id'
                                        ORDER BY  compendium_pages_history.edited_at DESC
                                        LIMIT     1 "));

  // Prepare the lastest update
  $temp             = (isset($dupdate['ph_time']) && $dupdate['ph_time']) ? $dupdate['ph_time'] : $dpage['p_created'];
  $data['updated']  = ($temp) ? sanitize_output(string_change_case(time_since($temp), 'lowercase')) : __('error');

  // Fetch any associated categories
  $qcategories = query("  SELECT    compendium_pages_categories.id    AS 'cpc_id'   ,
                                    compendium_categories.id          AS 'pc_id'    ,
                                    compendium_categories.name_$lang  AS 'pc_name'
                          FROM      compendium_pages_categories
                          LEFT JOIN compendium_categories
                          ON        compendium_pages_categories.fk_compendium_categories  = compendium_categories.id
                          WHERE     compendium_pages_categories.fk_compendium_pages       = '$page_id'
                          ORDER BY  compendium_categories.display_order ASC ");

  // Prepare the category data
  for($i = 0; $row = mysqli_fetch_array($qcategories); $i++)
  {
    $data['category_id'][$i]    = sanitize_output($row['pc_id']);
    $data['category_name'][$i]  = sanitize_output($row['pc_name']);
  }

  // Add the number of categories do the data
  $data['categories'] = $i;

  // If the page is a redirection, check whether it is a legal redirection
  if($dpage['p_redirect'] && $no_loops)
  {
    // Sanitize the redirection
    $redirect_page = sanitize($dpage['p_redirect'], 'string');

    // Check if the redirection is a valid page url
    if(database_entry_exists('compendium_pages', 'page_url', $redirect_page))
    {
      // Check if the redirection is a redirection
      $dredirect = mysqli_fetch_array(query(" SELECT  compendium_pages.redirection_$lang  AS 'p_redirect'
                                              FROM    compendium_pages
                                              WHERE   compendium_pages.page_url LIKE '$redirect_page' "));

      // Return null if the redirection is a redirection
      if($dredirect['p_redirect'])
        return NULL;

      // Otherwise add the redirection's url to the returned data
      $data['redirect'] = $redirect_page;
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
 * @param   int     $exclude_id   (OPTIONAL)  A page id to exclude from the pages being fetched.
 * @param   int     $type         (OPTIONAL)  Request a specific page type for the randomly returned page.
 *
 * @return  string                            The url of a randomly chosen compendium page.
 */

function compendium_pages_get_random( int $exclude_id = 0 ,
                                      int $type       = 0 ) : string
{
  // Sanitize the page type
  $type = sanitize($type, 'string');

  // Prepare the page type condition
  $query_type = ($type) ? " AND compendium_pages.fk_compendium_types = '$type' " : '';

  // Sanitize the excluded id
  $exclude_id = sanitize($exclude_id, 'int', 0);

  // Add the excluded id if necessary
  $query_exclude = ($exclude_id) ? " AND compendium_pages.id != '$exclude_id' " : '';

  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch a random page's url
  $dpage = mysqli_fetch_array(query(" SELECT    compendium_pages.page_url AS 'c_url'
                                      FROM      compendium_pages
                                      WHERE     compendium_pages.is_deleted         = 0
                                      AND       compendium_pages.is_draft           = 0
                                      AND       compendium_pages.title_$lang        NOT LIKE ''
                                      AND       compendium_pages.redirection_$lang  LIKE ''
                                      AND       compendium_pages.is_nsfw            = 0
                                      AND       compendium_pages.is_gross           = 0
                                      AND       compendium_pages.is_offensive       = 0
                                                $query_type
                                                $query_exclude
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
 *
 * @return  array                           An array containing compendium pages.
 */

function compendium_pages_list( string  $sort_by    = 'date'    ,
                                array   $search     = array()   ,
                                int     $limit      = 0         ,
                                bool    $user_view  = false     ) : array
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');
  require_included_file('functions_time.inc.php');

  // Get the user's current language, access rights, settings, and the compendium pages which they can access
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = ($user_view) ? 0 : user_is_administrator();
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Sanitize the search parameters
  $search_url         = isset($search['url'])         ? sanitize($search['url'], 'string')                  : '';
  $search_translation = isset($search['translation']) ? sanitize($search['translation'], -1, 1)             : 0;
  $search_title       = isset($search['title'])       ? sanitize($search['title'], 'string')                : '';
  $search_redirect    = isset($search['redirect'])    ? sanitize($search['redirect'], -1, 1)                : 0;
  $search_redirname   = isset($search['redirname'])   ? sanitize($search['redirname'], 'string')            : '';
  $search_nsfw        = isset($search['nsfw'])        ? sanitize($search['nsfw'], 'int', -1, 1)             : -1;
  $search_gross       = isset($search['gross'])       ? sanitize($search['gross'], 'int', -1, 1)            : -1;
  $search_offensive   = isset($search['offensive'])   ? sanitize($search['offensive'], 'int', -1, 1)        : -1;
  $search_nsfw_title  = isset($search['nsfw_title'])  ? sanitize($search['nsfw_title'], 'int', -1, 1)       : -1;
  $search_type        = isset($search['type'])        ? sanitize($search['type'], 'int', 0)                 : 0;
  $search_era         = isset($search['era'])         ? sanitize($search['era'], 'int', 0)                  : 0;
  $search_category    = isset($search['category'])    ? sanitize($search['category'], 'int', -2)            : 0;
  $search_language    = isset($search['language'])    ? sanitize($search['language'], 'string')             : '';
  $search_appeared    = isset($search['appeared'])    ? sanitize($search['appeared'], 'int', 0, date('Y'))  : 0;
  $search_peaked      = isset($search['peaked'])      ? sanitize($search['peaked'], 'int', 0, date('Y'))    : 0;
  $search_created     = isset($search['created'])     ? sanitize($search['created'], 'int', 0, date('Y'))   : 0;
  $search_nsfw_admin  = isset($search['nsfw_admin'])  ? sanitize($search['nsfw_admin'], 'string')           : '';
  $search_wip         = isset($search['wip'])         ? sanitize($search['wip'], 'string')                  : '';
  $search_notes       = isset($search['notes'])       ? sanitize($search['notes'], 'int', 0, 1)             : 0;

  // Join categories if required
  $join_categories = ($search_category || isset($search['join_categories'])) ? " LEFT JOIN compendium_pages_categories ON compendium_pages_categories.fk_compendium_pages = compendium_pages.id ": '';
  $count_categories = ($join_categories) ? " , COUNT(compendium_pages_categories.id) AS 'pc_count' " : '';

  // Fetch the pages
  $qpages = "     SELECT    compendium_pages.id                 AS 'p_id'         ,
                            compendium_pages.is_deleted         AS 'p_deleted'    ,
                            compendium_pages.is_draft           AS 'p_draft'      ,
                            compendium_pages.created_at         AS 'p_created'    ,
                            compendium_pages.last_edited_at     AS 'p_edited'     ,
                            compendium_pages.page_url           AS 'p_url'        ,
                            compendium_pages.title_$lang        AS 'p_title'      ,
                            compendium_pages.title_en           AS 'p_title_en'   ,
                            compendium_pages.title_fr           AS 'p_title_fr'   ,
                            compendium_pages.redirection_$lang  AS 'p_redirect'   ,
                            compendium_pages.year_appeared      AS 'p_app_year'   ,
                            compendium_pages.month_appeared     AS 'p_app_month'  ,
                            compendium_pages.year_peak          AS 'p_peak_year'  ,
                            compendium_pages.month_peak         AS 'p_peak_month' ,
                            compendium_pages.is_nsfw            AS 'p_nsfw'       ,
                            compendium_pages.is_gross           AS 'p_gross'      ,
                            compendium_pages.is_offensive       AS 'p_offensive'  ,
                            compendium_pages.title_is_nsfw      AS 'p_nsfw_title' ,
                            compendium_pages.summary_$lang      AS 'p_summary'    ,
                            compendium_pages.admin_notes        AS 'p_notes'      ,
                            compendium_pages.admin_urls         AS 'p_urlnotes'   ,
                            compendium_eras.id                  AS 'pe_id'        ,
                            compendium_eras.short_name_$lang    AS 'pe_name'      ,
                            compendium_types.id                 AS 'pt_id'        ,
                            compendium_types.name_$lang         AS 'pt_name'      ,
                            compendium_types.full_name_$lang    AS 'pt_display'
                            $count_categories
                  FROM      compendium_pages
                  LEFT JOIN compendium_types  ON compendium_pages.fk_compendium_types = compendium_types.id
                  LEFT JOIN compendium_eras   ON compendium_pages.fk_compendium_eras  = compendium_eras.id
                            $join_categories
                  WHERE     1 = 1 ";

  // Do not show deleted pages or drafts to regular users
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.is_deleted = 0
                  AND       compendium_pages.is_draft   = 0 ";

  // Do not show redirections so regular users
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.redirection_$lang = '' ";

  // Regular users should only see pages with a title matching their current language
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.title_$lang != '' ";

  // Search the data
  if($search_url && $is_admin)
    $qpages .= "  AND       compendium_pages.page_url                             LIKE '%$search_url%'        ";
  if($search_translation == -1 && $is_admin)
    $qpages .= "  AND       compendium_pages.title_$lang                          =     ''                    ";
  else if($search_translation == 1 && $is_admin)
    $qpages .= "  AND       compendium_pages.title_$lang                          !=    ''                    ";
  if($search_title == 'exists' && $is_admin)
    $qpages .= "  AND       compendium_pages.title_$lang                          !=    ''                    ";
  else if($search_title)
    $qpages .= "  AND       compendium_pages.title_$lang                          LIKE  '%$search_title%'     ";
  if($search_redirect == -1)
    $qpages .= "  AND       compendium_pages.redirection_$lang                    =     ''                    ";
  else if($search_redirect == 1 && $is_admin)
    $qpages .= "  AND       compendium_pages.redirection_$lang                    !=    ''                    ";
  if($search_redirname && $is_admin)
    $qpages .= "  AND       compendium_pages.redirection_$lang                    LIKE  '%$search_redirname%' ";
  if($search_nsfw > -1)
    $qpages .= "  AND       compendium_pages.is_nsfw                              =     '$search_nsfw'        ";
  if($search_gross > -1)
    $qpages .= "  AND       compendium_pages.is_gross                             =     '$search_gross'       ";
  if($search_offensive > -1)
    $qpages .= "  AND       compendium_pages.is_offensive                         =     '$search_offensive'   ";
  if($search_nsfw_title > -1)
    $qpages .= "  AND       compendium_pages.title_is_nsfw                        =     '$search_nsfw_title'  ";
  if($search_type)
    $qpages .= "  AND       compendium_pages.fk_compendium_types                  =     '$search_type'        ";
  if($search_era)
    $qpages .= "  AND       compendium_pages.fk_compendium_eras                   =     '$search_era'         ";
  if($search_category > 0)
    $qpages .= "  AND       compendium_pages_categories.fk_compendium_categories  =     '$search_category'    ";
  else if($search_category == -1)
    $qpages .= "  AND       compendium_pages_categories.fk_compendium_categories  IS NULL                     ";
  else if($search_category == -2)
    $qpages .= "  AND       compendium_pages_categories.fk_compendium_categories  IS NOT NULL                 ";
  if($search_language == 'monolingual' && $is_admin)
    $qpages .= "  AND     ( compendium_pages.title_en                             =     ''
                  OR        compendium_pages.title_fr                             =     '' )                  ";
  else if($search_language == 'bilingual' && $is_admin)
    $qpages .= "  AND       compendium_pages.title_en                             !=    ''
                  AND       compendium_pages.title_fr                             !=    ''                    ";
  else if($search_language == 'english' && $is_admin)
    $qpages .= "  AND       compendium_pages.title_en                             !=    ''                    ";
  else if($search_language == 'french' && $is_admin)
    $qpages .= "  AND       compendium_pages.title_fr                             !=    ''                    ";
  if($search_appeared)
    $qpages .= "  AND       compendium_pages.year_appeared                        =     '$search_appeared'    ";
  if($search_peaked)
    $qpages .= "  AND       compendium_pages.year_peak                            =     '$search_peaked'      ";
  if($search_created)
    $qpages .= "  AND       YEAR(FROM_UNIXTIME(compendium_pages.created_at))      =     '$search_created'     ";
  if($search_nsfw_admin == 'nsfw' && $is_admin)
    $qpages .= "  AND     ( compendium_pages.title_is_nsfw                        =     1
                  OR        compendium_pages.is_nsfw                              =     1
                  OR        compendium_pages.is_gross                             =     1
                  OR        compendium_pages.is_offensive                         =     1 )                   ";
  else if($search_nsfw_admin == 'safe' && $is_admin)
    $qpages .= "  AND       compendium_pages.title_is_nsfw                        =     0
                  AND       compendium_pages.is_nsfw                              =     0
                  AND       compendium_pages.is_gross                             =     0
                  AND       compendium_pages.is_offensive                         =     0                     ";
  else if($search_nsfw_admin == 'title' && $is_admin)
    $qpages .= "  AND       compendium_pages.title_is_nsfw                        =     1                     ";
  else if($search_nsfw_admin == 'page' && $is_admin)
    $qpages .= "  AND       compendium_pages.is_nsfw                              =     1                     ";
  else if($search_nsfw_admin == 'gross' && $is_admin)
    $qpages .= "  AND       compendium_pages.is_gross                             =     1                     ";
  else if($search_nsfw_admin == 'offensive' && $is_admin)
    $qpages .= "  AND       compendium_pages.is_offensive                         =     1                     ";
  if($search_wip == 'draft' && $is_admin)
    $qpages .= "  AND       compendium_pages.is_draft                             =     1                     ";
  else if($search_wip == 'deleted' && $is_admin)
    $qpages .= "  AND       compendium_pages.is_deleted                           =     1                     ";
  else if($search_wip == 'finished' && $is_admin)
    $qpages .= "  AND       compendium_pages.is_draft                             =     0
                  AND       compendium_pages.is_deleted                           =     0                     ";
  if($search_notes && $is_admin)
    $qpages .= "  AND     ( compendium_pages.admin_notes                          !=    ''
                  OR        compendium_pages.admin_urls                           !=    '' )                  ";

  // Avoid duplicates if categories are included
  if($join_categories)
    $qpages .= " GROUP BY compendium_pages.id ";

  // Sort the data
  if($sort_by == 'url' && $is_admin)
    $qpages .= "  ORDER BY    compendium_pages.page_url             ASC                 ";
  else if($sort_by == 'title')
    $qpages .= "  ORDER BY    compendium_pages.title_$lang          = ''                ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'redirect' && $is_admin)
    $qpages .= "  ORDER BY    compendium_pages.redirection_$lang    = ''                ,
                              compendium_pages.redirection_$lang    ASC                 ,
                              compendium_pages.page_url             ASC                 ";
  else if($sort_by == 'theme')
    $qpages .= "  ORDER BY    compendium_types.name_en              != 'meme'           ,
                              compendium_types.name_en              != 'definition'     ,
                              compendium_types.name_en              != 'sociocultural'  ,
                              compendium_types.name_en              ASC                 ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'categories' && $is_admin)
    $qpages .= "  ORDER BY    compendium_pages_categories.id        IS NULL             ,
                              COUNT(compendium_pages_categories.id) DESC                ,
                              compendium_pages.page_url             ASC                 ";
  else if($sort_by == 'era')
    $qpages .= "  ORDER BY    compendium_eras.id                    IS NULL             ,
                              compendium_eras.year_start            DESC                ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'appeared')
    $qpages .= "  ORDER BY    compendium_pages.year_appeared        DESC                ,
                              compendium_pages.month_appeared       DESC                ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'appeared_desc')
    $qpages .= "  ORDER BY    compendium_pages.year_appeared        = 0                 ,
                              compendium_pages.year_appeared        ASC                 ,
                              compendium_pages.month_appeared       ASC                 ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'peak')
    $qpages .= "  ORDER BY    compendium_pages.year_peak            DESC                ,
                              compendium_pages.month_peak           DESC                ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'peak_desc')
    $qpages .= "  ORDER BY    compendium_pages.year_peak            = 0                 ,
                              compendium_pages.year_peak            ASC                 ,
                              compendium_pages.month_peak           ASC                 ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'created')
    $qpages .= "  ORDER BY    compendium_pages.created_at           DESC                ,
                              compendium_pages.title_$lang          ASC                 ";
  else if($sort_by == 'language' && $is_admin)
    $qpages .= "  ORDER BY  ( compendium_pages.title_en             != ''
                  AND         compendium_pages.title_fr             != '' )             ,
                              compendium_pages.title_en             = ''                ,
                              compendium_pages.title_fr             = ''                ,
                              compendium_pages.page_url             ASC                 ";
  else if($sort_by == 'nsfw' && $is_admin)
    $qpages .= "  ORDER BY    compendium_pages.title_is_nsfw        = ''                ,
                              compendium_pages.is_nsfw              = ''                ,
                              compendium_pages.is_gross             = ''                ,
                              compendium_pages.is_offensive         = ''                ,
                              compendium_pages.page_url             ASC                 ";
  else if($sort_by == 'wip' && $is_admin)
    $qpages .= "  ORDER BY    compendium_pages.is_draft             = 0                 ,
                              compendium_pages.is_deleted           = 0                 ,
                              compendium_pages.page_url             ASC                 ";
  else
    $qpages .= "  ORDER BY
                  GREATEST  ( compendium_pages.created_at                               ,
                              compendium_pages.last_edited_at )     DESC                ,
                              compendium_pages.title_$lang          ASC                 ";

  // Limit the amount of pages returned
  if($limit)
    $qpages .= "  LIMIT $limit ";

  // Run the query
  $qpages = query($qpages);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qpages); $i++)
  {
    $data[$i]['id']         = sanitize_output($row['p_id']);
    $data[$i]['deleted']    = ($row['p_deleted']);
    $data[$i]['draft']      = ($row['p_draft']);
    $data[$i]['created']    = ($row['p_created']) ? sanitize_output(time_since($row['p_created'])) : '';
    $data[$i]['edited']     = ($row['p_edited']) ? sanitize_output(time_since($row['p_edited'])) : '';
    $data[$i]['url']        = sanitize_output($row['p_url']);
    $data[$i]['urldisplay'] = sanitize_output(string_truncate($row['p_url'], 25, '...'));
    $data[$i]['fullurl']    = (mb_strlen($row['p_url']) > 25) ? sanitize_output($row['p_url']) : '';
    $data[$i]['title']      = sanitize_output($row['p_title']);
    $data[$i]['shorttitle'] = sanitize_output(string_truncate($row['p_title'], 32, '...'));
    $data[$i]['fulltitle']  = (mb_strlen($row['p_title']) > 32) ? sanitize_output($row['p_title']) : '';
    $data[$i]['admintitle'] = sanitize_output(string_truncate($row['p_title'], 25, '...'));
    $data[$i]['adminfull']  = (mb_strlen($row['p_title']) > 25) ? sanitize_output($row['p_title']) : '';
    $temp                   = ($lang == 'en') ? $row['p_title_fr'] : $row['p_title_en'];
    $data[$i]['wrongtitle'] = sanitize_output(string_truncate($temp, 23, '...'));
    $data[$i]['fullwrong']  = (mb_strlen($temp) > 23) ? sanitize_output($temp) : '';
    $data[$i]['lang_en']    = ($row['p_title_en']) ? 1 : 0;
    $data[$i]['lang_fr']    = ($row['p_title_fr']) ? 1 : 0;
    $data[$i]['redirect']   = sanitize_output(string_truncate($row['p_redirect'], 20, '...'));
    $data[$i]['fullredir']  = (mb_strlen($row['p_redirect']) > 20) ? sanitize_output($row['p_redirect']) : '';
    $temp                   = ($row['p_app_month']) ? __('month_'.$row['p_app_month'], spaces_after: 1) : '';
    $data[$i]['appeared']   = ($row['p_app_year']) ? $temp.$row['p_app_year'] : '';
    $temp                   = ($row['p_app_month']) ? __('month_short_'.$row['p_app_month'], spaces_after: 1) : '';
    $data[$i]['app_short']  = ($row['p_app_year']) ? $temp.mb_substr($row['p_app_year'], 2) : '';
    $temp                   = ($row['p_peak_month']) ? __('month_'.$row['p_peak_month'], spaces_after: 1) : '';
    $data[$i]['peak']       = ($row['p_peak_year']) ? $temp.$row['p_peak_year'] : '';
    $temp                   = ($row['p_peak_month']) ? __('month_short_'.$row['p_peak_month'], spaces_after: 1) : '';
    $data[$i]['peak_short'] = ($row['p_peak_year']) ? $temp.mb_substr($row['p_peak_year'], 2) : '';
    $data[$i]['blur']       = ($row['p_nsfw_title'] && $nsfw < 2) ? ' blur' : '';
    $data[$i]['blur_link']  = ($row['p_nsfw_title'] && $nsfw < 2) ? ' blur' : ' forced_link';
    $temp                   = bbcodes(sanitize_output($row['p_summary'], preserve_line_breaks: true));
    $data[$i]['adminnsfw']  = ($row['p_nsfw'] || $row['p_gross'] || $row['p_offensive'] || $row['p_nsfw_title']);
    $data[$i]['nsfw']       = ($row['p_nsfw']);
    $data[$i]['gross']      = ($row['p_gross']);
    $data[$i]['offensive']  = ($row['p_offensive']);
    $data[$i]['nsfwtitle']  = ($row['p_nsfw_title']);
    $data[$i]['summary']    = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
    $data[$i]['notes']      = sanitize_output($row['p_notes']);
    $data[$i]['urlnotes']   = sanitize_output($row['p_urlnotes']);
    $data[$i]['type_id']    = sanitize_output($row['pt_id']);
    $data[$i]['type']       = sanitize_output($row['pt_name']);
    $data[$i]['era_id']     = sanitize_output($row['pe_id']);
    $data[$i]['era']        = sanitize_output($row['pe_name']);
    $data[$i]['categories'] = ($join_categories) ? sanitize_output($row['pc_count']) : 0;

    // Prepare the admin urls
    if($row['p_urlnotes'])
    {
      // Split the urls
      $admin_urls = explode("|||", $row['p_urlnotes']);

      // Format the url list
      $formatted_admin_urls = '';
      for($j = 0; $j < count($admin_urls); $j++)
        $formatted_admin_urls .= __link($admin_urls[$j], string_truncate($admin_urls[$j], 40, '...'), is_internal: false).'<br>';

      // Add the formatted page list and the page count to the data
      $data[$i]['urlnotes'] = $formatted_admin_urls;
      $data[$i]['urlcount'] = $j;
    }
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

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
                    WHERE     compendium_pages.title_$lang != ''
                    AND       compendium_pages.is_deleted   = 0
                    AND       compendium_pages.is_draft     = 0
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
  $page_redirect_en   = isset($contents['redirect_en'])   ? sanitize($contents['redirect_en'], 'string')      : '';
  $page_redirect_fr   = isset($contents['redirect_fr'])   ? sanitize($contents['redirect_fr'], 'string')      : '';
  $page_summary_en    = isset($contents['summary_en'])    ? sanitize($contents['summary_en'], 'string')       : '';
  $page_summary_fr    = isset($contents['summary_fr'])    ? sanitize($contents['summary_fr'], 'string')       : '';
  $page_body_en       = isset($contents['body_en'])       ? sanitize($contents['body_en'], 'string')          : '';
  $page_body_fr       = isset($contents['body_fr'])       ? sanitize($contents['body_fr'], 'string')          : '';
  $page_appear_month  = isset($contents['appear_month'])  ? sanitize($contents['appear_month'], 'int', 0, 12) : 0;
  $page_appear_year   = isset($contents['appear_year'])   ? sanitize($contents['appear_year'], 'int', 0)      : 0;
  $page_peak_month    = isset($contents['peak_month'])    ? sanitize($contents['peak_month'], 'int', 0, 12)   : 0;
  $page_peak_year     = isset($contents['peak_year'])     ? sanitize($contents['peak_year'], 'int', 0)        : 0;
  $page_nsfw_title    = isset($contents['nsfw_title'])    ? sanitize($contents['nsfw_title'], 'int', 0, 1)    : 0;
  $page_nsfw          = isset($contents['nsfw'])          ? sanitize($contents['nsfw'], 'int', 0, 1)          : 0;
  $page_gross         = isset($contents['gross'])         ? sanitize($contents['gross'], 'int', 0, 1)         : 0;
  $page_offensive     = isset($contents['offensive'])     ? sanitize($contents['offensive'], 'int', 0, 1)     : 0;
  $page_type          = isset($contents['type'])          ? sanitize($contents['type'], 'int', 0)             : 0;
  $page_era           = isset($contents['era'])           ? sanitize($contents['era'], 'int', 0)              : 0;
  $page_admin_notes   = isset($contents['admin_notes'])   ? sanitize($contents['admin_notes'], 'string')      : '';
  $page_admin_urls    = isset($contents['admin_urls'])    ? sanitize($contents['admin_urls'], 'string')       : '';

  // Error: No URL or URL already taken
  if(!$page_url || database_entry_exists('compendium_pages', 'page_url', $page_url))
    return __('compendium_page_new_no_url');

  // Error: No title in either language
  if(!$page_title_en && !$page_title_fr)
    return __('compendium_page_new_no_title');

  // Error: Redirects to non existing pages
  if($page_redirect_en && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_en))
    return __('compendium_page_new_bad_redirect');
  if($page_redirect_fr && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_fr))
    return __('compendium_page_new_bad_redirect');

  // Error: No page type
  if(!$page_type || !database_row_exists('compendium_types', $page_type))
    return __('compendium_page_new_no_type');

  // Create the compendium page
  query(" INSERT INTO compendium_pages
          SET         compendium_pages.fk_compendium_types  = '$page_type'          ,
                      compendium_pages.fk_compendium_eras   = '$page_era'           ,
                      compendium_pages.is_draft             = 1                     ,
                      compendium_pages.created_at           = '$timestamp'          ,
                      compendium_pages.page_url             = '$page_url'           ,
                      compendium_pages.title_en             = '$page_title_en'      ,
                      compendium_pages.title_fr             = '$page_title_fr'      ,
                      compendium_pages.redirection_en       = '$page_redirect_en'   ,
                      compendium_pages.redirection_fr       = '$page_redirect_fr'   ,
                      compendium_pages.year_appeared        = '$page_appear_year'   ,
                      compendium_pages.month_appeared       = '$page_appear_month'  ,
                      compendium_pages.year_peak            = '$page_peak_year'     ,
                      compendium_pages.month_peak           = '$page_peak_month'    ,
                      compendium_pages.is_nsfw              = '$page_nsfw'          ,
                      compendium_pages.is_gross             = '$page_gross'         ,
                      compendium_pages.is_offensive         = '$page_offensive'     ,
                      compendium_pages.title_is_nsfw        = '$page_nsfw_title'    ,
                      compendium_pages.summary_en           = '$page_summary_en'    ,
                      compendium_pages.summary_fr           = '$page_summary_fr'    ,
                      compendium_pages.definition_en        = '$page_body_en'       ,
                      compendium_pages.definition_fr        = '$page_body_fr'       ,
                      compendium_pages.admin_notes          = '$page_admin_notes'   ,
                      compendium_pages.admin_urls           = '$page_admin_urls'    ");

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
  $page_redirect_en   = isset($contents['redirect_en'])   ? sanitize($contents['redirect_en'], 'string')      : '';
  $page_redirect_fr   = isset($contents['redirect_fr'])   ? sanitize($contents['redirect_fr'], 'string')      : '';
  $page_summary_en    = isset($contents['summary_en'])    ? sanitize($contents['summary_en'], 'string')       : '';
  $page_summary_fr    = isset($contents['summary_fr'])    ? sanitize($contents['summary_fr'], 'string')       : '';
  $page_body_en       = isset($contents['body_en'])       ? sanitize($contents['body_en'], 'string')          : '';
  $page_body_fr       = isset($contents['body_fr'])       ? sanitize($contents['body_fr'], 'string')          : '';
  $page_appear_month  = isset($contents['appear_month'])  ? sanitize($contents['appear_month'], 'int', 0, 12) : 0;
  $page_appear_year   = isset($contents['appear_year'])   ? sanitize($contents['appear_year'], 'int', 0)      : 0;
  $page_peak_month    = isset($contents['peak_month'])    ? sanitize($contents['peak_month'], 'int', 0, 12)   : 0;
  $page_peak_year     = isset($contents['peak_year'])     ? sanitize($contents['peak_year'], 'int', 0)        : 0;
  $page_nsfw_title    = isset($contents['nsfw_title'])    ? sanitize($contents['nsfw_title'], 'int', 0, 1)    : 0;
  $page_nsfw          = isset($contents['nsfw'])          ? sanitize($contents['nsfw'], 'int', 0, 1)          : 0;
  $page_gross         = isset($contents['gross'])         ? sanitize($contents['gross'], 'int', 0, 1)         : 0;
  $page_offensive     = isset($contents['offensive'])     ? sanitize($contents['offensive'], 'int', 0, 1)     : 0;
  $page_type          = isset($contents['type'])          ? sanitize($contents['type'], 'int', 0)             : 0;
  $page_era           = isset($contents['era'])           ? sanitize($contents['era'], 'int', 0)              : 0;
  $page_admin_notes   = isset($contents['admin_notes'])   ? sanitize($contents['admin_notes'], 'string')      : '';
  $page_admin_urls    = isset($contents['admin_urls'])    ? sanitize($contents['admin_urls'], 'string')       : '';
  $page_history_en    = isset($contents['history_en'])    ? sanitize($contents['history_en'], 'string')       : '';
  $page_history_fr    = isset($contents['history_fr'])    ? sanitize($contents['history_fr'], 'string')       : '';
  $page_history_major = isset($contents['major'])         ? sanitize($contents['major'], 'int', 0, 1)         : 0;

  // Error: No URL
  if(!$page_url)
    return __('compendium_page_new_no_url');

  // Error: New URL is already taken
  if(($page_url_raw != $page_data['url_raw']) && database_entry_exists('compendium_pages', 'page_url', $page_url))
    return __('compendium_page_new_no_url');

  // Error: No title in either language
  if(!$page_title_en && !$page_title_fr)
    return __('compendium_page_new_no_title');

  // Error: Redirects to non existing pages
  if($page_redirect_en && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_en))
    return __('compendium_page_new_bad_redirect');
  if($page_redirect_fr && !database_entry_exists('compendium_pages', 'page_url', $page_redirect_fr))
    return __('compendium_page_new_bad_redirect');

  // Error: No page type
  if(!$page_type || !database_row_exists('compendium_types', $page_type))
    return __('compendium_page_new_no_type');

  // Update the compendium page
  query(" UPDATE  compendium_pages
          SET     compendium_pages.fk_compendium_types  = '$page_type'          ,
                  compendium_pages.fk_compendium_eras   = '$page_era'           ,
                  compendium_pages.page_url             = '$page_url'           ,
                  compendium_pages.title_en             = '$page_title_en'      ,
                  compendium_pages.title_fr             = '$page_title_fr'      ,
                  compendium_pages.redirection_en       = '$page_redirect_en'   ,
                  compendium_pages.redirection_fr       = '$page_redirect_fr'   ,
                  compendium_pages.year_appeared        = '$page_appear_year'   ,
                  compendium_pages.month_appeared       = '$page_appear_month'  ,
                  compendium_pages.year_peak            = '$page_peak_year'     ,
                  compendium_pages.month_peak           = '$page_peak_month'    ,
                  compendium_pages.is_nsfw              = '$page_nsfw'          ,
                  compendium_pages.is_gross             = '$page_gross'         ,
                  compendium_pages.is_offensive         = '$page_offensive'     ,
                  compendium_pages.title_is_nsfw        = '$page_nsfw_title'    ,
                  compendium_pages.summary_en           = '$page_summary_en'    ,
                  compendium_pages.summary_fr           = '$page_summary_fr'    ,
                  compendium_pages.definition_en        = '$page_body_en'       ,
                  compendium_pages.definition_fr        = '$page_body_fr'       ,
                  compendium_pages.admin_notes          = '$page_admin_notes'   ,
                  compendium_pages.admin_urls           = '$page_admin_urls'
          WHERE   compendium_pages.id                   = '$page_id'            ");

  // Fetch the category list
  $categories = compendium_categories_list();

  // Prepare the page's category list
  $page_categories = ($page_data['category_id']) ? $page_data['category_id'] : array();

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
  if($page_url_raw != $page_data['url_raw'])
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

  // Do not handle history, activity or integrations for redirections, deleted pages, or drafts
  if(!$page_redirect_en && !$page_redirect_fr && !$page_data['draft'] && !$page_data['deleted'])
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

  // Recalculate the image's links
  compendium_images_recalculate_links($image_id);

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
  $temp               = ($dimage['ci_nsfw'] || $dimage['ci_gross'] || $dimage['ci_offensive']) ? 1 : 0;
  $data['blur']       = ($nsfw < 2 && $temp) ? ' class="compendium_image_blur"' : '';
  $data['blurred']    = ($nsfw < 2 && $temp) ? 1 : 0;
  $data['body_clean'] = sanitize_output($dimage['ci_body']);
  $temp               = bbcodes(sanitize_output($dimage['ci_body'], preserve_line_breaks: true));
  $data['body']       = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $page_links         = ($dimage['ci_used']) ? compendium_images_assemble_links($dimage['ci_used']) : '';
  $data['used']       = ($dimage['ci_used']) ? $page_links['list'] : '';
  $data['used_count'] = ($dimage['ci_used']) ? $page_links['count'] : 0;
  $data['used_en']    = sanitize_output($dimage['ci_used_en']);
  $data['used_fr']    = sanitize_output($dimage['ci_used_fr']);
  $data['caption_en'] = sanitize_output($dimage['ci_caption_en']);
  $data['caption_fr'] = sanitize_output($dimage['ci_caption_fr']);

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

  // Sanitize the search parameters
  $search_name    = isset($search['name'])    ? sanitize($search['name'], 'string')       : '';
  $search_date    = isset($search['date'])    ? sanitize($search['date'], 0)              : 0;
  $search_nsfw    = isset($search['nsfw'])    ? sanitize($search['nsfw'], 'string')       : '';
  $search_used_en = isset($search['used_en']) ? sanitize($search['used_en'], 'string')    : '';
  $search_used_fr = isset($search['used_fr']) ? sanitize($search['used_fr'], 'string')    : '';
  $search_tags    = isset($search['tags'])    ? sanitize($search['tags'], 'string')       : '';
  $search_caption = isset($search['caption']) ? sanitize($search['caption'], 'string')    : '';
  $search_deleted = isset($search['deleted']) ? sanitize($search['deleted'], 'int', 0, 2) : 0;

  // Fetch the images
  $qimages = "     SELECT   compendium_images.id                AS 'ci_id'          ,
                            compendium_images.is_deleted        AS 'ci_del'         ,
                            compendium_images.uploaded_at       AS 'ci_date'        ,
                            compendium_images.file_name         AS 'ci_name'        ,
                            compendium_images.tags              AS 'ci_tags'        ,
                            compendium_images.is_nsfw           AS 'ci_nsfw'        ,
                            compendium_images.is_gross          AS 'ci_gross'       ,
                            compendium_images.is_offensive      AS 'ci_offensive'   ,
                            compendium_images.used_in_pages_en  AS 'ci_used_en'     ,
                            compendium_images.used_in_pages_fr  AS 'ci_used_fr'     ,
                            compendium_images.caption_$lang     AS 'ci_caption'     ,
                            compendium_images.caption_en        AS 'ci_caption_en'  ,
                            compendium_images.caption_fr        AS 'ci_caption_fr'
                  FROM      compendium_images
                  WHERE     1 = 1 ";

  // Search the data
  if($search_name)
    $qimages .= " AND       compendium_images.file_name                         LIKE  '%$search_name%'    ";
  if($search_date)
    $qimages .= " AND       YEAR(FROM_UNIXTIME(compendium_images.uploaded_at))  =     '$search_date'      ";
  if($search_nsfw == 'safe')
    $qimages .= " AND       compendium_images.is_nsfw                           =     0
                  AND       compendium_images.is_gross                          =     0
                  AND       compendium_images.is_offensive                      =     0                   ";
  else if($search_nsfw == 'nsfw')
    $qimages .= " AND     ( compendium_images.is_nsfw                           =     1
                  OR        compendium_images.is_gross                          =     1
                  OR        compendium_images.is_offensive                      =     1 )                 ";
  else if($search_nsfw == 'image')
    $qimages .= " AND       compendium_images.is_nsfw                           =     1                   ";
  else if($search_nsfw == 'gross')
    $qimages .= " AND       compendium_images.is_gross                          =     1                   ";
  else if($search_nsfw == 'offensive')
    $qimages .= " AND       compendium_images.is_offensive                      =     1                   ";
  if($search_used_en)
    $qimages .= " AND       compendium_images.used_in_pages_en                  LIKE  '%$search_used_en%' ";
  if($search_used_fr)
    $qimages .= " AND       compendium_images.used_in_pages_fr                  LIKE  '%$search_used_fr%' ";
  if($search_tags)
    $qimages .= " AND       compendium_images.tags                              LIKE  '%$search_tags%'    ";
  if($search_caption == 'none')
    $qimages .= " AND       compendium_images.caption_en                        =     ''
                  AND       compendium_images.caption_fr                        =     ''                  ";
  else if($search_caption == 'monolingual')
    $qimages .= " AND     ( compendium_images.caption_en                        =     ''
                  AND       compendium_images.caption_fr                        !=    '' )
                  OR      ( compendium_images.caption_en                        !=    ''
                  AND       compendium_images.caption_fr                        =     '' )                ";
  else if($search_caption == 'bilingual')
    $qimages .= " AND       compendium_images.caption_en                        !=    ''
                  AND       compendium_images.caption_fr                        !=    ''                  ";
  else if($search_caption == 'english')
    $qimages .= " AND       compendium_images.caption_en                        !=    ''                  ";
  else if($search_caption == 'french')
    $qimages .= " AND       compendium_images.caption_fr                        !=    ''                  ";
  if($search_deleted == 1)
    $qimages .= " AND       compendium_images.is_deleted                        =     0                   ";
  if($search_deleted == 2)
    $qimages .= " AND       compendium_images.is_deleted                        =     1                   ";

  // Sort the data
  if($sort_by == 'name')
    $qimages .= " ORDER BY    compendium_images.file_name         ASC     ,
                              compendium_images.uploaded_at       DESC    ";
  else if($sort_by == 'nsfw')
    $qimages .= " ORDER BY    compendium_images.is_nsfw           = ''    ,
                              compendium_images.is_gross          = ''    ,
                              compendium_images.is_offensive      = ''    ,
                              compendium_images.uploaded_at       DESC    ";
  else if($sort_by == 'used_en')
    $qimages .= " ORDER BY    compendium_images.used_in_pages_en  != ''   ,
                              compendium_images.used_in_pages_fr  != ''   ,
                              compendium_images.used_in_pages_en  ASC     ,
                              compendium_images.uploaded_at       DESC    ";
  else if($sort_by == 'used_fr')
    $qimages .= " ORDER BY    compendium_images.used_in_pages_fr  != ''   ,
                              compendium_images.used_in_pages_en  != ''   ,
                              compendium_images.used_in_pages_fr  ASC     ,
                              compendium_images.uploaded_at       DESC    ";
  else if($sort_by == 'tags')
    $qimages .= " ORDER BY    compendium_images.tags              ASC     ,
                              compendium_images.uploaded_at       DESC    ";
  else if($sort_by == 'caption')
    $qimages .= " ORDER BY  ( compendium_images.caption_en        != ''
                  AND         compendium_images.caption_fr        != '' ) ,
                              compendium_images.caption_fr        != ''   ,
                              compendium_images.caption_en        != ''   ,
                              compendium_images.uploaded_at       DESC    ";
  else if($sort_by == 'deleted')
    $qimages .= " ORDER BY    compendium_images.is_deleted        DESC    ,
                              compendium_images.uploaded_at       DESC    ";
  else
    $qimages .= " ORDER BY    compendium_images.uploaded_at       DESC    ";

  // Run the query
  $qimages = query($qimages);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qimages); $i++)
  {
    $data[$i]['id']         = sanitize_output($row['ci_id']);
    $data[$i]['deleted']    = ($row['ci_del']) ? 1 : 0;
    $data[$i]['name']       = sanitize_output(string_truncate($row['ci_name'], 22, '...'));
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
    $temp                   = bbcodes(sanitize_output($row['ci_caption'], preserve_line_breaks: true));
    $data[$i]['body']       = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Uploads a new compendium image.
 *
 * @param   array       $file       The image being uploaded.
 * @param   string      $contents   The contents of the image data.
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
  $temp_name  = $file['tmp_name'];

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
  $tags       = isset($contents['tags'])        ? string_change_case($contents['tags'], 'lowercase')  : '';
  $tags       = sanitize($tags, 'string');
  $caption_en = isset($contents['caption_en'])  ? sanitize($contents['caption_en'], 'string')         : '';
  $caption_fr = isset($contents['caption_fr'])  ? sanitize($contents['caption_fr'], 'string')         : '';
  $nsfw       = isset($contents['nsfw'])        ? sanitize($contents['nsfw'], 'int', 0, 1)            : 0;
  $gross      = isset($contents['gross'])       ? sanitize($contents['gross'], 'int', 0, 1)           : 0;
  $offensive  = isset($contents['offensive'])   ? sanitize($contents['offensive'], 'int', 0, 1)       : 0;

  // Upload the image
  if(move_uploaded_file($temp_name, $file_path))
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
  $timestamp        = sanitize(time(), 'int', 0);
  $image_name_raw   = isset($contents['name']) ? $contents['name'] : '';
  $image_name       = sanitize(compendium_format_image_name($contents['name']), 'string');
  $image_tags       = isset($contents['tags'])        ? sanitize($contents['tags'], 'string')         : '';
  $image_caption_en = isset($contents['caption_en'])  ? sanitize($contents['caption_en'], 'string')   : '';
  $image_caption_fr = isset($contents['caption_fr'])  ? sanitize($contents['caption_fr'], 'string')   : '';
  $image_nsfw       = isset($contents['nsfw'])        ? sanitize($contents['nsfw'], 'int', 0, 1)      : 0;
  $image_gross      = isset($contents['gross'])       ? sanitize($contents['gross'], 'int', 0, 1)     : 0;
  $image_offensive  = isset($contents['offensive'])   ? sanitize($contents['offensive'], 'int', 0, 1) : 0;

  // Error: No image name
  if(!$image_name)
    return __('compendium_image_upload_misnamed');

  // Move the image file if necessary
  if($image_name_raw != $image_data['name_raw'])
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
  if($action != 'restore' && $image_data['used_en'] || $image_data['used_fr'])
    return;

  // Soft deletion
  if($action == 'delete')
    query(" UPDATE  compendium_images
            SET     compendium_images.is_deleted  = 1
            WHERE   compendium_images.id          = '$image_id' ");

  // Restoration
  if($action == 'restore')
    query(" UPDATE  compendium_images
            SET     compendium_images.is_deleted  = 0
            WHERE   compendium_images.id          = '$image_id' ");

  // Hard deletion
  if($action == 'hard_delete')
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
 * @param   int   $image_id   The image's id.
 *
 * @return  void
 */

function compendium_images_recalculate_links( int $image_id ) : void
{
  // Sanitize the image's id
  $image_id = sanitize($image_id, 'int', 0);

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

  // Assemble the english page names into an string
  $usage_list_en = '';
  for($i = 0; $dusage = mysqli_fetch_array($qusage); $i++)
  {
    if($i > 0)
      $usage_list_en .= '|||';
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

  // Assemble the french page names into an string
  $usage_list_fr = '';
  for($i = 0; $dusage = mysqli_fetch_array($qusage); $i++)
  {
    if($i > 0)
      $usage_list_fr .= '|||';
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
      $temp = ($shorten) ? string_truncate($page_list_array[$i + 1], 20, '...') : $page_list_array[$i + 1];
      $formatted_page_list .= __link('pages/compendium/'.$page_list_array[$i], sanitize_output($temp)).'<br>';
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
    $temp = ($shorten) ? string_truncate($tags_array[$i], 18, '...') : $tags_array[$i];
    $formatted_tags .= sanitize_output($temp).'<br>';
  }

  // Add the formatted tag list and the tag count to the returned data
  $data['list']   = $formatted_tags;
  $data['count']  = $i;

  // Return the formatted page list
  return $data;
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
 * Returns data related to a compendium page.
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
    $dmissing = mysqli_fetch_array(query("  SELECT  compendium_missing.id       AS 'cm_id'    ,
                                                    compendium_missing.page_url AS 'cm_url'   ,
                                                    compendium_missing.title    AS 'cm_title' ,
                                                    compendium_missing.notes    AS 'cm_notes'
                                            FROM    compendium_missing
                                            WHERE   $where "));

    // Assemble an array with the missing data
    $missing_url_raw  = $dmissing['cm_url'];
    $missing_url      = sanitize($missing_url_raw, 'string');
    $missing_id       = $dmissing['cm_id'];
    $data['title']    = sanitize_output($dmissing['cm_title']);
    $temp             = bbcodes(sanitize_output($dmissing['cm_notes'], preserve_line_breaks: true));
    $data['body']     = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
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

  // Sum up the total missing page calls count and all them to the returned data
  $data['count_pages']      = $count_pages;
  $data['count_images']     = $count_images;
  $data['count_categories'] = $count_categories;
  $data['count_eras']       = $count_eras;
  $data['count']            = $count_pages + $count_images + $count_categories + $count_eras;

  // Return the data
  return $data;
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
  $nsfw     = user_settings_nsfw();
  $privacy  = user_settings_privacy();
  $mode     = user_get_mode();
  $pages    = compendium_pages_list_urls();

  // Sanitize and prepare the data
  $missing        = array();
  $urls           = array();
  $search_url     = isset($search['url'])     ? sanitize($search['url'], 'string')        : '';
  $search_title   = isset($search['title'])   ? sanitize($search['title'], 'string')      : '';
  $search_notes   = isset($search['notes'])   ? sanitize($search['notes'], 'int', -1, 1)  : -1;
  $search_status  = isset($search['status'])  ? sanitize($search['status'], 'int', -1, 1) : -1;

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
    // Look for missing pages in the english definitions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_body_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
    }

    // Look for missing pages in the french definitions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_body_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
    }

    // Look for missing pages in the english summaries
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_summary_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
    }

    // Look for missing pages in the french summaries
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dpages['c_summary_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
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
    // Look for missing pages in the english captions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dimages['ci_caption_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
    }

    // Look for missing pages in the french captions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dimages['ci_caption_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
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
    // Look for missing pages in the english category descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dcategories['cc_body_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
    }

    // Look for missing pages in the french category descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $dcategories['cc_body_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
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
    // Look for missing pages in the english era descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $deras['ce_body_en'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
    }

    // Look for missing pages in the french era descriptions
    preg_match_all('/\[page:(.*?)\|(.*?)\]/', $deras['ce_body_fr'], $links);
    for($i = 0; $i < count($links[1]); $i++)
    {
      $dead_link = compendium_format_url($links[1][$i]);
      if(!in_array($dead_link, $missing) && !in_array($dead_link, $urls))
        array_push($missing, $dead_link);
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
  if($search_title || $search_notes == 1 || $search_status == 1)
    $missing = array();

  // Fetch the missing pages in the database
  $qmissing = "     SELECT    compendium_missing.id       AS 'cm_id'    ,
                              compendium_missing.page_url AS 'cm_url'   ,
                              compendium_missing.title    AS 'cm_title' ,
                              compendium_missing.notes    AS 'cm_notes'
                    FROM      compendium_missing
                    WHERE     1 = 1 ";

  // Search the data
  if($search_url)
    $qmissing .= "  AND       compendium_missing.page_url LIKE  '%$search_url%'   ";
  if($search_title)
    $qmissing .= "  AND       compendium_missing.title    LIKE  '%$search_title%' ";
  if($search_notes == 0)
    $qmissing .= "  AND       compendium_missing.notes    =     ''                ";
  else if($search_notes == 1)
    $qmissing .= "  AND       compendium_missing.notes    !=    ''                ";
  if($search_status == 0)
    $qmissing .= "  AND       0                           =     1                 ";

  // Order the data
  if($sort_by == 'title')
    $qmissing .= "  ORDER BY  compendium_missing.title    = ''  ,
                              compendium_missing.title    ASC   ,
                              compendium_missing.page_url ASC   ";
  else if($sort_by == 'notes')
    $qmissing .= "  ORDER BY  compendium_missing.notes    = ''  ,
                              compendium_missing.page_url ASC   ";
  else
    $qmissing .= "  ORDER BY  compendium_missing.page_url ASC   ";

  // Run the query
  $qmissing = query($qmissing);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmissing); $i++)
  {
    // Format the data
    $data[$i]['id']         = sanitize_output($row['cm_id']);
    $data[$i]['url']        = sanitize_output($row['cm_url']);
    $data[$i]['urldisplay'] = sanitize_output(string_truncate($row['cm_url'], 30, '...'));
    $data[$i]['fullurl']    = (mb_strlen($row['cm_url']) > 30) ? sanitize_output($row['cm_url']) : '';
    $data[$i]['title']      = sanitize_output($row['cm_title']);
    $data[$i]['t_display']  = sanitize_output(string_truncate($row['cm_title'], 25, '...'));
    $data[$i]['t_full']     = (mb_strlen($row['cm_title']) > 25) ? sanitize_output($row['cm_title']) : '';
    $temp                   = bbcodes(sanitize_output($row['cm_notes'], preserve_line_breaks: true));
    $data[$i]['notes']      = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);

    // Remove matching missing pages
    if(in_array($row['cm_url'], $missing))
      array_splice($missing, array_search($row['cm_url'], $missing), 1);
  }

  // Sort the missing pages array (with a little encoding trick for accents)
  $missing = array_map("utf8_decode", $missing);
  sort($missing, SORT_LOCALE_STRING);
  $missing = array_map("utf8_encode", $missing);

  // Prepare the missing pages array for displaying
  foreach($missing as $page_id => $page_name)
    $missing[$page_id] = sanitize_output($page_name);

  // Add the missing pages to the data
  $data['missing'] = $missing;

  // Add the number of rows to the data
  $data['rows'] = $i;

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
  $missing_url    = sanitize(compendium_format_url($missing_url), 'string');
  $missing_id     = sanitize($missing_id, 'int', 0);
  $missing_title  = (isset($contents['title'])) ? sanitize($contents['title'], 'string')  : '';
  $missing_notes  = (isset($contents['notes'])) ? sanitize($contents['notes'], 'string')  : '';

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
            SET         compendium_missing.page_url = '$missing_url'    ,
                        compendium_missing.title    = '$missing_title'  ,
                        compendium_missing.notes    = '$missing_notes'  ");
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
    if($missing_data_url != $missing_url && database_entry_exists('compendium_missing', 'page_url', $missing_url))
      return __('compendium_missing_edit_double');

    // Update the missing pages
    query(" UPDATE  compendium_missing
            SET     compendium_missing.page_url = '$missing_url'    ,
                    compendium_missing.title    = '$missing_title'  ,
                    compendium_missing.notes    = '$missing_notes'
            WHERE   compendium_missing.id       = '$missing_id'     ");
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
  $temp                 = bbcodes(sanitize_output($dtype['ct_body'], preserve_line_breaks: true));
  $data['body']         = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $data['body_en']      = sanitize_output($dtype['ct_body_en']);
  $data['body_fr']      = sanitize_output($dtype['ct_body_fr']);

  // Return the data
  return $data;
}




/**
 * Fetches a list of compendium page types.
 *
 * @return  array   An array containing page types.
 */

function compendium_types_list() : array
{
  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the compendium page types
  $qtypes = query(" SELECT    compendium_types.id               AS 'ct_id'    ,
                              compendium_types.display_order    AS 'ct_order' ,
                              compendium_types.name_$lang       AS 'ct_name'  ,
                              compendium_types.full_name_$lang  AS 'ct_full'  ,
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
    $data[$i]['id']     = sanitize_output($row['ct_id']);
    $data[$i]['order']  = sanitize_output($row['ct_order']);
    $data[$i]['name']   = sanitize_output($row['ct_name']);
    $data[$i]['full']   = sanitize_output($row['ct_full']);
    $data[$i]['count']  = ($row['ct_count']) ? sanitize_output($row['ct_count']) : '-';
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

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
  $order    = sanitize($contents['order'], 'int', 0);
  $name_en  = sanitize($contents['name_en'], 'string');
  $name_fr  = sanitize($contents['name_fr'], 'string');
  $full_en  = sanitize($contents['full_en'], 'string');
  $full_fr  = sanitize($contents['full_fr'], 'string');
  $body_en  = sanitize($contents['body_en'], 'string');
  $body_fr  = sanitize($contents['body_fr'], 'string');

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

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $type_id  = sanitize($type_id, 'int', 0);
  $order    = sanitize($contents['order'], 'int', 0);
  $name_en  = sanitize($contents['name_en'], 'string');
  $name_fr  = sanitize($contents['name_fr'], 'string');
  $full_en  = sanitize($contents['full_en'], 'string');
  $full_fr  = sanitize($contents['full_fr'], 'string');
  $body_en  = sanitize($contents['body_en'], 'string');
  $body_fr  = sanitize($contents['body_fr'], 'string');

  // Error: Page type does not exist
  if(!$type_id || !database_row_exists('compendium_types', $type_id))
    return __('compendium_type_edit_error');

  // Error: No title
  if(!$name_en || !$name_fr || !$full_en || !$full_fr)
    return __('compendium_type_add_no_name');

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

  // Delete the page type
  query(" DELETE FROM compendium_types
          WHERE       compendium_types.id = '$type_id' ");

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
  $temp                 = bbcodes(sanitize_output($dcategory['cc_body'], preserve_line_breaks: true));
  $data['body']         = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $data['body_en']      = sanitize_output($dcategory['cc_body_en']);
  $data['body_fr']      = sanitize_output($dcategory['cc_body_fr']);

  // Return the data
  return $data;
}




/**
 * Fetches a list of compendium categories.
 *
 * @return  array   An array containing categories.
 */

function compendium_categories_list() : array
{
  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the compendium categories
  $qcategories = query("  SELECT    compendium_categories.id            AS 'cc_id'    ,
                                    compendium_categories.display_order AS 'cc_order' ,
                                    compendium_categories.name_$lang    AS 'cc_name'  ,
                                    COUNT(compendium_pages.id)          AS 'cc_count'
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
    $data[$i]['id']     = sanitize_output($row['cc_id']);
    $data[$i]['order']  = sanitize_output($row['cc_order']);
    $data[$i]['name']   = sanitize_output($row['cc_name']);
    $data[$i]['count']  = ($row['cc_count']) ? sanitize_output($row['cc_count']) : '-';
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

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
  $order    = sanitize($contents['order'], 'int', 0);
  $name_en  = sanitize($contents['name_en'], 'string');
  $name_fr  = sanitize($contents['name_fr'], 'string');
  $body_en  = sanitize($contents['body_en'], 'string');
  $body_fr  = sanitize($contents['body_fr'], 'string');

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

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $category_id  = sanitize($category_id, 'int', 0);
  $order        = sanitize($contents['order'], 'int', 0);
  $name_en      = sanitize($contents['name_en'], 'string');
  $name_fr      = sanitize($contents['name_fr'], 'string');
  $body_en      = sanitize($contents['body_en'], 'string');
  $body_fr      = sanitize($contents['body_fr'], 'string');

  // Error: Category does not exist
  if(!$category_id || !database_row_exists('compendium_categories', $category_id))
    return __('compendium_category_edit_error');

  // Error: No title
  if(!$name_en || !$name_fr)
    return __('compendium_category_add_no_name');

  // Edit the compendium category
  query(" UPDATE  compendium_categories
          SET     compendium_categories.display_order   = '$order'    ,
                  compendium_categories.name_en         = '$name_en'  ,
                  compendium_categories.name_fr         = '$name_fr'  ,
                  compendium_categories.description_en  = '$body_en'  ,
                  compendium_categories.description_fr  = '$body_fr'
          WHERE   compendium_categories.id              = '$category_id' ");

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

  // Delete the category
  query(" DELETE FROM compendium_categories
          WHERE       compendium_categories.id = '$category_id' ");

  // Delete any dead links to the category
  query(" DELETE FROM compendium_pages_categories
          WHERE       compendium_pages_categories.fk_compendium_categories = '$category_id' ");

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
  $temp                 = bbcodes(sanitize_output($dera['ce_body'], preserve_line_breaks: true));
  $data['body']         = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
  $data['body_en']      = sanitize_output($dera['ce_body_en']);
  $data['body_fr']      = sanitize_output($dera['ce_body_fr']);

  // Return the data
  return $data;
}




/**
 * Fetches a list of compendium eras.
 *
 * @return  array   An array containing eras.
 */

function compendium_eras_list() : array
{
  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the compendium eras
  $qeras = query("  SELECT    compendium_eras.id                AS 'ce_id'    ,
                              compendium_eras.name_$lang        AS 'ce_name'  ,
                              compendium_eras.short_name_$lang  AS 'ce_short' ,
                              compendium_eras.year_start        AS 'ce_start' ,
                              compendium_eras.year_end          AS 'ce_end'   ,
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
    $data[$i]['id']     = sanitize_output($row['ce_id']);
    $data[$i]['name']   = sanitize_output($row['ce_name']);
    $data[$i]['short']  = sanitize_output($row['ce_short']);
    $data[$i]['start']  = ($row['ce_start']) ? sanitize_output($row['ce_start']) : '-';
    $data[$i]['startx'] = ($row['ce_start']) ? sanitize_output($row['ce_start']) : 'xxxx';
    $data[$i]['end']    = ($row['ce_end']) ? sanitize_output($row['ce_end']) : '-';
    $data[$i]['endx']   = ($row['ce_end']) ? sanitize_output($row['ce_end']) : 'xxxx';
    $data[$i]['count']  = ($row['ce_count']) ? sanitize_output($row['ce_count']) : '-';
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

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
  $start    = sanitize($contents['start'], 'int', 0);
  $end      = sanitize($contents['end'], 'int', 0);
  $name_en  = sanitize($contents['name_en'], 'string');
  $name_fr  = sanitize($contents['name_fr'], 'string');
  $short_en = sanitize($contents['short_en'], 'string');
  $short_fr = sanitize($contents['short_fr'], 'string');
  $body_en  = sanitize($contents['body_en'], 'string');
  $body_fr  = sanitize($contents['body_fr'], 'string');

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

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $era_id   = sanitize($era_id, 'int', 0);
  $start    = sanitize($contents['start'], 'int', 0);
  $end      = sanitize($contents['end'], 'int', 0);
  $name_en  = sanitize($contents['name_en'], 'string');
  $name_fr  = sanitize($contents['name_fr'], 'string');
  $short_en = sanitize($contents['short_en'], 'string');
  $short_fr = sanitize($contents['short_fr'], 'string');
  $body_en  = sanitize($contents['body_en'], 'string');
  $body_fr  = sanitize($contents['body_fr'], 'string');

  // Error: Era does not exist
  if(!$era_id || !database_row_exists('compendium_eras', $era_id))
    return __('compendium_era_edit_error');

  // Error: No title
  if(!$name_en || !$name_fr || !$short_en || !$short_fr)
    return __('compendium_era_add_no_name');

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

  // Delete the era
  query(" DELETE FROM compendium_eras
          WHERE       compendium_eras.id = '$era_id' ");

  // All went well
  return NULL;
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
  $history_body_en  = isset($history_data['body_en']) ? sanitize($history_data['body_en'], 'string')  : '';
  $history_body_fr  = isset($history_data['body_fr']) ? sanitize($history_data['body_fr'], 'string')  : '';
  $history_major    = isset($history_data['major'])   ? sanitize($history_data['major'], 'string')    : 'false';
  $history_major    = ($history_major == 'false')     ? 0                                             : 1;

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
                                                compendium_admin_tools.template_fr  AS 'cn_template_fr'
                                        FROM    compendium_admin_tools
                                        LIMIT   1 "));

  // Assemble an array with the data
  $data['global']       = sanitize_output($dnotes['cn_global']);
  $data['snippets']     = sanitize_output($dnotes['cn_snippets']);
  $data['template_en']  = sanitize_output($dnotes['cn_template_en']);
  $data['template_fr']  = sanitize_output($dnotes['cn_template_fr']);

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
  $notes_global       = isset($notes_data['global'])      ? sanitize($notes_data['global'], 'string')       : '';
  $notes_snippets     = isset($notes_data['snippets'])    ? sanitize($notes_data['snippets'], 'string')     : '';
  $notes_template_en  = isset($notes_data['template_en']) ? sanitize($notes_data['template_en'], 'string')  : '';
  $notes_template_fr  = isset($notes_data['template_fr']) ? sanitize($notes_data['template_fr'], 'string')  : '';

  // Update the admin notes
  query(" UPDATE  compendium_admin_tools
          SET     compendium_admin_tools.global_notes = '$notes_global'       ,
                  compendium_admin_tools.snippets     = '$notes_snippets'     ,
                  compendium_admin_tools.template_en  = '$notes_template_en'  ,
                  compendium_admin_tools.template_fr  = '$notes_template_fr'  ");
}




/**
 * Fetches the years at which compendium pages have been created.
 *
 * @return  array   An array containing years.
 */

function compendium_pages_list_years() : array
{
  // Fetch the compendium page years
  $qyears = query(" SELECT    YEAR(FROM_UNIXTIME(compendium_pages.created_at)) AS 'c_year'
                    FROM      compendium_pages
                    WHERE     compendium_pages.created_at != '0000-00-00'
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
 * @return  array   An array containing years.
 */

function compendium_appearance_list_years() : array
{
  // Fetch the compendium page years
  $qyears = query(" SELECT    compendium_pages.year_appeared AS 'a_year'
                    FROM      compendium_pages
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
 * @return  array   An array containing years.
 */

function compendium_peak_list_years() : array
{
  // Fetch the compendium page years
  $qyears = query(" SELECT    compendium_pages.year_peak AS 'p_year'
                    FROM      compendium_pages
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
 * Formats a compendium page url.
 *
 * @param   string  $url  The compendium page url.
 *
 * @return  string        The formatted page url.
 */

function compendium_format_url( ?string $url ) : string
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
  $url = (mb_substr($url, 0, 6)   == 'admin_')            ? mb_substr($url, 6)  : $url;
  $url = (mb_substr($url, 0, 8)   == 'category')          ? mb_substr($url, 8)  : $url;
  $url = (mb_substr($url, 0, 12)  == 'cultural_era')      ? mb_substr($url, 12) : $url;
  $url = (mb_substr($url, 0, 5)   == 'index')             ? mb_substr($url, 5)  : $url;
  $url = (mb_substr($url, 0, 5)   == 'image')             ? mb_substr($url, 5)  : $url;
  $url = (mb_substr($url, 0, 17)  == 'mission_statement') ? mb_substr($url, 17) : $url;
  $url = (mb_substr($url, 0, 5)   == 'page_')             ? mb_substr($url, 5)  : $url;
  $url = (mb_substr($url, 0, 7)   == 'random_')           ? mb_substr($url, 7)  : $url;

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
  $temp = bbcodes(sanitize_output($text, preserve_line_breaks: true));
  $text = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);

  // Return the formatted string
  return $text;
}