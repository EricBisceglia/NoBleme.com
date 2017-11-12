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
$page_titre = "Écrire un devblog";

// CSS & JS
$css  = array('devblog');
$js   = array('dynamique', 'devblog/previsualiser_devblog');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualisation du contenu

$previsualiser_titre    = (isset($_POST['devblog_titre']) && $_POST['devblog_titre']) ? predata(postdata_vide('devblog_titre', 'string', '')) : 'Titre du devblog';
$previsualiser_date     = jourfr(date('Y-m-d'));
$previsualiser_contenu  = (isset($_POST['devblog_contenu']) && $_POST['devblog_contenu']) ? $_POST['devblog_contenu'] : 'Contenu du devblog<br><br>Bla bla etc.';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un nouveau devblog

if(isset($_POST['devblog_go']))
{
  // Assainissement du postdata
  $devblog_timestamp  = time();
  $devblog_titre      = postdata_vide('devblog_titre', 'string', '');
  $devblog_contenu    = postdata_vide('devblog_contenu', 'string', '');

  // On crée le devblog
  query(" INSERT INTO devblog
          SET         timestamp = '$devblog_timestamp'  ,
                      titre     = '$devblog_titre'      ,
                      contenu   = '$devblog_contenu'    ");

  // Activité récente
  $devblog_id = mysqli_insert_id($db);
  query(" INSERT INTO activite
          SET         timestamp     = '$devblog_timestamp'  ,
                      action_type   = 'devblog'             ,
                      action_id     = '$devblog_id'         ,
                      action_titre  = '$devblog_titre'      ");

  // Bot IRC
  $devblog_titre_raw = $_POST['devblog_titre'];
  ircbot($chemin, "Nouveau blog de développement publié : ".$devblog_titre_raw.": ".$GLOBALS['url_site']."pages/devblog/devblog?id=".$devblog_id, "#dev");

  // Et on redirige vers le devblog nouvellement crée
  exit(header("Location: ".$chemin."pages/devblog/devblog?id=".$devblog_id));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h1>Composer un devblog</h1>

        <br>

        <form method="POST">
          <fieldset>
            <label for="devblog_titre">Titre</label>
            <input id="devblog_titre" name="devblog_titre" class="indiv" type="text" onkeyup="previsualiser_devblog('<?=$chemin?>');"><br>
            <br>
            <label for="devblog_contenu">Contenu</label>
            <textarea id="devblog_contenu" name="devblog_contenu" class="indiv devblog_textarea" onkeyup="previsualiser_devblog('<?=$chemin?>');"></textarea><br>
            <br>
            <input value="POSTER LE DEVBLOG" type="submit" name="devblog_go">
          </fieldset>
        </form>

        <br>
        <hr class="devblog_edit">
        <br>

        <div id="devblog_previsualiser">
          <?php } ?>

          <h4 class="alinea">
            <?=$previsualiser_titre?>
            <img src="<?=$chemin?>img/icones/modifier.png" alt="M" height="24" class="pointeur">
            <img src="<?=$chemin?>img/icones/supprimer.png" alt="S" height="24" class="pointeur">
          </h4>

          <h6 class="alinea texte_nobleme_clair">Blog de développement #000 du <?=$previsualiser_date?> (Il y a 000 jours)</h6>

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