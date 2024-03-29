<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_get                      Returns data related to a quote.                                                 */
/*  quotes_get_linked_users         Returns a list of users linked to a quote.                                       */
/*  quotes_get_random_id            Returns a random quote ID.                                                       */
/*  quotes_list                     Returns a list of quotes.                                                        */
/*  quotes_add                      Creates a new unvalidated quote proposal.                                        */
/*  quotes_edit                     Modifies an existing quote.                                                      */
/*  quotes_delete                   Deletes a quote.                                                                 */
/*  quotes_restore                  Restores a soft deleted quote.                                                   */
/*                                                                                                                   */
/*  quotes_approve                  Approve a quote awaiting admin validation.                                       */
/*  quotes_reject                   Reject a quote awaiting admin validation.                                        */
/*                                                                                                                   */
/*  quotes_link_user                Links a user to an existing quote.                                               */
/*  quotes_unlink_user              Unlinks a user from an existing quote.                                           */
/*  quotes_update_linked_users      Updates the list of users linked to a quote.                                     */
/*  quotes_update_all_linked_users  Updates the list of users linked to every single quote.                         */
/*                                                                                                                   */
/*  quotes_stats_list               Returns stats related to quotes.                                                 */
/*  quotes_stats_get_oldest_year    Returns the year in which the oldest quote took place.                           */
/*  quotes_stats_recalculate_user   Recalculates quote database statistics for a specific user.                      */
/*  quotes_stats_recalculate_all    Recalculates global quote database statistics.                                   */
/*                                                                                                                   */
/*  user_settings_quotes            Returns the quote related settings of the current user.                          */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns data related to a quote.
 *
 * @param   int         $quote_id               The quote's id.
 * @param   string      $format     (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array|null                          An array containing related data, or null if it does not exist.
 */

function quotes_get(  int     $quote_id           ,
                      string  $format   = 'html'  ) : mixed
{
  // Sanitize the data
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!database_row_exists('quotes', $quote_id))
    return NULL;

  // Fetch the data
  $dquote = query(" SELECT    quotes.is_deleted       AS 'q_deleted'      ,
                              quotes.admin_validation AS 'q_validated'    ,
                              submitter.id            AS 'q_submitter_id' ,
                              submitter.username      AS 'q_submitter'    ,
                              quotes.body             AS 'q_body'         ,
                              quotes.submitted_at     AS 'q_date'         ,
                              quotes.language         AS 'q_lang'         ,
                              quotes.is_nsfw          AS 'q_nsfw'
                    FROM      quotes
                    LEFT JOIN users AS submitter ON quotes.fk_users_submitter = submitter.id
                    WHERE     quotes.id = '$quote_id' ",
                    fetch_row: true);

  // Format the data
  $data               = NULL;
  $quote_deleted      = $dquote['q_deleted'];
  $quote_validated    = $dquote['q_validated'];
  $quote_submitter_id = $dquote['q_submitter_id'];
  $quote_submitter    = $dquote['q_submitter'];
  $quote_body         = $dquote['q_body'];
  $quote_timestamp    = $dquote['q_date'];
  $quote_date         = ($dquote['q_date']) ? date('Y-m-d', $dquote['q_date']) : '';
  $quote_lang         = $dquote['q_lang'];
  $quote_nsfw         = $dquote['q_nsfw'];

  // Prepare the data for display
  if($format === 'html')
  {
    $data['deleted']      = sanitize_output($quote_deleted);
    $data['validated']    = sanitize_output($quote_validated);
    $data['submitter_id'] = sanitize_output($quote_submitter_id);
    $data['submitter']    = sanitize_output($quote_submitter);
    $data['body']         = sanitize_output($quote_body);
    $data['body_full']    = sanitize_output($quote_body, true);
    $data['date']         = sanitize_output($quote_date);
    $data['lang']         = sanitize_output($quote_lang);
    $data['nsfw']         = sanitize_output($quote_nsfw);
  }

  // Prepare the data for the API
  else if($format === 'api')
  {
    // Do not show deleted or unvalidated quotes in the API
    if($quote_deleted || !$quote_validated)
      return NULL;

    // Quote data
    $data['quote']['id']        = (string)$quote_id;
    $data['quote']['is_nsfw']   = (bool)$quote_nsfw;
    $data['quote']['language']  = string_change_case($quote_lang, 'lowercase');
    $data['quote']['link']      = $GLOBALS['website_url'].'pages/quotes/'.$quote_id;
    $data['quote']['body']      = sanitize_json($quote_body);
    $data['quote']['added_on']  = ($quote_timestamp) ? date('Y-m-d', $quote_timestamp) : NULL;

    // Linked users data
    $quote_users = quotes_get_linked_users($quote_id, exclude_deleted: true);
    if($quote_users['rows'])
    {
      for($i = 0; $i < $quote_users['rows']; $i++)
      {
        $data['quote']['users'][$i]['id']       = (string)$quote_users[$i]['id'];
        $data['quote']['users'][$i]['username'] = sanitize_json($quote_users[$i]['username']);
        $data['quote']['users'][$i]['link']     = $GLOBALS['website_url'].'pages/users/'.$quote_users[$i]['id'];
      }
    }
    else
      $data['quote']['users'] = NULL;
  }

  // Return the prepared data
  return $data;
}




/**
 * Returns a list of users linked to a quote.
 *
 * @param   int         $quote_id                     The quote's id.
 * @param   bool        $exclude_deleted  (OPTIONAL)  Excludes deleted users from the returned data.
 *
 * @return  array|null                                An array containing related data, or null if it does not exist.
*/

