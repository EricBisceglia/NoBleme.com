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