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
// Choix du menu à afficher

// Déjà on init les variables de menu si elles sont vides
if(!isset($header_menu))
  $header_menu = '';
if(!isset($header_submenu))
  $header_submenu = '';
if(!isset($header_sidemenu))
  $header_sidemenu = '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation du menu principal

$h_menu_css['nobleme']           = ($header_menu == '')                    ? ' menu_main_item_selected' : '';
$h_menu_css['communaute']        = ($header_menu == 'communaute')          ? ' menu_main_item_selected' : '';
$h_menu_css['lire']              = ($header_menu == 'lire')                ? ' menu_main_item_selected' : '';
$h_menu_css['discuter']          = ($header_menu == 'discuter')            ? ' menu_main_item_selected' : '';
$h_menu_css['admin']             = ($header_menu == 'admin')               ? ' menu_main_item_selected' : '';
$h_menu_css['secrets']           = ($header_menu == 'secrets')             ? ' menu_main_item_selected' : ' menu_main_item_secrets';
$h_menu_css['connexion']         = ($header_menu == 'connexion')           ? ' menu_main_item_selected' : '';
$h_menu_css['inscription']       = ($header_menu == 'inscription')         ? ' menu_main_item_selected' : '';
$h_menu_css['compte']            = ($header_menu == 'compte')              ? ' menu_main_item_selected' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation des menus secondaires

