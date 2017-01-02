/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                             js/onglets.js                                                             **
**                                                                                                                                       **
**                            Fonction permettant d'avoir des onglets qui s'ouvrent lorsque l'on clique dessus                           **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Paramètres :                                                                                                                         **
**                                                                                                                                       **
**  eventOnglet : L'évènement (généralement le clic) qui a déclenché le script                                                           **
**    nomOnglet : Le nom de l'élément qui sera affiché lorsque le script est délenché (les autres éléments seront masqués)               **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Guide d'utilisation :                                                                                                                **
**                                                                                                                                       **
**  # D'abord on fait les onglets ainsi (stylés avec l'aide de onglets.css) :                                                            **
**  <ul class="onglet">                                                                                                                  **
**    <li><a id="onglet1_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'onglet1')">Premier onglet</a></li>         **
**    <li><a id="onglet2_onglet" class="pointeur bouton_onglet" onclick="ouvrirOnglet(event, 'onglet2')">Second onglet</a></li>          **
**  </ul>                                                                                                                                **
**                                                                                                                                       **
**  # Ensuite, on crée chaque onglet de la façon suivante (toujours avec l'aide de onglets.css) :                                        **
**  <div id="onglet1" class="contenu_onglet">                                                                                            **
**    Contenu de l'onglet                                                                                                                **
**  </div>                                                                                                                               **
**                                                                                                                                       **
**  # Finalement, on ajoute ceci plus loin dans la page pour déterminer quel onglet sera ouvert par défaut                               **
**  <script>                                                                                                                             **
**  document.getElementById("onglet1_onglet").click();                                                                                   **
**  </script>                                                                                                                            **
**                                                                                                                                       **
******************************************************************************************************************************************/

function ouvrirOnglet(eventOnglet, nomOnglet) {

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
  eventOnglet.currentTarget.classList.add('onglet_actif');

  // On vire le flash sur l'onglet s'il y en a un
  document.getElementById(nomOnglet+'_onglet').classList.remove('onglet_blink');

  // Et finalement, on remet à zéro les positions des barres de défilement quand on change d'onglet
  scroll_onglet = document.getElementsByClassName("scroll_onglet");
  for (i = 0; i < scroll_onglet.length; i++) {
    scroll_onglet[i].scrollTop = scroll_onglet[i].scrollHeight;
  }
}