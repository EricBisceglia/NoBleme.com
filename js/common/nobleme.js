/*********************************************************************************************************************/
/*                                                                                                                   */
/*                Consider this a homebrew microframework... or maybe a nanoframework? Picoframework?                */
/*         It's all wrappers to handle some of the jank of vanilla JS. Not minified because I'm a dinosaur.          */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*  fetch_sanitize              Sanitizes a string for use in postdata.                                              */
/*  fetch_sanitize_id           Sanitizes an element for use in postdata.                                            */
/*  fetch_page                  Fetches content dynamically.                                                         */
/*                                                                                                                   */
/*  form_require_field          Ensures that a form element is properly filled.                                      */
/*                                                                                                                   */
/*  css_add                     Adds a CSS class to an element                                                       */
/*  css_remove                  Removes a CSS class from an element.                                                 */
/*                                                                                                                   */
/*  toggle_element              Toggles the visibility state of an element.                                          */
/*  toggle_class                Toggles the visibility state of all elements of a specific class.                    */
/*  toggle_element_oneway       Sets the visibility state of an element.                                             */
/*  toggle_class_oneway         Sets the visibility state of all elements of a specific class.                       */
/*  element_is_toggled          Checks whether an element is currently visible or not.                               */
/*                                                                                                                   */
/*  checkbox_toggle             Toggles the checked status of a checkbox.                                            */
/*  checkbox_toggle_oneway      Sets the checked status of a checkbox.                                               */
/*  checkbox_is_checked         Checks whether a checkbox is currently checked or unchecked.                         */
/*                                                                                                                   */
/*  to_clipboard                Places some data in the user's clipboard.                                            */
/*                                                                                                                   */
/*  unblur                      Removes the blur filter from an element being triggered by an action.                */
/*  unblur_element              Removes the blur filter from a specific element.                                     */
/*                                                                                                                   */
/*  popin_close                 Closes an open popin.                                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Sanitizes a string for use in postdata.
 *
 * @param   {string}  data  The data to sanitize.
 *
 * @returns {string}        The sanitized string.
 */

function fetch_sanitize(data)
{
  // Return sanitized data
  return encodeURIComponent(data);
}




/**
 * Sanitizes an element for use in postdata.
 *
 * @param   {string}  element The ID of the element to sanitize.
 *
 * @returns {string}          The sanitized string.
 */

function fetch_sanitize_id(element)
{
  // Attempt to identify the targetted element
  element_tag   = document.getElementById(element)?.tagName.toLowerCase();
  element_type  = document.getElementById(element)?.type.toLowerCase();

  // If the element is a checkbox, return 1 or 0
  if(element_tag == 'input' && (element_type == 'checkbox' || element_type == 'radio'))
    return (document.getElementById(element)?.checked) ? 1 : 0;

  // Otherwise, return the element's sanitized value
  return encodeURIComponent(document.getElementById(element)?.value);
}




/**
 * Fetches content dynamically.
 *
 * fetch_sanitize() and/or fetch_sanitize_id() should be used to sanitize the contents of the postdata.
 *
 * @param   {string}  target_page       The url of the page containing the content to be fetched.
 * @param   {string}  target_element    The element of the current page in which the target content will be fetched.
 * @param   {string}  [postdata]        This content will be passed to the target page as postdata.
 * @param   {string}  [callback]        Script element to call once the content has been fetched.
 * @param   {int}     [append_content]  Should the content be appended to the target element instead of replacing it.
 * @param   {string}  [path]            The path to the root of the website - only used if load bar should be shown.
 * @param   {int}     [show_load_bar]   If set, there will be a "loading" bar until the fetched content is loaded.
 *
 * @returns {void}
 */

