<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                                       //
// Cette page transforme l'activité récente stockée dans la base de données en contenu prêt à être affiché publiquement                  //
//                                                                                                                                       //
// Le contenu produit est utilisé à la fois pour l'activité récente et pour le log de modération                                         //
//                                                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Transforme une activité récente en résultat formaté
//
// $chemin                    est le chemin relatif jusqu'à la racine du site
// $modlog                    précise s'il s'agit de l'activité récente (0) ou du log de modération (1)
// $type                      est le type d'activité à traiter
// $userid        (optionnel) est l'ID du compte de l'utilisateur lié à l'activité
// $pseudonyme    (optionnel) est le pseudonyme de l'utilisateur lié à l'activité
// $id            (optionnel) est l'ID de la table liée à l'activité
// $titre         (optionnel) est le titre utilisé pour construire le texte de l'activité
// $parent        (optionnel) est le titre ou pseudonyme d'un élément parent à l'activité en question
//
// Renvoie un tableau de données contenant :
// $retour['css']   le style à appliquer à la ligne (si vide, l'action ne sera pas stylée)
// $retour['href]   le chemin relatif de l'URL vers laquelle l'activité récente pointe (si vide, l'action ne sera pas cliquable)
// $retour['FR']    la description de l'activité, en français (si vide, l'action n'apparait pas lorsque la page est consultée en français)
// $retour['EN']    la description de l'activité, en anglais (si vide, l'action n'apparait pas lorsque la page est consultée en anglais)
//
// Utilisation: activite_recente($chemin, 0, 'register', 1, 'Bad');

