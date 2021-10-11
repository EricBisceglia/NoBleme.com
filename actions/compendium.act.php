<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_pages_get                Returns data related to a compendium page.                                   */
/*  compendium_pages_get_random         Returns data related to a random compendium page.                            */
/*  compendium_pages_list               Fetches a list of compendium pages.                                          */
/*  compendium_pages_list_urls          Fetches a list of all public compendium page urls.                           */
/*                                                                                                                   */
/*  compendium_page_type_get            Returns data related to a compendium page type.                              */
/*                                                                                                                   */
/*  compendium_eras_list                Fetches a list of compendium eras.                                           */
/*                                                                                                                   */
/*  compendium_page_history_list        Returns data related to a compendium page's history.                         */
/*                                                                                                                   */
/*  compendium_pages_list_years         Fetches the years at which compendium pages have been created.               */
/*  compendium_appearance_list_years    Fetches the years at which compendium content has appeared.                  */
/*  compendium_peak_list_years          Fetches the years at which compendium content has peaked.                    */
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
                                                compendium_pages.page_type          AS 'p_type'       ,
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
                                                compendium_eras.name_$lang          AS 'pe_name'
                                      FROM      compendium_pages
                                      LEFT JOIN compendium_eras
                                      ON        compendium_pages.fk_compendium_eras = compendium_eras.id
                                      WHERE     $where "));

  // Return null if the task should not be displayed
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
  $page_type          = compendium_page_type_get($dpage['p_type']);
  $data['type']       = sanitize_output(string_change_case($page_type['name_'.$lang], 'initials'));
  $data['type_raw']   = sanitize_output($dpage['p_type']);
  $data['type_url']   = sanitize_output($page_type['url']);
  $data['type_other'] = sanitize_output($page_type['other_'.$lang]);
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
  $data['updated']  = ($temp) ? sanitize_output(time_since($temp)) : __('error');

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

    // Return null if the redirection does not exist
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

  // Return the data
  return $data;
}




/**
 * Returns data related to a random compendium page.
 *
 * @param   string  $type   (OPTIONAL)  Request a specific page type for the randomly returned page.
 *
 * @return  string                      The url of a randomly chosen compendium page.
 */

