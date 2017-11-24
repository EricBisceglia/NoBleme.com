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
/*                                                    GESTION DU LOGIN ET DU LANGAGE                                                     */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Préparation des URLs pour la déconnexion et le changement de langue
$url_logout   = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&logout' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?logout';
$url_langage  = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&changelang=1' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?changelang=1';
$url_logout   = destroy_html($url_logout);
$url_langage  = destroy_html($url_langage);

// Déconnexion
if(isset($_GET['logout']))
{
  // Déconnexion & redirection
  logout();
  unset($_GET['logout']);
  $url_self     = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_rebuild  = urldecode(http_build_query($_GET));
  $url_rebuild  = ($url_rebuild) ? $url_self.'?'.$url_rebuild : $url_self;
  exit(header("Location: ".$url_rebuild));
}

// On va chercher si le langage choisi est couvert par la page
if(isset($langage_page))
  $langage_error = (!in_array($lang, $langage_page)) ? 1 : 0;
else
  $langage_error = 0;

// Et on prépare les strings d'erreur selon la langue
if($langage_error)
  $langage_error = ($lang == 'FR') ? "Cette page n'est disponible qu'en anglais et n'a pas de traduction française." : "Sorry! This page is only available in french and does not have an english translation.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                       CHECK MISE À JOUR EN COURS                                                      */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Récupération de l'état de maj
$checkmaj = query(" SELECT vars_globales.mise_a_jour FROM vars_globales ");
$majcheck = mysqli_fetch_array($checkmaj);

// Si maj, on ferme la machine (sauf pour les admins)
if($majcheck['mise_a_jour'] && !getadmin())
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Une mise à jour est en cours, NoBleme est temporairement fermé.<br><br>Revenez dans quelques minutes.<br><br><br><br>An update is in progress, NoBleme is temporarily closed.<br><br>Come back in a few minutes.</body></html>');

