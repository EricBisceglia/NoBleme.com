<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/**
 * Checks if a user is allowed to vote in writer's corner contests.
 *
 * The current rule is that only administrators, global moderators, moderators, and people who have taken part as
 * authors in previous writer's contests are allowed to vote. This function looks whether the user satisfies this rule.
 *
 * @param   int|null $user_id (OPTIONAL) Specifies the ID of the user to check - if null, current user.
 *
 * @return  bool                         Is the user allowed to vote in writer's corner contests.
 */

function writings_contest_can_vote($user_id=NULL)
{
  // If the user is logged out, then he can't vote
  if(is_null($user_id) && !user_is_logged_in())
    return 0;

  // Fetch and sanitize the user's ID
  $user_id = (!is_null($user_id)) ? $user_id : user_get_id();
  $user_id = sanitize($user_id, 'int', 0);

  // Fetch some info about the user
  $duser = mysqli_fetch_array(query(" SELECT  users.is_administrator    AS 'u_admin'      ,
                                              users.is_global_moderator AS 'u_global_mod' ,
                                              users.is_moderator        AS 'u_mod'
                                      FROM    users
                                      WHERE   users.id = '$user_id' "));

  // If the user is part of the administrative team, then he can vote
  $can_vote = ($duser['u_admin'] || $duser['u_global_mod'] || $duser['u_mod']) ? 1 : 0;

  // Otherwise, check if the user has contributed a writing to a past contest in the writer's corner
  if(!$can_vote)
  {
    $dtext = mysqli_fetch_array(query(" SELECT    writings_texts.id AS 't_id'
                                        FROM      writings_texts
                                        LEFT JOIN writings_contests
                                               ON writings_texts.fk_writings_contests = writings_contests.id
                                        WHERE     writings_contests.fk_users_winner > 0
                                        AND       writings_texts.fk_users = '$user_id' "));
    $can_vote = ($dtext['t_id']) ? 1 : 0;
  }

  // Return whether the user is allowed to vote
  return $can_vote;
}




/**
 * Updates the number of texts in a writer's corner contest.
 *
 * @param   int $contest_id The ID of the contest which needs re-counting.
 *
 * @return  int             The number of texts in the contest.
 */

function writings_contest_update_texts_count($contest_id)
{
  // If the specified ID is 0, don't get tricked into counting all texts linked to no existing contest and return 0
  if(!$contest_id)
    return 0;

  // Sanitize the contest id
  $contest_id = sanitize($contest_id, 'int', 0);

  // Fetch the number of texts in the contest
  $dtexts = mysqli_fetch_array(query("  SELECT  COUNT(writings_texts.id) AS 'w_num'
                                        FROM    writings_texts
                                        WHERE   writings_texts.fk_writings_contests = '$contest_id' "));

  // Sanitize the returned value - just in case
  $nb_texts = sanitize($dtexts['w_num'], 'int', 0);

  // Update the contest with the info
  query(" UPDATE  writings_contests
          SET     writings_contests.nb_entries  = '$nb_texts'
          WHERE   writings_contests.id          = '$contest_id' ");

  // In case it could be useful, return the number of texts in the specified contest
  return $nb_texts;
}