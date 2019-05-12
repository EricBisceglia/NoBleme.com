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