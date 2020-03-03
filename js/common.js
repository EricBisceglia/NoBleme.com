/**
 * Toggles the side menu when the hamburger menu is pressed.
 *
 * @returns {void}
 */

 function toggle_sidemenu()
{
  // Fetch the side menu
  var sidemenu = document.getElementById("header_sidemenu");

  // If the sidemenu is visible, hide it slowly
  if (document.getElementsByClassName("header_sidemenu_hide").length == 0)
  {
    sidemenu.className = "header_sidemenu header_sidemenu_hide";
    setTimeout(function(){sidemenu.style.display = 'none';}, 500);
  }

  // If the sidemenu is hidden, show it
  else
  {
    sidemenu.className = "header_sidemenu header_sidemenu_show";
    sidemenu.style.display = 'block';
  }
}