// CSS spécial pendant les mises à jour
if(!$majcheck['mise_a_jour'])
{
  $css_mise_a_jour  = "";
  $css_mise_a_jour2 = "";
}
else
{
  $css_mise_a_jour  = " mise_a_jour";
  $css_mise_a_jour2 = " mise_a_jour_background";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         GESTION DES PAGEVIEWS                                                         */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération puis création ou incrémentation du pageview count de la page liée

if(isset($page_nom) && isset($page_url) && !isset($error_mode))
{
  // Réparation des erreurs au cas où
  $page_nom = postdata($page_nom, 'string');
  $page_url = postdata($page_url, 'string');

  // Requête pour récupérer les pageviews sur la page courante
  $view_query = query(" SELECT  pageviews.vues
                        FROM    pageviews
                        WHERE   pageviews.url_page  = '$page_url' ");

  // Si la requête renvoie un résultat, reste plus qu'à incrémenter les pageviews
  if (mysqli_num_rows($view_query) != 0)
  {
    // On définit le nombre de pageviews
    $pageviews_array = mysqli_fetch_array($view_query);
    $pageviews = $pageviews_array["vues"] + 1;

    // On update la BDD si l'user n'est pas un admin
    if(((loggedin() && !getadmin()) || !loggedin()))
      query(" UPDATE  pageviews
              SET     pageviews.vues      = pageviews.vues + 1 ,
                      pageviews.nom_page  = '$page_nom'
              WHERE   pageviews.url_page  = '$page_url' ");
  }

  // Sinon, il faut créer l'entrée de la page et lui donner son premier pageview
  else
  {
    // On définit le nombre de pageviews
    $pageviews = 1;

    // On update la BDD
    query(" INSERT INTO pageviews
            SET         pageviews.nom_page  = '$page_nom' ,
                        pageviews.url_page  = '$page_url' ,
                        pageviews.vues      = 1           ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Traitement de l'activité récente / dernière page visitée

// On récupère le nom et l'url de la page s'ils sont précisés
$activite_page  = (isset($page_nom)) ? $page_nom  : 'Page non listée';
$activite_url   = (isset($page_url)) ? $page_url  : '';

// On s'assure que l'user soit connecté
if(loggedin())
{
  // On prépare la date et l'user
  $visite_timestamp = time();
  $visite_user      = $_SESSION['user'];

  // Nettoyage des données au cas où
  $activite_page  = postdata($activite_page, 'string');
  $activite_url   = postdata($activite_url, 'string');

  // IP de l'user
  $visite_ip    = postdata($_SERVER["REMOTE_ADDR"], 'string');

  // Puis on fait la requête d'update
  query(" UPDATE  membres
          SET     membres.derniere_visite       = '$visite_timestamp' ,
                  membres.derniere_visite_page  = '$activite_page'      ,
                  membres.derniere_visite_url   = '$activite_url'       ,
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
  $guest_ip = postdata($_SERVER["REMOTE_ADDR"], 'string');
  $qguest   = query(" SELECT invites.ip FROM invites WHERE invites.ip = '$guest_ip' ");

  // On crée l'invité si nécessaire
  if(!mysqli_num_rows($qguest))
  {
    $guest_nom = postdata(surnom_mignon(), 'string');
    query(" INSERT INTO invites SET invites.ip = '$guest_ip', invites.surnom = '$guest_nom' ");
  }

  // Nettoyage des données au cas où
  $activite_page  = postdata($activite_page, 'string');
  $activite_url   = postdata($activite_url, 'string');

  // Et on met à jour les données
  $guest_timestamp = time();
  query(" UPDATE  invites
          SET     invites.derniere_visite       = '$guest_timestamp'  ,
                  invites.derniere_visite_page  = '$activite_page'      ,
                  invites.derniere_visite_url   = '$activite_url'
          WHERE   invites.ip                    = '$guest_ip'         ");
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
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation de la liste des feuilles de style
//
// Les retours à la ligne bizarres sont pour préserver l'indentation du HTML

if (isset($css))
{
  // Si un CSS perso est défini, on inclut déjà reset.css, header.css, et nobleme.css
  $stylesheets = '<link rel="stylesheet" href="'.$chemin.'css/reset.css" type="text/css">
    <link rel="stylesheet" href="'.$chemin.'css/header.css" type="text/css">
    <link rel="stylesheet" href="'.$chemin.'css/nobleme.css" type="text/css">';

  // Puis on loope les éléments de $css et on les ajoute aux css à inclure
  for($i=0;$i<count($css);$i++)
    $stylesheets .= '
    <link rel="stylesheet" href="'.$chemin.'css/'.$css[$i].'.css" type="text/css">';

  // Pour préserver l'indentation
  if (!isset($js))
    $stylesheets .= '
';
}

// Sinon, on se contente d'inclure reset.css, header.css, et nobleme.css
else
  $stylesheets = '<link rel="stylesheet" href="'.$chemin.'css/reset.css" type="text/css">
    <link rel="stylesheet" href="'.$chemin.'css/header.css" type="text/css">
    <link rel="stylesheet" href="'.$chemin.'css/nobleme.css" type="text/css">
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
if(date('d-m') == '01-04' && ($_SERVER["SERVER_NAME"] != "localhost" || $_SERVER["SERVER_NAME"] != "127.0.0.1") && substr($_SERVER["PHP_SELF"],-6) != 'cv.php' && substr($_SERVER["PHP_SELF"],-2) != 'cv')
  $javascripts .= '
    <script type="text/javascript" src="'.$chemin.'js/festif.js"> </script>
';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation du titre de la page, sera uniquement NoBleme si aucun titre n'est précisé, et précédé d'un @ en localhost

if(isset($page_url) && $page_url == "cv")
  $page_titre = $page_titre;
else if (!isset($page_titre))
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
if(loggedin() && getadmin())
{
  if(strlen($page_desc) > 25 && strlen($page_desc) < 155)
    $alerte_meta = "";
  else if (strlen($page_desc) <= 25)
  {
    $alerte_meta  = "Description meta trop courte (".strlen($page_desc)." <= 25)";
    $css_maj      = "maj";
  }
  else
  {
    $alerte_meta  = "Description meta trop longue (".strlen($page_desc)." >= 155)";
    $css_maj      = "maj";
  }
}
else
  $alerte_meta = "";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remise à zéro des variables de menu si jamais elles sont vides

if(!isset($header_menu) || $header_menu == '')
  $header_menu = 'NoBleme';
if(!isset($header_sidemenu))
  $header_sidemenu = '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction renvoyant le CSS à utiliser pour un élément du header selon s'il est sélectionné ou non
//
// Paramètres :
// $element : l'élément dont on veut renvoyer la classe
// $actuel : l'élément actuellement sélectionné
// $menu : le menu dont l'élément fait partie
//
// Exemple : header_class('NoBleme','Accueil','top');

function header_class($element, $actuel, $menu)
{
  if($menu == 'top')
    return (strtolower($element) == strtolower($actuel)) ? 'header_topmenu_titre header_topmenu_selected' : 'header_topmenu_titre';
  else if($menu == 'side')
    return (strtolower($element) == strtolower($actuel)) ? 'header_sidemenu_item header_sidemenu_selected' : 'header_sidemenu_item';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/**************************************************************************************************************************************/ ?>

<!DOCTYPE html>
<html lang="<?=changer_casse($lang,'min')?>">
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




<!-- ######################################################################################################################################
#                                                                 MENUS                                                                   #
###################################################################################################################################### !-->

<?php ####################################################### MENU PRINCIPAL ##############################################################
// Préparation des traductions des titres
$menu['discuter'] = ($lang == 'FR') ? 'DISCUTER'  : 'TALK';
$menu['jouer']    = ($lang == 'FR') ? 'JOUER'     : 'PLAY';
$menu['lire']     = ($lang == 'FR') ? 'LIRE'      : 'READ';
/* ########################################################################## */ if(!isset($_GET["popup"]) && !isset($_GET["popout"])) { ?>

    <div class="header_topmenu<?=$css_mise_a_jour?>">
      <div id="header_titres" class="header_topmenu_zone">

        <a class="header_topmenu_lien" href="<?=$chemin?>index">
          <div class="<?=header_class('NoBleme',$header_menu,'top')?>">NOBLEME</div>
        </a>

        <a class="header_topmenu_lien" href="<?=$chemin?>pages/irc/index">
          <div class="<?=header_class('Discuter',$header_menu,'top')?>"><?=$menu['discuter']?></div>
        </a>

        <?php if($lang == 'FR') { ?>
        <a class="header_topmenu_lien" href="<?=$chemin?>pages/quotes/index">
          <div class="<?=header_class('Lire',$header_menu,'top')?>"><?=$menu['lire']?></div>
        </a>
        <?php } ?>

        <a class="header_topmenu_lien" href="<?=$chemin?>pages/nbrpg/index">
          <div class="<?=header_class('Jouer',$header_menu,'top')?>"><?=$menu['jouer']?></div>
        </a>

        <?php if(loggedin() && getsysop()) { ?>
        <a class="header_topmenu_lien" href="<?=$chemin?>pages/nobleme/activite?mod">
          <div class="<?=header_class('Admin',$header_menu,'top')?>">ADMIN</div>
        </a>

        <?php } if(loggedin() && getadmin()) { ?>
        <a class="header_topmenu_lien" href="<?=$chemin?>pages/dev/ircbot">
          <div class="<?=header_class('Dev',$header_menu,'top')?>">DEV</div>
        </a>
        <?php } ?>
      </div>
      <div class="header_topmenu_zone header_topmenu_flag">
        <a href="<?=$url_langage?>">
          <?php if($lang == 'FR') { ?>
          <img class="header_topmenu_flagimg" src="<?=$chemin?>img/icones/lang_en.png" alt="EN">
          <?php } else { ?>
          <img class="header_topmenu_flagimg" src="<?=$chemin?>img/icones/lang_fr.png" alt="FR">
          <?php } ?>
        </a>
      </div>
    </div>




<?php ###################################################### GESTION DU LOGIN #############################################################
// Préparation des traductions des phrases liées au compte
$getpseudo              = predata(getpseudo());
$submenu['message']     = ($lang == 'FR') ? "$getpseudo, vous avez reçu un nouveau message, cliquez ici pour le lire !" : "$getpseudo, you have recieved a new message, click here to read it!";
$submenu['connecté']    = ($lang == 'FR') ? "Vous êtes connecté en tant que $getpseudo. Cliquez ici pour modifier votre profil et/ou gérer votre compte" : "You are logged in as $getpseudo. Click here to edit your profile and/or manage your account.";
$submenu['deconnexion'] = ($lang == 'FR') ? "Déconnexion" : "Log out";
$submenu['connexion']   = ($lang == 'FR') ? "Vous n'êtes pas connecté: Cliquez ici pour vous identifier ou vous enregistrer" : "You are not logged in: Click here to login or register.";
######################################################################################################################################## ?>

    <div class="menu_sub<?=$css_mise_a_jour2?>">
      <?php if(loggedin()) {
            if($notifications) { ?>
      <div class="header_topmenu_zone">
        <a id="nouveaux_messages" class="menu_sub_lien nouveaux_messages" href="<?=$chemin?>pages/user/notifications">
          <?=$submenu['message']?>
        </a>
      </div>
      <?php } else { ?>
      <div class="header_topmenu_zone">
        <a id="nouveaux_messages"  class="menu_sub_lien" href="<?=$chemin?>pages/user/notifications">
          <?=$submenu['connecté']?>
        </a>
      </div>
      <?php } ?>
      <div class="header_topmenu_zone">
        <a class="menu_sub_lien" href="<?=$url_logout?>">
          <?=$submenu['deconnexion']?>
        </a>
      </div>
      <?php } else { ?>
      <div class="header_topmenu_zone">
        <a class="menu_sub_lien" href="<?=$chemin?>pages/user/login">
          <?=$submenu['connexion']?>
        </a>
      </div>
      <?php } ?>
    </div>




<?php ######################################################## MENU LATÉRAL ###############################################################
// Préparation des traductions
$sidemenu['afficher'] = ($lang == 'FR') ? 'Afficher le menu latéral'  : 'Show the side menu';
$sidemenu['masquer']  = ($lang == 'FR') ? 'Masquer le menu latéral'   : 'Hide the side menu';
######################################################################################################################################## ?>

    <script>
    // Faire disparaitre la suggestion de menu latéral quand on scrolle
    window.addEventListener('scroll', function() {

      // On applique ceci seulement si le menu est caché
      if(window.getComputedStyle(document.getElementById('header_sidemenu')).display == 'none')
      {
        // On détecte où en est le scrolling
        var currentscroll = Math.max(document.body.scrollTop,document.documentElement.scrollTop);

        // Si on est en haut, on affiche, sinon, on masque
        if(!currentscroll)
          document.getElementById('header_nomenu').style.display = 'inline';
        else
          document.getElementById('header_nomenu').style.display = 'none';
      }
    }, true);
    </script>

    <div class="containermenu">
      <div class="header_side_nomenu" id="header_nomenu" onclick="document.getElementById('header_sidemenu').style.display = 'flex'; document.getElementById('header_nomenu').style.display = 'none';">
        <?=$sidemenu['afficher']?>
      </div>
      <nav id="header_sidemenu" class="header_sidemenu_mobile<?=$css_mise_a_jour2?>">
        <div class="header_sidemenu">
          <div>
            <div class="header_sidemenu_item header_sidemenu_desktop" onclick="document.getElementById('header_nomenu').style.display = 'flex'; document.getElementById('header_sidemenu').style.display = 'none';">
              <?=$sidemenu['masquer']?>
            </div>
            <hr class="header_sidemenu_hr header_sidemenu_desktop">




<?php ################################################### MENU LATÉRAL : NOBLEME ##########################################################
// Préparation des traductions des titres du menu
$sidemenu['nb_accueil']     = ($lang == 'FR') ? "Page d'accueil"        : "Home page";
$sidemenu['nb_activite']    = ($lang == 'FR') ? "Activité récente"      : "Recent activity";
$sidemenu['nb_communaute']  = ($lang == 'FR') ? "Communauté"            : "Community";
$sidemenu['nb_enligne']     = ($lang == 'FR') ? "Qui est en ligne"      : "Who's online";
$sidemenu['nb_admins']      = ($lang == 'FR') ? "Équipe administrative" : "Staff and admins";
$sidemenu['nb_membres']     = ($lang == 'FR') ? "Liste des membres"     : "Registered user list";
$sidemenu['nb_annivs']      = ($lang == 'FR') ? "Anniversaires"         : "Member birthdays";
$sidemenu['nb_irls']        = ($lang == 'FR') ? "Rencontres IRL"        : "Real life meetups";
$sidemenu['nb_irlstats']    = ($lang == 'FR') ? "Statistiques des IRL"  : "RL meetup stats";
$sidemenu['nb_aide']        = ($lang == 'FR') ? "Aide & Informations"   : "Help / Documentation";
$sidemenu['nb_doc']         = ($lang == 'FR') ? "Documentation du site" : "Website documentation";
$sidemenu['nb_nobleme']     = ($lang == 'FR') ? "Qu'est-ce que NoBleme" : "What is NoBleme";
$sidemenu['nb_coc']         = ($lang == 'FR') ? "Code de conduite"      : "Code of conduct";
$sidemenu['nb_rss']         = ($lang == 'FR') ? "Flux RSS"              : "RSS feeds";
$sidemenu['nb_dev']         = ($lang == 'FR') ? "Développement"         : "Development";
$sidemenu['nb_coulisses']   = ($lang == 'FR') ? "Coulisses de NoBleme"  : "Behind the scenes";
$sidemenu['nb_bug']         = ($lang == 'FR') ? "Rapporter un bug"      : "Report a bug";
$sidemenu['nb_feature']     = ($lang == 'FR') ? "Quémander un feature"  : "Request a feature";
/* ################################################################################################## */ if($header_menu == 'NoBleme') { ?>

            <div class="header_sidemenu_titre">
              NoBleme.com
            </div>

            <a href="<?=$chemin?>index">
              <div class="<?=header_class('Accueil',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_accueil']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/nobleme/activite">
              <div class="<?=header_class('ActiviteRecente',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_activite']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['nb_communaute']?>
            </div>

            <a href="<?=$chemin?>pages/nobleme/online?noguest">
              <div class="<?=header_class('QuiEstEnLigne',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_enligne']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/nobleme/admins">
              <div class="<?=header_class('EquipeAdmin',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_admins']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/nobleme/membres">
              <div class="<?=header_class('ListeDesMembres',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_membres']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/nobleme/anniversaires">
              <div class="<?=header_class('Anniversaires',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_annivs']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/irl/index">
              <div class="<?=header_class('IRL',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_irls']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/irl/stats">
              <div class="<?=header_class('IRLstats',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_irlstats']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['nb_aide']?>
            </div>

            <a href="<?=$chemin?>pages/doc/index">
              <div class="<?=header_class('Doc',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_doc']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/doc/nobleme">
              <div class="<?=header_class('QuEstCeQueNoBleme',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_nobleme']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/doc/coc">
              <div class="<?=header_class('CoC',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_coc']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/doc/rss">
              <div class="<?=header_class('RSS',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_rss']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['nb_dev']?>
            </div>

            <a href="<?=$chemin?>pages/nobleme/coulisses">
              <div class="<?=header_class('Coulisses',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_coulisses']?>
              </div>
            </a>

            <?php if($lang == 'FR') { ?>

            <a href="<?=$chemin?>pages/devblog/index">
              <div class="<?=header_class('Devblog',$header_sidemenu,'side')?>">
                Blog de développement
              </div>
            </a>

            <a href="<?=$chemin?>pages/todo/index">
              <div class="<?=header_class('TodoList',$header_sidemenu,'side')?>">
                Liste des tâches
              </div>
            </a>

            <a href="<?=$chemin?>pages/todo/roadmap">
              <div class="<?=header_class('Roadmap',$header_sidemenu,'side')?>">
                Plan de route
              </div>
            </a>

            <?php } ?>

            <a href="<?=$chemin?>pages/todo/request">
              <div class="<?=header_class('OuvrirTicket',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_feature']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/todo/request?bug">
              <div class="<?=header_class('OuvrirTicketBug',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_bug']?>
              </div>
            </a>




<?php } ################################################ MENU LATÉRAL : DISCUTER ##########################################################
// Préparation des traductions des titres du menu
$sidemenu['bla_forum']            = ($lang == 'FR') ? "Forum de discussion"       : "Discussion forum";
$sidemenu['bla_forum_sujets']     = ($lang == 'FR') ? "Travaux en cours"          : "Work in progress";
$sidemenu['bla_irc']              = ($lang == 'FR') ? "Serveur de chat IRC"       : "IRC chat server";
$sidemenu['bla_irc_what']         = ($lang == 'FR') ? "Qu'est-ce que IRC"         : "What is IRC";
$sidemenu['bla_irc_clic']         = ($lang == 'FR') ? "Rejoindre la conversation" : "Join the conversation";
$sidemenu['bla_irc_canaux']       = ($lang == 'FR') ? "Liste des canaux"          : "Channel list";
$sidemenu['bla_irc_services']     = ($lang == 'FR') ? "Commandes et services"     : "Commands and services";
/* ################################################################################################# */ if($header_menu == 'Discuter') { ?>

            <div class="header_sidemenu_titre">
              <?=$sidemenu['bla_irc']?>
            </div>

            <a href="<?=$chemin?>pages/irc/index">
              <div class="<?=header_class('IRC',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_what']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/irc/client">
              <div class="<?=header_class('IRCClient',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_clic']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/irc/services">
              <div class="<?=header_class('IRCServices',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_services']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/irc/canaux">
              <div class="<?=header_class('IRCCanaux',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_canaux']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['bla_forum']?>
            </div>

            <a href="<?=$chemin?>pages/forum/index">
              <div class="<?=header_class('ForumIndex',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_forum_sujets']?>
              </div>
            </a>




<?php } ################################################## MENU LATÉRAL : LIRE ############################################################
// Pas de traductions de titres dans cette section, elle n'est pas multilingue (pour le moment ?)
/* ##################################################################################################### */ if($header_menu == 'Lire') { ?>

            <?php if($lang == 'FR') { ?>

            <div class="header_sidemenu_titre">
              Miscellanées
            </div>

            <a href="<?=$chemin?>pages/quotes/index">
              <div class="<?=header_class('MiscIndex',$header_sidemenu,'side')?>">
                Paroles de NoBlemeux
              </div>
            </a>

            <a href="<?=$chemin?>pages/quotes/quote?random">
              <div class="<?=header_class('MiscRandom',$header_sidemenu,'side')?>">
                Miscellanée au hasard
              </div>
            </a>

            <a href="<?=$chemin?>pages/quotes/stats">
              <div class="<?=header_class('MiscStats',$header_sidemenu,'side')?>">
                Stats des miscellanées
              </div>
            </a>

            <a href="<?=$chemin?>pages/quotes/add">
              <div class="<?=header_class('MiscAdd',$header_sidemenu,'side')?>">
                Proposer une miscellanée
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              NBDatabase
            </div>

            <a href="<?=$chemin?>pages/nbdb/index">
              <div class="<?=header_class('NBDBIndex',$header_sidemenu,'side')?>">
                Travaux en cours
              </div>
            </a>

            <?php } else { ?>
            <div class="header_sidemenu_titre">
              This section of the
            </div>
            <div class="header_sidemenu_titre">
              website isn't available
            </div>
            <div class="header_sidemenu_titre">
              in english, sorry :(
            </div>
            <?php } ?>




<?php } ################################################## MENU LATÉRAL : JOUER ###########################################################
// Préparation des traductions des titres du menu
$sidemenu['jeu_nbrpg_index']  = ($lang == 'FR') ? "Qu'est-ce que le NBRPG"  : "What is the NBRPG";
$sidemenu['jeu_nrm_rip']      = ($lang == 'FR') ? "En souvenir du NRM"      : "Remembering the NRM";
$sidemenu['jeu_nrm_podium']   = ($lang == 'FR') ? "Champions du passé"      : "Champions of the past";
$sidemenu['jeu_radikal']      = ($lang == 'FR') ? "Projet: Radikal"         : "Project: Radikal";
$sidemenu['jeu_radikal_hype'] = ($lang == 'FR') ? "Le prochain jeu NoBleme" : "The next NoBleme game";
/* #################################################################################################### */ if($header_menu == 'Jouer') { ?>

            <div class="header_sidemenu_titre">
              NoBlemeRPG
            </div>

            <a href="<?=$chemin?>pages/nbrpg/index">
              <div class="<?=header_class('NBRPGWhat',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_nbrpg_index']?>
              </div>
            </a>

            <?php if($lang == 'FR') { ?>
            <a href="<?=$chemin?>pages/nbrpg/archives">
              <div class="<?=header_class('NBRPGArchives',$header_sidemenu,'side')?>">
                Sessions archivées
              </div>
            </a>
            <?php } ?>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              NRM Online
            </div>

            <a href="<?=$chemin?>pages/nrm/index">
              <div class="<?=header_class('NRM',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_nrm_rip']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/nrm/podium">
              <div class="<?=header_class('NRMPodium',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_nrm_podium']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['jeu_radikal']?>
            </div>

            <a href="<?=$chemin?>pages/radikal/hype">
              <div class="<?=header_class('RadikalHype',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_radikal_hype']?>
              </div>
            </a>




<?php } ################################################# MENU LATÉRAL : COMPTE ###########################################################
// Préparation des traductions des titres du menu
$sidemenu['user_notifs']          = ($lang == 'FR') ? "Messagerie privée"       : "Private messages";
$sidemenu['user_notifs_inbox']    = ($lang == 'FR') ? "Boîte de réception"      : "Account inbox";
$sidemenu['user_notifs_outbox']   = ($lang == 'FR') ? "Messages envoyés"        : "Sent messages";
$sidemenu['user_notifs_envoyer']  = ($lang == 'FR') ? "Composer un message"     : "Write a message";
$sidemenu['user_profil']          = ($lang == 'FR') ? "Profil public"           : "Public profile";
$sidemenu['user_profil_self']     = ($lang == 'FR') ? "Voir mon profil public"  : "My public profile";
$sidemenu['user_profil_edit']     = ($lang == 'FR') ? "Modifier mon profil"     : "Edit my profile";
$sidemenu['user_reglages']        = ($lang == 'FR') ? "Réglages du compte"      : "Account settings";
$sidemenu['user_reglages_email']  = ($lang == 'FR') ? "Changer d'e-mail"        : "Change my e-mail";
$sidemenu['user_reglages_pass']   = ($lang == 'FR') ? "Changer de mot de passe" : "Change my password";
$sidemenu['user_reglages_pseudo'] = ($lang == 'FR') ? "Changer de pseudonyme"   : "Change my nickname";
$sidemenu['user_reglages_delete'] = ($lang == 'FR') ? "Supprimer mon compte"    : "Delete my account";
/* ################################################################################################### */ if($header_menu == 'Compte') { ?>

            <div class="header_sidemenu_titre">
              <?=$sidemenu['user_notifs']?>
            </div>

            <a href="<?=$chemin?>pages/user/notifications">
              <div class="<?=header_class('Notifications',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_notifs_inbox']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/user/notifications?envoyes">
              <div class="<?=header_class('MessagesEnvoyes',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_notifs_outbox']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/user/pm">
              <div class="<?=header_class('ComposerMessage',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_notifs_envoyer']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['user_profil']?>
            </div>

            <a href="<?=$chemin?>pages/user/user">
              <div class="<?=header_class('MonProfil',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_profil_self']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/user/profil">
              <div class="<?=header_class('ModifierProfil',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_profil_edit']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['user_reglages']?>
            </div>

            <a href="<?=$chemin?>pages/user/email">
              <div class="<?=header_class('ChangerEmail',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_email']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/user/pass">
              <div class="<?=header_class('ChangerPass',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_pass']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/user/pseudo">
              <div class="<?=header_class('ChangerPseudo',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_pseudo']?>
              </div>
            </a>

            <a href="<?=$chemin?>pages/user/delete">
              <div class="<?=header_class('SupprimerCompte',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_delete']?>
              </div>
            </a>




<?php } /* ############################################## MENU LATÉRAL : ADMIN ######################## */ if($header_menu == 'Admin') { ?>

            <div class="header_sidemenu_titre">
              Activité récente
            </div>

            <a href="<?=$chemin?>pages/nobleme/activite?mod">
              <div class="<?=header_class('Modlogs',$header_sidemenu,'side')?>">
                Logs de modération
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Gestion des membres
            </div>

            <a href="<?=$chemin?>pages/sysop/pilori">
              <div class="<?=header_class('Pilori',$header_sidemenu,'side')?>">
                Pilori des bannis
              </div>
            </a>

            <a href="<?=$chemin?>pages/sysop/ban">
              <div class="<?=header_class('Bannir',$header_sidemenu,'side')?>">
                Bannir un utilisateur
              </div>
            </a>

            <a href="<?=$chemin?>pages/sysop/profil">
              <div class="<?=header_class('ModifierProfil',$header_sidemenu,'side')?>">
                Modifier un profil
              </div>
            </a>

            <a href="<?=$chemin?>pages/sysop/pass">
              <div class="<?=header_class('ChangerPass',$header_sidemenu,'side')?>">
                Changer un mot de passe
              </div>
            </a>

            <?php if(getadmin()) { ?>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Outils administratifs
            </div>

            <a href="<?=$chemin?>pages/admin/permissions">
              <div class="<?=header_class('Permissions',$header_sidemenu,'side')?>">
                Changer les permissions
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Statistiques
            </div>

            <a href="<?=$chemin?>pages/admin/pageviews">
              <div class="<?=header_class('Pageviews',$header_sidemenu,'side')?>">
                Popularité des pages
              </div>
            </a>

            <a href="<?=$chemin?>pages/admin/doppelganger">
              <div class="<?=header_class('Doppelganger',$header_sidemenu,'side')?>">
                Doppelgänger
              </div>
            </a>

            <?php } ?>




<?php } /* ################################################ MENU LATÉRAL : DEV ########################## */ if($header_menu == 'Dev') { ?>

            <div class="header_sidemenu_titre">
              Bot IRC NoBleme
            </div>

            <a href="<?=$chemin?>pages/dev/ircbot">
              <div class="<?=header_class('IRCbot',$header_sidemenu,'side')?>">
                Gestion du bot IRC
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Gestion du site
            </div>

            <a href="<?=$chemin?>pages/dev/maj">
              <div class="<?=header_class('MajChecklist',$header_sidemenu,'side')?>">
                Mise à jour : Checklist
              </div>
            </a>

            <a href="<?=$chemin?>pages/dev/sql">
              <div class="<?=header_class('MajRequetes',$header_sidemenu,'side')?>">
                Requêtes SQL
              </div>
            </a>

            <a href="<?=$chemin?>pages/dev/fermeture">
              <div class="<?=header_class('MajFermeture',$header_sidemenu,'side')?>">
                Ouvrir/fermer le site
              </div>
            </a>

            <a href="<?=$chemin?>pages/dev/version">
              <div class="<?=header_class('MajVersion',$header_sidemenu,'side')?>">
                Numéro de version
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Références de code
            </div>

            <a href="<?=$chemin?>pages/dev/snippets">
              <div class="<?=header_class('Snippets',$header_sidemenu,'side')?>">
                Snippets de code
              </div>
            </a>

            <a href="<?=$chemin?>pages/dev/reference">
              <div class="<?=header_class('Reference',$header_sidemenu,'side')?>">
                Référence HTML / CSS
              </div>
            </a>

            <a href="<?=$chemin?>pages/dev/fonctions">
              <div class="<?=header_class('Fonctions',$header_sidemenu,'side')?>">
                Référence des fonctions
              </div>
            </a>


          <?php } ?>

          </div>
        </div>
      </nav>

  <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                                                     //
  //                                                            FIN DES MENUS                                                            //
  //                                                                                                                                     //
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

<!-- ######################################################################################################################################
#                                                                 CORPS                                                                   #
###################################################################################################################################### !-->

    <div class="flex_element contenu_page">

      <?php } if($alerte_meta != "") { ?>

      <br>
      <br>

      <div class="gros gras texte_erreur align_center monospace">
        <?=$alerte_meta?>
      </div>

      <?php } if($langage_error) { ?>

      <div class="gros gras texte_erreur align_center monospace">
        <?=$langage_error?>
      </div>

      <br>

      <hr class="separateur_contenu">

      <br>

      <?php } ?>