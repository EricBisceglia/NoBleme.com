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
/*                                                               REQUÊTES                                                                */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Passage global de l'utf8 à l'utf8mb4 pour gérer les emojis et autres conneries

query(" ALTER DATABASE nobleme CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci; ");

query(" ALTER TABLE activite CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite CHANGE pseudonyme pseudonyme TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite CHANGE action_type action_type TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite CHANGE action_titre action_titre MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite CHANGE parent parent MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite CHANGE justification justification TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE activite_diff CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite_diff CHANGE titre_diff titre_diff TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite_diff CHANGE diff_avant diff_avant LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE activite_diff CHANGE diff_apres diff_apres LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE devblog CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE devblog CHANGE titre titre MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE devblog CHANGE contenu contenu LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE forum_categorie CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_categorie CHANGE nom_fr nom_fr TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_categorie CHANGE nom_en nom_en TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_categorie CHANGE description_fr description_fr MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_categorie CHANGE description_en description_en MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE forum_filtrage CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE forum_message CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_message CHANGE contenu contenu LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE forum_sujet CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_sujet CHANGE apparence apparence TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_sujet CHANGE classification classification TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_sujet CHANGE langage langage TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE forum_sujet CHANGE titre titre MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE invites CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE invites CHANGE ip ip VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE invites CHANGE surnom surnom MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE invites CHANGE derniere_visite_page derniere_visite_page MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE invites CHANGE derniere_visite_url derniere_visite_url MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE irc_canaux CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irc_canaux CHANGE canal canal TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irc_canaux CHANGE langue langue TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irc_canaux CHANGE description_fr description_fr MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irc_canaux CHANGE description_en description_en MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE irl CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl CHANGE lieu lieu TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl CHANGE raison_fr raison_fr TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl CHANGE raison_en raison_en TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl CHANGE details_fr details_fr LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl CHANGE details_en details_en LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE irl_participants CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl_participants CHANGE pseudonyme pseudonyme TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl_participants CHANGE details_fr details_fr TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE irl_participants CHANGE details_en details_en TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE membres CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE pseudonyme pseudonyme TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE pass pass MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE moderateur moderateur MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE moderateur_description_fr moderateur_description_fr MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE moderateur_description_en moderateur_description_en MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE email email TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE derniere_visite_page derniere_visite_page MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE derniere_visite_url derniere_visite_url MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE derniere_visite_ip derniere_visite_ip TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE banni_raison banni_raison MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE langue langue TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE genre genre TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE habite habite TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE metier metier TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE profil profil LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres CHANGE forum_lang forum_lang TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE membres_essais_login CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE membres_essais_login CHANGE ip ip TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE notifications CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE notifications CHANGE titre titre MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE notifications CHANGE contenu contenu LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE pageviews CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE pageviews CHANGE nom_page nom_page MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE pageviews CHANGE url_page url_page MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE quotes CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE quotes CHANGE contenu contenu LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE quotes_membres CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE todo CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE todo CHANGE titre titre MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE todo CHANGE contenu contenu LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE todo CHANGE source source MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE todo_categorie CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE todo_categorie CHANGE categorie categorie TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE todo_roadmap CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE todo_roadmap CHANGE version version TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE todo_roadmap CHANGE description description MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE vars_globales CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");

