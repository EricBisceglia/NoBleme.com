<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Définition des valeurs en français en toutes lettres

// Jours de la semaine
$joursfr = array( "Dimanche"  ,
"Lundi"     ,
"Mardi"     ,
"Mercredi"  ,
"Jeudi"     ,
"Vendredi"  ,
"Samedi"    );

// Mois de l'année
$moisfr = array(  ""            ,
"Janvier"     ,
"Février"     ,
"Mars"        ,
"Avril"       ,
"Mai"         ,
"Juin"        ,
"Juillet"     ,
"Ao&ucirc;t"  ,
"Septembre"   ,
"Octobre"     ,
"Novembre"    ,
"Décembre"    );

// Mois de l'année, court
$moisfr_courts = array( "",
      "Jan.",
      "Fév.",
      "Mars",
      "Avr.",
      "Mai",
      "Juin",
      "Juil.",
      "Août",
      "Sept.",
      "Oct.",
      "Nov.",
      "Déc.");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défintion de la date du jour en toutes lettres
//
// Exemple d'utilisation:
// echo 'Nous sommes le' . $datefr ;

$datefr = $joursfr[date("w")]." ".date("j")." ".strtolower($moisfr[date("n")])." ".date("Y");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de conversion d'une date mysql vers une date en toutes lettres
//
// Le second paramètre, optionnel, contrôle la langue
//
// Exemple d'utilisation
// $ma_date = datefr($date_a_convertir);