if($header_menu == '' || $header_menu == 'connexion' || $header_menu == 'inscription')
{
  $h_submenu_css['accueil']      = ($header_submenu == 'accueil')          ? ' menu_sub_item_selected' : '';
  $h_submenu_css['activite']     = ($header_submenu == 'activite')         ? ' menu_sub_item_selected' : '';
  $h_submenu_css['online']       = ($header_submenu == 'online')           ? ' menu_sub_item_selected' : '';
  $h_submenu_css['dev']          = ($header_submenu == 'dev')              ? ' menu_sub_item_selected' : '';
  $h_submenu_css['aide']         = ($header_submenu == 'aide')             ? ' menu_sub_item_selected' : '';
}
else if($header_menu == 'communaute')
{
  $h_submenu_css['membres']      = ($header_submenu == 'membres')          ? ' menu_sub_item_selected' : '';
  $h_submenu_css['irl']          = ($header_submenu == 'irl')              ? ' menu_sub_item_selected' : '';
  $h_submenu_css['admins']       = ($header_submenu == 'admins')           ? ' menu_sub_item_selected' : '';
}
else if($header_menu == 'lire')
{
  $h_submenu_css['nbdb']         = ($header_submenu == 'nbdb')             ? ' menu_sub_item_selected' : '';
  $h_submenu_css['nbrpg']        = ($header_submenu == 'nbrpg')            ? ' menu_sub_item_selected' : '';
  $h_submenu_css['miscellanees'] = ($header_submenu == 'miscellanees')     ? ' menu_sub_item_selected' : '';
}
else if($header_menu == 'discuter')
{
  $h_submenu_css['forum']        = ($header_submenu == 'forum')            ? ' menu_sub_item_selected' : '';
  $h_submenu_css['ecrivains']    = ($header_submenu == 'ecrivains')        ? ' menu_sub_item_selected' : '';
  $h_submenu_css['irc']          = ($header_submenu == 'irc')              ? ' menu_sub_item_selected' : '';
}
else if($header_menu == 'admin')
{
  $h_submenu_css['mod']          = ($header_submenu == 'mod')              ? ' menu_sub_item_selected' : '';
  $h_submenu_css['admin']        = ($header_submenu == 'admin')            ? ' menu_sub_item_selected' : '';
  $h_submenu_css['dev']          = ($header_submenu == 'dev')              ? ' menu_sub_item_selected' : '';
  $h_submenu_css['nbrpg']        = ($header_submenu == 'nbrpg')            ? ' menu_sub_item_selected' : '';
}
else if($header_menu == 'secrets')
{
  $h_submenu_css['liste']        = ($header_submenu == 'liste')            ? ' menu_sub_item_selected' : '';
}
else if($header_menu == 'compte')
{
  $h_submenu_css['messages']     = ($header_submenu == 'messages')         ? ' menu_sub_item_selected' : '';
  $h_submenu_css['profil']       = ($header_submenu == 'profil')           ? ' menu_sub_item_selected' : '';
  $h_submenu_css['reglages']     = ($header_submenu == 'reglages')         ? ' menu_sub_item_selected' : '';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation des menus latéraux

if($header_menu == '' && $header_submenu == 'dev')
{
  $h_side_css['coulisses']       = ($header_sidemenu == 'coulisses')       ? ' menu_side_item_selected' : '';
  $h_side_css['source']          = ($header_sidemenu == 'source')          ? ' menu_side_item_selected' : '';
  $h_side_css['todo']            = ($header_sidemenu == 'todo')            ? ' menu_side_item_selected' : '';
  $h_side_css['todo_recent']     = ($header_sidemenu == 'todo_recent')     ? ' menu_side_item_selected' : '';
  $h_side_css['todo_solved']     = ($header_sidemenu == 'todo_solved')     ? ' menu_side_item_selected' : '';
  $h_side_css['roadmap']         = ($header_sidemenu == 'roadmap')         ? ' menu_side_item_selected' : '';
  $h_side_css['ticket']          = ($header_sidemenu == 'ticket')          ? ' menu_side_item_selected' : '';
  $h_side_css['todo_rss']        = ($header_sidemenu == 'todo_rss')        ? ' menu_side_item_selected' : '';
  $h_side_css['devblog']         = ($header_sidemenu == 'devblog')         ? ' menu_side_item_selected' : '';
  $h_side_css['devblog_top']     = ($header_sidemenu == 'devblog_top')     ? ' menu_side_item_selected' : '';
  $h_side_css['devblog_rss']     = ($header_sidemenu == 'devblog_rss')     ? ' menu_side_item_selected' : '';
  $h_side_css['ticket_bug']      = ($header_sidemenu == 'ticket_bug')      ? ' menu_side_item_selected' : '';
  $h_side_css['ticket_feature']  = ($header_sidemenu == 'ticket_feature')  ? ' menu_side_item_selected' : '';
}
else if($header_menu == '' && $header_submenu == 'aide')
{
  $h_side_css['documentation']   = ($header_sidemenu == 'documentation')   ? ' menu_side_item_selected' : '';
  $h_side_css['nobleme']         = ($header_sidemenu == 'nobleme')         ? ' menu_side_item_selected' : '';
  $h_side_css['coc']             = ($header_sidemenu == 'coc')             ? ' menu_side_item_selected' : '';
  $h_side_css['bbcodes']         = ($header_sidemenu == 'bbcodes')         ? ' menu_side_item_selected' : '';
  $h_side_css['emotes']          = ($header_sidemenu == 'emotes')          ? ' menu_side_item_selected' : '';
  $h_side_css['rss']             = ($header_sidemenu == 'rss')             ? ' menu_side_item_selected' : '';
  $h_side_css['bug']             = ($header_sidemenu == 'bug')             ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'communaute' && $header_submenu == 'membres')
{
  $h_side_css['portail']         = ($header_sidemenu == 'portail')         ? ' menu_side_item_selected' : '';
  $h_side_css['liste']           = ($header_sidemenu == 'liste')           ? ' menu_side_item_selected' : '';
  $h_side_css['anniversaires']   = ($header_sidemenu == 'anniversaires')   ? ' menu_side_item_selected' : '';
  $h_side_css['pilori']          = ($header_sidemenu == 'pilori')          ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'lire' && $header_submenu == 'miscellanees')
{
  $h_side_css['paroles']         = ($header_sidemenu == 'paroles')         ? ' menu_side_item_selected' : '';
  $h_side_css['hasard']          = ($header_sidemenu == 'hasard')          ? ' menu_side_item_selected' : '';
  $h_side_css['stats']           = ($header_sidemenu == 'stats')           ? ' menu_side_item_selected' : '';
  $h_side_css['proposer']        = ($header_sidemenu == 'proposer')        ? ' menu_side_item_selected' : '';
  $h_side_css['rss']             = ($header_sidemenu == 'rss')             ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'lire' && $header_submenu == 'nbrpg')
{
  $h_side_css['index']           = ($header_sidemenu == 'index')           ? ' menu_side_item_selected' : '';
  $h_side_css['liste_persos']    = ($header_sidemenu == 'liste_persos')    ? ' menu_side_item_selected' : '';
  $h_side_css['archive']         = ($header_sidemenu == 'archive')         ? ' menu_side_item_selected' : '';
  $h_side_css['caverne']         = ($header_sidemenu == 'caverne')         ? ' menu_side_item_selected' : '';
  $h_side_css['historique']      = ($header_sidemenu == 'historique')      ? ' menu_side_item_selected' : '';
  $h_side_css['caverne_random']  = ($header_sidemenu == 'caverne_random')  ? ' menu_side_item_selected' : '';
  $h_side_css['client']          = ($header_sidemenu == 'client')          ? ' menu_side_item_selected' : '';
  $h_side_css['observer']        = ($header_sidemenu == 'observer')        ? ' menu_side_item_selected' : '';
  $h_side_css['fiche_perso']     = ($header_sidemenu == 'fiche_perso')     ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'discuter' && $header_submenu == 'irc')
{
  $h_side_css['index']           = ($header_sidemenu == 'index')           ? ' menu_side_item_selected' : '';
  $h_side_css['clic']            = ($header_sidemenu == 'clic')            ? ' menu_side_item_selected' : '';
  $h_side_css['traditions']      = ($header_sidemenu == 'traditions')      ? ' menu_side_item_selected' : '';
  $h_side_css['canaux']          = ($header_sidemenu == 'canaux')          ? ' menu_side_item_selected' : '';
  $h_side_css['services']        = ($header_sidemenu == 'services')        ? ' menu_side_item_selected' : '';
  $h_side_css['akundo']          = ($header_sidemenu == 'akundo')          ? ' menu_side_item_selected' : '';
  $h_side_css['client']          = ($header_sidemenu == 'client')          ? ' menu_side_item_selected' : '';
  $h_side_css['bouncer']         = ($header_sidemenu == 'bouncer')         ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'admin' && $header_submenu == 'mod')
{
  $h_side_css['modlogs']         = ($header_sidemenu == 'modlogs')         ? ' menu_side_item_selected' : '';
  $h_side_css['bannir']          = ($header_sidemenu == 'bannir')          ? ' menu_side_item_selected' : '';
  $h_side_css['profil']          = ($header_sidemenu == 'profil')          ? ' menu_side_item_selected' : '';
  $h_side_css['pass']            = ($header_sidemenu == 'pass')            ? ' menu_side_item_selected' : '';
  $h_side_css['irl_add']         = ($header_sidemenu == 'irl_add')         ? ' menu_side_item_selected' : '';
  $h_side_css['irl_edit']        = ($header_sidemenu == 'irl_edit')        ? ' menu_side_item_selected' : '';
  $h_side_css['irl_delete']      = ($header_sidemenu == 'irl_delete')      ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'admin' && $header_submenu == 'admin')
{
  $h_side_css['stats_dop']       = ($header_sidemenu == 'stats_dop')       ? ' menu_side_item_selected' : '';
  $h_side_css['stats_views']     = ($header_sidemenu == 'stats_views')     ? ' menu_side_item_selected' : '';
  $h_side_css['stats_views_evo'] = ($header_sidemenu == 'stats_views_evo') ? ' menu_side_item_selected' : '';
  $h_side_css['stats_refs']      = ($header_sidemenu == 'stats_refs')      ? ' menu_side_item_selected' : '';
  $h_side_css['stats_refs_evo']  = ($header_sidemenu == 'stats_refs_evo')  ? ' menu_side_item_selected' : '';
  $h_side_css['devblog_add']     = ($header_sidemenu == 'devblog_add')     ? ' menu_side_item_selected' : '';
  $h_side_css['todo_add']        = ($header_sidemenu == 'todo_add')        ? ' menu_side_item_selected' : '';
  $h_side_css['todo_valider']    = ($header_sidemenu == 'todo_valider')    ? ' menu_side_item_selected' : '';
  $h_side_css['quote_add']       = ($header_sidemenu == 'quote_add')       ? ' menu_side_item_selected' : '';
  $h_side_css['quote_valider']   = ($header_sidemenu == 'quote_valider')   ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'admin' && $header_submenu == 'dev')
{
  $h_side_css['maj']             = ($header_sidemenu == 'maj')             ? ' menu_side_item_selected' : '';
  $h_side_css['sql']             = ($header_sidemenu == 'sql')             ? ' menu_side_item_selected' : '';
  $h_side_css['ircbot']          = ($header_sidemenu == 'ircbot')          ? ' menu_side_item_selected' : '';
  $h_side_css['formattage']      = ($header_sidemenu == 'formattage')      ? ' menu_side_item_selected' : '';
  $h_side_css['css']             = ($header_sidemenu == 'css')             ? ' menu_side_item_selected' : '';
  $h_side_css['fonctions']       = ($header_sidemenu == 'fonctions')       ? ' menu_side_item_selected' : '';
  $h_side_css['charte']          = ($header_sidemenu == 'charte')          ? ' menu_side_item_selected' : '';
  $h_side_css['nompages']        = ($header_sidemenu == 'nompages')        ? ' menu_side_item_selected' : '';
  $h_side_css['flashanniv']      = ($header_sidemenu == 'flashanniv')      ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'compte' && $header_submenu == 'messages')
{
  $h_side_css['inbox']           = ($header_sidemenu == 'inbox')           ? ' menu_side_item_selected' : '';
  $h_side_css['envoyes']         = ($header_sidemenu == 'envoyes')         ? ' menu_side_item_selected' : '';
  $h_side_css['ecrire']          = ($header_sidemenu == 'ecrire')          ? ' menu_side_item_selected' : '';
}
else if($header_menu == 'compte' && $header_submenu == 'reglages')
{
  $h_side_css['reglages']        = ($header_sidemenu == 'reglages')        ? ' menu_side_item_selected' : '';
  $h_side_css['email']           = ($header_sidemenu == 'email')           ? ' menu_side_item_selected' : '';
  $h_side_css['pass']            = ($header_sidemenu == 'pass')            ? ' menu_side_item_selected' : '';
}




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
        <div onClick="location.href = '<?=$chemin?>'" class="menu_main_item<?=$h_menu_css['nobleme']?>">
          <a                     href="<?=$chemin?>">NOBLEME.COM</a>
        </div>
        <div onClick="location.href = '<?=$chemin?>pages/nobleme/index'" class="menu_main_item<?=$h_menu_css['communaute']?>">
          <a                     href="<?=$chemin?>pages/nobleme/index">COMMUNAUTÉ</a>
        </div>
        <div onClick="location.href = '<?=$chemin?>pages/nbdb/index'" class="menu_main_item<?=$h_menu_css['lire']?>">
          <a                     href="<?=$chemin?>pages/nbdb/index">LIRE</a>
        </div>
        <div onClick="location.href = '<?=$chemin?>pages/forum/index'" class="menu_main_item<?=$h_menu_css['discuter']?>">
          <a                     href="<?=$chemin?>pages/forum/index">DISCUTER</a>
        </div>
        <div onClick="location.href = '<?=$chemin?>pages/secrets/index'" class="menu_main_item<?=$h_menu_css['secrets']?>">
          <a                     href="<?=$chemin?>pages/secrets/index">SECRETS</a>
        </div>
      </div>
      <div class="menu_main_section">
        <?php if(!loggedin()) { ?>
        <div onClick="location.href = '<?=$chemin?>pages/user/login'" class="menu_main_item<?=$h_menu_css['connexion']?>">
          <a                     href="<?=$chemin?>pages/user/login">CONNEXION</a>
        </div>
        <div onClick="location.href = '<?=$chemin?>pages/user/register'" class="menu_main_item<?=$h_menu_css['inscription']?>">
          <a                     href="<?=$chemin?>pages/user/register">S'INSCRIRE</a>
        </div>
        <?php } else { ?>
        <?php if(loggedin() && getsysop($_SESSION['user'])) { ?>
        <div onClick="location.href = '<?=$chemin?>pages/nobleme/activite?mod'" class="menu_main_item<?=$h_menu_css['admin']?>">
          <a                     href="<?=$chemin?>pages/nobleme/activite?mod">ADMINISTRATION</a>
        </div>
        <?php } ?>
        <div onClick="location.href = '<?=$chemin?>pages/user/notifications'" class="menu_main_item<?=$h_menu_css['compte']?>">
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
      <div onClick="location.href = '<?=$chemin?>'" class="menu_sub_item<?=$h_submenu_css['accueil']?>">
        <a                     href="<?=$chemin?>">Page d'accueil</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/nobleme/activite'" class="menu_sub_item<?=$h_submenu_css['activite']?>">
        <a                     href="<?=$chemin?>pages/nobleme/activite">Activité récente</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/nobleme/online'" class="menu_sub_item<?=$h_submenu_css['online']?>">
        <a                     href="<?=$chemin?>pages/nobleme/online">Qui est en ligne ?</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/nobleme/coulisses'" class="menu_sub_item<?=$h_submenu_css['dev']?>">
        <a                     href="<?=$chemin?>pages/nobleme/coulisses">Développement</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/doc/index'" class="menu_sub_item<?=$h_submenu_css['aide']?>">
        <a                     href="<?=$chemin?>pages/doc/index">Aide &amp; Infos</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'communaute') { ?>
    <div class="menu_sub">
      <div onClick="location.href = '<?=$chemin?>pages/nobleme/index'" class="menu_sub_item<?=$h_submenu_css['membres']?>">
        <a                     href="<?=$chemin?>pages/nobleme/index">Membres</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/nobleme/irls'" class="menu_sub_item<?=$h_submenu_css['irl']?>">
        <a                     href="<?=$chemin?>pages/nobleme/irls">Rencontres IRL</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/nobleme/admins'" class="menu_sub_item<?=$h_submenu_css['admins']?>">
        <a                     href="<?=$chemin?>pages/nobleme/admins">Équipe administrative</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'lire') { ?>
    <div class="menu_sub">
      <div onClick="location.href = '<?=$chemin?>pages/nbdb/index'" class="menu_sub_item<?=$h_submenu_css['nbdb']?>">
        <a                     href="<?=$chemin?>pages/nbdb/index">NBDatabase</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/nbrpg/index'" class="menu_sub_item<?=$h_submenu_css['nbrpg']?>">
        <a                     href="<?=$chemin?>pages/nbrpg/index">NoBlemeRPG</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/irc/quotes'" class="menu_sub_item<?=$h_submenu_css['miscellanees']?>">
        <a                     href="<?=$chemin?>pages/irc/quotes">Miscellanees</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'discuter') { ?>
    <div class="menu_sub">
      <div onClick="location.href = '<?=$chemin?>pages/forum/index'" class="menu_sub_item<?=$h_submenu_css['forum']?>">
        <a                     href="<?=$chemin?>pages/forum/index">Forum NoBleme</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/forum/ecrivains'" class="menu_sub_item<?=$h_submenu_css['ecrivains']?>">
        <a                     href="<?=$chemin?>pages/forum/ecrivains">Le coin des écrivains</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/irc/index'" class="menu_sub_item<?=$h_submenu_css['irc']?>">
        <a                     href="<?=$chemin?>pages/irc/index">Chat IRC</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'admin') { ?>
    <div class="menu_sub">
      <div onClick="location.href = '<?=$chemin?>pages/nobleme/activite?mod'" class="menu_sub_item<?=$h_submenu_css['mod']?>">
        <a                     href="<?=$chemin?>pages/nobleme/activite?mod">Modération</a>
      </div>
      <?php if(getadmin()) { ?>
      <div onClick="location.href = '<?=$chemin?>pages/todo/index?admin'" class="menu_sub_item<?=$h_submenu_css['admin']?>">
        <a                     href="<?=$chemin?>pages/todo/index?admin">Administration</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/dev/formattage'" class="menu_sub_item<?=$h_submenu_css['dev']?>">
        <a                     href="<?=$chemin?>pages/dev/formattage">Développement</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/nbrpg/admin'" class="menu_sub_item<?=$h_submenu_css['nbrpg']?>">
        <a                     href="<?=$chemin?>pages/nbrpg/admin">NBRPG</a>
      </div>
      <?php } ?>
    </div>

    <?php } else if ($header_menu == 'secrets') { ?>
    <div class="menu_sub">
      <div onClick="location.href = '<?=$chemin?>pages/secrets/index'" class="menu_sub_item<?=$h_submenu_css['liste']?>">
        <a                     href="<?=$chemin?>pages/secrets/index">Liste des secrets</a>
      </div>
    </div>

    <?php } else if ($header_menu == 'compte') { ?>
    <div class="menu_sub">
      <div onClick="location.href = '<?=$chemin?>pages/user/notifications'" class="menu_sub_item<?=$h_submenu_css['messages']?>">
        <a                     href="<?=$chemin?>pages/user/notifications">Messages privés</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/user/user?id=<?=$_SESSION['user']?>'" class="menu_sub_item<?=$h_submenu_css['profil']?>">
        <a                     href="<?=$chemin?>pages/user/user?id=<?=$_SESSION['user']?>">Profil public</a>
      </div>
      <div onClick="location.href = '<?=$chemin?>pages/user/reglages'" class="menu_sub_item<?=$h_submenu_css['reglages']?>">
        <a                     href="<?=$chemin?>pages/user/reglages">Réglages du compte</a>
      </div>
      <div onClick="location.href = '<?=$url_logout?>'" class="menu_sub_item">
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
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/coulisses'" class="menu_side_item<?=$h_side_css['coulisses']?>">
            <a                     href="<?=$chemin?>pages/nobleme/coulisses">Coulisses de NoBleme</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/coulisses?source'" class="menu_side_item<?=$h_side_css['source']?>">
            <a                     href="<?=$chemin?>pages/nobleme/coulisses?source">Code source du site</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/todo/roadmap'" class="menu_side_item<?=$h_side_css['roadmap']?>">
            <a                     href="<?=$chemin?>pages/todo/roadmap">Plan de route</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/index'" class="menu_side_item<?=$h_side_css['todo']?>">
            <a                     href="<?=$chemin?>pages/todo/index">Tâches non résolues</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/index?solved'" class="menu_side_item<?=$h_side_css['todo_solved']?>">
            <a                     href="<?=$chemin?>pages/todo/index?solved">Tâches résolues</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/index?recent'" class="menu_side_item<?=$h_side_css['todo_recent']?>">
            <a                     href="<?=$chemin?>pages/todo/index?recent">Tâches récentes</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/add'" class="menu_side_item<?=$h_side_css['ticket']?>">
            <a                     href="<?=$chemin?>pages/todo/add">Ouvrir un ticket</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/rss'" class="menu_side_item<?=$h_side_css['todo_rss']?>">
            <a                     href="<?=$chemin?>pages/todo/rss">Tâches : Flux RSS</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/devblog/index'" class="menu_side_item<?=$h_side_css['devblog']?>">
            <a                     href="<?=$chemin?>pages/devblog/index">Blog de développement</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/devblog/top'" class="menu_side_item<?=$h_side_css['devblog_top']?>">
            <a                     href="<?=$chemin?>pages/devblog/top">Devblogs populaires</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/devblog/rss'" class="menu_side_item<?=$h_side_css['devblog_rss']?>">
            <a                     href="<?=$chemin?>pages/devblog/rss">Devblogs : Flux RSS</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/todo/add?bug'" class="menu_side_item<?=$h_side_css['ticket_bug']?>">
            <a                     href="<?=$chemin?>pages/todo/add?bug">Rapporter un bug</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/add?feature'" class="menu_side_item<?=$h_side_css['ticket_feature']?>">
            <a                     href="<?=$chemin?>pages/todo/add?feature">Quémander un feature</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == '' && $header_submenu == 'aide') { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/doc/index'" class="menu_side_item<?=$h_side_css['documentation']?>">
            <a                     href="<?=$chemin?>pages/doc/index">Documentation du site</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/doc/nobleme'" class="menu_side_item<?=$h_side_css['nobleme']?>">
            <a                     href="<?=$chemin?>pages/doc/nobleme">Qu'est-ce que NoBleme</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/doc/coc'" class="menu_side_item<?=$h_side_css['coc']?>">
            <a                     href="<?=$chemin?>pages/doc/coc">Code de conduite</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/doc/bbcodes'" class="menu_side_item<?=$h_side_css['bbcodes']?>">
            <a                     href="<?=$chemin?>pages/doc/bbcodes">Utiliser les BBCodes</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/doc/emotes'" class="menu_side_item<?=$h_side_css['emotes']?>">
            <a                     href="<?=$chemin?>pages/doc/emotes">Liste des émoticônes</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/doc/rss'" class="menu_side_item<?=$h_side_css['rss']?>">
            <a                     href="<?=$chemin?>pages/doc/rss">S'abonner aux flux RSS</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/add?bug&amp;doc'" class="menu_side_item<?=$h_side_css['bug']?>">
            <a                     href="<?=$chemin?>pages/todo/add?bug&amp;doc">Rapporter un bug</a>
          </div>

        </div>
      </nav>

      <?php } else if($header_menu == 'communaute' && $header_submenu == 'membres') { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/index'" class="menu_side_item<?=$h_side_css['portail']?>">
            <a                     href="<?=$chemin?>pages/nobleme/index">Portail des membres</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/membres'" class="menu_side_item<?=$h_side_css['liste']?>">
            <a                     href="<?=$chemin?>pages/nobleme/membres">Liste des membres</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/anniversaires'" class="menu_side_item<?=$h_side_css['anniversaires']?>">
            <a                     href="<?=$chemin?>pages/nobleme/anniversaires">Anniversaires</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/pilori'" class="menu_side_item<?=$h_side_css['pilori']?>">
            <a                     href="<?=$chemin?>pages/nobleme/pilori">Pilori des bannis</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'lire' && $header_submenu == 'nbrpg') { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/index'" class="menu_side_item<?=$h_side_css['index']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/index">Qu'est-ce que le NBRPG ?</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/joueurs_actifs'" class="menu_side_item<?=$h_side_css['liste_persos']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/joueurs_actifs">Liste des personnages</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/archive'" class="menu_side_item<?=$h_side_css['archive']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/archive">Archive des sessions</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/caverne'" class="menu_side_item<?=$h_side_css['caverne']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/caverne">La caverne de Liodain</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/caverne?historique'" class="menu_side_item<?=$h_side_css['historique']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/caverne?historique">Caverne : Historique</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/caverne?random'" class="menu_side_item<?=$h_side_css['caverne_random']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/caverne?random">Caverne : Page au hasard</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/client'" class="menu_side_item<?=$h_side_css['client']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/client">Client : Jouer au NBRPG</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/client_spectateur'" class="menu_side_item<?=$h_side_css['observer']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/client_spectateur">Observer le jeu en cours</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nbrpg/fiche_perso'" class="menu_side_item<?=$h_side_css['fiche_perso']?>">
            <a                     href="<?=$chemin?>pages/nbrpg/fiche_perso">Ma fiche de personnage</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'lire' && $header_submenu == 'miscellanees') { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/irc/quotes'" class="menu_side_item<?=$h_side_css['paroles']?>">
            <a                     href="<?=$chemin?>pages/irc/quotes">Paroles de NoBlemeux</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/quotes?random'" class="menu_side_item<?=$h_side_css['hasard']?>">
            <a                     href="<?=$chemin?>pages/irc/quotes?random">Citation au hasard</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/quotes_stats'" class="menu_side_item<?=$h_side_css['stats']?>">
            <a                     href="<?=$chemin?>pages/irc/quotes_stats">Statistiques des citations</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/irc/quote_add'" class="menu_side_item<?=$h_side_css['proposer']?>">
            <a                     href="<?=$chemin?>pages/irc/quote_add">Proposer une citation</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/irc/quotes_rss'" class="menu_side_item<?=$h_side_css['rss']?>">
            <a                     href="<?=$chemin?>pages/irc/quotes_rss">Flux RSS des citations</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'discuter' && $header_submenu == 'irc') { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/irc/index'" class="menu_side_item<?=$h_side_css['index']?>">
            <a                     href="<?=$chemin?>pages/irc/index">Qu'est-ce que IRC ?</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/web'" class="menu_side_item<?=$h_side_css['clic']?>">
            <a                     href="<?=$chemin?>pages/irc/web">Discuter en un clic</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/irc/traditions'" class="menu_side_item<?=$h_side_css['traditions']?>">
            <a                     href="<?=$chemin?>pages/irc/traditions">Coutumes et traditions</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/canaux'" class="menu_side_item<?=$h_side_css['canaux']?>">
            <a                     href="<?=$chemin?>pages/irc/canaux">Liste des canaux</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/services'" class="menu_side_item<?=$h_side_css['services']?>">
            <a                     href="<?=$chemin?>pages/irc/services">Commandes et services</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/akundo'" class="menu_side_item<?=$h_side_css['akundo']?>">
            <a                     href="<?=$chemin?>pages/irc/akundo">Utilisation d'Akundo</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/irc/client'" class="menu_side_item<?=$h_side_css['client']?>">
            <a                     href="<?=$chemin?>pages/irc/client">Installer un client IRC</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/bouncer'" class="menu_side_item<?=$h_side_css['bouncer']?>">
            <a                     href="<?=$chemin?>pages/irc/bouncer">Utiliser un bouncer</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'admin' && $header_submenu == 'mod' && getsysop()) { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/activite?mod'" class="menu_side_item<?=$h_side_css['modlogs']?>">
            <a                     href="<?=$chemin?>pages/nobleme/activite?mod">Logs de modération</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/sysop/ban'" class="menu_side_item<?=$h_side_css['bannir']?>">
            <a                     href="<?=$chemin?>pages/sysop/ban">Bannir un utilisateur</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/sysop/profil'" class="menu_side_item<?=$h_side_css['profil']?>">
            <a                     href="<?=$chemin?>pages/sysop/profil">Modifier un profil</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/sysop/pass'" class="menu_side_item<?=$h_side_css['pass']?>">
            <a                     href="<?=$chemin?>pages/sysop/pass">Éditer un mot de passe</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/sysop/irl?add'" class="menu_side_item<?=$h_side_css['irl_add']?>">
            <a                     href="<?=$chemin?>pages/sysop/irl?add">Créer une nouvelle IRL</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/irls?edit'" class="menu_side_item<?=$h_side_css['irl_edit']?>">
            <a                     href="<?=$chemin?>pages/nobleme/irls?edit">Modifier une IRL</a>
          </div>
          <?php if(getadmin()) { ?>
          <div onClick="location.href = '<?=$chemin?>pages/nobleme/irls?delete'" class="menu_side_item<?=$h_side_css['irl_delete']?>">
            <a                     href="<?=$chemin?>pages/nobleme/irls?delete">Supprimer une IRL</a>
          </div>
          <?php } ?>
        </div>
      </nav>

      <?php } else if($header_menu == 'admin' && $header_submenu == 'admin' && getadmin()) { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/admin/stats_doppelgangers'" class="menu_side_item<?=$h_side_css['stats_dop']?>">
            <a                     href="<?=$chemin?>pages/admin/stats_doppelgangers">Doppelgängers</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/admin/stats_pageviews'" class="menu_side_item<?=$h_side_css['stats_views']?>">
            <a                     href="<?=$chemin?>pages/admin/stats_pageviews">Stats : Pageviews</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/admin/stats_referers'" class="menu_side_item<?=$h_side_css['stats_refs']?>">
            <a                     href="<?=$chemin?>pages/admin/stats_referers">Stats : Referers</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/admin/stats_pageviews_evolution'" class="menu_side_item<?=$h_side_css['stats_views_evo']?>">
            <a                     href="<?=$chemin?>pages/admin/stats_pageviews_evolution">Évolution : Pageviews</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/admin/stats_referers_evolution'" class="menu_side_item<?=$h_side_css['stats_refs_evo']?>">
            <a                     href="<?=$chemin?>pages/admin/stats_referers_evolution">Évolution : Referers</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/devblog/admin?add'" class="menu_side_item<?=$h_side_css['devblog_add']?>">
            <a                     href="<?=$chemin?>pages/devblog/admin?add">Nouveau devblog</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/todo/admin?add'" class="menu_side_item<?=$h_side_css['todo_add']?>">
            <a                     href="<?=$chemin?>pages/todo/admin?add">Nouveau ticket</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/todo/index?admin'" class="menu_side_item<?=$h_side_css['todo_valider']?>">
            <a                     href="<?=$chemin?>pages/todo/index?admin">Tâches à valider</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/irc/quote_add?admin'" class="menu_side_item<?=$h_side_css['quote_add']?>">
            <a                     href="<?=$chemin?>pages/irc/quote_add?admin">Nouvelle miscellanée</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/irc/quotes?admin'" class="menu_side_item<?=$h_side_css['quote_valider']?>">
            <a                     href="<?=$chemin?>pages/irc/quotes?admin">Miscellanées à valider</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'admin' && $header_submenu == 'dev' && getadmin()) { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/dev/maj'" class="menu_side_item<?=$h_side_css['maj']?>">
            <a                     href="<?=$chemin?>pages/dev/maj">Mise à jour : Checklist</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/dev/sql'" class="menu_side_item<?=$h_side_css['sql']?>">
            <a                     href="<?=$chemin?>pages/dev/sql">Mise à jour : Requêtes</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/dev/ircbot'" class="menu_side_item<?=$h_side_css['ircbot']?>">
            <a                     href="<?=$chemin?>pages/dev/ircbot">Gestion du bot IRC</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/dev/formattage'" class="menu_side_item<?=$h_side_css['formattage']?>">
            <a                     href="<?=$chemin?>pages/dev/formattage">Formattage du code</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/dev/css'" class="menu_side_item<?=$h_side_css['css']?>">
            <a                     href="<?=$chemin?>pages/dev/css">Référence du CSS</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/dev/fonctions'" class="menu_side_item<?=$h_side_css['fonctions']?>">
            <a                     href="<?=$chemin?>pages/dev/fonctions">Liste des fonctions</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/dev/images'" class="menu_side_item<?=$h_side_css['charte']?>">
            <a                     href="<?=$chemin?>pages/dev/images">Charte graphique</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/dev/pages'" class="menu_side_item<?=$h_side_css['nompages']?>">
            <a                     href="<?=$chemin?>pages/dev/pages">Gestion : Nom des pages</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/dev/flashanniv'" class="menu_side_item<?=$h_side_css['flashanniv']?>">
            <a                     href="<?=$chemin?>pages/dev/flashanniv">Gestion : Flashs anniv.</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'compte' && $header_submenu == 'messages') { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/user/pm'" class="menu_side_item<?=$h_side_css['ecrire']?>">
            <a                     href="<?=$chemin?>pages/user/pm">Écrire un message</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/user/notifications'" class="menu_side_item<?=$h_side_css['inbox']?>">
            <a                     href="<?=$chemin?>pages/user/notifications">Messages reçus</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/user/notifications?envoyes'" class="menu_side_item<?=$h_side_css['envoyes']?>">
            <a                     href="<?=$chemin?>pages/user/notifications?envoyes">Messages envoyés</a>
          </div>
        </div>
      </nav>

      <?php } else if($header_menu == 'compte' && $header_submenu == 'reglages') { ?>
      <nav>
        <div class="menu_side">
          <div onClick="location.href = '<?=$chemin?>pages/user/reglages'" class="menu_side_item<?=$h_side_css['reglages']?>">
            <a                     href="<?=$chemin?>pages/user/reglages">Réglages généraux</a>
          </div>
          <hr class="menu_side_hr">
          <div onClick="location.href = '<?=$chemin?>pages/user/email'" class="menu_side_item<?=$h_side_css['email']?>">
            <a                     href="<?=$chemin?>pages/user/email">Changer d'e-mail</a>
          </div>
          <div onClick="location.href = '<?=$chemin?>pages/user/pass'" class="menu_side_item<?=$h_side_css['pass']?>">
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