query(" ALTER TABLE version CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE version CHANGE version version TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");
query(" ALTER TABLE version CHANGE build build TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                      FONCTIONS POUR LES REQUÊTES                                                      */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/*   Ces fonctions permettent d'effectuer des modifications structurelles sur la base de données, à ne pas utiliser hors de ce fichier   */
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/* Liste des fonctions contenues dans ce fichier:                                                                                        */
/* sql_creer_table($nom_table, $requete);                                                                                                */
/* sql_renommer_table($nom_table, $nouveau_nom);                                                                                         */
/* sql_vider_table($nom_table);                                                                                                          */
/* sql_supprimer_table($nom_table);                                                                                                      */
/* sql_creer_champ($nom_table, $nom_champ, $type_champ, $after_nom_champ);                                                               */
/* sql_renommer_champ($nom_table, $ancien_nom_champ, $nouveau_nom_champ, $type_champ);                                                   */
/* sql_changer_type_champ($nom_table, $nom_champ, $type_champ)                                                                           */
/* sql_supprimer_champ($nom_table, $nom_champ);                                                                                          */
/* sql_creer_index($nom_table, $nom_index, $nom_champs, $fulltext);                                                                      */
/* sql_insertion_valeur($condition, $requete);                                                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'une table
//
/* Exemple:
sql_creer_table("nom_table", "  id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
                                cc    MEDIUMTEXT                                            ,
                                tvvmb INT(11) UNSIGNED NOT NULL                             ");
*/

function sql_creer_table($nom_table, $requete)
{
  return query(" CREATE TABLE IF NOT EXISTS ".$nom_table." ( ".$requete." ) ENGINE=MyISAM;");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renommer une table
//
// Exemple: sql_renommer_table("nom_table", "nouveau_nom");

function sql_renommer_table($nom_table, $nouveau_nom)
{
  // Si la table existe, on la renomme
  if(query(" DESCRIBE ".$nom_table, 1))
    query(" ALTER TABLE $nom_table RENAME $nouveau_nom ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vidange d'une table
//
// Exemple: sql_vider_table("nom_table");

function sql_vider_table($nom_table)
{
  // On vérifie que la table existe
  if(!query(" DESCRIBE ".$nom_table, 1))
    return;

  // Puis on la vide
  query(" TRUNCATE TABLE ".$nom_table);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une table
//
// Exemple: sql_supprimer_table("nom_table");

function sql_supprimer_table($nom_table)
{
  query(" DROP TABLE IF EXISTS ".$nom_table);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'un champ dans une table existante
//
// Exemple: sql_creer_champ("nom_table", "cc2", "MEDIUMTEXT", "cc");

function sql_creer_champ($nom_table, $nom_champ, $type_champ, $after_nom_champ)
{
  // On vérifie que la table existe
  if(!query(" DESCRIBE ".$nom_table, 1))
    return;

  // On a besoin de la structure de la table
  $qdescribe = query(" DESCRIBE ".$nom_table);

  // Si le champ après lequel placer ce champ n'existe pas, on s'arrête là
  $i = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $i = ($ddescribe['Field'] == $after_nom_champ) ? 1 : $i;
  if(!$i)
    return;

  // On a besoin une nouvelle fois de la structure de la table
  $qdescribe = query(" DESCRIBE ".$nom_table);

  // On va tester si le champ existe déjà
  $i = 0;
  while($ddescribe = mysqli_fetch_array($qdescribe))
    $i = ($ddescribe['Field'] == $nom_champ) ? 1 : $i;

  // S'il n'existe pas, on fait la requête
  if(!$i)
    query(" ALTER TABLE ".$nom_table." ADD ".$nom_champ." ".$type_champ." AFTER ".$after_nom_champ);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renommer un champ dans une table existante
//
// Exemple: sql_renommer_champ("nom_table", "cc2", "cc3", "MEDIUMTEXT");

function sql_renommer_champ($nom_table, $ancien_nom_champ, $nouveau_nom_champ, $type_champ)
{
  // On vérifie que la table existe
  if(!query(" DESCRIBE ".$nom_table, 1))
    return;

  // On a besoin de la structure de la table
  $qdescribe = query(" DESCRIBE ".$nom_table);

  // Si le nouveau nom du champ existe déjà, on s'arrête là
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if ($ddescribe['Field'] == $nouveau_nom_champ)
      return;
  }

  // On a besoin une nouvelle fois de la structure de la table
  $qdescribe = query(" DESCRIBE ".$nom_table);

  // Si le champ existe dans la table, on le renomme
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $ancien_nom_champ)
      query(" ALTER TABLE ".$nom_table." CHANGE ".$ancien_nom_champ." ".$nouveau_nom_champ." ".$type_champ);
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Changer le type d'un champ dans une table existante
//
// Exemple: sql_changer_type_champ("nom_table", "cc2", "MEDIUMTEXT");

function sql_changer_type_champ($nom_table, $nom_champ, $type_champ)
{
  // On vérifie que la table existe
  if(!query(" DESCRIBE ".$nom_table, 1))
    return;

  // On a besoin une nouvelle fois de la structure de la table
  $qdescribe = query(" DESCRIBE ".$nom_table);

  // Si le champ existe dans la table, on le renomme
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $nom_champ)
      query(" ALTER TABLE ".$nom_table." MODIFY ".$nom_champ." ".$type_champ);
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un champ dans une table existante
//
// Exemple: sql_supprimer_champ("nom_table", "tvvmb");

function sql_supprimer_champ($nom_table, $nom_champ)
{
  // On vérifie que la table existe
  if(!query(" DESCRIBE ".$nom_table, 1))
    return;

  // On a besoin de la structure de la table
  $qdescribe = query(" DESCRIBE ".$nom_table);

  // Si le champ existe dans la table, on le supprime
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == $nom_champ)
      query(" ALTER TABLE ".$nom_table." DROP ".$nom_champ);
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Création d'un index dans une table existante
//
// Exemple: sql_creer_index("nom_table", "index_cc", "cc, tvvmb(10)")

function sql_creer_index($nom_table, $nom_index, $nom_champs, $fulltext=NULL)
{
  // On va chercher si l'index existe
  $qindex = query(" SHOW INDEX FROM ".$nom_table." WHERE key_name LIKE '".$nom_index."' ");

  // S'il existe pas, on le crée
  if(!mysqli_num_rows($qindex))
  {
    $temp_fulltext = ($fulltext) ? ' FULLTEXT ' : '';
    query(" ALTER TABLE ".$nom_table."
            ADD ".$temp_fulltext." INDEX ".$nom_index." (".$nom_champs."); ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'une entrée dans une table
//
/* Exemple :
sql_insertion_valeur(" SELECT cc, tvvmb FROM nom_table WHERE cc LIKE 'test' AND tvvmb = 1 ",
" INSERT INTO nom_table
  SET         cc    = 'test'  ,
              tvvmb = 1       ");
*/

function sql_insertion_valeur($condition, $requete)
{
  // Si l'entrée n'existe pas déjà, on insère
  if(!mysqli_num_rows(query($condition)))
    query($requete);
}




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