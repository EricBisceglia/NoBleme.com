<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page retournant des informations sur un log en particulier pour l'afficher dans l'activité récente et le log de modération
//
// Variables qu'il renvoie pour l'activité récente, dans un array :
// $description_class[$nactrec]  - CSS de la ligne de l'activité récente
// $description_action[$nactrec] - Description de l'activité
//
// Ainsi que pour le log de modération, toujours dans le même array :
// $description_diff[$nactrec]   - Différences stockées dans le log, togglable seulement s'il est != ''
// $description_raison[$nactrec] - Justification du log, togglable seulement s'il est != ''

// On commence par aller chercher toute l'activité récente
$qactrec = "    SELECT    activite.id           ,
                          activite.timestamp    ,
                          activite.pseudonyme   ,
                          activite.FKmembres    ,
                          activite.action_type  ,
                          activite.action_id    ,
                          activite.action_titre ,
                          activite.parent_id    ,
                          activite.parent_titre ,
                          activite.justification
                FROM      activite              ";
// Activité récente ou log de modération
if(isset($_GET['mod']))
  $qactrec .= " WHERE     activite.log_moderation = 1 ";
else
  $qactrec .= " WHERE     activite.log_moderation = 0 ";
// On rajoute la recherche si y'en a une
if(isset($_POST['activite_action']))
{
  $activite_action = postdata($_POST['activite_action']);
  if($activite_action != 'user')
    $qactrec .= " AND      activite.action_type LIKE '%".$activite_action."%'";
  else
    $qactrec .= " AND      (activite.action_type LIKE 'register'
                  OR        activite.action_type LIKE 'profil%'
                  OR        activite.action_type LIKE 'ban'
                  OR        activite.action_type LIKE 'unban' )";
}
// On trie
$qactrec .= "   ORDER BY  activite.timestamp DESC ";
// On décide combien on en select
if(isset($_POST['activite_num']))
{
  $activite_limit = postdata($_POST['activite_num']);
  $qactrec .= " LIMIT     ".$activite_limit;
}
else
  $qactrec .= " LIMIT     100 ";
// On balance la requête
$qactrec = query($qactrec);

