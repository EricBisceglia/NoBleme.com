<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_add                    Creates a new unvalidated quote proposal.                                          */
/*  quotes_get                    Returns data related to a quote.                                                   */
/*  quotes_get_linked_users       Returns a list of users linked to a quote.                                         */
/*  quotes_get_random_id          Returns a random quote ID.                                                         */
/*  quotes_list                   Returns a list of quotes.                                                          */
/*  quotes_edit                   Modifies an existing quote.                                                        */
/*  quotes_delete                 Deletes a quote.                                                                   */
/*  quotes_restore                Restores a soft deleted quote.                                                     */
/*                                                                                                                   */
/*  quotes_approve                Approve a quote awaiting admin validation.                                         */
/*                                                                                                                   */
/*  quotes_link_user              Links a user to an existing quote.                                                 */
/*  quotes_unlink_user            Unlinks a user from an existing quote.                                             */
/*                                                                                                                   */
/*  user_setting_quotes           Returns the quote related settings of the current user.                            */
/*                                                                                                                   */
/*********************************************************************************************************************/

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
A new quote proposal has been made by [url=${path}pages/users/${submitter_id}]${submitter_nick}[/url] : [url=${path}pages/quotes/${quote_id}][Quote #${quote_id}][/url]

[quote=${submitter_nick}]${body_raw}[/quote]
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

  // Return the new quote's id
  return $quote_id;
}




/**
 * Returns data related to a quote.
 *
 * @param   int         $quote_id   The quote's id.
 *
 * @return  array|null              An array containing related data, or null if it does not exist.
 */

