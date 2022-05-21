<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  bbcodes      Turns BBCodes into HTML.                                                                            */
/*  nbcodes      Turns more BBCodes into HTML, for administrator usage only.                                         */
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
 * @param   string  $message                    The message which contains BBCodes.
 *
 * @return  string                              The message, with BBCodes converted to HTML, ready for display.
 */

function bbcodes( string  $message ) : string
{
  /*******************************************************************************************************************/
  // [b]Bold[/b]

  // Replace tags with HTML
  $message = str_replace("[b]", "<span class=\"bold\">", $message, $open);
  $message = str_replace("[/b]", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // [i]Italics[/i]

  // Replace tags with HTML
  $message = str_replace("[i]", "<span class=\"italics\">", $message, $open);
  $message = str_replace("[/i]", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // [u]Underline[/u]

  // Replace tags with HTML
  $message = str_replace("[u]", "<span class=\"underlined\">", $message, $open);
  $message = str_replace("[/u]", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // [s]Strikethrough[/s]

  // Replace tags with HTML
  $message = str_replace("[s]", "<span class=\"strikethrough\">", $message, $open);
  $message = str_replace("[/s]", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // [ins]Insert[/ins] (for use in diffs)

  // Replace tags with HTML
  $message = str_replace("[ins]", "<ins>", $message, $open);
  $message = str_replace("[/ins]", "</ins>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $message.="</ins>";
  }


  /*******************************************************************************************************************/
  // [del]Delete[/del] (for use in diffs)

  // Replace tags with HTML
  $message = str_replace("[del]", "<del>", $message, $open);
  $message = str_replace("[/del]", "</del>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
     for($i = 0; $i < ($open - $close); $i++)
      $message.="</del>";
  }

  /*******************************************************************************************************************/
  // [url=http://www.example.com]Link[/url]

  // Solved with a regex
  $message = preg_replace('/\[url\](.*?)\[\/url\]/is','<a class="bold" href="$1">$1</a>', $message);

  // Same thing but with a parameter for the url
  $message = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','<a class="bold" href="$1">$2</a>', $message);


  /*******************************************************************************************************************/
  // [img]http://www.example.com/image.jpg[/img]

  // Solved with a regex
  $message = preg_replace('/\[img\](.*?)\[\/img\]/is','<img src="$1" alt="">', $message);


  /*******************************************************************************************************************/
  // [align=left/center/right]Text alignment[/align]

  // Solved with a regex
  $message = preg_replace('/\[align\=(left|center|right)\](.*?)\[\/align\]/is','<div class="align_$1">$2</div>', $message);


  /*******************************************************************************************************************/
  // [color=#CACACA]Colored text[/color]

  // Solved with a regex
  $message = preg_replace('/\[color\=(.*?)\](.*?)\[\/color\]/is','<span style="color: $1;">$2</span>', $message);


  /*******************************************************************************************************************/
  // [size=2]Text size[/size]

  // Solved with a regex
  $message = preg_replace('/\[size\=(.*?)\](.*?)\[\/size\]/is','<span style="font-size: $1em;">$2</span>', $message);


  /*******************************************************************************************************************/
  // [code]Code block[/code]

  // Solved with a regex
  $message = preg_replace('/\[code\](.*?)\[\/code\]/is','<div class="tinypadding_top"><pre>$1</pre></div>', $message);


  /*******************************************************************************************************************/
  // [quote]Quoted text[/quote]

  // Solved with a regex in a while loop
  while(preg_match('/\[quote\](.*?)\[\/quote\]/is',$message))
    $message = preg_replace('/\[quote\](.*?)\[\/quote\]/is',"<div class=\"tinypadding_top\"><div class=\"bbcode_quote_body\"><div class=\"bbcode_quote_title\">".__('bbcodes_quote')."</div><hr class=\"bbcode_quote_separator\">$1</div></div>", $message);

  // Same thing but with a parameter specifying the author
  while(preg_match('/\[quote=(.*?)\](.*?)\[\/quote\]/is',$message))
    $message = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is',"<div class=\"tinypadding_top\"><div class=\"bbcode_quote_body\"><div class=\"bbcode_quote_title\">".__('bbcodes_quote_by')." $1 :</div><hr class=\"bbcode_quote_separator\">$2</div></div>", $message);


  /*******************************************************************************************************************/
  // [spoiler]Hidden content[/spoiler]

  // Solved with a regex in a while loop - seems complicated, but it's just because we're applying a lot of js here
  while(preg_match('/\[spoiler\](.*?)\[\/spoiler\]/is',$message))
    $message = preg_replace("/\[spoiler\](.*?)\[\/spoiler\]/is", "<div class=\"tinypadding_top\"><div class=\"bbcode_spoiler_body\"><div class=\"bbcode_spoiler_title bold\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '".__('bbcodes_spoiler')." : <a class=\'bold\' href=\'#\' onclick=\'return false;\'>".__('bbcodes_spoiler_hide')."</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '".__('bbcodes_spoiler')." : <a href=\'#\' class=\'bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_show')."</a>'; }\">".__('bbcodes_spoiler')." : <a href=\"#\" class=\"bold\" onclick=\"return false;\">".__('bbcodes_spoiler_show')."</a></span></div><div><div style=\"display: none;\"><hr class=\"bbcode_spoiler_separator\">$1</div></div></div></div>", $message);

  // Same thing but with a parameter describing the spoiler's contents
  while(preg_match('/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is',$message))
    $message = preg_replace("/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is", "<div class=\"tinypadding_top\"><div class=\"bbcode_spoiler_body\"><div class=\"bbcode_spoiler_title bold\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '$1 : <a href=\'#\' class=\'bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_hide')."</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '$1 : <a href=\'#\' class=\'bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_show')."</a>'; }\">$1 : <a href=\"#\" class=\"bold\" onclick=\"return false;\">".__('bbcodes_spoiler_show')."</a></span></div><div><div style=\"display: none;\"><hr class=\"bbcode_spoiler_separator\">$2</div></div></div></div>", $message);


  /*******************************************************************************************************************/
  // [blur]Blurry content[/blur]

  // Solved with a regex
  $message = preg_replace('/\[blur\](.*?)\[\/blur\]/is','<span class="blur" onmouseover="unblur();">$1</span>', $message);


  /*******************************************************************************************************************/
  // [space] Yeah this literally just adds some unbreakable spaces, then a breakable one to avoid overflow

  // Solved with a regex
  $message = preg_replace('/\[space\]/is','      ', $message);


  /*******************************************************************************************************************/
  // [line] Horizontal separator

  // Solved with a regex
  $message = preg_replace('/\[line\]/is','<hr class="bbcode_line">', $message);


  /*******************************************************************************************************************/
  // All BBCodes have been treated

  // Return the data
  return $message;
}




/**
 * Turns more BBCodes into HTML, for administrator usage only.
 *
 * I chose to use BBCodes for the encyclopedia of internet culture instead of some other wiki-like syntax.
 * To this end, I needed acces sto more BBCodes, which users will not be allowed to use on the rest of the website.
 * Basically these are only for administrators, so there's not too much worries to be had about user input.
 *
 * @param   string  $message                    The message which contains BBCodes.
 * @param   array   $page_list      (OPTIONAL)  Output of compendium_pages_list_urls() (all existing eligible urls).
 * @param   array   $privacy_level  (OPTIONAL)  The output of user_settings_privacy() (third party settings).
 * @param   int     $nsfw_settings  (OPTIONAL)  The optuput of user_settings_nsfw() (profanity/nudity filter).
 * @param   string  $mode           (OPTIONAL)  The output of user_get_mode() (whether a light/dark theme is in use).
 *
 * @return  string                              The message, with NBCodes converted to HTML, ready for display.
 */

function nbcodes( string  $message                                                                ,
                  array   $page_list      = array()                                               ,
                  array   $privacy_level  = array('youtube' => 0, 'trends' => 0, 'twitter' => 0)  ,
                  int     $nsfw_settings  = 0                                                     ,
                  string  $mode           = 'dark'                                                ) : string
{
  /*******************************************************************************************************************/
  // Run bbcodes on the data
  $message = bbcodes($message, $privacy_level);


  /*******************************************************************************************************************/
  // Fetch the path to the website's root
  $path = root_path();


  /*******************************************************************************************************************/
  // Prepare blurring based on NSFW filter settings

  $blurring   = ($nsfw_settings < 2) ? 'class="nbcode_blur"' : '';
  $blurring2  = ($nsfw_settings < 2) ? 'class="nbcode_blur_2"' : '';
  $blurring3  = ($nsfw_settings < 1) ? ' nbcode_blur_3' : '';
  $blurring4  = ($nsfw_settings < 1) ? ' class="nbcode_blur_3"' : '';
  $unblur     = ($nsfw_settings < 2) ? ' onmouseover="unblur();"' : '';


  /*******************************************************************************************************************/
  // Prepare the correct path for icons
  $mode = ($mode == 'dark') ? '' : '_dark';


  /*******************************************************************************************************************/
  // === Subtitle ===

  // Initialize the tag counter
  $i = 0;

  // Handle this with a regex
  $message = preg_replace_callback('/\=\=\=\ (.*?)\ \=\=\=/is', function($m) use(&$i) {$i++; return '<h5 class="pointer" id="subsection'.$i.'" onclick="document.location=\'#subsection'.$i.'\';">'.$m[1].'</h5>';}, $message);


  /*******************************************************************************************************************/
  // == Title == (must parse after subtitles or it won't work)

  // Initialize the tag counter
  $i = 0;

  // Handle this with a regex
  $message = preg_replace_callback('/\=\=\ (.*?)\ \=\=/is', function($m) use(&$i) {$i++; return '<h4 class="pointer" id="section'.$i.'" onclick="document.location=\'#section'.$i.'\';">'.$m[1].'</h4>';}, $message);


  /*******************************************************************************************************************/
  // [nsfw]Blurred text[/nsfw]

  // Replace tags with HTML
  $message = str_replace("[nsfw]", "<span".$blurring4.$unblur.">", $message, $open);
  $message = str_replace("[/nsfw]", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i = 0; $i < ($open - $close); $i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // [page:compendium_url|page name]

  // Fetch all the matching tags
  preg_match_all('/\[page:(.*?)\|(.*?)\]/', $message, $results);

  // We'll need to parse each of them individually
  $i = 0;
  foreach($results[0] as $pattern)
  {
    // Prepare a different style depending on whether the page exists or not in the compendium
    $temp = (in_array(string_change_case(html_entity_decode(str_replace(' ', '_', $results[1][$i]), ENT_QUOTES), 'lowercase'), $page_list)) ? '' : 'nbcode_dead_link noglow';

    // Replace the NBcode with its HTML counterpart
    $message = str_replace($pattern, '<a class="'.$temp.'" href="'.$path.'pages/compendium/'.rawurlencode(str_replace(' ', '_', $results[1][$i])).'">'.$results[2][$i].'</a>', $message);

    // Don't forget to increment the result being treated between each iteration of the loop
    $i++;
  }


  /*******************************************************************************************************************/
  // [link:https://example.com|page name]

  // Handle this with a regex
  $message = preg_replace('/\[link:(.*?)\|(.*?)\]/i','<a href="$1" rel="noopener noreferrer" target="_blank">$2<img src="'.$path.'img/icons/link_external'.$mode.'.svg" alt=" " class="smallicon nbcode_link_icon"></a>', $message);


  /*******************************************************************************************************************/
  // [nobleme:pages/compendium/index|internal link name]

  // Handle this with a regex
  $message = preg_replace('/\[nobleme:(.*?)\|(.*?)\]/i','<a href="'.$path.'$1">$2</a>', $message);


  /*******************************************************************************************************************/
  // [anchor:name]

  // Handle this with a regex
  $message = preg_replace('/\[anchor:(.*?)\]/i','<span id="$1">&nbsp;</span>', $message);


  /*******************************************************************************************************************/
  // [menu][/menu]

  // Handle this with a regex
  $message = preg_replace('/\[menu\](.*?)\[\/menu\]/is','<h4>'.__('nbcodes_menu_contents').'</h4>$1', $message);


  /*******************************************************************************************************************/
  // [menuitem:link|text]

  // Handle this with a regex
  $message = preg_replace('/\[menuitem:(.*?)\|(.*?)\]/i','<span class="nbcode_menu_bull">&bull;</span> <a class="nbcode_menu_link" href="#$1">$2</a>', $message);


  /*******************************************************************************************************************/
  // [image:image.png|left|description of the image]

  // Handle this with a regex
  $message = preg_replace('/\[image:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img src="'.$path.'img/compendium/$1" alt="$1"></a><br>$3</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[image:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img src="'.$path.'img/compendium/$1" alt="$1"></a></div>', $message);

  // Same thing if the images has no description or alignment
  $message = preg_replace('/\[image:(.*?)\]/i','<a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img src="'.$path.'img/compendium/$1" alt="$1"></a>', $message);


  /*******************************************************************************************************************/
  // [image-nsfw:image.png|left|description of the image]

  // Handle this with a regex
  $message = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img '.$blurring2.$unblur.' src="'.$path.'img/compendium/$1" alt="$1"></a><br>$3</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[image-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img '.$blurring2.$unblur.' src="'.$path.'img/compendium/$1" alt="$1"></a></div>', $message);

  // Same thing if the images has no description or alignment
  $message = preg_replace('/\[image-nsfw:(.*?)\]/i','<a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><img '.$blurring.$unblur.' src="'.$path.'img/compendium/$1" alt="$1"></a>', $message);


  /*******************************************************************************************************************/
  // [youtube:urlyoutube|left|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $message);
  else
    $message = preg_replace('/\[youtube:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span><br><br>$3</div>', $message);


  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $message);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube:(.*?)\]/i','<div class="align_center"><iframe width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[youtube:(.*?)\]/i','<div class="align_center"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [youtube-nsfw:urlyoutube|left|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe '.$blurring2.$unblur.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $message);
  else
    $message = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span><br><br>$3</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><iframe '.$blurring2.$unblur.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_floater nbcode_floater_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $message);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube-nsfw:(.*?)\]/i','<div class="align_center"><iframe '.$blurring2.$unblur.' width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[youtube-nsfw:(.*?)\]/i','<div class="align_center"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [gallery][/gallery]

  // Handle this with a regex
  $message = preg_replace('/\[gallery\](.*?)\[\/gallery\]/is','<div class="nbcode_gallery">$1</div>', $message);


  /*******************************************************************************************************************/
  // [gallery:image.png|description of the image]

  // Handle this with a regex
  $message = preg_replace('/\[gallery:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents" loading="lazy"></div></a><hr class="nbcode_gallery_hr">$2</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[gallery:(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents" loading="lazy"></div></a></div>', $message);


  /*******************************************************************************************************************/
  // [gallery-nsfw:image.png|description of the image]

  // Handle this with a regex
  $message = preg_replace('/\[gallery-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img '.$blurring2.$unblur.' src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents" loading="lazy"></div></a><hr class="nbcode_gallery_hr">$2</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[gallery-nsfw:(.*?)\]/i','<div class="nbcode_gallery_cell"><a href="'.$path.'pages/compendium/image?name=$1" class="noglow"><div class="nbcode_gallery_container"><img '.$blurring2.$unblur.' src="'.$path.'img/compendium/$1" alt="$1" class="nbcode_gallery_contents" loading="lazy"></div></a></div>', $message);


  /*******************************************************************************************************************/
  // [gallery-youtube:urlyoutube|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[gallery-youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div><hr class="nbcode_gallery_hr">$2</div>', $message);
  else
    $message = preg_replace('/\[gallery-youtube:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span><br><br>$2</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[gallery-youtube:(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div></div>', $message);
  else
    $message = preg_replace('/\[gallery-youtube:(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [gallery-youtube-nsfw:urlyoutube|description of the video]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[gallery-youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe '.$blurring2.$unblur.'src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div><hr class="nbcode_gallery_hr">$2</div>', $message);
  else
    $message = preg_replace('/\[gallery-youtube-nsfw:(.*?)\|(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span><br><br>$2</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[gallery-youtube-nsfw:(.*?)\]/i','<div class="nbcode_gallery_cell"><div class="nbcode_gallery_container"><iframe '.$blurring2.$unblur.' src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe></div></div>', $message);
  else
    $message = preg_replace('/\[gallery-youtube-nsfw:(.*?)\]/i','<div class="nbcode_gallery_cell"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [source:number]

  // Handle this with a regex
  $message = preg_replace('/\[source:(.*?)\]/i','<a class="nbcode_source" id="sourcelink_$1" href="#source_$1">[$1]</a>', $message);


  /*******************************************************************************************************************/
  // [sources:number|text]

  // Handle this with a regex
  $message = preg_replace('/\[sources:(.*?)\|(.*?)\]/i','<a id="source_$1" href="#sourcelink_$1">[$1]</a> $2', $message);


  /*******************************************************************************************************************/
  // [trends:word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[trends:(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[trends:(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1">Google trends: $1</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [trends2:word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[trends2:(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[trends2:(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2">Google trends: $1, $2</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [trends3:word|word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[trends3:(.*?)\|(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[trends3:(.*?)\|(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3">Google trends: $1, $2, $3</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [trends4:word|word|word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4">Google trends: $1, $2, $3, $4</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [trends5:word|word|word|word|word]

  // Depending on privacy levels, hide it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$5","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4,$5","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4,$5">Google trends: $1, $2, $3, $4, $5</a><br><span class="small">'.__('nbcodes_trends_hidden').'</span></div>', $message);


  /*******************************************************************************************************************/
  // [copypasta=unique_id]Some text[/copypasta]

  // Handle this with a regex
  $message = preg_replace('/\[copypasta\=(.*?)\](.*?)\[\/copypasta\]/is','<pre onclick="to_clipboard(\' \', \'copypasta_$1\', true);" class="monospace spaced dowrap nbcode_copypasta" id="copypasta_$1">$2</pre>', $message);


  /*******************************************************************************************************************/
  // [copypasta-nsfw=unique_id]Some text[/copypasta-nsfw]

  // Handle this with a regex
  $message = preg_replace('/\[copypasta-nsfw\=(.*?)\](.*?)\[\/copypasta-nsfw\]/is','<pre onclick="to_clipboard(\' \', \'copypasta_$1\', true);" class="monospace spaced dowrap nbcode_copypasta'.$blurring3.'"'.$unblur.' id="copypasta_$1">$2</pre>', $message);


  /*******************************************************************************************************************/
  // All NBCodes have been treated

  // Return the data
  return $message;
}