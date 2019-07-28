/******************************************************************************************************************************************
**                                                                                                                                       **
**                                      Fonctions permettant les opérations dynamiques en javascript                                     **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**                                                              dynamique()                                                              **
**                                                                                                                                       **
**   Exécute une requête xhr permettant d'aller faire des actions et/ou modifier du contenu sans recharger l'intégralité de la page      **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**          chemin : Le path relatif vers la racine du site                                                                              **
**  page_a_charger : URL de la page qui sera appelée par la requête et qui traitera le postdata                                          **
**   element_cible : ID de l'élément qui sera remplacé par ce que la requête va renvoyer                                                 **
**        postdata : Données qui vont être passées en postdata avec la requête                                                           **
**       noloadbar : Optionnel - Si ce paramètre est rempli, la barre de chargement n'apparaitra pas à la place de l'élément qui charge  **
**          append : Optionnel - Si ce paramètre est rempli, le contenu est ajouté à la fin de l'élément au lieu de le remplacer         **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  dynamique('<?=$chemin?>','maj.php','maj',                                                                                            **
**    'version='+dynamique_prepare("version")                                                                                            **
**   +'&build='+encodeURIComponent('<?=var_php?>')                                                                                       **
**   +'&maj=1');                                                                                                                         **
**                                                                                                                                       **
******************************************************************************************************************************************/

function dynamique(chemin, page_a_charger, element_cible , postdata, noloadbar, append) {

  // Barre de chargement à la place du futur contenu
  if(typeof noloadbar === 'undefined' && typeof append === 'undefined')
    document.getElementById(element_cible).innerHTML = '<div class="align_center intable">Chargement en cours...<br><img src="'+chemin+'img/divers/chargement.gif" alt="Chargement en cours..."></div>';

  // Création de l'objet xhr qui servira à communiquer
  var xhr;
  if(window.XMLHttpRequest)
    xhr = new XMLHttpRequest();
  else if (window.ActiveXObject)
    xhr = new ActiveXObject("Microsoft.XMLHTTP"); // Pour gérer IE8 et plus ancien

  // Envoi de la requête sous forme de postdata
  xhr.open("POST", page_a_charger, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
  xhr.setRequestHeader("XHR", "yup");
  xhr.send(postdata);

  // Attente du retour des données
  if(typeof append === 'undefined')
    xhr.onreadystatechange = retour_donnees;
  else
    xhr.onreadystatechange = append_donnees;

  // Mise à jour des données si tout s'est bien passé
  function retour_donnees()
  {
    if(xhr.readyState === 4)
    {
      if(xhr.status === 200)
      {
        // Si l'user a IE, on reloade tout sans se poser de questions parce que fuck quoi
        if(!document.addEventListener)
          location.reload(false);

        // On met à jour la valeur
        if(typeof append === 'undefined')
          document.getElementById(element_cible).innerHTML = xhr.responseText;
      }
      // Erreur si 404 ou autre erreur http
      else
        document.getElementById(element_cible).innerHTML = "Erreur de chargement du contenu dynamique :(";
    }
  }

  // Append de données si tout se passe bien
  function append_donnees()
  {
    if(xhr.readyState === 4)
    {
      if(xhr.status === 200)
      {
        // Si l'user a IE, on reloade tout sans se poser de questions parce que fuck quoi
        if(!document.addEventListener)
          location.reload(false);

        // On appent l'élément à la fin du div
        var div       = document.createElement("div");
        div.innerHTML = xhr.responseText;
        document.getElementById(element_cible).appendChild(div);
      }
      // Erreur si 404 ou autre erreur http
      else
        document.getElementById(element_cible).innerHTML = "Erreur de chargement du contenu dynamique :(";
    }
  }
}




/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                          dynamique_prepare()                                                          **
**                                                                                                                                       **
**   Prépare un élément pour son passage dans le postdata via la fonction dynamique()                                                    **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  id_element : ID de l'élément qui doit être préparé                                                                                   **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  dynamique_prepare('element');                                                                                                        **
**                                                                                                                                       **
******************************************************************************************************************************************/

function dynamique_prepare(id_element)
{
  // On se contente de renvoyer le contenu traité par encodeURIComponent
  return encodeURIComponent(document.getElementById(id_element).value);
}




/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                      dynamique_validate_input()                                                       **
**                                                                                                                                       **
**   Valide que le contenu d'un formulaire est bien rempli                                                                               **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  id_element : ID de l'élément dont le contenu ne doit pas être vide                                                                   **
**    id_label : Optionnel - ID du label de l'élément, dont l'apparence est changée s'il est vide                                        **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  if(!dynamique_validate_input("id_champ","id_champ_label"))                                                                           **
**    return;                                                                                                                            **
**                                                                                                                                       **
******************************************************************************************************************************************/

function dynamique_validate_input(id_element,id_label)
{
  // Au cas où on aurait déjà invalidé ce label auparavant, on lui rend son apparence normale
  if(typeof(id_label) !== 'undefined')
  {
    document.getElementById(id_label).classList.remove('negatif');
    document.getElementById(id_label).classList.remove('texte_blanc');
  }

  // On vérifie si le champ est vide
  if(document.getElementById(id_element).value == "")
  {
    // S'il est vide, on change le style des labels
    if(typeof(id_label) !== 'undefined')
    {
      document.getElementById(id_label).classList.add('negatif');
      document.getElementById(id_label).classList.add('texte_blanc');
    }

    // Et on renvoie 0 pour signifier l'erreur
    return 0;
  }

  // Si le champ est bien rempli, on renvoie 1
  else
    return 1;
}