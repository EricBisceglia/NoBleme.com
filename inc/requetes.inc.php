<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Cette page contient les requêtes à effectuer lors d'une mise à jour afin de faire des changements structurels sur le site             //
// Elle ne peut être appelée que par un administrateur via la page /pages/dev/requetes                                                   //
// Les requêtes ne sont pas conservées d'une mise à jour à l'autre.                                                                      //
// À la place, il faut importer la structure de données du site depuis le fichier sqldump.php qui se trouve à la racine du site          //
//                                                                                                                                       //
//                                            !!!!! PENSER À METTRE À JOUR SQLDUMP.PHP !!!!!                                             //
//                                                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Indexs manquants dans les tables précédentes

sql_creer_index('automatisation', 'index_action', 'action_id');

sql_creer_index('ecrivains_concours', 'index_gagnant', 'FKecrivains_texte_gagnant, FKmembres_gagnant');

sql_creer_index('ecrivains_concours_vote', 'index_texte', 'FKecrivains_concours');
sql_creer_index('ecrivains_concours_vote', 'index_concours', 'FKecrivains_texte');
sql_creer_index('ecrivains_concours_vote', 'index_membre', 'FKmembres');
sql_creer_index('ecrivains_concours_vote', 'index_poids', 'poids_vote, FKmembres, FKecrivains_texte, FKecrivains_concours');

sql_creer_index('ecrivains_note', 'index_texte', 'FKecrivains_texte');
sql_creer_index('ecrivains_note', 'index_membre', 'FKmembres');
sql_creer_index('ecrivains_note', 'index_note', 'note');

sql_creer_index('ecrivains_texte', 'index_auteur', 'anonyme, FKmembres');
sql_creer_index('ecrivains_texte', 'index_concours', 'FKecrivains_concours');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Pages

sql_creer_table('nbdb_web_page');

