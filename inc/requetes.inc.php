<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Besoin global : Récupération de l'id de dernière requete

$derniere_requete = sql_check_id_requete();




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
// #543 - Historique des requêtes SQL

// Je laisse volontairement ce bloc de commentaires pour avoir une référence à la prochaine requête
// Cette requête se trouve également en bas du fichier

/*
if($derniere_requete < 16)
{
  sql_creer_champ("vars_globales", "derniere_requete_sql", "TINYINT(1) NOT NULL", "mise_a_jour");
  sql_update_id_requete(16);
}
*/




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                      FONCTIONS POUR LES REQUÊTES                                                      */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/*   Ces fonctions permettent d'effectuer des modifications structurelles sur la base de données, à ne pas utiliser hors de ce fichier   */
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/* Liste des fonctions contenues dans ce fichier:                                                                                        */
/*                                                                                                                                       */
/* sql_check_id_requete();                                                                                                            */
/* sql_update_id_requete($id);                                                                                                           */
/*                                                                                                                                       */
/* sql_creer_table($nom_table);                                                                                                          */
/* sql_renommer_table($nom_table, $nouveau_nom);                                                                                         */
/* sql_vider_table($nom_table);                                                                                                          */
/* sql_supprimer_table($nom_table);                                                                                                      */
/*                                                                                                                                       */
/* sql_creer_champ($nom_table, $nom_champ, $type_champ, $after_nom_champ);                                                               */
/* sql_renommer_champ($nom_table, $ancien_nom_champ, $nouveau_nom_champ, $type_champ);                                                   */
/* sql_changer_type_champ($nom_table, $nom_champ, $type_champ)                                                                           */
/* sql_supprimer_champ($nom_table, $nom_champ);                                                                                          */
/*                                                                                                                                       */
/* sql_creer_index($nom_table, $nom_index, $nom_champs, $fulltext);                                                                      */
/*                                                                                                                                       */
/* sql_insertion_valeur($condition, $requete);                                                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérifie si une requête va être jouée ou non
//
// Exemple : sql_check_id_requete();

function sql_check_id_requete()
{
  // On vérifie que la table existe
  if(!query(" DESCRIBE vars_globales ", 1))
    return 0;

  // Si oui, il nous faut la structure de la table
  $qdescribe = query(" DESCRIBE vars_globales");

  // On part du principe qu'on a pas le droit de faire la requête
  $requete_ok = 0;

  // On vérifie que le champ existe
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == "derniere_requete_sql")
      $requete_ok = 1;
  }

  // Si on a pas le droit de faire la requête, on s'arrête là
  if(!$requete_ok)
    return 0;

  // On peut maintenant récupérer l'id de la dernière requête passée
  $derniere_requete = mysqli_fetch_array(query("  SELECT    vars_globales.derniere_requete_sql
                                                  FROM      vars_globales
                                                  ORDER BY  vars_globales.derniere_requete_sql DESC
                                                  LIMIT     1 "));

  // Reste plus qu'à renvoyer cette valeur
  return $derniere_requete['derniere_requete_sql'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Met à jour l'id de la dernière requête jouée
//
// Exemple : sql_update_id_requete(69);

function sql_update_id_requete($id)
{
  // On vérifie que la table existe
  if(!query(" DESCRIBE vars_globales ", 1))
    return;

  // Si oui, il nous faut la structure de la table
  $qdescribe = query(" DESCRIBE vars_globales");

  // On part du principe que le champ n'existe pas
  $requete_ok = 0;

  // On vérifie que le champ existe
  while($ddescribe = mysqli_fetch_array($qdescribe))
  {
    if($ddescribe['Field'] == "derniere_requete_sql")
      $requete_ok = 1;
  }

  // Si le champ n'existe pas, on s'arrête là
  if(!$requete_ok)
    return;

  // Assainissement de la demande
  $id = postdata($id, "int", 0);

  // Mise à jour de l'id
  query(" UPDATE  vars_globales
          SET     vars_globales.derniere_requete_sql = $id ");
}




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




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        HISTORIQUE DES REQUÊTES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                Permet de rejouer toutes les requêtes qui ne se sont pas encore jouées,                                */
/*                      afin d'assurer une montée de version depuis n'importe quelle version précédente de NoBleme                       */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 5                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
// Changement structurel du coin des écrivains

