<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
sysoponly($lang);

// Menus du header
$header_menu      = 'Admin';
$header_sidemenu  = 'Bannir';

// Identification
$page_nom = "Administre secrètement le site";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Bannir un utilisateur";

// JS
$js = array('dynamique', 'sysop/chercher_user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si on est en train de bannir un utilisateur

if(isset($_POST['ban_go']) && isset($_POST['ban_raison']) && $_POST['ban_raison'])
{
  // On nettoie le postdata
  $ban_id     = postdata($_GET['id'], 'int', 0);
  $ban_raison = postdata(tronquer_chaine($_POST['ban_raison'], 50), 'string');
  $ban_duree  = ((postdata_vide('ban_duree', 'int', '') * 86400) + time());

  // On vérifie que l'user existe, sinon on dégage
  $qtestban = mysqli_fetch_array(query("  SELECT  membres.id
                                          FROM    membres
                                          WHERE   membres.id = '$ban_id' "));
  if(!$qtestban['id'])
    header("Location: ".$chemin."pages/sysop/ban");

  // On bannit l'user
  query(" UPDATE  membres
          SET     banni_date    = '$ban_duree' ,
                  banni_raison  = '$ban_raison'
          WHERE   membres.id    = '$ban_id' ");

  // On ajoute le ban à l'activité récente
  $ban_pseudo = postdata(getpseudo($ban_id), 'string');
  $ban_jours  = postdata_vide('ban_duree', 'int', 0);
  activite_nouveau('ban', 0, $ban_id, $ban_pseudo, $ban_jours);

  // Ainsi qu'aux logs de modération
  $ban_sysop = postdata(getpseudo(), 'string');
  activite_nouveau('ban', 1, $ban_id, $ban_pseudo, $ban_jours, NULL, $ban_sysop, $ban_raison);

  // On prépare le message privé à envoyer à l'user banni
  $ban_duree_raw  = $_POST['ban_duree'];
  $ban_raison_raw = tronquer_chaine($_POST['ban_raison'], 50);
  $ban_pm = <<<EOD
Vous avez été banni de NoBleme pendant {$ban_duree_raw} jour(s)
[b]Raison du ban:[/b] {$ban_raison_raw}

À l'avenir, respectez le [url={$chemin}pages/doc/coc]code de conduite[/url] de NoBleme.



You have been banned from NoBleme for {$_POST['ban_duree']} day(s)

In the future, respect NoBleme's [url={$chemin}pages/doc/coc]code of conduct[/url].
EOD;

  // On envoie un message privé à l'user qui s'est fait bannir
  envoyer_notif($ban_id, "Vous avez été banni / You have been banned", postdata($ban_pm));

  // On notifie #NoBleme et #sysop de l'action
  $temp_jour = ($ban_jours == 1) ? ' jour' : ' jours';
  ircbot($chemin, getpseudo($ban_id)." a été banni de NoBleme pendant ".$ban_jours.$temp_jour." - ".$GLOBALS['url_site']."pages/user/user?id=".$ban_id, "#nobleme");
  ircbot($chemin, getpseudo()." a banni ".getpseudo($ban_id)." pendant ".$ban_jours.$temp_jour." - ".$GLOBALS['url_site']."pages/sysop/pilori", "#sysop");

  // Et on redirige vers le profil de l'user
  header("Location: ".$chemin."pages/user/user?id=".$ban_id);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si on est en train de débannir un utilisateur

if(isset($_POST['deban_go']) && isset($_POST['deban_raison']) && $_POST['deban_raison'])
{
  // On nettoie le postdata
  $deban_id     = postdata($_GET['id'], 'int', 0);
  $deban_raison = postdata(tronquer_chaine($_POST['deban_raison'], 50), 'string');

  // On vérifie que l'user existe, sinon on dégage
  $qtestdeban = mysqli_fetch_array(query("  SELECT  membres.id
                                          FROM    membres
                                          WHERE   membres.id = '$deban_id' "));
  if(!$qtestdeban['id'])
    header("Location: ".$chemin."pages/sysop/ban");

  // On débannit l'user
  query(" UPDATE  membres
          SET     banni_date    = 0 ,
                  banni_raison  = ''
          WHERE   membres.id    = '$deban_id' ");

  // On ajoute le ban à l'activité récente
  $deban_pseudo = postdata(getpseudo($deban_id), 'string');
  activite_nouveau('deban', 0, $deban_id, $deban_pseudo);

  // Ainsi qu'aux logs de modération
  $deban_sysop = postdata(getpseudo(), 'string');
  activite_nouveau('deban', 1, $deban_id, $deban_pseudo, 0, NULL, $deban_sysop, $deban_raison);

  // On prépare le message privé à envoyer à l'user banni
  $deban_raison_raw = tronquer_chaine($_POST['deban_raison'], 50);
  $deban_pm = <<<EOD
Votre bannissement a été levé, vous pouvez utiliser votre compte à nouveau.
[b]Raison du débannissement:[/b] {$deban_raison_raw}

À l'avenir, respectez le [url={$chemin}pages/doc/coc]code de conduite[/url] de NoBleme.



Your banishment has been lifted, you can use your account again

In the future, respect NoBleme's [url={$chemin}pages/doc/coc]code of conduct[/url].
EOD;

  // On envoie un message privé à l'user qui s'est fait bannir
  envoyer_notif($deban_id, "Vous avez été débanni / You have been unbanned", postdata($deban_pm));

  // On notifie #sysop de l'action
  ircbot($chemin, getpseudo()." a débanni ".getpseudo($deban_id)." - ".$GLOBALS['url_site']."pages/nobleme/activite?mod", "#sysop");

  // Et on redirige vers le profil de l'user
  header("Location: ".$chemin."pages/user/user?id=".$deban_id);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a choisi l'user à ban, on prépare ses infos
if(isset($_GET['id']))
{
  // On commence par récupérer l'ID
  $ban_id = postdata($_GET['id'], 'int', 0);

  // On va chercher les données liées à l'user
  $qbanuser = mysqli_fetch_array(query("  SELECT  membres.pseudonyme  ,
                                                  membres.banni_date
                                          FROM    membres
                                          WHERE   membres.id = '$ban_id' "));
  $ban_etat   = $qbanuser['banni_date'];
  $ban_pseudo = predata($qbanuser['pseudonyme']);

  // Si l'user existe pas, on dégage
  if(!$ban_pseudo)
    $_GET['id'] = 0;
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Bannir un utilisateur</h1>

        <p>Je vous fais confiance pour ne pas utiliser cet outil à la légère. Un bannissement court (1-7 jours) est une bonne façon de faire comprendre à quelqu'un qu'il doit impérativement changer son comportement. Un bannissement très long (un mois, un an) est une bonne façon de se débarrasser de quelqu'un d'indésirable. Abuser des bannissements est une bonne façon de passer pour un site à la modération brutale et perdre la confiance de la communauté.</p>

        <br>
        <br>

        <?php if(isset($_GET['id']) && $ban_pseudo && $ban_id == 1) { ?>

        <h5>On ne bannit pas le patron. Bien essayé.</h5>

        <?php } else if(isset($_GET['id']) && $ban_pseudo && $ban_etat) { ?>

        <h5>Débannir <a href="<?=$chemin?>pages/user/user?id=<?=$ban_id?>"><?=$ban_pseudo?></a> de NoBleme</h5>
        <br>

        <form method="POST">
          <fieldset>
            <label for="deban_raison">Justification du deban (doit être impérativement rempli, en résumé, 50 caractères max):</label>
            <input id="deban_raison" name="deban_raison" class="indiv" type="text" maxlength="50"><br>
            <br>
            <input value="Débannir <?=$ban_pseudo?>" type="submit" name="deban_go">
          </fieldset>
        </form>

        <?php } else if(isset($_GET['id']) && $ban_pseudo) { ?>

        <h5>Bannir <a href="<?=$chemin?>pages/user/user?id=<?=$ban_id?>"><?=$ban_pseudo?></a> de NoBleme</h5>
        <br>

        <form method="POST">
          <fieldset>
            <label for="ban_raison">Justification du ban (doit être impérativement rempli, en résumé, 50 caractères max):</label>
            <input id="ban_raison" name="ban_raison" class="indiv" type="text" maxlength="50"><br>
            <br>
            <label for="ban_duree">Durée du ban</label>
            <select id="ban_duree" name="ban_duree" class="indiv">
              <option value="1">Une journée</option>
              <option value="2">Deux jours</option>
              <option value="3">Trois jours</option>
              <option value="7">Une semaine</option>
              <option value="30">Un mois</option>
              <option value="365">Un an</option>
              <option value="3650">Permaban (dix ans)</option>
            </select><br>
            <br>
            <input value="Bannir <?=$ban_pseudo?>" type="submit" name="ban_go">
          </fieldset>
        </form>

        <?php } else { ?>

        <fieldset>
          <label for="sysop_pseudo_user">Entrez une partie du pseudonyme de l'utilisateur que vous souhaitez bannir :</label>
          <input  id="sysop_pseudo_user" name="sysop_pseudo_user" class="indiv" type="text"
                  onkeyup="sysop_chercher_user('<?=$chemin?>', 'Bannir', 'ban')";><br>
        </fieldset>

      </div>

      <div class="minitexte" id="sysop_liste_users">
        &nbsp;

      <?php } ?>

    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';