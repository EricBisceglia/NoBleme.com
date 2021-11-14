<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_pages_get                    Returns data related to a compendium page.                               */
/*  compendium_pages_get_random             Returns data related to a random compendium page.                        */
/*  compendium_pages_list                   Fetches a list of compendium pages.                                      */
/*  compendium_pages_list_urls              Fetches a list of all public compendium page urls.                       */
/*                                                                                                                   */
/*  compendium_images_get                   Returns data related to an image used in the compendium.                 */
/*  compendium_images_get_random            Returns data related to a random image used in the compendium.           */
/*  compendium_images_recalculate_links     Recalculates the compendium pages on which an image is being used.       */
/*  compendium_images_assemble_links        Transforms the list of compendium pages on which an image is being used  */
/*                                          into a usable string.                                                    */
/*                                                                                                                   */
/*  compendium_types_get                    Returns data related to a compendium page type.                          */
/*  compendium_types_list                   Fetches a list of compendium page types.                                 */
/*  compendium_types_add                    Creates a new compendium page type.                                      */
/*  compendium_types_edit                   Modifies an existing compendium page type.                               */
/*  compendium_types_delete                 Deletes an existing compendium page type.                                */
/*                                                                                                                   */
/*  compendium_categories_get               Returns data related to a compendium category.                           */
/*  compendium_categories_list              Fetches a list of compendium categories.                                 */
/*  compendium_categories_add               Creates a new compendium category.                                       */
/*  compendium_categories_edit              Modifies an existing compendium category.                                */
/*  compendium_categories_delete            Deletes an existing compendium category.                                 */
/*                                                                                                                   */
/*  compendium_eras_get                     Returns data related to a compendium era.                                */
/*  compendium_eras_list                    Fetches a list of compendium eras.                                       */
/*  compendium_eras_add                     Creates a new compendium era.                                            */
/*  compendium_eras_edit                    Modifies an existing compendium era.                                     */
/*  compendium_eras_delete                  Deletes an existing compendium era.                                      */
/*                                                                                                                   */
/*  compendium_page_history_get             Returns data related to an entry in a compendium page's history.         */
/*  compendium_page_history_list            Returns data related to a compendium page's history entry.               */
/*  compendium_page_history_edit            Modifies an existing compendium page's history entry.                    */
/*  compendium_page_history_delete          Hard deletes an existing compendium page's history entry.                */
/*                                                                                                                   */
/*  compendium_admin_notes_get              Fetches the admin notes.                                                 */
/*  compendium_admin_notes_edit             Modifies the admin notes.                                                */
/*                                                                                                                   */
/*  compendium_pages_list_years             Fetches the years at which compendium pages have been created.           */
/*  compendium_appearance_list_years        Fetches the years at which compendium content has appeared.              */
/*  compendium_peak_list_years              Fetches the years at which compendium content has peaked.                */
/*                                                                                                                   */
/*  compendium_nbcodes_apply                Applies NBCodes to a string.                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns data related to a compendium page.
 *
 * @param   int         $page_id  (OPTIONAL)  The page's id. Only one of these two parameters should be set.
 * @param   string      $page_url (OPTIONAL)  The page's url. Only one of these two parameters should be set.
 *
 * @return  array|null                        An array containing page related data, or NULL if it does not exist.
 */

