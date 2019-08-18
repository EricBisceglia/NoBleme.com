<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


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
 * @param   string|null $lang           (OPTIONAL)  The language currently being used.
 * @param   string|null $path           (OPTIONAL)  Relative path to the root of the website (default 2 folders away).
 * @param   array|null  $privacy_level  (OPTIONAL)  The output of user_settings_privacy() (third party settings).
 *
 * @return  string                            The message, with BBCodes converted to HTML, ready for display.
 */

function bbcodes($message, $lang='EN', $path="./../../", $privacy_level=array('twitter' => 0, 'youtube' => 0, 'trends' => 0))
{
  /*******************************************************************************************************************/
  // XSS prevention attempts.
  // This is poor quality code. Anyone who has a better solution, please give it to me, I really want it.

  $message = str_ireplace(".svg",".&zwnj;svg",$message);       # SVGs are exploitable through CDATA, we deny them
  $message = str_ireplace("xmlns","xmlns&zwnj;",$message);     # XMLNS trolling attempts denial
  $message = str_ireplace("onclick","onclick&zwnj;",$message); # Guess it's time to manually handle all js events...
  $message = str_ireplace("oncontextmenu","oncontextmenu&zwnj;",$message);
  $message = str_ireplace("ondblclick","ondblclick&zwnj;",$message);
  $message = str_ireplace("onmousedown","onmousedown&zwnj;",$message);
  $message = str_ireplace("onmouseenter","onmouseenter&zwnj;",$message);
  $message = str_ireplace("onmouseleave","onmouseleave&zwnj;",$message);
  $message = str_ireplace("onmousemove","onmousemove&zwnj;",$message);
  $message = str_ireplace("onmouseover","onmouseover&zwnj;",$message);
  $message = str_ireplace("onmouseout","onmouseout&zwnj;",$message);
  $message = str_ireplace("onmouseup","onmouseup&zwnj;",$message);
  $message = str_ireplace("onkeydown","onkeydown&zwnj;",$message);
  $message = str_ireplace("onkeypress","onkeypress&zwnj;",$message);
  $message = str_ireplace("onkeyup","onkeyup&zwnj;",$message);
  $message = str_ireplace("onabort","onabort&zwnj;",$message);
  $message = str_ireplace("onbeforeunload","onbeforeunload&zwnj;",$message);
  $message = str_ireplace("onerror","onerror&zwnj;",$message);
  $message = str_ireplace("onhashchange","onhashchange&zwnj;",$message);
  $message = str_ireplace("onload","onload&zwnj;",$message);
  $message = str_ireplace("onpageshow","onpageshow&zwnj;",$message);
  $message = str_ireplace("onpagehide","onpagehide&zwnj;",$message);
  $message = str_ireplace("onresize","onresize&zwnj;",$message);
  $message = str_ireplace("onscroll","onscroll&zwnj;",$message);
  $message = str_ireplace("onunload","onunload&zwnj;",$message);
  $message = str_ireplace("onblur","onblur&zwnj;",$message);
  $message = str_ireplace("onchange","onchange&zwnj;",$message);
  $message = str_ireplace("onfocus","onfocus&zwnj;",$message);
  $message = str_ireplace("onfocusin","onfocusin&zwnj;",$message);
  $message = str_ireplace("onfocusout","onfocusout&zwnj;",$message);
  $message = str_ireplace("oninput","oninput&zwnj;",$message);
  $message = str_ireplace("oninvalid","oninvalid&zwnj;",$message);
  $message = str_ireplace("onreset","onreset&zwnj;",$message);
  $message = str_ireplace("onsearch","onsearch&zwnj;",$message);
  $message = str_ireplace("onselect","onselect&zwnj;",$message);
  $message = str_ireplace("onsubmit","onsubmit&zwnj;",$message);
  $message = str_ireplace("ondrag","ondrag&zwnj;",$message);
  $message = str_ireplace("ondragend","ondragend&zwnj;",$message);
  $message = str_ireplace("ondragenter","ondragenter&zwnj;",$message);
  $message = str_ireplace("ondragleave","ondragleave&zwnj;",$message);
  $message = str_ireplace("ondragover","ondragover&zwnj;",$message);
  $message = str_ireplace("ondragstart","ondragstart&zwnj;",$message);
  $message = str_ireplace("ondrop","ondrop&zwnj;",$message);
  $message = str_ireplace("oncopy","oncopy&zwnj;",$message);
  $message = str_ireplace("oncut","oncut&zwnj;",$message);
  $message = str_ireplace("onpaste","onpaste&zwnj;",$message);
  $message = str_ireplace("onafterprint","onafterprint&zwnj;",$message);
  $message = str_ireplace("onbeforeprint","onbeforeprint&zwnj;",$message);
  $message = str_ireplace("onabort","onabort&zwnj;",$message);
  $message = str_ireplace("oncanplay","oncanplay&zwnj;",$message);
  $message = str_ireplace("oncanplaythrough","oncanplaythrough&zwnj;",$message);
  $message = str_ireplace("ondurationchange","ondurationchange&zwnj;",$message);
  $message = str_ireplace("onemptied","onemptied&zwnj;",$message);
  $message = str_ireplace("onended","onended&zwnj;",$message);
  $message = str_ireplace("onloadeddata","onloadeddata&zwnj;",$message);
  $message = str_ireplace("onloadedmetadata","onloadedmetadata&zwnj;",$message);
  $message = str_ireplace("onloadstart","onloadstart&zwnj;",$message);
  $message = str_ireplace("onpause","onpause&zwnj;",$message);
  $message = str_ireplace("onplay","onplay&zwnj;",$message);
  $message = str_ireplace("onplaying","onplaying&zwnj;",$message);
  $message = str_ireplace("onprogress","onprogress&zwnj;",$message);
  $message = str_ireplace("onratechange","onratechange&zwnj;",$message);
  $message = str_ireplace("onseeked","onseeked&zwnj;",$message);
  $message = str_ireplace("onseeking","onseeking&zwnj;",$message);
  $message = str_ireplace("onstalled","onstalled&zwnj;",$message);
  $message = str_ireplace("onsuspend","onsuspend&zwnj;",$message);
  $message = str_ireplace("ontimeupdate","ontimeupdate&zwnj;",$message);
  $message = str_ireplace("onvolumechange","onvolumechange&zwnj;",$message);
  $message = str_ireplace("onwaiting","onwaiting&zwnj;",$message);
  $message = str_ireplace("animationend","animationend&zwnj;",$message);
  $message = str_ireplace("animationiteration","animationiteration&zwnj;",$message);
  $message = str_ireplace("animationstart","animationstart&zwnj;",$message);
  $message = str_ireplace("transitionend","transitionend&zwnj;",$message);
  $message = str_ireplace("onmessage","onmessage&zwnj;",$message);
  $message = str_ireplace("onopen","onopen&zwnj;",$message);
  $message = str_ireplace("ononline","ononline&zwnj;",$message);
  $message = str_ireplace("onoffline","onoffline&zwnj;",$message);
  $message = str_ireplace("onpopstate","onpopstate&zwnj;",$message);
  $message = str_ireplace("onmousewheel","onmousewheel&zwnj;",$message);
  $message = str_ireplace("onshow","onshow&zwnj;",$message);
  $message = str_ireplace("onstorage","onstorage&zwnj;",$message);
  $message = str_ireplace("ontoggle","ontoggle&zwnj;",$message);
  $message = str_ireplace("onwheel","onwheel&zwnj;",$message);
  $message = str_ireplace("ontouchcancel","ontouchcancel&zwnj;",$message);
  $message = str_ireplace("ontouchend","ontouchend&zwnj;",$message);
  $message = str_ireplace("ontouchmove","ontouchmove&zwnj;",$message);
  $message = str_ireplace("ontouchstart","ontouchstart&zwnj;",$message);


  /*******************************************************************************************************************/
  // [b]Bold[/b]

  // Replace tags with HTML
  $message = str_replace("[b]", "<span class=\"gras\">", $message, $open);
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
  $message = str_replace("[i]", "<span class=\"italique\">", $message, $open);
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
  $message = str_replace("[u]", "<span class=\"souligne\">", $message, $open);
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
  $message = str_replace("[s]", "<span class=\"barre\">", $message, $open);
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
  $message = preg_replace('/\[url\](.*?)\[\/url\]/is','<a class="gras" href="$1">$1</a>', $message);

  // Same thing but with a parameter for the url
  $message = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','<a class="gras" href="$1">$2</a>', $message);


  /*******************************************************************************************************************/
  // [img]http://www.image.com/image.jpg[/img]

  // Solved with a regex
  $message = preg_replace('/\[img\](.*?)\[\/img\]/is','<img class="bbcodeimg" src="$1" alt="">', $message);


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
  $message = preg_replace('/\[code\](.*?)\[\/code\]/is','<pre class="monospace alinea wrap">$1</pre>', $message);


  /*******************************************************************************************************************/
  // [youtube]videoid[/youtube]

  // Depending on privacy levels, show or hide the content - solved with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[youtube\](.*?)\[\/youtube\]/is',"<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" gesture=\"media\" allow=\"encrypted-media\" allowfullscreen></iframe>", $message);
  else
    $message = preg_replace('/\[youtube\](.*?)\[\/youtube\]/is',"<div><a class=\"gras\" href=\"https://www.youtube.com/watch?v=$1\">YouTube: $1</a></div>", $message);


  /*******************************************************************************************************************/
  // [twitter]tweetid[/twitter]

  // Depending on privacy levels, show or hide the content - solved with a regex
  if(!$privacy_level['twitter'])
    $message = preg_replace('/\[twitter\](.*?)\[\/twitter\]/is',"<script type=\"text/javascript\"> function loadx(data) { document.write(data.html); } </script><script type=\"text/javascript\" src=\"https://api.twitter.com/1/statuses/oembed.json?id=$1&callback=loadx\"></script> <div class='twitter' onLoad='loadx().html'/></div>", $message);
  else
    $message = preg_replace('/\[twitter\](.*?)\[\/twitter\]/is',"<div><a class=\"gras\" href=\"http://www.twitter.com/statuses/$1\">Tweet: $1</a></div>", $message);


  /*******************************************************************************************************************/
  // [quote]Quoted text[/quote]

  // Prepare the translated strings
  $temp = ($lang == 'EN') ? 'Quote:' : 'Citation :';

  // Solved with a regex in a while loop
  while(preg_match('/\[quote\](.*?)\[\/quote\]/is',$message))
    $message = preg_replace('/\[quote\](.*?)\[\/quote\]/is',"<div class=\"citation_corps\"><div class=\"citation_titre\">$temp</div>$1</div>", $message);

  // Same thing but with a parameter specifying the author
  $temp = ($lang == 'EN') ? 'Quote by' : 'Citation de';
  while(preg_match('/\[quote=(.*?)\](.*?)\[\/quote\]/is',$message))
    $message = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is',"<div class=\"citation_corps\"><div class=\"citation_titre\">$temp $1 :</div>$2</div>", $message);


  /*******************************************************************************************************************/
  // [spoiler]Hidden content[/spoiler]

  // Prepare the translated strings
  $temp   = ($lang == 'EN') ? 'HIDE SPOILER CONTENTS' : 'MASQUER LE CONTENU CACHÉ';
  $temp2  = ($lang == 'EN') ? 'SHOW SPOILER CONTENTS' : 'VOIR LE CONTENU CACHÉ';

  // Solved with a regex in a while loop - seems complicated, but it's just because we're applying a lot of js here
  while(preg_match('/\[spoiler\](.*?)\[\/spoiler\]/is',$message))
    $message = preg_replace("/\[spoiler\](.*?)\[\/spoiler\]/is", "<div class=\"spoiler_corps\"><div class=\"spoiler_titre\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = 'SPOILER : <a class=\'dark blank gras\' href=\'#\' onclick=\'return false;\'>$temp</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = 'SPOILER : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>$temp2</a>'; }\">SPOILER : <a href=\"#\" class=\"dark blank gras\" onclick=\"return false;\">$temp2</a></span></div><div><div style=\"display: none;\">$1</div></div></div>", $message);

  // Same thing but with a parameter describing the spoiler's contents
  while(preg_match('/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is',$message))
    $message = preg_replace("/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is", "<div class=\"spoiler_corps\"><div class=\"spoiler_titre\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '$1 : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>$temp</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '$1 : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>$temp2</a>'; }\">$1 : <a href=\"#\" class=\"dark blank gras\" onclick=\"return false;\">$temp2</a></span></div><div><div style=\"display: none;\">$2</div></div></div>", $message);


  /*******************************************************************************************************************/
  // [blur]Blurry content[/blur]

  // Solved with a regex
  $message = preg_replace('/\[blur\](.*?)\[\/blur\]/is','<span class="flou">$1</span>', $message);


  /*******************************************************************************************************************/
  // [space] Yeah this literally just adds some unbreakable spaces, then a breakable one to avoid overflow

  // Solved with a regex
  $message = preg_replace('/\[space\]/is','      ', $message);


  /*******************************************************************************************************************/
  // [line] Horizontal separator

  // Solved with a regex
  $message = preg_replace('/\[line\]/is','<hr>', $message);


  /*******************************************************************************************************************/
  // Emotes

  // We just replace text with emotes... sometimes it causes problems, so keep an eye out for them
  $message = str_replace(":&quot;)", '<img src="'.$path.'./img/emotes/honte.png" alt="honte">', $message);
  $message = str_replace(':")', '<img src="'.$path.'./img/emotes/honte.png" alt="honte">', $message);
  $message = str_replace(":-#", '<img src="'.$path.'./img/emotes/honte.png" alt="honte">', $message);
  $message = str_replace("):C", '<img src="'.$path.'./img/emotes/mecontent.png" alt="mécontent">', $message);
  $message = str_replace("):(", '<img src="'.$path.'./img/emotes/colere.png" alt="colère">', $message);
  $message = str_replace(":&quot;(", '<img src="'.$path.'./img/emotes/pleure.png" alt="pleure">', $message);
  $message = str_replace(':"(', '<img src="'.$path.'./img/emotes/pleure.png" alt="pleure">', $message);
  $message = str_replace(":'(", '<img src="'.$path.'./img/emotes/pleure.png" alt="pleure">', $message);
  $message = str_replace(":-(", '<img src="'.$path.'./img/emotes/triste.png" alt="triste">', $message);
  $message = str_replace("XD", '<img src="'.$path.'./img/emotes/rire.png" alt="rire">', $message);
  $message = str_replace("xD", '<img src="'.$path.'./img/emotes/rire.png" alt="rire">', $message);
  $message = str_replace(":-O", '<img src="'.$path.'./img/emotes/surprise.png" alt="surprise">', $message);
  $message = str_replace(":-o", '<img src="'.$path.'./img/emotes/surprise.png" alt="surprise">', $message);
  $message = str_replace(":-s", '<img src="'.$path.'./img/emotes/gene.png" alt="gêné">', $message);
  $message = str_replace(":-S", '<img src="'.$path.'./img/emotes/gene.png" alt="gêné">', $message);
  $message = str_replace(":-p", '<img src="'.$path.'./img/emotes/coquin.png" alt="coquin">', $message);
  $message = str_replace(":-P", '<img src="'.$path.'./img/emotes/coquin.png" alt="coquin">', $message);
  $message = str_replace(":-DD", '<img src="'.$path.'./img/emotes/jouissif.png" alt="jouissif">', $message);
  $message = str_replace(";-)", '<img src="'.$path.'./img/emotes/complice.png" alt="complice">', $message);
  $message = str_replace(":-)", '<img src="'.$path.'./img/emotes/sourire.png" alt="sourire">', $message);
  $message = str_replace("9_9", '<img src="'.$path.'./img/emotes/reveur.png" alt="rêveur">', $message);
  $message = str_replace(":-|", '<img src="'.$path.'./img/emotes/blase.png" alt="Blasé">', $message);
  $message = str_replace(":-D", '<img src="'.$path.'./img/emotes/heureux.png" alt="heureux">', $message);
  $message = str_replace("o_O", '<img src="'.$path.'./img/emotes/perplexe3.png" alt="perplexe">', $message);
  $message = str_replace("B-)", '<img src="'.$path.'./img/emotes/cool.png" alt="cool">', $message);
  $message = str_replace("8-)", '<img src="'.$path.'./img/emotes/cool.png" alt="cool">', $message);
  $message = str_replace("o_o", '<img src="'.$path.'./img/emotes/perplexe1.png" alt="perplexe">', $message);
  $message = str_replace("O_O", '<img src="'.$path.'./img/emotes/perplexe1.png" alt="perplexe">', $message);
  $message = str_replace("O_o", '<img src="'.$path.'./img/emotes/perplexe2.png" alt="perplexe">', $message);


  /*******************************************************************************************************************/
  // All BBCodes have been treated

  // We can now return the data
  return $message;
}




