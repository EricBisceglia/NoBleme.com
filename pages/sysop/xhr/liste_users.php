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
$userlist_action    = postdata_vide('action', 'string', '');
$userlist_lien      = postdata_vide('lien', 'string', '');
$userlist_chemin    = postdata_vide('chemin', 'string', '');

// On commence par libérer de leurs bans les users qui ne sont plus bannis
$timestamp = time();
query(" UPDATE  membres
        SET     banni_date    = 0  ,
                banni_raison  = ''
        WHERE   banni_date   <= '$timestamp' ");

// On va chercher la liste d'users
$quserlist = query("  SELECT    membres.id          ,
                                membres.pseudonyme  ,
                                membres.banni_date
                      FROM      membres
                      WHERE     membres.pseudonyme LIKE '%$userlist_recherche%'
                      ORDER BY  membres.pseudonyme ASC ");

// On les prépare pour l'affiche
for($nuserlist = 0; $duserlist = mysqli_fetch_array($quserlist) ; $nuserlist++)
{
  $userlist_id[$nuserlist]      = $duserlist['id'];
  $userlist_pseudo[$nuserlist]  = predata($duserlist['pseudonyme']);
  if($userlist_action == 'Bannir')
    $userlist_texte[$nuserlist] = ($duserlist['banni_date']) ? 'Débannir' : 'Bannir';
  else
    $userlist_texte[$nuserlist] = $userlist_action;
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
    <tr>
      <td>
        <a class="gras" href="<?=$userlist_chemin?>pages/user/user?id=<?=$userlist_id[$i]?>"><?=$userlist_pseudo[$i]?></a>
      </td>
      <td>
        <a class="gras" href="<?=$userlist_chemin?>pages/sysop/<?=$userlist_lien?>?id=<?=$userlist_id[$i]?>"><?=$userlist_texte[$i]?></a>
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