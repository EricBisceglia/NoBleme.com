<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/**
 * Turns BBCodes into HTML.
 *
 * Yeah, let's say things how they are, BBCodes are bad and risky.
 * But I felt like I needed some way to let users make posts more interesting, and markdown has its limitations.
 * I went with the usual oldschool risky way and reimplemented BBCodes. Peace be upon my poor foolish soul.
 * This implementation nicely detects unclosed tags and closes them for you. I'm just cool like that.
 * Some CSS is involved, so make sure nobleme.css is included in your page when using BBCodes.
 *
 * @param   string      $message                    The message which contains BBCodes.
 * @param   string|null $path           (OPTIONAL)  Relative path to the root of the website (default 2 folders away).
 * @param   array|null  $privacy_level  (OPTIONAL)  The output of user_settings_privacy() (third party settings).
 *
 * @return  string                            The message, with BBCodes converted to HTML, ready for display.
 */

function bbcodes($message, $path="./../../", $privacy_level=array('twitter' => 0, 'youtube' => 0, 'trends' => 0))
{
  /*******************************************************************************************************************/
  // [b]Bold[/b]

  // Replace tags with HTML
  $message = str_replace("[b]", "<span class=\"bold\">", $message, $open);
  $message = str_replace("[/b]", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
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
    for($i=0;$i<($open-$close);$i++)
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
    for($i=0;$i<($open-$close);$i++)
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
    for($i=0;$i<($open-$close);$i++)
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
    for($i=0;$i<($open-$close);$i++)
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
    for($i=0;$i<($open-$close);$i++)
      $message.="</del>";
  }

  /*******************************************************************************************************************/
  // [url=http://www.url.com]Link[/url]

  // Solved with a regex
  $message = preg_replace('/\[url\](.*?)\[\/url\]/is','<a class="bold" href="$1">$1</a>', $message);

  // Same thing but with a parameter for the url
  $message = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','<a class="bold" href="$1">$2</a>', $message);


  /*******************************************************************************************************************/
  // [img]http://www.image.com/image.jpg[/img]

  // Solved with a regex
  $message = preg_replace('/\[img\](.*?)\[\/img\]/is','<img class="bbcode_img" src="$1" alt="">', $message);


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
  $message = preg_replace('/\[code\](.*?)\[\/code\]/is','<pre class="monospace indented dowrap">$1</pre>', $message);


  /*******************************************************************************************************************/
  // [youtube]videoid[/youtube]

  // Depending on privacy levels, show or hide the content - solved with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube\](.*?)\[\/youtube\]/is',"<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" gesture=\"media\" allow=\"encrypted-media\" allowfullscreen></iframe>", $message);
  else
    $message = preg_replace('/\[youtube\](.*?)\[\/youtube\]/is',"<div><a class=\"bold\" href=\"https://www.youtube.com/watch?v=$1\">YouTube: $1</a></div>", $message);


  /*******************************************************************************************************************/
  // [twitter]tweetid[/twitter]

  // Depending on privacy levels, show or hide the content - solved with a regex
  if(!$privacy_level['twitter'])
    $message = preg_replace('/\[twitter\](.*?)\[\/twitter\]/is',"<script type=\"text/javascript\"> function loadx(data) { document.write(data.html); } </script><script type=\"text/javascript\" src=\"https://api.twitter.com/1/statuses/oembed.json?id=$1&callback=loadx\"></script> <div onLoad='loadx().html'/></div>", $message);
  else
    $message = preg_replace('/\[twitter\](.*?)\[\/twitter\]/is',"<div><a class=\"bold\" href=\"http://www.twitter.com/statuses/$1\">Tweet: $1</a></div>", $message);


  /*******************************************************************************************************************/
  // [quote]Quoted text[/quote]

  // Solved with a regex in a while loop
  while(preg_match('/\[quote\](.*?)\[\/quote\]/is',$message))
    $message = preg_replace('/\[quote\](.*?)\[\/quote\]/is',"<div class=\"bbcode_quote_body\"><div class=\"bbcode_quote_title\">".__('bbcodes_quote')."</div>$1</div>", $message);

  // Same thing but with a parameter specifying the author
  while(preg_match('/\[quote=(.*?)\](.*?)\[\/quote\]/is',$message))
    $message = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is',"<div class=\"bbcode_quote_body\"><div class=\"bbcode_quote_title\">".__('bbcodes_quote_by')." $1 :</div>$2</div>", $message);


  /*******************************************************************************************************************/
  // [spoiler]Hidden content[/spoiler]

  // Solved with a regex in a while loop - seems complicated, but it's just because we're applying a lot of js here
  while(preg_match('/\[spoiler\](.*?)\[\/spoiler\]/is',$message))
    $message = preg_replace("/\[spoiler\](.*?)\[\/spoiler\]/is", "<div class=\"bbcode_spoiler_body\"><div class=\"bbcode_spoiler_title\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '".__('bbcodes_spoiler')." : <a class=\'blank bold\' href=\'#\' onclick=\'return false;\'>".__('bbcodes_spoiler_hide')."</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '".__('bbcodes_spoiler')." : <a href=\'#\' class=\'blank bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_show')."</a>'; }\">SPOILER : <a href=\"#\" class=\"blank bold\" onclick=\"return false;\">".__('bbcodes_spoiler_show')."</a></span></div><div><div style=\"display: none;\">$1</div></div></div>", $message);

  // Same thing but with a parameter describing the spoiler's contents
  while(preg_match('/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is',$message))
    $message = preg_replace("/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is", "<div class=\"bbcode_spoiler_body\"><div class=\"bbcode_spoiler_title\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '$1 : <a href=\'#\' class=\'blank bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_hide')."</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '$1 : <a href=\'#\' class=\'blank bold\' onclick=\'return false;\'>".__('bbcodes_spoiler_show')."</a>'; }\">$1 : <a href=\"#\" class=\"blank bold\" onclick=\"return false;\">".__('bbcodes_spoiler_show')."</a></span></div><div><div style=\"display: none;\">$2</div></div></div>", $message);


  /*******************************************************************************************************************/
  // [blur]Blurry content[/blur]

  // Solved with a regex
  $message = preg_replace('/\[blur\](.*?)\[\/blur\]/is','<span class="blurry">$1</span>', $message);


  /*******************************************************************************************************************/
  // [space] Yeah this literally just adds some unbreakable spaces, then a breakable one to avoid overflow

  // Solved with a regex
  $message = preg_replace('/\[space\]/is','      ', $message);


  /*******************************************************************************************************************/
  // [line] Horizontal separator

  // Solved with a regex
  $message = preg_replace('/\[line\]/is','<hr>', $message);


  /*******************************************************************************************************************/
  // Emojis

  // Replace text with emotes - sometimes it causes problems, so keep an eye out for them
  $message = str_replace(":&quot;)", '<img src="'.$path.'./img/emotes/shame.png" alt=":-#">', $message);
  $message = str_replace(':")', '<img src="'.$path.'./img/emotes/shame.png" alt=":-#">', $message);
  $message = str_replace(":-#", '<img src="'.$path.'./img/emotes/shame.png" alt=":-#">', $message);
  $message = str_replace("):C", '<img src="'.$path.'./img/emotes/unhappiness.png" alt="):C">', $message);
  $message = str_replace("):(", '<img src="'.$path.'./img/emotes/anger.png" alt="):(">', $message);
  $message = str_replace(":&quot;(", '<img src="'.$path.'./img/emotes/crying.png" alt=":\'(">', $message);
  $message = str_replace(':"(', '<img src="'.$path.'./img/emotes/crying.png" alt=":\'(">', $message);
  $message = str_replace(":'(", '<img src="'.$path.'./img/emotes/crying.png" alt=":\'(">', $message);
  $message = str_replace(":-(", '<img src="'.$path.'./img/emotes/sadness.png" alt=":(">', $message);
  $message = str_replace("XD", '<img src="'.$path.'./img/emotes/laughter.png" alt="XD">', $message);
  $message = str_replace("xD", '<img src="'.$path.'./img/emotes/laughter.png" alt="XD">', $message);
  $message = str_replace(":-O", '<img src="'.$path.'./img/emotes/surprise.png" alt=":o">', $message);
  $message = str_replace(":-o", '<img src="'.$path.'./img/emotes/surprise.png" alt=":o">', $message);
  $message = str_replace(":-s", '<img src="'.$path.'./img/emotes/confusion.png" alt=":s">', $message);
  $message = str_replace(":-S", '<img src="'.$path.'./img/emotes/confusion.png" alt=":s">', $message);
  $message = str_replace(":-p", '<img src="'.$path.'./img/emotes/tongue.png" alt=":p">', $message);
  $message = str_replace(":-P", '<img src="'.$path.'./img/emotes/tongue.png" alt=":p">', $message);
  $message = str_replace(":-DD", '<img src="'.$path.'./img/emotes/ecstasy.png" alt=":DD">', $message);
  $message = str_replace(";-)", '<img src="'.$path.'./img/emotes/wink.png" alt=";)">', $message);
  $message = str_replace(":-)", '<img src="'.$path.'./img/emotes/smiling.png" alt=":)">', $message);
  $message = str_replace("9_9", '<img src="'.$path.'./img/emotes/implying.png" alt="9_9">', $message);
  $message = str_replace(":-|", '<img src="'.$path.'./img/emotes/meh.png" alt=":|">', $message);
  $message = str_replace(":-D", '<img src="'.$path.'./img/emotes/happiness.png" alt=":D">', $message);
  $message = str_replace("o_O", '<img src="'.$path.'./img/emotes/shock_right.png" alt="o_O">', $message);
  $message = str_replace("B-)", '<img src="'.$path.'./img/emotes/cool.png" alt="B)">', $message);
  $message = str_replace("8-)", '<img src="'.$path.'./img/emotes/cool.png" alt="B)">', $message);
  $message = str_replace("o_o", '<img src="'.$path.'./img/emotes/shock.png" alt="o_o">', $message);
  $message = str_replace("O_O", '<img src="'.$path.'./img/emotes/shock.png" alt="o_o">', $message);
  $message = str_replace("O_o", '<img src="'.$path.'./img/emotes/shock_left.png" alt="O_o">', $message);


  /*******************************************************************************************************************/
  // All BBCodes have been treated

  // Return the data
  return $message;
}




