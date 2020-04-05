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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Login attempt

if(isset($_POST['login_form_submit']))
{
  // Check whether "remember me" is checked
  $login_form_remember_me = isset($_POST['login_form_remember']) ? 1 : null;

  // Attempt to login
  $login_form_attempt = user_authenticate(  $_SERVER["REMOTE_ADDR"]       ,
                                            $_POST['login_form_nickname'] ,
                                            $_POST['login_form_password'] ,
                                            $login_form_remember_me       );

  // If the user has logged in, redirect them
  if($login_form_attempt === 1)
    header("location: ".$path."todo_link");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Form values

$login_form_nickname    = isset($_POST['login_form_nickname']) ? sanitize_output($_POST['login_form_nickname']) : '';
$login_form_password    = isset($_POST['login_form_password']) ? sanitize_output($_POST['login_form_password']) : '';
$login_form_remember_me = (isset($_POST['login_form_remember']) || !isset($_POST['login_form_submit'])) ? " checked" : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Creation of URLs to use for logging out and changing language

$url_logout = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&logout' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?logout';
$url_lang   = ($_SERVER['QUERY_STRING']) ? substr(basename($_SERVER['PHP_SELF']),0,-4).'?'.$_SERVER['QUERY_STRING'].'&changelang=1' : substr(basename($_SERVER['PHP_SELF']),0,-4).'?changelang=1';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Logout

if(isset($_GET['logout']))
  user_log_out();




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
  $dpms                     = mysqli_fetch_array($qpms);
  $nb_private_messages      = $dpms['pm_nb'];
  $nb_private_messages_css  = ($nb_private_messages) ? ' header_submenu_blink' : '';
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

    <div class="header_infobar red">
      <?=__link('todo_link', __('website_closed'), 'noglow glowhover bold indiv align_center biggest', 1, $path);?>
    </div>

    <?php } ?>


<?php /* ############################################## TOP MENU ################### */ if(!isset($_GET["popup"])) { ?>

    <div class="header_topmenu">

      <div id="header_titres" class="header_topmenu_zone">

        <div class="header_topmenu_title" id="header_menu_title_nobleme" onclick="toggle_header_menu('nobleme', 1);">
          <?=__('menu_top_nobleme')?>
        </div>

        <div class="header_topmenu_title" id="header_menu_title_pages" onclick="toggle_header_menu('pages', 1);">
          <?=__('menu_top_pages')?>
        </div>

        <div class="header_topmenu_title" id="header_menu_title_social" onclick="toggle_header_menu('social', 1);">
          <?=__('menu_top_social')?>
        </div>

      </div>

      <div class="header_topmenu_zone">

        <?php if(user_is_logged_in() && $nb_private_messages) { ?>
        <img id="header_topmenu_account_icon" class="header_topmenu_icon header_topmenu_mail" src="<?=$path?>img/icons/login_mail.svg" alt="Account" onclick="toggle_header_menu('account');">
        <?php } else { ?>
        <img id="header_topmenu_account_icon" class="header_topmenu_icon header_topmenu_account" src="<?=$path?>img/icons/login.svg" alt="Account" onclick="toggle_header_menu('account');">
        <?php } ?>

        <?php if($is_global_moderator) { ?>
        <img class="header_topmenu_icon header_topmenu_panel" src="<?=$path?>img/icons/admin_panel.svg" alt="Account" onclick="toggle_header_menu('admin');">
        <?php } ?>

        <a href="<?=$url_lang?>">
          <?php if($lang == 'FR') { ?>
          <img class="header_topmenu_icon header_topmenu_flag" src="<?=$path?>img/icons/lang_en.png" alt="EN">
          <?php } else { ?>
          <img class="header_topmenu_icon header_topmenu_flag" src="<?=$path?>img/icons/lang_fr.png" alt="FR">
          <?php } ?>
        </a>

      </div>
    </div>


<?php ############################################ SUBMENU: NOBLEME ################################################ ?>

    <div class="header_submenu" id="header_submenu_nobleme">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('nobleme.com')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('index', __('submenu_nobleme_homepage'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/nobleme/activity', __('submenu_nobleme_activity'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_what_is'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_internet'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_irc'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/politics/manifesto', __('submenu_nobleme_manifesto'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_nobleme_users')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/users/online', __('submenu_nobleme_online'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_userlist'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_staff'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_birthdays'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_nobleme_dev')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_behind_scenes'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_devblog'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_todolist'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_roadmap'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_report_bug'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_feature'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_nobleme_documentation')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_what_is'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_coc'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_privacy'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_personal_data'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_nobleme_contact_admin'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

    </div>


<?php ############################################# SUBMENU: PAGES ################################################# ?>

<div class="header_submenu" id="header_submenu_pages">

  <div class="header_submenu_column">
    <div class="header_submenu_title">
      <?=__('submenu_pages_internet')?>
    </div>
    <div class="header_submenu_item">
      <?=__link('todo_link', __('submenu_pages_internet_index'), 'header_submenu_link text_blue', 1, $path);?>
    </div>
    <div class="header_submenu_item">
      <?=__link('todo_link', __('submenu_pages_internet_pages'), 'header_submenu_link text_blue', 1, $path);?>
    </div>
    <div class="header_submenu_item">
      <?=__link('todo_link', __('submenu_pages_internet_dictionary'), 'header_submenu_link text_blue', 1, $path);?>
    </div>
    <div class="header_submenu_item">
      <?=__link('todo_link', __('submenu_pages_internet_culture'), 'header_submenu_link text_blue', 1, $path);?>
    </div>
    <div class="header_submenu_item">
      <?=__link('todo_link', __('submenu_pages_internet_random'), 'header_submenu_link text_blue', 1, $path);?>
    </div>
  </div>

  <div class="header_submenu_column">
    <div class="header_submenu_title">
      <?=__('submenu_pages_politics')?>
    </div>
    <div class="header_submenu_item">
      <?=__link('pages/politics/manifesto', __('submenu_pages_politics_manifesto'), 'header_submenu_link', 1, $path);?>
    </div>
    <div class="header_submenu_item">
      <?=__link('todo_link', __('submenu_pages_politics_documentation'), 'header_submenu_link text_blue', 1, $path);?>
    </div>
    <div class="header_submenu_item">
      <?=__link('todo_link', __('submenu_pages_politics_join'), 'header_submenu_link text_blue', 1, $path);?>
    </div>
  </div>

</div>


<?php ############################################## SUBMENU: SOCIAL ############################################## ?>

    <div class="header_submenu" id="header_submenu_social">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_social_irc')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_irc_intro'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_irc_browser'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_irc_client'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_irc_channels'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_social_meetups')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_meetups_list'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_meetups_stats'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_social_games')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_games_minecraft'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_games_nbrpg'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_games_nrm'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_social_quotes')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_quotes_list'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_quotes_random'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_quotes_stats'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_social_quotes_submit'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

    </div>