function compendium_pages_get_random( string $type = '' ) : string
{
  // Sanitize the page type
  $type = sanitize($type, 'string');

  // Prepare the page type condition
  $type = ($type) ? " AND compendium_pages.page_type LIKE '$type' " : '';

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
                                      $type
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

  // Get the user's current language, access rights, and nsfw settings
  $lang           = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin       = ($user_view) ? 0 : user_is_administrator();
  $nsfw_settings  = user_settings_nsfw();

  // Sanitize the search parameters
  $search_type      = isset($search['type'])      ? sanitize($search['type'], 'string')                 : '';
  $search_title     = isset($search['title'])     ? sanitize($search['title'], 'string')                : '';
  $search_nsfw      = isset($search['nsfw'])      ? sanitize($search['nsfw'], 'int', -1, 1)             : -1;
  $search_gross     = isset($search['gross'])     ? sanitize($search['gross'], 'int', -1, 1)            : -1;
  $search_offensive = isset($search['offensive']) ? sanitize($search['offensive'], 'int', -1, 1)        : -1;
  $search_era       = isset($search['era'])       ? sanitize($search['era'], 'int', 0)                  : 0;
  $search_appeared  = isset($search['appeared'])  ? sanitize($search['appeared'], 'int', 0, date('Y'))  : 0;
  $search_peaked    = isset($search['peaked'])    ? sanitize($search['peaked'], 'int', 0, date('Y'))    : 0;
  $search_created   = isset($search['created'])   ? sanitize($search['created'], 'int', 0, date('Y'))   : 0;

  // Fetch the pages
  $qpages = "     SELECT    compendium_pages.created_at       AS 'p_created'    ,
                            compendium_pages.last_edited_at   AS 'p_edited'     ,
                            compendium_pages.page_type        AS 'p_type'       ,
                            compendium_pages.page_url         AS 'p_url'        ,
                            compendium_pages.title_$lang      AS 'p_title'      ,
                            compendium_pages.year_appeared    AS 'p_app_year'   ,
                            compendium_pages.month_appeared   AS 'p_app_month'  ,
                            compendium_pages.year_peak        AS 'p_peak_year'  ,
                            compendium_pages.month_peak       AS 'p_peak_month' ,
                            compendium_pages.title_is_nsfw    AS 'p_nsfw_title' ,
                            compendium_pages.summary_$lang    AS 'p_summary'    ,
                            compendium_eras.id                AS 'pe_id'        ,
                            compendium_eras.short_name_$lang  AS 'pe_name'
                  FROM      compendium_pages
                  LEFT JOIN compendium_eras ON compendium_pages.fk_compendium_eras = compendium_eras.id
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
  if($search_type)
    $qpages .= "  AND       compendium_pages.page_type                        LIKE  '%$search_type%'    ";
  if($search_title)
    $qpages .= "  AND       compendium_pages.title_$lang                      LIKE  '%$search_title%'   ";
  if($search_nsfw > -1)
    $qpages .= "  AND       compendium_pages.is_nsfw                          =     '$search_nsfw'      ";
  if($search_gross > -1)
    $qpages .= "  AND       compendium_pages.is_gross                         =     '$search_gross'     ";
  if($search_offensive > -1)
    $qpages .= "  AND       compendium_pages.is_offensive                     =     '$search_offensive' ";
  if($search_era)
    $qpages .= "  AND       compendium_pages.fk_compendium_eras               =     '$search_era'       ";
  if($search_appeared)
    $qpages .= "  AND       compendium_pages.year_appeared                    =     '$search_appeared'  ";
  if($search_peaked)
    $qpages .= "  AND       compendium_pages.year_peak                        =     '$search_peaked'    ";
  if($search_created)
    $qpages .= "  AND       YEAR(FROM_UNIXTIME(compendium_pages.created_at))  =     '$search_created'   ";

  // Sort the data
  if($sort_by == 'title')
    $qpages .= "  ORDER BY    compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'theme')
    $qpages .= "  ORDER BY    compendium_pages.page_type        != 'meme'           ,
                              compendium_pages.page_type        != 'definition'     ,
                              compendium_pages.page_type        != 'sociocultural'  ,
                              compendium_pages.page_type        ASC                 ,
                              compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'era')
    $qpages .= "  ORDER BY    compendium_eras.id                IS NULL             ,
                              compendium_eras.year_start        DESC                ,
                              compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'appeared')
    $qpages .= "  ORDER BY    compendium_pages.year_appeared    DESC                ,
                              compendium_pages.month_appeared   DESC                ,
                              compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'appeared_desc')
    $qpages .= "  ORDER BY    compendium_pages.year_appeared    = 0                 ,
                              compendium_pages.year_appeared    ASC                 ,
                              compendium_pages.month_appeared   ASC                 ,
                              compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'peak')
    $qpages .= "  ORDER BY    compendium_pages.year_peak        DESC                ,
                              compendium_pages.month_peak       DESC                ,
                              compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'peak_desc')
    $qpages .= "  ORDER BY    compendium_pages.year_peak        = 0                 ,
                              compendium_pages.year_peak        ASC                 ,
                              compendium_pages.month_peak       ASC                 ,
                              compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'created')
    $qpages .= "  ORDER BY    compendium_pages.created_at       DESC                ,
                              compendium_pages.title_$lang      ASC                 ";
  else
    $qpages .= "  ORDER BY
                  GREATEST  ( compendium_pages.created_at                           ,
                              compendium_pages.last_edited_at ) DESC                ,
                              compendium_pages.title_$lang      ASC                 ";

  // Limit the amount of pages returned
  if($limit)
    $qpages .= "  LIMIT $limit ";

  // Run the query
  $qpages = query($qpages);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qpages); $i++)
  {
    $temp                   = compendium_page_type_get($row['p_type']);
    $data[$i]['created']    = ($row['p_created']) ? sanitize_output(time_since($row['p_created'])) : '';
    $data[$i]['edited']     = ($row['p_edited']) ? sanitize_output(time_since($row['p_edited'])) : '';
    $data[$i]['type']       = ($temp) ? sanitize_output($temp['name_'.$lang]) : '';
    $data[$i]['type_url']   = ($temp) ? sanitize_output($temp['url']) : '';
    $data[$i]['url']        = sanitize_output($row['p_url']);
    $data[$i]['title']      = sanitize_output($row['p_title']);
    $data[$i]['shorttitle'] = sanitize_output(string_truncate($row['p_title'], 32, '...'));
    $data[$i]['fulltitle']  = (mb_strlen($row['p_title']) >= 32) ? sanitize_output($row['p_title']) : '';
    $temp                   = ($row['p_app_month']) ? __('month_'.$row['p_app_month'], spaces_after: 1) : '';
    $data[$i]['appeared']   = ($row['p_app_year']) ? $temp.$row['p_app_year'] : '';
    $temp                   = ($row['p_peak_month']) ? __('month_'.$row['p_peak_month'], spaces_after: 1) : '';
    $data[$i]['peak']       = ($row['p_peak_year']) ? $temp.$row['p_peak_year'] : '';
    $data[$i]['blur']       = ($row['p_nsfw_title'] && $nsfw_settings < 2) ? ' blur' : '';
    $data[$i]['summary']    = nbcodes(bbcodes(sanitize_output($row['p_summary'], preserve_line_breaks: true)));
    $data[$i]['era_id']     = sanitize_output($row['pe_id']);
    $data[$i]['era']        = sanitize_output($row['pe_name']);
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
 * Returns data related to a compendium page type.
 *
 * @param   string      $page_type  The requested page type.
 *
 * @return  array|null              An array containing the data, or null if the page type doesn't exist.
 */

function compendium_page_type_get( string $page_type = '' ) : mixed
{
  // Page type: meme
  if($page_type == 'meme')
    return array( 'name_en'   => "meme"   ,
                  'name_fr'   => "meme"   ,
                  'url'       => "memes"  ,
                  'other_en'  => "meme"   ,
                  'other_fr'  => "meme"   );

  // Page type: definition
  else if($page_type == 'definition')
    return array( 'name_en'   => "definition" ,
                  'name_fr'   => "définition" ,
                  'url'       => "slang"      ,
                  'other_en'  => "definition" ,
                  'other_fr'  => "definition" );

  // Page type: sociocultural
  else if($page_type == 'sociocultural')
    return array( 'name_en'   => "sociocultural"          ,
                  'name_fr'   => "socioculturel"          ,
                  'url'       => "sociocultural"          ,
                  'other_en'  => "sociocultural entry"    ,
                  'other_fr'  => "contenu socioculturel"  );

  // Page type: drama
  else if($page_type == 'drama')
    return array( 'name_en'   => "drama"  ,
                  'name_fr'   => "drame"  ,
                  'url'       => "dramas" ,
                  'other_en'  => "drama"  ,
                  'other_fr'  => "drame"  );

  // Page type: history
  else if($page_type == 'history')
    return array( 'name_en'   => "history"            ,
                  'name_fr'   => "histoire"           ,
                  'url'       => "historical"         ,
                  'other_en'  => "historical entry"   ,
                  'other_fr'  => "contenu historique" );

  // Page type no found
  return null;
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
                              compendium_eras.short_name_$lang  AS 'ce_short'
                    FROM      compendium_eras
                    ORDER BY  compendium_eras.year_start ASC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qeras); $i++)
  {
    $data[$i]['id']     = sanitize_output($row['ce_id']);
    $data[$i]['short']  = sanitize_output($row['ce_short']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns data related to a compendium page's history.
 *
 * @param   int         $page_id  The page's id
 *
 * @return  array|null            An array containing the data, or null if the page type doesn't exist.
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
    $data[$i]['id']     = sanitize_output($row['ph_id']);
    $data[$i]['date']   = sanitize_output(time_since($row['ph_date']));
    $data[$i]['major']  = $row['ph_major'];
    $data[$i]['body']   = sanitize_output($row['ph_body']);
  }

  // Fetch the page's creation date
  $dpage = mysqli_fetch_array(query(" SELECT  compendium_pages.created_at AS 'p_created'
                                      FROM    compendium_pages
                                      WHERE   compendium_pages.id = '$page_id' "));

  // Add the page creation info to the data
  $data[$i]['id']     = 0;
  $data[$i]['date']   = sanitize_output(time_since($dpage['p_created']));
  $data[$i]['major']  = 1;
  $data[$i]['body']   = '';
  $data[$i]['edit']   = 1;

  // Add the number of rows to the data
  $data['rows'] = $i + 1;

  // Return the prepared data
  return $data;
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