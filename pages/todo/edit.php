<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/todo.inc.php';     // Fonctions liées à la liste des tâches

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Todolist';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Modifier une tâche";




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

if(isset($_POST['todo_edit_go']) || isset($_POST['todo_approve_go']))
{
  // Assainissement du postdata
  $todo_edit_lang         = postdata_vide('todo_edit_lang', 'string', 'FR');
  $todo_edit_titre        = postdata_vide('todo_edit_titre', 'string', '');
  $todo_edit_description  = postdata_vide('todo_edit_description', 'string', '');
  $todo_edit_categorie    = postdata_vide('todo_edit_categorie', 'int', 0);
  $todo_edit_objectif     = postdata_vide('todo_edit_objectif', 'int', 0);
  $todo_edit_importance   = postdata_vide('todo_edit_importance', 'int', 0);
  $todo_edit_public       = postdata_vide('todo_edit_public', 'int', 0);

  // Mise à jour de la tâche
  query(" UPDATE  todo
          SET     todo.titre            = '$todo_edit_titre'        ,
                  todo.contenu          = '$todo_edit_description'  ,
                  todo.FKtodo_categorie = '$todo_edit_categorie'    ,
                  todo.FKtodo_roadmap   = '$todo_edit_objectif'     ,
                  todo.importance       = '$todo_edit_importance'   ,
                  todo.public           = '$todo_edit_public'       ,
                  todo.valide_admin     = 1
          WHERE   todo.id               = '$todo_id'                ");

  // Si c'est une nouvelle tâche...
  if(isset($_POST['todo_approve_go']))
  {
    // On a besoin de savoir qui a soumis la tâche
    $qtodo = mysqli_fetch_array(query(" SELECT    membres.id          AS 'm_id'     ,
                                                  membres.pseudonyme  AS 'm_pseudo'
                                        FROM      todo
                                        LEFT JOIN membres ON todo.FKmembres = membres.id
                                        WHERE     todo.id = '$todo_id' "));
    $todo_edit_submitter  = postdata($qtodo['m_id']);
    $todo_edit_pseudo_raw = $qtodo['m_pseudo'];

    if($todo_edit_public)
    {
      // On crée une entrée dans l'activité récente
      $todo_edit_pseudo = postdata(getpseudo(), 'string');
      activite_nouveau('todo_new', 0, $todo_edit_submitter, $todo_edit_pseudo, $todo_id, $todo_edit_titre);

      // On notifie IRC
      $todo_edit_titre_raw  = $_POST['todo_edit_titre'];
      ircbot($chemin, $todo_edit_pseudo_raw." a ouvert une tâche : ".$todo_edit_titre_raw." - ".$GLOBALS['url_site']."pages/todo/index?id=".$todo_id, "#dev");
    }

    // On prépare un message privé en français
    if($todo_edit_lang == 'FR')
    {
      $todo_titre_message = "Proposition approuvée";
      if($todo_edit_public)
        $todo_message   = <<<EOD
[b]Votre proposition a été acceptée ![/b]

Vous pouvez retrouver la tâche #{$todo_id} en [url={$chemin}pages/todo/index?id={$todo_id}]cliquant ici[/url].

Votre contribution au développement de NoBleme est appréciée.
N'hésitez pas à soumettre d'autres propositions dans le futur !
EOD;
      else
      {
        $todo_titre_raw = $_POST['todo_edit_titre'];
        $todo_message   = <<<EOD
[b]Votre proposition a été acceptée ![/b]

Une tâche privée a été ouverte sous le nom [b]{$todo_titre_raw}[/b]. Le choix de garder cette tâche privée est volontaire, elle n'apparaitra pas dans la [url={$chemin}pages/todo/index]liste des tâches[/url], mais a bien été prise en compte.

Votre contribution au développement de NoBleme est appréciée.
N'hésitez pas à soumettre d'autres propositions dans le futur !
EOD;
      }
    }

    // Ou en anglais
    else
    {
      $todo_titre_message = "Proposal approved";
      $todo_message       = <<<EOD
[b]Your proposal has been approved![/b]

You have submitted a bug request or feature proposal which has been approved and added into NoBleme's todo list. Sadly, as the todo list is available only in french, it would be pointless to give you a link to the ticket that was opened for your proposal.

Your contribution to NoBleme's development is appreciated.
Don't hesitate to submit other bug reports or feature requests in the future.
EOD;
    }

    // Et on envoie le message privé
    envoyer_notif($todo_edit_submitter, postdata($todo_titre_message), postdata($todo_message));
  }

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
$qtodo = mysqli_fetch_array(query(" SELECT    todo.valide_admin     AS 't_valide'     ,
                                              todo.titre            AS 't_titre'      ,
                                              todo.contenu          AS 't_contenu'    ,
                                              todo.FKtodo_categorie AS 't_categorie'  ,
                                              todo.FKtodo_roadmap   AS 't_objectif'   ,
                                              todo.importance       AS 't_importance' ,
                                              todo.public           AS 't_public'
                                    FROM      todo
                                    WHERE     todo.id = '$todo_id' "));

// Si la tâche existe pas, on sort
if($qtodo['t_titre'] === NULL)
  exit(header("Location: ".$chemin."pages/todo/index"));

// On prépare tout ça pour l'affichage
$todo_titre         = predata($qtodo['t_titre']);
$todo_contenu_full  = bbcode(predata($qtodo['t_contenu'], 1));
$todo_contenu       = $qtodo['t_valide'] ? (predata($qtodo['t_contenu'])) : '';
$todo_valide_admin  = $qtodo['t_valide'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants

// Catégories
$qcategories = query("  SELECT    todo_categorie.id ,
                                  todo_categorie.categorie
                        FROM      todo_categorie
                        ORDER BY  todo_categorie.categorie ASC ");
$selected         = (!$qtodo['t_categorie']) ? ' selected' : '';
$select_categorie = '<option value="0"'.$selected.'>Aucune catégorie</option>';
while($dcategories = mysqli_fetch_array($qcategories))
{
  $selected           = ($dcategories['id'] == $qtodo['t_categorie']) ? ' selected' : '';
  $select_categorie  .= '<option value="'.$dcategories['id'].'"'.$selected.'>'.predata($dcategories['categorie']).'</option>';
}


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


// Importances
$select_importance = '';
for($i=0;$i<=5;$i++)
{
  $selected           = ($i == $qtodo['t_importance']) ? ' selected' : '';
  $select_importance .= '<option value="'.$i.'"'.$selected.'>'.todo_importance($i).'</option>';
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

        <?php if($todo_valide_admin) { ?>

        <h1>Modifier une tâche</h1>

        <?php } else { ?>

        <h2>Approuver une proposition de tâche</h2>

        <br>
        <?=$todo_contenu_full?><br>

        <?php } ?>

        <br>

        <form method="POST">
          <fieldset>

            <?php if(!$todo_valide_admin) { ?>
            <label for="todo_edit_lang">Langue de la notification</label>
            <select id="todo_edit_lang" name="todo_edit_lang" class="indiv">
              <option value="FR">Français</option>
              <option value="EN">English</option>
            </select><br>
            <br>
            <?php } ?>

            <label for="todo_edit_titre">Titre</label>
            <input id="todo_edit_titre" name="todo_edit_titre" class="indiv" type="text" value="<?=$todo_titre?>"><br>
            <br>

            <label for="todo_edit_description">Description</label>
            <textarea id="todo_edit_description" name="todo_edit_description" class="indiv" style="height:100px"><?=$todo_contenu?></textarea><br>
            <br>

            <label for="todo_edit_categorie">Catégorie</label>
            <div class="flexcontainer">
              <div style="flex:15">
                <select id="todo_edit_categorie" name="todo_edit_categorie" class="indiv">
                  <?=$select_categorie?>
                </select><br>
              </div>
              <div style="flex:1" class="align_right">
                <a href="<?=$chemin?>pages/todo/edit_categories">
                  <img src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="30">
                </a>
              </div>
            </div>
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

            <label for="todo_edit_importance">Importance</label>
            <select id="todo_edit_importance" name="todo_edit_importance" class="indiv">
              <?=$select_importance?>
            </select><br>
            <br>

            <label for="todo_edit_public">Visibilité</label>
            <select id="todo_edit_public" name="todo_edit_public" class="indiv">
              <?=$select_visibilite?>
            </select><br>
            <br>
            <br>

            <?php if($todo_valide_admin) { ?>
            <input value="MODIFIER LA TÂCHE" type="submit" name="todo_edit_go"><br>
            <?php } else { ?>
            <input value="APPROUVER LA TÂCHE" type="submit" name="todo_approve_go"><br>
            <?php } ?>

          </fieldset>
        </form>

      </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';