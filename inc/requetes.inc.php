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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                                       //
//                                            !!!!! PENSER À METTRE À JOUR SQLDUMP.PHP !!!!!                                             //
//                                                                                                                                       //
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dernière activité des membres

sql_creer_champ('membres', 'derniere_activite', 'INT(11) UNSIGNED NOT NULL', 'derniere_visite_ip');




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