function quotes_get_linked_users( int   $quote_id                 ,
                                  bool  $exclude_deleted = false  ) : mixed
{
  // Sanitize the data
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!database_row_exists('quotes', $quote_id))
    return NULL;

  // Exclude deleted users if requested
  $search_deleted = ($exclude_deleted) ? " AND users.is_deleted = 0 " : " ";

  // Fetch the user list
  $qusers = query(" SELECT    users.id                AS 'u_id'       ,
                              users.username          AS 'u_nick'     ,
                              users.is_deleted        AS 'u_deleted'  ,
                              users.deleted_username  AS 'u_realnick'
                    FROM      quotes_users
                    LEFT JOIN users ON quotes_users.fk_users = users.id
                    WHERE     quotes_users.fk_quotes = '$quote_id'
                              $search_deleted
                    ORDER BY  users.username ASC ");

  // Prepare the data
  for($i = 0; $row = query_row($qusers); $i++)
  {
    $data[$i]['id']       = $row['u_id'];
    $data[$i]['deleted']  = $row['u_deleted'];
    $data[$i]['username'] = ($row['u_deleted'])
                          ? sanitize_output($row['u_realnick'])
                          : sanitize_output($row['u_nick']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns a random quote ID.
 *
 * @param   array   $search   (OPTIONAL)  Specifies search parameters for the randomly returned quote.
 * @param   string  $context  (OPTIONAL)  In which context will the random ID be used ('page', 'api').
 *
 * @return  int                           A random quote's ID, in the user's allowed languages.
 */

function quotes_get_random_id(  array   $search   = array() ,
                                string  $context  = 'html'  ) : int
{
  // Sanitize the search parameters
  $search_lang  = sanitize_array_element($search, 'lang', 'string', default: NULL);
  $search_nsfw  = sanitize_array_element($search, 'nsfw', 'int', 0, 1, default: -1);
  $search_user  = sanitize_array_element($search, 'user', 'int', 0);
  $search_year  = sanitize_array_element($search, 'year', 'int', 0);

  // Initialize extra parameters for the query
  $search_where = '';
  $join_user    = '';

  // Search for quotes in specific languages
  if($context === 'html')
  {
    // Fetch the user's language settings for quotes
    $language_settings = user_settings_quotes();

    // Filter by only one language if necessary
    if($language_settings['show_en'] && !$language_settings['show_fr'])
      $search_where .= " AND quotes.language LIKE 'EN' ";
    else if($language_settings['show_fr'] && !$language_settings['show_en'])
      $search_where .= " AND quotes.language LIKE 'FR' ";
  }
  else if($context === 'api' && $search_lang)
    $search_where .= " AND quotes.language LIKE '%$search_lang%' ";

  // Search for quotes including a specific user ID
  if($context === 'api' && $search_user)
  {
    // Return no quote if the user does not exist
    if(!database_row_exists('users', $search_user))
      return 0;

    // Join quotes with matching user ids
    $join_user    .= "  LEFT JOIN quotes_users
                        ON        quotes_users.fk_quotes  = quotes.id       ";
    $search_where .= "  AND       quotes_users.fk_users   = '$search_user'  ";
  }

  // Search for other parameters
  $search_where .= ($search_nsfw > -1)  ? " AND quotes.is_nsfw = '$search_nsfw' "                           : " ";
  $search_where .= ($search_year)       ? " AND YEAR(FROM_UNIXTIME(quotes.submitted_at)) = '$search_year' " : " ";

  // Fetch a random quote
  $drand = query("  SELECT    quotes.id AS 'q_id'
                    FROM      quotes
                              $join_user
                    WHERE     quotes.is_deleted       = 0
                    AND       quotes.admin_validation = 1
                              $search_where
                    ORDER BY  RAND()
                    LIMIT     1 "   ,
                    fetch_row: true );

  // Return the random quote's id
  return (isset($drand['q_id'])) ? $drand['q_id'] : 0;
}




/**
 * Returns a list of quotes.
 *
 * @param   array   $search         (OPTIONAL)  Search for specific field values.
 * @param   int     $quote_id       (OPTIONAL)  Return only a single quote instead of a list.
 * @param   bool    $show_waitlist  (OPTIONAL)  Only show quotes awaiting admin validation.
 * @param   bool    $show_deleted   (OPTIONAL)  Only show soft deleted quotes.
 * @param   string  $format         (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array   An array containing quotes.
 */

function quotes_list( ?array  $search         = array() ,
                      ?int    $quote_id       = 0       ,
                      bool    $show_waitlist  = false   ,
                      bool    $show_deleted   = false   ,
                      string  $format         = 'html'  ) : array
{
  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Prepare and sanitize the parameters
  $quote_id = sanitize($quote_id, 'int', 0);
  $is_admin = user_is_administrator();

  // Prepare the language filter
  $lang_en  = (isset($search['lang_en']) && $search['lang_en']);
  $lang_fr  = (isset($search['lang_fr']) && $search['lang_fr']);

  // Prepare the search parameters
  $search_body  = sanitize_array_element($search, 'body', 'string');
  $search_user  = sanitize_array_element($search, 'user', 'int', min: 0, default: 0);
  $search_year  = sanitize_array_element($search, 'year', 'int', min: -1, default: 0);
  $search_nsfw  = sanitize_array_element($search, 'nsfw', 'int', min: -1, max: 1, default: -1);

  // View a single quote
  if($quote_id && $is_admin)
    $query_search = " WHERE quotes.id               = '$quote_id' ";
  else if($quote_id)
    $query_search = " WHERE quotes.id               = '$quote_id'
                      AND   quotes.admin_validation = 1
                      AND   quotes.is_deleted       = 0 ";

  // View quotes awaiting validation
  else if($is_admin && $show_waitlist)
    $query_search = " WHERE quotes.admin_validation = 0 ";

  // View deleted quotes
  else if($is_admin && $show_deleted)
    $query_search = " WHERE quotes.is_deleted = 1 ";

  // Default view
  else
    $query_search = " WHERE quotes.admin_validation = 1
                      AND   quotes.is_deleted       = 0 ";

  // Filter the quotes by language
  if($lang_en && !$lang_fr && !$quote_id)
    $query_search .= " AND quotes.language LIKE 'EN'  ";
  if($lang_fr && !$lang_en && !$quote_id)
    $query_search .= " AND quotes.language LIKE 'FR'  ";
  if(!$lang_fr && !$lang_en && !$quote_id)
    $query_search .= " AND 1 = 0                      ";

  // Search through the data: Years
  if($search_year === -1)
    $query_search .= " AND quotes.submitted_at                      = 0               ";
  else if($search_year)
    $query_search .= " AND YEAR(FROM_UNIXTIME(quotes.submitted_at)) = '$search_year'  ";

  // Search through the data: Other searches
  $query_search .= ($search_body)       ? " AND quotes.body        LIKE '%$search_body%'  " : " ";
  $query_search .= ($search_user)       ? " AND quotes_users.fk_users = '$search_user'    " : " ";
  $query_search .= ($search_nsfw > -1)  ? " AND quotes.is_nsfw        = '$search_nsfw'    " : " ";

  // Fetch the quotes
  $qquotes = "  SELECT    quotes.id                                                               AS 'q_id'       ,
                          quotes.submitted_at                                                     AS 'q_date'     ,
                          GROUP_CONCAT(linked_users.id ORDER BY linked_users.username ASC)        AS 'lu_id'      ,
                          GROUP_CONCAT(linked_users.username ORDER BY linked_users.username ASC)  AS 'lu_nick'    ,
                          quotes.is_nsfw                                                          AS 'q_nsfw'     ,
                          quotes.is_deleted                                                       AS 'q_deleted'  ,
                          quotes.admin_validation                                                 AS 'q_public'   ,
                          quotes.language                                                         AS 'q_lang'     ,
                          quotes.body                                                             AS 'q_body'     ,
                          quotes.linked_users                                                     AS 'q_linked'
                FROM      quotes
                LEFT JOIN quotes_users                  ON  quotes.id               = quotes_users.fk_quotes
                LEFT JOIN users         AS linked_users ON  quotes_users.fk_users   = linked_users.id
                                                        AND linked_users.is_deleted = 0
                          $query_search
                GROUP BY  quotes.id
                ORDER BY  quotes.submitted_at DESC  ,
                          quotes.id           DESC  ";

  // Run the query
  $dquotes = query($qquotes);

  // Prepare the data
  for($i = 0; $row = query_row($dquotes); $i++)
  {
    // Format the data
    $quote_id         = $row['q_id'];
    $quote_date       = $row['q_date'];
    $quote_date_text  = ($row['q_date']) ? date_to_text($row['q_date'], strip_day:1) : __('quotes_nodate');
    $quote_nsfw       = $row['q_nsfw'];
    $quote_deleted    = $row['q_deleted'];
    $quote_validated  = $row['q_public'];
    $quote_language   = $row['q_lang'];
    $quote_body       = $row['q_body'];

    // Fetch linked users the standard way, from the `quotes_users` table
    if(!$search_user)
    {
      $quote_users_ids    = ($row['lu_id']) ? explode(',', $row['lu_id']) : '';
      $quote_users_nicks  = ($row['lu_nick']) ? explode(',', $row['lu_nick']) : '';
      $quote_users_count  = (is_array($quote_users_ids)) ? count($quote_users_ids) : 0;
      $quote_users_count  = ($quote_users_count && $quote_users_count === count($quote_users_nicks))
                          ? $quote_users_count
                          : 0;
    }

    // When filtering quotes by user, fetch linked users from the `quotes` table instead
    else
    {
      // Decode the JSON containing the users
      $quote_users        = json_decode($row['q_linked'], associative: true);
      $quote_users_count  = (isset($quote_users['rows'])) ? $quote_users['rows'] : 0;

      // Assemble the user list from the json
      if($quote_users_count)
      {
        for($j = 0; $j < $quote_users_count; $j++)
        {
          $quote_users_ids[$j]    = $quote_users[$j]['id'];
          $quote_users_nicks[$j]  = $quote_users[$j]['username'];
        }
      }
    }

    // Prepare the data for display
    if($format === 'html')
    {
      // Quote data
      $data[$i]['id']         = sanitize_output($quote_id);
      $data[$i]['date']       = sanitize_output($quote_date_text);
      $data[$i]['nsfw']       = sanitize_output($quote_nsfw);
      $data[$i]['deleted']    = sanitize_output($quote_deleted);
      $data[$i]['validated']  = sanitize_output($quote_validated);
      $data[$i]['body']       = sanitize_output($quote_body, true);
      $data[$i]['meta_desc']  = string_truncate($quote_body, 250, '...');

      // Linked user data
      if($quote_users_count)
      {
        for($j = 0; $j < count($quote_users_nicks); $j++)
          $quote_users_nicks[$j] = sanitize_output($quote_users_nicks[$j]);
        for($j = 0; $j < count($quote_users_ids); $j++)
          $quote_users_ids[$j] = sanitize_output($quote_users_ids[$j]);
      }
      $data[$i]['linked_count'] = sanitize_output($quote_users_count);
      $data[$i]['linked_ids']   = $quote_users_ids;
      $data[$i]['linked_nicks'] = $quote_users_nicks;
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      // Quote data
      $data[$i]['id']       = (string)$quote_id;
      $data[$i]['is_nsfw']  = (bool)$quote_nsfw;
      $data[$i]['language'] = string_change_case($quote_language, 'lowercase');
      $data[$i]['link']     = $GLOBALS['website_url'].'pages/quotes/'.$quote_id;
      $data[$i]['body']     = sanitize_json($quote_body);
      $data[$i]['added_on'] = ($quote_date) ? date('Y-m-d', $quote_date) : NULL;

      // Linked user data
      if($quote_users_count)
      {
        for($j = 0; $j < $quote_users_count; $j++)
        {
          $data[$i]['users'][$j]['id']        = (string)$quote_users_ids[$j];
          $data[$i]['users'][$j]['username']  = sanitize_json($quote_users_nicks[$j]);
          $data[$i]['users'][$j]['link']      = $GLOBALS['website_url'].'pages/users/'.$quote_users_ids[$j];
        }
      }
      else
        $data[$i]['users'] = NULL;
    }
  }

  // Add the language filters and the number of rows to the data
  if($format === 'html')
  {
    $data['lang_en']  = $lang_en;
    $data['lang_fr']  = $lang_fr;
    $data['rows']     = $i;
  }

  // Give a default return value when no quotes are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('quotes' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new unvalidated quote proposal.
 *
 * @param   string      $body   The quote proposal's contents.
 *
 * @return  string|int          A string if an error happened, or the newly created quote's id if all went well.
 */

function quotes_add( string $body ) : mixed
{
  // Require the user to be logged in to run this action
  user_restrict_to_users();

  // Sanitize the data
  $body_raw = $body;
  $body     = sanitize($body, 'string');

  // Stop here if no quote was provided
  if(!$body)
    return __('quotes_add_empty');

  // Check for flood
  flood_check();

  // Fetch data regarding the proposal
  $timestamp      = sanitize(time(), 'int', 0);
  $submitter_id   = sanitize(user_get_id(), 'int', 0);
  $submitter_nick = user_get_username();
  $is_admin       = user_is_administrator();
  $language       = sanitize(user_get_language(), 'string');

  // Create the quote
  query(" INSERT INTO quotes
          SET         quotes.fk_users_submitter = '$submitter_id' ,
                      quotes.submitted_at       = '$timestamp'    ,
                      quotes.language           = '$language'     ,
                      quotes.body               = '$body'         ");

  // Grab the newly created quote's id
  $quote_id = query_id();

  // Notify admins of the new proposal
  if(!$is_admin)
  {
    // Prepare the admin mail
    $path       = root_path();
    $mail_body  = <<<EOT
A new quote proposal has been made by [url={$path}pages/users/{$submitter_id}]{$submitter_nick}[/url] : [url={$path}pages/quotes/{$quote_id}][Quote #{$quote_id}][/url]

[quote={$submitter_nick}]{$body_raw}[/quote]
EOT;

    // Send the admin mail
    private_message_send( 'Quote proposal'    ,
                          $mail_body          ,
                          recipient: 0        ,
                          sender: 0           ,
                          is_admin_only: true );

    // IRC notification
    irc_bot_send_message("Quote proposal #$quote_id has been made by $submitter_nick: ".$GLOBALS['website_url']."pages/admin/inbox", "admin");
  }

  // Recalculate the linked users' stats
  quotes_stats_recalculate_user($submitter_id);

  // Return the new quote's id
  return $quote_id;
}




/**
 * Modifies an existing quote.
 *
 * @param   int     $quote_id     The quote's id.
 * @param   array   $quote_data   The modified quote data.
 *
 * @return  void
 */

function quotes_edit( int   $quote_id   ,
                      array $quote_data ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the quote's id
  $quote_id = sanitize($quote_id, 'int', 0);

  // Stop here if the quote does not exist
  if(!database_row_exists('quotes', $quote_id))
    return;

  // Sanitize the updated data
  $quote_body = sanitize($quote_data['body'], 'string');
  $quote_date = sanitize(strtotime($quote_data['date']), 'int', 0);
  $quote_lang = sanitize($quote_data['lang'], 'string');
  $quote_nsfw = sanitize($quote_data['nsfw'], 'int', 0, 1);

  // Update the quote
  query(" UPDATE  quotes
          SET     quotes.body         = '$quote_body' ,
                  quotes.submitted_at = '$quote_date' ,
                  quotes.language     = '$quote_lang' ,
                  quotes.is_nsfw      = '$quote_nsfw'
          WHERE   quotes.id           = '$quote_id' ");

  // Fetch more data on the quote
  $quote_data = quotes_get($quote_id);

  // IRC bot message
  if(!$quote_data['deleted'] && $quote_data['validated'])
  {
    $username = user_get_username();
    irc_bot_send_message("A quote has been modified by $username: ".$GLOBALS['website_url']."pages/quotes/".$quote_id, 'admin');
  }

  // Recalculate the quote submitter's stats
  quotes_stats_recalculate_user($quote_data['submitter_id']);
}




/**
 * Deletes a quote.
 *
 * @param   int     $quote_id                 The id of the quote to delete.
 * @param   bool    $hard_delete  (OPTIONAL)  If set, performs a hard deletion.
 *
 * @return  string                            A string recapping the results of the deletion process.
 */

function quotes_delete( int   $quote_id             ,
                        bool  $hard_delete  = false ) : string
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Sanitize the quote's id
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!$quote_id)
    return __('quotes_delete_none');
  if(!database_row_exists('quotes', $quote_id))
    return __('quotes_delete_error');

  // Fetch more data on the quote
  $quote_data = quotes_get($quote_id);

  // Fetch the users linked to the quote
  $quote_users = quotes_get_linked_users($quote_id);

  // Hard delete the quote if requested
  if($hard_delete)
    query(" DELETE FROM quotes
            WHERE       quotes.id = '$quote_id' ");

  // Soft delete the quote
  query(" UPDATE  quotes
          SET     quotes.is_deleted = 1
          WHERE   quotes.id         = '$quote_id' ");

  // Recalculate the quote submitter's stats
  quotes_stats_recalculate_user($quote_data['submitter_id']);

  // Recalculate the linked users' stats
  for($i = 0; $i < $quote_users['rows']; $i++)
    quotes_stats_recalculate_user($quote_users[$i]['id']);

  // Return that the quote was properly deleted
  if($hard_delete)
    return __('quotes_delete_hard_ok');
  else
    return __('quotes_delete_ok');
}




/**
 * Restores a soft deleted quote
 *
 * @param   int     $quote_id   The id of the quote to restore.
 *
 * @return  string              A string recapping the results of the restoration process.
 */

function quotes_restore( int $quote_id ) : string
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Sanitize the quote's id
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!$quote_id)
    return __('quotes_delete_none');
  if(!database_row_exists('quotes', $quote_id))
    return __('quotes_restore_error');

  // Restore the quote
  query(" UPDATE  quotes
          SET     quotes.is_deleted = 0
          WHERE   quotes.id         = '$quote_id' ");

  // Fetch more data on the quote
  $quote_data = quotes_get($quote_id);

  // Recalculate the quote submitter's stats
  quotes_stats_recalculate_user($quote_data['submitter_id']);

  // Fetch the users linked to the quote
  $quote_users = quotes_get_linked_users($quote_id);

  // Recalculate the linked users' stats
  for($i = 0; $i < $quote_users['rows']; $i++)
    quotes_stats_recalculate_user($quote_users[$i]['id']);

  // Return that the quote was restored
  return __('quotes_restore_ok');
}




/**
 * Approve a quote awaiting admin validation.
 *
 * @param   int         $quote_id   The id of the quote to approve.
 *
 * @return  string|null              A string if an error happened, or null if all went well.
 */

function quotes_approve(int $quote_id) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Sanitize the quote's id
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!$quote_id)
    return __('quotes_delete_none');
  if(!database_row_exists('quotes', $quote_id))
    return __('quotes_restore_error');

  // Fetch information about the quote
  $dquote = query(" SELECT  quotes.fk_users_submitter AS 'q_submitter'  ,
                            quotes.is_deleted         AS 'q_deleted'    ,
                            quotes.admin_validation   AS 'q_validated'  ,
                            quotes.language           AS 'q_lang'
                    FROM    quotes
                    WHERE   quotes.id = '$quote_id' ",
                    fetch_row: true);

  // Error: Quote has been deleted
  if($dquote['q_deleted'])
    return __('quotes_restore_error');

  // Error: Quote has already been approved
  if($dquote['q_validated'])
    return __('quotes_approve_already');

  // Approve the quote
  query(" UPDATE  quotes
          SET     quotes.admin_validation = 1
          WHERE   quotes.id               = '$quote_id' ");

  // Notify the user if they are not the one approving the quote
  if($dquote['q_submitter'] && user_get_id() !== (int)$dquote['q_submitter'])
  {
    // Prepare some data
    $admin_id = sanitize(user_get_id(), 'int', 0);
    $user_id  = sanitize($dquote['q_submitter'], 'int', 0);
    $lang     = user_get_language($user_id);
    $path     = root_path();

    // Prepare the message's title
    $message_title = ($lang === 'FR') ? 'Citation approuvée' : 'Quote proposal approved';

    // Prepare the message's body
    if($lang === 'FR')
      $message_body = <<<EOT
Votre proposition de citation a été approuvée : [url={$path}pages/quotes/{$quote_id}]Citation #{$quote_id}[/url].

Nous vous remercions pour votre participation à la collection de citations de NoBleme.
EOT;
    else
      $message_body = <<<EOT
Your quote proposal has been approved: [url={$path}pages/quotes/{$quote_id}]Quote #{$quote_id}[/url].

Thank you for being a part of NoBleme's quote database. It is greatly appreciated.
EOT;


    // Send the notification message
    private_message_send( $message_title          ,
                          $message_body           ,
                          recipient: $user_id     ,
                          sender: 0               ,
                          true_sender: $admin_id  ,
                          hide_admin_mail: true   );
  }

  // Notify IRC in the correct language
  if($dquote['q_lang'] === 'EN')
    irc_bot_send_message("A new quote has been added to NoBleme's quote database: ".$GLOBALS['website_url']."pages/quotes/$quote_id", 'english');
  else if($dquote['q_lang'] === 'FR')
    irc_bot_send_message("Une nouvelle entrée a été ajoutée à la collection de citations de NoBleme : ".$GLOBALS['website_url']."pages/quotes/$quote_id", 'french');

  // Notify Discord
  if($dquote['q_lang'] === 'EN')
    discord_send_message("A new quote has been added to NoBleme's quote database.".PHP_EOL."Une nouvelle citation anglophone a été ajoutée à la collection de citations de NoBleme.".PHP_EOL."<".$GLOBALS['website_url']."pages/quotes/$quote_id>", 'main');
  else if($dquote['q_lang'] === 'FR')
    discord_send_message("A new french speaking quote has been added to NoBleme's quote database.".PHP_EOL."Une nouvelle citation a été ajoutée à la collection de citations de NoBleme.".PHP_EOL."<".$GLOBALS['website_url']."pages/quotes/$quote_id>", 'main');

  // Fetch more data on the quote
  $quote_data = quotes_get($quote_id);

  // Recalculate the quote submitter's stats
  quotes_stats_recalculate_user($quote_data['submitter_id']);

  // Fetch the users linked to the quote
  $quote_users = quotes_get_linked_users($quote_id);

  // Recalculate the linked users' stats
  for($i = 0; $i < $quote_users['rows']; $i++)
    quotes_stats_recalculate_user($quote_users[$i]['id']);

  // All went well
  return NULL;
}




/**
 * Reject a quote awaiting admin validation.
 *
 * @param   int           $quote_id               The id of the quote to reject.
 * @param   string        $reason     (OPTIONAL)  The reason for rejecting the quote.
 *
 * @return  string|null                           A string if an error happened, or null if all went well.
 */

function quotes_reject( int     $quote_id     ,
                        string  $reason = ''  ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Sanitize the quote's id
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!$quote_id)
    return __('quotes_delete_none');
  if(!database_row_exists('quotes', $quote_id))
    return __('quotes_restore_error');

  // Fetch information about the quote
  $dquote = query(" SELECT  quotes.fk_users_submitter AS 'q_submitter'  ,
                            quotes.is_deleted         AS 'q_deleted'    ,
                            quotes.admin_validation   AS 'q_validated'  ,
                            quotes.language           AS 'q_lang'       ,
                            quotes.body               AS 'q_body'
                    FROM    quotes
                    WHERE   quotes.id = '$quote_id' ",
                    fetch_row: true);

  // Error: Quote has been deleted
  if($dquote['q_deleted'])
    return __('quotes_restore_error');

  // Error: Quote has already been approved
  if($dquote['q_validated'])
    return __('quotes_approve_already');

  // Reject the quote
  query(" UPDATE  quotes
          SET     quotes.admin_validation = 1 ,
                  quotes.is_deleted       = 1
          WHERE   quotes.id               = '$quote_id' ");

  // Notify the user if they are not the one rejecting the quote
  if($dquote['q_submitter'] && user_get_id() !== (int)$dquote['q_submitter'])
  {
    // Prepare some data
    $admin_id = sanitize(user_get_id(), 'int', 0);
    $user_id  = sanitize($dquote['q_submitter'], 'int', 0);
    $lang     = user_get_language($user_id);
    $body     = $dquote['q_body'];

    // Prepare the message's title
    $message_title = ($lang === 'FR') ? 'Citation rejetée' : 'Quote proposal rejected';

    // Prepare the rejection reason
    if($reason)
    {
      if($lang === 'FR')
        $reason = "[u]Raison du refus[/u] : $reason";
      else
        $reason = "[u]Rejection reason[/u]: $reason";
    }

    // Prepare the message's body
    if($lang === 'FR')
      $message_body = <<<EOT
Votre proposition de citation a été rejetée.

Ce refus ne signifie pas que votre contribution n'est pas appréciée : dans une optique de faire primer la qualité sur la quantité, nous refusons un grand nombre de propositions. N'hésitez pas à soumettre d'autres propositions dans le futur. Nous vous remercions pour votre participation à la collection de citations de NoBleme.

{$reason}

Le contenu de votre proposition de citation était le suivant :

[quote]{$body}[/quote]
EOT;
    else
      $message_body = <<<EOT
Your quote proposal has been rejected.

This refusal does not mean that we do not appreciate your contribution: our goal is to prioritize quality over quantity, therefore we reject a lot of quote proposals. Do not hesitate to submit more quote proposals in the future. Thank you for contributing to NoBleme's quote database. It is greatly appreciated.

{$reason}

Your proposal was the following:

[quote]{$body}[/quote]
EOT;


    // Send the notification message
    private_message_send( $message_title          ,
                          $message_body           ,
                          recipient: $user_id     ,
                          sender: 0               ,
                          true_sender: $admin_id  ,
                          hide_admin_mail: true   );
  }

  // All went well
  return NULL;
}




/**
 * Links a user to an existing quote.
 *
 * @param   int         $quote_id   The quote's id.
 * @param   string      $username   The username of the account that should be linked to the quote.
 *
 * @return  string|null             A string if an error happened, or null if all went well.
 */

function quotes_link_user(  int     $quote_id ,
                            string  $username ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Sanitize the parameters
  $quote_id = sanitize($quote_id, 'int', 0);
  $username = sanitize($username, 'string');

  // Check if the quote exists
  if(!$quote_id || !database_row_exists('quotes', $quote_id))
    return __('quotes_restore_error');

  // Check if a username has been provided
  if(!$username)
    return __('quotes_users_empty');

  // Fetch the user id
  $user_id = sanitize(database_entry_exists('users', 'username', $username), 'int', 0);

  // Stop here if the account has not been found
  if(!$user_id)
    return __('quotes_users_error');

  // Check if the link already exists
  $dlink = query_row_count(query("  SELECT  quotes_users.id
                                    FROM    quotes_users
                                    WHERE   quotes_users.fk_quotes  = '$quote_id'
                                    AND     quotes_users.fk_users   = '$user_id' "));

  // Stop here if it does exist
  if($dlink)
    return __('quotes_users_exists');

  // Link the account to the quote
  query(" INSERT INTO quotes_users
          SET         quotes_users.fk_quotes  = '$quote_id' ,
                      quotes_users.fk_users   = '$user_id'  ");

  // Recalculate the linked users' stats
  quotes_update_linked_users($quote_id);
  quotes_stats_recalculate_user($user_id);

  // ALl went well
  return NULL;
}




/**
 * Unlinks a user from an existing quote.
 *
 * @param   int         $quote_id   The quote's id.
 * @param   string      $user_id    The user's id.
 *
 * @return  void
 */

function quotes_unlink_user(  int     $quote_id ,
                              string  $user_id  ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the parameters
  $quote_id = sanitize($quote_id, 'int', 0);
  $user_id  = sanitize($user_id, 'int', 0);

  // Check if the quote exists
  if(!$quote_id || !database_row_exists('quotes', $quote_id))
    return;

  // Check if the user exists
  if(!$user_id || !database_row_exists('users', $user_id))
    return;

  // Unlink the user
  query(" DELETE FROM quotes_users
          WHERE       quotes_users.fk_quotes  = '$quote_id'
          AND         quotes_users.fk_users   = '$user_id' ");

  // Recalculate the linked users' stats
  quotes_update_linked_users($quote_id);
  quotes_stats_recalculate_user($user_id);
}




/**
 * Updates the list of users linked to a quote.
 *
 * @param   int   $quote_id   The quote's id.
 *
 * @return void
 */

function quotes_update_linked_users( int $quote_id ) : void
{
  // Sanitize the quote's id
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!$quote_id || !database_row_exists('quotes', $quote_id))
    return;

  // Fetch the users linked to the quote
  $quote_users = quotes_get_linked_users($quote_id);

  // Prepare the data
  $linked_users = json_encode($quote_users);

  // Update the linked users
  query(" UPDATE  quotes
          SET     quotes.linked_users = '$linked_users'
          WHERE   quotes.id           = '$quote_id' ");
}




/**
 * Updates the list of users linked to every single quote.
 *
 * @return void
 */

function quotes_update_all_linked_users() : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Fetch every quote
  $qquotes = query("  SELECT    quotes.id AS 'q_id'
                      FROM      quotes
                      ORDER BY  quotes.id ASC");

  // Loop through the quotes and update their linked users
  while($dquotes = query_row($qquotes))
  {
    $quote_id = sanitize($dquotes['q_id'], 'int', 0);
    quotes_update_linked_users($quote_id);
  }
}




/**
 * Returns stats related to quotes.
 *
 * @return  array   An array of stats related to quotes.
 */

function quotes_stats_list() : array
{
  // Check if the required files have been included
  require_included_file('functions_numbers.inc.php');
  require_included_file('functions_mathematics.inc.php');

  // Initialize the return array
  $data = array();

  // Add the oldest quote's year to the return array
  $data['oldest_year'] = quotes_stats_get_oldest_year();

  // Fetch the total number of quotes
  $dquotes = query("  SELECT  COUNT(*)              AS 'q_total'    ,
                              SUM(CASE  WHEN quotes.language LIKE 'EN' THEN 1
                                        ELSE 0 END) AS 'q_total_en' ,
                              SUM(CASE  WHEN quotes.language LIKE 'FR' THEN 1
                                        ELSE 0 END) AS 'q_total_fr' ,
                              SUM(quotes.is_nsfw)   AS 'q_total_nsfw'
                      FROM    quotes
                      WHERE   quotes.is_deleted       = 0
                      AND     quotes.admin_validation = 1 ",
                      fetch_row: true);

  // Add some stats to the return array
  $data['total']        = $dquotes['q_total'];
  $data['total_en']     = $dquotes['q_total_en'];
  $data['percent_en']   = number_display_format(maths_percentage_of($dquotes['q_total_en'], $dquotes['q_total']) ,
                                                'percentage');
  $data['total_fr']     = $dquotes['q_total_fr'];
  $data['percent_fr']   = number_display_format(maths_percentage_of($dquotes['q_total_fr'], $dquotes['q_total']) ,
                                                'percentage');
  $data['total_nsfw']   = $dquotes['q_total_nsfw'];
  $data['percent_nsfw'] = number_display_format(maths_percentage_of($dquotes['q_total_nsfw'], $dquotes['q_total']) ,
                                                'percentage');

  // Fetch all quotes, included unvalidated and deleted
  $dquotes = query("  SELECT  COUNT(*)                AS 'q_total'          ,
                              SUM(quotes.is_deleted)  AS 'q_total_deleted'  ,
                              SUM(CASE  WHEN quotes.admin_validation = 0 THEN 1
                                        ELSE 0 END)   AS 'q_total_unvalidated'
                      FROM    quotes ",
                      fetch_row: true );

  // Add some stats to the return array
  $data['deleted']      = $dquotes['q_total_deleted'];
  $data['percent_del']  = number_display_format(maths_percentage_of($dquotes['q_total_deleted'], $dquotes['q_total']) ,
                                                'percentage');
  $data['unvalidated']  = $dquotes['q_total_unvalidated'];

  // Fetch user stats
  $qquotes = query("  SELECT    users.id                        AS 'u_id'               ,
                                users.username                  AS 'u_nick'             ,
                                users_stats.quotes              AS 'us_quotes'          ,
                                users_stats.quotes_en           AS 'us_quotes_en'       ,
                                users_stats.quotes_fr           AS 'us_quotes_fr'       ,
                                users_stats.quotes_nsfw         AS 'us_quotes_nsfw'     ,
                                users_stats.quotes_oldest_id    AS 'us_quotes_old_id'   ,
                                users_stats.quotes_oldest_date  AS 'us_quotes_old_date' ,
                                users_stats.quotes_newest_id    AS 'us_quotes_new_id'   ,
                                users_stats.quotes_newest_date  AS 'us_quotes_new_date'
                      FROM      users_stats
                      LEFT JOIN users ON users_stats.fk_users = users.id
                      WHERE     users_stats.quotes > 0
                      ORDER BY  users_stats.quotes  DESC  ,
                                users.username      ASC   ");

  // Loop through user stats and add its data to the return array
  for($i = 0; $row = query_row($qquotes); $i++)
  {
    $data['users_id_'.$i]           = sanitize_output($row['u_id']);
    $data['users_nick_'.$i]         = sanitize_output($row['u_nick']);
    $data['users_quotes_'.$i]       = sanitize_output($row['us_quotes']);
    $data['users_quotes_en_'.$i]    = $row['us_quotes_en'] ? (sanitize_output($row['us_quotes_en'])) : '';
    $data['users_quotes_fr_'.$i]    = $row['us_quotes_fr'] ? (sanitize_output($row['us_quotes_fr'])) : '';
    $data['users_quotes_nsfw_'.$i]  = $row['us_quotes_nsfw'] ? (sanitize_output($row['us_quotes_nsfw'])) : '';
    $data['users_quotes_nsfw_'.$i] .= $row['us_quotes_nsfw']
                                    ? ' ('.sanitize_output(number_display_format(
                                                      maths_percentage_of($row['us_quotes_nsfw'], $row['us_quotes']) ,
                                                           'percentage')).')'
                                    : '';
    $data['users_qold_id_'.$i]      = sanitize_output($row['us_quotes_old_id']);
    $data['users_qold_date_'.$i]    = ($row['us_quotes_old_date'])
                                    ? sanitize_output(date('Y', $row['us_quotes_old_date']))
                                    : sanitize_output('< '.$data['oldest_year']);
    $data['users_qnew_id_'.$i]      = sanitize_output($row['us_quotes_new_id']);
    $data['users_qnew_date_'.$i]    = ($row['us_quotes_new_date'])
                                    ? sanitize_output(date('Y', $row['us_quotes_new_date']))
                                    : sanitize_output('< '.$data['oldest_year']);
  }

  // Add the amount of user stats to the return array
  $data['users_count'] = $i;

  // Fetch quotes by years
  $qquotes = query("  SELECT    quotes.submitted_at                       AS 'q_time'     ,
                                YEAR(FROM_UNIXTIME(quotes.submitted_at))  AS 'q_year'     ,
                                COUNT(*)                                  AS 'q_count'    ,
                                SUM(CASE  WHEN quotes.language LIKE 'EN' THEN 1
                                          ELSE 0 END)                     AS 'q_count_en' ,
                                SUM(CASE  WHEN quotes.language LIKE 'FR' THEN 1
                                          ELSE 0 END)                     AS 'q_count_fr'
                      FROM      quotes
                      WHERE     quotes.admin_validation = 1
                      AND       quotes.is_deleted       = 0
                      GROUP BY  q_year
                      ORDER BY  q_year ");

  // Add quote data over time to the return data
  while($dquotes = query_row($qquotes))
  {
    $year                           = ($dquotes['q_year'] >= $data['oldest_year']) ? $dquotes['q_year'] : 0;
    $data['years_count_'.$year]     = ($dquotes['q_count']) ? sanitize_output($dquotes['q_count']) : '';
    $data['years_count_en_'.$year]  = ($dquotes['q_count_en']) ? sanitize_output($dquotes['q_count_en']) : '';
    $data['years_count_fr_'.$year]  = ($dquotes['q_count_fr']) ? sanitize_output($dquotes['q_count_fr']) : '';
  }

  // Ensure every year has an entry until the current one
  for($i = $data['oldest_year']; $i <= date('Y'); $i++)
  {
    $data['years_count_'.$i]    ??= '';
    $data['years_count_en_'.$i] ??= '';
    $data['years_count_fr_'.$i] ??= '';
  }

  // Fetch contributor stats
  $qquotes = query("  SELECT    users.id                      AS 'u_id'         ,
                                users.username                AS 'u_nick'       ,
                                users_stats.quotes_submitted  AS 'us_submitted' ,
                                users_stats.quotes_approved   AS 'us_approved'
                      FROM      users_stats
                      LEFT JOIN users ON users_stats.fk_users = users.id
                      WHERE     users_stats.quotes_submitted  > 0
                      ORDER BY  users_stats.quotes_approved   DESC  ,
                                users_stats.quotes_submitted  DESC  ,
                                users.username                ASC   ");

  // Loop through user stats and add its data to the return array
  for($i = 0; $row = query_row($qquotes); $i++)
  {
    $data['contrib_id_'.$i]         = sanitize_output($row['u_id']);
    $data['contrib_nick_'.$i]       = sanitize_output($row['u_nick']);
    $data['contrib_submitted_'.$i]  = sanitize_output($row['us_submitted']);
    $data['contrib_approved_'.$i]   = ($row['us_approved']) ? sanitize_output($row['us_approved']) : '';
    $data['contrib_percentage_'.$i] = sanitize_output(number_display_format(
                                                      maths_percentage_of($row['us_approved'], $row['us_submitted']) ,
                                                      'percentage'));
  }

  // Add the amount of user stats to the return array
  $data['contrib_count'] = $i;

  // Return the stats
  return $data;
}




/**
 * Returns the year in which the oldest quote took place.
 *
 * @return  int   The oldest quote's year.
 */

function quotes_stats_get_oldest_year() : int
{
  // Look up the oldest quote
  $dquotes = query("  SELECT  MIN(quotes.submitted_at) AS 'q_oldest'
                      FROM    quotes
                      WHERE   quotes.is_deleted       = 0
                      AND     quotes.admin_validation = 1
                      AND     quotes.submitted_at     > 0 ",
                      fetch_row: true);

  // Return its year
  return date('Y', $dquotes['q_oldest']);
}




/**
 * Recalculates quote database statistics for a specific user.
 *
 * @param   int   $user_id  The user's id.
 *
 * @return  void
 */

function quotes_stats_recalculate_user( int $user_id )
{
  // Sanitize the user's id
  $user_id = sanitize($user_id, 'int', 0);

  // Check if the user exists
  if(!$user_id || !database_row_exists('users', $user_id))
    return;

  // Count the quotes in which the user is involved
  $dquotes = query("  SELECT    COUNT(*)              AS 'q_count'    ,
                                SUM(CASE  WHEN quotes.language LIKE 'EN' THEN 1
                                          ELSE 0 END) AS 'q_count_en' ,
                                SUM(CASE  WHEN quotes.language LIKE 'FR' THEN 1
                                          ELSE 0 END) AS 'q_count_fr' ,
                                SUM(quotes.is_nsfw)   AS 'q_count_nsfw'
                      FROM      quotes_users
                      LEFT JOIN quotes
                      ON        quotes_users.fk_quotes  = quotes.id
                      WHERE     quotes_users.fk_users   = '$user_id'
                      AND       quotes.is_deleted       = 0
                      AND       quotes.admin_validation = 1 ",
                      fetch_row: true);

  // Sanitize the quote involvement stats
  $quotes_count       = sanitize($dquotes['q_count'], 'int', 0);
  $quotes_count_en    = sanitize($dquotes['q_count_en'], 'int', 0);
  $quotes_count_fr    = sanitize($dquotes['q_count_fr'], 'int', 0);
  $quotes_count_nsfw  = sanitize($dquotes['q_count_nsfw'], 'int', 0);

  // Find the user's oldest quote
  $dquotes = query("  SELECT    quotes.id           AS 'q_id' ,
                                quotes.submitted_at AS 'q_date'
                      FROM      quotes_users
                      LEFT JOIN quotes
                      ON        quotes_users.fk_quotes  = quotes.id
                      WHERE     quotes_users.fk_users   = '$user_id'
                      AND       quotes.is_deleted       = 0
                      AND       quotes.admin_validation = 1
                      ORDER BY  quotes.submitted_at     ASC ,
                                quotes.id               ASC
                      LIMIT     1 ",
                      fetch_row: true);

  // Sanitize the oldest quote stats
  $oldest_id    = isset($dquotes['q_id']) ? sanitize($dquotes['q_id'], 'int', 0) : 0;
  $oldest_date  = isset($dquotes['q_id']) ? sanitize($dquotes['q_date'], 'int', 0) : 0;

  // Find the user's newest quote
  $dquotes = query("  SELECT    quotes.id           AS 'q_id' ,
                                quotes.submitted_at AS 'q_date'
                      FROM      quotes_users
                      LEFT JOIN quotes
                      ON        quotes_users.fk_quotes  = quotes.id
                      WHERE     quotes_users.fk_users   = '$user_id'
                      AND       quotes.is_deleted       = 0
                      AND       quotes.admin_validation = 1
                      ORDER BY  quotes.submitted_at     DESC ,
                                quotes.id               DESC
                      LIMIT     1 ",
                      fetch_row: true);

  // Sanitize the newest quote stats
  $newest_id    = isset($dquotes['q_id']) ? sanitize($dquotes['q_id'], 'int', 0) : 0;
  $newest_date  = isset($dquotes['q_id']) ? sanitize($dquotes['q_date'], 'int', 0) : 0;

  // Count the quotes submitted by the user
  $dquotes = query("  SELECT    COUNT(*) AS 'q_count'
                      FROM      quotes
                      WHERE     quotes.fk_users_submitter = '$user_id' ",
                      fetch_row: true);

  // Sanitize the quote submission stats
  $submitted_count = sanitize($dquotes['q_count'], 'int', 0);

  // Count the quotes submitted and approved by the user
  $dquotes = query("  SELECT    COUNT(*) AS 'q_count'
                      FROM      quotes
                      WHERE     quotes.fk_users_submitter = '$user_id'
                      AND       quotes.is_deleted         = 0
                      AND       quotes.admin_validation   = 1 ",
                      fetch_row: true);

  // Sanitize the quote submission stats
  $approved_count = sanitize($dquotes['q_count'], 'int', 0);

  // Update the user's quotes stats
  query(" UPDATE  users_stats
          SET     users_stats.quotes              = '$quotes_count'       ,
                  users_stats.quotes_en           = '$quotes_count_en'    ,
                  users_stats.quotes_fr           = '$quotes_count_fr'    ,
                  users_stats.quotes_nsfw         = '$quotes_count_nsfw'  ,
                  users_stats.quotes_oldest_id    = '$oldest_id'          ,
                  users_stats.quotes_oldest_date  = '$oldest_date'        ,
                  users_stats.quotes_newest_id    = '$newest_id'          ,
                  users_stats.quotes_newest_date  = '$newest_date'        ,
                  users_stats.quotes_submitted    = '$submitted_count'    ,
                  users_stats.quotes_approved     = '$approved_count'
          WHERE   users_stats.fk_users            = '$user_id'            ");
}




/**
 * Recalculates global quote database statistics.
 *
 * @return  void
 */

function quotes_stats_recalculate_all()
{
  // Fetch every user id
  $qusers = query(" SELECT    users.id AS 'u_id'
                    FROM      users
                    ORDER BY  users.id ASC ");

  // Loop through the users and recalculate their individual quote database statistics
  while($dusers = query_row($qusers))
  {
    $user_id = sanitize($dusers['u_id'], 'int', 0);
    quotes_stats_recalculate_user($user_id);
  }
}




/**
 * Returns the quote related settings of the current user.
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
    $dprivacy = query(" SELECT  users_settings.quotes_languages AS 'sq_lang'
                        FROM    users_settings
                        WHERE   users_settings.fk_users = '$user_id' ",
                        fetch_row: true);

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
    $lang_en = ($lang === 'EN');
    $lang_fr = ($lang === 'FR');
  }

  // Return those privacy settings, neatly folded in a cozy array
  return array( 'show_en' => $lang_en ,
                'show_fr' => $lang_fr );
}