function fetch_page(  target_page             ,
                      target_element          ,
                      postdata        = null  ,
                      callback        = null  ,
                      append_content  = null  ,
                      path            = null  ,
                      show_load_bar   = null  )
{
  // Check if the browser supports fetch
  if (window.fetch)
  {
    // Replace the target element with a load bar if necessary
    if(show_load_bar && !append_content)
      document.getElementById(target_element).innerHTML = '<div class="align_center intable">Loading...<br><img src="'+path+'img/common/loading.gif" alt="Loading..."></div>';

    // Fetch the desired page, include headers to show it's postdata, and put the postdata in the body
    fetch(target_page, {
      method: "POST",
      mode: 'same-origin',
      cache: 'default',
      credentials: 'same-origin',
      headers: new Headers(
      {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        'Fetched': 'yes'
      } ),
      body: postdata
    } )

    // Wait for the response
    .then(function(response)
    {
      // If all went according to plan, return the response's body
      if(response.ok)
        return response.text();

      // Otherwise log the incident in the console for debugging purposes
      console.log('ERROR: Status -> ' + response.status);
      console.log('ERROR: Status text -> ' + response.statusText);
    } )

    // Error handling
    .catch(function(error)
    {
      // Log the error in the console for debugging purposes
      console.log('ERROR: ' + error);
    } )

    // Wait for the data
    .then(function(returned_data)
    {
      // Replace the target element with the returned data
      if(!append_content)
        document.getElementById(target_element).innerHTML = returned_data;

      // Or append the returned data below the target element
      else
      {
        var append_div        = document.createElement("div");
        append_div.innerHTML  = returned_data;
        document.getElementById(target_element).appendChild(append_div);
      }

      // If no data was returned, point it out in the console for debugging purposes
      if(!returned_data)
        return console.log('INFO: No data returned.');
    } )

    // Wait for the data to entirely finish being fetched
    .then(response =>
    {
      // If a callback was requested, do it
      if(callback)
        callback()
    });
  }

  // If the browser doesn't support fetch, throw a really annoying error popup and be hated for life
  else
    alert('Your browser can not handle the JS fetch() element.\r\n\r\nPlease upgrade to a more recent browser or browser version.\r\n\r\nSorry for the inconvenience.');
}




/**
 * Ensures that a form element is properly filled.
 *
 * @param   {string}  element_id  The ID of a form element that should not be empty.
 * @param   {string}  label_id    The ID of the label associated with said element.
 *
 * @returns {int}                 0 if the field is empty, 1 if the field is filled.
 */

function form_require_field(  element_id  ,
                              label_id    )
{
  // In case the field has already been rejected by this function before, reset the label to its default value
  if(label_id)
    css_remove(label_id, 'red');

  // Check whether the field is empty
  if(document.getElementById(element_id).value == "")
  {
    // If it is empty, change the styling of its associated label and return 0
    if(label_id)
      css_add(label_id, 'red');
    return 0;
  }

  // Otherwise all's good, return 1
  else
    return 1;
}




/**
 * Adds a CSS class to an element.
 *
 * @param   {string}        element_id  The element's id.
 * @param   {string|array}  class_name  The CSS class to add to the element, can be an array of classes.
 *
 * @returns {void}
 */

function css_add( element_id  ,
                  class_name  )
{
  // If the provided class is singular, add it to the element
  if(!Array.isArray(class_name))
    document.getElementById(element_id)?.classList.add(class_name);

  // Otherwise add each class in the array to the element
  else
    class_name.forEach(class_add => document.getElementById(element_id)?.classList.add(class_add));
}




/**
 * Removes a CSS class from an element.
 *
 * @param   {string}        element_id  The element's id.
 * @param   {string|array}  class_name  The CSS class to remove from the element, can be an array of classes.
 *
 * @returns {void}
 */

 function css_remove( element_id  ,
                      class_name  )
{
  // If the provided class is singular, remove it from the element
  if(!Array.isArray(class_name))
    document.getElementById(element_id)?.classList.remove(class_name);

  // Otherwise remove each class in the array from the element
  else
    class_name.forEach(class_add => document.getElementById(element_id)?.classList.remove(class_add));
}