function quotes_get( int $quote_id ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!database_row_exists('quotes', $quote_id))
    return NULL;

  // Fetch the data
  $dquote = mysqli_fetch_array(query("  SELECT    submitter.username  AS 'q_submitter'  ,
                                                  quotes.body         AS 'q_body'       ,
                                                  quotes.submitted_at AS 'q_date'       ,
                                                  quotes.language     AS 'q_lang'       ,
                                                  quotes.is_nsfw      AS 'q_nsfw'
                                        FROM      quotes
                                        LEFT JOIN users AS submitter ON quotes.fk_users_submitter = submitter.id
                                        WHERE     quotes.id = '$quote_id' "));

  // Assemble an array with the data
  $data['submitter']  = sanitize_output($dquote['q_submitter']);
  $data['body']       = sanitize_output($dquote['q_body']);
  $data['body_full']  = sanitize_output($dquote['q_body'], true);
  $data['date']       = sanitize_output(date('Y-m-d', $dquote['q_date']));
  $data['lang']       = $dquote['q_lang'];
  $data['nsfw']       = $dquote['q_nsfw'];

  // Return the data
  return $data;
}



/**
 * Returns a list of users linked to a quote.
 *
 * @param   int         $quote_id   The quote's id.
 *
 * @return  array|null              An array containing related data, or null if it does not exist.
*/

function quotes_get_linked_users(int $quote_id) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $quote_id = sanitize($quote_id, 'int', 0);

  // Check if the quote exists
  if(!database_row_exists('quotes', $quote_id))
    return NULL;

  // Fetch the user list
  $qusers = query(" SELECT    users.id                AS 'u_id'       ,
                              users.username          AS 'u_nick'     ,
                              users.is_deleted        AS 'u_deleted'  ,
                              users.deleted_username  AS 'u_realnick'
                    FROM      quotes_users
                    LEFT JOIN users ON quotes_users.fk_users = users.id
                    WHERE     quotes_users.fk_quotes = '$quote_id'
                    ORDER BY  users.username ASC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    $data[$i]['id']       = $row['u_id'];
    $data[$i]['deleted']  = $row['u_deleted'];
    $temp                 = ($row['u_deleted']) ? $row['u_realnick'] : $row['u_nick'];
    $data[$i]['username'] = sanitize_output($temp);
  }

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
 * Returns a list of quotes.
 *
 * @param   array   $search         (OPTIONAL)  Search for specific field values.
 * @param   int     $quote_id       (OPTIONAL)  Return only a single quote instead of a list.
 * @param   bool    $show_waitlist  (OPTIONAL)  Only show quotes awaiting admin validation.
 * @param   bool    $show_deleted   (OPTIONAL)  Only show soft deleted quotes.
 *
 * @return  array   An array containing quotes.
 */

function quotes_list( ?array  $search         = array() ,
                      ?int    $quote_id       = 0       ,
                      bool    $show_waitlist  = false   ,
                      bool    $show_deleted   = false   ) : array
{
  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Prepare and sanitize the parameters
  $quote_id = sanitize($quote_id, 'int', 0);
  $is_admin = user_is_administrator();

  // Prepare the language filter
  $lang_en    = (isset($search['lang_en']) && $search['lang_en']);
  $lang_fr    = (isset($search['lang_fr']) && $search['lang_fr']);

  // Fetch the quotes
  $qquotes = "    SELECT    quotes.id                                                               AS 'q_id'       ,
                            quotes.submitted_at                                                     AS 'q_date'     ,
                            GROUP_CONCAT(linked_users.id ORDER BY linked_users.username ASC)        AS 'lu_id'      ,
                            GROUP_CONCAT(linked_users.username ORDER BY linked_users.username ASC)  AS 'lu_nick'    ,
                            quotes.is_nsfw                                                          AS 'q_nsfw'     ,
                            quotes.is_deleted                                                       AS 'q_deleted'  ,
                            quotes.admin_validation                                                 AS 'q_public'   ,
                            quotes.body                                                             AS 'q_body'
                  FROM      quotes
                  LEFT JOIN quotes_users                  ON  quotes.id               = quotes_users.fk_quotes
                  LEFT JOIN users         AS linked_users ON  quotes_users.fk_users   = linked_users.id
                                                          AND linked_users.is_deleted = 0
                  WHERE     1 = 1 ";

  // Show a single quote
  if($quote_id && $is_admin)
    $qquotes .= " AND       quotes.id               = '$quote_id' ";
  else if($quote_id)
    $qquotes .= " AND       quotes.id               = '$quote_id'
                  AND       quotes.admin_validation = 1
                  AND       quotes.is_deleted       = 0           ";

  // View quotes awaiting validation
  else if($is_admin && $show_waitlist)
    $qquotes .= " AND       quotes.admin_validation = 0           ";

  // View deleted quotes
  else if($is_admin && $show_deleted)
    $qquotes .= " AND       quotes.is_deleted       = 1           ";

  // Normal view
  else
    $qquotes .= " AND       quotes.admin_validation = 1
                  AND       quotes.is_deleted       = 0 ";

  // Filter the quotes by language
  if($lang_en && !$lang_fr && !$quote_id)
    $qquotes .= " AND       quotes.language      LIKE 'EN'          ";
  if($lang_fr && !$lang_en && !$quote_id)
    $qquotes .= " AND       quotes.language      LIKE 'FR'          ";
  if(!$lang_fr && !$lang_en && !$quote_id)
    $qquotes .= " AND       1                       = 0             ";

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
    $data[$i]['deleted']      = $row['q_deleted'];
    $data[$i]['validated']    = $row['q_public'];
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

  // IRC bot message
  $username = user_get_username();
  irc_bot_send_message("A quote has been modified by $username: ".$GLOBALS['website_url']."pages/quotes/".$quote_id, 'admin');
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

  // Hard delete the quote if requested
  if($hard_delete)
  {
    query(" DELETE FROM quotes
            WHERE       quotes.id = '$quote_id' ");
    return __('quotes_delete_hard_ok');
  }

  // Soft delete the quote
  query(" UPDATE  quotes
          SET     quotes.is_deleted = 1
          WHERE   quotes.id         = '$quote_id' ");
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
  return __('quotes_restore_ok');
}




/**
 * Approve a quote awaiting admin validation.
 *
 * @param   int     $quote_id   The id of the quote to approve.
 *
 * @return  string              A string recapping the results of the approval process.
 */

function quotes_approve(int $quote_id) : string
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
  $dquote = mysqli_fetch_array(query("  SELECT  quotes.fk_users_submitter AS 'q_submitter'  ,
                                                quotes.is_deleted         AS 'q_deleted'    ,
                                                quotes.admin_validation   AS 'q_validated'  ,
                                                quotes.language           AS 'q_lang'
                                        FROM    quotes
                                        WHERE   quotes.id = '$quote_id' "));

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
  if($dquote['q_submitter'] && user_get_id() != $dquote['q_submitter'])
  {
    // Prepare some data
    $admin_id = sanitize(user_get_id(), 'int', 0);
    $user_id  = sanitize($dquote['q_submitter'], 'int', 0);
    $lang     = user_get_language($user_id);
    $path     = root_path();

    // Prepare the message's title
    $message_title = ($lang == 'FR') ? 'Citation approuvée' : 'Quote proposal approved';

    // Prepare the message's body
    if($lang == 'FR')
      $message_body = <<<EOT
Votre proposition de citation a été approuvée : [url=${path}pages/quotes/${quote_id}]Citation #${quote_id}[/url].

Nous vous remercions pour votre participation à la collection de citations de NoBleme.
EOT;
    else
      $message_body = <<<EOT
Your quote proposal has been approved: [url=${path}pages/quotes/${quote_id}]Quote #${quote_id}[/url].

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
  if($dquote['q_lang'] == 'EN')
    irc_bot_send_message("A new quote has been added to NoBleme's quote database: ".$GLOBALS['website_url']."pages/quotes/$quote_id", 'english');
  else if($dquote['q_lang'] == 'FR')
    irc_bot_send_message("Une nouvelle entrée a été ajoutée à la collection de citations de NoBleme : ".$GLOBALS['website_url']."pages/quotes/$quote_id", 'french');

  // Return that all went well
  return __('quotes_approve_ok');
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
  $dlink = mysqli_num_rows(query("  SELECT  quotes_users.id
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
                              string  $user_id ) : void
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
