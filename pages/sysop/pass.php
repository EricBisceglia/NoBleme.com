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
$header_sidemenu  = 'pass';

// Titre et description
$page_titre = "Modifier un mot de passe";
$page_desc  = "Administration - Modifier le mot de passe d'un utilisateur";

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
  $idpass = postdata($_GET['id']);

  // Si c'est pas un nombre, dehors
  if(!is_numeric($_GET['id']))
    erreur('ID invalide');

  // Si l'utilisateur n'existe pas, dehors
  if(!mysqli_num_rows(query(" SELECT membres.id FROM membres WHERE membres.id = '$idpass' ")))
    erreur("Impossible de modifier un utilisateur qui n'existe pas");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Chercher un utilisateur

if(isset($_POST['sysop_chercher_x']) && $_POST['sysop_pass'])
{
  // Assainissement du postdata
  $pass_chercher = postdata($_POST['sysop_pass']);

  // On va chercher une liste de tous les membres contenant la chaine de caractères
  $qpchercher = query(" SELECT id, pseudonyme FROM membres WHERE pseudonyme LIKE '%$pass_chercher%' ORDER BY pseudonyme ASC ");

  // S'il n'y a qu'un seul résultat on redirige
  if(mysqli_num_rows($qpchercher) == 1)
  {
    $dpchercher = mysqli_fetch_array($qpchercher);
    header('Location: '.$chemin.'pages/sysop/pass?id='.$dpchercher['id']);
  }

  // Sinon on prépare ça pour l'affichage
  for($npchercher = 0 ; $dpchercher = mysqli_fetch_array($qpchercher) ; $npchercher++)
  {
    $pchercher_id[$npchercher]      = $dpchercher['id'];
    $pchercher_pseudo[$npchercher]  = $dpchercher['pseudonyme'];
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier un mot de passe

if(isset($_POST['sysop_modifier_x']) && $_POST['sysop_pass'])
{
  // Assainissement du postdata et salage du mot de passe
  $new_pass = postdata(salage($_POST['sysop_pass']));

  // Mise à jour du mot de passe
  query(" UPDATE membres SET membres.pass = '$new_pass' WHERE membres.id = '$idpass' ");

  // Log de modération
  $timestamp      = time();
  $membre_pseudo  = postdata(getpseudo($idpass));
  $admin_id       = $_SESSION['user'];
  $admin_pseudo   = postdata(getpseudo());
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'      ,
                      log_moderation  = 1                 ,
                      FKmembres       = '$idpass'         ,
                      pseudonyme      = '$membre_pseudo'  ,
                      action_type     = 'editpass'        ,
                      parent_id       = '$admin_id'       ,
                      parent_titre    = '$admin_pseudo'   ");

  // Bot IRC NoBleme
  ircbot($chemin,"http://nobleme.com/pages/nobleme/activite?mod : ".getpseudo()." a modifié le mot de passe de ".getpseudo($idpass),"#sysop");

  // Redirection vers une page de confirmation
  header('Location: '.$chemin.'pages/sysop/pass?id='.$idpass.'&ok');
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
      <span class="titre">Modifier un mot de passe</span><br>
      <br>
      Cet outil n'est pas fait pour troller ou s'amuser.<br>
      Il sert <span class="gras">uniquement</span> à aider un utilisateur ayant perdu son mot de passe à récupérer son compte.<br>
      Une entrée apparaitra dans le <a href="<?=$chemin?>pages/nobleme/activite?mod">log de modération</a> informant les autres administrateurs de votre action.
    </div>

    <?php if(!isset($_GET['id'])) { ?>

    <div class="body_main smallsize align_center" id="resultats">
      <span class="gras">Rechercher le pseudonyme de l'utilisateur dont vous souhaitez modifier le mot de passe :</span><br>
      (Vous pouvez rentrer seulement une partie du pseudonyme, la magie de NoBleme fera le reste)<br>
      <br>
      <form name="sysop_pass_chercher" method="post" action="pass#resultats">
        <input class="indiv" name="sysop_pass"><br>
        <input type="image" src="<?=$chemin?>img/boutons/chercher.png" alt="Chercher" name="sysop_chercher">
      </form>
    </div>

    <?php if(isset($_POST['sysop_chercher_x']) && $_POST['sysop_pass']) { ?>

    <div class="body_main smallsize">
      <table class="cadre_gris indiv">
        <thead>
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
        </thead>
        <tbody class="cadre_gris_altc">
          <?php for($i=0;$i<$npchercher;$i++) { ?>
          <tr>
            <td class="cadre_gris spaced align_center">
              <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$pchercher_id[$i]?>"><?=$pchercher_pseudo[$i]?></a>
            </td>
            <td class="cadre_gris spaced align_center">
              <a class="dark blank" href="<?=$chemin?>pages/sysop/pass?id=<?=$pchercher_id[$i]?>">Modifier le mot de passe</a>
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
        </tbody>
      </table>
    </div>

    <?php } ?>

    <?php } else if(!isset($_GET['ok'])) { ?>

    <div class="body_main smallsize">
      <form name="sysop_editer_pass" method="post" action="pass?id=<?=$idpass?>">
        <span class="gras alinea">Nouveau mot de passe de <?=getpseudo($idpass)?> :</span><br>
        <input type="password" class="indiv" name="sysop_pass" value="" maxlength="35"><br>
        <br>
        <div class="align_center indiv">
          <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="Modifier" name="sysop_modifier">
        </div>
      </form>
    </div>

    <?php } else { ?>

    <div class="body_main smallsize">
      <div class="indiv gros gras align_center texte_erreur">Le mot de passe de <?=getpseudo($idpass)?> a bien été changé</div>
    </div>

    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';