<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_list                   Returns a list of quotes.                                                          */
/*  quotes_get_random_id          Returns a random quote ID.                                                         */
/*                                                                                                                   */
/*  user_setting_quotes           Quote related settings of the current user.                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns a list of quotes.
 *
 * @param   array   $search     (OPTIONAL)  Search for specific field values.
 * @param   int     $quote_id   (OPTIONAL)  Return only a single quote instead of a list.
 *
 * @return  array   An array containing quotes.
 */

function quotes_list( ?array  $search   = array() ,
                      ?int    $quote_id = 0       ) : array
{
  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Sanitize the parameters
  $quote_id = sanitize($quote_id, 'int', 0);

  // Prepare the language filter
  $lang_en    = (isset($search['lang_en']) && $search['lang_en']);
  $lang_fr    = (isset($search['lang_fr']) && $search['lang_fr']);

  // Fetch the quotes
  $qquotes = "    SELECT    quotes.id                                                               AS 'q_id'     ,
                            quotes.submitted_at                                                     AS 'q_date'   ,
                            GROUP_CONCAT(linked_users.id ORDER BY linked_users.username ASC)        AS 'lu_id'    ,
                            GROUP_CONCAT(linked_users.username ORDER BY linked_users.username ASC)  AS 'lu_nick'  ,
                            quotes.is_nsfw                                                          AS 'q_nsfw'   ,
                            quotes.body                                                             AS 'q_body'
                  FROM      quotes
                  LEFT JOIN quotes_users                  ON quotes.id              = quotes_users.fk_quotes
                  LEFT JOIN users         AS linked_users ON quotes_users.fk_users  = linked_users.id
                  WHERE     quotes.is_deleted       = 0
                  AND       quotes.admin_validation = 1 ";

  // Show a single quote
  if($quote_id)
    $qquotes .= " AND       quotes.id               = '$quote_id' ";

  // Filter the quotes by language
  if($lang_en && !$lang_fr && !$quote_id)
    $qquotes .= " AND       quotes.language      LIKE 'EN'        ";
  if($lang_fr && !$lang_en && !$quote_id)
    $qquotes .= " AND       quotes.language      LIKE 'FR'        ";
  if(!$lang_fr && !$lang_en && !$quote_id)
    $qquotes .= " AND       1                       = 0           ";

  // Finish the query
  $qquotes .= "   GROUP BY  quotes.id
                  ORDER BY  quotes.submitted_at DESC  ,
                            quotes.id           DESC  ";

  // Run the query
  $dquotes = query($qquotes);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($dquotes); $i++)
  {
    $data[$i]['id']           = $row['q_id'];
    $temp                     = ($row['q_date']) ? date_to_text($row['q_date'], strip_day: 1) : __('quotes_nodate');
    $data[$i]['date']         = sanitize_output($temp);
    $data[$i]['linked_ids']   = ($row['lu_id']) ? explode(',', $row['lu_id']) : '';
    $data[$i]['linked_nicks'] = ($row['lu_nick']) ? explode(',', $row['lu_nick']) : '';
    $temp                     = (is_array($data[$i]['linked_ids'])) ? count($data[$i]['linked_ids']) : 0;
    $data[$i]['linked_count'] = ($temp && $temp == count($data[$i]['linked_nicks'])) ? $temp : 0;
    $data[$i]['nsfw']         = $row['q_nsfw'];
    $data[$i]['body']         = sanitize_output($row['q_body'], true);
    $data[$i]['summary']      = sanitize_output(string_truncate($row['q_body'], 80, '...'));
  }

  // Add the language filters to the data
  $data['lang_en']  = $lang_en;
  $data['lang_fr']  = $lang_fr;

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns a random quote ID.
 *
 * @return  int   A random quote's ID, in the user's allowed languages.
 */

function quotes_get_random_id() : int
{
  // Fetch the user's quotes related language settings
  $settings = user_settings_quotes();

  // Assemble the language settings into an extra query condition
  if($settings['show_en'] && !$settings['show_fr'])
    $limit_lang = " AND quotes.language LIKE 'EN' ";
  else if($settings['show_fr'] && !$settings['show_en'])
    $limit_lang = " AND quotes.language LIKE 'FR' ";
  else
    $limit_lang = '';

  // Fetch a random quote
  $drand = mysqli_fetch_array(query(" SELECT    quotes.id AS 'q_id'
                                      FROM      quotes
                                      WHERE     quotes.is_deleted       = 0
                                      AND       quotes.admin_validation = 1
                                                $limit_lang
                                      ORDER BY  RAND()
                                      LIMIT     1 "));

  // Return the random quote's id
  return $drand['q_id'];
}




/**
 * Quote related settings of the current user.
 *
 * @return  array   The current quote related settings of the user, in the form of an array.
 */

function user_settings_quotes() : array
{
  // By default, give the settings default values
  $lang_en = 0;
  $lang_fr = 0;

  // If the user is logged in, fetch their quotes related settings
  if(user_is_logged_in())
  {
    // Sanitize the user id
    $user_id = sanitize($_SESSION['user_id'], 'int', 0);

    // Fetch the settings
    $dprivacy = mysqli_fetch_array(query("  SELECT  users_settings.quotes_languages AS 'sq_lang'
                                            FROM    users_settings
                                            WHERE   users_settings.fk_users = '$user_id' "));

    // Set the values to the current user settings
    $lang_en = (str_contains($dprivacy['sq_lang'], 'EN'));
    $lang_fr = (str_contains($dprivacy['sq_lang'], 'FR'));
  }

  // If unset, set the language settings accordingly to the user's current language
  if(!$lang_en && !$lang_fr)
  {
    // Fetch the current language
    $lang = user_get_language();

    // Set the language settings
    $lang_en = ($lang == 'EN');
    $lang_fr = ($lang == 'FR');
  }

  // Return those privacy settings, neatly folded in a cozy array
  return array( 'show_en' => $lang_en ,
                'show_fr' => $lang_fr );
}
