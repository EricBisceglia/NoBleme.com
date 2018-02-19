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

// Vu que c'est du MyISAM faudrait peut-être construire des index (oops)

sql_creer_index("activite", "index_membres", "FKmembres");
sql_creer_index("activite", "index_action", "action_id");
sql_creer_index("activite", "index_type", "action_type(10)");
sql_creer_index("activite_diff", "index_activite", "FKactivite");
sql_creer_index("irl_participants", "index_irl", "FKirl");
sql_creer_index("irl_participants", "index_membres", "FKmembres");
sql_creer_index("membres", "index_login", "pseudonyme(20), pass(60)");
sql_creer_index("membres", "index_droits", "admin, sysop, moderateur(10)");
sql_creer_index("membres_essais_login", "index_membres", "FKmembres");
sql_creer_index("notifications", "index_destinataire", "FKmembres_destinataire");
sql_creer_index("notifications", "index_envoyeur", "FKmembres_envoyeur");
sql_creer_index("notifications", "index_chronologie", "date_envoi");
sql_creer_index("pageviews", "index_recherche", "nom_page, url_page", 1);
sql_creer_index("pageviews", "index_tri", "vues, vues_lastvisit");
sql_creer_index("quotes", "index_membres", "FKauteur");
sql_creer_index("quotes_membres", "index_quotes", "FKquotes");
sql_creer_index("quotes_membres", "index_membres", "FKmembres");
sql_creer_index("todo", "index_membres", "FKmembres");
sql_creer_index("todo", "index_categorie", "FKtodo_categorie");
sql_creer_index("todo", "index_roadmap", "FKtodo_roadmap");
sql_creer_index("todo", "index_titre", "titre", 1);
sql_creer_index("todo_roadmap", "index_classement", "id_classement");




// On veut plus du vieux système de filtrage par catégorie du forum, on va en recréer un nouveau

