<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'communaute';
$header_submenu   = 'irl';

// Titre et description
$page_titre = "IRL - Statistiques";
$page_desc  = "Statistiques concernant les IRL NoBlemeuses et leurs participants";

// Identification
$page_nom = "nobleme";
$page_id  = "irlstats";

// CSS
$css = array('general');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pour commencer, on a besoin de connaitre le nombre total d'IRL passées

$irldatenow = date("Y-m-d");
$qtotalirls = mysqli_fetch_array(query(" SELECT COUNT(*) AS 'nbirls' FROM irl WHERE irl.date < '$irldatenow' "));
$totalirls  = $qtotalirls['nbirls'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Les habitués

// On commence par aller chercher tous les noblemeux qui ont participé à des IRL
$qhabitues = query("  SELECT    membres.id                  AS 'irlstat_id'     ,
                                membres.pseudonyme          AS 'irlstat_pseudo' ,
                                COUNT(irl_participants.id)  AS 'irlstat_nombre'
                      FROM      irl_participants  ,
                                irl               ,
                                membres
                      WHERE     irl_participants.confirme   = 1
                      AND       irl_participants.FKmembres != 0
                      AND       irl_participants.FKirl      = irl.id
                      AND       irl.date                    < '$irldatenow'
                      AND       irl_participants.FKmembres  = membres.id
                      GROUP BY  irl_participants.FKmembres
                      HAVING    COUNT(irl_participants.id)  >= 5
                      ORDER BY  COUNT(irl_participants.id)  DESC ,
                                membres.pseudonyme          ASC  ");

// On va chercher les infos supplémentaires et préparer pour l'affichage
for($nhabitues = 0 ; $dhabitues = mysqli_fetch_array($qhabitues) ; $nhabitues++)
{
  // PremièreIRL
  $qpremiereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = ".$dhabitues['irlstat_id']."
                                              AND       irl_participants.FKirl      = irl.id
                                              ORDER BY  irl.date ASC "));

  // Dernière IRL
  $qderniereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = ".$dhabitues['irlstat_id']."
                                              AND       irl_participants.FKirl      = irl.id
                                              AND       irl.date                    < '$irldatenow'
                                              ORDER BY  irl.date DESC "));

  // Reste plus qu'à préparer les données pour l'affichage
  $habitues_id[$nhabitues]          = $dhabitues['irlstat_id'];
  $habitues_pseudo[$nhabitues]      = $dhabitues['irlstat_pseudo'];
  $habitues_nombre[$nhabitues]      = $dhabitues['irlstat_nombre'];
  $habitues_pourcent[$nhabitues]    = round(($dhabitues['irlstat_nombre']/$totalirls)*100,0);
  $habitues_premiereid[$nhabitues]  = $qpremiereirl['irlid'];
  $habitues_premiere[$nhabitues]    = jourfr($qpremiereirl['irldate'],1);
  $habitues_derniereid[$nhabitues]  = $qderniereirl['irlid'];
  $habitues_derniere[$nhabitues]    = jourfr($qderniereirl['irldate'],1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Fréquence

// D'abord on veut l'année de l'IRL la plus ancienne
$qirloriginelle = mysqli_fetch_array(query(" SELECT YEAR(irl.date) AS 'irloriginelle' FROM irl ORDER BY irl.date ASC "));
$irloriginelle  = $qirloriginelle['irloriginelle'];

// Maintenant qu'on a la première année, on parcourt jusqu'à cette année et on prépare pour l'affichage
for($nfrequence = $irloriginelle ; $nfrequence <= date('Y') ; $nfrequence++)
{
  // On va chercher le nombre d'IRLs pour l'année concernée
  $qfrequenceirl = mysqli_fetch_array(query(" SELECT COUNT(*) AS 'frequenceirl' FROM irl WHERE YEAR(irl.date) = '$nfrequence' "));

  // Et on prépare les donnéespour l'affichage
  $frequence_annee[$nfrequence] = $nfrequence;
  $frequence_count[$nfrequence] = $qfrequenceirl['frequenceirl'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Liste complète

// On commence par aller chercher tous les noblemeux qui ont participé à des IRL
$qirliste = query(" SELECT    membres.id                  AS 'irlstat_id'     ,
                              membres.pseudonyme          AS 'irlstat_pseudo' ,
                              COUNT(irl_participants.id)  AS 'irlstat_nombre'
                    FROM      irl_participants  ,
                              irl               ,
                              membres
                    WHERE     irl_participants.confirme   = 1
                    AND       irl_participants.FKmembres != 0
                    AND       irl_participants.FKirl      = irl.id
                    AND       irl.date                    < '$irldatenow'
                    AND       irl_participants.FKmembres  = membres.id
                    GROUP BY  irl_participants.FKmembres
                    ORDER BY  membres.pseudonyme ASC ");

// On va chercher les infos supplémentaires et préparer pour l'affichage
for($nirliste = 0 ; $dirliste = mysqli_fetch_array($qirliste) ; $nirliste++)
{
  // PremièreIRL
  $qpremiereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = ".$dirliste['irlstat_id']."
                                              AND       irl_participants.FKirl      = irl.id
                                              ORDER BY  irl.date ASC "));

  // Dernière IRL
  $qderniereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = ".$dirliste['irlstat_id']."
                                              AND       irl_participants.FKirl      = irl.id
                                              AND       irl.date                    < '$irldatenow'
                                              ORDER BY  irl.date DESC "));

  // Reste plus qu'à préparer les données pour l'affichage
  $irliste_id[$nirliste]          = $dirliste['irlstat_id'];
  $irliste_pseudo[$nirliste]      = $dirliste['irlstat_pseudo'];
  $irliste_nombre[$nirliste]      = $dirliste['irlstat_nombre'];
  $irliste_style[$nirliste]       = ($dirliste['irlstat_nombre'] >= 5) ? ' gras' : '';
  $irliste_premiereid[$nirliste]  = $qpremiereirl['irlid'];
  $irliste_premiere[$nirliste]    = substr(jourfr($qpremiereirl['irldate']),2);
  $irliste_derniereid[$nirliste]  = $qderniereirl['irlid'];
  $irliste_derniere[$nirliste]    = substr(jourfr($qderniereirl['irldate']),2);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/nobleme/irls">
        <img src="<?=$chemin?>img/logos/irlstats.png" alt="Statistiques des IRL">
      </a>
    </div>
    <br>

    <div class="body_main smallsize">
      <span class="titre">Les IRL NoBlemeuses en chiffres</span><br>
      <br>
      Sur cette page, vous trouverez plusieurs statistiques différentes concernant les <a href="<?=$chemin?>pages/nobleme/irls">IRL NoBlemeuses</a>.<br>
      Si vous vous demandez ce qu'est une <a href="<?=$chemin?>pages/nobleme/irls">IRL NoBlemeuse</a>, cliquez sur <a href="<?=$chemin?>pages/nobleme/irls">ce lien</a> et vous saurez.<br>
      <br>
      Notons que les statistiques ne couvrent pas les IRL NoBlemeuses ayant eu lieu avant 2012.<br>
      Elles seront ajoutées si quelqu'un en retrouve les détails précis (date, lieu, liste des participants).<br>
      <br>
      Les statistiques listées ici sont les suivantes :<br>
      <ul class="dotlist">
        <li><a class="dark gras" href="#habitues">Les habitués</a> : Les NoBlemeux qui ont participé à plus de 5 IRL</li>
        <li><a class="dark gras" href="#frequence">Fréquence</a> : Le nombre d'IRL NoBlemeuses qui ont eu lieu chaque année</li>
        <li><a class="dark gras" href="#liste">Liste complète</a> : Liste de tous les NoBlemeux qui ont participé à au moins une IRL</li>
      </ul>
    </div>

    <br>

    <div class="body_main smallsize" id="habitues">
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros" colspan="4">
            LES HABITUÉS DES IRL NOBLEMEUSES
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre">
            Nombre d'IRL
          </td>
          <td class="cadre_gris_sous_titre">
            Première IRL
          </td>
          <td class="cadre_gris_sous_titre">
            Dernière IRL
          </td>
        </tr>
        <?php for($i=0;$i<$nhabitues;$i++) { ?>
        <tr>
          <td class="cadre_gris align_center">
            <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$habitues_id[$i]?>"><?=$habitues_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris align_center">
            <span class="gras"><?=$habitues_nombre[$i]?></span> (<?=$habitues_pourcent[$i]?>%)
          </td>
          <td class="cadre_gris align_center">
            <a class="dark blank" href="<?=$chemin?>pages/nobleme/irl?irl=<?=$habitues_premiereid[$i]?>"><?=$habitues_premiere[$i]?></a>
          </td>
          <td class="cadre_gris align_center">
            <a class="dark blank" href="<?=$chemin?>pages/nobleme/irl?irl=<?=$habitues_derniereid[$i]?>"><?=$habitues_derniere[$i]?></a>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

    <br>

    <div class="body_main irlstats_frequence" id="frequence">
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros" colspan="2">
            FRÉQUENCE DES IRL
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre">
            Année
          </td>
          <td class="cadre_gris_sous_titre">
            Nombre d'IRL
          </td>
        </tr>
        <?php for($i=($nfrequence-1);$i>=$irloriginelle;$i--) { ?>
        <tr>
          <td class="cadre_gris align_center gras">
            <?=$frequence_annee[$i]?>
          </td>
          <td class="cadre_gris align_center gras">
            <?=$frequence_count[$i]?>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

    <br>

    <div class="body_main smallsize" id="liste">
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros" colspan="4">
            LISTE COMPLÈTE DES PARTICIPANTS AUX IRLS NOBLEMEUSES
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre">
            Nombre d'IRL
          </td>
          <td class="cadre_gris_sous_titre">
            Première IRL
          </td>
          <td class="cadre_gris_sous_titre">
            Dernière IRL
          </td>
        </tr>
        <?php for($i=0;$i<$nirliste;$i++) { ?>
        <tr>
          <td class="cadre_gris align_center">
            <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$irliste_id[$i]?>"><?=$irliste_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris align_center<?=$irliste_style[$i]?>">
            <?=$irliste_nombre[$i]?>
          </td>
          <?php if($irliste_nombre[$i] > 1) { ?>
          <td class="cadre_gris align_center">
            <a class="dark blank" href="<?=$chemin?>pages/nobleme/irl?irl=<?=$irliste_premiereid[$i]?>"><?=$irliste_premiere[$i]?></a>
          </td>
          <td class="cadre_gris align_center">
            <a class="dark blank" href="<?=$chemin?>pages/nobleme/irl?irl=<?=$irliste_derniereid[$i]?>"><?=$irliste_derniere[$i]?></a>
          </td>
          <?php } else { ?>
          <td class="cadre_gris align_center" colspan="2">
            <a class="dark blank" href="<?=$chemin?>pages/nobleme/irl?irl=<?=$irliste_premiereid[$i]?>"><?=$irliste_premiere[$i]?></a>
          </td>
          <?php } ?>
        </tr>
        <?php } ?>
      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';