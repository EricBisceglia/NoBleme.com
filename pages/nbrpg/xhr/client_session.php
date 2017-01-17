<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                     CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE PAR DU XHR                                    */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(!isset($_POST['xhr']))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Cette page n\'est pas censée être chargée toute seule, dehors !</body></html>');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inclusions communes + nbrpg, protection des permissions, et correction du chemin vu qu'on se situe un dossier plus haut que d'habitude
include './../../../inc/includes.inc.php';
include './../../../inc/nbrpg.inc.php';
$chemin_fixed   = substr($chemin,0,-3);
$id_personnage  = nbrpg();
if(!$id_personnage)
  exit();

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Infos sur la session en cours

// On va chercher le contenu de la session
$qsession = query(" SELECT    nbrpg_session.id                AS 's_id'         ,
                              nbrpg_persos.couleur_chat       AS 'p_couleur'    ,
                              nbrpg_persos.nom                AS 'p_nom'        ,
                              membres.pseudonyme              AS 'p_pseudo'     ,
                              nbrpg_session.monstre_niveau    AS 'm_niveau'     ,
                              nbrpg_persos.niveau             AS 'p_niveau'     ,
                              nbrpg_persos.experience         AS 'p_exp'        ,
                              nbrpg_persos.prochain_niveau    AS 'p_exp_next'   ,
                              nbrpg_monstres.nom              AS 'm_nom'        ,
                              nbrpg_persos.niveau_non_assigne AS 'p_niv_na'     ,
                              nbrpg_persos.niveau_combat      AS 'p_niv_combat' ,
                              nbrpg_persos.niveau_magie       AS 'p_niv_magie'  ,
                              nbrpg_persos.niveau_strategie   AS 'p_niv_tank'   ,
                              nbrpg_persos.niveau_medecine    AS 'p_niv_soins'  ,
                              nbrpg_persos.niveau_aventure    AS 'p_niv_utile'  ,
                              nbrpg_monstres.type             AS 'm_type'       ,
                              nbrpg_session.vie               AS 's_vie'        ,
                              nbrpg_persos.max_vie            AS 'p_viemax'     ,
                              nbrpg_monstres.max_vie          AS 'm_viemax'     ,
                              nbrpg_session.danger            AS 's_danger'     ,
                              nbrpg_session.physique          AS 's_physique'   ,
                              nbrpg_session.mental            AS 's_mental'     ,
                              arme.buff_hpmax                 AS 'a_hpmax'      ,
                              arme.buff_hpmax_pourcent        AS 'a_hpmaxp'     ,
                              costume.buff_hpmax              AS 'c_hpmax'      ,
                              costume.buff_hpmax_pourcent     AS 'c_hpmaxp'     ,
                              arme.buff_danger                AS 'a_danger'     ,
                              arme.buff_danger_pourcent       AS 'a_dangerp'    ,
                              costume.buff_danger             AS 'c_danger'     ,
                              costume.buff_danger_pourcent    AS 'c_dangerp'    ,
                              arme.buff_physique              AS 'a_physique'   ,
                              arme.buff_physique_pourcent     AS 'a_physiquep'  ,
                              costume.buff_physique           AS 'c_physique'   ,
                              costume.buff_physique_pourcent  AS 'c_physiquep'  ,
                              arme.buff_mental                AS 'a_mental'     ,
                              arme.buff_mental_pourcent       AS 'a_mentalp'    ,
                              costume.buff_mental             AS 'c_mental'     ,
                              costume.buff_mental_pourcent    AS 'c_mentalp'
                    FROM      nbrpg_session
                    LEFT JOIN nbrpg_persos    ON              nbrpg_session.FKnbrpg_persos        = nbrpg_persos.id
                    LEFT JOIN membres         ON              nbrpg_persos.FKmembres              = membres.id
                    LEFT JOIN nbrpg_monstres  ON              nbrpg_session.FKnbrpg_monstres      = nbrpg_monstres.id
                    LEFT JOIN nbrpg_objets    AS arme     ON  nbrpg_persos.FKnbrpg_objets_arme    = arme.id
                    LEFT JOIN nbrpg_objets    AS costume  ON  nbrpg_persos.FKnbrpg_objets_costume = costume.id
                    ORDER BY  nbrpg_session.danger  DESC ,
                              nbrpg_persos.nom      DESC ,
                              nbrpg_monstres.nom    DESC ");

// Puis on prépare tout ça pour l'affichage
for($nsession = 0 ; $dsession = mysqli_fetch_array($qsession) ; $nsession++)
{
  // On a d'abord besoin de chercher certains effets et certaines armes, on prépare le terrain pour ça
  $session_id                   = $dsession['s_id'];
  $session_effets[$nsession]    = '';
  $buff_hpmax                   = $dsession['a_hpmax'] + $dsession['c_hpmax'];
  $buff_hpmax_p                 = $dsession['a_hpmaxp'] + $dsession['c_hpmaxp'];
  $buff_danger                  = $dsession['a_danger'] + $dsession['c_danger'];
  $buff_danger_p                = $dsession['a_dangerp'] + $dsession['c_dangerp'];
  $buff_physique                = $dsession['a_physique'] + $dsession['c_physique'];
  $buff_physique_p              = $dsession['a_physiquep'] + $dsession['c_physiquep'];
  $buff_mental                  = $dsession['a_mental'] + $dsession['c_mental'];
  $buff_mental_p                = $dsession['a_mentalp'] + $dsession['c_mentalp'];

  // Puis on va chercher les effets
  $qeffets                      = query(" SELECT    nbrpg_session_effets.FKnbrpg_effets             AS 'e_id'           ,
                                                    nbrpg_session_effets.duree_restante             AS 'e_duree'        ,
                                                    nbrpg_effets.duree                              AS 'e_dureemax'     ,
                                                    nbrpg_effets.reduction_effet_par_tour           AS 'e_reduction'    ,
                                                    nbrpg_effets.reduction_effet_par_tour_pourcent  AS 'e_reduction_p'  ,
                                                    nbrpg_effets.buff_hpmax                         AS 'e_hpmax'        ,
                                                    nbrpg_effets.buff_hpmax_pourcent                AS 'e_hpmax_p'      ,
                                                    nbrpg_effets.buff_danger                        AS 'e_danger'       ,
                                                    nbrpg_effets.buff_danger_pourcent               AS 'e_danger_p'     ,
                                                    nbrpg_effets.buff_physique                      AS 'e_physique'     ,
                                                    nbrpg_effets.buff_physique_pourcent             AS 'e_physique_p'   ,
                                                    nbrpg_effets.buff_mental                        AS 'e_mental'       ,
                                                    nbrpg_effets.buff_mental_pourcent               AS 'e_mental_p'
                                          FROM      nbrpg_session_effets
                                          LEFT JOIN nbrpg_effets ON nbrpg_session_effets.FKnbrpg_effets = nbrpg_effets.id
                                          WHERE     nbrpg_session_effets.FKnbrpg_session = '$session_id'
                                          ORDER BY  nbrpg_session_effets.duree_restante DESC ");

  // Et on fait des calculs sur ces effets
  while($deffets = mysqli_fetch_array($qeffets))
  {
    $session_effets[$nsession]  .= nbrpg_format_effet($deffets['e_id'],$deffets['e_duree']);
    $duree_max                  = $deffets['e_dureemax'];
    $duree                      = $deffets['e_duree'];
    $reduction                  = $deffets['e_reduction'];
    $reduction_p                = $deffets['e_reduction_p'];
    $buff_hpmax                 += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_hpmax'],$reduction,$reduction_p);
    $buff_hpmax_p               += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_hpmax_p'],$reduction,$reduction_p);
    $buff_danger                += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_danger'],$reduction,$reduction_p);
    $buff_danger_p              += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_danger_p'],$reduction,$reduction_p);
    $buff_physique              += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_physique'],$reduction,$reduction_p);
    $buff_physique_p            += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_physique_p'],$reduction,$reduction_p);
    $buff_mental                += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_mental'],$reduction,$reduction_p);
    $buff_mental_p              += nbrpg_reduction_effet($duree_max,$duree,$deffets['e_mental_p'],$reduction,$reduction_p);
  }

  // Et reste plus qu'à faire les calculs finaux et formater pour l'affichage
  $session_perso                = ($dsession['p_nom']) ? 1 : 0;
  $session_couleur[$nsession]   = ($session_perso) ? $dsession['p_couleur'] : '#133742';
  $session_joueur[$nsession]    = ($session_perso) ? $dsession['p_pseudo'] : '';
  $session_nom[$nsession]       = ($session_perso) ? $dsession['p_nom'] : $dsession['m_nom'];
  $session_vie[$nsession]       = nbrpg_vierestante($dsession['s_vie'],($session_perso) ? nbrpg_application_effet($dsession['p_viemax'],$buff_hpmax,$buff_hpmax_p) : nbrpg_multiplicateur(nbrpg_application_effet($dsession['m_viemax'],$buff_hpmax,$buff_hpmax_p), $dsession['m_niveau']));
  $session_danger[$nsession]    = nbrpg_application_effet($dsession['s_danger'],$buff_danger,$buff_danger_p);
  $session_physique[$nsession]  = nbrpg_application_effet($dsession['s_physique'],$buff_physique,$buff_physique_p);
  $session_mental[$nsession]    = nbrpg_application_effet($dsession['s_mental'],$buff_mental,$buff_mental_p);
  if($session_perso)
  {
    $session_niveau[$nsession]  = "<span class=\"pointeur tooltip\">".$dsession['p_niveau']."<div class=\"petittooltip\">".$dsession['p_exp']."/".$dsession['p_exp_next']." XP</div></span>";
    $session_details[$nsession]   = nbrpg_classe($dsession['p_niv_combat'],$dsession['p_niv_magie'],$dsession['p_niv_tank'],$dsession['p_niv_soins'],$dsession['p_niv_utile'],$dsession['p_niv_na']);
  }
  else
  {
    $session_niveau[$nsession]  = $dsession['m_niveau'];
    $session_details[$nsession] = nbrpg_monstre($dsession['m_nom'],$dsession['m_type']);
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/**************************************************************************************************************************************/ ?>

<br>
<br>
<div class="align_center">
  <p class="plusgros gras">Session en cours</p>
  <br>
  <p class="pluspetit">Survolez certains titres et contenus du tableau avec votre souris pour obtenir des informations supplémentaires</p>
</div>
<br>

<div class="nbrpg_table_session">
  <table class="cadre_gris indiv">
    <thead>
      <tr>
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          JOUEUR
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          NOM
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros pointeur tooltip">
          NIV.
          <div>
            Le niveau du personnage.<br>
            <br>
            Plus il est élevé, plus le personnage est fort.<br>
            C'est aussi con que ça.
          </div>
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros pointeur tooltip">
          HP
          <div>
            Les points de vie du personnage.<br>
            <br>
            S'ils tombent à 0, le personnage meurt et est exclu de la session.<br>
          </div>
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros pointeur tooltip">
          DAN.
          <div class="grandtooltip">
            Le niveau de danger du personnage.<br>
            <br>
            Pour les joueurs, plus le niveau de danger est élevé, plus le joueur a de chances de se faire attaquer par les adversaires.<br>
            <br>
            Pour les adversaires, plus le niveau de danger est élevé, plus il s'agit d'un adversaire difficile à vaincre (à quelques exceptions près).<br>
            <br>
            Lors d'un combat, c'est le personnage le plus dangereux qui a l'honneur de faire la première action. Les personnages prennent ensuite chacun leur tour, par ordre décroissant de dangerosité.<br>
            <br>
            Augmenter votre niveau de danger vous permet d'agir plus tôt lors des combats, mais vous expose également à plus de chances de subir les attaques adverses.
          </div>
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros pointeur tooltip">
          PHY.
          <div class="grandtooltip">
            La forme physique du personnage.<br>
            <br>
            Plus le physique du personnage est élevé, plus les attaques physiques du personnage seront douloureuses.<br>
          </div>
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros pointeur tooltip">
          MEN.
          <div class="grandtooltip">
            La capacité mentale du personnage.<br>
            <br>
            Plus le mental du personnage est élevé, plus les attaques magiques du personnage seront douloureuses.<br>
          </div>
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros pointeur tooltip">
          EFFETS
          <div class="petittooltip">
            La liste des afflictions, bénédictions, ou autres effets qui sont affectent actuellement le personnage.<br>
            <br>
            Pour voir les détails d'un effet spécifique, passez votre souris dessus et une infobulle s'ouvrira.
          </div>
        </td>
      </tr>
    </thead>
    <tbody class="cadre_gris_altc">
      <?php for($i=0;$i<$nsession;$i++) { ?>
      <tr>
        <td class="cadre_gris align_center vspaced gras" style="color:<?=$session_couleur[$i]?>">
          <?=$session_joueur[$i]?>
        </td>
        <td class="cadre_gris align_center vspaced" style="color:<?=$session_couleur[$i]?>">
          <span class="pointeur tooltip">
            <span class="gras"><?=$session_nom[$i]?></span>
            <div class="petittooltip">
              <?=$session_details[$i]?>
            </div>
          </span>
        </td>
        <td class="cadre_gris align_center vspaced gras">
          <?=$session_niveau[$i]?>
        </td>
        <td class="cadre_gris align_center vspaced gras">
          <?=$session_vie[$i]?>
        </td>
        <td class="cadre_gris align_center vspaced gras">
          <?=$session_danger[$i]?>
        </td>
        <td class="cadre_gris align_center vspaced gras">
          <?=$session_physique[$i]?>
        </td>
        <td class="cadre_gris align_center vspaced gras">
          <?=$session_mental[$i]?>
        </td>
        <td class="cadre_gris align_center vspaced">
          <?=$session_effets[$i]?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>