<?php ############################################ SUBMENU: ACCOUNT ################################################ ?>

    <div class="header_submenu" id="header_submenu_account">
    <?php if($is_logged_in) { ?>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_pms')?>
        </div>
        <div class="header_submenu_item<?=$nb_private_messages_css?>">
          <?=__link('todo_link', __('submenu_user_pms_inbox'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_pms_outbox'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_pms_write'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_profile')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_profile_self'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_profile_edit'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_settings')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_settings_privacy'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_settings_nsfw'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_edit')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_edit_email'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_edit_password'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_edit_nickname'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_user_edit_delete'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=sanitize_output(user_get_nickname())?>
        </div>
        <div class="header_submenu_item">
          <a class="header_submenu_link" href="<?=$url_logout?>"><?=__('submenu_user_logout_logout')?></a>
        </div>
      </div>

      <?php } else { ?>

      <div class="header_submenu_fullwidth">

        <div class="width_30 bigpadding_top hugepadding_bot">

        <h1 class="align_center padding_bot">
          <?=__('login_form_title')?>
        </h1>

        <?php if(isset($login_form_attempt)) { ?>

        <h5 class="align_center bigpadding_bot padding_top underlined dowrap">
          <?=string_change_case(__('error'), 'uppercase').__(':').' '.$login_form_attempt?>
        </h5>

        <?php } ?>

        <form method="POST" action="">
          <fieldset>

            <div class="smallpadding_bot">
              <label class="text_light" for="login_form_nickname"><?=string_change_case(__('nickname'), 'initials')?></label>
              <input id="login_form_nickname" name="login_form_nickname" class="indiv" type="text" value="<?=$login_form_nickname?>">
            </div>

            <div class="padding_bot">
              <label class="text_light" for="login_form_password"><?=string_change_case(__('password'), 'initials')?> <?=__link('pages/users/forgotten_password', __('login_form_form_forgotten'), 'bold', 1, $path)?></label>
              <input id="login_form_password" name="login_form_password" class="indiv" type="password" value="<?=$login_form_password?>">
            </div>

            <div class="float_right">
              <input id="login_form_remember" name="login_form_remember" type="checkbox"<?=$login_form_remember_me?>>
              <label class="label_inline" for="login_form_remember"><?=__('login_form_form_remember')?></label>
            </div>
            <input value="<?=__('login_form_title')?>" type="submit" name="login_form_submit">
            &nbsp;&nbsp;
            <a class="noglow" href="<?=$path?>pages/users/register">
              <button type="button"><?=__('login_form_form_register')?></button>
            </a>

          </fieldset>
        </form>

      </div>

      </div>

      <?php } ?>
    </div>


<?php ############################################# SUBMENU: ADMIN ################################################# ?>

    <?php if($is_global_moderator) { ?>
    <div class="header_submenu" id="header_submenu_admin">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_activity')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/nobleme/activity?mod', __('submenu_admin_modlogs'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_users')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_banned'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_nickname'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_password'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <?php if($is_admin) { ?>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_rights'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <?php } ?>
      </div>

      <?php if($is_admin) { ?>
      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_stats')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_pageviews'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_doppelganger'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_website')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_ircbot'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_close'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/queries', __('submenu_admin_sql'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_release'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('todo_link', __('submenu_admin_scheduler'), 'header_submenu_link text_blue', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_doc')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/snippets', __('submenu_admin_doc_snippets'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/palette', __('submenu_admin_doc_css'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>
      <?php } ?>

    </div>
    <?php } ?>


<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                                             END HEADER AND BEGIN PAGE                                             //
//                                                                                                                   //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

    <div class="header_main_page">

      <?php } if($meta_alert) { ?>

      <h5 class="align_center monospace padding_top">
        <?=$meta_alert?>
      </h5>

      <?php } if($lang_error) { ?>

      <div class="align_center monospace bigpadding_bot">
        <?=__('header_language_error');?>
      </div>

      <?php } ?>