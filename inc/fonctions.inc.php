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
// Fonction forçant nl2br() à renvoyer des <br> au lieu de <br /> pour respecter le doctype
//
// Utilisation: nl2br_fixed($string);

function nl2br_fixed($contenu)
{
  return preg_replace("/\r\n|\n|\r/", "<br>", $contenu);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction inverse de nl2br (transforme les line breaks en retours ligne)
//
// Utilisation: br2ln($string);

function br2ln($contenu)
{
  $contenu = str_replace('<br>',"\n",$contenu);
  $contenu = str_replace('<br/>',"\n",$contenu);
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
// Fonction générant un surnom aléatoire pour un unvité
//
// Utilisation: surnom_mignon();

function surnom_mignon()
{
  // Liste de mots (les adjectif1 doivent prendre un espace s'ils ne se collent pas au nom)
  $adjectif1 = array("Petit ", "Gros ", "Sale ", "Grand ", "Bel ", "Doux ", "L'", "Un ", "Cet ", "Ce ", "Premier ", "Gentil ", "Méchant ", "Bout d'", "Le ", "Capitaine ", "Quel ", "Saint ", "Chétif ", "Président ", "Général ", "Dernier ", "L'unique ", "Ex ", "Archi ", "Méga ", "Micro ", "Fort ", "Demi ", "Cadavre de ", "Âme d'", "Fils du ", "Futur ", "Second ");

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
// Utilisation: diff("Mon texte","Nouveau texte",1,1);

function diff($old, $new, $bbcodes=NULL, $table=NULL)
{
  if($table)
    $ret = '<table class="cadre_gris indiv"><tr><td class="cadre_gris align_center gras souligne">Différences entre les versions : En <del>&nbsp;rouge&nbsp;</del> ce qui a été retiré, en <ins>&nbsp;vert&nbsp;</ins> ce qui a été ajouté</td></tr><tr><td class="cadre_gris nobleme_background"><br>';
  else
    $ret = '';
  $diff = diff_raw(preg_split("/[\s]+/", $old), preg_split("/[\s]+/", $new));
  foreach($diff as $k){
    if(is_array($k)){
      if($bbcodes && !$table)
        $ret .= (!empty($k['d'])?"&nbsp;[del]&nbsp;".implode(' ',$k['d'])."&nbsp;[/del]&nbsp;":'').(!empty($k['i'])?"&nbsp;[ins]&nbsp;".implode(' ',$k['i'])."&nbsp;[/ins]&nbsp;":'');
      else
        $ret .= (!empty($k['d'])?"&nbsp;<del>&nbsp;".implode(' ',$k['d'])."&nbsp;</del>&nbsp;":'').(!empty($k['i'])?"&nbsp;<ins>&nbsp;".implode(' ',$k['i'])."&nbsp;</ins>&nbsp;":'');
      }
    else $ret .= $k . ' ';
  }
  if($table)
    $ret .= '<br><br></td></tr></table>';
  return $ret;
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
  if($fichier_ircbot = fopen($chemin.'ircbot.txt', "w+"))
  {
    if(!$canal_irc)
      fwrite($fichier_ircbot, time()." ".substr($message_irc,0,450)."\r\n");
    else
      fwrite($fichier_ircbot, time()." PRIVMSG ".$canal_irc." :".substr($message_irc,0,450)."\r\n");
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