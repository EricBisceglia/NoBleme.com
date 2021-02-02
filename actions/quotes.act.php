<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  quotes_list                   Returns a list of quotes.                                                          */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns a list of quotes.
 *
 * @param   int     $quote_id   (OPTIONAL)  Return only a single quote instead of a list.
 *
 * @return  array   An array containing quotes.
 */

function quotes_list( ?int  $quote_id = 0 ) : array
{
  // Check if the required files have been included
  require_included_file('quotes.lang.php');

  // Sanitize the parameters
  $quote_id = sanitize($quote_id, 'int', 0);

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

  // Search the quotes
  if($quote_id)
    $qquotes .= " AND       quotes.id               = '$quote_id' ";

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
    $data[$i]['summary']      = sanitize_output(string_truncate($row['q_body'], 100, '...'));
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}