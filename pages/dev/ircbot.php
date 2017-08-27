<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'IRCbot';

// Titre et description
$page_titre = "Dev: Bot IRC";

// Identification
$page_nom = "admin";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Envoyer un message

if(isset($_POST['botMessage']) && $_POST['botMessage'])
{
  if($ircbot_canal == 'aucun')
    ircbot($chemin,$_POST['botMessage']);
  else
    ircbot($chemin,$_POST['botMessage'],$_POST['botCanal'],1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Notifier #dev d'un commit

if(isset($_POST['botCommit']) && $_POST['botCommit'])
{
  $ircbot_commit = "Nouveau commit dans le dépôt public de NoBleme: ".$_POST['botCommit'];
  if($_POST['botCommitTitre'])
    $ircbot_commit .= " - ".$_POST['botCommitTitre'];
  ircbot($chemin,$ircbot_commit,"#dev");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tuer le bot... bonne nuit doux prince

if(isset($_POST['botQuit']))
  ircbot($chemin,"quit");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Dernière commande effectuée par le bot
if(file_exists($chemin."ircbot.txt"))
  $ircbot_debug = substr(file_get_contents($chemin."ircbot.txt"),11);
else
  $ircbot_debug = "Le fichier .txt du bot IRC n'existe pas ou est mal configuré";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Gestion du bot IRC NoBleme</h1>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

      <div class="texte">

        <p>
          <h5>Envoyer un message sur IRC via le bot</h5>
        </p>

        <form method="POST">
          <fieldset>
            <label for="botMessage">Message à envoyer</label>
            <input id="botMessage" name="botMessage" class="indiv" type="text"><br>
            <br>
            <label for="botCanal">Canal sur lequel envoyer le message</label>
            <select id="botCanal" name="botCanal" class="indiv">
              <option value="#nobleme">#NoBleme</option>
              <option value="#dev">#Dev</option>
              <option value="#sysop">#Sysop</option>
              <option value="aucun">Aucun (commande, sans le slash)</option>
            </select><br>
            <br>
            <input value="Envoyer le message" type="submit">
          </fieldset>
        </form>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

      <div class="texte">

        <p>
          <h5>Notifier #dev d'un nouveau commit</h5>
        </p>

        <form method="POST">
          <fieldset>
            <label for="botCommit">URL du commit | <a href="https://bitbucket.org/EricBisceglia/nobleme.com/commits/all">Bitbucket</a></label>
            <input id="botCommit" name="botCommit" class="indiv" type="text"><br>
            <br>
            <label for="botCommitTitre">Titre du commit</label>
            <input id="botCommitTitre" name="botCommitTitre" class="indiv" type="text"><br>
            <br>
            <input value="Notifier #Dev" type="submit">
          </fieldset>
        </form>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

      <div class="texte">

        <p>
          <h5>Debug: Dernière commande enregistrée</h5>
        </p>

        <p class="texte_nobleme_fonce gras">
          <?=$ircbot_debug?>
        </p>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

      <div class="texte">

        <p>
          <h5>Démarrer le bot</h5>
        </p>

        <p class="align_center gros gras texte_negatif">
          Surtout ne pas démarrer le bot s'il est déja démarré !
        </p>

        <form action="<?=$chemin?>pages/dev/ircbot_boot">
          <p class="align_center">
            <button>Démarrer le bot</button>
          </p>
        </form>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

      <div class="texte">

        <p>
          <h5>Arrêter le bot</h5>
        </p>

        <form method="POST">
          <p class="align_center">
            <input type="submit" name="botQuit" value="Forcer le bot à quitter IRC">
          </p>
        </form>

      </div>

      <br>
      <br>

      <hr class="separateur_contenu">

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';