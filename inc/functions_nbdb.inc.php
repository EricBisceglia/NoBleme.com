<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');



/**
 * Removes accentuated latin characters from a string.
 *
 * @param   string $string  The string which is about to lose its accents.
 *
 * @return  string          The string, without its latin accents.
 */

function string_remove_accents($string)
{
  // Simply enough, we prepare two arrays: accents and their non accentuated equivalents
  $accents    = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
  $no_accents = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

  // We then replace any occurence of the first set of characters by its equivalent in the second
  return str_replace($accents, $no_accents, $string);
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un tableau contenant la liste des pages de l'encyclopédie du web
//
// $lang est la langue à utiliser
//
// Utilisation: nbdb_web_liste_pages_encyclopedie($lang);

function nbdb_web_list_pages($lang)
{
  // On spécifie la langue à chercher
  $web_lang = string_change_case($lang, 'lowercase');

  // On va chercher la liste des noms de pages
  $qweb = query(" SELECT  nbdb_web_pages.title_$web_lang AS 'w_titre'
                  FROM    nbdb_web_pages ");

  // On les colle dans un tableau
  $liste_pages = array();
  while($dweb = mysqli_fetch_array($qweb))
    array_push($liste_pages, string_change_case(html_entity_decode($dweb['w_titre'], ENT_QUOTES), 'lowercase'));

  // Et on renvoie le tableau
  return $liste_pages;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un tableau contenant la liste des pages du dictionnaire du web
//
// $lang est la langue à utiliser
//
// Utilisation: nbdb_web_liste_pages_dictionnaire($lang);

function nbdb_web_list_definitions($lang)
{
  // On spécifie la langue à chercher
  $web_lang = string_change_case($lang, 'lowercase');

  // On va chercher la liste des noms de pages
  $qweb = query(" SELECT  nbdb_web_definitions.title_$web_lang AS 'w_titre'
                  FROM    nbdb_web_definitions ");

  // On les colle dans un tableau
  $liste_pages = array();
  while($dweb = mysqli_fetch_array($qweb))
    array_push($liste_pages, string_change_case(html_entity_decode($dweb['w_titre'], ENT_QUOTES), 'lowercase'));

  // Et on renvoie le tableau
  return $liste_pages;
}