function datefr($date, $lang="FR")
{
// Si c'est un timestamp, on le convertit
if(is_numeric($date))
$date = date('Y-m-d', $date);

// En anglais c'est simple
if($lang != 'FR')
return date('l F j, Y', strtotime($date));

// En français, moins
else
{
// Jours de la semaine en toutes lettres
$joursfr = array( "Dimanche"  ,
    "Lundi"     ,
    "Mardi"     ,
    "Mercredi"  ,
    "Jeudi"     ,
    "Vendredi"  ,
    "Samedi"    );

// Mois de l'année en toutes lettres
$moisfr = array(  ""            ,
    "Janvier"     ,
    "Février"     ,
    "Mars"        ,
    "Avril"       ,
    "Mai"         ,
    "Juin"        ,
    "Juillet"     ,
    "Ao&ucirc;t"  ,
    "Septembre"   ,
    "Octobre"     ,
    "Novembre"    ,
    "Décembre"    );

// Conversion de la date en toutes lettres
$date_text  = $joursfr[date("w", strtotime($date))]." ";
$date_text .= (date("j", strtotime($date)) == '1') ? date("j", strtotime($date))."er " : date("j", strtotime($date))." ";
$date_text .= $moisfr[date("n", strtotime($date))]." ";
$date_text .= date("Y", strtotime($date));

// Renvoi de la valeur
return $date_text;
}
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de conversion d'une date mysql vers une date en toutes lettres, ne renvoie pas de nom de jour
//
// Le second paramètre, optionnel, contrôle la langue
// Le troisième paramètre, optionnel, retire le numéro du jour
//
// Exemple d'utilisation
// $ma_date = jourfr($date_a_convertir,1);

function jourfr($date, $lang="FR", $stripday=NULL)
{
// Si c'est un timestamp, on le convertit
if(is_numeric($date))
$date = date('Y-m-d', $date);

// En anglais c'est simple
if($lang != 'FR')
{
if(!$stripday)
return date('F j, Y', strtotime($date));
else
return date('F Y', strtotime($date));
}

// En français, moins
else
{
// Mois de l'année en toutes lettres
$moisfr = array(  ""            ,
      "Janvier"     ,
      "Février"     ,
      "Mars"        ,
      "Avril"       ,
      "Mai"         ,
      "Juin"        ,
      "Juillet"     ,
      "Août"        ,
      "Septembre"   ,
      "Octobre"     ,
      "Novembre"    ,
      "Décembre"    );

if(!$stripday)
{
// Conversion de la date en toutes lettres
$date_text = date("j", strtotime($date))." ".$moisfr[date("n", strtotime($date))]." ".date("Y", strtotime($date));

// Transformer 1 en 1er
if(substr($date_text,0,2) == '1 ')
$date_text = '1er '.substr($date_text,1);
}
else
{
// Conversion de la date en toutes lettres
$date_text = $moisfr[date("n", strtotime($date))]." ".date("Y", strtotime($date));
}

// Renvoi de la valeur
return $date_text;
}
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de conversion d'une date mysql vers une date DD/MM/YY
//
// Exemple d'utilisation
// $ma_date = ddmmyy($date_a_convertir);

function ddmmyy($date)
{
// Si la date est NULL ou 0000-00-00 on ne renvoie rien
if(!$date || $date == '0000-00-00')
return NULL;

// Conversion de la date en toutes lettres
$date_ddmmyy = date('d/m/y',strtotime($date));

// Renvoi de la valeur
return $date_ddmmyy;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de conversion d'une date DD/MM/YY ou DD/MM/YYYY vers une date MYSQL
//
// Exemple d'utilisation
// $ma_date_mysql = mysqldate("19/03/2005");

function mysqldate($date)
{
// Format DD/MM/YYYY
if(strlen($date) == 10)
$date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));

// Format DD/MM/YY
else if(strlen($date) == 8)
$date = date('Y-m-d', strtotime(substr($date,6,2).'-'.substr($date,3,2).'-'.substr($date,0,2)));

// Sinon, on renvoie une date vide
else
return '0000-00-00';

// On gère le cas 1970-01-01
if($date == '1970-01-01')
return '0000-00-00';
else
return $date;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ancienneté d'une action : Renvoie de quand date l'action en toutes lettres
//
// Paramètres:
// $date est un timestamp
// $lang est la langue à utiliser (français par défaut)
//
// Exemple d'utilisation :
// $anciennete = ilya($timestamp,"FR");

function ilya($date, $lang="FR")
{
// Calcul de la différence de temps entre la date et aujourd'hui
$diff = time() - $date;

// Définition en toutes lettres de la différence de temps
if($diff < 0)
$ilya = ($lang == 'FR') ? "Dans le futur" : "In the future";
else if ($diff == 0)
$ilya = ($lang == 'FR') ? "En ce moment même" : "Right now";
else if ($diff == 1)
$ilya = ($lang == 'FR') ? "Il y a 1 seconde" : "A second ago";
else if ($diff <= 60)
$ilya = ($lang == 'FR') ? "Il y a ".$diff." secondes" : $diff." seconds ago";
else if ($diff <= 120)
$ilya = ($lang == 'FR') ? "Il y a 1 minute" : "A minute ago";
else if ($diff <= 3600)
$ilya = ($lang == 'FR') ? "Il y a ".floor($diff/60)." minutes" : floor($diff/60)." minutes ago";
else if ($diff <= 7200)
$ilya = ($lang == 'FR') ? "Il y a 1 heure": "An hour ago";
else if ($diff <= 86400)
$ilya = ($lang == 'FR') ? "Il y a ".floor($diff/3600)." heures" : floor($diff/3600)." hours ago";
else if ($diff <= 172800)
$ilya = ($lang == 'FR') ? "Hier" : "Yesterday";
else if ($diff <= 259200)
$ilya = ($lang == 'FR') ? "Avant-hier" : floor($diff/86400)." days ago";
else if ($diff <= 31536000)
$ilya = ($lang == 'FR') ? "Il y a ".floor($diff/86400)." jours" : floor($diff/86400)." days ago";
else if ($diff <= 63072000)
$ilya = ($lang == 'FR') ? "L'année dernière" : "A year ago";
else if ($diff <= 3153600000)
$ilya = ($lang == 'FR') ? "Il y a ".floor($diff/31536000)." ans" : floor($diff/31536000)." years ago";
else if ($diff <= 6307200000)
$ilya = ($lang == 'FR') ? "... le siècle dernier ? ö_O" : "... a century ago ? ö_O";
else
$ilya = ($lang == 'FR') ? "Fixe ton code mon vieux, il est complètement pété" : "Fix your code my friend, it is broken af";

// Et on renvoie la phrase
return $ilya;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Temps à venir avant une action : Prend un timestamp en paramètre, renvoie quand aura lieu l'action en toutes lettres
//
// Paramètres:
// $date est un timestamp
// $lang est la langue à utiliser (français par défaut)
//
// Exemple d'utilisation :
// $anciennete = dans($timestamp,"FR");

function dans($date, $lang="FR")
{
// Calcul de la différence de temps entre aujourd'hui et la date
$diff = $date - time();

// Définition en toutes lettres de la différence de temps
if ($diff < 0)
$dans = ($lang == 'FR') ? "Dans le passé" : "In the past";
else if ($diff == 0)
$dans = ($lang == 'FR') ? "En ce moment même" : "Right now";
else if ($diff == 1)
$dans = ($lang == 'FR') ? "Dans 1 seconde" : "In 1 second";
else if ($diff < 60)
$dans = ($lang == 'FR') ? "Dans ".$diff." secondes" : "In ".$diff." seconds";
else if ($diff < 120)
$dans = ($lang == 'FR') ? "Dans 1 minute" : "In 1 minute";
else if ($diff < 3600)
$dans = ($lang == 'FR') ? "Dans ".floor($diff/60)." minutes" : "In ".floor($diff/60)." minutes";
else if ($diff < 7200)
$dans = ($lang == 'FR') ? "Dans 1 heure" : "In 1 hour";
else if ($diff < 172800)
$dans = ($lang == 'FR') ? "Dans ".floor($diff/3600)." heures" : "In ".floor($diff/3600)." hours";
else if ($diff < 31536000)
$dans = ($lang == 'FR') ? "Dans ".(floor($diff/86400)+1)." jours" : "In ".(floor($diff/86400)+1)." days";
else if ($diff < 63072000)
$dans = ($lang == 'FR') ? "Dans plus d'un an" : "In more than a year";
else if ($diff < 3153600000)
$dans = ($lang == 'FR') ? "Dans ".floor($diff/31536000)." ans" : "In ".floor($diff/31536000)." years";
else if ($diff < 6307200000)
$dans = ($lang == 'FR') ? "Le siècle prochain" : "Next century";
else
$dans = ($lang == 'FR') ? "Dans très très longtemps" : "In a very very long time";

// Et on renvoie la phrase
return $dans;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Arrête le processus de la page abruptement si elle n'est pas appelée par la fonction js dynamique();
//
// Utilisation: xhronly();

function xhronly()
{
  if(!isset($_SERVER['HTTP_DYNAMIQUE']))
    exit();
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détecte si la page est appelée par du XHR ou non
//
// Utilisation: getxhr();

function getxhr()
{
  return (isset($_SERVER['HTTP_DYNAMIQUE'])) ? 1 : 0;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tronque une chaine de caractères pour n'en garder que le début (et optionnellement rajouter quelque chose au niveau de la troncature)
// $chaine est la chaine de caractères à tronquer
// $longueur est le nombre de caractères à conserver dans la chaine
// $suffixe est le contenu à rajouter à la fin de la chaine tronquée
//
// Exemple d'utilisation :
// $titrecourt = tronquer_chaine($titre,20,'...');

function tronquer_chaine($chaine,$longueur,$suffixe='')
{
  return (mb_strlen($chaine,'UTF-8') > $longueur) ? mb_substr($chaine,0,$longueur,'UTF-8').$suffixe : $chaine;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction changeant la casse d'une chaine de caractères sans massacrer l'encodage
// $chaine est la chaine de caractères à manipuler
// $action est l'action à effectuer: 'maj' pour des majuscules, 'min' pour des minuscules, 'init' pour la première lettre en majuscules
//
// Utilisation: changer_casse('Test accentué','maj');

function changer_casse($chaine,$action)
{
  if($action == 'maj')
    return mb_convert_case($chaine, MB_CASE_UPPER, "UTF-8");
  else if($action == 'min')
    return mb_convert_case($chaine, MB_CASE_LOWER, "UTF-8");
  else if($action == 'init')
    return mb_substr(mb_convert_case($chaine, MB_CASE_UPPER, "UTF-8"),0,1,'utf-8').mb_substr($chaine,1,65536,'utf-8');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction inverse de nl2br (transforme les line breaks en retours ligne)
//
// Utilisation: br2ln($string);

function br2ln($contenu)
{
  $contenu = str_replace('<br>',"\n",$contenu);
  $contenu = str_replace('<br/>',"\n",$contenu);
  $contenu = str_replace('<br />',"\n",$contenu);
  $contenu = str_replace('</br>',"\n",$contenu);
  return $contenu;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction remplaçant les caractères interdits dans les balises meta par leur équivalent ISO HTML
//
// Utilisation: meta_fix($string);

function meta_fix($meta_desc)
{
  $meta_desc = str_replace("'","&#39;",$meta_desc);
  $meta_desc = str_replace("\"","&#34;",$meta_desc);
  $meta_desc = str_replace("<","&#60;",$meta_desc);
  $meta_desc = str_replace(">","&#62;",$meta_desc);
  $meta_desc = str_replace("{","&#123;",$meta_desc);
  $meta_desc = str_replace("}","&#125;",$meta_desc);
  $meta_desc = str_replace("[","&#91;",$meta_desc);
  $meta_desc = str_replace("]","&#93;",$meta_desc);
  $meta_desc = str_replace("(","&#40;",$meta_desc);
  $meta_desc = str_replace(")","&#41;",$meta_desc);

  return $meta_desc;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction détruisant les balises html histoire de pas se faire xsser la gueule à volonté
// Transorme également :amp: en ampersands pour contrecarrer le passage de postdata en js
//
// Utilisation: destroy_html($string);

function destroy_html($ravage)
{
  // On détruit le HTML
  $ravage = htmlentities($ravage);

  // Transformation des :amp: en & pour le xhr
  $ravage = str_replace(":amp:","&",$ravage);

  // Nettoyage de base
  $ravage = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $ravage);
  $ravage = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $ravage);
  $ravage = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $ravage);
  $ravage = html_entity_decode($ravage, ENT_COMPAT, 'UTF-8');

  // On ne veut pas de propriétés qui commencent par on ou xmlns
  $ravage = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $ravage);

  // On gère les protocoles javascript et jvscript
  $ravage = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $ravage);
  $ravage = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $ravage);
  $ravage = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $ravage);

  // Pour gérer des problèmes causés par IE
  $ravage = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $ravage);
  $ravage = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $ravage);
  $ravage = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $ravage);

  return $ravage;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un nombre avec le bon signe
//
// Exemple d'utilisation :
// $nombre_signed = signe_nombre($nombre)

function signe_nombre($nombre)
{
  if($nombre > 0)
    return '+'.$nombre;
  else
    return $nombre;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un style css en fonction d'un contenu selon s'il est positif, neutre, ou négatif
// Si $hex est rempli, renvoie un hex de couleur au lieu d'une classe css
//
// Exemple d'utilisation :
// $couleur_contenu = format_positif($contenu);

function format_positif($contenu,$hex=NULL)
{
  if(!$hex)
  {
    if($contenu > 0)
      return 'positif';
    else if($contenu == 0)
      return 'neutre';
    else
      return 'negatif';
  }
  else
  {
    if($contenu > 0)
      return '339966';
    else if($contenu == 0)
      return 'EB8933';
    else
      return 'FF0000';
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Formatte un nombre selon plusieurs formats possibles
// $nombre est le nombre à formatter
// $format est le type de format à y appliquer
// Si $decimales est précisé, affiche ce nombre de décimales après la virgule (lorsque c'est possible)
// Si $signe est précisé, affiche le signe + si le nombre est positif
//
// Exemple d'utilisation :
// $prix = format_nombre($nombre,"prix")

function format_nombre($nombre,$format,$decimales=NULL,$signe=NULL)
{
  // Nombre de décimales (en option) pour les pourcentages et les points
  $decimales = (!is_null($decimales)) ? $decimales : 1;

  // Formater un prix
  if($format == "nombre")
    $format_nombre = number_format((float)$nombre, 0, ',', ' ');

  // Formater un prix
  if($format == "prix")
    $format_nombre = number_format((float)$nombre, 0, ',', ' ')." €";

  // Formater un prix avec centimes
  if($format == "centimes")
    $format_nombre = number_format((float)$nombre, 2, ',', ' ')." €";

  // Formater un pourcentage
  else if($format == "pourcentage")
    $format_nombre = number_format((float)$nombre, $decimales, ',', '')." %";

  // Formater un point de pourcentage
  else if($format == "point")
    $format_nombre = number_format((float)$nombre, $decimales, ',', '')." p%";

  // Application du signe si nécessaire
  if($signe && $nombre > 0)
    $format_nombre = '+'.$format_nombre;

  // On renvoie le résultat
  return $format_nombre;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Calcul le pourcentage qu'un nombre représente d'un autre nombre
// $nombre est le nombre qui est un pourcent du total
// $total est le total dont le nombre est un pourcent
// Si $croissance est rempli, calcule une croissance au lieu d'un pourcentage d'un nombre
//
// Exemple d'utilisation :
// $pourcentage = calcul_pourcentage($nombre,$total);

function calcul_pourcentage($nombre, $total, $croissance=NULL)
{
  if(!$croissance)
    return ($total) ? (($nombre/$total)*100) : 0;
  else
    return ($total) ? (($nombre/$total)*100)-100 : 0;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction renvoyant la différence entre deux arrays de strings
//
// Renvoie un array des différences, à utiliser avec la fonction diff()
//
// Inspiré de la méthode de diff par array de Paul Butler http://www.paulbutler.org/

function diff_raw($old, $new)
{
  $matrix = array();
  $maxlen = 0;
  foreach($old as $oindex => $ovalue){
    $nkeys = array_keys($new, $ovalue);
    foreach($nkeys as $nindex){
      $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
        $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
      if($matrix[$oindex][$nindex] > $maxlen){
        $maxlen = $matrix[$oindex][$nindex];
        $omax = $oindex + 1 - $maxlen;
        $nmax = $nindex + 1 - $maxlen;
      }
    }
  }
  if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
  return array_merge(
    diff_raw(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
    array_slice($new, $nmax, $maxlen),
    diff_raw(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
  );
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction renvoyant une différence formatée et lisible entre deux strings
//
// Utilisation: diff("Mon texte", "Nouveau texte");

function diff($old, $new)
{
  $return = '';
  $diff = diff_raw(preg_split("/[\s]+/", $old), preg_split("/[\s]+/", $new));
  foreach($diff as $k)
  {
    if(is_array($k))
        $return .= (!empty($k['d'])?"&nbsp;<del>&nbsp;".implode(' ',$k['d'])."&nbsp;</del>&nbsp;":'').(!empty($k['i'])?"&nbsp;<ins>&nbsp;".implode(' ',$k['i'])."&nbsp;</ins>&nbsp;":'');
    else
      $return .= $k . ' ';
  }
  return $return;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction cherchant un mot dans une chaîne de caractères et renvoyant un certain nombre de mots avant et après le mot trouvé
//
// Utilisation: search_wrap("canard", "Je suis un canard dans une phrase longue", 2);

function search_wrap($recherche, $texte, $nombre_mots_autour)
{
  $recherche = preg_quote($recherche, '/');
  $texte = preg_quote($texte, '/');
  // On commence par découper les mots en ignorant la casse
  $mots = preg_split('/\s+/u', changer_casse($texte, 'min'));

  // Si on trouve le mot dans la phrase, on récupère sa position
  $recuperation_mots  = preg_grep("/".changer_casse($recherche, 'min').".*/", $mots);
  $position_mots      = array_keys($recuperation_mots);

  // Puis on reprend les mots dans leur forme réelle
  $mots = preg_split('/\s+/u', $texte);

  // Si on a repéré le mot, on met sa première occurence dans une variable
  if(count($position_mots))
    $position = $position_mots[0];

  // Puis on récupère tout ce qui vient avant/après
  if (isset($position))
  {
    // D'abord on a besoin des positions de début et de fin selon le nombre de mots qu'on veut récupérer
    $debut  = (($position - $nombre_mots_autour) > 0) ? $position - $nombre_mots_autour : 0;
    $fin    = ((($position + ($nombre_mots_autour + 1)) < count($mots)) ? $position + ($nombre_mots_autour + 1) : count($mots)) - $debut;

    // Ensuite on découpe les mots en un tableau
    $slice  = array_slice($mots, $debut, $fin);

    // On met des ... au début et à la fin du tableau si nécessaire
    $debut  = ($debut > 0) ? "..." : "";
    $fin    = ($position + ($nombre_mots_autour + 1) < count($mots)) ? "..." : "";

    // Puis on assemble ce tableau en une chaine de caractères qu'on renvoie
    return stripslashes($debut.implode(' ', $slice).$fin);
  }

  // Si on a été perdu à une étape, on renvoie rien
  else
    return "";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction appliquant du HTML autour de toutes les occurences d'un mot particulier dans une chaine de caractères
//
// Utilisation: html_autour("canard", "Je suis un canard dans une phrase", '<span class="gras">', "</span>");

function html_autour($recherche, $texte, $html_avant, $html_apres)
{
  $recherche = preg_quote($recherche, '/');
  $texte = preg_quote($texte, '/');
  return stripslashes(preg_replace("/($recherche)/i", "$html_avant$1$html_apres", $texte));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remplace les lettres accentuées d'une chaine de caractères par leur équivalent non accentué
//
// Utilisation: remplacer_accents('Évangélisme');

function remplacer_accents($chaine)
{
  // On dénifinit de façon complètement stupide les caractères à remplacer
  $accents    = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
  $noaccents  = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

  // Puis on renvoie la chaine modifiée
  return str_replace($accents, $noaccents, $chaine);
}