/**
 * Turns more BBCodes into HTML for the NoBleme database.
 *
 * I chose to use BBCodes for the encyclopedia of internet culture instead of some other wiki-like syntax.
 * To this end, I needed acces sto more BBCodes, which users will not be allowed to use on the rest of the website.
 * Basically these are only for administrators, so there's not too much worries to be had about user input.
 * Make sure to run bbcodes() after this function, eg. nbdbcodes(bbcodes($my_content));
 *
 * @param   string      $message                      The message which contains BBCodes.
 * @param   string|null $lang             (OPTIONAL)  The language currently being used.
 * @param   string|null $path             (OPTIONAL)  Relative path to the website root (defaults to 2 folders away).
 * @param   array       $page_list        (OPTIONAL)  Output of nbdb_web_list_pages() (all titles in current language).
 * @param   array       $definition_list  (OPTIONAL)  Output of nbdb_web_list_definitions() (all definitions in $lang).
 * @param   array|null  $privacy_level    (OPTIONAL)  The output of user_settings_privacy() (third party settings).
 * @param   int|null    $nsfw_settings    (OPTIONAL)  The optuput of user_settings_nsfw() (profanity/nudity filter).
 *
 * @return  string                            The message, with NBDB's BBCodes converted to HTML, ready for display.
 */

