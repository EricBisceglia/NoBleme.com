/******************************************************************************************************************************************
**                                                                                                                                       **
**                            Fonction permettant d'avoir des onglets qui s'ouvrent lorsque l'on clique dessus                           **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Paramètres :                                                                                                                         **
**                                                                                                                                       **
**  eventOnglet     : L'évènement (généralement le clic) qui a déclenché le script                                                       **
**    nomOnglet     : Le nom de l'élément qui sera affiché lorsque le script est délenché (les autres éléments seront masqués)           **
**  elementAGriser  : (optionnel) Grise un élément différent de celui sur lequel on clique                                               **
**                                                                                                                                       **
******************************************************************************************************************************************/

function ouvrirOnglet(eventOnglet, nomOnglet, elementAGriser) {

  // On commence par cacher le contenu de tous les onglets
  contenu_onglet = document.getElementsByClassName("contenu_onglet");
  for (i = 0; i < contenu_onglet.length; i++) {
    contenu_onglet[i].style.display = "none";
  }

  // Ensuite, on supprime tous les boutons d'onglets actifs
  bouton_onglet = document.getElementsByClassName("bouton_onglet");
  for (i = 0; i < bouton_onglet.length; i++) {
    bouton_onglet[i].className = bouton_onglet[i].className.replace(" onglet_actif", "");
  }

  // On affiche le contenu de l'onglet que l'on veut afficher
  document.getElementById(nomOnglet).style.display = "block";

  // On met en évidence le bouton de l'onglet
  if(typeof(elementAGriser) === 'undefined')
    eventOnglet.currentTarget.classList.add('onglet_actif');
  else
    document.getElementById(elementAGriser).classList.add('onglet_actif');

  // On vire le flash sur l'onglet s'il y en a un
  document.getElementById(nomOnglet+'_onglet').classList.remove('onglet_blink');

  // Et finalement, on remet à zéro les positions des barres de défilement quand on change d'onglet
  scroll_onglet = document.getElementsByClassName("scroll_onglet");
  for (i = 0; i < scroll_onglet.length; i++) {
    scroll_onglet[i].scrollTop = scroll_onglet[i].scrollHeight;
  }
}