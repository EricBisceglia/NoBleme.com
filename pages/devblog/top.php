<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Devblogs populaires";
$page_desc  = "Blogs de développement de NoBleme les plus populaires";

// Identification
$page_nom = "devblog";
$page_id  = "top";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les devblogs, par ordre chronologique
$qdevblog = query(" SELECT    devblog.id                ,
                              devblog.timestamp         ,
                              devblog.titre             ,
                              devblog.score_popularite  ,
                              count(devblog_commentaire.id) AS coms

                    FROM      devblog
                    LEFT JOIN devblog_commentaire ON  devblog.id = devblog_commentaire.FKdevblog
                    LEFT JOIN stats_pageviews     ON (devblog.id = stats_pageviews.id_page
                                                  AND stats_pageviews.nom_page LIKE 'devblog' )

                    GROUP BY  devblog.id
                    ORDER BY  devblog.score_popularite  DESC ,
                              stats_pageviews.vues      DESC ,
                              devblog.id                DESC ");

// Et on prépare pour l'affichage
for($ndevblog = 0 ; $ddevblog = mysqli_fetch_array($qdevblog) ; $ndevblog++)
{
  $devblog_id[$ndevblog]            = $ddevblog['id'];
  $devblog_titre[$ndevblog]         = $ddevblog['titre'];
  $devblog_date[$ndevblog]          = ilya($ddevblog['timestamp']);
  $devblog_popularite[$ndevblog]    = $ddevblog['score_popularite'];
  $devblog_commentaires[$ndevblog]  = (!$ddevblog['coms']) ? '' : $ddevblog['coms'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/devblog/">
        <img src="<?=$chemin?>img/logos/devblog.png" alt="Devblog">
      </a>
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Devblogs populaires</span><br>
      <br>
      Ci-dessous, la liste des <a href="<?=$chemin?>pages/devblog/index">blogs de développement</a> postés sur NoBleme, classés par ordre de popularité.<br>
      Pour accéder à un devblog dans la liste, cliquez sur son titre.<br>
      <br>
      La popularité est déterminée par une formule (pas vraiment) secrète qui prend en compte les éléments suivants :<br>
      <div class="alinea">
        - Nombre de vues totales et dans les mois récents<br>
        - Nombre de commentaires postés en réponse<br>
        - Temps écoulé depuis la publication du devblog
      </div>
    </div>

    <br>

    <div class="body_main bigsize">
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Devblog
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Popularité
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Publication
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Commentaires
          </td>
        </tr>
        <?php for($i=0;$i<$ndevblog;$i++) { ?>
        <tr>
          <td class="cadre_gris_vide_discret" colspan="4">
          </td>
        </tr>
        <tr>
          <td class="cadre_gris align_center spaced gras">
            <a class="blank dark" href="<?=$chemin?>pages/devblog/blog?id=<?=$devblog_id[$i]?>"><?=$devblog_titre[$i]?></a>
          </td>
          <td class="cadre_gris align_center spaced gras">
            <?=$devblog_popularite[$i]?>
          </td>
          <td class="cadre_gris align_center spaced">
            <?=$devblog_date[$i]?>
          </td>
          <td class="cadre_gris align_center spaced">
            <?=$devblog_commentaires[$i]?>
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