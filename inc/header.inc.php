<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


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

// If the user permission variables don't exist, stop here
if(!isset($is_admin) || !isset($is_global_moderator) || !isset($is_moderator))
  exit(__('error_forbidden'));

// If the user doesn't have a set language, stop here
if(!isset($lang))
  exit(__('error_forbidden'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default variable values (those are required by the header but it's fine if they're not set)

// Check whether the page exist in the user's current language - if not, throw an error message
$lang_error = (isset($page_lang) && !in_array($lang, $page_lang)) ? 1 : 0;

// If page names and URLs for user activity are not set, give them a default value
$activity_url     = (isset($page_url) && !isset($hidden_activity)) ? $page_url : '';
$activity_page_en = (isset($page_title_en) && !isset($hidden_activity)) ? $page_title_en : 'Unlisted page';
$activity_page_fr = (isset($page_title_fr) && !isset($hidden_activity)) ? $page_title_fr : 'Page non listée';




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

// Keep the update status in a variable
$website_closed = $dupdate['update'];

// If yes, close the website to anyone who's not an admin
if($website_closed && !$is_admin)
  exit(__('error_website_update'));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  LOGIN / LOGOUT                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Creation of URLs to use for logging out and changing language
$url_logout = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&logout' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?logout';
$url_lang   = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&changelang=1' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?changelang=1';

// Logout
if(isset($_GET['logout']))
{
  // Log the user out
  user_log_out();

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
if(isset($page_url) && !isset($error_mode))
{
  // Sanitize the data
  $page_url_sanitized = sanitize($page_url, 'string');
  $page_en_sanitized  = sanitize($page_title_en, 'string');
  $page_fr_sanitized  = sanitize($page_title_fr, 'string');
  $page_timestamp     = time();

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
            SET     stats_pageviews.view_count      = stats_pageviews.view_count + 1  ,
                    stats_pageviews.page_name_en    = '$page_en_sanitized'            ,
                    stats_pageviews.page_name_fr    = '$page_fr_sanitized'            ,
                    stats_pageviews.last_viewed_at  = '$page_timestamp'
            WHERE   stats_pageviews.page_url        = '$page_url_sanitized' ");

  // If it doesn't, create the page and give it its first pageview
  else if(!$dpageviews["p_views"])
    query(" INSERT INTO stats_pageviews
            SET         stats_pageviews.page_url        = '$page_url_sanitized' ,
                        stats_pageviews.page_name_en    = '$page_en_sanitized'  ,
                        stats_pageviews.page_name_fr    = '$page_fr_sanitized'  ,
                        stats_pageviews.last_viewed_at  = '$page_timestamp'     ,
                        stats_pageviews.view_count      = 1                     ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// User and guest activity

// Fetch and sanitize all the data required to track recent activity
$activity_timestamp         = time();
$activity_ip                = sanitize($_SERVER["REMOTE_ADDR"], 'string');
$activity_page_en_sanitized = sanitize($activity_page_en, 'string');
$activity_page_fr_sanitized = sanitize($activity_page_fr, 'string');
$activity_url_sanitized     = sanitize($activity_url, 'string');
$activity_user              = (user_is_logged_in()) ? sanitize(user_get_id(), 'int', 0) : 0;

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
  $guest_limit = time() - 2500000;
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

// Set the current page title based on the user's language
$page_title = ($lang == 'EN' && isset($page_title_en)) ? $page_title_en : '';
$page_title = ($lang == 'FR' && isset($page_title_fr)) ? $page_title_fr : $page_title;

// If the current page is unnamed, simply call it NoBleme, else prepend NoBleme to it
$page_title = ($page_title) ? 'NoBleme - '.$page_title : 'NoBleme';

// If we are working on dev mode, add an @ before the page's title
if($GLOBALS['dev_mode'])
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

// Include the default javascript files (weird line breaks are for indentation)
$javascripts = '
    <script src="'.$path.'js/common.js"> </script>';

// If extra JS files are set, add them to the list
if (isset($js))
{
  // Loop through all files and include them
  for($i = 0; $i < count($js); $i++)
    $javascripts .= '
    <script src="'.$path.'js/'.$js[$i].'.js"> </script>';
}

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
    <link rel="shortcut icon" href="<?=$path?>favicon.ico">
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

  <?php if(isset($this_page_is_a_404)) { ?>
<body id="body" onload="this_page_is_a_404();">
  <?php } else if(isset($onload)) { ?>
<body id="body" onload="<?=$onload?>">
  <?php } else { ?>
<body id="body">
  <?php } ?>

<?php ############################################# WEBSITE UPDATE ################################################# ?>

    <?php if($website_closed) { ?>

    <div class="header_infobar error">
      <?=__link('todo_link', __('website_closed'), 'noglow glowhover bold indiv align_center biggest', 1, $path);?>
    </div>

    <?php } ?>

<?php /* ############################################## TOP MENU ################### */ if(!isset($_GET["popup"])) { ?>

    <div class="header_topmenu">

      <div id="header_titres" class="header_topmenu_zone">

        <div class="header_topmenu_title" onclick="toggle_header_menu('nobleme');">
          <?=__('menu_top_nobleme')?>
        </div>

        <div class="header_topmenu_title" onclick="toggle_header_menu('community');">
          <?=__('menu_top_community')?>
        </div>

        <div class="header_topmenu_title" onclick="toggle_header_menu('pages');">
          <?=__('menu_top_pages')?>
        </div>

        <?php if($is_global_moderator) { ?>
        <div class="header_topmenu_title" onclick="toggle_header_menu('admin');">
          <?=__('menu_top_admin')?>
        </div>
        <?php } ?>

      </div>

      <div class="header_topmenu_zone header_topmenu_flag">

        <a href="<?=$url_lang?>">
          <?php if($lang == 'FR') { ?>
          <img class="header_topmenu_flagimg" src="<?=$path?>img/icons/lang_en_clear.png" alt="EN">
          <?php } else { ?>
          <img class="header_topmenu_flagimg" src="<?=$path?>img/icons/lang_fr_clear.png" alt="FR">
          <?php } ?>
        </a>

      </div>
    </div>

<?php ########################################### LOGIN / STATUS BAR ############################################### ?>

    <div class="header_infobar">

      <?php if(user_is_logged_in()) {
            if($nb_private_messages) { ?>

      <div class="header_topmenu_zone header_infobar_link header_infobar_notification pointer" onclick="toggle_header_menu('account');" id="header_infobar_new_messages">
        <span class="desktop">
          <?=__('header_status_message', $nb_private_messages, 0, 0, array(sanitize_output(user_get_nickname()), $nb_private_messages))?>
        </span>
        <span class="mobile">
          <?=__('header_status_message_short', $nb_private_messages, 0, 0, array(sanitize_output(user_get_nickname()), $nb_private_messages))?>
        </span>
      </div>

      <?php } else { ?>

      <div class="header_topmenu_zone header_infobar_link pointer" onclick="toggle_header_menu('account');">
        <span class="desktop">
          <?=__('header_status_logged_in', 0, 0, 0, array(sanitize_output(user_get_nickname())))?>
        </span>
        <span class="mobile">
          <?=__('header_status_logged_in_short', 0, 0, 0, array(sanitize_output(user_get_nickname())))?>
        </span>
      </div>

      <?php } ?>

      <div class="header_topmenu_zone">
        <?=__link($url_logout, __('header_status_logout'), "header_infobar_link", 1, $path);?>
      </div>

      <?php } else { ?>

      <div class="header_topmenu_zone header_infobar_link">
        <span class="desktop">
          <?=__link('pages/users/login', __('header_status_login'), "header_infobar_link", 1, $path);?>
        </span>
        <span class="mobile">
          <?=__link('pages/users/login', __('header_status_login_short'), "header_infobar_link", 1, $path);?>
        </span>
      </div>

      <?php } ?>

    </div>

<?php ############################################ SUBMENU: NOBLEME ################################################ ?>

    <div class="header_submenu" id="header_submenu_nobleme">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('nobleme.com')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('index', __('submenu_nobleme_homepage'), 'text_red noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('pages/nobleme/activity', __('submenu_nobleme_activity'), 'text_red noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_what_is'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_internet'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_irc'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_manifesto'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_nobleme_documentation')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_coc'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_privacy'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_personal_data'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_contact_admin'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_nobleme_dev')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_behind_scenes'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_devblog'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_todolist'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_roadmap'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_report_bug'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_nobleme_feature'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

    </div>


<?php ########################################### SUBMENU: COMMUNITY ############################################### ?>

    <div class="header_submenu" id="header_submenu_community">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_community_users')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_online'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_userlist'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_staff'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_birthdays'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_community_irc')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_irc_intro'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_irc_browser'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_irc_client'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_irc_channels'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_community_meetups')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_meetups_list'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_meetups_stats'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_community_quotes')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_quotes_list'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_quotes_random'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_quotes_stats'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_community_quotes_submit'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

    </div>

<?php ############################################# SUBMENU: PAGES ################################################# ?>

    <div class="header_submenu" id="header_submenu_pages">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_pages_internet')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_internet_index'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_internet_pages'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_internet_dictionary'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_internet_culture'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_internet_random'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_pages_politics')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('pages/politics/manifesto', __('submenu_pages_politics_manifesto'), 'text_red noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_pages_archives')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_nbrpg'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_nrm'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_pages_nrm_champions'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

    </div>

<?php ############################################# SUBMENU: ADMIN ################################################# ?>

    <?php if($is_global_moderator) { ?>
    <div class="header_submenu" id="header_submenu_admin">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_activity')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('pages/nobleme/activity?mod', __('submenu_admin_modlogs'), 'text_red noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_users')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_banned'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_nickname'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_password'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <?php if($is_admin) { ?>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_rights'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <?php } ?>
      </div>

      <?php if($is_admin) { ?>
      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_stats')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_pageviews'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_doppelganger'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_website')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_ircbot'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_close'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('pages/dev/queries', __('submenu_admin_sql'), 'text_red noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_release'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_scheduler'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_doc')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('pages/dev/snippets', __('submenu_admin_doc_snippets'), 'text_red noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_admin_doc_css'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>
      <?php } ?>

    </div>
    <?php } ?>

<?php ############################################ SUBMENU: ACCOUNT ################################################ ?>

    <?php if($is_logged_in) { ?>
    <div class="header_submenu" id="header_submenu_account">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_pms')?>
        </div>
        <?php if($nb_private_messages) { ?>
        <div class="header_submenu_link header_infobar_notification">
          <?=__link('todo_link', __('submenu_user_pms_inbox'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <?php } else { ?>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_pms_inbox'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <?php } ?>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_pms_outbox'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_pms_write'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_profile')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_profile_self'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_profile_edit'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_settings')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_settings_privacy'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_settings_nsfw'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_edit')?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_edit_email'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_edit_password'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_edit_nickname'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
        <div class="header_submenu_link">
          <?=__link('todo_link', __('submenu_user_edit_delete'), 'text_error noglow glowhover bold', 1, $path);?>
        </div>
      </div>

    </div>
    <?php } ?>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                                             END HEADER AND BEGIN PAGE                                             //
//                                                                                                                   //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

    <div class="header_main_page">

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