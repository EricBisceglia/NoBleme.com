/******************************************************************************************************************************************
**                                                                                                                                       **
**                                    Fonction permettant de mettre du contenu dans le presse-papiers                                    **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  <div onClick="pressepapiers('du contenu')">                                                                                          **
**                                                                                                                                       **
******************************************************************************************************************************************/

function pressepapiers(contenu)
{
  // On prépare un textarea temporaire, dans lequel on met notre contenu à copier
  var temparea    = document.createElement('textarea');
  temparea.value  = contenu;

  // Pour éviter les éventuels problèmes, on en fait une textarea invisible et non éditable
  temparea.setAttribute('readonly', '');
  temparea.style = {position: 'absolute', left: '-9999px'};

  // On crée la textarea
  document.body.appendChild(temparea);

  // On copie le contenu de la textarea dans le presse-papiers
  temparea.select();
  document.execCommand('copy');

  // Il ne reste plus qu'à supprimer la textarea temporaire
  document.body.removeChild(temparea);
}