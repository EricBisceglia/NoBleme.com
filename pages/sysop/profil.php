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
$header_sidemenu  = 'profil';

// Titre et description
$page_titre = "Modifier un profil";
$page_desc  = "Administration - Modifier le profil public d'un utilisateur";

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
  $idprofil = postdata($_GET['id']);

  // Si c'est pas un nombre, dehors
  if(!is_numeric($_GET['id']))
    erreur('ID invalide');

  // Si l'utilisateur n'existe pas, dehors
  if(!mysqli_num_rows(query(" SELECT membres.id FROM membres WHERE membres.id = '$idprofil' ")))
    erreur("Impossible de modifier un utilisateur qui n'existe pas");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Chercher un utilisateur

if(isset($_POST['sysop_chercher_x']) && $_POST['sysop_profil'])
{
  // Assainissement du postdata
  $profil_chercher = postdata($_POST['sysop_profil']);

  // On va chercher une liste de tous les membres contenant la chaine de caractères
  $qpchercher = query(" SELECT id, pseudonyme FROM membres WHERE pseudonyme LIKE '%$profil_chercher%' ORDER BY pseudonyme ASC ");

  // S'il n'y a qu'un seul résultat on redirige
  if(mysqli_num_rows($qpchercher) == 1)
  {
    $dpchercher = mysqli_fetch_array($qpchercher);
    header('Location: '.$chemin.'pages/sysop/profil?id='.$dpchercher['id']);
  }

  // Sinon on prépare ça pour l'affichage
  for($npchercher = 0 ; $dpchercher = mysqli_fetch_array($qpchercher) ; $npchercher++)
  {
    $pchercher_id[$npchercher]      = $dpchercher['id'];
    $pchercher_pseudo[$npchercher]  = $dpchercher['pseudonyme'];
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier un profil

if(isset($_POST['sysop_modifier_x']))
{
  // On va chercher les données avant modification pour comparer si y'a changement
  $qprofiledit = mysqli_fetch_array(query(" SELECT region, metier, profil FROM membres WHERE membres.id = '$idprofil' "));

  // On commence par assainir le postdata
  $sysop_region = postdata($_POST['sysop_region']);
  $sysop_metier = postdata($_POST['sysop_metier']);
  $sysop_profil = postdata($_POST['sysop_texte']);
  $sysop_raison = postdata($_POST['sysop_raison']);

  // On effectue le changement
  query(" UPDATE membres SET region = '$sysop_region', metier = '$sysop_metier', profil = '$sysop_profil' WHERE membres.id = '$idprofil'");

  // On envoie un message à la personne concernée
  $sysopm_contenu    = "[b]L'administration du site a modifié votre [url=".$chemin."pages/user/user?id=".$idprofil."]profil public[/url][/b]\r\n\r\n";
  if($sysop_raison  != '')
    $sysopm_contenu .= "La raison spécifiée pour la modification est la suivante : ".$_POST['sysop_raison']."\r\n\r\n";
  $sysopm_contenu   .= "Dans le futur, assurez-vous que votre profil public respecte le [url=".$chemin."pages/doc/coc]code de conduite[/url] de NoBleme.";
  envoyer_notif($idprofil , 'Votre profil public a été modifié' , postdata($sysopm_contenu));

  // Log de modération
  $timestamp      = time();
  $membre_pseudo  = postdata(getpseudo($idprofil));
  $admin_id       = $_SESSION['user'];
  $admin_pseudo   = postdata(getpseudo());
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'      ,
                      log_moderation  = 1                 ,
                      FKmembres       = '$idprofil'       ,
                      pseudonyme      = '$membre_pseudo'  ,
                      action_type     = 'profil_edit'     ,
                      parent_id       = '$admin_id'       ,
                      parent_titre    = '$admin_pseudo'   ,
                      justification   = '$sysop_raison'   ");

  // Diff
  $id_diff      = mysqli_insert_id($db);
  if($_POST['sysop_region'] != $qprofiledit['region'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'              ,
                        titre_diff  = 'Ville / Région / Pays' ,
                        diff        = '".postdata(diff($qprofiledit['region'],$_POST['sysop_region'],1))."' ");
  if($_POST['sysop_metier'] != $qprofiledit['metier'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'            ,
                        titre_diff  = 'Métier / Occupation' ,
                        diff        = '".postdata(diff($qprofiledit['metier'],$_POST['sysop_metier'],1))."' ");
  if($_POST['sysop_texte'] != $qprofiledit['profil'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'        ,
                        titre_diff  = 'Texte de profil' ,
                        diff        = '".postdata(diff($qprofiledit['profil'],$_POST['sysop_texte'],1))."' ");

  // Bot IRC NoBleme
  ircbot($chemin,"http://nobleme.com/pages/nobleme/activite?mod : ".getpseudo()." a modifié le profil public de ".getpseudo($idprofil),"#sysop");

  // Puis on redirige vers le profil modifié
  header('Location: '.$chemin.'pages/user/user?id='.$idprofil.'#profil_haut');
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On a besoin des infos du profil pour pouvoir les éditer
if(isset($_GET['id']))
{
  $qprofil        = mysqli_fetch_array(query(" SELECT region, metier, profil FROM membres WHERE membres.id = '$idprofil' "));
  $profil_metier  = destroy_html($qprofil['metier']);
  $profil_region  = destroy_html($qprofil['region']);
  $profil_texte   = destroy_html($qprofil['profil']);
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
      <span class="titre">Modifier un profil public</span><br>
      <br>
      Cet outil n'est pas fait pour troller ou s'amuser.<br>
      Il sert <span class="gras">uniquement</span> à retirer des profils publics le contenu brisant les règles de NoBleme.<br>
      <br>
      Les modifications que vous faites apparaitront en détail dans le <a href="<?=$chemin?>pages/nobleme/activite?mod">log de modération</a>, et les membres dont le profil public se fait modifier auront une notification les informant de la modification.
    </div>

    <?php if(!isset($_GET['id'])) { ?>

    <div class="body_main smallsize align_center" id="resultats">
      <span class="gras">Rechercher le pseudonyme de l'utilisateur à modifier :</span><br>
      (Vous pouvez rentrer seulement une partie du pseudonyme, la magie de NoBleme fera le reste)<br>
      <br>
      <form name="sysop_profil_chercher" method="post" action="profil#resultats">
        <input class="indiv" name="sysop_profil"><br>
        <input type="image" src="<?=$chemin?>img/boutons/chercher.png" alt="Chercher" name="sysop_chercher">
      </form>
    </div>

    <?php if(isset($_POST['sysop_chercher_x']) && $_POST['sysop_profil']) { ?>

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
              <a class="dark blank" href="<?=$chemin?>pages/sysop/profil?id=<?=$pchercher_id[$i]?>">Modifier le profil public</a>
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

    <?php } else { ?>

    <div class="body_main smallsize">
      <form name="sysop_editer_profil" method="post" action="profil?id=<?=$idprofil?>">
        <span class="gras alinea">Ville / Région / Pays :</span><br>
        <input class="indiv" name="sysop_region" value="<?=$profil_region?>" maxlength="35"><br>
        <br>
        <span class="gras alinea">Métier / Occupation :</span><br>
        <input class="indiv" name="sysop_metier" value="<?=$profil_metier?>" maxlength="35"><br>
        <br>
        <span class="gras alinea">Profil personnalisé :</span><br>
        <textarea class="indiv" rows="15" name="sysop_texte"><?=$profil_texte?></textarea><br>
        <br>
        <span class="moinsgros gras alinea">Raison de la modification (impératif) :</span><br>
        <input class="indiv" name="sysop_raison"><br>
        <br>
        <div class="align_center indiv">
          <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="Modifier" name="sysop_modifier">
        </div>
      </form>
    </div>

    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';