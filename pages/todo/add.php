<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Menus du header
$header_menu      = '';
$header_submenu   = 'dev';
$header_submenu   = (!isset($_GET['doc'])) ? $header_submenu : 'aide';
$header_sidemenu  = (!isset($_GET['bug'])) ? 'ticket' : 'ticket_bug';
$header_sidemenu  = (!isset($_GET['feature'])) ? $header_sidemenu : 'ticket_feature';
$header_sidemenu  = (!isset($_GET['doc'])) ? $header_sidemenu : 'bug';

// Titre et description
$page_titre = "Ouvrir un ticket";
$page_desc  = "Ouverture d'un ticket pour reporter un bug ou proposer un feature";

// Identification
$page_nom = "todo";
$page_id  = "add";

// CSS
$css = array('todo');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualisation

if(isset($_POST['todo_add_previsualiser_x']))
{
  $todo_add_prev_titre    = destroy_html($_POST['todo_add_titre']);
  $todo_add_prev_contenu  = bbcode(nl2br_fixed(destroy_html($_POST['todo_add_contenu'])));
  $todo_add_prev_raw      = destroy_html($_POST['todo_add_contenu']);
}
else
{
  $todo_add_prev_titre    = '';
  $todo_add_prev_raw      = '';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouveau ticket

if(isset($_POST['todo_add_ajouter_x']))
{
  // Assainissement du postdata
  $add_titre      = postdata(destroy_html($_POST['todo_add_titre']));
  $add_contenu    = postdata(destroy_html($_POST['todo_add_contenu']));
  $add_user       = $_SESSION['user'];
  $add_timestamp  = time();

  // On crée le ticket
  query(" INSERT INTO todo
          SET         FKmembres         = '$add_user'       ,
                      timestamp         = '$add_timestamp'  ,
                      importance        = 0                 ,
                      titre             = '$add_titre'      ,
                      contenu           = '$add_contenu'    ,
                      FKtodo_categorie  = 0                 ,
                      FKtodo_roadmap    = 0                 ,
                      valide_admin      = 0                 ,
                      public            = 0                 ,
                      timestamp_fini    = 0                 ");

  // Et finalement on envoie une notification
  $add_ticket   = mysqli_insert_id($db);
  $add_pseudo   = postdata(getpseudo());
  $add_date     = postdata(datefr(date('Y-m-d',$add_timestamp)));
  $add_message  = '[b][url='.$chemin.'pages/todo/index?id='.$add_ticket.']Lien vers le ticket[/url][/b]\r\n\r\n';
  $add_message .= '[b]Date : [/b]'.$add_date.'\r\n';
  $add_message .= '[b]Auteur : [/b] [url='.$chemin.'pages/user/user?id='.$add_user.']'.$add_pseudo.'[/url]\r\n';
  $add_message .= '[b]Titre : [/b]'.$add_titre.'\r\n\r\n';
  $add_message .= '[quote='.$add_pseudo.']'.$add_contenu.'[/quote]';
  envoyer_notif(1 , 'Ticket à valider : '.$add_titre , $add_message);
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/todo_add.png" alt="OUVRIR UN TICKET">
    </div>
    <br>

    <?php if(!isset($_POST['todo_add_ajouter_x'])) { ?>
    <div class="body_main midsize">
      <span class="titre">À lire avant d'ouvrir un ticket</span><br>
      <br>
      Les <a href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> et les <a href="<?=$chemin?>pages/doc/emotes">émoticônes</a> sont autorisés pour mettre en forme votre message.<br>
      <br>
      Une fois le ticket rempli, votre requête sera jugée, puis acceptée ou refusée selon sa pertinence.<br>
      Vous recevrez une <a href="<?=$chemin?>pages/user/pm">notification</a> vous informant du sort de votre requête une fois que le jugement aura eu lieu.<br>
      Notez que le contenu de votre ticket sera probablement reformulé.<br>
      <br>
      Surtout, soyez aussi descriptif que possible.<br>
      Si un rapport de bug n'est pas clair, il est impossible de reproduire le bug, et le ticket sera refusé.<br>
      Si une demande de feature n'est pas claire, il est impossible de comprendre ce que vous désirez, et le ticket sera refusé.<br>
      <br>
      Prenez également le temps de vérifier que votre requête ne soit pas déjà présente dans la <a href="<?=$chemin?>pages/todo/index">liste des tâches</a>.<br>
      <br>
      Une fois votre demande envoyée, elle ne pourra pas être modifiée ni annulée.<br>
      Afin d'éviter de faire des erreurs en allant trop vite, il est obligatoire de prévisualiser la demande avant de l'envoyer.<br>
    </div>

    <br>

    <?php if(isset($_POST['todo_add_previsualiser_x'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Ticket : <?=$todo_add_prev_titre?></span><br>
      <br>
      <?=$todo_add_prev_contenu?>
    </div>
    <?php } ?>

    <div class="body_main midsize">
      <form id="todo_add" method="POST" action="add">
        <table class="indiv data_input">
          <tr>
            <td class="data_input_right spaced todo_add">Titre :</td>
            <td class="spaced"><input class="indiv" name="todo_add_titre" value="<?=$todo_add_prev_titre?>"></td>
            <td class="data_input_left spaced todo_add_legende">Bref résumé du ticket</td>
          </tr>
          <tr>
            <td class="data_input_right spaced todo_add valign_center">Description :</td>
            <td class="spaced"><textarea class="indiv" rows="10" name="todo_add_contenu"><?=$todo_add_prev_raw?></textarea></td>
            <td class="data_input_left spaced todo_add_legende valign_center">
              Description détaillée du ticket<br>
              Les <a class="dark blank gras" href="<?=$chemin?>pages/doc/bbcodes">BBcodes</a> sont autorisés<br>
              Les <a class="dark blank gras" href="<?=$chemin?>pages/doc/emotes">émoticônes</a> sont autorisées
            </td>
          </tr>
          <tr>
            <td colspan="3" class="align_center">
              <input type="image" src="<?=$chemin?>img/boutons/previsualiser.png" alt="PRÉVISUALISER" name="todo_add_previsualiser">
              <?php if(isset($_POST['todo_add_previsualiser_x'])) { ?>
              <img src="<?=$chemin?>img/boutons/separateur.png" alt=" | ">
              <input type="image" src="<?=$chemin?>img/boutons/envoyer.png" alt="AJOUTER" name="todo_add_ajouter">
              <?php } ?>
            </td>
          </tr>
        </table>
      </form>
    </div>

    <?php } else { ?>

    <div class="body_main midsize">
      <span class="titre">Merci d'avoir aidé à améliorer NoBleme</span><br>
      <br>
      Votre ticket a bien été envoyé. Il sera maintenant jugé, puis accepté ou refusé.<br>
      Même s'il finit par être refusé, merci d'avoir proposé de contribuer à l'amélioration de NoBleme. Votre aide est appréciée.<br>
      <br>
      Vous recevrez une notification vous informant du sort de votre requête une fois que le jugement aura eu lieu.<br>
      Notez que le contenu de votre ticket sera probablement reformulé.<br>
    </div>

    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';