<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


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

  if($type === 'dev_version')
  {
    $return['css']  = 'bold text_white positive';
    $return['href'] = $path.'index_temp_nobleme';
    $return['EN']   = "New version of the website: ".sanitize_output($title);
    $return['FR']   = "Nouvelle version du site : ".sanitize_output($title);
  }

  else if($type === 'dev_blog')
  {
    $return['css']  = 'text_black green_background';
    $return['href'] = $path.'index_temp_nobleme?id='.$id;
    $return['EN']   = ($parent) ? "New devblog published: ".sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? "Nouveau devblog publié : ".sanitize_output(string_truncate($title, 50, '...')) : '';
  }

  else if($type === 'dev_task_new')
  {
    $return['href'] = $path.'index_temp_nobleme?id='.$id;
    $return['EN']   = ($parent) ? sanitize_output($nickname)." opened a new task: ".sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? sanitize_output($nickname)." a ouvert une tâche : ".sanitize_output(string_truncate($title, 50, '...')) : '';

  }

  else if($type === 'dev_task_finished')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_nobleme?id='.$id;
    $return['EN']   = ($parent) ? "Task solved: ".sanitize_output(string_truncate($parent, 75, '...')) : '';
    $return['FR']   = ($title) ? "Tache résolue : ".sanitize_output(string_truncate($title, 70, '...')) : '';
  }


  //*****************************************************************************************************************//
  //                                                      USERS                                                      //
  //*****************************************************************************************************************//

  else if($type === 'users_register')
  {
    $return['css']  = 'text_white nobleme_light';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = sanitize_output($nickname)." registered on NoBleme!";
    $return['FR']   = sanitize_output($nickname)." s'est inscrit·e sur NoBleme !";
  }

  else if($type === 'users_profile_edit')
  {
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = sanitize_output($nickname).' edited their public profile';
    $return['FR']   = sanitize_output($nickname).' a modifié son profil public';
  }

  else if($type === 'users_admin_edit_profile')
  {
    $return['css']  = 'neutral text_white';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = sanitize_output($parent).' edited '.sanitize_output($nickname)."'s public profile";
    $return['FR']   = sanitize_output($parent).' a modifié le profil public de '.sanitize_output($nickname);
  }

  else if($type === 'users_admin_edit_password')
  {
    $return['css']  = 'website_update text_white';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = sanitize_output($parent).' changed '.sanitize_output($nickname)."'s password";
    $return['FR']   = sanitize_output($parent).' a modifié le mot de passe de '.sanitize_output($nickname);
  }

  else if($type === 'users_banned' && !$admins_only)
  {
    $return['css']  = 'negative text_white bold';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $temp           = ($id > 1) ? 's' : '';
    $return['EN']   = sanitize_output($nickname).' has been banned for '.$id.' day'.$temp;
    $return['FR']   = sanitize_output($nickname).' a été banni·e pendant '.$id.' jour'.$temp;
  }
  else if($type == 'users_banned')
  {
    $return['css']  = 'negative text_white bold';
    $return['href'] = $path.'index_temp_admin';
    $temp           = ($id > 1) ? 's' : '';
    $return['EN']   = sanitize_output($parent).' banned '.sanitize_output($nickname).' for '.$id.' day'.$temp;
    $return['FR']   = sanitize_output($parent).' a banni '.sanitize_output($nickname).' pendant '.$id.' jour'.$temp;
  }

  else if($type === 'users_unbanned' && !$admins_only)
  {
    $return['css']  = 'positive text_white bold';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = sanitize_output($nickname).' has been unbanned';
    $return['FR']   = sanitize_output($nickname).' a été débanni·e';
  }
  else if($type == 'users_unbanned')
  {
    $return['css']  = 'positive text_white bold';
    $return['href'] = $path.'index_temp_admin';
    $return['EN']   = sanitize_output($parent).' has unbanned '.sanitize_output($nickname);
    $return['FR']   = sanitize_output($parent).' a débanni '.sanitize_output($nickname);
  }

  else if($type === 'users_rights_delete')
  {
    $return['css']  = 'website_update text_white';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = sanitize_output($nickname)." is not part of the administrative team anymore";
    $return['FR']   = sanitize_output($nickname)." ne fait plus partie de l'équipe administrative";
  }

  else if($type === 'users_rights_moderator')
  {
    $return['css']  = 'green_background text_black';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = sanitize_output($nickname)." has joined the administrative team as a moderator";
    $return['FR']   = sanitize_output($nickname)." a rejoint l'équipe administrative en tant que modérateur";
  }

  else if($type === 'users_rights_global_moderator')
  {
    $return['css']  = 'neutral text_white bold';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = sanitize_output($nickname)." has joined the admin. team as a global moderator";
    $return['FR']   = sanitize_output($nickname)." a rejoint l'équipe admin. en tant que modérateur global";
  }

  else if($type === 'users_rights_administrator')
  {
    $return['css']  = 'positive text_white bold';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = sanitize_output($nickname)." is now a website administrator";
    $return['FR']   = sanitize_output($nickname)." est maintenant un administrateur du site";
  }




  //*****************************************************************************************************************//
  //                                                REAL LIFE MEETUPS                                                //
  //*****************************************************************************************************************//

  else if($type === 'meetups_new' && !$admins_only)
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = 'New real life meetup planned the '.sanitize_output($title);
    $return['FR']   = 'Nouvelle rencontre IRL planifiée le '.sanitize_output($title);
  }
  else if($type === 'meetups_new')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = sanitize_output($nickname).' created a new meetup the '.sanitize_output($title);
    $return['FR']   = sanitize_output($nickname).' a crée une nouvelle IRL le '.sanitize_output($title);
  }

  else if($type === 'meetups_edit')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = sanitize_output($nickname)." edited the ".sanitize_output($title)." meetup";
    $return['FR']   = sanitize_output($nickname)." a modifié l'IRL du ".sanitize_output($title);
  }

  else if($type === 'meetups_delete')
  {
    $return['css']  = 'website_update text_white';
    $return['EN']   = sanitize_output($nickname)." deleted the ".sanitize_output($title)." meetup";
    $return['FR']   = sanitize_output($nickname)." a supprimé l'IRL du ".sanitize_output($title);
  }

  else if($type === 'meetups_people_new' && !$admins_only)
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = sanitize_output($nickname).' joined the '.sanitize_output($title)." meetup";
    $return['FR']   = sanitize_output($nickname)." a rejoint l'IRL du ".sanitize_output($title);
  }
  else if($type === 'meetups_people_new')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = sanitize_output($parent)." added ".sanitize_output($nickname)." to the ".sanitize_output($title)." meetup";
    $return['FR']   = sanitize_output($parent).' a ajouté '.sanitize_output($nickname)." à l'IRL du ".sanitize_output($title);
  }

  else if($type === 'meetups_people_edit')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = sanitize_output($parent).' modified '.sanitize_output($nickname)."'s details in the ".sanitize_output($title)." meetup";
    $return['FR']   = sanitize_output($parent).' a modifié les infos de '.sanitize_output($nickname)." dans l'IRL du ".sanitize_output($title);
  }

  else if($type === 'meetups_people_delete' && !$admins_only)
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = sanitize_output($nickname).' left the '.sanitize_output($title)." meetup";
    $return['FR']   = sanitize_output($nickname)." a quitté l'IRL du ".sanitize_output($title);
  }
  else if($type === 'meetups_people_delete')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = sanitize_output($parent).' removed '.sanitize_output($nickname).' from the '.sanitize_output($title)." meetup";
    $return['FR']   = sanitize_output($parent).' a supprimé '.sanitize_output($nickname)." de l'IRL du ".sanitize_output($title);
  }




  //*****************************************************************************************************************//
  //                                        ENCYCLOPEDIA OF INTERNET CULTURE                                         //
  //*****************************************************************************************************************//

  else if($type === 'internet_page_new')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($parent) ? 'New page in the internet encyclopedia : '.sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? "Nouvelle page dans l'encyclopédie du web : ".sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  else if($type === 'internet_page_edit')
  {
    $return['css']  = '';
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($parent) ? "Page modified in the internet encyclopedia : ".sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? "Page modifiée dans l'encyclopédie du web : ".sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  else if($type === 'internet_page_delete')
  {
    $return['css']  = '';
    $return['EN']   = ($parent) ? 'Page deleted in the internet encyclopedia : '.sanitize_output(string_truncate($parent, 50, '...')) : '';
    $return['FR']   = ($title) ? "Page supprimée dans l'encyclopédie du web : ".sanitize_output(string_truncate($title, 40, '...')) : '';
  }

  else if($type === 'internet_definition_new')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($parent) ? 'New entry in the internet dictionary : '.sanitize_output(string_truncate($parent, 55, '...')) : '';
    $return['FR']   = ($title) ? 'Nouvelle entrée dans le dictionnaire du web : '.sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  else if($type === 'internet_definition_edit')
  {
    $return['css']  = '';
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($parent) ? 'Entry modified in the internet dictionary : '.sanitize_output(string_truncate($parent, 55, '...')) : '';
    $return['FR']   = ($title) ? 'Entrée modifiée dans le dictionnaire du web : '.sanitize_output(string_truncate($title, 45, '...')) : '';
  }

  else if($type === 'internet_definition_delete')
  {
    $return['css']  = '';
    $return['EN']   = ($parent) ? 'Entry deleted in the internet dictionary : '.sanitize_output(string_truncate($parent, 55, '...')) : '';
    $return['FR']   = ($title) ? 'Entrée supprimée dans le dictionnaire du web : '.sanitize_output(string_truncate($title, 40, '...')) : '';
  }




  //*****************************************************************************************************************//
  //                                                     QUOTES                                                      //
  //*****************************************************************************************************************//

  else if($type === 'quotes_new_fr')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = 'Citation #'.$id.' ajoutée à la collection';
  }
  else if($type === 'quotes_new_en')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = 'Quote #'.$id.' added to the collection';
    $return['FR']   = 'Citation anglophone #'.$id.' ajoutée à la collection';
  }




  //*****************************************************************************************************************//
  //                                                 WRITER'S CORNER                                                 //
  //*****************************************************************************************************************//

  else if($type === 'writings_text_new_fr')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = ($nickname != 'Anonyme') ? sanitize_output($nickname).' a publié un texte : '.sanitize_output(string_truncate($title, 70, '...')) : 'Nouveau texte publié : '.sanitize_output(string_truncate($title, 70, '...'));
  }

  else if($type === 'writings_text_edit_fr')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = sanitize_output($nickname).' a modifié le contenu d\'un texte : '.sanitize_output(string_truncate($title, 50, '...'));
  }

  else if($type === 'writings_text_delete')
  {
    $return['css']  = 'website_update text_white';
    $return['EN']   = sanitize_output($nickname)." deleted a writer's corner entry: ".sanitize_output(string_truncate($title, 40, '...'));
    $return['FR']   = sanitize_output($nickname).' a supprimé un texte du coin des écrivains : '.sanitize_output(string_truncate($title, 40, '...'));
  }

  else if($type === 'writings_contest_new_fr')
  {
    $return['css']  = 'text_black green_background';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = 'Nouveau concours du coin des écrivains : '.sanitize_output(string_truncate($title, 50, '...'));
  }

  else if($type === 'writings_contest_winner_fr')
  {
    $return['css']  = 'text_black green_background_light';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = 'Concours du coin des écrivains ouvert aux votes : '.sanitize_output(string_truncate($title, 40, '...'));
  }

  else if($type === 'writings_contest_vote_fr')
  {
    $return['css']  = 'text_black green_background';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = $nickname.' a gagné le concours du coin des écrivains : '.sanitize_output(string_truncate($title, 30, '...'));
  }



  //*****************************************************************************************************************//
  //                                                 DEFAULT VALUES                                                  //
  //*****************************************************************************************************************//
  // If no activity type has been matched, return some default content

  else
  {
    $return['css']  = '';
    $return['href'] = '';
    $return['EN']   = "This should not appear here, oops (".$type.")";
    $return['FR']   = "Ceci ne devrait pas apparaitre ici, oups (".$type.")";
  }

  // If some values were left empty, replace them with an empty string

  $return['css']  = (isset($return['css']))  ? $return['css']  : "";
  $return['href'] = (isset($return['href'])) ? $return['href'] : "";
  $return['EN']   = (isset($return['EN']))   ? $return['EN']   : "";
  $return['FR']   = (isset($return['FR']))   ? $return['FR']   : "";

  // Time to return the data
  return $return;
}