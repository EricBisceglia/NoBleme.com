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

function editor_bold( target_element          ,
                      bbcode                  ,
                      prompt_text     = null  ,
                      prompt_text_2   = null  )
{
  // Fetch the target element
  target_element = document.getElementById(target_element);

  // Determine where the cursor is
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
    author = prompt(prompt_text);
    if(author)
      replace = '[quote=' + author + ']' + selection + '[/quote]';
    else
      replace = '[quote]' + selection + '[/quote]';
  }

  // Apply BBcode: spoiler
  else if(bbcode == 'spoiler')
  {
    author = prompt(prompt_text);
    if(author)
      replace = '[spoiler=' + author + ']' + selection + '[/spoiler]';
    else
      replace = '[spoiler]' + selection + '[/spoiler]';
  }

  // Apply BBcode: link
  else if(bbcode == 'link')
  {
    link = prompt(prompt_text);
    text = prompt(prompt_text_2);
    if(!link)
      replace = '[url]' + selection + '[/url]';
    else if(!text)
      replace = selection + '[url=' + link + ']' + link + '[/url]';
    else
      replace = selection + '[url=' + link + ']' + text + '[/url]';
  }

  // Apply BBcode: image
  else if(bbcode == 'image')
  {
    source = prompt(prompt_text);
    if(source)
      replace = selection + '[img]' + source + '[/img]';
    else
      replace = '[img]' + selection + '[/img]';
  }

  // Apply the BBCodes
  target_element.value = target_element.value.substring(0, start) + replace + target_element.value.substring(end, length);
}