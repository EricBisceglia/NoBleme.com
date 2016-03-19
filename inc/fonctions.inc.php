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
  $ravage = str_replace(":amp:","&",$ravage);
  $ravage = str_replace("<","&#60;",$ravage);
  $ravage = str_replace(">","&#62;",$ravage);
  $ravage = str_replace("\"","&quot;",$ravage);

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