if($derniere_requete < 1)
{
  sql_supprimer_champ('ecrivains_concours', 'FKforum_sujet');
  sql_renommer_champ('ecrivains_concours', 'date_debut', 'timestamp_debut', 'INT(11) UNSIGNED NOT NULL');
  sql_renommer_champ('ecrivains_concours', 'date_fin', 'timestamp_fin', 'INT(11) UNSIGNED NOT NULL');

  sql_creer_champ('ecrivains_concours', 'FKmembres_gagnant', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_creer_champ('ecrivains_concours', 'FKecrivains_texte_gagnant', 'INT(11) UNSIGNED NOT NULL', 'FKmembres_gagnant');
  sql_creer_champ('ecrivains_concours', 'num_participants', 'INT(11) UNSIGNED NOT NULL', 'timestamp_fin');
  sql_creer_champ('ecrivains_concours_vote', 'poids_vote', 'INT(11) UNSIGNED NOT NULL', 'FKmembres');
}
sql_update_id_requete(1);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Table pour les cron

if($derniere_requete < 2)
{
  sql_creer_table("automatisation", " id                  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
                                      action_id           INT(11) UNSIGNED NOT NULL                             ,
                                      action_type         MEDIUMTEXT                                            ,
                                      action_description  MEDIUMTEXT                                            ,
                                      action_timestamp    INT(11) UNSIGNED NOT NULL                             ");
}
sql_update_id_requete(2);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 6                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
// #505 - Rendre les miscellanées bilingues// Indexs fulltext pour les recherches dans la NBDB

if($derniere_requete < 3)
{
  sql_creer_index('nbdb_web_page', 'index_contenu_en', 'contenu_en', 1);
  sql_creer_index('nbdb_web_page', 'index_contenu_fr', 'contenu_fr', 1);

  sql_creer_index('nbdb_web_definition', 'index_definition_en', 'definition_en', 1);
  sql_creer_index('nbdb_web_definition', 'index_definition_fr', 'definition_fr', 1);

  sql_creer_index('nbdb_web_categorie', 'index_description_fr', 'description_fr', 1);
  sql_creer_index('nbdb_web_categorie', 'index_description_en', 'description_en', 1);

  sql_creer_index('nbdb_web_definition', 'index_definition_fr', 'definition_fr', 1);
  sql_creer_index('nbdb_web_definition', 'index_definition_en', 'definition_en', 1);
}
sql_update_id_requete(3);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Indexs manquants

if($derniere_requete < 4)
{
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
}
sql_update_id_requete(4);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Pages

if($derniere_requete < 5)
{
  sql_creer_table('nbdb_web_page');

  sql_creer_champ('nbdb_web_page', 'FKnbdb_web_periode', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_creer_champ('nbdb_web_page', 'titre_fr', 'MEDIUMTEXT', 'FKnbdb_web_periode');
  sql_creer_champ('nbdb_web_page', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
  sql_creer_champ('nbdb_web_page', 'redirection_fr', 'MEDIUMTEXT', 'titre_en');
  sql_creer_champ('nbdb_web_page', 'redirection_en', 'MEDIUMTEXT', 'redirection_fr');
  sql_creer_champ('nbdb_web_page', 'contenu_fr', 'LONGTEXT', 'redirection_en');
  sql_creer_champ('nbdb_web_page', 'contenu_en', 'LONGTEXT', 'contenu_fr');
  sql_creer_champ('nbdb_web_page', 'annee_apparition', 'INT(4)', 'contenu_en');
  sql_creer_champ('nbdb_web_page', 'mois_apparition', 'INT(2)', 'annee_apparition');
  sql_creer_champ('nbdb_web_page', 'annee_popularisation', 'INT(4)', 'mois_apparition');
  sql_creer_champ('nbdb_web_page', 'mois_popularisation', 'INT(2)', 'annee_popularisation');
  sql_creer_champ('nbdb_web_page', 'est_vulgaire', 'TINYINT(1)', 'mois_popularisation');
  sql_creer_champ('nbdb_web_page', 'est_politise', 'TINYINT(1)', 'est_vulgaire');
  sql_creer_champ('nbdb_web_page', 'est_incorrect', 'TINYINT(1)', 'est_politise');

  sql_creer_index('nbdb_web_page', 'index_periode', 'FKnbdb_web_periode');
  sql_creer_index('nbdb_web_page', 'index_apparition', 'annee_apparition, mois_apparition');
  sql_creer_index('nbdb_web_page', 'index_popularisation', 'annee_popularisation, mois_popularisation');
  sql_creer_index('nbdb_web_page', 'index_titre_fr', 'titre_fr (25)');
  sql_creer_index('nbdb_web_page', 'index_titre_en', 'titre_en (25)');
}
sql_update_id_requete(5);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Définitions

if($derniere_requete < 6)
{
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
}
sql_update_id_requete(6);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Périodes

if($derniere_requete < 7)
{
  sql_creer_table('nbdb_web_periode');

  sql_creer_champ('nbdb_web_periode', 'titre_fr', 'MEDIUMTEXT', 'id');
  sql_creer_champ('nbdb_web_periode', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
  sql_creer_champ('nbdb_web_periode', 'description_fr', 'MEDIUMTEXT', 'titre_en');
  sql_creer_champ('nbdb_web_periode', 'description_en', 'MEDIUMTEXT', 'description_fr');
  sql_creer_champ('nbdb_web_periode', 'annee_debut', 'INT(4)', 'description_en');
  sql_creer_champ('nbdb_web_periode', 'annee_fin', 'INT(4)', 'annee_debut');
}
sql_update_id_requete(7);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Catégories

if($derniere_requete < 8)
{
  sql_creer_table('nbdb_web_categorie');

  sql_creer_champ('nbdb_web_categorie', 'titre_fr', 'MEDIUMTEXT', 'id');
  sql_creer_champ('nbdb_web_categorie', 'titre_en', 'MEDIUMTEXT', 'titre_fr');
  sql_creer_champ('nbdb_web_categorie', 'ordre_affichage', 'INT(11) UNSIGNED NOT NULL', 'titre_en');
  sql_creer_champ('nbdb_web_categorie', 'description_fr', 'MEDIUMTEXT', 'ordre_affichage');
  sql_creer_champ('nbdb_web_categorie', 'description_en', 'MEDIUMTEXT', 'description_fr');

  sql_creer_index('nbdb_web_categorie', 'index_ordre_affichage', 'ordre_affichage');
}
sql_update_id_requete(8);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Catégories des pages

if($derniere_requete < 9)
{
  sql_creer_table('nbdb_web_page_categorie');

  sql_creer_champ('nbdb_web_page_categorie', 'FKnbdb_web_page', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_creer_champ('nbdb_web_page_categorie', 'FKnbdb_web_categorie', 'INT(11) UNSIGNED NOT NULL', 'FKnbdb_web_page');

  sql_creer_index('nbdb_web_page_categorie', 'index_pages', 'FKnbdb_web_page, FKnbdb_web_categorie');
}
sql_update_id_requete(9);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Nouvelle table : NBDB - Encyclopédie du web - Images

if($derniere_requete < 10)
{
  sql_creer_table('nbdb_web_image');

  sql_creer_champ('nbdb_web_image', 'timestamp_upload', 'INT(11) UNSIGNED NOT NULL', 'id');
  sql_creer_champ('nbdb_web_image', 'nom_fichier', 'MEDIUMTEXT', 'timestamp_upload');
  sql_creer_champ('nbdb_web_image', 'tags', 'MEDIUMTEXT', 'nom_fichier');
}
sql_update_id_requete(10);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 7                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
// #505 - Rendre les miscellanées bilingues

if($derniere_requete < 11)
{
  sql_creer_champ('quotes', 'langue', 'TINYTEXT', 'timestamp');

  query(" UPDATE  quotes
          SET     quotes.langue = 'FR'
          WHERE   quotes.langue IS NULL ");

  query(" UPDATE  activite
          SET     activite.action_type  =     'quote_new_fr'
          WHERE   activite.action_type  LIKE  'quote' ");
}
sql_update_id_requete(11);



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dernière activité des membres

if($derniere_requete < 12)
  sql_creer_champ('membres', 'derniere_activite', 'INT(11) UNSIGNED NOT NULL', 'derniere_visite_ip');
sql_update_id_requete(12);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 8                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
// #496 - Option pour désactiver google trends

if($derniere_requete < 13)
{
  sql_creer_champ('membres', 'voir_tweets', 'TINYINT(1)', 'voir_nsfw');
  sql_creer_champ('membres', 'voir_youtube', 'TINYINT(1)', 'voir_tweets');
  sql_creer_champ('membres', 'voir_google_trends', 'TINYINT(1)', 'voir_youtube');
}
sql_update_id_requete(13);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #477 - Permettre de tag des contenus de la NBDB comme NSFW

if($derniere_requete < 14)
{
  sql_creer_champ('nbdb_web_page', 'contenu_floute', 'TINYINT(1)', 'mois_popularisation');
  sql_creer_champ('nbdb_web_definition', 'contenu_floute', 'TINYINT(1)', 'definition_en');
  sql_creer_champ('nbdb_web_image', 'nsfw', 'TINYINT(1)', 'tags');
}
sql_update_id_requete(14);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                           VERSION 3 BUILD 9                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
// #533 - Commentaires privés dans la NBDB

if($derniere_requete < 15)
{
  sql_creer_champ('nbdb_web_definition', 'notes_admin', 'LONGTEXT', 'est_incorrect');
  sql_creer_champ('nbdb_web_page', 'notes_admin', 'LONGTEXT', 'est_incorrect');
  sql_creer_table('nbdb_web_notes_admin');
  sql_creer_champ('nbdb_web_notes_admin', 'notes_admin', 'LONGTEXT', 'id');
  sql_creer_champ('nbdb_web_notes_admin', 'brouillon_fr', 'LONGTEXT', 'notes_admin');
  sql_creer_champ('nbdb_web_notes_admin', 'brouillon_en', 'LONGTEXT', 'brouillon_fr');
}
sql_update_id_requete(15);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// #543 - Historique des requêtes SQL

sql_creer_champ("vars_globales", "derniere_requete_sql", "TINYINT(1) NOT NULL", "mise_a_jour");
sql_update_id_requete(16);