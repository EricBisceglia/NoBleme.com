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

// If there are no header menu / header sidemenu variables, reset them to their default value
$header_menu      = (!isset($header_menu) || $header_menu == '') ? 'NoBleme' : $header_menu;
$header_sidemenu  = (!isset($header_sidemenu)) ? '' : $header_sidemenu;

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

<?php /* ############################################## TOP MENU ################### */ if(!isset($_GET["popup"])) { ?>

    <div class="header_topmenu<?=$website_update_css?>">

      <div id="header_titres" class="header_topmenu_zone">

        <a class="header_topmenu_link" href="<?=$path?>index">
          <div class="<?=header_menu_css('NoBleme',$header_menu,'top')?>">
            <?=__('menu_top_nobleme')?>
          </div>
        </a>

        <a class="header_topmenu_link" href="<?=$path?>index_temp_community">
          <div class="<?=header_menu_css('Community',$header_menu,'top')?>">
            <?=__('menu_top_community')?>
          </div>
        </a>

        <a class="header_topmenu_link" href="<?=$path?>index_temp_pages">
          <div class="<?=header_menu_css('Pages',$header_menu,'top')?>">
            <?=__('menu_top_pages')?>
          </div>
        </a>

        <?php if($is_global_moderator) { ?>
        <a class="header_topmenu_link" href="<?=$path?>pages/nobleme/activity?mod">
          <div class="<?=header_menu_css('Admin',$header_menu,'top')?>">
            <?=__('menu_top_admin')?>
          </div>
        </a>
        <?php } ?>

      </div>

      <div class="header_topmenu_zone header_topmenu_flag">

        <a href="<?=$url_lang?>">
          <?php if($lang == 'FR') { ?>
          <img class="header_topmenu_flagimg" src="<?=$path?>img/icons/lang_en.png" alt="EN">
          <?php } else { ?>
          <img class="header_topmenu_flagimg" src="<?=$path?>img/icons/lang_fr.png" alt="FR">
          <?php } ?>
        </a>

      </div>
    </div>

<?php ########################################### LOGIN / STATUS BAR ############################################### ?>

    <div id="statusbar_nomenu" class="header_infobar_standard header_infobar<?=$website_update_css2?>">

      <?php if(user_is_logged_in()) {
            if($nb_private_messages) { ?>

      <div class="header_topmenu_zone">
        <a id="header_infobar_notification" class="header_infobar_link header_infobar_notification" href="<?=$path?>index_temp_users">
          <?=__('header_status_message', $nb_private_messages, 0, 0, array(sanitize_output(user_get_nickname()), $nb_private_messages))?>
        </a>
      </div>

      <?php } else { ?>

      <div class="header_topmenu_zone">
        <a id="header_infobar_notification"  class="header_infobar_link" href="<?=$path?>index_temp_users">
          <?=__('header_status_logged_in', 0, 0, 0, array(sanitize_output(user_get_nickname())))?>
        </a>
      </div>

      <?php } ?>

      <div class="header_topmenu_zone">
        <a class="header_infobar_link" href="<?=$url_logout?>">
          <?=__('header_status_logout')?>
        </a>
      </div>

      <?php } else { ?>

      <div class="header_topmenu_zone">
        <a class="header_infobar_link" href="<?=$path?>pages/users/login">
          <?=__('header_status_login')?>
        </a>
      </div>

      <?php } ?>

    </div>

    <div id="statusbar_menu" class="header_infobar_responsive header_infobar<?=$website_update_css2?>">

      <?php if(user_is_logged_in()) {
            if($nb_private_messages) { ?>

      <div class="header_topmenu_zone">
        <a id="header_infobar_notification" class="header_infobar_link header_infobar_notification" href="<?=$path?>pages/users/notifications">
          <?=__('header_status_message_short', $nb_private_messages, 0, 0, array(sanitize_output(user_get_nickname()), $nb_private_messages))?>
        </a>
      </div>

      <?php } else { ?>

      <div class="header_topmenu_zone">
        <a id="header_infobar_notification"  class="header_infobar_link" href="<?=$path?>pages/users/notifications">
          <?=__('header_status_logged_in_short', 0, 0, 0, array(sanitize_output(user_get_nickname())))?>
        </a>
      </div>

      <?php } ?>

      <div class="header_topmenu_zone">
        <a class="header_infobar_link" href="<?=$url_logout?>">
          <?=__('header_status_logout')?>
        </a>
      </div>

      <?php } else { ?>

      <div class="header_topmenu_zone">
        <a class="header_infobar_link" href="<?=$path?>pages/users/login">
          <?=__('header_status_login_short')?>
        </a>
      </div>

      <?php } ?>

    </div>

<?php ################################################ SIDE MENU ################################################### ?>

    <div class="header_side_menu_container">

      <div class="header_side_nomenu" id="header_nomenu" onclick="document.getElementById('header_sidemenu').style.display = 'flex'; document.getElementById('header_nomenu').style.display = 'none';">
        <?=__('menu_side_display');?>
      </div>

      <nav id="header_sidemenu" class="header_sidemenu_mobile<?=$website_update_css2?>">
        <div class="header_sidemenu">
          <div>

            <div class="header_sidemenu_item header_sidemenu_desktop" onclick="document.getElementById('header_nomenu').style.display = 'flex'; document.getElementById('header_sidemenu').style.display = 'none';">
              <?=__('menu_side_hide')?>
            </div>

            <hr class="header_sidemenu_hr header_sidemenu_desktop">

<?php /* ######################################## SIDE MENU: NOBLEME ########### */ if ($header_menu == 'NoBleme') { ?>

            <div class="header_sidemenu_title">
              <?=__('nobleme.com')?>
            </div>

            <a href="<?=$path?>index">
              <div class="<?=header_menu_css('Homepage',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_homepage')?>
              </div>
            </a>

            <a href="<?=$path?>pages/nobleme/activity">
              <div class="<?=header_menu_css('Activity',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_activity')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_nobleme_documentation')?>
            </div>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Whatsnobleme',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_what_is')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('COC',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_coc')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('API',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_api')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('RSS',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_rss')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_nobleme_dev')?>
            </div>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Behindscenes',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_behind_scenes')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Devblog',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_devblog')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Todolist',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_todolist')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Roadmap',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_roadmap')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Bugreport',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_report_bug')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Featurerequest',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_feature')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_nobleme_legal')?>
            </div>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Forgetme',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_contact_admin')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Privacy',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_privacy')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Personaldata',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_personal_data')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_nobleme">
              <div class="text_grey_light <?=header_menu_css('Forgetme',$header_sidemenu,'side')?>">
                <?=__('menu_side_nobleme_forget_me')?>
              </div>
            </a>

