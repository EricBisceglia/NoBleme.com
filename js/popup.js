/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                              js/popup.js                                                              **
**                                                                                                                                       **
**                      Fonction permettant d'invoquer un popup de largeur et de hauteur fixes, centré dans l'écran                      **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  <a onClick="lienpopup('http://www.nobleme.com/',1000,800)">                                                                          **
**                                                                                                                                       **
******************************************************************************************************************************************/

function lienpopup(lien,largeur,hauteur)
{

  // Définition du centre de la page
  var centrer = (window.screen.width/2) - ((largeur/2)+10);
  var centrer2 = (window.screen.height/2) - ((hauteur/2)+50);

  // Puis ouverture de la fenêtre
  var fenetre = window.open("" + lien + "","_blank","status=no,height=" + hauteur + ",width=" + largeur + ",left=" + centrer + ",screenX=" + centrer + ",top=" + centrer2 + ",screenY=" + centrer2 + ",titlebar=no,statusbar=no,menubar=no,resizable=no,scrollbars=yes");

  // Et focus sur la fenêtre
  fenetre.focus();

}