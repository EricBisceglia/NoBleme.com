<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Identification
$page_nom = "irl";

// JS
$css = array('irl');
$js  = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'ID de la page

// On ne bosse qu'avec un ID valide
if(!isset($_GET['irl']))
  erreur("Impossible de charger la page : Paramètre manquant");
if(!is_numeric($_GET['irl']))
  erreur("Impossible de charger la page : ID incorrect");

// Maintenant on peut bosser
$page_id    = postdata($_GET['irl']);
if (!mysqli_num_rows(query(" SELECT irl.id FROM irl WHERE irl.id = '$page_id' ")))
  erreur("Impossible de charger la page : ID non existant");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Infos générales sur l'IRL

// On va chercher les infos de l'IRL choisie
$dirl = mysqli_fetch_array(query("  SELECT  irl.id                AS 'irlid'        ,
                                            irl.date              AS 'irldate'      ,
                                            irl.lieu              AS 'irllieu'      ,
                                            irl.raison            AS 'irlraison'    ,
                                            irl.details_pourquoi  AS 'irlpourquoi'  ,
                                            irl.details_ou        AS 'irlou'        ,
                                            irl.details_quand     AS 'irlquand'     ,
                                            irl.details_quoi      AS 'irlquoi'      ,
                                    (SELECT count(irl_participants.id) FROM irl_participants WHERE irl_participants.FKirl = irl.id) AS 'irlcombien'
                                    FROM    irl
                                    WHERE   irl.id = '$page_id' "));

// On règle certains trucs pour l'affichage
$page_titre = "IRL du ".jourfr($dirl['irldate']);
$page_desc  = "Détails de l'IRL NoBlemeuse du ".jourfr($dirl['irldate']);

// Puis on prépare les données pour l'affichage
$irl_id       = $dirl['irlid'];
$irl_date     = datefr($dirl['irldate']);
$irl_etatdate = (strtotime($dirl['irldate']) >= strtotime(date('Y-m-d'))) ? 1 : 0;
$irl_pourquoi = bbcode(destroy_html($dirl['irlpourquoi']));
$irl_ou       = bbcode(destroy_html($dirl['irlou']));
$irl_quand    = bbcode(destroy_html($dirl['irlquand']));
$irl_quoi     = bbcode(destroy_html($dirl['irlquoi']));
$irl_combien  = $dirl['irlcombien'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Participants à l'IRL

// On fait la requête que s'il y a des participants
if($irl_combien)
{
  // On va chercher des infos sur les participants
  $qparticipants = query("  SELECT    irl_participants.FKmembres  AS 'membreid'     ,
                                      membres.pseudonyme          AS 'membrepseudo' ,
                                      irl_participants.pseudonyme AS 'irlppseudo'   ,
                                      irl_participants.confirme   AS 'irlpconfirme' ,
                                      irl_participants.details    AS 'irlpdetails'  ,
                                      IF(membres.pseudonyme IS NULL,irl_participants.pseudonyme,membres.pseudonyme) AS 'orderby'
                            FROM      irl_participants
                            LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                            WHERE     irl_participants.FKirl = '$irl_id'
                            ORDER BY  irl_participants.confirme DESC ,
                                      orderby                   ASC  ");

  // Préparation des données pour l'affichage
  for($nparticipants = 0 ; $dparticipants = mysqli_fetch_array($qparticipants) ; $nparticipants++)
  {
    $irlp_css[$nparticipants]       = ($nparticipants%2) ? ' nobleme_background' : '';
    $irlp_pseudo[$nparticipants]    = (!$dparticipants['membreid']) ? $dparticipants['irlppseudo'] : '<a class="dark blank" href="'.$chemin.'pages/user/user?id='.$dparticipants['membreid'].'">'.$dparticipants['membrepseudo'].'</a>' ;
    $irlp_confirme[$nparticipants]  = (!$dparticipants['irlpconfirme']) ? '&nbsp;' : '&check;';
    $irlp_details[$nparticipants]   = $dparticipants['irlpdetails'];
  }

}






/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/nobleme/irls"><img src="<?=$chemin?>img/logos/irl.png" alt="IRL"></a>
    </div>
    <br>

    <div class="body_main bigsize">
      <span class="titre">IRL du <?=$irl_date?></span><br>
      <br>
      <table class="indiv">
        <tr>
          <td class="nowrap spaced gras align_right infos_irl">
            Pourquoi ?
          </td>
          <td>
            <?=$irl_pourquoi?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td class="nowrap spaced gras align_right infos_irl">
            Où ?
          </td>
          <td>
            <?=$irl_ou?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td class="nowrap spaced gras align_right infos_irl">
            Quand ?
          </td>
          <td>
            <?=$irl_quand?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td class="nowrap spaced gras align_right infos_irl">
            Quoi ?
          </td>
          <td>
            <?=$irl_quoi?>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td class="nowrap spaced gras align_right infos_irl">
            Qui ?
          </td>
          <td>

            <?php if($irl_combien) { ?>
            Les <span class="gras"><?=$irl_combien?></span> NoBlemeux listés dans le tableau ci-dessous :
            <?php } else { ?>
            Personne pour le moment
            <?php } ?>

          </td>
        </tr>
      </table>

      <?php if((getsysop() || getmod('irl'))) { ?>
    </div>
    <div class="body_main bigsize">
      <span class="soustitre">Modifier l'IRL</span><br>
      <br>
      Si vous voyez ceci, c'est que vous êtes sysop et que vous avez la permission de modifier cette IRL.<br>
      <br>
      Pour modifier le contenu de cette IRL et/ou la liste de ses participants : <a href="<?=$chemin?>pages/sysop/irl?edit=<?=$irl_id?>">cliquez ici</a>.<br>
      <?php if(getadmin()) { ?>
      Pour supprimer cette IRL : <a href="<?=$chemin?>pages/sysop/irl?delete=<?=$irl_id?>">cliquez ici</a>.
      <?php } else { ?>
      Pour supprimer cette IRL, demandez à Bad de le faire. Vous n'avez pas la permission de le faire vous-même.
      <?php } } ?>

      <?php if($irl_combien) { ?>

    </div>

    <div class="body_main bigsize" id="irlp">

      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            Présence confirmée
          </td>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            Détail(s) particulier(s)
          </td>
        </tr>

        <?php for($i=0;$i<$nparticipants;$i++) { ?>

        <tr>
          <td class="cadre_gris align_center spaced noflow<?=$irlp_css[$i]?>">
            <?=$irlp_pseudo[$i]?>
          </td>
          <td class="cadre_gris align_center spaced noflow<?=$irlp_css[$i]?>">
            <?=$irlp_confirme[$i]?>
          </td>
          <td class="cadre_gris align_center spaced noflow<?=$irlp_css[$i]?>">
            <?=$irlp_details[$i]?>
          </td>
        </tr>

        <?php } ?>

      </table>

      <?php } ?>

    </div>

    <div class="body_main bigsize">

      <?php if(!$irl_etatdate) { ?>

      <span class="titre">Et l'IRL est finie !</span><br>
      <br>
      Ce fut, comme toujours, une agréable journée.<br>
      Si vous avez raté celle-ci, venez à la suivante !

      <?php } else { ?>

      <span class="titre">Je peux venir ?</span><br>
      <br>
      Bien sûr que oui, ne soyez pas timide et venez nous rejoindre !<br>
      Les IRLs NoBlemeuses ne sont pas des cercles fermés, nous sommes parfaitement acceptants de toute nouvelle personne qui souhaiterait y assister.<br>
      <br>
      La seule condition pour participer à l'IRL est de nous prévenir à l'avance de votre intention de venir.<br>
      Pour ce faire, prévenez <a href="<?=$chemin?>pages/user/user?pseudo=Wan">Wan</a> ou <a href="<?=$chemin?>pages/user/user?id=1">Bad</a> par <a href="<?=$chemin?>pages/user/pm.php?user=227">message privé</a> ou via <a href="<?=$chemin?>pages/irc/index">IRC</a> et vous serez ajouté à la liste.

      <?php } ?>

    </div>



<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';