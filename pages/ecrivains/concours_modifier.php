<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsConcours';

// Identification
$page_nom = "Gère les concours d'écriture";
$page_url = "pages/ecrivains/concours_liste";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Concours du coin des écrivains";
$page_desc  = "Le célèbre concours d'écriture du coin des écrivains de NoBleme.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'ID du concours

// On récupère l'ID du concours à modifier - s'il n'y en a pas, c'est une création de concours
if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  $id_concours = 0;
else
  $id_concours = postdata($_GET['id'], 'int');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'un nouveau concours

if(isset($_POST['concours_creer']))
{
  // Assainissement du postdata
  $concours_new_debut = strtotime(str_replace("/", "-", postdata_vide('concours_date_debut', 'string')));
  $concours_new_fin   = strtotime(str_replace("/", "-", postdata_vide('concours_date_fin', 'string')).' 22:00');
  $concours_new_titre = postdata_vide('concours_titre', 'string');
  $concours_new_sujet = postdata_vide('concours_sujet', 'string');

  // Création du concours
  query(" INSERT INTO ecrivains_concours
          SET         ecrivains_concours.timestamp_debut  = '$concours_new_debut' ,
                      ecrivains_concours.timestamp_fin    = '$concours_new_fin'   ,
                      ecrivains_concours.titre            = '$concours_new_titre' ,
                      ecrivains_concours.sujet            = '$concours_new_sujet' ");

  // Automatisation de la fin du concours
  $concours_new_id = mysqli_insert_id($db);
  automatisation('ecrivains_concours_vote', $concours_new_id, $concours_new_fin);

  // Activité récente
  activite_nouveau('ecrivains_concours_new', 0, 0, 0, $concours_new_id, $concours_new_titre);

  // Bot IRC
  $concours_new_titre_raw = $_POST['concours_titre'];
  ircbot($chemin, 'Un nouveau concours du coin des écrivains vient de commencer : '.$concours_new_titre_raw.' - '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$concours_new_id, '#NoBleme');
  ircbot($chemin, 'Un nouveau concours du coin des écrivains vient de commencer : '.$concours_new_titre_raw.' - '.$GLOBALS['url_site'].'pages/ecrivains/concours?id='.$concours_new_id, '#write');

  // Redirection
  exit(header("Location: ".$chemin."pages/ecrivains/concours?id=".$concours_new_id));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'un concours existant

if($id_concours && isset($_POST['concours_modifier']))
{
  // Assainissement du postdata
  $concours_edit_debut  = strtotime(str_replace("/", "-", postdata_vide('concours_date_debut', 'string')));
  $concours_edit_fin    = strtotime(str_replace("/", "-", postdata_vide('concours_date_fin', 'string')).' 22:00');
  $concours_edit_titre  = postdata_vide('concours_titre', 'string');
  $concours_edit_sujet  = postdata_vide('concours_sujet', 'string');

  // Modification du concours
  query(" UPDATE  ecrivains_concours
          SET     ecrivains_concours.timestamp_debut  = '$concours_edit_debut'  ,
                  ecrivains_concours.timestamp_fin    = '$concours_edit_fin'    ,
                  ecrivains_concours.titre            = '$concours_edit_titre'  ,
                  ecrivains_concours.sujet            = '$concours_edit_sujet'
          WHERE   ecrivains_concours.id               = '$id_concours'          ");

  // On vérifie s'il faut déplacer l'automatisation de la fin du concours
  $dautomatisation = mysqli_fetch_array(query(" SELECT  automatisation.action_id AS 'a_id'
                                                FROM    automatisation
                                                WHERE   automatisation.action_id    = '$id_concours'
                                                AND     automatisation.action_type  = 'ecrivains_concours_vote' "));

  // Déplacement de l'automatisation de la fin du concours si nécessaire
  if($dautomatisation['a_id'])
    automatisation('ecrivains_concours_vote', $id_concours, $concours_edit_fin);

  // Redirection
  exit(header("Location: ".$chemin."pages/ecrivains/concours?id=".$id_concours));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des infos du concours

// Si c'est une modification, on a besoin des infos du concours
if($id_concours)
{
  // On va les chercher
  $dconcours = mysqli_fetch_array(query(" SELECT  ecrivains_concours.timestamp_debut  AS 'c_debut'  ,
                                                  ecrivains_concours.timestamp_fin    AS 'c_fin'    ,
                                                  ecrivains_concours.titre            AS 'c_titre'  ,
                                                  ecrivains_concours.sujet            AS 'c_sujet'
                                          FROM    ecrivains_concours
                                          WHERE   ecrivains_concours.id = '$id_concours' "));

  // Puis on les prépare pour l'affichage
  $concours_titre = predata($dconcours['c_titre']);
  $concours_sujet = predata($dconcours['c_sujet']);
  $concours_debut = predata(date('d/m/Y', $dconcours['c_debut']));
  $concours_fin   = predata(date('d/m/Y', $dconcours['c_fin']));
}
// Sinon, on laisse tout vide par défaut
else
{
  $concours_titre = '';
  $concours_sujet = '';
  $concours_debut = date('d/m/Y');
  $concours_fin   = '';
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <?php if(!$id_concours) { ?>
        <h1>Nouveau concours d'écriture</h1>
        <?php } else { ?>
        <h1>Modifier un concours d'écriture</h1>
        <?php } ?>

        <p>
          <form method="POST">
            <fieldset>

              <label for="concours_titre">Titre du concours</label>
              <input id="concours_titre" name="concours_titre" class="indiv" type="text" value="<?=$concours_titre?>"><br>
              <br>

              <label for="concours_sujet">Sujet du concours</label>
              <input id="concours_sujet" name="concours_sujet" class="indiv" type="text" value="<?=$concours_sujet?>"><br>
              <br>

              <label for="concours_date_debut">Date de début</label>
              <input id="concours_date_debut" name="concours_date_debut" class="indiv" type="text" value="<?=$concours_debut?>"><br>
              <br>

              <label for="concours_date_fin">Date de fin</label>
              <input id="concours_date_fin" name="concours_date_fin" class="indiv" type="text" value="<?=$concours_fin?>"><br>
              <br>

              <br>
              <?php if(!$id_concours) { ?>
              <input value="CRÉER UN NOUVEAU CONCOURS" type="submit" name="concours_creer">
              <?php } else { ?>
              <input value="MODIFIER LE CONCOURS" type="submit" name="concours_modifier">
              <?php } ?>

            </fieldset>
          </form>
        </p>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';