/**
 * Applies BBCodes to the selection.
 *
 * @param   {string}  target_element    The element in which BBCodes should be applied.
 * @param   {string}  bbcode            The type of BBCode to apply.
 * @param   {string}  [prompt_text]     The text to show in the prompt (related to the BBCode).
 * @param   {string}  [prompt_text_2]   The text to show in the second prompt (related to the BBCode).
 *
 * @returns {void}
 */

function editor_apply(  target_element          ,
                        bbcode                  ,
                        prompt_text     = null  ,
                        prompt_text_2   = null  )
{
  // Fetch the target element
  target_element = document.getElementById(target_element);

  // Determine where the cursor and/or selection currently are within the target element
	length    = target_element.value.length;
	start     = target_element.selectionStart;
  end       = target_element.selectionEnd;
  selection = target_element.value.substring(start, end);

  // Apply BBCode: bold
  if(bbcode == 'bold')
    replace = '[b]' + selection + '[/b]';

  // Apply BBCode: underlined
  else if(bbcode == 'underlined')
    replace = '[u]' + selection + '[/u]';

  // Apply BBcode: quote
  else if(bbcode == 'quote')
  {
    // Ask for the author and act accordingly
    author = prompt(prompt_text);
    if(author)
      replace = '[quote=' + author + ']' + selection + '[/quote]';
    else
      replace = '[quote]' + selection + '[/quote]';
  }

  // Apply BBcode: spoiler
  else if(bbcode == 'spoiler')
  {
    // Ask for the author and act accordingly
    author = prompt(prompt_text);
    if(author)
      replace = '[spoiler=' + author + ']' + selection + '[/spoiler]';
    else
      replace = '[spoiler]' + selection + '[/spoiler]';
  }

  // Apply BBcode: link
  else if(bbcode == 'link')
  {
    // Ask for the url and the text
    link = prompt(prompt_text);
    text = prompt(prompt_text_2);

    // If the url doesn't have a valid prefix, prepend https to it
    if(link)
    {
      if(link.substr(0, 'https://'.length) !== 'https://' && link.substr(0, 'http://'.length) !== 'http://')
        link = 'https://' + link;
    }

    // If no url was given, wrap the selected text with url tags
    if(!link)
      replace = '[url]' + selection + '[/url]';

    // Otherwise assemble the given link
    else if(!text)
      replace = selection + '[url=' + link + ']' + link + '[/url]';
    else
      replace = selection + '[url=' + link + ']' + text + '[/url]';
  }

  // Apply BBcode: image
  else if(bbcode == 'image')
  {
    // Ask for the url
    source = prompt(prompt_text);

    // If the url doesn't have a valid prefix, prepend https to it
    if(source)
    {
      if(source.substr(0, 'https://'.length) !== 'https://' && source.substr(0, 'http://'.length) !== 'http://')
      source = 'https://' + source;
    }

    // If an url was given, assemble the image
    if(source)
      replace = selection + '[img]' + source + '[/img]';

    // Otherwise wrap the selected text with img tags
    else
      replace = '[img]' + selection + '[/img]';
  }

  // Apply the BBCodes
  target_element.value = target_element.value.substring(0, start) + replace + target_element.value.substring(end, length);
}