sql_supprimer_table('forum_filtrage');
sql_creer_table("forum_categorie", "  id              INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
                                      par_defaut      TINYINT(1) UNSIGNED NOT NULL                          ,
                                      classement      INT(11) UNSIGNED NOT NULL                             ,
                                      nom_fr          TINYTEXT NOT NULL                                     ,
                                      nom_en          TINYTEXT NOT NULL                                     ,
                                      description_fr  MEDIUMTEXT NOT NULL                                   ,
                                      description_en  MEDIUMTEXT NOT NULL                                   ");
sql_supprimer_champ("forum_sujet", "categorie");
sql_creer_champ("forum_sujet", "FKforum_categorie", "INT(11) UNSIGNED NOT NULL", "FKmembres_dernier_message");
sql_creer_table("forum_filtrage", " id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
                                    FKmembres         INT(11) UNSIGNED NOT NULL                             ,
                                    FKforum_categorie INT(11) UNSIGNED NOT NULL                             ");
sql_creer_champ("membres", "forum_lang", "TINYTEXT NOT NULL", "forum_messages");



// Le forum aussi a le droit à des index

sql_creer_index("forum_categorie", "index_classement", "par_defaut, classement");
sql_creer_index("forum_filtrage", "index_membres", "FKmembres");
sql_creer_index("forum_filtrage", "index_categorie", "FKforum_categorie");
sql_creer_index("forum_message", "index_sujet", "FKforum_sujet");
sql_creer_index("forum_message", "index_parent", "FKforum_message_parent");
sql_creer_index("forum_message", "index_membres", "FKmembres");
sql_creer_index("forum_message", "index_chronologie", "timestamp_creation");
sql_creer_index("forum_message", "index_contenu", "contenu", 1);
sql_creer_index("forum_sujet", "index_createur", "FKmembres_createur");
sql_creer_index("forum_sujet", "index_dernier", "FKmembres_dernier_message");
sql_creer_index("forum_sujet", "index_categorie", "FKforum_categorie");
sql_creer_index("forum_sujet", "index_chronologie", "timestamp_dernier_message");
sql_creer_index("forum_sujet", "index_titre", "titre", 1);




// Contenu des catégories du forum : Par défaut

$temp_desc_fr = postdata("Sélectionnez ceci si votre sujet ne correspond à aucune des options de catégorisation possibles. Dans la majorité des cas, c'est cette option que vous voudrez choisir pour votre sujet de discussion.", 'string');
$temp_desc_en = postdata("Pick this if your topic doesn't fit any of the other categories. In most cases, this is the option that you will want to select.", 'string');
sql_insertion_valeur(" SELECT nom_fr FROM forum_categorie WHERE nom_fr LIKE 'Aucune catégorie' ",
" INSERT INTO forum_categorie
  SET         par_defaut      = 1                   ,
              classement      = 0                   ,
              nom_fr          = 'Aucune catégorie'  ,
              nom_en          = 'Uncategorized'     ,
              description_fr  = '$temp_desc_fr'     ,
              description_en  = '$temp_desc_en'     ");

// Contenu des catégories du forum : Politique

$temp_desc_fr = postdata("Si votre sujet parle de politique et/ou est lié à des actualités de nature politisées, cochez cette case afin que les utilisateurs qui le désirent puissent soit facilement trouver votre sujet pour y répondre, soit facilement filtrer votre sujet afin de ne pas le voir.", 'string');
$temp_desc_en = postdata("If your topic is about politics and/or current events of a political nature, pick this option so that users who want to avoid that kind of content can filter it out (or so that those who want to discuss this kind of content can do so).", 'string');
sql_insertion_valeur(" SELECT nom_fr FROM forum_categorie WHERE nom_fr LIKE 'Politique' ",
" INSERT INTO forum_categorie
  SET         par_defaut      = 0               ,
              classement      = 100             ,
              nom_fr          = 'Politique'     ,
              nom_en          = 'Political'     ,
              description_fr  = '$temp_desc_fr' ,
              description_en  = '$temp_desc_en' ");

// Contenu des catégories du forum : Informatique

$temp_desc_fr = postdata("Afin de catégoriser les conversations liées à tous les champs de l'informatique (logiciels, développement, administration système, réseau, hardware, etc.), cochez cette case si votre sujet parle d'un sujet informatique quelconque. Cette catégorie n'est pas faite pour les jeux vidéo : si vous souhaitez parler de jeux vidéo sélectionnez l'option Aucune catégorie.", 'string');
$temp_desc_en = postdata("In order to tag all topics that deal with the world of computer science (software, hardware, coding, sysadmin, networking, etc.), check this box if your planned topic fits that description. Note that this category is not made for video games: if you wish to discuss video games, check the \"Uncategorized\" box instead.", 'string');
sql_insertion_valeur(" SELECT nom_fr FROM forum_categorie WHERE nom_fr LIKE 'Informatique' ",
" INSERT INTO forum_categorie
  SET         par_defaut      = 0                   ,
              classement      = 101                 ,
              nom_fr          = 'Informatique'      ,
              nom_en          = 'Computer science'  ,
              description_fr  = '$temp_desc_fr'     ,
              description_en  = '$temp_desc_en'     ");

// Contenu des catégories du forum : NoBleme.com

$temp_desc_fr = postdata("Cochez cette case si votre sujet parle du contenu du site NoBleme.com et/ou de la communauté NoBleme.", 'string');
$temp_desc_en = postdata("Pick this option if your topic is about the NoBleme.com website and/or its community.", 'string');
sql_insertion_valeur(" SELECT nom_fr FROM forum_categorie WHERE nom_fr LIKE 'NoBleme.com' ",
" INSERT INTO forum_categorie
  SET         par_defaut      = 0               ,
              classement      = 200             ,
              nom_fr          = 'NoBleme.com'   ,
              nom_en          = 'NoBleme.com'   ,
              description_fr  = '$temp_desc_fr' ,
              description_en  = '$temp_desc_en' ");




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