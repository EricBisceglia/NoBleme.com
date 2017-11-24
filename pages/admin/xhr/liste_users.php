<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
sysoponly($lang);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On récupère la recherche et l'action
$userlist_recherche = postdata_vide('pseudo', 'string', '');
$userlist_chemin    = postdata_vide('chemin', 'string', '');

// On va chercher la liste d'users
$quserlist = query("  SELECT    membres.id          ,
                                membres.pseudonyme  ,
                                membres.admin       ,
                                membres.sysop       ,
                                membres.moderateur
                      FROM      membres
                      WHERE     membres.pseudonyme LIKE '%$userlist_recherche%'
                      ORDER BY  membres.pseudonyme ASC ");

// On les prépare pour l'affiche
for($nuserlist = 0; $duserlist = mysqli_fetch_array($quserlist) ; $nuserlist++)
{
  $userlist_id[$nuserlist]      = $duserlist['id'];
  $userlist_pseudo[$nuserlist]  = predata($duserlist['pseudonyme']);
  $userlist_css[$nuserlist]     = ($duserlist['admin']) ? ' class="negatif"' : '';
  $userlist_css[$nuserlist]     = ($duserlist['sysop']) ? ' class="neutre"' : $userlist_css[$nuserlist];
  $userlist_css[$nuserlist]     = ($duserlist['moderateur']) ? ' class="vert_background"' : $userlist_css[$nuserlist];
  $userlist_acss[$nuserlist]    = ($duserlist['admin'] || $duserlist['sysop']) ? ' texte_blanc' : '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<br>
<br>

<table class="fullgrid titresnoirs">
  <thead>
    <tr>
      <th>
        Pseudonyme
      </th>
      <th>
        Action
      </th>
    </tr>
  </thead>

  <?php if($nuserlist) { ?>

  <tbody class="align_center">
    <?php for($i=0;$i<$nuserlist;$i++) { ?>
    <tr<?=$userlist_css[$i]?>>
      <td>
        <a class="gras<?=$userlist_acss[$i]?>" href="<?=$userlist_chemin?>pages/user/user?id=<?=$userlist_id[$i]?>"><?=$userlist_pseudo[$i]?></a>
      </td>
      <td>
        <a class="gras<?=$userlist_acss[$i]?>" href="<?=$userlist_chemin?>pages/admin/permissions?id=<?=$userlist_id[$i]?>">Changer les permissions</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>

  <?php } else { ?>

  <tbody class="align_center">
    <tr>
      <td colspan="2" class="noir texte_blanc gras">
        AUCUN UTILISATEUR TROUVÉ
      </td>
    </tr>
  </tbody>

  <?php } ?>

</table>