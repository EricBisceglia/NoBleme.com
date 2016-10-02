<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = (!isset($_GET['edit']))   ? 'communaute' : 'admin';
$header_menu      = (!isset($_GET['delete'])) ? $header_menu : 'admin';
$header_submenu   = (!isset($_GET['edit']))   ? 'irl' : 'mod';
$header_submenu   = (!isset($_GET['delete'])) ? $header_submenu : 'mod';
$header_sidemenu  = (!isset($_GET['edit']))   ? '' : 'irl_edit';
$header_sidemenu  = (!isset($_GET['delete'])) ? $header_sidemenu : 'irl_delete';

// Titre et description
$page_titre = "IRL";
$page_desc  = "Organisation des IRL noblemeuses (et archivage des IRL passées)";

// Identification
$page_nom = "nobleme";
$page_id  = "irls";

// JS
$js  = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on est en mode sysop, on dégage les users
if(isset($_GET['edit']))
{
  sysoponly('irl');
  $page_nom = "sysop";
  $page_id  = "";
}

// Si on est en mode admin, on dégage les users
if(isset($_GET['delete']))
{
  adminonly();
  $page_nom = "admin";
  $page_id  = "";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va se chercher les IRL
$qirls = query("  SELECT    irl.id      AS 'irlid'      ,
                            irl.date    AS 'irldate'    ,
                            irl.lieu    AS 'irllieu'    ,
                            irl.raison  AS 'irlraison'  ,
                  (SELECT count(irl_participants.id) FROM irl_participants WHERE irl_participants.FKirl = irl.id) AS 'irlparticipants'
                  FROM      irl
                  ORDER BY  irl.date DESC ");

// Préparation des données
for($nirls = 0 ; $dirls = mysqli_fetch_array($qirls) ; $nirls++)
{
  $irl_id[$nirls]     = $dirls['irlid'];
  $irl_date[$nirls]   = datefr($dirls['irldate']);
  $irl_lieu[$nirls]   = destroy_html($dirls['irllieu']);
  $irl_raison[$nirls] = destroy_html($dirls['irlraison']);
  $irl_nombre[$nirls] = $dirls['irlparticipants'];
  $irl_css[$nirls]    = ($dirls['irldate'] > date('Y-m-d')) ? '' : ' nobleme_background';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <?php if(!isset($_GET['edit']) && !isset($_GET['delete'])) { ?>
      <img src="<?=$chemin?>img/logos/irl.png" alt="IRL">
      <?php } else { ?>
      <img src="<?=$chemin?>img/logos/sysop_irl.png" alt="IRL">
      <?php } ?>
    </div>
    <br>

    <?php if(!isset($_GET['edit']) && !isset($_GET['delete'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Organisation des rencontres IRL NoBlemeuses</span><br>
      <br>
      L'acronyme <span class="gras">IRL</span> signifie en anglais "<span class="gras">I</span>n <span class="gras">R</span>eal <span class="gras">L</span>ife" (en français "Dans la vraie vie"), et sert à qualifier les rencontres de membres d'une communauté internet dans le monde réel. Son opposé est OTI: "On The Internet" (en français "Sur internet").<br>
      <br>
      Depuis ses débuts en 2005, la communauté de NoBleme effectue régulièrement des rencontres dans le monde réel. Toutefois, ce n'est que depuis 2012 qu'elles sont traquées sur le site. Les IRL précédentes étaient intégralement organisées sur le <a href="<?=$chemin?>pages/irc/index">serveur IRC</a> et il ne reste comme trace de leur existence que la mémoire de ceux qui y ont participé.<br>
      <br>
      Cette page sert à organiser les rencontres IRL à venir, et à garder une trace des IRL passées.<br>
      Vous pourrez également trouver des statistiques sur les IRL et leurs participants en <a href="<?=$chemin?>pages/nobleme/irlstats">cliquant ici</a>.
    </div>
    <?php } ?>

    <?php if((getsysop() || getmod('irl')) && !isset($_GET['edit']) && !isset($_GET['delete'])) { ?>
    <div class="body_main midsize">
      <span class="soustitre">Modifier les IRL</span><br>
      <br>
      Si vous voyez ceci, c'est que vous avez la permission de modifier les IRL.<br>
      <br>
      Pour créer une nouvelle IRL : <a href="<?=$chemin?>pages/sysop/irl?add">cliquez ici</a><br>
      Pour modifier le contenu des IRL : <a href="?edit">cliquez ici</a> et des liens d'édition apparaitront dans le tableau.<br>
      <?php if(getadmin()) { ?>
      Pour supprimer une IRL : <a href="?delete">cliquez ici</a> et des liens de suppression apparaitront dans le tableau.
      <?php } else { ?>
      Vous n'avez pas la permission de supprimer des IRL. Demandez à Bad de le faire pour vous.
      <?php } ?>
    </div>
    <?php } ?>

    <div class="body_main midsize">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            Date
          </td>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            Lieu
          </td>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            Raison
          </td>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            Participants
          </td>
          <td class="cadre_gris_sous_titre spaced noflow moinsgros">
            <?php if(!isset($_GET['edit']) && !isset($_GET['delete'])) { ?>
            Détails
            <?php } else if(isset($_GET['edit'])) { ?>
            Sysop
            <?php } else { ?>
            Admin
            <?php } ?>
          </td>
        </tr>

        <?php for($i=0;$i<$nirls;$i++) { ?>

        <tr>
          <td class="cadre_gris align_center spaced noflow<?=$irl_css[$i]?>">
            <?=$irl_date[$i]?>
          </td>
          <td class="cadre_gris align_center spaced noflow<?=$irl_css[$i]?>">
            <?=$irl_lieu[$i]?>
          </td>
          <td class="cadre_gris align_center spaced noflow<?=$irl_css[$i]?>">
            <?=$irl_raison[$i]?>
          </td>
          <td class="cadre_gris align_center spaced noflow gras<?=$irl_css[$i]?>">
            <?=$irl_nombre[$i]?>
          </td>
          <td class="cadre_gris align_center spaced noflow gras<?=$irl_css[$i]?>">
            <?php if(!isset($_GET['edit']) && !isset($_GET['delete'])) { ?>
            <a class="dark" href="<?=$chemin?>pages/nobleme/irl?irl=<?=$irl_id[$i]?>">Plus de détails</a>
            <?php } else if(isset($_GET['edit'])) { ?>
            <a class="dark" href="<?=$chemin?>pages/sysop/irl?edit=<?=$irl_id[$i]?>">Modifier l'IRL</a>
            <?php } else { ?>
            <a class="dark" href="<?=$chemin?>pages/sysop/irl?delete=<?=$irl_id[$i]?>">Supprimer l'IRL</a>
            <?php } ?>
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