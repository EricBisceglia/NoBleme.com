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
  $todo_edit_resolu     = postdata_vide('todo_edit_resolu', 'int', 0);
  $todo_edit_source     = postdata_vide('todo_edit_source', 'string', '');
  $todo_edit_titre_fr   = postdata_vide('todo_edit_titre_fr', 'string', '');
  $todo_edit_titre_en   = postdata_vide('todo_edit_titre_en', 'string', '');
  $todo_edit_contenu_fr = postdata_vide('todo_edit_contenu_fr', 'string', '');
  $todo_edit_contenu_en = postdata_vide('todo_edit_contenu_en', 'string', '');
  $todo_edit_objectif   = postdata_vide('todo_edit_objectif', 'int', 0);
  $todo_edit_public     = postdata_vide('todo_edit_public', 'int', 0);
  $todo_timestamp_fini  = ($todo_edit_resolu) ? time() : 0;

  // Mise à jour de la tâche
  query(" UPDATE  todo
          SET     todo.titre_fr         = '$todo_edit_titre_fr'   ,
                  todo.titre_en         = '$todo_edit_titre_en'   ,
                  todo.contenu_fr       = '$todo_edit_contenu_fr' ,
                  todo.contenu_en       = '$todo_edit_contenu_en' ,
                  todo.FKtodo_roadmap   = '$todo_edit_objectif'   ,
                  todo.public           = '$todo_edit_public'     ,
                  todo.timestamp_fini   = '$todo_timestamp_fini'  ,
                  todo.source           = '$todo_edit_source'
          WHERE   todo.id               = '$todo_id'              ");

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
      activite_nouveau('todo_fini', 0, 0, NULL, $todo_id, $todo_edit_titre_fr, $todo_edit_titre_en);

      // Et on notifie via le bot IRC
      $todo_edit_titre_raw_fr = $_POST['todo_edit_titre_fr'];
      $todo_edit_titre_raw_en = $_POST['todo_edit_titre_en'];
      if($todo_edit_titre_raw_fr)
        ircbot($chemin, "Tâche résolue : ".$todo_edit_titre_raw_fr." - ".$GLOBALS['url_site']."pages/todo/index?id=".$todo_id, "#dev");
      if($todo_edit_titre_raw_en)
        ircbot($chemin, "Task solved: ".$todo_edit_titre_raw_en." - ".$GLOBALS['url_site']."pages/todo/index?id=".$todo_id, "#english");
      if($todo_edit_source)
      {
        $todo_edit_source_raw = $_POST['todo_edit_source'];
        ircbot($chemin, "Le code source de NoBleme a été modifié : ".$todo_edit_source_raw, "#dev");
        ircbot($chemin, "Changes have been made to NoBleme's source code: ".$todo_edit_source_raw, "#english");
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
$qtodo = mysqli_fetch_array(query(" SELECT    todo.titre_fr         AS 't_titre_fr'   ,
                                              todo.titre_en         AS 't_titre_en'   ,
                                              todo.contenu_fr       AS 't_contenu_fr' ,
                                              todo.contenu_en       AS 't_contenu_en' ,
                                              todo.public           AS 't_public'     ,
                                              todo.FKtodo_roadmap   AS 't_objectif'   ,
                                              todo.timestamp_fini   AS 't_fini'       ,
                                              todo.source           AS 't_source'
                                    FROM      todo
                                    WHERE     todo.id = '$todo_id' "));

// Si la tâche existe pas, on sort
if($qtodo['t_titre_fr'] === NULL && $qtodo['t_titre_en'] === NULL)
  exit(header("Location: ".$chemin."pages/todo/index"));

// On prépare tout ça pour l'affichage
$todo_titre_fr      = predata($qtodo['t_titre_fr']);
$todo_titre_en      = predata($qtodo['t_titre_en']);
$todo_contenu_fr    = predata($qtodo['t_contenu_fr']);
$todo_contenu_en    = predata($qtodo['t_contenu_en']);
$todo_source        = predata($qtodo['t_source']);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants

// Objectifs
$qobjectifs = query(" SELECT    todo_roadmap.id             AS 'r_id'     ,
                                todo_roadmap.version_$lang  AS 'r_version'
                      FROM      todo_roadmap
                      ORDER BY  todo_roadmap.id_classement DESC ");
$selected         = (!$qtodo['t_objectif']) ? ' selected' : '';
$select_objectif  = '<option value="0"'.$selected.'>Aucun objectif</option>';
while($dobjectifs = mysqli_fetch_array($qobjectifs))
{
  $selected         = ($dobjectifs['r_id'] == $qtodo['t_objectif']) ? ' selected' : '';
  $select_objectif .= '<option value="'.$dobjectifs['r_id'].'"'.$selected.'>'.predata($dobjectifs['r_version']).'</option>';
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

      <div class="texte3">

        <h1 class="align_center">
          Résoudre une tâche
        </h1>

        <?php if($todo_titre_en) { ?>
        <h5 class="align_center">Task #<?=$todo_id?>: <?=$todo_titre_en?></h5>
        <?php } if($todo_titre_fr) { ?>
        <h5 class="align_center">Tâche #<?=$todo_id?> : <?=$todo_titre_fr?></h5>
        <?php } ?>

        <h5 class="align_center">
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

            <label for="todo_edit_source">Code source du patch (<a href="https://github.com/EricBisceglia/NoBleme.com/pulls?utf8=%E2%9C%93&q=is%3Apr">GitHub</a>)</label>
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
                  <img src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="30">
                </a>
              </div>
            </div>
            <br>

            <label for="todo_edit_public">Visibilité</label>
            <select id="todo_edit_public" name="todo_edit_public" class="indiv">
              <?=$select_visibilite?>
            </select><br>
            <br>

            <div class="flexcontainer">
              <div style="flex:7">

                <label for="todo_edit_titre_fr">Titre en français</label>
                <input id="todo_edit_titre_fr" name="todo_edit_titre_fr" class="indiv" type="text" value="<?=$todo_titre_fr?>"><br>
                <br>

                <label for="todo_edit_contenu_fr">Description en français (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a>)</label>
                <textarea id="todo_edit_contenu_fr" name="todo_edit_contenu_fr" class="indiv" style="height:100px"><?=$todo_contenu_fr?></textarea><br>
                <br>

              </div>
              <div style="flex:1">
                &nbsp;
              </div>
              <div style="flex:7">

                <label for="todo_edit_titre_en">Titre en anglais</label>
                <input id="todo_edit_titre_en" name="todo_edit_titre_en" class="indiv" type="text" value="<?=$todo_titre_en?>"><br>
                <br>

                <label for="todo_edit_contenu_en">Description en anglais (<a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a>)</label>
                <textarea id="todo_edit_contenu_en" name="todo_edit_contenu_en" class="indiv" style="height:100px"><?=$todo_contenu_en?></textarea><br>
                <br>

              </div>
            </div>

            <input value="CHANGER L'ÉTAT DE LA TÂCHE" type="submit" name="todo_solved_go"><br>

          </fieldset>
        </form>

      </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';