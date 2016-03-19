/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                              js/popup.js                                                              **
**                                                                                                                                       **
**             Fonction permettant d'invoquer un popup de largeur fixe, centré dans l'écran, et de hauteur = 100% de l'écran             **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  <a onClick="lienpopup('http://www.nobleme.com/',1000)">                                                                              **
**                                                                                                                                       **
******************************************************************************************************************************************/

function lienpopup(lien,largeur) {

  // Définition du centre de la page
  var centrer = (window.screen.width/2) - ((largeur/2)+10);

  // Puis ouverture de la fenêtre
  var fenetre = window.open("" + lien + "","_blank","status=no,height=" + (screen.height - 120) + ",width=" + largeur + ",left=" + centrer + ",screenX=" + centrer + ",screenY=0,top=0,titlebar=no,statusbar=no,menubar=no,resizable=yes,scrollbars=yes");

  // Et focus sur la fenêtre
  fenetre.focus();

}