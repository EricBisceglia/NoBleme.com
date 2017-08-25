<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'Dev';
$header_sidemenu  = 'MajRequetes';

// Titre et description
$page_titre = "Dev: Requêtes SQL";

// Identification
$page_nom = "admin";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         TEMPLATES DE REQUÊTES                                                         */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/* Ces modèles sont là pour me souvenir d'une version à l'autre de comment écrire mes changements sans me faire chier à aller dig les logs

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'une table

query(" CREATE TABLE IF NOT EXISTS vars_globales (
          id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          cc    MEDIUMTEXT                                            ,
          tvvmb INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'un champ dans une table existante

if(!@mysqli_query(" SELECT mise_a_jour FROM vars_globales ", 'x'))
  @mysqli_query(" ALTER TABLE vars_globales ADD mise_a_jour MEDIUMTEXT AFTER nbrpg_activite ", 'x');


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Rajout d'une entrée dans un champ

if(!mysqli_num_rows(query(" SELECT id FROM pages WHERE page_nom LIKE 'nobleme' AND page_id LIKE 'activite' ")))
  query(" INSERT INTO pages
          SET         page_nom    = 'nobleme'                       ,
                      page_id     = 'activite'                      ,
                      visite_page = 'Consulte l\'activité récente'  ,
                      visite_url  = 'pages/nobleme/activite'        ");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                               REQUÊTES                                                                */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tout le bordel du NBRPG en attente d'être pushé dans la version publique

/********************************NBRPGTEST*DELETEME**********************/
query(" DROP TABLE IF EXISTS nbrpg_persos ");
query(" DROP TABLE IF EXISTS nbrpg_objets ");
query(" DROP TABLE IF EXISTS nbrpg_monstres ");
query(" DROP TABLE IF EXISTS nbrpg_session ");
query(" DROP TABLE IF EXISTS nbrpg_chatlog ");
query(" DROP TABLE IF EXISTS nbrpg_effets ");
query(" DROP TABLE IF EXISTS nbrpg_session_effets ");
/********************************NBRPGTEST*DELETEME**********************/

