<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/**
 * Fetches all page titles of the encyclopedia of internet culture in a specific language.
 *
 * @param   string|null $lang (OPTIONAL)  The language of the page titles, default to current user's language.
 *
 * @return  array                         All of the page titles in the requested language.
 */

function internet_list_pages($lang = NULL)
{
  // Fetch the user's language if required
  $lang = (!$lang) ? user_get_language() : $lang;

  // Prepare the language for use in a query by turning it lowercase and sanitizing it
  $lang = sanitize(string_change_case($lang, 'lowercase'), 'string');

  // Fetch the list of all page titles in the requested language
  $qpages = query(" SELECT  internet_pages.title_$lang AS 'w_title'
                    FROM    internet_pages
                    WHERE   internet_pages.title_$lang != '' ");

  // Push all those pages in an array
  $page_list = array();
  while($dpages = mysqli_fetch_array($qpages))
    array_push($page_list, string_change_case($dpages['w_title'], 'lowercase'));

  // Return the array of page titles
  return $page_list;
}