<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Stats des miscellanées";
$page_desc  = "Statistiques sur les miscellanées (citations de NoBlemeux)";

// Identification
$page_nom = "quotes";
$page_id  = "stats";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Pour commencer, on a besoin de connaitre le nombre total de miscellanées
$qtotalmisc = mysqli_fetch_array(query(" SELECT COUNT(*) AS 'nbquotes' FROM quotes "));
$totalmisc  = $qtotalmisc['nbquotes'];

// On va récupérer les stats des miscellanées
$qmiscstats = query(" SELECT    membres.id                AS 'qsid'   ,
                                membres.pseudonyme        AS 'qsnick' ,
                                COUNT(quotes_membres.id)  AS 'qsnum'
                      FROM      quotes_membres
                      LEFT JOIN membres ON quotes_membres.FKmembres = membres.id
                      GROUP BY  quotes_membres.FKmembres
                      ORDER BY  COUNT(quotes_membres.id)  DESC  ,
                                membres.pseudonyme        ASC   ");

// Et on les prépare pour l'affichage
for($nmiscstats = 0 ; $dmiscstats = mysqli_fetch_array($qmiscstats) ; $nmiscstats++)
{
  $miscstats_id[$nmiscstats]        = $dmiscstats['qsid'];
  $miscstats_pseudo[$nmiscstats]    = $dmiscstats['qsnick'];
  $miscstats_num[$nmiscstats]       = $dmiscstats['qsnum'];
  $miscstats_pourcent[$nmiscstats]  = number_format(round(($dmiscstats['qsnum']/$totalmisc)*100,1),1);

  // On va fetch la première apparition
  $idqmembre = $dmiscstats['qsid'];
  $qpremieremisc = mysqli_fetch_array(query(" SELECT    quotes.timestamp AS 'qtime'
                                              FROM      quotes_membres
                                              LEFT JOIN quotes ON quotes_membres.FKquotes = quotes.id
                                              WHERE     quotes_membres.FKmembres = '$idqmembre'
                                              ORDER BY  quotes.timestamp ASC
                                              LIMIT     1 "));
  $miscstats_premiere[$nmiscstats]  = ($qpremieremisc['qtime']) ? jourfr(date('Y-m-d',$qpremieremisc['qtime']),1) : 'Inconnue (avant 2012)';

  // Et la dernière apparition
  $qdernieremisc = mysqli_fetch_array(query(" SELECT    quotes.timestamp AS 'qtime'
                                              FROM      quotes_membres
                                              LEFT JOIN quotes ON quotes_membres.FKquotes = quotes.id
                                              WHERE     quotes_membres.FKmembres = '$idqmembre'
                                              ORDER BY  quotes.timestamp DESC
                                              LIMIT     1 "));
  $miscstats_derniere[$nmiscstats]  = ($qdernieremisc['qtime']) ? jourfr(date('Y-m-d',$qdernieremisc['qtime']),1) : 'Inconnue (avant 2012)';
}


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/miscellanees.png" alt="Miscellanées">
    </div>
    <br>

    <div class="body_main smallsize">
      <span class="titre">Les miscellanées en chiffres</span><br>
      <br>
      Sur cette page, vous trouverez la liste des <a href="<?=$chemin?>pages/nobleme/membres">membres</a> les plus présents dans les <a href="<?=$chemin?>pages/irc/quotes">miscellanées</a>.<br>
      Si vous vous demandez ce qu'est une miscellanée, cliquez sur <a href="<?=$chemin?>pages/irc/quotes">ce lien</a> et vous saurez.<br>
      <br>
      À noter, les dates des miscellanées datant d'avant 2012 sont manquantes, c'est pourquoi vous verrez des membres pour lesquels la première et/ou dernière apparition sera  « Inconnue (avant 2012) ».
    </div>

    <br>

    <div class="body_main smallsize">
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros" colspan="4">MEMBRES LES PLUS CITÉS DANS LES MISCELLANÉES</td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre">Pseudonyme</td>
          <td class="cadre_gris_sous_titre">Nombre</td>
          <td class="cadre_gris_sous_titre">Première apparition</td>
          <td class="cadre_gris_sous_titre">Dernière apparition</td>
        </tr>
        <?php for($i=0;$i<$nmiscstats;$i++) { ?>
        <tr>
          <td class="cadre_gris align_center">
            <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$miscstats_id[$i]?>"><?=$miscstats_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris align_center">
            <span class="gras"><?=$miscstats_num[$i]?></span> (<?=$miscstats_pourcent[$i]?>%)
          </td>
          <td class="cadre_gris align_center">
            <?=$miscstats_premiere[$i]?>
          </td>
          <td class="cadre_gris align_center">
            <?=$miscstats_derniere[$i]?>
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