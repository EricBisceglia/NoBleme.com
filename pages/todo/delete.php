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
$page_titre = "Supprimer une tâche";




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
// Suppression de la tâche

if(isset($_POST['todo_delete']) || isset($_POST['todo_reject']))
{
  if(isset($_POST['todo_reject']))
  {
    // On a besoin de choper des infos sur la tâche avant de la supprimer
    $qtodo = mysqli_fetch_array(query(" SELECT    todo.contenu        AS 't_contenu'  ,
                                                  membres.id          AS 'm_id'
                                        FROM      todo
                                        LEFT JOIN membres ON todo.FKmembres = membres.id
                                        WHERE     todo.id = '$todo_id' "));
  }

  // On supprime la tâche
  query(" DELETE FROM todo
          WHERE       todo.id = '$todo_id' ");

  // Ainsi que l'entrée dans l'activité récente
  query(" DELETE FROM activite
          WHERE     ( activite.action_type  = 'todo_new'
          OR          activite.action_type  = 'todo_fini' )
          AND         activite.action_id    = '$todo_id' ");

  if(isset($_POST['todo_reject']))
  {
    // On récupère le postdata
    $todo_delete_lang   = postdata_vide('todo_delete_lang', 'string', 'FR');
    $todo_delete_raison = $_POST['todo_delete_raison'];

    // On envoie un message de rejet à l'auteur
    $todo_auteur      = $qtodo['m_id'];
    $todo_contenu_raw = $qtodo['t_contenu'];

    // Selon si on veut l'envoyer en français...
    if($todo_delete_lang == 'FR')
    {
      $todo_titre_message = "Proposition refusée";
      $todo_raison        = ($todo_delete_raison) ? $todo_delete_raison : "Aucune raison spécifiée";
      $todo_message       = <<<EOD
[b]Votre proposition a été refusée.[/b]

[b]Raison du refus :[/b] {$todo_raison}

[b]Contenu de la proposition :[/b]
[quote]{$todo_contenu_raw}[/quote]

Même si votre proposition a été refusée, votre contribution à NoBleme est appréciée.
N'hésitez pas à continuer à contribuer dans le futur !
EOD;
    }
    else
    {
      $todo_titre_message = "Proposal rejected";
      $todo_raison        = ($todo_delete_raison) ? $todo_delete_raison : "No reason specified";
      $todo_message       = <<<EOD
[b]Your proposal has been rejected.[/b]

[b]Reason for refusal:[/b] {$todo_raison}

[b]Your proposal was:[/b]
[quote]{$todo_contenu_raw}[/quote]

Even though your proposal was rejected, your contribution to NoBleme is appreciated.
Don't hesitate to continue contributing in the future !
EOD;
    }

    // Et on envoie ce message
    envoyer_notif($todo_auteur, postdata($todo_titre_message), postdata($todo_message));
  }

  // Redirection vers la liste des tâches
  exit(header("Location: ".$chemin."pages/todo/index"));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On a besoin de quelques infos sur la tâche
$qtodo = mysqli_fetch_array(query(" SELECT    membres.pseudonyme  AS 'm_pseudo' ,
                                              todo.valide_admin   AS 't_valide' ,
                                              todo.titre          AS 't_titre'  ,
                                              todo.contenu        AS 't_contenu'
                                    FROM      todo
                                    LEFT JOIN membres ON todo.FKmembres = membres.id
                                    WHERE     todo.id = '$todo_id' "));

// Si la tâche existe pas, on sort
if($qtodo['t_titre'] === NULL)
  exit(header("Location: ".$chemin."pages/todo/index"));

// On prépare tout ça pour l'affichage
$todo_titre         = predata($qtodo['t_titre']);
$todo_contenu       = bbcode(predata($qtodo['t_contenu'], 1));
$todo_valide_admin  = $qtodo['t_valide'];
$todo_pseudonyme    = predata($qtodo['m_pseudo']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Supprimer une tâche</h1>

        <br>

        <?php if($todo_valide_admin) { ?>

        <h5>Confirmer la suppression de la tâche suivante :</h5>

        <h5 class="texte_negatif"><?=$todo_titre?></h5>
        <br>

        <?php } else { ?>

        <h5>Confirmer le rejet de la proposition de <?=$todo_pseudonyme?> :</h5>

        <br>
        <?=$todo_contenu?><br>
        <br>

        <?php } ?>

        <form method="POST">
          <fieldset>

            <?php if(!$todo_valide_admin) { ?>

            <label for="todo_delete_lang">Langue de la notification</label>
            <select id="todo_delete_lang" name="todo_delete_lang" class="indiv">
              <option value="FR">Français</option>
              <option value="EN">English</option>
            </select><br>
            <br>

            <label for="todo_delete_raison">Raison du refus</label>
            <input id="todo_delete_raison" name="todo_delete_raison" class="indiv" type="text"><br>
            <br>

            <?php } ?>

            <br>

            <?php if($todo_valide_admin) { ?>
            <input value="SUPPRIMER LA TÂCHE" type="submit" name="todo_delete">
            <?php } else { ?>
            <input value="REJETER LA PROPOSITION" type="submit" name="todo_reject">
            <?php } ?>

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';