<?php } /* ################################### SIDE MENU: COMMUNITY ##### */ else if ($header_menu == 'Community') { ?>

            <div class="header_sidemenu_title">
              <?=__('menu_side_community_irc')?>
            </div>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('IRC',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_irc_intro')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('IRCbrowser',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_irc_browser')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('IRCclient',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_irc_client')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('IRCchannels',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_irc_channels')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_community_users')?>
            </div>

            <a href="<?=$path?>pages/users/online">
              <div class="<?=header_menu_css('Online',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_online')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Userlist',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_userlist')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Staff',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_staff')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Birthdays',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_birthdays')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_community_meetups')?>
            </div>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Meetups',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_meetups_list')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_community_quotes')?>
            </div>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Quotes',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_quotes_list')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Quotesrandom',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_quotes_random')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Quotessubmit',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_quotes_submit')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_community_writers')?>
            </div>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Writers',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_writers_writings')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Writerspublish',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_writers_publish')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_community">
              <div class="text_grey_light <?=header_menu_css('Writerscontests',$header_sidemenu,'side')?>">
                <?=__('menu_side_community_writers_contests')?>
              </div>
            </a>

<?php } /* ######################################### SIDE MENU: PAGES ####### */ else if ($header_menu == 'Pages') { ?>

            <div class="header_sidemenu_title">
              <?php if(!$is_admin) { ?>
              <?=__('menu_side_pages_internet')?>
              <?php } else { ?>
              <a class="blank nohover text_black" href="<?=$path?>index_temp_pages">
                <?=__('menu_side_pages_internet')?>
                <img class="spaced_left valign_middle" src="<?=$path?>img/icons/settings.svg" alt="X" height="16">
              </a>
              <?php } ?>
            </div>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('Web',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_internet_index')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('Webpages',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_internet_pages')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('Webdict',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_internet_dictionary')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('Webculture',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_internet_culture')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('Webrandom',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_internet_random')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_pages_archives')?>
            </div>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('NBRPG',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_nbrpg')?>
              </div>
            </a>

            <?php if($lang == 'FR') { ?>
            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('NBRPGsessions',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_nbrpg_sessions')?>
              </div>
            </a>
            <?php } ?>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('NRM',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_nrm')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_pages">
              <div class="text_grey_light <?=header_menu_css('NRMchampions',$header_sidemenu,'side')?>">
                <?=__('menu_side_pages_nrm_champions')?>
              </div>
            </a>

<?php } /* ########################################## SIDE MENU: USER ######## */ else if ($header_menu == 'User') { ?>

            <div class="header_sidemenu_title">
              <?=__('menu_side_user_pms')?>
            </div>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('PMinbox',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_pms_inbox')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('PMoutbox',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_pms_outbox')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('PMwrite',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_pms_write')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_user_profile')?>
            </div>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Profile',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_profile_self')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Profileedit',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_profile_edit')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_user_settings')?>
            </div>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Settingsprivacy',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_settings_privacy')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Settingsnsfw',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_settings_nsfw')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Settingsemail',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_settings_email')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Settingspassword',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_settings_password')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Settingsnickname',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_settings_nickname')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_users">
              <div class="text_grey_light <?=header_menu_css('Settingsdelete',$header_sidemenu,'side')?>">
                <?=__('menu_side_user_settings_delete')?>
              </div>
            </a>

