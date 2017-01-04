<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'lire';
$header_submenu   = 'nbrpg';
$header_sidemenu  = 'liste_persos';

// Titre et description
$page_titre = "NBRPG : Personnages";
$page_desc  = "Liste des personnages actuellement actifs dans le NoBlemeRPG";

// Identification
$page_nom = "nbrpg";
$page_id  = "personnages";

// CSS
$css = array('nbrpg');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la liste des personnages
$qpersos = query("  SELECT    nbrpg_persos.couleur_chat     AS 'p_couleur'  ,
                              nbrpg_persos.nom              AS 'p_nom'      ,
                              membres.id                    AS 'p_userid'   ,
                              membres.pseudonyme            AS 'p_pseudo'   ,
                              nbrpg_persos.date_creation    AS 'p_creation' ,
                              nbrpg_persos.classe           AS 'p_classe'   ,
                              nbrpg_persos.niveau           AS 'p_niveau'   ,
                              nbrpg_persos.max_vie          AS 'p_vie'      ,
                              nbrpg_persos.physique         AS 'p_physique' ,
                              nbrpg_persos.mental           AS 'p_mental'   ,
                              nbrpg_persos.danger           AS 'p_danger'
                    FROM      nbrpg_persos
                    LEFT JOIN membres ON nbrpg_persos.FKmembres = membres.id
                    ORDER BY  nbrpg_persos.niveau        DESC  ,
                              nbrpg_persos.experience    DESC  ,
                              nbrpg_persos.date_creation ASC   ");

// Puis on les prépare pour l'affichage
for($npersos = 0 ; $dpersos = mysqli_fetch_array($qpersos) ; $npersos++)
{
  $perso_couleur[$npersos]  = $dpersos['p_couleur'];
  $perso_nom[$npersos]      = $dpersos['p_nom'];
  $perso_userid[$npersos]   = $dpersos['p_userid'];
  $perso_joueur[$npersos]   = $dpersos['p_pseudo'];
  $perso_creation[$npersos] = ilya($dpersos['p_creation']);
  $perso_classe[$npersos]   = $dpersos['p_classe'];
  $perso_niveau[$npersos]   = $dpersos['p_niveau'];
  $perso_maxvie[$npersos]   = $dpersos['p_vie'];
  $perso_physique[$npersos] = $dpersos['p_physique'];
  $perso_mental[$npersos]   = $dpersos['p_mental'];
  $perso_danger[$npersos]   = $dpersos['p_danger'];
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/nbrpg.png" alt="NoBlemeRPG">
    </div>
    <br>

    <div class="body_main midsize">
      <p class="titre">Liste des personnages actifs dans le NoBlemeRPG</p>
      <br>
      <br>
      Cette page contient une liste des personnages actifs en ce moment dans le <a href="<?=$chemin?>pages/nbrpg/index">NoBlemeRPG</a>.<br>
      <br>
      À la fin de certains <a href="<?=$chemin?>pages/nbrpg/caverne?historique">arcs d'histoire</a>, il arrive parfois que tous les personnages soient mis à la retraite (ou tués) et que de nouveaux personnages soient crées à leur place pour vivre de nouvelles aventures. Vous ne trouverez sur cette page que les personnages actuellement incarnés par des joueurs. L'historique des anciens personnages est trouvable dans la <a href="<?=$chemin?>pages/nbrpg/caverne">caverne de Liodain</a>. Les couleurs sont aléatoirement assignées aux personnages au moment de leur création, et permettent de les identifier plus facilement pendant le jeu.
    </div>

    <br>

    <div class="body_main bigsize">
      <table class="cadre_gris indiv">
        <thead>
          <tr>
            <td class="cadre_gris_titre moinsgros vspaced spaced">
              PERSONNAGE
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced">
              JOUEUR
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced nowrap">
              REJOINT LE GROUPE
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced">
              CLASSE
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced">
              NIVEAU
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced nowrap">
              VIE MAX.
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced">
              PHYSIQUE
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced">
              MENTAL
            </td>
            <td class="cadre_gris_titre moinsgros vspaced spaced">
              DANGER
            </td>
          </tr>
        </thead>
        <tbody class="cadre_gris_altc">
          <?php for($i=0;$i<$npersos;$i++) { ?>
          <tr>
            <td class="cadre_gris align_center moinsgros gras vspaced spaced nowrap" style="color:<?=$perso_couleur[$i]?>">
              <?=$perso_nom[$i]?>
            </td>
            <td class="cadre_gris align_center vspaced spaced nowrap">
              <a href="<?=$chemin?>pages/user/user.php?id=<?=$perso_userid[$i]?>" class="dark blank"><?=$perso_joueur[$i]?></a>
            </td>
            <td class="cadre_gris align_center vspaced spaced nowrap">
              <?=$perso_creation[$i]?>
            </td>
            <td class="cadre_gris align_center vspaced spaced nowrap">
              <?=$perso_classe[$i]?>
            </td>
            <td class="cadre_gris align_center gras vspaced spaced nowrap">
              <?=$perso_niveau[$i]?>
            </td>
            <td class="cadre_gris align_center gras vspaced spaced nowrap nbrpg_hp_high">
              <?=$perso_maxvie[$i]?>
            </td>
            <td class="cadre_gris align_center vspaced spaced nowrap">
              <?=$perso_physique[$i]?>
            </td>
            <td class="cadre_gris align_center  vspaced spaced nowrap">
              <?=$perso_mental[$i]?>
            </td>
            <td class="cadre_gris align_center vspaced spaced nowrap">
              <?=$perso_danger[$i]?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';