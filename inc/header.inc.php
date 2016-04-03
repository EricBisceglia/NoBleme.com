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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation de l'url complète de la page pour login/logout

$url_complete = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.htmlspecialchars($_SERVER['QUERY_STRING']) : substr(basename($_SERVER['PHP_SELF']),0,-4);
$url_logout   = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.htmlspecialchars($_SERVER['QUERY_STRING']).'&amp;logout' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?logout';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Connexion

if(isset($_POST['nobleme_login_x']))
{
  // Récupération du postdata
  $pseudo   = destroy_html(postdata($_POST['nobleme_pseudo']));
  $pass     = destroy_html(postdata($_POST['nobleme_pass']));
  $souvenir = postdata_vide('nobleme_souvenir');

  // Vérification que le pseudo & pass sont bien rentrés
  if($pseudo != "" && $pass != "")
  {
    // On check si la personne tente de bruteforce nobleme
    $brute_ip     = postdata($_SERVER["REMOTE_ADDR"]);
    $timecheck    = (time() - 3600);
    $qcheckbrute  = query(" SELECT COUNT(*) AS 'num_brute' FROM membres_essais_login WHERE ip = '$brute_ip' AND timestamp > '$timecheck' ");
    $checkbrute   = mysqli_fetch_array($qcheckbrute);
    if( $checkbrute['num_brute'] > 9 )
      exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Non mais ho, c\'est quoi cette tentative de choper les mots de passe des gens ?<br><br>Vous êtes privé d\'utiliser un compte sur NoBleme pendant une heure.<br><br>Revenez quand vous serez calmé.<br><br>Couillon.</body></html>');
    else
    {
      // On récupère les pseudos correspondant au pseudo rentré
      $login = query(" SELECT membres.pass , membres.pass_old , membres.id FROM membres WHERE membres.pseudonyme = '$pseudo' ");

      // On s'arrête là si ça ne renvoie pas de résultat
      if (mysqli_num_rows($login) == 0)
        $erreur = "Ce pseudonyme n'existe pas";
      else
      {

        // On sale le mot de passe, puis on compare si le pass entré correspond au pass stocké
        $passtest     = salage($pass);
        $passtest_old = old_salage($pass);

        while($logins = mysqli_fetch_array($login))
        {
          // Vérifions s'il y a bruteforce
          $login_id         = $logins['id'];
          $timecheck        = (time() - 300);
          $qcheckbruteforce = query(" SELECT COUNT(*) AS 'num_brute' FROM membres_essais_login WHERE FKmembres = '$login_id' AND timestamp > '$timecheck' ");
          $checkbruteforce  = mysqli_fetch_array($qcheckbruteforce);

          // Pas de bruteforce? Allons-y
          $login_ok     = 0;
          $bonpass      = $logins['pass'];
          $bonpass_old  = $logins['pass_old'];

          if(($bonpass === $passtest || $bonpass_old === $passtest_old ) && $checkbruteforce['num_brute'] < 5)
          {
            // C'est bon, on peut login
            $login_ok = 1;

            // Si on en est encore au vieux pass, on le fait sauter et on met le nouveau pass à la place
            if($bonpass_old !== 'nope')
              query(" UPDATE membres SET pass = '$passtest' , pass_old = 'nope' WHERE id = '$login_id' ");
          }
          else if ($checkbruteforce['num_brute'] >= 5)
            $erreur = "Trop d'essais de connexion à ce compte dans les 5 dernières minutes &nbsp;&nbsp;<a href=\"".$chemin."pages/user/register?oublie\" class=\"header_whitelink\">Mot de passe oublié ?</a>";
        }

        // Si le pass est pas bon, dehors. Et tant qu'on y est, on log l'essai en cas de bruteforce
        if($login_ok == 0 && $checkbruteforce['num_brute'] < 5)
        {
          $timestamp  = time();
          query(" INSERT INTO membres_essais_login SET FKmembres = '$login_id' , timestamp = '$timestamp' , ip = '$brute_ip' ");
          $erreur     = "Mot de passe incorrect &nbsp;&nbsp;<a href=\"".$chemin."pages/user/register?oublie\" class=\"header_whitelink\">Mot de passe oublié ?</a>";
        }
        else if ($checkbruteforce['num_brute'] < 5)
        {
          // On est bons, reste plus qu'à se connecter!
          if($souvenir == "ok")
          {
            // Si checkbox se souvenir est cochée, on crée un cookie
            setcookie("nobleme_memory", old_salage($pseudo) , time()+630720000, "/");
            $_SESSION['user'] = $login_id;
          }
          else
          {
            // Sinon, on se contente d'ouvrir une session
            $_SESSION['user'] = $login_id;
          }

          // Validation & redirection
          $erreur = "Login ok, rechargez la page";
          header("location: ".$url_complete);

        }
      }
    }

  }
  // Si pseudo & pass ne sont pas correctement entrés, messages d'erreur
  else if ($pseudo != "" && $pass == "")
    $erreur = "Vous n'avez pas rentré de mot de passe.";
  else if ($pseudo == "" && $pass != "")
    $erreur = "Vous n'avez pas rentré de pseudonyme.";
  else
    $erreur = "Vous n'avez pas rentré d'identifiants.";
}
else
  $erreur = "";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
