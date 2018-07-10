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
$header_sidemenu  = 'Todolist';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Valider une tâche";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id

// Si y'a pas d'id, on sort
if(!isset($_GET['id']))
  exit(header("Location: ".$chemin."pages/todo/index"));

// Sinon, on récupère l'id
$todo_id = postdata($_GET['id'], 'int');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification de la tâche

if(isset($_POST['todo_solved_go']))
{
  // Assainissement du postdata
  $todo_edit_resolu       = postdata_vide('todo_edit_resolu', 'int', 0);
  $todo_edit_source       = postdata_vide('todo_edit_source', 'string', '');
  $todo_edit_titre        = postdata_vide('todo_edit_titre', 'string', '');
  $todo_edit_description  = postdata_vide('todo_edit_description', 'string', '');
  $todo_edit_objectif     = postdata_vide('todo_edit_objectif', 'int', 0);
  $todo_edit_public       = postdata_vide('todo_edit_public', 'int', 0);
  $todo_timestamp_fini    = ($todo_edit_resolu) ? time() : 0;

  // Mise à jour de la tâche
  query(" UPDATE  todo
          SET     todo.titre            = '$todo_edit_titre'        ,
                  todo.contenu          = '$todo_edit_description'  ,
                  todo.FKtodo_roadmap   = '$todo_edit_objectif'     ,
                  todo.public           = '$todo_edit_public'       ,
                  todo.timestamp_fini   = '$todo_timestamp_fini'    ,
                  todo.source           = '$todo_edit_source'
          WHERE   todo.id               = '$todo_id'                ");

  if($todo_edit_resolu)
  {
    // Si elle est résolue, on va chercher dans l'activité récente si cette tâche est déjà marqué comme résolue
    $qcheckactivite = mysqli_fetch_array(query("  SELECT  activite.id
                                                  FROM    activite
                                                  WHERE   activite.action_type  = 'todo_fini'
                                                  AND     activite.action_id    = '$todo_id' "));

    if($qcheckactivite['id'] === NULL)
    {
      // Si non, on l'insère dans l'activité récente
      activite_nouveau('todo_fini', 0, 0, NULL, $todo_id, $todo_edit_titre);

      // Et on notifie via le bot IRC
      $todo_edit_titre_raw = $_POST['todo_edit_titre'];
      ircbot($chemin, "Tâche résolue : ".$todo_edit_titre_raw." - ".$GLOBALS['url_site']."pages/todo/index?id=".$todo_id, "#dev");
      if($todo_edit_source)
      {
        $todo_edit_source_raw = $_POST['todo_edit_source'];
        ircbot($chemin, "Nouveau commit sur le dépôt public de NoBleme : ".$todo_edit_source_raw, "#dev");
      }
    }
  }
  // Sinon, on supprime l'entrée dans l'activité récente
  else
    activite_supprimer('todo_fini', 0, 0, NULL, $todo_id);

  // Et on redirige vers la liste des tâches
  exit(header("Location: ".$chemin."pages/todo/index"));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Données du formulaire

// On a besoin de quelques infos sur la tâche
$qtodo = mysqli_fetch_array(query(" SELECT    todo.titre            AS 't_titre'    ,
                                              todo.contenu          AS 't_contenu'  ,
                                              todo.public           AS 't_public'   ,
                                              todo.FKtodo_roadmap   AS 't_objectif' ,
                                              todo.timestamp_fini   AS 't_fini'     ,
                                              todo.source           AS 't_source'
                                    FROM      todo
                                    WHERE     todo.id = '$todo_id' "));

// Si la tâche existe pas, on sort
if($qtodo['t_titre'] === NULL)
  exit(header("Location: ".$chemin."pages/todo/index"));

// On prépare tout ça pour l'affichage
$todo_titre   = predata($qtodo['t_titre']);
$todo_contenu = predata($qtodo['t_contenu']);
$todo_source  = predata($qtodo['t_source']);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants

// Objectifs
$qobjectifs = query(" SELECT    todo_roadmap.id ,
                                todo_roadmap.version
                      FROM      todo_roadmap
                      ORDER BY  todo_roadmap.id_classement DESC ");
$selected         = (!$qtodo['t_objectif']) ? ' selected' : '';
$select_objectif  = '<option value="0"'.$selected.'>Aucun objectif</option>';
while($dobjectifs = mysqli_fetch_array($qobjectifs))
{
  $selected         = ($dobjectifs['id'] == $qtodo['t_objectif']) ? ' selected' : '';
  $select_objectif .= '<option value="'.$dobjectifs['id'].'"'.$selected.'>'.predata($dobjectifs['version']).'</option>';
}


// Visibilité
$selected           = ($qtodo['t_public']) ? ' selected' : '';
$select_visibilite  = '<option value="1"'.$selected.'>Public</option>';
$selected           = ($qtodo['t_public']) ? '' : ' selected';
$select_visibilite .= '<option value="0"'.$selected.'>Privé</option>';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Résoudre une tâche</h1>

        <h5>
          Tâche #<?=$todo_id?> : <?=$todo_titre?>
        </h5>

        <h5>
          <a class="gras" href="<?=$chemin?>pages/todo/index?id=<?=$todo_id?>"><?=$GLOBALS['url_site']?>pages/todo/index?id=<?=$todo_id?></a>
        </h5>

        <br>

        <form method="POST">
          <fieldset>

            <label for="todo_edit_resolu">Résolution</label>
            <select id="todo_edit_resolu" name="todo_edit_resolu" class="indiv">
              <option value="0">Tâche à faire</option>
              <option value="1" selected>Tâche résolue</option>
            </select><br>
            <br>

            <label for="todo_edit_source">Code source du patch | <a href="https://bitbucket.org/EricBisceglia/nobleme.com/commits/all">Bitbucket</a></label>
            <input id="todo_edit_source" name="todo_edit_source" class="indiv" type="text" value="<?=$todo_source?>"><br>
            <br>

            <label for="todo_edit_objectif">Objectif</label>
            <div class="flexcontainer">
              <div style="flex:15">
                <select id="todo_edit_objectif" name="todo_edit_objectif" class="indiv">
                  <?=$select_objectif?>
                </select><br>
              </div>
              <div style="flex:1" class="align_right">
                <a href="<?=$chemin?>pages/todo/edit_roadmaps">
                  <img src="<?=$chemin?>img/icones/modifier.png" alt="M">
                </a>
              </div>
            </div>
            <br>

            <label for="todo_edit_public">Visibilité</label>
            <select id="todo_edit_public" name="todo_edit_public" class="indiv">
              <?=$select_visibilite?>
            </select><br>
            <br>

            <label for="todo_edit_titre">Titre de la tâche</label>
            <input id="todo_edit_titre" name="todo_edit_titre" class="indiv" type="text" value="<?=$todo_titre?>"><br>
            <br>

            <label for="todo_edit_description">Description</label>
            <textarea id="todo_edit_description" name="todo_edit_description" class="indiv" style="height:100px"><?=$todo_contenu?></textarea><br>
            <br>

            <input value="CHANGER L'ÉTAT DE LA TÂCHE" type="submit" name="todo_solved_go"><br>

          </fieldset>
        </form>

      </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';