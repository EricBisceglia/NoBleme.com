<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  log_activity_parse      Transforms an entry of the `logs_activity` table into human readable content.            */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Transforms an entry of the `logs_activity` table into human readable content.
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
 * @return  array                                 Array of elements used to output and format the activity log;
 *                                                return['css']   is the style of the table line (if empty, no style);
 *                                                return['href']  is the url of the activity (if empty, not clickable);
 *                                                return['EN']    is the activity in english (if empty, french only);
 *                                                return['FR']    is the activity in french (if empty, english only).
 */

function log_activity_parse(  $path                 ,
                              $admins_only          ,
                              $type                 ,
                              $id           = 0     ,
                              $title_en     = NULL  ,
                              $title_fr     = NULL  ,
                              $userid       = 0     ,
                              $nickname     = NULL  ,
                              $mod_nickname = NULL  ,
                              $amount       = 0     )
{
  //*****************************************************************************************************************//
  //                                             DEVELOPMENT / INTERNALS                                             //
  //*****************************************************************************************************************//

  if($type === 'dev_version')
  {
    $return['css']  = 'bold green';
    $return['href'] = $path.'todo_link';
    $return['EN']   = "New version of the website: ".$title_en;
    $return['FR']   = "Nouvelle version du site : ".$title_fr;
  }

  else if($type === 'dev_blog')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = ($title_en) ? "New devblog published: ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Nouveau devblog publié : ".$title_fr : '';
  }

  else if($type === 'dev_task_new')
  {
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = ($title_en) ? $nickname." opened a new task: ".$title_en : '';
    $return['FR']   = ($title_fr) ? $nickname." a ouvert une tâche : ".$title_fr : '';

  }

  else if($type === 'dev_task_finished')
  {
    $return['css']  = 'text_green bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = ($title_en) ? "Task solved: ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Tache résolue : ".$title_fr : '';
  }


  //*****************************************************************************************************************//
  //                                                      USERS                                                      //
  //*****************************************************************************************************************//

  else if($type === 'users_register')
  {
    $return['css']  = 'text_green bold';
    $return['href'] = $path.'todo_link?id='.$userid;
    $return['EN']   = $nickname." registered on NoBleme!";
    $return['FR']   = $nickname." a crée son compte sur NoBleme !";
  }

  else if($type === 'users_profile_edit')
  {
    $return['href'] = $path.'todo_link?id='.$userid;
    $return['EN']   = $nickname.' edited their public profile';
    $return['FR']   = $nickname.' a modifié son profil public';
  }

  else if($type === 'users_admin_edit_profile')
  {
    $return['css']  = 'orange bold';
    $return['href'] = $path.'todo_link?id='.$userid;
    $return['EN']   = $mod_nickname.' edited '.$nickname."'s public profile";
    $return['FR']   = $mod_nickname.' a modifié le profil public de '.$nickname;
  }

  else if($type === 'users_admin_edit_password')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link?id='.$userid;
    $return['EN']   = $mod_nickname.' changed '.$nickname."'s password";
    $return['FR']   = $mod_nickname.' a modifié le mot de passe de '.$nickname;
  }

  else if($type === 'users_banned' && !$admins_only)
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link?id='.$userid;
    $temp           = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month', '365' => 'for a year', '3650' => 'permanently');
    $temp2          = ($title_en) ? ' ('.$title_en.')' : '';
    $return['EN']   = $nickname.' has been banned '.$temp[$amount].$temp2;
    $temp           = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois', '365' => 'un an', '3650' => 'définitivement');
    $temp2          = ($title_fr) ? ' ('.$title_fr.')' : '';
    $return['FR']   = $nickname.' s\'est fait bannir '.$temp[$amount].$temp2;
  }
  else if($type == 'users_banned')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link';
    $temp           = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month', '365' => 'for a year', '3650' => 'permanently');
    $temp2          = ($title_en) ? ' ('.$title_en.')' : '';
    $return['EN']   = $mod_nickname.' banned '.$nickname.' '.$temp[$amount].$temp2;
    $temp           = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois', '365' => 'un an', '3650' => 'définitivement');
    $temp2          = ($title_fr) ? ' ('.$title_fr.')' : '';
    $return['FR']   = $mod_nickname.' a banni '.$nickname.' '.$temp[$amount].$temp2;
  }

  else if($type === 'users_banned_edit' && !$admins_only)
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link?id='.$userid;
    $temp           = array(0 => '', 1 => 'ending a day from now', 7 => 'ending a week from now', 30 => 'ending a month from now', '365' => 'ending a year from now', '3650' => 'a permanent ban');
    $temp2          = ($title_en) ? ' ('.$title_en.')' : '';
    $return['EN']   = $nickname.' has had their ban updated to '.$temp[$amount].$temp2;
    $temp           = array(0 => '', 1 => 'dans un jour', 7 => 'dans une semaine', 30 => 'dans un mois', '365' => 'dans un an', '3650' => 'ban permanent');
    $temp2          = ($title_fr) ? ' ('.$title_fr.')' : '';
    $return['FR']   = 'La date de fin du bannissement de '.$nickname.' a changé : '.$temp[$amount].$temp2;
  }
  else if($type == 'users_banned_edit')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link';
    $temp           = array(0 => '', 1 => 'to ending a day from now', 7 => 'to ending a week from now', 30 => 'to ending a month from now', '365' => 'to ending a year from now', '3650' => 'to a permanent ban');
    $temp2          = ($title_en) ? ' ('.$title_en.')' : '';
    $return['EN']   = $mod_nickname.' edited the ban of '.$nickname.' '.$temp[$amount].$temp2;
    $temp           = array(0 => '', 1 => ': fini dans un jour', 7 => ': fini dans une semaine', 30 => ': fini dans un mois', '365' => ': fini dans un an', '3650' => 'en un ban permanent');
    $temp2          = ($title_fr) ? ' ('.$title_fr.')' : '';
    $return['FR']   = $mod_nickname.' a modifié le bannissement de '.$nickname.' '.$temp[$amount].$temp2;
  }

  else if($type == 'users_banned_delete')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link';
    $temp           = ($title_en) ? ' ('.$title_en.')' : '';
    $return['EN']   = $mod_nickname.' unbanned '.$nickname.$temp;
    $temp           = ($title_fr) ? ' ('.$title_fr.')' : '';
    $return['FR']   = $mod_nickname.' a débanni '.$nickname.$temp;
  }

  else if($type === 'users_unbanned' && !$admins_only)
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'todo_link?id='.$userid;
    $return['EN']   = $nickname.' has been unbanned';
    $return['FR']   = $nickname.' s\'est fait débannir';
  }
  else if($type == 'users_unbanned')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link';
    $return['EN']   = $mod_nickname.' has unbanned '.$nickname;
    $return['FR']   = $mod_nickname.' a débanni '.$nickname;
  }

  else if($type == 'users_banned_ip')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'pages/admin/ban';
    $temp           = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month', '365' => 'for a year', '3650' => 'permanently');
    $temp2          = ($title_en) ? ' ('.$title_en.')' : '';
    $return['EN']   = $mod_nickname.' banned the IP address '.$nickname.' '.$temp[$amount].$temp2;
    $temp           = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois', '365' => 'un an', '3650' => 'définitivement');
    $temp2          = ($title_fr) ? ' ('.$title_fr.')' : '';
    $return['FR']   = $mod_nickname.' a banni l\'adresse IP '.$nickname.' '.$temp[$amount].$temp2;
  }

  else if($type == 'users_banned_ip_delete')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'pages/admin/ban';
    $return['EN']   = $mod_nickname.' unbanned the IP address '.$nickname;
    $return['FR']   = $mod_nickname.' a débanni l\'adresse IP '.$nickname;
  }

  else if($type == 'users_unbanned_ip')
  {
    $return['css']  = 'text_red';
    $return['href'] = $path.'pages/admin/ban';
    $return['EN']   = 'The ban of the IP address '.$nickname.' has ended';
    $return['FR']   = 'Le bannissement de l\'adresse IP '.$nickname.' est fini';
  }

  else if($type === 'users_rights_delete')
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'todo_link';
    $return['EN']   = $nickname." is not part of the administrative team anymore";
    $return['FR']   = $nickname." ne fait plus partie de l'équipe administrative";
  }

  else if($type === 'users_rights_moderator')
  {
    $return['css']  = 'orange bold';
    $return['href'] = $path.'todo_link';
    $return['EN']   = $nickname." has joined the administrative team as a moderator";
    $return['FR']   = $nickname." a rejoint l'équipe de modération de NoBleme";
  }

  else if($type === 'users_rights_administrator')
  {
    $return['css']  = 'red bold';
    $return['href'] = $path.'todo_link';
    $return['EN']   = $nickname." is now a website administrator";
    $return['FR']   = $nickname." a rejoint l'équipe d'administration de NoBleme";
  }

  else if($type === 'users_delete')
  {
    $return['css']  = 'red bold';
    $return['EN']   = $nickname."'s account has been deleted by ".$mod_nickname;
    $return['FR']   = "Le compte de ".$nickname." a été supprimé par ".$mod_nickname;
  }

  else if($type === 'users_undelete')
  {
    $return['css']  = 'green bold';
    $return['EN']   = $nickname."'s account has been reactivated by ".$mod_nickname;
    $return['FR']   = "Le compte de ".$nickname." a été réactivé par ".$mod_nickname;
  }




  //*****************************************************************************************************************//
  //                                                REAL LIFE MEETUPS                                                //
  //*****************************************************************************************************************//

  else if($type === 'meetups_new' && !$admins_only)
  {
    $return['css']  = 'green bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = 'New real life meetup planned on '.date_to_text($title_en, 1);
    $return['FR']   = 'Nouvelle rencontre IRL planifiée le '.date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_new')
  {
    $return['css']  = 'green bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = $mod_nickname.' created a new meetup on '.date_to_text($title_en, 1);
    $return['FR']   = $mod_nickname.' a crée une nouvelle IRL le '.date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_edit')
  {
    $return['href'] = $path.'todo_link?id='.$id;
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
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = $nickname.' joined the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $nickname." a rejoint l'IRL du ".date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_people_new')
  {
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = $mod_nickname." added ".$nickname." to the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname.' a ajouté '.$nickname." à l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_edit')
  {
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = $mod_nickname.' modified '.$nickname."'s details in the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname.' a modifié les infos de '.$nickname." dans l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_delete' && !$admins_only)
  {
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = $nickname.' left the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $nickname." a quitté l'IRL du ".date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_people_delete')
  {
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = $mod_nickname.' removed '.$nickname.' from the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_nickname.' a supprimé '.$nickname." de l'IRL du ".date_to_text($title_fr, 1);
  }




  //*****************************************************************************************************************//
  //                                        ENCYCLOPEDIA OF INTERNET CULTURE                                         //
  //*****************************************************************************************************************//

  else if($type === 'internet_page_new')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = ($title_en) ? 'New page in the internet encyclopedia : '.$title_en : '';
    $return['FR']   = ($title_fr) ? "Nouvelle page dans l'encyclopédie du web : ".$title_fr : '';
  }

  else if($type === 'internet_page_edit')
  {
    $return['href'] = $path.'todo_link?id='.$id;
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
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = ($title_en) ? 'New entry in the internet dictionary : '.$title_en : '';
    $return['FR']   = ($title_fr) ? 'Nouvelle entrée dans le dictionnaire du web : '.$title_fr : '';
  }

  else if($type === 'internet_definition_edit')
  {
    $return['href'] = $path.'todo_link?id='.$id;
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
    $return['href'] = $path.'todo_link?id='.$id;
    $return['FR']   = 'Citation #'.$id.' ajoutée à la collection';
  }
  else if($type === 'quotes_new_en')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['EN']   = 'Quote #'.$id.' added to the collection';
    $return['FR']   = 'Citation anglophone #'.$id.' ajoutée à la collection';
  }




  //*****************************************************************************************************************//
  //                                                 WRITER'S CORNER                                                 //
  //*****************************************************************************************************************//

  else if($type === 'writings_text_new_fr')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['FR']   = ($nickname != 'Anonyme') ? $nickname.' a publié un texte : '.$title_fr : 'Nouveau texte publié : '.$title_fr;
  }

  else if($type === 'writings_text_edit_fr')
  {
    $return['href'] = $path.'todo_link?id='.$id;
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
    $return['href'] = $path.'todo_link?id='.$id;
    $return['FR']   = 'Nouveau concours du coin des écrivains : '.$title_fr;
  }

  else if($type === 'writings_contest_winner_fr')
  {
    $return['css']  = 'brown bold';
    $return['href'] = $path.'todo_link?id='.$id;
    $return['FR']   = 'Concours du coin des écrivains ouvert aux votes : '.$title_fr;
  }

  else if($type === 'writings_contest_vote_fr')
  {
    $return['css']  = 'green bold';
    $return['href'] = $path.'todo_link?id='.$id;
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