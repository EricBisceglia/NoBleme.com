<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un tableau contenant la liste des pages de l'encyclopédie du web
//
// $lang est la langue à utiliser
//
// Utilisation: nbdb_web_liste_pages_encyclopedie($lang);

function nbdb_web_liste_pages_encyclopedie($lang)
{
  // On spécifie la langue à chercher
  $web_lang = changer_casse($lang, 'min');

  // On va chercher la liste des noms de pages
  $qweb = query(" SELECT  nbdb_web_page.titre_$web_lang AS 'w_titre'
                  FROM    nbdb_web_page ");

  // On les colle dans un tableau
  $liste_pages = array();
  while($dweb = mysqli_fetch_array($qweb))
    array_push($liste_pages, changer_casse(html_entity_decode($dweb['w_titre'], ENT_QUOTES), 'min'));

  // Et on renvoie le tableau
  return $liste_pages;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Renvoie un tableau contenant la liste des pages du dictionnaire du web
//
// $lang est la langue à utiliser
//
// Utilisation: nbdb_web_liste_pages_dictionnaire($lang);

function nbdb_web_liste_pages_dictionnaire($lang)
{
  // On spécifie la langue à chercher
  $web_lang = changer_casse($lang, 'min');

  // On va chercher la liste des noms de pages
  $qweb = query(" SELECT  nbdb_web_definition.titre_$web_lang AS 'w_titre'
                  FROM    nbdb_web_definition ");

  // On les colle dans un tableau
  $liste_pages = array();
  while($dweb = mysqli_fetch_array($qweb))
    array_push($liste_pages, changer_casse(html_entity_decode($dweb['w_titre'], ENT_QUOTES), 'min'));

  // Et on renvoie le tableau
  return $liste_pages;
}