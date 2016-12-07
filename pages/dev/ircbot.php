<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'admin';
$header_submenu   = 'dev';
$header_sidemenu  = 'ircbot';

// Titre et description
$page_titre = "Bot IRC NoBleme";
$page_desc  = "Gestion du bot IRC NoBleme";

// Identification
$page_nom = "admin";
$page_id  = "admin";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Forcer le bot à quitter

if(isset($_GET['quit']))
  ircbot($chemin,"quit");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Envoyer un message avec le bot

if(isset($_POST['ircbot_message']) && $_POST['ircbot_commande'])
{
  // Assainissement du postdata
  $ircbot_message = $_POST['ircbot_commande'];
  $ircbot_canal   = $_POST['ircbot_canal'];

  // On rajoute le # au nom du canal si nécessire
  if($ircbot_canal && substr($ircbot_canal,0,1) != "#")
    $ircbot_canal = "#".$ircbot_canal;

  // Reste plus qu'à balancer la commande
  if($ircbot_canal)
    ircbot($chemin,$ircbot_message,$ircbot_canal,1);
  else
    ircbot($chemin,$ircbot_message);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Notifier #dev d'un commit

if(isset($_POST['ircbot_commit']) && $_POST['ircbot_commit_url'])
  ircbot($chemin,"Nouveau commit : ".$_POST['ircbot_commit_url'],"#dev");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/administration.png" alt="Administration">
    </div>
    <br>

    <div class="body_main midsize">
      <table class="cadre_gris indiv">

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros gras">
            DÉMARRER LE BOT IRC NOBLEME
          </td>
        </tr>
        <tr>
          <td class="cadre_gris monospace align_center moinsgros gras">
            <br>
            !!! Ne pas démarrer le bot s'il est déjà en train de fonctionner !!!<br>
            <br>
            <a href="<?=$chemin?>pages/dev/ircbot_boot" target="blank" class="dark blank">Cliquer ici pour démarrer le bot</a><br>
            <br>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros gras">
            ARRÊTER LE BOT IRC NOBLEME
          </td>
        </tr>
        <tr>
          <td class="cadre_gris monospace align_center moinsgros gras">
            <br>
            <a href="<?=$chemin?>pages/dev/ircbot?quit" target="blank" class="dark blank">Cliquer ici pour forcer le bot à quitter IRC</a><br>
            <br>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros gras">
            ENVOYER UN MESSAGE PERSONNALISÉ AVEC LE BOT IRC NOBLEME
          </td>
        </tr>
        <tr>
          <td class="cadre_gris monospace align_center moinsgros">
            <br>
            <form name="ircbot_msg" action="ircbot" method="POST">
              Commande à envoyer <input name="ircbot_commande" value=""><br>
              #canal (optionnel) <input name="ircbot_canal" value=""><br>
              <br>
              <input type="submit" name="ircbot_message" value="Envoyer le message">
            </form>
            <br>
          </td>
        </tr>

        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros gras">
            NOTIFIER #DEV D'UN NOUVEAU COMMIT
          </td>
        </tr>
        <tr>
          <td class="cadre_gris monospace align_center moinsgros">
            <br>
            <form name="ircbot_commit" action="ircbot" method="POST">
              URL du commit <input name="ircbot_commit_url" value=""> <a class="dark blank" href="https://bitbucket.org/EricBisceglia/nobleme.com/commits/all" target="_blank">Bitbucket</a><br>
              <br>
              <input type="submit" name="ircbot_commit" value="Notifier #dev du commit">
            </form>
            <br>
          </td>
        </tr>

      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';