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
          id                  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          FKmembres           INT(11) UNSIGNED NOT NULL                             ,
          couleur_chat        TINYTEXT                                              ,
          dernier_chat_rp     INT(11) UNSIGNED NOT NULL                             ,
          dernier_chat_hrp    INT(11) UNSIGNED NOT NULL                             ,
          date_creation       INT(11) UNSIGNED NOT NULL                             ,
          nom                 MEDIUMTEXT                                            ,
          classe              MEDIUMTEXT                                            ,
          niveau              INT(11) UNSIGNED NOT NULL                             ,
          experience          INT(11) UNSIGNED NOT NULL                             ,
          prochain_niveau     INT(11) UNSIGNED NOT NULL                             ,
          max_vie             INT(11) UNSIGNED NOT NULL                             ,
          max_charges_oracle  INT(11) UNSIGNED NOT NULL                             ,
          physique            INT(11) UNSIGNED NOT NULL                             ,
          mental              INT(11) UNSIGNED NOT NULL                             ,
          danger              INT(11) UNSIGNED NOT NULL                             ,
          FKarme              INT(11) UNSIGNED NOT NULL                             ,
          FKcostume           INT(11) UNSIGNED NOT NULL                             ,
          FKobjet1            INT(11) UNSIGNED NOT NULL                             ,
          FKobjet2            INT(11) UNSIGNED NOT NULL                             ,
          FKobjet3            INT(11) UNSIGNED NOT NULL                             ,
          FKobjet4            INT(11) UNSIGNED NOT NULL
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
          vie               INT(11) UNSIGNED NOT NULL                             ,
          energie           INT(11) UNSIGNED NOT NULL                             ,
          charges_oracle    INT(11) UNSIGNED NOT NULL                             ,
          physique          INT(11) UNSIGNED NOT NULL                             ,
          mental            INT(11) UNSIGNED NOT NULL                             ,
          danger            INT(11) UNSIGNED NOT NULL
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
query(" INSERT INTO nbrpg_persos SET id = 1 , FKmembres = 47, couleur_chat = '#AAAA66', date_creation = 1394875860, nom = 'Raclette', classe = 'Aventurier', niveau = 1, experience = 28, prochain_niveau = 50, max_vie = 20, max_charges_oracle = 1, physique = 10, mental = 10, danger = 10, FKarme = 0, FKcostume = 0, FKobjet1 = 0, FKobjet2 = 0, FKobjet3 = 0, FKobjet4 = 0 ");
query(" INSERT INTO nbrpg_persos SET id = 2 , FKmembres = 234, couleur_chat = '#AA6666', date_creation = 1334875863, nom = 'Bidule', classe = 'Druide', niveau = 3, experience = 0, prochain_niveau = 100, max_vie = 28, max_charges_oracle = 1, physique = 12, mental = 18, danger = 14, FKarme = 0, FKcostume = 0, FKobjet1 = 0, FKobjet2 = 0, FKobjet3 = 0, FKobjet4 = 0 ");
query(" INSERT INTO nbrpg_persos SET id = 3 , FKmembres = 227, couleur_chat = '#66AAAA', date_creation = 1393925460, nom = 'Gorillor', classe = 'Homme-singe', niveau = 3, experience = 74, prochain_niveau = 75, max_vie = 42, max_charges_oracle = 1, physique = 17, mental = 5, danger = 21, FKarme = 0, FKcostume = 0, FKobjet1 = 0, FKobjet2 = 0, FKobjet3 = 0, FKobjet4 = 0 ");
query(" INSERT INTO nbrpg_persos SET id = 4 , FKmembres = 236, couleur_chat = '#AA66AA', date_creation = 1393925460, nom = 'Eorzea', classe = 'Chevalier', niveau = 6, experience = 44, prochain_niveau = 100, max_vie = 60, max_charges_oracle = 1, physique = 20, mental = 16, danger = 20, FKarme = 0, FKcostume = 0, FKobjet1 = 0, FKobjet2 = 0, FKobjet3 = 0, FKobjet4 = 0 ");
$time = time();
query(" INSERT INTO nbrpg_persos SET id = 5 , FKmembres = 1, couleur_chat = '#66AA66', date_creation = $time, nom = 'Baderon', classe = 'Aventurier', niveau = 1, experience = 0, prochain_niveau = 25, max_vie = 20, physique = 10, max_charges_oracle = 1, mental = 10, danger = 10, FKarme = 0, FKcostume = 0, FKobjet1 = 0, FKobjet2 = 0, FKobjet3 = 0, FKobjet4 = 0 ");

query(" INSERT INTO nbrpg_session SET id = 1 , FKnbrpg_persos = 1 , FKnbrpg_monstres = 0 , vie = 20 , energie = 100 , charges_oracle = 1, physique = 10, mental = 10, danger = 10 ");
query(" INSERT INTO nbrpg_session SET id = 2 , FKnbrpg_persos = 3 , FKnbrpg_monstres = 0 , vie = 42 , energie = 100 , charges_oracle = 1, physique = 17, mental = 5, danger = 21 ");
query(" INSERT INTO nbrpg_session SET id = 3 , FKnbrpg_persos = 4 , FKnbrpg_monstres = 0 , vie = 60 , energie = 100 , charges_oracle = 1, physique = 20, mental = 16, danger = 20 ");
query(" INSERT INTO nbrpg_session SET id = 4 , FKnbrpg_persos = 5 , FKnbrpg_monstres = 0 , vie = 20 , energie = 100 , charges_oracle = 1, physique = 10, mental = 10, danger = 10 ");

query(" INSERT INTO nbrpg_monstres SET id = 1 , nom = 'Bitounette moulée' , max_vie = 94");
query(" INSERT INTO nbrpg_monstres SET id = 2 , nom = 'Clafoutis des forêts' , max_vie = 37");
query(" INSERT INTO nbrpg_monstres SET id = 3 , nom = 'Schnafon' , max_vie = 189");

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