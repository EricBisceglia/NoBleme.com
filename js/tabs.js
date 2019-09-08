/**
 * Opens a tab (not a browser tab, but within a tab list on the page).
 *
 * Requires the inclusion of 'tabs.css' to work properly.
 * All tab titles should have the CSS class 'tab_title'.
 * All tab bodies should have the CSS class 'tab_contents'.
 * All tab elements containing a scroll bar should have the CSS class 'tab_scrollbar'.
 * All tab titles should have the same id as their body plus '_title', eg. 'tab_sometab' and 'tab_sometab_title'.
 *
 *
 * @param   {string}  tab_event   The event that caused the opening of the tab (usually a click).
 * @param   {string}  tab_body_id The ID of the contents of the tab.
 *
 * @example tab_open(event, 'tab_body', 'tab_title');
 *
 * @returns {void}
 */

function tab_open(tab_event, tab_body_id)
{
  // Fetch all tab titles
  tab_title_list = document.getElementsByClassName("tab_contents");

  // Reset all tab titles to normal status
  for (i = 0; i < tab_title_list.length; i++) {
    tab_title_list[i].className = tab_title_list[i].className.replace(" active_tab", "");
  }

  // If the tab is blinking, remove the blink upon clicking on it
  document.getElementById(tab_body_id+'_title').classList.remove('tab_blink');

  // Give the active visuals to the current tab title
  tab_event.currentTarget.classList.add('active_tab');

  // Fetch all tab bodies
  tab_body_list = document.getElementsByClassName("tab_contents");

  // Hide all of the tab bodies
  for (i = 0; i < tab_contents.length; i++) {
    tab_body_list[i].style.display = "none";
  }

  // Un-hide the body of the tab that should be shown
  document.getElementById(tab_body_id).style.display = "block";

  // Fetch all elements with scrollbars
  tab_scrollbar_list = document.getElementsByClassName("tab_scrollbar");

  // Reset the scrollbar positions to the top
  for (i = 0; i < tab_scrollbar_list.length; i++) {
    tab_scrollbar_list[i].scrollTop = tab_scrollbar_list[i].scrollHeight;
  }
}