/**
 * Toggles the visibility state of an element.
 *
 * @param   {string}  element_id      The element whose visibility will be toggled.
 * @param   {string}  [element_type]  The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_element(  element_id              ,
                          element_type  = 'block' )
{
  // Fetch the selected element
  var selected_element = document.getElementById(element_id);

  // Stop here if does not exist
  if(!selected_element)
    return;

  // Check the current visibility state of the element
  var element_visibility = selected_element.currentStyle ? selected_element.currentStyle.display : getComputedStyle(selected_element,null).display;

  // Toggle it to the opposite visibility state
  if(element_visibility == 'none')
    selected_element.style.display = element_type;
  else
    selected_element.style.display = 'none';
}




/**
 * Toggles the visibility state of all elements of a specific class.
 *
 * @param   {string}  element_class   The class whose visibility will be toggled.
 * @param   {string}  [element_type]  The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_class(  element_class           ,
                        element_type  = 'block' )
{
  // Fetch all elements with the selected class
  var selected_class = document.getElementsByClassName(element_class);

  // Check the current visibility state of the first element of the class
  var first_element     = selected_class[0];
  var class_visibility  = first_element.currentStyle ? first_element.currentStyle.display : getComputedStyle(first_element,null).display;

  // Define the new visibility state to apply to the class
  var new_visibility_state = class_visibility == 'none' ? element_type : 'none';

  // Apply the changed visibility state to all elements of the class
  for(var i = 0; i < selected_class.length; i++)
    selected_class[i].style.display = new_visibility_state;
}




/**
 * Sets the visibility state of an element.
 *
 * @param   {string}  element_id            The element whose visibility will be toggled.
 * @param   {int}     will_be_made_visible  Whether the element will be hidden (0) or made visible (1).
 * @param   {string}  [element_type]        The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_element_oneway( element_id                      ,
                                will_be_made_visible            ,
                                element_type          = 'block' )
{
  // Fetch the selected element
  var selected_element = document.getElementById(element_id);

  // Stop here if it does not exist
  if(!selected_element)
    return;

  // Toggle the element's visibility in the requested way
  if(!will_be_made_visible)
    selected_element.style.display = 'none';
  else
    selected_element.style.display = element_type;
}




/**
 * Sets the visibility state of all elements of a specific class.
 *
 * @param   {string}  element_class         The class whose visibility will be toggled.
 * @param   {int}     will_be_made_visible  Whether the element will be hidden (0) or made visible (1).
 * @param   {string}  [element_type]        The type of element (block, table-row, grid, etc.), defaults to 'block'
 *
 * @returns {void}
 */

function toggle_class_oneway( element_class                   ,
                              will_be_made_visible            ,
                              element_type          = 'block' )
{
  // Fetch all elements with the selected class
  var selected_class = document.getElementsByClassName(element_class);

  // Define the visibility state to apply
  var visibility_state = (!will_be_made_visible) ? 'none' : element_type;

  // Apply the changed visibility state to all elements of the class
  for(var i = 0; i < selected_class.length; i++)
    selected_class[i].style.display = visibility_state;
}




/**
 * Checks whether an element is currently visible or not.
 *
 * @param   {string}  element_id  The element being checked.
 *
 * @return  {bool}                Whether the element is currently visible.
 */

function element_is_toggled( element_id )
{
  // Fetch the selected element
  var selected_element = document.getElementById(element_id);

  // Check the current visibility state of the element
  var element_visibility = selected_element.currentStyle ? selected_element.currentStyle.display : getComputedStyle(selected_element,null).display;

  // Return the appropriate value
  if(element_visibility == 'none')
    return false;
  else
    return true;
}




/**
 * Toggles the checked status of a checkbox.
 *
 * @param   {string}  checkbox_id   The checkbox which will get its status toggled.
 *
 * @returns {void}
 */

function checkbox_toggle( checkbox_id )
{
  // Swap the checked status if the checkbox exist
  if(document.getElementById(checkbox_id))
    document.getElementById(checkbox_id).click();
}




/**
 * Sets the checked status of a checkbox.
 *
 * @param   {string}  checkbox_id       The checkbox's id.
 * @param   {int}     will_be_checked   Whether the checkbox should be checked (1) or unchecked (0).
 *
 * @returns {void}
 */

