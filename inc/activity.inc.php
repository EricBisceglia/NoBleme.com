<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


/**
 * Transforms an entry of the `logs_activity` table into human readable content.
 *
 * This whole function is pretty self explanatory.
 * Basically you grab a whole line of the `logs_activity` table and you drop it through this function.
 * The output will be an array of values ready to be used for the recent activity page or the administrative logs page.
 *
 * @param   string      $path                     Relative path to the root of the website (usually is "./../../").
 * @param   bool        $admins_only              Is the log public (0) or private (1).
 * @param   string      $type                     Identifies the type of activity being processed.
 * @param   int|null    $userid       (OPTIONAL)  ID of the user being implicated by the activity log.
 * @param   string|null $nickname     (OPTIONAL)  Nickname of the user being implicated by the activity log.
 * @param   int|null    $id           (OPTIONAL)  ID of the action/element of the activity in the log.
 * @param   string|null $title        (OPTIONAL)  Title of the activity in the log.
 * @param   string|null $parent       (OPTIONAL)  Title of the parent element of the activity in the log.
 *
 * @return  array                                 Returns an array of elements allowing you to format the activity log;
 *                                                return['css']   is the style of the table line (if empty, no style);
 *                                                return['href']  is the url of the activity (if empty, not clickable);
 *                                                return['EN']    is the activity in english (if empty, french only);
 *                                                return['FR']    is the activity in french (if empty, english only).
 */

