/**
 * Previews BBCodes in real time.
 *
 * @param   {string}  input         The element to be previewed.
 * @param   {string}  output        Where the preview should appear.
 * @param   {string}  [root_path]   The path to the root of the website.
 *
 * @returns {void}
 */

function preview_bbcodes( input                   ,
                          output                  ,
                          root_path = "./../../"  )
{
  // Assemble the postdata
  postdata = 'preview_element=' + fetch_sanitize_id(input);

  // Assemble the file path
  path = root_path + 'pages/common/preview_bbcodes';

  // Submit the preview
  fetch_page(path, output, postdata);
}