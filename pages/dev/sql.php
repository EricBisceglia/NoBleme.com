<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

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
// On commence par choper la maj choisie et initialiser le string d'affichage

$majq = '';

if(isset($_GET['maj']))
  $idmaj = postdata($_GET['maj']);
else
  $idmaj = '';





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Version 2

if($idmaj == 'v2')
{
  $majq .= '<span class="gras souligne moinsgros alinea">Version 2</span><br>';

  // Nettoyage du bordel dans les miscellanées
  $getmisc = query(" SELECT id, contenu FROM quotes ");
  while($fixmisc = mysqli_fetch_array($getmisc))
    query(" UPDATE quotes SET contenu = '".postdata(stripslashes($fixmisc['contenu']))."' WHERE id = '".$fixmisc['id']."'");
  $majq .= "<br><br>Fixé le bordel dans les miscellanées";

  // Ajout du champ todo.source
  if(!@mysqli_query($GLOBALS['db'], " SELECT source FROM todo "))
    query(" ALTER TABLE todo ADD source MEDIUMTEXT AFTER timestamp_fini ");
  $majq .= "<br><br>Ajout du champ todo.source";

  // Suppression du champ membres.bie
  if(@mysqli_query($GLOBALS['db'], " SELECT bie FROM membres "))
    query(" ALTER TABLE membres DROP bie ");
  $majq .= "<br><br>Suppression du champ membres.bie";

  // Création de l'enregistrement consulte le CV de Bad
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nobleme' AND page_id LIKE 'cv' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'nobleme'                 ,
                        page_id     = 'cv'                      ,
                        visite_page = 'Consulte de CV de Bad'   ,
                        visite_url  = 'pages/cv'                ");
  $majq .= "<br><br>Activité : Consulte le CV de Bad";

  // Création de l'enregistrement propose une nouvelle miscellanée
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'quotes' AND page_id LIKE 'add' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'quotes'                            ,
                        page_id     = 'add'                               ,
                        visite_page = 'Propose une nouvelle miscellanée'  ,
                        visite_url  = 'pages/irc/quotes'                  ");
  $majq .= "<br>Activité : Propose une nouvelle miscellanée";

  // Création de l'enregistrement se marre devant les miscellanées
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'quotes' AND page_id LIKE 'index' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'quotes'                            ,
                        page_id     = 'index'                             ,
                        visite_page = 'Se marre devant les miscellanées'  ,
                        visite_url  = 'pages/irc/quotes'                  ");
  $majq .= "<br>Activité : Se marre devant les miscellanées";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Re-Alpha 15

if($idmaj == 'ra15')
{
  $majq .= '<span class="gras souligne moinsgros alinea">Re-Alpha 15</span><br>';

  // Création de la table forum_loljk
  query(" CREATE TABLE IF NOT EXISTS forum_loljk (
            id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            timestamp         INT(11) UNSIGNED NOT NULL                             ,
            threadparent      INT(11) NOT NULL                                      ,
            threadstart       TINYINT(1) NOT NULL                                   ,
            FKauteur          INT(11) NOT NULL                                      ,
            titre             MEDIUMTEXT                                            ,
            contenu           LONGTEXT
          ) ENGINE=MyISAM; ");
  $majq .= "<br>Crée la table forum_loljk";

  // Création de la table quotes
  query(" CREATE TABLE IF NOT EXISTS quotes (
            id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            timestamp         INT(11) UNSIGNED NOT NULL                             ,
            contenu           LONGTEXT                                              ,
            FKauteur          INT(11) NOT NULL                                      ,
            valide_admin      TINYINT(1) NOT NULL
          ) ENGINE=MyISAM; ");
  $majq .= "<br>Crée la table quotes";

  // Création de la table secrets
  query(" CREATE TABLE IF NOT EXISTS secrets (
            id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            nom               MEDIUMTEXT                                            ,
            url               MEDIUMTEXT                                            ,
            titre             MEDIUMTEXT                                            ,
            description       MEDIUMTEXT
          ) ENGINE=MyISAM; ");
  $majq .= "<br>Crée la table secrets";

  // Création de la table membres_secrets
  query(" CREATE TABLE IF NOT EXISTS membres_secrets (
            id                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY  ,
            FKmembres         INT(11) UNSIGNED NOT NULL                             ,
            FKsecrets         INT(11) UNSIGNED NOT NULL                             ,
            timestamp         INT(11) UNSIGNED NOT NULL
          ) ENGINE=MyISAM; ");
  $majq .= "<br>Crée la table membres_secrets";

  // Ajout du champ membres.moderateur
  if(!@mysqli_query($GLOBALS['db'], " SELECT moderateur FROM membres "))
    query(" ALTER TABLE membres ADD moderateur MEDIUMTEXT AFTER sysop ");
  $majq .= "<br><br>Ajout du champ membres.moderateur";

  // Ajout du champ membres.moderateur_description
  if(!@mysqli_query($GLOBALS['db'], " SELECT moderateur_description FROM membres "))
    query(" ALTER TABLE membres ADD moderateur_description MEDIUMTEXT AFTER moderateur ");
  $majq .= "<br>Ajout du champ membres.moderateur_description";

  // Création de l'enregistrement découvre IRC
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'irc' AND page_id LIKE 'index' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'irc'               ,
                        page_id     = 'index'             ,
                        visite_page = 'Découvre IRC'      ,
                        visite_url  = 'pages/irc/index'   ");
  $majq .= "<br><br>Activité : Découvre IRC";

  // Création de l'enregistrement veut rejoindre IRC
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'irc' AND page_id LIKE 'web' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'irc'                 ,
                        page_id     = 'web'                 ,
                        visite_page = 'Veut rejoindre IRC'  ,
                        visite_url  = 'pages/irc/web'       ");
  $majq .= "<br>Activité : Veut rejoindre IRC";

  // Création de l'enregistrement questionne les traditions IRC
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'irc' AND page_id LIKE 'traditions' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'irc'                           ,
                        page_id     = 'traditions'                    ,
                        visite_page = 'Questionne les traditions IRC' ,
                        visite_url  = 'pages/irc/traditions'          ");
  $majq .= "<br>Activité : Questionne les traditions IRC";

  // Création de l'enregistrement choisit son canal IRC préféré
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'irc' AND page_id LIKE 'canaux' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'irc'                           ,
                        page_id     = 'canaux'                        ,
                        visite_page = 'Choisit son canal IRC préféré' ,
                        visite_url  = 'pages/irc/canaux'              ");
  $majq .= "<br>Activité : Choisit son canal IRC préféré";

  // Création de l'enregistrement se fait troller par le forum
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'forum' AND page_id LIKE 'loljk' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'forum'                             ,
                        page_id     = 'loljk'                             ,
                        visite_page = 'Se fait troller par le \"forum\"'  ,
                        visite_url  = 'pages/forum/index'                 ");
  $majq .= "<br>Activité : Se fait troller par le forum";

  // Création de l'enregistrement déprime devant une page en travaux
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nobleme' AND page_id LIKE 'travaux' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'nobleme'                             ,
                        page_id     = 'travaux'                             ,
                        visite_page = 'Déprime devant une page en travaux'  ,
                        visite_url  = 'pages/nobleme/travaux'               ");
  $majq .= "<br>Activité : Déprime devant une page en trvaux";

  // Création de l'enregistrement découvre NoBleme
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'doc' AND page_id LIKE 'nobleme' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'doc'               ,
                        page_id     = 'nobleme'           ,
                        visite_page = 'Découvre NoBleme'  ,
                        visite_url  = 'pages/doc/nobleme' ");
  $majq .= "<br>Activité : Découvre NoBleme";

}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Re-Alpha 14

if($idmaj == 'ra14')
{
  $majq .= '<span class="gras souligne moinsgros alinea">Re-Alpha 14</span><br>';

  // Création du champ stats_referer.alias
  if(!@mysqli_query($GLOBALS['db'], " SELECT alias FROM stats_referer "))
    query(" ALTER TABLE stats_referer ADD alias TEXT NOT NULL AFTER source ");
  $majq .= "<br>Crée le champ stats_referer.alias";

  // Création du champ vars_globales.last_referer_check
  if(!@mysqli_query($GLOBALS['db'], " SELECT last_referer_check FROM vars_globales "))
    query(" ALTER TABLE vars_globales ADD last_referer_check TEXT NOT NULL AFTER last_pageview_check ");
  $majq .= "<br>Crée le champ vars_globales.last_referer_check<br>";

  // Création de l'enregistrement se prend une 404
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'erreur' AND page_id LIKE '404' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'erreur'            ,
                        page_id     = '404'               ,
                        visite_page = 'Se prend une 404'  ,
                        visite_url  = 'pages/nobleme/404' ");
  $majq .= "<br>Activité : Erreur 404";

  // Création de l'enregistrement change son e-mail
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'user' AND page_id LIKE 'email' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'user'              ,
                        page_id     = 'email'             ,
                        visite_page = 'Change son e-mail' ,
                        visite_url  = 'pages/nobleme/404' ");
  $majq .= "<br>Activité : Changer d'e-mail";

  // Création de l'enregistrement change son e-mail
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'user' AND page_id LIKE 'pass' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'user'                    ,
                        page_id     = 'pass'                    ,
                        visite_page = 'Change son mot de passe' ,
                        visite_url  = 'pages/nobleme/404'       ");
  $majq .= "<br>Activité : Changer de mot de passe";
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Re-Alpha 13

if($idmaj == 'ra13')
{
  $majq .= '<span class="gras souligne moinsgros alinea">Re-Alpha 13</span><br>';

  // Création du champ membres.sexe
  if(!@mysqli_query($GLOBALS['db'], " SELECT sexe FROM membres "))
    query(" ALTER TABLE membres ADD sexe TINYTEXT NOT NULL AFTER banni_raison ");
  $majq .= "<br>Crée le champ membres.sexe";

  // Création du champ membres.région
  if(!@mysqli_query($GLOBALS['db'], " SELECT region FROM membres "))
    query(" ALTER TABLE membres ADD region TINYTEXT NOT NULL AFTER anniversaire ");
  $majq .= "<br>Crée le champ membres.region";

  // Création du champ membres.métier
  if(!@mysqli_query($GLOBALS['db'], " SELECT metier FROM membres "))
    query(" ALTER TABLE membres ADD metier TINYTEXT NOT NULL AFTER region ");
  $majq .= "<br>Crée le champ membres.metier<br>";


  // Création de l'enregistrement respecte l'équipe administrative
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nobleme' AND page_id LIKE 'admins' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'nobleme'                           ,
                        page_id     = 'admins'                            ,
                        visite_page = 'Respecte l\'équipe administrative' ,
                        visite_url  = 'pages/nobleme/admins'              ");
  $majq .= "<br>Activité : Équipe administrative";

  // Création de l'enregistrement recalcule les statistiques des IRL
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nobleme' AND page_id LIKE 'irlstats' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'nobleme'                             ,
                        page_id     = 'irlstats'                            ,
                        visite_page = 'Recalcule les statistiques des IRL'  ,
                        visite_url  = 'pages/nobleme/irlstats'              ");
  $majq .= "<br>Activité : Stastistiques des IRL";

  // Création de l'enregistrement modifie son profil public
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'user' AND page_id LIKE 'profil' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'user'                        ,
                        page_id     = 'profil'                      ,
                        visite_page = 'Modifie son profil public'   ,
                        visite_url  = 'pages/nobleme/profil'        ");
  $majq .= "<br>Activité : Éditer son profil public";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Re-Alpha 12

if($idmaj == 'ra12')
{
  $majq .= '<span class="gras souligne moinsgros alinea">Re-Alpha 12</span><br>';

  // Création de la table todo
  query(" CREATE TABLE IF NOT EXISTS todo (
            id                INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            FKmembres         INT(11)                                     ,
            timestamp         INT(11)                                     ,
            importance        INT(11)                                     ,
            titre             MEDIUMTEXT                                  ,
            contenu           LONGTEXT                                    ,
            FKtodo_categorie  INT(11)                                     ,
            FKtodo_roadmap    INT(11)                                     ,
            valide_admin      TINYINT(1)                                  ,
            public            TINYINT(1)                                  ,
            timestamp_fini    INT(11)
          ) ENGINE=MyISAM; ");
  $majq .= '<br>Crée la table todo';


  // Création de la table todo_commentaire
  query(" CREATE TABLE IF NOT EXISTS todo_commentaire (
            id                INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            FKtodo            INT(11)                                     ,
            FKmembres         INT(11)                                     ,
            timestamp         INT(11)                                     ,
            contenu           LONGTEXT
          ) ENGINE=MyISAM; ");
  $majq .= '<br>Crée la table todo_commentaire';


  // Création de la table todo_categorie
  query(" CREATE TABLE IF NOT EXISTS todo_categorie (
            id                INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            categorie         TINYTEXT
          ) ENGINE=MyISAM; ");
  $majq .= '<br>Crée la table todo_catégorie';


  // Création de la table todo_roadmap
  query(" CREATE TABLE IF NOT EXISTS todo_roadmap (
            id                INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            id_classement     INT(11)                                     ,
            version           TINYTEXT                                    ,
            description       MEDIUMTEXT
          ) ENGINE=MyISAM; ");
  $majq .= '<br>Crée la table todo_roadmap<br>';


  // Création de l'enregistrement liste des tâches
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'todo' AND page_id LIKE 'index' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'todo'                            ,
                        page_id     = 'index'                           ,
                        visite_page = 'Décortique la liste des tâches'  ,
                        visite_url  = 'pages/todo/index'                ");
  $majq .= '<br>Activité : Liste des tâches';

  // Création de l'enregistrement ouvre un ticket
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'todo' AND page_id LIKE 'add' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'todo'                    ,
                        page_id     = 'add'                     ,
                        visite_page = 'Ouvre un nouveau ticket' ,
                        visite_url  = 'pages/todo/add'          ");
  $majq .= '<br>Activité: Ouvre un ticket';

  // Création de l'enregistrement litle plan de route
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'todo' AND page_id LIKE 'roadmap' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'todo'                  ,
                        page_id     = 'roadmap'               ,
                        visite_page = 'Lit le plan de route'  ,
                        visite_url  = 'pages/todo/add'        ");
  $majq .= '<br>Activité: Lit le plan de route';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Re-Alpha 11

if($idmaj == 'ra11')
{
  $majq .= '<span class="gras souligne moinsgros alinea">Re-Alpha 11</span><br>';

  // Suppression des pageviews mensuelles
  query(" DROP TABLE IF EXISTS stats_pageviews_mois; ");
  $majq .= "<br>Supprimé la table stats_pageviews_mois<br>";


  // Création de la table devblog
  query(" CREATE TABLE IF NOT EXISTS devblog (
            id                INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            timestamp         INT(11) UNSIGNED NOT NULL                   ,
            titre             MEDIUMTEXT                                  ,
            resume            MEDIUMTEXT                                  ,
            contenu           LONGTEXT                                    ,
            score_popularite  INT(11)
          ) ENGINE=MyISAM; ");
  $majq .= "<br>Crée la table devblog";


  // Création de la table devblog_commentaire
  query(" CREATE TABLE IF NOT EXISTS devblog_commentaire (
            id        INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            FKdevblog INT(11)                                     ,
            FKmembres INT(11)                                     ,
            timestamp INT(11) UNSIGNED NOT NULL                   ,
            contenu   LONGTEXT
          ) ENGINE=MyISAM; ");
  $majq .= "<br>Crée la table devblog_commentaire<br>";


  // On vire le PHP du nom des pages
  query(" UPDATE pages SET visite_url = REPLACE(visite_url,'.php','') ");
  $majq .= "<br>Retiré .php de la fin du nom des pages de l'activité récente<br>";


  // Création de l'enregistrement coulisses
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'nobleme' AND page_id LIKE 'coulisses' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'nobleme'                         ,
                        page_id     = 'coulisses'                       ,
                        visite_page = 'Zyeute les coulisses de NoBleme' ,
                        visite_url  = 'pages/nobleme/coulisses'         ");
  $majq .= "<br>Activité : Coulisses";

  // Création de l'enregistrement liste des devblogs
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'devblog' AND page_id LIKE 'index' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'devblog'                         ,
                        page_id     = 'index'                           ,
                        visite_page = 'Considère la liste des devblogs' ,
                        visite_url  = 'pages/devblog/index'             ");
  $majq .= "<br>Activité : Liste des devblogs";

  // Création de l'enregistrement devblogs populaires
  if(!@mysqli_num_rows(@mysqli_query($GLOBALS['db'], " SELECT id FROM pages WHERE page_nom LIKE 'devblog' AND page_id LIKE 'top' ")))
    query(" INSERT INTO pages
            SET         page_nom    = 'devblog'                         ,
                        page_id     = 'top'                             ,
                        visite_page = 'Mire les devblogs populaires'    ,
                        visite_url  = 'pages/devblog/top'               ");
  $majq .= "<br>Activité : Devblogs populaires";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On finit le string d'affichage

if($idmaj)
  $majq .= '<br><br><span class="moinsgros gras">Fini toutes les requêtes !</span></div><div class="body_main midsize align_center">';





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

    <div class="body_main midsize align_center">
      <?=$majq?>
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris_titre moinsgros">
            VERSION
          </td>
          <td class="cadre_gris_titre moinsgros">
            CHANGEMENTS STRUCTURELS
          </td>
        </tr>

        <tr>
          <td class="cadre_gris moinsgros gras">
            <a class="dark blank" href="?maj=v2">Version 2</a>
          </td>
          <td class="cadre_gris">
            Fix du bordel dans les miscellanées<br>
            Création du champ todo.source<br>
            Suppression du champ membres.bie
          </td>
        </tr>
        <tr>
          <td colspan="2" class="cadre_gris_vide">
          </td>
        </tr>

        <tr>
          <td class="cadre_gris moinsgros gras">
            <a class="dark blank" href="?maj=ra15">Re-alpha 15</a>
          </td>
          <td class="cadre_gris">
            Création des tables quotes ; quotes_membres
          </td>
        </tr>
        <tr>
          <td colspan="2" class="cadre_gris_vide">
          </td>
        </tr>

        <tr>
          <td class="cadre_gris moinsgros gras">
            <a class="dark blank" href="?maj=ra14">Re-alpha 14</a>
          </td>
          <td class="cadre_gris">
            Création des champs stats_referer.alias ; vars_globales.last_referer_check
          </td>
        </tr>
        <tr>
          <td colspan="2" class="cadre_gris_vide">
          </td>
        </tr>

        <tr>
          <td class="cadre_gris moinsgros gras">
            <a class="dark blank" href="?maj=ra13">Re-alpha 13</a>
          </td>
          <td class="cadre_gris">
            Création des champs membres.sexe ; membres.region ; membres.metier
          </td>
        </tr>
        <tr>
          <td colspan="2" class="cadre_gris_vide">
          </td>
        </tr>

        <tr>
          <td class="cadre_gris moinsgros gras">
            <a class="dark blank" href="?maj=ra12">Re-alpha 12</a>
          </td>
          <td class="cadre_gris">
            Création des tables todo ; todo_commentaire ; todo_categorie ; roadmap
          </td>
        </tr>
        <tr>
          <td colspan="2" class="cadre_gris_vide">
          </td>
        </tr>

        <tr>
          <td class="cadre_gris moinsgros gras">
            <a class="dark blank" href="?maj=ra11">Re-alpha 11</a>
          </td>
          <td class="cadre_gris">
            Suppression de la table stats_pageviews_mois<br>
            Création des tables devblog ; devblog_commentaire<br>
            Suppression de .php à la fin des urls dans l'activité récente
          </td>
        </tr>

      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';