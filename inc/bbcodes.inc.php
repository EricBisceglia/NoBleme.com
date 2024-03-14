<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  bbcodes               Turns BBCodes into HTML.                                                                   */
/*  bbcodes_remove        Removes all BBCode formatting from a text.                                                 */
/*                                                                                                                   */
/*  nbcodes               Turns more BBCodes into HTML, for administrator usage only.                                */
/*  nbcodes_remove        Removes all NBCode formatting from a text.                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Turns BBCodes into HTML.
 *
 * Yeah, let's say things how they are, BBCodes are bad and risky.
 * But I felt like I needed some way to let users make posts more interesting, and markdown has its limitations.
 * I went with the usual oldschool risky way and reimplemented BBCodes. Peace be upon my poor foolish soul.
 * This implementation nicely detects unclosed tags and closes them for you. I'm just cool like that.
 * Some CSS is involved, so make sure nobleme.css is included in your page when using BBCodes.
 *
 * @param   string  $text   The text which contains BBCodes.
 *
 * @return  string          The text, with BBCodes converted to HTML, ready for display.
 */

function bbcodes( string  $text ) : string
{
  /*******************************************************************************************************************/
  // [b]Bold[/b]

  // Replace tags with HTML
  $text = str_replace("[b]", "<span class=\"bold\">", $text, $open);
  $text = str_replace("[/b]", "</span>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $text.="</span>";
  }


  /*******************************************************************************************************************/
  // [i]Italics[/i]

  // Replace tags with HTML
  $text = str_replace("[i]", "<span class=\"italics\">", $text, $open);
  $text = str_replace("[/i]", "</span>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $text.="</span>";
  }


  /*******************************************************************************************************************/
  // [u]Underline[/u]

  // Replace tags with HTML
  $text = str_replace("[u]", "<span class=\"underlined\">", $text, $open);
  $text = str_replace("[/u]", "</span>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $text.="</span>";
  }


  /*******************************************************************************************************************/
  // [s]Strikethrough[/s]

  // Replace tags with HTML
  $text = str_replace("[s]", "<span class=\"strikethrough\">", $text, $open);
  $text = str_replace("[/s]", "</span>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $text.="</span>";
  }


  /*******************************************************************************************************************/
  // [ins]Insert[/ins] (for use in diffs)

  // Replace tags with HTML
  $text = str_replace("[ins]", "<ins>", $text, $open);
  $text = str_replace("[/ins]", "</ins>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $text.="</ins>";
  }


  /*******************************************************************************************************************/
  // [del]Delete[/del] (for use in diffs)

  // Replace tags with HTML
  $text = str_replace("[del]", "<del>", $text, $open);
  $text = str_replace("[/del]", "</del>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $text.="</del>";
  }

  /*******************************************************************************************************************/
  // [url=http://www.example.com]Link[/url]

  // Solved with a regex
  $text = preg_replace('/\[url\](.*?)\[\/url\]/is','<a class="bold" href="$1">$1</a>', $text);

  // Same thing but with a parameter for the url
  $text = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','<a class="bold" href="$1">$2</a>', $text);


  /*******************************************************************************************************************/
  // [img]http://www.example.com/image.jpg[/img]

  // Solved with a regex
  $text = preg_replace('/\[img\](.*?)\[\/img\]/is','<img src="$1" alt="">', $text);


  /*******************************************************************************************************************/
  // [align=left/center/right]Text alignment[/align]

  // Solved with a regex
  $text = preg_replace('/\[align\=(left|center|right)\](.*?)\[\/align\]/is','<div class="align_$1">$2</div>', $text);


  /*******************************************************************************************************************/
  // [color=#CACACA]Colored text[/color]

  // Solved with a regex
  $text = preg_replace('/\[color\=(.*?)\](.*?)\[\/color\]/is','<span style="color: $1;">$2</span>', $text);


  /*******************************************************************************************************************/
  // [size=2]Text size[/size]

  // Solved with a regex
  $text = preg_replace('/\[size\=(.*?)\](.*?)\[\/size\]/is','<span style="font-size: $1em;">$2</span>', $text);


  /*******************************************************************************************************************/
  // [code]Code block[/code]

  // Solved with a regex
  $text = preg_replace('/\[code\](.*?)\[\/code\]/is','<div class="tinypadding_top"><pre>$1</pre></div>', $text);


  /*******************************************************************************************************************/
  // [quote]Quoted text[/quote]

  // Solved with a regex in a while loop
  while(preg_match('/\[quote\](.*?)\[\/quote\]/is',$text))
    $text = preg_replace('/\[quote\](.*?)\[\/quote\]/is',"<div class=\"tinypadding_top\"><div class=\"bbcode_quote_body\"><div class=\"bbcode_quote_title\">".__('bbcodes_quote')."</div><hr class=\"bbcode_quote_separator\">$1</div></div>", $text);

  // Same thing but with a parameter specifying the author
  while(preg_match('/\[quote=(.*?)\](.*?)\[\/quote\]/is',$text))
    $text = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is',"<div class=\"tinypadding_top\"><div class=\"bbcode_quote_body\"><div class=\"bbcode_quote_title\">".__('bbcodes_quote_by')." $1".__(':')."</div><hr class=\"bbcode_quote_separator\">$2</div></div>", $text);


  /*******************************************************************************************************************/
  // [spoiler]Hidden content[/spoiler]

  // Solved with a regex in a while loop - seems complicated, but it's just because we're applying a lot of js here
  while(preg_match('/\[spoiler\](.*?)\[\/spoiler\]/is',$text))
    $text = preg_replace("/\[spoiler\](.*?)\[\/spoiler\]/is", "<div class=\"tinypadding_top\"><div class=\"bbcode_spoiler_body\"><div class=\"bbcode_spoiler_title bold\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '".__('bbcodes_spoiler')." : <a class=\'bold\' href=\'#\' onclick=\'return false;\'>".__('bbcodes_spoiler_hide')."</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '".__('bbcodes_spoiler').__(':')." <a href=\'#\' class=\'bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_show')."</a>'; }\">".__('bbcodes_spoiler').__(':')." <a href=\"#\" class=\"bold\" onclick=\"return false;\">".__('bbcodes_spoiler_show')."</a></span></div><div><div style=\"display: none;\"><hr class=\"bbcode_spoiler_separator\">$1</div></div></div></div>", $text);

  // Same thing but with a parameter describing the spoiler's contents
  while(preg_match('/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is',$text))
    $text = preg_replace_callback("/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is", function ($matches) { $title = htmlentities($matches[1]); return "<div class=\"tinypadding_top\"><div class=\"bbcode_spoiler_body\"><div class=\"bbcode_spoiler_title bold\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '".$title.__(':')." <a href=\'#\' class=\'bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_hide')."</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '".$title.__(':')." <a href=\'#\' class=\'bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_show')."</a>'; }\">".$matches[1].__(':')." <a href=\"#\" class=\"bold\" onclick=\"return false;\">".__('bbcodes_spoiler_show')."</a></span></div><div><div style=\"display: none;\"><hr class=\"bbcode_spoiler_separator\">".$matches[2]."</div></div></div></div>"; },  $text);


  /*******************************************************************************************************************/
  // [blur]Blurry content[/blur]

  // Solved with a regex
  $text = preg_replace('/\[blur\](.*?)\[\/blur\]/is','<span class="blur" onmouseover="unblur(this);">$1</span>', $text);


  /*******************************************************************************************************************/
  // [space] Yeah this literally just adds some unbreakable spaces, then a breakable one to avoid overflow

  // Solved with a regex
  $text = preg_replace('/\[space\]/is','      ', $text);


  /*******************************************************************************************************************/
  // [line] Horizontal separator

  // Solved with a regex
  $text = preg_replace('/\[line\]/is','<hr class="bbcode_line">', $text);


  /*******************************************************************************************************************/
  // All BBCodes have been treated

  // Return the data
  return $text;
}




