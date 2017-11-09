<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'MajVersion';

// Titre et description
$page_titre = "Dev: Version";

// Identification
$page_nom = "Administre secrètement le site";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Mise à jour du numéro de version
if(isset($_POST['majVersion']))
{
  // Traitement du postdata
  $maj_version  = postdata($_POST['majVersion']);
  $maj_build    = postdata($_POST['majBuild']);
  $maj_date     = postdata($_POST['majDate']);
  $maj_activite = $maj_version.' build '.$maj_build;
  $timestamp    = time();

  // Nouvelle version
  query(" INSERT INTO version SET version.version = '$maj_version', version.build = '$maj_build', version.date = '$maj_date' ");

  // Activité récente
  query(" INSERT INTO activite SET activite.timestamp = '$timestamp', activite.action_type = 'version', activite.action_titre = '$maj_activite' ");

  // Bot IRC NoBleme
  ircbot($chemin,"Nouvelle version de NoBleme: Version ".$maj_version." build ".$maj_build." - ".$GLOBALS['url_site']."pages/todo/roadmap","#dev");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Version et builds actuels
$qmajversion  = mysqli_fetch_array(query("SELECT version.version, version.build FROM version ORDER BY version.id DESC LIMIT 1"));
$maj_version  = $qmajversion['version'];
$maj_build    = $qmajversion['build'] + 1;
$maj_date     = date('Y-m-d');
$maj_datefull = jourfr($maj_date);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php if(!isset($_POST['majVersion'])) { ?>

      <div class="texte">

        <br>

        <h1>Mise à jour</h1>
        <h4>Nouveau numéro de version</h4>

        <br>
        <br>

        <form method="POST">
          <fieldset>
            <label for="majVersion">Version</label>
            <input id="majVersion" name="majVersion" class="indiv" type="text" value="<?=$maj_version?>"><br>
            <br>
            <label for="majBuild">Build</label>
            <input id="majBuild" name="majBuild" class="indiv" type="text" value="<?=$maj_build?>"><br>
            <br>
            <label for="majDate">Date</label>
            <input id="majDate" name="majDate" class="indiv" type="text" value="<?=$maj_date?>"><br>
            <br>
            <input value="Mettre à jour le numéro de version" type="submit">
          </fieldset>
        </form>

      </div>

      <?php } else { ?>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="align_center">

          <h1>Mise à jour effectuée</h1>

          <br>
          <br>

          <h5>Version <?=$maj_version?> build <?=$maj_build?> du <?=$maj_datefull?></h5>

        </div>

        <br>
        <br>
        <br>
        <br>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';