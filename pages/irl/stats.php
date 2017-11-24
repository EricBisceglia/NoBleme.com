<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'IRLStats';

// Identification
$page_nom = "Recalcule les statistiques des IRL";
$page_url = "pages/irl/stats";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Statistiques des IRL" : "Real life meetup stats";
$page_desc  = "Statistiques des rencontres IRL des NoBlemeux";

// CSS & JS
$css = array('onglets');
$js  = array('onglets');




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
  // Première IRL
  $temp_id = $dhabitues['irlstat_id'];
  $qpremiereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = '$temp_id'
                                              AND       irl_participants.FKirl      = irl.id
                                              ORDER BY  irl.date ASC "));

  // Dernière IRL
  $qderniereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = '$temp_id'
                                              AND       irl_participants.FKirl      = irl.id
                                              AND       irl.date                    < '$irldatenow'
                                              ORDER BY  irl.date DESC "));

  // Reste plus qu'à préparer les données pour l'affichage
  $habitues_id[$nhabitues]          = $dhabitues['irlstat_id'];
  $habitues_pseudo[$nhabitues]      = predata($dhabitues['irlstat_pseudo']);
  $habitues_nombre[$nhabitues]      = $dhabitues['irlstat_nombre'];
  $habitues_pourcent[$nhabitues]    = predata(round(($dhabitues['irlstat_nombre']/$totalirls)*100,0));
  $habitues_premiereid[$nhabitues]  = $qpremiereirl['irlid'];
  $habitues_premiere[$nhabitues]    = predata(jourfr($qpremiereirl['irldate'], $lang, 1));
  $habitues_derniereid[$nhabitues]  = $qderniereirl['irlid'];
  $habitues_derniere[$nhabitues]    = predata(jourfr($qderniereirl['irldate'], $lang, 1));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Liste des participants

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
  // Première IRL
  $temp_id = $dirliste['irlstat_id'];
  $qpremiereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = '$temp_id'
                                              AND       irl_participants.FKirl      = irl.id
                                              ORDER BY  irl.date ASC "));

  // Dernière IRL
  $qderniereirl = mysqli_fetch_array(query("  SELECT    irl.id    AS 'irlid' ,
                                                        irl.date  AS 'irldate'
                                              FROM      irl_participants ,
                                                        irl
                                              WHERE     irl_participants.FKmembres  = '$temp_id'
                                              AND       irl_participants.FKirl      = irl.id
                                              AND       irl.date                    < '$irldatenow'
                                              ORDER BY  irl.date DESC "));

  // Reste plus qu'à préparer les données pour l'affichage
  $irliste_id[$nirliste]          = $dirliste['irlstat_id'];
  $irliste_pseudo[$nirliste]      = predata($dirliste['irlstat_pseudo']);
  $irliste_nombre[$nirliste]      = $dirliste['irlstat_nombre'];
  $irliste_css[$nirliste]         = ($dirliste['irlstat_nombre'] >= 5) ? ' class="gras"' : '';
  $irliste_premiereid[$nirliste]  = $qpremiereirl['irlid'];
  $irliste_premiere[$nirliste]    = predata(jourfr($qpremiereirl['irldate'], $lang, 1));
  $irliste_derniereid[$nirliste]  = $qderniereirl['irlid'];
  $irliste_derniere[$nirliste]    = predata(jourfr($qderniereirl['irldate'], $lang, 1));
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




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']            = "Statistiques des IRL";
  $trad['soustitre']        = "Les rencontres entre NoBlemeux, en chiffres";
  $trad['desc']             = <<<EOD
Cette page contient diverses statistiques portant sur les <a class="gras" href="{$chemin}pages/irl/index">rencontres IRL</a> entre NoBlemeux. Les IRL ont eu lieu régulièrement depuis 2005, mais ce n'est que depuis fin 2012 qu'elles sont organisées et listées sur le site internet. Par conséquent, les stats ne commencent qu'en automne 2012.
EOD;

  // Onglets
  $trad['ong_habitues']     = "LES HABITUÉS";
  $trad['ong_participants'] = "LISTE DES PARTICIPANTS";
  $trad['ong_frequence']    = "FRÉQUENCE DES IRL";

  // Les habitués + Liste des participants
  $trad['hab_pseudo']       = "PSEUDONYME";
  $trad['hab_nombre']       = "NOMBRE D'IRL";
  $trad['hab_premiere']     = "PREMIÈRE IRL";
  $trad['hab_derniere']     = "DERNIÈRE IRL";

  // Fréquence des IRL
  $trad['freq_annee']       = "ANNÉE";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']            = "Meetup statistics";
  $trad['soustitre']        = "NoBleme's real life meetups, by the numbers";
  $trad['desc']             = <<<EOD
This page contains statistics about NoBleme's <a class="gras" href="{$chemin}pages/irl/index">real life meetups</a>. Meetups have been happening regularly on NoBleme since 2005, but they've only been tracked on the website since late 2012.
EOD;

  // Onglets
  $trad['ong_habitues']     = "THE USUAL SUSPECTS";
  $trad['ong_participants'] = "FULL ATTENDEE LIST";
  $trad['ong_frequence']    = "MEETUP FREQUENCY";

  // Les habitués + Liste des participants
  $trad['hab_pseudo']       = "NICKNAME";
  $trad['hab_nombre']       = "MEETUPS";
  $trad['hab_premiere']     = "FIRST MEETUP";
  $trad['hab_derniere']     = "LATEST NEETUP";

  // Fréquence des IRL
  $trad['freq_annee']       = "YEAR";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['desc']?></p>

        <br>
        <br>

        <ul class="onglet">
          <li>
            <a id="irl_habitues_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, 'irl_habitues')"><?=$trad['ong_habitues']?></a>
          </li>
          <li>
            <a id="irl_participants_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'irl_participants')"><?=$trad['ong_participants']?></a>
          </li>
          <li>
            <a id="irl_frequence_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'irl_frequence')"><?=$trad['ong_frequence']?></a>
          </li>
        </ul>

        <div id="irl_habitues" class="contenu_onglet">

          <table class="grid titresnoirs altc">
            <thead>
              <tr>
                <th>
                  <?=$trad['hab_pseudo']?>
                </th>
                <th>
                  <?=$trad['hab_nombre']?>
                </th>
                <th>
                  <?=$trad['hab_premiere']?>
                </th>
                <th>
                  <?=$trad['hab_derniere']?>
                </th>
              </tr>
            </thead>
            <tbody class="align_center">
              <?php for($i=0;$i<$nhabitues;$i++) { ?>
              <tr>
                <td class="gras">
                  <a href="<?=$chemin?>pages/user/user?id=<?=$habitues_id[$i]?>"><?=$habitues_pseudo[$i]?></a>
                </td>
                <td>
                  <span class="gras"><?=$habitues_nombre[$i]?></span> (<?=$habitues_pourcent[$i]?>%)
                </td>
                <td>
                  <a href="<?=$chemin?>pages/irl/irl?id=<?=$habitues_premiereid[$i]?>"><?=$habitues_premiere[$i]?></a>
                </td>
                <td>
                  <a href="<?=$chemin?>pages/irl/irl?id=<?=$habitues_derniereid[$i]?>"><?=$habitues_derniere[$i]?></a>
                </td>
                <?php } ?>
              </tr>
            </tbody>
          </table>

        </div>

        <div id="irl_participants" class="hidden contenu_onglet">

          <table class="grid titresnoirs altc">
            <thead>
              <tr>
                <th>
                  <?=$trad['hab_pseudo']?>
                </th>
                <th>
                  <?=$trad['hab_nombre']?>
                </th>
                <th>
                  <?=$trad['hab_premiere']?>
                </th>
                <th>
                  <?=$trad['hab_derniere']?>
                </th>
              </tr>
            </thead>
            <tbody class="align_center">
              <?php for($i=0;$i<$nirliste;$i++) { ?>
              <tr>
                <td class="gras">
                  <a href="<?=$chemin?>pages/user/user?id=<?=$irliste_id[$i]?>"><?=$irliste_pseudo[$i]?></a>
                </td>
                <td<?=$irliste_css[$i]?>>
                  <?=$irliste_nombre[$i]?>
                </td>
                <td>
                  <a href="<?=$chemin?>pages/irl/irl?id=<?=$irliste_premiereid[$i]?>"><?=$irliste_premiere[$i]?></a>
                </td>
                <td>
                  <a href="<?=$chemin?>pages/irl/irl?id=<?=$irliste_derniereid[$i]?>"><?=$irliste_derniere[$i]?></a>
                </td>
                <?php } ?>
              </tr>
            </tbody>
          </table>

        </div>

        <div id="irl_frequence" class="hidden contenu_onglet">

          <div class="microtexte">

            <table class="grid titresnoirs altc">
              <thead>
                <tr>
                  <th>
                    <?=$trad['freq_annee']?>
                  </th>
                  <th>
                    <?=$trad['hab_nombre']?>
                  </th>
                </tr>
              </thead>
              <tbody class="align_center">
                <?php for($i=($nfrequence-1);$i>=$irloriginelle;$i--) { ?>
                <tr>
                  <td class="gras">
                    <?=$frequence_annee[$i]?>
                  </td>
                  <td>
                    <?=$frequence_count[$i]?>
                  </td>
                  <?php } ?>
                </tr>
              </tbody>
            </table>

          </div>

        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';