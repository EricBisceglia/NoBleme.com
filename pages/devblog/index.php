<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Liste des devblogs";
$page_desc  = "Écrits techniques vulgarisés portant parfois sur le développement de NoBleme, parfois sur le monde de l'informatique en général";

// Identification
$page_nom = "devblog";
$page_id  = "index";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les devblogs, par ordre chronologique
$qdevblog = query(" SELECT    devblog.id        ,
                              devblog.timestamp ,
                              devblog.titre     ,
                              devblog.resume
                    FROM      devblog
                    ORDER BY  devblog.timestamp DESC  ");

// Et on prépare pour l'affichage
for($ndevblog = 0 ; $ddevblog = mysqli_fetch_array($qdevblog) ; $ndevblog++)
{
  $devblog_id[$ndevblog]      = $ddevblog['id'];
  $devblog_titre[$ndevblog]   = $ddevblog['titre'];
  $devblog_date[$ndevblog]    = jourfr(date('Y-m-d',$ddevblog['timestamp']));
  $devblog_resume[$ndevblog]  = htmlspecialchars_decode($ddevblog['resume']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/devblog.png" alt="Devblog">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Pourquoi le devblog ?</span><br>
      <br>
      Comme son nom l'indique, il s'agit d'un blog de développement, un lieu où je peux parler de ce que je fais « derrière les rideaux ».<br>
      <br>
      L'intérêt du devblog est le suivant :<br>
      <br>
      <ul class="dotlist">
        <li class="spaced">
          Avoir un endroit où je peux présenter les mises à jour du site aux utilisateurs et expliquer le pourquoi des changements
        </li>
        <li class="spaced">
          Donner une vue de ce qui se passe du côté technique de NoBleme aux curieux que ça peut intéresser
        </li>
        <li class="spaced">
          J'aime beaucoup vulgariser l'informatique (expliquer des choses complexes avec des analogies et des termes simples), ça me fait un endroit où le faire, et ainsi partager un peu les dessous de mon métier aux novices qui se demandent à quoi ça ressemble
        </li>
        <li class="spaced">
          Si on me pose souvent une question technique, avoir un endroit où répondre de façon détaillée et/ou définitive à la question afin d'y renvoyer les gens qui me reposeraient encore et encore la question par la suite
        </li>
      </ul>
      <br>
      <br>
      <span class="soustitre">Suivre les devblogs</span><br>
      <br>
      Il existe un <a href="<?=$chemin?>pages/doc/rss">flux RSS</a> permettant de d'être notifié de la publication de nouveaux devblogs, disponible sur <a href="<?=$chemin?>pages/devblog/rss">cette page</a>.
    </div>

    <br>

    <div class="body_main bigsize">
      <span class="titre">Liste des devblogs</span><br>
      <br>
      Ci-dessous, tous les articles publiés dans le blog de développement, du plus récent au plus ancien.<br>
      Pour accéder à un devblog dans la liste, cliquez sur son titre.<br>
      <br>
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros">
            Titre
          </td>
          <td class="cadre_gris_titre moinsgros">
            Publication
          </td>
          <td class="cadre_gris_titre moinsgros">
            Résumé du contenu
          </td>
        </tr>
        <?php for($i=0;$i<$ndevblog;$i++) { ?>
        <?php if($i != 0) { ?>
        <tr>
          <td class="cadre_gris_vide_discret" colspan="3">
          </td>
        </tr>
        <?php } ?>
        <tr>
          <td class="cadre_gris align_center spaced gras">
            <a class="blank dark" href="<?=$chemin?>pages/devblog/blog?id=<?=$devblog_id[$i]?>"><?=$devblog_titre[$i]?></a>
          </td>
          <td class="cadre_gris align_center spaced nowrap">
            <?=$devblog_date[$i]?>
          </td>
          <td class="cadre_gris align_center spaced">
            <?=$devblog_resume[$i]?>
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