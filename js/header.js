/*********************************************************************************************************************/
/*                                                                                                                   */
/*                            Functions required by the header menu on nearly every page                             */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Toggles the visibility of a top menu
 *
 * @param   {string}  menu_name       The name of the menu to show or hide.
 * @param   {string}  [invert_title]  If set, inverts the color scheme of the menu's title.
 *
 * @returns {void}
 */

function toggle_header_menu(  menu_name     ,
                              invert_title  )
{
  // Fetch the selected menu
  var selected_submenu = document.getElementById('header_submenu_' + menu_name);

  // Check the current visibility state of the menu
  var menu_visibility = selected_submenu.currentStyle ? selected_submenu.currentStyle.display : getComputedStyle(selected_submenu,null).display;

  // Fetch all submenus
  var all_submenus = document.getElementsByClassName('header_submenu');

  // Close all open submenus
  for(var i = 0; i < all_submenus.length; i++)
    all_submenus[i].style.display = 'none';

  // If the menu is invisible, open it
  if(menu_visibility == 'none')
    selected_submenu.style.display = 'grid';

  // Check whether this title's color scheme should be inverted
  invert_color_scheme = (typeof invert_title !== 'undefined' && !document.getElementById('header_menu_title_' + menu_name).classList.contains('header_topmenu_title_selected'));

  // Restore all inverted color schemes (if there are any)
  var inverted_schemes = document.getElementsByClassName('header_topmenu_title_selected');
  while (inverted_schemes.length)
    inverted_schemes[0].classList.remove('header_topmenu_title_selected');

  // If the title's color scheme should be inverted, do it
  if(invert_color_scheme)
    document.getElementById('header_menu_title_' + menu_name).classList.add('header_topmenu_title_selected');

  // If the annoying new notification animation is there, replace it with the standard user icon upon clicking
  if(menu_name == 'account')
  {
    var account_icon = document.getElementById('header_topmenu_account_icon');
    account_icon.setAttribute('src', account_icon.getAttribute('src').replace("login_mail.svg", "login.svg"));
  }
}




/**
 * Attempts to log in a guest.
 *
 * This function will check that the form values are properly filled in before sending the form through.
 * There is obviously also back end data validation, so this function is only front end sugar for the user experience.
 *
 * @param   {string}  login_path    The path to the login page.
 * @param   {bool}    [is_dev_mode] Whether the website is running in dev mode (in which case passwords can be null).
 *
 * @returns {void}
 */

function users_login_attempt( login_path  ,
                              is_dev_mode )
{
  // Ensure both nickname and password are filled in
  form_failed = (!form_require_field("login_form_nickname", "label_login_form_nickname")) ? 1 : 0;
  form_failed = (!is_dev_mode && !form_require_field("login_form_password", "label_login_form_password")) ? 1 : form_failed;

  // If both are ok, then fetch whether the login is valid - if it is, submit the form
  if(!form_failed)
  {
    // Prepare the postdata
    postdata  = 'login_form_nickname='  + fetch_sanitize_id('login_form_nickname');
    postdata += '&login_form_password=' + fetch_sanitize_id('login_form_password');
    postdata += '&login_form_remember=' + fetch_sanitize_id('login_form_remember');

    // Send the login attempt to the backend (it will handle the rest)
    fetch_page(login_path, 'login_form_error', postdata, users_login_attempt_process);
  }
}




/**
 * Process a finished login attempt.
 *
 * @returns {void}
 */

function users_login_attempt_process()
{
  // Fetch the current login status
  login_status = document.getElementById('login_form_error').innerHTML;

  // If the back says the user is logged in, redirect them to their inbox
  if(login_status == "OK")
  {
    root_path = document.getElementById('root_path').value;
    window.location = root_path + 'todo_link';
  }

  // If there is an error, display it
  else
    document.getElementById('login_form_error').style.display = 'block';
}




/**
 * Closes an open popin.
 *
 * @param   {string}  popin_id  The id of the popin.
 *
 * @returns {void}
 */

function popin_close(popin_id)
{
  // If the requested popin has been opened, close it and get rid of the hash in the url
  if(location.hash == popin_id || location.hash == '#'+popin_id)
  {
    location.hash = '#_';
    history.replaceState({}, document.title, window.location.href.split('#')[0]);
  }
}

// Close the lost account access popin if it is open
popin_close('popin_lost_access');