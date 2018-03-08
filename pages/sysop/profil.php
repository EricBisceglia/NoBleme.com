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
$header_sidemenu  = 'ModifierProfil';

// Identification
$page_nom = "Administre secrètement le site";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Modifier un profil";

// CSS & JS
$css  = array('user');
$js   = array('dynamique', 'sysop/chercher_user');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on change le profil d'un utilisateur
if(isset($_POST['profil_go']))
{
  // On nettoie le postdata
  $profil_id      = postdata($_GET['id'], 'int', 0);
  $profil_genre   = postdata_vide('profil_genre', 'string', '', 35);
  $profil_habite  = postdata_vide('profil_habite', 'string', '', 35);
  $profil_metier  = postdata_vide('profil_metier', 'string', '', 35);
  $profil_texte   = postdata_vide('profil_texte', 'string', '');

  // On vérifie que l'user existe, sinon on dégage
  $qtestprofil = mysqli_fetch_array(query(" SELECT  membres.id
                                            FROM    membres
                                            WHERE   membres.id = '$profil_id' "));
  if(!$qtestprofil['id'])
    header("Location: ".$chemin."pages/sysop/profil");

  // On récupère le profil actuel de l'user pour le diff
  $qprofiluser = mysqli_fetch_array(query(" SELECT  membres.pseudonyme  ,
                                                    membres.genre       ,
                                                    membres.habite      ,
                                                    membres.metier      ,
                                                    membres.profil
                                            FROM    membres
                                            WHERE   membres.id = '$profil_id' "));

  // On met à jour le profil
  query(" UPDATE  membres
          SET     membres.genre   = '$profil_genre'   ,
                  membres.habite  = '$profil_habite'  ,
                  membres.metier  = '$profil_metier'  ,
                  membres.profil  = '$profil_texte'
          WHERE   membres.id      = '$profil_id'      ");

  // On ajoute le changement aux logs de modération
  $timestamp      = time();
  $profil_pseudo  = postdata(getpseudo($profil_id), 'string');
  $profil_sysop   = postdata(getpseudo(), 'string');
  query(" INSERT INTO activite
          SET         timestamp       = '$timestamp'      ,
                      log_moderation  = 1                 ,
                      FKmembres       = '$profil_id'      ,
                      pseudonyme      = '$profil_pseudo'  ,
                      action_type     = 'profil_edit'     ,
                      parent          = '$profil_sysop'   ");

  // On crée les diff pour aller avec le log
  $id_activite        = mysqli_insert_id($db);
  $old_profil_genre   = postdata($qprofiluser['genre'], 'string');
  $old_profil_habite  = postdata($qprofiluser['habite'], 'string');
  $old_profil_metier  = postdata($qprofiluser['metier'], 'string');
  $old_profil_texte   = postdata($qprofiluser['profil'], 'string');
  if($profil_genre != $old_profil_genre)
    query(" INSERT INTO activite_diff
            SET         FKactivite      = '$id_activite'      ,
                        titre_diff      = 'Genre'             ,
                        diff_avant      = '$old_profil_genre' ,
                        diff_apres      = '$profil_genre'     ");
  if($profil_habite != $old_profil_habite)
    query(" INSERT INTO activite_diff
            SET         FKactivite      = '$id_activite'          ,
                        titre_diff      = 'Ville / Région / Pays' ,
                        diff_avant      = '$old_profil_habite'    ,
                        diff_apres      = '$profil_habite'        ");
  if($profil_metier != $old_profil_metier)
    query(" INSERT INTO activite_diff
            SET         FKactivite      = '$id_activite'        ,
                        titre_diff      = 'Métier / Occupation' ,
                        diff_avant      = '$old_profil_metier'  ,
                        diff_apres      = '$profil_metier'      ");
  if($profil_texte != $old_profil_texte)
    query(" INSERT INTO activite_diff
            SET         FKactivite      = '$id_activite'      ,
                        titre_diff      = 'Texte libre'       ,
                        diff_avant      = '$old_profil_texte' ,
                        diff_apres      = '$profil_texte'     ");

  // On prépare le message privé à envoyer à l'user dont le profil a été changé
  $profil_pm = <<<EOD
[url={$chemin}pages/user/user]Votre profil public[/url] a été modifié par un membre de [url={$chemin}pages/nobleme/admins]l'équipe administrative[/url].

À l'avenir, assurez vous que le contenu de votre profil respecte le [url={$chemin}pages/doc/coc]code de conduite[/url] de NoBleme.



A member of the [url={$chemin}pages/nobleme/admins]administrative team[/url] modified your [url={$chemin}pages/user/user]public profile[/url].

In the future, make sure that your public profile respects NoBleme's [url={$chemin}pages/doc/coc]code of conduct[/url].
EOD;

  // On envoie un message privé à l'user qui s'est fait bannir
  envoyer_notif($profil_id, "Profil public modifié / Public profile edited", postdata($profil_pm));

  // On notifie #sysop de l'action
  ircbot($chemin, getpseudo()." a modifié le profil public de ".getpseudo($profil_id)." - ".$GLOBALS['url_site']."pages/user/user?id=".$profil_id, "#sysop");

  // Et on redirige vers le profil de l'user
  header("Location: ".$chemin."pages/user/user?id=".$profil_id);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a choisi l'user, on prépare ses infos
if(isset($_GET['id']))
{
  // On commence par récupérer l'ID
  $profil_id = postdata($_GET['id'], 'int', 0);

  // On va chercher les données liées à l'user
  $qprofiluser = mysqli_fetch_array(query(" SELECT  membres.pseudonyme  ,
                                                    membres.genre       ,
                                                    membres.habite      ,
                                                    membres.metier      ,
                                                    membres.profil
                                            FROM    membres
                                            WHERE   membres.id = '$profil_id' "));
  $profil_pseudo  = predata($qprofiluser['pseudonyme']);
  $profil_genre   = predata($qprofiluser['genre']);
  $profil_habite  = predata($qprofiluser['habite']);
  $profil_metier  = predata($qprofiluser['metier']);
  $profil_texte   = predata($qprofiluser['profil']);

  // Si l'user existe pas, on dégage
  if(!$profil_pseudo)
    $_GET['id'] = 0;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Modifier un profil public</h1>

        <p>Évitez de vous servir de cet outil pour vous amuser à troller. Son but est de nettoyer le contenu des profils qui ne respectent pas le <a class="gras" href="<?=$chemin?>pages/doc/coc">code de conduite</a> ou d'aider les membres qui se galèrent à faire leur profil tout seul.</p>

        <br>
        <br>

        <?php if(isset($_GET['id']) && $profil_pseudo && $profil_id == 1) { ?>

        <h5>On ne change pas le profil du patron. Bien essayé.</h5>

        <?php } else if(isset($_GET['id']) && $profil_pseudo) { ?>

        <h5>Modifier le profil de <a href="<?=$chemin?>pages/user/user?id=<?=$profil_id?>"><?=$profil_pseudo?></a></h5>
        <br>

        <form method="POST">
          <fieldset>
            <label for="profil_genre">Genre:</label>
            <input id="profil_genre" name="profil_genre" class="indiv" type="text" value="<?=$profil_genre?>" maxlength="35"><br>
            <br>
            <label for="profil_habite">Ville / Région / Pays:</label>
            <input id="profil_habite" name="profil_habite" class="indiv" type="text" value="<?=$profil_habite?>" maxlength="35"><br>
            <br>
            <label for="profil_metier">Métier / Occupation:</label>
            <input id="profil_metier" name="profil_metier" class="indiv" type="text" value="<?=$profil_metier?>" maxlength="35"><br>
            <br>
            <label for="profil_texte">Texte libre (partie droite):</label>
            <textarea id="profil_texte" name="profil_texte" class="indiv profil_textarea" lines="20"><?=$profil_texte?></textarea><br>
            <br>
            <input value="Modifier le profil de <?=$profil_pseudo?>" type="submit" name="profil_go">
          </fieldset>
        </form>

        <?php } else { ?>

        <fieldset>
          <label for="sysop_pseudo_user">Entrez une partie du pseudonyme de l'utilisateur dont vous souhaitez modifier le profil :</label>
          <input  id="sysop_pseudo_user" name="sysop_pseudo_user" class="indiv" type="text"
                  onkeyup="sysop_chercher_user('<?=$chemin?>', 'Modifier le profil', 'profil')";><br>
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