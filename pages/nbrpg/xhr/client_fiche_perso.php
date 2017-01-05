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
$id_session     = nbrpg_session($id_personnage);
if(!$id_session)
  exit();

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Infos de la fiche de personnage

// On va chercher les infos du perso
$qpersonnage = query("  SELECT    nbrpg_persos.nom                AS 'perso_nom'          ,
                                  nbrpg_persos.classe             AS 'perso_classe'       ,
                                  nbrpg_persos.niveau             AS 'perso_niveau'       ,
                                  nbrpg_persos.experience         AS 'perso_xp'           ,
                                  nbrpg_persos.prochain_niveau    AS 'perso_xp_max'       ,
                                  nbrpg_session.vie               AS 'perso_vie'          ,
                                  nbrpg_persos.max_vie            AS 'perso_vie_max'      ,
                                  nbrpg_session.energie           AS 'perso_energie'      ,
                                  nbrpg_session.charges_oracle    AS 'perso_oracle'       ,
                                  nbrpg_persos.max_charges_oracle AS 'perso_oracle_max'   ,
                                  nbrpg_session.physique          AS 'perso_physique'     ,
                                  nbrpg_persos.physique           AS 'perso_physique_max' ,
                                  nbrpg_session.mental            AS 'perso_mental'       ,
                                  nbrpg_persos.mental             AS 'perso_mental_max'   ,
                                  nbrpg_session.danger            AS 'perso_danger'       ,
                                  nbrpg_persos.danger             AS 'perso_danger_max'
                        FROM      nbrpg_persos
                        LEFT JOIN nbrpg_session ON nbrpg_session.FKnbrpg_persos = nbrpg_persos.id
                        WHERE     nbrpg_persos.id = '$id_personnage' ");

// Puis on prépare tout ça pour l'affichage
$dpersonnage      = mysqli_fetch_array($qpersonnage);
$perso_nom        = $dpersonnage['perso_nom'];
$perso_classe     = $dpersonnage['perso_classe'].' niveau '.$dpersonnage['perso_niveau'];
$perso_xp         = $dpersonnage['perso_xp'].'/'.$dpersonnage['perso_xp_max'].' XP';
$perso_vie        = nbrpg_vierestante($dpersonnage['perso_vie'],$dpersonnage['perso_vie_max']);
$perso_energie    = $dpersonnage['perso_energie'].'%';
$perso_oracle     = '['.$dpersonnage['perso_oracle'].'/'.$dpersonnage['perso_oracle_max'].' charges]';
$perso_physique   = $dpersonnage['perso_physique'];
$perso_physique  .= ($perso_physique != $dpersonnage['perso_physique_max']) ? ' ('.$dpersonnage['perso_physique_max'].')': '';
$perso_mental     = $dpersonnage['perso_mental'];
$perso_mental    .= ($perso_mental != $dpersonnage['perso_mental_max']) ? ' ('.$dpersonnage['perso_mental_max'].')': '';
$perso_danger     = $dpersonnage['perso_danger'];
$perso_danger    .= ($perso_danger != $dpersonnage['perso_danger_max']) ? ' ('.$dpersonnage['perso_danger_max'].')': '';



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/**************************************************************************************************************************************/ ?>

<br>
<br>
<div class="align_center gras">
  <p class="plusgros"><?=$perso_nom?></p>
  <br>
  <p class="gros"><?=$perso_classe?></p>
  <p class="gros vspaced"><?=$perso_xp?></p>
</div>
<br>
<br>

<div class="container" style="line-height:20px;">

  <div class="moinsgros spaced nowrap container">
    <div class="align_right gras spaced nowrap">
      <p>Points de vie :</p>
      <br>
      <p>Énergie :</p>
      <p>Invoquer l'Oracle :</p>
      <br>
      <p>Physique :</p>
      <p>Mental :</p>
      <p>Danger :</p>
      <br>
      <p>Arme :</p>
      <p>Costume :</p>
      <p>Objet 1 :</p>
      <p>Objet 2 :</p>
      <p>Objet 3 :</p>
      <p>Objet 4 :</p>
      <br>
    </div>
    <div class="align_left nowrap">
      <p class="gras"><?=$perso_vie?></p>
      <br>
      <p class="gras"><?=$perso_energie?></p>
      <p><a class="dark blank pointeur tooltip" href="#"><?=$perso_oracle?></a></p>
      <br>
      <p class="gras"><?=$perso_physique?></p>
      <p class="gras"><?=$perso_mental?></p>
      <p class="gras"><?=$perso_danger?></p>
      <br>
      <p><a class="dark blank pointeur"></a></p>
      <p></p>
      <p><a class="dark blank pointeur"></a></p>
      <p><a class="dark blank pointeur"></a></p>
      <p><a class="dark blank pointeur"></a></p>
      <p><a class="dark blank pointeur"></a></p>
    </div>
  </div>

  <div class="moinsgros spaced" style="flex-grow:1">
    <p class="indiv align_center gros gras">Compétences :</p>
    <br>
    <div class="container">
      <div class="align_right gras spaced nowrap" style="flex-grow:1">
        <p>Compétence passive</p>
        <br>
        <p>Compétence active</p>
        <br>
        <p>Compétence à charges</p>
        <br>
        <p>Compétence à énergie</p>
      </div>
      <div class="align_left nowrap" style="flex-grow:1">
        <p>(passif)</p>
        <br>
        <p><a class="dark blank pointeur">[Activer]</a></p>
        <br>
        <p><a class="dark blank pointeur">[1/1 charges]</a></p>
        <br>
        <p><a class="dark blank pointeur">[15% énergie]</a></p>
      </div>
    </div>
  </div>

</div>