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
$qsession = query(" SELECT    nbrpg_session.id              AS 's_id'       ,
                              nbrpg_persos.couleur_chat     AS 'p_couleur'  ,
                              nbrpg_persos.nom              AS 'p_nom'      ,
                              membres.pseudonyme            AS 'p_pseudo'   ,
                              nbrpg_session.monstre_niveau  AS 'm_niveau'   ,
                              nbrpg_persos.niveau           AS 'p_niveau'   ,
                              nbrpg_monstres.nom            AS 'm_nom'      ,
                              nbrpg_session.vie             AS 's_vie'      ,
                              nbrpg_persos.max_vie          AS 'p_viemax'   ,
                              nbrpg_monstres.max_vie        AS 'm_viemax'   ,
                              nbrpg_session.danger          AS 's_danger'   ,
                              nbrpg_session.physique        AS 's_physique' ,
                              nbrpg_session.mental          AS 's_mental'
                    FROM      nbrpg_session
                    LEFT JOIN nbrpg_persos    ON nbrpg_session.FKnbrpg_persos   = nbrpg_persos.id
                    LEFT JOIN membres         ON nbrpg_persos.FKmembres         = membres.id
                    LEFT JOIN nbrpg_monstres  ON nbrpg_session.FKnbrpg_monstres = nbrpg_monstres.id
                    ORDER BY  nbrpg_session.danger  DESC ,
                              nbrpg_persos.nom      DESC ,
                              nbrpg_monstres.nom    DESC ");

// Puis on prépare tout ça pour l'affichage
for($nsession = 0 ; $dsession = mysqli_fetch_array($qsession) ; $nsession++)
{
  $session_id[$nsession]        = $dsession['s_id'];
  $session_perso                = ($dsession['p_nom']) ? 1 : 0;
  $session_couleur[$nsession]   = ($session_perso) ? $dsession['p_couleur'] : '#133742';
  $session_joueur[$nsession]    = ($session_perso) ? $dsession['p_pseudo'] : '';
  $session_nom[$nsession]       = ($session_perso) ? $dsession['p_nom'] : $dsession['m_nom'];
  $session_niveau[$nsession]    = ($session_perso) ? $dsession['p_niveau'] : $dsession['m_niveau'];
  $session_vie[$nsession]       = nbrpg_vierestante($dsession['s_vie'],($session_perso) ? $dsession['p_viemax'] : nbrpg_multiplicateur($dsession['m_viemax'], $dsession['m_niveau']));
  $session_danger[$nsession]    = $dsession['s_danger'];
  $session_physique[$nsession]  = $dsession['s_physique'];
  $session_mental[$nsession]    = $dsession['s_mental'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/**************************************************************************************************************************************/ ?>

<br>
<br>
<div class="align_center gras">
  <p class="plusgros">Session en cours</p>
</div>
<br>
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
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          NIV.
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          HP
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          DAN.
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          PHY.
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          MEN.
        </td>
        <td class="cadre_gris_sous_titre vspaced moinsgros">
          EFFETS
        </td>
      </tr>
    </thead>
    <tbody class="cadre_gris_altc">
      <?php for($i=0;$i<$nsession;$i++) { ?>
      <tr>
        <td class="cadre_gris align_center vspaced gras" style="color:<?=$session_couleur[$i]?>">
          <?=$session_joueur[$i]?>
        </td>
        <td class="cadre_gris align_center vspaced gras" style="color:<?=$session_couleur[$i]?>">
          <?=$session_nom[$i]?>
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
        <td class="cadre_gris align_center vspaced gras">

        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>