<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                 THIS PAGE CAN ONLY BE USED IN SPECIFIC SITUATIONS                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Restrictions and prerequisites

// If we are on a subdomain, strip the subdomain from the url - prepare some data required for this action
$subdomain_check    = explode('.',$_SERVER['HTTP_HOST']);
$domain_name        = explode('.',$GLOBALS['domain_name']);
$domain_name_start  = $domain_name[0];
$domain_name_end    = $domain_name[1];

// This website should really only be used on localhost, 127.0.0.1, ::1, and whatever the website's domain name is
if($_SERVER["SERVER_NAME"] != "localhost" && $_SERVER["SERVER_NAME"] != "127.0.0.1"  && $_SERVER["SERVER_NAME"] != "::1" && $_SERVER["SERVER_NAME"] != "[::1]" && $subdomain_check[0] != $domain_name_start && $domain_name_end != 'com')
  header("Location: "."http://".$subdomain_check[1].".".$subdomain_check[2].$_SERVER['REQUEST_URI']);

// If the user permission variables don't exist, stop here
if(!isset($is_admin) || !isset($is_global_moderator) || !isset($is_moderator))
  exit(__('error_forbidden'));

// If the user doesn't have a set language, stop here
if(!isset($lang))
  exit(__('error_forbidden'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default variable values (those are required by the header but it's fine if they're not set)

// If there are no header menu / header sidemenu variables, reset them to their default value
$header_menu      = (!isset($header_menu) || $header_menu == '') ? 'NoBleme' : $header_menu;
$header_sidemenu  = (!isset($header_sidemenu)) ? 'Homepage' : $header_sidemenu;

// Check whether the page exist in the user's current language - if not, throw an error message
$lang_error = (isset($page_lang) && !in_array($lang, $page_lang)) ? 1 : 0;

// If page names and URLs for user activity are not set, give them a default value
$activity_page_en = (isset($page_name_en))  ? $page_name_en   : 'Unlisted page';
$activity_page_fr = (isset($page_name_fr))  ? $page_name_fr   : 'Page non listée';
$activity_url     = (isset($page_url))      ? $page_url       : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 WEBSITE SHUTDOWN                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Check if a website update is in progress
$qupdate  = query(" SELECT  system_variables.update_in_progress AS 'update'
                    FROM    system_variables
                    LIMIT   1 ");
$dupdate = mysqli_fetch_array($qupdate);

// If yes, close the website to anyone who's not an admin
if($dupdate['update'] && !$is_admin)
  exit(__('error_website_update'));

// During updates, change some of the CSS properties to remind admins that the website is closed
$website_update_css   = ($dupdate['update']) ? " website_update" : "";
$website_update_css2  = ($dupdate['update']) ? " website_update_background" : "";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  LOGIN / LOGOUT                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Creation of URLs to use for logging out and changing language
$url_logout = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&logout' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?logout';
$url_lang   = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&changelang=1' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?changelang=1';
$url_logout = sanitize_output($url_logout);
$url_lang   = sanitize_output($url_lang);

// Logout
if(isset($_GET['logout']))
{
  // Log the user out
  logout();

  // Redirect to the page without the 'logout' query param
  unset($_GET['logout']);
  $url_self     = mb_substr(basename($_SERVER['PHP_SELF']), 0, -4);
  $url_rebuild  = urldecode(http_build_query($_GET));
  $url_rebuild  = ($url_rebuild) ? $url_self.'?'.$url_rebuild : $url_self;
  exit(header("Location: ".$url_rebuild));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      METRICS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// View count of the current page

// We only go through this if the page name and url are set before the header
if(isset($page_name_en) && isset($page_url) && !isset($error_mode))
{
  // Sanitize data before using it in queries
  $page_name_sanitized  = sanitize($page_name_en, 'string');
  $page_url_sanitized   = sanitize($page_url, 'string');

  // Fetch current page's view count
  $qpageviews = query(" SELECT  stats_pageviews.view_count AS 'p_views'
                        FROM    stats_pageviews
                        WHERE   stats_pageviews.page_url = '$page_url_sanitized' ");

  // Define the current view count (used in the footer for metrics)
  $dpageviews = mysqli_fetch_array($qpageviews);
  $pageviews  = ($dpageviews["p_views"]) ? ($dpageviews["p_views"] + 1) : 1;

  // If the page exists, increment its view count (unless user is an admin)
  if(!$is_admin && mysqli_num_rows($qpageviews) != 0)
    query(" UPDATE  stats_pageviews
            SET     stats_pageviews.view_count  = stats_pageviews.view_count + 1 ,
                    stats_pageviews.page_name   = '$page_name_sanitized'
            WHERE   stats_pageviews.page_url    = '$page_url_sanitized' ");

  // If it doesn't, create the page and give it its first pageview
  else if(!$dpageviews["p_views"])
    query(" INSERT INTO stats_pageviews
            SET         stats_pageviews.page_name   = '$page_name_sanitized'  ,
                        stats_pageviews.page_url    = '$page_url_sanitized'   ,
                        stats_pageviews.view_count  = 1                       ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// User and guest activity

// Fetch and sanitize all the data required to track recent activity
$activity_timestamp         = time();
$activity_ip                = sanitize($_SERVER["REMOTE_ADDR"], 'string');
$activity_page_en_sanitized = sanitize($activity_page_en, 'string');
$activity_page_fr_sanitized = sanitize($activity_page_fr, 'string');
$activity_url_sanitized     = sanitize($activity_url, 'string');
$activity_user              = (user_is_logged_in()) ? sanitize(user_get_id(), 'int', 0) : 0;

// Logged in user activity
if(user_is_logged_in())
  query(" UPDATE  users
          SET     users.last_visited_at       = '$activity_timestamp'         ,
                  users.last_visited_page_en  = '$activity_page_en_sanitized' ,
                  users.last_visited_page_fr  = '$activity_page_fr_sanitized' ,
                  users.last_visited_url      = '$activity_url_sanitized'     ,
                  users.current_ip_address    = '$activity_ip'
          WHERE   users.id                    = '$activity_user'              ");

// Guest activity
else
{
  // Clean up older guest activity
  $guest_limit = time() - 86400;
  query(" DELETE FROM users_guests
          WHERE       users_guests.last_visited_at < '$guest_limit' ");

  // Check whether the guest already exists in the database
  $qguest   = query(" SELECT  users_guests.ip_address AS 'g_ip'
                      FROM    users_guests
                      WHERE   users_guests.ip_address = '$activity_ip' ");

  // Create the guest if it does not exist
  if(!mysqli_num_rows($qguest))
  {
    // Generate a random nickname
    $guest_name_en = sanitize(user_generate_random_nickname('EN'), 'string');
    $guest_name_fr = sanitize(user_generate_random_nickname('FR'), 'string');

    // Create the guest
    query(" INSERT INTO users_guests
            SET         users_guests.ip_address                 = '$activity_ip'    ,
                        users_guests.randomly_assigned_name_en  = '$guest_name_en'  ,
                        users_guests.randomly_assigned_name_fr  = '$guest_name_fr'  ");
  }

  // Et on met à jour les données
  query(" UPDATE  users_guests
          SET     users_guests.last_visited_at      = '$activity_timestamp'         ,
                  users_guests.last_visited_page_en = '$activity_page_en_sanitized' ,
                  users_guests.last_visited_page_fr = '$activity_page_fr_sanitized' ,
                  users_guests.last_visited_url     = '$activity_url_sanitized'
          WHERE   users_guests.ip_address           = '$activity_ip'                ");
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 PRIVATE MESSAGES                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Check only if the user is logged in
if (user_is_logged_in())
{
  // Fetch unreal private message count
  $qpms = query(" SELECT  COUNT(*) AS 'pm_nb'
                  FROM    users_private_messages
                  WHERE   users_private_messages.read_at            = 0
                  AND     users_private_messages.fk_users_recipient = '$activity_user' ");

  // Fetch the result for display
  $dpms                 = mysqli_fetch_array($qpms);
  $nb_private_messages  = $dpms['pm_nb'];
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  HEADER CONTENTS                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page title

// If the current page is the admin's CV, leave the title as is
if(isset($page_url) && $page_url == "cv")
  $page_title = $page_title;

// If the current page is unnamed, simply call it NoBleme
else if (!$page_title)
  $page_title = 'NoBleme';

// If the current page has a name, call it by its name preceded by NoBleme
else
  $page_title = 'NoBleme - '.$page_title;

// If we are working on localhost, add an @ before the page's title
if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1" || $_SERVER["SERVER_NAME"] == "::1" || $_SERVER["SERVER_NAME"] == "[::1]")
  $page_title = "@ ".$page_title;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page description

// If there is no description, use the default generic french one
$page_description = (isset($page_description)) ? $page_description : "NoBleme, la communauté web qui n'apporte rien mais a réponse à tout";

// Make the page's description W3C meta tag compliant
$page_description = html_fix_meta_tags($page_description);

// If the user is an admin, show a warning if the page description is too long
if($is_admin)
{
  // No warning if the description is of correct length
  if(strlen($page_description) > 25 && strlen($page_description) < 155)
    $meta_alert = "";

  // Warning if the description is too short
  else if (strlen($page_description) <= 25)
    $meta_alert  = __('header_meta_error_short', 0, 0, 0, array(strlen($page_description)));

  // Warning if the description is too long
  else
    $meta_alert  = __('header_meta_error_long', 0, 0, 0, array(strlen($page_description)));
}

// No warning if the user is not an admin
else
  $meta_alert = "";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  FILE INCLUSIONS                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// CSS stylesheets

// Include the default stylesheets (weird line breaks are for indentation)
$stylesheets = '<link rel="stylesheet" href="'.$path.'css/reset.css" type="text/css">
    <link rel="stylesheet" href="'.$path.'css/header.css" type="text/css">
    <link rel="stylesheet" href="'.$path.'css/nobleme.css" type="text/css">';

// If extra stylesheets are set, add them to the list
if (isset($css))
{
  // Loop through all extra sheets and include them
  for($i = 0; $i < count($css); $i++)
    $stylesheets .= '
    <link rel="stylesheet" href="'.$path.'css/'.$css[$i].'.css" type="text/css">';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// JavaScript files

// By default none are included (line break to preserve indentation)
$javascripts = '';

// If extra JS files are set, add them to the list
if (isset($js))
{
  // Loop through all files and include them
  for($i = 0; $i < count($js); $i++)
    $javascripts .= '
    <script src="'.$path.'js/'.$js[$i].'.js"> </script>';
}

// On april 1st, include a spinning penis rain (but not on local copies of the website or on the admin's CV)
if(date('d-m') == '01-04' && $_SERVER["SERVER_NAME"] != "localhost" && $_SERVER["SERVER_NAME"] != "127.0.0.1"  && $_SERVER["SERVER_NAME"] != "::1" && $_SERVER["SERVER_NAME"] != "[::1]" && substr($_SERVER["PHP_SELF"],-6) != 'cv.php' && substr($_SERVER["PHP_SELF"],-2) != 'cv')
  $javascripts .= '
    <script src="'.$path.'js/festif.js"> </script>';

// Add a line break at the end to preserve indentation
$javascripts .= '
';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                           DISPLAY THE HEADER AND MENUS                                            */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<!DOCTYPE html>
<html lang="<?=string_change_case($lang,'lowercase')?>">
  <head>
    <title><?=$page_title?></title>
    <link rel="shortcut icon" href="<?=$path?>img/divers/favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?=$page_description?>">
    <meta property="og:title" content="<?=$page_title?>">
    <meta property="og:description" content="<?=$page_description?>">
    <meta property="og:url" content="<?='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>">
    <meta property="og:site_name" content="NoBleme.com">
    <meta property="og:image" content="<?=$GLOBALS['website_url']?>img/divers/404_gauche.png">
    <meta name="twitter:image:alt" content="NoBleme, la communauté qui n'apporte rien mais a réponse à tout">
    <meta name="twitter:card" content="summary_large_image">
    <?=$stylesheets?>
    <?=$javascripts?>
  </head>

  <?php if(isset($cette_page_est_404)) { ?>
<body id="body" onload="ecrire_404();">
  <?php } else if(isset($onload)) { ?>
<body id="body" onload="<?=$onload?>">
  <?php } else { ?>
<body id="body">
  <?php } ?>




    <!-- ################################  HEADER  ################################ -->

<?php ####################################################### MENU PRINCIPAL #############################################################
// Préparation des traductions des titres
$menu['discuter'] = ($lang == 'FR') ? 'DISCUTER'  : 'TALK';
$menu['jouer']    = ($lang == 'FR') ? 'JOUER'     : 'PLAY';
$menu['lire']     = ($lang == 'FR') ? 'LIRE'      : 'READ';
/* ######################################################################### */ if(!isset($_GET["popup"]) && !isset($_GET["popout"])) { ?>

    <div class="header_topmenu<?=$website_update_css?>">
      <div id="header_titres" class="header_topmenu_zone">

        <a class="header_topmenu_lien" href="<?=$path?>index">
          <div class="<?=header_menu_css('NoBleme',$header_menu,'top')?>">NOBLEME</div>
        </a>

        <a class="header_topmenu_lien" href="<?=$path?>pages/irc/index">
          <div class="<?=header_menu_css('Discuter',$header_menu,'top')?>"><?=$menu['discuter']?></div>
        </a>

        <a class="header_topmenu_lien" href="<?=$path?>pages/nbdb/index">
          <div class="<?=header_menu_css('Lire',$header_menu,'top')?>"><?=$menu['lire']?></div>
        </a>

        <a class="header_topmenu_lien" href="<?=$path?>pages/nbrpg/index">
          <div class="<?=header_menu_css('Jouer',$header_menu,'top')?>"><?=$menu['jouer']?></div>
        </a>

        <?php if($is_global_moderator) { ?>
        <a class="header_topmenu_lien" href="<?=$path?>pages/nobleme/activite?mod">
          <div class="<?=header_menu_css('Admin',$header_menu,'top')?>">ADMIN</div>
        </a>

        <?php } if($is_admin) { ?>
        <a class="header_topmenu_lien" href="<?=$path?>pages/dev/ircbot">
          <div class="<?=header_menu_css('Dev',$header_menu,'top')?>">DEV</div>
        </a>
        <?php } ?>
      </div>
      <div class="header_topmenu_zone header_topmenu_flag">
        <a href="<?=$url_lang?>">
          <?php if($lang == 'FR') { ?>
          <img class="header_topmenu_flagimg" src="<?=$path?>img/icones/lang_en.png" alt="EN">
          <?php } else { ?>
          <img class="header_topmenu_flagimg" src="<?=$path?>img/icones/lang_fr.png" alt="FR">
          <?php } ?>
        </a>
      </div>
    </div>




<?php ###################################################### GESTION DU LOGIN ############################################################
// Préparation des traductions des phrases liées au compte
$getpseudo              = sanitize_output(user_get_nickname());
$submenu['message']     = ($lang == 'FR') ? "$getpseudo, vous avez reçu $nb_private_messages nouveaux messages, cliquez ici pour les lire !" : "$getpseudo, you have recieved $nb_private_messages new messages, click here to read them!";
$submenu['connecté']    = ($lang == 'FR') ? "Vous êtes connecté en tant que $getpseudo. Cliquez ici pour modifier votre profil et/ou gérer votre compte" : "You are logged in as $getpseudo. Click here to edit your profile and/or manage your account.";
$submenu['deconnexion'] = ($lang == 'FR') ? "Déconnexion" : "Log out";
$submenu['connexion']   = ($lang == 'FR') ? "Vous n'êtes pas connecté: Cliquez ici pour vous identifier ou vous enregistrer" : "You are not logged in: Click here to login or register.";
####################################################################################################################################### ?>

    <div class="menu_sub<?=$website_update_css2?>">
      <?php if(user_is_logged_in()) {
            if($nb_private_messages) { ?>
      <div class="header_topmenu_zone">
        <a id="nouveaux_messages" class="menu_sub_lien nouveaux_messages" href="<?=$path?>pages/user/notifications">
          <?=$submenu['message']?>
        </a>
      </div>
      <?php } else { ?>
      <div class="header_topmenu_zone">
        <a id="nouveaux_messages"  class="menu_sub_lien" href="<?=$path?>pages/user/notifications">
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
        <a class="menu_sub_lien" href="<?=$path?>pages/user/login">
          <?=$submenu['connexion']?>
        </a>
      </div>
      <?php } ?>
    </div>




<?php ######################################################## MENU LATÉRAL ##############################################################
// Préparation des traductions
$sidemenu['afficher'] = ($lang == 'FR') ? 'Afficher le menu latéral'  : 'Show the side menu';
$sidemenu['masquer']  = ($lang == 'FR') ? 'Masquer le menu latéral'   : 'Hide the side menu';
####################################################################################################################################### ?>

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
      <nav id="header_sidemenu" class="header_sidemenu_mobile<?=$website_update_css2?>">
        <div class="header_sidemenu">
          <div>
            <div class="header_sidemenu_item header_sidemenu_desktop" onclick="document.getElementById('header_nomenu').style.display = 'flex'; document.getElementById('header_sidemenu').style.display = 'none';">
              <?=$sidemenu['masquer']?>
            </div>
            <hr class="header_sidemenu_hr header_sidemenu_desktop">




<?php ################################################### MENU LATÉRAL : NOBLEME #########################################################
// Préparation des traductions des titres du menu
$sidemenu['nb_accueil']     = ($lang == 'FR') ? "Page d'accueil"                : "Home page";
$sidemenu['nb_activite']    = ($lang == 'FR') ? "Activité récente"              : "Recent activity";
$sidemenu['nb_communaute']  = ($lang == 'FR') ? "Communauté"                    : "Community";
$sidemenu['nb_enligne']     = ($lang == 'FR') ? "Qui est en ligne"              : "Who's online";
$sidemenu['nb_admins']      = ($lang == 'FR') ? "Équipe administrative"         : "Staff and admins";
$sidemenu['nb_membres']     = ($lang == 'FR') ? "Liste des membres"             : "Registered user list";
$sidemenu['nb_annivs']      = ($lang == 'FR') ? "Anniversaires"                 : "Member birthdays";
$sidemenu['nb_irls']        = ($lang == 'FR') ? "Rencontres IRL"                : "Real life meetups";
$sidemenu['nb_irlstats']    = ($lang == 'FR') ? "Statistiques des IRL"          : "RL meetup stats";
$sidemenu['nb_aide']        = ($lang == 'FR') ? "Aide & Informations"           : "Help / Documentation";
$sidemenu['nb_doc']         = ($lang == 'FR') ? "Documentation du site"         : "Website documentation";
$sidemenu['nb_nobleme']     = ($lang == 'FR') ? "Qu'est-ce que NoBleme"         : "What is NoBleme";
$sidemenu['nb_coc']         = ($lang == 'FR') ? "Code de conduite"              : "Code of conduct";
$sidemenu['nb_api']         = ($lang == 'FR') ? "API publique"                  : "Public API";
$sidemenu['nb_rss']         = ($lang == 'FR') ? "Flux RSS"                      : "RSS feeds";
$sidemenu['nb_dev']         = ($lang == 'FR') ? "Développement"                 : "Development";
$sidemenu['nb_coulisses']   = ($lang == 'FR') ? "Coulisses de NoBleme"          : "Behind the scenes";
$sidemenu['nb_todo']        = ($lang == 'FR') ? "Liste des tâches"              : "To-do list";
$sidemenu['nb_roadmap']     = ($lang == 'FR') ? "Plan de route"                 : "Roadmap";
$sidemenu['nb_bug']         = ($lang == 'FR') ? "Rapporter un bug"              : "Report a bug";
$sidemenu['nb_feature']     = ($lang == 'FR') ? "Quémander un feature"          : "Request a feature";
$sidemenu['nb_legal']       = ($lang == 'FR') ? "Mentions légales"              : "Legal notice";
$sidemenu['nb_confidence']  = ($lang == 'FR') ? "Politique de confidentialité"  : "Privacy policy";
$sidemenu['nb_persodata']   = ($lang == 'FR') ? "Vos données personnelles"      : "Your personal data";
$sidemenu['nb_oubli']       = ($lang == 'FR') ? "Droit à l'oubli"               : "Right to be forgotten";
/* ################################################################################################# */ if($header_menu == 'NoBleme') { ?>

            <div class="header_sidemenu_titre">
              NoBleme.com
            </div>

            <a href="<?=$path?>index">
              <div class="<?=header_menu_css('Accueil',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_accueil']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nobleme/activite">
              <div class="<?=header_menu_css('ActiviteRecente',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_activite']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['nb_communaute']?>
            </div>

            <a href="<?=$path?>pages/nobleme/online?noguest">
              <div class="<?=header_menu_css('QuiEstEnLigne',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_enligne']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nobleme/admins">
              <div class="<?=header_menu_css('EquipeAdmin',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_admins']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nobleme/membres">
              <div class="<?=header_menu_css('ListeDesMembres',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_membres']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nobleme/anniversaires">
              <div class="<?=header_menu_css('Anniversaires',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_annivs']?>
              </div>
            </a>

            <a href="<?=$path?>pages/irl/index">
              <div class="<?=header_menu_css('IRL',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_irls']?>
              </div>
            </a>

            <a href="<?=$path?>pages/irl/stats">
              <div class="<?=header_menu_css('IRLstats',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_irlstats']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['nb_aide']?>
            </div>

            <a href="<?=$path?>pages/doc/index">
              <div class="<?=header_menu_css('Doc',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_doc']?>
              </div>
            </a>

            <a href="<?=$path?>pages/doc/nobleme">
              <div class="<?=header_menu_css('QuEstCeQueNoBleme',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_nobleme']?>
              </div>
            </a>

            <a href="<?=$path?>pages/doc/coc">
              <div class="<?=header_menu_css('CoC',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_coc']?>
              </div>
            </a>

            <a href="<?=$path?>pages/doc/api">
              <div class="<?=header_menu_css('API',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_api']?>
              </div>
            </a>

            <a href="<?=$path?>pages/doc/rss">
              <div class="<?=header_menu_css('RSS',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_rss']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['nb_dev']?>
            </div>

            <a href="<?=$path?>pages/nobleme/coulisses">
              <div class="<?=header_menu_css('Coulisses',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_coulisses']?>
              </div>
            </a>

            <?php if($lang == 'FR') { ?>

            <a href="<?=$path?>pages/devblog/index">
              <div class="<?=header_menu_css('Devblog',$header_sidemenu,'side')?>">
                Blog de développement
              </div>
            </a>

            <?php } ?>

            <a href="<?=$path?>pages/todo/index">
              <div class="<?=header_menu_css('TodoList',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_todo']?>
              </div>
            </a>

            <a href="<?=$path?>pages/todo/roadmap">
              <div class="<?=header_menu_css('Roadmap',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_roadmap']?>
              </div>
            </a>

            <a href="<?=$path?>pages/todo/request">
              <div class="<?=header_menu_css('OuvrirTicket',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_feature']?>
              </div>
            </a>

            <a href="<?=$path?>pages/todo/request?bug">
              <div class="<?=header_menu_css('OuvrirTicketBug',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_bug']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['nb_legal']?>
            </div>

            <a href="<?=$path?>pages/doc/mentions_legales">
              <div class="<?=header_menu_css('MentionsLegales',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_confidence']?>
              </div>
            </a>

            <a href="<?=$path?>pages/doc/donnees_personnelles">
              <div class="<?=header_menu_css('DonneesPersonnelles',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_persodata']?>
              </div>
            </a>

            <a href="<?=$path?>pages/doc/droit_oubli">
              <div class="<?=header_menu_css('DroitOubli',$header_sidemenu,'side')?>">
                <?=$sidemenu['nb_oubli']?>
              </div>
            </a>




<?php } ################################################ MENU LATÉRAL : DISCUTER #########################################################
// Préparation des traductions des titres du menu
$sidemenu['bla_forum']            = ($lang == 'FR') ? "Forum de discussion"       : "Discussion forum";
$sidemenu['bla_forum_sujets']     = ($lang == 'FR') ? "Sujets de discussion"      : "Latest forum topics";
$sidemenu['bla_forum_ouvrir']     = ($lang == 'FR') ? "Ouvrir un nouveau sujet"   : "Open a new topic";
$sidemenu['bla_forum_recherche']  = ($lang == 'FR') ? "Recherche sur le forum"    : "Search the forum";
$sidemenu['bla_forum_filtrage']   = ($lang == 'FR') ? "Préférences de filtrage"   : "Filtering preferences";
$sidemenu['bla_irc']              = ($lang == 'FR') ? "Serveur de chat IRC"       : "IRC chat server";
$sidemenu['bla_irc_what']         = ($lang == 'FR') ? "Qu'est-ce que IRC"         : "What is IRC";
$sidemenu['bla_irc_clic']         = ($lang == 'FR') ? "Rejoindre la conversation" : "Join the conversation";
$sidemenu['bla_irc_canaux']       = ($lang == 'FR') ? "Liste des canaux"          : "Channel list";
$sidemenu['bla_irc_services']     = ($lang == 'FR') ? "Commandes et services"     : "Commands and services";
/* ################################################################################################ */ if($header_menu == 'Discuter') { ?>

            <div class="header_sidemenu_titre">
              <?=$sidemenu['bla_irc']?>
            </div>

            <a href="<?=$path?>pages/irc/index">
              <div class="<?=header_menu_css('IRC',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_what']?>
              </div>
            </a>

            <a href="<?=$path?>pages/irc/client">
              <div class="<?=header_menu_css('IRCClient',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_clic']?>
              </div>
            </a>

            <a href="<?=$path?>pages/irc/services">
              <div class="<?=header_menu_css('IRCServices',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_services']?>
              </div>
            </a>

            <a href="<?=$path?>pages/irc/canaux">
              <div class="<?=header_menu_css('IRCCanaux',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_irc_canaux']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['bla_forum']?>
            </div>

            <a href="<?=$path?>pages/forum/index">
              <div class="<?=header_menu_css('ForumIndex',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_forum_sujets']?>
              </div>
            </a>

            <a href="<?=$path?>pages/forum/new">
              <div class="<?=header_menu_css('ForumNew',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_forum_ouvrir']?>
              </div>
            </a>

            <a href="<?=$path?>pages/forum/recherche">
              <div class="<?=header_menu_css('ForumRecherche',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_forum_recherche']?>
              </div>
            </a>

            <a href="<?=$path?>pages/forum/filtres">
              <div class="<?=header_menu_css('ForumFiltrage',$header_sidemenu,'side')?>">
                <?=$sidemenu['bla_forum_filtrage']?>
              </div>
            </a>




<?php } ################################################## MENU LATÉRAL : LIRE ###########################################################
// Préparation des traductions des titres du menu
$sidemenu['lire_nbdb_titre']        = ($lang == 'FR') ? "NBDB"                      : "NoBleme Database";
$sidemenu['lire_nbdb_index']        = ($lang == 'FR') ? "Base d'informations"       : "The NoBleme Database";
$sidemenu['lire_nbdb_web_encyclo']  = ($lang == 'FR') ? "Encyclopédie du web"       : "Internet encyclopedia";
$sidemenu['lire_nbdb_web_e_liste']  = ($lang == 'FR') ? "Liste des pages"           : "List of all pages";
$sidemenu['lire_nbdb_web_e_rand']   = ($lang == 'FR') ? "Page au hasard"            : "Random page";
$sidemenu['lire_nbdb_web_dico']     = ($lang == 'FR') ? "Dictionnaire du web"       : "Internet dictionnary";
$sidemenu['lire_quotes_titre']      = ($lang == 'FR') ? "Miscellanées"              : "Miscellanea";
$sidemenu['lire_quotes_liste']      = ($lang == 'FR') ? "Paroles de NoBlemeux"      : "Quote database";
$sidemenu['lire_quotes_random']     = ($lang == 'FR') ? "Miscellanée au hasard"     : "Random quote";
$sidemenu['lire_quotes_stats']      = ($lang == 'FR') ? "Stats des miscellanées"    : "Miscellanea stats";
$sidemenu['lire_quotes_proposer']   = ($lang == 'FR') ? "Proposer une miscellanée"  : "Submit a new quote";
/* #################################################################################################### */ if($header_menu == 'Lire') { ?>

            <div class="header_sidemenu_titre">
              <?=$sidemenu['lire_nbdb_titre']?>
            </div>

            <a href="<?=$path?>pages/nbdb/index">
              <div class="<?=header_menu_css('NBDBIndex',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_nbdb_index']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nbdb/web">
              <div class="<?=header_menu_css('NBDBEncycloWeb',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_nbdb_web_encyclo']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nbdb/web_pages">
              <div class="<?=header_menu_css('NBDBEncycloListe',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_nbdb_web_e_liste']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nbdb/web?random">
              <div class="<?=header_menu_css('NBDBEncycloRand',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_nbdb_web_e_rand']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nbdb/web_dictionnaire">
              <div class="<?=header_menu_css('NBDBDicoWeb',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_nbdb_web_dico']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['lire_quotes_titre']?>
            </div>

            <a href="<?=$path?>pages/quotes/index">
              <div class="<?=header_menu_css('MiscIndex',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_quotes_liste']?>
              </div>
            </a>

            <a href="<?=$path?>pages/quotes/quote?random">
              <div class="<?=header_menu_css('MiscRandom',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_quotes_random']?>
              </div>
            </a>

            <a href="<?=$path?>pages/quotes/stats">
              <div class="<?=header_menu_css('MiscStats',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_quotes_stats']?>
              </div>
            </a>

            <a href="<?=$path?>pages/quotes/add">
              <div class="<?=header_menu_css('MiscAdd',$header_sidemenu,'side')?>">
                <?=$sidemenu['lire_quotes_proposer']?>
              </div>
            </a>

            <?php if($lang == 'FR') { ?>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Coin des écrivains
            </div>

            <a href="<?=$path?>pages/ecrivains/index">
              <div class="<?=header_menu_css('EcrivainsListe',$header_sidemenu,'side')?>">
                Écrits de NoBlemeux
              </div>
            </a>

            <a href="<?=$path?>pages/ecrivains/concours_liste">
              <div class="<?=header_menu_css('EcrivainsConcours',$header_sidemenu,'side')?>">
                Concours d'écriture
              </div>
            </a>

            <a href="<?=$path?>pages/ecrivains/publier">
              <div class="<?=header_menu_css('EcrivainsPublier',$header_sidemenu,'side')?>">
                Publier un texte
              </div>
            </a>

            <?php } ?>




<?php } ################################################## MENU LATÉRAL : JOUER ##########################################################
// Préparation des traductions des titres du menu
$sidemenu['jeu_nbrpg_index']  = ($lang == 'FR') ? "Qu'est-ce que le NBRPG"  : "What is the NBRPG";
$sidemenu['jeu_nrm_rip']      = ($lang == 'FR') ? "En souvenir du NRM"      : "Remembering the NRM";
$sidemenu['jeu_nrm_podium']   = ($lang == 'FR') ? "Champions du passé"      : "Champions of the past";
$sidemenu['jeu_radikal']      = ($lang == 'FR') ? "Projet: Radikal"         : "Project: Radikal";
$sidemenu['jeu_radikal_hype'] = ($lang == 'FR') ? "Le prochain jeu NoBleme" : "The next NoBleme game";
/* ################################################################################################### */ if($header_menu == 'Jouer') { ?>

            <div class="header_sidemenu_titre">
              NoBlemeRPG
            </div>

            <a href="<?=$path?>pages/nbrpg/index">
              <div class="<?=header_menu_css('NBRPGWhat',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_nbrpg_index']?>
              </div>
            </a>

            <?php if($lang == 'FR') { ?>
            <a href="<?=$path?>pages/nbrpg/archives">
              <div class="<?=header_menu_css('NBRPGArchives',$header_sidemenu,'side')?>">
                Sessions archivées
              </div>
            </a>
            <?php } ?>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              NRM Online
            </div>

            <a href="<?=$path?>pages/nrm/index">
              <div class="<?=header_menu_css('NRM',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_nrm_rip']?>
              </div>
            </a>

            <a href="<?=$path?>pages/nrm/podium">
              <div class="<?=header_menu_css('NRMPodium',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_nrm_podium']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['jeu_radikal']?>
            </div>

            <a href="<?=$path?>pages/radikal/hype">
              <div class="<?=header_menu_css('RadikalHype',$header_sidemenu,'side')?>">
                <?=$sidemenu['jeu_radikal_hype']?>
              </div>
            </a>




<?php } ################################################# MENU LATÉRAL : COMPTE ##########################################################
// Préparation des traductions des titres du menu
$sidemenu['user_notifs']          = ($lang == 'FR') ? "Messagerie privée"       : "Private messages";
$sidemenu['user_notifs_inbox']    = ($lang == 'FR') ? "Boîte de réception"      : "Account inbox";
$sidemenu['user_notifs_outbox']   = ($lang == 'FR') ? "Messages envoyés"        : "Sent messages";
$sidemenu['user_notifs_envoyer']  = ($lang == 'FR') ? "Composer un message"     : "Write a message";
$sidemenu['user_profil']          = ($lang == 'FR') ? "Profil public"           : "Public profile";
$sidemenu['user_profil_self']     = ($lang == 'FR') ? "Voir mon profil public"  : "My public profile";
$sidemenu['user_profil_edit']     = ($lang == 'FR') ? "Modifier mon profil"     : "Edit my profile";
$sidemenu['user_reglages']        = ($lang == 'FR') ? "Réglages du compte"      : "Account settings";
$sidemenu['user_reglages_prive']  = ($lang == 'FR') ? "Options de vie privée"   : "Privacy options";
$sidemenu['user_reglages_nsfw']   = ($lang == 'FR') ? "Options de vulgarité"    : "Adult content options";
$sidemenu['user_reglages_email']  = ($lang == 'FR') ? "Changer d'e-mail"        : "Change my e-mail";
$sidemenu['user_reglages_pass']   = ($lang == 'FR') ? "Changer de mot de passe" : "Change my password";
$sidemenu['user_reglages_pseudo'] = ($lang == 'FR') ? "Changer de pseudonyme"   : "Change my nickname";
$sidemenu['user_reglages_delete'] = ($lang == 'FR') ? "Supprimer mon compte"    : "Delete my account";
/* ################################################################################################## */ if($header_menu == 'Compte') { ?>

            <div class="header_sidemenu_titre">
              <?=$sidemenu['user_notifs']?>
            </div>

            <a href="<?=$path?>pages/user/notifications">
              <div class="<?=header_menu_css('Notifications',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_notifs_inbox']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/notifications?envoyes">
              <div class="<?=header_menu_css('MessagesEnvoyes',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_notifs_outbox']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/pm">
              <div class="<?=header_menu_css('ComposerMessage',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_notifs_envoyer']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['user_profil']?>
            </div>

            <a href="<?=$path?>pages/user/user">
              <div class="<?=header_menu_css('MonProfil',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_profil_self']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/profil">
              <div class="<?=header_menu_css('ModifierProfil',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_profil_edit']?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              <?=$sidemenu['user_reglages']?>
            </div>

            <a href="<?=$path?>pages/user/privacy">
              <div class="<?=header_menu_css('ReglagesViePrivee',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_prive']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/nsfw">
              <div class="<?=header_menu_css('ReglagesNSFW',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_nsfw']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/email">
              <div class="<?=header_menu_css('ChangerEmail',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_email']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/pass">
              <div class="<?=header_menu_css('ChangerPass',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_pass']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/pseudo">
              <div class="<?=header_menu_css('ChangerPseudo',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_pseudo']?>
              </div>
            </a>

            <a href="<?=$path?>pages/user/delete">
              <div class="<?=header_menu_css('SupprimerCompte',$header_sidemenu,'side')?>">
                <?=$sidemenu['user_reglages_delete']?>
              </div>
            </a>




<?php } /* ############################################## MENU LATÉRAL : ADMIN ####################### */ if($header_menu == 'Admin') { ?>

            <div class="header_sidemenu_titre">
              Activité récente
            </div>

            <a href="<?=$path?>pages/nobleme/activite?mod">
              <div class="<?=header_menu_css('Modlogs',$header_sidemenu,'side')?>">
                Logs de modération
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Gestion des membres
            </div>

            <a href="<?=$path?>pages/sysop/pilori">
              <div class="<?=header_menu_css('Pilori',$header_sidemenu,'side')?>">
                Pilori des bannis
              </div>
            </a>

            <a href="<?=$path?>pages/sysop/ban">
              <div class="<?=header_menu_css('Bannir',$header_sidemenu,'side')?>">
                Bannir un utilisateur
              </div>
            </a>

            <a href="<?=$path?>pages/sysop/profil">
              <div class="<?=header_menu_css('ModifierProfil',$header_sidemenu,'side')?>">
                Modifier un profil
              </div>
            </a>

            <a href="<?=$path?>pages/sysop/pass">
              <div class="<?=header_menu_css('ChangerPass',$header_sidemenu,'side')?>">
                Changer un mot de passe
              </div>
            </a>

            <?php if($is_admin) { ?>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Outils administratifs
            </div>

            <a href="<?=$path?>pages/admin/permissions">
              <div class="<?=header_menu_css('Permissions',$header_sidemenu,'side')?>">
                Changer les permissions
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Statistiques
            </div>

            <a href="<?=$path?>pages/admin/pageviews">
              <div class="<?=header_menu_css('Pageviews',$header_sidemenu,'side')?>">
                Popularité des pages
              </div>
            </a>

            <a href="<?=$path?>pages/admin/doppelganger">
              <div class="<?=header_menu_css('Doppelganger',$header_sidemenu,'side')?>">
                Doppelgänger
              </div>
            </a>

            <?php } ?>




<?php } /* ################################################ MENU LATÉRAL : DEV ######################### */ if($header_menu == 'Dev') { ?>

            <div class="header_sidemenu_titre">
              Bot IRC NoBleme
            </div>

            <a href="<?=$path?>pages/dev/ircbot">
              <div class="<?=header_menu_css('IRCbot',$header_sidemenu,'side')?>">
                Gestion du bot IRC
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Gestion du site
            </div>

            <a href="<?=$path?>pages/dev/maj">
              <div class="<?=header_menu_css('MajChecklist',$header_sidemenu,'side')?>">
                Mise à jour : Checklist
              </div>
            </a>

            <a href="<?=$path?>pages/dev/sql">
              <div class="<?=header_menu_css('MajRequetes',$header_sidemenu,'side')?>">
                Requêtes SQL
              </div>
            </a>

            <a href="<?=$path?>pages/dev/fermeture">
              <div class="<?=header_menu_css('MajFermeture',$header_sidemenu,'side')?>">
                Ouvrir/fermer le site
              </div>
            </a>

            <a href="<?=$path?>pages/dev/version">
              <div class="<?=header_menu_css('MajVersion',$header_sidemenu,'side')?>">
                Numéro de version
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_titre">
              Références de code
            </div>

            <a href="<?=$path?>pages/dev/snippets">
              <div class="<?=header_menu_css('Snippets',$header_sidemenu,'side')?>">
                Snippets de code
              </div>
            </a>

            <a href="<?=$path?>pages/dev/reference">
              <div class="<?=header_menu_css('Reference',$header_sidemenu,'side')?>">
                Référence HTML / CSS
              </div>
            </a>

            <a href="<?=$path?>pages/dev/fonctions">
              <div class="<?=header_menu_css('Fonctions',$header_sidemenu,'side')?>">
                Référence des fonctions
              </div>
            </a>


          <?php } ?>

          </div>
        </div>
      </nav>

  <?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //                                                                                                                                    //
  //                                                           FIN DES MENUS                                                            //
  //                                                                                                                                    //
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

    <!-- ################################  BODY  ################################ -->

    <div class="flex_element contenu_page">

      <?php } if($meta_alert != "") { ?>

      <br>
      <br>

      <div class="gros gras texte_erreur align_center monospace">
        <?=$meta_alert?>
      </div>

      <?php } if($lang_error) { ?>

      <div class="gros gras texte_erreur align_center monospace">
        <?=__('header_language_error');?>
      </div>

      <br>

      <hr class="separateur_contenu">

      <br>

      <?php } ?>