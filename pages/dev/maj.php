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
$header_sidemenu  = 'maj';

// Titre
$page_titre = "Dev : Mise à jour";

// Identification
$page_nom = "admin";

// CSS & JS
$css = array('admin');
$js  = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Version et builds actuels
$qversion = mysqli_fetch_array(query("SELECT version.version, version.build, version.date FROM version ORDER BY version.id DESC LIMIT 1"));
$avantmaj = "Version ".$qversion['version'].", build ".$qversion['build'];
$version  = $qversion['version'];
$build    = $qversion['build'] + 1;




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

      <br>
      <br>

      <div class="margin_auto midsize monospace">
        <table class="cadre_gris indiv">

          <tr>
            <td class="cadre_gris_titre gros">AVANT DE FAIRE LA MISE À JOUR</td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Préparation de la structure de la base de données</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">S'il y a eu des changements structurels, faire un dump dans sqldump.php</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Nouvelles pages sur le site ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Les permissions guest / user / admin sont-elles bonnes ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Me vois-je bien sur les nouvelles pages dans <a class="dark gras" href="<?=$chemin?>pages/nobleme/online">qui est en ligne</a> ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Passer tout l'output au <a class="dark gras" href="http://validator.w3.org/#validate_by_input">validateur W3C</a> et corriger les erreurs</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Nouvelles fonctionnalités ajoutant/modifiant/suuprimant du contenu ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">S'assurer qu'il y ait des logs et qu'ils apparaissent dans l'<a class="dark gras" href="<?=$chemin?>pages/nobleme/activite">activité récente</a></td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros align_center">Nouveaux pouvoirs de modération ou administratifs ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">S'assurer que les logs apparaissent dans les <a class="dark gras" href="<?=$chemin?>pages/nobleme/activite?mod">logs de modération</a></td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Nouvelles pages pouvant utiliser des liens courts ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Créer les <a class="dark gras" href="<?=$chemin?>s/index">raccourcis</a> partout où il en faut</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros align_center">Nouveaux tags css ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Les ajouter à la <a class="dark gras" href="<?=$chemin?>pages/dev/css">référence du CSS</a> si ce n'est pas fait</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Nouvelles fonctions() ?</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Les ajouter à la <a class="dark gras" href="<?=$chemin?>pages/dev/fonctions">liste des fonctions</a> si ce n'est pas fait</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Faire un backup local complet</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Juste un dump (pas un backup) en local au cas où je foutrais la merde</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Commit les nouveaux changements</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">On est prêts à passer aux choses sérieuses</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

        </table>
      </div>

      <br>
      <br>
      <br>

      <div class="margin_auto midsize monospace" id="majtime">
        <table class="cadre_gris indiv">

          <tr>
            <td class="cadre_gris_titre gros">ET MAINTENANT ON FAIT LA MISE À JOUR</td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Fermer le site aux utilisateurs</td>
          </tr>
          <tr id="fermer">

            <?php if(!$majcheck['mise_a_jour']) { ?>

              <td class="cadre_gris_haut align_center moinsgros pointeur" onclick="dynamique('<?=$chemin?>','maj.php?dynamique','fermer','fermer=1');dynamique('<?=$chemin?>','maj.php?dynamique','ouvrir','fermer2=1');"><a class="dark gras">Cliquer ici pour fermer le site</a><br><br></td>

            <?php } else { ?>

              <td class="cadre_gris_haut align_center moinsgros mise_a_jour texte_blanc moinsgros gras">Le site est maintenant fermé<br><br></td>

            <?php } ?>

          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Faire les requêtes SQL si il y en a
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"><a class="dark gras" href="<?=$chemin?>pages/dev/sql">Faire les requêtes</a> et espérer que tout se passe bien</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Uploader les fichiers dans le FTP</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Tous ceux qui sont updatés dans le hg, sinon upload tout et on écrase</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Tester que tout fonctionne</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">On est jamais trop sûr, en prod ça peut différer du dev</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Mettre à jour la todo list</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Dans le <a class="dark gras" href="<?=$chemin?>pages/todo/roadmap">plan de route</a> rendre publics / valider les tickets concernés</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Ajouter le nouveau numéro de version
          </tr>
          <tr id="maj">
            <td class="cadre_gris_haut align_center moinsgros blanc">

              <table class="data_input">
                <tr>
                  <td class="data_input_right">Avant maj :</td>
                  <td class="data_input_left nowrap"><?=$avantmaj?></td>
                </tr>
                <tr>
                  <td class="data_input_right">Version :</td>
                  <td class="maj_version_titre"><input class="indiv" id="version" value="<?=$version?>"></td>
                </tr>
                <tr>
                  <td class="data_input_right">Build :&nbsp;</td>
                  <td class="maj_version_titre"><input class="indiv" id="build" value="<?=$build?>"></td>
                </tr>
                <tr>
                  <td class="data_input_right">Date :</td>
                  <td class="maj_version_titre"><input class="indiv" id="date" value="<?=date('Y-m-d')?>"></td>
                </tr>
                <tr>
                  <td class="align_center pointeur" colspan="2" onClick="dynamique('<?=$chemin?>','maj.php?dynamique','maj',
                    'version='+dynamique_prepare('version')+
                    '&amp;build='+dynamique_prepare('build')+
                    '&amp;date='+dynamique_prepare('date')+
                    '&amp;maj=1');">
                    <img src="<?=$chemin?>img/boutons/ajouter.png" alt="Ajouter">
                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Rouvrir le site aux utilisateurs
          </tr>
          <tr id="ouvrir">

            <?php if(!$majcheck['mise_a_jour']) { ?>

              <td class="cadre_gris_haut align_center moinsgros gras">Le site est pas encore fermé yo<br><br></td>

            <?php } else { ?>

              <td class="cadre_gris_haut align_center moinsgros mise_a_jour texte_blanc moinsgros gras pointeur" onclick="dynamique('<?=$chemin?>','maj.php?dynamique','ouvrir','ouvrir=1');dynamique('<?=$chemin?>','maj.php?dynamique','fermer','ouvrir2=1')";>Cliquer ici pour ouvrir le site<br><br></td>

            <?php } ?>

          </tr>

        </table>
      </div>

      <br>
      <br>
      <br>

      <div class="margin_auto midsize monospace">
        <table class="cadre_gris indiv">

          <tr>
            <td class="cadre_gris_titre gros">APRÈS LA MISE À JOUR</td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">Faire un backup local complet après la mise à jour</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Backup local de tout le contenu du répertoire /www/</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Dump local de la base de données</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

          <tr>
            <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">C'est fini</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros">Yay, maintenant on peut passer à autre chose de plus intéressant</td>
          </tr>
          <tr>
            <td class="cadre_gris_haut align_center moinsgros"></td>
          </tr>

        </table>
      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                     PLACE AUX DONNÉES DYNAMIQUES                                                      */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Fermer le site
  if(isset($_POST['fermer']))
  {
    // On ferme le site
    query(" UPDATE vars_globales SET mise_a_jour = 1 ");

    // On affiche que le site est fermé
    ?>

    <td class="cadre_gris_haut align_center moinsgros mise_a_jour texte_blanc moinsgros gras">Le site est maintenant fermé<br><br></td>

    <?php
  }
  else if(isset($_POST['fermer2']))
  {
    // Et on fait apparaitre le bouton pour ouvrir le site
    ?>

    <td class="cadre_gris_haut align_center moinsgros mise_a_jour texte_blanc moinsgros gras pointeur" onclick="dynamique('<?=$chemin?>','maj.php?dynamique','ouvrir','ouvrir=1');dynamique('<?=$chemin?>','maj.php?dynamique','fermer','ouvrir2=1')";>Cliquer ici pour ouvrir le site<br><br></td>

    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Ouvrir le site
  if(isset($_POST['ouvrir']))
  {
    // On ouvre le site
    query(" UPDATE vars_globales SET mise_a_jour = 0 ");

    // Et on fait savoir qu'il est ouvert !
    ?>

    <td class="cadre_gris_haut align_center moinsgros vert_background moinsgros gras">Le site a ré-ouvert ses portes !<br><br></td>

    <?php
  }
  else if(isset($_POST['ouvrir2']))
  {
    // Également en haut
    ?>

    <td class="cadre_gris_haut align_center moinsgros vert_background moinsgros gras">La mise à jour est finie !<br><br></td>

    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Mise à jour
  if(isset($_POST['maj']))
  {
    // Traitement du postdata
    $version    = postdata($_POST['version']);
    $build      = postdata($_POST['build']);
    $date       = postdata($_POST['date']);
    $v_activite = $version.' build '.$build;
    $timestamp  = time();

    // Nouvelle version
    query(" INSERT INTO version SET version.version = '$version', version.build = '$build', version.date = '$date' ");

    // Activité récente
    query(" INSERT INTO activite SET activite.timestamp = '$timestamp', activite.action_type = 'version', activite.action_titre = '$v_activite' ");

    // Bot IRC NoBleme
    ircbot($chemin,"Nouvelle version de NoBleme publiée : Version ".$version." build ".$build." - http://nobleme.com/pages/todo/roadmap","#dev");

    // Et on affiche tout ça
    $newversion = stripslashes("Version ".$version.", build ".$build." du ".jourfr($date));
    ?>

    <td class="cadre_gris_haut align_center moinsgros vert_background moinsgros gras">
      Le nouveau numéro de version a été ajouté !<br>
      <?=$newversion?><br>
      <br>
    </td>

    <?php
  }
}