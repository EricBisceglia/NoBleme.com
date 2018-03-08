<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'MiscStats';

// Identification
$page_nom = "Recalcule les statistiques des miscellanées";
$page_url = "pages/quotes/stats";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Statistiques des miscellanées";
$page_desc  = "Intéractions entre NoBlemeux qui ont été conservées pour la postérité";

// CSS & JS
$css = array('onglets');
$js  = array('onglets');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pour commencer, on a besoin de connaitre le nombre total de miscellanées passées

$qtotalmisc = mysqli_fetch_array(query(" SELECT COUNT(*) AS 'nbmisc' FROM quotes WHERE valide_admin = 1 "));
$totalmisc  = $qtotalmisc['nbmisc'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Les réguliers

// On commence par aller chercher tous les noblemeux qui sont cités
$qreguliers = query(" SELECT    membres.id                AS 'miscstat_id'     ,
                                membres.pseudonyme        AS 'miscstat_pseudo' ,
                                COUNT(quotes_membres.id)  AS 'miscstat_nombre'
                      FROM      quotes_membres  ,
                                quotes          ,
                                membres
                      WHERE     quotes.valide_admin         = 1
                      AND       quotes_membres.FKquotes     = quotes.id
                      AND       quotes_membres.FKmembres    = membres.id
                      GROUP BY  quotes_membres.FKmembres
                      HAVING    COUNT(quotes_membres.id)  >= 5
                      ORDER BY  COUNT(quotes_membres.id)  DESC ,
                                membres.pseudonyme        ASC  ");

// On va chercher les infos supplémentaires et préparer pour l'affichage
for($nreguliers = 0 ; $dreguliers = mysqli_fetch_array($qreguliers) ; $nreguliers++)
{
  // Première miscellanée
  $temp_id = $dreguliers['miscstat_id'];
  $qpremieremisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'miscid' ,
                                                        quotes.timestamp  AS 'miscdate'
                                              FROM      quotes_membres ,
                                                        quotes
                                              WHERE     quotes_membres.FKmembres  = '$temp_id'
                                              AND       quotes_membres.FKquotes   = quotes.id
                                              AND       quotes.valide_admin       = 1
                                              ORDER BY  quotes.timestamp ASC "));

  // Dernière miscellanée
  $qdernieremisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'miscid' ,
                                                        quotes.timestamp  AS 'miscdate'
                                              FROM      quotes_membres ,
                                                        quotes
                                              WHERE     quotes_membres.FKmembres  = '$temp_id'
                                              AND       quotes_membres.FKquotes   = quotes.id
                                              AND       quotes.valide_admin       = 1
                                              ORDER BY  quotes.timestamp DESC "));

  // Reste plus qu'à préparer les données pour l'affichage
  $reguliers_id[$nreguliers]          = $dreguliers['miscstat_id'];
  $reguliers_pseudo[$nreguliers]      = predata($dreguliers['miscstat_pseudo']);
  $reguliers_nombre[$nreguliers]      = $dreguliers['miscstat_nombre'];
  $reguliers_pourcent[$nreguliers]    = predata(round(($dreguliers['miscstat_nombre']/$totalmisc)*100,0));
  $reguliers_premiereid[$nreguliers]  = $qpremieremisc['miscid'];
  $reguliers_premiere[$nreguliers]    = (!$qpremieremisc['miscdate']) ? 'Date inconnue' : predata(jourfr(date('Y-m-d', $qpremieremisc['miscdate']), $lang, 1));
  $reguliers_derniereid[$nreguliers]  = $qdernieremisc['miscid'];
  $reguliers_derniere[$nreguliers]    = (!$qdernieremisc['miscdate']) ? 'Date inconnue' : predata(jourfr(date('Y-m-d', $qdernieremisc['miscdate']), $lang, 1));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Membres cités

// On commence par aller chercher tous les noblemeux qui sont cités
$qmiscliste = query(" SELECT    membres.id                AS 'miscstat_id'     ,
                                membres.pseudonyme        AS 'miscstat_pseudo' ,
                                COUNT(quotes_membres.id)  AS 'miscstat_nombre'
                      FROM      quotes_membres  ,
                                quotes          ,
                                membres
                      WHERE     quotes.valide_admin         = 1
                      AND       quotes_membres.FKquotes     = quotes.id
                      AND       quotes_membres.FKmembres    = membres.id
                      GROUP BY  quotes_membres.FKmembres
                      ORDER BY  membres.pseudonyme        ASC  ");

// On va chercher les infos supplémentaires et préparer pour l'affichage
for($nmiscliste = 0 ; $dmiscliste = mysqli_fetch_array($qmiscliste) ; $nmiscliste++)
{
  // Première miscellanée
  $temp_id = $dmiscliste['miscstat_id'];
  $qpremieremisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'miscid' ,
                                                        quotes.timestamp  AS 'miscdate'
                                              FROM      quotes_membres ,
                                                        quotes
                                              WHERE     quotes_membres.FKmembres  = '$temp_id'
                                              AND       quotes_membres.FKquotes   = quotes.id
                                              AND       quotes.valide_admin       = 1
                                              ORDER BY  quotes.timestamp ASC "));

  // Dernière miscellanée
  $qdernieremisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'miscid' ,
                                                        quotes.timestamp  AS 'miscdate'
                                              FROM      quotes_membres ,
                                                        quotes
                                              WHERE     quotes_membres.FKmembres  = '$temp_id'
                                              AND       quotes_membres.FKquotes   = quotes.id
                                              AND       quotes.valide_admin       = 1
                                              ORDER BY  quotes.timestamp DESC "));

  // Reste plus qu'à préparer les données pour l'affichage
  $miscliste_id[$nmiscliste]          = $dmiscliste['miscstat_id'];
  $miscliste_pseudo[$nmiscliste]      = predata($dmiscliste['miscstat_pseudo']);
  $miscliste_nombre[$nmiscliste]      = $dmiscliste['miscstat_nombre'];
  $miscliste_css[$nmiscliste]         = ($dmiscliste['miscstat_nombre'] >= 5) ? ' class="gras"' : '';
  $miscliste_premiereid[$nmiscliste]  = $qpremieremisc['miscid'];
  $miscliste_premiere[$nmiscliste]    = (!$qpremieremisc['miscdate']) ? 'Date inconnue' : predata(jourfr(date('Y-m-d',$qpremieremisc['miscdate']), $lang, 1));
  $miscliste_derniereid[$nmiscliste]  = $qdernieremisc['miscid'];
  $miscliste_derniere[$nmiscliste]    = (!$qdernieremisc['miscdate']) ? 'Date inconnue' : predata(jourfr(date('Y-m-d',$qdernieremisc['miscdate']), $lang, 1));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Fréquence

// D'abord on veut l'année de la miscellanée la plus ancienne
$qmiscoriginelle  = mysqli_fetch_array(query(" SELECT YEAR(FROM_UNIXTIME(quotes.timestamp)) AS 'miscoriginelle' FROM quotes WHERE quotes.timestamp > 0 AND valide_admin = 1 ORDER BY quotes.timestamp ASC "));
$miscoriginelle    = $qmiscoriginelle['miscoriginelle'];

// Maintenant qu'on a la première année, on parcourt jusqu'à cette année et on prépare pour l'affichage
for($nfrequence = $miscoriginelle ; $nfrequence <= date('Y') ; $nfrequence++)
{
  // On va chercher le nombre de miscellanées pour l'année concernée
  $qfrequencemisc = mysqli_fetch_array(query(" SELECT COUNT(*) AS 'frequencemisc' FROM quotes WHERE YEAR(FROM_UNIXTIME(quotes.timestamp)) = '$nfrequence' AND valide_admin = 1 "));

  // Et on prépare les donnéespour l'affichage
  $frequence_annee[$nfrequence] = $nfrequence;
  $frequence_count[$nfrequence] = $qfrequencemisc['frequencemisc'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Stats: Contributeurs

// On va chercher les plus grands contributeurs
$qmisccontrib = query(" SELECT    COUNT(quotes.FKauteur)  AS 'q_nombre' ,
                                  membres.pseudonyme      AS 'm_pseudo' ,
                                  membres.id              AS 'm_id'
                        FROM      quotes
                        LEFT JOIN membres ON quotes.FKauteur = membres.id
                        WHERE     quotes.valide_admin = 1
                        GROUP BY  quotes.FKauteur
                        ORDER BY  COUNT(quotes.FKauteur)  DESC  ,
                                  membres.pseudonyme      ASC   ");

// Et on les prépare pour l'affichage
for($nmisccontrib = 0; $dmisccontrib = mysqli_fetch_array($qmisccontrib); $nmisccontrib++)
{
  $misccontrib_nombre[$nmisccontrib]  = $dmisccontrib['q_nombre'];
  $misccontrib_pseudo[$nmisccontrib]  = predata($dmisccontrib['m_pseudo']);
  $misccontrib_id[$nmisccontrib]      = $dmisccontrib['m_id'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Statistiques des miscellanées</h1>

        <h5>Petites citations amisantes, en chiffres</h5>

        <p class="italique">
          Miscellanée : nom féminin, ordinairement au pluriel.<br>
          Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.
        </p>

        <p>
          Cette page contient diverses statistiques portant sur les <a class="gras" href="<?=$chemin?>pages/quotes/index">miscellanées</a>. Les miscellanées sont accumulées depuis 2005, mais ce n'est que depuis fin 2012 qu'elles sont datées. Par conséquent, il manque les dates des miscellanées datant d'avant l'automne 2012.
        </p>

        <br>
        <br>

        <ul class="onglet">
          <li>
            <a id="misc_reguliers_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, 'misc_reguliers')">LES RÉGULIERS</a>
          </li>
          <li>
            <a id="misc_membres_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'misc_membres')">MEMBRES CITÉS</a>
          </li>
          <li>
            <a id="misc_frequence_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'misc_frequence')">FRÉQUENCE</a>
          </li>
          <li>
            <a id="misc_contributeurs_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'misc_contributeurs')">CONTRIBUTEURS</a>
          </li>
        </ul>

        <div id="misc_reguliers" class="contenu_onglet">

          <table class="grid titresnoirs altc">
            <thead>
              <tr>
                <th>
                  PSEUDONYME
                </th>
                <th>
                  APPARITIONS
                </th>
                <th>
                  PREMIÈRE APPARITION
                </th>
                <th>
                  DERNIÈRE APPARITION
                </th>
              </tr>
            </thead>
            <tbody class="align_center">
              <?php for($i=0;$i<$nreguliers;$i++) { ?>
              <tr>
                <td class="gras">
                  <a href="<?=$chemin?>pages/user/user?id=<?=$reguliers_id[$i]?>"><?=$reguliers_pseudo[$i]?></a>
                </td>
                <td>
                  <span class="gras"><?=$reguliers_nombre[$i]?></span> (<?=$reguliers_pourcent[$i]?>%)
                </td>
                <td>
                  <a href="<?=$chemin?>pages/quotes/quote?id=<?=$reguliers_premiereid[$i]?>"><?=$reguliers_premiere[$i]?></a>
                </td>
                <td>
                  <a href="<?=$chemin?>pages/quotes/quote?id=<?=$reguliers_derniereid[$i]?>"><?=$reguliers_derniere[$i]?></a>
                </td>
                <?php } ?>
              </tr>
            </tbody>
          </table>

        </div>

        <div id="misc_membres" class="contenu_onglet hidden">

          <table class="grid titresnoirs altc">
            <thead>
              <tr>
                <th>
                  PSEUDONYME
                </th>
                <th>
                  APPARITIONS
                </th>
                <th>
                  PREMIÈRE APPARITION
                </th>
                <th>
                  DERNIÈRE APPARITION
                </th>
              </tr>
            </thead>
            <tbody class="align_center">
              <?php for($i=0;$i<$nmiscliste;$i++) { ?>
              <tr>
                <td class="gras">
                  <a href="<?=$chemin?>pages/user/user?id=<?=$miscliste_id[$i]?>"><?=$miscliste_pseudo[$i]?></a>
                </td>
                <td<?=$miscliste_css[$i]?>>
                  <?=$miscliste_nombre[$i]?>
                </td>
                <td>
                  <a href="<?=$chemin?>pages/quotes/quote?id=<?=$miscliste_premiereid[$i]?>"><?=$miscliste_premiere[$i]?></a>
                </td>
                <td>
                  <a href="<?=$chemin?>pages/quotes/quote?id=<?=$miscliste_derniereid[$i]?>"><?=$miscliste_derniere[$i]?></a>
                </td>
                <?php } ?>
              </tr>
            </tbody>
          </table>

        </div>

        <div id="misc_frequence" class="contenu_onglet hidden">

          <div class="microtexte">

            <table class="grid titresnoirs altc">
              <thead>
                <tr>
                  <th>
                    ANNÉE
                  </th>
                  <th>
                    MISCELLANÉES
                  </th>
                </tr>
              </thead>
              <tbody class="align_center">
                <?php for($i=($nfrequence-1);$i>=$miscoriginelle;$i--) { ?>
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

        <div id="misc_contributeurs" class="contenu_onglet hidden">

          <div class="minitexte">

            <table class="grid titresnoirs altc">
              <thead>
                <tr>
                  <th>
                    PSEUDONYME
                  </th>
                  <th>
                    PROPOSITIONS DE<br>MISCELLANÉES<br>ACCEPTÉES
                  </th>
                </tr>
              </thead>
              <tbody class="align_center">
                <?php for($i=0;$i<$nmisccontrib;$i++) { ?>
                <tr>
                  <td class="gras">
                    <a href="<?=$chemin?>pages/user/user?id=<?=$misccontrib_id[$i]?>"><?=$misccontrib_pseudo[$i]?></a>
                  </td>
                  <td>
                    <?=$misccontrib_nombre[$i]?>
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