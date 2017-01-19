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
// Exemple d'utilisation: bbcode($post)

function bbcode($post)
{
  // Fix temporaire pour les XSS gratuits.
  // Il faut vraiment que je trouve mieux que ça comme solution... Franchement, si quelqu'un a une solution, je suis preneur.
  $post = str_replace(".svg",".&zwnj;svg",$post);       # Je ne veux pas de SVG, c'est exploitable avec CDATA
  $post = str_replace("xmlns","xmlns&zwnj;",$post);     # Troll XMLNS
  $post = str_replace("onclick","onclick&zwnj;",$post); # Bon bah on va gérer à la main tous les events JS pour le moment... ffffff
  $post = str_replace("oncontextmenu","oncontextmenu&zwnj;",$post);
  $post = str_replace("ondblclick","ondblclick&zwnj;",$post);
  $post = str_replace("onmousedown","onmousedown&zwnj;",$post);
  $post = str_replace("onmouseenter","onmouseenter&zwnj;",$post);
  $post = str_replace("onmouseleave","onmouseleave&zwnj;",$post);
  $post = str_replace("onmousemove","onmousemove&zwnj;",$post);
  $post = str_replace("onmouseover","onmouseover&zwnj;",$post);
  $post = str_replace("onmouseout","onmouseout&zwnj;",$post);
  $post = str_replace("onmouseup","onmouseup&zwnj;",$post);
  $post = str_replace("onkeydown","onkeydown&zwnj;",$post);
  $post = str_replace("onkeypress","onkeypress&zwnj;",$post);
  $post = str_replace("onkeyup","onkeyup&zwnj;",$post);
  $post = str_replace("onabort","onabort&zwnj;",$post);
  $post = str_replace("onbeforeunload","onbeforeunload&zwnj;",$post);
  $post = str_replace("onerror","onerror&zwnj;",$post);
  $post = str_replace("onhashchange","onhashchange&zwnj;",$post);
  $post = str_replace("onload","onload&zwnj;",$post);
  $post = str_replace("onpageshow","onpageshow&zwnj;",$post);
  $post = str_replace("onpagehide","onpagehide&zwnj;",$post);
  $post = str_replace("onresize","onresize&zwnj;",$post);
  $post = str_replace("onscroll","onscroll&zwnj;",$post);
  $post = str_replace("onunload","onunload&zwnj;",$post);
  $post = str_replace("onblur","onblur&zwnj;",$post);
  $post = str_replace("onchange","onchange&zwnj;",$post);
  $post = str_replace("onfocus","onfocus&zwnj;",$post);
  $post = str_replace("onfocusin","onfocusin&zwnj;",$post);
  $post = str_replace("onfocusout","onfocusout&zwnj;",$post);
  $post = str_replace("oninput","oninput&zwnj;",$post);
  $post = str_replace("oninvalid","oninvalid&zwnj;",$post);
  $post = str_replace("onreset","onreset&zwnj;",$post);
  $post = str_replace("onsearch","onsearch&zwnj;",$post);
  $post = str_replace("onselect","onselect&zwnj;",$post);
  $post = str_replace("onsubmit","onsubmit&zwnj;",$post);
  $post = str_replace("ondrag","ondrag&zwnj;",$post);
  $post = str_replace("ondragend","ondragend&zwnj;",$post);
  $post = str_replace("ondragenter","ondragenter&zwnj;",$post);
  $post = str_replace("ondragleave","ondragleave&zwnj;",$post);
  $post = str_replace("ondragover","ondragover&zwnj;",$post);
  $post = str_replace("ondragstart","ondragstart&zwnj;",$post);
  $post = str_replace("ondrop","ondrop&zwnj;",$post);
  $post = str_replace("oncopy","oncopy&zwnj;",$post);
  $post = str_replace("oncut","oncut&zwnj;",$post);
  $post = str_replace("onpaste","onpaste&zwnj;",$post);
  $post = str_replace("onafterprint","onafterprint&zwnj;",$post);
  $post = str_replace("onbeforeprint","onbeforeprint&zwnj;",$post);
  $post = str_replace("onabort","onabort&zwnj;",$post);
  $post = str_replace("oncanplay","oncanplay&zwnj;",$post);
  $post = str_replace("oncanplaythrough","oncanplaythrough&zwnj;",$post);
  $post = str_replace("ondurationchange","ondurationchange&zwnj;",$post);
  $post = str_replace("onemptied","onemptied&zwnj;",$post);
  $post = str_replace("onended","onended&zwnj;",$post);
  $post = str_replace("onloadeddata","onloadeddata&zwnj;",$post);
  $post = str_replace("onloadedmetadata","onloadedmetadata&zwnj;",$post);
  $post = str_replace("onloadstart","onloadstart&zwnj;",$post);
  $post = str_replace("onpause","onpause&zwnj;",$post);
  $post = str_replace("onplay","onplay&zwnj;",$post);
  $post = str_replace("onplaying","onplaying&zwnj;",$post);
  $post = str_replace("onprogress","onprogress&zwnj;",$post);
  $post = str_replace("onratechange","onratechange&zwnj;",$post);
  $post = str_replace("onseeked","onseeked&zwnj;",$post);
  $post = str_replace("onseeking","onseeking&zwnj;",$post);
  $post = str_replace("onstalled","onstalled&zwnj;",$post);
  $post = str_replace("onsuspend","onsuspend&zwnj;",$post);
  $post = str_replace("ontimeupdate","ontimeupdate&zwnj;",$post);
  $post = str_replace("onvolumechange","onvolumechange&zwnj;",$post);
  $post = str_replace("onwaiting","onwaiting&zwnj;",$post);
  $post = str_replace("animationend","animationend&zwnj;",$post);
  $post = str_replace("animationiteration","animationiteration&zwnj;",$post);
  $post = str_replace("animationstart","animationstart&zwnj;",$post);
  $post = str_replace("transitionend","transitionend&zwnj;",$post);
  $post = str_replace("onmessage","onmessage&zwnj;",$post);
  $post = str_replace("onopen","onopen&zwnj;",$post);
  $post = str_replace("ononline","ononline&zwnj;",$post);
  $post = str_replace("onoffline","onoffline&zwnj;",$post);
  $post = str_replace("onpopstate","onpopstate&zwnj;",$post);
  $post = str_replace("onmousewheel","onmousewheel&zwnj;",$post);
  $post = str_replace("onshow","onshow&zwnj;",$post);
  $post = str_replace("onstorage","onstorage&zwnj;",$post);
  $post = str_replace("ontoggle","ontoggle&zwnj;",$post);
  $post = str_replace("onwheel","onwheel&zwnj;",$post);
  $post = str_replace("ontouchcancel","ontouchcancel&zwnj;",$post);
  $post = str_replace("ontouchend","ontouchend&zwnj;",$post);
  $post = str_replace("ontouchmove","ontouchmove&zwnj;",$post);
  $post = str_replace("ontouchstart","ontouchstart&zwnj;",$post);

  // [b]Gras[/b]
  $post = str_replace("[b]", "<b>", $post, $open);
  $post = str_replace("[/b]", "</b>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</b>";
  }

  // [i]Italique[/i]
  $post = str_replace("[i]", "<i>", $post, $open);
  $post = str_replace("[/i]", "</i>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</i>";
  }

  // [u]Underline[/u]
  $post = str_replace("[u]", "<u>", $post, $open);
  $post = str_replace("[/u]", "</u>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</u>";
  }

  // [s]Strikethrough[/s]
  $post = str_replace("[s]", "<s>", $post, $open);
  $post = str_replace("[/s]", "</s>", $post, $close);
  if($open > $close)
  {
    for($i=0;$i<($open-$close);$i++)
      $post.="</s>";
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
  $post = preg_replace('/\[url\](.*?)\[\/url\]/is','<a class="dark" href="$1">$1</a>', $post);

  // [url=http://www.url.com]Lien[/url]
  $post = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/is','<a class="dark" href="$1">$2</a>', $post);

  // [img]http://www.image.com/image.jpg[/img]
  $post = preg_replace('/\[img\](.*?)\[\/img\]/is','<img class="bbcodeimg" src="$1" alt="">', $post);

  // [align=left/center/right]Texte aligné[/align]
  $post = preg_replace('/\[align\=(left|center|right)\](.*?)\[\/align\]/is','<div style="text-align: $1;">$2</div>', $post);

  // [color=#CACACA]Texte coloré[/color]
  $post = preg_replace('/\[color\=(.*?)\](.*?)\[\/color\]/is','<span style="color: $1;">$2</span>', $post);

  // [size=2]Grand texte[/size]
  $post = preg_replace('/\[size\=(.*?)\](.*?)\[\/size\]/is','<span style="font-size: $1em;">$2</span>', $post);

  // [code]Bloc de code[/code]
  $post = preg_replace('/\[code\](.*?)\[\/code\]/is','<pre class="monospace wrap">$1</pre>', $post);

  // [quote]Citation[/quote]
  while(preg_match('/\[quote\](.*?)\[\/quote\]/is',$post))
    $post = preg_replace('/\[quote\](.*?)\[\/quote\]/is',"<div class=\"citation_corps\"><div class=\"citation_titre\">Citation :</div>$1</div>", $post);

  // [quote=Machin]Citation par Machin[/quote]
  while(preg_match('/\[quote=(.*?)\](.*?)\[\/quote\]/is',$post))
    $post = preg_replace('/\[quote=(.*?)\](.*?)\[\/quote\]/is',"<div class=\"citation_corps\"><div class=\"citation_titre\">Citation de $1 :</div>$2</div>", $post);

  // [spoiler]Contenu caché[/spoiler]
  $post = preg_replace("/\[spoiler\]((\s|.)+?)\[\/spoiler\]/", "<div class=\"spoiler_corps\"><div class=\"spoiler_titre\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = 'SPOILER : <a class=\'dark blank gras\' href=\'#\' onclick=\'return false;\'>CLIQUEZ ICI POUR MASQUER LE CONTENU DU SPOILER</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = 'SPOILER : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>CLIQUEZ ICI POUR VOIR LE CONTENU DU SPOILER</a>'; }\">SPOILER : <a href=\"#\" class=\"dark blank gras\" onclick=\"return false;\">CLIQUEZ ICI POUR VOIR LE CONTENU DU SPOILER</a></span></div><div><div style=\"display: none; font-size: 0.75em;\">$1</div></div></div><noscript><div class=\"erreur alinea gras texte_blanc\">JavaScript est requis pour voir le contenu du spoiler</div></noscript>", $post);

  // [spoiler=titre]Contenu caché[/spoiler]
  $post = preg_replace("/\[spoiler=(.*?)\]((\s|.)+?)\[\/spoiler\]/", "<div class=\"spoiler_corps\"><div class=\"spoiler_titre\"><span onclick=\"if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerHTML = '$1 : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>CLIQUEZ ICI POUR MASQUER LE CONTENU DU SPOILER</a>'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerHTML = '$1 : <a href=\'#\' class=\'dark blank gras\' onclick=\'return false;\'>CLIQUEZ ICI POUR VOIR LE CONTENU DU SPOILER</a>'; }\">$1 : <a href=\"#\" class=\"dark blank gras\" onclick=\"return false;\">CLIQUEZ ICI POUR VOIR LE CONTENU DU SPOILER</a></span></div><div><div style=\"display: none; font-size: 0.75em;\">$2</div></div></div><noscript><div class=\"erreur alinea gras texte_blanc\">JavaScript est requis pour voir le contenu du spoiler</div></noscript>", $post);

  // [flou]Contenu floué[/flou]
  $post = preg_replace('/\[flou\](.*?)\[\/flou\]/is','<pre class="flou">$1</pre>', $post);


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
    for ($i=0 ; $i<($longueur-$count_base) ; $i++)
      $chemin .= "../";
  }

  // Emotes
  $post = str_replace(":&quot;)", '<img src="'.$chemin.'img/emotes/honte.png" alt="honte">', $post);
  $post = str_replace(':")', '<img src="'.$chemin.'img/emotes/honte.png" alt="honte">', $post);
  $post = str_replace(":#", '<img src="'.$chemin.'img/emotes/honte.png" alt="honte">', $post);
  $post = str_replace("):C", '<img src="'.$chemin.'img/emotes/mecontent.png" alt="mécontent">', $post);
  $post = str_replace("):(", '<img src="'.$chemin.'img/emotes/colere.png" alt="colère">', $post);
  $post = str_replace(":&quot;(", '<img src="'.$chemin.'img/emotes/pleure.png" alt="pleure">', $post);
  $post = str_replace(':"(', '<img src="'.$chemin.'img/emotes/pleure.png" alt="pleure">', $post);
  $post = str_replace(":'(", '<img src="'.$chemin.'img/emotes/pleure.png" alt="pleure">', $post);
  $post = str_replace(":(", '<img src="'.$chemin.'img/emotes/triste.png" alt="triste">', $post);
  $post = str_replace("XD", '<img src="'.$chemin.'img/emotes/rire.png" alt="rire">', $post);
  $post = str_replace("xD", '<img src="'.$chemin.'img/emotes/rire.png" alt="rire">', $post);
  $post = str_replace(":O", '<img src="'.$chemin.'img/emotes/surprise.png" alt="surprise">', $post);
  $post = str_replace(":o", '<img src="'.$chemin.'img/emotes/surprise.png" alt="surprise">', $post);
  $post = str_replace(":s", '<img src="'.$chemin.'img/emotes/gene.png" alt="gêné">', $post);
  $post = str_replace(":S", '<img src="'.$chemin.'img/emotes/gene.png" alt="gêné">', $post);
  $post = str_replace(":p", '<img src="'.$chemin.'img/emotes/coquin.png" alt="coquin">', $post);
  $post = str_replace(":P", '<img src="'.$chemin.'img/emotes/coquin.png" alt="coquin">', $post);
  $post = str_replace(":DD", '<img src="'.$chemin.'img/emotes/jouissif.png" alt="jouissif">', $post);
  $post = str_replace(";-)", '<img src="'.$chemin.'img/emotes/complice.png" alt="complice">', $post);
  $post = str_replace(":)", '<img src="'.$chemin.'img/emotes/sourire.png" alt="sourire">', $post);
  $post = str_replace("9_9", '<img src="'.$chemin.'img/emotes/reveur.png" alt="rêveur">', $post);
  $post = str_replace(":|", '<img src="'.$chemin.'img/emotes/blase.png" alt="Blasé">', $post);
  $post = str_replace(":D", '<img src="'.$chemin.'img/emotes/heureux.png" alt="heureux">', $post);
  $post = str_replace("o_O", '<img src="'.$chemin.'img/emotes/perplexe3.png" alt="perplexe">', $post);
  $post = str_replace("B)", '<img src="'.$chemin.'img/emotes/cool.png" alt="cool">', $post);
  $post = str_replace("o_o", '<img src="'.$chemin.'img/emotes/perplexe1.png" alt="perplexe">', $post);
  $post = str_replace("O_O", '<img src="'.$chemin.'img/emotes/perplexe1.png" alt="perplexe">', $post);
  $post = str_replace("O_o", '<img src="'.$chemin.'img/emotes/perplexe2.png" alt="perplexe">', $post);

  // Et on renvoie la chaine traitée
  return $post;
}