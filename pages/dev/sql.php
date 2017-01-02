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
$header_sidemenu  = 'sql';

// Titre et description
$page_titre = "Dev : Requêtes";

// Identification
$page_nom = "admin";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                               REQUÊTES                                                                */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Début du string d'affichage

$majq = '<p class="nobleme_fonce texte_blanc gros gras vspaced">Début des requêtes...</p>';

/********************************NBRPGTEST*DELETEME**********************/
query(" DROP TABLE IF EXISTS nbrpg_persos ");
query(" DROP TABLE IF EXISTS nbrpg_monstres ");
query(" DROP TABLE IF EXISTS nbrpg_session ");
query(" DROP TABLE IF EXISTS nbrpg_chatlog ");
$majq .= '<p class="erreur texte_blanc gros gras vspaced">Exécution des tests à supprimer avant de mettre en live</p>';
/********************************NBRPGTEST*DELETEME**********************/

query(" CREATE TABLE IF NOT EXISTS nbrpg_persos (
          id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          FKmembres         INT(11) UNSIGNED NOT NULL                             ,
          couleur_chat      TINYTEXT                                              ,
          dernier_chat_rp   INT(11) UNSIGNED NOT NULL                             ,
          dernier_chat_hrp  INT(11) UNSIGNED NOT NULL                             ,
          date_creation     INT(11) UNSIGNED NOT NULL                             ,
          nom               MEDIUMTEXT                                            ,
          max_vie           INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");
$majq .= '<p class="vert_background vspaced moinsgros gras">Crée la table nbrpg_persos</p>';


query(" CREATE TABLE IF NOT EXISTS nbrpg_monstres (
          id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          nom               MEDIUMTEXT                                            ,
          max_vie           INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");
$majq .= '<p class="vert_background vspaced moinsgros gras">Crée la table nbrpg_monstres</p>';


query(" CREATE TABLE IF NOT EXISTS nbrpg_session (
          id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          FKnbrpg_persos    INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_monstres  INT(11) UNSIGNED NOT NULL                             ,
          vie               INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");
$majq .= '<p class="vert_background vspaced moinsgros gras">Crée la table nbrpg_monstre</p>';


query(" CREATE TABLE IF NOT EXISTS nbrpg_chatlog (
          id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          timestamp         INT(11) UNSIGNED NOT NULL                             ,
          FKmembres         INT(11) UNSIGNED NOT NULL                             ,
          type_chat         TINYTEXT                                              ,
          message           LONGTEXT
        ) ENGINE=MyISAM; ");
$majq .= '<p class="vert_background vspaced moinsgros gras">Crée la table nbrpg_chatlog</p>';


if(!@mysqli_query($GLOBALS['db'], " SELECT nbrpg_activite FROM vars_globales "))
  query(" ALTER TABLE vars_globales ADD nbrpg_activite INT(11) UNSIGNED NOT NULL AFTER last_referer_check ");
$majq .= '<p class="vert_background_clair vspaced gras">Crée le champ vars_globales.nbrpg_activite</p>';



if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nbrpg' AND page_id LIKE 'index' ")))
  query(" INSERT INTO pages
          SET         page_nom    = 'nbrpg'                     ,
                      page_id     = 'index'                     ,
                      visite_page = 'Attend le retour du NBRPG' ,
                      visite_url  = 'pages/nbrpg/index'         ");
$majq .= '<p class="nobleme_background vspaced">Crée l\'entrée activité : Attend le retour du NBRPG</p>';

if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nbrpg' AND page_id LIKE 'personnages' ")))
  query(" INSERT INTO pages
          SET         page_nom    = 'nbrpg'                         ,
                      page_id     = 'personnages'                   ,
                      visite_page = 'Juge les personnages du NBRPG' ,
                      visite_url  = 'pages/nbrpg/joueurs_actifs'    ");
$majq .= '<p class="nobleme_background vspaced">Crée l\'entrée activité : Juge les personnages du NBRPG</p>';


/********************************NBRPGTEST*DELETEME**********************/
query(" INSERT INTO nbrpg_persos SET id = 1 , FKmembres = 47, couleur_chat = '#AAAA66' , date_creation = 1394875860 , nom = 'Raclette' , max_vie = 21 ");
query(" INSERT INTO nbrpg_persos SET id = 2 , FKmembres = 234, couleur_chat = '#AA6666' , date_creation = 1334875863 , nom = 'Bidule' , max_vie = 18 ");
query(" INSERT INTO nbrpg_persos SET id = 3 , FKmembres = 227, couleur_chat = '#66AAAA' , date_creation = 1393925460 , nom = 'Gorillor' , max_vie = 38 ");
query(" INSERT INTO nbrpg_persos SET id = 4 , FKmembres = 236, couleur_chat = '#AA66AA' , date_creation = 1393925460 , nom = 'Eorzea' , max_vie = 48 ");
query(" INSERT INTO nbrpg_persos SET id = 5 , FKmembres = 1, couleur_chat = '#66AA66' , date_creation = 1393925460 , nom = 'Baderon' , max_vie = 29 ");
query(" INSERT INTO nbrpg_monstres SET id = 1 , nom = 'Bitounette moulée' , max_vie = 94");
query(" INSERT INTO nbrpg_monstres SET id = 2 , nom = 'Clafoutis des forêts' , max_vie = 37");
query(" INSERT INTO nbrpg_monstres SET id = 3 , nom = 'Schnafon' , max_vie = 189");
query(" INSERT INTO nbrpg_session SET id = 1 , FKnbrpg_persos = 1 , FKnbrpg_monstres = 0 , vie = 21 ");
query(" INSERT INTO nbrpg_session SET id = 2 , FKnbrpg_persos = 3 , FKnbrpg_monstres = 0 , vie = 38 ");
query(" INSERT INTO nbrpg_session SET id = 3 , FKnbrpg_persos = 4 , FKnbrpg_monstres = 0 , vie = 48 ");
query(" INSERT INTO nbrpg_session SET id = 4 , FKnbrpg_persos = 5 , FKnbrpg_monstres = 0 , vie = 29 ");
query(" INSERT INTO nbrpg_session SET id = 5 , FKnbrpg_persos = 0 , FKnbrpg_monstres = 1 , vie = 94 ");
query(" INSERT INTO nbrpg_session SET id = 6 , FKnbrpg_persos = 0 , FKnbrpg_monstres = 1 , vie = 94 ");
query(" INSERT INTO nbrpg_session SET id = 7 , FKnbrpg_persos = 0 , FKnbrpg_monstres = 3 , vie = 189 ");
$majq .= '<p class="erreur texte_blanc gros gras vspaced">Exécution des tests à supprimer avant de mettre en live</p>';
/********************************NBRPGTEST*DELETEME**********************/


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fin du string d'affichage

$majq .= '<p class="nobleme_fonce texte_blanc gros gras vspaced">Fini toutes les requêtes !</p>';





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                               TEMPLATES                                                               */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/* Ces modèles sont là pour me souvenir d'une version à l'autre de comment écrire mes changements sans me faire chier à aller dig les logs


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'une table

query(" CREATE TABLE IF NOT EXISTS cc_tvvmb (
          id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          cc    MEDIUMTEXT                                            ,
          tvvmb INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");
$majq .= '<p class="vert_background vspaced moinsgros gras">Crée la table cc_tvvmb</p>';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'un champ dans une table existante

if(!@mysqli_query($GLOBALS['db'], " SELECT tvvmb FROM cc "))
  query(" ALTER TABLE cc ADD tvvmb INT(11) UNSIGNED NOT NULL AFTER champ_avant_tvvmb ");
$majq .= '<p class="vert_background_clair vspaced gras">Crée le champ cc.tvvmb</p>';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Rajout d'une entrée dans un champ

if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'cc' AND page_id LIKE 'tvvmb' ")))
  query(" INSERT INTO pages
          SET         page_nom    = 'cc'                  ,
                      page_id     = 'tvvmb'               ,
                      visite_page = 'Salue tout le monde' ,
                      visite_url  = 'pages/cc/tvvmb'      ");
$majq .= '<p class="nobleme_background vspaced">Crée l\'entrée activité : Salue tout le monde</p>';




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

    <div class="body_main smallsize align_center">
      <?=$majq?>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';