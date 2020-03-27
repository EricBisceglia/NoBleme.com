/**
 * Toggles the visibility of a top menu
 *
 * @param   {string}  menu_name The name of the menu to show or hide.
 *
 * @returns {void}
 */

function toggle_header_menu(menu_name)
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

  // If the annoying new notification animation is there, replace it with the standard user icon upon clicking
  var account_icon = document.getElementById('header_topmenu_account_icon');
   account_icon.setAttribute('src', account_icon.getAttribute('src').replace("login_mail.svg", "login.svg"));
}