<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Error management function, use it when you need to throw an error and abort everything else
// Includes the header and footer though, so the contents of both will be ran
// Concludes with an exit(), thus nothing can be ran after the error
//
// $message               is the error message that will be displayed (can include HTML)
// $path      (optional)  is the relative path to the index of the website (defaults to being 2 folders from the root)
// $lang      (optional)  is the currently used language (defaults to english if nothing is stored in the session)
// $menu_main (optional)  is the main header menu to be highlighted (defaults to the main section ('NoBleme'))
// $menu_side (optional)  is the side header menu to be highlighted (defaults to the home page ('Homepage'))
//
// Example usage
// error("Please do not access this page", $path, $lang, 'NoBleme', 'Homepage');

function error($message, $path = './../../', $lang = NULL, $menu_main = 'NoBleme', $menu_side = 'Homepage')
{
  // Is the user logged in? - check from the session (required by the header)
  $is_logged_in = (isset($_SESSION['user'])) ? $_SESSION['user'] : 0;

  // Does the user have special permissions? (required by the header)
  if(!$is_logged_in)
  {
    $is_admin             = 0;
    $is_global_moderator  = 0;
    $is_moderator         = 0;
  }
  else
  {
    $id_user = postdata($is_logged_in, 'int', 0);
    $ddroits = mysqli_fetch_array(query(" SELECT  users.is_administrator    AS 'm_admin'      ,
                                                  users.is_global_moderator AS 'm_globalmod'  ,
                                                  users.is_moderator        AS 'm_mod'
                                          FROM    users
                                          WHERE   users.id = '$id_user' "));
    $is_admin             = $ddroits['m_admin'];
    $is_global_moderator  = ($is_admin || $ddroits['m_globalmod']) ? 1 : 0;
    $is_moderator         = $ddroits['m_mod'];
  }

  // We also need to figure out the user's language - take it from the session if it is there (required by the header)
  $temp_lang  = (!isset($_SESSION['lang'])) ? 'EN' : $_SESSION['lang'];
  $lang       = ($lang) ? $lang : $temp_lang;

  // We must inform the header that this is an error being thrown
  $error_mode = 1;

  // Available languages, title, description, and internal page name are required by the header too
  $page_lang  = array('EN', 'FR');
  $page_title = ($lang == 'EN') ? "Error" : "Error";
  $page_desc  = ($lang == 'EN') ? "This is an error page. You will forget about this page's mere existence. Don't panic, the red flashing light is part of the process": "Ceci est une page d'erreur. Vous allez oublier l'existence de cette page. Ne paniquez pas, le flash rouge est normal.";
  $page_name = "Se prend une erreur";

  // Translations (multilingual content)
  $trad = array();
  $trad['ohno'] = ($lang == 'EN') ? "OH NO &nbsp;: (" : "OH NON &nbsp;: (";
  $trad['oops'] = ($lang == 'EN') ? "YOU HAVE ENCOUNTERED AN ERROR" : "VOUS AVEZ RENCONTRÉ UNE ERREUR";

  // We open the HTML by including the header
  include $path.'inc/header.inc.php';
  ?>

  <!-- Custom error message -->
  <div class="indiv align_center error_container">
    <h3 class="small_error_gap">
      <?=$trad['ohno']?>
    </h3>
    <h3 class="big_error_gap">
      <?=$trad['oops']?>
    </h3>
    <h3>
      <?=$message?>
    </h3>
  </div>

  <?php
  // We close the HTML by including the footer
  include $path.'inc/footer.inc.php';

  // Finally we exit out of here to make sure nothing else is ran afterwards
  exit ();
}