sql_creer_champ('nbdb_web_page', 'FKnbdb_web_periode', 'INT(11) UNSIGNED NOT NULL', 'id');
sql_creer_champ('nbdb_web_page', 'titre_fr', 'MEDIUMTEXT', 'FKnbdb_web_periode');
sql_creer_champ('nbdb_web_page', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
sql_creer_champ('nbdb_web_page', 'redirection_fr', 'MEDIUMTEXT', 'titre_en');
sql_creer_champ('nbdb_web_page', 'redirection_en', 'MEDIUMTEXT', 'redirection_fr');
sql_creer_champ('nbdb_web_page', 'contenu_fr', 'LONGTEXT', 'redirection_en');
sql_creer_champ('nbdb_web_page', 'contenu_en', 'LONGTEXT', 'contenu_fr');
sql_creer_champ('nbdb_web_page', 'date_apparition', 'DATE', 'contenu_en');
sql_creer_champ('nbdb_web_page', 'date_popularisation', 'DATE', 'date_apparition');
sql_creer_champ('nbdb_web_page', 'est_vulgaire', 'TINYINT(1)', 'date_popularisation');
sql_creer_champ('nbdb_web_page', 'est_politise', 'TINYINT(1)', 'est_vulgaire');
sql_creer_champ('nbdb_web_page', 'est_incorrect', 'TINYINT(1)', 'est_politise');

sql_creer_index('nbdb_web_page', 'index_periode', 'FKnbdb_web_periode');
sql_creer_index('nbdb_web_page', 'index_apparition', 'date_apparition');
sql_creer_index('nbdb_web_page', 'index_popularisation', 'date_popularisation');
sql_creer_index('nbdb_web_page', 'index_titre_fr', 'titre_fr (25)');
sql_creer_index('nbdb_web_page', 'index_titre_en', 'titre_en (25)');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Définitions

sql_creer_table('nbdb_web_definition');

sql_creer_champ('nbdb_web_definition', 'titre_fr', 'MEDIUMTEXT', 'id');
sql_creer_champ('nbdb_web_definition', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
sql_creer_champ('nbdb_web_definition', 'redirection_fr', 'MEDIUMTEXT', 'titre_en');
sql_creer_champ('nbdb_web_definition', 'redirection_en', 'MEDIUMTEXT', 'redirection_fr');
sql_creer_champ('nbdb_web_definition', 'definition_fr', 'LONGTEXT', 'redirection_en');
sql_creer_champ('nbdb_web_definition', 'definition_en', 'LONGTEXT', 'definition_fr');
sql_creer_champ('nbdb_web_definition', 'est_vulgaire', 'TINYINT(1)', 'definition_en');
sql_creer_champ('nbdb_web_definition', 'est_politise', 'TINYINT(1)', 'est_vulgaire');
sql_creer_champ('nbdb_web_definition', 'est_incorrect', 'TINYINT(1)', 'est_politise');

sql_creer_index('nbdb_web_definition', 'index_titre_fr', 'titre_fr (25)');
sql_creer_index('nbdb_web_definition', 'index_titre_en', 'titre_en (25)');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Périodes

sql_creer_table('nbdb_web_periode');

sql_creer_champ('nbdb_web_periode', 'titre_fr', 'MEDIUMTEXT', 'id');
sql_creer_champ('nbdb_web_periode', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
sql_creer_champ('nbdb_web_periode', 'description_fr', 'MEDIUMTEXT', 'titre_en');
sql_creer_champ('nbdb_web_periode', 'description_en', 'MEDIUMTEXT', 'description_fr');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Catégories

sql_creer_table('nbdb_web_categorie');

sql_creer_champ('nbdb_web_categorie', 'titre_fr', 'MEDIUMTEXT', 'id');
sql_creer_champ('nbdb_web_categorie', 'titre_en', 'MEDIUMTEXT', 'titre_fr');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Catégories des pages, définitions, et images

sql_creer_table('nbdb_web_categorie_contenu');

sql_creer_champ('nbdb_web_categorie_contenu', 'FKnbdb_web_categorie', 'INT(11) UNSIGNED NOT NULL', 'id');
sql_creer_champ('nbdb_web_categorie_contenu', 'FKnbdb_web_page', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_categorie');
sql_creer_champ('nbdb_web_categorie_contenu', 'FKnbdb_web_definition', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_page');
sql_creer_champ('nbdb_web_categorie_contenu', 'FKnbdb_web_image', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_definition');

sql_creer_index('nbdb_web_categorie_contenu', 'index_pages', 'FKnbdb_web_page, FKnbdb_web_categorie');
sql_creer_index('nbdb_web_categorie_contenu', 'index_definitions', 'FKnbdb_web_definition, FKnbdb_web_categorie');
sql_creer_index('nbdb_web_categorie_contenu', 'index_images', 'FKnbdb_web_image, FKnbdb_web_categorie');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Images

sql_creer_table('nbdb_web_image');

sql_creer_champ('nbdb_web_image', 'url', 'TEXT', 'id');
sql_creer_champ('nbdb_web_image', 'titre_fr', 'MEDIUMTEXT', 'url');
sql_creer_champ('nbdb_web_image', 'titre_en', 'MEDIUMTEXT', 'titre_fr');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Images liées à une page

sql_creer_table('nbdb_web_image_page');

sql_creer_champ('nbdb_web_image_page', 'FKnbdb_web_image', 'INT(11) UNSIGNED NOT NULL', 'id');
sql_creer_champ('nbdb_web_image_page', 'FKnbdb_web_page', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_image');
sql_creer_champ('nbdb_web_image_page', 'ordre_affichage', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_page');
sql_creer_champ('nbdb_web_image_page', 'titre_fr', 'MEDIUMTEXT', 'ordre_affichage');
sql_creer_champ('nbdb_web_image_page', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
sql_creer_champ('nbdb_web_image_page', 'description_fr', 'MEDIUMTEXT', 'titre_en');
sql_creer_champ('nbdb_web_image_page', 'description_en', 'MEDIUMTEXT', 'description_fr');

sql_creer_index('nbdb_web_image_page', 'index_images', 'FKnbdb_web_page, FKnbdb_web_image');
sql_creer_index('nbdb_web_image_page', 'index_affichage', 'ordre_affichage');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Historique des changements

sql_creer_table('nbdb_web_historique');

sql_creer_champ('nbdb_web_historique', 'FKnbdb_web_page', 'INT(11) UNSIGNED NOT NULL', 'id');
sql_creer_champ('nbdb_web_historique', 'public', 'TINYINT(1) NOT NULL', 'FKnbdb_web_page');
sql_creer_champ('nbdb_web_historique', 'timestamp', 'INT(11) UNSIGNED NOT NULL', 'public');
sql_creer_champ('nbdb_web_historique', 'type_historique', 'TEXT', 'timestamp');
sql_creer_champ('nbdb_web_historique', 'diff_avant', 'TEXT', 'type_historique');
sql_creer_champ('nbdb_web_historique', 'diff_apres', 'TEXT', 'diff_avant');

sql_creer_index('nbdb_web_historique', 'index_timestamp', 'timestamp');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                      FONCTIONS POUR LES REQUÊTES                                                      */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/*   Ces fonctions permettent d'effectuer des modifications structurelles sur la base de données, à ne pas utiliser hors de ce fichier   */
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/* Liste des fonctions contenues dans ce fichier:                                                                                        */
/* sql_creer_table($nom_table);                                                                                                          */
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
// Création d'une table contenant uniquement un champ nommé 'id' (clé primaire, auto increment, etc.)
//
// Exemple: sql_creer_table("nom_table");

function sql_creer_table($nom_table)
{
  return query(" CREATE TABLE IF NOT EXISTS ".$nom_table." ( id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ) ENGINE=MyISAM;");
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
// Exemple: sql_creer_champ("nom_table", "cc2", "INT(11) UNSIGNED NOT NULL", "cc");

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