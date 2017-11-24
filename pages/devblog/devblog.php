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
$page_nom = "Lit le devblog : ";
$page_url = "pages/devblog/devblog?id=";

// Lien court
$shorturl = "d=";

// Langages disponibles
$langage_page = array('FR');

// Titre et description
$page_titre = "Devblog : ";
$page_desc  = "Blog de développement : ";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a pas donné d'id, dehors
if(!isset($_GET['id']))
  exit(header("Location: ".$chemin."pages/devblog/index"));

// On récupère l'id du devblog
$devblog_id = postdata($_GET['id'], 'int');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher le contenu de devblog
$qdevblog = mysqli_fetch_array(query("  SELECT  devblog.timestamp ,
                                                devblog.titre     ,
                                                devblog.contenu
                                        FROM    devblog
                                        WHERE   devblog.id = '$devblog_id' "));

// Si le devblog existe pas, dehors
if($qdevblog['titre'] === NULL)
  exit(header("Location: ".$chemin."pages/devblog/index"));

// Sinon, on prépare le contenu pour l'affichage
$devblog_date     = predata(jourfr(date('Y-m-d', $qdevblog['timestamp'])));
$devblog_ilya     = predata(ilya($qdevblog['timestamp']));
$devblog_titre    = predata($qdevblog['titre']);
$devblog_contenu  = $qdevblog['contenu'];

// On a aussi besoin de compléter les infos de la page
$page_nom   .= tronquer_chaine($devblog_titre, 40, '...');
$page_url   .= $devblog_id;
$shorturl   .= $devblog_id;
$page_titre .= $devblog_titre;
$page_desc  .= $devblog_titre;

// Il va nous falloir les devblogs précédents et suivant
$qprevdevblog = mysqli_fetch_array(query("  SELECT    devblog.id  ,
                                                      devblog.titre
                                            FROM      devblog
                                            WHERE     devblog.id < '$devblog_id'
                                            ORDER BY  devblog.id DESC
                                            LIMIT     1 "));
$qnextdevblog = mysqli_fetch_array(query("  SELECT    devblog.id  ,
                                                      devblog.titre
                                            FROM      devblog
                                            WHERE     devblog.id > '$devblog_id'
                                            ORDER BY  devblog.id ASC
                                            LIMIT     1 "));

// Dont on prépare également le contenu pour l'affichage
$devblog_prev_id    = $qprevdevblog['id'];
$devblog_prev_titre = predata($qprevdevblog['titre']);
$devblog_next_id    = $qnextdevblog['id'];
$devblog_next_titre = predata($qnextdevblog['titre']);





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h4 class="alinea">
          <?=$devblog_titre?>
          <?php if(getadmin()) { ?>
          <a href="<?=$chemin?>pages/devblog/edit?id=<?=$devblog_id?>">
            <img src="<?=$chemin?>img/icones/modifier.png" alt="M" height="24" class="pointeur">
          </a>
          <a href="<?=$chemin?>pages/devblog/delete?id=<?=$devblog_id?>">
            <img src="<?=$chemin?>img/icones/supprimer.png" alt="S" height="24" class="pointeur">
          </a>
          <?php } ?>
        </h4>

        <h6 class="alinea texte_nobleme_clair">Blog de développement #<?=$devblog_id?> du <?=$devblog_date?> (<?=$devblog_ilya?>)</h6>

        <br>
        <?=$devblog_contenu?><br>
        <br>

        <div class="flexcontainer align_center gras">

          <?php if($devblog_prev_id) { ?>
          <div style="flex:3">
            <span class="texte_noir">Devblog précédent :</span><br>
            <a href="<?=$chemin?>pages/devblog/devblog?id=<?=$devblog_prev_id?>"><?=$devblog_prev_titre?></a>
          </div>

          <?php } if($devblog_prev_id && $devblog_next_id) { ?>
          <div style="flex:1">
            &nbsp;
          </div>

          <?php } if($devblog_next_id) { ?>
          <div style="flex:3">
            <span class="texte_noir">Devblog suivant :</span><br>
            <a href="<?=$chemin?>pages/devblog/devblog?id=<?=$devblog_next_id?>"><?=$devblog_next_titre?></a>
          </div>
          <?php } ?>

        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';