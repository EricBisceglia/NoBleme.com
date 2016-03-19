<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Titre et description
$page_titre = "Supprimer un ticket";

// Identification
$page_nom = "admin";
$page_id  = "admin";

// CSS
$css = array('todo');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On récupère l'ID du ticket à supprimer

if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  erreur('ID ticket invalide');
else
  $todoid = postdata($_GET['id']);



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un ticket

if(isset($_POST['todo_supprimer_x']))
{
  // On a besoin d'infos sur le ticket pour la suite
  $dtodo = mysqli_fetch_array(query(" SELECT FKmembres, titre, valide_admin FROM todo WHERE todo.id = '$todoid' "));

  // On delete le ticket et ses commentaires
  query(" DELETE FROM todo WHERE todo.id = '$todoid' ");
  query(" DELETE FROM todo_commentaire WHERE todo_commentaire.FKtodo = '$todoid' ");

  // Ainsi que les entrées de l'activité récente et du log de modération
  query(" DELETE FROM activite WHERE action_type = 'new_todo' AND action_id = '$todoid' ");
  query(" DELETE FROM activite WHERE action_type = 'fini_todo' AND action_id = '$todoid' ");
  query(" DELETE FROM activite WHERE action_type = 'new_todo_comm' AND parent_id = '$todoid' ");
  query(" DELETE FROM activite WHERE action_type = 'edit_todo_comm' AND action_id = '$todoid' ");
  query(" DELETE FROM activite WHERE action_type = 'del_todo_comm' AND action_id = '$todoid' ");

  // Si le ticket n'était pas encore validé, on message le submitteur pour s'excuser
  if(!$dtodo['valide_admin'])
  {
    $del_titre    = (strlen(html_entity_decode($dtodo['titre'])) > 25) ? substr(html_entity_decode(postdata($dtodo['titre'])),0,24).'...' : postdata($dtodo['titre']);
    $del_message  = "[b]Votre proposition de ticket a été refusée.[/b]\r\n\r\n";
    $del_message .= "[b]Ticket proposé :[/b] ".$dtodo['titre']."\r\n";
    if($_POST['todo_raison'])
      $del_message .= "[b]Raison du refus :[/b] ".$_POST['todo_raison']."\r\n";
    $del_message .= "\r\n";
    $del_message .= "Même si votre ticket a été refusé, votre tentative de contribution au développement de NoBleme est appréciée.\r\n";
    $del_message .= "Si vous pensez que le refus de ce ticket est injuste, vous pouvez répondre à ce message privé pour contester la décision.\r\n";
    $del_message .= "N'hésitez pas à soumettre d'autres propositions de tickets dans le futur.";
    envoyer_notif($dtodo['FKmembres'] , 'Ticket refusé : '.$del_titre , postdata($del_message));
  }

  // Reste plus qu'à rediriger
  header("Location: ".$chemin."pages/todo/index?admin");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des infos du ticket

// On va le chercher
$dtodo = mysqli_fetch_array(query(" SELECT    todo.id           ,
                                              todo.titre        ,
                                              todo.valide_admin ,
                                              COUNT(todo_commentaire.id) AS 'commentaires'
                                    FROM      todo
                                    LEFT JOIN todo_commentaire ON todo.id = todo_commentaire.FKtodo
                                    WHERE     todo.id = '$todoid' "));

// S'il existe pas, dehors
if(!$dtodo['id'])
  erreur('Ticket inexistant');

// Préparation pour l'affichage
$todo_titre         = $dtodo['titre'];
$todo_valide        = $dtodo['valide_admin'];
$todo_commentaires  = $dtodo['commentaires'];




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/administration.png" alt="ADMINISTRATION">
    </div>
    <br>

    <div class="body_main smallsize">
      <span class="titre">Confirmer la suppression du ticket :</span><br>
      <br>
      <span class="gras">Titre :</span> <?=$todo_titre?><br>
      <br>
      <?php if($todo_commentaires) { ?>
      <span class="gras"><?=$todo_commentaires?> commentaires seront également supprimés</span><br>
      <br>
      <?php } ?>
      <form id="todo" method="POST" action="<?=$url_complete?>">
        <?php if(!$todo_valide) { ?>
        <br>
        <table class="indiv">
          <tr>
            <td class="data_input_right spaced todo_delete">
              Raison du refus :
            </td>
            <td>
              <input class="intable" name="todo_raison">
            </td>
          </tr>
        </table>
        <br>
        <?php } ?>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/supprimer.png" alt="SUPPRIMER" name="todo_supprimer">
        </div>
      </form>
    </div>




<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';
