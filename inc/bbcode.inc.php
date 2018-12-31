<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction formattant les bbcodes contenus dans un message pour en faire du HTML
// Ne fonctionne que dans un sens (bbcode => html)
// Détecte les tags non fermés et les corrige
// Requiret nobleme.css pour fonctionner correctement
//
// $xhr est un paramètre optionnel qui permet d'utiliser un chemin différent pour les URL
//
// Exemple d'utilisation: bbcode($post)

function bbcode($post, $xhr=NULL)
{
  // Détermination de la langue utilisée
  $lang = (!isset($_SESSION['lang'])) ? 'FR' : $_SESSION['lang'];

  // Détermination du niveau de vie privée demandé par l'utilisateur
  $niveau_vie_privee = niveau_vie_privee();

  // Fix temporaire pour les XSS gratuits.
  // Il faut vraiment que je trouve mieux que ça comme solution... Franchement, si quelqu'un a une solution, je suis preneur.
  $post = str_ireplace(".svg",".&zwnj;svg",$post);       # Je ne veux pas de SVG, c'est exploitable avec CDATA
  $post = str_ireplace("xmlns","xmlns&zwnj;",$post);     # Troll XMLNS
  $post = str_ireplace("onclick","onclick&zwnj;",$post); # Bon bah on va gérer à la main tous les events JS pour le moment... ffffff
  $post = str_ireplace("oncontextmenu","oncontextmenu&zwnj;",$post);
  $post = str_ireplace("ondblclick","ondblclick&zwnj;",$post);
  $post = str_ireplace("onmousedown","onmousedown&zwnj;",$post);
  $post = str_ireplace("onmouseenter","onmouseenter&zwnj;",$post);
  $post = str_ireplace("onmouseleave","onmouseleave&zwnj;",$post);
  $post = str_ireplace("onmousemove","onmousemove&zwnj;",$post);
  $post = str_ireplace("onmouseover","onmouseover&zwnj;",$post);
  $post = str_ireplace("onmouseout","onmouseout&zwnj;",$post);
  $post = str_ireplace("onmouseup","onmouseup&zwnj;",$post);
  $post = str_ireplace("onkeydown","onkeydown&zwnj;",$post);
  $post = str_ireplace("onkeypress","onkeypress&zwnj;",$post);
  $post = str_ireplace("onkeyup","onkeyup&zwnj;",$post);
  $post = str_ireplace("onabort","onabort&zwnj;",$post);
  $post = str_ireplace("onbeforeunload","onbeforeunload&zwnj;",$post);
  $post = str_ireplace("onerror","onerror&zwnj;",$post);
  $post = str_ireplace("onhashchange","onhashchange&zwnj;",$post);
  $post = str_ireplace("onload","onload&zwnj;",$post);
  $post = str_ireplace("onpageshow","onpageshow&zwnj;",$post);
  $post = str_ireplace("onpagehide","onpagehide&zwnj;",$post);
  $post = str_ireplace("onresize","onresize&zwnj;",$post);
  $post = str_ireplace("onscroll","onscroll&zwnj;",$post);
  $post = str_ireplace("onunload","onunload&zwnj;",$post);
  $post = str_ireplace("onblur","onblur&zwnj;",$post);
  $post = str_ireplace("onchange","onchange&zwnj;",$post);
  $post = str_ireplace("onfocus","onfocus&zwnj;",$post);
  $post = str_ireplace("onfocusin","onfocusin&zwnj;",$post);
  $post = str_ireplace("onfocusout","onfocusout&zwnj;",$post);
  $post = str_ireplace("oninput","oninput&zwnj;",$post);
  $post = str_ireplace("oninvalid","oninvalid&zwnj;",$post);
  $post = str_ireplace("onreset","onreset&zwnj;",$post);
  $post = str_ireplace("onsearch","onsearch&zwnj;",$post);
  $post = str_ireplace("onselect","onselect&zwnj;",$post);
  $post = str_ireplace("onsubmit","onsubmit&zwnj;",$post);
  $post = str_ireplace("ondrag","ondrag&zwnj;",$post);
  $post = str_ireplace("ondragend","ondragend&zwnj;",$post);
  $post = str_ireplace("ondragenter","ondragenter&zwnj;",$post);
  $post = str_ireplace("ondragleave","ondragleave&zwnj;",$post);
  $post = str_ireplace("ondragover","ondragover&zwnj;",$post);
  $post = str_ireplace("ondragstart","ondragstart&zwnj;",$post);
  $post = str_ireplace("ondrop","ondrop&zwnj;",$post);
  $post = str_ireplace("oncopy","oncopy&zwnj;",$post);
  $post = str_ireplace("oncut","oncut&zwnj;",$post);
  $post = str_ireplace("onpaste","onpaste&zwnj;",$post);
  $post = str_ireplace("onafterprint","onafterprint&zwnj;",$post);
  $post = str_ireplace("onbeforeprint","onbeforeprint&zwnj;",$post);
  $post = str_ireplace("onabort","onabort&zwnj;",$post);
  $post = str_ireplace("oncanplay","oncanplay&zwnj;",$post);
  $post = str_ireplace("oncanplaythrough","oncanplaythrough&zwnj;",$post);
  $post = str_ireplace("ondurationchange","ondurationchange&zwnj;",$post);
  $post = str_ireplace("onemptied","onemptied&zwnj;",$post);
  $post = str_ireplace("onended","onended&zwnj;",$post);
  $post = str_ireplace("onloadeddata","onloadeddata&zwnj;",$post);
  $post = str_ireplace("onloadedmetadata","onloadedmetadata&zwnj;",$post);
  $post = str_ireplace("onloadstart","onloadstart&zwnj;",$post);
  $post = str_ireplace("onpause","onpause&zwnj;",$post);
  $post = str_ireplace("onplay","onplay&zwnj;",$post);
  $post = str_ireplace("onplaying","onplaying&zwnj;",$post);
  $post = str_ireplace("onprogress","onprogress&zwnj;",$post);
  $post = str_ireplace("onratechange","onratechange&zwnj;",$post);
  $post = str_ireplace("onseeked","onseeked&zwnj;",$post);
  $post = str_ireplace("onseeking","onseeking&zwnj;",$post);
  $post = str_ireplace("onstalled","onstalled&zwnj;",$post);
  $post = str_ireplace("onsuspend","onsuspend&zwnj;",$post);
  $post = str_ireplace("ontimeupdate","ontimeupdate&zwnj;",$post);
  $post = str_ireplace("onvolumechange","onvolumechange&zwnj;",$post);
  $post = str_ireplace("onwaiting","onwaiting&zwnj;",$post);
  $post = str_ireplace("animationend","animationend&zwnj;",$post);
  $post = str_ireplace("animationiteration","animationiteration&zwnj;",$post);
  $post = str_ireplace("animationstart","animationstart&zwnj;",$post);
  $post = str_ireplace("transitionend","transitionend&zwnj;",$post);
  $post = str_ireplace("onmessage","onmessage&zwnj;",$post);
  $post = str_ireplace("onopen","onopen&zwnj;",$post);
  $post = str_ireplace("ononline","ononline&zwnj;",$post);
  $post = str_ireplace("onoffline","onoffline&zwnj;",$post);
  $post = str_ireplace("onpopstate","onpopstate&zwnj;",$post);
  $post = str_ireplace("onmousewheel","onmousewheel&zwnj;",$post);
  $post = str_ireplace("onshow","onshow&zwnj;",$post);
  $post = str_ireplace("onstorage","onstorage&zwnj;",$post);
  $post = str_ireplace("ontoggle","ontoggle&zwnj;",$post);
  $post = str_ireplace("onwheel","onwheel&zwnj;",$post);
  $post = str_ireplace("ontouchcancel","ontouchcancel&zwnj;",$post);
  $post = str_ireplace("ontouchend","ontouchend&zwnj;",$post);
  $post = str_ireplace("ontouchmove","ontouchmove&zwnj;",$post);
  $post = str_ireplace("ontouchstart","ontouchstart&zwnj;",$post);

  // [b]Gras[/b]
  $post = str_replace("[b]", "<span class=\"gras\">", $post, $open);
  $post = str_replace("[/b]", "</span>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</span>";
  }

  // [i]Italique[/i]
  $post = str_replace("[i]", "<span class=\"italique\">", $post, $open);
  $post = str_replace("[/i]", "</span>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</span>";
  }

  // [u]Underline[/u]
  $post = str_replace("[u]", "<span class=\"souligne\">", $post, $open);
  $post = str_replace("[/u]", "</span>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</span>";
  }

  // [s]Strikethrough[/s]
  $post = str_replace("[s]", "<span class=\"barre\">", $post, $open);
  $post = str_replace("[/s]", "</span>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</span>";
  }

  // [ins]Secret: Insert[/ins]
  $post = str_replace("[ins]", "<ins>", $post, $open);
  $post = str_replace("[/ins]", "</ins>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</ins>";
  }

  // [del]Secret: Delete[/del]
  $post = str_replace("[del]", "<del>", $post, $open);
  $post = str_replace("[/del]", "</del>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</del>";
  }

  // [url=http://www.url.com]Lien[/url]
  $post = preg_replace('/\[url\](.*?)\[\/url\]/is','<a class="gras" href="$1">$1</a>', $post);

  // [url=http://www.url.com]Lien[/url]
  $post = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','<a class="gras" href="$1">$2</a>', $post);

  // [img]http://www.image.com/image.jpg[/img]
  $post = preg_replace('/\[img\](.*?)\[\/img\]/is','<img class="bbcodeimg" src="$1" alt="">', $post);

  // [align=left/center/right]Texte aligné[/align]
  $post = preg_replace('/\[align\=(left|center|right)\](.*?)\[\/align\]/is','<div class="align_$1">$2</div>', $post);

  // [color=#CACACA]Texte coloré[/color]
  $post = preg_replace('/\[color\=(.*?)\](.*?)\[\/color\]/is','<span style="color: $1;">$2</span>', $post);

  // [size=2]Grand texte[/size]
  $post = preg_replace('/\[size\=(.*?)\](.*?)\[\/size\]/is','<span style="font-size: $1em;">$2</span>', $post);

  // [code]Bloc de code[/code]
  $post = preg_replace('/\[code\](.*?)\[\/code\]/is','<pre class="monospace alinea wrap">$1</pre>', $post);

  // [youtube]videoid[/youtube]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[youtube\](.*?)\[\/youtube\]/is',"<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" gesture=\"media\" allow=\"encrypted-media\" allowfullscreen></iframe>", $post);
  else
    $post = preg_replace('/\[youtube\](.*?)\[\/youtube\]/is',"<div><a class=\"gras\" href=\"https://www.youtube.com/watch?v=$1\">YouTube: $1</a></div>", $post);

  // [twitter]tweetid[/twitter]
  if(!$niveau_vie_privee['twitter'])
    $post = preg_replace('/\[twitter\](.*?)\[\/twitter\]/is',"<script type=\"text/javascript\"> function loadx(data) { document.write(data.html); } </script><script type=\"text/javascript\" src=\"https://api.twitter.com/1/statuses/oembed.json?id=$1&callback=loadx\"></script> <div class='twitter' onLoad='loadx().html'/></div>", $post);
  else
    $post = preg_replace('/\[twitter\](.*?)\[\/twitter\]/is',"<div><a class=\"gras\" href=\"http://www.twitter.com/statuses/$1\">Tweet: $1</a></div>", $post);

  // [quote]Citation[/quote]
  $temp = ($lang == 'FR') ? 'Citation :' : 'Quote:';
  while(preg_match('/\[quote\](.*?)\[\/quote\]/is',$post))
    $post = preg_replace('/\[quote\](.*?)\[\/quote\]/is',"<div class=\"citation_corps\"><div class=\"citation_titre\">$temp</div>$1</div>", $post);

  // [quote=Machin]Citation par Machin[/quote]
  $temp = ($lang == 'FR') ? 'Citation de' : 'Quote by';
  while(preg_match('/\[quote=(.*?)\](.*?)\[\/quote\]/is',$post))
    $post = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is',"<div class=\"citation_corps\"><div class=\"citation_titre\">$temp $1 :</div>$2</div>", $post);

  // [spoiler]Contenu caché[/spoiler]
  $temp = ($lang == 'FR') ? 'MASQUER LE CONTENU CACHÉ' : 'HIDE SPOILER CONTENTS';
  $temp2 = ($lang == 'FR') ? 'VOIR LE CONTENU CACHÉ' : 'SHOW SPOILER CONTENTS';
  while(preg_match('/\[spoiler\](.*?)\[\/spoiler\]/is',$post))
    $post = preg_replace("/\[spoiler\](.*?)\[\/spoiler\]/is", "<div class=\"spoiler_corps\"><div class=\"spoiler_titre\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = 'SPOILER : <a class=\'dark blank gras\' href=\'#\' onclick=\'return false;\'>$temp</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = 'SPOILER : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>$temp2</a>'; }\">SPOILER : <a href=\"#\" class=\"dark blank gras\" onclick=\"return false;\">$temp2</a></span></div><div><div style=\"display: none;\">$1</div></div></div>", $post);

  // [spoiler=titre]Contenu caché[/spoiler]
  while(preg_match('/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is',$post))
    $post = preg_replace("/\[spoiler=(.*?)\](.*?)\[\/spoiler\]/is", "<div class=\"spoiler_corps\"><div class=\"spoiler_titre\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '$1 : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>$temp</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '$1 : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>$temp2</a>'; }\">$1 : <a href=\"#\" class=\"dark blank gras\" onclick=\"return false;\">$temp2</a></span></div><div><div style=\"display: none;\">$2</div></div></div>", $post);

  // [blur]Contenu floué[/blur]
  $post = preg_replace('/\[blur\](.*?)\[\/blur\]/is','<span class="flou">$1</span>', $post);

  // [space]
  $post = preg_replace('/\[space\]/is','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $post);

  // [line]
  $post = preg_replace('/\[line\]/is','<hr>', $post);


  // Redéfinition du $chemin
  // La base est différente selon si on est en localhost ou en prod
  if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1")
    $count_base = 3;
  else
    $count_base = 2;

  // Déterminer à combien de dossiers de la racine on est
  $longueur = count(explode( '/', $_SERVER['REQUEST_URI']));

  // Si on est à la racine, laisser le chemin tel quel
  if($longueur <= $count_base)
    $chemin = "";

  // Sinon, partir de ./ puis déterminer le nombre de ../ à rajouter
  else
  {
    $chemin = "./";
    $start = ($xhr) ? 1 : 0;
    for ($i=$start ; $i<($longueur-$count_base) ; $i++)
      $chemin .= "../";
  }

  // Emotes
  $post = str_replace(":&quot;)", '<img src="'.$chemin.'./img/emotes/honte.png" alt="honte">', $post);
  $post = str_replace(':")', '<img src="'.$chemin.'./img/emotes/honte.png" alt="honte">', $post);
  $post = str_replace(":-#", '<img src="'.$chemin.'./img/emotes/honte.png" alt="honte">', $post);
  $post = str_replace("):C", '<img src="'.$chemin.'./img/emotes/mecontent.png" alt="mécontent">', $post);
  $post = str_replace("):(", '<img src="'.$chemin.'./img/emotes/colere.png" alt="colère">', $post);
  $post = str_replace(":&quot;(", '<img src="'.$chemin.'./img/emotes/pleure.png" alt="pleure">', $post);
  $post = str_replace(':"(', '<img src="'.$chemin.'./img/emotes/pleure.png" alt="pleure">', $post);
  $post = str_replace(":'(", '<img src="'.$chemin.'./img/emotes/pleure.png" alt="pleure">', $post);
  $post = str_replace(":-(", '<img src="'.$chemin.'./img/emotes/triste.png" alt="triste">', $post);
  $post = str_replace("XD", '<img src="'.$chemin.'./img/emotes/rire.png" alt="rire">', $post);
  $post = str_replace("xD", '<img src="'.$chemin.'./img/emotes/rire.png" alt="rire">', $post);
  $post = str_replace(":-O", '<img src="'.$chemin.'./img/emotes/surprise.png" alt="surprise">', $post);
  $post = str_replace(":-o", '<img src="'.$chemin.'./img/emotes/surprise.png" alt="surprise">', $post);
  $post = str_replace(":-s", '<img src="'.$chemin.'./img/emotes/gene.png" alt="gêné">', $post);
  $post = str_replace(":-S", '<img src="'.$chemin.'./img/emotes/gene.png" alt="gêné">', $post);
  $post = str_replace(":-p", '<img src="'.$chemin.'./img/emotes/coquin.png" alt="coquin">', $post);
  $post = str_replace(":-P", '<img src="'.$chemin.'./img/emotes/coquin.png" alt="coquin">', $post);
  $post = str_replace(":-DD", '<img src="'.$chemin.'./img/emotes/jouissif.png" alt="jouissif">', $post);
  $post = str_replace(";-)", '<img src="'.$chemin.'./img/emotes/complice.png" alt="complice">', $post);
  $post = str_replace(":-)", '<img src="'.$chemin.'./img/emotes/sourire.png" alt="sourire">', $post);
  $post = str_replace("9_9", '<img src="'.$chemin.'./img/emotes/reveur.png" alt="rêveur">', $post);
  $post = str_replace(":-|", '<img src="'.$chemin.'./img/emotes/blase.png" alt="Blasé">', $post);
  $post = str_replace(":-D", '<img src="'.$chemin.'./img/emotes/heureux.png" alt="heureux">', $post);
  $post = str_replace("o_O", '<img src="'.$chemin.'./img/emotes/perplexe3.png" alt="perplexe">', $post);
  $post = str_replace("B-)", '<img src="'.$chemin.'./img/emotes/cool.png" alt="cool">', $post);
  $post = str_replace("8-)", '<img src="'.$chemin.'./img/emotes/cool.png" alt="cool">', $post);
  $post = str_replace("o_o", '<img src="'.$chemin.'./img/emotes/perplexe1.png" alt="perplexe">', $post);
  $post = str_replace("O_O", '<img src="'.$chemin.'./img/emotes/perplexe1.png" alt="perplexe">', $post);
  $post = str_replace("O_o", '<img src="'.$chemin.'./img/emotes/perplexe2.png" alt="perplexe">', $post);

  // Et on renvoie la chaine traitée
  return $post;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction rajoutant des BBCodes supplémentaires pour la NBDB
//
// $post                      est la chaîne de caractères à transformer
// $chemin                    est le chemin jusqu'à la racine du site
// $liste_pages_encyclopedie  est un tableau contenant la liste de toutes les pages de l'encyclopédie du web
// $liste_pages_dictionnaire  est un tableau contenant la liste de toutes les pages du dictionnaire du web
//
// Exemple d'utilisation: nbdbcode($post, $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang));

function nbdbcode($post, $chemin, $liste_pages_encyclopedie, $liste_pages_dictionnaire)
{
  // Détermination de la langue utilisée
  $lang = (!isset($_SESSION['lang'])) ? 'FR' : $_SESSION['lang'];

  // Préparation du vocabulaire à utiliser
  $temp_lang_video_off = ($lang == 'FR') ? 'Cette vidéo est masquée (<a href="'.$chemin.'pages/user/privacy">options de vie privée</a>)' : 'This video is hidden (<a href="'.$chemin.'pages/user/privacy">privacy options</a>)';
  $temp_lang_video_off_small = ($lang == 'FR') ? 'Vidéo masquée (<a href="'.$chemin.'pages/user/privacy">options de vie privée</a>)' : 'Video hidden (<a href="'.$chemin.'pages/user/privacy">privacy options</a>)';
  $temp_lang_trends_off = ($lang == 'FR') ? 'Ce graphe Google trends est masqué (<a href="'.$chemin.'pages/user/privacy">options de vie privée</a>)' : 'This Google trends graph is hidden (<a href="'.$chemin.'pages/user/privacy">privacy options</a>)';

  // Est-ce qu'on floute ou non les contenus ?
  $floutage   = (niveau_nsfw() < 2) ? 'class="web_nsfw_flou"' : '';
  $floutage2  = (niveau_nsfw() < 2) ? 'class="web_nsfw_flou2"' : '';
  $floutage3  = (niveau_nsfw() < 1) ? ' web_nsfw_flou3' : '';

  // Détermination du niveau de vie privée demandé par l'utilisateur
  $niveau_vie_privee = niveau_vie_privee();

  // === Sous-titre ===
  $post = str_replace("=== ", "<span class=\"moinsgros gras texte_grisfonce\">", $post, $open);
  $post = str_replace(" ===", "</span>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</span>";
  }

  // == Titre ==
  $post = str_replace("== ", "<span class=\"gros gras texte_noir souligne\">", $post, $open);
  $post = str_replace(" ==", "</span>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</span>";
  }

  // [[web:page de l'encyclo du web|titre du lien]]
  preg_match_all('/\[\[web:(.*?)\|(.*?)\]\]/', $post, $resultats);
  $i = 0;
  foreach($resultats[0] as $pattern)
  {
    $temp_style = (in_array(changer_casse(html_entity_decode($resultats[1][$i], ENT_QUOTES), 'min'), $liste_pages_encyclopedie)) ? 'gras' : 'texte_negatif';
    $post = str_replace($pattern, '<a class="'.$temp_style.'" href="'.$chemin.'pages/nbdb/web?page='.$resultats[1][$i].'">'.$resultats[2][$i].'</a>', $post);
    $i++;
  }

  // [[dico:page du dico du web|titre du lien]]
  preg_match_all('/\[\[dico:(.*?)\|(.*?)\]\]/', $post, $resultats);
  $i = 0;
  foreach($resultats[0] as $pattern)
  {
    $temp_style = (in_array(changer_casse(html_entity_decode($resultats[1][$i], ENT_QUOTES), 'min'), $liste_pages_dictionnaire)) ? 'gras' : 'texte_negatif';
    $post = str_replace($pattern, '<a class="'.$temp_style.'" href="'.$chemin.'pages/nbdb/web_dictionnaire?define='.$resultats[1][$i].'">'.$resultats[2][$i].'</a>', $post);
    $i++;
  }

  // [[lien:http://www.lienexterne.com|description du lien]]
  $post = preg_replace('/\[\[lien:(.*?)\|(.*?)\]\]/i','<a href="$1">$2<img src="'.$chemin.'img/icones/lien_externe.svg" alt=" " height="14" style="padding: 0px 2px;"></a>', $post);

  // [[lien:http://www.lienexterne.com]]
  $post = preg_replace('/\[\[lien:(.*?)\]\]/i','<a href="$1">$1<img src="'.$chemin.'img/icones/lien_externe.svg" alt=" " height="14" style="padding: 0px 2px;"></a>', $post);

  // [[image:image.png|gauche|description de l'image]]
  $post = preg_replace('/\[\[image:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img src="'.$chemin.'img/nbdb_web/$1" alt="$1"></a>$3</div>', $post);

  // [[image:image.png|gauche]]
  $post = preg_replace('/\[\[image:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img src="'.$chemin.'img/nbdb_web/$1" alt="$1"></a></div>', $post);

  // [[image:image.png]]
  $post = preg_replace('/\[\[image:(.*?)\]\]/i','<a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img src="'.$chemin.'img/nbdb_web/$1" alt="$1"></a>', $post);

  // [[image-nsfw:image.png|gauche|description de l'image]]
  $post = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img '.$floutage2.' src="'.$chemin.'img/nbdb_web/$1" alt="$1"></a>$3</div>', $post);

  // [[image-nsfw:image.png|gauche]]
  $post = preg_replace('/\[\[image-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img '.$floutage2.' src="'.$chemin.'img/nbdb_web/$1" alt="$1"></a></div>', $post);

  // [[image-nsfw:image.png]]
  $post = preg_replace('/\[\[image-nsfw:(.*?)\]\]/i','<a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img '.$floutage.' src="'.$chemin.'img/nbdb_web/$1" alt="$1"></a>', $post);

  // [[youtube:urlyoutube|gauche|description de la vidéo]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[youtube:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $post);
  else
    $post = preg_replace('/\[\[youtube:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span><br><br>$3</div>', $post);

  // [[youtube:urlyoutube|gauche]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[youtube:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $post);
  else
    $post = preg_replace('/\[\[youtube:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $post);

  // [[youtube:urlyoutube]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[youtube:(.*?)\]\]/i','<div class="align_center"><iframe width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $post);
  else
    $post = preg_replace('/\[\[youtube:(.*?)\]\]/i','<div class="align_center"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $post);

  // [[youtube-nsfw:urlyoutube|gauche|description de la vidéo]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe '.$floutage2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>$3</div>', $post);
  else
    $post = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span><br><br>$3</div>', $post);

  // [[youtube-nsfw:urlyoutube|gauche]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><iframe '.$floutage2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $post);
  else
    $post = preg_replace('/\[\[youtube-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_flotteur web_flottement_$2"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $post);

  // [[youtube-nsfw:urlyoutube]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[youtube-nsfw:(.*?)\]\]/i','<div class="align_center"><iframe '.$floutage2.' width="560" height="315" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>', $post);
  else
    $post = preg_replace('/\[\[youtube-nsfw:(.*?)\]\]/i','<div class="align_center"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off.'</span></div>', $post);

  // [[galerie]][[/galerie]]
  $post = preg_replace('/\[\[galerie\]\](.*?)\[\[\/galerie\]\]/is','<div class="web_galerie">$1</div>', $post);

  // [[galerie:urlyoutube|youtube|légende]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[galerie:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><iframe width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="wyb_galerie_hr">$2</div>', $post);
  else
    $post = preg_replace('/\[\[galerie:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span><br><br>$2</div>', $post);

  // [[galerie:urlyoutube|youtube]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[galerie:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><iframe width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_galerie_hr"></div>', $post);
  else
    $post = preg_replace('/\[\[galerie:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span></div>', $post);

  // [[galerie:image.png|description de l'image]]
  $post = preg_replace('/\[\[galerie:(.*?)\|(.*?)\]\]/i','<div class="web_galerie_image"><div style="height:150px"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img src="'.$chemin.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div><hr class="web_galerie_hr">$2</div>', $post);

  // [[galerie:image.png]]
  $post = preg_replace('/\[\[galerie:(.*?)\]\]/i','<div class="web_galerie_image"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img src="'.$chemin.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div>', $post);

  // [[galerie-nsfw:urlyoutube|youtube|légende]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[galerie-nsfw:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><iframe '.$floutage2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_galerie_hr">$2</div>', $post);
  else
    $post = preg_replace('/\[\[galerie-nsfw:(.*?)\|youtube\|(.*?)\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span><br><br>$2</div>', $post);

  // [[galerie-nsfw:urlyoutube|youtube]]
  if(!$niveau_vie_privee['youtube'])
    $post = preg_replace('/\[\[galerie-nsfw:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><iframe '.$floutage2.' width="100%" src="https://www.youtube.com/embed/$1?rel=0&amp;showinfo=0&amp;iv_load_policy=3" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><hr class="web_galerie_hr"></div>', $post);
  else
    $post = preg_replace('/\[\[galerie-nsfw:(.*?)\|youtube\]\]/i','<div class="web_galerie_image"><a class="gras" href="https://www.youtube.com/watch?v=$1">NSFW! - YouTube: $1</a><br><span class="maigre">'.$temp_lang_video_off_small.'</span></div>', $post);

  // [[galerie-nsfw:image.png|description de l'image]]
  $post = preg_replace('/\[\[galerie-nsfw:(.*?)\|(.*?)\]\]/i','<div class="web_galerie_image"><div style="height:150px"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img '.$floutage2.' src="'.$chemin.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div><hr class="web_galerie_hr">$2</div>', $post);

  // [[galerie-nsfw:image.png]]
  $post = preg_replace('/\[\[galerie-nsfw:(.*?)\]\]/i','<div class="web_galerie_image"><a href="'.$chemin.'pages/nbdb/web_image?image=$1"><img '.$floutage2.' src="'.$chemin.'img/nbdb_web/$1" alt="$1" style="max-height:150px"></a></div>', $post);

  // [[trends:mot]]
  if(!$niveau_vie_privee['trends'])
    $post = preg_replace('/\[\[trends:(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $post);
  else
    $post = preg_replace('/\[\[trends:(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1">Google trends: $1</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $post);

  // [[trends2:mot|mot]]
  if(!$niveau_vie_privee['trends'])
    $post = preg_replace('/\[\[trends2:(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $post);
  else
    $post = preg_replace('/\[\[trends2:(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2">Google trends: $1, $2</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $post);

  // [[trends3:mot|mot|mot]]
  if(!$niveau_vie_privee['trends'])
    $post = preg_replace('/\[\[trends3:(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $post);
  else
    $post = preg_replace('/\[\[trends3:(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2,$3">Google trends: $1, $2, $3</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $post);

  // [[trends4:mot|mot|mot|mot]]
  if(!$niveau_vie_privee['trends'])
    $post = preg_replace('/\[\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $post);
  else
    $post = preg_replace('/\[\[trends4:(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4">Google trends: $1, $2, $3, $4</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $post);

  // [[trends5:mot|mot|mot|mot|mot]]
  if(!$niveau_vie_privee['trends'])
    $post = preg_replace('/\[\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1605_RC01/embed_loader.js"></script>
  <script type="text/javascript">
    trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"$1","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$2","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$3","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$4","geo":"","time":"2004-01-01 '.date('Y-m-d').'"},{"keyword":"$5","geo":"","time":"2004-01-01 '.date('Y-m-d').'"}],"category":0,"property":""}, {"exploreQuery":"date=all&q=$1,$2,$3,$4,$5","guestPath":"https://trends.google.com:443/trends/embed/"});
  </script>', $post);
  else
    $post = preg_replace('/\[\[trends5:(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)\]\]/i','<div class="align_center"><a class="moinsgros gras" href="https://trends.google.com/trends/explore?q=$1,$2,$3,$4,$5">Google trends: $1, $2, $3, $4, $5</a><br><span class="maigre">'.$temp_lang_trends_off.'</span></div>', $post);

  // [[copypasta=id]]Texte[[/copypasta]]
  $post = preg_replace('/\[\[copypasta\=(.*?)\]\](.*?)\[\[\/copypasta\]\]/is','<pre onclick="highlight(\'copypasta_$1\');" class="monospace spaced dowrap web_copypasta" id="copypasta_$1">$2</pre>', $post);

  // [[copypasta-nsfw=id]]Texte[[/copypasta-nsfw]]
  $post = preg_replace('/\[\[copypasta-nsfw\=(.*?)\]\](.*?)\[\[\/copypasta-nsfw\]\]/is','<pre onclick="highlight(\'copypasta_$1\');" class="monospace spaced dowrap web_copypasta'.$floutage3.'" id="copypasta_$1">$2</pre>', $post);

  // Et on renvoie la chaine traitée
  return $post;
}