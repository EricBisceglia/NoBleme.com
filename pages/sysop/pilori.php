<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
sysoponly($lang);

// Menus du header
$header_menu      = 'Admin';
$header_sidemenu  = 'Pilori';

// Identification
$page_nom = "Administre secrètement le site";

// Langues disponibles
$langue_page = array('FR');

// Titre
$page_titre = "Pilori des bannis";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On commence par libérer de leurs bans les users qui ne sont plus bannis
$timestamp = time();
query(" UPDATE  membres
        SET     banni_date    = 0  ,
                banni_raison  = ''
        WHERE   banni_date   <= '$timestamp' ");

// On va chercher les users banns
$qbannis = query("  SELECT    membres.id          ,
                              membres.pseudonyme  ,
                              membres.banni_date  ,
                              membres.banni_raison
                    FROM      membres
                    WHERE     membres.banni_date != 0
                    ORDER BY  membres.banni_date ASC ");

// Et on les prépare pour l'affichage
for($nbannis = 0; $dbannis = mysqli_fetch_array($qbannis); $nbannis++)
{
  $banni_id[$nbannis]     = $dbannis['id'];
  $banni_pseudo[$nbannis] = predata($dbannis['pseudonyme']);
  $banni_fin[$nbannis]    = dans($dbannis['banni_date']).' ('.datefr(date('Y-m-d', $dbannis['banni_date'])).')';
  $banni_raison[$nbannis] = predata($dbannis['banni_raison']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1 class="align_center">Pilori des bannis</h1>

        <br>
        <br>

        <?php if(!$nbannis) { ?>

        <h5 class="align_center">Bonne nouvelle, il n'y a aucun utilisateur banni en ce moment !</h5>

        <?php } else { ?>

        <table class="grid titresnoirs">
          <thead>
            <tr>
              <th>
                &nbsp;
              </th>
              <th>
                Fin du ban
              </th>
              <th>
                Raison du ban
              </th>
              <th>
                &nbsp;
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <?php for($i=0;$i<$nbannis;$i++) { ?>
            <tr>
              <td class="align_right spaced gras nowrap">
                <a href="<?=$chemin?>pages/user/user?id=<?=$banni_id[$i]?>"><?=$banni_pseudo[$i]?></a>
              </td>
              <td class="nowrap">
                <?=$banni_fin[$i]?>
              </td>
              <td>
                <?=$banni_raison[$i]?>
              </td>
              <td class="aling_center nowrap">
                <a href="<?=$chemin?>pages/sysop/ban?id=<?=$banni_id[$i]?>">Débannir</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';