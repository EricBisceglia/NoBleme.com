/*********************************************************************************************************************/
/*                                                                                                                   */
/*  fetch_page              Fetches content dynamically.                                                             */
/*                                                                                                                   */
/*  fetch_sanitize          Sanitizes a string for use in postdata.                                                  */
/*  fetch_sanitize_id       Sanitizes an element for use in postdata.                                                */
/*                                                                                                                   */
/*  form_require_field      Ensures that a form element is properly filled.                                          */
/*                                                                                                                   */
/*********************************************************************************************************************/


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
 * Sanitizes a string for use in postdata.
 *
 * @param   {string}  data  The data to sanitize.
 *
 * @returns {string}        The sanitized string.
 */

function fetch_sanitize(data)
{
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
  if(document.getElementById(element))
    return encodeURIComponent(document.getElementById(element).value);
}




/**
 * Ensures that a form element is properly filled.
 *
 * @param   {string}  element_id  The ID of a form element that should not be empty.
 * @param   {string}  label_id    The ID of the label associated with said element.
 *
 * @example if(!form_require_field("my_field","my_field_label")) { return;}
 *
 * @returns {int}                 0 if the field is empty, 1 if the field is filled.
 */

function form_require_field(  element_id  ,
                              label_id    )
{
  // In case the field has already been rejected by this function before, reset the label to its default value
  if(label_id)
    document.getElementById(label_id).classList.remove('red');

  // Check whether the field is empty
  if(document.getElementById(element_id).value == "")
  {
    // If it is empty, change the styling of its associated label
    if(label_id)
      document.getElementById(label_id).classList.add('red');

    // Return 0 to show that it is not OK
    return 0;
  }

  // All's good, return 1
  else
    return 1;
}