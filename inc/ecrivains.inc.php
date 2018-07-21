<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détermine si le membre a le droit de voter dans un concours du coin des écrivains
//
// Utilisation: ecrivains_concours_peut_voter();

function ecrivains_concours_peut_voter()
{
  // Par défaut, l'user n'a pas le droit de voter
  $peut_voter = 0;

  // On vérifie déjà si l'user fait partie de l'équipe administrative - si oui, il peut voter
  if(getadmin() || getsysop() || getmod())
    $peut_voter = 1;

  // Sinon, on vérifie s'il a participé à un concours d'écriture fini dans le passé
  if(!$peut_voter && loggedin())
  {
    // Pour ce faire, on parcourt la liste des anciens participants
    $qcheckconcours = query(" SELECT    membres.id  AS 'm_id'
                              FROM      membres
                              LEFT JOIN ecrivains_texte     ON membres.id                           = ecrivains_texte.FKmembres
                              LEFT JOIN ecrivains_concours  ON ecrivains_texte.FKecrivains_concours = ecrivains_concours.id
                              WHERE     ecrivains_concours.FKmembres_gagnant > 0
                              GROUP BY  membres.id ");

    // Puis on vérifie si l'user est dans la liste
    $membre = $_SESSION['user'];
    while($dcheckconcours = mysqli_fetch_array($qcheckconcours))
    {
      if($membre == $dcheckconcours['m_id'])
        $peut_voter = 1;
    }
  }

  // Et finalement, on renvoie si l'user a le droit de vote ou non
  return $peut_voter;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recompte le nombre de textes liés à un concours d'écriture
//
// $concours est l'id du concours en question
//
// Utilisation: ecrivains_concours_compter_textes($concours);

function ecrivains_concours_compter_textes($concours)
{
  // On compte les textes
  $dconcourscompter = mysqli_fetch_array(query("  SELECT  COUNT(ecrivains_texte.id) AS 'num_textes'
                                                  FROM    ecrivains_texte
                                                  WHERE   ecrivains_texte.FKecrivains_concours = '$concours' "));

  // Et on met à jour le résultat
  $num_textes = $dconcourscompter['num_textes'];
  query(" UPDATE  ecrivains_concours
          SET     ecrivains_concours.num_participants = '$num_textes'
          WHERE   ecrivains_concours.id               = '$concours' ");

  // Au cas où, on renvoie le résultat
  return $num_textes;
}