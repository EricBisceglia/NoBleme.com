/******************************************************************************************************************************************
**                                                                                                                                       **
**                                Fonction permettant de sélectionner le contenu d'un élément de la page                                 **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  <pre id="sup" onClick="highlight('sup')">                                                                                            **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**    Note: Sur les vieux browsers et sur les versions modernes de IE, il est impossible de sélectionner plus d'un élément à la fois.    **
**                     select() a beau être plus simple que getSelection().addRange(), c'est aussi très limitatif :(                     **
**                                                                                                                                       **
******************************************************************************************************************************************/

function highlight( element ) {

  // On chope l'élément à sélectionner
  var selectme = document.getElementById(element);

  // Petite ruse pour savoir si on est en quirks
  if (!document.selection)
  {
    // Ce code est pour les browsers normaux
    var selection = document.createRange();
    selection.setStartBefore(selectme);
    selection.setEndAfter(selectme);
    window.getSelection().addRange(selection);
  }
  else
  {
    // Ce code est pour les vieux browsers
    var selection = document.body.createTextRange();
    selection.moveToElementText(selectme);
    selection.select();
  }
}