<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Titre et description
$page_titre = "Miscellanées";
$page_desc  = "Proposer l'ajout d'une nouvelle miscellanée";

// Identification
$page_nom = "quotes";
$page_id  = "add";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On check si il y a un ajout de nouvelle citation
if(isset($_POST['quote_add_x']) && $_POST['quote_contenu'])
{
  // Assainissement du postdata et préparation des données
  $quote_contenu    = postdata(destroy_html($_POST['quote_contenu']));
  $quote_timestamp  = time();
  $quote_auteur     = $_SESSION['user'];

  // Si c'est un user on le traite mal
  if(!getadmin())
  {
    // On check que ça ne soit pas du spam de quotes
    $qquote = mysqli_fetch_array(query(" SELECT timestamp FROM quotes WHERE FKauteur = '$quote_auteur' ORDER BY timestamp DESC LIMIT 1 "));
    if((time() - $qquote['timestamp']) <= 30)
      erreur("Flood : Merci d'attendre avant de proposer une autre miscellanée");

    // On propose la quote
    query(" INSERT INTO quotes
            SET         timestamp     = '$quote_timestamp'  ,
                        contenu       = '$quote_contenu'    ,
                        FKauteur      = '$quote_auteur'     ,
                        valide_admin  = 0                   ");

    // Message à Bad pour lui faire savoir qu'une quote attend validation
    $add_quote    = mysqli_insert_id($db);
    $add_auteur   = postdata(getpseudo());
    $add_date     = postdata(datefr(date('Y-m-d',$quote_timestamp)));
    $add_message  = '[b][url='.$chemin.'pages/irc/quotes?id='.$add_quote.']Lien vers la miscellanée[/url][/b]\r\n\r\n';
    $add_message .= '[b]Date :[/b] '.$add_date.'\r\n';
    $add_message .= '[b]Auteur :[/b] [url='.$chemin.'pages/user/user?id='.$quote_auteur.']'.$add_auteur.'[/url]\r\n\r\n';
    $add_message .= '[quote='.$add_auteur.']'.$quote_contenu.'[/quote]';
    envoyer_notif(1, 'Proposition de miscellanée', $add_message);

    // Et redirection vers un monde meilleur
    header('Location: '.$chemin.'pages/irc/quote_add?done');
  }
  // Si c'est un admin, on balance direct la quote
  else
  {
    query(" INSERT INTO quotes
            SET         timestamp     = '$quote_timestamp'  ,
                        contenu       = '$quote_contenu'    ,
                        FKauteur      = '$quote_auteur'     ,
                        valide_admin  = 1                   ");
    header('Location: '.$chemin.'pages/irc/quotes?id='.mysqli_insert_id($db));
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

  <br>
  <div class="indiv align_center">
    <a href="<?=$chemin?>pages/irc/quotes">
      <img src="<?=$chemin?>img/logos/miscellanees.png" alt="Miscellanées">
    </a>
  </div>
  <br>

  <?php if(!isset($_GET['done'])) { ?>
  <div class="body_main midsize">
    <span class="titre">Proposer une nouvelle miscellanée</span><br>
    <br>
    <span class="italique">Miscellanée : nom féminin, ordinairement au pluriel.<br>
    Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.</span><br>
    <br>
    Les miscellanées sont des phrases, des monologues, des conversations entre les NoBlemeux qui sont été conservés pour la posterité.<br>
    Votre proposition de miscellanée doit impérativement <span class="gras">provenir de NoBleme</span>. Peu importe qu'elle vienne du <a href="<?=$chemin?>pages/irc/">serveur IRC</a>, du <a href="<?=$chemin?>pages/forum/">forum</a>, ou qu'elle soit une retranscription de propos tenus pendant une <a href="<?=$chemin?>pages/nobleme/irls">rencontre IRL</a>, tant que ça vient de NoBleme et pas d'ailleurs.<br>
    <br>
    Une fois votre miscellanée proposée, elle sera jugée par <a href="<?=$chemin?>pages/user/user?pseudo=Bad">Bad</a>. Vous recevrez une notification vous informant de la décision du jugement.<br>
    Si elle est assez divertissante, elle sera acceptée et listée <a href="<?=$chemin?>pages/irc/quotes">avec les autres miscellanées</a>.<br>
    <br>
    Les critères selon lesquels les propositions de miscellanées sont jugées sont les suivants :<br>
    - Est-elle divertissante ? Elle doit au moins être un peu amusante, sinon il n'y a aucune raison de la garder.<br>
    - Y a-t-il assez de contexte ? Il y a des choses qui ne sont pas drôles si on a pas le reste de la conversation qui va avec.<br>
    - Est-elle humiliante pour quelqu'un ? L'objectif des miscellanées n'est pas de rire des NoBlemeux, c'est de rire avec eux.<br>
    <br>
    <br>
    Maintenant, à vous de jouer. Copiez-coller ou retranscrivez dans le cadre ci-dessous la conversation que vous voudriez voir incluse dans les miscellanées. Ne vous fatiguez pas à la formater, contentez-vous de la balancer telle quelle, la magie de NoBleme s'occupe du reste.<br>
    <br>
    <form name="add_quote" action="quote_add" method="POST">
      <textarea class="indiv" rows="15" name="quote_contenu"></textarea><br>
      <br>
      <div class="indiv align_center">
        <input type="image" src="<?=$chemin?>img/boutons/miscellanee.png" name="quote_add">
      </div>
    </form>
  </div>

  <?php } else { ?>
  <div class="body_main midsize">
    <span class="titre">Merci de votre contribution !</span><br>
    <br>
    Votre proposition de miscellanée a bien été envoyée. Elle sera maintenant jugée, puis acceptée ou refusée.<br>
    Même si elle finit par être refusée, merci de l'avoir proposée. Toute contribution est appréciée !<br>
    <br>
    Vous recevrez une notification vous informant du sort de votre miscellanée une fois que le jugement aura eu lieu.<br>
    Notez que le contenu de la miscellanée sera probablement reformaté et peut-être reformulé.<br>
  </div>
  <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';