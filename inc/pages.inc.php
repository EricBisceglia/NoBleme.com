<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page retournant un nom de page + url complets à partir du nom court et de l'id de la page
//
// Variables devant être définies pour le bon fonctionnement de la fonction :
// $page_nom  - nom court de la page
// $page_id   - id de la page
// $chemin    - chemin d'include
//
// Optionnel: Si $page_titre == -1, il va aller chercher le titre correspondant à l'id défini par $page_id
//
// Variables renvoyées par la fonction :
// $visite_page - nom long de la page
// $visite_url  - url de la page

if(!isset($page_nom))
{
  // Pas de page? Pas d'infos
  $visite_page = "Page non listée";
  $visite_url  = "";
}
else if(isset($chemin))
{
  // Si l'ID est pas rempli, on le laisse vide
  if(!isset($page_id))
    $page_id = '';

  // On va chercher les informations correspondantes
  $page_nom = postdata($page_nom);
  $page_id  = postdata($page_id);
  $qpages   = query(" SELECT pages.visite_page, pages.visite_url FROM pages WHERE pages.page_nom = '$page_nom' AND pages.page_id = '$page_id' ");

  // On vérifie si c'est listé
  if(!mysqli_num_rows($qpages))
  {
    // Pas de page? Pas d'infos
    $visite_page = "Page non listée";
    $visite_url  = "";
  }
  else
  {
    // On peut aller choper les données
    $dpages = mysqli_fetch_array($qpages);

    // Pour les pages simples, ces infos suffisent
    $visite_page  = $dpages['visite_page'];
    $visite_url   = ($dpages['visite_url'] != '') ? $chemin.$dpages['visite_url'] : '';

    // Page admin -> On affiche pas l'url publiquement
    if($page_nom == 'admin')
      $visite_url = '';
  }

  /**** Maintenant on peut traiter les exceptions ***/

  // IRLs
  if($page_nom == 'irl' && is_numeric($page_id))
  {
    if($page_titre == -1)
    {
      $getpageirl = mysqli_fetch_array(query(" SELECT irl.date FROM irl WHERE id = '$page_id' "));
      $page_titre = 'irl du '.datefr($getpageirl['date']);
    }
    $visite_page  = "Observe l'".$page_titre;
    $visite_url   = $chemin.'pages/nobleme/irl?irl='.$page_id;
  }

  // Devblogs
  if($page_nom == 'devblog' && is_numeric($page_id))
  {
    if($page_titre == -1)
    {
      $getpagedev = mysqli_fetch_array(query(" SELECT titre FROM devblog WHERE id = '$page_id' "));
      $page_titre = destroy_html($getpagedev['titre']);
    }
    if(strlen($page_titre) <= 40)
      $visite_page  = "Lit le ".lcfirst($page_titre);
    else
      $visite_page  = "Lit le ".substr(lcfirst($page_titre),0,37).'...';
    $visite_url     = $chemin.'pages/devblog/blog?id='.$page_id;
  }

  // Profil utilisateur
  if($page_nom == 'user' && is_numeric($page_id))
  {
    if($page_titre == -1)
      $page_titre = getpseudo($page_id);
    $visite_page  = "Regarde le ".lcfirst($page_titre);
    $visite_url     = $chemin.'pages/user/user?id='.$page_id;
  }

  // Miscellanées
  if($page_nom == 'quotes' && is_numeric($page_id))
  {
    $visite_page  = "Se marre devant la miscellanée #".$page_id;
    $visite_url     = $chemin.'pages/irc/quotes?id='.$page_id;
  }
}