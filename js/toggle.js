/******************************************************************************************************************************************
**                                                                                                                                       **
**                                          Change la visibilité d'un objet (visible/invisible)                                          **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**                                                              toggle_row                                                               **
**                                                                                                                                       **
**                                              Change la visibilité d'une ligne de tableau                                              **
**                                                                                                                                       **
**  Paramètres :                                                                                                                         **
**                                                                                                                                       **
**           monobjet : ID de la ligne d'une table dont la visibilité va être togglée                                                    **
**              table : Paramètre optionnel, transforme l'élément en table-row au lieu de block, à utiliser pour les <tr>                **
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**           onClick="toggle_row('monobjet')";                                                                                           **
**                                                                                                                                       **
******************************************************************************************************************************************/

function toggle_row(monobjet,table)
{
  // On récupère le statut de la ligne
  var cssobjet = document.getElementById(monobjet);
  var visobjet = cssobjet.currentStyle ? cssobjet.currentStyle.display : getComputedStyle(cssobjet,null).display;

  // On toggle la visibilité de la ligne
  if(visobjet == 'none')
    cssobjet.style.display = (typeof table === 'undefined') ? 'block' : 'table-row';
  else
    cssobjet.style.display = 'none';
}




/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                             toggle_class                                                              **
**                                                                                                                                       **
**                                     Change la visibilité des éléments ayant une classe spécifique                                     **
**                                                                                                                                       **
**  Paramètres :                                                                                                                         **
**                                                                                                                                       **
**           maclasse : nom de la classe dont la visibilité des éléments va être togglée                                                 **
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**           onClick="toggle_class('maclasse')"                                                                                          **
**                                                                                                                                       **
******************************************************************************************************************************************/

function toggle_class(maclasse)
{
  // On met les éléments de la classe dans un tableau et
  var arrayclass    = document.getElementsByClassName(maclasse);

  // On récupère l'état actuel de visibilité d'un élément de la classe
  var elementtest   = arrayclass[0];
  var visclass      = elementtest.currentStyle ? elementtest.currentStyle.display : getComputedStyle(elementtest,null).display;

  // On définit la nouvelle visibilité
  var newstatusclass = visclass == 'none' ? 'block' : 'none';

  // Reste plus qu'à toggler la visibilité de tous les éléments de la classe
  for(var i = 0 ; i < arrayclass.length ; i++)
    arrayclass[i].style.display = newstatusclass;
}




/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                             toggle_oneway                                                             **
**                                                                                                                                       **
**                                                 Rend un élément visible ou invisible                                                  **
**                                                                                                                                       **
**  Paramètres :                                                                                                                         **
**                                                                                                                                       **
**           monobjet : ID de l'objet dont la visibilité va être togglée                                                                 **
**             oneway : Sens dans lequel on veut faire une action (0 = masquer, 1 = afficher)                                            **
**              table : Paramètre optionnel, transforme l'élément en table-row au lieu de block, à utiliser pour les <tr>                **
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**           onClick="toggle_oneway('monobjet', 1)";                                                                                     **
**                                                                                                                                       **
******************************************************************************************************************************************/

function toggle_oneway(monobjet, oneway, table)
{
  // Si on demande de masquer l'élément
  if(!oneway)
    document.getElementById(monobjet).style.display = 'none';

  // Si on demande d'afficher l'élément
  else
    document.getElementById(monobjet).style.display = (typeof table === 'undefined') ? 'block' : 'table-row';
}