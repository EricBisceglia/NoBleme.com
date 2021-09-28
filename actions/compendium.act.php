<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  compendium_pages_list         Fetches a list of compendium pages.                                                */
/*                                                                                                                   */
/*  compendium_page_type_get      Returns data related to a compendium page type.                                    */
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

  // Get the user's current language and access rights
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = ($user_view) ? 0 : user_is_administrator();

  // Sanitize the search parameters
  $search_type      = isset($search['type'])      ? sanitize($search['type'], 'string')           : '';
  $search_nsfw      = isset($search['nsfw'])      ? sanitize($search['nsfw'], 'int', -1, 1)       : -1;
  $search_gross     = isset($search['gross'])     ? sanitize($search['gross'], 'int', -1, 1)      : -1;
  $search_offensive = isset($search['offensive']) ? sanitize($search['offensive'], 'int', -1, 1)  : -1;

  // Fetch the pages
  $qpages = "     SELECT    compendium_pages.created_at     AS 'p_created'  ,
                            compendium_pages.last_edited_at AS 'p_edited'   ,
                            compendium_pages.page_type      AS 'p_type'     ,
                            compendium_pages.page_url       AS 'p_url'      ,
                            compendium_pages.title_$lang    AS 'p_title'    ,
                            compendium_pages.summary_$lang  AS 'p_summary'
                  FROM      compendium_pages
                  WHERE     1 = 1 ";

  // Do not show deleted pages or drafts to regular users
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.is_deleted   = 0
                  AND       compendium_pages.is_draft     = 0 ";

  // Regular users should only see tasks with a title matching their current language
  if(!$is_admin)
    $qpages .= "  AND       compendium_pages.title_$lang  != '' ";

  // Search the data
  if($search_type)
    $qpages .= "  AND       compendium_pages.page_type    LIKE '%$search_type%'     ";
  if($search_nsfw > -1)
    $qpages .= "  AND       compendium_pages.is_nsfw      =    '$search_nsfw'       ";
  if($search_gross > -1)
    $qpages .= "  AND       compendium_pages.is_gross     =    '$search_gross'      ";
  if($search_offensive > -1)
    $qpages .= "  AND       compendium_pages.is_offensive =    '$search_offensive'  ";

  // Sort the data
  if($sort_by == 'name')
    $qpages .= "  ORDER BY    compendium_pages.title_$lang      ASC     ";
  else
    $qpages .= "  ORDER BY
                  GREATEST  ( compendium_pages.created_at               ,
                              compendium_pages.last_edited_at ) DESC    ,
                              compendium_pages.title_$lang      ASC     ";

  // Limit the amount of pages returned
  if($limit)
    $qpages .= "  LIMIT $limit ";

  // Run the query
  $qpages = query($qpages);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qpages); $i++)
  {
    $temp                 = compendium_page_type_get($row['p_type']);
    $data[$i]['created']  = ($row['p_created']) ? sanitize_output(time_since($row['p_created'])) : '';
    $data[$i]['edited']   = ($row['p_edited']) ? sanitize_output(time_since($row['p_edited'])) : '';
    $data[$i]['type']     = ($temp) ? sanitize_output($temp['name_'.$lang]) : '';
    $data[$i]['type_url'] = ($temp) ? sanitize_output($temp['url']) : '';
    $data[$i]['url']      = sanitize_output($row['p_url']);
    $data[$i]['title']    = sanitize_output($row['p_title']);
    $data[$i]['summary']  = nbcodes(bbcodes(sanitize_output($row['p_summary'], preserve_line_breaks: true)));
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