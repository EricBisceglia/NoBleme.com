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

// Langues disponibles
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Proposer une miscellanée" : 'Submit a new quote';
$page_desc  = "Intéractions entre NoBlemeux qui ont été conservées pour la postérité";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Ajout d'une miscellanée
if(isset($_POST['misc_contenu']))
{
  // Mesure anti flood
  if(!$est_admin)
    antiflood();

  // Assainissement du postdata
  $misc_contenu = postdata_vide('misc_contenu', 'string', '');

  if($misc_contenu && $_SESSION['user'])
  {
    // On ajoute la citation à la BDD
    $misc_submitter = postdata($_SESSION['user'], 'int', 0);
    $misc_timestamp = time();
    $misc_langue    = postdata($lang, 'string', 'FR');
    $misc_valide    = ($misc_submitter == 1) ? 1 : 0;
    query(" INSERT INTO quotes
            SET         quotes.timestamp    = '$misc_timestamp' ,
                        quotes.contenu      = '$misc_contenu'   ,
                        quotes.langue       = '$misc_langue'    ,
                        quotes.FKauteur     = '$misc_submitter' ,
                        quotes.valide_admin = '$misc_valide'    ");
    $misc_id        = mysqli_insert_id($db);

    if($misc_valide)
    {
      // Si c'est Bad, on valide la quote d'office, pour ça on a d'abord besoin de plus de postdata à assainir
      $misc_langue  = postdata_vide('misc_langue', 'string', 'FR');
      $misc_nsfw    = (isset($_POST['misc_nsfw'])) ? 1 : 0;

      // Qu'on peut aller rajouter à la citation
      query(" UPDATE  quotes
              SET     quotes.langue   = '$misc_langue'  ,
                      quotes.nsfw     = '$misc_nsfw'
              WHERE   quotes.id       = '$misc_id' ");

      // On ajoute une entrée à l'activité récente
      activite_nouveau('quote_new_'.changer_casse($misc_langue, 'min'), 0, 0, NULL, $misc_id);

      // On envoie un message via le bot IRC
      if($misc_langue == 'FR')
        ircbot($chemin, "Miscellanée #".$misc_id." ajoutée à la collection : ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id, "#NoBleme");
      else
      {
        ircbot($chemin, "Miscellanée anglophone #".$misc_id." ajoutée à la collection : ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id, "#NoBleme");
        ircbot($chemin, "Quote #".$misc_id." added to the collection: ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id, "#english");
      }

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
Proposée par [url={$chemin}pages/users/user?id={$misc_submitter}]{$misc_pseudo}[/url] le {$misc_date}
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
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Proposer une miscellanée";
  $trad['soustitre']  = "Pour amuser la galerie avec une petite citation amusante";

  // Proposition de miscellanée
  $trad['misc_1']     = <<<EOD
Miscellanée : nom féminin, ordinairement au pluriel.<br>
Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.
EOD;
  $trad['misc_2']     = <<<EOD
Si vous avez lu quelque chose d'amusant sur NoBleme, vous pouvez proposer d'immortaliser ce moment dans les miscellanées. Pour ce faire, tout ce que vous avez à faire est remplir le formulaire ci-dessous et patienter le temps de voir si votre proposition de miscellanée est acceptée ou rejetée par <a class="gras" href="{$chemin}pages/users/user?id=1">Bad</a>.
EOD;
  $trad['misc_3']     = <<<EOD
Les critères sur lesquels les propositions de miscellanées sont jugées sont les suivants :<br>
- Vient-elle de NoBleme ? Bien entendu, le contenu des sites autres que NoBleme ne sera pas accepté ici.<br>
- Est-elle divertissante ? Elle doit au moins être un peu amusante, sinon aucune raison de la garder.<br>
- Y a-t-il assez de contexte ? Il y a des choses qui perdent tout leur intérêt une fois sorties de leur contexte.<br>
- Est-elle humiliante pour quelqu'un ? L'objectif n'est pas de rire des NoBlemeux, c'est de rire avec eux.
EOD;
  $trad['misc_4']     = <<<EOD
Maintenant, à vous de jouer. Copiez-coller ou retranscrivez dans le cadre ci-dessous la conversation que vous voudriez voir incluse dans les miscellanées. Ne vous fatiguez pas à la formater, contentez-vous de la balancer telle quelle, la magie de NoBleme s'occupe du reste.
EOD;
  $trad['misc_go']    = "PROPOSER UNE MISCELLANÉE";

  // Remerciements
  $trad['mercimisc1'] = "Merci de votre contribution !";
  $trad['mercimisc2'] = "Votre proposition de miscellanée a été reçue par le système";
  $trad['mercimisc3'] = <<<EOD
Une fois que <a class="gras" href="{$chemin}pages/users/user?id=1">Bad</a> aura jugé votre miscellanée, vous recevrez un message privé vous informant de si elle a été acceptée ou refusée. Dans tous les cas, merci de votre contribution !
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Submit a new quote";
  $trad['soustitre']  = "Contribute to NoBleme's miscellanea collection";

  // Proposition de miscellanée
  $trad['misc_1']     = <<<EOD
Miscellanea: a collection of miscellaneous items, esp literary works.
EOD;
  $trad['misc_2']     = <<<EOD
If you read something funny on NoBleme, you might want it to be immortalized somewhere for posterity. For it to happen, all you have to do is fill the form below with the funny thing in question, and wait until your quote proposal gets accepted or rejected by <a class="gras" href="{$chemin}pages/users/user?id=1">Bad</a>.
EOD;
  $trad['misc_3']     = <<<EOD
The criteria on which the quote proposals are judged are the following:<br>
- Does it come from NoBleme? Obviously, we only want quotes from our own community.<br>
- Is it entertaining? It must be at least a bit funny, otherwise why would we keep it.<br>
- Is there enough context? Some things aren't funny anymore when taken out of their context.<br>
- Is it humiliating for someone? Our goal here is to laugh with people, not to laugh at them.
EOD;
  $trad['misc_4']     = <<<EOD
Now, it's up to you. Copy/paste or retranscribe the conversation you'd want to see quoted in the box below. Don't bother with the formatting, just paste it as is, NoBleme's magic will handle the rest.
EOD;
  $trad['misc_go']    = "SUBMIT A PROPOSAL FOR A NEW QUOTE";

  // Remerciements
  $trad['mercimisc1'] = "Thank you for your contribution!";
  $trad['mercimisc2'] = "Your quote proposal has been registered in the system.";
  $trad['mercimisc3'] = <<<EOD
<a class="gras" href="{$chemin}pages/users/user?id=1">Bad</a> will now judge your quote and decide whether to keep it on the website or not. Once it is done, you will receive a private message informing you of its fate. Thanks a lot for your contribution!
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <?php if(!isset($_GET['ok'])) { ?>

        <h1>
          <?=$trad['titre']?>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
        </h5>

        <p class="italique">
          <?=$trad['misc_1']?>
        </p>

        <p>
          <?=$trad['misc_2']?>
        </p>

        <p>
          <?=$trad['misc_3']?>
        </p>

        <p>
          <?=$trad['misc_4']?>
        </p>

        <br>

        <form method="POST">
          <fieldset>

            <?php if($est_admin) { ?>

            <label for="misc_langue">Langue de la citation</label>
            <select class="indiv" name="misc_langue">
              <option value="FR">Français</option>
              <option value="EN">Anglais</option>
            </select><br>
            <br>

            <label for="misc_contenu">Contenu de la citation</label>

            <?php } ?>

            <textarea class="indiv" name="misc_contenu" style="height:180px"></textarea><br>
            <br>

            <?php if($est_admin) { ?>

            <input id="misc_nsfw" name="misc_nsfw" type="checkbox">
            <label class="label-inline" for="misc_nsfw">Cette citation est NSFW</label><br>
            <br>

            <?php } ?>

            <input type="submit" value="<?=$trad['misc_go']?>">
          </fieldset>
        </form>

        <?php } else { ?>

        <h1>
          <?=$trad['mercimisc1']?>
        </h1>

        <h5>
          <?=$trad['mercimisc2']?>
        </h5>

        <br>

        <p>
          <?=$trad['mercimisc3']?>
        </p>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';