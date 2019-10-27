/*********************************************************************************************************************/
/*                                                                                                                   */
/*                          Homemade XHR implementation to allow for dynamic page contents                           */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Reloads part of a page without reloading the whole page.
 *
 * Bit of a reinventing the wheel situation, I know, but this does the work just fine.
 * Besides, even without minifying, this is actually both lighter and faster than jquery.
 * xhr_sanitize() and/or xhr_sanitize_id() should be used to sanitize the contents of the postdata.
 *
 * @param   {string}  path            The path to the root of the website.
 * @param   {string}  target_page     The page that will be loaded inside the target element.
 * @param   {string}  target_element  The element of the page in which the target page will be loaded.
 * @param   {string}  postdata        Anything in here which will be passed to the target page as postdata.
 * @param   {int}     [no_load_bar]   If set, there will not be a "loading" bar until the XHR is loaded.
 * @param   {int}     [append]        If set, the content will be appended to the target element instead.
 *
 * @example xhr_load("<?=$path?>", "my_page.php", "my_value=" + xhr_sanitize_id("my_field") + "&other_value=0");
 *
 * @returns {void}
 */

function xhr_load(path, target_page, target_element , postdata, no_load_bar, append)
{
  // Replace the target element with a load bar if necessary
  if(typeof no_load_bar === 'undefined' && typeof append === 'undefined')
    document.getElementById(target_element).innerHTML = '<div class="align_center intable">Loading...<br><img src="'+path+'img/common/loading.gif" alt="Loading..."></div>';

  // Create the XHR (XMLHttpRequest) object
  var xhr;
  if(window.XMLHttpRequest)
    xhr = new XMLHttpRequest();

  // If the object hasn't been created (eg. dealing with IE8 or older), don't bother with the rest
  else
    return;

  // Open the XHR request to the target page
  xhr.open("POST", target_page, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
  xhr.setRequestHeader("XHR", "yup");
  xhr.send(postdata);

  // Wait for the target page to respond, call a different function depending on whether we are replacing or appending
  if(typeof append === 'undefined')
    xhr.onreadystatechange = xhr_return_data;
  else
    xhr.onreadystatechange = xhr_append_data;

  // Replace the data once the target page is done responding
  function xhr_return_data()
  {
    // Check if the operation is complete
    if(xhr.readyState === 4)
    {
      // If the target page loaded properly, replace the target element with the contents of target page
      if(xhr.status === 200)
        document.getElementById(target_element).innerHTML = xhr.responseText;

      // Replace the target element with an error if the target page replied an error code
      else
        document.getElementById(target_element).innerHTML = "XHR error: target page returned a " + xhr.status;
    }

    // Replace the target element with an error if the operation didn't fully complete
    else
      document.getElementById(target_element).innerHTML = "XHR state error: " + xhr.readyState;
  }

  // Append the data once the target page is done responding
  function xhr_append_data()
  {
    // Check if the operation is complete
    if(xhr.readyState === 4)
    {
      // If the target page loaded properly, append the contents of target page below the target element
      if(xhr.status === 200)
      {
        var div       = document.createElement("div");
        div.innerHTML = xhr.responseText;
        document.getElementById(target_element).appendChild(div);
      }

      // Append an error below the target element if the target page replied an error code
      else
      {
        var div       = document.createElement("div");
        div.innerHTML = "XHR error: target page returned a " + xhr.status;
        document.getElementById(target_element).appendChild(div);
      }
    }

    // Append an error below the target element if the operation didn't fully complete
    else
    {
      var div       = document.createElement("div");
      div.innerHTML = "XHR state error: " + xhr.readyState;
      document.getElementById(target_element).appendChild(div);
    }
  }
}




/**
 * Sanitizes a string for use within XHR.
 *
 * @param   {string}  data  The data to sanitize.
 *
 * @returns {string}        The sanitized string.
 */

function xhr_sanitize(data)
{
  // Let encodeURIComponent do the work
  return encodeURIComponent(data);
}




/**
 * Sanitizes an element for use within XHR.
 *
 * @param   {string}  element The ID of the element to sanitize.
 *
 * @returns {string}          The sanitized string.
 */

function xhr_sanitize_id(element)
{
  // Let encodeURIComponent do the work
  return encodeURIComponent(document.getElementById(element).value);
}




/**
 * Ensures that a form element is properly filled.
 *
 * @param   {string}  element_id  The ID of a form element that should not be empty.
 * @param   {string}  label_id    The ID of the label associated with said element.
 *
 * @example if(!xhr_require_field("my_field","my_field_label")) { return;}
 *
 * @returns {int}                 0 if the field is empty, 1 if the field is filled.
 */

function xhr_require_field(element_id, label_id)
{
  // In case the field has already been rejected by this function before, reset the label to its default value
  if(typeof(label_id) !== 'undefined')
  {
    document.getElementById(label_id).classList.remove('negative');
    document.getElementById(label_id).classList.remove('text_white');
  }

  // Check whether the field is empty
  if(document.getElementById(element_id).value == "")
  {
    // If it is empty, change the styling of its associated label
    if(typeof(label_id) !== 'undefined')
    {
      document.getElementById(label_id).classList.add('negative');
      document.getElementById(label_id).classList.add('text_white');
    }

    // Return 0 to show that it is not OK
    return 0;
  }

  // All's good, return 1
  else
    return 1;
}