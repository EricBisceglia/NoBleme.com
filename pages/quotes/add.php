<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'MiscAdd';

// Identification
$page_nom = "Propose une nouvelle miscellanée";
$page_url = "pages/quotes/add";

// Langages disponibles
$langage_page = array('FR');

// Titre et description
$page_titre = "Proposer une miscellanée" ;
$page_desc  = "Intéractions entre NoBlemeux qui ont été conservées pour la postérité";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Ajout d'une miscellanée
if(isset($_POST['misc_contenu']))
{
  // Assainissement du postdata
  $misc_contenu = postdata_vide('misc_contenu', 'string', '');

  if($misc_contenu && $_SESSION['user'])
  {
    // On ajoute la citation à la BDD
    $misc_submitter = postdata($_SESSION['user']);
    $misc_timestamp = time();
    $misc_valide    = ($misc_submitter == 1) ? 1 : 0;
    query(" INSERT INTO quotes
            SET         quotes.timestamp    = '$misc_timestamp' ,
                        quotes.contenu      = '$misc_contenu'   ,
                        quotes.FKauteur     = '$misc_submitter' ,
                        quotes.valide_admin = '$misc_valide'    ");
    $misc_id        = mysqli_insert_id($db);

    if($misc_valide)
    {
      // Si c'est Bad, la quote est direct validée, on ajoute une entrée à l'activité récente
      query(" INSERT INTO activite
              SET         timestamp   = '$misc_timestamp' ,
                          action_type = 'quote'           ,
                          action_id   = '$misc_id'        ");

      // On envoie un message via le bot IRC
      ircbot($chemin, "Miscellanée #".$misc_id." ajoutée à la collection: ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id, "#NoBleme");

      // Puis on redirige vers la page de modification de la citation pour y lier des membres
      exit(header("Location: ".$chemin."pages/quotes/edit?id=".$misc_id));
    }
    else
    {
      // Sinon, on envoie un message de validation à Bad
      $misc_contenu_raw = $_POST['misc_contenu'];
      $misc_pseudo      = getpseudo();
      $misc_date        = jourfr(date('Y-m-d', $misc_timestamp));
      $misc_message     = <<<EOD
Proposée par [url={$chemin}pages/user/user?id={$misc_submitter}]{$misc_pseudo}[/url] le {$misc_date}
[url={$chemin}pages/quotes/edit?id={$misc_id}]Accepter la proposition de miscellanée[/url]
[url={$chemin}pages/quotes/delete?id={$misc_id}]Rejeter la proposition de miscellanée[/url]

{$misc_contenu_raw}
EOD;
      envoyer_notif(1, "Proposition de miscellanée", postdata($misc_message));

      // On notifie via IRC
      ircbot($chemin, "Bad: Yo, quelqu'un a soumis une nouvelle proposition de miscellanée, va voir ce que tu en penses.", "#sysop");

      // On redirige vers un message de validation
      exit(header("Location: ".$chemin."pages/quotes/add?ok"));
    }
  }
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <?php if(!isset($_GET['ok'])) { ?>

        <h1>Proposer une miscellanée</h1>

        <h5>Pour amuser la galerie avec une petite citation amusante</h5>

        <p class="italique">
          Miscellanée : nom féminin, ordinairement au pluriel.<br>
          Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.
        </p>

        <p>
          Si vous avez lu quelque chose d'amusant sur NoBleme, vous pouvez proposer d'immortaliser ce moment dans les miscellanées. Pour ce faire, tout ce que vous avez à faire est remplir le formulaire ci-dessous et patienter le temps de voir si votre proposition de miscellanée est acceptée ou rejetée par <a class="gras" href="<?=$chemin?>pages/user/user?id=1">Bad</a>.
        </p>

        <p>
          Les critères sur lesquels les propositions de miscellanées sont jugées sont les suivants :<br>
          - Vient-elle de NoBleme ? Bien entendu, le contenu des sites autres que NoBleme ne sera pas accepté ici.<br>
          - Est-elle divertissante ? Elle doit au moins être un peu amusante, sinon aucune raison de la garder.<br>
          - Y a-t-il assez de contexte ? Il y a des choses qui perdent tout leur intérêt une fois sorties de leur contexte.<br>
          - Est-elle humiliante pour quelqu'un ? L'objectif n'est pas de rire des NoBlemeux, c'est de rire avec eux.<br>
        </p>

        <p>
          Maintenant, à vous de jouer. Copiez-coller ou retranscrivez dans le cadre ci-dessous la conversation que vous voudriez voir incluse dans les miscellanées. Ne vous fatiguez pas à la formater, contentez-vous de la balancer telle quelle, la magie de NoBleme s'occupe du reste.
        </p>

        <br>

        <form method="POST">
          <fieldset>
            <textarea class="indiv" name="misc_contenu" style="height:180px"></textarea><br>
            <br>
            <input type="submit" value="PROPOSER UNE MISCELLANÉE">
          </fieldset>
        </form>

        <?php } else { ?>

        <h1>Merci de votre contribution !</h1>

        <h5>Votre proposition de miscellanée a été reçue par le système</h5>

        <br>

        <p>
          Une fois que <a class="gras" href="<?=$chemin?>pages/user/user?id=1">Bad</a> aura jugé votre miscellanée, vous recevrez un message privé vous informant de si elle a été acceptée ou refusée. Dans tous les cas, merci de votre contribution !
        </p>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';