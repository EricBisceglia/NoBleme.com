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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Défintion de la date du jour en toutes lettres
//
// Exemple d'utilisation:
// echo 'Nous sommes le' . $datefr ;

$datefr = $joursfr[date("w")]." ".date("j")." ".strtolower($moisfr[date("n")])." ".date("Y");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de conversion d'une date mysql vers une date en toutes lettres
//
// Exemple d'utilisation
// $ma_date = datefr($date_a_convertir);

function datefr($date)
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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de conversion d'une date mysql vers une date en toutes lettres, ne renvoie pas de nom de jour
//
// Le second paramètre, optionnel, retire le numéro du jour
//
// Exemple d'utilisation
// $ma_date = jourfr($date_a_convertir,1);

function jourfr($date,$stripday=NULL)
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
                    "Ao&urcirc;t" ,
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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction de conversion d'une date mysql vers une date DD/MM/YY
//
// Exemple d'utilisation
// $ma_date = ddmmyy($date_a_convertir);

function ddmmyy($date)
{
  // Conversion de la date en toutes lettres
  $date_ddmmyy = date(date("d", strtotime($date))."/".date("m", strtotime($date))."/".date("y", strtotime($date)));

  // Renvoi de la valeur
  return $date_ddmmyy;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ancienneté d'une action : Prend un timestamp en paramètre, renvoie de quand date l'action en toutes lettres
//
// Exemple d'utilisation :
// $anciennete = ilya($timestamp);

function ilya($date)
{
  // Calcul de la différence de temps entre la date et aujourd'hui
  $diff = time() - $date;

  // Définition en toutes lettres de la différence de temps
  if($diff < 0)
    $ilya = "Dans le futur";
  else if ($diff == 0)
    $ilya = "En ce moment même";
  else if ($diff == 1)
    $ilya = "Il y a 1 seconde";
  else if ($diff <= 60)
    $ilya = "Il y a ".$diff." secondes";
  else if ($diff <= 120)
    $ilya = "Il y a 1 minute";
  else if ($diff <= 3600)
    $ilya = "Il y a ".floor($diff/60)." minutes";
  else if ($diff <= 7200)
    $ilya = "Il y a 1 heure";
  else if ($diff <= 86400)
    $ilya = "Il y a ".floor($diff/3600)." heures";
  else if ($diff <= 172800)
    $ilya = "Hier";
  else if ($diff <= 259200)
    $ilya = "Avant-hier";
  else if ($diff <= 31536000)
    $ilya = "Il y a ".floor($diff/86400)." jours";
  else if ($diff <= 63072000)
    $ilya = "L'année dernière";
  else if ($diff <= 3153600000)
    $ilya = "Il y a ".floor($diff/31536000)." ans";
  else if ($diff <= 6307200000)
    $ilya = "... le siècle dernier ? ö_O";
  else
    $ilya = "Fixe ton code mon vieux, il est complètement pété";

  // Et on renvoie la phrase
  return $ilya;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Temps à venir avant une action : Prend un timestamp en paramètre, renvoie quand aura lieu l'action en toutes lettres
//
// Exemple d'utilisation :
// $prevision = dans($timestamp);

function dans($date)
{
  // Calcul de la différence de temps entre aujourd'hui et la date
  $diff = $date - time();

  // Définition en toutes lettres de la différence de temps
  if ($diff < 0)
    $dans = "Dans le passé";
  else if ($diff == 0)
    $dans = "En ce moment même";
  else if ($diff == 1)
    $dans = "Dans 1 seconde";
  else if ($diff < 60)
    $dans = "Dans ".$diff." secondes";
  else if ($diff < 120)
    $dans = "Dans 1 minute";
  else if ($diff < 3600)
    $dans = "Dans ".floor($diff/60)." minutes";
  else if ($diff < 7200)
    $dans = "Dans 1 heure";
  else if ($diff < 172800)
    $dans = "Dans ".floor($diff/3600)." heures";
  else if ($diff < 31536000)
    $dans = "Dans ".(floor($diff/86400)+1)." jours";
  else if ($diff < 63072000)
    $dans = "Dans plus d'un an";
  else if ($diff < 3153600000)
    $dans = "Dans ".floor($diff/31536000)." ans";
  else if ($diff < 6307200000)
    $dans = "Le siècle prochain";
  else
    $dans = "Dans très très longtemps";

  // Et on renvoie la phrase
  return $dans;
}