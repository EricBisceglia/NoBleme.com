<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Génère un echo que seul Bad peut voir, afin de débug en live sur le serveur de prod quand c'est nécessaire
//
// Utilisation: bfdecho($stuff)

function bfdecho($stuff)
{
  if(isset($_SESSION['user']) && $_SESSION['user'] == 1)
    echo $stuff;
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
// Fonction envoyant un message privé type "message système" à un utilisateur à partir de son ID
//
// Utilisation: envoyer_notif($destinataire,$titre,$contenu,$silent);
//
// Si $sender est NULL, alors le message sera un message système
// Si $silent est set, alors le message sera considéré comme déjà lu

function envoyer_notif($en_destinataire,$en_titre,$en_contenu,$sender=NULL,$silent=NULL)
{
  // Préparation des données
  $en_date    = time();
  $en_titre   = $en_titre;
  $en_contenu = $en_contenu;

  // Message système ou pm
  $en_sender = 0;
  if($sender)
    $en_sender = $sender;

  // Notification silencieuse
  $en_consult = 0;
  if($silent)
    $en_consult = time();

  // Insertion des données
  query(" INSERT INTO   notifications
          SET           FKmembres_destinataire  = '$en_destinataire'  ,
                        FKmembres_envoyeur      = '$en_sender'        ,
                        date_envoi              = '$en_date'          ,
                        date_consultation       = '$en_consult'       ,
                        titre                   = '$en_titre'         ,
                        contenu                 = '$en_contenu'       ");
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
// Fonction générant un surnom aléatoire pour un unvité
//
// Utilisation: surnom_mignon();

function surnom_mignon()
{
  // Liste de mots (les adjectif1 doivent prendre un espace s'ils ne se collent pas au nom)
  $adjectif1 = array("Petit ", "Gros ", "Sale ", "Grand ", "Bel ", "Doux ", "L'", "Un ", "Cet ", "Ce ", "Premier ", "Gentil ", "Méchant ", "Bout d'", "Le ", "Capitaine ", "Quel ", "Saint ", "Chétif ", "Président ", "Général ", "Dernier ", "L'unique ", "Ex ", "Archi ", "Méga ", "Micro ", "Fort ", "Demi ", "Cadavre de ", "Âme d'", "Fils du ", "Futur ", "Second ", "Meta-");

  $nom = array("ours", "oiseau", "chat", "chien", "canard", "pigeon", "haricot", "arbre", "rongeur", "pot de miel", "indien", "gazon", "paysan", "crouton", "mollusque", "bouc", "éléphant", "sanglier", "journal", "singe", "cœur", "félin", "", "morse", "phoque", "miquet", "kévin", "monstre", "meuble", "frelon", "robot", "slip", "cousin", "frère", "internet", "type", "copain", "raton", "mouton", "VIP");

  $âdjectif2 = array("solitaire", "mignon", "moche", "farouche", "mystérieux", "con", "lourdingue", "glandeur", "douteux", "noir", "blanc", "rose", "mauve", "chaotique", "pâle", "raciste", "rigolo", "choupinet", "borgne", "douteux", "baltique", "fatigué", "", "peureux", "millénaire", "belge", "bouseux", "crade", "des champs", "urbain", "sourd", "techno", "fatigué", "cornu", "mort", "cool", "moelleux");

  // On assemble le surnom
  $surnom = $adjectif1[rand(0,(count($adjectif1)-1))].$nom[rand(0,(count($nom)-1))]." ".$âdjectif2[rand(0,(count($âdjectif2)-1))];

  // Et on balance la sauce
  return($surnom);
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
// Fonction renvoyant un ordre de priorité à partir d'une valeur entre 0 et 5
// Utilisé pour la liste des tâches
//
// Le paramètre optionnel permet de décider si on veut du style html ou non
//
// Utilisation: todo_importance($valeur,1);

function todo_importance($importance,$style=NULL)
{
  switch($importance)
  {
    case 5:
      if($style)
        $returnme = '<span class="gras souligne">Urgent</span>';
      else
        $returnme = 'Urgent';
    break;
    case 4:
      if($style)
        $returnme = '<span class="gras">Important</span>';
      else
        $returnme = 'Important';
    break;
    case 3:
      $returnme = 'À considérer';
    break;
    case 2:
      $returnme = 'Y\'a le temps';
    break;
    case 1:
      if($style)
        $returnme = '<span class="italique">Pas pressé</span>';
      else
        $returnme = 'Pas pressé';
    break;
    default:
      if($style)
        $returnme = '<span class="italique">À faire un jour</span>';
      else
        $returnme = 'À faire un jour';
  }
  return $returnme;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction envoyant un message qui sera broadcasté par le bot IRC NoBleme s'il est en ligne
//
// Le premier paramètre optionnel permet de spécifier un canal sur lequel écrire le message
// Le second paramètre optionnel autorise les codes de formattage de texte
//
// Utilisation: ircbot($chemin,"PRIVMSG #NoBleme :Bonjour !");
// Utilisation: ircbot($chemin,"Bonjour !","#NoBleme");

function ircbot($chemin,$message_irc,$canal_irc=NULL,$formattage=NULL)
{
  // On assainit le message
  $message_irc = str_replace("\\n", '', $message_irc);
  $message_irc = str_replace("\\r", '', $message_irc);
  $message_irc = str_replace("\\t", '', $message_irc);

  // On formatte le message si c'est autorisé
  if($formattage)
  {
    // Substitution des bytes de formattage
    $message_irc = str_replace('%O',chr(0x0f),$message_irc);        // Remise à zéro
    $message_irc = str_replace('%B',chr(0x02),$message_irc);        // Gras
    $message_irc = str_replace('%I',chr(0x1d),$message_irc);        // Italique
    $message_irc = str_replace('%U',chr(0x1f),$message_irc);        // Souligné
    $message_irc = str_replace('%C00',chr(0x03).'00',$message_irc); // Couleur : Blanc
    $message_irc = str_replace('%C01',chr(0x03).'01',$message_irc); // Couleur : Noir
    $message_irc = str_replace('%C02',chr(0x03).'02',$message_irc); // Couleur : Bleu
    $message_irc = str_replace('%C03',chr(0x03).'03',$message_irc); // Couleur : Vert
    $message_irc = str_replace('%C04',chr(0x03).'04',$message_irc); // Couleur : Rouge
    $message_irc = str_replace('%C05',chr(0x03).'05',$message_irc); // Couleur : Marron
    $message_irc = str_replace('%C06',chr(0x03).'06',$message_irc); // Couleur : Violet
    $message_irc = str_replace('%C07',chr(0x03).'07',$message_irc); // Couleur : Orange
    $message_irc = str_replace('%C08',chr(0x03).'08',$message_irc); // Couleur : Jaune
    $message_irc = str_replace('%C09',chr(0x03).'09',$message_irc); // Couleur : Vert clair
    $message_irc = str_replace('%C10',chr(0x03).'10',$message_irc); // Couleur : Bleu vert
    $message_irc = str_replace('%C11',chr(0x03).'11',$message_irc); // Couleur : Cyan clair
    $message_irc = str_replace('%C12',chr(0x03).'12',$message_irc); // Couleur : Bleu clair
    $message_irc = str_replace('%C13',chr(0x03).'13',$message_irc); // Couleur : Rose
    $message_irc = str_replace('%C14',chr(0x03).'14',$message_irc); // Couleur : Gris

    // Bytes de formattage personnalisés / combinés
    $message_irc = str_replace('%NB',chr(0x02).chr(0x03).'00,01',$message_irc);               // Fond noir, texte blanc gras
    $message_irc = str_replace('%TROLL',chr(0x1f).chr(0x02).chr(0x03).'08,13',$message_irc);  // Fond rose, texte jaune gras, souligné
  }

  // Si on peut écrire dans le fichier, on remplace son contenu par le message
  if($fichier_ircbot = fopen($chemin.'ircbot.txt', "a"))
  {
    if(!$canal_irc)
      file_put_contents($chemin.'ircbot.txt', time()." ".substr($message_irc,0,450).PHP_EOL, FILE_APPEND);
    else
      file_put_contents($chemin.'ircbot.txt', time()." PRIVMSG ".$canal_irc." :".substr($message_irc,0,450).PHP_EOL, FILE_APPEND);
    fclose($fichier_ircbot);
    return 1;
  }
  else
    return 0;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie une (ou aucune) propriété CSS correspondant à un menu de navigation du header, selon si l'option est sélectionnée ou non
//
// Le premier paramètre est l'option de menu actuellement sélectionnée
// Le second paramètre est l'option de menu dont on veut récupérer le CSS
// Le troisième paramètre est le type de menu (0 -> menu principal / 1 -> sous-menu / 2 -> menu latéral)
//
// Utilisation: menu_css($header_menu,'communaute',0)

function menu_css($menu_postdata, $menu_objet, $menu_type)
{
  // Si l'entrée est sélectionnée, on renvoie le CSS approprié
  if($menu_postdata == $menu_objet)
  {
    if($menu_type == 0)
      return ' menu_main_item_selected';
    else if($menu_type == 1)
      return ' menu_sub_item_selected';
    else if($menu_type == 2)
      return ' menu_side_item_selected';
  }

  // Si elle n'est pas sélectionnée, on ne renvoie rien, sauf dans le cas du menu secret
  else
  {
    if($menu_objet == 'secrets' && $menu_type == 0)
      return ' menu_main_item_secrets';
    else
      return '';
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insère une entrée dans la table activite, retourne l'id de l'activité qui vient d'être crée
//
// type_action                    est le le type d'action, pour son traitement dans pages/nobleme/activite
// log_moderation                 définit si c'est public (0) ou un log de modération (1)
// membre_id          (optionnel) est l'ID du membre lié à l'activité
// membre_pseudonyme  (optionnel) est le pseudonyme du membre lié à l'activité
// action_id          (optionnel) est l'id d'une table externe auquel l'action est lié
// action_titre       (optionnel) est le titre de l'action, pour son traitement dans pages/nobleme/activite
// action_parent      (optionnel) est un élément parent à l'action, pour son traitement dans pages/nobleme/activite
// justification      (optionnel) est la justification de l'action dans le log de modération
//
// Utilisation: activite_nouveau('truc_edit', 0, 0, 'Bad', 42, 'Le truc édité');

function activite_nouveau($type_action, $log_moderation, $membre_id=0, $membre_pseudonyme=NULL, $action_id=0, $action_titre=NULL, $action_parent=NULL, $justification=NULL)
{
  // On crée la nouvelle activité
  $timestamp = time();
  query(" INSERT INTO activite
          SET         activite.timestamp      = '$timestamp'          ,
                      activite.log_moderation = '$log_moderation'     ,
                      activite.FKmembres      = '$membre_id'          ,
                      activite.pseudonyme     = '$membre_pseudonyme'  ,
                      activite.action_type    = '$type_action'        ,
                      activite.action_id      = '$action_id'          ,
                      activite.action_titre   = '$action_titre'       ,
                      activite.parent         = '$action_parent'      ,
                      activite.justification  = '$justification'      ");

  // Puis on renvoie l'id de l'activité fraichement crée
  return(mysqli_insert_id($GLOBALS['db']));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insère une entrée dans la table activite_diff
//
// id                     est l'id de l'activité liée au diff
// titre                  est le titre du diff
// avant                  est le contenu qui était présent avant le diff
// apres      (optionnel) est le contenu qui en remplace un autre dans le diff
// optionnel  (optionnel) spécifie que le diff ne doit être crée que si le contenu d'après est différent du contenu d'avant
//
// Utilisation: $activite_id = activite_diff(1, 'Valeur', 3, 5, 1);

function activite_diff($id, $titre, $avant, $apres=NULL, $optionnel=NULL)
{
  // Si le contenu est trop grand, on ne crée pas de diff
  $apres = (strlen($apres) > 10000) ? NULL : $apres;

  // On crée le diff (si nécessaire)
  if(!$optionnel || $avant != $apres)
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$id'     ,
                        titre_diff  = '$titre'  ,
                        diff_avant  = '$avant'  ,
                        diff_apres  = '$apres'  ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Purge le contenu de la table activite_diff qui n'est lié à aucune entrée dans la table activite
//
// Utilisation: purger_diff_orphelins()

function purger_diff_orphelins()
{
  // On va chercher les orphelins
  $qorphelins = query(" SELECT    activite_diff.id AS 'd_id'
                        FROM      activite_diff
                        LEFT JOIN activite ON activite_diff.FKactivite = activite.id
                        WHERE     activite.id IS NULL ");

  // Et on les asphyxie discrètement
  while($dorphelins = mysqli_fetch_array($qorphelins))
  {
    $id_orphelin = $dorphelins['d_id'];
    query(" DELETE FROM activite_diff
            WHERE       activite_diff.id = '$id_orphelin' ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Supprime une entrée dans la table activite ainsi que toutes les entrées liées dans activite_diff
//
// type_action                    est le le type d'activité à supprimer
// log_moderation     (optionnel) définit si c'est public (0) ou un log de modération (1)
// membre_id          (optionnel) est l'ID du membre lié à l'activité à supprimer
// membre_pseudonyme  (optionnel) est le pseudonyme du membre lié à l'activité à supprimer
// action_id          (optionnel) est l'id d'une table externe à laquelle l'activité est lié
// type_action_tout   (optionnel) s'il est rempli, supprime toutes les actions de ce type
//
// Utilisation: activite_supprimer('truc_edit', 42);

function activite_supprimer($type_action, $log_moderation=0, $membre_id=0, $membre_pseudonyme=NULL, $action_id=0, $type_action_tout=0)
{
  // On construit la requête selon les paramètres qui sont remplis ou non
  $activite_supprimer    = "  DELETE FROM activite ";

  // Type d'action, englobant toutes les actions du type ou non
  if(!$type_action_tout)
    $activite_supprimer .= "  WHERE       activite.action_type    LIKE  '$type_action' ";
  else
    $activite_supprimer .= "  WHERE       activite.action_type    LIKE  '$type_action%' ";

  // Activité récente ou log de modération
  $activite_supprimer .= "    AND         activite.log_moderation =     '$log_moderation' ";

  // Autres paramètres
  if($membre_id)
    $activite_supprimer .= "  AND         activite.FKmembres      =     '$membre_id' ";
  if($membre_pseudonyme)
    $activite_supprimer .= "  AND         activite.pseudonyme     LIKE  '$membre_pseudonyme' ";
  if($action_id)
    $activite_supprimer .= "  AND         activite.action_id      =     '$action_id' ";

  // On supprime l'activité
  query($activite_supprimer);

  // Et on envoie une purge des diffs potentiellement orphelins suite à la suppression
  purger_diff_orphelins();
}