// Si l'user est connecté, mise à jour de son referer & de son langage

// On ne s'en occupe que si la page a un nom
if(isset($_SERVER['HTTP_REFERER']))
{
  // Abort si le visiteur se balade sur nobleme et ne vient pas de l'extérieur
  $referer = $_SERVER['HTTP_REFERER'];
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
  $qnotif = query(" SELECT  COUNT(*)                                                                      AS total ,
                            COUNT(CASE WHEN notifications.FKmembres_envoyeur != '0' THEN 1 ELSE NULL END) AS pm
                    FROM    notifications
                    WHERE   notifications.date_consultation       = 0
                    AND     notifications.FKmembres_destinataire  = ".$_SESSION['user'] );

  // Récupération des données
  $notifs       = mysqli_fetch_array($qnotif);
  $total_notif  = $notifs['total'];
  $notif        = $notifs['total'] - $notifs['pm'];
  $pms          = $notifs['pm'];

  // Préparation de la phrase à afficher dans le header
  if ($notif == 0 && $pms == 0)
    $notifications = "";
  else if ($notif == 1 && $pms == 0)
    $notifications = "Vous avez 1 nouvelle notification !";
  else if ($pms == 0)
    $notifications = "Vous avez ".$notif." nouvelles notifications !";
  else if ($pms == 1 && $notif == 0)
    $notifications = "Vous avez 1 nouveau message privé !";
  else if ($pms == 1 && $notif == 1)
    $notifications = "Vous avez 1 nouveau message et 1 notification !";
  else if ($notif == 0)
    $notifications = "Vous avez ".$pms." nouveaux messages privés !";
  else if ($pms == 1)
    $notifications = "Vous avez 1 nouveau message privé et ".$notif." notifications !";
  else if ($notif == 1)
    $notifications = "Vous avez ".$pms." nouveaux messages privés et 1 notification !";
  else
    $notifications = "Vous avez ".$pms." nouveaux messages privés et ".$notif." notifications !";
}
else
  $notifications = "";



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
if(date('d-m') == '01-04' && ($_SERVER["SERVER_NAME"] != "localhost" || $_SERVER["SERVER_NAME"] != "127.0.0.1"))
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
// Préparation de l'URL de l'image du header

// Détermineront si on montre des images de header amusantes pour certains users
$rand_conneries_connes    = rand(0,9);
$rand_conneries_normales  = rand(0,4);

// Pour quand on est en dev
if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1" )
  $header_image = "nobleme_dev.png";

// Des conneries pour certains users
else if(loggedin() && getpseudo() == 'Planeshift')
  $header_image = "nobleme_popup.png";
else if(loggedin() && getpseudo() == 'Wan')
  $header_image = "nobleme_mlle_milis.png";
else if(!$rand_conneries_normales && loggedin() && getpseudo() == 'ThArGos')
  $header_image = "nobleme_kiwis.png";
else if(!$rand_conneries_connes && loggedin() && getpseudo() == 'Enerhpozyks')
  $header_image = "nobleme_posix.png";
else if(!$rand_conneries_connes && loggedin() && getpseudo() == 'Kutz')
  $header_image = "nobleme_fabrice.png";

// Si c'est l'anniv de nobleme
else if(date('d-m') == '19-03')
  $header_image = "nobleme_anniv.png";

// Sinon, on pioche un logo au hasard
else
{
  // On va compter le nombre de fichiers qui existent
  $nlogos = 1;
  for($i = 0 ; file_exists($chemin.'img/logos/nobleme_'.($i+1).'.png') ; $i++)
    $nlogos ++;

  // Et on file un logo aléatoire dans le tas
  $header_image = "nobleme_".rand(1,$nlogos-1).".png";
}




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
    <style type="text/css">
            a.dropdown { background: url('<?=$chemin?>img/divers/fleche.png') 160px 7px no-repeat;       }
      a.dropdown:hover { background: url('<?=$chemin?>img/divers/fleche_hover.png') 160px 7px no-repeat; }
    </style>
  </head>

  <?php if(isset($cette_page_est_404)) { ?>
  <body id="body" onLoad="ecrire_404();">
  <?php } else { ?>
  <body id="body">
  <?php } ?>

    <?php if(!isset($_GET["popup"]) && !isset($_GET["popout"]) && !isset($_GET["dynamique"])) { ?>

    <form name="login" action="<?=$url_complete?>" method="POST">
      <div class="header header_logo">
        <table class="header_login">
          <tr>

            <?php if(!loggedin()) { ?>
            <td rowspan="4">
            <?php } else { ?>
            <td>
            <?php } ?>

              <a class="header_logo nonlien" href="<?=$chemin?>">
                <img src="<?=$chemin?>img/logos/<?=$header_image?>" alt="Logo">
              </a>
            </td>
            <?php if(!loggedin()) { ?>
            <td colspan="2"></td>
            <?php } ?>
          </tr>

          <?php if(!loggedin()) { ?>

          <tr>
            <td class="login_row align_right">
              Pseudonyme :&nbsp;
            </td>
            <td class="login_row2">
             <input type="text" name="nobleme_pseudo" class="intable">
           </td>
          </tr>
          <tr>
            <td class="login_row align_right">
              Mot de passe :&nbsp;
            </td>
            <td class="login_row2">
              <input type="password" name="nobleme_pass" class="intable">
            </td>
          </tr>
          <tr>
            <td colspan="2" class="login_row3">
              <table class="header_login">
                <tr>
                  <td class="login_row3">
                    <input type="checkbox" name="nobleme_souvenir" value="ok"> Se souvenir de moi
                  </td>
                  <td class="login_row3">
                    <input type="image" src="<?=$chemin?>img/boutons/connexion.png" name="nobleme_login" alt="Connexion">
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <?php } ?>

        </table>
      </div>
    </form>

    <div class="header header_menu">
      <ul id="menu_main">

        <li class="menu_first">NoBleme
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>">
                Page d'accueil
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/nobleme/activite">
                Activité récente
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/nobleme/online">
                Qui est en ligne ?
              </a>
            </li>

            <li>
              <a class="dropdown">
                Communauté
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/membres">
                    Liste des membres
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/admins">
                    Équipe administrative
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/anniversaires">
                    Anniversaires
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/pilori">
                    Pilori des bannis
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/irls">
                    Organisation des IRL
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/irlstats">
                    Statistiques des IRL
                  </a>
                </li>

              </ul>
            </li>

            <li>
              <a class="dropdown">
                Développement
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/coulisses">
                    Coulisses de NoBleme
                  </a>
                </li>

                <li>
                  <a class="dropdown">
                    Blog de développement
                  </a>
                  <ul class="menu_main">

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/devblog/blog">
                        Devblog le plus récent
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/devblog/index">
                        Liste des devblogs
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/devblog/top">
                        Devblogs populaires
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/devblog/rss">
                        Flux RSS
                      </a>
                    </li>

                  </ul>
                </li>

                <li>
                  <a class="dropdown">
                    Liste des tâches
                  </a>
                  <ul class="menu_main">

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/todo/roadmap">
                        Plan de route
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/todo/index">
                        Tous les tickets ouverts
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/todo/index?recent">
                        Derniers tickets ouverts
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/todo/index?solved">
                        Derniers tickets résolus
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/todo/add">
                        Ouvrir un ticket
                      </a>
                    </li>

                    <li>
                      <a class="menu_link" href="<?=$chemin?>pages/todo/rss">
                        Flux RSS
                      </a>
                    </li>

                  </ul>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/todo/add?bug">
                    Rapporter un bug
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/todo/add?feature">
                    Proposer un feature
                  </a>
                </li>

              </ul>
            </li>

          </ul>
        </li>

        <li>Chat IRC
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/irc/index">
                Qu'est-ce que IRC ?
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/irc/web">
                Venir discuter en un clic
              </a>
            </li>

            <li>
              <a class="dropdown">
                Documentation d'IRC
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/traditions">
                    Coutumes et traditions
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/canaux">
                    Liste des canaux
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/services">
                    Commandes et services
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/akundo">
                    Utilisation d'Akundo
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/client">
                    Installer un client IRC
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/bouncer">
                    Utiliser un bouncer
                  </a>
                </li>

              </ul>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/irc/quotes">
                Miscellanées
              </a>
            </li>

            <!--
            <li>
              <a class="dropdown">
                Miscellanées
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/misc">
                    Paroles de NoBlemeux
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/misc_add">
                    Proposer une citation
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/misc?random">
                    Citation au hasard
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/irc/misc_search">
                    Chercher une citation
                  </a>
                </li>

                <li>
                  <a class="menu_link">
                    <s>Flux RSS</s>
                  </a>
                </li>

              </ul>
            </li>
            -->

          </ul>
        </li>

        <li>Forum

          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/forum/index">
                Le Forum NoBleme... ?
              </a>
            </li>

          </ul>

        </li>

        <li>NBDatabase

          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/wiki/index">
                NBDatabase en travaux :(
              </a>
            </li>

          </ul>

        </li>

        <li>Aide &amp; Infos
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/doc/index">
                Documentation du site
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/doc/nobleme">
                Qu'est-ce que NoBleme ?
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/doc/coc">
                Code de conduite
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/doc/rss">
                S'abonner aux flux RSS
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/todo/add?bug">
                Rapporter un bug
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/user/pm?user=1">
                Contacter l'administration
              </a>
            </li>

          </ul>
        </li>

        <?php if(loggedin()) { ?>

        <li>Mon compte
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/user/notifications">
                Notifications
              </a>
            </li>

            <li>
              <a class="dropdown">
                Messages privés
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/user/pm">
                    Écrire un message privé
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/user/notifications">
                    Boite de réception
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/user/notifications?envoyes">
                    Messages envoyés
                  </a>
                </li>

              </ul>
            </li>

            <li>
              <a class="dropdown">
                Profil public
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/user/user?id=<?=$_SESSION['user']?>">
                    Voir mon profil
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/user/profil">
                    Modifier mon profil
                  </a>
                </li>

              </ul>
            </li>

            <li>
              <a class="dropdown">
                Réglages / Sécurité
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/user/email">
                    Changer d'e-mail
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/user/pass">
                    Changer de mot de passe
                  </a>
                </li>

              </ul>
            </li>

          </ul>
        </li>

        <?php } if(getsysop()) { ?>

        <li>Modération
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/nobleme/activite?mod">
                Logs de modération
              </a>
            </li>

            <li>
              <a class="dropdown">
                Utilisateurs
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/sysop/ban">
                    Bannir un utilisateur
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/sysop/profil">
                    Modifier un profil public
                  </a>
                </li>


                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/sysop/pass">
                    Modifier un mot de passe
                  </a>
                </li>

              </ul>
            </li>

            <li>
              <a class="dropdown">
                Orginasation des IRL
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/sysop/irl?add">
                    Créer une nouvelle IRL
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/irls?edit">
                    Modifier une IRL existante
                  </a>
                </li>

                <?php if(getadmin()) { ?>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/nobleme/irls?delete">
                    Supprimer une IRL
                  </a>
                </li>

                <?php } ?>

              </ul>
            </li>

          </ul>
        </li>

        <?php } if(getadmin()) { ?>

        <li>Administration
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/devblog/admin?add">
                Nouveau devblog
              </a>
            </li>

            <li>
              <a class="dropdown">
                Liste des tâches
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/todo/admin?add">
                    Nouveau ticket
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/todo/index?admin">
                    Tickets à valider
                  </a>
                </li>

              </ul>
            </li>

            <li>
              <a class="dropdown">
                Statistiques
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/admin/stats_doppelgangers">
                    Doppelgängers
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/admin/stats_pageviews">
                    Pageviews : Global
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/admin/stats_pageviews_evolution">
                    Pageviews : Évolution
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/admin/stats_referers">
                    Referers : Global
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/admin/stats_referers_evolution">
                    Referers : Évolution
                  </a>
                </li>

              </ul>
            </li>

          </ul>
        </li>

        <li>Développement
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/dev/maj">
                Mise à jour : Checklist
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/dev/sql">
                Mise à jour : Requêtes
              </a>
            </li>

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/dev/ircbot">
                Gestion du bot IRC
              </a>
            </li>

            <li>
              <a class="dropdown">
                Références
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/dev/formattage">
                    Formattage du code
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/dev/css">
                    Référence du CSS
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/dev/fonctions">
                    Liste des fonctions
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/dev/images">
                    Références graphiques
                  </a>
                </li>

              </ul>
            </li>

            <li>
              <a class="dropdown">
                Gestion
              </a>
              <ul class="menu_main">

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/dev/pages">
                    Nom des pages
                  </a>
                </li>

                <li>
                  <a class="menu_link" href="<?=$chemin?>pages/dev/flashanniv">
                    Flashs anniversaire
                  </a>
                </li>

              </ul>
            </li>

          </ul>
        </li>

        <li><s>Life.base</s></li>

        <?php } ?>

        <li>
          <span class="menu_secret">
            Secrets
          </span>
          <ul class="menu_main menu_low">

            <li>
              <a class="menu_link" href="<?=$chemin?>pages/nobleme/secrets">
                Liste des secrets
              </a>
            </li>

          </ul>
        </li>

      </ul>

    </div>

    <div class="header header_bottom">
      <table class="indiv">
        <tr>
          <td class="header_info_left">
            <a class="header_notif" href="<?=$chemin?>pages/user/notifications"><?=$notifications?></a>
          </td>
          <td class="header_info_right align_right texte_blanc">

            <?php if(!loggedin()) {
              if (!$erreur) { ?>

            Vous n'êtes pas connecté

              <?php } else { ?>

            Erreur : <?=$erreur?>

              <?php } ?>

            &nbsp;&nbsp;<a href="<?=$chemin?>pages/user/register" class="header_whitelink">Créer un compte</a>

            <?php } else { ?>

            Vous êtes connecté en tant que <a class="header_whiteblank" href="<?=$chemin?>pages/user/user?id=<?=$_SESSION['user']?>"><?=getpseudo()?></a>&nbsp;&nbsp;<a href="<?=$url_logout?>" class="header_whitelink">Déconnexion</a>

            <?php } ?>

          </td>
        </tr>
      </table>
    </div>

    <?php } if($alerte_meta != "") { ?>

    <br>
    <br>

    <div class="gros gras texte_erreur align_center monospace">
      <?=$alerte_meta?>
    </div>

    <?php } ?>

    <!-- Fin du header -->