<?php } /* ######################################### SIDE MENU: ADMIN ####### */ else if ($header_menu == 'Admin') { ?>

            <div class="header_sidemenu_title">
              <?=__('menu_side_admin_activity')?>
            </div>

            <a href="<?=$path?>pages/nobleme/activity?mod">
              <div class="<?=header_menu_css('Modlogs',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_modlogs')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_admin_users')?>
            </div>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Nickname',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_nickname')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Password',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_password')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Banned',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_banned')?>
              </div>
            </a>

            <?php if($is_admin) { ?>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Rights',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_rights')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_admin_website')?>
            </div>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('IRCbot',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_ircbot')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Close',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_close')?>
              </div>
            </a>

            <a href="<?=$path?>pages/dev/queries">
              <div class="<?=header_menu_css('SQL',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_sql')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Release',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_release')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Scheduler',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_scheduler')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_admin_stats')?>
            </div>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Pageviews',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_pageviews')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('Doppelganger',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_doppelganger')?>
              </div>
            </a>

            <hr class="header_sidemenu_hr">

            <div class="header_sidemenu_title">
              <?=__('menu_side_admin_doc')?>
            </div>

            <a href="<?=$path?>pages/dev/snippets">
              <div class="<?=header_menu_css('Snippets',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_doc_snippets')?>
              </div>
            </a>

            <a href="<?=$path?>index_temp_admin">
              <div class="text_grey_light <?=header_menu_css('CSS',$header_sidemenu,'side')?>">
                <?=__('menu_side_admin_doc_css')?>
              </div>
            </a>

            <?php } ?>

            <?php } ?>

          </div>
        </div>
      </nav>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//                                             END HEADER AND BEGIN PAGE                                             //
//                                                                                                                   //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

    <div class="header_main_page_container header_main_page">

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