/**
 * Removes all BBCode formatting from a text.
 *
 * @param   string  $text   The text which will be stripped of BBCodes.
 *
 * @return  string          The text, with BBCodes stripped.
 */

function bbcodes_remove( string  $text ) : string
{
  // Remove bold
  $text = str_replace("[b]", "", $text, $open);
  $text = str_replace("[/b]", "", $text, $open);

  // Remove italics
  $text = str_replace("[i]", "", $text, $open);
  $text = str_replace("[/i]", "", $text, $open);

  // Remove underline
  $text = str_replace("[u]", "", $text, $open);
  $text = str_replace("[/u]", "", $text, $open);

  // Remove strikethrough
  $text = str_replace("[s]", "", $text, $open);
  $text = str_replace("[/s]", "", $text, $open);

  // Remove insert
  $text = str_replace("[ins]", "", $text, $open);
  $text = str_replace("[/ins]", "", $text, $open);

  // Remove delete
  $text = str_replace("[del]", "", $text, $open);
  $text = str_replace("[/del]", "", $text, $open);

  // Remove links
  $text = preg_replace('/\[url\](.*?)\[\/url\]/is','$1', $text);
  $text = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','$2', $text);

  // Remove images
  $text = preg_replace('/\[img\](.*?)\[\/img\]/is','$1', $text);

  // Remove alignment
  $text = preg_replace('/\[align\=(left|center|right)\](.*?)\[\/align\]/is','$2', $text);

  // Remove color
  $text = preg_replace('/\[color\=(.*?)\](.*?)\[\/color\]/is','$2', $text);

  // Remove size
  $text = preg_replace('/\[size\=(.*?)\](.*?)\[\/size\]/is','$2', $text);

  // Remove code blocks
  $text = str_replace("[code]", "", $text, $open);
  $text = str_replace("[/code]", "", $text, $open);

  // Remove quotes
  while(preg_match('/\[quote\](.*?)\[\/quote\]/is',$text))
    $text = preg_replace('/\[quote\](.*?)\[\/quote\]/is',"$1", $text);
  while(preg_match('/\[quote=(.*?)\](.*?)\[\/quote\]/is',$text))
    $text = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is',"$1".__(':')." $2", $text);

  // Remove spoilers
  while(preg_match('/\[spoiler\](.*?)\[\/spoiler\]/is',$text))
    $text = preg_replace("/\[spoiler\](.*?)\[\/spoiler\]/is", "$1", $text);
  while(preg_match('/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is',$text))
    $text = preg_replace_callback("/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is", function ($matches) { $title = htmlentities($matches[1]); return $matches[2]; },  $text);

  // Remove blur
  $text = str_replace("[blur]", "", $text, $open);
  $text = str_replace("[/blur]", "", $text, $open);

  // Remove spaces
  $text = preg_replace('/\[space\]/is','      ', $text);

  // Remove lines
  $text = preg_replace('/\[line\]/is', PHP_EOL.'----------'.PHP_EOL, $text);

  // Return the data
  return $text;
}




