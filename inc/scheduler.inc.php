<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Cette page permet à NoBleme d'avoir une sorte de cron maison                                                                          //
// Des tâches planifiées sont enregistrées dans la table automatisation via la fonction automatisation(type, id, timestamp)              //
// Chaque fois qu'un visiteur charge une page de NoBleme, la table est parcourue pour vérifier s'il y a une action à faire               //
// Les actions sont à usage unique: une fois une action effectée via cette page, elle est supprimée de la table                          //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Crée une entrée dans la table automatisation, afin qu'elle soit exécutée à une date prévue
//
// action_type                    est le type d'action à automatiser
// action_id                      est l'id de l'action à déclencher
// action_timestamp               est le moment auquel déclencher cette action
// action_description (optionnel) est une description de l'action à automatiser
//
// Utilisation: automatisation('ecrivains_concours_fin', 5, strtotime('2005-03-19'));

function automatisation($action_type, $action_id, $action_timestamp, $action_description=NULL)
{
  // Si jamais l'action est déjà planifiée, on l'écrase
  query(" DELETE FROM automatisation
          WHERE       automatisation.action_id    =     '$action_id'
          AND         automatisation.action_type  LIKE  '$action_type' ");

  // Puis on planifie la nouvelle action
  query(" INSERT INTO automatisation
          SET         automatisation.action_id          = '$action_id'          ,
                      automatisation.action_type        = '$action_type'        ,
                      automatisation.action_description = '$action_description' ,
                      automatisation.action_timestamp   = '$action_timestamp'   ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Traitement des contenus de la table automatisation

// On commence par aller chercher s'il y a des tâches planifiées en attente d'exécution
$timestamp        = time();
$qautomatisation  = query(" SELECT  system_scheduler.id               AS 'a_id'     ,
                                    system_scheduler.task_id          AS 'a_action' ,
                                    system_scheduler.task_type        AS 'a_type'   ,
                                    system_scheduler.task_description AS 'a_desc'
                            FROM    system_scheduler
                            WHERE   system_scheduler.planned_at       <= '$timestamp' ");

// S'il y a des tâches à effectuer, on s'en occupe
while($dautomatisation = mysqli_fetch_array($qautomatisation))
{
  // On prépare les infos liées à la tâche à automatiser
  $automatisation_id        = $dautomatisation['a_id'];
  $automatisation_action_id = $dautomatisation['a_action'];
  $automatisation_type      = $dautomatisation['a_type'];
  $automatisation_desc      = postdata($dautomatisation['a_desc'], 'string');
  $automatisation_desc_raw  = $dautomatisation['a_desc'];




  //*************************************************************************************************************************************//
  //                                                   CONCOURS DU COIN DES ÉCRIVAINS                                                    //
  //*************************************************************************************************************************************//
  // Fin de la participation au concours, ouverture des votes

  if($automatisation_type == 'ecrivains_concours_vote')
  {
    // On vérifie que le concours existe
    $qcheckconcours = mysqli_fetch_array(query("  SELECT  ecrivains_concours.titre AS 'c_titre'
                                                  FROM    ecrivains_concours
                                                  WHERE   ecrivains_concours.id = '$automatisation_action_id' "));

    if($qcheckconcours['c_titre'])
    {
      // Entrée dans l'activité récente
      $concours_titre = postdata($qcheckconcours['c_titre'], 'string');
      activite_nouveau('ecrivains_concours_vote', 0, 0, 0, $automatisation_action_id, $concours_titre);

      // Annonce de l'ouverture des votes sur IRC
      $concours_titre_raw = $qcheckconcours['c_titre'];
      ircbot($chemin, 'Fin de la participation au concours du coin des écrivains : '.$concours_titre_raw.' - Les votes sont ouverts pendant 10 jours : '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$automatisation_action_id, '#NoBleme');
      ircbot($chemin, 'Fin de la participation au concours du coin des écrivains : '.$concours_titre_raw.' - Les votes sont ouverts pendant 10 jours : '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$automatisation_action_id, '#write');

      // Automatisation de la date limite pour voter (dans 10 jours à 22:00)
      $automatisation_date = strtotime(date('d-m-Y', strtotime("+10 days")).' 22:00:00');
      automatisation('ecrivains_concours_fin', $automatisation_action_id, $automatisation_date);
    }
  }


  //*************************************************************************************************************************************//
  // Fin du vote et du concours

  else if($automatisation_type == 'ecrivains_concours_fin')
  {
    // On vérifie que le concours existe
    $qcheckconcours = mysqli_fetch_array(query("  SELECT  ecrivains_concours.titre AS 'c_titre'
                                                  FROM    ecrivains_concours
                                                  WHERE   ecrivains_concours.id = '$automatisation_action_id' "));

    // Calcul du gagnant du concours
    if($qcheckconcours['c_titre'])
    {
      // On va chercher les textes ayant participé au concours, dans un ordre aléatoire pour tirer un gagnant au sort en cas d'égalité
      $qtextes = query("  SELECT    ecrivains_texte.id AS 't_id'
                          FROM      ecrivains_texte
                          WHERE     ecrivains_texte.FKecrivains_concours = '$automatisation_action_id'
                          ORDER BY  RAND() ");

      // On prépare les éléments pour la comparaison
      $plus_haute_note  = 0;
      $id_texte_gagnant = 0;

      // On va chercher les notes correspondant aux textes
      for($ntextes = 0; $dtextes = mysqli_fetch_array($qtextes); $ntextes++)
      {
        $id_texte = $dtextes['t_id'];
        $dnote    = mysqli_fetch_array(query("  SELECT  SUM(ecrivains_concours_vote.poids_vote)  AS 'c_note'
                                                FROM    ecrivains_concours_vote
                                                WHERE   ecrivains_concours_vote.FKecrivains_concours  = '$automatisation_action_id'
                                                AND     ecrivains_concours_vote.FKecrivains_texte     = '$id_texte' "));

        // On détermine si ce texte est le gagnant
        if($dnote['c_note'] > $plus_haute_note)
        {
          $plus_haute_note  = $dnote['c_note'];
          $id_texte_gagnant = $id_texte;
        }
      }

      // On met à jour le concours avec le texte gagnant
      query(" UPDATE  ecrivains_concours
              SET     ecrivains_concours.FKecrivains_texte_gagnant  = '$id_texte_gagnant'
              WHERE   ecrivains_concours.id                         = '$automatisation_action_id' ");

      // On va chercher des infos sur le texte gagnant
      $dgagnant = mysqli_fetch_array(query("  SELECT    ecrivains_texte.titre   AS 't_titre'  ,
                                                        ecrivains_texte.anonyme AS 't_anon'   ,
                                                        membres.id              AS 'm_id'     ,
                                                        membres.pseudonyme      AS 'm_pseudo'
                                              FROM      ecrivains_texte
                                              LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
                                              WHERE     ecrivains_texte.id = '$id_texte_gagnant' "));

      // Puis on met à jour les infos sur le gagnant si le texte n'est pas anonyme
      if(!$dgagnant['t_anon'])
      {
        $id_membre_gagnant = $dgagnant['m_id'];
        query(" UPDATE  ecrivains_concours
                SET     ecrivains_concours.FKmembres_gagnant  = '$id_membre_gagnant'
                WHERE   ecrivains_concours.id                 = '$automatisation_action_id' ");
      }

      // Entrée dans l'activité récente
      $concours_titre   = postdata($qcheckconcours['c_titre'], 'string');
      $concours_gagnant = ($dgagnant['t_anon']) ? 'Un auteur anonyme' : predata($dgagnant['m_pseudo']);
      activite_nouveau('ecrivains_concours_gagnant', 0, 0, $concours_gagnant, $automatisation_action_id, $concours_titre);

      // Annonce du gagnant sur IRC
      $concours_titre_raw   = $qcheckconcours['c_titre'];
      $concours_gagnant_raw = ($dgagnant['t_anon']) ? 'Un auteur anonyme' : $dgagnant['m_pseudo'];
      ircbot($chemin, $concours_gagnant_raw.' a gagné le concours du coin des écrivains  : '.$concours_titre_raw.' - '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$automatisation_action_id, '#NoBleme');
      ircbot($chemin, $concours_gagnant_raw.' a gagné le concours du coin des écrivains  : '.$concours_titre_raw.' - '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$automatisation_action_id, '#write');
    }
  }




  //*************************************************************************************************************************************//
  //                                                           FIN DE LA TÂCHE                                                           //
  //*************************************************************************************************************************************//
  // Maintenant que la tâche est effectuée, on peut la supprimer

  query(" DELETE FROM   automatisation
          WHERE         automatisation.id = '$automatisation_id' ");
}