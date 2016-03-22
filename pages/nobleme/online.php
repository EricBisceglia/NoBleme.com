<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Qui est en ligne ?";
$page_desc  = "Liste des membres de NoBleme connectés au site dans les dernières 24 heures";

// Identification
$page_nom = "nobleme";
$page_id  = "online";

// JS
$js = array('toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher le mix d'invités et de membres qui se baladent sur nobleme
$maxdate = time() - 86400;
$qonline =  "  ( SELECT
                  'guest'                       AS 'type'   ,
                  '0'                           AS 'id'     ,
                  '0'                           AS 'admin'  ,
                  '0'                           AS 'sysop'  ,
                  '0'                           AS 'mod'    ,
                  invites.surnom                AS 'pseudo' ,
                  invites.derniere_visite       AS 'date'   ,
                  invites.derniere_visite_page  AS 'page'   ,
                  invites.derniere_visite_url   AS 'url'
                FROM      invites
                WHERE     invites.derniere_visite >= '$maxdate'
                ORDER BY  invites.derniere_visite DESC ";
if(!isset($_GET['noguest']))
  $qonline .= " LIMIT     100 ) ";
else
  $qonline .= " LIMIT       0 ) ";
$qonline .= " UNION
                ( SELECT
                  'user'                        AS 'type'   ,
                  membres.id                    AS 'id'     ,
                  membres.admin                 AS 'admin'  ,
                  membres.sysop                 AS 'sysop'  ,
                  membres.moderateur            AS 'mod'    ,
                  membres.pseudonyme            AS 'pseudo' ,
                  membres.derniere_visite       AS 'date'   ,
                  membres.derniere_visite_page  AS 'page'   ,
                  membres.derniere_visite_url   AS 'url'
                FROM      membres
                WHERE     membres.derniere_visite >= '$maxdate'
                ORDER BY  membres.derniere_visite DESC
                LIMIT     100 )
              ORDER BY date DESC ";

$qonline = query($qonline);

// Et à partir de ça, on se prépare les données
for($nonline = 0 ; $donline = mysqli_fetch_array($qonline) ; $nonline++)
{
  // L'invité a son surnom mignon, l'user son pseudo
  if ($donline['type'] === 'guest')
    $online_pseudo[$nonline] = $donline['pseudo'];
  else if (!$donline['admin'] && !$donline['sysop'])
    $online_pseudo[$nonline] = '<a class="dark blank gras" href="'.$chemin.'pages/user/user?id='.$donline['id'].'">'.$donline['pseudo'].'</a>';
  else
    $online_pseudo[$nonline] = '<a class="blank gras" href="'.$chemin.'pages/user/user?id='.$donline['id'].'"><span class="texte_blanc">'.$donline['pseudo'].'</span></a>';

  // Les couleurs de fond
  if ($donline['type'] === 'guest')
    $online_css[$nonline] = '';
  else if (!$donline['admin'] && !$donline['sysop'] && !$donline['mod'])
    $online_css[$nonline] = 'nobleme_background gras';
  else if ($donline['sysop'])
    $online_css[$nonline] = 'sysop texte_blanc gras';
  else if ($donline['mod'])
    $online_css[$nonline] = 'vert_background gras';
  else
    $online_css[$nonline] = 'mise_a_jour texte_blanc gras';

  // La page avec ou sans url autour
  if($donline['url'] == '')
    $online_page[$nonline] = $donline['page'];
  else if (!$donline['admin'] && !$donline['sysop'])
    $online_page[$nonline] = '<a class="dark blank gras" href="'.$donline['url'].'">'.$donline['page'].'</a>';
  else
    $online_page[$nonline] = '<a class="dark blank gras" href="'.$donline['url'].'"><span class="texte_blanc">'.$donline['page'].'</span></a>';

  // Et le reste
  $online_date[$nonline]  = ilya($donline['date']);
  $online_url[$nonline]   = $donline['url'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/online.png" alt="Qui est en ligne ?">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Visiteurs connectés</span><br>
      <br>
      Cette page recense les visiteurs connectés dans les dernières 24 heures, et la page de NoBleme qu'ils ont visité en dernier<br>
      <br>
      <?php if(!isset($_GET['noguest'])) { ?>
      Les invités n'ayant pas de pseudonymes, ils sont identifiés par des surnoms idiots. C'est plus rigolo que des adresses IP, non ?<br>
      Si vous en avez marre de voir tous ces invités : <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/online?noguest">cliquez ici pour masquer les invités et ne voir que les membres enregistrés</a><br>
      <?php } else { ?>
      Les invités sont actuellement masqués, <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/online">cliquez ici pour afficher les invités</a><br>
      <?php } ?>
      <br>
      <?php if(!isset($_GET['noguest'])) { ?>
      Les invités apparaissent en blanc,<br>
      <?php } ?>
      les <a href="<?=$chemin?>pages/nobleme/membres">membres enregistrés</a> ont un fond <span class="nobleme_background gras">&nbsp;gris&nbsp;</span>,<br>
      les <a href="<?=$chemin?>pages/nobleme/admins">modérateurs</a> ont le droit à du <span class="vert_background gras">&nbsp;vert&nbsp;</span>,<br>
      les <a href="<?=$chemin?>pages/nobleme/admins">sysops</a> (modérateurs globaux) en <span class="sysop texte_blanc gras">&nbsp;orange&nbsp;</span>,<br>
      et <a href="<?=$chemin?>pages/user/user?id=1">l'administrateur</a> apparait en <span class="mise_a_jour texte_blanc gras">&nbsp;rouge&nbsp;</span>.
    </div>

    <br>

    <div class="body_main bigsize">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Dernière activité
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
            Dernière action
          </td>
        </tr>

        <?php for($i=0;$i<$nonline;$i++) { ?>

        <tr>
          <td class="cadre_gris cadre_gris_haut align_center <?=$online_css[$i]?>">
            <?=$online_date[$i]?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center <?=$online_css[$i]?>">
            <?=$online_pseudo[$i]?>
          </td>
          <td class="cadre_gris cadre_gris_haut align_center <?=$online_css[$i]?>">
            <?=$online_page[$i]?>
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