<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  error_page          Throw an error page.                                                                         */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Throw an error page.
 *
 * The global error management function, use it when you need to abort the execution of the logic in a page.
 * Concludes with an exit(), thus nothing else can be ran after the error is thrown, the script just ends here.
 * Includes header.inc.php and footer.inc.php, so the contents of both will be ran - keep this in mind.
 * This obviously means that you should not run this function after the header has already been included.
 *
 * @param   string  $message  The error message that will be displayed (can include HTML).
 *
 * @return  void
 */

function error_page( string $message ) : void
{
  // Fetch the path to the website's root
  $path = root_path();

  // Fetch the user's language
  $lang = user_get_language();

  // Fetch the user's mode
  $mode = user_get_mode();

  // Is the user logged in and/or IP banned? - check from the session (required by the header)
  $is_logged_in = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;
  $is_ip_banned = user_is_ip_banned();

  // User permissions (required by the header)
  $is_moderator = user_is_moderator();
  $is_admin     = user_is_administrator();

  // Mock system variables that need to be there even in special circumstances
  $system_variables = array('website_is_closed' => system_variable_fetch('website_is_closed'));

  // Inform the header that an error is being thrown
  $error_mode = 1;

  // Page summary is required by the header too
  $page_lang        = array('FR', 'EN');
  $page_url         = "";
  $page_title_en    = "Error page";
  $page_title_fr    = "Page d'erreur";
  $page_description = "This is an error page. You will forget about this page's mere existence. Don't panic, the red flashing light is part of the process";

  // Include the required CSS
  $css = array('index');

  // Open the HTML part by including the header
  include_once $path."inc/header.inc.php";
  ?>

  <!-- Custom error message -->
  <div class="indiv align_center error_container">
    <h3 class="small_error_gap">
      <?=__('error_ohno');?>
    </h3>
    <h3 class="big_error_gap">
      <?=__('error_encountered');?>
    </h3>
    <h3>
      <?=$message?>
    </h3>
  </div>

  <?php
  // Close the HTML part by including the footer
  include_once $path."inc/footer.inc.php";

  // Throw an exit(); to ensure nothing else is ran after the error is displayed
  exit();
}