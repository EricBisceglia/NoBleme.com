<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Utilisateurs bannis";
$page_desc  = "Liste des membres de NoBleme bannis de la communauté";

// Identification
$page_nom = "nobleme";
$page_id  = "pilori";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On commence par révoquer les bans finis
$timestamp = time();
query(" UPDATE membres SET membres.banni_date = '0' , membres.banni_raison = '' WHERE membres.banni_date != '0' AND membres.banni_date < '$timestamp' ");

// On va chercher tous les idiots qui se sont fait dégager
$qbannis = query("  SELECT    membres.id          ,
                              membres.pseudonyme  ,
                              membres.banni_date  ,
                              membres.banni_raison
                    FROM      membres
                    WHERE     membres.banni_date != 0
                    ORDER BY  membres.banni_date ASC ");

// Et on prépare les données
for($nbannis = 0 ; $dbannis = mysqli_fetch_array($qbannis) ; $nbannis++)
{
  $ban_id[$nbannis]     = $dbannis['id'];
  $ban_pseudo[$nbannis] = $dbannis['pseudonyme'];
  $ban_raison[$nbannis] = destroy_html($dbannis['banni_raison']);
  $ban_date[$nbannis]   = datefr(date('Y-m-d',$dbannis['banni_date'])).' à '.date('H:i:s',$dbannis['banni_date']).' ('.dans($dbannis['banni_date']).')';
  $ban_css[$nbannis]    = ($nbannis%2) ? ' nobleme_background' : '';
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/pilori.png" alt="Le pilori des bannis">
    </div>
    <br>

    <div class="body_main midsize">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_titre gros" colspan="3">
            LISTE DES UTILISATEURS BANNIS DE NOBLEME
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Raison du bannissemernt
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Fin du bannissement
          </td>
        </tr>

        <?php for($i=0;$i<$nbannis;$i++) { ?>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center <?=$ban_css[$i]?>">
            <a class="dark blank" href="<?=$chemin?>pages/user/user?id=<?=$ban_id[$i]?>"><?=$ban_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center <?=$ban_css[$i]?>">
            <?=$ban_raison[$i]?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center <?=$ban_css[$i]?>">
            <?=$ban_date[$i]?>
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