// Et on prépare les données comme il se doit
for($nactrec = 0 ; $dactrec = mysqli_fetch_array($qactrec) ; $nactrec++)
{
  // ID pour suppression et date de l'action
  $actid[$nactrec]        = $dactrec['id'];
  $date_action[$nactrec]  = ilya($dactrec['timestamp']);

  // Puis on passe au traitement au cas par cas...


  //*************************************************************************************************************************************//
  //                                                      ACTIVITÉ GÉNÉRALE DU SITE                                                      //
  //*************************************************************************************************************************************//

  //*************************************************************************************************************************************//
  // Nouvelle version
  if($dactrec['action_type'] === 'version')
  {
    $description_class[$nactrec]  = 'gras texte_blanc sysop';
    $description_action[$nactrec] = 'Nouvelle version de NoBleme.com publiée : <a class="nolink texte_blanc gras" href="'.$chemin.'pages/todo/roadmap">Version '.$dactrec['action_titre'].'</a>';
  }




  //*************************************************************************************************************************************//
  //                                                      ACTIVITÉ LIÉE AUX MEMBRES                                                      //
  //*************************************************************************************************************************************//

  //*************************************************************************************************************************************//
  // Nouvel utilisateur
  else if($dactrec['action_type'] === 'register')
  {
    $description_class[$nactrec]  = 'nobleme_background';
    $description_action[$nactrec] = 'Un nouvel utilisateur s\'est inscrit sur NoBleme sous le pseudonyme <a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
  }


  //*************************************************************************************************************************************//
  // Utilisateur modifie son profil
  else if($dactrec['action_type'] === 'profil')
  {
    $description_class[$nactrec]  = '';
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> a modifié son profil public';
  }


  //*************************************************************************************************************************************//
  // Mot de passe d'un user modifié par un admin
  else if($dactrec['action_type'] === 'editpass')
  {
    $description_class[$nactrec]  = 'mise_a_jour texte_blanc';
    $description_action[$nactrec] = '<a class="nolink texte_blanc gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a modifié le mot de passe de <a class="nolink texte_blanc gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
    $description_raison[$nactrec] = '';
    $description_diff[$nactrec]   = '';
  }


  //*************************************************************************************************************************************//
  // Profil d'un user modifié par un admin
  else if($dactrec['action_type'] === 'profil_edit')
  {
    // Log de modération
    $description_class[$nactrec]  = 'sysop texte_blanc';
    $description_action[$nactrec] = '<a class="nolink texte_blanc gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a modifié le profil public de <a class="nolink texte_blanc gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
    $description_raison[$nactrec] = 'Raison de la modification : <span class="souligne">'.bbcode(destroy_html($dactrec['justification']))."</span>";

    // Diff
    $qdiff = query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC ");
    $difftemp = '';
    while($ddiff = mysqli_fetch_array($qdiff))
      $difftemp .= '<span class="gras">'.$ddiff['titre_diff'].' :</span> '.bbcode(destroy_html($ddiff['diff'])).'<br>';
    if($difftemp)
      $description_diff[$nactrec] = '<span class="gras souligne">Changements (le <del>&nbsp;rouge&nbsp;</del> a été retiré, le <ins>&nbsp;vert&nbsp;</ins> a été ajouté) :</span><br><br>'.$difftemp;
    else
      $description_diff[$nactrec] = 'Aucune modification apparente. Il est possible que '.$dactrec['parent_titre'].' ait juste appuyé sur Modifer sans rien changer. C\'est pas super malin, parce que '.$dactrec['pseudonyme'].' a reçu une notification lui disant que son profil a été changé. Au cas où, on crée quand même un log de modération.';
  }


  //*************************************************************************************************************************************//
  // Utilisateur banni
  else if($dactrec['action_type'] === 'ban')
  {
    if(!isset($_GET['mod']))
    {
      // Activité récente
      $description_class[$nactrec]  = 'mise_a_jour_background';
      $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres']. '">'.$dactrec['pseudonyme'].'</a> a été <a class="dark blank gras" href="'.$chemin.'pages/nobleme/pilori">banni</a> pendant '.$dactrec['action_id'].' jour(s)';
    } else {
      // Log de modération
      $description_class[$nactrec]  = 'mise_a_jour texte_blanc';
      $description_action[$nactrec] = '<a class="texte_blanc nolink gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a banni <a class="texte_blanc nolink gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> pendant '.$dactrec['action_id'].' jour(s)';
      $description_raison[$nactrec] = 'Raison du ban : <span class="souligne">'.bbcode(destroy_html($dactrec['justification']))."</span>";
      $description_diff[$nactrec]   = '';
    }
  }



  //*************************************************************************************************************************************//
  // Utilisateur débanni
  else if($dactrec['action_type'] === 'deban')
  {
    if(!isset($_GET['mod']))
    {
      // Activité récente
      $description_class[$nactrec]  = 'vert_background_clair';
      $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres']. '">'.$dactrec['pseudonyme'].'</a> a été <a class="dark blank gras" href="'.$chemin.'pages/nobleme/pilori">débanni</a>';
    } else {
      // Log de modération
      $description_class[$nactrec]  = 'vert_background';
      $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a débanni <a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
      $description_raison[$nactrec] = 'Raison du déban : <span class="souligne">'.bbcode(destroy_html($dactrec['justification']))."</span>";
      $description_diff[$nactrec]   = '';
    }
  }




  //*************************************************************************************************************************************//
  //                                                    IRLS ET PARTICIPANTS AUX IRLS                                                    //
  //*************************************************************************************************************************************//

  // Nouvelle IRL
  else if($dactrec['action_type'] === 'new_irl')
  {
    if(!isset($_GET['mod']))
    {
      // Activité récente
      $description_class[$nactrec]  = 'vert_background_clair';
      $description_action[$nactrec] = 'Nouvelle rencontre IRL planifiée : <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">'.$dactrec['action_titre'].'</a>';
    } else {
      // Log de modération
      $description_class[$nactrec]  = 'vert_background_clair';
      $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> a crée une nouvelle IRL: <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">'.$dactrec['action_titre'].'</a>';
      $description_diff[$nactrec]   = '';
      $description_raison[$nactrec] = '';
    }
  }


  // IRL supprimée
  else if($dactrec['action_type'] === 'delete_irl')
  {
    // Log de modération
    $description_class[$nactrec]  = 'mise_a_jour_background';
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> a supprimé une IRL: '.$dactrec['action_titre'];
    $description_raison[$nactrec] = (!$dactrec['justification']) ? '' : 'Raison de la suppression : <span class="souligne">'.bbcode(destroy_html($dactrec['justification']))."</span>";

    // Diff
    $qdiff = query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC ");
    $description_diff[$nactrec]   = '<span class="gras souligne">Contenu de l\'IRL avant sa suppression :</span> <br><br>';
    while($ddiff = mysqli_fetch_array($qdiff))
      $description_diff[$nactrec] .= '<span class="gras">'.$ddiff['titre_diff'].' :</span> '.bbcode(destroy_html($ddiff['diff'])).'<br>';
  }


  // IRL modifiée
  else if($dactrec['action_type'] === 'edit_irl')
  {
    // Log de modération
    $description_class[$nactrec]  = '';
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> a modifié une IRL: <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">'.$dactrec['action_titre'].'</a>';
    $description_raison[$nactrec] = '';

    // Diff
    $qdiff = query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC ");
    $difftemp = '';
    while($ddiff = mysqli_fetch_array($qdiff))
      $difftemp .= '<span class="gras">'.$ddiff['titre_diff'].' :</span> '.bbcode(destroy_html($ddiff['diff'])).'<br>';
    if($difftemp)
      $description_diff[$nactrec] = '<span class="gras souligne">Changements (le <del>&nbsp;rouge&nbsp;</del> a été retiré, le <ins>&nbsp;vert&nbsp;</ins> a été ajouté) :</span><br><br>'.$difftemp;
    else
      $description_diff[$nactrec] = 'Aucune modification apparente. Il est possible que '.$dactrec['pseudonyme'].' ait juste appuyé sur Modifer sans rien changer. Au cas où, on crée quand même un log de modération.';
  }


  // Nouveau participant à une IRL
  else if($dactrec['action_type'] === 'add_irl_participant')
  {
    if(!isset($_GET['mod']))
    {
      // Activité récente
      $tempadduser = ($dactrec['FKmembres'] == 0) ? $dactrec['pseudonyme'] : '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
      $description_class[$nactrec]  = '';
      $description_action[$nactrec] = $tempadduser.' a rejoint <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">l\'IRL du '.$dactrec['action_titre'].'</a>';
    }
    else
    {
      // Log de modération
      $tempadduser = ($dactrec['FKmembres'] == 0) ? $dactrec['pseudonyme'] : '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
      $description_class[$nactrec]  = '';
      $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a ajouté '.$tempadduser.' à <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">l\'IRL du '.$dactrec['action_titre'].'</a>';
      $description_diff[$nactrec]   = '';
      $description_raison[$nactrec] = '';
    }
  }


  // Participant modifié dans une IRL
  else if($dactrec['action_type'] === 'edit_irl_participant')
  {
    // Log de modération
    $tempedituser = ($dactrec['FKmembres'] == 0) ? $dactrec['pseudonyme'] : '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
    $description_class[$nactrec]  = '';
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a modifié les détails de '.$tempedituser.' dans <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">l\'IRL du '.$dactrec['action_titre'].'</a>';
    $description_raison[$nactrec] = '';

    // Diff
    $qdiff = query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC ");
    $difftemp = '';
    while($ddiff = mysqli_fetch_array($qdiff))
      $difftemp .= '<span class="gras">'.$ddiff['titre_diff'].' :</span> '.bbcode(destroy_html($ddiff['diff'])).'<br>';
    if($difftemp)
      $description_diff[$nactrec] = '<span class="gras souligne">Changements (le <del>&nbsp;rouge&nbsp;</del> a été retiré, le <ins>&nbsp;vert&nbsp;</ins> a été ajouté) :</span><br><br>'.$difftemp;
    else
      $description_diff[$nactrec] = 'Aucune modification apparente. Il est possible que '.$dactrec['pseudonyme'].' ait juste appuyé sur Modifer sans rien changer. Au cas où, on crée quand même un log de modération.';
  }


  // Participant supprimé d'une IRL
  else if($dactrec['action_type'] === 'del_irl_participant')
  {
    if(!isset($_GET['mod']))
    {
      // Activité récente
      $tempdeluser = ($dactrec['FKmembres'] == 0) ? $dactrec['pseudonyme'] : '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
      $description_class[$nactrec]  = '';
      $description_action[$nactrec] = $tempdeluser.' a quitté <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">l\'IRL du '.$dactrec['action_titre'].'</a>';
    }
    else
    {
      // Log de modération
      $tempdeluser = ($dactrec['FKmembres'] == 0) ? $dactrec['pseudonyme'] : '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a>';
      $description_class[$nactrec]  = 'mise_a_jour_background';
      $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a supprimé '.$tempdeluser.' de <a class="dark blank gras" href="'.$chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'].'">l\'IRL du '.$dactrec['action_titre'].'</a>';
      $description_raison[$nactrec] = '';

      // Diff
      $qdiff = query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC ");
      $description_diff[$nactrec]   = '<span class="gras souligne">Infos sur '.$tempdeluser.' avant sa suppression :</span> <br><br>';
      while($ddiff = mysqli_fetch_array($qdiff))
        $description_diff[$nactrec] .= '<span class="gras">'.$ddiff['titre_diff'].' :</span> '.bbcode(destroy_html($ddiff['diff'])).'<br>';
    }
  }




  //*************************************************************************************************************************************//
  //                                                      DEVBLOGS ET COMMENTAIRES                                                       //
  //*************************************************************************************************************************************//

  // Nouveau devblog
  else if($dactrec['action_type'] === 'new_devblog')
  {
    $description_class[$nactrec]  = 'vert_background_clair';
    if(strlen($dactrec['action_titre']) > 70)
      $devblog_titre = substr(html_entity_decode($dactrec['action_titre']),0,68).'...';
    else
      $devblog_titre = $dactrec['action_titre'];
    $description_action[$nactrec] = 'Nouveau devblog publié : <a class="dark blank gras" href="'.$chemin.'pages/devblog/blog.php?id='.$dactrec['action_id'].'">'.$devblog_titre.'</a>';
  }


  // Nouveau commentaire dans un devblog
  else if($dactrec['action_type'] === 'new_devblog_comm')
  {
    $description_class[$nactrec]  = '';
    if(strlen($dactrec['parent_titre']) > 45)
      $devblog_titre = substr(html_entity_decode($dactrec['parent_titre']),0,43).'...';
    else
      $devblog_titre = $dactrec['parent_titre'];
    $description_action[$nactrec] = '<a class="dark blank gras gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> a commenté le devblog <a class="dark blank gras gras" href="'.$chemin.'pages/devblog/blog?id='.$dactrec['parent_id'].'">'.$devblog_titre.'</a>';
  }


  // Modification d'un commentaire dans un devblog
  else if($dactrec['action_type'] === 'edit_devblog_comm')
  {
    // Log de modération
    $description_class[$nactrec]  = '';
    if(strlen($dactrec['action_titre']) > 25)
      $devblog_titre = substr(html_entity_decode($dactrec['action_titre']),0,22).'...';
    else
      $devblog_titre = $dactrec['action_titre'];
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a modifié un commentaire de <a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> du devblog <a class="dark blank gras" href="'.$chemin.'pages/devblog/blog?id='.$dactrec['action_id'].'">'.$devblog_titre.'</a>';
    if($dactrec['justification'])
      $description_raison[$nactrec] = 'Raison de la modification : <span class="souligne">'.bbcode(destroy_html($dactrec['justification'])).'</span>';
    else
      $description_raison[$nactrec] = '';

    // Diff
    $ddiff = mysqli_fetch_array(query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC "));
    if(strpos($ddiff['diff'],'[ins]') || strpos($ddiff['diff'],'[del]') )
      $description_diff[$nactrec] = '<span class="gras souligne">Changements (le <del>&nbsp;rouge&nbsp;</del> a été retiré, le <ins>&nbsp;vert&nbsp;</ins> a été ajouté) :</span><br><br><span class="gras">'.$ddiff['titre_diff'].' </span> '.bbcode($ddiff['diff']).'<br>';
    else
      $description_diff[$nactrec] = 'Aucune modification apparente. Il est possible que '.$dactrec['pseudonyme'].' ait juste appuyé sur Modifer sans rien changer. Au cas où, on crée quand même un log de modération.';
  }


  // Suppression d'un commentaire dans un devblog
  else if($dactrec['action_type'] === 'del_devblog_comm')
  {
    // Log de modération
    $description_class[$nactrec]  = 'mise_a_jour_background';
    if(strlen($dactrec['action_titre']) > 25)
      $devblog_titre = substr(html_entity_decode($dactrec['action_titre']),0,22).'...';
    else
      $devblog_titre = $dactrec['action_titre'];
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a supprimé un commentaire de <a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> du devblog <a class="dark blank gras" href="'.$chemin.'pages/devblog/blog?id='.$dactrec['action_id'].'">'.$devblog_titre.'</a>';
    if($dactrec['justification'])
      $description_raison[$nactrec] = 'Raison de la suppression : <span class="souligne">'.bbcode(destroy_html($dactrec['justification'])).'</span>';
    else
      $description_raison[$nactrec] = '';

    // Diff
    $ddiff = mysqli_fetch_array(query(" SELECT diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."'"));
    $description_diff[$nactrec]   = '<span class="gras souligne">Contenu du commentaire supprimé :</span> <br><br>'.bbcode(nl2br_fixed($ddiff['diff'])).'<br>';
  }




  //*************************************************************************************************************************************//
  //                                                        TODOS ET COMMENTAIRES                                                        //
  //*************************************************************************************************************************************//

  // Nouveau todo
  else if($dactrec['action_type'] === 'new_todo')
  {
    $description_class[$nactrec]  = 'nobleme_background';
    if(strlen($dactrec['action_titre']) > 65)
      $todo_titre = substr(html_entity_decode($dactrec['action_titre']),0,62).'...';
    else
      $todo_titre = $dactrec['action_titre'];
    $description_action[$nactrec] = '<a class="dark blank gras gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> a ouvert un nouveau ticket : <a class="dark blank gras" href="'.$chemin.'pages/todo/index.php?id='.$dactrec['action_id'].'">'.$todo_titre.'</a>';
  }


  // Todo fini
  else if($dactrec['action_type'] === 'fini_todo')
  {
    $description_class[$nactrec]  = 'vert_background_clair';
    if(strlen($dactrec['action_titre']) > 80)
      $todo_titre = substr(html_entity_decode($dactrec['action_titre']),0,67).'...';
    else
      $todo_titre = $dactrec['action_titre'];
    $description_action[$nactrec] = 'Ticket résolu : <a class="dark blank gras" href="'.$chemin.'pages/todo/index.php?id='.$dactrec['action_id'].'">'.$todo_titre.'</a>';
  }


  // Nouveau commentaire sur un todo
  else if($dactrec['action_type'] === 'new_todo_comm')
  {
    $description_class[$nactrec]  = '';
    if(strlen($dactrec['parent_titre']) > 65)
      $todo_titre = substr(html_entity_decode($dactrec['parent_titre']),0,62).'...';
    else
      $todo_titre = $dactrec['parent_titre'];
    $description_action[$nactrec] = '<a class="dark blank gras gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> a commenté le ticket <a class="dark blank gras" href="'.$chemin.'pages/todo/index.php?id='.$dactrec['parent_id'].'">'.$todo_titre.'</a>';
  }


  // Modification d'un commentaire sur un ticket
  else if($dactrec['action_type'] === 'edit_todo_comm')
  {
    // Log de modération
    $description_class[$nactrec]  = '';
    if(strlen($dactrec['action_titre']) > 30)
      $todo_titre = substr(html_entity_decode($dactrec['action_titre']),0,28).'...';
    else
      $todo_titre = $dactrec['action_titre'];
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a modifié un commentaire de <a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> du ticket <a class="dark blank gras" href="'.$chemin.'pages/todo/index?id='.$dactrec['action_id'].'">'.$todo_titre.'</a>';
    if($dactrec['justification'])
      $description_raison[$nactrec] = 'Raison de la modification : <span class="souligne">'.bbcode(destroy_html($dactrec['justification'])).'</span>';
    else
      $description_raison[$nactrec] = '';

    // Diff
    $ddiff = mysqli_fetch_array(query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC "));
    if(strpos($ddiff['diff'],'[ins]') || strpos($ddiff['diff'],'[del]') )
      $description_diff[$nactrec] = '<span class="gras souligne">Changements (le <del>&nbsp;rouge&nbsp;</del> a été retiré, le <ins>&nbsp;vert&nbsp;</ins> a été ajouté) :</span><br><br><span class="gras">'.$ddiff['titre_diff'].' </span> '.bbcode($ddiff['diff']).'<br>';
    else
      $description_diff[$nactrec] = 'Aucune modification apparente. Il est possible que '.$dactrec['pseudonyme'].' ait juste appuyé sur Modifer sans rien changer. Au cas où, on crée quand même un log de modération.';
  }


  // Suppression d'un commentaire sur un ticket
  else if($dactrec['action_type'] === 'del_todo_comm')
  {
    // Log de modération
    $description_class[$nactrec]  = 'mise_a_jour_background';
    if(strlen($dactrec['action_titre']) > 30)
      $todo_titre = substr(html_entity_decode($dactrec['action_titre']),0,28).'...';
    else
      $todo_titre = $dactrec['action_titre'];
    $description_action[$nactrec] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['parent_id'].'">'.$dactrec['parent_titre'].'</a> a supprimé un commentaire de <a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$dactrec['FKmembres'].'">'.$dactrec['pseudonyme'].'</a> du ticket <a class="dark blank gras" href="'.$chemin.'pages/todo/index?id='.$dactrec['action_id'].'">'.$todo_titre.'</a>';
    if($dactrec['justification'])
      $description_raison[$nactrec] = 'Raison de la suppression : <span class="souligne">'.bbcode(destroy_html($dactrec['justification'])).'</span>';
    else
      $description_raison[$nactrec] = '';

    // Diff
    $ddiff = mysqli_fetch_array(query(" SELECT diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."'"));
    $description_diff[$nactrec]   = '<span class="gras souligne">Contenu du commentaire supprimé :</span> <br><br>'.bbcode(nl2br_fixed($ddiff['diff'])).'<br>';
  }




  //*************************************************************************************************************************************//
  //                           SI ON NE TROUVE RIEN, ON A UN PROBLÈME, ET ON LE FAIT SAVOIR EN ENGUEULANT BAD                            //
  //*************************************************************************************************************************************//
  // Parce que je suis masochiste, je suis prêt à m'humilier en gras all caps sur fond rouge en prod si j'ai oublié de traiter un élément
  else
  {
    $description_class[$nactrec]  = ' erreur gras texte_blanc';
    $description_action[$nactrec] = 'Action inconnue : "'.$dactrec['action_type'].'"... apprends à bien faire ton boulot, Bad >:(';
    $description_diff[$nactrec]   = '';
    $description_raison[$nactrec] = '';
  }
}