function checkbox_toggle_oneway(  checkbox_id     ,
                                  will_be_checked )
{
  // Check or uncheck the checkbox
  if(will_be_checked)
    document.getElementById(checkbox_id).checked = true;
  else
    document.getElementById(checkbox_id).checked = false;
}




/**
 * Checks whether a checkbox is currently checked or unchecked.
 *
 * @param   {string}  checkbox_id   The checkbox in question.
 *
 * @return  {bool}                  Whether the checkbox is currently checked.
 */

function checkbox_is_checked( checkbox_id )
{
  // Return the appropriate value
  return (document.getElementById(checkbox_id)?.checked) ? true : false;
}




/**
 * Places some data in the user's clipboard.
 *
 * @param   {string}  contents            The contents that should be placed in the user's clipboard.
 * @param   {string}  [element_id]        If set, fetches the element's contents instead of the first argument.
 * @param   {bool}    [highlight_element] If set, highlights the element's contents after copying it to clipboard.
 *
 * @returns {void}
 */

function to_clipboard(  contents                  ,
                        element_id        = null  ,
                        highlight_element = null  )
{
  // If needed, fetch the element's contents
  if(element_id)
    contents = document.getElementById(element_id).innerHTML;

  // Replace any special characters with their real value
  contents = contents.replace(/&lt;/gi, "<");
  contents = contents.replace(/&gt;/gi, ">");
  contents = contents.replace(/&amp;/gi, "&");
  contents = contents.replace(/&times;/gi, "×");
  contents = contents.replace(/&nbsp;/gi, " ");
  contents = contents.replace(/<br>/gi, "");

  // Prepare a temporary textarea and place the contents in it
  var temparea    = document.createElement('textarea');
  temparea.value  = contents;

  // Place the textarea off screen and make it uneditable
  temparea.setAttribute('readonly', '');
  temparea.style = {position: 'absolute', left: '-9999px'};
  document.body.appendChild(temparea);

  // Move the textarea's contents into the clipboard (if the browser allows it…)
  temparea.select();
  document.execCommand('copy');

  // Delete the temporary textarea
  document.body.removeChild(temparea);

  // Highlight the element's contents if required
  if(highlight_element)
  {
    // Fetch the element
    contents = document.getElementById(element_id)

    // Wrap the browser's selection range around it
    var selection = document.createRange();
    selection.setStartBefore(contents);
    selection.setEndAfter(contents);
    window.getSelection().addRange(selection);
  }
}




/**
 * Removes the blur filter from an element being triggered by an action.
 *
 * @param   {string}  [target_id]   The action's target.
 *
 * @returns {void}
 */

function unblur(target_id)
{
  // Remove the blur filter
  target_id.classList.remove('blur');
  target_id.classList.remove('bigblur');
  target_id.classList.remove('nbcode_blur');
  target_id.classList.remove('nbcode_blur_2');
  target_id.classList.remove('nbcode_blur_3');
  target_id.classList.remove('compendium_image_blur');
}




/**
 * Removes the blur filter from a specific element.
 *
 * @param   {string}  [element_id]  Unblur the specific element.
 *
 * @returns {void}
 */

function unblur_element(element_id)
{
  // Remove the blur filter
  css_remove(element_id, ['blur', 'bigblur', 'nbcode_blur', 'nbcode_blur_2', 'nbcode_blur_3', 'compendium_image_blur']);
}




/**
 * Closes an open popin.
 *
 * @param   {string}  popin_id  The id of the popin, or * to close all open popins
 *
 * @returns {void}
 */

function popin_close(popin_id)
{
  // If the requested popin has been opened, close it
  if(location.hash == popin_id || location.hash == '#'+popin_id || popin_id == '*')
  {
    // Get rid of the hash in the URL
    location.hash = '#_';
    history.replaceState({}, document.title, window.location.href.split('#')[0]);

    // Scroll back to the top
    var popin_scroll = document.getElementsByClassName('popin_body');
    for(var i = 0; i < popin_scroll.length; i++)
      popin_scroll[i].scrollTop = 0;
  }
}


// Close all open popins upon pressing the escape key
document.addEventListener("keydown", ({key}) => {
  if (key === "Escape")
    popin_close('*');
})