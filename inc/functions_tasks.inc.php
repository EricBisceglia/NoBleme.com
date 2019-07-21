<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction renvoyant un ordre de priorité à partir d'une valeur entre 0 et 5
// Utilisé pour la liste des tâches
//
// $lang  (optionnel) détermine la langue utilisée
// $style (optionnel) détermine si on veut du style HTML ou non
//
// Utilisation: todo_importance($valeur,1);

function todo_importance($importance, $lang='FR', $style=NULL)
{
  switch($importance)
  {
    case 5:
      $importance_texte = ($lang == 'FR') ? 'Urgent' : 'Emergency';
      if($style)
        $returnme = '<span class="gras souligne">'.$importance_texte.'</span>';
      else
        $returnme = $importance_texte;
    break;

    case 4:
      $importance_texte = ($lang == 'FR') ? 'Important' : 'Important';
      if($style)
        $returnme = '<span class="gras">'.$importance_texte.'</span>';
      else
        $returnme = $importance_texte;
    break;

    case 3:
      $importance_texte = ($lang == 'FR') ? 'À considérer' : 'To consider';
      $returnme = $importance_texte;
    break;

    case 2:
      $importance_texte = ($lang == 'FR') ? "Y'a le temps" : "There's still time";
      $returnme = $importance_texte;
    break;

    case 1:
      $importance_texte = ($lang == 'FR') ? 'Pas pressé' : 'No hurry';
      if($style)
        $returnme = '<span class="italique">'.$importance_texte.'</span>';
      else
        $returnme = $importance_texte;
    break;

    default:
      $importance_texte = ($lang == 'FR') ? 'À faire un jour' : 'Maybe some day';
      if($style)
        $returnme = '<span class="italique">'.$importance_texte.'</span>';
      else
        $returnme = $importance_texte;
  }
  return $returnme;
}