function log_activity_parse($path, $admins_only, $type, $userid=0, $nickname=NULL, $id=0, $title=NULL, $parent=NULL)
{

  //*****************************************************************************************************************//
  //                                             DEVELOPMENT / INTERNALS                                             //
  //*****************************************************************************************************************//
  // New version of the website

  if($type === 'dev_version')
  {
    $return['css']  = 'gras texte_blanc positif';
    $return['href'] = $path.'pages/todo/roadmap';
    $return['EN']   = "New version of NoBleme.com: ".sanitize_output($title);
    $return['FR']   = "Nouvelle version de NoBleme.com : ".sanitize_output($title);
  }

  //*******************************************************************************************************************
  // New development blog

  else if($type === 'dev_blog')
  {
    $return['css']  = 'texte_noir vert_background';
    $return['href'] = $path.'pages/devblog/devblog?id='.$id;
    $return['FR']   = "Nouveau devblog publié : ".sanitize_output(string_truncate($title, 50, '...'));
  }

  //*******************************************************************************************************************
  // New task in the to-do list

  else if($type === 'dev_task_new')
  {
    $return['href'] = $path.'pages/todo/index?id='.$id;
    if($title)
      $return['EN'] = sanitize_output($nickname)." has opened a new task: ".sanitize_output(string_truncate($parent, 50, '...'));
    if($parent)
      $return['FR'] = sanitize_output($nickname)." a ouvert une tâche : ".sanitize_output(string_truncate($title, 50, '...'));

  }

  //*******************************************************************************************************************
  // Task solved in the to-do list

  else if($type === 'dev_task_finished')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/todo/index?id='.$id;
    if($title)
      $return['EN']   = "Task solved: ".sanitize_output(string_truncate($parent, 75, '...'));
    if($parent)
      $return['FR']   = "Tache résolue : ".sanitize_output(string_truncate($title, 70, '...'));
  }


  //*****************************************************************************************************************//
  //                                                      USERS                                                      //
  //*****************************************************************************************************************//
  // New user registered

  else if($type === 'user_register')
  {
    $return['css']  = 'texte_blanc nobleme_clair';
    $return['href'] = $path.'pages/user/user?id='.$userid;
    $return['EN']   = sanitize_output($nickname)." registered on NoBleme!";
    $return['FR']   = sanitize_output($nickname)." s'est inscrit(e) sur NoBleme !";
  }

  //*******************************************************************************************************************
  // A user edited his public profile

  else if($type === 'user_profile_edit')
  {
    $return['href'] = $path.'pages/user/user?id='.$userid;
    $return['EN']   = sanitize_output($nickname).' edited his public profile';
    $return['FR']   = sanitize_output($nickname).' a modifié son profil public';
  }

  //*******************************************************************************************************************
  // A user profile has been edited by an administrator

  else if($type === 'user_admin_edit_profile')
  {
    $return['css']  = 'neutre texte_blanc';
    $return['href'] = $path.'pages/user/user?id='.$userid;
    $return['EN']   = sanitize_output($parent).' edited '.sanitize_output($nickname)."'s public profile";
    $return['FR']   = sanitize_output($parent).' a modifié le profil public de '.sanitize_output($nickname);
  }

  //*******************************************************************************************************************
  // A user's password has been changed by an administrator

  else if($type === 'user_admin_edit_password')
  {
    $return['css']  = 'neutre texte_blanc';
    $return['href'] = $path.'pages/user/user?id='.$userid;
    $return['EN']   = sanitize_output($parent).' changed '.sanitize_output($nickname)."'s password";
    $return['FR']   = sanitize_output($parent).' a modifié le mot de passe de '.sanitize_output($nickname);
  }

  //*******************************************************************************************************************
  // A user has been banned from the website

  else if($type === 'user_banned' && !$admins_only)
  {
    $return['css']  = 'negatif texte_blanc gras';
    $return['href'] = $path.'pages/user/user?id='.$userid;
    $temp           = ($id > 1) ? 's' : '';
    $return['EN']   = sanitize_output($nickname).' has been banned for '.$id.' day'.$temp;
    $return['FR']   = sanitize_output($nickname).' a été banni(e) pendant '.$id.' jour'.$temp;
  }
  else if($type == 'user_banned')
  {
    $return['css']  = 'negatif texte_blanc gras';
    $return['href'] = $path.'pages/sysop/pilori';
    $temp           = ($id > 1) ? 's' : '';
    $return['EN']   = sanitize_output($parent).' banned '.sanitize_output($nickname).' for '.$id.' day'.$temp;
    $return['FR']   = sanitize_output($parent).' a banni '.sanitize_output($nickname).' pendant '.$id.' jour'.$temp;
  }

  //*******************************************************************************************************************
  // A banned user has been reinstated on the website

  else if($type === 'user_unbanned' && !$admins_only)
  {
    $return['css']  = 'positif texte_blanc gras';
    $return['href'] = $path.'pages/user/user?id='.$userid;
    $return['EN']   = sanitize_output($nickname).' has been unbanned';
    $return['FR']   = sanitize_output($nickname).' a été débanni(e)';
  }
  else if($type == 'user_unbanned')
  {
    $return['css']  = 'positif texte_blanc gras';
    $return['href'] = $path.'pages/sysop/pilori';
    $return['EN']   = sanitize_output($parent).' has unbanned '.sanitize_output($nickname);
    $return['FR']   = sanitize_output($parent).' a débanni '.sanitize_output($nickname);
  }

  //*******************************************************************************************************************
  // A user has been stripped from all his special access rights

  else if($type === 'user_rights_delete')
  {
    $return['css']  = 'negatif texte_blanc gras';
    $return['href'] = $path.'pages/nobleme/admins';
    $return['EN']   = sanitize_output($nickname)." is not part of the administrative team anymore";
    $return['FR']   = sanitize_output($nickname)." ne fait plus partie de l'équipe administrative";
  }

  //*******************************************************************************************************************
  // A user has become a moderator

  else if($type === 'user_rights_moderator')
  {
    $return['css']  = 'vert_background texte_noir';
    $return['href'] = $path.'pages/nobleme/admins';
    $return['EN']   = sanitize_output($nickname)." has joined the administrative team as a moderator";
    $return['FR']   = sanitize_output($nickname)." a rejoint l'équipe administrative en tant que modérateur";
  }

  //*******************************************************************************************************************
  // A user has become a global moderator

  else if($type === 'user_rights_global_moderator')
  {
    $return['css']  = 'neutre texte_blanc gras';
    $return['href'] = $path.'pages/nobleme/admins';
    $return['EN']   = sanitize_output($nickname)." has joined the administrative team as a global moderator";
    $return['FR']   = sanitize_output($nickname)." a rejoint l'équipe administrative en tant que modérateur global";
  }




  //*****************************************************************************************************************//
  //                                                REAL LIFE MEETUPS                                                //
  //*****************************************************************************************************************//
  // New meetup

  else if($type === 'meetup_new' && !$admins_only)
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['EN']   = 'New real life meetup planned';
    $return['FR']   = 'Nouvelle rencontre IRL planifiée le '.sanitize_output($title);
  }
  else if($type === 'meetup_new')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['FR']   = sanitize_output($nickname).' a crée une nouvelle IRL le '.sanitize_output($title);
  }

  //*******************************************************************************************************************
  // A meetup has been modified

  else if($type === 'meetup_edit')
  {
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['FR']   = sanitize_output($nickname).' a modifié l\'IRL du '.sanitize_output($title);
  }

  //*******************************************************************************************************************
  // A meetup has been deleted

  else if($type === 'meetup_delete')
  {
    $return['css']  = 'mise_a_jour texte_blanc';
    $return['FR']   = sanitize_output($nickname)." a supprimé l'IRL du ".sanitize_output($title);
  }

  //*******************************************************************************************************************
  // A new person joined a meetup

  else if($type === 'meetup_people_new' && !$admins_only)
  {
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['EN']   = sanitize_output($nickname).' joined a real life meetup';
    $return['FR']   = sanitize_output($nickname).' a rejoint l\'IRL du '.sanitize_output($title);
  }
  else if($type === 'meetup_people_new')
  {
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['FR']   = sanitize_output($parent).' a ajouté '.sanitize_output($nickname).' à l\'IRL du '.sanitize_output($title);
  }

  //*******************************************************************************************************************
  // A person's info has been edited in a meetup

  else if($type === 'meetup_people_edit')
  {
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['FR']   = sanitize_output($parent).' a modifié les infos de '.sanitize_output($nickname).' dans l\'IRL du '.sanitize_output($title);
  }

  //*******************************************************************************************************************
  // A person has been removed from a meetup

  else if($type === 'meetup_people_delete' && !$admins_only)
  {
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['EN']   = sanitize_output($nickname).' left a real life meetup';
    $return['FR']   = sanitize_output($nickname).' a quitté l\'IRL du '.sanitize_output($title);
  }
  else if($type === 'meetup_people_delete')
  {
    $return['href'] = $path.'pages/irl/irl?id='.$id;
    $return['FR']   = sanitize_output($parent).' a supprimé '.sanitize_output($nickname).' de l\'IRL du '.sanitize_output($title);
  }




  //*****************************************************************************************************************//
  //                                     NBDB: ENCYCLOPEDIA OF INTERNET CULTURE                                      //
  //*****************************************************************************************************************//
  // New page

  else if($type === 'nbdb_web_page_new')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/nbdb/web?id='.$id;
    $return['EN']   = ($parent) ? 'New page in the internet encyclopedia : '.sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? 'Nouvelle page dans l\'encyclopédie du web : '.sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  //*******************************************************************************************************************
  // A page has been modified

  else if($type === 'nbdb_web_page_edit')
  {
    $return['css']  = '';
    $return['href'] = $path.'pages/nbdb/web?id='.$id;
    $return['EN']   = ($parent) ? 'Page modified in the internet encyclopedia : '.sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? 'Page modifiée dans l\'encyclopédie du web : '.sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  //*******************************************************************************************************************
  // A page has been deleted

  else if($type === 'nbdb_web_page_delete')
  {
    $return['css']  = '';
    $return['href'] = $path.'pages/nbdb/web';
    $return['EN']   = ($parent) ? 'Page deleted in the internet encyclopedia : '.sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? 'Page supprimée dans l\'encyclopédie du web : '.sanitize_output(string_truncate($title, 40, '...')) : '';
  }

  //*******************************************************************************************************************
  // New dictionary definition

  else if($type === 'nbdb_web_definition_new')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/nbdb/web_dictionnaire?id='.$id;
    $return['EN']   = ($parent) ? 'New entry in the internet dictionary : '.sanitize_output(string_truncate($parent, 55, '...')) : '';
    $return['FR']   = ($title) ? 'Nouvelle entrée dans le dictionnaire du web : '.sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  //*******************************************************************************************************************
  // A dictionary definition has been edited

  else if($type === 'nbdb_web_definition_edit')
  {
    $return['css']  = '';
    $return['href'] = $path.'pages/nbdb/web_dictionnaire?id='.$id;
    $return['EN']   = ($parent) ? 'Entry modified in the internet dictionary : '.sanitize_output(string_truncate($parent, 55, '...')) : '';
    $return['FR']   = ($title) ? 'Entrée modifiée dans le dictionnaire du web : '.sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  //*******************************************************************************************************************
  // A dictionary definition has been deleted

  else if($type === 'nbdb_web_definition_delete')
  {
    $return['css']  = '';
    $return['href'] = $path.'pages/nbdb/web_dictionnaire';
    $return['EN']   = ($parent) ? 'Entry deleted in the internet dictionary : '.sanitize_output(string_truncate($parent, 55, '...')) : '';
    $return['FR']   = ($title) ? 'Entrée supprimée dans le dictionnaire du web : '.sanitize_output(string_truncate($title, 40, '...')) : '';
  }




  //*****************************************************************************************************************//
  //                                                     QUOTES                                                      //
  //*****************************************************************************************************************//
  // New quote

  else if($type === 'quote_new_fr')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/quotes/quote?id='.$id;
    $return['FR']   = 'Miscellanée #'.$id.' ajoutée à la collection';
  }
  else if($type === 'quote_new_en')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/quotes/quote?id='.$id;
    $return['EN']   = 'Miscellanea #'.$id.' added to the collection';
    $return['FR']   = 'Miscellanée anglophone #'.$id.' ajoutée à la collection';
  }




  //*****************************************************************************************************************//
  //                                                      FORUM                                                      //
  //*****************************************************************************************************************//
  // New thread

  else if($type === 'forum_thread_new' && !$admins_only)
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/forum/sujet?id='.$id;
    $return['EN']   = sanitize_output($nickname).' opened a forum topic: '.sanitize_output(string_truncate($title, 50, '...'));
    $return['FR']   = sanitize_output($nickname).' a ouvert un sujet sur le forum : '.sanitize_output(string_truncate($title, 50, '...'));
  }
  else if($type === 'forum_thread_new')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/forum/sujet?id='.$id;
    $return['EN']   = sanitize_output($nickname).' opened a private forum topic: '.sanitize_output(string_truncate($title, 45, '...'));
    $return['FR']   = sanitize_output($nickname).' a ouvert un sujet privé sur le forum : '.sanitize_output(string_truncate($title, 45, '...'));
  }

  //*******************************************************************************************************************
  // A thread has been edited

  else if($type === 'forum_thread_edit')
  {
    $return['href'] = $path.'pages/forum/sujet?id='.$id;
    $return['FR']   = sanitize_output($nickname).' a modifié le sujet du forum '.sanitize_output(string_truncate($title, 45, '...'));
  }

  //*******************************************************************************************************************
  // A thread has been deleted

  else if($type === 'forum_thread_delete')
  {
    $return['css']  = 'mise_a_jour texte_blanc';
    $return['FR']   = sanitize_output($nickname).' a supprimé le sujet du forum '.sanitize_output(string_truncate($title, 45, '...'));
  }

  //*******************************************************************************************************************
  // New message posted

  else if($type === 'forum_message_new' && !$admins_only)
  {
    $return['href'] = $path.'pages/forum/sujet?id='.$parent.'#'.$id;
    $return['EN']   = sanitize_output($nickname).' replied to the forum topic '.sanitize_output(string_truncate($title, 50, '...'));
    $return['FR']   = sanitize_output($nickname).' a répondu au sujet du forum '.sanitize_output(string_truncate($title, 50, '...'));
  }
  else if($type === 'forum_message_new')
  {
    $return['href'] = $path.'pages/forum/sujet?id='.$parent.'#'.$id;
    $return['EN']   = sanitize_output($nickname).' replied to the private forum topic '.sanitize_output(string_truncate($title, 45, '...'));
    $return['FR']   = sanitize_output($nickname).' a répondu au sujet privé du forum '.sanitize_output(string_truncate($title, 45, '...'));
  }

  //*******************************************************************************************************************
  // A message has been edited

  else if($type === 'forum_message_edit')
  {
    $return['href'] = $path.'pages/forum/sujet?id='.$id;
    $return['EN']   = sanitize_output($nickname).' edited a message by '.$title.' on the forum';
    $return['FR']   = sanitize_output($nickname).' a modifié un message de '.$title.' sur le forum';
  }

  //*******************************************************************************************************************
  // A message has been deleted

  else if($type === 'forum_message_delete')
  {
    $return['css']  = 'mise_a_jour_background';
    $return['href'] = $path.'pages/forum/sujet?id='.$id;
    if($nickname == $title)
    {
      $return['EN']   = sanitize_output($nickname).' deleted one of his messages on the forum';
      $return['FR']   = sanitize_output($nickname).' a supprimé un de ses messages sur le forum';
    }
    else
    {
      $return['EN']   = sanitize_output($nickname).' deleted a message by '.$title.' on the forum';
      $return['FR']   = sanitize_output($nickname).' a supprimé un message de '.$title.' sur le forum';
    }
  }




  //*****************************************************************************************************************//
  //                                                 WRITER'S CORNER                                                 //
  //*****************************************************************************************************************//
  // New writing published

  else if($type === 'ecrivains_new')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/ecrivains/texte?id='.$id;
    $return['FR']   = ($nickname != 'Anonyme') ? sanitize_output($nickname).' a publié un texte : '.sanitize_output(string_truncate($title, 70, '...')) : 'Nouveau texte publié : '.sanitize_output(string_truncate($title, 70, '...'));
  }

  //*******************************************************************************************************************
  // A writing has been edited

  else if($type === 'ecrivains_edit')
  {
    $return['href'] = $path.'pages/ecrivains/texte?id='.$id;
    $return['FR']   = sanitize_output($nickname).' a modifié le contenu d\'un texte : '.sanitize_output(string_truncate($title, 50, '...'));
  }

  //*******************************************************************************************************************
  // A writing has been deleted

  else if($type === 'ecrivains_delete')
  {
    $return['css']  = 'mise_a_jour texte_blanc';
    $return['FR']   = sanitize_output($nickname).' a supprimé un texte du coin des écrivains : '.sanitize_output(string_truncate($title, 40, '...'));
  }

  //*******************************************************************************************************************
  // Comment added to a writing

  else if($type === 'writings_comment_new')
  {
    $return['href'] = $path.'pages/ecrivains/texte?id='.$id;
    $return['FR']   = sanitize_output($nickname).' a réagi au texte '.sanitize_output(string_truncate($title, 70, '...'));
  }
  else if($type === 'writings_comment_new_anonymous')
  {
    $return['href'] = $path.'pages/ecrivains/texte?id='.$id;
    $return['FR']   = 'Nouvelle réaction anonyme au texte '.sanitize_output(string_truncate($title, 60, '...'));
  }

  //*******************************************************************************************************************
  // A comment has been deleted

  else if($type === 'writings_comment_delete')
  {
    $return['css']  = 'mise_a_jour_background';
    $return['href'] = $path.'pages/ecrivains/texte?id='.$id;
    $return['FR']   = sanitize_output($nickname).' a supprimé une réaction de '.$title.' dans le coin des écrivains';
  }

  //*******************************************************************************************************************
  // New writing contest

  else if($type === 'writings_contest_new')
  {
    $return['css']  = 'texte_noir vert_background';
    $return['href'] = $path.'pages/ecrivains/concours?id='.$id;
    $return['FR']   = 'Nouveau concours du coin des écrivains : '.sanitize_output(string_truncate($title, 50, '...'));
  }

  //*******************************************************************************************************************
  // Writing contest open for voting

  else if($type === 'writings_contest_winner')
  {
    $return['css']  = 'texte_noir vert_background_clair';
    $return['href'] = $path.'pages/ecrivains/concours?id='.$id;
    $return['FR']   = 'Concours du coin des écrivains ouvert aux votes : '.sanitize_output(string_truncate($title, 40, '...'));
  }

  //*******************************************************************************************************************
  // Writing contest finished

  else if($type === 'writings_contest_vote')
  {
    $return['css']  = 'texte_noir vert_background';
    $return['href'] = $path.'pages/ecrivains/concours?id='.$id;
    $return['FR']   = $nickname.' a gagné le concours du coin des écrivains : '.sanitize_output(string_truncate($title, 30, '...'));
  }



  //*****************************************************************************************************************//
  //                                                 DEFAULT VALUES                                                  //
  //*****************************************************************************************************************//
  // If no activity type has been matched, we return some default content
  else
  {
    $return['css']  = '';
    $return['href'] = '';
    $return['EN']   = "This should not appear here, oops (".$type.")";
    $return['FR']   = "Ceci ne devrait pas apparaitre ici, oups (".$type.")";
  }

  // If some values were left empty, we replace them with an empty string
  $return['css']  = (isset($return['css']))  ? $return['css']  : "";
  $return['href'] = (isset($return['href'])) ? $return['href'] : "";
  $return['FR']   = (isset($return['FR']))   ? $return['FR']   : "";
  $return['EN']   = (isset($return['EN']))   ? $return['EN']   : "";

  // We're all done now, time to return the data
  return $return;
}