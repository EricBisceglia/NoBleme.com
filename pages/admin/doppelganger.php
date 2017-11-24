<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Admin';
$header_sidemenu  = 'Doppelganger';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Doppelgänger";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les doublons d'IP
$qdoppel = query("  SELECT    membres.id                  AS 'd_id'     ,
                              membres.pseudonyme          AS 'd_pseudo' ,
                              membres.derniere_visite_ip  AS 'd_ip'
                    FROM      membres
                    WHERE     membres.derniere_visite_ip != ''
                    AND       membres.derniere_visite_ip IN ( SELECT    membres.derniere_visite_ip
                                                              FROM      membres
                                                              GROUP BY  membres.derniere_visite_ip
                                                              HAVING    count(membres.derniere_visite_ip) > 1)
                    ORDER BY  membres.derniere_visite_ip  ASC ,
                              membres.pseudonyme          ASC ");

// Et on les prépare pour l'affichage
for($ndoppel = 0; $ddoppel = mysqli_fetch_array($qdoppel); $ndoppel++)
{
  $doppel_id[$ndoppel]      = $ddoppel['d_id'];
  $doppel_pseudo[$ndoppel]  = predata($ddoppel['d_pseudo']);
  $doppel_ip[$ndoppel]      = predata($ddoppel['d_ip']);
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte align_center">

        <h1>Doppelgänger</h1>

        <h5>Membres partageant la même IP</h5>

      </div>

      <br>
      <br>

      <div class="minitexte2">

        <table class="grid titresnoirs">
          <thead>
            <tr>
              <th>
                MEMBRE
              </th>
              <th>
                DERNIÈRE IP
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <?php for($i=0;$i<$ndoppel;$i++) { ?>
            <?php if($i != 0 && $doppel_ip[$i] != $doppel_ip[$i-1]) { ?>
            <tr>
              <td colspan="4" class="blankrow"></td>
            </tr>
            <?php } ?>
            <tr>
              <td>
                <a href="<?=$chemin?>pages/user/user?id=<?=$doppel_id[$i]?>"><?=$doppel_pseudo[$i]?></a>
              </td>
              <td>
                <?=$doppel_ip[$i]?>
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