function nbdbcodes($message, $lang='EN', $path="./../../", $page_list=array(), $definition_list=array(), $privacy_level=array('twitter' => 0, 'youtube' => 0, 'trends' => 0), $nsfw_settings=0)
{
  /*******************************************************************************************************************/
  // Setting up third party privacy settings

  // Translation of multilingual strings
  $temp_lang_video_off = ($lang == 'EN') ? 'This video is hidden (<a href="'.$path.'pages/user/privacy">privacy options</a>)' : 'Cette vidéo est masquée (<a href="'.$path.'pages/user/privacy">options de vie privée</a>)';
  $temp_lang_video_off_small = ($lang == 'EN') ? 'Video hidden (<a href="'.$path.'pages/user/privacy">privacy options</a>)' : 'Vidéo masquée (<a href="'.$path.'pages/user/privacy">options de vie privée</a>)';
  $temp_lang_trends_off = ($lang == 'EN') ? 'This Google trends graph is hidden (<a href="'.$path.'pages/user/privacy">privacy options</a>)' : 'Ce graphe Google trends est masqué (<a href="'.$path.'pages/user/privacy">options de vie privée</a>)';

  // If necessary, prepare CSS classes for blurred content
  $blurring   = ($nsfw_settings < 2) ? 'class="web_nsfw_flou"' : '';
  $blurring2  = ($nsfw_settings < 2) ? 'class="web_nsfw_flou2"' : '';
  $blurring3  = ($nsfw_settings < 1) ? ' web_nsfw_flou3' : '';


  /*******************************************************************************************************************/
  // === Subtitle ===

  // Replace tags with HTML
  $message = str_replace("=== ", "<span class=\"moinsgros gras texte_grisfonce\">", $message, $open);
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
  $message = str_replace("== ", "<span class=\"gros gras texte_noir souligne\">", $message, $open);
  $message = str_replace(" ==", "</span>", $message, $close);

  // Close leftover open tags
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $message.="</span>";
  }


  /*******************************************************************************************************************/
  // [[web:internet encyclopedia page|description of the link]]

  // We fetch all the matching tags
  preg_match_all('/\[\[web:(.*?)\|(.*?)\]\]/', $message, $results);

  // We'll need to parse each of them individually
  $i = 0;
  foreach($results[0] as $pattern)
  {
    // Prepare to a different style depending on whether the page exists or not in the encyclopedia
    $temp_style = (in_array(string_change_case(html_entity_decode($results[1][$i], ENT_QUOTES), 'lowercase'), $page_list)) ? 'gras' : 'texte_negatif';

    // We can now replace the BBCode with its HTML counterpart
    $message = str_replace($pattern, '<a class="'.$temp_style.'" href="'.$path.'pages/nbdb/web?page='.rawurlencode($results[1][$i]).'">'.$results[2][$i].'</a>', $message);

    // Don't forget to increment the result being treated between each iteration of the loop
    $i++;
  }


  /*******************************************************************************************************************/
  // [[definition:internet dictionary page|description of the link]]

  // We fetch all the matching tags
  preg_match_all('/\[\[definition:(.*?)\|(.*?)\]\]/', $message, $results);

  // We'll need to parse each of them individually
  $i = 0;
  foreach($results[0] as $pattern)
  {
    // Prepare to a different style depending on whether the page exists or not in the encyclopedia
    $temp_style = (in_array(string_change_case(html_entity_decode($results[1][$i], ENT_QUOTES), 'lowercase'), $definition_list)) ? 'gras' : 'texte_negatif';

    // We can now replace the BBCode with its HTML counterpart
    $message = str_replace($pattern, '<a class="'.$temp_style.'" href="'.$path.'pages/nbdb/web_dictionnaire?define='.rawurlencode($results[1][$i]).'">'.$results[2][$i].'</a>', $message);

    // Don't forget to increment the result being treated between each iteration of the loop
    $i++;
  }


  /*******************************************************************************************************************/
  // [[link:http://www.lienexterne.com|description of the link]]

  // We handle this with a regex
  $message = preg_replace('/\[\[link:(.*?)\|(.*?)\]\]/i','<a href="$1">$2<img src="'.$path.'img/icones/lien_externe.svg" alt=" " height="14" style="padding: 0px 2px;"></a>', $message);

  // Same thing if the link has no description
  $message = preg_replace('/\[\[link:(.*?)\]\]/i','<a href="$1">$1<img src="'.$path.'img/icones/lien_externe.svg" alt=" " height="14" style="padding: 0px 2px;"></a>', $message);


  /*******************************************************************************************************************/
  // [[image:image.png|left|description of the image]]

  // We handle this with a regex
  $message = preg_replace('/\[\[image:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img src="'.$path.'img/nbdb_web/$1" alt="$1"></a>$3</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[image:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img src="'.$path.'img/nbdb_web/$1" alt="$1"></a></div>', $message);

  // Same thing if the images has no description or alignment
  $message = preg_replace('/\[\[image:(.*?)\]\]/i','<a href="'.$path.'pages/nbdb/web_image?image=$1"><img src="'.$path.'img/nbdb_web/$1" alt="$1"></a>', $message);


  /*******************************************************************************************************************/
  // [[image-nsfw:image.png|left|description of the image]]

  // We handle this with a regex
  $message = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/nbdb_web/$1" alt="$1"></a>$3</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/nbdb_web/$1" alt="$1"></a></div>', $message);

  // Same thing if the images has no description or alignment
  $message = preg_replace('/\[\[image-nsfw:(.*?)\]\]/i','<a href="'.$path.'pages/nbdb/web_image?image=$1"><img '.$blurring.' src="'.$path.'img/nbdb_web/$1" alt="$1"></a>', $message);


  /*******************************************************************************************************************/
  // [[youtube:urlyoutube|left|description of the video]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $message);
  else
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span><br><br>$3</div>', $message);


  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $message);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube:(.*?)\]\]/i','<div class="align_center"><iframe width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube:(.*?)\]\]/i','<div class="align_center"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[youtube-nsfw:urlyoutube|left|description of the video]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $message);
  else
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span><br><br>$3</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $message);

  // Same thing if the video has no description or alignment
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\]\]/i','<div class="align_center"><iframe '.$blurring2.' width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $message);
  else
    $message = preg_replace('/\[\[youtube-nsfw:(.*?)\]\]/i','<div class="align_center"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery]][[/gallery]]

  // We handle this with a regex
  $message = preg_replace('/\[\[gallery\]\](.*?)\[\[\/gallery\]\]/is','<div class="web_galerie">$1</div>', $message);


  /*******************************************************************************************************************/
  // [[gallery:image.png|description of the image]]

  // We handle this with a regex
  $message = preg_replace('/\[\[gallery:(.*?)\|(.*?)\]\]/i','<div class="web_galerie_image"><div style="height:150px"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img src="'.$path.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div><hr class="web_galerie_hr">$2</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[gallery:(.*?)\]\]/i','<div class="web_galerie_image"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img src="'.$path.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery-nsfw:image.png|description of the image]]

  // We handle this with a regex
  $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_galerie_image"><div style="height:150px"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div><hr class="web_galerie_hr">$2</div>', $message);

  // Same thing if the image has no description
  $message = preg_replace('/\[\[gallery-nsfw:(.*?)\]\]/i','<div class="web_galerie_image"><a href="'.$path.'pages/nbdb/web_image?image=$1"><img '.$blurring2.' src="'.$path.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery:urlyoutube|youtube|description of the video]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="wyb_galerie_hr">$2</div>', $message);
  else
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span><br><br>$2</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><iframe style="width:100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_galerie_hr"></div>', $message);
  else
    $message = preg_replace('/\[\[gallery:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[gallery-nsfw:urlyoutube|youtube|description of the video]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_galerie_hr">$2</div>', $message);
  else
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span><br><br>$2</div>', $message);

  // Same thing if the video has no description
  if(!$privacy_level['youtube'])
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><iframe '.$blurring2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_galerie_hr"></div>', $message);
  else
    $message = preg_replace('/\[\[gallery-nsfw:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends:word]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends:(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends:(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1">Google trends: $1</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends2:word|word]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends2:(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends2:(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2">Google trends: $1, $2</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends3:word|word|word]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends3:(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends3:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2,$3">Google trends: $1, $2, $3</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends4:word|word|word|word]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4">Google trends: $1, $2, $3, $4</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[trends5:word|word|word|word|word]]

  // Depending on privacy levels, we blur it or not - both cases are treated with a regex
  if(!$privacy_level['trends'])
    $message = preg_replace('/\[\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$5","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4,$5","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $message);
  else
    $message = preg_replace('/\[\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4,$5">Google trends: $1, $2, $3, $4, $5</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $message);


  /*******************************************************************************************************************/
  // [[copypasta=id]]Some text[[/copypasta]]

  // We handle this with a regex
  $message = preg_replace('/\[\[copypasta\=(.*?)\]\](.*?)\[\[\/copypasta\]\]/is','<pre onclick="highlight(\'copypasta_$1\');" class="monospace spaced dowrap web_copypasta" id="copypasta_$1">$2</pre>', $message);


  /*******************************************************************************************************************/
  // [[copypasta-nsfw=id]]Some text[[/copypasta-nsfw]]

  // We handle this with a regex
  $message = preg_replace('/\[\[copypasta-nsfw\=(.*?)\]\](.*?)\[\[\/copypasta-nsfw\]\]/is','<pre onclick="highlight(\'copypasta_$1\');" class="monospace spaced dowrap web_copypasta'.$blurring3.'" id="copypasta_$1">$2</pre>', $message);


  /*******************************************************************************************************************/
  // All BBCodes have been treated

  // We can now return the data
  return $message;
}