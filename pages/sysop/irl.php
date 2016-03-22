<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
sysoponly('irl');

// Titre et description
$page_titre = "Ajouter une IRL";

// Identification
$page_nom = "sysop";

// CSS & JS
$css = array('sysop');
$js  = array('calendrier');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On envoie chier les mauvaises requêtes

// Dehors si on est sur la page sans raison
if(!isset($_GET['add']) && !isset($_GET['edit']) && !isset($_GET['delete']))
  erreur('Aucune action spécifiée');

// Delete est pas pour les sysop
if(isset($_GET['delete']))
  adminonly();

// Si on edit ou delete une IRL non existante
if(isset($_GET['edit']) || isset($_GET['delete']))
{
  // On en profite pour changer le titre
  if(isset($_GET['edit']))
  {
    $page_titre = "Modifier une IRL";
    $id_irl = postdata($_GET['edit']);
  }
  else
  {
    $page_titre = "Supprimer une IRL";
    $id_irl = postdata($_GET['delete']);
  }

  // Dehors si c'est pas un ID
  if(!is_numeric($id_irl))
    erreur("ID d'IRL invalide");

  // Dehors si l'IRL existe pas
  if(!mysqli_num_rows(query("SELECT irl.id FROM irl WHERE irl.id = '$id_irl'")))
    erreur("IRL inexistante");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'une nouvelle irl

if(isset($_POST['irl_add_x']))
{
  // Traitement du postdata
  $add_date     = postdata($_POST['irl_date']);
  $add_lieu     = postdata($_POST['irl_lieu']);
  $add_raison   = postdata($_POST['irl_raison']);
  $add_pourquoi = postdata($_POST['irl_pourquoi']);
  $add_ou       = postdata($_POST['irl_ou']);
  $add_quand    = postdata($_POST['irl_quand']);
  $add_quoi     = postdata($_POST['irl_quoi']);

  // Ajout de la nouvelle IRL
  query(" INSERT INTO irl
          SET         irl.date              = '$add_date'     ,
                      irl.lieu              = '$add_lieu'     ,
                      irl.raison            = '$add_raison'   ,
                      irl.details_pourquoi  = '$add_pourquoi' ,
                      irl.details_ou        = '$add_ou'       ,
                      irl.details_quand     = '$add_quand'    ,
                      irl.details_quoi      = '$add_quoi'     ");

  // Activité récente
  $timestamp  = time();
  $new_irl    = mysqli_insert_id($db);
  $nom_irl    = datefr($add_date);
  query(" INSERT INTO activite
          SET         timestamp     = '$timestamp'  ,
                      action_type   = 'new_irl'     ,
                      action_id     = '$new_irl'    ,
                      action_titre  = '$nom_irl'    ");

  // Log de modération
  $sysop_id     = $_SESSION['user'];
  $sysop_pseudo = getpseudo();
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'    ,
                      log_moderation  = 1               ,
                      FKmembres       = '$sysop_id'     ,
                      pseudonyme      = '$sysop_pseudo' ,
                      action_type     = 'new_irl'       ,
                      action_id       = '$new_irl'      ,
                      action_titre    = '$nom_irl'      ");

  // Redirection vers la nouvelle IRL
  header("Location: ".$chemin."pages/nobleme/irl?irl=".$new_irl);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'une irl

if(isset($_POST['irl_edit_x']))
{
  // Traitement du postdata
  $edit_date      = postdata($_POST['irl_date']);
  $edit_lieu      = postdata($_POST['irl_lieu']);
  $edit_raison    = postdata($_POST['irl_raison']);
  $edit_pourquoi  = postdata($_POST['irl_pourquoi']);
  $edit_ou        = postdata($_POST['irl_ou']);
  $edit_quand     = postdata($_POST['irl_quand']);
  $edit_quoi      = postdata($_POST['irl_quoi']);

  // On récupère des infos sur l'irl pour le log de modération et le diff
  $qirl = query(" SELECT  irl.date              ,
                          irl.lieu              ,
                          irl.raison            ,
                          irl.details_pourquoi  ,
                          irl.details_ou        ,
                          irl.details_quand     ,
                          irl.details_quoi
                  FROM    irl
                  WHERE   irl.id = '$id_irl'    ");
  $dirl = mysqli_fetch_array($qirl);

  // Mise à jour de l'irl
  query(" UPDATE  irl
          SET     irl.date              = '$edit_date'      ,
                  irl.lieu              = '$edit_lieu'      ,
                  irl.raison            = '$edit_raison'    ,
                  irl.details_pourquoi  = '$edit_pourquoi'  ,
                  irl.details_ou        = '$edit_ou'        ,
                  irl.details_quand     = '$edit_quand'     ,
                  irl.details_quoi      = '$edit_quoi'
          WHERE   irl.id                = '$id_irl'         ");

  // Log de modération
  $timestamp    = time();
  $sysop_id     = $_SESSION['user'];
  $sysop_pseudo = getpseudo();
  $nom_irl      = datefr($dirl['date']);
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'    ,
                      log_moderation  = 1               ,
                      FKmembres       = '$sysop_id'     ,
                      pseudonyme      = '$sysop_pseudo' ,
                      action_type     = 'edit_irl'      ,
                      action_id       = '$id_irl'       ,
                      action_titre    = '$nom_irl'      ");
  // Diff
  $id_diff = mysqli_insert_id($db);
  if(stripslashes($edit_date) != $dirl['date'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'  ,
                        titre_diff  = 'Date'      ,
                        diff        = '".postdata(diff($dirl['date'],stripslashes($edit_date),1))."' ");
  if(stripslashes($edit_lieu) != $dirl['lieu'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'  ,
                        titre_diff  = 'Lieu'      ,
                        diff        = '".postdata(diff($dirl['lieu'],stripslashes($edit_lieu),1))."' ");
  if(stripslashes($edit_raison) != $dirl['raison'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'  ,
                        titre_diff  = 'Raison'    ,
                        diff        = '".postdata(diff($dirl['raison'],stripslashes($edit_raison),1))."' ");
  if(stripslashes($edit_pourquoi) != $dirl['details_pourquoi'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'  ,
                        titre_diff  = 'Pourquoi'  ,
                        diff        = '".postdata(diff($dirl['details_pourquoi'],stripslashes($edit_pourquoi),1))."' ");
  if(stripslashes($edit_ou) != $dirl['details_ou'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'  ,
                        titre_diff  = 'Où'        ,
                        diff        = '".postdata(diff($dirl['details_ou'],stripslashes($edit_ou),1))."' ");
  if(stripslashes($edit_quand) != $dirl['details_quand'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'  ,
                        titre_diff  = 'Quand'     ,
                        diff        = '".postdata(diff($dirl['details_quand'],stripslashes($edit_quand),1))."' ");
  if(stripslashes($edit_quoi) != $dirl['details_quoi'])
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id_diff'  ,
                        titre_diff  = 'Quoi'      ,
                        diff        = '".postdata(diff($dirl['details_quoi'],stripslashes($edit_quoi),1))."' ");

  // Redirection vers l'IRL
  header("Location: ".$chemin."pages/nobleme/irl?irl=".$id_irl);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fini d'éditer les participants d'une irl

if(isset($_POST['irl_edit_participants_x']))
{
  // Redirection vers l'IRL
  header("Location: ".$chemin."pages/nobleme/irl?irl=".$id_irl);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une irl

if(isset($_POST['irl_delete_x']))
{
  // On récupère des infos sur l'irl pour le log de modération et le diff
  $qirl = query(" SELECT  irl.date              ,
                          irl.lieu              ,
                          irl.raison            ,
                          irl.details_pourquoi  ,
                          irl.details_ou        ,
                          irl.details_quand     ,
                          irl.details_quoi
                  FROM    irl
                  WHERE   irl.id = '$id_irl'    ");
  $dirl = mysqli_fetch_array($qirl);

  // Ainsi que la liste des participants pour le log de modération et le diff
  $qparticipants = query("  SELECT      irl_participants.pseudonyme AS 'irlpseudo' ,
                                        membres.pseudonyme          AS 'pseudo'
                            FROM        irl_participants
                            LEFT JOIN   membres ON irl_participants.FKmembres = membres.id
                            WHERE       irl_participants.FKirl = '$id_irl' ");
  $liste_participants = '';
  while($dparticipants = mysqli_fetch_array($qparticipants))
  {
    $liste_participants .= ($dparticipants['pseudo'] != NULL) ? $dparticipants['pseudo'] : $dparticipants['irlpseudo'];
    $liste_participants .= ' - ';
  }
  $liste_participants = substr(postdata($liste_participants),0,-3);

  // Suppression de l'IRL
  query(" DELETE FROM irl               WHERE irl.id                  = '$id_irl' ");
  query(" DELETE FROM irl_participants  WHERE irl_participants.FKirl  = '$id_irl' ");
  query(" DELETE FROM activite          WHERE activite.action_id      = '$id_irl' AND activite.action_type LIKE '%_irl%' ");

  // Log de modération
  $timestamp    = time();
  $admin_id     = $_SESSION['user'];
  $admin_pseudo = getpseudo();
  $nom_irl      = datefr($dirl['date']);
  $delraison    = postdata($_POST['irl_delete_raison']);
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'    ,
                      log_moderation  = 1               ,
                      FKmembres       = '$admin_id'     ,
                      pseudonyme      = '$admin_pseudo' ,
                      action_type     = 'delete_irl'    ,
                      action_titre    = '$nom_irl'      ,
                      justification   = '$delraison'    ");

  // Diff
  $id_diff      = mysqli_insert_id($db);
  $irl_resume   = postdata("IRL du ".$nom_irl." à ".$dirl['lieu']." pour ".$dirl['raison']);
  $irl_pourquoi = postdata($dirl['details_pourquoi']);
  $irl_ou       = postdata($dirl['details_ou']);
  $irl_quand    = postdata($dirl['details_quand']);
  $irl_quoi     = postdata($dirl['details_quoi']);
  query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Résumé' , diff = '$irl_resume' ");
  query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Pourquoi' , diff = '$irl_pourquoi' ");
  query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Où' , diff = '$irl_ou' ");
  query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Quand' , diff = '$irl_quand' ");
  query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Quoi' , diff = '$irl_quoi' ");
  query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Participants' , diff = '$liste_participants' ");

  // Redirection vers la liste des IRLs
  header("Location: ".$chemin."pages/nobleme/irls");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un participant à une irl

if(isset($_POST['irlp_ajouter']) && postdata($_POST['irlp_pseudo']))
{
  // Traitement du postdata
  $addp_pseudo    = postdata(destroy_html($_POST['irlp_pseudo']));
  $addp_confirme  = postdata($_POST['irlp_confirme']);
  $addp_details   = postdata(destroy_html($_POST['irlp_details']));

  // On va fetch l'ID de l'user s'il existe
  $findp = mysqli_fetch_array(query(" SELECT membres.id, membres.pseudonyme FROM membres WHERE membres.pseudonyme LIKE '$addp_pseudo' "));
  $addp_membre      = ($findp['id']) ? $findp['id'] : 0;
  $addp_pseudonyme  = ($findp['id']) ? '' : $addp_pseudo;

  // On va check si l'user participe déjà à l'IRL
  if(!mysqli_num_rows(query(" SELECT id FROM irl_participants WHERE FKirl = '$id_irl' AND FKmembres = '$addp_membre' AND pseudonyme LIKE '$addp_pseudonyme' ")))
  {
    // Ajout du participant
    query(" INSERT INTO irl_participants
            SET         FKirl       = '$id_irl'           ,
                        FKmembres   = '$addp_membre'      ,
                        pseudonyme  = '$addp_pseudonyme'  ,
                        confirme    = '$addp_confirme'    ,
                        details     = '$addp_details'     ");

    // On récupère le nom de l'IRL
    $infosirl = mysqli_fetch_array(query(" SELECT date FROM irl WHERE irl.id = '$id_irl' "));
    $nom_irl  = datefr($infosirl['date']);

    // Activité récente
    $timestamp  = time();
    query(" INSERT INTO activite
            SET         timestamp     = '$timestamp'          ,
                        FKmembres     = '$addp_membre'        ,
                        pseudonyme    = '$addp_pseudo'        ,
                        action_type   = 'add_irl_participant' ,
                        action_id     = '$id_irl'             ,
                        action_titre  = '$nom_irl'            ");

    // Log de modération
    $sysop_id     = $_SESSION['user'];
    $sysop_pseudo = getpseudo();
    query(" INSERT INTO activite
            SET         timestamp       = '$timestamp'          ,
                        log_moderation  = 1                     ,
                        FKmembres       = '$addp_membre'        ,
                        pseudonyme      = '$addp_pseudo'        ,
                        action_type     = 'add_irl_participant' ,
                        action_id       = '$id_irl'             ,
                        action_titre    = '$nom_irl'            ,
                        parent_id       = '$sysop_id'           ,
                        parent_titre    = '$sysop_pseudo'       ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'un participant à une irl

if(isset($_POST['irlp_modifier']))
{
  $editp_id = postdata($_POST['irlp_actionid']);
  if(is_numeric($editp_id) && $editp_id > 0)
  {
    // On récupère des infos sur le participant pour le log de modération et le diff
    $deditpid = mysqli_fetch_array(query("  SELECT    irl_participants.id         AS 'irlp_id'        ,
                                                      irl_participants.FKmembres  AS 'irlp_user'      ,
                                                      irl_participants.pseudonyme AS 'irlp_pseudo'    ,
                                                      membres.pseudonyme          AS 'user_pseudo'    ,
                                                      irl_participants.confirme   AS 'irlp_confirme'  ,
                                                      irl_participants.details    AS 'irlp_details'   ,
                                                      irl.id                      AS 'irl_id'         ,
                                                      irl.date                    AS 'irl_date'
                                            FROM      irl_participants
                                            LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                                            LEFT JOIN irl     ON irl_participants.FKirl     = irl.id
                                            WHERE     irl_participants.id = '$editp_id' "));

    // On check si le participant existe
    if($deditpid['irlp_id'])
    {
      // On récupère le reste du postdata
      $editp_confirme = postdata($_POST['irlp_confirme'.$editp_id]);
      $editp_details  = postdata(destroy_html($_POST['irlp_details'.$editp_id]));

      // Modification du participant
      query(" UPDATE  irl_participants
              SET     FKirl       = '$id_irl'           ,
                      confirme    = '$editp_confirme'   ,
                      details     = '$editp_details'
              WHERE   id          = '$editp_id'         ");

      // Log de modération
      $timestamp    = time();
      $editp_membre = ($deditpid['irlp_user']) ? $deditpid['irlp_user'] : 0;
      $editp_nick   = postdata(($deditpid['user_pseudo']) ? $deditpid['user_pseudo'] : $deditpid['irlp_pseudo']);
      $editp_irlid  = $deditpid['irl_id'];
      $editp_irlnom = datefr($deditpid['irl_date']);
      $sysop_id     = $_SESSION['user'];
      $sysop_pseudo = getpseudo();
      query(" INSERT INTO activite
              SET         timestamp       = '$timestamp'            ,
                          log_moderation  = 1                       ,
                          FKmembres       = '$editp_membre'         ,
                          pseudonyme      = '$editp_nick'           ,
                          action_type     = 'edit_irl_participant'  ,
                          action_id       = '$editp_irlid'          ,
                          action_titre    = '$editp_irlnom'         ,
                          parent_id       = '$sysop_id'             ,
                          parent_titre    = '$sysop_pseudo'         ");

      // Diff
      $id_diff  = mysqli_insert_id($db);
      if(stripslashes($editp_confirme) != $deditpid['irlp_confirme'])
        query(" INSERT INTO activite_diff
                SET         FKactivite  = '$id_diff'  ,
                            titre_diff  = 'Confirmé'  ,
                            diff        = '".postdata(diff($deditpid['irlp_confirme'],stripslashes($editp_confirme),1))."' ");
      if(stripslashes($editp_details) != $deditpid['irlp_details'])
        query(" INSERT INTO activite_diff
                SET         FKactivite  = '$id_diff'  ,
                            titre_diff  = 'Détails'   ,
                            diff        = '".postdata(diff($deditpid['irlp_details'],stripslashes($editp_details),1))."' ");

    }
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un participant à une irl

if(isset($_POST['irlp_supprimer']))
{
  // On vérifie si le participant a bien été rentré
  $delp_id = postdata($_POST['irlp_actionid']);
  if(is_numeric($delp_id) && $delp_id > 0)
  {
    // On récupère des infos sur le participant pour le log de modération et le diff
    $ddelpid = mysqli_fetch_array(query(" SELECT    irl_participants.id         AS 'irlp_id'        ,
                                                    irl_participants.FKmembres  AS 'irlp_user'      ,
                                                    irl_participants.pseudonyme AS 'irlp_pseudo'    ,
                                                    membres.pseudonyme          AS 'user_pseudo'    ,
                                                    irl_participants.confirme   AS 'irlp_confirme'  ,
                                                    irl_participants.details    AS 'irlp_details'   ,
                                                    irl.id                      AS 'irl_id'         ,
                                                    irl.date                    AS 'irl_date'
                                          FROM      irl_participants
                                          LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                                          LEFT JOIN irl     ON irl_participants.FKirl     = irl.id
                                          WHERE     irl_participants.id = '$delp_id' "));

    // On check si le participant existe
    if($ddelpid['irlp_id'])
    {
      // Suppression du participant
      query(" DELETE FROM irl_participants  WHERE irl_participants.id = '$delp_id' ");

      // Activité récente
      $timestamp    = time();
      $delp_membre  = ($ddelpid['irlp_user']) ? $ddelpid['irlp_user'] : 0;
      $delp_pseudo  = postdata(($ddelpid['user_pseudo']) ? $ddelpid['user_pseudo'] : $ddelpid['irlp_pseudo']);
      $delp_irlid   = $ddelpid['irl_id'];
      $delp_irlnom  = datefr($ddelpid['irl_date']);
      query(" INSERT INTO activite
              SET         timestamp     = '$timestamp'          ,
                          FKmembres     = '$delp_membre'        ,
                          pseudonyme    = '$delp_pseudo'        ,
                          action_type   = 'del_irl_participant' ,
                          action_id     = '$delp_irlid'         ,
                          action_titre  = '$delp_irlnom'        ");

      // Log de modération
      $sysop_id     = $_SESSION['user'];
      $sysop_pseudo = getpseudo();
      query(" INSERT INTO activite
              SET         timestamp       = '$timestamp'          ,
                          log_moderation  = 1                     ,
                          FKmembres       = '$delp_membre'        ,
                          pseudonyme      = '$delp_pseudo'        ,
                          action_type     = 'del_irl_participant' ,
                          action_id       = '$delp_irlid'         ,
                          action_titre    = '$delp_irlnom'        ,
                          parent_id       = '$sysop_id'           ,
                          parent_titre    = '$sysop_pseudo'       ");

      // Diff
      $id_diff        = mysqli_insert_id($db);
      $delp_confirme  = ($ddelpid['irlp_confirme']) ? 'Oui' : 'Non';
      $delp_details   = postdata($ddelpid['irlp_details']);
      query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Confirmé' , diff = '$delp_confirme' ");
      query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , titre_diff = 'Détails'  , diff = '$delp_details' ");
    }
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si on edit ou delete, infos de l'irl

if(isset($id_irl))
{
  // On va chercher l'IRL
  $qirl = query(" SELECT    irl.id                AS 'irlid'        ,
                            irl.date              AS 'irldate'      ,
                            irl.lieu              AS 'irllieu'      ,
                            irl.raison            AS 'irlraison'    ,
                            irl.details_pourquoi  AS 'irlpourquoi'  ,
                            irl.details_ou        AS 'irlou'        ,
                            irl.details_quand     AS 'irlquand'     ,
                            irl.details_quoi      AS 'irlquoi'      ,
                  (SELECT count(irl_participants.id) FROM irl_participants WHERE irl_participants.FKirl = irl.id) AS 'irlparticipants'
                  FROM      irl
                  WHERE     irl.id = '$id_irl'
                  ORDER BY  irl.date DESC ");
  $dirl = mysqli_fetch_array($qirl);

  // Et on en récupère les données
  $irl_id           = $dirl['irlid'];
  $irl_date         = datefr($dirl['irldate']);
  $irl_date_form    = destroy_html($dirl['irldate']);
  $irl_lieu         = destroy_html($dirl['irllieu']);
  $irl_raison       = destroy_html($dirl['irlraison']);
  $irl_pourquoi     = destroy_html($dirl['irlpourquoi']);
  $irl_ou           = destroy_html($dirl['irlou']);
  $irl_quand        = destroy_html($dirl['irlquand']);
  $irl_quoi         = destroy_html($dirl['irlquoi']);
  $irl_participants = $dirl['irlparticipants'];

  // Si on edit, liste des participants
  if(isset($_GET['edit']))
  {
    // On va chercher les participants
    $qirlp = query("  SELECT    irl_participants.id         AS 'irlpid'   ,
                                irl_participants.pseudonyme AS 'fakenick' ,
                                membres.pseudonyme          AS 'truenick' ,
                                irl_participants.confirme                 ,
                                irl_participants.details
                      FROM      irl_participants
                      LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                      WHERE     irl_participants.FKirl = '$id_irl' ");
    for($nirlp = 0 ; $dirlp = mysqli_fetch_array($qirlp) ; $nirlp++)
    {
      // Et on prépare les données
      $irlp_id[$nirlp]        = $dirlp['irlpid'];
      $irlp_pseudo[$nirlp]    = ($dirlp['truenick'] != NULL) ? $dirlp['truenick'] : $dirlp['fakenick'];
      $irlp_confirme[$nirlp]  = $dirlp['confirme'];
      $irlp_details[$nirlp]   = destroy_html($dirlp['details']);
      $irlp_css[$nirlp]       = ($nirlp%2) ? 'blanc' : 'nobleme_background';
    }
  }
}
else
{
  // Si on edit pas, faut qua^nd même set les valeurs par défaut
  $irl_date_form    = '';
  $irl_lieu         = '';
  $irl_raison       = '';
  $irl_pourquoi     = '';
  $irl_ou           = '';
  $irl_quand        = '';
  $irl_quoi         = '';
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/sysop_irl.png" alt="Logo">
    </div>
    <br>
    <br>

    <?php if(isset($_GET['add'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Créer une nouvelle IRL</span><br>
      <br>
      Les IRLs crées via cette pages apparaitront immédiatement dans la <a href="<?=$chemin?>pages/nobleme/irls">liste des IRL</a>.<br>
      <br>
      Vous pouvez utiliser les <a href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> et des <a href="<?=$chemin?>pages/doc/emotes">émoticônes</a> dans tous les champs des "Infos détaillées".
    </div>
    <?php } else if(isset($_GET['edit'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Modifier une IRL</span><br>
      <br>
      Vous pouvez utiliser les <a href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> et des <a href="<?=$chemin?>pages/doc/emotes">émoticônes</a> dans tous les champs des "Infos détaillées".
    </div>
    <?php } ?>

    <?php if(!isset($_GET['delete'])) { ?>

    <br>

    <?php if(!isset($_GET['edit'])) { ?>
    <form name="irl" method="post" action="irl.php?add">
    <?php } else { ?>
    <form name="irl" method="post" action="irl.php?edit=<?=$id_irl?>">
    <?php } ?>

      <div class="body_main midsize">
        <span class="soustitre">Infos générales (liste des IRLs)</span><br>
        <br>
        <table class="indiv">

          <tr>
            <td class="gras align_right spaced">Date :</td>
            <script type="text/javascript">
              var cal1 = new CalendarPopup();
            </script>
            <td class="align_left"><input class="irldate" name="irl_date" id="anchor1" onClick="cal1.select(document.forms['irl'].irl_date,'anchor1','yyyy-MM-dd'); return false;" maxlength="10" value="<?=$irl_date_form?>">&nbsp;&nbsp;<span class="italique">Date au format YYYY-MM-DD, cliquer dans le champ pour ouvrir un calendrier</span></td>
          </tr>

          <tr>
            <td class="gras align_right spaced">Lieu :</td>
            <td class="align_left"><input class="irllieu" name="irl_lieu" maxlength="16" value="<?=$irl_lieu?>">&nbsp;&nbsp;<span class="italique">Maximum 16 caractères</span></td>
          </tr>

          <tr>
            <td class="gras align_right spaced">Raison :</td>
            <td class="align_left"><input class="irllieu" name="irl_raison" maxlength="40" value="<?=$irl_raison?>">&nbsp;&nbsp;<span class="italique">Maximum 40 caractères</span></td>
          </tr>


        </table>

        <br>
        <br>

        <span class="soustitre">Infos détaillées (page de l'IRL)</span><br>
        <br>
        <table class="indiv">

          <tr>
            <td class="gras align_right spaced">Pourquoi :</td>
            <td class="align_left"><textarea class="irldetails" name="irl_pourquoi" rows="1"><?=$irl_pourquoi?></textarea>
          </tr>

          <tr>
            <td class="gras align_right spaced">Où :</td>
            <td class="align_left"><textarea class="irldetails" name="irl_ou" rows="1"><?=$irl_ou?></textarea>
          </tr>

          <tr>
            <td class="gras align_right spaced">Quand :</td>
            <td class="align_left"><textarea class="irldetails" name="irl_quand" rows="1"><?=$irl_quand?></textarea>
          </tr>

          <tr>
            <td class="gras align_right spaced">Quoi :</td>
            <td class="align_left"><textarea class="irldetails" name="irl_quoi" rows="1"><?=$irl_quoi?></textarea>
          </tr>

          <tr>
            <?php if(isset($_GET['add'])) { ?>
            <td colspan="2" class="align_center"><br><input name="irl_add" type="image" src="<?=$chemin?>img/boutons/ajouter.png" alt="Ajouter"></td>
            <?php } else { ?>
            <td colspan="2" class="align_center"><br><input name="irl_edit" type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="Modifier"></td>
            <?php } ?>
          </tr>

        </table>
      </div>

    </form>

    <?php if(isset($_GET['edit'])) { ?>

    <br>

    <form name="irlp" method="post" action="#irlp">
      <input type="hidden" name="irlp_actionid" id="irlp_actionid" value="0">

      <div class="body_main midsize" id="irlp">

        <table class="indiv cadre_gris">

          <tr>
            <td class="cadre_gris_titre moinsgros" colspan="5">
              LISTE DES PARTICIPANTS: La première ligne du tableau sert à en ajouter
            </td>
          </tr>

          <tr>
          <td class="cadre_gris_sous_titre moinsgros">
            Pseudonyme
          </td>
          <td class="cadre_gris_sous_titre moinsgros confirme spaced">
            Confirmé
          </td>
          <td class="cadre_gris_sous_titre moinsgros">
            Détails (optionnel)
          </td>
          <td class="cadre_gris_sous_titre moinsgros" colspan="2">
            Actions
          </td>
        </tr>

        <tr>
          <td class="cadre_gris align_center">
            <input class="indiv discret align_center" name="irlp_pseudo" value="">
          </td>
          <td class="cadre_gris align_center">
            <select class="indiv discret align_center" name="irlp_confirme">
              <option value="0">Non</option>
              <option value="1">Oui</option>
            </select>
          </td>
          <td class="cadre_gris align_center">
            <input class="indiv discret align_center" name="irlp_details" value="">
          </td>
          <td class="cadre_gris align_center" colspan="2">
            <input type="submit" class="indiv discret align_center blanc" name="irlp_ajouter" value="Ajouter">
          </td>
        </tr>

          <?php for($i=0;$i<$nirlp;$i++) { ?>
          <tr>
            <td class="cadre_gris align_center <?=$irlp_css[$i]?>">
             <?=$irlp_pseudo[$i]?>
            </td>
            <td class="cadre_gris align_center <?=$irlp_css[$i]?>">
              <select class="indiv discret align_center <?=$irlp_css[$i]?>" name="irlp_confirme<?=$irlp_id[$i]?>">
                <?php if($irlp_confirme[$i]) { ?>
                <option value="0">Non</option>
                <option value="1" selected>Oui</option>
                <?php } else { ?>
                <option value="0" selected>Non</option>
                <option value="1">Oui</option>
                <?php } ?>
              </select>
            </td>
            <td class="cadre_gris align_center <?=$irlp_css[$i]?>">
              <input class="indiv align_center <?=$irlp_css[$i]?>" name="irlp_details<?=$irlp_id[$i]?>" value="<?=$irlp_details[$i]?>">
            </td>
            <td class="cadre_gris align_center <?=$irlp_css[$i]?>">
              <input type="submit" class="indiv discret align_center <?=$irlp_css[$i]?>" name="irlp_modifier" value="Modifier" onClick="document.getElementById('irlp_actionid').value = '<?=$irlp_id[$i]?>'; document.getElementById('irlp').submit();">
            </td>
            <td class="cadre_gris align_center <?=$irlp_css[$i]?>">
              <input type="submit" class="indiv discret align_center <?=$irlp_css[$i]?>" name="irlp_supprimer" value="Supprimer"
              onClick="var ok = confirm('Confirmer la suppression de <?=addslashes($irlp_pseudo[$i])?> ?'); if(ok == true) {document.getElementById('irlp_actionid').value = '<?=$irlp_id[$i]?>'; document.getElementById('irlp').submit();}">
            </td>
          </tr>
          <?php } ?>
        </table>

        <div class="align_center">
          <input name="irl_edit_participants" type="image" src="<?=$chemin?>img/boutons/retour_irl.png" alt="Modifier">
        </div>

      </div>

    </form>

    <?php } ?>


    <?php } else { ?>

    <div class="body_main smallsize">
      <br>
      <div class="moinsgros gras indiv align_center">
        <span class="gros">Confirmer la suppression de l'IRL :</span><br>
        <br>
        <br>
        Irl du <?=$irl_date?> à <?=$irl_lieu?>, <?=$irl_participants?> participant(s) listé(s).<br>
        <br>
        <br>
        <form name="irl" method="post" action="irl.php?delete=<?=$id_irl?>">
          Raison de la suppression :<br>
          <br>
          <input class="indiv align_center" name="irl_delete_raison"><br>
          <br>
          <input name="irl_delete" type="image" src="<?=$chemin?>img/boutons/supprimer.png" alt="Supprimer">
        </form>
      </div>
    </div>

    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';