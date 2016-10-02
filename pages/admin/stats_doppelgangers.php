<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'admin';
$header_submenu   = 'admin';
$header_sidemenu  = 'stats_dop';

// Titre et description
$page_titre = "Stats - Doppelgangers";

// Identification
$page_nom = "admin";



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les dupes
$qdoppel = query("  SELECT    membres.id                  AS 'did'      ,
                              membres.pseudonyme          AS 'dpseudo'  ,
                              membres.derniere_visite_ip  AS 'dip'
                    FROM      membres
                    WHERE     membres.derniere_visite_ip != ''
                    AND       membres.derniere_visite_ip IN ( SELECT    membres.derniere_visite_ip
                                                              FROM      membres
                                                              GROUP BY  membres.derniere_visite_ip
                                                              HAVING    count(membres.derniere_visite_ip) > 1)
                    ORDER BY  membres.derniere_visite_ip  ASC ,
                              membres.pseudonyme          ASC ");

// Puis on prépare ça pour l'affichage
for($ndoppel = 0 ; $ddoppel = mysqli_fetch_array($qdoppel) ; $ndoppel++)
{
  $doppel_id[$ndoppel]      = $ddoppel['did'];
  $doppel_pseudo[$ndoppel]  = $ddoppel['dpseudo'];
  $doppel_ip[$ndoppel]      = $ddoppel['dip'];
}


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/administration.png" alt="Administration">
    </div>
    <br>

    <div class="body_main smallsize">
      <table class="cadre_gris indiv">
        <tr>
          <td colspan="2" class="cadre_gris_titre gros">
            DOPPELGÄNGERS
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut">
            Adresse IP
          </td>
        </tr>
        <?php for($i=0;$i<$ndoppel;$i++) { ?>
        <?php if($i != 0 && $doppel_ip[$i] != $doppel_ip[$i-1]) { ?>
        <tr>
          <td colspan="2" class="cadre_gris_vide">
          </td>
        </tr>
        <?php } ?>
        <tr>
          <td class="cadre_gris align_center">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?id=<?=$doppel_id[$i]?>"><?=$doppel_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris align_center">
            <?=$doppel_ip[$i]?>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';