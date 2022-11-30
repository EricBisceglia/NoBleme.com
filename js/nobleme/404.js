/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                 Writes text in the textarea of the 404 error page                                 */
/*                                                                                                                   */
/*                            Original idea by ThArGos, thanks for the genius idea buddy!                            */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Prepare an array with the text of the 404 error
var text_404 = new Array("", "", "",
"In A.D. "+new Date().getFullYear(),
"User was browsing.", "", "", "",
"User: What happen?",
"Browser: Somebody set up us the error.",
"Website: We get signal.",
"User: What!!",
"Website: Main text box turn on.",
"User: It's you!!", "", "",
"404: How are you gentlemen!!",
"404: All your errors are belong to us.",
"404: You are on the way to being lost.",
"User: What you say!!",
"404: You have no chance to find your desired page make your time.",
"404: Ha ha ha ha...", "", "",
"Website: User!!",
"User: Take off every 'Zig'!!",
"User: You know what you doing.",
"User: Move 'Zig'.",
"User: For great justice.", "", "", "", "", "", "", "",
"Error 404: 'Zig' not found", "", "", "");

// Prepare some global variables to track the state of the text
var text_length       = text_404[0].length
var textarea_contents = '';
var cursor_position   = 0;
var cursor_row        = 0;
var current_row       = 0;


/**
 * Controls the text flow of the 404 error.
 *
 * This function should be called through onLoad on the 404 page.
 *
 * @returns {void}
 */

function this_page_is_a_404()
{
  // Reset the contents of the textarea
  textarea_contents = '';

  // Decide where the cursor should be
  current_row = Math.max(0, (cursor_row - 7));

  // Fetch the required line of text
  while(current_row < cursor_row)
    textarea_contents += text_404[current_row++] + '\r\n';

  // Print the text in the textarea, then position an underscore at the end to simulate a cursor
  document.getElementById('text404_desktop').value = textarea_contents + text_404[cursor_row].substring(0,cursor_position) + "_";
  document.getElementById('text404_mobile').value = textarea_contents + text_404[cursor_row].substring(0,cursor_position) + "_";

  // Check if we need to move to the next line
  if(cursor_position++ === text_length)
  {
    // If we do, reposition the cursor
    cursor_position=0;
    cursor_row++;

    // Check if the text is done being printed
    if(cursor_row !== text_404.length)
    {
      // If not, update the current position and run this function again after a small pause
      text_length = text_404[cursor_row].length;
      setTimeout("this_page_is_a_404()", 500);
    }
  }

  // Otherwise, simply print the next character by calling the function again asap
  else
    setTimeout("this_page_is_a_404()", 50);
}