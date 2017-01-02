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
$id_personnage = nbrpg();
if(!$id_personnage)
  exit();

/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Infos de la fiche de personnage

// On va chercher les infos du perso
$qpersonnage = query("  SELECT    nbrpg_persos.nom            AS 'perso_nom'      ,
                                  nbrpg_persos.date_creation  AS 'perso_creation' ,
                                  nbrpg_session.vie           AS 'perso_vie'      ,
                                  nbrpg_persos.max_vie        AS 'perso_vie_max'
                        FROM      nbrpg_persos
                        LEFT JOIN nbrpg_session ON nbrpg_session.FKnbrpg_persos = nbrpg_persos.id
                        WHERE     nbrpg_persos.id = '$id_personnage' ");

// Puis on prépare tout ça pour l'affichage
$dpersonnage    = mysqli_fetch_array($qpersonnage);
$perso_nom      = $dpersonnage['perso_nom'];
$perso_vie      = nbrpg_vierestante($dpersonnage['perso_vie'],$dpersonnage['perso_vie_max']);




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
  <p class="gros">Homme-singe niveau 3</p>
  <p class="gros vspaced">32/100 XP</p>
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
      <p class="gras">100%</p>
      <p><a class="dark blank pointeur">[1/1 charges]</a></p>
      <br>
      <p class="gras">10</p>
      <p class="gras">9</p>
      <br>
      <p><a class="dark blank pointeur">[Poings]</a></p>
      <p>Peau de bête</p>
      <p><a class="dark blank pointeur">[Tranche de froma...]</a></p>
      <p><a class="dark blank pointeur">[Zizi d'ours]</a></p>
      <p></p>
      <p></p>
    </div>
  </div>

  <div class="moinsgros spaced" style="flex-grow:1">
    <p class="indiv align_center gros gras">Compétences :</p>
    <br>
    <div class="container">
      <div class="align_right gras spaced nowrap" style="flex-grow:1">
        <p>Dangereux</p>
        <br>
        <p>Stance du gorille</p>
        <p>Stance du chimpanzé</p>
        <br>
        <p>Coup de poing assommant</p>
        <p>Boulette de morve</p>
        <br>
        <p>Hurlement sauvage</p>
        <p>Arborescence infernale</p>
      </div>
      <div class="align_left nowrap" style="flex-grow:1">
        <p>(passif)</p>
        <br>
        <p><a class="dark blank pointeur">[Activer]</a></p>
        <p><a class="dark blank pointeur">[Activer]</a></p>
        <br>
        <p><a class="dark blank pointeur">[1/1 charges]</a></p>
        <p><a class="dark blank pointeur">[2/4 charges]</a></p>
        <br>
        <p><a class="dark blank pointeur">[15% énergie]</a></p>
        <p><a class="dark blank pointeur">[40% énergie]</a></p>
      </div>
    </div>
  </div>

</div>