/**
 * Turns more BBCodes into HTML for the NoBleme database.
 *
 * I chose to use BBCodes for the encyclopedia of internet culture instead of some other wiki-like syntax.
 * To this end, I needed acces sto more BBCodes, which users will not be allowed to use on the rest of the website.
 * Basically these are only for administrators, so there's not too much worries to be had about user input.
 * Make sure to run bbcodes() after this function, eg. nbcodes(bbcodes($my_content));
 *
 * @param   string      $message                      The message which contains BBCodes.
 * @param   string|null $path             (OPTIONAL)  Relative path to the website root (defaults to 2 folders away).
 * @param   array       $page_list        (OPTIONAL)  Output of internet_list_pages() (all titles in current language).
 * @param   array|null  $privacy_level    (OPTIONAL)  The output of user_settings_privacy() (third party settings).
 * @param   int|null    $nsfw_settings    (OPTIONAL)  The optuput of user_settings_nsfw() (profanity/nudity filter).
 *
 * @return  string                            The message, with NBCodes converted to HTML, ready for display.
 */

function nbcodes($message, $path="./../../", $page_list=array(), $privacy_level=array('twitter' => 0, 'youtube' => 0, 'trends' => 0), $nsfw_settings=0)
{
  /*******************************************************************************************************************/
  // Prepare blurring based on NSFW filter settings

  $blurring   = ($nsfw_settings < 2) ? 'class="web_nsfw_blur"' : '';
  $blurring2  = ($nsfw_settings < 2) ? 'class="web_nsfw_blur2"' : '';
  $blurring3  = ($nsfw_settings < 1) ? ' web_nsfw_blur3' : '';


  /*******************************************************************************************************************/
  // === Subtitle ===

  // Replace tags with HTML
  $message = str_replace("=== ", "<span class=\"big bold text_grey_dark\">", $message, $open);
  $message = str_replace(" ===", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // == Title == (must parse after subtitles or it won't work)

  // Replace tags with HTML
  $message = str_replace("== ", "<span class=\"big bold text_black underlined\">", $message, $open);
  $message = str_replace(" ==", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // [[internet:internet encyclopedia page|description of the link]]

  // Fetch all the matching tags
  preg_match_all('/\[\[internet:(.*?)\|(.*?)\]\]/', $message, $results);

  // We'll need to parse each of them individually
  $i = 0;
  foreach($results[0] as $pattern)
  {
    // Prepare to a different style depending on whether the page exists or not in the encyclopedia
    $temp = (in_array(string_change_case(html_entity_decode($results[1][$i], ENT_QUOTES), 'lowercase'), $page_list)) ? 'bold' : 'text_negative';

    // Replace the NBcode with its HTML counterpart
    $message = str_replace($pattern, '<a class="'.$temp.'" href="'.$path.'pages/internet/web?page='.rawurlencode($results[1][$i]).'">'.$results[2][$i].'</a>', $message);

    // Don't forget to increment the result being treated between each iteration of the loop
    $i++;
  }


  /*******************************************************************************************************************/
  // [[link:http://www.lienexterne.com|description of the link]]

  // Handle this with a regex
  $message = preg_replace('/\[\[link:(.*?)\|(.*?)\]\]/i','<a href="$1">$2<img src="'.$path.'img/icons/link_external.svg" alt=" " height="14" style="padding: 0px 2px;"></a>', $message);

  // Same thing if the link has no description
  $message = preg_replace('/\[\[link:(.*?)\]\]/i','<a href="$1">$1<img src="'.$path.'img/icons/link_external.svg" alt=" " height="14" style="padding: 0px 2px;"></a>', $message);


  /*******************************************************************************************************************/
  // [[image:image.png|left|description of the image]]

  // Handle this with a regex
  $message = preg_replace('/\[\[image:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a href="'.$path.'pages/internet/web_image?image=$1"><img src="'.$path.'img/internet/$1" alt="$1"></a>$3</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[image:(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a href="'.$path.'pages/internet/web_image?image=$1"><img src="'.$path.'img/internet/$1" alt="$1"></a></div>', $message);

  // Same thing if the images has no description or alignment
  $message = preg_replace('/\[\[image:(.*?)\]\]/i','<a href="'.$path.'pages/internet/web_image?image=$1"><img src="'.$path.'img/internet/$1" alt="$1"></a>', $message);


  /*******************************************************************************************************************/
  // [[image-nsfw:image.png|left|description of the image]]

  // Handle this with a regex
  $message = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a href="'.$path.'pages/internet/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/internet/$1" alt="$1"></a>$3</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a href="'.$path.'pages/internet/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/internet/$1" alt="$1"></a></div>', $message);

  // Same thing if the images has no description or alignment
  $message = preg_replace('/\[\[image-nsfw:(.*?)\]\]/i','<a href="'.$path.'pages/internet/web_image?image=$1"><img '.$blurring.' src="'.$path.'img/internet/$1" alt="$1"></a>', $message);


  /*******************************************************************************************************************/
  // [[youtube:urlyoutube|left|description of the video]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $message);
  else
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden', 1, 0, 0, array($path)).'</span><br><br>$3</div>', $message);


  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden', 1, 0, 0, array($path)).'</span></div>', $message);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube:(.*?)\]\]/i','<div class="align_center"><iframe width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube:(.*?)\]\]/i','<div class="align_center"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[youtube-nsfw:urlyoutube|left|description of the video]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $message);
  else
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden', 1, 0, 0, array($path)).'</span><br><br>$3</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_floater web_float_$2"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden', 1, 0, 0, array($path)).'</span></div>', $message);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\]\]/i','<div class="align_center"><iframe '.$blurring2.' width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\]\]/i','<div class="align_center"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery]][[/gallery]]

  // Handle this with a regex
  $message = preg_replace('/\[\[gallery\]\](.*?)\[\[\/gallery\]\]/is','<div class="web_gallery">$1</div>', $message);


  /*******************************************************************************************************************/
  // [[gallery:image.png|description of the image]]

  // Handle this with a regex
  $message = preg_replace('/\[\[gallery:(.*?)\|(.*?)\]\]/i','<div class="web_gallery_image"><div style="height:150px"><a href="'.$path.'pages/internet/web_image?image=$1"><img src="'.$path.'img/internet/$1" alt="$1" style="max-height:150px"></a></div><hr class="web_gallery_hr">$2</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[gallery:(.*?)\]\]/i','<div class="web_gallery_image"><a href="'.$path.'pages/internet/web_image?image=$1"><img src="'.$path.'img/internet/$1" alt="$1" style="max-height:150px"></a></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery-nsfw:image.png|description of the image]]

  // Handle this with a regex
  $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_gallery_image"><div style="height:150px"><a href="'.$path.'pages/internet/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/internet/$1" alt="$1" style="max-height:150px"></a></div><hr class="web_gallery_hr">$2</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[gallery-nsfw:(.*?)\]\]/i','<div class="web_gallery_image"><a href="'.$path.'pages/internet/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/internet/$1" alt="$1" style="max-height:150px"></a></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery:urlyoutube|youtube|description of the video]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_gallery_image"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_galerie_hr">$2</div>', $message);
  else
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_gallery_image"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small', 1, 0, 0, array($path)).'</span><br><br>$2</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\]\]/i','<div class="web_gallery_image"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_gallery_hr"></div>', $message);
  else
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\]\]/i','<div class="web_gallery_image"><a class="bold" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery-nsfw:urlyoutube|youtube|description of the video]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_gallery_image"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_gallery_hr">$2</div>', $message);
  else
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_gallery_image"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small', 1, 0, 0, array($path)).'</span><br><br>$2</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\]\]/i','<div class="web_gallery_image"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_gallery_hr"></div>', $message);
  else
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\]\]/i','<div class="web_gallery_image"><a class="bold" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="small">'.__('nbcodes_video_hidden_small', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends:word]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends:(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends:(.*?)\]\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1">Google trends: $1</a><br><span class="small">'.__('nbcodes_trends_hidden', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends2:word|word]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends2:(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends2:(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2">Google trends: $1, $2</a><br><span class="small">'.__('nbcodes_trends_hidden', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends3:word|word|word]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends3:(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends3:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3">Google trends: $1, $2, $3</a><br><span class="small">'.__('nbcodes_trends_hidden', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends4:word|word|word|word]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4">Google trends: $1, $2, $3, $4</a><br><span class="small">'.__('nbcodes_trends_hidden', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends5:word|word|word|word|word]]

  // Depending on privacy levels, blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$5","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4,$5","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="big bold" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4,$5">Google trends: $1, $2, $3, $4, $5</a><br><span class="small">'.__('nbcodes_trends_hidden', 1, 0, 0, array($path)).'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[copypasta=id]]Some text[[/copypasta]]

  // Handle this with a regex
  $message = preg_replace('/\[\[copypasta\=(.*?)\]\](.*?)\[\[\/copypasta\]\]/is','<pre onclick="highlight(\'copypasta_$1\');" class="monospace spaced dowrap web_copypasta" id="copypasta_$1">$2</pre>', $message);


  /*******************************************************************************************************************/
  // [[copypasta-nsfw=id]]Some text[[/copypasta-nsfw]]

  // Handle this with a regex
  $message = preg_replace('/\[\[copypasta-nsfw\=(.*?)\]\](.*?)\[\[\/copypasta-nsfw\]\]/is','<pre onclick="highlight(\'copypasta_$1\');" class="monospace spaced dowrap web_copypasta'.$blurring3.'" id="copypasta_$1">$2</pre>', $message);


  /*******************************************************************************************************************/
  // All NBCodes have been treated

  // Return the data
  return $message;
}