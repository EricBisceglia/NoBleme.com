<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }




/**
 * Throw an error page.
 *
 * The global error management function, use it when you need to abort the execution of the logic in a page.
 * Concludes with an exit(), thus nothing else can be ran after the error is thrown, the script just ends here.
 * Includes header.inc.php and footer.inc.php, so the contents of both will be ran - keep this in mind.
 * This obviously means that you should not run this function after the header has already been included.
 *
 * @example error_page("You must be logged in to access this page.", $path, $lang, "NoBleme", "Homepage");
 *
 * @param   string  $message                The error message that will be displayed (can include HTML).
 * @param   string  $path       (OPTIONAL)  The relative path to the root of the website (defaults to 2 folders away).
 * @param   string  $lang       (OPTIONAL)  The current language (defaults to session stored value, or to english).
 * @param   string  $menu_main  (OPTIONAL)  The main header menu to be highlighted (defaults to 'NoBleme').
 * @param   string  $menu_side  (OPTIONAL)  The side header menu to be highlighted (defaults to 'Homepage').
 *
 * @return  void
 */

function error_page($message, $path="./../../", $lang=NULL, $menu_main="NoBleme", $menu_side="Homepage")
{
  // Is the user logged in? - check from the session (required by the header)
  $is_logged_in = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;

  // Does the user have special permissions? (required by the header)
  if(!$is_logged_in)
  {
    // By default we assume he does not
    $is_admin             = 0;
    $is_global_moderator  = 0;
    $is_moderator         = 0;
  }
  else
  {
    // Let's sanitize the user id, just in case
    $id_user = sanitize($is_logged_in, 'int', 0);

    // Now we can go look for his user rights
    $drights = mysqli_fetch_array(query(" SELECT  users.is_administrator    AS 'm_admin'      ,
                                                  users.is_global_moderator AS 'm_globalmod'  ,
                                                  users.is_moderator        AS 'm_mod'
                                          FROM    users
                                          WHERE   users.id = '$id_user' "));

    // And we can set them as variables, which the header will use
    $is_admin             = $drights['m_admin'];
    $is_global_moderator  = ($is_admin || $drights['m_globalmod']) ? 1 : 0;
    $is_moderator         = $drights['m_mod'];
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

  // Translation of the text strings before display (bilingual content)
  $text = array();
  $text['ohno'] = ($lang == 'EN') ? "OH NO &nbsp;: (" : "OH NON &nbsp;: (";
  $text['oops'] = ($lang == 'EN') ? "YOU HAVE ENCOUNTERED AN ERROR" : "VOUS AVEZ RENCONTRÉ UNE ERREUR";

  // We open the HTML part by including the header
  include_once $path."inc/header.inc.php";
  ?>

  <!-- Custom error message -->
  <div class="indiv align_center error_container">
    <h3 class="small_error_gap">
      <?=$text['ohno']?>
    </h3>
    <h3 class="big_error_gap">
      <?=$text['oops']?>
    </h3>
    <h3>
      <?=$message?>
    </h3>
  </div>

  <?php
  // We close the HTML part by including the footer
  include_once $path."inc/footer.inc.php";

  // Finally we exit out of here to make sure nothing else is ran afterwards
  exit ();
}