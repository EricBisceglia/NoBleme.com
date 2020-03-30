/**
 * Toggles the visibility of a top menu
 *
 * @param   {string}  menu_name       The name of the menu to show or hide.
 * @param   {string}  [invert_title]  If set, inverts the color scheme of the menu's title.
 *
 * @returns {void}
 */

function toggle_header_menu(menu_name, invert_title)
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
  var account_icon = document.getElementById('header_topmenu_account_icon');
   account_icon.setAttribute('src', account_icon.getAttribute('src').replace("login_mail.svg", "login.svg"));
}