<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Titre et description
$page_titre = "Ticket";
$page_desc  = "Ajouter ou modifier un ticket";

// Identification
$page_nom = "admin";
$page_id  = "admin";

// CSS et JS
$css = array('todo');
$js  = array('calendrier','dynamique','popup');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id

if(isset($_GET['id']) && is_numeric($_GET['id']))
  $todoid = postdata($_GET['id']);
else if(!isset($_GET['add']))
  erreur('ID ticket invalide');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un nouveau ticket

if(isset($_POST['todo_ajouter_x']))
{
  // Traitement du postdata
  $todo_date        = (postdata($_POST['todo_date']) == date('Y-m-d')) ? time() : postdata(strtotime($_POST['todo_date']));
  $todo_priorite    = postdata($_POST['todo_priorite']);
  $todo_titre       = postdata(destroy_html($_POST['todo_titre']));
  $todo_contenu     = postdata(destroy_html($_POST['todo_contenu']));
  $todo_categorie   = postdata($_POST['todo_categorie']);
  $todo_roadmap     = postdata($_POST['todo_roadmap']);
  $todo_visibilite  = postdata($_POST['todo_visibilite']);

  // Requête
  query(" INSERT INTO todo
          SET         FKmembres         = 1                   ,
                      timestamp         = '$todo_date'        ,
                      importance        = '$todo_priorite'    ,
                      titre             = '$todo_titre'       ,
                      contenu           = '$todo_contenu'     ,
                      FKtodo_categorie  = '$todo_categorie'   ,
                      FKtodo_roadmap    = '$todo_roadmap'     ,
                      valide_admin      = 1                   ,
                      public            = '$todo_visibilite'  ,
                      timestamp_fini    = 0                   ");

  // Activité récente
  $add_todo = mysqli_insert_id($db);
  if($todo_visibilite)
  {
    $add_timestamp = time();
    query(" INSERT INTO activite
            SET         timestamp     = '$add_timestamp'  ,
                        FKmembres     = 1                 ,
                        pseudonyme    = 'Bad'             ,
                        action_type   = 'new_todo'        ,
                        action_id     = '$add_todo'       ,
                        action_titre  = '$todo_titre'     ");
  }

  // Redirection
  header("Location: ".$chemin."pages/todo/index?id=".$add_todo);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'un ticket

if(isset($_POST['todo_modifier_x']))
{
  // Traitement du postdata
  $todo_priorite    = postdata($_POST['todo_priorite']);
  $todo_titre       = postdata(destroy_html($_POST['todo_titre']));
  $todo_contenu     = postdata(destroy_html($_POST['todo_contenu']));
  $todo_categorie   = postdata($_POST['todo_categorie']);
  $todo_roadmap     = postdata($_POST['todo_roadmap']);
  $todo_visibilite  = postdata($_POST['todo_visibilite']);

  // Déjà on veut récolter des infos sur le ticket pour plus tard
  $dtodo = mysqli_fetch_array(query(" SELECT  FKmembres     ,
                                              timestamp     ,
                                              valide_admin  ,
                                              public        ,
                                              timestamp_fini
                                      FROM    todo
                                      WHERE   todo.id = '$todoid' "));

  // Mise à jour du ticket
  query(" UPDATE  todo
          SET     importance        = '$todo_priorite'  ,
                  titre             = '$todo_titre'     ,
                  contenu           = '$todo_contenu'   ,
                  FKtodo_categorie  = '$todo_categorie' ,
                  FKtodo_roadmap    = '$todo_roadmap'   ,
                  public            = '$todo_visibilite'
          WHERE   id                = '$todoid'         ");

  // S'il passe de public à privé, on le vire de l'activité récente
  if($dtodo['public'] && !$todo_visibilite)
  {
    query(" DELETE FROM activite WHERE action_type = 'new_todo' AND action_id = '$todoid' ");
    query(" DELETE FROM activite WHERE action_type = 'fini_todo' AND action_id = '$todoid' ");
  }

  // S'il passe de privé à public, on le (re)met dans l'activité récente
  if(!$dtodo['public'] && $todo_visibilite)
  {
    $activite_timestamp = $dtodo['timestamp'];
    $activite_user      = $dtodo['FKmembres'];
    $activite_pseudo    = getpseudo($activite_user);
    query(" INSERT INTO activite
            SET         timestamp     = '$activite_timestamp' ,
                        FKmembres     = '$activite_user'      ,
                        pseudonyme    = '$activite_pseudo'    ,
                        action_type   = 'new_todo'            ,
                        action_id     = '$todoid'             ,
                        action_titre  = '$todo_titre'         ");
    if($dtodo['timestamp_fini'])
    {
      $activite_fini = $dtodo['timestamp_fini'];
      query(" INSERT INTO activite
              SET         timestamp     = '$activite_fini'      ,
                          action_type   = 'fini_todo'           ,
                          action_id     = '$todoid'             ,
                          action_titre  = '$todo_titre'         ");
    }
  }

  // S'il était pas encore validé, on le valide et on message l'ouvreur du ticket
  if(!$dtodo['valide_admin'])
  {
    query(" UPDATE todo SET valide_admin = 1 WHERE id = '$todoid' ");
    $add_titre    = (strlen(html_entity_decode($todo_titre)) > 25) ? substr(html_entity_decode($todo_titre),0,24).'...' : $todo_titre;
    $add_message  = "[b]Votre proposition de ticket a été acceptée.[/b]\r\n\r\n";
    if($todo_visibilite)
      $add_message .= "Votre ticket est visible ici : [b][url=".$chemin."pages/todo/index?id=".$todoid."]".$todo_titre."[/url][/b]\r\n";
    else
      $add_message .= "Votre ticket est un secret et n'apparait pas sur la liste des tâches. Aidez-moi à garder le secret, n'en parlez pas !\r\n";
    $add_message .= "Merci d'avoir aidé à contribuer à l'amélioration de NoBleme !\r\n";
    $add_message .= "N'hésitez pas à soumettre d'autres propositions de tickets dans le futur.";
    envoyer_notif($dtodo['FKmembres'] , 'Ticket accepté : '.$add_titre , postdata($add_message));
  }

  // Et on redirige
  header("Location: ".$chemin."pages/todo/index?id=".$todoid);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Valeurs par défaut des champs

// Si on ajoute un ticket et qu'on loade la page pour la première fois
if(isset($_GET['add']) && !isset($_POST['todo_previsualiser_x']))
{
  $todo_date        = date('Y-m-d');
  $todo_priorite    = 0;
  $todo_titre       = '';
  $todo_contenu     = '';
  $todo_categorie   = 0;
  $todo_roadmap     = 0;
  $todo_visibilite  = 0;
}
// Sinon on reprend les valeurs de la page
else if(isset($_POST['todo_previsualiser_x']))
{
  if(isset($_GET['add']))
    $todo_date            = $_POST['todo_date'];
  $todo_priorite          = $_POST['todo_priorite'];
  $todo_titre             = destroy_html($_POST['todo_titre']);
  $todo_contenu           = destroy_html($_POST['todo_contenu']);
  $todo_categorie         = $_POST['todo_categorie'];
  $todo_roadmap           = $_POST['todo_roadmap'];
  $todo_visibilite        = $_POST['todo_visibilite'];
  $todo_previsualisation  = bbcode(nl2br_fixed(destroy_html($_POST['todo_contenu'])));
}
// Sinon on est en train d'edit, on va chercher les valeurs
else
{
  // On chope les données
  $dtodo = mysqli_fetch_array(query(" SELECT  timestamp         ,
                                              importance        ,
                                              titre             ,
                                              contenu           ,
                                              FKtodo_categorie  ,
                                              FKtodo_roadmap    ,
                                              public
                                      FROM    todo
                                      WHERE   todo.id = '$todoid' "));
  // Et on les prépare à l'affichage
  $todo_priorite    = $dtodo['importance'];
  $todo_titre       = $dtodo['titre'];
  $todo_contenu     = $dtodo['contenu'];
  $todo_categorie   = $dtodo['FKtodo_categorie'];
  $todo_roadmap     = $dtodo['FKtodo_roadmap'];
  $todo_visibilite  = $dtodo['public'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants

// Priorité
$select_priorite = '';
for($i=0;$i<=5;$i++)
{
  if($todo_priorite == $i)
    $select_priorite .= '<option class="todo_importance_'.$i.'" value="'.$i.'" selected>'.todo_importance($i).'</option>';
  else
    $select_priorite .= '<option class="todo_importance_'.$i.'" value="'.$i.'">'.todo_importance($i).'</option>';
}


// Catégorie
$select_categorie = '';
if(!$todo_categorie)
  $select_categorie .= '<option value="0" selected>Aucune</option>';
else
  $select_categorie .= '<option value="0">Aucune</option>';
$qcategories = query(" SELECT id, categorie FROM todo_categorie ORDER BY categorie ASC ");
while($dcategories = mysqli_fetch_array($qcategories))
{
  if($todo_categorie == $dcategories['id'])
    $select_categorie .= '<option value="'.$dcategories['id'].'" selected>'.$dcategories['categorie'].'</option>';
  else
    $select_categorie .= '<option value="'.$dcategories['id'].'">'.$dcategories['categorie'].'</option>';
}


// Roadmaps
$select_roadmap = '';
if(!$todo_roadmap)
  $select_roadmap .= '<option value="0" selected>Aucun</option>';
else
  $select_roadmap .= '<option value="0">Aucun</option>';
$qroadmap = query(" SELECT id, version FROM todo_roadmap ORDER BY id_classement DESC ");
while($droadmap = mysqli_fetch_array($qroadmap))
{
  if($todo_roadmap == $droadmap['id'])
    $select_roadmap .= '<option value="'.$droadmap['id'].'" selected>'.$droadmap['version'].'</option>';
  else
    $select_roadmap .= '<option value="'.$droadmap['id'].'">'.$droadmap['version'].'</option>';
}


// Visibilité
$select_visibilite = '';
if($todo_visibilite)
  $select_visibilite .= '<option value="1" selected>Public</option>';
else
  $select_visibilite .= '<option value="1">Public</option>';
if(!$todo_visibilite)
  $select_visibilite .= '<option value="0" selected>Privé</option>';
else
  $select_visibilite .= '<option value="0">Privé</option>';





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/administration.png" alt="ADMINISTRATION">
    </div>
    <br>

    <?php if(isset($_POST['todo_previsualiser_x'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Ticket : <?=$todo_titre?></span><br>
      <br>
      <?=$todo_previsualisation?>
    </div>
    <?php } ?>

    <div class="body_main midsize">
      <script type="text/javascript">
        var cal1 = new CalendarPopup();
      </script>
      <form id="todo" method="POST" action="<?=$url_complete?>">
        <table class="indiv">
          <?php if(isset($_GET['add'])) { ?>
          <tr>
            <td class="data_input_right admin_gauche spaced">Date :</td>
            <td colspan="2"><input class="intable" name="todo_date" value="<?=$todo_date?>"></td>
            <td class="align_left admin_droite spaced"><a class="dark blank gras" id="anchor1" onClick="cal1.select(document.forms['todo'].todo_date,'anchor1','yyyy-MM-dd'); return false;">Calendrier</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td class="data_input_right admin_gauche spaced">Priorité :</td>
            <td colspan="3"><select class="intable todo_importance_<?=$todo_priorite?>" name="todo_priorite"><?=$select_priorite?></select></td>
          </tr>
          <tr>
            <td class="data_input_right admin_gauche spaced">Titre :</td>
            <td colspan="3"><input class="intable" name="todo_titre" value="<?=$todo_titre?>"></td>
          </tr>
          <tr>
            <td class="data_input_right admin_gauche spaced">Contenu :</td>
            <td colspan="3"><textarea class="intable" name="todo_contenu" rows="8"><?=$todo_contenu?></textarea></td>
          </tr>
          <tr>
            <td class="data_input_right admin_gauche spaced">Catégorie :</td>
            <td id="todo_categorie"><select class="intable" name="todo_categorie"><?=$select_categorie?></select></td>
            <td class="admin_reload align_center pointeur"><img src="<?=$chemin?>img/icones/details.png" alt="Re" height="17" onClick="dynamique('<?=$chemin?>','<?=$url_complete?>&amp;dynamique','todo_categorie','todo_categorie=1');"></td>
            <td class="align_left admin_droite spaced"><a class="dark blank gras" onClick="lienpopup('<?=$chemin?>pages/todo/categories?popup',800)">Catégories</a></td>
          </tr>
          <tr>
            <td class="data_input_right admin_gauche spaced">Roadmap :</td>
            <td id="todo_roadmap"><select class="intable" name="todo_roadmap"><?=$select_roadmap?></select></td>
            <td class="admin_reload align_center pointeur"><img src="<?=$chemin?>img/icones/details.png" alt="Re" height="17" onClick="dynamique('<?=$chemin?>','<?=$url_complete?>&amp;dynamique','todo_roadmap','todo_roadmap=1');"></td>
            <td class="align_left admin_droite spaced"><a class="dark blank gras" onClick="lienpopup('<?=$chemin?>pages/todo/roadmaps?popup',800)">Roadmaps</a></td>
          </tr>
          <tr>
            <td class="data_input_right admin_gauche spaced">Visibilité :</td>
            <td colspan="3"><select class="intable" name="todo_visibilite"><?=$select_visibilite?></select></td>
          </tr>
          <tr>
            <td colspan="4" class="align_center">
              <input type="image" src="<?=$chemin?>img/boutons/previsualiser.png" alt="PRÉVISUALISER" name="todo_previsualiser">
              <img src="<?=$chemin?>img/boutons/separateur.png" alt=" | ">
              <?php if(isset($_GET['add'])) { ?>
              <input type="image" src="<?=$chemin?>img/boutons/ajouter.png" alt="AJOUTER" name="todo_ajouter">
              <?php } else { ?>
              <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="MODIFIER" name="todo_modifier">
              <?php } ?>
            </td>
          </tr>
        </table>
      </form>
    </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Reload des select

  if(isset($_POST['todo_categorie']))
    echo '<select class="intable" name="todo_categorie">'.$select_categorie.'</select>';
  else if(isset($_POST['todo_roadmap']))
    echo '<select class="intable" name="todo_roadmap">'.$select_roadmap.'</select>';
}