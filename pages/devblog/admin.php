<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Titre et description
$page_titre = "Devblog - Admin";

// Identification
$page_nom = "admin";
$page_id  = "admin";

// CSS & JS
$css = array("devblog");
$js  = array('calendrier');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Définition du blogid

if(isset($_GET['edit']))
  $blogid = $_GET['edit'];
else if(isset($_GET['delete']))
  $blogid = $_GET['delete'];
else if(!isset($_GET['add']))
  erreur('ID invalide');



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualisation

if(isset($_POST['devblog_preview_x']))
  $devblog_preview = bbcode(nl2br_fixed($_POST['add_contenu']));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un nouveau devblog

if(isset($_GET['add']))
{
  if(isset($_POST['devblog_add_x']))
  {
    // Traitement du postdata
    $add_date     = strtotime(postdata($_POST['add_date']));
    $add_titre    = postdata($_POST['add_titre']);
    $add_resume   = postdata(nl2br_fixed($_POST['add_resume']));
    $add_contenu  = postdata(nl2br_fixed($_POST['add_contenu']));

    // Ajout des données
    query(" INSERT INTO devblog SET timestamp = '$add_date'     ,
                                    titre     = '$add_titre'    ,
                                    resume    = '$add_resume'   ,
                                    contenu   = '$add_contenu'  ");

    // Activité récente
    $blog_id    = mysqli_insert_id($db);
    $blog_time  = time();
    query(" INSERT INTO activite
            SET         timestamp     = '$blog_time'  ,
                        action_type   = 'new_devblog' ,
                        action_id     = '$blog_id'    ,
                        action_titre  = '$add_titre'  ");

    // Bot IRC NoBleme
    ircbot($chemin,"Nouveau devblog publié : http://nobleme.com/pages/devblog/blog?id=".$blog_id." - ".$_POST['add_titre'],"#dev");

    // Redirection vers le nouveau devblog
    header('Location: '.$chemin.'pages/devblog/blog');
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'un devblog

if(isset($_POST['devblog_edit_x']))
{
  // On récupère le postdata
  $edit_date    = strtotime(postdata($_POST['add_date']));
  $edit_titre   = postdata($_POST['add_titre']);
  $edit_resume  = postdata(nl2br_fixed($_POST['add_resume']));
  $edit_contenu = postdata(nl2br_fixed($_POST['add_contenu']));

  // On édite
  query(" UPDATE  devblog SET   timestamp = '$edit_date'    ,
                                titre     = '$edit_titre'   ,
                                resume    = '$edit_resume'  ,
                                contenu   = '$edit_contenu'
                          WHERE id        = '$blogid'       ");

  // Et on revient au devblog
  header('Location: '.$chemin.'pages/devblog/blog?id='.$blogid);
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un devblog

if(isset($_POST['devblog_delete_x']))
{
  // RIP devblog et ses commentaires
  query(" DELETE FROM devblog WHERE id = '$blogid' ");
  query(" DELETE FROM devblog_commentaire WHERE FKdevblog = '$blogid' ");

  // Activité récente
  query(" DELETE FROM activite WHERE action_type = 'new_devblog' AND action_id = '$blogid' ");
  query(" DELETE FROM activite WHERE action_type = 'new_devblog_comm' AND parent_id = '$blogid' ");

  // Et on redirige vers la liste des devblogs
  header('Location: '.$chemin.'pages/devblog/index');
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Conserver les valeurs dans les champs

if(!isset($_GET['delete']) && !isset($_POST['devblog_edit_x']) && !isset($_POST['devblog_add_x']))
{
  $add_date     = isset($_POST['add_date']) ? $_POST['add_date'] : date('Y-m-d');
  $add_titre    = isset($_POST['add_titre']) ? destroy_html($_POST['add_titre']) : '';
  $add_resume   = isset($_POST['add_resume']) ? destroy_html($_POST['add_resume']) : '';
  $add_contenu  = isset($_POST['add_contenu']) ? destroy_html($_POST['add_contenu']) : '';
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des valeurs pour un devblog à éditer ou supprimer

if((isset($_GET['edit']) && !isset($_POST['devblog_preview_x'])) || isset($_GET['delete']))
{
  // On va chercher le blog à éditer
  $dblogid = mysqli_fetch_array(query(" SELECT  timestamp ,
                                                titre     ,
                                                resume    ,
                                                contenu
                                        FROM    devblog
                                        WHERE   id = '$blogid' "));

  // Et on prépare les valeurs
  $add_date     = date('Y-m-d',$dblogid['timestamp']);
  $add_titre    = $dblogid['titre'];
  $add_resume   = br2ln($dblogid['resume']);
  $add_contenu  = br2ln($dblogid['contenu']);
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

    <?php if(isset($_POST['devblog_preview_x'])) { ?>
    <div class="body_main midsize">
      <?=$devblog_preview?>
    </div>
    <br>
    <?php } ?>

    <?php if(!isset($_GET['delete'])) { ?>
    <div class="body_main midsize">
    <span class="titre">
      <?php if(isset($_GET['add'])) { ?>
      Nouveau blog de développement
      <?php } else { ?>
      Modifier le blog de développement
      <?php } ?>
    </span><br>
    <br>
    <?php if(isset($_GET['add'])) { ?>
    <form name="devblog" method="post" action="admin?add">
    <?php } else { ?>
    <form name="devblog" method="post" action="admin?edit=<?=$blogid?>">
    <?php } ?>
      <script type="text/javascript">
        var cal1 = new CalendarPopup();
      </script>
      <table class="indiv">
        <tr>
          <td class="gras align_right spaced add_titres">Date :</td>
          <td><input class="indiv" name="add_date" value="<?=$add_date?>"></td>
          <td class="add_calendrier align_right"><a class="dark blank gras" id="anchor1" onClick="cal1.select(document.forms['devblog'].add_date,'anchor1','yyyy-MM-dd'); return false;">Calendrier</a></td>
        </tr>
        <tr>
          <td class="gras align_right spaced add_titres">Titre :</td>
          <td colspan="2"><input class="indiv" name="add_titre" value="<?=$add_titre?>"></td>
        </tr>
        <tr>
          <td class="gras align_right spaced add_titres">Résumé :</td>
          <td colspan="2"><textarea class="indiv" rows="2" name="add_resume"><?=$add_resume?></textarea></td>
        </tr>
        <tr>
          <td class="gras align_right spaced add_titres">Contenu :</td>
          <td colspan="2"><textarea class="indiv" rows="20" name="add_contenu"><?=$add_contenu?></textarea></td>
        </tr>
        <tr>
          <td class="align_center" colspan="3">
            <input type="image" src="<?=$chemin?>img/boutons/previsualiser.png" alt="PRÉVISUALISER" name="devblog_preview">
            <img src="<?=$chemin?>img/boutons/separateur.png" alt=" | ">
            <?php if(isset($_GET['add'])) { ?>
            <input type="image" src="<?=$chemin?>img/boutons/ajouter.png" alt="AJOUTER" name="devblog_add">
            <?php } else { ?>
            <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="MODIFIER" name="devblog_edit">
            <?php } ?>
          </td>
        </tr>
      </table>
    </form>
  </div>

  <?php } else { ?>
  <div class="body_main midsize">
    <span class="titre">Confirmer la suppression du blog de développement suivant :</span>
    <br>
    <br>
    <form name="devblog" method="post" action="admin?delete=<?=$blogid?>">
      <table class="indiv">
        <tr>
          <td class="align_right gras spaced add_titres">Titre :</td>
          <td class="align_left"><?=$add_titre?></td>
        </tr>
        <tr>
          <td class="align_right gras spaced add_titres">Résumé :</td>
          <td class="align_left"><?=$add_resume?></td>
        </tr>
        <tr>
          <td class="align_center" colspan="2">
            <br><input type="image" src="<?=$chemin?>img/boutons/supprimer.png" alt="SUPPRIMER" name="devblog_delete">
          </td>
        </tr>
      </table>
    </form>
  </div>
  <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';