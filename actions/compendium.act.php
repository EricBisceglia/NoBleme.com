<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_pages_list               Fetches a list of compendium pages.                                          */
/*                                                                                                                   */
/*  compendium_page_type_get            Returns data related to a compendium page type.                              */
/*                                                                                                                   */
/*  compendium_pages_list_years         Fetches the years at which compendium pages have been created.               */
/*  compendium_appearance_list_years    Fetches the years at which compendium content has appeared.                  */
/*  compendium_peak_list_years          Fetches the years at which compendium content has peaked.                    */
/*                                                                                                                   */
/*********************************************************************************************************************/


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
  $search_appeared  = isset($search['appeared'])  ? sanitize($search['appeared'], 'int', 0, date('Y'))  : 0;
  $search_peaked    = isset($search['peaked'])    ? sanitize($search['peaked'], 'int', 0, date('Y'))    : 0;
  $search_created   = isset($search['created'])   ? sanitize($search['created'], 'int', 0, date('Y'))   : 0;

  // Fetch the pages
  $qpages = "     SELECT    compendium_pages.created_at     AS 'p_created'    ,
                            compendium_pages.last_edited_at AS 'p_edited'     ,
                            compendium_pages.page_type      AS 'p_type'       ,
                            compendium_pages.page_url       AS 'p_url'        ,
                            compendium_pages.title_$lang    AS 'p_title'      ,
                            compendium_pages.year_appeared  AS 'p_app_year'   ,
                            compendium_pages.month_appeared AS 'p_app_month'  ,
                            compendium_pages.year_peak      AS 'p_peak_year'  ,
                            compendium_pages.month_peak     AS 'p_peak_month' ,
                            compendium_pages.is_nsfw        AS 'p_nsfw'       ,
                            compendium_pages.is_gross       AS 'p_gross'      ,
                            compendium_pages.is_offensive   AS 'p_offensive'  ,
                            compendium_pages.summary_$lang  AS 'p_summary'
                  FROM      compendium_pages
                  WHERE     1 = 1 ";

  // Do not show deleted pages or drafts to regular users
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.is_deleted = 0
                  AND       compendium_pages.is_draft   = 0 ";

  // Do not show redirections so regular users
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.redirection_$lang = '' ";

  // Regular users should only see tasks with a title matching their current language
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.title_$lang != '' ";

  // Search the data
  if($search_type)
    $qpages .= "  AND       compendium_pages.page_type                        LIKE '%$search_type%'     ";
  if($search_title)
    $qpages .= "  AND       compendium_pages.title_$lang                      LIKE '%$search_title%'    ";
  if($search_nsfw > -1)
    $qpages .= "  AND       compendium_pages.is_nsfw                          =    '$search_nsfw'       ";
  if($search_gross > -1)
    $qpages .= "  AND       compendium_pages.is_gross                         =    '$search_gross'      ";
  if($search_offensive > -1)
    $qpages .= "  AND       compendium_pages.is_offensive                     =    '$search_offensive'  ";
  if($search_appeared)
    $qpages .= "  AND       compendium_pages.year_appeared                    =    '$search_appeared'   ";
  if($search_peaked)
    $qpages .= "  AND       compendium_pages.year_peak                        =    '$search_peaked'     ";
  if($search_created)
    $qpages .= "  AND       YEAR(FROM_UNIXTIME(compendium_pages.created_at))  =   '$search_created'     ";

  // Sort the data
  if($sort_by == 'title')
    $qpages .= "  ORDER BY    compendium_pages.title_$lang      ASC                 ";
  else if($sort_by == 'theme')
    $qpages .= "  ORDER BY    compendium_pages.page_type        != 'meme'           ,
                              compendium_pages.page_type        != 'definition'     ,
                              compendium_pages.page_type        != 'sociocultural'  ,
                              compendium_pages.page_type        ASC                 ,
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
    $temp                   = ($row['p_nsfw'] || $row['p_gross']);
    $data[$i]['blur']       = ($temp && $nsfw_settings < 2) ? ' blur' : '';
    $data[$i]['summary']    = nbcodes(bbcodes(sanitize_output($row['p_summary'], preserve_line_breaks: true)));
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
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
    return array( 'name_en' => "meme"   ,
                  'name_fr' => "meme"   ,
                  'url'     => "memes"  );

  // Page type: definition
  else if($page_type == 'definition')
    return array( 'name_en' => "definition" ,
                  'name_fr' => "définition" ,
                  'url'     => "slang"      );

  // Page type: sociocultural
  else if($page_type == 'sociocultural')
    return array( 'name_en' => "sociocultural" ,
                  'name_fr' => "socioculturel" ,
                  'url'     => "sociocultural"  );

  // Page type: drama
  else if($page_type == 'drama')
    return array( 'name_en' => "drama"  ,
                  'name_fr' => "drame"  ,
                  'url'     => "dramas" );

  // Page type: history
  else if($page_type == 'history')
    return array( 'name_en' => "history"    ,
                  'name_fr' => "histoire"   ,
                  'url'     => "historical" );

  // Page type no found
  return null;
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