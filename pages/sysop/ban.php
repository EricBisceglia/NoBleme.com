<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
sysoponly();

// Menus du header
$header_menu      = 'admin';
$header_submenu   = 'mod';
$header_sidemenu  = 'bannir';

// Titre et description
$page_titre = "Bannir un utilisateur";
$page_desc  = "Administration - Bannir un utilisateur de NoBleme";

// Identification
$page_nom = "sysop";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'ID

if(isset($_GET['id']))
{
  // On assainit avant tout
  $idban = postdata($_GET['id']);

  // Si c'est pas un nombre, dehors
  if(!is_numeric($_GET['id']))
    erreur('ID invalide');

  // Si l'utilisateur n'existe pas, dehors
  if(!mysqli_num_rows(query(" SELECT membres.id FROM membres WHERE membres.id = '$idban' ")))
    erreur("Impossible de modifier un utilisateur qui n'existe pas");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Chercher un utilisateur

if(isset($_POST['sysop_chercher_x']) && $_POST['sysop_ban'])
{
  // Assainissement du postdata
  $ban_chercher = postdata($_POST['sysop_ban']);

  // On va chercher une liste de tous les membres contenant la chaine de caractères
  $qpchercher = query(" SELECT id, pseudonyme, banni_date FROM membres WHERE pseudonyme LIKE '%$ban_chercher%' ORDER BY pseudonyme ASC ");

  // S'il n'y a qu'un seul résultat on redirige
  if(mysqli_num_rows($qpchercher) == 1)
  {
    $dpchercher = mysqli_fetch_array($qpchercher);
    header('Location: '.$chemin.'pages/sysop/ban?id='.$dpchercher['id']);
  }

  // Sinon on prépare ça pour l'affichage
  for($npchercher = 0 ; $dpchercher = mysqli_fetch_array($qpchercher) ; $npchercher++)
  {
    $pchercher_id[$npchercher]      = $dpchercher['id'];
    $pchercher_pseudo[$npchercher]  = $dpchercher['pseudonyme'];
    $pchercher_banni[$npchercher]   = ($dpchercher['banni_date']) ? 'Débannir' : 'Bannir' ;
    $pchercher_css[$npchercher]     = ($npchercher%2) ? ' nobleme_background' : '' ;
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Bannir un utilisateur

if(isset($_POST['sysop_bannir_x']) && $_POST['sysop_raison'] != '' && $idban != 1)
{
  // On assainit le postdata
  $sysop_duree  = postdata($_POST['sysop_duree']);
  $sysop_raison = postdata($_POST['sysop_raison']);

  // On envoie le ban (rip)
  $ban_datefin = (time() + $sysop_duree*86400);
  query(" UPDATE membres SET banni_date = '$ban_datefin' , banni_raison = '$sysop_raison' WHERE membres.id = '$idban' ");

  // Notification au banni pour qu'il sache qu'il a été banni si jamais il se connecte pas pendant le ban
  $sysopm_contenu  = "[b]Vous avez été temporairement banni de NoBleme[/b]\r\n\r\n";
  $sysopm_contenu .= "Vous avez été banni du ".datefr(date("Y-m-d",time()))." à ".date("H:i",time());
  $sysopm_contenu .= " au ".datefr(date("Y-m-d",$ban_datefin))." à ".date("H:i",$ban_datefin)."\r\n";
  $sysopm_contenu .= "La raison pour laquelle vous avez été banni est la suivante : ".$_POST['sysop_raison']."\r\n\r\n";
  $sysopm_contenu .= "Dans le futur, assurez-vous de respecter le [url=".$chemin."pages/doc/coc]code de conduite[/url] de NoBleme.";
  envoyer_notif($idban , 'Vous avez été banni de NoBleme' , postdata($sysopm_contenu));

  // Activité récente
  $timestamp      = time();
  $membre_pseudo  = postdata(getpseudo($idban));
  $log_finban     = $sysop_duree;
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'      ,
                      log_moderation  = 0                 ,
                      FKmembres       = '$idban'          ,
                      pseudonyme      = '$membre_pseudo'  ,
                      action_type     = 'ban'             ,
                      action_id       = '$log_finban'     ");

  ircbot($chemin,$membre_pseudo." vient de se faire bannir de NoBleme jusqu'au ".jourfr(date("Y-m-d",$ban_datefin))." ! (Raison : ".$_POST['sysop_raison'].") - http://nobleme.com/pages/nobleme/pilori","#nobleme");

  // Log de modération
  $timestamp      = time();
  $membre_pseudo  = postdata(getpseudo($idban));
  $log_finban     = $sysop_duree;
  $admin_id       = $_SESSION['user'];
  $admin_pseudo   = postdata(getpseudo());
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'      ,
                      log_moderation  = 1                 ,
                      FKmembres       = '$idban'          ,
                      pseudonyme      = '$membre_pseudo'  ,
                      action_type     = 'ban'             ,
                      action_id       = '$log_finban'     ,
                      parent_id       = '$admin_id'       ,
                      parent_titre    = '$admin_pseudo'   ,
                      justification   = '$sysop_raison'   ");

  // Puis on redirige vers le profil du banni
  header('Location: '.$chemin.'pages/user/user?id='.$idban);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Débannir un utilisateur

if(isset($_POST['sysop_debannir_x']) && $_POST['sysop_raison'] != '')
{
  // On assainit le postdata
  $sysop_raison = postdata($_POST['sysop_raison']);

  // On retire le ban (yay)
  query(" UPDATE membres SET banni_date = '0' , banni_raison = '' WHERE membres.id = '$idban' ");

  // Activité récente
  $timestamp      = time();
  $membre_pseudo  = postdata(getpseudo($idban));
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'      ,
                      log_moderation  = 0                 ,
                      FKmembres       = '$idban'          ,
                      pseudonyme      = '$membre_pseudo'  ,
                      action_type     = 'deban'           ");

  ircbot($chemin,$membre_pseudo." vient de se débannir de NoBleme ! (Raison : ".$_POST['sysop_raison'].")","#nobleme");

  // Log de modération
  $timestamp      = time();
  $membre_pseudo  = postdata(getpseudo($idban));
  $admin_id       = $_SESSION['user'];
  $admin_pseudo   = postdata(getpseudo());
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'      ,
                      log_moderation  = 1                 ,
                      FKmembres       = '$idban'          ,
                      pseudonyme      = '$membre_pseudo'  ,
                      action_type     = 'deban'           ,
                      parent_id       = '$admin_id'       ,
                      parent_titre    = '$admin_pseudo'   ,
                      justification   = '$sysop_raison'   ");

  // Puis on redirige vers le profil du débanni
  header('Location: '.$chemin.'pages/user/user?id='.$idban);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On a besoin des infos sur le ban
if(isset($_GET['id']))
{
  $qprofilban   = mysqli_fetch_array(query(" SELECT id, pseudonyme, banni_date, banni_raison FROM membres WHERE id = '$idban' "));
  $pban_id      = $qprofilban['id'];
  $pban_pseudo  = destroy_html($qprofilban['pseudonyme']);
  $pban_date    = $qprofilban['banni_date'];
  $pban_raison  = bbcode(destroy_html($qprofilban['banni_raison']));
}




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

    <div class="body_main smallsize">
      <span class="titre">Bannir un utilisateur</span><br>
      <br>
      Cet outil sert à bannir les utilisateurs qui ne suivent pas les <a href="<?=$chemin?>pages/doc/eula">règles</a> de NoBleme.<br>
      <br>
      Lorsque vous banissez un utilisateur, une entrée apparaitra dans le <a href="<?=$chemin?>pages/nobleme/activite?mod">log de modération</a>, l'utilisateur recevra une notification l'informant de son ban, et il apparaitra dans le <a href="<?=$chemin?>pages/nobleme/pilori">pilori des bannis</a>.
    </div>

    <?php if(!isset($_GET['id'])) { ?>

    <div class="body_main smallsize align_center" id="resultats">
      <span class="gras">Rechercher le pseudonyme de l'utilisateur à bannir :</span><br>
      (Vous pouvez rentrer seulement une partie du pseudonyme, la magie de NoBleme fera le reste)<br>
      <br>
      <form name="sysop_ban_chercher" method="post" action="ban#resultats">
        <input class="indiv" name="sysop_ban"><br>
        <input type="image" src="<?=$chemin?>img/boutons/chercher.png" alt="Chercher" name="sysop_chercher">
      </form>
    </div>

    <?php if(isset($_POST['sysop_chercher_x']) && $_POST['sysop_ban']) { ?>

    <div class="body_main smallsize">
      <table class="cadre_gris indiv">
        <tr>
          <td colspan="2" class="cadre_gris_titre moinsgros">
            RÉSULTATS DE LA RECHERCHE
          </td>
        </tr>
        <?php if($npchercher) { ?>
        <tr>
          <td class="cadre_gris_sous_titre">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre">
            Action
          </td>
        </tr>
        <?php for($i=0;$i<$npchercher;$i++) { ?>
        <tr>
          <td class="cadre_gris spaced align_center<?=$pchercher_css[$i]?>">
            <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$pchercher_id[$i]?>"><?=$pchercher_pseudo[$i]?></a>
          </td>
          <td class="cadre_gris spaced align_center<?=$pchercher_css[$i]?>">
            <a class="dark blank" href="<?=$chemin?>pages/sysop/ban?id=<?=$pchercher_id[$i]?>"><?=$pchercher_banni[$i]?></a>
          </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
          <td colspan="3" class="align_center moinsgros gras cadre_gris_haut mise_a_jour texte_blanc">
            Aucun utilisateur trouvé, cherchez mieux
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

    <?php } ?>

    <?php } else { ?>

    <div class="body_main smallsize">
      <form name="sysop_bannir" method="post" action="ban?id=<?=$idban?>">

        <?php if($pban_id == 1) { ?>

        <div class="gros gras align_center">On bannit pas le patron :)</div>
        <div class="moinsgros align_center">Bien essayé, mais je suis pas si con que ça quand même</div>

        <?php } else if(!$pban_date) { ?>

        <span class="moinsgros gras alinea">Bannir <a class="dark blank" href="<?=$chemin?>pages/user/user?id=<?=$pban_id?>"><?=$pban_pseudo?></a> de NoBleme</span><br>
        <br>
        <br>
        <span class="moinsgros gras alinea">Durée du ban :</span><br>
        <select class="indiv gras" name="sysop_duree">
          <option value="1">Une journée (avertissement)</option>
          <option value="3">Trois jours (second avertissement)</option>
          <option value="7">Une semaine (punition sérieuse)</option>
          <option value="30">Un mois (situation très grave)</option>
          <option value="365">Une année (situation exceptionellement grave)</option>
          <option value="3652">Dix ans (punition maximale - permaban)</option>
        </select><br>
        <br>
        <span class="moinsgros gras alinea">Raison du ban (impératif) :</span><br>
        <input class="indiv" name="sysop_raison"><br>
        <br>
        <div class="align_center indiv">
          <input type="image" src="<?=$chemin?>img/boutons/bannir.png" alt="Bannir" name="sysop_bannir">
        </div>

        <?php } else { ?>

        <span class="moinsgros gras alinea">Débannir <a class="dark blank" href="<?=$chemin?>pages/user/user?id=<?=$pban_id?>"><?=$pban_pseudo?></a> de NoBleme</span><br>
        <br>
        Lorsque vous débanissez un utilisateur, il ne recevra pas de notification l'informant qu'il a été débanni.<br>
        Si vous désirez le lui faire savoir, envoyez-lui un message privé pour le tenir au courant.<br>
        <br>
        <span class="moinsgros gras alinea">Raison du déban (impératif) :</span><br>
        <input class="indiv" name="sysop_raison"><br>
        <br>
        <div class="align_center indiv">
          <input type="image" src="<?=$chemin?>img/boutons/debannir.png" alt="Déannir" name="sysop_debannir">
        </div>

        <?php } ?>

      </form>
    </div>

    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';