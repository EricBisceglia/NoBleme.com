<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Devblog';

// Identification
$page_nom = "Considère la liste des devblogs";
$page_url = "pages/devblog/index";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Devblogs";
$page_desc  = "Écrits techniques vulgarisés portant parfois sur le développement de NoBleme, parfois sur le monde de l&#39;informatique en général";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les devblogs
$qdevblogs = query("  SELECT    devblog.id        ,
                                devblog.timestamp ,
                                devblog.titre
                      FROM      devblog
                      ORDER BY  devblog.timestamp DESC ");

// Et on les prépare pour l'affichage
for($ndevblogs = 0; $ddevblogs = mysqli_fetch_array($qdevblogs); $ndevblogs++)
{
  $devblog_id[$ndevblogs]     = $ddevblogs['id'];
  $devblog_titre[$ndevblogs]  = predata($ddevblogs['titre']);
  $devblog_date[$ndevblogs]   = predata(jourfr(date('Y-m-d', $ddevblogs['timestamp'])));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>
          Blogs de développement
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/rss.png" alt="RSS">
          </a>
          <?php if(getadmin()) { ?>
          <a href="<?=$chemin?>pages/devblog/add">
            <img src="<?=$chemin?>img/icones/ajouter.png" alt="+" class="pointeur">
          </a>
          <?php } ?>
        </h1>

        <h5>Points techniques et vulgarisations informatiques</h5>

        <p>
          Cette section du site sert de plateforme à <a class="gras" href="<?=$chemin?>pages/user/user?id=1">Bad</a> pour partager des articles parlant de l'état du développement de NoBleme, du futur du site, ou d'autres sujets portants sur les métiers des sciences informatiques.
        </p>

        <br>
        <br>

        <table class="grid titresnoirs altc nowrap">
          <thead>
            <tr>
              <th>
                DATE DE PUBLICATION
              </th>
              <th>
                TITRE DU DEVBLOG
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <?php for($i=0;$i<$ndevblogs;$i++) { ?>
            <tr>
              <td>
                <?=$devblog_date[$i]?>
              </td>
              <td class=" gras">
                <a href="<?=$chemin?>pages/devblog/devblog?id=<?=$devblog_id[$i]?>"><?=$devblog_titre[$i]?></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';