function activite_recente($chemin, $modlog, $type, $userid=0, $pseudonyme=NULL, $id=0, $titre=NULL, $parent=NULL)
{




  //*************************************************************************************************************************************//
  //                                                               MEMBRES                                                               //
  //*************************************************************************************************************************************//
  // Nouvel utilisateur

  if($type === 'register')
  {
    $retour['css']  = 'texte_blanc nobleme_clair';
    $retour['href'] = $chemin.'pages/user/user?id='.$userid;
    $retour['FR']   = predata($pseudonyme)." s'est inscrit(e) sur NoBleme !";
    $retour['EN']   = predata($pseudonyme)." registered on NoBleme!";
  }

  //***************************************************************************************************************************************
  // Utilisateur modifie son profil

  else if($type === 'profil')
  {
    $retour['href'] = $chemin.'pages/user/user?id='.$userid;
    $retour['FR']   = predata($pseudonyme).' a modifié son profil public';
    $retour['EN']   = predata($pseudonyme).' edited his public profile';
  }

  //***************************************************************************************************************************************
  // Profil d'un user modifié par un admin

  else if($type === 'profil_edit')
  {
    $retour['css']  = 'neutre texte_blanc';
    $retour['href'] = $chemin.'pages/user/user?id='.$userid;
    $retour['FR']   = predata($parent).' a modifié le profil public de '.predata($pseudonyme);
    $retour['EN']   = predata($parent).' edited '.predata($pseudonyme).'\'s public profile';
  }

  //***************************************************************************************************************************************
  // Mot de passe d'un user modifié par un admin

  else if($type === 'editpass')
  {
    $retour['css']  = 'neutre texte_blanc';
    $retour['href'] = $chemin.'pages/user/user?id='.$userid;
    $retour['FR']   = predata($parent).' a modifié le mot de passe de '.predata($pseudonyme);
    $retour['EN']   = predata($parent).' changed '.predata($pseudonyme).'\'s password';
  }

  //***************************************************************************************************************************************
  // Utilisateur banni

  else if($type === 'ban' && !$modlog)
  {
    $retour['css']  = 'negatif texte_blanc gras';
    $retour['href'] = $chemin.'pages/user/user?id='.$userid;
    $temp           = ($id > 1) ? 's' : '';
    $retour['FR']   = predata($pseudonyme).' a été banni(e) pendant '.$id.' jour'.$temp;
    $retour['EN']   = predata($pseudonyme).' has been banned for '.$id.' day'.$temp;
  }
  else if($type == 'ban')
  {
    $retour['css']  = 'negatif texte_blanc gras';
    $retour['href'] = $chemin.'pages/sysop/pilori';
    $temp           = ($id > 1) ? 's' : '';
    $retour['FR']   = predata($parent).' a banni '.predata($pseudonyme).' pendant '.$id.' jour'.$temp;
    $retour['EN']   = predata($parent).' banned '.predata($pseudonyme).' for '.$id.' day'.$temp;
  }

  //***************************************************************************************************************************************
  // Utilisateur débanni

  else if($type === 'deban' && !$modlog)
  {
    $retour['css']  = 'positif texte_blanc gras';
    $retour['href'] = $chemin.'pages/user/user?id='.$userid;
    $retour['FR']   = predata($pseudonyme).' a été débanni(e)';
    $retour['EN']   = predata($pseudonyme).' has been unbanned';
  }
  else if($type == 'deban')
  {
    $retour['css']  = 'positif texte_blanc gras';
    $retour['href'] = $chemin.'pages/sysop/pilori';
    $retour['FR']   = predata($parent).' a débanni '.predata($pseudonyme);
    $retour['EN']   = predata($parent).' has unbanned '.predata($pseudonyme);
  }

  //***************************************************************************************************************************************
  // Permissions: Plus aucun droit

  else if($type === 'droits_delete')
  {
    $retour['css']  = 'negatif texte_blanc gras';
    $retour['href'] = $chemin.'pages/nobleme/admins';
    $retour['FR']   = predata($pseudonyme)." ne fait plus partie de l'équipe administrative";
    $retour['EN']   = predata($pseudonyme)." is not part of the administrative team anymore";
  }

  //***************************************************************************************************************************************
  // Permissions: Plus aucun droit

  else if($type === 'droits_mod')
  {
    $retour['css']  = 'vert_background texte_noir';
    $retour['href'] = $chemin.'pages/nobleme/admins';
    $retour['FR']   = predata($pseudonyme)." a rejoint l'équipe administrative en tant que modérateur";
    $retour['EN']   = predata($pseudonyme)." has joined the administrative team as a moderator";
  }

  //***************************************************************************************************************************************
  // Permissions: Plus aucun droit

  else if($type === 'droits_sysop')
  {
    $retour['css']  = 'neutre texte_blanc gras';
    $retour['href'] = $chemin.'pages/nobleme/admins';
    $retour['FR']   = predata($pseudonyme)." a rejoint l'équipe administrative en tant que sysop";
    $retour['EN']   = predata($pseudonyme)." has joined the administrative team as a sysop";
  }




  //*************************************************************************************************************************************//
  //                                                                FORUM                                                                //
  //*************************************************************************************************************************************//
  // Nouveau sujet

  else if($type === 'forum_new' && !$modlog)
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/forum/sujet?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a ouvert un sujet sur le forum : '.predata(tronquer_chaine($titre, 50, '...'));
    $retour['EN']   = predata($pseudonyme).' opened a forum topic: '.predata(tronquer_chaine($titre, 50, '...'));
  }
  else if($type === 'forum_new')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/forum/sujet?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a ouvert un sujet privé sur le forum : '.predata(tronquer_chaine($titre, 45, '...'));
    $retour['EN']   = predata($pseudonyme).' opened a private forum topic: '.predata(tronquer_chaine($titre, 45, '...'));
  }

  //***************************************************************************************************************************************
  // Nouveau message

  else if($type === 'forum_new_message' && !$modlog)
  {
    $retour['href'] = $chemin.'pages/forum/sujet?id='.$parent.'#'.$id;
    $retour['FR']   = predata($pseudonyme).' a répondu au sujet du forum '.predata(tronquer_chaine($titre, 50, '...'));
    $retour['EN']   = predata($pseudonyme).' replied to the forum topic '.predata(tronquer_chaine($titre, 50, '...'));
  }
  else if($type === 'forum_new_message')
  {
    $retour['href'] = $chemin.'pages/forum/sujet?id='.$parent.'#'.$id;
    $retour['FR']   = predata($pseudonyme).' a répondu au sujet privé du forum '.predata(tronquer_chaine($titre, 45, '...'));
    $retour['EN']   = predata($pseudonyme).' replied to the private forum topic '.predata(tronquer_chaine($titre, 45, '...'));
  }

  //***************************************************************************************************************************************
  // Suppression d'un message

  else if($type === 'forum_delete_message')
  {
    $retour['css']  = 'mise_a_jour_background';
    $retour['href'] = $chemin.'pages/forum/sujet?id='.$id;
    if($pseudonyme == $titre)
    {
      $retour['FR']   = predata($pseudonyme).' a supprimé un de ses messages sur le forum';
      $retour['EN']   = predata($pseudonyme).' deleted one of his messages on the forum';
    }
    else
    {
      $retour['FR']   = predata($pseudonyme).' a supprimé un message de '.$titre.' sur le forum';
      $retour['EN']   = predata($pseudonyme).' deleted a message by '.$titre.' on the forum';
    }
  }

  //***************************************************************************************************************************************
  // Modification d'un message

  else if($type === 'forum_edit_message')
  {
    $retour['href'] = $chemin.'pages/forum/sujet?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a modifié un message de '.$titre.' sur le forum';
    $retour['EN']   = predata($pseudonyme).' edited a message by '.$titre.' on the forum';
  }

  //***************************************************************************************************************************************
  // Modification d'un sujet

  else if($type === 'forum_edit')
  {
    $retour['href'] = $chemin.'pages/forum/sujet?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a modifié le sujet du forum '.predata(tronquer_chaine($titre, 45, '...'));
  }

  //***************************************************************************************************************************************
  // Suppression d'un sujet

  else if($type === 'forum_delete')
  {
    $retour['css']  = 'mise_a_jour texte_blanc';
    $retour['FR']   = predata($pseudonyme).' a supprimé le sujet du forum '.predata(tronquer_chaine($titre, 45, '...'));
  }




  //*************************************************************************************************************************************//
  //                                                                 NBDB                                                                //
  //*************************************************************************************************************************************//
  // Encyclopédie du web : Nouvelle page

  else if($type === 'nbdb_web_page_new')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/nbdb/web?id='.$id;
    $retour['FR']   = ($titre) ? 'Nouvelle page dans l\'encyclopédie du web : '.predata(tronquer_chaine($titre, 45, '...')) : '';
    $retour['EN']   = ($parent) ? 'New page in the internet encyclopedia : '.predata(tronquer_chaine($parent, 50, '...')) : '';
  }

  //*************************************************************************************************************************************//
  // Encyclopédie du web : Modification d'une page

  else if($type === 'nbdb_web_page_edit')
  {
    $retour['css']  = '';
    $retour['href'] = $chemin.'pages/nbdb/web?id='.$id;
    $retour['FR']   = ($titre) ? 'Page modifiée dans l\'encyclopédie du web : '.predata(tronquer_chaine($titre, 45, '...')) : '';
    $retour['EN']   = ($parent) ? 'Page modified in the internet encyclopedia : '.predata(tronquer_chaine($parent, 50, '...')) : '';
  }

  //*************************************************************************************************************************************//
  // Encyclopédie du web : Suppression d'une page

  else if($type === 'nbdb_web_page_delete')
  {
    $retour['css']  = '';
    $retour['href'] = $chemin.'pages/nbdb/web';
    $retour['FR']   = ($titre) ? 'Page supprimée dans l\'encyclopédie du web : '.predata(tronquer_chaine($titre, 40, '...')) : '';
    $retour['EN']   = ($parent) ? 'Page deleted in the internet encyclopedia : '.predata(tronquer_chaine($parent, 50, '...')) : '';
  }

  //*************************************************************************************************************************************//
  // Dictionnaire du web : Nouvelle entrée

  else if($type === 'nbdb_web_definition_new')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/nbdb/web_dictionnaire?id='.$id;
    $retour['FR']   = ($titre) ? 'Nouvelle entrée dans le dictionnaire du web : '.predata(tronquer_chaine($titre, 45, '...')) : '';
    $retour['EN']   = ($parent) ? 'New entry in the internet dictionary : '.predata(tronquer_chaine($parent, 55, '...')) : '';
  }

  //*************************************************************************************************************************************//
  // Dictionnaire du web : Modification d'une entrée

  else if($type === 'nbdb_web_definition_edit')
  {
    $retour['css']  = '';
    $retour['href'] = $chemin.'pages/nbdb/web_dictionnaire?id='.$id;
    $retour['FR']   = ($titre) ? 'Entrée modifiée dans le dictionnaire du web : '.predata(tronquer_chaine($titre, 45, '...')) : '';
    $retour['EN']   = ($parent) ? 'Entry modified in the internet dictionary : '.predata(tronquer_chaine($parent, 55, '...')) : '';
  }

  //*************************************************************************************************************************************//
  // Dictionnaire du web : Suppression d'une entrée

  else if($type === 'nbdb_web_definition_delete')
  {
    $retour['css']  = '';
    $retour['href'] = $chemin.'pages/nbdb/web_dictionnaire';
    $retour['FR']   = ($titre) ? 'Entrée supprimée dans le dictionnaire du web : '.predata(tronquer_chaine($titre, 40, '...')) : '';
    $retour['EN']   = ($parent) ? 'Entry deleted in the internet dictionary : '.predata(tronquer_chaine($parent, 55, '...')) : '';
  }




  //*************************************************************************************************************************************//
  //                                                          COIN DES ÉCRIVAINS                                                         //
  //*************************************************************************************************************************************//
  // Nouveau texte

  else if($type === 'ecrivains_new')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/ecrivains/texte?id='.$id;
    $retour['FR']   = ($pseudonyme != 'Anonyme') ? predata($pseudonyme).' a publié un texte : '.predata(tronquer_chaine($titre, 70, '...')) : 'Nouveau texte publié : '.predata(tronquer_chaine($titre, 70, '...'));
  }

  //*************************************************************************************************************************************//
  // Modification d'un texte

  else if($type === 'ecrivains_edit')
  {
    $retour['href'] = $chemin.'pages/ecrivains/texte?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a modifié le contenu d\'un texte : '.predata(tronquer_chaine($titre, 50, '...'));
  }

  //*************************************************************************************************************************************//
  // Suppression d'un texte

  else if($type === 'ecrivains_delete')
  {
    $retour['css']  = 'mise_a_jour texte_blanc';
    $retour['FR']   = predata($pseudonyme).' a supprimé un texte du coin des écrivains : '.predata(tronquer_chaine($titre, 40, '...'));
  }

  //*************************************************************************************************************************************//
  // Réaction à un texte

  else if($type === 'ecrivains_reaction_new')
  {
    $retour['href'] = $chemin.'pages/ecrivains/texte?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a réagi au texte '.predata(tronquer_chaine($titre, 70, '...'));
  }
  else if($type === 'ecrivains_reaction_new_anonyme')
  {
    $retour['href'] = $chemin.'pages/ecrivains/texte?id='.$id;
    $retour['FR']   = 'Nouvelle réaction anonyme au texte '.predata(tronquer_chaine($titre, 60, '...'));
  }

  //***************************************************************************************************************************************
  // Suppression d'une réaction à un texte

  else if($type === 'ecrivains_reaction_delete')
  {
    $retour['css']  = 'mise_a_jour_background';
    $retour['href'] = $chemin.'pages/ecrivains/texte?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a supprimé une réaction de '.$titre.' dans le coin des écrivains';
  }

  //***************************************************************************************************************************************
  // Nouveau concours du coin des écrivains

  else if($type === 'ecrivains_concours_new')
  {
    $retour['css']  = 'texte_noir vert_background';
    $retour['href'] = $chemin.'pages/ecrivains/concours?id='.$id;
    $retour['FR']   = 'Nouveau concours du coin des écrivains : '.predata(tronquer_chaine($titre, 50, '...'));
  }

  //***************************************************************************************************************************************
  // Concours du coin des écrivains ouvert aux votes

  else if($type === 'ecrivains_concours_vote')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/ecrivains/concours?id='.$id;
    $retour['FR']   = 'Concours du coin des écrivains ouvert aux votes : '.predata(tronquer_chaine($titre, 40, '...'));
  }

  //***************************************************************************************************************************************
  // Concours du coin des écrivains ouvert aux votes

  else if($type === 'ecrivains_concours_gagnant')
  {
    $retour['css']  = 'texte_noir vert_background';
    $retour['href'] = $chemin.'pages/ecrivains/concours?id='.$id;
    $retour['FR']   = $pseudonyme.' a gagné le concours du coin des écrivains : '.predata(tronquer_chaine($titre, 30, '...'));
  }




  //*************************************************************************************************************************************//
  //                                                                 IRL                                                                 //
  //*************************************************************************************************************************************//
  // Nouvelle IRL

  else if($type === 'irl_new' && !$modlog)
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = 'Nouvelle rencontre IRL planifiée le '.predata($titre);
    $retour['EN']   = 'New real life meetup planned';
  }
  else if($type === 'irl_new')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a crée une nouvelle IRL le '.predata($titre);
  }

  //***************************************************************************************************************************************
  // IRL modifiée

  else if($type === 'irl_edit')
  {
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a modifié l\'IRL du '.predata($titre);
  }

  //***************************************************************************************************************************************
  // Suppression d'une IRL

  else if($type === 'irl_delete')
  {
    $retour['css']  = 'mise_a_jour texte_blanc';
    $retour['FR']   = predata($pseudonyme)." a supprimé l'IRL du ".predata($titre);
  }

  //***************************************************************************************************************************************
  // Nouveau participant à une IRL

  else if($type === 'irl_add_participant' && !$modlog)
  {
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a rejoint l\'IRL du '.predata($titre);
    $retour['EN']   = predata($pseudonyme).' joined a real life meetup';
  }
  else if($type === 'irl_add_participant')
  {
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = predata($parent).' a ajouté '.predata($pseudonyme).' à l\'IRL du '.predata($titre);
  }

  //***************************************************************************************************************************************
  // Participant modifié dans une IRL

  else if($type === 'irl_edit_participant')
  {
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = predata($parent).' a modifié les infos de '.predata($pseudonyme).' dans l\'IRL du '.predata($titre);
  }

  //***************************************************************************************************************************************
  // Participant supprimé d'une IRL

  else if($type === 'irl_del_participant' && !$modlog)
  {
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = predata($pseudonyme).' a quitté l\'IRL du '.predata($titre);
    $retour['EN']   = predata($pseudonyme).' left a real life meetup';
  }
  else if($type === 'irl_del_participant')
  {
    $retour['href'] = $chemin.'pages/irl/irl?id='.$id;
    $retour['FR']   = predata($parent).' a supprimé '.predata($pseudonyme).' de l\'IRL du '.predata($titre);
  }




  //*************************************************************************************************************************************//
  //                                                            MISCELLANÉES                                                             //
  //*************************************************************************************************************************************//
  // Nouvelle miscellanée

  else if($type === 'quote_new_fr')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/quotes/quote?id='.$id;
    $retour['FR']   = 'Miscellanée #'.$id.' ajoutée à la collection';
  }
  else if($type === 'quote_new_en')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/quotes/quote?id='.$id;
    $retour['FR']   = 'Miscellanée anglophone #'.$id.' ajoutée à la collection';
    $retour['EN']   = 'Miscellanea #'.$id.' added to the collection';
  }




  //*************************************************************************************************************************************//
  //                                                            DÉVELOPPEMENT                                                            //
  //*************************************************************************************************************************************//
  // Nouvelle version

  else if($type === 'version')
  {
    $retour['css']  = 'gras texte_blanc positif';
    $retour['href'] = $chemin.'pages/todo/roadmap';
    $retour['FR']   = "Nouvelle version de NoBleme.com : ".predata($titre);
    $retour['EN']   = "New version of NoBleme.com: ".predata($titre);
  }

  //***************************************************************************************************************************************
  // Nouveau devblog

  else if($type === 'devblog')
  {
    $retour['css']  = 'texte_noir vert_background';
    $retour['href'] = $chemin.'pages/devblog/devblog?id='.$id;
    $retour['FR']   = "Nouveau devblog publié : ".predata(tronquer_chaine($titre, 50, '...'));
  }

  //***************************************************************************************************************************************
  // Nouvelle tâche

  else if($type === 'todo_new')
  {
    $retour['href'] = $chemin.'pages/todo/index?id='.$id;
    $retour['FR']   = predata($pseudonyme)." a ouvert une tâche : ".predata(tronquer_chaine($titre, 50, '...'));
  }

  //***************************************************************************************************************************************
  // Tâche résolue

  else if($type === 'todo_fini')
  {
    $retour['css']  = 'texte_noir vert_background_clair';
    $retour['href'] = $chemin.'pages/todo/index?id='.$id;
    $retour['FR']   = "Tache résolue : ".predata(tronquer_chaine($titre, 70, '...'));
  }




  //*************************************************************************************************************************************//
  //                                                         RETOUR DES DONNÉES                                                          //
  //*************************************************************************************************************************************//
  // On remplit un cas par défaut, au cas où le type d'activité demandé ne serait pas encore rempli dans cette fonction

  else
  {
    $retour['css']  = '';
    $retour['href'] = '';
    $retour['FR']   = "Ceci ne devrait pas apparaitre ici, oups (".$type.")";
    $retour['EN']   = "This should not appear here, oops (".$type.")";
  }

  //***************************************************************************************************************************************
  // Si jamais des valeurs de retour sont vides, on leur met une valeur par défaut (par exemple si on ne veut pas styler / pas de lien)

  $retour['css']  = (isset($retour['css']))  ? $retour['css']  : "";
  $retour['href'] = (isset($retour['href'])) ? $retour['href'] : "";
  $retour['FR']   = (isset($retour['FR']))   ? $retour['FR']   : "";
  $retour['EN']   = (isset($retour['EN']))   ? $retour['EN']   : "";

  //***************************************************************************************************************************************
  // Il ne reste plus qu'à renvoyer le tableau contenant les données

  return $retour;
}