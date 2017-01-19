<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                     REDIRECTION DES SOUS-DOMAINES                                                     */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On récupère le sous-domaine en cours
$le_subd = explode('.',$_SERVER['HTTP_HOST']);

// Et on redirige vers le lieu approprié
if($_SERVER["SERVER_NAME"] != "localhost" && $_SERVER["SERVER_NAME"] != "127.0.0.1"  && $le_subd[0] != 'nobleme' && $le_subd[1] != 'com')
  header("Location: "."http://".$le_subd[1].".".$le_subd[2].$_SERVER['REQUEST_URI']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                            GESTION DU LOGIN                                                           */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Préparation de l'url complète de la page
$url_complete = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'] : substr(basename($_SERVER['PHP_SELF']),0,-4);
$url_logout   = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&amp;logout' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?logout';
$url_complete = destroy_html($url_complete);
$url_logout   = destroy_html($url_logout);

// Déconnexion
if(isset($_GET['logout']))
{
  // Déconnexion & redirection
  logout();
  header("location: ".substr($url_complete,0,-7));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                       CHECK MISE À JOUR EN COURS                                                      */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Récupération de l'état de maj
$checkmaj = query(" SELECT vars_globales.mise_a_jour FROM vars_globales ");
$majcheck = mysqli_fetch_array($checkmaj);

// Si maj, on ferme la machine (sauf pour les admins)
if($majcheck['mise_a_jour'] && @getadmin($_SESSION['user']) == 0)
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Une mise à jour est en cours, NoBleme est temporairement fermé.<br><br>Revenez dans quelques minutes.</body></html>');

// CSS spécial pendant les mises à jour
if(!$majcheck['mise_a_jour'])
  $css_body_maj = "";
else
  $css_body_maj = ' class="mise_a_jour"';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                              GESTION DES PAGEVIEWS ET DES STATS REFERER                                               */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération puis création ou incrémentation du pageview count de la page liée

if(isset($page_nom) && isset($page_id) && !isset($error_mode))
{
  // Réparation des erreurs au cas où
  $page_nom = postdata($page_nom);
  $page_id  = postdata($page_id);

  // Requête pour récupérer les pageviews sur la page courante
  $view_query = query(" SELECT  stats_pageviews.vues
                        FROM    stats_pageviews
                        WHERE   stats_pageviews.nom_page  = '$page_nom'
                        AND     stats_pageviews.id_page   = '$page_id' ");

  // Si la requête renvoie un résultat, reste plus qu'à incrémenter les pageviews
  if (mysqli_num_rows($view_query) != 0)
  {
    // On définit le nombre de pageviews
    $pageviews_array = mysqli_fetch_array($view_query);
    $pageviews = $pageviews_array["vues"] + 1;

    // On update la BDD si l'user n'est pas un admin
    if(((loggedin() && !getadmin($_SESSION['user'])) || !loggedin()))
      query(" UPDATE  stats_pageviews
              SET     stats_pageviews.vues      = stats_pageviews.vues + 1
              WHERE   stats_pageviews.nom_page  = '$page_nom'
              AND     stats_pageviews.id_page   = '$page_id' ");
  }

  // Sinon, il faut créer l'entrée de la page et lui donner son premier pageview
  else
  {
    // On définit le nombre de pageviews
    $pageviews = 1;

    // On update la BDD
    query(" INSERT INTO stats_pageviews
            SET         stats_pageviews.nom_page  = '$page_nom' ,
                        stats_pageviews.id_page   = '$page_id'  ,
                        stats_pageviews.vues      = 1           ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Traitement de l'activité récente / dernière page visitée

// On laisse pages.inc.php faire le travail préparatoire
include $chemin."./inc/pages.inc.php";

// On s'assure que l'user soit connecté
if(loggedin())
{
  // On prépare la date et l'user
  $visite_timestamp = time();
  $visite_user      = $_SESSION['user'];

  // Nettoyage des données au cas où
  $visite_page  = postdata($visite_page);
  $visite_url   = postdata($visite_url);

  // IP de l'user
  $visite_ip    = postdata($_SERVER["REMOTE_ADDR"]);

  // Puis on fait la requête d'update
  query(" UPDATE  membres
          SET     membres.derniere_visite       = '$visite_timestamp' ,
                  membres.derniere_visite_page  = '$visite_page'      ,
                  membres.derniere_visite_url   = '$visite_url'       ,
                  membres.derniere_visite_ip    = '$visite_ip'
          WHERE   membres.id                    = '$visite_user' ");
}
// Sinon on a affaire a un invité
else
{
  // On nettoie les vieilles infos
  $guest_limit = time() - 86400;
  query(" DELETE FROM invites WHERE invites.derniere_visite < '$guest_limit' ");

  // On va chercher s'il existe
  $guest_ip = postdata($_SERVER["REMOTE_ADDR"]);
  $qguest   = query(" SELECT invites.ip FROM invites WHERE invites.ip = '$guest_ip' ");

  // On crée l'invité si nécessaire
  if(!mysqli_num_rows($qguest))
  {
    $guest_nom = postdata(surnom_mignon());
    query(" INSERT INTO invites SET invites.ip = '$guest_ip', invites.surnom = '$guest_nom' ");
  }

  // Nettoyage des données au cas où
  $visite_page  = postdata($visite_page);
  $visite_url   = postdata($visite_url);

  // Et on met à jour les données
  $guest_timestamp = time();
  query(" UPDATE  invites
          SET     invites.derniere_visite       = '$guest_timestamp'  ,
                  invites.derniere_visite_page  = '$visite_page'      ,
                  invites.derniere_visite_url   = '$visite_url'
          WHERE   invites.ip                    = '$guest_ip'         ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si l'user est connecté, mise à jour de son referer

// On ne s'en occupe que si la page a un nom
if(isset($_SERVER['HTTP_REFERER']))
{
  // Abort si le visiteur se balade sur nobleme et ne vient pas de l'extérieur
  $referer = postdata($_SERVER['HTTP_REFERER']);
  $origine = parse_url($referer);
  if($origine['host'] != "www.nobleme.com" AND $origine['host'] != "nobleme.com" AND $origine['host'] != "localhost" AND $origine['host'] != "127.0.0.1")
  {
    // Requête pour récupérer le nombre de visiteurs venus par ce referrer
    $referer_query = query(" SELECT stats_referer.nombre FROM stats_referer WHERE stats_referer.source = '$referer' ");

    // Si la requête renvoie un résultat, reste plus qu'à incrémenter le compte de visiteurs
    if (mysqli_num_rows($referer_query) != 0)
      query(" UPDATE  stats_referer
              SET     stats_referer.nombre  = stats_referer.nombre + 1
              WHERE   stats_referer.source = '$referer'             ");

    // Sinon, il faut créer l'entrée de la source et lui donner son premier visiteur
    else
      query(" INSERT INTO stats_referer
              SET         stats_referer.source  = '$referer'  ,
                          stats_referer.nombre  = 1           ");
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des notifications

// Si l'user est connecté
if (loggedin())
{
  // Requête
  $qnotif = query(" SELECT  notifications.id
                    FROM    notifications
                    WHERE   notifications.date_consultation       = 0
                    AND     notifications.FKmembres_destinataire  = ".$_SESSION['user']."
                    LIMIT   1 " );

  // Préparation des données pour l'affichage
  $notifications  = mysqli_num_rows($qnotif);
  $notifs_texte   = ($notifications) ? ' (!)' : '';
  $notifs_css     = ($notifications) ? ' class="nouveaux_messages"' : '';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation de la liste des feuilles de style
//
// Les retours à la ligne bizarres sont pour préserver l'indentation du HTML

if (isset($css))
{
  // Si un CSS perso est défini, on inclut déjà nobleme.css
  $stylesheets = '<link rel="stylesheet" href="'.$chemin.'css/nobleme.css" type="text/css">';

  // Puis on loope les éléments de $css et on les ajoute aux css à inclure
  for($i=0;$i<count($css);$i++)
    $stylesheets .= '
    <link rel="stylesheet" href="'.$chemin.'css/'.$css[$i].'.css" type="text/css">';

  // Pour préserver l'indentation
  if (!isset($js))
    $stylesheets .= '
';
}

// Sinon, on se contente d'inclure nobleme.css
else
  $stylesheets = '<link rel="stylesheet" href="'.$chemin.'css/nobleme.css" type="text/css">
';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation de la liste des .js
//
// Les retours à la ligne bizarres sont pour préserver l'indentation du HTML

// Préparation de la liste des js
if (isset($js))
{
  $javascripts = '';

  // On loope les éléments de $js et on prépare le paquet de .js à inclure
  for($i=0;$i<count($js);$i++)
  {
    $javascripts .= '
    <script type="text/javascript" src="'.$chemin.'js/'.$js[$i].'.js"> </script>';
  }

  // Pour préserver l'indentation
  $javascripts .= '
';
}
else
  $javascripts = '
';

// Pluie de bites tournantes le premier avril
if(date('d-m') == '01-04' && ($_SERVER["SERVER_NAME"] != "localhost" || $_SERVER["SERVER_NAME"] != "127.0.0.1") && substr($_SERVER["PHP_SELF"],-6) != 'cv.php')
  $javascripts .= '
    <script type="text/javascript" src="'.$chemin.'js/festif.js"> </script>
';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation du titre de la page, sera uniquement NoBleme si aucun titre n'est précisé, et précédé d'un @ en localhost

if (!isset($page_titre))
  $page_titre = 'NoBleme';
else
  $page_titre = 'NoBleme - '.$page_titre;

if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1")
  $page_titre = "@ ".$page_titre;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation de la meta description de la page

// Si pas de description, truc générique par défaut
if (!isset($page_desc))
  $page_desc = "NoBleme, la communauté web qui n'apporte rien mais a réponse à tout";

// On remplace les caractères interdits pour éviter les conneries
$page_desc = meta_fix($page_desc);

// Si admin, alerte si la longueur est > les 158 caractères max ou < les 25 caractères min
if(loggedin() && getadmin($_SESSION['user']))
{
  if(strlen($page_desc) > 25 && strlen($page_desc) < 155)
    $alerte_meta = "";
  else if (strlen($page_desc) <= 25)
  {
    $alerte_meta  = "Description meta trop courte (".strlen($page_desc)." <= 25)";
    $css_maj      = "maj";
    $css_body_maj = ' class="maj"';
  }
  else
  {
    $alerte_meta  = "Description meta trop longue (".strlen($page_desc)." >= 155)";
    $css_maj      = "maj";
    $css_body_maj = ' class="maj"';
  }
}
else
  $alerte_meta = "";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remise à zéro des variables de menu si jamais elles sont vides

if(!isset($header_menu) || $header_menu == 'nobleme')
  $header_menu = '';
if(!isset($header_submenu))
  $header_submenu = '';
if(!isset($header_sidemenu))
  $header_sidemenu = '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/**************************************************************************************************************************************/ ?>

<!DOCTYPE html>
<html<?=$css_body_maj?>>
  <head>
    <title><?=$page_titre?></title>
    <link rel="shortcut icon" href="<?=$chemin?>img/divers/favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?=$page_desc?>">
    <?=$stylesheets?>
    <?=$javascripts?>
  </head>

  <?php if(isset($cette_page_est_404)) { ?>
  <body id="body" onLoad="ecrire_404();">
  <?php } else { ?>
  <body id="body">
  <?php } ?>

    <?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                                                                                                                   //
    //                                                          MENU  PRINCIPAL                                                          //
    //                                                                                                                                   //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

    <?php if(!isset($_GET["popup"]) && !isset($_GET["popout"]) && !isset($_GET["dynamique"])) { ?>

    <div class="menu_main">
      <div class="menu_main_section">
        <div class="menu_main_item<?=menu_css($header_menu,'',0)?>"
             onClick="location.href = '<?=$chemin?>'">
          <a                     href="<?=$chemin?>">NOBLEME.COM</a>
        </div>
        <div class="menu_main_item<?=menu_css($header_menu,'communaute',0)?>"
             onClick="location.href = '<?=$chemin?>pages/nobleme/index'">
          <a                     href="<?=$chemin?>pages/nobleme/index">COMMUNAUTÉ</a>
        </div>
        <div class="menu_main_item<?=menu_css($header_menu,'lire',0)?>"
             onClick="location.href = '<?=$chemin?>pages/nbdb/index'">
          <a                     href="<?=$chemin?>pages/nbdb/index">LIRE</a>
        </div>
        <div class="menu_main_item<?=menu_css($header_menu,'discuter',0)?>"
             onClick="location.href = '<?=$chemin?>pages/forum/index'">
          <a                     href="<?=$chemin?>pages/forum/index">DISCUTER</a>
        </div>
        <div class="menu_main_item<?=menu_css($header_menu,'secrets',0)?>"
             onClick="location.href = '<?=$chemin?>pages/secrets/index'">
          <a                     href="<?=$chemin?>pages/secrets/index">SECRETS</a>
        </div>
      </div>
      <div class="menu_main_section">
        <?php if(!loggedin()) { ?>
        <div class="menu_main_item<?=menu_css($header_menu,'connexion',0)?>"
             onClick="location.href = '<?=$chemin?>pages/user/login'">
          <a                     href="<?=$chemin?>pages/user/login">CONNEXION</a>
        </div>
        <div class="menu_main_item<?=menu_css($header_menu,'inscription',0)?>"
             onClick="location.href = '<?=$chemin?>pages/user/register'">
          <a                     href="<?=$chemin?>pages/user/register">S'INSCRIRE</a>
        </div>
        <?php } else { ?>
        <?php if(loggedin() && getsysop($_SESSION['user'])) { ?>
        <div class="menu_main_item<?=menu_css($header_menu,'admin',0)?>"
             onClick="location.href = '<?=$chemin?>pages/nobleme/activite?mod'">
          <a                     href="<?=$chemin?>pages/nobleme/activite?mod">ADMINISTRATION</a>
        </div>
        <?php } ?>
        <div class="menu_main_item<?=menu_css($header_menu,'compte',0)?>"
             onClick="location.href = '<?=$chemin?>pages/user/notifications'">
          <a                     href="<?=$chemin?>pages/user/notifications" <?=$notifs_css?>>MON COMPTE<?=$notifs_texte?></a>
        </div>
        <?php } ?>
      </div>
    </div>


    <?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                                                                                                                   //
    //                                                          MENU SECONDAIRE                                                          //
    //                                                                                                                                   //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

    <?php if ($header_menu == '' || $header_menu == 'connexion' || $header_menu == 'inscription') { ?>
    <div class="menu_sub">
      <div class="menu_sub_item<?=menu_css($header_submenu,'accueil',1)?>"
           onClick="location.href = '<?=$chemin?>'">
        <a                     href="<?=$chemin?>">Page d'accueil</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'activite',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nobleme/activite'">
        <a                     href="<?=$chemin?>pages/nobleme/activite">Activité récente</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'online',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nobleme/online'">
        <a                     href="<?=$chemin?>pages/nobleme/online">Qui est en ligne ?</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'dev',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nobleme/coulisses'">
        <a                     href="<?=$chemin?>pages/nobleme/coulisses">Développement</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'aide',1)?>"
           onClick="location.href = '<?=$chemin?>pages/doc/index'">
        <a                     href="<?=$chemin?>pages/doc/index">Aide &amp; Infos</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'communaute') { ?>
    <div class="menu_sub">
      <div class="menu_sub_item<?=menu_css($header_submenu,'membres',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nobleme/index'">
        <a                     href="<?=$chemin?>pages/nobleme/index">Membres</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'irl',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nobleme/irls'">
        <a                     href="<?=$chemin?>pages/nobleme/irls">Rencontres IRL</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'admins',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nobleme/admins'">
        <a                     href="<?=$chemin?>pages/nobleme/admins">Équipe administrative</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'lire') { ?>
    <div class="menu_sub">
      <div class="menu_sub_item<?=menu_css($header_submenu,'nbdb',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nbdb/index'">
        <a                     href="<?=$chemin?>pages/nbdb/index">NBDatabase</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'nbrpg',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nbrpg/index'">
        <a                     href="<?=$chemin?>pages/nbrpg/index">NoBlemeRPG</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'miscellanees',1)?>"
           onClick="location.href = '<?=$chemin?>pages/irc/quotes'">
        <a                     href="<?=$chemin?>pages/irc/quotes">Miscellanees</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'discuter') { ?>
    <div class="menu_sub">
      <div class="menu_sub_item<?=menu_css($header_submenu,'forum',1)?>"
           onClick="location.href = '<?=$chemin?>pages/forum/index'">
        <a                     href="<?=$chemin?>pages/forum/index">Forum NoBleme</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'ecrivains',1)?>"
           onClick="location.href = '<?=$chemin?>pages/forum/ecrivains'">
        <a                     href="<?=$chemin?>pages/forum/ecrivains">Le coin des écrivains</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'irc',1)?>"
           onClick="location.href = '<?=$chemin?>pages/irc/index'">
        <a                     href="<?=$chemin?>pages/irc/index">Chat IRC</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'admin') { ?>
    <div class="menu_sub">
      <div class="menu_sub_item<?=menu_css($header_submenu,'mod',1)?>"
           onClick="location.href = '<?=$chemin?>pages/nobleme/activite?mod'">
        <a                     href="<?=$chemin?>pages/nobleme/activite?mod">Modération</a>
      </div>
      <?php if(getadmin()) { ?>
      <div class="menu_sub_item<?=menu_css($header_submenu,'admin',1)?>"
           onClick="location.href = '<?=$chemin?>pages/todo/index?admin'">
        <a                     href="<?=$chemin?>pages/todo/index?admin">Administration</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'dev',1)?>"
           onClick="location.href = '<?=$chemin?>pages/dev/formattage'">
        <a                     href="<?=$chemin?>pages/dev/formattage">Développement</a>
      </div>
      <?php } ?>
    </div>

    <?php } else if ($header_menu == 'secrets') { ?>
    <div class="menu_sub">
      <div class="menu_sub_item<?=menu_css($header_submenu,'liste',1)?>"
           onClick="location.href = '<?=$chemin?>pages/secrets/index'">
        <a                     href="<?=$chemin?>pages/secrets/index">Liste des secrets</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'compte') { ?>
    <div class="menu_sub">
      <div class="menu_sub_item<?=menu_css($header_submenu,'messages',1)?>"
           onClick="location.href = '<?=$chemin?>pages/user/notifications'">
        <a                     href="<?=$chemin?>pages/user/notifications">Messages privés</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'profil',1)?>"
           onClick="location.href = '<?=$chemin?>pages/user/user?id=<?=$_SESSION['user']?>'">
        <a                     href="<?=$chemin?>pages/user/user?id=<?=$_SESSION['user']?>">Profil public</a>
      </div>
      <div class="menu_sub_item<?=menu_css($header_submenu,'reglages',1)?>"
           onClick="location.href = '<?=$chemin?>pages/user/reglages'">
        <a                     href="<?=$chemin?>pages/user/reglages">Réglages du compte</a>
      </div>
      <div class="menu_sub_item"
           onClick="location.href = '<?=$url_logout?>'">
        <a                     href="<?=$url_logout?>">Déconnexion</a>
      </div>
    </div>

    <?php } ?>


    <?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //                                                                                                                                   //
    //                                                           MENU  LATÉRAL                                                           //
    //                                                                                                                                   //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

    <div class="body_container">
      <?php if($header_sidemenu) { ?>

      <?php if($header_menu == '' && $header_submenu == 'dev') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'coulisses',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/coulisses'">
            <a                     href="<?=$chemin?>pages/nobleme/coulisses">Coulisses de NoBleme</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'source',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/coulisses?source'">
            <a                     href="<?=$chemin?>pages/nobleme/coulisses?source">Code source du site</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'roadmap',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/roadmap'">
            <a                     href="<?=$chemin?>pages/todo/roadmap">Plan de route</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'todo',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/index'">
            <a                     href="<?=$chemin?>pages/todo/index">Tâches non résolues</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'todo_solved',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/index?solved'">
            <a                     href="<?=$chemin?>pages/todo/index?solved">Tâches résolues</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'todo_recent',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/index?recent'">
            <a                     href="<?=$chemin?>pages/todo/index?recent">Tâches récentes</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'ticket',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/add'">
            <a                     href="<?=$chemin?>pages/todo/add">Ouvrir un ticket</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'todo_rss',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/rss'">
            <a                     href="<?=$chemin?>pages/todo/rss">Tâches : Flux RSS</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'devblog',2)?>"
               onClick="location.href = '<?=$chemin?>pages/devblog/index'">
            <a                     href="<?=$chemin?>pages/devblog/index">Blog de développement</a>
          </div>
          <div  class="menu_side_item<?=menu_css($header_sidemenu,'devblog_top',2)?>"
               onClick="location.href = '<?=$chemin?>pages/devblog/top'">
            <a                     href="<?=$chemin?>pages/devblog/top">Devblogs populaires</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'devblog_rss',2)?>"
               onClick="location.href = '<?=$chemin?>pages/devblog/rss'">
            <a                     href="<?=$chemin?>pages/devblog/rss">Devblogs : Flux RSS</a>
          </div>
          <hr class="menu_side_hr">
          <div  class="menu_side_item<?=menu_css($header_sidemenu,'ticket_bug',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/add?bug'">
            <a                     href="<?=$chemin?>pages/todo/add?bug">Rapporter un bug</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'ticket_feature',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/add?feature'">
            <a                     href="<?=$chemin?>pages/todo/add?feature">Quémander un feature</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == '' && $header_submenu == 'aide') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'documentation',2)?>"
               onClick="location.href = '<?=$chemin?>pages/doc/index'">
            <a                     href="<?=$chemin?>pages/doc/index">Documentation du site</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'nobleme',2)?>"
               onClick="location.href = '<?=$chemin?>pages/doc/nobleme'">
            <a                     href="<?=$chemin?>pages/doc/nobleme">Qu'est-ce que NoBleme</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'coc',2)?>"
               onClick="location.href = '<?=$chemin?>pages/doc/coc'">
            <a                     href="<?=$chemin?>pages/doc/coc">Code de conduite</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'bbcodes',2)?>"
               onClick="location.href = '<?=$chemin?>pages/doc/bbcodes'">
            <a                     href="<?=$chemin?>pages/doc/bbcodes">Utiliser les BBCodes</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'emotes',2)?>"
               onClick="location.href = '<?=$chemin?>pages/doc/emotes'">
            <a                     href="<?=$chemin?>pages/doc/emotes">Liste des émoticônes</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'rss',2)?>"
               onClick="location.href = '<?=$chemin?>pages/doc/rss'">
            <a                     href="<?=$chemin?>pages/doc/rss">S'abonner aux flux RSS</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'bug',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/add?bug&amp;doc'">
            <a                     href="<?=$chemin?>pages/todo/add?bug&amp;doc">Rapporter un bug</a>
          </div>

        </div>
      </nav>

      <?php } else if($header_menu == 'communaute' && $header_submenu == 'membres') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'portail',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/index'">
            <a                     href="<?=$chemin?>pages/nobleme/index">Portail des membres</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'liste',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/membres'">
            <a                     href="<?=$chemin?>pages/nobleme/membres">Liste des membres</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'anniversaires',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/anniversaires'">
            <a                     href="<?=$chemin?>pages/nobleme/anniversaires">Anniversaires</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'pilori',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/pilori'">
            <a                     href="<?=$chemin?>pages/nobleme/pilori">Pilori des bannis</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'lire' && $header_submenu == 'nbrpg') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'index',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/index'">
            <a                     href="<?=$chemin?>pages/nbrpg/index">Qu'est-ce que le NBRPG ?</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'liste_persos',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/joueurs_actifs'">
            <a                     href="<?=$chemin?>pages/nbrpg/joueurs_actifs">Liste des personnages</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'archive',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/archive'">
            <a                     href="<?=$chemin?>pages/nbrpg/archive">Archive des sessions</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'caverne',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/caverne'">
            <a                     href="<?=$chemin?>pages/nbrpg/caverne">La caverne de Liodain</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'historique',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/caverne?historique'">
            <a                     href="<?=$chemin?>pages/nbrpg/caverne?historique">Caverne : Historique</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'caverne_random',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/caverne?random'">
            <a                     href="<?=$chemin?>pages/nbrpg/caverne?random">Caverne : Page au hasard</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'client',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/client'">
            <a                     href="<?=$chemin?>pages/nbrpg/client">Client : Jouer au NBRPG</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'observer',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/client_spectateur'">
            <a                     href="<?=$chemin?>pages/nbrpg/client_spectateur">Observer le jeu en cours</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'fiche_perso',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/fiche_perso'">
            <a                     href="<?=$chemin?>pages/nbrpg/fiche_perso">Ma fiche de personnage</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'lire' && $header_submenu == 'miscellanees') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'paroles',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/quotes'">
            <a                     href="<?=$chemin?>pages/irc/quotes">Paroles de NoBlemeux</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'hasard',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/quotes?random'">
            <a                     href="<?=$chemin?>pages/irc/quotes?random">Citation au hasard</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'stats',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/quotes_stats'">
            <a                     href="<?=$chemin?>pages/irc/quotes_stats">Statistiques des citations</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'proposer',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/quote_add'">
            <a                     href="<?=$chemin?>pages/irc/quote_add">Proposer une citation</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'rss',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/quotes_rss'">
            <a                     href="<?=$chemin?>pages/irc/quotes_rss">Flux RSS des citations</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'discuter' && $header_submenu == 'irc') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'index',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/index'">
            <a                     href="<?=$chemin?>pages/irc/index">Qu'est-ce que IRC ?</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'clic',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/web'">
            <a                     href="<?=$chemin?>pages/irc/web">Discuter en un clic</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'traditions',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/traditions'">
            <a                     href="<?=$chemin?>pages/irc/traditions">Coutumes et traditions</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'canaux',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/canaux'">
            <a                     href="<?=$chemin?>pages/irc/canaux">Liste des canaux</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'services',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/services'">
            <a                     href="<?=$chemin?>pages/irc/services">Commandes et services</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'akundo',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/akundo'">
            <a                     href="<?=$chemin?>pages/irc/akundo">Utilisation d'Akundo</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'client',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/client'">
            <a                     href="<?=$chemin?>pages/irc/client">Installer un client IRC</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'bouncer',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/bouncer'">
            <a                     href="<?=$chemin?>pages/irc/bouncer">Utiliser un bouncer</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'admin' && $header_submenu == 'mod' && getsysop()) { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'modlogs',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/activite?mod'">
            <a                     href="<?=$chemin?>pages/nobleme/activite?mod">Logs de modération</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'bannir',2)?>"
               onClick="location.href = '<?=$chemin?>pages/sysop/ban'">
            <a                     href="<?=$chemin?>pages/sysop/ban">Bannir un utilisateur</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'profil',2)?>"
               onClick="location.href = '<?=$chemin?>pages/sysop/profil'">
            <a                     href="<?=$chemin?>pages/sysop/profil">Modifier un profil</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'pass',2)?>"
               onClick="location.href = '<?=$chemin?>pages/sysop/pass'">
            <a                     href="<?=$chemin?>pages/sysop/pass">Éditer un mot de passe</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'irl_add',2)?>"
               onClick="location.href = '<?=$chemin?>pages/sysop/irl?add'">
            <a                     href="<?=$chemin?>pages/sysop/irl?add">Créer une nouvelle IRL</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'irl_edit',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/irls?edit'">
            <a                     href="<?=$chemin?>pages/nobleme/irls?edit">Modifier une IRL</a>
          </div>
          <?php if(getadmin()) { ?>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'irl_delete',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nobleme/irls?delete'">
            <a                     href="<?=$chemin?>pages/nobleme/irls?delete">Supprimer une IRL</a>
          </div>
          <?php } ?>
        </div>
      </nav>

      <?php } else if($header_menu == 'admin' && $header_submenu == 'admin' && getadmin()) { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'stats_dop',2)?>"
               onClick="location.href = '<?=$chemin?>pages/admin/stats_doppelgangers'">
            <a                     href="<?=$chemin?>pages/admin/stats_doppelgangers">Stats : Doppelgängers</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'stats_views',2)?>"
               onClick="location.href = '<?=$chemin?>pages/admin/stats_pageviews'">
            <a                     href="<?=$chemin?>pages/admin/stats_pageviews">Stats : Visites</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'stats_views_evo',2)?>"
               onClick="location.href = '<?=$chemin?>pages/admin/stats_pageviews_evolution'">
            <a                     href="<?=$chemin?>pages/admin/stats_pageviews_evolution">Stats : Évolution visites</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'stats_refs',2)?>"
               onClick="location.href = '<?=$chemin?>pages/admin/stats_referers'">
            <a                     href="<?=$chemin?>pages/admin/stats_referers">Stats : Referers</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'stats_refs_evo',2)?>"
               onClick="location.href = '<?=$chemin?>pages/admin/stats_referers_evolution'">
            <a                     href="<?=$chemin?>pages/admin/stats_referers_evolution">Stats : Évolution referers</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'devblog_add',2)?>"
               onClick="location.href = '<?=$chemin?>pages/devblog/admin?add'">
            <a                     href="<?=$chemin?>pages/devblog/admin?add">Devblog : Nouveau</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'todo_add',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/admin?add'">
            <a                     href="<?=$chemin?>pages/todo/admin?add">Tâches : Nouveau ticket</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'todo_valider',2)?>"
               onClick="location.href = '<?=$chemin?>pages/todo/index?admin'">
            <a                     href="<?=$chemin?>pages/todo/index?admin">Tâches : En attente</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'quote_add',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/quote_add?admin'">
            <a                     href="<?=$chemin?>pages/irc/quote_add?admin">Miscellanées : Nouvelle</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'quote_valider',2)?>"
               onClick="location.href = '<?=$chemin?>pages/irc/quotes?admin'">
            <a                     href="<?=$chemin?>pages/irc/quotes?admin">Miscellanées : En attente</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'nbrpg_client',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/admin'">
            <a                     href="<?=$chemin?>pages/nbrpg/admin">NBRPG : Client admin</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'nbrpg_permissions',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/admin_permissions'">
            <a                     href="<?=$chemin?>pages/nbrpg/admin_permissions">NBRPG : Permissions</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'nbrpg_monstres',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/admin_monstres'">
            <a                     href="<?=$chemin?>pages/nbrpg/admin_monstres">NBRPG : Monstres</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'nbrpg_objets',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/admin_objets'">
            <a                     href="<?=$chemin?>pages/nbrpg/admin_objets">NBRPG : Objets</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'nbrpg_effets',2)?>"
               onClick="location.href = '<?=$chemin?>pages/nbrpg/admin_effets'">
            <a                     href="<?=$chemin?>pages/nbrpg/admin_effets">NBRPG : Effets</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'flashanniv',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/flashanniv'">
            <a                     href="<?=$chemin?>pages/dev/flashanniv">Gestion : Flashs anniv.</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'nompages',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/pages'">
            <a                     href="<?=$chemin?>pages/dev/pages">Gestion : Nom des pages</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'admin' && $header_submenu == 'dev' && getadmin()) { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'maj',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/maj'">
            <a                     href="<?=$chemin?>pages/dev/maj">Mise à jour : Checklist</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'sql',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/sql'">
            <a                     href="<?=$chemin?>pages/dev/sql">Mise à jour : Requêtes</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'ircbot',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/ircbot'">
            <a                     href="<?=$chemin?>pages/dev/ircbot">Gestion du bot IRC</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'formattage',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/formattage'">
            <a                     href="<?=$chemin?>pages/dev/formattage">Formattage du code</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'css',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/css'">
            <a                     href="<?=$chemin?>pages/dev/css">Référence du CSS</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'fonctions',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/fonctions'">
            <a                     href="<?=$chemin?>pages/dev/fonctions">Liste des fonctions</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'charte',2)?>"
               onClick="location.href = '<?=$chemin?>pages/dev/images'">
            <a                     href="<?=$chemin?>pages/dev/images">Charte graphique</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'compte' && $header_submenu == 'messages') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'ecrire',2)?>"
               onClick="location.href = '<?=$chemin?>pages/user/pm'">
            <a                     href="<?=$chemin?>pages/user/pm">Écrire un message</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'inbox',2)?>"
               onClick="location.href = '<?=$chemin?>pages/user/notifications'">
            <a                     href="<?=$chemin?>pages/user/notifications">Messages reçus</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'envoyes',2)?>"
               onClick="location.href = '<?=$chemin?>pages/user/notifications?envoyes'">
            <a                     href="<?=$chemin?>pages/user/notifications?envoyes">Messages envoyés</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'compte' && $header_submenu == 'reglages') { ?>
      <nav>
        <div class="menu_side">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'reglages',2)?>"
               onClick="location.href = '<?=$chemin?>pages/user/reglages'">
            <a                     href="<?=$chemin?>pages/user/reglages">Réglages généraux</a>
          </div>
          <hr class="menu_side_hr">
          <div class="menu_side_item<?=menu_css($header_sidemenu,'email',2)?>"
               onClick="location.href = '<?=$chemin?>pages/user/email'">
            <a                     href="<?=$chemin?>pages/user/email">Changer d'e-mail</a>
          </div>
          <div class="menu_side_item<?=menu_css($header_sidemenu,'pass',2)?>"
               onClick="location.href = '<?=$chemin?>pages/user/pass'">
            <a                     href="<?=$chemin?>pages/user/pass">Changer de mot de passe</a>
          </div>
        </div>
      </nav>

      <?php } ?>
      <?php } ?>

      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      //                                                                                                                                 //
      //                                                          FIN DES MENUS                                                          //
      //                                                                                                                                 //
      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>


      <div class="body_contenu">

      <?php } if($alerte_meta != "") { ?>

      <br>
      <br>

      <div class="gros gras texte_erreur align_center monospace">
        <?=$alerte_meta?>
      </div>

      <?php } ?>