<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Admin';
$header_sidemenu  = 'Permissions';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Changer les permissions";

// JS
$js = array('dynamique', 'admin/chercher_user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Changement de privilèges
if(isset($_POST['permissions_go']))
{
  // On nettoie le postdata
  $permissions_id     = postdata($_GET['id'], 'int', 0);
  $permissions_droits = postdata_vide('permissions_droits', 'string', '');

  // On vérifie que l'user existe, sinon on dégage
  $qtestdroits = mysqli_fetch_array(query("  SELECT  membres.id
                                          FROM    membres
                                          WHERE   membres.id = '$permissions_id' "));
  if(!$qtestdroits['id'])
    header("Location: ".$chemin."pages/admin/permissions");

  // On prépare les infos pour la suite selon le type de promotion/démotion
  if(!$permissions_droits)
  {
    $permissions_sysop      = 0;
    $permissions_moderateur = NULL;
    $permissions_modfr      = '';
    $permissions_moden      = '';
    $permissions_action     = 'droits_delete';
    $permissions_ircbot_fr  = " ne fait plus partie de l'équipe administrative de NoBleme";
    $permissions_ircbot_en  = " is no longer part ofNoBleme's administrative team";
  }
  else if($permissions_droits == 'sysop')
  {
    $permissions_sysop      = 1;
    $permissions_moderateur = NULL;
    $permissions_modfr      = '';
    $permissions_moden      = '';
    $permissions_action     = 'droits_sysop';
    $permissions_ircbot_fr  = " rejoint l'équipe administrative de NoBleme en tant que sysop";
    $permissions_ircbot_en  = " has joined NoBleme's administrative team as a sysop";
  }
  else
  {
    $permissions_sysop      = 0;
    $permissions_moderateur = $permissions_droits;
    $permissions_action     = 'droits_mod';
    $permissions_ircbot_fr = " rejoint l'équipe administrative de NoBleme en tant que modérateur";
    $permissions_ircbot_en = " has joined NoBleme's administrative team as a moderator";
    if($permissions_droits == 'irl')
    {
      $permissions_modfr      = 'Rencontres IRL';
      $permissions_moden      = 'Real life meetups';
    }
    else if($permissions_droits == 'forum')
    {
      $permissions_modfr      = 'Forum';
      $permissions_moden      = 'Forum';
    }
  }

  // On change les permissions
  query(" UPDATE  membres
          SET     sysop                     = '$permissions_sysop'      ,
                  moderateur                = '$permissions_moderateur' ,
                  moderateur_description_fr = '$permissions_modfr'      ,
                  moderateur_description_en = '$permissions_moden'
          WHERE   membres.id                = '$permissions_id' ");

  // On crée un log dans l'activité récente et dans le log de modération
  $permissions_pseudo = postdata(getpseudo($permissions_id), 'string');
  activite_nouveau($permissions_action, 0, 0, $permissions_pseudo);
  activite_nouveau($permissions_action, 1, 0, $permissions_pseudo);

  // On notifie IRC
  ircbot($chemin, getpseudo($permissions_id).$permissions_ircbot_fr." - ".$GLOBALS['url_site']."pages/nobleme/admins", "#nobleme");
  ircbot($chemin, getpseudo($permissions_id).$permissions_ircbot_en." - ".$GLOBALS['url_site']."pages/nobleme/admins?english", "#english");

  // Et on redirige vers le profil de l'user
  header("Location: ".$chemin."pages/user/user?id=".$permissions_id);
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a choisi l'user à modifier, on prépare ses infos
if(isset($_GET['id']))
{
  // On commence par récupérer l'ID
  $permissions_id = postdata($_GET['id'], 'int', 0);

  // On va chercher les données liées à l'user
  $qdroitsuser = mysqli_fetch_array(query("  SELECT  membres.pseudonyme  ,
                                                  membres.admin       ,
                                                  membres.sysop       ,
                                                  membres.moderateur
                                          FROM    membres
                                          WHERE   membres.id = '$permissions_id' "));
  $permissions_pseudo = predata($qdroitsuser['pseudonyme']);
  $permissions_admin  = $qdroitsuser['admin'];

  // Si l'user existe pas, on dégage
  if(!$permissions_pseudo)
    $_GET['id'] = 0;

  // On doit aussi préparer le menu déroulant
  $selected             = (!$qdroitsuser['sysop'] && !$qdroitsuser['moderateur']) ? ' selected' : '';
  $permissions_select   = '<option value="">Aucune permission</option>';
  $selected             = ($qdroitsuser['moderateur'] == 'irl') ? ' selected' : '';
  $permissions_select  .= '<option value="irl" class="vert_background texte_grisfonce"'.$selected.'>Modérateur: Rencontres IRL</option>';
  $selected             = ($qdroitsuser['moderateur'] == 'forum') ? ' selected' : '';
  $permissions_select  .= '<option value="forum" class="vert_background texte_grisfonce"'.$selected.'>Modérateur: Forum</option>';
  $selected             = ($qdroitsuser['sysop']) ? ' selected' : '';
  $permissions_select  .= '<option value="sysop" class="neutre texte_blanc"'.$selected.'>Sysop</option>';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Changer les permissions</h1>

        <br>
        <br>

        <?php if(isset($_GET['id']) && $permissions_pseudo && $permissions_admin) { ?>

        <h5>On ne touche pas aux permissions des administrateurs via cet outil.</h5>

        <?php } else if(isset($_GET['id']) && $permissions_pseudo) { ?>

        <h5>Altérer les privilèges de <a href="<?=$chemin?>pages/user/user?id=<?=$permissions_id?>"><?=$permissions_pseudo?></a></h5>
        <br>

        <form method="POST">
          <fieldset>
            <label for="permissions_droits">Nouveaux privilèges</label>
            <select id="permissions_droits" name="permissions_droits" class="indiv">
              <?=$permissions_select?>
            </select><br>
            <br>
            <input value="Changer les permissions de <?=$permissions_pseudo?>" type="submit" name="permissions_go">
          </fieldset>
        </form>

        <?php } else { ?>

        <fieldset>
          <label for="admin_pseudo_user">Entrez une partie du pseudonyme de l'utilisateur dont les privilèges seront modifiés :</label>
          <input  id="admin_pseudo_user" name="admin_pseudo_user" class="indiv" type="text" onkeyup="admin_chercher_user('<?=$chemin?>')";><br>
        </fieldset>

      </div>

      <div class="minitexte" id="admin_liste_users">
        &nbsp;

      <?php } ?>

    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';