function compendium_pages_get(  int     $page_id  = 0   ,
                                string  $page_url = ''  ) : mixed
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
  $dpage = mysqli_fetch_array(query(" SELECT    compendium_pages.id                 AS 'p_id'         ,
                                                compendium_pages.is_deleted         AS 'p_deleted'    ,
                                                compendium_pages.is_draft           AS 'p_draft'      ,
                                                compendium_pages.created_at         AS 'p_created'    ,
                                                compendium_pages.title_$lang        AS 'p_title'      ,
                                                compendium_pages.title_en           AS 'p_title_en'   ,
                                                compendium_pages.title_fr           AS 'p_title_fr'   ,
                                                compendium_pages.redirection_$lang  AS 'p_redirect'   ,
                                                compendium_pages.year_appeared      AS 'p_new_year'   ,
                                                compendium_pages.month_appeared     AS 'p_new_month'  ,
                                                compendium_pages.year_peak          AS 'p_peak_year'  ,
                                                compendium_pages.month_peak         AS 'p_peak_month' ,
                                                compendium_pages.is_nsfw            AS 'p_nsfw'       ,
                                                compendium_pages.is_gross           AS 'p_gross'      ,
                                                compendium_pages.is_offensive       AS 'p_offensive'  ,
                                                compendium_pages.summary_$lang      AS 'p_summary'    ,
                                                compendium_pages.definition_$lang   AS 'p_body'       ,
                                                compendium_eras.id                  AS 'pe_id'        ,
                                                compendium_eras.name_$lang          AS 'pe_name'      ,
                                                compendium_types.id                 AS 'pt_id'        ,
                                                compendium_types.name_$lang         AS 'pt_name'      ,
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
  $data['no_page']    = ($dpage['p_title']) ? 0 : 1;
  $temp               = (strlen($dpage['p_title']) > 25) ? 'h2' : 'h1';
  $temp               = (strlen($dpage['p_title']) > 30) ? 'h3' : $temp;
  $temp               = (strlen($dpage['p_title']) > 40) ? 'h4' : $temp;
  $data['title_size'] = (strlen($dpage['p_title']) > 50) ? 'h5' : $temp;
  $data['title']      = sanitize_output($dpage['p_title']);
  $data['title_en']   = sanitize_output($dpage['p_title_en']);
  $data['title_fr']   = sanitize_output($dpage['p_title_fr']);
  $temp               = ($dpage['p_new_month']) ? __('month_'.$dpage['p_new_month'], spaces_after: 1) : '';
  $data['appeared']   = ($dpage['p_new_year']) ? $temp.$dpage['p_new_year'] : '';
  $temp               = ($dpage['p_peak_month']) ? __('month_'.$dpage['p_peak_month'], spaces_after: 1) : '';
  $data['peak']       = ($dpage['p_peak_year']) ? $temp.$dpage['p_peak_year'] : '';
  $data['nsfw']       = $dpage['p_nsfw'];
  $data['offensive']  = $dpage['p_offensive'];
  $data['gross']      = $dpage['p_gross'];
  $data['meta']       = sanitize_output(string_truncate($dpage['p_summary'], 140, '...'));
  $data['summary']    = sanitize_output($dpage['p_summary']);
  $temp               = bbcodes(sanitize_output($dpage['p_body'], preserve_line_breaks: true));
  $data['body']       = nbcodes($temp, page_list: $pages, privacy_level: $privacy, nsfw_settings: $nsfw, mode: $mode);
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
  if($dpage['p_redirect'])
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
  $qpages = "     SELECT    compendium_pages.is_deleted         AS 'p_deleted'    ,
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
    $qpages .= "  ORDER BY    compendium_pages.is_deleted           = 0                 ,
                              compendium_pages.is_draft             = 0                 ,
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
    $temp                   = ($row['p_peak_month']) ? __('month_'.$row['p_peak_month'], spaces_after: 1) : '';
    $data[$i]['peak']       = ($row['p_peak_year']) ? $temp.$row['p_peak_year'] : '';
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
 * Returns data related to an image used in the compendium.
 *
 * @param   int         $image_id   (OPTIONAL)  The image's id. Only one of these two parameters should be set.
 * @param   string      $file_name  (OPTIONAL)  The image file's name  Only one of these two parameters should be set.
 *
 *
 * @return  array|null              An array containing page image data, or NULL if it does not exist.
 */

function compendium_images_get( int     $image_id   = 0 ,
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
  $dimage = mysqli_fetch_array(query("  SELECT  compendium_images.id                  AS 'ci_id'        ,
                                                compendium_images.is_deleted          AS 'ci_deleted'   ,
                                                compendium_images.file_name           AS 'ci_filename'  ,
                                                compendium_images.is_nsfw             AS 'ci_nsfw'      ,
                                                compendium_images.is_gross            AS 'ci_gross'     ,
                                                compendium_images.is_offensive        AS 'ci_offensive' ,
                                                compendium_images.used_in_pages_$lang AS 'ci_used'      ,
                                                compendium_images.caption_$lang       AS 'ci_body'
                                        FROM    compendium_images
                                        WHERE   compendium_images.id = '$image_id' "));

  // Return null if the image should not be displayed
  if(!$is_admin && $dimage['ci_deleted'])
    return NULL;

  // Assemble an array with the data
  $data['id']         = sanitize_output($dimage['ci_id']);
  $data['deleted']    = sanitize_output($dimage['ci_deleted']);
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

  // Get the user's current language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

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
 * Transforms the list of compendium pages on which an image is being used into a usable string.
 *
 * @param   string  $page_list  A list of compendium pages.
 *
 * @return  array               The formatted list and the page count.
 */

function compendium_images_assemble_links( string $page_list ) : array
{
  // Split the page list
  $page_list_array = explode("|||", $page_list);

  // Format the page list
  $formatted_page_list = '';
  for($i = 0; $i < count($page_list_array); $i++)
  {
    if(!($i % 2) && isset($page_list_array[$i + 1]))
      $formatted_page_list .= __link('pages/compendium/'.$page_list_array[$i], $page_list_array[$i + 1]).'<br>';
  }

  // Add the formatted page list and the page count to the returned data
  $data['list']   = $formatted_page_list;
  $data['count']  = ($i) ? floor($i / 2) : 0;

  // Return the formatted page list
  return $data;
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
    $data[$i]['end']    = ($row['ce_end']) ? sanitize_output($row['ce_end']) : '-';
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
 * Applies NBCodes to a string.
 *
 * @param   string  $text   A string with NBCodes in it.
 *
 * @return  string          The formatted string.
 */

function compendium_nbcodes_apply( ?string $text ) : string
{
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