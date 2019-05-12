<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = (isset($_GET['bug'])) ? 'OuvrirTicketBug' : 'OuvrirTicket';

// Identification
$page_nom = (isset($_GET['bug'])) ? 'Prépare un rapport de bug' : 'Fait part de ses désirs intimes';
$page_url = (isset($_GET['bug'])) ? 'pages/todo/request?bug' : 'pages/todo/request';

// Langues disponibles
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Quémander un feature" : "Request a feature";
$page_titre = ($lang == 'FR' && isset($_GET['bug'])) ? "Rapporter un bug" : $page_titre;
$page_titre = ($lang != 'FR' && isset($_GET['bug'])) ? "Report a bug" : $page_titre;
$page_desc  = (isset($_GET['bug'])) ? "Rapporter un bug dans le fonctionnement du site" : "Proposer une nouvelle fonctionnalité pour le site";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Ouverture d'un rapport de bug
if(isset($_POST['bug_ok']) || isset($_POST['feature_ok']))
{
  // Assainissement du postdata
  $todo_contenu = postdata_vide('rapport_contenu', 'string', '');

  if($todo_contenu && $_SESSION['user'])
  {
    // On crée la tâche
    $todo_submitter = postdata($_SESSION['user']);
    $todo_titre     = postdata('Proposition de '.getpseudo());
    $todo_timestamp = time();
    query(" INSERT INTO todo
            SET         todo.FKmembres          = '$todo_submitter' ,
                        todo.timestamp          = '$todo_timestamp' ,
                        todo.titre              = '$todo_pseudo'    ,
                        todo.contenu            = '$todo_contenu'   ,
                        todo.valide_admin       = 0                 ,
                        todo.public             = 1                 ,
                        todo.timestamp_fini     = 0                 ");

    // On envoie une notification à Bad
    $todo_id          = mysqli_insert_id($db);
    $todo_contenu_raw = $_POST['rapport_contenu'];
    $todo_pseudo      = getpseudo();
    $todo_date        = jourfr(date('Y-m-d', $todo_timestamp));
    $todo_titre       = (isset($_POST['bug_ok'])) ? "Rapport de bug" : "Demande de feature";
    $todo_type        = (isset($_POST['bug_ok'])) ? "proposition de tâche" : "demande de fonctionnalité";
    $todo_message     = <<<EOD
Ouvert par [url={$chemin}pages/user/user?id={$todo_submitter}]{$todo_pseudo}[/url] le {$todo_date}
[url={$chemin}pages/todo/edit?id={$todo_id}]Accepter la {$todo_type}[/url]
[url={$chemin}pages/todo/delete?id={$todo_id}]Rejeter la {$todo_type}[/url]

{$todo_contenu_raw}
EOD;
    envoyer_notif(1, postdata($todo_titre), postdata($todo_message));

    // On notifie via IRC
    ircbot($chemin, "Bad: Oh non, ".$todo_pseudo." a soumis un rapport de bug, va voir ce que tu en penses.", "#sysop");

    // On redirige vers un message de validation
    if(isset($_POST['bug_ok']))
      exit(header("Location: ".$chemin."pages/todo/request?bug&ok"));
    else
      exit(header("Location: ".$chemin."pages/todo/request?ok"));
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Rapport de bug
  if(isset($_GET['bug']))
  {
    // Formulaire
    $trad['bug_titre']        = "Rapporter un bug";
    $trad['bug_soustitre']    = "NoBleme vous remercie d'avance de votre aide";
    $trad['bug_desc']         = <<<EOD
<p>
  Si vous avez identifié un problème dans le fonctionnement de NoBleme ou dans son <a class="gras" href="https://bitbucket.org/EricBisceglia/nobleme.com/src/">code source</a>, remplissez le formulaire ci-dessous en détaillant autant que possible la nature du problème que vous avez découvert.
</p>
<p>
  Une fois que <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> aura reçu votre rapport de bug, vous recevrez une <a class="gras" href="{$chemin}pages/user/notifications">notification</a> vous informant de l'état du suivi de votre bug. Merci d'avance pour votre contribution à NoBleme !
</p>
EOD;
    $trad['bug_bouton']       = "ENVOYER LE RAPPORT DE BUG";
    $trad['bug_valider']      = "bug_ok";

    // Confirmation
    $trad['bug_ok_titre']     = "Merci de votre contribution !";
    $trad['bug_ok_soustitre'] = "Votre rapport de bug a bien été envoyé";
    $trad['bug_ok_desc']      = <<<EOD
<p>
  Une fois que <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> aura reçu votre rapport de bug, vous recevrez une <a class="gras" href="{$chemin}pages/user/notifications">notification</a> vous informant de l'état du suivi de votre bug. Merci d'avoir soumis le rapport de bug !
</p>
EOD;
  }
  // Demande de feature
  else
  {
    // Formulaire
    $trad['bug_titre']        = "Quémander un feature";
    $trad['bug_soustitre']    = "Les dieux de NoBleme seront-ils généreux aujourd'hui ?";
    $trad['bug_desc']         = <<<EOD
<p>
  Si vous avez une idée d'altération à une fonctionnalité actuelle qui rendrait l'utilisation du site plus agréable ou de nouvelle fonctionnalité qui serait utile au site, remplissez le formulaire ci-dessous en détaillant autant que possible votre désir. Assurez-vous toutefois avant que ce ne soit pas déjà dans la <a class="gras" href="{$chemin}pages/todo/index">liste des tâches</a>.
</p>
<p>
  Une fois que <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> aura reçu votre demande de fonctionnalité, vous recevrez une <a class="gras" href="{$chemin}pages/user/notifications">notification</a> vous informant de si votre idée a été retenue ou non. Merci d'avance pour votre contribution à NoBleme !
</p>
EOD;
    $trad['bug_bouton']       = "ENVOYER LA DEMANDE DE FONCTIONNALITÉ";
    $trad['bug_valider']      = "feature_ok";

    // Confirmation
    $trad['bug_ok_titre']     = "Merci de votre contribution !";
    $trad['bug_ok_soustitre'] = "Votre demande de fonctionnalité a bien été envoyée";
    $trad['bug_ok_desc']      = <<<EOD
<p>
  Une fois que <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> aura reçu votre demande de fonctionnalité, vous recevrez une <a class="gras" href="{$chemin}pages/user/notifications">notification</a> vous informant de si votre idée a été retenue ou non. Merci d'avance pour votre contribution à NoBleme !
</p>
EOD;
  }
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Rapport de bug
  if(isset($_GET['bug']))
  {
    // Formulaire
    $trad['bug_titre']        = "Bug report";
    $trad['bug_soustitre']    = "NoBleme thanks you for your help";
    $trad['bug_desc']         = <<<EOD
<p>
  If you have found a flaw by using NoBleme or browsing its <a class="gras" href="https://bitbucket.org/EricBisceglia/nobleme.com/src/">source code</a>, please fill up the form below and make sure to detail the issue as much as you can.
</p>
<p>
  Once <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> has read your bug report, you will receive a <a class="gras" href="{$chemin}pages/user/notifications">notification</a> informing you about the status of your bug report. Thanks in advance for your contribution to NoBleme!
</p>
EOD;
    $trad['bug_bouton']       = "SEND BUG REPORT";
    $trad['bug_valider']      = "bug_ok";

    // Confirmation
    $trad['bug_ok_titre']     = "Thank you for contributing!";
    $trad['bug_ok_soustitre'] = "Your bug report has been sent";
    $trad['bug_ok_desc']      = <<<EOD
<p>
  Once <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> has read your bug report, you will receive a <a class="gras" href="{$chemin}pages/user/notifications">message</a> informing you about the status of your bug report. Thank you for taking the time to do this!
</p>
EOD;
  }
  // Demande de feature
  else
  {
    // Formulaire
    $trad['bug_titre']        = "Request a feature";
    $trad['bug_soustitre']    = "Will the gods of NoBleme feel generous today?";
    $trad['bug_desc']         = <<<EOD
<p>
  If you have an idea for an alteration to NoBleme that would improve the website, or an idea for a new feature that would benefit the website, please fill the form below to submit a feature request.
</p>
<p>
  Once <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> has read your feature request, you will receive a <a class="gras" href="{$chemin}pages/user/notifications">message</a> informing you about the status of your feature request. Thanks in advance for your contribution to NoBleme!
</p>
EOD;
    $trad['bug_bouton']       = "SEND FEATURE REQUEST";
    $trad['bug_valider']      = "feature_ok";

    // Confirmation
    $trad['bug_ok_titre']     = "Thank you for contributing!";
    $trad['bug_ok_soustitre'] = "Your feature request has been sent";
    $trad['bug_ok_desc']      = <<<EOD
<p>
  Once <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> has read your feature request, you will receive a <a class="gras" href="{$chemin}pages/user/notifications">message</a> informing you about the status of your feature request. Thank you for taking the time to do this!
</p>
EOD;
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <?php if(!isset($_GET['ok'])) { ?>

        <h1><?=$trad['bug_titre']?></h1>

        <h5><?=$trad['bug_soustitre']?></h5>

        <?=$trad['bug_desc']?>

        <br>

        <form method="POST">
          <fieldset>
            <textarea class="indiv" name="rapport_contenu" style="height:150px"></textarea><br>
            <br>
            <input type="submit" value="<?=$trad['bug_bouton']?>" name="<?=$trad['bug_valider']?>">
          </fieldset>
        </form>

        <?php } else { ?>

        <h1><?=$trad['bug_ok_titre']?></h1>

        <h5><?=$trad['bug_ok_soustitre']?></h5>

        <br>

        <?=$trad['bug_ok_desc']?>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';