query(" CREATE TABLE IF NOT EXISTS nbrpg_persos (
          id                      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          FKmembres               INT(11) UNSIGNED NOT NULL                             ,
          couleur_chat            TINYTEXT                                              ,
          dernier_chat_rp         INT(11) UNSIGNED NOT NULL                             ,
          dernier_chat_hrp        INT(11) UNSIGNED NOT NULL                             ,
          date_creation           INT(11) UNSIGNED NOT NULL                             ,
          nom                     MEDIUMTEXT                                            ,
          niveau                  INT(11) UNSIGNED NOT NULL                             ,
          experience              INT(11) UNSIGNED NOT NULL                             ,
          prochain_niveau         INT(11) UNSIGNED NOT NULL                             ,
          max_vie                 INT(11) UNSIGNED NOT NULL                             ,
          max_charges_oracle      INT(11) UNSIGNED NOT NULL                             ,
          physique                INT(11) UNSIGNED NOT NULL                             ,
          mental                  INT(11) UNSIGNED NOT NULL                             ,
          danger                  INT(11) UNSIGNED NOT NULL                             ,
          niveau_non_assigne      INT(11) UNSIGNED NOT NULL                             ,
          niveau_combat           INT(11) UNSIGNED NOT NULL                             ,
          niveau_magie            INT(11) UNSIGNED NOT NULL                             ,
          niveau_strategie        INT(11) UNSIGNED NOT NULL                             ,
          niveau_medecine         INT(11) UNSIGNED NOT NULL                             ,
          niveau_aventure         INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_objets_arme     INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_objets_costume  INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_objets_objet1   INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_objets_objet2   INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_objets_objet3   INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_objets_objet4   INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");

query(" CREATE TABLE IF NOT EXISTS nbrpg_objets (
          id                              INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          nom                             MEDIUMTEXT                                            ,
          description                     LONGTEXT                                              ,
          flavortext                      LONGTEXT                                              ,
          niveau                          INT(11) UNSIGNED NOT NULL                             ,
          type                            MEDIUMTEXT                                            ,
          rarete                          MEDIUMTEXT                                            ,
          FKnbrpg_effets_passif           INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_effets_passif2          INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_effets_utilisation      INT(11) UNSIGNED NOT NULL                             ,
          effets_utilisation_probabilite  INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_effets_utilisation2     INT(11) UNSIGNED NOT NULL                             ,
          effets_utilisation_probabilite2 INT(11) UNSIGNED NOT NULL                             ,
          type_degats                     MEDIUMTEXT                                            ,
          degats_pourcent_physique        INT(11) UNSIGNED NOT NULL                             ,
          degats_pourcent_mental          INT(11) UNSIGNED NOT NULL                             ,
          attaque_precision               INT(11) UNSIGNED NOT NULL                             ,
          buff_precision                  INT(11) SIGNED NOT NULL                               ,
          buff_hpmax                      INT(11) SIGNED NOT NULL                               ,
          buff_hpmax_pourcent             INT(11) SIGNED NOT NULL                               ,
          buff_danger                     INT(11) SIGNED NOT NULL                               ,
          buff_danger_pourcent            INT(11) SIGNED NOT NULL                               ,
          buff_physique                   INT(11) SIGNED NOT NULL                               ,
          buff_physique_pourcent          INT(11) SIGNED NOT NULL                               ,
          buff_mental                     INT(11) SIGNED NOT NULL                               ,
          buff_mental_pourcent            INT(11) SIGNED NOT NULL                               ,
          reduction_degats                INT(11) SIGNED NOT NULL                               ,
          reduction_degats_pourcent       INT(11) SIGNED NOT NULL
        ) ENGINE=MyISAM; ");

query(" CREATE TABLE IF NOT EXISTS nbrpg_monstres (
          id                        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          nom                       MEDIUMTEXT                                            ,
          type                      MEDIUMTEXT                                            ,
          description_publique      LONGTEXT                                              ,
          max_vie                   INT(11) UNSIGNED NOT NULL                             ,
          type_degats               MEDIUMTEXT                                            ,
          degats_pourcent_physique  INT(11) UNSIGNED NOT NULL                             ,
          degats_pourcent_mental    INT(11) UNSIGNED NOT NULL                             ,
          attaque_precision         INT(11) UNSIGNED NOT NULL                             ,
          physique                  INT(11) UNSIGNED NOT NULL                             ,
          mental                    INT(11) UNSIGNED NOT NULL                             ,
          danger                    INT(11) UNSIGNED NOT NULL                             ,
          resistance_physique       INT(11) SIGNED NOT NULL                               ,
          resistance_magique        INT(11) SIGNED NOT NULL
        ) ENGINE=MyISAM; ");

query(" CREATE TABLE IF NOT EXISTS nbrpg_session (
          id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          FKnbrpg_persos    INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_monstres  INT(11) UNSIGNED NOT NULL                             ,
          monstre_niveau    INT(11) UNSIGNED NOT NULL                             ,
          vie               INT(11) UNSIGNED NOT NULL                             ,
          energie           INT(11) UNSIGNED NOT NULL                             ,
          charges_oracle    INT(11) UNSIGNED NOT NULL                             ,
          physique          INT(11) UNSIGNED NOT NULL                             ,
          mental            INT(11) UNSIGNED NOT NULL                             ,
          danger            INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");

query(" CREATE TABLE IF NOT EXISTS nbrpg_chatlog (
          id        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          timestamp INT(11) UNSIGNED NOT NULL                             ,
          FKmembres INT(11) UNSIGNED NOT NULL                             ,
          nom_perso MEDIUMTEXT                                            ,
          type_chat TINYTEXT                                              ,
          message   LONGTEXT
        ) ENGINE=MyISAM; ");

query(" CREATE TABLE IF NOT EXISTS nbrpg_effets (
          id                                  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          nom                                 MEDIUMTEXT                                            ,
          duree                               INT(11) UNSIGNED NOT NULL                             ,
          description                         LONGTEXT                                              ,
          flavortext                          LONGTEXT                                              ,
          url_icone                           MEDIUMTEXT                                            ,
          supprimer_avant_et_apres_combat     TINYINT(1) UNSIGNED NOT NULL                          ,
          ne_peut_pas_etre_debuff             TINYINT(1) UNSIGNED NOT NULL                          ,
          reduction_effet_par_tour            INT(11) SIGNED NOT NULL                               ,
          reduction_effet_par_tour_pourcent   INT(11) SIGNED NOT NULL                               ,
          paralysie                           TINYINT(1) UNSIGNED NOT NULL                          ,
          degats                              INT(11) SIGNED NOT NULL                               ,
          ne_peut_pas_tuer                    TINYINT(1) UNSIGNED NOT NULL                          ,
          buff_precision                      INT(11) SIGNED NOT NULL                               ,
          buff_degats                         INT(11) SIGNED NOT NULL                               ,
          buff_degats_pourcent                INT(11) SIGNED NOT NULL                               ,
          buff_hpmax                          INT(11) SIGNED NOT NULL                               ,
          buff_hpmax_pourcent                 INT(11) SIGNED NOT NULL                               ,
          buff_danger                         INT(11) SIGNED NOT NULL                               ,
          buff_danger_pourcent                INT(11) SIGNED NOT NULL                               ,
          buff_physique                       INT(11) SIGNED NOT NULL                               ,
          buff_physique_pourcent              INT(11) SIGNED NOT NULL                               ,
          buff_mental                         INT(11) SIGNED NOT NULL                               ,
          buff_mental_pourcent                INT(11) SIGNED NOT NULL                               ,
          reduction_degats                    INT(11) SIGNED NOT NULL                               ,
          reduction_degats_pourcent           INT(11) SIGNED NOT NULL                               ,
          amplification_soins                 INT(11) SIGNED NOT NULL                               ,
          amplification_soins_pourcent        INT(11) SIGNED NOT NULL                               ,
          amplification_soins_recus           INT(11) SIGNED NOT NULL                               ,
          amplification_soins_recus_pourcent  INT(11) SIGNED NOT NULL
        ) ENGINE=MyISAM; ");

query(" CREATE TABLE IF NOT EXISTS nbrpg_session_effets (
          id              INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
          FKnbrpg_session INT(11) UNSIGNED NOT NULL                             ,
          FKnbrpg_effets  INT(11) UNSIGNED NOT NULL                             ,
          duree_restante  INT(11) UNSIGNED NOT NULL
        ) ENGINE=MyISAM; ");



if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nbrpg' AND page_id LIKE 'index' ")))
  query(" INSERT INTO pages
          SET         page_nom    = 'nbrpg'                     ,
                      page_id     = 'index'                     ,
                      visite_page = 'Attend le retour du NBRPG' ,
                      visite_url  = 'pages/nbrpg/index'         ");

if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nbrpg' AND page_id LIKE 'personnages' ")))
  query(" INSERT INTO pages
          SET         page_nom    = 'nbrpg'                         ,
                      page_id     = 'personnages'                   ,
                      visite_page = 'Juge les personnages du NBRPG' ,
                      visite_url  = 'pages/nbrpg/joueurs_actifs'    ");

if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nbrpg' AND page_id LIKE 'client' ")))
  query(" INSERT INTO pages
          SET         page_nom    = 'nbrpg'               ,
                      page_id     = 'client'              ,
                      visite_page = 'Joue au NoBlemeRPG'  ,
                      visite_url  = 'pages/nbrpg/client'  ");


/********************************NBRPGTEST*DELETEME**********************/
query(" INSERT INTO nbrpg_persos SET id = 1 , FKmembres = 47, couleur_chat = '#AAAA66', date_creation = 1394875860, nom = 'Raclette',niveau = 1, experience = 28, prochain_niveau = 50, max_vie = 100, max_charges_oracle = 1, physique = 10, mental = 10, danger = 10 , niveau_non_assigne = 1 ");
query(" INSERT INTO nbrpg_persos SET id = 2 , FKmembres = 234, couleur_chat = '#AA6666', date_creation = 1334875863, nom = 'Bidule', niveau = 3, experience = 0, prochain_niveau = 100, max_vie = 140, max_charges_oracle = 1, physique = 12, mental = 18, danger = 14 , niveau_magie = 2 , niveau_medecine = 1 ");
query(" INSERT INTO nbrpg_persos SET id = 3 , FKmembres = 227, couleur_chat = '#66AAAA', date_creation = 1393925460, nom = 'Gorillor', niveau = 3, experience = 74, prochain_niveau = 75, max_vie = 260, max_charges_oracle = 1, physique = 17, mental = 5, danger = 21 , niveau_combat = 2 , niveau_aventure = 1 ");
query(" INSERT INTO nbrpg_persos SET id = 4 , FKmembres = 236, couleur_chat = '#AA66AA', date_creation = 1393925460, nom = 'Eorzea', niveau = 6, experience = 44, prochain_niveau = 100, max_vie = 350, max_charges_oracle = 1, physique = 20, mental = 16, danger = 20 , niveau_non_assigne = 1 , niveau_combat = 2 , niveau_strategie = 3 ");
$time = time();
query(" INSERT INTO nbrpg_persos SET id = 5 , FKmembres = 1, couleur_chat = '#66AA66', date_creation = $time, nom = 'Baderon', niveau = 1, experience = 0, prochain_niveau = 25, max_vie = 100, physique = 10, max_charges_oracle = 1, mental = 10, danger = 10, FKnbrpg_objets_arme = 1, FKnbrpg_objets_costume = 2, FKnbrpg_objets_objet3 = 3 , niveau_aventure = 1 ");

query(" INSERT INTO nbrpg_objets SET id = 1 , nom = 'Dague paralysante' , description = 'Une dague unique. Inflige 50% de votre physique en dégâts, et augmente votre niveau de danger de 1. 25% de chances d\'appliquer l\'effet poison', flavortext = 'Ne pas lécher la lame, si vous tenez à la vie', niveau = 6, type = 'Arme', rarete = 'Unique', FKnbrpg_effets_utilisation = 1, effets_utilisation_probabilite = 25, type_degats = 'physique' , degats_pourcent_physique = 50, attaque_precision = 80, buff_danger = 1 ");
query(" INSERT INTO nbrpg_objets SET id = 2 , nom = 'Armure de poils' , description = 'Couvert de poils, vous êtes 5% plus résistant, mais aussi 5% plus dangereux' , niveau = 1 , type = 'Costume', rarete = 'Commun' , buff_danger_pourcent = 5, reduction_degats_pourcent = 5 ");
query(" INSERT INTO nbrpg_objets SET id = 3 , nom = 'L\'objet test' , description = 'On teste tout on est fous' , flavortext = 'Ceci n\'est pas un test' , niveau = 42, type = 'Costume' , rarete = 'Unique' , FKnbrpg_effets_passif = 1, FKnbrpg_effets_passif2 = 2, FKnbrpg_effets_utilisation = 3, effets_utilisation_probabilite = 50, FKnbrpg_effets_utilisation2 = 4, effets_utilisation_probabilite2 = 100, type_degats = 'magique' , degats_pourcent_physique = 250, degats_pourcent_mental = 25, attaque_precision = 50, buff_precision = -10, buff_hpmax = 10, buff_hpmax_pourcent = 10, buff_danger = 5, buff_danger_pourcent = 25, buff_physique = -5, buff_physique_pourcent = -15, buff_mental = -1, buff_mental_pourcent = -50, reduction_degats = 5, reduction_degats_pourcent = -10 ");

query(" INSERT INTO nbrpg_session SET id = 1 , FKnbrpg_persos = 1 , FKnbrpg_monstres = 0 , vie = 10 , energie = 100 , charges_oracle = 1, physique = 10, mental = 10, danger = 10 ");
query(" INSERT INTO nbrpg_session SET id = 2 , FKnbrpg_persos = 3 , FKnbrpg_monstres = 0 , vie = 10 , energie = 100 , charges_oracle = 1, physique = 17, mental = 5, danger = 21 ");
query(" INSERT INTO nbrpg_session SET id = 3 , FKnbrpg_persos = 4 , FKnbrpg_monstres = 0 , vie = 10 , energie = 100 , charges_oracle = 1, physique = 20, mental = 16, danger = 20 ");
query(" INSERT INTO nbrpg_session SET id = 4 , FKnbrpg_persos = 5 , FKnbrpg_monstres = 0 , vie = 10 , energie = 100 , charges_oracle = 1, physique = 10, mental = 10, danger = 10 ");

query(" INSERT INTO nbrpg_monstres SET id = 1 , nom = 'Bitounette moulée' , type = 'Commun' , max_vie = 80 , physique = 10 , mental = 5 , danger = 10 , resistance_physique = 10 , resistance_magique = -10 ");
query(" INSERT INTO nbrpg_monstres SET id = 2 , nom = 'Clafoutis des forêts' , type = 'Élite' , max_vie = 60 , physique = 10 , mental = 10 , danger = 10 , resistance_physique = 0 , resistance_magique = -40 ");
query(" INSERT INTO nbrpg_monstres SET id = 3 , nom = 'Schnafon' , type = 'Boss' , max_vie = 300 , physique = 20 , mental = 20 , danger = 20 , resistance_physique = 40 , resistance_magique = 0 ");

query(" INSERT INTO nbrpg_session SET id = 5 , FKnbrpg_persos = 0 , FKnbrpg_monstres = 1 , monstre_niveau = 1 , vie = 10, physique = 10 , mental = 5 , danger = 10 ");
query(" INSERT INTO nbrpg_session SET id = 6 , FKnbrpg_persos = 0 , FKnbrpg_monstres = 1 , monstre_niveau = 3 , vie = 10, physique = 12 , mental = 6 , danger = 5 ");
query(" INSERT INTO nbrpg_session SET id = 7 , FKnbrpg_persos = 0 , FKnbrpg_monstres = 3 , monstre_niveau = 7 , vie = 10, physique = 26 , mental = 26 , danger = 26 ");

query(" INSERT INTO nbrpg_effets SET id = 1 , nom = 'Poison paralysant' , duree = 5 , description = 'Un poison qui coule dans les veines, infligeant 1 dégât chaque tour pendant 5 tours, paralysant totalement, et réduisant le physique de 25% tant qu\'il est actif. Ne peut pas tuer la cible.' , flavortext = 'Fabriqué à partir de véritable sang de raclure, garanti 100% douloureux.' , url_icone = 'effet_goutte.png' , supprimer_avant_et_apres_combat = 1 , degats = 1 , ne_peut_pas_tuer = 1, buff_mental_pourcent = -25 ");
query(" INSERT INTO nbrpg_effets SET id = 2 , nom = 'Bénédiction majeure' , duree = 4 , description = 'Fait briller la lumière divine sur un personnage, le rendant plus fort, plus résistant, et plus dangereux. Il est impossible de retirer ou d\'altérer cet effet positif. L\'effet diminue de 25% chaque tour jusqu\'à ce qu\'il n\'en reste plus rien.' , url_icone = 'effet_plus.png' , supprimer_avant_et_apres_combat = 1 , ne_peut_pas_etre_debuff = 1 , reduction_effet_par_tour_pourcent = 25 , buff_degats_pourcent = 40 , buff_danger_pourcent = 40 , buff_hpmax_pourcent = 40 , buff_physique_pourcent = 40 , reduction_degats_pourcent = 20 ");
query(" INSERT INTO nbrpg_effets SET id = 3 , nom = 'Le buff de test' , duree = 0 , description = 'Pour tester le système de buff/debuff' , flavortext = 'On est fous on remplit tout' , url_icone = 'effet_excla.png' , supprimer_avant_et_apres_combat = 0 , ne_peut_pas_etre_debuff = 1 , reduction_effet_par_tour = 3 , reduction_effet_par_tour_pourcent = 30 , paralysie = 1 , degats = -3 , ne_peut_pas_tuer = 1 , buff_precision = 10, buff_degats = -1 , buff_degats_pourcent = -20 , buff_hpmax = 10 , buff_hpmax_pourcent = -10 , buff_danger = -10 , buff_danger_pourcent = 10 , buff_physique = 10 , buff_physique_pourcent = 10 , buff_mental = -10 , buff_mental_pourcent = -10 , reduction_degats = 5 , reduction_degats_pourcent = -10 , amplification_soins = 5 , amplification_soins_pourcent = 10 , amplification_soins_recus = -10 , amplification_soins_recus_pourcent = -50 ");
query(" INSERT INTO nbrpg_effets SET id = 4 , nom = 'L\'autre buff de test' , duree = 42 , description = 'Pour tester le système de buff/debuff' , flavortext = 'On est fous on remplit tout' , url_icone = 'effet_interro.png' , supprimer_avant_et_apres_combat = 0 , ne_peut_pas_etre_debuff = 0 , reduction_effet_par_tour = -3 , reduction_effet_par_tour_pourcent = -30 , paralysie = 0 , degats = 3 , ne_peut_pas_tuer = -1 , buff_precision = -10, buff_degats = 1 , buff_degats_pourcent = 20 , buff_hpmax = -10 , buff_hpmax_pourcent = 10 , buff_danger = 10 , buff_danger_pourcent = -10 , buff_physique = -10 , buff_physique_pourcent = -10 , buff_mental = 10 , buff_mental_pourcent = 10 , reduction_degats = -5 , reduction_degats_pourcent = 10 , amplification_soins = -10 , amplification_soins_pourcent = -10 , amplification_soins_recus = 1 , amplification_soins_recus_pourcent = 20 ");

query(" INSERT INTO nbrpg_session_effets SET id = 1 , FKnbrpg_session = 2 , FKnbrpg_effets = 1 , duree_restante = 2 ");
query(" INSERT INTO nbrpg_session_effets SET id = 2 , FKnbrpg_session = 3 , FKnbrpg_effets = 1 , duree_restante = 3 ");
query(" INSERT INTO nbrpg_session_effets SET id = 3 , FKnbrpg_session = 3 , FKnbrpg_effets = 2 , duree_restante = 4 ");
query(" INSERT INTO nbrpg_session_effets SET id = 4 , FKnbrpg_session = 4 , FKnbrpg_effets = 2 , duree_restante = 1 ");
query(" INSERT INTO nbrpg_session_effets SET id = 5 , FKnbrpg_session = 1 , FKnbrpg_effets = 3 , duree_restante = 0 ");
query(" INSERT INTO nbrpg_session_effets SET id = 6 , FKnbrpg_session = 1 , FKnbrpg_effets = 4 , duree_restante = 1 ");
query(" INSERT INTO nbrpg_session_effets SET id = 7 , FKnbrpg_session = 1 , FKnbrpg_effets = 4 , duree_restante = 42 ");
query(" INSERT INTO nbrpg_session_effets SET id = 8 , FKnbrpg_session = 1 , FKnbrpg_effets = 4 , duree_restante = 42 ");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <br>
      <br>
      <br>
      <br>
      <br>
      <br>

      <div class="texte">

        <h1 class="positif texte_blanc align_center">LES REQUÊTES ONT ÉTÉ EFFECTUÉES AVEC SUCCÈS</h1>

      </div>

      <br>
      <br>
      <br>
      <br>
      <br>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';