/**
 * Turns more BBCodes into HTML, for administrator usage only.
 *
 * I chose to use BBCodes for the encyclopedia of internet culture instead of some other wiki-like syntax.
 * To this end, I needed acces sto more BBCodes, which users will not be allowed to use on the rest of the website.
 * Basically these are only for administrators, so there's not too much worries to be had about user input.
 *
 * @param   string  $text                       The text which contains BBCodes.
 * @param   array   $page_list      (OPTIONAL)  Output of compendium_pages_list_urls() (all existing eligible urls).
 * @param   array   $privacy_level  (OPTIONAL)  The output of user_settings_privacy() (third party settings).
 * @param   int     $nsfw_settings  (OPTIONAL)  The optuput of user_settings_nsfw() (profanity/nudity filter).
 * @param   string  $mode           (OPTIONAL)  The output of user_get_mode() (whether a light/dark theme is in use).
 *
 * @return  string                              The text, with NBCodes converted to HTML, ready for display.
 */

function nbcodes( string  $text                                                   ,
                  array   $page_list      = array()                               ,
                  array   $privacy_level  = array('youtube' => 0, 'trends' => 0)  ,
                  int     $nsfw_settings  = 0                                     ,
                  string  $mode           = 'dark'                                ) : string
{
  /*******************************************************************************************************************/
  // Run bbcodes on the data
  $text = bbcodes($text, $privacy_level);


  /*******************************************************************************************************************/
  // Fetch the path to the website's root
  $path = root_path();


  /*******************************************************************************************************************/
  // Prepare blurring based on NSFW filter settings

  $blurring   = ($nsfw_settings < 2) ? 'class="nbcode_blur"' : '';
  $blurring2  = ($nsfw_settings < 2) ? 'class="nbcode_blur_2"' : '';
  $blurring2b = ($nsfw_settings < 2) ? ' nbcode_blur_2' : '';
  $blurring3  = ($nsfw_settings < 1) ? ' nbcode_blur_3' : '';
  $blurring4  = ($nsfw_settings < 1) ? ' class="nbcode_blur_3"' : '';
  $unblur     = ($nsfw_settings < 2) ? ' onmouseover="unblur(this);"' : '';


  /*******************************************************************************************************************/
  // Prepare the correct path for icons
  $mode = ($mode === 'dark') ? '' : '_dark';


  /*******************************************************************************************************************/
  // === anchor:id|Subtitle ===

  // Handle this with a regex
  $text = preg_replace('/\=\=\=\ anchor:(.*?)\|(.*?)\ \=\=\=/is','<span id="$1">&nbsp;</span><h5 class="pointer" onclick="document.location=\'#$1\';">$2</h5>', $text);


  /*******************************************************************************************************************/
  // === Subtitle ===

  // Initialize the tag counter
  $i = 0;

  // Handle this with a regex
  $text = preg_replace_callback('/\=\=\=\ (.*?)\ \=\=\=/is', function($m) use(&$i) {$i++; return '<h5 class="pointer" id="subsection'.$i.'" onclick="document.location=\'#subsection'.$i.'\';">'.$m[1].'</h5>';}, $text);


  /*******************************************************************************************************************/
  // == anchor:id|Title ==

  // Handle this with a regex
  $text = preg_replace('/\=\=\ anchor:(.*?)\|(.*?)\ \=\=/is','<span id="$1">&nbsp;</span><h4 class="pointer" onclick="document.location=\'#$1\';">$2</h4>', $text);


  /*******************************************************************************************************************/
  // == Title == (must parse after subtitles or it won't work)

  // Initialize the tag counter
  $i = 0;

  // Handle this with a regex
  $text = preg_replace_callback('/\=\=\ (.*?)\ \=\=/is', function($m) use(&$i) {$i++; return '<h4 class="pointer" id="section'.$i.'" onclick="document.location=\'#section'.$i.'\';">'.$m[1].'</h4>';}, $text);


  /*******************************************************************************************************************/
  // [nsfw]Blurred text[/nsfw]

  // Replace tags with HTML
  $text = str_replace("[nsfw]", "<span".$blurring4.$unblur.">", $text, $open);
  $text = str_replace("[/nsfw]", "</span>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i = 0; $i < ($open - $close); $i++)
      $text.="</span>";
  }


  /*******************************************************************************************************************/
  // [page:compendium_url|page name]

  // Fetch all the matching tags
  preg_match_all('/\[page:(.*?)\|(.*?)\]/', $text, $results);

  // We'll need to parse each of them individually
  $i = 0;
  foreach($results[0] as $pattern)
  {
    // Assemble the link
    $link = rawurlencode(str_replace(' ', '_', $results[1][$i]));

    // If the page exists within the compendium, make it a proper link
    if(in_array(string_change_case(html_entity_decode(str_replace(' ', '_', $results[1][$i]), ENT_QUOTES), 'lowercase'), $page_list))
      $text = str_replace($pattern, '<a href="'.$path.'pages/compendium/'.$link.'">'.$results[2][$i].'</a>', $text);

    // Otherwise, make it a dead link
    else
      $text = str_replace($pattern, '<a class="nbcode_dead_link noglow" href="'.$path.'pages/compendium/'.$link.'">'.$results[2][$i].'</a>', $text);

    // Don't forget to increment the result being treated between each iteration of the loop
    $i++;
  }


  /*******************************************************************************************************************/
  // [link:https://example.com|page name]

  // Handle this with a regex
  $text = preg_replace('/\[link:(.*?)\|(.*?)\]/i','<a href="$1" rel="noopener noreferrer" target="_blank">$2<img src="'.$path.'img/icons/link_external'.$mode.'.svg" alt=" " class="smallicon nbcode_link_icon"></a>', $text);


  /*******************************************************************************************************************/
  // [nobleme:pages/compendium/index|internal link name]

  // Handle this with a regex
  $text = preg_replace('/\[nobleme:(.*?)\|(.*?)\]/i','<a href="'.$path.'$1">$2</a>', $text);


  /*******************************************************************************************************************/
  // [anchor:id]

  // Handle this with a regex
  $text = preg_replace('/\[anchor:(.*?)\]/i','<span id="$1">&nbsp;</span>', $text);


  /*******************************************************************************************************************/
  // [menu][/menu]

  // Handle this with a regex
  $text = preg_replace('/\[menu\](.*?)\[\/menu\]/is','<h4>'.__('nbcodes_menu_contents').'</h4>$1', $text);


  /*******************************************************************************************************************/
  // [menuitem:link|text]

  // Handle this with a regex
  $text = preg_replace('/\[menuitem:(.*?)\|(.*?)\]/i','<span class="nbcode_menu_bull">&bull;</span> <a class="nbcode_menu_link" href="#$1">$2</a>', $text);


  /*******************************************************************************************************************/
  // [submenuitem:link|text]

  // Handle this with a regex
  $text = preg_replace('/\[submenuitem:(.*?)\|(.*?)\]/i','<span class="nbcode_menu_bull indented">&bull;</span> <a class="nbcode_menu_link" href="#$1">$2</a>', $text);


  /*******************************************************************************************************************/
  // [bulletlist][/bulletlist]

  // Fetch all the matching tags
  preg_match_all('/\[bulletlist\](.*?)\[\/bulletlist\]/is', $text, $results);

  // We'll need to parse each of them individually
  $i = 0;
  foreach($results[0] as $pattern)
  {
    // Remove any line breaks within the bullet list
    $bulletlist = str_replace(PHP_EOL, '', $results[1][$i]);
    $bulletlist = str_replace('<br />', '', $bulletlist);
    $bulletlist = str_replace('<br>', '', $bulletlist);

    // Replace the tags with HTML
    $text = str_replace($pattern, '<ul>'.$bulletlist.'</ul>', $text);

    // Don't forget to increment the result being treated between each iteration of the loop
    $i++;
  }


  /*******************************************************************************************************************/
  // [bullet]Bullet point[/bullet]

  // Replace tags with HTML
  $text = str_replace("[bullet]", "<li>", $text, $open);
  $text = str_replace("[/bullet]", "</li>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i = 0; $i < ($open - $close); $i++)
      $text.="</li>";
  }


  /*******************************************************************************************************************/
  // [subbulletlist][/subbulletlist]

  // Replace tags with HTML
  $text = str_replace("[subbulletlist]", "<ul>", $text, $open);
  $text = str_replace("[/subbulletlist]", "</ul>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i = 0; $i < ($open - $close); $i++)
      $text.="</ul>";
  }


  /*******************************************************************************************************************/
  // [subbullet]Sub bullet point[/subbullet]

  // Replace tags with HTML
  $text = str_replace("[subbullet]", "<li>", $text, $open);
  $text = str_replace("[/subbullet]", "</li>", $text, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i = 0; $i < ($open - $close); $i++)
      $text.="</li>";
  }


  /*******************************************************************************************************************/
  // [image:image.png|left|description of the image]

  // Handle this with a regex
  $text = preg_replace('/\[image:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img src="'.$path.'img/compendium/$1" alt="$1"></a><br>$3</div>', $text);

  // Same thing if the image has no description
  $text = preg_replace('/\[image:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img src="'.$path.'img/compendium/$1" alt="$1"></a></div>', $text);

  // Same thing if the images has no description or alignment
  $text = preg_replace('/\[image:(.*?)\]/i','<a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img src="'.$path.'img/compendium/$1" alt="$1"></a>', $text);


  /*******************************************************************************************************************/
  // [image-nsfw:image.png|left|description of the image]

  // Handle this with a regex
  $text = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img '.$blurring2.$unblur.' src="'.$path.'img/compendium/$1" alt="$1"></a><br>$3</div>', $text);

  // Same thing if the image has no description
  $text = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img '.$blurring2.$unblur.' src="'.$path.'img/compendium/$1" alt="$1"></a></div>', $text);

  // Same thing if the images has no description or alignment
  $text = preg_replace('/\[image-nsfw:(.*?)\]/i','<a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img '.$blurring.$unblur.' src="'.$path.'img/compendium/$1" alt="$1"></a>', $text);


  /*******************************************************************************************************************/
  // [youtube:urlyoutube|left|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[youtube:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $text);
  else
    $text = preg_replace('/\[youtube:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span><br><br>$3</div>', $text);


  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $text);
  else
    $text = preg_replace('/\[youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $text);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[youtube:(.*?)\]/i','<div class="align_center"><iframe width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $text);
  else
    $text = preg_replace('/\[youtube:(.*?)\]/i','<div class="align_center"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [youtube-nsfw:urlyoutube|left|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe '.$blurring2.$unblur.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $text);
  else
    $text = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span><br><br>$3</div>', $text);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe '.$blurring2.$unblur.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $text);
  else
    $text = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $text);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[youtube-nsfw:(.*?)\]/i','<div class="align_center"><iframe '.$blurring2.$unblur.' width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $text);
  else
    $text = preg_replace('/\[youtube-nsfw:(.*?)\]/i','<div class="align_center"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [caption]Gallery image caption[/caption=author]

  // Solved with a regex in a while loop
  while(preg_match('/\[caption\](.*?)\[\/caption\]/is',$text))
    $text = preg_replace('/\[caption\](.*?)\[\/caption\]/is',"<div class=\"nbcode_caption\">$1</div>", $text);


  /*******************************************************************************************************************/
  // [caption=author]Gallery image caption with author[/caption=author]

  // Same thing but with a parameter specifying the author
  while(preg_match('/\[caption=(.*?)\](.*?)\[\/caption\]/is',$text))
    $text = preg_replace('/\[caption=(.*?)\](.*?)\[\/caption\]/is',"<div class=\"nbcode_caption\"><span class=\"bold\">$1</span>".__(':')." $2</div>", $text);


  /*******************************************************************************************************************/
  // [gallery][/gallery]

  // Handle this with a regex
  $text = preg_replace('/\[gallery\](.*?)\[\/gallery\]/is','<div class="nbcode_gallery">$1</div>', $text);


  /*******************************************************************************************************************/
  // [gallery:image.png|description of the image]

  // Handle this with a regex
  $text = preg_replace('/\[gallery:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents" loading="lazy"></div></a><hr class="nbcode_gallery_hr">$2</div>', $text);

  // Same thing if the image has no description
  $text = preg_replace('/\[gallery:(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents" loading="lazy"></div></a></div>', $text);


  /*******************************************************************************************************************/
  // [gallery-nsfw:image.png|description of the image]

  // Handle this with a regex
  $text = preg_replace('/\[gallery-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents'.$blurring2b.'"'.$unblur.' loading="lazy"></div></a><hr class="nbcode_gallery_hr">$2</div>', $text);

  // Same thing if the image has no description
  $text = preg_replace('/\[gallery-nsfw:(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents'.$blurring2b.'"'.$unblur.' loading="lazy"></div></a></div>', $text);


  /*******************************************************************************************************************/
  // [gallery-youtube:urlyoutube|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[gallery-youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div><hr class="nbcode_gallery_hr">$2</div>', $text);
  else
    $text = preg_replace('/\[gallery-youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span><br><br>$2</div>', $text);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[gallery-youtube:(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div></div>', $text);
  else
    $text = preg_replace('/\[gallery-youtube:(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [gallery-youtube-nsfw:urlyoutube|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[gallery-youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe '.$blurring2.$unblur.'src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div><hr class="nbcode_gallery_hr">$2</div>', $text);
  else
    $text = preg_replace('/\[gallery-youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span><br><br>$2</div>', $text);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $text = preg_replace('/\[gallery-youtube-nsfw:(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe '.$blurring2.$unblur.' src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div></div>', $text);
  else
    $text = preg_replace('/\[gallery-youtube-nsfw:(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [source:number]

  // Handle this with a regex
  $text = preg_replace('/\[source:(.*?)\]/i','<a class="nbcode_source" id="sourcelink_$1" href="#source_$1">[$1]</a>', $text);


  /*******************************************************************************************************************/
  // [sources:number|text]

  // Handle this with a regex
  $text = preg_replace('/\[sources:(.*?)\|(.*?)\]/i','<a id="source_$1" href="#sourcelink_$1">[$1]</a> $2', $text);


  /*******************************************************************************************************************/
  // [trends:word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $text = preg_replace('/\[trends:(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $text);
  else
    $text = preg_replace('/\[trends:(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1">Google trends: $1</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [trends2:word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $text = preg_replace('/\[trends2:(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $text);
  else
    $text = preg_replace('/\[trends2:(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2">Google trends: $1, $2</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [trends3:word|word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $text = preg_replace('/\[trends3:(.*?)\|(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $text);
  else
    $text = preg_replace('/\[trends3:(.*?)\|(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3">Google trends: $1, $2, $3</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [trends4:word|word|word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $text = preg_replace('/\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $text);
  else
    $text = preg_replace('/\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4">Google trends: $1, $2, $3, $4</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [trends5:word|word|word|word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $text = preg_replace('/\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$5","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4,$5","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $text);
  else
    $text = preg_replace('/\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4,$5">Google trends: $1, $2, $3, $4, $5</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $text);


  /*******************************************************************************************************************/
  // [copypasta=unique_id]Some text[/copypasta]

  // Handle this with a regex
  $text = preg_replace('/\[copypasta\=(.*?)\](.*?)\[\/copypasta\]/is','<pre class="monospace spaced dowrap nbcode_copypasta" id="copypasta_$1">$2</pre>', $text);


  /*******************************************************************************************************************/
  // [copypasta-nsfw=unique_id]Some text[/copypasta-nsfw]

  // Handle this with a regex
  $text = preg_replace('/\[copypasta-nsfw\=(.*?)\](.*?)\[\/copypasta-nsfw\]/is','<pre class="monospace spaced dowrap nbcode_copypasta'.$blurring3.'"'.$unblur.' id="copypasta_$1">$2</pre>', $text);


  /*******************************************************************************************************************/
  // All NBCodes have been treated

  // Return the data
  return $text;
}




/**
 * Removes all NBCode formatting from a text.
 *
 * @param   string  $text   The text which contains NBCodes.
 *
 * @return  string          The text, with NBCodes converted to HTML, ready for display.
 */

 function nbcodes_remove( string  $text ) : string
{
  // Remove BBCodes
  $text = bbcodes_remove($text);

  // Remove subtitles
  $text = preg_replace('/\=\=\=\ anchor:(.*?)\|(.*?)\ \=\=\=/i','$2', $text);
  $text = str_replace("=== ", "", $text, $open);
  $text = str_replace(" ===", "", $text, $open);

  // Remove titles
  $text = preg_replace('/\=\=\ anchor:(.*?)\|(.*?)\ \=\=/i','$2', $text);
  $text = str_replace("== ", "", $text, $open);
  $text = str_replace(" ==", "", $text, $open);

  // Remove blur
  $text = str_replace("[nsfw]", "", $text, $open);
  $text = str_replace("[/nsfw]", "", $text, $open);

  // Remove compendium page links
  $text = preg_replace('/\[page:(.*?)\|(.*?)\]/is','$2', $text);

  // Remove external links
  $text = preg_replace('/\[link:(.*?)\|(.*?)\]/is','$2', $text);

  // Remove internal links
  $text = preg_replace('/\[nobleme:(.*?)\|(.*?)\]/is','$2', $text);

  // Remove anchors
  $text = preg_replace('/\[anchor:(.*?)\]/is', '', $text);

  // Remove menus
  $text = preg_replace('/\[menu\](.*?)\[\/menu\]/is', __('nbcodes_menu_contents').'$1' , $text);
  $text = preg_replace('/\[menuitem:(.*?)\|(.*?)\]/is','* $2', $text);
  $text = preg_replace('/\[submenuitem:(.*?)\|(.*?)\]/i','  * $2', $text);

  // Remove bullet lists
  $text = str_replace("[bulletlist]", "", $text, $open);
  $text = str_replace("[/bulletlist]", "", $text, $open);
  while(preg_match('/\[bullet\](.*?)\[\/bullet\]/is',$text))
    $text = preg_replace("/\[bullet\](.*?)\[\/bullet\]/is", "* $1", $text);
  $text = str_replace("[subbulletlist]", "", $text, $open);
  $text = str_replace("[/subbulletlist]", "", $text, $open);
  while(preg_match('/\[subbullet\](.*?)\[\/subbullet\]/is',$text))
    $text = preg_replace("/\[subbullet\](.*?)\[\/subbullet\]/is", "  * $1", $text);

  // Remove images
  $text = preg_replace('/\[image:(.*?)\|(.*?)\|(.*?)\]/i', '$1 - $3'.PHP_EOL, $text);
  $text = preg_replace('/\[image:(.*?)\|(.*?)\]/i', '$1'.PHP_EOL , $text);
  $text = preg_replace('/\[image:(.*?)\]/i', '$1' , $text);
  $text = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]/i', '$1 - $3'.PHP_EOL, $text);
  $text = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\]/i', '$1'.PHP_EOL , $text);
  $text = preg_replace('/\[image-nsfw:(.*?)\]/i', '$1' , $text);

  // Remove youtube videos
  $text = preg_replace('/\[youtube:(.*?)\|(.*?)\|(.*?)\]/i', 'YouTube: $1 - $3'.PHP_EOL, $text);
  $text = preg_replace('/\[youtube:(.*?)\|(.*?)\]/i', 'YouTube: $1'.PHP_EOL , $text);
  $text = preg_replace('/\[youtube:(.*?)\]/i', 'YouTube: $1' , $text);
  $text = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]/i', 'YouTube: $1 - $3'.PHP_EOL, $text);
  $text = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\]/i', 'YouTube: $1'.PHP_EOL , $text);
  $text = preg_replace('/\[youtube-nsfw:(.*?)\]/i', 'YouTube: $1' , $text);

  // Remove captions
  while(preg_match('/\[caption\](.*?)\[\/caption\]/is',$text))
    $text = preg_replace('/\[caption\](.*?)\[\/caption\]/is',"$1", $text);
  while(preg_match('/\[caption=(.*?)\](.*?)\[\/caption\]/is',$text))
    $text = preg_replace('/\[caption=(.*?)\](.*?)\[\/caption\]/is',"$1: $2", $text);

  // Remove galleries
  $text = preg_replace('/\[gallery\](.*?)\[\/gallery\]/is', '$1', $text);
  $text = preg_replace('/\[gallery:(.*?)\|(.*?)\]/i', '$1 - $2', $text);
  $text = preg_replace('/\[gallery:(.*?)\]/i', '$1', $text);
  $text = preg_replace('/\[gallery-nsfw:(.*?)\|(.*?)\]/i', '$1 - $2', $text);
  $text = preg_replace('/\[gallery-nsfw:(.*?)\]/i', '$1', $text);
  $text = preg_replace('/\[gallery-youtube:(.*?)\|(.*?)\]/i', 'YouTube: $1 - $2', $text);
  $text = preg_replace('/\[gallery-youtube:(.*?)\]/i', 'YouTube: $1', $text);
  $text = preg_replace('/\[gallery-youtube-nsfw:(.*?)\|(.*?)\]/i', 'YouTube: $1 - $2', $text);
  $text = preg_replace('/\[gallery-youtube-nsfw:(.*?)\]/i', 'YouTube: $1', $text);

  // Remove sources
  $text = preg_replace('/\[source:(.*?)\]/i','[$1]', $text);
  $text = preg_replace('/\[sources:(.*?)\|(.*?)\]/i','[$1] $2', $text);

  // Remove google trends
  $text = preg_replace('/\[trends:(.*?)\]/i', 'Google Trends: $1', $text);
  $text = preg_replace('/\[trends2:(.*?)\|(.*?)\]/i', 'Google Trends: $1 - $2', $text);
  $text = preg_replace('/\[trends3:(.*?)\|(.*?)\|(.*?)\]/i', 'Google Trends: $1 - $2 - $3', $text);
  $text = preg_replace('/\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i', 'Google Trends: $1 - $2 - $3 - $4', $text);
  $text = preg_replace('/\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i', 'Google Trends: $1 - $2 - $3 - $4 - $5', $text);

  // Remove copypasta
  $text = preg_replace('/\[copypasta\=(.*?)\](.*?)\[\/copypasta\]/is', '$2', $text);
  $text = preg_replace('/\[copypasta-nsfw\=(.*?)\](.*?)\[\/copypasta-nsfw\]/is', '$2', $text);

  // Return the data
  return $text;
}