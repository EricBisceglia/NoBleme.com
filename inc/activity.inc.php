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
 * @param   int|null    $id           (OPTIONAL)  ID of the action/element of the activity in the log.
 * @param   string|null $title_en     (OPTIONAL)  Title of the activity in the log, in english.
 * @param   string|null $title_en     (OPTIONAL)  Title of the activity in the log, in french.
 * @param   int|null    $userid       (OPTIONAL)  ID of the user being implicated by the activity log.
 * @param   string|null $nickname     (OPTIONAL)  Nickname of the user being implicated by the activity log.
 * @param   string|null $mod_nickname (OPTIONAL)  Nickname of the staff member being implicated by the activity log.
 * @param   int|null    $amount       (OPTIONAL)  Amount linked to the activity log.
 *
 * @return  array                                 Returns an array of elements allowing you to format the activity log;
 *                                                return['css']   is the style of the table line (if empty, no style);
 *                                                return['href']  is the url of the activity (if empty, not clickable);
 *                                                return['EN']    is the activity in english (if empty, french only);
 *                                                return['FR']    is the activity in french (if empty, english only).
 */

function log_activity_parse($path, $admins_only, $type, $id=0, $title_en=NULL, $title_fr=NULL, $userid=0, $nickname=NULL, $mod_nickname=NULL, $amount=0)
{
  //*****************************************************************************************************************//
  //                                             DEVELOPMENT / INTERNALS                                             //
  //*****************************************************************************************************************//

  if($type === 'dev_version')
  {
    $return['css']  = 'bold green';
    $return['href'] = $path.'index_temp_nobleme';
    $return['EN']   = "New version of the website: ".$title_en;
    $return['FR']   = "Nouvelle version du site : ".$title_fr;
  }

  else if($type === 'dev_blog')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'index_temp_nobleme?id='.$id;
    $return['EN']   = ($title_en) ? "New devblog published: ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Nouveau devblog publié : ".$title_fr : '';
  }

  else if($type === 'dev_task_new')
  {
    $return['href'] = $path.'index_temp_nobleme?id='.$id;
    $return['EN']   = ($title_en) ? $nickname." opened a new task: ".$title_en : '';
    $return['FR']   = ($title_fr) ? $nickname." a ouvert une tâche : ".$title_fr : '';

  }

  else if($type === 'dev_task_finished')
  {
    $return['css']  = 'text_green bold';
    $return['href'] = $path.'index_temp_nobleme?id='.$id;
    $return['EN']   = ($title_en) ? "Task solved: ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Tache résolue : ".$title_fr : '';
  }


  //*****************************************************************************************************************//
  //                                                      USERS                                                      //
  //*****************************************************************************************************************//

  else if($type === 'users_register')
  {
    $return['css']  = 'text_green bold';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = $nickname." registered on NoBleme!";
    $return['FR']   = $nickname." s'est inscrit·e sur NoBleme !";
  }

  else if($type === 'users_profile_edit')
  {
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = $nickname.' edited their public profile';
    $return['FR']   = $nickname.' a modifié son profil public';
  }

  else if($type === 'users_admin_edit_profile')
  {
    $return['css']  = 'orange bold';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = $mod_nickname.' edited '.$nickname."'s public profile";
    $return['FR']   = $mod_nickname.' a modifié le profil public de '.$nickname;
  }

  else if($type === 'users_admin_edit_password')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = $mod_nickname.' changed '.$nickname."'s password";
    $return['FR']   = $mod_nickname.' a modifié le mot de passe de '.$nickname;
  }

  else if($type === 'users_banned' && !$admins_only)
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $temp           = ($amount != 1) ? 's' : '';
    $return['EN']   = $nickname.' has been banned for '.$amount.' day'.$temp;
    $return['FR']   = $nickname.' a été banni·e pendant '.$amount.' jour'.$temp;
  }
  else if($type == 'users_banned')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'index_temp_admin';
    $temp           = ($amount != 1) ? 's' : '';
    $return['EN']   = $mod_nickname.' banned '.$nickname.' for '.$amount.' day'.$temp;
    $return['FR']   = $mod_nickname.' a banni '.$nickname.' pendant '.$amount.' jour'.$temp;
  }

  else if($type === 'users_unbanned' && !$admins_only)
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'index_temp_community?id='.$userid;
    $return['EN']   = $nickname.' has been unbanned';
    $return['FR']   = $nickname.' a été débanni·e';
  }
  else if($type == 'users_unbanned')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'index_temp_admin';
    $return['EN']   = $mod_nickname.' has unbanned '.$nickname;
    $return['FR']   = $mod_nickname.' a débanni '.$nickname;
  }

  else if($type === 'users_rights_delete')
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = $nickname." is not part of the administrative team anymore";
    $return['FR']   = $nickname." ne fait plus partie de l'équipe administrative";
  }

  else if($type === 'users_rights_moderator')
  {
    $return['css']  = 'orange bold';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = $nickname." has joined the administrative team as a moderator";
    $return['FR']   = $nickname." a rejoint l'équipe administrative en tant que modérateur";
  }

  else if($type === 'users_rights_global_moderator')
  {
    $return['css']  = 'orange bold';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = $nickname." has joined the administrative team as a global moderator";
    $return['FR']   = $nickname." a rejoint l'équipe admin. en tant que modérateur global";
  }

  else if($type === 'users_rights_administrator')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'index_temp_community';
    $return['EN']   = $nickname." is now a website administrator";
    $return['FR']   = $nickname." est maintenant un administrateur du site";
  }




  //*****************************************************************************************************************//
  //                                                REAL LIFE MEETUPS                                                //
  //*****************************************************************************************************************//

  else if($type === 'meetups_new' && !$admins_only)
  {
    $return['css']  = 'green bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = 'New real life meetup planned on '.date_to_text($title_en, 1);
    $return['FR']   = 'Nouvelle rencontre IRL planifiée le '.date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_new')
  {
    $return['css']  = 'green bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = $mod_nickname.' created a new meetup on '.date_to_text($title_en, 1);
    $return['FR']   = $mod_nickname.' a crée une nouvelle IRL le '.date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_edit')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = $mod_nickname." edited the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname." a modifié l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_delete')
  {
    $return['css']  = 'red bold';
    $return['EN']   = $mod_nickname." deleted the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname." a supprimé l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_new' && !$admins_only)
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = $nickname.' joined the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $nickname." a rejoint l'IRL du ".date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_people_new')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = $mod_nickname." added ".$nickname." to the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname.' a ajouté '.$nickname." à l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_edit')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = $mod_nickname.' modified '.$nickname."'s details in the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname.' a modifié les infos de '.$nickname." dans l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_delete' && !$admins_only)
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = $nickname.' left the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $nickname." a quitté l'IRL du ".date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_people_delete')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = $mod_nickname.' removed '.$nickname.' from the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname.' a supprimé '.$nickname." de l'IRL du ".date_to_text($title_fr, 1);
  }




  //*****************************************************************************************************************//
  //                                        ENCYCLOPEDIA OF INTERNET CULTURE                                         //
  //*****************************************************************************************************************//

  else if($type === 'internet_page_new')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($title_en) ? 'New page in the internet encyclopedia : '.$title_en : '';
    $return['FR']   = ($title_fr) ? "Nouvelle page dans l'encyclopédie du web : ".$title_fr : '';
  }

  else if($type === 'internet_page_edit')
  {
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($title_en) ? "Page modified in the internet encyclopedia : ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Page modifiée dans l'encyclopédie du web : ".$title_fr : '';
  }

  else if($type === 'internet_page_delete')
  {
    $return['EN']   = ($title_en) ? 'Page deleted in the internet encyclopedia : '.$title_en : '';
    $return['FR']   = ($title_fr) ? "Page supprimée dans l'encyclopédie du web : ".$title_fr : '';
  }

  else if($type === 'internet_definition_new')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($title_en) ? 'New entry in the internet dictionary : '.$title_en : '';
    $return['FR']   = ($title_fr) ? 'Nouvelle entrée dans le dictionnaire du web : '.$title_fr : '';
  }

  else if($type === 'internet_definition_edit')
  {
    $return['href'] = $path.'index_temp_pages?id='.$id;
    $return['EN']   = ($title_en) ? 'Entry modified in the internet dictionary : '.$title_en : '';
    $return['FR']   = ($title_fr) ? 'Entrée modifiée dans le dictionnaire du web : '.$title_fr : '';
  }

  else if($type === 'internet_definition_delete')
  {
    $return['EN']   = ($title_en) ? 'Entry deleted in the internet dictionary : '.$title_en : '';
    $return['FR']   = ($title_fr) ? 'Entrée supprimée dans le dictionnaire du web : '.$title_fr : '';
  }




  //*****************************************************************************************************************//
  //                                                     QUOTES                                                      //
  //*****************************************************************************************************************//

  else if($type === 'quotes_new_fr')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = 'Citation #'.$id.' ajoutée à la collection';
  }
  else if($type === 'quotes_new_en')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['EN']   = 'Quote #'.$id.' added to the collection';
    $return['FR']   = 'Citation anglophone #'.$id.' ajoutée à la collection';
  }




  //*****************************************************************************************************************//
  //                                                 WRITER'S CORNER                                                 //
  //*****************************************************************************************************************//

  else if($type === 'writings_text_new_fr')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = ($nickname != 'Anonyme') ? $nickname.' a publié un texte : '.$title_fr : 'Nouveau texte publié : '.$title_fr;
  }

  else if($type === 'writings_text_edit_fr')
  {
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = $mod_nickname.' a modifié le contenu d\'un texte : '.$title_fr;
  }

  else if($type === 'writings_text_delete')
  {
    $return['css']  = 'red bold';
    $return['EN']   = $mod_nickname." deleted a french writer's corner entry: ".$title_en;
    $return['FR']   = $mod_nickname.' a supprimé un texte du coin des écrivains : '.$title_fr;
  }

  else if($type === 'writings_contest_new_fr')
  {
    $return['css']  = 'green bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = 'Nouveau concours du coin des écrivains : '.$title_fr;
  }

  else if($type === 'writings_contest_winner_fr')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = 'Concours du coin des écrivains ouvert aux votes : '.$title_fr;
  }

  else if($type === 'writings_contest_vote_fr')
  {
    $return['css']  = 'green bold';
    $return['href'] = $path.'index_temp_community?id='.$id;
    $return['FR']   = $nickname.' a gagné le concours du coin des écrivains : '.$title_fr;
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