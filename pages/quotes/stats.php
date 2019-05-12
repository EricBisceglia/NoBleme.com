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
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Statistiques des miscellanées" : "Miscellanea statistics";
$page_desc  = "Intéractions entre NoBlemeux qui ont été conservées pour la postérité";

// CSS & JS
$css = array('onglets');
$js  = array('onglets', 'dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Gestion des langues

// Langues pour le menu déroulant
$select_lang_fr = ($lang == 'FR') ? ' selected' : '';
$select_lang_en = ($lang == 'EN') ? ' selected' : '';

// Assemblage de la langue pour la requête
$temp_lang  = (!isset($_POST['misc_stats_langue'])) ? postdata(changer_casse($lang, 'maj'), 'string', 'FR') : postdata_vide('misc_stats_langue', 'string', 'FR');
$where_lang = ($temp_lang != 'All') ? " AND quotes.langue = '$temp_lang' " : "";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pour commencer, on a besoin de connaitre le nombre total de miscellanées passées

$qtotalmisc = mysqli_fetch_array(query("  SELECT  COUNT(*) AS 'nbmisc'
                                          FROM    quotes
                                          WHERE   quotes.valide_admin = 1
                                          $where_lang "));
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
                                $where_lang
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
                                                        $where_lang
                                              ORDER BY  quotes.timestamp ASC "));

  // Dernière miscellanée
  $qdernieremisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'miscid' ,
                                                        quotes.timestamp  AS 'miscdate'
                                              FROM      quotes_membres ,
                                                        quotes
                                              WHERE     quotes_membres.FKmembres  = '$temp_id'
                                              AND       quotes_membres.FKquotes   = quotes.id
                                              AND       quotes.valide_admin       = 1
                                                        $where_lang
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
                                $where_lang
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
                                                        $where_lang
                                              ORDER BY  quotes.timestamp ASC "));

  // Dernière miscellanée
  $qdernieremisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'miscid' ,
                                                        quotes.timestamp  AS 'miscdate'
                                              FROM      quotes_membres ,
                                                        quotes
                                              WHERE     quotes_membres.FKmembres  = '$temp_id'
                                              AND       quotes_membres.FKquotes   = quotes.id
                                              AND       quotes.valide_admin       = 1
                                                        $where_lang
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
$qmiscoriginelle  = mysqli_fetch_array(query("  SELECT    YEAR(FROM_UNIXTIME(quotes.timestamp)) AS 'miscoriginelle'
                                                FROM      quotes
                                                WHERE     quotes.timestamp > 0
                                                AND       valide_admin = 1
                                                          $where_lang
                                                ORDER BY  quotes.timestamp ASC "));
$miscoriginelle    = $qmiscoriginelle['miscoriginelle'];

// Maintenant qu'on a la première année, on parcourt jusqu'à cette année et on prépare pour l'affichage
for($nfrequence = $miscoriginelle ; $nfrequence <= date('Y') ; $nfrequence++)
{
  // On va chercher le nombre de miscellanées pour l'année concernée
  $qfrequencemisc = mysqli_fetch_array(query("  SELECT  COUNT(*) AS 'frequencemisc'
                                                FROM    quotes
                                                WHERE   YEAR(FROM_UNIXTIME(quotes.timestamp)) = '$nfrequence'
                                                AND     valide_admin = 1
                                                        $where_lang "));

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
                                  $where_lang
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
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']                  = "Statistiques des miscellanées";
  $trad['soustitre']              = "Petits chiffres pas très amusant sur les petites citations amusantes";
  $trad['desc1']                  = <<<EOD
Miscellanée : nom féminin, ordinairement au pluriel.<br>
Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.
EOD;
  $trad['desc2']                  = <<<EOD
Cette page contient diverses statistiques portant sur les <a class="gras" href="{$chemin}pages/quotes/index">miscellanées</a>. Les miscellanées sont accumulées depuis 2005, mais ce n'est que depuis fin 2012 qu'elles sont datées. Par conséquent, il manque les dates des miscellanées datant d'avant l'automne 2012.
EOD;

  // Formulaire de recherche
  $trad['qstats_search_lang']     = "Afficher les statistiques des miscellanées dans les langues suivantes :";
  $trad['qstats_search_langfr']   = "Citations en français uniquement";
  $trad['qstats_search_langen']   = "Citations en anglais uniquement";
  $trad['qstats_search_langall']  = "Toutes les citations (français + anglais)";

  // Onglets
  $trad['qstats_tab_reguliers']   = "LES RÉGULIERS";
  $trad['qstats_tab_cites']       = "MEMBRES CITÉS";
  $trad['qstats_tab_frequence']   = "FRÉQUENCE";
  $trad['qstats_tab_contrib']     = "CONTRIBUTEURS";

  // Tableaux
  $trad['qstats_pseudonyme']      = "PSEUDONYME";
  $trad['qstats_apparitions']     = "APPARITIONS";
  $trad['qstats_premier']         = "PREMIÈRE APPARITION";
  $trad['qstats_dernier']         = "DERNIÈRE APPARITION";
  $trad['qstats_annee']           = "ANNÉE";
  $trad['qstats_miscellanees']    = "MISCELLANÉES";
  $trad['qstats_propositions']    = "PROPOSITIONS DE<br>MISCELLANÉES<br>ACCEPTÉES";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']                  = "Miscellanea stats";
  $trad['soustitre']              = "Unfunny numbers about funny-ish quotes";
  $trad['desc1']                  = <<<EOD
Miscellanea: a collection of miscellaneous items, esp literary works.
EOD;
  $trad['desc2']                  = <<<EOD
This page contains various statistics about <a class="gras" href="{$chemin}pages/quotes/index">miscellanea</a>, various quotes stored on NoBleme.
EOD;

  // Formulaire de recherche
  $trad['qstats_search_lang']     = "Show statistics for quotes in the following languages:";
  $trad['qstats_search_langfr']   = "Quotes in french only";
  $trad['qstats_search_langen']   = "Quotes in english only";
  $trad['qstats_search_langall']  = "All the quotes (english + french)";

  // Onglets
  $trad['qstats_tab_reguliers']   = "REGULARS";
  $trad['qstats_tab_cites']       = "QUOTED USERS";
  $trad['qstats_tab_frequence']   = "FREQUENCY";
  $trad['qstats_tab_contrib']     = "CONTRIBUTORS";

  // Tableaux
  $trad['qstats_pseudonyme']      = "NICKNAME";
  $trad['qstats_apparitions']     = "APPEARANCES";
  $trad['qstats_premier']         = "FIRST APPEARANCE";
  $trad['qstats_dernier']         = "LAST APPEARANCE";
  $trad['qstats_annee']           = "YEAR";
  $trad['qstats_miscellanees']    = "QUOTES";
  $trad['qstats_propositions']    = "QUOTES PROPOSALS<br>ACCEPTED";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p class="italique"><?=$trad['desc1']?></p>

        <p><?=$trad['desc2']?></p>

        <br>

        <fieldset>

          <label for="misc_stats_langue"><?=$trad['qstats_search_lang']?></label>
          <select class="indiv" id="misc_stats_langue" name="misc_stats_langue" onchange="dynamique('<?=$chemin?>', 'stats', 'misc_stats_tableau', 'misc_stats_langue='+dynamique_prepare('misc_stats_langue'), 1);">
          <option value="FR"<?=$select_lang_fr?>><?=$trad['qstats_search_langfr']?></option>
          <option value="EN"<?=$select_lang_en?>><?=$trad['qstats_search_langen']?></option>
          <option value="All"><?=$trad['qstats_search_langall']?></option>
          </select><br>
          <br>

        </fieldset>

        <br>

        <div id="misc_stats_tableau">

        <?php } ?>

          <ul class="onglet">
            <li>
              <a id="misc_reguliers_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, 'misc_reguliers')"><?=$trad['qstats_tab_reguliers']?></a>
            </li>
            <li>
              <a id="misc_membres_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'misc_membres')"><?=$trad['qstats_tab_cites']?></a>
            </li>
            <li>
              <a id="misc_frequence_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'misc_frequence')"><?=$trad['qstats_tab_frequence']?></a>
            </li>
            <li>
              <a id="misc_contributeurs_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'misc_contributeurs')"><?=$trad['qstats_tab_contrib']?></a>
            </li>
          </ul>

          <div id="misc_reguliers" class="contenu_onglet">

            <table class="grid titresnoirs altc">
              <thead>
                <tr>
                  <th>
                    <?=$trad['qstats_pseudonyme']?>
                  </th>
                  <th>
                    <?=$trad['qstats_apparitions']?>
                  </th>
                  <th>
                    <?=$trad['qstats_premier']?>
                  </th>
                  <th>
                    <?=$trad['qstats_dernier']?>
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
                    <?=$trad['qstats_pseudonyme']?>
                  </th>
                  <th>
                    <?=$trad['qstats_apparitions']?>
                  </th>
                  <th>
                    <?=$trad['qstats_premier']?>
                  </th>
                  <th>
                    <?=$trad['qstats_dernier']?>
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
                      <?=$trad['qstats_annee']?>
                    </th>
                    <th>
                      <?=$trad['qstats_miscellanees']?>
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
                      <?=$trad['qstats_pseudonyme']?>
                    </th>
                    <th>
                      <?=$trad['qstats_propositions']?>
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

        <?php if(!getxhr()) { ?>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }