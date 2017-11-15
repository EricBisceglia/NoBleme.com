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

// Nouveau système de pageviews
sql_renommer_table('stats_pageviews', 'pageviews');
sql_vider_table('pageviews');
sql_renommer_champ('pageviews', 'id_page', 'url_page', 'MEDIUMTEXT');

// Au revoir les stats referer
sql_supprimer_table('stats_referer');
sql_supprimer_champ('vars_globales', 'last_referer_check');

// Nouveau système d'activité
sql_vider_table('activite_diff');
sql_renommer_champ('activite', 'parent_titre', 'parent', 'MEDIUMTEXT');
sql_renommer_champ('activite_diff', 'diff', 'diff_avant', 'LONGTEXT');
sql_creer_champ('activite_diff', 'diff_apres', 'LONGTEXT', 'diff_avant');
query(" UPDATE activite SET log_moderation = 1 WHERE action_type LIKE 'profil' ");
query(" UPDATE activite SET action_type = 'quote' WHERE action_type LIKE 'quote_add' ");
query(" UPDATE activite SET action_type = 'devblog' WHERE action_type LIKE 'new_devblog' ");
query(" UPDATE activite SET action_type = 'todo_new' WHERE action_type LIKE 'new_todo' ");
query(" UPDATE activite SET action_type = 'todo_fini' WHERE action_type LIKE 'fini_todo' ");
query(" UPDATE activite SET action_type = 'irl_new' WHERE action_type LIKE 'new_irl' ");
query(" UPDATE activite SET action_type = 'irl_edit' WHERE action_type LIKE 'edit_irl' ");
query(" UPDATE activite SET action_type = 'irl_delete' WHERE action_type LIKE 'delete_irl' ");
query(" UPDATE activite SET action_type = 'irl_add_participant' WHERE action_type LIKE 'add_irl_participant' ");
query(" UPDATE activite SET action_type = 'irl_edit_participant' WHERE action_type LIKE 'edit_irl_participant' ");
query(" UPDATE activite SET action_type = 'irl_del_participant' WHERE action_type LIKE 'del_irl_participant' ");

// RIP les commentaires sur les devblogs et les tâches
sql_supprimer_table('todo_commentaire');
query(" DELETE FROM activite WHERE action_type = 'new_todo_comm' ");
query(" DELETE FROM activite WHERE action_type = 'todo_todo_comm' ");
query(" DELETE FROM activite WHERE action_type = 'edit_todo_comm' ");
query(" DELETE FROM activite WHERE action_type = 'del_todo_comm' ");
sql_supprimer_table('devblog_commentaire');
query(" DELETE FROM activite WHERE action_type = 'new_devblog_comm' ");
query(" DELETE FROM activite WHERE action_type = 'todo_devblog_comm' ");
query(" DELETE FROM activite WHERE action_type = 'edit_devblog_comm' ");
query(" DELETE FROM activite WHERE action_type = 'del_devblog_comm' ");

// Changement de la structure de la table membres
sql_renommer_champ('membres', 'region', 'habite', 'TINYTEXT');
sql_renommer_champ('membres', 'sexe', 'genre', 'TINYTEXT');
sql_renommer_champ('membres', 'moderateur_description', 'moderateur_description_fr', 'MEDIUMTEXT');
sql_creer_champ('membres', 'moderateur_description_en', 'MEDIUMTEXT', 'moderateur_description_fr');
query(" UPDATE membres SET moderateur_description_en = 'Real life meetups' WHERE moderateur_description_fr LIKE 'Rencontres IRL' ");

// Changement de la structure de la table irl
sql_renommer_champ('irl', 'raison', 'raison_fr', 'TINYTEXT NOT NULL');
sql_creer_champ('irl', 'raison_en', 'TINYTEXT NOT NULL', 'raison_fr');
sql_creer_champ('irl', 'details_fr', 'LONGTEXT NOT NULL', 'raison_en');
sql_creer_champ('irl', 'details_en', 'LONGTEXT NOT NULL', 'details_fr');
sql_renommer_champ('irl_participants', 'details', 'details_fr', 'TINYTEXT NOT NULL');
sql_creer_champ('irl_participants', 'details_en', 'TINYTEXT NOT NULL', 'details_fr');
$qdescribe = query(" DESCRIBE irl ");
while($ddescribe = mysqli_fetch_array($qdescribe))
{
  if($ddescribe['Field'] == "details_pourquoi")
    query(" UPDATE irl SET details_fr = CONCAT('[b][u]Pourquoi:[/u][/b] ', details_pourquoi, '\r\n\r\n[b][u]Où:[/u][/b] ', details_ou, '\r\n\r\n[b][u]Quand:[/u][/b] ', details_quand, '\r\n\r\n[b][u]Quoi:[/u][/b] ', details_quoi) ");
}
sql_supprimer_champ('irl', 'details_pourquoi');
sql_supprimer_champ('irl', 'details_ou');
sql_supprimer_champ('irl', 'details_quand');
sql_supprimer_champ('irl', 'details_quoi');
query(" UPDATE irl SET raison_fr = '' WHERE raison_fr LIKE 'Il faut une raison ?' ");
query(" UPDATE irl SET raison_fr = '' WHERE raison_fr LIKE 'Parce que' ");
query(" UPDATE irl SET raison_fr = '' WHERE raison_fr LIKE 'Comme ça' ");
query(" UPDATE irl SET raison_fr = '' WHERE raison_fr LIKE 'Parce que Shalena l\'a réclamé' ");
query(" UPDATE irl SET raison_fr = 'Anniversaire de Trucy' WHERE raison_fr LIKE 'Anniversaire de Wan' ");
query(" UPDATE irl SET raison_en = 'Trucy\'s graduation' WHERE raison_fr LIKE 'RDD de Trucy' ");
query(" UPDATE irl SET raison_en = 'Trucy\'s done studying' WHERE raison_fr LIKE 'Fin des études de Trucy' ");
query(" UPDATE irl SET raison_en = 'Plow is leaving :\'(' WHERE raison_fr LIKE 'Plow s\'en va :\'(' ");
query(" UPDATE irl SET raison_en = 'Exanis is visiting Paris' WHERE raison_fr LIKE 'Passage d\'Exanis à Paris' ");
query(" UPDATE irl SET raison_en = 'NoBleme\'s 11th birthday' WHERE raison_fr LIKE 'Les 11 ans de NoBleme !' ");
query(" UPDATE irl SET raison_en = 'Trucy\'s birthday' WHERE raison_fr LIKE 'Anniversaire de Trucy' ");
query(" UPDATE irl SET raison_en = 'Odin is leaving Paris' WHERE raison_fr LIKE 'Parce que Odin s\'en va de Paris' ");
query(" UPDATE irl SET raison_en = 'Kutz is visiting Paris' WHERE raison_fr LIKE 'Passage de Kutz à Paris' ");
query(" UPDATE irl SET raison_en = 'NoBleme\'s 10th birthday mini-meetup' WHERE raison_fr LIKE 'Mini-irl des 10 ans de NoBleme' ");
query(" UPDATE irl SET raison_en = 'SiHn is visiting paris' WHERE raison_fr LIKE 'Passage de SiHn à Paris' ");
query(" UPDATE irl SET raison_en = 'Sofly\'s birthday' WHERE raison_fr LIKE 'Anniversaire de Sofly' ");
query(" UPDATE irl SET raison_en = 'ThArGos is visiting paris' WHERE raison_fr LIKE 'Passage de ThArGos à Paris' ");

// Fix des vieux messages privés foireux
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&lt;', '<') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&gt;', '>') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&#62;', '>') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&amp;', '&') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&quot;', '\"') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&Agrave;', 'À') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&agrave;', 'à') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&acirc;', 'â') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&auml;', 'ä') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&Ccedil;', 'Ç') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&ccedil;', 'ç') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&eacute;', 'é') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&egrave;', 'è') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&Ecirc;', 'Ê') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&ecirc;', 'ê') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&euml;', 'ë') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&icirc;', 'î') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&iuml;', 'ï') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&ocirc;', 'ô') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&oacute;', 'ó') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&ouml;', 'ö') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&ugrave;', 'ù') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&ucirc;', 'û') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&uuml;', 'ü') ");
query(" UPDATE notifications SET contenu = REPLACE (contenu, '&nbsp;', ' ') ");

// Fix des vieilles miscellanées foireuses
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&lt;', '<') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&gt;', '>') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&#62;', '>') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&amp;', '&') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&quot;', '\"') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&Agrave;', 'À') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&agrave;', 'à') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&acirc;', 'â') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&auml;', 'ä') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&Ccedil;', 'Ç') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&ccedil;', 'ç') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&eacute;', 'é') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&egrave;', 'è') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&Ecirc;', 'Ê') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&ecirc;', 'ê') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&euml;', 'ë') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&icirc;', 'î') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&iuml;', 'ï') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&ocirc;', 'ô') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&oacute;', 'ó') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&ouml;', 'ö') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&ugrave;', 'ù') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&ucirc;', 'û') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&uuml;', 'ü') ");
query(" UPDATE quotes SET contenu = REPLACE (contenu, '&nbsp;', ' ') ");

// Fix des vieilles tâches foireuses
query(" UPDATE todo SET titre = REPLACE (titre, '&lt;', '<') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&gt;', '>') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&#62;', '>') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&amp;', '&') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&quot;', '\"') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&Agrave;', 'À') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&agrave;', 'à') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&acirc;', 'â') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&auml;', 'ä') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&Ccedil;', 'Ç') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&ccedil;', 'ç') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&eacute;', 'é') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&egrave;', 'è') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&Ecirc;', 'Ê') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&ecirc;', 'ê') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&euml;', 'ë') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&icirc;', 'î') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&iuml;', 'ï') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&ocirc;', 'ô') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&oacute;', 'ó') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&ouml;', 'ö') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&ugrave;', 'ù') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&ucirc;', 'û') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&uuml;', 'ü') ");
query(" UPDATE todo SET titre = REPLACE (titre, '&nbsp;', ' ') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&lt;', '<') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&gt;', '>') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&laquo;', '«') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&raquo;', '»') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&#60;', '<') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&#62;', '>') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&amp;', '&') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&quot;', '\"') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&Agrave;', 'À') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&agrave;', 'à') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&acirc;', 'â') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&auml;', 'ä') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&Ccedil;', 'Ç') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&ccedil;', 'ç') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&Eacute;', 'É') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&eacute;', 'é') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&Egrave;', 'È') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&egrave;', 'è') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&Ecirc;', 'Ê') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&ecirc;', 'ê') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&euml;', 'ë') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&icirc;', 'î') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&iuml;', 'ï') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&ocirc;', 'ô') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&oacute;', 'ó') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&ouml;', 'ö') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&ugrave;', 'ù') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&ucirc;', 'û') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&uuml;', 'ü') ");
query(" UPDATE todo SET contenu = REPLACE (contenu, '&nbsp', ' ') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&lt;', '<') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&gt;', '>') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&laquo;', '«') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&raquo;', '»') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&#60;', '<') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&#62;', '>') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&amp;', '&') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&quot;', '\"') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&Agrave;', 'À') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&agrave;', 'à') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&acirc;', 'â') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&auml;', 'ä') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&Ccedil;', 'Ç') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&ccedil;', 'ç') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&Eacute;', 'É') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&eacute;', 'é') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&Egrave;', 'È') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&egrave;', 'è') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&Ecirc;', 'Ê') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&ecirc;', 'ê') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&euml;', 'ë') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&icirc;', 'î') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&iuml;', 'ï') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&ocirc;', 'ô') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&oacute;', 'ó') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&ouml;', 'ö') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&ugrave;', 'ù') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&ucirc;', 'û') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&uuml;', 'ü') ");
query(" UPDATE todo_roadmap SET description = REPLACE (description, '&nbsp', ' ') ");
query(" UPDATE todo_categorie SET categorie = REPLACE (categorie, '&egrave;', 'è') ");

// Plus besoin de certains contenus devenus legacy
sql_supprimer_table('anniv_flash');
sql_supprimer_table('forum_loljk');
sql_supprimer_table('membres_secrets');
sql_supprimer_table('pages');
sql_supprimer_table('secrets');
sql_supprimer_champ('devblog', 'score_popularite');
sql_supprimer_champ('devblog', 'resume');
sql_supprimer_champ('membres', 'profil_last_edit');
sql_supprimer_champ('activite', 'parent_id');

// On dégage tout le NBRPG pour le moment (il reviendra, promis)
sql_supprimer_table('nbrpg_chatlog');
sql_supprimer_table('nbrpg_effets');
sql_supprimer_table('nbrpg_monstres');
sql_supprimer_table('nbrpg_objets');
sql_supprimer_table('nbrpg_persos');
sql_supprimer_table('nbrpg_session');
sql_supprimer_table('nbrpg_session_effets');
sql_supprimer_champ('vars_globales', 'nbrpg_activite');




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