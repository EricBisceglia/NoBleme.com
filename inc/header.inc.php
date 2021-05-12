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
// Debug mode

// In ENV debug mode, print all environment variables in header
if($GLOBALS['dev_mode'] && $GLOBALS['env_debug_mode'])
{
  var_dump(array('GET', $_GET));
  var_dump(array('POST', $_POST));
  var_dump(array('FILES', $_FILES));
  var_dump(array('ENV', $_ENV));
  var_dump(array('REQUEST', $_REQUEST));
  var_dump(array('SESSION', $_SESSION));
  var_dump(array('COOKIE', $_COOKIE));
  var_dump(array('SERVER', $_SERVER));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Restrictions and prerequisites

// If the user permission variables don't exist, stop here
if(!isset($is_admin) || !isset($is_moderator))
  exit(__('error_forbidden'));

// If the user doesn't have a set language, stop here
if(!isset($lang))
  exit(__('error_forbidden'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default variable values (those are required by the header but it's fine if they're not set)

// Check whether the page exist in the user's current language - if not, throw an error message
$lang_error = (isset($page_lang) && !in_array($lang, $page_lang));

// If page names and URLs for user activity are not set, give them a default value
$activity_url     = (isset($page_url) && !isset($hidden_activity)) ? $page_url : '';
$activity_page_en = (isset($page_title_en) && !isset($hidden_activity)) ? $page_title_en : 'Unlisted page';
$activity_page_fr = (isset($page_title_fr) && !isset($hidden_activity)) ? $page_title_fr : 'Page non listée';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 WEBSITE SHUTDOWN                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Check whether a website update is in progress
$website_closed = $system_variables['update_in_progress'];

// If yes, close the website to anyone who's not an admin
if($website_closed  && !$is_admin)
  exit(__('error_website_update'));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      ACCOUNT                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

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
  $page_timestamp     = sanitize(time(), 'int', 0);

  // Fetch current page's view count
  $qpageviews = query(" SELECT  stats_pages.view_count AS 'p_views'
                        FROM    stats_pages
                        WHERE   stats_pages.page_url = '$page_url_sanitized' ");

  // Define the current view count (used in the footer for metrics)
  $dpageviews = mysqli_fetch_array($qpageviews);
  $pageviews  = (isset($dpageviews["p_views"])) ? ($dpageviews["p_views"] + 1) : 1;

  // If the page exists, increment its view count
  if(mysqli_num_rows($qpageviews) != 0)
  {
    // Don't increment it however if the user is an admin in production mode
    if(!$is_admin || $GLOBALS['dev_mode'])
      query(" UPDATE  stats_pages
              SET     stats_pages.view_count      =     stats_pages.view_count + 1  ,
                      stats_pages.page_name_en    =     '$page_en_sanitized'        ,
                      stats_pages.page_name_fr    =     '$page_fr_sanitized'
              WHERE   stats_pages.page_url        LIKE  '$page_url_sanitized' ");
  }

  // If it doesn't, create the page and give it its first pageview
  else if(!isset($dpageviews["p_views"]))
    query(" INSERT INTO stats_pages
            SET         stats_pages.page_url        = '$page_url_sanitized' ,
                        stats_pages.page_name_en    = '$page_en_sanitized'  ,
                        stats_pages.page_name_fr    = '$page_fr_sanitized'  ,
                        stats_pages.last_viewed_at  = '$page_timestamp'     ,
                        stats_pages.view_count      = 1                     ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// User and guest activity

// Fetch and sanitize all the data required to track recent activity
$activity_timestamp         = sanitize(time(), 'int', 0);
$activity_language          = sanitize(user_get_language(), 'string');
$activity_ip                = sanitize($_SERVER["REMOTE_ADDR"], 'string');
$activity_page_en_sanitized = sanitize($activity_page_en, 'string');
$activity_page_fr_sanitized = sanitize($activity_page_fr, 'string');
$activity_url_sanitized     = sanitize($activity_url, 'string');
$activity_user              = (user_is_logged_in()) ? sanitize(user_get_id(), 'int', 0) : 0;

// Logged in user activity
if($activity_user)
  query(" UPDATE  users
          SET     users.current_language      = '$activity_language'          ,
                  users.last_visited_at       = '$activity_timestamp'         ,
                  users.last_visited_page_en  = '$activity_page_en_sanitized' ,
                  users.last_visited_page_fr  = '$activity_page_fr_sanitized' ,
                  users.last_visited_url      = '$activity_url_sanitized'     ,
                  users.current_ip_address    = '$activity_ip'
          WHERE   users.id                    = '$activity_user'              ");

// Guest activity
else
{
  // Clean up older guest activity
  $guest_limit = sanitize(time() - 2500000, 'int', 0);
  query(" DELETE FROM users_guests
          WHERE       users_guests.last_visited_at < '$guest_limit' ");

  // Check whether the guest already exists in the database
  $qguest   = query(" SELECT  users_guests.ip_address AS 'g_ip'
                      FROM    users_guests
                      WHERE   users_guests.ip_address LIKE '$activity_ip' ");

  // Create the guest if it does not exist
  if(!mysqli_num_rows($qguest))
  {
    // Generate a random username
    $guest_name_en = sanitize(user_generate_random_username('EN'), 'string');
    $guest_name_fr = sanitize(user_generate_random_username('FR'), 'string');

    // Create the guest
    query(" INSERT INTO users_guests
            SET         users_guests.ip_address                 = '$activity_ip'    ,
                        users_guests.randomly_assigned_name_en  = '$guest_name_en'  ,
                        users_guests.randomly_assigned_name_fr  = '$guest_name_fr'  ");
  }

  // Update guest activity data
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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Private messages

// Check only if the user is logged in
if($activity_user)
{
  // Fetch unread private message count
  $dpms = mysqli_fetch_array(query("  SELECT  COUNT(*) AS 'pm_nb'
                                      FROM    users_private_messages
                                      WHERE   users_private_messages.read_at              = 0
                                      AND     users_private_messages.deleted_by_recipient = 0
                                      AND     users_private_messages.fk_users_recipient   = '$activity_user' "));

  // Fetch the result for display
  $private_message_count      = $dpms['pm_nb'];
  $private_message_count_css  = ($private_message_count && basename($_SERVER['PHP_SELF']) != 'inbox.php') ? ' header_submenu_blink' : '';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Administrative mail

// Check only if the user is moderator or above
if($is_moderator)
{
  // Prevent moderators from being warned for admin only mail
  $admin_condition = ($is_admin) ? '' : ' AND users_private_messages.is_admin_only_message = 0 ';
  // Fetch unread private message count
  $dpms = mysqli_fetch_array(query("  SELECT  COUNT(*) AS 'pm_nb'
                                      FROM    users_private_messages
                                      WHERE   users_private_messages.read_at                = 0
                                      AND     users_private_messages.hide_from_admin_mail   = 0
                                      AND     users_private_messages.deleted_by_recipient   = 0
                                      AND     users_private_messages.fk_users_recipient     = 0
                                              $admin_condition "));

  // Fetch the result for display
  $admin_mail_count     = $dpms['pm_nb'];
  $admin_mail_count_css = ($admin_mail_count && basename($_SERVER['PHP_SELF']) != 'inbox.php') ? ' header_submenu_blink' : '';
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

// If the current page is unnamed, simply call it NoBleme, else append NoBleme to it - or Devmode when in dev mode
$temp       = ($GLOBALS['dev_mode']) ? ' | Devmode' : ' | NoBleme';
$page_title = ($page_title) ? $page_title.$temp : 'NoBleme.com';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page description

// If there is no description, use a default generic one
$page_description = (isset($page_description)) ? $page_description : $page_title_en." - See more by visiting this page on NoBleme.com";

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
    <script src="'.$path.'js/common/header.js"> </script>
    <script src="'.$path.'js/common/fetch.js"> </script>';

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
    <meta name="twitter:image:alt" content="NoBleme.com - <?=$page_description?>">
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

  <?php if(!isset($hide_header)) { ?>

  <input id="root_path" type="hidden" class="hidden" value="<?=$path?>">

    <div id="popin_lost_access" class="popin_background">
      <div class="popin_body">
        <a class="popin_close" onclick="popin_close('popin_lost_access');">×</a>
        <h4>
          <?=__('users_lost_access_title')?>
        </h4>
        <p>
          <?=__('users_lost_access_body', 0, 0, 0, array($path))?>
        </p>
        <p>
          <?=__('users_lost_access_solution', 0, 0, 0, array($path))?>
        </p>
      </div>
    </div>


<?php ############################################# WEBSITE UPDATE ################################################# ?>

    <?php if($website_closed) { ?>

    <div class="header_infobar">
      <?=__link('pages/dev/close_website', __('website_closed'), 'header_infobar_link', 1, $path);?>
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

        <?php if(user_is_logged_in() && $private_message_count && basename($_SERVER['PHP_SELF']) != 'inbox.php') { ?>
        <img id="header_topmenu_account_icon" class="header_topmenu_icon header_topmenu_mail" src="<?=$path?>img/icons/login_mail.svg" alt="<?=string_change_case('account', 'initials');?>" title="<?=string_change_case('account', 'initials');?>" onclick="toggle_header_menu('account');">
        <?php } else { ?>
        <img id="header_topmenu_account_icon" class="header_topmenu_icon header_topmenu_account" src="<?=$path?>img/icons/login.svg" alt="<?=string_change_case('account', 'initials');?>" title="<?=string_change_case('account', 'initials');?>" onclick="toggle_header_menu('account');">
        <?php } ?>

        <?php if($is_moderator && $admin_mail_count && basename($_SERVER['PHP_SELF']) != 'inbox.php') { ?>
        <img id="header_topmenu_admin_icon" class="header_topmenu_icon header_topmenu_mail" src="<?=$path?>img/icons/login_mail.svg" alt="<?=string_change_case('administration', 'initials');?>" title="<?=string_change_case('administration', 'initials');?>" onclick="toggle_header_menu('admin');">
        <?php } else if($is_moderator) { ?>
        <img id="header_topmenu_admin_icon" class="header_topmenu_icon header_topmenu_panel" src="<?=$path?>img/icons/admin_panel.svg" alt="<?=string_change_case('administration', 'initials');?>" title="<?=string_change_case('administration', 'initials');?>" onclick="toggle_header_menu('admin');">
        <?php } ?>

        <a href="<?=$url_lang?>">
          <?php if($lang == 'FR') { ?>
          <img class="header_topmenu_icon header_topmenu_flag" src="<?=$path?>img/icons/lang_en.png" alt="EN" title="EN">
          <?php } else { ?>
          <img class="header_topmenu_icon header_topmenu_flag" src="<?=$path?>img/icons/lang_fr.png" alt="FR" title="FR">
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
          <?=__link('pages/doc/nobleme', __('submenu_nobleme_what_is'), 'header_submenu_link', 1, $path);?>
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
          <?=__link('pages/users/list', __('submenu_nobleme_userlist'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/users/admins', __('submenu_nobleme_staff'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_nobleme_dev')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/doc/dev', __('submenu_nobleme_behind_scenes'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/blog_list', __('submenu_nobleme_devblog'), 'header_submenu_link', 1, $path);?>
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
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_nobleme_support')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/doc/coc', __('submenu_nobleme_coc'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/doc/privacy', __('submenu_nobleme_privacy'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/doc/data', __('submenu_nobleme_personal_data'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/doc/legal', __('submenu_nobleme_legal'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/messages/admins', __('submenu_nobleme_contact_admin'), 'header_submenu_link', 1, $path);?>
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
          <?=__link('pages/politics/faq', __('submenu_pages_politics_join'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

    </div>


<?php ############################################## SUBMENU: SOCIAL ############################################## ?>

    <div class="header_submenu" id="header_submenu_social">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_social_platforms')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/social/irc', __('submenu_social_platforms_irc'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/social/irc?browser', __('submenu_social_platforms_irc_web'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/social/irc?channels', __('submenu_social_platforms_irc_chans'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/social/discord', __('submenu_social_platforms_discord'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/social/others', __('submenu_social_platforms_others'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_social_quotes')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/quotes/list', __('submenu_social_quotes_list'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/quotes/random', __('submenu_social_quotes_random'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/quotes/submit', __('submenu_social_quotes_submit'), 'header_submenu_link', 1, $path);?>
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
          <?=__link('todo_link', __('submenu_social_meetups_host'), 'header_submenu_link text_blue', 1, $path);?>
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
        <div class="header_submenu_item<?=$private_message_count_css?>">
          <?=__link('pages/messages/inbox', __('submenu_user_pms_inbox'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/messages/outbox', __('submenu_user_pms_outbox'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/messages/write', __('submenu_user_pms_write'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/messages/admins', __('submenu_nobleme_contact_admin'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_edit')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/account/settings_email', __('submenu_user_edit_email'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/account/settings_password', __('submenu_user_edit_password'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/messages/admins?username', __('submenu_user_edit_username'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/messages/admins?delete', __('submenu_user_edit_delete'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_settings')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/account/settings_privacy', __('submenu_user_settings_privacy'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/account/settings_nsfw', __('submenu_user_settings_nsfw'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_user_profile')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/users/profile', __('submenu_user_profile_self'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/users/profile_edit', __('submenu_user_profile_edit'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=sanitize_output(user_get_username())?>
        </div>
        <div class="header_submenu_item">
          <a class="header_submenu_link" href="<?=$url_logout?>"><?=__('submenu_user_logout_logout')?></a>
        </div>
      </div>

      <?php } else if(!$is_ip_banned) { ?>

      <div class="header_submenu_fullwidth">

        <div class="width_30 bigpadding_top hugepadding_bot">

        <h1 class="align_center padding_bot">
          <?=__('login_form_title')?>
        </h1>

        <h5 id="login_form_error" class="align_center bigpadding_bot padding_top underlined dowrap hidden">
          &nbsp;
        </h5>

        <form method="POST" name="login_form" onsubmit="user_login_attempt('<?=$path?>pages/account/login_attempt', <?=$GLOBALS['dev_mode']?>); return false;">
          <fieldset>

            <div class="smallpadding_bot">
              <label class="text_light" id="label_login_form_username" for="login_form_username"><?=string_change_case(__('username'), 'initials')?></label>
              <input id="login_form_username" name="login_form_username" class="indiv" type="text" value="">
            </div>

            <div class="padding_bot">
              <label class="text_light" id="label_login_form_password" for="login_form_password"><?=string_change_case(__('password'), 'initials')?> </label>
              <input id="login_form_password" name="login_form_password" class="indiv" type="password" value="">
            </div>

            <div class="desktop float_right">
              <input id="login_form_remember_desktop" name="login_form_remember_desktop" type="checkbox" checked>
              <label class="label_inline" for="login_form_remember_desktop"><?=__('login_form_form_remember')?></label>
            </div>

            <div class="mobile padding_bot">
              <input id="login_form_remember_mobile" name="login_form_remember_mobile" type="checkbox" checked>
              <label class="label_inline" for="login_form_remember_mobile"><?=__('login_form_form_remember')?></label>
            </div>

            <input type="submit" class="button_chain" value="<?=__('login_form_title')?>">

            <button type="button" onclick="window.location = '<?=$path?>pages/account/register';"><?=__('login_form_form_register')?></button>

          </fieldset>
        </form>

      </div>

      </div>

      <?php } else { ?>

      <div class="header_submenu_fullwidth dowrap text_light">

        <div class="width_30 bigpadding_top hugepadding_bot">

          <h1 class="align_center padding_bot">
            <?=__('users_ip_banned_title')?>
          </h1>

          <?=__('users_ip_banned_body')?>

        </div>

      </div>

      <?php } ?>

    </div>



<?php ############################################# SUBMENU: ADMIN ################################################# ?>

    <?php if($is_moderator) { ?>
    <div class="header_submenu" id="header_submenu_admin">

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_activity')?>
        </div>
        <div class="header_submenu_item<?=$admin_mail_count_css?>">
          <?=__link('pages/admin/inbox', __('submenu_admin_inbox'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/nobleme/activity?mod', __('submenu_admin_modlogs'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/users/admins', __('submenu_nobleme_staff'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_users')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/admin/ban', __('submenu_admin_ban'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/admin/user_rename', __('submenu_admin_username'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/admin/user_password', __('submenu_admin_password'), 'header_submenu_link', 1, $path);?>
        </div>
        <?php if($is_admin) { ?>
        <div class="header_submenu_item">
          <?=__link('pages/admin/user_rights', __('submenu_admin_rights'), 'header_submenu_link', 1, $path);?>
        </div>
        <?php } ?>
        <div class="header_submenu_item">
          <?=__link('pages/admin/user_deactivate', __('submenu_admin_deactivate'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/admin/stats_doppelganger', __('submenu_admin_doppelganger'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <?php if($is_admin) { ?>
      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_website')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/irc_bot', __('submenu_admin_ircbot'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/discord', __('submenu_admin_discord'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/close_website', __('submenu_admin_close'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/queries', __('submenu_admin_sql'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/versions', __('submenu_admin_versions'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/scheduler', __('submenu_admin_scheduler'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_stats')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/admin/stats_metrics', __('submenu_admin_metrics'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/admin/stats_views', __('submenu_admin_pageviews'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>

      <div class="header_submenu_column">
        <div class="header_submenu_title">
          <?=__('submenu_admin_doc')?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/doc_snippets', __('submenu_admin_doc_snippets'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/doc_css_palette', __('submenu_admin_doc_css'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/doc_js_toolbox', __('submenu_admin_doc_js'), 'header_submenu_link', 1, $path);?>
        </div>
        <div class="header_submenu_item">
          <?=__link('pages/dev/doc_functions', __('submenu_admin_doc_functions'), 'header_submenu_link', 1, $path);?>
        </div>
      </div>
      <?php } ?>

    </div>
    <?php } ?>

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