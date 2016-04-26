<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Profil de ";
$page_desc  = "Profil public du membre de NoBleme ";

// Identification
$page_nom = "user";

// CSS & JS
$css = array('user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si pas d'userid, dehors
if(!isset($_GET['id']) && !isset($_GET['pseudo']))
  erreur('ID utilisateur invalide');

// On nettoie
$getid      = (isset($_GET['id'])) ? postdata($_GET['id']) : '';
$getpseudo  = (isset($_GET['pseudo'])) ? postdata($_GET['pseudo']) : '';

// Si getid, on check s'il existe puis on va chercher userid et userpseudo
if(is_numeric($getid))
{
  // Si c'est un id numérique
  if(!mysqli_num_rows(query(" SELECT id FROM membres WHERE id = '$getid' ")))
    erreur('ID utilisateur inexistant');
  $userid     = $getid;
  $userpseudo = getpseudo($getid);
}
else
{
  // Si c'est un pseudonyme
  $querynick = query(" SELECT id FROM membres WHERE pseudonyme LIKE '$getpseudo' ");
  if(!mysqli_num_rows($querynick))
    erreur('Pseudonyme inexistant');
  $querynick  = mysqli_fetch_array($querynick);
  $userid     = $querynick['id'];
  $userpseudo = $getpseudo;
}

// Et on complète les infos d'indentification de la page
$page_titre .= $userpseudo;
$page_desc  .= $userpseudo;
$page_id     = $userid;

// S'il est banni, on révoque le ban
$banquery = mysqli_fetch_array(query(" SELECT membres.banni_date FROM membres WHERE membres.id = '$userid' "));
if($banquery["banni_date"] < time())
  query(" UPDATE membres SET membres.banni_date = '0' , membres.banni_raison  = '' WHERE membres.id = '$userid' ");

// Maintenant on peut aller chercher les infos qu'on va afficher sur la page
$datenow = date("Y-m-d");
$qprofil = query("  SELECT  membres.admin           AS 'admin'        ,
                            membres.sysop           AS 'sysop'        ,
                            membres.moderateur      AS 'moderateur'   ,
                            membres.date_creation   AS 'creation'     ,
                            membres.derniere_visite AS 'visite'       ,
                            membres.banni_date      AS 'ban_date'     ,
                            membres.banni_raison    AS 'ban_raison'   ,
                            membres.sexe            AS 'sexe'         ,
                            membres.anniversaire    AS 'anniversaire' ,
                            membres.region          AS 'region'       ,
                            membres.metier          AS 'metier'       ,
                            membres.profil          AS 'custom'       ,
                   (SELECT COUNT(*) FROM irl_participants, irl  WHERE irl_participants.FKmembres    = '$userid'
                                                                AND   irl_participants.confirme     = 1
                                                                AND   irl_participants.FKirl        = irl.id
                                                                AND   irl.date                      < '$datenow') AS 'irls'          ,
                   (SELECT COUNT(*) FROM devblog_commentaire    WHERE devblog_commentaire.FKmembres = '$userid')  AS 'devblog'       ,
                   (SELECT COUNT(*) FROM todo                   WHERE todo.FKmembres                = '$userid')  AS 'tickets'       ,
                   (SELECT COUNT(*) FROM todo_commentaire       WHERE todo_commentaire.FKmembres    = '$userid')  AS 'tickets_comm'
                    FROM    membres
                    WHERE   membres.id = '$userid' ");
while($dprofil = mysqli_fetch_array($qprofil))
{
  $p_admin            = $dprofil['admin'];
  $p_sysop            = $dprofil['sysop'];
  $p_moderateur       = $dprofil['moderateur'];
  $p_creation         = 'Le <span class="gras">'.jourfr(date('Y-m-d',$dprofil['creation'])).'</span> à '.date('H:i',$dprofil['creation']);
  $p_creation        .= ' ('.strtolower(ilya($dprofil['creation'],1)).')';
  if($dprofil['visite'])
  {
    $p_visite         = 'Le <span class="gras">'.jourfr(date('Y-m-d',$dprofil['visite'])).'</span> à '.date('H:i',$dprofil['visite']);
    $p_visite        .= ' ('.strtolower(ilya($dprofil['visite'],1)).')';
  }
  else
    $p_visite = 0;
  $p_ban              = ($dprofil['ban_date']) ? 1 : 0;
  $p_ban_date         = jourfr(date("Y-m-d",$dprofil['ban_date']));
  $p_ban_raison       = destroy_html($dprofil['ban_raison']);
  $p_sexe             = ($dprofil['sexe']) ? '<span class="gras">'.substr($dprofil['sexe'],0,1).'</span>'.substr($dprofil['sexe'],1) : 0;
  if(substr($dprofil['anniversaire'],0,4) > '0000' && substr($dprofil['anniversaire'],5,2) != '00' && substr($dprofil['anniversaire'],8,2) != '00')
  {
    $p_anniversaire   = '<span class="gras">'.floor((strtotime(date('Y-m-d'))-strtotime($dprofil['anniversaire']))/31556926).'</span> ans / Anniversaire le ';
    $p_anniversaire  .= substr(jourfr(date('Y').'-'.substr($dprofil['anniversaire'],5,5)),0,-5);
  }
  else
    $p_anniversaire   = 0;
  $p_region           = destroy_html($dprofil['region']);
  $p_metier           = destroy_html($dprofil['metier']);
  $p_irls             = $dprofil['irls'];
  $p_devblog          = $dprofil['devblog'];
  $p_tickets          = $dprofil['tickets'];
  $p_tickets_comm     = $dprofil['tickets_comm'];
  $p_custom           = ($dprofil['custom']) ? nl2br_fixed(bbcode(destroy_html($dprofil['custom']))) : '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><div class="indiv align_center gras">'.$userpseudo.' n\'a pas personnalisé son profil</div>';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/profil.png" alt="PROFIL UTILISATEUR">
    </div>
    <br>

    <table class="indiv margin_auto userprofil_titre" id="profil_haut">
      <tr>
        <td colspan="3">
          <?php if(!$p_ban) { ?>
          <div class="body_main align_center">
            <span class="user_pseudo"><?=$userpseudo?></span><br>
            <?php if($p_admin) { ?>
            <span class="texte_mise_a_jour user_titre">Administrateur</span><br>
            <?php } else if($p_sysop) { ?>
            <a href="<?=$chemin?>pages/nobleme/admins"><span class="texte_sysop user_titre">Modérateur global</span></a><br>
            <?php } else if($p_moderateur) { ?>
            <a href="<?=$chemin?>pages/nobleme/admins"><span class="texte_vert user_titre">Modérateur</span></a><br>
            <?php } ?>
            Membre #<?=$page_id?>
          </div>
          <?php } else { ?>
          <div class="body_main align_center">
            <div class="indiv mise_a_jour texte_blanc">
              <br>
              <span class="user_pseudo"><?=$userpseudo?></span><br>
              Membre #<?=$page_id?><br>
              <br>
              <span class="moinsgros gras">Banni de NoBleme jusqu'au <?=$p_ban_date?></span><br>
              <span class="moinsgros gras">Raison du ban : <?=$p_ban_raison?></span><br>
              <br>
            </div>
          </div>
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td>
          <table class="indiv userprofil_gauche">
            <tr>
              <td>
                <div class="body_main userprofil_pm align_center">
                  <?php if(loggedin() && $userid != $_SESSION['user']) { ?>
                  <a href="<?=$chemin?>pages/user/pm?user=<?=$userid?>">
                    <img src="<?=$chemin?>img/boutons/profil_envoyer_pm.png" alt="Envoyer un message privé">
                  </a>
                  <?php } else { ?>
                  <a href="<?=$chemin?>pages/user/profil">
                    <img src="<?=$chemin?>img/boutons/profil_modifier_infos.png" alt="Modifier mon profil">
                  </a>
                  <?php } ?>
                </div>
                <div class="body_main userprofil_info align_center">
                  Création du compte :<br>
                  <?=$p_creation?>
                  <hr class="separateur_profil">
                  <?php if($p_visite) { ?>
                  Dernière visite :<br>
                  <?=$p_visite?>
                  <hr class="separateur_profil">
                  <?php } if($p_sexe) { ?>
                  Sexe :<br>
                  <?=$p_sexe?>
                  <hr class="separateur_profil">
                  <?php } if($p_anniversaire) { ?>
                  Âge actuel / Anniversaire :<br>
                  <?=$p_anniversaire?>
                  <hr class="separateur_profil">
                  <?php } if($p_region) { ?>
                  Ville / Région / Pays :<br>
                  <?=$p_region?>
                  <hr class="separateur_profil">
                  <?php } if($p_metier) { ?>
                  Métier / Occupation :<br>
                  <?=$p_metier?>
                  <hr class="separateur_profil">
                  <?php } if($p_irls) { ?>
                  <a href="<?=$chemin?>pages/nobleme/irls">IRLs NoBlemeuses</a> :<br>
                  Est venu <span class="gras"><?=$p_irls?></span> fois
                  <hr class="separateur_profil">
                  <?php } ?>
                  <?php if($p_devblog) { ?>
                  Commentaires postés sur des <a href="<?=$chemin?>pages/devblog/index">devblogs</a> :<br>
                  <span class="gras"><?=$p_devblog?></span>
                  <hr class="separateur_profil">
                  <?php } if($p_tickets) { ?>
                  <a href="<?=$chemin?>pages/todo/index">Tickets</a> ouverts :<br>
                  <span class="gras"><?=$p_tickets?></span>
                  <hr class="separateur_profil">
                  <?php } if($p_tickets_comm) { ?>
                  Commentaires postés sur des <a href="<?=$chemin?>pages/todo/index">tickets</a> <br>
                  <span class="gras"><?=$p_tickets_comm?></span>
                  <hr class="separateur_profil">
                  <?php } ?>
                </div>
              </td>
            </tr>
          </table>
        </td>
        <td class="userprofil_milieu">
          &nbsp;
        </td>
        <td>
          <table class="indiv userprofil_droite">
            <tr>
              <td>
                <div class="body_main userprofil_custom">
                  <?=$p_custom?>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <?php if(loggedin() && getsysop()) { ?>
      <tr>
        <td colspan="3">
          <div class="body_main align_center">
            <span class="moinsgros gras souligne">Outils administratifs</span><br>
            <a href="<?=$chemin?>pages/sysop/profil?id=<?=$userid?>">Modifier le profil public de <?=$userpseudo?></a><br>
            <?php if(!$p_ban) { ?>
            <a href="<?=$chemin?>pages/sysop/ban?id=<?=$userid?>">Bannir <?=$userpseudo?></a>
            <?php } else { ?>
            <a href="<?=$chemin?>pages/sysop/ban?id=<?=$userid?>">Débannir <?=$userpseudo?></a>
            <?php } ?>
          </div>
        </td>
      </tr>
      <?php } ?>
    </table>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';