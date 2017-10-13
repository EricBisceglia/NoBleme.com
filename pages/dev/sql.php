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
$header_sidemenu  = 'MajRequetes';

// Titre et description
$page_titre = "Dev: Requêtes SQL";

// Identification
$page_nom = "Administre secrètement le site";




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
// Suppression d'une table

query(" DROP TABLE IF EXISTS vars_globales ");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'un champ dans une table existante

$temp = query(" DESCRIBE vars_globales ");
$temp3 = 0;
while($temp2 = mysqli_fetch_array($temp))
{
  if($temp2['Field'] == 'mise_a_jour')
    $temp3 = 1;
}
if(!$temp3)
  query(" ALTER TABLE vars_globales ADD mise_a_jour MEDIUMTEXT AFTER version ");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renommer un champ dans une table existante

$temp = query(" DESCRIBE stats_pageviews ");
while($temp2 = mysqli_fetch_array($temp))
{
  if($temp2['Field'] == 'id_page')
    query(" ALTER TABLE stats_pageviews CHANGE id_page url_page MEDIUMTEXT ");
}


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
// Nouveau système de pageviews

query(" TRUNCATE TABLE stats_pageviews ");

$temp = query(" DESCRIBE stats_pageviews ");
while($temp2 = mysqli_fetch_array($temp))
{
  if($temp2['Field'] == 'id_page')
    query(" ALTER TABLE stats_pageviews CHANGE id_page url_page MEDIUMTEXT ");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Description multilingue des modérateurs

$temp = query(" DESCRIBE membres ");
while($temp2 = mysqli_fetch_array($temp))
{
  if($temp2['Field'] == 'moderateur_description')
    query(" ALTER TABLE membres CHANGE moderateur_description moderateur_description_fr MEDIUMTEXT ");
}

$temp = query(" DESCRIBE membres ");
$temp3 = 0;
while($temp2 = mysqli_fetch_array($temp))
{
  if($temp2['Field'] == 'moderateur_description_en')
    $temp3 = 1;
}
if(!$temp3)
  query(" ALTER TABLE membres ADD moderateur_description_en MEDIUMTEXT AFTER moderateur_description_fr ");

query(" UPDATE membres SET moderateur_description_en = 'Real life meetups' WHERE moderateur_description_fr LIKE 'Rencontres IRL' ");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Au revoir les stats referer

query(" DROP TABLE IF EXISTS stats_referer ");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On dégage tout le NBRPG pour le moment

query(" DROP TABLE IF EXISTS nbrpg_chatlog ");
query(" DROP TABLE IF EXISTS nbrpg_effets ");
query(" DROP TABLE IF EXISTS nbrpg_monstres ");
query(" DROP TABLE IF EXISTS nbrpg_objets ");
query(" DROP TABLE IF EXISTS nbrpg_persos ");
query(" DROP TABLE IF EXISTS nbrpg_session ");
query(" DROP TABLE IF EXISTS nbrpg_session_effets ");




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