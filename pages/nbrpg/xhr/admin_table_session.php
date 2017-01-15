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
$chemin_fixed = substr($chemin,0,-3);
adminonly();

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Participants à la session en cours

// On va chercher les infos sur les participants
$qsession = query(" SELECT    nbrpg_session.id        AS 'session_id'   ,
                              nbrpg_persos.nom        AS 'perso_nom'    ,
                              membres.pseudonyme      AS 'perso_joueur' ,
                              nbrpg_monstres.nom      AS 'monstre_nom'  ,
                              nbrpg_session.vie       AS 'session_hp'   ,
                              nbrpg_persos.max_vie    AS 'perso_viemax' ,
                              nbrpg_monstres.max_vie  AS 'monstre_viemax'
                    FROM      nbrpg_session
                    LEFT JOIN nbrpg_persos    ON nbrpg_session.FKnbrpg_persos   = nbrpg_persos.id
                    LEFT JOIN membres         ON nbrpg_persos.FKmembres         = membres.id
                    LEFT JOIN nbrpg_monstres  ON nbrpg_session.FKnbrpg_monstres = nbrpg_monstres.id
                    ORDER BY  nbrpg_session.danger  DESC ,
                              nbrpg_persos.nom      DESC ,
                              nbrpg_monstres.nom    DESC ");

// Préparation des données pour l'affichage
for($nsession = 0 ; $dsession = mysqli_fetch_array($qsession) ; $nsession++)
{
  $session_id[$nsession]      = $dsession['session_id'];
  $session_perso              = ($dsession['perso_nom']) ? 1 : 0;
  $session_joueur[$nsession]  = ($session_perso) ? $dsession['perso_joueur'] : 'Monstre';
  $session_nom[$nsession]     = ($session_perso) ? $dsession['perso_nom'] : $dsession['monstre_nom'];
  $session_vie[$nsession]     = nbrpg_vierestante($dsession['session_hp'],($session_perso) ? $dsession['perso_viemax'] : $dsession['monstre_viemax']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/**************************************************************************************************************************************/ ?>

<table class="cadre_gris indiv">
  <tr>
    <td class="cadre_gris_titre moinsgros">
      JOUEUR
    </td>
    <td class="cadre_gris_titre moinsgros">
      NOM
    </td>
    <td class="cadre_gris_titre moinsgros">
      HP
    </td>
    <td class="cadre_gris_titre moinsgros" colspan="2">
      ACTIONS
    </td>
  </tr>
  <?php for($i=0;$i<$nsession;$i++) { ?>
  <tr>
    <td class="cadre_gris align_center vspaced gras">
      <?=$session_joueur[$i]?>
    </td>
    <td class="cadre_gris align_center vspaced gras">
      <?=$session_nom[$i]?>
    </td>
    <td class="cadre_gris align_center vspaced gras">
      <?=$session_vie[$i]?>
    </td>
    <td class="cadre_gris align_center vspaced gras">
      <input type="button" class="gras" value="-10HP" onClick="dynamique('<?=$chemin_fixed?>','xhr/admin_actions','', 'xhr&amp;action=modifier_hp&amp;cible=<?=$session_id[$i]?>&amp;valeur=-10');">
    </td>
    <td class="cadre_gris align_center vspaced gras">
      <input type="button" class="gras" value="+10HP" onClick="dynamique('<?=$chemin_fixed?>','xhr/admin_actions','', 'xhr&amp;action=modifier_hp&amp;cible=<?=$session_id[$i]?>&amp;valeur=+10');">
    </td>
  </tr>
  <?php } ?>
</table>