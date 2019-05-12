<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Devblog';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Modifier un devblog";

// CSS & JS
$css  = array('devblog');
$js   = array('dynamique', 'devblog/previsualiser_devblog');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id

// Si l'id est pas set, on dégage
if(!isset($_GET['id']))
  exit(header("Location: ".$chemin."pages/devblog/index"));

// On vérifie que le devblog existe, sinon dehors
$devblog_id     = postdata($_GET['id'], 'int');
$qcheckdevblog  = mysqli_fetch_array(query("  SELECT  devblog.id
                                              FROM    devblog
                                              WHERE   devblog.id = '$devblog_id' "));
if($qcheckdevblog['id'] == NULL)
  exit(header("Location: ".$chemin."pages/devblog/index"));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification du devblog

if(isset($_POST['devblog_go']))
{
  // Assainissement du postdata
  $devblog_titre      = postdata_vide('devblog_titre', 'string', '');
  $devblog_contenu    = postdata_vide('devblog_contenu', 'string', '');

  // On met à jour le devblog
  query(" UPDATE  devblog
          SET     devblog.titre   = '$devblog_titre' ,
                  devblog.contenu = '$devblog_contenu'
          WHERE   devblog.id      = '$devblog_id' ");

  // Et on redirige vers le devblog
  exit(header("Location: ".$chemin."pages/devblog/devblog?id=".$devblog_id));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher le devblog
$qdevblog = mysqli_fetch_array(query("  SELECT  devblog.timestamp ,
                                                devblog.titre     ,
                                                devblog.contenu
                                        FROM    devblog
                                        WHERE   devblog.id = '$devblog_id' "));

// Et on prépare son contenu pour l'affichage, tout gérant la prévisualisation quand il y en a
$devblog_titre          = predata($qdevblog['titre']);
$devblog_contenu        = predata($qdevblog['contenu']);
$previsualiser_titre    = (isset($_POST['devblog_titre'])) ? predata(postdata_vide('devblog_titre', 'string', '')) : predata($qdevblog['titre']);
$previsualiser_date     = jourfr(date('Y-m-d', $qdevblog['timestamp']));
$previsualiser_ilya     = ilya($qdevblog['timestamp']);
$previsualiser_contenu  = (isset($_POST['devblog_contenu'])) ? $_POST['devblog_contenu'] : $qdevblog['contenu'];




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h1>Modifier le devblog</h1>

        <br>

        <form method="POST">
          <fieldset>
            <label for="devblog_titre">Titre</label>
            <input id="devblog_titre" name="devblog_titre" class="indiv" type="text" value="<?=$devblog_titre?>" onkeyup="previsualiser_devblog('<?=$chemin?>', <?=$devblog_id?>);"><br>
            <br>
            <label for="devblog_contenu">Contenu</label>
            <textarea id="devblog_contenu" name="devblog_contenu" class="indiv devblog_textarea" style="white-space: pre-wrap" onkeyup="previsualiser_devblog('<?=$chemin?>', <?=$devblog_id?>);"><?=$devblog_contenu?></textarea><br>
            <br>
            <input value="MODIFIER LE DEVBLOG" type="submit" name="devblog_go">
          </fieldset>
        </form>

        <br>
        <hr class="devblog_edit">
        <br>

        <div id="devblog_previsualiser">
          <?php } ?>

          <h4 class="alinea">
            <?=$previsualiser_titre?>
            <img src="<?=$chemin?>img/icones/modifier.svg" alt="M" class="pointeur">
            <img src="<?=$chemin?>img/icones/supprimer.svg" alt="S" class="pointeur">
          </h4>

          <h6 class="alinea texte_nobleme_clair">Blog de développement #<?=$devblog_id?> du <?=$previsualiser_date?> (<?=$previsualiser_ilya?>)</h6>

          <br>
          <?=$previsualiser_contenu?><br>
          <br>

          <div class="flexcontainer align_center gras">

            <div style="flex:3">
              <span class="texte_noir">Devblog précédent :</span><br>
              <a>Lien vers le devblog précédent</a>
            </div>

            <div style="flex:1">
              &nbsp;
            </div>

            <div style="flex:3">
              <span class="texte_noir">Devblog suivant :</span><br>
              <a>Lien vers le devblog suivant</a>
            </div>

          </div>

          <?php if(!getxhr()) { ?>
        </div>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }